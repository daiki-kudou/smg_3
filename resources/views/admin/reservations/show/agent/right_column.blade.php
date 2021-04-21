<div class="col">
  <div class="client_mater">
    <table class="table table-bordered name-table">
      <tr>
        <td colspan="2">
          <div class="d-flex align-items-center justify-content-between">
            <p class="title-icon">
              <i class="far fa-id-card icon-size"></i>仲介会社情報
            </p>
            <p><a class="more_btn" href="">仲介会社詳細工藤さん！リンク</a></p>
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
          {{$reservation->enduser->company}}
        </td>
      </tr>
      <tr>
        <td class="table-active">
          <label for="enduser_address" class=" ">住所</label>
        </td>
        <td>
          {{$reservation->enduser->address}}
        </td>
      </tr>
      <tr>
        <td class="table-active">
          <label for="enduser_tel" class="">連絡先</label>
        </td>
        <td>
          {{$reservation->enduser->tel}}
        </td>
      </tr>
      <tr>
        <td class="table-active">
          <label for="enduser_mail" class=" ">メールアドレス</label>
        </td>
        <td>
          {{$reservation->enduser->email}}
        </td>
      </tr>
      <tr>
        <td class="table-active">
          <label for="enduser_incharge" class="">当日担当者</label>
        </td>
        <td>
          {{$reservation->enduser->person}}
        </td>
      </tr>
      <tr>
        <td class="table-active">
          <label for="" class="">当日連絡先</label>
        </td>
        <td>
          {{$reservation->enduser->mobile}}
        </td>
      </tr>
      <tr>
        <td class="table-active">
          <label for="enduser_attr" class="">利用者属性</label>
        </td>
        <td>
          {{$reservation->enduser->attr}}
        </td>
      </tr>
    </table>
  </div>
  <table class="table table-bordered sale-table">
    <tr>
      <td colspan="2">
        <p class="title-icon">
          <i class="fas fa-yen-sign icon-size"></i>エンドユーザーへの支払い料
        </p>
      </td>
    </tr>
    <tr>
      <td class="table-active">
        <label for="enduser_charge ">支払い料</label>
      </td>
      <td class="d-flex align-items-center">
        {{number_format($reservation->enduser->charge)}}円
      </td>
    </tr>
  </table>
  <table class="table table-bordered note-table">
    <tr>
      <td colspan="2">
        <p class="title-icon">
          <i class="fas fa-envelope icon-size"></i>備考
        </p>
      </td>
    </tr>
    <tr>
      <td>
        <label for="userNote">申し込みフォーム備考</label>
        <div>{{$reservation->user_details}}</div>
      </td>
    </tr>
    <tr>
      <td>
        <label for="adminNote">管理者備考</label>
        <div>{{$reservation->admin_details}}</div>
      </td>
    </tr>
  </table>
</div>