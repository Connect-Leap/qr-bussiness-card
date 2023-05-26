<?php

namespace App\Http\Controllers\Backend\Admin\QR;

use App\Http\Controllers\Controller;
use App\Http\Resources\QrCodeResource;
use App\Models\ApplicationSetting;
use App\Models\QR;
use App\Models\QrContactType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use AshAllenDesign\ShortURL\Models\ShortURL;

class QrController extends Controller
{
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
        $users = User::whereNotIn('role', $roles_cannot_have_qr)->latest()->get();
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

    public function QrProcessing($url_key, $qr_id)
    {
        $process = app('QrProcessing')->execute([
            'url_key' => $url_key,
            'qr_id' => $qr_id
        ]);

        return Redirect::to($process['data']['destination'], $process['response_code']);
    }

    public function edit($id)
    {
        $qr = QR::where('id', $id)->first();

        return view('pages.master-qr.edit', [
            'qr' => $qr
        ]);
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
        //
    }
}
