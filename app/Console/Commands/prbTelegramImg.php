<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use App\Notifications\LaravelTelegramImgNotification;
use TelegramNotifications\Messages\TelegramMessage;
use TelegramNotifications\TelegramChannel;


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
        $user->notify(new LaravelTelegramImgNotification([
            'text' => "Como has estado!",
            'photo' => 'https://codezen.io/wp-content/uploads/2020/03/Telegram-Notifications-In-Laravel.jpg',
            'photo_caption' => 'Telegram Notifications in Laravel'
        ]));
        
    }
}
