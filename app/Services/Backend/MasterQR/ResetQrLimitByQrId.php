<?php

namespace App\Services\Backend\MasterQR;

use App\Models\ApplicationSetting;
use App\Models\QR;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class ResetQrLimitByQrId extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $qr_model = QR::where('id', $dto['qr_id'])->first();
        $application_setting = ApplicationSetting::first();

        if (empty($qr_model)) {
            $this->results['response_code'] = 404;
            $this->results['success'] = false;
            $this->results['message'] = 'QR ID Not Found';
            $this->results['data'] = [];
        } else {
            $qr_model->update([
                'usage_limit' => $application_setting->default_scan_limit,
            ]);

            $this->results['response_code'] = 200;
            $this->results['success'] = true;
            $this->results['message'] = 'QR Successfully Reset';
            $this->results['data'] = $qr_model;
        }
    }
}
