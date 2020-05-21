<?php

namespace App\Console;

use App\Console\Commands\CoronaDaily;
use App\Console\Commands\CoronaUpdates;
use App\Console\Commands\CoronaWeekly;
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
        CoronaDaily::class,
        CoronaUpdates::class,
        CoronaWeekly::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('corona:daily')->everyMinute();
        $schedule->command('corona:weekly')->everyMinute();
        $schedule->command('corona:updates')->everyMinute();
        $schedule->command('corona:totalSummary')->everyMinute();
        //$schedule->command('corona:confirmed')->everyMinute();
        //$schedule->command('corona:deaths')->everyMinute();
        //$schedule->command('corona:recovered')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
