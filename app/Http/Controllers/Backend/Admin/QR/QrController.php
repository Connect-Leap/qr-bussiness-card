<?php

namespace App\Http\Controllers\Backend\Admin\QR;

use App\Http\Controllers\Controller;
use App\Http\Resources\QrCodeResource;
use App\Http\Resources\QrProcessingResource;
use App\Models\ApplicationSetting;
use App\Models\QR;
use App\Models\QrContactType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use AshAllenDesign\ShortURL\Models\ShortURL;
use App\Traits\ClientIp;
use Stevebauman\Location\Facades\Location;

class QrController extends Controller
{
    use ClientIp;

    public function index(QrCodeResource $qrCodeResource)
    {
        $qrcodes = $qrCodeResource->toArray(QR::latest()->get());
        // dd($qrcodes);

        return view('pages.master-qr.index', [
            'qrcodes' => $qrcodes,
        ]);
    }

    public function create()
    {
        $roles_cannot_have_qr = ['admin', 'supervisor'];
        $user_id_from_qr_model = QR::select('user_id')->latest()->get()->pluck('user_id')->toArray();
        $users = User::whereNotIn('role', $roles_cannot_have_qr)->whereNotIn('id', $user_id_from_qr_model)->latest()->get();
        $settings = ApplicationSetting::latest()->get();
        $contact_types = QrContactType::latest()->get();

        return view('pages.master-qr.create', [
            'users' => $users,
            'settings' => $settings,
            'contact_types' => $contact_types,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'qr_contact_type_id' => ['required'],
            'user_id' => ['required'],
            'redirect_link' => ['required', 'unique:qrs,redirect_link'],
            'usage_limit' => ['required'],
        ]);

        $process = app('CreateQR')->execute([
            'qr_contact_type_id' => $request->qr_contact_type_id,
            'user_id' => $request->user_id,
            'redirect_link' => $request->redirect_link,
            'usage_limit' => $request->usage_limit,
            'status' => VALID,
        ]);

        return redirect()->route('master-qr.index')->with('success', $process['message']);
    }

    public function QrProcessing(QrProcessingResource $qrProcessingResource, $url_key, $qr_id)
    {
        $qr_visitor_data = $qrProcessingResource->toArray(Location::get($this->getIp()));
        $application_setting = ApplicationSetting::first();

        $process = app('QrProcessing')->execute([
            'url_key' => $url_key,
            'qr_id' => $qr_id,
            'qr_visitor_data' => $qr_visitor_data,
            'application_setting' => $application_setting,
        ]);

        if ($process['response_code'] == 429) {
            abort(429);
        }

        return Redirect::to($process['data']['destination'], $process['response_code']);
    }

    public function edit($id)
    {
        $qr = QR::where('id', $id)->first();
        $roles_cannot_have_qr = ['admin', 'supervisor'];
        $users = User::whereNotIn('role', $roles_cannot_have_qr)->latest()->get();
        $contact_types = QrContactType::latest()->get();

        return view('pages.master-qr.edit', [
            'qr' => $qr,
            'users' => $users,
            'contact_types' => $contact_types,
        ]);
    }

    public function update(Request $request, $id)
    {
        $process = app('UpdateQR')->execute([
            'qr_id' => $id,
            'qr_contact_type_id' => $request->qr_contact_type_id,
            'user_id' => $request->user_id,
            'redirect_link' => $request->redirect_link,
            'usage_limit' => $request->usage_limit,
        ]);

        return redirect()->route('master-qr.index')->with('success', $process['message']);
    }

    public function destroy($id)
    {
        $process = app('DeleteQR')->execute([
            'qr_id' => $id
        ]);

        if (!$process['success']) return response()->json(['error' => $process['message']], $process['response_code']);

        return response()->json(['success' => $process['message']], $process['response_code']);
    }

    public function resetUserQrCode($qr_id)
    {
        $process = app('ResetQrLimitByQrId')->execute([
            'qr_id' => $qr_id,
        ]);

        return redirect()->back()->with('success', $process['message']);
    }

    public function resetAllUserQrCode()
    {
        $process = app('ResetAllUserQr')->execute();

        $status = ($process['success'] == true) ? 'success' : 'fail';

        return redirect()->back()->with($status, $process['message']);
    }
}
