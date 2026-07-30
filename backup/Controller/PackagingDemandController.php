<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Item;
use DB;
use App\SmvType;
use Session;
use App\Order;
use App\PackagingDemandEntry;
use Response;
use App\PackagingTranster;
use App\OrderDetail;
use App\Unit;
use App\Shift;
use App\User;
use App\employee;
use App\Warehouse;
use App\PackingToMaster;
use App\PackingToDetails;
use App\PackingTransferMaster;
use App\PackingTransferDetail;
use App\PackingTiFromToMaster;
use App\PackingTiFromToDetail;
use App\Rack;
use App\Danish;
class PackagingDemandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {  

        $smvTypes=SmvType::all();  
        $conveyers=\DB::select("SELECT * FROM conveyors");
        $times=\DB::select("SELECT * FROM times");
        $orders=Order::all();
        $items=Item::all();
        $users=User::all();
        $packagingDemandEntries=PackagingDemandEntry::where('item_id', $request->item_id)->orderBy('id','Desc')->paginate(20);
        $results=DB::select("SELECT
            SUM(tbl.ct_in_sec) AS ct_in_sec, 
            SUM(tbl.no_of_hr) AS total_no_of_hr,
            SUM(tbl.smv) AS smv,
            ROUND(SUM(tbl.no_of_hr)*60/(SUM(tbl.ct_in_sec)/60),3) AS target_per_hr,
            ROUND(((SUM(tbl.no_of_hr)*60)/(SUM(tbl.ct_in_sec)/60))*12,3) AS target_per_shift
        FROM
            (
            SELECT
                smv_master.item_id,
                smv_details.no_of_hr,
                smv_details.ct_in_sec,
                ROUND(smv_details.ct_in_sec / 60, 3) AS smv,
                ROUND(
                    (smv_details.no_of_hr * 60) /(smv_details.ct_in_sec / 60),
                    3
                ) AS target_per_hr,
                ROUND(
                    (smv_details.no_of_hr * 60) /(smv_details.ct_in_sec / 60),
                    3
                ) * 12 AS target_per_shift
            FROM
                smv_master
            JOIN smv_details ON smv_details.master_id = smv_master.id
            WHERE
                smv_master.item_id = '$request->item_id'
        ) tbl
        GROUP BY
            tbl.item_id");
        if(count($results)>0){
           
           foreach ($results as $key => $value) {

           $ct_in_sec=$value->ct_in_sec;
           $total_no_of_hr=$value->total_no_of_hr;
           $smv=$value->smv;
           $target_per_hr=$value->target_per_hr;
           $target_per_shift=$value->target_per_shift;          
        }
       
      }else{

           $ct_in_sec='';
           $total_no_of_hr='';
           $smv='';
           $target_per_hr='';
           $target_per_shift='';

        }
       $units=Unit::all();
       $shifts=Shift::all();
       $employees=DB::select("SELECT employees.id,employees.name,units.name as unit_name
                    FROM employees
                    JOIN units ON units.id=employees.unit_id
                    GROUP BY employees.id,employees.name,units.name
                    ORDER BY units.name DESC");

        return view('smv.packaging_demand_entry')
               ->with('items', $items)
               ->with('smvTypes', $smvTypes)
               ->with('conveyers', $conveyers)
               ->with('times', $times)
               ->with('orders', $orders)
               ->with('packagingDemandEntries',$packagingDemandEntries)
               ->with('ct_in_sec', $ct_in_sec)
               ->with('total_no_of_hr', $total_no_of_hr)
               ->with('smv', $smv)
               ->with('target_per_hr', $target_per_hr)
               ->with('target_per_shift', $target_per_shift)
               ->with('smv_type_id', $request->smv_type_id)
               ->with('order_id', $request->order_id)
               ->with('item_id', $request->item_id)
               ->with('units',$units)
               ->with('shifts',$shifts)
               ->with('users',$users)
               ->with('employees',$employees);


    }
     
    public function jsonGetPackingDetils(Request $request,$id){

        $orderDetails=OrderDetail::where('id',$id)->first(); 
        $item_id=$orderDetails->item_id;
        $results=DB::select("SELECT
            SUM(tbl.ct_in_sec) AS ct_in_sec, 
            SUM(tbl.no_of_hr) AS total_no_of_hr,
            SUM(tbl.smv) AS smv,
            ROUND(SUM(tbl.no_of_hr)*60/(SUM(tbl.ct_in_sec)/60),3) AS target_per_hr,
            ROUND(((SUM(tbl.no_of_hr)*60)/(SUM(tbl.ct_in_sec)/60))*12,3) AS target_per_shift
        FROM
            (
            SELECT
                smv_master.item_id,
                smv_details.no_of_hr,
                smv_details.ct_in_sec,
                ROUND(smv_details.ct_in_sec / 60, 3) AS smv,
                ROUND(
                    (smv_details.no_of_hr * 60) /(smv_details.ct_in_sec / 60),
                    3
                ) AS target_per_hr,
                ROUND(
                    (smv_details.no_of_hr * 60) /(smv_details.ct_in_sec / 60),
                    3
                ) * 12 AS target_per_shift
            FROM
                smv_master
            JOIN smv_details ON smv_details.master_id = smv_master.id
            WHERE
                smv_master.item_id = '$item_id'
        ) tbl
        GROUP BY tbl.item_id");
        
        return response()->json($results);

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

    public function packagingTranserView(Request $request){
       
       $orders=Order::all();
       $fWhs=Warehouse::all();
       return view('smv.packaging_transfer')
             ->with('orders',$orders)
             ->with('fWhs',$fWhs);

    }

    public function packagingStockGeneration(Request $request){
       
        $orders=Order::all();
        $fWhs=Warehouse::all();
        return view('smv.packing_stock_generation')
              ->with('orders',$orders)
              ->with('fWhs',$fWhs);
 
     }

    public function jsonGetTotalToQty(Request $request){
       
       return $request->all(); 
        

    }

    public function jsonGetPackagingQty(Request $request){
       
      $packingQty=PackagingDemandEntry::where('item_id','=',$request->item_id)->where('order_id',$request->order_id)->sum('demand_quantity'); 
      $results=DB::select("SELECT SUM(packing_to_details.tr_qty) AS tr_qty
        FROM packing_to_masters
        JOIN packing_to_details ON packing_to_details.master_id=packing_to_masters.id
        WHERE packing_to_masters.from_wh_id='$request->form_wh_id' 
        AND packing_to_details.order_id='$request->order_id' 
        AND packing_to_details.item_id='$request->item_id'");

      $tr_qty=$results[0]->tr_qty;
      $due_qty=$packingQty-$tr_qty;
      return response()->json(['due_qty'=>$due_qty]); 


    }

    public function packagingTranster(Request $request){
      
      $packagingTranster=new PackagingTranster();
      $packagingTranster->order_id=$request->order_id;
      $packagingTranster->item_id=$request->item_id;
      $packagingTranster->transfer_qty=$request->transfer_qty;
      $packagingTranster->creator_id=Auth::user()->id;
      $packagingTranster->save();
      Session::flash("success", "Edited Succcessfully !");
      return redirect("/packaging_transer/view");



    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
    
        $items=Item::all();
        $smvTypes=SmvType::all();  
        $conveyers=\DB::select("SELECT * FROM conveyors");
        $times=\DB::select("SELECT * FROM times");
        $packagingDemand=PackagingDemandEntry::findorfail($id);
        return view('smv.packaging_demand_edit')
               ->with('items', $items)
               ->with('smvTypes', $smvTypes)
               ->with('conveyers', $conveyers)
               ->with('times', $times)
               ->with('smv_id', $request->smv_id)
               ->with('packagingDemand', $packagingDemand);


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
        
         DB::table('packaging_demand_entries')
                ->where('id', $id)
                ->update([
            'conveyor_id' => $request->conveyor_id,
            'time_id' => $request->time_id,
            'demand_quantity' => $request->demand_quantity,
            'actual_hr'=>$request->actual_hr,
            'remark'=>$request->remark

        ]);
        
        Session::flash("success", "Edit Succcessfull..!");
        return redirect()->back(); 

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

    public function packagingDemandEditView(Request $request){
         

        $orders=Order::all();
        $item_id=OrderDetail::where('id',$request->item_id)->value('item_id');
        $packagingDemandEntries=PackagingDemandEntry::where('item_id', $item_id)->orderBy('id','Desc')->paginate(20);
        return view('smv.packaging_edit')
               ->with('orders',$orders)
               ->with('packagingDemandEntries',$packagingDemandEntries);
      
    }

    public function storePackagingToHistory(Request $request){
        $to_no='';
        $packingToMaster=new PackingToMaster();
        $packingToMaster->from_wh_id=$request->form_wh_id;
        $packingToMaster->to_wh_id=$request->to_wh_id;
        $packingToMaster->date=date("Y-m-d", strtotime($request->create_date));
        $packingToMaster->user_id=Auth::user()->id;
        $packingToMaster->remak=$request->remark;
        $packingToMaster->transfer_type=$request->transfer_type;
        $packingToMaster->save();
        $packingToMaster->transfer_no = $request->transfer_type.date('dmY').$packingToMaster->id;
        $packingToMaster ->save();
        
        for($i=0; $i<sizeof($request->to_details); $i++) {
           
            $packingDetails=new PackingToDetails();
            $packingDetails->master_id=$packingToMaster->id;
            $packingDetails->order_id=$request->to_details[$i]['order_id'];
            $packingDetails->item_id=$request->to_details[$i]['item_id'];
            $packingDetails->pk_qty=$request->to_details[$i]['pk_qty'];
            $packingDetails->tr_qty=$request->to_details[$i]['tr_qty'];
            $packingDetails->save();

        }
        $to_no=$request->transfer_type.date('dmY').$packingToMaster->id;

        return response()->json(['status'=>'Success','to_no'=>$to_no]);

    }

    public function storeGenerationStock(Request $request){
         
        $to_no='';
        $packingToMaster=new PackingToMaster();
        $packingToMaster->from_wh_id=$request->form_wh_id;
        $packingToMaster->to_wh_id=$request->to_wh_id;
        $packingToMaster->date=date("Y-m-d", strtotime($request->create_date));
        $packingToMaster->user_id=Auth::user()->id;
        $packingToMaster->remak=$request->remark;
        $packingToMaster->transfer_type=$request->transfer_type;
        $packingToMaster->save();
        $packingToMaster->transfer_no = $request->transfer_type.date('dmY').$packingToMaster->id;
        $packingToMaster ->save();
        
        for($i=0; $i<sizeof($request->to_details); $i++) {
           
            $packingDetails=new PackingToDetails();
            $packingDetails->master_id=$packingToMaster->id;
            $packingDetails->order_id=$request->to_details[$i]['order_id'];
            $packingDetails->item_id=$request->to_details[$i]['item_id'];
            $packingDetails->pk_qty=$request->to_details[$i]['pk_qty'];
            $packingDetails->tr_qty=$request->to_details[$i]['tr_qty'];
            $packingDetails->save();

        }
        $to_no=$request->transfer_type.date('dmY').$packingToMaster->id;

        return response()->json(['status'=>'Success','to_no'=>$to_no]);

    }

    public function packagingTransferTI(Request $request){
        
        $fWhs=Warehouse::all();
        $racks=Rack::all();
        return view('smv.packaging_transfer_ti')
              ->with('fWhs',$fWhs)
              ->with('racks',$racks);
    }

    public function packingPendingTrnList(Request $request){
          
        $results=PackingToMaster::where('to_wh_id',$request->warehouse_id)->where('status',0)->get();
        $racks=Rack::where('warehouse_id',$request->warehouse_id)->get();
        return response()->json(['result'=>$results,'racks'=>$racks]);

    }

    public function packingPackingTrnDetails(Request $request){

        $results=DB::select("SELECT
            packing_to_masters.transfer_no AS trn_no,
            CONCAT(items.code, '-', items.name) AS Item,
            packing_to_details.pk_qty AS pk_qty,
            packing_to_details.tr_qty AS tr_qty
        FROM
            packing_to_masters
        JOIN packing_to_details ON packing_to_details.master_id = packing_to_masters.id
        JOIN order_details ON order_details.id=packing_to_details.item_id
        JOIN items ON items.id = order_details.item_id
        WHERE packing_to_masters.id='$request->trn_id' and packing_to_masters.status=0"); 
        
        return response()->json(['results'=>$results]);
     
    }

    public function jsonPackagingRackDanish(Request $request){


            
        $danishes=\DB::select("SELECT t.id,t.full_rack_name,SUM(due_qty) as due_qty
            FROM(
                (SELECT danishes.id,
                danishes.full_rack_name,
                0 as due_qty
                FROM danishes
                JOIN racks ON racks.id=danishes.rack_id
                WHERE racks.id='$request->rack_id')
            UNION ALL
                (SELECT
                packing_transfer_masters.danish_id,
                danishes.full_rack_name,
                SUM(packing_transfer_details.due_qty) AS due_qty
                FROM
                packing_transfer_masters
                JOIN packing_transfer_details ON packing_transfer_details.master_id = packing_transfer_masters.id
                JOIN danishes ON danishes.id=packing_transfer_masters.danish_id
                WHERE packing_transfer_masters.rack_id='$request->rack_id'
                GROUP BY packing_transfer_masters.rack_id, packing_transfer_masters.danish_id,danishes.full_rack_name)) AS t
            GROUP BY t.id,t.full_rack_name");
        return response()->json(['danishes'=>$danishes]);           

    }


    public function storePackagingTiHistory(Request $request){
 
        $trnExistOrNot=PackingTransferMaster::where('transfer_no',$request->trn_no)->first();

        if(is_null($trnExistOrNot)){
            
            $ti_number='';
            $packingMasters=PackingToMaster::where('transfer_no',$request->trn_no)->first(['transfer_no','from_wh_id','to_wh_id']);
            $packingTransferMaster=new PackingTransferMaster();
            $packingTransferMaster->transfer_no=$packingMasters->transfer_no;
            $packingTransferMaster->transfer_type='TI';
            $packingTransferMaster->from_wh_id=$packingMasters->from_wh_id;
            $packingTransferMaster->to_wh_id=$packingMasters->to_wh_id;
            $packingTransferMaster->rack_id=$request->rack_id;
            $packingTransferMaster->danish_id=$request->danish_id;
            $packingTransferMaster->remak=$request->remark;
            $packingTransferMaster->user_id=Auth::user()->id;
            $packingTransferMaster->save();
            $packingTransferMaster->ti_number = 'TI'.date('dmY').$packingTransferMaster->id;
            $ti_number='TI'.date('dmY').$packingTransferMaster->id;
            $packingTransferMaster ->save();

            $results=\DB::select("SELECT
                packing_to_details.order_id as order_id,
                packing_to_details.item_id AS item_id,
                packing_to_details.pk_qty AS pk_qty,
                packing_to_details.tr_qty AS tr_qty
            FROM
                packing_to_masters
            JOIN packing_to_details ON packing_to_details.master_id = packing_to_masters.id
            WHERE
                packing_to_masters.transfer_no = '$packingMasters->transfer_no'");

            foreach($results as $result){
               
                $packingTransferDetails=new PackingTransferDetail();
                $packingTransferDetails->master_id=$packingTransferMaster->id;
                $packingTransferDetails->order_id=$result->order_id;
                $packingTransferDetails->item_id=$result->item_id;
                $packingTransferDetails->pk_qty=$result->pk_qty;
                $packingTransferDetails->tr_qty=$result->tr_qty;
                $packingTransferDetails->ti_qty=$result->tr_qty;
                $packingTransferDetails->due_qty=$result->tr_qty;
                $packingTransferDetails->save();

            }

            PackingToMaster::where('transfer_no',$packingMasters->transfer_no)
                ->update(['approve_id'=>Auth::user()->id,'status'=>1]);
            
            return response()->json(['status'=>'Success', 'ti_no'=>$ti_number]); 

        }else{
           
            return 'Exist'; 

        }

            
    }

    public function packagingTransferTO(){
        
        $orders=Order::all();
        $fWhs=Warehouse::all();
        return view('smv.packaging_transfer_to')
              ->with('orders',$orders)
              ->with('fWhs',$fWhs); 

    }

    public function jsonPackagingTiDetails(Request $request){

        $results=DB::select("SELECT
            order_details.id AS item_id,
            items.name AS item,
            racks.id as rack_id,
            racks.rack_number AS rack,
            danishes.id AS danish_id,
            danishes.full_rack_name AS danish,
            SUM(packing_transfer_details.ti_qty) AS ti_qty,
            SUM(packing_transfer_details.`due_qty`) AS due_qty,
            0 AS tr_qty
        FROM
            packing_transfer_masters
        JOIN packing_transfer_details ON packing_transfer_details.master_id=packing_transfer_masters.id
        JOIN order_details ON order_details.id=packing_transfer_details.item_id
        JOIN items ON items.id = order_details.item_id
        JOIN danishes ON danishes.id = packing_transfer_masters.danish_id
        JOIN racks ON racks.id = packing_transfer_masters.rack_id
        WHERE packing_transfer_details.order_id='$request->order_id' AND packing_transfer_masters.to_wh_id='$request->form_wh_id' AND packing_transfer_details.due_qty !=0
        GROUP BY items.name,racks.rack_number,danishes.full_rack_name,order_details.id,racks.id,danishes.id");

        if(count($results)>0){
        
           return response()->json(['results'=>$results]);
  
        }else{

            return response()->json(['no_result'=>$results]); 

        }
         

    }

    public function storePackingToFromTIHistory(Request $request){
          
        $packingTIFromTO=new PackingTiFromToMaster();
        $packingTIFromTO->from_wh_id=$request->form_wh_id;
        $packingTIFromTO->to_wh_id=$request->to_wh_id;
        $packingTIFromTO->date=date("Y-m-d", strtotime($request->create_date));
        $packingTIFromTO->user_id=Auth::user()->id;
        $packingTIFromTO->remak=$request->remark;
        $packingTIFromTO->transfer_type=$request->transfer_type;
        $packingTIFromTO->ti_number=1;
        $packingTIFromTO->save();
        $packingTIFromTO->transfer_no = $request->transfer_type.date('dmY').$packingTIFromTO->id;
        $packingTIFromTO ->save();

        for($i=0; $i<sizeof($request->to_details); $i++) {
           
            $packingTiFromTODetail=new PackingTiFromToDetail();
            $packingTiFromTODetail->master_id=$packingTIFromTO->id;
            $packingTiFromTODetail->order_id=$request->order_id;
            $packingTiFromTODetail->item_id=$request->to_details[$i]['item_id'];
            $packingTiFromTODetail->rack_id=$request->to_details[$i]['rack_id'];
            $packingTiFromTODetail->danish_id=$request->to_details[$i]['danish_id'];
            $packingTiFromTODetail->ti_qty=$request->to_details[$i]['ti_qty'];
            $packingTiFromTODetail->due_qty=$request->to_details[$i]['due_qty'];
            $packingTiFromTODetail->tr_qty=preg_replace("<<br>>", "", $request->to_details[$i]['tr_qty']);
            $packingTiFromTODetail->save();
            $this->updateTransferQty($request->form_wh_id,$request->order_id,$request->to_details[$i]['item_id'],$request->to_details[$i]['rack_id'],$request->to_details[$i]['danish_id'],preg_replace("<<br>>", "", $request->to_details[$i]['tr_qty']));

        }
        return response()->json(['status'=>'Success']);


    }

    public function updateTransferQty($form_wh_id,$order_id,$item_id,$rack_id,$danish_id,$tr_qty){

        $results=DB::select("SELECT
                packing_transfer_details.id,
                packing_transfer_details.due_qty
            FROM
                packing_transfer_masters
            JOIN packing_transfer_details ON packing_transfer_details.master_id = packing_transfer_masters.id
            WHERE
                packing_transfer_masters.to_wh_id = $form_wh_id
                AND packing_transfer_details.order_id=$order_id
                AND packing_transfer_masters.rack_id = $rack_id
                AND packing_transfer_details.item_id = $item_id
                AND packing_transfer_masters.danish_id = $danish_id");
        
        foreach($results as $result){
              
            if($result->due_qty > $tr_qty && $tr_qty!=0){    


                PackingTransferDetail::where('id',  $result->id)->update(['due_qty' => $result->due_qty-$tr_qty]);
                $tr_qty = 0;  
              
            }elseif($result->due_qty < $tr_qty && $tr_qty!=0){ 
                
                $tr_qty= $tr_qty-$result->due_qty; 
                PackingTransferDetail::where('id',  $result->id)->update(['due_qty' =>0]);
                
            }
            elseif($result->due_qty == $tr_qty && $tr_qty!=0){

                $tr_qty = 0;   
                PackingTransferDetail::where('id',  $result->id)->update(['due_qty' =>0]);
            
            }
                         
        }

        

    }
    
    public function fgInventoryReport(Request $request){
         
        $warehouses = Warehouse::all();
        $orders=Order::all();
        return view("smv.fgInventoryReport")
        ->with('warehouses',$warehouses)
        ->with('orders',$orders);
        
    }

    public function jsonGetDanishStock(Request $request){
            
        // $p1=$request->warehouse_id;
        // $results=DB::select('call FG_STOCK(?)',array($p1));

        $from_date=date("Y-m-d", strtotime($request->from_date));
        $to_date=date('Y-m-d', strtotime($request->to_date.' + 1 days'));

        $where = "(t1.created_at >= '$from_date' and t1.created_at <= '$to_date')";
        
        if($request->order_id!='All'){

            $where.=" and t5.id=$request->order_id";
           
        }
        
        if($request->item_id!='All'){
           
            $where.=" and t3.id=$request->item_id";   

        }
        
        if($request->warehouse_id!='All'){
            
            $where.=" and t6.id=$request->warehouse_id";
        }
        
        if($request->rack_id!='All'){
            
            $where.=" and t8.id=$request->rack_id";
            
        }
            
        $results=DB::select("SELECT
                t1.Order_no                       as `order`,
                t1.Item_code                      as code,
                t1.Item_name                      as item,
                t1.Wh_name                        as wh,
                t1.rack                           as rack,
                t1.danish                         as danish,
                SUM(t1.Ti_qty)                    as ti_Qty,
                SUM(t1.To_qty)                    as to_qty,
                (SUM(t1.Ti_qty) - SUM(t1.To_qty)) as due_Qty
            from ((select
                    t5.order_no       as Order_no,
                    t4.code           as Item_code,
                    t4.name           as Item_name,
                    t6.name           as Wh_name,
                    t7.full_rack_name as danish,
                    t8.rack_number    as rack,
                    SUM(t2.ti_qty)    as Ti_qty,
                    0                 as To_qty
                    from packing_transfer_masters as t1
                    join packing_transfer_details t2 on t2.master_id = t1.id
                    join order_details t3 on t3.id = t2.item_id
                    join items t4 on t4.id = t3.item_id
                    join orders t5 on t5.id = t2.order_id
                    join warehouses t6 on t6.id = t1.to_wh_id
                    join danishes t7 on t7.id = t1.danish_id
                    join racks t8 on t8.id = t1.rack_id
                    where $where
                    group by t5.order_no, t4.code, t4.name, t6.name, t7.full_rack_name, t8.rack_number
                    order by t5.order_no, t4.code, t4.name, t6.name, t7.full_rack_name, t8.rack_number)
                    union all
                    (select
                    t5.order_no       as Order_no,
                    t4.code           as Item_code,
                    t4.name           as Item_name,
                    t6.name           as Wh_name,
                    t7.full_rack_name as danish,
                    t8.rack_number    as rack,
                    0                 as Ti_qty,
                    SUM(t2.tr_qty)    as To_qty
                    from packing_ti_from_to_masters t1
                    join packing_ti_from_to_details t2 on t2.master_id = t1.id
                    join order_details t3 on t3.id = t2.item_id
                    join items t4 on t4.id = t3.item_id
                    join orders t5 on t5.id = t2.order_id
                    join warehouses t6 on t6.id = t1.from_wh_id
                    join danishes t7 on t7.id = t2.danish_id
                    join racks t8 on t8.id = t2.rack_id
                    where $where
                    group by t5.order_no, t4.code, t4.name, t6.name, t7.full_rack_name, t8.rack_number
                    order by t5.order_no, t4.code, t4.name, t6.name, t7.full_rack_name, t8.rack_number)) as t1
            group by t1.Order_no, t1.Item_code, t1.Item_name, t1.Wh_name, t1.rack, t1.danish");
        
        
        return response()->json(['result'=>$results]);        

    }

    public function getFgPendingToReport(Request $request){

        $warehouses = Warehouse::all();
        return view("smv.packing_pending_to_list")->with('warehouses',$warehouses);

    }

    public function packingPendingTOReport(Request $request){
     
        $result=DB::select("SELECT
            packing_to_masters.transfer_no AS trn_no,
            SUM(packing_to_details.tr_qty) AS qty
        FROM
            packing_to_masters
        JOIN packing_to_details ON packing_to_details.master_id = packing_to_masters.id
        WHERE packing_to_masters.to_wh_id='$request->warehouse_id' AND packing_to_masters.status=0
        GROUP BY packing_to_masters.transfer_no");

        return response()->json(['result'=>$result]);  

    }

    public function jsonGetWarehouseRack(Request $request){
       
        $results=Rack::where('warehouse_id',$request->warehouse_id)->get();
        return response()->json(['results'=>$results]); 
        
    }
    

}
