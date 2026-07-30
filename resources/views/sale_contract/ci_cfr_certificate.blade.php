<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="return updateExpDuplicateTask()">Print</button></h1>
</section>
</div>
<style>

*{
    font-size: 9px;
}

table {
  border-collapse: collapse;
}
table, th, td {
  border: 1px solid black;
}


@media print {
    .row {
        clear: both;
        page-break-after: always;
    }
    .noprint {display:none;}
}
</style>
<?php 
     
    try { 

        $total_net_weight=$total_net_weight;
        $freight_cost=$sale_contract->freight_cost;
        $per_unit_freight=$freight_cost/$total_net_weight;

    }catch (Exception $e) {


    }    
     
?>
<?php $total_pcs_in_ctn = 0; $total_ctn = 0; $total_sum = 0;?>
   @foreach ($sale_contract_details as $sale_contract_detail)
       <?php 
           try { 
                if($sale_contract_detail->ci_factor!=0){

                   $per_net_weight_kg_fright=$per_unit_freight*$sale_contract_detail->net_weight_kg;
                   $caton_fright=$per_net_weight_kg_fright/$sale_contract_detail->ctn;
                   $carton_fright_pl_rate=round($caton_fright+$sale_contract_detail->rate_per_ctn,3);
                   $total_sum=$total_sum+round($carton_fright_pl_rate*$sale_contract_detail->ctn,2);


                }
          }catch (Exception $e) { }          
     ?>
 @endforeach
<div class="row">
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>    
        <div class="col-md-16">
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr> 
                     <td colspan="2" width="70px" style="border:hidden">&nbsp;</td>
                     <td colspan="3" style="border:hidden;">
                       <span style="font-size: 16px"><span style="font-weight: bold;font-size: 15px;font-family: 'Times New Roman', Times, serif;">Date: <span style="font-size: 13px;font-weight: normal;"><?php echo $today = date("d-m-Y");?></span></span></span>
                       <pre style="border:0px;font-size: 13px;font-family: 'Times New Roman', Times, serif;">THE MANAGER<br>{{$sale_contract->bank->name}}<br>{{$sale_contract->bank->branch}}<br>{{$sale_contract->bank->address}}<br></pre>
                     </td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;">Subject:</span><span style="font-size: 16px;font-style: bold"> Application for CFR certificate under invoice no: <span style="font-size: 13px">{{$sale_contract->invoice_no}}</span>,<span style="font-weight: bold;font-size: 13px"> <br> <span style="font-size: 14px"></span>DATE: @if($sale_contract->invoice_date){{date("d-m-Y",strtotime( $sale_contract->invoice_date))}}@endif And EXP NO : {{$sale_contract->export_no}}, EXP DATE: @if($sale_contract->export_date){{date("d-m-Y",strtotime( $sale_contract->export_date))}}@endif</span></span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;"><br><br>Dear Sir,</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><br>We have exported <span style="font-size: 14px;font-weight: bold;">{{$ctn}}</span> Cartons of PRAN products to <span style="font-size: 12px;font-weight: bold;">EMERGING WORLD FZC. WH# B1-30,<br>GATE NO-1, POST BOX NO: 21031, AJMAN FREE ZONE,AJMAN, U.A.E.</span> Under the above mention <br>invoice number.The document in respect of the shipment under this EXP form be <br>negotiated/accepted only when these are drawn on CFR basis and not on FOB basis.</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px;font-weight: bol"><br>The other necessary information are-</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;">
                        <span style="font-size: 16px;font-weight: bold">
                           1. Freight Forwarder License Number : 
                           @if($sale_contract->frightForwarder && $sale_contract->frightForwarder->license_number)
                                 {{ $sale_contract->frightForwarder->license_number }}
                           @endif
                           <br>
                           
                           2. Freight Forwarder Name : 
                           @if($sale_contract->frightForwarder && $sale_contract->frightForwarder->shipping_name)
                                 {{ $sale_contract->frightForwarder->shipping_name }}
                           @endif
                           <br>
                           
                           3. Name Of Airline/Shipping Line : 
                           @if($sale_contract->shippingLine && $sale_contract->shippingLine->shipping_name)
                                 {{ $sale_contract->shippingLine->shipping_name }}
                           @endif
                           <br>
                           
                           4. Master Bill Of Lading/Airway Bill No : 
                           {{ $sale_contract->bl_no ?: '' }}
                           <br>
                           
                           5. Master Bill Of Lading/Airway Bill Date : 
                           @if($sale_contract->bl_date)
                                 {{ date('d-m-Y', strtotime($sale_contract->bl_date)) }}
                           @endif
                           <br>
                           
                           6. HAWB/HBL No : 
                           {{ $sale_contract->master_airway_bill_no ?: '' }}
                           <br>
                           
                           7. HAWB/HBL Date : 
                           @if($sale_contract->master_airway_bill_date)
                                 {{ date('d-m-Y', strtotime($sale_contract->master_airway_bill_date)) }}
                           @endif
                           <br>
                           
                           8. Freight and Other Charges (FC) : 
                           {{ $sale_contract->freight_amount_fc ?: '' }}
                           <br>
                           
                           9. Freight and Other Charges (BDT) : 
                           {{ $sale_contract->freight_amount_btd ?: '' }}
                        </span>
                     </td>
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px;font-weight: bol"><br> Please issue a CFR Certificate for this invoice number.</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px">
                       <br><br><br><br><br><br>Thanking You.<br><br><br><br><br><br><span style="font-size: 13px">{{$company_name}}</span><br>
                     </span></td>                 
                  </tr> 
            </tbody>
         </table>
      </div> <!-- col-md-16 end -->
</div> 

<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script>document.title = 'CFR Report-{{$sale_contract->company->name}}';
   function exportF(elem) {
      var table = document.getElementById("inv");
      var html = table.outerHTML;
      var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
      elem.setAttribute("href", url);
      elem.setAttribute("download", "cfr_report_{{$sale_contract->company->code}}.xls"); // Choose the file name
      return false;
   }

   function updateExpDuplicateTask(){

      var x = confirm("Are you sure want to print?");
      if (x){

         print1();
         print2();

      }else{

         return false;

      }

   }

   function print1(){

      var task_id=10;
      var sc_id={{$sale_contract->id}};
      var url = "{{url('/')}}"+"/update/task/exp_duplicate?sc_id="+sc_id+"&task_id="+task_id;
      $.get(url, function( data ) {


         console.log(data);
            

      });

   }

   function print2(){

      window.print();

   }
</script>





