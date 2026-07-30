<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Group;
use App\SaleContract;
use App\SCI;
use App\ItemGroup;
use App\SciStatus;
use App\ComInvMaster;
use App\ComInvMasterDetails;
use App\Company;
use DB;
use Illuminate\Support\Facades\Input;
use App\InsentivePercentage;
use Excel;
use Session;
use Auth;
class CaseInsentiveController extends Controller
{

    public function __construct(){

       $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return 100;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function topListView(){

       $saleContracts=SaleContract::orderBy('id','Desc')->paginate(11);
       return view('ci.top_list')->with('saleContracts', $saleContracts);

    }

    public function jsonGetInvoiceList(Request $request){
         
        return $results=\DB::select("SELECT
                s_c_i_s.id,
                s_c_i_s.exp_no AS export_no,
                s_c_i_s.invoice_no AS invoice_no,
                s_c_i_s.exp_amount_usd AS invoice_amount,
                companies.code as company,
                s_c_i_s.proceeds_realization_date AS realized_date,
                s_c_i_s.exp_submit_date AS exp_submit_date,
                s_c_i_s.invoice_date AS invoice_date,
                sale_contracts.sales_contract_no,
                sale_contracts.dated,
                s_c_i_s.country_or_expored_name AS country,
                s_c_i_s.over_due AS over_due_date,
                SUM(swift_histories.breakup_value) AS break_up,
                s_c_i_s.shipped_on_board_date,
                s_c_i_s.exp_amount_usd-SUM(swift_histories.breakup_value) AS over_due
             FROM s_c_i_s
             JOIN sale_contracts ON sale_contracts.id=s_c_i_s.sale_contract_id
             JOIN companies ON companies.id=sale_contracts.company_id
             JOIN swift_updates ON swift_updates.sale_contract_id=s_c_i_s.sale_contract_id
             JOIN swift_histories ON swift_histories.master_id=swift_updates.id
             WHERE s_c_i_s.over_due_status_id=1 AND s_c_i_s.invoice_no LIKE '%$request->data%' 
             GROUP BY s_c_i_s.invoice_no LIMIT 10");

    }

    public function jsonGetInvoiceListForMasterBook(Request $request){

        return $scis=SCI::select('s_c_i_s.*','sci_statuses.name','sale_contracts.sales_contract_no','sale_contracts.dated')
                   ->where('s_c_i_s.invoice_no', 'like', '%' . $request->data . '%')
                   ->orWhere('s_c_i_s.exp_no', 'like', '%' . $request->data . '%')
                   ->orWhere('s_c_i_s.ad_code', 'like', '%' . $request->data . '%')
                   ->orWhere('s_c_i_s.claim_submission_date', 'like', '%' . $request->data . '%')
                   ->orWhere('s_c_i_s.over_due', 'like', '%' . $request->data . '%')
                   ->join('sci_statuses','sci_statuses.id','s_c_i_s.sci_status_id')
                   ->join('sale_contracts','sale_contracts.id','s_c_i_s.sale_contract_id')
                   ->get(50); 


    }

    public function jsonGetInvoiceListForMasterBookAll(Request $request){
        
        $form_date=date('Y-m-d', strtotime($request->form_date));
        $to_date=date('Y-m-d', strtotime($request->to_date));
        return $scis=SCI::select('s_c_i_s.*','sci_statuses.name','sale_contracts.sales_contract_no','sale_contracts.dated')
                   ->whereBetween('s_c_i_s.created_at', [$form_date, $to_date])
                   ->join('sci_statuses','sci_statuses.id','s_c_i_s.sci_status_id')
                   ->join('sale_contracts','sale_contracts.id','s_c_i_s.sale_contract_id')
                   ->get(); 


    }

    public function overDueList(Request $request){

        $data=DB::select("SELECT
                s_c_i_s.id,
                s_c_i_s.exp_no AS export_no,
                s_c_i_s.invoice_no AS invoice_no,
                s_c_i_s.exp_amount_usd AS invoice_amount,
                companies.code as company,
                s_c_i_s.proceeds_realization_date AS realized_date,
                s_c_i_s.exp_submit_date AS exp_submit_date,
                s_c_i_s.invoice_date AS invoice_date,
                sale_contracts.sales_contract_no,
                sale_contracts.dated,
                s_c_i_s.country_or_expored_name AS country,
                s_c_i_s.over_due AS over_due_date,
                SUM(swift_histories.breakup_value) AS break_up,
                s_c_i_s.shipped_on_board_date,
                s_c_i_s.exp_amount_usd-SUM(swift_histories.breakup_value) AS over_due
             FROM s_c_i_s
             JOIN sale_contracts ON sale_contracts.id=s_c_i_s.sale_contract_id
             JOIN companies ON companies.id=sale_contracts.company_id
             JOIN swift_updates ON swift_updates.sale_contract_id=s_c_i_s.sale_contract_id
             JOIN swift_histories ON swift_histories.master_id=swift_updates.id
             WHERE s_c_i_s.over_due_status_id=1
             GROUP BY s_c_i_s.invoice_no");
        $results=$this->generatePaginationForOverDueList($data);
        return view('ci.over_due')->with('results', $results);

    }

    private function generatePaginationForOverDueList($data){

        $page = Input::get('page', 1);  
        $paginate = 10;    
        $offSet = ($page * $paginate) - $paginate;  
        $parameters = Input::getQueryString();
        $parameters = preg_replace('/&page(=[^&]*)?|^page(=[^&]*)?&?/','', $parameters);
        $path = url('/') . '/swift_list?' . $parameters;
        $itemsForCurrentPage = array_slice($data, $offSet, $paginate, true);  
        $results = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($data), $paginate, $page); 
        return $results = $results->withPath($path);
  

    }

     public function prcList(){
        
        $data=DB::select("SELECT
                    s_c_i_s.exp_no AS export_no,
                    s_c_i_s.exp_no AS export_date,
                    s_c_i_s.exp_submit_date AS exp_submit_date,
                    s_c_i_s.invoice_no AS invoice_no,
                    s_c_i_s.invoice_date AS invoice_date,
                    s_c_i_s.shipped_on_board_date,
                    sale_contracts.bl_no,
                    sale_contracts.bl_date,
                    s_c_i_s.discharge_port,
                    s_c_i_s.see_freight AS freight_cost,
                    sale_contracts.sales_contract_no AS sales_contract_no,
                    sale_contracts.dated,
                    sale_contracts.importer_country,
                    s_c_i_s.exp_amount_usd AS invoice_amount,
                    s_c_i_s.amount_of_proceed_realized AS realized_amount,
                    s_c_i_s.proceeds_realization_date AS realized_date
                FROM s_c_i_s
                JOIN sale_contracts ON sale_contracts.id=s_c_i_s.sale_contract_id
                WHERE s_c_i_s.prc_list_status_id = 1");
        $results=$this->generatePaginationPrcList($data);                  
        return view('ci.prc_list')->with('results', $results);


    }

    public function getPrc(Request $request)
    {
        try {

            $fromDate = $request->from_date;
            $toDate   = $request->to_date;
            $checkOk  = $request->check_ok;

            $results = DB::select('CALL PRC(?, ?, ?)', [
                $fromDate,
                $toDate,
                $checkOk
            ]);

            $formattedResults = [];
            foreach ($results as $key => $row) {
                $formattedResults[] = [
                    'id' => $row->id,
                    'ci_shadow_file'=> $row->ci_shadow_file,
                    'invoice_no' => $row->invoice_no,
                    'prc_issue_number' => $row->prc_issue_number,
                    'prc_issue_date' => $row->prc_issue_date,
                    'exp_no'=> $row->exp_no,
                    'exp_date'=> $row->exp_date,
                    'company'=> $row->company
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $formattedResults
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function jsonGetPrcList(Request $request){

        return $data=DB::select("SELECT
                    s_c_i_s.exp_no AS export_no,
                    s_c_i_s.exp_no AS export_date,
                    s_c_i_s.exp_submit_date AS exp_submit_date,
                    s_c_i_s.invoice_no AS invoice_no,
                    s_c_i_s.invoice_date AS invoice_date,
                    s_c_i_s.shipped_on_board_date,
                    sale_contracts.bl_no,
                    sale_contracts.bl_date,
                    s_c_i_s.discharge_port,
                    s_c_i_s.see_freight AS freight_cost,
                    sale_contracts.sales_contract_no AS sales_contract_no,
                    sale_contracts.dated,
                    sale_contracts.importer_country,
                    s_c_i_s.exp_amount_usd AS invoice_amount,
                    s_c_i_s.amount_of_proceed_realized AS realized_amount,
                    s_c_i_s.proceeds_realization_date AS realized_date
                FROM s_c_i_s
                JOIN sale_contracts ON sale_contracts.id=s_c_i_s.sale_contract_id
                WHERE s_c_i_s.over_due_status_id=1 AND s_c_i_s.invoice_no LIKE '%$request->data%'");
        
    }
    private function generatePaginationPrcList($data){

        $page = Input::get('page', 1);  
        $paginate = 10;    
        $offSet = ($page * $paginate) - $paginate;  
        $parameters = Input::getQueryString();
        $parameters = preg_replace('/&page(=[^&]*)?|^page(=[^&]*)?&?/','', $parameters);
        $path = url('/') . '/prc/list?' . $parameters;
        $itemsForCurrentPage = array_slice($data, $offSet, $paginate, true);  
        $results = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($data), $paginate, $page); 
        return $results = $results->withPath($path);
  

    }

    public function masterBookView(){
          
       $year=date("Y");   
       $scis=SCI::orderBy('id','ASC')->whereYear('created_at',$year)->paginate(100);
       return view('ci.master_book')->with('scis', $scis);

    }


    public function masterBookViewAll(){

       return view('ci.ci_master_book_all');

    }


    public function masterBookEditView(Request $request, $id){

       $sci=SCI::findorfail($id);
       $edit_sci_id =$sci->sale_contract_id;
       $sciStatuses=SciStatus::all(); 
       $current_date=date('Y-m-d'); 
       $previous_date=date('Y-m-d', strtotime('-36 month')); 
       $sale_contracts=SaleContract::where('id',$sci->sale_contract_id)->get();

        $non_eligible_item_totals =SaleContract::where('sale_contracts.id',$sci->sale_contract_id)
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
        $NonEligibletotalNetWeight=0;
        $non_eligible_total_amount=0;
        $sale_contract = SaleContract::find($sci->sale_contract_id);
        $results=\DB::select("SELECT SUM(sale_contract_details.net_weight_kg) as total_net_weight_kg
                            FROM sale_contract_details
                            WHERE sale_contract_details.sale_contract_id='$sci->sale_contract_id'");
        foreach ($results as $key => $value) {
           
             $total_net_weight=$value->total_net_weight_kg;
             
        }

        try { 

               $freight_cost=$sale_contract->freight_cost;
               $per_unit_freight=$freight_cost/$total_net_weight;
                          
            }catch (Exception $e) {


        }
        foreach($non_eligible_item_totals as $key => $sale_contract_detail) {

                try { 
                
                      if($sale_contract_detail->ci_factor!=0){

                             $per_net_weight_kg_fright=$per_unit_freight*$sale_contract_detail->net_weight_kg;
                             $caton_fright=$per_net_weight_kg_fright/$sale_contract_detail->ctn;
                             $carton_fright_pl_rate=$caton_fright+$sale_contract_detail->rate_per_ctn;
                             $NonEligibletotalNetWeight=$NonEligibletotalNetWeight+$sale_contract_detail->net_weight_kg;
                            
                      }else{

                        $carton_fright_pl_rate="0";

                      }
                }catch (Exception $e) {
 
                } 
                
                $non_eligible_total_amount=$non_eligible_total_amount+$carton_fright_pl_rate*$sale_contract_detail->ctn;

        }
        $eligibleItemNetWeight=0;
        $itemDetails=DB::select("SELECT
                item_groups.item_group_name,
                item_groups.id AS item_group_id,
                sale_contracts.id AS sale_contract_id,
                SUM(sale_contract_details.net_weight_kg) AS net_weight_kg,
                bus.name,bus.code,bus.id as bu_id
            FROM
                sale_contracts
            JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
            JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
            JOIN bus ON bus.id=ci_items.bu_id
            JOIN item_groups ON item_groups.id = ci_items.item_group_id
            WHERE
                sale_contracts.id = '$sci->sale_contract_id' AND item_groups.id!=236
            GROUP BY
                bus.name,item_groups.item_group_name");
         
        foreach ($itemDetails as $key => $value) {

           $eligibleItemNetWeight=$eligibleItemNetWeight+$value->net_weight_kg;
            
        } 
       
       return view('ci.master_book_edit')
             ->with('sci', $sci)
             ->with('sciStatuses',$sciStatuses)
             ->with('sale_contracts', $sale_contracts)
             ->with('edit_sci_id',$edit_sci_id)
             ->with('non_eligible_total_amount',$non_eligible_total_amount)
             ->with('eligibleItemNetWeight',$eligibleItemNetWeight);

    }
    
    public function cashInsentiveReportView(Request $request){


        $insentivePercents=InsentivePercentage::all();
        $regions=DB::select("select count(notify_parties.region) as count,notify_parties.region,notify_parties.region_code
                from notify_parties
                group by notify_parties.region,notify_parties.region_code");

        return view('case_insentive.report_index')
               ->with('insentivePercents',$insentivePercents)
               ->with('regions',$regions);      

    }

    public function cashInsentiveReportShow(Request $request){

            $fromDate = date("Y-m-d", strtotime($request->fromDate));
            $toDate   = date('Y-m-d', strtotime($request->toDate));
            $region   = $request->region;
            if($request->region!='All'){

                $results=\DB::select("Select a.* from ((SELECT
                            s_c_i_s.ad_code,
                            companies.code AS exporter_name,
                            CONCAT(bus.name,'-',bus.code) as bu_name,
                            item_groups.item_group_name as Item,
                            com_inv_masters.invoice_no as Invoice,
                            notify_parties.region as region,
                            CONCAT('$',FORMAT(com_inv_masters.invoice_value,2)) as Invoice_Amount,
                            FORMAT(SUM(com_inv_master_details.claim_bdt),2) as total_amout,
                            SUM(com_inv_master_details.30_percent_insentive_amount) as 30_percent,
                            com_inv_masters.30_percent_insentive_date as 30_percent_date,
                            0 as 70_percent,
                            '' as 70_percent_date,
                            0 as 100_percent,
                            '' as 100_percent_date
                        FROM
                            com_inv_masters
                            JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id = com_inv_masters.id
                            JOIN item_groups ON item_groups.id = com_inv_master_details.item_group_id
                            JOIN bus ON bus.id=com_inv_master_details.bu_id
                            JOIN s_c_i_s ON s_c_i_s.sale_contract_id=com_inv_masters.sale_contact_id
                            JOIN sale_contracts ON sale_contracts.id=com_inv_masters.sale_contact_id
                            JOIN companies ON companies.id=sale_contracts.company_id
                            JOIN notify_parties on notify_parties.id=sale_contracts.notify_pary_id
                        WHERE (date(com_inv_masters.30_percent_insentive_date)>='$fromDate'
                            and date(com_inv_masters.30_percent_insentive_date)<='$toDate')
                            and notify_parties.region_code='$region'
                        GROUP BY item_groups.item_group_name,bus.name,com_inv_masters.invoice_no
                        order by bus.name ASC)
                        
                        union all
                        
                        (SELECT
                            s_c_i_s.ad_code,
                            companies.code AS exporter_name,
                            CONCAT(bus.name,'-',bus.code) as bu_name,
                            item_groups.item_group_name as Item,
                            com_inv_masters.invoice_no as Invoice,
                            notify_parties.region as region,
                            CONCAT('$',FORMAT(com_inv_masters.invoice_value,2)) as Invoice_Amount,
                            FORMAT(SUM(com_inv_master_details.claim_bdt),2) as total_amout,
                            0 as 30_percent,
                            '' as 30_percent_date,
                            SUM(com_inv_master_details.70_percent_insentive_amount) as 70_percent,
                            date_format(str_to_date(com_inv_masters.70_percent_insentive_date,'%Y-%m-%d'),'%d-%m-%Y') as 70_percent_date,
                            0 as 100_percent,
                            '' as 100_percent_date
                        FROM
                            com_inv_masters
                            JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id = com_inv_masters.id
                            JOIN item_groups ON item_groups.id = com_inv_master_details.item_group_id
                            JOIN bus ON bus.id=com_inv_master_details.bu_id
                            JOIN s_c_i_s ON s_c_i_s.sale_contract_id=com_inv_masters.sale_contact_id
                            JOIN sale_contracts ON sale_contracts.id=com_inv_masters.sale_contact_id
                            JOIN companies ON companies.id=sale_contracts.company_id
                            JOIN notify_parties on notify_parties.id=sale_contracts.notify_pary_id
                        WHERE (date(com_inv_masters.`70_percent_insentive_date`)>='$fromDate'
                              and date(com_inv_masters.`70_percent_insentive_date`)<='$toDate')
                              and notify_parties.region_code='$region'
                        GROUP BY item_groups.item_group_name,bus.name,com_inv_masters.invoice_no
                        order by bus.name ASC)
                        
                        union  all
                        
                        (SELECT
                            s_c_i_s.ad_code,
                            companies.code AS exporter_name,
                            CONCAT(bus.name,'-',bus.code) as bu_name,
                            item_groups.item_group_name as Item,
                            com_inv_masters.invoice_no as Invoice,
                            notify_parties.region as region,
                            CONCAT('$',FORMAT(com_inv_masters.invoice_value,2)) as Invoice_Amount,
                            FORMAT(SUM(com_inv_master_details.claim_bdt),2) as total_amout,
                            0 as 30_percent,
                            '' as 30_percent_date,
                            0 as 70_percent,
                            '' as 70_percent_date,
                            SUM(com_inv_master_details.100_percent_insentive_amount) as 100_percent,
                            date_format(str_to_date(com_inv_masters.100_percent_insentive_date,'%Y-%m-%d'),'%d-%m-%Y') as 100_percent_date
                        FROM
                            com_inv_masters
                            JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id = com_inv_masters.id
                            JOIN item_groups ON item_groups.id = com_inv_master_details.item_group_id
                            JOIN bus ON bus.id=com_inv_master_details.bu_id
                            JOIN s_c_i_s ON s_c_i_s.sale_contract_id=com_inv_masters.sale_contact_id
                            JOIN sale_contracts ON sale_contracts.id=com_inv_masters.sale_contact_id
                            JOIN companies ON companies.id=sale_contracts.company_id
                            JOIN notify_parties on notify_parties.id=sale_contracts.notify_pary_id
                        WHERE (date(com_inv_masters.`100_percent_insentive_date`)>='$fromDate'
                                and date(com_inv_masters.`100_percent_insentive_date`)<='$toDate')
                                and notify_parties.region_code='$region'
                        GROUP BY item_groups.item_group_name,bus.name,com_inv_masters.invoice_no
                        order by bus.name ASC)) as a");

            }else{

                $results=\DB::select("Select a.* from ((SELECT
                        s_c_i_s.ad_code,
                        companies.code AS exporter_name,
                        CONCAT(bus.name,'-',bus.code) as bu_name,
                        item_groups.item_group_name as Item,
                        com_inv_masters.invoice_no as Invoice,
                        notify_parties.region as region,
                        CONCAT('$',FORMAT(com_inv_masters.invoice_value,2)) as Invoice_Amount,
                        FORMAT(SUM(com_inv_master_details.claim_bdt),2) as total_amout,
                        SUM(com_inv_master_details.30_percent_insentive_amount) as 30_percent,
                        com_inv_masters.30_percent_insentive_date as 30_percent_date,
                        0 as 70_percent,
                        '' as 70_percent_date,
                        0 as 100_percent,
                        '' as 100_percent_date
                    FROM
                        com_inv_masters
                        JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id = com_inv_masters.id
                        JOIN item_groups ON item_groups.id = com_inv_master_details.item_group_id
                        JOIN bus ON bus.id=com_inv_master_details.bu_id
                        JOIN s_c_i_s ON s_c_i_s.sale_contract_id=com_inv_masters.sale_contact_id
                        JOIN sale_contracts ON sale_contracts.id=com_inv_masters.sale_contact_id
                        JOIN companies ON companies.id=sale_contracts.company_id
                        JOIN notify_parties on notify_parties.id=sale_contracts.notify_pary_id
                    WHERE (date(com_inv_masters.30_percent_insentive_date)>='$fromDate'
                        and date(com_inv_masters.30_percent_insentive_date)<='$toDate')
                    GROUP BY item_groups.item_group_name,bus.name,com_inv_masters.invoice_no
                    order by bus.name ASC)
                    
                    union all
                    
                    (SELECT
                        s_c_i_s.ad_code,
                        companies.code AS exporter_name,
                        CONCAT(bus.name,'-',bus.code) as bu_name,
                        item_groups.item_group_name as Item,
                        com_inv_masters.invoice_no as Invoice,
                        notify_parties.region as region,
                        CONCAT('$',FORMAT(com_inv_masters.invoice_value,2)) as Invoice_Amount,
                        FORMAT(SUM(com_inv_master_details.claim_bdt),2) as total_amout,
                        0 as 30_percent,
                        '' as 30_percent_date,
                        SUM(com_inv_master_details.70_percent_insentive_amount) as 70_percent,
                        date_format(str_to_date(com_inv_masters.70_percent_insentive_date,'%Y-%m-%d'),'%d-%m-%Y') as 70_percent_date,
                        0 as 100_percent,
                        '' as 100_percent_date
                    FROM
                        com_inv_masters
                        JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id = com_inv_masters.id
                        JOIN item_groups ON item_groups.id = com_inv_master_details.item_group_id
                        JOIN bus ON bus.id=com_inv_master_details.bu_id
                        JOIN s_c_i_s ON s_c_i_s.sale_contract_id=com_inv_masters.sale_contact_id
                        JOIN sale_contracts ON sale_contracts.id=com_inv_masters.sale_contact_id
                        JOIN companies ON companies.id=sale_contracts.company_id
                        JOIN notify_parties on notify_parties.id=sale_contracts.notify_pary_id
                    WHERE (date(com_inv_masters.`70_percent_insentive_date`)>='$fromDate'
                        and date(com_inv_masters.`70_percent_insentive_date`)<='$toDate')
                    GROUP BY item_groups.item_group_name,bus.name,com_inv_masters.invoice_no
                    order by bus.name ASC)
                    
                    union  all
                    
                    (SELECT
                        s_c_i_s.ad_code,
                        companies.code AS exporter_name,
                        CONCAT(bus.name,'-',bus.code) as bu_name,
                        item_groups.item_group_name as Item,
                        com_inv_masters.invoice_no as Invoice,
                        notify_parties.region as region,
                        CONCAT('$',FORMAT(com_inv_masters.invoice_value,2)) as Invoice_Amount,
                        FORMAT(SUM(com_inv_master_details.claim_bdt),2) as total_amout,
                        0 as 30_percent,
                        '' as 30_percent_date,
                        0 as 70_percent,
                        '' as 70_percent_date,
                        SUM(com_inv_master_details.100_percent_insentive_amount) as 100_percent,
                        date_format(str_to_date(com_inv_masters.100_percent_insentive_date,'%Y-%m-%d'),'%d-%m-%Y') as 100_percent_date
                    FROM
                        com_inv_masters
                        JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id = com_inv_masters.id
                        JOIN item_groups ON item_groups.id = com_inv_master_details.item_group_id
                        JOIN bus ON bus.id=com_inv_master_details.bu_id
                        JOIN s_c_i_s ON s_c_i_s.sale_contract_id=com_inv_masters.sale_contact_id
                        JOIN sale_contracts ON sale_contracts.id=com_inv_masters.sale_contact_id
                        JOIN companies ON companies.id=sale_contracts.company_id
                        JOIN notify_parties on notify_parties.id=sale_contracts.notify_pary_id
                    WHERE (date(com_inv_masters.`100_percent_insentive_date`)>='$fromDate'
                            and date(com_inv_masters.`100_percent_insentive_date`)<='$toDate')
                    GROUP BY item_groups.item_group_name,bus.name,com_inv_masters.invoice_no
                    order by bus.name ASC)) as a");  
                 

            }

            

        if(count($results) > 0) {

            $array = array();
            for ($i = 0, $c = count($results); $i < $c; ++$i) {

                $array[$i] = (array) $results[$i];
            }
            return \Excel::create('Insentive_Report', function($excel) use ($array) {

                        $excel->sheet('mySheet', function($sheet) use ($array) {

                            $sheet->fromArray($array);
                        });
                    })->download('xls');
        }else{

            Session::flash("danger", "No Data Available..!");
            return redirect()->back();
        }    


    }


    public function caseInsentiveSummaryReportView(Request $request){

        return view('case_insentive.summary_report_home');

    }


    public function getInvoiceValue($invoice_no,$item_group_id,$bu_id){

        $invoiceResults=\DB::select("SELECT com_inv_master_details.total_amount
                FROM com_inv_masters
                JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id=com_inv_masters.id
                WHERE com_inv_masters.invoice_no='$invoice_no' AND com_inv_master_details.item_group_id='$item_group_id' AND com_inv_master_details.bu_id='$bu_id'");
        foreach($invoiceResults as $key => $value) {
               
             return $value->total_amount;

        }    

    }

    public function getFreightValue($invoice_no,$item_group_id,$bu_id){
         
        $invoiceResults=\DB::select("SELECT com_inv_master_details.total_freight
                FROM com_inv_masters
                JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id=com_inv_masters.id
                WHERE com_inv_masters.invoice_no='$invoice_no' AND com_inv_master_details.item_group_id=$item_group_id AND com_inv_master_details.bu_id=$bu_id");
        foreach($invoiceResults as $key => $value) {
               
             return $value->total_freight;   

        }
 
    }

    public function getNetFobValue($invoice_no,$item_group_id,$bu_id){
         
        $invoiceResults=\DB::select("SELECT com_inv_master_details.total_net_fob
                FROM com_inv_masters
                JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id=com_inv_masters.id
                WHERE com_inv_masters.invoice_no='$invoice_no' AND com_inv_master_details.item_group_id=$item_group_id AND com_inv_master_details.bu_id=$bu_id");
        foreach($invoiceResults as $key => $value) {
               
             return $value->total_net_fob;   

        }

    }

    public function getInsentive($invoice_no,$item_group_id,$bu_id,$percent_id){
         
        switch ($percent_id) {
            
              case 1:
                  return $this->get30PercentBTD($invoice_no,$item_group_id,$bu_id);
                  break;

              case 2:
                  return $this->get70PercentBTD($invoice_no,$item_group_id,$bu_id);
                  break;

              case 3:
                  return $this->get100PercentBTD($invoice_no,$item_group_id,$bu_id);
                  break; 
          }  

    }

    public function get30PercentBTD($invoice_no,$item_group_id,$bu_id){

        $invoiceResults=\DB::select("SELECT com_inv_master_details.30_percent_insentive_amount as parcent1
                FROM com_inv_masters
                JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id=com_inv_masters.id
                JOIN item_groups ON item_groups.id = com_inv_master_details.item_group_id
                WHERE com_inv_masters.invoice_no='$invoice_no' AND com_inv_master_details.item_group_id=$item_group_id AND com_inv_master_details.bu_id=$bu_id 
                AND com_inv_master_details.30_percent_insentive_amount !=''");
        foreach($invoiceResults as $key => $value) {
               
             return $value->parcent1;   

        }

    }    

    public function get70PercentBTD($invoice_no,$item_group_id,$bu_id){

        $invoiceResults=\DB::select("SELECT com_inv_master_details.70_percent_insentive_amount as parcent2
                FROM com_inv_masters
                JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id=com_inv_masters.id
                JOIN item_groups ON item_groups.id = com_inv_master_details.item_group_id
                WHERE com_inv_masters.invoice_no='$invoice_no' AND com_inv_master_details.item_group_id=$item_group_id AND com_inv_master_details.bu_id=$bu_id 
                AND com_inv_master_details.70_percent_insentive_amount !=''");
        foreach($invoiceResults as $key => $value) {
               
             return $value->parcent2;   

        }
    }

    public function get100PercentBTD($invoice_no,$item_group_id,$bu_id){

        $invoiceResults=\DB::select("SELECT com_inv_master_details.100_percent_insentive_amount as parcent3
                FROM com_inv_masters
                JOIN com_inv_master_details ON com_inv_master_details.com_inv_master_id=com_inv_masters.id
                JOIN item_groups ON item_groups.id = com_inv_master_details.item_group_id
                WHERE com_inv_masters.invoice_no='$invoice_no' AND com_inv_master_details.item_group_id=$item_group_id AND com_inv_master_details.bu_id=$bu_id  
                AND com_inv_master_details.100_percent_insentive_amount !=''");
        foreach($invoiceResults as $key => $value) {
               
             return $value->parcent3;   

        }

    }

    public function getAdName($invoice_no){

      $sales_contact_id=SaleContract::where('invoice_no', $invoice_no)->pluck('id');
      if(!empty($sales_contact_id['0'])){

        $ad_code=SCI::where('sale_contract_id', $sales_contact_id['0'])->pluck('ad_code');
        return $ad_code['0'];

      }else{
         
        return ""; 

      }
      

    }

    public function getExpName($invoice_no){
      
      $sales_contact_id=SaleContract::where('invoice_no', $invoice_no)->pluck('id');
      if(!empty($sales_contact_id['0'])){

        $ad_code=SCI::where('sale_contract_id', $sales_contact_id['0'])->pluck('exp_no');
        return $ad_code['0'];

      }else{
         
        return ""; 

      }
        
    }

    public function getCompanyName($invoice_no){

      $company_id=SaleContract::where('invoice_no', $invoice_no)->pluck('company_id');
      if(!empty($company_id['0'])){

        $company=Company::where('id', $company_id)->pluck('code');
        return $company['0'];

      }else{
         
        return ""; 

      } 

    }

    public function jsonEditInvoiceDetails(Request $request){
          
        \DB::beginTransaction();
        try {

           
            for ($i=1; $i < sizeof($request->datastring['0']); $i++) { 
 
                $sci=SCI::findorfail($request->master_id);
                $sale_contract_id=$request->datastring[$i++]['value'];
                $invoiceExistOrNot=SCI::where('sale_contract_id', $sale_contract_id)->get();
                $sci->sale_contract_id=$sale_contract_id;
                $invoice_no=SaleContract::where('id', $sale_contract_id)->pluck('invoice_no');
                $sci->invoice_no=$invoice_no['0'];
                $sci->invoice_date=date("d-m-Y",strtotime($request->datastring[$i++]['value']));
                $sci->ad_code=$request->datastring[$i++]['value'];
                $sci->exp_no=$request->datastring[$i++]['value'];
                $expDate=$request->datastring[$i++]['value'];
                if(!empty($expDate)){

                   $sci->exp_date=date("d-m-Y",strtotime($expDate));

                }else{

                   $sci->exp_date=''; 
                }

                $exp_submit_date=$request->datastring[$i++]['value'];

                if(!empty($exp_submit_date)){
               
                   $sci->exp_submit_date=date("d-m-Y",strtotime($exp_submit_date));

                }else{
                   
                   $sci->exp_submit_date=''; 

                }
                
                $sci->sci_status_id=$request->datastring[$i++]['value'];
                $sci->ci_shadow_file=$request->datastring[$i++]['value'];

                $proceeds_realization_date=$request->datastring[$i++]['value'];

                if(!empty($proceeds_realization_date)){

                    $sci->proceeds_realization_date=date("d-m-Y",strtotime($proceeds_realization_date));

                }else{

                   $sci->proceeds_realization_date=''; 

                }

                $last_date_for_lodging_claim=$request->datastring[$i++]['value'];

                if(!empty($last_date_for_lodging_claim)){

                   $sci->last_date_for_lodging_claim=$last_date_for_lodging_claim;

                }else{

                   $sci->last_date_for_lodging_claim=''; 
                }

                $sci->exp_amount_usd=$request->datastring[$i++]['value'];
                $sci->non_eligible_item_value=$request->datastring[$i++]['value'];
                $sci->no_of_carton_exported=$request->datastring[$i++]['value'];
                $sci->amount_of_proceed_realized=$request->datastring[$i++]['value'];
                $sci->short_realized=$request->datastring[$i++]['value'];
                $prc_issue_date=$request->datastring[$i++]['value'];

                if(!empty($prc_issue_date)){

                    $sci->prc_issue_date=date("d-m-Y",strtotime($prc_issue_date));

                }else{

                    $sci->prc_issue_date=''; 

                }

                $bapa_application_submit_date=$request->datastring[$i++]['value'];
                if(!empty($bapa_application_submit_date)){

                  $sci->bapa_application_submit_date=date("d-m-Y",strtotime($bapa_application_submit_date)); 
                    
                }else{

                  $sci->bapa_application_submit_date='';

                }

                $bapa_certificate_date=$request->datastring[$i++]['value'];

                if(!empty($bapa_certificate_date)){

                  $sci->bapa_certificate_date=date("d-m-Y",strtotime($bapa_certificate_date)); 
                    
                }else{

                  $sci->bapa_certificate_date='';

                }

                $claim_submission_date=$request->datastring[$i++]['value'];

                if(!empty($claim_submission_date)){

                   $sci->claim_submission_date=date("d-m-Y",strtotime($claim_submission_date)); 
                    
                }else{

                   $sci->claim_submission_date='';

                }

                $sci->claim_amount_usd=$request->datastring[$i++]['value'];

                $audit_report_date=$request->datastring[$i++]['value'];

                if(!empty($audit_report_date)){

                   $sci->audit_report_date=date("d-m-Y",strtotime($audit_report_date)); 
                    
                }else{

                   $sci->audit_report_date=''; 
                }

                $sci->auditted_amount=$request->datastring[$i++]['value'];
                $sci->exchange_rate=$request->datastring[$i++]['value'];
                $sci->auditted_amount_tk=$request->datastring[$i++]['value'];
                $sci->shipped_on_board_date=date("d-m-Y",strtotime($request->datastring[$i++]['value']));
                $sci->shipped_on_board_date2=date("d-m-Y",strtotime($request->datastring[$i++]['value']));
                $over_due_date=$request->datastring[$i++]['value'];
                if(!empty($over_due_date)){

                   $sci->over_due=date("d-m-Y",strtotime($over_due_date)); 
                    
                }else{

                   $sci->over_due='';

                }

                $sci->bl_or_challan_no=$request->datastring[$i++]['value'];
                $bl_or_challan_date=$request->datastring[$i++]['value'];

                if(!empty($bl_or_challan_date)){

                   $sci->bl_or_challan_date=date("d-m-Y",strtotime($bl_or_challan_date));  

                }else{

                   $sci->bl_or_challan_date='';

                }

                $sci->discharge_port=$request->datastring[$i++]['value'];
                $sci->see_freight=$request->datastring[$i++]['value'];
                $sci->company_or_exporter_name=$request->datastring[$i++]['value'];
                $sci->country_or_expored_name=$request->datastring[$i++]['value'];
                $sci->shipping_bill_no=$request->datastring[$i++]['value'];
                $shipping_bill_date=$request->datastring[$i++]['value'];
                if(!empty($shipping_bill_date)){

                   $sci->shipping_bill_date=date("d-m-Y",strtotime($shipping_bill_date)); 
                   
                }else{

                   $sci->shipping_bill_date='';

                }
                $sci->insurance=$request->datastring[$i++]['value'];
                $sci->od_sight_rate=$request->datastring[$i++]['value'];
                $false=$request->datastring[$i++]['value'];
                $sci->prc_issue_number=$request->datastring[$i++]['value'];
                $sci->importer_bank=$request->datastring[$i++]['value'];
                $sci->tt_number=$request->datastring[$i++]['value'];
                $sci->tt_date=$request->datastring[$i++]['value'];
                $sci->tt_amount=$request->datastring[$i++]['value'];
                $sci->eligibleItemNetWeight=$request->datastring[$i++]['value'];
                $sci->bank_address=$request->datastring[$i++]['value'];
                $sci->non_eligible_item_name=$request->datastring[$i++]['value'];
                $sci->lc_number=$request->datastring[$i++]['value'];
                $sci->lc_date=$request->datastring[$i++]['value'];
                $sci->lc_value=$request->datastring[$i++]['value'];
                $sci->edit_id=Auth::user()->id;
                $sci->save();
            }

            return "Success";
   
        }catch (Exception $e) {

           DB::rollback(); 
           echo 'Caught exception: ',  $e->getMessage(), "\n";

        } 

    }

    public function downloadMasterBookRecordCurrent(Request $request){

        ini_set('memory_limit', -1); 
        // $form_date = date("Y-m-d", strtotime($request->form_date));
        // $to_date   = date('Y-m-d', strtotime($request->to_date." +1 days"));
        $results = \DB::select("SELECT
                    s_c_i_s.ad_code,
                    s_c_i_s.exp_no,
                    s_c_i_s.exp_date,
                    s_c_i_s.exp_submit_date,
                    sci_statuses.name AS status_type,
                    s_c_i_s.ci_shadow_file,
                    s_c_i_s.last_date_for_lodging_claim,
                    s_c_i_s.invoice_no,
                    s_c_i_s.invoice_date AS Invoice_Date,
                    s_c_i_s.exp_amount_usd,
                    s_c_i_s.non_eligible_item_value,
                    s_c_i_s.no_of_carton_exported,
                    s_c_i_s.proceeds_realization_date,
                    s_c_i_s.amount_of_proceed_realized,
                    s_c_i_s.short_realized,
                    s_c_i_s.prc_issue_date,
                    s_c_i_s.bapa_application_submit_date,
                    s_c_i_s.bapa_certificate_date,
                    s_c_i_s.claim_submission_date,
                    s_c_i_s.claim_amount_usd,
                    s_c_i_s.audit_report_date,
                    s_c_i_s.auditted_amount,
                    s_c_i_s.exchange_rate,
                    s_c_i_s.auditted_amount_tk,
                    s_c_i_s.shipped_on_board_date,
                    s_c_i_s.over_due,
                    s_c_i_s.bl_or_challan_no,
                    s_c_i_s.bl_or_challan_date,
                    s_c_i_s.discharge_port,
                    s_c_i_s.see_freight,
                    s_c_i_s.company_or_exporter_name,
                    s_c_i_s.country_or_expored_name,
                    sale_contracts.sales_contract_no,
                    DATE_FORMAT(sale_contracts.dated,'%d-%m-%Y') AS sale_contact_date,
                    s_c_i_s.shipping_bill_no,
                    s_c_i_s.shipping_bill_date,
                    s_c_i_s.insurance,
                    s_c_i_s.non_eligible_item_name
                FROM s_c_i_s
                JOIN sci_statuses ON s_c_i_s.sci_status_id=sci_statuses.id
                JOIN sale_contracts ON sale_contracts.id=s_c_i_s.sale_contract_id");

        if(count($results) > 0) {

            $array = array();
            for ($i = 0, $c = count($results); $i < $c; ++$i) {

                $array[$i] = (array) $results[$i];
            }
            return \Excel::create('Master_Book', function($excel) use ($array) {

                        $excel->sheet('mySheet', function($sheet) use ($array) {

                            $sheet->fromArray($array);
                        });
                    })->download('xls');
        }else{

            Toastr::error('No Record Available:)', 'Message');
            return redirect('/master/book');
        }     


    }

    public function downloadMasterBookRecord(Request $request){

        $form_date = date("Y-m-d", strtotime($request->form_date));
        $to_date   = date('Y-m-d', strtotime($request->to_date." +1 days"));
        $results = \DB::select("SELECT
                    s_c_i_s.ad_code,
                    s_c_i_s.exp_no,
                    s_c_i_s.exp_date,
                    s_c_i_s.exp_submit_date,
                    sci_statuses.name AS status_type,
                    s_c_i_s.ci_shadow_file,
                    s_c_i_s.last_date_for_lodging_claim,
                    s_c_i_s.invoice_no,
                    s_c_i_s.invoice_date AS Invoice_Date,
                    s_c_i_s.exp_amount_usd,
                    s_c_i_s.non_eligible_item_value,
                    s_c_i_s.no_of_carton_exported,
                    s_c_i_s.proceeds_realization_date,
                    s_c_i_s.amount_of_proceed_realized,
                    s_c_i_s.short_realized,
                    s_c_i_s.prc_issue_date,
                    s_c_i_s.bapa_application_submit_date,
                    s_c_i_s.bapa_certificate_date,
                    s_c_i_s.claim_submission_date,
                    s_c_i_s.claim_amount_usd,
                    s_c_i_s.audit_report_date,
                    s_c_i_s.auditted_amount,
                    s_c_i_s.exchange_rate,
                    s_c_i_s.auditted_amount_tk,
                    s_c_i_s.shipped_on_board_date,
                    s_c_i_s.over_due,
                    s_c_i_s.bl_or_challan_no,
                    s_c_i_s.bl_or_challan_date,
                    s_c_i_s.discharge_port,
                    s_c_i_s.see_freight,
                    s_c_i_s.company_or_exporter_name,
                    s_c_i_s.country_or_expored_name,
                    sale_contracts.sales_contract_no,
                    DATE_FORMAT(sale_contracts.dated,'%d-%m-%Y') AS sale_contact_date,
                    s_c_i_s.shipping_bill_no,
                    s_c_i_s.shipping_bill_date,
                    s_c_i_s.insurance,
                    s_c_i_s.non_eligible_item_name
                FROM s_c_i_s
                JOIN sci_statuses ON s_c_i_s.sci_status_id=sci_statuses.id
                JOIN sale_contracts ON sale_contracts.id=s_c_i_s.sale_contract_id
                WHERE s_c_i_s.created_at >='$form_date' AND s_c_i_s.created_at <='$to_date'");

        if(count($results) > 0) {

            $array = array();
            for ($i = 0, $c = count($results); $i < $c; ++$i) {

                $array[$i] = (array) $results[$i];
            }
            return \Excel::create('Master_Book', function($excel) use ($array) {

                        $excel->sheet('mySheet', function($sheet) use ($array) {

                            $sheet->fromArray($array);
                        });
                    })->download('xls');
        }else{

            Toastr::error('No Record Available:)', 'Message');
            return redirect('/master/book');
        }     


    }


}
