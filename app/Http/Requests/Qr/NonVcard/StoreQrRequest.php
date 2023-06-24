<?php

namespace App\Http\Requests\Qr\NonVcard;

use Illuminate\Foundation\Http\FormRequest;

class StoreQrRequest extends FormRequest
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
            'qr_contact_type_id' => ['required'],
            'user_id' => ['required'],
            'redirect_link' => ['required', 'unique:qrs,redirect_link'],
            'usage_limit' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required',
            'unique' => 'The :attribute has already been taken',
        ];
    }

    public function attributes()
    {
        return [
            'qr_contact_type_id' => 'contact type',
            'user_id' => 'user',
        ];
    }
}
