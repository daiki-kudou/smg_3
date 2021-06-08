@extends('layouts.admin.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<div class="container-field mt-3">
  {{-- <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
          メールテンプレート管理
        </li>
      </ol>
    </nav>
  </div> --}}
  <h2 class="mt-3 mb-3">メールテンプレート管理</h2>
  <hr>
</div>
<div class="container-field">
  <table class="table table-bordered mt-5 mail_template">
    <thead>
      <tr class="table_row">
        <th width="30%">配信タイミング</th>
        <th>件名</th>
        <th>送付先</th>
        <th class="btn-cell">詳細</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td rowspan="2">会員登録申込</td>
        <td>【管理者通知】SMGアクセア貸し会議室　会員登録について</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminReqLeg')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　会員登録について</td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userReqLeg')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
    </tbody>


    <tbody>
      <tr>
        <td rowspan="2">会員登録完了</td>
        <td>【管理者通知】SMGアクセア貸し会議室　会員登録完了について</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminFinLeg')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　会員登録完了について</td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userFinLeg')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
    </tbody>


    <tbody>
      <tr>
        <td rowspan="2">管理者仮押え完了及びユーザーへ編集権限譲渡</td>
        <td>【管理者通知】SMGアクセア貸し会議室　仮押えについて</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminFinPreRes')}}" class="more_btn"
            target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　仮押えについて</td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userFinPreRes')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
    </tbody>


    <tbody>
      <tr>
        <td rowspan="2">管理者主導仮押えから本予約切り替え（ユーザー承認）</td>
        <td>【管理者通知】SMGアクセア貸し会議室　予約完了のお知らせ</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminPreResToRes')}}" class="more_btn"
            target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　予約完了のお知らせ</td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userPreResToRes')}}" class="more_btn"
            target="_blank">編集</a>
        </td>
      </tr>
    </tbody>


    <tbody>
      <tr>
        <td rowspan="2">管理者ダブルチェック完了、ユーザーへ予約承認依頼送付</td>
        <td>【管理者通知】SMGアクセア貸し会議室　予約承認のお願い</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminFinDblChk')}}" class="more_btn"
            target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　予約承認のお願い</td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userFinDblChk')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
    </tbody>

    <tbody>
      <tr>
        <td rowspan="2">予約内容追加</td>
        <td>【管理者通知】追加の備品・サービス（その他）を受け付けました</td>
        <td>管理者</td>
        <td><a href="" class="more_btn">未　編集</a></td>
      </tr>
      <tr>
        <td>追加の備品・サービス（その他）を受け付けました</td>
        <td>ユーザー</td>
        <td><a href="" class="more_btn">未　編集</a></td>
      </tr>
    </tbody>

    <tbody>
      <tr>
        <td rowspan="2">追加予約受付完了</td>
        <td>【管理者通知】追加の備品・サービス（その他）予約完了のお知らせ</td>
        <td>管理者</td>
        <td>
          <a href="{{url('/admin/maileclipse/templates/edit/adminFinAddRes')}}" class="more_btn">
            編集
          </a>
        </td>
      </tr>
      <tr>
        <td>追加の備品・サービス（その他）予約完了のお知らせ</td>
        <td>ユーザー</td>
        <td>
          <a href="{{url('/admin/maileclipse/templates/edit/userFinAddRes')}}" class="more_btn">
            編集
          </a>
        </td>
      </tr>
    </tbody>

    <tbody>
      <tr>
        <td rowspan="2">Web予約</td>
        <td>【管理者通知】SMGアクセア貸し会議室　予約申込受付のお知らせ</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminReqRes')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　予約申込受付のお知らせ</td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userReqRes')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
    </tbody>


    <tbody>
      <tr>
        <td rowspan="2">Web予約完了</td>
        <td>【管理者通知】SMGアクセア貸し会議室　予約完了のお知らせ</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminFinRes')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　予約完了のお知らせ</td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userFinRes')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
    </tbody>


    <tbody>
      <tr>
        <td rowspan="2">入金完了</td>
        <td>【管理者通知】SMGアクセア貸し会議室　ご入金完了のお知らせ</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminPaid')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　ご入金完了のお知らせ</td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userPaid')}}" class="more_btn" target="_blank">編集</a></td>
      </tr>
    </tbody>


    {{-- <tbody>
      <tr>
        <td rowspan="2">未入金時、催促(5営業日前)</td>
        <td>【管理者通知】SMGアクセア貸し会議室　ご入金のお願い</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminRemindPaid')}}" class="more_btn"
    target="_blank">編集</a>
    </td>
    </tr>
    <tr>
      <td>SMGアクセア貸し会議室　ご入金のお願い</td>
      <td>ユーザー</td>
      <td><a href="{{url('/admin/maileclipse/templates/edit/userRemindPaid')}}" class="more_btn" target="_blank">編集</a>
      </td>
    </tr>
    </tbody> --}}


    {{-- <tbody>
      <tr>
        <td rowspan="2">未入金時、催促(2営業日前)</td>
        <td>【管理者通知】SMGアクセア貸し会議室　ご入金のお願い(お支払いの督促) </td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminRemindPaid2')}}" class="more_btn"
    target="_blank">編集</a>
    </td>
    </tr>
    <tr>
      <td>SMGアクセア貸し会議室　ご入金のお願い(お支払いの督促) </td>
      <td>ユーザー</td>
      <td><a href="{{url('/admin/maileclipse/templates/edit/userRemindPaid2')}}" class="more_btn" target="_blank">編集</a>
      </td>
    </tr>
    </tbody> --}}


    <tbody>
      <tr>
        <td rowspan="2">管理者ダブルチェック完了、ユーザーキャンセル承認送付</td>
        <td>【管理者通知】SMGアクセア貸し会議室　キャンセル承認のお願い</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminCxlChck')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　キャンセル承認のお願い</td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userCxlChck')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
    </tbody>


    {{-- <tbody>
      <tr>
        <td rowspan="2">管理者ダブルチェック完了、ユーザーキャンセル承認送付催促(72時間経過後)</td>
        <td>【管理者通知】SMGアクセア貸し会議室　キャンセル承認のお願い(再送)</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminRemindCxlChck')}}" class="more_btn"
    target="_blank">編集</a></td>
    </tr>
    <tr>
      <td>SMGアクセア貸し会議室　キャンセル承認のお願い(再送)</td>
      <td>ユーザー</td>
      <td><a href="{{url('/admin/maileclipse/templates/edit/userRemindCxlChck')}}" class="more_btn"
          target="_blank">編集</a>
      </td>
    </tr>
    </tbody> --}}


    <tbody>
      <tr>
        <td rowspan="2">キャンセル完了</td>
        <td>【管理者通知】SMGアクセア貸し会議室　キャンセル完了のお知らせ</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminFinCxl')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　キャンセル完了のお知らせ</td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userFinCxl')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
    </tbody>


    <tbody>
      <tr>
        <td rowspan="2">キャンセル料入金確認完了</td>
        <td>【管理者通知】SMGアクセア貸し会議室　ご入金完了のお知らせ</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminCxlPaid')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　ご入金完了のお知らせ</td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userCxlPaid')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
    </tbody>


    {{-- <tbody>
      <tr>
        <td rowspan="2">キャンセル料入金催促(5営業日前)</td>
        <td>【管理者通知】SMGアクセア貸し会議室　ご入金のお願い</td>
        <td>管理者</td>
        <td><a href="" class="more_btn">未　編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　ご入金のお願い</td>
        <td>ユーザー</td>
        <td><a href="" class="more_btn">未　編集</a>
        </td>
      </tr>
    </tbody> --}}


    {{-- <tbody>
      <tr>
        <td rowspan="2">キャンセル料入金催促(2営業日前)</td>
        <td>【管理者通知】SMGアクセア貸し会議室　ご入金のお願い(お支払いの督促)</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminRemindCxl2')}}" class="more_btn"
    target="_blank">編集</a>
    </td>
    </tr>
    <tr>
      <td>SMGアクセア貸し会議室　ご入金のお願い(お支払いの督促)</td>
      <td>ユーザー</td>
      <td><a href="{{url('/admin/maileclipse/templates/edit/userRemindCxl2')}}" class="more_btn" target="_blank">編集</a>
      </td>
    </tr>
    </tbody> --}}


    <tbody>
      <tr>
        <td rowspan="2">退会</td>
        <td>SMGアクセア貸し会議室　退会完了について </td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/admiUnSub')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　退会完了について </td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userUnSub')}}" class="more_btn" target="_blank">編集</a>
        </td>
      </tr>
    </tbody>


    {{-- <tbody>
      <tr>
        <td rowspan="2">パスワード再発行</td>
        <td>【管理者通知】SMGアクセア貸し会議室　パスワードの再発行について</td>
        <td>管理者</td>
        <td><a href="" class="more_btn" target="_blank">編集</a></td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　パスワードの再発行について</td>
        <td>ユーザー</td>
        <td><a href="" class="more_btn" target="_blank">編集</a></td>
      </tr>
    </tbody> --}}


  </table>
</div>
@endsection