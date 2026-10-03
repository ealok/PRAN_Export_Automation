<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\POMaster;
use App\POItemDetails;
use App\CiItem;
use App\NotifyParty;
use App\Importer;
use App\NotifyPartyItem;
use App\NotifyPartyUser;
use App\SaleContract;
use App\SaleContractDetail;
use Illuminate\Support\Facades\Auth;
class POController extends Controller
{
    public function __construct()
    {
        
    }

    public function createPO(Request $request)
    {
        $ss_header = $request->header('ss');
        $yy_header = $request->header('yy');
        
        //@@@@-Header validation-@@@@----
        if ($ss_header !== 'purchase_order') {
            return response()->json([
                'status' => 'error',
                'message' => 'Header validation failed',
                'errors' => ['ss' => ['The ss header must be "purchase_order"']]
            ], 400);
        }

        if ($yy_header !== 'HJDyh876Yhdsf543GFOYSAL') {
            return response()->json([
                'status' => 'error',
                'message' => 'Header validation failed',
                'errors' => ['yy' => ['The yy header is invalid']]
            ], 400);
        }

        //@@@@-Check if request is JSON-@@@@----
        if (!$request->isJson()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Request must be JSON'
            ], 400);
        }

        //@@@@-Validation rules-@@@@----
        $validator = Validator::make(
            $request->all(),
            [
                'party' => 'required|string',
                'user' => 'required|string|max:20',
                'uniq_num' => 'required|string|max:50',
                '20ft_cnter' => 'nullable|integer|min:0',
                '40ft_cnter' => 'nullable|integer|min:0',
                '40hc_cnter' => 'nullable|integer|min:0',
                'data' => 'required|array|min:1',
                'data.*' => 'required|array',
                'data.*.item' => 'required|string|max:20',
                'data.*.ctn' => 'required|integer|min:1|max:999999',
                'data.*.sample' => 'sometimes|integer|min:0|max:10',
            ],
            [
                'party.required' => 'Party field is required',
                'party.string' => 'Party must be a valid string',

                'user.required' => 'User field is required',
                'user.string' => 'User must be a valid string',
                'user.max' => 'User cannot exceed 20 characters',

                'uniq_num.required' => 'PO number cannot be null',
                'uniq_num.string' => 'PO number must be a valid string',
                'uniq_num.max' => 'PO number cannot exceed 50 characters',

                '20ft_cnter.integer' => '20ft container must be a valid number',
                '20ft_cnter.min' => '20ft container cannot be negative',

                '40ft_cnter.integer' => '40ft container must be a valid number',
                '40ft_cnter.min' => '40ft container cannot be negative',

                '40hc_cnter.integer' => '40ft HC container must be a valid number',
                '40hc_cnter.min' => '40ft HC container cannot be negative',

                'data.required' => 'At least one item is required',
                'data.array' => 'Data must be an array',
                'data.min' => 'At least one item is required',

                'data.*.item.required' => 'Item code is required for each entry',
                'data.*.item.string' => 'Item code must be a valid string',
                'data.*.item.max' => 'Item code cannot exceed 20 characters',

                'data.*.ctn.required' => 'CTN is required for each entry',
                'data.*.ctn.integer' => 'CTN must be a valid number',
                'data.*.ctn.min' => 'CTN must be at least 1',
                'data.*.ctn.max' => 'CTN cannot exceed 999999',

                'data.*.sample.integer' => 'Sample must be a valid number',
                'data.*.sample.min' => 'Sample cannot be negative',
                'data.*.sample.max' => 'Sample cannot exceed 10',
            ]
        );

        //@@@@-Check validation fails-@@@@----
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed - PO cannot be created.',
                'errors' => $validator->errors()
            ], 422);
        }

        //@@@@-Get validated data-@@@@----
        $validated = $validator->valid();
        
        $partyCode = $validated['party'];
        $staffId = $validated['user'];
        $container_20ft = isset($validated['20ft_cnter']) ? $validated['20ft_cnter'] : 0;
        $container_40ft = isset($validated['40ft_cnter']) ? $validated['40ft_cnter'] : 0;
        $container_40hc = isset($validated['40hc_cnter']) ? $validated['40hc_cnter'] : 0;
        
        //@@@@-Check if user exists by staff_id-@@@@----
        $user = DB::table('users')
            ->where('username', $staffId)
            ->first();
            
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
                'errors' => [
                    'user' => ['Staff ID "' . $staffId . '" does not exist in the system']
                ]
            ], 422);
        }
        
        $userId = $user->id;
        
        //@@@@-Check if party exists-@@@@----
        $party = DB::table('notify_parties')
            ->where('id', $partyCode)
            ->orWhere('code', $partyCode)
            ->first();
            
        if (!$party) {
            return response()->json([
                'status' => 'error',
                'message' => 'Party not found',
                'errors' => [
                    'party' => ['Party "' . $partyCode . '" does not exist in the system']
                ]
            ], 422);
        }
        
        $partyId = $party->id;
        $partyCode = $party->code;
        $uniqNum = $validated['uniq_num'];

        //@@@@-Check unique number already exists for this user-@@@@----
        $existingPO = DB::table('po_master')
            ->where('REF_PO_NO', $uniqNum)
            ->first();

        if ($existingPO) {
            return response()->json([
                'status' => 'error',
                'message' => 'Duplicate PO not allowed',
                'errors' => [
                    'uniq_num' => ['PO number "' . $uniqNum . '" already exists for this user and party']
                ]
            ], 422);
        }    
        
        //@@@@-Check user permission for this party-@@@@----
        $userPartyPermission = DB::table('notify_party_users')
            ->where('user_id', $userId)
            ->where('notify_party_id', $partyId)
            ->first();
        
        if (!$userPartyPermission) {
            return response()->json([
                'status' => 'error',
                'message' => 'User does not have permission for this party',
                'errors' => [
                    'user' => ['User "' . $staffId . '" does not have access to party "' . $partyCode . '"']
                ]
            ], 403);
        }

        //@@@@-Set default sample = 0 if not provided-@@@@----
        $validated['data'] = collect($validated['data'])
            ->map(function ($item) {
                $item['sample'] = isset($item['sample']) ? $item['sample'] : 0;
                return $item;
            })
            ->values()
            ->toArray();

        //@@@@-Validate each item-@@@@----
        $itemErrors = [];
        $validItems = [];
        $totalItems = count($validated['data']);
        
        foreach ($validated['data'] as $index => $item) {
            $itemCode = $item['item'];
            $errorMessages = [];
            
            //@@@@-Get item data from view-@@@@----
            $itemData = DB::table('vw_item_party_validation')
                ->where('item_code', $itemCode)
                ->where('party_code', $partyCode)
                ->first();
            
            //@@@@-Check if item exists-@@@@----
            if (!$itemData) {
                $itemExists = DB::table('ci_items')->where('ci_item_code', $itemCode)->first();
                if ($itemExists) {
                    $itemErrors["item_$index"] = [
                        'item_code' => $itemCode,
                        'status' => ($itemExists->status == 1) ? 'Y' : 'N',
                        'item_assign' => 'N',
                        'errors' => ['Item "' . $itemCode . '" is not assigned to this party']
                    ];
                } else {
                    $itemErrors["item_$index"] = [
                        'item_code' => $itemCode,
                        'status' => 'N',
                        'item_assign' => 'N',
                        'errors' => ['Item code "' . $itemCode . '" does not exist in the system']
                    ];
                }
                continue;
            }

            //@@@@-Check item active status-@@@@----
            if ($itemData->is_active == 0) {
                $errorMessages[] = 'Item "' . $itemCode . '" is currently inactive';
            }

            //@@@@-Check item assignment to party-@@@@----
            if ($itemData->item_assign == 0) {
                $errorMessages[] = 'Item "' . $itemCode . '" is not assigned to this party';
            }

            //@@@@-If errors found, add to itemErrors-@@@@----
            if (!empty($errorMessages)) {
                $itemErrors["item_$index"] = [
                    'item_code' => $itemCode,
                    'status' => ($itemData->is_active == 1) ? 'Y' : 'N',
                    'item_assign' => ($itemData->item_assign == 1) ? 'Y' : 'N',
                    'errors' => $errorMessages
                ];
                continue;
            }

            //@@@@-Add valid item to list-@@@@----
            $validItems[] = [
                'item' => $item,
                'item_data' => $itemData
            ];
        }

        //@@@@-Check if any item errors exist-@@@@----
        if (!empty($itemErrors)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item validation failed. PO cannot be created.',
                'total_item' => $totalItems,
                'errors' => $itemErrors
            ], 422);
        }

        //@@@@-Check if any valid items exist-@@@@----
        if (empty($validItems)) {
            return response()->json([
                'status' => 'error',
                'message' => 'No valid items found. PO cannot be created.',
                'total_item' => $totalItems,
                'errors' => [
                    'data' => ['At least one valid item is required']
                ]
            ], 422);
        }

        //@@@@-Start transaction-@@@@----
        DB::beginTransaction();
        
        try {
            //@@@@-Create PO Master-@@@@----
            $poMaster = new POMaster();
            $poMaster->PARTY_ID = $partyId;
            $poMaster->REF_PO_NO = $validated['uniq_num'];
            $poMaster->CREATE_DATE = date('Y-m-d');
            $poMaster->REMARK = 'Manually Created';
            $poMaster->PO_DATE = date('Y-m-d');
            $poMaster->ORDER_QTY = array_sum(array_column($validated['data'], 'ctn'));
            $poMaster->TEMPLATE_ID = 0;
            $poMaster->ORDER_STATUS = 'Y';
            $poMaster->ORDER_TYPE = 'regular';
            $poMaster->IUID = $userId;
            $poMaster->EUID = $userId;
            $poMaster->save();
            
            //@@@@-Generate PO Number-@@@@----
            $poNumber = $this->createPONumber($partyCode);
            $poMaster->PO_NO = $poNumber;
            $poMaster->save();
            
            //@@@@-Create PO Item Details-@@@@----
            foreach ($validItems as $itemData) {
                $item = $itemData['item'];
                $data = $itemData['item_data'];
                
                $itemDetails = new POItemDetails();
                $itemDetails->master_id = $poMaster->id;
                $itemDetails->item_id = $data->item_id;
                $itemDetails->item_name = $data->item_name;
                $itemDetails->factor = $data->factor;
                $itemDetails->rate_per_ctn = 0;
                $itemDetails->order_qty_ctn = $item['ctn'];
                $itemDetails->cbm = 0;
                $itemDetails->specifition = null;
                $itemDetails->ref_code = null;
                $itemDetails->coding_matter = null;
                $itemDetails->special_requirement = null;
                $itemDetails->save();
            }
            
            //@@@@-Create Sales Contract-@@@@----
            $invoice_no = $this->createSalesContract($partyId, $userId, $validItems, $poNumber, $poMaster->id, $container_20ft, $container_40ft, $container_40hc);
            
            //@@@@-Commit transaction-@@@@----
            DB::commit();
            
            //@@@@-Return success response-@@@@----
            return response()->json([
                'status' => 'success',
                'message' => 'PO created successfully',
                'data' => [
                    'po_number' => $poNumber,
                    'invoice_no' => $invoice_no,
                    'ref_po_no' => $validated['uniq_num'],
                    'party' => $partyCode,
                    'user' => $staffId,
                    'total_items' => count($validated['data']),
                    'total_order_qty' => $poMaster->ORDER_QTY
                ]
            ], 201);

        } catch (\Exception $e) {
            //@@@@-Rollback transaction on error-@@@@----
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create PO: ' . $e->getMessage()
            ], 500);
        }
    } 

    public function createSalesContract($partyId, $user_id, $validItems, $poNumber, $po_id, $container_20ft = 0, $container_40ft = 0, $container_40hc = 0)
    {
        try {
            //@@@@-Get last contract for this party-@@@@----
            $sale_contract_prev = null;
            $sale_contract = SaleContract::where('notify_pary_id', $partyId)
                ->where('inactive', 'N')
                ->orderBy('id', 'DESC')
                ->first();
                
            if ($sale_contract) {
                $sale_contract_prev = $sale_contract;
            } else {
                //@@@@-Get user's assigned party-@@@@----
                $user_first_assign_party = NotifyPartyUser::where('user_id', $user_id)->first();
                
                if ($user_first_assign_party) {
                    $sale_contract_prev = SaleContract::where('notify_pary_id', $user_first_assign_party->notify_party_id)
                        ->where('inactive', 'N')
                        ->orderBy('id', 'DESC')
                        ->first();
                } else {
                    //@@@@-Fallback to party_id 1-@@@@----
                    $sale_contract_prev = SaleContract::where('id', 1)->first();
                }
            }
            
            //@@@@-Generate invoice number-@@@@----
            $invoice_no = $this->generateInvoiceNumber($partyId);
            //@@@@-Create new sales contract-@@@@----
            $sale_contract = new SaleContract();
            $sale_contract->sales_contract_no = $invoice_no;
            $sale_contract->dated = date("Y-m-d");
            $sale_contract->invoice_no = $invoice_no;
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
            $sale_contract->notify_pary_id = $partyId;
            $sale_contract->carrying_mode_id = $sale_contract_prev->carrying_mode_id;
            $sale_contract->loading_place_id = $sale_contract_prev->loading_place_id;
            $sale_contract->final_destination = $sale_contract_prev->final_destination;
            $sale_contract->creator_id = $user_id;
            $sale_contract->terms_and_condition = $sale_contract_prev->terms_and_condition;
            $sale_contract->terms_and_condition_desk_inv = $sale_contract_prev->terms_and_condition_desk_inv;
            $sale_contract->freight_cost = 0;
            $sale_contract->container_1 = $container_20ft;
            $sale_contract->container_2 = $container_40ft;
            $sale_contract->container_3 = $container_40hc;
            $sale_contract->freight_cost_1 = 0;
            $sale_contract->freight_cost_2 = 0;
            $sale_contract->freight_cost_3 = 0;
            $sale_contract->container = ($container_20ft + $container_40ft + $container_40hc);
            $sale_contract->importer_country = $sale_contract_prev->importer_country;
            $sale_contract->angikar_given_by = $sale_contract_prev->angikar_given_by;
            $sale_contract->approver_id = null;
            $sale_contract->approved_at = null;
            $sale_contract->desk_approver_id = null;
            $sale_contract->po_number = $poNumber;
            $sale_contract->po_master_id = $po_id;
            $sale_contract->inactive = 'N';
            $sale_contract->save();
            
            //@@@@-Set importer name and address-@@@@----
            if ($sale_contract_prev->importer_id == 1) {
                $sale_contract->importer_name = 'N/A';
                $sale_contract->importer_address = 'N/A';
            } else {
                $sale_contract->importer_name = $sale_contract_prev->importer_name 
                    ? $sale_contract_prev->importer_name 
                    : Importer::where('id', $sale_contract_prev->importer_id)->value('name');
                $sale_contract->importer_address = $sale_contract_prev->importer_address 
                    ? $sale_contract_prev->importer_address 
                    : Importer::where('id', $sale_contract_prev->importer_id)->value('address');
            }
            
            $sale_contract->party_name = $sale_contract_prev->party_name 
                ? $sale_contract_prev->party_name 
                : NotifyParty::where('id', $sale_contract_prev->notify_pary_id)->value('name');
            $sale_contract->party_address = $sale_contract_prev->party_address 
                ? $sale_contract_prev->party_address 
                : NotifyParty::where('id', $sale_contract_prev->notify_pary_id)->value('address');
            $sale_contract->third_notify_party = $sale_contract_prev->third_notify_party;
            $sale_contract->created_at = date('Y-m-d H:i:s');
            $sale_contract->save();
            
            //@@@@-Create Sales Contract Details-@@@@----
            foreach ($validItems as $index => $itemData) {
                $item = $itemData['item'];
                $ci_item = CiItem::where('ci_item_code', $item['item'])->where('status', 1)->first();
                
                if (!$ci_item) {
                    continue;
                }
                
                //@@@@-Get data from notify_party_items-@@@@----
                $cbm_per_carton = NotifyPartyItem::where('ci_item_id', $ci_item->id)
                    ->where('notify_party_id', $partyId)
                    ->pluck('cbm_per_ctn')->toArray();
                $acc_rate = NotifyPartyItem::where('ci_item_id', $ci_item->id)
                    ->where('notify_party_id', $partyId)
                    ->pluck('acc_rate')->toArray();
                $desk_item_name = NotifyPartyItem::where('ci_item_id', $ci_item->id)
                    ->where('notify_party_id', $partyId)
                    ->pluck('desk_item_name')->toArray();
                $party_rate = NotifyPartyItem::where('ci_item_id', $ci_item->id)
                    ->where('notify_party_id', $partyId)
                    ->pluck('party_rate')->toArray();
                $gross_weight = NotifyPartyItem::where('ci_item_id', $ci_item->id)
                    ->where('notify_party_id', $partyId)
                    ->pluck('gross_weight')->toArray();
                $hs_code2 = NotifyPartyItem::where('ci_item_id', $ci_item->id)
                    ->where('notify_party_id', $partyId)
                    ->pluck('hs_code2')->toArray();
                
                //@@@@-Create sales contract detail-@@@@----
                $sale_contract_detail = new SaleContractDetail();
                $sale_contract_detail->ccq = 0;
                $sale_contract_detail->ci_item_id = $ci_item->id;
                $sale_contract_detail->ci_item_name = $ci_item->duplicate_name;
                $sale_contract_detail->sale_contract_id = $sale_contract->id;
                $sale_contract_detail->rate_per_ctn = $ci_item->ci_item_rate;
                $sale_contract_detail->hs_code = $ci_item->hs_code;
                
                //@@@@-Set desk item name-@@@@----
                if (!empty($desk_item_name[0])) {
                    $sale_contract_detail->desk_item_name = $desk_item_name[0];
                }
                
                //@@@@-Set party rate-@@@@----
                if (!empty($party_rate[0])) {
                    $sale_contract_detail->rate_per_ctn_for_party = $party_rate[0];
                    $sale_contract_detail->total_amount_party = $party_rate[0] * $item['ctn'];
                }
                
                //@@@@-Set account rate-@@@@----
                if (!empty($acc_rate[0])) {
                    $sale_contract_detail->rate_per_ctn_for_acc = $acc_rate[0];
                    $sale_contract_detail->total_amount_acc = $acc_rate[0] * $item['ctn'];
                }
                
                //@@@@-Set basic item details-@@@@----
                $sale_contract_detail->total_amount = $ci_item->ci_item_rate * $item['ctn'];
                $sale_contract_detail->ctn = $item['ctn'];
                $sale_contract_detail->pcs_in_ctn = $item['ctn'] * $ci_item->ci_factor;
                $sale_contract_detail->factor = $ci_item->ci_factor;
                
                //@@@@-Set CBM-@@@@----
                if (!empty($cbm_per_carton[0])) {
                    $sale_contract_detail->cbm_per_ctn = $cbm_per_carton[0];
                    $sale_contract_detail->total_cbm = $cbm_per_carton[0] * $item['ctn'];
                }
                
                //@@@@-Set freight and weight-@@@@----
                $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = 0;
                $sale_contract_detail->per_ctn_freight = 0;
                $sale_contract_detail->ci_rate_pl_freight = 0;
                $sale_contract_detail->net_weight_kg = $item['ctn'] * $ci_item->d_net_weight;
                $sale_contract_detail->hs_code_2 = !empty($hs_code2[0]) ? $hs_code2[0] : NULL;
                
                //@@@@-Set gross weight-@@@@----
                if (!empty($gross_weight[0])) {
                    $sale_contract_detail->gross_weight_kg = $item['ctn'] * $gross_weight[0];
                }
                
                //@@@@-Set bapa percent and BU-@@@@----
                $sale_contract_detail->bapa_percent = ($ci_item->bapa_percent * $sale_contract_detail->total_amount_party) / 100;
                $sale_contract_detail->bu_id = $ci_item->bu_id;
                $sale_contract_detail->sample_qty = $item['sample'] ? $item['sample'] : 0;
                $sale_contract_detail->mfg = NULL;
                $sale_contract_detail->exp = NULL;
                $sale_contract_detail->barcode = NULL;
                $sale_contract_detail->batch_no = NULL;
                $sale_contract_detail->save();
            }
            
            //@@@@-Manage Freight-@@@@----
            $this->manageFreight($sale_contract->id);
            
            //@@@@-Manage CCQ-@@@@----
            $this->manageCCQ($sale_contract->id);
            
            return $invoice_no;
            
        } catch (\Exception $e) {
            throw new \Exception('Error creating sales contract: ' . $e->getMessage());
        }
    }

    private function generateInvoiceNumber($partyId)
    {
        $party = NotifyParty::where('id', $partyId)->first();
        $sale_contract = SaleContract::where('notify_pary_id', $partyId)
            ->where('inactive', 'N')
            ->orderBy('id', 'DESC')
            ->first();
        
        if($sale_contract && $sale_contract->invoice_no) {
            return $this->incrementInvoiceNumber($sale_contract->invoice_no);
        }
        
        $refName = $party ? $party->ref_name : 'UNKNOWN';
        return 'PRAN-' . $refName . '-01-' . date('Y');

    }

    private function incrementInvoiceNumber($invoiceNo)
    {
        $invoiceNo = preg_replace('/-copy\d+$/', '', $invoiceNo);
        $parts = explode('-', $invoiceNo);
        $year = array_pop($parts);
        $numberPart = array_pop($parts);
        if (preg_match('/(\d+)$/', $numberPart, $matches)) {
            $newNumber = $matches[1] + 1;
            $numberPart = preg_replace('/\d+$/', $newNumber, $numberPart);
            $parts[] = $numberPart;
            $parts[] = $year;
            return implode('-', $parts);
        }
        
        return $invoiceNo . '-01-' . date('Y');
    }

    private function createPONumber($partyCode)
    {
        $year = date('Y');
        $month = date('m');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return "PO-{$partyCode}-{$year}{$month}-{$random}";
    }

    private function manageFreight($sale_contract_id)
    {
        $sale_contract = SaleContract::find($sale_contract_id);
        if(!$sale_contract) {
            return;
        }

        $freight_cost = (float) $sale_contract->freight_cost;
        $sum_total_cbm = SaleContractDetail::where('sale_contract_id',$sale_contract_id)->sum('total_cbm');
        $sum_total_cbm = (float) $sum_total_cbm;
        if($sum_total_cbm <= 0) {

            foreach ($sale_contract->sale_contract_details as $sale_contract_detail) {
                $ci_rate_pl_freight = (float) $sale_contract_detail->rate_per_ctn;
                $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = 0;
                $sale_contract_detail->per_ctn_freight = 0;
                $sale_contract_detail->ci_rate_pl_freight = round($ci_rate_pl_freight, 3);
                $sale_contract_detail->total_amount =
                    $sale_contract_detail->ctn * round($ci_rate_pl_freight, 3);

                $sale_contract_detail->save();
            }
            return;
        }

        foreach ($sale_contract->sale_contract_details as $sale_contract_detail) {

            $ctn = (float) $sale_contract_detail->ctn;
            $total_cbm = (float) $sale_contract_detail->total_cbm;
            $rate_per_ctn = (float) $sale_contract_detail->rate_per_ctn;
            if($ctn <= 0) {

                $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = 0;
                $sale_contract_detail->per_ctn_freight = 0;
                $sale_contract_detail->ci_rate_pl_freight = round($rate_per_ctn, 3);
                $sale_contract_detail->total_amount = 0;
                $sale_contract_detail->save();
                continue;
            }

            $freightByCBM = ($freight_cost / $sum_total_cbm) * $total_cbm;
            $perCtnFreight = $freightByCBM / $ctn;
            $ciRatePlFreight = $rate_per_ctn + $perCtnFreight;
            $roundedRate = round($ciRatePlFreight, 3);
            $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = $freightByCBM;
            $sale_contract_detail->per_ctn_freight = $perCtnFreight;
            $sale_contract_detail->ci_rate_pl_freight = $roundedRate;
            $sale_contract_detail->total_amount = $ctn * $roundedRate;
            $sale_contract_detail->save();

        }
    }


    private function manageCCQ($sale_contract_id)
    {

        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$sale_contract_id) ->orderBy('id')->get();
        if ($sale_contract_details->isEmpty()) {
            return;
        }

        $sum_ccq = 0;
        foreach ($sale_contract_details as $sale_contract_detail) {

            $ctn = $sale_contract_detail->ctn ? (float) $sale_contract_detail->ctn : 0;
            $sum_ccq += $ctn;
            $sale_contract_detail->ccq = $sum_ccq;
            $sale_contract_detail->save();
        }

    }

}