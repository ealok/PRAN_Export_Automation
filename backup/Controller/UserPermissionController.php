<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
use App\Location;
use App\LocPermissions;
use App\UserQcMaster;
use App\Role;
use App\MenuSetup;
use App\Permission;
use DB;
use Auth;
class UserPermissionController extends Controller
{

    private $permission;
    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware(function ($request, $next) {
          
            $action = Route::getCurrentRoute()->getActionName();
            $menu=MenuSetup::where('menu_controller',class_basename(explode('@', $action)[0]))->first();
            if(!is_null($menu)){
               $this->permission=Permission::where('role_id',Auth::user()->role_id)->where('menu_id',$menu->id)->first();
            }else{
               $this->permission=(object)array('wsmu_vsbl' => 0, 'wsmu_crat' => 0, 'wsmu_read' => 0, 'wsmu_updt' => 0, 'wsmu_delt' => 0); 
            }
            return $next($request);

       });

    }
    public function index()
    {
        $users=User::all();
        $locations=Location::all();
        $role_id=Auth::user()->role_id;
        if($role_id==1){
            
            $roles=Role::all();
            return view('user_permission.index')
                ->with("users" ,$users)
                ->with("locations",$locations)
                ->with("roles",$roles);
        }else{

            $users=User::all();
            $locations=Location::all();
            $skipIds=[1, 3, 4, 13, 15, 16];
            $roles = Role::whereNotIn('id', $skipIds)->get();
            return view('user_permission.index')
                ->with("users" ,$users)
                ->with("locations",$locations)
                ->with("roles",$roles);
        }

    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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


    public function updateUserRole(Request $request){

        $results=User::where('id',$request->user_id)->update([
           'role_id'=>$request->role_id
        ]);

        return response()->json(['code'=>200,'msg'=>'Permission Successfully Done..!!']);
        
    }

    public function updateUserLocation(Request $request){


        $locPermissions=new LocPermissions();
        $locPermissions->loc_id=$request->loc_id;
        $locPermissions->user_id=$request->user_id;
        $locPermissions->save();
        return response()->json(['code'=>200,'msg'=>'Permission Successfully Done..!!']);
        
    }

    public function updateUserQcMaster(Request $request){


        $userQcMaster=new UserQcMaster();
        $userQcMaster->user_id =$request->user_id;
        $userQcMaster->qc_master_id =$request->qc_master_id;
        $userQcMaster->created_by=Auth::user()->id;
        $userQcMaster->save();
        return response()->json(['code'=>200,'msg'=>'Permission Successfully Done..!!']);
        
    }

    public function getUserRole(Request $request){
        
        
        $results = DB::table('users')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->where('users.id', '=', $request->user_id)
            ->select(DB::raw("CONCAT(users.username, '/', users.name) as user"), 'roles.name as role')
            ->get();

        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);

        } else  {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);

        }    


    }

    public function getUserLoc(Request $request){


        $results = DB::table('loc_permissions')
            ->join('users', 'users.id', '=', 'loc_permissions.user_id')
            ->join('locations', 'locations.id', '=', 'loc_permissions.loc_id')
            ->where('users.id', '=', $request->user_id)
            ->select(DB::raw("CONCAT(users.username, '/', users.name) AS user"), 'locations.name as location')
            ->get();

        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);

        } else  {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);

        }     

    }

    public function getUserQcMasterList(Request $request){
      
        $results = DB::table('user_qc_masters')
            ->join('qc_masters', 'qc_masters.id', '=', 'user_qc_masters.qc_master_id')
            ->join('lines', 'lines.id', '=', 'qc_masters.line_id')
            ->join('companies', 'companies.id', '=', 'lines.company_id')
            ->join('locations', 'locations.id', '=', 'lines.location_id')
            ->join('users', 'users.id', '=', 'user_qc_masters.user_id')
            ->where('user_qc_masters.user_id', '=', $request->user_id)
            ->select(
                DB::raw('CONCAT(users.username, "/", users.name) AS user'),
                'qc_masters.name AS qc_master',
                'lines.name AS line',
                'companies.name AS company',
                'locations.name AS location'
            )
            ->get();

        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);

        } else  {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);

        }     

    }

    public function passwordReset(){
     
       return view('user_permission.pwd_reset');  

    }

    public function resetUserPassword(Request $request){

        $user = User::where('username', $request->staff_id)->first();
        if(!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }
        if($user->login_type == 1){
            return response()->json(['success' => false, 'message' => 'Failed, Change Hris Password.!!']);
        } else {
            $user->password = bcrypt($request->newPassword);
            if ($user->save()) {
                return response()->json(['success' => true, 'message' => 'Password reset successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to reset password']);
            }
        }
        
    }

}
