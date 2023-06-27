<?php

namespace App\Services\Backend\MasterQR;

use App\Models\QR;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\QrContactType;
use App\Models\QrFileStorage;
use App\Services\BaseService;
use App\Traits\QrFileStorageTrait;
use App\Traits\SocialMediaFormatAudit;
use Illuminate\Support\Facades\DB;
use App\Services\BaseServiceInterface;

class CreateQR extends BaseService implements BaseServiceInterface
{
    use QrFileStorageTrait, SocialMediaFormatAudit;

    public function process($dto)
    {
        DB::beginTransaction();
        try {
            $qr_contact_type_model = QrContactType::where('format_link', $dto['redirect_link'])->first();
            $social_media_auditor = $this->socialMediaFormatAudit($dto['qr_contact_type_id'], $dto['redirect_link']);

            if (!$social_media_auditor) {
                $this->results['response_code'] = 403;
                $this->results['success'] = false;
                $this->results['message'] = 'Please enter the link according to the selected contact type';
                $this->results['data'] = [];
            } elseif (empty($qr_contact_type_model)) {
                $qrcode_model = QR::create([
                    'qr_contact_type_id' => $dto['qr_contact_type_id'],
                    'user_id' => $dto['user_id'],
                    'redirect_link' => ($dto['qr_contact_type_id'] == LINKEDIN || $dto['qr_contact_type_id'] == OTHER) ? $dto['redirect_link'] : whatsappNumberFormatter($dto['redirect_link']),
                    'usage_limit' => $dto['usage_limit'],
                    'status' => $dto['status'],
                ]);

                $user = User::where('id', $dto['user_id'])->first();

                $make_slug = Str::slug($user->employee->name);

                $builder = new \AshAllenDesign\ShortURL\Classes\Builder();
                $builder->destinationUrl($qrcode_model['redirect_link'])->urlKey($make_slug)->make();

                $qr_file_storage_trait = $this->storeQrToStorageDisk(route('master-qr.qr-processing', [
                    'urlkey' => $make_slug,
                    'qr_id' => $qrcode_model['id'],
                ]));

                $store_to_file_storage = app('StoreToFileStorage')->execute([
                    'file_size' => 24000,
                    'file_driver' => config('filesystems.default'),
                    'file_extension' => $qr_file_storage_trait['extension'],
                    'file_original_name' => $qr_file_storage_trait['output_file'],
                    'file_name' => $qr_file_storage_trait['output_file'],
                    'file_path' => 'storage/app/public/qr-code/',
                    'file_type' => 'image/png',
                    'file_url' => storageLinkFormatter('storage/qr-code', $qr_file_storage_trait['filename'], $qr_file_storage_trait['extension']),
                    'is_used' => USED,
                ]);

                $store_to_pivot = QrFileStorage::create([
                    'qr_id' => $qrcode_model['id'],
                    'file_storage_id' => $store_to_file_storage['data']['file_storage_id'],
                ]);

                DB::commit();

                $this->results['response_code'] = 200;
                $this->results['success'] = true;
                $this->results['message'] = 'QR Successfully Created';
                $this->results['data'] = [
                    'qr' => $qrcode_model,
                    'pivot' => $store_to_pivot,
                    'file_storage' => $store_to_file_storage,
                ];
            } else {
                $this->results['response_code'] = 403;
                $this->results['success'] = false;
                $this->results['message'] = 'Please Input Correct Redirect Link';
                $this->results['data'] = [];
            }
        } catch (\Exception $err) {

            DB::rollback();

            $this->results['response_code'] = $err->getCode();
            $this->results['success'] = false;
            $this->results['message'] = $err->getMessage();
            $this->results['data'] = [];
        }
    }
}
