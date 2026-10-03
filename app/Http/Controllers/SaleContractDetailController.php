<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\SaleContractDetail;
use App\CiItem;
use App\SaleContract;
use App\NotifyPartyItem;
use App\JobOrderMaster;
use App\JobOrderDetails;
use Illuminate\Support\Facades\Crypt;
use DB;
class SaleContractDetailController extends Controller{


    public function __construct(){
       $this->middleware('auth');
    }
    

    public function index(){

        //$sale_contract_details = SaleContractDetail::orderBy('id','Desc')->paginate(20);
        // return view("sale_contract_detail.sale_contract_detail_list",compact("sale_contract_details"));
    }
    
    public function store(Request $request)
    {

        $ci_item = CiItem::find($request->ci_item_id);   
        // Validate inputs
        if ($request->cbm_per_ctn <= 0) {
            return response()->json([
                'status' => 400,
                'message' => 'CBM per CTN cannot be zero or negative!'
            ], 400);
        }
        
        if ($this->isCiAlreadyExist($request->sc_id, $ci_item->id)) {
            return response()->json([
                'status' => 400,
                'message' => 'This item already exists in the sale contract!'
            ], 400);
        }

        // Your existing save logic here...
        $sale_contract_detail = new SaleContractDetail;
        $sale_contract_detail->ccq = 0;
        $sale_contract_detail->ci_item_id = $request->ci_item_id;
        $sale_contract_detail->ci_item_name =$ci_item->duplicate_name; 
        $sale_contract_detail->sale_contract_id = $request->sc_id;
        $sale_contract_detail->rate_per_ctn = $ci_item->ci_item_rate;
        $sale_contract_detail->rate_per_ctn_for_party = $request->rate_per_ctn_for_party;
        $sale_contract_detail->rate_per_ctn_for_acc = $request->rate_per_ctn_for_acc;
        $sale_contract_detail->ctn = $request->ctn;
        $sale_contract_detail->pcs_in_ctn = $request->ctn * $ci_item->ci_factor;
        $sale_contract_detail->factor = $ci_item->ci_factor;
        $sale_contract_detail->is_eligible = $ci_item->is_ci_eligible;
        $sale_contract_detail->cbm_per_ctn = $request->cbm_per_ctn;
        $sale_contract_detail->total_cbm = $request->cbm_per_ctn * $request->ctn;
        $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = 0;
        $sale_contract_detail->per_ctn_freight = 0;
        $sale_contract_detail->ci_rate_pl_freight = 0;
        $sale_contract_detail->total_amount = $ci_item->ci_item_rate * $request->ctn;
        $sale_contract_detail->total_amount_party = $request->rate_per_ctn_for_party * $request->ctn;
        $sale_contract_detail->total_amount_acc = $request->rate_per_ctn_for_acc * $request->ctn;
        $sale_contract_detail->net_weight_kg = $request->ctn * $ci_item->d_net_weight;
        $sale_contract_detail->gross_weight_per_item = $request->gross_weight;
        $sale_contract_detail->gross_weight_kg = $request->ctn * $request->gross_weight;
        $sale_contract_detail->bapa_percent = $ci_item->bapa_percent;
        $sale_contract_detail->claim_amount = ($ci_item->bapa_percent * $sale_contract_detail->total_amount) / 100;
        $sale_contract_detail->bu_id = $ci_item->bu_id;
        
        if ($request->mfg && $request->exp) {
            $sale_contract_detail->mfg = date("Y-m-d", strtotime($request->mfg));
            $sale_contract_detail->exp = date("Y-m-d", strtotime($request->exp));
        }
        
        $sale_contract_detail->hs_code = $request->hs_code;
        $sale_contract_detail->hs_code_2 = $request->hs_code_2;
        $sale_contract_detail->container_no = $request->container_no;
        $sale_contract_detail->batch_no = $request->batch_no;
        $sale_contract_detail->desk_item_name = $request->desk_item_name;
        $sale_contract_detail->save();
        $this->manageFreight($request->sc_id);
        $this->manageCCQ($request->sc_id);
        
        // Calculate totals for response
        $totals = [
            'total_ctn' => SaleContractDetail::where('sale_contract_id', $request->sc_id)->sum('ctn'),
            'total_amount' => SaleContractDetail::where('sale_contract_id', $request->sc_id)->sum('total_amount'),
            'total_amount_party' => SaleContractDetail::where('sale_contract_id', $request->sc_id)->sum('total_amount_party'),
            'total_amount_acc' => SaleContractDetail::where('sale_contract_id', $request->sc_id)->sum('total_amount_acc'),
            'total_cbm' => SaleContractDetail::where('sale_contract_id', $request->sc_id)->sum('total_cbm'),
        ];
        
        return response()->json([
            'status' => 200,
            'message' => 'Item added successfully',
            'totals' => $totals
        ]);
    }

