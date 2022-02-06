<?php

namespace App\Http\Controllers\API;
use App\Tip;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TipsController extends Controller
{
    public function gettingTips()
    {
        $tips = Tip::whereDate('created_at', '=', date('Y-m-d'))->get();
        $data=[];
        if($tips != null){
            foreach ($tips as $key => $tip){ 
                $data[$key]['tip'] = $tip->tip;
                $data[$key]['is_morning'] = $tip->is_morning;
                $data[$key]['date'] = \Carbon\Carbon::parse($tip->created_at)->toFormattedDateString();	
                $data[$key]['time'] = \Carbon\Carbon::parse($tip->created_at)->format('h:i:s A');


            }
        }
        return response()->json($data);
    }
}
