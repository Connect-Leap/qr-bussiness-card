<?php

namespace App\Http\Requests\Profile;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'max:255'],
            'gender' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->id())],
            'department_name' => ['required', 'max:255'],
            'user_position' => ['required', 'max:255'],
            'user_position_period' => ['required'],
            'country_name' => ['required', 'max:255'],
            'country_code' => ['required', 'min:2'],
            'country_phone_code' => ['required', 'min:2'],
        ];

        if (auth()->user()->role == "employee") {
            $rules['employee_code'] = ['required'];
            $rules['phone_number'] = ['required', 'min:9', 'max:13'];
        }

        return $rules;
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
