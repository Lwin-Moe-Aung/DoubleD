<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\LiveChatEvent;
use App\LiveChat;
use App\Customer;
use Carbon\Carbon;

class LiveChatController extends Controller
{
    public function liveChat(Request $request) {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'customer_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['fail'=>'validation error!']);
        }

        $livechat = new LiveChat();
        $livechat->message = $request->message;
        $livechat->customer_id = $request->customer_id;
        if($livechat->save()){
            try{
                $customer = Customer::find($request->customer_id);
                $data["message"] = $livechat->message;
                $data["customer_id"] = $request->customer_id;
                $data["date"] = $livechat->created_at->format('Y-m-d H:i:s');
                $data["customer_name"] = $customer->name;
                $data["customer_photo"] = $customer->image;

                event(new LiveChatEvent($data));
                return response()->json(['success'=>'Message sent successfully']);
            } catch (\Exception $e) {
                $livechat->delete();
            }
        }
        return response()->json(['fail'=>'Message cannot sent']);

    }
  
    public function index(){

        $livechat = LiveChat::orderBy('created_at', 'desc')
                ->paginate(20)
                ->toArray();
               
        if(empty($livechat["data"])){
            return response()->json([]);
        } 
        foreach($livechat["data"] as $key=>$liveData){
            $customer = Customer::find($liveData["customer_id"]);
            //  dd($liveData["created_at"]);
            $data[$key]["message"] = $liveData["message"];
            $data[$key]["customer_name"] = $customer->name;
            $data[$key]["customer_photo"] = $customer->image;
            $data[$key]["date"] = $liveData["created_at"];
        }
        return response()->json($data,200);

    }
}
