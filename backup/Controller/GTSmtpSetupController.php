<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\ODP;
use App\Depot;
use App\GTSmtp;
use Auth;
use DB;
class GTSmtpSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::where('type_id',7)->get();
        $categories=DB::select("Select * from categories");
        return view('gt_smtp.index',compact('users'))
               ->with('categories',$categories);
    }

    public function gtSMTPList(Request $request){
        
        $results=DB::select("select
                gt_smtps.id,
                categories.name as category,
                users.name as user,
                case when gt_smtps.status=1 then 'Active'
                when gt_smtps.status=0 then 'Inactive' end as status
            from gt_smtps
            join categories on categories.id=gt_smtps.cat_id
            join users on users.id=gt_smtps.user_id
            where gt_smtps.user_id='$request->user_id'"); 
        
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

    public function activeInactiveGTSmtp(Request $request){
        
        $gtSmtp=GTSmtp::where('id',$request->id)->first(['status']);
        $result=GTSmtp::where('id', $request->id)->update([
            'status' => $gtSmtp->status == 1 ? 0 : ($gtSmtp->status == 0 ? 1 : null),
            'euid' =>Auth::user()->id
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

        for ($i=0; $i<count($request->category_ids); $i++) { 
          
            if(GTSmtp::where('user_id',$request->user_id)->where('cat_id',$request->category_ids[$i])->count()==0){
           
                $gtSmtp=new GTSmtp();
                $gtSmtp->user_id=$request->user_id;
                $gtSmtp->cat_id =$request->category_ids[$i];
                $gtSmtp->iuid =Auth::user()->id;
                $gtSmtp->euid =Auth::user()->id;
                $gtSmtp->save(); 
    
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
