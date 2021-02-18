@extends('layouts.admin.app')

@section('content')

<script src="{{ asset('/js/template.js') }}"></script>
<script>
  $(function() {
    $('.search_address1').on('change', function() {
      // console.log($('.search_address1').parent().next().find('input'));
      var post_code = $('.search_address1').val();
      var adr1 = $('.search_address2').val();
      var adr2 = $('.search_address3').val();
      $('.search_address1').parent().next().find('input').val(post_code);
      $('.search_address2').parent().next().find('input').val(adr1);
      $('.search_address3').parent().next().find('input').val(adr2);
    })
    $('.search_address2').on('change', function() {
      var adr1 = $('.search_address2').val();
      $('.search_address2').parent().next().find('input').val(adr1);
    })
    $('.search_address3').on('change', function() {
      var adr2 = $('.search_address3').val();
      $('.search_address3').parent().next().find('input').val(adr2);
    })
  })
</script>
<style>
  .error {
    color: red;
  }
</style>
<div class="container mb-5">
  <h1><span class="badge badge-secondary">仲介会社　新規登録</span></h1>
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  {{ Form::open(['url' => 'admin/agents', 'method'=>'POST', 'id'=>'agents_create_form']) }}
  @csrf
  <div class="row">
    <div class="col-sm">
      <table class="table">
        <thead>
          <tr>
            <th scope="col"><i class="fas fa-exclamation-circle fa-fw"></i></i>基本情報</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">{{ Form::label('name', '会社・団体名') }}</th>
            <td>{{ Form::text('name', old('name'), ['class' => 'form-control', 'id'=>'name']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('post_code', '郵便番号') }}</th>
            <td><input class="search_address1 form-control" type="text" name="zip01" maxlength="8"
                onKeyUp="AjaxZip3.zip2addr(this,'','pref01','addr01');"></td>
            <td class="">{{ Form::hidden('post_code', old('post_code'), ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address1', '住所1（都道府県）') }}</th>
            <td><input class="search_address2 form-control" type="text" name="pref01"></td>
            <td>{{ Form::hidden('address1', old('address1'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address2', '住所2（市町村番地）') }}</th>
            <td><input class="search_address3 form-control" type="text" name="addr01"></td>
            <td>{{ Form::hidden('address2', old('address2'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address3', '住所3（建物名）') }}</th>
            <td>{{ Form::text('address3', old('address3'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address_remark', '住所備考') }}</th>
            <td>{{ Form::textarea('address_remark', old('address_remark'), ['class' => 'form-control'])}}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('url', '会社・団体名URL') }}</th>
            <td>{{ Form::text('url', old('url'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('attr', '顧客属性') }}</th>
            <td>{{Form::select('attr', ['ネットワーク'=>'ネットワーカー', '個人事業主'=>'個人事業主','宗教団体'=>'宗教団体'])}}</td>

          </tr>
          <tr>
            <th scope="row">{{ Form::label('remark', '備考') }}</th>
            <td>{{ Form::textarea('remark', old('remark'), ['class' => 'form-control']) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-sm">
      <table class="table">
        <thead>
          <tr>
            <th scope="col"><i class="fas fa-user fa-fw"></i>担当者情報</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">{{ Form::label('person_firstname', '担当者氏名') }}</th>
            <td>
              姓{{ Form::text('person_firstname', old('person_firstname'), ['class' => 'form-control']) }}
            </td>
            <td>
              名{{ Form::text('person_lastname', old('person_lastname'), ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('firstname_kana', '担当者氏名（ふりがな）') }}</th>
            <td>セイ{{ Form::text('firstname_kana', old('firstname_kana'), ['class' => 'form-control']) }}
            </td>
            <td>メイ{{ Form::text('lastname_kana', old('lastname_kana'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('firstname_kana', '携帯電話') }}</th>
            <td>{{ Form::text('person_mobile', old('person_mobile'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('person_tel', '固定電話') }}</th>
            <td>{{ Form::text('person_tel', old('person_tel'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('fax', 'FAX') }}</th>
            <td>{{ Form::text('fax', old('fax'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('email', '担当者メールアドレス') }}</th>
            <td>{{ Form::text('email', old('email'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row"><i class="fas fa-user fa-fw"></i>支払いデータ</th>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('cost', '支払割合（原価）') }}</th>
            <td>{{ Form::number('cost', old('cost'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('payment_limit', '締日') }}</th>
            <td>
              <select name="payment_limit" id="payment_limit">
                <option value="1">当月末</option>
                <option value="2">翌月末</option>
                <option value="3">翌々月末</option>
              </select>
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('payment_day', '支払日') }}</th>
            <td>{{ Form::number('payment_day', old('payment_day'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('payment_remark', '備考') }}</th>
            <td>{{ Form::number('payment_remark', old('payment_remark'), ['class' => 'form-control']) }}</td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>
  <div class="container">
    <div class="mx-auto" style="width: 200px;">
      {{ Form::submit('登録', ['class' => 'btn btn-primary']) }}
      {{ Form::close() }}
    </div>
  </div>
</div>
@endsection