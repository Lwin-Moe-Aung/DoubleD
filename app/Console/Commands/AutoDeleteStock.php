<?php

namespace App\Console\Commands;

use App\SelectedLog;
use App\Stock;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoDeleteStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-stock';

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
     * @return int
     */
    public function handle()
    {
        $date = Carbon::now()->subDays(50);
        //log
        Log::info('delete Stock table and Selected Log table Where date from 60 ago  where date <='. $date);
        //delete Live chat data
        Stock::whereDate( 'created_at', '<=', $date)->delete();
        SelectedLog::whereDate( 'created_at', '<=', $date)->delete();

    }
}
