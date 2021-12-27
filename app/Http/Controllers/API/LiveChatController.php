<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\LiveChatEvent;
use App\LiveChat;
use App\Customer;


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
  
}
