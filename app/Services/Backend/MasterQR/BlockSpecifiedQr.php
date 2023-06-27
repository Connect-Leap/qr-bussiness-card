<?php

namespace App\Services\Backend\MasterQR;

use App\Models\QR;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class BlockSpecifiedQr extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $qr_model = QR::where('id', $dto['qr_id'])->first();

        if (empty($qr_model)) {
            $this->results['response_code'] = 404;
            $this->results['success'] = false;
            $this->results['message'] = 'QR ID Not Found';
            $this->results['data'] = [];
        } else {
            $qr_model->update([
                'status' => INVALID,
            ]);

            $this->results['response_code'] = 200;
            $this->results['success'] = true;
            $this->results['message'] = 'QR Successfully Blocked';
            $this->results['data'] = $qr_model;
        }
    }
}
