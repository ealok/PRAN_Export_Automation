<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CVR;
use App\ContainerSize;
use App\Location;
use App\CarryingChg;
use App\ContainerCat;
use Auth;
use DB;
class DepotChargeController extends Controller
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
        return view('deport_charge.index')
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

        if(ContainerSize::where('name',$request->ctr_size)->count()==0){
           
            $carryingChg=new ContainerSize();
            $carryingChg->name=$request->ctr_size;
            $carryingChg->charge=$request->charge;
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

    public function jsonGetListOfDepotChg(Request $request){
         
        $results=DB::select("SELECT * FROM container_size");   
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

    public function getDepotChgEditData(Request $request){
         
        $result=DB::table('container_size')->where('id',$request->id)->get();
        if($result){

            return response()->json([
                'message' => "Data Found",
                "data"    => $result,
                "code"    => 200
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "data"    => [],
                "code"    => 500
            ]);

        }        

    }

    public function updateDepotCharge(Request $request){
      
        $carryingChg=ContainerSize::findorfail($request->editId);
        $carryingChg->name=$request->ectr_size;
        $carryingChg->charge=$request->echarge;
        $carryingChg->save();
        $carryingChg->save();
        return response()->json([
            'status'=>'success',
            'code'=>200
        ]);     
    
    }

    
}
