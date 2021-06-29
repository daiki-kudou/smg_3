<div class="col">
  <div class="customer-table">
    <table class="table table-bordered name-table">
      <tr>
        <td colspan="2">
          <div class="d-flex align-items-center justify-content-between">
            <p class="title-icon {{ClassHelper::addNotMemberClass($reservation)}}">
              <i class="far fa-address-card icon-size"></i>
              顧客情報
            </p>
            <p>
              @if (!$user->trashed())
              <a class="more_btn" target="_blank" rel="noopener"
                href="{{url('admin/clients/'.$reservation->user_id)}}">顧客詳細
              </a>
              @endif
            </p>
          </div>
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="company">会社名・団体名</label></td>
        <td>
          {{$user->company}}
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="name">担当者氏名</label></td>
        <td>
          {{ReservationHelper::getPersonName($user->id)}}
        </td>
      </tr>
      <tr>
        <td class="table-active">メールアドレス</td>
        <td>
          {{$user->email}}
        </td>
      </tr>
      <tr>
        <td class="table-active">携帯番号 </td>
        <td>
          <p class="mobile"> {{$user->mobile}} </p>
        </td>
      </tr>
      <tr>
        <td class="table-active">固定電話 </td>
        <td>
          <p class="tel">{{$user->tel}}</p>
        </td>
      </tr>
      <tr class="caution">
        <td colspan="2">
          <p>注意事項</p>
          <p>
            {{$user->attention}}
          </p>
        </td>
      </tr>
    </table>
    <table class="table table-bordered oneday-table">
      <tr>
        <td colspan="2">
          <p class="title-icon">
            <i class="fas fa-user icon-size"></i>
            当日の連絡できる担当者
          </p>
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="ondayName">氏名</label></td>
        <td>{{$reservation->in_charge}}</td>
      </tr>
      <tr>
        <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
        <td>{{$reservation->tel}}</td>
      </tr>
    </table>
  </div>

  <table class="table table-bordered mail-table">
    <tr>
      <td colspan="2">
        <p class="title-icon">
          <i class="fas fa-envelope icon-size"></i>
          利用後の送信メール
        </p>
      </td>
    </tr>
    <tr>
      <td class="table-active"><label for="sendMail">送信メール</label></td>
      <td>{{$reservation->email_flag==1?'あり':'なし'}}</td>
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
          <i class="fas fa-file-alt icon-size"></i>
          備考
        </p>
      </td>
    </tr>
    <tr>
      <td>
        <p>申し込みフォーム備考</p>
        <p>
          {!! nl2br(e($reservation->user_details??"なし")) !!}
        </p>
      </td>
    </tr>
    <tr>
      <td>
        <p>管理者備考</p>
        <p>{{isset($reservation->admin_details)?$reservation->admin_details:'なし'}}</p>
      </td>
    </tr>
  </table>
</div>