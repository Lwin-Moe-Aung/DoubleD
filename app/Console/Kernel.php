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
        Commands\AutoDeleteLiveChat::class,
        Commands\AutoDeleteStock::class,

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
            // ->weekdays()
            ->timezone('Asia/Yangon')
            ->between("00:16", "00:18");

        $schedule->command('auto-generate-evening-stock')
            // ->weekdays()
            ->timezone('Asia/Yangon')
            ->between("00:20", "00:22");

        $schedule->command('delete-live-chat')
            ->timezone('Asia/Yangon')
            ->weekly();
        $schedule->command('delete-stock')
            ->timezone('Asia/Yangon')
            ->weekly();

        // $schedule->command('auto-generate-morning-stock')
        //     // ->weekdays()
        //     ->timezone('Asia/Yangon')
        //     ->between("15:02", "15:03");

        // $schedule->command('auto-generate-evening-stock')
        //     // ->weekdays()
        //     ->timezone('Asia/Yangon')
        //     ->between("15:04", "15:05");

        // $schedule->command('delete-live-chat')
        //     ->timezone('Asia/Yangon')
        //     ->weekly();
        // $schedule->command('delete-stock')
        //     ->timezone('Asia/Yangon')
        //     ->weekly();


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
