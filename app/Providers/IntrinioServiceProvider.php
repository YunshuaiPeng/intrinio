<?php

namespace App\Providers;

use App\Services\IntrinioService;
use Illuminate\Support\ServiceProvider;

class IntrinioServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('intrinio', function ($app) {
            return new IntrinioService(
                config('intrinio.key'),
            );
        });
    }

    public function boot()
    {
        //
    }
}
