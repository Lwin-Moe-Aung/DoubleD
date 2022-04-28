<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\Position;
use App\SelectedLog;
use App\Events\StockEvent;
use DataTables;
use Carbon\Carbon;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Stock::select('*')->orderBy('created_at', 'desc');
            return Datatables::of($data)
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('m/d/Y h:i:s A'); // human readable format
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<button type="button" data-id="' . $data->id . '" data-toggle="modal" data-target="#DeleteStockModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.stock.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(date('m-d-Y'));
        $position = Position::first();
        $selected_log = SelectedLog::whereDate('date', '=', date('Y-m-d'))->first();

        return view('admin.stock.create', compact('position', 'selected_log'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(date('Y-m-d H:i:sA'));
        // return $request;
        $request->validate([
            'stock' => 'required'
        ]);
        if ($request->radio != "none") {
        }
        //morning
        $startDate = Carbon::createFromFormat('H:i a', '12:32 AM');
        $endDate = Carbon::createFromFormat('H:i a', '12:35 AM');
        // $startDate = Carbon::createFromFormat('H:i a', '11:00 AM');
        // $endDate = Carbon::createFromFormat('H:i a', '11:30 AM');
        $check = Carbon::now()->between($startDate, $endDate, true);
        //evening
        $startDate1 = Carbon::createFromFormat('H:i a', '12:38 AM');
        $endDate1 = Carbon::createFromFormat('H:i a', '12:41 AM');
        // $startDate1 = Carbon::createFromFormat('H:i a', '11:35 AM');
        // $endDate1 = Carbon::createFromFormat('H:i a', '11:36 AM');
        $check1 = Carbon::now()->between($startDate1, $endDate1, true);
        if($check || $check1){
            if ($request->radio != "none") {
                return redirect()->route('stocks.index')
                    ->with('error', 'Stock အသစ်ထည့်သွင်ရာတွင် error တစ်ခုခု ရှိနေသည်။ ပြန်လည်လုပ်ဆောင်ပေးပါ။');
            }
        }

        $stock1_stop = false;
        $stock2_stop = false;

        $stock = $request->stock;
        $first_p = (int)$request->first_p;
        $second_p = (int)$request->second_p;

        $selected_stock1 = substr($stock, $first_p - 1, 1);
        $selected_stock2 = substr($stock, $second_p - 1, 1);

        if ($request->radio != "none") {
            if ($request->radio == "morning_first_select") {
                $selected_log = new SelectedLog;
                $selected_log->date = date('Y-m-d');
                $selected_log->morning_first_select = $selected_stock1;
                $selected_log->save();
                $stock1_stop = true;
                $id_column = "mfs_stock_id";
            } else {
                $selected_log = SelectedLog::whereDate('date', '=', date('Y-m-d'))->first();
                if ($request->radio == "evening_second_select") {
                    $selected_log->evening_second_select = $selected_stock2;
                    $selected_log->evening_ss_time = date('Y-m-d H:i:s');
                    $selected_stock1 = $selected_log->evening_first_select;
                    $stock1_stop = true;
                    $stock2_stop = true;
                    $id_column = "ess_stock_id";
                } elseif ($request->radio == "evening_first_select") {
                    $selected_log->evening_first_select = $selected_stock1;
                    $stock1_stop = true;
                    $id_column = "efs_stock_id";
                } else {
                    $selected_log->morning_second_select = $selected_stock2;
                    $selected_log->morning_ss_time = date('Y-m-d H:i:s');
                    $selected_stock1 = $selected_log->morning_first_select;
                    $stock1_stop = true;
                    $stock2_stop = true;
                    $id_column = "mss_stock_id";
                }
            }
        } else {
            if ($request->type == "morning_second_select") {
                $selected_log = SelectedLog::whereDate('date', '=', date('Y-m-d'))->first();
                $selected_stock1 = $selected_log->morning_first_select;
                $stock1_stop = true;
            } elseif ($request->type == "evening_second_select") {
                $selected_log = SelectedLog::whereDate('date', '=', date('Y-m-d'))->first();
                $selected_stock1 = $selected_log->evening_first_select;
                $stock1_stop = true;
            }
            $id_column = "";
        }
        $selected_stock["selected_stock1"] = [
            "selected_stock1" => $selected_stock1,
            "stock1_stop" => $stock1_stop,
        ];
        $selected_stock["selected_stock2"] = [
            "selected_stock2" => $selected_stock2,
            "stock2_stop" => $stock2_stop,
        ];
        //Saving Stock table
        $ss = new Stock;
        $ss->stock = $stock;
        $ss->selected_stock = $selected_stock1 . $selected_stock2;
        $ss->user_id =  $request->user_id;

        if ($ss->save()) {
            try {
                //saving selectedlog table
                if ($id_column != "") {
                    $selected_log->$id_column = $ss->id;
                    $selected_log->save();
                }

                $data = [];
                $data['stock'] = $stock;
                $data['selected_stock1'] = $selected_stock['selected_stock1'];
                $data['selected_stock2'] = $selected_stock['selected_stock2'];

                $data['is_morning'] = Carbon::now()->lt($startDate1)  ? true : false;

                // $data['is_morning'] = $request->type == "morning_first_select" || $request->type == "morning_second_select" ? true : false;
                // $data['date'] = $ss->created_at->format('m/d/Y h:i:s A');
                $data['date'] = \Carbon\Carbon::parse($ss->created_at)->toFormattedDateString();
                $data['time'] = \Carbon\Carbon::parse($ss->created_at)->format('h:i:s A');
                event(new StockEvent($data));
                return redirect()->route('stocks.index')
                    ->with('success', 'Stock အသစ်ထည့်သွင်းခြင်း အောင်မြင်ပါသည်။');
            } catch (\Exception $e) {
                $ss->delete();
            }
        }
        return redirect()->route('stocks.index')
            ->with('error', 'Stock အသစ်ထည့်သွင်ရာတွင် error တစ်ခုခု ရှိနေသည်။ ပြန်လည်လုပ်ဆောင်ပေးပါ။');
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
        $selectedLog = SelectedLog::where('mfs_stock_id', $id)
            ->orWhere('mss_stock_id', $id)
            ->orWhere('efs_stock_id', $id)
            ->orWhere('ess_stock_id', $id)
            ->first();
        if ($selectedLog != null) {
            return response()->json(['error' => 'Stock cannot deleted'], 500);
        }

        if (Stock::find($id)->delete()) {
            return response()->json(['success' => 'Stock deleted successfully']);
        }
    }

    public function resetSelectedLog()
    {
        SelectedLog::whereDate('date', '=', date('Y-m-d'))->delete();
        return true;
    }
}
