<?php

namespace App\Services;

use App\Services\BaseServiceInterface;

abstract class BaseService implements BaseServiceInterface
{
    protected $results;

    public function __construct()
    {
        $this->results = ['success' => null, 'response_code' => null, 'message' => null, 'data' => null];
    }

    abstract protected function process( $data );

    public function execute( $input_data = null )
    {
        $this->process($input_data);

        return $this->results;
    }
}
