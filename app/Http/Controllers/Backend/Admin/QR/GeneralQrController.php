<?php

namespace App\Http\Controllers\Backend\Admin\QR;

use App\Models\Office;
use Illuminate\Http\Request;
use App\Models\QrContactType;
use App\Models\ApplicationSetting;
use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralQr\NonVcard\StoreQrRequest;

class GeneralQrController extends Controller
{
    public function index()
    {
        return view('pages.master-qr.general-qr.index');
    }

    public function create()
    {
        $offices = Office::latest()->get();
        if ($this->user()->hasRole('supervisor')) {
            $offices = $offices->filter(function ($value) {
                return $value->id == $this->user()->office_id;
            });
        }

        $settings = ApplicationSetting::latest()->get();
        $contact_types = QrContactType::where('name', '!=', 'VCard')->latest()->get();

        return view('pages.master-qr.general-qr.create', [
            'offices' => $offices,
            'settings' => $settings,
            'contact_types' => $contact_types
        ]);
    }

    public function createVcard()
    {
        $offices = Office::latest()->get();
        if ($this->user()->hasRole('supervisor')) {
            $offices = $offices->filter(function ($value) {
                return $value->id == $this->user()->office_id;
            });
        }

        $settings = ApplicationSetting::latest()->get();
        $contact_type = QrContactType::where('name', 'VCard')->first();

        return view('pages.master-qr.general-qr.create-vcard', [
            'offices' => $offices,
            'settings' => $settings,
            'contact_type' => $contact_type,
        ]);
    }

    public function store(StoreQrRequest $request)
    {
        $process = app('CreateQR')->execute([
            'name' => $request->qr_name,
            'qr_contact_type_id' => $request->qr_contact_type_id,
            'office_id' => $request->office_id,
            'user_id' => null,
            'redirect_link' => $request->redirect_link,
            'usage_limit' => $request->usage_limit,
            'status' => VALID,
        ]);

        if (!$process['success']) return redirect()->back()->with('fail', $process['message'])->withInput();

        $status = ($process['success'] == true) ? 'success' : 'fail';

        return redirect()->route('general-qr.index')->with($status, $process['message']);
    }
}
