<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\NotifyParty;
use App\Importer;
use App\NotifyPartyUser;
use Auth;
use App\DistributorInfoMaster;
use App\JobOrderMaster;
use App\JobOrderDetails;
use App\CiItem;
use App\SaleContract;
use App\ProductionFloor;
use Session;
use App\Depot;
use App\JObOrderNumber;
use Carbon\Carbon;
use App\Dunit;
use App\Runit;
use Toastr;
use PDF;
use App\DateFormat;
use App\User;
use App\SaleContractDetail;
use App\DoMaster;
use App\DoDetails;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobOrderApproveMail;
use App\Mail\JobOrderMail;
use App\JobApproveMaster;
use App\JobApproveDetail;
use App\LandPortDashboard;
use App\seaPortdashboard;
use App\Vat;
use App\PFP;
use App\ODP;
use DB;
use App\ApprovePercent;
use App\MailList;
use App\UserArea;
use App\JOSyn;
use DateTime;
class QuickJobOrderController extends Controller
{
    public function __construct(){

       $this->middleware('auth');

    }
   
    public function create()
    {    

        $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');
        $notify_parties = NotifyParty::orderBy('id','DESC')->whereIn('id',$notify_party_ids)->get();
        return view("job_order_quick.index")
                ->with('notify_parties', $notify_parties);
        
    }

     public function getPartyWiseSCJoList(Request $request){
        
        $results=DB::select("select
                sc.id,
                job_order_masters.id as jo_id,
                sc.notify_pary_id as party_id,
                sc.sales_contract_no,
                job_order_masters.job_order_number as jo_number,
                date_format(sc.dated,'%d-%m-%Y') as sales_contract_date,
                sc.invoice_no,
                c.name as company,
                b.short_name as bank,
                CASE WHEN job_order_masters.status = 1 THEN 'Pending'
                WHEN job_order_masters.status = 2 THEN 'Approved'
                WHEN job_order_masters.status IS NULL THEN 'Not Created'
                END AS status
            from sale_contracts sc
            join companies c on c.id=sc.company_id
            join banks b on b.id=sc.bank_id
            join importers imp on imp.id=sc.importer_id
            left join job_order_masters on job_order_masters.sale_contract_id=sc.id
            where sc.notify_pary_id='$request->party_id' AND sc.inactive='N' AND (job_order_masters.status != 3 OR job_order_masters.status IS NULL)
            order by sc.id desc");
        return response()->json([
            'results'=>$results,
            'code'=>200
        ]);

        return response()->json([
            'results'=>$results,
            'code'=>200
        ]);
        
    }

    public function createNew(Request $request){

        $encodedPartyId = $request->query('partyId');
        $encodedScid = $request->query('scid');
        $encodedjoid = $request->query('joid');
        $party_id = base64_decode($encodedPartyId);
        $sale_contact_id = base64_decode($encodedScid); 
        $jodi_id = base64_decode($encodedjoid);  
        $notify_party= NotifyParty::where('id', $party_id)->first(['name','address','shipping_mark']);
        $importer_code = NotifyParty::where('id', $party_id)->pluck('code');
        $salesContactItems = SaleContract::select(
                'sale_contract_details.id as line_id',
                'ci_items.ci_item_code',
                'ci_items.ci_item_name',
                'ci_items.ci_factor as factor',
                'sale_contract_details.pcs_in_ctn',
                'notify_party_items.dunit as du_unit',
                'notify_party_items.runit as ru_unit',
                'sale_contract_details.ctn as qty',
                'notify_parties.shipping_mark',
                'notify_party_items.shelf_life as self_line',
                'notify_party_items.coding_matter as coding_mater',
                'notify_party_items.special_requirement as special_requirment',
                'sale_contract_details.rate_per_ctn_for_acc',
                DB::raw('ROUND(sale_contract_details.rate_per_ctn_for_acc / ci_items.ci_factor, 6) as rate'),
                'sale_contracts.sales_contract_no',
                'production_floors.p_code',
                'production_floors.short_name as factory',
                'sale_contract_details.sample_qty',
                'sale_contract_details.rate_status',
                'notify_party_items.factory_id as wh_id'
            )
            ->join('sale_contract_details', 'sale_contract_details.sale_contract_id', '=', 'sale_contracts.id')
            ->join('ci_items', 'ci_items.id', '=', 'sale_contract_details.ci_item_id')
            ->join('notify_party_items', 'notify_party_items.ci_item_id', '=', 'sale_contract_details.ci_item_id')
            ->join('notify_parties', 'notify_parties.id', '=', 'notify_party_items.notify_party_id')
            ->leftJoin('production_floors', 'production_floors.id', '=', 'notify_party_items.factory_id')
            ->where('sale_contracts.id', $sale_contact_id)
            ->where('notify_party_items.notify_party_id', $party_id)
            ->get();

        $depots=ProductionFloor::where('status',1)->get(); 
        $dunits=Dunit::all();
        $runits=Runit::all();
        $invoice_no=SaleContract::where('id', $sale_contact_id)->pluck('invoice_no');    
        $shipping_mark=""; 
        $sc_number="";
        foreach($salesContactItems as $key => $value) {
                     
          $shipping_mark=$value->shipping_mark;
          $sc_number=$value->sales_contract_no;

        }    

        $sale_contract=SaleContract::where('id',$sale_contact_id)->first(['party_address']);
        return view("job_order_quick.create")
               ->with('importer_name',$notify_party->name)
               ->with('sale_contract', $sale_contract)
               ->with('salesContactItems',$salesContactItems)
               ->with('importer_code', $importer_code['0'])
               ->with('sale_contract_id',$sale_contact_id)
               ->with('dunits', $dunits)
               ->with('runits', $runits)
               ->with('depots', $depots)
               ->with('shipping_mark', $notify_party->shipping_mark)
               ->with('sc_number', $sc_number)
               ->with('party_id', $party_id)
               ->with('invoice_no',$invoice_no['0']);

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
        
        $results=\DB::select("select
            ci_items.ci_item_code as item_code,
            ci_items.ci_item_name as item_name,
            job_order_details.orqt as order_qty,
            job_order_details.smqt as sample_qty,
            round(job_order_details.rate,6) as rate
        from job_order_masters
            join job_order_details on job_order_details.master_id=job_order_masters.id
            join ci_items on ci_items.id=job_order_details.item_id
        where job_order_masters.id='$id'
                and job_order_details.item_status='Y'");

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editJobOrder(Request $request)
    {

        $encodedPartyId = $request->query('partyId');
        $encodedJoid = $request->query('joid');
        $party_id = base64_decode($encodedPartyId);
        $id = base64_decode($encodedJoid);
        $jobHeaderInfo = DB::table('job_order_masters')
            ->join('notify_parties', 'notify_parties.id', '=', 'job_order_masters.importer_id')
            ->join('sale_contracts', 'sale_contracts.id', '=', 'job_order_masters.sale_contract_id')
            ->select(
                'notify_parties.code', 
                'notify_parties.name', 
                'notify_parties.address', 
                'job_order_masters.shipping_mask',
                'job_order_masters.note', 
                'job_order_masters.issue_date', 
                'job_order_masters.delivery_date', 
                'job_order_masters.mfg_date', 
                'job_order_masters.batch_number',
                'job_order_masters.job_order_number', 
                'sale_contracts.sales_contract_no', 
                'job_order_masters.mfg_date_orginal', 
                'job_order_masters.best_before', 
                'job_order_masters.imp_by', 
                'job_order_masters.distributed_by', 
                'job_order_masters.wh_id'
            )
            ->where('job_order_masters.id', $id)
            ->first();

        $jobItemDetails = DB::table('job_order_masters')
            ->join('job_order_details', 'job_order_details.master_id', '=', 'job_order_masters.id')
            ->join('ci_items', 'ci_items.id', '=', 'job_order_details.item_id')
            ->select(
                'job_order_details.id',
                'job_order_details.item_id',
                'ci_items.ci_item_code',
                'ci_items.ci_item_name',
                'job_order_details.self_life as self_line',
                'job_order_details.exp_date',
                'job_order_details.qty',
                'job_order_details.sale_contact_qty as pcs_in_ctn',
                'job_order_details.du_unit',
                'job_order_details.ru_unit',
                'job_order_details.orqt as odr_qty',
                'job_order_details.smqt as sample_qty',
                'job_order_details.coding_matter as coding_mater',
                'job_order_details.sreq as special_requirment',
                'job_order_details.rate',
                'job_order_details.rate_status',
                'ci_items.ci_factor as factor',
                'job_order_details.factory',
                'job_order_details.wh_id',
                'job_order_details.id as line_id'
            )
            ->where('job_order_masters.id', $id)
            ->where('job_order_details.item_status', 'Y')
            ->get();

        $result=JobOrderMaster::findorfail($id);
        $jobOrderNumber=explode("/",$result->job_order_number);
        $dunits=Dunit::all();
        $runits=Runit::all();
        $depots=ProductionFloor::where('status',1)->get(); 
        $sales_contract_details=SaleContract::findorfail($result->sale_contract_id);
        $sc_number=$sales_contract_details->sales_contract_no;
        $invoice_no=SaleContract::where('id', $result->sale_contract_id)->pluck('invoice_no'); 
        return view('job_order_quick.job_order_edit')
                ->with('jobHeaderInfo', $jobHeaderInfo)
                ->with('depots', $depots)
                ->with('jobOrderNumber', $jobOrderNumber['0'])
                ->with('jobItemDetails', $jobItemDetails)
                ->with('dunits', $dunits)
                ->with('runits', $runits)
                ->with('sc_number',$sc_number)
                ->with('edit_id',$id)
                ->with('invoice_no',$invoice_no['0'])
                ->with('sale_contract_id',$result->sale_contract_id);
              
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
     
        try {

            $syn_date = date('Y-m-d');
            // Update sync status date
            JobOrderDetails::where('master_id', $request->edit_id)->update([
                'syn_status_date' => $syn_date
            ]);

            $importer_id = NotifyParty::where('code', $request->importer_code)->value('id');         
            
            // Update job order master
            DB::table('job_order_masters')
                ->where('id', $request->edit_id)
                ->update([
                    'shipping_mask' => $request->shipping_mark,
                    'note' => $request->note,
                    'issue_date' => $request->issue_date,
                    'delivery_date' => $request->delivery_date,
                    'mfg_date_orginal' => $request->mfg_date,
                    'best_before' => $request->bestBefore,
                    'imp_by' => $request->imp_by,
                    'distributed_by' => $request->distributed_by,
                    'batch_number' => $request->batch_number,
                    'mfg_date' => $this->getMfgDateFormate($importer_id, $request->mfg_date)
                ]);

            // Update job order details
            $infoDetails = $request->input('info_details');
            foreach($infoDetails as $index => $item) { 

                $ci_item = CiItem::where('ci_item_code', $item['item_code'])->first(['ci_factor','id']);
                DB::table('job_order_details')->where('id', $item['line_id'])
                    ->update([
                        'du_unit' => $item['du_unit'],
                        'ru_unit' => $item['ru_unit'],
                        'orqt' => $item['orqt'],
                        'smqt' => $item['smqt'],
                        'coding_matter' => $this->formatMultilineText($item['coding_matter']),
                        'sreq' => $this->formatMultilineText($item['sreq']),
                        'rate' => $item['rate'],
                        'wh_id' => $item['depot'],
                        'update_by' => Auth::user()->id
                    ]);
            }

            // Update KYC data
            $this->updateKyvData($request->edit_id);
            return response()->json([
                'status' => 'success',
                'message' => 'Job Order updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update job order: ' . $e->getMessage()
            ], 500);
        }

    }

    public function deleteJobOrderItemInEdit(Request $request)
    {

        try {

            $lineIds = $request->input('line_ids');
            $date = date('Y-m-d');
            if (!$lineIds || !is_array($lineIds) || empty($lineIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No items selected for removal'
                ], 400);
            }

            $updatedCount = JobOrderDetails::whereIn('id', $lineIds)
                ->update([
                    'item_status' => 'N',
                    'inactive_date' => $date,
                    'inactive_by' => Auth::user()->id,
                    'syn_status_date' => $date
                ]);
            $this->updateKyvData($request->edit_id);
            return response()->json([
                'success' => true,
                'message' => $updatedCount . ' item(s) removed successfully',
                'removed_count' => $updatedCount,
                'removed_ids' => $lineIds
            ]);
            
            
            
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to remove items: ' . $e->getMessage()
            ], 500);

        }

    }

