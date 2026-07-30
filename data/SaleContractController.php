<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
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
use App\NotifyPartyItem;
use Excel;
use DB;
use App\NotifyPartyUser;
use App\Mail\SalesContactMail;
use Mail;
use App\FileNumber;
use App\SCI;
use Brian2694\Toastr\Facades\Toastr;
class SaleContractController extends Controller{


    public function __construct(){

       $this->middleware('auth');

    }

  
   // desk sale_contract_list
    public function index(Request $request, $id){
        
        $sale_contracts = SaleContract::where('notify_pary_id',$id)->get();
        return view("sale_contract.sci.sale_contract_desk_list",compact("sale_contracts"))->with('party_id',$id);
    }

     // desk  access
    public function access_notify_party_list(Request $request){
 
        $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');
        $notify_parties = NotifyParty::whereIn('id',$notify_party_ids)->get();  
        return view("sale_contract.access_notify_party_list")->with('notify_parties',$notify_parties);
    }

    public function sale_contract_ci_doc(){
         
        $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');
        $notify_parties = NotifyParty::whereIn('id',$notify_party_ids)->get();
        $sale_contracts = SaleContract::whereIn('notify_pary_id',$notify_party_ids)->where('desk_approve_at','!=',null)->get();
        return view("sale_contract.sci.sale_contract_list",compact("sale_contracts"))
                ->with('notify_parties', $notify_parties);
    }

    public function sale_contract_ci_doc_list($id){

         $sale_contracts = SaleContract::where('notify_pary_id',$id)
                                        ->where('desk_approve_at','!=',null)
                                        ->get();
        return view("sale_contract.sci.sale_contract_desk_list",compact("sale_contracts"))
        ->with('party_id',$id);     

    }


    public function sale_contract_ci(){

        //$sale_contracts = SaleContract::where('approved_at','!=',null)->get();
        $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');
        $notify_parties = NotifyParty::whereIn('id',$notify_party_ids)->get();
        return view("sale_contract.sci.sale_contract_list",compact("sale_contracts"))->with('notify_parties', $notify_parties);
    }
   
    

    public function create(Request $request,$id){
     
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
             ->with('id', $request->id);
             
    }


    public function store(Request $request){
         
        $user_id=Auth::user()->id;
        $this->validate($request, [
           "sales_contract_no"=>"nullable|max:191",
           "dated"=>"required|date",
           "country_id"=>"required|numeric|exists:countries,id",
           "sales_term_id"=>"required|numeric|exists:sales_terms,id",
           "company_id"=>"required|numeric|exists:companies,id",
           "bank_id"=>"required|numeric|exists:banks,id",
           "importer_id"=>"required|numeric|exists:importers,id",
           "bank_importer_id"=>"required|numeric|exists:bank_importers,id",
           "notify_pary_id"=>"required|numeric|exists:notify_parties,id",
           "carrying_mode_id"=>"required|numeric|exists:carrying_modes,id",
           "loading_place_id"=>"required|numeric|exists:loading_places,id",
           "final_destination"=>"required|max:191",

        ]);

        $company_bank = CompanyBank::where('company_id',$request->company_id)->where('bank_id',$request->bank_id)->first();
        $account_number   = $company_bank->account_number;
        $sale_contract = new SaleContract;
        $sale_contract->sales_contract_no=$request->sales_contract_no;
        $sale_contract->dated=date("Y-m-d",strtotime($request->dated));
        if($request->invoice_no == ''){
            $sale_contract->invoice_no=$request->sales_contract_no;
        }else{
            $sale_contract->invoice_no = $request->invoice_no; 
        }
        if($request->invoice_date){
        $sale_contract->invoice_date=date("Y-m-d",strtotime($request->invoice_date));
        }
        $sale_contract->export_no=$request->export_no;
        $sale_contract->ci_note=$request->ci_note;
        if($request->export_date){
        $sale_contract->export_date= date("Y-m-d",strtotime($request->export_date));
        }
        $sale_contract->discharge_port=$request->discharge_port;
        $sale_contract->country_id=$request->country_id;
        $sale_contract->sales_term_id=$request->sales_term_id;
        $sale_contract->company_id=$request->company_id;
        $sale_contract->bank_id=$request->bank_id;
        $sale_contract->account_number=$account_number;
        $sale_contract->importer_id=$request->importer_id;
        $sale_contract->bank_importer_id=$request->bank_importer_id;
        $sale_contract->notify_pary_id=$request->notify_pary_id;
        $sale_contract->carrying_mode_id=$request->carrying_mode_id;
        $sale_contract->loading_place_id=$request->loading_place_id;
        $sale_contract->final_destination=$request->final_destination;
        $sale_contract->container=$request->container;
        $sale_contract->container_1=$request->container_1;
        $sale_contract->container_2=$request->container_2;
        $sale_contract->container_3=$request->container_3;
        $sale_contract->freight_cost_1 = $request->freight_cost_1;
        $sale_contract->freight_cost_2 = $request->freight_cost_2;
        $sale_contract->freight_cost_3 = $request->freight_cost_3;
        $sale_contract->freight_cost = $request->freight_cost_1 + $request->freight_cost_2 + $request->freight_cost_3;
        $sale_contract->desk_freight_cost= $request->freight_cost_1 + $request->freight_cost_2 + $request->freight_cost_3;
        $sale_contract->terms_and_condition = $request->terms_and_condition;
        $sale_contract->terms_and_condition_desk_inv = $request->terms_and_condition_desk_inv;
        $sale_contract->importer_country  = $request->importer_country ;
        $sale_contract->angikar_given_by  = $request->angikar_given_by ;
        $sale_contract->is_revised  = $request->is_revised ;
        $sale_contract->is_master  = $request->is_master ;
        $sale_contract->is_proforma_invoice =$request->is_proforma_invoice;
        $sale_contract->footer_importer_address =$request->footer_importer_address;
        $sale_contract->third_notify_party =$request->third_notify_party;
        $sale_contract->creator_id = Auth::user()->id;
        $sale_contract ->save();
        $sale_contract = SaleContract::orderBy('id','desc')->first(); 
        if($request->hasFile('formated_file')) {

            $formated_file = $request->file('formated_file');
            $path = $formated_file->getRealPath();
            $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
            $this->save_excel($sale_contract->id,$datas, $request->notify_pary_id);    
        }  
        $this->manageFreight($sale_contract->id);
        $this->manageCCQ($sale_contract->id);
        Session::flash('party_id', $request->notify_id);
        Session::flash('sale_contract_no', $request->sale_contract_no);
        Session::flash("success", "Created Succcessfully !");
        return redirect('/notify/party/list/desk/'.$request->notify_id);

    }

