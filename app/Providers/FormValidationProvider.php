<?php

namespace App\Providers;

use App\Service\FormValidation;
use Illuminate\Support\ServiceProvider;

class FormValidationProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FormValidation::class, function () {
            return new FormValidation();
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
