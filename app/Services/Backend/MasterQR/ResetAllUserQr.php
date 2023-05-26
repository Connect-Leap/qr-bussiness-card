<?php

namespace App\Services\Backend\MasterQR;

use App\Models\ApplicationSetting;
use App\Models\QR;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class ResetAllUserQr extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $application_setting = ApplicationSetting::first();

        $qr_models = QR::query()->update([
            'usage_limit' => $application_setting->default_scan_limit
        ]);

        $this->results['response_code'] = 200;
        $this->results['success'] = true;
        $this->results['message'] = 'All QR Records Successfully Reset';
        $this->results['data'] = $qr_models;
    }
}
