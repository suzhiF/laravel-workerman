<?php

namespace Suzhif\LaravelWorkerman;

use Illuminate\Support\ServiceProvider;
use Suzhif\LaravelWorkerman\Commands\WorkermanCommand;
use Suzhif\LaravelWorkerman\Handler\GatewayHandler;

class WorkermanServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([WorkermanCommand::class]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/workerman.php' => config_path('workerman.php')
        ]);
    }
}
