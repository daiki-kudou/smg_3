<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesRequest extends FormRequest
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
            'user_id' => ['nullable', 'regex:/^[0-9]+$/i'],
            'search_id' => ['nullable', 'regex:/^[0-9]+$/i'],
            'multiple_id' => ['nullable', 'regex:/^[0-9]+$/i'],
            'sogaku' => ['nullable', 'regex:/^[0-9]+$/i'],
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => '顧客ID',
            'search_id' => '予約ID',
            'multiple_id' => '予約一括ID',
            'sogaku' => '総額',
        ];
    }

    public function messages()
    {
        return [
            'user_id.regex' => ':attributeは半角数字で入力してください。',
            'search_id.regex' => ':attributeは半角数字で入力してください。',
            'multiple_id.regex' => ':attributeは半角数字で入力してください。',
            'sogaku.regex' => ':attributeは半角数字で入力してください。',
        ];
    }
}
