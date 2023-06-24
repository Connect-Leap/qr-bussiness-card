<?php

namespace App\Http\Requests\Qr\Vcard;

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
            'usage_limit' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required',
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
