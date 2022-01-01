<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SubAdminController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*')
                    // ->where('role','!=',"Admin")
                    ->orderBy('created_at', 'desc');
            return Datatables::of($data)
                    
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editUser">Edit</a>';
                            $btn = $btn.'<button type="button" data-id="'.$row->id.'" data-toggle="modal" data-target="#DeleteSubAdminModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view("admin.subAdmin.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subAdmin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->route('sub-admins.create')
                ->withErrors($validator->errors())
                ->withInput();
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = "Subadmin";
        if($user->save()){
            return redirect()->route('sub-admins.index')
            ->with('success','Sub Admin အသစ်ထည့် ခြင်းအောင်မြင်ပါသည်။');
        }

        return redirect()->route('sub-admins.create')
        ->with('error','Sub Admin အသစ်ထည့် ခြင်းမအောင်မြင်ပါ။');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tip  $tip
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tip  $tip
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tip  $tip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,

        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        if($user->save()){
            return response()->json(array(
                'success' => 'Sub Admin ပြင်ဆင်ခြင်းအောင်မြင်ပါသည်။',
                ));
        }
        return response()->json(array(
            'error' => 'Sub Admin ပြင်ဆင်ခြင်းမအောင်မြင်ပါ။',
            ));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tip  $tip
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = new User;
        $user->deleteData($id);
        return response()->json(['success'=>'Sub adminဖျက်ခြင်းအောင်မြင်ပါသည်။']);
    }
}