<?php
/*
 * This file is part of the Laravel-Modx package.
 *
 * (c) Giorgos Mylonas <mylgeorge@gmail.com>
 *
 */

namespace Modx\Providers;

use Illuminate\Support\ServiceProvider;
use Modx\ModxHasher;

class ModxHashServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('modx_hash', function () {
            return new ModxHasher;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['modx_hash'];
    }

}