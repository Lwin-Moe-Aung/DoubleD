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
        Commands\AutoGenerateMorningStock::class,
        Commands\AutoGenerateEveningStock::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('auto-generate-morning-stock')
                ->weekdays()
                ->timezone('Asia/Yangon')
                ->between("09:00","11:30");

        $schedule->command('auto-generate-evening-stock')
                ->weekdays()
                ->timezone('Asia/Yangon')
                ->between("14:00","17:30");
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
