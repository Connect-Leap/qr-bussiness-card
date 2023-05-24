<?php

namespace App\Services\Backend\MasterOffice;

use App\Models\Office;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class DeleteOffice extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $office = Office::where('id', $dto['office_id'])->first();

        if (empty($office)) {
            $this->results['success'] = false;
            $this->results['response_code'] = 404;
            $this->results['message'] = 'Office Not Found';
            $this->results['data'] = [];
        } else {
            $office->delete();

            $this->results['success'] = true;
            $this->results['response_code'] = 200;
            $this->results['message'] = 'Office Successfully Deleted';
            $this->results['data'] = $office;
        }
    }
}
