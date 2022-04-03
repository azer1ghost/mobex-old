<?php

namespace App\Console;

use App\Console\Commands\AzerpostPaidStatus;
use App\Console\Commands\Campaign;
use App\Console\Commands\Cashback;
use App\Console\Commands\CustomSystem;
use App\Console\Commands\Daily;
use App\Console\Commands\SendNotification;
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
        AzerpostPaidStatus::class,
        SendNotification::class,
        Daily::class,
        Campaign::class,
        Cashback::class,
        CustomSystem::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
