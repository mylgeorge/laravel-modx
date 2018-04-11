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
use Modx\Models\modUser;
use Modx\ModxHasher;

class ModxServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->runningInConsole() || !config('modx.boot')) return;

        $singleton = $this->app->make(ModxCMS::class);

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
        $this->registerConfig();

        $this->app['auth']->provider('modx_user_provider', function($app, array $config) {
            return new ModxUserProvider(new ModxHasher, modUser::class);
        });

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

    protected function registerConfig()
    {
        $this->mergeConfigFrom(realpath(__DIR__.'/../../../config/modx.php'), 'modx');
        $this->publishes([realpath(__DIR__.'/../../../config/modx.php') => config_path('modx.php')]);
    }
}