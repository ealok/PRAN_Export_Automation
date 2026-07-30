<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\CICvr;
class CIConversionRateController extends Controller
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
        return view('ci_cvr.index');
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

        $ciCvr=new CICvr();
        $ciCvr->rate=$request->rate;
        $ciCvr->save();
        return response()->json([
            'status'=>'success',
            'code'=>200
        ]); 
    }


    public function getCrvEditData(Request $request){
         
        $result=DB::table('ci_cvrs')->where('id',$request->id)->get();
        if($result){

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"    => $result
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"    => []
            ]);

        }        

    }

    public function updateCiCVr(Request $request){
       
        $cvr=CICvr::findorfail($request->editId);
        $cvr->rate=$request->rate;
        $cvr->save();
        return response()->json([
            'status'=>'success',
            'code'=>200
        ]);       
        
    
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

    public function jsonGetListOfCVR(Request $request){
         
        $results = DB::table('ci_cvrs')->get();
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
}
