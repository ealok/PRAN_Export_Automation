<?php

namespace App\Http\Controllers;
use App\SaleContract;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Desk;
use App\Area;
use App\NotifyParty;
use App\NotifyPartyItem;
use App\SaleContractDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\NotifyPartyUser;
class ReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function ci_report_index(){

        return view('reports.ci_report_index');

    }

    public function mcb_report_view(Request $request){

        $dateFrom = date("Y-m-d",strtotime($request->dateFrom));
        $dateTo = date("Y-m-d",strtotime($request->dateTo));
        $scis = SaleContract::whereDate('sale_contracts.dated','>=',$dateFrom)
                    ->whereDate('sale_contracts.dated','<=',$dateTo)
                    ->where('sale_contracts.approver_id','!=',null)
                    ->where('sale_contracts.desk_approve_at','!=',null)
                    ->get();
        return view('reports.mcb_report_view')->with('scis',$scis)
                   ->with('dateFrom',$request->dateFrom)
                   ->with('dateTo',$request->dateTo);
    }


    public function orderTruckingReport(Request $request){

        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'
                    and notify_parties.status=1");
        

        return view('reports.order_trucking.order_trucking_report')
               ->with('notifyParties',$notifyParties);
                 
    } 

    public function getOrderWisePO(Request $request){

        $dateFrom = date("Y-m-d",strtotime($request->from_date));
        $dateTo = date("Y-m-d",strtotime($request->to_date));  
        $results=DB::select("select ID, PO_NO
            from po_master
            where date(po_master.CREATE_DATE)>='$dateFrom' and date(po_master.CREATE_DATE)<='$dateTo'
            and PARTY_ID='$request->party_id'");

        return response()->json([

            'results'=>$results

        ],200);


    }

    public function getTruckingReportDetails(Request $request){
        
        $dateFrom = date("Y-m-d",strtotime($request->from_date));
        $dateTo = date("Y-m-d",strtotime($request->to_date)); 
        
        $dataArray=array(); 
        $empty_array=array();
        $party_id=$request->party_id;  

        $po_id="";
        if($request->po_no){

            $po_id=$request->po_no;
        }

        // $results = DB::select("CALL PROC_ORDER_REPORT_SC_LIST(?, ?, ?, ?)", [$dateFrom, $dateTo, $party_id, $po_id]);
        $results = DB::select("select
                sale_contracts.id as sc_id,
                notify_parties.code as code,
                notify_parties.name as party_name,
                po_master.PO_NO as po_no,
                po_master.PO_DATE as po_date,
                sale_contracts.sales_contract_no as SC_NO,
                sale_contracts.created_at as SC_Date,
                u1.id as User_Id,
                desk.name as desk
            from po_master
            join sale_contracts on sale_contracts.po_master_id=po_master.ID
            join notify_parties on notify_parties.id=sale_contracts.notify_pary_id
            join users u1 on u1.id=sale_contracts.creator_id
            join desk_setup on desk_setup.DESK_HEAD_ID=u1.head_id
            join desk on desk.id=desk_setup.DESK_ID
            where po_master.REMARK='Manually Created' and sale_contracts.id=2480");


        foreach($results as $key=>$value){
                
                $item_array=array(); 
                $dataArray['sc_id']=$value->sc_id;
                $dataArray['code']=$value->code;
                $dataArray['party_name']=$value->party_name;
                $dataArray['po_no']=$value->po_no;
                $dataArray['po_date']=$value->po_date;
                $dataArray['SC_NO']=$value->SC_NO;
                $dataArray['SC_Date']=$value->SC_Date;
                $dataArray['User_Id']=$value->User_Id;
                $dataArray['desk']=$value->desk;
                $items=DB::select("select
                                ci_items.ci_item_code as Item_Id,
                                ci_items.ci_item_name as Item_Name,
                                t1.party_item_code as Party_Item_Code,
                                t1.party_item_name as Party_Item_Name,
                                t2.job_order_number as JO_NO,
                                t2.jo_id,
                                t2.jo_date as Jo_Date,
                                t2.orqt as Item_Qty,
                                t2.unit as Unit,
                                case when t3.prod_qty then t3.prod_qty else 0 end as prod_qty
                            from po_master
                            join po_item_details on po_item_details.master_id = po_master.ID
                            join sale_contracts on sale_contracts.po_master_id = po_master.ID
                            join ci_items on ci_items.id=po_item_details.item_id
                            left join (select ci_item_id,party_item_code,party_item_name
                                        from party_order_items
                                        where party_id=1
                                        ) as t1 on po_item_details.item_id=t1.ci_item_id
                            left join(
                                    select
                                        job_order_masters.id as jo_id,
                                        job_order_masters.job_order_number,
                                        job_order_masters.sale_contract_id,
                                        job_order_details.item_id,
                                        job_order_details.orqt,
                                        date(job_order_masters.created_at) as jo_date,
                                        dunits.dunit_name as unit
                                    from job_order_masters
                                    join job_order_details on job_order_details.master_id=job_order_masters.id
                                    join dunits on dunits.id = job_order_details.du_unit
                                    where job_order_masters.status != 3 and job_order_details.item_status = 'Y'
                                ) as t2 on t2.sale_contract_id=sale_contracts.id and t2.item_id=po_item_details.item_id
                            
                            left join (
                                        select
                                        production_details.prod_qty,
                                        production_details.job_order_id,
                                        production_details.item_id
                                        from production_details
                                        ) t3 on t3.job_order_id=t2.jo_id and t3.item_id=po_item_details.item_id
                            where sale_contracts.id=2480
                            order by t2.jo_id asc");

                foreach($items as $key => $item) {

                    $item_array[]=array('Item_Id'=>$item->Item_Id, 'Item_Name'=>$item->Item_Name,'Party_Item_Code'=>$item->Party_Item_Code,'Party_Item_Name'=>$item->Party_Item_Name,'JO_NO'=>$item->JO_NO,'Jo_Date'=>$item->Jo_Date,'Item_Qty'=>$item->Item_Qty,'Unit'=>$item->Unit,'prod_qty'=>$item->prod_qty);
                    $dataArray['items']=$item_array;
                    
                }

                $empty_array[]=$dataArray;

            
            }
        
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'
                    and notify_parties.status=1");    

        return view('reports.order_trucking.order_trucking_report')
               ->with('empty_array',$empty_array)
               ->with('notifyParties',$notifyParties)
               ->with('form_date',$request->from_date)
               ->with('to_date',$request->to_date)
               ->with('party_id',$party_id);

    }

    public function joReport(){

        $regions = Area::whereNotIn('id', [3, 7, 17, 20])->get();    
        return view('reports.jo_report')->with('regions',$regions);

    }

    public function jo_details(){

        return view('reports.jo_details');

    }

    public function getJoInvoiceDetails(Request $request){
          
        try {
            
            $search = $request->input('search', '');
            $results = DB::select('CALL sp_search_jo_invoice_details(?)', [$search]);
            return response()->json([
                'status' => 'success',
                'data' => $results
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }


        
     
    }


    public function exportJOInvoiceDetails(Request $request)
    {
        try {
            // Get search parameter
            $search = $request->input('search', '');

            // Call stored procedure
            $data = collect(DB::select(
                "CALL sp_search_jo_invoice_details(?)",
                array($search)
            ));

            // Check if data exists
            if ($data->isEmpty()) {
                return redirect()->back()->with('error', 'No data found to export');
            }

            // Direct Excel Download
            return Excel::create('JO_Invoice_Details_' . date('YmdHis'), function ($excel) use ($data) {

                $excel->sheet('JO Invoice Details', function ($sheet) use ($data) {

                    $sheet->setOrientation('landscape');
                    $sheet->setFontFamily('Calibri');
                    $sheet->setFontSize(10);

                    $row = 1;

                    // ================ HEADER =================
                    $sheet->mergeCells("A{$row}:O{$row}");
                    $sheet->row($row, array("JO / Invoice Details Report"));
                    $sheet->cells("A{$row}:O{$row}", function ($cells) {
                        $cells->setBackground('#1F4E78');
                        $cells->setFontColor('#FFFFFF');
                        $cells->setFontWeight('bold');
                        $cells->setFontSize(14);
                    });
                    $row++;

                    // ================ DATE & INFO =================
                    $sheet->row($row, array(
                        'Generated Date:', date('d-m-Y H:i:s'),
                        'Total Records:', $data->count()
                    ));
                    $sheet->cells("A{$row}:D{$row}", function ($cells) {
                        $cells->setBackground('#EAF2F8');
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                    $row += 2;

                    // ================ COLUMN HEADERS =================
                    $sheet->row($row, array(
                        'SL',
                        'Contract No',
                        'Contract Date',
                        'Invoice No',
                        'Party Code',
                        'Party Name',
                        'Item Code',
                        'Item Name',
                        'SC Qty(Ctn)',
                        'JO Number',
                        'JO Qty(Ctn)',
                        'FOB Rate',
                        'JO Date',
                        'JO Creator',
                        'Contract Creator'
                    ));

                    $sheet->cells("A{$row}:O{$row}", function ($cells) {
                        $cells->setBackground('#D9EAD3');
                        $cells->setFontWeight('bold');
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                    $row++;

                    // ================ DATA ROWS =================
                    $sl = 1;
                    $totalSCQty = 0;
                    $totalJOQty = 0;

                    foreach ($data as $item) {
                        
                        $scQty = isset($item->sc_qty) ? floatval($item->sc_qty) : 0;
                        $joQty = isset($item->jo_qty) ? floatval($item->jo_qty) : 0;
                        $fobRate = isset($item->fob_rate) ? floatval($item->fob_rate) : 0;

                        $sheet->row($row, array(
                            $sl++,
                            isset($item->contract_no) ? $item->contract_no : '',
                            isset($item->contract_date) ? $item->contract_date : '',
                            isset($item->invoice_no) ? $item->invoice_no : '',
                            isset($item->party_code) ? $item->party_code : '',
                            isset($item->party_name) ? $item->party_name : '',
                            isset($item->ci_item_code) ? $item->ci_item_code : '',
                            isset($item->ci_item_name) ? $item->ci_item_name : '',
                            $scQty,
                            isset($item->jo_number) ? $item->jo_number : '',
                            $joQty,
                            number_format($fobRate, 2),
                            isset($item->jo_date) ? $item->jo_date : '',
                            isset($item->jo_creator) ? $item->jo_creator : '',
                            isset($item->contract_creator) ? $item->contract_creator : ''
                        ));

                        $sheet->cells("A{$row}:O{$row}", function ($cells) {
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });

                        $totalSCQty += $scQty;
                        $totalJOQty += $joQty;

                        $row++;
                    }

                    // ================ TOTAL ROW =================
                    $sheet->row($row, array(
                        '', '', '', '', '', '', '', 'TOTAL',
                        $totalSCQty, '', $totalJOQty, '', '', '', ''
                    ));

                    $sheet->cells("A{$row}:O{$row}", function ($cells) {
                        $cells->setBackground('#F2F2F2');
                        $cells->setFontWeight('bold');
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                    });

                    // ================ AUTO WIDTH =================
                    foreach (range('A', 'O') as $col) {
                        $sheet->setWidth($col, 16);
                    }
                    $sheet->setWidth('B', 20);   // Contract No
                    $sheet->setWidth('D', 18);   // Invoice No
                    $sheet->setWidth('F', 30);   // Party Name
                    $sheet->setWidth('H', 35);   // Item Name
                    $sheet->setWidth('J', 20);   // JO Number
                    $sheet->setWidth('L', 18);   // FOB Rate
                    $sheet->setWidth('N', 25);   // JO Creator
                    $sheet->setWidth('O', 25);   // Contract Creator
                });

            })->download('xlsx');

        } catch (\Exception $e) {
            \Log::error('Export error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }
    public function jsonGetJoReportData(Request $request)
    {
        try {

            $regionId = $request->input('region_id', null);
            $countryNames = $request->input('country_list', []);
            $partyIds = $request->input('party_list', []);
            $fromDate = $request->has('fromDate') && $request->fromDate ? date('Y-m-d', strtotime($request->fromDate)) : null;
            $toDate = $request->has('toDate') && $request->toDate ? date('Y-m-d', strtotime($request->toDate)) : null;
            $invoiceNo = $request->input('invoice_no', null);
            $countryNamesStr = !empty($countryNames) ? implode(',', $countryNames) : '';
            $partyIdsStr = !empty($partyIds) ? implode(',', $partyIds) : '';
            
            return [
                $regionId, 
                $countryNamesStr, 
                $fromDate, 
                $toDate, 
                $invoiceNo
            ];


            $data = DB::select("CALL PROD_JO_REPORT(?, ?, ?, ?, ?)", [
                $regionId, 
                $countryNamesStr, 
                $fromDate, 
                $toDate, 
                $invoiceNo
            ]);
            
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'total' => count($data)
            ]);
            
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);

        }

    }

    public function getCancelJoData(){

        return view('reports.jo_cancel_report');

    }

    public function jsonGetCancelReportData(Request $request){

        $dateFrom = date("Y-m-d",strtotime($request->from_date));
        $dateTo = date("Y-m-d",strtotime($request->to_date));  
        $results=DB::select("SELECT 
            notify_parties.code                                   as p_code,
            notify_parties.name                                   as p_name,
            notify_parties.country                                as country,
            concat(users.username, '-', users.name)               as user,
            job_order_masters.job_order_number                    as jo_no,
            ci_items.ci_item_name                                 as name,
            ci_items.ci_item_code                                 as code,
            job_order_details.orqt                                as `order`,
            job_order_details.rate                                as rate,
            date(job_order_masters.created_at)                    as date,
            job_order_details.item_status                         as status,
            sale_contracts.invoice_no                             as invoice
            from job_order_masters
                join sale_contracts on sale_contracts.id = job_order_masters.sale_contract_id
                join job_order_details on job_order_details.master_id = job_order_masters.id
                join notify_parties on notify_parties.id = job_order_masters.importer_id
                join ci_items on ci_items.id = job_order_details.item_id
                join users on users.id=job_order_masters.user_id
            where (job_order_masters.status = 3 or job_order_details.item_status='N')
                  AND date(job_order_masters.created_at)>='$dateFrom'
                  AND date(job_order_masters.created_at)<='$dateTo'
            ORDER BY job_order_masters.created_at");  

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
    
    public function freightReport(Request $request){

        return view('reports.freight_report');

    }

    public function getFreightReportData(Request $request){
        
        $from_date=NULL; 
        if($request->from_date){
           
            $from_date=date("Y-m-d", strtotime($request->from_date));
            
        } 

        $to_date=NULL;
        if($request->to_date){
           
            $to_date=date("Y-m-d", strtotime($request->to_date));
 
        }
        
        $results=DB::select("CALL PROC_FREIGHT_REPORT(?,?)", [$from_date,$to_date]);
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

    public function jsonGetTnaReport(Request $request){
        
        $from_date=date("Y-m-d", strtotime($request->from_date));
        $to_date=date('Y-m-d', strtotime($request->to_date));
        $query='';
        switch($request->port_type) {

            case 1:
                
                $taskNamesLand=DB::select("SELECT task_definition.ID as id ,task_definition.DESCRIPTION as name
                                    FROM `template_details`
                                    join task_definition on task_definition.ID=template_details.TASK_ID
                                    WHERE MASTER_ID=1");

                foreach($taskNamesLand as $task){

                    $id=$task->id;
                    $name=$task->name;
                    $query .=", MAX(IF(t1.Task_ID=$id, action_date,'')) as `col_$id`";
                
                }
                
                $results=\DB::select("select
                        po_no,
                        sc_id as id,
                        sc_no as invoice_no
                        ".$query."
                        from landport_dashboard_data as t1
                        where (date(sc_date) >='$from_date' and date(sc_date) <='$to_date')
                        group by t1.po_no, sc_no, sc_id");

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

                break;

            case 2:
                
                $taskNamesLand=DB::select("SELECT task_definition.ID as id ,task_definition.DESCRIPTION as name
                                    FROM `template_details`
                                    join task_definition on task_definition.ID=template_details.TASK_ID
                                    WHERE MASTER_ID=3");
                foreach($taskNamesLand as $task){

                    $id=$task->id;
                    $name=$task->name;
                    $query .=", MAX(IF(t1.Task_ID=$id, action_date,'')) as `col_$id`";
                
                }

                $results=\DB::select("select
                        po_no,
                        sc_id as id,
                        sc_no as invoice_no
                        ".$query."
                        from seaport_dashboard_data as t1
                        WHERE (date(sc_date) >='$from_date' and date(sc_date) <='$to_date')
                        group by t1.po_no, sc_no, sc_id");

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

                break;

        }         


    }

    public function tnaProgressReport(Request $request){
      
        $desks = Desk::whereNotIn('id', [7, 12, 13])->where('status',1)->orderBy('name', 'asc')->get();
        $tasks=DB::select("select task_definition.DESCRIPTION as task_name,task_definition.ID as task_id from task_definition where SEQUANCE!=0 order by SEQUANCE asc");
        return view('reports.tna_progress_report',compact('desks'))->with("tasks",$tasks);

    }

    public function getTNAProgReportData(Request $request){
        
        $query='';
        $from_date=date("Y-m-d", strtotime($request->from_date));
        $to_date=date("Y-m-d", strtotime($request->to_date));
        $desk_id=$request->desk_id;
        if($desk_id=="All"){
         
            $where = "(tna_report.sc_date >='$from_date' and tna_report.sc_date <='$to_date') and po_master.STATUS=1";

        }else{
        
            $area_ids = Area::where('desk_id', $desk_id)->pluck('id')->toArray();
            $area_ids = implode(',', $area_ids);
            $where = "(tna_report.sc_date >= '$from_date' and tna_report.sc_date <= '$to_date') and po_master.STATUS=1 and tna_report.area_id in ($area_ids)";

        }
        $reportMenus=DB::select("select task_definition.DESCRIPTION as task_name,task_definition.ID as task_id from task_definition where SEQUANCE!=0 order by SEQUANCE asc");
        foreach($reportMenus as $key => $task) {
        
            $task_id=$task->task_id;
            $task_name=$task->task_name;
            $query.=", CONCAT(
                    COALESCE(DATE_FORMAT(max(case when tb1.Task_ID = $task_id THEN tb1.from_date END), '%d-%b-%y'), ''), ',',
                    COALESCE(DATE_FORMAT(max(case when tb1.Task_ID = $task_id THEN tb1.to_date END), '%d-%b-%y'), ''), ',',
                    COALESCE(DATE_FORMAT(max(case when tb1.Task_ID = $task_id THEN tb1.action_date END), '%d-%b-%y'), ''),',',
                    max(case when tb1.Task_ID = $task_id THEN tb1.user END),',',
                        SUM(CASE WHEN tb1.Task_ID = $task_id AND (tb1.action_date IS NULL AND current_date() <= tb1.to_date)
                        THEN DATEDIFF(tb1.to_date, CURRENT_DATE())
                            WHEN tb1.Task_ID = $task_id AND (tb1.action_date IS NULL AND current_date() >= tb1.to_date)
                            THEN DATEDIFF(tb1.to_date, CURRENT_DATE())
                            WHEN tb1.Task_ID = $task_id AND (tb1.action_date IS NOT NULL AND tb1.action_date <= tb1.to_date)
                            THEN DATEDIFF(tb1.to_date, tb1.action_date)
                            WHEN tb1.Task_ID = $task_id AND (tb1.action_date IS NOT NULL AND tb1.action_date >= tb1.to_date)
                            THEN DATEDIFF(tb1.to_date, tb1.action_date) END)) as `$task_name`";
        

        }

        $reportData=DB::select("select
            COALESCE(tb1.ref_name,'') as desk,
            tb1.inv_no as inv,
            tb1.po_no as po_no
            ".$query."
            from(
                SELECT
                    tna_report.po_no,
                    tna_report.inv_no,
                    tna_report.Task_ID,
                    tna_report.from_date,
                    tna_report.po_date,
                    tna_report.to_date,
                    tna_report.action_date,
                    notify_parties.ref_name,
                    ''  as user
                FROM tna_report
                JOIN po_master on po_master.ID=tna_report.po_id
                JOIN notify_parties on notify_parties.id=tna_report.party_id
                WHERE $where) as tb1
                group by tb1.po_no,tb1.po_date
                order by tb1.po_no");

        return response()->json([
            'reportMenus'=>$reportMenus,
            'reportData'=>$reportData
        ]);    

    }


    public function updateGrossWeight(){

        $results=DB::select("select
            sale_contract_details.id,
            sale_contracts.notify_pary_id,
            sale_contract_details.ci_item_id,
            sale_contract_details.gross_weight_kg,
            sale_contract_details.gross_weight_per_item,
            sale_contract_details.ctn,
            ci_items.ci_factor
        from sale_contract_details
        join sale_contracts on sale_contracts.id = sale_contract_details.sale_contract_id
        join ci_items on ci_items.id=sale_contract_details.ci_item_id
        where sale_contracts.id = 52347");

        foreach($results as $result){
            
            $gross_weight=NotifyPartyItem::where('notify_party_id',$result->notify_pary_id)->where('ci_item_id',$result->ci_item_id)->value('gross_weight');
            $total_gwt=round($gross_weight*$result->ctn,6); 
            $gwt_pitem=round($total_gwt/$result->ci_factor,6);
            SaleContractDetail::where('id',$result->id)->update([
                'gross_weight_kg'=>$total_gwt,
                'gross_weight_per_item'=>$gwt_pitem
            ]);

        }

    }

    public function updateCBM(){

        $results=DB::select("select
            sale_contract_details.id,
            sale_contracts.notify_pary_id,
            sale_contract_details.ci_item_id,
            sale_contract_details.gross_weight_kg,
            sale_contract_details.gross_weight_per_item,
            sale_contract_details.ctn,
            sale_contract_details.cbm_per_ctn,
            ci_items.ci_factor
        from sale_contract_details
        join sale_contracts on sale_contracts.id = sale_contract_details.sale_contract_id
        join ci_items on ci_items.id=sale_contract_details.ci_item_id
        where sale_contract_details.cbm_per_ctn=0");
        foreach($results as $result){
            
            $cbm_per_ctn=NotifyPartyItem::where('notify_party_id',$result->notify_pary_id)->where('ci_item_id',$result->ci_item_id)->value('cbm_per_ctn');
            $totalCalCbm=round($cbm_per_ctn*$result->ctn,6); 
            SaleContractDetail::where('id',$result->id)->update([
                'total_cbm'=>$totalCalCbm,
                'cbm_per_ctn'=>$cbm_per_ctn
            ]);

        }

    }

    public function poDetailsReport(Request $request){

        $regions = Area::whereNotIn('id', [3, 7, 17, 20])->get(); 
        return view('reports.po_details_report')->with('regions',$regions);

    }

     public function poPoDetailsReportData(Request $request){

        try {

            $region_id = $request->input('region_id');
            $countryList = $request->input('country_list');
            $from_date=date("Y-m-d", strtotime($request->fromDate));
            $to_date=date("Y-m-d", strtotime($request->toDate));  
            $countryNames = null;
            if (is_array($countryList) && count($countryList) > 0) {
                $countryNames = implode(',', $countryList);
            }    

         

            // Call procedure with all 4 parameters
            $results = DB::select('CALL PROC_PO_Wise_Report(?, ?, ?, ?)', [
                $region_id,                  
                $countryNames,              
                $from_date,               
                $to_date    
            ]);
            
            return response()->json([
                'status' => 'success',
                'data' => $results,
                'total' => count($results)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

    }

    public function scDetailsReport(Request $request){
         
        $regions = Area::whereNotIn('id', [3, 7, 17, 20])->get();
        return view('reports.sc_details_report')->with('regions',$regions);

    }

    public function gpSummaryReport(Request $request){

        $regions = Area::whereNotIn('id', [3, 7, 17, 20])->get();
        return view("reports.gp_summary")->with('regions',$regions);  

    }

    public function getGpSummaryDate(Request $request)
    {
        try {
            $region_id = $request->input('region_id', 1);
            $countryList = $request->input('country_list');
            $from_date = $request->input('fromDate') ? date("Y-m-d", strtotime($request->input('fromDate'))) : null;
            $to_date = $request->input('toDate') ? date("Y-m-d", strtotime($request->input('toDate'))) : null;
            $invoice_no = $request->input('invoice_search');
            $countryNames = is_array($countryList) && count($countryList) > 0 ? implode(',', $countryList) : null;
            $results = DB::select('CALL GetInvoiceWiseGPSummary(?, ?, ?, ?, ?)', [
                $region_id,
                $countryNames,
                $from_date,
                $to_date,
                $invoice_no
            ]);
            
            return response()->json([
                'status' => 'success',
                'data' => $results,
                'total' => count($results)
            ]);
            
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function gpDetailsReport(Request $request){

        $regions = Area::whereNotIn('id', [3, 7, 17, 20])->get();
        return view("reports.gp_details")->with('regions',$regions);   

    }

    public function getGpDetailsDate(Request $request)
    {
        try {
            
            $region_id = $request->input('region_id', 1);
            $countryList = $request->input('country_list');
            $from_date = $request->input('fromDate') ? date("Y-m-d", strtotime($request->input('fromDate'))) : null;
            $to_date = $request->input('toDate') ? date("Y-m-d", strtotime($request->input('toDate'))) : null;
            $invoice_no = $request->input('invoice_search');
            $countryNames = is_array($countryList) && count($countryList) > 0 ? implode(',', $countryList) : null;
            $results = DB::select('CALL GpDetailsReport(?, ?, ?, ?, ?)', [
                $region_id,
                $countryNames,
                $from_date,
                $to_date,
                $invoice_no
            ]);
            
            return response()->json([
                'status' => 'success',
                'data' => $results,
                'total' => count($results)
            ]);
            
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function jsonGetGpDetails(Request $request){

       
        try {

            $contractId = $request->input('contractId');
            $results = DB::select('CALL GET_INVOICE_WISE_GP_DETILS(?)', [
                $contractId
            ]);
            
            return response()->json([
                'status' => 'success',
                'data' => $results,
                'total' => count($results)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
 
    }

    public function scVsJoReport(Request $request){
       
       $regions = Area::whereNotIn('id', [3, 7, 17, 20])->get();
       return view('reports.sc_vs_jo')->with('regions',$regions);;

    }

    public function jsonGetScVsJOData(Request $request)
    {
        try {
            
            $search = $request->input('search', '');
            $regionId = $request->input('region_id', null);
            $countryNames = $request->input('country_list', '');
            $fromDate = $request->input('fromDate', null);
            $toDate = $request->input('toDate', null);
            if (is_array($countryNames)) {
                $countryNames = implode(',', $countryNames);
            }

            if (!empty($search)) {
                $regionId = null;
                $countryNames = '';
                $fromDate = null;
                $toDate = null;
            } else {
                
                if ($fromDate) {
                    $fromDate = date('Y-m-d', strtotime($fromDate));
                }
                if ($toDate) {
                    $toDate = date('Y-m-d', strtotime($toDate));
                }
            }

            $results = DB::select(
                'CALL PROC_SC_JO_Report(?, ?, ?, ?, ?)',
                [
                    $search,
                    $regionId,
                    $countryNames,
                    $fromDate,
                    $toDate
                ]
            );

            return response()->json([
                'status' => 'success',
                'data' => $results
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function scVsJoVsDoReport(Request $request){
       
       $regions = Area::whereNotIn('id', [3, 7, 17, 20])->get();
       return view('reports.sc_vs_jo_vs_do')->with('regions',$regions);

    }

    public function jsonGetScVsJOVsDoData(Request $request)
    {
        try {
            
            $search = $request->input('search', '');
            $regionId = $request->input('region_id', null);
            $countryNames = $request->input('country_list', '');
            $fromDate = $request->input('fromDate', null);
            $toDate = $request->input('toDate', null);
            if (is_array($countryNames)) {
                $countryNames = implode(',', $countryNames);
            }

            if (!empty($search)) {
                $regionId = null;
                $countryNames = '';
                $fromDate = null;
                $toDate = null;
            } else {
                
                if ($fromDate) {
                    $fromDate = date('Y-m-d', strtotime($fromDate));
                }
                if ($toDate) {
                    $toDate = date('Y-m-d', strtotime($toDate));
                }
            }

            $results = DB::select(
                'CALL SC_JO_DO_Report(?, ?, ?, ?, ?)',
                [
                    $search,
                    $regionId,
                    $countryNames,
                    $fromDate,
                    $toDate
                ]
            );

            return response()->json([
                'status' => 'success',
                'data' => $results
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
}
