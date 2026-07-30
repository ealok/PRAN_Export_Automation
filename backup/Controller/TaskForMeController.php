<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\SaleContract;
use App\JobOrderMaster;
use App\POMaster;
use App\PODetails;
use Auth;
use App\TaskDefinition;
use App\TaskUpdatedHistory;
use App\User;
use App\NotifyParty;
use App\NotifyPartyUser;
use App\UserArea;
use App\seaPortdashboard;
use App\LandPortDashboard;
use App\SpecialApprove;

class TaskForMeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        // $user_id=Auth::user()->id;
        // $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
        //             from notify_parties
        //             join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
        //             where notify_party_users.user_id='$user_id'
        //             and notify_parties.status=1"); 
        // return view('taskforme.index',compact('notifyParties'));
        

    }

    public function getTaskList(Request $request){
              
        if(UserArea::where('user_id',Auth::user()->id)->exists()){
            
            $area_ids=UserArea::where('user_id',Auth::user()->id)->pluck('area_id')->toArray();
            $area_ids=implode(',',$area_ids);
            $results=DB::select("CALL USER_PO_LIST(?)",[$area_ids]); 
            
        }else{
            
            $area_id=0;
            $results=DB::select("CALL USER_PO_LIST($area_id)");

        }

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

    public function getUpgradeMytaskDetails(Request $request){
       
        
        $saleContract=SaleContract::where('po_master_id',$request->id)->first(['id','po_number']);
        $type_id=User::where('id',Auth::user()->id)->first(['type_id']);
        $user_id=Auth::user()->id;
        if($saleContract->po_number==""){

            return response()->json([
                'userTaskLists'=>'',
                'po_master_id'=>'',
                'jo_id'=>'',
                'sc_id'=>'',
                'sales_contact_lists'=>'',
                'job_order_lists'=>'',
                'po_number'=>'',
                'error'=>'po_error'     
            ],200);

        }
        $sc_id=$request->id;
        $jo_id='';
        if($saleContract->po_number){

            $po_number=$saleContract->po_number; 
            $poMaster=POMaster::where('PO_NO',$po_number)->first(['id','TEMPLATE_ID']);
            $poMasterId=$poMaster->id;
            $userId=Auth::user()->id;
            $sale_contact_id=$saleContract->id;
            if($poMaster->TEMPLATE_ID==1){

                $userTaskLists=DB::select("CALL UPDATE_TASK_LIST_LAND($sale_contact_id,$userId)");

            }elseif($poMaster->TEMPLATE_ID==3) {
                
                $userTaskLists=DB::select("CALL UPDATE_TASK_LIST_SEA($sale_contact_id,$userId)");
            }

        }else{

            $userTaskLists="";

        }

        return response()->json([
            'userTaskLists'=>$userTaskLists,
            'po_master_id'=>$request->id,
            'error'=>''     
        ],200);

    }

    public function jsonLoadSynTask(Request $request){

        $sale_contract=SaleContract::where('po_master_id',$request->po_master_id)->first(['id','po_number']);
        if($sale_contract->po_number){

            $po_number=$sale_contract->po_number; 
            $poMaster=POMaster::where('PO_NO',$po_number)->first(['id','TEMPLATE_ID']);
            $poMasterId=$poMaster->id;
            $userId=Auth::user()->id;
            $sale_contact_id=$sale_contract->id;
            if($poMaster->TEMPLATE_ID==1){

                $updateTaskLists=DB::select("CALL UPDATE_TASK_LIST_LAND($sale_contact_id,$userId)");

            }elseif($poMaster->TEMPLATE_ID==3) {
                
                $updateTaskLists=DB::select("CALL UPDATE_TASK_LIST_SEA($sale_contact_id,$userId)");
            }

        }
        
        return response()->json([
            'updateTaskLists'=>$updateTaskLists
        ]);


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
    
  
        $saleContact=SaleContract::where('po_master_id',$request->po_master_id)->first(['id','sales_contract_no','po_number']);
        $po_master=POMaster::where('PO_NO',$saleContact->po_number)->first(['ID','TEMPLATE_ID']);
        $file='';
        // if($files = $request->file('file')) {

        //     $file = $request->file->store('public/task');

        // }

        if($po_master->TEMPLATE_ID==1){
             
            LandPortDashboard::where('sc_id', $saleContact->id)
                ->where('Task_ID',$request->task_id)
                ->update([
                    'action_date' =>date("Y-m-d", strtotime($request->task_date)),
                    'file_name'=>$file,
                    'updated_by'=>Auth::user()->id
                ]);

            if($request->task_id==21){

                SaleContract::where('id',$saleContact->id)->update([
                    'approver_id'=>Auth::user()->id,
                    'approved_at'=>date('Y-m-d')
                ]);  

            }    

        }else{

            $date=date("Y-m-d");
            seaPortdashboard::where('sc_id',$saleContact->id)
                ->where('Task_ID',$request->task_id)
                ->update([
                    'action_date' =>date("Y-m-d", strtotime($request->task_date)),
                    'file_name'=>$file,
                    'updated_by'=>Auth::user()->id
            ]);

            if($request->task_id==21){

                SaleContract::where('id',$saleContact->id)->update([
                    'approver_id'=>Auth::user()->id,
                    'approved_at'=>date('Y-m-d')
                ]);  

            }  

        }

        return response()->json(['status'=>'success']);
        

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
      
    }

    public function taskQuery(){
     
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                        from notify_parties
                        join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                        where notify_party_users.user_id='$user_id'");
        return view('taskforme.task_query',compact('notifyParties'));
        
    }

    public function getLandPortTaskQuery(Request $request){


        $from_date=date("Y-m-d", strtotime($request->from_date));
        $to_date=date('Y-m-d', strtotime($request->to_date));
        $query='';
        switch($request->port_type) {

            case 1:
                
                $taskNamesLand=DB::select("SELECT task_definition.ID as id ,task_definition.DESCRIPTION as name
                                    FROM `template_details`
                                    join task_definition on task_definition.ID=template_details.TASK_ID
                                    WHERE MASTER_ID=1");

                foreach($taskNamesLand as $task){

                    $id=$task->id;
                    $name=$task->name;
                    $query .=", MAX(IF(t1.Task_ID=$id, action_date,'')) as `col_$id`";
                
                }
                
                $results=\DB::select("select
                        po_no,
                        sc_id as id,
                        sc_no as invoice_no
                        ".$query."
                        from landport_dashboard_data as t1
                        where (date(sc_date) >='$from_date' and date(sc_date) <='$to_date') and party_id='$request->party_id'
                        group by t1.po_no, sc_no, sc_id");

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

                break;

            case 2:
                
                $taskNamesLand=DB::select("SELECT task_definition.ID as id ,task_definition.DESCRIPTION as name
                                    FROM `template_details`
                                    join task_definition on task_definition.ID=template_details.TASK_ID
                                    WHERE MASTER_ID=3");
                foreach($taskNamesLand as $task){

                    $id=$task->id;
                    $name=$task->name;
                    $query .=", MAX(IF(t1.Task_ID=$id, action_date,'')) as `col_$id`";
                
                }

                $results=\DB::select("select
                        po_no,
                        sc_id as id,
                        sc_no as invoice_no
                        ".$query."
                        from seaport_dashboard_data as t1
                        WHERE (date(sc_date) >='$from_date' and date(sc_date) <='$to_date') and party_id='$request->party_id'
                        group by t1.po_no, sc_no, sc_id");

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

                break;

        }         


    }

    public function updatedSpecialTaskLand(Request $request){
        
        $result=LandPortDashboard::where('sc_id',$request->sc_id)->where('Task_ID',34)->update([
              
           'action_date'=>date('Y-m-d')

        ]);

        $specialApproval=new SpecialApprove();
        $specialApproval->sc_id=$request->sc_id;
        $specialApproval->approve_id=Auth::user()->id;
        $specialApproval->approve_date=date('Y-m-d');
        $specialApproval->save();

        if($result){

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


    public function taskQueryApproval(Request $request){
     
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                        from notify_parties");
        return view('taskforme.task_query_approval',compact('notifyParties'));   
           

    }

    public function updatedSpecialTaskSea(Request $request){
        
        $result=seaPortdashboard::where('sc_id',$request->sc_id)->where('Task_ID',33)->update([
              
           'action_date'=>date('Y-m-d')

        ]);

        $specialApproval=new SpecialApprove();
        $specialApproval->sc_id=$request->sc_id;
        $specialApproval->approve_id=Auth::user()->id;
        $specialApproval->approve_date=date('Y-m-d');
        $specialApproval->save();

        if($result) {

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

    public function tnaHitRateReport(){

        return view('taskforme.tna_hit_rate_report');

    }

    public function getHitrateReportData(Request $request){

         
        $from_date=NULL; 
        if($request->from_date){
           
            $from_date=date("Y-m-d", strtotime($request->from_date));
            
        } 

        $to_date=NULL;
        if($request->to_date){
           
            $to_date=date("Y-m-d", strtotime($request->to_date));
 
        }
        $results=DB::select("select
                UPPER(desk.name) as DESK,
                t1.desk_head as DESK_HEAD,
                COUNT(tna_report.Task_ID) as TOTAL_TASK,
                SUM(CASE WHEN tna_report.action_date IS NOT NULL THEN 1 ELSE 0 END) AS COMPLETE_TASK,
                SUM(CASE WHEN (tna_report.Task_ID is not null && tna_report.action_date IS NULL) THEN 1 ELSE 0 END) AS INCOMPLETE_TASK,
                ROUND(COALESCE(SUM(CASE WHEN tna_report.action_date IS NOT NULL THEN 1 ELSE 0 END)*100/COUNT(tna_report.Task_ID),0),2) as PERCENT
                from tna_report
                left join users on users.id = tna_report.user_id
                left join desk_setup on desk_setup.DESK_HEAD_ID=users.head_id
                left join desk on desk.id=desk_setup.DESK_ID
                join (
                    select users.name as desk_head,users.id as head_id
                    from desk_setup
                    join users on users.id=desk_setup.DESK_HEAD_ID
                    group by desk_setup.DESK_HEAD_ID
                    ) t1 on t1.head_id=users.head_id
                where (tna_report.sc_date>='$from_date' and tna_report.sc_date<='$to_date')
                group by desk.name
                order by DESK ASC");

        return response()->json([
            'results'=>$results
        ],200);
    
    }

    public function updateExpDuplicate(Request $request){
     
        $saleContract=SaleContract::where('id',$request->sc_id)->first(['id','po_number']);    
        if($saleContract->po_number){
 
            $poMaster=POMaster::where('PO_NO',$saleContract->po_number)->first(['id','TEMPLATE_ID']);
            if($poMaster->TEMPLATE_ID==1){
                
                $landPortDash=LandPortDashboard::where('sc_id',$request->sc_id)->where('Task_ID',$request->task_id)->first(['action_date']);
                if(is_null($landPortDash->action_date)){
                   
                    LandPortDashboard::where('sc_id',$request->sc_id)->where('Task_ID',$request->task_id)->update([
                        'action_date'=>date('Y-m-d') 
                     ]);

                }

            }elseif($poMaster->TEMPLATE_ID==3) {
                
                $seaPortDash=seaPortdashboard::where('sc_id',$request->sc_id)->where('Task_ID',$request->task_id)->first(['action_date']);
                if(is_null($seaPortDash->action_date)){
                   
                    seaPortdashboard::where('sc_id',$request->sc_id)->where('Task_ID',$request->task_id)->update([
                        'action_date'=>date('Y-m-d') 
                     ]);

                }
            }

        }


    }


    public function updatePhytoTaskDate(Request $request){

        $saleContract=SaleContract::where('id',$request->sc_id)->first(['id','po_number']);    
        if($saleContract->po_number){
 
            $poMaster=POMaster::where('PO_NO',$saleContract->po_number)->first(['id','TEMPLATE_ID']);
            if($poMaster->TEMPLATE_ID==1){
                
                if(LandPortDashboard::where('sc_id',$request->sc_id)->where('Task_ID',$request->task_id)->count()>0){
                    
                    $landPortDash=LandPortDashboard::where('sc_id',$request->sc_id)->where('Task_ID',$request->task_id)->first(['action_date']);
                    if(is_null($landPortDash->action_date)){
                    
                        LandPortDashboard::where('sc_id',$request->sc_id)->where('Task_ID',$request->task_id)->update([
                            'action_date'=>date('Y-m-d') 
                        ]);

                    }

                }
                
            }elseif($poMaster->TEMPLATE_ID==3) {
                
                if(seaPortdashboard::where('sc_id',$request->sc_id)->where('Task_ID',$request->task_id)->count()>0){

                    $seaPortDash=seaPortdashboard::where('sc_id',$request->sc_id)->where('Task_ID',$request->task_id)->first(['action_date']);
                    if(is_null($seaPortDash->action_date)){
                       
                        seaPortdashboard::where('sc_id',$request->sc_id)->where('Task_ID',$request->task_id)->update([
                            'action_date'=>date('Y-m-d') 
                         ]);
    
                    } 

                }

            }

        } 
        

    }

    public function invoiceSearchTnaApprovalFun(Request $request){
 
        $results =DB::select("SELECT
                sale_contracts.id,
                sale_contracts.po_number,
                sale_contracts.invoice_no,
                date_format(sale_contracts.invoice_date,'%d-%m-%Y') as invoice_date,
                case when (t1.action_date is null and t2.action_date is null) then 'Not Approve'
                when (t1.action_date is not null or  t2.action_date is not null) then 'Approve'
                end as status,
                users.name as user
                FROM sale_contracts
                join users on users.id=sale_contracts.creator_id
                left join (
                            select po_id,action_date from landport_dashboard_data where Task_ID=32
                            ) t1 on t1.po_id=sale_contracts.po_master_id
                left join (
                    select po_id,action_date from seaport_dashboard_data where Task_ID=32
                    ) t2 on t2.po_id=sale_contracts.po_master_id
                WHERE (sale_contracts.sales_contract_no like '%$request->sales_contract_no%'
                    OR sale_contracts.export_no like '%$request->sales_contract_no%'
                    OR sale_contracts.invoice_no like '%$request->sales_contract_no%')
                ORDER BY sale_contracts.id desc");

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
                "data"    =>[]
            ]);
        }  

    }

    public function makeTnaFinalApproval(Request $request){

        try {

            $saleContract = SaleContract::where('id', $request->sc_id)->first(['id', 'po_number']);
            if($saleContract->po_number) {

                $poMaster = POMaster::where('PO_NO', $saleContract->po_number)->first(['id', 'TEMPLATE_ID']);
                if($poMaster && $poMaster->TEMPLATE_ID == 1){

                    if(LandPortDashboard::where('sc_id', $request->sc_id)->where('Task_ID', 32)->count()>0) {

                        $landPortDash = LandPortDashboard::where('sc_id', $request->sc_id)->where('Task_ID', 32)->first(['action_date']);
                        if(is_null($landPortDash->action_date)) {

                            $updateStatus=LandPortDashboard::where('sc_id', $request->sc_id)
                                ->where('Task_ID', 32)
                                ->update([
                                    'action_date' => date('Y-m-d')
                                ]);
                            
                            if($updateStatus){

                                return response()->json([
                                    'message' => "Your Approval Done..!!",
                                    "code"    => 200
                                ]);

                            }
                                 
                        }

                    }

                } 

                elseif($poMaster && $poMaster->TEMPLATE_ID == 3) {

                    if (seaPortdashboard::where('sc_id', $request->sc_id)->where('Task_ID', 32)->exists()) {

                        $seaPortDash = seaPortdashboard::where('sc_id', $request->sc_id)->where('Task_ID', 32)->first(['action_date']);
                        if (is_null($seaPortDash->action_date)) {

                            $updateStatus=seaPortdashboard::where('sc_id', $request->sc_id)
                                ->where('Task_ID', 32)
                                ->update([
                                    'action_date' => date('Y-m-d')
                                ]);

                            if($updateStatus){

                                return response()->json([
                                    'message' => "Your Approval Done..!!",
                                    "code"    => 200
                                ]);

                            }    

                        }

                    }
                }

            } else {

                return response()->json([
                    'message' => "Approval Fail..!!",
                    "code"    => 500
                ]);


            }
        } catch (QueryException $e) {

            return response()->json([
                'message' => 'Database error: ' . $e->getMessage(),
                'code'    => 500
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
                'code'    => 500
            ]);
        }


    }
        
}
