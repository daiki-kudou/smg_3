@extends('layouts.admin.app')

@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">ダミーダミーダミー
            </li>
          </ol>
        </nav>
      </div>
      <h2 class="mt-3 mb-3">一括仮押え　概要</h2>
      <hr>
    </div>

    <section class="mt-5">
    <div class="mb-2"><a class="more_btn4" href="">削除</a></div>

      <table class="table ttl_head mb-0">
        <tbody>
          <tr>
            <td>
              <h3 class="text-white py-2">
                仮押さえ一括ID：{{$multiple->id}}
              </h3>
            </td>
            <td class="text-right">
              <a class="more_btn4" href="">仮押さえ内容を確定する</a>
            </td>
        </tbody>
      </table>

      <div class="border-wrap2 p-4">
        <table class="table table-bordered customer-table mb-5" style="table-layout: fixed;">
          <tbody>
            <tr>
              <td colspan="4">
                <div class="d-flex align-items-center justify-content-between">
                  <p class="title-icon">
                    <i class="far fa-address-card icon-size" aria-hidden="true"></i>
                    仲介会社情報
                  </p>
                  <p>
                    <a class="more_btn" href="">仲介会社情報を変更する</a>
                    {{-- <a href="{{url('admin/multiples/switch/'.$multiple->id)}}" class="more_btn">顧客情報を変更する</a> --}}
                  </p>
                </div>
              </td>
            </tr>
            <tr>
              <th class="table-active" width="25%"><label for="company">会社名・団体名</label></th>
              <td>
                {{ReservationHelper::getAgentCompany($multiple->pre_reservations()->first()->agent_id)}}
              </td>
              <td class="table-active"><label for="name">担当者氏名</label></td>
              <td>
                {{ReservationHelper::getAgentPerson($multiple->pre_reservations()->first()->agent_id)}}
              </td>
            </tr>
            <tr>
              <td class="table-active" scope="row"><label for="email">担当者メールアドレス</label></td>
              <td>
                {{ReservationHelper::getAgentEmail($multiple->pre_reservations()->first()->agent_id)}}
              </td>
              <td class="table-active" scope="row"><label for="mobile">携帯番号</label></td>
              <td>
                {{ReservationHelper::getAgentMobile($multiple->pre_reservations()->first()->agent_id)}}
              </td>
            </tr>
            <tr>
              <td class="table-active" scope="row"><label for="tel">固定電話</label></td>
              <td>
                {{ReservationHelper::getAgentTel($multiple->pre_reservations()->first()->agent_id)}}
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
                  エンドユーザー
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active" width="25%"><label for="onedayCompany">会社名・団体名</label></td>
              <td>
                @if (!empty($multiple->pre_reservations()->first()->pre_enduser->company))
                {{$multiple->pre_reservations()->first()->pre_enduser->company}}
                @endif
              </td>
              <td class="table-active"><label for="onedayName">担当者氏名</label></td>
              <td>
                @if (!empty($multiple->pre_reservations()->first()->pre_enduser->person))
                {{$multiple->pre_reservations()->first()->pre_enduser->person}}
                @endif
              </td>
            </tr>
            <tr>
              <td class="table-active" scope="row"><label for="onedayEmail">担当者メールアドレス</label></td>
              <td>
                @if (!empty($multiple->pre_reservations()->first()->pre_enduser->email))
                {{$multiple->pre_reservations()->first()->pre_enduser->email}}
                @endif
              </td>
              <td class="table-active" scope="row"><label for="onedayMobile">携帯番号</label></td>
              <td>
                @if (!empty($multiple->pre_reservations()->first()->pre_enduser->mobile))
                {{$multiple->pre_reservations()->first()->pre_enduser->mobile}}
                @endif
              </td>
            </tr>
            <tr>
              <td class="table-active" scope="row"><label for="onedayTel">固定電話</label></td>
              <td>
                @if (!empty($multiple->pre_reservations()->first()->pre_enduser->tel))
                {{$multiple->pre_reservations()->first()->pre_enduser->tel}}
                @endif
              </td>
              <td class="table-active" scope="row"><label for="onedayTel">住所</label></td>
              <td>
                @if (!empty($multiple->pre_reservations()->first()->pre_enduser->address))
                {{$multiple->pre_reservations()->first()->pre_enduser->address}}
                @endif
              </td>
            </tr>
            <tr>
              <td class="table-active" scope="row"><label for="onedayTel">属性</label></td>
              <td>
                @if (!empty($multiple->pre_reservations()->first()->pre_enduser->attr))
                {{$multiple->pre_reservations()->first()->pre_enduser->attr}}
                @endif
              </td>
            </tr>
          </tbody>
        </table>
        <hr class="my-5 border_color">
        <div class="mt-5">
          <p class="text-right"><a href="{{url('admin/multiples/agent/'.$multiple->id."/add_venue")}}" class="more_btn3">日程を追加する</a></p>
          <p class="mb-2">詳細を入力する場合は、会場ごとに編集をしてください。</p>
        </div>
        <table class="table table-bordered table-scroll">
          <thead>
            <tr class="table_row">
              <th>一括仮押えID</th>
              <th>作成日</th>
              <th>利用会場</th>
              <th>総件数</th>
              <th>件数</th>
              <th>編集</th>
              <!-- <th>日程の追加</th> -->
            </tr>
          </thead>
          <tbody>
            @for ($i = 0; $i < $venue_count; $i++) @if ($i==0) <tr>
              <td rowspan="{{$venue_count}}">{{$multiple->id}}</td> {{--一括ID--}}
              <td rowspan="{{$venue_count}}">{{ReservationHelper::formatDate($multiple->created_at)}}</td>{{--作成日--}}
              <td>{{ReservationHelper::getVenue($venues[$i]->venue_id)}}</td>{{--利用会場--}}
              <td class="text-center" rowspan="{{$venue_count}}">
                {{$multiple->pre_reservations()->get()->count()}}
              </td>{{--総件数--}}
              <td class="text-center">
                {{$multiple->pre_reservations()->where('venue_id',$venues[$i]->venue_id)->get()->count()}}
              </td>
              <td class="text-center">
                <a class="more_btn"
                  href="{{url('admin/multiples/agent/'.$multiple->id.'/edit'.'/'.$venues[$i]->venue_id)}}">編集</a>
              </td>
              </tr>
              @else
              <tr>
                <td>{{ReservationHelper::getVenue($venues[$i]->venue_id)}}</td>
                <td  class="text-center">
                  {{$multiple->pre_reservations()->where('venue_id',$venues[$i]->venue_id)->get()->count()}}
                </td>
                <td class="text-center">
                  {{-- <a class="more_btn"
                    href="{{url('admin/multiples/'.$multiple->id.'/edit'.'/'.$venues[$i]->venue_id)}}">編集</a> --}}
                  <a class="more_btn"
                    href="{{url('admin/multiples/agent/'.$multiple->id.'/edit'.'/'.$venues[$i]->venue_id)}}">編集</a>
                </td>
              </tr>
              @endif
              @endfor
          </tbody>
        </table>
      </div>
    </section>
  <div class="btn_wrapper">
    <p class="text-center"><a class="more_btn_lg" href="{{url('admin/multiples')}}">一覧にもどる</a></p>
  </div>



@endsection