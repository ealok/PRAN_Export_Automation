<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
use App\ScTemp;
class TestController extends Controller
{

    public function __construct(){

       $this->middleware('auth');

    }

    public function quickSc(Request $request){
        
        $user_id=Auth::user()->id;
        $notify_party_ids = NotifyPartyUser::where('user_id', $user_id)->where('status', '1')->pluck('notify_party_id');
        $notify_parties = NotifyParty::whereIn('id', $notify_party_ids)->get();  
        return view("sale_contract.quick_access_notify_party_list")->with('notify_parties',$notify_parties);

    }

    public function getBuyerPoList(Request $request){

        // return $results = DB::select("SELECT
        //         pm.ID,
        //         pm.PO_NO,
        //         CASE
        //         WHEN pm.ORDER_TYPE = 2 THEN CONCAT(pm.PO_NO, '(GT)')
        //         ELSE pm.PO_NO
        //         END AS SPO_NO,
        //         pm.REMARK,
        //         pm.APPROVED_STATUS
        // FROM po_master pm
        // WHERE pm.PARTY_ID = '$request->party_id'
        //     AND pm.STATUS = 1
        //     AND pm.CREATE_DATE >= '2024-01-01'
        //     AND pm.REMARK = 'Manually Created'
        //     AND pm.ORDER_TYPE = 1
        //     AND pm.APPROVED_STATUS = 'Y'");

        return $results = DB::select("SELECT
                        pm.ID,
                        pm.PO_NO,
                        CASE
                        WHEN pm.ORDER_TYPE = 2 THEN CONCAT(pm.PO_NO, '(GT)')
                        ELSE pm.PO_NO
                        END AS SPO_NO,
                        pm.REMARK,
                        pm.APPROVED_STATUS
                FROM po_master pm
                WHERE pm.PARTY_ID = '$request->party_id'
                    AND pm.STATUS = 1
                    AND pm.CREATE_DATE >= '2026-01-01'
                    AND pm.REMARK = 'Manually Created'
                    AND pm.ORDER_TYPE = 1
                    AND pm.APPROVED_STATUS = 'Y'");


    }



    public function sales_contract(Request $request){

        $party_id = base64_decode($request->query('partyId'));
        $user_id = Auth::user()->id;
        $notify_party_ids = NotifyPartyUser::where('user_id', $user_id)->where('status', '1')->pluck('notify_party_id');
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
        $transportAgencyies=TransportAgency::all(); 
        $customStations=CustomStation::all();
        $shippingLines=ShippingLine::all();
        $party_name= SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('party_name') ? SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('party_name') : NotifyParty::where('id',$party_id)->value('name');
        $party_address= SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('party_address') ? SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('party_address') : NotifyParty::where('id',$party_id)->value('address');             
        $also_notify_party= SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('third_notify_party') ? SaleContract::where('notify_pary_id',$party_id)->orderBy('id', 'desc')->limit(1)->value('third_notify_party') : ''; 
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'");  

        $party_items = \DB::select("SELECT
                ci_items.id AS item_id,
                ci_items.ci_item_name,
                ci_items.ci_item_code
            FROM ci_items
            JOIN notify_party_items ON ci_items.id = notify_party_items.ci_item_id
            JOIN notify_parties ON notify_parties.id = notify_party_items.notify_party_id
            WHERE notify_parties.id = :party_id
        ", ['party_id' => $party_id]);        
                             
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
            ->with('party_items',$party_items)
            ->with('transportAgencyies',$transportAgencyies)
            ->with('customStations',$customStations)
            ->with('shippingLines',$shippingLines)
            ->with('id', $party_id)
            ->with('xxxx_party_id', $party_id);

    }

    public function SaveTempScItems(Request $request){
         
        $formated_file = $request->file('file');
        $path = $formated_file->getRealPath();
        $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
        $user_id=Auth::user()->id;
        $this->saveTemporaryTableDataOnCreate($datas,$request->party_id,$user_id);
        $results = DB::select("SELECT 
                id,
                item_code, 
                item_name, 
                acc_rate_per_ctn, 
                party_rate_per_ctn, 
                cbm_per_ctn, 
                factor, 
                hs_code, 
                if(hs_code2,hs_code2,'') as hs_code2,
                total_ctn, 
                total_cbm,
                total_gross_weight as gross_weight, 
                total_acc_value, 
                total_party_value, 
                is_missing,
                sample_qty 
            FROM tbl_sc_temp 
            WHERE user_id = :user_id
            ORDER BY id DESC", ['user_id' => $user_id]);

        return response()->json([
            'code'=>200,
            'data'=>$results
        ]);

    }


    private function saveTemporaryTableDataOnCreate($datas,$party_id,$user_id)
    {
        foreach($datas as $key => $value) {

            if(empty($value->item_code) || $value->item_code == NULL) {
                continue;
            }

            $ci_item = CiItem::where('ci_item_code', $value->item_code)->first(['id', 'factor', 'hs_code']);
            if(!$ci_item) {
                continue; 
            }

            $notifyParty = NotifyPartyItem::where('ci_item_id', $ci_item->id)
                ->where('notify_party_id', $party_id)
                ->first(['desk_item_name', 'acc_rate', 'party_rate', 'cbm_per_ctn', 'gross_weight', 'hs_code2', 'cbm_per_ctn']);

            if(!$notifyParty) {
                continue; 
            }

            $existsTempItem = ScTemp::where('item_code', trim($value->item_code))->where('user_id', $user_id)->exists();
            if($existsTempItem){

                continue;
            }

            $ScTemp = new ScTemp();
            $ScTemp->item_code = trim($value->item_code);
            $ScTemp->ref_code = trim($value->item_code);
            $ScTemp->item_name = trim($notifyParty->desk_item_name);
            $ScTemp->acc_rate_per_ctn = $notifyParty->acc_rate;
            $ScTemp->party_rate_per_ctn = $notifyParty->party_rate;
            $ScTemp->cbm_per_ctn = $notifyParty->cbm_per_ctn;
            $ScTemp->factor = $ci_item->factor;
            $ScTemp->hs_code = $ci_item->hs_code;
            $ScTemp->hs_code2 = $value->hs_code2;
            $ScTemp->total_ctn = $value->ctn;
            $ScTemp->gross_weight = trim($notifyParty->gross_weight);
            $ScTemp->total_cbm = round($notifyParty->cbm_per_ctn * $value->ctn,6);
            $ScTemp->total_acc_value = round($notifyParty->acc_rate * $value->ctn, 6);
            $ScTemp->total_party_value = round($notifyParty->party_rate * $value->ctn, 6);
            $ScTemp->total_gross_weight = round($value->ctn * $notifyParty->gross_weight, 6);
            $ScTemp->user_id = $user_id;
            $ScTemp->sample_qty = $value->sample ? $value->sample : 0;
            $ScTemp->is_missing = CiItem::where('ci_item_code', $value->item_code)->where('status', 1)->count() > 0 ? 0 : 1;
            $ScTemp->save();
        }

    }


    public function SaveTempScItemsOnEidt(Request $request){
       
        $formated_file = $request->file('file');
        $path = $formated_file->getRealPath();
        $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
        $user_id=Auth::user()->id;
        $sc_id=$request->sc_id;
        $this->saveTemporaryTableData($datas,$request->party_id,$user_id,$sc_id);
        $results = DB::select("SELECT 
                id,
                item_code, 
                item_name, 
                acc_rate_per_ctn, 
                party_rate_per_ctn, 
                cbm_per_ctn, 
                factor, 
                hs_code, 
                if(hs_code2,hs_code2,'') as hs_code2,
                total_ctn, 
                total_cbm,
                total_gross_weight as gross_weight, 
                total_acc_value, 
                total_party_value,
                sample_qty, 
                is_missing 
            FROM tbl_sc_temp 
            WHERE user_id = :user_id
            ORDER BY id DESC", ['user_id' => $user_id]);

        return response()->json([
            'code'=>200,
            'data'=>$results
        ]);

    }

    public function pageLoadDeleteTempItem(Request $request){

        if(ScTemp::where('user_id',Auth::user()->id)->count()>0){
           
            ScTemp::where('user_id', Auth::user()->id)->delete();

        }

    }


    private function saveTemporaryTableData($datas,$party_id,$user_id,$sc_id)
    {

        foreach ($datas as $key => $value) {

            if (empty($value->item_code) || $value->item_code == NULL) {
                continue;
            }
            $ci_item = CiItem::where('ci_item_code', trim($value->item_code))->first(['id', 'factor', 'hs_code']);
            if (!$ci_item) {
                continue; 
            }

            $notifyParty = NotifyPartyItem::where('ci_item_id', $ci_item->id)->where('notify_party_id', $party_id)->first(['desk_item_name', 'acc_rate', 'party_rate', 'cbm_per_ctn', 'gross_weight', 'hs_code2']);
            if(!$notifyParty) {
                continue; 
            }

            $existsTempItem = ScTemp::where('item_code', trim($value->item_code))->where('user_id', $user_id)->exists();
            if($existsTempItem){

                continue;
            }

            $existingContractItem = SaleContractDetail::where('sale_contract_id', $sc_id)
                            ->where('ci_item_id', $ci_item->id)
                            ->first();
            if($existingContractItem){

                continue;
            }                                 

            $ScTemp = new ScTemp();
            $ScTemp->item_code = trim($value->item_code);
            $ScTemp->ref_code = trim($value->item_code);
            $ScTemp->item_name = trim($notifyParty->desk_item_name);
            $ScTemp->acc_rate_per_ctn = $notifyParty->acc_rate;
            $ScTemp->party_rate_per_ctn = $notifyParty->party_rate;
            $ScTemp->factor = $ci_item->factor;
            $ScTemp->hs_code = trim($ci_item->hs_code);
            $ScTemp->hs_code2 = trim($value->hs_code2);
            $ScTemp->total_ctn = $value->ctn;
            $ScTemp->gross_weight = trim($notifyParty->gross_weight);
            $ScTemp->cbm_per_ctn = $notifyParty->cbm_per_ctn;
            $ScTemp->total_cbm = round($notifyParty->cbm_per_ctn * $value->ctn, 6);
            $ScTemp->total_acc_value = round($notifyParty->acc_rate * $value->ctn, 6);
            $ScTemp->total_party_value = round($notifyParty->party_rate * $value->ctn, 6);
            $ScTemp->total_gross_weight = round($value->ctn * $notifyParty->gross_weight, 6);
            $ScTemp->user_id = $user_id;
            $ScTemp->sample_qty = $value->sample ? $value->sample : 0;
            $ScTemp->is_missing = CiItem::where('ci_item_code', $value->item_code)->where('status', 1)->count() > 0 ? 0 : 1;
            $ScTemp->save();
        }
    }


    public function deleteScTempItem(Request $request){
 
      $itemIds = $request->input('item_ids');
      $deleted = ScTemp::whereIn('id', $itemIds)->delete();
      return response()->json(['status' => true,'code'=>200]);

    }

    public function deleteQuickScItem(Request $request)
    {
        try {
            $itemIds = $request->input('item_ids');
            $sale_contract_id = $request->input('sale_contract_id');
            ScTemp::whereIn('id', $itemIds)->delete();
            $mailStatus = DB::table('sale_contracts')
                ->where('id', $sale_contract_id)
                ->value('mail_status');
            
            if ($mailStatus === 'Y') {
                $restrictedIds = SaleContractDetail::whereIn('id', $itemIds)
                    ->whereIn('rate_status', ['M', 'E', 'S'])
                    ->pluck('id')
                    ->toArray();
                
                $deletedCount = SaleContractDetail::whereIn('id', $itemIds)
                    ->whereNotIn('rate_status', ['M', 'E', 'S'])
                    ->delete();
                
                $deletedIds = array_diff($itemIds, $restrictedIds);
                
                $message = '';
                if ($deletedCount > 0) {
                    $message .= $deletedCount . ' item(s) deleted successfully.';
                }
                if (!empty($restrictedIds)) {
                    $message .= ' ' . count($restrictedIds) . ' item(s) skipped (rate_status: M, E, S).';
                }
                if ($deletedCount == 0 && empty($restrictedIds)) {
                    $message = 'No items to delete. All selected items are already sent for approval.';
                }
                
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => $message,
                    'deleted_ids' => array_values($deletedIds),
                    'restricted_ids' => array_values($restrictedIds)
                ]);
                
            } else {
                
                $deletedCount = SaleContractDetail::whereIn('id', $itemIds)->delete();
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => $deletedCount . ' item(s) deleted successfully.',
                    'deleted_ids' => $itemIds,
                    'restricted_ids' => []
                ]);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function partyItemList(Request $request){

        $results = \DB::select("
            SELECT
                ci_items.id AS item_id,
                ci_items.ci_item_name,
                ci_items.ci_item_code
            FROM ci_items
            JOIN notify_party_items ON ci_items.id = notify_party_items.ci_item_id
            JOIN notify_parties ON notify_parties.id = notify_party_items.notify_party_id
            WHERE notify_parties.id = :party_id
        ", ['party_id' => $request->party_id]);


        $lastSaleContract = SaleContract::where('notify_pary_id', $request->party_id)->latest('id')->first(['party_name', 'party_address']);
        $partyName = !empty($lastSaleContract->party_name) ? $lastSaleContract->party_name : '';
        $partyAddress = !empty($lastSaleContract->party_address) ? $lastSaleContract->party_address : '';

        if($results){

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results,
                'partyName'=> $partyName,
                'partyAddress'=> $partyAddress
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data" =>[],
                'partyName'=>'',
                'partyAddress'=>'',

            ]);

        } 

    }

    public function impShipDetails(Request $request){

        $lastSaleContract = SaleContract::where('importer_id',$request->imp_id)->latest('id')->first(['importer_address']);
        $impAddress = !empty($lastSaleContract->importer_address) ? $lastSaleContract->importer_address : '';
        return response()->json([
            'message' => "Data Found",
            "code"    => 200,
            'impAddress'=> $impAddress
        ]);


    }

    // Updated PHP Controller
    public function addScTempItem(Request $request){

        $user_id = Auth::user()->id;
        $ci_item = CiItem::where('id', $request->ci_item_id)->first(['ci_item_code','factor']);
        if (!$ci_item) {
            return response()->json([
                'code' => 404,
                'message' => 'Item not found.'
            ], 200);
        }
        $existingItem = ScTemp::where('user_id', $user_id)
            ->where('item_code', $ci_item->ci_item_code)
            ->first();

        if ($existingItem) {
            return response()->json([
                'code' => 409,
                'message' => 'This item is already added to the table.'
            ], 200);
        }

        $ScTemp = new ScTemp();
        $ScTemp->item_code = $ci_item->ci_item_code;
        $ScTemp->ref_code = $ci_item->ci_item_code;
        $ScTemp->item_name = trim($request->desk_item_name);
        $ScTemp->acc_rate_per_ctn = $request->rate_per_ctn_for_acc;
        $ScTemp->party_rate_per_ctn = $request->rate_per_ctn_for_party;
        $ScTemp->cbm_per_ctn = $request->cbm_per_ctn;
        $ScTemp->factor = $ci_item->factor;
        $ScTemp->gross_weight = $request->gross_weight;
        $ScTemp->hs_code = trim($request->hs_code);
        $ScTemp->hs_code2 = trim($request->hs_code_2);
        $ScTemp->total_ctn = $request->ctn;
        $ScTemp->total_cbm = round($request->ctn * $request->cbm_per_ctn, 6);
        $ScTemp->total_acc_value = round($request->ctn * $request->rate_per_ctn_for_acc, 6);
        $ScTemp->total_party_value = round($request->ctn * $request->rate_per_ctn_for_party, 6);
        $ScTemp->total_gross_weight = round($request->ctn * $request->gross_weight, 6);
        $ScTemp->sample_qty = $request->sample_qty;
        $ScTemp->user_id = $user_id;
        $ScTemp->is_missing = 1;
        $ScTemp->save();
        $results = DB::select("SELECT 
                id,
                item_code, 
                item_name, 
                acc_rate_per_ctn, 
                party_rate_per_ctn, 
                cbm_per_ctn, 
                total_gross_weight as gross_weight, 
                hs_code, 
                if(hs_code2,hs_code2,'') as hs_code2, 
                total_ctn, 
                total_cbm, 
                total_acc_value, 
                total_party_value, 
                is_missing,
                sample_qty 
            FROM tbl_sc_temp 
            WHERE user_id = :user_id
            ORDER BY id DESC", ['user_id' => $user_id]);

        return response()->json([
            'code' => 200,
            'data' => $results
        ]);

    }

    public function addScTempItemOnEdit(Request $request)
    {
       
        $user_id = Auth::user()->id;
        $ci_item = CiItem::where('id', $request->ci_item_id)->first(['ci_item_code', 'factor']);
        if (!$ci_item) {
            return response()->json([
                'code' => 404,
                'message' => 'Item not found.'
            ], 200);
        }

        $existingContractItem = SaleContractDetail::where('sale_contract_id', $request->sc_header_editId)
            ->where('ci_item_id', $request->ci_item_id)
            ->first();

        $existingTempItem = ScTemp::where('user_id', $user_id)
            ->where('item_code', $ci_item->ci_item_code)
            ->first();

        if ($existingContractItem || $existingTempItem) {
            return response()->json([
                'code' => 409,
                'message' => 'This item is already added to the table.'
            ], 200);
        }
        ScTemp::where('user_id', $user_id)->delete();
        $tempItem = new ScTemp();
        $tempItem->item_code = $ci_item->ci_item_code;
        $tempItem->ref_code = $ci_item->ci_item_code;
        $tempItem->item_name = trim($request->desk_item_name);
        $tempItem->acc_rate_per_ctn = $request->rate_per_ctn_for_acc;
        $tempItem->party_rate_per_ctn = $request->rate_per_ctn_for_party;
        $tempItem->cbm_per_ctn = $request->cbm_per_ctn;
        $tempItem->factor = $ci_item->factor;
        $tempItem->gross_weight = $request->gross_weight;
        $tempItem->hs_code = trim($request->hs_code);
        $tempItem->hs_code2 = trim($request->hs_code_2);
        $tempItem->total_ctn = $request->ctn;
        $tempItem->total_cbm = round($request->ctn * $request->cbm_per_ctn, 6);
        $tempItem->total_acc_value = round($request->ctn * $request->rate_per_ctn_for_acc, 6);
        $tempItem->total_party_value = round($request->ctn * $request->rate_per_ctn_for_party, 6);
        $tempItem->total_gross_weight = round($request->ctn * $request->gross_weight, 6);
        $tempItem->sample_qty = round($request->sample_qty);
        $tempItem->user_id = $user_id;
        $tempItem->is_missing = 1;
        $tempItem->save();

        // Fetch updated list for current user
        $results = DB::select("
            SELECT 
                id,
                item_code, 
                item_name, 
                acc_rate_per_ctn, 
                party_rate_per_ctn, 
                cbm_per_ctn, 
                total_gross_weight as gross_weight, 
                hs_code, 
                IF(hs_code2, hs_code2, '') AS hs_code2, 
                total_ctn, 
                total_cbm, 
                total_acc_value, 
                total_party_value,
                sample_qty, 
                is_missing 
            FROM tbl_sc_temp 
            WHERE user_id = :user_id
            ORDER BY id DESC
        ", ['user_id' => $user_id]);

        return response()->json([
            'code' => 200,
            'data' => $results
        ]);
    }


    public function createSalesContract(Request $request)
    {   
         
        if(SaleContract::where('invoice_no', $request->invoice_no)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Already Exist This Invoice',
                'code' => 409
            ], 409);
        }

        $user_id = Auth::user()->id;
        if($request->action == "insert") {
            
            $company_bank = CompanyBank::where('company_id', $request->company_id)->where('bank_id', $request->bank_id)->first();
            $account_number = isset($company_bank->account_number) ? $company_bank->account_number : '';
            $sale_contract = new SaleContract();
            $sale_contract->sales_contract_no = str_replace('/', '-', $request->sales_contract_no);
            $sale_contract->dated = date("Y-m-d", strtotime($request->dated));
            $sale_contract->invoice_no = str_replace('/', '-', $request->invoice_no);
            $sale_contract->invoice_date = !empty($request->invoice_date) ? date("Y-m-d", strtotime($request->invoice_date)) : '';
            $sale_contract->ci_note = isset($request->ci_note) ? $request->ci_note : '';
            $sale_contract->discharge_port = isset($request->discharge_port) ? $request->discharge_port : '';
            $sale_contract->country_id = isset($request->country_id) ? $request->country_id : 0;
            $sale_contract->sales_term_id = isset($request->sales_term_id) ? $request->sales_term_id : 0;
            $sale_contract->company_id = isset($request->company_id) ? $request->company_id : 0;
            $sale_contract->bank_id = isset($request->bank_id) ? $request->bank_id : 0;
            $sale_contract->account_number = $account_number;
            $sale_contract->importer_id = isset($request->importer_id) ? $request->importer_id : 0;
            $sale_contract->bank_importer_id = isset($request->bank_importer_id) ? $request->bank_importer_id : 0;
            $sale_contract->notify_pary_id = isset($request->notify_pary_id) ? $request->notify_pary_id : 0;
            $sale_contract->carrying_mode_id = isset($request->carrying_mode_id) ? $request->carrying_mode_id : 0;
            $sale_contract->loading_place_id = isset($request->loading_place_id) ? $request->loading_place_id : 0;
            $sale_contract->final_destination = isset($request->final_destination) ? $request->final_destination : '';
            $sale_contract->container_1 = !empty($request->container_qty_1) ? $request->container_qty_1 . 'X' . '20 Feet' : NULL;
            $sale_contract->container_2 = !empty($request->container_qty_2) ? $request->container_qty_2 . 'X' . '40 Feet' : NULL;
            $sale_contract->container_3 = !empty($request->container_qty_3) ? $request->container_qty_3 . 'X' . '40 HC' : NULL;
            $sale_contract->total_container = (!empty($request->container_qty_1) ? $request->container_qty_1 : 0) + (!empty($request->container_qty_2) ? $request->container_qty_2 : 0) + (!empty($request->container_qty_3) ? $request->container_qty_3 : 0);
            $sale_contract->container_qty_1 = !empty($request->container_qty_1) ? $request->container_qty_1 : 0;
            $sale_contract->container_qty_2 = !empty($request->container_qty_2) ? $request->container_qty_2 : 0;
            $sale_contract->container_qty_3 = !empty($request->container_qty_3) ? $request->container_qty_3 : 0;
            $sale_contract->freight_cost_1 = !empty($request->freight_cost_1) ? $request->freight_cost_1 : 0;
            $sale_contract->freight_cost_2 = !empty($request->freight_cost_2) ? $request->freight_cost_2 : 0;
            $sale_contract->freight_cost_3 = !empty($request->freight_cost_3) ? $request->freight_cost_3 : 0;
            $sale_contract->freight_cost = (!empty($request->freight_cost_1) ? $request->freight_cost_1 : 0) + (!empty($request->freight_cost_2) ? $request->freight_cost_2 : 0) + (!empty($request->freight_cost_3) ? $request->freight_cost_3 : 0);
            $sale_contract->desk_freight_cost = isset($request->desk_freight_cost) ? $request->desk_freight_cost : 0;
            $sale_contract->qtan_freight_cost = isset($request->qtan_freight_cost) ? $request->qtan_freight_cost : 0;
            $sale_contract->terms_and_condition = isset($request->terms_and_condition) ? $request->terms_and_condition : '';
            $sale_contract->terms_and_condition_desk_inv = isset($request->terms_and_condition_desk_inv) ? $request->terms_and_condition_desk_inv : '';
            $sale_contract->importer_country = isset($request->importer_country) ? $request->importer_country : '';
            $sale_contract->angikar_given_by = isset($request->angikar_given_by) ? $request->angikar_given_by : '';
            $sale_contract->is_revised = isset($request->is_revised) ? $request->is_revised : 0;
            $sale_contract->is_master = isset($request->is_master) ? $request->is_master : 0;
            $sale_contract->is_proforma_invoice = isset($request->is_proforma_invoice) ? $request->is_proforma_invoice : 0;
            $sale_contract->footer_importer_address = isset($request->footer_importer_address) ? $request->footer_importer_address : 0;
            $sale_contract->third_notify_party = isset($request->third_notify_party) ? $request->third_notify_party : '';
            $sale_contract->creator_id = Auth::user()->id;
            $sale_contract->party_name = isset($request->party_name) ? trim($request->party_name) : '';
            $sale_contract->party_address = isset($request->party_address) ? trim($request->party_address) : '';
            $sale_contract->importer_name = !empty($request->importer_id) ? Importer::where('id', $request->importer_id)->value('name') : '';
            $sale_contract->importer_address = isset($request->importer_address) ? trim($request->importer_address) : '';
            $sale_contract->advance_payment = !empty($request->advance_payment) ? $request->advance_payment : 0;
            $sale_contract->po_number = POMaster::where('ID',$request->po_id)->value('id');
            $sale_contract->po_master_id = $request->po_id ? $request->po_id : NULL;
            $sale_contract->currency_id = 1;
            $sale_contract->sc_type = 1;
            $sale_contract->save();
            $poItems = ($request->upload_from == 'order' && !empty($request->po_items)) ? json_decode($request->po_items, true) : [];
            if(!empty($poItems)) {
                foreach($poItems as $item) {
                    $ci_item = CiItem::where('ci_item_code', isset($item['item_code']) ? $item['item_code'] : '')->first();
                    if($ci_item) {
                        $party_item = NotifyPartyItem::where('ci_item_id', $ci_item->id)->where('notify_party_id', $request->notify_pary_id)->first(['desk_item_name']);
                        $sale_contract_detail = new SaleContractDetail();
                        $sale_contract_detail->ccq = 0;
                        $sale_contract_detail->ci_item_id = $ci_item->id;
                        $sale_contract_detail->po_line_id = isset($item['po_line_id']) ? $item['po_line_id'] : NULL;
                        $sale_contract_detail->ci_item_name = isset($ci_item->duplicate_name) ? $ci_item->duplicate_name : '';
                        $sale_contract_detail->sale_contract_id = $sale_contract->id;
                        $sale_contract_detail->rate_per_ctn = isset($ci_item->ci_item_rate) ? $ci_item->ci_item_rate : 0;
                        $sale_contract_detail->hs_code = isset($item['hs_code']) ? $item['hs_code'] : '';
                        $sale_contract_detail->desk_item_name = isset($party_item->desk_item_name) ? $party_item->desk_item_name : (isset($item['item_name']) ? $item['item_name'] : '');
                        $sale_contract_detail->ctn = isset($item['total_ctn']) ? $item['total_ctn'] : 0;
                        $sale_contract_detail->rate_per_ctn_for_party = isset($item['party_rate_per_ctn']) ? $item['party_rate_per_ctn'] : 0;
                        $sale_contract_detail->total_amount_party = isset($item['total_party_value']) ? $item['total_party_value'] : 0;
                        $sale_contract_detail->total_amount = (isset($ci_item->ci_item_rate) ? $ci_item->ci_item_rate : 0) * (isset($item['total_ctn']) ? $item['total_ctn'] : 0);
                        $sale_contract_detail->rate_per_ctn_for_acc = isset($item['acc_rate_per_ctn']) ? $item['acc_rate_per_ctn'] : 0;
                        $sale_contract_detail->total_amount_acc = isset($item['total_acc_value']) ? $item['total_acc_value'] : 0;
                        $sale_contract_detail->pcs_in_ctn = (isset($item['total_ctn']) ? $item['total_ctn'] : 0) * (isset($ci_item->ci_factor) ? $ci_item->ci_factor : 0);
                        $sale_contract_detail->factor = isset($ci_item->ci_factor) ? $ci_item->ci_factor : 0;
                        $sale_contract_detail->cbm_per_ctn = isset($item['cbm_per_ctn']) ? round($item['cbm_per_ctn'], 6) : 0;
                        $sale_contract_detail->total_cbm = isset($item['total_cbm']) ? $item['total_cbm'] : 0;
                        $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = 0;
                        $sale_contract_detail->per_ctn_freight = 0;
                        $sale_contract_detail->ci_rate_pl_freight = 0;
                        $sale_contract_detail->net_weight_kg = (isset($item['total_ctn']) ? $item['total_ctn'] : 0) * (isset($ci_item->d_net_weight) ? $ci_item->d_net_weight : 0);
                        $sale_contract_detail->hs_code_2 = isset($item['hs_code2']) ? $item['hs_code2'] : '';
                        $sale_contract_detail->gross_weight_per_item = isset($item['gross_weight']) ? $item['gross_weight'] : 0;
                        $sale_contract_detail->claim_amount = 0;
                        $sale_contract_detail->gross_weight_kg = (isset($item['total_ctn']) ? $item['total_ctn'] : 0) * (isset($item['gross_weight']) ? $item['gross_weight'] : 0);
                        $sale_contract_detail->bapa_percent = isset($ci_item->bapa_percent) ? $ci_item->bapa_percent : 0;
                        $sale_contract_detail->bu_id = isset($ci_item->bu_id) ? $ci_item->bu_id : 0;
                        $sale_contract_detail->sample_qty = isset($item['sample_qty']) ? $item['sample_qty'] : 0;
                        $sale_contract_detail->mfg = NULL;
                        $sale_contract_detail->exp = NULL;
                        $sale_contract_detail->barcode = NULL;
                        $sale_contract_detail->batch_no = NULL;
                        $sale_contract_detail->save();
                    }
                }
            }
            
            $results = DB::select("SELECT * FROM tbl_sc_temp WHERE user_id = ? ORDER BY id ASC", [$user_id]);
            if(!empty($results)) {
                foreach ($results as $value) {
                    $ci_item = CiItem::where('ci_item_code', isset($value->item_code) ? $value->item_code : '')->first();
                    
                    if ($ci_item) {
                        $party_item = NotifyPartyItem::where('ci_item_id', $ci_item->id)
                            ->where('notify_party_id', $request->notify_pary_id)
                            ->first(['desk_item_name']);
                        
                        $sale_contract_detail = new SaleContractDetail();
                        $sale_contract_detail->ccq = 0;
                        $sale_contract_detail->ci_item_id = $ci_item->id;
                        $sale_contract_detail->ci_item_name = isset($ci_item->duplicate_name) ? $ci_item->duplicate_name : '';
                        $sale_contract_detail->sale_contract_id = $sale_contract->id;
                        $sale_contract_detail->rate_per_ctn = isset($ci_item->ci_item_rate) ? $ci_item->ci_item_rate : 0;
                        $sale_contract_detail->hs_code = isset($value->hs_code) ? $value->hs_code : '';
                        $sale_contract_detail->desk_item_name = isset($party_item->desk_item_name) ? $party_item->desk_item_name : (isset($value->item_name) ? $value->item_name : '');
                        $sale_contract_detail->ctn = isset($value->total_ctn) ? $value->total_ctn : 0;
                        $sale_contract_detail->rate_per_ctn_for_party = isset($value->party_rate_per_ctn) ? $value->party_rate_per_ctn : 0;
                        $sale_contract_detail->total_amount_party = isset($value->total_party_value) ? $value->total_party_value : 0;
                        $sale_contract_detail->total_amount = (isset($ci_item->ci_item_rate) ? $ci_item->ci_item_rate : 0) * (isset($value->total_ctn) ? $value->total_ctn : 0);
                        $sale_contract_detail->rate_per_ctn_for_acc = isset($value->acc_rate_per_ctn) ? $value->acc_rate_per_ctn : 0;
                        $sale_contract_detail->total_amount_acc = isset($value->total_acc_value) ? $value->total_acc_value : 0;
                        $sale_contract_detail->pcs_in_ctn = (isset($value->total_ctn) ? $value->total_ctn : 0) * (isset($ci_item->ci_factor) ? $ci_item->ci_factor : 0);
                        $sale_contract_detail->factor = isset($ci_item->ci_factor) ? $ci_item->ci_factor : 0;
                        $sale_contract_detail->cbm_per_ctn = isset($value->cbm_per_ctn) ? round($value->cbm_per_ctn, 6) : 0;
                        $sale_contract_detail->total_cbm = isset($value->total_cbm) ? $value->total_cbm : 0;
                        $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = 0;
                        $sale_contract_detail->per_ctn_freight = 0;
                        $sale_contract_detail->ci_rate_pl_freight = 0;
                        $sale_contract_detail->net_weight_kg = (isset($value->total_ctn) ? $value->total_ctn : 0) * (isset($ci_item->d_net_weight) ? $ci_item->d_net_weight : 0);
                        $sale_contract_detail->hs_code_2 = isset($value->hs_code2) ? $value->hs_code2 : '';
                        $sale_contract_detail->gross_weight_per_item = isset($value->gross_weight) ? $value->gross_weight : 0;
                        $sale_contract_detail->claim_amount = 0;
                        $sale_contract_detail->gross_weight_kg = (isset($value->total_ctn) ? $value->total_ctn : 0) * (isset($value->gross_weight) ? $value->gross_weight : 0);
                        $sale_contract_detail->bapa_percent = isset($ci_item->bapa_percent) ? $ci_item->bapa_percent : 0;
                        $sale_contract_detail->bu_id = isset($ci_item->bu_id) ? $ci_item->bu_id : 0;
                        $sale_contract_detail->sample_qty = isset($value->sample_qty) ? $value->sample_qty : 0;
                        $sale_contract_detail->mfg = NULL;
                        $sale_contract_detail->exp = NULL;
                        $sale_contract_detail->barcode = NULL;
                        $sale_contract_detail->batch_no = NULL;
                        $sale_contract_detail->save();
                    }
                }
            }

            ScTemp::where('user_id', $user_id)->delete();
            $this->manageFreight($sale_contract->id);
            $this->manageCCQ($sale_contract->id);
            $this->updateCiTotalValue($sale_contract->id);
            return response()->json([
                'success' => true,
                'message' => 'Data processed successfully',
                'scId' => $sale_contract->id
            ]);
        }
        
        if ($request->action == "update") {
            
            SaleContract::where('id', $request->insert_sc_id)->update([
                'invoice_date' => !empty($request->invoice_date) ? date("Y-m-d", strtotime($request->invoice_date)) : '',
                'export_no' => isset($request->export_no) ? $request->export_no : '',
                'export_date' => !empty($request->export_date) ? date("Y-m-d", strtotime($request->export_date)) : NULL,
                'terms_and_condition_desk_inv' => isset($request->terms_and_condition_desk_inv) ? $request->terms_and_condition_desk_inv : '',
                'bl_no' => isset($request->bl_no) ? $request->bl_no : '',
                'bl_date' => !empty($request->bl_date) ? date("Y-m-d", strtotime($request->bl_date)) : NULL,
                'bl_date_cer' => !empty($request->bl_date_cer) ? date("Y-m-d", strtotime($request->bl_date_cer)) : NULL,
                'importer_country' => isset($request->importer_country) ? $request->importer_country : '',
                'angikar_given_by' => isset($request->angikar_given_by) ? $request->angikar_given_by : '',
                'freight_charge_india' => isset($request->freight_charge_india) ? $request->freight_charge_india : 0,
                'tr_report_date' => isset($request->tr_report_date) ? $request->tr_report_date : NULL,
                'phyto_product_name' => isset($request->phyto_product_name) ? $request->phyto_product_name : '',
                'is_notify_also_notity' => isset($request->is_notify_also_notity) ? $request->is_notify_also_notity : 0,
                'vehicle' => isset($request->vehicle) ? $request->vehicle : '',
                'revise_product_name' => isset($request->revise_product_name) ? $request->revise_product_name : '',
                'factory_address_type' => isset($request->factory_address_type_id) ? $request->factory_address_type_id : 0,
                'third_notify_party' => isset($request->third_notify_party) ? $request->third_notify_party : '',
                'insurance_charge' => isset($request->insurance_charge) ? $request->insurance_charge : '',
                'pallet_charge' => isset($request->pallet_charge) ? $request->pallet_charge : '',
                'foreign_port' => isset($request->foreign_port) ? $request->foreign_port : '',
                'bd_port' => isset($request->bd_port) ? $request->bd_port : '',
                'tr_no_is_exist' => isset($request->tr_no_is_exist) ? $request->tr_no_is_exist : 0,
                'address_replace' => isset($request->address_replace) ? $request->address_replace : 0,
                'transport_agency_id' => isset($request->transport_agency_id) ? $request->transport_agency_id : 0,
                'bank_address_for_india' => isset($request->bank_address_for_india) ? $request->bank_address_for_india : '',
                'lc_term_for_india' => isset($request->lc_term_for_india) ? $request->lc_term_for_india : '',
                'is_total_amount_oceania' => isset($request->is_total_amount_oceania) ? $request->is_total_amount_oceania : 0,
                'lot_number' => isset($request->lot_number) ? $request->lot_number : '',
                'custom_decleration' => isset($request->custom_decleration) ? $request->custom_decleration : '',
                'best_before_india' => isset($request->best_before_india) ? $request->best_before_india : 0,
                'gsp_ref_number' => isset($request->gsp_ref_number) ? $request->gsp_ref_number : '',
                'shipping_mark_india' => isset($request->shipping_mark_india) ? $request->shipping_mark_india : '',
                'safta_dated' => !empty($request->safta_dated) ? date("Y-m-d", strtotime($request->safta_dated)) : NULL,
                'freight_date' => !empty($request->freight_date) ? date("Y-m-d", strtotime($request->freight_date)) : NULL,
                'mfg_date_india' => isset($request->mfg_date_india) ? $request->mfg_date_india : 0,
                'india_mfg_setup_date' => isset($request->india_mfg_setup_date) ? $request->india_mfg_setup_date : NULL,
                'dcc_memo_no' => isset($request->dcc_memo_no) ? $request->dcc_memo_no : '',
                'shipping_line_id' => isset($request->shipping_line_id) ? $request->shipping_line_id : 0,
                'name_of_shipping_line_id' => isset($request->name_of_shipping_line_id) ? $request->name_of_shipping_line_id : 0,
                'freight_amount_fc' => isset($request->freight_amount_fc) ? $request->freight_amount_fc : 0,
                'freight_amount_btd' => isset($request->freight_amount_btd) ? $request->freight_amount_btd : 0,
                'custom_station_id' => isset($request->custom_station_id) ? $request->custom_station_id : 0,
                'arv_amount' => isset($request->arv_amount) ? $request->arv_amount : 0,
                'cnf_print_date' => !empty($request->cnf_print_date) ? date("Y-m-d", strtotime($request->cnf_print_date)) : NULL,
                'master_airway_bill_no' => isset($request->master_airway_bill_no) ? $request->master_airway_bill_no : '',
                'master_airway_bill_date' => !empty($request->master_airway_bill_date) ? date("Y-m-d", strtotime($request->master_airway_bill_date)) : NULL,
                'arv_amount_received_date' => !empty($request->arv_amount_received_date) ? date('Y-m-d H:i:s', strtotime($request->arv_amount_received_date)) : NULL,
                'salary_adjustment' => isset($request->salary_adjustment) ? $request->salary_adjustment : 0,
                'mv_or_voy' => isset($request->mv_or_voy) ? $request->mv_or_voy : '',
                'container_number' => isset($request->container_number) ? $request->container_number : '',
                'add_also_notify_party' => isset($request->add_also_notify_party) ? $request->add_also_notify_party : 0,
                'is_fob' => isset($request->is_fob) ? $request->is_fob : 0,
                'oc_date' => !empty($request->oc_date) ? date("Y-m-d", strtotime($request->oc_date)) : NULL
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data processed successfully'
            ]);
        }
    }

    public function saleContractEidt(Request $request){

        $partyId = base64_decode($request->query('partyId'));
        $scid = base64_decode($request->query('scid'));
        $user_id = Auth::user()->id;
        $notify_party_ids = NotifyPartyUser::where('user_id', $user_id)->where('status', '1')->pluck('notify_party_id');
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
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'");  
        $sale_contract = SaleContract::find($scid);
        $templateNames=TemplateMaster::all();
        $transportAgencyies=TransportAgency::all();
        $shippingLines=ShippingLine::all();
        $customStations=CustomStation::all();
        $party_items=DB::select("select
                ci_items.id,
                ci_items.ci_item_code as item_code,
                ci_items.ci_item_name as item_name
            from notify_party_items
            join ci_items on ci_items.id = notify_party_items.ci_item_id
            where notify_party_items.notify_party_id = '$partyId'
            order by id asc");

        $container_qty1=0;
        $container_qty2=0;
        $container_qty3=0;

        $container_qty1 = ($sale_contract->container_qty_1) ? $sale_contract->container_qty_1 : (($sale_contract->container_1) ? intval(strtok($sale_contract->container_1, 'x')) : 0);
        $container_qty2 = ($sale_contract->container_qty_2) ? $sale_contract->container_qty_2 : (($sale_contract->container_2) ? intval(strtok($sale_contract->container_2, 'x')) : 0);
        $container_qty3 = ($sale_contract->container_qty_3) ? $sale_contract->container_qty_3 : (($sale_contract->container_3) ? intval(strtok($sale_contract->container_3, 'x')) : 0);    
        return view("sale_contract.sale_contract_edit2")
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
             ->with('container_qty1',$container_qty1)
             ->with('container_qty2',$container_qty2)
             ->with('container_qty3',$container_qty3)
             ->with("partyId" ,$partyId)
             ->with("notifyParties" ,$notifyParties)
             ->with('shippingLines',$shippingLines)
             ->with('transportAgencyies',$transportAgencyies)
             ->with('customStations',$customStations)
             ->with("sale_contract" ,$sale_contract)
             ->with("party_items" ,$party_items)
             ->with("scid" ,$scid);
            //  ->with('templateNames',$templateNames)

    }

    public function salesContractEditDoc(Request $request){

        $partyId = base64_decode($request->query('partyId'));
        $scid = base64_decode($request->query('scid'));
        $user_id = Auth::user()->id;
        $notify_party_ids = NotifyPartyUser::where('user_id', $user_id)->where('status', '1')->pluck('notify_party_id');
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
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'");  
        $sale_contract = SaleContract::find($scid);
        $templateNames=TemplateMaster::all();
        $transportAgencyies=TransportAgency::all();
        $shippingLines=ShippingLine::all();
        $customStations=CustomStation::all();
        $party_items=DB::select("select
                ci_items.id,
                ci_items.ci_item_code as item_code,
                ci_items.ci_item_name as item_name
            from notify_party_items
            join ci_items on ci_items.id = notify_party_items.ci_item_id
            where notify_party_items.notify_party_id = '$partyId'
            order by id asc");
        $container_qty1=0;
        $container_qty2=0;
        $container_qty3=0;
        $container_qty1 = ($sale_contract->container_qty_1) ? $sale_contract->container_qty_1 : (($sale_contract->container_1) ? intval(strtok($sale_contract->container_1, 'x')) : 0);
        $container_qty2 = ($sale_contract->container_qty_2) ? $sale_contract->container_qty_2 : (($sale_contract->container_2) ? intval(strtok($sale_contract->container_2, 'x')) : 0);
        $container_qty3 = ($sale_contract->container_qty_3) ? $sale_contract->container_qty_3 : (($sale_contract->container_3) ? intval(strtok($sale_contract->container_3, 'x')) : 0);    
        return view("sale_contract.sale_contract_edit_doc")
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
             ->with('container_qty1',$container_qty1)
             ->with('container_qty2',$container_qty2)
             ->with('container_qty3',$container_qty3)
             ->with("partyId" ,$partyId)
             ->with("notifyParties" ,$notifyParties)
             ->with('shippingLines',$shippingLines)
             ->with('transportAgencyies',$transportAgencyies)
             ->with('customStations',$customStations)
             ->with("sale_contract" ,$sale_contract)
             ->with("party_items" ,$party_items)
             ->with("scid" ,$scid);
            //  ->with('templateNames',$templateNames)

    }


    public function getScEditItem(Request $request){

        $sc_id=$request->sc_id;
        $results=DB::select("SELECT
            scd.id,
            ci.ci_item_code AS item_code,
            scd.desk_item_name AS item_name,
            scd.ci_item_name AS doc_name,
            scd.ctn AS total_ctn,
            scd.factor,
            scd.rate_per_ctn_for_acc AS acc_rate_per_ctn,
            scd.rate_per_ctn_for_party AS party_rate_per_ctn,
            scd.rate_per_ctn AS ci_rate_per_ctn,
            round(scd.cbm_per_ctn,6) as cbm_per_ctn,
            scd.gross_weight_kg as gross_weight,
            scd.hs_code,
            COALESCE(scd.hs_code_2, '') AS hs_code2,
            round(scd.total_cbm,6) as total_cbm,
            scd.total_amount_acc AS total_acc_value,
            scd.total_amount_party AS total_party_value,
            scd.total_amount AS total_ci_value,
            scd.sample_qty AS sample_qty
        FROM sale_contract_details AS scd
        INNER JOIN sale_contracts AS sc ON sc.id = scd.sale_contract_id
        INNER JOIN ci_items AS ci ON ci.id = scd.ci_item_id
        WHERE scd.sale_contract_id='$sc_id'"); 

        if($results){

             return response()->json([
                'code'=>200,
                'Message'=>'Item Found',
                'data'=>$results
            ]);

        } else {

            return response()->json([
                'message' => "Item Not Found",
                "code"    => 500,
                "data" =>[]

            ]);

        }   

    }

    public function jsonHandleFreight(Request $request){

        $sc_id=$request->sc_id;
        $freightApiLogStatus=FreightLogHistory::where('sc_id', $sc_id)->count() > 0 ? 1 : 0;
        return response()->json([
            'code'=>200,
            'status'=>$freightApiLogStatus
        ]);
    }

    public function getScEditItemDetails(Request $request){
           
        $party_id=SaleContract::where('id',$request->sc_id)->value('notify_pary_id');
        $items=DB::select("select
                ci_items.id,
                ci_items.ci_item_code as item_code,
                ci_items.ci_item_name as item_name
            from notify_party_items
            join ci_items on ci_items.id = notify_party_items.ci_item_id
            where notify_party_items.notify_party_id = '$party_id' and ci_items.ci_item_code='$request->itemCode'
            order by id asc");

        $result=SaleContractDetail::where('id',$request->itemId)->first(); 
        return response()->json([
            'data'=>$result,
            'items'=>$items,
            'edit_item_code'=>$request->itemCode
        ]);

    }

    public function updateDocItem(Request $request){
       
        $result = DB::selectOne("SELECT
            sale_contract_details.id,
            ci_items.id as item_id,
            ci_item_code AS item_code,
            sale_contract_details.desk_item_name AS item_name,
            sale_contract_details.ci_item_name AS doc_name,
            sale_contract_details.ctn AS total_ctn,
            sale_contract_details.factor,
            sale_contract_details.rate_per_ctn_for_acc AS acc_rate_per_ctn,
            sale_contract_details.rate_per_ctn_for_party AS party_rate_per_ctn,
            sale_contract_details.rate_per_ctn AS ci_rate_per_ctn,
            sale_contract_details.cbm_per_ctn,
            sale_contract_details.gross_weight_per_item AS gross_weight,
            sale_contract_details.hs_code,
            IF(sale_contract_details.hs_code_2, sale_contract_details.hs_code_2, '') AS hs_code2,
            sale_contract_details.total_cbm AS total_cbm,
            sale_contract_details.total_amount_acc AS total_acc_value,
            sale_contract_details.total_amount_party AS total_party_value,
            sale_contract_details.total_amount AS total_ci_value
        FROM sale_contract_details
        JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
        WHERE sale_contract_details.id = ?", [$request->itemId]);
        $party_id=SaleContract::where('id',$request->sc_id)->value('notify_pary_id');  
        $items = \DB::select("
            SELECT
                ci_items.id AS item_id,
                ci_items.ci_item_name,
                ci_items.ci_item_code as item_code
            FROM ci_items
            JOIN notify_party_items ON ci_items.id = notify_party_items.ci_item_id
            JOIN notify_parties ON notify_parties.id = notify_party_items.notify_party_id
            WHERE notify_parties.id = :party_id
        ", ['party_id' => $party_id]);     

        if($result){

            return response()->json([
                'code'=>200,
                'Message'=>'Item Found',
                'data'=>$result,
                'items'=>$items
            ]);

        } else {

            return response()->json([
                'message' => "Item Not Found",
                "code"    => 500,
                "data" =>[],
                "items"=>$items

            ]);

        }  

    }

    public function updateScDeskItem(Request $request){
        
        $gross_weight=NotifyPartyItem::where('notify_party_id',SaleContract::where('id',$request->sc_id)->value('notify_pary_id'))->where('ci_item_id',$request->e_ci_item_id)->value('gross_weight');
        $ci_item = CiItem::find($request->e_ci_item_id);   
        $item_line_id = $request->item_line_id;
        $sale_contract_detail = SaleContractDetail::findorfail($item_line_id);
        $sale_contract_detail->ccq=0;
        $sale_contract_detail->sale_contract_id                 = $request->sc_id;
        $sale_contract_detail->ci_item_id                       = $request->e_ci_item_id;
        $sale_contract_detail->ci_item_name                     = $ci_item->duplicate_name; 
        $sale_contract_detail->rate_per_ctn                     = $ci_item->ci_item_rate;
        $sale_contract_detail->rate_per_ctn_for_party           = $request->e_rate_per_ctn_for_party;
        $sale_contract_detail->rate_per_ctn_for_acc             = $request->e_rate_per_ctn_for_acc;
        $sale_contract_detail->ctn                              = $request->e_ctn;
        $sale_contract_detail->pcs_in_ctn                       = $request->e_ctn * $ci_item->ci_factor;
        $sale_contract_detail->factor                           = $ci_item->ci_factor;
        $sale_contract_detail->is_eligible                      = $ci_item->is_ci_eligible;
        $sale_contract_detail->cbm_per_ctn                      = $request->e_cbm_per_ctn;
        $sale_contract_detail->total_cbm                        = $request->e_cbm_per_ctn * $request->e_ctn;
        $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm   = 0;
        $sale_contract_detail->per_ctn_freight                  = 0;
        $sale_contract_detail->ci_rate_pl_freight               = 0;
        $sale_contract_detail->total_amount                     = $ci_item->ci_item_rate*$request->e_ctn;
        $sale_contract_detail->total_amount_party               = $request->e_rate_per_ctn_for_party*$request->e_ctn;
        $sale_contract_detail->total_amount_acc                 = $request->e_rate_per_ctn_for_acc*$request->e_ctn;
        $sale_contract_detail->net_weight_kg                    = $request->e_ctn * $ci_item->d_net_weight;
        $sale_contract_detail->gross_weight_per_item            = round($request->e_gross_weight/$ci_item->ci_item_rate,6);
        $sale_contract_detail->gross_weight_kg                  = round($gross_weight * $request->e_ctn,6);
        $sale_contract_detail->bapa_percent                     = $ci_item->bapa_percent;
        $sale_contract_detail->claim_amount                     = ($ci_item->bapa_percent * $sale_contract_detail->total_amount ) / 100;
        $sale_contract_detail->bu_id                            = $ci_item->bu_id;
        $sale_contract_detail->sample_qty                       = $request->sample_qty;
        if($request->mfg){
            $sale_contract_detail->mfg                          = date("Y-m-d",strtotime($request->mfg));
        }

        if($request->mfg==""){
           $sale_contract_detail->mfg = NULL;
        }

        if($request->exp){
           $sale_contract_detail->exp                           = date("Y-m-d",strtotime($request->exp)); 
        }

        if($request->exp==""){
           $sale_contract_detail->exp = NULL;
        }

        $sale_contract_detail->hs_code                          = $request->e_hs_code;
        $sale_contract_detail->hs_code_2                        = $request->e_hs_code_2;
        $sale_contract_detail->container_no                     = $request->container_no;
        $sale_contract_detail->batch_no                         = $request->batch_no;
        $sale_contract_detail->desk_item_name                   = $request->e_desk_item_name;
        $sale_contract_detail ->save();
        $this->manageFreight($request->sc_id);
        $this->manageCCQ($request->sc_id);
        $this->updateCiTotalValue($request->sc_id);

        $results=DB::select("SELECT
            sale_contract_details.id,
            ci_item_code as item_code,
            sale_contract_details.desk_item_name as item_name,
            sale_contract_details.ctn as total_ctn,
            sale_contract_details.rate_per_ctn_for_acc as acc_rate_per_ctn,
            sale_contract_details.rate_per_ctn_for_party as party_rate_per_ctn,
            sale_contract_details.cbm_per_ctn as cbm_per_ctn,
            sale_contract_details.total_cbm as total_cbm,
            sale_contract_details.factor,
            sale_contract_details.gross_weight_kg as gross_weight,
            sale_contract_details.hs_code,
            if(sale_contract_details.hs_code_2,sale_contract_details.hs_code_2,'') as hs_code2,
            sale_contract_details.total_amount_acc as total_acc_value,
            sale_contract_details.total_amount_party as total_party_value,
            sale_contract_details.sample_qty
        FROM `sale_contract_details`
        join ci_items on ci_items.id=sale_contract_details.ci_item_id
        WHERE `sale_contract_id`='$request->sc_id'
        order by sale_contract_details.id ASC"); 

        if($results){

            return response()->json([
                'code'=>200,
                'msg'=>'Update Successfully Done',
                'data'=>$results
            ]);

        } else {

            return response()->json([
                'msg' => "Data Not Found",
                "code"    => 500,
                "data" =>[]

            ]);

        } 

    }

    public function updateItemDocInfo(Request $request)
    {
        try {

            $sale_contract_detail = SaleContractDetail::find($request->item_line_id);
            if (!$sale_contract_detail) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Item not found.'
                ]);
            }

            $sale_contract_detail->ci_item_name = $request->e_doc_name;
            $sale_contract_detail->hs_code = $request->e_hs_code;
            $sale_contract_detail->ctn = $request->e_ctn;
            $sale_contract_detail->cbm_per_ctn = $request->e_cbm_per_ctn;
            $sale_contract_detail->total_cbm = $request->e_total_cbm;
            $sale_contract_detail->hs_code_2 = $request->e_hs_code2;
            $sale_contract_detail->rate_per_ctn = $request->e_doc_ctn_rate;
            $sale_contract_detail->total_amount = $request->e_doc_ctn_rate * $request->ctn;
            $sale_contract_detail->save();

            // optional helper functions
            $this->manageFreight($request->sc_id);
            $this->manageCCQ($request->sc_id);
            $this->updateCiTotalValue($request->sc_id);
            $results=DB::select("SELECT
                    sale_contract_details.id,
                    ci_item_code as item_code,
                    sale_contract_details.desk_item_name as item_name,
                    sale_contract_details.ci_item_name as doc_name,
                    sale_contract_details.ctn as total_ctn,
                    sale_contract_details.factor,
                    sale_contract_details.rate_per_ctn_for_acc as acc_rate_per_ctn,
                    sale_contract_details.rate_per_ctn_for_party as party_rate_per_ctn,
                    sale_contract_details.rate_per_ctn as ci_rate_per_ctn,
                    sale_contract_details.cbm_per_ctn,
                    sale_contract_details.gross_weight_kg as gross_weight,
                    sale_contract_details.hs_code,
                    if(sale_contract_details.hs_code_2,sale_contract_details.hs_code_2,'') as hs_code2,
                    sale_contract_details.total_cbm as total_cbm,
                    sale_contract_details.total_amount_acc as total_acc_value,
                    sale_contract_details.total_amount_party as total_party_value,
                    sale_contract_details.total_amount as total_ci_value
            FROM `sale_contract_details`
            join ci_items on ci_items.id=sale_contract_details.ci_item_id
            WHERE `sale_contract_id`='$request->sc_id'"); 
            return response()->json([
                'status' => 'success',
                'msg' => 'Item updated successfully!',
                'data' => $results
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to update item. ' . $e->getMessage(),
                'data' => []
            ]);
        }

    }

    public function updateSalesContract(Request $request){

        $itemsTable = json_decode($request->table_items, true);
        if($request->action=="insert"){

            $terms = $request->terms_and_condition;
            if (strpos($terms, 'EXPIRY OF THIS SALES CONTRACT') !== false) {
                $terms = preg_replace('/^.*EXPIRY OF THIS SALES CONTRACT.*(\r?\n)?/mi', '', $terms);
            }

            preg_match_all('/^\d+\./m', $terms, $matches);
            $nextNumber = count($matches[0]) + 1;
            $newDate = date('d-m-Y', strtotime($request->dated . ' +180 days'));
            $newLine = $nextNumber . '. EXPIRY OF THIS SALES CONTRACT ON: ' . $newDate;
            $terms = trim($terms) . "\n" . $newLine;

            $sale_contract = SaleContract::find($request->sc_header_editId);
            $sale_contract->sales_contract_no = str_replace('/', '-', $request->sales_contract_no);
            $sale_contract->dated = date("Y-m-d", strtotime($request->dated));
            // $sale_contract->invoice_no = str_replace('/', '-', ltrim($request->invoice_no == '' ? $request->sales_contract_no : $request->invoice_no));
            $sale_contract->invoice_no = str_replace('/', '-', $request->invoice_no);
            if ($request->invoice_date) {
                $sale_contract->invoice_date = date("Y-m-d", strtotime($request->invoice_date));
            }
            $sale_contract->ci_note = $request->ci_note;
            $sale_contract->discharge_port = $request->discharge_port;
            $sale_contract->country_id = $request->country_id;
            $sale_contract->sales_term_id = $request->sales_term_id;
            $sale_contract->company_id = $request->company_id;
            $sale_contract->bank_id = $request->bank_id;
            $sale_contract->account_number = CompanyBank::where('company_id', $request->company_id)->where('bank_id', $request->bank_id)->value('account_number');
            $sale_contract->importer_id = $request->importer_id;
            $sale_contract->bank_importer_id = $request->bank_importer_id;
            $sale_contract->notify_pary_id = $request->notify_pary_id;
            $sale_contract->carrying_mode_id = $request->carrying_mode_id;
            $sale_contract->loading_place_id = $request->loading_place_id;
            $sale_contract->final_destination = $request->final_destination;
            $sale_contract->container_1 = $request->container_qty_1 ? $request->container_qty_1 . 'X' . '20 Feet' : NULL;
            $sale_contract->container_2 = $request->container_qty_2 ? $request->container_qty_2 . 'X' . '40 Feet' : NULL;
            $sale_contract->container_3 = $request->container_qty_3 ? $request->container_qty_3 . 'X' . '40 HC' : NULL;
            $sale_contract->total_container = ($request->container_qty_1 ? $request->container_qty_1 : 0) + ($request->container_qty_2 ? $request->container_qty_2 : 0) + ($request->container_qty_3 ? $request->container_qty_3 : 0);
            $sale_contract->container_qty_1 = $request->container_qty_1 ? $request->container_qty_1 : 0;
            $sale_contract->container_qty_2 = $request->container_qty_2 ? $request->container_qty_2 : 0;
            $sale_contract->container_qty_3 = $request->container_qty_3 ? $request->container_qty_3 : 0;
            $sale_contract->freight_cost_1 = $request->freight_cost_1 ? $request->freight_cost_1 : 0;
            $sale_contract->freight_cost_2 = $request->freight_cost_2 ? $request->freight_cost_2 : 0;
            $sale_contract->freight_cost_3 = $request->freight_cost_3 ? $request->freight_cost_3 : 0;
            $sale_contract->freight_cost = ($request->freight_cost_1 ? $request->freight_cost_1 : 0) + ($request->freight_cost_2 ? $request->freight_cost_2 : 0) + ($request->freight_cost_3 ? $request->freight_cost_3 : 0);
            $sale_contract->desk_freight_cost = $request->desk_freight_cost;
            $sale_contract->qtan_freight_cost = $request->qtan_freight_cost;
            $sale_contract->terms_and_condition = $terms;
            $sale_contract->importer_country = $request->importer_country;
            $sale_contract->angikar_given_by = $request->angikar_given_by;
            $sale_contract->is_revised = $request->is_revised;
            $sale_contract->is_master = $request->is_master;
            $sale_contract->is_proforma_invoice = $request->is_proforma_invoice;
            $sale_contract->footer_importer_address = $request->footer_importer_address;
            $sale_contract->third_notify_party = $request->third_notify_party;
            $sale_contract->creator_id = Auth::user()->id;
            $sale_contract->party_name = trim($request->party_name);
            $sale_contract->party_address = trim($request->party_address);
            $sale_contract->importer_name = Importer::where('id',$request->importer_id)->value('name');
            $sale_contract->importer_address = $request->importer_address;
            $sale_contract->advance_payment = $request->advance_payment ? $request->advance_payment : 0;
            $sale_contract->po_number = 1;
            $sale_contract->currency_id = 1;
            $sale_contract->billed_to = $request->is_billed_to ? $request->is_billed_to : NULL;
            $sale_contract->po_master_id = $request->po_id ? $request->po_id : 2;
            $sale_contract->sc_type = 1;
            $sale_contract->save();
            foreach($itemsTable as $item) {
                        
                $ci_item = CiItem::where('ci_item_code',$item['item_code'])->first();
                if($ci_item){
                        
                    if($this->isCiDetailAlreadyExist($request->sc_header_editId,$ci_item->id)){
                         
                        $party_item=NotifyPartyItem::where('ci_item_id', $ci_item->id)->where('notify_party_id', $request->notify_pary_id)->first(['desk_item_name']);
                        $updateData = [
                            'ccq' => 0,
                            'ci_item_id' => $ci_item->id,
                            'ci_item_name' => $ci_item->duplicate_name,
                            'sale_contract_id' => $request->sc_header_editId,
                            'rate_per_ctn' => $item['acc_rate_per_ctn'],
                            'hs_code' => $item['hs_code'],
                            'desk_item_name' => $party_item->desk_item_name,
                            'rate_per_ctn_for_party' => $item['party_rate_per_ctn'],
                            'total_amount_party' => $item['party_rate_per_ctn'] * $item['total_ctn'],
                            'rate_per_ctn_for_acc' => $item['acc_rate_per_ctn'],
                            'total_amount_acc' => $item['acc_rate_per_ctn'] * $item['total_ctn'],
                            'total_amount' => $item['acc_rate_per_ctn'] * $item['total_ctn'],
                            'ctn' => $item['total_ctn'],
                            'pcs_in_ctn' => $item['total_ctn'] * $ci_item->ci_factor,
                            'factor' => $ci_item->ci_factor,
                            'cbm_per_ctn' => ROUND($item['cbm_per_ctn'],6),
                            'total_cbm' => $item['total_cbm'],
                            'freigh_x_tcbm_by_sum_total_cbm' => 0,
                            'per_ctn_freight' => 0,
                            'ci_rate_pl_freight' => 0,
                            'net_weight_kg' => $item['total_ctn'] * $ci_item->d_net_weight,
                            'gross_weight_kg' => $item['gross_weight'],
                            'gross_weight_per_item' => ROUND($item['gross_weight'] / $ci_item->ci_factor),
                            'bapa_percent' => 0,
                            'bu_id' => $ci_item->bu_id,
                            'claim_amount' => 0,
                            'mfg' => null,
                            'exp' => null,
                            'barcode' => null,
                            'batch_no' => null,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];

                        if (!empty($item['hs_code2'])) {
                            $updateData['hs_code_2'] = $item['hs_code2'];
                        }

                        if (!empty($item['sample_qty'])) {
                            $updateData['sample_qty'] = $item['sample_qty'];
                        }

                        SaleContractDetail::where('sale_contract_id', $request->sc_header_editId)
                            ->where('ci_item_id', $ci_item->id)
                            ->update($updateData);

                    }else{
                     
                        $sale_contract_detail = new SaleContractDetail();
                        $sale_contract_detail->ccq=0;
                        $sale_contract_detail->ci_item_id=$ci_item->id;
                        $desk_item_name=NotifyPartyItem::where('ci_item_id', $ci_item->id)->where('notify_party_id', $request->notify_pary_id)->value('desk_item_name');
                        $sale_contract_detail->ci_item_name                         = $ci_item->duplicate_name; 
                        $sale_contract_detail->sale_contract_id                     = $request->sc_header_editId;
                        $sale_contract_detail->rate_per_ctn                         = $item['acc_rate_per_ctn'];
                        $sale_contract_detail->hs_code                              = $item['hs_code'];
                        $sale_contract_detail->hs_code_2                            = $item['hs_code2'];
                        $sale_contract_detail->desk_item_name                       = $item['item_name'];
                        $sale_contract_detail->rate_per_ctn_for_party               = $item['party_rate_per_ctn'];   
                        $sale_contract_detail->total_amount_party                   = $item['party_rate_per_ctn'] * $item['total_ctn'];      
                        $sale_contract_detail->rate_per_ctn_for_acc                 = $item['acc_rate_per_ctn'];
                        $sale_contract_detail->total_amount_acc                     = $item['acc_rate_per_ctn'] * $item['total_ctn'];           
                        $sale_contract_detail->total_amount                         = $item['acc_rate_per_ctn'] * $item['total_ctn'];  
                        $sale_contract_detail->ctn                                  = $item['total_ctn'];
                        $sale_contract_detail->pcs_in_ctn                           = $item['total_ctn'] * $ci_item->ci_factor;
                        $sale_contract_detail->factor                               = $ci_item->ci_factor;
                        $sale_contract_detail->cbm_per_ctn                          = ROUND($item['cbm_per_ctn'],6);
                        $sale_contract_detail->total_cbm                            = $item['total_cbm'];
                        $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm       = 0;
                        $sale_contract_detail->per_ctn_freight                      = 0;
                        $sale_contract_detail->ci_rate_pl_freight                   = 0;
                        $sale_contract_detail->net_weight_kg                        = $item['total_ctn'] * $ci_item->d_net_weight;
                        $sale_contract_detail->gross_weight_kg                      = $item['gross_weight'];
                        $sale_contract_detail->gross_weight_per_item                = ROUND($item['gross_weight']/$ci_item->ci_factor);
                        $sale_contract_detail->bapa_percent                         = $ci_item->bapa_percent;
                        $sale_contract_detail->bapa_percent                         = 0;
                        $sale_contract_detail->bu_id                                = $ci_item->bu_id;
                        $sale_contract_detail->sample_qty                           = $item['sample_qty'];
                        $sale_contract_detail->claim_amount                         = 0;
                        $sale_contract_detail->mfg=NULL;
                        $sale_contract_detail->exp=NULL;
                        $sale_contract_detail->barcode=NULL;
                        $sale_contract_detail->batch_no=NULL;
                        $sale_contract_detail ->save();
                        
                    }

                }

            }

            $apiCallingStatus = 0;
            if(($request->qtan_freight_cost > 0 && FreightLogHistory::where('sc_id', $request->sc_header_editId)->count() == 0)){
                
                $this->qtanFreightSyn($request->sc_header_editId);
                $apiCallingStatus = 1;

            }
            $this->scCurrencyHistory($sale_contract->id, 1);
            $this->manageFreight($request->sc_header_editId);
            $this->manageCCQ($request->sc_header_editId);
            $this->updateCiTotalValue($request->sc_header_editId);
            return response()->json([
                'success' => true,
                'call_status'=>$apiCallingStatus
            ]);

       }  

       if($request->action=="update"){
          
            SaleContract::where('id', $request->sc_line_editId)->update([
                'invoice_date' => $request->invoice_date ? date("Y-m-d", strtotime($request->invoice_date)) : '',
                'export_no' => $request->export_no,
                'export_date' => $request->export_date ? date("Y-m-d", strtotime($request->export_date)) : NULL,
                'terms_and_condition_desk_inv' => $request->terms_and_condition_desk_inv,
                'bl_no' => $request->bl_no,
                'bl_date' => $request->bl_date ? date("Y-m-d", strtotime($request->bl_date)) : NULL,
                'bl_date_cer' => $request->bl_date_cer ? date("Y-m-d", strtotime($request->bl_date_cer)) : NULL,
                'importer_country' => $request->importer_country,
                'angikar_given_by' => $request->angikar_given_by,
                'freight_charge_india' => $request->freight_charge_india ? $request->freight_charge_india : 0,
                'tr_report_date' => $request->tr_report_date,
                'phyto_product_name' => $request->phyto_product_name,
                'is_notify_also_notity' => $request->is_notify_also_notity,
                'vehicle' => $request->vehicle,
                'revise_product_name' => $request->revise_product_name,
                'factory_address_type' => $request->factory_address_type_id,
                'third_notify_party' => $request->third_notify_party,
                'insurance_charge' => $request->insurance_charge,
                'pallet_charge' => $request->pallet_charge,
                'foreign_port' => $request->foreign_port,
                'bd_port' => $request->bd_port,
                'tr_no_is_exist' => $request->tr_no_is_exist,
                'address_replace' => $request->address_replace,
                'transport_agency_id' => $request->transport_agency_id ?: 0,
                'bank_address_for_india' => $request->bank_address_for_india,
                'lc_term_for_india' => $request->lc_term_for_india,
                'is_total_amount_oceania' => $request->is_total_amount_oceania,
                'lot_number' => $request->lot_number,
                'custom_decleration' => $request->custom_decleration,
                'best_before_india' => $request->best_before_india ? $request->best_before_india : 0,
                'gsp_ref_number' => $request->gsp_ref_number,
                'shipping_mark_india' => $request->shipping_mark_india,
                'safta_dated' => $request->safta_dated ? date("Y-m-d", strtotime($request->safta_dated)) : NULL,
                'freight_date' => $request->freight_date ? date("Y-m-d", strtotime($request->freight_date)) : NULL,
                'mfg_date_india' => $request->mfg_date_india ? $request->mfg_date_india : 0,
                'india_mfg_setup_date' => $request->india_mfg_setup_date ?: NULL,
                'dcc_memo_no' => $request->dcc_memo_no,
                'shipping_line_id' => $request->shipping_line_id ?: 0,
                'name_of_shipping_line_id' => $request->name_of_shipping_line_id ?: 0,
                'freight_amount_fc' => $request->freight_amount_fc ? $request->freight_amount_fc : 0,
                'freight_amount_btd' => $request->freight_amount_btd ? $request->freight_amount_btd : 0,
                'custom_station_id' => $request->custom_station_id ? $request->custom_station_id : 0,
                'arv_amount' => $request->arv_amount ? $request->arv_amount : 0,
                'cnf_print_date' => $request->cnf_print_date ? date("Y-m-d", strtotime($request->cnf_print_date)) : NULL,
                'master_airway_bill_no' => $request->master_airway_bill_no,
                'master_airway_bill_date' => !empty($request->master_airway_bill_date) && strtotime($request->master_airway_bill_date) ? date("Y-m-d", strtotime($request->master_airway_bill_date)) : null,
                'arv_amount_received_date' => $request->arv_amount_received_date ? date('Y-m-d H:i:s', strtotime($request->arv_amount_received_date)) : NULL,
                'salary_adjustment' => $request->salary_adjustment ? $request->salary_adjustment : 0,
                'mv_or_voy' => $request->mv_or_voy,
                'container_number' => $request->container_number,
                'add_also_notify_party' => $request->add_also_notify_party,
                'is_fob'=> $request->is_fob,
                'is_bank'=> $request->is_bank,
                'oc_date' => $request->oc_date ? date("Y-m-d",strtotime($request->oc_date)) : NULL,
                'billed_to' => $request->is_billed_to ? $request->is_billed_to : NULL,
                'is_hscode' => $request->is_hscode ? $request->is_hscode : 0
            ]);

            if($request->is_fob==1){
               return $this->qtanFreightSyn($request->sc_header_editId);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data Updated successfully'
            ]);   

       }

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
            cnf.depot_id as depot
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

    private function isCiDetailAlreadyExist($sale_contract_id,$ci_item_id){
        $sale_contract_detail = SaleContractDetail::where('sale_contract_id',$sale_contract_id)->where('ci_item_id',$ci_item_id)->get();
        if($sale_contract_detail->first()){
          return 1;
        }else{
            return 0;
        }
    }

    public function duplicate(Request $request){
        
        $id = $request->scid;
        $sale_contract_prev = SaleContract::find($id);
        $sale_contract = new SaleContract;
        $sale_contract->sales_contract_no=$sale_contract_prev->sales_contract_no;
        $sale_contract->dated=date("Y-m-d",strtotime($sale_contract_prev->dated));
        $sale_contract->invoice_no = str_replace('/', '-', ltrim($sale_contract_prev->invoice_no)) . '-copy';
        $sale_contract->ad_code=$sale_contract_prev->ad_code;
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
        $sale_contract->currency_id  = 1;
        $sale_contract->approver_id = null;
        $sale_contract->approved_at = null;
        $sale_contract->desk_approver_id = null;
        $sale_contract->desk_approve_at = null;
        $sale_contract->created_at=date('Y-m-d H:i:s');
        $sale_contract -> save();
        $sale_contract->invoice_no = $sale_contract->invoice_no.$sale_contract->id;
        if($sale_contract_prev->importer_id==1){

            $sale_contract->importer_name='N/A';
            $sale_contract->importer_address='N/A';

        }else{
             
            $sale_contract->importer_name=$sale_contract_prev->importer_name ? $sale_contract_prev->importer_name : Importer::where('id',$sale_contract_prev->importer_id)->value('name');
            $sale_contract->importer_address=$sale_contract_prev->importer_address ? $sale_contract_prev->importer_address : Importer::where('id',$sale_contract_prev->importer_id)->value('address');
            
        }

        $sale_contract->party_name=$sale_contract_prev->party_name ? $sale_contract_prev->party_name : NotifyParty::where('id',$sale_contract_prev->notify_pary_id)->value('name');
        $sale_contract->party_address=$sale_contract_prev->party_address ? $sale_contract_prev->party_address : NotifyParty::where('id',$sale_contract_prev->notify_pary_id)->value('address');
        $sale_contract->third_notify_party=$sale_contract_prev->third_notify_party;
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
            $sale_contract_detail->desk_item_name=$sale_contract_detail_prev->desk_item_name;
            $sale_contract_detail->container_no = $sale_contract_detail_prev->container_no;
            $sale_contract_detail->batch_no = $sale_contract_detail_prev->batch_no;
            $sale_contract_detail->hs_code=$sale_contract_detail_prev->hs_code;
            $sale_contract_detail->hs_code_2=$sale_contract_detail_prev->hs_code_2;
            $sale_contract_detail->save();
        }
        
        return response()->json([
           'msg'=>'Duplicate Successfully Done.!!',
           'code'=>200 
        ]);

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

    public function show(Request $request){
  
        $dparty_id= base64_decode($request->query('partyId'));
        $id    = base64_decode($request->query('scid'));
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
        // if($sale_contract->po_number){

        //     $sale_contract->po_number;
        //     $poMaster=POMaster::where('PO_NO',$sale_contract->po_number)->first(['id','TEMPLATE_ID']);
        //     $poMasterId=$poMaster->id;
        //     $userId=Auth::user()->id;
        //     $sale_contact_id=$sale_contract->id;
        //     if($poMaster->TEMPLATE_ID==1){

        //         $userTaskLists=DB::select("CALL UPDATE_TASK_LIST_LAND($sale_contact_id,$userId)");

        //     }elseif($poMaster->TEMPLATE_ID==3) {
                
        //         $userTaskLists=DB::select("CALL UPDATE_TASK_LIST_SEA($sale_contact_id,$userId)");
        //     }

        // }

        return view("sale_contract.sale_contract_show2",compact("sale_contract"))
                 ->with('sale_contract_details',$sale_contract_details)
                 ->with('unposted_status',$unposted_status)
                 ->with('party_id', $dparty_id)
                 ->with('total_net_weight', $total_net_weight)
                 ->with('sale_contract_no', $id)
                 ->with('ciEditHistories', $ciEditHistories)
                 ->with('userTaskLists', $userTaskLists)
                 ->with('cnf',$cnf);
                 
    }

    public function approveSalesContract(Request $request)
    {
        // try {

            $scId = base64_decode($request->scid);
            $sale_contract = SaleContract::findOrFail($scId);
            if ($sale_contract->desk_approver_id != null) {
                return response()->json([
                    'code'    => 409,
                    'message' => "Already Posted"
                ]);
            }

            $sale_contract->desk_approver_id = Auth::user()->id;
            $sale_contract->desk_approve_at  = Carbon::now();
            $sale_contract->save();
            $this->sendDeskApprovalMail($scId);
            return response()->json([
                'code'    => 200,
                'message' => "Sales Contract Posted successfully!"
            ]);

        // } catch (\Exception $e) {
        //     return response()->json([
        //         'code'    => 500,
        //         'message' => "Something went wrong: " . $e->getMessage()
        //     ]);
        // }

    }


    public function sendDeskApprovalMail($sales_contract_id){
          
        $sales_contract=\DB::table('sale_contracts')->where('id', $sales_contract_id)->pluck('invoice_no');
        $party_id=SaleContract::where('id',$sales_contract_id)->value('notify_pary_id');
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
        $u="samia@prangroup.com";
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
            $message->subject($data['subject']);
        }); 
               

    }
    

    public function addQuickScEditAddItem(Request $request){
        
        $ci_item = CiItem::find($request->ci_item_id);   
        $sc_id = $request->sc_header_editId;
        $sale_contract_detail = new SaleContractDetail();
        $sale_contract_detail->ccq=0;
        $sale_contract_detail->sale_contract_id                 = $sc_id;
        $sale_contract_detail->ci_item_id                       = $request->ci_item_id;
        $sale_contract_detail->ci_item_name                     = $ci_item->duplicate_name; 
        $sale_contract_detail->rate_per_ctn                     = $ci_item->ci_item_rate;
        $sale_contract_detail->rate_per_ctn_for_party           = $request->rate_per_ctn_for_party;
        $sale_contract_detail->rate_per_ctn_for_acc             = $request->rate_per_ctn_for_acc;
        $sale_contract_detail->ctn                              = $request->ctn;
        $sale_contract_detail->pcs_in_ctn                       = $request->ctn * $ci_item->ci_factor;
        $sale_contract_detail->factor                           = $ci_item->ci_factor;
        $sale_contract_detail->is_eligible                      = $ci_item->is_ci_eligible;
        $sale_contract_detail->cbm_per_ctn                      = $request->cbm_per_ctn;
        $sale_contract_detail->total_cbm                        = $request->cbm_per_ctn * $request->ctn;
        $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm   = 0;
        $sale_contract_detail->per_ctn_freight                  = 0;
        $sale_contract_detail->ci_rate_pl_freight               = 0;
        
        
        $sale_contract_detail->total_amount                     = $ci_item->ci_item_rate*$request->ctn;
        $sale_contract_detail->total_amount_party               = $request->rate_per_ctn_for_party*$request->ctn;
        $sale_contract_detail->total_amount_acc                 = $request->rate_per_ctn_for_acc*$request->ctn;
        $sale_contract_detail->net_weight_kg                    = $request->ctn * $ci_item->d_net_weight;

        $sale_contract_detail->gross_weight_per_item            = $request->gross_weight;
        $sale_contract_detail->gross_weight_kg                  = $request->ctn * $request->gross_weight;
        
        // bapa cal
        $sale_contract_detail->bapa_percent                     = $ci_item->bapa_percent;
        $sale_contract_detail->claim_amount                     = ($ci_item->bapa_percent * $sale_contract_detail->total_amount ) / 100;
        $sale_contract_detail->bu_id                            = $ci_item->bu_id;
        $sale_contract_detail->hs_code                          = $request->hs_code;
        $sale_contract_detail->hs_code_2                        = $request->hs_code_2;
        $sale_contract_detail->container_no                     = $request->container_no;
        $sale_contract_detail->batch_no                         = $request->batch_no;
        $sale_contract_detail->desk_item_name                   = $request->desk_item_name;
        $sale_contract_detail ->save();

        $this->manageFreight($sc_id);
        $this->manageCCQ($sc_id);
        $this->updateCiTotalValue($sc_id);
        
        $results=DB::select("SELECT
            sale_contract_details.id,
            ci_item_code as item_code,
            sale_contract_details.desk_item_name as item_name,
            sale_contract_details.ctn as total_ctn,
            sale_contract_details.rate_per_ctn_for_acc as acc_rate_per_ctn,
            sale_contract_details.rate_per_ctn_for_party as party_rate_per_ctn,
            sale_contract_details.cbm_per_ctn,
            sale_contract_details.factor,
            sale_contract_details.gross_weight_per_item as gross_weight,
            sale_contract_details.hs_code,
            if(sale_contract_details.hs_code_2,sale_contract_details.hs_code_2,'') as hs_code2,
            sale_contract_details.total_amount_acc as total_acc_value,
            sale_contract_details.total_amount_party as total_party_value
        FROM `sale_contract_details`
        join ci_items on ci_items.id=sale_contract_details.ci_item_id
        WHERE `sale_contract_id`='$sc_id'
        order by sale_contract_details.id DESC"); 

        if($results){

             return response()->json([
                'code'=>200,
                'Message'=>'Item Added Successfully.!!',
                'data'=>$results
            ]);

        } else {

            return response()->json([
                'message' => "Item Added Failed.!!",
                "code"    => 500,
                "data" =>[]

            ]);

        } 

    }

    // private function manageFreight($sale_contract_id){
        
    //     $sale_contract = SaleContract::find($sale_contract_id);
    //     $freight_cost  = $sale_contract->freight_cost;
    //     $sum_total_cbm = SaleContractDetail::where('sale_contract_id',$sale_contract_id)->sum('total_cbm');
    //     foreach($sale_contract->sale_contract_details as $sale_contract_detail){

    //         $freigh_x_tcbm_by_sum_total_cbm = ($freight_cost / $sum_total_cbm ) * $sale_contract_detail->total_cbm ;
    //         $per_ctn_freight = $freigh_x_tcbm_by_sum_total_cbm / $sale_contract_detail->ctn;
    //         $ci_rate_pl_freight = $sale_contract_detail->rate_per_ctn + $per_ctn_freight;
    //         $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = $freigh_x_tcbm_by_sum_total_cbm;
    //         $sale_contract_detail->per_ctn_freight   = $per_ctn_freight;
    //         $sale_contract_detail->ci_rate_pl_freight     = round($ci_rate_pl_freight,3);
    //         $sale_contract_detail->total_amount = $sale_contract_detail->ctn * round($ci_rate_pl_freight,3);
    //         $sale_contract_detail->save();
            
    //     }

    // }

    private function manageFreight($sale_contract_id)
    {
        try {

            $sale_contract = SaleContract::find($sale_contract_id);
            if (!$sale_contract) {
                throw new \Exception("Sale contract not found.");
            }

            $freight_cost  = $sale_contract->freight_cost;
            $sum_total_cbm = SaleContractDetail::where('sale_contract_id', $sale_contract_id)->sum('total_cbm');

            // Prevent divide-by-zero
            if ($sum_total_cbm == 0) {
                throw new \Exception("Total CBM is zero, cannot calculate freight distribution.");
            }

            foreach ($sale_contract->sale_contract_details as $sale_contract_detail) {

                $freigh_x_tcbm_by_sum_total_cbm = ($freight_cost / $sum_total_cbm) * $sale_contract_detail->total_cbm;

                // Prevent second divide-by-zero
                if ($sale_contract_detail->ctn == 0) {
                    throw new \Exception("CTN value is zero for item ID: " . $sale_contract_detail->id);
                }

                $per_ctn_freight = $freigh_x_tcbm_by_sum_total_cbm / $sale_contract_detail->ctn;
                $ci_rate_pl_freight = $sale_contract_detail->rate_per_ctn + $per_ctn_freight;

                $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = $freigh_x_tcbm_by_sum_total_cbm;
                $sale_contract_detail->per_ctn_freight = $per_ctn_freight;
                $sale_contract_detail->ci_rate_pl_freight = round($ci_rate_pl_freight, 3);
                $sale_contract_detail->total_amount = $sale_contract_detail->ctn * round($ci_rate_pl_freight, 3);
                $sale_contract_detail->save();
            }

        } catch (\Exception $e) {
            // handle exception
            \Log::error("Freight calculation failed: " . $e->getMessage());

            // optional: return false or throw again
            return false;
        }

        return true;
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

    public function doc_make_price_same(Request $request){
        
        $sale_contact_id=$request->sale_contact_id;
        $sale_contract_detail = DB::select("UPDATE sale_contract_details set 
                               sale_contract_details.rate_per_ctn = sale_contract_details.rate_per_ctn_for_acc,
                               sale_contract_details.total_amount = sale_contract_details.rate_per_ctn_for_acc * sale_contract_details.ctn where sale_contract_details.sale_contract_id='$sale_contact_id'");
        $this->manageFreight($sale_contact_id);
        return response()->json([
            'code'=>200
        ]);    
        
    }

    // com  access notify Party
    public function comAccessPartyList(){
        $user_id=Auth::user()->id;
        $notify_party_ids = NotifyPartyUser::where('user_id', $user_id)->where('status', '1')->pluck('notify_party_id');
        $notify_parties = NotifyParty::whereIn('id', $notify_party_ids)->get();
        return view("sale_contract.doc_sales_contract")
                ->with('notify_parties', $notify_parties);
    }

     
    public function comInvDetails(Request $request){
  
        $id= base64_decode($request->query('scid'));
        $dparty_id= base64_decode($request->query('partyId'));
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
        return view("sale_contract.doc_sales_contract_details",compact("sale_contract"))
                 ->with('sale_contract_details',$sale_contract_details)
                 ->with('unposted_status',$unposted_status)
                 ->with('party_id', $dparty_id)
                 ->with('total_net_weight', $total_net_weight)
                 ->with('sale_contract_no', $id)
                 ->with('ciEditHistories', $ciEditHistories)
                 ->with('userTaskLists', $userTaskLists)
                 ->with('cnf',$cnf);
                 
    }

    public function partyWiseDocScList(Request $request){
        
        $results=DB::select("select
                sc.id,
                sc.notify_pary_id                 as party_id,
                sc.sales_contract_no,
                date_format(sc.dated, '%d-%m-%Y') as sales_contract_date,
                sc.invoice_no,
                c.name                            as company,
                b.short_name                      as bank,
                sc.export_no                      as export_no,
                case when (desk_approver_id is not null and approver_id is null)
                    then 'Desk Approved'
                when (desk_approver_id is not null and approver_id is not null)
                    then 'Doc Approved'
                ELSE 'Not Approved' end           as status
            from sale_contracts sc
            join companies c on c.id=sc.company_id
            join banks b on b.id=sc.bank_id
            join importers imp on imp.id=sc.importer_id
            where sc.notify_pary_id='$request->party_id' AND sc.inactive='N' AND sc.desk_approver_id is not null
            order by sc.id desc");
        return response()->json([
            'results'=>$results,
            'code'=>200
        ]);

    }

    public function docApproveSalesContract(Request $request){

        try {

            $scId = base64_decode($request->scid);
            $sale_contract = SaleContract::findOrFail($scId);
            if($sale_contract->approver_id != null) {

                return response()->json([
                    'code'    => 409,
                    'message' => "Already Posted"
                ]);

            }

            $sale_contract->approver_id = Auth::user()->id;
            $sale_contract->approved_at  = Carbon::now();
            $sale_contract->save();
            return response()->json([
                'code'    => 200,
                'message' => "Sales Contract Posted successfully!"
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'code'    => 500,
                'message' => "Something went wrong: " . $e->getMessage()
            ]);
        }

    }


    public function unpostedApproveDesk(Request $request){

        try {

            $scId = base64_decode($request->scid);
            $sale_contract = SaleContract::findOrFail($scId);
            if($sale_contract->approver_id != null) {

                return response()->json([
                    'code'    => 409,
                    'message' => "Already Posted"
                ]);

            }

            $sale_contract->desk_approver_id = NULL;
            $sale_contract->desk_approve_at  = NULL;
            $sale_contract->save();
            $this->sendUnPostedMail($scId);
            return response()->json([
                'code'    => 200,
                'message' => "Sales Contract Posted successfully!"
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'code'    => 500,
                'message' => "Something went wrong: " . $e->getMessage()
            ]);
        }

    }

    public function sendUnPostedMail($sales_contract_id){
       
        $sales_contract=\DB::table('sale_contracts')->where('id', $sales_contract_id)->pluck('invoice_no');
        $party_id=SaleContract::where('id',$sales_contract_id)->value('notify_pary_id');
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
        $p="samia@prangroup.com";
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
            $message->from($data['email'],'SC Unposted Mail');
            $message->to($data['email_array']);
            $message->subject($data['subject']);
        }); 

    }


    public function jsonGetPoItems(Request $request){
      
        $party_id=POMaster::where('id',$request->po_id)->value('PARTY_ID');
        $results = DB::select("SELECT
                poi.id as id,
                ci_items.ci_item_code as item_code,
                ci_items.ci_item_name as item_name,
                t2.acc_rate as acc_rate_per_ctn,
                t2.party_rate as party_rate_per_ctn,
                t2.cbm_per_ctn as cbm_per_ctn,
                t2.gross_weight as gross_weight,
                ci_items.hs_code as hs_code,
                IF(t2.hs_code2, t2.hs_code2, '') as hs_code2,
                ROUND(SUM(t2.cbm_per_ctn * poi.order_qty_ctn), 6) as total_cbm,
                ROUND(SUM(t2.acc_rate * poi.order_qty_ctn), 6) as total_acc_value,
                ROUND(SUM(t2.party_rate * poi.order_qty_ctn), 6) as total_party_value,
                poi.order_qty_ctn as po_qty,
                COALESCE(SUM(scd.ctn), 0) as used_qty,
                (poi.order_qty_ctn - COALESCE(SUM(scd.ctn), 0)) as total_ctn
            FROM po_master po
            JOIN po_item_details poi ON poi.master_id = po.ID
            JOIN ci_items ON ci_items.id = poi.item_id
            JOIN (
                SELECT ci_item_id, acc_rate, party_rate, cbm_per_ctn, gross_weight, hs_code2
                FROM notify_party_items
                WHERE notify_party_id = ?
            ) t2 ON t2.ci_item_id = poi.item_id
            LEFT JOIN sale_contract_details scd ON scd.po_line_id = poi.id
            LEFT JOIN sale_contracts sc ON sc.id = scd.sale_contract_id AND sc.inactive = 'N'
            WHERE po.ID = ?
            GROUP BY
                poi.id,
                ci_items.ci_item_code,
                ci_items.ci_item_name,
                t2.acc_rate,
                t2.party_rate,
                t2.cbm_per_ctn,
                t2.gross_weight,
                ci_items.hs_code,
                t2.hs_code2,
                poi.order_qty_ctn
            HAVING total_ctn > 0
            ORDER BY ci_items.ci_item_code
        ", [$party_id, $request->po_id]);

        return response()->json([
            'code'=>200,
            'data'=>$results
        ]);    

    }

    private function scCurrencyHistory($sale_contact_id,$currency_id){
       
        $sc_currency_histroy=new ScCurrencyHistory();
        $sc_currency_histroy->sale_contract_id=$sale_contact_id;
        $sc_currency_histroy->currency_id=$currency_id;
        $sc_currency_histroy->rate=CurrencySetup::where('id',$currency_id)->value('currency_rate');
        $sc_currency_histroy->save();

    }


}
