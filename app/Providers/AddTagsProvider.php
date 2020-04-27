<?php

namespace App\Providers;

use App\Service\AddTags;
use Illuminate\Support\ServiceProvider;

class AddTagsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AddTags::class, function () {
            return new AddTags();
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
