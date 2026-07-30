<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use App\NotifyParty;
use App\NotifyPartyItem;
use App\FCustOrderMaster;
use App\FCustOrderDetails;
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
use App\CompanyBank;
use App\SaleContract;
use App\FCustScMaster;
use App\FCustScDetails;
use App\JobOrderMaster;
use App\JobOrderDetails;
use App\JObOrderNumber;
use App\JObOrderNumber2;
use App\Importer;
use App\TemplateDetail;
use App\SampleAttach;
use App\JOCopies;
use App\Role;
use \DateTime;
use Excel;
use App\CiItem;
use App\ScWiseJOList;
use App\TemporaryTable;
use App\FCustJoMaster;
use App\FCustJodetails;
use App\FcustScJOList;
use App\FCastTNABoard;
use App\Company;
use Auth;
use DB;
use Session;
class ForecastOrderController extends Controller
{

     
    public function __construct(){

        $this->middleware('auth');
 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
       
        $importers=Importer::orderBy('id','ASC')->get();               
        return view('forecast.create')
               ->with('importers',$importers);

    }

    public function getOrders(Request $request){
         
        $results=DB::select("SELECT
                fcust_demand_master.ID                                     as id,
                fcust_demand_master.PO_NO                                  as po_no,
                date_format(fcust_demand_master.PO_DATE, '%d-%m-%Y')       as po_date,
                date_format(fcust_demand_master.DELIVERY_DATE, '%d-%m-%Y') as delivery_date,
                fcust_demand_master.ORDER_NUMBER                           as order_number,
                CASE WHEN fcust_demand_master.APPROVED_STATUS = 'N'
                    THEN 'Not Approved'
                ELSE 'Approved' END                                        as status
            FROM fcust_demand_master
            JOIN fcust_demand_details on fcust_demand_details.master_id = fcust_demand_master.ID
            where fcust_demand_details.party_id=75273 AND fcust_demand_master.ORDER_STATUS='Y'
            GROUP BY fcust_demand_master.ID, fcust_demand_master.PO_NO,
            fcust_demand_master.DELIVERY_DATE, fcust_demand_master.ORDER_NUMBER
            ORDER BY fcust_demand_master.ID DESC");
        
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

    public function approveFcustOrder(Request $request)
    {

        // DB::beginTransaction();
        // try {

            $poId = $request->po_id;
            $poMaster = FCustOrderMaster::where('fcust_demand_master.id', $poId)
                ->join('fcust_demand_details', 'fcust_demand_master.id', '=', 'fcust_demand_details.master_id')
                ->first([
                    'fcust_demand_master.ID',
                    'fcust_demand_master.PO_NO',
                    'fcust_demand_master.IUID',
                    'fcust_demand_master.CREATE_DATE',
                    'fcust_demand_details.PARTY_ID'
                ]);

            $results = DB::table('fcust_demand_details')
                ->join('ci_items', 'ci_items.id', '=', 'fcust_demand_details.item_id')
                ->join('companies', 'companies.id', '=', 'ci_items.bu_id')
                ->select('fcust_demand_details.*', 'companies.factory_name as op')
                ->where('master_id', $poId)
                ->get();

            return $joNo = $this->autoTransectionWithoutSelection($poMaster, $results, $request);
            // POMaster::where('id', $poId)->update([
            //     'APPROVED_STATUS' => 'Y',
            //     'ORDER_NUMBER' => $joNo
            // ]);

            DB::commit();
            return response()->json([
                'status' => 'Success',
                'jo_no'  => $joNo
            ], 200);

        // } catch (\Exception $e) {

        //     DB::rollBack();
        //     return response()->json([
        //         'status' => 'Error',
        //         'message' => $e->getMessage()
        //     ], 500);

        // }
    }

    public function autoTransectionWithoutSelection($po_master, $results, $request){

        $sales_contract_id=$this->createSalesContract($po_master,$results,$request);
        return $jo_no=$this->createJobOrder($po_master->ID,$sales_contract_id,$results);

    }

    private function createSalesContract($po_master,$results,$request){

        $id = 4560;
        $sc_invoice_no = $this->generateInvoiceNumber($po_master->ID);
        $sale_contract_prev = SaleContract::find($id);
        $sale_contract = new FCustScMaster();
        $sale_contract->sales_contract_no=$sc_invoice_no;
        $sale_contract->dated=date("Y-m-d",strtotime($sale_contract_prev->dated));
        $sale_contract->invoice_no=$sc_invoice_no;
        $sale_contract->ad_code=$sale_contract_prev->ad_code;
        $sale_contract->ci_note=$sale_contract_prev->ci_note;
        $sale_contract->discharge_port=$sale_contract_prev->discharge_port;
        $sale_contract->country_id=$sale_contract_prev->country_id;
        $sale_contract->sales_term_id=$sale_contract_prev->sales_term_id;
        $sale_contract->company_id=$sale_contract_prev->company_id;
        $sale_contract->bank_id=$sale_contract_prev->bank_id;
        $sale_contract->account_number=$sale_contract_prev->account_number;
        $sale_contract->bank_importer_id=$sale_contract_prev->bank_importer_id;
        $sale_contract->carrying_mode_id=$sale_contract_prev->carrying_mode_id;
        $sale_contract->loading_place_id=$sale_contract_prev->loading_place_id;
        $sale_contract->final_destination=$sale_contract_prev->final_destination;
        $sale_contract->creator_id = Auth::user()->id;
        $sale_contract->terms_and_condition = $sale_contract_prev->terms_and_condition;
        $sale_contract->terms_and_condition_desk_inv = $sale_contract_prev->terms_and_condition_desk_inv;
        $sale_contract->freight_cost = $sale_contract_prev->freight_cost;
        $sale_contract->container=$sale_contract_prev->container;
        $sale_contract->container_1=$sale_contract_prev->container_1;
        $sale_contract->container_2=$sale_contract_prev->container_2;
        $sale_contract->container_3=$sale_contract_prev->container_3;
        $sale_contract->freight_cost_1 = $sale_contract_prev->freight_cost_1;
        $sale_contract->freight_cost_2 = $sale_contract_prev->freight_cost_2;
        $sale_contract->freight_cost_3 = $sale_contract_prev->freight_cost_3;
        $sale_contract->freight_cost = $sale_contract_prev->freight_cost;
        $sale_contract->importer_country  = $sale_contract_prev->importer_country ;
        $sale_contract->angikar_given_by  = $sale_contract_prev->angikar_given_by ;
        $sale_contract->po_master_id  = $po_master->ID;
        $sale_contract->po_number  = $po_master->PO_NO;
        $sale_contract->approver_id = null;
        $sale_contract->approved_at = null;
        $sale_contract->save();

        foreach($results as $value){

            $sale_contract_detail                                   = new FCustScDetails();
            $sale_contract_detail->importer_id                      = $value->party_id;
            $sale_contract_detail->party_id                         = $value->party_id;
            $sale_contract_detail->ci_item_id                       = $value->item_id;
            $sale_contract_detail->sale_contract_id                 = $sale_contract->id;
            $sale_contract_detail->rate_per_ctn_for_party           = 0;
            $sale_contract_detail->rate_per_ctn_for_acc             = 0;
            $sale_contract_detail->ctn                              = 0;
            $sale_contract_detail->rate_per_ctn                     = $value->factor*$value->acct_rate_per_piece;
            $sale_contract_detail->do_unit                          = $value->order_qty;
            $sale_contract_detail->pcs_in_ctn                       = $value->order_qty;
            $sale_contract_detail->total_amount                     = $value->order_qty*$value->acct_rate_per_piece;
            $sale_contract_detail->total_amount_party               = $value->order_qty*$value->acct_rate_per_piece;
            $sale_contract_detail->total_amount_acc                 = $value->order_qty*$value->acct_rate_per_piece;
            $sale_contract_detail->net_weight_kg                    = $value->net_weight_per_piece;
            $sale_contract_detail->gross_weight_kg                  = $value->gross_weight_per_piece;
            $sale_contract_detail->desk_item_name                   = $value->item_name;
            $sale_contract_detail->hs_code                          = $value->hs_code;
            $sale_contract_detail->ref_code                         = $value->ref_code;
            $sale_contract_detail->factor                           = $value->factor;
            $sale_contract_detail->l                                = 0; 
            $sale_contract_detail->h                                = 0;
            $sale_contract_detail->w                                = 0;
            $sale_contract_detail->stack                            = 0;
            $sale_contract_detail->total_cbm                        = $value->total_cbm;
            $sale_contract_detail->l2                               = 0; 
            $sale_contract_detail->h2                               = 0;
            $sale_contract_detail->w2                               = 0;    
            $sale_contract_detail->cbm                              = 0;  
            $sale_contract_detail->rate_per_ctn                     = 0;
            $sale_contract_detail->is_eligible                      = 0;
            $sale_contract_detail->bapa_percent                     = 0;
            $sale_contract_detail->claim_amount                     = 0;
            $sale_contract_detail->bu_id                            = 0;
            $sale_contract_detail->cbm_per_ctn                      = 0;
            $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm   = 0;
            $sale_contract_detail->per_ctn_freight                  = 0;
            $sale_contract_detail->ci_rate_pl_freight               = 0;
            $sale_contract_detail->net_weight_per_pcs               = 0;
            $sale_contract_detail->gross_weight_per_pcs             = 0;
            $sale_contract_detail->ccq                              = 0;
            $sale_contract_detail->ci_item_name                     = NULL; 
            $sale_contract_detail->hs_code_2                        = null;
            $sale_contract_detail->description_id                   = NULL;
            $sale_contract_detail->smqt                             = $value->sample_qty_pcs;
            $sale_contract_detail->depo                             = 0;
            $sale_contract_detail ->save();
        }

        $saleContract = FCustScMaster::where('fcust_sc_master.id', $sale_contract->id)
            ->join('fcust_sc_details', 'fcust_sc_master.id', '=', 'fcust_sc_details.sale_contract_id')
            ->first([
                'fcust_sc_master.id',
                'fcust_sc_master.po_master_id',
                'fcust_sc_master.creator_id',
                'fcust_sc_master.invoice_no',
                'fcust_sc_master.created_at',
                'fcust_sc_master.invoice_no',
                'fcust_sc_details.importer_id'
            ]);
        
        $user=User::where('id',$saleContract->creator_id)->first(['username','name']);
        $po_master=FCustOrderMaster::where('id',$po_master->ID)->first(['ID','TEMPLATE_ID','PO_NO','CREATE_DATE']);
        $po_details=DB::select("select
                task_definition.DESCRIPTION as description,
                po_details.TASK_ID          as task_id,
                po_details.FROM_DATE        as from_date,
                task_definition.USER_TYPE   as user_type,
                po_details.TO_DATE          as to_date
            from po_details
            join task_definition on task_definition.ID = po_details.TASK_ID
            where po_details.MASTER_ID = $po_master->ID");

        foreach($po_details as $key => $value){
        
            $seaPortdashboard=new FCastTNABoard();
            $seaPortdashboard->sc_id=$saleContract->id;
            $seaPortdashboard->party_id=$saleContract->importer_id;
            $seaPortdashboard->Task_ID=$value->task_id;
            if($value->task_id==1){

                $seaPortdashboard->action_date=date("Y-m-d", strtotime($po_master->CREATE_DATE));
            }

            if($value->task_id==2){
                
                $seaPortdashboard->action_date=date("Y-m-d", strtotime($saleContract->created_at));;
            }

            if($value->task_id==3){
                
                $seaPortdashboard->action_date=date("Y-m-d");
            }
            
            $seaPortdashboard->buyer=NotifyParty::where('id',$saleContract->importer_id)->value('ref_name');
            $seaPortdashboard->inv_no=$saleContract->invoice_no;
            $seaPortdashboard->res_by=Role::where('id',$value->user_type)->value('name');
            $seaPortdashboard->inactive='N';
            $seaPortdashboard->task_name=$value->description;
            $seaPortdashboard->po_no=$po_master->PO_NO;
            $seaPortdashboard->po_id=$po_master->ID;
            $seaPortdashboard->po_date=date("Y-m-d", strtotime($po_master->CREATE_DATE));
            $seaPortdashboard->from_date=$value->from_date;
            $seaPortdashboard->to_date=$value->to_date;
            $seaPortdashboard->sc_no=$saleContract->invoice_no;
            $seaPortdashboard->sc_date=date("Y-m-d", strtotime($saleContract->created_at));
            $seaPortdashboard->user=$user->username.'-'.$user->name;
            $seaPortdashboard->user_id=$saleContract->creator_id;
            $seaPortdashboard->insert_date=date('Y-m-d');
            $seaPortdashboard->save(); 

        } 

        return $sale_contract->id;

    }

    public function createJobOrder($po_id,$sale_contract_id,$results){
       
        $sale_contract=FCustScMaster::where('id',$sale_contract_id)->first(['sales_contract_no']);
        $jobOrderMaster=new FCustJoMaster();
        $jobOrderMaster->sale_contract_id=$sale_contract_id;
        $jobOrderMaster->shipping_mask="RFL";
        $jobOrderMaster->note=$sale_contract->sales_contract_no;
        $jobOrderMaster->issue_date=date('Y-m-d');
        $jobOrderMaster->delivery_date=FCustOrderMaster::where('id',$po_id)->value('DELIVERY_DATE');
        $jo_num=$this->generateFcstOrderNumber();
        $jobOrderMaster->job_order_number=$jo_num; 
        $jobOrderMaster->job_order_number2=$jo_num;           
        $jobOrderMaster->best_before=0;
        $jobOrderMaster->user_id=Auth::user()->id;
        $jobOrderMaster->status=1;
        $jobOrderMaster->owner_type='Export';
        $jobOrderMaster->job_type='Forecast';
        $jobOrderMaster->save();

        foreach($results as $key => $value) {
                
            $jobOrderDetails=new FCustJodetails();
            $jobOrderDetails->master_id=$jobOrderMaster->id;
            $jobOrderDetails->importer_id=$value->party_id;
            $jobOrderDetails->item_id=$value->item_id;  
            $jobOrderDetails->factor=$value->factor;
            $jobOrderDetails->qty=$value->order_qty_ctn;
            $jobOrderDetails->du_unit=2;
            $jobOrderDetails->ru_unit=2;
            $jobOrderDetails->orqt=$value->order_qty;
            $jobOrderDetails->sale_contact_qty=$value->order_qty;
            $jobOrderDetails->smqt=$value->sample_qty_pcs;
            $jobOrderDetails->rate=$value->rate_per_ctn;
            $jobOrderDetails->update_by=Auth::user()->id;
            $jobOrderDetails->version=1;
            $jobOrderDetails->save();  

        }      

        $scWiseJOList=new FcustScJOList();
        $scWiseJOList->sc_id=$sale_contract_id;
        $scWiseJOList->po_id=FCustScMaster::where('id',$sale_contract_id)->value('po_master_id');
        $scWiseJOList->jo_id=$jobOrderMaster->id;
        $scWiseJOList->jo_no=$jo_num;
        $scWiseJOList->save(); 
        // $this->sendGroupEmail($jobOrderMaster->id);
        return $jo_num;

    }

    public function generateInvoiceNumber($buyerId){
   
        $year = date('Y');
        $yearShort = date('y');
        $buyer = DB::table('importers')->where('id', $buyerId)->first();
        if (!$buyer) {
            throw new Exception("Buyer not found");
        }
        $shortName = $buyer->ref_name;
        $sequence = DB::table('buyer_invoice_sequences')
            ->where('buyer_id', $buyerId)
            ->where('year', $year)
            ->first();

        if($sequence){
            
            $uniqueNumber = $sequence->last_number + 1;
            DB::table('buyer_invoice_sequences')
                ->where('id', $sequence->id)
                ->update(['last_number' => $uniqueNumber]);
        }else{
        
            $uniqueNumber = 1;
            DB::table('buyer_invoice_sequences')->insert([
                'buyer_id' => $buyerId,
                'year' => $year,
                'last_number' => $uniqueNumber
            ]);
        }

        $invoiceNumber = $shortName . '/' . str_pad($uniqueNumber, 2, '0', STR_PAD_LEFT) . '/' . $yearShort;
        return $invoiceNumber;

    }

    public function inactivePO(Request $request){

        $result=POMaster::where('id',$request->id)->update([
          'ORDER_STATUS'=>'N',
          'STATUS'=>0
        ]);

        if($result){
            return response()->json([
                'code' => 200,
                'message' => 'Cancel Done..!!'
            ]);
        }

    }

    private function sendGroupEmail($jo_id){

        $jo_info = JobOrderMaster::where('id',$jo_id)->first();  
        $categorizedData = [];
        $itemInfo = DB::table('job_order_details')
                ->join('ci_items', 'ci_items.id', '=', 'job_order_details.item_id')
                ->select(
                    'job_order_details.op',
                    'ci_items.ci_item_code as item_code',
                    'ci_items.ci_item_name as item_name',
                    'ci_items.factor as factor',
                    'job_order_details.orqt as orqt',
                    'job_order_details.smqt as smqt',
                    'job_order_details.rate as rate',
                    DB::raw('(job_order_details.orqt * job_order_details.rate) as total_val'))
                ->where('job_order_details.master_id', $jo_id)
                ->get();

        foreach($itemInfo as $item) {
            if(isset($item->op)){
                $op = $item->op; 
                if(!isset($categorizedData[$op])) {
                    $categorizedData[$op] = [];
                }
                $categorizedData[$op][] = $item;
            }
        }

        $opNamesToSendEmail = array_keys($categorizedData);
        foreach($categorizedData as $groupName => $values) {

            if(count($values)>0){

                $mail_list = DB::table('op_mail_setup')
                    ->join('users', 'users.id', '=', 'op_mail_setup.user_id')
                    ->where('op_mail_setup.op', $groupName)
                    ->where('op_mail_setup.status', 'N')
                    ->pluck('email')
                    ->toArray();

                $opfiles=SampleAttach::where('jo_id', $jo_id)->where('op', $op)->get();
                if(count($mail_list)>0){

                    $user = User::where('id', Auth::user()->id)->first(['name', 'username', 'email']);
                    $importer = Importer::where('id', $jo_info->importer_id)->first(['name', 'code']);
                    $sale_contract = SaleContract::where('id', $jo_info->sale_contract_id)->first(['invoice_no', 'sales_contract_no', 'po_number']);
                    $joFiles=JOCopies::where('jo_id',$jo_id)->get();
                    $data = array(
                        'items' => $itemInfo,
                        'importer' => $importer,
                        'email_array' => $mail_list,
                        'user' => $user,
                        'subject' => "New JO Notification ,".' Invoice: '.$sale_contract->invoice_no,
                        'sale_contract' => $sale_contract,
                        'issue_date' => $jo_info->issue_date,
                        'delivery_date' => $jo_info->delivery_date,
                        'jo' =>  $jo_info->job_order_number2,
                        'cc' => $user->email,
                        'joFiles' =>$joFiles
                    );
            
                    $from_mail = env('MAIL_FROM_ADDRESS');
                   try {

                        Mail::send('mail.job_order_mail', $data, function($message) use ($from_mail, $data) {
                            $message->from($from_mail, 'Job-Order-Mail@rflgroupbd.com');
                            $message->to($data['email_array']);
                            $message->subject($data['subject']);
                        });
                        return response()->json(['message' => 'Email sent successfully!']);

                    } catch (\Exception $e) {

                        return response()->json(['error' => 'Email failed to send. Error: ' . $e->getMessage()]);

                    }
               
                }      
                
            }
        }

    }

    private function sendingCosterNotificationMail($jo_id){

        $itemInfo = DB::select("
            SELECT
                ci_items.id as item_id,
                ci_items.ci_item_code as code,
                ci_items.ci_item_name as name,
                job_order_details.qty as ctn,
                job_order_details.orqt as orqt,
                job_order_details.smqt as smqt,
                job_order_details.rate as rate,
                job_order_details.factor,
                companies.factory_name as com
            FROM job_order_masters
            JOIN job_order_details ON job_order_details.master_id = job_order_masters.id
            JOIN ci_items ON ci_items.id = job_order_details.item_id
            JOIN companies ON companies.id = ci_items.bu_id
            WHERE job_order_masters.id = '$jo_id' AND job_order_details.item_status = 'Y' AND job_order_details.mail_status IS NULL
            ORDER BY companies.name");
        $itemsComData = [];
        foreach($itemInfo as $item) {
            
            if(isset($item->com)) {

                $com = $item->com;
                if (!isset($itemsComData[$com])) {

                    $itemsComData[$com] = [];
                }
                $itemsComData[$com][] = $item;
            }
        }

        $opNamesToSendEmail = array_keys($itemsComData);
        foreach($itemsComData as $comName => $items) {
            
            $itemIds = array_map(function($item) {
                return $item->item_id;
            }, $items);

            if(count($items)>0){
                
                //@@@@@-Update Item Status 
                JobOrderDetails::where('master_id',$jo_id)->whereIn('item_id',$itemIds)->update([
                    'mail_status'=>'Y',
                    'mail_by'=>Auth::user()->id,
                    'mail_date'=>date('Y-m-d H:i:s')
                ]);

                $email_array = DB::table('coster_mail_list')
                    ->join('users', 'users.id', '=', 'coster_mail_list.user_id')
                    ->where('coster_mail_list.status', 'N')
                    ->where('coster_mail_list.com',$comName)
                    ->pluck('email')
                    ->toArray();
                    
                // $email_array=array('mis94@mis.prangroup.com');
                if(count($email_array) > 0){

                    $user = User::where('id', Auth::user()->id)->first(['name', 'username', 'email']);
                    $importer = Importer::where('id', JobOrderMaster::where('id', $jo_id)->value('importer_id'))->first(['name', 'code']);
                    $sale_contract = SaleContract::where('id', JobOrderMaster::where('id', $jo_id)->value('sale_contract_id'))->first(['invoice_no','sales_contract_no']);
                    $job_order=JobOrderMaster::where('id',$jo_id)->first(['job_order_number','issue_date','delivery_date']);
                    $files=SampleAttach::where('jo_id',$jo_id)->get();
                    $data = [
                        'items' => $items,
                        'importer' => $importer,
                        'email_array' => $email_array,
                        'user' => $user,
                        'subject' => "Costar Approval ,".' Invoice: '.$sale_contract->invoice_no,
                        'sale_contract' => $sale_contract,
                        'job_order' => $job_order,
                        'cc_mail'=>$user->email,
                        'files'=>$files
                    ];

                    $from_mail = env('MAIL_FROM_ADDRESS');
                    Mail::send('mail.cost_approval_template', $data, function($message) use ($from_mail, $data) {
                        $message->from($from_mail, 'Cost-Approval-Notification@rflgroupbd.com');
                        $message->to('mis94@mis.prangroup.com');
                        // $message->to($data['email_array']);
                        // $message->cc($data['cc_mail']);
                        $message->subject($data['subject']);
                    });

                }

            }

        }
        
        return 'success';

    }

    private function uploadOderSheet($request,$jo_id,$jo_num){

        $filesUploaded = false;
        if($request->hasFile('order_sheet_ref')){

            foreach ($request->file('order_sheet_ref') as $file) {

                $filePath = $file->getRealPath();
                $fileName = $file->getClientOriginalName();
                $cFile = new \CURLFile($filePath, $file->getClientMimeType(), $fileName);
                $cFile->setPostFilename($fileName); // Set filename for cURL
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    // CURLOPT_URL => 'http://rqc.rflgroupbd.com:8016/jo_file/upload', // Endpoint URL
                    CURLOPT_URL => 'http://localhost:8082/jo_file/upload', // Endpoint URL
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                        'file' => $cFile
                    ),
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: multipart/form-data'
                    ),
                ));

                $response = curl_exec($curl);
                $responseData = json_decode($response, true);
                $status = $responseData['status'];
                if($status==200){
                    
                    $joCopy=new JOCopies();
                    $joCopy->jo_id=$jo_id;
                    $joCopy->jo_number=$jo_num;
                    $joCopy->file_name=$responseData['file_path'];
                    $joCopy->iuser=Auth::user()->id;
                    $joCopy->save();
                    $filesUploaded = true;

                }
                $error = curl_error($curl);
                curl_close($curl);
                
            }
            
        }else{

            return 'No File';
        }

    }

