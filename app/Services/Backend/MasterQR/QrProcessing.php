<?php

namespace App\Services\Backend\MasterQR;

use App\Models\QR;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;
use AshAllenDesign\ShortURL\Models\ShortURL;

class QrProcessing extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $qr_model = QR::where('id', $dto['qr_id'])->first();

        if ($qr_model->usage_limit >= 1) {
            $qr_model->update([
                'usage_limit' => ($qr_model->usage_limit - 1),
                'status' => VALID
            ]);

            $short_url_model = ShortURL::where('destination_url', $qr_model->redirect_link)->first();

            $this->results['response_code'] = 302;
            $this->results['success'] = true;
            $this->results['message'] = 'Redirect Sucecssfully';
            $this->results['data'] = [
                'destination' => $short_url_model->destination_url
            ];
        } elseif ($qr_model->usage_limit == 0) {
            $qr_model->update([
                'status' => INVALID
            ]);

            $this->results['response_code'] = 302;
            $this->results['success'] = false;
            $this->results['message'] = 'Redirect To Office Admin';
            $this->results['data'] = [
                'destination' => env('DEFAULT_ADMIN_WHATSAPP_CONTACT_URL')
            ];
        }
    }
}
