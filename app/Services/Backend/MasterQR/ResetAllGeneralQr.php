<?php

namespace App\Services\Backend\MasterQR;

use App\Models\ApplicationSetting;
use App\Models\QR;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class ResetAllGeneralQr extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $application_setting = ApplicationSetting::first();

        if (QR::count() < 1) {
            $this->results['response_code'] = 404;
            $this->results['success'] = false;
            $this->results['message'] = 'QR Records Not Found';
            $this->results['data'] = [];
        } else {
            $qr_models = QR::query()->where('office_id', '!=', null)->update([
                'usage_limit' => $application_setting->default_scan_limit,
                'status' => VALID
            ]);

            $this->results['response_code'] = 200;
            $this->results['success'] = true;
            $this->results['message'] = 'All General QR Records Successfully Reset';
            $this->results['data'] = $qr_models;
        }


    }
}
