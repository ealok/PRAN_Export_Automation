<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Desk;
use App\Process;
use App\JobOrderMaster;
use App\TaskDefinition;
use App\EventDate;
use App\Role;
use DB;
use Auth;
use Session;
class TaskDefinitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        
        $results = DB::table('task_definition as t')
        ->select(
            't.id as id',
            't.DESCRIPTION as des',
            't.STANDARD_DAYS as std',
            'u2.NAME as user_type'
        )
        ->selectRaw("CASE WHEN t.ACTION_TYPE = 0 THEN 'Single' ELSE 'Multiple' END AS Action_Type")
        ->selectRaw("CASE WHEN t.SHOW_STATUS = 'Y' THEN 'Active' WHEN t.SHOW_STATUS = 'N' THEN 'Inactive' END AS status")
        ->leftJoin('user_types as u2', 'u2.ID', '=', 't.USER_TYPE')
        ->where('t.SHOW_STATUS', '=', 'Y')
        ->get();
                 
        return view('task_definition.index')
             ->with('results',$results);
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users=User::all();
        $desks=Desk::all();
        $process=Process::all();
        $current_date=date('Y-m-d'); 
        $previous_date=date('Y-m-d', strtotime('-3 month'));
        $event_types=EventDate::all();   
        $user_types=Role::all();
        return view('task_definition.create')
        ->with('users', $users)
        ->with('user_types',$user_types)
        ->with('desks',$desks)
        ->with('process',$process)
        ->with('event_types',$event_types);
             
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     
            
        $taskDefinition=new TaskDefinition();
        $taskDefinition->DESCRIPTION=$request->description;
        $taskDefinition->USER_TYPE=$request->user_type;
        $taskDefinition->STANDARD_DAYS=$request->standard_day ? $request->standard_day : 0;
        $taskDefinition->EVENT_TYPE_ID=$request->event_type_id ? $request->event_type_id : 0;
        $taskDefinition->CANCEL_STATUS=$request->cancel_status;
        $taskDefinition->MAIL_SEND=$request->mail_send;
        $taskDefinition->SHOW_STATUS='Y';
        $taskDefinition->ACTION_TYPE=$request->action_type;
        $taskDefinition->CANCEL_STATUS=1;
        $taskDefinition->DESK_UID=0;
        $taskDefinition->PROCESS_ID=0;
        $taskDefinition->DESK_HEAD_UID=0;
        $taskDefinition->RELATED_TO=0;
        $taskDefinition->LAG_DAYS=0;
        $taskDefinition->CAL_TYPE=0;
        $taskDefinition->IUID=Auth::user()->id;
        $taskDefinition->EUID=Auth::user()->id;
        $result=$taskDefinition->save();
        if($result) {
            return response()->json([
                'message' => "Task Created Successfully",
                "code"    => 200
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
         
        $users=User::all();
        $desks=Desk::all();
        $process=Process::all();
        $current_date=date('Y-m-d'); 
        $previous_date=date('Y-m-d', strtotime('-3 month'));
        $event_types=EventDate::all();
        $taskDefinition=TaskDefinition::findorfail($id);
        $user_types=Role::all();        
        return view('task_definition.edit')
        ->with('users', $users)
        ->with('desks',$desks)
        ->with('process',$process)
        ->with('event_types',$event_types)
        ->with('taskDefinition',$taskDefinition)
        ->with('edit_id',$id)
        ->with('user_types',$user_types);
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

        
        
    }

    public function updateTaskDefinition(Request $request){

        $result=DB::table('task_definition')  
           ->where('id', $request->edit_id)
           ->update(
                array(
                   'DESCRIPTION' => $request->description,
                   'USER_TYPE'=>$request->default_uid,
                   'STANDARD_DAYS' => $request->standard_day ? $request->standard_day : 0,
                   'EVENT_TYPE_ID' => $request->event_type_id ? $request->event_type_id : NULL,
                   'ACTION_TYPE' => $request->action_type,
                   'MAIL_SEND' => $request->mail_send,
                //    'BOARD_STATUS' => $request->board_status, 
                   'EUID' => Auth::user()->id,
                   )
                );

        return response()->json([
            'message' => "Task Updated Successfully!",
            "code"    => 200,
        ]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        //DB::connection('oracle')->table('TASK_DEFINITION')->delete($id);
        TaskDefinition::where('id', $id)->update([
           'STATUS'=>'N'
        ]);
        Session::flash("danger", "Deleted Succcessfully..!! !");
        return redirect()->back(); 
    }
}
