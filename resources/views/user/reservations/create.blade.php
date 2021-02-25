{{Form::open(['url' => 'user/reservations/test', 'method' => 'POST', 'id'=>''])}}
@csrf

<div class="form-group row justify-content-center">
<label class="col-form-label">購入個数</label>
<div class="">

<input type="number" class="inputNumber form-control" value="0" name="test" >
</div>

<label class="col-form-label">個</label>
<div class="col-sm-auto">
{!! Form::submit('カートへ', ['class' => 'btn btn-primary']) !!}
</div>
</div>
{!! Form::close() !!}