    private function uploadSampleFile($request,$jo_id){
       
        $filesUploaded = false;
        if($request->hasFile('approval_copy')){

            foreach($request->file('approval_copy') as $file){

                $filePath = $file->getRealPath();
                $fileName = $file->getClientOriginalName();;
                $cFile = new \CURLFile($filePath, $file->getClientMimeType(), $fileName);
                $cFile->setPostFilename($fileName); // Set filename for cURL
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://rqc.rflgroupbd.com:8016/smpl_attach/upload', // Endpoint URL
                    // CURLOPT_URL => 'http://localhost:8082/smpl_attach/upload', // Endpoint URL
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                        'file' => $cFile
                    ),
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: multipart/form-data'
                    ),
                ));        

                // Execute cURL and get response
                $response = curl_exec($curl);
                $responseData = json_decode($response, true);
                if(isset($responseData['status']) && $responseData['status'] == 200) {

                    // $existingFile = SampleAttach::where('jo_id', $jo_id)
                    //     ->where('file_path', $responseData['file_path'])
                    //     ->where('op', $op)
                    //     ->first();
        
                    // // Save only if no duplicate is found
                    // if(!$existingFile){
                        $sampleAttach = new SampleAttach();
                        $sampleAttach->jo_id = $jo_id;
                        // $sampleAttach->item_id = CiItem::where('ci_item_code',$itemCode)->value('id');
                        $sampleAttach->op = 'OP';
                        $sampleAttach->file_path = $responseData['file_path'];
                        $sampleAttach->iuser = Auth::user()->id;
                        $sampleAttach->save();
                    // }

                }

            }

        }else{

            return 'No File';

        }

    }

    public function jobOrderItemVerify($results,$master_id){ 

        $data_array = array();
        foreach($results as $result){ 

            $data_array[] = array('itemID' => CiItem::where('id', $result->item_id)->value('ci_item_code'));

        }
    
        $item_array = array();
        $item_array['staffId'] = Auth::user()->username;
        $item_array['itemList'] = $data_array;
        $itemsArray = json_encode($item_array);
        $curl = curl_init();
        try {

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://172.17.8.97:8616/api/Items/ItemsCheck',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $itemsArray,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Basic YXV0aGRvOjEyUHJhbkBhdXRoZG8k'
                ),
            ));

            $response = curl_exec($curl);
            $data = json_decode($response, true);
            if(is_array($data) && !empty($data)) {
                foreach($data as $key => $value) {

                        JobOrderDetails::where('master_id', $master_id)
                        ->where('item_id', CiItem::where('ci_item_code', $value['ITEM_ID'])->value('id'))
                        ->update([
                            'verify_status' => $value['ITEM_INACTIVE']
                        ]);

                }
                // Return the data as an array
                return response()->json($data, 200);

            } else {
                // Return an empty array if the response is not valid
                return response()->json([], 200);
            }
        } catch (Exception $e) {
            // Handle any errors
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);

        } finally {

            curl_close($curl);

        }
    
  
    }

    public function sendReportByEmail($po_id,$sale_contract_id,$party_id,$jo_id,$items,$filePath)
    {
        $sale_contract=SaleContract::where('id',$sale_contract_id)->first(['sales_contract_no']);
        $notify_party=NotifyParty::where('id',$party_id)->first(['name','code']);
        $po_master=POMaster::where('id',$po_id)->first(['PO_NO','DELIVERY_DATE','INSPECTION_DATE']); 
        $jo_order=JobOrderMaster::where('id',$jo_id)->first(['job_order_number']);
        $user=User::where('id',Auth::user()->id)->first(['name','email']);
        $from_mail = env('MAIL_FROM_ADDRESS');
        //$receiver_email=array('mis94@mis.prangroup.com','export198@rflgroupbd.com');
        // $receiver_email = DB::table('op_mail_setup')
        //             ->where('op','DPL')
        //             ->pluck('email')
        //             ->toArray();
        $receiver_email=array('mis94@mis.prangroup.com');
        $data = [
            'receiver_email' =>  $receiver_email, 
            'subject' => 'New JO Create Notification Mail',
            'notify_party'=>$notify_party,
            'po_master'=>$po_master,
            'sale_contract'=>$sale_contract,
            'order'=>$jo_order,
            'items'=>$items,
            'user'=>$user,
            'cc'=>$user->email
        ];

        Mail::send('std_order_mail_template', $data, function($message) use ($from_mail,$data, $filePath) {   // Attach the file
            $message->from($from_mail, 'Job-Order-Mail@rflgroupbd.com'); 
            $message->to($data['receiver_email']);
            $message->cc($data['cc']);
            $message->subject($data['subject']);
            $message->attach($filePath); 
        });

    }   

    function generateFcstOrderNumber()
    {
        $year = date('Y');      
        $yearShort = date('y'); 
        $sequence = DB::table('fcust_order_sequences')
            ->where('year', $year)
            ->first();

        if ($sequence) {
            
            $uniqueNumber = $sequence->last_number + 1;
            DB::table('fcust_order_sequences')
                ->where('id', $sequence->id)
                ->update(['last_number' => $uniqueNumber]);
        } else {
            
            $uniqueNumber = 1;
            DB::table('fcust_order_sequences')->insert([
                'year' => $year,
                'last_number' => $uniqueNumber
            ]);
        }
        $orderNumber = 'Forecast-' . str_pad($uniqueNumber, 2, '0', STR_PAD_LEFT) . '-' . $yearShort;
        return $orderNumber;
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

        
        $importers=Importer::orderBy('id','ASC')->get();               
        return view('sale_contract.po.create')
               ->with('importers',$importers);

        // $dcLists = PortDetails::orderBy('id','ASC')->get();
        // $importers=Importer::orderBy('id','ASC')->get();
        // return view('docket_entry.index')
        //       ->with('dcLists',$dcLists)
        //       ->with('importers',$importers);       
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->all();
        if($request->btnType=="Create"){

            $FCustOrderMaster=new FCustOrderMaster();
            $FCustOrderMaster->CREATE_DATE=date("Y-m-d");
            $FCustOrderMaster->REMARK='Manually Created';
            $FCustOrderMaster->PO_DATE=DateTime::createFromFormat('d/m/Y',$request->create_date)->format('Y-m-d');
            $FCustOrderMaster->ORDER_QTY=0;
            $FCustOrderMaster->ORDER_STATUS='Y';
            $FCustOrderMaster->TEMPLATE_ID=$this->getTemplateId($request);
            $FCustOrderMaster->DELIVERY_DATE=DateTime::createFromFormat('d/m/Y',$request->delivery_date)->format('Y-m-d');
            $FCustOrderMaster->INSPECTION_DATE=DateTime::createFromFormat('d/m/Y',$request->inspection_date)->format('Y-m-d');
            $FCustOrderMaster->IUID=Auth::user()->id;
            $FCustOrderMaster->EUID=Auth::user()->id;
            $FCustOrderMaster->save();
            $po_number = 'PO'.date('mY').str_pad($FCustOrderMaster->id, 6, "0", STR_PAD_LEFT);
            $FCustOrderMaster->PO_NO=$po_number;
            $FCustOrderMaster->BUYER_PO=$request->ref_po_no ? $request->ref_po_no : $po_number;
            $FCustOrderMaster->save();
            $this->uploadPOAttachment($request,$po_number,$FCustOrderMaster->id); ///@@@@@--PO Attachment Function 
            $itemArray = json_decode($request->input('itemDetails'), true);
            $itemArray = array_filter($itemArray, function($item) {
                return !empty($item['item_code']);
            });
            $itemArray = array_values($itemArray);
            foreach($itemArray as $item) {
               
                $ci_item=CiItem::where('ci_item_code',(int)$item['item_code'])->first(['id']);
                if(NotifyPartyItem::where('notify_party_id',$request->buyer_id)->where('ci_item_id',$ci_item->id)->exists()){
                    $notifyPartyItem=NotifyPartyItem::where('notify_party_id',$request->buyer_id)->where('ci_item_id',$ci_item->id)->first(['factor','cbm_per_ctn','clint_fg_code','acc_rate']);
                }

                $FCustOrderDetails=new FCustOrderDetails();
                $FCustOrderDetails->master_id=$FCustOrderMaster->id;
                $FCustOrderDetails->party_id=$request->buyer_id;
                $FCustOrderDetails->item_id=$ci_item->id;
                $FCustOrderDetails->item_name=$item['name'];
                $FCustOrderDetails->do_unit=$item['do_unit'] ? $item['do_unit'] : $item['total_unit'];
                $FCustOrderDetails->order_qty=$item['total_unit'];
                $FCustOrderDetails->sample_qty_pcs=$item['smqt'];
                $FCustOrderDetails->net_weight_per_piece=$item['net_weight_per_unit'] ? $item['net_weight_per_unit'] : 0;
                $FCustOrderDetails->gross_weight_per_piece=$item['gross_weight_per_unit'] ? $item['gross_weight_per_unit'] : 0;
                $FCustOrderDetails->unit_per_ctn=$item['unit_per_ctn'] ? $item['unit_per_ctn'] : 0;
                $FCustOrderDetails->acct_rate_per_piece=$item['rate_per_ctn_for_acc'] ? $item['rate_per_ctn_for_acc'] : 0;
                $FCustOrderDetails->party_rate_per_piece=$item['rate_per_ctn_for_party'] ? $item['rate_per_ctn_for_party'] : 0;
                $FCustOrderDetails->ci_rate_per_piece=$item['rate_per_ctn_for_party'] ? $item['rate_per_ctn_for_party'] : 0;
                $FCustOrderDetails->l=$item['l'] ? $item['l'] :0;
                $FCustOrderDetails->w=$item['w'] ? $item['w'] :0;
                $FCustOrderDetails->h=$item['h'] ? $item['h'] : 0;
                $FCustOrderDetails->stack=$item['stack'] ? $item['stack'] : 0;
                $FCustOrderDetails->total_cbm=$item['tcbm'] ? $item['tcbm'] : 0;
                $FCustOrderDetails->l2=$item['l2'] ? $item['l2'] : 0;
                $FCustOrderDetails->w2=$item['w2'] ? $item['w2'] : 0;
                $FCustOrderDetails->h2=$item['h2'] ? $item['h2'] : 0;
                $FCustOrderDetails->cbm=$item['cbm'] ? $item['cbm'] : 0;
                $FCustOrderDetails->description_id=$item['description_id'] ? $item['description_id'] : 0;
                $FCustOrderDetails->depo=$item['depo'] ? $item['depo'] : 0;
                $FCustOrderDetails->total_ctn=$item['total_ctn'];
                // ----------------------------

                $FCustOrderDetails->factor=$item['unit_per_ctn'] ? $item['unit_per_ctn'] : 0;
                $FCustOrderDetails->rate_per_ctn=$item['rate_per_ctn'] ? $item['rate_per_ctn']: 0;
                $FCustOrderDetails->order_qty_ctn=$item['total_ctn'];
                $FCustOrderDetails->sc_qty_ctn=$item['do_unit'] ? $item['do_unit'] : $item['total_unit'];
                $FCustOrderDetails->cbm_per_ctn=$item['cbm'] ? $item['cbm'] : 0;
                $FCustOrderDetails->ref_code=$item['ref_code'] ? $item['ref_code'] : 0;
                $FCustOrderDetails->hs_code=$item['hs_code'] ? $item['hs_code'] : 0;
                $FCustOrderDetails->specifition='no';
                $FCustOrderDetails->user_id=Auth::user()->id;
                $FCustOrderDetails->save(); 
            }

            $templateDetails=TemplateDetail::where('MASTER_ID',14)->orderBy('ID','ASC')->get();
            foreach($templateDetails as $templateDetail){

                $PODetails=new PODetails();
                $PODetails->MASTER_ID=$FCustOrderMaster->id;
                $PODetails->TASK_ID=$templateDetail->TASK_ID;
                $PODetails->STD=0;
                $PODetails->FROM_DATE=date('Y-m-d');
                $PODetails->TO_DATE=date('Y-m-d');
                $PODetails->save();  
            }

            return response()->json([
                'code'=>200,
                'message'=>"Successfully Created..!!"
            ]);

        }

        if($request->btnType=="Update"){
            //Update PO Header Information 
            FCustOrderMaster::where('id', $request->poId)->update([
                'PO_DATE'         => Carbon::createFromFormat('d/m/Y', $request->create_date)->format('Y-m-d'),
                'DELIVERY_DATE'   => Carbon::createFromFormat('d/m/Y', $request->delivery_date)->format('Y-m-d'),
                'INSPECTION_DATE' => Carbon::createFromFormat('d/m/Y', $request->inspection_date)->format('Y-m-d'),
                'BUYER_PO'        => $request->ref_po_no
            ]);
            $itemArray = json_decode($request->input('itemDetails'), true);
            $itemArray = array_filter($itemArray, function($item) {
                return !empty($item['item_code']);
            });
            $itemArray = array_values($itemArray);
            foreach($itemArray as $item) {

                $ci_item=CiItem::where('ci_item_code',(int)$item['item_code'])->first(['id']);
                if(FCustOrderDetails::where('master_id',$request->poId)->where('item_id',$ci_item->id)->count()>0){

                    FCustOrderDetails::where('master_id',$request->poId)->where('item_id',$ci_item->id)->update([
                        'item_name'=>$item['name'],
                        'do_unit'=>$item['do_unit'] ? $item['do_unit'] : $item['total_unit'],
                        'order_qty'=>$item['total_unit'],
                        'sample_qty_pcs'=>$item['smqt'],
                        'net_weight_per_piece'=>$item['net_weight_per_unit'] ? $item['net_weight_per_unit'] : 0,
                        'gross_weight_per_piece'=>$item['gross_weight_per_unit'] ? $item['gross_weight_per_unit'] : 0,
                        'unit_per_ctn'=>$item['unit_per_ctn'] ? $item['unit_per_ctn'] : 0,
                        'acct_rate_per_piece'=>$item['rate_per_ctn_for_acc'] ? $item['rate_per_ctn_for_acc'] : 0,
                        'party_rate_per_piece'=>$item['rate_per_ctn_for_party'] ? $item['rate_per_ctn_for_party'] : 0,
                        'ci_rate_per_piece'=>$item['rate_per_ctn_for_party'] ? $item['rate_per_ctn_for_party'] : 0,
                        'l'=>$item['l'] ? $item['l'] :0,
                        'w'=>$item['w'] ? $item['w'] :0,
                        'h'=>$item['h'] ? $item['h'] : 0,
                        'stack'=>$item['stack'] ? $item['stack'] : 0,
                        'total_cbm'=>$item['tcbm'] ? $item['tcbm'] : 0,
                        'l2'=>$item['l2'] ? $item['l2'] : 0,
                        'w2'=>$item['w2'] ? $item['w2'] : 0,
                        'h2'=>$item['h2'] ? $item['h2'] : 0,
                        'cbm'=>$item['cbm'] ? $item['cbm'] : 0,
                        'description_id'=>$item['description_id'] ? $item['description_id'] : 0,
                        'depo'=>$item['depo'] ? $item['depo'] : 0,
                        'total_ctn'=>$item['total_ctn'],
                        'factor'=>$item['unit_per_ctn'] ? $item['unit_per_ctn'] : 0,
                        'rate_per_ctn'=>$item['rate_per_ctn'] ? $item['rate_per_ctn']: 0,
                        'order_qty_ctn'=>$item['total_ctn'],
                        'sc_qty_ctn'=>$item['do_unit'] ? $item['do_unit'] : $item['total_unit'],
                        'cbm_per_ctn'=>$item['cbm'] ? $item['cbm'] : 0,
                        'ref_code'=>$item['ref_code'] ? $item['ref_code'] : 0,
                        'hs_code'=>$item['hs_code'] ? $item['hs_code'] : 0,
                        'specifition'=>'no'
                   ]);

                }else{
                    
                    $FCustOrderDetails=new FCustOrderDetails();
                    $FCustOrderDetails->master_id=$request->poId;
                    $FCustOrderDetails->item_id=$ci_item->id;
                    $FCustOrderDetails->item_name=$item['name'];
                    $FCustOrderDetails->do_unit=$item['do_unit'] ? $item['do_unit'] : $item['total_unit'];
                    $FCustOrderDetails->order_qty=$item['total_unit'];
                    $FCustOrderDetails->sample_qty_pcs=$item['smqt'];
                    $FCustOrderDetails->net_weight_per_piece=$item['net_weight_per_unit'] ? $item['net_weight_per_unit'] : 0;
                    $FCustOrderDetails->gross_weight_per_piece=$item['gross_weight_per_unit'] ? $item['gross_weight_per_unit'] : 0;
                    $FCustOrderDetails->unit_per_ctn=$item['unit_per_ctn'] ? $item['unit_per_ctn'] : 0;
                    $FCustOrderDetails->acct_rate_per_piece=$item['rate_per_ctn_for_acc'] ? $item['rate_per_ctn_for_acc'] : 0;
                    $FCustOrderDetails->party_rate_per_piece=$item['rate_per_ctn_for_party'] ? $item['rate_per_ctn_for_party'] : 0;
                    $FCustOrderDetails->ci_rate_per_piece=$item['rate_per_ctn_for_party'] ? $item['rate_per_ctn_for_party'] : 0;
                    $FCustOrderDetails->l=$item['l'] ? $item['l'] :0;
                    $FCustOrderDetails->w=$item['w'] ? $item['w'] :0;
                    $FCustOrderDetails->h=$item['h'] ? $item['h'] : 0;
                    $FCustOrderDetails->stack=$item['stack'] ? $item['stack'] : 0;
                    $FCustOrderDetails->total_cbm=$item['tcbm'] ? $item['tcbm'] : 0;
                    $FCustOrderDetails->l2=$item['l2'] ? $item['l2'] : 0;
                    $FCustOrderDetails->w2=$item['w2'] ? $item['w2'] : 0;
                    $FCustOrderDetails->h2=$item['h2'] ? $item['h2'] : 0;
                    $FCustOrderDetails->cbm=$item['cbm'] ? $item['cbm'] : 0;
                    $FCustOrderDetails->description_id=$item['description_id'] ? $item['description_id'] : 0;
                    $FCustOrderDetails->depo=$item['depo'] ? $item['depo'] : 0;
                    $FCustOrderDetails->total_ctn=$item['total_ctn'];
                    // ----------------------------
                    $FCustOrderDetails->factor=$item['unit_per_ctn'] ? $item['unit_per_ctn'] : 0;
                    $FCustOrderDetails->rate_per_ctn=$item['rate_per_ctn'] ? $item['rate_per_ctn']: 0;
                    $FCustOrderDetails->order_qty_ctn=$item['total_ctn'];
                    $FCustOrderDetails->sc_qty_ctn=$item['do_unit'] ? $item['do_unit'] : $item['total_unit'];
                    $FCustOrderDetails->cbm_per_ctn=$item['cbm'] ? $item['cbm'] : 0;
                    $FCustOrderDetails->ref_code=$item['ref_code'] ? $item['ref_code'] : 0;
                    $FCustOrderDetails->hs_code=$item['hs_code'] ? $item['hs_code'] : 0;
                    $FCustOrderDetails->specifition='no';
                    $FCustOrderDetails->user_id=Auth::user()->id;
                    $FCustOrderDetails->save(); 

                }
                
            }
            
            return response()->json([
                'code'=>200,
                'message'=>"Successfully Updated Done..!!"
            ]);

        }

    }

    public function getTemplateId($request){

        $formDate = DateTime::createFromFormat('d/m/Y',$request->create_date)->format('Y-m-d');
        $toDate = DateTime::createFromFormat('d/m/Y',$request->delivery_date)->format('Y-m-d');
        $formDateObj = new DateTime($formDate);
        $toDateObj = new DateTime($toDate);
        $interval = $formDateObj->diff($toDateObj);  
        $v_tmp_day = $interval->days;
        return  $template_id = 14;;
        if ($v_tmp_day <= 30) {
            $template_id = 14;
        } elseif ($v_tmp_day >= 31 && $v_tmp_day <= 45) {
            $template_id = 15;
        } elseif ($v_tmp_day >= 46 && $v_tmp_day <= 60) {
            if ($v_order_type === 'Existing') {
                $template_id = 16;
            } elseif ($v_order_type === 'Development') {
                $template_id = 17;
            }
        } elseif ($v_tmp_day >= 61 && $v_tmp_day <= 75) {
            if ($v_order_type === 'Existing') {
                $template_id = 19;
            } elseif ($v_order_type === 'Development') {
                $template_id = 18;
            }
        } elseif ($v_tmp_day >= 76) {
            if ($v_order_type === 'Existing') {
                $template_id = 21;
            } elseif ($v_order_type === 'Development') {
                $template_id = 20;
            }
        }

        return $template_id;

    }

    public function uploadPOAttachment($request,$po_num,$po_id){
       
        if($request->hasFile('attachment_file')) {

            $file = $request->file('attachment_file');
            $filePath = $file->getRealPath();
            $fileName = $file->getClientOriginalName();
            $cFile = new \CURLFile($filePath, $file->getClientMimeType(), $fileName);
            $cFile->setPostFilename($fileName); // Set filename for cURL
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://localhost:8082/upload/po_attachment', // Endpoint URL
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'file' => $cFile,
                    'po_no' => $po_num // Pass jo_num as a POST parameter
                ),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: multipart/form-data'
                ),
            ));
    
            $doc_ref=$response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);
            if($error){

                return response()->json(['error' => $error], 500);

            }else{
                
                \DB::table('po_master')->where('id',$po_id)->update([
                    'REF_PIC'=>$doc_ref
                ]);

            }
            return response($response);

        } else {

            return response()->json(['error' => 'No file provided'], 400);

        }
        
    }

    public function addedPoMaterItem(Request $request){
            
        $status="";
        if(POItemDetails::where('item_id',$request->item_id)->where('master_id',$request->po_master_id)->exists()){

             $status="alredy_exist";

        }else{
                
            $poItemDetails=new POItemDetails();
            $poItemDetails->master_id=$request->po_master_id;
            $poItemDetails->item_id=$request->item_id;
            $poItemDetails->factor=$request->item_factor;
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
        $date=$month.$day.$year;
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
            return $party_code->code.$create_number.$date;
         
        }else{

            $number=1;
            $po_number=new PONumber();
            $po_number->party_id=$party_id;
            $po_number->number=1;
            $po_number->year=$currentYear;
            $po_number->save();
            $create_number=str_pad($number,6,'0',STR_PAD_LEFT);
            return $party_code->code.$create_number.$date;

           
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
        $results=DB::select("select
                    ci_items.id,
                    ci_items.ci_item_code as code,
                    ci_items.ci_item_name as item_name,
                    companies.factory_name as com,
                    po_item_details.factor,
                    po_item_details.rate_per_ctn,
                    po_item_details.sc_qty_ctn as order_qty,
                    po_item_details.specifition,
                    po_master.APPROVED_STATUS as status
                from po_master
                join po_item_details on po_item_details.master_id=po_master.ID
                join ci_items on ci_items.id=po_item_details.item_id
                join companies on companies.id=ci_items.bu_id
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

    public function getFcustOdrDetails(Request $request){

        $po = FCustOrderMaster::where('fcust_demand_master.id', $request->order_id)
            ->join('fcust_demand_details', 'fcust_demand_master.id', '=', 'fcust_demand_details.master_id')
            ->first([
                'fcust_demand_master.ID',
                'fcust_demand_master.BUYER_PO',
                'fcust_demand_master.DELIVERY_DATE',
                'fcust_demand_master.INSPECTION_DATE',
                'fcust_demand_master.PO_DATE',
                'fcust_demand_master.REMARK',
                'fcust_demand_details.party_id'
            ]);
        $buyers=Importer::orderBy('id','asc')->get();
        return response()->json([
            'buyer_po'=>$po->BUYER_PO,
            'po_date'=>date("d/m/Y", strtotime($po->PO_DATE)),
            'delivery_date'=>date("d/m/Y", strtotime($po->DELIVERY_DATE)),
            'inspection_date'=>date("d/m/Y", strtotime($po->INSPECTION_DATE)),
            'note'=>$po->REMARK,
            'buyer_id'=>$po->party_id,
            'buyers'=>$buyers,
            'poId'=>$po->ID
        ]);

    }

    public function updateSingleDemnad(Request $request){
        
        $ci_item=CiItem::where('ci_item_code',$request->item_code)->first(['id']);
        $result = POItemDetails::where('master_id',$request->edit_po_id)
                        ->where('item_id',$ci_item->id)
                        ->update([
                                'order_qty_ctn'      => $request->order_qty/$request->factor,
                                'sc_qty_ctn'         => $request->order_qty
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
                
                $ci_item=CiItem::where('ci_item_code',$request->editPoDetails[$i]['item_code'])->first(['id']);
                POItemDetails::where('master_id',$request->edit_po_id)
                    ->where('item_id',$ci_item->id)
                    ->update([
                        'order_qty_ctn'      => $request->editPoDetails[$i]['order_qty'] ? $request->editPoDetails[$i]['order_qty'] : 0,
                        'specifition'        => $request->editPoDetails[$i]['specifications']]);                
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
       
        $results=DB::select("
                ci_items.ci_item_code AS Item_Code,
                ci_items.ci_item_name AS Name,
                COALESCE(notify_party_items.factor,0) AS Factor,
                0 as Rate_Per_Ctn,
                0 as Order_Qty_Ctn,
                '' as Specifications,
                notify_party_items.clint_fg_code as party_item_code
            FROM
            notify_party_items
            JOIN ci_items ON ci_items.id = notify_party_items.ci_item_id
            WHERE notify_party_items.notify_party_id ='$request->party_id'");
        
        if(count($results) > 0) {

            $array = array();
            for ($i = 0, $c = count($results); $i < $c; ++$i) {

                $array[$i] = (array) $results[$i];
            }
            return \Excel::create('Items_List', function($excel) use ($array) {

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
        
        $results=DB::select("select
                    ci_items.ci_item_code         as item_code,
                    t1.acc_rate                   as rate_per_ctn,
                    t1.party_rate                 as rate_per_ctn_for_party,
                    po_item_details.order_qty_ctn as ctn,
                    ''                            as mfg,
                    ''                            as exp
                from po_master
                    join po_item_details on po_item_details.master_id = po_master.ID
                    join ci_items on ci_items.id = po_item_details.item_id
                    join notify_parties on notify_parties.id = po_master.PARTY_ID
                    join (select
                            notify_party_items.ci_item_id      as item_id,
                            notify_party_items.notify_party_id as party_id,
                            notify_party_items.acc_rate        as acc_rate,
                            notify_party_items.party_rate      as party_rate
                        from notify_party_items) as t1 on t1.party_id = po_master.PARTY_ID and t1.item_id = po_item_details.item_id
                where po_master.ID='$request->po_id'");

        if(count($results) > 0) {

            $array = array();
            for ($i = 0, $c = count($results); $i < $c; ++$i) {

                $array[$i] = (array) $results[$i];
            }
            return \Excel::create('Demand_Report', function($excel) use ($array) {

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
                ->select('ci_items.id','ci_items.ci_item_name','notify_party_items.factor','notify_party_items.hs_code','notify_party_items.cbm_per_ctn','ci_items.ci_item_code','notify_party_items.acc_rate','notify_party_items.party_rate','notify_party_items.desk_item_name','notify_party_items.gross_weight','notify_party_items.clint_fg_code as clint_fg_code')
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
      
       $ids_string = implode(',', $request->item_ids);
       $results=DB::select("UPDATE po_item_details SET status='N' WHERE po_item_details.item_id IN ($ids_string) AND po_item_details.master_id='$request->edit_po_id'");
       return response()->json([
          'status'=>'success'
       ],200); 

    }

    public function demandPartyItemView(Request $request){
          
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'
                    and notify_parties.status=1");
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
                case when party_order_items.party_item_name then party_order_items.party_item_name else '' end as party_item_name,
                case when party_order_items.min_order_qty then party_order_items.min_order_qty else '' end as min_odr_qty,
                case when party_order_items.max_order_qty then party_order_items.max_order_qty else '' end  as max_odr_qty,
                case when party_order_items.reorder then party_order_items.reorder end as reorder_qty,
                case when party_order_items.purchase_lead_day then party_order_items.purchase_lead_day end as purchase_lead_day,
                case when party_order_items.agv_sales then party_order_items.agv_sales end as avg_sales
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

    public function loadViewExcelUploadItems(Request $request){

        return view('sale_contract.po.partials.excel_items');

    }

    public function jsonGetPOInvValue(Request $request){
       
        $result = DB::table('po_master')
            ->join('po_item_details', 'po_item_details.master_id', '=', 'po_master.ID')
            ->where('po_master.ID', '=', 3616)
            ->select(
                DB::raw('SUM(po_item_details.do_unit * po_item_details.acct_rate_per_piece) as total_value'),
                DB::raw('SUM(po_item_details.sample_qty_pcs * po_item_details.acct_rate_per_piece) as sample_value')
            )->first();

        return response()->json([
            'totalValue'=>$result->total_value ? $result->total_value : 0,
            'sampleValue'=>$result->sample_value ? $result->sample_value : 0
        ]);

    }

    public function searchPreviousInv(Request $request){
        
        $searchTerm = $request->input('item_code');
        $results = DB::table('sale_contracts')
            ->select(
                'sale_contracts.invoice_no as invoice_no'
            )
            ->where('sale_contracts.invoice_no', 'LIKE', '%' . $searchTerm . '%')
            ->limit(10)
            ->get();
        return response()->json($results);

    }

    public function jsonDeleteDemandItem(Request $request){
      
       if($request->btnType=='Edit'){
           POItemDetails::where('id',$request->id)->delete();
       }else if($request->btnType=="Create"){
           TemporaryTable::where('id',$request->id)->delete();
       }
       return response()->json([
          'status'=>'Success',
          'code'=>200
       ]);

    }

    public function getFcustOrderItems(Request $request){

        $results=DB::select("select
            fdd.id                     as id,
            ci_items.ci_item_code      as item_code,
            fdd.ref_code               as ref_code,
            fdd.item_name              as ci_item_name,
            fdd.hs_code                as hs_code,
            fdd.do_unit                as do_unit,
            fdd.order_qty              as order_qty,
            fdd.sample_qty_pcs         as sample_qty_pcs,
            fdd.factor                 as factor,
            fdd.order_qty_ctn          as total_ctn,
            fdd.rate_per_ctn           as rate_per_ctn,
            fdd.net_weight_per_piece   as net_weight_per_piece,
            fdd.gross_weight_per_piece as gross_weight_per_piece,
            fdd.unit_per_ctn           as unit_per_ctn,
            fdd.acct_rate_per_piece    as acct_rate_per_piece,
            fdd.party_rate_per_piece   as party_rate_per_piece,
            fdd.ci_rate_per_piece      as ci_rate_per_piece,
            fdd.l                      as l,
            fdd.w                      as w,
            fdd.h                      as h,
            fdd.stack                  as stack,
            fdd.total_cbm              as total_cbm,
            fdd.l2                     as l2,
            fdd.w2                     as w2,
            fdd.h2                     as h2,
            fdd.cbm                    as cbm,
            fdd.description_id as description_id,
            fdd.depo as depo
        from fcust_demand_details fdd
        join ci_items on ci_items.id = fdd.item_id
        where fdd.master_id='$request->poId'");

        $resultsCollection = collect($results);
        $records = $resultsCollection->map(function($item) {
            return (object)[
                'id' => $item->id,
                'item_code' => $item->item_code,
                'ref_code' => $item->ref_code,
                'ci_item_name' => $item->ci_item_name,
                'hs_code' => $item->hs_code,
                'do_unit' => $item->do_unit,
                'order_qty' => $item->order_qty,
                'sample_qty_pcs' => $item->sample_qty_pcs,
                'factor' => $item->factor,
                'total_ctn' => $item->total_ctn,
                'rate_per_ctn' => $item->rate_per_ctn,
                'net_weight_per_piece' => $item->net_weight_per_piece,
                'gross_weight_per_piece' => $item->gross_weight_per_piece,
                'unit_per_ctn' => $item->unit_per_ctn,
                'acct_rate_per_piece' => $item->acct_rate_per_piece,
                'party_rate_per_piece' => $item->party_rate_per_piece,
                'ci_rate_per_piece' => $item->ci_rate_per_piece,
                'l' => $item->l,
                'w' => $item->w,
                'h' => $item->h,
                'stack' => $item->stack,
                'total_cbm' => $item->total_cbm,
                'l2' => $item->l2,
                'w2' => $item->w2,
                'h2' => $item->h2,
                'cbm' => $item->cbm,
                'description_id' => $item->description_id,
                'depo' => $item->depo,
            ];
        });    

        if(count($records)>0) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => [$records]
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);

        }

    }

    public function fcastOrderRcv(){
  
        $user_id=Auth::user()->id;
        $companies=Company::orderBy("factory_name","ASC")->get(); 
        return view('forecast.order_receive',compact('companies')); 

    }

    public function fcastReceiveList(Request $request){

        $from_date = $request->from_date ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date = $request->to_date ? date("Y-m-d", strtotime($request->to_date)) : null;
        $companies = $request->companies ? implode(',', $request->companies) : null;
        $results = DB::select("CALL forecast_order_list(?, ?)", [$from_date, $to_date, $companies]);
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

    public function getFcastDemandData(Request $request){
        $order_id = $request->order_id;
        $results = DB::select("CALL PROC_FCUST_ORDER_DEMAND(?)", [$order_id]);

        if ($results) {
            $data = [];
            $buyers = []; // সকল ডাইনামিক buyers

            foreach ($results as $row) {
                $row = (array)$row;

                // buyers কলাম গুলো আলাদা করা
                $buyerData = [];
                foreach ($row as $key => $value) {
                    if (!in_array($key, ['IMP_CODE','PRODUCT_CODE','PRODUCT_NAME','FACTOR','FOB','TOTAL QTY','TOTAL VALUE','REMARKS'])) {
                        $buyers[$key] = $key; // buyer নাম সংগ্রহ
                        $buyerData[$key] = $value; // buyer-এর quantity
                        unset($row[$key]);
                    }
                }

                $row['buyers'] = $buyerData;
                $data[] = $row;
            }

            return response()->json([
                'message' => "Data Found",
                'code'    => 200,
                'buyers'  => array_values($buyers),
                'data'    => $data
            ]);
        } else {
            return response()->json([
                'message' => "No Data Found",
                'code'    => 500,
                'buyers'  => [],
                'data'    => []
            ]);
        }
    }

    public function getFcustTaskDetails(Request $request){
        
        $userId=Auth::user()->id;
        $userTaskLists=DB::select("CALL FCUST_UPDATE_TASK_LIST($request->po_id,$userId,$request->jo_id)");
        return response()->json([
            'userTaskLists'=>$userTaskLists,
            'po_master_id'=>$request->po_id,
            'jo_no'=>$userTaskLists[0]->jo_no,
            'error'=>''     
        ],200);

    }

    public function jsonGetPOWiseJoList(Request $request){
        
        $saleContact=FCustScMaster::where('po_master_id',$request->po_id)->where('inactive','=','N')->first(['id']);
        $results=DB::select("select
                id, 
                job_order_number2 as jo_no
            from fcust_jo_master
            where fcust_jo_master.status!=3 AND fcust_jo_master.job_order_number2='$request->jo_no'
            AND sale_contract_id='$saleContact->id'"); 
        return response()->json([
            'results'=>$results
        ],200);   

    }

    public function jsonGetPoAttachment(Request $request){
         
        $joFiles=JOCopies::where('jo_id',$request->jo_id)->get();
        $delivery_date=JobOrderMaster::where('id',$request->jo_id)->value('delivery_date');
        if(count($joFiles)){

            return response()->json([
                'joFiles' => $joFiles,
                'delivery_date'=>date("d-m-Y", strtotime($delivery_date))
            ],200);

        }else{

            return response()->json([
                'joFiles' => [],
                'delivery_date'=>date("d-m-Y", strtotime($delivery_date))
            ],200);
        }

    }

    public function rcvFactOrder(Request $request)
    {

        FCustJoMaster::where('id',$request->jo_id)->update(['prod_api_status'=>'Y']);
        return response()->json([
            'status'=>'success',
            'code'=>200,
            'message' => "Task Updated Done..!!"
        ]);

        // $jo_no=JobOrderMaster::where('id',$request->jo_id)->value('job_order_number2');
        // $job_type=JobOrderMaster::where('id',$request->jo_id)->value('job_type');
        // if($request->task_id==4){
        //     if(JobOrderMaster::where('id',$request->jo_id)->value('job_type')==NULL){
        //         $this->SynJoOrderByApi($request->jo_id,$request->order_type); 
        //         $this->CreateTNA($jo_no);
        //         $this->sendJOReceiveNotification($request->jo_id);
        //         seaPortdashboard::where('po_id',$request->po_master_id)->where('Task_ID',$request->task_id)->update(['action_date'=>date("Y-m-d", strtotime($request->action_date))]);
        //         return response()->json([
        //             'status'=>'success',
        //             'code'=>200,
        //             'message' => "Task Updated Done..!!"
        //         ]);
        //     }else{
        //         JobOrderMaster::where('id',$request->jo_id)->update([
        //             'prod_api_status'=>'Y'
        //         ]);
        //         return response()->json([
        //             'status'=>'success',
        //             'code'=>200,
        //             'message' => "Task Updated Done..!!"
        //         ]);
        //     }
           
        // }

    }

    public function fcastReport(Request $request){

        return view('forecast.fcast_report');

    }

    public function showFcastReport(Request $request){

        try {

            $results = DB::select("CALL PROC_FCUST_ORDER_REPORT()");
            if (!empty($results)) {
                $headers = [];
                if (count($results) > 0) {
                    $firstRow = (array)$results[0];
                    $headers = array_keys($firstRow);
                }
                
                return response()->json([
                    'message' => "Data Found",
                    "code"    => 200,
                    "data"    => $results,
                    "headers" => $headers
                ]);
            } else {
                return response()->json([
                    'message' => "No data available",
                    "code"    => 404,
                    "data"    => [],
                    "headers" => []
                ]);
            }

        } catch (\Exception $e) {

            return response()->json([
                'message' => "Internal Server Error: " . $e->getMessage(),
                "code"    => 500,
                "data"    => [],
                "headers" => []
            ]);

        } 

    }

}

