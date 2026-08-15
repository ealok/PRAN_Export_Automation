<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\NotifyParty;
use App\NotifyPartyItem;
use App\POMaster;
use App\PODetails;
use App\POItemDetails;
use App\PONumber;
use App\POUser;
use App\POUserDetail;
use App\User;
use Carbon\Carbon;
use App\UserArea;
use App\NotifyPartyUser;
use App\PartyOrderItem;
use Illuminate\Support\Facades\Mail;
use Excel;
use App\CiItem;
use Auth;
use DB;
use Session;
class DemandController extends Controller
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
        
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'");
        // $users=User::all();
        $users=User::where('type_id',7)->get();              
        return view('sale_contract.po.po_list',compact('notifyParties'))
               ->with('users',$users);
        
     
    }

    public function getPOs(Request $request){
         
        $results=DB::select("SELECT
                po_master.ID as id,
                po_master.PO_NO as po_no,
                po_master.PO_DATE as po_date,
                CONCAT(notify_parties.code,'-',notify_parties.name) AS party,
                SUM(po_item_details.order_qty_ctn) AS order_qty,
                CASE WHEN (po_master.APPROVED_STATUS='N' && po_master.ORDER_STATUS='Y') THEN 'Not Posted'
                WHEN (po_master.APPROVED_STATUS='Y' && po_master.ORDER_STATUS='Y') THEN 'Posted'
                WHEN (po_master.APPROVED_STATUS='N' && po_master.ORDER_STATUS='N') THEN 'Cancel' END as status,
                CASE WHEN po_master.GT_STATUS='N' THEN 'Not Rcv' WHEN po_master.GT_STATUS='R' THEN 'Rcv'
                 WHEN po_master.GT_STATUS='P' THEN 'Proced' WHEN po_master.GT_STATUS='C' THEN 'Cancel'
                 END AS gt_status,
                CASE WHEN po_master.ORDER_TYPE=1 THEN 'PRAN' ELSE 'GT' END as order_type,
                CASE WHEN po_master.GT_DOC_REF is not null then gt_doc_ref else '' end as gt_doc_ref
            FROM po_master
            JOIN po_item_details on po_item_details.master_id=po_master.ID
            JOIN notify_parties ON notify_parties.id = po_master.PARTY_ID
            where notify_parties.code='$request->party_code'
            GROUP BY po_master.ID,po_master.PO_NO,po_master.PO_DATE,
            po_master.APPROVED_STATUS,notify_parties.code,notify_parties.name,po_master.ORDER_TYPE,po_master.ORDER_STATUS,gt_status,po_master.GT_DOC_REF
            ORDER BY po_master.ID DESC");
        
        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);

        } else  {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);

        }

    }

    public function approvePO(Request $request){
         
        $user_id=Auth::user()->id;
        DB::beginTransaction();
        try {

                POMaster::where('id',$request->po_id)->update(['APPROVED_STATUS'=>'Y','APPROVED_BY'=>$user_id,'APPROVED_DATE'=>date('Y-m-d')]);
                $po_master=POMaster::where('id',$request->po_id)->first(['ID','PARTY_ID','IUID','CREATE_DATE','PO_NO','PO_DATE','ORDER_TYPE']);
                $results=DB::select("SELECT
                        ci_items.ci_item_code AS item_code,
                        ci_items.ci_item_name AS item_name,
                        ci_items.factor AS unit_per_ctn,
                        npi.acc_rate AS purchase_rate,
                        npi.party_rate AS sales_rate,
                        po_item_details.order_qty_ctn AS order_qty,
                        po_item_details.order_qty_ctn * npi.party_rate AS value,
                        po_item_details.coding_matter AS coding_matter,
                        po_item_details.special_requirement AS special_requirement,
                        po_item_details.specifition AS remarks
                    FROM po_master
                    JOIN po_item_details ON po_item_details.master_id = po_master.ID
                    JOIN ci_items ON ci_items.id = po_item_details.item_id
                    JOIN notify_party_items npi ON npi.notify_party_id = po_master.PARTY_ID AND npi.ci_item_id = ci_items.id
                    WHERE po_master.ID = '$request->po_id' AND npi.notify_party_id = '$po_master->PARTY_ID' AND po_item_details.status='Y'");
                           
            if(POMaster::where('id',$request->po_id)->value('ORDER_TYPE')==2){
                $users=User::whereIn('id',$request->user_ids)->pluck('email')->toArray();
                $this->sendOrderNotificationMail($po_master,$results,$users);
            }
            DB::commit();

        }catch(\Exception $e) {

            if($e->getMessage()){
            
                $status='Error'; 
  
            }
            
            DB::rollback();
        }  
        
        $status='Success';
        $po_master=POMaster::where('id',$request->po_id)->first(['APPROVED_STATUS']);
        return response()->json([

            'status' => $status,
            'check_status'=>1,
            'approve_status'=>$po_master->APPROVED_STATUS

        ],200);


    }

    public function sendOrderNotificationMail($po_master, $results, $users){
         
        $notify_party = NotifyParty::where('id', $po_master->PARTY_ID)->first(['code', 'name']);
        $createBy = User::where('id', $po_master->IUID)->first();
        $cc_mail = Auth::user()->email;
        $data = array(
            'results' => $results,
            'customer' => $notify_party,
            'po_details' => $po_master,
            'createBy' => $createBy,
            'subject' => "GT New Order Notification",
            'ordr_type' => $po_master->ORDER_TYPE == 1 ? 'PRAN order' : 'Global trading',
            'to_array' => $users,
            'cc_mail' => $cc_mail
        );
        
        $from_mail = env('MAIL_FROM_ADDRESS');
        try {
            Mail::send('gt_order_mail_template', $data, function($message) use ($from_mail, $data) {
                $message->from($from_mail, 'GT-Order-Notification@prangroup.com');
                $message->to($data['to_array']);
                $message->cc($data['cc_mail']);
                $message->subject($data['subject']);
            });
            return 'Mail sent successfully';
        } catch (\Exception $e) {
            return 'Mail failed to send. Error: ' . $e->getMessage();
        }

    }    

    public function cancelPO(Request $request){
         
        DB::beginTransaction();
        try {
            
            if(POMaster::where('id',$request->po_id)->where('GT_STATUS','C')->count()>0 || POMaster::where('id',$request->po_id)->value('GT_STATUS')=='N'){

                POMaster::where('id',$request->po_id)->update(['ORDER_STATUS'=>'N','APPROVED_STATUS'=>'N']);
                $status='Success';
                DB::commit();

            }else{
               
                $status='Alert';
                DB::commit();   

            }
            

        }catch(\Exception $e) {

            if($e->getMessage()){ $status='Error';}
            DB::rollback();
        }  
        
        return response()->json(['status' => $status],200);


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

    public function updateLandPoUser($master_id){
          
        $results=DB::select("SELECT template_details.TASK_ID as task_id,task_definition.USER_TYPE as user_type
                FROM template_master
                JOIN template_details ON template_details.MASTER_ID=template_master.ID
                join task_definition on task_definition.ID=template_details.TASK_ID
                WHERE template_master.TEMPLATE_TYPE=1");

        foreach($results as $key => $value) {

            if($value->user_type==1){
                 
                $result=POUser::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                if(is_null($result))
                {
                    
                    $Po_User=new POUser();    
                    $Po_User->PO_MASTER_ID=$master_id;
                    $Po_User->TASK_ID=$value->task_id;
                    $Po_User->TYPE_ID=$value->user_type;
                    $Po_User->STATUS='parent';
                    $Po_User->USER_TYPE='Desk';
                    $Po_User->save();

                }
                  

            }

            if($value->user_type==2){
                
                $result=POUser::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                if(is_null($result))
                {
                    $Po_User=new POUser();    
                    $Po_User->PO_MASTER_ID=$master_id;
                    $Po_User->TASK_ID=$value->task_id;
                    $Po_User->TYPE_ID=$value->user_type;
                    $Po_User->STATUS='parent';
                    $Po_User->USER_TYPE='Accounts';
                    $Po_User->save();  
                }
                

            }
            if($value->user_type==3){
                
                $result=POUser::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                if(is_null($result))
                { 
                    $Po_User=new POUser();    
                    $Po_User->PO_MASTER_ID=$master_id;
                    $Po_User->TASK_ID=$value->task_id;
                    $Po_User->TYPE_ID=$value->user_type;
                    $Po_User->STATUS='parent';
                    $Po_User->USER_TYPE='Production';
                    $Po_User->save();
                }
                

            }
            if($value->user_type==4){
                
                $result=POUser::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                if(is_null($result))
                {
                    $Po_User=new POUser();    
                    $Po_User->PO_MASTER_ID=$master_id;
                    $Po_User->TASK_ID=$value->task_id;
                    $Po_User->TYPE_ID=$value->user_type;
                    $Po_User->STATUS='parent';
                    $Po_User->USER_TYPE='Documentation';
                    $Po_User->save();
                }
                
                
            }

            if($value->user_type==5){
                
                $result=POUser::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                if(is_null($result))
                {
                    $Po_User=new POUser();    
                    $Po_User->PO_MASTER_ID=$master_id;
                    $Po_User->TASK_ID=$value->task_id;
                    $Po_User->TYPE_ID=$value->user_type;
                    $Po_User->STATUS='parent';
                    $Po_User->USER_TYPE='Documentation';
                    $Po_User->save();
                }
                
                
            }
            

            if($value->user_type==6){
                
                $result=POUser::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                if(is_null($result))
                {
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

        $this->updateLandPoUserDetails($master_id);


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
                    $result=POUserDetail::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                    if(is_null($result))
                    {
                        foreach($users1 as $user) {

                            $poUserDetail=new POUserDetail();      
                            $poUserDetail->PO_MASTER_ID=$master_id;
                            $poUserDetail->TASK_ID=$value->task_id;
                            $poUserDetail->USER_ID=$user->id;
                            $poUserDetail->save();  
                
                        } 

                    }
                }   

                if($value->user_type==2){
                
                    $users2=User::where('type_id',2)->select('id')->get();
                    $result=POUserDetail::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                    if(is_null($result))
                    {
                        foreach($users2 as $key => $user) {

                            $poUserDetail=new POUserDetail();      
                            $poUserDetail->PO_MASTER_ID=$master_id;
                            $poUserDetail->TASK_ID=$value->task_id;
                            $poUserDetail->USER_ID=$user->id;
                            $poUserDetail->save();  
                
                        } 
                    }    

                }
                if($value->user_type==3){
                    
                    $users3=User::where('type_id',3)->select('id')->get();
                    $result=POUserDetail::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                    if(is_null($result))
                    {
                        foreach($users3 as $key => $user) {

                            $poUserDetail=new POUserDetail();      
                            $poUserDetail->PO_MASTER_ID=$master_id;
                            $poUserDetail->TASK_ID=$value->task_id;
                            $poUserDetail->USER_ID=$user->id;
                            $poUserDetail->save();  
                
                        } 

                    }    

                }
                if($value->user_type==4){

                    $users4=User::where('type_id',4)->select('id')->get();
                    $result=POUserDetail::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                    if(is_null($result))
                    {
                        foreach($users4 as $key => $user) {

                            $poUserDetail=new POUserDetail();      
                            $poUserDetail->PO_MASTER_ID=$master_id;
                            $poUserDetail->TASK_ID=$value->task_id;
                            $poUserDetail->USER_ID=$user->id;
                            $poUserDetail->save();  
                
                        }

                    }
                    
                }

                if($value->user_type==5){

                    $users4=User::where('type_id',5)->select('id')->get();
                    $result=POUserDetail::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                    if(is_null($result))
                    {
                        foreach($users4 as $key => $user) {

                            $poUserDetail=new POUserDetail();      
                            $poUserDetail->PO_MASTER_ID=$master_id;
                            $poUserDetail->TASK_ID=$value->task_id;
                            $poUserDetail->USER_ID=$user->id;
                            $poUserDetail->save();  
                
                        }

                    }
                    
                }
                

                if($value->user_type==6){
                     
                    $user_head=User::where('id',$user_id)->first(['head_id']); 
                    $result=POUserDetail::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                    if(is_null($result))
                    {
                        $poUserDetail=new POUserDetail();      
                        $poUserDetail->PO_MASTER_ID=$master_id;
                        $poUserDetail->TASK_ID=$value->task_id;
                        $poUserDetail->USER_ID=$user_head->head_id;
                        $poUserDetail->save();  
                    }
                    
                }
                
                
            }

        } 
       

    }

    public function updateSeaPoDetails($master_id,$from_date){
               
        $results=DB::select("SELECT template_details.TASK_ID as task_id,template_details.STANDARD_DAY as std
            FROM template_master
            JOIN template_details ON template_details.MASTER_ID=template_master.ID
            WHERE template_master.TEMPLATE_TYPE=2");

        $countDates=0;
        $current_date=$from_date;
        foreach ($results as $key => $value) {
            
            $result=PODetails::where('MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
            if(is_null($result))
            { 
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
        
        }
        
        $this->updateSeaPoUser($master_id);

    }

    public function updateSeaPoUser($master_id){
        
        $results=DB::select("SELECT template_details.TASK_ID as task_id,task_definition.USER_TYPE as user_type
                FROM template_master
                JOIN template_details ON template_details.MASTER_ID=template_master.ID
                join task_definition on task_definition.ID=template_details.TASK_ID
                WHERE template_master.TEMPLATE_TYPE=2");

        foreach($results as $key => $value) {

            if($value->user_type==1){

                $result=POUser::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                if(is_null($result))
                {
                    $Po_User=new POUser();    
                    $Po_User->PO_MASTER_ID=$master_id;
                    $Po_User->TASK_ID=$value->task_id;
                    $Po_User->TYPE_ID=$value->user_type;
                    $Po_User->STATUS='parent';
                    $Po_User->USER_TYPE='Desk';
                    $Po_User->save();  
                }

            }

            if($value->user_type==2){
                 
                $result=POUser::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                if(is_null($result))
                {
                    $Po_User=new POUser();    
                    $Po_User->PO_MASTER_ID=$master_id;
                    $Po_User->TASK_ID=$value->task_id;
                    $Po_User->TYPE_ID=$value->user_type;
                    $Po_User->STATUS='parent';
                    $Po_User->USER_TYPE='Accounts';
                    $Po_User->save();

                } 
                  
                

            }
            if($value->user_type==3){
                 
                $result=POUser::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                if(is_null($result))
                {
                    $Po_User=new POUser();    
                    $Po_User->PO_MASTER_ID=$master_id;
                    $Po_User->TASK_ID=$value->task_id;
                    $Po_User->TYPE_ID=$value->user_type;
                    $Po_User->STATUS='parent';
                    $Po_User->USER_TYPE='Production';
                    $Po_User->save();
                }
                

            }
            if($value->user_type==4){
                
                $result=POUser::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                if(is_null($result))
                { 
                    $Po_User=new POUser();    
                    $Po_User->PO_MASTER_ID=$master_id;
                    $Po_User->TASK_ID=$value->task_id;
                    $Po_User->TYPE_ID=$value->user_type;
                    $Po_User->STATUS='parent';
                    $Po_User->USER_TYPE='Documentation';
                    $Po_User->save();
                }
                
                
            }
            if($value->user_type==5){
                
                $result=POUser::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                if(is_null($result))
                { 
                    $Po_User=new POUser();    
                    $Po_User->PO_MASTER_ID=$master_id;
                    $Po_User->TASK_ID=$value->task_id;
                    $Po_User->TYPE_ID=$value->user_type;
                    $Po_User->STATUS='parent';
                    $Po_User->USER_TYPE='Documentation';
                    $Po_User->save();
                }
                
                
            }
            
            if($value->user_type==6){
                 
                $result=POUser::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                if(is_null($result))
                {
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

        $this->updateSeaPoUserDetails($master_id);


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
                    $result=POUserDetail::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                    if(is_null($result))
                    {
                        foreach($users1 as $user) {

                            $poUserDetail=new POUserDetail();      
                            $poUserDetail->PO_MASTER_ID=$master_id;
                            $poUserDetail->TASK_ID=$value->task_id;
                            $poUserDetail->USER_ID=$user->id;
                            $poUserDetail->save();  
                
                        } 

                    }    

                }

                if($value->user_type==2){
                
                    $users2=User::where('type_id',2)->select('id')->get();
                    $result=POUserDetail::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                    if(is_null($result))
                    {
                        foreach($users2 as $key => $user) {

                            $poUserDetail=new POUserDetail();      
                            $poUserDetail->PO_MASTER_ID=$master_id;
                            $poUserDetail->TASK_ID=$value->task_id;
                            $poUserDetail->USER_ID=$user->id;
                            $poUserDetail->save();  
                
                        } 

                    }    

                }
                if($value->user_type==3){
                    
                    $users3=User::where('type_id',3)->select('id')->get();
                    $result=POUserDetail::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                    if(is_null($result))
                    {
                        foreach($users3 as $key => $user) {

                            $poUserDetail=new POUserDetail();      
                            $poUserDetail->PO_MASTER_ID=$master_id;
                            $poUserDetail->TASK_ID=$value->task_id;
                            $poUserDetail->USER_ID=$user->id;
                            $poUserDetail->save();  
                
                        } 

                    }    

                }
                if($value->user_type==4){

                    $users4=User::where('type_id',4)->select('id')->get();
                    $result=POUserDetail::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                    if(is_null($result))
                    {
                        foreach($users4 as $key => $user) {

                            $poUserDetail=new POUserDetail();      
                            $poUserDetail->PO_MASTER_ID=$master_id;
                            $poUserDetail->TASK_ID=$value->task_id;
                            $poUserDetail->USER_ID=$user->id;
                            $poUserDetail->save();  
                
                        } 

                    }    
                    
                }

                if($value->user_type==5){

                    $users4=User::where('type_id',5)->select('id')->get();
                    $result=POUserDetail::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                    if(is_null($result))
                    {
                        foreach($users4 as $key => $user) {

                            $poUserDetail=new POUserDetail();      
                            $poUserDetail->PO_MASTER_ID=$master_id;
                            $poUserDetail->TASK_ID=$value->task_id;
                            $poUserDetail->USER_ID=$user->id;
                            $poUserDetail->save();  
                
                        } 

                    }    
                    
                }
                

                if($value->user_type==6){

                    $result=POUserDetail::where('PO_MASTER_ID',$master_id)->where('TASK_ID',$value->task_id)->first();
                    if(is_null($result))
                    {
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

        return view('sale_contract.po.create')
               ->with('notifyParties',$notifyParties);
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        DB::beginTransaction();
        $po_number='';
        try {

            $POMaster=new POMaster();
            $POMaster->PARTY_ID=$request->party_id;
            $POMaster->CREATE_DATE=date('Y-m-d');
            $POMaster->REMARK='Manually Created';
            $POMaster->PO_DATE=$request->sales_contact_date ? date("Y-m-d", strtotime($request->sales_contact_date)) : date('Y-m-d');
            $POMaster->REF_PO_NO=$request->ref_po_no;
            $POMaster->ORDER_QTY=0;
            $POMaster->TEMPLATE_ID=0;
            $POMaster->ORDER_STATUS='Y';
            $POMaster->ORDER_TYPE=$request->order_type;
            $POMaster->IUID=Auth::user()->id;
            $POMaster->EUID=Auth::user()->id;
            $POMaster->save();
            $po_number = $this->createPONumber($request->party_id);
            $POMaster->PO_NO=$po_number;
            $POMaster->save();
            
        $chunkSize = 100;    
        $itemArray = $request->item_array;
        $chunks = array_chunk($itemArray, $chunkSize);
        foreach($chunks as $chunk) {
                 
            foreach ($chunk as $item) {

                // if(CiItem::where('ci_item_code',(int)$item['item_code'])->count()!=0){
                        $ci_item=CiItem::where('ci_item_code',$item['item_code'])->first(['id']);

                //     if(NotifyPartyItem::where('notify_party_id',$request->party_id)->where('ci_item_id',$ci_item->id)->exists()){

                        $item_details=new POItemDetails();
                        $item_details->master_id=$POMaster->id;
                        $item_details->item_id=$ci_item ? $ci_item->id : NULL;
                        $item_details->item_name=$item['item_name'];
                        $item_details->factor=$item['factor'];
                        $item_details->rate_per_ctn=$item['rate'];
                        $item_details->order_qty_ctn=$item['order_qty'];
                        $item_details->cbm=$item['cbm'];
                        if($ci_item){
                            $coding_matter = NotifyPartyItem::where('notify_party_id', $request->party_id)
                                ->where('ci_item_id', $ci_item->id)
                                ->value('coding_matter');
                            
                            $special_requirement = NotifyPartyItem::where('notify_party_id', $request->party_id)
                                ->where('ci_item_id', $ci_item->id)
                                ->value('special_requirement');

                            $item_details->coding_matter = $coding_matter ? $coding_matter : null;
                            $item_details->special_requirement = $special_requirement ? $special_requirement : null;
                        }
                        $item_details->specifition=$item['specifications'];
                        $item_details->ref_code=$item['ref_code'];
                        $item_details->save(); 
    
                //     }

                // }
               

            }
                
        } 
                                
        $status='Success';
        DB::commit();
        }catch(\Exception $e) {
            
            if($e->getMessage()){
            
                $status='Error'; 
  
            }
            
            DB::rollback();
                
        }

        //$this->sendNewOrderMail($POMaster->id,$po_number,$request->party_id,$request->order_type);   

        return response()->json([
                    
            'status'=>$status,
            'po_number'=>$po_number 

        ]);

    }

    public function sendNewOrderMail($po_id,$po_number,$party_id,$order_type){
         
        $user=User::where('id',Auth::user()->id)->first(['email','name']);
        $email_array = DB::table('notify_party_users')
                ->join('users', 'users.id', '=', 'notify_party_users.user_id')
                ->select('users.email')
                ->where('notify_party_id', $party_id)
                ->where('users.active', 1)
                ->where('users.order_mail_status', 1)
                ->whereNotNull('email')
                ->get()
                ->pluck('email')
                ->toArray();

        $notify_party=NotifyParty::where('id',$party_id)->first(['code','name']);
        $items=DB::select("select
                bus.name                      as bu,
                ci_items.ci_item_code         as code,
                ci_items.ci_item_name         as name,
                po_item_details.factor        as factor,
                po_item_details.order_qty_ctn as qty,
                po_item_details.specifition   as specification
            from po_item_details
                join ci_items on ci_items.id = po_item_details.item_id
                join bus on bus.id=ci_items.bu_id
            where master_id =$po_id
            order by bus.name");

        $data = array(
            'name'=>$user->name,
            'email'=>$user->email,
            'po_no'=>$po_number,
            'email_list'=>$email_array,
            'party_code'=>$notify_party->code,
            'party_name'=>$notify_party->name,
            'items'=>$items,
            'ordr_type'=>$order_type==1 ? 'PRAN order' : 'Global trading'
        );

        
        $from_mail=env('MAIL_FROM_ADDRESS');
        Mail::send('web_order_mail', $data, function($message) use ($from_mail,$data){
            $message->from($from_mail,'Web-Order-Mail@prangroup.com');
            $message->to($data['email_list']);
            $message->cc(['mis@prangroup.com','mis4@mis.prangroup.com','mis10@mis.prangroup.com','mis94@mis.prangroup.com']); 
            $message->subject('New Order Notification, PO No: '.$data['po_no']);
        }); 

    }

    public function addedPoMaterItem(Request $request){
            
        $status="";

        if($request->item_id){
             
            if(POItemDetails::where('item_id',$request->item_id)->where('master_id',$request->po_master_id)->exists()){

                return response()->json([
                    
                    'status'=>"alredy_exist"

                ],200); 

            }

            $poItemDetails=new POItemDetails();
            $poItemDetails->master_id=$request->po_master_id;
            $poItemDetails->item_id=$request->item_id;
            $poItemDetails->item_name=$request->item_name;
            $poItemDetails->factor=$request->item_factor ? $request->item_factor : 0;
            $poItemDetails->order_qty_ctn=$request->order_qty;
            $poItemDetails->specifition=$request->specification;
            $poItemDetails->save(); 
            $status="success";
    
        }else{

            $poItemDetails=new POItemDetails();
            $poItemDetails->master_id=$request->po_master_id;
            $poItemDetails->item_name=$request->item_name;
            $poItemDetails->factor=$request->item_factor ? $request->item_factor : 0;
            $poItemDetails->order_qty_ctn=$request->order_qty;
            $poItemDetails->specifition=$request->specification;
            $poItemDetails->save(); 
            $status="success";
        }
        return response()->json([
                    
            'status'=>$status

        ],200); 
         

    }

    private function createPONumber($party_id){

        //PONumber
        $t = Carbon::now();  
        $day = $t->day;
        $month = $t->month;
        $year = $t->year;
        if($day<10){
            $day='0'.$day;
        }
        if($month<10){
            $month='0'.$month;
        }
        $date=$month.'-'.$day.'-'.$year;
        $currentYear=date('Y');
        $party_code=NotifyParty::where('id',$party_id)->first(['code']);
        $importerIdExistOrNOt =PONumber::orderBy('id','Desc')->where('party_id',$party_id)->where('year',$currentYear)->first();
        $importerIdExistOrNOtArray=(array)$importerIdExistOrNOt;
        if(count($importerIdExistOrNOtArray)>0){


            $number=$importerIdExistOrNOt->number;
            $number=$number+1;
            $po_number=new PONumber();
            $po_number->party_id=$party_id;
            $po_number->number=$number;
            $po_number->year=$currentYear;
            $po_number->save();
            $create_number=str_pad($number,6,'0',STR_PAD_LEFT); 
            return $party_code->code.'-'.$create_number.'-'.$currentYear;
         
        }else{

           $number=1;
           $po_number=new PONumber();
           $po_number->party_id=$party_id;
           $po_number->number=1;
           $po_number->year=$currentYear;
           $po_number->save();
           $create_number=str_pad($number,6,'0',STR_PAD_LEFT);
           return $party_code->code.'-'.$create_number.'-'.$date;

           
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
        $results=DB::select("SELECT
                    po_item_details.id,
                    if(ci_items.ci_item_code,ci_items.ci_item_code,'') as code,
                    case when ci_items.ci_item_name  then ci_items.ci_item_name else po_item_details.item_name end as item_name,
                    po_item_details.factor,
                    po_item_details.rate_per_ctn,
                    po_item_details.order_qty_ctn,
                    case when po_item_details.specifition is null then '' else po_item_details.specifition end as remarks,
                    case when po_item_details.coding_matter is null then '' else po_item_details.coding_matter end as coding_matter,
                    case when po_item_details.special_requirement is null then '' else po_item_details.special_requirement end as special_requirement,
                    po_master.APPROVED_STATUS as status
                FROM po_master
                JOIN po_item_details on po_item_details.master_id=po_master.ID
                LEFT JOIN ci_items on ci_items.id=po_item_details.item_id
                LEFT JOIN notify_party_items npi ON npi.notify_party_id = po_master.PARTY_ID AND npi.ci_item_id = ci_items.id
                WHERE po_master.ID='$id' AND po_item_details.status='Y'");
        
        $approveStatus=POMaster::where('ID',$id)->first(['APPROVED_STATUS']);

        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "approveStatus"=>$approveStatus->APPROVED_STATUS,
                "po_edit_id"=>$id,
                "data"  => $results
            ]);

        }else{

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"    => [],
                "approveStatus"=>$approveStatus->APPROVED_STATUS
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

    public function updateSingleDemnad(Request $request){
        

        $ci_item=CiItem::where('ci_item_code',$request->item_code)->first(['id']);
        $result = POItemDetails::where('master_id',$request->edit_po_id)
                        ->where('item_id',$ci_item->id)
                        ->update([
                                'order_qty_ctn'       => $request->order_qty,
                                'coding_matter'       => $request->coding_matter,
                                'special_requirement' => $request->special_requirement,
                                'specifition'         => $request->specifications
                            ]);

        if($result) {

            return response()->json([
                'message' => "Success",
                "code"    => 200,
            ]);

        } else  {
            return response()->json([
                'message' => "Fail",
                "code"    => 500
            ]);
        }


    }

    public function updateAllDemnad(Request $request){
       
        $status="";
        DB::beginTransaction();
        try {

            for($i=0;$i<count($request->editPoDetails);$i++){
                POItemDetails::where('id',$request->editPoDetails[$i]['line_id'])
                    ->update([
                        'order_qty_ctn'        => $request->editPoDetails[$i]['order_qty']      ? $request->editPoDetails[$i]['order_qty'] : 0,
                        'coding_matter'        => $request->editPoDetails[$i]['coding_matter']  ? $request->editPoDetails[$i]['coding_matter'] : '',
                        'special_requirement'  => $request->editPoDetails[$i]['special_requirement']  ? $request->editPoDetails[$i]['special_requirement'] : '',                        
                        'specifition'          => $request->editPoDetails[$i]['remarks'] ?  $request->editPoDetails[$i]['remarks'] : ''
                    ]);                          
                DB::commit();        
            }
            $status='Success'; 

        }catch(\Exception $e) {
            
            if($e->getMessage()){
            
                $status='Error'; 
  
            }
            
            DB::rollback();
                
        }

        return response()->json([
            'message' => $status,
            "code"    => 200,
        ]);
        
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

    public function downloadPartyItemExcel(Request $request){
       
        $results=DB::select("SELECT
                ci_items.ci_item_code AS Item_Code,
                ci_items.ci_item_name AS Name,
                ci_items.factor AS Factor,
                0 as Rate_Per_Ctn,
                0 as Order_Qty_Ctn,
                notify_party_items.cbm_per_ctn as `Cbm`,
                '' as Ref_Code,
                '' as Remarks
            FROM notify_party_items
                JOIN ci_items ON ci_items.id = notify_party_items.ci_item_id
                JOIN notify_parties on notify_parties.id=notify_party_items.notify_party_id
            WHERE notify_party_items.notify_party_id ='$request->party_id'");
        
        if(count($results) > 0) {

            $array = array();
            for ($i = 0, $c = count($results); $i < $c; ++$i) {

                $array[$i] = (array) $results[$i];
            }

            return \Excel::create('PARTY_ITEMS', function($excel) use ($array) {

                    $excel->sheet('mySheet', function($sheet) use ($array) {

                        $sheet->fromArray($array);
                    });

            })->download('xls');

                    
        }else{

            Session::flash("danger", "No Data Available..!");
            return redirect()->back();
        } 


    }

    public function jsonDownloadPoItem(Request $request){
        
        // $results=DB::select("select
        //         ci_items.ci_item_code         as item_code,
        //         ci_items.ci_item_name         as item_name,
        //         po_item_details.order_qty_ctn as ctn,
        //         0                             as sample,
        //         po_item_details.specifition   as unit
        //         from po_master
        //             join po_item_details on po_item_details.master_id = po_master.ID
        //             join ci_items on ci_items.id = po_item_details.item_id
        //             join notify_parties on notify_parties.id = po_master.PARTY_ID
        //             join (select
        //                     notify_party_items.ci_item_id      as item_id,
        //                     notify_party_items.notify_party_id as party_id,
        //                     notify_party_items.acc_rate        as acc_rate,
        //                     notify_party_items.party_rate      as party_rate
        //                 from notify_party_items) as t1 on t1.party_id = po_master.PARTY_ID and t1.item_id = po_item_details.item_id
        //         where po_master.ID='$request->po_id' and po_item_details.status='Y'");


         $results=DB::select("select
                TRIM(ci_items.ci_item_code)         as item_code,
                ci_items.ci_item_name         as item_name,
                po_item_details.order_qty_ctn as ctn,
                0                             as sample,
                0                             as purchase_rate,
                0                             as sales_rate
                from po_master
                    join po_item_details on po_item_details.master_id = po_master.ID
                    join ci_items on ci_items.id = po_item_details.item_id
                    join bus on bus.id=ci_items.bu_id
                where po_master.ID='$request->po_id' and po_item_details.status='Y'
                order by bus.name");


        if(count($results) > 0) {

            $array = array();
            for ($i = 0, $c = count($results); $i < $c; ++$i) {

                $array[$i] = (array) $results[$i];
            }
            return \Excel::create('Order_Reports', function($excel) use ($array) {

                        $excel->sheet('mySheet', function($sheet) use ($array) {

                            $sheet->fromArray($array);
                        });
                    })->download('xls');
                    
        }else{

            Session::flash("danger", "No Data Available..!");
            return redirect()->back();
        } 
       

    }

    public function codeItemDetails(Request $request){
         
   
        return NotifyPartyItem::where('notify_party_id',$request->notify_party_id)
                ->where('ci_item_code',$request->ci_item_code)
                ->join('ci_items','ci_items.id','notify_party_items.ci_item_id')
                ->leftJoin('party_order_items','party_order_items.ci_item_id','notify_party_items.ci_item_id')
                ->select('ci_items.id','ci_items.ci_item_name','ci_items.factor','ci_items.hs_code','notify_party_items.cbm_per_ctn','ci_items.ci_item_code','notify_party_items.acc_rate','notify_party_items.party_rate','notify_party_items.desk_item_name','notify_party_items.gross_weight')
                ->first();        

    }

    public function getPoDetails(Request $request){
        
        $results=DB::select("select
                    CONCAT(ci_items.ci_item_code,'-',ci_items.ci_item_name) as item_name,
                    po_item_details.factor,
                    po_item_details.rate_per_ctn,
                    po_item_details.order_qty_ctn,
                    po_item_details.specifition
                from po_master
                join po_item_details on po_item_details.master_id=po_master.ID
                join ci_items on ci_items.id=po_item_details.item_id
                WHERE po_master.PO_NO='$request->po_no'");

        return response()->json([
            'results'=>$results
        ],200); 

    }

    public function inactiveDemandItem(Request $request){
        
        $ids_string = implode(',', $request->line_ids);
        $results=DB::select("UPDATE po_item_details SET status='N' WHERE po_item_details.id IN ($ids_string)");
        return response()->json([
            'status'=>'success'
        ],200); 

    }

    public function demandPartyItemView(Request $request){
          
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'");
        return view('sale_contract.po.party_item')
               ->with('notifyParties',$notifyParties);

    }

    public function getOrderPartyItems(Request $request){

        
        $notifyParty=NotifyParty::where('code',$request->party_code)->first(['id']);
        $results=DB::select("select
                ci_items.id,
                ci_items.ci_item_code as item_code,
                ci_items.ci_item_name as item_name,
                runits.runit_name as unit,
                case when party_order_items.party_item_code then party_order_items.party_item_code else '' end as party_item_code,
                case when party_order_items.party_item_name!='' then party_order_items.party_item_name else '' end as party_item_name,
                case when party_order_items.min_order_qty then party_order_items.min_order_qty else '0' end as min_odr_qty,
                case when party_order_items.max_order_qty then party_order_items.max_order_qty else '0' end  as max_odr_qty,
                case when party_order_items.reorder then party_order_items.reorder else '0' end as reorder_qty,
                case when party_order_items.purchase_lead_day then party_order_items.purchase_lead_day else '0' end as purchase_lead_day,
                case when party_order_items.agv_sales then party_order_items.agv_sales else '0' end as avg_sales
            from notify_party_items
                join notify_parties on notify_parties.id=notify_party_items.notify_party_id
                join ci_items on ci_items.id=notify_party_items.ci_item_id
                join runits on runits.id=notify_party_items.runit
                left join party_order_items on party_order_items.ci_item_id=notify_party_items.ci_item_id
            where notify_party_items.notify_party_id='$notifyParty->id' AND ci_items.status=1");

        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);

        }else{

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);

        }


    }

    public function saveOrderItems(Request $request){

        for ($i=0; $i<count($request->itemDetails); $i++) {
            
            $notifyParty=NotifyParty::where('code',$request->party_code)->first(['id']);
            $ciItem=CiItem::where('ci_item_code',$request->itemDetails[$i]['item_code'])->first(['id']);
            $partyOrderItem=PartyOrderItem::where('party_id',$notifyParty->id)->where('ci_item_id',$ciItem->id)->first();

            if(is_null($partyOrderItem)){
                 
                if($request->itemDetails[$i]['party_item_code']!=""){
                    
                    $partyOrderItem=new PartyOrderItem();
                    $partyOrderItem->party_id=$notifyParty->id;
                    $partyOrderItem->ci_item_id=$ciItem->id;
                    $partyOrderItem->party_item_code=$request->itemDetails[$i]['party_item_code'];
                    $partyOrderItem->party_item_name=$request->itemDetails[$i]['party_item_name'];
                    $partyOrderItem->min_order_qty=$request->itemDetails[$i]['min_order_qty'] ? $request->itemDetails[$i]['min_order_qty'] : 0;
                    $partyOrderItem->max_order_qty=$request->itemDetails[$i]['max_order_qty'] ? $request->itemDetails[$i]['max_order_qty'] : 0;
                    $partyOrderItem->reorder=$request->itemDetails[$i]['reorder_qty'] ? $request->itemDetails[$i]['reorder_qty'] : 0;
                    $partyOrderItem->purchase_lead_day=$request->itemDetails[$i]['purchase_lead_day'] ? $request->itemDetails[$i]['purchase_lead_day'] : 0;
                    $partyOrderItem->agv_sales=$request->itemDetails[$i]['avg_sales'] ? $request->itemDetails[$i]['avg_sales'] : 0;
                    $partyOrderItem->created_date=date('Y-m-d');
                    $partyOrderItem->created_by=Auth::user()->id;
                    $partyOrderItem->save();

                }

            }else{
                 
                PartyOrderItem::where('party_id',$notifyParty->id)->where('ci_item_id',$ciItem->id)->update([
                    'party_id'=>$notifyParty->id,
                    'ci_item_id'=>$ciItem->id,
                    'party_item_code'=>$request->itemDetails[$i]['party_item_code'],
                    'party_item_name'=>$request->itemDetails[$i]['party_item_name'],
                    'min_order_qty'=>$request->itemDetails[$i]['min_order_qty'] ? $request->itemDetails[$i]['min_order_qty'] : 0,
                    'max_order_qty'=>$request->itemDetails[$i]['max_order_qty'] ? $request->itemDetails[$i]['max_order_qty'] : 0,
                    'reorder'=>$request->itemDetails[$i]['reorder_qty'] ? $request->itemDetails[$i]['reorder_qty'] : 0,
                    'purchase_lead_day'=>$request->itemDetails[$i]['purchase_lead_day'] ? $request->itemDetails[$i]['purchase_lead_day'] : 0,
                    'agv_sales'=>$request->itemDetails[$i]['avg_sales'] ? $request->itemDetails[$i]['avg_sales'] : 0,
                    'created_date'=>date('Y-m-d'),
                    'created_by'=>Auth::user()->id
                ]);

            }

        }
			
        return response()->json([

            'message' => "Data Inserted Successfully",
            "code"    => 200
        ]);
			 

    }


}
