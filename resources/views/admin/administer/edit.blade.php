@extends('layouts.admin.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<div class="container-field mt-3">
  <h2 class="mt-3 mb-3">管理者 編集</h2>
  <hr>
</div>


{{ Form::open(['url' => 'admin/administer/'.$auth['id'], 'method'=>'PUT', 'id'=>'admin_update']) }}
@csrf

<section class="section-bg mt-5">
  <table class="table user-profile table-bordered">
    <tbody>
      <tr>
        <th class="form_required w-25">{{Form::label("name","名前")}}</th>
        <td>
          {{Form::text('name',$auth['name'],['id'=>'name','class'=>'form-control'])}}
          <p class="is-error-name" style="color: red"></p>
        </td>
      </tr>
      <tr>
        <th class="form_required">{{Form::label("email","メールアドレス")}}</th>
        <td>
          {{Form::text('email',$auth['email'],['id'=>'email','class'=>'form-control'])}}
          <p class="is-error-email" style="color: red"></p>
        </td>
      </tr>
    </tbody>
  </table>
</section>

　<div class="btn-wrapper mt-5">
  <p class="text-center">
    {{Form::submit('更新する',['id'=>"form_submit",'class'=>'more_btn_lg btn'])}}
  </p>
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