<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'max:50',
            'content' => 'max:1000',
        ];
    }

    public function messages()
    {
        return [
            'title.max' => 'タイトルは50文字以内にしてください',
            'content.max' => 'メッセージは1000文字以内にしてください',
        ];
    }
}
