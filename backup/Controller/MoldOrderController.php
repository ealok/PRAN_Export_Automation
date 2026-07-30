<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Company;
use App\CiItem;
use App\MoldOrder;
use App\MoldOdrMaster;
use App\MoldOderDetails;
use App\POMaster;
use App\NotifyPartyItem;
use App\POItemDetails;
use App\SaleContract;
use App\SaleContractDetail;
use App\JobOrderMaster;
use App\JobOrderDetails;
use Carbon\Carbon;
use App\JObOrderNumber2;
use App\Importer;
use App\PODetails;
use App\TemplateDetail;
use App\User;
use App\seaPortdashboard;
use App\NotifyParty;
use App\ScWiseJOList;
use App\Role;
use Mail;
use Auth;
class MoldOrderController extends Controller
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
        return view('mold_order.index');         
    }
    public function getMoldOrderList(Request $request){
        
        $results=DB::select("select
                mold_odr_master.order_number as odr_number,
                mold_odr_master.order_name as project_name,
                date_format(mold_odr_master.created_at,'%d-%m-%Y') as odr_date
                from mold_odr_master
            where mold_odr_master.status='N'
            group by odr_number,project_name,mold_odr_master.created_at
            order by mold_odr_master.id ASC");

        if(count($results)>0){

            return response()->json([
                'message' => 'Data Found',
                'code' => 500,
                'data'=>$results
            ]);

        }else{

            return response()->json([
                'message' => 'Data Found',
                'code' => 500,
                'data'=>[]
            ]);

        }

    }       
    public function getCreateForm(){

        $moldingProcess=DB::select("select * from mold_process order by id ASC");
        $runnerTypes=DB::select("select * from runner_type order by id ASC");
        $runnerGates=DB::select("select * from runner_gate order by id ASC");
        $noOfCavities=DB::select("select * from no_of_cavity order by id ASC");
        $product_materials=DB::select("select * from product_materials order by id ASC");
        $parties=DB::select('select * from importers where id=565 order by id ASC');
        $machine_sizes=DB::select("select * from machine_size order by id ASC");
        $companies=Company::orderBy('id','ASC')->get();
        return view('mold_order.create')
               ->with('moldingProcess',$moldingProcess)
               ->with('runnerTypes',$runnerTypes)
               ->with('runnerGates',$runnerGates)
               ->with('noOfCavities',$noOfCavities)
               ->with('product_materials',$product_materials)
               ->with('parties',$parties)
               ->with('machine_sizes',$machine_sizes)
               ->with('companies',$companies);

    }
    public function updatedSelectBoxValue(Request $request){
          
        if($request->button_type=='Molding'){
            return $this->addNewMolding($request);
        }else if($request->button_type=='Runner_Type'){
            return $this->addNewRunnerType($request);
        }else if($request->button_type=='Runner_Gate'){
            return $this->addNewRunnerGate($request);
        }else if($request->button_type=='NoOfCavity'){
            return $this->addNewNoOfCavity($request);
        }else if($request->button_type=='MachineSize'){
            return $this->addNewMachineOfSize($request);
        }else if($request->button_type=='ProductMaterial'){
            return $this->addNewProductMaterials($request);
        }

    }
    private function addNewMolding($request){

        DB::table('mold_process')->insertGetId([
            'name' => $request->newProcessName,
            'user_id' => Auth::user()->id
        ]);

        $results=DB::select("select * from mold_process order by id ASC");
        return response()->json([
            'results'=>$results
        ]);


    }
    private function addNewRunnerType($request){

        DB::table('runner_type')->insertGetId([
            'name' => $request->newProcessName,
            'user_id' => Auth::user()->id
        ]);

        $results=DB::select("select * from runner_type order by id ASC");
        return response()->json([
            'results'=>$results
        ]);

    }
    private function addNewRunnerGate($request){

        DB::table('runner_gate')->insertGetId([
            'name' => $request->newProcessName,
            'user_id' => Auth::user()->id
        ]);

        $results=DB::select("select * from runner_gate order by id ASC");
        return response()->json([
            'results'=>$results
        ]);
    }
    private function addNewNoOfCavity($request){

        DB::table('no_of_cavity')->insertGetId([
            'name' => $request->newProcessName,
            'user_id' => Auth::user()->id
        ]);

        $results=DB::select("select * from no_of_cavity order by id ASC");
        return response()->json([
            'results'=>$results
        ]);
    }
    private function addNewMachineOfSize($request){

        DB::table('machine_size')->insertGetId([
            'name' => $request->newProcessName,
            'user_id' => Auth::user()->id
        ]);

        $results=DB::select("select * from machine_size order by id ASC");
        return response()->json([
            'results'=>$results
        ]);
    }
    public function addNewProductMaterials($request){
        DB::table('product_materials')->insertGetId([
            'name' => $request->newProcessName,
            'user_id' => Auth::user()->id
        ]);

        $results=DB::select("select * from product_materials order by id ASC");
        return response()->json([
            'results'=>$results
        ]);
    }

    public function seachJobOrderNumber(Request $request){

        $searchTerm = $request->input('item_code');
        $results = DB::table('job_order_masters')
            ->select(
                'job_order_masters.job_order_number2 as job_order_number'
            )
            ->where('job_order_masters.job_order_number2', 'LIKE', '%' . $searchTerm . '%')
            ->limit(10)
            ->get();
        return response()->json($results);

    }
    
    public function seachItem(Request $request){

        $searchTerm = $request->input('item_code');
        $joNo = $request->input('joNo');
        if($request->isJo){

            $results = DB::table('job_order_masters')
                ->join('job_order_details', 'job_order_masters.id', '=', 'job_order_details.master_id')
                ->join('ci_items', 'ci_items.id', '=', 'job_order_details.item_id')
                ->select('ci_items.ci_item_code as item_code', 'ci_items.ci_item_name as item_name')
                ->where('job_order_details.item_status', 'Y')
                ->where(function($query) use ($searchTerm) {
                    $query->where('ci_items.ci_item_code', 'like', '%' . $searchTerm . '%')
                        ->orWhere('ci_items.ci_item_name', 'like', '%' . $searchTerm . '%');
                })
                ->where('job_order_masters.job_order_number2',$joNo)
                ->limit(10)
                ->get();

        }else{
           
            $results = DB::table('ci_items')
                    ->where(function($query) use ($searchTerm) {
                        $query->where('ci_item_code', 'like', '%' . $searchTerm . '%')
                        ->orWhere('ci_item_name', 'like', '%' . $searchTerm . '%');
                    })
                    ->select('ci_item_code as item_code', 'ci_item_name as item_name')
                    ->limit(10)
                    ->get();
        }
        return response()->json($results);

    }

    public function getFGInfo(Request $request){
           
        $ci_item_name=CiItem::where('id', $request->fg_id)->value('ci_item_name');
        $item_rate=NotifyPartyItem::where('notify_party_id',559)->where('ci_item_id',$request->fg_id)->value('acc_rate') ? NotifyPartyItem::where('notify_party_id',559)->where('ci_item_id',$request->fg_id)->value('acc_rate') : 0;
        return response()->json([
            'ci_item_name'=>$ci_item_name,
            'item_rate'=>$item_rate
        ]);
         
    }
    public function getPartyItems(Request $request){

        $items=DB::select("select ci_items.id,
            concat(ci_items.ci_item_code, ' / ' ,ci_items.ci_item_name) as item
            from notify_party_items
            join ci_items on ci_items.id=notify_party_items.ci_item_id
            where notify_party_id = '$request->party_id'");

        return response()->json([
            'code'=> 200,
            'results'=>$items
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

    public function saveTempMoldOrder(Request $request){
            
        $user_id = Auth::user()->id;
        $lastRecord = DB::table('mold_odr_temp')
            ->where('created_by', $user_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastRecord && $lastRecord->fg_code == $request->fg_code) {
            $currentSequence = $lastRecord->sequence_no;
        } else {
            $maxSequence = DB::table('mold_odr_temp')
                ->where('created_by', $user_id)
                ->max('sequence_no');
                
            // Fixed the null coalescing issue
            $currentSequence = ($maxSequence !== null) ? $maxSequence + 1 : 1;
        }

        // Rest of your code remains the same...
        $inserted_id = DB::table('mold_odr_temp')->insertGetId([
            'order_name' => $request->order_name,
            'sku_number' => $request->sku_number,
            'jo_no' => $request->jo_no,
            'party_id' => $request->party_id,
            'fg_code' => $request->fg_code,
            'fg_name' => $request->fg_name,
            'sfg_code' => $request->sfg_code,
            'sfg_name' => $request->sfg_name,
            'sequence_no' => $currentSequence,
            'mold_process_id' => $request->molding_process,
            'mold_of_design' => isset($request->mold_design) && $request->mold_design ? 1 : 0,
            'mold_aps' => isset($request->mold_aps) && $request->mold_aps ? 1 : 0,
            'runner_type_id' => $request->runner_type_id,
            'runner_gate_id' => $request->runner_gate_id,
            'no_of_cavity' => $request->no_of_cavity,
            'prod_sample_wet' => $request->prod_sample_wet,
            'prod_target_wet' => $request->prod_target_wet,
            'prod_design_wet' => $request->prod_design_wet,
            'prod_tolerance' => $request->prod_tolerance,
            'prod_dim_l' => $request->prod_dim_l,
            'prod_dim_w' => $request->prod_dim_w,
            'prod_dim_h' => $request->prod_dim_h,
            'prod_dim_tolerance' => $request->prod_dim_tolerance,
            'product_material_id' => $request->product_material,
            'stacking' => isset($request->stacking) && $request->stacking ? 1 : 0,
            'stacking_with_existing' => isset($request->with_statcking) && $request->with_statcking ? 1 : 0,
            'stacking_with_new' => isset($request->new_statcking) && $request->new_statcking ? 1 : 0,
            'stacking_height' => isset($request->statcking_height) && $request->statcking_height ? $request->statcking_height : 0,
            'stacking_aps' => isset($request->aps_statcking) && $request->aps_statcking ? 1 : 0,
            'universality' => isset($request->universality) && $request->universality ? 1 : 0,
            'universality_with_existing' => isset($request->universality_with_existing) && $request->universality_with_existing  ? 1 : 0,
            'universality_with_new' => isset($request->universality_with_new) && $request->universality_with_new ? 1 : 0,
            'capacity' => isset($request->capacity) && $request->capacity ? 1 : 0,
            'require_capacity' => isset($request->require_capacity) && $request->require_capacity  ? $request->require_capacity : 0,
            'capacity_with_existing' => $request->existing_capacity_type,
            'capacity_with_aps' => $request->aps_capacity_type,
            'logo_info' => $request->logo_info,
            'logo_with_ins' => $request->with_insert,
            'logo_without_ins' => $request->without_insert,
            'machinge_size_id' => $request->machine_size,
            'texturing' => isset($request->texturing) && $request->texturing  ? 1 : 0,
            'texturing_pattern_etching' => isset($request->texturing_pattern_etching) && $request->texturing_pattern_etching ? 1 : 0,
            'texturing_mat_finishing' => isset($request->texturing_mat_finishing) && $request->texturing_mat_finishing  ? 1 : 0,
            'texturing_spray_etching' => isset($request->texturing_spray_etching) && $request->texturing_spray_etching  ? 1 : 0,
            'texturing_with_aps' => isset($request->texturing_with_aps) && $request->texturing_with_aps  ? 1 : 0,
            'note' => isset($request->note) && $request->note  ? $request->note : '',
            'odr_quantity' => $request->order_qty ? $request->order_qty : 0,
            'delivery_date' => $this->convertedDate($request->delivery_date),
            'created_by' => $user_id
        ]); 

        if ($request->hasFile('mold_file')) {
            $file = $request->file('mold_file');
            $this->uploadMoldAttachment($inserted_id, $file, 'mold');
        }

        if ($request->hasFile('logo_file')) {
            $file = $request->file('logo_file');
            $this->uploadMoldAttachment($inserted_id, $file, 'logo');
        }  
        
        return response()->json([
            'code' => 200,
            'message' => 'Order saved successfully'
        ]); 

    }

    private function convertedDate($delivery_date){

        $dateParts = explode('/', $delivery_date);
        $day = $dateParts[0];
        $month = $dateParts[1];
        $year = $dateParts[2];
        $formattedDate = $year . '-' . $month . '-' . $day;
        return date("Y-m-d", strtotime($formattedDate));
       
    }

    public function getMoldTempEntry(){

        $user_id=Auth::user()->id; 
        $results=DB::select("select
                id,
                order_name,
                fg_name,
                fg_code,
                sfg_code,
                sfg_name,
                sku_number,
                odr_quantity
            from mold_odr_temp
            where created_by='$user_id'");

        return response()->json([
             'data'=>$results,
             'code'=>200
        ]);

    }
	
	public function store(Request $request)
    {
        $user_id = Auth::user()->id; 
        $results = DB::table('mold_odr_temp')
            ->where('created_by', $user_id)
            ->orderBy('fg_code')
            ->orderBy('sequence_no')
            ->orderBy('id', 'asc')
            ->get();
            
        if ($results->isEmpty()) {
            return response()->json([
                'code' => 400,
                'msg' => 'No data found to save'
            ]);
        }

        $firstOrder = $results->first();
        $groupedData = [];
        foreach ($results as $result) {
            $key = $result->fg_code . '_' . $result->sequence_no;
            $groupedData[$key] = $result;
        }

        $moldOdrMasterIds = [];
        foreach ($groupedData as $key => $firstItem) {
            
            $accessories = DB::table('mold_odr_temp')
                ->where('created_by', $user_id)
                ->where('fg_code', $firstItem->fg_code)
                ->where('sequence_no', $firstItem->sequence_no)
                ->get();

            $MoldOdrMaster = new MoldOdrMaster();
            $MoldOdrMaster->party_id = $firstItem->party_id;
            $MoldOdrMaster->fg_id = CiItem::where('ci_item_code', $firstItem->fg_code)->value('id');
            $MoldOdrMaster->fg_code = $firstItem->fg_code;
            $MoldOdrMaster->fg_name = $firstItem->fg_name;
            $MoldOdrMaster->order_name = $firstItem->order_name;
            $MoldOdrMaster->sku_number = $firstItem->sku_number;
            $MoldOdrMaster->job_no = $firstItem->jo_no;
            $MoldOdrMaster->delivery_date = $firstItem->delivery_date;
            $MoldOdrMaster->created_by = $user_id;
            $MoldOdrMaster->updated_by = $user_id;  
            $MoldOdrMaster->save();            
            $moldOdrMasterIds[] = $MoldOdrMaster->id;
            foreach ($accessories as $item) {
                $MoldOderDetails = new MoldOderDetails();
                $MoldOderDetails->order_id = $MoldOdrMaster->id;
                $MoldOderDetails->sequence_no = $item->sequence_no;
                $MoldOderDetails->sfg_code = $item->sfg_code;
                $MoldOderDetails->sfg_name = $item->sfg_name;
                $MoldOderDetails->delivery_date = $item->delivery_date;
                $MoldOderDetails->sku_number = $item->sku_number;
                $MoldOderDetails->mold_process_id = $item->mold_process_id;
                $MoldOderDetails->mold_of_design = $item->mold_of_design;
                $MoldOderDetails->mold_file = $item->mold_file;
                $MoldOderDetails->mold_aps = $item->mold_aps;
                $MoldOderDetails->runner_type_id = $item->runner_type_id;
                $MoldOderDetails->runner_gate_id = $item->runner_gate_id;
                $MoldOderDetails->no_of_cavity = $item->no_of_cavity;
                $MoldOderDetails->prod_sample_wet = $item->prod_sample_wet;
                $MoldOderDetails->prod_target_wet = $item->prod_target_wet;
                $MoldOderDetails->prod_design_wet = $item->prod_design_wet;
                $MoldOderDetails->prod_tolerance = $item->prod_tolerance;
                $MoldOderDetails->prod_dim_l = $item->prod_dim_l;
                $MoldOderDetails->prod_dim_w = $item->prod_dim_w;
                $MoldOderDetails->prod_dim_h = $item->prod_dim_h;
                $MoldOderDetails->prod_dim_tolerance = $item->prod_dim_tolerance;
                $MoldOderDetails->product_material_id = $item->product_material_id;
                $MoldOderDetails->stacking = $item->stacking;
                $MoldOderDetails->stacking_with_existing = $item->stacking_with_existing;
                $MoldOderDetails->stacking_with_new = $item->stacking_with_new;
                $MoldOderDetails->stacking_height = $item->stacking_height;
                $MoldOderDetails->stacking_aps = $item->stacking_aps;
                $MoldOderDetails->universality = $item->universality;
                $MoldOderDetails->universality_with_existing = $item->universality_with_existing;
                $MoldOderDetails->universality_with_new = $item->universality_with_new;
                $MoldOderDetails->capacity = $item->capacity;
                $MoldOderDetails->require_capacity = $item->require_capacity;
                $MoldOderDetails->capacity_with_existing = $item->capacity_with_existing;
                $MoldOderDetails->capacity_with_aps = $item->capacity_with_aps;
                $MoldOderDetails->logo_info = $item->logo_info;
                $MoldOderDetails->logo_with_ins = $item->logo_with_ins;
                $MoldOderDetails->logo_without_ins = $item->logo_without_ins;
                $MoldOderDetails->logo_file = $item->logo_file;
                $MoldOderDetails->machinge_size_id = $item->machinge_size_id;
                $MoldOderDetails->texturing = $item->texturing;
                $MoldOderDetails->texturing_pattern_etching = $item->texturing_pattern_etching;
                $MoldOderDetails->texturing_mat_finishing = $item->texturing_mat_finishing;
                $MoldOderDetails->texturing_spray_etching = $item->texturing_spray_etching;
                $MoldOderDetails->texturing_with_aps = $item->texturing_with_aps;
                $MoldOderDetails->note = $item->note;
                $MoldOderDetails->odr_quantity = $item->odr_quantity;
                $MoldOderDetails->save();
            }
        }

        $party_id=$firstOrder->party_id;
        $po_id=$this->createPO($party_id,$results);
        $sales_contract_id=$this->createSalesContract($party_id,$po_id,$results);
        $jo_number=$this->createJobOrder($moldOdrMasterIds,$party_id,$po_id,$sales_contract_id,$results);    
        $this->sendOrderConfirmationMail($moldOdrMasterIds,$sales_contract_id);
        $this->pushOrderData($jo_number);
        $this->deleteMoldTempRecord();
        return response()->json([
            'code'=>200,
            'msg'=>'Save Successfully..!!'
        ]);

    }

    private function pushOrderData($jo_no){
        
        $masterInfo = DB::select("SELECT DISTINCT
                mm.id                                  AS header_id,
                mm.fg_id                               AS item_id,
                ci_items.ci_item_code                  AS item_code,
                ci_items.ci_item_name                  AS item_name,
                mm.job_no                              AS job_no,
                mm.order_number                        AS jo_number,
                users.username                         AS created_by,
                DATE_FORMAT(mm.created_at, '%d-%b-%y') AS created_date,
                ''                                     AS owner_org_id,
                mm.order_name                          AS project_name,
                mm.sku_number                          AS sku_number,
                'Pending'                              AS status,
                ''                                     AS delivery_date,
                ''                                     AS commit_delivery_date,
                ''                                     AS task_id,
                notify_parties.code                    AS party_code
            FROM mold_odr_master mm
            LEFT JOIN ci_items ON ci_items.id = mm.fg_id
            JOIN notify_parties ON notify_parties.id = mm.party_id
            JOIN users ON users.id = mm.created_by
            WHERE mm.order_number = ?", [$jo_no]);

        $masterData = [];
        foreach($masterInfo as $master) {
            $masterData[] = [
                'HEADER_ID'               => $master->header_id,
                'FORMULA_NO'              => $master->item_code,
                'FORMULA_DESC1'           => $master->item_name,
                'ORDER_NUMBER'            => $master->jo_number, // Create Job order Number 
                'JOB_ORDER_NO'            => $master->job_no,   //Ref Job Order Number 
                'CREATED_BY'              => $master->created_by,
                'CREATION_DATE'           => $master->created_date,
                'OWNER_ORGANIZATION_ID'   => $master->owner_org_id,
                'PROJECT_NAME'            => $master->project_name,  // Project Name
                'SKU_NUMBER'              => $master->sku_number,
                'STATUS'                  => $master->status,
                'DELIVERY_DATE'           => $master->delivery_date,
                'COMMITTED_DELIVERY_DATE' => $master->commit_delivery_date,
                'TASK_ID'                 => 'apps.iseq$$_2743274.NEXTVAL', // Oracle sequence
                'PARTY_CODE'              => $master->party_code,
            ];

        }

        // --- Get detail data ---
        $detailInfo = DB::select("SELECT
                    md.id                                     as line_id,
                    mm.id                                     as header_id,
                    mm.fg_id                                  as item_id,
                    md.mold_file                              as mold_file,
                    md.mold_aps                               as mold_aps,
                    'f'                                       as scraf_fector,
                    md.prod_sample_wet                        as prod_sample_wet,
                    md.prod_target_wet                        as prod_target_wet,
                    md.prod_design_wet                        as prod_design_wet,
                    md.prod_tolerance                         as prod_tolerance,
                    md.prod_dim_l                             as prod_dim_l,
                    users.username                            as last_updated_by,
                    DATE_FORMAT(mm.created_at, '%d-%b-%y')    as last_updated_date,
                    DATE_FORMAT(mm.created_at, '%d-%b-%y')    as create_date,
                    0                                         as last_updated_login,
                    md.note                                   as sample_note,
                    md.sfg_name                               as sample_description,
                    mold_process.name                         as molding_process,
                    md.mold_of_design                         as mold_of_design,
                    runner_type.name                          as runner_type,
                    runner_gate.name                          as runner_gate,
                    md.no_of_cavity                           as no_of_cavity,
                    md.prod_dim_w                             as prod_dim_w,
                    product_materials.name                    as prod_material,
                    md.prod_dim_h                             as prod_dim_h,
                    md.stacking                               as stacking,
                    md.prod_dim_tolerance                     as prod_dim_tolerance,
                    md.capacity                               as capacity,
                    md.logo_info                              as logo_info,
                    md.stacking_with_existing                 as stacking_with_existing,
                    md.stacking_with_new                      as stacking_with_new,
                    md.stacking_height                        as stacking_height,
                    md.stacking_aps                           as stacking_aps,
                    machine_size.name                         as machine_size,
                    md.texturing                              as texturing,
                    md.odr_quantity                           as mold_qty,
                    0                                         as rate,
                    md.sfg_code                               as sfg_code,
                    md.universality                           as universality,
                    md.universality_with_existing             as universality_with_existing,
                    md.universality_with_new                  as universality_with_new,
                    md.require_capacity                       as require_capacity,
                    md.capacity_with_existing                 as capacity_with_existing,
                    md.capacity_with_aps                      as capacity_with_aps,
                    md.logo_with_ins                          as logo_with_ins,
                    1                                         as tpformula_id,
                    1                                         as iaformula_id,
                    'kg'                                      as scale_uom,
                    md.logo_without_ins                       as logo_without_ins,
                    md.logo_file                              as logo_file,
                    md.texturing_pattern_etching              as texturing_pattern_etching,
                    md.texturing_mat_finishing                as texturing_mat_finishing,
                    md.texturing_spray_etching                as texturing_spray_etching,
                    md.texturing_with_aps                     as texturing_with_aps,
                    1                                         as buffer_ind,
                    1                                         as inventory_item_id,
                    1                                         as organization_id,
                    'kg'                                      as detail_uom,
                    1                                         as revision,
                    ''                                        as ingredient_end_date,
                    0                                         as prod_percent,
                    ''                                        as attachment,
                    DATE_FORMAT(md.delivery_date, '%d-%b-%y') as commited_delivery_date,
                    ''                                        as task_id
                FROM mold_odr_master AS mm
                JOIN mold_odr_details AS md ON md.order_id = mm.id
                LEFT JOIN ci_items on ci_items.id = mm.fg_id
                JOIN notify_parties on notify_parties.id = mm.party_id
                JOIN mold_process on mold_process.id = md.mold_process_id
                JOIN runner_type on runner_type.id = md.runner_type_id
                JOIN runner_gate on runner_gate.id = md.runner_gate_id
                JOIN no_of_cavity on no_of_cavity.id = md.runner_gate_id
                JOIN product_materials on product_materials.id = md.product_material_id
                JOIN machine_size on machine_size.id = md.machinge_size_id
                JOIN users on users.id = mm.created_by
                WHERE mm.order_number = ?", [$jo_no]);

        $detailData = [];
        foreach($detailInfo as $detail) {
            $detailData[] = [
                'LINE_ID'                      => $detail->line_id,
                'HEADER_ID'                    => $detail->header_id,
                'MOLD_FILE'                    => $detail->mold_file,
                'MOLD_APS'                     => $detail->mold_aps,
                'SCRAP_FACTOR'                 => $detail->scraf_fector,
                'PROD_SAMPLE_WET'              => $detail->prod_sample_wet,
                'PROD_TARGET_WET'              => $detail->prod_target_wet,
                'PROD_DESIGN_WET'              => $detail->prod_design_wet,
                'PROD_TOLERANCE'               => $detail->prod_tolerance,
                'PROD_DIM_L'                   => $detail->prod_dim_l,
                'LAST_UPDATED_BY'              => $detail->last_updated_by,
                'LAST_UPDATE_DATE'             => $detail->last_updated_date,
                'CREATION_DATE'                => $detail->create_date,
                'LAST_UPDATE_LOGIN'            => $detail->last_updated_login,
                'NOTE'                         => $detail->sample_note,
                'DESCRIPTION'                  => $detail->sample_description,
                'MOLDING_PROCESS'              => $detail->molding_process,
                'MOLD_OF_DESIGN'               => $detail->mold_of_design,
                'RUNNER_TYPE'                  => $detail->runner_type,
                'RUNNER_GATE'                  => $detail->runner_gate,
                'NO_OF_CAVITY'                 => $detail->no_of_cavity,
                'PROD_DIM_W'                   => $detail->prod_dim_w,
                'PRODUCT_MATERIAL'             => $detail->prod_material,
                'PROD_DIM_H'                   => $detail->prod_dim_h,
                'STATCKING'                    => $detail->stacking,
                'PROD_DIM_TOLERANCE'           => $detail->prod_dim_tolerance,
                'CAPACITY'                     => $detail->capacity,
                'LOGO_INFO'                    => $detail->logo_info,
                'STACKING_WITH_EXISTING'       => $detail->stacking_with_existing,
                'STACKING_WITH_NEW'            => $detail->stacking_with_new,
                'STACKING_HEIGHT'              => $detail->stacking_height,
                'STACKING_APS'                 => $detail->stacking_aps,
                'MACHINE_SIZE'                 => $detail->machine_size,
                'TEXTURING'                    => $detail->texturing,
                'MOLD_QTY'                     => $detail->mold_qty,
                'RATE'                         => $detail->rate,
                'SFG_CODE'                     => $detail->sfg_code,
                'UNIVERSALITY'                 => $detail->universality,
                'UNIVERSALITY_WITH_EXISTING'   => $detail->universality_with_existing,
                'UNIVERSALITY_WITH_NEW'        => $detail->universality_with_new,
                'REQUIRE_CAPACITY'             => $detail->require_capacity,
                'CAPACITY_WITH_EXISTING'       => $detail->capacity_with_existing,
                'CAPACITY_WITH_APS'            => $detail->capacity_with_aps,
                'LOGO_WITH_INS'                => $detail->logo_with_ins,
                'TPFORMULA_ID'                 => $detail->tpformula_id,
                'IAFORMULA_ID'                 => $detail->iaformula_id,
                'SCALE_UOM'                    => $detail->scale_uom,
                'LOGO_WITHOUT_INS'             => $detail->logo_without_ins,
                'LOGO_FILE'                    => $detail->logo_file,
                'TEXTURING_PATTERN_ETCHING'    => $detail->texturing_pattern_etching,
                'TEXTURING_MAT_FINISHING'      => $detail->texturing_mat_finishing,
                'TEXTURING_SPRAY_ETCHING'      => $detail->texturing_spray_etching,
                'TEXTURING_WITH_APS'           => $detail->texturing_with_aps,
                'BUFFER_IND'                   => $detail->buffer_ind,
                'INVENTORY_ITEM_ID'            => $detail->inventory_item_id,
                'ORGANIZATION_ID'              => $detail->organization_id,
                'DETAIL_UOM'                   => $detail->detail_uom,
                'REVISION'                     => $detail->revision,
                'INGREDIENT_END_DATE'          => $detail->ingredient_end_date,
                'PROD_PERCENT'                 => $detail->prod_percent,
                'ATTACHMENT'                   => $detail->attachment,
                'COMMITTED_DELIVERY_DATE'      => $detail->commited_delivery_date,
                'TASK_ID'                      => 'apps.iseq$$_2743274.NEXTVAL', // Oracle sequence
            ];
        }

        // --- Build InsertAll function ---
        $buildInsertAll = function($table, $rows) {
            if (empty($rows)) return '';
            $columns = array_keys($rows[0]);
            $sql = " INSERT ALL\n";
            foreach ($rows as $row) {
                $values = array_map(function ($val) {
                    if (is_null($val)) return "NULL";
                    if (is_numeric($val)) return $val;
                    // Keep Oracle sequence RAW
                    if (preg_match('/^apps\.[A-Za-z0-9_\$]+\.NEXTVAL$/', $val)) return $val;
                    return "'" . addslashes($val) . "'";
                }, array_values($row));
                $sql .= "  INTO {$table} (" . implode(', ', $columns) . ")\n";
                $sql .= "  VALUES (" . implode(', ', $values) . ")\n";
            }
            $sql .= "SELECT * FROM dual \n";
            $sql .= "\n";
            return $sql;
        };

        

        // --- Generate SQL ---
        $masterSql = $buildInsertAll('apps.xxprg_mold_formula_mst', $masterData);
        $detailSql = $buildInsertAll('apps.xxprg_mold_formula_dtl', $detailData);
        // --- API Call ---
        $baseUrl = 'https://ego.rflgroupbd.com:8077/ords/rpro/buyinfo/testinsertall_inonego';
        $param1 = [
            'strSql_M' => $masterSql,
            'strSql_D' => "select * from dual",
        ];

        $param2 = [
            'strSql_M' => "select * from dual",
            'strSql_D' => $detailSql,
        ];

        // return $params;
        $url = $baseUrl . '?' . http_build_query($param1);
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
        ]);

        $responseData = curl_exec($curl);
        curl_close($curl);

        $url = $baseUrl . '?' . http_build_query($param2);
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
        ]);
        $responseData = curl_exec($curl);
        curl_close($curl);

       
    }

    public function deleteTempMoldRecord(Request $request){
        
        $orderId = $request->input('order_id');
        $deleted = DB::table('mold_odr_temp')
            ->where('id', $orderId)  // Find the record where the id matches
            ->delete();  // Delete the record

        return response()->json([
             'code'=>200
        ]);

    }

    public function sendOrderConfirmationMail($moldOdrMasterIds,$sales_contract_id){
        
        $placeholders = implode(',', array_fill(0, count($moldOdrMasterIds), '?'));
        $sales_contact=SaleContract::where('id',$sales_contract_id)->first(['invoice_no','po_number']);
        $items = DB::select("SELECT
                ci_items.ci_item_code AS fg_code,
                ci_items.ci_item_name AS fg_name,
                mold_odr_details.sfg_code,
                mold_odr_details.sfg_name,
                mold_process.name AS mold_proces,
                CASE WHEN mold_of_design THEN 'Y' ELSE '' END AS mold_of_design,
                mold_file,
                CASE WHEN mold_aps THEN 'Y' ELSE '' END AS mold_aps,
                runner_type.name AS runner_type,
                runner_gate.name AS runner_gate,
                no_of_cavity.name AS no_of_cavity,
                prod_sample_wet,
                prod_target_wet,
                prod_design_wet,
                prod_tolerance,
                product_materials.name AS product_material,
                prod_dim_l,
                prod_dim_w,
                prod_dim_h,
                prod_dim_tolerance,
                CASE WHEN stacking THEN 'Y' ELSE '' END AS stacking,
                CASE WHEN stacking_with_existing THEN 'Y' ELSE '' END AS stacking_with_existing,
                CASE WHEN stacking_with_new THEN 'Y' ELSE '' END AS stacking_with_new,
                stacking_height,
                CASE WHEN stacking_aps THEN 'Y' ELSE '' END AS stacking_aps,
                CASE WHEN universality THEN 'Y' ELSE '' END AS universality,
                CASE WHEN universality_with_existing THEN 'Y' ELSE '' END AS universality_with_existing,
                CASE WHEN universality_with_new THEN 'Y' ELSE '' END AS universality_with_new,
                CASE WHEN capacity THEN 'Y' ELSE '' END AS capacity,
                require_capacity,
                CASE WHEN capacity_with_existing THEN 'Y' ELSE '' END AS capacity_with_existing,
                CASE WHEN capacity_with_aps THEN 'Y' ELSE '' END AS capacity_with_aps,
                CASE WHEN logo_info THEN 'Y' ELSE '' END AS logo_info,
                CASE WHEN logo_with_ins THEN 'Y' ELSE '' END AS logo_with_ins,
                CASE WHEN logo_without_ins THEN 'Y' ELSE '' END AS logo_without_ins,
                logo_file,
                machine_size.name AS machine_size,
                CASE WHEN texturing THEN 'Y' ELSE '' END AS texturing,
                CASE WHEN texturing_pattern_etching THEN 'Y' ELSE '' END AS texturing_pattern_etching,
                CASE WHEN texturing_mat_finishing THEN 'Y' ELSE '' END AS texturing_mat_finishing,
                CASE WHEN texturing_spray_etching THEN 'Y' ELSE '' END AS texturing_spray_etching,
                CASE WHEN texturing_with_aps THEN 'Y' ELSE '' END AS texturing_with_aps,
                note,
                odr_quantity
            FROM mold_odr_details
            JOIN mold_odr_master on mold_odr_details.order_id = mold_odr_master.id
            LEFT JOIN ci_items on ci_items.id=mold_odr_master.fg_id
            JOIN mold_process ON mold_process.id = mold_odr_details.mold_process_id
            JOIN runner_type ON runner_type.id = mold_odr_details.runner_type_id
            JOIN runner_gate ON runner_gate.id = mold_odr_details.runner_gate_id
            JOIN no_of_cavity ON no_of_cavity.id = mold_odr_details.no_of_cavity
            JOIN product_materials ON product_materials.id = mold_odr_details.product_material_id
            JOIN machine_size ON machine_size.id = mold_odr_details.machinge_size_id
            WHERE mold_odr_details.order_id IN ($placeholders)
        ", $moldOdrMasterIds);

        $email_array = array('rfltoolroom2@prangroup.com','mis94@mis.prangroup.com','mis6@mis.prangroup.com');
        //$email_array = array('mis94@mis.prangroup.com');
        $email_array = array();
        $email_array[] = Auth::user()->email;
        $moldOrderMaster=MoldOdrMaster::where('id',$moldOdrMasterIds[0])->first(['order_number','order_name']);
        $data = [
            'items'  => $items,
            'project_name'=>$moldOrderMaster->order_name,
            'order_number'=>$moldOrderMaster->order_number,
            'po_no'  => $sales_contact->po_number,
            'inv_no' => $sales_contact->invoice_no,
            'email_array'=>$email_array
        ];

        $from_mail = env('MAIL_FROM_ADDRESS');
        try {
            Mail::send('mail.mold_mail_template', $data, function($message) use ($from_mail, $data) {
                $message->from($from_mail, 'Rfl-Mold@rflgroupbd.com');
                $message->to($data['email_array']);
                $message->subject('New Mold Order Notification');
            });
            // If Mail::send() executes without exceptions, it means the email was sent
            return response()->json(['status' => 'success', 'message' => 'Email sent successfully.']);
        } catch (\Exception $e) {
            // If an exception occurs, it means there was an error sending the email
            return response()->json(['status' => 'error', 'message' => 'Failed to send email. Error: ' . $e->getMessage()]);
        }

    }
 
    public function createPO($party_id,$results){

        $POMaster=new POMaster();
        $POMaster->PARTY_ID=$party_id;
        $POMaster->CREATE_DATE=date("Y-m-d");
        $POMaster->REMARK='Manually Created';
        $POMaster->PO_DATE=date("Y-m-d");
        $POMaster->ORDER_QTY=0;
        $POMaster->ORDER_STATUS='Y';
        $POMaster->TEMPLATE_ID=14;
        $POMaster->DELIVERY_DATE=date("Y-m-d");
        $POMaster->INSPECTION_DATE=date("Y-m-d");
        $POMaster->IUID=Auth::user()->id;
        $POMaster->EUID=Auth::user()->id;
        $POMaster->save();
        $po_number = 'PO'.date('mY').str_pad($POMaster->id, 6, "0", STR_PAD_LEFT);
        $POMaster->PO_NO=$po_number;
        $POMaster->BUYER_PO=$po_number;
        $POMaster->save();
        foreach($results as $result) {
               
            $poItemDetails=new POItemDetails();
            $poItemDetails->master_id=$POMaster->id;
            $poItemDetails->item_id=$result->fg_code;
            $poItemDetails->item_name=$result->fg_name;
            $poItemDetails->do_unit=$result->odr_quantity;
            $poItemDetails->order_qty=$result->odr_quantity;
            $poItemDetails->sample_qty_pcs=0;
            $poItemDetails->net_weight_per_piece=0;
            $poItemDetails->gross_weight_per_piece=0;
            $poItemDetails->unit_per_ctn=1;
            $poItemDetails->acct_rate_per_piece=NotifyPartyItem::where('notify_party_id',$party_id)->where('ci_item_id',$result->fg_code)->value('acc_rate') ? NotifyPartyItem::where('notify_party_id',$party_id)->where('ci_item_id',$result->fg_code)->value('acc_rate'): 0;
            $poItemDetails->party_rate_per_piece=NotifyPartyItem::where('notify_party_id',$party_id)->where('ci_item_id',$result->fg_code)->value('acc_rate') ? NotifyPartyItem::where('notify_party_id',$party_id)->where('ci_item_id',$result->fg_code)->value('acc_rate'): 0;
            $poItemDetails->ci_rate_per_piece=0;
            $poItemDetails->l=0;
            $poItemDetails->w=0;
            $poItemDetails->h=0;
            $poItemDetails->stack=0;
            $poItemDetails->total_cbm=0;
            $poItemDetails->l2=0;
            $poItemDetails->w2=0;
            $poItemDetails->h2=0;
            $poItemDetails->cbm=0;
            $poItemDetails->description_id=0;
            $poItemDetails->depo=0;
            $poItemDetails->total_ctn=1;
            // ----------------------------

            $poItemDetails->factor=1;
            $poItemDetails->rate_per_ctn=1;
            $poItemDetails->order_qty_ctn=1;
            $poItemDetails->sc_qty_ctn=1;
            $poItemDetails->cbm_per_ctn=0;
            $poItemDetails->ref_code=0;
            $poItemDetails->hs_code=0;
            $poItemDetails->specifition='no';
            $poItemDetails->user_id=Auth::user()->id;
            $poItemDetails->save(); 

        }

        $templateDetails=TemplateDetail::where('MASTER_ID',14)->orderBy('ID','ASC')->get();
        foreach($templateDetails as $templateDetail){

            $PODetails=new PODetails();
            $PODetails->MASTER_ID=$POMaster->id;
            $PODetails->TASK_ID=$templateDetail->TASK_ID;
            $PODetails->STD=0;
            $PODetails->FROM_DATE=date('Y-m-d');
            $PODetails->TO_DATE=date('Y-m-d');
            $PODetails->save();  
        }   

        return $POMaster->id;

    }

    private function createSalesContract($party_id,$po_id, $results){

        $id=170;
        $sale_contract_prev = SaleContract::find($id);
        $sale_contract = new SaleContract();
        $sale_contract->sales_contract_no=$this->generateInvoiceNumber();
        $sale_contract->dated=date("Y-m-d");
        $sale_contract->invoice_no=$this->generateInvoiceNumber();
        $sale_contract->ad_code=$sale_contract_prev->ad_code;
        $sale_contract->ci_note=$sale_contract_prev->ci_note;
        $sale_contract->discharge_port=$sale_contract_prev->discharge_port;
        $sale_contract->country_id=$sale_contract_prev->country_id;
        $sale_contract->sales_term_id=$sale_contract_prev->sales_term_id;
        $sale_contract->company_id=$sale_contract_prev->company_id;
        $sale_contract->bank_id=$sale_contract_prev->bank_id;
        $sale_contract->account_number=$sale_contract_prev->account_number;
        $sale_contract->importer_id=$party_id;
        $sale_contract->bank_importer_id=$sale_contract_prev->bank_importer_id;
        $sale_contract->notify_pary_id=$party_id;
        $sale_contract->carrying_mode_id=$sale_contract_prev->carrying_mode_id;
        $sale_contract->loading_place_id=$sale_contract_prev->loading_place_id;
        $sale_contract->final_destination= 'No';
        $sale_contract->terms_and_condition = 'No';
        $sale_contract->terms_and_condition_desk_inv = 'No';
        $sale_contract->freight_cost = 0;
        $sale_contract->container=0;
        $sale_contract->container_1=NULL;
        $sale_contract->container_2=NULL;
        $sale_contract->container_3=NULL;
        $sale_contract->freight_cost_1 = 0;
        $sale_contract->freight_cost_2 = 0;
        $sale_contract->freight_cost_3 = 0;
        $sale_contract->freight_cost = 0;
        $sale_contract->importer_country  = NULL;
        $sale_contract->angikar_given_by  = NULL;
        $sale_contract->po_number = POMaster::where('id',$po_id)->value('po_no');
        $sale_contract->po_master_id  = $po_id;
        $sale_contract->approver_id = null;
        $sale_contract->approved_at = null;
        $sale_contract->creator_id = Auth::user()->id;
        $sale_contract -> save();
        foreach($results as $value){

            $rate=NotifyPartyItem::where('notify_party_id',$party_id)->where('ci_item_id',$value->fg_code)->value('acc_rate') ? NotifyPartyItem::where('notify_party_id',$party_id)->where('ci_item_id',$value->fg_code)->value('acc_rate'): 0;
            $sale_contract_detail                                   = new SaleContractDetail();
            $sale_contract_detail->ci_item_id                       = $value->fg_code;
            $sale_contract_detail->ref_code                         = $value->fg_code;
            $sale_contract_detail->desk_item_name                   = $value->fg_name;
            $sale_contract_detail->sale_contract_id                 = $sale_contract->id;
            $sale_contract_detail->rate_per_ctn_for_party           = $rate;
            $sale_contract_detail->rate_per_ctn_for_acc             = $rate;
            $sale_contract_detail->ctn                              = 1;
            $sale_contract_detail->rate_per_ctn                     = 0;
            $sale_contract_detail->do_unit                          = $value->odr_quantity;
            $sale_contract_detail->pcs_in_ctn                       = $value->odr_quantity;
            $sale_contract_detail->total_amount                     = $value->odr_quantity*$rate;
            $sale_contract_detail->total_amount_party               = $value->odr_quantity*$rate;
            $sale_contract_detail->total_amount_acc                 = $value->odr_quantity*$rate;
            $sale_contract_detail->net_weight_kg                    = 0;
            $sale_contract_detail->gross_weight_kg                  = 0;
            $sale_contract_detail->hs_code                          = NULL;
            $sale_contract_detail->factor                           = 1;
            $sale_contract_detail->l                                = 0; 
            $sale_contract_detail->h                                = 0;
            $sale_contract_detail->w                                = 0;
            $sale_contract_detail->stack                            = 0;
            $sale_contract_detail->total_cbm                        = 0;
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
            $sale_contract_detail->sample_qty                       = 0;
            $sale_contract_detail->depo                             = 0;
            $sale_contract_detail ->save();

        }

        $saleContract=SaleContract::where('id',$sale_contract->id)->first(['id','po_master_id','creator_id','invoice_no','created_at','notify_pary_id']);
        $user=User::where('id',Auth::user()->id)->first(['id','username','name']);
        $po_master=POMaster::where('id',$po_id)->first(['ID','TEMPLATE_ID','PO_NO','CREATE_DATE']);
        $po_details=DB::select("select
                task_definition.DESCRIPTION as description,
                po_details.TASK_ID          as task_id,
                po_details.FROM_DATE        as from_date,
                task_definition.USER_TYPE   as user_type,
                po_details.TO_DATE          as to_date
            from po_details
            join task_definition on task_definition.ID = po_details.TASK_ID
            where po_details.MASTER_ID = $po_id");

       
        foreach($po_details as $key => $value){
        
            $user->username.'-'.$user->name;
            $seaPortdashboard=new seaPortdashboard();
            $seaPortdashboard->sc_id=$saleContract->id;
            $seaPortdashboard->party_id=$saleContract->notify_pary_id;
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
            
            $seaPortdashboard->buyer=NotifyParty::where('id',$saleContract->notify_pary_id)->value('ref_name');
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
            $seaPortdashboard->user_id=$user->id;
            $seaPortdashboard->insert_date=date('Y-m-d');
            $seaPortdashboard->save(); 
            $seaPortdashboard->id;
        } 

        return $sale_contract->id;

    }

    public function createJobOrder($moldOdrMasterIds,$party_id,$po_id,$sale_contract_id,$results){
         
        $sale_contract=SaleContract::where('id',$sale_contract_id)->first(['importer_id']);
        $jo_no=$this->getJobOrderNumber2($sale_contract->importer_id,'N/A');
        $jobOrderMaster=new JobOrderMaster();
        $jobOrderMaster->importer_id=$sale_contract->importer_id;
        $jobOrderMaster->sale_contract_id=$sale_contract_id;
        $jobOrderMaster->shipping_mask="RFL";
        $jobOrderMaster->note=NULL;
        $jobOrderMaster->issue_date=date('Y-m-d');
        $jobOrderMaster->delivery_date=POMaster::where('id',$po_id)->value('DELIVERY_DATE');
        $jobOrderMaster->mfg_date_orginal=NULL;
        $jobOrderMaster->mfg_date=NULL;
        $jobOrderMaster->batch_number=NULL;
        $jobOrderMaster->job_order_number=$jo_no; 
        $jobOrderMaster->job_order_number2=$jo_no;           
        $jobOrderMaster->best_before=0;
        $jobOrderMaster->imp_by=NULL;
        $jobOrderMaster->distributed_by=NULL;
        $jobOrderMaster->user_id=Auth::user()->id;
        $jobOrderMaster->status=1;
        $jobOrderMaster->job_type='Mold';
        $jobOrderMaster->save();
        foreach($results as $key => $value) {
                
            $rate=NotifyPartyItem::where('notify_party_id',$party_id)->where('ci_item_id',$value->fg_code)->value('acc_rate') ? NotifyPartyItem::where('notify_party_id',$party_id)->where('ci_item_id',$value->fg_code)->value('acc_rate'): 0;
            $jobOrderDetails=new JobOrderDetails();
            $jobOrderDetails->master_id=$jobOrderMaster->id;
            $jobOrderDetails->item_id=$value->fg_code; 
            $jobOrderDetails->op=NULL; 
            $jobOrderDetails->depo=NULL;  
            $jobOrderDetails->exp_date=NULL;
            $jobOrderDetails->factor=1;
            $jobOrderDetails->qty=1;
            $jobOrderDetails->du_unit=2;
            $jobOrderDetails->ru_unit=2;
            $jobOrderDetails->orqt=$value->odr_quantity;
            $jobOrderDetails->sale_contact_qty=$value->odr_quantity;
            $jobOrderDetails->smqt=0;
            $jobOrderDetails->coding_matter=NULL;
            $jobOrderDetails->sreq=NULL;
            $jobOrderDetails->rate=$rate;
            $jobOrderDetails->update_by=Auth::user()->id;
            $jobOrderDetails->version=1;
            $jobOrderDetails->save();  

        }      

        $scWiseJOList=new ScWiseJOList();
        $scWiseJOList->sc_id=$sale_contract_id;
        $scWiseJOList->po_id=SaleContract::where('id',$sale_contract_id)->value('po_master_id');
        $scWiseJOList->jo_id=$jobOrderMaster->id;
        $scWiseJOList->jo_no=$jo_no;
        $scWiseJOList->save();     
        MoldOdrMaster::whereIn('id',$moldOdrMasterIds)->update([
            'order_number'=>$jo_no 
        ]);
        return $jo_no;
             
    }

    public function uploadMoldAttachment($inserted_id, $file, $ftype){

        if($file) {

            $filePath = $file->getRealPath();
            $fileName = $file->getClientOriginalName();
            $cFile = new \CURLFile($filePath, $file->getClientMimeType(), $fileName);
            $cFile->setPostFilename($fileName); // Set filename for cURL
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://rqc.rflgroupbd.com:8016/upload/mold_attach', // Endpoint URL
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
            $error = curl_error($curl);
            curl_close($curl);
            if($error){

                return response()->json(['error' => $error], 500);

            }else{

                $responseArray = json_decode($response, true);
                $filePath = $responseArray['file_path'];
                if($ftype=='mold'){
                  
                   DB::table('mold_odr_temp')->where('id',$inserted_id)->update(['mold_file'=>$filePath]);
                }

                if($ftype=='logo'){
                   DB::table('mold_odr_temp')->where('id',$inserted_id)->update(['logo_file'=>$filePath]);
                }

            }

        } else {

            return response()->json(['error' => 'No file provided'], 400);

        }
        
    }

    function generateInvoiceNumber()
    {
        $currentYear = Carbon::now()->format('y');
        $fullYear = Carbon::now()->format('Y'); 
        $invoiceCounter = DB::table('invoice_counters')->where('year', $fullYear)->first();
        if ($invoiceCounter) {
            $newInvoiceNumber = $invoiceCounter->last_invoice_number + 1;
            DB::table('invoice_counters')->where('year', $fullYear)->update(['last_invoice_number' => $newInvoiceNumber]);
        } else {
            $newInvoiceNumber = 1;
            DB::table('invoice_counters')->insert([
                'year' => $fullYear,
                'last_invoice_number' => $newInvoiceNumber
            ]);
        }

        $invoiceNumber = str_pad($newInvoiceNumber, 2, '0', STR_PAD_LEFT);
        $invoiceFormat = "RFL-Mold-Inv-{$invoiceNumber}-{$currentYear}";
        return $invoiceFormat;

    }

    private function getJobOrderNumber2($importer_id,$country_notation){
           
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
        $importerIdExistOrNOt =JObOrderNumber2::orderBy('id','Desc')->where('importer_id',$importer_id)->where('year',$currentYear)->first();
        $importerIdExistOrNOtArray=(array)$importerIdExistOrNOt;
        $short_name=Importer::where('id',$importer_id)->value('ref_name');
        if(count($importerIdExistOrNOtArray)>0){

            $number=$importerIdExistOrNOt->number+1;
            $jobOrderNumber=new JObOrderNumber2();
            $jobOrderNumber->importer_id=$importer_id;
            $jobOrderNumber->number=$number;
            $jobOrderNumber->year=$currentYear;
            $jobOrderNumber->save();
            $create_number=str_pad($number,2,'0',STR_PAD_LEFT);
            if($country_notation=='N/A'){

                return $jobOrderNumber=$short_name.'-'.date('y').'-'.str_pad($number,2,'0',STR_PAD_LEFT);

            }else{

                return $jobOrderNumber=$short_name.'-'.date('y').'-'.str_pad($number,2,'0',STR_PAD_LEFT).'-'.$country_notation;
            }
             
         
        }else{

           $number=1;
           $jobOrderNumber=new JObOrderNumber2();
           $jobOrderNumber->importer_id=$importer_id;
           $jobOrderNumber->number=1;
           $jobOrderNumber->year=$currentYear;
           $jobOrderNumber->save();
           $create_number=str_pad($number,2,'0',STR_PAD_LEFT); 
           if($country_notation=='N/A'){

             return $jobOrderNumber=$short_name.'-'.date('y').'-'.str_pad($number,2,'0',STR_PAD_LEFT);
            
           }else{

             return $jobOrderNumber=$short_name.'-'.date('y').'-'.str_pad($number,2,'0',STR_PAD_LEFT).'-'.$country_notation;

           }
                      
        }
        
    }

    public function deleteMoldTempRecord(){

       DB::table('mold_odr_temp')->where('created_by',Auth::user()->id)->delete(); 
    
    }

    public function inactiveMoldOrder(Request $request){

       $result=MoldOdrMaster::where('order_number', $request->joNo)->update([
          'status'=>'Y'
       ]);

       if($result){
 
          return response()->json([
              'code'=>200,
              'msg'=>'The Order Cancel Done !!'
          ]);
          
       }else{
          return response()->json([
              'code'=>500,
              'msg'=>'Order Inactive Fail !!'
          ]);
       }

    }

    public function moldQuery(Request $request){
       
        $importers=Importer::where('id',565)->get();
        return view('mold_order.mold_query')
              ->with('importers',$importers);

    }

    public function getMoldMoldQueryList(Request $request){
              

        $orderNumber=NULL; 
        $from_date=NULL;
        if($request->fromDate){
           
            $from_date=date("Y-m-d", strtotime($request->fromDate));
            
        }  

        $to_date=NULL;
        if($request->toDate){
           
            $to_date=date("Y-m-d", strtotime($request->toDate));
 
        }    
        $party_id=NULL;
        if($request->partyId){

            $party_id=$request->partyId; 

        }

        $order_no=NULL;
        if($request->orderNumber){

            $order_no=$request->orderNumber; 

        }
 
        $results=DB::select("CALL PROC_MOLD_QUERY(?,?,?,?)", [$from_date,$to_date,$party_id,$order_no]);
        if(count($results)>0){

            return response()->json([
                'data'=>$results,
                'code'=>200
            ]); 

        }else{
            
            return response()->json([
                'data'=>$results,
                'code'=>500
            ]);

        }

    }

    public function getMoldDetails(Request $request){
        
        // return $request->orderId;
        $results=DB::select("SELECT
                 CASE 
                    WHEN mold_odr_details.delivery_date IS NOT NULL 
                    THEN DATE_FORMAT(mold_odr_details.delivery_date, '%d-%m-%Y') 
                    ELSE '' 
                END AS delivery_date,
                ci_items.ci_item_code as fg_code,
                ci_items.ci_item_name as fg_name,
                mold_process.name as mold_proces,
                case when `mold_of_design` then 'YES' else 'NO' end as mold_of_design,
                `mold_file` as mold_file,
                case when `mold_aps` then 'Y' else '' end as mold_aps,
                runner_type.name as runner_type,
                runner_gate.name as runner_gate,
                no_of_cavity.name as no_of_cavity,
                `prod_sample_wet`,
                `prod_target_wet`,
                `prod_design_wet`,
                `prod_tolerance`,
                product_materials.name as product_material,
                `prod_dim_l`,
                `prod_dim_w`,
                `prod_dim_h`,
                `prod_dim_tolerance`,
                case when `stacking` then 'Y' else '' end as stacking,
                case when `stacking_with_existing` then 'Y' else '' end as stacking_with_existing,
                case when `stacking_with_new` then 'Y' else '' end as stacking_with_new,
                `stacking_height`,
                case when `stacking_aps` then 'Y' else '' end as stacking_aps,
                case when `universality` then 'Y' else '' end as universality,
                case when `universality_with_existing` then 'Y' else '' end as universality_with_existing,
                case when `universality_with_new` then 'Y' else '' end as universality_with_new,
                case when `capacity`then 'Y' else '' end as capacity,
                `require_capacity`,
                case when `capacity_with_existing` then 'Y' else '' end as capacity_with_existing,
                case when `capacity_with_aps` then 'Y' else '' end as capacity_with_aps,
                case when `logo_info` then 'Y' else '' end as logo_info,
                case when `logo_with_ins` then 'Y' else '' end as logo_with_ins,
                case when `logo_without_ins` then 'Y' else '' end as logo_without_ins,
                `logo_file` as logo_file,
                machine_size.name as machine_size,
                case when `texturing` then 'Y' else '' end as texturing,
                case when `texturing_pattern_etching` then 'Y' else '' end as texturing_pattern_etching,
                case when `texturing_mat_finishing` then 'Y' else '' end as texturing_mat_finishing,
                case when `texturing_spray_etching` then 'Y' else '' end as texturing_spray_etching,
                case when `texturing_with_aps` then 'Y' else '' end as texturing_with_aps,
                `note`,
                `odr_quantity`
            FROM `mold_odr_details`
            join ci_items on ci_items.id=mold_odr_details.fg_id
            join mold_process on mold_process.id=mold_odr_details.mold_process_id
            join runner_type on runner_type.id=mold_odr_details.runner_type_id
            join runner_gate on runner_gate.id=mold_odr_details.runner_gate_id
            join no_of_cavity on no_of_cavity.id=mold_odr_details.runner_gate_id
            join product_materials on product_materials.id=mold_odr_details.product_material_id
            join machine_size on machine_size.id=mold_odr_details.machinge_size_id
            WHERE `order_id` = '$request->orderId'");
        $orderMaster=MoldOdrMaster::where('id',$request->orderId)->first(['order_number','order_name']);
        return view('mold_order.mold_details')
            ->with('orderMaster',$orderMaster)
            ->with('results',$results);

    }

    public function moldReceiving(Request $request){
    
        $user_id=Auth::user()->id;
        $companies=Company::orderBy("factory_name","ASC")->get(); 
        return view('mold_order.mold_receiving',compact('companies'));

    }

    public function getUserMoldOrderList(Request $request){

        $from_date = $request->from_date ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date = $request->to_date ? date("Y-m-d", strtotime($request->to_date)) : null;
        $companies = $request->companies ? implode(',', $request->companies) : null;
        $results = DB::select("CALL MOLD_ORDER_LIST(?, ?, ?)", [$from_date, $to_date, $companies]);
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

    public function moldOrderReceived(Request $request)
    {
        
        return $this->pushOrderData($request->jo_no);

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
}
