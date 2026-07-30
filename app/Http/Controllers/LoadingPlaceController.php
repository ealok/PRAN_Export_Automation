<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\LoadingPlace;


class LoadingPlaceController extends Controller{


    public function __construct(){
       $this->middleware('auth');
    }
    

    public function index(){
        $loading_places = LoadingPlace::orderBy('id','Desc')->paginate(20);
        return view("loading_place.loading_place_list",compact("loading_places"));
    }


    public function create(){
        
        return view("loading_place.loading_place_create");;
    }


    public function store(Request $request){

        $this->validate($request, [
           "name"=>"required|max:191",
           "address"=>"required|max:191",

        ]);

        $loading_place = new LoadingPlace;
        $loading_place->name=$request->name;
        $loading_place->address=$request->address;

        $loading_place ->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/loading_place");
    }



    public function edit($id){
        
        $loading_place = LoadingPlace::find($id); 
        return view("loading_place.loading_place_edit",compact("loading_place"));;
        
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
           "name"=>"required|max:191",
           "address"=>"required|max:191",

        ]); 

        $loading_place = LoadingPlace::find($id);
        $loading_place->name=$request->name;
        $loading_place->address=$request->address;

        $loading_place->save();
        Session::flash("success", "Edited Succcessfully !");
        return redirect("/loading_place");
    }

    public function show($id){
        $loading_place = LoadingPlace::find($id); 
        return view("loading_place.loading_place_show",compact("loading_place"));
    }


    public function destroy($id){
        $loading_place = LoadingPlace::findOrFail($id);
        $loading_place ->delete();
        Session::flash("success", "Deleted Succcessfully !");
        return redirect("/loading_place");
    }

}