    public function deleteDoOrderItem(Request $request){

       $date=date('Y-m-d');
       \DB::table('job_order_details')->whereIn('id', explode(",",$request->ids))->update(array('item_status' =>'N','inactive_date'=>$date,'inactive_by'=>Auth::user()->id));
       return response()->json(['success'=>"Item Delete successfully...!!"]);
         

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

    // public function getImporterDetailsForJobOrder(Request $request){
          

    //     $importer_id=$request->importer_id;  
    //     if($importer_id){
            
    //         $address=NotifyParty::where('id', $request->importer_id)->pluck('address');
    //         $name=NotifyParty::where('id', $request->importer_id)->pluck('name'); 
    //         $importerSalesContacts = DistributorInfoMaster::select('distributor_info_masters.sale_contract_id','sale_contracts.sales_contract_no')
    //                     ->join('sale_contracts','sale_contracts.id','=','distributor_info_masters.id')
    //                     ->where('distributor_info_masters.importer_id', $request->importer_id)
    //                     ->get();
 
    //     }else{


    //         $importer_id="";
             

    //     }

    //     $sale_contract_id="";
    //     $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');
    //     $notifyParties = NotifyParty::whereIn('id',$notify_party_ids)->get();
    //     return view("job_order.create")
    //            ->with('importerSalesContacts', $importerSalesContacts)
    //            ->with('importer_id', $importer_id)
    //            ->with('notifyParties', $notifyParties)
    //            ->with('sale_contract_id', $sale_contract_id)
    //            ->with('importer_address', $address['0'])
    //            ->with('importer_name', $name['0']);




    // }

    public function getJobOrderItemBelogToSaleContact(Request $request){

        $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');
        $notifyParties = NotifyParty::whereIn('id',$notify_party_ids)->get();
        $sale_contract_details=DistributorInfoMaster::select('ci_items.ci_item_code','ci_items.ci_item_name','distributor_info_details.du_unit','distributor_info_details.ru_unit','distributor_info_details.self_line','distributor_info_details.coding_mater','distributor_info_details.special_requirment','distributor_info_details.rate','distributor_info_details.qty') 
            ->join('distributor_info_details','distributor_info_masters.id','=','distributor_info_details.distributor_master_id')
            ->join('ci_items','ci_items.id','=','distributor_info_details.item_id')
            ->where('distributor_info_masters.importer_id','=',$request->importer_id)
            ->where('distributor_info_masters.sale_contract_id','=',$request->sale_contact_id)
            ->get();

        $importerSalesContacts = DistributorInfoMaster::select('distributor_info_masters.sale_contract_id','sale_contracts.sales_contract_no')
                        ->join('sale_contracts','sale_contracts.id','=','distributor_info_masters.id')
                        ->where('distributor_info_masters.importer_id', $request->importer_id)
                        ->get();    

        return view("job_order.create")
            ->with('sale_contract_details', $sale_contract_details)
            ->with('notifyParties', $notifyParties)
            ->with('shipping_mark', $request->shipping_mark)
            ->with('importer_address', $request->importer_address)
            ->with('importer_name', $request->importer_name)
            ->with('importer_id', $request->importer_id)
            ->with('sale_contact_id', $request->sale_contact_id)
            ->with('importerSalesContacts', $importerSalesContacts)
            ->with('note', $request->note)
            ->with('issue_date', $request->issue_date)
            ->with('delivery_date', $request->delivery_date)
            ->with('mfg_date', $request->mfg_date)
            ->with('batch_number', $request->batch_number);

    }

    public function storeJobCreateInfo(Request $request)
    {
        
        ini_set('max_execution_time', 600);       
        $importer_id = NotifyParty::where('code', $request->importer_code)->first(['id']);
        $jobOrderMaster = new JobOrderMaster();
        $jobOrderMaster->importer_id = $importer_id->id;
        $jobOrderMaster->sale_contract_id = $request->sale_contact_id;
        $jobOrderMaster->shipping_mask = $request->shipping_mark;
        $jobOrderMaster->note = $request->note;
        $jobOrderMaster->issue_date = $request->issue_date;
        $jobOrderMaster->delivery_date = $request->delivery_date;
        $jobOrderMaster->mfg_date_orginal = $request->mfg_date;
        $jobOrderMaster->mfg_date = $this->getMfgDateFormate($importer_id->id, $request->mfg_date);
        $jobOrderMaster->batch_number = $request->batch_number;
        $jobOrderMaster->job_order_number = $this->getJobOrderNumber($importer_id->id, $request->importer_code);
        $jobOrderMaster->best_before = $request->bestBefore;
        $jobOrderMaster->imp_by = $request->imp_by;
        $jobOrderMaster->distributed_by = $request->distributed_by;
        $jobOrderMaster->user_id = Auth::user()->id;
        $jobOrderMaster->status = 1;
        $jobOrderMaster->save();
        $infoDetails = $request->input('info_details');
        $factoryItems = [];
        foreach($infoDetails as $index => $item) {
            
            $party_item = CiItem::where('ci_item_code', $item['item_code'])->first();
            $jobOrderDetails = new JobOrderDetails();
            $jobOrderDetails->master_id = $jobOrderMaster->id;
            $jobOrderDetails->sc_line_id = $item['line_id'];
            $jobOrderDetails->item_id = $party_item->id;
            $jobOrderDetails->self_life = $item['self_life'];
            $jobOrderDetails->factor = $item['factor'];
            $jobOrderDetails->exp_date = $this->getExpDateFormate($importer_id->id, $request->mfg_date, $item['self_life']);
            $jobOrderDetails->qty = $item['qty'];
            $jobOrderDetails->sale_contact_qty = $item['sale_contact_qty'];
            $jobOrderDetails->du_unit = $item['du_unit'];
            $jobOrderDetails->orqt = $item['orqt'];
            $jobOrderDetails->smqt = $item['smqt'];
            $jobOrderDetails->ru_unit = $item['ru_unit'];
            $jobOrderDetails->coding_matter = $this->formatMultilineText($item['coding_matter']);
            $jobOrderDetails->sreq = $this->formatMultilineText($item['sreq']);
            $jobOrderDetails->cncl = 0; 
            $jobOrderDetails->rate = $item['rate'];
            $wh_id=ProductionFloor::where('p_code',$item['depot'])->value('id');
            $jobOrderDetails->wh_id = $wh_id;
            $jobOrderDetails->rate_status = 'Y';
            $jobOrderDetails->update_by = Auth::user()->id;
            $jobOrderDetails->version = 1;
            $jobOrderDetails->save();
            $factoryId = $wh_id;
            if (!isset($factoryItems[$factoryId])) {
                $factoryItems[$factoryId] = [];
            }
            $factoryItems[$factoryId][] = $item;
            
        }

        $this->updateKyvData($jobOrderMaster->id);                                   // Update KYV Data
        $this->sendFactoryWiseEmails($factoryItems, $jobOrderMaster, $request);    // Send factory-wise emails
        return response()->json([                                                    // Return success response                     
            'status' => 'success',
            'message' => 'Job Order created successfully!',
            'job_order_number' => $jobOrderMaster->job_order_number
        ]);
    }


    private function formatMultilineText($text)
    {
        if (!$text) return '';

        // Normalize line endings
        $text = str_replace(["\r\n", "\r"], "\n", trim($text));

        // Optional: auto format compact text (like "1.Use" or "#Use")
        $text = preg_replace('/#\s*/', "\n# ", $text);
        $text = preg_replace('/(\d+\.)/', "\n$1", $text);
        $text = preg_replace('/\.([A-Z])/', ".\n$1", $text);

        // Remove excessive blank lines
        $text = preg_replace("/\n{2,}/", "\n", $text);

        return trim($text);
    }

    private function sendFactoryWiseEmails($factoryItems, $jobOrderMaster, $request)
    {
        $user = \DB::table('users')->where('id', Auth::user()->id)->first(['email','name','head_id']);
        $jo_master = JobOrderMaster::where('id', $jobOrderMaster->id)->first(['job_order_number','p_floor_id','delivery_date','sale_contract_id']);
        $sale_contract = SaleContract::where('id', $jo_master->sale_contract_id)->first(['invoice_no']); 
        $notifyParty = NotifyParty::where('code', $request->importer_code)->first(['code','name','country']);
        foreach($factoryItems as $factoryId => $items) {
           
            $factory = ProductionFloor::where('id', $factoryId)->first(['short_name', 'id', 'p_code']);
            if (!$factory) {
                continue;
            }

            $email_array = User::where('location_id', $factory->id)->where('active', 1)->where('type_id', 3)->whereNotNull('email')->pluck('email')->toArray();
            $desk_array = array();
            if($user->head_id) {
                $desk_array = User::where('head_id', $user->head_id)->where('active', 1)->where('jo_mail_status', 1)->whereNotNull('email')->pluck('email')->toArray();  
            }
            
            $responsible_array = array("buh.psc@prangroup.com", "pran219@prangroup.com");
            $hasBU19 = false;
            foreach ($items as $item) {
                $saleContractDetail = SaleContractDetail::where('sale_contract_id', $jo_master->sale_contract_id)->where('bu_id', 19)->first();
                if ($saleContractDetail) {
                    $hasBU19 = true;
                    break;
                }
            }

            if ($hasBU19) {
                $sending_mail_list = array_merge($email_array, $desk_array, $responsible_array);
            } else {
                $sending_mail_list = array_merge($email_array, $desk_array);
            }
            
            $sending_mail_list = array_unique($sending_mail_list);
            if (count($sending_mail_list) > 0) {
                $data = array(
                    'job_order_number' => $jo_master->job_order_number,
                    'name' => $user->name,
                    'email' => $user->email,
                    'sale_contract' => $sale_contract->invoice_no,
                    'delivery_date' => $jo_master->delivery_date,
                    'email_array' => $sending_mail_list,
                    'items' => $items,
                    'factory' => $factory,
                    'country' => $notifyParty->country,
                    'url' => 'http://pqc.prangroup.com:8114/jo/receive'
                );
                
                $from_mail = env('MAIL_FROM_ADDRESS');
                
                try {
                    Mail::send('job_order_mail', $data, function($message) use ($from_mail, $data, $factory, $sale_contract) {
                        $message->from($from_mail, 'Job-Order-Mail@prangroup.com'); 
                        $message->to($data['email_array']); // Uncomment for production
                        // $message->to('mis94@mis.prangroup.com'); // Remove this in production
                        $message->subject('JO Creation Mail - ' . $factory->short_name . ', Invoice No. ' . $data['sale_contract']);
                    });
                    
                } catch (\Exception $e) {
                    // Log email error if needed, but don't stop the process
                    \Log::error('Email sending failed for factory ' . $factory->short_name . ': ' . $e->getMessage());
                }
            }
        }
    }

    private function updateKyvData($jo_id){
        
        $results = DB::select("CALL PROC_KYV_JO_RECEIVE_BY_ID(?)", [$jo_id]);
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
        }

    }

    //@@@@@-------------Get Mfg/Exp Date----------------

    private function getMfgDateFormate($importer_id, $mfg_date){

        $getDateFormatID=NotifyParty::where('id', $importer_id)->pluck('mfg_date');
        $dateFormate=DateFormat::where('id', $getDateFormatID['0'])->pluck('formate');
        //---Date Formate1---------------------

        if($dateFormate['0']=="2020-04-01"){
          
           return $newDate = date("Y-m-d", strtotime($mfg_date));

        }//---End---- 

        //---Date Formate2---------------------

        if($dateFormate['0']=="2020/04/01"){
          
           return $newDate = date("Y-m-d", strtotime($mfg_date));

        }//---End----

        //---Date Formate3--------------------- 

        if($dateFormate['0']=="March 14,2001"){
          
           return $newDate = date("F j, Y", strtotime($mfg_date));

        }//--End--   

        //---Date Formate4--------------------- 
        if($dateFormate['0']=="Wednesday, March 14,2001"){

          return $newDate = date('l,F j, Y', strtotime($mfg_date));  

        }
        //--End--

        // ---Date Formate5--------------------- 
        if($dateFormate['0']=="14 March 2001"){

          return $newDate = date('j F, Y' ,strtotime($mfg_date));

        }  
        // --End--

        //---Date Formate6---------------------
        if($dateFormate['0']=="01-04-2021"){

          return $newDate = date("d-m-Y", strtotime($mfg_date));

        }//---End---

        //---Date Formate6---------------------

        if($dateFormate['0']=="01/04/2021"){  

          return $newDate = date("d/m/Y", strtotime($mfg_date));

        }//---End---- 

        //---Date Formate7--------------------- 
        if($dateFormate['0']=="March 2001"){

          return $newDate = date('F, Y', strtotime($mfg_date)); 

        }

        if($dateFormate['0']=="N/A"){

          return 'N/A'; 

        }

        if($dateFormate['0']=="14 Mar 2001"){

             return $newDate = date('j M Y',strtotime($mfg_date));

        } 

        if($dateFormate['0']=="06-2001"){

             $month=date("m",strtotime($mfg_date));
             $year=date("Y",strtotime($mfg_date));
             return $date=$month.'-'.$year;

        }

        if($dateFormate['0']=="14 MAR 2001"){

            $day=date("d",strtotime($mfg_date));
            $month =strtoupper(date('M',strtotime($mfg_date)));
            $year=date("Y",strtotime($mfg_date));
            return $date=$day." ".$month." ".$year;

        }

        if($dateFormate['0']=="MAR 2001"){

            $day=date("d",strtotime($mfg_date));
            $month =strtoupper(date('M',strtotime($mfg_date)));
            $year=date("Y",strtotime($mfg_date));
            return $date=$month." ".$year;

        }

        if($dateFormate['0']=="14 MARCH 2001"){

            $day=date("d",strtotime($mfg_date));
            $month =strtoupper(date('F',strtotime($mfg_date)));
            $year=date("Y",strtotime($mfg_date));
            return $date=$day." ".$month." ".$year;

        } 

        if($dateFormate['0']=="01/2025"){
            return $newDate = date("m/Y", strtotime($mfg_date));
        }

    }

