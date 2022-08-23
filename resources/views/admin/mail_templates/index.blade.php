@extends('layouts.admin.app')
@section('content')
    <link href="{{ asset('/css/template.css') }}" rel="stylesheet">

    <div class="container-field mt-3">
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
                    <th>【1】-1｜★顧客新規登録（ﾒｰﾙｱﾄﾞﾚｽ仮登録）</th>
                    <td>会員仮登録のお知らせ（SMG貸し会議室）</td>
                    <td>ユーザー</td>
                    <td></td>
                </tr>
                <tr>
                    <th>【1】-2｜★顧客新規登録（登録完了）</th>
                    <td>会員登録完了のお知らせ（SMG貸し会議室）</td>
                    <td>ユーザー</td>
                    <td></td>
                </tr>
                <tr>
                    <th>【1】-3｜■顧客情報・ﾒｰﾙｱﾄﾞﾚｽ変更</th>
                    <td>メールアドレス変更のご確認（SMG貸し会議室）</td>
                    <td>ユーザー</td>
                    <td></td>
                </tr>
                <tr>
                    <th>【1】-4｜■顧客情報・ﾒｰﾙｱﾄﾞﾚｽ変更完了</th>
                    <td>メールアドレス変更完了のお知らせ（SMG貸し会議室）</td>
                    <td>ユーザー</td>
                    <td></td>
                </tr>
                <tr>
                    <th>【1】-5｜■顧客情報・ﾊﾟｽﾜｰﾄﾞ変更</th>
                    <td>パスワード変更のご確認（SMG貸し会議室）</td>
                    <td>ユーザー</td>
                    <td></td>
                </tr>
                <tr>
                    <th>【1】-6｜■顧客情報・ﾊﾟｽﾜｰﾄﾞ変更完了</th>
                    <td>パスワード変更完了のお知らせ（SMG貸し会議室）</td>
                    <td>ユーザー</td>
                    <td></td>
                </tr>
                <tr>
                    <th>【1】-7｜▼顧客情報・退会完了</th>
                    <td>会員退会完了のお知らせ（SMG貸し会議室）</td>
                    <td>ユーザー</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
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
                    <th>【2】-1｜仮押え・承認依頼</th>
                    <td>【仮押え：［仮押ID］】予約申込み手続きのお願い（SMG貸し会議室）</td>
                    <td>ユーザー・管理者</td>
                    <td>
                        <a target="_blank" class="btn more_btn" href="{{ url('/admin/mail_templates/8') }}">
                            詳細
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>【2】-2｜仮押え・取消し</th>
                    <td>【仮押え：［仮押ID］】取消しのお知らせ（SMG貸し会議室）</td>
                    <td>ユーザー・管理者</td>
                    <td>
                        <a target="_blank" class="btn more_btn" href="{{ url('/admin/mail_templates/9') }}">
                            詳細
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
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
                    <th>【3】-1｜予約受付完了</th>
                    <td>【会議室｜[予約情報：カテゴリ]：[予約ID]】予約申込みを受付しました（SMG貸し会議室）</td>
                    <td>ユーザー・管理者</td>
                    <td>
                        <div class="mb-3">
                            <a target="_blank" class="btn more_btn" href="{{ url('/admin/mail_templates/10') }}">
                                詳細
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>【3】-2｜予約・承認依頼（追加請求含）</th>
                    <td>【会議室｜[予約情報：カテゴリ]：[予約ID]】承認手続きのお願い（SMG貸し会議室）</td>
                    <td>ユーザー</td>
                    <td>
                        <div class="mb-3">
                            <a target="_blank" class="btn more_btn" href="{{ url('/admin/mail_templates/11') }}">
                                詳細
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>【3】-3｜予約・予約完了</th>
                    <td>【会議室｜[予約情報：カテゴリ]：[予約ID]】予約完了/お支払のお知らせ（SMG貸し会議室）</td>
                    <td>ユーザー・管理者</td>
                    <td>
                        <div class="mb-3">
                            <a target="_blank" class="btn more_btn" href="{{ url('/admin/mail_templates/12') }}">
                                詳細
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>【3】-4｜予約・予約取消</th>
                    <td>【会議室｜[予約情報：カテゴリ]：[予約ID]】予約申込み取消しのお知らせ（SMG貸し会議室）</td>
                    <td>ユーザー・管理者</td>
                    <td>
                        <a target="_blank" class="btn more_btn" href="{{ url('/admin/mail_templates/13') }}">
                            詳細
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

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
                    <th>【4】-1｜キャンセル・承認依頼</th>
                    <td>【会議室｜キャンセル：[予約ID]】承認手続きのお願い（SMG貸し会議室）</td>
                    <td>ユーザー</td>
                    <td>
                        <a target="_blank" class="btn more_btn" href="{{ url('/admin/mail_templates/14') }}">
                            詳細
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>【4】-2｜キャンセル・キャンセル完了</th>
                    <td>【会議室｜キャンセル：[予約ID]】手続き完了/お支払のお知らせ（SMG貸し会議室）</td>
                    <td>ユーザー・管理者</td>
                    <td>
                        <a target="_blank" class="btn more_btn" href="{{ url('/admin/mail_templates/15') }}">
                            詳細
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
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
                    <th>【5】-1｜入金催促（支払期日の2営業日前）</th>
                    <td>【会議室お支払｜[売上請求情報：カテゴリ]：[予約ID]】期日のお知らせ（SMG貸し会議室）</td>
                    <td>ユーザー</td>
                    <td>
                        <a target="_blank" class="btn more_btn" href="{{ url('/admin/mail_templates/16') }}">
                            詳細
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>【5】-2｜入金督促（支払期日の１営業日後）</th>
                    <td>【会議室お支払｜[売上請求情報：カテゴリ]：[予約ID]】期日超過のお知らせ（SMG貸し会議室）</td>
                    <td>ユーザー・管理者</td>
                    <td>
                        <a target="_blank" class="btn more_btn" href="{{ url('/admin/mail_templates/17') }}">
                            詳細
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>【5】-3｜入金完了</th>
                    <td>【会議室お支払｜[売上請求情報：カテゴリ]：[予約ID]】入金完了のお知らせ（SMG貸し会議室）</td>
                    <td>ユーザー</td>
                    <td>
                        <div class="mb-3">
                            <a target="_blank" class="btn more_btn" href="{{ url('/admin/mail_templates/18') }}">
                                詳細（会場・追加）
                            </a>
                        </div>
                        <div class="mb-3">
                            <a target="_blank" class="btn more_btn" href="{{ url('/admin/mail_templates/19') }}">
                                詳細（キャンセル）
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

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
                    <th>【6】｜利用後のお礼</th>
                    <td>会議室ご利用の御礼（SMG貸し会議室）</td>
                    <td>ユーザー</td>
                    <td>
                        <div class="mb-3">
                            <a target="_blank" class="btn more_btn" href="{{ url('/admin/mail_templates/20') }}">
                                詳細
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
