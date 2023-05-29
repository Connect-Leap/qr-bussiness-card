<?php

namespace App\Services\Backend\Configuration;

use App\Models\ApplicationSetting;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class UpdateApplicationSetting extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $find_application_setting = ApplicationSetting::where('id', $dto['application_setting_id'])->first();

        if (empty($find_application_setting)) {
            $this->results['response_code'] = 404;
            $this->results['success'] = false;
            $this->results['message'] = 'Application Setting Not Found';
            $this->results['data'] = [];
        } else{
            $find_application_setting->update([
                'default_scan_limit' => $dto['default_scan_limit'],
                'default_rate_limit' => $dto['default_rate_limit'],
                'default_rate_time_limit' => ($find_application_setting->default_rate_time_limit != $dto['default_rate_time_limit']) ? ($dto['default_rate_time_limit'] * 60) : $dto['default_rate_time_limit'],
            ]);

            $this->results['response_code'] = 200;
            $this->results['success'] = true;
            $this->results['message'] = 'Application Setting Successfully Updated';
            $this->results['data'] = $find_application_setting;
        }
    }
}
