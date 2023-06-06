<?php

namespace App\Services\Backend\FileStorage;

use App\Models\FileStorage;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class StoreToFileStorage extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $store_to_file_storage = FileStorage::create([
            'file_size' => $dto['file_size'],
            'file_driver' => $dto['file_driver'],
            'file_extension' => $dto['file_extension'],
            'file_original_name' => $dto['file_original_name'],
            'file_name' => $dto['file_name'],
            'file_path' => $dto['file_path'],
            'file_type' => $dto['file_type'],
            'file_url' => $dto['file_url'],
            'is_used' => $dto['is_used'],
        ]);

        $this->results['response_code'] = 200;
        $this->results['success'] = true;
        $this->results['message'] = 'Successfully Stored';
        $this->results['data'] = ['file_storage_id' => $store_to_file_storage->id];
    }
}
