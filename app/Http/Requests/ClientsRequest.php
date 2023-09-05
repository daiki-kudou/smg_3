<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientsRequest extends FormRequest
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
            'search_id' => ['nullable', 'regex:/^[0-9]+$/i'],
        ];
    }

    public function attributes()
    {
        return [
            'search_id' => '顧客ID',
        ];
    }

    public function messages()
    {
        return [
            'search_id.regex' => ':attributeは半角数字で入力してください。',
        ];
    }
}
