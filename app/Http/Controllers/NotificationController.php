<?php

namespace App\Http\Controllers;
use DB;

use App\Notification;
use Illuminate\Http\Request;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Validator;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Notification::orderByDesc('created_at')->paginate(10);
        return view("admin.notifications.index",compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    public function addNotification(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
        $notification = new Notification();
        if($request->subject != null){
            $notification->subject = $request->subject;
        }
        $notification->description = $request->description;
        if($notification->save())
        {
            try{
                DB::table('users')
                    ->where('role', '=', 'Subadmin')
                    ->update([
                        'noti_count' => DB::raw('noti_count + 1'),
                    ]);
                $user = User::select('id','noti_count')
                    ->where('role', '=', 'Subadmin')
                    ->get()
                    ->toArray();
                event(new NotificationEvent($user));
                return response()->json(array(
                    'success' => 'အောင်မြင်ပါသည်။',
                    ));
            } catch (\Exception $e) {
                $notification->delete();
            }
        }
        return response()->json(array(
            'error' => 'မအောင်မြင်ပါ။',
            ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function deleteNotification(Request $request)
    {
        try {
            Notification::destroy($request->data);
            return response()->json(array(
                'success' => 'အောင်မြင်ပါသည်။',
                ));
        }
        catch (\Exception $e) {
            return response()->json(array(
                'error' => 'မအောင်မြင်ပါ။',
                ));
        } 
    }

    public function getNotification()
    {
        $notification = Notification::select('*')
                        ->orderByDesc('created_at')
                        ->limit(5)
                        ->get();
        $user = User::find(1);
        $uu = User::find(Auth::id());
        $uu->noti_count = 0;
        $uu->save();

        foreach($notification as $key=>$value){
            $data[$key]['link'] = config('const.IMAGE_URL').'notifications';
            $data[$key]['image'] = config('const.IMAGE_URL').'images/admin/admin.jpg';
            $data[$key]['sender'] = $user->name;
            $data[$key]['subject'] = Str::limit($value->subject, 15);
            $data[$key]['description'] = Str::limit($value->description, 50,);
            $data[$key]['created_at'] = Carbon::parse($value->created_at)->diffForHumans();
        }

        return response()->json($data);
    }

    public function autocompleteSearch(Request $request)
    {
          $query = $request->get('query');
          $filterResult = Notification::where('subject', 'LIKE', '%'. $query. '%')->get();
          return response()->json($filterResult);
    } 
}
