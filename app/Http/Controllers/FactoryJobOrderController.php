<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\UserProductionFloorSetup;
use Auth;
class FactoryJobOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user_id=Auth::user()->id;
        $prod_floor_id=UserProductionFloorSetup::where('user_id', $user_id)->pluck('production_floor_id')->first();
        $jobOrderMasters=\DB::select("SELECT
                job_order_masters.id,
                job_order_masters.job_order_number,
                notify_parties.code,
                notify_parties.address,
                sale_contracts.sales_contract_no,
                sale_contracts.invoice_no,
                job_order_masters.issue_date,
                job_order_masters.status,
                notify_parties.name,
                job_order_masters.job_order_do_number,
                depots.d_code,
                depots.d_name,
                production_floors.p_code,
                production_floors.p_name
            FROM
                job_order_masters
            JOIN notify_parties ON job_order_masters.importer_id = notify_parties.id
            JOIN sale_contracts ON sale_contracts.id = job_order_masters.sale_contract_id
            LEFT JOIN depots ON depots.d_code = job_order_masters.wh_id
            JOIN production_floors ON production_floors.id = job_order_masters.p_floor_id
            WHERE
                job_order_masters.p_floor_id='$prod_floor_id'"); 
       return view('factory_job_order.job_order_list')->with('jobOrderMasters',$jobOrderMasters); 

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
}
