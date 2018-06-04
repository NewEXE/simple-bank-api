<?php

namespace App\Providers;

use App\Services\InternalApi;
use Illuminate\Support\ServiceProvider;

class InternalApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('internal_api', function () {
            return new InternalApi();
        });
    }
}
