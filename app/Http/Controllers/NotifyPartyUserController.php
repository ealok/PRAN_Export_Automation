<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\NotifyPartyUser;
use App\NotifyParty;
use App\UserArea;
use App\User;
use App\Area;
use DB;
class NotifyPartyUserController extends Controller{


    public function __construct(){
       parent::__construct();
       $this->middleware('auth');
    }
    
    public function index(){

        // if(!$this->hasReadPermission()) {
            
        //     return view('limited_access');
        // }
        $role_id = Auth::user()->role_id;
        $access_role = [1, 16];
        if (in_array($role_id, $access_role)) {
            $notify_parties = NotifyParty::all();
            $users = User::all();
            $regions = Area::whereNotIn('id', [3, 7, 17, 20])->get();
            return view("notify_party_user.notify_party_user_list", compact("notify_parties"))->with('users', $users)->with('regions',$regions);
        } else {
            $userAreas = UserArea::where('user_id', Auth::user()->id)->pluck('area_id');
            $notify_parties = NotifyParty::whereIn('area_id', $userAreas)->get();
            $users = User::all();
            $regions = Area::whereNotIn('id', [3, 7, 17, 20])->get();
            return view("notify_party_user.notify_party_user_list", compact("notify_parties"))->with('users', $users)->with('regions',$regions);
        }

    }

    public function create(){
        
        $notify_parties=NotifyParty::all();
        $users=User::all();
        return view("notify_party_user.notify_party_user_create")
             ->with("notify_parties" ,$notify_parties)
             ->with("users" ,$users);
    }

    public function store(Request $request)
    {
        $userId = $request->user_id;
        $regionId = $request->region_id;
        $countryIds = $request->country_list;  // Array of country IDs
        $partyIds = $request->party_list;      // Array of party IDs
        $successCount = 0;
        $duplicateCount = 0;
        $assigned_by = Auth::user()->id;
        
        // Get user ID from username if needed
        $userDbId = User::where('username', $userId)->value('id');
        
        if (!$userDbId) {
            return response()->json([
                'msg' => "User not found",
                'code' => 404
            ]);
        }
        
        // Loop through each country and each party
        foreach($countryIds as $countryId) {

            foreach($partyIds as $partyId) {
                
                // Check if the combination already exists
                $exists = DB::table('notify_party_users')
                    ->where('user_id', $userDbId)
                    ->where('notify_party_id', $partyId)
                    ->count();
                
                if ($exists == 0) {
                    
                    DB::table('notify_party_users')->insert([
                        'region_id' => $regionId,
                        'country' => $countryId,
                        'notify_party_id' => $partyId,
                        'user_id' => $userDbId,
                        'assign_by' => $assigned_by,
                        'created_at' => date('Y-m-d'),
                        'updated_at' => date('Y-m-d')
                    ]);
                    
                    $successCount++;
                    
                } else {
                    $duplicateCount++;
                }
            }
        }
        
        if ($successCount > 0) {
            return response()->json([
                'msg' => $successCount . " party(s) assigned successfully",
                'duplicate' => $duplicateCount . " duplicate(s) skipped",
                'code' => 200
            ]);
        } else {
            return response()->json([
                'msg' => "All selected parties are already assigned",
                'code' => 409
            ]);
        }

    }


    // public function store(Request $request){

    //     $userId = $request->user_id;
    //     $regionId = $request->region_id;
    //     $partyIds = $request->party_list;
    //     $successCount = 0;
    //     $duplicateCount = 0;
    //     $assigned_by=Auth::user()->id;
    //     foreach($partyIds as $partyId){
            
    //         $exists = DB::table('notify_party_users')
    //             ->where('user_id', $userId)
    //             ->where('notify_party_id', $partyId)
    //             ->where('region_id', $regionId)
    //             ->count();
            
    //         if($exists == 0){
                
    //             DB::table('notify_party_users')->insert([
    //                 'region_id' => $regionId,
    //                 'notify_party_id' => $partyId,
    //                 'user_id' => User::where('username',$userId)->value('id'),
    //                 'assign_by' => $assigned_by,
    //                 'created_at' => date('Y-m-d'),
    //                 'updated_at' => date('Y-m-d')
    //             ]);

    //             $successCount++;
                
    //         } else {

    //             $duplicateCount++;
    //         }

    //     }
        
    //     if($successCount > 0) {

    //         return response()->json([
    //             'msg' => $successCount . " party(s) assigned successfully",
    //             'code' => 200
    //         ]);

    //     } else {

    //         return response()->json([
    //             'msg' => "All selected parties are already assigned",
    //             'code' => 409
    //         ]);
    //     }

    // }

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
            
        $staff_id=User::where('username',$request->staff_id)->value('id');
        $results=\DB::select("SELECT
            notify_party_users.id as id,
            areas.name as region,
            notify_party_users.country,
            CONCAT(notify_parties.code,'-',notify_parties.name) as party,
            CONCAT(users.username,'-',users.name) as user,
            date_format(notify_party_users.created_at,'%d-%m-%Y') as created_at,
            IF(notify_party_users.status=1,'Active','Inactive') as status
        FROM notify_party_users
        JOIN notify_parties ON notify_parties.id = notify_party_users.notify_party_id
        JOIN users ON users.id = notify_party_users.user_id
        JOIN areas on areas.id=notify_party_users.region_id
        WHERE users.id = '$staff_id'");
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

    public function jsonGetRegionWiseCountryList(Request $request){

        $results=\DB::select("SELECT
             distinct notify_parties.country as country
        FROM notify_parties
        WHERE area_id='$request->region_id'");

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
    
    public function jsonGetRegionPartyList(Request $request)
    {
        try {
            $countryIds = $request->country_ids;
            $regionId = $request->region_id;
            
            if(empty($countryIds)) {
                return response()->json([
                    'message' => "Country IDs are required",
                    "code" => 400,
                    "data" => []
                ]);
            }

            // Convert to array if string
            $countryIds = is_string($countryIds) ? explode(',', $countryIds) : $countryIds;
            $countryIds = array_filter($countryIds);
            
            if(empty($countryIds)) {
                return response()->json([
                    'message' => "Valid Country IDs are required",
                    "code" => 400,
                    "data" => []
                ]);
            }

            // Single line query
            $results = \DB::select("SELECT id, code, name, region FROM notify_parties WHERE country IN ('" . implode("','", $countryIds) . "') ORDER BY id");
            return response()->json([
                'message' => !empty($results) ? "Data Found" : "No parties found for selected filters",
                "code" => 200,
                "data" => $results
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "Internal Server Error: " . $e->getMessage(),
                "code" => 500,
                "data" => []
            ]);
        }
    }

    public function activateNotifyPartyUser(Request $request){
        $result=NotifyPartyUser::whereIn('id', $request->item_ids)->update(['status' => 1]);
        if($result) {
            return response()->json([
                'message' => "Data Activated Successfully!",
                "code"    => 200,
            ]);
        } else  {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }

    }

    public function deleteNotifyPartyUser(Request $request){
          
        $result=NotifyPartyUser::whereIn('id', $request->item_ids)->update(['status' => 0]);
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