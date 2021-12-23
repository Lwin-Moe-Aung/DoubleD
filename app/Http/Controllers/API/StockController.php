<?php

namespace App\Http\Controllers\API;
use App\Stock;
use App\SelectedLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function gettingStock()
    {
        $stock = Stock::latest()->first();
        if($stock != null){
            $selected_stock1 = substr( $stock->selected_stock, 0, 1); 
            $selected_stock2 = substr( $stock->selected_stock, 1, 1); 
            
            $selected_log = SelectedLog::latest()->first();
            $data["stock"] = $stock->stock;
            $data["selected_stock1"] = [
                "selected_stock1" => $selected_stock1,
                "stock1_stop" => $selected_stock1 == $selected_log->morning_first_select || $selected_stock1 == $selected_log->evening_first_select ? true: false,
            ];
            $data["selected_stock2"] = [
                "selected_stock2" => $selected_stock2,
                "stock2_stop" => $selected_stock2 == $selected_log->morning_second_select || $selected_stock2 == $selected_log->evening_second_select ? true: false,
            ];
            $data["date"] = $stock->created_at->format('m/d/Y h:i:s A');
            $data["selected_stock2"] = [
                "selected_stock2" => $selected_stock2,
                "stock2_stop" =>  !$data["selected_stock1"]["stock1_stop"]? false: $data["selected_stock2"]["stock2_stop"],
            ];
            
        }
       
        return response()->json($data);
    }
}
