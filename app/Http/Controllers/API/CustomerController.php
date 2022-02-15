<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Support\Facades\Validator;
use Image;
use Intervention\Image\Exception\NotReadableException;

class CustomerController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json(['fail' => 'Name field validation error!']);
        }
        $customer = new Customer();
        $customer->name = $request->name;
        $imageName = "/images/customer/default_customer.png";
        $imageOriginalName = "/images/customer/default_customer.png";
        if ($image = $request->file('image')) {

            // for save original image
            $filename = time() . rand(1000, 9999) . $image->getClientOriginalName();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(50, 50);
            $image_resize->save(public_path('images/customer/thumbnail/' . $filename));
            $imageName = "/images/customer/thumbnail/" . $filename;

            $originalfilename = time() . rand(1000, 9999) . $image->getClientOriginalName();
            $request->file('image')->move(public_path('images/customer/original/'), $originalfilename);
            $imageOriginalName = "/images/customer/original/" . $originalfilename;
        }
        $customer->original_image =  $imageOriginalName;
        $customer->image =  $imageName;
        if ($customer->save()) {
            return Response()->json($customer);
        }
        return response()->json(['fail' => 'Cannot register customer.']);
    }

    public function profile(int $id)
    {
        $customer = Customer::find($id);

        return response()->json($customer, 200);
    }
}
