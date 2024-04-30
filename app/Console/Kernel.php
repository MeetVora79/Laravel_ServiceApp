<?php

namespace App\Console;


use Illuminate\Console\Scheduling\Schedule as Scheduler;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\ServiceCron::class,
        Commands\MaintenanceServiceCron::class,
    ];


    /**
     * Define the application's command schedule.
     */
    protected function schedule(Scheduler $schedule)
    {
        $schedule->command('test:cron')->everyMinute();
        $schedule->command('maintenance:cron')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }

}
