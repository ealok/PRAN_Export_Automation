<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\IndiaItemGorupAssign;
use App\ItemGroupIndia;
use App\CiItem;
use Session;
use Auth;
class ItemGroupAssignIndiaController extends Controller
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
         
        $results=IndiaItemGorupAssign::all();  
        return view('item_group_assign_ind.index')
               ->with('results',$results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $itemGorups=ItemGroupIndia::all(); 
        $ciItems=CiItem::all();
        return view('item_group_assign_ind.create')
              ->with('itemGorups',$itemGorups)
              ->with('ciItems',$ciItems);
               
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
       $results=IndiaItemGorupAssign::where('india_group_id',$request->india_group_id)->where('india_item_id',$request->india_item_id)->first();

       if($results){
         
          Session::flash("danger", "Alredy Assign !");
          return redirect("/assign_item_gorup_india");

       }else{

           $obj=new IndiaItemGorupAssign();
           $obj->india_group_id=$request->india_group_id;
           $obj->india_item_id=$request->india_item_id;
           $obj->hs_code1=$request->hs_code1;
           $obj->hs_code2=$request->hs_code2;
           $obj->save(); 
           Session::flash("success", "Assign Successful..!!!");
           return redirect("/assign_item_gorup_india");

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
    
        $editDetails=IndiaItemGorupAssign::findorfail($id);
        $itemGorups=ItemGroupIndia::all(); 
        $ciItems=CiItem::all();
        return view('item_group_assign_ind.edit')
               ->with('itemGorups',$itemGorups)
               ->with('ciItems',$ciItems)
               ->with('editDetails',$editDetails);

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

       $obj=IndiaItemGorupAssign::findorfail($id);
       $obj->india_group_id=$request->india_group_id;
       $obj->india_item_id=$request->india_item_id;
       $obj->hs_code1=$request->hs_code1;
       $obj->hs_code2=$request->hs_code2;
       $obj->save(); 
       Session::flash("success", "Edit Successful..!!!");
       return redirect("/assign_item_gorup_india"); 

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

    public function indiaItemGroupAssign(Request $request){
      


        

    }


}
