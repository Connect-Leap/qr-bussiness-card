<?php

namespace App\Services\Backend\MasterQR;

use App\Models\QR;
use App\Models\User;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;
use JeroenDesloovere\VCard\VCard;
use Illuminate\Support\Str;

class CreateQRVCard extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $user = User::where('id', $dto['user_id'])->first();

        $vcard_process = $this->VCard(
            $user->employee->name,
            $user->office->name,
            $user->position->name,
            ucfirst($user->role),
            $user->email,
            $user->phone_number
        );
        $create_qr = QR::create([
            'qr_contact_type_id' => $dto['qr_contact_type_id'],
            'user_id' => $dto['user_id'],
            'vcard_string' => $vcard_process,
            'usage_limit' => $dto['usage_limit'],
            'status' => $dto['status'],
        ]);

        $this->results['response_code'] = 200;
        $this->results['success'] = true;
        $this->results['message'] = 'QR Successfully Created';
        $this->results['data'] = $create_qr;

    }

    private function VCard(
        $input_first_name,
        $input_company,
        $input_jobtitle,
        $input_role,
        $input_email,
        $input_phonenumber,
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

        // $vcard->addPhoto(__DIR__ . '/landscape.jpeg');

        // save vcard on disk
        // $vcard->setSavePath('/path/to/directory');
        // $vcard->save();

        return $result['vcard_string'] = $vcard->getOutput();

        // return vcard as a download
        // return $vcard->download();
    }
}
