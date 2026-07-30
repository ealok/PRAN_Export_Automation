<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
class ApiController extends Controller
{
    public function getInvoiceList(Request $request){
         
        
        return $results=DB::select("select sale_contracts.invoice_no
            from sale_contracts
            join job_order_masters on job_order_masters.sale_contract_id=sale_contracts.id
            where job_order_masters.created_at>=SUBDATE(current_date(), interval 90 day)
            and (job_order_masters.job_order_do_number is not null or job_order_masters.job_order_do_number='')
            group by sale_contracts.invoice_no");
    }

}
