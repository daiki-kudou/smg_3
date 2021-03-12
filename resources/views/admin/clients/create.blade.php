@extends('layouts.admin.app')
@section('content')
<!-- <script src="{{ asset('/js/template.js') }}"></script> -->
<!-- <script src="{{ asset('/js/admin/validation.js') }}"></script> -->
<!-- <script src="{{ asset('/js/admin/reservation.js') }}"></script> -->
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<script>
  $(function() {
    $('.discount').on('click', function() {
      $('#condition').toggleClass('checkon');
    })

  })
</script>
<style>
  .checkon {
    display: none;
  }

  .hide {
    display: none !important;
  }
</style>

<div class="container-field">
  <div class="container">
    <div class="float-right">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">ダミーテキスト</li>
        </ol>
      </nav>
    </div>
    <h2 class="mt-3 mb-3">顧客管理　新規作成</h2>
    <hr>


    <section class="section-wrap">
      <div class="row">
        <div class="col">
          {{ Form::open(['url' => 'admin/clients', 'method'=>'POST', 'id'=>'ClientsCreateForm']) }}
          @csrf
          <table class="table table-bordered">
            <thead>
              <tr>
                <td colspan="2">
                  <p class="title-icon">
                    <i class="fas fa-info-circle icon-size"></i>基本情報
                  </p>
                </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="table-active form_required">{{ Form::label('company', '会社・団体名') }}</td>
                <td>{{ Form::text('company', old('company'), ['class' => 'form-control']) }}
                  <p class="is-error-company" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active">{{ Form::label('post_code', '郵便番号') }}</td>
                <td>{{ Form::text('post_code', old('post_code'), [
                                'class' => 'form-control',
                                'onKeyUp'=>"AjaxZip3.zip2addr(this,'','address1','address2');",
                                'autocomplete'=>'off',
                                ]) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">{{ Form::label('address1', '住所1（都道府県）') }}</td>
                <td>{{ Form::text('address1', old('address1'), ['class' => 'form-control']) }}</td>
              </tr>
              <tr>
                <td class="table-active">{{ Form::label('address2', '住所2（市町村番地）') }}</td>
                <td>{{ Form::text('address2', old('address2'), ['class' => 'form-control']) }}</td>
              </tr>
              <tr>
                <td class="table-active">{{ Form::label('address3', '住所3（建物名）') }}</td>
                <td>{{ Form::text('address3', old('address3'), ['class' => 'form-control']) }}</td>
              </tr>
              <!-- <tr>
                <td class="table-active">{{ Form::label('address_remark', '住所備考') }}</td>
                <td>{{ Form::textarea('address_remark', old('address_remark'), ['class' => 'form-control']) }}
                </td>
              </tr> -->
              <tr>
                <td class="table-active">{{ Form::label('url', '会社・団体名URL') }}</td>
                <td>{{ Form::text('url', old('url'), ['class' => 'form-control']) }}
                  <p class="is-error-url" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active">
                  <div class="d-flex align-items-center">
                    <input type="checkbox" class="discount mr-1">
                    {{ Form::label('condition', '割引条件') }}
                  </div>
                </td>
                <td>{{ Form::textarea('condition', '平日% 土日% 3週間前%', ['class' => 'form-control checkon']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">{{ Form::label('attr', '顧客属性') }}</td>
                <td>{{Form::select('attr', [1=>'一般企業', 2=>'上場企業',3=>'近隣利用', 4=>'個人講師', 5=>'MLM', 6=>'その他'])}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col">
          <table class="table table-bordered">
            <thead>
              <tr>
                <td colspan="3">
                  <p class="title-icon">
                    <i class="fas fa-user icon-size"></i>担当者情報
                  </p>
                </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td width="38%" class="table-active form_required">{{ Form::label('first_name', '担当者氏名') }}</td>
                <td>姓：{{ Form::text('first_name', old('first_name'), ['class' => 'form-control']) }}
                  <p class="is-error-first_name" style="color: red"></p>
                </td>
                <td>名：{{ Form::text('last_name', old('last_name'), ['class' => 'form-control']) }}
                  <p class="is-error-last_name" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active form_required">{{ Form::label('first_name_kana', '担当者氏名（フリガナ）') }}</td>
                <td>セイ：{{ Form::text('first_name_kana', old('first_name_kana'), ['class' => 'form-control'])}}
                  <p class="is-error-first_name_kana" style="color: red"></p>
                </td>
                <td>メイ：{{ Form::text('last_name_kana', old('last_name_kana'), ['class' => 'form-control']) }}
                  <p class="is-error-last_name_kana" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active form_required">{{ Form::label('mobile', '携帯番号') }}</td>
                <td colspan="2">{{ Form::text('mobile', old('mobile'), ['class' => 'form-control']) }}
                  <p class="is-error-mobile" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active">{{ Form::label('tel', '固定電話') }}</td>
                <td colspan="2">{{ Form::text('tel', old('tel'), ['class' => 'form-control']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active form_required">{{ Form::label('email', '担当者メールアドレス') }}</td>
                <td colspan="2">{{ Form::text('email', old('email'), ['class' => 'form-control']) }}
                  <p class="is-error-email" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active">{{ Form::label('fax', 'FAX') }}</td>
                <td colspan="2">{{ Form::text('fax', old('fax'), ['class' => 'form-control']) }}</td>
              </tr>

            </tbody>
          </table>

          <table class="table table-bordered">
            <thead>
              <tr>
                <td colspan="3">
                  <p class="title-icon">
                    <i class="fas fa-yen-sign icon-size"></i>支払いデータ
                  </p>
                </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="table-active form_required">{{ Form::label('pay_metdod', '支払方法') }}</td>
                <td>
                  <select name="pay_method" id="pay_method">
                    <option value="1">銀行振込</option>
                    <option value="2">現金</option>
                    <option value="3">クレジットカード</option>
                    <option value="4">スマホ決済</option>
                  </select>
                  <p class="is-error-pay_method" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active form_required">{{ Form::label('pay_limit', '支払期日') }}</td>
                <td>
                  {{Form::select('pay_limit', [1=>'当月末〆当月末CASH', 2=>'当月末〆翌月末CASH',3=>'当月末〆翌々月末CACH',4=>'当月末〆3カ月末CASH'])}}
                  <p class="is-error-pay_limit" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active">{{ Form::label('pay_post_code', '請求書送付先郵便番号') }}</td>
                <td>{{ Form::text('pay_post_code', old('pay_post_code'), [
                                'class' => 'form-control pay_post_code',
                                'onKeyUp'=>"AjaxZip3.zip2addr(this,'','pay_address1','pay_address2');",
                                'autocomplete'=>'off',
                                ]) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">{{ Form::label('pay_address1', '請求書送付先（都道府県）') }}</td>
                <td>{{ Form::text('pay_address1', old('pay_address1'), ['class' => 'form-control pay_address_1']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">{{ Form::label('pay_address2', '請求書送付先（市町村番地）') }}</td>
                <td>{{ Form::text('pay_address2', old('pay_address2'), ['class' => 'form-control pay_address_2']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">{{ Form::label('pay_address3', '請求書送付先（建物名）') }}</td>
                <td>{{ Form::text('pay_address3', old('pay_address3'), ['class' => 'form-control']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">{{ Form::label('pay_remark', '請求書備考') }}</td>
                <td>{{ Form::textarea('pay_remark', old('pay_remark'), ['class' => 'form-control']) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- 備考 ------------------------------------------------------------->
      <div class="row">
        <div class="col">
          <table class="table">
            <thead>
              <tr>
                <td class="table-active caution">{{ Form::label('attention', '注意事項') }}</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="caution">{{ Form::textarea('attention', old('attention'), ['class' => 'form-control']) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col">
          <table class="table table-bordered">
            <thead>
              <tr>
                <td class="table-active">{{ Form::label('remark', '顧客情報詳細') }}</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ Form::textarea('remark', old('remark'), ['class' => 'form-control']) }}</td>
              </tr>
              </thead>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    {{ Form::submit('登録する', ['class' => 'btn more_btn_lg d-block btn-lg mx-auto my-5']) }}
    {{ Form::close() }}
  </div>
  <script>
    // カタカナ
    jQuery.validator.addMethod("katakana", function(value, element) {
      return this.optional(element) || /^([ァ-ヶー]+)$/.test(value);
    }, "<br/>全角カタカナを入力してください");

    // 顧客新規作成 バリデーション
    $(function() {
      $("#ClientsCreateForm").validate({
        rules: {
          company: {
            required: true,
          },
          post_code: {
            maxlength: 7
          },
          url: {
            url: true
          },
          first_name: {
            required: true,
          },
          last_name: {
            required: true,
          },
          first_name_kana: {
            required: true,
            katakana: true
          },
          last_name_kana: {
            required: true,
            katakana: true
          },
          mobile: {
            required: true,
            minlength: 11
          },
          tel: {
            minlength: 10
          },
          email: {
            required: true,
            email: true
          },
          pay_metdod: {
            required: true,
          },
          pay_limit: {
            required: true,
          },
          pay_post_code: {
            maxlength: 7
          },
        },
        messages: {
          company: {
            required: "※必須項目です",
          },
          post_code: {
            required: "※必須項目です",
            maxlength: '７桁で入力してください'
          },
          url: {
            url: '正しいURLを記入してください(例:https://osaka-conference.com/)'
          },
          first_name: {
            required: "※必須項目です",
          },
          last_name: {
            required: "※必須項目です",
          },
          first_name_kana: {
            required: "※必須項目です",
            katakana: "※カタカナで入力してください",
          },
          last_name_kana: {
            required: "※必須項目です",
            katakana: "※カタカナで入力してください",
          },
          mobile: {
            required: "※必須項目です",
            minlength: '※最低桁数は11です',
          },
          tel: {
            minlength: '※最低桁数は10です',
          },
          email: {
            required: "※必須項目です",
            email: '※Emailの形式で入力してください',
          },
          pay_metdod: {
            required: "※必須項目です",
          },
          pay_limit: {
            required: "※必須項目です",
          },
          pay_post_code: {
            maxlength: 7
          },
        },
        errorPlacement: function(error, element) {
          var name = element.attr('name');
          if (element.attr('name') === 'category[]') {
            error.appendTo($('.is-error-category'));
          } else if (element.attr('name') === name) {
            error.appendTo($('.is-error-' + name));
          }
        },
        errorElement: "span",
        errorClass: "is-error",
        //送信前にLoadingを表示
        submitHandler: function(form) {
          $('.approval').addClass('hide');
          $('.loading').removeClass('hide');
          form.submit();
        }
      });
      $('input').on('blur', function() {
        $(this).valid();
      });
    })


    $(function() {
      function ExceptString($target) {
        $target.numeric({
          negative: false,
        });
        $target.on('change', function() {
          charactersChange($(this));
        })
        charactersChange = function(ele) {
          var val = ele.val();
          var han = val.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s) {
            return String.fromCharCode(s.charCodeAt(0) - 0xFEE0)
          });
          if (val.match(/[Ａ-Ｚａ-ｚ０-９]/g)) {
            $(ele).val(han);
          }
        }
      }
      var post_code = $("input[name^='post_code']");
      ExceptString(post_code);
      var luggage_post_code = $("input[name^='luggage_post_code']");
      var pay_post_code = $("input[name^='pay_post_code']");
      ExceptString(pay_post_code);
      var fax = $("input[name^='fax']");
      ExceptString(fax);
      var mobile = $("input[name^='mobile']");
      ExceptString(mobile);
      var tel = $("input[name^='tel']");
      ExceptString(tel);
    });
  </script>
  @endsection