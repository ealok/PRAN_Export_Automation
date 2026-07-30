<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\NotifyPartyUser;
use App\NotifyParty;
use App\UserArea;
use App\User;
use DB;
class NotifyPartyUserController extends Controller{


    public function __construct(){
       $this->middleware('auth');
    }
    

    public function index(){

        $role_id = Auth::user()->role_id;
        $access_role = [1, 16];
        if (in_array($role_id, $access_role)) {
            $notify_parties = NotifyParty::all();
            $users = User::all();
            return view("notify_party_user.notify_party_user_list", compact("notify_parties"))->with('users', $users);
        } else {
            $userAreas = UserArea::where('user_id', Auth::user()->id)->pluck('area_id');
            $notify_parties = NotifyParty::whereIn('area_id', $userAreas)->get();
            $users = User::all();
            return view("notify_party_user.notify_party_user_list", compact("notify_parties"))->with('users', $users);
        }


    }

    public function create(){
        
        $notify_parties=NotifyParty::all();
        $users=User::all();
        return view("notify_party_user.notify_party_user_create")
             ->with("notify_parties" ,$notify_parties)
             ->with("users" ,$users);
    }


    public function store(Request $request){
           
        foreach($request->party_list as $partyId){

            if(NotifyPartyUser::where('user_id', $request->user_id)->where('notify_party_id', $partyId)->count()==0){

                DB::table('notify_party_users')->insert([
                    'notify_party_id' => $partyId,
                    'user_id' => $request->user_id,
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ]);

            }

        }   
    
        return response()->json([
            'msg'=>'Data inserted successfully',
            'code'=>200
        ]);

    }



    public function edit($id){
        
        $notify_parties=NotifyParty::all();
        $users=User::all();
        $notify_party_user = NotifyPartyUser::find($id); 
        return view("notify_party_user.notify_party_user_edit",compact("notify_party_user"))
             ->with("notify_parties" ,$notify_parties)
             ->with("users" ,$users);;
        
    }


    private function isAlreadyExist($notify_party_id,$user_id){
        $notify_party_user = NotifyPartyUser::where('notify_party_id',$notify_party_id)->where('user_id',$user_id)->first();
        if($notify_party_user){
           return 1;
        }else{
            return 0;
        }

    }

    private function isAlreadyExistEdit($id,$notify_party_id,$user_id){
        $notify_party_user = NotifyPartyUser::where('notify_party_id',$notify_party_id)->where('user_id',$user_id)->where('id','!=',$id)->first();
        if($notify_party_user){
           return 1;
        }else{
            return 0;
        }

    }

    public function update(Request $request, $id) {

        $this->validate($request, [
           "notify_party_id"=>"required|numeric|exists:notify_parties,id",
           "user_id"=>"required|numeric|exists:users,id",


        ]); 

        if($this->isAlreadyExistEdit($id,$request->notify_party_id,$request->user_id)){
            Session::flash("danger", "Already Exist !");
            return redirect()->back();
        }

        $notify_party_user = NotifyPartyUser::find($id);
        $notify_party_user->notify_party_id=$request->notify_party_id;
        $notify_party_user->user_id=$request->user_id;
        $notify_party_user->save();
        Session::flash("success", "Edited Succcessfully !");
        return redirect("/notify_party_user");
    }

    public function show($id){
        $notify_party_user = NotifyPartyUser::find($id); 
        return view("notify_party_user.notify_party_user_show",compact("notify_party_user"));
    }


    public function destroy($id){
        $notify_party_user = NotifyPartyUser::findOrFail($id);
        $notify_party_user ->delete();
        Session::flash("success", "Deleted Succcessfully !");
        return redirect("/notify_party_user");
    }

    public function get_item_of_notify_party(Request $request){
       return  NotifyPartyUser::where('notify_party_id',$request->notify_party_id)->join('users','users.id','notify_party_users.user_id')->select('users.id','users.ci_item_name','users.ci_item_code')->get();
    }

    public function get_item_reate_for_notify_party(Request $request){

        return  NotifyPartyUser::where('notify_party_id',$request->notify_party_id)->where('user_id',$request->user_id)->join('users','users.id','notify_party_users.user_id')->select('users.id','users.ci_item_name','users.hs_code','notify_party_users.cbm_per_ctn','users.ci_item_code','notify_party_users.acc_rate','notify_party_users.party_rate','notify_party_users.desk_item_name')->first();
    }

    public function getPartyUserList(Request $request){

        $results=\DB::select("SELECT
            notify_party_users.id as id,
            CONCAT(notify_parties.code,'-',notify_parties.name) as party,
            CONCAT(users.username,'-',users.name) as user
        FROM notify_party_users
        JOIN notify_parties ON notify_parties.id = notify_party_users.notify_party_id
        JOIN users ON users.id = notify_party_users.user_id
        WHERE users.username = $request->staff_id");

        if($results){

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"    => $results
            ]);

        }else{

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"    => []
            ]);

        }    


    }

    public function deleteNotifyPartyUser(Request $request){
          
        $result=NotifyPartyUser::whereIn('id', $request->item_ids)->delete();
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

}