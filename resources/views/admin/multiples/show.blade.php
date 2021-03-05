@extends('layouts.admin.app')

@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<div class="content">
  <div class="container-fluid">
    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">ダミーダミーダミー
            </li>
          </ol>
        </nav>
      </div>
      <h2 class="mt-3 mb-3">一括仮押さえ　詳細</h2>
      <hr>
    </div>

    <!-- 仮押さえ登録--------------------------------------------------------　 -->
    <section class="section-wrap">
      <div class="row">
        <div class="col-12">
          <table class="table ttl_head">
            <tbody>
              <tr>
                <td>
                  <h2 class="text-white">
                    仮押さえ概要
                  </h2>
                </td>
                <td>
                  <dl class="ttl_box">
                    <dt>仮押さえ一括ID:</dt>
                    <dd class="total_result">{{$multiple->id}}</dd>
                  </dl>
                </td>
                <td class="text-right">
                  <a class="more_btn4" href="">削除</a>
                  <a class="more_btn" href="">編集</a>
                </td>
            </tbody>
          </table>
        </div>

        <div class="col-12">
          <table class="table table-bordered customer-table mb-5" style="table-layout: fixed;">
            <tbody>
              <tr>
                <td colspan="4">
                  <div class="d-flex align-items-center justify-content-between">
                    <p class="title-icon">
                      <i class="far fa-address-card icon-size" aria-hidden="true"></i>
                      顧客情報
                    </p>
                  </div>
                </td>
              </tr>
              <tr>
                <th class="table-active" width="25%"><label for="company">会社名・団体名</label></th>
                <td>
                  {{ReservationHelper::getCompany($multiple->pre_reservations()->first()->user_id)}}
                </td>
                <td class="table-active"><label for="name">担当者氏名</label></td>
                <td>
                  {{ReservationHelper::getPersonName($multiple->pre_reservations()->first()->user_id)}}
                </td>
              </tr>
              <tr>
                <td class="table-active" scope="row"><label for="email">担当者メールアドレス</label></td>
                <td>
                  {{ReservationHelper::getPersonEmail($multiple->pre_reservations()->first()->user_id)}}
                </td>
                <td class="table-active" scope="row"><label for="mobile">携帯番号</label></td>
                <td>
                  {{ReservationHelper::getPersonMobile($multiple->pre_reservations()->first()->user_id)}}
                </td>
              </tr>
              <tr>
                <td class="table-active" scope="row"><label for="tel">固定電話</label></td>
                <td>
                  {{ReservationHelper::getPersonTel($multiple->pre_reservations()->first()->user_id)}}
                </td>
              </tr>
            </tbody>
          </table>
          <table class="table table-bordered oneday-customer-table" style="table-layout: fixed;">
            <tbody>
              <tr>
                <td colspan="4">
                  <p class="title-icon">
                    <i class="fas fa-user icon-size" aria-hidden="true"></i>
                    顧客情報(顧客登録がされていない場合)
                  </p>
                </td>
              </tr>
              <tr>
                <td class="table-active" width="25%"><label for="onedayCompany">会社名・団体名</label></td>
                <td>
                  @if ($multiple->pre_reservations()->first()->id==999)
                  {{$multiple->pre_reservations()->first()->unknown_user()->unknown_user_company}}
                  @endif
                </td>
                <td class="table-active"><label for="onedayName">担当者氏名</label></td>
                <td>
                  @if ($multiple->pre_reservations()->first()->id==999)
                  {{$multiple->pre_reservations()->first()->unknown_user()->unknown_user_name}}
                  @endif
                </td>
              </tr>
              <tr>
                <td class="table-active" scope="row"><label for="onedayEmail">担当者メールアドレス</label></td>
                <td>
                  @if ($multiple->pre_reservations()->first()->id==999)
                  {{$multiple->pre_reservations()->first()->unknown_user()->unknown_user_email}}
                  @endif
                </td>
                <td class="table-active" scope="row"><label for="onedayMobile">携帯番号</label></td>
                <td>
                  @if ($multiple->pre_reservations()->first()->id==999)
                  {{$multiple->pre_reservations()->first()->unknown_user()->unknown_user_mobile}}
                  @endif
                </td>
              </tr>
              <tr>
                <td class="table-active" scope="row"><label for="onedayTel">固定電話</label></td>
                <td>
                  @if ($multiple->pre_reservations()->first()->id==999)
                  {{$multiple->pre_reservations()->first()->unknown_user()->unknown_user_tel}}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    <!-- 仮押さえ一括 -->
    <section>
      <table class="table ttl_head">
        <tbody>
          <tr>
            <td>
              <h2 class="text-white">
                仮押さえ内容
              </h2>
            </td>
        </tbody>
      </table>

      <section class="mt-5">
        <p class="mb-2">詳細を入力する場合は、会場ごとに編集をしてください。</p>
        <p class="text-right mb-5"><a href="" class="more_btn3">新しい会場で日程を追加する</a></p>
        <table class="table table-bordered prereserve-table table-scroll text-center">
          <thead>
            <tr class="table_row">
              <th>一括仮押さえID</th>
              <th>作成日</th>
              <th>利用会場</th>
              <th>総件数</th>
              <th>件数</th>
              <th>編集</th>
              <th>日程の追加</th>
            </tr>
          </thead>
          <tbody>
            @for ($i = 0; $i < $venue_count; $i++) @if ($i==0) <tr>
              <td rowspan="{{$venue_count}}">{{$multiple->id}}</td> {{--一括ID--}}
              <td rowspan="{{$venue_count}}">{{ReservationHelper::formatDate($multiple->created_at)}}</td>{{--作成日--}}
              <td>{{ReservationHelper::getVenue($venues[$i]->venue_id)}}</td>{{--利用会場--}}
              <td rowspan="{{$venue_count}}">
                {{$multiple->pre_reservations()->get()->count()}}
              </td>{{--総件数--}}
              <td>
                {{$multiple->pre_reservations()->where('venue_id',$venues[$i]->venue_id)->get()->count()}}
              </td>
              <td><a class="more_btn" href="{{url('admin/multiples/'.$multiple->id.'/edit'.'/'.$venues[$i]->venue_id)}}">編集</a></td>
              <td><a class="more_btn" href="">日程の追加をする</a></td>
              </tr>
              @else
              <tr>
                <td>{{ReservationHelper::getVenue($venues[$i]->venue_id)}}</td>
                <td>
                  {{$multiple->pre_reservations()->where('venue_id',$venues[$i]->venue_id)->get()->count()}}
                </td>
                <td><a class="more_btn" href="{{url('admin/multiples/'.$multiple->id.'/edit'.'/'.$venues[$i]->venue_id)}}">編集</a></td>
                <td><a class="more_btn" href="">日程の追加をする</a></td>
              </tr>
              @endif
              @endfor
          </tbody>
          {{-- <tbody>
            <tr>
              <td>00001</td>
              <td>2020/12/28(月)</td>
              <td class="table_column">
                <p>サンワールドビルビル</p>
                <p>サンワールドビルビル</p>
              </td>
              <td>8</td>
              <td class="table_column">
                <p>3</p>
                <p>5</p>
              </td>
              <td class="table_column">
                <p><a href="" class="more_btn">編集</a></p>
                <p><a href="" class="more_btn">編集</a></p>
              </td>
              <td class="table_column">
                <p><a href="" class="more_btn">日程を追加する</a></p>
                <p><a href="" class="more_btn">日程を追加する</a></p>
              </td>
            </tr>
          </tbody> --}}
        </table>
      </section>
    </section>
  </div>
  <div class="btn_wrapper">
    <p class="text-center"><a class="more_btn_lg" href="">一覧にもどる</a></p>
  </div>
</div>



@endsection