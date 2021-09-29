@extends('layouts.admin.app')
@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>
{{-- <script src="{{ asset('/js/validation.js') }}"></script> --}}


<style>
  #fullOverlay {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(100, 100, 100, .5);
    z-index: 2147483647;
    display: none;
  }

  .frame_spinner {
    max-width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .hide {
    display: none;
  }
</style>

<div class="d-flex justify-content-end">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
      </li>
    </ol>
  </nav>
</div>


<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>

@foreach ($errors->all() as $error)
<div class="alert alert-danger">
  <ul>
    <li>{{$error}}</li>
  </ul>
</div>
@endforeach

{{Form::open(['url' => 'admin/agents_reservations', 'method' => 'POST', 'id'=>'agentReservationCreateForm'])}}
@csrf
<section class="mt-4">
  <div class="row">
    <div class="col">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>予約情報
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">利用日</td>
            <td>
              {{ Form::text('', ReservationHelper::formatDate($master_info['reserve_date']) ,['class'=>'form-control', 'id'=>'datepicker1', 'placeholder'=>'入力してください', 'readonly'] ) }}
              {{ Form::hidden('reserve_date', $master_info['reserve_date'] ,['class'=>'form-control', 'id'=>'datepicker1', 'placeholder'=>'入力してください', 'readonly'] ) }}
              <p class="is-error-reserve_date" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">会場</td>
            <td>
              {{ Form::text('', ReservationHelper::getVenue($master_info['venue_id']) ,['class'=>'form-control', 'placeholder'=>'入力してください','readonly'] ) }}
              {{ Form::hidden('venue_id', $master_info['venue_id'],['class'=>'form-control', 'placeholder'=>'入力してください','readonly'] ) }}
              <p class="is-error-venue_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">料金体系</td>
            <td>
              {{ Form::text('', ReservationHelper::priceSystem($master_info['price_system']) ,['class'=>'form-control', 'placeholder'=>'入力してください','readonly'] ) }}
              {{ Form::hidden('price_system', $master_info['price_system'] ,['class'=>'form-control', 'placeholder'=>'入力してください','readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">入室時間</td>
            <td>
              {{ Form::text('', date('H:i',strtotime($master_info['enter_time'])) ,['class'=>'form-control','readonly'] ) }}
              {{ Form::hidden('enter_time', $master_info['enter_time'] ,['class'=>'form-control','readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">退室時間</td>
            <td>
              <div>
                {{ Form::text('', date('H:i',strtotime($master_info['leave_time'])) ,['class'=>'form-control','readonly'] ) }}
                {{ Form::hidden('leave_time', $master_info['leave_time'] ,['class'=>'form-control','readonly'] ) }}
                <p class="is-error-leave_time" style="color: red"></p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <table class="table table-bordered board-table">
        <tbody>
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="fas fa-clipboard icon-size" aria-hidden="true"></i>案内版
                </p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">案内板</td>
            <td>
              {{ Form::text('', $master_info['board_flag']==1?"あり":"なし" ,['class'=>'form-control','readonly'] ) }}
              {{ Form::hidden('board_flag', $master_info['board_flag'] ,['class'=>'form-control','readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称1</td>
            <td>
              {{ Form::text('event_name1', !empty($master_info['event_name1'])?$master_info['event_name1']:"" ,['class'=>'form-control','readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              {{ Form::text('event_name2', !empty($master_info['event_name2'])?$master_info['event_name2']:"" ,['class'=>'form-control','readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              {{ Form::text('event_owner', !empty($master_info['event_owner'])?$master_info['event_owner']:"" ,['class'=>'form-control','readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント開始時間</td>
            <td>
              <div>
                {{ Form::text('', !empty($master_info['event_start'])?ReservationHelper::formatTime($master_info['event_start']):"" ,['class'=>'form-control','readonly'] ) }}
                {{ Form::hidden('event_start', !empty($master_info['event_start'])?$master_info['event_start']:"" ,['class'=>'form-control','readonly'] ) }}
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント終了時間</td>
            <td>
              {{ Form::text('', !empty($master_info['event_finish'])?ReservationHelper::formatTime($master_info['event_finish']):"" ,['class'=>'form-control','readonly'] ) }}
              {{ Form::hidden('event_finish', !empty($master_info['event_finish'])?$master_info['event_finish']:"" ,['class'=>'form-control','readonly'] ) }}
            </td>
          </tr>
        </tbody>
      </table>


      <div class="equipemnts">
        <table class="table table-bordered">
          <thead class="accordion-ttl">
            <tr>
              <th colspan="2">
                <p class="title-icon fw-bolder active">
                  <i class="fas fa-wrench icon-size" aria-hidden="true"></i>有料備品
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap2">
            @foreach ($venue->getEquipments() as $key=>$equ)
            <tr>
              <td class="table-active">{{$equ->item}}</td>
              <td>
                <div class="d-flex align-items-end">
                  {{ Form::text('equipment_breakdown'.$key, $master_info['equipment_breakdown'.$key],['class'=>'form-control','readonly'] ) }}
                  <span class="ml-1">個</span>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="services">
        <table class="table table-bordered">
          <thead class="accordion-ttl">
            <tr>
              <th colspan="2">
                <p class="title-icon fw-bolder active">
                  <i class="fas fa-hand-holding-heart icon-size" aria-hidden="true"></i>有料サービス
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap2">
            @foreach ($venue->getServices() as $key=>$ser)
            <tr>
              <td class="table-active">{{$ser->item}}</td>
              <td>
                {{ Form::text('', $master_info['services_breakdown'.$key]==1?"あり":"なし",['class'=>'form-control','readonly'] ) }}
                {{ Form::hidden('services_breakdown'.$key, $master_info['services_breakdown'.$key],['class'=>'form-control','readonly'] ) }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      @if ($venue->layout!=0)
      <div class="layouts">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <p class="title-icon">
                  <i class="fas fa-th icon-size fa-fw" aria-hidden="true"></i>レイアウト
                </p>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active">準備</td>
              <td>
                {{ Form::text('layout_prepare_count', $master_info['layout_prepare']==1?"あり":"なし" ,['class'=>'form-control','readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">片付</td>
              <td>
                {{ Form::text('layout_clean_count', $master_info['layout_clean']==1?"あり":"なし" ,['class'=>'form-control','readonly'] ) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif


      @if ($venue->luggage_flag!=0)
      <div class="luggage">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <p class="title-icon">
                  <i class="fas fa-suitcase-rolling icon-size fa-fw" aria-hidden="true"></i>荷物預り
                </p>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active">荷物預かり</td>
              <td>
                {{ Form::text('', (int)$master_info['luggage_flag']===1?"有り":"無し",['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('luggage_flag', $master_info['luggage_flag'],['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">事前に預かる荷物<br>（個数）</td>
              <td>
                {{ Form::text('luggage_count', $master_info['luggage_count'],['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ Form::text('luggage_arrive', $master_info['luggage_arrive'],['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>

            <tr>
              <td class="table-active">事後返送する荷物</td>
              <td>
                {{ Form::text('luggage_return', $master_info['luggage_return'],['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif

      @if ($venue->eat_in_flag!=0)
      <div class="eat_in">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan='2'>
                <p class="title-icon">
                  <i class="fas fa-utensils icon-size fa-fw"></i>室内飲食
                </p>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                {{$master_info['eat_in']==1?"あり":"なし"}}
                {{ Form::hidden('eat_in', $master_info['eat_in']) }}
              </td>
              <td>
                @if ($master_info['eat_in']==1)
                @if ($master_info['eat_in_prepare']==1)
                手配済み
                {{ Form::hidden('eat_in_prepare', $master_info['eat_in_prepare']) }}
                @else
                検討中
                {{ Form::hidden('eat_in_prepare', $master_info['eat_in_prepare']) }}
                @endif
                @endif
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif

    </div>

    <div class="col">
      <table class="table table-bordered name-table">
        <tbody>
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-id-card icon-size" aria-hidden="true"></i>仲介会社情報
                </p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="agent_id" class=" form_required">サービス名称</label>
            </td>
            <td>
              {{ Form::text('', ReservationHelper::getAgentCompany($master_info['agent_id']),['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('agent_id', $master_info['agent_id'],['class'=>'form-control'] ) }}
              <p class="is-error-user_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name">担当者氏名<br></label></td>
            <td>
              {{ Form::text('in_charge', ReservationHelper::getAgentPerson($master_info['agent_id']),['class'=>'form-control', 'readonly'] ) }}
              {{-- 保存用 --}}
              {{ Form::hidden('tel', ReservationHelper::getAgentTel($master_info['agent_id']),['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('email_flag', 0,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered oneday-table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-user-check icon-size" aria-hidden="true"></i>エンドユーザー情報
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_company" class="">エンドユーザー</label>
            </td>
            <td>
              {{ Form::text('enduser_company', $master_info['enduser_company'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_address" class=" ">住所</label>
            </td>
            <td>
              {{ Form::text('enduser_address', $master_info['enduser_address'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_tel" class="">連絡先</label>
            </td>
            <td>
              {{ Form::text('enduser_tel', $master_info['enduser_tel'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_mail" class=" ">メールアドレス</label>
            </td>
            <td>
              {{ Form::text('enduser_mail', $master_info['enduser_mail'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_incharge" class="">当日担当者</label>
            </td>
            <td>
              {{ Form::text('enduser_incharge', $master_info['enduser_incharge'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_mobile" class="">当日連絡先</label>
            </td>
            <td>
              {{ Form::text('enduser_mobile', $master_info['enduser_mobile'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_attr" class="">利用者属性</label>
            </td>
            <td>
              {{ Form::text('enduser_attr', ReservationHelper::getEndUser($master_info['enduser_attr']),['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered sale-table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>エンドユーザーへの支払い料
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">
              <label for="end_user_charge ">支払い料</label>
            </td>
            <td class="d-flex align-items-center">
              {{ Form::text('end_user_charge', $master_info['end_user_charge'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
        </tbody>
      </table>


      @if ($venue->alliance_flag!=0)

      <table class="table table-bordered sale-table" id="user_cost">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>売上原価<span
                  class="annotation">（提携会場を選択した場合、提携会場で設定した原価率が適応されます）</span>
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="cost">原価率</label></td>
            <td class="d-flex align-items-center">
              {{Form::text('cost',$master_info['cost'],['class'=>'form-control sales_percentage','readonly'])}}
              <span class="ml-1">%</span>
              <p class="is-error-cost" style="color: red"></p>
            </td>
          </tr>
        </tbody>
      </table>
      @endif


      <table class="table table-bordered note-table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-envelope icon-size" aria-hidden="true"></i>備考
              </p>
            </td>
          </tr>
          <tr>
            <td>
              <label for="adminNote">管理者備考</label>
              {{ Form::textarea('admin_details', $master_info['admin_details'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="mt-5">
  <div class="bill">
    <div class="bill_head">
      <table class="table">
        <tbody>
          <tr>
            <td>
              <h2 class="text-white">
                請求書No
              </h2>
            </td>
            <td>
              <dl class="ttl_box">
                <dt>合計金額</dt>
                <dd class="total_result">
                  {{number_format($check_info['master_total'])}}
                  円
                </dd>
              </dl>
            </td>
            <td>
              <dl class="ttl_box">
                <dt>支払い期日</dt>
                <dd class="total_result">
                  {{ReservationHelper::formatDate($check_info['pay_limit'])}}
                </dd>
              </dl>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="bill_details">
      <div class="head d-flex">
        <div class="accordion_btn">
          <i class="fas fa-plus bill_icon_size hide" aria-hidden="true"></i>
          <i class="fas fa-minus bill_icon_size" aria-hidden="true"></i>
        </div>
        <div class="billdetails_ttl">
          <h3>
            請求内訳
          </h3>
        </div>
      </div>
      <div class="main">
        <div class="venues billdetails_content">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>
                  <h4 class="billdetails_content_ttl">
                    会場料
                  </h4>
                </td>
              </tr>
            </tbody>
            <tbody class="venue_head">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="venue_main">
              <tr>
                <td>
                  {{ Form::text('venue_breakdown_item[]', $check_info['venue_breakdown_item0'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_cost[]', 0,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count[]', $check_info['venue_breakdown_count0'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_subtotal[]', 0,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              {{-- 保存用 --}}
              {{ Form::hidden('venue_price', 0,['class'=>'form-control', 'readonly'] ) }}
            </tbody>
          </table>
        </div>

        @if(!empty($check_info['equipment_breakdown_item0'])||!empty($check_info['service_breakdown_item'])||!empty($check_info['luggage_count']))
        <div class="equipment billdetails_content">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td colspan="4">
                  <h4 class="billdetails_content_ttl">
                    有料備品・サービス
                  </h4>
                </td>
              </tr>
            </tbody>
            <tbody class="equipment_head">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="equipment_main">
              @foreach ($venue->getEquipments() as $key=>$equ)
              @if (!empty($check_info['equipment_breakdown_item'.$key]))
              <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item[]', $check_info['equipment_breakdown_item'.$key] ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_cost[]', 0,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count[]', $check_info['equipment_breakdown_count'.$key],['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_subtotal[]', 0,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endif
              @endforeach

              @foreach ($venue->getServices() as $key=>$ser)
              @if (!empty($check_info['service_breakdown_item'.$key]))
              <tr>
                <td>
                  {{ Form::text('service_breakdown_item[]', $check_info['service_breakdown_item'.$key],['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('service_breakdown_cost[]', 0,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('service_breakdown_count[]', $check_info['service_breakdown_count'.$key],['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('service_breakdown_subtotal[]', 0,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endif
              @endforeach

              @if (!empty($check_info['luggage_count']))
              <tr>
                <td>
                  {{ Form::text('service_breakdown_item[]', $check_info['luggage_item'] ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('service_breakdown_cost[]', 0,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('service_breakdown_count[]', $check_info['luggage_count'] ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('service_breakdown_subtotal[]', 0,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
        @endif


        @if (!empty($check_info['layout_price']))
        <div class="layout billdetails_content">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>
                  <h4 class="billdetails_content_ttl">
                    レイアウト
                  </h4>
                </td>
              </tr>
            </tbody>
            <tbody class="layout_head">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="layout_main">
              @if ($master_info['layout_prepare']==1)
              <tr>
                <td>
                  {{ Form::text('layout_breakdown_item[]', $check_info['layout_prepare_item'] ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_cost[]', $check_info['layout_prepare_cost'] ,['class'=>'form-control','readonly'] ) }}
                </td>
                </td>
                <td>
                  {{ Form::text('layout_breakdown_count[]', $check_info['layout_prepare_count'] ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_subtotal[]', $check_info['layout_prepare_subtotal'] ,['class'=>'form-control','readonly'] ) }}
                </td>
              </tr>
              @endif
              @if ($master_info['layout_clean']==1)
              <tr>
                <td>
                  {{ Form::text('layout_breakdown_item[]', $check_info['layout_clean_item'] ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_cost[]', $check_info['layout_clean_cost'] ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_count[]', $check_info['layout_clean_count'] ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_subtotal[]', $check_info['layout_clean_subtotal'] ,['class'=>'form-control','readonly'] ) }}
                </td>
              </tr>
              @endif
            </tbody>
            <tbody class="layouts_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('layout_price', $check_info['layout_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif


        @if (array_sum($check_info['others_input_count'])!=0)
        <div class="others billdetails_content">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td colspan="3">
                  <h4 class="billdetails_content_ttl">
                    その他
                  </h4>
                </td>
              </tr>
            </tbody>
            <tbody class="others_head">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="others_main">
              @foreach ($check_info['others_input_count'] as $key=>$item)
              <tr>
                <td>
                  {{ Form::text('others_breakdown_item[]', $check_info['others_input_item'][$key],['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_cost[]', 0,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_count[]', $check_info['others_input_count'][$key],['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_subtotal[]', 0,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif

        <div class="bill_total">
          <table class="table text-right">
            <tbody>
              <tr>
                <td>小計：</td>
                <td>
                  {{ Form::text('master_subtotal',$check_info['master_subtotal'] ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax',$check_info['master_tax'] ,['class'=>'form-control text-right', 'readonly'] ) }}

                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total',$check_info['master_total'] ,['class'=>'form-control text-right', 'readonly'] ) }}

                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <div class="information">
    <div class="information_details">
      <div class="head d-flex">
        <div class="accordion_btn">
          <i class="fas fa-plus bill_icon_size hide" aria-hidden="true"></i>
          <i class="fas fa-minus bill_icon_size" aria-hidden="true"></i>
        </div>
        <div class="billdetails_ttl">
          <h3>
            請求書情報
          </h3>
        </div>
      </div>
      <div class="main">
        <div class="informations billdetails_content pb-3">
          <table class="table">
            <tbody>
              <tr>
                <td>請求日
                  {{ Form::text('bill_created_at', $check_info['bill_created_at'],['class'=>'form-control', 'id'=>'datepicker6', 'readonly'] ) }}

                </td>
                <td>支払期日
                  {{ Form::text('payment_limit', $check_info['pay_limit'],['class'=>'form-control', 'id'=>'datepicker6', 'readonly'] ) }}

                </td>
              </tr>
              <tr>
                <td>
                  請求書宛名
                  {{ Form::text('bill_company', $check_info['pay_company'],['class'=>'form-control', 'readonly'] ) }}

                </td>
                <td>
                  担当者
                  {{ Form::text('bill_person', $check_info['bill_person'],['class'=>'form-control', 'readonly'] ) }}

                </td>
              </tr>
              <tr>
                <td colspan="2">
                  請求書備考
                  {{ Form::textarea('bill_remark', $check_info['bill_remark'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <div class="paid">
    <div class="paid_details">
      <div class="head d-flex">
        <div class="d-flex align-items-center">
          <h3 class="pl-3">
            入金情報
          </h3>
        </div>
      </div>
      <div class="main">
        <div class="paids billdetails_content">
          <table class="table">
            <tbody>
              <tr>
                <td>入金状況
                  {{Form::text('',ReservationHelper::paidStatus($check_info['paid']),['class'=>'form-control','readonly'])}}
                  {{ Form::hidden('paid', $check_info['paid'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  入金日
                  {{ Form::text('pay_day', $check_info['pay_day'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>振込人名{{ Form::text('pay_person', $check_info['pay_person'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>入金額{{ Form::text('payment', $check_info['payment'],['class'=>'form-control', 'readonly'] ) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="container-field d-flex justify-content-center mt-5">
  <a href="{{route('admin.agents_reservations.calculate')}}" class="btn more_btn4_lg d-block mr-5">請求内訳を修正する</a>
  {{Form::submit('予約を登録する', ['class'=>'d-block btn more_btn_lg', 'id'=>'check_submit'])}}
  {{Form::close()}}
</div>

@endsection