<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\CiItemClaim;
use App\ClaimDetails;
use Session;
class CiItemCalimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $cIItemClaimes = DB::table('ci_item_claims')
            ->join('claim_details', 'claim_details.claim_id', '=', 'ci_item_claims.id')
            ->select('claim_details.id', 'ci_item_claims.ci_item_claim_name', 'claim_details.fship_date', 'claim_details.tship_date', 'claim_details.ci_item_claim_percentage')
            ->get();
         return view('ci_item_claim.ci_item_claim_list')->with('cIItemClaimes',$cIItemClaimes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $ciItemClaimes=CiItemClaim::all();
        return view('ci_item_claim.ci_item_claim_create')->with('ciItemClaimes',$ciItemClaimes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
           "ci_item_claim_name"=>"required|max:200",
           "ci_item_claim_percentage"=>"required|numeric",
        ]);
        $cIItemClaim=new CiItemClaim();
        $cIItemClaim->ci_item_claim_name=$request->ci_item_claim_name;
        $cIItemClaim->ci_item_claim_percentage=$request->ci_item_claim_percentage;
        $cIItemClaim->fship_date=date('Y-m-d',strtotime($request->fship_date));
        $cIItemClaim->tship_date=date('Y-m-d',strtotime($request->tship_date));
        $cIItemClaim->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/ci_item_claim"); 

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
        $claimdetails=ClaimDetails::findorfail($id);
        $ciItemClaims =CiItemClaim::all();
        return view('ci_item_claim.ci_item_claim_edit')
                ->with('ciItemClaims', $ciItemClaims)
                ->with('claimdetails',$claimdetails);
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
        
         $ClaimDetails=ClaimDetails::findorfail($id);
         $ClaimDetails->claim_id=$request->ci_item_claim_name;
         $ClaimDetails->fship_date=date('Y-m-d',strtotime($request->fship_date));
         $ClaimDetails->tship_date=date('Y-m-d',strtotime($request->tship_date));
         $ClaimDetails->ci_item_claim_percentage=$request->ci_item_claim_percentage;
         $ClaimDetails->save();
         Session::flash("success", "Update Succcessfully !");
         return redirect("/ci_item_claim");
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
