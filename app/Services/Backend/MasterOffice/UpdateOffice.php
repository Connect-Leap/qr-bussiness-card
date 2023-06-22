<?php

namespace App\Services\Backend\MasterOffice;

use App\Models\Office;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class UpdateOffice extends BaseService implements BaseServiceInterface
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
            $office->name = $dto['name'];
            $office->address = $dto['address'];
            $office->email = $dto['email'];
            $office->contact = $dto['contact'];
            $office->company_link = $dto['company_link'];
            $office->save();

            $this->results['success'] = true;
            $this->results['response_code'] = 200;
            $this->results['message'] = 'Office Successfully Updated';
            $this->results['data'] = $office;
        }
    }
}
