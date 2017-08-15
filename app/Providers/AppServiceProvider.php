<?php

namespace App\Providers;

use App\Services\Sms;
use Illuminate\Support\ServiceProvider;
use Services\String;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerString();
        $this->registerSms();
    }

    protected function registerString()
    {
        $this->app->singleton('string', function ($app) {
            return new String();
        });
    }

    /**
     * 短信服务
     */
    protected function registerSms()
    {
        $this->app->singleton('sms', function ($app) {
            return new Sms();
        });
    }
}
