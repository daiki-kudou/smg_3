{{-- @extends('layouts.admin.app')

@section('content')
<h1><span class="badge badge-secondary">備品詳細</span></h1>
<div class="form-group">
  {{ Form::label('item', '有料サービス名') }}
<div>{{$service->item}}</div>
</div>
<div class="form-group">
  {{ Form::label('price', '料金（円）') }}
  <div>{{$service->price}}</div>
</div>
<div class="form-group">
  {{ Form::label('remark', '備考') }}
  <div>{{$service->remark}}</div>
</div>
{{ link_to_route('admin.equipments.edit', '編集する', $parameters = $service->id, ['class' => 'btn btn-primary']) }}
@endsection --}}