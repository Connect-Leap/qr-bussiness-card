<?php

namespace App\Services\Backend\Configuration;

use App\Models\ApplicationSetting;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class CreateApplicationSetting extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $application_setting_model = ApplicationSetting::create([
            'default_scan_limit' => $dto['default_scan_limit'],
            'default_rate_limit' => $dto['default_rate_limit'],
            'default_rate_time_limit' => $dto['default_rate_time_limit'],
        ]);

        $this->results['response_code'] = 200;
        $this->results['success'] = true;
        $this->results['message'] = 'Application Setting Created Successfully';
        $this->results['data'] = $application_setting_model;
    }
}
