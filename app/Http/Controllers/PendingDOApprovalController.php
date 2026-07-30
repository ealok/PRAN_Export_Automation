<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\JobOrderMaster;
use DB;
use App\SaleContract;
use App\SaleContractDetail;
use App\User;
use App\POMaster;
use App\LandPortDashboard;
use App\seaPortdashboard;
use Mail;
class PendingDOApprovalController extends Controller
{   
    public function __construct(){

        $this->middleware('auth');

    }


    public function showListDOPending(){
      
        $results=DB::select("CALL DPL()");
        return view('do_pending_list')->with('results',$results);
  
      }

      public function balanceBreakerApprovalMail(Request $request){
        
        $status='';
        $result='';
        $joMaster=JobOrderMaster::where('id',$request->jo_id)->first(['bbm_status']);
        if(is_null($joMaster->bbm_status) || empty($joMaster->bbm_status)){
            
           $current_date=date('d-m-Y');
           $result=JobOrderMaster::where('id','=',$request->jo_id)
                ->update([
                  'bbm_status' => 'N',
                  'credit_limit'=>$request->credit_limit,
                  'undel_value'=>$request->undelivered,
                  'balance'=>$request->balance,
                  'bbm_date'=>date("Y-m-d", strtotime($current_date)),
                  'usd'=>$request->rate]);
                  
           if($result==true){
             
             $status='Success';
             $this->sendBlanceBreakerApprovalMail($request->jo_id);
                 
           }  
        
        }else{
          
          $joMaster=JobOrderMaster::findorfail($request->jo_id);
          if($joMaster->bbm_status=="Y"){
           
             $status='Approve'; 
  
          }elseif($joMaster->bbm_status=="N"){
             
             $status='Sent';
  
          }   
  
        }
  
        return response()->json([
           
          'status'=>$status
             
        ],200);
  
      }
  
