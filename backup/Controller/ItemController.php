<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Item;


class ItemController extends Controller{


    public function __construct(){
       $this->middleware('auth');
    }
    

    public function index(){
        $items = Item::orderBy('id','Desc')->paginate(20);
        return view("item.item_list",compact("items"));
    }


    public function create(){
        
        return view("item.item_create");;
    }


    public function store(Request $request){

        $this->validate($request, [
           "name"=>"required|max:191",
           "code"=>"required|max:191|unique:items",
           "ci_item_code"=>"required|max:191",
           "ci_item_name"=>"required|max:191",

        ]);

        $item = new Item;
        $item->name=$request->name;
        $item->code=$request->code;
        $item->ci_item_code=$request->ci_item_code;
        $item->ci_item_name=$request->ci_item_name;

        $item ->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/item");
    }



    public function edit($id){
        
        $item = Item::find($id); 
        return view("item.item_edit",compact("item"));;
        
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
           "name"=>"required|max:191",
           "code"=>"required|max:191|unique:items,code,$id",
           "ci_item_code"=>"required|max:191",
           "ci_item_name"=>"required|max:191",

        ]); 

        $item = Item::find($id);
        $item->name=$request->name;
        $item->code=$request->code;
        $item->ci_item_code=$request->ci_item_code;
        $item->ci_item_name=$request->ci_item_name;

        $item->save();
        Session::flash("success", "Edited Succcessfully !");
        return redirect("/item");
    }

    public function show($id){
        $item = Item::find($id); 
        return view("item.item_show",compact("item"));
    }


    public function destroy($id){
        $item = Item::findOrFail($id);
        $item ->delete();
        Session::flash("success", "Deleted Succcessfully !");
        return redirect("/item");
    }

}