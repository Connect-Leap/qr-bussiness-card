<?php

namespace App\Services\Backend\MasterQR;

use App\Models\QR;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class UpdateQR extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $qr_model = QR::where('id', $dto['qr_id'])->first();

        if (empty($qr_model)) {
            $this->results['response_code'] = 404;
            $this->results['success'] = false;
            $this->results['message'] = 'QR Not Found';
            $this->results['data'] = [];
        } else {
            $qr_model->update([
                'qr_contact_type_id' => $dto['qr_contact_type_id'],
                'user_id' => $dto['user_id'],
                'redirect_link' => $dto['redirect_link'],
                'usage_limit' => $dto['usage_limit'],
            ]);

            $this->results['response_code'] = 200;
            $this->results['success'] = true;
            $this->results['message'] = 'QR Updated Successfully';
            $this->results['data'] = $qr_model;
        }
    }
}