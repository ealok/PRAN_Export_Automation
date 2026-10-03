<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;


use App\Company;
use App\Bank;
use App\CompanyBank;

class CompanyBankController extends Controller{


    public function __construct(){
       $this->middleware('auth');
    }
    

    public function index(){

        $company_banks = CompanyBank::orderBy('id','Desc')->get();
        return view("company_bank.company_bank_list",compact("company_banks"));
        
    }


    public function create(){
        
        $companies=Company::all();
        $banks=Bank::all();
        return view("company_bank.company_bank_create")
             ->with("companies" ,$companies)
             ->with("banks" ,$banks);;
    }


    public function store(Request $request){

        $this->validate($request, [
           "company_id"=>"required|numeric|exists:companies,id",
           "bank_id"=>"required|numeric|exists:banks,id",
           "account_number"=>"required|max:191",

        ]);

        if($this->isAlreadyExist($request->company_id,$request->bank_id)){
            Session::flash("danger", "Already Exist!");
            return redirect()->back();
        }

        $company_bank = new CompanyBank;
        $company_bank->company_id=$request->company_id;
        $company_bank->bank_id=$request->bank_id;
        $company_bank->account_number=$request->account_number;
        $company_bank ->save();

        Session::flash("success", "Created Succcessfully !");
        return redirect("/company_bank");
    }

    public function isAlreadyExist($company_id,$bank_id){
        $company_bank = CompanyBank::where('company_id',$company_id)->where('bank_id',$bank_id)->first();
        if($company_bank){
            return 1;
        }else{
            return 0;
        }
    }



    public function edit($id){
        
        $companies=Company::all();
        $banks=Bank::all();
        $company_bank = CompanyBank::find($id); 
        return view("company_bank.company_bank_edit",compact("company_bank"))
             ->with("companies" ,$companies)
             ->with("banks" ,$banks);;
        
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
           "company_id"=>"required|numeric|exists:companies,id",
           "bank_id"=>"required|numeric|exists:banks,id",
           "account_number"=>"required|max:191",

        ]); 

        $company_bank = CompanyBank::find($id);
        $company_bank->company_id=$request->company_id;
        $company_bank->bank_id=$request->bank_id;
        $company_bank->account_number=$request->account_number;

        $company_bank->save();
        Session::flash("success", "Edited Succcessfully !");
        return redirect("/company_bank");
    }

    public function show($id){
        $company_bank = CompanyBank::find($id); 
        return view("company_bank.company_bank_show",compact("company_bank"));
    }


    public function destroy($id){
        $company_bank = CompanyBank::findOrFail($id);
        $company_bank ->delete();
        Session::flash("success", "Deleted Succcessfully !");
        return redirect("/company_bank");
    }


    public function get_company_bank(Request $request){
        $company_banks = CompanyBank::where('company_id',$request->company_id)->pluck('bank_id');
        return Bank::whereIn('id',$company_banks)->get();
    }

}