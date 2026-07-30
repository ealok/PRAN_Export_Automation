<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\SalesTerm;


class SalesTermController extends Controller{


    public function __construct(){
       $this->middleware('auth');
    }
    

    public function index(){
        $sales_terms = SalesTerm::orderBy('id','Desc')->paginate(20);
        return view("sales_term.sales_term_list",compact("sales_terms"));
    }


    public function create(){
        
        return view("sales_term.sales_term_create");;
    }


    public function store(Request $request){

        $this->validate($request, [
           "name"=>"required|max:191",

        ]);

        $sales_term = new SalesTerm;
        $sales_term->name=$request->name;

        $sales_term ->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/sales_term");
    }



    public function edit($id){
        
        $sales_term = SalesTerm::find($id); 
        return view("sales_term.sales_term_edit",compact("sales_term"));;
        
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
           "name"=>"required|max:191",

        ]); 

        $sales_term = SalesTerm::find($id);
        $sales_term->name=$request->name;

        $sales_term->save();
        Session::flash("success", "Edited Succcessfully !");
        return redirect("/sales_term");
    }

    public function show($id){
        $sales_term = SalesTerm::find($id); 
        return view("sales_term.sales_term_show",compact("sales_term"));
    }


    public function destroy($id){
        $sales_term = SalesTerm::findOrFail($id);
        $sales_term ->delete();
        Session::flash("success", "Deleted Succcessfully !");
        return redirect("/sales_term");
    }

}