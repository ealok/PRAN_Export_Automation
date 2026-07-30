<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use DB;
use App\SaleContract;
use App\Company;
use App\ComInvMaster;
use App\BapaBillSetup;
use App\BapaRecv;
use Auth;
class BapaBillReceivController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        return view('bapa_recv.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $results=BapaRecv::where('sales_contact_id',$request->invoice_id)->first();
        if(is_null($results)){
 
            $bapaRcv=new BapaRecv();
            $bapaRcv->sales_contact_id=$request->invoice_id;
            $bapaRcv->company_id=$request->company_id;
            $bapaRcv->use_rate=$request->usd_rate;
            $bapaRcv->processing_fee=$request->processing_fee;
            $bapaRcv->net_fob=$request->net_fob;
            $bapaRcv->claim_amount=$request->claim_amount;
            $bapaRcv->subsidy_fee=$request->subsidy_fee;
            $bapaRcv->payable_amount=$request->total_payable;
            $bapaRcv->exp_no=$request->exp_no;
            $bapaRcv->recv_date=date("Y-m-d", strtotime($request->receive_date));
            $bapaRcv->iuid=Auth::user()->id;
            $bapaRcv->euid=Auth::user()->id;
            $bapaRcv->save();
            if($bapaRcv) {

                return response()->json([
                    'message' => "Data Inserted Successfully",
                    "code"    => 200,
                ]);

            }

        }else{

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
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

    public function jsonGetComMasterInvList(Request $request){
      
       
        $results=DB::select("CALL PROC_BAPA_INV_LIST()");                
        return response()->json([
            'data'=>$results,
            'status'=>200
        ]);

    }

    public function jsonGetCompanyList(Request $request){
      
        $results=Company::all();
        return response()->json([
            'data'=>$results,
            'status'=>200
        ]);

    }

    public function getBapaRcvList(Request $request){
        
        $from_date=NULL; 
        if($request->from_date){
           
            $from_date=date("Y-m-d", strtotime($request->from_date));
            
        }  
        $to_date=NULL;
        if($request->to_date){
           
            $to_date=date("Y-m-d", strtotime($request->to_date));
 
        }

        $user_id=Auth::user()->id;
        $company_id=NULL; 
        if($request->company_id){

            $company_id=$request->company_id;

        }

        $status=NULL; 
        if($request->status){

            $status=$request->status;
        }

        $results=DB::select("CALL PROC_BAPA_RECV_LIST(?,?,?,?,?)", [$from_date,$to_date,$user_id,$company_id,$status]);

        if($results) {
            
            return response()->json([         
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);
			
        }else {
			
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);

        }

    }

    public function jsonBapaRcvDetails(Request $request){
         
        $net_fob=0;
        $claim_amount=0;
        $subsidy_fee=0;
        $prcessing_fee=0;
        $payable_amount=0;
        $company_id='';
        $exp_no='';
        $companies=Company::all();
        $bapaBillsetup = BapaBillSetup::orderBy('id', 'desc')->first();    
        if(SaleContract::where('id',$request->invoice_id)->exists()){

            $saleContact=SaleContract::where('id',$request->invoice_id)->first(['company_id','export_no']);
            $company_id=$saleContact->company_id;
            $exp_no= $saleContact->export_no;

        }

        if(ComInvMaster::where('sale_contact_id',$request->invoice_id)->exists()){
           
            $comInvMaster=ComInvMaster::where('sale_contact_id',$request->invoice_id)->first(['net_fob']);
            $net_fob=$comInvMaster->net_fob;
            $claim_amount=($comInvMaster->net_fob*20)/100;
            $subsidy_fee=(($claim_amount*$bapaBillsetup->use_rate)*.25)/100;
            $payable_amount=$subsidy_fee+$bapaBillsetup->processing_fee;

        }
        
        return response()->json([
            "companies"     => $companies,
            "company_id"    => $company_id,
            "net_fob"       => $net_fob,
            "claim_amount"  => round(($net_fob*20)/100,6),
            "subsidy_fee"   => round($subsidy_fee,6),
            "prcessing_fee" => $bapaBillsetup->processing_fee,            
            "exp_no"        => $exp_no,
            "payable_amount"=> round($payable_amount,6),
            "usd_rate"      => $bapaBillsetup->use_rate 
        ],200);
        
    }

    public function bapaPrintPadView(Request $request){

        $encodedArray = $request->xxx;
        $myArray = json_decode(urldecode($encodedArray));
        $recv_ids = substr($myArray, 1, -1);
        $string_array=explode(",",$recv_ids);
        $com_inv_master=ComInvMaster::findorfail($string_array[0]);
        $sale_contract=SaleContract::findorfail($com_inv_master->sale_contact_id);
        $results=DB::select("CALL PROC_BAPA_PRINT(?)",[$recv_ids]);
        return view('bapa_recv.pad_view',compact('results'))
                ->with('sale_contract',$sale_contract)
                ->with('recv_ids',$recv_ids);

    }

    public function bapaBillView(Request $request){
        
        return view('bapa_recv.bapa_bill');

    }

    public function jsonBapaBill(Request $request){
       
        $from_date=NULL; 
        if($request->from_date){
           
            $from_date=date("Y-m-d", strtotime($request->from_date));
            
        }  
        $to_date=NULL;
        if($request->to_date){
           
            $to_date=date("Y-m-d", strtotime($request->to_date));
 
        }

        $status_id=NULL; 
        if($request->status_id){

            $status_id=$request->status_id;

        }
        
        $results=DB::select("CALL PROC_BAPA_BILL(?,?,?)", [$from_date,$to_date,$status_id]);   
        if($results) {
            
            return response()->json([         
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);
			
        }else {
			
            return response()->json([

                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
                
            ]);
        }
        

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

    public function bapaUpdatePrintStatus(Request $request){
         
        $array = explode(',', $request->ids);
        if(ComInvMaster::whereIn('id',$array)->update([

           'recv_status' =>  'Y',
           'recv_date'     => date('Y-m-d'),
           'recv_by'   =>  Auth::user()->id

        ])){
           
            return response()->json([

                'message' => "Data Updated Successfully!",
                "code"    => 200,
            ]);
            

        }else{
              
            return response()->json([

                'message' => "Internal Server Error",
                "code"    => 500
            ]);

        }

    }

    public function updateBapaBillStatus(Request $request){
    
        if(ComInvMaster::whereIn('id',$request->ids)->update([

            'bill_status' =>  'Y',
            'bill_date'     =>  date('Y-m-d'),
            'bill_by'   =>  Auth::user()->id
 
        ])){
            
            return response()->json([

                'message' => "Data Updated Successfully!",
                "code"    => 200,
            ]);

 
        }else{
               
            return response()->json([

                'message' => "Internal Server Error",
                "code"    => 500
            ]);
 
        }       


    }

    public function bapaBillReport(Request $request){
      
        return view('bapa_recv.bill_report');

    }

}


