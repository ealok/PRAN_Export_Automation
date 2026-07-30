<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ItemGroup;
use App\CiItemClaim;
use App\AssignItemClaim;
use Session;
class AssignItemClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $results=\DB::select("SELECT
                assign_item_claims.id,
                item_groups.item_group_name,
                ci_item_claims.ci_item_claim_name,
                ci_item_claims.ci_item_claim_percentage
            FROM
                assign_item_claims
            JOIN item_groups ON item_groups.id = assign_item_claims.item_group_id
            JOIN ci_item_claims ON ci_item_claims.id = assign_item_claims.ci_item_claim_id");
        return view('assign_item_claim.home')
              ->with('results', $results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
        $itemGroups=ItemGroup::all();
        $CiItemClaims=CiItemClaim::all();
        return view('assign_item_claim.create')
            ->with('itemGroups', $itemGroups)
            ->with('CiItemClaims',$CiItemClaims);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $AssignItemClaim=new AssignItemClaim();
        $results=AssignItemClaim::where('item_group_id',$request->item_group_id)->where('ci_item_claim_id',$request->ci_item_claim_id)->get();
        if(count($results)>0){

        Session::flash("danger", "Already Assign..!!");
        return redirect("/assign_item_claim");    

        }else{

        $AssignItemClaim->item_group_id=$request->item_group_id;
        $AssignItemClaim->ci_item_claim_id=$request->ci_item_claim_id;
        $AssignItemClaim->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/assign_item_claim"); 


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
        $assignItemClaim=AssignItemClaim::findorfail($id);
        $itemGroups=ItemGroup::all();
        $CiItemClaims=CiItemClaim::all();
        return view('assign_item_claim.edit')
               ->with('assignItemClaim', $assignItemClaim)
               ->with('itemGroups', $itemGroups)
               ->with('CiItemClaims',$CiItemClaims);
       
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
    
        $AssignItemClaim=AssignItemClaim::findorfail($id);
        $results=AssignItemClaim::where('item_group_id',$request->item_group_id)->where('ci_item_claim_id',$request->ci_item_claim_id)->get();
        if(count($results)>0){

            Session::flash("danger", "Already Assign..!!");
            return redirect("/assign_item_claim");    

        }else{

            $AssignItemClaim->item_group_id=$request->item_group_id;
            $AssignItemClaim->ci_item_claim_id=$request->ci_item_claim_id;
            $AssignItemClaim->save();
            Session::flash("success", "Edit Succcessfully !");
            return redirect("/assign_item_claim");
        }
        
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
