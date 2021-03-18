@extends('layouts.admin.app')

@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<div class="container-field">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          {{ Breadcrumbs::render(Route::currentRouteName(),$agent->id) }}
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">仲介会社　詳細</h2>
  <hr>
</div>

<section class="mt-5">
  <div class="text-right mb-2">
    {{ link_to_route('admin.agents.edit', '編集する', $parameters = $agent->id, ['class' => 'btn more_btn']) }}
  </div>

  <div class="row">
    <!-- 左側の項目 ---------------------------------------------------->
    <div class="col">
      <table class="table table-bordered agent_table">
        <thead>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-exclamation-circle icon-size" aria-hidden="true"></i>基本情報
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="table-active"><label for="name">サービス名称</label></th>
            <td>{{ $agent->name }}</td>
          </tr>
          <tr>
            <th class="table-active"><label for="company">運営会社</label></th>
            <td>{{ $agent->company }}</td>
          </tr>
          <tr>
            <th class="table-active"><label for="post_code">郵便番号</label></th>
            <td>{{ $agent->post_code }}</td>
          </tr>
          <tr>
            <th class="table-active"><label for="address1">住所1（都道府県）</label></th>
            <td>{{ $agent->address1 }}</td>
          </tr>
          <tr>
            <th class="table-active"><label for="address2">住所2（市町村番地）</label></th>
            <td>{{ $agent->address2 }}</td>
          </tr>
          <tr>
            <th class="table-active"><label for="address3">住所3（建物名）</label></th>
            <td>{{ $agent->address3 }}</td>
          </tr>
          <tr>
            <td class="table-active"><label for="tel">電話番号</label></td>
            <td>{{ $agent->person_tel }}</td>
          </tr>
          <tr>
            <td class="table-active"><label for="fax">FAX</label></td>
            <td>{{ $agent->fax}}</td>
          </tr>
          <tr>
            <td class="table-active"><label for="person_firstname">担当者氏名</label></td>
            <td>{{ $agent->id }}</td>
          </tr>
          <tr>
            <td class="table-active"><label for="firstname_kana">担当者氏名（フリガナ）</label></td>
            <td>{{ $agent->id }}</td>
          </tr>
          <tr>
            <td class="table-active"><label for="person_tel">担当者TEL</label></td>
            <td>{{ $agent->person_mobile }}</td>
          </tr>
          <tr>
            <td class="table-active"><label for="email">担当者メールアドレス</label></td>
            <td>{{ $agent->email }}</td>
          </tr>
          <tr>
            <td class="table-active"><label for="remark">備考</label></td>
            <td>
              {!!nl2br(e($agent->last_remark))!!}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- 左側の項目 終わり---------------------------------------------------->


    <!-- 右側の項目 ---------------------------------------------------->
    <div class="col">
      <!-- 担当者情報 ------------------------------------------------------>
      <p class="title-icon">
      </p>
      <table class="table table-bordered agent_table">
        <thead>
          <tr>
            <td colspan="3">
              <p class="title-icon">
                <i class="fas fa-window-restore icon-size" aria-hidden="true"></i>サイト情報
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="table-active"><label for="service_name">サイト名称</label></th>
            <td>{{ $agent->site }}</td>
          </tr>
          <tr>
            <th class="table-active"><label for="service_url">サイトURL</label></th>
            <td>{{ $agent->site_url }}</td>
          </tr>
          <tr>
            <th class="table-active"><label for="login_url">管理URL</label></th>
            <td>{{ $agent->login }}</td>
          </tr>
          <tr>
            <th class="table-active"><label for="login_id">ID</label></th>
            <td>{{ $agent->site_id }}</td>
          </tr>
          <tr>
            <th class="table-active"><label for="password">パスワード</label></th>
            <td>{{ $agent->site_pass }}</td>
          </tr>
          <!-- <tr>
              <th class="table-active"><label for="alliance_remark">提携会場備考</label></th>
              <td>
                {!!nl2br(e($agent->agent_remark))!!}
              </td>
            </tr> -->
          <tr>
            <th class="table-active"><label for="site_remark">備考</label></th>
            <td>
              {!!nl2br(e($agent->site_remark))!!}
            </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered agent_table">
        <thead>
          <tr>
            <td colspan="3">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>取引条件
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="table-active"><label for="cost">仲介手数料</label></th>
            <td>{{ $agent->cost }}%</td>
          </tr>
          <tr>
            <th class="table-active"><label for="deal_details">取引詳細</label></th>
            <td>
              {!!nl2br(e($agent->deal_remark))!!}
            </td>
          </tr>
          <tr>
            <th class="table-active"><label for="cancel">キャンセルポリシー</label></th>
            <td>{{ $agent->cxl }}</td>
          </tr>
          <tr>
            <th class="table-active"><label for="deal_remark">備考</label></th>
            <td>
              {!!nl2br(e($agent->cxl_remark))!!}
            </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered agent_table">
        <thead>
          <tr>
            <td colspan="3">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>決済条件
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="table-active"><label for="close_date">決済条件</label></th>
            <td>{{ ReservationHelper::payTerm($agent->payment_limit) }}
            </td>
          </tr>
          <tr>
            <th class="table-active"><label for="pay_remark">備考</label></th>
            <td>
              {!!nl2br(e($agent->payment_remark))!!}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- 右側の項目　終わり -------------------------------------------------->
  </div>

  <div class="text-right">
    {{ Form::model($agent, ['route' => ['admin.agents.destroy', $agent->id], 'method' => 'delete']) }}
    @csrf
    {{ Form::submit('削除する', ['class' => 'btn more_btn4 del_btn']) }}
    {{ Form::close() }}
  </div>

  <div class="text-center mt-5">
    <p><a class="more_btn_lg" href="{{url('admin/agents')}}">一覧にもどる</a>
    </p>
  </div>
</section>


<script>
  $(function() {
    $('.del_btn').on('click', function() {
      if (!confirm('本当に削除しますか？')) {
        return false;
      }
    })
  })
</script>
@endsection