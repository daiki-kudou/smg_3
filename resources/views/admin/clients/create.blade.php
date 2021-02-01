@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('/js/template.js') }}"></script>

<script>
  $(function() {
    $('.discount').on('click', function() {
      $('#condition').toggleClass('hide');
    })

  })
</script>
<style>
  .hide {
    display: none;
  }
</style>

<div class="container">
  <h2>顧客管理　新規作成</h2>
  <div class="row">
    <div class="col-sm">
      {{ Form::open(['route' => 'admin.clients.store']) }}
      <table class="table">
        <thead>
          <tr>
            <td scope="col"><i class="fas fa-exclamation-circle fa-fw"></i></i>基本情報</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td scope="row">{{ Form::label('company', '会社・団体名') }}</td>
            <td>{{ Form::text('company', old('company'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <td scope="row">{{ Form::label('post_code', '郵便番号') }}</td>
            <td>{{ Form::text('post_code', old('post_code'), [
                                'class' => 'form-control',
                                'onKeyUp'=>"AjaxZip3.zip2addr(this,'','address1','address2');",
                                'autocomplete'=>'off',
                                ]) }}
            </td>
          </tr>
          <tr>
            <td scope="row">{{ Form::label('address1', '住所1（都道府県）') }}</td>
            <td>{{ Form::text('address1', old('address1'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <td scope="row">{{ Form::label('address2', '住所2（市町村番地）') }}</td>
            <td>{{ Form::text('address2', old('address2'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <td scope="row">{{ Form::label('address3', '住所3（建物名）') }}</td>
            <td>{{ Form::text('address3', old('address3'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <td scope="row">{{ Form::label('address_remark', '住所備考') }}</td>
            <td>{{ Form::textarea('address_remark', old('address_remark'), ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <td scope="row">{{ Form::label('url', '会社・団体名URL') }}</td>
            <td>{{ Form::text('url', old('url'), ['class' => 'form-control']) }}</td>

          </tr>
          <tr>
            <td scope="row">{{ Form::label('attr', '顧客属性') }}</td>
            <td>{{Form::select('attr', [1=>'一般企業', 2=>'上場企業',3=>'近隣利用', 4=>'講師・セミナー', 5=>'その他'])}}</td>
          </tr>
          <tr>
            <td scope="row"><input type="checkbox" class="discount">{{ Form::label('condition', '割引条件') }}
            </td>
            <td>{{ Form::textarea('condition', '平日%
土日%
3週間前%', ['class' => 'form-control hide']) }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-sm">
      <table class="table">
        <thead>
          <tr>
            <td scope="col"><i class="fas fa-user fa-fw"></i>担当者情報</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td scope="row">{{ Form::label('first_name', '担当者氏名') }}</td>
            <td>姓：{{ Form::text('first_name', old('first_name'), ['class' => 'form-control']) }}</td>
            <td>名：{{ Form::text('last_name', old('last_name'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <td scope="row">{{ Form::label('first_name_kana', '担当者氏名（ふりがな）') }}</td>
            <td>セイ：{{ Form::text('first_name_kana', old('first_name_kana'), ['class' => 'form-control'])}}
            </td>
            <td>メイ：{{ Form::text('last_name_kana', old('last_name_kana'), ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <td scope="row">{{ Form::label('tel', '電話番号') }}</td>
            <td>{{ Form::text('tel', old('tel'), ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <td scope="row">{{ Form::label('mobile', '携帯番号') }}</td>
            <td>{{ Form::text('mobile', old('mobile'), ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <td scope="row">{{ Form::label('email', '担当者メールアドレス') }}</td>
            <td>{{ Form::text('email', old('email'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <td scope="row">{{ Form::label('fax', 'FAX') }}</td>
            <td>{{ Form::text('fax', old('fax'), ['class' => 'form-control']) }}</td>
          </tr>
          <thead>
            <tr>
              <td scope="col"><i class="fas fa-user fa-fw"></i>支払いデータ</td>
            </tr>
            <tr>
              <td scope="row">{{ Form::label('pay_metdod', '支払方法') }}</td>
              <td>{{Form::select('pay_metdod', [1=>'銀行振込', 2=>'現金',3=>'クレジットカード', 4=>'スマホ決済'])}}</td>
            </tr>
            <tr>
              <td scope="row">{{ Form::label('pay_limit', '支払期日') }}</td>
              <td>{{Form::select('pay_limit', [1=>'3営業日前', 2=>'当月末',3=>'翌月末'])}}</td>
            </tr>
            <tr>
              <td scope="row">{{ Form::label('pay_post_code', '請求書送付先郵便番号') }}</td>
              <td>{{ Form::text('pay_post_code', old('pay_post_code'), [
                                'class' => 'form-control pay_post_code',
                                'onKeyUp'=>"AjaxZip3.zip2addr(this,'','pay_address1','pay_address2');",
                                'autocomplete'=>'off',
                                ]) }}
              </td>
            </tr>
            <tr>
              <td scope="row">{{ Form::label('pay_address1', '請求書送付先（都道府県）') }}</td>
              <td>{{ Form::text('pay_address1', old('pay_address1'), ['class' => 'form-control pay_address_1']) }}
              </td>
            </tr>
            <tr>
              <td scope="row">{{ Form::label('pay_address2', '請求書送付先（市町村番地）') }}</td>
              <td>{{ Form::text('pay_address2', old('pay_address2'), ['class' => 'form-control pay_address_2']) }}
              </td>
            </tr>
            <tr>
              <td scope="row">{{ Form::label('pay_address3', '建物名') }}</td>
              <td>{{ Form::text('pay_address3', old('pay_address3'), ['class' => 'form-control']) }}
              </td>
            </tr>
            <tr>
              <td>{{ Form::label('pay_remark', '請求書備考') }}</td>
              <td>{{ Form::textarea('pay_remark', old('pay_remark'), ['class' => 'form-control']) }}</td>
            </tr>
          </thead>
        </tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-sm">
      <table class="table">
        <thead>
          <tr>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td scope="row">{{ Form::label('attention', '注意事項') }}</td>
            <td>{{ Form::textarea('attention', old('attention'), ['class' => 'form-control']) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-sm">
      <table class="table">
        <thead>
          <tr>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td scope="row">{{ Form::label('remark', '備考') }}</td>
            <td>{{ Form::textarea('remark', old('remark'), ['class' => 'form-control']) }}</td>
          </tr>
          </thead>
        </tbody>
      </table>
    </div>
  </div>
  {{ Form::submit('新規作成', ['class' => 'btn btn-primary btn-block']) }}
  {{ Form::close() }}
</div>
@endsection