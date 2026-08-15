<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Location;
use App\LocPermissions;
use App\UserQcMaster;
use App\Role;
use App\MenuSetup;
use App\Permission;
use App\UserPermission;
use App\UserRole;
use DB;
use Auth;
class UserPermissionController extends Controller
{

    //private $permission;
    public function __construct()
    {
       parent::__construct(); 
       $this->middleware('auth');
    
    }
    public function index()
    {
        // if(!$this->hasViewPermission()) {
            
        //     return view('limited_access');
        // }
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

    public function updateUserRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg' => $validator->errors()->first()
            ], 400);
        }
        
        try {

            $exists = UserRole::where('user_id', $request->user_id)
                ->where('role_id', $request->role_id)
                ->where('is_active', 1)
                ->exists();
            
            if($exists) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Role already assigned to this user.'
                ], 400);
            }
            
            $userRole = UserRole::create([
                'user_id' => $request->user_id,
                'role_id' => $request->role_id,
                'assigned_by' => auth()->id(),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            return response()->json([
                'status' => 'success',
                'msg' => 'Role assigned successfully.',
                'data' => [
                    'user_role_id' => $userRole->id,
                    'user_id' => $userRole->user_id,
                    'role_id' => $userRole->role_id
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to assign role: ' . $e->getMessage()
            ], 500);
        }
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
        
        $results = DB::table('user_roles')
                ->join('users', 'users.id', '=', 'user_roles.user_id')
                ->join('roles', 'roles.id', '=', 'user_roles.role_id')
                ->where('user_roles.user_id', '=', $request->user_id)
                ->where('user_roles.is_active', '=', 1)
                ->select(
                    'user_roles.id as user_role_id',
                    DB::raw("CONCAT(users.username, '/', users.name) as user"),
                    'roles.name as role_name'
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

    public function getUserPermissions(Request $request){
        
        $userId = $request->user_id;
        $user = User::find($userId);
        if(!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $userRoles = UserRole::where('user_id', $userId)->where('is_active', 1)->pluck('role_id')->toArray();
        $menus = MenuSetup::where('status', 1)->orderBy('id', 'asc')->get();
        $rolePermissions = Permission::whereIn('role_id', $userRoles)->get()->keyBy('menu_id');
        $userPermissions = UserPermission::where('user_id', $userId)->get()->keyBy('menu_id');
        $menuData = [];
        foreach($menus as $menu){
            
            $rolePerm = $rolePermissions->get($menu->id);
            $userPerm = $userPermissions->get($menu->id);
            $defaultVsbl = !empty($rolePerm->wsmu_vsbl) ? '1' : '0';
            $defaultCrat = !empty($rolePerm->wsmu_crat) ? '1' : '0';
            $defaultRead = !empty($rolePerm->wsmu_read) ? '1' : '0';
            $defaultUpdt = !empty($rolePerm->wsmu_updt) ? '1' : '0';
            $defaultDelt = !empty($rolePerm->wsmu_delt) ? '1' : '0';
            $menuData[] = [
                'menu_id' => $menu->id,
                'menu_name' => $menu->menu_name,
                'menu_url' => $menu->menu_url,
                'menu_icon' => $menu->menu_icon,
                // Role defaults
                'wsmu_vsbl' => $defaultVsbl,
                'wsmu_crat' => $defaultCrat,
                'wsmu_read' => $defaultRead,
                'wsmu_updt' => $defaultUpdt,
                'wsmu_delt' => $defaultDelt,
                // Custom overrides
                'has_custom' =>  $userPerm ? true : false,
                'custom_vsbl' => $userPerm ? $userPerm->wsmu_vsbl : null,
                'custom_crat' => $userPerm ? $userPerm->wsmu_crat : null,
                'custom_read' => $userPerm ? $userPerm->wsmu_read : null,
                'custom_updt' => $userPerm ? $userPerm->wsmu_updt : null,
                'custom_delt' => $userPerm ? $userPerm->wsmu_delt : null,
            ];
        }        

        return response()->json([
            'user_id' => $userId,
            'user_name' => $user->name,
            'user_username' => $user->username,
            'menus' => $menuData
        ]);
        
    }

    public function resetUserPermissions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg' => $validator->errors()->first()
            ], 400);
        }
        
        try {
            $deleted = UserPermission::where('user_id', $request->user_id)->delete();
            return response()->json([
                'status' => 'success',
                'msg' => 'Permissions reset to role defaults successfully. ' . $deleted . ' custom permissions removed.',
                'deleted_count' => $deleted
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to reset permissions: ' . $e->getMessage()
            ], 500);
        }
    }
    public function saveUserPermissions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'permissions' => 'required|array'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg' => $validator->errors()->first()
            ], 400);
        }
        
        $userId = $request->user_id;
        $permissions = $request->permissions;
        
        DB::beginTransaction();
        
        try {
            $userRoles = UserRole::where('user_id', $userId)
                ->where('is_active', 1)
                ->pluck('role_id')
                ->toArray();
            
            if (empty($userRoles)) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'User has no role assigned. Please assign a role first.'
                ], 400);
            }
            
            $savedCount = 0;
            $deletedCount = 0;
            $debugData = [];
            
            foreach ($permissions as $perm) {
                $menuId = $perm['menu_id'];
                
                $rolePerm = Permission::whereIn('role_id', $userRoles)
                    ->where('menu_id', $menuId)
                    ->first();
                
                $defaultVsbl = $rolePerm ? $rolePerm->wsmu_vsbl : '0';
                $defaultCrat = $rolePerm ? $rolePerm->wsmu_crat : '0';
                $defaultRead = $rolePerm ? $rolePerm->wsmu_read : '0';
                $defaultUpdt = $rolePerm ? $rolePerm->wsmu_updt : '0';
                $defaultDelt = $rolePerm ? $rolePerm->wsmu_delt : '0';
                
                $saveData = [];
                $changes = [];
                
                // Check all 5 permissions
                if ($perm['vsbl'] != $defaultVsbl) {
                    $saveData['wsmu_vsbl'] = $perm['vsbl'];
                    $changes['vsbl'] = ['default' => $defaultVsbl, 'new' => $perm['vsbl']];
                } else {
                    // 🔥 NULL এর পরিবর্তে '0' সেভ করুন
                    $saveData['wsmu_vsbl'] = '0';
                }
                
                if ($perm['crat'] != $defaultCrat) {
                    $saveData['wsmu_crat'] = $perm['crat'];
                    $changes['crat'] = ['default' => $defaultCrat, 'new' => $perm['crat']];
                } else {
                    $saveData['wsmu_crat'] = '0';
                }
                
                if ($perm['read'] != $defaultRead) {
                    $saveData['wsmu_read'] = $perm['read'];
                    $changes['read'] = ['default' => $defaultRead, 'new' => $perm['read']];
                } else {
                    $saveData['wsmu_read'] = '0';
                }
                
                if ($perm['updt'] != $defaultUpdt) {
                    $saveData['wsmu_updt'] = $perm['updt'];
                    $changes['updt'] = ['default' => $defaultUpdt, 'new' => $perm['updt']];
                } else {
                    $saveData['wsmu_updt'] = '0';
                }
                
                if ($perm['delt'] != $defaultDelt) {
                    $saveData['wsmu_delt'] = $perm['delt'];
                    $changes['delt'] = ['default' => $defaultDelt, 'new' => $perm['delt']];
                } else {
                    $saveData['wsmu_delt'] = '0';
                }
                
                // 🔥 সব ফিল্ডের জন্য এন্ট্রি তৈরি করুন (সব ফিল্ডে '0' বা '1' থাকবে)
                $hasChanges = !empty($changes);
                
                if ($hasChanges) {
                    $existing = UserPermission::where('user_id', $userId)
                        ->where('menu_id', $menuId)
                        ->first();
                    
                    if ($existing) {
                        $existing->update($saveData);
                        $debugData[] = [
                            'menu_id' => $menuId,
                            'action' => 'updated',
                            'changes' => $changes,
                            'save_data' => $saveData
                        ];
                    } else {
                        $saveData['user_id'] = $userId;
                        $saveData['menu_id'] = $menuId;
                        UserPermission::create($saveData);
                        $debugData[] = [
                            'menu_id' => $menuId,
                            'action' => 'created',
                            'changes' => $changes,
                            'save_data' => $saveData
                        ];
                    }
                    $savedCount++;
                } else {
                    // No changes, delete if exists
                    $deleted = UserPermission::where('user_id', $userId)
                        ->where('menu_id', $menuId)
                        ->delete();
                    
                    if ($deleted) {
                        $deletedCount++;
                        $debugData[] = [
                            'menu_id' => $menuId,
                            'action' => 'deleted',
                            'changes' => 'No custom permission needed'
                        ];
                    } else {
                        $debugData[] = [
                            'menu_id' => $menuId,
                            'action' => 'no change',
                            'changes' => 'Already matches role default'
                        ];
                    }
                }
            }
            
            DB::commit();
            
            $customCount = UserPermission::where('user_id', $userId)->count();
            
            return response()->json([
                'status' => 'success',
                'msg' => "Custom permissions saved successfully. {$savedCount} saved, {$deletedCount} removed. Total custom overrides: {$customCount}",
                'saved_count' => $savedCount,
                'deleted_count' => $deletedCount,
                'total_custom' => $customCount,
                'debug_data' => $debugData
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to save permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeUserRole(Request $request)
    {
  
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:user_roles,id'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg' => $validator->errors()->first()
            ], 400);
        }
        
        try {

            $userRole = UserRole::with('role')->find($request->id);
            if(!$userRole) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'User role not found'
                ], 404);
            }
            
            $userId = $userRole->user_id;
            $roleName = $userRole->role ? $userRole->role->name : 'Unknown';
            $userRole->delete();
            UserPermission::where('user_id', $userId)->delete();
            $remainingRoles = UserRole::where('user_id', $userId)
                ->where('is_active', 1)
                ->count();
            
            $message = "Role '{$roleName}' removed successfully.";
            if ($remainingRoles == 0) {
                $message .= " User has no roles left.";
            }

            return response()->json([
                'status' => 'success',
                'msg' => $message,
                'data' => [
                    'user_id' => $userId,
                    'role_name' => $roleName,
                    'remaining_roles' => $remainingRoles
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to remove role: ' . $e->getMessage()
            ], 500);
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
