<?php

namespace App\Console\Commands;

use App\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sendpost {from} {to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = \App\User::all();
        try {
            $from = Carbon::parse($this->argument('from'));
            $to = Carbon::parse($this->argument('to'));
            $posts = Post::where('published', false)->whereBetween('created_at',[$from, $to])->latest()->get();
            $users->map->notify(new \App\Notifications\SendPost($posts));
        } catch (\Exception $e) {
            $this->error('Wrong date format. It must be dd-mm-yyyy');
        }
    }
}
