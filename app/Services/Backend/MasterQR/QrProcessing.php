<?php

namespace App\Services\Backend\MasterQR;

use App\Models\QR;
use App\Models\QrVisitor;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;
use AshAllenDesign\ShortURL\Models\ShortURL;
use Illuminate\Support\Facades\RateLimiter;
use App\Traits\ClientIp;

class QrProcessing extends BaseService implements BaseServiceInterface
{
    use ClientIp;

    public function process($dto)
    {
        $qr_model = QR::where('id', $dto['qr_id'])->first();

        $qr_visitor_model = QrVisitor::create([
            'qr_id' => $qr_model->id,
            'ip_address' => $dto['qr_visitor_data']['visitor_location_data']['ip_address'],
            'detail_visitor_json' => json_encode($dto['qr_visitor_data'])
        ]);

        RateLimiter::attempt(
            'visitor-ip:'.$this->getIp(),
            $dto['application_setting']['default_rate_limit'],
            function () use($qr_model, $qr_visitor_model) {
                if ($qr_model->usage_limit >= 1 && $qr_model->status == VALID) {
                    $qr_model->update([
                        'usage_limit' => ($qr_model->usage_limit - 1),
                        'status' => VALID
                    ]);
        
                    $short_url_model = ShortURL::where('destination_url', $qr_model->redirect_link)->first();
        
                    $this->results['response_code'] = 302;
                    $this->results['success'] = true;
                    $this->results['message'] = 'Redirect Sucecssfully';
                    $this->results['data'] = [
                        'destination' => $short_url_model->destination_url,
                        'qr_visitor' => $qr_visitor_model
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
            },
            $dto['application_setting']['default_rate_time_limit']
        );
    }
}