    public function edit(Request $request, $id){

        $sale_contract = SaleContract::find($id); 
        if($sale_contract ->approver_id){
            Session::flash("danger", "Already Approved !");
            return redirect()->back();
        }

        $countries=Country::all();
        $sales_terms=SalesTerm::all();
        $companies=Company::all();
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
             ->with('party_id', $request->party_id)
             ->with('sale_contract_no', $request->sale_contract_no);

        
    }

    public function update(Request $request, $id) {
        
       
        // $this->validate($request, [f
        //    "sales_contract_no"=>"nullable|max:191",
        //    "dated"=>"required|date",
        //    "country_id"=>"required|numeric|exists:countries,id",
        //    "sales_term_id"=>"required|numeric|exists:sales_terms,id",
        //    "company_id"=>"required|numeric|exists:companies,id",
        //    "bank_id"=>"required|numeric|exists:banks,id",
        //    "importer_id"=>"required|numeric|exists:importers,id",
        //    "bank_importer_id"=>"required|numeric|exists:bank_importers,id",
        //    "notify_pary_id"=>"required|numeric|exists:notify_parties,id",
        //    "carrying_mode_id"=>"required|numeric|exists:carrying_modes,id",
        //    "loading_place_id"=>"required|numeric|exists:loading_places,id",
        //    "final_destination"=>"required|max:191"

        // ]); 
        if(!empty($request->insurance_charge) && !empty($request->pallet_charge)){

            Session::flash("danger", "Insurance & Pallet Charge Is Not Allow Same Time..!!");
            Session::flash('party_id', $request->party_id);
            Session::flash('sale_contract_no', $request->sale_contract_no);
            return redirect()->back();
        }
        
        if($request->insurance_charge){
           if(empty($request->desk_freight_cost)){

              Session::flash("danger", "First Enter Desk Freight Cost..!!");
              Session::flash('party_id', $request->party_id);
              Session::flash('sale_contract_no', $request->sale_contract_no);
              return redirect()->back(); 

           }
        }

        $company_bank = CompanyBank::where('company_id',$request->company_id)->where('bank_id',$request->bank_id)->first();
        $account_number   = $company_bank->account_number;
        $sale_contract = SaleContract::find($id); 
        if($sale_contract ->approver_id){

            Session::flash("danger", "Already Approved !");
            Session::flash('party_id', $request->party_id);
            Session::flash('sale_contract_no', $request->sale_contract_no);
            return redirect()->back();

        }else{

            $sale_contract->sales_contract_no=$request->sales_contract_no;
            $sale_contract->dated=date("Y-m-d",strtotime($request->dated));
            $sale_contract->invoice_no=$request->invoice_no;
            if($request->invoice_date){

                $sale_contract->invoice_date=date("Y-m-d",strtotime($request->invoice_date));

            }else{

                $sale_contract->invoice_date='';
            }
            $sale_contract->export_no=$request->export_no;
            $sale_contract->ad_code=$request->ad_code; 
            $sale_contract->ci_note=$request->ci_note;
            if($request->export_date){
                $sale_contract->export_date= date("Y-m-d",strtotime($request->export_date));
            }
            $sale_contract->discharge_port=$request->discharge_port;
            $sale_contract->country_id=$request->country_id;
            $sale_contract->sales_term_id=$request->sales_term_id;
            $sale_contract->company_id=$request->company_id;
            $sale_contract->bank_id=$request->bank_id;
            $sale_contract->account_number=$account_number;
            $sale_contract->importer_id=$request->importer_id;
            $sale_contract->bank_importer_id=$request->bank_importer_id;
            $sale_contract->notify_pary_id=$request->notify_pary_id;
            $sale_contract->carrying_mode_id=$request->carrying_mode_id;
            $sale_contract->loading_place_id=$request->loading_place_id;
            $sale_contract->final_destination=$request->final_destination;
            $sale_contract->container=$request->container;
            $sale_contract->container_1=$request->container_1;
            $sale_contract->container_2=$request->container_2;
            $sale_contract->container_3=$request->container_3;
            $sale_contract->freight_cost_1 = $request->freight_cost_1;
            $sale_contract->freight_cost_2 = $request->freight_cost_2;
            $sale_contract->freight_cost_3 = $request->freight_cost_3;
            if($request->freight_cost_1 > 0 || $request->freight_cost_2  > 0 || $request->freight_cost_3  > 0){
              $sale_contract->freight_cost = $request->freight_cost_1 + $request->freight_cost_2 + $request->freight_cost_3;
            }else{
              $sale_contract->freight_cost = $request->freight_cost;              
            }
            $sale_contract->terms_and_condition = $request->terms_and_condition;
            $sale_contract->terms_and_condition_desk_inv = $request->terms_and_condition_desk_inv;

            $sale_contract->bl_no  = $request->bl_no ;
            if($request->bl_date){
                $sale_contract->bl_date=date("Y-m-d",strtotime($request->bl_date));
            }
            $sale_contract->importer_country  = $request->importer_country ;
            $sale_contract->angikar_given_by  = $request->angikar_given_by ;
            $sale_contract->desk_freight_cost =$request->desk_freight_cost;
            $sale_contract->is_revised  = $request->is_revised ;
            $sale_contract->is_master  = $request->is_master ;
            $sale_contract->tr_report_date=$request->tr_report_date;
            $sale_contract->phyto_product_name=$request->phyto_product_name;
            $sale_contract->is_proforma_invoice =$request->is_proforma_invoice;
            $sale_contract->footer_importer_address =$request->footer_importer_address;
            $sale_contract->is_notify_also_notity =$request->is_notify_also_notity;
            $sale_contract->vehicle =$request->vehicle;
            $sale_contract->revise_product_name =$request->revise_product_name;
            $sale_contract->factory_address_type=$request->factory_address_type_id;
            $sale_contract->third_notify_party =$request->third_notify_party;
            $sale_contract->insurance_charge =$request->insurance_charge;
            $sale_contract->pallet_charge =$request->pallet_charge;
            $sale_contract->save();
            $this->manageFreight($id);
            $this->manageCCQ($id);
            if($request->hasFile('formated_file')) {

                $formated_file = $request->file('formated_file');
                $path = $formated_file->getRealPath();
                $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
                $this->save_excel($id, $datas, $request->notify_pary_id);    
            } 
            Session::flash('party_id', $request->party_id);
            Session::flash('sale_contract_no', $request->sale_contract_no);
            Session::flash("success", "Edited Succcessfully !");
            return redirect()->back();


       }
    
    }

