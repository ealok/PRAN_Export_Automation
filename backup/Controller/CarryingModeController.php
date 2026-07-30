<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\CarryingMode;


class CarryingModeController extends Controller{


    public function __construct(){
       $this->middleware('auth');
    }
    

    public function index(){
        $carrying_modes = CarryingMode::orderBy('id','Desc')->paginate(20);
        return view("carrying_mode.carrying_mode_list",compact("carrying_modes"));
    }


    public function create(){
        
        return view("carrying_mode.carrying_mode_create");;
    }


    public function store(Request $request){

        $this->validate($request, [
           "name"=>"required|max:191",

        ]);

        $carrying_mode = new CarryingMode;
        $carrying_mode->name=$request->name;

        $carrying_mode ->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/carrying_mode");
    }



    public function edit($id){
        
        $carrying_mode = CarryingMode::find($id); 
        return view("carrying_mode.carrying_mode_edit",compact("carrying_mode"));;
        
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
           "name"=>"required|max:191",

        ]); 

        $carrying_mode = CarryingMode::find($id);
        $carrying_mode->name=$request->name;

        $carrying_mode->save();
        Session::flash("success", "Edited Succcessfully !");
        return redirect("/carrying_mode");
    }

    public function show($id){
        $carrying_mode = CarryingMode::find($id); 
        return view("carrying_mode.carrying_mode_show",compact("carrying_mode"));
    }


    public function destroy($id){
        $carrying_mode = CarryingMode::findOrFail($id);
        $carrying_mode ->delete();
        Session::flash("success", "Deleted Succcessfully !");
        return redirect("/carrying_mode");
    }

}