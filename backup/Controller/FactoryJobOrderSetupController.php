<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\ProductionFloor;
use App\UserProductionFloorSetup;
use Auth;
use DB;
use Session;
class FactoryJobOrderSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        $productionFloors=ProductionFloor::all();
        $results=DB::select("select
                        users.id,
                        users.name AS user_name,
                        users.username AS staff_id,
                        u1.name AS creator_name,
                        u1.username AS creator_staff_id,
                        production_floors.p_code,
                        production_floors.p_name
                    from users
                    join production_floors on production_floors.id=users.location_id
                    JOIN users AS u1 ON u1.id = production_floors.creator_id
                    ORDER BY production_floors.p_code DESC");
        return view('factory_job_order_setup.production_floor_wise_home')
               ->with('users', $users)
               ->with('productionFloors',$productionFloors)
               ->with('results', $results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return 100;
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
        $setUpRow=UserProductionFloorSetup::findorfail($id);
        $users=User::all();
        $productionFloors=ProductionFloor::all();
        return view('factory_job_order_setup.production_floor_wise_edit')
               ->with('setUpRow',$setUpRow)
               ->with('users', $users)
               ->with('productionFloors',$productionFloors);
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
        
        $userProductionFloor=UserProductionFloorSetup::findorfail($id);
        $userProductionFloor->user_id=$request->user_id;
        $userProductionFloor->production_floor_id=$request->p_floor_id;
        $userProductionFloor->creator_id=Auth::user()->id;
        $userProductionFloor->save();
        Session::flash("success", "Update Succcessfully !");
        return redirect('/factory/job_order/setup');

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

    public function saveProductionFloorDetails(Request $request){
        
        $results=User::where('id',$request->user_id)->update([
          
            'location_id'=>$request->p_floor_id

        ]);

        if($results){

            return 'Success'; 

        }else{
             
            

        }


                       

    }
        
}