    public function show(Request $request, $id){
  
        $user_id=Auth::user()->id; 
        $sale_contract = SaleContract::find($id); 
        $sale_contract_details =SaleContractDetail::where('sale_contract_id',$id)->orderBy('id','asc')->get(); 
        $results=DB::table("user_features")
                ->where('user_id', $user_id)
                ->where('feature_id', 21)
                ->get();
        if(count($results)>0){

            $unposted_status=1;

        }else{

            $unposted_status=0;
        }  
        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");
        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        }
        return view("sale_contract.sale_contract_show",compact("sale_contract"))
                 ->with('sale_contract_details',$sale_contract_details)
                 ->with('unposted_status',$unposted_status)
                 ->with('party_id', $request->party_id)
                 ->with('total_net_weight', $total_net_weight)
                 ->with('sale_contract_no', $id);
    }

    public function ci_sale_contract($id){

        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.duplicate_name','ci_items.ci_item_rate','ci_items.ci_item_code','sale_contract_details.rate_per_ctn','sale_contracts.ci_note',
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
        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");
        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        } 
        return view("sale_contract.ci_sale_contract",compact("sale_contract"))
                ->with('sale_contract_details',$sale_contract_details)
                ->with('total_net_weight', $total_net_weight)
                ->with('obj',$this);
     
    }

    public function ci_com_inv($id){

        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.duplicate_name','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn',
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
        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$id'");
        $nocs_array=$this->create_nocs($sale_contract_details); 
        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        }
        return view("sale_contract.ci_com_inv",compact("sale_contract"))
                ->with('sale_contract_details',$sale_contract_details)
                ->with('obj',$this)
                ->with('total_net_weight', $total_net_weight)
                ->with('nocs_array', $nocs_array);
     
    }

    

    public function ci_com_inv_pack_weight($id){

        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.duplicate_name','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn',
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
                            WHERE sale_contract_details.sale_contract_id='$id'");
        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;

        }

        $sale_contract = SaleContract::find($id);
        $nocs_array=$this->create_nocs($sale_contract_details); 
        return view("sale_contract.ci_com_inv_pack_weight",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('nocs_array',$nocs_array)
              ->with('total_net_weight', $total_net_weight);

      }

      public function ci_sale_contract_tr($id){

        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                            ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.duplicate_name',
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
        return view("sale_contract.tr_dubai.ci_sales_contact_tr",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('obj',$this);
     
    }

    public function ci_com_inv_tr($id){

        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.duplicate_name','ci_items.ci_factor',
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
        return view("sale_contract.tr_dubai.ci_inv_tr",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('obj',$this);
     
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

        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor',
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
        return view("sale_contract.ci_application_for_exp_lien",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('obj',$this);   

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

        $saleContract=SaleContract::where('id',$request->id)->pluck('is_print'); 
        $is_print=$saleContract['0'];
        if($is_print==0){

            $date = date('Y-m-d');
            DB::table('sale_contracts')
                    ->where('id', $request->id)
                    ->update([
                'bank_for_print_date' => $date,
                'is_print' => 1  
            ]);

            echo"Success"; 

        }

     }

      public function noc($id){
        
        $total_carton=0;
        $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_item_rate','sale_contract_details.rate_per_ctn',
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

        return view("sale_contract.ci_noc",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('total_amount', $total_amount)
              ->with('ctn', $total_carton)
              ->with('total_net_weight',$total_net_weight);  
     }

    public function cfrCertificate(Request $request, $id){

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

        return view("sale_contract.ci_cfr_certificate",compact("sale_contract"))
              ->with('sale_contract_details',$sale_contract_details)
              ->with('obj',$this)
              ->with('total_amount', $total_amount)
              ->with('ctn', $total_carton)
              ->with('total_net_weight',$total_net_weight)
              ->with('company_name', $company_name);


    }

    public function ci_packaging($id){

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

    public function desk_invoice_maly($id){
        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        return view("sale_contract.desk_invoice_maly",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details);
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

    public function desk_sale_contract_maly($id){

        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get(); 
        return view("sale_contract.desk_sale_contract_maly",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details);
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
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')
            ->get(); 
        $nocs_array=$this->create_nocs($sale_contract_details);                         
        return view("sale_contract.desk_packaging",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('nocs_array', $nocs_array)->with('factory_address', $factory_address);
    }

    public function desk_packaging_maly($id){

        $sale_contract = SaleContract::find($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->orderBy('id')->get();
        $nocs_array=$this->create_nocs($sale_contract_details);   
        return view("sale_contract.desk_packaging_maly",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('nocs_array', $nocs_array);
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
        return view("sale_contract.desk_com_inv_pack",compact("sale_contract"))->with('sale_contract_details',$sale_contract_details)->with('nocs_array', $nocs_array)->with('factory_address', $factory_address);
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
        $sale_contract = SaleContract::find($id); 
        $all_sum =  $this->getAllSum($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get(); 
        return view("sale_contract.report.annesure",compact("sale_contract")) ->with('all_sum',$all_sum)->with('sale_contract_details',$sale_contract_details);
    }

    public function bapa_forwarding($id){
        $sale_contract = SaleContract::find($id); 
        $all_sum =  $this->getAllSum($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get(); 
        return view("sale_contract.report.bapa_forwarding",compact("sale_contract")) ->with('all_sum',$all_sum)->with('sale_contract_details',$sale_contract_details);
    }

    public function cal_sheet($id){

        return $sale_contract = SaleContract::find($id); 
        $all_sum =  $this->getAllSum($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get(); 
        return view("sale_contract.report.cal_sheet",compact("sale_contract")) ->with('all_sum',$all_sum)->with('sale_contract_details',$sale_contract_details);
    }

    public function f_kha($id){
        $sale_contract = SaleContract::find($id); 
        $all_sum =  $this->getAllSum($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get(); 
        return view("sale_contract.report.f_kha",compact("sale_contract")) ->with('all_sum',$all_sum)->with('sale_contract_details',$sale_contract_details);
    }

    public function f_kha_2($id){
        $sale_contract = SaleContract::find($id); 
        $all_sum =  $this->getAllSum($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get(); 
        return view("sale_contract.report.f_kha_2",compact("sale_contract")) ->with('all_sum',$all_sum)->with('sale_contract_details',$sale_contract_details);
    }
    public function forwarding($id){

        $sale_contract = SaleContract::find($id); 
        $all_sum =  $this->getAllSum($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get(); 
        return view("sale_contract.report.forwarding",compact("sale_contract")) ->with('all_sum',$all_sum)->with('sale_contract_details',$sale_contract_details);
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
        $noce_value=$explode_array[1];
        return view("sale_contract.report.mcci",compact("sale_contract")) ->with('all_sum',$all_sum)->with('obj',$this)->with('sale_contract_details',$sale_contract_details)->with('total_net_weight', $total_net_weight)->with('total_amount_with_freight',$total_amount_with_freight)->with('noce_value', $noce_value);
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
        return view("sale_contract.report.bci",compact("sale_contract")) ->with('all_sum',$all_sum)->with('obj',$this)->with('sale_contract_details',$sale_contract_details)->with('total_net_weight', $total_net_weight)->with('total_amount_with_freight',$total_amount_with_freight)->with('noce_value', $noce_value);
    }
    public function b_certi($id){

        $sale_contract = SaleContract::find($id);
        $all_sum =  $this->getAllSum($id);  
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get(); 
        return view("sale_contract.report.b_certi",compact("sale_contract")) ->with('all_sum',$all_sum)->with('obj',$this)->with('sale_contract_details',$sale_contract_details);
    }

    public function safta($id){
        
        $sale_contract = SaleContract::find($id); 
        $all_sum =  $this->getAllSum($id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get(); 
        return view("sale_contract.report.safta",compact("sale_contract")) 
            ->with('all_sum',$all_sum)
            ->with('obj',$this)
            ->with('sale_contract_details',$sale_contract_details);
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
      return  SaleContractDetail::where('sale_contract_details.sale_contract_id',$sale_contract_id)->where('sale_contract_details.ci_item_name',$ci_item_name)
                              ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                              ->first()->hs_code;
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


    public function approve_desk(Request $request, $id){

         
        $sale_contract = SaleContract::findOrFail($id);
        if($sale_contract ->desk_approver_id != null ){
            Session::flash("danger", "Already Posted !");
            return redirect()->back();
        }
        $sale_contract ->desk_approver_id = Auth::user()->id;
        $sale_contract ->desk_approve_at = Carbon::now();
        $sale_contract ->save();
        Mail::send(new SalesContactMail());
        Session::flash("success", "Posted Succcessfully !");
        return redirect('/notify/party/list/desk/'.$request->party_id);

    }


    public function cancel_approve_desk(Request $request, $id){


        $sale_contract = SaleContract::findOrFail($id);
        if($sale_contract ->approver_id != null ){
            Session::flash("danger", "Task Finished Can not cancel Posted !");
            return redirect()->back();
        }

        $sale_contract ->desk_approver_id = null;
        $sale_contract ->desk_approve_at = null;
        $sale_contract ->save();
        Session::flash("success", "Unposted Succcessfully !");
        return redirect('/notify/party/list/doc/'.$request->party_id);
    }    
    public function duplicate(Request $request, $id){
        
        $sale_contract_prev = SaleContract::find($id);
        $sale_contract = new SaleContract;
        $sale_contract->sales_contract_no=$sale_contract_prev->sales_contract_no;
        $sale_contract->dated=date("Y-m-d",strtotime($sale_contract_prev->dated));
        $sale_contract->invoice_no=$sale_contract_prev->invoice_no."-duplicate";
        //$sale_contract->invoice_date=$sale_contract_prev->invoice_date;
        //$sale_contract->export_no=$sale_contract_prev->export_no;
        $sale_contract->ad_code=$sale_contract_prev->ad_code;
        //$sale_contract->export_date=$sale_contract_prev->export_date;
        $sale_contract->ci_note=$sale_contract_prev->ci_note;
        $sale_contract->discharge_port=$sale_contract_prev->discharge_port;
        $sale_contract->country_id=$sale_contract_prev->country_id;
        $sale_contract->sales_term_id=$sale_contract_prev->sales_term_id;
        $sale_contract->company_id=$sale_contract_prev->company_id;
        $sale_contract->bank_id=$sale_contract_prev->bank_id;
        $sale_contract->account_number=$sale_contract_prev->account_number;
        $sale_contract->importer_id=$sale_contract_prev->importer_id;
        $sale_contract->bank_importer_id=$sale_contract_prev->bank_importer_id;
        $sale_contract->notify_pary_id=$sale_contract_prev->notify_pary_id;
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

        $sale_contract->approver_id = null;
        $sale_contract->approved_at = null;
        $sale_contract -> save();
        $sale_contract->invoice_no = $sale_contract->invoice_no.$sale_contract->id;
        $sale_contract -> save();
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$id)->get();
        foreach($sale_contract_details as $sale_contract_detail_prev){
            $sale_contract_detail = new SaleContractDetail;
            $sale_contract_detail->ci_item_id=$sale_contract_detail_prev->ci_item_id;
            $sale_contract_detail->ci_item_name=$sale_contract_detail_prev->ci_item_name; 
            $sale_contract_detail->sale_contract_id=$sale_contract->id;
            $sale_contract_detail->rate_per_ctn=$sale_contract_detail_prev->rate_per_ctn;
            $sale_contract_detail->rate_per_ctn_for_party=$sale_contract_detail_prev->rate_per_ctn_for_party;
            $sale_contract_detail->rate_per_ctn_for_acc=$sale_contract_detail_prev->rate_per_ctn_for_acc;
            $sale_contract_detail->ctn=$sale_contract_detail_prev->ctn;
            $sale_contract_detail->pcs_in_ctn=$sale_contract_detail_prev->pcs_in_ctn;

            $sale_contract_detail->cbm_per_ctn       = $sale_contract_detail_prev->cbm_per_ctn;
            $sale_contract_detail->total_cbm         = $sale_contract_detail_prev->total_cbm;
            $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = 0;
            $sale_contract_detail->per_ctn_freight        = 0;
            $sale_contract_detail->ci_rate_pl_freight     = 0;

            $sale_contract_detail->is_eligible  = $sale_contract_detail_prev->is_eligible;
            $sale_contract_detail->bapa_percent = $sale_contract_detail_prev->bapa_percent;
            $sale_contract_detail->claim_amount = $sale_contract_detail_prev->claim_amount ;
            $sale_contract_detail->bu_id        = $sale_contract_detail_prev->bu_id;
 
            $sale_contract_detail->total_amount      =$sale_contract_detail_prev->total_amount;
            $sale_contract_detail->total_amount_party=$sale_contract_detail_prev->total_amount_party;
            $sale_contract_detail->total_amount_acc=$sale_contract_detail_prev->total_amount_acc;
            $sale_contract_detail->net_weight_kg=$sale_contract_detail_prev->net_weight_kg;
            $sale_contract_detail->gross_weight_kg=$sale_contract_detail_prev->gross_weight_kg;
            $sale_contract_detail->gross_weight_per_item=$sale_contract_detail_prev->gross_weight_per_item;
            $sale_contract_detail->ccq=$sale_contract_detail_prev->ccq;
            $sale_contract_detail->mfg=$sale_contract_detail_prev->mfg;
            $sale_contract_detail->exp=$sale_contract_detail_prev->exp;
            $sale_contract_detail->desk_item_name=$sale_contract_detail_prev->desk_item_name;
            $sale_contract_detail->container_no = $sale_contract_detail_prev->container_no;
            $sale_contract_detail->batch_no = $sale_contract_detail_prev->batch_no;
            $sale_contract_detail->hs_code=$sale_contract_detail_prev->hs_code;
            $sale_contract_detail->hs_code_2=$sale_contract_detail_prev->hs_code_2;

            $sale_contract_detail ->save();
        }

        Session::flash("success", "Duplicate Succcessfully !");
        return redirect('/notify/party/list/desk/'.$request->fed_back_id);

    }




    private function isCiDetailAlreadyExist($sale_contract_id,$ci_item_id){
        $sale_contract_detail = SaleContractDetail::where('sale_contract_id',$sale_contract_id)->where('ci_item_id',$ci_item_id)->get();
        if($sale_contract_detail->first()){
          return 1;
        }else{
            return 0;
        }
    }
    
    

private function save_excel($sale_contract_id,$datas, $notify_party_id) {

        foreach ($datas as $key => $value) {

                if($value->item_code == '' || !is_numeric($value->ctn)){

                    echo "Numeric Data Required!! <br>";

                }else{
                        
                        $ci_items =  CiItem::where('ci_item_code',$value->item_code)->get();
                        if($ci_item = $ci_items->first()){
                        
                            if($this->isCiDetailAlreadyExist($sale_contract_id,$ci_item->id)){
                            
                            }else{

                                $sale_contract_detail = new SaleContractDetail;
                                $sale_contract_detail->ccq=0;
                                $sale_contract_detail->ci_item_id=$ci_item->id;
                                $cbm_per_carton=NotifyPartyItem::where('ci_item_id', $ci_item->id)->where('notify_party_id', $notify_party_id)->pluck('cbm_per_ctn')->toArray();
                                $acc_rate=NotifyPartyItem::where('ci_item_id', $ci_item->id)->where('notify_party_id', $notify_party_id)->pluck('acc_rate')->toArray();
                                $desk_item_name=NotifyPartyItem::where('ci_item_id', $ci_item->id)->where('notify_party_id', $notify_party_id)->pluck('desk_item_name')->toArray();
                                $party_rate=NotifyPartyItem::where('ci_item_id', $ci_item->id)->where('notify_party_id', $notify_party_id)->pluck('party_rate')->toArray();
                                $gross_weight=NotifyPartyItem::where('ci_item_id', $ci_item->id)->where('notify_party_id', $notify_party_id)->pluck('gross_weight')->toArray();
                                $sale_contract_detail->ci_item_name=$ci_item->ci_item_name; 
                                $sale_contract_detail->sale_contract_id=$sale_contract_id;
                                $sale_contract_detail->rate_per_ctn= $ci_item->ci_item_rate;
                                if(!empty($desk_item_name[0])){

                                   $sale_contract_detail->desk_item_name = $desk_item_name[0];
                                }
                                if(!empty($party_rate[0])){

                                  $sale_contract_detail->rate_per_ctn_for_party=$party_rate[0];
                                  $sale_contract_detail->total_amount_party=$party_rate[0]*$value->ctn;
                                }  
                                $sale_contract_detail->hs_code=$ci_item->hs_code;
                                if(!empty($acc_rate[0])){

                                   $sale_contract_detail->rate_per_ctn_for_acc=$acc_rate[0];
                                   $sale_contract_detail->total_amount_acc=$acc_rate[0]*$value->ctn;

                                }
                                $sale_contract_detail->ctn               =$value->ctn;
                                $sale_contract_detail->pcs_in_ctn        =$value->ctn * $ci_item->ci_factor;

                                if(!empty($cbm_per_carton[0])){

                                   $sale_contract_detail->cbm_per_ctn       = $cbm_per_carton[0];
                                   $sale_contract_detail->total_cbm         = $cbm_per_carton[0] * $value->ctn ;
                                }

                                $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = 0;
                                $sale_contract_detail->per_ctn_freight        = 0;
                                $sale_contract_detail->ci_rate_pl_freight     = 0;
                                $sale_contract_detail->total_amount      =$ci_item->ci_item_rate*$value->ctn;
                                $sale_contract_detail->net_weight_kg     =$value->ctn * $ci_item->d_net_weight;
                                $sale_contract_detail->gross_weight_per_item=$gross_weight[0];
                                if(!empty($gross_weight[0])){

                                  $sale_contract_detail->gross_weight_kg   =$value->ctn * $gross_weight[0];
                                  $sale_contract_detail->gross_weight_per_item=$gross_weight[0];


                                }  
                                $sale_contract_detail->bapa_percent = $ci_item->bapa_percent;
                                $sale_contract_detail->bapa_percent = ($ci_item->bapa_percent * $sale_contract_detail->total_amount_party ) / 100;
                                $sale_contract_detail->bu_id        = $ci_item->bu_id;
                                $sale_contract_detail ->save();
                              
                            }

                        }else{
                                echo 'sl= '.$value->sl."  item_code= ".$value->item_code."  Error: Item Not Created, Check item_code or Please Create Item !!<br>";
                        }

            }// blank data

        }// foreach end 

        return redirect('/access_notify_party_list');

    }// end get data from excel
 

    public function ci_make_price_same($sale_contract_id){


        $sale_contract_detail = DB::select("UPDATE sale_contract_details set 
                               sale_contract_details.rate_per_ctn = sale_contract_details.rate_per_ctn_for_party,
                               sale_contract_details.total_amount = sale_contract_details.rate_per_ctn_for_party * sale_contract_details.ctn where sale_contract_details.sale_contract_id='$sale_contract_id' 
                               ");
        $this->manageFreight($sale_contract_id);    

        Session::flash("success", "Party price and Ci price now same !");
        return redirect()->back();

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

   

    public function sci_edit($id){
         

        $sale_contract = SaleContract::find($id); 
        return view("sale_contract.sci.sci_edit",compact("sale_contract"));
        
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
                sale_contracts.id = '$id'
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

        if(count($sale_contract_details)>0){

            $explodeResult=explode("/",$sale_contract_no);
            $getingYearResults=FileNumber::where('from_year', end($explodeResult))->pluck('symbol')->toArray();
            $ref_name=$short_name.'/'.$sale_contract_no.'/'.$getingYearResults[0].'-'.'04-005';
            
            $noneligibleItemTotals=DB::select("SELECT
                    sale_contracts.sales_contract_no,
                    SUM(sale_contract_details.total_amount) as non_eligible_item_total
                FROM
                    sale_contracts
                JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
                WHERE
                    sale_contracts.id='$id' AND sale_contract_details.is_eligible='0'");
            foreach ($noneligibleItemTotals as $key => $value) {
               
               $noneligibleItemTotal=$value->non_eligible_item_total;
            }

            if(empty($noneligibleItemTotal)){

                $noneligibleItemTotal=0;
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
                        JOIN item_groups ON item_groups.id = ci_items.item_group
                        WHERE 
                            sale_contract_details.sale_contract_id='$id'
                        GROUP BY item_groups.id,item_groups.item_group_name,sale_contracts.id");

            $item_array=array();
            $item_groups=DB::select("SELECT
                        item_groups.item_group_name,
                        ci_items.ci_item_name,
                        COUNT(item_groups.item_group_name) as item_group_count 
                    FROM
                        sale_contracts
                    JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
                    JOIN ci_items ON ci_items.id=sale_contract_details.ci_item_id
                    JOIN item_groups ON item_groups.id=ci_items.item_group
                    WHERE
                        sale_contracts.id = '$id'
                    GROUP BY item_groups.item_group_name,item_groups.item_group_name");
            foreach ($item_groups as $key => $value) {

               if($value->item_group_count>1){

                   array_push($item_array, $value->item_group_name);

               }else{
                   
                   array_push($item_array, $value->ci_item_name);

               }                  

            }
            
            $ciItemClaimPercentage=0;
            $totalAmount=0;
            $ciItemGroupTotals=DB::select("SELECT  
                sale_contract_details.ci_item_claim_percent,
                SUM(sale_contract_details.total_amount) as total_amount
                
            FROM
                sale_contracts
            JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
            JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
            JOIN item_groups ON item_groups.id = ci_items.item_group
            WHERE 
                sale_contract_details.sale_contract_id='$id'
            GROUP BY sale_contract_details.sale_contract_id,sale_contract_details.ci_item_claim_percent");
            foreach ($ciItemGroupTotals as $key => $value) {
                 
              $ciItemClaimPercentage=$value->ci_item_claim_percent;
              $totalAmount=$value->total_amount;

            }

            $description_of_goods='';

            for ($i=0; $i < count($item_array); $i++) { 
                
                $description_of_goods=$description_of_goods.$item_array[$i].',';

            }

            $rcpeDetails=DB::select("SELECT tbl.item_group_name,tbl.item_group_id,repe_details.source_type,repe_details.source_address,sum((net_weight_kg * repe_details.percentage)/100) as percentWeight, sum(repe_details.percentage) as percentage, repe_details.ingredient  FROM( SELECT
                        item_groups.id AS item_group_id,
                        item_groups.item_group_name,          
                        SUM(
                            sale_contract_details.net_weight_kg
                        ) AS net_weight_kg  
                    FROM
                        sale_contracts
                    JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
                    JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                    JOIN item_groups ON item_groups.id = ci_items.item_group             
                    WHERE
                        sale_contract_details.sale_contract_id = '$id'
                    GROUP BY
                        item_group_id) tbl
                    JOIN ci_items ON tbl.item_group_id=ci_items.item_group
                    JOIN rcpe_masters ON ci_items.receipe_id = rcpe_masters.id
                    JOIN rcpe ON rcpe.id=rcpe_masters.rcpe_fg_id
                    JOIN repe_details ON rcpe_masters.id=repe_details.rcpe_id
                    GROUP BY repe_details.ingredient");
            $net_fob=$realize_value-$freight_cost-$insurance-$noneligibleItemTotal;
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
                        JOIN item_groups ON item_groups.id = ci_items.item_group
                        JOIN rcpe_masters ON ci_items.receipe_id = rcpe_masters.id
                        JOIN rcpe ON rcpe.id=rcpe_masters.rcpe_fg_id
                        JOIN repe_details ON rcpe_masters.id=repe_details.rcpe_id
                        WHERE
                            sale_contract_details.sale_contract_id = '$id'
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
            $different_of_r_and_i=number_format($totalAmount-$realize_value,3);
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
               ->with('noneligibleItemTotal', $noneligibleItemTotal)
               ->with('itemDetails', $itemDetails)
               ->with('item_array', $item_array)
               ->with('description_of_goods',$description_of_goods)
               ->with('ciItemClaimPercentage', $ciItemClaimPercentage)
               ->with('totalAmount', $totalAmount)
               ->with('rcpeDetails', $rcpeDetails)
               ->with('realize_value', $realize_value)
               ->with('net_fob', $net_fob)
               ->with('localMateril', $localMateril)
               ->with('imported', $imported)
               ->with('different_of_r_and_i', $different_of_r_and_i);
           

        }else{

            return view('sale_contract.sci.sci_com_inv');
               
        }


    }
  //sci manage
  public function sci_update(Request $request, $id) {
        
    $this->validate($request, [
       "exp_submit_date"=>"nullable|date",
       "last_date_for_lodging_claim"=>"nullable|date",
       "proceeds_realization_date"=>"nullable|date",
       "amount_of_proceed_realized"=>"nullable|numeric",
       "short_realized"=>"nullable|numeric",
       "prc_issue_date"=>"nullable|date",
       "bapa_application_submit_date"=>"nullable|date",
       "bapa_certificate_date"=>"nullable|date",
       "claim_submission_date"=>"nullable|date",
       "claim_amount_usd"=>"nullable|numeric",
       "audit_report_date"=>"nullable|date",
       "auditted_amount"=>"nullable|numeric",
       "exchange_rate"=>"nullable|numeric",
       "auditted_amount_tk"=>"nullable|numeric",
       "shipped_on_board_date"=>"nullable|date",
       "bl_date"=>"nullable|date",
       "challan_date"=>"nullable|date",
       "challan_no"=>"nullable|max:191",
       "shipping_bill_no"=>"nullable|max:191",
       "shipping_bill_date"=>"nullable|date",
       "lc_date"=>"nullable|date",
       "bb_prc_date"=>"nullable|max:191",
       "country_of_importer"=>"nullable|max:191",
       "insurance" =>"nullable|max:191",
       "od_sight_rate"=>"nullable|max:191",
    ]);

    $results=DB::table('s_c_i_s')
       ->where('sale_contract_id', $id)
       ->get();
    if(count($results)>0){

        Session::flash("danger", "Already Exist For This Sales Contact..!!");
        return redirect('/sale_contract/'.$id);
    }else{

        $sci=new SCI();
        $sci->sale_contract_id=$id;
        if($request->exp_submit_date){
           $sci->exp_submit_date=date("Y-m-d",strtotime($request->exp_submit_date));
        }
        $sci->status=$request->status;
        if($request->proceeds_realization_date){
        $sci->proceeds_realization_date=date("Y-m-d",strtotime($request->proceeds_realization_date));
        }
        $sci->amount_of_proceed_realized=$request->amount_of_proceed_realized;
        $sci->short_realized=$request->short_realized;
        if($request->prc_issue_date){
        $sci->prc_issue_date=date("Y-m-d",strtotime($request->prc_issue_date));
        }
        if($request->bapa_application_submit_date){
        $sci->bapa_application_submit_date=date("Y-m-d",strtotime($request->bapa_application_submit_date));
        }
        if($request->bapa_certificate_date){
        $sci->bapa_certificate_date=date("Y-m-d",strtotime($request->bapa_certificate_date));
        }
        if($request->claim_submission_date){
        $sci->claim_submission_date=date("Y-m-d",strtotime($request->claim_submission_date));
        }
        $sci->claim_amount_usd=$request->claim_amount_usd;
        if($request->audit_report_date){
        $sci->audit_report_date=date("Y-m-d",strtotime($request->audit_report_date));
        }
        $sci->auditted_amount=$request->auditted_amount;
        $sci->exchange_rate=$request->exchange_rate;
        $sci->auditted_amount_tk = $request->exchange_rate * $request->auditted_amount;
        if($request->subsidy_rece_date_30_perc){
            $sci->subsidy_rece_date_30_perc=date("Y-m-d",strtotime($request->subsidy_rece_date_30_perc));
        }
        if($request->subsidy_rece_date_70_perc){
            $sci->subsidy_rece_date_70_perc=date("Y-m-d",strtotime($request->subsidy_rece_date_70_perc));
        }
        if($request->subsidy_rece_date_100_perc){
        $sci->subsidy_rece_date_100_perc=date("Y-m-d",strtotime($request->subsidy_rece_date_100_perc));
        }
        if($request->shipped_on_board_date){
        $sci->shipped_on_board_date=date("Y-m-d",strtotime($request->shipped_on_board_date));
        $sci->last_date_for_lodging_claim=date('Y-m-d', strtotime($request->shipped_on_board_date. ' + 180 days'));
        }
        if($request->bl_date){
        $sci->bl_date=date("Y-m-d",strtotime($request->bl_date));
        }
        if($request->challan_date){
        $sci->challan_date=date("Y-m-d",strtotime($request->challan_date));
        }
        $sci->challan_no=$request->challan_no;
        $sci->shipping_bill_no=$request->shipping_bill_no;
        if($request->shipping_bill_date){
          $sci->shipping_bill_date=date("Y-m-d",strtotime($request->shipping_bill_date));
        }
        if($request->lc_date){
          $sci->lc_date=date("Y-m-d",strtotime($request->lc_date));
        }
        if($request->insurance){
          $sci->insurance=$request->insuranc;
        }
        if($request->od_sight_rate){
          $sci->od_sight_rate=$request->od_sight_rate;
        }

        $sci->bb_prc_date=$request->bb_prc_date;
        $sci->save();

        Session::flash("success", "Edited Succcessfully !");
        return redirect('/sale_contract/'.$id);

    }    

    
}





public function getLastccq($sale_contract_id){
    return SaleContractDetail::where('sale_contract_id',$sale_contract_id)->orderBy('id','desc')->first()->ccq;
}

public function deleteSalesContact(Request $request, $id){

        $sales_contact_details_ids=SaleContractDetail::where('sale_contract_id', $id)->pluck('id')->toArray();
        DB::table('sale_contracts')->where('id', $id)->delete();
        if(count($sales_contact_details_ids) > 0){
            try{

                DB::table('sale_contract_details')->whereIn('id', $sales_contact_details_ids)->delete();
            }
            catch(Exception $e){

                return $e;  
            }

        }                                              
        Session::flash("success", "Delete Succcessfully..!! !");
        return redirect('/notify/party/list/desk/'.$request->fed_back_id); 

   }

   public function returnDirect(Request $request){

        $user_id=Auth::user()->id; 
        $sale_contract = SaleContract::find($request->sale_contract_no); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$request->sale_contract_no)->get(); 
        $results=DB::table("user_features")
                ->where('user_id', $user_id)
                ->where('feature_id', 21)
                ->get();
        if(count($results)>0){

            $unposted_status=1;

        }else{

            $unposted_status=0;
        }     
        return view("sale_contract.sale_contract_show",compact("sale_contract"))
                 ->with('sale_contract_details',$sale_contract_details)
                 ->with('unposted_status',$unposted_status)
                 ->with('party_id', $request->party_id)
                 ->with('sale_contract_no', $request->sale_contract_no);


   }

   public function deleteSalesContactItem(Request $request){
       
        \DB::table("sale_contract_details")->whereIn('id',explode(",",$request->ids))->delete();
        $results=DB::select("SELECT
            SUM(sale_contract_details.ctn) as ctn,
            SUM(
                sale_contract_details.total_amount_acc
            ) AS total_amount_acc,
            SUM(
                sale_contract_details.total_amount_party
            ) AS total_amount_party,
            SUM(
                sale_contract_details.total_amount
            ) AS total_amount,
            SUM(
                sale_contract_details.total_cbm
            ) AS total_cbm,
            SUM(
                sale_contract_details.gross_weight_kg
            ) AS gross_weight_kg,
            SUM(
                sale_contract_details.pcs_in_ctn
            ) AS pcs_in_ctn
        FROM
            sale_contract_details
        WHERE
            sale_contract_details.sale_contract_id = '$request->sale_contract_no'");

        foreach ($results as $key => $result) {

            $ctn=$result->ctn;
            $total_amount_acc=$result->total_amount_acc;
            $total_amount_party=$result->total_amount_party;
            $total_amount=$result->total_amount;
            $total_cbm=$result->total_cbm;
            $gross_weight_kg=$result->gross_weight_kg;
            $pcs_in_ctn=$result->pcs_in_ctn;

        }
        
        if(!empty($ctn)){

          return $array=array($ctn, $total_amount_acc, $total_amount_party, $total_amount, $total_cbm, $gross_weight_kg, $pcs_in_ctn);

        }else{

          return $array=array('0','0','0','0','0','0','0');

        }         

   }

   public function checkInvoiceNumberExistOrNot(Request $request){

          
        $results=\DB::select("SELECT * FROM sale_contracts WHERE sale_contracts.invoice_no LIKE '%$request->invoice_no%'");
           
        if(count($results)>0){

            return 1;

        }else{

           return 0;

        }   

   }


}
