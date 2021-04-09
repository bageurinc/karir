<?php

namespace Bageur\Karir;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Bageur\Karir\Controllers\LowonganController');
        $this->app->make('Bageur\Karir\Controllers\PerusahaanController');
        $this->app->make('Bageur\Karir\Controllers\KarirMembersController');
        $this->app->make('Bageur\Karir\Controllers\LamaranController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/migration');
    }
}
