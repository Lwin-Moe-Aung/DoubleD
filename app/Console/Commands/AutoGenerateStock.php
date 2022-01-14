<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\StockEvent;
use App\Position;
use App\Stock;
use Illuminate\Support\Facades\Log;

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
        $this->sentData();
        sleep(15);
        $this->sentData();
        sleep(15);
        $this->sentData();
        sleep(15);
        $this->sentData();
    }

    public function sentData()
    {
        $randomNumber = random_int(10000000, 99999999);
        $position = Position::first();
        $selected_stock1 = substr($randomNumber, $position->first_p -1 , 1); 
        $selected_stock2 = substr($randomNumber, $position->second_p -1 , 1); 
        //Saving Stock table
        $ss = new Stock;
        $ss->stock = $randomNumber;
        $ss->selected_stock = $selected_stock1.$selected_stock2;
        $ss->user_id =  2;
        if($ss->save()){
            try {
                $selected_stock["selected_stock1"] = [
                    "selected_stock1" => $selected_stock1,
                    "stock1_stop" => false,
                ];
                $selected_stock["selected_stock2"] = [
                    "selected_stock1" => $selected_stock2,
                    "stock1_stop" => false,
                ];
        
                $data['stock'] = (string)$randomNumber;
                $data['selected_stock'] = $selected_stock;
                $data['is_morning'] = true;
                $data['date'] = date('m/d/Y h:i:s A');
              
                event(new StockEvent($data));
               
            } catch (\Exception $e) {
                $ss->delete();
               
            }
        }

    }
}
