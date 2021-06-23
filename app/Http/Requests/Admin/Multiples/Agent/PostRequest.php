<?php

namespace App\Http\Requests\Admin\Multiples\Agent;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    // ここでは認証させない
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    $rules = [];
    $rules['cp_master_enduser_charge'] = 'required';

    return $rules;
  }
  /**
   * 定義済みバリデーションルールのエラーメッセージ取得
   *
   * @return array
   */
  public function messages()
  {
    return [
      'cp_master_enduser_charge.required' => 'コピー機能内エンドユーザーからの入金額は必須です',
    ];
  }
}
