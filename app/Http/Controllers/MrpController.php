<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CiItem;
use Session;
class MrpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $ciItems=CiItem::all();
        return view('mrp.mrp_list')->with('ci_items',$ciItems);
        
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
        //
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
        $ci_item = CiItem::find($id); 
        return view('mrp.edit')->with('ci_item',$ci_item);
        

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
        
        // \DB::table('ci_items')
        //     ->where('id', $id)
        //     ->update(['mrp_rs' => $request->mrp_rs,'hs_brand_name'=>$request->hs_brand_name,'short_name'=>$request->short_name]);

        \DB::table('ci_items')
            ->where('id', $id)
            ->update(['mrp_rs' => $request->mrp_rs]);    
        Session::flash("success", "Update Succcessfully !");    
        return redirect('/mrp');

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
