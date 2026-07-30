<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Desk;
use App\Area;
use App\User;
use App\UserArea;
class DeskWiseUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas=Area::all();
        $users=User::where('active',1)->get();
        return view('desk_user.index')
            ->with('areas',$areas)
            ->with('users',$users);
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
        // return $request->all();
        for($i=0; $i< count($request->desk_id); $i++) {
             
            for($j=0; $j< count($request->user_id); $j++) { 
                   
                $userArea=new UserArea();
                if(UserArea::where('user_id',$request->user_id[$j])->where('area_id',$request->desk_id[$i])->count()===0){
                   
                    $userArea->area_id=$request->desk_id[$i];
                    $userArea->user_id=$request->user_id[$j];
                    $userArea->save();

                }
                
            }
           
        }

        return response()->json([
            'message'=>'inserted successfully done',
            'code'=>200
        ]);
    }

    public function deleteDeskUser(Request $request){

        $result=UserArea::where('id',$request->delete_id)->delete();
        if($result) {

            return response()->json([
                'message' => "Data Deleted Successfully!",
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