    private function isCiAlreadyExist($sale_contract_id, $ci_item_id)
    {
        return SaleContractDetail::where('sale_contract_id', $sale_contract_id)
            ->where('ci_item_id', $ci_item_id)
            ->exists();
    }

    private function manageFreight($sale_contract_id){
        
        $sale_contract = SaleContract::find($sale_contract_id);
        $freight_cost  = $sale_contract->freight_cost;
        $sum_total_cbm = SaleContractDetail::where('sale_contract_id',$sale_contract_id)
                                            ->sum('total_cbm');

        foreach($sale_contract->sale_contract_details as $sale_contract_detail){

            $freigh_x_tcbm_by_sum_total_cbm = ($freight_cost / $sum_total_cbm ) * $sale_contract_detail->total_cbm ;
            $per_ctn_freight = $freigh_x_tcbm_by_sum_total_cbm / $sale_contract_detail->ctn;
            $ci_rate_pl_freight = $sale_contract_detail->rate_per_ctn + $per_ctn_freight;
            $sale_contract_detail->freigh_x_tcbm_by_sum_total_cbm = $freigh_x_tcbm_by_sum_total_cbm;
            $sale_contract_detail->per_ctn_freight   = $per_ctn_freight;
            $sale_contract_detail->ci_rate_pl_freight     = round($ci_rate_pl_freight,3);
            $sale_contract_detail->total_amount = $sale_contract_detail->ctn * round($ci_rate_pl_freight,3);
            $sale_contract_detail->save();

          
        }

    }

    
    private function manageCCQ($sale_contract_id){
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$sale_contract_id)->get();
        $sum_ccq = 0;
        foreach($sale_contract_details as $sale_contract_detail){
            $sum_ccq += $sale_contract_detail->ctn;
            $sale_contract_detail->ccq = $sum_ccq;
            $sale_contract_detail->save();
        }

