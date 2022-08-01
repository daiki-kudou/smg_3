@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<div class="container-field">
  <div class="float-right">

    @include('layouts.admin.breadcrumbs',['id'=>$user->id])
  </div>
  <h2 class="mt-3 mb-3">顧客管理 詳細</h2>
  <hr>
</div>

<section class="mt-5">
  <div class="align-items-center d-flex justify-content-between mb-3">
    <div>
      {{-- {{ Form::model($user, ['route' => ['admin.clients.destroy', $user->id], 'method' => 'delete']) }}
      @csrf
      {{Form::hidden("page",$request->page)}}
      {{ Form::submit('削除', ['class' => 'btn more_btn4',"id"=>"delete_btn"]) }}
      {{ Form::close() }} --}}
    </div>
    <div>
      {{ link_to_route('admin.clients.edit', '編集する', $parameters = $user->id, ['class' => 'btn more_btn']) }}
    </div>
  </div>

  <div class="row">
    <!-- 左側の項目 ---------------------------------------------------->
    <div class="col">
      <table class="table table-bordered client_table">
        <thead>
          <tr>
            <td colspan="2">
              <div class="d-flex justify-content-between">
                <p class="title-icon">
                  <i class="fas fa-exclamation-circle icon-size fa-fw"></i>基本情報
                </p>
                <p>{{$user->admin_or_user==1?"管理者登録":"ユーザー登録"}}</p>
              </div>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="table-active">{{ Form::label('id', '顧客ID') }}</th>
            <td>{{ReservationHelper::fixId($user->id)}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('id', '登録日') }}</th>
            <td>{{ReservationHelper::formatDate($user->created_at)}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('company', '会社・団体名') }}</th>
            <td>{{$user->company}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('post_code', '郵便番号') }}</th>
            <td>{{$user->post_code}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address1', '住所1（都道府県）') }}</th>
            <td>{{$user->address1}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address2', '住所2（市町村番地）') }}</th>
            <td>{{$user->address2}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address3', '住所3（建物名）') }}</th>
            <td>{{$user->address3}}</td>
            </td>
          </tr>
          <!-- <tr>
            <th class="table-active">{{ Form::label('address_remark', '住所備考') }}</th>
            <td>{{$user->address_remark}}</td>
          </tr> -->
          <tr>
            <th class="table-active">{{ Form::label('url', '会社・団体名URL') }}</th>
            <td class="word_break">{{$user->url}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('attr', '顧客属性') }}</th>
            <td>
              @if ($user->attr==1)
              一般企業
              @elseif($user->attr==2)
              上場企業
              @elseif($user->attr==3)
              近隣利用
              @elseif($user->attr==4)
              個人講師
              @elseif($user->attr==5)
              MLM
              @elseif($user->attr==6)
              仲介会社
              @elseif($user->attr==7)
              その他
              @endif
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('condition', '割引条件') }}</th>
            <td>{{$user->condition}}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- 左側の項目 終わり---------------------------------------------------->
    <!-- 右側の項目 ---------------------------------------------------->
    <div class="col">
      <!-- 担当者情報 ------------------------------------------------------>
      <table class="table table-bordered client_table">
        <thead>
          <tr>
            <p class="title-icon">
              <td colspan="3"><i class="fas fa-user fa-fw icon-size"></i>担当者情報
            </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="table-active">{{ Form::label('first_name', '担当者氏名') }}</th>
            <td>{{$user->first_name}}{{$user->last_name}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('first_name_kana', '担当者氏名（フリガナ）') }}</th>
            <td>{{$user->first_name_kana}}{{$user->last_name_kana}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('tel', '固定電話') }}</th>
            <td>{{$user->tel}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('mobile', '携帯電話') }}</th>
            <td>{{$user->mobile}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('email', '担当者メールアドレス') }}</th>
            <td>{{$user->email}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('fax', 'FAX') }}</th>
            <td>{{$user->fax}}</td>
          </tr>
        </tbody>
      </table>

      <!-- 支払いデータ ------------------------------------------------>
      <table class="table table-bordered client_table">
        <thead>
          <tr>
            <td colspan="3">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size"></i>支払いデータ
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="table-active">{{ Form::label('pay_method', '支払方法') }}</th>
            <td>
              @if ($user->pay_method==1)
              銀行振込
              @elseif($user->pay_method==2)
              現金
              @elseif($user->pay_method==3)
              クレジットカード
              @elseif($user->pay_method==4)
              スマホ決済
              @endif
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_limit', '支払期日') }}</th>
            <td>
              @if ($user->pay_limit==1)
              当日
              @elseif($user->pay_limit==2)
              3営業日前
              @elseif($user->pay_limit==3)
              当月末締め／当月末支払い
              @elseif($user->pay_limit==4)
              当月末締め／翌月末支払い
              @elseif($user->pay_limit==5)
              当月末締め／翌々月末支払い
              @endif
            </td>
          </tr>
		  <tr>
            <th class="table-active">{{ Form::label('payer', '振込名') }}</th>
            <td>{{$user->payer}}</td>
		  </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_post_code', '請求書送付先郵便番号') }}</th>
            <td>{{$user->pay_post_code}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_address1', '請求書送付先（都道府県）') }}</th>
            <td>{{$user->pay_address1}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_address2', '請求書送付先（市町村番地）') }}</th>
            <td>{{$user->pay_address2}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_address3', '請求書送付先 (建物名)') }}</th>
            <td>{{$user->pay_address3}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_remark', '請求書備考') }}</th>
            <td>
              <p class="remark_scroll">
                {!!nl2br(e($user->pay_remark))!!}
              </p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- 右側の項目　終わり -------------------------------------------------->
  </div>

  <!-- 備考 ----------------------------------------------------------->
  <div class="row">
    <div class="col">
      <table class="table table table-bordered">
        <thead>
          <tr>
            <th class="table-active caution">{{ Form::label('attention', '注意事項') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="caution word_break">
              {!!nl2br(e($user->attention))!!}
            </td>
          </tr>

        </tbody>
      </table>
    </div>
    <div class="col">
      <table class="table table table-bordered">
        <thead>
          <tr>
            <th class="table-active">{{ Form::label('remark', '備考') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="word_break">
              {!!nl2br(e($user->remark))!!}
            </td>
          </tr>
          </thead>
        </tbody>
      </table>
    </div>
  </div>
  <!-- 　備考終わり ----------------------------------------->


  <!-- 利用履歴 ----------------------------------------------------->
  <div class="use_history">
    <hr>

    <ul class="d-flex justify-content-end mt-5">
      <li class="mr-3">
        {{ Form::open(['url' => '/admin/pre_reservations/create', 'method'=>'get', 'id'=>'','autocomplete'=>'off']) }}
        @csrf
        {{Form::hidden('user_id_from_client_show',$user->id)}}
        {{Form::submit('仮押さえをする',['id'=>"form_submit",'class'=>'more_btn3'])}}
        {{Form::close()}}
      </li>
      <li>
        {{ Form::open(['url' => '/admin/reservations/create', 'method'=>'get', 'id'=>'','autocomplete'=>'off']) }}
        @csrf
        {{Form::hidden('user_id_from_client_show',$user->id)}}
        {{Form::submit('予約をする',['id'=>"form_submit",'class'=>'more_btn3'])}}
        {{Form::close()}}
      </li>
    </ul>

    <h4 class="mb-2 mt-4">予約・利用履歴</h4>
    <div class="table-wrap">
      <table class="table table-bordered table-scroll">
        <thead>
          <tr class="table_row">
            <th>予約一括ID</th>
            <th>予約ID</th>
            <th>利用日</th>
            <th>入室</th>
            <th>退室</th>
            <th>利用会場</th>
            <th>会社名団体名</th>
            <th>担当者氏名</th>
            <th>携帯電話</th>
            <th>固定電話</th>
            <th>仲介会社</th>
            <th>エンドユーザー</th>
            <th width="120">売上区分</th>
            <th width="120">予約状況</th>
            <th width="120">詳細</th>
          </tr>
        </thead>
        @foreach ($reservations as $reservation)
        <tbody>
          <tr>
            <td rowspan="{{count($reservation->bills()->get())}}">
              {{$reservation->multiple_reserve_id!=0?$reservation->multiple_reserve_id:""}}</td>
            <td rowspan="{{count($reservation->bills()->get())}}">{{$reservation->id}}</td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              {{ReservationHelper::formatDate($reservation->reserve_date)}}
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}">{{$reservation->enter_time}}</td>
            <td rowspan="{{count($reservation->bills()->get())}}">{{$reservation->leave_time}}</td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              {{ReservationHelper::getVenue($reservation->venue->id)}}
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              @if ($reservation->user_id>0)
              {{$reservation->user->company}}
              @endif
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              @if ($reservation->user_id>0)
              {{ReservationHelper::getPersonName($reservation->user_id)}}
              @endif
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              @if ($reservation->user_id>0)
              {{$reservation->user->mobile}}
              @endif
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              @if ($reservation->user_id>0)
              {{$reservation->user->tel}}
              @endif
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              @if ($reservation->agent_id>0)
              {{ReservationHelper::getAgentCompany($reservation->agent_id)}}
              @endif
            </td>
            <td>
              @if ($reservation->agent_id>0)
              {{optional($reservation->agent->enduser->company)}}
              @endif
            </td>
            <td>会場予約</td>　
            <td>
              {{ReservationHelper::judgeStatus($reservation->bills()->first()->reservation_status)}}
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}"><a
                href="{{ url('/admin/reservations', $reservation->id) }}" class="more_btn">詳細</a></td>
          </tr>
          @for ($i = 0; $i < count($reservation->bills()->get())-1; $i++)
            <tr>
              <td>
                @if ($reservation->bills()->skip($i+1)->first()->category==2)
                追加請求
                @endif
              </td>
            </tr>
            @endfor
        </tbody>
        @endforeach
      </table>
    </div>

    {{ $reservations->links() }}

  </div>

  <div class="text-center">
    <p><a class="more_btn_lg" href="{{url('/admin/clients')}}">一覧にもどる</a>
    </p>
  </div>

</section>

<script>
  // $(function(){
  // $('#delete_btn').on('click',function(){
  //     if(!confirm('削除しますか？')){
  //       return false;
  //     }
  // });
  // });
</script>
@endsection