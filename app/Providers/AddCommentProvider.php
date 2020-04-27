<?php

namespace App\Providers;

use App\Service\AddComment;
use Illuminate\Support\ServiceProvider;

class AddCommentProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AddComment::class, function () {
            return new AddComment();
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
