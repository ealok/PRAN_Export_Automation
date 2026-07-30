<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CiItem;
use Session;
use DB;
use App\ItemGroup;
use App\AssignItemClaim;
use App\IndiaItemGorupAssign;
class ItemGroupAssignController extends Controller
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
        // $results=DB::select("SELECT
        //         ci_items.id,
        //         ci_items.ci_item_name,
        //         ci_items.ci_item_code,
        //         item_groups.item_group_name
        //     FROM
        //         ci_items
        //     LEFT JOIN item_groups ON item_groups.id=ci_items.item_group_id
        //     ORDER BY item_groups.item_group_name DESC");

        $results=DB::select("SELECT
                    ci_items.id,
                    ci_items.duplicate_name,
                    ci_items.ci_item_name,
                    ci_items.ci_item_code,
                    item_groups.item_group_name,
                    rcpe.name AS rcpe_name,
                    ci_item_claims.ci_item_claim_name as claim_name,
                    ci_item_claims.ci_item_claim_percentage AS claim_percentage,
                    CASE WHEN ci_items.item_group_id = 236 THEN 'Not Eligible' ELSE 'Eligible' END AS status
                FROM
                    ci_items
                LEFT JOIN item_groups ON item_groups.id = ci_items.item_group_id
                LEFT JOIN rcpe_masters ON rcpe_masters.id=ci_items.receipe_id
                LEFT JOIN rcpe ON rcpe.id=rcpe_masters.rcpe_fg_id
                LEFT JOIN assign_item_claims ON assign_item_claims.item_group_id=item_groups.id
                LEFT JOIN ci_item_claims ON ci_item_claims.id=assign_item_claims.ci_item_claim_id
                ORDER BY
                    ci_items.ci_item_code ASC");
        return view('item_group_assign.assign_item_group_list')->with('results', $results);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('item_group_assign.assign_item_group');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
       if ($request->hasFile('item_file')) {
            $path = $request->file('item_file')->getRealPath();
            $data = \Excel::load($path, function($reader) {  
                    })->get();     
            if (!empty($data) && $data->count()) {
                foreach ($data->toArray() as $key => $value) {

                    if (!empty($value)) {
                        
                        foreach ($value as $v) {

                            $insert[] = ['group_id' => $v['group_id'], 'item_code' => $v['item_code'], 'item_claim_group_id'=> $v['item_claim_group_id'], 'receipe_id'=> $v['receipe_id']];
                        }
                    }
                }
                $insert = array_filter(array_map('array_filter', $insert));
                foreach ($insert as $key => $values) {

                    if(isset($values['item_code'])){
                        
                        $item_code = $values['item_code'];
                        
                    }else{
                        
                         $item_code='';
                        
                    }

                    if(isset($values['group_id'])){
                        
                       $group_id = $values['group_id'];
                        
                    }else{
                        
                         $group_id='';
                        
                    }

                    if(isset($values['item_claim_group_id'])){
                        
                       $item_claim_group_id = $values['item_claim_group_id'];
                        
                    }else{
                        
                         $item_claim_group_id='';
                        
                    }

                    if(isset($values['receipe_id'])){
                        
                       $receipe_id = $values['receipe_id'];
                        
                    }else{
                        
                         $receipe_id='';
                        
                    }


                    $item_id = CiItem::where('ci_item_code',$item_code)->pluck('id');
                    \DB::table('ci_items')
                            ->where('id', $item_id)
                            ->update([
                        'item_group_id' =>$group_id,
                        'item_claim_group_id' => $item_claim_group_id,
                        'receipe_id' => $receipe_id

                        
                    ]);

                     

                }   
                
            }
        }
           
        Session::flash("success", "Updated Succcessfully !");
        return redirect("/item_group_assign");
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

        $itemGroups=ItemGroup::all();
        $ciItems=CiItem::all();
        $ciItemdetails=CiItem::findorfail($id);
        $ciItemRowDetails=CiItem::findorfail($id);
        $receipe_id=$ciItemRowDetails->receipe_id;
        $bapa_percent=$ciItemRowDetails->bapa_rate;
        $bapa_old_date=$ciItemRowDetails->bapa_old_date;
        $bapa_new_rate=$ciItemRowDetails->bapa_new_rate;
        $bapa_new_date=$ciItemRowDetails->bapa_new_date;
        $rcpes=DB::select("SELECT rcpe_masters.id,rcpe.name
            FROM rcpe_masters
            JOIN rcpe ON rcpe.id=rcpe_masters.rcpe_fg_id
            WHERE rcpe_masters.status=1");
        return view('item_group_assign.assign_item_group_edit')
                 ->with('itemGroups', $itemGroups)
                 ->with('ciItems', $ciItems)
                 ->with('ciItemdetails', $ciItemdetails)
                 ->with('rcpes',$rcpes)
                 ->with('receipe_id',$receipe_id)
                 ->with('bapa_percent',$bapa_percent)
                 ->with('bapa_old_date',$bapa_old_date)
                 ->with('bapa_new_rate',$bapa_new_rate)
                 ->with('bapa_new_date',$bapa_new_date);
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

    
        $ciItemdetails=CiItem::findorfail($id);
        $ciItemdetails->item_group_id=$request->item_group;
        $ciItemdetails->save();

        $ciItem=CiItem::findorfail($id);
        $ciItem->receipe_id=$request->recipe_id;
        $ciItem->bapa_rate=$request->bapa_percent;
        $ciItem->bapa_old_date=$request->bapa_old_date;
        $ciItem->bapa_new_rate=$request->bapa_new_rate;
        $ciItem->bapa_new_date=$request->bapa_new_date;
        $ciItem->save();
        Session::flash("success", "Updated Succcessfully !");
        return redirect("/item_group_assign");
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


    public function assignItemGroupIndia(Request $request){
        
        $results=IndiaItemGorupAssign::all();  
        return view('item_group_assign.assign_item_group_india')
               ->with('results',$results);

    }
}
