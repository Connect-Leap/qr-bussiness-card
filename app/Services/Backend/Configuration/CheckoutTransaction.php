<?php

namespace App\Services\Backend\Configuration;

use App\Models\Transaction;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;
use App\Models\InformationSetting;
use Illuminate\Support\Facades\DB;

class CheckoutTransaction extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        DB::beginTransaction();

        try {
            $checkout_data_json = json_decode($dto['checkout_data_json']);

            $transaction = Transaction::create([
                'information_setting_id' => $dto['information_setting_id'],
                'transaction_code' => $checkout_data_json->transaction_id,
                'transaction_voucher_id' => $dto['transaction_voucher_id'],
                'price' => $checkout_data_json->gross_amount,
                'total_price' => $checkout_data_json->gross_amount,
                'transaction_time' => $checkout_data_json->transaction_time,
                'transaction_status' => $checkout_data_json->transaction_status,
                'payment_type' => $checkout_data_json->payment_type,
                'payment_pdf_url' => $checkout_data_json->pdf_url,
                'expired_date_until' => $dto['expired_date_until'],
                'snap_token' => $dto['snap_token'],
            ]);

            $update_information_setting = InformationSetting::where('id', $dto['information_setting_id'])->first();

            $update_information_setting->update([
                'expired_date' => $transaction['expired_date_until']
            ]);

            DB::commit();

            $this->results['response_code'] = $checkout_data_json->status_code;
            $this->results['success'] = ($checkout_data_json->status_code == 200) ? true : false;
            $this->results['message'] = $checkout_data_json->status_message;
            $this->results['data'] = $transaction;
        } catch (\Exception $err) {
            DB::rollBack();

            $this->results['response_code'] = $err->getCode();
            $this->results['success'] = false;
            $this->results['message'] = $err->getMessage();
            $this->results['data'] = [];
        }

    }
}
