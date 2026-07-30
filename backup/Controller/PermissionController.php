<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Session;
use Auth;
use App\RootSetup;
use App\MenuSetup;
use App\Role;
use App\Permission;
use App\User;
use DB;
class PermissionController extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        
    }

    public function index()
    {
         return view("limited_access");  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        // if(!$this->hasViewPermission()) {

        //     return view('limited_access');
            
        // }

        $roles=Role::all();
        $menus = DB::table('menus as t1')
                ->leftJoin('menus as m2', 't1.id', '=', 'm2.root_id')
                ->select(
                    DB::raw('CASE WHEN m2.id IS NULL THEN t1.id ELSE m2.id END AS id'),
                    't1.menu_name as root',
                    DB::raw('CASE WHEN m2.menu_name IS NULL THEN t1.menu_name ELSE m2.menu_name END AS menu_name')
                )
                ->where('t1.root_id', 0)
                ->orderBy('t1.priority', 'asc')
                ->orderBy('m2.priority', 'asc')
                ->get();   
        return view('permission.permission_create',compact('roles'))
            ->with('menus',$menus); 
         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $menuPermissions = $request->input('menuPermissions');
        foreach ($menuPermissions as $permission) {

            $roleId = $permission['role_id'];
            $menuId = $permission['menu_id'];
            $vsbl = $permission['vsbl'];
            $crat = $permission['crat'];
            $read = $permission['read'];
            $updt = $permission['updt'];
            $delt = $permission['delt'];

            if(Permission::where('role_id',$roleId)->where('menu_id',$menuId)->count()==0){
             
                $permission=new Permission();
                $permission->role_id=$roleId;
                $permission->menu_id=$menuId;
                $permission->wsmu_vsbl=$vsbl;
                $permission->wsmu_crat=$crat;
                $permission->wsmu_read=$read;
                $permission->wsmu_updt=$updt;
                $permission->wsmu_delt=$delt;
                $permission->save(); 
                 

            }else{
               
                Permission::where('role_id',$roleId)->where('menu_id',$menuId)->update([
                   
                    'role_id'=>$roleId,
                    'menu_id'=>$menuId,
                    'wsmu_vsbl'=>$vsbl,
                    'wsmu_crat'=>$crat,
                    'wsmu_read'=>$read,
                    'wsmu_updt'=>$updt,
                    'wsmu_delt'=>$delt 

                ]);


            }
           

        }

        return response()->json([
            'message' => "Save Successfully Done..!!",
            "code"    => 200,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        
        $permissions = Permission::where('role_id', $request->role_id)->get();
        return response()->json(['menuPermissions' => $permissions]);
    }

    public function getRolePermission(Request $request){

        $permissions = Permission::where('role_id', $request->role_id)->get();
        return response()->json(['menuPermissions' => $permissions]);

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
