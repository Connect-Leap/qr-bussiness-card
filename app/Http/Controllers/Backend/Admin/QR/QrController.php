<?php

namespace App\Http\Controllers\Backend\Admin\QR;

use App\Models\QR;
use App\Models\User;
use App\Traits\ClientIp;
use Illuminate\Http\Request;
use App\Models\QrContactType;
use Illuminate\Http\Response;
use App\Models\ApplicationSetting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Qr\NonVcard\StoreQrRequest;
use App\Http\Requests\Qr\Vcard\StoreQrRequest as StoreQrVcardRequest;
use App\Http\Resources\QrCodeResource;
use JeroenDesloovere\VCard\VCardParser;
use Illuminate\Support\Facades\Redirect;
use Stevebauman\Location\Facades\Location;
use App\Http\Resources\QrProcessingResource;
use AshAllenDesign\ShortURL\Models\ShortURL;
use App\Traits\GetOfficeidFromUserId;

class QrController extends Controller
{
    use ClientIp, GetOfficeidFromUserId;

    public function index(QrCodeResource $qrCodeResource)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('show-user-qr')) {
            $this->throwUnauthorizedException(['show-qr']);
        }
        // End Gate

        $qr_model = QR::where('office_id', null)->latest()->get();
        if ($this->user()->hasRole('supervisor')) {
            $qr_model = $qr_model->filter(function ($value) {
                return $value->user->office->id == $this->user()->office_id;
            });
        }

        $qrcodes = $qrCodeResource->toArray($qr_model);

        return view('pages.master-qr.index', [
            'qrcodes' => $qrcodes,
        ]);
    }

    public function create()
    {
        // Gate
        if (!$this->user()->hasPermissionTo('create-user-qr')) {
            $this->throwUnauthorizedException(['create-user-qr']);
        }
        // End Gate

        $roles_cannot_have_qr = ['admin', 'supervisor'];
        $user_id_from_qr_model = QR::select('user_id')->where('user_id', '!=', null)->latest()->get()->pluck('user_id')->toArray();

        // Users
        $users = User::whereNotIn('role', $roles_cannot_have_qr)->whereNotIn('id', $user_id_from_qr_model)->latest()->get();
        if ($this->user()->hasRole('supervisor')) {
            $users = $users->filter(function ($value) {
                return $value->office->id == $this->user()->office_id;
            });
        }
        // End Users

        $settings = ApplicationSetting::latest()->get();
        $contact_types = QrContactType::where('name', '!=', 'VCard')->latest()->get();

        return view('pages.master-qr.create', [
            'users' => $users,
            'settings' => $settings,
            'contact_types' => $contact_types,
        ]);
    }

    public function createVcard()
    {
        // Gate
        if (!$this->user()->hasPermissionTo('create-user-qr-vcard')) {
            $this->throwUnauthorizedException(['create-user-qr-vcard']);
        }
        // End Gate

        $roles_cannot_have_qr = ['admin', 'supervisor'];
        $user_id_from_qr_model = QR::select('user_id')->where('user_id', '!=', null)->latest()->get()->pluck('user_id')->toArray();

        // Users
        $users = User::whereNotIn('role', $roles_cannot_have_qr)->whereNotIn('id', $user_id_from_qr_model)->latest()->get();
        if ($this->user()->hasRole('supervisor')) {
            $users = $users->filter(function ($value) {
                return $value->office->id == $this->user()->office_id;
            });
        }
        // End Users

        $settings = ApplicationSetting::latest()->get();
        $contact_type = QrContactType::where('name', 'VCard')->first();

        return view('pages.master-qr.create-vcard', [
            'users' => $users,
            'settings' => $settings,
            'contact_type' => $contact_type,
        ]);
    }

    public function store(StoreQrRequest $request)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('store-user-qr')) {
            $this->throwUnauthorizedException(['store-user-qr']);
        }
        // End Gate

        $process = app('CreateQR')->execute([
            'name' => null,
            'qr_contact_type_id' => $request->qr_contact_type_id,
            'office_id' => null,
            'user_id' => $request->user_id,
            'redirect_link' => $request->redirect_link,
            'usage_limit' => $request->usage_limit,
            'status' => VALID,
            'created_by' => $this->user()->id,
            'created_for_user_office' => $this->getOfficeIdFromUserId($request->user_id),
        ]);

        if (!$process['success']) return redirect()->back()->with('fail', $process['message'])->withInput();

        return redirect()->route('master-qr.index')->with('success', $process['message']);
    }

    public function storeVcard(StoreQrVcardRequest $request)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('store-user-qr-vcard')) {
            $this->throwUnauthorizedException(['store-user-qr-vcard']);
        }
        // End Gate

        $process = app('CreateQRVCard')->execute([
            'name' => null,
            'qr_contact_type_id' => $request->qr_contact_type_id,
            'office_id' => null,
            'user_id' => $request->user_id,
            'usage_limit' => $request->usage_limit,
            'status' => VALID,
            'created_by' => $this->user()->id,
            'created_for_user_office' => $this->getOfficeIdFromUserId($request->user_id),
        ]);

        if (!$process['success']) return redirect()->back()->with('fail', $process['message'])->withInput();

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

    public function QrVcardProcessing(QrProcessingResource $qrProcessingResource, $qr_id)
    {
        $qr_visitor_data = $qrProcessingResource->toArray(Location::get($this->getIp()));

        $process = app('QrVcardProcessing')->execute([
            'qr_id' => $qr_id,
            'qr_visitor_data' => $qr_visitor_data,
        ]);

        if (!$process['success']) return Redirect::to($process['data']['destination'], $process['response_code']);

        return view('pages.waiting-page', [
            'destination' => $process['data']['destination'],
            'filename' => $process['data']['filename'],
            'vcard_string' => $process['data']['qr_data']['vcard_string'],
        ]);
    }

    public function edit($id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('edit-user-qr')) {
            $this->throwUnauthorizedException(['edit-user-qr']);
        }
        // End Gate

        $qr = QR::where('id', $id)->first();
        $roles_cannot_have_qr = ['admin', 'supervisor'];
        $users = User::whereNotIn('role', $roles_cannot_have_qr)->latest()->get();
        $contact_types = QrContactType::where('name', '!=', 'VCard')->latest()->get();

        return view('pages.master-qr.edit', [
            'qr' => $qr,
            'users' => $users,
            'contact_types' => $contact_types,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('update-user-qr')) {
            $this->throwUnauthorizedException(['update-user-qr']);
        }
        // End Gate

        $process = app('UpdateQR')->execute([
            'qr_id' => $id,
            'qr_contact_type_id' => $request->qr_contact_type_id,
            'user_id' => $request->user_id,
            'redirect_link' => $request->redirect_link,
            'usage_limit' => $request->usage_limit,
        ]);

        if ($process['response_code'] == 403) return redirect()->back()->with('fail', $process['message'])->withInput();

        return redirect()->route('master-qr.index')->with('success', $process['message']);
    }

    public function destroy($id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('delete-user-qr')) {
            $this->throwUnauthorizedException(['delete-user-qr']);
        }
        // End Gate

        $process = app('DeleteQR')->execute([
            'qr_id' => $id
        ]);

        if (!$process['success']) return back()->with('fail', $process['message']);

        return response()->json(['success' => $process['message']], $process['response_code']);
    }

    public function resetUserQrCode($qr_id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('reset-specified-user-qr')) {
            $this->throwUnauthorizedException(['reset-specified-user-qr']);
        }
        // End Gate

        $process = app('ResetQrLimitByQrId')->execute([
            'qr_id' => $qr_id,
        ]);

        return redirect()->back()->with('success', $process['message']);
    }

    public function resetAllUserQrCode()
    {
        // Gate
        if (!$this->user()->hasPermissionTo('reset-all-user-qr')) {
            $this->throwUnauthorizedException(['reset-all-user-qr']);
        }
        // End Gate

        $process = app('ResetAllUserQr')->execute();

        $status = ($process['success'] == true) ? 'success' : 'fail';

        return redirect()->back()->with($status, $process['message']);
    }

    public function showDetailQr($id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('show-detail-user-qr')) {
            $this->throwUnauthorizedException(['show-detail-user-qr']);
        }
        // End Gate

        $qr_model = QR::where('id', $id)->first();
        // dd(json_decode($qr_model->qrVisitors[0]->detail_visitor_json));

        return view('pages.master-qr.show-qr-visitor', [
            'qr_model' => $qr_model,
        ]);
    }

    public function activateSpecifiedUserQr($id)
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

    public function blockSpecifiedUserQr($id)
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
