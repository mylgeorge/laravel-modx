<?php
/*
 * This file is part of the Laravel-Modx package.
 *
 * (c) Giorgos Mylonas <mylgeorge@gmail.com>
 *
 */

namespace Modx\Providers;

use Illuminate\Support\ServiceProvider;
use Modx\ModxCMS;

class ModxServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(ModxCMS $singleton)
    {
        global $modx;

        $singleton->initialize('web');

        if (!$singleton->getRequest()) return abort(404);
        $singleton->request->sanitizeRequest();

        $modx = $singleton;

        view()->composer('*', function ($view) use ($singleton) {
            $view->with('modx', $singleton);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ModxCMS::class, function ($app) {
            return new ModxCMS;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ModxCMS::class];
    }

}