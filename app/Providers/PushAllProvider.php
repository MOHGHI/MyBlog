<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PushAllProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Service\Pushall::class, function () {
            return new \App\Service\Pushall(config('mohghi.pushall.api.key'), config('mohghi.pushall.api.id'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
