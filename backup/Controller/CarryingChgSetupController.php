<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CVR;
use App\ContainerSize;
use App\ContainerCat;
use App\Location;
use App\CarryingChg;
use Auth;
use DB;
class CarryingChgSetupController extends Controller
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
        return view('carrying_charge.index')
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
           
        if(CarryingChg::where('location_id',$request->location_id)->where('ctr_size_id',$request->ctr_size_id)->where('ctr_cat_id',$request->ctr_cat_id)->count()==0){
           
            $carryingChg=new CarryingChg();
            $carryingChg->location_id=$request->location_id;
            $carryingChg->ctr_size_id=$request->ctr_size_id;
            $carryingChg->ctr_cat_id=$request->ctr_cat_id;
            $carryingChg->carring_charge=$request->carring_charge;
            $carryingChg->depot_expense=$request->depot_expense;
            $carryingChg->save();
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

    public function jsonGetListOfCarringChg(Request $request){
         
     
        $results=DB::select("select
            carrying_chg.id,
                locations.name as location,
                container_size.name as ctr_size,
                container_cat.name as ctr_name,
                carrying_chg.carring_charge as carring_chg,
                carrying_chg.depot_expense As depot_expense
            from carrying_chg
                join locations on locations.id=carrying_chg.location_id
                join container_cat on container_cat.id=carrying_chg.ctr_cat_id
                join container_size on container_size.id=carrying_chg.ctr_size_id
            order by locations.name,container_size.name,carrying_chg.id");   

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
         
        $result=DB::table('carrying_chg')->where('id',$request->id)->get();
        $container_sizes=ContainerSize::all();
        $container_cats=ContainerCat::all();
        $locations=Location::select('name','id')->get();
        if($result){

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "container_sizes" =>$container_sizes,
                "container_cats" =>$container_cats,
                "locations" =>$locations,
                "data"    => $result
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "container_sizes" =>[],
                "container_cats" =>[],
                "locations" =>[],
                "data"    => []
            ]);

        }        

    }

    public function updateCarringCharge(Request $request){

        $carryingChg=CarryingChg::findorfail($request->editId);
        $carryingChg->location_id=$request->elocation_id;
        $carryingChg->ctr_size_id=$request->ectr_size_id;
        $carryingChg->ctr_cat_id=$request->ectr_cat_id;
        $carryingChg->carring_charge=$request->ecarring_charge;
        $carryingChg->depot_expense=$request->edepot_expense;
        $carryingChg->save();
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
