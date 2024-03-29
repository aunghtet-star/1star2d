<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        $schedule->command('backup:run --only-db')->daily();
        $schedule->call(function () {
            DB::table('twos')->where('date', '<', Carbon::parse(now()->subDays(30)->format('Y-m-d')))->delete();
        })->daily();
        $schedule->call(function () {
            DB::table('threes')->where('date', '<', Carbon::parse(now()->subDays(90)->format('Y-m-d')))->delete();
        })->daily();

        $schedule->command('auto:opentime')->twiceDailyAt(9, 13);
        $schedule->command('auto:closetime')->twiceDailyAt(12, 16);
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
