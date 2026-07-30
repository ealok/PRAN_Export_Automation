<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\SaleContract;
use App\TruckDetails;
use DB;
class FactoryUserController extends Controller
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

       return view('factory_user.factory_user');

    }

    public function searchSalesContact(Request $request){

            $results =DB::select("SELECT
                        sale_contracts.id,
                        CASE WHEN (sale_contracts.desk_approver_id is null && sale_contracts.approver_id is null) THEN 'Desk Created Only'
                            WHEN (sale_contracts.desk_approver_id is not null && sale_contracts.approver_id is null) THEN 'Desk Posted'
                            WHEN (sale_contracts.desk_approver_id is not null && sale_contracts.approver_id is not null) THEN 'CI Doc Posted'
                            WHEN sale_contracts.inactive='Y' THEN 'Cancel'
                        END as status,
                        sale_contracts.sales_contract_no,
                        date_format(sale_contracts.dated,'%d-%m-%Y') as sales_contract_date,
                        sale_contracts.invoice_no as invoice_no,
                        companies.name as company,
                        banks.name as bank,
                        sale_contracts.final_destination
                    FROM sale_contracts
                        join companies on companies.id=sale_contracts.company_id
                        join banks on banks.id=sale_contracts.bank_id
                    WHERE (sale_contracts.sales_contract_no like '%$request->sales_contract_no%'
                            OR sale_contracts.export_no like '%$request->sales_contract_no%'
                            OR sale_contracts.invoice_no like '%$request->sales_contract_no%')
                    ORDER BY sale_contracts.id desc");

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
                    "data"    =>[]
                ]);
            }           
                      

    }

    public function jsonGetTruckNumber(Request $request){
          
        $saleContract=SaleContract::where('id',$request->sale_contract_id)->first(['truck_numbers','truck_loaded_date']);
        return response()->json([
            'msg' => $saleContract->truck_numbers,
            'date'=> $saleContract->truck_loaded_date,
            "code"    => 200,
        ]);

    }

    public function updateTruckNumbers(Request $request){
      
        $results=DB::table('sale_contracts')
          ->where('id',$request->sales_contact_id)
          ->update([
              'truck_numbers'=>$request->truck_numbers,
              'truck_loaded_date'=>$request->truck_loaded_date
        ]);
        
        return response()->json([
            'message' => "Data Updated Successfully!",
            "code"    => 200,
        ]);

    }

    public function updateTruckDetails(Request $request)
    {
        // DB::beginTransaction();
        // try {
            
            $trucks = [];
            $truckCount = count($request->truck_numbers);
            for ($i = 0; $i < $truckCount; $i++) {
                $trucks[] = [
                    'truck_loaded_date' => date("Y-m-d",strtotime($request->truck_loaded_date)),
                    'sales_contract_id' => $request->sales_contact_id,
                    'truck_number' => $request->truck_numbers[$i],
                    'unit' => $request->unit_count[$i],
                    'net_weight' => $request->net_weight[$i],
                    'gross_weight' => $request->gross_weight[$i]
                ];
            }
            
            // Insert all trucks at once
            TruckDetails::insert($trucks);
            return response()->json([
                'code' => 200,
                'message' => 'Truck details updated successfully'
            ]);
            
        // } catch (\Exception $e) {

        //     return response()->json([
        //         'code' => 500,
        //         'message' => 'Failed to update truck details: ' . $e->getMessage()
        //     ], 500);
        // }
    }


    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


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

    
}
