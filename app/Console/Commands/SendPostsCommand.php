<?php

namespace App\Console\Commands;

use App\Post;
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
        if(date_parse($this->argument('from'))['error_count'] == 0 &&
            date_parse($this->argument('to'))['error_count'] == 0) {
            $from = $this->argument('from');
            $to = $this->argument('to');
            $posts = Post::where([
                ['published', true],
                ['created_at','>=', $from],
                ['created_at','<=', $to],
            ])->latest()->get();
            $users->map->notify(new \App\Notifications\SendPost($posts));
        } else {
            $this->error('Wrong date format. It must be dd-mm-yyyy');
        }

    }
}
