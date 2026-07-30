<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use Auth;
use App\SaleContractDetail;
use App\NotifyParty;
use App\DistributorInfoMaster;
use App\CiItem;
use App\DistributorInfoDetail;
use App\NotifyPartyUser;
use App\NotifyPartyItem;
use App\Runit;
use App\Dunit;
use Toastr;
class ExportDistributorInformationController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

       

        $notify_party_ids = NotifyPartyUser::where('user_id',Auth::user()->id)->pluck('notify_party_id');
        $notifyParties = NotifyParty::whereIn('id',$notify_party_ids)->get();
        if($request->importer_id){


            $notify_party_address = NotifyParty::where('id',$request->importer_id)->pluck('address');
            $notify_party_address = $notify_party_address['0'];
            $notify_party_items=NotifyPartyItem::select('notify_party_items.desk_item_name','notify_party_items.acc_rate','notify_party_items.party_rate','notify_party_items.coding_matter','notify_party_items.special_requirement','notify_party_items.shelf_life','notify_party_items.dunit','notify_party_items.runit','ci_items.ci_item_code','ci_items.ci_item_name','ci_items.factor') 
            ->join('ci_items','ci_items.id','=','notify_party_items.ci_item_id')
            ->where('notify_party_items.notify_party_id','=',$request->importer_id)
            ->get();


        }else{

           $notify_party_address="";
           $notify_party_items=""; 

        }
        $dunits=Dunit::all();
        $runits=Runit::all();
        return view('distributor_information.create')
               ->with('notifyParties', $notifyParties)
               ->with('notify_party_address', $notify_party_address)
               ->with('importer_id', $request->importer_id)
               ->with('notify_party_items', $notify_party_items)
               ->with('dunits', $dunits)
               ->with('runits', $runits);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      

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
        //  $aray=array();
        // for ($i=0; $i < count($request->dist_info_details); $i++) { 


        //     NotifyParty::where('code', dist_info_details)
             
        //    // $distributorInfoMaster=new DistributorInfoMaster();
        //    // $distributorInfoMaster->importer_id=
        //    // $distributorInfoMaster->address=
        //    // $distributorInfoMaster->user_id=
          

        // }
    }

    public function saveExportDistInfo(Request $request){
        
          
        //return $request->all();  
        $my_array=array();
        $length=count($request->unit_data); 
        //@@@@@@@@@@@@@@@-----------Checking Unit------------------
        for ($j=1; $j<$length; $j++) {

            if($request->unit_data[$j]['value']==""){
                
                return "Fail";

            }    
                      

        } 
        $d_unit=array(); 
        $r_unit=array();
        $temp_array=array();
        $dist_info_details=array();
        //@@@@@@@@@@@@@@@----------End Unit Checking--------------
        //@@@@@@@@@@@@@@@----------Separate Unit Value------------
        for ($j=1; $j<$length; $j++) {


            if($j%2==0){
                  
                $r_unit[] = array('ru_unit' => $request->unit_data[$j]['value']);
               

            }else{

                $d_unit[] = array('du_unit' => $request->unit_data[$j]['value']);

            }    
                      

        }
        //@@@@@@@@@@@----End---------------------------------------

        //@@@@@@@@@@@@@@-----Combine Value-------------------------

        for ($i=0; $i<count($request->info_details); $i++) { 

             $temp_array[] = array_merge($request->info_details[$i], $r_unit[$i]);

        }


        for ($i=0; $i<count($request->info_details); $i++) { 

             $dist_info_details[] = array_merge($temp_array[$i], $d_unit[$i]);

        }
        
        // @@@@@@@@@@@@@@@@--End----- 

        //@@@@@@Validate Carton Qty/ Shelf Life---------------

        $shelfLife=array();
        $cartonQty=array(); 
        for ($i=0; $i<count($dist_info_details); $i++) {

            array_push($shelfLife, preg_replace("<<br>>", "0", $dist_info_details[$i]['shelf_life']));
            array_push($cartonQty, preg_replace("<<br>>", "0", $dist_info_details[$i]['qty']));

        }

        for ($i=0; $i <count($cartonQty) ; $i++) { 
          
            if ($cartonQty[$i]=='0') {
              
                return "cartonQty";

            }

        } 
         
        for ($i=0; $i <count($shelfLife) ; $i++) { 
          
            if ($shelfLife[$i]=='0') {
              
                return "shelf_life";

            }

        }
        
        
        
        $existORNotMasterId=DistributorInfoMaster::where('importer_id',$request->importer_id)->pluck('id');
        if(count($existORNotMasterId)>0){
             
            for ($i=0; $i<count($dist_info_details); $i++) { 
             
                $party_item_id=CiItem::where('ci_item_code', $dist_info_details[$i]['item_code'])->pluck('id');
                $itemExistOrNot=$notify_party_items=DistributorInfoMaster::select('distributor_info_details.rate','distributor_info_details.id') 
                       ->join('distributor_info_details','distributor_info_details.distributor_master_id','=','distributor_info_masters.id')
                       ->where('distributor_info_details.item_id','=',$party_item_id['0'])
                       ->where('distributor_info_masters.importer_id','=',$request->importer_id)
                       ->get();

                foreach ($itemExistOrNot as $key => $value) {
                           
                   $details_id=$value->id;

                }       
                if(count($itemExistOrNot)>0){

                    \DB::table('distributor_info_details')
                    ->where('id', $details_id)
                    ->update([
                        'du_unit' => $dist_info_details[$i]['du_unit'],
                        'ru_unit' => $dist_info_details[$i]['ru_unit'],
                        'qty' => preg_replace("<<br>>", "0", $dist_info_details[$i]['qty']),
                        'self_line' => preg_replace("<<br>>", "0", $dist_info_details[$i]['shelf_life']),
                        'coding_mater' => preg_replace("<<br>>", "", $dist_info_details[$i]['coding_mater']),
                        'special_requirment' => preg_replace("<<br>>", " ", $dist_info_details[$i]['sreq']),
                        'rate' => preg_replace("<<br>>", "0", $dist_info_details[$i]['rate']),
                        'update_by' => Auth::user()->id,
                        'version' => 1
                    ]);

                }else{

                       $distributorInfoDetail=new DistributorInfoDetail();
                       $distributorInfoDetail->distributor_master_id=$existORNotMasterId['0'];
                       $distributorInfoDetail->item_id=$party_item_id['0'];  
                       $distributorInfoDetail->du_unit=$dist_info_details[$i]['du_unit'];
                       $distributorInfoDetail->ru_unit=$dist_info_details[$i]['ru_unit'];
                       $distributorInfoDetail->qty=preg_replace("<<br>>", "0", $dist_info_details[$i]['qty']);
                       $distributorInfoDetail->self_line=preg_replace("<<br>>", "0", $dist_info_details[$i]['shelf_life']);
                       $distributorInfoDetail->coding_mater=preg_replace("<<br>>", "", $dist_info_details[$i]['coding_mater']);
                       $distributorInfoDetail->special_requirment=preg_replace("<<br>>", " ", $dist_info_details[$i]['sreq']);
                       $distributorInfoDetail->rate=preg_replace("<<br>>", "0", $dist_info_details[$i]['rate']);
                       $distributorInfoDetail->create_by=Auth::user()->id;
                       $distributorInfoDetail->update_by=Auth::user()->id;
                       $distributorInfoDetail->version=1;
                       $distributorInfoDetail->save(); 


                } 
            
            }  

        }else{

            $party_item_id=DistributorInfoMaster::where('importer_id',$request->importer_id)->pluck('id'); 
            $distributorInfoMaster=new DistributorInfoMaster();
            $distributorInfoMaster->importer_id=$request->importer_id;
            $distributorInfoMaster->address=$request->importer_address;
            $distributorInfoMaster->user_id=Auth::user()->id;
            $distributorInfoMaster->save();
            for ($i=0; $i<count($dist_info_details); $i++) { 
              $distributorInfoDetail=new DistributorInfoDetail();
               $party_item_id=CiItem::where('ci_item_code', $dist_info_details[$i]['item_code'])->pluck('id');
               $distributorInfoDetail->distributor_master_id=$distributorInfoMaster->id;
               $distributorInfoDetail->item_id=$party_item_id['0'];  
               $distributorInfoDetail->du_unit=$dist_info_details[$i]['du_unit'];
               $distributorInfoDetail->ru_unit=$dist_info_details[$i]['ru_unit'];
               $distributorInfoDetail->qty=preg_replace("<<br>>", "0", $dist_info_details[$i]['qty']);
               $distributorInfoDetail->self_line=preg_replace("<<br>>", "0", $dist_info_details[$i]['shelf_life']);
               $distributorInfoDetail->coding_mater=preg_replace("<<br>>", "", $dist_info_details[$i]['coding_mater']);
               $distributorInfoDetail->special_requirment=preg_replace("<<br>>", " ", $dist_info_details[$i]['sreq']);
               $distributorInfoDetail->rate=preg_replace("<<br>>", "0", $dist_info_details[$i]['rate']);
               $distributorInfoDetail->create_by=Auth::user()->id;
               $distributorInfoDetail->update_by=Auth::user()->id;
               $distributorInfoDetail->version=1;
               $distributorInfoDetail->save();  
            
            }  


        }
        return "Success";

        
    }

    
}
