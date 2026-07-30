<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Importer;


class ImporterController extends Controller{


    public function __construct(){
       $this->middleware('auth');
    }
    

    public function index(){
        $importers = Importer::orderBy('id','Desc')->paginate(20);
        return view("importer.importer_list",compact("importers"));
    }


    public function create(){
        
        return view("importer.importer_create");;
    }


    public function store(Request $request){

        $this->validate($request, [
           "name"=>"required|max:191",
           "address"=>"required|max:191",

        ]);

        $importer = new Importer;
        $importer->name=$request->name;
        $importer->address=$request->address;

        $importer ->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/importer");
    }



    public function edit($id){
        
        $importer = Importer::find($id); 
        return view("importer.importer_edit",compact("importer"));;
        
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
           "name"=>"required|max:191",
           "address"=>"required|max:191",

        ]); 

        $importer = Importer::find($id);
        $importer->name=$request->name;
        $importer->address=$request->address;

        $importer->save();
        Session::flash("success", "Edited Succcessfully !");
        return redirect("/importer");
    }

    public function show($id){
        $importer = Importer::find($id); 
        return view("importer.importer_show",compact("importer"));
    }


    public function destroy($id){
        $importer = Importer::findOrFail($id);
        $importer ->delete();
        Session::flash("success", "Deleted Succcessfully !");
        return redirect("/importer");
    }

}