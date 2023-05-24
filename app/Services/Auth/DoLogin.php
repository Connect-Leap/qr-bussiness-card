<?php

namespace App\Services\Auth;

use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use App\Services\BaseServiceInterface;

class DoLogin extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        if (Auth::attempt(['email' => $dto['email'], 'password' => $dto['password']])) {

            $this->results['success'] = true;
            $this->results['response_code'] = 200;
            $this->results['message'] = 'Successfully Login';
            $this->results['data'] = ['email' => $dto['email']];


        } else {

            $this->results['success'] = false;
            $this->results['response_code'] = 401;
            $this->results['message'] = 'The provided credentials do not match our records.';
            $this->results['data'] = ['email' => $dto['email']];

        }
    }
}
