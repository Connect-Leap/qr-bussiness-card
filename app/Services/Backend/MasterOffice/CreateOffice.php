<?php

namespace App\Services\Backend\MasterOffice;

use App\Models\Office;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class CreateOffice extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $office = Office::create([
            'name' => ucwords($dto['name']),
            'address' => $dto['address'],
            'email' => $dto['email'],
            'contact' => $dto['contact'],
        ]);

        $this->results['success'] = true;
        $this->results['response_code'] = 200;
        $this->results['message'] = 'Office Successfully Created';
        $this->results['data'] = $office;
    }
}
