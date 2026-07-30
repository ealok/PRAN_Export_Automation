<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CVR;
use App\ContainerSize;
use App\ContainerCat;
use App\Location;
use App\CarryingChg;
use App\CostingOtherHead;
use Auth;
use DB;
class CostingOthersHeadSetup extends Controller
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

        $container_sizes=ContainerSize::all();
        $container_cats=ContainerCat::all();
        $locations=Location::select('name','id')->get();
        return view('cost_others_hd.index')
                ->with('locations',$locations)
                ->with('container_cats',$container_cats)
                ->with('container_sizes',$container_sizes);
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
           
        if(costingOtherHead::where('cost_head',$request->cost_head)->count()==0){
           
            $costingOtherHead=new CostingOtherHead();
            $costingOtherHead->cost_head=$request->cost_head;
            $costingOtherHead->charge=$request->charge;
            $costingOtherHead->save();
            return response()->json([
                'status'=>'success',
                'code'=>200
            ]); 

        }else{
              
            return response()->json([
                'status'=>'warning',
                'code'=>409
            ]); 

        }
       

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

    public function getCostingOtherHd(Request $request){
         
     
        $results=DB::select("select * from  costing_others_hd");   
        if($results){

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"    => $results
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"    => []
            ]);

        }        

    }

    public function getCarringChgEditData(Request $request){
         
        $result=DB::table('costing_others_hd')->where('id',$request->id)->get();
        if($result){

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"    =>$result
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);

        }        

    }

    public function updateCostingOtherHd(Request $request){

        $costingOtherHead=CostingOtherHead::findorfail($request->editId);
        $costingOtherHead->cost_head=$request->ecost_head;
        $costingOtherHead->charge=$request->ecarring_charge;
        $costingOtherHead->save();
        return response()->json([
            'status'=>'success',
            'code'=>200
        ]);     
    
    }

    public function getCurrentMonthCVR(Request $request){

        $results = DB::table('cvr_setup')
            ->select('from_date', 'to_date', 'cvr_rate')
            ->whereRaw('CURRENT_DATE() >= from_date')
            ->whereRaw('CURRENT_DATE() <= to_date')
            ->where('status', 'N')
            ->orderByDesc('id')
            ->get();

        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "results"  => $results
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "results" => []
            ]);

        }       

    }

}
