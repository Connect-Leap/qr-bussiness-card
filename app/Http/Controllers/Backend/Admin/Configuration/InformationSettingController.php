<?php

namespace App\Http\Controllers\Backend\Admin\Configuration;

use App\Http\Controllers\Controller;
use App\Models\InformationSetting;
use Illuminate\Http\Request;

class InformationSettingController extends Controller
{
    public function showInformationSetting()
    {
        // Gate
        if (!$this->user()->hasPermissionTo('show-information-setting')) {
            $this->throwUnauthorizedException(['show-information-setting']);
        }
        // End Gate

        $information_setting = InformationSetting::first();

        if (!is_null($information_setting->expired_date)) {
            $day_counter = ceil((strtotime($information_setting->expired_date) - time())/86400);
            $day_counter = $day_counter. ' Days Remain';
        }

        return view('pages.information-setting.index', [
            'information_setting' => $information_setting,
            'day_counter' => (!is_null($information_setting->expired_date))
                            ? $day_counter
                            : [],
        ]);
    }

    public function showCheckoutTransactionPage()
    {
        // Gate
        if (!$this->user()->hasPermissionTo('show-checkout-transaction')) {
            $this->throwUnauthorizedException(['show-checkout-transaction']);
        }
        // End Gate

        $information_setting = InformationSetting::first();

        if (is_null($information_setting->stakeholder_email)) {
            abort(503);
        }

        // Midtrans Get Snap Token
        if (!is_null($information_setting->stakeholder_email)) {
            $midtrans = app('GetTransactionSnapToken')->execute([
                'total_price' => 10000,
                'customer_name' => $information_setting->application_name,
                'stakeholder_email' => $information_setting->stakeholder_email,
            ]);
        } // end

        return view('pages.information-setting.order-transaction', [
            'information_setting' => $information_setting,
            'midtrans' => (!is_null($information_setting->stakeholder_email))
                            ? ['snap_token' => $midtrans['data']['snap_token']]
                            : [],
        ]);
    }

    public function updateInformationSetting(Request $request)
    {
        // Gate
        if (!$this->user()->hasPermissionTo('update-information-setting')) {
            $this->throwUnauthorizedException(['update-information-setting']);
        }
        // End Gate

        $process = app('UpdateInformationSetting')->execute([
            'application_name' => $request->application_name,
            'application_version' => $request->application_version,
            'application_description' => $request->application_description,
            'stakeholder_email' => $request->stakeholder_email,
        ]);

        return redirect()->back()->with('success', $process['message']);
    }

    public function checkoutOrder(Request $request)
    {
        $process = app('CheckoutTransaction')->execute([
            'checkout_data_json' => $request->get('checkout_data_json'),
            'information_setting_id' => $request->get('information_setting_id'),
            'transaction_voucher_id' => null,
            'snap_token' => null,
        ]);

        $status = ($process['success'] == true) ? 'success' : 'fail';

        return redirect()->route('information-setting.index')->with($status, $process['message']);
    }
}
