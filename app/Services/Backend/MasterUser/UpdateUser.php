<?php

namespace App\Services\Backend\MasterUser;

use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use App\Services\BaseServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateUser extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $user = new User();

        DB::beginTransaction();

        try {
            $updated_user = $user->find($dto['user_id'])->update([
                'email' => $dto['email'],
                'gender' => $dto['gender'],
            ]);

            switch ($dto['role']) {

                case 'supervisor':
                    $user->supervisor()->where('user_id', $dto['user_id'])->update([
                        'name' => $dto['name']
                    ]);

                    break;
                case 'employee':
                    $user->employee()->where('user_id', $dto['user_id'])->update([
                        'name' => $dto['name'],
                        'employee_code' => $dto['employee_code']
                    ]);

                    break;
            }

            $user->department()->where('user_id', $dto['user_id'])->update([
                'name' => $dto['department_name'],
            ]);

            $user->position()->where('user_id', $dto['user_id'])->update([
                'name' => $dto['user_position'],
                'period' => $dto['user_position_period']
            ]);

            $user->nationality()->where('user_id', $dto['user_id'])->update([
                'country_name' => ucwords($dto['country_name']),
                'country_code' => ucwords($dto['country_code']),
                'country_phone_code' => $dto['country_phone_code']
            ]);
        } catch (\Exception $err) {
            $this->results['success'] = false;
            $this->results['response_code'] = $err->getCode();
            $this->results['message'] = $err->getMessage();
            $this->results['data'] = [];
        }

        $this->results['success'] = true;
        $this->results['response_code'] = 200;
        $this->results['message'] = 'User Successfully Created';
        $this->results['data'] = $updated_user;

    }
}
