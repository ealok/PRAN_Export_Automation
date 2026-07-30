<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\SaleContract;
use App\SaleContractDetail;
use DB;
use App\Desk;
use Session;
class DeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $desks=Desk::where('status',1)
              ->orderBy('id','dsc')->get();
        return view('desk.index')
              ->with('desks',$desks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('desk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $desk=new Desk();
        $desk->name=$request->name;
        $desk->save();
        session::flash("success", "Created Succcessfully !");
        return redirect("/desk"); 

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
        $desk=Desk::findorfail($id);  
        return view('desk.edit')
            ->with('desk',$desk);

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

        $desk=Desk::findorfail($id);
        $desk->name=$request->name;
        $desk->save();
        session::flash("success", "Update Succcessfully !");
        return redirect("/desk");
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $desk=Desk::findorfail($id);
        $desk->status=0;
        $desk->save();
        Session::flash("danger", "Delete Succcessfully !");
        return redirect("/desk");

    }

    public function deskReportHome(Request $request){

       
        if(!empty($request->fromDate) && !empty($request->toDate)){

             $dateFrom = date("Y-m-d",strtotime($request->fromDate));
             $dateTo=date('Y-m-d', strtotime("+1 days", strtotime($request->toDate)));
             
            $results=\DB::select("SELECT
                sale_contracts.sales_contract_no AS sc_no,
                sale_contracts.dated AS sc_date,
                companies.code AS company_name,
                banks.name AS bank_name,
                sale_contracts.export_no,
                sale_contracts.export_date,
                sale_contracts.freight_cost,
                sales_terms.name as sales_term,
                sale_contracts.invoice_no,
                sale_contracts.invoice_date,
                importers.name AS importer_name,
                notify_parties.name AS notify_pary_name,
                users.username AS user_Name,
                sale_contracts.discharge_port,
                sale_contracts.final_destination,
                sale_contracts.bank_for_print_date
            FROM
                sale_contracts
            JOIN companies ON companies.id=sale_contracts.company_id
            JOIN banks ON banks.id=sale_contracts.bank_id
            JOIN sales_terms ON sales_terms.id=sale_contracts.sales_term_id
            JOIN importers ON importers.id=sale_contracts.importer_id
            JOIN notify_parties ON notify_parties.id=sale_contracts.notify_pary_id
            JOIN users ON users.id=sale_contracts.creator_id
            WHERE DATE(sale_contracts.export_date) >= '$dateFrom' AND
             DATE(sale_contracts.export_date) <= 'dateTo'
               AND sale_contracts.export_date !=''");

        }else{

           $results=[];

        }
        
        ///$results=$this->generatePagination($data);          
        return view('desk_report.desk_details_report')
               ->with('results', $results)
               ->with("obj" ,$this);
    }

    private function generatePagination($data){

        $page = Input::get('page', 1);  
        $paginate = 10;    
        $offSet = ($page * $paginate) - $paginate;  
        $parameters = Input::getQueryString();
        $parameters = preg_replace('/&page(=[^&]*)?|^page(=[^&]*)?&?/','', $parameters);
        $path = url('/') . '/desk/report/home?' . $parameters;
        $itemsForCurrentPage = array_slice($data, $offSet, $paginate, true);  
        $results = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($data), $paginate, $page); 
        return $results = $results->withPath($path);
  
    }

    public function getInvoiceAmount($sc_no){

       $sci=SaleContract::where('sales_contract_no', $sc_no)->first(['id']);
       $salesContact=SaleContract::findorfail($sci->id);
       $total_net_weight=\DB::table("sale_contract_details")->where('sale_contract_id',$sci->id)->sum('net_weight_kg');

       if($total_net_weight==0){

         $total_net_weight=1;
       }
       try { 

           $freight_cost=$salesContact->freight_cost;
           $per_unit_freight=$freight_cost/$total_net_weight;
                  
        }catch (Exception $e) { }

        $sale_contract_details=SaleContract::where('sale_contracts.id',$sci->id)
                                ->select('sale_contract_details.ci_item_name','ci_items.p_net_weight','ci_items.ci_factor','ci_items.ci_item_rate','bank_for_print_date','sale_contract_details.rate_per_ctn','importers.address as importer_address','importers.name as importer_name','notify_parties.address as notify_party_address','notify_parties.name as notify_party_name',
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
        $totalAmount=0;
        foreach ($sale_contract_details as $key => $sale_contract_detail) {
            try { 
            
                  if($sale_contract_detail->ci_factor!=0){

                         $per_net_weight_kg_fright=$per_unit_freight*$sale_contract_detail->net_weight_kg;
                         $caton_fright=$per_net_weight_kg_fright/$sale_contract_detail->ctn;
                         $carton_fright_pl_rate=round($caton_fright+$sale_contract_detail->rate_per_ctn, 3);
                        
                  }else{

                    $carton_fright_pl_rate="0";

                  }
                  $totalAmount=$totalAmount+round($carton_fright_pl_rate*$sale_contract_detail->ctn,2);

            }catch (Exception $e) {

            }
        }
        
        return $totalAmount;  


    }

    public function getAccAmount($sc_no){

       $sci=SaleContract::where('sales_contract_no', $sc_no)->first(['id']);
       return $invoiceAmount=SaleContractDetail::where('sale_contract_id',$sci->id)->sum('total_amount_acc'); 
        
    }


}
