<?php

namespace App\Console\Commands;

use App\Events\StockEvent;
use App\Position;
use App\Stock;
use Illuminate\Console\Command;

class AutoGenerateEveningStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto-generate-evening-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto generate evening stock and send to client using socket.';

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
        $selected_stock1 = substr($randomNumber, $position->first_p - 1, 1);
        $selected_stock2 = substr($randomNumber, $position->second_p - 1, 1);
        //Saving Stock table
        $ss = new Stock;
        $ss->stock = $randomNumber;
        $ss->selected_stock = $selected_stock1 . $selected_stock2;
        $ss->user_id =  2;
        if ($ss->save()) {
            try {
                $data['stock'] = (string)$randomNumber;
                $data["selected_stock1"] = [
                    "selected_stock1" => $selected_stock1,
                    "stock1_stop" => false,
                ];
                $data["selected_stock2"] = [
                    "selected_stock2" => $selected_stock2,
                    "stock2_stop" => false,
                ];
                $data['is_morning'] = false;
                $data['date'] = \Carbon\Carbon::now()->toFormattedDateString();
                $data['time'] = \Carbon\Carbon::now()->format('h:i:s A');
                event(new StockEvent($data));
            } catch (\Exception $e) {
                $ss->delete();
            }
        }
    }
}
