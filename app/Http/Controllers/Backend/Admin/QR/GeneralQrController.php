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
        // Gate
        if (!$this->user()->hasPermissionTo('show-general-qr')) {
            $this->throwUnauthorizedException(['show-general-qr']);
        }
        // End Gate

        $qr_model = QR::where('user_id', null)->latest()->get();

        if ($this->user()->hasRole('supervisor')) {
            $qr_model = $qr_model->filter(function ($value) {
                return $value->office->id == $this->user()->office_id;
            });
        }

        $qrcodes = $qrCodeResource->toArray($qr_model);

        // dd($qrcodes[0]['qrcode']['status']);

        return view('pages.master-qr.general-qr.index', [
            'qrcodes' => $qrcodes,
        ]);
    }

    public function create()
    {
        // Gate
        if (!$this->user()->hasPermissionTo('create-general-qr')) {
            $this->throwUnauthorizedException(['create-general-qr']);
        }
        // End Gate

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
        // Gate
        if (!$this->user()->hasPermissionTo('create-general-qr-vcard')) {
            $this->throwUnauthorizedException(['create-general-qr-vcard']);
        }
        // End Gate

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
        // Gate
        if (!$this->user()->hasPermissionTo('store-general-qr')) {
            $this->throwUnauthorizedException(['store-general-qr']);
        }
        // End Gate

        $process = app('CreateQR')->execute([
            'name' => $request->qr_name,
            'qr_contact_type_id' => $request->qr_contact_type_id,
            'office_id' => $request->office_id,
            'user_id' => null,
            'redirect_link' => $request->redirect_link,
            'usage_limit' => $request->usage_limit,
            'status' => VALID,
            'created_by' => $this->user()->id,
            'created_for_user_office' => $request->office_id,
        ]);

        if (!$process['success']) return redirect()->back()->with('fail', $process['message'])->withInput();

        $status = ($process['success'] == true) ? 'success' : 'fail';

        return redirect()->route('general-qr.index')->with($status, $process['message']);
    }

    public function storeVcard(StoreQrVcardRequest $request)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('store-general-qr-vcard')) {
            $this->throwUnauthorizedException(['store-general-qr-vcard']);
        }
        // End Gate

        $process = app('CreateQRVCard')->execute([
            'name' => ucwords($request->qr_name),
            'qr_contact_type_id' => $request->qr_contact_type_id,
            'office_id' => $request->office_id,
            'user_id' => null,
            'usage_limit' => $request->usage_limit,
            'status' => VALID,
            'created_by' => $this->user()->id,
            'created_for_user_office' => $request->office_id,
        ]);

        if (!$process['success']) return redirect()->back()->with('fail', $process['message'])->withInput();

        return redirect()->route('general-qr.index')->with('success', $process['message']);
    }

    public function destroy($id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('delete-general-qr')) {
            $this->throwUnauthorizedException(['delete-general-qr']);
        }
        // End Gate

        $process = app('DeleteQR')->execute([
            'qr_id' => $id
        ]);

        if (!$process['success']) return back()->with('fail', $process['message']);

        return response()->json(['success' => $process['message']], $process['response_code']);
    }

    public function resetGeneralQrCode($qr_id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('reset-specified-general-qr')) {
            $this->throwUnauthorizedException(['reset-specified-general-qr']);
        }
        // End Gate

        $process = app('ResetQrLimitByQrId')->execute([
            'qr_id' => $qr_id,
        ]);

        return redirect()->back()->with('success', $process['message']);
    }

    public function resetAllGeneralQrCode()
    {
        // Gate
        if (!$this->user()->hasPermissionTo('reset-all-general-qr')) {
            $this->throwUnauthorizedException(['reset-all-general-qr']);
        }
        // End Gate

        $process = app('ResetAllGeneralQr')->execute();

        $status = ($process['success'] == true) ? 'success' : 'fail';

        return redirect()->back()->with($status, $process['message']);
    }

    public function showDetailQr($id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('show-detail-general-qr')) {
            $this->throwUnauthorizedException(['show-detail-general-qr']);
        }
        // End Gate

        $qr_model = QR::where('id', $id)->first();
        // dd(json_decode($qr_model->qrVisitors[0]->detail_visitor_json));

        return view('pages.master-qr.show-qr-visitor', [
            'qr_model' => $qr_model,
        ]);
    }

    public function activateSpecifiedGeneralQr($id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('activate-specified-qr')) {
            $this->throwUnauthorizedException(['activate-specified-qr']);
        }
        // End Gate

        $process = app('ActivateSpecifiedQr')->execute([
            'qr_id' => $id,
        ]);

        $status = ($process['success'] == true) ? 'success' : 'fail';

        return redirect()->back()->with($status, $process['message']);
    }

    public function blockSpecifiedGeneralQr($id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('block-specified-qr')) {
            $this->throwUnauthorizedException(['block-specified-qr']);
        }
        // End Gate

        $process = app('BlockSpecifiedQr')->execute([
            'qr_id' => $id,
        ]);

        $status = ($process['success'] == true) ? 'success' : 'fail';

        return redirect()->back()->with($status, $process['message']);
    }
}
