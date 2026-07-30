<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Desk;
use App\Process;
use App\JobOrderMaster;
use App\TaskDefinition;
use App\TemplateMaster;
use App\TemplateDetail;
use App\EventDate;
use DB;
use Auth;
use Session;
class TaskTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $results = DB::select("select t.ID id,t.DESCRIPTION des,p.NAME name
                        from template_master t
                        join process_type p on p.ID=t.TEMPLATE_TYPE");
        return view('task_template.index')->with('results',$results);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users=User::all();
        $process=Process::get(); 
        $taskes=TaskDefinition::orderBy('id','asc')->select(['id','DESCRIPTION'])->get();
        return view('task_template.create')
        ->with('users', $users)
        ->with('process',$process)
        ->with('taskes',$taskes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
       
        $templateMaster=new TemplateMaster();
        $templateMaster->template_type=$request->template_type;
        $templateMaster->description=$request->description;
        $templateMaster->remark=$request->remark;
        $templateMaster->mail=$request->mail=="" ? 'N' : 'Y';
        $templateMaster->iuid=Auth::user()->id;
        $templateMaster->euid=Auth::user()->id;
        $templateMaster->save();

        for($i=0;$i<count($request->matching_info);$i++){
           
            $templateDetail=new TemplateDetail();
            $templateDetail->MASTER_ID=$templateMaster->id;
            $templateDetail->TASK_ID=$request->matching_info[$i]['task_id'];
            $templateDetail->SEQUANCE=$request->matching_info[$i]['sequance'];
            if($request->matching_info[$i]['dependent_task_id']!=""){
                
                $templateDetail->DEPENDENT_TASK_ID=$request->matching_info[$i]['dependent_task_id'];

            }
            if($request->matching_info[$i]['lay_day']!=""){
                 
                $templateDetail->LAY_DAY=$request->matching_info[$i]['lay_day'];

            }
            if($request->matching_info[$i]['standard_day']!=""){

                $templateDetail->STANDARD_DAY=$request->matching_info[$i]['standard_day'];  
            }
            $templateDetail->save();

        }

        return response()->json([

            'status'=>'success'
            
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
         
        
        $templateMaster = DB::select("select t.ID id,t.DESCRIPTION template_name,p.NAME tempalte_type,t.REMARK as remark
                            from template_master t
                            join process_type p on p.ID=t.TEMPLATE_TYPE
                            where t.ID='$id'");

        $template_type="";
        $template_name="";
        $remark="";
        foreach($templateMaster as $value){
              
              $template_type=$value->tempalte_type;
              $template_name=$value->template_name;
              $remark=$value->remark;

        }

        $templateDetails = DB::select("SELECT t2.id as id,
                                        t3.DESCRIPTION as task_name,
                                        case when t4.DESCRIPTION IS NULL  then '' else  t4.DESCRIPTION end dependent_task,
                                        t2.STANDARD_DAY as standard_day,
                                        t2.LAY_DAY as lay_day,
                                        t2.SEQUANCE seq
                                from template_master t1
                                join template_details t2 on t2.MASTER_ID = t1.ID
                                join task_definition t3 on t3.ID=t2.TASK_ID
                                left join task_definition t4 on t4.ID = t2.DEPENDENT_TASK_ID
                                where t2.MASTER_ID='$id'
                                ORDER by t2.SEQUANCE");                   

        
        return response()->json([

           'templateDetails'=>$templateDetails,
           'template_type'=>$template_type,
           'template_name'=>$template_name,
           'remark'=>$remark

        ]);

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
        DB::connection('oracle')->table('TEMPLATE_MASTER')->delete($id);
        Session::flash("danger", "Deleted Succcessfully..!! !");
        return redirect()->back(); 
    }

    public function jsonGetTaskDetails(Request $request,$id){
          
        $task=TaskDefinition::findorfail($id); 
        $users=DB::select("SELECT users.id,users.name,users.username,user_types.name,user_types.id as type_id
                            FROM users
                            LEFT JOIN user_types ON user_types.id=users.type_id
                            WHERE users.head_id=2 or users.type_id IN (2,3,4,5)");
        
        $user_type=DB::select("select * from user_types order by name ASC");

        return response()->json([
             'task_des'=>$task->DESCRIPTION,
             'lag_day'=>$task->LAY_DAYS,
             'standard_day'=>$task->STANDARD_DAYS,
             'default_uid'=>$task->DETAULT_UID,
             'sequance'=>$task->ID,
             'users'=>$users,
             'user_types'=>$user_type,
             'status'=>'Success'
        ]);


    }
}
