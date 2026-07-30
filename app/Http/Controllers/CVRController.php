<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CVR;
use Auth;
use DB;
class CVRController extends Controller
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
        return view('cvr.index');
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
       

        $cvr=new CVR();
        $cvr->from_date=date('Y-m-d',strtotime($request->form_date));
        $cvr->to_date=date('Y-m-d',strtotime($request->to_date));
        $cvr->cvr_rate=$request->conversion_rate;
        $cvr->status=$request->status;
        $cvr->user_id=Auth::user()->id;
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
         
        $results = DB::table('cvr_setup')
                ->join('users', 'users.id', '=', 'cvr_setup.user_id')
                ->select('cvr_setup.id','cvr_setup.from_date', 'cvr_setup.to_date', 'cvr_setup.cvr_rate', DB::raw("CASE WHEN cvr_setup.status='N' THEN 'Active' WHEN cvr_setup.status='Y' THEN 'Inactive' END AS status"))
                ->get();

        
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

    public function getCrvEditData(Request $request){
         
        $result=DB::table('cvr_setup')->where('id',$request->id)->get();
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

    public function cvrUpdate(Request $request){
       
        $cvr=CVR::findorfail($request->editId);
        $cvr->from_date=date('Y-m-d',strtotime($request->from_date));
        $cvr->to_date=date('Y-m-d',strtotime($request->to_date));
        $cvr->cvr_rate=$request->cvr_rate;
        $cvr->status=$request->status;
        $cvr->user_id=Auth::user()->id;
        $cvr->save();
        return response()->json([
            'status'=>'success',
            'code'=>200
        ]);     
        
    
    }


}
