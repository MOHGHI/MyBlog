<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPostCreatedNotification
{

    /**
     * Handle the event.
     *
     * @param  PostCreated  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
//        \Mail::to(env('ADMIN_EMAIL'))->send(
//          new \App\Mail\PostCreated($event->post)
//        );
    }
}
