<div class="col">
  <div class="client_mater">
    <table class="table table-bordered name-table">
      <tr>
        <td colspan="2">
          <div class="d-flex align-items-center justify-content-between">
            <p class="title-icon">
              <i class="far fa-id-card icon-size"></i>仲介会社情報
            </p>
            <p><a class="more_btn" target="_blank" rel="noopener"
                href="{{url('admin/agents/'.$reservation->agent_id)}}">仲介会社詳細</a></p>
          </div>
        </td>
      </tr>
      <tr>
        <td class="table-active">
          <label for="agent_id">サービス名称</label>
        </td>
        <td>
          {{ReservationHelper::getAgentCompany($reservation->agent_id)}}
          <p class="is-error-user_id" style="color: red"></p>
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="name">担当者氏名<br></label></td>
        <td>
          {{ReservationHelper::getAgentPerson($reservation->agent_id)}}
          <p class="selected_person"></p>
        </td>
      </tr>
    </table>
    <table class="table table-bordered oneday-table">
      <tr>
        <td colspan="2">
          <p class="title-icon">
            <i class="fas fa-user-check icon-size"></i>エンドユーザー情報
          </p>
        </td>
      </tr>
      <tr>
        <td class="table-active">
          <label for="enduser_company" class="">エンドユーザー</label>
        </td>
        <td>
          {{optional($reservation->enduser)->company}}
        </td>
      </tr>
      <tr>
        <td class="table-active">
          <label for="enduser_address" class=" ">住所</label>
        </td>
        <td>
          {{optional($reservation->enduser)->address}}
        </td>
      </tr>
      <tr>
        <td class="table-active">
          <label for="enduser_tel" class="">連絡先</label>
        </td>
        <td>
          {{optional($reservation->enduser)->tel}}
        </td>
      </tr>
      <tr>
        <td class="table-active">
          <label for="enduser_mail" class=" ">メールアドレス</label>
        </td>
        <td>
          {{optional($reservation->enduser)->email}}
        </td>
      </tr>
      <tr>
        <td class="table-active">
          <label for="enduser_incharge" class="">当日担当者</label>
        </td>
        <td>
          {{optional($reservation->enduser)->person}}
        </td>
      </tr>
      <tr>
        <td class="table-active">
          <label for="" class="">当日連絡先</label>
        </td>
        <td>
          {{optional($reservation->enduser)->mobile}}
        </td>
      </tr>
      <tr>
        <td class="table-active">
          <label for="enduser_attr" class="">利用者属性</label>
        </td>
        <td>
          {{ReservationHelper::getEndUser(optional($reservation->enduser)->attr)}}
        </td>
      </tr>
    </table>
  </div>
  <table class="table table-bordered sale-table">
    <tr>
      <td colspan="2">
        <p class="title-icon">
          <i class="fas fa-yen-sign icon-size"></i>エンドユーザーからの入金額(レイアウト料金は含まない)
        </p>
      </td>
    </tr>
    <tr>
      <td class="table-active">
        <label for="end_user_charge ">支払い料</label>
      </td>
      <td class="d-flex align-items-center">
        {{number_format(optional($reservation->enduser)->charge)}}円
      </td>
    </tr>
  </table>

  @if ($venue->alliance_flag!=0)
  <table class="table table-bordered sale-table">
    <tr>
      <td colspan="2">
        <p class="title-icon">
          <i class="fas fa-yen-sign icon-size"></i>
          売上原価
        </p>
      </td>
    </tr>
    <tr>
      <td class="table-active"><label for="sale">原価率</label></td>
      <td>{{$reservation->cost==0?'':$reservation->cost}}%</td>
    </tr>
  </table>
  @endif

  <table class="table table-bordered note-table">
    <tr>
      <td colspan="2">
        <p class="title-icon">
          <i class="fas fa-file-alt icon-size"></i>備考
        </p>
      </td>
    </tr>
    <tr>
      <td>
        <label for="adminNote">管理者備考</label>
        <div>
          {!! nl2br(e($reservation->admin_details??"なし")) !!}
        </div>
      </td>
    </tr>
  </table>
</div>