<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\DateClaim;
use Session;
class CiDateClaimController extends Controller
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
        $dateClaimes = \DB::table("date_claims")
                ->select("*",
                    \DB::raw('(CASE 
                        WHEN date_claims.status = "1" THEN "Active" 
                        WHEN date_claims.status = "2" THEN "Inactive" 
                        END) AS status'))
                ->paginate(10);
        return view('ci_date_claim.date_claim_home')->with('dateClaimes', $dateClaimes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   

        return view('ci_date_claim.date_claim_create');
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $results=DateClaim::where('status', $request->status)->pluck('status');
        if(count($results)>0){

            if($results['0']=='1'){
                
                Session::flash("danger", "Already  Active Another Claim..!!");
                return redirect('/ci_date_claim');
            }
            
        }
        $dateClaim=new DateClaim();
        $dateClaim->days=$request->days;
        if($request->date){

          $dateClaim->date=date('Y-m-d', strtotime($request->date));
          
        }
        $dateClaim->status=$request->status;
        $dateClaim->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect('/ci_date_claim');


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
        $dateClaim=DateClaim::findorfail($id);
        return view('ci_date_claim.date_claim_edit')
               ->with('dateClaim',$dateClaim);
        
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
        $results=DateClaim::where('status', $request->status)->pluck('status');
        if(count($results)>0){

            if($results['0']=='1'){
                
                Session::flash("danger", "Already  Active Another Claim..!!");
                return redirect('/ci_date_claim');
            }
            
        }

        $dateClaim=DateClaim::findorfail($id);
        $dateClaim->days=$request->days;
        if($request->date){
          $dateClaim->date=date('Y-m-d', strtotime($request->date));
        }
        $dateClaim->status=$request->status;
        $dateClaim->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect('/ci_date_claim');

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
