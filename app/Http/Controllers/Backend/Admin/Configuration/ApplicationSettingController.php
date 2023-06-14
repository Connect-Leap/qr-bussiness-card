<?php

namespace App\Http\Controllers\Backend\Admin\Configuration;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use Illuminate\Http\Request;

class ApplicationSettingController extends Controller
{
    public function index()
    {
        // Gate
        if (!$this->user()->hasPermissionTo('show-application-setting')) {
            $this->throwUnauthorizedException(['show-application-setting']);
        }
        // End Gate

        $settings = ApplicationSetting::latest()->get();

        return view('pages.application-setting.index', [
            'settings' => $settings
        ]);
    }

    public function create()
    {
        abort(403, 'Page Unauthorized');

        return view('pages.application-setting.create');
    }

    public function store(Request $request)
    {
        abort(403, 'Page Unauthorized');

        $request->validate([
            'default_scan_limit' => ['required'],
        ]);

        $process = app('CreateApplicationSetting')->execute([
            'default_scan_limit' => $request->default_scan_limit,
            'default_rate_limit' => $request->default_rate_limit,
            'default_rate_time_limit' => $request->default_rate_time_limit,
        ]);

        return redirect()->route('application-setting.index')->with('success', $process['message']);
    }

    public function edit($id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('edit-application-setting')) {
            $this->throwUnauthorizedException(['edit-application-setting']);
        }
        // End Gate

        $setting = ApplicationSetting::where('id', $id)->first();

        return view('pages.application-setting.edit', [
            'setting' => $setting
        ]);
    }

    public function update(Request $request, $id)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('update-application-setting')) {
            $this->throwUnauthorizedException(['update-application-setting']);
        }
        // End Gate

        $request->validate([
            'default_scan_limit' => ['required'],
        ]);

        $process = app('UpdateApplicationSetting')->execute([
            'application_setting_id' => $id,
            'default_scan_limit' => $request->default_scan_limit,
            'default_rate_limit' => $request->default_rate_limit,
            'default_rate_time_limit' => $request->default_rate_time_limit,
        ]);

        return redirect()->route('application-setting.index')->with('success', $process['message']);
    }
}
