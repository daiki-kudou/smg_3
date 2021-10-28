@extends('layouts.admin.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<div class="container-field mt-3">
  <h2 class="mt-3 mb-3">管理者一覧</h2>
  <hr>
</div>

<table class="table table table-bordered mt-5">
  <thead>
    <tr>
      <th>ID</th>
      <th>名前</th>
      <th>メールアドレス</th>
      <th width="120"></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($admins as $admin)
    <tr>
      <td>{{ReservationHelper::fixId($admin['id'])}}</td>
      <td>{{$admin['name']}}</td>
      <td>{{$admin['email']}}</td>
      <td class="text-center">
        @if ($admin['id']===$auth['id'])
        <a href="{{route('admin.administer.edit',$admin['id'])}}" class="btn more_btn">編集</a>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>



















@endsection