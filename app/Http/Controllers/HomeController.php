<?php

namespace App\Http\Controllers;

use App\Customer;
use App\SelectedLog;
use App\Stock;
use App\Tip;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $customer_count = Customer::count();
        return view('admin.dashboard.dashboard', compact('customer_count'));
    }

    public function showCustomer(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::select('*')
                // ->where('role','!=',"Admin")
                ->orderBy('created_at', 'desc');
            return DataTables::of($data)

                ->addIndexColumn()
                // ->editColumn('image', function ($request) {
                //     return '<img src="' . $request->image . '" border="0" width="40" class="img-rounded" align="center" />'; // human readable format
                // })
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" data-id="' . $row->id . '" data-toggle="modal" data-target="#DeleteSubAdminModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.dashboard.show-customer');
    }

    public function customerDelete($id)
    {
        Customer::find($id)->delete();
        return response()->json(['success' => 'Customer ဖျက်ခြင်းအောင်မြင်ပါသည်။']);
    }

    public function showHistory(int $days)
    {
        $to = Carbon::now()->subDay(1);
        $from = Carbon::now()->subDay($days + 1);
        // $to = Carbon::createFromFormat('Y-m-d h:i:s', $to)->format('Y-m-d H:i:s');
        // return $from;
        $data = SelectedLog::when(isset($days), function ($q) use ($from, $to) {
            $q->whereBetween('date', [$from, $to]);
        })
            ->join('stocks', 'stocks.id', '=', 'selected_log.mss_stock_id')

            ->select('selected_log.*', 'stocks.*')
            ->orderByDesc('date')
            ->get();

        $return_data = [];
        $className = array('info', 'success', 'warning', 'danger');
        foreach ($data as $key => $dd) {
            $return_data[$key]['className'] = $className[array_rand($className)];
            $return_data[$key]["date"] = \Carbon\Carbon::parse($dd->date)->toFormattedDateString();
            $return_data[$key]["stock"]["morning"]["stock"] = $this->getStockById($dd->mss_stock_id);
            $return_data[$key]["stock"]["morning"]["selected_stock1"] = $dd->morning_first_select;
            $return_data[$key]["stock"]["morning"]["selected_stock2"] = $dd->morning_second_select;

            $return_data[$key]["stock"]["evening"]["stock"] = $this->getStockById($dd->ess_stock_id);
            $return_data[$key]["stock"]["evening"]["selected_stock1"] = $dd->evening_first_select;
            $return_data[$key]["stock"]["evening"]["selected_stock2"] = $dd->evening_second_select;
            $return_data[$key]["tips"]["morning"] = $this->gettingTipByDate($dd->date, 1);
            $return_data[$key]["tips"]["evening"] = $this->gettingTipByDate($dd->date, 0);
        }
        // dd($return_data);
        return view('admin.dashboard.show-selected-stock', compact('return_data'));
        // return response()->json($return_data);
    }
    public function gettingTipByDate(String $date, $is_morning)
    {

        $tip = Tip::whereDate('created_at', '=', $date)
            ->where('is_morning', $is_morning)
            ->first();

        if ($tip != null) return $tip->tip;

        return "";
    }

    public function getStockById($id)
    {
        $stock = Stock::find($id);
        if ($stock == null) {
            return "";
        }
        return $stock->stock;
    }
}
