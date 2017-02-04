<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Auth\AuthLogic', 'App\Services\Auth\JWTAuthLogic');        
    }
}