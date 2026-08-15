<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\JobOrderMaster;
use DB;
use App\SaleContract;
use App\SaleContractDetail;
use App\User;
use Mail;
use App\JOSyn;
use Auth;
use App\FreightLogHistory;
use App\Oc;
class ApprovalController extends Controller
{
    
    public function __construct()
    {
        
    }
    public function approvalPendingScList(){
       
      $sale_contracts=SaleContract::where('matching_status',2)
                          ->where('show_status','M')
                          ->where('mail_status','Y')
                          ->orWhere('mail_status','E')
                          ->get();
      return view('job_order.pending_approval_sc_list')
            ->with('sale_contracts',$sale_contracts);
            
  }



    public function jsonPendingJOBListEd(Request $request){

      return $qc_entries = SaleContract::where('show_status','E')
            ->get();

    }

    public function jsonPendingJOBListMd(Request $request){

         return $results=DB::select("SELECT
              sale_contracts.id,
              sale_contracts.sales_contract_no,
              sale_contracts.dated,
              sale_contracts.invoice_no,
              importers.name AS importer,
              banks.name AS bank
          FROM
              sale_contracts
          JOIN importers ON importers.id = sale_contracts.importer_id
          JOIN companies ON companies.id=sale_contracts.company_id
          JOIN banks ON banks.id=sale_contracts.bank_id
          WHERE sale_contracts.show_status='M'"); 

    }

    public function approvePendingJobOrderEd(Request $request){
          
        $ids=explode(",",$request->ids);
        $invoices=\DB::table("sale_contracts")->whereIn('id',$ids)->select('invoice_no')->get();
        $creator_ids=SaleContract::whereIn('id',$ids)->groupBy('creator_id')->select('creator_id')->get()->toArray();
        $head_ides=User::whereIn('id',$creator_ids)->select('head_id')->get()->toArray();
        $email_array=User::where('head_id',$head_ides)->select('email')->get()->toArray();
        $email_array = array_map(function ($item) { return $item["email"]; }, $email_array);  
        $data = array(
          'from_email' => 'reportbi@prangroup.com',
          'subject' => "JO Price Approval Done",
          'results' => $invoices,
          'receiver_email' => $email_array,
          'approve_by' =>'ED' 
        );

        for($i=0;$i<count($ids);$i++) {

          $jobOrderMaster=SaleContract::findorfail($ids[$i]);
          $jobOrderMaster->ed_approve=1;
          $jobOrderMaster->ed_approve_id=Auth::user()->id;
          $jobOrderMaster->show_status="";
          $jobOrderMaster->matching_status=1;
          $jobOrderMaster->mail_status=NULL;
          $jobOrderMaster->save();
          $update_id=$ids[$i];
          \DB::select("UPDATE sale_contract_details
            SET rate_status='Y' 
            WHERE `sale_contract_id`='$update_id' AND rate_status='E'");

        }
        
        $from_mail=env('MAIL_FROM_ADDRESS');
        Mail::send('Jo_approval_done_template', $data, function($message) use ($from_mail,$data){

          $message->from($from_mail,'JO Approval Mail'); 
          $message->to($data['receiver_email']);
          $message->cc(['mis@prangroup.com','mis4@mis.prangroup.com','mis10@mis.prangroup.com']); // CC mail address
          $message->subject($data['subject']);

        });

        return "success";

    }

    public function approvePendingJobOrderMd(Request $request){
          
      $ids=explode(",",$request->ids);
      $invoices=\DB::table("sale_contracts")->whereIn('id',$ids)->select('invoice_no')->get();
      $creator_ids=SaleContract::whereIn('id',$ids)->groupBy('creator_id')->select('creator_id')->get()->toArray();
      $head_ides=User::whereIn('id',$creator_ids)->select('head_id')->get()->toArray();
      $email_array = User::where('head_id', $head_ides)->whereNotNull('email')->where('email', '!=', '')->pluck('email')->toArray();
      $data = array(
        'from_email' => 'reportbi@prangroup.com',
        'subject' => "JO Price Approval Done",
        'results' => $invoices,
        'receiver_email' => $email_array,
        'approve_by' =>'MD'

      );

      for($i=0;$i<count($ids);$i++) {
      
        $jobOrderMaster=SaleContract::findorfail($ids[$i]);
        $jobOrderMaster->md_approve=1;
        $jobOrderMaster->md_approve_id=Auth::user()->id;
        $jobOrderMaster->show_status="";
        $jobOrderMaster->matching_status=1;
        $jobOrderMaster->mail_status=NULL;
        $jobOrderMaster->save();
        $update_id=$ids[$i];
        \DB::select("UPDATE sale_contract_details
          SET rate_status='Y'
          WHERE `sale_contract_id`='$update_id' AND (rate_status='M' OR rate_status='E' OR rate_status='S')");

      }

      try {
        
        $from_mail=env('MAIL_FROM_ADDRESS');
        Mail::send('Jo_approval_done_template', $data, function($message) use ($from_mail,$data){

          $message->from($from_mail,'JO Approval Mail');
          $message->to($data['receiver_email']);
          $message->cc(['mis@prangroup.com','mis4@mis.prangroup.com','mis10@mis.prangroup.com']);
          $message->subject($data['subject']);

        });
        
      } catch (Exception $e) {

         return $e;
         
      }

      return "success";

    }

    public function approvePendingInvoice(Request $request)
    {
        try {
            $id = $request->id;
            $invoices=DB::table("sale_contracts")->where('id',$id)->get();
            $jobOrderMaster = SaleContract::findOrFail($id);
            $invoiceNo = $jobOrderMaster->invoice_no;
            $jobOrderMaster->md_approve = 1;
            $jobOrderMaster->md_approve_id = Auth::user()->id;
            $jobOrderMaster->show_status = "";
            $jobOrderMaster->matching_status = 1;
            $jobOrderMaster->mail_status = NULL;
            $jobOrderMaster->save();
            DB::table('sale_contract_details')
                ->where('sale_contract_id', $id)
                ->whereIn('rate_status', ['M', 'E', 'S'])
                ->update(['rate_status' => 'Y']);

            $creatorId = SaleContract::where('id', $id)
                ->pluck('creator_id')
                ->toArray();

            $emailArray = [];
            if($creatorId) {
                $emailArray = User::where('id', $creatorId)
                    ->whereNotNull('email')
                    ->where('email', '!=', '')
                    ->pluck('email')
                    ->toArray();
            }
            
            $data = [
                'from_email' => 'reportbi@prangroup.com',
                'subject' => "JO Price Approval Done",
                'results' =>  $invoices,
                'receiver_email' => $emailArray,
                'approve_by' => 'Management'
            ];
            
            
            try {
                $from_mail = env('MAIL_FROM_ADDRESS');
                Mail::send('Jo_approval_done_template', $data, function($message) use ($from_mail, $data) {
                    $message->from($from_mail, 'JO Approval Mail');
                    $message->to($data['receiver_email']);
                    $message->cc(['mis@prangroup.com', 'mis4@mis.prangroup.com', 'mis10@mis.prangroup.com']);
                    $message->subject($data['subject']);
                });
            } catch (Exception $e) {
                
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Invoice ' . $invoiceNo . ' approved successfully.'
            ]);
            
        } catch (\Exception $e) {
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve invoice. ' . $e->getMessage()
            ], 500);
            
        }
    }

