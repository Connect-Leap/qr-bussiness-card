<?php

namespace App\Services\Backend\MasterQR;

use App\Models\FileStorage;
use App\Models\QR;
use App\Models\QrFileStorage;
use App\Models\User;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use JeroenDesloovere\VCard\VCard;
use Illuminate\Support\Str;
use App\Traits\QrFileStorageTrait;

class CreateQRVCard extends BaseService implements BaseServiceInterface
{
    use QrFileStorageTrait;

    public function process($dto)
    {
        $user = User::where('id', $dto['user_id'])->first();

        DB::beginTransaction();

        try {
            $vcard_process = $this->VCard(
                $user->employee->name,
                $user->office->name,
                $user->position->name,
                ucfirst($user->role),
                $user->email,
                $user->phone_number,
                $user->office->company_link ?? null,
            );

            $create_qr = QR::create([
                'qr_contact_type_id' => $dto['qr_contact_type_id'],
                'user_id' => $dto['user_id'],
                'vcard_string' => $vcard_process['vcard_string'],
                'usage_limit' => $dto['usage_limit'],
                'status' => $dto['status'],
            ]);

            $qr_file_storage_trait = $this->storeQrToStorageDisk(route('master-qr.qr-vcard-processing', [
                'qr_id' => $create_qr['id']
            ]));

            $file_storage_data_array = array(
                [
                    'file_size' => 1,
                    'file_driver' => config('filesystems.default'),
                    'file_extension' => $vcard_process['vcard_extension'],
                    'file_original_name' => $vcard_process['vcard_filename'],
                    'file_name' => $vcard_process['vcard_filename'],
                    'file_path' => 'storage/app/public/vcard/',
                    'file_type' => 'vcard/vcf',
                    'file_url' => storageLinkFormatter('storage/vcard', $vcard_process['vcard_filename'], $vcard_process['vcard_extension']),
                    'is_used' => USED,
                ],
                [
                    'file_size' => 24000,
                    'file_driver' => config('filesystems.default'),
                    'file_extension' => $qr_file_storage_trait['extension'],
                    'file_original_name' => $qr_file_storage_trait['output_file'],
                    'file_name' => $qr_file_storage_trait['output_file'],
                    'file_path' => 'storage/app/public/qr-code/',
                    'file_type' => 'image/png',
                    'file_url' => storageLinkFormatter('storage/qr-code', $qr_file_storage_trait['filename'], $qr_file_storage_trait['extension']),
                    'is_used' => USED,
                ]
            );

            foreach($file_storage_data_array as $file_storage_data) {
                $store_to_file_storage = app('StoreToFileStorage')->execute($file_storage_data);

                $store_to_pivot = QrFileStorage::create([
                    'qr_id' => $create_qr->id,
                    'file_storage_id' => $store_to_file_storage['data']['file_storage_id'],
                ]);
            }

            DB::commit();

            $this->results['response_code'] = 200;
            $this->results['success'] = true;
            $this->results['message'] = 'QR Successfully Created';
            $this->results['data'] = [
                'qr' => $create_qr,
                'pivot' => $store_to_pivot,
                'file_storage' => $store_to_file_storage
            ];
        } catch (\Exception $err) {

            DB::rollBack();

            $this->results['response_code'] = $err->getCode();
            $this->results['success'] = false;
            $this->results['message'] = $err->getMessage();
            $this->results['data'] = [];
        }
    }

    private function VCard(
        $input_first_name,
        $input_company,
        $input_jobtitle,
        $input_role,
        $input_email,
        $input_phonenumber,
        $input_url = null,
    ) {

        $result['vcard_string'] = null;

        // define vcard
        $vcard = new VCard();

        // define variables
        $lastname = '';
        $firstname = $input_first_name;
        $additional = '';
        $prefix = '';
        $suffix = '';

        // add personal data
        $vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);

        // add work data
        $vcard->addCompany($input_company);
        $vcard->addJobtitle($input_jobtitle);
        $vcard->addRole($input_role);
        $vcard->addEmail($input_email);
        $vcard->addPhoneNumber($input_phonenumber, 'WORK');
        if(!is_null($input_url)) {
            $vcard->addURL($input_url);
        }

        // save vcard on disk
        $vcard->setSavePath(storage_path('app/public/vcard'));
        $vcard->save();

        $result['vcard_string'] = $vcard->getOutput();
        $result['vcard_extension'] = $vcard->getFileExtension();
        $result['vcard_filename'] = $vcard->getFilename();

        return $result;

        // return vcard as a download
        // return
    }
}
