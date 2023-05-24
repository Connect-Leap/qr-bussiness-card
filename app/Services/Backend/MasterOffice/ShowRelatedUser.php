<?php

namespace App\Services\Backend\MasterOffice;

use App\Models\Office;
use App\Models\User;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class ShowRelatedUser extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $user = User::where('office_id', $dto['office_id'])->whereIn('role', ['supervisor', 'employee'])->latest()->get();
        $office = Office::where('id', $dto['office_id'])->first();

        if ($user->count() < 1) {
            $this->results['success'] = false;
            $this->results['response_code'] = 404;
            $this->results['message'] = 'User Not Found';
            $this->results['data'] = [
                'users' => [],
                'user_total' => $user->count(),
                'user_supervisor_total' => User::where('office_id', $dto['office_id'])->where('role', 'supervisor')->count(),
                'user_employee_total' => User::where('office_id', $dto['office_id'])->where('role', 'employee')->count(),
                'office' => $office,
            ];
        } else {
            $this->results['success'] = true;
            $this->results['response_code'] = 200;
            $this->results['message'] = 'Successfully Get User Data';
            $this->results['data'] = [
                'users' => $user,
                'user_total' => $user->count(),
                'user_supervisor_total' => User::where('office_id', $dto['office_id'])->where('role', 'supervisor')->count(),
                'user_employee_total' => User::where('office_id', $dto['office_id'])->where('role', 'employee')->count(),
                'office' => $office,
            ];
        }
    }
}
