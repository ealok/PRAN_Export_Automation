<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\BU;
use App\CurrencySetup;
use Session;
use Auth;
class CurrencySetupController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $results=CurrencySetup::orderBy('id','Desc')->paginate(10);
        return view('currency_setup.currency_list',compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('currency_setup.currency_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "currency_name"=>"required",
            "currency_rate"=>"required"
        ]);
        $curency_setup=new CurrencySetup();
        $curency_setup->currency_name=$request->currency_name;
        $curency_setup->currency_rate=$request->currency_rate;
        $curency_setup->iuid=Auth::user()->id;
        $curency_setup->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/currency");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result=CurrencySetup::findorfail($id);
        return view('currency_setup.currency_edit')
            ->with('result',$result);

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

        $this->validate($request, [
            "currency_name"=>"required",
            "currency_rate"=>"required"
        ]);
        $curency_setup=CurrencySetup::findorfail($id);
        $curency_setup->currency_name=$request->currency_name;
        $curency_setup->currency_rate=$request->currency_rate;
        $curency_setup->euid=Auth::user()->id;
        $curency_setup->save();
        Session::flash("success", "Update Succcessfully !");
        return redirect("/currency");
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

    public function getCurrencyRate(Request $request){
        
        $currencyId=$request->currency_id;
        $result = CurrencySetup::where('id', $currencyId)
                 ->selectRaw('CASE WHEN id = 1 THEN "Default" ELSE ROUND(currency_rate, 2) END AS rate')
                 ->first();

        return response()->json(['rate'=>$result->rate],200);

    } 


}
