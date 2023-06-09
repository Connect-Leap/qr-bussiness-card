<?php

namespace App\Http\Controllers\Backend\Admin\Configuration;

use App\Http\Controllers\Controller;
use App\Models\InformationSetting;
use Illuminate\Http\Request;

class InformationSettingController extends Controller
{
    public function showInformationSetting()
    {
        $information_setting = InformationSetting::first();

        // Midtrans Get Snap Token
        if (!is_null($information_setting->stakeholder_email)) {
            $midtrans = app('GetTransactionSnapToken')->execute([
                'total_price' => 10000,
                'customer_name' => $information_setting->application_name,
                'stakeholder_email' => $information_setting->stakeholder_email,
            ]);
        } // end

        return view('pages.information-setting.index', [
            'information_setting' => $information_setting,
            'midtrans' => (!is_null($information_setting->stakeholder_email))
                            ? ['snap_token' => $midtrans['data']['snap_token']]
                            : [],
        ]);
    }

    public function updateInformationSetting(Request $request)
    {
        $process = app('UpdateInformationSetting')->execute([
            'application_name' => $request->application_name,
            'application_version' => $request->application_version,
            'application_description' => $request->application_description,
            'stakeholder_email' => $request->stakeholder_email,
        ]);

        return redirect()->back()->with('success', $process['message']);
    }
}
