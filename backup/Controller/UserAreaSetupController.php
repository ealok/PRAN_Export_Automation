<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\UserArea;
use App\User;
use App\Area;
use Session;
use DB;
class UserAreaSetupController extends Controller
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
        $results=\DB::select('select * from users where type_id=1 and active=1');
        $arrayObj=(array)$results[0];
        $results=UserArea::orderBy('id','desc')->get();
        return view('user_area.index',compact('results'));

    }

    public function getDeskUserList(Request $request){

        $results=DB::select("SELECT
                        user_areas.id AS id,
                        CONCAT(users.username,'-',users.name) AS user,
                        areas.name AS desk,
                        CASE WHEN user_areas.status = 1 THEN 'Active' WHEN user_areas.status = 0 THEN 'Inactive' END AS status
                FROM user_areas
                    JOIN users ON users.id = user_areas.user_id
                    JOIN areas on areas.id=user_areas.area_id
                where user_areas.user_id='$request->user_id'");

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $users=User::all(); 
        $areas=Area::all();
        return view('user_area.create',compact('users'))
              ->with('areas',$areas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        
          
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
        $users=User::all(); 
        $areas=Area::all();
        $userArea=UserArea::findorfail($id);
        return view('user_area.show',compact('users'))
              ->with('areas',$areas)
              ->with('userArea',$userArea);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $users=User::all(); 
        $areas=Area::all();
        $userArea=UserArea::findorfail($id);
        return view('user_area.edit',compact('users'))
              ->with('areas',$areas)
              ->with('userArea',$userArea);
        
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

        $userArea=UserArea::findorfail($id);
        $userArea->user_id=$request->user_id;
        $userArea->area_id=$request->area_id;
        $userArea->save();
        Session::flash("success", "Updated Succcessfully !");
        return redirect("/user_area");
       
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userArea=UserArea::findorfail($id);
        $userArea->delete();
        Session::flash("danger", "Deleted Succcessfully !");
        return redirect("/user_area");
        
    }
}
