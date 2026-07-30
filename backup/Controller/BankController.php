<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Bank;


class BankController extends Controller{


    public function __construct(){
       $this->middleware('auth');
    }
    

    public function index(){
        $banks = Bank::orderBy('id','Desc')->paginate(20);
        return view("bank.bank_list",compact("banks"));
    }


    public function create(){
        
        return view("bank.bank_create");;
    }


    public function store(Request $request){

        $this->validate($request, [
           "name"=>"required|max:191",
           "branch"=>"required|max:191",
           "address"=>"required|max:191",
           "swift_code"=>"required|max:191",

        ]);

        $bank = new Bank;
        $bank->name=$request->name;
        $bank->branch=$request->branch;
        $bank->address=$request->address;
        $bank->swift_code=$request->swift_code;

        $bank ->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/bank");
    }



    public function edit($id){
        
        $bank = Bank::find($id); 
        return view("bank.bank_edit",compact("bank"));;
        
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
           "name"=>"required|max:191",
           "branch"=>"required|max:191",
           "address"=>"required|max:191",
           "swift_code"=>"required|max:191",

        ]); 

        $bank = Bank::find($id);
        $bank->name=$request->name;
        $bank->branch=$request->branch;
        $bank->address=$request->address;
        $bank->swift_code=$request->swift_code;

        $bank->save();
        Session::flash("success", "Edited Succcessfully !");
        return redirect("/bank");
    }

    public function show($id){
        $bank = Bank::find($id); 
        return view("bank.bank_show",compact("bank"));
    }


    public function destroy($id){
        $bank = Bank::findOrFail($id);
        $bank ->delete();
        Session::flash("success", "Deleted Succcessfully !");
        return redirect("/bank");
    }

}