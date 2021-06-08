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
  <h2 class="mt-3 mb-3">メールテンプレート（定期実行）管理</h2>
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
    </tbody>

    <tbody>
      <tr>
        <td rowspan="2">管理者が追加請求の予約承認依頼をしてから、72時間後</td>
        <td>【管理者通知】SMGアクセア貸し会議室　追加請求の予約承認のお願い(再送) </td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminRemindCxlChck')}}" class="more_btn"
            target="_blank">編集</a></td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　追加請求の予約承認のお願い(再送) </td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userRemindCxlChck')}}" class="more_btn"
            target="_blank">編集</a>
        </td>
      </tr>
    </tbody>



    <tbody>
      <tr>
        <td rowspan="2">入金期日5営業日前(催促)</td>
        <td>【管理者通知】SMGアクセア貸し会議室　ご入金のお願い </td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminRemindPaid')}}" class="more_btn"
            target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　ご入金のお願い </td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userRemindPaid')}}" class="more_btn"
            target="_blank">編集</a>
        </td>
      </tr>
    </tbody>



    <tbody>
      <tr>
        <td rowspan="2">入金期日2営業日前の13:30に送付(催促)</td>
        <td>【管理者通知】SMGアクセア貸し会議室　ご入金のお願い(お支払いの督促) </td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminRemindPaid2')}}" class="more_btn"
            target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　ご入金のお願い(お支払いの督促) </td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userRemindPaid2')}}" class="more_btn"
            target="_blank">編集</a>
        </td>
      </tr>
    </tbody>





    <tbody>
      <tr>
        <td rowspan="2">追加請求の入金期日5営業日前</td>
        <td>【管理者通知】SMGアクセア貸し会議室　追加請求のご入金のお願い</td>
        <td>管理者</td>
        <td><a href="" class="more_btn">未　編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　追加請求のご入金のお願い</td>
        <td>ユーザー</td>
        <td><a href="" class="more_btn">未　編集</a>
        </td>
      </tr>
    </tbody>




    <tbody>
      <tr>
        <td rowspan="2">追加請求の入金期日2営業日前</td>
        <td>【管理者通知】SMGアクセア貸し会議室　追加請求のご入金のお願い(お支払いの督促) </td>
        <td>管理者</td>
        <td><a href="" class="more_btn">未　編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　追加請求のご入金のお願い(お支払いの督促) </td>
        <td>ユーザー</td>
        <td><a href="" class="more_btn">未　編集</a>
        </td>
      </tr>
    </tbody>



    <tbody>
      <tr>
        <td rowspan="2">管理者がキャンセル承認依頼をしてから、72時間後</td>
        <td>【管理者通知】SMGアクセア貸し会議室　キャンセル承認のお願い(再送)</td>
        <td>管理者</td>
        <td><a href="" class="more_btn">未　編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　キャンセル承認のお願い(再送)</td>
        <td>ユーザー</td>
        <td><a href="" class="more_btn">未　編集</a>
        </td>
      </tr>
    </tbody>





    <tbody>
      <tr>
        <td rowspan="2">管理者が追加請求のキャンセル承認依頼をしてから、72時間後</td>
        <td>【管理者通知】SMGアクセア貸し会議室　追加申込みのキャンセル承認のお願い(再送) </td>
        <td>管理者</td>
        <td><a href="" class="more_btn">未　編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　追加申込みのキャンセル承認のお願い(再送) </td>
        <td>ユーザー</td>
        <td><a href="" class="more_btn">未　編集</a>
        </td>
      </tr>
    </tbody>





    <tbody>
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
    </tbody>


    <tbody>
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
        <td><a href="{{url('/admin/maileclipse/templates/edit/userRemindCxl2')}}" class="more_btn"
            target="_blank">編集</a>
        </td>
      </tr>
    </tbody>



    <tbody>
      <tr>
        <td rowspan="2">追加請求のキャンセル料入金期日5営業日前</td>
        <td>【管理者通知】SMGアクセア貸し会議室　ご入金のお願い</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminRemindCxl2')}}" class="more_btn"
            target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　ご入金のお願い</td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userRemindCxl2')}}" class="more_btn"
            target="_blank">編集</a>
        </td>
      </tr>
    </tbody>

    <tbody>
      <tr>
        <td rowspan="2">追加請求のキャンセル料入金期日2営業日前</td>
        <td>【管理者通知】SMGアクセア貸し会議室　ご入金のお願い(お支払いの督促)</td>
        <td>管理者</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/adminRemindCxl2')}}" class="more_btn"
            target="_blank">編集</a>
        </td>
      </tr>
      <tr>
        <td>SMGアクセア貸し会議室　ご入金のお願い(お支払いの督促)</td>
        <td>ユーザー</td>
        <td><a href="{{url('/admin/maileclipse/templates/edit/userRemindCxl2')}}" class="more_btn"
            target="_blank">編集</a>
        </td>
      </tr>
    </tbody>








  </table>
</div>
@endsection