    public function rejectApprovalInvoice(Request $request){
        
         $reject_note=$request->reject_note;
         try {
            $id = $request->id;
            $invoices=DB::table("sale_contracts")->where('id',$id)->get();
            $jobOrderMaster = SaleContract::findOrFail($id);
            $invoiceNo = $jobOrderMaster->invoice_no;
            $jobOrderMaster->md_approve = 1;
            $jobOrderMaster->md_approve_id = Auth::user()->id;
            $jobOrderMaster->show_status = "";
            $jobOrderMaster->matching_status = 1;
            $jobOrderMaster->mail_status = NULL;
            $jobOrderMaster->save();
            DB::table('sale_contract_details')
                ->where('sale_contract_id', $id)
                ->whereIn('rate_status', ['M', 'E', 'S'])
                ->update(['rate_status' => 'Y']);
 
            $creatorId = SaleContract::where('id', $id)->value('creator_id');
            $emailArray = [];
            if($creatorId) {
                $emailArray = User::where('id', $creatorId)
                    ->whereNotNull('email')
                    ->where('email', '!=', '')
                    ->pluck('email')
                    ->toArray();
            }

            $data = [
                'from_email' => 'reportbi@prangroup.com',
                'subject' => "JO Price Approval Done",
                'results' => $invoices,
                'receiver_email' => $emailArray,
                'approve_by' => 'Management',
                'rejected_note' => $request->reject_note
            ];
            
            try {
                $from_mail = env('MAIL_FROM_ADDRESS');
                Mail::send('Jo_approval_rejected_template', $data, function($message) use ($from_mail, $data) {
                    $message->from($from_mail, 'JO Approval Mail');
                    $message->to($data['receiver_email']);
                    $message->cc(['mis@prangroup.com', 'mis4@mis.prangroup.com', 'mis10@mis.prangroup.com']);
                    $message->subject($data['subject']);
                });
            } catch (Exception $e) {
                
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Invoice ' . $invoiceNo . 'Rejected successfully.'
            ]);
            
        } catch (\Exception $e) {
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to Reject invoice. ' . $e->getMessage()
            ], 500);
            
        }

    }

    public function bulkApproveInvoices(Request $request){

        $ids=explode(",",$request->ids);
        $invoices=\DB::table("sale_contracts")->whereIn('id',$ids)->select('invoice_no')->get();
        $creator_ids=SaleContract::whereIn('id',$ids)->groupBy('creator_id')->select('creator_id')->get()->toArray();
        $head_ides=User::whereIn('id',$creator_ids)->select('head_id')->get()->toArray();
        $creatorIds = SaleContract::whereIn('id', $ids)
            ->whereNotNull('creator_id')
            ->where('creator_id', '!=', 0)
            ->pluck('creator_id')
            ->unique()
            ->toArray();

        $emailArray = User::whereIn('id', $creatorIds)
          ->whereNotNull('email')
          ->where('email', '!=', '')
          ->pluck('email')
          ->toArray();

        $data = array(
          'from_email' => 'reportbi@prangroup.com',
          'subject' => "JO Price Approval Done",
          'results' => $invoices,
          'receiver_email' => $emailArray,
          'approve_by' =>'MD'
        );

        for($i=0;$i<count($ids);$i++) {
        
          $jobOrderMaster=SaleContract::findorfail($ids[$i]);
          $jobOrderMaster->md_approve=1;
          $jobOrderMaster->md_approve_id=Auth::user()->id;
          $jobOrderMaster->show_status="";
          $jobOrderMaster->matching_status=1;
          $jobOrderMaster->mail_status=NULL;
          $jobOrderMaster->save();
          $update_id=$ids[$i];
          \DB::select("UPDATE sale_contract_details
            SET rate_status='Y'
            WHERE `sale_contract_id`='$update_id' AND (rate_status='M' OR rate_status='E' OR rate_status='S')");

        }

        try {
          
          $from_mail=env('MAIL_FROM_ADDRESS');
          Mail::send('Jo_approval_done_template', $data, function($message) use ($from_mail,$data){
            $message->from($from_mail,'JO Approval Mail');
            $message->to($data['receiver_email']);
            $message->cc(['mis@prangroup.com','mis4@mis.prangroup.com','mis10@mis.prangroup.com']);
            $message->subject($data['subject']);
          });

          return response()->json([
            'success' => true,
            'message' => 'Invoice approved successfully.'
          ]);
          
        } catch(Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to approve the invoice.'
            ], 500);

        }

    }

    public function balanceBreakerApprovalMail(Request $request){
      
      $status='';
      $result='';
      $joMaster=JobOrderMaster::where('id',$request->jo_id)->first(['bbm_status']);
      if(is_null($joMaster->bbm_status) || empty($joMaster->bbm_status)){
          
         $result=JobOrderMaster::where('id','=',$request->jo_id)
              ->update([
                'bbm_status' => 'N',
                'credit_limit'=>$request->credit_limit,
                'undel_value'=>$request->undelivered,
                'balance'=>$request->balance,
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

      $email_array=array('md@prangroup.com'); 
      $joMaster=JobOrderMaster::where('id',$jo_id)->first(['user_id']);
      $user=User::where('id',$joMaster->user_id)->first(['name']);
      
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

      $data = array(
        'results'=>$results,
        'receiver_email'=>$email_array,
        'subject'=>'Circuit Breaker : Export Credit DO Approval',
        'created_by'=>$user->name
       ); 
      
      $from_mail=env('MAIL_FROM_ADDRESS');

      Mail::send('do_approval_mail_view', $data, function($message) use ($from_mail,$data){

        $message->from($from_mail,'JO Approval Mail');
        $message->to($data['receiver_email']);
        $message->subject($data['subject']);
        
      }); 

    }

    public function showListDOPending(){
      
      $results=DB::select("CALL DPL()");
      return view('do_pending_list')->with('results',$results);

    }

    public function approvePendingDoList(Request $request){
      
      $ids=explode(",",$request->ids);
      $array = implode("','",$ids);
      $jo_user_ids=JobOrderMaster::whereIn('id', $ids)->pluck('user_id')->toArray();
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

        $from_mail=env('MAIL_FROM_ADDRESS');
        
        Mail::send('do_approval_done_view', $data, function($message) use ($from_mai,$data){
          $message->from($from_mai,'DO Approval Mail');
          $message->to($data['receiver_email']);
          $message->cc(['mis@prangroup.com','mis4@mis.prangroup.com','mis10@mis.prangroup.com']);
          $message->subject($data['subject']);
        });

        return 1;


    }

    public function getSynchronization(){
       
      return view('syn.syn_view');

    }

    public function kyvJobOrderReceive(Request $request){

        $results=DB::select("CALL PROC_KYV_JO_RECEIVE()");
        $array=array();
        $array['UserName'] = '211347'; 
        $array['IsBulk'] = 1;
        foreach($results as $result){

          $data_array[]=array('DistCode'=>$result->Code,'Invoice_No'=>$result->invoice,'JO_No'=>$result->JO_NO,'JO_Date'=>$result->Date,'Delivery_Date'=>$result->delivery_date,'Item_Code'=>$result->Item,'Order_Qty'=>$result->Order,'Rate'=>$result->Rate,'Status'=>$result->Status,'DoNo'=>"",'DoDate'=>"",'OID'=>$result->old);
          $array['data']=$data_array;

        }

        if(count($array) > 0) {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://runner.prangroup.com:4002/kyvexpapi/Api/JOPBulk',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'ss: Alok',
                    'yy: HJDyh876Yhdsf543GDJksn',
                    'Content-Type: application/json'
                ),
                CURLOPT_POSTFIELDS => json_encode($array)
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $responseData = json_decode($response, true);
            $joSyn=new JOSyn();
            $joSyn->status='SUCCESS';
            $joSyn->msg=$responseData['SuccessMessage'];
            $joSyn->syn_date=date('Y-m-d');
            $joSyn->save();                  
        }

    }

    public function kyvJobOrderUpdateReceive(Request $request){

        $results=DB::select("CALL PROC_KYV_JO_UPDATE_RECEIVE()");
        $array=array();
        $array['UserName'] = '211347'; 
        $array['IsBulk'] = 1;
        foreach($results as $result){

          $data_array[]=array('DistCode'=>$result->Code,'Invoice_No'=>$result->invoice,'JO_No'=>$result->JO_NO,'JO_Date'=>$result->Date,'Delivery_Date'=>$result->delivery_date,'Item_Code'=>$result->Item,'Order_Qty'=>$result->Order,'Rate'=>$result->Rate,'Status'=>$result->Status,'DoNo'=>"",'DoDate'=>"",'OID'=>$result->old);
          $array['data']=$data_array;

        }

        if(count($array) > 0) {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://runner.prangroup.com:4002/kyvexpapi/Api/JOPBulk',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'ss: Alok',
                    'yy: HJDyh876Yhdsf543GDJksn',
                    'Content-Type: application/json'
                ),
                CURLOPT_POSTFIELDS => json_encode($array)
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $responseData = json_decode($response, true);
            $joSyn=new JOSyn();
            $joSyn->status='SUCCESS';
            $joSyn->msg=$responseData['SuccessMessage'];
            $joSyn->syn_date=date('Y-m-d');
            $joSyn->save();                  
        }


    }


    public function invoiceFreightFatching(Request $request){
       
        $results=DB::select("SELECT
                    sale_contracts.id                    as id, 
                    sale_contracts.invoice_no            as invoice,
                    case when sales_terms.name='FOB'     then 'FOB'
                    when sales_terms.name='CFR'  then 'CFR'
                    when sales_terms.name='CPT'  then 'CFR'
                    when sales_terms.name='CIF'  then 'CFR'
                    when sales_terms.name LIKE 'FOB,%' THEN 'FOB'
                    else 'FOB' end                       as sales_term,
                    companies.code2                      as company_id,
                    case when sale_contracts.freight_charge_india
                      then sale_contracts.freight_charge_india
                    else sale_contracts.freight_cost
                    end as freight_cost,
                    case when sale_contracts.container_1 then CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(sale_contracts.container_1,' ',1),'x',1) AS UNSIGNED)
                    when sale_contracts.container_2    then CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(sale_contracts.container_2,' ',1),'x',1) AS UNSIGNED)
                    when sale_contracts.container_3    then CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(sale_contracts.container_3,' ',1),'x',1) AS UNSIGNED)
                    else 0 end as containter_qty,
                    case when sale_contracts.container_1 then SUBSTRING_INDEX(sale_contracts.container_1,'X',-1)
                    when sale_contracts.container_2 then SUBSTRING_INDEX(sale_contracts.container_2,'X',-1)
                    when sale_contracts.container_3 then SUBSTRING_INDEX(sale_contracts.container_3,'X',-1)
                    else 0 end as container_size
            from sale_contracts
              join sales_terms on sales_terms.id = sale_contracts.sales_term_id
              join companies on companies.id=sale_contracts.company_id
            where date(sale_contracts.created_at)>='2023-02-01' and date(sale_contracts.created_at)<='2023-02-28'
                  AND sale_contracts.inactive='N'
            having containter_qty>0");

      if(count($results)>0){
            
        foreach ($results as $key => $value) {
             
            $company_id=$value->company_id;
            $invoice_number=$value->invoice;
            $container_qty=$value->containter_qty;
            $charge=$value->freight_cost; 
            $container_size=$value->container_size;
            $sales_term=$value->sales_term;
            $sale_contract_id=$value->id;

            $url = 'http://runner.prangroup.com:9001/app/prg/invoices/job';
            $url .= '?company_id=' . urlencode($company_id);
            $url .= '&invoice_number=' . urlencode($invoice_number);
            $url .= '&container_quantity=' . urlencode($container_qty);
            $url .= '&charges=' . urlencode($charge);
            $url .= '&container_size=' . urlencode($container_size);
            $url .= '&sales_term=' . urlencode($sales_term);
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
            ));
            
            $response = curl_exec($curl);
            curl_close($curl);
            $responseObject = json_decode($response);
            $outputMsg = $responseObject->output_msg;
            $freightLogHistory=new FreightLogHistory();
            $freightLogHistory->sc_id=$sale_contract_id;
            $freightLogHistory->user_id=Auth::user()->id;
            $freightLogHistory->message=$outputMsg;
            $freightLogHistory->save();

        }

      }

    }

    public function kyvDOUpdatedReceive(Request $request){
           
      $results=DB::select("CALL PROC_KYV_DO_RECEIVE()");
      if(count($results)>0){
      
        foreach ($results as $key => $value) {
            
          $dist_code=$value->Code;
          $jo_no=$value->JO;
          $item=$value->Item;
          $do_no=$value->DO;
          $do_date=date("d-m-Y",strtotime($value->date));
          $curl = curl_init();
          curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://runner.prangroup.com:4002/kyvexpapi/api/ssapi',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "actionName": "JO_UPDATE_DO",
            "ComId": "PRAN",
            "Param1": "'.$dist_code.'",
            "Param2": "'.$jo_no.'",
            "Param3": "'.$item.'",
            "Param4": "'.$do_no.'",
            "Param5": "'.$do_date.'",
            "Param6": "",
            "Param7": "",
            "Param8": ""
            }',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'ss: SSA',
                'yy: HJDyh876Yhd765JHdgeoOsdesIUh9876KKLjfkusYhGHS'
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
    
        } 

      }

    }

    public function ocUpdate(Request $request){
          
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://runner.prangroup.com:4005/api/ssapi',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "actionName": "EXP_CHALLAN_INFO",
            "ComId": "PRAN",
            "Param1": "01/01/2024",
            "Param2": "18/02/2024",
            "Param3": "",
            "Param4": "",
            "Param5": "",
            "Param6": "",
            "Param7": "",
            "Param8": ""
        }

        ',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'ss: SSA',
            'yy: HJDyh876Yhd765JHdgeoOsdesIUh9876KKLjfkusYhGHS'
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $responseObject = json_decode($response);
        foreach($responseObject as $key => $value) {
             
            if(Oc::where('jo_no',$value->JO_NO)->count()==0){
                
                $oc=new Oc();
                $oc->jo_no=$value->JO_NO;
                $oc->sc_id=JobOrderMaster::where('job_order_number',$value->JO_NO)->value('sale_contract_id');
                $oc->dist_id=$value->DIST_ID;
                $oc->do_no=$value->DO_NO;
                $oc->order_qty=$value->ORDER_QTY;
                $oc->challan_no=$value->CHALLAN_NO;
                $date = \DateTime::createFromFormat('d/m/Y', $value->CH_DATE);
                $ch_date = $date->format('Y-m-d');
                $oc->challan_date=$ch_date;
                $oc->challan_qty=$value->CH_QTY;
                $oc->bal_qty=$value->BAL_QTY;
                $oc->save();

            }else{

              $date = \DateTime::createFromFormat('d/m/Y', $value->CH_DATE);
              $ch_date = $date->format('Y-m-d');

              Oc::where('jo_no',$value->JO_NO)->update([
                'jo_no'=>$value->JO_NO,
                'sc_id'=>JobOrderMaster::where('job_order_number',$value->JO_NO)->value('sale_contract_id'),
                'dist_id'=>$value->DIST_ID,
                'do_no'=>$value->DO_NO,
                'order_qty'=>$value->ORDER_QTY,
                'challan_no'=>$value->CHALLAN_NO,
                'challan_date'=>$ch_date,
                'challan_qty'=>$value->CH_QTY,
                'bal_qty'=>$value->BAL_QTY
              ]);

            }
            
                   
        }


    }

    public function ciValueSyn(){

       $results=DB::select("select id from sale_contracts where created_at>='2024-07-01' and created_at<='2024-09-10'");
       foreach($results as $key => $value) {

          $this->updateCiTotalValue($value->id);
          
       }

       return response()->json([
          'message'=>'Done',
          'status'=>200
       ]);

    }

    public function joSingleReceive(Request $request){

       if(JobOrderMaster::where('job_order_number', $request->jo_no)->count()>0){
           
          $job_order=JobOrderMaster::where('job_order_number', $request->jo_no)->first(['id']);
          return $this->updateKyvData($job_order->id);

       }else{
         
          return response()->json([
              'code'=> 400,
              'msg'=>'No Job Order Found'
          ]);

       }
      
    }


    private function updateKyvData($jo_id){

        $results = DB::select("CALL PROC_KYV_JO_RECEIVE_BY_ID(?)", [$jo_id]);
        if(count($results)>0){
            $array=array();
            $array['UserName'] = Auth::user()->username; 
            $array['IsBulk'] = 1;
            foreach($results as $result){

              $data_array[]=array('DistCode'=>$result->Code,'Invoice_No'=>$result->invoice,'JO_No'=>$result->JO_NO,'JO_Date'=>$result->Date,'Delivery_Date'=>$result->delivery_date,'Item_Code'=>$result->Item,'Order_Qty'=>$result->Order,'Rate'=>$result->Rate,'Status'=>$result->Status,'DoNo'=>"",'DoDate'=>"",'OID'=>$result->old);
              $array['data']=$data_array;

            }
            
            if(count($array) > 0) {

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://runner.prangroup.com:4002/kyvexpapi/Api/JOPBulk',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_HTTPHEADER => array(
                        'ss: Alok',
                        'yy: HJDyh876Yhdsf543GDJksn',
                        'Content-Type: application/json'
                    ),
                    CURLOPT_POSTFIELDS => json_encode($array)
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                $responseData = json_decode($response, true);
                if (isset($responseData['SuccessCode']) && $responseData['SuccessCode'] == "2000") {
                    return response()->json([
                        'code' => 200, 
                        'msg' => 'JO Updated Successfull' // Success message from the API response
                    ]);
                } else {
                    return response()->json([
                        'code' => 400, 
                        'msg' => 'No Job Order Found'
                    ]);
                }
            }
        }else{
           
          return response()->json([
              'code'=> 400,
              'msg'=>'No Job Order Found'
          ]);
 
        }
        
    }


    public function updateCiTotalValue($id){

      $total_sum=0;
      $sale_contract=SaleContract::findorfail($id);  
      $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
      if($total_net_weight){

          $per_unit_freight=$sale_contract->freight_cost/$total_net_weight;
          $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                              ->select('sale_contract_details.ci_item_name','sale_contract_details.rate_per_ctn','ci_items.ci_factor',
                                  DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                  DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                  DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                  DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                  DB::Raw('SUM(sale_contract_details.ctn) AS ctn'))
                          ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                          ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                          ->groupby('sale_contract_details.ci_item_name')
                          ->orderBy('sale_contract_details.id')
                          ->get();

          foreach($sale_contract_details as $sale_contract_detail){

              try { 

                  if($sale_contract_detail->ci_factor !=0 ){
  
                      $per_net_weight_kg_fright=$per_unit_freight*$sale_contract_detail->net_weight_kg;
                      if($sale_contract_detail->ctn){

                          $caton_fright=$per_net_weight_kg_fright/$sale_contract_detail->ctn;

                      }else{

                          $caton_fright=0; 
                      }
                      $carton_fright_pl_rate=round($caton_fright+$sale_contract_detail->rate_per_ctn,3);
                      $total_sum=$total_sum+round($carton_fright_pl_rate*$sale_contract_detail->ctn,2);

                  }

              }catch (Exception $e) {
      
          
              }  
              
           }

          DB::table('sale_contracts')->where('id',$id)->update([
              'total_ci_value'=>$total_sum 
          ]);

      }

    }

   

    public function crmOrderReceive()
    {
        try {

            $results = DB::select("CALL PROC_CRM_ORDER_RECEIVE()");
            if (empty($results)) {
                return ['status' => 'error', 'message' => 'No data found'];
            }
            
            $payloadData = [];
            foreach ($results as $row) {
                $payloadData[] = [
                    'line_id'       => !empty($row->line_id) ? $row->line_id : 0,
                    'Contract_No'   => !empty($row->Contract_No) ? $row->Contract_No : '',
                    'Contract_Date' => !empty($row->Contract_Date) ? $row->Contract_Date : '',
                    'Invoice_No'    => !empty($row->Invoice_No) ? $row->Invoice_No : '',
                    'Invoice_Date'  => !empty($row->Invoice_Date) ? $row->Invoice_Date : '',
                    'Party_Code'    => !empty($row->Party_Code) ? $row->Party_Code : '',
                    'Party_Name'    => !empty($row->Party_Name) ? $row->Party_Name : '',
                    'Item_Code'     => !empty($row->Item_Code) ? $row->Item_Code : '',
                    'Item_Name'     => !empty($row->Item_Name) ? $row->Item_Name : '',
                    'ci_factor'     => !empty($row->ci_factor) ? $row->ci_factor : 0,
                    'SC_Qty'        => !empty($row->SC_Qty) ? $row->SC_Qty : '0',
                    'JO_Number'     => !empty($row->JO_Number) ? $row->JO_Number : '',
                    'JO_Qty'        => !empty($row->JO_Qty) ? $row->JO_Qty : '0',
                    'Rate'          => !empty($row->Rate) ? (float) $row->Rate : 0,
                    'Status'        => !empty($row->Status) ? $row->Status : '-',
                    'JO_Date'       => !empty($row->JO_Date) ? $row->JO_Date : '',
                    'JO_Creator'    => !empty($row->JO_Creator) ? $row->JO_Creator : '',
                    'SC_Creator'    => !empty($row->SC_Creator) ? $row->SC_Creator : ''
                ];
            }
            
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => 'https://crm.prangroup.com/api/job-orders/store',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_POSTFIELDS     => json_encode(count($payloadData) == 1 ? $payloadData[0] : $payloadData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                CURLOPT_HTTPHEADER     => [
                    'ss: order_list',
                    'yy: HJDyh876Yhdsf543GFOYSAL',
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Authorization: Basic YXV0aDoxMlByYW5AMTIzNDU2JA=='
                ],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            if (!empty($curlError)) {
                return ['status' => 'error', 'message' => 'CURL Error: ' . $curlError];
            }
            
            $decodedResponse = json_decode($response, true);
            if($httpCode == 200 || $httpCode == 201) {
                
                DB::table('crm_push_logs')->insert([
                    'push_status' => 'Y',
                    'push_date' => date('Y-m-d H:i:s'),
                    'push_message' => !empty($decodedResponse['message']) ? $decodedResponse['message'] : 'Data pushed successfully',
                    'push_total' => !empty($decodedResponse['total']) ? $decodedResponse['total'] : 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'action_type'=> 'received'
                ]);
              
            }
            
            DB::table('crm_push_logs')->insert([
                'push_status' => 'F',
                'push_date' => date('Y-m-d H:i:s'),
                'push_message' => 'API Error: HTTP ' . $httpCode,
                'push_total' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'action_type'=> 'received'
            ]);
            
            return [
                'status' => 'error',
                'message' => 'API Error: HTTP ' . $httpCode,
                'response' => $decodedResponse
            ];
            
        } catch (\Exception $e) {
            
            DB::table('crm_push_logs')->insert([
                'push_status' => 'F',
                'push_date' => date('Y-m-d H:i:s'),
                'push_message' => 'Exception: ' . $e->getMessage(),
                'push_total' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'action_type'=> 'received'
            ]);
            
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function crmOrderUpdateReceive()
    {
        try {

            $results = DB::select("CALL PROC_CRM_SYN_ORDER_UPDATE()");
            if (empty($results)) {
                return ['status' => 'error', 'message' => 'No data found'];
            }

            $payloadData = [];
            foreach ($results as $row) {
                $payloadData[] = [
                    'line_id'       => !empty($row->line_id) ? $row->line_id : 0,
                    'Contract_No'   => !empty($row->Contract_No) ? $row->Contract_No : '',
                    'Contract_Date' => !empty($row->Contract_Date) ? $row->Contract_Date : '',
                    'Invoice_No'    => !empty($row->Invoice_No) ? $row->Invoice_No : '',
                    'Invoice_Date'  => !empty($row->Invoice_Date) ? $row->Invoice_Date : '',
                    'Party_Code'    => !empty($row->Party_Code) ? $row->Party_Code : '',
                    'Party_Name'    => !empty($row->Party_Name) ? $row->Party_Name : '',
                    'Item_Code'     => !empty($row->Item_Code) ? $row->Item_Code : '',
                    'Item_Name'     => !empty($row->Item_Name) ? $row->Item_Name : '',
                    'ci_factor'     => !empty($row->ci_factor) ? $row->ci_factor : 0,
                    'SC_Qty'        => !empty($row->SC_Qty) ? $row->SC_Qty : '0',
                    'JO_Number'     => !empty($row->JO_Number) ? $row->JO_Number : '',
                    'JO_Qty'        => !empty($row->JO_Qty) ? $row->JO_Qty : '0',
                    'Rate'          => !empty($row->Rate) ? (float) $row->Rate : 0,
                    'Status'        => !empty($row->Status) ? $row->Status : '-',
                    'JO_Date'       => !empty($row->JO_Date) ? $row->JO_Date : '',
                    'JO_Creator'    => !empty($row->JO_Creator) ? $row->JO_Creator : '',
                    'SC_Creator'    => !empty($row->SC_Creator) ? $row->SC_Creator : ''
                ];
            }
            
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => 'https://crm.prangroup.com/api/job-orders/store',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_POSTFIELDS     => json_encode(count($payloadData) == 1 ? $payloadData[0] : $payloadData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                CURLOPT_HTTPHEADER     => [
                    'ss: order_list',
                    'yy: HJDyh876Yhdsf543GFOYSAL',
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Authorization: Basic YXV0aDoxMlByYW5AMTIzNDU2JA=='
                ],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            if (!empty($curlError)) {
                return ['status' => 'error', 'message' => 'CURL Error: ' . $curlError];
            }
            
            $decodedResponse = json_decode($response, true);
            if($httpCode == 200 || $httpCode == 201) {

                DB::table('crm_push_logs')->insert([
                    'push_status' => 'Y',
                    'push_date' => date('Y-m-d H:i:s'),
                    'push_message' => !empty($decodedResponse['message']) ? $decodedResponse['message'] : 'Data pushed successfully',
                    'push_total' => !empty($decodedResponse['total']) ? $decodedResponse['total'] : 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'action_type'=> 'updated'
                ]);

            }
        
            DB::table('crm_push_logs')->insert([
                'push_status' => 'F',
                'push_date' => date('Y-m-d H:i:s'),
                'push_message' => 'API Error: HTTP ' . $httpCode,
                'push_total' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'action_type'=> 'updated'
            ]);
            
            return [
                'status' => 'error',
                'message' => 'API Error: HTTP ' . $httpCode,
                'response' => $decodedResponse
            ];
            
        } catch (\Exception $e) {
            
            DB::table('crm_push_logs')->insert([
                'push_status' => 'F',
                'push_date' => date('Y-m-d H:i:s'),
                'push_message' => 'Exception: ' . $e->getMessage(),
                'push_total' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'action_type'=> 'updated'
            ]);
            
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

}
