<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\PFP;
use App\ProductionFloor;
use App\JobOrderMaster;
use App\LandPortDashboard;
use App\seaPortdashboard;
use App\SaleContract;
use Mail;
class TradingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'
                    and notify_parties.status=1");
        $pf_ids=PFP::where('user_id', Auth::user()->id)->pluck('pfp_id')->toArray();
        $pfs=ProductionFloor::whereIn('id',$pf_ids)->get();
        return view('trading.index',compact('notifyParties'))
                ->with('pfs',$pfs);
    }

    public function getTradingJoList(Request $request){
          
        $results=DB::select("select
                    job_order_masters.id,
                    CONCAT(notify_parties.code, '-', notify_parties.name)          as party,
                    job_order_masters.job_order_number                             as jo_no,
                    date_format(job_order_masters.created_at, '%d-%m-%Y')          as jo_date,
                    job_order_masters.delivery_date                                as delivery_date,
                    sum(job_order_details.orqt)                                    as order_qty,
                    ROUND(SUM(job_order_details.orqt*job_order_details.rate),6)    as `values`, 
                    concat(users.username, '-', users.name)                        as user,
                    CASE when job_order_masters.jo_receive_status='Y' then 'Y' ELSE 'N' END as status
                from job_order_masters
                    join job_order_details on job_order_details.master_id = job_order_masters.id
                    join production_floors on production_floors.id = job_order_masters.p_floor_id
                    join notify_parties on notify_parties.id = job_order_masters.importer_id
                    join users on users.id = job_order_masters.user_id
                where notify_parties.id='$request->party_id' 
                      and production_floors.id='$request->pf_id' 
                      and job_order_masters.status!=3
                      and job_order_details.item_status!='N'
                group by job_order_masters.id, notify_parties.code, notify_parties.name,
                    job_order_masters.job_order_number,
                    job_order_masters.created_at,job_order_masters.delivery_date,users.username, users.name,job_order_masters.jo_receive_status");

        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);
        }

    }

    public function getTradingDetails(Request $request,$id){
        
        $results=DB::select("select
            ci_items.ci_item_code as code,
            ci_items.ci_item_name as item,
            job_order_details.orqt,
            job_order_details.smqt,
            ROUND(job_order_details.rate,6) as rate,
            ROUND(SUM(job_order_details.rate*job_order_details.orqt),6) as value,
            dunits.dunit_name as dunit,
            runits.runit_name as runit
        from job_order_masters
            join job_order_details on job_order_details.master_id = job_order_masters.id
            join ci_items on ci_items.id=job_order_details.item_id
            join dunits on dunits.id=job_order_details.du_unit
            join runits on runits.id=job_order_details.ru_unit
        where job_order_masters.id='$id'
        group by ci_items.ci_item_code,ci_items.ci_item_name,job_order_details.orqt,
        job_order_details.smqt,dunits.dunit_name,runits.runit_name,job_order_details.rate,job_order_details.orqt");

        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);
        }

    }

    public function tradingRcvJo(Request $request){
        
        $joOrderMaster=JobOrderMaster::where('id',$request->jo_id)->first(['sale_contract_id']);
        $job_id=$request->jo_id;
        $sale_contact_id=$joOrderMaster->sale_contract_id;
        $date=date('Y-m-d');
        $user_id=Auth::user()->id;
        JobOrderMaster::where('id', $job_id)
                ->update([
                    'jo_receive_status' => 'Y',
                    'jo_receive_date' => $date,
                    'jo_receive_by' =>$user_id
                  ]);

        LandPortDashboard::where('sc_id',$sale_contact_id)->where('Task_ID',2)->update([
        'action_date'=>date('Y-m-d')
        ]);
    
        seaPortdashboard::where('sc_id',$sale_contact_id)->where('Task_ID',2)->update([
        'action_date'=>date('Y-m-d')
        ]);


        // $user=\DB::table('users')->where('id', Auth::user()->id)->first(['email','name','head_id']);
        // $jo_master=JobOrderMaster::where('id', $job_id)->first(['job_order_number','sale_contract_id','delivery_date']);
        // $sale_contract=SaleContract::where('id', $jo_master->sale_contract_id)->first(['invoice_no']);
        // $trading_user_mail=array('mis94@mis.prangroup.com');

        // $data = array(
        //     'job_order_number'=>$jo_master->job_order_number,
        //     'name'=>$user->name,
        //     'from_email'=>$user->email,
        //     'sale_contract'=>$sale_contract->invoice_no,
        //     'delivery_date'=>$jo_master->delivery_date,
        //     'to_emails'=>$trading_user_mail,
        //     'subject'=>"Trading Order Received"
        // );
          
        // Mail::send('trading_jo_receive_mail', $data, function($message) use ($data){
        //     $message->from($data['from_email']);
        //     $message->to($data['to_emails']);
        //     $message->subject($data['subject']);
        // });   


        return response()->json([
            'message' => "Receive Successfully Done!",
            "code"    => 200,
        ]);       

    }

    public function jsonDownloadTradingJoDetails(Request $request){
        
        $jobOrderMaster=JobOrderMaster::where('id', $request->jo_id)->first(['created_at']);
        $create_date=date("d-m-Y", strtotime($jobOrderMaster->created_at));
        $results=DB::select("select
            ci_items.ci_item_code as Code,
            ci_items.ci_item_name as Item,
            job_order_details.orqt as Order_Qty,
            job_order_details.smqt as Smpl_Qty,
            ROUND(job_order_details.rate,6) as Rate,
            ROUND(SUM(job_order_details.rate*job_order_details.orqt),6) as `Value(USD)`,
            dunits.dunit_name as Dunit,
            runits.runit_name as Runit
        from job_order_masters
            join job_order_details on job_order_details.master_id = job_order_masters.id
            join ci_items on ci_items.id=job_order_details.item_id
            join dunits on dunits.id=job_order_details.du_unit
            join runits on runits.id=job_order_details.ru_unit
        where job_order_masters.id='$request->jo_id'
        group by ci_items.ci_item_code,ci_items.ci_item_name,job_order_details.orqt,
        job_order_details.smqt,dunits.dunit_name,runits.runit_name,job_order_details.rate,job_order_details.orqt");

        if(count($results) > 0) {

            $array = array();
            for ($i = 0, $c = count($results); $i < $c; ++$i) {

                $array[$i] = (array) $results[$i];
            }
            return \Excel::create('Trading_Report-'.$create_date, function($excel) use ($array) {

                        $excel->sheet('mySheet', function($sheet) use ($array) {

                            $sheet->fromArray($array);
                        });
                    })->download('xls');
                    
        }else{

            Session::flash("danger", "No Data Available..!");
            return redirect()->back();
        } 
       


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
