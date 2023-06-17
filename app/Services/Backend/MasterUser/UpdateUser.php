<?php

namespace App\Services\Backend\MasterUser;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\UserEmployee;
use App\Models\UserPosition;
use App\Services\BaseService;
use App\Models\UserDepartment;
use App\Models\UserSupervisor;
use App\Models\UserNationality;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\BaseServiceInterface;

class UpdateUser extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        DB::beginTransaction();

        try {
            $created_user = User::where('id', $dto['user_id'])->update([
                'office_id' => $dto['office_id'],
                'email' => $dto['email'],
                'gender' => $dto['gender'],
                'phone_number' => $dto['phone_number'] ?? null,
            ]);

            if ($dto['role'] == 'supervisor') {
                UserSupervisor::where('user_id', $dto['user_id'])->update([
                    'name' => $dto['name']
                ]);
            } elseif ($dto['role'] == 'employee') {
                UserEmployee::where('user_id', $dto['user_id'])->update([
                    'name' => $dto['name'],
                    'employee_code' => $dto['employee_code']
                ]);
            }

            UserDepartment::where('user_id', $dto['user_id'])->update([
                'name' => $dto['department_name'],
            ]);

            UserPosition::where('user_id', $dto['user_id'])->update([
                'name' => $dto['user_position'],
                'period' => $dto['user_position_period']
            ]);

            UserNationality::where('user_id', $dto['user_id'])->update([
                'country_name' => ucwords($dto['country_name']),
                'country_code' => ucwords($dto['country_code']),
                'country_phone_code' => $dto['country_phone_code']
            ]);

            DB::commit();
        } catch (\Exception $err) {
            dd($err->getMessage());
            DB::rollback();

            $this->results['success'] = false;
            $this->results['response_code'] = $err->getCode();
            $this->results['message'] = $err->getMessage();
            $this->results['data'] = [];
        }

        $this->results['success'] = true;
        $this->results['response_code'] = 200;
        $this->results['message'] = 'User Successfully Updated';
        $this->results['data'] = $created_user;

    }
}