        return 1;

    }


    // CI EDIT
    public function edit($sale_contact_id, $party_id){
        
        $id =\Crypt::decrypt($sale_contact_id);
        $ci_items=CiItem::all();
        $sale_contract_detail = SaleContractDetail::find($id); 
        return view("sale_contract_detail.sale_contract_detail_edit",compact("sale_contract_detail"))
             ->with("ci_items" ,$ci_items)
             ->with('party_id', \Crypt::decrypt($party_id));
        
    }

    public function edit_desk($encryptedId,$party_id){
    
        $id=\Crypt::decrypt($encryptedId);
        $party_id=\Crypt::decrypt($party_id);
        // $user_id=Auth::user()->id;  
        // $sale_contract_detail = SaleContractDetail::find($id); 
        // $sale_contract = SaleContract::find($sale_contract_detail->sale_contract_id);
        // $notity_party_id=$sale_contract->notify_pary_id;
        // $item_gross_weight=NotifyPartyItem::where('notify_party_id',$notity_party_id)->where('ci_item_id',$sale_contract_detail->ci_item_id)->first(['gross_weight']);
        // $notify_party_items = NotifyPartyItem::where('notify_party_id',$sale_contract->notify_pary_id)->pluck('ci_item_id');
        // $ci_items=CiItem::whereIn('id',$notify_party_items)->get();
        // return view("sale_contract_detail.sale_contract_detail_edit_desk",compact("sale_contract_detail"))
        //      ->with("ci_items" ,$ci_items)
        //      ->with('sale_contract_details',$sale_contract_detail)
        //      ->with('party_id', $d_party_id)
        //      ->with('sale_contract',$sale_contract)
        //      ->with('item_gross_weight',$item_gross_weight);

        $sale_contract_detail = SaleContractDetail::findOrFail($id);
        $gross_weight=NotifyPartyItem::where('notify_party_id',$party_id)->where('ci_item_id',$sale_contract_detail->ci_item_id)->value('gross_weight');
        $ci_items = CiItem::where('id',$sale_contract_detail->ci_item_id)->get();
        $sale_contract = $sale_contract_detail->sale_contract;
        return view('partials.edit_desk_modal', compact(
            'id',
            'sale_contract_detail', 
            'ci_items',
            'party_id', 
            'sale_contract',
            'gross_weight'
        ));

    }


    public function edit_ci($sale_contact_id,$party_id,$sc_id){
    
        $id=\Crypt::decrypt($sale_contact_id);
        $party_id=\Crypt::decrypt($party_id);
        $sc_id=\Crypt::decrypt($sc_id);

        // $user_id=Auth::user()->id;  
        // $sale_contract_detail = SaleContractDetail::find($id); 
        // $sale_contract      = SaleContract::find($sale_contract_detail->sale_contract_id);
        // $notity_party_id=$sale_contract->notify_pary_id;
        // $item_gross_weight=NotifyPartyItem::where('notify_party_id',$notity_party_id)->where('ci_item_id',$sale_contract_detail->ci_item_id)->first(['gross_weight']);
        // $notify_party_items = NotifyPartyItem::where('notify_party_id',$sale_contract->notify_pary_id)->pluck('ci_item_id');
        // $ci_items=CiItem::whereIn('id',$notify_party_items)->get();
        // return view("sale_contract_detail.sale_contract_detail_edit_desk",compact("sale_contract_detail"))
        //      ->with("ci_items" ,$ci_items)
        //      ->with('sale_contract_details',$sale_contract_detail)
        //      ->with('party_id', $d_party_id)
        //      ->with('sale_contract',$sale_contract)
        //      ->with('item_gross_weight',$item_gross_weight);

        $sale_contract_detail = SaleContractDetail::findOrFail($id);
        return view('partials.edit_ci_modal', compact(
            'sale_contract_detail', 
            'id', 
            'sc_id',
            'party_id'
        ));

    }


    public function update_desk(Request $request){
         
        $id=$request->encryptedId; 
        $ci_item = CiItem::find($request->ci_item_id);
        $sale_contract_detail = SaleContractDetail::find($id);
        $sale_contract_detail->ci_item_id=$request->ci_item_id;
        if($sale_contract_detail->ci_item_id != $request->ci_item_id){

           $sale_contract_detail->ci_item_name=$ci_item->ci_item_name;

        }
        $sale_contract_detail->rate_per_ctn_for_party=$request->rate_per_ctn_for_party;
        $sale_contract_detail->rate_per_ctn_for_acc=$request->rate_per_ctn_for_acc;
        $sale_contract_detail->ctn=$request->ctn;
        $sale_contract_detail->pcs_in_ctn=$request->ctn * $ci_item->ci_factor;
        $sale_contract_detail->cbm_per_ctn = $request->cbm_per_ctn;
        $sale_contract_detail->total_cbm = $request->cbm_per_ctn * $request->ctn;
        $sale_contract_detail->total_amount_party=$request->rate_per_ctn_for_party * $request->ctn;
        $sale_contract_detail->total_amount_acc=$request->rate_per_ctn_for_acc * $request->ctn;
        $sale_contract_detail->net_weight_kg=$request->ctn * $ci_item->d_net_weight;
        $sale_contract_detail->gross_weight_per_item=$request->gross_weight;
        $sale_contract_detail->gross_weight_kg=$request->ctn * $request->gross_weight;
        $sale_contract_detail->is_eligible       = $ci_item->is_ci_eligible;
        $sale_contract_detail->container_no = $request->container_no;
        $sale_contract_detail->batch_no = $request->batch_no;
        $sale_contract_detail->bapa_percent = $ci_item->bapa_percent;
        $sale_contract_detail->claim_amount = ($ci_item->bapa_percent * $sale_contract_detail->total_amount_party ) / 100;
        $sale_contract_detail->bu_id        = $ci_item->bu_id;
        if($request->mfg || $request->exp){

            $sale_contract_detail->mfg=date("Y-m-d",strtotime($request->mfg));
            $sale_contract_detail->exp=date("Y-m-d",strtotime($request->exp));

        }else{

            $sale_contract_detail->mfg=NULL;
            $sale_contract_detail->exp=NULL;
        }
        $sale_contract_detail->hs_code=$request->hs_code;
        $sale_contract_detail->hs_code_2=$request->hs_code_2;
        $sale_contract_detail->safta_percentage=$request->safta_percentage;
        $sale_contract_detail->container_no = $request->container_no;
        $sale_contract_detail->batch_no = $request->batch_no;
        $sale_contract_detail->desk_item_name =$request->desk_item_name;
        $sale_contract_detail ->save();
        $this->manageFreight($sale_contract_detail->sale_contract_id);
        $this->manageCCQ($sale_contract_detail->sale_contract_id);
        $user_id=Auth::user()->id; 
        $sale_contract = SaleContract::find($request->sale_contract_id); 
        $sale_contract_details = SaleContractDetail::where('sale_contract_id',$request->sale_contract_no)->get(); 
        $joIds=JobOrderMaster::where('sale_contract_id',$id)->pluck('id')->toArray();
        DB::table('job_order_details')
            ->whereIn('id', $joIds)
            ->where('item_id',$request->ci_item_id)
            ->update([
                'syn_status_date'=>date('Y-m-d'),
                'item_status'=>'N'
            ]);
   

       return response()->json([
           'code'=>200
       ]);     
        
    }

    // CI UPDATE
    public function update_ci(Request $request) {

        $id=$request->encryptedId;
        $ci_item = CiItem::find($request->ci_item_id);
        $sale_contract_detail = SaleContractDetail::find($id);
        $sale_contract_detail->ci_item_name   =$request->ci_item_name;
        $sale_contract_detail->hs_code        =$request->hs_code;
        $sale_contract_detail->rate_per_ctn   =$request->rate_per_ctn;
        $sale_contract_detail->pcs_in_ctn     =$request->ctn * $ci_item->ci_factor;
        $sale_contract_detail->total_amount   =$request->rate_per_ctn * $request->ctn;
        $sale_contract_detail->net_weight_kg  =$request->ctn * $ci_item->d_net_weight;
        $sale_contract_detail->mfg  = NULL;
        $sale_contract_detail->exp  = NULL;
        $sale_contract_detail ->save();
        $this->manageFreight($request->sc_id);
        $this->manageCCQ($request->sc_id);
        $this->updateCiTotalValue($request->sc_id);
        return response()->json([
           'code'=>200
       ]);
        
    }


    public function show($id){

        $sale_contract_detail = SaleContractDetail::find($id); 
        return view("sale_contract_detail.sale_contract_detail_show",compact("sale_contract_detail"));

    }


    public function destroy($id){

        $sale_contract_detail = SaleContractDetail::findOrFail($id);
        $sale_contract_id = $sale_contract_detail->sale_contract_id;
        $sale_contract_detail ->delete();
        $this->manageFreight($sale_contract_id);
        $this->manageCCQ($sale_contract_id);
        Session::flash("success", "Deleted Succcessfully !");
        return redirect()->back();
    }

    public function updateCiTotalValue($id){

        $total_sum=0;
        $sale_contract=SaleContract::findorfail($id);  
        $total_net_weight = SaleContractDetail::where('sale_contract_id',$id)->sum('net_weight_kg');
        if($total_net_weight){

            $per_unit_freight=$sale_contract->freight_cost/$total_net_weight;
            $sale_contract_details = SaleContract::where('sale_contracts.id',$id)
                                ->select('sale_contract_details.ci_item_name','sale_contract_details.rate_per_ctn','ci_items.ci_factor',
                                    DB::Raw('SUM(sale_contract_details.ctn) AS ctn'),
                                    DB::Raw('SUM(sale_contract_details.total_amount) AS total_amount'),
                                    DB::Raw('SUM(sale_contract_details.net_weight_kg) AS net_weight_kg'),
                                    DB::Raw('SUM(sale_contract_details.gross_weight_kg) AS gross_weight_kg'),
                                    DB::Raw('SUM(sale_contract_details.ctn) AS ctn'))
                            ->join('sale_contract_details','sale_contract_details.sale_contract_id','sale_contracts.id')
                            ->join('ci_items','ci_items.id','sale_contract_details.ci_item_id')
                            ->groupby('sale_contract_details.ci_item_name')
                            ->orderBy('sale_contract_details.id')
                            ->get();

            foreach($sale_contract_details as $sale_contract_detail){

                try { 

                    if($sale_contract_detail->ci_factor !=0 ){
    
                        $per_net_weight_kg_fright=$per_unit_freight*$sale_contract_detail->net_weight_kg;
                        if($sale_contract_detail->ctn){

                            $caton_fright=$per_net_weight_kg_fright/$sale_contract_detail->ctn;

                        }else{

                            $caton_fright=0; 
                        }
                        $carton_fright_pl_rate=round($caton_fright+$sale_contract_detail->rate_per_ctn,3);
                        $total_sum=$total_sum+round($carton_fright_pl_rate*$sale_contract_detail->ctn,2);
 
                    }

                }catch (Exception $e) {
        
            
                }  
                
             }

            DB::table('sale_contracts')->where('id',$id)->update([
                'total_ci_value'=>$total_sum 
            ]);

        }

    }

    public function getSaleContractDetails(Request $request, $sale_contract_id)
{
    try {
        // Decrypt if encrypted
        try {
            $sale_contract_id = \Crypt::decrypt($sale_contract_id);
        } catch (\Exception $e) {
            // If not encrypted, use as is
        }
        
        $party_id = $request->get('party_id');
        
        // Get sale contract with details
        $sale_contract = SaleContract::with(['sale_contract_details' => function($query) {
            $query->with('ci_item')
                ->orderBy('id', 'asc');
        }])->findOrFail($sale_contract_id);
        
        // Calculate totals
        $totals = [
            'total_ctn' => 0,
            'total_amount_acc' => 0,
            'total_amount_party' => 0,
            'total_amount' => 0,
            'total_cbm' => 0,
            'total_gross_weight_kg' => 0,
            'pcs_in_carton' => 0,
        ];
        
        foreach ($sale_contract->sale_contract_details as $detail) {
            $totals['total_ctn'] += (isset($detail->ctn) ? $detail->ctn : 0);
            $totals['total_amount_acc'] += (isset($detail->total_amount_acc) ? $detail->total_amount_acc : 0);
            $totals['total_amount_party'] += (isset($detail->total_amount_party) ? $detail->total_amount_party : 0);
            $totals['total_amount'] += (isset($detail->total_amount) ? $detail->total_amount : 0);
            $totals['total_cbm'] += (isset($detail->total_cbm) ? $detail->total_cbm : 0);
            $totals['total_gross_weight_kg'] += (isset($detail->gross_weight_kg) ? $detail->gross_weight_kg : 0);
            $totals['pcs_in_carton'] += (isset($detail->pcs_in_ctn) ? $detail->pcs_in_ctn : 0);
        }
        
        // Generate HTML for table rows
        $html = '';
        $key = 0;
        
        foreach ($sale_contract->sale_contract_details as $sale_contract_detail) {

            $prev = $sale_contract->sale_contract_details->get($key-1);
            $next = $sale_contract->sale_contract_details->get($key+1);
            $html .= '<tr>';
            $html .= '<td><input type="checkbox" class="sub_chk" data-id="' . $sale_contract_detail->id . '"></td>';
            $html .= '<td>' . (isset($sale_contract_detail->ci_item->ci_item_code) ? $sale_contract_detail->ci_item->ci_item_code : '') . '</td>';
            $html .= '<td>';
            $html .= 'CI:' . (isset($sale_contract_detail->ci_item_name) ? $sale_contract_detail->ci_item_name : '') . '</br>';
            $html .= 'Desk:' . (isset($sale_contract_detail->desk_item_name) ? $sale_contract_detail->desk_item_name : '');
            $html .= '</td>';
            $html .= '<td>' . (isset($sale_contract_detail->hs_code) ? $sale_contract_detail->hs_code : '') . ' <br>' . (isset($sale_contract_detail->hs_code_2) ? $sale_contract_detail->hs_code_2 : '') . '</td>';
            $html .= '<td>' . (isset($sale_contract_detail->ctn) ? $sale_contract_detail->ctn : 0) . '</td>';
            
            // Always show all columns without permission checks
            $html .= '<td>' . (isset($sale_contract_detail->rate_per_ctn_for_acc) ? $sale_contract_detail->rate_per_ctn_for_acc : 0) . '</td>';
            $html .= '<td>' . (isset($sale_contract_detail->total_amount_acc) ? $sale_contract_detail->total_amount_acc : 0) . '</td>';
            $html .= '<td style="background-color:#958d13ed;color:white">' . (isset($sale_contract_detail->rate_per_ctn_for_party) ? $sale_contract_detail->rate_per_ctn_for_party : 0) . '</td>';
            $html .= '<td style="background-color:#958d13ed;color:white">' . (isset($sale_contract_detail->total_amount_party) ? $sale_contract_detail->total_amount_party : 0) . '</td>';
            
            $html .= '<td style="background-color:#958d13ed;color:white">' . (isset($sale_contract_detail->rate_per_ctn) ? $sale_contract_detail->rate_per_ctn : 0) . '</td>';
            $html .= '<td style="background-color:#958d13ed;color:white">' . (isset($sale_contract_detail->total_amount) ? $sale_contract_detail->total_amount : 0) . '</td>';
            
            $html .= '<td>' . number_format((isset($sale_contract_detail->cbm_per_ctn) ? $sale_contract_detail->cbm_per_ctn : 0), 3) . '</td>';
            $html .= '<td>' . number_format((isset($sale_contract_detail->total_cbm) ? $sale_contract_detail->total_cbm : 0), 3) . '</td>';
            $html .= '<td>' . (isset($sale_contract_detail->gross_weight_kg) ? $sale_contract_detail->gross_weight_kg : 0) . '</td>';
            $html .= '<td>' . (isset($sale_contract_detail->pcs_in_ctn) ? $sale_contract_detail->pcs_in_ctn : 0) . '</td>';
            $html .= '<td>';
            
            // Always show edit buttons
            $html .= '<button type="button" 
                    class="btn btn-xs btn-success btn-flat edit-desk-btn" 
                    data-id="' . \Crypt::encrypt($sale_contract_detail->id) . '"
                    data-party-id="' . \Crypt::encrypt($party_id) . '">Edit Desk</button>';
            
            $html .= '<button type="button" 
                    class="btn btn-xs btn-primary btn-flat edit-ci-btn" 
                    data-id="' . \Crypt::encrypt($sale_contract_detail->id) . '"
                    data-party-id="' . \Crypt::encrypt($party_id) . '"
                    data-sc-id="' . \Crypt::encrypt($sale_contract_detail->sale_contract_id) . '"
                    data-type="ci">Edit CI</button>';
            
            $html .= '</td>';
            $html .= '</tr>';
            
            $key++;
        }
        
        // Total row
        $html .= '<tr style="background: #0a1c7be8;color: white;">';
        $html .= '<td></td>';
        $html .= '<td><strong>Total</strong></td>';
        $html .= '<td></td>';
        $html .= '<td></td>';
        $html .= '<td><span id="totalCtn" style="font-weight: bold;">' . $totals['total_ctn'] . '</span></td>';
        
        // All columns for total row
        $html .= '<td></td>';
        $html .= '<td><span id="total_amount_accc" style="font-weight: bold;">' . $totals['total_amount_acc'] . '</span></td>';
        $html .= '<td></td>';
        $html .= '<td><span id="total_amount_partyy" style="font-weight: bold;">' . $totals['total_amount_party'] . '</span></td>';
        
        $html .= '<td></td>';
        $html .= '<td><span id="total_amount" style="font-weight: bold;">' . $totals['total_amount'] . '</span></td>';
        
        $html .= '<td></td>';
        $html .= '<td><span id="total_cbm" style="font-weight: bold;">' . number_format($totals['total_cbm'], 3) . '</span></td>';
        $html .= '<td><span id="total_gross_weight_kg" style="font-weight: bold;">' . $totals['total_gross_weight_kg'] . '</span></td>';
        $html .= '<td><span id="pcs_in_carton" style="font-weight: bold;">' . $totals['pcs_in_carton'] . '</span></td>';
        $html .= '<td></td>';
        $html .= '</tr>';
        
        return response()->json([
            'success' => true,
            'html' => $html,
            'totals' => $totals
        ], 200); // Explicitly set 200 status
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error loading data: ' . $e->getMessage(),
            'html' => '<tr><td colspan="15" class="text-center text-danger">Error loading data</td></tr>'
        ], 500);
    }
}


}