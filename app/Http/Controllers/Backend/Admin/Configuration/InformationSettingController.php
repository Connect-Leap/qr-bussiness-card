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
        return view('pages.information-setting.index', [
            'information_setting' => $information_setting,
        ]);
    }

    public function updateInformationSetting(Request $request)
    {
        $process = app('UpdateInformationSetting')->execute([
            'application_name' => $request->application_name,
            'application_version' => $request->application_version,
            'application_description' => $request->application_description
        ]);

        return redirect()->back()->with('success', $process['message']);
    }
}
