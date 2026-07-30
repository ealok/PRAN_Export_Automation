<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\ScItem;


class ScItemController extends Controller{


    public function __construct(){
       $this->middleware('auth');
    }
    

    public function index(){
        $sc_items = ScItem::orderBy('id','Desc')->paginate(20);
        return view("sc_item.sc_item_list",compact("sc_items"));
    }


    public function create(){
        
        return view("sc_item.sc_item_create");;
    }


    public function store(Request $request){

        $this->validate($request, [
           "code"=>"required|max:191",
           "name"=>"required|max:191",
           "ci_item_code"=>"required|max:191",
           "ci_item_name"=>"required|max:191",

        ]);

        $sc_item = new ScItem;
        $sc_item->code=$request->code;
        $sc_item->name=$request->name;
        $sc_item->ci_item_code=$request->ci_item_code;
        $sc_item->ci_item_name=$request->ci_item_name;

        $sc_item ->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/sc_item");
    }



    public function edit($id){
        
        $sc_item = ScItem::find($id); 
        return view("sc_item.sc_item_edit",compact("sc_item"));;
        
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
           "code"=>"required|max:191",
           "name"=>"required|max:191",
           "ci_item_code"=>"required|max:191",
           "ci_item_name"=>"required|max:191",

        ]); 

        $sc_item = ScItem::find($id);
        $sc_item->code=$request->code;
        $sc_item->name=$request->name;
        $sc_item->ci_item_code=$request->ci_item_code;
        $sc_item->ci_item_name=$request->ci_item_name;

        $sc_item->save();
        Session::flash("success", "Edited Succcessfully !");
        return redirect("/sc_item");
    }

    public function show($id){
        $sc_item = ScItem::find($id); 
        return view("sc_item.sc_item_show",compact("sc_item"));
    }


    public function destroy($id){
        $sc_item = ScItem::findOrFail($id);
        $sc_item ->delete();
        Session::flash("success", "Deleted Succcessfully !");
        return redirect("/sc_item");
    }

    

}