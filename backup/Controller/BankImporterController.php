<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\BankImporter;


class BankImporterController extends Controller{


    public function __construct(){
       $this->middleware('auth');
    }
    

    public function index(){
        $bank_importers = BankImporter::orderBy('id','Desc')->paginate(20);
        return view("bank_importer.bank_importer_list",compact("bank_importers"));
    }


    public function create(){
        
        return view("bank_importer.bank_importer_create");;
    }


    public function store(Request $request){

        $this->validate($request, [
           "bank_name"=>"required|max:191",
           "account_name"=>"required|max:191",
           "branch"=>"required|max:191",
           "ac_or_iban"=>"required|max:191",
           "swift_code"=>"required|max:191",
           "other"=>"nullable|max:191",

        ]);

        $bank_importer = new BankImporter;
        $bank_importer->bank_name=$request->bank_name;
        $bank_importer->account_name=$request->account_name;
        $bank_importer->branch=$request->branch;
        $bank_importer->ac_or_iban=$request->ac_or_iban;
        $bank_importer->swift_code=$request->swift_code;
        $bank_importer->other=$request->other;

        $bank_importer ->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/bank_importer");
    }



    public function edit($id){
        
        $bank_importer = BankImporter::find($id); 
        return view("bank_importer.bank_importer_edit",compact("bank_importer"));;
        
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
           "bank_name"=>"required|max:191",
           "account_name"=>"required|max:191",
           "branch"=>"required|max:191",
           "ac_or_iban"=>"required|max:191",
           "swift_code"=>"required|max:191",
           "other"=>"nullable|max:191",

        ]); 

        $bank_importer = BankImporter::find($id);
        $bank_importer->bank_name=$request->bank_name;
        $bank_importer->account_name=$request->account_name;
        $bank_importer->branch=$request->branch;
        $bank_importer->ac_or_iban=$request->ac_or_iban;
        $bank_importer->swift_code=$request->swift_code;
        $bank_importer->other=$request->other;

        $bank_importer->save();
        Session::flash("success", "Edited Succcessfully !");
        return redirect("/bank_importer");
    }

    public function show($id){
        $bank_importer = BankImporter::find($id); 
        return view("bank_importer.bank_importer_show",compact("bank_importer"));
    }


    public function destroy($id){
        $bank_importer = BankImporter::findOrFail($id);
        $bank_importer ->delete();
        Session::flash("success", "Deleted Succcessfully !");
        return redirect("/bank_importer");
    }

}