<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\NotifyParty;
use App\POMaster;
use App\PODetails;
use App\TemplateMaster;
use App\User;
use DB;
use Auth;
use App\UserType;
use App\POUser;
use App\POUserDetail;
use App\TaskDefinition;
use App\NotifyPartyUser;
class POController extends Controller
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

        if(NotifyPartyUser::where('user_id',Auth::user()->id)->exists()){
            
            $userPary=NotifyPartyUser::where('user_id',Auth::user()->id)->first();
            $partyAreaId=NotifyParty::where('id',$userPary->notify_party_id)->first(['area_id']);
            $results = DB::select("SELECT t1.id,
                        t1.CREATE_DATE AS create_date,
                        t1.PO_NO AS po_no,
                        t2.NAME AS party_name,
                        t2.code as code,
                        t3.NAME AS created_by,
                        t1.ORDER_QTY as order_qty,
                        CASE WHEN t1.STATUS=1 THEN 'Active' ELSE 'Inactive' END as status
                    FROM po_master t1
                    LEFT JOIN notify_parties t2 ON t2.id = t1.PARTY_ID
                    LEFT JOIN users t3 ON t3.id = t1.IUID
                    where t2.area_id='$partyAreaId->area_id'");
                    
            return view('po.index')->with('results',$results);

        }else{

           return redirect()->back();

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
       $user_id=Auth::user()->id;
       $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'");  
       $templateNames=TemplateMaster::all();
       $userTypes=UserType::all();
       return view('po.create')
           ->with('notifyParties',$notifyParties)
           ->with('templateNames',$templateNames);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  

        $status='';
        DB::beginTransaction();
        try {

            $po_number='';
            $POMaster=new POMaster();
            $POMaster->PARTY_ID=$request->party_id;
            $POMaster->CREATE_DATE=date("Y-m-d", strtotime($request->create_date));
            $POMaster->TEMPLATE_ID=$request->template_id;
            $POMaster->REMARK=$request->remark;
            $POMaster->ORDER_QTY=$request->order_qty;
            $POMaster->IUID=Auth::user()->id;
            $POMaster->EUID=Auth::user()->id;
            $POMaster->save();
            $po_number = 'PO'.date('mY').str_pad($POMaster->id, 6, "0", STR_PAD_LEFT);
            $POMaster->PO_NO=$po_number;
            $POMaster->save();
            $current_date=date('Y-m-d');
            $countDates=0;

            for($i=0;$i<count($request->results);$i++){
                
                $countDates += $request->results[$i]['std'];
                $NewDate=Date('Y-m-d', strtotime("+".$countDates." days"));
                $PODetails=new PODetails();
                $checkPODetails=PODetails::where('MASTER_ID',$POMaster->id)->orderBy('id','DESC')->first();
                $std=$request->results[$i]['std'];
                if(is_null($checkPODetails)){
                  
                    $PODetails->MASTER_ID=$POMaster->id;
                    $PODetails->TASK_ID=$request->results[$i]['task_id'];
                    $PODetails->STD=$std;
                    $PODetails->FROM_DATE=$current_date;
                    $PODetails->TO_DATE=$NewDate;
                    $PODetails->save();

                }else{
                    
                    if($std==0){
                       
                        $PODetails->MASTER_ID=$POMaster->id;
                        $PODetails->TASK_ID=$request->results[$i]['task_id'];
                        $PODetails->STD=$std;
                        $PODetails->FROM_DATE=$checkPODetails->FROM_DATE;
                        $PODetails->TO_DATE=$checkPODetails->TO_DATE;
                        $PODetails->save();  
                        
                    }else{

                        $PODetails->MASTER_ID=$POMaster->id;
                        $PODetails->TASK_ID=$request->results[$i]['task_id'];
                        $PODetails->STD=$std;
                        $PODetails->FROM_DATE=$checkPODetails->TO_DATE;
                        $PODetails->TO_DATE=$NewDate;
                        $PODetails->save();


                    }
                    

                }
                

            }
            
            for($i=0; $i<count($request->results); $i++){
                
                $user_type=TaskDefinition::where('ID',$request->results[$i]['task_id'])->first(['USER_TYPE']);
                $userType=UserType::where('id',$user_type->USER_TYPE)->first(['name']);
                $this->savePOUser($POMaster->id,$request->results[$i]['task_id'],$request->results[$i]['type_id'],$request->results[$i]['status'],$userType->name);  
                
            }

            for($j=0; $j<count($request->results); $j++){
                
                if($request->results[$j]['status']=="parent"){

                    $userType=UserType::where('id',$request->results[$j]['type_id'])->first(['name']); 
                    if($userType->name=="Desk Head"){

                        $user=array(Auth::user()->id);
                        $this->savePOUserDetails($user, $POMaster->id, $request->results[$j]['task_id']); 

                    }else{

                        if($userType->name=="Desk"){
                            
                            $desk_head=User::where('id',Auth::user()->id)->first(['head_id']);
                            $user=User::where('head_id',$desk_head->head_id)->pluck('id')->toArray();
                            $this->savePOUserDetails($user, $POMaster->id, $request->results[$j]['task_id']);  

                        }else{

                            $user=User::where('type_id',$request->results[$j]['type_id'])->pluck('id')->toArray();
                            $this->savePOUserDetails($user, $POMaster->id, $request->results[$j]['task_id']);

                        }

                    }

                }else{

                    $user=array($request->results[$j]['task_id']);
                    $this->savePOUserDetails($user, $POMaster->id, $request->results[$j]['task_id']);

                }
                
            }
            
            DB::commit();
            
            $status='Success';

        }catch(\Exception $e) {
            
            if($e->getMessage()){
            
                $status='Error'; 
  
            }
            
            DB::rollback();
                
        }

        

        return response()->json([
                    
            'status'=>$status,
            'po_number'=>$po_number 

        ]);

        
    }

    private function savePOUser($master_id,$task_id,$type_id,$status,$name){

        $Po_User=new POUser();    
        $Po_User->PO_MASTER_ID=$master_id;
        $Po_User->TASK_ID=$task_id;
        $Po_User->TYPE_ID=$type_id;
        $Po_User->STATUS=$status;
        $Po_User->USER_TYPE=$name;
        $Po_User->save(); 
           
    }

    private function savePOUserDetails($user,$master_id,$task_id){
        

        for($j=0; $j<count($user); $j++){
            
            $poUserDetail=new POUserDetail();      
            $poUserDetail->PO_MASTER_ID=$master_id;
            $poUserDetail->TASK_ID=$task_id;
            $poUserDetail->USER_ID=$user[$j];
            $poUserDetail->save();  

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

        $posMaster=POMaster::findorfail($id);
        $templates=TemplateMaster::all();
        $notifyParties=NotifyParty::all();
        $taskDetails=DB::select("select t2.TASK_ID as task_id,t4.TYPE_ID as type_id,
                    t3.DESCRIPTION as task_name,t1.REMARK,
                    t4.STATUS as status,
                    t2.STD,
                    t4.USER_TYPE
                from po_master t1
                join po_details t2 on t2.MASTER_ID = t1.ID
                join task_definition t3 on t3.ID = t2.TASK_ID
                join po_user t4 on t4.TASK_ID=t2.TASK_ID
                where t2.MASTER_ID='$id' and t4.PO_MASTER_ID='$id'
                order by t2.TASK_ID");

        $userTypes=UserType::all();
        $userTypeChil=DB::select("select t1.TASK_ID as task_id,t2.DESCRIPTION as name 
                        from po_user t1
                        join task_definition t2 on t2.ID = t1.TASK_ID
                        where t1.PO_MASTER_ID='$id'
                        order by t1.TASK_ID");
          
        $desk_head_id=User::where('id',Auth::user()->id)->first(['head_id']);
        $desk_user=User::where('head_id',$desk_head_id->id)->get();   
        $user=DB::select("SELECT id,name,username,type_id FROM users WHERE `type_id` IN (2, 3, 4, 5)");    
        return response()->json([
             'party_id'=>$posMaster->PARTY_ID,
             'date'=>date("d-m-Y", strtotime($posMaster->CREATE_DATE)),
             'order_qty'=>$posMaster->ORDER_QTY,       
             'template_id'=>$posMaster->TEMPLATE_ID,
             'remark'=>$posMaster->REMARK,
             'notifyParties'=>$notifyParties,
             'templates'=>$templates,
             'taskDetails'=>$taskDetails,
             'user'=>$user,
             'userTypes'=>$userTypes,
             'userTypeChil'=>$userTypeChil,
             'desk_user'=>$desk_user,
             'update_id'=>$id,
             'status'=>$posMaster->STATUS
        ],200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        
        $result=POMaster::where('ID',$id)->update(['STATUS'=>$request->status]);   
        return response()->json(['status'=>'success']);  

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

    public function jsonGetTemplateDetails(Request $request){
           
        $template=TemplateMaster::where('id',$request->template_id)->first(['TEMPLATE_TYPE']);
        $results=""; $status=""; $user=""; $userTypes="";
        $user_id=Auth::user()->id; $desk_user="";
        $desk_head_id=User::where('id',Auth::user()->id)->first(['head_id']);
        if(!is_null($desk_head_id->head_id)){
           
            $desk_user=User::where('head_id',$desk_head_id->head_id)->get(); 
            $user=DB::select("SELECT id,name,username,type_id FROM users WHERE `type_id` IN (2, 3, 4, 5)");
            $userTypes=UserType::all();
            if($template->TEMPLATE_TYPE==1){
               
                $results = DB::select("Select t3.ID id,
                            t3.DESCRIPTION template_name,
                            t3.USER_TYPE as user_type,
                            t3.STANDARD_DAYS as std,
                            t3.CANCEL_STATUS AS status
                        from template_master t1
                        join template_details t2 on t2.MASTER_ID = t1.ID
                        join task_definition t3 on t3.ID = t2.TASK_ID
                        where t1.TEMPLATE_TYPE=1 and t3.SHOW_STATUS='Y'
                        order by t2.ORDER_BY_LAND ASC");

            }elseif($template->TEMPLATE_TYPE==2) {
                  
                $results = DB::select("Select t3.ID id,
                            t3.DESCRIPTION template_name,
                            t3.USER_TYPE as user_type,
                            t3.STANDARD_DAYS as std,
                            t3.CANCEL_STATUS AS status
                        from template_master t1
                        join template_details t2 on t2.MASTER_ID = t1.ID
                        join task_definition t3 on t3.ID = t2.TASK_ID
                        where t1.TEMPLATE_TYPE=2 and t3.SHOW_STATUS='Y'
                        order by t2.ORDER_BY_SEA ASC");

            }

            $status='success';            

        }else{

            $status='error';

        }
        
        return response()->json([
            'results'=>$results,
            'status'=>$status,
            'user'=>$user,
            'userTypes'=>$userTypes,
            'user_id'=>$user_id,
            'desk_user'=>$desk_user
        ],200);

    }

    public function jsonGetPoItems(Request $request){
      
        $party_id=POMaster::where('id',$request->po_id)->value('PARTY_ID');
        $results=DB::select("select
                ci_items.ci_item_code as item_code,
                ci_items.ci_item_name as item_name,
                t2.acc_rate as acc_rate_per_ctn,
                t2.party_rate as party_rate_per_ctn,
                t2.cbm_per_ctn as cbm_per_ctn,
                t2.gross_weight*poi.order_qty_ctn as gross_weight,
                ci_items.hs_code as hs_code,
                if(t2.hs_code2,t2.hs_code2,'') as hs_code2,
                poi.order_qty_ctn as total_ctn,
                ROUND(SUM(t2.cbm_per_ctn*poi.order_qty_ctn),6) as total_cbm,
                ROUND(SUM(t2.acc_rate*poi.order_qty_ctn),6) as total_acc_value,
                ROUND(SUM(t2.party_rate*poi.order_qty_ctn),6) as total_party_value
            from po_master po
            join po_item_details poi on poi.master_id=po.ID
            join ci_items on ci_items.id=poi.item_id
            join (
                    select ci_item_id,acc_rate,party_rate,cbm_per_ctn,gross_weight,hs_code2
                    from notify_party_items
                    where notify_party_id='$party_id'
                ) t2 on t2.ci_item_id = poi.item_id
            where po.ID = '$request->po_id'
            group by
            ci_items.ci_item_code,
            ci_items.ci_item_name,
            t2.acc_rate,
            t2.party_rate,
            t2.cbm_per_ctn,
            t2.gross_weight,
            ci_items.hs_code,
            t2.hs_code2,
            poi.order_qty_ctn");

        return response()->json([
            'code'=>200,
            'data'=>$results
        ]);    

    }

}
