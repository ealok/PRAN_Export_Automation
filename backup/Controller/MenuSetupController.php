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
use DB;
class MenuSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $permission;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            
            $action = Route::getCurrentRoute()->getActionName();
            $menu = MenuSetup::where('menu_controller', class_basename(explode('@', $action)[0]))->first();
            // Initialize permission with default values
            $this->permission = (object) array('wsmu_vsbl' => 0, 'wsmu_crat' => 0, 'wsmu_read' => 0, 'wsmu_updt' => 0, 'wsmu_delt' => 0);
            if(!is_null($menu)) {

                $roleName = Role::where('id', Auth::user()->role_id)->value('name');
                if ($roleName === "Super Admin") {
                    // Set all permissions to 1 for Super Admin
                    $this->permission = (object) array('wsmu_vsbl' => 1, 'wsmu_crat' => 1, 'wsmu_read' => 1, 'wsmu_updt' => 1, 'wsmu_delt' => 1);
                } else {
                    // Retrieve permissions for the user role and menu
                    $permission = Permission::where('role_id', Auth::user()->role_id)->where('menu_id', $menu->id)->first();

                    if ($permission) {
                        // If permissions exist, assign them
                        $this->permission = $permission;
                    }
                }
            }

            return $next($request);
        });
    }

    public function index()
    {
        // $this->permission->wsmu_vsbl;
        // if($this->permission->wsmu_vsbl){
            
            $menuList = DB::table('menus as t1')
            ->leftJoin('menus as m2', 't1.id', '=', 'm2.root_id')
            ->select(
                't1.id as id',
                't1.menu_name as root',
                't1.menu_url as root_url',
                't1.menu_icon as root_icon',
                'm2.menu_name as menu',
                'm2.menu_url as menu_url',
                'm2.menu_icon as menu_icon'
            )
            ->where('t1.root_id', '=', 0)
            ->orderBy('t1.priority', 'asc')
            ->orderBy('m2.priority', 'asc')
            ->get();
           return view('menu.menu_list',compact("menuList"));

        // }else{
            
        //     return view("limited_access");

        // }
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if($this->permission->wsmu_crat){

            $setupMenus=MenuSetup::where('root_id',0)->get();
            return view('menu.menu_create',compact("setupMenus"));

        // }else{
        
        //     return view("limited_access");
        // }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $menu_setup=new MenuSetup();
        $menu_setup->root_id=$request->root_id ? $request->root_id : 0;
        $menu_setup->menu_name=$request->menu_name;
        $menu_setup->menu_url=$request->menu_url;
        $menu_setup->menu_icon=$request->menu_icon;
        $menu_setup->priority=$request->priority ? $request->priority : 0;
        $menu_setup->menu_url=$request->menu_url ? $request->menu_url : '#';
        $menu_setup->menu_controller=$request->menu_controller;
        $menu_setup->status=$request->status ? $request->status : 0;
        $menu_setup->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/menu");

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
