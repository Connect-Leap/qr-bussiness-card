<?php

namespace App\Http\Requests\Office;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOfficeRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'email' => ['required', 'email', Rule::unique('offices')->ignore($this->management_office)],
            'contact' => ['required', 'min:9', 'max:13'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required',
            'max' => 'The :attribute must not be greater than :max characters',
            'email' => 'The :attribute must be a valid email address',
            'unique' => 'The :attribute has already been taken',
            'min' => 'The :attribute must be at least :min characters',
        ];
    }
}
