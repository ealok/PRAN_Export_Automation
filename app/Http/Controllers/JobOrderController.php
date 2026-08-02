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
use Illuminate\Support\Facades\Crypt; // Add this line
use App\Vat;
use App\PFP;
use App\ODP;
use DB;
use App\ApprovePercent;
use App\MailList;
use App\UserArea;
use App\JOSyn;
use DateTime;
class JobOrderController extends Controller
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
        $firstDay = date('Y-m-d');
        $lastDay  = date('Y-m-d', strtotime('-3 months'));
        // $area_ids=UserArea::where('user_id',$user_id)->pluck('area_id')->toArray();
        // $notify_parties = NotifyParty::whereIn('area_id',$area_ids)->get();
        $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->where('status', '1')->pluck('notify_party_id');
        $notify_parties = NotifyParty::whereIn('id',$notify_party_ids)->get();  
        return view("job_order.index")
            ->with('firstDay', $firstDay)
            ->with('lastDay', $lastDay)
            ->with('notify_parties',$notify_parties);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($sale_contact_id,$party_id)
    {    
        
        $sale_contact_id=\Crypt::decrypt($sale_contact_id);
        $party_id=\Crypt::decrypt($party_id);         
        $notify_party= NotifyParty::where('id', $party_id)->first(['name','address','shipping_mark']);
        $importer_code = NotifyParty::where('id', $party_id)->pluck('code');
        $salesContactItems = SaleContract::select('ci_items.ci_item_code','ci_items.ci_item_name','ci_items.ci_factor','sale_contract_details.pcs_in_ctn','notify_party_items.dunit as du_unit','notify_party_items.runit as ru_unit',
            'sale_contract_details.ctn as qty','notify_parties.shipping_mark','notify_party_items.shelf_life as self_line',
            'notify_party_items.coding_matter as coding_mater','notify_party_items.special_requirement as special_requirment','notify_party_items.fob_value as fob_value',
            'sale_contract_details.rate_per_ctn_for_acc as rate','ci_items.ci_factor','sale_contract_details.pcs_in_ctn','sale_contracts.sales_contract_no',
            'production_floors.p_code','production_floors.short_name as factory','sale_contract_details.sample_qty','sale_contract_details.id as line_id')
            ->join('sale_contract_details','sale_contract_details.sale_contract_id','=','sale_contracts.id')
            ->join('ci_items','ci_items.id','=','sale_contract_details.ci_item_id')
            ->join('notify_party_items','notify_party_items.ci_item_id','=','sale_contract_details.ci_item_id')
            ->join('notify_parties','notify_parties.id','=','notify_party_items.notify_party_id')
            ->leftjoin('production_floors','production_floors.id','=','notify_party_items.factory_id')
            ->where('sale_contracts.id', $sale_contact_id)
            ->where('notify_party_items.notify_party_id', $party_id)
            ->get(); 
               
        $productionFloors=ProductionFloor::where('status',1)->get(); 
        $depots=Depot::where('status',1)->get(); 
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
        return view("job_order.create")
               ->with('importer_name', $notify_party->name)
               ->with('sale_contract', $sale_contract)
               ->with('salesContactItems', $salesContactItems)
               ->with('importer_code', $importer_code['0'])
               ->with('sale_contract_id', $sale_contact_id)
               ->with('productionFloors',$productionFloors )
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
    public function edit($id)
    {
           $id=\Crypt::decrypt($id);
           $jobOrderMasterResults=\DB::select("SELECT notify_parties.code, notify_parties.name, notify_parties.address,job_order_masters.shipping_mask,job_order_masters.note,job_order_masters.issue_date,job_order_masters.delivery_date,job_order_masters.mfg_date,job_order_masters.batch_number,job_order_masters.job_order_number,sale_contracts.sales_contract_no,job_order_masters.note,job_order_masters.mfg_date_orginal,job_order_masters.best_before,job_order_masters.imp_by,job_order_masters.distributed_by,job_order_masters.wh_id
            FROM job_order_masters
            JOIN notify_parties ON notify_parties.id=job_order_masters.importer_id
            JOIN sale_contracts ON sale_contracts.id=job_order_masters.sale_contract_id
            WHERE job_order_masters.id='$id'");
            $jobOrderDetails=\DB::select("SELECT
                        job_order_details.id,
                        job_order_details.item_id,
                        ci_items.ci_item_code,
                        ci_items.ci_item_name,
                        job_order_details.self_life,
                        job_order_details.exp_date,
                        job_order_details.qty,
                        job_order_details.sale_contact_qty,
                        job_order_details.du_unit,
                        job_order_details.orqt,
                        job_order_details.smqt,
                        job_order_details.ru_unit,
                        job_order_details.coding_matter,
                        job_order_details.sreq,
                        job_order_details.cncl,
                        job_order_details.rate,
                        ci_items.ci_factor
                    FROM
                        job_order_masters
                    JOIN job_order_details ON job_order_details.master_id = job_order_masters.id
                    JOIN ci_items ON ci_items.id = job_order_details.item_id
                    WHERE job_order_masters.id='$id' AND job_order_details.item_status='Y'");

        $result=JobOrderMaster::findorfail($id);
        $jobOrderNumber=explode("/",$result->job_order_number);
        $productionFloorId=$result->p_floor_id;
        $dunits=Dunit::all();
        $runits=Runit::all();
        $productionFloors=ProductionFloor::where('status',1)->get(); 
        $depots=Depot::where('status',1)->get(); 
        $sales_contract_details=SaleContract::findorfail($result->sale_contract_id);
        $sc_number=$sales_contract_details->sales_contract_no;
        $invoice_no=SaleContract::where('id', $result->sale_contract_id)->pluck('invoice_no'); 
        return view('job_order.job_order_edit')
               ->with('jobOrderMasterResults', $jobOrderMasterResults)
               ->with('productionFloors', $productionFloors)
               ->with('depots', $depots)
               ->with('productionFloorId', $productionFloorId)
               ->with('jobOrderNumber', $jobOrderNumber['0'])
               ->with('jobOrderDetails', $jobOrderDetails)
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
        
        $my_array=array();
        $length=count($request->unit_data);
        //@@@@@@@@@@@@@@@-----------Checking Unit------------------
        for ($j=0; $j<$length; $j++) {

            if($request->unit_data[$j]['value']==""){
                
                return "Fail";

            }    
                      

        } 


        $d_unit=array(); 
        $r_unit=array();
        $temp_array=array();
        $dist_info_details=array();
        //@@@@@@@@@@@@@@@----------End Unit Checking--------------
        $cncl=array(); 
        //@@@@@Factory Validation----------------
        for ($i=0; $i<count($request->info_details); $i++) { 

            array_push($cncl, preg_replace("<<br>>", "", $request->info_details[$i]['cncl']));

        }

        for ($i=0; $i<count($request->info_details); $i++) { 

            if($cncl[$i]==""){
                
                return "cncl";

            }

        }
        
        //@@@@@@@@@@@----End---------------------------------------
        //@@@@@@@@@@@@@@@----------Separate Unit Value------------
        for ($j=0; $j<$length; $j++) {


            if($j%2==0){
                  
                $d_unit[] = array('du_unit' => $request->unit_data[$j]['value']);

            }else{

                $r_unit[] = array('ru_unit' => $request->unit_data[$j]['value']);
                
            } 
                      

        }

        //@@@@@@@@@@@----End---------------------------------------


        //@@@@@@@@@@@@@@-----Combine Value-------------------------

        for ($i=0; $i<count($request->info_details); $i++) { 

             $temp_array[] = array_merge($request->info_details[$i], $r_unit[$i]);

        }

        for ($i=0; $i<count($request->info_details); $i++) { 

             $dist_info_details[] = array_merge($temp_array[$i], $d_unit[$i]);

        }
        
        // @@@@@@@@@@@@@@@@--End Validation Check--------------

        $orQty=array(); 
        $smQty=array();
        $item_ids=array();
        for ($i=0; $i<count($request->info_details); $i++) {

            array_push($orQty, preg_replace("<<br>>", "0", $dist_info_details[$i]['orqt']));
            array_push($smQty, preg_replace("<<br>>", "", $dist_info_details[$i]['smqt']));
            $ciItem=CiItem::where('ci_item_code',$dist_info_details[$i]['item_code'])->first(['id']);
            array_push($item_ids,$ciItem->id);

        }

        for ($i=0; $i <count($orQty) ; $i++) { 
          
            if ($orQty[$i]=='0') {
              
                return "or_qty";

            }

        } 
         
        for ($i=0; $i <count($smQty) ; $i++) { 
          
            if ($smQty[$i]=='') {
              
                return "sm_qty";

            }

        }
       
        $importer_id = NotifyParty::where('code', $request->importer_code)->pluck('id');
        $mfg_date_format=NotifyParty::where('id', $importer_id['0'])->pluck('mfg_date');
        $exp_date_format=NotifyParty::where('id', $importer_id['0'])->pluck('exp_date');
        $jobOrderObj=JobOrderMaster::where('id',$request->edit_id)->first(['sale_contract_id','delivery_date']);
        $sc_id=$jobOrderObj->sale_contract_id; 

        $preDeliveryDate=$jobOrderObj->delivery_date;
        $currentDeliveryDate=$request->delivery_date;

        $date1 = new DateTime($preDeliveryDate);
        $date2 = new DateTime($currentDeliveryDate);
        $syn_date=date('Y-m-d');
        JobOrderDetails::where('master_id', $request->edit_id)->update([
            'syn_status_date'=>$syn_date
        ]);

        if($mfg_date_format['0']==""){
           
           return "mfg_date_format"; 

        }

        if($exp_date_format['0']==""){
           
           return "exp_date_format"; 

        }
         
        \DB::table('job_order_masters')
                ->where('id', $request->edit_id)
                ->update([
            'shipping_mask' => $request->shipping_mark,
            'note' => $request->note,
            'issue_date' => $request->issue_date,
            'delivery_date' => $request->delivery_date,
            'mfg_date_orginal' => $request->mfg_date,
            'best_before'=>$request->bestBefore,
            'imp_by'=>$request->imp_by,
            'distributed_by'=>$request->distributed_by,
            'batch_number'=>$request->batch_number,
            'wh_id'=>$request->depo_id,
            'mfg_date' => $this->getMfgDateFormate($importer_id['0'],$request->mfg_date)
        ]);

        for ($i=0; $i<count($dist_info_details); $i++) { 
               
            $ci_item=CiItem::where('ci_item_code', $dist_info_details[$i]['item_code'])->first(['ci_factor','id']);
            \DB::table('job_order_details')
            ->where('id', $dist_info_details[$i]['details_id'])
            ->update([
                'du_unit' => $dist_info_details[$i]['du_unit'],
                'ru_unit' => $dist_info_details[$i]['ru_unit'],
                'orqt' =>(preg_replace("<<br>>", "", $dist_info_details[$i]['qty'])*$ci_item->ci_factor),
                'sale_contact_qty'=>(preg_replace("<<br>>", "", $dist_info_details[$i]['qty'])*$ci_item->ci_factor),
                'smqt' =>preg_replace("<<br>>", "", $dist_info_details[$i]['smqt']),
                'coding_matter' => $dist_info_details[$i]['coding_matter'],
                'sreq' => $dist_info_details[$i]['sreq'],
                'rate' => $dist_info_details[$i]['rate'],
                'qty' => $dist_info_details[$i]['qty'],
                'update_by' => Auth::user()->id,
                'exp_date'  =>$this->getExpDateFormate($importer_id['0'],$request->mfg_date, $dist_info_details[$i]['self_life'])
            ]);

        }
        $this->updateKyvData($request->edit_id);
        $this->pushCrmData($request->edit_id);
        return "Success";  


    }

    public function deleteJobOrderItemInEdit(Request $request){

        $date=date('Y-m-d');
        \DB::table('job_order_details')->whereIn('id', explode(",",$request->ids))->update(array('item_status' =>'N','inactive_date'=>$date,'inactive_by'=>Auth::user()->id,'syn_status_date'=>$date));
        $this->updateKyvData($request->joId);
        return response()->json(['success'=>"Item Delete successfully..!!"]);

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

    public function getImporterDetailsForJobOrder(Request $request){
          

        $importer_id=$request->importer_id;  
        if($importer_id){
            
            $address=NotifyParty::where('id', $request->importer_id)->pluck('address');
            $name=NotifyParty::where('id', $request->importer_id)->pluck('name'); 
            $importerSalesContacts = DistributorInfoMaster::select('distributor_info_masters.sale_contract_id','sale_contracts.sales_contract_no')
                        ->join('sale_contracts','sale_contracts.id','=','distributor_info_masters.id')
                        ->where('distributor_info_masters.importer_id', $request->importer_id)
                        ->get();
 
        }else{


            $importer_id="";
             

        }

        $sale_contract_id="";
        $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->where('status', '1')->pluck('notify_party_id');
        $notifyParties = NotifyParty::whereIn('id',$notify_party_ids)->get();
        return view("job_order.create")
               ->with('importerSalesContacts', $importerSalesContacts)
               ->with('importer_id', $importer_id)
               ->with('notifyParties', $notifyParties)
               ->with('sale_contract_id', $sale_contract_id)
               ->with('importer_address', $address['0'])
               ->with('importer_name', $name['0']);




    }

    public function getJobOrderItemBelogToSaleContact(Request $request){

        $user_id = Auth::user()->id;
        $notify_party_ids = NotifyPartyUser::where('user_id', $user_id)->where('status', '1')->pluck('notify_party_id');
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

    public function saveJobOrderInformationDetails(Request $request)
    {

        ini_set('max_execution_time', 600); 
        $my_array=array();
        $length=count($request->unit_data);
        //@@@@@@@@@@@@@@@-----------Checking Unit------------------
        for ($j=2; $j<$length; $j++) {

            if($request->unit_data[$j]['value']==""){
                
                return "Fail";

            }                

        } 

        $d_unit=array(); 
        $r_unit=array();
        $temp_array=array();
        $dist_info_details=array();
        //@@@@@@@@@@@@@@@----------End Unit Checking--------------
        //@@@@@@@@@@@@@@@----------Separate Unit Value------------
        for ($j=0; $j<$length; $j++) {


            if($j%2==0){
                  
                $r_unit[] = array('ru_unit' => $request->unit_data[$j]['value']);
               

            }else{

                $d_unit[] = array('du_unit' => $request->unit_data[$j]['value']);

            } 
                      

        }
                 
        $cncl=array(); 
        //@@@@@Factory Validation----------------
        for ($i=0; $i<count($request->info_details); $i++) { 

            array_push($cncl, preg_replace("<<br>>", "", $request->info_details[$i]['cncl']));

        }

        for($i=0; $i<count($request->info_details); $i++) { 

            if($cncl[$i]==""){
                
                return "cncl";

            }

        }

        for($i=0; $i<count($request->info_details); $i++) { 

            $temp_array[] = array_merge($request->info_details[$i], $r_unit[$i]);

        }

        for($i=0; $i<count($request->info_details); $i++) { 

             $dist_info_details[] = array_merge($temp_array[$i], $d_unit[$i]);

        }

        //@@@--------Validation Check--------------

        $orQty=array(); 
        $smQty=array();
        $item_ids=array();
        for ($i=0; $i<count($request->info_details); $i++) {

            array_push($orQty, preg_replace("<<br>>", "0", $dist_info_details[$i]['orqt']));
            array_push($smQty, preg_replace("<<br>>", "", $dist_info_details[$i]['smqt']));
            $ciItem=CiItem::where('ci_item_code',$dist_info_details[$i]['item_code'])->first(['id']);
            array_push($item_ids,$ciItem->id);
        }

        for ($i=0; $i <count($orQty) ; $i++) { 
          
            if ($orQty[$i]=='0') {
              
                return "or_qty";

            }

        } 
         
        for($i=0; $i <count($smQty) ; $i++) { 
          
            if ($smQty[$i]=='') {
              
                return "sm_qty";

            }

        }

        $ids = join(', ', $item_ids);
        $checkingMatchingItemStatus=DB::select("SELECT (CASE WHEN count1 = count2 THEN 'Y' ELSE 'N' END) as status FROM(SELECT (SELECT COUNT(sale_contract_details.id)
            FROM sale_contract_details
            WHERE sale_contract_details.sale_contract_id ='$request->sale_contact_id' AND `rate_status`='Y' 
            AND sale_contract_details.ci_item_id IN($ids)) AS count1,
            (SELECT COUNT(sale_contract_details.id) FROM sale_contract_details WHERE sale_contract_details.sale_contract_id ='$request->sale_contact_id' AND sale_contract_details.ci_item_id IN ($ids)) AS count2) AS counts");

        $itemStatus=$checkingMatchingItemStatus[0]->status;
        if($itemStatus=='N'){

           return 'CI'; //check item..
           
        }

        //@@@@--End---        
        $importer_id = NotifyParty::where('code', $request->importer_code)->pluck('id');
        $mfg_date_format=NotifyParty::where('id', $importer_id['0'])->pluck('mfg_date');
        $exp_date_format=NotifyParty::where('id', $importer_id['0'])->pluck('exp_date');
        if($mfg_date_format['0']==""){
           
           return "mfg_date_format"; 

        }

        if($exp_date_format['0']==""){
           
           return "exp_date_format"; 

        }
        
        $jobOrderMaster=new JobOrderMaster();
        $jobOrderMaster->importer_id=$importer_id['0'];
        $jobOrderMaster->sale_contract_id=$request->sale_contact_id;
        $jobOrderMaster->shipping_mask=$request->shipping_mark;
        $jobOrderMaster->note=$request->note;
        $jobOrderMaster->issue_date=$request->issue_date;
        $jobOrderMaster->delivery_date=$request->delivery_date;
        $jobOrderMaster->mfg_date_orginal=$request->mfg_date;
        $jobOrderMaster->mfg_date=$this->getMfgDateFormate($importer_id['0'],$request->mfg_date);
        $jobOrderMaster->batch_number=$request->batch_number;
        $jobOrderMaster->job_order_number=$this->getJobOrderNumber($importer_id['0'],$request->importer_code);
        $jobOrderMaster->p_floor_id=$request->p_floor_id;
        $jobOrderMaster->wh_id=$request->depo_id;
        $jobOrderMaster->best_before=$request->bestBefore;
        $jobOrderMaster->imp_by=$request->imp_by;
        $jobOrderMaster->distributed_by=$request->distributed_by;
        $jobOrderMaster->user_id=Auth::user()->id;
        $jobOrderMaster->status=1;
        $jobOrderMaster->save();
        for($i=0; $i<count($dist_info_details); $i++){

            $party_item_id=CiItem::where('ci_item_code', $dist_info_details[$i]['item_code'])->pluck('id'); 
            $jobOrderDetails=new JobOrderDetails();
            $jobOrderDetails->master_id=$jobOrderMaster->id;
            $jobOrderDetails->sc_line_id = isset($dist_info_details[$i]['line_id']) ? $dist_info_details[$i]['line_id'] : null;
            $jobOrderDetails->item_id=$party_item_id['0'];  
            $jobOrderDetails->self_life=$dist_info_details[$i]['self_life'];
            $jobOrderDetails->exp_date=$this->getExpDateFormate($importer_id['0'],$request->mfg_date, $dist_info_details[$i]['self_life']);
            $jobOrderDetails->qty=$dist_info_details[$i]['qty'];
            $jobOrderDetails->sale_contact_qty=$dist_info_details[$i]['sale_contact_qty'];
            $jobOrderDetails->du_unit=$dist_info_details[$i]['du_unit'];
            $jobOrderDetails->orqt=preg_replace("<<br>>", "", $dist_info_details[$i]['orqt']);
            $jobOrderDetails->smqt=preg_replace("<<br>>", "", $dist_info_details[$i]['smqt']);
            $jobOrderDetails->ru_unit=$dist_info_details[$i]['ru_unit'];
            $jobOrderDetails->coding_matter=$dist_info_details[$i]['coding_matter'];
            $jobOrderDetails->sreq=$dist_info_details[$i]['sreq'];
            $jobOrderDetails->cncl=preg_replace("<<br>>", " ", $dist_info_details[$i]['cncl']);
            $jobOrderDetails->rate=$dist_info_details[$i]['rate'];
            $jobOrderDetails->update_by=Auth::user()->id;
            $jobOrderDetails->version=1;
            $jobOrderDetails->save();

        }

        $user=\DB::table('users')->where('id', Auth::user()->id)->first(['email','name','head_id']);
        $jo_master=JobOrderMaster::where('id', $jobOrderMaster->id)->first(['job_order_number','p_floor_id','delivery_date','sale_contract_id']);
        $sale_contract=SaleContract::where('id', $jo_master->sale_contract_id)->first(['invoice_no']); 
        $productionFloor=ProductionFloor::where('id', $jo_master->p_floor_id)->first(['p_code','short_name']);
        $depo=Depot::where('id', $request->depo_id)->first(['d_code']);
        $results=DB::select("CALL PRPC_JO_DETAILS($jobOrderMaster->id)");
        $notifyParty=NotifyParty::where('code', $request->importer_code)->first(['code','name','country']);
        if($productionFloor->p_code==35000 || $depo->d_code==35000){

            $trading_user_mail=User::where('trading_mail_status',1)->where('active',1)->pluck('email')->toArray();
            $data = array(
                'job_order_number'=>$jo_master->job_order_number,
                'name'=>$user->name,
                'email'=>$user->email,
                'party_name'=>$notifyParty->name,
                'party_code'=>$notifyParty->code,
                'sale_contract'=>$sale_contract->invoice_no,
                'delivery_date'=>$jo_master->delivery_date,
                'email_array'=>$trading_user_mail,
                'results'=> $results,
                'pfloor_code'=>$productionFloor->p_code,
                'pfloor_name'=>$productionFloor->short_name,
                'url'=>'http://pqc.prangroup.com:8114/jo/receive'
            );

            $this->updateDashboardHistory($request->sale_contact_id,1);
            $from_mail=env('MAIL_FROM_ADDRESS');
            Mail::send('trading_jo_receive_mail', $data, function($message) use ($from_mail,$data){

                $message->from($from_mail,'Job-Order-Mail@prangroup.com');
                $message->to('mis94@mis.prangroup.com');
                $message->cc(['export@prangroup.com','mis4@mis.prangroup.com','mis10@mis.prangroup.com']); 
                $message->subject('Trading JO Creation Mail, Invoice No. '.$data['sale_contract']);  
                
            });

        }else{

            $email_array=User::where('location_id',$jo_master->p_floor_id)->where('active',1)->where('type_id',3)->whereNotNull('email')->pluck('email')->toArray();
            $user_email=User::where('id', Auth::user()->id)->first(['email']);
            $desk_array=array();
            if($user->head_id){

                $desk_array=User::where('head_id',$user->head_id)->where('active',1)->where('jo_mail_status',1)->whereNotNull('email')->pluck('email')->toArray();  
            
            }
            
            $responsible_array=array("buh.psc@prangroup.com","pran219@prangroup.com");
            if(SaleContractDetail::where('sale_contract_id',$request->sale_contact_id)->where('bu_id',19)->exists()){
                
                $sending_mail_list=array_merge($email_array, $desk_array, $responsible_array);

            }else{
            
                $sending_mail_list=array_merge($email_array, $desk_array); 

            }
             
            //$this->updateDashboardHistory($request->sale_contact_id,1);
            $this->updateKyvData($jobOrderMaster->id);
            $this->pushCrmData($jobOrderMaster->id);
            if(count($sending_mail_list)>0){
                
                $data = array(
                    'job_order_number'=>$jo_master->job_order_number,
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'sale_contract'=>$sale_contract->invoice_no,
                    'delivery_date'=>$jo_master->delivery_date,
                    'email_array'=>$sending_mail_list,
                    'results'=>$results,
                    'pfloor_code'=>$productionFloor->p_code,
                    'country'=>$notifyParty->country,
                    'pfloor_name'=>$productionFloor->short_name,
                    'url'=>'http://pqc.prangroup.com:8114/jo/receive'
                );
                $from_mail=env('MAIL_FROM_ADDRESS');
                Mail::send('job_order_mail', $data, function($message) use ($from_mail,$data){

                    $message->from($from_mail,'Job-Order-Mail@prangroup.com'); 
                    $message->to($data['email_array']);
                    $message->subject('JO Creation Mail, Invoice No. '.$data['sale_contract']);
                    
                });

            }

        }

        return "Success";

    }


    private function pushCrmData($jo_id)
    {
        try {

            $results = DB::select("CALL PROC_CRM_ORDER_PUSH(?)", [$jo_id]);
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
            if(!empty($curlError)) {
                return ['status' => 'error', 'message' => 'CURL Error: ' . $curlError];
            }
            $decodedResponse = json_decode($response, true);
            if($httpCode == 200 || $httpCode == 201) {
                DB::table('job_order_masters')
                    ->where('id', $jo_id)
                    ->update([
                        'push_status' => 'Y',
                        'push_date' => date('Y-m-d H:i:s'), 
                        'push_message' => !empty($decodedResponse['message']) ? $decodedResponse['message'] : 'Data pushed successfully',
                        'push_total' => !empty($decodedResponse['total']) ? $decodedResponse['total'] : 0,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
            }

            return [
                'status' => 'error',
                'message' => 'API Error: HTTP ' . $httpCode,
                'response' => $decodedResponse
            ];
            
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
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



    public function addNewJobOrderItem(Request $request){
        
        $master_id=JobOrderMaster::where('job_order_number', $request->job_order_number)->first(['id']);
        $checkItemExist=JobOrderDetails::where('master_id',$master_id->id)
                       ->where('item_status','Y')
                       ->where('item_id',$request->sc_item_id)
                       ->first();

        if(!is_null($checkItemExist)){
 
           return 'item_exist';

        }

        $master_id=JobOrderMaster::where('job_order_number', $request->job_order_number)->pluck('id');
        $notify_party_id=JobOrderMaster::where('job_order_number', $request->job_order_number)->pluck('importer_id');
        $notify_party_id=$notify_party_id['0'];
        $jobOrderDetails=new JobOrderDetails();
        $jobOrderDetails->master_id=$master_id['0'];
        $jobOrderDetails->item_id=$request->sc_item_id;
        $sale_contract_id=JobOrderMaster::where('job_order_number', $request->job_order_number)->pluck('sale_contract_id');

        //@@@@@@@----Get Sales Conatct Id---------
        $sale_contract_id=$sale_contract_id['0'];
        //@@@@@@@----End-------------------

        //@@@@@@@@@@@@--Get Carton Qty-----------------

        $ctnQty=SaleContractDetail::where('sale_contract_id',$sale_contract_id)->where('ci_item_id',$request->sc_item_id)->pluck('ctn');

        $acc_rate=SaleContractDetail::where('sale_contract_id',$sale_contract_id)->where('ci_item_id',$request->sc_item_id)->pluck('rate_per_ctn_for_acc');

        //@@@@@@@@@@@@@@@@--End------------------
        

        //@@@@@@@@@@@@@@@@---Get Notify Party Item Details------------- 
        $results=\DB::select("SELECT
            notify_party_items.coding_matter,
            notify_party_items.special_requirement,
            notify_party_items.shelf_life,
            notify_party_items.dunit,
            notify_party_items.runit,
            production_floors.short_name as p_name,
            notify_party_items.acc_rate,
            ci_items.factor
        FROM
            `notify_party_items`
        JOIN production_floors ON production_floors.id=notify_party_items.factory_id
        JOIN ci_items ON ci_items.id=notify_party_items.ci_item_id
        WHERE `notify_party_id`='$notify_party_id' AND `ci_item_id`='$request->sc_item_id'");

        foreach ($results as $key => $value) {
            
           $self_life=$value->shelf_life;
           $du_unit=$value->dunit;
           $ru_unit=$value->runit;
           $coding_matter=$value->coding_matter;
           $sreq=$value->special_requirement;
           $cncl=$value->p_name;
           $factor=$value->factor;

        }

        $master_id=JobOrderMaster::where('job_order_number', $request->job_order_number)->first(['mfg_date','id']);
        $per_piece_rate=$acc_rate['0']/$factor;
        $jobOrderDetails->self_life=$self_life;
        $jobOrderDetails->exp_date=$this->getExpDateFormate($notify_party_id,$request->mfg_date, $self_life);
        $jobOrderDetails->qty=$ctnQty['0'];
        $jobOrderDetails->sale_contact_qty=$ctnQty['0']*$factor;
        $jobOrderDetails->du_unit=$du_unit;
        $jobOrderDetails->orqt=$ctnQty['0']*$factor;
        $jobOrderDetails->smqt=0;
        $jobOrderDetails->ru_unit=$ru_unit;
        $jobOrderDetails->coding_matter=$coding_matter;
        $jobOrderDetails->sreq=$sreq;
        $jobOrderDetails->cncl=$cncl;
        $jobOrderDetails->rate=$per_piece_rate;
        $jobOrderDetails->update_by=Auth::user()->id;
        $jobOrderDetails->version=1;
        $jobOrderDetails->item_status='Y';
        $jobOrderDetails->syn_status_date=date('Y-m-d');
        $jobOrderDetails->save(); 
        $date=date('Y-m-d');
        $this->updateKyvData($master_id['0']);
        return "success";
            
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

            $day = date("d", strtotime($mfg_date)); // 2 digit month
            $year  = date("Y", strtotime($mfg_date)); // 4 digit year
            return $date = $day . "/" . $year;

        } 

        if($dateFormate[0] == "2026 JN 05") {

            $timestamp = strtotime($mfg_date);
            $year = date("Y", $timestamp);
            $day  = date("d", $timestamp);
            $monthNum = date("m", $timestamp);
            $months = [
                '01' => 'JN',
                '02' => 'FB',
                '03' => 'MR',
                '04' => 'AP',
                '05' => 'MY',
                '06' => 'JN',
                '07' => 'JL',
                '08' => 'AG',
                '09' => 'SP',
                '10' => 'OC',
                '11' => 'NV',
                '12' => 'DC'
            ];

            return $year . " " . $months[$monthNum] . " " . $day;
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

                $month = date("m", strtotime($exp_date)); // 2 digit month
                $year  = date("Y", strtotime($exp_date)); // 4 digit year
                return $date = $month . "/" . $year;

            }
            
            if($dateFormate[0] == "2026 JN 05") {

                $timestamp = strtotime($exp_date);
                $year = date("Y", $timestamp);
                $day  = date("d", $timestamp);
                $monthNum = date("m", $timestamp);
                $months = [
                    '01' => 'JN',
                    '02' => 'FB',
                    '03' => 'MR',
                    '04' => 'AP',
                    '05' => 'MY',
                    '06' => 'JN',
                    '07' => 'JL',
                    '08' => 'AG',
                    '09' => 'SP',
                    '10' => 'OC',
                    '11' => 'NV',
                    '12' => 'DC'
                ];
                
                return $year . " " . $months[$monthNum] . " " . $day;
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

    public function getJobOrderList(Request $request)
    {
        try {
            
            $partyId = $request->party_id;
            $fromDate = $request->from_date;
            $toDate = $request->to_date;
            $query = DB::table('job_order_masters')
                ->select([
                    'job_order_masters.id',
                    'sale_contracts.id as sc_id',
                    'job_order_masters.job_order_number',
                    DB::raw('COALESCE(SUM(jod.orqt * jod.rate), 0) as invoice_value'),
                    DB::raw('COALESCE(SUM(jod.qty), 0) as total_ctn'),
                    'notify_parties.code',
                    'notify_parties.address',
                    'sale_contracts.invoice_no',
                    'job_order_masters.status',
                    'notify_parties.name',
                    'job_order_masters.job_order_do_status',
                    'job_order_masters.job_order_do_number',
                    DB::raw("CONCAT(production_floors.p_code, '-', production_floors.short_name) as prod_floor"),
                    DB::raw("CONCAT(depots.d_code, '-', depots.d_name) as out_depo"),
                    'production_floors.p_code',
                    'job_order_masters.created_at',
                    DB::raw("CASE 
                        WHEN job_order_masters.job_order_do_status IS NULL THEN 'DO' 
                        ELSE 'Done' 
                    END as order_by")
                ])
                ->join('job_order_details as jod', 'job_order_masters.id', '=', 'jod.master_id')
                ->join('production_floors', 'production_floors.id', '=', 'job_order_masters.p_floor_id')
                ->join('notify_parties', 'job_order_masters.importer_id', '=', 'notify_parties.id')
                ->join('sale_contracts', 'sale_contracts.id', '=', 'job_order_masters.sale_contract_id')
                ->leftJoin('depots', 'depots.d_code', '=', 'job_order_masters.wh_id')
                ->where('job_order_masters.importer_id', $partyId)
                ->where('job_order_masters.status', '!=', 3);
                // ->where(function($query) {
                //     $query->where('jod.item_status', '!=', 'Y')
                //         ->orWhereNull('jod.item_status');
                // });

            if ($fromDate && $toDate) {
                $query->whereBetween(DB::raw('DATE(job_order_masters.created_at)'), [$fromDate, $toDate]);
            }

            $query->groupBy([
                'job_order_masters.id',
                'sale_contracts.id',
                'job_order_masters.job_order_number',
                'notify_parties.code',
                'notify_parties.address',
                'sale_contracts.invoice_no',
                'job_order_masters.status',
                'notify_parties.name',
                'job_order_masters.job_order_do_status',
                'job_order_masters.job_order_do_number',
                'production_floors.p_code',
                'production_floors.short_name',
                'depots.d_code',
                'depots.d_name',
                'job_order_masters.created_at'
            ]);

            $query->orderBy('sc_id', 'DESC');
            $jobOrderMasters = $query->get();
            if ($jobOrderMasters->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'total' => 0,
                    'message' => 'No job orders found for the selected criteria'
                ]);
            }
            
            $data = $jobOrderMasters->map(function($jobOrder) {
                return [
                    'id' => $jobOrder->id,
                    'sc_id' => $jobOrder->sc_id, 
                    'encrypted_id' => Crypt::encrypt($jobOrder->id),
                    'job_order_number' => $jobOrder->job_order_number,
                    'invoice_value' => (float) $jobOrder->invoice_value,
                    'total_ctn' => (int) $jobOrder->total_ctn,
                    'prod_floor' => $jobOrder->prod_floor,
                    'out_depo' => $jobOrder->out_depo,
                    'job_order_do_number' => $jobOrder->job_order_do_number,
                    'code' => $jobOrder->code,
                    'invoice_no' => $jobOrder->invoice_no,
                    'status' => $jobOrder->status,
                    'job_order_do_status' => $jobOrder->job_order_do_status,
                    'name' => $jobOrder->name,
                    'address' => $jobOrder->address,
                    'p_code' => $jobOrder->p_code,
                    'created_at' => $jobOrder->created_at,
                    'order_by' => $jobOrder->order_by
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $data->count(),
                'message' => 'Data loaded successfully'
            ]);
            
        } catch (\Exception $e) {
           
            return response()->json([
                'success' => false,
                'message' => 'Error fetching data. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }

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

    public function AppvoveJobOrder(Request $request)
    {

        // try {
            $jobOrderId=\Crypt::decrypt($request->input('job_order_id'));
            $jobOrder = JobOrderMaster::find($jobOrderId);
            if (!$jobOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Job order not found.'
                ], 404);
            }
            
            // Check if already approved
            if ($jobOrder->status == '2') {
                return response()->json([
                    'success' => false,
                    'message' => 'This job order is already approved.'
                ]);
            }
            
            // Update status
            $jobOrder->status = '2';
            $jobOrder->save();
            return response()->json([
                'success' => true,
                'message' => 'Job order approved successfully!',
                'data' => [
                    'job_order_number' => $jobOrder->job_order_number,
                    'job_order_do_status' => $jobOrder->job_order_do_status,
                    'encrypted_id' => $jobOrderId
                ]
            ]);
            
        // } catch (\Exception $e) {
            
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'An error occurred while approving the job order. Please try again.'
        //     ], 500);
        // }
    }

    public function jobOrderCancel(Request $request){
               
        $id = decrypt($request->job_order_id);
        $date=date('Y-m-d');
        DB::table('job_order_masters')->where('id', $id)->update(['status' => "3"]);
        DB::table('job_order_details')->where('master_id',$id)->update(array('item_status' =>'N','inactive_date'=>$date,'inactive_by'=>Auth::user()->id,'syn_status_date'=>$date));
        $user=User::where('id',Auth::user()->id)->first(['email','name','head_id']);
        $jo_master=JobOrderMaster::where('id', $id)->first(['job_order_number','sale_contract_id']);
        $sale_contract=SaleContract::where('id',$jo_master->sale_contract_id)->first(['invoice_no']); 
        $email_array=User::where('location_id',$jo_master->p_floor_id)->pluck('email')->toArray();
        $desk_array=array();
        if($user->head_id){
           
            $desk_array=User::where('head_id',$user->head_id)->where('active',1)->pluck('email')->toArray();  

        }

        $sending_mail_list=array_merge($email_array,$desk_array);
        if(count($sending_mail_list)>0){
             
            $data = array(
                'job_order_number'=>$jo_master->job_order_number,
                'name'=>$user->name,
                'email'=>$user->email,
                'delivery_date'=>$user->delivery_date,
                'sale_contract'=>$sale_contract->invoice_no,
                'sending_email_array'=>$sending_mail_list
            );

        }

        DB::table('job_order_details')
            ->where('master_id', $id)
            ->update([
                'inactive_date'=>date('Y-m-d'),
                'inactive_by'=>Auth::user()->id,
                'syn_status_date'=>$date,
                'item_status'=>'N'
            ]);

        $this->updateKyvData($id);
        $this->pushCrmData($id);    
        return response()->json([
            'success' => true,
            'message' => 'Job order cancelled successfully'
        ]);
 
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
            return response()->json([
                'response' => $response
            ]);
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

    public function doCreate(Request $request,$id){
         
        ini_set('memory_limit', -1); 
        $id=\Crypt::decrypt($id);
        $jobOrderMasterResults=\DB::select("SELECT notify_parties.code, notify_parties.name, notify_parties.address,job_order_masters.shipping_mask,job_order_masters.note,job_order_masters.issue_date,job_order_masters.delivery_date,job_order_masters.mfg_date_orginal as mfg_date,job_order_masters.batch_number,job_order_masters.job_order_number,sale_contracts.sales_contract_no,sale_contracts.id as sales_contract_id,job_order_masters.note,job_order_masters.wh_id
            FROM job_order_masters
            JOIN notify_parties ON notify_parties.id=job_order_masters.importer_id
            JOIN sale_contracts ON sale_contracts.id=job_order_masters.sale_contract_id
            WHERE job_order_masters.id='$id'");

        $jobOrderDetails=\DB::select("SELECT
                        job_order_details.id,
                        job_order_details.item_id,
                        ci_items.ci_item_code,
                        ci_items.ci_item_name,
                        job_order_details.self_life,
                        job_order_details.exp_date,
                        job_order_details.qty,
                        job_order_details.sale_contact_qty,
                        job_order_details.du_unit,
                        job_order_details.orqt,
                        job_order_details.do_qty,
                        job_order_details.smqt,
                        job_order_details.ru_unit,
                        job_order_details.coding_matter,
                        job_order_details.sreq,
                        job_order_details.cncl,
                        job_order_details.rate
                    FROM
                        job_order_masters
                    JOIN job_order_details ON job_order_details.master_id = job_order_masters.id
                    JOIN ci_items ON ci_items.id = job_order_details.item_id
                    WHERE job_order_masters.id='$id' AND job_order_details.item_status='Y'");
        $result=JobOrderMaster::findorfail($id);
        $jobOrderNumber=explode("/",$result->job_order_number);
        $productionFloorId=$result->p_floor_id;
       
        $dunits=Dunit::all();
        $runits=Runit::all();
        $productionFloors=ProductionFloor::where('status',1)->get(); 
        $depots=Depot::where('status',1)->get(); 
        $jobOrderMaster=JobOrderMaster::where('id',$id)->first(['sale_contract_id']);
        $salesContacts=SaleContract::where('id',$jobOrderMaster->sale_contract_id)->first(['id','invoice_no']);
        return view('job_order.do_create')
               ->with('jobOrderMasterResults', $jobOrderMasterResults)
               ->with('productionFloors', $productionFloors)
               ->with('deports', $depots)
               ->with('productionFloorId', $productionFloorId)
               ->with('jobOrderNumber', $jobOrderNumber['0'])
               ->with('jobOrderDetails', $jobOrderDetails)
               ->with('dunits', $dunits)
               ->with('runits', $runits)
               ->with('id', $id)
               ->with('salesContacts', $salesContacts);

    }

    public function getJobOrderRequestItem(Request $request){
            
        $party_id=NotifyParty::where('code', $request->party_code)->pluck('id');
        ini_set('max_execution_time', -1); 
        $mfgDate=$this->getMfgDateFormate($party_id['0'],$request->mfg_date);
        JobOrderMaster::where('id',$request->job_order_id)->update([

            'mfg_date'=>$this->getMfgDateFormate($party_id['0'],$request->mfg_date)

        ]);
        
        $warehouseId=Depot::where('id', $request->depo_id)->first(['d_code']);
        if($warehouseId->d_code==35000){
            
            return "not_do";

        }

        $doMaster=new DoMaster();
        $doMaster->importer_id=$party_id['0'];
        $doMaster->sale_contract_id=$request->sc_id;
        $doMaster->job_order_id=$request->job_order_id;
        $doMaster->shipping_mask=$request->shipping_mark;
        $doMaster->note=$request->note;
        $doMaster->issue_date=$request->issue_date;
        $doMaster->delivery_date=$request->delivery_date;
        $doMaster->mfg_date=$request->mfg_date;
        $doMaster->batch_number=$request->batch_number;
        $doMaster->p_floor_id=$request->p_floor_id;
        $doMaster->wh_id=$request->depo_id;
        $doMaster->user_id=Auth::user()->id;
        $doMaster->currency_rate=$request->currency_rate;
        $doMaster->save();
        for ($i=0; $i<count($request->info_details); $i++) { 

            $jobOrderDetails=new DoDetails(); 
            $party_item_id=CiItem::where('ci_item_code', $request->info_details[$i]['item_code'])->pluck('id');
            $jobOrderDetails->master_id=$doMaster->id;
            $jobOrderDetails->jo_line_id=$request->info_details[$i]['lineId'];
            $jobOrderDetails->item_id=$party_item_id['0'];  
            $jobOrderDetails->self_life=$request->info_details[$i]['self_life'];
            $jobOrderDetails->exp_date=$request->info_details[$i]['exp_date'];
            $jobOrderDetails->qty=$request->info_details[$i]['qty'];
            $jobOrderDetails->sale_contact_qty=$request->info_details[$i]['sales_contact_qty'];
            $jobOrderDetails->du_unit=1;
            $jobOrderDetails->orqt=$request->info_details[$i]['orqt'];
            $jobOrderDetails->smqt=$request->info_details[$i]['smqt'];
            $jobOrderDetails->ru_unit=1;
            $jobOrderDetails->coding_matter=$request->info_details[$i]['codding_matter'];
            $jobOrderDetails->sreq=$request->info_details[$i]['sreq'];
            $jobOrderDetails->cncl=$request->info_details[$i]['cncl'];
            $jobOrderDetails->rate=$request->info_details[$i]['rate'];
            $jobOrderDetails->save();
            $existingDoQtySum = JobOrderDetails::where('item_id', $party_item_id['0'])->where('master_id',$request->job_order_id)->value('do_qty');
            JobOrderDetails::where('master_id',$request->job_order_id)->where('item_id',$party_item_id[0])->update([
                'do_qty'=>$existingDoQtySum + $request->info_details[$i]['orqt']
            ]); 

        }

        $parts = explode('-', $request->job_order_no);
        $job_order_no = implode('-', array_slice($parts, 1));
        $invoice_no=SaleContract::where('id', $request->sc_id)->pluck('invoice_no'); 
        $array=array();
        $user_id=Auth::user()->id;
        $staff_id=User::where('id', $user_id)->pluck('username');
        $array['DISTID'] = $request->party_code;
        $array['NOTE'] = $invoice_no['0'];
        $array['DOCNO'] = $job_order_no;
        $array['SHIPPING'] = $request->shipping_mark;
        $array['CURRENCY']=$request->currency_rate;
        $array['IUSER']=$staff_id['0'];
        $warehouseId=Depot::where('id', $request->depo_id)->pluck('d_code');
        for($i=0; $i<count($request->info_details); $i++) { 

            $orqt=preg_replace("<<br>>", "", $request->info_details[$i]['orqt']); 
            $smqt=preg_replace("<<br>>", "",$request->info_details[$i]['smqt']);
            $party_item_id=CiItem::where('ci_item_code', $request->info_details[$i]['item_code'])->pluck('id');
            $item_factor=CiItem::where('ci_item_code', $request->info_details[$i]['item_code'])->pluck('factor'); 
            $dunit=1;
            $runit=1;
            $data_array[]=array('ITEM_ID'=>$request->info_details[$i]['item_code'], 'QTY'=>$orqt,'S_QTY'=>$smqt,'RATE'=>$request->info_details[$i]['rate'],'DUFACT'=>$item_factor['0'],'WH_ID'=>$warehouseId['0'],'LINE_NOTE'=>"Batch_Number:".$request->batch_number.','."Self_Life".$request->info_details[$i]['self_life'].','."Exp_Date:".$request->info_details[$i]['exp_date'].',');
            //$data_array[]=array('ITEM_ID'=>$request->info_details[$i]['item_code'], 'QTY'=>$orqt,'S_QTY'=>$smqt,'RATE'=>$request->info_details[$i]['rate'],'DUFACT'=>$item_factor['0'],'WH_ID'=>$warehouseId['0'],'LINE_NOTE'=>"Batch_Number:".$request->batch_number.','."Self_Life".$request->info_details[$i]['self_life'].','."Exp_Date:".$request->info_details[$i]['exp_date'].','."Dunit:".$dunit['0'].','."Runit:".$runit.','."Coding_Matter:".$request->info_details[$i]['codding_matter'].','."SREQ:".$request->info_details[$i]['sreq']);
            $array['data']=$data_array;
        
        }
        
        $my_array=json_encode($array);
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $url = 'http://runner.prangroup.com:4005/api/dox';
        $headers = array(
            "Content-type: application/json",
            "ss: Alok",
            "yy: HJDyh876Yhdsf543GDJksn"
        );   

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $my_array);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $x= json_decode($response,true);
        if(isset($x['DOdt'][0]['DO_NO'])){
            
            $doNumber=$x['DOdt'][0]['DO_NO'];
            $status=$x['Status'];
            $remark=$x['Remarks'];
            if($status=="OK"){

                \DB::table('job_order_masters')
                ->where('id', $request->job_order_id)
                ->update([
                    'job_order_do_status' => $status,
                    'job_order_do_remark' => $remark,
                    'job_order_do_number' => $doNumber,
                    'job_order_do_creator' => Auth::user()->id,
                    'job_order_do_date' => date('Y-m-d'),
                    'wh_id'=>$warehouseId['0']  
                ]);

                $this->updateDashboardHistory($request->sc_id,2); 
                echo "ok";

            } 
                            
        }else{

            echo "Fail";

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


    public function deskWiseJoList(){
        
        $firstDay = date('Y-m-d');
        $lastDay  = date('Y-m-d', strtotime('-3 months'));
        $user_id=Auth::user()->id;
        $notify_party_ids = NotifyPartyUser::where('user_id', $user_id)->where('status', '1')->pluck('notify_party_id');
        $notify_parties = NotifyParty::whereIn('id', $notify_party_ids)->get();
        return view('job_order.desh_wise_jo')
               ->with('lastDay',$lastDay)
               ->with('firstDay',$firstDay)
               ->with('notify_parties',$notify_parties);     

    }

    // public function notifyPartyJobOrderList($id){

    //     $id=\Crypt::decrypt($id);
    //     $firstDay = date('Y-m-d');
    //     $lastDay  = date('Y-m-d', strtotime('-3 months'));
    //     $user_id=Auth::user()->id;
    //     $area_ids=UserArea::where('user_id',$user_id)->pluck('area_id')->toArray();
    //     $notify_parties = NotifyParty::whereIn('area_id',$area_ids)->get();
    //     return view('job_order.desh_wise_jo')
    //            ->with('lastDay',$lastDay)
    //            ->with('firstDay',$firstDay)
    //            ->with('notify_parties',$notify_parties);

    // }

    public function jobOrderAddItemEditOption(Request $request)
    {
        $jobOrderMaster = JobOrderMaster::where('job_order_number', $request->job_number)->first();
        
        $salesContactItems = !empty($jobOrderMaster) ? DB::select("
            SELECT
                ci_items.id AS item_id,
                sale_contracts.sales_contract_no,
                ci_items.ci_item_code,
                ci_items.ci_item_name
            FROM
                sale_contracts
            JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
            JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
            WHERE sale_contracts.id = ?
            AND (sale_contract_details.rate_status = 'Y' OR sale_contract_details.rate_status IS NULL)
        ", [$jobOrderMaster->sale_contract_id]) : [];

        $currentDepoId = !empty($jobOrderMaster) ? $jobOrderMaster->wh_id : null;
        
        $depo = !empty($currentDepoId) ? Depot::where('id', $currentDepoId)->get() : [];
        
        return response()->json([
            'items' => $salesContactItems,
            'job_number' => $request->job_number,
            'depos' => $depo,
            'sale_contract_id' => !empty($jobOrderMaster) ? $jobOrderMaster->sale_contract_id : null,
            'current_depo_id' => $currentDepoId
        ]);
    }

     public function jobOrderRateMatching(Request $request){ 
         
        $results=$this->checkItemRateMatching($request);
        if($results=="Md"){
        
          $updateExistOrNot=\DB::table('sale_contracts')->where('id',$request->id)->update(['show_status'=>"M",'matching_status'=>"2"]);  
          return $results;

        }else if($results=="Ed"){
          
          $updateExistOrNot=\DB::table('sale_contracts')->where('id',$request->id)->update(['show_status'=>"E",'matching_status'=>"2"]);
          return $results;

        }else if($results=="S"){
          
            $updateExistOrNot=\DB::table('sale_contracts')->where('id',$request->id)->update(['show_status'=>"S",'matching_status'=>"2"]);
            return $results;
  
        }else if($results=="success"){
          
          $updateExistOrNot=\DB::table('sale_contracts')->where('id',$request->id)->update(['matching_status'=>"1"]);
          return $results;
           
        }
        

    }

    private function checkItemRateMatching($request){
         
        $second_approval=NotifyParty::where('id',SaleContract::where('id',$request->id)->value('notify_pary_id'))->value('second_approval');
        for ($i=0; $i<count($request->matching_info); $i++) { 
                 
          $request->matching_info[$i]['rate'];  
          $item_code=$request->matching_info[$i]['item_code'];
          $ciItem=CiItem::where('ci_item_code',$request->matching_info[$i]['item_code'])->first(['id']);
          $item_rate=preg_replace('/(?<=\d)\s+(?=\d)/', '', $request->matching_info[$i]['rate']); 
          $item_rate=(float)$item_rate;
          $warehouse=Depot::where('id', $request->wh_id)->first(['d_code']);
          $depo_code=$warehouse->d_code;
          $allowPercent=ApprovePercent::where('id','1')->first(['min_percent','max_percent']);
          $checkMatchingStatus=SaleContractDetail::where('sale_contract_id',$request->id)
                              ->where('ci_item_id',$ciItem->id)
                              ->first(['rate_status']);
                               
          if(is_null($checkMatchingStatus->rate_status)){
               
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
                $result=json_decode($response);
                if(!empty($result)){
                       
                    foreach($result as $val){
                         
                        $status='Y';
                        $percent=0;
                        if($val->XX > 0){
                            
                            $percent=round((($item_rate-$val->XX)/$item_rate)*100,3);
                            if($percent>$allowPercent->min_percent && $percent<=$allowPercent->max_percent){

                                if($second_approval==316){
                                    $status='S';
                                }else{
                                    $status='E'; 
                                }   
                                  
                                  
                            }elseif($percent<=$allowPercent->min_percent) {
                                
                              $status='M';

                            }elseif($percent>$allowPercent->max_percent) {
                                
                              $status='Y';  

                            }  

                        }

                        $ci_item=CiItem::where('ci_item_code', $request->matching_info[$i]['item_code'])->first(['id']); 
                        $detailsID=SaleContractDetail::where('sale_contract_id',$request->id)->where('ci_item_id',$ci_item->id)->first(['id']);
                        $jobDetails=SaleContractDetail::findorfail($detailsID->id);
                        $jobDetails->rate_status=$status;
                        $jobDetails->rate_percent=$percent;
                        $jobDetails->per_piece_rate=$item_rate;
                        $jobDetails->prime_cost=$val->XX;
                        $jobDetails->save();
                      
                    }

                    $job_order_master=SaleContract::findorfail($request->id);
                    $job_order_master->matching_status=0;
                    $job_order_master->save();


                }else{
                    
                    $ci_item=CiItem::where('ci_item_code', $request->matching_info[$i]['item_code'])->first(['id']); 
                    $detailsID=SaleContractDetail::where('sale_contract_id',$request->id)->where('ci_item_id',$ci_item->id)->first(['id']);
                    $jobDetails=SaleContractDetail::findorfail($detailsID->id);
                    $jobDetails->rate_status='Y';
                    $jobDetails->rate_percent=0;
                    $jobDetails->per_piece_rate=$item_rate;
                    $jobDetails->prime_cost=0;
                    $jobDetails->save();

                } 
          

          }                    

        } 

        $rateMatchingMdStatus=SaleContractDetail::where('sale_contract_id',$request->id)
            ->where('rate_status','M')
            ->get();

        $rateMatchingOtherStatus=SaleContractDetail::where('sale_contract_id',$request->id)
            ->where('rate_status','=','S')
            ->get();       
 
        $rateMatchingEDStatus=SaleContractDetail::where('sale_contract_id',$request->id)
            ->where('rate_status','E')
            ->where('rate_status','!=','M')
            ->where('rate_status','!=','S')
            ->get(); 

        if(count($rateMatchingMdStatus)>0) {
             
           return 'Md';

        }elseif(count($rateMatchingEDStatus)>0){
            
           return 'Ed';

        }elseif(count($rateMatchingOtherStatus)>0){
            
            return 'S';
 
        }else{

            return 'success';
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
                        sale_contract_details.prime_cost,
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

        // $rateMatchingOtherStatus=SaleContractDetail::where('sale_contract_id',$request->id)
        //     ->where('rate_status','S')
        //     ->get();             
        
         

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
           
            $this->sendMailToMdSir($request->id,$rateMatchingMdStatus,$item_ids,$wh);
            return 'Md';
 
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

        // array_push($email_array,'md@prangroup.com');
        // array_push($email_array,'finance@prangroup.com');
        array_push($email_array,'md@prangroup.com');
        $jo_notification_mail_lists = MailList::where('is_active', 1)->where('jo_notification', 1)->whereNotNull('email')->where('email', '!=', '')->pluck('email')->toArray();
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
        $jo_notification_mail_lists = MailList::where('is_active', 1)->where('jo_notification', 1)->whereNotNull('email')->where('email', '!=', '')->pluck('email')->toArray();
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

            $this->pushCrmData($request->cancel_id);    
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

}
