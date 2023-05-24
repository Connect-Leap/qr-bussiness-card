<?php

namespace App\Http\Controllers\Backend\Admin\Configuration;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use Illuminate\Http\Request;

class ApplicationSettingController extends Controller
{
    public function index()
    {
        $settings = ApplicationSetting::latest()->get();

        return view('pages.application-setting.index', [
            'settings' => $settings
        ]);
    }

    public function create()
    {
        return view('pages.application-setting.create');
    }

    public function edit($id)
    {
        $setting = ApplicationSetting::where('id', $id)->first();

        return view('pages.application-setting.edit', [
            'setting' => $setting
        ]);
    }
}