    public function getExpDateFormate($importer_id, $mfg_date, $self_life){

        
        $date=date('Y-m-d', strtotime('-1 day', strtotime($mfg_date)));
        $offset=$self_life;
        $exp_date=date('Y-m-d', strtotime("+$offset months", strtotime($date)));       
        $getDateFormatID=NotifyParty::where('id', $importer_id)->pluck('exp_date');
        $dateFormate=DateFormat::where('id', $getDateFormatID['0'])->pluck('formate');
        //---Date Formate1---------------------
        if($dateFormate['0']=="N/A"){

          return 'N/A'; 

        }else{

            if($dateFormate['0']=="2020-04-01"){
          
                return $newDate = date("Y-m-d", strtotime($exp_date));

            }//---End---- 
            //---Date Formate2---------------------
            if($dateFormate['0']=="2020/04/01"){
              
               return $newDate = date("Y-m-d", strtotime($exp_date));

            }//---End----

            //---Date Formate3--------------------- 

            if($dateFormate['0']=="March 14,2001"){
              
               return $newDate = date("F j, Y", strtotime($exp_date));

            }//--End--   

            //---Date Formate4--------------------- 
            if($dateFormate['0']=="Wednesday, March 14,2001"){

              return $newDate = date('l,F j, Y', strtotime($exp_date));  

            }
            //--End--

            // ---Date Formate5--------------------- 
            if($dateFormate['0']=="14 March 2001"){

              return $newDate = date('j F, Y' ,strtotime($exp_date));

            }  
            // --End--

            //---Date Formate6---------------------
            if($dateFormate['0']=="01-04-2021"){

              return $newDate = date("d-m-Y", strtotime($exp_date));

            }//---End---

            //---Date Formate6---------------------

            if($dateFormate['0']=="01/04/2021"){  

              return $newDate = date("d/m/Y", strtotime($exp_date));

            }//---End---- 

            //---Date Formate7--------------------- 
            if($dateFormate['0']=="March 2001"){

              return $newDate = date('F, Y', strtotime($exp_date)); 

            }

            if($dateFormate['0']=="14 Mar 2001"){

             return $newDate = date('j M,Y',strtotime($exp_date));

            }

            if($dateFormate['0']=="06-2001"){

                 $month=date("m",strtotime($exp_date));
                 $year=date("Y",strtotime($exp_date));
                 return $date=$month.'-'.$year;

            }

            if($dateFormate['0']=="14 MAR 2001"){

                $day=date("d",strtotime($exp_date));
                $month =strtoupper(date('M',strtotime($exp_date)));
                $year=date("Y",strtotime($exp_date));
                return $date=$day." ".$month." ".$year;

            }

            if($dateFormate['0']=="MAR 2001"){

                $day=date("d",strtotime($exp_date));
                $month =strtoupper(date('M',strtotime($exp_date)));
                $year=date("Y",strtotime($exp_date));
                return $date=$month." ".$year;

            }

            if($dateFormate['0']=="14 MARCH 2001"){

                $day=date("d",strtotime($exp_date));
                $month =strtoupper(date('F',strtotime($exp_date)));
                $year=date("Y",strtotime($exp_date));
                return $date=$day." ".$month." ".$year;

            }  

            if($dateFormate['0']=="01/2025"){
                return $newDate = date("m/Y", strtotime($exp_date));
            }


        }

    }

    private function getJobOrderNumber($importer_id, $party_code){

       
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
        $importerIdExistOrNOt =JObOrderNumber::orderBy('id','Desc')->where('importer_id',$importer_id)->where('year',$currentYear)->first();
        $importerIdExistOrNOtArray=(array)$importerIdExistOrNOt;
        if(count($importerIdExistOrNOtArray)>0){


            $number=$importerIdExistOrNOt->number;
            $number=$number+1;
            $jobOrderNumber=new JObOrderNumber();
            $jobOrderNumber->importer_id=$importer_id;
            $jobOrderNumber->number=$number;
            $jobOrderNumber->year=$currentYear;
            $jobOrderNumber->save();
            $create_number=str_pad($number,6,'0',STR_PAD_LEFT); 
            return $jobOrderNumber=$party_code.'-'.$create_number.'-'.$date;
         
        }else{

           $number=1;
           $jobOrderNumber=new JObOrderNumber();
           $jobOrderNumber->importer_id=$importer_id;
           $jobOrderNumber->number=1;
           $jobOrderNumber->year=$currentYear;
           $jobOrderNumber->save();
           $create_number=str_pad($number,6,'0',STR_PAD_LEFT);
           return $jobOrderNumber=$party_code.'-'.$create_number.'-'.$date;

           
        }
        

    }

    public function getJobOrderList(){

        $user_id=Auth::user()->id;
        $area_ids=UserArea::where('user_id',$user_id)->pluck('area_id')->toArray();
        $ids = join(', ', $area_ids);
        $previousDate=date('Y-m-d', strtotime('-3 month'));
        $currentDate=date('Y-m-01', strtotime($previousDate));
        $jobOrderMasters=\DB::select("SELECT
                    job_order_masters.id,
                    job_order_masters.job_order_number,
                    notify_parties.code,
                    notify_parties.address,
                    sale_contracts.sales_contract_no,
                    sale_contracts.invoice_no,
                    job_order_masters.issue_date,
                    job_order_masters.status,
                    notify_parties.name,
                    job_order_masters.job_order_do_number,
                    depots.d_code,depots.d_name
                FROM
                    job_order_masters
                JOIN notify_parties ON job_order_masters.importer_id = notify_parties.id
                JOIN sale_contracts ON sale_contracts.id = job_order_masters.sale_contract_id
                LEFT JOIN depots ON depots.d_code=job_order_masters.wh_id
                WHERE notify_parties.area_id in ($ids) and job_order_masters.status!=2 
                     and job_order_masters.status!=3
                ORDER by job_order_masters.id");
        return view("job_order.job_order_list")
               ->with('jobOrderMasters', $jobOrderMasters);

    }

    public function jobOrderApprovalList(){

        $results=DB::select("SELECT
                sale_contracts.id,
                sale_contracts.sales_contract_no,
                sale_contracts.dated,
                sale_contracts.invoice_no,
                importers.name AS importer,
                banks.name AS bank,
                sale_contracts.matching_status
            FROM
                sale_contracts
            JOIN importers ON importers.id = sale_contracts.importer_id
            JOIN companies ON companies.id = sale_contracts.company_id
            JOIN banks ON banks.id = sale_contracts.bank_id
            WHERE
                sale_contracts.matching_status = '1' OR sale_contracts.matching_status = '2'");
        return view('job_order.job_order_approval_list')->with('results',$results);

    }

    public function AppvoveJobOrder(Request $request){ 
        
        $result=\DB::table('job_order_masters')->where('id', $request->query('joId'))->update(['status' => "2"]);
        if($result) {

            return response()->json([
                'code' => 200,
                'msg'  => 'Job Order Approved Successfully!'
            ]);

        }else{

            return response()->json([
                'code' => 500,
                'msg'  => 'Job Order Approved Failed!'
            ]);

        }

    }

    public function jobOrderCancel(Request $request)
    {
        try {
            $date = date('Y-m-d');
            \DB::transaction(function () use ($date, $request) {
                \DB::table('job_order_masters')
                    ->where('id', $request->joId)
                    ->update(['status' => "3"]);

                \DB::table('job_order_details')
                    ->where('master_id', $request->joId)
                    ->update([
                        'item_status' => 'N',
                        'inactive_date' => $date,
                        'inactive_by' => Auth::user()->id,
                        'syn_status_date' => $date
                    ]);
            });

            return response()->json([
                'code'=> 200,
                'success' => true,
                'message' => 'Job Order cancelled successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error cancelling Job Order: ' . $e->getMessage()
            ], 500);
        }

           
        // $user = User::find(Auth::user()->id, ['email', 'name', 'head_id']);
        // $jo_master = JobOrderMaster::find($request->joId, ['job_order_number', 'sale_contract_id']);
        // $sale_contract = SaleContract::find($jo_master->sale_contract_id, ['invoice_no']);
        // $email_array = User::where('location_id', $jo_master->p_floor_id)
        //     ->pluck('email')
        //     ->toArray();

        // $desk_array = [];
        // if ($user->head_id) {
        //     $desk_array = User::where('head_id', $user->head_id)
        //         ->pluck('email')
        //         ->toArray();
        // }

        // $sending_mail_list = array_merge($email_array, $desk_array);
        // if (count($sending_mail_list) > 0) {
        //     $data = [
        //         'job_order_number' => $jo_master->job_order_number,
        //         'name' => $user->name,
        //         'email' => $user->email,
        //         'delivery_date' => $jo_master->delivery_date ?  $jo_master->delivery_date : null,
        //         'sale_contract' => $sale_contract->invoice_no,
        //         'sending_email_array' => $sending_mail_list
        //     ];
            
            
        // }

        // $this->updateKyvData($request->joId);

    }

    public function saveVatInfoDetails($id){
        
        $jobOrderMaster=JobOrderMaster::where('id',$id)->pluck('sale_contract_id');
        $sale_contact_id=$jobOrderMaster['0'];
        $sale_contract = SaleContract::find($sale_contact_id); 
        $sale_contract_details = SaleContract::where('sale_contracts.id',$sale_contact_id)
                            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.duplicate_name','ci_items.ci_item_rate','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contracts.ci_note','ci_items.ci_item_code','sale_contracts.invoice_no','sale_contracts.sales_contract_no',
                            DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                            DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                            DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                            DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.ccq) AS ccq')
                            )
                         ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                         ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                         ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                         ->orderBy('sale_contract_details.id')
                         ->get();

        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id=$sale_contact_id");

        foreach ($results as $key => $value){
           
             $total_net_weight=$value->total_net_weight_kg;

        }

        try { 

               $freight_cost=$sale_contract->freight_cost;
               $per_unit_freight=$freight_cost/$total_net_weight;
                          
            }catch (Exception $e) {


        }
        $jobOrderMaster=JobOrderMaster::where('id', $id)->first(['job_order_number','status']);   
        $total_amount=0;
        foreach($sale_contract_details as $key => $sale_contract_detail){
           
                try { 
                
                      if($sale_contract_detail->ci_factor!=0){

                             $per_net_weight_kg_fright=$per_unit_freight*$sale_contract_detail->net_weight_kg;
                             $caton_fright=$per_net_weight_kg_fright/$sale_contract_detail->ctn;
                             $carton_fright_pl_rate=round($caton_fright+$sale_contract_detail->rate_per_ctn, 3);
                            
                      }else{

                        $carton_fright_pl_rate="0";

                      }
                }catch (Exception $e) {
 
                } 

                $ci_rate=round($carton_fright_pl_rate*$sale_contract_detail->ctn,3);
                $vat = new Vat();
                $vat->job_order_number=str_replace("/","-",$jobOrderMaster->job_order_number);
                $vat->item_code=$sale_contract_detail->ci_item_code;
                $vat->item_Name=$sale_contract_detail->ci_item_name;
                $vat->invoice_no=$sale_contract_detail->invoice_no;
                $vat->sales_contact_no=$sale_contract_detail->sales_contract_no;
                $vat->rate=$carton_fright_pl_rate;
                $vat->status=$jobOrderMaster->status;
                $vat->save();

        }

        return 'Success';
        

    }

    

