@extends('layouts.admin.app')
@section('content')





{{ Form::open(['url' => 'admin/administer/'.$auth['id'], 'method'=>'PUT', 'id'=>'admin_update']) }}
@csrf

<div>
  {{Form::label("name","名前")}}
  {{Form::text('name',$auth['name'],['id'=>'name'])}}
  <p class="is-error-name" style="color: red"></p>
</div>

<div>
  {{Form::label("email","メールアドレス")}}
  {{Form::text('email',$auth['email'],['id'=>'email'])}}
  <p class="is-error-email" style="color: red"></p>
</div>

<div>
  {{Form::submit('更新する',['id'=>"form_submit"])}}
</div>

{{Form::close()}}






<script>
  $('#form_submit').on('click',function(){
  if(!confirm('更新しますか？')){return false;}
  })

$(function () {
  $("#admin_update").validate({
    rules: {
      name: {required: true,},
      email: {required: true,email: true,},
    },
    messages: {
      name: {required: "※必須項目です",},
      email: {required: "※必須項目です",email: "※メール形式で入力してください",},
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