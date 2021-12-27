<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Support\Facades\Validator;
Use Image;
use Intervention\Image\Exception\NotReadableException;

class CustomerController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json(['fail'=>'Name field validation error!']);
        }
        $customer = new Customer();
        $customer->name = $request->name;
        $imageName = "/images/customer/default_customer.png";
        if ($image = $request->file('image')) {
     
            // for save original image
            $filename = time().$image->getClientOriginalName();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(50,50);
            $image_resize->save(public_path('images/customer/'.$filename));
            $imageName = "/images/customer/".$filename;
          }
        $customer->image =  $imageName;
        if($customer->save()){
            return Response()->json($customer);
        }
        return response()->json(['fail'=>'Cannot register customer.']);

    }
    
}
