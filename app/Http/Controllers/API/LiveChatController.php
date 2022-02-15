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
    public function liveChat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'customer_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['fail' => 'validation error!']);
        }

        $livechat = new LiveChat();
        $livechat->message = $request->message;
        $livechat->customer_id = $request->customer_id;
        if ($livechat->save()) {
            try {
                $customer = Customer::find($request->customer_id);
                $data["id"] = $livechat->id;
                $data["message"] = $livechat->message;
                $data["customer_id"] = $request->customer_id;
                $data["customer_name"] = $customer->name;
                $data["customer_photo"] = $customer->image;
                $data["date"] = \Carbon\Carbon::parse($livechat->created_at)->diffForHumans();
                event(new LiveChatEvent($data));
                return response()->json($data);
            } catch (\Exception $e) {
                $livechat->delete();
            }
        }
        return response()->json(['fail' => 'Message cannot sent']);
    }

    public function index()
    {
        $livechat = LiveChat::orderBy('created_at', 'desc')
            ->paginate(10)
            ->toArray();
        if (empty($livechat["data"])) {
            return response()->json([]);
        }
        foreach ($livechat["data"] as $key => $liveData) {
            $customer = Customer::find($liveData["customer_id"]);
            //  dd($liveData["created_at"]);
            $livechat["data"][$key]["message"] = $liveData["message"];
            $livechat["data"][$key]["customer_name"] = $customer->name;
            $livechat["data"][$key]["customer_photo"] = $customer->image;
            $livechat["data"][$key]["date"] = \Carbon\Carbon::parse($liveData["created_at"])->diffForHumans();
        }
        return response()->json($livechat, 200);
    }
}
