<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class IntrinioService
{
    protected string $key;

    protected Http $http;

    public function __construct(string $key)
    {
        $this->key = $key;
    }
}
