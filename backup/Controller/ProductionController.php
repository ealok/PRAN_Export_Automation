<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\JobOrderMaster;
use App\Group;
use App\ProductionMaster;
use App\ProductionDetails;
use App\ProductionFloor;
use App\SaleContract;
use App\POMaster;
use App\PODetails;
use App\User;
use App\POUserDetail;
use App\POUser;
use App\LandPortDashboard;
use App\seaPortdashboard;
use Auth;
use App\Desk;
use App\DeskSetup;
use DB;
use App\SaleContractDetail;
class ProductionController extends Controller
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
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $current_date=date('Y-m-d'); 
        $previous_date=date('Y-m-d', strtotime('-1 month'));
        $p_floors=ProductionFloor::all();
        return view('production.create')
              ->with('p_floors',$p_floors)
              ->with('current_date',$current_date)
              ->with('previous_date',$previous_date);

    }

    public function productionFloorWiseJOSCList(Request $request){
        
        $from_date=date("Y-m-d", strtotime($request->from_date));
        $to_date=date("Y-m-d", strtotime($request->to_date));
        $results=DB::select("SELECT job_order_masters.id,
                    sale_contracts.invoice_no,
                    job_order_masters.job_order_number,
                    countries.name,
                    notify_parties.country,
                    job_order_masters.created_at
            FROM job_order_masters
            JOIN sale_contracts ON sale_contracts.id=job_order_masters.sale_contract_id
            JOIN notify_parties ON notify_parties.id=sale_contracts.notify_pary_id
            JOIN countries ON countries.id=sale_contracts.country_id
            where (job_order_masters.created_at>='$from_date' AND job_order_masters.created_at <='$to_date')
                  and job_order_masters.p_floor_id='$request->pfloor_id' 
                  and sale_contracts.inactive='N' and job_order_masters.status!=3
            ORDER BY notify_parties.country");
            
        return response()->json(['results'=>$results]); 


    }

    public function productionFloorWiseJOB(Request $request){
           
        $from_date=date("Y-m-d", strtotime($request->from_date));
        $to_date=date("Y-m-d", strtotime($request->to_date));
        $prod_floor_id=$request->pfloor_id; 
        $results=DB::select("CALL PROC_PROD_FLOOR_WISE_SC_JO_LIST(?,?,?)",[$from_date,$to_date,$prod_floor_id]);    
        return response()->json(['results'=>$results]);  

    }

    public function  jsonGetScWiseJODetails(Request $request){
              
        $sc_id=$request->sc_id;
        $results=DB::select("CALL PROC_SC_WISE_JO_DETAILS($sc_id)"); 
        return response()->json(['results'=>$results]);
 

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

    public function jsonGetJOBDetails(Request $request){
        
        $results=\DB::select("select a.item_id,a.item_code,a.item_name,a.order_qty,sum(a.prod_qty) as prod_qty,a.order_qty-sum(a.prod_qty) as due_qty,
                MAX(a.date) as date 
                from ((SELECT
                    job_order_details.item_id,
                    ci_items.ci_item_code AS item_code,
                    ci_items.ci_item_name AS item_name,
                    ROUND(job_order_details.orqt/ci_items.ci_factor,0) AS order_qty,
                    0 as prod_qty,
                    '' as date
                FROM
                    job_order_masters
                    JOIN job_order_details ON job_order_details.master_id = job_order_masters.id
                    JOIN ci_items ON ci_items.id = job_order_details.item_id
                WHERE
                    job_order_masters.id ='$request->job_order_id')
                
                union all
                
                (SELECT
                    production_details.item_id,
                    ci_items.ci_item_code AS item_code,
                    ci_items.ci_item_name AS item_name,
                    production_details.order_qty AS order_qty,
                    SUM(production_details.prod_qty) AS prod_qty,
                    MAX(production_details.date) as date
                FROM
                    production_details
                    JOIN ci_items ON ci_items.id = production_details.item_id
                where production_details.job_order_id='$request->job_order_id'
                GROUP BY
                    production_details.item_id,
                    ci_items.ci_item_code,
                    ci_items.ci_item_name,
                    production_details.order_qty)) a
                group by a.item_id,a.item_code,a.item_name,a.order_qty");    


        return response()->json([
           
            'results'=>$results,
            'status'=>200

        ]);

    }

    public function storeProdDetails(Request $request){
       
        for($i=0; $i<sizeof($request->prod_details); $i++) {
          
           if((int)$request->prod_details[$i]['entered_qty']!==0){
              
                $prodDetails=new ProductionDetails(); 
                $prodDetails->job_order_id=$request->job_order_id; 
                $prodDetails->date=date("Y-m-d", strtotime(date('Y-m-d')));
                $prodDetails->item_id=$request->prod_details[$i]['item_id'];
                $prodDetails->order_qty=$request->prod_details[$i]['order_qty'];
                if((int)$request->prod_details[$i]['order_qty'] > (int)$request->prod_details[$i]['entered_qty']){
    
                    if((int)$request->prod_details[$i]['prod_qty']==0){
                    
                        $prodDetails->prod_qty=(int)$request->prod_details[$i]['entered_qty'];
    
                    }else{
    
                        $variance=(int)$request->prod_details[$i]['order_qty']-(int)$request->prod_details[$i]['prod_qty'];
                        if($variance <= (int)$request->prod_details[$i]['entered_qty']){
    
                            $prodDetails->prod_qty=$variance;
    
                        }else{
    
                            $prodDetails->prod_qty=(int)$request->prod_details[$i]['entered_qty']; 
    
                        }   
    
                    }
                    
                    
                }
    
                if((int)$request->prod_details[$i]['order_qty'] < (int)$request->prod_details[$i]['entered_qty']){
    
                    
                    if((int)$request->prod_details[$i]['prod_qty']==0){
                            
                        $prodDetails->prod_qty=(int)$request->prod_details[$i]['order_qty']; 
        
                    }else{
        
                        $variance=(int)$request->prod_details[$i]['order_qty']-(int)$request->prod_details[$i]['prod_qty'];
                        if($variance <= (int)$request->prod_details[$i]['entered_qty']){
        
                            $prodDetails->prod_qty=$variance;
        
                        }else{
        
                            $prodDetails->prod_qty=(int)$request->prod_details[$i]['entered_qty']; 
        
                        }  
        
                    }
    
    
                }
    
                if((int)$request->prod_details[$i]['order_qty'] == (int)$request->prod_details[$i]['entered_qty']){
                    
                    if((int)$request->prod_details[$i]['prod_qty']==0){
                    
                        $prodDetails->prod_qty=(int)$request->prod_details[$i]['entered_qty'];
    
                    }else{
    
                        $variance=(int)$request->prod_details[$i]['order_qty']-(int)$request->prod_details[$i]['prod_qty'];
                        if($variance <= (int)$request->prod_details[$i]['entered_qty']){
    
                            $prodDetails->prod_qty=$variance;
    
                        }else{
    
                            $prodDetails->prod_qty=(int)$request->prod_details[$i]['entered_qty']; 
    
                        }   
    
                    }
    
                }
                $prodDetails->prod_floor_id=$request->prod_details[$i]['prod_floor'];
                $prodDetails->creator_id=Auth::user()->id;
                $prodDetails->save();

           }
             
           
        }

        return response()->json([
            'status'=>'success',
            200
        ]);

    }

    public function productionReport(Request $request){
        

        $current_date=date('Y-m-d'); 
        $previous_date=date('Y-m-d', strtotime('-1 month'));
        $p_floors=ProductionFloor::all();

        return view('production.report')
              ->with('p_floors',$p_floors)
              ->with('current_date',$current_date)
              ->with('previous_date',$previous_date);

    }

    public function jsonLoadProdReport(Request $request){
        
       
        $from_date=date("Y-m-d", strtotime($request->from_date));
        $to_date=date('Y-m-d', strtotime($request->to_date.' + 1 days'));
        $where = "(t1.created_at >= '$from_date' and t1.created_at <= '$to_date')";
        if($request->location_id!='All'){

            $where.=" and t1.prod_floor_id='$request->location_id'";

        }

        $results="";
        if($request->report_type==1){
           
            $results=DB::select("select
                t3.invoice_no,
                SUM(t1.order_qty) as order_qty,
                SUM(t1.prod_qty) as prod_qty,
                SUM(t1.order_qty-t1.prod_qty) as due_qty
            from production_details t1
                join job_order_masters t2 on  t2.id=t1.job_order_id
                join sale_contracts t3 on t3.id=t2.sale_contract_id
            where $where 
            group by t3.invoice_no"); 


        }else{

            $results=DB::select("select
                t3.invoice_no,
                t4.ci_item_name as item_name,
                t4.ci_item_code as item_code,
                SUM(t1.order_qty) as order_qty,
                SUM(t1.prod_qty) as prod_qty,
                SUM(t1.order_qty-t1.prod_qty) as due_qty
            from production_details t1
                join job_order_masters t2 on  t2.id=t1.job_order_id
                join sale_contracts t3 on t3.id=t2.sale_contract_id
                join ci_items t4 on t4.id=t1.item_id
            where $where
            group by t3.invoice_no,t4.ci_item_name,t4.ci_item_code
            order by t3.invoice_no");

        }

        return response()->json([
            'results'=>$results,
            'report_type'=>$request->report_type
        ],200);

    }

    public function joReceiveGetView(){

        $current_date=date('Y-m-d'); 
        $previous_date=date('Y-m-d', strtotime('-1 month'));
        $p_floors=ProductionFloor::all();
        return view('production.jo_receive')
              ->with('p_floors',$p_floors)
              ->with('current_date',$current_date)
              ->with('previous_date',$previous_date);

    }

    public function factoryDOQueryGetView(){

        $current_date=date('Y-m-d'); 
        $previous_date=date('Y-m-d', strtotime('-1 month'));
        $p_floors=ProductionFloor::all();

        return view('production.do_query')
              ->with('p_floors',$p_floors)
              ->with('current_date',$current_date)
              ->with('previous_date',$previous_date);

    }

    public function jsonGetScJOTaskList(Request $request){
          
        $saleContract=SaleContract::where('id',$request->sc_id)->first(['po_number']);
        $type_id=User::where('id',Auth::user()->id)->first(['type_id']);
        $user_id=Auth::user()->id;
        if($saleContract->po_number==""){

            return response()->json([
                'userTaskLists'=>'',
                'sales_contact_id'=>'',
                'error'=>'po_error'     
            ],200);

        }
        $sc_id=$request->id;
        $jo_id='';
        if($saleContract->po_number){
            
            $poMaster=POMaster::where('PO_NO',$saleContract->po_number)->first(['id']);
            $poMasterId=$poMaster->id;
            $userId=Auth::user()->id;
            $userTaskLists=DB::select("CALL UPDATE_TASK_LIST_FACTORY($poMasterId,$userId)");

        }else{

            $userTaskLists="";

        }

        return response()->json([
            'userTaskLists'=>$userTaskLists,
            'po_master_id'=>$poMasterId,
            'jo_no'=>$request->jo_number,
            'error'=>''     
        ],200);


    }

    public function jsonSaveJoStatus(Request $request){

        $joOrderMaster=JobOrderMaster::where('job_order_number',$request->jo_no)->first(['id','sale_contract_id']);
        $job_id=$joOrderMaster->id;
        $sale_contact_id=$joOrderMaster->sale_contract_id;
        $date=date('Y-m-d');
        $user_id=Auth::user()->id;
        if($request->task_id==2){
            
            JobOrderMaster::where('id', $job_id)
                ->update([
                    'jo_receive_status' => 'Y',
                    'jo_receive_date' => $date,
                    'jo_receive_by' =>$user_id
                    ]);

            LandPortDashboard::where('sc_id',$sale_contact_id)->where('Task_ID',2)->update([
            'action_date'=>date('Y-m-d')
            ]);
        
            seaPortdashboard::where('sc_id',$sale_contact_id)->where('Task_ID',2)->update([
            'action_date'=>date('Y-m-d')
            ]);
    
        }

        if($request->task_id==3){
            
            JobOrderMaster::where('id', $job_id)
                ->update([
                    'prod_status' => 'Y',
                    'prod_date' => $date,
                    'prod_by' =>$user_id
                    ]);
            
            LandPortDashboard::where('sc_id',$sale_contact_id)->where('Task_ID',1)->update([
                'action_date'=>date('Y-m-d')
                ]);
            
            seaPortdashboard::where('sc_id',$sale_contact_id)->where('Task_ID',3)->update([
                'action_date'=>date('Y-m-d')
            ]);        
    
        }
        
          

        return response()->json(['status'=>'success']);  
       

    }

    public function updatePoDetails(){
          
        $results=DB::select("select
                po_master.ID as master_id,
                po_master.TEMPLATE_ID as type,
                date(po_master.CREATE_DATE) as date
            from po_master where po_master.PO_NO='PO082022000072'");

        foreach ($results as $key => $value) {
          
             
            if($value->type==1){
                
                $isExist=PODetails::where('MASTER_ID',$value->master_id)->first();
                if(is_null($isExist)) {

                    $this->updatePoDetailsForLand($value->master_id,$value->date);
        
                }
                 
            }

            if($value->type==3){ 
                
                $isExist=PODetails::where('MASTER_ID',$value->master_id)->first();
                if(is_null($isExist)){

                    $this->updatePoDetailsForSea($value->master_id,$value->date); 
        
                }

            }


        }    


    }

    public function updatePoDetailsForLand($master_id,$from_date){
        
        $results=DB::select("SELECT template_details.TASK_ID as task_id,template_details.STANDARD_DAY as std
            FROM template_master
            JOIN template_details ON template_details.MASTER_ID=template_master.ID
            WHERE template_master.TEMPLATE_TYPE=1");

        $countDates=0;
        $current_date=$from_date;
        foreach ($results as $key => $value) {
            
            $countDates += $value->std;
            $PODetails=new PODetails();
            $checkPODetails=PODetails::where('MASTER_ID',$master_id)->orderBy('id','DESC')->first();
            $std=$value->std;
            if(is_null($checkPODetails)){
                
                $PODetails->MASTER_ID=$master_id;
                $PODetails->TASK_ID=$value->task_id;
                $PODetails->STD=$std;
                $PODetails->FROM_DATE=$current_date;
                $newDate = date('Y-m-d', strtotime($current_date . ' + ' . $countDates . ' days'));
                $PODetails->TO_DATE=$newDate;
                $PODetails->save();

            }else{
                
                if($std==0){
                    
                    $PODetails->MASTER_ID=$master_id;
                    $PODetails->TASK_ID=$value->task_id;
                    $PODetails->STD=$std;
                    $PODetails->FROM_DATE=$checkPODetails->FROM_DATE;
                    $PODetails->TO_DATE=date('Y-m-d', strtotime($checkPODetails->FROM_DATE . ' + ' . $countDates . ' days'));
                    $PODetails->save();  
                    
                }else{

                    $PODetails->MASTER_ID=$master_id;
                    $PODetails->TASK_ID=$value->task_id;
                    $PODetails->STD=$std;
                    $PODetails->FROM_DATE=$checkPODetails->TO_DATE;
                    $PODetails->TO_DATE=date('Y-m-d', strtotime($checkPODetails->TO_DATE . ' + ' . $countDates . ' days'));
                    $PODetails->save();

                }

            }
                
        }   

    }

    public function updatePoDetailsForSea($master_id,$from_date){
       
        $results=DB::select("SELECT template_details.TASK_ID as task_id,template_details.STANDARD_DAY as std
                FROM template_master
                JOIN template_details ON template_details.MASTER_ID=template_master.ID
                WHERE template_master.TEMPLATE_TYPE=2");

        $countDates=0;
        $current_date=$from_date;
        foreach ($results as $key => $value) {
            
            $countDates += $value->std;
            $PODetails=new PODetails();
            $checkPODetails=PODetails::where('MASTER_ID',$master_id)->orderBy('id','DESC')->first();
            $std=$value->std;
            if(is_null($checkPODetails)){
                
                $PODetails->MASTER_ID=$master_id;
                $PODetails->TASK_ID=$value->task_id;
                $PODetails->STD=$std;
                $PODetails->FROM_DATE=$current_date;
                $newDate = date('Y-m-d', strtotime($current_date . ' + ' . $countDates . ' days'));
                $PODetails->TO_DATE=$newDate;
                $PODetails->save();

            }else{
                
                if($std==0){
                    
                    $PODetails->MASTER_ID=$master_id;
                    $PODetails->TASK_ID=$value->task_id;
                    $PODetails->STD=$std;
                    $PODetails->FROM_DATE=$checkPODetails->FROM_DATE;
                    $PODetails->TO_DATE=date('Y-m-d', strtotime($checkPODetails->FROM_DATE . ' + ' . $countDates . ' days'));
                    $PODetails->save();  
                    
                }else{

                    $PODetails->MASTER_ID=$master_id;
                    $PODetails->TASK_ID=$value->task_id;
                    $PODetails->STD=$std;
                    $PODetails->FROM_DATE=$checkPODetails->TO_DATE;
                    $PODetails->TO_DATE=date('Y-m-d', strtotime($checkPODetails->TO_DATE . ' + ' . $countDates . ' days'));
                    $PODetails->save();

                }

            }
                
        }    

    }

    public function updatePoUser(){
          
        $results=DB::select("SELECT po_master.ID as master_id,t1.count,po_master.TEMPLATE_ID as `type`
                from po_master
                left join (select
                            po_user.PO_MASTER_ID as MASTER_ID,
                            count(po_user.TASK_ID) as count
                            from po_user
                            group by po_user.PO_MASTER_ID) as t1
                    on po_master.ID=t1.MASTER_ID
                where (t1.count is null or t1.count='')
                order by po_master.PO_NO");

        foreach ($results as $key => $value) {
          
            if($value->type==1){
                
                $this->updatePoUserForLand($value->master_id); 

            }

            if($value->type==3){ 
                
                $this->updatePoUserForSea($value->master_id);  

            }


        }    


    }

    public function updatePoUserForLand($master_id){
        
        $results=DB::select("SELECT template_details.TASK_ID as task_id,task_definition.USER_TYPE as user_type
                FROM template_master
                JOIN template_details ON template_details.MASTER_ID=template_master.ID
                join task_definition on task_definition.ID=template_details.TASK_ID
                WHERE template_master.TEMPLATE_TYPE=1");

        foreach($results as $key => $value) {

            if($value->user_type==1){
                 
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Desk';
                $Po_User->save();  

            }

            if($value->user_type==2){
            
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Accounts';
                $Po_User->save();  
                

            }
            if($value->user_type==3){
               
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Production';
                $Po_User->save();
                

            }
            if($value->user_type==4){
               
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Documentation';
                $Po_User->save();
                
                
            }
            

            if($value->user_type==6){
              
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Desk Head';
                $Po_User->save();
                    
            }
            
            
        }



    }
    
    public function updatePoUserForSea($master_id){
    
        $results=DB::select("SELECT template_details.TASK_ID as task_id,task_definition.USER_TYPE as user_type
                FROM template_master
                JOIN template_details ON template_details.MASTER_ID=template_master.ID
                join task_definition on task_definition.ID=template_details.TASK_ID
                WHERE template_master.TEMPLATE_TYPE=2");

        foreach($results as $key => $value) {

            if($value->user_type==1){
                 
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Desk';
                $Po_User->save();  

            }

            if($value->user_type==2){
            
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Accounts';
                $Po_User->save();  
                

            }
            if($value->user_type==3){
               
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Production';
                $Po_User->save();
                

            }
            if($value->user_type==4){
               
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Documentation';
                $Po_User->save();
                
                
            }
            

            if($value->user_type==6){
              
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Desk Head';
                $Po_User->save();
                    
            }
            
            
        }

    }

    public function updatePoUserDetails(){
        
        $results=DB::select("SELECT po_master.ID as master_id,t1.count,po_master.TEMPLATE_ID as `type`
            from po_master
            left join (select
                        po_user_detail.PO_MASTER_ID as MASTER_ID,
                        count(po_user_detail.TASK_ID) as count
                        from po_user_detail
                        group by po_user_detail.PO_MASTER_ID) as t1
            on po_master.ID=t1.MASTER_ID
            where (t1.count is null or t1.count='')
            order by po_master.PO_NO");

        foreach ($results as $key => $value) {
                
                    
            if($value->type==1){
                
                if($value->master_id){

                    $this->updatePoUsersForLand($value->master_id); 
                    
                }
                

            }

            if($value->type==3){ 
                
                $this->updatePoUsersForSea($value->master_id);  

            }


        }       
       

    }

    public function updatePoUsersForLand($master_id){
        
        $results=DB::select("SELECT template_details.TASK_ID as task_id,task_definition.USER_TYPE as user_type
                    FROM template_master
                    JOIN template_details ON template_details.MASTER_ID=template_master.ID
                    join task_definition on task_definition.ID=template_details.TASK_ID
                    WHERE template_master.TEMPLATE_TYPE=1");

        $po_master=POMaster::where('id',$master_id)->first(['IUID']);
        $user_id=$po_master->IUID;
        $user_head=User::where('id',$user_id)->first(['head_id']);
        if(!is_null($user_head->head_id)){

            foreach ($results as $key => $value) {

                
                if($value->user_type==1){
                    
                    $users1=User::where('head_id', $user_head->head_id)->get();
                    foreach($users1 as $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 

                }

                if($value->user_type==2){
                
                    $users2=User::where('type_id',2)->select('id')->get();
                    foreach($users2 as $key => $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 

                }
                if($value->user_type==3){
                    
                    $users3=User::where('type_id',3)->select('id')->get();
                    foreach($users3 as $key => $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 


                }
                if($value->user_type==4){

                    $users4=User::where('type_id',4)->select('id')->get();
                    foreach($users4 as $key => $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 

                    
                }
                

                if($value->user_type==6){
                
                    $user_head=User::where('id',$user_id)->first(['head_id']); 
                    $poUserDetail=new POUserDetail();      
                    $poUserDetail->PO_MASTER_ID=$master_id;
                    $poUserDetail->TASK_ID=$value->task_id;
                    $poUserDetail->USER_ID=$user_head->head_id;
                    $poUserDetail->save();  
                    
                }
                
                
            }

        }
        

    }

    public function updatePoUsersForSea($master_id){
    
        $results=DB::select("SELECT template_details.TASK_ID as task_id,task_definition.USER_TYPE as user_type
                FROM template_master
                JOIN template_details ON template_details.MASTER_ID=template_master.ID
                join task_definition on task_definition.ID=template_details.TASK_ID
                WHERE template_master.TEMPLATE_TYPE=2");

        $po_master=POMaster::where('id',$master_id)->first(['IUID']);
        $user_id=$po_master->IUID;
        $user_head=User::where('id',$user_id)->first(['head_id']);
        if(!is_null($user_head->head_id)){

            foreach ($results as $key => $value) {

                
                if($value->user_type==1){
                    
                    $users1=User::where('head_id', $user_head->head_id)->get();
                    foreach($users1 as $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 

                }

                if($value->user_type==2){
                
                    $users2=User::where('type_id',2)->select('id')->get();
                    foreach($users2 as $key => $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 

                }
                if($value->user_type==3){
                    
                    $users3=User::where('type_id',3)->select('id')->get();
                    foreach($users3 as $key => $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 


                }
                if($value->user_type==4){

                    $users4=User::where('type_id',4)->select('id')->get();
                    foreach($users4 as $key => $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 

                    
                }
                

                if($value->user_type==6){
                
                    $user_head=User::where('id',$user_id)->first(['head_id']); 
                    $poUserDetail=new POUserDetail();      
                    $poUserDetail->PO_MASTER_ID=$master_id;
                    $poUserDetail->TASK_ID=$value->task_id;
                    $poUserDetail->USER_ID=$user_head->head_id;
                    $poUserDetail->save();  
                    
                }
                
                
            }

        }

    }

    //<!---Manual PO Create----!>

    public function manualPOCreate(){
        
        DB::beginTransaction();
        try {

            $results=DB::select("SELECT sale_contracts.id as id
                    from sale_contracts
                    join job_order_masters on job_order_masters.sale_contract_id=sale_contracts.id
                    where date(sale_contracts.created_at)>=SUBDATE(current_date(), interval 90 day)
                        and (sale_contracts.po_number is null or  sale_contracts.po_number='')
                        and sale_contracts.inactive='N'
                        and job_order_masters.status=1
                        limit 1");

            foreach ($results as $key => $value) {
                
                $salesContact=SaleContract::where('id',$value->id)->first(['id','creator_id','notify_pary_id','created_at']);
                $user=User::where('id',$salesContact->creator_id)->first(['head_id']);
                $head_arrays = array(158, 159, 160);
                $party_id=$salesContact->notify_pary_id;
                $i=1;
                if (in_array($user->head_id, $head_arrays))
                {    
                    $POMaster=new POMaster();
                    $POMaster->PARTY_ID=$salesContact->notify_pary_id;
                    $POMaster->CREATE_DATE=date("Y-m-d", strtotime($salesContact->created_at));
                    $POMaster->TEMPLATE_ID=1;
                    $POMaster->REMARK='Manually Created';
                    $POMaster->ORDER_QTY=0;
                    $POMaster->IUID=$salesContact->creator_id;
                    $POMaster->EUID=$salesContact->creator_id;
                    $POMaster->save();
                    $po_number = 'PO'.date('mY').str_pad($POMaster->id, 6, "0", STR_PAD_LEFT);
                    $POMaster->PO_NO=$po_number;
                    $POMaster->save();
                    SaleContract::where('id',$value->id)->update(['po_number'=>$po_number]);
                    $create_date=date("Y-m-d", strtotime($salesContact->created_at));
                    $this->updateLandPoDetails($POMaster->id,$create_date);
                    $this->updateLandPoUser($POMaster->id);
                    $this->updateLandPoUserDetails($POMaster->id);
        
                }else{
                    
                    $POMaster=new POMaster();
                    $POMaster->PARTY_ID=$salesContact->notify_pary_id;
                    $POMaster->CREATE_DATE=date("Y-m-d", strtotime($salesContact->created_at));
                    $POMaster->TEMPLATE_ID=3;
                    $POMaster->REMARK='Manually Created';
                    $POMaster->ORDER_QTY=0;
                    $POMaster->IUID=$salesContact->creator_id;
                    $POMaster->EUID=$salesContact->creator_id;
                    $POMaster->save();
                    $po_number = 'PO'.date('mY').str_pad($POMaster->id, 6, "0", STR_PAD_LEFT);
                    $POMaster->PO_NO=$po_number;
                    $POMaster->save();
                    SaleContract::where('id',$value->id)->update(['po_number'=>$po_number]);
                    $create_date=date("Y-m-d", strtotime($salesContact->created_at));
                    $this->updateSeaPoDetails($POMaster->id,$create_date);
                    $this->updateSeaPoUser($POMaster->id);
                    $this->updateSeaPoUserDetails($POMaster->id);

                }

            }

            DB::commit();

        } catch (\Exception $exception) {


            DB::rollback();
       
        }

    }
    
    public function updateLandPoDetails($master_id,$from_date){
        
        $results=DB::select("SELECT template_details.TASK_ID as task_id,template_details.STANDARD_DAY as std
            FROM template_master
            JOIN template_details ON template_details.MASTER_ID=template_master.ID
            WHERE template_master.TEMPLATE_TYPE=1");

        $countDates=0;
        $current_date=$from_date;
        foreach ($results as $key => $value) {

            $countDates += $value->std;
            $NewDate=Date('Y-m-d', strtotime("+".$countDates." days"));
            $PODetails=new PODetails();
            $PODetails->MASTER_ID=$master_id;
            $PODetails->TASK_ID=$value->task_id;
            $PODetails->STD=$value->std;
            $PODetails->FROM_DATE=$current_date;
            $PODetails->TO_DATE=$NewDate;
            $PODetails->save();
            $current_date=$NewDate;
          
        }
        
        $this->updateLandPoUser($master_id); 

    }

    public function updateSeaPoDetails($master_id,$from_date){
               
        $results=DB::select("SELECT template_details.TASK_ID as task_id,template_details.STANDARD_DAY as std
        FROM template_master
        JOIN template_details ON template_details.MASTER_ID=template_master.ID
        WHERE template_master.TEMPLATE_TYPE=2");

        $countDates=0;
        $current_date=$from_date;
        foreach ($results as $key => $value) {

            $countDates += $value->std;
            $NewDate=Date('Y-m-d', strtotime("+".$countDates." days"));
            $PODetails=new PODetails();
            $PODetails->MASTER_ID=$master_id;
            $PODetails->TASK_ID=$value->task_id;
            $PODetails->STD=$value->std;
            $PODetails->FROM_DATE=$current_date;
            $PODetails->TO_DATE=$NewDate;
            $PODetails->save();
            $current_date=$NewDate;
        
        }
        
        $this->updateSeaPoUser($master_id);

    }

    public function updateLandPoUser($master_id){
          
        $results=DB::select("SELECT template_details.TASK_ID as task_id,task_definition.USER_TYPE as user_type
                FROM template_master
                JOIN template_details ON template_details.MASTER_ID=template_master.ID
                join task_definition on task_definition.ID=template_details.TASK_ID
                WHERE template_master.TEMPLATE_TYPE=1");

        foreach($results as $key => $value) {

            if($value->user_type==1){
                 
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Desk';
                $Po_User->save();  

            }

            if($value->user_type==2){
            
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Accounts';
                $Po_User->save();  
                

            }
            if($value->user_type==3){
               
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Production';
                $Po_User->save();
                

            }
            if($value->user_type==4){
               
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Documentation';
                $Po_User->save();
                
                
            }
            

            if($value->user_type==6){
              
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Desk Head';
                $Po_User->save();
                    
            }
            
            
        }

        $this->updateLandPoUserDetails($master_id);


    }

    public function updateSeaPoUser($master_id){
        
        $results=DB::select("SELECT template_details.TASK_ID as task_id,task_definition.USER_TYPE as user_type
        FROM template_master
        JOIN template_details ON template_details.MASTER_ID=template_master.ID
        join task_definition on task_definition.ID=template_details.TASK_ID
        WHERE template_master.TEMPLATE_TYPE=2");

        foreach($results as $key => $value) {

            if($value->user_type==1){
                
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Desk';
                $Po_User->save();  

            }

            if($value->user_type==2){
            
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Accounts';
                $Po_User->save();  
                

            }
            if($value->user_type==3){
            
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Production';
                $Po_User->save();
                

            }
            if($value->user_type==4){
            
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Documentation';
                $Po_User->save();
                
                
            }
            

            if($value->user_type==6){
            
                $Po_User=new POUser();    
                $Po_User->PO_MASTER_ID=$master_id;
                $Po_User->TASK_ID=$value->task_id;
                $Po_User->TYPE_ID=$value->user_type;
                $Po_User->STATUS='parent';
                $Po_User->USER_TYPE='Desk Head';
                $Po_User->save();
                    
            }
            
            
        } 

        $this->updateSeaPoUserDetails($master_id);


    }

    public function updateLandPoUserDetails($master_id){
       
        $results=DB::select("SELECT template_details.TASK_ID as task_id,task_definition.USER_TYPE as user_type
                    FROM template_master
                    JOIN template_details ON template_details.MASTER_ID=template_master.ID
                    join task_definition on task_definition.ID=template_details.TASK_ID
                    WHERE template_master.TEMPLATE_TYPE=1");

        $po_master=POMaster::where('id',$master_id)->first(['IUID']);
        $user_id=$po_master->IUID;
        $user_head=User::where('id',$user_id)->first(['head_id']);
        if(!is_null($user_head->head_id)){

            foreach ($results as $key => $value) {

                
                if($value->user_type==1){
                    
                    $users1=User::where('head_id', $user_head->head_id)->get();
                    foreach($users1 as $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 

                }

                if($value->user_type==2){
                
                    $users2=User::where('type_id',2)->select('id')->get();
                    foreach($users2 as $key => $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 

                }
                if($value->user_type==3){
                    
                    $users3=User::where('type_id',3)->select('id')->get();
                    foreach($users3 as $key => $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 


                }
                if($value->user_type==4){

                    $users4=User::where('type_id',4)->select('id')->get();
                    foreach($users4 as $key => $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 

                    
                }
                

                if($value->user_type==6){
                
                    $user_head=User::where('id',$user_id)->first(['head_id']); 
                    $poUserDetail=new POUserDetail();      
                    $poUserDetail->PO_MASTER_ID=$master_id;
                    $poUserDetail->TASK_ID=$value->task_id;
                    $poUserDetail->USER_ID=$user_head->head_id;
                    $poUserDetail->save();  
                    
                }
                
                
            }

        } 
       

    }

    public function updateSeaPoUserDetails($master_id){
        
        $results=DB::select("SELECT template_details.TASK_ID as task_id,task_definition.USER_TYPE as user_type
        FROM template_master
        JOIN template_details ON template_details.MASTER_ID=template_master.ID
        join task_definition on task_definition.ID=template_details.TASK_ID
        WHERE template_master.TEMPLATE_TYPE=2");

        $po_master=POMaster::where('id',$master_id)->first(['IUID']);
        $user_id=$po_master->IUID;
        $user_head=User::where('id',$user_id)->first(['head_id']);
        if(!is_null($user_head->head_id)){

            foreach ($results as $key => $value) {

                
                if($value->user_type==1){
                    
                    $users1=User::where('head_id', $user_head->head_id)->get();
                    foreach($users1 as $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 

                }

                if($value->user_type==2){
                
                    $users2=User::where('type_id',2)->select('id')->get();
                    foreach($users2 as $key => $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 

                }
                if($value->user_type==3){
                    
                    $users3=User::where('type_id',3)->select('id')->get();
                    foreach($users3 as $key => $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 


                }
                if($value->user_type==4){

                    $users4=User::where('type_id',4)->select('id')->get();
                    foreach($users4 as $key => $user) {

                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user->id;
                        $poUserDetail->save();  
            
                    } 

                    
                }
                

                if($value->user_type==6){
                
                    $user_head=User::where('id',$user_id)->first(['head_id']); 
                    $poUserDetail=new POUserDetail();      
                    $poUserDetail->PO_MASTER_ID=$master_id;
                    $poUserDetail->TASK_ID=$value->task_id;
                    $poUserDetail->USER_ID=$user_head->head_id;
                    $poUserDetail->save();  
                    
                }
                
                
            }

        } 
        

    }

    public function manualTnaData(){

        return view('manual_tna');

    }

    public function saveManualTna(Request $request){

        $po_master=POMaster::where('PO_NO',$request->po_no)->first();
        $status='';
        if(is_null($po_master)){

            $status=0;

        }else{

            $po_master=POMaster::where('PO_NO',$request->po_no)->first(['ID','TEMPLATE_ID','PO_NO','CREATE_DATE','IUID']);
            $saleContract=SaleContract::where('po_master_id',$po_master->ID)->first(['id','po_master_id','creator_id','invoice_no','dated','notify_pary_id']);
            $po_details=DB::select("select task_definition.DESCRIPTION as description,po_details.TASK_ID as task_id,po_details.FROM_DATE as from_date,po_details.TO_DATE as to_date
                        from po_details
                        join task_definition on task_definition.ID=po_details.TASK_ID
                        where po_details.MASTER_ID=$po_master->ID");
            $user=User::where('id',$po_master->IUID)->first(['username','name','head_id']);
            $deskSetup=DeskSetup::where('DESK_HEAD_ID',$user->head_id)->first(['DESK_ID']);    
            $desk=Desk::where('id',$deskSetup->DESK_ID)->first(['name']);
            if($po_master->TEMPLATE_ID==1){
                
                foreach ($po_details as $key => $value) {
                    
                    $landPortDashboard=new LandPortDashboard();
                    $landPortDashboard->sc_id=$saleContract->id;
                    $landPortDashboard->party_id=$saleContract->notify_pary_id;
                    $landPortDashboard->Task_ID=$value->task_id;
                    if($value->task_id==12){

                        $landPortDashboard->action_date=date("Y-m-d", strtotime($po_master->CREATE_DATE));
                    }
                    if($value->task_id==13){

                        $landPortDashboard->action_date=$saleContract->dated;
                    }
                    $landPortDashboard->desk=$desk->name;
                    $landPortDashboard->task_name=$value->description;
                    $landPortDashboard->po_no=$po_master->PO_NO;
                    $landPortDashboard->po_date=date("Y-m-d", strtotime($po_master->CREATE_DATE));
                    $landPortDashboard->from_date=$value->from_date;
                    $landPortDashboard->to_date=$value->to_date;
                    $landPortDashboard->sc_no=$saleContract->invoice_no;
                    $landPortDashboard->sc_date=$saleContract->dated;
                    $landPortDashboard->user=$user->username.'-'.$user->name;
                    $landPortDashboard->insert_date=date('Y-m-d');
                    $landPortDashboard->save(); 

                }
            
            
            }else if($po_master->TEMPLATE_ID==3){
                
                
                foreach ($po_details as $key => $value) {
                    
                    $seaPortdashboard=new seaPortdashboard();
                    $seaPortdashboard->sc_id=$saleContract->id;
                    $seaPortdashboard->party_id=$saleContract->notify_pary_id;
                    $seaPortdashboard->Task_ID=$value->task_id;
                    if($value->task_id==12){

                        $seaPortdashboard->action_date=date("Y-m-d", strtotime($po_master->CREATE_DATE));
                    }
                    if($value->task_id==13){
                        
                        $seaPortdashboard->action_date=$saleContract->dated;
                    }
                    $seaPortdashboard->desk=$desk->name;
                    $seaPortdashboard->task_name=$value->description;
                    $seaPortdashboard->po_no=$po_master->PO_NO;
                    $seaPortdashboard->po_date=date("Y-m-d", strtotime($po_master->CREATE_DATE));
                    $seaPortdashboard->from_date=$value->from_date;
                    $seaPortdashboard->to_date=$value->to_date;
                    $seaPortdashboard->sc_no=$saleContract->invoice_no;
                    $seaPortdashboard->sc_date=$saleContract->dated;
                    $seaPortdashboard->user=$user->username.'-'.$user->name;
                    $seaPortdashboard->insert_date=date('Y-m-d');
                    $seaPortdashboard->save(); 

                }
    

            }

            $status=1;

        }

        return response()->json([
            'status'=>$status
        ]);

    }

    public function manualDataUpdate(Request $request){
       
        return view('manual_tna_date_update');

    }

    public function jsonManualDataUpdate(Request $request){
       
        $po_master=POMaster::where('PO_NO',$request->po_no)->first();
        $status='';
        if(is_null($po_master)){

            $status=0;

        }else{

            $po_master=POMaster::where('PO_NO',$request->po_no)->first(['ID','TEMPLATE_ID']);
            $saleContract=SaleContract::where('po_master_id',$po_master->ID)->first(['id']);
            $result=DB::select("CALL PROC_TNA_DATE_UPDATE(?,?,?)",[$saleContract->id,$po_master->TEMPLATE_ID,$po_master->ID]);
            $status=1;

        }

        return response()->json([
            'status'=>$status
        ]);



    }

    public function updateCiTotalValue(){
          
        // return $value->id;
        $results=SaleContract::select('sale_contracts.id','sale_contracts.freight_cost')
                   ->join('sale_contract_details','sale_contracts.id','sale_contract_details.sale_contract_id')
                   ->where('sale_contracts.id', '=', 44471)
                   ->get();

        // $results = SaleContract::select('id')
        //         ->whereBetween('created_at', ['2024-12-01', '2025-01-31'])
        //         ->where('inactive', 'N')
        //         ->get();

        foreach($results as $key => $value) {

            $total_sum=0;
            $sale_contract=SaleContract::findorfail($value->id);  
            $total_net_weight=\DB::table("sale_contract_details")->where('sale_contract_id',$value->id)->sum('net_weight_kg');
            if($total_net_weight){

                $per_unit_freight=$sale_contract->freight_cost/$total_net_weight;
                $sale_contract_details = SaleContract::where('sale_contracts.id', $value->id)
                    ->select(
                        'ci_items.id as item_id',
                        'ci_items.ci_item_code',
                        'sale_contract_details.ci_item_name',
                        'sale_contract_details.rate_per_ctn',
                        'ci_items.ci_factor',
                        'sale_contract_details.net_weight_kg',
                        DB::raw('SUM(sale_contract_details.ctn) AS ctn'),
                        DB::raw('SUM(sale_contract_details.total_amount_party) AS total_amount'),
                        DB::raw('SUM(sale_contract_details.total_amount) AS ci_amount')
                    )
                    ->join('sale_contract_details', 'sale_contract_details.sale_contract_id', '=', 'sale_contracts.id')
                    ->join('ci_items', 'ci_items.id', '=', 'sale_contract_details.ci_item_id')
                    ->groupBy('sale_contracts.invoice_no', 'ci_items.ci_item_code')
                    ->orderBy('sale_contract_details.id')
                    ->get();
    
                foreach ($sale_contract_details as $sale_contract_detail){
    
                    try { 
    
                        if($sale_contract_detail->ci_factor !=0 ){
        
                            $per_net_weight_kg_fright=$per_unit_freight*$sale_contract_detail->net_weight_kg;
                            if($sale_contract_detail->ctn){

                                $caton_fright=$per_net_weight_kg_fright/$sale_contract_detail->ctn;

                            }else{

                                $caton_fright=0; 
                            }
                            $carton_fright_pl_rate=round($caton_fright+$sale_contract_detail->rate_per_ctn,6);
                            $total_sum=$total_sum+round($carton_fright_pl_rate*$sale_contract_detail->ctn,6);
                            //$total_sum=round($carton_fright_pl_rate*$sale_contract_detail->ctn,6);
        
                        }
    
                    }catch (Exception $e) {
            
                
                    }  

                    // SaleContractDetail::where('sale_contract_id',$value->id)->where('ci_item_id',$sale_contract_detail->item_id)->update([
                    //     'total_amount'=>$total_sum
                    // ]);
    
                }

                SaleContract::where('id',$value->id)->update([
                    'total_ci_value'=> $total_sum 
                ]);

            }
            
        }

    }     

}
