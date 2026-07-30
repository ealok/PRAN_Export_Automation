<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ProductPercentage;
use Session;
class ProductPercentageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $productPercentages=ProductPercentage::all();
        return view('product_percentage.home')->with('productPercentages',$productPercentages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product_percentage.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produdct_percentage=new ProductPercentage();
        $produdct_percentage->product_name=$request->product_name;
        $produdct_percentage->percentage=$request->percentage;
        $produdct_percentage->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/product_percentage");
        
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
        $produdct_percentage=ProductPercentage::findorfail($id);
        return view('product_percentage.edit')->with('produdct_percentage',$produdct_percentage);
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
        $produdct_percentage=ProductPercentage::findorfail($id);
        $produdct_percentage->product_name=$request->product_name;
        $produdct_percentage->percentage=$request->percentage;
        $produdct_percentage->save();
        Session::flash("success", "Edit Succcessfully !");
        return redirect("/product_percentage");
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
