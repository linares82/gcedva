<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use App\Notifications\LaravelTelegramNotification;

class prbTelegramImg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:ToTelegramImg';

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
        $user=User::find(1);
        $user->notify(new LaravelTelegramNotification([
            'text' => "Como has estado!"
            'photo'=>
            'photo_caption'=>
        ]));
    }
}
