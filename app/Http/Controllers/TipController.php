<?php

namespace App\Http\Controllers;

use App\Tip;
use Illuminate\Http\Request;
use App\Events\TipsEvent;
use DataTables;

class TipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Tip::select('*')->orderBy('created_at', 'desc');
            return Datatables::of($data)
                    ->editColumn('created_at', function ($request) {
                        return $request->created_at->format('m/d/Y h:i:s A'); // human readable format
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                            $btn = '<button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteTipModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
                        //    $btn = '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view("admin.tip.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tip.create');
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
        $request->validate([
            'tip' => 'required',
        ]);
        $tip = new Tip();
        $tip->tip = $request->tip;
        $tip->is_morning = $request->radio == "is_evening" ? false: true;
        if($tip->save()){
            try {
                $data['tips'] = $tip->tip;
                $data['is_morning'] = $tip->is_morning;
                $data['date'] = $tip->created_at->format('m/d/Y h:i:s A');
                
                event(new TipsEvent($data));
                return redirect()->route('tips.index')
                ->with('success','Tip created successfully.');
            } catch (\Exception $e) {
                $tip::delete();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tip  $tip
     * @return \Illuminate\Http\Response
     */
    public function show(Tip $tip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tip  $tip
     * @return \Illuminate\Http\Response
     */
    public function edit(Tip $tip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tip  $tip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tip $tip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tip  $tip
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tip = new Tip;
        $tip->deleteData($id);
        return response()->json(['success'=>'Article deleted successfully']);
    }
}