<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\SaleContract;
use App\UserFeatures;
use DB;
use Auth;
class ApprovalViewController extends Controller
{
    
    public function __construct(){

        $this->middleware('auth');
 
    }

    public function pedingJobOrderEd(){
       
        // $ids = [48];
        // $idToCheck = Auth::user()->id;
        // if(in_array($idToCheck, $ids)){

            $sale_contracts=SaleContract::where('matching_status',2)
                            ->where('show_status','E')
                            ->where('mail_status','Y')
                            ->get();
            return view('job_order.pending_job_order_ed')
                ->with('sale_contracts',$sale_contracts);

        // }else{

        //     return view("limited_access");
        // }  
        
              
    }

    public function pedingJobOrderMD(){
       
        // $ids = [230,316,1,275];
        // $idToCheck = Auth::user()->id;
        // if(in_array($idToCheck, $ids)){

            $sale_contracts = SaleContract::where('matching_status', 2)
                ->whereIn('show_status', ['M', 'S'])
                ->where('mail_status', 'Y')
                ->get();

            return view('job_order.pending_job_order_md')
                ->with('sale_contracts',$sale_contracts);

        // }else{

        //     return view("limited_access");
        // }      
              
    }

    public function managementApproval(){

        return view('job_order.management_approval_order_list');
    }

    public function getPendingApprovals()
    {
        $pendingApprovals = DB::table('sale_contracts')
            ->select(
                'sale_contracts.id as sc_id',
                'notify_parties.name as party_name',
                'sale_contracts.invoice_no',
                'notify_parties.country',
                'ci_items.ci_item_code as item_code',
                'ci_items.ci_item_name as item_name',
                'sale_contract_details.pcs_in_ctn as pcs_qty',
                'sale_contract_details.ctn as ctn_qty',
                'sale_contract_details.per_piece_rate as fob',
                'sale_contract_details.prime_cost',
                'sale_contract_details.rate_percent as gp',
                'sale_contract_details.rate_status as status',
                'sale_contract_details.total_amount_acc as total_value',
                'sale_contract_details.id as detail_id',
                'users.name as user',
                DB::raw("DATE_FORMAT(sale_contracts.created_at, '%d-%m-%Y') as mail_send_date")
            )
            ->join('sale_contract_details', 'sale_contract_details.sale_contract_id', '=', 'sale_contracts.id')
            ->join('notify_parties', 'notify_parties.id', '=', 'sale_contracts.notify_pary_id')
            ->join('ci_items', 'ci_items.id', '=', 'sale_contract_details.ci_item_id')
            ->join('users', 'users.id', '=', 'sale_contracts.creator_id')
            ->where('sale_contracts.mail_status', 'Y')
            ->where('sale_contracts.inactive', 'N')
            ->whereIn('sale_contract_details.rate_status', ['M','S'])
            ->get();

        $groupedApprovals = [];
        foreach($pendingApprovals as $item) {
            $invoiceNo = $item->invoice_no;
            if(!isset($groupedApprovals[$invoiceNo])) {
                $groupedApprovals[$invoiceNo] = [
                    'sc_id' => $item->sc_id,
                    'invoice_no' => $item->invoice_no,
                    'party_name' => $item->party_name,
                    'country' => $item->country,
                    'status' => $item->status,
                    'mail_send_date' => $item->mail_send_date,
                    'user' => $item->user,
                    'details' => []
                ];
            }
            
            $groupedApprovals[$invoiceNo]['details'][] = [
                'item_code' => $item->item_code,
                'item_name' => $item->item_name,
                'pcs_qty' => $item->pcs_qty,
                'ctn_qty' => $item->ctn_qty,
                'fob' => $item->fob,
                'prime_cost' => $item->prime_cost,
                'gp' => $item->gp,
                'total_value' => $item->total_value,
                'detail_id' => $item->detail_id
            ];
        }

        $filteredApprovals = array_filter($groupedApprovals, function($invoice) {
            return !empty($invoice['details']) && count($invoice['details']) > 0;
        });
        
        $filteredApprovals = array_values($filteredApprovals);
        return response()->json([
            'status' => 'success',
            'data' => $filteredApprovals
        ]);
    }

}
