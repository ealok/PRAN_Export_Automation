<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Requisition;
use App\RequisitionItem;
use App\RequisitionSeq;
use App\Area;
use App\Bu;
use Auth;
use DB;

class RequistionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $requisitionSeq = RequisitionSeq::orderBy('id','desc')->first();
        $lastRequisitionId=$requisitionSeq->next_value;
        $lastRequisitionId = $lastRequisitionId ? $lastRequisitionId : 0;
        return view("requistion.index", compact('lastRequisitionId'));
    }

    public function getList(Request $request)
    {
        try {
            $user = auth()->user(); // Get logged-in user
            $userId = $user->id;
            $page = (int) $request->get('page', 1);
            $perPage = (int) $request->get('per_page', 10);
            $search = $request->get('search', '');
            $offset = ($page - 1) * $perPage;
            $searchTerm = '%' . $search . '%';
            
            // COUNT QUERY - Only user filter, no status filter
            $countSql = "
                SELECT COUNT(*) as total
                FROM requisitions r
                LEFT JOIN requisition_items ri ON r.id = ri.requisition_id AND ri.id = (
                    SELECT MIN(id) FROM requisition_items WHERE requisition_id = r.id
                )
                LEFT JOIN users u ON r.created_by = u.id
                WHERE r.created_by = ?
            ";
            
            $countParams = [$userId];
            
            if (!empty($search)) {
                $countSql .= " AND (
                    r.requisition_number LIKE ? 
                    OR ri.item_name LIKE ? 
                    OR ri.hs_code LIKE ? 
                    OR u.name LIKE ?
                )";
                $countParams = array_merge($countParams, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
            }
            
            $totalResult = DB::select($countSql, $countParams);
            $total = isset($totalResult[0]->total) ? $totalResult[0]->total : 0;
            
            // DATA QUERY - Only user filter, no status filter
            $dataSql = "
                SELECT 
                    r.id,
                    r.requisition_number,
                    DATE_FORMAT(r.requisition_date, '%d-%m-%y') as date,
                    r.total_items,
                    r.status,
                    r.api_note as note,
                    COALESCE(u.name, 'System') as requested_by,
                    ri.item_code as code,
                    ri.item_name as name,
                    ri.hs_code as hsCode,
                    ri.region_name as region,
                    ri.pcs_net_weight as net_weight,
                    ri.factor,
                    ri.bu_name as bu,
                    (SELECT COUNT(*) FROM requisition_items WHERE requisition_id = r.id) as actual_item_count
                FROM requisitions r
                LEFT JOIN requisition_items ri ON r.id = ri.requisition_id AND ri.id = (
                    SELECT MIN(id) FROM requisition_items WHERE requisition_id = r.id
                )
                LEFT JOIN users u ON r.created_by = u.id
                WHERE r.created_by = ?
            ";
            
            $dataParams = [$userId];
            
            if (!empty($search)) {
                $dataSql .= " AND (
                    r.requisition_number LIKE ? 
                    OR ri.item_name LIKE ? 
                    OR ri.hs_code LIKE ? 
                    OR u.name LIKE ?
                )";
                $dataParams = array_merge($dataParams, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
            }
            $dataSql .= " ORDER BY r.created_at DESC LIMIT ? OFFSET ?";
            $dataParams[] = $perPage;
            $dataParams[] = $offset;
            $requisitions = DB::select($dataSql, $dataParams);
            $formattedData = [];
            foreach($requisitions as $item) {
                $formattedData[] = [
                    'id' => $item->id,
                    'code' => isset($item->code) ? $item->code : 'N/A',
                    'name' => isset($item->name) ? $item->name : 'N/A',
                    'factor' => $item->factor ? $item->factor : '0',
                    'netWeight' => $item->net_weight ? $item->net_weight : '0',
                    'hsCode' => isset($item->hsCode) ? $item->hsCode : '-',
                    'date' => $item->date,
                    'bu' => $item->bu,
                    'region' => $item->region,
                    'status' => $item->status,
                    'requisition_number' => $item->requisition_number,
                    'total_items' => $item->total_items,
                    'actual_item_count' => $item->actual_item_count,
                    'note' => isset($item->note) ? $item->note : '-'
                ];
            }
            
            return response()->json([
                'success' => true,
                'data' => $formattedData,
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'total' => $total,
                    'last_page' => $total > 0 ? ceil($total / $perPage) : 0
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load requisitions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function jsonGetRegionPartyList(){
         
        $regions = Area::whereNotIn('id', [3, 7, 17, 18, 20])->get();
        return response()->json([
            'success' => true,
            'data' => $regions
        ]);

    }

    public function getBusList(){
         
        $bus = Bu::whereNotIn('id', [24, 32, 33])->get();
        return response()->json([
            'success' => true,
            'data' => $bus
        ]);


    }

    public function getNewRequisitionNumber(Request $request)
    {
        
        $sequence = DB::table('requisition_sequence')->orderBy('id', 'desc')->first();
        $lastValue = $sequence ? $sequence->next_value + 1 : 0;
        $newValue = $lastValue + 1;
        $requisitionNumber = $this->formatRequisitionNumber($newValue);
        DB::table('requisition_sequence')->insert([
            'sequence_name' => $requisitionNumber,
            'next_value' => $newValue,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
        
        return response()->json([
            'success' => true,
            'requisition_number' => $requisitionNumber,
            'next_value' => $newValue
        ]);

    }

    /**
     * Delete requisition sequence from database
     */
    public function deleteRequisitionSequence(Request $request)
    {
        try {
            $requisitionNumber = $request->requisition_number;
            $sequenceId = $request->sequence_id;
            
            // Delete from requisition_sequence table
            $deleted = DB::table('requisition_sequence')
                ->where('sequence_name', $requisitionNumber)
                ->orWhere('id', $sequenceId)
                ->delete();
            
            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Requisition sequence deleted successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Requisition sequence not found'
                ], 404);
            }
            
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete: ' . $e->getMessage()
            ], 500);
        }
    }

    private function formatRequisitionNumber($sequenceId)
    {
        $date = date('Y-m-d');
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $paddedId = str_pad($sequenceId, 6, '0', STR_PAD_LEFT);
        return "REQ/{$year}/{$month}/{$paddedId}";

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Group items by requisition number
            $groupedItems = [];
            foreach($request->items as $itemData) {

                $reqNumber = $itemData['requisitionNumber'];
                if(!isset($groupedItems[$reqNumber])) {
                    $groupedItems[$reqNumber] = [];
                }
                $groupedItems[$reqNumber][] = $itemData;

            }
            
            $savedRequisitions = [];
            foreach($groupedItems as $reqNumber => $items) {

                $totalItems = count($items);
                $requisition = Requisition::where('requisition_number', $reqNumber)->first();
                if(!$requisition) {
                    $requisition = new Requisition();
                    $requisition->requisition_number = $reqNumber;
                    $requisition->requisition_date = date('Y-m-d');
                    $requisition->total_items = $totalItems;
                    $requisition->status = 'pending';
                    $requisition->api_note = 'PDD Pending';
                    $requisition->created_by = Auth::id();
                    $requisition->created_at = date('Y-m-d H:i:s');
                    $requisition->updated_at = date('Y-m-d H:i:s');
                    $requisition->save();
                } else {
                    $requisition->total_items = $requisition->total_items + $totalItems;
                    $requisition->updated_at = date('Y-m-d H:i:s');
                    $requisition->save();
                }
                
                foreach($items as $itemData) {

                    $requisitionItem = new RequisitionItem();
                    $requisitionItem->requisition_id = $requisition->id;
                    $requisitionItem->requisition_number = $reqNumber;
                    $requisitionItem->item_name = $itemData['name'];
                    $requisitionItem->factor = (int) $itemData['factor'];
                    $requisitionItem->bu = $itemData['bu'];
                    $requisitionItem->bu_name = Bu::where('code', $itemData['bu'])->value('name');
                    $requisitionItem->pcs_net_weight = $itemData['netWeight'];
                    $requisitionItem->ctn_net_weight = round(($itemData['netWeight'] * $itemData['factor']) / 1000, 3);
                    $requisitionItem->region_code = $itemData['region'];
                    $requisitionItem->region_name = Area::where('code', $itemData['region'])->value('name');
                    $requisitionItem->note = isset($itemData['specifications']) ? $itemData['specifications'] : null;
                    $requisitionItem->image_path = null;
                    $requisitionItem->created_at = date('Y-m-d H:i:s');
                    $requisitionItem->updated_at = date('Y-m-d H:i:s');
                    $requisitionItem->save();

                }

                $this->createNewRequisition($reqNumber, $items);
                $savedRequisitions[] = [
                    'id' => $requisition->id,
                    'requisition_number' => $requisition->requisition_number,
                    'total_items' => $requisition->total_items
                ];

            }
            
            // Send notification (once with all requisitions)
            $this->requisitionNotificationMail($request->items);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => count($savedRequisitions) . ' requisition(s) saved successfully',
                'requisitions' => $savedRequisitions,
                'last_id' => !empty($savedRequisitions) ? end($savedRequisitions)['id'] : null
            ], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to save requisition: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function createNewRequisition($requisitionNumber, $items)
    {
        if (empty($items)) {
            return false;
        }

        $formattedItems = [];
        foreach($items as $item) {

            $formattedItems[] = [
                "RequestId"      => $requisitionNumber,
                "ItemName"       => $item['name'],
                "Specifications" => $item['specifications'],
                "CompanyId"      => $item['bu'],
                "CountryId"      => $item['region'],
                "HSCode"         => "",
                "RUnit"          => "",
                "DUnit"          => "",
                "Factor"         => $item['factor'],
                "TruckFactor"    => 0,
                "FOB"            => 0,
                "PrimeCost"      => "",
                "Attribute1"     => $item['netWeight'],
                "Attribute2"     => round(((float)$item['netWeight'] * (float)$item['factor']) / 1000, 3),
                "Attribute3"     => "",
                "Attribute4"     => "",
                "Attribute5"     => "",
                "Attribute6"     => "",
                "Attribute7"     => "",
                "Attribute8"     => "",
                "Attribute9"     => "",
                "Attribute10"    => "",
            ];
        }

        $postData = [
            "StaffId" => Auth::user()->username,
            "Status"  => "NEW",
            "data"    => $formattedItems
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://runner.prangroup.com:4001/expapi/api/ItemsRequest',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_SSL_VERIFYPEER => false,   
            CURLOPT_SSL_VERIFYHOST => false, 
            CURLOPT_HTTPHEADER => [
                'ss: Alok',
                'yy: HJDyh876Yhdsf543GDJksn',
                'Content-Type: application/json'
            ],
        ]);
        
        $response = curl_exec($curl);
        if(curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return $error;
        }
        curl_close($curl);
        $responseData = json_decode($response, true);
        if(isset($responseData['SuccessCode']) && $responseData['SuccessCode'] == "2000" && !empty($responseData['data'])) 
        {
            foreach ($responseData['data'] as $resItem) {

                    Requisition::where('requisition_number', $requisitionNumber)
                    ->update([
                        'app_old' => $resItem['APPL_OID'],
                        'app_status'   => 'sent',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
            }
        }
        return $response;
    }

    private function requisitionNotificationMail($item_list)
    {

        $receiver_email = array('export214@prangroup.com','export155@prangroup.com','export490@prangroup.com','export211@prangroup.com','export212@prangroup.com','export214@prangroup.com');
        $requisitionNumber = 'N/A';
        $requisitionNumbers = [];
        $itemCount = 0;
        $firstItemName = '';
        if(!empty($item_list)) {
            foreach($item_list as $item) {
                if(isset($item['requisitionNumber'])) {
                    $requisitionNumbers[] = $item['requisitionNumber'];
                }
            }
        }

        $uniqueRequisitionNumbers = array_unique($requisitionNumbers);
        $requisitionNumbersString = "'" . implode("','", $uniqueRequisitionNumbers) . "'";
        $items=DB::select("SELECT 
                `requisition_number`,
                `item_name`,
                `factor`,
                `region_name`,
                `bu_name`,
                `pcs_net_weight` as net_weight
            FROM `requisition_items`
            WHERE `requisition_number` IN ($requisitionNumbersString)");
                    
        $subject = "New Requisition Created";
        $userName = 'System';
        $userEmail = 'N/A';
        if (Auth::check()) {
            $user = Auth::user();
            if (isset($user->name)) {
                $userName = $user->name;
            }
            if (isset($user->email)) {
                $userEmail = $user->email;
            }
        }
        
        $data = array(
            'items' => $items,
            'subject' => $subject,
            'receiver_email' => $receiver_email,
            'created_by' => $userName,
            'created_by_email' => $userEmail,
            'requisition_number' => $requisitionNumber,
            'item_count' => $itemCount,
            'first_item_name' => $firstItemName
        );
        
        $from_mail = env('MAIL_FROM_ADDRESS');
        Mail::send('mail.requisition_mail_template', $data, function($message) use ($from_mail, $data) {
            $message->from($from_mail, 'Export-Item-Requisitions@prangroup.com');
            $message->to($data['receiver_email']);
            $message->cc('mis94@mis.prangroup.com');
            $message->subject($data['subject']);
        });
        
    }

    public function search(Request $request)
    {
        try {
            
            $searchTerm = $request->get('search', '');
            $searchParam = "%{$searchTerm}%";
            $items = DB::select("
                SELECT
                    ci_items.id AS id,
                    ci_items.ci_item_name AS name,
                    '' AS factory,
                    ci_items.ci_item_code AS code,
                    ci_items.class_name AS category,
                    ci_items.hs_code AS hsCode,
                    '' AS image,
                    ci_items.factor AS factor,
                    0 AS stock,
                    0 AS fob,
                    ci_items.d_net_weight AS net_weight,
                    bus.name AS bu,
                    CASE WHEN ci_items.status = 1 THEN 'Active' ELSE 'Inactive' END AS status,
                    CASE WHEN ci_items.is_ci_eligible = 1 THEN 'Yes' ELSE 'No' END AS ci_eligible,
                    CASE 
                        WHEN ci_items.item_type_id = 2 THEN 'Export'
                        WHEN ci_items.item_type_id = 3 THEN 'Global Trading'
                        WHEN ci_items.item_type_id = 1 THEN 'Local'
                        ELSE 'N/A'
                    END AS item_type
                FROM ci_items
                JOIN bus ON bus.id = ci_items.bu_id
                WHERE ci_items.ci_item_name LIKE ?
                OR ci_items.ci_item_code LIKE ?
                OR ci_items.hs_code LIKE ?
                LIMIT 8
            ", [$searchParam, $searchParam, $searchParam]);
            
            return response()->json([
                'success' => true,
                'data' => $items,
                'count' => count($items)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Search failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getReqDetails(Request $request){
     
        $req=$request->req_number;
        try {
            $items = DB::select("
               select
                    r.requisition_number,
                    ri.item_name,
                    ri.note as specifications,
                    ri.factor,
                    ri.region_name as region,
                    r.status,
                    r.api_note as remark
                    from requisitions r
                join requisition_items ri on r.id = ri.requisition_id
                WHERE r.requisition_number = ?
            ", [$req]);
            
            if (empty($items)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requisition not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'items' => $items,
                'total_items' => count($items)
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }

    }

    public function updateManualRequistion(Request $request){
       
        if (empty($request->requistion_no)) {
            return false;
        }

        $items=DB::select("select
                r.requisition_number,
                ri.item_name,
                ri.note as specifications,
                ri.factor,
                ri.bu,
                ri.region_code,
                ri.pcs_net_weight,
                ri.ctn_net_weight,
                r.status,
                r.api_note as remark
            from requisitions r
            join requisition_items ri on r.id = ri.requisition_id
            where r.requisition_number='$request->requistion_no'");

        $formattedItems = [];
        foreach($items as $item) {

            $formattedItems[] = [
                "RequestId"      => $item->requisition_number,
                "ItemName"       => $item->item_name,
                "Specifications" => $item->specifications,
                "CompanyId"      => $item->bu,
                "CountryId"      => $item->region_code,
                "HSCode"         => "",
                "RUnit"          => "",
                "DUnit"          => "",
                "Factor"         => $item->factor,
                "TruckFactor"    => 0,
                "FOB"            => 0,
                "PrimeCost"      => "",
                "Attribute1"     => $item->pcs_net_weight,
                "Attribute2"     => $item->ctn_net_weight,
                "Attribute3"     => "",
                "Attribute4"     => "",
                "Attribute5"     => "",
                "Attribute6"     => "",
                "Attribute7"     => "",
                "Attribute8"     => "",
                "Attribute9"     => "",
                "Attribute10"    => "",
            ];
        }

        $postData = [
            "StaffId" => Auth::user()->username,
            "Status"  => "NEW",
            "data"    => $formattedItems
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://runner.prangroup.com:4001/expapi/api/ItemsRequest',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_SSL_VERIFYPEER => false,   
            CURLOPT_SSL_VERIFYHOST => false, 
            CURLOPT_HTTPHEADER => [
                'ss: Alok',
                'yy: HJDyh876Yhdsf543GDJksn',
                'Content-Type: application/json'
            ],
        ]);
        
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return $error;
        }
        curl_close($curl);
        $responseData = json_decode($response, true);
        if(isset($responseData['SuccessCode']) && $responseData['SuccessCode'] == "2000" && !empty($responseData['data'])) 
        {
            foreach ($responseData['data'] as $resItem) {

                    Requisition::where('requisition_number', $request->requistion_no)
                    ->update([
                        'app_old' => $resItem['APPL_OID'],
                        'app_status'   => 'sent',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
            }
        }
        return $response;   

    }

    public function getItemsForItemOpening(Request $request)
    {
        try {
            $search = $request->input('q', '');
            
            $query = DB::table('requisition_items as ri')
                ->leftJoin('job_order_details as jod', 'jod.item_id', '=', 'ri.item_id')
                ->leftJoin('job_order_masters as jm', 'jod.master_id', '=', 'jm.id');

            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('ri.item_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('ri.item_code', 'LIKE', '%' . $search . '%');
                });
            }
            
            $items = $query->select(
                'ri.id as requisition_id',
                'ri.item_code',
                'ri.item_name',
                'ri.region_name',
                DB::raw('
                    CASE 
                        WHEN ri.admin_date IS NOT NULL THEN "Completed"
                        WHEN ri.op_date IS NOT NULL THEN "OP Approved"
                        WHEN ri.pd_date IS NOT NULL THEN "PD Approved"
                        ELSE "Requisition Created"
                    END as status
                '),
                'ri.requisition_number',
                'ri.created_at as requisition_date',
                'ri.pd_date',
                'ri.pd_name',
                'ri.op_date',
                'ri.op_name',
                'ri.admin_date',
                'ri.admin_name'
            )
            ->groupBy(
                'ri.id',
                'ri.item_code',
                'ri.item_name',
                'ri.region_name',
                'ri.requisition_number',
                'ri.created_at',
                'ri.pd_date',
                'ri.pd_name',
                'ri.op_date',
                'ri.op_name',
                'ri.admin_date',
                'ri.admin_name'
            )
            ->limit(20)
            ->get();

            $formattedItems = array();
            foreach ($items as $item) {
                // Using ternary operator instead of ??
                $itemCode = !is_null($item->item_code) ? $item->item_code : '';
                $itemName = !is_null($item->item_name) ? $item->item_name : 'Unknown Item';
                $regionName = !is_null($item->region_name) ? $item->region_name : 'Unknown';
                $status = !is_null($item->status) ? $item->status : 'Requisition Created';
                $requisitionDate = !is_null($item->requisition_date) ? $item->requisition_date : '';
                
                $formattedItems[] = array(
                    'id' => $item->requisition_id,
                    'code' => $itemCode,
                    'name' => $itemName,
                    'text' => $itemName . ' (' . (!empty($itemCode) ? $itemCode : 'No Code') . ')',
                    'region' => $regionName,
                    'status' => $status,
                    'requisition_number' => $item->requisition_number,
                    'requisition_date' => $requisitionDate,
                    'pd_date' => $item->pd_date,
                    'pd_name' => $item->pd_name,
                    'op_date' => $item->op_date,
                    'op_name' => $item->op_name,
                    'admin_date' => $item->admin_date,
                    'admin_name' => $item->admin_name
                );
            }

            return response()->json(array(
                'status' => 'success',
                'items' => $formattedItems,
                'total' => count($formattedItems)
            ));

        } catch (\Exception $e) {
            return response()->json(array(
                'status' => 'error',
                'message' => $e->getMessage()
            ), 500);
        }
    }

    public function getItemOpeningDetails(Request $request)
    {
        try {
            $itemId = $request->input('id');
            
            if (!$itemId) {
                return response()->json(array(
                    'status' => 'error',
                    'message' => 'Item ID is required'
                ), 400);
            }

            $item = DB::table('requisition_items as ri')
                ->leftJoin('job_order_details as jod', 'jod.item_id', '=', 'ri.item_id')
                ->leftJoin('job_order_masters as jm', 'jod.master_id', '=', 'jm.id')
                ->where('ri.id', $itemId)
                ->select(
                    'ri.id as requisition_id',
                    'ri.item_code',
                    'ri.item_name',
                    'ri.region_name',
                    DB::raw('
                        CASE 
                            WHEN ri.admin_date IS NOT NULL THEN "Completed"
                            WHEN ri.op_date IS NOT NULL THEN "OP Approved"
                            WHEN ri.pd_date IS NOT NULL THEN "PD Approved"
                            ELSE "Requisition Created"
                        END as status
                    '),
                    'ri.requisition_number',
                    'ri.created_at as requisition_date',
                    'ri.pd_date',
                    'ri.pd_name',
                    'ri.op_date',
                    'ri.op_name',
                    'ri.admin_date',
                    'ri.admin_name'
                )
                ->first();

            if (!$item) {
                return response()->json(array(
                    'status' => 'error',
                    'message' => 'Item not found'
                ), 404);
            }

            // Using ternary operator instead of ??
            $itemCode = !is_null($item->item_code) ? $item->item_code : '';
            $itemName = !is_null($item->item_name) ? $item->item_name : 'Unknown Item';
            $regionName = !is_null($item->region_name) ? $item->region_name : 'Unknown';
            $status = !is_null($item->status) ? $item->status : 'Requisition Created';
            $requisitionDate = !is_null($item->requisition_date) ? $item->requisition_date : '';

            $itemData = array(
                'id' => $item->requisition_id,
                'code' => $itemCode,
                'name' => $itemName,
                'region' => $regionName,
                'status' => $status,
                'requisition_number' => $item->requisition_number,
                'requisition_date' => $requisitionDate,
                'pd' => array(
                    'status' => !is_null($item->pd_date) ? 'Completed' : 'Pending',
                    'date' => !is_null($item->pd_date) ? date('d-m-Y H:i:s', strtotime($item->pd_date)) : '',
                    'user' => !is_null($item->pd_name) ? $item->pd_name : ''
                ),
                'op' => array(
                    'status' => !is_null($item->op_date) ? 'Completed' : 'Pending',
                    'date' => !is_null($item->op_date) ? date('d-m-Y H:i:s', strtotime($item->op_date)) : '',
                    'user' => !is_null($item->op_name) ? $item->op_name : ''
                ),
                'admin' => array(
                    'status' => !is_null($item->admin_date) ? 'Completed' : 'Pending',
                    'date' => !is_null($item->admin_date) ? date('d-m-Y H:i:s', strtotime($item->admin_date)) : '',
                    'user' => !is_null($item->admin_name) ? $item->admin_name : ''
                )
            );

            return response()->json(array(
                'status' => 'success',
                'item' => $itemData
            ));

        } catch (\Exception $e) {
            return response()->json(array(
                'status' => 'error',
                'message' => $e->getMessage()
            ), 500);
        }
    }

}