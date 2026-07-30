<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\NotifyPartyItem;
use App\NotifyPartyUser;
use App\NotifyParty;
use App\CiItem;
use App\Dunit;
use App\Runit;
use App\ProductionFloor;
use App\Depot;
use App\POMaster;
use Excel;
use DB;
class NotifyPartyItemController extends Controller{


    public function __construct(){

       $this->middleware('auth');

    }
    
    public function index(){
            
        $dunits=Dunit::all();
        $runits=Runit::all();
        $productionFloors=ProductionFloor::where('status',1)->get(); 
        $ci_items=CiItem::all();
        return view("notify_party_item.access_notify_party")
              ->with('dunits',$dunits)
              ->with('runits',$runits)
              ->with('ci_items',$ci_items)
              ->with('productionFloors',$productionFloors);
    }

   


    public function getNofityPartyItems(Request $request){
        
        $notifyParty=NotifyParty::where('code',$request->party_code)->first(['id']);
        $results=\DB::select("SELECT
                notify_party_items.id,
                ci_items.id as item_id,
                notify_parties.name,
                notify_parties.code,
                notify_party_items.acc_rate,
                notify_party_items.party_rate,
                notify_party_items.cbm_per_ctn,
                ci_items.ci_item_name,
                ci_items.ci_item_code,
                notify_party_items.desk_item_name,
                notify_party_items.fob_value,
                notify_party_items.gross_weight,
                notify_party_items.shelf_life,
                notify_party_items.coding_matter,
                notify_party_items.special_requirement,
                notify_party_items.hs_code2,
                case when ci_items.status=1 then 'Active' 
                    when ci_items.status=0 then 'Inactive' end as status,
                notify_parties.ref_name,
                production_floors.short_name
            FROM
                notify_party_items
            JOIN notify_parties ON notify_parties.id = notify_party_items.notify_party_id
            JOIN ci_items ON ci_items.id = notify_party_items.ci_item_id
            left JOIN production_floors on production_floors.id=notify_party_items.factory_id
            WHERE notify_parties.id='$notifyParty->id'");

        if($results){

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data" =>[]
            ]);

        } 

    }

    public function create(Request $request){
        
        $productionFloors=ProductionFloor::all(); 
        $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');
        $notify_parties=NotifyParty::whereIn('id',$notify_party_ids)->get();
        $ci_items=CiItem::all();
        $dunits=Dunit::all();
        $runits=Runit::all();
        $deports=Depot::all();
        return view("notify_party_item.notify_party_item_create")
             ->with("notify_parties" ,$notify_parties)
             ->with("ci_items" ,$ci_items)
             ->with('party_id', $request->party_id)
             ->with('dunits', $dunits)
             ->with('runits',$runits)
             ->with('deports',$deports)
             ->with('productionFloors', $productionFloors);
    }

    public function getCiActiveItemList(){

        $results=\DB::select("select
                  ci_items.id,
                  ci_items.ci_item_name,
                  ci_items.ci_item_code,
                  ci_items.duplicate_name,
                  ci_items.p_net_weight,
                  ci_items.factor,
                  ci_items.ci_factor,
                  ci_items.d_net_weight,
                  ci_items.d_gross_weight,
                  ci_items.ci_item_rate,
                  ci_items.hs_code
              from ci_items
              where status=1");


        if($results){
      
            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);
        
        }else{
        
            return response()->json([

                'message' => "Internal Server Error",
                "code"    => 500,
                "data"    =>[]
                
            ]);
        
        }

    }


    public function store(Request $request){

        //return $request->all();
        // $this->validate($request, [

        //    "notify_party_id"=>"required|numeric|exists:notify_parties,id",
        //    "ci_item_id"=>"required|numeric|exists:ci_items,id",
        //    "desk_item_name"=>"required|max:191",
        //    "acc_rate"=>"required|numeric",
        //    "party_rate"=>"required|numeric",
        //    "gross_weight"=>"required",
        //    "shelf_life"=>"required|numeric",
        //    "dunit_id"=>"required",
        //    "runit_id"=>"required",
        //    "factory_id"=>"required|numeric",

        // ]);

        $notifyParty=NotifyParty::where('code',$request->party_code)->first(['id']);
        if(NotifyPartyItem::where('notify_party_id',$notifyParty->id)->where('ci_item_id',$request->ci_item_id)->exists()){
 
            return response()->json([
                'msg'=>'Already exists',
                'code'=>409
            ]);

        }else{

            $notify_party_item = new NotifyPartyItem();
            $notify_party_item->notify_party_id=$notifyParty->id;
            $notify_party_item->ci_item_id=$request->ci_item_id;
            $notify_party_item->desk_item_name=$request->desk_item_name;
            $notify_party_item->acc_rate=$request->acc_rate;
            $notify_party_item->acc_rate2=$request->acc_rate;
            $notify_party_item->party_rate=$request->party_rate;
            $notify_party_item->cbm_per_ctn=$request->cbm_per_ctn;
            $notify_party_item->gross_weight=$request->gross_weight;
            $notify_party_item->shelf_life=$request->shelf_life;
            $notify_party_item->coding_matter=$request->coding_matter;
            $notify_party_item->special_requirement=$request->special_requirment;
            $notify_party_item->ingredient=trim($request->ingredient);
            $notify_party_item->dunit=$request->dunit_id;
            $notify_party_item->runit=$request->runit_id;
            $notify_party_item->factory_id=$request->factory_id;
            $notify_party_item->hs_code2=$request->hs_code2;
            $notify_party_item ->save();
            return response()->json([
                'msg'=>'Data inserted successfully',
                'code'=>200
            ]);

        }

       

        
    }



    public function edit($id, Request $request){
       
        $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');
        $notify_parties=NotifyParty::whereIn('id',$notify_party_ids)->get();
        $ci_items=CiItem::all();
        $notify_party_item = NotifyPartyItem::find($id);
        $ci_item_id = NotifyPartyItem::where('id', $id)->pluck('ci_item_id');
        $d_gross_weight=CiItem::where('id', $ci_item_id)->pluck('d_gross_weight');
        $dunits=Dunit::all();
        $runits=Runit::all();
        $productionFloors=ProductionFloor::all();
        return view("notify_party_item.notify_party_item_edit",compact("notify_party_item"))
             ->with("notify_parties" ,$notify_parties)
             ->with("ci_items" ,$ci_items)
             ->with('id', $request->id)
             ->with('d_gross_weight', $d_gross_weight)
             ->with('dunits',$dunits)
             ->with('runits',$runits)
             ->with('productionFloors', $productionFloors);
        
    }


    // private function isAlreadyExist($notify_party_id,$ci_item_id){

    //     $notify_party_item = NotifyPartyItem::where('notify_party_id',$notify_party_id)->where('ci_item_id',$ci_item_id)->first();
    //     if($notify_party_item){

    //        return 1;

    //     }else{

    //         return 0;
    //     }

    // }

    private function isAlreadyExistEdit($id,$notify_party_id,$ci_item_id){
        $notify_party_item = NotifyPartyItem::where('notify_party_id',$notify_party_id)->where('ci_item_id',$ci_item_id)->where('id','!=',$id)->first();
        if($notify_party_item){
           return 1;
        }else{
            return 0;
        }

    }

    public function update(Request $request, $id) {
         
        $this->validate($request, [
           "notify_party_id"=>"required|numeric|exists:notify_parties,id",
           "ci_item_id"=>"required|numeric|exists:ci_items,id",
           "desk_item_name"=>"required|max:191",
           "gross_weight"=>"required",
           "shelf_life"=>"required",
           "dunit_id"=>"required",
           "runit_id"=>"required",
           "factory_id"=>"required|numeric",
        ]); 

        if($this->isAlreadyExistEdit($id,$request->notify_party_id,$request->ci_item_id)){
            Session::flash("danger", "Already Exist !");
            return redirect()->back();
        }
        $notify_party_item = NotifyPartyItem::find($id);
        $notify_party_item->notify_party_id=$request->notify_party_id;
        $notify_party_item->ci_item_id=$request->ci_item_id;
        $notify_party_item->desk_item_name=$request->desk_item_name;
        if(!empty($request->acc_rate)){

           $notify_party_item->acc_rate=$request->acc_rate;
        }
        if(!empty($request->party_rate)){

           $notify_party_item->party_rate=$request->party_rate;
        }   
        $notify_party_item->cbm_per_ctn=$request->cbm_per_ctn;
        $notify_party_item->gross_weight=$request->gross_weight;
        $notify_party_item->shelf_life=$request->shelf_life;
        $notify_party_item->coding_matter=$request->coding_matter;
        $notify_party_item->special_requirement=$request->special_requirment;
        $notify_party_item->dunit=$request->dunit_id;
        $notify_party_item->runit=$request->runit_id;
        $notify_party_item->factory_id=$request->factory_id;
        $notify_party_item ->save();
        Session::flash("success", "Edited Succcessfully !");
        return redirect('notify/party/item/list/'.$request->id);
    }

    public function show($id){
        
        $notify_party_item = NotifyPartyItem::find($id); 
        return view("notify_party_item.notify_party_item_show",compact("notify_party_item"));
    }
       
    public function deletePartyItem(Request $request){

        $result=NotifyPartyItem::where('id', $request->delete_id)->delete();
        if($result) {

            return response()->json([
                'message' => "Data Deleted Successfully!",
                "code"    => 200,
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }

    }

    public function destroy($id){

        $notify_party_item = NotifyPartyItem::findOrFail($id);
        $notify_party_item ->delete();
        Session::flash("danger", "Deleted Succcessfully !");
        return redirect()->back();
    }

    public function get_item_of_notify_party(Request $request){
       
       return NotifyPartyItem::where('notify_party_id',$request->notify_party_id)
                        ->join('ci_items','ci_items.id','notify_party_items.ci_item_id')
                        ->select('ci_items.id','ci_items.ci_item_name','ci_items.ci_item_code')
                        ->where('ci_items.status','=',1)
                        ->get();



    }

    public function get_order_item_of_notify_party(Request $request){


        return $results=DB::select("SELECT
                ci_items.id AS id,
                ci_items.ci_item_name as ci_item_name,
                ci_items.ci_item_code as ci_item_code,
                ci_items.factor AS factor,
                0 as rate
            FROM
                notify_party_items
                JOIN ci_items ON ci_items.id = notify_party_items.ci_item_id
            WHERE
                notify_party_items.notify_party_id ='$request->notify_party_id'");

    }



    public function poWisePartyItem(Request $request){
           
        $po_master=POMaster::where('ID',$request->edit_po_id)->first(['PARTY_ID']);
        $results=NotifyPartyItem::where('notify_party_id',$po_master->PARTY_ID)
                        ->join('ci_items','ci_items.id','notify_party_items.ci_item_id')
                        ->select('ci_items.id','ci_items.ci_item_name','ci_items.ci_item_code')
                        ->where('ci_items.status','=',1)
                        ->get();
        return response()->json([
            'results'=>$results,
        ],200);

    }

    public function getItemFactor(Request $request){
        
        $ciItem=CiItem::where('id',$request->item_id)->first(['factor','ci_item_name']); 
        return response()->json([
           'factor'=>$ciItem->factor,
           'ci_item_name'=>$ciItem->ci_item_name
        ],200); 


    }

    public function get_item_reate_for_notify_party(Request $request){

        return  NotifyPartyItem::where('notify_party_id',$request->notify_party_id)
                        ->where('ci_item_id',$request->ci_item_id)
                        ->join('ci_items','ci_items.id','notify_party_items.ci_item_id')
                        ->select('ci_items.id','ci_items.ci_item_name','ci_items.factor','ci_items.hs_code','notify_party_items.cbm_per_ctn','ci_items.ci_item_code','notify_party_items.acc_rate','notify_party_items.party_rate','notify_party_items.desk_item_name','notify_party_items.gross_weight')
                        ->first();
     
    }

     public function copyNotifyPartyItem(Request $request){
         
        
        $fromNotifyParty=NotifyParty::where('code',$request->from_party_code)->first(['id']);
        $toNotifyParty=NotifyParty::where('code',$request->to_party_code)->first(['id']);
        $total_items=count($request->ci_item_list);
        for($i=0; $i<$total_items;$i++) { 
             
            $item_id=$request->ci_item_list[$i];
            if(NotifyPartyItem::where('notify_party_id', $toNotifyParty->id)->where('ci_item_id', $item_id)->count() === 0) {

                $notify_party_items=\DB::select("SELECT
                    ci_items.id as ci_item_id,
                    notify_party_items.desk_item_name,
                    notify_party_items.acc_rate,
                    notify_party_items.party_rate,
                    notify_party_items.cbm_per_ctn,
                    notify_party_items.notify_party_id,
                    notify_party_items.gross_weight,
                    notify_party_items.coding_matter,
                    notify_party_items.special_requirement,
                    notify_party_items.shelf_life,
                    notify_party_items.dunit,
                    notify_party_items.runit,
                    notify_party_items.factory_id
                FROM
                notify_party_items
                JOIN notify_parties ON notify_parties.id = notify_party_items.notify_party_id
                JOIN ci_items ON ci_items.id = notify_party_items.ci_item_id
                WHERE notify_party_items.notify_party_id='$fromNotifyParty->id' and notify_party_items.ci_item_id='$item_id'");

                foreach($notify_party_items as $key => $value) {

                    $notify_party_item = new NotifyPartyItem();
                    $notify_party_item->notify_party_id=$toNotifyParty->id;
                    $notify_party_item->ci_item_id=$item_id;
                    $notify_party_item->desk_item_name=$value->desk_item_name;
                    $notify_party_item->acc_rate=$value->acc_rate;
                    $notify_party_item->acc_rate2=$value->acc_rate;
                    $notify_party_item->party_rate=$value->party_rate;
                    $notify_party_item->cbm_per_ctn=$value->cbm_per_ctn;
                    $notify_party_item->gross_weight=$value->gross_weight;
                    $notify_party_item->coding_matter=$value->coding_matter;
                    $notify_party_item->special_requirement=$value->special_requirement;
                    $notify_party_item->shelf_life=$value->shelf_life;
                    $notify_party_item->dunit=$value->dunit;
                    $notify_party_item->runit=$value->runit;
                    $notify_party_item->factory_id=$value->factory_id;
                    $notify_party_item ->save(); 

                }


            }
            
        }
        
        return response()->json([
            'msg'=>'Copy successfully done',
            'code'=>200
        ]);
   

    }

    public function partyItemEditDetails(Request $request){

        $notifyPartyItem=NotifyPartyItem::findorfail($request->edit_id);
        $dunits=Dunit::all();  
        $runits=Runit::all();  
        $productionFloors=ProductionFloor::where('status',1)->get();
        $notifyParty=NotifyParty::all();
        $ciItem=CiItem::where('id',$notifyPartyItem->ci_item_id)->first(['id','ci_item_name','ci_item_code']);
        $partyItems=DB::select("SELECT
                ci_items.id,
                ci_items.ci_item_code,
                ci_items.ci_item_name
            FROM
                notify_party_items
                JOIN ci_items ON ci_items.id = notify_party_items.ci_item_id
            WHERE notify_party_items.notify_party_id='$notifyPartyItem->notify_party_id'");
        return response()->json([
            'notifyPartyItem' => $notifyPartyItem,
            'dunits'=>$dunits,
            'runits'=>$runits,
            'productionFloors'=>$productionFloors,
            'notifyParty'=>$notifyParty,
            'partyItems'=>$partyItems
        ]);

    }

    public function getItemGrossWeight(Request $request){

        $item=CiItem::where('id', $request->ci_item_id)->first(['d_gross_weight']);   
        $cbm=0;
        if(NotifyPartyItem::where('notify_party_id',NotifyParty::where('code',$request->party_code)->value('id'))->where('ci_item_id',$request->ci_item_id)->count()>0){

            $partyItem=NotifyPartyItem::where('notify_party_id',NotifyParty::where('code',$request->party_code)->value('id'))->where('ci_item_id',$request->ci_item_id)->first(['cbm_per_ctn']);
            $cbm=$partyItem->cbm_per_ctn;
        }
        
        return response()->json([
            'gross_weight'=>$item->d_gross_weight,
            'cbm'=>$cbm
        ]);

    }

     public function updatePartyItems(Request $request){

        $notify_party_item = NotifyPartyItem::findorfail($request->edit_id);
        $notify_party_item->notify_party_id=$request->notify_party_id;
        $notify_party_item->ci_item_id=$request->ci_item_id;
        $notify_party_item->desk_item_name=$request->desk_item_name;
        $notify_party_item->acc_rate=$request->acc_rate;
        $notify_party_item->party_rate=$request->party_rate;
        $notify_party_item->cbm_per_ctn=$request->cbm_per_ctn;
        $notify_party_item->gross_weight=$request->gross_weight;
        $notify_party_item->shelf_life=$request->shelf_life;
        $notify_party_item->coding_matter=$request->coding_matter;
        $notify_party_item->special_requirement=$request->special_req;
        $notify_party_item->ingredient=trim($request->ingredient);
        $notify_party_item->dunit=$request->dunit_id;
        $notify_party_item->runit=$request->runit_id;
        $notify_party_item->factory_id=$request->factory_id;
        $notify_party_item->hs_code2=$request->hs_code2;
        $notify_party_item ->save();
        return response()->json([
            'msg'=>'Updated successfully done',
            'code'=>200
        ]);         

     }

     public function partyItemUpload(){

        return view('notify_party.notify_party_price_update');
 
    } 
    
    public function partyItemInclude(Request $request){

        $formated_file = $request->file('file');  
        $path = $formated_file->getRealPath();
        $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
        $this->includeItems($datas);
        Session::flash("success", "Upload Succcessfully !");
        return redirect("/notify_party_excel/upload_view");      
  
  
    }
  
    private function includeItems($datas){
  
        foreach ($datas as $key => $value){
             
            if(!empty($value->party_code)){
  
                $notifyPartyId=NotifyParty::where('code',$value->party_code)->first(['id']);
                $itemId=CiItem::where('ci_item_code',$value->item_code)->first(['id']);
                if(NotifyPartyItem::where('notify_party_id',$notifyPartyId->id)->where('ci_item_id',$itemId->id)->exists()){
                     
                      NotifyPartyItem::where('notify_party_id',$notifyPartyId->id)->where('ci_item_id',$itemId->id)->update([
                          'acc_rate'=>$value->acc_rate,
                          'party_rate'=>$value->party_rate
                      ]);
  
                }
  
            } 
  
        }
       
    }

    public function managePartyItems(Request $request){
           
        return view('notify_party.manage_party_items');

    }

    public function uploadPartyItems(Request $request){
         
        $formated_file = $request->file('excel_file');
        $path = $formated_file->getRealPath();
        $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
        return $this->uploadItems($datas);
        
    }

    private function uploadItems($datas)
    {

        $user_id = Auth::user()->id;  
        $errors = []; // collect errors
        foreach ($datas as $key => $value) {

            $notifyPartyId = NotifyParty::where('code',trim($value->party_code))->value('id'); 
            $ciItem = CiItem::where('ci_item_code',$value->item_code)->first();
            $factory_id=ProductionFloor::where('short_name',$value->factroy)->value('id');
            if (!$notifyPartyId) {
                $errors[] = "Row ".($key+1).": Party code '{$value->party_code}' not found.";
                continue;
            }
            if (!$ciItem) {
                $errors[] = "Row ".($key+1).": Item code '{$value->item_code}' not found.";
                continue;
            }

            $dunitId = Dunit::where('dunit_name', 'like', '%' . $value->dunit . '%')->value('id');
            $runitId = Runit::where('runit_name', 'like', '%' . $value->runit . '%')->value('id');

            if (!$dunitId) {
                $errors[] = "Row ".($key+1).": Dunit '{$value->dunit}' not found.";
            }
            if (!$runitId) {
                $errors[] = "Row ".($key+1).": Runit '{$value->runit}' not found.";
            }

            if (!$dunitId || !$runitId) {
                continue;
            }

            $existing = NotifyPartyItem::where('notify_party_id',$notifyPartyId)
                ->where('ci_item_id',$ciItem->id)->first();

            if (!$existing) {
                $notify_party_item = new NotifyPartyItem();
                $notify_party_item->notify_party_id = $notifyPartyId;
                $notify_party_item->ci_item_id = $ciItem->id;
                $notify_party_item->desk_item_name = $ciItem->ci_item_name;
                $notify_party_item->acc_rate = $value->acc_rate;
                $notify_party_item->party_rate = $value->party_rate;
                $notify_party_item->cbm_per_ctn = $value->cbm;
                $notify_party_item->gross_weight = $value->gross_weight;
                $notify_party_item->coding_matter = $value->coding_matter;
                $notify_party_item->special_requirement = $value->special_requirement;
                $notify_party_item->shelf_life = $value->shelf_life;
                $notify_party_item->dunit = $dunitId;
                $notify_party_item->runit = $runitId;
                $notify_party_item->factory_id = $factory_id;
                $notify_party_item->hs_code2 = $value->hs_code;
                $notify_party_item->save();
            } else {
                $updateData = [
                    'party_rate' => $value->party_rate,
                    'cbm_per_ctn' => $value->cbm,
                    'gross_weight' => $value->gross_weight,
                    'coding_matter' => $value->coding_matter,
                    'special_requirement' => $value->special_requirement,
                    'dunit' => $dunitId,
                    'runit' => $runitId,
                    'factory_id' => $factory_id,
                    'hs_code2' => $value->hs_code
                ];
                $existing->update($updateData);
            }
        }

        if (count($errors) > 0) {
            return response()->json([
                'status' => 'error',
                'errors' => $errors
            ], 422);
        }

        return response()->json(['status' => 'success', 'message' => 'Upload successfully done !']);
    }

    public function searchCiItem(Request $request)
    {
        $search = $request->get('search');
        $items = CiItem::where(function($query) use ($search) {
                $query->where('ci_item_code', 'LIKE', "%{$search}%")
                    ->orWhere('ci_item_name', 'LIKE', "%{$search}%");
            })
            ->limit(50) // Limit results for performance
            ->get(['id', 'ci_item_code', 'ci_item_name']);
        
        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }

}