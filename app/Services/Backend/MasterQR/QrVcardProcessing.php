<?php

namespace App\Services\Backend\MasterQR;

use App\Services\BaseService;
use App\Models\ApplicationSetting;
use App\Models\QR;
use App\Models\QrVisitor;
use App\Services\BaseServiceInterface;

class QrVcardProcessing extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $qr_model = QR::where('id', $dto['qr_id'])->first();

        if (!empty($qr_model)) {
            $qr_visitor_model = QrVisitor::create([
                'qr_id' => $qr_model->id,
                'ip_address' => $dto['qr_visitor_data']['visitor_location_data']['ip_address'],
                'detail_visitor_json' => json_encode($dto['qr_visitor_data'])
            ]);

            if ($qr_model->usage_limit >= 1 && $qr_model->status == VALID) {
                $get_qr_pivot_content = $qr_model->fileStorage()->first();

                $qr_model->update([
                    'usage_limit' => ($qr_model->usage_limit - 1),
                    'status' => VALID
                ]);

                $this->results['response_code'] = 302;
                $this->results['success'] = true;
                $this->results['message'] = 'Redirect Sucecssfully';
                $this->results['data'] = [
                    'destination' => $get_qr_pivot_content->file_url,
                    'qr_visitor' => $qr_visitor_model,
                    'qr_data' => $qr_model,
                ];
            } elseif ($qr_model->usage_limit == 0 && $qr_model->status == VALID) {
                $qr_model->update([
                    'status' => INVALID
                ]);

                $this->results['response_code'] = 302;
                $this->results['success'] = false;
                $this->results['message'] = 'Redirect To Office Admin';
                $this->results['data'] = [
                    'destination' => env('DEFAULT_ADMIN_WHATSAPP_CONTACT_URL'),
                    'qr_visitor' => $qr_visitor_model
                ];
            } else {
                $this->results['response_code'] = 302;
                $this->results['success'] = false;
                $this->results['message'] = 'Redirect To Office Admin';
                $this->results['data'] = [
                    'destination' => env('DEFAULT_ADMIN_WHATSAPP_CONTACT_URL'),
                    'qr_visitor' => $qr_visitor_model
                ];
            }
        } else {
            $this->results['response_code'] = 302;
            $this->results['success'] = false;
            $this->results['message'] = 'Redirect To Office Admin';
            $this->results['data'] = [
                'destination' => env('DEFAULT_ADMIN_WHATSAPP_CONTACT_URL')
            ];
        }
    }
}
