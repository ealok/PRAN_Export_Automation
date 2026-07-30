<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\BapaBillSetup;
use Session;
class BapaSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $results=BapaBillSetup::all();
        return view('bapa_bill_setup.index',compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bapa_bill_setup.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bapaBillSetup=new BapaBillSetup();
        $bapaBillSetup->claim_percent=$request->claim_percent;
        $bapaBillSetup->subsidy_percent=$request->subsidy_percent;
        $bapaBillSetup->processing_fee=$request->processing_fee;
        $bapaBillSetup->save();
        Session::flash("success", "Created Succcessfully !");
        return redirect("/bapa_bill_setup");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {    
        $result=BapaBillSetup::findorfail($id);
        return view('bapa_bill_setup.edit',compact('result'));
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
        
        $bapaBillSetup=BapaBillSetup::findorfail($id);;
        $bapaBillSetup->claim_percent=$request->claim_percent;
        $bapaBillSetup->subsidy_percent=$request->subsidy_percent;
        $bapaBillSetup->processing_fee=$request->processing_fee;
        $bapaBillSetup->save();
        Session::flash("success", "Updated Succcessfully Done !");
        return redirect("/bapa_bill_setup");

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
