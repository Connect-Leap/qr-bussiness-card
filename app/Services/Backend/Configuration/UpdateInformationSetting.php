<?php

namespace App\Services\Backend\Configuration;

use App\Models\InformationSetting;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class UpdateInformationSetting extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $information_setting = InformationSetting::first();

        if (empty($information_setting)) {
            $this->results['response_code'] = 404;
            $this->results['success'] = false;
            $this->results['message'] = 'Information Setting Not Found';
            $this->results['data'] = [];
        } else {
            $information_setting->update([
                'application_name' => $dto['application_name'],
                'application_version' => $dto['application_version'],
                'application_description' => $dto['application_description'],
                'stakeholder_email' => $dto['stakeholder_email'],
            ]);

            $this->results['response_code'] = 200;
            $this->results['success'] = true;
            $this->results['message'] = 'Information Setting Updated Successfully';
            $this->results['data'] = $information_setting;
        }
    }
}
