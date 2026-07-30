<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use App\ShippingLine;
class ShippingLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
        return view('shipping_line.index');
        
    }

    public function getShippingLinedetails(Request $request){

        $results=ShippingLine::orderBy('id','desc')->get();
        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);

        } else  {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);

        }

    }


    public function jsonGetEditDetails(Request $request){

        $result=ShippingLine::findorfail($request->edit_id);   
        if($result) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"    => $result,
                "edit_id" => $request->edit_id
            ]);

        } else  {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"    => [],
                "edit_id" => ""
            ]);

        }

    }

    public function shippingLineUpdate(Request $request){

        $shippingLine=ShippingLine::findorfail($request->edit_id);
        $shippingLine->shipping_name=$request->shipping_name;
        $shippingLine->license_number=$request->license_number;
        $shippingLine->save();
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         
        $shippingLine=new ShippingLine();
        $shippingLine->shipping_name=$request->shipping_name;
        $shippingLine->license_number=$request->license_number;
        $result=$shippingLine->save();
        if($result) {
            return response()->json([
                'message' => "Data Inserted Successfully",
                "code"    => 200
            ]);
        } else  {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }

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
