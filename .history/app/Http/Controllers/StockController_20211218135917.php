<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\Position;
//use App\Events\StockUploadEvent;
use App\Events\StockEvent;


class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.stock.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $position = Position::first();
        return view('admin.stock.create', compact('position'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $request->validate([
            'item' => 'required'
        ]);
        $item = $request->item;
        $first_p = (int)$request->first_p;
        $second_p = (int)$request->second_p;
        
        $selected_item = substr( $item, $first_p-1, 1); 
        $selected_item .= substr( $item, $second_p-1, 1); 
        
        $stock = new Stock;
        $stock->item = $item;
        $stock->selected_item =  $selected_item;
        $stock->save();
        
        //event(new StockUploadEvent($stock->toArray()));
        event(new StockEvent($stock->toArray()));

        return redirect()->route('stocks.index')
                        ->with('success','Stock created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
