<?php

namespace App\Http\Controllers\Backend\Admin\QR;

use App\Models\QR;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Models\QrContactType;
use App\Models\ApplicationSetting;
use App\Http\Controllers\Controller;
use App\Http\Resources\QrCodeResource;
use App\Http\Requests\GeneralQr\NonVcard\StoreQrRequest;
use App\Http\Requests\GeneralQr\Vcard\StoreQrRequest as StoreQrVcardRequest;

class GeneralQrController extends Controller
{
    public function index(QrCodeResource $qrCodeResource)
    {
        $qr_model = QR::where('user_id', null)->latest()->get();
        if ($this->user()->hasRole('supervisor')) {
            $qr_model = $qr_model->filter(function ($value) {
                return $value->user->office->id == $this->user()->office_id;
            });
        }

        $qrcodes = $qrCodeResource->toArray($qr_model);

        return view('pages.master-qr.general-qr.index', [
            'qrcodes' => $qrcodes,
        ]);
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

    public function storeVcard(StoreQrVcardRequest $request)
    {
        $process = app('CreateQRVCard')->execute([
            'name' => ucwords('COMPANY PHONE CONTACT QR CODE'),
            'qr_contact_type_id' => $request->qr_contact_type_id,
            'office_id' => $request->office_id,
            'user_id' => null,
            'usage_limit' => $request->usage_limit,
            'status' => VALID,
        ]);

        if (!$process['success']) return redirect()->back()->with('fail', $process['message'])->withInput();

        return redirect()->route('general-qr.index')->with('success', $process['message']);
    }

    public function destroy($id)
    {
        $process = app('DeleteQR')->execute([
            'qr_id' => $id
        ]);

        if (!$process['success']) return back()->with('fail', $process['message']);

        return response()->json(['success' => $process['message']], $process['response_code']);
    }

    public function resetGeneralQrCode($qr_id)
    {
        $process = app('ResetQrLimitByQrId')->execute([
            'qr_id' => $qr_id,
        ]);

        return redirect()->back()->with('success', $process['message']);
    }

    public function resetAllGeneralQrCode()
    {
        $process = app('ResetAllGeneralQr')->execute();

        $status = ($process['success'] == true) ? 'success' : 'fail';

        return redirect()->back()->with($status, $process['message']);
    }

    public function showDetailQr($id)
    {
        $qr_model = QR::where('id', $id)->first();
        // dd(json_decode($qr_model->qrVisitors[0]->detail_visitor_json));

        return view('pages.master-qr.show-qr-visitor', [
            'qr_model' => $qr_model,
        ]);
    }
}
