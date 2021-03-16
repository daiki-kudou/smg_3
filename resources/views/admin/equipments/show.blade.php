@extends('layouts.admin.app')

@section('content')
<h1><span class="badge badge-secondary">備品詳細</span></h1>
<div class="form-group">
  {{ Form::label('item', '備品名') }}
  <div>{{$eqipment->item}}</div>
</div>
<div class="form-group">
  {{ Form::label('price', '料金（円）') }}
  <div>{{$eqipment->price}}</div>
</div>
<div class="form-group">
  {{ Form::label('stock', '在庫数（総数）') }}
  <div>{{$eqipment->stock}}</div>
</div>
<div class="form-group">
  {{ Form::label('remark', '備考') }}
  <div>{!! nl2br(e($eqipment->remark)) !!}</div>


</div>

{{ link_to_route('admin.equipments.edit', '編集する', $parameters = $eqipment->id, ['class' => 'btn btn-primary']) }}
{{-- {{ Form::model($venue, ['route' => ['admin.venues.destroy', $venue->id], 'method' => 'delete']) }}
@csrf
{{ Form::submit('削除', ['class' => 'btn btn-danger']) }}
{{ Form::close() }} --}}


@endsection