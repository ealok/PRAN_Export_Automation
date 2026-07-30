<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\RcpeMaster;
use App\RepeDetails;
use Auth;
use Session;
use User;
class MaterialReceipeController extends Controller
{

    public function __construct(){

       $this->middleware('auth');

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $results=DB::select("SELECT
                rcpe_masters.id,
                rcpe_masters.rcpe_fg_id,
                rcpe.name,
                rcpe_masters.product_percentage,
                rcpe_masters.created_at,
                CASE WHEN rcpe_masters.status = 1 THEN 'Active' ELSE 'Inactive'
            END AS active_status
            FROM
                rcpe_masters
            JOIN rcpe ON rcpe_masters.rcpe_fg_id = rcpe.id");
        return view('receipe.receipe_list')->with('results', $results);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $results=\DB::select("SELECT * FROM `rcpe`");
        return view('receipe.receipe_create')->with('results',$results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $user_id=Auth::user()->id;
        $rcpe_fg_id=$request->rcpe_fg_value[0]; 
        // $results=DB::table('rcpe_masters')
        //    ->where('rcpe_fg_id', $rcpe_fg_id)
        //    ->get();
        // if(count($results)>0){

        //    Session::flash("danger", "Dear Sir, Already Exist Recipe For This Item...!!");
        //    return redirect("/recipe"); 

        // }else{


        // } 
        
        $rcpeMaster=new RcpeMaster();
        $rcpeMaster->rcpe_fg_id=$rcpe_fg_id;
        $rcpeMaster->user_id=$user_id;
        $rcpeMaster->product_percentage=$request->product_percentage[0];
        $rcpeMaster->save();
        $rcpe_id=$rcpeMaster->id;
        $length=count($request->rcpe_fg_value);
        for ($i=0; $i < $length; $i++) { 

            $repe_details=new RepeDetails();
            $repe_details->rcpe_id=$rcpe_id;
            $repe_details->ingredient=$request->ingredient[$i];
            $repe_details->rcpe_unit=$request->rcpe_unit[$i];
            $repe_details->source_type=$request->source_type[$i];
            $repe_details->source_address=$request->source_address[$i];
            $repe_details->qty=$request->qty[$i];
            $repe_details->percentage=$request->percentage[$i];
            $repe_details->wqty=$request->wqty[$i];
            $repe_details->rate=$request->rate[$i];
            $repe_details->save();
        }
        Session::flash("success", "Created Succcessfully !");
        return redirect("/recipe");    

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $rcpeMasters=DB::select("SELECT
                rcpe_masters.id,
                rcpe_masters.rcpe_fg_id,
                rcpe.name,
                rcpe_masters.product_percentage,
                rcpe_masters.created_at,
                CASE WHEN rcpe_masters.status = 1 THEN 'Active' ELSE 'Inactive'
            END AS active_status
            FROM
                rcpe_masters
            JOIN rcpe ON rcpe_masters.rcpe_fg_id = rcpe.id
            WHERE rcpe_masters.id='$id'");

        $rcpeDetails=DB::select("SELECT
                    rcpe_masters.id,
                    rcpe_masters.rcpe_fg_id,
                    rcpe.name,
                    rcpe_masters.created_at,
                    repe_details.ingredient,
                    repe_details.rcpe_unit,
                    repe_details.source_type,
                    repe_details.source_address,
                    repe_details.qty,
                    repe_details.percentage,
                    repe_details.wqty,
                    repe_details.rate,
                    CASE WHEN rcpe_masters.status = 1 THEN 'Active' ELSE 'Inactive'
                            END AS active_status
                FROM
                    rcpe_masters
                JOIN rcpe ON rcpe_masters.rcpe_fg_id = rcpe.id
                JOIN repe_details ON repe_details.rcpe_id=rcpe_masters.id
                WHERE rcpe_masters.id='$id'");
        return view('receipe.receipe_show')->with('rcpeMasters',$rcpeMasters)->with('rcpeDetails', $rcpeDetails);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $rcpeis=DB::select("select * from rcpe");
        $rcpeMasters=DB::select("SELECT
                rcpe_masters.id,
                rcpe_masters.rcpe_fg_id,
                rcpe.name,
                rcpe_masters.created_at,
                rcpe_masters.status,
                rcpe_masters.product_percentage,
                CASE WHEN rcpe_masters.status = 1 THEN 'Active' ELSE 'Inactive'
            END AS active_status
            FROM
                rcpe_masters
            JOIN rcpe ON rcpe_masters.rcpe_fg_id = rcpe.id
            WHERE rcpe_masters.id='$id'");
        $results=RcpeMaster::findorfail($id);
        $recipeMasterId=$results->rcpe_fg_id;
        $rcpeDetails=DB::select("SELECT
                    repe_details.id,
                    rcpe_masters.rcpe_fg_id,
                    rcpe.name,
                    rcpe_masters.created_at,
                    repe_details.ingredient,
                    repe_details.rcpe_unit,
                    repe_details.source_type,
                    repe_details.source_address,
                    repe_details.qty,
                    repe_details.percentage,
                    repe_details.wqty,
                    repe_details.rate,
                    CASE WHEN rcpe_masters.status = 1 THEN 'Active' ELSE 'Inactive'
                            END AS active_status
                FROM
                    rcpe_masters
                JOIN rcpe ON rcpe_masters.rcpe_fg_id = rcpe.id
                JOIN repe_details ON repe_details.rcpe_id=rcpe_masters.id
                WHERE rcpe_masters.id='$id'");
         return view('receipe.receipe_edit')
              ->with('rcpeMasters',$rcpeMasters)
              ->with('rcpeDetails', $rcpeDetails)
              ->with('rcpeis', $rcpeis)
              ->with('recipeMasterId', $recipeMasterId);

    }

    public function updateRecipeMaster(Request $request){

           // dd($request->all());

        
            if($request->status=='1' || $request->status=='0'){
               
                $results=DB::table('rcpe_masters')
                     ->where('rcpe_fg_id', $request->rcpe_fg_id)
                     ->where('status', 1)
                     ->get();
                if(count($results)>0){

                    return redirect('recipe/' . $request->master_id . '/edit')->with('danger','Already Active Another Recipe');
                }     

            }

            $results=RcpeMaster::findorfail($request->master_id);
            $prviousStatus=$results->status;
            $previousVersion=$request->version;

            if($request->status==$prviousStatus && !empty($request->status)){
                
               $flag=1;

            }else{

                if($request->status==''){

                    $flag=0;

                }else if($request->status=='0'){

                   $flag=1;
                }

            }

            DB::table('rcpe_masters')
                    ->where('id', $request->master_id)
                    ->update([
                'rcpe_fg_id' => $request->rcpe_fg_id,
                'product_percentage'=>$request->product_percentage,
                'status' => $flag
                
            ]);

            return redirect('/recipe')->with('success','Update Succcessfully..!!');

        
        
        
    }

    public function getRecipeDetailseditView(Request $request, $id){
         

         $result=RepeDetails::findorfail($id);
         return view('receipe.receipe_details_edit')
               ->with('id', $id)
               ->with('rcpe_id',$result->rcpe_id)
               ->with('result', $result);

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
        

    }

    public function recipeDetailsUpdate(Request $request){

        DB::table('repe_details')
                  ->where('id', $request->edit_id)
                  ->update([
              'ingredient' => $request->ingredient,
              'rcpe_unit' => $request->rcpe_unit,
              'source_type' => $request->source_type,
              'source_address' => $request->source_address,  
              'qty' => $request->qty,
              'percentage' => $request->percentage,  
              'wqty' => $request->wqty,
              'rate' => $request->rate          
        ]);

        return redirect('/recipe/'. $request->rcpe_id .'/edit')->with('success','Update Succcessfully..!!');

      

    }

    public function addNewIngredient($id){

        $rcpeis=DB::select("select * from rcpe");
        $results=RcpeMaster::findorfail($id);
        $recipeMasterId=$results->rcpe_fg_id;
        return view('receipe.add_new_ingredient')
               ->with('update_id', $id)
               ->with('results',$results)
               ->with('rcpeis', $rcpeis)
               ->with('recipeMasterId',$recipeMasterId);
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

    public function saveAddNewIngredient(Request $request){

        $length=count($request->rcpe_fg_value);
        for ($i=0; $i < $length; $i++) { 

            $repe_details=new RepeDetails();
            $repe_details->rcpe_id=$request->update_id['0'];
            $repe_details->ingredient=$request->ingredient[$i];
            $repe_details->rcpe_unit=$request->rcpe_unit[$i];
            $repe_details->source_type=$request->source_type[$i];
            $repe_details->source_address=$request->source_address[$i];
            $repe_details->qty=$request->qty[$i];
            $repe_details->percentage=$request->percentage[$i];
            $repe_details->wqty=$request->wqty[$i];
            $repe_details->rate=$request->rate[$i];
            $repe_details->save();
        }
        Session::flash("success", "Added Succcessfully !");
        return redirect("/recipe");

    }
}
