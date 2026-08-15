<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Bu;
use Session;
class BuController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     

        // if(!$this->hasViewPermission()) {

        //     return view('limited_access');
            
        // } 
        $bus=Bu::orderBy('id','Desc')->paginate(10);
        return view('bu.bu_list',compact('bus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        
        // if(!$this->hasCreatePermission()) {

        //     return view('limited_access');
            
        // } 
        return view('bu.bu_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bu=new Bu();
        $bu->code=$request->code;
        $bu->name=$request->name;
        $bu->buh_name=$request->buh_name;
        $bu->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/bu");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bu=Bu::findorfail($id);
        return view('bu.bu_show')
              ->with('bu',$bu);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bu=Bu::findorfail($id);
        return view('bu.bu_edit')
            ->with('bu',$bu);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bu=Bu::findorfail($id);
        $bu->code=$request->code;
        $bu->name=$request->name;
        $bu->buh_name=$request->buh_name;
        $bu->save();
        Session::flash("success", "Update Succcessfully !");
        return redirect("/bu");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
