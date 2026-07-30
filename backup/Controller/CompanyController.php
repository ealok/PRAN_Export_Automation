<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Company;

use App\Group;

class CompanyController extends Controller{


    public function __construct(){
       $this->middleware('auth');
    }
    

    public function index(){
        $companies = Company::orderBy('id','Desc')->paginate(20);
        return view("company.company_list",compact("companies"));
    }


    public function create(){
        
        $groups=Group::all();
        return view("company.company_create")
             ->with("groups" ,$groups);;
    }


    public function store(Request $request){


        $this->validate($request, [
           "name"=>"required|max:191|unique:companies",
           "code"=>"required|max:191|unique:companies",
           "erc_no"=>"required|max:191|unique:companies",
           "bin_no"=>"required|max:191|unique:companies",
           "factory_name"=>"required|max:191",
           "factory_address"=>"required|max:191",
           "ho_address"=>"required|max:191",
           "group_id"=>"required|numeric|exists:groups,id",
           "factory_address_details"=>"required",
        ]);

        $company = new Company;
        $company->name=$request->name;
        $company->code=$request->code;
        $company->erc_no=$request->erc_no;
        $company->bin_no=$request->bin_no;
        $company->factory_name=$request->factory_name;
        $company->factory_address=$request->factory_address;
        $company->ho_address=$request->ho_address;
        $company->group_id=$request->group_id;
        $company->enrolment_no=$request->enrolment_no;
        $company->factory_address_details=$request->factory_address_details;
        $company ->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/company");
    }



    public function edit($id){
        
        $groups=Group::all();
        $company = Company::find($id); 
        return view("company.company_edit",compact("company"))
             ->with("groups" ,$groups);;
        
    }

    public function update(Request $request, $id) {


        $this->validate($request, [
           "name"=>"required|max:191|unique:companies,name,$id",
           "code"=>"required|max:191|unique:companies,code,$id",
           "erc_no"=>"required|max:191|unique:companies,erc_no,$id",
           "bin_no"=>"required|max:191|unique:companies,bin_no,$id",
           "factory_name"=>"required|max:191",
           "factory_address"=>"required|max:191",
           "ho_address"=>"required|max:191",
           "group_id"=>"required|numeric|exists:groups,id",
           "factory_address_details"=>"required",
        ]); 

        $company = Company::find($id);
        $company->name=$request->name;
        $company->code=$request->code;
        $company->erc_no=$request->erc_no;
        $company->bin_no=$request->bin_no;
        $company->factory_name=$request->factory_name;
        $company->factory_address=$request->factory_address;
        $company->ho_address=$request->ho_address;
        $company->group_id=$request->group_id;
        $company->enrolment_no=$request->enrolment_no;
        $company->factory_address_details=$request->factory_address_details;
        $company->save();
        Session::flash("success", "Edited Succcessfully !");
        return redirect("/company");
    }

    public function show($id){
        $company = Company::find($id); 
        return view("company.company_show",compact("company"));
    }


    public function destroy($id){
        $company = Company::findOrFail($id);
        $company ->delete();
        Session::flash("success", "Deleted Succcessfully !");
        return redirect("/company");
    }

}