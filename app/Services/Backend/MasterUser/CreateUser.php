<?php

namespace App\Services\Backend\MasterUser;

use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use App\Services\BaseServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateUser extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        DB::beginTransaction();

        try {
            $user = new User();

            $created_user = $user->create([
                'email' => $dto['email'],
                'password' => Hash::make($dto['password']),
                'role' => $dto['role'],
                'gender' => $dto['gender'],
                'remember_token' => Str::random(10)
            ]);

            switch ($dto['role']) {

                case 'supervisor':
                    $user->supervisor()->create([
                        'user_id' => $created_user->id,
                        'name' => $dto['name']
                    ]);

                    $created_user->assignRole('supervisor');

                    break;
                case 'employee':
                    $user->employee()->create([
                        'user_id' => $created_user->id,
                        'name' => $dto['name'],
                        'employee_code' => $dto['employee_code']
                    ]);

                    $created_user->assignRole('employee');

                    break;
            }

            $user->department()->create([
                'user_id' => $created_user->id,
                'name' => $dto['department_name'],
            ]);

            $user->position()->create([
                'user_id' => $created_user->id,
                'name' => $dto['user_position'],
                'period' => $dto['user_position_period']
            ]);

            $user->nationality()->create([
                'user_id' => $created_user->id,
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
        $this->results['data'] = $created_user;

    }
}
