<?php

namespace App\Services\Backend\MasterQR;

use App\Models\QR;
use App\Models\QrContactType;
use App\Models\User;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;
use Illuminate\Support\Str;

class CreateQR extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $qr_contact_type_model = QrContactType::where('format_link', $dto['redirect_link'])->first();
        
        if (empty($qr_contact_type_model)) {
            $qrcode_model = QR::create([
                'qr_contact_type_id' => $dto['qr_contact_type_id'],
                'user_id' => $dto['user_id'],
                'redirect_link' => ($dto['qr_contact_type_id'] == 1) ? $dto['redirect_link'] : whatsappNumberFormatter($dto['redirect_link']),
                'usage_limit' => $dto['usage_limit'],
                'status' => $dto['status'],
            ]);
    
            $user = User::where('id', $dto['user_id'])->first();
    
            $make_slug = Str::slug($user->employee->name);
    
            $builder = new \AshAllenDesign\ShortURL\Classes\Builder();
            $builder->destinationUrl($qrcode_model['redirect_link'])->urlKey($make_slug)->make();
    
            $this->results['response_code'] = 200;
            $this->results['success'] = true;
            $this->results['message'] = 'QR Successfully Created';
            $this->results['data'] = $qrcode_model;
        } else {
            $this->results['response_code'] = 403;
            $this->results['success'] = false;
            $this->results['message'] = 'Please Input Correct Redirect Link';
            $this->results['data'] = [];
        }
    }
}
