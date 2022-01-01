<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\StockEvent;

class AutoGenerateStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto-generate-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto generate stock and send to client using socket.';

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
        $data['stock'] = "12345678";
        $data['selected_stock'] = "12";
        $data['is_morning'] = true;
        $data['date'] = date('m/d/Y h:i:s A');
       
        event(new StockEvent($data));
    }
}
