<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\TransportAgency;
use Session;
use Auth;
class TransportAgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results=TransportAgency::orderBy('id','Desc')->paginate(20); 
        return view('transport_agency.home')->with('results', $results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transport_agency.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $transportAgency=new TransportAgency();
       $transportAgency->transport_agency_info=$request->transport_agency_info;
       $transportAgency->description=$request->description;
       $transportAgency->save();
       Session::flash("success", "Created Succcessfully !");
       return redirect("/transportagency");

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
        $transportAgency=TransportAgency::findorfail($id);
        return view('transport_agency.edit')->with('transportAgency',$transportAgency);
        
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
        $transportAgency=TransportAgency::findorfail($id);
        $transportAgency->transport_agency_info=$request->transport_agency_info;
        $transportAgency->description=$request->description;
        $transportAgency->save();
        Session::flash("success", "Update Succcessfully..!");
        return redirect("/transportagency");

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
