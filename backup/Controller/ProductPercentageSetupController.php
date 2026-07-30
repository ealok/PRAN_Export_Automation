<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ItemGroup;
use DB;
use App\ProductPercentage;
use Session;
class ProductPercentageSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $results=DB::select("SELECT
                item_groups.id,
                item_groups.item_group_name,
                product_percentages.product_name,
                product_percentages.percentage
            FROM
                item_groups
            LEFT JOIN product_percentages ON product_percentages.id = item_groups.product_percentage_id");
        return view('product_percentage_setup.setup_home')
               ->with('results',$results);

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
        $item_group=ItemGroup::findorfail($id);
        $results=ProductPercentage::all();
        return view('product_percentage_setup.setup_edit')
               ->with('item_group',$item_group)
               ->with('results', $results);
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
        $item_group=ItemGroup::findorfail($id);
        $item_group->product_percentage_id=$request->product_percentage_id;
        $item_group->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/percentage_setup");

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
