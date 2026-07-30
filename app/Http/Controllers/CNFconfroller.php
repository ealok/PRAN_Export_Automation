<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CNF;
use App\SaleContract;
use App\CtDepot;
use Auth;
use DB;
class CNFconfroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          
        $current_date=date('Y-m-d'); 
        $previous_date=date('Y-m-d', strtotime('-12 month'));
        $sale_contracts=SaleContract::where('invoice_date','<=',$current_date)
                        ->select('sale_contracts.invoice_no','sale_contracts.id')
                        ->where('invoice_date','>=',$previous_date)
                        ->where('inactive','!=','Y')
                        ->whereNotNull('desk_approver_id')
                        ->get(); 

        $depots=CtDepot::all();
        $lastJobId = CNF::orderBy('id', 'desc')->value('job_no');   
        return view('cnf.cnf_index',compact('sale_contracts'))
               ->with('lastJobId',$lastJobId)
               ->with('depots',$depots);

    }

    public function getCNFList(){

        return view('cnf.cnf_list_view'); 

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
        

        // return $request->all();
        // if(CNF::where('sale_contract_id', $request->invoice_id)->count()==0){
            CtDepot::where('id',$request->depot_id)->value('name');
            $cnf=new CNF();
            $cnf->sale_contract_id=$request->invoice_id;
            $cnf->job_no=$request->job_no;
            $cnf->sb_no=$request->sb_no;
            $cnf->sb_date=date("Y-m-d", strtotime($request->sb_date));
            $cnf->assessable_rate=$request->assessable_rate;
            $cnf->examine_date=date("Y-m-d", strtotime($request->examine_date));
            $cnf->doc_send_date=date("Y-m-d", strtotime($request->doc_send_date));
            $cnf->depot_name=CtDepot::where('id',$request->depot_id)->value('name');
            $cnf->depot_id=$request->depot_id;
            $cnf->doc_rvd_date=date("Y-m-d", strtotime($request->doc_rvd_date));
            $cnf->invoice_value=$request->invoice_value;
            $cnf->iuid=Auth::user()->id;
            $cnf->save();
            if($cnf->id) {
                
                $cnf=CNF::where('id',$cnf->id)->first(['job_no']);
                return response()->json([
                    'message' => "Information Updated Successfully..!!",
                    "code"    => 200,
                    "last_id" => $cnf->job_no
                ]);

            }     

            
        // }else {

        //     return response()->json([
        //         'message' => "This invoice already updated",
        //         "code"    => 400
        //     ]);

        // }
       
    }

    public function jsonGetCnfList(Request $request){


        $from_date=NULL; 
        if($request->from_date){
           
            $from_date=date("Y-m-d", strtotime($request->from_date));
            
        } 

        $to_date=NULL;
        if($request->to_date){
           
            $to_date=date("Y-m-d", strtotime($request->to_date));
 
        }
        
        $results=DB::select("CALL PROC_CNF_EDIT_LIST(?,?)", [$from_date,$to_date]);
        if($results){

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"    => $results
            ]);

        }else{

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"    => []
            ]);

        }   
         

    }

    public function cnfReprotView(Request $request){

        return view('cnf.cnf_report_view');

    }

    public function cnfReprotData(Request $request){

        $from_date=NULL; 
        if($request->from_date){
           
            $from_date=date("Y-m-d", strtotime($request->from_date));
            
        } 

        $to_date=NULL;
        if($request->to_date){
           
            $to_date=date("Y-m-d", strtotime($request->to_date));
 
        }
        
        $results=DB::select("CALL PROC_CNF_REPORT(?,?)", [$from_date,$to_date]);
        if($results){

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"    => $results
            ]);

        }else{

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"    => []
            ]);

        }           


    }

    public function cnfEditDetails(Request $request){

        
        $results=CNF::findorfail($request->edit_id);
        $depots=CtDepot::all();
        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "result"  => $results,
                "depots" => $depots
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "result"  => [],
                "depots"  => []
            ]);

        }


    }

    public function cnfUpdate(Request $request){
          
        $result=CNF::where('id', $request->edit_id)->update([
            "sb_no"=>$request->sb_no,
            "job_no"=>$request->job_no,
            "sb_date"=>date("Y-m-d", strtotime($request->sb_date)),
            "assessable_rate"=>$request->assessable_rate,
            "examine_date"=>date("Y-m-d", strtotime($request->examine_date)),
            "doc_send_date"=>date("Y-m-d", strtotime($request->doc_send_date)),
            "depot_id"=>$request->depot_id,
            "depot_name"=>CtDepot::where('id',$request->depot_id)->value('name'),
            "doc_rvd_date"=>date("Y-m-d", strtotime($request->doc_rvd_date)),
            "invoice_value"=>$request->invoice_value,
            "iuid"=>Auth::user()->id,
        ]);
        
        if($result) {

            return response()->json([
                'message' => "Updated Successfully Done",
                "code"    => 200
            ]);

        } else  {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 400
            ]);

        }


    }

    public function jsonGetInvoieValue(Request $request){
            
        $result=SaleContract::where('id',$request->invoice_id)->first(['total_ci_value']);
        if($result) {

            return response()->json([
                'message' => "Data Updated Successfully!",
                "code"    => 200,
                "date"    => $result->total_ci_value
            ]);

        } else  {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "date"    => ''
            ]);

        }

    }

    public function checkingCnfJobNo(Request $request){

          
        if(CNF::where('job_no',$request->job_no)->count()==0){
             
            return response()->json([
                'status'=>false
            ]);

        }else{
            
            return response()->json([
                'status'=>false
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
