<?php

namespace iProtek\Data;

use Illuminate\Support\ServiceProvider;

class iProtekServiceDataProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register package services
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Bootstrap package services
        
        //$this->publishes([
        //    __DIR__.'/../database/migrations' => database_path('migrations'),
        //], 'migrations');

        
        /*
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/iprotek'),
        ], 'public');
        */ 
 
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'iprotek_data');
 
    }
}