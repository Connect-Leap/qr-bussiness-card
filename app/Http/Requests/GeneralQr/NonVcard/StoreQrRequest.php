<?php

namespace App\Http\Requests\GeneralQr\NonVcard;

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
            'qr_name' => ['required'],
            'qr_contact_type_id' => ['required'],
            'office_id' => ['required'],
            'redirect_link' => ['required'],
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
            'office_id' => 'office',
            'qr_name' => 'qr name',
        ];
    }
}
