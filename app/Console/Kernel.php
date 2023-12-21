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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        info("sheduler executed");
        // $schedule->command('app:list_all_emails')->everyMinute();

        // $schedule->call(function () {
        //     info("scheduled");
        // })->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        $this->load(__DIR__ . '/../../packages/Webkul/Core/src/Console/Commands');
        $this->load(__DIR__ . '/../../packages/Webkul/Email/src/Console/Commands');

        require base_path('routes/console.php');
    }
}
