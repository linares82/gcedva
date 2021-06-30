<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ActivarBs::class,
        Commands\CargaRemota::class,
        Commands\EnviarCorreos::class,
        Commands\EnviarSms::class,
        Commands\AlertaFinContrato::class,
        Commands\Imap::class,
        Commands\CambiarEstatus::class,
        Commands\EnvioSmsMail::class,
        Commands\AtrazoPagos::class,
        Commands\PrbEmail::class,
        Commands\IANMatricula::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        //$schedule->command('backup:mysql-dump')->dailyAt('14:00');
        //$schedule->command('ian:FinContratos')->dailyAt('23:00');

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
