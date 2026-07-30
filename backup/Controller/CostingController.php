<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Order;
use App\CiItem;
use App\NotifyParty;
use App\SalesTerm;
use App\ContainerSize;
use App\ContainerCat;
use App\Location;
use App\CostingMaster;
use App\CostingDetails;
use App\PrimeCost;
use App\NotifyPartyItem;
use App\CarryingChg;
use Auth;
use DB;
use App\Bu;
use Excel;
class CostingController extends Controller
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
    
        $items=CiItem::select('ci_item_code','ci_item_name')->get();
        $sales_term=SalesTerm::whereNotIn('id',[4,5,6])->get();
        $container_size=ContainerSize::all();
        $container_cat=ContainerCat::all();
        $locations=Location::select('name','id')->get();
        $parties = NotifyParty::select('code','name')->get();
        return view('costing.index')
               ->with('parties',$parties)
               ->with('items',$items)
               ->with('sales_term',$sales_term)
               ->with('container_size',$container_size)
               ->with('container_cat',$container_cat)
               ->with('locations',$locations);

    }


    public function getAllCosting(Request $request){

        $result=DB::select("SELECT
                costing_master.id,
                notify_parties.code AS party_code,
                ci_items.ci_item_code AS item_code,
                ci_items.ci_item_name as item_name,
                costing_master.country,
                costing_master.region,
                locations.name AS loc_name,
                costing_details.conversion_rate,
                costing_master.container_size,
                ROUND(costing_details.per_piece_bd_value,2) as fob_per_piece,
                ROUND(costing_details.manual_prime_cost,2) AS prime_cost_bdt,
                ROUND(costing_details.per_piece_bd_value*costing_master.pcs_per_ctn,2) AS rate_per_ctn,
                ROUND(costing_details.total_cost_bdt,2) AS total_cost_bdt,
                costing_details.gp_percentage,
                COALESCE(costing_details.last_updated_date,'') AS last_updated_date,
                costing_master.approve
                FROM costing_master
                JOIN costing_details ON costing_details.master_id = costing_master.id
                JOIN notify_parties ON notify_parties.id = costing_master.party_id
                JOIN ci_items ON ci_items.id = costing_master.item_id
                LEFT JOIN locations ON locations.id = costing_master.location_id
                WHERE notify_parties.code='$request->party_code'
                ORDER BY costing_master.id DESC");

        if($result){

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $result
            ]);

        }else{

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);

        }


    }

    public function approveCosting(Request $request,$id){

        if(CostingMaster::where('id',$id)->where('approve','Y')->count()>0){
               
            return response()->json([
                'message' => "Already Approved..!!",
                "code"    => 409
            ]);

        }else{

            $costingMaster=CostingMaster::where('id',$id)->first(['party_id','item_id']);
            $costingdetails=CostingDetails::where('master_id',$id)->first(['per_piece_usd_value']);
            NotifyPartyItem::where('notify_party_id',$costingMaster->party_id)
                            ->where('ci_item_id',$costingMaster->item_id)
                            ->update([
                                'fob_value'=>$costingdetails->per_piece_usd_value   
                            ]);

            $result=CostingMaster::where('id',$id)->update([
                'approve'=>'Y'
            ]);
     
            if($result) {
    
                return response()->json([
                    'message' => "Approved Successfully Done !",
                    "code"    => 200,
                ]);
    
            } 

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
     
        //return $request->all();
        try {

            DB::beginTransaction(); 
            $costingMasterId=$this->insertCostingMaster($request);
            $this->insertCostingDetails($request,$costingMasterId); 
            DB::commit();
            return response()->json([
                'status'=>'success'
            ],200);
           
        } catch (\Exception $e) {
            
            DB::rollback();
            throw $e;

        }
        
    }

    private function insertCostingMaster($request){
        
       
        $costingMaster=new CostingMaster(); 
        $costingMaster->party_id=NotifyParty::where('code',$request->party_code)->value('id');
        $costingMaster->country=$request->country_name;
        $costingMaster->region=$request->region;
        $costingMaster->zone=$request->zone;
        $costingMaster->item_id=CiItem::where('ci_item_code',$request->item)->value('id');
        $costingMaster->bu=$request->bu;
        $costingMaster->location_id=$request->location;
        $costingMaster->sales_term=$request->sales_term;
        $costingMaster->container_size=$request->container_size;
        $costingMaster->container_category=$request->container_category;
        $costingMaster->ctn_per_container=$request->ctn_per_container;
        $costingMaster->pcs_per_container=$request->pcs_per_container;
        $costingMaster->pcs_per_ctn=$request->pcs_per_ctn;
        $costingMaster->carriage_per_container=$request->carriage_per_container=='' ? 0 : $request->carriage_per_container;
        $costingMaster->cnf_charge=$request->c_and_f_charge=='' ? 0 : $request->c_and_f_charge;
        $costingMaster->depot_exp=$request->depot_exp=='' ? 0 : $request->depot_exp;
        $costingMaster->doc_chg=$request->doc_chg=='' ? 0 : $request->doc_chg;
        $costingMaster->inside_gift_id=$request->inside_gift_id;
        $costingMaster->others_id=$request->others_id=='' ? 0 : $request->others_id;
        $costingMaster->freight_chg=$request->sales_term !='FOB' ? $request->freight_chg : 0;
        $costingMaster->ins_chg=$request->sales_term !='FOB' ? $request->ins_chg : 0;
        $costingMaster->iuser=Auth::user()->id;
        $costingMaster->idate=date("Y-m-d");
        $costingMaster->save();
        return $costingMaster->id;

    }

    private function insertCostingDetails($request,$costingMasterId){
       
        $costingDetails=new CostingDetails();
        $costingDetails->master_id=$costingMasterId;
        $costingDetails->manual_prime_cost=$request->manual_prime_cost;
        $costingDetails->prime_cost_bdt=$request->prime_cost_bdt;
        $costingDetails->prime_cost_usd=$request->prime_cost_usd;
        $costingDetails->factory_oh_percent=$request->factory_oh_percent;
        $costingDetails->factory_oh_bdt=$request->factory_oh_bdt;
        $costingDetails->factory_oh_usd=$request->factory_oh_usd;
        $costingDetails->carriage_percent=$request->carriage_percent;
        $costingDetails->carriage_percent_bdt=$request->carriage_percent_bdt;
        $costingDetails->carriage_percent_usd=$request->carriage_percent_usd;
        $costingDetails->cnf_exp_percent=$request->cnf_exp_percent;
        $costingDetails->cnf_exp_bdt=$request->cnf_exp_bdt;
        $costingDetails->cnf_exp_usd=$request->cnf_exp_usd;
        $costingDetails->depot_exp_percent=$request->depot_chg_percent;
        $costingDetails->depot_exp_bdt=$request->depot_chg_bdt;
        $costingDetails->depot_exp_usd=$request->depot_chg_usd;
        $costingDetails->collection_chg_percent=$request->collection_chg_percent;
        $costingDetails->collection_chg_bdt=$request->collection_chg_bdt;
        $costingDetails->collection_chg_usd=$request->collection_chg_usd;
        $costingDetails->insight_gift_percent=$request->insight_gift_percent;
        $costingDetails->insight_gift_bdt=$request->insight_gift_bdt;
        $costingDetails->insight_gift_usd=$request->insight_gift_usd;
        $costingDetails->others_percent=$request->others_percent;
        $costingDetails->others_bdt=$request->others_bdt;
        $costingDetails->others_usd=$request->others_usd;
        $costingDetails->total_oh_percent=$request->total_oh_percent;
        $costingDetails->total_oh_bdt=$request->total_oh_bdt;
        $costingDetails->total_oh_usd=$request->total_oh_usd;
        $costingDetails->total_cost_percent=$request->total_cost_percent;
        $costingDetails->total_cost_bdt=$request->total_cost_bdt;
        $costingDetails->total_cost_usd=$request->total_cost_usd;
        $costingDetails->gp_percentage=$request->gp_percentage;
        $costingDetails->gp_bdt=$request->gp_bdt;
        $costingDetails->gp_usd=$request->gp_usd;
        $costingDetails->per_piece_percent_value=$request->per_piece_percent_value;
        $costingDetails->per_piece_bd_value=$request->per_piece_bd_value;
        $costingDetails->per_piece_usd_value=$request->per_piece_usd_value;
        $costingDetails->fob_in_bdt=$request->fob_in_bdt;
        $costingDetails->fob_in_ctn=$request->fob_in_ctn;
        $costingDetails->conversion_rate=$request->conversion_rate;
        $costingDetails->cif_or_cfr_rate_per_ctn=$request->sales_term !='FOB' ? $request->cif_or_cfr_rate_per_ctn : 0;
        $costingDetails->cif_or_cfr_rate_per_piece=$request->sales_term !='FOB' ? $request->cif_or_cfr_rate_per_piece : 0;
        $costingDetails->last_updated_date=date("Y-m-d");
        $costingDetails->save();
     

    }

    public function updateCosting(Request $request){
          
            //return $request->all();
        // try {

        //     DB::beginTransaction(); 

             if($request->type==1){
                  
                $costingMasterId=$this->insertCostingMaster($request);
                $this->insertCostingDetails($request,$costingMasterId); 
                return response()->json([
                    'message' => "Created Successfully!",
                    "code"    => 200,
                ]);
                
             }else if($request->type==2){
                

                $this->updatedCostingMaster($request);
                $this->updatedCostingDetails($request); 

                return response()->json([
                    'message' => "Updated Successfully!",
                    "code"    => 200
                ]);

             }
           
        //     DB::commit();
        //     return response()->json([
        //         'status'=>'success'
        //     ],200);
           
        // } catch (\Exception $e) {
            
        //     DB::rollback();
        //     return response()->json([
        //         'status'=>'fail'
        //     ],200);
        // }


    }

    private function updatedCostingMaster($request){

        $notifyParty=NotifyParty::where('code',$request->party_code)->first(['id']);
        $ciItem=CiItem::where('ci_item_code',$request->item)->first(['id']);
        $costingMaster=CostingMaster::findorfail($request->edit_id); 
        $costingMaster->party_id=$notifyParty->id;
        $costingMaster->country=$request->country_name;
        $costingMaster->region=$request->region;
        $costingMaster->zone=$request->zone;
        $costingMaster->item_id=$ciItem->id;
        $costingMaster->bu=$request->bu;
        $costingMaster->location_id=$request->location;
        $costingMaster->sales_term=$request->sales_term;
        $costingMaster->container_size=$request->container_size;
        $costingMaster->container_category=$request->container_category;
        $costingMaster->ctn_per_container=$request->ctn_per_container;
        $costingMaster->pcs_per_container=$request->pcs_per_container;
        $costingMaster->pcs_per_ctn=$request->pcs_per_ctn;
        $costingMaster->carriage_per_container=$request->carriage_per_container=='' ? 0 : $request->carriage_per_container;
        $costingMaster->cnf_charge=$request->c_and_f_charge=='' ? 0 : $request->c_and_f_charge;
        $costingMaster->depot_exp=$request->depot_exp=='' ? 0 : $request->depot_exp;
        $costingMaster->doc_chg=$request->doc_chg=='' ? 0 : $request->doc_chg;
        $costingMaster->inside_gift_id=$request->inside_gift_id=='' ? 0 : $request->inside_gift_id;
        $costingMaster->others_id=$request->others_id=='' ? 0 : $request->others_id;
        $costingMaster->freight_chg=$request->sales_term !='FOB' ? $request->freight_chg : 0;
        $costingMaster->ins_chg=$request->sales_term !='FOB' ? $request->ins_chg : 0;
        $costingMaster->euser =Auth::user()->id;
        $costingMaster->idate=date("Y-m-d");
        $costingMaster->save();


    }

    private function updatedCostingDetails($request){

        CostingDetails::where('master_id',$request->edit_id)
            ->update([
                'manual_prime_cost'=>$request->manual_prime_cost, 
                'prime_cost_bdt'=>$request->prime_cost_bdt,
                'prime_cost_usd'=>$request->prime_cost_usd,
                'factory_oh_percent'=>$request->factory_oh_percent,
                'factory_oh_bdt'=>$request->factory_oh_percent,
                'factory_oh_bdt'=>$request->factory_oh_bdt,
                'factory_oh_percent'=>$request->factory_oh_percent,
                'factory_oh_usd'=>$request->factory_oh_usd,
                'carriage_percent'=>$request->carriage_percent,
                'carriage_percent_bdt'=>$request->carriage_percent_bdt,
                'carriage_percent_usd'=>$request->carriage_percent_usd,
                'depot_exp_percent'=>$request->depot_chg_percent,
                'depot_exp_bdt'=>$request->depot_chg_bdt,
                'depot_exp_usd'=>$request->depot_chg_usd,
                'collection_chg_percent'=>$request->collection_chg_percent,
                'collection_chg_bdt'=>$request->collection_chg_bdt,
                'collection_chg_usd'=>$request->collection_chg_usd,
                'insight_gift_percent'=>$request->insight_gift_percent,
                'insight_gift_bdt'=>$request->insight_gift_bdt,
                'insight_gift_usd'=>$request->insight_gift_usd,
                'others_percent'=>$request->others_percent,
                'others_bdt'=>$request->others_bdt,
                'others_usd'=>$request->others_usd,
                'total_oh_percent'=>$request->total_oh_percent,
                'total_cost_percent'=>$request->total_cost_percent,
                'total_cost_bdt'=>$request->total_cost_bdt,
                'total_cost_usd'=>$request->total_cost_usd,
                'gp_percentage'=>$request->gp_percentage,
                'gp_bdt'=>$request->gp_bdt,
                'gp_usd'=>$request->gp_usd,
                'per_piece_percent_value'=>$request->per_piece_percent_value,
                'per_piece_bd_value'=>$request->per_piece_bd_value,
                'per_piece_usd_value'=>$request->per_piece_usd_value,
                'fob_in_bdt'=>$request->fob_in_bdt,
                'fob_in_ctn'=>$request->fob_in_ctn,
                'conversion_rate'=>$request->conversion_rate,
                'cif_or_cfr_rate_per_ctn'=>$request->sales_term !='FOB' ? $request->cif_or_cfr_rate_per_ctn : 0,
                'cif_or_cfr_rate_per_piece'=>$request->sales_term !='FOB' ? $request->cif_or_cfr_rate_per_piece : 0,
                'last_updated_date'=>date('Y-m-d')
            ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
           
        
        $codingMaster=CostingMaster::find($id);
        $masterInfo=CostingMaster::with([
            'notify_party' => function ($query) {
                $query->select('id', 'name', 'code', 'country', 'region', 'zone');
            },
            'location' => function ($query) {
                $query->select('id', 'name as location');
            }
        ])
        ->select('costing_master.*')
        ->find($id);

        $costingDetails=CostingDetails::where('master_id', $id)->firstOrFail(); 
        $salesTerm=SalesTerm::all(); 
        $container_size=ContainerSize::all();
        $container_cat=ContainerCat::all();
        $locations=Location::all();
        $notifyParties=NotifyParty::all();
        $partyItems = NotifyPartyItem::where('notify_party_id',$codingMaster->party_id)
                ->join('ci_items', 'ci_items.id', '=', 'notify_party_items.ci_item_id')
                ->select('ci_items.id','ci_items.ci_item_code as item_code', 'ci_items.ci_item_name as item_name')
                ->get();
        return response()->json([
             'masterInfo'=>$masterInfo,
             'salesTerm'=>$salesTerm,
             'container_sizes'=>$container_size,
             'container_cats'=>$container_cat,
             'costingDetails'=>$costingDetails,
             'partyItems'=>$partyItems,
             'locations'=>$locations,
             'notifyParties'=>$notifyParties
         ],200);   

        
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

    public function uploadPrimeCostView(){

        return view('costing.primecost_upload');

    }

    public function uploadPrimeCost(Request $request){
     
        $file='';
        $status='';
        if($files = $request->file('file')) {

            $formated_file = $request->file('file');
            $path = $formated_file->getRealPath();
            $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
            try {

                DB::beginTransaction(); 
                $this->uploadCost($datas); 
                DB::commit();
                return response()->json([
                    'status'=>'success'
                ],200);
               
            } catch (\Exception $e) {
                
                echo $e->getMessage();
                DB::rollback();
                return response()->json([
                    'status'=>'fail'
                ],200);
            }

        }

    }

    private function uploadCost($datas){

        foreach ($datas as $key => $value){

            $start_date = $value['effective_start_date'];
            $start_date = $start_date->toDateString();
            $start_date=date("Y-m-d", strtotime($start_date));

            $end_date = $value['effective_end_date'];
            $end_date = $end_date->toDateString();
            $end_date=date("Y-m-d", strtotime($end_date));


            if(PrimeCost::where('code',$value->item_id)->where('start_date','>=',$start_date)->where('end_date','<=',$end_date)->count()==0){
            
                $primeCost=new PrimeCost();
                $primeCost->code=$value->item_id;
                $primeCost->name=$value->item_name;
                $primeCost->cost=$value->prime_cost ? $value->prime_cost : 0;
                $primeCost->start_date=$start_date;
                $primeCost->end_date=$end_date;
                $primeCost->created_date=date('Y-m-d');
                $primeCost->iuser=Auth::user()->id;
                $primeCost->save();

            }
            
        }
  
    }

    public function costingUploadView(){

        return view('costing.costing_upload');
    }
    
    public function uploadCosting(Request $request){
     
        $file='';
        $status='';
        if($files = $request->file('file')) {

            $formated_file = $request->file('file');
            $path = $formated_file->getRealPath();
            $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
            try {

                DB::beginTransaction(); 
                   $this->save_costing($datas); 
                DB::commit();
                return response()->json([
                    'status'=>'success'
                ],200);
               
            } catch (\Exception $e) {
                
                echo $e->getMessage();
                DB::rollback();
                return response()->json([
                    'status'=>'fail'
                ],200);
            }

        }

    }


    private function save_costing($datas){

        foreach($datas as $key => $value){


            if(CostingMaster::where('party_id',NotifyParty::where('code',$value->party)->value('id'))->count()==0){

                $partyItems=NotifyPartyItem::where('notify_party_id',NotifyParty::where('code',$value->party)->value('id'))->get();
                foreach($partyItems as $key => $partyItem) {

                    if(NotifyPartyItem::where('notify_party_id',$partyItem->notify_party_id)->where('ci_item_id',$partyItem->ci_item_id)->value('acc_rate')>0){

                        $factor=CiItem::where('id',$partyItem->ci_item_id)->value('factor');
                        //$fob_usd_per_ctn=NotifyPartyItem::where('notify_party_id',NotifyParty::where('code',$value->party)->value('id'))->where('ci_item_id',CiItem::where('ci_item_code',$value->item)->value('id'))->value('acc_rate');
                        $fob_usd_per_ctn=$partyItem->acc_rate;
                        // $ctn_per_container=$value->container_size=="20 Feet" ? 1200 : 2500;
                        $ctn_per_container=2500;
                        $costingMaster=new CostingMaster(); 
                        $costingMaster->party_id=NotifyParty::where('code',$value->party)->value('id');
                        $costingMaster->country=NotifyParty::where('code',$value->party)->value('country');
                        $costingMaster->region=NotifyParty::where('code',$value->party)->value('region');
                        $costingMaster->zone=NotifyParty::where('code',$value->party)->value('zone');
                        $costingMaster->item_id=$partyItem->ci_item_id;
                        $costingMaster->bu=Bu::where('id',CiItem::where('id',$partyItem->ci_item_id)->value('bu_id'))->value('code');
                        $costingMaster->location_id=Bu::where('id',CiItem::where('id',$partyItem->ci_item_id)->value('bu_id'))->value('location_id');
                        $costingMaster->sales_term=$value->sales_term;
                        $costingMaster->container_size=$value->container_size;
                        $costingMaster->container_category=$value->container_categroy;
                        $costingMaster->ctn_per_container=$ctn_per_container;
                        $costingMaster->pcs_per_container=$ctn_per_container*$factor;
                        $costingMaster->pcs_per_ctn=$factor;
                        $costingMaster->carriage_per_container=$value->carriage_per_container=='' ? 0 : $value->carriage_per_container;
                        $costingMaster->cnf_charge=$value->cnf_expense_per_ctn=='' ? 0 : $value->cnf_expense_per_ctn;
                        $costingMaster->depot_exp=$value->deport_chg=='' ? 0 : $value->deport_chg;
                        $costingMaster->doc_chg=$value->doc_chg=='' ? 0 : $value->doc_chg;
                        $costingMaster->inside_gift_id=$value->insight_gift=='' ? 0 : $value->insight_gift;
                        $costingMaster->others_id=$value->others=='' ? 0 : $value->others;
                        $costingMaster->freight_chg=$value->freight;
                        $costingMaster->ins_chg=$value->insurance;
                        $costingMaster->iuser=Auth::user()->id;
                        $costingMaster->idate=date("Y-m-d");
                        $costingMaster->save();
        
                        //return CarryingChg::where('location_id',Bu::where('id',CiItem::where('ci_item_code',$value->item)->value('bu_id'))->value('location_id'))->where('ctr_size_id',ContainerSize::where('name',$value->container_size)->value('id'))->where('ctr_cat_id',ContainerCat::where('name',$value->$value->container_categroy)->value('id'))->value('carring_charge');
                        
                        //$prime_Cost=PrimeCost::where('code',CiItem::where('id',$partyItem->ci_item_id))->orderBy('id','DESC')->first();
                        $prime_Cost = PrimeCost::where('code',CiItem::where('id',$partyItem->ci_item_id)->value('ci_item_code'))->whereDate('start_date', '>=', '2024-02-01')->whereDate('start_date', '<=', '2024-02-30')->first();
                        $costingDetails=new CostingDetails();
                        $costingDetails->master_id=$costingMaster->id;
                        // $costingDetails->manual_prime_cost=$value->prime_cost_bdt;
                        // $costingDetails->prime_cost_bdt=$value->prime_cost_bdt;
                        // $costingDetails->prime_cost_usd=$value->prime_cost_usd;
                        $prime_cost_bdt=0;
                        $prime_cost_usd=0;
                        if(!is_null($prime_Cost)){

                            $prime_cost_bdt=$prime_Cost->cost;
                            $prime_cost_usd=$prime_Cost->cost/$value->conversion_rateusd;

                        }
                        $costingDetails->manual_prime_cost=$prime_cost_bdt;
                        $costingDetails->prime_cost_bdt=$prime_cost_bdt;
                        $costingDetails->prime_cost_usd=$prime_cost_usd;
                        
                        $factory_oh_percent=0.00;
                        $factory_oh_bdt=0.000;
                        $factroy_oh_usd=0.000000;
        
                        $costingDetails->factory_oh_percent=$factory_oh_percent;
                        $costingDetails->factory_oh_bdt=$factory_oh_bdt;
                        $costingDetails->factory_oh_usd=$factroy_oh_usd;
                        
                        
                        $conversion_rate=$value->conversion_rateusd;
                        $per_piece_value_usd=$fob_usd_per_ctn/$factor;
                        $per_piece_bdt_amount=$per_piece_value_usd*$value->conversion_rateusd;
                        $pcs_per_container=$ctn_per_container*$factor;
        
                        //$carriage_per_container=CarryingChg::where('location_id',Bu::where('id',CiItem::where('ci_item_code',$value->item)->value('bu_id'))->value('location_id'))->where('ctr_size_id',ContainerSize::where('name',$value->container_size)->value('id'))->where('ctr_cat_id',ContainerCat::where('name',$value->$value->container_categroy)->value('id'))->value('carring_charge');
                        $carriage_per_container=$value->carriage_per_container;
                        $carriage_charge_bdt=$carriage_per_container/$pcs_per_container;
                        $formated_carriage_percent_bdt=round($carriage_charge_bdt,3);
                        $carriage_percent=($carriage_charge_bdt/$per_piece_bdt_amount)*100;
                        $forated_carriage_percent=round($carriage_percent,2);          
                        $carriage_percent_usd=$carriage_charge_bdt/$conversion_rate;
                        $forated_carriage_percent_usd=round($carriage_percent_usd,6);
            
                        $costingDetails->carriage_percent=$forated_carriage_percent;
                        $costingDetails->carriage_percent_bdt=$formated_carriage_percent_bdt;
                        $costingDetails->carriage_percent_usd=$forated_carriage_percent_usd;
        
                        $cnf_expense=$value->cnf_expense_per_ctn;
                        $total_ctn_cnf_charge=$cnf_expense*$ctn_per_container;
                        $cnf_exp_bdt=$total_ctn_cnf_charge/$pcs_per_container;
                        $foramated_cnf_exp_bdt=round($cnf_exp_bdt,3);
        
                        $cnf_exp_percent=($cnf_exp_bdt/$per_piece_bdt_amount)*100;
                        $forated_cnf_exp_percent=round($cnf_exp_percent,2);
                        $cnf_exp_usd=$cnf_exp_bdt/$conversion_rate;
                        $forated_cnf_exp_usd=round($cnf_exp_usd,6);
        
                        $costingDetails->cnf_exp_percent=$forated_cnf_exp_percent;
                        $costingDetails->cnf_exp_bdt=$foramated_cnf_exp_bdt;
                        $costingDetails->cnf_exp_usd=$forated_cnf_exp_usd;
        
                        $depot_charge=$value->deport_chg;
                        $depot_exp_bdt=$depot_charge/$pcs_per_container;
                        $formated_depot_exp_bdt=round($depot_exp_bdt,3);
                        $depot_exp_percent=($depot_exp_bdt/$per_piece_bdt_amount)*100;
                        $formated_depot_exp_percent=round($depot_exp_percent,2);
                        $depot_exp_usd=$depot_exp_bdt/$conversion_rate;
                        $forated_depot_exp_usd=round($depot_exp_usd,6);
        
        
                        $costingDetails->depot_exp_percent=$formated_depot_exp_percent;
                        $costingDetails->depot_exp_bdt=$formated_depot_exp_bdt;
                        $costingDetails->depot_exp_usd=$forated_depot_exp_usd;
        
                        $coln_chg=$value->doc_chg;
                        $coln_chg_bdt=$coln_chg/$pcs_per_container; 
                        $forated_coln_chg_bdt=round($coln_chg_bdt,3);
                        $coln_chg_percent=($coln_chg_bdt/$per_piece_bdt_amount)*100; 
                        $forated_coln_chg_percent=round($coln_chg_percent,2);
                        $coln_chg_usd=$coln_chg_bdt/$conversion_rate;
                        $forated_coln_chg_usd=round($coln_chg_usd,6);
            
        
                        $costingDetails->collection_chg_percent=$forated_coln_chg_percent;
                        $costingDetails->collection_chg_bdt=$forated_coln_chg_bdt;
                        $costingDetails->collection_chg_usd=$forated_coln_chg_usd;
        
        
                        $insite_gift=$value->insight_gift;
                        $insite_gift_bdt=$insite_gift/$pcs_per_container;
                        $forated_insite_gift_bdt=round($insite_gift_bdt,3);
                        $inside_gift_percent=($insite_gift_bdt/$per_piece_bdt_amount)*100;
                        $forated_insite_gift_percent=round($inside_gift_percent,2);
                        $insight_gift_usd=$insite_gift_bdt/$conversion_rate;
                        $forated_insight_gift_usd=round($insight_gift_usd,6);
            
                        $costingDetails->insight_gift_percent=$forated_insite_gift_percent;
                        $costingDetails->insight_gift_bdt=$forated_insite_gift_bdt;
                        $costingDetails->insight_gift_usd=$forated_insight_gift_usd;
        
                        $others=$value->others;
                        $others_bdt=$others/$pcs_per_container;
                        $forated_others_bdt=round($others_bdt,3);
                        $others_percent=($others_bdt/$per_piece_bdt_amount)*100;
                        $formated_others_percent=round($others_percent,2);
                        $others_usd=$others_bdt/$conversion_rate;
                        $formated_others_usd=round($others_usd,6);
        
        
                        $costingDetails->others_percent=$formated_others_percent;
                        $costingDetails->others_bdt=$forated_others_bdt;
                        $costingDetails->others_usd=$formated_others_usd;
        
                        $total_oh_bdt=($factory_oh_bdt+$carriage_charge_bdt+$cnf_exp_bdt+$depot_exp_bdt+$coln_chg_bdt+$insite_gift_bdt+$others_bdt);
                        $formated_total_oh_bdt=round($total_oh_bdt,3);
        
                        $total_oh_usd=($factroy_oh_usd+$carriage_percent_usd+$cnf_exp_usd+$depot_exp_usd+$coln_chg_usd+$insight_gift_usd+$others_usd);    
                        $formated_total_oh_usd=round($total_oh_usd,6);
        
                        $total_oh_percent=($total_oh_bdt/$per_piece_bdt_amount)*100;
                        $formated_total_oh_percent=round($total_oh_percent,2);
        
                        $costingDetails->total_oh_percent=$formated_total_oh_percent;
                        $costingDetails->total_oh_bdt=$formated_total_oh_bdt;
                        $costingDetails->total_oh_usd=$formated_total_oh_usd;
        
                        
                        $total_cost_bdt=$total_oh_bdt+$prime_cost_bdt;
                        $formated_total_cost_bdt=round($total_cost_bdt,3);
                        $total_cost_usd=$total_oh_usd+$prime_cost_usd;
                        $formated_total_cost_usd=round($total_cost_usd,6);
                        $total_cost_percent=(($total_cost_bdt/$per_piece_bdt_amount)*100);
                        $formated_total_cost_percent=round($total_cost_percent);
        
                        $costingDetails->total_cost_percent=$formated_total_cost_percent;
                        $costingDetails->total_cost_bdt=$formated_total_cost_bdt;
                        $costingDetails->total_cost_usd=$formated_total_cost_usd;
                        
                        $costingDetails->gp_percentage=100-$total_cost_percent;
                        $costingDetails->gp_bdt=$per_piece_bdt_amount-$total_cost_bdt;
                        $costingDetails->gp_usd=$per_piece_value_usd-$total_cost_usd;
        
                        $costingDetails->per_piece_percent_value=0.00;
                        $costingDetails->per_piece_bd_value=$per_piece_bdt_amount;
                        $costingDetails->per_piece_usd_value=$per_piece_value_usd;
        
                    
                        $costingDetails->fob_in_bdt=($fob_usd_per_ctn*$conversion_rate);
                        $costingDetails->fob_in_ctn=$fob_usd_per_ctn;
                        $costingDetails->conversion_rate=$conversion_rate;
        
                        $freight_plus_ins=$value->freight+$value->insurance;
                        $freight_plus_ins_per_ctn=round(($freight_plus_ins/$ctn_per_container+$fob_usd_per_ctn),6);
                        $freight_plus_ins_per_piece=round(($freight_plus_ins_per_ctn/$factor),6);
        
                        $costingDetails->cif_or_cfr_rate_per_ctn=$freight_plus_ins_per_ctn;
                        $costingDetails->cif_or_cfr_rate_per_piece=$freight_plus_ins_per_piece;
                        $costingDetails->save();
        
                    }     

                    
                } 

            }

        }


    }

    public function costingReportView(){

        
        $regions=NotifyParty::select('region','region_code')->groupBy('region','region_code')->get();
        $countries=NotifyParty::select('country')->groupBy('country')->where('country', '!=', '')->get();
        $parties = NotifyParty::select('code','name')->get();
        return view('costing.costing_report')
                ->with('parties',$parties)
                ->with('countries',$countries)
                ->with('regions',$regions);


    }

    public function jsonGetRegionWisePartyList(Request $request){



        $where="";
        if($request->region=='All'){

            $where.=" notify_parties.region like '%%'";

        }else{

            $where.=" notify_parties.region='$request->region'";
        }

        $result=DB::select("SELECT DISTINCT country
                FROM notify_parties
                WHERE $where");

        if($result) {

            return response()->json([
                'message' => "Data Found Successfully!",
                "code"    => 200,
                "data"    => $result 
            ]);

        } else  {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"    => []
            ]);

        }


    }

    public function jsonCountryWisePartyList(Request $request){

        
        $where="";
        if($request->country=='All'){

            $where.=" notify_parties.country like '%%'";

        }else{

            $where.=" notify_parties.country='$request->country'";
        }

        $result=DB::select("SELECT DISTINCT code, name
            FROM notify_parties
            WHERE $where");

        if($result) {

            return response()->json([
                'message' => "Data Deleted Successfully!",
                "code"    => 200,
                "data"    => $result 
            ]);

        } else {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"    => []
            ]);

        }

    }

    public function jsonGetCostingReportData(Request $request){

        $region=NULL; 
        if($request->region){
           
            $region_code=$request->region;
            
        }  
        $country=NULL;
        if($request->country){
           
            $country=$request->country;
 
        }
        $party_code=NULL;
        if($request->party_code){
           
            $party_code=$request->party_code;
 
        }
        $result=DB::select("CALL PROC_COSTING_REPORT_DATA(?,?,?)", [$region_code,$country,$party_code]);
        if($result){

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $result
            ]);

        }else{

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);

        }


    }

    public function jsonGetCostingFreightDetails(Request $request){
            
        $result = CostingMaster::select(
            'costing_master.freight_chg',
            'costing_master.ins_chg',
            'costing_details.cif_or_cfr_rate_per_ctn as rate_per_ctn',
            'costing_details.cif_or_cfr_rate_per_piece as rate_per_piece'
        )
        ->join('costing_details', 'costing_master.id', '=', 'costing_details.master_id')
        ->where('costing_master.id', '=', $request->id)
        ->where('costing_master.sales_term', '=', $request->sales_term)
        ->first();    
        
        if($result) {

            return response()->json([
                'message' =>        "Data Found",
                "freight_chg"       => $result->freight_chg,
                "ins_chg"           => $result->ins_chg,
                "rate_per_ctn"      => $result->rate_per_ctn,
                "rate_per_piece"    => $result->rate_per_piece,
                "code"    => 200,
            ]);

        } else  {

            return response()->json([
                'message' => "Internal Server Error",
                "freight_chg"       => 0,
                "ins_chg"           => 0,
                "rate_per_ctn"      => 0,
                "rate_per_piece"    => 0,
                "code"    => 500,
            ]);

        }
 
    }

    public function getCarryingCharge(Request $request){
      
        $carrying_charge=0;
        $result=CarryingChg::where('location_id',$request->location_id)
               ->where('ctr_size_id', ContainerSize::where('name',$request->container_size)->value('id'))
               ->where('ctr_cat_id', ContainerCat::where('name',$request->container_category)->value('id'))
               ->first();

        if(!is_null($result)){

            $carrying_charge=$result->carring_charge;
        }
        
        return response()->json([
            'carrying_charge'=>$carrying_charge
        ],200);
              
    }

    public function getDepotCharge(Request $request){
          
        $depot_charge=0;
        $result=CarryingChg::where('ctr_size_id',ContainerSize::where('name',$request->container_size)->value('id'))
               ->where('ctr_cat_id', ContainerCat::where('name',$request->container_cat)->value('id'))
               ->first();
        if(!is_null($result)){

            $depot_charge=$result->depot_expense;
        }
        return response()->json([
            'depot_charge'=>$depot_charge
        ],200);

    }

    public function getCostingCvrAndHdCost(Request $request){


        $result = DB::table('cvr_setup')
            ->select('from_date', 'to_date', 'cvr_rate')
            ->whereRaw('CURRENT_DATE() >= from_date')
            ->whereRaw('CURRENT_DATE() <= to_date')
            ->where('status', 'N')
            ->orderByDesc('id')
            ->first();
        $cvr_rate=0;
        if(!is_null($result)){
            
           $cvr_rate=$result->cvr_rate;

        }

        $hd_cost = DB::table('costing_others_hd')
            ->select('cost_head', 'charge')
            ->get();

        $cnf_charage = $hd_cost[0]->charge;
        $doc_charge = $hd_cost[1]->charge;
        $inside_gift = $hd_cost[2]->charge;
        $others = $hd_cost[3]->charge;
        
        return response()->json([
            'cvr_rate'=>$cvr_rate,
            'cnf_charage'=>$cnf_charage,
            'doc_charge'=>$doc_charge,
            'inside_gift'=>$inside_gift,
            'others'=>$others,

        ]);
    

    }

    
}
