<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class ItemController extends Controller
{
    
    public function __construct()
    {
            
    }
    
    public function updateItemsList(Request $request){ 
         
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
        
        $start_time = microtime(true);
        $results=\DB::select("SELECT
            ci_items.ci_item_code AS Item_Code,
            ci_items.ci_item_name AS Item_Name,
            ci_items.p_net_weight AS Pcs_Net_Weight,
            ci_items.d_net_weight AS Ctn_Net_Weight,
            ci_items.factor AS Unit_Per_Ctn,
            ci_items.d_gross_weight AS Ctn_Gross_Weight,
            ci_items.hs_code AS Hs_Code,
            bus.code AS BU_Code,
            bus.name AS BU_Name,
            CASE WHEN item_type_id = 1 THEN 'Local' WHEN item_type_id = 2 THEN 'Export' WHEN item_type_id = 3 THEN 'Global Trading'
            END AS category,
            CASE WHEN status = 1 THEN 'Y' ELSE 'N' END AS status
            FROM ci_items
            LEFT JOIN bus ON bus.id = ci_items.bu_id
            WHERE ci_items.created_at >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
            ORDER BY ci_items.id DESC");   
      
        if($results){
            
            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);
        
        }else{
        
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"    =>[]
            ]);
        
        }

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
