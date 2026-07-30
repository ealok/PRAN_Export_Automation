<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ItemGroup;
use Session;
class ItemGroupController extends Controller
{

    public function __construct(){

       $this->middleware('auth');

    }
      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemGroups=ItemGroup::all();
        return view('item_group.item_group_list')->with('itemGroups', $itemGroups);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('item_group.item_group_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $itemGroup=new ItemGroup();
        $itemGroup->item_group_name=$request->item_group_name;
        $itemGroup->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/item_group");
        
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
        return view('item_group.item_group_edit')->with('item_group', $item_group);

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
        $item_group->item_group_name=$request->item_group_name;
        $item_group->short_name=$request->short_name;
        $item_group->save();        
        Session::flash("success", "Created Succcessfully !");
        return redirect("/item_group");
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