    public function jobOrderDetails(Request $request, $id){
       
        $id=\Crypt::decrypt($id);
        $jobOrderMasters=\DB::select("SELECT
                job_order_masters.note             AS NOTE,
                job_order_masters.job_order_number AS JOD_NUM,
                sale_contracts.party_address       AS address,
                job_order_masters.shipping_mask,
                job_order_masters.issue_date,
                job_order_masters.delivery_date,
                job_order_masters.best_before,
                job_order_masters.mfg_date,
                users.name,
                users.username,
                job_order_masters.created_at,
                job_order_masters.imp_by,
                sale_contracts.party_name          AS party_name,
                job_order_masters.distributed_by
            FROM job_order_masters
                JOIN users ON job_order_masters.user_id = users.id
                JOIN sale_contracts on sale_contracts.id = job_order_masters.sale_contract_id
            WHERE
                job_order_masters.id ='$id'");

        foreach ($jobOrderMasters as $key => $value) {
           
           $note=$value->NOTE;
           $job_number=$value->JOD_NUM;
           $issue_date=$value->issue_date;
           $delivery_date=$value->delivery_date;
           $mfg_date=$value->mfg_date;
           $party_name=$value->party_name;
           $address=$value->address;
           $name=$value->name;
           $shipping_mask=$value->shipping_mask;
           $username=$value->username;
           $create_date=$value->created_at;
           $best_before=$value->best_before;
           $imp_by=$value->imp_by;
           $distributed_by=$value->distributed_by;

        }
        $create_date="";
        if($create_date){
        
            $create_date=date("Y-m-d",strtotime($create_date));

        }
        
        $jobOrderDetails=\DB::select("SELECT job_order_masters.mfg_date,job_order_masters.delivery_date,job_order_masters.issue_date,ci_items.ci_item_name,ci_items.ci_item_code,job_order_details.self_life,job_order_details.exp_date,job_order_details.qty,job_order_details.sale_contact_qty,dunits.dunit_name,runits.runit_name,job_order_details.orqt,job_order_details.smqt,job_order_details.coding_matter,job_order_details.sreq,job_order_details.rate,job_order_details.exp_date,job_order_masters.batch_number, ci_items.factor FROM job_order_masters 
            JOIN job_order_details ON job_order_masters.id = job_order_details.master_id
            JOIN ci_items ON ci_items.id=job_order_details.item_id
            LEFT JOIN dunits ON dunits.id=job_order_details.du_unit
            LEFT JOIN runits ON runits.id=job_order_details.ru_unit
            WHERE job_order_masters.id='$id' AND job_order_details.item_status='Y'");

        return view('job_order.job_order_report')
                 ->with('jobOrderDetails', $jobOrderDetails)
                 ->with('note',$note)
                 ->with('job_number', $job_number)
                 ->with('job_number', $job_number)
                 ->with('issue_date', $issue_date)
                 ->with('delivery_date', $delivery_date)
                 ->with('mfg_date', $mfg_date)
                 ->with('name', $name)
                 ->with('shipping_mask', $shipping_mask)
                 ->with('username', $username)
                 ->with('create_date', $create_date)
                 ->with('best_before', $best_before)
                 ->with('imp_by', $imp_by)
                 ->with('party_name', $party_name)
                 ->with('address', $address)
                 ->with('distributed_by',$distributed_by);

    }

    public function factoryJOReport($id){
    
        $prod_floor_id='';
        if(User::where('id',Auth::user()->id)->exists()){
           
            $user=User::where('id',Auth::user()->id)->first(['location_id']); 
            $prod_floor_id=$user->location_id;     

        }

        

        $jobOrderMasters=\DB::select("SELECT
                job_order_masters.note AS NOTE,
                job_order_masters.job_order_number AS JOD_NUM,
                sale_contracts.party_address AS address,
                job_order_masters.shipping_mask,
                job_order_masters.issue_date,
                job_order_masters.delivery_date,
                job_order_masters.best_before,
                job_order_masters.mfg_date,
                users.name,
                users.username,
                job_order_masters.created_at,
                job_order_masters.imp_by,
                sale_contracts.party_name AS party_name,
                job_order_masters.distributed_by
            FROM job_order_masters
            JOIN sale_contracts on sale_contracts.id=job_order_masters.sale_contract_id
            JOIN users ON job_order_masters.user_id=users.id
            WHERE
                job_order_masters.id='$id'");

        foreach ($jobOrderMasters as $key => $value) {
           
           $note=$value->NOTE;
           $job_number=$value->JOD_NUM;
           $issue_date=$value->issue_date;
           $delivery_date=$value->delivery_date;
           $mfg_date=$value->mfg_date;
           $party_name=$value->party_name;
           $address=$value->address;
           $name=$value->name;
           $shipping_mask=$value->shipping_mask;
           $username=$value->username;
           $create_date=$value->created_at;
           $best_before=$value->best_before;
           $imp_by=$value->imp_by;
           $distributed_by=$value->distributed_by;

        }

        $create_date=date("Y-m-d",strtotime($create_date));
        $jobOrderDetails=\DB::select("SELECT job_order_masters.mfg_date,job_order_masters.delivery_date,job_order_masters.issue_date,ci_items.ci_item_name,ci_items.ci_item_code,job_order_details.self_life,job_order_details.exp_date,job_order_details.qty,job_order_details.sale_contact_qty,dunits.dunit_name,runits.runit_name,job_order_details.orqt,job_order_details.smqt,job_order_details.coding_matter,job_order_details.sreq,job_order_details.rate,job_order_details.exp_date,job_order_masters.batch_number, ci_items.factor FROM job_order_masters 
            JOIN job_order_details ON job_order_masters.id = job_order_details.master_id
            JOIN ci_items ON ci_items.id=job_order_details.item_id
            LEFT JOIN dunits ON dunits.id=job_order_details.du_unit
            LEFT JOIN runits ON runits.id=job_order_details.ru_unit
            WHERE job_order_masters.id='$id' 
              AND job_order_details.item_status='Y'
              AND job_order_masters.p_floor_id='$prod_floor_id'");

        return view('job_order.job_order_report')
                 ->with('jobOrderDetails', $jobOrderDetails)
                 ->with('note',$note)
                 ->with('job_number', $job_number)
                 ->with('job_number', $job_number)
                 ->with('issue_date', $issue_date)
                 ->with('delivery_date', $delivery_date)
                 ->with('mfg_date', $mfg_date)
                 ->with('address', $address)
                 ->with('name', $name)
                 ->with('shipping_mask', $shipping_mask)
                 ->with('username', $username)
                 ->with('create_date', $create_date)
                 ->with('best_before', $best_before)
                 ->with('imp_by', $imp_by)
                 ->with('party_name', $party_name)
                 ->with('distributed_by',$distributed_by);

    }

    public function factorySCReport($id){

        $sale_contract = SaleContract::find($id);
        $company_id=$sale_contract->company_id;
        $factory_address_type_id=$sale_contract->factory_address_type;
        $companyDetails=DB::table('companies')
            ->where('id', $company_id)
            ->get();
        foreach ($companyDetails as $key => $value) {
           
           $factory_address=$value->factory_address;
           $factory_address_details=$value->factory_address_details;

        }

        if($factory_address_type_id==1){
          
          $factory_address=$factory_address; 

        }else if($factory_address_type_id==2)
        {
         
         $factory_address=$factory_address_details; 

        }else{
        
         $factory_address="";

        }  
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')
            ->get(); 
        $nocs_array=$this->create_nocs($sale_contract_details);                         
        return view("production.factory_sc_report",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('nocs_array', $nocs_array)
               ->with('factory_address', $factory_address);

    }

    private function create_nocs($sale_contract_details){

         
        $value_array=array();
        foreach ($sale_contract_details as $key => $sale_contract_detail) {


            array_push($value_array, $sale_contract_detail->ctn);

        }

        $next=0;
        $result_array=array();
        $sum=0;
        $prv=1;

        for($i=0; $i<count($value_array) ; $i++) {
        $sum=$sum+$value_array[$i];
        array_push($result_array, $prv.'-'.$sum);
        $prv=$sum+1;
            
        }
        return $result_array;

    }

    public function checkDoBalance(Request $request){
            
            $jo_approve_status=JobOrderMaster::where('id',$request->jo_id)->first(['bbm_status']);
            if($jo_approve_status->bbm_status=='Y'){

                return response()->json([
    
                    'credit_limit'=>0,
                    'blance'=>0,
                    'undelivered'=>0,
                    'rate'=>0,
                    'status'=>'success',
                    'check_status'=>$jo_approve_status->bbm_status

                ]);

            }
            $party_code=$request->party_code;
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'http://runner.prangroup.com:4005/api/expssapi',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
              "actionName":"EXPORT_BAL",
              "ComId":"PRAN",
              "Param1": "'.$party_code.'",
              "Param2": "",
              "Param3": "",
              "Param4": "",
              "Param5": "",
              "Param6": "",
              "Param7": "",
              "Param8": ""
            }',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'ss: Alok',
                'yy: HJDyh876Yhdsf543GDJksn'
              ),
            ));
            
            $response = curl_exec($curl);
            curl_close($curl);
            if(isset($response)){
    
               $result=json_decode($response);  
               foreach($result as $val){
                 
                    $check_status='';
                    $check=round($val->CR_LIM-($val->DO_ABAL+$val->UBAL+$request->total_balance),3);
                    if($request->total_balance < 1){  

                        $check_status='Y';

                    }elseif($jo_approve_status->bbm_status=='Y'){

                        return $check_status='Y';

                    }elseif($check > 0){
                    
                        $check_status='Y';
    
                    }elseif($check < 0){
                    
                        $check_status='N';
    
                    } 
                
                    return response()->json([
    
                        'credit_limit'=>$val->CR_LIM,
                        'blance'=>$val->DO_ABAL,
                        'undelivered'=>$val->UBAL,
                        'rate'=>$val->USD_RATE,
                        'status'=>'success',
                        'check_status'=>$check_status
    
                    ]);
                        
               } 
    
            }else{
                
              return response()->json([
    
                  'status'=>'error'
              ]); 
    
            } 

    }

    public function doCreateView(Request $request){
         
        ini_set('memory_limit', -1); 
        $id = base64_decode($request->query('joid'));
        $jobHeaderInfo = \DB::table('job_order_masters')
            ->join('notify_parties', 'notify_parties.id', '=', 'job_order_masters.importer_id')
            ->join('sale_contracts', 'sale_contracts.id', '=', 'job_order_masters.sale_contract_id')
            ->select(
                'job_order_masters.id',
                'notify_parties.code',
                'notify_parties.name',
                'notify_parties.address',
                'job_order_masters.shipping_mask',
                'job_order_masters.note',
                'job_order_masters.issue_date',
                'job_order_masters.delivery_date',
                'job_order_masters.mfg_date_orginal as mfg_date',
                'job_order_masters.mfg_date_orginal', 
                'job_order_masters.imp_by',
                'job_order_masters.best_before', 
                'job_order_masters.distributed_by',
                'job_order_masters.batch_number',
                'job_order_masters.job_order_number',
                'sale_contracts.sales_contract_no',
                'sale_contracts.invoice_no as invoice_no',
                'sale_contracts.id as sales_contract_id',
                'job_order_masters.wh_id'
            )
            ->where('job_order_masters.id', $id)
            ->first();


        $jobItemDetails = DB::table('job_order_masters')
            ->join('job_order_details', 'job_order_details.master_id', '=', 'job_order_masters.id')
            ->join('ci_items', 'ci_items.id', '=', 'job_order_details.item_id')
            ->select(
                'job_order_details.id',
                'job_order_details.item_id',
                'ci_items.ci_item_code',
                'ci_items.ci_item_name',
                'job_order_details.self_life as self_line',
                'job_order_details.exp_date',
                'job_order_details.qty',
                'job_order_details.sale_contact_qty as pcs_in_ctn',
                'job_order_details.du_unit',
                'job_order_details.ru_unit',
                'job_order_details.orqt as orqt',
                'job_order_details.smqt as sample_qty',
                'job_order_details.do_qty as do_qty',
                DB::raw('SUM(job_order_details.orqt - job_order_details.do_qty) as balance'),
                'job_order_details.coding_matter as coding_mater',
                'job_order_details.sreq as special_requirment',
                'job_order_details.rate',
                'ci_items.ci_factor as factor',
                'job_order_details.factory',
                'job_order_details.wh_id',
                'job_order_details.id as line_id',
                'job_order_details.rate_status as rate_status'
            )
            ->where('job_order_masters.id', $id)
            ->where('job_order_details.item_status', 'Y')
            ->groupBy(
                'job_order_details.id',
                'job_order_details.item_id',
                'ci_items.ci_item_code',
                'ci_items.ci_item_name',
                'job_order_details.self_life',
                'job_order_details.exp_date',
                'job_order_details.qty',
                'job_order_details.sale_contact_qty',
                'job_order_details.du_unit',
                'job_order_details.ru_unit',
                'job_order_details.orqt',
                'job_order_details.smqt',
                'job_order_details.do_qty',
                'job_order_details.coding_matter',
                'job_order_details.sreq',
                'job_order_details.rate',
                'ci_items.ci_factor',
                'job_order_details.factory',
                'job_order_details.wh_id',
                'job_order_details.rate_status'
            )->get();
 

        $result=JobOrderMaster::findorfail($id);
        $jobOrderNumber=explode("/",$result->job_order_number);
        $dunits=Dunit::all();
        $runits=Runit::all();
        $depots=ProductionFloor::where('status',1)->get(); 
        $jobOrderMaster=JobOrderMaster::where('id',$id)->first(['sale_contract_id']);
        $salesContact=SaleContract::where('id',$jobOrderMaster->sale_contract_id)->first(['id','invoice_no']);
        return view('job_order_quick.do_create')
               ->with('jobHeaderInfo', $jobHeaderInfo)
               ->with('depots', $depots)
               ->with('jobOrderNumber', $jobOrderNumber['0'])
               ->with('jobItemDetails', $jobItemDetails)
               ->with('dunits', $dunits)
               ->with('runits', $runits)
               ->with('salesContact', $salesContact)
               ->with('id', $id);

    }

    public function createDO(Request $request)
    {   

        try {
            $infoDetails = $request->input('info_details');
            $depotGroups = [];
            foreach ($infoDetails as $item) {
                $depotId = $item['depot'];
                if (!isset($depotGroups[$depotId])) {
                    $depotGroups[$depotId] = [];
                }
                $depotGroups[$depotId][] = $item;
            }

            $doNumbers = [];
            $parts = explode('-', $request->job_order_no);
            $job_order_no = implode('-', array_slice($parts, 1));
            $invoice_no = SaleContract::where('id', $request->sc_id)->value('invoice_no');
            $user_id = Auth::user()->id;
            $staff_id = User::where('id', $user_id)->value('username');
            
            foreach ($depotGroups as $depotId => $depotItems) {
                $warehouse = ProductionFloor::where('id', $depotId)->first(['p_code','short_name']);
                $array = [];
                $array['DISTID'] = $request->party_code;
                $array['NOTE'] = $invoice_no;
                $array['DOCNO'] = $job_order_no;
                $array['SHIPPING'] = $request->shipping_mark;
                $array['CURRENCY'] = $request->currency_rate;
                $array['IUSER'] = $staff_id;

                $data_array = [];
                foreach ($depotItems as $item) {
                    $dunit = Dunit::where('id', $item['du_unit'])->value('id');
                    $runit = Runit::where('id', $item['ru_unit'])->value('id');
                    
                    $data_array[] = [
                        'ITEM_ID' => $item['item_code'],
                        'QTY' => $item['do_qty'],
                        'S_QTY' => $item['smqt'],
                        'RATE' => $item['rate'],
                        'DUFACT' => $item['du_unit'],
                        'WH_ID' => $warehouse->p_code,
                        'LINE_NOTE' => "Batch_Number:" . $request->batch_number . ',' . "Self_Life" . $item['self_life'] . ',' . "Dunit:" . $dunit . ',' . "Runit:" . $runit . ','
                    ];
                }

                $array['data'] = $data_array;
                $url = 'http://runner.prangroup.com:4005/api/dox';
                $headers = [
                    "Content-type: application/json",
                    "ss: Alok",
                    "yy: HJDyh876Yhdsf543GDJksn"
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FAILONERROR, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);
                
                if (curl_error($ch)) {
                    throw new \Exception('CURL Error: ' . curl_error($ch));
                }

                curl_close($ch);
                $x = json_decode($response, true);
                if (isset($x['DOdt'][0]['DO_NO'])) {
                    $doNumber = $x['DOdt'][0]['DO_NO'];
                    $status = $x['Status'];
                    $remark = $x['Remarks'];
                    
                    if ($status == "OK") {
                        foreach ($depotItems as $item) {
                            DB::table('do_history')->insert([
                                'job_order_id' => $request->job_order_id,
                                'do_number' => $doNumber,
                                'depot_id' => $depotId,
                                'depot_code' => $warehouse->p_code,
                                'item_code' => $item['item_code'],
                                'item_name' => $item['item_name'],
                                'do_qty' => $item['do_qty'],
                                'smpl_qty' => $item['smqt'],
                                'rate' => $item['rate'],
                                'line_id' => $item['line_id'],
                                'status' => $status,
                                'remark' => $remark,
                                'created_by' => Auth::user()->id,
                                'created_date' => date('Y-m-d'),
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);

                            DB::table('job_order_details')
                                ->where('id', $item['line_id'])
                                ->update([
                                    'do_qty' => DB::raw('COALESCE(do_qty, 0) + '. (int)$item['do_qty']),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                    'wh_id'=>$depotId
                                ]);
                        }

                        $doNumbers[] = [
                            'depot_id' => $depotId,
                            'depot_name' => $warehouse->short_name,
                            'depot_code' => $warehouse->p_code,
                            'do_number' => $doNumber,
                            'items' => $depotItems // Include items for email template
                        ];

                        // Update job order master
                        DB::table('job_order_masters')
                            ->where('id', $request->job_order_id)
                            ->update([
                                'job_order_do_status' => $status,
                                'job_order_do_remark' => $remark,
                                'job_order_do_creator' => Auth::user()->id,
                                'job_order_do_date' => date('Y-m-d'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);
                    }
                } else {
                    throw new \Exception('DO creation failed for depot: ' . $warehouse->short_name);
                }
            }

            // Send emails after all DOs are created
            $this->sendDOEmails($doNumbers, $request);
            return response()->json([
                'status' => 'success',
                'message' => 'DO created successfully for all depots!',
                'do_numbers' => $doNumbers
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create DO: ' . $e->getMessage()
            ], 500);
        }
    }

    private function sendDOEmails($doNumbers, $request)
    {
        try {
            foreach ($doNumbers as $doInfo) {

                $email_array = array();
                $warehouse = ProductionFloor::where('id', $doInfo['depot_id'])->first(['p_code', 'short_name']);
                // Get warehouse users emails
                $warehouseUsers = User::where('location_id', $doInfo['depot_id'])
                                    ->where('type_id', 3)
                                    ->whereNotNull('email')
                                    ->pluck('email')
                                    ->toArray();
                
                $email_array = array_merge($email_array, $warehouseUsers);
                // Add current user email
                $user_email = Auth::user()->email;
                if (!in_array($user_email, $email_array)) {
                    $email_array[] = $user_email;
                }

                if(count($email_array) > 0) {

                    $invoice_no = SaleContract::where('id', $request->sc_id)->value('invoice_no');
                    $mailData = [
                        'do_number' => $doInfo['do_number'],
                        'depot_name' => $doInfo['depot_name'],
                        'depot_short_name' => isset($warehouse->short_name) ? $warehouse->short_name : $doInfo['depot_name'],
                        'depot_code' => $doInfo['depot_code'],
                        'job_order_no' => $request->job_order_no,
                        'invoice_no' => $invoice_no,
                        'created_by' => Auth::user()->name,
                        'created_date' => date('Y-m-d H:i:s'),
                        'shipping_mark' => isset($request->shipping_mark) ? $request->shipping_mark : '',
                        'batch_number' => isset($request->batch_number) ? $request->batch_number : '',
                        'items' => isset($doInfo['items']) ? $doInfo['items'] : array(),
                        'user_email' => $user_email,
                        'party_code' => isset($request->party_code) ? $request->party_code : ''
                    ];

                    $from_email = 'Job-Order-Mail@prangroup.com';
                    Mail::send('mail.do_mail_template', $mailData, function($message) use ($from_email, $mailData, $email_array) {
                        $message->from($from_email, 'DO Creation Notification');
                        $message->to($email_array);
                        $message->subject('DO Creation Notification - ' . $mailData['do_number'] . ' - Invoice No: ' . $mailData['invoice_no']);
                    });

                }
            }

        } catch (\Exception $e) {
            \Log::error('DO Email sending failed: ' . $e->getMessage());
        }
    }

    private function updateDashboardHistory($sale_contact_id,$type){

        if($type==1){
           
            LandPortDashboard::where('sc_id',$sale_contact_id)->where('Task_ID',1)->update([
                'action_date'=>date('Y-m-d')
            ]);
    
            seaPortdashboard::where('sc_id',$sale_contact_id)->where('Task_ID',1)->update([
                'action_date'=>date('Y-m-d')
            ]);  

        }else if($type==2){

            LandPortDashboard::where('sc_id',$sale_contact_id)->where('Task_ID',8)->update([
                'action_date'=>date('Y-m-d')
            ]);
    
            seaPortdashboard::where('sc_id',$sale_contact_id)->where('Task_ID',8)->update([
                'action_date'=>date('Y-m-d')
            ]);

        }
       

    }


    public function deskWiseNotifyPartyList(Request $request){
        
        $user_id=Auth::user()->id;
        $area_ids=UserArea::where('user_id',$user_id)->pluck('area_id')->toArray();
        $notify_parties = NotifyParty::whereIn('area_id',$area_ids)->get();  
        return view("job_order.desh_wise_notify_party")
            ->with('notify_parties',$notify_parties);        

    }

    public function notifyPartyJobOrderList($id){

        $id=\Crypt::decrypt($id);
        $previousDate=date('Y-m-d', strtotime('-3 month'));
        $currentDate=date('Y-m-01', strtotime($previousDate));
        $jobOrderMasters=\DB::select("SELECT
                            job_order_masters.id,
                            job_order_masters.job_order_number,
                            notify_parties.code,
                            notify_parties.address,
                            sale_contracts.invoice_no,
                            job_order_masters.status,
                            notify_parties.name,
                            job_order_masters.job_order_do_status,
                            job_order_masters.job_order_do_number,
                            concat(production_floors.p_code,'-',production_floors.short_name) as prod_floor,
                            concat(depots.d_code,'-',depots.d_name) as out_depo,
                            production_floors.p_code,
                            case when job_order_masters.job_order_do_status is null then 'DO' else 'Done' end as 'order_by'
                    FROM job_order_masters
                    JOIN production_floors on production_floors.id=job_order_masters.p_floor_id
                    JOIN notify_parties ON job_order_masters.importer_id = notify_parties.id
                    JOIN sale_contracts ON sale_contracts.id = job_order_masters.sale_contract_id
                    LEFT JOIN depots ON depots.d_code=job_order_masters.wh_id
                    WHERE job_order_masters.importer_id='$id' and job_order_masters.status!=3
                    ORDER BY order_by ASC");
                    
        return view('job_order.desh_wise_jo')
               ->with('jobOrderMasters', $jobOrderMasters)
               ->with('party_id',$id);

    }

    public function jobOrderAddItemEditOption(Request $request){
         
        $sale_contract=JobOrderMaster::where('job_order_number', $request->job_number)->first(['sale_contract_id']);
        $salesContactItems=\DB::select("SELECT
            ci_items.id AS item_id,
            sale_contracts.sales_contract_no,
            ci_items.ci_item_code,
            ci_items.ci_item_name
        FROM
            sale_contracts
        JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
        JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
        WHERE
            sale_contracts.id = '$sale_contract->sale_contract_id' AND sale_contract_details.rate_status='Y'");

        $jobOrder=JobOrderMaster::where('job_order_number',$request->job_number)->first(['wh_id']); 
        $depo=Depot::where('id',$jobOrder->wh_id)->get();
        return $array=array($salesContactItems, $request->job_number, $depo, $sale_contract->sale_contract_id);

    }

    public function jobOrderRateMatching(Request $request){ 
  
        $results = $this->checkItemRateMatching($request);
        $itemStatuses = SaleContractDetail::where('sale_contract_id', $request->id)
            ->join('ci_items', 'sale_contract_details.ci_item_id', '=', 'ci_items.id')
            ->select(
                'ci_items.ci_item_code as item_code',
                'sale_contract_details.rate_status',
                'sale_contract_details.rate_percent',
                'sale_contract_details.per_piece_rate',
                'sale_contract_details.prime_cost'
            )
            ->get()
            ->map(function($item) {
                return [
                    'item_code' => $item->item_code,
                    'status' => $this->mapStatusToFrontend($item->rate_status),
                    'message' => $this->getStatusMessage($item->rate_status, $item->rate_percent),
                    'rate_percent' => $item->rate_percent,
                    'per_piece_rate' => $item->per_piece_rate,
                    'prime_cost' => $item->prime_cost
                ];
            })
            ->toArray();

        if($results == "Md") {

            $updateExistOrNot = \DB::table('sale_contracts')->where('id', $request->id)->update(['show_status' => "M", 'matching_status' => "2"]);  
            return response()->json([
                'overall_status' => 'needs_approval',
                'approval_type' => 'Md',
                'item_statuses' => $itemStatuses,
                'message' => 'Items are not Verified, Need MD(PRAN) approval..!!'
            ]);

        } else if($results == "Ed") {

            $updateExistOrNot = \DB::table('sale_contracts')->where('id', $request->id)->update(['show_status' => "E", 'matching_status' => "2"]);
            return response()->json([
                'overall_status' => 'needs_approval',
                'approval_type' => 'Ed',
                'item_statuses' => $itemStatuses,
                'message' => 'Items are not Verified, Need ED(Export) approval..!!'
            ]);

        } else if($results == "S") {

            $updateExistOrNot = \DB::table('sale_contracts')->where('id', $request->id)->update(['show_status' => "S", 'matching_status' => "2"]);
            return response()->json([
                'overall_status' => 'needs_approval', 
                'approval_type' => 'S',
                'item_statuses' => $itemStatuses,
                'message' => 'Items are not Verified, Need Samia madam approval..!!!'
            ]);

        } else if($results == "success") {

            $updateExistOrNot = \DB::table('sale_contracts')->where('id', $request->id)->update(['matching_status' => "1"]);

            return response()->json([
                'overall_status' => 'success',
                'item_statuses' => $itemStatuses,
                'message' => 'Rate verifying successfully Done..!!'
            ]);
        }
    }

    private function checkItemRateMatching($request){
    
        $second_approval = NotifyParty::where('id', SaleContract::where('id', $request->id)->value('notify_pary_id'))->value('second_approval');
        $matchingInfo = $request->input('matching_info');
        $allowPercent = ApprovePercent::where('id', '1')->first(['min_percent', 'max_percent']);
        $itemResults = []; // Store individual item results for response
        
        foreach($matchingInfo as $item) {

            $item_code = $item['item_code'];
            $ciItem = CiItem::where('ci_item_code', $item['item_code'])->first(['id']);
            $item_rate = $item['rate']; 
            $depo_code = $item['depo_code'];
            $line_id =  $item['line_id'];           
            
            // Check if this item is still pending (only verify pending items)
            $checkMatchingStatus = SaleContractDetail::where('id', $line_id)->first(['rate_status']);
            
            // Only process if status is null (pending) or if you want to reprocess, remove this check
            if(is_null($checkMatchingStatus->rate_status)) {
                
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://runner.prangroup.com:4005/api/expssapi',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                        "actionName": "ITEM_CHECK",
                        "ComId": "PRAN",
                        "Param1": "'.$item_code.'",
                        "Param2": "'.$depo_code.'",
                        "Param3": "'.$item_rate.'",
                        "Param4": "",
                        "Param5": "",
                        "Param6": "",
                        "Param7": "",
                        "Param8": ""
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'ss: Alok',
                        'yy: HJDyh876Yhdsf543GDJksn'
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                $result = json_decode($response);
                
                if(!empty($result)) {

                    foreach($result as $val) {

                        $status = 'Y';
                        $percent = 0;
                        if($val->XX > 0) {

                            $percent = round((($item_rate - $val->XX) / $item_rate) * 100, 3);
                            if($percent > $allowPercent->min_percent && $percent <= $allowPercent->max_percent) {

                                if($second_approval == 316) {

                                    $status = 'S';

                                } else {

                                    $status = 'E'; 
                                }

                            } elseif($percent <= $allowPercent->min_percent) {

                                $status = 'M';

                            } elseif($percent > $allowPercent->max_percent) {

                                $status = 'Y';  

                            }
                        }

                        $scDetails = SaleContractDetail::findorfail($line_id);
                        $scDetails->rate_status = $status;
                        $scDetails->rate_percent = $percent;
                        $scDetails->per_piece_rate = $item_rate;
                        $scDetails->prime_cost = $val->XX;
                        $scDetails->wh_id = ProductionFloor::where('p_code',$depo_code)->value('id');
                        $scDetails->save();

                    }

                } else {
                    
                    // API returned empty response
                    $ci_item = CiItem::where('ci_item_code', $item['item_code'])->first(['id']); 
                    $scDetails = SaleContractDetail::findorfail($line_id);
                    $scDetails->rate_status = 'Y';
                    $scDetails->rate_percent = 0;
                    $scDetails->per_piece_rate = $item_rate;
                    $scDetails->prime_cost = 0;
                    $scDetails->wh_id = ProductionFloor::where('p_code',$depo_code)->value('id');
                    $scDetails->save();

                }
            }
        }

        // Update job order master
        $job_order_master = SaleContract::findorfail($request->id);
        $job_order_master->matching_status = 0;
        $job_order_master->save();

        // Determine overall status based on ALL items (including previously verified)
        $rateMatchingMdStatus = SaleContractDetail::where('sale_contract_id', $request->id)
            ->where('rate_status', 'M')
            ->count();

        $rateMatchingOtherStatus = SaleContractDetail::where('sale_contract_id', $request->id)
            ->where('rate_status', 'S')
            ->count();       

        $rateMatchingEDStatus = SaleContractDetail::where('sale_contract_id', $request->id)
            ->where('rate_status', 'E')
            ->where('rate_status', '!=', 'M')
            ->where('rate_status', '!=', 'S')
            ->count(); 

        if($rateMatchingMdStatus > 0) {
            return 'Md';
        } elseif($rateMatchingEDStatus > 0) {
            return 'Ed';
        } elseif($rateMatchingOtherStatus > 0) {
            return 'S';
        } else {
            return 'success';
        }
    }

    private function mapStatusToFrontend($backendStatus)
    {
        $statusMap = [
            'Y' => 'verified',        // Verified
            'M' => 'needs_approval',  // Needs MD approval
            'E' => 'needs_approval',  // Needs ED approval  
            'S' => 'needs_approval',  // Needs Samia approval
            null => 'pending'         // Not checked yet
        ];
        
        if (array_key_exists($backendStatus, $statusMap)) {
            return $statusMap[$backendStatus];
        } else {
            return 'failed';
        }
    }


    private function getStatusMessage($status, $percent = null)
    {
        $messages = [
            'Y' => 'Verified',
            'M' => 'Needs Approval',
            'E' => 'Needs Approval',
            'S' => 'Needs Approval',
            null => 'Pending'
        ];

        if (array_key_exists($status, $messages)) {
            return $messages[$status];
        } else {
            return 'Verification failed';
        }
    }


    public function rateMatchingView(Request $request){
         
        $length=count($request->matching_info);
        $item_ids=array();
        for ($i=0; $i<count($request->matching_info); $i++) {
           
           $ciItem=CiItem::where('ci_item_code',$request->matching_info[$i]['item_code'])->first(['id']);
           array_push($item_ids,$ciItem->id);
        }

        $ids = join(', ', $item_ids); 
        return $results=DB::select("SELECT
                        ci_items.id,
                        ci_items.ci_item_code,
                        ci_items.ci_item_name,
                        sale_contract_details.per_piece_rate,
                        if(sale_contract_details.prime_cost is null ,'',sale_contract_details.prime_cost) as prime_cost,
                        COALESCE(sale_contract_details.rate_percent,0) as rate_percent,
                        (case when sale_contract_details.rate_status='E' then 'Ed'
                        when sale_contract_details.rate_status ='M' then 'Md'
                        when sale_contract_details.rate_status ='S' then 'Samia'
                        when sale_contract_details.rate_status ='Y' then 'Y'
                        else '' end) as rate_status
                    FROM
                        sale_contracts
                    JOIN sale_contract_details ON sale_contract_details.sale_contract_id = sale_contracts.id
                    JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                    WHERE sale_contracts.id='$request->id' AND sale_contract_details.ci_item_id IN ($ids)");

    }

    public function sendingApprovalMail(Request $request){
        
        $results=$this->sendingMailFun($request);
        if($results=="Md"){
            
          $updateExistOrNot=\DB::table('sale_contracts')->where('id',$request->id)
         ->update(['show_status'=>"M",'matching_status'=>"2",'mail_status'=>"Y"]);  
          return $results;

        }else if($results=="Ed"){
          
          $updateExistOrNot=\DB::table('sale_contracts')->where('id',$request->id)
          ->update(['show_status'=>"E",'matching_status'=>"2",'mail_status'=>"Y"]);

          return $results;

        }else if($results=="S"){
          
            $updateExistOrNot=\DB::table('sale_contracts')->where('id',$request->id)
            ->update(['show_status'=>"S",'matching_status'=>"2",'mail_status'=>"Y"]);
  
            return $results;
  
        }else{
          
          return $results;
           
        }


    }

    private function sendingMailFun($request){

        $length=count($request->matching_info);
        $item_ids=$request->matching_info;
        $warehouse=Depot::where('id', $request->wh_id)->first(['d_code','d_name']);
        $wh=$warehouse->d_code.'-'.$warehouse->d_name;
        $rateMatchingEDStatus=SaleContractDetail::where('sale_contract_id',$request->id)
            ->where('rate_status','E')
            ->where('rate_status','!=','M')
            ->where('rate_status','!=','S')
            ->get();
             
        $rateMatchingMdStatus=SaleContractDetail::where('sale_contract_id',$request->id)
            ->where('rate_status','M')
            ->get();

        $rateMatchingOtherStatus=SaleContractDetail::where('sale_contract_id',$request->id)
            ->where('rate_status','S')
            ->get();             
        
         

        $checkingMatchingItemStatus=DB::select("SELECT
            (CASE WHEN count1 = count2 THEN 'Y' ELSE 'N' END) as status FROM(
            SELECT (SELECT COUNT(sale_contract_details.id) 
            FROM sale_contract_details
            WHERE
                sale_contract_details.sale_contract_id ='$request->id' 
                AND sale_contract_details.rate_status!='M'
                AND sale_contract_details.rate_status!='E'
                AND sale_contract_details.rate_status!='S'
                AND sale_contract_details.rate_status ='Y'
                AND (sale_contract_details.rate_status IS NOT NULL OR sale_contract_details.rate_status != '')) AS count1,(SELECT COUNT(sale_contract_details.id) FROM sale_contract_details
            WHERE sale_contract_details.sale_contract_id ='$request->id') AS count2) AS counts");

        $checkMatchingItemStatus=$checkingMatchingItemStatus[0]->status;
        $mailStaus=SaleContract::where('id', $request->id)->first(['mail_status']);
        
        if($checkMatchingItemStatus=='Y'){
            
          return "Am";  //Ns=Not matching 

        }
        elseif(!is_null($mailStaus->mail_status)){

           return 'As';  //As=already send

        }elseif(count($rateMatchingMdStatus)>0) {

           $this->sendMailToMdSir($request->id,$rateMatchingMdStatus,$item_ids,$wh);
           return 'Md';

        }elseif(count($rateMatchingEDStatus)>0){
           
           
           $this->sendMailToEdSir($request->id,$rateMatchingEDStatus,$item_ids,$wh);
           return 'Ed';

        }elseif(count($rateMatchingOtherStatus)>0){
           
           
            $this->sendManagementMail($request->id,$rateMatchingEDStatus,$item_ids,$wh);
            return 'S';
 
        }else{

            return 'success';
        }

    }

    private function sendMailToMdSir($id,$data,$item_ids,$wh){
         
        $sale_contract=SaleContract::where('id',$id)->first(['importer_id','notify_pary_id','sales_contract_no','invoice_no','creator_id']);
        $importer_id=$sale_contract->importer_id;
        $notify_pary_id=$sale_contract->notify_pary_id;
        $invoice_no=$sale_contract->invoice_no;
        $user=User::where('id',$sale_contract->creator_id)->first(['name','username','email']);
        $created_by=$user->username.'-'.$user->name;

        $notify_party=NotifyParty::findorfail($notify_pary_id);
        $notify_party_name=$notify_party->name;
        $notify_party_address=$notify_party->address;
        $party_code=$notify_party->code;
        $country=$notify_party->country;  

        $importer=Importer::findorfail($importer_id);
        $importer_name=$importer->name;
        $importer_address=$importer->address;

        $name="";
        $address="";

        if($importer_name=="N/A"){

            $name=$notify_party_name;
            $address=$notify_party_address;

        }else{

            $name=$importer_name;
            $address=$importer_address; 

        }

        $allowPercent=ApprovePercent::where('id','1')->first(['min_percent','max_percent']);
        $email_array=array();
        $results=DB::select("SELECT
                        ci_items.ci_item_code,
                        ci_items.ci_item_name,
                        coalesce(NULL,sale_contract_details.rate_status,'') AS rate_status,
                        sale_contract_details.per_piece_rate,
                        sale_contract_details.rate_percent,
                        sale_contract_details.prime_cost,
                        notify_parties.name as notify_party,
                        bus.name AS bu_name,
                        notify_parties.country
                    FROM
                        sale_contracts
                    JOIN sale_contract_details ON sale_contract_details.sale_contract_id = sale_contracts.id
                    JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                    JOIN bus ON bus.id=ci_items.bu_id
                    JOIN notify_parties ON notify_parties.id=sale_contracts.notify_pary_id
                    where sale_contracts.id = '$id' AND sale_contract_details.rate_status!='Y' AND (sale_contract_details.rate_status='M' OR sale_contract_details.rate_status='E')");

        array_push($email_array,'md@prangroup.com');
        // array_push($email_array,'finance@prangroup.com');
        // array_push($email_array,'md@prangroup.com');
        $jo_notification_mail_lists = MailList::where('is_active',1)->where('jo_notification',1)->pluck('email')->toArray();
        array_push($jo_notification_mail_lists,$user->email); 
        $data = array(
             'results'=>$results,
             'notify_party_name'=>$name,
             'notify_party_address'=>$address,
             'sc_number'=>$sale_contract->sales_contract_no,
             'receiver_email'=>$email_array,
             'allowPercent'=>$allowPercent,
             'party_code'=>$party_code,
             'invoice_no'=>$invoice_no,
             'created_by'=>$created_by,
             'jo_notification_mail_lists'=>$jo_notification_mail_lists,
             'subject'=>"JOB-Order-Approval,"." Invoice : ".$invoice_no,
             'subject2'=>"Export Item Price status with Prime Cost",
             'warehouse'=>$wh,
             'country'=>$country
            ); 

        $this->sendMdMail($data);
        $this->sendNotificationMail($data);  

    }

    
    private function sendMdMail($data){
          
        $from_mail=env('MAIL_FROM_ADDRESS');
        Mail::send('md_approval_mail', $data, function($message) use ($from_mail,$data){
            $message->from($from_mail,'ExportJOBOrderApprovalMail@prangroup.com');
            $message->to($data['receiver_email']);
            $message->cc(['mis@prangroup.com','mis94@mis.prangroup.com','mis10@prangroup.com']);
            $message->subject($data['subject']);
        }); 

    }
    
    //@
    //ED Sir mail function
    //@

    private function sendMailToEdSir($id,$data,$item_ids,$wh){
        
        $sale_contract=SaleContract::where('id',$id)->first(['importer_id','notify_pary_id','sales_contract_no','invoice_no','creator_id']);
        $importer_id=$sale_contract->importer_id;
        $notify_pary_id=$sale_contract->notify_pary_id;
        $invoice_no=$sale_contract->invoice_no;
        $user=User::where('id',$sale_contract->creator_id)->first(['name','username','email']);
        $notify_party=NotifyParty::findorfail($notify_pary_id);
        $notify_party_name=$notify_party->name;
        $notify_party_address=$notify_party->address;
        $party_code=$notify_party->code;
        $country=$notify_party->country; 

        $created_by=$user->username.'-'.$user->name; 

        $importer=Importer::findorfail($importer_id);
        $importer_name=$importer->name;
        $importer_address=$importer->address;

        $name="";
        $address="";

        if($importer_name=="N/A"){

            $name=$notify_party_name;
            $address=$notify_party_address;


        }else{

            $name=$importer_name;
            $address=$importer_address; 

        }

        $allowPercent=ApprovePercent::where('id','1')->first(['min_percent','max_percent']);
        $email_array=array();
        $results=DB::select("SELECT
                        ci_items.ci_item_code,
                        ci_items.ci_item_name,
                        coalesce(NULL,sale_contract_details.rate_status,'') AS rate_status,
                        sale_contract_details.per_piece_rate,
                        sale_contract_details.rate_percent,
                        sale_contract_details.prime_cost,
                        notify_parties.name as notify_party,
                        notify_parties.country,
                        bus.name AS bu_name
                    FROM
                        sale_contracts
                    JOIN sale_contract_details ON sale_contract_details.sale_contract_id = sale_contracts.id
                    JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                    JOIN bus ON bus.id=ci_items.bu_id
                    JOIN notify_parties ON notify_parties.id=sale_contracts.notify_pary_id
                    where sale_contracts.id = '$id'  AND sale_contract_details.rate_status != 'Y' AND sale_contract_details.rate_status = 'E' AND sale_contract_details.rate_status != 'M'");

        array_push($email_array,'pranexp@prangroup.com');
        $jo_notification_mail_lists = MailList::where('is_active',1)->where('jo_notification',1)
                  ->pluck('email')->toArray();
        array_push($jo_notification_mail_lists,$user->email);
        $data = array(
             'results'=>$results,
             'notify_party_name'=>$name,
             'notify_party_address'=>$address,
             'sc_number'=>$sale_contract->sales_contract_no,
             'receiver_email'=>$email_array,
             'allowPercent'=>$allowPercent,
             'party_code'=>$party_code,
             'jo_notification_mail_lists'=>$jo_notification_mail_lists,
             'invoice_no'=>$invoice_no,
             'created_by'=>$created_by,
             'subject'=>"JOB-Order-Approval,"." Invoice : ".$invoice_no,
             'subject2'=>"Export Item Price status with Prime Cost",
             'warehouse'=>$wh,
             'country'=>$country
            ); 

        $this->sendEdMail($data);
        $this->sendNotificationMail($data); 

    }

    //@
    //ED Sir mail sending function
    //@

    private function sendEdMail($data){

      $from_mail=env('MAIL_FROM_ADDRESS');  
      Mail::send('ed_approval_mail', $data, function($message) use ($from_mail,$data){
          $message->from($from_mail,'ExportJOBOrderApprovalMail@prangroup.com');
          $message->to($data['receiver_email']); 
          $message->subject($data['subject']);

        }); 

    }

    //@
    //send cost notification mail
    //@

    private function sendNotificationMail($data){
        
        $from_mail=env('MAIL_FROM_ADDRESS');
        Mail::send('jo_notification_mail', $data, function($message) use ($from_mail,$data){
          $message->from($from_mail,'ExportJOBOrderCostNotification@prangroup.com');
          $message->to($data['jo_notification_mail_lists']);
          $message->cc(['export@prangroup.com']); 
          $message->subject($data['subject2']);
        });
       
    }

    private function sendManagementMail($id,$data,$item_ids,$wh){

        $sale_contract=SaleContract::where('id',$id)->first(['importer_id','notify_pary_id','sales_contract_no','invoice_no','creator_id']);
        $importer_id=$sale_contract->importer_id;
        $notify_pary_id=$sale_contract->notify_pary_id;
        $invoice_no=$sale_contract->invoice_no;
        $user=User::where('id',$sale_contract->creator_id)->first(['name','username','email']);
        $notify_party=NotifyParty::findorfail($notify_pary_id);
        $notify_party_name=$notify_party->name;
        $notify_party_address=$notify_party->address;
        $party_code=$notify_party->code;
        $country=$notify_party->country; 
        $created_by=$user->username.'-'.$user->name; 
        $importer=Importer::findorfail($importer_id);
        $importer_name=$importer->name;
        $importer_address=$importer->address;
        $name="";
        $address="";

        if($importer_name=="N/A"){

            $name=$notify_party_name;
            $address=$notify_party_address;


        }else{

            $name=$importer_name;
            $address=$importer_address; 

        }

        $allowPercent=ApprovePercent::where('id','1')->first(['min_percent','max_percent']);
        $email_array=array();
        $results=DB::select("SELECT
                        ci_items.ci_item_code,
                        ci_items.ci_item_name,
                        coalesce(NULL,sale_contract_details.rate_status,'') AS rate_status,
                        sale_contract_details.per_piece_rate,
                        sale_contract_details.rate_percent,
                        sale_contract_details.prime_cost,
                        notify_parties.name as notify_party,
                        notify_parties.country,
                        bus.name AS bu_name
                    FROM
                        sale_contracts
                    JOIN sale_contract_details ON sale_contract_details.sale_contract_id = sale_contracts.id
                    JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                    JOIN bus ON bus.id=ci_items.bu_id
                    JOIN notify_parties ON notify_parties.id=sale_contracts.notify_pary_id
                    where sale_contracts.id = '$id' AND sale_contract_details.rate_status = 'S'");

        array_push($email_array,'pranexp@prangroup.com');
        $jo_notification_mail_lists = MailList::where('is_active',1)->where('jo_notification',1)->pluck('email')->toArray();
        array_push($jo_notification_mail_lists,$user->email);
        $data = array(
             'results'=>$results,
             'notify_party_name'=>$name,
             'notify_party_address'=>$address,
             'sc_number'=>$sale_contract->sales_contract_no,
             'receiver_email'=>$email_array,
             'allowPercent'=>$allowPercent,
             'party_code'=>$party_code,
             'jo_notification_mail_lists'=>$jo_notification_mail_lists,
             'invoice_no'=>$invoice_no,
             'created_by'=>$created_by,
             'subject'=>"JOB-Order-Approval,"." Invoice : ".$invoice_no,
             'subject2'=>"Export Item Price status with Prime Cost",
             'warehouse'=>$wh,
             'country'=>$country
            ); 

        $from_mail=env('MAIL_FROM_ADDRESS');
        Mail::send('management_mail', $data, function($message) use ($from_mail,$data){
          $message->from($from_mail,'ExportJOBOrderCostNotification@prangroup.com');
          $message->to('Samia@prangroup.com');
          //$message->to('mis94@mis.prangroup.com');
          $message->subject($data['subject2']);
        });
       
    }

    public function deleteJOBOrderApprovalItem(Request $request){
         
       $result=SaleContractDetail::where('id',$request->delete_id)->delete();
       if($result==true){
            
          return 'yes';  
 
       }else{

          return 'no'; 
       }


    }
     
    public function cancelJo(Request $request){
         
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                     from notify_parties
                     join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                     where notify_party_users.user_id='$user_id'");
         return view('job_order.jo_cancel',compact('notifyParties')); 
 
    }

    public function cancelJoInvWise(Request $request){
         
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                     from notify_parties
                     join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                     where notify_party_users.user_id='$user_id'");
         return view('job_order.jo_cancel_inv_wise',compact('notifyParties')); 
 
    }

    public function jsonGetInvoiceJoList(Request $request){

        $results=DB::select("select
                job_order_masters.id,
                job_order_masters.job_order_number as jo_no,
                job_order_masters.job_order_do_number as do_no,
                sum(job_order_details.orqt) as order_qty,
                sum(job_order_details.smqt) as sample_qty,
                job_order_masters.created_at as create_date,
                job_order_masters.delivery_date as delivery_date,
                job_order_masters.mfg_date as mfg_date,
                users.name as user,
                CASE
                when job_order_masters.status=1 then 'Not Approved'
                when job_order_masters.status=2 then 'Approved'
                when job_order_masters.status=3 then 'Cancel'
                END AS status
            from job_order_masters
                join job_order_details on job_order_details.master_id=job_order_masters.id
                join sale_contracts on sale_contracts.id=job_order_masters.sale_contract_id
                join users on users.id=job_order_masters.user_id
            WHERE sale_contracts.invoice_no='$request->invoice_no'
            group by job_order_masters.id,job_order_masters.job_order_number,job_order_masters.job_order_do_number,
                job_order_masters.created_at,job_order_masters.delivery_date,job_order_masters.mfg_date,users.name,job_order_masters.status
            order by job_order_details.orqt desc");  
        
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
                "data"    => []
            ]);

        }  

    }

    public function jsonGetJoDetails(Request $request,$id){
          
        $results=DB::select("select
                ci_items.ci_item_code as code,
                ci_items.ci_item_name as item,
                job_order_details.orqt,
                job_order_details.smqt,
                ROUND(job_order_details.rate,6) as rate,
                ROUND(SUM(job_order_details.rate*job_order_details.orqt),6) as value,
                dunits.dunit_name as dunit,
                runits.runit_name as runit,
                job_order_details.item_status
            from job_order_masters
                join job_order_details on job_order_details.master_id = job_order_masters.id
                join ci_items on ci_items.id=job_order_details.item_id
                join dunits on dunits.id=job_order_details.du_unit
                join runits on runits.id=job_order_details.ru_unit
            where job_order_masters.id='$id'
            group by ci_items.ci_item_code,ci_items.ci_item_name,job_order_details.orqt,
            job_order_details.smqt,dunits.dunit_name,runits.runit_name,job_order_details.rate,
            job_order_details.orqt,item_status");

        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);
        }



    }

    public function getPartyWiseJoCancelList(Request $request){

        $results=DB::select("select
                    job_order_masters.id,
                    job_order_masters.job_order_number as jo_no,
                    sale_contracts.invoice_no as invoice,
                    sum(job_order_details.orqt) as order_qty,
                    sum(job_order_details.smqt) as sample_qty,
                    job_order_masters.created_at as create_date,
                    job_order_masters.delivery_date as delivery_date,
                    job_order_masters.mfg_date as mfg_date,
                    users.name as user,
                    case
                        when job_order_masters.status=1 then 'Not Approved'
                        when job_order_masters.status=2 then 'Approved'
                        when job_order_masters.status=3 then 'Cancel' end as status
                from job_order_masters
                    join job_order_details on job_order_details.master_id=job_order_masters.id
                    join sale_contracts on sale_contracts.id=job_order_masters.sale_contract_id
                    join users on users.id=job_order_masters.user_id
                    join notify_parties on  notify_parties.id=job_order_masters.importer_id
                where (job_order_masters.job_order_do_number is null or job_order_masters.job_order_do_number='')
                        AND job_order_masters.status!=3
                        AND job_order_masters.status in (1,2)
                        AND notify_parties.id=$request->party_id
                group by job_order_masters.id,job_order_masters.job_order_number,job_order_masters.delivery_date,
                    job_order_masters.mfg_date,users.name,job_order_masters.status,job_order_masters.created_at,
                    sale_contracts.invoice_no
                order by job_order_details.orqt desc");  
        
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
                "data"    => []
            ]);

        }  

    }

    public function getPartyPendingJO(Request $request){

        $notifyParty=NotifyParty::where('code',$request->party_code)->first(['id']);
        $party_id=$notifyParty->id;
        $results=DB::select("CALL PROC_PENDING_JO_LIST(?)", [$party_id]);
        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"    => []
            ]);

        }  
         
    }

    public function joSoftCancel(Request $request){
          
        $result = JobOrderMaster::where('id', $request->cancel_id)->whereNull('job_order_do_number')->first();
        if($result){

            JobOrderMaster::where('id', $request->cancel_id)->update(['status' => "3"]);
            $result=\DB::table('job_order_details')
                ->where('master_id',$request->cancel_id)
                ->update([
                    'inactive_date'=>date('Y-m-d'),
                    'inactive_by'=>Auth::user()->id,
                    'syn_status_date'=>date('Y-m-d'),
                    'item_status'=>'N'
                ]);

            if($result) {

                return response()->json([
                    'messages' => "Cancel Done..!!",
                    "code"    => 200
                ]);

            } 

        }else{
            
            return response()->json([
                'messages' => "Already DO Done..!!",
                "code"    => 500
            ]);

        }
         

    }

    public function joRevise(){
       
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'"); 
        return view('job_order.jo_revise',compact('notifyParties'));

    }

    public function getPartyWiseJoList(Request $request){
       
        $results=DB::select("select
                    job_order_masters.id,
                    job_order_masters.job_order_number as jo_no,
                    sale_contracts.invoice_no as invoice,
                    sum(job_order_details.orqt) as order_qty,
                    sum(job_order_details.smqt) as sample_qty,
                    job_order_masters.created_at as create_date,
                    job_order_masters.delivery_date as delivery_date,
                    job_order_masters.mfg_date as mfg_date,
                    users.name as user,
                    case when job_order_masters.status=2 then 'Approved' end  as status
                from job_order_masters
                    join job_order_details on job_order_details.master_id=job_order_masters.id
                    join sale_contracts on sale_contracts.id=job_order_masters.sale_contract_id
                    join users on users.id=job_order_masters.user_id
                    join notify_parties on  notify_parties.id=job_order_masters.importer_id
                where (job_order_masters.job_order_do_number is null or job_order_masters.job_order_do_number='')
                        AND job_order_masters.status!=3
                        AND job_order_masters.status=2
                        AND notify_parties.id=$request->party_id
                group by job_order_masters.id,job_order_masters.job_order_number,job_order_masters.delivery_date,
                    job_order_masters.mfg_date,users.name,job_order_masters.status,job_order_masters.created_at,
                    sale_contracts.invoice_no
                order by job_order_details.orqt desc");  
        
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
                "data"    => []
            ]);

        }  

    }

    
    public function reviseJo(Request $request){
       
        $result=JobOrderMaster::where('id',$request->revise_id)->update([
            'status'=>1
        ]);

        if($result){

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"    => $result
            ]);

        }else{

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);

        }
        
    }

    public function joQuery(Request $request){
         
       $user_id=Auth::user()->id;
       $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'
                    and notify_parties.status=1");
        return view('job_order.jo_query',compact('notifyParties')); 

    }

    public function viewJOreport(Request $request){
       
        $encodedJOid = $request->query('joid');
        $id = base64_decode($encodedJOid); 
        $jobOrderMasters=\DB::select("SELECT
                job_order_masters.note             AS NOTE,
                job_order_masters.job_order_number AS JOD_NUM,
                sale_contracts.party_address       AS address,
                job_order_masters.shipping_mask,
                job_order_masters.issue_date,
                job_order_masters.delivery_date,
                job_order_masters.best_before,
                job_order_masters.mfg_date,
                users.name,
                users.username,
                job_order_masters.created_at,
                job_order_masters.imp_by,
                sale_contracts.party_name          AS party_name,
                job_order_masters.distributed_by
            FROM job_order_masters
                JOIN users ON job_order_masters.user_id = users.id
                JOIN sale_contracts on sale_contracts.id = job_order_masters.sale_contract_id
            WHERE
                job_order_masters.id ='$id'");

        foreach ($jobOrderMasters as $key => $value) {
           
           $note=$value->NOTE;
           $job_number=$value->JOD_NUM;
           $issue_date=$value->issue_date;
           $delivery_date=$value->delivery_date;
           $mfg_date=$value->mfg_date;
           $party_name=$value->party_name;
           $address=$value->address;
           $name=$value->name;
           $shipping_mask=$value->shipping_mask;
           $username=$value->username;
           $create_date=$value->created_at;
           $best_before=$value->best_before;
           $imp_by=$value->imp_by;
           $distributed_by=$value->distributed_by;

        }
        $create_date="";
        if($create_date){
        
            $create_date=date("Y-m-d",strtotime($create_date));

        }
        
        $jobOrderDetails=\DB::select("SELECT job_order_masters.mfg_date,job_order_masters.delivery_date,job_order_masters.issue_date,ci_items.ci_item_name,ci_items.ci_item_code,job_order_details.self_life,job_order_details.exp_date,job_order_details.qty,job_order_details.sale_contact_qty,dunits.dunit_name,runits.runit_name,job_order_details.orqt,job_order_details.smqt,job_order_details.coding_matter,job_order_details.sreq,job_order_details.rate,job_order_details.exp_date,job_order_masters.batch_number, ci_items.factor FROM job_order_masters 
            JOIN job_order_details ON job_order_masters.id = job_order_details.master_id
            JOIN ci_items ON ci_items.id=job_order_details.item_id
            LEFT JOIN dunits ON dunits.id=job_order_details.du_unit
            LEFT JOIN runits ON runits.id=job_order_details.ru_unit
            WHERE job_order_masters.id='$id' AND job_order_details.item_status='Y'");

        return view('job_order.job_order_report')
                 ->with('jobOrderDetails', $jobOrderDetails)
                 ->with('note',$note)
                 ->with('job_number', $job_number)
                 ->with('job_number', $job_number)
                 ->with('issue_date', $issue_date)
                 ->with('delivery_date', $delivery_date)
                 ->with('mfg_date', $mfg_date)
                 ->with('name', $name)
                 ->with('shipping_mask', $shipping_mask)
                 ->with('username', $username)
                 ->with('create_date', $create_date)
                 ->with('best_before', $best_before)
                 ->with('imp_by', $imp_by)
                 ->with('party_name', $party_name)
                 ->with('address', $address)
                 ->with('distributed_by',$distributed_by);

    }

    public function getAvaiableItemForJo(Request $request){
 
        $sc_id=$request->sc_id;
        $jo_id=$request->jo_id;
        $results = DB::select("SELECT
                sale_contract_details.id,
                sale_contract_details.ci_item_id,
                ci_items.ci_item_code,
                ci_items.ci_item_name,
                sale_contract_details.ctn,
                sale_contract_details.pcs_in_ctn,
                sale_contract_details.per_piece_rate AS rate,
                sale_contract_details.rate_percent as gp,
                CASE WHEN sale_contract_details.rate_status IS NULL OR sale_contract_details.rate_status = '' THEN 'Not Verified'
                WHEN sale_contract_details.rate_status = 'Y' THEN 'Verified' END AS status,
                production_floors.p_code as depo_code,
                sale_contract_details.prime_cost as prime_cost
            FROM sale_contract_details
            JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
            left join production_floors on production_floors.id=sale_contract_details.wh_id
            WHERE sale_contract_details.sale_contract_id = '$sc_id'
            AND sale_contract_details.ci_item_id NOT IN (
            SELECT job_order_details.item_id
            FROM job_order_details
                INNER JOIN job_order_masters
                ON job_order_details.master_id = job_order_masters.id
            WHERE job_order_masters.sale_contract_id = '$sc_id' and job_order_masters.id='$jo_id')");

        $depots=ProductionFloor::all();

        if($results) {

            return response()->json([
                'message' => "Data Found",
                    "code"    => 200,
                    "data"  => $results,
                    "depots" => $depots
                ]);

        }else{

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"    => [],
                "depots"  => $depots
            ]);

        }  

    }

    public function jobOrderAddItem(Request $request){
        
        $jo_master=JobOrderMaster::where('id', $request->jo_id)->first(['id','job_order_number','sale_contract_id','importer_id','mfg_date_orginal']);
        $item=SaleContractDetail::where('id',$request->item_id)->first(['ci_item_id','rate_per_ctn_for_acc','ctn','pcs_in_ctn']);
        $checkItemExist=JobOrderDetails::where('master_id',$jo_master->id)
                       ->where('item_status','Y')
                       ->where('item_id',$item->ci_item_id)
                       ->first();

        if(!is_null($checkItemExist)) {

            return response()->json([
                'code' => 409,
                'message' => 'This item already exists, Please update Qty!'
            ]);
        }

        $results=\DB::select("SELECT
            notify_party_items.coding_matter,
            notify_party_items.special_requirement,
            notify_party_items.shelf_life,
            notify_party_items.dunit,
            notify_party_items.runit,
            notify_party_items.acc_rate,
            ci_items.factor
        FROM
            `notify_party_items`
        JOIN ci_items ON ci_items.id=notify_party_items.ci_item_id
        WHERE `notify_party_id`='$jo_master->importer_id' AND `ci_item_id`='$item->ci_item_id'");
        foreach ($results as $key => $value) {
            
           $self_life=$value->shelf_life;
           $du_unit=$value->dunit;
           $ru_unit=$value->runit;
           $coding_matter=$value->coding_matter;
           $sreq=$value->special_requirement;
           $factor=$value->factor;

        }

        $jobOrderDetails=new JobOrderDetails();
        $jobOrderDetails->master_id=$jo_master->id;
        $jobOrderDetails->sc_line_id=$request->item_id;
        $jobOrderDetails->item_id=$item->ci_item_id;
        $sale_contract_id=$jo_master->sale_contract_id;
        $per_piece_rate=round($item->rate_per_ctn_for_acc/$factor,6);
        $jobOrderDetails->self_life=$self_life;
        $jobOrderDetails->exp_date=$this->getExpDateFormate($jo_master->importer_id,$jo_master->mfg_date_orginal,$self_life);
        $jobOrderDetails->qty=$item->ctn;
        $jobOrderDetails->factor=$factor;
        $jobOrderDetails->sale_contact_qty=$item->pcs_in_ctn;
        $jobOrderDetails->du_unit=$du_unit;
        $jobOrderDetails->orqt=$item->ctn*$factor;
        $jobOrderDetails->smqt=0;
        $jobOrderDetails->ru_unit=$ru_unit;
        $jobOrderDetails->coding_matter=$coding_matter;
        $jobOrderDetails->sreq=$sreq;
        $jobOrderDetails->rate=$per_piece_rate;
        $jobOrderDetails->update_by=Auth::user()->id;
        $jobOrderDetails->version=1;
        $jobOrderDetails->item_status='Y';
        $jobOrderDetails->wh_id='Y';
        $jobOrderDetails->item_status='Y';
        $jobOrderDetails->syn_status_date=date('Y-m-d');
        $jobOrderDetails->save(); 
        $date=date('Y-m-d');
        $this->updateKyvData($jo_master->id);
        return response()->json([
            'code' => 200,
            'message' => 'Item successfully added to Job Order.'
        ]);
            
    }

    public function updateWh(){

        $results=DB::select("select id,wh_id from job_order_masters where created_at >='2025-05-01' and status!=3");
        foreach($results as $result){
 
            $wh_id=ProductionFloor::where('p_code', $result->wh_id)->where('status',1)->value('id');
            if($wh_id){

               JobOrderDetails::where('master_id',$result->id)->update([
                  'wh_id'=>$wh_id
               ]);

            }

            $d_code=Depot::where('id',$result->wh_id)->value('d_code');
            $wh_id=ProductionFloor::where('p_code', $d_code)->where('status',1)->value('id');
            if($wh_id){

               JobOrderDetails::where('master_id',$result->id)->update([
                  'wh_id'=>$wh_id
               ]);

            }

        }

    }

    public function doQuery(){
         
       $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');  
       $importers = NotifyParty::orderBy('id','DESC')->whereIn('id',$notify_party_ids)->get();
       return view('job_order_quick.do_query')
           ->with('importers',$importers); 

    }

    public function buyerDOsummary(Request $request){

        $fromDate=date("Y-m-d", strtotime($request->from_date));
        $toDate=date("Y-m-d", strtotime($request->to_date));
        $results=DB::select("select
                    job_order_masters.id                                    as jo_id,
                    job_order_masters.job_order_number                      as jo_number,
                    do_history.do_number                                    as do_number,
                    sale_contracts.invoice_no                               as delivery_invoice,
                    date_format(do_history.created_date, '%d-%m-%Y')        as do_date,
                    sum(do_history.do_qty)                                  as total_qty,
                    ROUND(sum(do_history.do_qty * do_history.rate), 3)      as total_value,
                    users.name                                              as creator
                from do_history
                join job_order_masters on job_order_masters.id = do_history.job_order_id
                JOIN sale_contracts on sale_contracts.id=job_order_masters.sale_contract_id
                join users on users.id = do_history.created_by
                where job_order_masters.importer_id = '$request->party_id' and date(do_history.created_date) >= '$fromDate' and date(do_history.created_date) <= '$toDate'
                group by job_order_masters.id ,job_order_masters.job_order_number,do_history.created_date, do_history.do_number,users.name");

        return response()->json([
            'message' => "Data Found",
            "code"    => 200,
            "data"  => $results
        ]);
    

    }

    public function buyerDODetails(Request $request){
    
        $do_number=$request->doNumber;
        $results=DB::select("SELECT
                do_history.item_code as item_code,
                do_history.item_name as item_name,
                do_history.depot_code as depot,
                do_history.do_qty AS do_qty,
                do_history.smpl_qty as sample,
                round(do_history.do_qty * do_history.rate, 3) AS total_value,
                do_history.rate AS rate
            FROM do_history
            JOIN job_order_masters ON job_order_masters.id = do_history.job_order_id
            JOIN sale_contracts on sale_contracts.id=job_order_masters.sale_contract_id
            JOIN users ON users.id = do_history.created_by
            JOIN notify_parties ON notify_parties.id = job_order_masters.importer_id
            where do_history.do_number like '%$do_number%'");

        return response()->json([
            'message' => "Data Found",
            "code"    => 200,
            "data"  => $results
        ]);

    }


}
