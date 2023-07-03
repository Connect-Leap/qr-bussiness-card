<?php

namespace App\Http\Requests\Users\Supervisor;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupervisorRequest extends FormRequest
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
            'office_id' => ['required'],
            'name' => ['required', 'max:255'],
            'gender' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'department_name' => ['required', 'max:255'],
            'user_position' => ['required', 'max:255'],
            'user_position_period' => ['required'],
            'country_id' => ['required'],
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

    public function attributes()
    {
        return [
            'office_id' => 'office',
            'country_id' => 'country',
        ];
    }
}
