<?php

namespace App\Http\Requests\Admin\Reservations;

use Illuminate\Foundation\Http\FormRequest;

class ReservationsStore extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'venue_id' => 'required',
      'reserve_date' => 'required',
      'price_system' => 'required',
      'enter_time' => 'required',
      'leave_time' => 'required',
    ];
  }

  /**
   * 定義済みバリデーションルールのエラーメッセージ取得
   *
   * @return array
   */
  public function messages()
  {
    return [
      'venue_id.required' => '会場を選択してください',
      'reserve_date.required' => '利用日を選択してください',
      'price_system.required' => '料金体系を選択してください',
      'enter_time.required' => '入室時間を選択してください',
      'leave_time.required' => '退室時間を選択してください',
    ];
  }
}
