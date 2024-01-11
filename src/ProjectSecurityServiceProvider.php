<?php

namespace Shumonpal\ProjectSecurity;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Shumonpal\ProjectSecurity\Listeners\NotifyIfNotLicencedListener;

class ProjectSecurityServiceProvider extends ServiceProvider
{

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__. '/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->mergeConfigFrom(
            __DIR__.'/../config/app-licence.php', 'app-licence'
        );
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'shumonpal');

        $this->publishes([
            __DIR__.'/../config/app-licence.php' => config_path('app-licence.php'),
        ], 'app-licence-config');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->booting(function () {            
            Event::listen(Login::class , NotifyIfNotLicencedListener::class);
        });
    }


}