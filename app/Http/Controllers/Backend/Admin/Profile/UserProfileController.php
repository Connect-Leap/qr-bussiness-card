<?php

namespace App\Http\Controllers\Backend\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\QrCodeResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\QR;

class UserProfileController extends Controller
{
    public function show(QrCodeResource $qrCodeResource)
    {

        $authenticated_user = auth()->user();
        $total_online_hour = diffDatetimeCounter($authenticated_user->login_at);
        $total_usage_hour = diffDatetimeCounter($authenticated_user->created_at);
        $qr = $qrCodeResource->toArray(QR::where('user_id', $authenticated_user->id)->get())[0];

        return view('pages.profile.user-profile', [
            'total_online_hour' => $total_online_hour,
            'total_usage_hour' => $total_usage_hour,
            'user' => $authenticated_user,
            'qr' => $qr,
        ]);
    }

    public function update(Request $request)
    {
        // dd($request->all());
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

        // dd($rules);

        $request->validate($rules, [
            'name.required' => 'The :attribute field is required.',
            'gender.required' => 'The :attribute field is required.',
            'email.required' => 'The :attribute field is required.',
            'email.unique' => 'The :attribute has already been taken.',
            'department_name.required' => 'The :attribute field is required.',
            'user_position.required' => 'The :attribute field is required.',
            'country_name.required' => 'The :attribute field is required.',
            'country_code.required' => 'The :attribute field is required.',
            'country_phone_code.required' => 'The :attribute field is required.',
            'employee_code' => 'The :attribute field is required.',
            'phone_number' =>'The :attribute field is required.',
        ]);

        $data = [
            'office_id' => auth()->user()->office_id,
            'user_id' => auth()->id(),
            'role' => auth()->user()->role,

            'name' => $request->name,
            'gender' => $request->gender,
            'email' => $request->email,
            'department_name' => $request->department_name,
            'user_position' => $request->user_position,
            'user_position_period' => $request->user_position_period,
            'country_name' => $request->country_name,
            'country_code' => $request->country_code,
            'country_phone_code' => $request->country_phone_code,
        ];


        if (auth()->user()->role == "employee") {
            $data['employee_code'] = $request->employee_code;
            $data['phone_number'] = $request->phone_number;
        }

        $process = app('UpdateUser')->execute($data);

        $status = $process['success'] == true ? 'success' : 'fail';

        return redirect()->back()->with($status, $process['message']);

    }
}
