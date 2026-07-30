<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Session;
use Auth;
use App\Role;
use DB;
use App\MenuSetup;
use App\Permission;
class RoleController extends Controller
{
    
    /*
    * @return \Illuminate\Http\Response
    */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');

    }
    
    public function index()
    {
        if(!$this->hasViewPermission()) {

            return view('limited_access');
            
        }
        $roles=Role::all();
        return view('role.role_list',compact("roles"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if(!$this->hasCreatePermission()) {

            return view('limited_access');
            
        }

        return view('role.role_create');    
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role=new Role();
        $role->name=$request->name;
        $role->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/role");

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
