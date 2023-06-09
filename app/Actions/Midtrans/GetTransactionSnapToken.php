<?php

namespace App\Actions\Midtrans;

use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class GetTransactionSnapToken extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $dto['total_price'],
            ),
            'customer_details' => array(
                'first_name' => $dto['customer_name'],
                'last_name' => '',
                'email' => $dto['stakeholder_email'],
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $this->results['response_code'] = 200;
        $this->results['success'] = true;
        $this->results['message'] = 'Snap Token Successfully Generated';
        $this->results['data'] = ['snap_token' => $snapToken];
    }
}
