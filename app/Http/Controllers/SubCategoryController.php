<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Category;
use App\SubCategory;
use DB;
class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::all();
        return view('subcategories.index')
               ->with('categories',$categories);
    }

    public function getSubcategoryList(Request $request){
           
        $subcategories = DB::table('sub_categories')
                ->select('sub_categories.id', 'categories.name as category', 'sub_categories.name as sub_category')
                ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
                ->orderBy('sub_categories.id', 'desc')
                ->get();

        if($subcategories) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $subcategories
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
            'category_id' => 'required',
            'name' => 'required|unique:sub_categories',

        ],[
            'category_id.required' => 'Category is required.',
            'name.required' => 'Subcategory is required.',
            'name.unique' => 'Subcategory is unique.',
            'name.max' => 'Subcategory should not exceed 255 characters.',
        ]);

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()->toArray()]);
            
        }

        $sub_category=new SubCategory();
        $sub_category->category_id =$request->category_id;
        $sub_category->name=$request->name;
        $sub_category->save();

        if($sub_category) {

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
