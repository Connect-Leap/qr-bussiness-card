<?php

namespace App\Http\Controllers\Backend\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\QrCodeResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\QR;
use Barryvdh\DomPDF\Facade\Pdf;

class UserProfileController extends Controller
{
    public function show(QrCodeResource $qrCodeResource)
    {

        $authenticated_user = auth()->user();
        $total_online_hour = diffDatetimeCounter($authenticated_user->login_at);
        $total_usage_hour = diffDatetimeCounter($authenticated_user->created_at);
        if ($authenticated_user->hasRole('employee') && !is_null($authenticated_user->Qr)) {
            $qr = $qrCodeResource->toArray(QR::where('user_id', $authenticated_user->id)->get())[0];
        }

        return view('pages.profile.user-profile', [
            'total_online_hour' => $total_online_hour,
            'total_usage_hour' => $total_usage_hour,
            'user' => $authenticated_user,
            'qr' => $qr ?? [],
        ]);
    }

    public function showCard(QrCodeResource $qrCodeResource)
    {
        $authenticated_user = auth()->user();
        if ($authenticated_user->hasRole('employee') && !is_null($authenticated_user->Qr)) {
            $qr = $qrCodeResource->toArray(QR::where('user_id', $authenticated_user->id)->get())[0];
        }

        $pdf = Pdf::loadView('pdf.card-simulation', ['user' => $authenticated_user, 'qr' => $qr ?? []])
            ->setPaper('a4', 'landscape');

        return $pdf->stream('card-simulation.pdf');
    }

    public function update(UpdateProfileRequest $request)
    {
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
