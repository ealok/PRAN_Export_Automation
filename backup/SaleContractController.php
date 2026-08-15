<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
use Session;
use Auth;
use App\SaleContract;
use App\SaleContractDetail;
use App\Country;
use App\SalesTerm;
use App\Company;
use App\Bank;
use App\Importer;
use App\NotifyParty;
use App\CarryingMode;
use App\LoadingPlace;
use App\CiItem;
use App\CompanyBank;
use App\BankImporter;
use Carbon\Carbon;
use App\Feature;  
use App\ScCurrencyHistory;
use App\PODetails;
use App\NotifyPartyItem;
use Excel;
use DB;
use App\NotifyPartyUser;
use App\Mail\SalesContactMail;
use Illuminate\Support\Facades\Crypt;
use App\Mail\ImpostedMail;
use Mail;
use App\FileNumber;
use App\SCI;
use Brian2694\Toastr\Facades\Toastr;
use App\TransportAgency;
use App\SciStatus;
use App\CurrencySetup;
use App\CustomStation;
use App\CNF;
use App\DateClaim;
use App\OverDue;
use App\SwiftUpdate;
use App\ComInvMaster;
use App\ComInvDetail;
use App\ComInvRecipeDetail;
use App\ComInvMasterDetails;
use App\ComInvItemDetail;
use App\InsentivePercentage;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use App\ItemGroup;
use App\AssignItemClaim;
use App\CiItemClaim;
use App\JobOrderMaster;
use App\CiEditHistory;
use App\CICvr;
use App\CiReportDateFormatSetup;
use App\IndiaItemGorupAssign;
use App\ItemGroupIndia;
use App\POMaster;
use App\UserFeatures;
use App\User;
use App\UserArea;
use App\LandPortDashboard;
use App\seaPortdashboard;
use App\DeskSetup;
use App\Desk;
use App\ShippingLine;
use App\UserSignature;
use App\FreightLogHistory;
use App\TemplateMaster;
use App\TruckDetails;
class SaleContractController extends Controller{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');

    }

    public function index()
    {
        // if(!$this->hasViewPermission()) {

        //     return view('limited_access');
            
        // }

        try {

            $user_id = Auth::user()->id;
            $firstDay = date('Y-m-d');
            $lastDay  = date('Y-m-d', strtotime('-6 months'));
            $notify_party_ids = NotifyPartyUser::where('user_id', $user_id)->where('status', '1')->pluck('notify_party_id');
            $notify_parties = NotifyParty::whereIn('id', $notify_party_ids)->get();
            return view('sale_contract.sci.sale_contract_desk_list')
                ->with('firstDay', $firstDay)
                ->with('lastDay', $lastDay)
                ->with('notify_parties', $notify_parties);

        } catch (\Exception $e) {

            return $e->getMessage();
        }
        
    }


    public function getScPartyList(Request $request)
    {
        try {
            $party_id = $request->input('party_id');
            $from_date = $request->input('from_date');
            $to_date = $request->input('to_date');
            $to_date = date('Y-m-d', strtotime($to_date . ' +1 day'));
            $results = DB::table('sale_contracts')
                    ->select([
                        'sale_contracts.id',
                        'sale_contracts.sales_contract_no',
                        'sale_contracts.dated',
                        'sale_contracts.invoice_no',
                        'sale_contracts.export_no as export_no',
                        'sale_contracts.final_destination',
                        'sale_contracts.approver_id',
                        'sale_contracts.desk_approver_id',
                        'companies.name as company',
                        'banks.name as bank_name',
                        DB::raw("
                            CASE
                                WHEN sale_contracts.approver_id IS NOT NULL THEN 'Comm.Posted'
                                WHEN sale_contracts.desk_approver_id IS NOT NULL THEN 'Desk.Posted'
                                ELSE 'New'
                            END AS status
                        ")
                    ])
                    ->join('companies', 'companies.id', '=', 'sale_contracts.company_id')
                    ->leftJoin('banks', 'banks.id', '=', 'sale_contracts.bank_id')
                    ->where('sale_contracts.notify_pary_id', $party_id)
                    ->where('sale_contracts.inactive', '=', 'N')
                    ->whereBetween('sale_contracts.created_at', [$from_date, $to_date])
                    ->orderBy('sale_contracts.id', 'DESC')
                    ->get();

            

            $encryptedPartyId = Crypt::encrypt($party_id);
            $results = $results->map(function ($item) use ($encryptedPartyId) {
                $data = (array) $item; 
                $data['encrypted_id'] = Crypt::encrypt($data['id']);
                $data['encrypted_party_id'] = $encryptedPartyId;
                return $data;
            });
            
            return response()->json([
                'success' => true,
                'party_id' => $party_id,
                'encrypted_party_id' => $encryptedPartyId,
                'data' => $results
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function comInvList(Request $request, $id){
        
        try {

            $party_id=\Crypt::decrypt($id); 
            $order_type = ((Auth::user()->type_id != 7 && Auth::user()->type_id!=NULL) || Auth::user()->type_id === NULL ) ? 1 : 2;
            $sale_contracts = SaleContract::where('notify_pary_id', $party_id)
                ->where('inactive', 'N')
                // ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->where('sc_type', $order_type)
                ->get();

            return view("sale_contract.sci.sale_contract_com_list", compact("sale_contracts"))->with('party_id', $party_id);

        } catch (\Exception $e) {
            
            echo $e->getMessage();

        }
                
    }

    // desk  access notify Party

    // public function access_notify_party_desk(Request $request){
 
    //     $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');
    //     $notify_parties = NotifyParty::whereIn('id',$notify_party_ids)->get();  
    //     return view("sale_contract.access_notify_party_list")->with('notify_parties',$notify_parties);
        
    // }

    public function getPartyWiseSCList(Request $request){
      
        $results=DB::select("select
                sc.id,
                sc.notify_pary_id as party_id,
                sc.sales_contract_no,
                date_format(sc.dated,'%d-%m-%Y') as sales_contract_date,
                sc.invoice_no,
		sc.export_no,
                c.name as company,
                b.short_name as bank,
                case when desk_approver_id is not null then  'Desk Approved'
                when (approver_id is not null  and desk_approver_id is not null) then 'Com Approved'
                ELSE 'Not Approved' end as status
            from sale_contracts sc
            join companies c on c.id=sc.company_id
            join banks b on b.id=sc.bank_id
            join importers imp on imp.id=sc.importer_id
            where sc.notify_pary_id='$request->party_id' AND sc.inactive='N'
            order by sc.id desc");
        return response()->json([
            'results'=>$results,
            'code'=>200
        ]);
        
    }

    // com  access notify Party

    public function access_notify_party_com(){

        $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');
        $notify_parties = NotifyParty::whereIn('id',$notify_party_ids)->get();
        return view("sale_contract.access_notify_party_doc")
                ->with('notify_parties', $notify_parties);
    }

     public function getPartyWiseSCListCi(Request $request){
        
        $results=DB::select("select
                    sc.id,
                    sc.notify_pary_id as party_id,
                    sc.sales_contract_no,
                    date_format(sc.dated,'%d-%m-%Y') as sales_contract_date,
                    sc.invoice_no,
                    c.name as company,
                    b.short_name as bank,
                    case when desk_approver_id is not null then  'Desk Approved'
                    when (approver_id is not null  and desk_approver_id is not null) then 'Com Approved'
                    ELSE 'Not Approved' end as status
                from sale_contracts sc
                join companies c on c.id=sc.company_id
                join banks b on b.id=sc.bank_id
                join importers imp on imp.id=sc.importer_id
                where sc.invoice_no like '%$request->invoice_no%' and sc.inactive='N'
                order by sc.id desc
                limit 5");
        return response()->json([
            'results'=>$results,
            'code'=>200
        ]);
        
    }


     // desk  access
    public function access_notify_party_list(Request $request){
 
        $area_ids=UserArea::where('user_id',Auth::user()->id)->pluck('area_id')->toArray();
        $notify_parties = NotifyParty::whereIn('area_id',$area_ids)->get(); 
        return view("sale_contract.access_notify_party_list")->with('notify_parties',$notify_parties);
        
    }



    public function sale_contract_ci_doc_list($id){
        
        $sale_contracts = SaleContract::where('notify_pary_id',\Crypt::decrypt($id))->where('desk_approve_at','!=',null)->get();
        return view("sale_contract.sci.sale_contract_desk_list",compact("sale_contracts"))->with('party_id',\Crypt::decrypt($id));     

    }

    public function sale_contract_ci_list(){

        $user_id=Auth::user()->id;
        $notify_party_ids = NotifyPartyUser::where('user_id', $user_id)->where('status', '1')->pluck('notify_party_id');
        $notify_parties = NotifyParty::whereIn('id', $notify_party_ids)->get();
        return view("sale_contract.sci.sale_contract_ci_list")
                ->with('notify_parties', $notify_parties);

    }
    public function sale_contract_ci($id){

        $sale_contracts = SaleContract::where('notify_pary_id',$id)->where('approver_id','!=',null)->get();
        return view("sale_contract.sci.sale_contract_desk_list",compact("sale_contracts"))->with('party_id',$id); 
        
    }

    public function create($id){
                 
        $party_id = base64_decode($id);
        $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');
        $countries=Country::all();
        $sales_terms=SalesTerm::all();
        $companies=Company::all();
        $banks=Bank::all();
        $importers=Importer::all();
        $notify_parties=NotifyParty::whereIn('id',$notify_party_ids)->get();
        $carrying_modes=CarryingMode::all();
        $loading_places=LoadingPlace::all();
        $bank_importers = BankImporter::all();
        $currency=CurrencySetup::all();   
        $party_name= SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('party_name') ? SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('party_name') : NotifyParty::where('id',$party_id)->value('name');
        $party_address= SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('party_address') ? SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('party_address') : NotifyParty::where('id',$party_id)->value('address');             
        $also_notify_party= SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('third_notify_party') ? SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('third_notify_party') : ''; 
        $party_name= "";
        $party_address= "";             
        $also_notify_party="";
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'");  
        $templateNames=TemplateMaster::all();                        
        return view("sale_contract.sale_contract_create")
             ->with("countries" ,$countries)
             ->with("sales_terms" ,$sales_terms)
             ->with("companies" ,$companies)
             ->with("banks" ,$banks)
             ->with("importers" ,$importers)
             ->with("notify_parties" ,$notify_parties)
             ->with("carrying_modes" ,$carrying_modes)
             ->with("bank_importers" ,$bank_importers)
             ->with("loading_places" ,$loading_places)
             ->with("currency" ,$currency)
             ->with("party_name" ,$party_name)
             ->with("party_address" ,$party_address)
             ->with("also_notify_party" ,$also_notify_party)
             ->with("notifyParties" ,$notifyParties)
             ->with('templateNames',$templateNames);

    }

    public function getScCreatePoList(Request $request){

        return $results=DB::select("SELECT
                    po_master.ID,
                    po_master.PO_NO,
                    CASE
                    WHEN po_master.ORDER_TYPE = 2 THEN CONCAT(po_master.PO_NO, '', '(GT)')
                    ELSE po_master.PO_NO
                    END AS SPO_NO,
                    po_master.REMARK,
                    po_master.APPROVED_STATUS
                    FROM po_master
                WHERE po_master.PARTY_ID='$request->party_id'
                    AND po_master.STATUS = 1
                    AND po_master.USED_STATUS IS NULL
                    AND po_master.CREATE_DATE >= '2024-09-01'
                    AND (
                        (po_master.REMARK != 'Manually Created')
                        OR (po_master.REMARK = 'Manually Created'
                            AND po_master.ORDER_TYPE = 2
                            AND po_master.APPROVED_STATUS = 'Y'))
                ORDER BY po_master.ID ASC");


    }

    public function getScEditPoList(Request $request){
                                         
        return $results=DB::select("SELECT DISTINCT t2.PO_NO
                FROM (
                    SELECT po_master.PO_NO, po_master.REMARK,0 as po_size
                    FROM po_master
                    WHERE po_master.PARTY_ID = '$request->party_id'
                            AND po_master.STATUS = 1
                            AND po_master.USED_STATUS is null
                            AND ((po_master.REMARK != 'Manually Created' AND po_master.APPROVED_STATUS != 'Y')
                                OR po_master.REMARK != 'Manually Created')
                    UNION ALL
                    SELECT sale_contracts.po_number COLLATE utf8_general_ci AS PO_NO,'' as REMARK,LENGTH(sale_contracts.po_number) as po_size
                    FROM sale_contracts
                    WHERE sale_contracts.id = '$request->sc_id'
                    ) AS t2
                WHERE t2.PO_NO IS NOT NULL");

    }

    public function store(Request $request){

        // DB::beginTransaction();
        // try {
            
            // Check if the SaleContract already exists
            if(SaleContract::where('invoice_no', $request->invoice_no)->exists()) {
                return response()->json([
                    'message' => "Already Exist This Invoice",
                    "code"    => 409
                ],409);
            }

            // if(SaleContract::where('po_number',$request->po_id)->count()>0){
             
            //     return response()->json([
            //         'message' => "Already Exist This PO Number",
            //         "code"    => 409
            //     ]); 

            // }

            // $order_type = ((Auth::user()->type_id != 7 && Auth::user()->type_id!=NULL) || Auth::user()->type_id === NULL ) ? 1 : 2;
            // if(POMaster::where('PO_NO',$request->po_id)->value('ORDER_TYPE')!=$order_type){
            //     return response()->json([
            //         'message' => "You Are Not Unable to Use This PO.!!",
            //         "code"    => 409
            //     ]); 
            // }

            $company_bank = CompanyBank::where('company_id', $request->company_id)
                ->where('bank_id', $request->bank_id)
                ->first();
            $account_number = $company_bank->account_number;

            // $po_master = POMaster::where('PO_NO', $request->po_id)
            //     ->first(['ID', 'CREATE_DATE','ORDER_TYPE']);
            

            $sale_contract = new SaleContract;
            $sale_contract->sales_contract_no = str_replace('/', '-', $request->sales_contract_no);
            $sale_contract->dated = date("Y-m-d", strtotime($request->dated));
            $sale_contract->invoice_no = str_replace('/', '-', $request->invoice_no);;
            if ($request->invoice_date) {
                $sale_contract->invoice_date = date("Y-m-d", strtotime($request->invoice_date));
            }
        
            $sale_contract->export_no = $request->export_no;
            $sale_contract->ci_note = $request->ci_note;
        
            if ($request->export_date) {
                $sale_contract->export_date = date("Y-m-d", strtotime($request->export_date));
            }
        
            $sale_contract->discharge_port = $request->discharge_port;
            $sale_contract->country_id = $request->country_id;
            $sale_contract->sales_term_id = $request->sales_term_id;
            $sale_contract->company_id = $request->company_id;
            $sale_contract->bank_id = $request->bank_id;
            $sale_contract->account_number = $account_number;
            $sale_contract->importer_id = $request->importer_id;
            $sale_contract->bank_importer_id = $request->bank_importer_id;
            $sale_contract->notify_pary_id = $request->notify_pary_id;
            $sale_contract->carrying_mode_id = $request->carrying_mode_id;
            $sale_contract->loading_place_id = $request->loading_place_id;
            $sale_contract->final_destination = $request->final_destination;
            $sale_contract->container = $request->container;
            $sale_contract->container_1 = $request->container_qty_1 ? $request->container_qty_1 . 'X' . $request->container_1 : NULL;
            $sale_contract->container_2 = $request->container_qty_2 ? $request->container_qty_2 . 'X' . $request->container_2 : NULL;
            $sale_contract->container_3 = $request->container_qty_3 ? $request->container_qty_3 . 'X' . $request->container_3 : NULL;
            $container_qty_1 = $request->container_qty_1 ? $request->container_qty_1 : 0;
            $container_qty_2 = $request->container_qty_2 ? $request->container_qty_2 : 0;
            $container_qty_3 = $request->container_qty_3 ? $request->container_qty_3 : 0;
            $sale_contract->total_container = $container_qty_1 + $container_qty_2 + $container_qty_3;
            $sale_contract->container_qty_1 = $request->container_qty_1 ? $request->container_qty_1 : 0;
            $sale_contract->container_qty_2 = $request->container_qty_2 ? $request->container_qty_2 : 0;
            $sale_contract->container_qty_3 = $request->container_qty_3 ? $request->container_qty_3 : 0;
            $sale_contract->freight_cost_1 = $request->freight_cost_1;
            $sale_contract->freight_cost_2 = $request->freight_cost_2;
            $sale_contract->freight_cost_3 = $request->freight_cost_3;
            $sale_contract->freight_cost = $request->freight_cost_1 + $request->freight_cost_2 + $request->freight_cost_3;
            $sale_contract->desk_freight_cost = $request->desk_freight_cost;
            $sale_contract->qtan_freight_cost = $request->qtan_freight_cost;
            $sale_contract->terms_and_condition = $request->terms_and_condition;
            $sale_contract->terms_and_condition_desk_inv = $request->terms_and_condition_desk_inv;
            $sale_contract->importer_country = $request->importer_country;
            $sale_contract->angikar_given_by = $request->angikar_given_by;
            $sale_contract->is_revised = $request->is_revised;
            $sale_contract->is_master = $request->is_master;
            $sale_contract->is_proforma_invoice = $request->is_proforma_invoice;
            $sale_contract->footer_importer_address = $request->footer_importer_address;
            $sale_contract->third_notify_party = $request->third_notify_party;
            $sale_contract->creator_id = Auth::user()->id;
            $sale_contract->currency_id = $request->currency_id;
            $sale_contract->party_name = trim($request->party_name);
            $sale_contract->party_address = trim($request->party_address);
            $sale_contract->importer_name = trim($request->importer_name);
            $sale_contract->importer_address = trim($request->importer_address);
            $sale_contract->third_notify_party = trim($request->third_notify_party);
            $sale_contract->po_number = 1;
            $sale_contract->po_master_id = 1;
            $sale_contract->sc_type = 1;
            $sale_contract->expaire_show_status =$request->expaire_show_status;
            $sale_contract->save();
            $this->updateCiTotalValue($sale_contract->id);
            $sale_contract = SaleContract::orderBy('id', 'desc')->first();
            if($request->hasFile('formated_file')) {

                $formated_file = $request->file('formated_file');
                $path = $formated_file->getRealPath();
                $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
                $this->save_items($sale_contract->id, $datas, $request->notify_pary_id);
                // if($order_type==1){

                //     $this->save_items($sale_contract->id, $datas, $request->notify_pary_id);

                // }else{
                    
                //     $this->save_trading_items($sale_contract->id, $datas, $request->notify_pary_id);
                // }
                
            }
              
            if($request->hasFile('pi_upload')) {

                $this->uploadPIDoc($request,$sale_contract->id);
                
            }

            // $po_date = date("Y-m-d", strtotime($po_master->CREATE_DATE));
            // if($order_type==1){

                $this->manageFreight($sale_contract->id);
                $this->manageCCQ($sale_contract->id);
            // }
        
            // $apiCallingStatus = 0;
            // if ($request->qtan_freight_cost) {
                
            //     $this->qtanFreightSyn($sale_contract->id);
            //     $apiCallingStatus = 1;
            // }
            
            // POMaster::where('PO_NO',$request->po_id)->update(['USED_STATUS'=>'Y']);
            $this->scCurrencyHistory($sale_contract->id, $request->currency_id);
            //$this->createBoardHistroy($sale_contract->id, $request->po_id, $po_date, $sale_contract->dated);
            DB::commit();
            return response()->json([
                'message' => "Data Inserted Successfully",
                "code"    => 200,
                "call_status" => 1
            ]);
        
        // } catch (\Exception $e) {

        //     DB::rollback();
        //     return response()->json([
        //         'message' => "Internal Server Error",
        //         'error'   => $e->getMessage(),
        //         "code"    => 500
        //     ]);
        // }
        
    }

    public function approve_desk(Request $request){
         
        $id=$request->sale_contract_id;
        $sale_contract = SaleContract::findOrFail($id);
        if($sale_contract ->desk_approver_id != null ){

            return response()->json([
                'message' => "Already Approved",
                "code"    => 409
            ]);
        }
        $sale_contract ->desk_approver_id = Auth::user()->id;
        $sale_contract ->desk_approve_at = Carbon::now();
        $sale_contract ->save();
        $this->createCiEditHisroy($id);
        $this->ci_make_price_same2($id); 
        $this->sendDeskApprovalMail($id,$sale_contract->notify_pary_id);
        return response()->json([
            'message' => "Make posted successfully..!!",
            "code"    => 200
        ]);
    
    }

    private function uploadPIDoc($request,$sale_contract_id){
       
        if($request->hasFile('pi_upload')){

            $file = $request->file('pi_upload');
            $filePath = $file->getRealPath();
            $fileName = $file->getClientOriginalName();            
            $cFile = new \CURLFile($filePath, $file->getClientMimeType(), $fileName);
            $cFile->setPostFilename($fileName); // Set filename for cURL
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://rqc.rflgroupbd.com:8016/upload/gt/pi_copy', // Endpoint URL
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
                
                $sales_contract=SaleContract::find($sale_contract_id);
                $sales_contract->gt_doc_ref=$responseData['file_path'];
                $sales_contract->save();
            }
            
            $error = curl_error($curl);
            curl_close($curl);
                
        }else{

            return "No File";

        }

    }

    private function save_trading_items($sale_contract_id,$datas,$notify_party_id){
        
       
        foreach ($datas as $key => $value) {

            $ci_items =  CiItem::where('ci_item_code',preg_replace('/\s+/', '', $value->item_code))->where('status',1)->get();
            if($value->item_code == '' || !is_numeric($value->ctn)){

                echo "Numeric Data Required!! <br>";

            }else{
                    
                $ci_items =  CiItem::where('ci_item_code',$value->item_code)->where('status',1)->get();
                if($ci_item = $ci_items->first()){

                    $sale_contract_detail = new SaleContractDetail();
                    $sale_contract_detail->ccq                              = 0;
                    $sale_contract_detail->ci_item_id                       = $ci_item->id;
                    $sale_contract_detail->sale_contract_id                 = $sale_contract_id;
                    $sale_contract_detail->rate_per_ctn                     = $ci_item->ci_item_rate;
                    $sale_contract_detail->desk_item_name                   = $ci_item->ci_item_name;
                    $sale_contract_detail->ci_item_name                     = $ci_item->ci_item_name;
                    $sale_contract_detail->hs_code                          = $ci_item->hs_code;
                    $sale_contract_detail->rate_per_ctn_for_party           = $value->purchase_rate;
                    $sale_contract_detail->total_amount_party               = $value->purchase_rate*$value->ctn;
                    $sale_contract_detail->rate_per_ctn_for_acc             = $value->sales_rate;
                    $sale_contract_detail->total_amount_acc                 = $value->sales_rate*$value->ctn;
                    $sale_contract_detail->ctn                              = $value->ctn;
                    $sale_contract_detail->pcs_in_ctn                       = $value->ctn * $ci_item->factor;
                    $sale_contract_detail->factor                           = $ci_item->factor;
                    $sale_contract_detail->cbm_per_ctn                      = 0;
                    $sale_contract_detail->total_cbm                        = 0;
                    $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm   = 0;
                    $sale_contract_detail->per_ctn_freight                  = 0;
                    $sale_contract_detail->ci_rate_pl_freight               = 0;
                    $sale_contract_detail->total_amount                     = $value->purchase_rate * $value->ctn;
                    $sale_contract_detail->net_weight_kg                    = $value->ctn * $ci_item->d_net_weight;
                    $sale_contract_detail->hs_code_2                        = $value->hs_code2;
                    $sale_contract_detail->gross_weight_kg                  = $value->ctn * $ci_item->d_gross_weight;
                    $sale_contract_detail->bapa_percent                     = 0;
                    $sale_contract_detail->bapa_percent                     = 0;
                    $sale_contract_detail->bu_id                            = $ci_item->bu_id;
                    $sale_contract_detail->sample_qty                       = $value->sample=="" ? "0" : $value->sample;
                    $sale_contract_detail ->save();

                }else{

                    echo 'sl= '.$value->sl."  item_code= ".$value->item_code."  Error: Item Not Created, Check item_code or Please Create Item !!<br>";
                }

            }

        }

    }

    private function scCurrencyHistory($sale_contact_id,$currency_id){
       
        $sc_currency_histroy=new ScCurrencyHistory();
        $sc_currency_histroy->sale_contract_id=$sale_contact_id;
        $sc_currency_histroy->currency_id=$currency_id;
        $sc_currency_histroy->rate=CurrencySetup::where('id',$currency_id)->value('currency_rate');
        $sc_currency_histroy->save();

    }

    public function edit($sale_contact_id, $party_id){
        
        $id=\Crypt::decrypt($sale_contact_id);
        $dparty_id=\Crypt::decrypt($party_id);
        $sale_contract = SaleContract::find($id);
        $container_qty1=0;
        $container_qty2=0;
        $container_qty3=0;
        $container_qty1 = ($sale_contract->container_qty_1) ? $sale_contract->container_qty_1 : (($sale_contract->container_1) ? intval(strtok($sale_contract->container_1, 'x')) : 0);
        $container_qty2 = ($sale_contract->container_qty_2) ? $sale_contract->container_qty_2 : (($sale_contract->container_2) ? intval(strtok($sale_contract->container_2, 'x')) : 0);
        $container_qty3 = ($sale_contract->container_qty_3) ? $sale_contract->container_qty_3 : (($sale_contract->container_3) ? intval(strtok($sale_contract->container_3, 'x')) : 0);
        $po_no=$sale_contract->po_number;
        if($sale_contract->approver_id){

            Session::flash("danger", "Already Approved !");
            return redirect()->back();
        }
        
        $countries=Country::all();
        $sales_terms=SalesTerm::all();
        $companies=Company::all();
        $transportAgencyies=TransportAgency::all();
        $banks=\DB::select("SELECT banks.id, banks.name
                    FROM company_banks
                    JOIN banks ON banks.id=company_banks.bank_id
                    WHERE company_banks.company_id='$sale_contract->company_id'");
        $importers=Importer::all();
        $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');
        $notify_parties=NotifyParty::whereIn('id',$notify_party_ids)->get();
        $carrying_modes=CarryingMode::all();
        $loading_places=LoadingPlace::all();
        $bank_importers = BankImporter::all();
        $ci_items = [];
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id','asc')->get();
        $freightSynStatus=FreightLogHistory::where('sc_id',$id)->count();
        $currency=CurrencySetup::all(); 
        $customStations=CustomStation::all();
        $shippingLines=ShippingLine::all();
        $party_name= SaleContract::where('notify_pary_id',$dparty_id)->orderBy('id', 'desc')->limit(1)->value('party_name') ? SaleContract::where('notify_pary_id',$dparty_id)->orderBy('id', 'desc')->limit(1)->value('party_name') : NotifyParty::where('id',$dparty_id)->value('name');
        $party_address= SaleContract::where('notify_pary_id',$dparty_id)->orderBy('id', 'desc')->limit(1)->value('party_address') ? SaleContract::where('notify_pary_id',$dparty_id)->orderBy('id', 'desc')->limit(1)->value('party_address') : NotifyParty::where('id',$dparty_id)->value('address');
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'");  
        $templateNames=TemplateMaster::all(); 
        return view("sale_contract.sale_contract_edit",compact("sale_contract"))
             ->with("countries" ,$countries)
             ->with("sales_terms" ,$sales_terms)
             ->with("companies" ,$companies)
             ->with("banks" ,$banks)
             ->with("importers" ,$importers)
             ->with("notify_parties" ,$notify_parties)
             ->with("carrying_modes" ,$carrying_modes)
             ->with("loading_places" ,$loading_places)
             ->with("bank_importers" ,$bank_importers)
             ->with("sale_contract_details",$sale_contract_details)
             ->with("ci_items" ,$ci_items)
             ->with('party_id', $dparty_id)
             ->with('po_no',$po_no)
             ->with('container_qty1',$container_qty1)
             ->with('container_qty2',$container_qty2)
             ->with('container_qty3',$container_qty3)
             ->with('currency',$currency)
             ->with('freightSynStatus',$freightSynStatus)
             ->with('customStations',$customStations)
             ->with('shippingLines',$shippingLines)
             ->with('transportAgencyies',$transportAgencyies)
             ->with('party_name',$party_name)
             ->with("notifyParties" ,$notifyParties)
             ->with('templateNames',$templateNames)
             ->with('party_address',$party_address);

    }

    public function update(Request $request) {
        
        $id=$request->sale_contract_id;
        $invoice_no = str_replace('/', '-', $request->invoice_no);
        $exists = SaleContract::where('invoice_no', $invoice_no)
                ->where('inactive', 'N')
                ->where('id', '!=', $id)
                ->exists();

        if($exists) {

            return response()->json([
                'status' => 'Invoice number already exists in the system.',
                'code' => 422
            ]);

        }    

        $terms = $request->terms_and_condition;
        if(strpos($terms, 'EXPIRY OF THIS SALES CONTRACT') !== false) {
            $terms = preg_replace('/^.*EXPIRY OF THIS SALES CONTRACT.*(\r?\n)?/mi', '', $terms);
        }

        preg_match_all('/^\d+\./m', $terms, $matches);
        $nextNumber = count($matches[0]) + 1;
        $newDate = date('d-m-Y', strtotime($request->dated . ' +180 days'));
        $newLine = $nextNumber . '. EXPIRY OF THIS SALES CONTRACT ON: ' . $newDate;
        $terms = trim($terms) . "\n" . $newLine;
        if(!empty($request->insurance_charge) && !empty($request->pallet_charge)) {

            return response()->json(['status' => 'Insurance & Pallet Charge Is Not Allow Same Time..!!', 'code' => 422]);
        }

        if ($request->insurance_charge && empty($request->desk_freight_cost)) {
            
            return response()->json(['status' => 'First Enter Desk Freight Cost..!!', 'code' => 422]);
        }

        $company_bank = CompanyBank::where('company_id', $request->company_id)->where('bank_id', $request->bank_id)->first();
        $account_number = $company_bank->account_number;
        $sale_contract = SaleContract::find($id);
        $callStatus = 0;
        if ($sale_contract->approver_id) {

            return response()->json(['status' => 'Already Approved..!!', 'code' => 422]);

        } else {

            $sale_contract->sales_contract_no = str_replace('/', '-', $request->sales_contract_no);
            $sale_contract->dated = date("Y-m-d", strtotime($request->dated));
            $sale_contract->invoice_no = str_replace('/', '-', $request->invoice_no);
            $sale_contract->invoice_date = $request->invoice_date ? date("Y-m-d", strtotime($request->invoice_date)) : '';
            $sale_contract->export_no = $request->export_no;
            $sale_contract->ad_code = $request->ad_code;
            $sale_contract->ci_note = $request->ci_note;
            $sale_contract->export_date = $request->export_date ? date("Y-m-d", strtotime($request->export_date)) : NULL;
            $sale_contract->discharge_port = $request->discharge_port;
            $sale_contract->country_id = $request->country_id;
            $sale_contract->sales_term_id = $request->sales_term_id ?: SaleContract::where('id', $id)->value('sales_term_id');
            $sale_contract->company_id = $request->company_id;
            $sale_contract->bank_id = $request->bank_id;
            $sale_contract->account_number = $account_number;
            $sale_contract->importer_id = $request->importer_id;
            $sale_contract->bank_importer_id = $request->bank_importer_id;
            $sale_contract->notify_pary_id = $request->notify_pary_id;
            $sale_contract->carrying_mode_id = $request->carrying_mode_id;
            $sale_contract->loading_place_id = $request->loading_place_id;
            $sale_contract->final_destination = $request->final_destination;
            $sale_contract->container = $request->container;
            $sale_contract->container_1 = $request->container_qty_1 ? $request->container_qty_1 . 'X' . $request->container_1 : NULL;
            $sale_contract->container_2 = $request->container_qty_2 ? $request->container_qty_2 . 'X' . $request->container_2 : NULL;
            $sale_contract->container_3 = $request->container_qty_3 ? $request->container_qty_3 . 'X' . $request->container_3 : NULL;
            $container_qty_1 = $request->container_qty_1 ?: 0;
            $container_qty_2 = $request->container_qty_2 ?: 0;
            $container_qty_3 = $request->container_qty_3 ?: 0;
            $sale_contract->total_container = $container_qty_1 + $container_qty_2 + $container_qty_3;
            $sale_contract->container_qty_1 = $container_qty_1;
            $sale_contract->container_qty_2 = $container_qty_2;
            $sale_contract->container_qty_3 = $container_qty_3;
            $sale_contract->freight_cost_1 = $request->freight_cost_1;
            $sale_contract->freight_cost_2 = $request->freight_cost_2;
            $sale_contract->freight_cost_3 = $request->freight_cost_3;
            if($request->freight_cost_1 > 0 || $request->freight_cost_2 > 0 || $request->freight_cost_3 > 0) {
                $sale_contract->freight_cost = $request->freight_cost_1 + $request->freight_cost_2 + $request->freight_cost_3;
            } else {
                $sale_contract->freight_cost = 0;
            }
            $sale_contract->terms_and_condition = $terms;
            $sale_contract->terms_and_condition_desk_inv = $request->terms_and_condition_desk_inv;
            $sale_contract->bl_no = $request->bl_no;
            $sale_contract->bl_date = $request->bl_date ? date("Y-m-d", strtotime($request->bl_date)) : NULL;
            $sale_contract->bl_date_cer = $request->bl_date_cer ? date("Y-m-d", strtotime($request->bl_date_cer)) : NULL;
            $sale_contract->qtan_freight_cost = $request->qtan_freight_cost;
            $sale_contract->importer_country = $request->importer_country;
            $sale_contract->angikar_given_by = $request->angikar_given_by;
            $sale_contract->desk_freight_cost = $request->desk_freight_cost ?: 0;
            $sale_contract->freight_charge_india = $request->freight_charge_india;
            $sale_contract->is_revised = $request->is_revised;
            $sale_contract->is_master = $request->is_master;
            $sale_contract->tr_report_date = $request->tr_report_date;
            $sale_contract->phyto_product_name = $request->phyto_product_name;
            $sale_contract->is_proforma_invoice = $request->is_proforma_invoice;
            $sale_contract->footer_importer_address = $request->footer_importer_address;
            $sale_contract->is_notify_also_notity = $request->is_notify_also_notity;
            $sale_contract->vehicle = $request->vehicle;
            $sale_contract->revise_product_name = $request->revise_product_name;
            $sale_contract->factory_address_type = $request->factory_address_type_id;
            $sale_contract->third_notify_party = $request->third_notify_party;
            $sale_contract->insurance_charge = $request->insurance_charge;
            $sale_contract->pallet_charge = $request->pallet_charge;
            $sale_contract->foreign_port = $request->foreign_port;
            $sale_contract->bd_port = $request->bd_port;
            $sale_contract->tr_no_is_exist = $request->tr_no_is_exist;
            $sale_contract->address_replace = $request->address_replace;
            $sale_contract->transport_agency_id = $request->transport_agency_id ?: 0;
            $sale_contract->bank_address_for_india = $request->bank_address_for_india;
            $sale_contract->lc_term_for_india = $request->lc_term_for_india;
            $sale_contract->is_total_amount_oceania = $request->is_total_amount_oceania;
            $sale_contract->advance_payment = $request->advance_payment;
            $sale_contract->lot_number = $request->lot_number;
            $sale_contract->custom_decleration = $request->custom_decleration;
            $sale_contract->best_before_india = $request->best_before_india;
            $sale_contract->gsp_ref_number = $request->gsp_ref_number;
            $sale_contract->shipping_mark_india = $request->shipping_mark_india;
            $sale_contract->safta_dated = $request->safta_dated ? date("Y-m-d", strtotime($request->safta_dated)): NULL;
            $sale_contract->freight_date = $request->freight_date ? date("Y-m-d", strtotime($request->freight_date)) : NULL;
            $sale_contract->mfg_date_india = $request->mfg_date_india;
            $sale_contract->india_mfg_setup_date = $request->india_mfg_setup_date ? $request->india_mfg_setup_date : NULL;
            $sale_contract->dcc_memo_no = $request->dcc_memo_no;
            $sale_contract->currency_id = $request->currency_id;
            $sale_contract->shipping_line_id = $request->shipping_line_id ? $request->shipping_line_id : 0;
            $sale_contract->name_of_shipping_line_id = $request->name_of_shipping_line_id ? $request->name_of_shipping_line_id : 0;
            $sale_contract->freight_amount_fc = $request->freight_amount_fc;
            $sale_contract->freight_amount_btd = $request->freight_amount_btd;
            $sale_contract->custom_station_id = $request->custom_station_id ? $request->custom_station_id : 0;
            $sale_contract->arv_amount = $request->arv_amount ?: 0;
            $sale_contract->cnf_print_date = $request->cnf_print_date ? date("Y-m-d", strtotime($request->cnf_print_date)) : NULL;
            $sale_contract->master_airway_bill_no = $request->master_airway_bill_no;
            $sale_contract->party_name = trim($request->party_name);
            $sale_contract->party_address = trim($request->party_address);
            $sale_contract->importer_name = trim($request->importer_name);
            $sale_contract->importer_address = trim($request->importer_address);
            $sale_contract->master_airway_bill_date = $request->master_airway_bill_date ? date("Y-m-d", strtotime($request->master_airway_bill_date)) : NULL;
            if ($request->po_id) {
                $sale_contract->po_number = 1;
                $sale_contract->po_master_id = 1;
            }
            $arv_date = !empty($request->arv_amount_received_date) ? date('Y-m-d H:i:s', strtotime($request->arv_amount_received_date)) : NULL;
            $sale_contract->arv_amount_received_date = $arv_date;
            $sale_contract->salary_adjustment = $request->salary_adjustment;
            $sale_contract->mv_or_voy = $request->mv_or_voy;
            $sale_contract->container_number = $request->container_number;
            $sale_contract->add_also_notify_party = $request->add_also_notify_party;
            $sale_contract->is_hscode2 = $request->is_hscode2;
            $sale_contract->is_fob= $request->is_fob;
            $sale_contract->port_of_shipment =$request->port_of_shipment;
            $sale_contract->oc_date =$request->oc_date ? date("Y-m-d",strtotime($request->oc_date)):NULL;
            $sale_contract->expaire_show_status =$request->expaire_show_status;
            $sale_contract->save();
            $apiCallingStatus = 0;
            if(($request->qtan_freight_cost > 0 && FreightLogHistory::where('sc_id', $id)->count() == 0) || $request->is_fob==1){

                $this->qtanFreightSyn($sale_contract->id);
                $apiCallingStatus = 1;
            }
            $order_type = ((Auth::user()->type_id != 7 && Auth::user()->type_id!=NULL) || Auth::user()->type_id === NULL ) ? 1 : 2;
            if($order_type==1){

                $this->scCurrencyHistory($sale_contract->id, $request->currency_id);
                $this->manageFreight($id);
                $this->manageCCQ($id);

            }
            $this->updateCiTotalValue($sale_contract->id);
            if ($request->hasFile('formated_file')) {

                $formated_file = $request->file('formated_file');
                $path = $formated_file->getRealPath();
                $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
                $this->save_items($id, $datas, $request->notify_pary_id);

            }

        
            if($request->hasFile('pi_upload')) {

                $this->uploadPIDoc($request,$id);
                
            }

            DB::commit();
            return response()->json(['status' => 'Updated Successfully Done..!!', 'call_status' => $apiCallingStatus, 'code' => 200]);
        }

    
    }

    public function updateReportPercent(Request $request)
    {
        $contractId = $request->contract_id;
        $percentage = $request->percentage;
        SaleContract::where('id', $contractId)->update([
            'adj_percent' => $percentage
        ]);

        $results = SaleContractDetail::where('sale_contract_id', $contractId)->get();
        if ($results->isNotEmpty()) {

            foreach ($results as $result) {

                $updated_rate = round($result->rate_per_ctn_for_acc * $percentage / 100, 3);
                $updated_value = round($updated_rate * $result->ctn, 3);
                $result->update([
                    'rate_per_ctn_for_party' => $updated_rate,
                    'total_amount_party'     => $updated_value,
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'Adjustment percentage applied successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No contract details found'
        ]);
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

    public function createBoardHistroy($id,$po_no,$po_date,$sc_date){
       
        $saleContract=SaleContract::where('id',$id)->first(['id','po_master_id','creator_id','invoice_no','created_at','notify_pary_id']);
        $user=User::where('id',$saleContract->creator_id)->first(['id','username','name','head_id']);
        $po_master=POMaster::where('PO_NO',$po_no)->first(['ID','TEMPLATE_ID','PO_NO','CREATE_DATE']);
        $po_details=DB::select("select task_definition.DESCRIPTION as description,po_details.TASK_ID as task_id,po_details.FROM_DATE as from_date,po_details.TO_DATE as to_date
            from po_details
            join task_definition on task_definition.ID=po_details.TASK_ID
            where po_details.MASTER_ID=$po_master->ID");
        

        $deskSetup=DeskSetup::where('DESK_HEAD_ID',$user->head_id)->first(['DESK_ID']);    
        $desk=Desk::where('id',$deskSetup->DESK_ID)->first(['name']);
        if($po_master->TEMPLATE_ID==1){
            
            $po_master=POMaster::where('PO_NO',$po_no)->first();
            if(!is_null($po_master)){
               
                foreach ($po_details as $key => $value) {
                 
                    $landPortDashboard=new LandPortDashboard();
                    $landPortDashboard->sc_id=$saleContract->id;
                    $landPortDashboard->party_id=$saleContract->notify_pary_id;
                    $landPortDashboard->Task_ID=$value->task_id;
                    if($value->task_id==12){
    
                        $landPortDashboard->action_date=$po_date;
                    }
                    if($value->task_id==13){
    
                        $landPortDashboard->action_date=$sc_date;
                    }
                    $landPortDashboard->desk=$desk->name;
                    $landPortDashboard->task_name=$value->description;
                    $landPortDashboard->po_no=$po_master->PO_NO;
                    $landPortDashboard->po_id=$po_master->ID;
                    $landPortDashboard->po_date=date("Y-m-d", strtotime($po_master->CREATE_DATE));
                    $landPortDashboard->from_date=$value->from_date;
                    $landPortDashboard->to_date=$value->to_date;
                    $landPortDashboard->sc_no=$saleContract->invoice_no;
                    $landPortDashboard->sc_date=date("Y-m-d", strtotime($saleContract->created_at));
                    $landPortDashboard->user=$user->username.'-'.$user->name;
                    $landPortDashboard->user_id=$user->id;
                    $landPortDashboard->insert_date=date('Y-m-d');
                    $landPortDashboard->save(); 
    
                }
                
            }
        
        }else if($po_master->TEMPLATE_ID==3){
             
            $po_master=POMaster::where('PO_NO',$po_no)->first();
            if(!is_null($po_master)){
                
                foreach ($po_details as $key => $value) {
                
                    $seaPortdashboard=new seaPortdashboard();
                    $seaPortdashboard->sc_id=$saleContract->id;
                    $seaPortdashboard->party_id=$saleContract->notify_pary_id;
                    $seaPortdashboard->Task_ID=$value->task_id;
                    if($value->task_id==12){
    
                        $seaPortdashboard->action_date=$po_date;
                    }
                    if($value->task_id==13){
                        
                        $seaPortdashboard->action_date=$sc_date;
                    }
                    $seaPortdashboard->desk=$desk->name;
                    $seaPortdashboard->task_name=$value->description;
                    $seaPortdashboard->po_no=$po_master->PO_NO;
                    $seaPortdashboard->po_id=$po_master->ID;
                    $seaPortdashboard->po_date=date("Y-m-d", strtotime($po_master->CREATE_DATE));
                    $seaPortdashboard->from_date=$value->from_date;
                    $seaPortdashboard->to_date=$value->to_date;
                    $seaPortdashboard->sc_no=$saleContract->invoice_no;
                    $seaPortdashboard->sc_date=date("Y-m-d", strtotime($saleContract->created_at));
                    $seaPortdashboard->user=$user->username.'-'.$user->name;
                    $seaPortdashboard->user=$user->username.'-'.$user->name;
                    $seaPortdashboard->user_id=$user->id;
                    $seaPortdashboard->save(); 
    
                } 


            }

        }
  

    } 

    public function updateBoardTaskList($po_id,$request){

        
        $poMaster=POMaster::where('id',$po_id)->first(['TEMPLATE_ID']);
        $template=TemplateMaster::where('id',$poMaster->TEMPLATE_ID)->first(['TEMPLATE_TYPE']);
        if($template->TEMPLATE_TYPE==1){
           
            $inv_date = $request->invoice_date != "" ? date("Y-m-d", strtotime($request->invoice_date)) : NULL;
            if(LandPortDashboard::where('po_id', $po_id)->where('Task_ID', 4)->count()>0){

                $shipingDoc=LandPortDashboard::where('po_id', $po_id)->where('Task_ID', 4)->first(['action_date']);
                if(is_null($shipingDoc->action_date)){

                    seaPortdashboard::where('po_id', $po_id)->where('Task_ID', 4)->update(['action_date' => $inv_date]);
                }

            }
            

        }
        if($template->TEMPLATE_TYPE==2){

            $bl_date=$request->bl_date!="" ? date("Y-m-d", strtotime($request->bl_date)) : NULL;  
            $co_date = $request->invoice_date != "" ? date("Y-m-d", strtotime($request->invoice_date)) : NULL;
            
            

            if(seaPortdashboard::where('po_id', $po_id)->where('Task_ID', 16)->count()>0){

                $bl= seaPortdashboard::where('po_id', $po_id)->where('Task_ID', 16)->first(['action_date']);
                if(is_null($bl->action_date)){

                    seaPortdashboard::where('po_id', $po_id)->where('Task_ID', 16)->update(['action_date' => $bl_date]); //--ship on board date
                    seaPortdashboard::where('po_id', $po_id)->where('Task_ID', 23)->update(['action_date' => $bl_date]); //--gsp/oc/china CO Collection
                
                }

            }

            if(seaPortdashboard::where('po_id', $po_id)->where('Task_ID', 15)->count()>0){

                $vat_cnf=seaPortdashboard::where('po_id', $po_id)->where('Task_ID', 15)->first(['action_date']);
                if(is_null($vat_cnf->action_date)){
              
                    seaPortdashboard::where('po_id',$po_id)->where('Task_ID',15)->update(['action_date'=>$co_date]); //--vat & cnf document                            
                    
                }

            }
            
        
        }

    }

    public function show($id,$party_id){
  
        $id=\Crypt::decrypt($id);
        $dparty_id=\Crypt::decrypt($party_id);
        $sale_contract = SaleContract::find($id); 
        if(CNF::where('sale_contract_id', $id)->count()>0){

            $cnf=CNF::where('sale_contract_id', $id)->first();

        }else{

            $cnf=null;
        }

        $sale_contract_details =SaleContractDetail::where('sale_contract_id',$id)->orderBy('id','asc')->get(); 
        $unposted_status=0;
        if(UserFeatures::where('user_id',Auth::user()->id)->where('feature_id',21)->exists()){ $unposted_status=1; }
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $ciEditHistories=CiEditHistory::where('sales_contact_id', $id)->get();
        $userTaskLists=[];
        return view("sale_contract.sale_contract_show",compact("sale_contract"))
                 ->with('sale_contract_details',$sale_contract_details)
                 ->with('unposted_status',$unposted_status)
                 ->with('party_id', $dparty_id)
                 ->with('total_net_weight', $total_net_weight)
                 ->with('sale_contract_no', $id)
                 ->with('ciEditHistories', $ciEditHistories)
                 ->with('userTaskLists', $userTaskLists)
                 ->with('cnf',$cnf);
                 
    }


    public function saleContractFactroyDetails(Request $request,$id){
            
        $user_id=Auth::user()->id; 
        $sale_contract = SaleContract::find($id); 
        $sale_contract_details =SaleContractDetail::where('sale_contract_id',$id)->orderBy('id','asc')->get(); 
        $unposted_status=0;
        if(UserFeatures::where('user_id',Auth::user()->id)->where('feature_id',21)->exists()){ $unposted_status=1; }
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $ciEditHistories=CiEditHistory::where('sales_contact_id', $id)->get();
        return view("factory_user.sales_contact_details_factory",compact("sale_contract"))
                 ->with('sale_contract_details',$sale_contract_details)
                 ->with('unposted_status',$unposted_status)
                 ->with('party_id', 1)
                 ->with('total_net_weight', $total_net_weight)
                 ->with('sale_contract_no', $id)
                 ->with('ciEditHistories', $ciEditHistories);

    }

     public function comInvDetails($id,$party_id){
  
        $id=\Crypt::decrypt($id);
        $sale_contract = SaleContract::find($id); 
	$dparty_id = $sale_contract->notify_pary_id;
        if(CNF::where('sale_contract_id', $id)->count()>0){

            $cnf=CNF::where('sale_contract_id', $id)->first();

        }else{

            $cnf=null;
        }
        $sale_contract_details =SaleContractDetail::where('sale_contract_id',$id)->orderBy('id','asc')->get(); 
        $unposted_status=0;
        if(UserFeatures::where('user_id',Auth::user()->id)->where('feature_id',21)->exists()){ $unposted_status=1; }
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $ciEditHistories=CiEditHistory::where('sales_contact_id', $id)->get();
        $userTaskLists=[];
        if($sale_contract->po_number){

            $sale_contract->po_number;
            $poMaster=POMaster::where('PO_NO',$sale_contract->po_number)->first(['id','TEMPLATE_ID']);
            $poMasterId=$poMaster->id;
            $userId=Auth::user()->id;
            $sale_contact_id=$sale_contract->id;
            if($poMaster->TEMPLATE_ID==1){

                $userTaskLists=DB::select("CALL UPDATE_TASK_LIST_LAND($sale_contact_id,$userId)");

            }elseif($poMaster->TEMPLATE_ID==3) {
                
                $userTaskLists=DB::select("CALL UPDATE_TASK_LIST_SEA($sale_contact_id,$userId)");
            }

        }

        


        return view("sale_contract.sale_contract_details_com",compact("sale_contract"))
                 ->with('sale_contract_details',$sale_contract_details)
                 ->with('unposted_status',$unposted_status)
                 ->with('party_id', $dparty_id)
                 ->with('total_net_weight', $total_net_weight)
                 ->with('sale_contract_no', $id)
                 ->with('ciEditHistories', $ciEditHistories)
                 ->with('userTaskLists', $userTaskLists)
                 ->with('cnf',$cnf);
                 
    }

    public function ci_sale_contract($id){
           
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                            ->select('sale_contract_details.ci_item_name','sale_contract_details.hs_code','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_item_rate','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contracts.ci_note',
                            DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                            DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                            DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                            DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
                         ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                         ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                         ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.rate_per_ctn')
                         ->orderBy('sale_contract_details.id')
                         ->get();
                         
        $sale_contract = SaleContract::find($id);
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        return view("sale_contract.ci_sale_contract",compact("sale_contract"))
                ->with('sale_contract_details',$sale_contract_details)
                ->with('total_net_weight', $total_net_weight)
                ->with('obj',$this);
     
    }

    public function ksa_sale_contract($id){
           
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contracts.ci_note','notify_party_items.desk_item_name',
                            DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                            DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                            DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                            DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.ccq) AS ccq'),
                            DB::Raw('SUM(sale_contract_details.rate_per_ctn_for_acc + sale_contract_details.per_ctn_freight) AS ci_item_rate'))
                         ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                         ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                         ->join('notify_party_items', function ($join) {

                                $join->on('notify_party_items.ci_item_id', '=', 'ci_items.id')
                                     ->on('notify_party_items.notify_party_id', '=', 'sale_contracts.notify_pary_id');
                          })
                         ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contracts.ci_note','notify_party_items.desk_item_name')
                         ->orderBy('sale_contract_details.id')
                         ->get();

        $sale_contract = SaleContract::find($id);
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        return view("sale_contract.ksa.sale_contract",compact("sale_contract"))
                ->with('sale_contract_details',$sale_contract_details)
                ->with('total_net_weight', $total_net_weight)
                ->with('obj',$this);
     
    }
    



    // PRAN FROZEN CHOI PITHA-400 GX20 POUCH
    public function scDeskPad($id){

        $sale_contract = SaleContract::find($id);
        $insurance_charge=$sale_contract->insurance_charge;
        $pallet_charge=$sale_contract->pallet_charge;
        $company_id=$sale_contract->company_id;
        $importer_id=$sale_contract->importer_id;
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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        if(!empty($insurance_charge) && !empty($pallet_charge)){

            Session::flash("danger", "Insurance & Pallet Is Not Allow Same Sale Contact..!!");
            return redirect()->back();
        }

        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){

            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        }

        return view("sale_contract.pad.desk.desk_sales_contract",compact("sale_contract"))
                ->with('sale_contract_details',$sale_contract_details)
                ->with('factory_address', $factory_address)
                ->with('insurance_charge', $insurance_charge)
                ->with('pallet_charge', $pallet_charge)
                ->with('signatureImg',$signatureImg)
                ->with('obj',$this);

    }

    public function padCISalesContract($id){
       
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','sale_contract_details.hs_code','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_item_rate','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contracts.ci_note',
                                    DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                    DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                    DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                    DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                    DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                    DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
                                ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                                ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                                ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.hs_code')
                                ->orderBy('sale_contract_details.id')
                                ->get();

        $sale_contract = SaleContract::find($id);
        $company_id=$sale_contract->company_id;
        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){

            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        }
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        return view("sale_contract.pad.documentation.ci_sale_contact",compact("sale_contract"))
                ->with('sale_contract_details',$sale_contract_details)
                ->with('total_net_weight', $total_net_weight)
                ->with('signatureImg',$signatureImg)
                ->with('obj',$this);


    }

    public function padPacketAndWeightList($id){
         
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
            ->select('sale_contract_details.ci_item_name','sale_contract_details.hs_code','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_item_rate','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contracts.ci_note',
                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.hs_code')
            ->orderBy('sale_contract_details.id')
            ->get();
            
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $sale_contract = SaleContract::find($id);
        $company_id = $sale_contract->company_id;
        $nocs_array=$this->create_nocs($sale_contract_details);
        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){

            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        }

        return view("sale_contract.pad.documentation.ci_com_inv_pwl",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('nocs_array',$nocs_array)
              ->with('signatureImg',$signatureImg)
              ->with('total_net_weight', $total_net_weight);

    }

    public function padPI($id){
         
        $sale_contract = SaleContract::find($id);
        $insurance_charge=$sale_contract->insurance_charge;
        $pallet_charge=$sale_contract->pallet_charge;
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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        if(!empty($insurance_charge) && !empty($pallet_charge)){

            Session::flash("danger", "Insurance & Pallet Is Not Allow Same Sale Contact..!!");
            return redirect()->back();
        }
        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){

            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        }
        return view("sale_contract.pad.desk.desk_pi_pad",compact("sale_contract"))
                ->with('sale_contract_details',$sale_contract_details)
                ->with('factory_address', $factory_address)
                ->with('insurance_charge', $insurance_charge)
                ->with('signatureImg',$signatureImg)
                ->with('pallet_charge', $pallet_charge);
              

    }

    public function ci_com_inv($id){

        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','sale_contract_details.hs_code','ci_items.p_net_weight','ci_items.duplicate_name','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.rate_per_ctn')
                            ->orderBy('sale_contract_details.id')
                            ->get();
        $sale_contract = SaleContract::find($id);
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $nocs_array=$this->create_nocs($sale_contract_details); 
        return view("sale_contract.ci_com_inv",compact("sale_contract"))
                ->with('sale_contract_details',$sale_contract_details)
                ->with('obj',$this)
                ->with('total_net_weight', $total_net_weight)
                ->with('nocs_array', $nocs_array);


    }

    public function ci_com_inv_pad($id){

        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','sale_contract_details.hs_code','ci_items.p_net_weight','ci_items.duplicate_name','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.hs_code')
                            ->orderBy('sale_contract_details.id')
                            ->get();
        $sale_contract = SaleContract::find($id);
        $company_id =$sale_contract->company_id;
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $nocs_array=$this->create_nocs($sale_contract_details);  
        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){

            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        }
        return view("sale_contract.pad.documentation.ci_com_inv",compact("sale_contract"))
                ->with('sale_contract_details',$sale_contract_details)
                ->with('total_net_weight', $total_net_weight)
                ->with('nocs_array', $nocs_array)
                ->with('signatureImg',$signatureImg)
                ->with('obj',$this);
 


    }

 


    public function ksa_com_inv($id){

	 $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.rate_per_ctn','notify_party_items.desk_item_name',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq'),
                                DB::Raw('SUM(sale_contract_details.rate_per_ctn_for_acc + sale_contract_details.per_ctn_freight) AS ci_item_rate'))
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->join('notify_party_items', function ($join) {

                                $join->on('notify_party_items.ci_item_id', '=', 'ci_items.id')
                                     ->on('notify_party_items.notify_party_id', '=', 'sale_contracts.notify_pary_id');
                            })
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.rate_per_ctn','notify_party_items.desk_item_name')
                            ->orderBy('sale_contract_details.id')
                            ->get();

	$sale_contract = SaleContract::find($id);
	$total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
	$nocs_array=$this->create_nocs($sale_contract_details); 
	return view("sale_contract.ksa.ksa_com_inv",compact("sale_contract"))
			->with('sale_contract_details',$sale_contract_details)
			->with('obj',$this)
			->with('total_net_weight', $total_net_weight)
			->with('nocs_array', $nocs_array);
     
 }

    
    

    public function ci_com_inv_pack_weight($id){
         
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
            ->select('sale_contract_details.ci_item_name','sale_contract_details.hs_code','ci_items.p_net_weight','ci_items.duplicate_name','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','ci_items.ci_item_code',
                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.rate_per_ctn')
            ->orderBy('sale_contract_details.id')
            ->get();
            
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $sale_contract = SaleContract::find($id);
        $nocs_array=$this->create_nocs($sale_contract_details);

        return view("sale_contract.ci_com_inv_pack_weight",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('nocs_array',$nocs_array)
              ->with('total_net_weight', $total_net_weight);

    }

   public function ksa_com_inv_pack_weight($id){
            
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.rate_per_ctn','ci_items.ci_item_code','notify_party_items.desk_item_name',
                    DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                    DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                    DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                    DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                    DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                    DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
                ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                ->join('notify_party_items', function ($join) {

                    $join->on('notify_party_items.ci_item_id', '=', 'ci_items.id')
                        ->on('notify_party_items.notify_party_id', '=', 'sale_contracts.notify_pary_id');
                })
                ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.rate_per_ctn','notify_party_items.desk_item_name','ci_items.ci_item_code')
                ->orderBy('sale_contract_details.id')
                ->get();
                
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $sale_contract = SaleContract::find($id);
        $nocs_array=$this->create_nocs($sale_contract_details);
        return view("sale_contract.ksa.ksa_com_inv_pack_weight",compact("sale_contract"))
            ->with('sale_contract_details',$sale_contract_details)
            ->with('obj',$this)
            ->with('nocs_array',$nocs_array)
            ->with('total_net_weight', $total_net_weight);

    }



    public function getHsCodeWiseComInvReport($id){

        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.duplicate_name',
                                'ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','ci_items.ci_item_code','ci_items.hs_code',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.duplicate_name','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','ci_items.ci_item_code','ci_items.hs_code')
                            ->orderBy('ci_items.hs_code')
                            ->get();

        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $sale_contract = SaleContract::find($id);
        $nocs_array=$this->create_nocs($sale_contract_details); 
        $hs_codes_results=DB::select("SELECT sale_contract_details.hs_code,COUNT(sale_contract_details.ci_item_id) as count
                    FROM sale_contract_details
                    WHERE sale_contract_details.sale_contract_id = $id
                    GROUP BY sale_contract_details.hs_code
                    ORDER BY sale_contract_details.hs_code");   

        $hs_code_array=array();
        $count_array=array();
        foreach($hs_codes_results as $hs_codes_result){
          
            array_push($hs_code_array,$hs_codes_result->hs_code);
            array_push($count_array,$hs_codes_result->count);

        }

        $loop_init=count($count_array);

        return view("sale_contract.hsc_ci_com_inv_pack_weight",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('nocs_array',$nocs_array)
              ->with('total_net_weight', $total_net_weight)
              ->with('hs_codes',$hs_code_array)
              ->with('count_array',$count_array)
              ->with('loop_init',$loop_init);

      }

      public function ci_sale_contract_tr($id){

        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.duplicate_name','ci_items.ci_item_rate','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contracts.ci_note',
                            DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                            DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                            DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                            DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
                         ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                         ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                         ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                         ->orderBy('sale_contract_details.id')
                         ->get();
        $sale_contract = SaleContract::find($id);
        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");
        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        } 
        $sale_contract = SaleContract::find($id); 
        return view("sale_contract.tr_dubai.ci_sales_contact_tr",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('obj',$this)->with('total_net_weight', $total_net_weight);
     
    }

    public function ci_com_inv_tr($id){

        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.duplicate_name','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn',
                                    DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                    DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                    DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                    DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                    DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                    DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
                                ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                                ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                                ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                                ->orderBy('sale_contract_details.id')
                                ->get();
        $sale_contract = SaleContract::find($id);
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');;
        $nocs_array=$this->create_nocs($sale_contract_details); 
        return view("sale_contract.tr_dubai.ci_inv_tr",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('obj',$this)->with('total_net_weight', $total_net_weight);
     
    }

    public function ci_packaging_tr($id){

        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                            ->select('sale_contract_details.ci_item_name','ci_items.duplicate_name','ci_items.p_net_weight','ci_items.ci_factor',
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
        $sale_contract = SaleContract::find($id);
        $nocs_array=$this->create_nocs($sale_contract_details);  
        return view("sale_contract.tr_dubai.ci_pwl_tr",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('obj',$this)->with('nocs_array', $nocs_array);
         

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

     public function ci_com_inv_pack_weight_not_merch($id){

        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)
                                      ->orderBy('id', 'DESC')   
                                      ->get(); 
        return view("sale_contract.ci_com_inv_pack_weight_merge_report",compact("sale_contract"))
                 ->with('sale_contract_details',$sale_contract_details)
                 ->with('obj',$this);
     }
     public function application_for_exp_lien($id){
        
        $total_carton=0;
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight',
                                'ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn',
                                'importers.name as importer_name','importers.address as importer_address',
                                'notify_parties.name as notify_party_name','notify_parties.address as notify_party_address',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq')
                                )
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->join('importers','importers.id','sale_contracts.importer_id')
                            ->join('notify_parties','notify_parties.id','sale_contracts.notify_pary_id')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                            ->orderBy('sale_contract_details.id')
                            ->get();

        $sale_contract = SaleContract::find($id); 
        foreach ($sale_contract_details as $key => $value) {
            
            $total_amount=$value->total_amount;
            $total_carton=$total_carton+$value->ctn;
            $importer_name=$value->importer_name;
            $importer_address=$value->importer_address;
            $notify_party_name=$value->notify_party_name;
            $notify_party_address=$value->notify_party_address;

        } 
     
     

        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");
        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        }
        return view("sale_contract.ci_application_for_exp_lien",compact("sale_contract"))
                ->with('sale_contract_details',$sale_contract_details)
                ->with('obj',$this)
                ->with('total_amount', $total_amount)
                ->with('ctn', $total_carton)
                ->with('total_net_weight',$total_net_weight)
                ->with('id', $id)
                ->with('importer_address',  $importer_address)
                ->with('notify_party_address', $notify_party_address)
                ->with('importer_name',$importer_name)
                ->with('notify_party_name', $notify_party_name);

     }
     public function phyto($id){

        $ctn=0;
        $gross_weight_kg=0;
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq')
                                )
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                            ->orderBy('sale_contract_details.id')
                            ->get();
        $sale_contract = SaleContract::find($id);

        foreach ($sale_contract_details as $key => $value) {
         
            $ctn=$ctn+$value->ctn;
            $gross_weight_kg=$gross_weight_kg+$value->gross_weight_kg;
        
        } 
        return view("sale_contract.ci_phyto",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('ctn', $ctn)
              ->with('gross_weight_kg', $gross_weight_kg);
     }

    public function bank_for($id){

      $total_carton=0;
      $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                        ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_factor','ci_items.ci_item_rate','bank_for_print_date','sale_contract_details.rate_per_ctn','importers.address as importer_address','importers.name as importer_name','notify_parties.address as notify_party_address','notify_parties.name as notify_party_name',
                        DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                        DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                        DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                        DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                        DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                        DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                        DB::Raw('SUM(sale_contract_details.ccq) AS ccq')
                        )
                    ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                    ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                    ->join('importers','importers.id','sale_contracts.importer_id')
                    ->join('notify_parties','notify_parties.id','sale_contracts.notify_pary_id')
                    ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                    ->orderBy('sale_contract_details.id')
                    ->get();
            $sale_contract = SaleContract::find($id);
            foreach ($sale_contract_details as $key => $value) {
                
                $total_amount=$value->total_amount;
                $total_carton=$total_carton+$value->ctn;
                $importer_name=$value->importer_name;
                $importer_address=$value->importer_address;
                $notify_party_name=$value->notify_party_name;
                $notify_party_address=$value->notify_party_address;
            }
            $sale_contract = SaleContract::find($id); 
            $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                                FROM sale_contract_details
                                WHERE sale_contract_details.sale_contract_id='$id'");
            foreach ($results as $key => $value) {
               
                 $total_net_weight=$value->total_net_weight_kg;

            }

            LandPortDashboard::where('sc_id',$id)->where('Task_ID',11)->update([
                'action_date'=>date('Y-m-d')
            ]);
    
            seaPortdashboard::where('sc_id',$id)->where('Task_ID',11)->update([
                'action_date'=>date('Y-m-d')
            ]);  

            return view("sale_contract.ci_bank_for",compact("sale_contract"))
                   ->with('sale_contract_details',$sale_contract_details)
                   ->with('obj',$this)
                   ->with('total_amount', $total_amount)
                   ->with('ctn', $total_carton)
                   ->with('total_net_weight', $total_net_weight)
                   ->with('id', $id)
                   ->with('importer_address',  $importer_address)
                   ->with('notify_party_address', $notify_party_address)
                   ->with('importer_name',$importer_name)
                   ->with('notify_party_name', $notify_party_name);    
    
    }


     public function makeFixedBankForDate(Request $request){

        $saleContract=SaleContract::where('id',$request->id)->first(['is_print','po_master_id']); 
        if($saleContract->is_print==0){

            $current_date = date('Y-m-d');
            $next_day = date('Y-m-d', strtotime($current_date . ' +1 day'));
            DB::table('sale_contracts')
                    ->where('id', $request->id)
                    ->update([
                'bank_for_print_date' =>$next_day,
                'is_print' => 1  
            ]);

            echo"Success"; 

        }


     }

     public function makeFixedNocReportDate(Request $request){
        
        $saleContract=SaleContract::where('id',$request->id)->pluck('is_noc_print'); 
        $is_noc_print=$saleContract['0'];
        if($is_noc_print==0){

            $date = date('Y-m-d');
            DB::table('sale_contracts')
                    ->where('id', $request->id)
                    ->update([
                'noc_print_date' => $date,
                'is_noc_print' => 1  
            ]);

            echo"Success"; 

        }

     }

      public function noc($id){
        
        $total_carton=0;
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','importers.name as importer_name','importers.address as importer_address','notify_parties.name as notify_party_name','notify_parties.address as notify_party_address',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq')
                                )
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->join('importers','importers.id','sale_contracts.importer_id')
                            ->join('notify_parties','notify_parties.id','sale_contracts.notify_pary_id')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                            ->orderBy('sale_contract_details.id')
                            ->get();
        $sale_contract = SaleContract::find($id);
        foreach ($sale_contract_details as $key => $value) {
            
            $total_amount=$value->total_amount;
            $total_carton=$total_carton+$value->ctn;
            $importer_name=$value->importer_name;
            $importer_address=$value->importer_address;
            $notify_party_name=$value->notify_party_name;
            $notify_party_address=$value->notify_party_address;

        } 


        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");
        foreach ($results as $key => $value) {
           
            $total_net_weight=$value->total_net_weight_kg;

        }

        return view("sale_contract.ci_noc",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('total_amount', $total_amount)
              ->with('ctn', $total_carton)
              ->with('total_net_weight',$total_net_weight)
              ->with('id', $id)
              ->with('importer_address',  $importer_address)
              ->with('notify_party_address', $notify_party_address)
              ->with('importer_name',$importer_name)
              ->with('notify_party_name', $notify_party_name);
      }
     
     public function exp_cancel($id){
                 
        $total_carton=0;
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','importers.name as importer_name','importers.address as importer_address','notify_parties.name as notify_party_name','notify_parties.address as notify_party_address',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq')
                                )
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->join('importers','importers.id','sale_contracts.importer_id')
                            ->join('notify_parties','notify_parties.id','sale_contracts.notify_pary_id')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','importers.name','importers.address','notify_parties.name','notify_parties.address')
                            ->orderBy('sale_contract_details.id')
                            ->get();
        $sale_contract = SaleContract::find($id);
        foreach ($sale_contract_details as $key => $value) {
            
            $total_amount=$value->total_amount;
            $total_carton=$total_carton+$value->ctn;
            $importer_name=$value->importer_name;
            $importer_address=$value->importer_address;
            $notify_party_name=$value->notify_party_name;
            $notify_party_address=$value->notify_party_address;

        } 

        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");

        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        }

        return view("sale_contract.ci_exp_cancel",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('total_amount', $total_amount)
              ->with('ctn', $total_carton)
              ->with('total_net_weight',$total_net_weight)
              ->with('id', $id)
              ->with('importer_address',  $importer_address)
              ->with('notify_party_address', $notify_party_address)
              ->with('importer_name',$importer_name)
              ->with('notify_party_name', $notify_party_name);

     
     }

     public function noc_india($id){
        
        $total_carton=0;
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','sale_contract_details.total_amount_party',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq')
                                )
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                            ->orderBy('sale_contract_details.id')
                            ->get();
        $sale_contract = SaleContract::find($id);
        foreach ($sale_contract_details as $key => $value) {
            
            $total_amount=$value->total_amount;
            $total_carton=$total_carton+$value->ctn;
        } 
        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");
        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        }

        $desk_freight_cost=$sale_contract->desk_freight_cost;
        $p_total_amount=0;
        foreach ($sale_contract_details as $key => $value) {
          
           $p_total_amount=$p_total_amount+$value->total_amount_party;

        }

        $total_amount_with_freight=$desk_freight_cost+$p_total_amount;
        return view("sale_contract.ci_noc_ind",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('total_amount', $total_amount)
              ->with('ctn', $total_carton)
              ->with('total_net_weight',$total_net_weight)
              ->with('total_amount_with_freight',$total_amount_with_freight); 
     }
     



     public function nocReportUsaCanada($id){

        $total_carton=0;
        $sale_contract = SaleContract::find($id);
        $bank=Bank::where('id', $sale_contract->bank_id)->pluck('name');
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $user = auth()->user();
        $email=$user->email;
        return view("sale_contract.ci_noc_canada_usa",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('bank', $bank['0'])
              ->with('email', $email);

     }

     public function nocMaersk($id){

        $total_carton=0;
        $sale_contract = SaleContract::find($id);
        $bank=Bank::where('id', $sale_contract->bank_id)->pluck('name');
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $user = auth()->user();
        $email=$user->email;
        return view("sale_contract.noc_maersk",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('bank', $bank['0'])
              ->with('email', $email);

     } 

     public function nocMsc($id){

        $total_carton=0;
        $sale_contract = SaleContract::find($id);
        $bank=Bank::where('id', $sale_contract->bank_id)->pluck('name');
        $gross_weight = SaleContractDetail::where('sale_contract_id', $id)->sum('gross_weight_kg');
        $user = auth()->user();
        $email=$user->email;
        return view("sale_contract.noc_msc",compact("sale_contract"))
              ->with('gross_weight',$gross_weight)
              ->with('obj',$this)
              ->with('bank', $bank['0'])
              ->with('email', $email);

     } 

     public function nocCMACGM($id){

        $total_carton=0;
        $sale_contract = SaleContract::find($id);
        $bank=Bank::where('id', $sale_contract->bank_id)->pluck('name');
        $gross_weight = SaleContractDetail::where('sale_contract_id', $id)->sum('gross_weight_kg');
        $user = auth()->user();
        $email=$user->email;
        return view("sale_contract.noc_cma_cgm",compact("sale_contract"))
              ->with('gross_weight',$gross_weight)
              ->with('obj',$this)
              ->with('bank', $bank['0'])
              ->with('email', $email);

     } 

     public function riskBondFun($id){

        $sale_contract = SaleContract::select('total_container', 'container_1', 'container_2', 'container_3','company_id','container_number','phyto_product_name')->find($id);
        $company_name = Company::where('id', $sale_contract->company_id)->value('name');
        $factory_address = Company::where('id', $sale_contract->company_id)->value('factory_address');
        $riskBond = DB::table('risk_bond')->first();
        $bond_amount=$riskBond->bond_amount*$sale_contract->total_container;
        $formatted_number = number_format($bond_amount, 0, '', ',');
        $formatted_number = preg_replace('/(\d)(?=(\d{2})+(\d))/', '$1,', $formatted_number);
        $toWord=$this->convertNumberToWords($bond_amount);
        $containerSize = implode(',', array_filter([$sale_contract->container_1, $sale_contract->container_2, $sale_contract->container_3]));
        $containerQty=$sale_contract->container_number;
        return view("sale_contract.risk_bond",compact('sale_contract'))
            ->with('factory_address',$factory_address)
            ->with('company_name',$company_name)
            ->with('formatted_number',$formatted_number)
            ->with('toWord',$toWord)
            ->with('containerSize',$containerSize)
            ->with('containerQty',$containerQty);

     }  

     private function convertNumberToWords($number) {

        $words = array(
            0 => 'Zero',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety'
        );
    
        // Units for large numbers (Indian Numbering System: Lakh, Crore)
        $units = array(
            10000000 => 'Crore',
            100000 => 'Lakh',
            1000 => 'Thousand',
            100 => 'Hundred',
        );
    
        // If the number is less than 20, return the corresponding word
        if ($number < 20) {
            return $words[$number];
        }
    
        // If the number is less than 100
        if ($number < 100) {
            $tens = (int)($number / 10) * 10; // Get the tens (e.g., 30 from 32)
            $ones = $number % 10; // Get the ones (e.g., 2 from 32)
            return $words[$tens] . ($ones ? ' ' . $words[$ones] : '');
        }
    
        // Process large numbers: Hundreds, Thousands, Lakh, Crore
        $result = '';
        foreach ($units as $key => $value) {
            if ($number >= $key) {
                $count = floor($number / $key); // Divide the number by the unit
                $number -= $count * $key; // Subtract the processed part
    
                // If the unit is Lakh, Thousand, or Crore, process and append the result
                $result .= ($result ? ' ' : '') . $this->convertNumberToWords($count) . ' ' . $value;
            }
        }
    
        // Handle the remaining part (e.g., the last two digits after processing large units)
        if ($number) {
            $result .= ($result ? ' ' : '') . $words[$number];
        }
    
        return $result;
    }



    public function truck_receipt($id){

        $sale_contract = SaleContract::find($id);
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $net_weight=0;
        $gross_weight=0;
        $number_of_ctn=0;
        $total_amount=0;                    
        foreach ($sale_contract_details as $key => $value) {
           
           $net_weight=$net_weight+$value->net_weight_kg;
           $gross_weight=$gross_weight+$value->gross_weight_kg;
           $number_of_ctn=$number_of_ctn+$value->ctn;
           $total_amount=$total_amount+$value->total_amount_party;                    

        }      

        $transport_agency_info=TransportAgency::where('id', $sale_contract->transport_agency_id)->pluck('transport_agency_info');

        if(!empty($transport_agency_info['0'])){
                                           
           $transport_agency_info=$transport_agency_info['0'];

        }else{
           
           $transport_agency_info="";

        }

        $transport_agency_details=TransportAgency::where('id', $sale_contract->transport_agency_id)->pluck('description');
        if(!empty($transport_agency_details['0'])){
                                           
           $transport_agency_details=$transport_agency_details['0'];

        }else{
           
           $transport_agency_details="";

        } 

        $ci_note=explode(",",$sale_contract->ci_note);
        if(!empty($ci_note['0'])){

            $lc_number=$ci_note['0'];
        }else{

             $lc_number="";

        }

        if(!empty($ci_note['1'])){

           $lc_date=$ci_note['1']; 

        }else{

           $lc_date=""; 
        }

        return view("sale_contract.truck_receipt",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('transport_agency_info', $transport_agency_info)
              ->with('transport_agency_details', $transport_agency_details)
              ->with('net_weight', $net_weight)
              ->with('gross_weight', $gross_weight)
              ->with('number_of_ctn', $number_of_ctn)
              ->with('total_amount', $total_amount)
              ->with('lc_number', $lc_number)
              ->with('lc_date', $lc_date);

    }

    public function truck_recipt_india($id){

        $sale_contract = SaleContract::find($id);
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $net_weight=0;
        $gross_weight=0;
        $number_of_ctn=0;
        $total_amount=0;                    
        foreach ($sale_contract_details as $key => $value) {
           
           $net_weight=$net_weight+$value->net_weight_kg;
           $gross_weight=$gross_weight+$value->gross_weight_kg;
           $number_of_ctn=$number_of_ctn+$value->ctn;
           $total_amount=$total_amount+$value->total_amount_party;                    

        } 

        $transport_agency_info=TransportAgency::where('id', $sale_contract->transport_agency_id)->pluck('transport_agency_info');
        if(!empty($transport_agency_info['0'])){
                                           
           $transport_agency_info=$transport_agency_info['0'];

        }else{
           
           $transport_agency_info="";

        }

        $transport_agency_details=TransportAgency::where('id', $sale_contract->transport_agency_id)->pluck('description');
        if(!empty($transport_agency_details['0'])){
                                           
           $transport_agency_details=$transport_agency_details['0'];

        }else{
           
           $transport_agency_details="";

        } 

        $ci_note=explode(",",$sale_contract->ci_note);
        if(!empty($ci_note['0'])){

            $lc_number=$ci_note['0'];
        }else{

             $lc_number="";

        }

        if(!empty($ci_note['1'])){

           $lc_date=$ci_note['1']; 

        }else{

           $lc_date=""; 

        }

        $currency_type=SaleContract::where('id',$id)->first(['currency_id']) ; 
        if($currency_type->currency_id!=1){

            if(ScCurrencyHistory::where('sale_contract_id', $id)->count()!=0){
           
                $scRateHistroy=ScCurrencyHistory::where('sale_contract_id',$id)->where('currency_id',$currency_type->currency_id)->orderBy('id','ASC')->first();
                $exchange_rate=$scRateHistroy->rate;

            }else{

                $exchange_rate=1;
            }

        }else{

            $exchange_rate=1;

        }

        return view("sale_contract.ind.truck_receipt_ind",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('transport_agency_info', $transport_agency_info)
              ->with('transport_agency_details', $transport_agency_details)
              ->with('net_weight', $net_weight)
              ->with('gross_weight', $gross_weight)
              ->with('number_of_ctn', $number_of_ctn)
              ->with('total_amount', $total_amount)
              ->with('lc_number', $lc_number)
              ->with('exchange_rate',$exchange_rate)
              ->with('lc_date', $lc_date);

    }

    public function truck_recipt_details($id){

        $sale_contract = SaleContract::find($id);
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $net_weight=0;
        $gross_weight=0;
        $number_of_ctn=0;
        $total_amount=0;                    
        foreach ($sale_contract_details as $key => $value) {
           
           $net_weight=$net_weight+$value->net_weight_kg;
           $gross_weight=$gross_weight+$value->gross_weight_kg;
           $number_of_ctn=$number_of_ctn+$value->ctn;
           $total_amount=$total_amount+$value->total_amount_party;                    

        } 

        $transport_agency_info=TransportAgency::where('id', $sale_contract->transport_agency_id)->pluck('transport_agency_info');
        if(!empty($transport_agency_info['0'])){
                                           
           $transport_agency_info=$transport_agency_info['0'];

        }else{
           
           $transport_agency_info="";

        }

        $transport_agency_details=TransportAgency::where('id', $sale_contract->transport_agency_id)->pluck('description');
        if(!empty($transport_agency_details['0'])){
                                           
           $transport_agency_details=$transport_agency_details['0'];

        }else{
           
           $transport_agency_details="";

        } 

        $ci_note=explode(",",$sale_contract->ci_note);
        if(!empty($ci_note['0'])){

            $lc_number=$ci_note['0'];
        }else{

             $lc_number="";

        }

        if(!empty($ci_note['1'])){

           $lc_date=$ci_note['1']; 

        }else{

           $lc_date=""; 

        }

        $currency_type=SaleContract::where('id',$id)->first(['currency_id']) ; 
        if($currency_type->currency_id!=1){

            if(ScCurrencyHistory::where('sale_contract_id', $id)->count()!=0){
           
                $scRateHistroy=ScCurrencyHistory::where('sale_contract_id',$id)->where('currency_id',$currency_type->currency_id)->orderBy('id','ASC')->first();
                $exchange_rate=$scRateHistroy->rate;

            }else{

                $exchange_rate=1;
            }

        }else{

            $exchange_rate=1;

        }

        $results=TruckDetails::where('sales_contract_id',$id)->get();
        $truckDetails=TruckDetails::where('sales_contract_id',$id)->first();
        $truck_loaded_date=date("m-d-Y", strtotime($truckDetails->truck_loaded_date));
        return view("sale_contract.ind.truck_receipt_details",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('transport_agency_info', $transport_agency_info)
              ->with('transport_agency_details', $transport_agency_details)
              ->with('net_weight', $net_weight)
              ->with('gross_weight', $gross_weight)
              ->with('number_of_ctn', $number_of_ctn)
              ->with('total_amount', $total_amount)
              ->with('lc_number', $lc_number)
              ->with('exchange_rate',$exchange_rate)
              ->with('lc_date', $lc_date)
              ->with('results',$results)
              ->with('truck_loaded_date',$truck_loaded_date);

    }



    public function health_certificate($id){

        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $sale_contract = SaleContract::find($id);
        $notify_party_id=$sale_contract->notify_pary_id;
        $notify_party_address=NotifyParty::where('id',$notify_party_id)->pluck('shipping_mark');
        $notify_party_name=NotifyParty::where('id',$notify_party_id)->pluck('name');  
        return view("sale_contract.health_certificate",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('notify_party_address', $notify_party_address['0'])
              ->with('notify_party_name',$notify_party_name['0'])
              ->with('obj',$this);

    }

    public function ksa_health_certificate($id){

       $sale_contract_details = SaleContract::where('sale_contracts.id', $id)
    ->select(
        'sale_contract_details.ci_item_name',
        'ci_items.p_net_weight',
        'ci_items.duplicate_name',
        'ci_items.ci_factor',
        'ci_items.ci_item_rate',
        'sale_contract_details.rate_per_ctn',
        'ci_items.ci_item_code',
        'notify_party_items.desk_item_name',
        'sale_contract_details.ctn', // ? fixed here (added quotes)
        DB::raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
        DB::raw('SUM(sale_contract_details.total_amount) AS total_amount'),
        DB::raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
        DB::raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
        DB::raw('SUM(sale_contract_details.ccq) AS ccq')
    )
    ->join('sale_contract_details', 'sale_contract_details.sale_contract_id', '=', 'sale_contracts.id')
    ->join('ci_items', 'ci_items.id', '=', 'sale_contract_details.ci_item_id')
    ->join('notify_party_items', function ($join) {
        $join->on('notify_party_items.ci_item_id', '=', 'ci_items.id')
             ->on('notify_party_items.notify_party_id', '=', 'sale_contracts.notify_pary_id');
    })
    ->groupBy(
        'sale_contract_details.ci_item_name',
        'ci_items.p_net_weight',
        'ci_items.ci_factor',
        'ci_items.duplicate_name',
        'ci_items.ci_item_rate',
        'sale_contract_details.rate_per_ctn',
        'notify_party_items.desk_item_name',
        'sale_contract_details.ctn' // ? added here as well since it's a non-aggregated column
    )
    ->orderBy('sale_contract_details.id')
    ->get();

            
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $sale_contract = SaleContract::find($id);
        $nocs_array=$this->create_nocs($sale_contract_details);

        return view("sale_contract.ksa.health_certificate",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('nocs_array',$nocs_array)
              ->with('total_net_weight', $total_net_weight);  

    }

    public function ingredient_report(Request $request,$id){
        
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.duplicate_name','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','ci_items.ci_item_code','notify_party_items.desk_item_name','notify_party_items.ingredient',
                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
            ->join('notify_party_items', function ($join) {

                $join->on('notify_party_items.ci_item_id', '=', 'ci_items.id')
                     ->on('notify_party_items.notify_party_id', '=', 'sale_contracts.notify_pary_id');
             })
            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_item_code','ci_items.ci_factor','ci_items.duplicate_name','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','notify_party_items.desk_item_name','notify_party_items.ingredient')
            ->orderBy('sale_contract_details.id')
            ->get();
            
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $total_carton= SaleContractDetail::where('sale_contract_id',$id)->sum('ctn');
        $sale_contract = SaleContract::find($id);
        $nocs_array=$this->create_nocs($sale_contract_details);
        return view("sale_contract.ingredient_report",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('nocs_array',$nocs_array)
              ->with('total_net_weight', $total_net_weight)
              ->with('total_carton',$total_carton);


    }

    public function ingredient_report_uk(Request $request,$id){
        
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.duplicate_name','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','ci_items.ci_item_code','notify_party_items.desk_item_name','notify_party_items.ingredient',
                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
            ->join('notify_party_items', function ($join) {

                $join->on('notify_party_items.ci_item_id', '=', 'ci_items.id')
                     ->on('notify_party_items.notify_party_id', '=', 'sale_contracts.notify_pary_id');
             })
            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_item_code','ci_items.ci_factor','ci_items.duplicate_name','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','notify_party_items.desk_item_name','notify_party_items.ingredient')
            ->orderBy('sale_contract_details.id')
            ->get();
            
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $total_carton= SaleContractDetail::where('sale_contract_id',$id)->sum('ctn');
        $sale_contract = SaleContract::find($id);
        $nocs_array=$this->create_nocs($sale_contract_details);
        return view("sale_contract.ingredient_report_uk",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('nocs_array',$nocs_array)
              ->with('total_net_weight', $total_net_weight)
              ->with('total_carton',$total_carton);


    }

    public function ingredientPadReport(Request $request,$id){

        $sale_contract = SaleContract::find($id);
        $insurance_charge=$sale_contract->insurance_charge;
        $pallet_charge=$sale_contract->pallet_charge;
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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        if(!empty($insurance_charge) && !empty($pallet_charge)){

            Session::flash("danger", "Insurance & Pallet Is Not Allow Same Sale Contact..!!");
            return redirect()->back();
        }
        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){
       
            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        } 

        $total_carton= SaleContractDetail::where('sale_contract_id',$id)->sum('ctn');
        
        return view("sale_contract.pad.desk.ingredient_report",compact("sale_contract"))
                ->with('sale_contract_details',$sale_contract_details)
                ->with('factory_address', $factory_address)
                ->with('insurance_charge', $insurance_charge)
                ->with('pallet_charge', $pallet_charge)
                ->with('signatureImg',$signatureImg)
                ->with('total_carton',$total_carton)
                ->with('obj',$this);


    }

    public function ingredientUkPadReport(Request $request,$id){

        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.duplicate_name','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','ci_items.ci_item_code','notify_party_items.desk_item_name','notify_party_items.ingredient',
                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
            ->join('notify_party_items', function ($join) {

                $join->on('notify_party_items.ci_item_id', '=', 'ci_items.id')
                     ->on('notify_party_items.notify_party_id', '=', 'sale_contracts.notify_pary_id');
             })
            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_item_code','ci_items.ci_factor','ci_items.duplicate_name','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','notify_party_items.desk_item_name','notify_party_items.ingredient')
            ->orderBy('sale_contract_details.id')
            ->get();
            
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $total_carton= SaleContractDetail::where('sale_contract_id',$id)->sum('ctn');
        $sale_contract = SaleContract::find($id);
        $nocs_array=$this->create_nocs($sale_contract_details);
        $company_id=$sale_contract->company_id;
        $companyDetails=DB::table('companies')
            ->where('id', $company_id)
            ->get();
        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){
       
            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        } 
        return view("sale_contract.pad.desk.ingredient_report_uk",compact("sale_contract"))
        ->with('sale_contract_details',$sale_contract_details)
        ->with('obj',$this)
        ->with('signatureImg',$signatureImg)
        ->with('nocs_array',$nocs_array)
        ->with('total_net_weight', $total_net_weight)
        ->with('total_carton',$total_carton);


    }

    public function customCER($id){
      
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $sale_contract = SaleContract::find($id);
        $notify_party_id=$sale_contract->notify_pary_id;
        $notify_party_address=NotifyParty::where('id',$notify_party_id)->pluck('shipping_mark');
        $notify_party_name=NotifyParty::where('id',$notify_party_id)->pluck('name');  
        return view("sale_contract.ci_custom_cer",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this);

    }

    public function customCERCtg($id){
      
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $sale_contract = SaleContract::find($id);
        $notify_party_id=$sale_contract->notify_pary_id;
        $notify_party_address=NotifyParty::where('id',$notify_party_id)->pluck('shipping_mark');
        $notify_party_name=NotifyParty::where('id',$notify_party_id)->pluck('name');  
        return view("sale_contract.ci_custom_cer_ctg",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this);

    }

    public function customCER2($id){
      
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $sale_contract = SaleContract::find($id);
        $notify_party_id=$sale_contract->notify_pary_id;
        $notify_party_address=NotifyParty::where('id',$notify_party_id)->pluck('shipping_mark');
        $notify_party_name=NotifyParty::where('id',$notify_party_id)->pluck('name');  
        return view("sale_contract.ci_custom_cer2",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this);

    }

    public function customCER3($id){
      
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $sale_contract = SaleContract::find($id);
        $notify_party_id=$sale_contract->notify_pary_id;
        $notify_party_address=NotifyParty::where('id',$notify_party_id)->pluck('shipping_mark');
        $notify_party_name=NotifyParty::where('id',$notify_party_id)->pluck('name');  
        return view("sale_contract.ci_custom_cer3",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this);

    }


    public function gt_bill($id){
    
        $total_amount=0; 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        foreach ($sale_contract_details as $key => $value) {

            $total_amount=$total_amount+$value->total_amount_party;   
                            
        }               
        $sale_contract = SaleContract::find($id);
        $notify_party_id=$sale_contract->notify_pary_id;
        $notify_party_address=NotifyParty::where('id',$notify_party_id)->pluck('address');
        $notify_party_name=NotifyParty::where('id',$notify_party_id)->pluck('name');
        $shipping_mark=NotifyParty::where('id',$notify_party_id)->pluck('shipping_mark'); 
        $ci_note=explode(",",$sale_contract->ci_note);
        $new_total_amount=explode(".",$total_amount);
        $new_total_amount1=$new_total_amount['0'];
        $new_total_amount1=$this->decimalToWordConvert($new_total_amount1);
        if(!empty($new_total_amount['1'])){

         $new_total_amount2=$new_total_amount['1'];
         $new_total_amount2=$this->decimalToWordConvert($new_total_amount2);

        }else{

         $new_total_amount2="";   

        } 

        return view("sale_contract.gt_bill",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('lc_number', $ci_note['0'])
              ->with('total_amount', $total_amount)
              ->with('obj',$this)
              ->with('notify_party_address', $notify_party_address['0'])
              ->with('notify_party_name',$notify_party_name['0'])
              ->with('new_total_amount1', $new_total_amount1)
              ->with('new_total_amount2', $new_total_amount2)
              ->with('shipping_mark',$shipping_mark['0']);





    }

public function forBankLc($id){

    $total_amount=0; 
    $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
    $sale_contract = SaleContract::find($id);
    $ci_note=explode(",",$sale_contract->ci_note);
    if(!empty($ci_note['0'])){

        $lc_number=$ci_note['0'];

    }else{

        $lc_number="";
    }

    if(!empty($ci_note['1'])){

        $lc_date=$ci_note['1'];

    }else{

        $lc_date="";
    }

    foreach ($sale_contract_details as $key => $value) {

        $total_amount=$total_amount+$value->total_amount_party;   
                        
    }
    return view("sale_contract.for_bank_lc",compact("sale_contract"))
            ->with('sale_contract_details',$sale_contract_details)
            ->with('obj',$this)
            ->with('lc_number', $lc_number)
            ->with('lc_date', $lc_date)
            ->with('total_amount', $total_amount);
        
}

public function appForARV($id){

    $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight',
                                'ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn',
                                'importers.name as importer_name','importers.address as importer_address',
                                'notify_parties.name as notify_party_name','notify_parties.address as notify_party_address',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount_party) AS total_party_amount'))
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->join('importers','importers.id','sale_contracts.importer_id')
                            ->join('notify_parties','notify_parties.id','sale_contracts.notify_pary_id')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                            ->orderBy('sale_contract_details.id')
                            ->get();



    $sale_contract = SaleContract::find($id); 
    $total_amount=0;
    foreach ($sale_contract_details as $key => $value) {
        
        $total_amount=$value->total_party_amount;

    } 

    $total_amount=$total_amount+$sale_contract->desk_freight_cost;
    $account_number=CompanyBank::where('company_id',$sale_contract->company_id)->where('bank_id',$sale_contract->bank_id)->value('account_number');
    return view("sale_contract.app_for_arv",compact("sale_contract"))
            ->with('sale_contract_details',$sale_contract_details)
            ->with('obj',$this)
            ->with('total_amount', $total_amount)
            ->with('account_number',$account_number);
        
}



private function decimalToWordConvert($num){
        
    $num    = ( string ) ( ( int ) $num );
    if( ( int ) ( $num ) && ctype_digit( $num ) )
    {
        $words  = array( );
       
        $num    = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );
       
        $list1  = array('','one','two','three','four','five','six','seven',
            'eight','nine','ten','eleven','twelve','thirteen','fourteen',
            'fifteen','sixteen','seventeen','eighteen','nineteen');
       
        $list2  = array('','ten','twenty','thirty','forty','fifty','sixty',
            'seventy','eighty','ninety','hundred');
       
        $list3  = array('','thousand','million','billion','trillion',
            'quadrillion','quintillion','sextillion','septillion',
            'octillion','nonillion','decillion','undecillion',
            'duodecillion','tredecillion','quattuordecillion',
            'quindecillion','sexdecillion','septendecillion',
            'octodecillion','novemdecillion','vigintillion');
       
        $num_length = strlen( $num );
        $levels = ( int ) ( ( $num_length + 2 ) / 3 );
        $max_length = $levels * 3;
        $num    = substr( '00'.$num , -$max_length );
        $num_levels = str_split( $num , 3 );
       
        foreach( $num_levels as $num_part )
        {
            $levels--;
            $hundreds   = ( int ) ( $num_part / 100 );
            $hundreds   = ( $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '' );
            $tens       = ( int ) ( $num_part % 100 );
            $singles    = '';
           
            if( $tens < 20 ) { $tens = ( $tens ? ' ' . $list1[$tens] . ' ' : '' ); } else { $tens = ( int ) ( $tens / 10 ); $tens = ' ' . $list2[$tens] . ' '; $singles = ( int ) ( $num_part % 10 ); $singles = ' ' . $list1[$singles] . ' '; } $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' ); } $commas = count( $words ); if( $commas > 1 )
        {
            $commas = $commas - 1;
        }
       
        $words  = implode( ', ' , $words );
       
        //Some Finishing Touch
        //Replacing multiples of spaces with one space
        $words  = trim( str_replace( ' ,' , ',' , ucwords( $words )  ) , ', ' );  
        return $words;
    }
    else if( ! ( ( int ) $num ) )
    {
        return 'Zero';
    }
    return '';
    }

    public function cfrCertificate(Request $request, $id){

        $total_carton=0;
        $total_amount=0;
        $company_name='';
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','companies.name as company_name',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq')
                                )
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->join('companies', 'companies.id','sale_contracts.company_id')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                            ->orderBy('sale_contract_details.id')
                            ->get();
        $sale_contract = SaleContract::find($id);
        foreach ($sale_contract_details as $key => $value) {
            
            $total_amount=$value->total_amount;
            $total_carton=$total_carton+$value->ctn;
            $company_name=$value->company_name;
        } 
        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");
        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        }

         

        return view("sale_contract.ci_cfr_certificate",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('total_amount', $total_amount)
              ->with('ctn', $total_carton)
              ->with('total_net_weight',$total_net_weight)
              ->with('company_name', $company_name);


    }
    
     public function cfrCertificateInd(Request $request, $id){

        $total_carton=0;
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn','companies.name as company_name',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq')
                                )
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->join('companies', 'companies.id','sale_contracts.company_id')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                            ->orderBy('sale_contract_details.id')
                            ->get();
        $sale_contract = SaleContract::find($id);
        foreach ($sale_contract_details as $key => $value) {
            
            $total_amount=$value->total_amount;
            $total_carton=$total_carton+$value->ctn;
            $company_name=$value->company_name;
        } 
        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");
        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        }

        return view("sale_contract.ci_cfr_certificate_ind",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('total_amount', $total_amount)
              ->with('ctn', $total_carton)
              ->with('total_net_weight',$total_net_weight)
              ->with('company_name', $company_name);


    }


    public function ci_packaging($id){

        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                            ->select('sale_contract_details.ci_item_name','sale_contract_details.hs_code','ci_items.duplicate_name','ci_items.p_net_weight','ci_items.ci_factor',
                            DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                            DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                            DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                            DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.ccq) AS ccq')
                            )
                         ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                         ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                         ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.hs_code')
                         ->orderBy('sale_contract_details.id')
                         ->get();
        $sale_contract = SaleContract::find($id);
        $nocs_array=$this->create_nocs($sale_contract_details);  
        return view("sale_contract.ci_packaging",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('obj',$this)->with('nocs_array', $nocs_array);
         

    }

    public function ci_packaging_not_merge($id){

        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get();
        return view("sale_contract.ci_packaging_not_merge",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('obj',$this);

    }

    public function desk_invoice($id){

        $sale_contract = SaleContract::find($id);
        $insurance_charge=$sale_contract->insurance_charge;
        $pallet_charge=$sale_contract->pallet_charge;
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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        return view("sale_contract.desk_invoice",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('factory_address', $factory_address)
               ->with('insurance_charge', $insurance_charge)
               ->with('pallet_charge', $pallet_charge);
               
    }

    public function desk_invoice_pad($id){

        $sale_contract = SaleContract::find($id);
        $insurance_charge=$sale_contract->insurance_charge;
        $pallet_charge=$sale_contract->pallet_charge;
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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){

            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        }
        return view("sale_contract.pad.desk.desk_com_inv",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('factory_address', $factory_address)
               ->with('insurance_charge', $insurance_charge)
               ->with('signatureImg',$signatureImg)
               ->with('pallet_charge', $pallet_charge);
               
    }

    public function desk_invoice_maly($id){
        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        return view("sale_contract.desk_invoice_maly",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details);
    }

    public function desk_invoice_pad_maly($id){

        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        $signatureImg="";
        $company_id=$sale_contract->company_id;
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){
       
            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        }
        return view("sale_contract.pad.maly.desk_com_inv",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('signatureImg',$signatureImg);

    }


    public function desk_sale_contract($id){

        $sale_contract = SaleContract::find($id);
        $insurance_charge=$sale_contract->insurance_charge;
        $pallet_charge=$sale_contract->pallet_charge;
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
        
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        if(!empty($insurance_charge) && !empty($pallet_charge)){

            Session::flash("danger", "Insurance & Pallet Is Not Allow Same Sale Contact..!!");
            return redirect()->back();
        }
        return view("sale_contract.desk_sale_contract",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('factory_address', $factory_address)
               ->with('insurance_charge', $insurance_charge)
               ->with('pallet_charge', $pallet_charge);

    }

    public function desk_sale_contract_cbm($id){

        $sale_contract = SaleContract::find($id);
        $insurance_charge=$sale_contract->insurance_charge;
        $pallet_charge=$sale_contract->pallet_charge;
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
        
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        if(!empty($insurance_charge) && !empty($pallet_charge)){

            Session::flash("danger", "Insurance & Pallet Is Not Allow Same Sale Contact..!!");
            return redirect()->back();
        }
        return view("sale_contract.desk_sale_contract_cbm",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('factory_address', $factory_address)
               ->with('insurance_charge', $insurance_charge)
               ->with('pallet_charge', $pallet_charge);

    }



    public function desk_sale_contract_maly($id){

        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        return view("sale_contract.desk_sale_contract_maly",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details);
    }

    public function deskSCPadMaly($id){

        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $signatureImg="";
        $company_id=$sale_contract->company_id;
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){
       
            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        }
        return view("sale_contract.pad.maly.desk_sale_contract",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('signatureImg',$signatureImg);
    }

    

    public function desk_sale_contract_ind($id){

        $sale_contract = SaleContract::find($id);
        $insurance_charge=0;
        $pallet_charge=0;
        if($sale_contract->insurance_charge){

            $insurance_charge=$sale_contract->insurance_charge;
        }
        if($sale_contract->pallet_charge){

            $pallet_charge=$sale_contract->pallet_charge;
        }
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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        if(!empty($insurance_charge) && !empty($pallet_charge)){

            Session::flash("danger", "Insurance & Pallet Is Not Allow Same Sale Contact..!!");
            return redirect()->back();
        }
        $currency_type=SaleContract::where('id',$id)->first(['currency_id']) ; 
        $exchange_rate='';
        if($currency_type->currency_id!=1){

            if(ScCurrencyHistory::where('sale_contract_id', $id)->count()!=0){
           
                // $scRateHistroy=ScCurrencyHistory::where('sale_contract_id',$id)->where('currency_id',$currency_type->currency_id)->orderBy('id','ASC')->first();
                // $exchange_rate=$scRateHistroy->rate;
                 $exchange_rate=1;

            }else{

                $exchange_rate=1;
            }

        }else{

            $exchange_rate=1;

        }

        return view("sale_contract.ind.sales_contact",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('factory_address', $factory_address)
               ->with('insurance_charge', $insurance_charge)
               ->with('pallet_charge', $pallet_charge)
               ->with('exchange_rate',$exchange_rate);

    }

    public function desk_sc_ind_pad($id){

        $sale_contract = SaleContract::find($id);
        $insurance_charge=0;
        $pallet_charge=0;
        if($sale_contract->insurance_charge){

            $insurance_charge=$sale_contract->insurance_charge;
        }
        if($sale_contract->pallet_charge){

            $pallet_charge=$sale_contract->pallet_charge;
        }
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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        if(!empty($insurance_charge) && !empty($pallet_charge)){

            Session::flash("danger", "Insurance & Pallet Is Not Allow Same Sale Contact..!!");
            return redirect()->back();
        }
        $currency_type=SaleContract::where('id',$id)->first(['currency_id']) ; 
        $exchange_rate='';
        if($currency_type->currency_id!=1){

            if(ScCurrencyHistory::where('sale_contract_id', $id)->count()!=0){
           
                $scRateHistroy=ScCurrencyHistory::where('sale_contract_id',$id)->where('currency_id',$currency_type->currency_id)->orderBy('id','ASC')->first();
                $exchange_rate=$scRateHistroy->rate;

            }else{

                $exchange_rate=1;
            }

        }else{

            $exchange_rate=1;

        }

        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){
       
            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        }
    
        return view("sale_contract.ind.sc_pad_report",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('factory_address', $factory_address)
               ->with('insurance_charge', $insurance_charge)
               ->with('pallet_charge', $pallet_charge)
               ->with('signatureImg',$signatureImg)
               ->with('exchange_rate',$exchange_rate);

    }


    public function desk_invoice_ind($id){

        $sale_contract = SaleContract::findOrFail($id);
        $pallet_charge=0;
        $insurance_charge=0;
        if($sale_contract->insurance_charge){

            $insurance_charge=$sale_contract->insurance_charge;
        }
        if($sale_contract->pallet_charge){

            $pallet_charge=$sale_contract->pallet_charge;
        }
        $company_id=$sale_contract->company_id;
        $factory_address_type_id=$sale_contract->factory_address_type;
        $companyDetails=DB::table('companies')
            ->where('id', $company_id)
            ->get();
        foreach($companyDetails as $key => $value) {
           
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

        $freight_charge_india=$sale_contract->freight_charge_india;
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.rate_per_ctn','sale_contract_details.desk_item_name',
                                'notify_party_items.shelf_life','sale_contract_details.ctn','sale_contract_details.hs_code','sale_contract_details.hs_code_2','sale_contract_details.ctn',
                                'sale_contract_details.pcs_in_ctn','sale_contracts.india_mfg_setup_date','ci_items.mrp_rs','sale_contract_details.rate_per_ctn_for_party','sale_contract_details.total_amount_party',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq'),
                                DB::Raw('SUM(sale_contract_details.rate_per_ctn_for_acc + sale_contract_details.per_ctn_freight) AS ci_item_rate'))
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->join('notify_party_items', function ($join) {

                                $join->on('notify_party_items.ci_item_id', '=', 'ci_items.id')
                                     ->on('notify_party_items.notify_party_id', '=', 'sale_contracts.notify_pary_id');
                            })
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.rate_per_ctn','notify_party_items.desk_item_name')
                            ->orderBy('sale_contract_details.id')
                            ->get();

        $sc_id=$sale_contract->id; 
        $result=JobOrderMaster::where('sale_contract_id', $id)->first(['mfg_date','best_before']);
        if(!is_null($result)){
           
           $best_before=$result->best_before;
           $mfg_date=$result->mfg_date;

        }else{

          $best_before="";
          $mfg_date="";
          
        }
        $lot_number=$sale_contract->lot_number;
        $currency_type=SaleContract::where('id',$id)->first(['currency_id']) ; 
        $exchange_rate='';
        if($currency_type->currency_id!=1){

            if(ScCurrencyHistory::where('sale_contract_id', $id)->count()!=0){
           
                $scRateHistroy=ScCurrencyHistory::where('sale_contract_id',$id)->where('currency_id',$currency_type->currency_id)->orderBy('id','ASC')->first();
                $exchange_rate=$scRateHistroy->rate;

            }else{

                $exchange_rate=1;
            }

        }else{

            $exchange_rate=1;

        }

        return view("sale_contract.ind.desk_com_inv",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('factory_address', $factory_address)
               ->with('insurance_charge', $insurance_charge)
               ->with('pallet_charge', $pallet_charge)
               ->with('freight_charge_india',$freight_charge_india)
               ->with("obj" ,$this)
               ->with('best_before', $best_before)
               ->with('lot_number',$lot_number)
               ->with('mfg_date', $mfg_date)
               ->with('exchange_rate',$exchange_rate);

    }

    public function desk_invoice_ind_pad($id){

        $sale_contract = SaleContract::findOrFail($id);
        $pallet_charge=0;
        $insurance_charge=0;
        if($sale_contract->insurance_charge){

            $insurance_charge=$sale_contract->insurance_charge;
        }
        if($sale_contract->pallet_charge){

            $pallet_charge=$sale_contract->pallet_charge;
        }
        $company_id=$sale_contract->company_id;
        $factory_address_type_id=$sale_contract->factory_address_type;
        $companyDetails=DB::table('companies')
            ->where('id', $company_id)
            ->get();
        foreach($companyDetails as $key => $value) {
           
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

        $freight_charge_india=$sale_contract->freight_charge_india;
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.rate_per_ctn','sale_contract_details.desk_item_name',
                                'notify_party_items.shelf_life','sale_contract_details.ctn','sale_contract_details.hs_code','sale_contract_details.hs_code_2','sale_contract_details.ctn',
                                'sale_contract_details.pcs_in_ctn','sale_contracts.india_mfg_setup_date','ci_items.mrp_rs','sale_contract_details.rate_per_ctn_for_party','sale_contract_details.total_amount_party',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq'),
                                DB::Raw('SUM(sale_contract_details.rate_per_ctn_for_acc + sale_contract_details.per_ctn_freight) AS ci_item_rate'))
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->join('notify_party_items', function ($join) {

                                $join->on('notify_party_items.ci_item_id', '=', 'ci_items.id')
                                     ->on('notify_party_items.notify_party_id', '=', 'sale_contracts.notify_pary_id');
                            })
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.rate_per_ctn','notify_party_items.desk_item_name')
                            ->orderBy('sale_contract_details.id')
                            ->get();

        $sc_id=$sale_contract->id; 
        $result=JobOrderMaster::where('sale_contract_id', $id)->first(['mfg_date','best_before']);
        if(!is_null($result)){
           
           $best_before=$result->best_before;
           $mfg_date=$result->mfg_date;

        }else{

          $best_before="";
          $mfg_date="";
          
        }
        $lot_number=$sale_contract->lot_number;
        $currency_type=SaleContract::where('id',$id)->first(['currency_id']) ; 
        $exchange_rate='';
        if($currency_type->currency_id!=1){

            if(ScCurrencyHistory::where('sale_contract_id', $id)->count()!=0){
           
                $scRateHistroy=ScCurrencyHistory::where('sale_contract_id',$id)->where('currency_id',$currency_type->currency_id)->orderBy('id','ASC')->first();
                $exchange_rate=$scRateHistroy->rate;

            }else{

                $exchange_rate=1;
            }

        }else{

            $exchange_rate=1;

        }

        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){

            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        } 

        return view("sale_contract.ind.pad_com_inv",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('factory_address', $factory_address)
               ->with('insurance_charge', $insurance_charge)
               ->with('pallet_charge', $pallet_charge)
               ->with('freight_charge_india',$freight_charge_india)
               ->with("obj" ,$this)
               ->with('best_before', $best_before)
               ->with('lot_number',$lot_number)
               ->with('mfg_date', $mfg_date)
               ->with('signatureImg',$signatureImg)
               ->with('exchange_rate',$exchange_rate);

    }

    public function bestBeforeNumberToWord($num){

        $ones = array(
        0 =>"CENT",
        1 => "ONE",
        2 => "TWO",
        3 => "THREE",
        4 => "FOUR",
        5 => "FIVE",
        6 => "SIX",
        7 => "SEVEN",
        8 => "EIGHT",
        9 => "NINE",
        10 => "TEN",
        11 => "ELEVEN",
        12 => "TWELVE",
        13 => "THIRTEEN",
        14 => "FOURTEEN",
        15 => "FIFTEEN",
        16 => "SIXTEEN",
        17 => "SEVENTEEN",
        18 => "EIGHTEEN",
        19 => "NINETEEN",
        "014" => "FOURTEEN"
        );
        $tens = array( 
        0 => "CENT",
        1 => "TEN",
        2 => "TWENTY",
        3 => "THIRTY", 
        4 => "FORTY", 
        5 => "FIFTY", 
        6 => "SIXTY", 
        7 => "SEVENTY", 
        8 => "EIGHTY", 
        9 => "NINETY" 
        ); 
        $hundreds = array( 
        "HUNDRED", 
        "THOUSAND", 
        "MILLION", 
        "BILLION", 
        "TRILLION", 
        "QUARDRILLION" 
        ); /*limit t quadrillion */
        $num = number_format($num,2,".",","); 
        $num_arr = explode(".",$num); 
        $wholenum = $num_arr[0]; 
        $decnum = $num_arr[1]; 
        $whole_arr = array_reverse(explode(",",$wholenum)); 
        krsort($whole_arr,1); 
        $rettxt = ""; 
        foreach($whole_arr as $key => $i){
            
        while(substr($i,0,1)=="0")
                $i=substr($i,1,5);
        if($i < 20){ 
         
        try {
            
           if(isset($ones[$i]))
           {
              $rettxt .= $ones[$i];  
           }

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
         
        }elseif($i < 100){ 
        if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
        if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
        }else{ 
        if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
        if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
        if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
        } 
        if($key > 0){ 
        $rettxt .= " ".$hundreds[$key]." "; 
        }
        } 
        if($decnum > 0){
        $rettxt .= " and ";
        if($decnum < 20){
        $rettxt .= $ones[$decnum];
        }elseif($decnum < 100){
        $rettxt .= $tens[substr($decnum,0,1)];
        $rettxt .= " ".$ones[substr($decnum,1,1)];
        }
        }
        return $rettxt;
         
    }

    public function desk_packaging($id){

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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){

            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        }
        $nocs_array=$this->create_nocs($sale_contract_details);                         
        return view("sale_contract.desk_packaging",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('nocs_array', $nocs_array)->with('factory_address', $factory_address);
    }

    public function desk_packing_cbm($id){

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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){

            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        }
        $nocs_array=$this->create_nocs($sale_contract_details);                         
        return view("sale_contract.desk_packaging_cbm",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('nocs_array', $nocs_array)->with('factory_address', $factory_address);
    }

    public function desk_packaging_with_code($id){

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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        $nocs_array=$this->create_nocs($sale_contract_details);                         
        return view("sale_contract.desk_packaging_with_code",compact("sale_contract"))
        ->with('sale_contract_details',$sale_contract_details)
        ->with('nocs_array', $nocs_array)
        ->with('factory_address', $factory_address);
    }

    public function desk_packing_pad($id){

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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){

            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        }
        $nocs_array=$this->create_nocs($sale_contract_details);                         
        return view("sale_contract.pad.desk.desk_packing",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
               ->with('nocs_array', $nocs_array)
               ->with('signatureImg',$signatureImg)
               ->with('factory_address', $factory_address);

    }



    public function desk_packaging_maly($id){

        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $nocs_array=$this->create_nocs($sale_contract_details);   
        return view("sale_contract.desk_packaging_maly",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('nocs_array', $nocs_array)
               ->with('obj',$this);
    }

    public function desk_packaging_pad_maly($id){

        $sale_contract = SaleContract::find($id); 
        $company_id=$sale_contract->company_id;
        $factory_address_type_id=$sale_contract->factory_address_type;
        $companyDetails=DB::table('companies')
            ->where('id', $company_id)
            ->get();
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $nocs_array=$this->create_nocs($sale_contract_details);   
        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){

            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        }
        return view("sale_contract.pad.maly.desk_packaging",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('nocs_array', $nocs_array)
               ->with('signatureImg',$signatureImg)
               ->with('obj',$this);
    }



    public function desk_packaging_2($id){

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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get();
        $containerDetails = SaleContractDetail::where('sale_contract_id',$id)->select('container_no','sale_contract_id')->groupBy('container_no')
                                               ->orderBy('id','desc')
                                               ->get();
        $total_amounts=\DB::select("SELECT SUM(sale_contract_details.ctn) AS ctn, SUM(sale_contract_details.net_weight_kg) AS net_weight_kg, SUM(gross_weight_kg) AS gross_weight_kg
            FROM sale_contract_details 
            WHERE sale_contract_id = '$id'");

        return view("sale_contract.desk_packaging_2",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('containerDetails', $containerDetails)
               ->with('total_amounts', $total_amounts)
               ->with('factory_address', $factory_address);


    }

    public function desk_packaging_3($id){

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
        return view("sale_contract.desk_packaging_3",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('nocs_array', $nocs_array)->with('factory_address', $factory_address);
    }


    public function desk_packaging_uk($id){
       
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
        return view("sale_contract.desk_packaging",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('nocs_array', $nocs_array)->with('factory_address', $factory_address);    


    }


    public function desk_com_inv_pack($id){

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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $nocs_array=$this->create_nocs($sale_contract_details);
        return view("sale_contract.desk_com_inv_pack",compact("sale_contract"))
                ->with('sale_contract_details',$sale_contract_details)
                ->with('nocs_array', $nocs_array)
                ->with('factory_address', $factory_address);
    }

    public function deskAllPad($id){
       
       
        $sale_contract = SaleContract::find($id);
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
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
        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->exists()){

            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        }
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $nocs_array=$this->create_nocs($sale_contract_details);
        return view("sale_contract.pad.desk.desk_all_pad",compact("sale_contract"))
                ->with('sale_contract_details',$sale_contract_details)
                ->with('total_net_weight', $total_net_weight)
                ->with('factory_address', $factory_address)
                ->with('signatureImg',$signatureImg)
                ->with('nocs_array',$nocs_array)
                ->with('obj',$this);


    }

    public function pi_report($id){
       
        $sale_contract = SaleContract::find($id);
        $insurance_charge=$sale_contract->insurance_charge;
        $pallet_charge=$sale_contract->pallet_charge;
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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        if(!empty($insurance_charge) && !empty($pallet_charge)){

            Session::flash("danger", "Insurance & Pallet Is Not Allow Same Sale Contact..!!");
            return redirect()->back();
        }
        return view("sale_contract.desk_pi_report",compact("sale_contract"))
               ->with('sale_contract_details',$sale_contract_details)
               ->with('factory_address', $factory_address)
               ->with('insurance_charge', $insurance_charge)
               ->with('pallet_charge', $pallet_charge);
    
    } 

    public function uae_report($id){
       
        $sale_contract = SaleContract::find($id);
        $insurance_charge=$sale_contract->insurance_charge;
        $pallet_charge=$sale_contract->pallet_charge;
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
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.duplicate_name','ci_items.ci_item_rate','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contracts.ci_note',
                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
            ->orderBy('sale_contract_details.id')
            ->get();
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        return view("sale_contract.uae_invoice",compact("sale_contract"))
        ->with('sale_contract_details',$sale_contract_details)
        ->with('total_net_weight', $total_net_weight)
        ->with('sale_contract',$sale_contract)
        ->with('insurance_charge', $insurance_charge)
        ->with('pallet_charge', $pallet_charge)
        ->with('obj',$this);
    
    } 

    public function uae_pad($id){
       
        $sale_contract = SaleContract::find($id);
        $insurance_charge=$sale_contract->insurance_charge;
        $pallet_charge=$sale_contract->pallet_charge;
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
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.duplicate_name','ci_items.ci_item_rate','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contracts.ci_note',
                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                DB::Raw('SUM(sale_contract_details.ccq) AS ccq'))
            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
            ->orderBy('sale_contract_details.id')
            ->get();
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        return view("sale_contract.uad_pad",compact("sale_contract"))
        ->with('sale_contract_details',$sale_contract_details)
        ->with('total_net_weight', $total_net_weight)
        ->with('sale_contract',$sale_contract)
        ->with('insurance_charge', $insurance_charge)
        ->with('pallet_charge', $pallet_charge)
        ->with('obj',$this);
    
    } 

    public function acc_sale_contract($id){

        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        return view("sale_contract.acc_sale_contract",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details);
    }

    public function acc_sale_contract_with_code($id){
        
        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        return view("sale_contract.acc_sale_contract_with_code",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details);
    }

    

    public function acc_com_invoice($id){

        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        return view("sale_contract.acc_com_invoice",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details);
    }

    public function acc_packaging($id){

        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        return view("sale_contract.acc_packaging",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details);
    }

    public function annesure($id){
        
        $results=DB::table('com_inv_masters')->where('sale_contact_id', $id)->get();
        if(count($results)>0){
          
            $comInvMaster=ComInvMaster::where('sale_contact_id', $id)->firstOrFail();
            $sale_contract = SaleContract::find($id);
            $bank_id=$sale_contract->bank_id; 
            $bank=Bank::findorfail($bank_id);
            $ciReportDateSetup=CiReportDateFormatSetup::where('sale_contact_id',$id)->first();
            if($ciReportDateSetup!=null){
                
                $status=$ciReportDateSetup->status;

            }else{

                $status='';
            }

            return view("sale_contract.report.annesure",compact("sale_contract"))
                   ->with('comInvMaster',$comInvMaster)
                   ->with('bank', $bank)
                   ->with('status',$status);
        }else{
           
           Session::flash("danger", "Please Update Com Inv First...!");
           return redirect()->back();

        }
       
    }

    public function annexure_c($id){
        
        $sale_contract=SaleContract::findorfail($id);
        $comInvMaster=ComInvMaster::where('sale_contact_id', $id)->first(['local_material','imported']); 
        $conversionRate=CICvr::select('rate')->first();
        $conversionRate=$conversionRate->rate;
        $query = "
            SELECT SUM(Value) AS totalValue
            FROM (
                SELECT (SUM(percentWeight) * rate) / ? AS Value
                FROM com_inv_recipe_details
                WHERE sale_contact_id = $id
                    AND source_type = 'Local'
                GROUP BY ingredient
            ) AS t1;
        ";
        $totalValue = DB::select(DB::raw($query), [$conversionRate]);
        $total_local_material = $totalValue[0]->totalValue;
        $local_material_as_per_kha=$comInvMaster->local_material;
        $material_diff=Round($local_material_as_per_kha-$total_local_material,6);
        $isPositive = ($material_diff >= 0) ? 1 : 0;
        $results=DB::select("CALL PROC_ANNEXURE_C(?,?,?,?,?)", [$total_local_material,$material_diff,$isPositive,$conversionRate,$id]);  
        return view('sale_contract.report.annexure_c')
               ->with('results',$results)
               ->with('comInvMaster',$comInvMaster)
                ->with('sale_contract',$sale_contract);

    }

    public function annexure_d($id){
         
        $sale_contract=SaleContract::findorfail($id);
        $comInvMaster=ComInvMaster::where('sale_contact_id', $id)->first(['local_material','imported','imp_update_value','net_fob']);
        $conversionRate=CICvr::select('rate')->first();
        $conversionRate=$conversionRate->rate;
        $query = "
            SELECT SUM(Value) AS totalValue
            FROM (
                SELECT (SUM(percentWeight) * rate) / ? AS Value
                FROM com_inv_recipe_details
                WHERE sale_contact_id = $id
                    AND source_type = 'Imported'
                GROUP BY ingredient
            ) AS t1;
        "; 
        
        $totalValue = DB::select(DB::raw($query), [$conversionRate]);
        $total_imported_material = $totalValue[0]->totalValue;

        $fourPercentImp=0;        
        if(!empty($comInvMaster->imp_update_value)){
                
            $fourPercentImp=$comInvMaster->imp_update_value;
            
        }

        $local_material=$comInvMaster->local_material;
        $local_material_with_four_percent=$local_material+$fourPercentImp;
        $imported_material_as_per_kha=round($comInvMaster->net_fob-$local_material_with_four_percent,2);        
        $material_diff=Round($imported_material_as_per_kha-$total_imported_material,6);
        $isPositive = ($material_diff >= 0) ? 1 : 0;
        $results=DB::select("CALL PROC_ANNEXURE_D(?,?,?,?,?)", [$total_imported_material,$material_diff,$isPositive,$conversionRate,$id]);
        return view('sale_contract.report.annexure_d')
              ->with('results',$results)
              ->with('imported_material_as_per_kha',$imported_material_as_per_kha)
              ->with('sale_contract',$sale_contract);

    }

    public function reportDateSetting($id,$party_id){
        
        $font_size="";
        $char_size="";
        if(!empty($results->status)){

           $check=$results->status;

        }else{

           $check='';
        
        }
        
        if(!empty($results->is_director)){

            $is_director=$results->is_director;

        }else{

            $is_director='';
        } 
        $name="";
        $address="";
        if(CiReportDateFormatSetup::where('sale_contact_id',$id)->exists()){
          
            $results=CiReportDateFormatSetup::where('sale_contact_id',$id)->first(['font_size','char_size','name','address']); 
            $font_size=$results->font_size;
            $char_size=$results->char_size;
            $name=$results->name;
            $address=$results->address;

        }else{
           
            $font_size='9px';
            $char_size='92px';   
            
        }

        $comInvMaster=ComInvMaster::where('sale_contact_id',$id)->first(['claim_percent']);
        $claimPercent=0;
        if(!is_null($comInvMaster)){

            $claimPercent=$comInvMaster->claim_percent;  

        }
        return view('sale_contract.report.date_formeting')
               ->with('id',$id)
               ->with('party_id',$party_id)
               ->with('check',$check)
               ->with('is_director',$is_director)
               ->with('font_size',$font_size)
               ->with('char_size',$char_size)
               ->with('name',$name)
               ->with('claimPercent',$claimPercent)
               ->with('address',$address);

    } 

    public function saveDateFormetingDetails(Request $request){

       
       $dateSetup=new CiReportDateFormatSetup();
       $result=CiReportDateFormatSetup::where('sale_contact_id',$request->sale_contact_id)->first();
       if($result==null){

           $dateSetup->sale_contact_id=$request->sale_contact_id;
           $dateSetup->status=$request->is_date;
           $dateSetup->is_director=$request->is_director;
           $dateSetup->font_size=$request->font_size;
           $dateSetup->char_size=$request->char_size;
           $dateSetup->name=$request->name;
           $dateSetup->address=$request->address;
           $dateSetup->save();
           return redirect()->back();
           
       }else{
          
          CiReportDateFormatSetup::where('sale_contact_id', $request->sale_contact_id)
           ->update([
               'status' => $request->is_date,
               'is_director' => $request->is_director,
               'font_size'=>$request->font_size,
               'char_size'=>$request->char_size,
               'name'=>$request->name,
               'address'=>$request->address
            ]);

            return redirect()->back(); 

       }
        
       

    }

    public function bapa_forwarding($id){
        
        $results=DB::table('com_inv_masters')->where('sale_contact_id', $id)->get();
        if(count($results)>0){
           
              $sale_contract = SaleContract::find($id); 
              $all_sum =  $this->getAllSum($id); 
              $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get();
              $company_id=$sale_contract->company_id;
              $company=Company::findorfail($company_id); 
              $comInvMaster=ComInvMaster::where('sale_contact_id', $id)->firstOrFail();
              $sci=SCI::where('sale_contract_id', $id)->firstOrFail();
              return view("sale_contract.report.bapa_forwarding",compact("sale_contract"))->with('all_sum',$all_sum)->with('sale_contract_details',$sale_contract_details)->with('company', $company)->with('comInvMaster',$comInvMaster)->with('sci',$sci);
           
        }else{
           
           Session::flash("danger", "Please Update Com Inv First...!");
           return redirect()->back();

        }  
        
    }

    

    public function cal_sheet($id){
       
        $results=DB::table('com_inv_masters')->where('sale_contact_id', $id)->get();
        if(count($results)>0){
          
          $comInvMaster=ComInvMaster::where('sale_contact_id', $id)->firstOrFail();
          $sci=SCI::where('sale_contract_id', $id)->firstOrFail();
          return view("sale_contract.report.cal_sheet",compact("sale_contract"))
                 ->with('comInvMaster',$comInvMaster)
                 ->with('sci', $sci);

        }else{
          
           Session::flash("danger", "Please Update Com Inv First...!");
           return redirect()->back();

        }
        
    }

    public function valueAdditionReport($id){
       
        
        $results=DB::table('com_inv_masters')->where('sale_contact_id', $id)->get();
        $sale_contract=SaleContract::where('id',$id)->first(['invoice_no']);
        if(count($results)>0){
          
          $comInvMaster=ComInvMaster::where('sale_contact_id', $id)->firstOrFail();
          if(!empty($comInvMaster->imp_update_value)){
                
            $fourPercentImp=$comInvMaster->imp_update_value;
            
          }else{
            
            $fourPercentImp=0;

          }
          $local_material=$comInvMaster->local_material;
          $local_material_with_four_percent=$local_material+$fourPercentImp;
          $sci=SCI::where('sale_contract_id', $id)->firstOrFail();
          $net_fob_value=round($comInvMaster->realise_value-($comInvMaster->freight_cost+$comInvMaster->non_eligible_item),2);
          $imported_value=round($comInvMaster->net_fob-$local_material_with_four_percent,2);
          $result=round((($net_fob_value-$imported_value)/$net_fob_value)*100,2);
          return view("sale_contract.report.value_addition",compact("sale_contract"))
                 ->with('comInvMaster',$comInvMaster)
                 ->with('sci', $sci)
                 ->with('imported_value',$imported_value)
                 ->with('net_fob_value',$net_fob_value)
                 ->with('result',$result);


        }else{
          
           Session::flash("danger", "Please Update Com Inv First...!");
           return redirect()->back();

        }
        
    }





    public function f_kha($id){
        
        $results=DB::table('com_inv_masters')->where('sale_contact_id', $id)->get();
        if(count($results)>0){
           
            $sale_contract = SaleContract::find($id); 
            $all_sum =  $this->getAllSum($id); 
            $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get();
            $comInvMaster=ComInvMaster::where('sale_contact_id', $id)->firstOrFail(); 
            $sciSingleRowDetails=SCI::where('sale_contract_id', $id)->firstOrFail();
            $proceeds_realization_date=$sciSingleRowDetails->proceeds_realization_date;
            $company_id=$sale_contract->company_id;
            $company=Company::findorfail($company_id);
            $sci=SCI::where('sale_contract_id', $id)->firstOrFail();
            $ciReportDateSetup=CiReportDateFormatSetup::where('sale_contact_id',$id)->first();
            if($ciReportDateSetup!=null){
                
                $status=$ciReportDateSetup->status;

            }else{

                $status='';
            }
            
            // $comInv=ComInvMaster::where('sale_contact_id', $id)->first(['imp_update_value']);

            if(!empty($comInvMaster->imp_update_value)){
                
                $fourPercentImp=$comInvMaster->imp_update_value;
                
            }else{
                
                $fourPercentImp=0;
            }

            $local_material=$comInvMaster->local_material;
            $local_material_with_four_percent=$local_material+$fourPercentImp;
            $showValue=round($comInvMaster->net_fob-$local_material_with_four_percent,2);
            return view("sale_contract.report.f_kha",compact("sale_contract"))->with('all_sum',$all_sum)->with('sale_contract_details',$sale_contract_details)->with('comInvMaster',$comInvMaster)->with('proceeds_realization_date',$proceeds_realization_date)->with('company',$company)->with('sci',$sci)
                ->with('status',$status)->with('showValue',$showValue);

        }else{
           
           Session::flash("danger", "Please Update Com Inv First...!");
           return redirect()->back();

        }
        
    }

    public function updateImpValue($id,$party_id){
       

       $impValue=ComInvMaster::where('sale_contact_id',$id)->first(['imp_update_value']);
       if(is_null($impValue)){
           
           $impValue=0;

       }else{

           $impValue=$impValue->imp_update_value;
       }

       return view('bapa_setup.update')
              ->with('id',$id)
              ->with('impValue',$impValue);

    }

    public function updateImp(Request $request){
        

       ComInvMaster::where('sale_contact_id', $request->sc_id)
       ->update([
           'imp_update_value' =>$request->update_percentage 
        ]);
        
       return redirect()->back(); 

    }

    public function f_kha_2($id){

        $results=DB::table('com_inv_masters')->where('sale_contact_id', $id)->get();
        if(count($results)>0){
           
           $sale_contract = SaleContract::find($id); 
           $all_sum =  $this->getAllSum($id); 
           $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get(); 
           $comInvMaster=ComInvMaster::where('sale_contact_id', $id)->firstOrFail(); 
           return view("sale_contract.report.f_kha_2",compact("sale_contract"))->with('all_sum',$all_sum)->with('sale_contract_details',$sale_contract_details)->with('comInvMaster', $comInvMaster);

        }else{

           Session::flash("danger", "Please Update Com Inv First...!");
           return redirect()->back();

        }  
        
    }
    public function forwarding($id){
        
        $results=DB::table('com_inv_masters')->where('sale_contact_id', $id)->get();
        if(count($results)>0){
           
            $sale_contract = SaleContract::find($id); 
            
            $all_sum =  $this->getAllSum($id); 
            $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get(); 
            $comInvMaster=ComInvMaster::where('sale_contact_id', $id)->firstOrFail();
            $bank_id=$sale_contract->bank_id; 
            $bank=Bank::findorfail($bank_id);
            $company_id=$sale_contract->company_id;
            $company=Company::findorfail($company_id);
            $ciReportDateSetup=CiReportDateFormatSetup::where('sale_contact_id',$id)->first();
            if($ciReportDateSetup!=null){
                
                $status=$ciReportDateSetup->status;

            }else{

                $status='';
            }

            return view("sale_contract.report.forwarding",compact("sale_contract")) ->with('all_sum',$all_sum)->with('sale_contract_details',$sale_contract_details)->with('comInvMaster', $comInvMaster)->with('bank', $bank)->with('company',$company)->with('status',$status);

        }else{

            Session::flash("danger", "Please Update Com Inv First...!");
            return redirect()->back();
        }
        
    }

    public function declaration($id){
        
        $results=DB::table('com_inv_masters')->where('sale_contact_id', $id)->get();
        if(count($results)>0){
           
            $sale_contract = SaleContract::find($id); 
            $all_sum =  $this->getAllSum($id); 
            $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get(); 
            $comInvMaster=ComInvMaster::where('sale_contact_id', $id)->firstOrFail();
            $bank_id=$sale_contract->bank_id; 
            $bank=Bank::findorfail($bank_id);
            $company_id=$sale_contract->company_id;
            $company=Company::findorfail($company_id);
            $ciReportDateSetup=CiReportDateFormatSetup::where('sale_contact_id',$id)->first();
            if($ciReportDateSetup!=null){
                
                $status=$ciReportDateSetup->status;
                $is_director=$ciReportDateSetup->is_director;

            }else{

                $status='';
                $is_director='';
            }
            return view("sale_contract.report.declaration",compact("sale_contract")) ->with('all_sum',$all_sum)->with('sale_contract_details',$sale_contract_details)->with('comInvMaster', $comInvMaster)->with('bank', $bank)->with('company',$company)->with('status',$status)->with('is_director',$is_director);

        }else{
           
           Session::flash("danger", "Please Update Com Inv First...!");
           return redirect()->back();

        } 
        
    }

    public function mcci($id){

        $sale_contract = SaleContract::find($id); 
        $all_sum =  $this->getAllSum($id);
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.duplicate_name','ci_items.ci_item_rate','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contract_details.total_amount_party',
                            DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                            DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                            DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                            DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.ccq) AS ccq'),
                            DB::Raw('SUM(sale_contract_details.total_amount_party) AS total_party_amount')
                            )
                         ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                         ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                         ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.total_amount_party')
                         ->orderBy('sale_contract_details.id')
                         ->get();

           
        $desk_freight_cost=$sale_contract->desk_freight_cost;
        $p_total_amount=0;
        foreach ($sale_contract_details as $key => $value) {
          
           $p_total_amount=$p_total_amount+$value->total_party_amount;

        }


        $total_amount_with_freight=$desk_freight_cost+$p_total_amount;

        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");

        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        } 

        $nocs_array=$this->create_nocs($sale_contract_details);
        $last_getting_nocs=end($nocs_array);
        $explode_array=explode("-",$last_getting_nocs); 
        $noce_value=$explode_array['1'];
        return view("sale_contract.report.mcci",compact("sale_contract")) ->with('all_sum',$all_sum)->with('obj',$this)->with('sale_contract_details',$sale_contract_details)->with('total_net_weight', $total_net_weight)->with('total_amount_with_freight',$total_amount_with_freight)->with('noce_value', $noce_value);
    }

    public function mcciLand($id){

        $sale_contract = SaleContract::find($id); 
        $all_sum =  $this->getAllSum($id);
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.duplicate_name','ci_items.ci_item_rate','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contract_details.total_amount_party',
                            DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                            DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                            DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                            DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.ccq) AS ccq'),
                            DB::Raw('SUM(sale_contract_details.total_amount_party) AS total_party_amount')
                            )
                         ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                         ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                         ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.total_amount_party')
                         ->orderBy('sale_contract_details.id')
                         ->get();

           
        $desk_freight_cost=$sale_contract->desk_freight_cost;
        $p_total_amount=0;
        foreach ($sale_contract_details as $key => $value) {
          
           $p_total_amount=$p_total_amount+$value->total_party_amount;

        }


        $total_amount_with_freight=$desk_freight_cost+$p_total_amount;

        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");

        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        } 

        $nocs_array=$this->create_nocs($sale_contract_details);
        $last_getting_nocs=end($nocs_array);
        $explode_array=explode("-",$last_getting_nocs); 
        $noce_value=$explode_array['1'];
        return view("sale_contract.report.mcci_land",compact("sale_contract")) ->with('all_sum',$all_sum)->with('obj',$this)->with('sale_contract_details',$sale_contract_details)->with('total_net_weight', $total_net_weight)->with('total_amount_with_freight',$total_amount_with_freight)->with('noce_value', $noce_value);


    }

    public function mcciLandIndia($id){

        $sale_contract = SaleContract::find($id); 
        $all_sum =  $this->getAllSum($id);
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.duplicate_name','ci_items.ci_item_rate','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contract_details.total_amount_party',
                            DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                            DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                            DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                            DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.ccq) AS ccq'),
                            DB::Raw('SUM(sale_contract_details.total_amount_party) AS total_party_amount')
                            )
                         ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                         ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                         ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.total_amount_party')
                         ->orderBy('sale_contract_details.id')
                         ->get();
           
        $desk_freight_cost=$sale_contract->desk_freight_cost;
        $p_total_amount=0;
        foreach ($sale_contract_details as $key => $value) {
          
           $p_total_amount=$p_total_amount+$value->total_party_amount;

        }

        $total_amount_with_freight=$desk_freight_cost+$p_total_amount;

        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");

        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        } 

        $nocs_array=$this->create_nocs($sale_contract_details);
        $last_getting_nocs=end($nocs_array);
        $explode_array=explode("-",$last_getting_nocs); 
        $noce_value=$explode_array['1'];
        $currency_type=SaleContract::where('id',$id)->first(['currency_id']);  
        if($currency_type->currency_id!=1){

            if(ScCurrencyHistory::where('sale_contract_id', $id)->count()!=0){
           
                $scRateHistroy=ScCurrencyHistory::where('sale_contract_id',$id)->where('currency_id',$currency_type->currency_id)->orderBy('id','ASC')->first();
                $exchange_rate=$scRateHistroy->rate;

            }else{

                $exchange_rate=1;
            }

        }else{

            $exchange_rate=1;

        }
        return view("sale_contract.ind.mcci_land_india",compact("sale_contract"))
                 ->with('all_sum',$all_sum)
                 ->with('obj',$this)
                 ->with('sale_contract_details',$sale_contract_details)
                 ->with('total_net_weight', $total_net_weight)
                 ->with('total_amount_with_freight',$total_amount_with_freight)
                 ->with('noce_value', $noce_value)
                 ->with('exchange_rate',$exchange_rate);


    }


    public function bci($id){

        $sale_contract = SaleContract::find($id); 
        $all_sum =  $this->getAllSum($id); 
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.duplicate_name','ci_items.ci_item_rate','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contract_details.total_amount_party',
                            DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                            DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                            DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                            DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.ccq) AS ccq'),
                            DB::Raw('SUM(sale_contract_details.total_amount_party) AS total_party_amount')
                            )
                         ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                         ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                         ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.total_amount_party')
                         ->orderBy('sale_contract_details.id')
                         ->get();
        $desk_freight_cost=$sale_contract->desk_freight_cost;
        $p_total_amount=0;
        foreach ($sale_contract_details as $key => $value) {
          
           $p_total_amount=$p_total_amount+$value->total_party_amount;

        }

        $total_amount_with_freight=$desk_freight_cost+$p_total_amount;                 
        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");
        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        }  

        $nocs_array=$this->create_nocs($sale_contract_details);
        $last_getting_nocs=end($nocs_array);
        $explode_array=explode("-",$last_getting_nocs); 
        $noce_value=$explode_array[1];

        return view("sale_contract.report.bci",compact("sale_contract"))
               ->with('all_sum',$all_sum)
               ->with('obj',$this)
               ->with('sale_contract_details',$sale_contract_details)
               ->with('total_net_weight', $total_net_weight)
               ->with('total_amount_with_freight',$total_amount_with_freight)
               ->with('noce_value', $noce_value);
    }

    public function ksa_bci($id){

        $sale_contract = SaleContract::find($id); 
        $all_sum =  $this->getAllSum($id); 
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.rate_per_ctn','notify_party_items.desk_item_name',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq'),
                                DB::Raw('SUM(sale_contract_details.rate_per_ctn_for_acc + sale_contract_details.per_ctn_freight) AS ci_item_rate'))
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->join('notify_party_items', function ($join) {

                                $join->on('notify_party_items.ci_item_id', '=', 'ci_items.id')
                                     ->on('notify_party_items.notify_party_id', '=', 'sale_contracts.notify_pary_id');
                            })
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.rate_per_ctn','notify_party_items.desk_item_name')
                            ->orderBy('sale_contract_details.id')
                            ->get();
        
      
        $nocs_array=$this->create_nocs($sale_contract_details);
        $last_getting_nocs=end($nocs_array);
        $explode_array=explode("-",$last_getting_nocs); 
        $noce_value=$explode_array[1];
        
        return view("sale_contract.ksa.ksa_bci",compact("sale_contract"))
               ->with('all_sum',$all_sum)
               ->with('obj',$this)
               ->with('sale_contract_details',$sale_contract_details)
               ->with('noce_value', $noce_value);


    }

    public function bci_india($id){

        $sale_contract = SaleContract::find($id); 
        $all_sum =  $this->getAllSum($id); 
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.duplicate_name','ci_items.ci_item_rate','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contract_details.total_amount_party',
                            DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                            DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                            DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                            DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.ccq) AS ccq'),
                            DB::Raw('SUM(sale_contract_details.total_amount_party) AS total_party_amount')
                            )
                         ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                         ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                         ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.total_amount_party')
                         ->orderBy('sale_contract_details.id')
                         ->get();
        $desk_freight_cost=$sale_contract->desk_freight_cost;
        $p_total_amount=0;
        foreach ($sale_contract_details as $key => $value) {
          
           $p_total_amount=$p_total_amount+$value->total_party_amount;

        }

        $total_amount_with_freight=$desk_freight_cost+$p_total_amount;                 
        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg FROM sale_contract_details
            WHERE sale_contract_details.sale_contract_id='$id'");
        foreach($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        }                  
        $nocs_array=$this->create_nocs($sale_contract_details);
        $last_getting_nocs=end($nocs_array);
        $explode_array=explode("-",$last_getting_nocs); 
        $noce_value=$explode_array[1];
        return view("sale_contract.report.bci_india",compact("sale_contract")) ->with('all_sum',$all_sum)->with('obj',$this)->with('sale_contract_details',$sale_contract_details)->with('total_net_weight', $total_net_weight)->with('total_amount_with_freight',$total_amount_with_freight)->with('noce_value', $noce_value);
    }

    public function landFreightInd($id){
        
        $sale_contract=SaleContract::findorfail($id);
        if($sale_contract->transport_agency_id!=null){
           
           $agency_id=$sale_contract->transport_agency_id;
           $agency=TransportAgency::findorfail($agency_id);

        }else{

            $agency=[];
        }


        $currency_type=SaleContract::where('id',$id)->first(['currency_id']);  

        if($currency_type->currency_id!=1){

            if(ScCurrencyHistory::where('sale_contract_id', $id)->count()!=0){
           
                $scRateHistroy=ScCurrencyHistory::where('sale_contract_id',$id)->where('currency_id',$currency_type->currency_id)->orderBy('id','ASC')->first();
                $exchange_rate=$scRateHistroy->rate;

            }else{

                $exchange_rate=1;
            }

        }else{

            $exchange_rate=1;

        }

        return view("sale_contract.ind.land_freight_ind",compact("sale_contract"))
            ->with('agency',$agency)
            ->with('exchange_rate',$exchange_rate);
 

    }

    public function arvIndiaReport($id){
        
       $sale_contract=SaleContract::findorfail($id);
       $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.total_amount_party',
                            DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                            DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                            DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                            DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                            DB::Raw('SUM(sale_contract_details.ccq) AS ccq'),
                            DB::Raw('SUM(sale_contract_details.total_amount_party) AS total_party_amount')
                            )
                         ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                         ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                         ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','sale_contract_details.total_amount_party')
                         ->orderBy('sale_contract_details.id')
                         ->get();

           
        $desk_freight_cost=$sale_contract->desk_freight_cost;
        $total_ctn=0;
        $p_total_amount=0;
        foreach ($sale_contract_details as $key => $value) {
          
           $p_total_amount=$p_total_amount+$value->total_party_amount;
           $total_ctn+=$value->ctn;

        }

        $salesContactdetails=SaleContractDetail::where('sale_contract_id',$id)->take(1)->first();
        $assignItemGroup=IndiaItemGorupAssign::where('india_item_id',$salesContactdetails->ci_item_id)->first();
        $group_name="";
        if(!is_null($assignItemGroup)){

          $india_item_group_name=ItemGroupIndia::where('id',$assignItemGroup->india_group_id)->first();  
          $group_name=$india_item_group_name->group_name;
        }

        $hs_code2=NotifyPartyItem::where('notify_party_id',$sale_contract->notify_pary_id)->where('ci_item_id',$salesContactdetails->ci_item_id)->value('hs_code2');
        
        $exp_no=$sale_contract->export_no;
        if($exp_no){

            $exp_number=(explode("/",$exp_no));
            $ad_code=substr($exp_number['0'],4);

        }else{

            $ad_code=''; 

        }
        $total_amount_with_freight=$desk_freight_cost+$p_total_amount;
        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$sale_contract->company_id)->exists()){
       
            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$sale_contract->company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        } 
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');	
        return view("sale_contract.ind.arv_india")
              ->with('sale_contract',$sale_contract)
              ->with('total_amount_with_freight',$total_amount_with_freight)
              ->with('salesContactdetails',$salesContactdetails)
              ->with('ad_code',$ad_code)
              ->with('total_ctn',$total_ctn)
              ->with('signatureImg',$signatureImg)
              ->with('total_net_weight',$total_net_weight)
              ->with('hs_code2',$hs_code2)
              ->with('group_name',$group_name);


    }

    public function appForCnf($id){

        $sale_contract=SaleContract::with('customStation')->findorfail($id); 
        $desk_freight_cost=$sale_contract->desk_freight_cost; 
        $all_sum =  $this->getAllSum($id);
        $total_value=$desk_freight_cost+$all_sum->total_amount_party;
        $total_net_weight=$all_sum->total_net_weight_kg;
        return view('sale_contract.ind.app_for_cnf')
              ->with('sale_contract',$sale_contract)  
              ->with('total_net_weight',$total_net_weight)   
              ->with('total_value',$total_value);    

    }

    public function customAuthorization($id){

        $sale_contract=SaleContract::with('customStation')->findorfail($id); 
        $desk_freight_cost=$sale_contract->desk_freight_cost; 
        $all_sum =  $this->getAllSum($id);
        $total_value=$desk_freight_cost+$all_sum->total_amount_party;
        $total_net_weight=$all_sum->total_net_weight_kg;
        return view('sale_contract.custom_authorization')
                ->with('sale_contract',$sale_contract)  
                ->with('total_net_weight',$total_net_weight)   
                ->with('total_value',$total_value);    

    }


    public function arvReportForAll($id){

        $total_carton=0;
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight',
                                'ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn',
                                'importers.name as importer_name','importers.address as importer_address',
                                'notify_parties.name as notify_party_name','notify_parties.address as notify_party_address',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq')
                                )
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->join('importers','importers.id','sale_contracts.importer_id')
                            ->join('notify_parties','notify_parties.id','sale_contracts.notify_pary_id')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                            ->orderBy('sale_contract_details.id')
                            ->get();

        $sale_contract = SaleContract::find($id); 
        foreach ($sale_contract_details as $key => $value) {
            
            $total_amount=$value->total_amount;
            $total_carton=$total_carton+$value->ctn;
            $importer_name=$value->importer_name;
            $importer_address=$value->importer_address;
            $notify_party_name=$value->notify_party_name;
            $notify_party_address=$value->notify_party_address;

        } 
 
            
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        $total_ctn_number = SaleContractDetail::where('sale_contract_id',$id)->sum('ctn');
 
        $salesContactdetails=SaleContractDetail::where('sale_contract_id',$id)->take(1)->first();
         $assignItemGroup=IndiaItemGorupAssign::where('india_item_id',$salesContactdetails->ci_item_id)->first();
        $group_name="";
        if(!is_null($assignItemGroup)){

            $india_item_group_name=ItemGroupIndia::where('id',$assignItemGroup->india_group_id)->first();  
            $group_name=$india_item_group_name->group_name;

        }
        
        $exp_no=$sale_contract->export_no;
        if($exp_no){

            $exp_number=(explode("/",$exp_no));
            $ad_code=substr($exp_number['0'],4);

        }else{

            $ad_code=''; 

        }

        $signatureImg="";
        if(UserSignature::where('user_id',Auth::user()->id)->where('company_id',$sale_contract->company_id)->exists()){
       
            $singnature=UserSignature::where('user_id',Auth::user()->id)->where('company_id',$sale_contract->company_id)->first(['image_url']);
            $signatureImg=$singnature->image_url;

        } 

        return view("sale_contract.arv_report_all")
            ->with('sale_contract',$sale_contract)
            ->with('sale_contract_details',$sale_contract_details)
            ->with('salesContactdetails',$salesContactdetails)
            ->with('ad_code',$ad_code)
            ->with('total_amount', $total_amount)
            ->with('ctn', $total_carton)
            ->with('total_net_weight',$total_net_weight)
            ->with('total_ctn_number',$total_ctn_number)
            ->with('group_name',$group_name)
            ->with('signatureImg',$signatureImg);
 
 
    }

    public function b_certi($id){
          
        $sale_contract = SaleContract::find($id);
        $importer_id=$sale_contract->importer_id;
        $notify_party_id=$sale_contract->notify_pary_id;
        $importers=Importer::where('id',$importer_id)->first();
        $address_replace_status=$sale_contract->address_replace;
        $lc_number=SCI::where('sale_contract_id',$id)->first(['lc_number']);
        $importer_name="";
        $importer_address="";
        if(CiReportDateFormatSetup::where('sale_contact_id',$id)->exists()){
             
            $formatSetup=CiReportDateFormatSetup::where('sale_contact_id',$id)->first(['name','address']);
            $importer_name=$formatSetup->name;
            $importer_address=$formatSetup->address;

        }else{
            
            if($importers->name=="N/A"){
           
                // $notifyParty=NotifyParty::where('id',$notify_party_id)->first();
                $importer_name=$sale_contract->party_name;
                $importer_address=$sale_contract->party_address;
    
            }elseif($address_replace_status){
                
                // $notifyParty=NotifyParty::where('id',$notify_party_id)->first();
                $importer_name=$sale_contract->party_name;
                $importer_address=$sale_contract->party_address; 
    
            }else{
    
                $importer_name=$sale_contract->importer_name;
                $importer_address=$sale_contract->importer_address;
     
            }

        }
        
        $all_sum =  $this->getAllSum($id);  
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get(); 
        $comInvMaster=ComInvMaster::where('sale_contact_id', $id)->firstOrFail(); 
        $sciSingleRowDetails=SCI::where('sale_contract_id', $id)->firstOrFail();
        $proceeds_realization_date=$sciSingleRowDetails->proceeds_realization_date;
        $company_id=$sale_contract->company_id;
        $company=Company::findorfail($company_id);
        $sci=SCI::where('sale_contract_id','=',$id)->firstOrFail();
        $bankImporter=BankImporter::findorfail($sale_contract->bank_importer_id);
        $results=DB::select("SELECT DISTINCT item_groups.short_name as item_group_name,count(sale_contract_details.ci_item_id) as count
            FROM sale_contract_details
            JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
            JOIN item_groups ON item_groups.id=ci_items.item_group_id
            WHERE sale_contract_details.sale_contract_id = $id AND item_groups.id!=236
            GROUP BY item_groups.short_name
            ORDER BY count(sale_contract_details.ci_item_id) DESC");

        $number_of_groups=count($results);
        $concat_groups="";
        $count_char=0;
        $group_array="";
        $font_style="";
        $char_size=0;
        if(CiReportDateFormatSetup::where('sale_contact_id',$id)->exists()){
               
           $charSetup=CiReportDateFormatSetup::where('sale_contact_id',$id)->first(['font_size','char_size']);
           $char_size=$charSetup->char_size; 
           foreach($results as $key => $value) {
           
                if($concat_groups==""){ 
                
                    $concat_groups=$value->item_group_name; 
                    $group_array=$value->item_group_name;

                }else{

                    $concat_groups=$concat_groups.','.$value->item_group_name;
                    if(strlen($concat_groups) <= $char_size){
                    
                        $group_array=$group_array.','.$value->item_group_name; 

                    }   
                }

           }

           $group_array=substr($group_array,0);
           $font_style=$charSetup->font_size;

        }else{

            $char_size=92; 
            foreach($results as $key => $value) {
           
                if($concat_groups==""){ 
                
                    $concat_groups=$value->item_group_name; 
                    $group_array=$value->item_group_name;

                }else{

                    $concat_groups=$concat_groups.','.$value->item_group_name;
                    if(strlen($concat_groups) <= $char_size){
                    
                        $group_array=$group_array.','.$value->item_group_name; 

                    }   
                }

            }

            $group_array=substr($group_array,0);
            $font_style='9px';

        }

        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");
        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        }

        try { 

               $freight_cost=$sale_contract->freight_cost;
               $per_unit_freight=$freight_cost/$total_net_weight;
                          
            }catch (Exception $e) {


        }  

        $scDetails=DB::select("SELECT
                ci_items.ci_factor,
                sale_contract_details.ctn,
                sale_contract_details.rate_per_ctn,
                sale_contract_details.net_weight_kg
            FROM
                sale_contracts
            JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
            JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
            JOIN item_groups ON item_groups.id = ci_items.item_group_id
            WHERE
                sale_contracts.id =$id and item_groups.id!=236");

        $total_amount=0;

        foreach($scDetails as $result){

            try { 

                if($result->ci_factor!=0){

                    $per_net_weight_kg_fright=$per_unit_freight*$result->net_weight_kg;
                    $caton_fright=$per_net_weight_kg_fright/$result->ctn;
                    $carton_fright_pl_rate=round($caton_fright+$result->rate_per_ctn, 3);
                    
                }else{

                    $carton_fright_pl_rate="0";

                }

            }catch (Exception $e){


            } 

            $total_amount=$total_amount+round($carton_fright_pl_rate*$result->ctn,2);

        }

        return view("sale_contract.report.b_certi",compact("sale_contract"))
            ->with('all_sum',$all_sum)->with('obj',$this)
            ->with('sale_contract_details',$sale_contract_details)
            ->with('comInvMaster',$comInvMaster)
            ->with('proceeds_realization_date', $proceeds_realization_date)
            ->with('company', $company)
            ->with('sci',$sci)
            ->with('group_array', $group_array)
            ->with('bankImporter',$bankImporter)
            ->with('importer_name',$importer_name)
            ->with('importer_address',$importer_address)
            ->with('total_amount',$total_amount)
            ->with('lenght',$number_of_groups)
            ->with('lc_number',$lc_number->lc_number)
            ->with('font_style',$font_style);
    }

    public function safta($id){

        $sale_contract = SaleContract::find($id); 
        $all_sum =  $this->getAllSum($id); 
        $sale_contract_details=SaleContractDetail::where('sale_contract_id',$id)
               ->where('ci_items.status',1)
               ->Join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
               ->Join('item_group_assign_india','item_group_assign_india.india_item_id','sale_contract_details.ci_item_id')
               ->Join('item_group_india','item_group_india.id','item_group_assign_india.india_group_id')
               ->orderBy('sale_contract_details.id','ASC')
               ->select('sale_contract_details.id','sale_contract_details.ctn','sale_contract_details.desk_item_name','item_group_india.group_name','item_group_assign_india.hs_code2 as short_name','sale_contract_details.safta_percentage','sale_contract_details.hs_code','sale_contract_details.hs_code_2')
               ->get();

        $nw_status=count($sale_contract_details);       
        $total_net_weight=\DB::table("sale_contract_details")->where('sale_contract_id',$id)->sum('net_weight_kg');
        $total_gross_weight=\DB::table("sale_contract_details")->where('sale_contract_id',$id)->sum('gross_weight_kg');
        $nocs_array=$this->create_nocs($sale_contract_details);
        $total_amount = SaleContractDetail::where('sale_contract_id',$id)->sum('total_amount_party');
        $total_carton = SaleContractDetail::where('sale_contract_id',$id)->sum('ctn');
        $freight_charge=$sale_contract->freight_charge_india;
        if($freight_charge=='0'){

           $freight_charge=0;

        }
        $lot_number=$sale_contract->lot_number;
        $result=JobOrderMaster::where('sale_contract_id', $id)->first(['mfg_date','best_before']);
        if(!empty($result)){
           
           $mfg_date=$result->mfg_date;

        }else{

          $mfg_date="";
              
        }

        $shiping_mark_input=$sale_contract->shipping_mark_india;
        $shiping_mark=explode(",",$shiping_mark_input);
        $shiping_mark_lenght=count($shiping_mark);
        $item_length=count($sale_contract_details);

        if(empty($shiping_mark_input)){

            Session::flash("danger", "Shipping Mark Can not Be Empty..!");
            return redirect()->back();
        }
        
        if($shiping_mark_lenght!=$item_length){

            Session::flash("danger", "Please Check Shipping Mark..!");
            return redirect()->back();
        }

        $currency_type=SaleContract::where('id',$id)->first(['currency_id']);  
        if($currency_type->currency_id!=1){

            if(ScCurrencyHistory::where('sale_contract_id', $id)->count()!=0){
           
                $scRateHistroy=ScCurrencyHistory::where('sale_contract_id',$id)->where('currency_id',$currency_type->currency_id)->orderBy('id','ASC')->first();
                $exchange_rate=$scRateHistroy->rate;

            }else{

                $exchange_rate=1;
            }

        }else{

            $exchange_rate=1;

        }

        $country = isset($sale_contract->notify_pary_id) && $sale_contract->notify_pary_id == 1434 ? "PAKISTAN" : "INDIA";
        return view("sale_contract.report.safta",compact("sale_contract"))
                ->with('all_sum',$all_sum)->with('obj',$this)
                ->with('sale_contract_details',$sale_contract_details)
                ->with('nocs_array',$nocs_array)
                ->with('total_amount',$total_amount)
                ->with('freight_charge', $freight_charge)
                ->with('total_carton', $total_carton)
                ->with('total_net_weight',$total_net_weight)
                ->with('total_gross_weight',$total_gross_weight)
                ->with('nw_status',$nw_status)
                ->with('lot_number',$lot_number)
                ->with('mfg_date',$mfg_date)
                ->with('lot_number',$lot_number)
                ->with('exchange_rate',$exchange_rate)
                ->with('shiping_mark',$shiping_mark)
                ->with('country',$country);
    }
    
    public function angikar($id){

        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get();
        $all_sum =  $this->getAllSum($id); 
        return view("sale_contract.report.angikar",compact("sale_contract"))
                    ->with('obj',$this)
                    ->with('all_sum',$all_sum)
                    ->with('sale_contract_details',$sale_contract_details);
    }


    public function get_first_hs_code($sale_contract_id,$ci_item_name){

            return  SaleContractDetail::where('sale_contract_details.sale_contract_id',$sale_contract_id)
                              ->where('sale_contract_details.ci_item_name',$ci_item_name)
                              ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                              ->first()
                              ->hs_code;
    }

    public function get_ci_rate_plus_frieght_avg($sale_contract_id,$ci_item_name){
            $count = SaleContractDetail::where('sale_contract_id',$sale_contract_id)->where('ci_item_name',$ci_item_name)
                              ->count();
            $sum = SaleContractDetail::where('sale_contract_id',$sale_contract_id)->where('ci_item_name',$ci_item_name)
                            ->sum('ci_rate_pl_freight');      
                            
                            
            return $sum/$count;                

    }


    public function destroy($id){
        $sale_contract = SaleContract::findOrFail($id);

        if($sale_contract ->approver_id){
            Session::flash("danger", "Already Approved !");
            return redirect()->back();
        }

        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get();
        foreach($sale_contract_details as $sale_contract_detail){
        $sale_contract_detail->delete();
        }
  
        
        $sale_contract ->delete();
        Session::flash("success", "Deleted Succcessfully !");
        return redirect("/sale_contract");
    }

   public function approve($id){

        $sale_contract = SaleContract::findOrFail($id);
        $sum = $this->getAllSum($id);  
        if($sale_contract ->desk_approver_id == null){

            Session::flash("danger", "Not Posted by desk!");
            return redirect()->back();
            
        }else if($sale_contract ->approver_id){

            Session::flash("danger", "Already Approved by Ci Doc !");
            return redirect()->back();
        }
        if($sum->total_amount != null && $sum->total_amount_party != null && $sum->total_amount_acc != null){
            $sale_contract->claim_amount_usd = $sum->claim_amount;
            $sale_contract->auditted_amount  = $sum->claim_amount;
            $sale_contract->non_eligible_item_total = $this->get_count_non_eligible_items($id);
            $sale_contract->office_file_ref_no = "L-".sprintf("%04d", $id).'/'.date('y'); 
        }
        $sale_contract ->approver_id = Auth::user()->id;
        $sale_contract ->approved_at = Carbon::now();
        $sale_contract ->save();
        Session::flash("success", "Approved Succcessfully !");
        return redirect()->back();

    }


    public function CIMakeUnposted($sc_id,$party_id){
         
        $results=SaleContract::where('id',$sc_id)
                ->update(["approver_id" => "","approved_at"=>""]);

        if($results==true){
           
            Session::flash('party_id', $party_id);
            Session::flash('sale_contract_no', $sc_id);
            Session::flash("success", "CI Doc Unposted Succcessfully...!!");
            return redirect()->back();

        }else{

            Session::flash('party_id', $party_id);
            Session::flash('sale_contract_no', $sc_id);
            Session::flash("success", "CI Doc Unposted Failed...!!");
            return redirect()->back();

        }        

    }

    public function getAllSum($sale_contract_id){

        return SaleContract::where('sale_contracts.id',$sale_contract_id)
                ->select(
                DB::Raw('SUM(sale_contract_details.total_amount_party) AS total_amount_party'),
                DB::Raw('SUM(sale_contract_details.total_amount_acc) AS total_amount_acc'),
                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                DB::Raw('SUM(sale_contract_details.ci_rate_pl_freight) AS ci_rate_pl_freight'),
                DB::Raw('SUM(sale_contract_details.ctn) AS all_ctn_qty'),
                DB::Raw('SUM(IF(sale_contract_details.is_eligible = 1, sale_contract_details.is_eligible , 0)) AS sum_is_eligible'),
                DB::Raw('SUM(IF(sale_contract_details.is_eligible = 1, sale_contract_details.ctn , 0)) AS sum_is_eligible_ctn'),
                DB::Raw('SUM(IF(sale_contract_details.is_eligible = 1, sale_contract_details.claim_amount , 0)) AS claim_amount'),
                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS total_net_weight_kg'),
                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS total_gross_weight_kg')
                )
            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
            ->first();

    } 

    private function get_count_non_eligible_items($sale_contract_id){

        return SaleContract::where('sale_contracts.id',$sale_contract_id)
            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
            ->where('sale_contract_details.is_eligible','=',0)
            ->count();

    }

    public function approveSalesContract(Request $request)
    {

        try {

            $scId = base64_decode($request->scid);
            $sale_contract = SaleContract::findOrFail($scId);

            if ($sale_contract->desk_approver_id != null) {
                return response()->json([
                    'code'    => 409,
                    'message' => "Already Approved"
                ]);
            }

            $sale_contract->desk_approver_id = Auth::user()->id;
            $sale_contract->desk_approve_at  = Carbon::now();
            $sale_contract->save();

            // Extra functions
            // $this->createCiEditHisroy($scId);
            // $this->ci_make_price_same2($scId);

            // Mail send logic if needed...

            return response()->json([
                'code'    => 200,
                'message' => "Sales Contract approved successfully!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'code'    => 500,
                'message' => "Something went wrong: " . $e->getMessage()
            ]);
        }
    }

    private function sendDocApprovalNotificationMail($sc_id){
	 
        $sales_contract=SaleContract::where('id',$sc_id)->first(['sales_contract_no as sc_no','po_number','po_master_id','notify_pary_id as party_id','gt_doc_ref']);
        $notify_party=NotifyParty::where('id',$sales_contract->party_id)->first(['code','name']);
        $postedBy=User::where('id',Auth::user()->id)->first();
        $po_details=POMaster::where('id',$sales_contract->po_master_id)->first();
        $to_mail = User::where('id', $po_details->APPROVED_BY)->get()->pluck('email')->toArray();
        $results=DB::select("select
                    ci_items.ci_item_code,
                     ci_items.ci_item_name,
                    ci_items.factor,
                    sale_contract_details.ctn,
                    sale_contract_details.rate_per_ctn_for_party as purchase_rate,
                    sale_contract_details.rate_per_ctn_for_acc as sales_rate,
                    ROUND(sale_contract_details.rate_per_ctn_for_party*sale_contract_details.ctn,4) as total_purchase_value,
                    ROUND(sale_contract_details.rate_per_ctn_for_acc*sale_contract_details.ctn,4) as total_sales_value
                from sale_contracts
                join sale_contract_details on sale_contract_details.sale_contract_id=sale_contracts.id
                join ci_items on ci_items.id=sale_contract_details.ci_item_id
                where sale_contracts.id='$sc_id'");
    
        $data = array(
            'results'=>$results,
            'customer'=>$notify_party,
            'po_details'=>$po_details,
            'postedBy'=>$postedBy,
            'subject'=>"SC Posted",
            'doc_ref'=>$sales_contract->gt_doc_ref,
            'sc_no'=>$sales_contract->sc_no,
            'to_mail'=>$to_mail,
            'cc_mail'=>Auth::user()->email
        );

        $from_mail=env('MAIL_FROM_ADDRESS');
        try {
    
            Mail::send('gt_order_sc_mail_template', $data, function($message) use ($from_mail,$data){
                $message->from($from_mail, 'SC-Posted-Notification@prangroup.com');
                $message->to($data['to_mail']);
                $message->cc($data['cc_mail']);
                $message->subject($data['subject']);
            });

            return 'Mail sent successfully';
    
        } catch (\Exception $e) {
    
            return 'Mail failed to send. Error: ' . $e->getMessage();
    
        }
        
    
    }

    public function sendDeskApprovalMail($sales_contract_id,$party_id){
          
        $sales_contract=\DB::table('sale_contracts')->where('id', $sales_contract_id)->pluck('invoice_no');
        $user_id=Auth::user()->id;
        $user_email=\DB::table('users')->where('id', $user_id)->pluck('email');
        $user_name=\DB::table('users')->where('id', $user_id)->pluck('name');
        $email=$user_email['0'];
        $name=$user_name['0'];
        $sale_contract_name=$sales_contract['0'];
        $results=\DB::select("SELECT users.email
            FROM notify_party_users
              JOIN users ON notify_party_users.user_id=users.id
            WHERE notify_party_users.notify_party_id='$party_id' and users.active='1'");        
        $email_array=array();
        $a="export@prangroup.com";
        $b="sa.oman@prgoman.com";
        $c="mis94@mis.prangroup.com";
        $d="export282@prangroup.com";
        $e="export98@prangroup.com";
        $f="export124@prangroup.com";
        $g="export118@prangroup.com";
        $h="export157@prangroup.com";
        $i="export206@prangroup.com";
        $j="export166@prgoman.com";
        $k="export464@prangroup.com";
        $m="export31@prangroup.com";
        $n="export146@prangroup.com";
        $o="jedsales01@cloud24mail.com";
        $p="mdngt03@cloud24mail.com";
        $q="mkkgt02@cloud24mail.com";
        $r="dmmsales01@cloud24mail.com";
        $s="rydzbh@cloud24mail.com";
        $t="mis4@prangroup.com";
        $u="palmis@pal.prangroup.com";
        foreach($results as $key => $value) {

            if($value->email==$a || $value->email==$b || $value->email==$c || $value->email==$d || $value->email==$e || 
                $value->email==$f || $value->email==$g || $value->email==$h || $value->email==$i || $value->email==$j || 
                $value->email==$k || $value->email==$m || $value->email==$n || $value->email==$o || $value->email==$p ||
                $value->email==$q || $value->email==$r || $value->email==$s || $value->email==$t || $value->email==$u){
             
            }else{
                
              if($value->email!="" || $value->email!=null){

                array_push($email_array, $value->email);

              }  
              
              
            }    
           
        }
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

        $date=$year.'-'.$month.'-'.$day;
        $data = array(
            'name'=>$name,
            'email'=>$email,
            'sales_contract_no'=>$sale_contract_name,
            'email_array'=>$email_array,
            'subject'=>'Sales Contact No-'.$sale_contract_name.' '.'Mail Date: '.$date
        );
        
        Mail::send('email', $data, function($message) use ($data){
            $message->from($data['email'],'SC Posted Mail');
            $message->to($data['email_array']);
            // $message->cc('mis94@mis.prangroup.com');
            $message->subject($data['subject']);
        }); 
               

    }

    public function ci_make_price_same2($sale_contact_id){

        $sale_contract_detail = DB::select("UPDATE sale_contract_details set 
                               sale_contract_details.rate_per_ctn = sale_contract_details.rate_per_ctn_for_acc,
                               sale_contract_details.total_amount = sale_contract_details.rate_per_ctn_for_acc * sale_contract_details.ctn where sale_contract_details.sale_contract_id='$sale_contact_id'");
        $this->manageFreight($sale_contact_id);
        return response()->json([
            'code'=>200
        ]);    
        
    }

    public function qtanFreightSyn($id){
        
        $results=DB::select("SELECT
            sale_contracts.invoice_no            as invoice,
            case when sales_terms.name='FOB'     then 'FOB'
            when sales_terms.name='CFR'  then 'CFR'
            when sales_terms.name='CPT'  then 'CFR'
            when sales_terms.name='CIF'  then 'CFR'
            when sales_terms.name LIKE '%FOB%' THEN 'FOB'
            when sales_terms.name LIKE '%CFR%' THEN 'CFR'
            else 'FOB' end                       as sales_term,
            companies.code2                      as company_id,
            sale_contracts.qtan_freight_cost as freight_cost,
            sale_contracts.total_container as containter_qty,
            case when container_1 then container_1
            when container_2 then container_2
            when container_3 then container_3
            else '' end AS container_size,
            cnf.job_no as job_no,
            cnf.sb_no as sbn_no,
            container_qty_1 as container_qty_20ft,
            container_qty_2 as container_qty_40ft,
            container_qty_3 as container_qty_40hc,
            case when cnf.depot_id then cnf.depot_id else 1 end as depot
        from sale_contracts
        join sales_terms on sales_terms.id=sale_contracts.sales_term_id
        join companies on companies.id=sale_contracts.company_id
        left join cnf on cnf.sale_contract_id=sale_contracts.id
        where sale_contracts.id=$id");
        $total=$this->total_value($id);
  
        if(count($results)>0){
              
          foreach ($results as $key => $value) {
               
            $company_id=$value->company_id;
            $invoice_number=$value->invoice;
            $container_qty=$value->containter_qty;
            $charge=$value->freight_cost; 
            $container_size=$value->container_size;
            $sales_term=$value->sales_term;
            $job_no=$value->job_no ? $value->job_no : 1;
            $sbn_no=$value->sbn_no ? $value->sbn_no : 1;
            $container_qty_20ft=$value->container_qty_20ft;
            $container_qty_40ft=$value->container_qty_40ft;
            $container_qty_40hc=$value->container_qty_40hc;
            $depot=$value->depot ? $value->depot : 1;
            $total_ctn=$total->total_ctn;
            $total_weight=$total->total_weight;

            $url = 'http://runner.prangroup.com:9001/app/prg/invoices/job';
            $url .= '?company_id=' . urlencode($company_id);
            $url .= '&invoice_number=' . urlencode($invoice_number);
            $url .= '&container_quantity=' . urlencode($container_qty);
            $url .= '&charges=' . urlencode($charge);
            $url .= '&container_size=' . urlencode($container_size);
            $url .= '&sales_term=' . urlencode($sales_term);
            $url .= '&job_no=' . urlencode($job_no);
            $url .= '&sbn_no=' . urlencode($sbn_no);
            $url .= '&container_qty_20ft=' . urlencode($container_qty_20ft);
            $url .= '&container_qty_40ft=' . urlencode($container_qty_40ft);
            $url .= '&container_qty_40hc=' . urlencode($container_qty_40hc);
            $url .= '&depot=' . urlencode($depot);
            $url .= '&ctn_qty=' . urlencode($total_ctn);
            $url .= '&total_weight=' . urlencode($total_weight);            
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
            if($outputMsg=='Success'){

                $freightLogHistory=new FreightLogHistory();
                $freightLogHistory->sc_id=$id;
                $freightLogHistory->user_id=Auth::user()->id;
                $freightLogHistory->message=$outputMsg;
                $freightLogHistory->message=$outputMsg;
                $freightLogHistory->save();
            }

          }

        }
  
    }

    public function total_value($sale_contract_id){

        return SaleContract::where('sale_contracts.id',$sale_contract_id)
                ->select(
                   DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS total_weight'),
                   DB::Raw('SUM(sale_contract_details.ctn) AS total_ctn')
                )
            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
            ->first();

    } 

    public function createCiEditHisroy($id){
        
        $sale_contract = SaleContract::find($id); 
        $sale_contract_details =SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_factor','ci_items.ci_item_rate','bank_for_print_date','sale_contract_details.rate_per_ctn','importers.address as importer_address','importers.name as importer_name','notify_parties.address as notify_party_address','notify_parties.name as notify_party_name',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq')
                                )
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->join('importers','importers.id','sale_contracts.importer_id')
                            ->join('notify_parties','notify_parties.id','sale_contracts.notify_pary_id')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                            ->orderBy('sale_contract_details.id')
                            ->get();
        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");
        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        }

        try { 

               $freight_cost=$sale_contract->freight_cost;
               $per_unit_freight=$freight_cost/$total_net_weight;
                          
            }catch (Exception $e) {


        }   
        $total_amount=0;
        foreach ($sale_contract_details as $key => $sale_contract_detail) {
           
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

                $total_amount=$total_amount+round($carton_fright_pl_rate*$sale_contract_detail->ctn,2);

        }

        $ciEditHistroy=new CiEditHistory();
        $ciEditHistroy->sales_contact_id=$id;
        $ciEditHistroy->user_id=Auth::user()->id;
        $ciEditHistroy->total_amount=$total_amount;
        $ciEditHistroy->save();
    

    }

   

    public function cancel_approve_desk($sale_contact_id,$party_id){
        
        $id=\Crypt::decrypt($sale_contact_id);
        $sale_contract = SaleContract::findOrFail($id);
        if($sale_contract ->approver_id != null ){

            Session::flash("danger", "Task Finished Can not cancel Posted !");
            return redirect()->back();
        }
        $sale_contract ->desk_approver_id = null;
        $sale_contract ->desk_approve_at = null;
        $sale_contract ->save();
        $this->sendUnPostedMail($id,\Crypt::decrypt($party_id));
        Session::flash("success", "Unposted Succcessfully !");
        return redirect('/notify/party/list/doc/'.$party_id);
        
    }    

    public function sendUnPostedMail($sales_contract_id,$party_id){
       
        $sales_contract=\DB::table('sale_contracts')->where('id', $sales_contract_id)->pluck('invoice_no');
        $user_id=Auth::user()->id;
        $user_email=\DB::table('users')->where('id', $user_id)->pluck('email');
        $user_name=\DB::table('users')->where('id', $user_id)->pluck('name');
        $email=$user_email['0'];
        $name=$user_name['0'];
        $sale_contract_name=$sales_contract['0'];
        $results=\DB::select("SELECT users.email
            FROM notify_party_users
              JOIN users ON notify_party_users.user_id=users.id
            WHERE notify_party_users.notify_party_id='$party_id' and users.active='1'");        
        $email_array=array();
        $a="export@prangroup.com";
        $b="sa.oman@prgoman.com";
        $c="mis94@mis.prangroup.com";
        $d="export282@prangroup.com";
        $e="export98@prangroup.com";
        $f="export124@prangroup.com";
        $g="export118@prangroup.com";
        $h="export157@prangroup.com";
        $i="export206@prangroup.com";
        $j="export166@prgoman.com";
        $k="export464@prangroup.com";
        $m="export31@prangroup.com";
        $n="export146@prangroup.com";
        $o="mis4@prangroup.com";
        $p="palmis@pal.prangroup.com";
        foreach($results as $key => $value) {

            if($value->email==$a || $value->email==$b || $value->email==$c || $value->email==$d || $value->email==$e || $value->email==$f || $value->email==$g || $value->email==$h || $value->email==$i || $value->email==$j || $value->email==$k || $value->email==$m || $value->email==$n || $value->email==$o || $value->email==$p){
             
            }else{

              if($value->email!="" || $value->email!=null){

                array_push($email_array, $value->email);

              }
              
            }    
           
        }
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

        $date=$year.'-'.$month.'-'.$day;
        $data = array(
            'name'=>$name,
            'email'=>$email,
            'sales_contract_no'=>$sale_contract_name,
            'email_array'=>$email_array,
            'subject'=>'Sales Contact No-'.$sale_contract_name.' '.'Mail Date: '.$date
        );

        Mail::send('imposted_mail', $data, function($message) use ($data){
            $message->from($data['email'],'SC Imposted Mail');
            $message->to($data['email_array']);
            $message->subject($data['subject']);
        }); 

    }

    public function duplicate($sale_contact_id, $party_id)
    {
        try {

            $id = \Crypt::decrypt($sale_contact_id);
            $decryptedPartyId = \Crypt::decrypt($party_id);
            $sale_contract_prev = SaleContract::where('id', $id)
                ->where('notify_pary_id', $decryptedPartyId)
                ->first();

            if(!$sale_contract_prev) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sales contract not found.'
                ], 404);
            }
            
            if ($sale_contract_prev->inactive === 'Y') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot duplicate an inactive sales contract.'
                ], 400);
            }
            
            // Create a duplicate
            $sale_contract = new SaleContract;
            $sale_contract->sales_contract_no = $sale_contract_prev->sales_contract_no;
            $sale_contract->dated = date("Y-m-d", strtotime($sale_contract_prev->dated));
            $sale_contract->invoice_no = str_replace(' ', '', str_replace('/', '-', $sale_contract_prev->invoice_no . "-copy"));
            $sale_contract->ad_code = $sale_contract_prev->ad_code;
            $sale_contract->ci_note = $sale_contract_prev->ci_note;
            $sale_contract->discharge_port = $sale_contract_prev->discharge_port;
            $sale_contract->country_id = $sale_contract_prev->country_id;
            $sale_contract->sales_term_id = $sale_contract_prev->sales_term_id;
            $sale_contract->company_id = $sale_contract_prev->company_id;
            $sale_contract->bank_id = $sale_contract_prev->bank_id;
            $sale_contract->account_number = $sale_contract_prev->account_number;
            $sale_contract->importer_id = $sale_contract_prev->importer_id;
            $sale_contract->bank_importer_id = $sale_contract_prev->bank_importer_id;
            $sale_contract->notify_pary_id = $sale_contract_prev->notify_pary_id;
            $sale_contract->carrying_mode_id = $sale_contract_prev->carrying_mode_id;
            $sale_contract->loading_place_id = $sale_contract_prev->loading_place_id;
            $sale_contract->final_destination = $sale_contract_prev->final_destination;
            $sale_contract->creator_id = Auth::user()->id;
            $sale_contract->terms_and_condition = $sale_contract_prev->terms_and_condition;
            $sale_contract->terms_and_condition_desk_inv = $sale_contract_prev->terms_and_condition_desk_inv;
            $sale_contract->freight_cost = $sale_contract_prev->freight_cost;
            $sale_contract->container = $sale_contract_prev->container;
            $sale_contract->container_1 = $sale_contract_prev->container_1;
            $sale_contract->container_2 = $sale_contract_prev->container_2;
            $sale_contract->container_3 = $sale_contract_prev->container_3;
            $sale_contract->freight_cost_1 = $sale_contract_prev->freight_cost_1;
            $sale_contract->freight_cost_2 = $sale_contract_prev->freight_cost_2;
            $sale_contract->freight_cost_3 = $sale_contract_prev->freight_cost_3;
            $sale_contract->freight_cost = $sale_contract_prev->freight_cost;
            $sale_contract->importer_country = $sale_contract_prev->importer_country;
            $sale_contract->angikar_given_by = $sale_contract_prev->angikar_given_by;
            $sale_contract->approver_id = null;
            $sale_contract->approved_at = null;
            $sale_contract->desk_approver_id = null;
            $sale_contract->po_number = 1;
            $sale_contract->po_master_id = 1;
            $sale_contract->inactive = 'N';
            $sale_contract->save();
            $sale_contract->invoice_no = $sale_contract->invoice_no . $sale_contract->id;

            if($sale_contract_prev->importer_id == 1) {
                $sale_contract->importer_name = 'N/A';
                $sale_contract->importer_address = 'N/A';
            } else {
                $sale_contract->importer_name = $sale_contract_prev->importer_name ?: 
                    Importer::where('id', $sale_contract_prev->importer_id)->value('name');
                $sale_contract->importer_address = $sale_contract_prev->importer_address ?: 
                    Importer::where('id', $sale_contract_prev->importer_id)->value('address');
            }
            $sale_contract->party_name = $sale_contract_prev->party_name ?: 
                NotifyParty::where('id', $sale_contract_prev->notify_pary_id)->value('name');
            $sale_contract->party_address = $sale_contract_prev->party_address ?: 
                NotifyParty::where('id', $sale_contract_prev->notify_pary_id)->value('address');
            
            $sale_contract->third_notify_party = $sale_contract_prev->third_notify_party;
            $sale_contract->created_at = date('Y-m-d H:i:s');
            $sale_contract->save();
            
            // Duplicate contract details
            $sale_contract_details = SaleContractDetail::where('sale_contract_id', $id)->get();
            foreach($sale_contract_details as $sale_contract_detail_prev) {
                $sale_contract_detail = new SaleContractDetail;
                $sale_contract_detail->ci_item_id = $sale_contract_detail_prev->ci_item_id;
                $sale_contract_detail->ci_item_name = $sale_contract_detail_prev->ci_item_name; 
                $sale_contract_detail->sale_contract_id = $sale_contract->id;
                $sale_contract_detail->rate_per_ctn = $sale_contract_detail_prev->rate_per_ctn;
                $sale_contract_detail->rate_per_ctn_for_party = $sale_contract_detail_prev->rate_per_ctn_for_party;
                $sale_contract_detail->rate_per_ctn_for_acc = $sale_contract_detail_prev->rate_per_ctn_for_acc;
                $sale_contract_detail->ctn = $sale_contract_detail_prev->ctn;
                $sale_contract_detail->pcs_in_ctn = $sale_contract_detail_prev->pcs_in_ctn;

                $sale_contract_detail->cbm_per_ctn = $sale_contract_detail_prev->cbm_per_ctn;
                $sale_contract_detail->total_cbm = $sale_contract_detail_prev->total_cbm;
                $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = 0;
                $sale_contract_detail->per_ctn_freight = 0;
                $sale_contract_detail->ci_rate_pl_freight = 0;

                $sale_contract_detail->is_eligible = $sale_contract_detail_prev->is_eligible;
                $sale_contract_detail->bapa_percent = $sale_contract_detail_prev->bapa_percent;
                $sale_contract_detail->claim_amount = $sale_contract_detail_prev->claim_amount;
                $sale_contract_detail->bu_id = $sale_contract_detail_prev->bu_id;
    
                $sale_contract_detail->total_amount = $sale_contract_detail_prev->total_amount;
                $sale_contract_detail->total_amount_party = $sale_contract_detail_prev->total_amount_party;
                $sale_contract_detail->total_amount_acc = $sale_contract_detail_prev->total_amount_acc;
                $sale_contract_detail->net_weight_kg = $sale_contract_detail_prev->net_weight_kg;
                $sale_contract_detail->gross_weight_kg = $sale_contract_detail_prev->gross_weight_kg;
                $sale_contract_detail->gross_weight_per_item = $sale_contract_detail_prev->gross_weight_per_item;
                $sale_contract_detail->ccq = $sale_contract_detail_prev->ccq;
                $sale_contract_detail->mfg = $sale_contract_detail_prev->mfg;
                $sale_contract_detail->exp = $sale_contract_detail_prev->exp;
                $sale_contract_detail->desk_item_name = $sale_contract_detail_prev->desk_item_name;
                $sale_contract_detail->container_no = $sale_contract_detail_prev->container_no;
                $sale_contract_detail->batch_no = $sale_contract_detail_prev->batch_no;
                $sale_contract_detail->hs_code = $sale_contract_detail_prev->hs_code;
                $sale_contract_detail->hs_code_2 = $sale_contract_detail_prev->hs_code_2;
                $sale_contract_detail->save();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Sales contract duplicated successfully!'
            ]);
            
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid contract ID.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error duplicating sales contract: ' . $e->getMessage()
            ], 500);
        }
        
    }


    private function isCiDetailAlreadyExist($sale_contract_id,$ci_item_id){
        $sale_contract_detail = SaleContractDetail::where('sale_contract_id',$sale_contract_id)->where('ci_item_id',$ci_item_id)->get();
        if($sale_contract_detail->first()){
          return 1;
        }else{
            return 0;
        }
    }
    
    

    private function save_items($sale_contract_id,$datas, $notify_party_id) {

        foreach ($datas as $key => $value) {

                $ci_items =  CiItem::where('ci_item_code',$value->item_code)->where('status',1)->first();
                if(!$ci_items) {
                   
                    echo "Error: Item not found! Item Code = {$value->item_code}, SL = {$value->sl}<br>";
                    continue; 
                }
                $party_rate=NotifyPartyItem::where('ci_item_id', $ci_items->id)->where('notify_party_id', $notify_party_id)->pluck('party_rate')->toArray();
                if($value->item_code == '' || !is_numeric($value->ctn)){

                    echo "Numeric Data Required!! <br>";

                }else{
                        
                        $ci_items =  CiItem::where('ci_item_code',$value->item_code)->where('status',1)->get();
                        if($ci_item = $ci_items->first()){
                        
                            if($this->isCiDetailAlreadyExist($sale_contract_id,$ci_item->id)){
                            
                            }else{

                                $sale_contract_detail = new SaleContractDetail();
                                $sale_contract_detail->ccq=0;
                                $sale_contract_detail->ci_item_id=$ci_item->id;
                                $cbm_per_carton=NotifyPartyItem::where('ci_item_id', $ci_item->id)->where('notify_party_id', $notify_party_id)->pluck('cbm_per_ctn')->toArray();
                                $acc_rate=NotifyPartyItem::where('ci_item_id', $ci_item->id)->where('notify_party_id', $notify_party_id)->pluck('acc_rate')->toArray();
                                $desk_item_name=NotifyPartyItem::where('ci_item_id', $ci_item->id)->where('notify_party_id', $notify_party_id)->pluck('desk_item_name')->toArray();
                                $party_rate=NotifyPartyItem::where('ci_item_id', $ci_item->id)->where('notify_party_id', $notify_party_id)->pluck('party_rate')->toArray();
                                $gross_weight=NotifyPartyItem::where('ci_item_id', $ci_item->id)->where('notify_party_id', $notify_party_id)->pluck('gross_weight')->toArray();
                                $sale_contract_detail->ci_item_name=$ci_item->duplicate_name; 
                                $sale_contract_detail->sale_contract_id=$sale_contract_id;
                                $sale_contract_detail->rate_per_ctn= $ci_item->ci_item_rate;
                                $sale_contract_detail->hs_code=$ci_item->hs_code;
                                if(!empty($desk_item_name[0])){

                                   $sale_contract_detail->desk_item_name = $desk_item_name[0];
                                }
                                if(!empty($party_rate[0])){

                                  $sale_contract_detail->rate_per_ctn_for_party= $party_rate[0];   
                                  $sale_contract_detail->total_amount_party=$party_rate[0]*$value->ctn;        //Update Here Party Amount
                                  //$sale_contract_detail->rate_per_ctn_for_party = $value->percent ? ($party_rate[0]*$value->percent)/100*$value->ctn : $party_rate[0]*$value->ctn;
                                }  
                                if(!empty($acc_rate[0])){

                                   $sale_contract_detail->rate_per_ctn_for_acc=$acc_rate[0];
                                   $sale_contract_detail->total_amount_acc=$acc_rate[0]*$value->ctn;            // Total Accounts Amount

                                }

                                $sale_contract_detail->total_amount      = $ci_item->ci_item_rate*$value->ctn;  // Total CI Amount
                                $sale_contract_detail->ctn               = $value->ctn;
                                $sale_contract_detail->pcs_in_ctn        = $value->ctn * $ci_item->ci_factor;
                                $sale_contract_detail->factor            = $ci_item->ci_factor;
                                if(!empty($cbm_per_carton[0])){

                                   $sale_contract_detail->cbm_per_ctn       = $cbm_per_carton[0];
                                   $sale_contract_detail->total_cbm         = $cbm_per_carton[0] * $value->ctn ;
                                }
                                
                                $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = 0;
                                $sale_contract_detail->per_ctn_freight        = 0;
                                $sale_contract_detail->ci_rate_pl_freight     = 0;
                                $sale_contract_detail->net_weight_kg          = $value->ctn * $ci_item->d_net_weight;
                                $sale_contract_detail->hs_code_2              = $value->hs_code2;
                                if(!empty($gross_weight[0])){

                                  $sale_contract_detail->gross_weight_kg      = $value->ctn * $gross_weight[0];
                                }  
                                $sale_contract_detail->bapa_percent = $ci_item->bapa_percent;
                                $sale_contract_detail->bapa_percent = ($ci_item->bapa_percent * $sale_contract_detail->total_amount_party ) / 100;
                                $sale_contract_detail->bu_id        = $ci_item->bu_id;
                                $sale_contract_detail->sample_qty   = $value->sample=="" ? "0" : $value->sample;
                                $sale_contract_detail->mfg=NULL;
                                $sale_contract_detail->exp=NULL;
                                $sale_contract_detail->barcode=NULL;
                                $sale_contract_detail->batch_no=NULL;
                                $sale_contract_detail ->save();
                              
                            }

                        }else{
                                echo 'sl= '.$value->sl."  item_code= ".$value->item_code."  Error: Item Not Created, Check item_code or Please Create Item !!<br>";
                        }

            }// blank data

        }// foreach end 

        return redirect('/access_notify_party_list');

    }  //@@@-end get data from excel
 

    public function ci_make_price_same(Request $request){

        $sale_contact_id=$request->sale_contact_id;
        $sale_contract_detail = DB::select("UPDATE sale_contract_details set 
                               sale_contract_details.rate_per_ctn = sale_contract_details.rate_per_ctn_for_acc,
                               sale_contract_details.total_amount = sale_contract_details.rate_per_ctn_for_acc * sale_contract_details.ctn where sale_contract_details.sale_contract_id='$sale_contact_id'");
        $this->manageFreight($sale_contact_id);
        return response()->json([
            'code'=>200
        ]);    
        
    }



    private function manageFreight($sale_contract_id){
        
        $sale_contract = SaleContract::find($sale_contract_id);
        $freight_cost  = $sale_contract->freight_cost;
        $sum_total_cbm = SaleContractDetail::where('sale_contract_id',$sale_contract_id)
                                            ->sum('total_cbm');

        foreach($sale_contract->sale_contract_details as $sale_contract_detail){

            $freigh_x_tcbm_by_sum_total_cbm = ($freight_cost / $sum_total_cbm ) * $sale_contract_detail->total_cbm ;
            $per_ctn_freight = $freigh_x_tcbm_by_sum_total_cbm / $sale_contract_detail->ctn;
            $ci_rate_pl_freight = $sale_contract_detail->rate_per_ctn + $per_ctn_freight;
            $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = $freigh_x_tcbm_by_sum_total_cbm;
            $sale_contract_detail->per_ctn_freight   = $per_ctn_freight;
            $sale_contract_detail->ci_rate_pl_freight     = round($ci_rate_pl_freight,3);
            $sale_contract_detail->total_amount = $sale_contract_detail->ctn * round($ci_rate_pl_freight,3);
            $sale_contract_detail->save();
          
        }

    }


    private function manageCCQ($sale_contract_id){

        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$sale_contract_id)->get();
        $sum_ccq = 0;
        foreach($sale_contract_details as $sale_contract_detail){
            $sum_ccq += $sale_contract_detail->ctn;
            $sale_contract_detail->ccq = $sum_ccq;
            $sale_contract_detail->save();
        }

        return 1;

    }

    public function ci_edit_view(){
         
       $current_date=date('Y-m-d'); 
       $previous_date=date('Y-m-d', strtotime('-24 month'));
       $sciStatuses=SciStatus::all();
       $sale_contracts=SaleContract::where('invoice_date','<=',$current_date)
                       ->select('sale_contracts.invoice_no','sale_contracts.id')
                       ->where('invoice_date','>=',$previous_date)
                       ->whereNotNull('desk_approver_id')
                       ->get();
                       
       return view("sale_contract.sci.ci_update_view",compact("sale_contracts"))
             ->with('sciStatuses',$sciStatuses);

    }

    public function jsonGetInvoiceDetails(Request $request){

      $sale_contract = SaleContract::find($request->invoice_no);
      if($sale_contract->invoice_date){
           
         $invoice_date=date("d-m-Y", strtotime($sale_contract->invoice_date));  

      }else{

        $invoice_date="";

      }
      
      $exp_no=$sale_contract->export_no;
      if($sale_contract->export_date){
         
         $export_date=date("d-m-Y", strtotime($sale_contract->export_date));

      }else{

         $export_date=""; 
      }
      
      if($exp_no){

        $exp_number=(explode("/",$exp_no));
        $ad_code=substr($exp_number['0'],4);

      }else{

        $ad_code=''; 

      }

      $total_carton=0;
      $sale_contract_details =SaleContract::where('sale_contracts.id',$request->invoice_no)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_factor','ci_items.ci_item_rate','bank_for_print_date','sale_contract_details.rate_per_ctn','importers.address as importer_address','importers.name as importer_name','notify_parties.address as notify_party_address','notify_parties.name as notify_party_name',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq')
                                )
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->join('importers','importers.id','sale_contracts.importer_id')
                            ->join('notify_parties','notify_parties.id','sale_contracts.notify_pary_id')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                            ->orderBy('sale_contract_details.id')
                            ->get();
            
        $non_eligible_item_totals =SaleContract::where('sale_contracts.id',$request->invoice_no)
                                ->select('ci_items.ci_item_code','sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_factor','ci_items.ci_item_rate','bank_for_print_date','sale_contract_details.rate_per_ctn','importers.address as importer_address','importers.name as importer_name','notify_parties.address as notify_party_address','notify_parties.name as notify_party_name',
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.pcs_in_ctn) AS pcs_in_ctn'),
                                DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                DB::Raw('SUM(sale_contract_details.ccq) AS ccq')
                                )
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->join('importers','importers.id','sale_contracts.importer_id')
                            ->join('notify_parties','notify_parties.id','sale_contracts.notify_pary_id')
                            ->where('ci_items.item_group_id','236')
                            ->groupby('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor')
                            ->orderBy('sale_contract_details.id')
                            ->get();


        foreach ($sale_contract_details as $key => $value) {
            
            $total_carton=$total_carton+$value->ctn;
            $importer_name=$value->importer_name;
            $importer_address=$value->importer_address;
            $notify_party_name=$value->notify_party_name;
            $notify_party_address=$value->notify_party_address;
        }        

        $total_pcs_in_ctn = 0;
        $total_ctn = 0; 
        $total_amount = 0;
        $non_eligible_total_amount=0;
        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$request->invoice_no'");
        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        }

        try { 

               $freight_cost=$sale_contract->freight_cost;
               $per_unit_freight=$freight_cost/$total_net_weight;
                          
            }catch (Exception $e) {


        }   

        foreach ($sale_contract_details as $key => $sale_contract_detail) {
           
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

                $total_amount=$total_amount+round($carton_fright_pl_rate*$sale_contract_detail->ctn,2);
                //echo"<br>";

        }
        $NonEligibletotalNetWeight=0;
        foreach ($non_eligible_item_totals as $key => $sale_contract_detail) {
           
                try { 
                
                      if($sale_contract_detail->ci_factor!=0){

                            $per_net_weight_kg_fright=$per_unit_freight*$sale_contract_detail->net_weight_kg;
                            $caton_fright=$per_net_weight_kg_fright/$sale_contract_detail->ctn;
                            $carton_fright_pl_rate=round($caton_fright+$sale_contract_detail->rate_per_ctn, 3);
                            $NonEligibletotalNetWeight=$NonEligibletotalNetWeight+$sale_contract_detail->net_weight_kg;
                            
                      }else{

                        $carton_fright_pl_rate="0";

                      }
                }catch (Exception $e) {
 
                } 

                $non_eligible_total_amount=$non_eligible_total_amount+round($carton_fright_pl_rate*$sale_contract_detail->ctn,2);

        }
        
        $totalFreightCost=0;                    
        $salesContactdetails=SaleContract::select('sale_contracts.discharge_port','companies.name as company_name','countries.name as county_name')
                           ->join('companies','companies.id','sale_contracts.company_id')
                           ->join('countries','countries.id','sale_contracts.country_id')
                           ->where('sale_contracts.id',$request->invoice_no)
                           ->first();                    
         
        $claim_amount_usd=$sale_contract->claim_amount_usd;
        $audit_report_date=$sale_contract->audit_report_date;
        $auditted_amount=$sale_contract->auditted_amount;
        $auditted_amount_tk=$sale_contract->auditted_amount_tk;
        $shipped_on_board_date=$sale_contract->shipped_on_board_date;
        $company_name=$salesContactdetails->company_name;
        $discharge_port=explode(',',$salesContactdetails->discharge_port);
        $discharge_port=$discharge_port['0'];
        $county_name=$sale_contract->final_destination;
        $eligibleItemNetWeight=$total_net_weight-$NonEligibletotalNetWeight;
        if($sale_contract->ci_note){ 
           
            $lc=explode(",",$sale_contract->ci_note);

            if (!isset($lc[0])) {

               $lc_number = '';

            }else{
              
               $lc_number=$lc[0];
            }

            if (!isset($lc[1])) {

               $lc_date = '';

            }else{
              
               $lc_date=$lc[1];
            }
             
        }else{
 
            $lc_number='';
            $lc_date=''; 

        }
        
        return $array=array($invoice_date,$ad_code,$exp_no,$export_date,$total_amount,$non_eligible_total_amount,$total_carton,$claim_amount_usd,$totalFreightCost,$audit_report_date,$auditted_amount,$auditted_amount_tk,$shipped_on_board_date,$company_name,$discharge_port,$county_name,$eligibleItemNetWeight,$lc_number,$lc_date);

       

    }

    public function saveInvoiceDetails(Request $request){
        
       DB::beginTransaction();
        try {

            $edit_id='';
            for ($i=1; $i < sizeof($request->datastring['0']); $i++) { 

                $sci=new SCI();
                $sale_contract_id=$request->datastring[$i++]['value'];
                $invoiceExistOrNot=SCI::where('sale_contract_id', $sale_contract_id)->get();
                if(count($invoiceExistOrNot)>0){

                    return "Exist";
                }
                $sci->sale_contract_id=$sale_contract_id;
                $invoice_no=SaleContract::where('id', $sale_contract_id)->pluck('invoice_no');
                $sci->invoice_no=$invoice_no['0'];
                $sci->invoice_date=date("d-m-Y",strtotime($request->datastring[$i++]['value']));
                $sci->ad_code=$request->datastring[$i++]['value'];
                $sci->exp_no=$request->datastring[$i++]['value'];
                $expDate=$request->datastring[$i++]['value'];
                if(!empty($expDate)){

                   $sci->exp_date=date("d-m-Y",strtotime($expDate));
                }

                $exp_submit_date=$request->datastring[$i++]['value'];

                if(!empty($exp_submit_date)){
               
                   $sci->exp_submit_date=date("d-m-Y",strtotime($exp_submit_date));
                }
                
                $sci->sci_status_id=$request->datastring[$i++]['value'];
                $sci->ci_shadow_file=$request->datastring[$i++]['value'];

                $proceeds_realization_date=$request->datastring[$i++]['value'];

                if(!empty($proceeds_realization_date)){

                $sci->proceeds_realization_date=date("d-m-Y",strtotime($proceeds_realization_date));

                }

                $last_date_for_lodging_claim=$request->datastring[$i++]['value'];

                if(!empty($last_date_for_lodging_claim)){

                $sci->last_date_for_lodging_claim=$last_date_for_lodging_claim;

                }

                $sci->exp_amount_usd=$request->datastring[$i++]['value'];
                $sci->non_eligible_item_value=$request->datastring[$i++]['value'];
                $sci->no_of_carton_exported=$request->datastring[$i++]['value'];
                $sci->amount_of_proceed_realized=$request->datastring[$i++]['value'];
                $sci->short_realized=$request->datastring[$i++]['value'];
                $prc_issue_date=$request->datastring[$i++]['value'];

                if(!empty($prc_issue_date)){

                $sci->prc_issue_date=date("d-m-Y",strtotime($prc_issue_date));

                }

                $bapa_application_submit_date=$request->datastring[$i++]['value'];
                if(!empty($bapa_application_submit_date)){

                $sci->bapa_application_submit_date=date("d-m-Y",strtotime($bapa_application_submit_date)); 
                    
                }

                $bapa_certificate_date=$request->datastring[$i++]['value'];

                if(!empty($bapa_certificate_date)){

                $sci->bapa_certificate_date=date("d-m-Y",strtotime($bapa_certificate_date)); 
                    
                }

                $claim_submission_date=$request->datastring[$i++]['value'];

                if(!empty($claim_submission_date)){

                   $sci->claim_submission_date=date("d-m-Y",strtotime($claim_submission_date)); 
                    
                }

                $sci->claim_amount_usd=$request->datastring[$i++]['value'];

                $audit_report_date=$request->datastring[$i++]['value'];

                if(!empty($audit_report_date)){

                   $sci->audit_report_date=date("d-m-Y",strtotime($audit_report_date)); 
                    
                }

                $sci->auditted_amount=$request->datastring[$i++]['value'];
                $sci->exchange_rate=$request->datastring[$i++]['value'];
                $sci->auditted_amount_tk=$request->datastring[$i++]['value'];
                $sci->shipped_on_board_date=date("d-m-Y",strtotime($request->datastring[$i++]['value']));
                $sci->shipped_on_board_date2=date("d-m-Y",strtotime($request->datastring[$i++]['value']));
                $over_due_date=$request->datastring[$i++]['value'];
                if(!empty($over_due_date)){

                   $sci->over_due=date("d-m-Y",strtotime($over_due_date)); 
                    
                }
                $sci->bl_or_challan_no=$request->datastring[$i++]['value'];
                $bl_or_challan_date=$request->datastring[$i++]['value'];

                if(!empty($bl_or_challan_date)){

                   $sci->bl_or_challan_date=date("d-m-Y",strtotime($bl_or_challan_date));  

                }

                $sci->discharge_port=$request->datastring[$i++]['value'];
                $sci->see_freight=$request->datastring[$i++]['value'];
                $sci->company_or_exporter_name=$request->datastring[$i++]['value'];
                $sci->country_or_expored_name=$request->datastring[$i++]['value'];
                $sci->shipping_bill_no=$request->datastring[$i++]['value'];
                $shipping_bill_date=$request->datastring[$i++]['value'];
                if(!empty($shipping_bill_date)){

                   $sci->shipping_bill_date=date("d-m-Y",strtotime($shipping_bill_date)); 
                   
                }
                $sci->insurance=$request->datastring[$i++]['value'];
                $sci->od_sight_rate=$request->datastring[$i++]['value'];
                $sci->prc_issue_number=$request->datastring[$i++]['value'];
                $sci->eligibleItemNetWeight=$request->datastring[$i++]['value'];
                $sci->importer_bank=$request->datastring[$i++]['value'];
                $sci->tt_number=$request->datastring[$i++]['value'];
                $sci->tt_date=$request->datastring[$i++]['value'];
                $sci->tt_amount=$request->datastring[$i++]['value'];
                $sci->bank_address=$request->datastring[$i++]['value'];
                $sci->non_eligible_item_name=$request->datastring[$i++]['value'];
                $sci->lc_number=$request->datastring[$i++]['value'];
                $sci->lc_date=$request->datastring[$i++]['value'];
                $sci->lc_value=$request->datastring[$i++]['value'];
                $sci->user_id=Auth::user()->id;
                $sci->save();
            }
            $user_id=Auth::user()->id;
            $date=Carbon::now();
            \DB::table('sale_contracts')
                ->where('id', $sale_contract_id)
                ->update(['approver_id' => $user_id,'approved_at' => $date]);

            return "Success";
   
        }catch (Exception $e) {

           DB::rollback(); 
           echo 'Caught exception: ',  $e->getMessage(), "\n";
           return "Fail";

        }
         

    }
    

    public function sciComInv(Request $request, $id){
        
        $sale_contract_details=DB::select("SELECT
                sale_contracts.sales_contract_no,
                sale_contracts.dated,
                sale_contracts.invoice_no,
                sale_contracts.invoice_date,
                sale_contracts.export_no,
                sale_contracts.export_date,
                sale_contracts.freight_cost,
                importers.name AS importer_name,
                importers.address AS importer_address,
                banks.name AS bank_name,
                banks.address AS bank_address,
                bank_importers.bank_name AS importer_bank_name,
                bank_importers.branch AS importer_bank_address,
                s_c_i_s.claim_submission_date,
                s_c_i_s.last_date_for_lodging_claim,
                s_c_i_s.amount_of_proceed_realized,
                s_c_i_s.shipped_on_board_date,
                banks.short_name,
                sale_contracts.discharge_port,
                s_c_i_s.insurance,
                s_c_i_s.od_sight_rate,
                SUM(sale_contract_details.ctn) AS ctn,
                SUM(
                    sale_contract_details.pcs_in_ctn
                ) AS pcs_in_ctn,
                SUM(
                    sale_contract_details.total_amount
                ) AS total_amount,
                SUM(
                    sale_contract_details.net_weight_kg
                ) AS net_weigth_kg,
                SUM(
                    sale_contract_details.gross_weight_kg
                ) AS gross_weight_kg,
                s_c_i_s.amount_of_proceed_realized as realize_value
            FROM
                sale_contracts
            JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
            JOIN importers ON importers.id = sale_contracts.importer_id
            JOIN banks ON banks.id = sale_contracts.bank_id
            JOIN bank_importers ON bank_importers.id = sale_contracts.bank_importer_id
            JOIN s_c_i_s ON s_c_i_s.sale_contract_id = sale_contracts.id
            WHERE
                sale_contracts.id = '1'
            GROUP BY
                sale_contracts.sales_contract_no,
                sale_contracts.dated,
                sale_contracts.invoice_no,
                sale_contracts.invoice_date,
                sale_contracts.export_no,
                sale_contracts.export_date,
                sale_contracts.freight_cost,
                importers.name,
                importers.address,
                banks.name,
                banks.address,
                bank_importers.bank_name,
                bank_importers.branch,
                s_c_i_s.claim_submission_date,
                s_c_i_s.last_date_for_lodging_claim,
                s_c_i_s.amount_of_proceed_realized,
                s_c_i_s.shipped_on_board_date");

        foreach($sale_contract_details as $key => $value) {

                $sale_contact_date=$value->dated;
                $invoice_no=$value->invoice_no;
                $invoice_date=$value->invoice_date;
                $sale_contract_no=$value->sales_contract_no;
                $bank_name=$value->bank_name;
                $bank_address=$value->bank_address;
                $short_name=$value->short_name;
                $invoice_no=$value->invoice_no;
                $invoice_date=$value->invoice_date;
                $importer_name=$value->importer_name;
                $importer_address=$value->importer_address;
                $pcs_in_ctn=$value->pcs_in_ctn;
                $total_ctn=$value->ctn;
                $exp_no=$value->export_no;
                $exp_date=$value->export_date;
                $freight_cost=$value->freight_cost;
                $claim_submission_date=$value->claim_submission_date;
                $last_date_for_lodging_claim=$value->last_date_for_lodging_claim;
                $amount_of_proceed_realized=$value->amount_of_proceed_realized;
                $shipped_on_board_date=$value->shipped_on_board_date;
                $discharge_port=$value->discharge_port;
                $insurance=$value->insurance;
                $od_sight_rate=$value->od_sight_rate;
                $total_amount=$value->total_amount;
                $realize_value=$value->realize_value;

        }

        
        $sales_contact_no=SaleContract::where('id', $id)->pluck('sales_contract_no')->toArray();
        $bank_id=SaleContract::where('id', $id)->pluck('bank_id'); 
        $year=date('Y');
        $yearSymbol=FileNumber::where('from_year', $year)->pluck('symbol')->toArray();
        $bank_short_name=Bank::where('id',$bank_id)->pluck('short_name')->toArray();
        $salesContactSerial=SaleContract::select(DB::Raw('COUNT(sale_contracts.id) AS number'))
                            ->whereYear('sale_contracts.dated','=','2020')
                            ->where('sale_contracts.id','<=','500')
                            ->first();
        $salesContactSerial=$salesContactSerial->number;
        try {

            $ref_name=$bank_short_name['0'].'-'.$sales_contact_no['0'].'/'.$yearSymbol['0'].'-'.$salesContactSerial.'-'.date("y"); 

        } catch (\Exception $e) {

           
        }
        
        $itemDetails=DB::select("SELECT
                        item_groups.item_group_name,
                        item_groups.id as item_group_id,  
                        sale_contracts.id AS sale_contract_id,
                        SUM(sale_contract_details.ctn) AS ctn,
                        SUM(sale_contract_details.net_weight_kg) AS net_weight_kg,
                        SUM(sale_contract_details.total_amount) as total_amount
                    FROM
                        sale_contracts
                    JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
                    JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                    JOIN item_groups ON item_groups.id = ci_items.item_group_id
                    WHERE sale_contracts.id = $id GROUP BY item_groups.item_group_name");

        $item_array=array();
        
        $item_groups=DB::select("SELECT
                        item_groups.item_group_name,
                        ci_items.ci_item_name,
                        COUNT(item_groups.item_group_name) AS item_group_count
                    FROM
                        sale_contracts
                    JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
                    JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                    JOIN item_groups ON item_groups.id = ci_items.item_group_id
                    WHERE sale_contracts.id = $id
                    GROUP BY item_groups.item_group_name,item_groups.item_group_name");

        foreach ($item_groups as $key => $value) {

           if($value->item_group_count>1){

               array_push($item_array, $value->item_group_name);

           }else{
               
               array_push($item_array, $value->ci_item_name);

           }                  

        }

        if(count($sale_contract_details)>0){            
            
            $ciItemClaimPercentage=0;
            $ciItemGroupTotals=DB::select("SELECT 
                SUM(sale_contract_details.total_amount) as total_amount
            FROM
                sale_contracts
            JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
            JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
            JOIN item_groups ON item_groups.id = ci_items.item_group_id
            WHERE 
                sale_contract_details.sale_contract_id=$id
            GROUP BY sale_contract_details.sale_contract_id");
            foreach ($ciItemGroupTotals as $key => $value) {
                 
              $totalAmount=$value->total_amount;

            }

            $description_of_goods='';
            for ($i=0; $i < count($item_array); $i++) { 
                
                $description_of_goods=$description_of_goods.$item_array[$i].',';

            }
            
            $rcpeDetails=DB::select("SELECT tbl.item_group_name,tbl.item_group_id,repe_details.source_type,repe_details.source_address,sum((net_weight_kg * repe_details.percentage)/100) as percentWeight, sum(repe_details.percentage) as percentage, repe_details.ingredient  FROM(SELECT
                        item_groups.id AS item_group_id,
                        item_groups.item_group_name,          
                        SUM(
                            sale_contract_details.net_weight_kg
                        ) AS net_weight_kg  
                    FROM
                        sale_contracts
                    JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
                    JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                    JOIN item_groups ON item_groups.id = ci_items.item_group_id             
                    WHERE
                        sale_contract_details.sale_contract_id = '$id'
                    GROUP BY
                        item_group_id) tbl
                    JOIN ci_items ON tbl.item_group_id=ci_items.item_group_id
                    JOIN rcpe_masters ON ci_items.receipe_id = rcpe_masters.id
                    JOIN rcpe ON rcpe.id=rcpe_masters.rcpe_fg_id
                    JOIN repe_details ON rcpe_masters.id=repe_details.rcpe_id
                    GROUP BY repe_details.ingredient");

            $sci=SCI::where('sale_contract_id', 1)->first(['amount_of_proceed_realized', 'insurance', 'see_freight','non_eligible_item_value']);
            $net_fob=$sci->amount_of_proceed_realized-$sci->freight_cost-$sci->insurance-$sci->non_eligible_item_value;

            $non_eligible_item_value=$sci->non_eligible_item_value;

            if($net_fob<0){

              $net_fob=0;
                
            }
            $productPerentageTotal=0;
            $productPercentageDetails=DB::select("SELECT
                            item_groups.item_group_name,
                            rcpe_masters.product_percentage
                        FROM
                            sale_contracts
                        JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
                        JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                        JOIN item_groups ON item_groups.id = ci_items.item_group_id
                        JOIN rcpe_masters ON ci_items.receipe_id = rcpe_masters.id
                        JOIN rcpe ON rcpe.id=rcpe_masters.rcpe_fg_id
                        JOIN repe_details ON rcpe_masters.id=repe_details.rcpe_id
                        WHERE
                            sale_contract_details.sale_contract_id =12
                        GROUP BY item_groups.item_group_name");

            foreach ($productPercentageDetails as $key => $value) {
              
               $productPerentageTotal=$productPerentageTotal+$value->product_percentage;

            }

            $countProductPercentageNunber=count($productPercentageDetails);
            if($countProductPercentageNunber==0){
             
                $avgPercentage=0;

            }else{
                
               $avgPercentage=$productPerentageTotal/$countProductPercentageNunber;

            }
            
            $localMateril=$net_fob*($avgPercentage/100);
            $imported=$net_fob-$localMateril;
            $realize_amont=$totalAmount-73135.1;
            return view('sale_contract.sci.sci_com_inv')
               ->with('ref_name', $ref_name)
               ->with('claim_submission_date', $claim_submission_date)
               ->with('last_date_for_lodging_claim', $last_date_for_lodging_claim)
               ->with('bank_name', $bank_name)
               ->with('bank_address', $bank_address)
               ->with('sale_contact_date', $sale_contact_date)
               ->with('invoice_no', $invoice_no)
               ->with('invoice_date', $invoice_date)
               ->with('importer_name', $importer_name)
               ->with('importer_address', $importer_address)
               ->with('pcs_in_ctn', $pcs_in_ctn)
               ->with('total_ctn', $total_ctn)
               ->with('exp_no', $exp_no)
               ->with('exp_date', $exp_date)
               ->with('amount_of_proceed_realized', $amount_of_proceed_realized)
               ->with('freight_cost', $freight_cost)
               ->with('shipped_on_board_date', $shipped_on_board_date)
               ->with('discharge_port', $discharge_port)
               ->with('sales_contract_no', $sale_contract_no)
               ->with('insurance', $insurance)
               ->with('od_sight_rate', $od_sight_rate)
               ->with('noneligibleItemTotal', $non_eligible_item_value)
               ->with('itemDetails', $itemDetails)
               ->with('item_array', $item_array)
               ->with('description_of_goods',$description_of_goods)
               //->with('ciItemClaimPercentage', $ciItemClaimPercentage);
               ->with('totalAmount', $totalAmount)
               ->with('rcpeDetails', $rcpeDetails)
               ->with('net_fob', $net_fob)
               ->with('localMateril', $localMateril)
               ->with('imported', $imported)
               ->with('realize_amont', $realize_amont);

        }else{

            return view('sale_contract.sci.sci_com_inv');
               
        }


    }

    public function sciDocProcess(Request $request){

        $id = base64_decode($request->query('sc_id'));
        $rowCounts = SCI::where('sale_contract_id', $id)->get();
        if($rowCounts->isEmpty()) {
            
            Session::flash("danger", "Please First Upgrade Master Book To This Invoice!");
            return redirect()->back();
        }

        try {

            $results=SCI::where('sale_contract_id', '=', $id)->get();
            $insentivePercents=InsentivePercentage::all();
            $sciMaster=SCI::where('sale_contract_id', '=', $id)->firstOrFail();
            $exp_amount=$sciMaster->exp_amount_usd;
            $salesContact=SaleContract::findorfail($id);    
            $bankInfo = Bank::where('id', $salesContact->bank_id)->first(['name', 'address']);
            $name = $bankInfo->name;
            $address = $bankInfo->address;
            $bankInfo=Bank::where('id', $salesContact->bank_id)->first(['name', 'address']);
            $importerInfo=Importer::where('id',$salesContact->importer_id)->first(['name', 'address']);
            $sales_contact_no=SaleContract::where('id', $id)->pluck('sales_contract_no')->toArray();
            $bank_id=SaleContract::where('id', $id)->pluck('bank_id'); 
            $year=date('Y');
            $yearSymbol=FileNumber::where('from_year', $year)->pluck('symbol')->toArray();
            $bank_short_name=Bank::where('id',$bank_id)->pluck('short_name')->toArray();
            $total_net_weight=\DB::table("sale_contract_details")->where('sale_contract_id',$id)->sum('net_weight_kg');

            $eligibleItemNetWeight=SCI::where('sale_contract_id','=',$id)->sum('eligibleItemNetWeight');

            $pcs_in_ctn=\DB::table("sale_contract_details")->where('sale_contract_id',$id)->sum('pcs_in_ctn');
            $salesContactSerial=SaleContract::select(DB::Raw('COUNT(sale_contracts.id) AS number'))
                                ->whereYear('sale_contracts.dated','=','2020')
                                ->where('sale_contracts.id','<=','500')
                                ->first();
            $salesContactSerial=$salesContactSerial->number;
            $ref_name=$bank_short_name['0'].'-'.$sales_contact_no['0'].'/'.$yearSymbol['0'].'-'.$salesContactSerial.'-'.date("y"); 
            $itemDetails=DB::select("SELECT
                item_groups.item_group_name,
                item_groups.id AS item_group_id,
                sale_contracts.id AS sale_contract_id,
                SUM(sale_contract_details.ctn) AS ctn,
                SUM(sale_contract_details.net_weight_kg) AS net_weight_kg,
                SUM(sale_contract_details.total_amount) AS total_amount,
                bus.name,bus.code,bus.id as bu_id
            FROM
                sale_contracts
            JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
            JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
            JOIN bus ON bus.id=ci_items.bu_id
            JOIN item_groups ON item_groups.id = ci_items.item_group_id
            WHERE
                sale_contracts.id = $id AND item_groups.id!=236
            GROUP BY
                bus.name,item_groups.item_group_name");

            $item_array=array();
            $item_groups=DB::select("SELECT
                            item_groups.item_group_name,
                            ci_items.ci_item_name,
                            COUNT(item_groups.item_group_name) AS item_group_count
                        FROM
                            sale_contracts
                        JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
                        JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                        JOIN item_groups ON item_groups.id = ci_items.item_group_id
                        WHERE sale_contracts.id = $id AND item_groups.id!=236
                        GROUP BY item_groups.item_group_name,item_groups.item_group_name");

            foreach ($item_groups as $key => $value) {

            if($value->item_group_count>1){

                array_push($item_array, $value->item_group_name);

            }else{
                
                array_push($item_array, $value->ci_item_name);

            }                  

            }

            $description_of_goods='';
            for ($i=0; $i < count($item_array); $i++) { 
                
                $description_of_goods=$description_of_goods.$item_array[$i].',';

            }

            $sci=SCI::where('sale_contract_id', $id)->first(['amount_of_proceed_realized', 'insurance', 'see_freight','non_eligible_item_value','shipped_on_board_date']);
            $non_eligible_item_value=$sci->non_eligible_item_value;
            $totalAmount=$exp_amount;
            $eligible_item_value=$totalAmount-$non_eligible_item_value;
            $freight_cost=($eligibleItemNetWeight*$sci->see_freight)/$total_net_weight;
            $freight_cost=round($freight_cost,2); 
            $realize_amont=$totalAmount-$sci->amount_of_proceed_realized;
            if($sciMaster->amount_of_proceed_realized > $totalAmount){

            $realize_amont=0; 

            }
            
            if($sci->amount_of_proceed_realized > $totalAmount){
            
            $net_fob=$sci->amount_of_proceed_realized-$freight_cost-$sci->insurance-$sci->non_eligible_item_value;

            }else{

            $net_fob=$sci->amount_of_proceed_realized-$freight_cost-$sci->insurance-$sci->non_eligible_item_value;

            }

            $productPerentageTotal=0;
            $productPercentageDetails=DB::select("SELECT
                ci_items.ci_item_code,
                ci_items.ci_item_name,
                item_groups.item_group_name,
                item_groups.id,
                product_percentages.percentage
            FROM
                sale_contract_details
            JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
            JOIN item_groups ON item_groups.id = ci_items.item_group_id
            JOIN product_percentages ON product_percentages.id=item_groups.product_percentage_id
            WHERE
                sale_contract_details.sale_contract_id=$id AND item_groups.id!=236
            GROUP BY item_groups.id");

            foreach ($productPercentageDetails as $key => $value) {
            
            $productPerentageTotal=$productPerentageTotal+$value->percentage;

            }
            
            $countProductPercentageNunber=count($productPercentageDetails);
            if($countProductPercentageNunber==0){
            
                $avgPercentage=0;

            }else{
                
            $avgPercentage=$productPerentageTotal/$countProductPercentageNunber;

            }
            $avgPercentage=round($avgPercentage,3);
            try { 

                $per_unit_freight=$salesContact->freight_cost/$total_net_weight;
                
            }catch (Exception $e){}   

            if(empty($sci->shipped_on_board_date)){  

                Session::flash("danger", "Please Upgrade Shipping Date In Master Book First!");
                return redirect()->back();
            }
            $importer_id=$salesContact->importer_id;
            $importers=Importer::where('id',$importer_id)->first();
            $notify_party_id=$salesContact->notify_pary_id;
            if($importers->name=="N/A")
            {
                    
                $notifyParty=NotifyParty::where('id',$notify_party_id)->first();
                $importer_name=$notifyParty->name;
                $importer_address=$notifyParty->address;

            }else{

                $importer_name=$importers->name;
                $importer_address=$importers->address;

            }

            return view('sale_contract.sci.ci_com_inv_upgrade')
                ->with('ref_name', $ref_name)
                ->with('claim_submission_date', $sciMaster->claim_submission_date)
                ->with('last_date_for_lodging_claim', $sciMaster->last_date_for_lodging_claim)
                ->with('bank_name', $bankInfo->name)
                ->with('bank_address', $bankInfo->address)
                ->with('sales_contract_no', $salesContact->sales_contract_no)
                ->with('sale_contact_date', $salesContact->dated)
                ->with('invoice_no', $sciMaster->invoice_no)
                ->with('invoice_date', $sciMaster->invoice_date)
                ->with('importer_name', $importerInfo->name)
                ->with('importer_address', $importerInfo->address)
                ->with('total_ctn', $sciMaster->no_of_carton_exported)
                ->with('exp_no', $sciMaster->exp_no)
                ->with('exp_date', $sciMaster->exp_date)
                ->with('amount_of_proceed_realized', $sciMaster->amount_of_proceed_realized)
                ->with('pcs_in_ctn', $pcs_in_ctn)
                ->with('freight_cost', $freight_cost)
                ->with('shipped_on_board_date', $sciMaster->shipped_on_board_date)
                ->with('discharge_port', $sciMaster->discharge_port)
                ->with('insurance', $sciMaster->insurance)
                ->with('od_sight_rate', $sciMaster->od_sight_rate)
                ->with('noneligibleItemTotal', $sciMaster->non_eligible_item_value)
                ->with('realize_amont', $realize_amont)
                ->with('itemDetails', $itemDetails)
                ->with('item_array', $item_array)
                ->with('description_of_goods',$description_of_goods)
                ->with('totalAmount', $totalAmount)
                ->with('net_fob', $net_fob)
                ->with('avgPercentage', $avgPercentage)
                ->with('insentivePercents', $insentivePercents)
                ->with('total_net_weight',$eligibleItemNetWeight)
                ->with('per_unit_freight',$per_unit_freight)
                ->with('sale_contact_id',$id)
                ->with('importer_name',$importer_name)
                ->with('importer_address',$importer_address); 
            
        } catch (\Exception $e) {
               
            // echo $e->getMessage();
            return view('error.index')->with('error',$e->getMessage());

        }    
              

    }



    public function saveComInvDetails(Request $request){
    
        $sc_id=SaleContract::where('id', $request->sale_contact_id)->pluck('id');
        $ifexist=ComInvMaster::where('sale_contact_id', $request->sale_contact_id)->pluck('id');
        $total_net_weight=\DB::table("sale_contract_details")->where('sale_contract_id',$request->sale_contact_id)->sum('net_weight_kg');
        $sc_total_net_weight=\DB::table("sale_contract_details")->where('sale_contract_id',$request->sale_contact_id)->sum('net_weight_kg');
        $salesContact=SaleContract::findorfail($request->sale_contact_id);
        $sciMaster=SCI::where('sale_contract_id', '=', $request->sale_contact_id)->firstOrFail();
        $eligibleItemNetWeight=SCI::where('sale_contract_id','=',$request->sale_contact_id)->sum('eligibleItemNetWeight');
        $salecContactId=$request->sale_contact_id;
        if(count($ifexist)>0){

            return "Exist";

        }else{

            DB::beginTransaction();
            try {
                    
                    $ad_code=SCI::where('sale_contract_id', $request->sale_contact_id)->pluck('ad_code');
                    //@@@@@@@@-----Per kg Freight----@@@@@@@@@@@@@@@@
                    $itemDetails=DB::select("SELECT
                            item_groups.item_group_name,
                            item_groups.id AS item_group_id,
                            sale_contracts.id AS sale_contract_id,
                            SUM(sale_contract_details.ctn) AS ctn,
                            SUM(sale_contract_details.net_weight_kg) AS net_weight_kg,
                            SUM(sale_contract_details.total_amount) AS total_amount,
                            bus.name,bus.code,bus.id as bu_id
                        FROM
                            sale_contracts
                        JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
                        JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                        JOIN bus ON bus.id=ci_items.bu_id
                        JOIN item_groups ON item_groups.id = ci_items.item_group_id
                        WHERE
                            sale_contracts.id = $salecContactId AND item_groups.id!=236
                        GROUP BY
                            bus.name,item_groups.item_group_name");

                    $array=array();
                    $itemGroupName=''; $totalCtn=0; $totalNetWeight=0; $subTotalCtn=0; $subTotalAmount=0; $subNetWeight=0;$subFreight=0; $subFob=0; $minus_fob_value=0;$total_amount=0;$carton_fright_pl_rate=0;$sub_total_freight=0;
                    $comInvMaster=new ComInvMaster();
                    $comInvMaster->sale_contact_id=$request->sale_contact_id;
                    $comInvMaster->invoice_no=$request->inv_no;
                    $comInvMaster->invoice_value=$request->inv_value;
                    $comInvMaster->invoice_date=$request->inv_date;
                    $comInvMaster->freight_cost=$request->freight;
                    $comInvMaster->net_fob=$request->net_fob;
                    $comInvMaster->ref_name=$request->ref_name;
                    $comInvMaster->date=date("Y-m-d", strtotime($request->date));
                    $comInvMaster->time_out=$request->time_out;
                    $comInvMaster->bank=$request->bank;
                    $comInvMaster->bank_address=$request->bank_address;
                    $comInvMaster->sc_no=$request->sc_no;
                    $comInvMaster->sc_date=$request->sc_date;
                    $comInvMaster->sc_value=$request->sc_value;
                    $comInvMaster->name_of_importer=$request->name_of_importer;
                    $comInvMaster->importer_address=$request->importer_address;
                    $comInvMaster->quantity=$request->quantity;
                    $comInvMaster->carton=$request->carton;
                    $comInvMaster->exported_value=$request->exported_value;
                    $comInvMaster->exp_no=$request->exp_no;
                    $comInvMaster->exp_date=$request->exp_date;
                    $comInvMaster->exp_value=$request->exp_value;
                    $comInvMaster->realise_value=$request->realise_value;
                    $comInvMaster->od_sight_rate=$request->od_sight_rate;
                    $comInvMaster->shipment_date=$request->shipment_date;
                    $comInvMaster->discharge_port=$request->discharge_port;
                    $comInvMaster->insurance=$request->insurance;
                    $comInvMaster->net_fob=$request->net_fob;
                    $comInvMaster->non_eligible_item=$request->non_eligible_item;
                    $comInvMaster->local_material=$request->local_material;
                    $comInvMaster->imported=$request->imported;
                    $comInvMaster->claim_usd=$request->claim_usd;
                    $comInvMaster->rate_in_usd=$request->rate_in_usd;
                    $comInvMaster->description_of_good=$request->description_of_good;
                    $comInvMaster->total_claim_bdt=$request->total_claim_bdt;
                    $comInvMaster->total_claim_bdt_main=$request->total_claim_bdt;
                    $comInvMaster->imp_update_value=round(($request->net_fob*4)/100,2);
                    $comInvMaster->user_id=Auth::user()->id;
                    $claimPercent=$this->getClaimPercent($request->shipment_date);
                    $comInvMaster->claim_percent=$claimPercent;
                    $comInvMaster->save();
                    $master_id=$comInvMaster->id;
                    $realize=$request->inv_value-$request->realise_value;
                    try { 

                        $freight_cost=$salesContact->freight_cost;
                        $per_unit_freight=$freight_cost/$sc_total_net_weight;
                    
                    }catch (Exception $e){


                    }

                    $rcpeDetails=\DB::select("SELECT tbl.*,repe_details.ingredient,repe_details.percentage,repe_details.rate,((tbl.net_weight_kg*repe_details.percentage)/100) AS percentWeight,repe_details.source_type,repe_details.source_address FROM (SELECT
                            ci_items.id AS item_id,
                            item_groups.id AS item_group_id,
                            item_groups.item_group_name,                                                            
                            SUM(
                                sale_contract_details.net_weight_kg
                            ) AS net_weight_kg,
                            ci_items.ci_item_code,
                            ci_items.ci_item_name                                      
                        FROM
                            sale_contracts
                        JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
                        JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                        JOIN item_groups ON item_groups.id = ci_items.item_group_id
                        WHERE
                            sale_contract_details.sale_contract_id =$salecContactId  AND item_groups.id != 236
                        GROUP BY ci_items.ci_item_code) tbl
                        JOIN ci_items ON ci_items.id=tbl.item_id
                        JOIN rcpe_masters ON ci_items.receipe_id = rcpe_masters.id
                        JOIN rcpe ON rcpe.id=rcpe_masters.rcpe_fg_id
                        JOIN repe_details ON rcpe_masters.id=repe_details.rcpe_id");


                    foreach($rcpeDetails as $key => $value) {
                                    
                        $comInvRecipeDetail=new ComInvRecipeDetail();
                        $comInvRecipeDetail->sale_contact_id=$sc_id['0'];
                        $comInvRecipeDetail->ingredient=$value->ingredient; 
                        $comInvRecipeDetail->percentWeight=$value->percentWeight;
                        $comInvRecipeDetail->percentage=$value->percentage; 
                        $comInvRecipeDetail->source_address=$value->source_address;
                        $comInvRecipeDetail->source_type=$value->source_type; 
                        $comInvRecipeDetail->rate=$value->rate; 
                        $comInvRecipeDetail->save();    


                    }

                    foreach($itemDetails as $key => $itemDetail) {

                        $results=DB::select("SELECT
                                    ci_items.p_net_weight,ci_items.duplicate_name as ci_item_name,ci_items.ci_item_code,item_groups.item_group_name,item_groups.id AS item_group_id,
                                    sale_contracts.id AS sale_contract_id,sale_contract_details.ctn,sale_contract_details.total_amount, bus.name as bu_name,bus.code,ci_items.bapa_rate,ci_items.bapa_old_date,ci_items.bapa_new_rate,ci_items.bapa_new_date,ci_items.ci_factor,sale_contract_details.ctn,sale_contract_details.rate_per_ctn,sale_contract_details.net_weight_kg,ci_items.bu_id as bu_id
                                FROM
                                    sale_contracts
                                JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
                                JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                                JOIN item_groups ON item_groups.id = ci_items.item_group_id
                                JOIN bus ON bus.id=ci_items.bu_id
                                WHERE
                                    sale_contracts.id = '$itemDetail->sale_contract_id' AND item_groups.id = '$itemDetail->item_group_id' AND item_groups.id!=236 AND bus.id='$itemDetail->bu_id'");

                        $lenght=count($results);
                        $i=0;
                        $m=1;
                        $total=array(); 
                        foreach($results as $key => $value) {

                                try { 

                                    if($value->ci_factor!=0){

                                    $per_net_weight_kg_fright=$per_unit_freight*$value->net_weight_kg;
                                    $caton_fright=$per_net_weight_kg_fright/$value->ctn;
                                    $carton_fright_pl_rate=round($caton_fright+$value->rate_per_ctn,3);
                                                
                                    }else{

                                    $carton_fright_pl_rate="0";

                                    }

                                    $total_amount=$total_amount+round($carton_fright_pl_rate*$value->ctn,2);
                                    $subTotalAmount=$subTotalAmount+$carton_fright_pl_rate*$value->ctn;
                                    $freight=number_format($subTotalAmount/$value->net_weight_kg,4);
                                    
                                    $shipment_date=date("Y-m-d", strtotime($sciMaster->shipped_on_board_date));
                                    $bapaOldDate=date("Y-m-d", strtotime($value->bapa_old_date));

                                    if($shipment_date<=$bapaOldDate){
                                        
                                        $bapa_rate=$value->bapa_rate;
                                        
                                    }else{

                                        $bapa_rate=$value->bapa_new_rate;

                                    }
                                    
                                    $cfr_rate=number_format($request->freight/$eligibleItemNetWeight,4)+$bapa_rate;
                                    $sub_total_freight=$sub_total_freight+$freight;

                                                        
                                }catch (Exception $e){ }

                            $item_wise_per_kg_fright=number_format($subTotalAmount/$value->net_weight_kg,3); 
                            if($cfr_rate<$item_wise_per_kg_fright){
                            
                            $fob_rate=$item_wise_per_kg_fright-$cfr_rate; 
                            $minus_fob_value=$minus_fob_value+$fob_rate*$value->net_weight_kg; 

                            }
                            
                            //@@@@@ Cfr Rate 
                            $i++;
                            $totalCtn=$totalCtn+$value->ctn;
                            $subNetWeight=$subNetWeight+$value->net_weight_kg;
                            $item_group_id=CiItem::where('ci_item_code', $value->ci_item_code)->pluck('item_group_id');
                            $item_id=CiItem::where('ci_item_code', $value->ci_item_code)->pluck('id');
                            $total_bapa_value=$bapa_rate;
                            if($i==$lenght){
                                
                                $insurance=($subNetWeight*$request->insurance)/$eligibleItemNetWeight;
                                $short_access=($subNetWeight*$realize)/$eligibleItemNetWeight;
                                $fob=($total_amount-($subNetWeight*$request->freight/$eligibleItemNetWeight)-$short_access-$minus_fob_value-$insurance);
                                $fob=round($fob,4);
                                $comInvMasterDetails=new ComInvMasterDetails();
                                $comInvMasterDetails->ad_code=$ad_code['0'];
                                $comInvMasterDetails->bu_id=$value->bu_id;
                                $comInvMasterDetails->com_inv_master_id=$master_id;
                                $comInvMasterDetails->item_group_id=$item_group_id['0'];
                                $comInvMasterDetails->total_ctn=$totalCtn;
                                $comInvMasterDetails->total_net_weight=$subNetWeight;
                                $comInvMasterDetails->total_amount=$total_amount;
                                $comInvMasterDetails->total_freight=($subNetWeight*$sciMaster->see_freight)/$eligibleItemNetWeight;
                                $comInvMasterDetails->total_net_fob=$fob;
                                $comInvMasterDetails->claim_bdt=$fob*($claimPercent/100)*$request->od_sight_rate;
                                $comInvMasterDetails->save();
                                $item_amount=0;
                                foreach($results as $key => $val) {

                                    $item_group_id=CiItem::where('ci_item_code', $val->ci_item_code)->pluck('item_group_id');
                                    $item_id=CiItem::where('ci_item_code', $val->ci_item_code)->pluck('id');

                                    try { 

                                        if($val->ci_factor!=0){

                                        $per_net_weight_kg_fright=$per_unit_freight*$val->net_weight_kg;
                                        $caton_fright=$per_net_weight_kg_fright/$val->ctn;
                                        $carton_fright_pl_rate=round($caton_fright+$val->rate_per_ctn,4);
                                                    
                                        }else{

                                        $carton_fright_pl_rate="0";

                                        }

                                        $item_amount=$item_amount+$carton_fright_pl_rate*$val->ctn;
                                                        
                                }catch (Exception $e) { }

                                    $comInvItemDetail=new ComInvItemDetail();
                                    $comInvItemDetail->com_inv_master_id=$master_id;
                                    $comInvItemDetail->bu_id=$value->bu_id;
                                    $comInvItemDetail->item_group_id=$item_group_id['0'];
                                    $comInvItemDetail->item_id=$item_id['0'];
                                    $comInvItemDetail->pack_size=$val->p_net_weight;
                                    $comInvItemDetail->carton=$val->ctn;
                                    $comInvItemDetail->net_weight=$val->net_weight_kg;
                                    $comInvItemDetail->amount=$item_amount;
                                    $comInvItemDetail->fright=$item_amount/$val->net_weight_kg;
                                    $comInvItemDetail->save();
                                    
                                }

                            }
                            $subTotalAmount=0;
                            $total_freight=0;

                        } 
                        $totalCtn=0;
                        $totalCtn=0;
                        $subNetWeight=0;
                        $totalNetWeight=0;
                        $subTotalAmount=0;
                        $i=0;
                        $minus_fob_value=0;
                        $total_amount=0;
                        $carton_fright_pl_rate=0;

                    }


                DB::commit();

                }catch (\Exception $e) {
                

                DB::rollback();
                throw $e;
            
                }
                
                return "Success";

        }
 

    }

    private function getClaimPercent($shipment_date){

        $shipment_date=date("Y-m-d", strtotime($shipment_date));
        $result = DB::table('claim_details')
                    ->select('claim_details.ci_item_claim_percentage AS claimPercent')
                    ->where('fship_date', '<=', $shipment_date)  
                    ->where('tship_date', '>=', $shipment_date)
                    ->where('claim_id', 1)
                    ->first();

        return $claimPercent=$result->claimPercent;

    }

    public function editComInvDetails(Request $request){

        $sc_id=SaleContract::where('sales_contract_no', $request->sc_no)->pluck('id');
        $comInvMaster=ComInvMaster::findOrFail($sc_id['0']);
        $comInvMaster->sale_contact_id=$sc_id['0'];
        $comInvMaster->invoice_no=$request->inv_no;
        $comInvMaster->invoice_value=$request->inv_value;
        $comInvMaster->invoice_date=$request->inv_date;
        $comInvMaster->freight_cost=$request->freight;
        $comInvMaster->net_fob=$request->net_fob;
        $comInvMaster->ref_name=$request->ref_name;
        $comInvMaster->date=$request->date;
        $comInvMaster->time_out=$request->time_out;
        $comInvMaster->bank=$request->bank;
        $comInvMaster->bank_address=$request->bank_address;
        $comInvMaster->sc_no=$request->sc_no;
        $comInvMaster->sc_date=$request->sc_date;
        $comInvMaster->sc_value=$request->sc_value;
        $comInvMaster->name_of_importer=$request->name_of_importer;
        $comInvMaster->importer_address=$request->importer_address;
        $comInvMaster->quantity=$request->quantity;
        $comInvMaster->carton=$request->carton;
        $comInvMaster->exported_value=$request->exported_value;
        $comInvMaster->exp_no=$request->exp_no;
        $comInvMaster->exp_date=$request->exp_date;
        $comInvMaster->exp_value=$request->exp_value;
        $comInvMaster->realise_value=$request->realise_value;
        $comInvMaster->od_sight_rate=$request->od_sight_rate;
        $comInvMaster->shipment_date=$request->shipment_date;
        $comInvMaster->discharge_port=$request->discharge_port;
        $comInvMaster->insurance=$request->insurance;
        $comInvMaster->net_fob=$request->net_fob;
        $comInvMaster->non_eligible_item=$request->non_eligible_item;
        $comInvMaster->local_material=$request->local_material;
        $comInvMaster->imported=$request->imported;
        $comInvMaster->claim_usd=$request->claim_usd;
        $comInvMaster->rate_in_usd=$request->rate_in_usd;
        $comInvMaster->description_of_good=$request->description_of_good;
        $comInvMaster->save();
        return "Success";


    }

    public function ciComInvList(Request $request){
        
        $from_date = date('Y-m-01'); 
        $toDate = date("Y-m-d", strtotime("last day of this month"));
        $results=\DB::select("SELECT
                com_inv_masters.id,
                com_inv_masters.invoice_no,
                com_inv_masters.invoice_value,
                com_inv_masters.net_fob,
                sale_contracts.export_no,
                companies.code as code,
                com_inv_masters.30_percent_insentive_date AS date1,
                com_inv_masters.70_percent_insentive_date AS date2,
                com_inv_masters.100_percent_insentive_date AS date3,
                SUM(com_inv_master_details.30_percent_insentive_amount) AS Amount1,
                SUM(com_inv_master_details.70_percent_insentive_amount) AS Amount2,
                SUM(com_inv_master_details.100_percent_insentive_amount) AS Amount3,
                com_inv_masters.total_claim_bdt AS total_claim,
                users.username as user,
                com_inv_masters.date as print_date
            FROM
                com_inv_masters
            JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id = com_inv_masters.id
            JOIN sale_contracts ON sale_contracts.id=com_inv_masters.sale_contact_id
            JOIN companies ON companies.id=sale_contracts.company_id
            LEFT JOIN users on users.id=com_inv_masters.user_id
            where date(com_inv_masters.date) >= '$from_date' and date(com_inv_masters.date) <='$toDate'
            GROUP BY com_inv_masters.invoice_no");
        $insentivePercentages=InsentivePercentage::all();
        $results=$this->generatePagination($results);
        $invoices=\DB::table('sale_contracts')
                ->select('sale_contracts.id','sale_contracts.invoice_no')
                ->rightJoin('com_inv_masters', 'com_inv_masters.sale_contact_id', '=', 'sale_contracts.id')
                ->get(); 
        return view('sale_contract.sci.ci_com_inv_list')
            ->with('results',$results)
            ->with('insentivePercentages',$insentivePercentages)
            ->with('invoices',$invoices);

    }


    public function ciComInvListAll(Request $request){
        
        $fromDate  =$request->from_date;
        $from_date =date('Y-m-d', strtotime($fromDate)); 
        $toDate    =$request->to_date; 
        $to_date   =date('Y-m-d', strtotime($toDate."+1 days"));    
        if($request->from_date && $request->to_date){

            $results=\DB::select("SELECT
                com_inv_masters.id,
                com_inv_masters.invoice_no,
                com_inv_masters.invoice_value,
                com_inv_masters.net_fob,
                sale_contracts.export_no,
                companies.code as code,
                com_inv_masters.30_percent_insentive_date AS date1,
                com_inv_masters.70_percent_insentive_date AS date2,
                com_inv_masters.100_percent_insentive_date AS date3,
                SUM(com_inv_master_details.30_percent_insentive_amount) AS Amount1,
                SUM(com_inv_master_details.70_percent_insentive_amount) AS Amount2,
                SUM(com_inv_master_details.100_percent_insentive_amount) AS Amount3,
                com_inv_masters.total_claim_bdt AS total_claim,
                users.username as staff_id,
                users.name as name,
                com_inv_masters.date
            FROM
                com_inv_masters
            JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id = com_inv_masters.id
            JOIN sale_contracts ON sale_contracts.id=com_inv_masters.sale_contact_id
            JOIN companies ON companies.id=sale_contracts.company_id
            LEFT JOIN users on users.id=com_inv_masters.user_id
            where date(com_inv_masters.date) >= '$from_date' and date(com_inv_masters.date) <'$to_date'
            GROUP BY com_inv_masters.invoice_no");
            $insentivePercentages=InsentivePercentage::all();
            $invoices=\DB::table('sale_contracts')
                    ->select('sale_contracts.id','sale_contracts.invoice_no')
                    ->rightJoin('com_inv_masters', 'com_inv_masters.sale_contact_id', '=', 'sale_contracts.id')
                    ->get();  

        }else{

        $results=[];
        $insentivePercentages=[];
        $results=$this->generatePaginationAll($results);
        $invoices=[];
        $fromDate='';
        $to_date='';


        }

        return view('sale_contract.sci.ci_com_inv_list_all')
            ->with('results',$results)
            ->with('insentivePercentages',$insentivePercentages)
            ->with('fromDate',$fromDate)
            ->with('invoices',$invoices)
            ->with('fromDate',$fromDate)
            ->with('to_date',$toDate);
    
    }

    public function ciIncentiveExcelUPloadview(){
    
      return view('sale_contract.sci.incentive_excel_view');

    }

    public function incentiveExcelUpload(Request $request){

        $formated_file = $request->file('formated_file');
        $this->validate($request, [
        
            "formated_file"=>"required",
        ]);   
        $path = $formated_file->getRealPath();
        $data = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
        $result_array=$this->saveIncentive($data);
        if(count($result_array)>0){

            $results=(object)$result_array;
            return view('sale_contract.sci.error_invoice')->with('results',$results);

        }else{
        
            Session::flash("success", "Uploaded Succcessfully..!! !");
            return redirect()->back();  

        }
        
    }


    private function saveIncentive($data){
        
        $not_match=array();
        foreach ($data as $key => $value) {

            $array = get_object_vars($value->date);
            $date= date("Y-m-d",strtotime($array['date']));

            $insentivePercentage=InsentivePercentage::where('percentage',$value->percent)->first(['id']);
            $insentive_percentage_id=$insentivePercentage->id;
            $comInvoiceMaster=ComInvMaster::where('invoice_no',$value->invoice)->first(['id']);
            if(!is_null($comInvoiceMaster)){
            
                $comInvoiceMasterEditId=$comInvoiceMaster->id; 
                if(!empty($comInvoiceMaster->id)){
                    switch($value->percent){

                        case 30:
                    

                           $this->getIncentive1($insentive_percentage_id,$comInvoiceMasterEditId,date("Y-m-d", strtotime($date)));
                            
                        break;
                        case 70:
            
                            $this->getIncentive2($insentive_percentage_id,$comInvoiceMasterEditId,date("Y-m-d", strtotime($date)));
            
                        break;
                        case 100:
            
                            $this->getIncentive3($insentive_percentage_id,$comInvoiceMasterEditId,date("Y-m-d", strtotime($date)));
            
                        break;
                        default:
                        return "Fail";
                    
                    }  


                } 
            
            }else{

                array_push($not_match,$value->invoice);
            }   

        }

        return $not_match;
        
    } 

    public function getIncentive1($insentive_percentage_id,$edit_id,$insentive_date){
        
        $insentive_amount_70percent = ComInvMasterDetails::where('com_inv_master_id',$edit_id)->sum('70_percent_insentive_amount');
        $insentive_amount_100percent = ComInvMasterDetails::where('com_inv_master_id',$edit_id)->sum('100_percent_insentive_amount');
        if($insentive_amount_70percent==0 && $insentive_amount_100percent==0){
        
            return "check";

        }else{
            
            //@@@@--------2nd Time Insentive can not create

            // $results=\DB::select("SELECT com_inv_master_details.30_percent_insentive_amount 
            // FROM com_inv_master_details WHERE com_inv_master_details.30_percent_insentive_amount IS NOT NULL AND com_inv_master_details.com_inv_master_id=$edit_id");
            $comInvMaster=ComInvMaster::where('id',$edit_id)->first(['total_claim_bdt', 'total_claim_bdt_main']); 
            $edit_claim_bdt_amount_total=$comInvMaster->total_claim_bdt;
            $main_claim_bdt_amount_total=$comInvMaster->total_claim_bdt_main;
            if($main_claim_bdt_amount_total==$edit_claim_bdt_amount_total){
                
                \DB::select("UPDATE com_inv_masters SET com_inv_masters.30_percent_insentive_date='$insentive_date' WHERE com_inv_masters.id=$edit_id");
                \DB::select("UPDATE com_inv_master_details SET com_inv_master_details.30_percent_insentive_amount = com_inv_master_details.claim_bdt*0.3 WHERE com_inv_master_details.com_inv_master_id=$edit_id");
                return "Success";               

            }else{


                \DB::select("UPDATE com_inv_masters SET com_inv_masters.30_percent_insentive_date='$insentive_date' WHERE com_inv_masters.id=$edit_id");

                // $new_insentive_amount_30_percent=$edit_claim_bdt_amount_total-$insentive_amount_70percent;
                
                // \DB::select("UPDATE com_inv_master_details SET com_inv_master_details.30_percent_insentive_amount = $new_insentive_amount_30_percent WHERE com_inv_master_details.com_inv_master_id=$edit_id");

                


                $results=\DB::table('com_inv_master_details')->select('id')->where('com_inv_master_id',$edit_id)->get();

                foreach($results as $key => $value) {
                    
                    $previousClaimBDTAmount=ComInvMasterDetails::where('id', $value->id)->pluck('claim_bdt');
                    $insentiveAmount70=ComInvMasterDetails::where('id', $value->id)->pluck('70_percent_insentive_amount');
                    $newClaimBDTAmount=($edit_claim_bdt_amount_total*$previousClaimBDTAmount['0'])/$main_claim_bdt_amount_total;
                    $updateClaimBDTAmount=$newClaimBDTAmount-$insentiveAmount70['0'];
                    \DB::table('com_inv_master_details')->where('id', $value->id)->update(array('30_percent_insentive_amount'=>$updateClaimBDTAmount));  
    
                }

                return "Success";


            }
            
            return "Success";

        }  
        
    }

    public function getIncentive2($insentive_percentage_id,$edit_id,$insentive_date){

        
        // $results=\DB::select("SELECT com_inv_master_details.70_percent_insentive_amount 
        //     FROM com_inv_master_details WHERE com_inv_master_details.70_percent_insentive_amount IS NOT NULL AND com_inv_master_details.com_inv_master_id=$edit_id");

        // if(count($results)>0){
        
        //     return "Fail";

        // }else{ 

            DB::select("UPDATE com_inv_masters SET com_inv_masters.70_percent_insentive_date='$insentive_date' WHERE com_inv_masters.id=$edit_id");
            DB::select("UPDATE com_inv_master_details SET com_inv_master_details.70_percent_insentive_amount = com_inv_master_details.claim_bdt*0.7 WHERE com_inv_master_details.com_inv_master_id =$edit_id");
            return "Success";

        // }

    }

    public function getIncentive3($insentive_percentage_id,$edit_id,$insentive_date){

    
        // $results=\DB::select("SELECT com_inv_master_details.100_percent_insentive_amount 
        //     FROM com_inv_master_details WHERE com_inv_master_details.100_percent_insentive_amount IS NOT NULL AND com_inv_master_details.com_inv_master_id=$edit_id");

        // if(count($results)>0){
        
        //     return "Fail";

        // }else{

        \DB::select("UPDATE com_inv_masters SET com_inv_masters.100_percent_insentive_date='$insentive_date' WHERE com_inv_masters.id=$edit_id");

        \DB::select("UPDATE com_inv_master_details SET com_inv_master_details.100_percent_insentive_amount = com_inv_master_details.claim_bdt*1 WHERE com_inv_master_details.com_inv_master_id =$edit_id");

        return "Success";
        // }   

    }

    private function generatePaginationAll($data){


        $page = Input::get('page', 1);  
        $paginate = 50;    
        $offSet = ($page * $paginate) - $paginate;  
        $parameters = Input::getQueryString();
        $parameters = preg_replace('/&page(=[^&]*)?|^page(=[^&]*)?&?/','', $parameters);
        $path = url('/') . '/ci_com_inv/list/all?' . $parameters;
        $itemsForCurrentPage = array_slice($data, $offSet, $paginate, true);  
        $results = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($data), $paginate, $page); 
        return $results = $results->withPath($path);


    }

    public function ciComInvListDownloadExcel(Request $request){

        $from_date = date('Y-m-01');
        $to_date  = date('Y-m-t'); 
        $to_date  = date('Y-m-d', strtotime( $to_date . " +1 days"));
        $results=\DB::select("SELECT
                    sale_contracts.export_no AS Exp_NO,
                    com_inv_masters.invoice_no,
                    companies.code AS Company,
                    com_inv_masters.net_fob AS Net_Fob,
                    com_inv_masters.total_claim_bdt_main AS Main_BDT,
                    SUM(com_inv_master_details.30_percent_insentive_amount) AS 30_Percent_Amount,
                    com_inv_masters.30_percent_insentive_date AS 30_Percent_Date,
                    SUM(com_inv_master_details.70_percent_insentive_amount) AS 70_Percent_Amount,
                    com_inv_masters.70_percent_insentive_date AS 70_Percent_Date,
                    SUM(com_inv_master_details.100_percent_insentive_amount) AS 100_Percent_Amount,
                    com_inv_masters.100_percent_insentive_date AS 100_Percent_Date,
                    users.username as User,
                    com_inv_masters.date as Print_Date
                FROM
                    com_inv_masters
                JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id = com_inv_masters.id
                JOIN sale_contracts ON sale_contracts.id = com_inv_masters.sale_contact_id
                JOIN companies ON companies.id = sale_contracts.company_id
                LEFT JOIN users on users.id=com_inv_masters.user_id
                where date(com_inv_masters.date) >= '$from_date' AND date(com_inv_masters.date) <'$to_date'
                GROUP BY com_inv_masters.invoice_no");

        if(count($results) > 0) {

                $array = array();
                for ($i = 0, $c = count($results); $i < $c; ++$i) {

                    $array[$i] = (array) $results[$i];
                }
                return \Excel::create('Com_Inv_List', function($excel) use ($array) {

                            $excel->sheet('mySheet', function($sheet) use ($array) {

                                $sheet->fromArray($array);
                            });
                        })->download('xls');
            }else{

                Toastr::error('No Record Available:)', 'Message');
                return redirect('/master/book');
            }  


    }

    public function ciComInvListAllDownloadExcel(Request $request,$from_date,$to_date){ 

        $from_date = date('Y-m-d', strtotime($from_date)); 
        $toDate   = date('Y-m-d', strtotime($to_date." +1 days"));
        $results=\DB::select("SELECT
                    sale_contracts.export_no AS Exp_NO,
                    com_inv_masters.invoice_no,
                    companies.code AS Company,
                    com_inv_masters.invoice_value,
                    com_inv_masters.net_fob AS Net_Fob,
                    com_inv_masters.total_claim_bdt_main AS Main_BDT,
                    com_inv_masters.total_claim_bdt AS New_BDT,
                    SUM(com_inv_master_details.30_percent_insentive_amount) AS 30_Percent_Amount,
                    com_inv_masters.30_percent_insentive_date AS 30_Percent_Date,
                    SUM(com_inv_master_details.70_percent_insentive_amount) AS 70_Percent_Amount,
                    com_inv_masters.70_percent_insentive_date AS 70_Percent_Date,
                    SUM(com_inv_master_details.100_percent_insentive_amount) AS 100_Percent_Amount,
                    com_inv_masters.100_percent_insentive_date AS 100_Percent_Date,
                    CONCAT(users.username,'-',users.name) as User,
                    com_inv_masters.date as Print_Date
                FROM
                    com_inv_masters
                JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id = com_inv_masters.id
                JOIN sale_contracts ON sale_contracts.id = com_inv_masters.sale_contact_id
                JOIN companies ON companies.id = sale_contracts.company_id
                LEFT JOIN users on users.id=com_inv_masters.user_id
                WHERE
                    date(com_inv_masters.date) >= '$from_date' AND date(com_inv_masters.date) <= '$toDate'
                GROUP BY
                    com_inv_masters.invoice_no");

        if(count($results) > 0) {

                $array = array();
                for ($i = 0, $c = count($results); $i < $c; ++$i) {

                    $array[$i] = (array) $results[$i];
                }
                return \Excel::create('Com_Inv_List_All', function($excel) use ($array) {

                            $excel->sheet('mySheet', function($sheet) use ($array) {

                                $sheet->fromArray($array);
                            });
                        })->download('xls');
            }else{

                return redirect()->back();
            }  


    }

    public function getViewCiUnposted(Request $request){
    
        return view('ci.ci_unposted');

    }

    public function unpostedCiFile(Request $request){
        
        $comInvMaster=ComInvMaster::where('invoice_no',$request->invoice_no)->first();
        if(is_null($comInvMaster)){
            
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);

        }else{
        
            $result=ComInvMaster::where('invoice_no',$request->invoice_no)->first(['id','sale_contact_id']);
            $com_inv_id=$result->id;
            $sale_contact_id=$result->sale_contact_id;
            $user_id=Auth::user()->id;
            $results=DB::select("CALL UNPOSTED_CI_DOC(?,?,?)",[$com_inv_id,$sale_contact_id,$user_id]);
            return response()->json([
                'message' => "Data Delete Successfully",
                "code"    => 200
            ]);

        }


    }

    public function editInvoiceTotalAmount(Request $request){

        $comInvMaster=ComInvMaster::findorfail($request->edit_id);
        $comInvMaster->total_claim_bdt=$request->edit_amount;
        $comInvMaster->save();
        $results=\DB::table('com_inv_master_details')->select('id')->where('com_inv_master_id','=',$request->edit_id)->get();
        return"Success";


    }

    private function generatePagination($data){

        $page = Input::get('page', 1);  
        $paginate = 30;    
        $offSet = ($page * $paginate) - $paginate;  
        $parameters = Input::getQueryString();
        $parameters = preg_replace('/&page(=[^&]*)?|^page(=[^&]*)?&?/','', $parameters);
        $path = url('/') . '/ci_com_inv/list?' . $parameters;
        $itemsForCurrentPage = array_slice($data, $offSet, $paginate, true);  
        $results = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($data), $paginate, $page); 
        return $results = $results->withPath($path);
    

    }

    public function jsonComInvSearch(Request $request){

        return $data=\DB::select("SELECT
                com_inv_masters.id,
                com_inv_masters.invoice_no,
                sale_contracts.export_no,
                com_inv_masters.invoice_value,
                com_inv_masters.net_fob,
                companies.code as code,
                com_inv_masters.30_percent_insentive_date AS date1,
                com_inv_masters.70_percent_insentive_date AS date2,
                com_inv_masters.100_percent_insentive_date AS date3,
                SUM(com_inv_master_details.30_percent_insentive_amount) AS Amount1,
                SUM(com_inv_master_details.70_percent_insentive_amount) AS Amount2,
                SUM(com_inv_master_details.100_percent_insentive_amount) AS Amount3,
                com_inv_masters.total_claim_bdt AS total_claim,
                users.username as user,
                com_inv_masters.date as print_date
            FROM
                com_inv_masters
            JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id = com_inv_masters.id
            JOIN sale_contracts ON sale_contracts.id=com_inv_masters.sale_contact_id
            JOIN companies ON companies.id=sale_contracts.company_id
            LEFT JOIN users on users.id=com_inv_masters.user_id
            WHERE com_inv_masters.invoice_no LIKE '%$request->data%' GROUP BY com_inv_masters.invoice_no LIMIT 10");

    }

    public function jsonGetInsentiveDetails(Request $request){
        
        $results=ComInvMaster::findorfail($request->insentive_percentage_id);
        return response()->json(array('ref_num' =>$results->ref_name,'date'=>$results->date));

    } 

    public function createCaseInsentive(Request $request){

        
        $insentive_percentage_id=$request->insentive_percentage_id;
        switch ($insentive_percentage_id) {
        case 1:

            return $this->createCaseINsentive1($request->insentive_percentage_id,$request->edit_id,date("Y-m-d", strtotime($request->insentive_date)));
            
        break;
        case 2:

            return $this->createCaseINsentive2($request->insentive_percentage_id,$request->edit_id,date("Y-m-d", strtotime($request->insentive_date)));
        
        break;
        case 3:

            return $this->createCaseINsentive3($request->insentive_percentage_id,$request->edit_id,date("Y-m-d", strtotime($request->insentive_date)));
            
        break;
        default:

        return "Fail";
        
        } 

    }

    public function jsonEditInsentiveDetails(Request $request){
    
        $result=ComInvMaster::where('id', $request->ref_invoice_id)
           ->update([
               'ref_name' => $request->ref_no,
               'date' => date("Y-m-d", strtotime($request->ref_date))
            ]);
        if($result==true){
        
            return response()->json(['status'=>'success']);
    
        }else{

            return response()->json(['status'=>'fail']);

        } 

    }

    public function createCaseINsentive1($insentive_percentage_id,$edit_id,$insentive_date){

        $insentive_amount_70percent = ComInvMasterDetails::where('com_inv_master_id',$edit_id)->sum('70_percent_insentive_amount');
        $insentive_amount_100percent = ComInvMasterDetails::where('com_inv_master_id',$edit_id)->sum('100_percent_insentive_amount');
        if($insentive_amount_70percent==0 && $insentive_amount_100percent==0){
        
            return "check";

        }else{
            
            //@@@@--------2nd Time Insentive can not create

            $results=\DB::select("SELECT com_inv_master_details.30_percent_insentive_amount 
            FROM com_inv_master_details WHERE com_inv_master_details.30_percent_insentive_amount IS NOT NULL AND com_inv_master_details.com_inv_master_id=$edit_id");

            if(count($results)>0){
        
                return "Fail";     ///@@@@----End---@@@@

            }else{
                            
            $comInvMaster=ComInvMaster::where('id',$edit_id)->first(['total_claim_bdt', 'total_claim_bdt_main']); 
            $edit_claim_bdt_amount_total=$comInvMaster->total_claim_bdt;
            $main_claim_bdt_amount_total=$comInvMaster->total_claim_bdt_main;

            if($main_claim_bdt_amount_total==$edit_claim_bdt_amount_total){
                
                \DB::select("UPDATE com_inv_masters SET com_inv_masters.30_percent_insentive_date='$insentive_date' WHERE com_inv_masters.id=$edit_id");
                \DB::select("UPDATE com_inv_master_details SET com_inv_master_details.30_percent_insentive_amount = com_inv_master_details.claim_bdt*0.3 WHERE com_inv_master_details.com_inv_master_id=$edit_id");
                return "Success";               

            }else{


                \DB::select("UPDATE com_inv_masters SET com_inv_masters.30_percent_insentive_date='$insentive_date' WHERE com_inv_masters.id=$edit_id");

                // $new_insentive_amount_30_percent=$edit_claim_bdt_amount_total-$insentive_amount_70percent;
                
                // \DB::select("UPDATE com_inv_master_details SET com_inv_master_details.30_percent_insentive_amount = $new_insentive_amount_30_percent WHERE com_inv_master_details.com_inv_master_id=$edit_id");

                


                $results=\DB::table('com_inv_master_details')->select('id')->where('com_inv_master_id',$edit_id)->get();

                foreach($results as $key => $value) {
                    
                    $previousClaimBDTAmount=ComInvMasterDetails::where('id', $value->id)->pluck('claim_bdt');
                    $insentiveAmount70=ComInvMasterDetails::where('id', $value->id)->pluck('70_percent_insentive_amount');
                    $newClaimBDTAmount=($edit_claim_bdt_amount_total*$previousClaimBDTAmount['0'])/$main_claim_bdt_amount_total;
                    $updateClaimBDTAmount=$newClaimBDTAmount-$insentiveAmount70['0'];
                    \DB::table('com_inv_master_details')->where('id', $value->id)->update(array('30_percent_insentive_amount'=>$updateClaimBDTAmount));  
    
                }

                return "Success";


            }
            
            return "Success";

        }

        }  
        
    }

    public function createCaseINsentive2($insentive_percentage_id,$edit_id,$insentive_date){
        
        $results=\DB::select("SELECT com_inv_master_details.70_percent_insentive_amount 
            FROM com_inv_master_details WHERE com_inv_master_details.70_percent_insentive_amount IS NOT NULL AND com_inv_master_details.com_inv_master_id=$edit_id");

        if(count($results)>0){
        
            return "Fail";

        }else{ 

            \DB::select("UPDATE com_inv_masters SET com_inv_masters.70_percent_insentive_date='$insentive_date' WHERE com_inv_masters.id=$edit_id");

            \DB::select("UPDATE com_inv_master_details SET com_inv_master_details.70_percent_insentive_amount = com_inv_master_details.claim_bdt*0.7 WHERE com_inv_master_details.com_inv_master_id =$edit_id");
            return "Success";

        }

    }

    public function createCaseINsentive3($insentive_percentage_id,$edit_id,$insentive_date){
    
        $results=\DB::select("SELECT com_inv_master_details.100_percent_insentive_amount 
            FROM com_inv_master_details WHERE com_inv_master_details.100_percent_insentive_amount IS NOT NULL AND com_inv_master_details.com_inv_master_id=$edit_id");

        if(count($results)>0){
        
            return "Fail";

        }else{

        \DB::select("UPDATE com_inv_masters SET com_inv_masters.100_percent_insentive_date='$insentive_date' WHERE com_inv_masters.id=$edit_id");

        \DB::select("UPDATE com_inv_master_details SET com_inv_master_details.100_percent_insentive_amount = com_inv_master_details.claim_bdt*1 WHERE com_inv_master_details.com_inv_master_id =$edit_id");

        return "Success";
        }   

    }




    public function getLastDateForProcedRealize(Request $request){

        $numberOfDays=DateClaim::where('status','1')->pluck('days');
        $offset=$numberOfDays['0'];
        $date=$request->realization_date;
        return $loading_claim_last_date=date('d-m-Y', strtotime("+$offset days", strtotime($date)));

    }

    public function masterBookBulkUpload(){

        return view('sale_contract.sci.master_book_bulk_update');

    }

    public function saveMasterBookUpload(Request $request)
    {
        try {
            $data = $request->data;
            if (empty($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data to save.'
                ], 400);
            }

            $savedInvoices = [];
            $notSavedInvoices = [];
            
            foreach ($data as $item) {
                try {
                    $invoiceNo = trim($item['invoice_no']);
                    $existing = DB::table('s_c_i_s')->where('invoice_no', $invoiceNo)->first();
                    if($existing) {

                        $updateData = [];

                        if (isset($item['tt_amount']) && $item['tt_amount'] !== '' && $item['tt_amount'] !== null) {
                            $updateData['tt_amount'] = (float)trim($item['tt_amount']);
                        }
                        
                        if (isset($item['realized_amount']) && $item['realized_amount'] !== '' && $item['realized_amount'] !== null) {
                            $realizedAmount = (float)trim($item['realized_amount']);
                            $updateData['amount_of_proceed_realized'] = $realizedAmount;
                            $updateData['short_realized'] = $existing->exp_amount_usd - $realizedAmount;
                        }
                        
                        if (isset($item['od_sight_rate']) && $item['od_sight_rate'] !== '' && $item['od_sight_rate'] !== null) {
                            $updateData['od_sight_rate'] = (float)trim($item['od_sight_rate']);
                        }
                        
                        if (isset($item['prc_issue_no']) && $item['prc_issue_no'] !== '' && $item['prc_issue_no'] !== null) {
                            $updateData['prc_issue_number'] = trim($item['prc_issue_no']);
                        }
                        
                        if (isset($item['tt_no']) && $item['tt_no'] !== '' && $item['tt_no'] !== null) {
                            $updateData['tt_number'] = trim($item['tt_no']);
                        }
                        
                        if (isset($item['importer_bank']) && $item['importer_bank'] !== '' && $item['importer_bank'] !== null) {
                            $updateData['importer_bank'] = trim($item['importer_bank']);
                        }
                        
                        if (isset($item['bank_address']) && $item['bank_address'] !== '' && $item['bank_address'] !== null) {
                            $updateData['bank_address'] = trim($item['bank_address']);
                        }
                        
                        if (isset($item['tt_date']) && !empty(trim($item['tt_date']))) {
                            $updateData['tt_date'] = date('Y-m-d', strtotime(trim($item['tt_date'])));
                        }
                        
                        if (isset($item['proceeds_date']) && !empty(trim($item['proceeds_date']))) {
                            $updateData['proceeds_realization_date'] = date('Y-m-d', strtotime(trim($item['proceeds_date'])));
                        }
                        
                        if (!empty($updateData)) {
                            DB::table('s_c_i_s')
                                ->where('id', $existing->id)
                                ->update($updateData);
                        }
                        
                        $savedInvoices[] = $invoiceNo;
                        
                    } else {
                        $notSavedInvoices[] = $invoiceNo;
                    }

                } catch (\Exception $e) {
                    $invoiceNo = isset($item['invoice_no']) ? trim($item['invoice_no']) : 'Unknown';
                    $notSavedInvoices[] = $invoiceNo;
                }
            }

            $savedCount = count($savedInvoices);
            $notSavedCount = count($notSavedInvoices);
            
            if ($savedCount > 0 && $notSavedCount == 0) {
                $message = 'All ' . $savedCount . ' records updated successfully.';
            } elseif ($savedCount > 0 && $notSavedCount > 0) {
                $message = $savedCount . ' records updated. ' . $notSavedCount . ' invoices not found in database.';
            } elseif ($savedCount == 0 && $notSavedCount > 0) {
                $message = 'No matching invoices found in database.';
            } else {
                $message = 'No records to update.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'saved_invoices' => $savedInvoices,
                'not_saved_invoices' => $notSavedInvoices
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function jsonGetOverDue(Request $request){
        
        $numberOfDays=OverDue::where('status','1')->pluck('days');
        $offset=$numberOfDays['0'];
        $date=$request->shipped_on_board_date;
        return $over_due_date=date('d-m-Y', strtotime("+$offset days", strtotime($date)));

    }


    public function getLastccq($sale_contract_id){
        
       return SaleContractDetail::where('sale_contract_id',$sale_contract_id)->orderBy('id','desc')->first()->ccq;

    }

    public function inactiveSalesContact(Request $request)
    {
        $sc = SaleContract::where('id', $request->scid)->first();

        if (!$sc) {
            return response()->json([
                'code' => 404,
                'msg'  => 'Sales Contract not found!'
            ]);
        }

        if ($sc->matching_status == 2) {
            return response()->json([
                'code' => 403,
                'msg'  => 'Cannot inactivate. Approval mail already sent.'
            ]);
        }

        // Safe way to inactivate
        $sc->inactive = 'Y';
        if ($sc->save()) {
            return response()->json([
                'code' => 200,
                'msg'  => 'Sales Contract successfully inactivated.'
            ]);
        }

        return response()->json([
            'code' => 500,
            'msg'  => 'Failed to inactivate Sales Contract!'
        ]);
    }

    public function deleteSalesContact($sale_contact_id, $party_id){

        if(SaleContract::where('id',\Crypt::decrypt($sale_contact_id))->where('matching_status',2)->count()>0){
            Session::flash("danger", "Already send your approval mail..!!!");
            return redirect('/notify/party/list/desk/'.$party_id);  
        }
        SaleContract::where('id',\Crypt::decrypt($sale_contact_id))->update(['inactive'=>'Y']);
        LandPortDashboard::where('sc_id',\Crypt::decrypt($sale_contact_id))->delete();
        seaPortdashboard::where('sc_id',\Crypt::decrypt($sale_contact_id))->delete();                                        
        Session::flash("danger", "Deleted Succcessfully..!! !");
        return redirect('/notify/party/list/desk/'.$party_id); 

    }

   

    public function returnDirect($sale_contact_id,$party_id){
    
        $user_id=Auth::user()->id; 
        $dsale_contact_id=\Crypt::decrypt($sale_contact_id);
        $dparty_id=\Crypt::decrypt($party_id);
        $sale_contract = SaleContract::find($dsale_contact_id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$dsale_contact_id)->get(); 
        return redirect("/view/sale_contact/".\Crypt::encrypt($dsale_contact_id).'/'.\Crypt::encrypt($dparty_id));

    }

    public function deleteSalesContactItem(Request $request)
    {
        try {

            $ids = explode(",", $request->ids);
            $sale_contract_id = $request->sale_contract_no;
            $mailStatus = DB::table("sale_contracts")
                ->where('id', $sale_contract_id)
                ->value('mail_status');

            if($mailStatus === 'Y') {

                $restrictedIds = DB::table("sale_contract_details")
                    ->whereIn('id', $ids)
                    ->whereIn('rate_status', ['M', 'E', 'S'])
                    ->pluck('id')
                    ->toArray();
                
                $allowedIds = array_diff($ids, $restrictedIds);
                if (empty($allowedIds)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Nothing to delete. All selected items are already sent for approval (rate_status: M, E, S).'
                    ], 422);
                }
                
                $deletedCount = DB::table("sale_contract_details")
                    ->whereIn('id', $allowedIds)
                    ->delete();
                
                $results = DB::select("
                    SELECT
                        COALESCE(SUM(ctn), 0) as ctn,
                        COALESCE(SUM(total_amount_acc), 0) AS total_amount_acc,
                        COALESCE(SUM(total_amount_party), 0) AS total_amount_party,
                        COALESCE(SUM(total_amount), 0) AS total_amount,
                        COALESCE(SUM(total_cbm), 0) AS total_cbm,
                        COALESCE(SUM(gross_weight_kg), 0) AS gross_weight_kg,
                        COALESCE(SUM(pcs_in_ctn), 0) AS pcs_in_ctn
                    FROM sale_contract_details
                    WHERE sale_contract_id = ?
                ", [$sale_contract_id]);
                
                $result = !empty($results) ? $results[0] : null;
                $message = $deletedCount . ' item(s) deleted successfully.';
                if (!empty($restrictedIds)) {
                    $message .= ' ' . count($restrictedIds) . ' item(s) skipped (rate_status: M, E, S).';
                }
                
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'totals' => [
                        'total_ctn' => !empty($result) ? (float) $result->ctn : 0,
                        'total_amount_acc' => !empty($result) ? (float) $result->total_amount_acc : 0,
                        'total_amount_party' => !empty($result) ? (float) $result->total_amount_party : 0,
                        'total_amount' => !empty($result) ? (float) $result->total_amount : 0,
                        'total_cbm' => !empty($result) ? (float) $result->total_cbm : 0,
                        'total_gross_weight_kg' => !empty($result) ? (float) $result->gross_weight_kg : 0,
                        'pcs_in_carton' => !empty($result) ? (float) $result->pcs_in_ctn : 0
                    ],
                    'deleted_count' => $deletedCount,
                    'restricted_count' => count($restrictedIds)
                ]);
                
            } else {

                $deletedCount = DB::table("sale_contract_details")
                    ->whereIn('id', $ids)
                    ->delete();
                
                $results = DB::select("
                    SELECT
                        COALESCE(SUM(ctn), 0) as ctn,
                        COALESCE(SUM(total_amount_acc), 0) AS total_amount_acc,
                        COALESCE(SUM(total_amount_party), 0) AS total_amount_party,
                        COALESCE(SUM(total_amount), 0) AS total_amount,
                        COALESCE(SUM(total_cbm), 0) AS total_cbm,
                        COALESCE(SUM(gross_weight_kg), 0) AS gross_weight_kg,
                        COALESCE(SUM(pcs_in_ctn), 0) AS pcs_in_ctn
                    FROM sale_contract_details
                    WHERE sale_contract_id = ?
                ", [$sale_contract_id]);
                
                $result = !empty($results) ? $results[0] : null;
                return response()->json([
                    'success' => true,
                    'message' => $deletedCount . ' item(s) deleted successfully.',
                    'totals' => [
                        'total_ctn' => !empty($result) ? (float) $result->ctn : 0,
                        'total_amount_acc' => !empty($result) ? (float) $result->total_amount_acc : 0,
                        'total_amount_party' => !empty($result) ? (float) $result->total_amount_party : 0,
                        'total_amount' => !empty($result) ? (float) $result->total_amount : 0,
                        'total_cbm' => !empty($result) ? (float) $result->total_cbm : 0,
                        'total_gross_weight_kg' => !empty($result) ? (float) $result->gross_weight_kg : 0,
                        'pcs_in_carton' => !empty($result) ? (float) $result->pcs_in_ctn : 0
                    ],
                    'deleted_count' => $deletedCount
                ]);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function checkInvoiceNumberExistOrNot(Request $request){

        $invoice_no = str_replace('/', '-', $request->invoice_no);
        $id = $request->id;    
        $exists = SaleContract::where('invoice_no', $invoice_no)
            ->where('inactive', 'N')
            ->exists();
        return $exists ? 1 : 0;

    }

    public function checkInvoiceNumberExistOrNotOnEdit(Request $request){

        $invoice_no = str_replace('/', '-', $request->invoice_no);
        $id = $request->id;    
        $exists = SaleContract::where('invoice_no', $invoice_no)
            ->where('inactive', 'N')
            ->where('id', '!=', $id)
            ->exists();
        return $exists ? 1 : 0;

    }

    public function getViewFreightRevise(){

        
        $notifyParties=NotifyParty::all();
        return view('freight_revise.index',compact('notifyParties'));
        
    }

    public function getPatyWiseSCList(Request $request){
         
        $results=DB::select("SELECT
                    sc.id,
                    sc.invoice_no,
                    case when flh.message='Success' then 'Yes' else 'No' end as message
                    FROM sale_contracts sc
                    LEFT JOIN freight_log_historys flh ON flh.sc_id = sc.id
                    LEFT JOIN (
                                SELECT
                                sc_id,
                                MIN(id) AS min_id
                                FROM freight_log_historys
                                WHERE message IS NOT NULL
                                GROUP BY sc_id
                            ) flh_min ON flh_min.sc_id = flh.sc_id
                WHERE sc.notify_pary_id = '$request->party_id'
                    AND sc.created_at >= DATE_SUB(NOW(), INTERVAL 48 MONTH)
                    AND sc.inactive='N'
                    AND (flh.id = flh_min.min_id OR flh.id IS NULL)");

        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"    => $results 
            ]);

        } else  {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"    => []
            ]);

        }
       

    }

    public function checkBill($id){
        
       $results=DB::select("SELECT
            sale_contracts.invoice_no            as invoice,
            case when sales_terms.name='FOB'     then 'FOB'
            when sales_terms.name='CFR'  then 'CFR'
            when sales_terms.name='CPT'  then 'CFR'
            when sales_terms.name='CIF'  then 'CFR'
            when sales_terms.name LIKE '%FOB%' THEN 'FOB'
            when sales_terms.name LIKE '%CFR%' THEN 'CFR'
            else 'FOB' end                       as sales_term,
            companies.code2                      as company_id,
            sale_contracts.qtan_freight_cost as freight_cost,
            sale_contracts.total_container as containter_qty,
            case when container_1 then container_1
            when container_2 then container_2
            when container_3 then container_3
            else '' end AS container_size,
            cnf.job_no as job_no,
            cnf.sb_no as sbn_no,
            container_qty_1 as container_qty_20ft,
            container_qty_2 as container_qty_40ft,
            container_qty_3 as container_qty_40hc,
            case when cnf.depot_id then cnf.depot_id else 1 end as depot
        from sale_contracts
        join sales_terms on sales_terms.id=sale_contracts.sales_term_id
        join companies on companies.id=sale_contracts.company_id
        left join cnf on cnf.sale_contract_id=sale_contracts.id
        where sale_contracts.id=$id");
        $total=$this->total_value($id);
        if(count($results)>0){
              
          foreach ($results as $key => $value) {
               
            $company_id=$value->company_id;
            $invoice_number=$value->invoice;
            $container_qty=$value->containter_qty;
            $charge=$value->freight_cost; 
            $container_size=$value->container_size;
            $sales_term=$value->sales_term;
            $job_no=$value->job_no ? $value->job_no : 1;
            $sbn_no=$value->sbn_no ? $value->sbn_no : 1;
            $container_qty_20ft=$value->container_qty_20ft;
            $container_qty_40ft=$value->container_qty_40ft;
            $container_qty_40hc=$value->container_qty_40hc;
            $depot=$value->depot ? $value->depot : 1;
            $total_ctn=$total->total_ctn;
            $total_weight=$total->total_weight;

            $url = 'http://runner.prangroup.com:9001/app/prg/invoices/job';
            $url .= '?company_id=' . urlencode($company_id);
            $url .= '&invoice_number=' . urlencode($invoice_number);
            $url .= '&container_quantity=' . urlencode($container_qty);
            $url .= '&charges=' . urlencode($charge);
            $url .= '&container_size=' . urlencode($container_size);
            $url .= '&sales_term=' . urlencode($sales_term);
            $url .= '&job_no=' . urlencode($job_no);
            $url .= '&sbn_no=' . urlencode($sbn_no);
            $url .= '&container_qty_20ft=' . urlencode($container_qty_20ft);
            $url .= '&container_qty_40ft=' . urlencode($container_qty_40ft);
            $url .= '&container_qty_40hc=' . urlencode($container_qty_40hc);
            $url .= '&depot=' . urlencode($depot);
            $url .= '&ctn_qty=' . urlencode($total_ctn);
            $url .= '&total_weight=' . urlencode($total_weight);            
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
            if($outputMsg!='Success'){
               
                return response()->json(['message'=>$outputMsg,'code'=>409]);
                
            }else{

                FreightLogHistory::where('sc_id',$id)->delete(); 
                return response()->json(['message'=>"Done,You can update now",'code'=>200]);

            }

          }

        }
  
    }

    public function reviseFreight(Request $request){
           
        return $this->checkBill($request->revise_id);

    }

    public function getPartyLastShipmentHistory(Request $request){
         
        // $salesContract = SaleContract::where('notify_pary_id', $request->notify_pary_id)
        //                 ->orderBy('id', 'desc')
        //                 ->first(['loading_place_id', 'discharge_port', 'final_destination']);

        // $loadingPlaces = LoadingPlace::select('id')
        //                 ->selectRaw("CONCAT(loading_places.name, '/', loading_places.saddress) as address")
        //                 ->get();

        
                        
        // $loading_place_id="";                
        // $discharge_port="";                
        // $final_destination="";   

        $importer_name=SaleContract::where('importer_id',$request->importer_id)->orderBy('id', 'desc')->limit(1)->value('importer_name') ? SaleContract::where('importer_id',$request->importer_id)->orderBy('id', 'desc')->limit(1)->value('importer_name') : Importer::where('id', $request->importer_id)->value('name');             
        $importer_address=SaleContract::where('importer_id',$request->importer_id)->orderBy('id', 'desc')->limit(1)->value('importer_address') ? SaleContract::where('importer_id',$request->importer_id)->orderBy('id', 'desc')->limit(1)->value('importer_address') : Importer::where('id', $request->importer_id)->value('address');        
        return response()->json([
            'importer_name'=>$importer_name,
            'importer_address'=>$importer_address
        ],200); 

    }

    public function sales_contract(){

        // $party_id=\Crypt::decrypt($party_id); 
        $party_id=1; 
        $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');
        $countries=Country::all();
        $sales_terms=SalesTerm::all();
        $companies=Company::all();
        $banks=Bank::all();
        $importers=Importer::all();
        $notify_parties=NotifyParty::whereIn('id',$notify_party_ids)->get();
        $carrying_modes=CarryingMode::all();
        $loading_places=LoadingPlace::all();
        $bank_importers = BankImporter::pluck('bank_name', 'id')->mapWithKeys(function ($bankName, $id) {
            return [$id => str_replace('BANK NAME: ', '', $bankName)];
        });
        $currency=CurrencySetup::all();   
        $party_name= SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('party_name') ? SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('party_name') : NotifyParty::where('id',$party_id)->value('name');
        $party_address= SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('party_address') ? SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('party_address') : NotifyParty::where('id',$party_id)->value('address');             
        $also_notify_party= SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('third_notify_party') ? SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('third_notify_party') : ''; 
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'");  
        $templateNames=TemplateMaster::all();                        
        return view("sale_contract.sale_contract_create2")
             ->with("countries" ,$countries)
             ->with("sales_terms" ,$sales_terms)
             ->with("companies" ,$companies)
             ->with("banks" ,$banks)
             ->with("importers" ,$importers)
             ->with("notify_parties" ,$notify_parties)
             ->with("carrying_modes" ,$carrying_modes)
             ->with("bank_importers" ,$bank_importers)
             ->with("loading_places" ,$loading_places)
             ->with("currency" ,$currency)
             ->with("party_name" ,$party_name)
             ->with("party_address" ,$party_address)
             ->with("also_notify_party" ,$also_notify_party)
             ->with("notifyParties" ,$notifyParties)
             ->with('templateNames',$templateNames)
             ->with('id', $party_id);

    }

    public function getNotifyParties()
    {
       
        $userId = Auth::user()->id;
        $notifyPartyIds = NotifyPartyUser::where('user_id', $userId)->where('status', '1')->pluck('notify_party_id');
        $notifyParties = NotifyParty::select('code', 'name', 'ref_name')
            ->whereIn('id', $notifyPartyIds->toArray())
            ->orderBy('code')
            ->get();
            
        return response()->json(['data' => $notifyParties]);
    }

    public function softDelete($id, $party_id)
    {
        try {
            // Decrypt the IDs
            $decryptedId = Crypt::decrypt($id);
            $decryptedPartyId = Crypt::decrypt($party_id);
            
            // Find the sales contract
            $saleContract = SaleContract::where('id', $decryptedId)
                ->where('notify_pary_id', $decryptedPartyId)
                ->first();
            
            if (!$saleContract) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sales contract not found.'
                ], 404);
            }
            
            // Check if contract is already posted (cannot delete posted contracts)
            if ($saleContract->approver_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete a posted sales contract.'
                ], 403);
            }
            
            // Check if already inactive
            if ($saleContract->inactive === 'Y') {
                return response()->json([
                    'success' => false,
                    'message' => 'Sales contract is already inactive.'
                ], 400);
            }
            
            // Update the inactive status
            $updated = SaleContract::where('id', $decryptedId)
                ->where('notify_pary_id', $decryptedPartyId)
                ->update([
                    'inactive' => 'Y',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            
            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sales contract marked as delete successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete sales contract status.'
                ], 500);
            }
            
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid contract ID.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating sales contract: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deskPost($sale_contact_id, $party_id)
    {
        try {

            $id = \Crypt::decrypt($sale_contact_id);
            $decryptedPartyId = \Crypt::decrypt($party_id);
            $sale_contract = SaleContract::where('id', $id)
                ->where('notify_pary_id', $decryptedPartyId)
                ->first();
            
            if (!$sale_contract) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sales contract not found.'
                ], 404);
            }
            
            // Check if already desk posted
            if ($sale_contract->desk_approver_id != null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sales contract is already desk posted.'
                ], 400);
            }
            
            // Check if already comm posted
            if ($sale_contract->approver_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sales contract is already comm posted.'
                ], 400);
            }
            
            // Check if inactive
            if ($sale_contract->inactive === 'Y') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot desk post an inactive sales contract.'
                ], 400);
            }
            
            // Update as desk posted
            $sale_contract->desk_approver_id = Auth::user()->id;
            $sale_contract->desk_approve_at = Carbon::now(); 
            $sale_contract->save();
            
            // Call your existing methods
            $this->createCiEditHisroy($id);
            $this->ci_make_price_same2($id); 
            $this->sendDeskApprovalMail($id, $sale_contract->notify_pary_id);
            return response()->json([
                'success' => true,
                'message' => 'Sales contract marked as Desk Posted successfully!'
            ]);
            
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid contract ID.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating sales contract: ' . $e->getMessage()
            ], 500);
        }
    }
    

}
