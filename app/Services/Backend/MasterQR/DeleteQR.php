<?php

namespace App\Services\Backend\MasterQR;

use App\Models\FileStorage;
use App\Models\QR;
use App\Models\QrFileStorage;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;
use AshAllenDesign\ShortURL\Models\ShortURL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteQR extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        DB::beginTransaction();

        try {
            $qr_model = QR::where('id', $dto['qr_id'])->first();

            if (empty($qr_model)) {

                $this->results['response_code'] = 404;
                $this->results['success'] = false;
                $this->results['message'] = 'QR Not Found';
                $this->results['data'] = [];

            } else {

                if (!is_null($qr_model->redirect_link)) {
                    $short_url = ShortURL::where('destination_url', $qr_model->redirect_link)->first();

                    $short_url->delete();
                }

                // Delete Relation Records
                $qr_pivot_model = QrFileStorage::where('qr_id', $qr_model->id)->get();

                foreach($qr_pivot_model as $qr_pivot_data) {
                    FileStorage::where('id', $qr_pivot_data->file_storage_id)->delete();
                }

                // Delete Pivot Records
                $qr_model->fileStorage()->detach();

                // Delete Selected Qr Record
                $qr_model->delete();

                DB::commit();

                $this->results['response_code'] = 200;
                $this->results['success'] = true;
                $this->results['message'] = 'QR Deleted Successfully';
                $this->results['data'] = $qr_model;

            }
        } catch (\Exception $err) {

            DB::rollBack();

            $this->results['response_code'] = $err->getCode();
            $this->results['success'] = false;
            $this->results['message'] = $err->getMessage();
            $this->results['data'] = [];

        }
    }
}