      private function sendBlanceBreakerApprovalMail($jo_id){
  
        $email_array=array('accts6@prangroup.com');
        $joMaster=JobOrderMaster::where('id',$jo_id)->first(['user_id']);
        $user=User::where('id',$joMaster->user_id)->first(['name','email']);
        $results=DB::select("SELECT
                  sale_contracts.sales_contract_no AS sc_no,
                  sale_contracts.invoice_no AS invoice_no,
                  notify_parties.name AS party_name,
                  notify_parties.area AS country,
                  job_order_number AS jo_number,
                  job_order_masters.credit_limit as credit_limit,
                  job_order_masters.undel_value as undel_value,
                  job_order_masters.balance as balance,
                  Round(SUM(job_order_details.rate*job_order_details.orqt),2) as do_amount,
                  Round(job_order_masters.credit_limit-(balance+undel_value+SUM(job_order_details.rate*job_order_details.orqt)),2) as due_amount 
              FROM job_order_masters
              JOIN job_order_details ON job_order_details.master_id=job_order_masters.id
              JOIN sale_contracts ON sale_contracts.id=job_order_masters.sale_contract_id
              JOIN notify_parties ON notify_parties.id=job_order_masters.importer_id
              where job_order_masters.id=$jo_id
              GROUP BY sale_contracts.sales_contract_no,sale_contracts.invoice_no,notify_parties.name,notify_parties.area,
              job_order_number,job_order_masters.credit_limit,job_order_masters.undel_value,job_order_masters.balance");
        $cc_mail=array('mis10@mis.prangroup.com',$user->email);
        $data = array(
            'results'=>$results,
            'receiver_email'=>$email_array,
            'subject'=>'Circuit Breaker : Export Credit DO Approval',
            'created_by'=>$user->name,
            'cc_mail'=>$cc_mail
         ); 
         
        Mail::send('do_approval_mail_view', $data, function($message) use ($data){
  
          $message->from('reportbi@prangroup.com');
          $message->to($data['receiver_email']);
          $message->cc($data['cc_mail']);
          $message->subject($data['subject']);
          
        }); 
  
      }  
  
      public function approvePendingDoList(Request $request){
        
        $ids=explode(",",$request->ids);
        $array = implode("','",$ids);
        $jo_user_ids=JobOrderMaster::whereIn('id', $ids)->pluck('user_id')->toArray();
        $sc_ids = JobOrderMaster::whereIn('id', $ids)->pluck('sale_contract_id')->toArray();
        $unique_sc_ids = array_unique($sc_ids);
        // foreach ($unique_sc_ids as $key => $value) {
           
        //   $saleContract = SaleContract::where('id', $value)->first(['id', 'po_number']);
        //   if($saleContract->po_number) {

        //       $poMaster = POMaster::where('PO_NO', $saleContract->po_number)->first(['id', 'TEMPLATE_ID']);
        //       if($poMaster && $poMaster->TEMPLATE_ID == 1){

        //           if(LandPortDashboard::where('sc_id', $request->sc_id)->where('Task_ID', 34)->count()>0) {

        //               $landPortDash = LandPortDashboard::where('sc_id', $request->sc_id)->where('Task_ID', 34)->first(['action_date']);
        //               if(is_null($landPortDash->action_date)) {

        //                   $updateStatus=LandPortDashboard::where('sc_id', $request->sc_id)
        //                       ->where('Task_ID', 34)
        //                       ->update([
        //                           'action_date' => date('Y-m-d')
        //                       ]);
                               
        //               }

        //           }

        //       } 

        //       elseif($poMaster && $poMaster->TEMPLATE_ID == 3) {

        //           if (seaPortdashboard::where('sc_id', $request->sc_id)->where('Task_ID', 34)->exists()) {

        //               $seaPortDash = seaPortdashboard::where('sc_id', $request->sc_id)->where('Task_ID', 34)->first(['action_date']);
        //               if(is_null($seaPortDash->action_date)) {

        //                   $updateStatus=seaPortdashboard::where('sc_id', $request->sc_id)
        //                       ->where('Task_ID', 34)
        //                       ->update([
        //                           'action_date' => date('Y-m-d')
        //                       ]);   

        //               }

        //           }
        //       }

        //   }

        // }
        $user_emails=User::whereIn('id',$jo_user_ids)->pluck('email')->toArray();
        $results=DB::select("SELECT
                  job_order_masters.id, 
                  sale_contracts.invoice_no AS invoice_no,
                  notify_parties.name AS party_name,
                  notify_parties.area AS country,
                  job_order_number AS jo_number,
                  users.name
              FROM
                  job_order_masters
              JOIN sale_contracts ON sale_contracts.id=job_order_masters.sale_contract_id
              JOIN notify_parties ON notify_parties.id=job_order_masters.importer_id
              join users ON users.id=job_order_masters.user_id
              where job_order_masters.id IN ('".$array."')"); 
  
        $result=JobOrderMaster::whereIn('id',$ids)
        ->update([
            'bbm_status' => 'Y'
          ]);
  
        if($result){
  
          $mail_status=$this->DOApprovedNotificationMail($user_emails,$results);
          if($mail_status){
             
            return response()->json([
              
              'status'=>'success',
              'ids'=>$request->ids
  
            ],200);
  
          }
           
        }  
  
      }
  
      public function DOApprovedNotificationMail($user_emails,$results){
                   
          $data = array(
            'results'=>$results,
            'receiver_email'=>$user_emails,
            'subject'=>'Circuit Breaker : Exp-DO Credit Balance Approval'
          ); 
          
          Mail::send('do_approval_done_view', $data, function($message) use ($data){
  
            $message->from('reportbi@prangroup.com');
            $message->to($data['receiver_email']);
            $message->cc(['mis@prangroup.com','mis4@mis.prangroup.com','mis10@mis.prangroup.com']);
            $message->subject($data['subject']);
            
          });
  
          return 1;
  
  
      }
    
}
