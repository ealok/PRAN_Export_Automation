<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\CiItem;
use App\NotifyParty;
use App\NotifyPartyItem;
use App\Requisition;
use App\RequisitionItem;
use App\Area;
use App\Bu;
use App\Dunit;
use App\Runit;
use App\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Log;
class ItemRequisitionController extends Controller
{
     
   public function __construct()
   {
        
   }
   public function createItemRequisition(Request $request){ 
         
        $ss_header = $request->header('ss');      //@@@@----Validate headers----
        $yy_header = $request->header('yy');
        if(!$ss_header) {
            return response()->json([
                'status' => 'error',
                'message' => 'Header validation failed',
                'errors' => [
                    'ss' => ['The ss header is required']
                ]
            ], 400);
        }
        
        if($ss_header !== 'requisition') {
            return response()->json([
                'status' => 'error',
                'message' => 'Header validation failed',
                'errors' => [
                    'ss' => ['The ss header must be "requisition"']
                ]
            ], 400);
        }

        if(!$yy_header) {
            return response()->json([
                'status' => 'error',
                'message' => 'Header validation failed',
                'errors' => [
                    'yy' => ['The yy header is required']
                ]
            ], 400);
        }
        
        if($yy_header !== 'HJDyh876Yhdsf543GRAKIB') {
            return response()->json([
                'status' => 'error',
                'message' => 'Header validation failed',
                'errors' => [
                    'yy' => ['The yy header is invalid']
                ]
            ], 400);
        }

        if(!$request->isJson()) {         //@@@@----Validate that request body is JSON and not empty---
            return response()->json([
                'status' => 'error',
                'message' => 'Request must be JSON'
            ], 400);
        }

        $items = $request->all();
        if (!is_array($items) || empty($items)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Request body must be a non-empty array'
            ], 400);
        }

        $errors = [];
        $customMessages = [
            // General messages
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute must be a string.',
            'numeric' => 'The :attribute must be a number.',
            'max' => 'The :attribute may not be greater than :max characters.',
            'min' => 'The :attribute must be at least :min.',
            
            // ITEM_ID specific messages
            'ITEM_ID.required' => 'Item ID (ITEM_ID) is required for processing.',
            'ITEM_ID.string' => 'Item ID must be a valid string.',
            'ITEM_ID.max' => 'Item ID cannot exceed 50 characters.',
            
            // ITEM_NAME specific messages
            'ITEM_NAME.required' => 'Item name (ITEM_NAME) is required.',
            'ITEM_NAME.string' => 'Item name must be a valid string.',
            'ITEM_NAME.max' => 'Item name is too long. Maximum 255 characters allowed.',
            
            // D_U_FACT specific messages
            'D_U_FACT.required' => 'Default Unit Factor (D_U_FACT) is required.',
            'D_U_FACT.numeric' => 'Default Unit Factor must be a valid number.',
            'D_U_FACT.min' => 'Default Unit Factor cannot be negative.',
            
            // COMPANY_ID specific messages
            'COMPANY_ID.required' => 'Company ID (COMPANY_ID) is required.',
            'COMPANY_ID.string' => 'Company ID must be a valid string.',
            'COMPANY_ID.max' => 'Company ID cannot exceed 50 characters.',
            
            // BU specific messages
            'BU.required' => 'Business Unit (BU) is required.',
            'BU.string' => 'Business Unit must be a valid string.',
            'BU.max' => 'Business Unit cannot exceed 50 characters.',
            
            // CAT_NAME specific messages
            'CAT_NAME.required' => 'Category Name (CAT_NAME) is required.',
            'CAT_NAME.string' => 'Category Name must be a valid string.',
            'CAT_NAME.max' => 'Category Name cannot exceed 100 characters.',
            
            // CLASS_NAME specific messages
            'CLASS_NAME.required' => 'Class Name (CLASS_NAME) is required.',
            'CLASS_NAME.string' => 'Class Name must be a valid string.',
            'CLASS_NAME.max' => 'Class Name cannot exceed 100 characters.',

            // FOB specific messages
            'FOB.required' => 'FOB (Free on Board) value is required.',
            'FOB.numeric' => 'FOB must be a valid number (e.g., 10 or 10.50).',
            'FOB.min' => 'FOB must be greater than 0.',

            // CBM_PER_CTN specific messages
            'CBM_PER_CTN.required' => 'CBM per carton is required.',
            'CBM_PER_CTN.numeric' => 'CBM per carton must be a valid number (e.g., 0.5 or 1.75).',
            'CBM_PER_CTN.min' => 'CBM per carton must be greater than 0.',

            // PCS_NET_WEIGHT specific messages
            'PCS_NET_WEIGHT.required' => 'Pieces Net Weight is required.',
            'PCS_NET_WEIGHT.numeric' => 'Pieces Net Weight must be a valid number.',
            'PCS_NET_WEIGHT.min' => 'Pieces Net Weight must be greater than 0.',

            // CTN_NET_WEIGHT specific messages
            'CTN_NET_WEIGHT.required' => 'Carton Net Weight is required.',
            'CTN_NET_WEIGHT.numeric' => 'Carton Net Weight must be a valid number.',
            'CTN_NET_WEIGHT.min' => 'Carton Net Weight must be greater than 0.',

            // GROSS_WEIGHT specific messages
            'GROSS_WEIGHT.required' => 'Gross weight is required.',
            'GROSS_WEIGHT.numeric' => 'Gross weight must be a valid number (e.g., 5.5 or 10.25).',
            'GROSS_WEIGHT.min' => 'Gross weight must be greater than 0.',

            // REGION specific messages
            'REGION.required' => 'Region is required.',
            'REGION.string' => 'Region must be a valid string.',
            'REGION.max' => 'Region cannot exceed 50 characters.',

            // DUNIT_CODE specific messages
            'DUNIT_CODE.required' => 'Dunit code is required.',
            'DUNIT_CODE.string' => 'Dunit code must be a valid string.',
            'DUNIT_CODE.max' => 'Dunit code cannot exceed 50 characters.',
            
            // DUNIT_NAME specific messages
            'DUNIT_NAME.required' => 'Dunit name is required.',
            'DUNIT_NAME.string' => 'Dunit name must be a valid string.',
            'DUNIT_NAME.max' => 'Dunit name cannot exceed 100 characters.',

            // RUNIT_CODE specific messages
            'RUNIT_CODE.required' => 'Runit code is required.',
            'RUNIT_CODE.string' => 'Runit code must be a valid string.',
            'RUNIT_CODE.max' => 'Runit code cannot exceed 50 characters.',

            // RUNIT_NAME specific messages
            'RUNIT_NAME.required' => 'Runit name is required.',
            'RUNIT_NAME.string' => 'Runit name must be a valid string.',
            'RUNIT_NAME.max' => 'Runit name cannot exceed 100 characters.',

            // HS_CODE specific messages
            'HS_CODE.required' => 'HS Code is required.',
            'HS_CODE.string' => 'HS Code must be a valid string.',
            'HS_CODE.max' => 'HS Code cannot exceed 50 characters.'

        ];

        // Validate each item in the array
        foreach ($items as $index => $item) {

            if(!is_array($item)) {
                $errors["item_$index"] = [
                    'index' => $index,
                    'errors' => ['Item must be an object']
                ];
                continue;
            }

            $validator = Validator::make($item, [
                'ITEM_ID' => 'required|string|max:50',
                'ITEM_NAME' => 'required|string|max:255',
                'D_U_FACT' => 'required|numeric|min:0.01',
                'COMPANY_ID' => 'required|string|max:50',
                'BU' => 'required|string|max:50',
                'CAT_NAME' => 'required|string|max:100',
                'CLASS_NAME' => 'required|string|max:100',
                'FOB' => 'required|numeric|min:0.00',
                'CBM_PER_CTN' => 'required|numeric|min:0.00',
                'PCS_NET_WEIGHT' => 'required|numeric|min:0.01',
                'CTN_NET_WEIGHT' => 'required|numeric|min:0.01',
                'GROSS_WEIGHT' => 'required|numeric|min:0.00',
                'REGION' => 'required|string|max:50',
                'DUNIT_CODE' => 'required|string|max:50',
                'DUNIT_NAME' => 'required|string|max:100',
                'RUNIT_CODE' => 'required|string|max:50',
                'RUNIT_NAME' => 'required|string|max:100',
                'HS_CODE' => 'required|string|max:50'
            ], $customMessages);
            
            if ($validator->fails()) {
                $itemId = isset($item['ITEM_ID']) ? $item['ITEM_ID'] : 'unknown';
                $errors["item_$index"] = [
                    'item_id' => $itemId,
                    'index' => $index,
                    'errors' => $validator->errors()->all()
                ];
            }
        }

        if(!empty($errors)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed for one or more items',
                'errors' => $errors
            ], 422);
        }
        
        try {

            $receiver_email = array('export214@prangroup.com','export155@prangroup.com','export490@prangroup.com','export211@prangroup.com','export212@prangroup.com','export214@prangroup.com');
            $processedItems = [];
            $errors = [];
            foreach($items as $item) {
                
                $req_number = $item['REQUISITION_ID'];
                $itemId = $item['ITEM_ID'];
                $itemName = $item['ITEM_NAME'];
                $dUFact = $item['D_U_FACT'];
                $companyId = $item['COMPANY_ID'];
                $bu = $item['BU'];
                $catName = $item['CAT_NAME'];
                $className = $item['CLASS_NAME'];
                $fob = $item['FOB'];
                $cbm_per_ctn = $item['CBM_PER_CTN'];
                $pcs_net_weight = $item['PCS_NET_WEIGHT'];
                $ctn_net_weight = $item['CTN_NET_WEIGHT'];
                $gross_weight = $item['GROSS_WEIGHT'];
                $region = $item['REGION'];
                $dunit_code = $item['DUNIT_CODE'];
                $dunit_name = $item['DUNIT_NAME'];
                $runit_code = $item['RUNIT_CODE'];
                $runit_name = $item['RUNIT_NAME'];
                $hs_code = $item['HS_CODE'];
                $mail_list = isset($item['MAIL_LIST']) ? array_unique(array_merge($item['MAIL_LIST'], $receiver_email)) : $receiver_email;
                if(Requisition::where('requisition_number', $req_number)->count()>0){

                    // Check if item already exists
                    $existingItem = CiItem::where('ci_item_code', $itemId)->first();
                    if($existingItem) {
                        return response()->json([
                            'code' => 409,
                            'status' => 'error',
                            'message' => 'Item already exists in the table',
                            'data' => [
                                'item_id' => $itemId,
                                'item_name' => $itemName
                            ]
                        ], 409);
                    }

                    // Check/Create BU
                    $buDetails = Bu::where('code', $companyId)->first(['id', 'name', 'code']);
                    if(is_null($buDetails)) {
                        try {
                            $newBu = new Bu();
                            $newBu->name = $bu;
                            $newBu->code = $companyId;
                            $newBu->buh_name = $bu;
                            $newBu->location_id = 0;
                            $newBu->save();
                            $buDetails = $newBu;
                        } catch (\Exception $e) {
                            return response()->json([
                                'code' => 500,
                                'status' => 'error',
                                'message' => 'BU creation failed. Item cannot be created without BU.',
                                'error_details' => [
                                    'item_id' => $itemId,
                                    'item_name' => $itemName,
                                    'bu_name' => $bu,
                                    'reason' => $e->getMessage()
                                ]
                            ], 500);
                        }
                    }

                    // Check/Create Dunit
                    if(empty($dunit_code) || empty($dunit_name)) {
                        
                        $dunit_code = 'DU001';
                        $dunit_name = 'Carton';
                    }

                    $dunit = Dunit::where('dunit_code', $dunit_code)->first();
                    if(is_null($dunit)) {
                        try {
                            $newDunit = new Dunit();
                            $newDunit->dunit_code = $dunit_code;
                            $newDunit->dunit_name = $dunit_name;
                            $newDunit->save();
                            $dunit = $newDunit;
                        } catch (\Exception $e) {
                            return response()->json([
                                'code' => 500,
                                'status' => 'error',
                                'message' => 'Dunit Create failed.',
                                'error_details' => [
                                    'item_id' => $itemId,
                                    'item_name' => $itemName,
                                    'reason' => $e->getMessage()
                                ]
                            ], 500);
                        }
                    }

                    // Check/Create Runit
                    if(empty($runit_code) || empty($runit_name)) {
                        // Set default Runit values
                        $runit_code = 'RU001';
                        $runit_name = 'Piece';
                    }

                    $runit = Runit::where('runit_code', $runit_code)->first();
                    if(is_null($runit)) {
                        try {
                            $newRunit = new Runit();
                            $newRunit->runit_code = $runit_code;
                            $newRunit->runit_name = $runit_name;
                            $newRunit->save();
                            $runit = $newRunit;
                        } catch (\Exception $e) {
                            return response()->json([
                                'code' => 500,
                                'status' => 'error',
                                'message' => 'Runit Create failed.',
                                'error_details' => [
                                    'item_id' => $itemId,
                                    'item_name' => $itemName,
                                    'reason' => $e->getMessage()
                                ]
                            ], 500);
                        }
                    }

                    // Create new item
                    $newItem = new CiItem();
                    $newItem->ci_item_code = $itemId;
                    $newItem->ci_item_name = strtoupper($itemName);
                    $newItem->duplicate_name = strtoupper($itemName);
                    $newItem->p_net_weight = $pcs_net_weight;
                    $newItem->factor = $dUFact;
                    $newItem->ci_factor = $dUFact;
                    $newItem->d_net_weight = $ctn_net_weight;
                    $newItem->d_gross_weight = $gross_weight;
                    $newItem->ci_item_rate = $fob;
                    $newItem->hs_code = $hs_code;
                    $newItem->class_name = $className;
                    $newItem->bu_id = $buDetails->id;
                    $newItem->bu = $buDetails->name;
                    $newItem->company_id = $buDetails->code;
                    $newItem->item_type_id = 2;
                    $newItem->is_api = 1;                 
                    $newItem->save();

                    DB::table('requisitions')->where('requisition_number', $req_number)->update(['status' => 'completed']);
                    DB::table('requisition_items')->where('requisition_number',$req_number)->update([
                        'item_code'=> $itemId,
                        'hs_code'=> $hs_code,
                        'cat_name'=> $catName,
                        'class_name'=> $className,
                        'ctn_net_weight'=> $ctn_net_weight,
                        'pcs_net_weight'=> $pcs_net_weight,
                        'region_code_api'=> $region,
                        'dunit_code'=> $dunit_code,
                        'dunit_name'=> $dunit_name,
                        'runit_code'=> $runit_code,
                        'runit_name'=> $runit_name,
                    ]);    

                    $this->requisitionNotificationMail($req_number, $mail_list);
                    if($newItem->id) {
                        
                        // $this->assignItemToNotifyParty(
                        //     $newItem->id, 
                        //     $itemName, 
                        //     $dUFact, 
                        //     $fob, 
                        //     $cbm_per_ctn, 
                        //     $gross_weight, 
                        //     $region, 
                        //     $dunit_code, 
                        //     $dunit_name, 
                        //     $runit_code, 
                        //     $runit_name
                        // );
                        
                        return response()->json([
                            'code' => 200,
                            'status' => 'success',
                            'message' => 'Item created successfully',
                            'data' => [
                                'item_id' => $itemId,
                                'item_name' => $itemName,
                                'record_id' => $newItem->id
                            ]
                        ], 200);  

                    } else {
                        return response()->json([
                            'code' => 500,
                            'status' => 'error',
                            'message' => 'Failed to create item',
                            'data' => [
                                'item_id' => $itemId,
                                'item_name' => $itemName
                            ]
                        ], 500);
                    }

                }else{
                   
                    return response()->json([
                        'code' => 500,
                        'status' => 'error',
                        'message' => 'Requisition Number Not Match.!!',
                        'data' => [
                            'item_id' => $itemId,
                            'item_name' => $itemName
                        ]
                    ], 500);
                    
                }
                
            }

        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Failed to create item: ' . $e->getMessage(),
                'data' => [
                    'item_id' => isset($itemId) ? $itemId : 'unknown',
                    'item_name' => isset($itemName) ? $itemName : 'unknown'
                ]
            ], 500);
        }
    }

    // public function assignItemToNotifyParty($item_id,$itemName,$dUFact,$fob,$cbm_per_ctn,$gross_weight,$region,$dunit_code,$dunit_name,$runit_code,$runit_name){

    //     $area_ids = Area::where('code', $region)->pluck('id')->toArray();
    //     $notifyParty = NotifyParty::whereIn('area_id', $area_ids)->get();
    //     foreach($notifyParty as $party){

    //         $exists = NotifyPartyItem::where('notify_party_id', $party->id)
    //                 ->where('ci_item_id', $item_id)
    //                 ->exists();

    //         if(!$exists){

    //             $notify_party_item = new NotifyPartyItem();
    //             $notify_party_item->notify_party_id=$party->id;
    //             $notify_party_item->ci_item_id=$item_id;
    //             $notify_party_item->desk_item_name=$itemName;
    //             $notify_party_item->acc_rate=$fob;
    //             $notify_party_item->acc_rate2=$fob;
    //             $notify_party_item->party_rate=0;
    //             $notify_party_item->cbm_per_ctn=$cbm_per_ctn;
    //             $notify_party_item->gross_weight=0;
    //             $notify_party_item->shelf_life=0;
    //             $notify_party_item->dunit=Dunit::where('dunit_code',$dunit_code)->value('id');
    //             $notify_party_item->runit=Runit::where('runit_code',$runit_code)->value('id');
    //             $notify_party_item->factory_id=0;
    //             $notify_party_item->is_assign=0;
    //             $notify_party_item->save();

    //         }      

    //     }

    // }

    private function requisitionNotificationMail($req_number, $mail_list)
    {    
        $items = DB::select("SELECT
            `requisition_number`,
            `item_code`,
            `item_name`,
            `factor`,
            `region_name`,
            `bu_name`,
            `pcs_net_weight` AS net_weight,
            `ctn_net_weight` AS ctn_net_weight,
            `dunit_name`,
            `runit_name`,
            `prime_cost`
        FROM
            `requisition_items`
        WHERE
            `requisition_number` = ?", [$req_number]);

        // Current date
        $currentDate = date('Y-m-d H:i:s');
        $formattedDate = date('d F, Y', strtotime($currentDate)); // 02 March, 2026
        $requisition = Requisition::where('requisition_number', $req_number)->first();
        $created_by = $requisition->created_by;
        $creator_mail = User::where('id', $created_by)->value('email');
        $subject = "Requisition Completed Notification - " . $req_number . " - " . $formattedDate;
        $data = array(
            'items' => $items,
            'subject' => $subject,
            'requisition_number' => $req_number,
            'item_count' => count($items),
            'creator_mail' => $creator_mail,
            'current_date' => $currentDate,
            'formatted_date' => $formattedDate,
            'year' => date('Y'),
            'month' => date('F'),
            'day' => date('d')
        );

        $from_mail = env('MAIL_FROM_ADDRESS');
        Mail::send('mail.requisition_done_mail_template', $data, function($message) use ($from_mail, $data, $mail_list) {
            $message->from($from_mail, 'Export-Item-Requisitions@prangroup.com');
            $message->to($data['creator_mail']);
            $message->cc($mail_list);
            $message->subject($data['subject']);
        });


    }

    public function updateItemOpeningStatus(Request $request)
    {
        try {

            $status = $request->status;
            $code = $request->code;
            $data = $request->data;
            if ($status !== "success" || $code != 200) {
                return response()->json([
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Invalid status or code'
                ], 400);
            }

            if (empty($data)) {
                return response()->json([
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No data provided'
                ], 400);
            }
            
            foreach($data as $item) {

                $requisitionId = $item['REQUISITION_ID'];
                $note = $item['NOTE'];
                $requisition = Requisition::where('requisition_number', $requisitionId)->first();
                if($requisition) {
                    Requisition::where('requisition_number', $requisitionId)->update([
                        'api_note' => $note 
                    ]); 
                } else {
                    return response()->json([
                        'status' => 'failed',
                        'code' => 400,
                        'message' => 'Requisition Number Not Match.!'
                    ], 400);
                }
            }

            return response()->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'Updated successfully'
            ], 200);
            
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);

        }

    }
        
}