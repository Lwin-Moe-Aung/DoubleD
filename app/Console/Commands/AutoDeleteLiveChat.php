<?php

namespace App\Console\Commands;

use App\LiveChat;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoDeleteLiveChat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-live-chat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto delete live chat after a week from today';

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
        $date = Carbon::now()->subDays(7);
        //log
        Log::info('delete live chat date <= '. $date);
        //delete Live chat data
        LiveChat::whereDate( 'created_at', '<=', $date)->delete();
    }
}
