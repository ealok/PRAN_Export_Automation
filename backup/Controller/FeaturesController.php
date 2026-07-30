<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feature;
use Session;

class FeaturesController extends Controller
{
    

     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $features = Feature::all();
        return view('feature.features',compact('features'));
    }

   
    public function create()
    {
        return view('feature.features_create');
    }

   
    public function store(Request $request)
    {     
          $this->validate($request, [
            'name' => 'required|unique:features',
            ]);
          $feature = new Feature;
          $feature->name=$request->name;
          $feature->save(); 
          Session::flash('success','Successfully Created');  
          return redirect('/feature');

    }

    
    public function show($id)
    {
   
       
    }

    
    public function edit($id) {
     $feature = Feature::find($id);
     return view('feature.features_edit',compact('feature'));  
    }

    
    public function update(Request $request, $id)
    {
          $this->validate($request, [
            'name' => 'required|unique:features',
            ]);
          $feature = Feature::find($id);
          $feature->name=$request->name;
          $feature->save(); 
          Session::flash('success','Successfully Edited');  
          return redirect('/feature');
    }

    
    public function destroy($id)
    {
        //
    }
}
