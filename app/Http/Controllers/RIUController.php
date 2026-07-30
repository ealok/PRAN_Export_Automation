<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
class RIUController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = DB::table('repe_details')
                ->select('ingredient', DB::raw('MAX(rcpe_unit) as rcpe_unit'), DB::raw('MAX(source_type) as source_type'), DB::raw('MAX(source_address) as source_address'), DB::raw('MAX(rate) as rate'))
                ->groupBy('ingredient')
                ->get();
        return view('riu.index',compact('results'));
    }


    public function saveRiuData(Request $request){
            
          
        $dataArray = $request->input('data');
        foreach ($dataArray as $data) {
           
           
            DB::table('repe_details')
            ->where('ingredient', $data['ingredient']) // Replace 'YourIngredientValue' with the actual ingredient value
            ->update([
                'rcpe_unit' => $data['rcpe_unit'],
                'source_type' => $data['source_type'],
                'source_address' => $data['source_address'],
                'rate' => $data['rate']
            ]);
            

        }


        return response()->json(['message' => 'Information Updated successfully']);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
