<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationsRequest extends FormRequest
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
            'multiple_id' => ['nullable', 'regex:/^[0-9]+$/i'],
            'search_id' => ['nullable', 'regex:/^[0-9]+$/i'],
        ];
    }

    public function attributes()
    {
        return [
            'multiple_id' => '予約一括ID',
            'search_id' => '予約ID',
        ];
    }

    public function messages()
    {
        return [
            'multiple_id.regex' => ':attributeは半角数字で入力してください。',
            'search_id.regex' => ':attributeは半角数字で入力してください。',
        ];
    }
}
