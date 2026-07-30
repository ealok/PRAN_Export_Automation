<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Desk;
use App\Process;
use App\JobOrderMaster;
use App\TaskDefinition;
use App\EventDate;
use App\UserType;
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
    
        $results = DB::select("select  
                    t.id as id,
                    t.DESCRIPTION des,
                    t.STANDARD_DAYS as std,
                    u1.NAME milestone_user,
                    u2.NAME as user_type,
                    case when t.SHOW_STATUS='Y' then 'Active' 
                when t.SHOW_STATUS='N' then 'Inactive' end as status
                from task_definition t
                left join users u1 on u1.ID=t.DESK_HEAD_UID
                left join user_types u2 on u2.ID=t.USER_TYPE
                where t.SHOW_STATUS='Y'");
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
        $user_types=UserType::all();
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
            $taskDefinition->DESK_UID=$request->desk_uid;
            $taskDefinition->PROCESS_ID=$request->process_id;
            $taskDefinition->USER_TYPE=$request->user_type;
            $taskDefinition->DESK_HEAD_UID=$request->desk_head_id;
            $taskDefinition->RELATED_TO=$request->related_to ? $request->related_to : 0;
            $taskDefinition->TCLASS_ID=$request->tclass_id;
            $taskDefinition->MAIL_SEND=$request->mail_send;
            $taskDefinition->STANDARD_DAYS=$request->standard_day ? $request->standard_day : 0;
            $taskDefinition->LAG_DAYS=$request->lag_day ? $request->lag_day : 0;
            $taskDefinition->CAL_TYPE=$request->cal_type;
            $taskDefinition->DESCRIPTION=$request->description;
            $taskDefinition->EVENT_TYPE_ID=$request->event_type_id;
            $taskDefinition->IUID=Auth::user()->id;
            $taskDefinition->EUID=Auth::user()->id;
            $taskDefinition->save();
            if($taskDefinition->id){
               
                return response()->json([
                    
                   'status'=>'Success' 

                ]);

            }else{

                return response()->json([
                    
                    'status'=>'Fail' 
 
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
        $user_types=UserType::all();        
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
                   'DESK_UID' => $request->desk_uid,
                   'PROCESS_ID' => $request->process_id,
                   'DESK_HEAD_UID' => $request->desk_head_id,
                   'RELATED_TO' => $request->related_to,
                   'TCLASS_ID' => $request->tclass_id,
                   'MAIL_SEND' => $request->mail_send,
                   'STANDARD_DAYS' => $request->standard_day ? $request->standard_day : 0,
                   'LAG_DAYS' => $request->lag_day ? $request->lag_day : 0,
                   'CAL_TYPE' => $request->cal_type,
                   'DESCRIPTION' => $request->description,
                   'EVENT_TYPE_ID' => $request->event_type_id,
                   'EUID' => Auth::user()->id,
                   'USER_TYPE'=>$request->default_uid
                   )
                );

        if($result){
           
            return response()->json([

                'status'=>'Success'

            ],200);

        }else{
             
            return response()->json([
                    
                'status'=>'Fail' 

            ]);

        }  


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
