<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;

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
        $products = product::get();
        
        
        return view('home',compact('products'));
    }

    public function deletesingle($id)
    {
        product::destroy($id);
    	return response()->json(['success'=>"Product Deleted successfully.", 'tr'=>'tr_'.$id]);
    }

    public function deleteall(Request $request)
    {
        $ids = $request->ids;
        product::whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Products Deleted successfully."]);
    }

    public function store(Request $request)
    {
        
        $input = $request->only('name', 'price', 'status');

        $filename = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $filename);
        $input['image'] = $filename;
        $input['ups'] = uniqid();
        product::create($input);
        return true;
    }

    public function edit($id)
    {
        $product = product::where('id',$id)->first();
        return $product;
    }

    public function update(Request $request)
    {
        $input = $request->only('name', 'price', 'status');

        if($request->has('image'))
        {
            $filename = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $filename);
            $input['image'] = $filename;
        }
        
        
        product::where('id',$request->id)->update($input);
        return true;
    }
}
