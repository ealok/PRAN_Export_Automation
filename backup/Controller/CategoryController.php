<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Category;
use DB;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index');  
    }

    public function getCategoryList(Request $request){
           
        $categories = Category::select('id', 'name')
                    ->orderByDesc('id')
                    ->get();

        if($categories) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $categories
            ]);

        } else  {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);

        }        


    

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
           
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories'
        ],[
            'name.required' => 'Name is required.',
            'name.unique' => 'Name must be unique.',
            'name.max' => 'Name should not exceed 255 characters.',
        ]);

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()->toArray()]);
            
        }

        $category=new Category();
        $category->name=$request->name;
        $category->save();
        if($category) {

            return response()->json([
                'message' => "Data Inserted Successfully",
                "code"    => 200
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);

        } 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id;
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
