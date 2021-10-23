<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Intrinio extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'intrinio';
    }
}
