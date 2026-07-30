<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\ODP;
use DB;
class ODPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        $depots=DB::select("select * from depots");
        return view('odp.index',compact('users'))
               ->with('depots',$depots);
    }

    public function odpUserList(Request $request){
        
        $results=DB::select("select
                    odp.id as id,
                    CONCAT(users.username,'-',users.name) as user,
                    CONCAT(depots.d_code,'-',depots.d_name) as pfloor,
                    case when odp.status=1 then 'Active'
                    when odp.status=0 then 'Inactive' end as status
            from odp
                join users on users.id=odp.user_id
                join depots on depots.id=odp.odp_id
            where odp.user_id='$request->user_id'"); 
        
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

    public function activeInactiveOdp(Request $request){

        $pfpStats=ODP::where('id',$request->delete_id)->first(['status']);
        $result=ODP::where('id', $request->delete_id)->update([
            'status' => $pfpStats->status == 1 ? 0 : ($pfpStats->status == 0 ? 1 : null)
        ]);

        if($result) {
            return response()->json([
                'message' => "Successfully Done..!",
                "code"    => 200,
            ]);
        } else  {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
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
        
        for ($i=0; $i<count($request->depo_ids); $i++) { 
          
            if(ODP::where('user_id',$request->user_id)->where('odp_id',$request->depo_ids[$i])->count()==0){
           
                $odp=new ODP();
                $odp->user_id=$request->user_id;
                $odp->odp_id=$request->depo_ids[$i];
                $odp->save(); 
    
            }
              

        }

        return response()->json([

            'message' => "Successfully Done..!!",
            "code"    => 200
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
}
