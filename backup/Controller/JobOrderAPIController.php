<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Vat;
use App\SaleContract;
class JobOrderAPIController extends Controller
{   
	public function vatJOBOrderInfo($job_number){
        
        return $result = Vat::select('job_order_number AS JOB_NUMBER', 'item_code AS ITEM_CODE', 'item_Name as ITEM_NAME','invoice_no AS INVOICE_NO','sales_contact_no AS SC_NUMBER',"rate AS RATE")
                ->where('job_order_number',$job_number)
                ->get();

    }

    public function vatSaleContactInfo($invoice_no){
        
        return $result = Vat::select('job_order_number AS JOB_NUMBER', 'item_code AS ITEM_CODE', 'item_Name as ITEM_NAME','invoice_no AS INVOICE_NO','sales_contact_no AS SC_NUMBER',"rate AS RATE")
                ->where('invoice_no', 'like', '%' . $invoice_no . '%')
                ->get(100);

    }

     public function vatGetSaleContactList($invoice_no){

       $first_day_this_month = date('Y-m-01');
       $last_day_this_month  = date('Y-m-t'); 
       
       return $results=\DB::select("select sale_contracts.sales_contract_no as sale_contact_no,
            sale_contracts.invoice_no as invoice_no,
            companies.code as company_name
        from  sale_contracts
        join companies on companies.id=sale_contracts.company_id
        where sale_contracts.invoice_no like  '%$invoice_no%'"); 

     }

    
}
