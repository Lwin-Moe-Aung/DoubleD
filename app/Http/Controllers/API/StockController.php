<?php

namespace App\Http\Controllers\API;
use App\Stock;
use App\SelectedLog;
use App\Tip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StockController extends Controller
{
    public function gettingStock()
    {
        
        $selected_log = SelectedLog::whereDate('date', '=', date('Y-m-d'))->first();
        if($selected_log == null){
            $latestStock = $this->getLatestStock();
            if($latestStock == null){
                $selected_log = SelectedLog::latest()->first();
                if($selected_log == null){
                    $data = [];
                    return response()->json($data);
                }
            }else{
                $data["stock"] =  $latestStock->stock;
                $data["selected_stock1"] = [
                    "selected_stock1" => substr($latestStock->selected_stock, 0, 1),
                    "stock1_stop" => false
                ];
                $data["selected_stock2"] = [
                    "selected_stock2" => substr($latestStock->selected_stock, 1, 1),
                    "stock2_stop" => false
                ];
                $data["is_morning"] = true;
                // $data2["date"] = $selected_log->evening_ss_time->format('m/d/Y h:i:s A');
                $data["date"] =  $latestStock->created_at->format('m/d/Y h:i:s A');
                $data = [
                    $data
                ];

                return response()->json($data);
            }
        }

        if($selected_log->evening_second_select != null){   
            $data = $this->eveningSecondSelect($selected_log);
        }elseif($selected_log->evening_first_select != null){
            $data = $this->eveningFirstSelect($selected_log);
        }
        elseif($selected_log->morning_second_select != null){
            $data = $this->morningSecondSelect($selected_log);
        }else{
            $data = $this->morningFirstSelect($selected_log);
        }
           
        
        return response()->json($data);
    }

    public function getStockById($id)
    {  
        $stock = Stock::find($id);
        if($stock == null){
            return "";
        }
        return $stock->stock;
    }

    public function eveningSecondSelect(SelectedLog $selected_log)
    {  
        //data 1
        $data1["stock"] = $this->getStockById($selected_log->mss_stock_id);
        $data1["selected_stock1"] = [
            "selected_stock1" => $selected_log->morning_first_select,
            "stock1_stop" => true
        ];
        $data1["selected_stock2"] = [
            "selected_stock2" => $selected_log->morning_second_select,
            "stock2_stop" => true
        ];
        $data1["is_morning"] = true;
        $data1["date"] = $selected_log->morning_ss_time;
        // $data1["date"] = $selected_log->morning_ss_time->format('m/d/Y h:i:s A');

        //data2
        $data2["stock"] = $this->getStockById($selected_log->ess_stock_id);
        $data2["selected_stock1"] = [
            "selected_stock1" => $selected_log->evening_first_select,
            "stock1_stop" => true
        ];
        $data2["selected_stock2"] = [
            "selected_stock2" => $selected_log->evening_second_select,
            "stock2_stop" => true
        ];
        $data2["is_morning"] = false;
        // $data2["date"] = $selected_log->evening_ss_time->format('m/d/Y h:i:s A');
        $data2["date"] = $selected_log->evening_ss_time;

        
        $data =[
            $data1,
            $data2
        ];
        return $data;
    }

    public function eveningFirstSelect(SelectedLog $selected_log)
    {  
        //data 1
        $data1["stock"] = $this->getStockById($selected_log->mss_stock_id);
        $data1["selected_stock1"] = [
            "selected_stock1" => $selected_log->morning_first_select,
            "stock1_stop" => true
        ];
        $data1["selected_stock2"] = [
            "selected_stock2" => $selected_log->morning_second_select,
            "stock2_stop" => true
        ];
        $data1["is_morning"] = true;
        $data1["date"] = $selected_log->morning_ss_time;
        // $data1["date"] = $selected_log->morning_ss_time->format('m/d/Y h:i:s A');

        //data2
        $latestStock = $this->getLatestStock();
        $data2["stock"] =  $latestStock->stock;
        $data2["selected_stock1"] = [
            "selected_stock1" => $selected_log->evening_first_select,
            "stock1_stop" => true
        ];
        $data2["selected_stock2"] = [
            "selected_stock2" => substr($latestStock->selected_stock, 1, 1),
            "stock2_stop" => false
        ];
        $data2["is_morning"] = false;
        // $data2["date"] = $selected_log->evening_ss_time->format('m/d/Y h:i:s A');
        $data2["date"] =  $latestStock->created_at->format('m/d/Y h:i:s A');

        
        $data =[
            $data1,
            $data2
        ];
        return $data;
    }

    public function getLatestStock()
    {  
        // $selected_log = SelectedLog::whereDate('date', '=', date('Y-m-d'))->first();

        $stock = Stock::whereDate('created_at', '=', date('Y-m-d'))
                    ->orderBy('created_at', 'desc')
                    ->first();
        
        return $stock;
    }

    public function morningSecondSelect(SelectedLog $selected_log)
    {  
        //data 1
        $data1["stock"] = $this->getStockById($selected_log->mss_stock_id);
        $data1["selected_stock1"] = [
            "selected_stock1" => $selected_log->morning_first_select,
            "stock1_stop" => true
        ];
        $data1["selected_stock2"] = [
            "selected_stock2" => $selected_log->morning_second_select,
            "stock2_stop" => true
        ];
        $data1["is_morning"] = true;
        $data1["date"] = $selected_log->morning_ss_time;
        // $data1["date"] = $selected_log->morning_ss_time->format('m/d/Y h:i:s A');

        //data2
        $latestStock = $this->getLatestStock($selected_log->mss_stock_id);
        if($latestStock->id == $selected_log->mss_stock_id){
            $data =[
                $data1
            ];
            return $data;
        }
        $data2["stock"] =  $latestStock->stock;
        $data2["selected_stock1"] = [
            "selected_stock1" => substr($latestStock->selected_stock, 0, 1),
            "stock1_stop" => false
        ];
        $data2["selected_stock2"] = [
            "selected_stock2" => substr($latestStock->selected_stock, 1, 1),
            "stock2_stop" => false
        ];
        $data2["is_morning"] = false;
        // $data2["date"] = $selected_log->evening_ss_time->format('m/d/Y h:i:s A');
        $data2["date"] =  $latestStock->created_at->format('m/d/Y h:i:s A');
        $data =[
            $data1,
            $data2
        ];
        return $data;
    }

    public function morningFirstSelect(SelectedLog $selected_log)
    {  
        //data 1
        $latestStock = $this->getLatestStock();

        $data1["stock"] = $latestStock->stock;
        $data1["selected_stock1"] = [
            "selected_stock1" => $selected_log->morning_first_select,
            "stock1_stop" => true
        ];
        $data1["selected_stock2"] = [
            "selected_stock2" => substr($latestStock->selected_stock, 1, 1),
            "stock2_stop" => false
        ];
        $data1["is_morning"] = true;
        $data1["date"] =  $latestStock->created_at->format('m/d/Y h:i:s A');
        // $data1["date"] = $selected_log->morning_ss_time->format('m/d/Y h:i:s A');
        
        $data =[
            $data1
        ];
        return $data;
    }
    public function getHistory(int $days)
    {  
        $to = Carbon::now()->subDay(1);
        $from = Carbon::now()->subDay($days+1);
        // $to = Carbon::createFromFormat('Y-m-d h:i:s', $to)->format('Y-m-d H:i:s');
        // return $from;
        $data = SelectedLog::when(isset($days), function($q) use($from, $to){
                $q->whereBetween('date', [$from, $to]);
            })
            ->join('stocks', 'stocks.id', '=', 'selected_log.mss_stock_id')

            ->select('selected_log.*', 'stocks.*')
            ->orderByDesc('date')
            ->get();
        
        $return_data = [];
        foreach($data as $key => $dd) {

            $return_data[$key]["date"] =  $dd->date;
            $return_data[$key]["stock"]["morning"]["stock"] = $this->getStockById($dd->mss_stock_id);
            $return_data[$key]["stock"]["morning"]["selected_stock1"] = $dd->morning_first_select;
            $return_data[$key]["stock"]["morning"]["selected_stock2"] = $dd->morning_second_select;
            
            $return_data[$key]["stock"]["evening"]["stock"] = $this->getStockById($dd->ess_stock_id);
            $return_data[$key]["stock"]["evening"]["selected_stock1"] = $dd->evening_first_select;
            $return_data[$key]["stock"]["evening"]["selected_stock2"] = $dd->evening_second_select;
            $return_data[$key]["tips"]["morning"] = $this->gettingTipByDate($dd->date, 1);
            $return_data[$key]["tips"]["evening"] = $this->gettingTipByDate($dd->date, 0);

        }
        return response()->json($return_data);
    
    }
    public function gettingTipByDate(String $date, $is_morning){

        $tip = Tip::whereDate('created_at', '=', $date)
            ->where('is_morning', $is_morning)    
            ->first();
        
            if($tip != null) return $tip->tip;

        return "";
    }
}
