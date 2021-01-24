<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        User::created(function($model) {
            $model->setPublicSlug();
        });

        if(env('APP_SECURE')) {
            $url->forceScheme('https');
        }
    }
}
