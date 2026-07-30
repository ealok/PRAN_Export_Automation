<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\DeskSetup;
use Session;
use App\Desk;
use App\User;
class DeskSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $setup_users=DB::select("Select t1.ID as id,
                    CONCAT(t2.username,'-',t2.NAME) as desk_head,
                    t3.NAME as desk_name
                from desk_setup t1
                join users t2 on t2.ID = t1.DESK_HEAD_ID
                join desk t3 on t3.ID = t1.ID 
                where t3.status=1
                order by t1.ID desc");
        return view('desk_setup.index')
            ->with('setup_users',$setup_users);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
         
        $desks=Desk::all();
        $deskHeads=User::where('type_id',6)->get();
        return view('desk_setup.create')
            ->with('desks',$desks)
            ->with('deskHeads',$deskHeads);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $existOrNot=DeskSetup::where('DESK_HEAD_ID',$request->desk_head_id)
                   ->where('DESK_ID',$request->desk_id)
                   ->first();

        if(is_null($existOrNot)){
            
            $deskSetup=new DeskSetup();
            $deskSetup->DESK_ID=$request->desk_id;
            $deskSetup->DESK_HEAD_ID=$request->desk_head_id;
            $deskSetup->save();
            session::flash("success", "Created Succcessfully !");
            return redirect("/desk_setup");   
 
        }else{

            session::flash("danger", "Already Exist..!!");
            return redirect("/desk_setup");   

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
        $deskSetup=DeskSetup::findorfail($id);
        $desks=Desk::get();
        $deskHeads=User::where('type_id',6)->get();
        return view('desk_setup.edit')
             ->with('deskSetup',$deskSetup)
             ->with('desks',$desks)
             ->with('deskHeads',$deskHeads);
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
        
        $deskSetup=DeskSetup::findorfail($id);
        $deskSetup->DESK_ID=$request->desk_id;
        $deskSetup->DESK_HEAD_ID=$request->desk_head_id;
        $deskSetup->save();
        session::flash("success", "Update Succcessfully !");
        return redirect("/desk_setup"); 

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
