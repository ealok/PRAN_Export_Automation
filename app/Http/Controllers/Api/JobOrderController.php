<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
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
class JobOrderController extends Controller
{
     
   public function __construct()
   {
        
   }

    public function updateJobOrderList(Request $request){ 
         
        $ss_header = $request->header('ss');
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
        
        if(!$yy_header) {
            return response()->json([
                'status' => 'error',
                'message' => 'Header validation failed',
                'errors' => [
                    'yy' => ['The yy header is required']
                ]
            ], 400);
        }
        
        if($yy_header !== 'HJDyh876Yhdsf543GFOYSAL') {
            return response()->json([
                'status' => 'error',
                'message' => 'Header validation failed',
                'errors' => [
                    'yy' => ['The yy header is invalid']
                ]
            ], 400);
        }

        if(!$request->isMethod('post')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Method not allowed',
                'errors' => ['method' => ['Only POST methods are allowed']]
            ], 405);
        }
        
        // $ip = $request->ip();
        // $cache_key = 'api_rate_limit_' . $ip;
        // if(Cache::has($cache_key)) {
        //     echo $hit_count = Cache::get($cache_key);
        //     if($hit_count >= 10) {
        //         return response()->json([
        //             'status' => 'error',
        //             'message' => 'Rate limit exceeded',
        //             'errors' => ['rate_limit' => ['Too many requests. Please wait a minute.']]
        //         ], 429);
        //     }
        //     Cache::increment($cache_key);
        // } else {
        //     Cache::put($cache_key, 1, 60); // 1 minute
        // }
        
        $start_time = microtime(true);
        $results=DB::select("SELECT DISTINCT
                contract.sales_contract_no AS Contract_No,
                DATE_FORMAT(contract.dated, '%d-%m-%Y') AS Contract_Date,
                contract.invoice_no AS Invoice_No,
                DATE_FORMAT(if(contract.invoice_date='' ,contract.dated,contract.invoice_date),'%d-%m-%Y') AS Invoice_Date,
                n.code AS Party_Code,
                n.name AS Party_Name,
                ci.ci_item_code AS Item_Code,
                COALESCE(sod.ci_item_name, 'Not in SC') AS Item_Name,
                ci.ci_factor as ci_factor,
                ROUND(COALESCE(sod.pcs_in_ctn, 0) / ci.factor, 0) AS SC_Qty,
                master2.job_order_number AS JO_Number,
                ROUND(jod.orqt / ci.factor, 0) AS JO_Qty,
                jod.rate AS Rate,
                jod.item_status as Status,
                DATE_FORMAT(master2.created_at, '%d-%m-%Y') AS JO_Date,
                u.name AS JO_Creator,
                uc.name AS SC_Creator,
                c.sb_no as Bill_Of_Entry_No
            FROM job_order_masters master2
            INNER JOIN job_order_details jod ON master2.id = jod.master_id AND jod.item_status = 'Y'
            INNER JOIN sale_contracts contract ON master2.sale_contract_id = contract.id AND contract.inactive = 'N' AND master2.status != 3
            INNER JOIN cnf c on contract.id = c.sale_contract_id
            INNER JOIN notify_parties n ON contract.notify_pary_id = n.id
            INNER JOIN users uc ON uc.id = contract.creator_id
            INNER JOIN ci_items ci ON ci.id = jod.item_id
            LEFT JOIN sale_contract_details sod ON contract.id = sod.sale_contract_id AND jod.item_id = sod.ci_item_id
            LEFT JOIN users u ON u.id = master2.user_id
            WHERE 1=1
                AND master2.status != 3
                AND DATE(contract.dated) >= CURDATE() - INTERVAL 90 DAY
            ORDER BY contract.dated DESC, contract.sales_contract_no, master2.job_order_number");
        $execution_time = microtime(true) - $start_time; 
        return response()->json([
            'status' => 'success',
            'message' => 'Data Found',
            'data' => $results,
            'total' => count($results),
            'execution_time' => number_format($execution_time, 2) . 's'
        ], 200); 


        return response()->json([
            'status' => 'success',
            'message' => 'Data Found',
            'data' => $results,
            'total' => count($results),
            'execution_time' => number_format($execution_time, 2) . 's'
        ], 200);

        
    }
        
}