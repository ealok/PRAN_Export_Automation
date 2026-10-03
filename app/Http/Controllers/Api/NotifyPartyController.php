<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class NotifyPartyController extends Controller
{
    
    public function __construct()
    {
        
    }

    public function updatePartyListList(Request $request){ 
         
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
        $results = DB::select("SELECT
            code AS Code,
            name AS Name,
            ref_name as Ref_Name,
            address AS Address,
            country AS Country,
            region AS Region,
            zone AS Zone,
            status AS Status
        FROM notify_parties
        ORDER BY id ASC");
    return response()->json($results);
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
