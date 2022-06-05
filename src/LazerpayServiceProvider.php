<?php

/*
 *
 * (c) Muhideen Mujeeb Adeoye <mujeeb.muhideen@gmail.com>
 *
 */

namespace Mujhtech\Lazerpay;

use Illuminate\Support\ServiceProvider;

class LazerpayServiceProvider extends ServiceProvider
{

    /*
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('laravel-lazerpay', function () {

            return new Lazerpay;

        });
    }

    /**
     * Publishes all the config file this package needs to function
     */

    public function boot()
    {
        $config = realpath(__DIR__ . '/../config/lazerpay.php');

        $this->publishes([
            $config => config_path('lazerpay.php'),
        ]);
    }

    /**
     * Get the services provided by the provider
     * @return array
     */

    public function provides()
    {
        return ['laravel-lazerpay'];
    }

}
