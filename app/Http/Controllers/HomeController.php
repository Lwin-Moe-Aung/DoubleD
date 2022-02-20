<?php

namespace App\Http\Controllers;

use App\Customer;
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
}
