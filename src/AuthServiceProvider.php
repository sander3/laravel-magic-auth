<?php

namespace Soved\Laravel\Magic\Auth;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->registerTranslations();
    }

    /**
     * Register the magic authentication routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group([
            'prefix'     => config('magic-auth.uri'),
            'namespace'  => 'Soved\Laravel\Magic\Auth\Http\Controllers',
            'middleware' => 'web',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    /**
     * Register the magic authentication translations.
     *
     * @return void
     */
    protected function registerTranslations()
    {
        $this->loadTranslationsFrom(
            __DIR__ . '/../resources/lang', 'magic-auth'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();
        $this->offerPublishing();
    }

    /**
     * Setup the configuration for magic authentication.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/magic-auth.php', 'magic-auth'
        );
    }

    /**
     * Setup the resource publishing groups for magic authentication.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/magic-auth.php' => config_path('magic-auth.php'),
            ], 'magic-auth-config');

            $this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/magic-auth'),
            ], 'magic-auth-lang');
        }
    }
}
