<?php

namespace App\Http\Requests\Admin\PreReservations\Common;

use Illuminate\Foundation\Http\FormRequest;

class VenuePriceRequiredRequest extends FormRequest
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
    $rules['venue_price'] = 'required';

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
      'venue_price.required' => '会場料は必須です。',
    ];
  }

  protected function getRedirectUrl()
  {
    // return 'リダイレクトさせたいURL';
    return redirect()
      ->action("Admin\PreReservationsController@calculate")
      ->withInput();
  }
}
