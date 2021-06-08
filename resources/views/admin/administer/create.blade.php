@extends('layouts.admin.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          工藤さん！！！パンくずお願いします。
          {{-- {{ Breadcrumbs::render(Route::currentRouteName()) }} --}}
        </li>
      </ol>
    </nav>
  </div>

  <h2 class="mt-3 mb-3">管理者 新規登録</h2>
  <hr>
</div>


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

<section class="section-bg mt-5">
  <table class="table user-profile table-bordered">
    <tbody>
      <tr>
        <th class="form_required w-25">{{Form::label("name","名前")}}</th>
        <td>
          {{Form::text('name',"",['id'=>'name','class'=>'form-control'])}}
          <p class="is-error-name" style="color: red"></p>
        </td>
      </tr>
      <tr>
        <th class="form_required w-25">{{Form::label("email","メールアドレス")}}</th>
        <td>
          {{Form::text('email',"",['id'=>'email','class'=>'form-control'])}}
          <p class="is-error-email" style="color: red"></p>
        </td>
      </tr>
      <tr>
        <th class="form_required w-25">{{Form::label("password","パスワード")}}</th>
        <td>
          {{Form::password('password',['id'=>'password','class'=>'form-control'])}}
        <p class="is-error-password" style="color: red"></p>
        </td>
      </tr>
    </tbody>
  </table>
</section>

　<div class="btn-wrapper mt-5">
  <p class="text-center">
    {{Form::submit('保存する',['id'=>"form_submit",'class'=>'more_btn_lg btn'])}}
  </p>
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