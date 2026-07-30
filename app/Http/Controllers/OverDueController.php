<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\OverDue;
use DB;
use Session;
class OverDueController extends Controller
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
        $OverDuees = \DB::table("over_dues")
                ->select("*",
                    \DB::raw('(CASE 
                        WHEN over_dues.status = "1" THEN "Active" 
                        WHEN over_dues.status = "2" THEN "Inactive" 
                        END) AS status'))
                ->paginate(10);
        return view('over_due.date_claim_home')->with('OverDuees', $OverDuees);  
      

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('over_due.date_claim_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $results=OverDue::where('status', $request->status)->pluck('status');
        if(count($results)>0){

            if($results['0']=='1'){
                
                Session::flash("danger", "Already  Active Another Claim..!!");
                return redirect('/ci_date_claim');
            }
            
        }
        $OverDue=new OverDue();
        $OverDue->days=$request->days;
        if($request->date){
          $OverDue->date=date('Y-m-d', strtotime($request->date));
        }
        $OverDue->status=$request->status;
        $OverDue->save();
        Session::flash("success", "Over Due Created Succcessfully !");
        return redirect('/over_due');
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
        $OverDue=OverDue::findorfail($id);
        return view('over_due.date_claim_edit')
               ->with('dateClaim',$OverDue);
        
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
         
        $results=OverDue::where('status', $request->status)->pluck('status');
        if(count($results)>0){

            if($results['0']=='1'){
                
                Session::flash("danger", "Already  Active Another Claim..!!");
                return redirect('/over_due');
            }
            
        }

        $OverDue=OverDue::findorfail($id);
        $OverDue->days=$request->days;
        if($request->date){
          $OverDue->date=date('Y-m-d', strtotime($request->date));
        }
        $OverDue->status=$request->status;
        $OverDue->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect('/over_due'); 


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
