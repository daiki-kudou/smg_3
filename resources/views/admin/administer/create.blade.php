@extends('layouts.admin.app')
@section('content')


@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif



{{ Form::open(['url' => 'admin/administer/', 'method'=>'POST', 'id'=>'admin_create']) }}
@csrf
<div>
  {{Form::label("name","名前")}}
  {{Form::text('name',"",['id'=>'name'])}}
  <p class="is-error-name" style="color: red"></p>
</div>

<div>
  {{Form::label("email","メールアドレス")}}
  {{Form::text('email',"",['id'=>'email'])}}
  <p class="is-error-email" style="color: red"></p>
</div>

<div>
  {{Form::label("password","パスワード")}}
  {{Form::password('password',['id'=>'password'])}}
  <p class="is-error-password" style="color: red"></p>
</div>

<div>
  {{Form::submit('保存する',['id'=>"form_submit"])}}
</div>

{{Form::close()}}


<script>
  $('#form_submit').on('click',function(){
  if(!confirm('保存しますか？')){return false;}
  })

$(function () {
  $("#admin_create").validate({
    rules: {
      name: {required: true,},
      email: {required: true,email: true,},
      password: {required: true,minlength: 8,},
    },
    messages: {
      name: {required: "※必須項目です",},
      email: {required: "※必須項目です",email: "※メール形式で入力してください",},
      password: {required: "※必須項目です",minlength: "※8文字以上で入力してください",},
    },
    errorPlacement: function (error, element) {
      var name = element.attr('name');
      if (element.attr('name') === 'category[]') {
        error.appendTo($('.is-error-category'));
      } else if (element.attr('name') === name) {
        error.appendTo($('.is-error-' + name));
      }
    },
    errorElement: "span",
    errorClass: "is-error",
  });
  $('input').on('blur click input', function () {
    $(this).valid();
  });
})
</script>





@endsection