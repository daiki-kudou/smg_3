@extends('layouts.admin.app')
@section('content')








<table class="table">
  <thead>
    <tr>
      <th>ID</th>
      <th>名前</th>
      <th>メールアドレス</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($admins as $admin)
    <tr>
      <td>{{$admin['id']}}</td>
      <td>{{$admin['name']}}</td>
      <td>{{$admin['email']}}</td>
      <td>
        @if ($admin['id']===$auth['id'])
        <a href="{{route('admin.administer.edit',$admin['id'])}}" class="btn btn-primary">編集</a>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>



















@endsection