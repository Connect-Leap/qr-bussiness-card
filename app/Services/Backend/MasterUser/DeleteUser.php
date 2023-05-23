<?php

namespace App\Services\Backend\MasterUser;

use App\Models\User;
use App\Services\BaseService;
use App\Services\BaseServiceInterface;

class DeleteUser extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $user = User::where('id', $dto['user_id'])->first();

        if (empty($user)) {

            $this->results['success'] = false;
            $this->results['response_code'] = 404;
            $this->results['message'] = 'User Not Found';
            $this->results['data'] = [];

        } else {

            $user->delete();

            $this->results['success'] = true;
            $this->results['response_code'] = 200;
            $this->results['message'] = 'User Successfully Deleted';
            $this->results['data'] = $user;

        }
    }
}
