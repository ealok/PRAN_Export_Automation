<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\PFP;
use App\ProductionFloor;
use DB;
class PFPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        $p_floors=ProductionFloor::all();
        return view('pfp.index',compact('users'))
               ->with('p_floors',$p_floors);
    }

    public function pfpUserList(Request $request){
        
        $results=DB::select("select
            pfp.id as id,
            CONCAT(users.username,'-',users.name) as user,
            CONCAT(production_floors.p_code,'-',production_floors.short_name) as pfloor,
            case when pfp.status=1 then 'Active'
                    when pfp.status=0 then 'Inactive' end as status
        from pfp
        join users on users.id=pfp.user_id
        join production_floors on production_floors.id=pfp.pfp_id
        where pfp.user_id='$request->user_id'"); 
        
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

    public function activeInactivePfp(Request $request){

        $pfpStats=PFP::where('id',$request->delete_id)->first(['status']);
        $result=PFP::where('id', $request->delete_id)->update([
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
    
        for ($i=0; $i<count($request->p_floor_ids); $i++) {

            if(PFP::where('user_id',$request->user_id)->where('pfp_id',$request->p_floor_ids[$i])->count()==0){
           
                $pfp=new PFP();
                $pfp->user_id=$request->user_id;
                $pfp->pfp_id=$request->p_floor_ids[$i];
                $pfp->save();
            
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
