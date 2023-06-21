<?php

namespace App\Services\Backend\MasterUser;

use App\Models\User;
use App\Models\UserDepartment;
use App\Models\UserEmployee;
use App\Models\UserNationality;
use App\Models\UserPosition;
use Illuminate\Support\Str;
use App\Services\BaseService;
use App\Models\UserSupervisor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\BaseServiceInterface;

class CreateUser extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        DB::beginTransaction();

        try {
            $created_user = User::create([
                'office_id' => $dto['office_id'],
                'email' => $dto['email'],
                'password' => Hash::make($dto['password']),
                'role' => $dto['role'],
                'gender' => $dto['gender'],
                'remember_token' => Str::random(10),
                'phone_number' => $dto['phone_number'],
            ]);

            if ($dto['role'] == 'supervisor') {
                UserSupervisor::create([
                    'user_id' => $created_user->id,
                    'name' => $dto['name']
                ]);
                $created_user->assignRole('supervisor');
                $created_user->givePermissionTo(array_intersect(config('permission.list-permission'), [
                    // Profile
                    'show-profile',
                    'update-profile',
                    // Office
                    'show-detail-office',
                    // Employee
                    'show-employee',
                    'create-employee',
                    'store-employee',
                    'edit-employee',
                    'update-employee',
                    'delete-employee',
                    // Qr
                    'show-qr',
                    'show-detail-qr',
                    'create-qr',
                    'create-qr-vcard',
                    'store-qr',
                    'store-qr-vcard',
                    'delete-qr',
                    'reset-specified-qr',
                    'reset-all-qr',
                    // Card Simulator
                    'show-find-card-simulator',
                    'show-card-simulator-page',
                    // Application Setting
                    'show-application-setting',
                    // Information Setting
                    'show-information-setting',
                ]));
            } elseif ($dto['role'] == 'employee') {
                UserEmployee::create([
                    'user_id' => $created_user->id,
                    'name' => $dto['name'],
                    'employee_code' => $dto['employee_code']
                ]);
                $created_user->assignRole('employee');
                $created_user->givePermissionTo(array_intersect(config('permission.list-permission'), [
                    // Profile
                    'show-profile',
                    'update-profile',
                ]));
            }

            UserDepartment::create([
                'user_id' => $created_user->id,
                'name' => $dto['department_name'],
            ]);

            UserPosition::create([
                'user_id' => $created_user->id,
                'name' => $dto['user_position'],
                'period' => $dto['user_position_period']
            ]);

            UserNationality::create([
                'user_id' => $created_user->id,
                'country_name' => ucwords($dto['country_name']),
                'country_code' => ucwords($dto['country_code']),
                'country_phone_code' => $dto['country_phone_code']
            ]);

            DB::commit();
        } catch (\Exception $err) {
            DB::rollback();

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
