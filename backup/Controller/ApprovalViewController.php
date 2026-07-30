<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\SaleContract;
use App\UserFeatures;
use Auth;
class ApprovalViewController extends Controller
{
    
    public function __construct(){

        $this->middleware('auth');
 
    }

    public function pedingJobOrderEd(){
       
        $ids = [48];
        $idToCheck = Auth::user()->id;
        if(in_array($idToCheck, $ids)){

            $sale_contracts=SaleContract::where('matching_status',2)
                            ->where('show_status','E')
                            ->where('mail_status','Y')
                            ->get();
            return view('job_order.pending_job_order_ed')
                ->with('sale_contracts',$sale_contracts);

        }else{

            return view("limited_access");
        }  
        
              
    }

    public function pedingJobOrderMD(){
       
      

        $ids = [230,316,1,275];
        $idToCheck = Auth::user()->id;
        if(in_array($idToCheck, $ids)){

            $sale_contracts = SaleContract::where('matching_status', 2)
                ->whereIn('show_status', ['M', 'S'])
                ->where('mail_status', 'Y')
                ->get();

            return view('job_order.pending_job_order_md')
                ->with('sale_contracts',$sale_contracts);

        }else{

            return view("limited_access");
        }      
              
    }

    public function pedingJoApprovalList(){

        $sale_contracts = SaleContract::where('matching_status', 2)
                        ->where('mail_status', 'Y')
                        ->whereIn('show_status', ['S'])
                        ->get();
                                     
        return view('job_order.pending_job_order_list')
               ->with('sale_contracts',$sale_contracts);
    }


}
