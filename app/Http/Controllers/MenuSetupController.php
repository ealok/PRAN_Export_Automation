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

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
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
                'm2.menu_icon as menu_icon',
                'm2.color as color')
            ->where('t1.root_id', '=', 0)
            ->orderBy('t1.id', 'DESC')
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
        $menu_setup->is_feature=$request->feature_menu ? $request->feature_menu : 0;
        $menu_setup->color=$request->color ? $request->color : "#667eea";
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
        $setupMenus=MenuSetup::where('root_id',0)->get();
        return $result=MenuSetup::findorfail($id);
        return view('menu.menu_edit',compact("setupMenus"))
               ->with('result',$result);
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
