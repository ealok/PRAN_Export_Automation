<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Country;


class CountryController extends Controller{


    public function __construct(){
       $this->middleware('auth');
    }
    

    public function index(){
        $countries = Country::orderBy('id','Desc')->paginate(20);
        return view("country.country_list",compact("countries"));
    }


    public function create(){
        
        return view("country.country_create");;
    }


    public function store(Request $request){

        $this->validate($request, [
           "name"=>"required|max:191",
           "code"=>"required|max:191",

        ]);

        $country = new Country;
        $country->name=$request->name;
        $country->code=$request->code;

        $country ->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/country");
    }



    public function edit($id){
        
        $country = Country::find($id); 
        return view("country.country_edit",compact("country"));;
        
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
           "name"=>"required|max:191",
           "code"=>"required|max:191",

        ]); 

        $country = Country::find($id);
        $country->name=$request->name;
        $country->code=$request->code;

        $country->save();
        Session::flash("success", "Edited Succcessfully !");
        return redirect("/country");
    }

    public function show($id){
        $country = Country::find($id); 
        return view("country.country_show",compact("country"));
    }


    public function destroy($id){
        $country = Country::findOrFail($id);
        $country ->delete();
        Session::flash("success", "Deleted Succcessfully !");
        return redirect("/country");
    }

}