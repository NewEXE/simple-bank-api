<?php

namespace App\Providers;

use App\Models\User;
use App\Services\InternalApi;
use Illuminate\Support\ServiceProvider;

class InternalApiServiceProvider extends ServiceProvider
{
    /**
     * @var User
     */
    protected $user;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (\Schema::hasTable('users')) {
            $this->user = User::findOrFail(1);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('internal_api', function () {
            return new InternalApi($this->user);
        });
    }
}
