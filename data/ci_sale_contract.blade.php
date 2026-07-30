<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">Sale Contract for  CI 
    @if($sale_contract->approver_id == null && $sale_contract_details->first())
    <a class="noprint" href="{{url('/sale_contract/'.$sale_contract->id)}}/approve"><button style=" font-size: 30px;" class="btn btn-xs btn-success">Approve</button></a>
    @endif
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
   
    </h1>
</section>
</div>
<?php $invoice_date=$sale_contract->invoice_date?>
<?php if(!empty($invoice_date) && $invoice_date<="2019-11-17"){ ?>
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
    }
    .noprint {display:none;}
}
@page {margin-top:75px}
</style>
<div class="row" style="margin-top:-29px;">
<br>
<br>
<br>
        <div class="col-md-12">
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr>
                     <td colspan="8" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong  style="font-size:15px;">SALES CONTRACT </strong></td>                  
                  </tr>
                  <tr>
                     <td colspan="1">
                         <strong>SALES CONTRACT NO:{{$sale_contract->sales_contract_no}}</strong><br>
                         <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                     </td> 
                     <td colspan="7">
                        <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                        <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                     </td>                  
                  </tr>
                  <tr>
                     <td colspan="@if($sale_contract->importer_id == 1){{'1'}}@else{{'1'}}@endif">
                        <strong>EXPORTER / SHIPPER:</strong><br>
                        <pre style="margin-top:0px;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>FACTORY: {{$sale_contract->company->factory_address}} </pre>            
                     </td> 
                     
                    @if($sale_contract->importer_id != 1)
                     <td colspan="3">
                        <strong>IMPORTER</strong><br>
                        <pre style="margin-top:0px;">{{$sale_contract->importer->name}}<br>{{$sale_contract->importer->address}}</pre>
                     </td> 
                     @endif
                     <td colspan="@if($sale_contract->importer_id == 1){{'7'}}@else{{'4'}}@endif">
                        <strong>@if($sale_contract->importer_id == 1){{'IMPORTER'}}@else{{' NOTIFY PARTY'}}@endif</strong><br>
                        <pre style="margin-top:0px;">{{$sale_contract->notify_pary->name}}<br>{{$sale_contract->notify_pary->address}}</pre>
                     </td>                  
                  </tr>

                  <tr>
                     <td colspan="1"><strong>BENEFICIARY'S BANK:</strong>
                      <pre style="margin-top:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                     </td> 
                     <td colspan="7">
                     <pre style="margin-top:0px;"><strong>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                        </pre>
                     </td>                                       
                  </tr>   


                  <tr style="text-align:center;">
                     <td colspan="1"><strong>PRODUCT DESCRIPTION</strong></td> 
                     <td colspan="1"><strong>SIZE<br>gm/ml</strong></td> 
                     <td colspan="1"><strong>UNIT<br>/CTN</strong></td> 
                     <td colspan="1"><strong>HS<br> CODE</strong></td> 
                     <td colspan="1"><strong>TOTAL<br>CTNS</strong></td>  
                     <td colspan="1"><strong>TOTAL<br>PCS</strong></td> 
                     <td colspan="1"><strong>RATE(USD)/CTN</strong></td> 
                     <td colspan="1"><strong>TOTAL <br> VALUE</strong></td> 
                  </tr>
                    
                 
       
                  <?php $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount = 0;?>
                  @foreach ($sale_contract_details as $sale_contract_detail)
            
                        <tr style="text-align:right;">
                            <td colspan="1" style="text-align:left;">{{$sale_contract_detail->duplicate_name}}</td>
                            <td colspan="1">{{$sale_contract_detail->p_net_weight}}</td>
                            <td colspan="1">{{$sale_contract_detail->ci_factor}}</td>
                            <td colspan="1">{{$obj->get_first_hs_code($sale_contract->id,$sale_contract_detail->ci_item_name)}}</td>
                            <td colspan="1">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                            <td colspan="1">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                            <td colspan="1">${{round($sale_contract_detail->total_amount/$sale_contract_detail->ctn,3)}}</td>
                            <td colspan="1">$ {{number_format(round($sale_contract_detail->total_amount,2),2)}} <?php $total_amount+=$sale_contract_detail->total_amount ;?></td>
                        </tr>
                   @endforeach  
              

                  <tr style="text-align:right;">
                     <td colspan="1" style="text-align:left;"><strong>TOTAL</strong></td> 
                     <td colspan="1"></td>
                     <td colspan="1"></td>
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong>{{$total_ctn}}</strong></td>  
                     <td colspan="1"><strong>{{$total_pcs_in_ctn}}</strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong>$ {{number_format(round($total_amount,2),2)}}</strong></td> 
                  </tr>
                   @if($sale_contract->container_1 || $sale_contract->container_2 || $sale_contract->container_3)
                  <tr>
                     <td colspan="8"><strong>CONTAINER:
                        {{$sale_contract->container_1}}
                        @if($sale_contract->container_1)
                             {{","}}
                        @endif
                        {{$sale_contract->container_2}} 
                        @if($sale_contract->container_2)
                             {{","}}
                        @endif
                        {{$sale_contract->container_3}}
                     </strong></td>                  
                  </tr>
                  @endif
                  <tr>
                     <td colspan="8"><strong>TERMS AND CONDITIONS:</strong><br>
                     <pre style="margin-top:0px;">{{$sale_contract->terms_and_condition}}</pre>                     
                     </td>                  
                  </tr>

            </tbody>
         </table>
      
      </div> <!-- col-md-12 end -->
</div>
<script>document.title = 'ci_sale_contract_{{$sale_contract->sales_contract_no}}';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "ci_sale_contract_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script> 
<?php } else {?>
 <!-- <link rel="stylesheet" href="{{asset('admin_template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}"> -->
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

    }
    .noprint {display:none;}
}
@page { margin-top:75px}
</style>
<div class="row" style="margin-top:-29px;">
<br>
<br>
<br>
        <div class="col-md-12">
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr>
                     <td colspan="8" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong  style="font-size:15px;">SALES CONTRACT </strong></td>                  
                  </tr>
                  <tr>
                     <td colspan="1">
                         <strong>SALES CONTRACT NO:{{$sale_contract->sales_contract_no}}</strong><br>
                         <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                     </td> 
                     <td colspan="7">
                        <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                        <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                     </td>                  
                  </tr>
                  <tr>
                     <td colspan="@if($sale_contract->importer_id == 1){{'1'}}@else{{'1'}}@endif">
                        <strong>EXPORTER / SHIPPER:</strong><br>
                        <pre style="margin-top:0px;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>FACTORY: {{$sale_contract->company->factory_address}} </pre>            
                     </td> 
                     
                     @if($sale_contract->importer_id != 1)
                     <td colspan="3">
                        <strong>IMPORTER</strong><br>
                        <pre style="margin-top:0px;">{{$sale_contract->importer->name}}<br>{{$sale_contract->importer->address}}</pre>
                     </td> 
                     @endif
                     <td colspan="@if($sale_contract->importer_id == 1){{'7'}}@else{{'4'}}@endif">
                        <strong>@if($sale_contract->importer_id == 1){{'IMPORTER'}}@else{{' NOTIFY PARTY'}}@endif</strong><br>
                        <pre style="margin-top:0px;">{{$sale_contract->notify_pary->name}}<br>{{$sale_contract->notify_pary->address}}</pre>
                     </td>                  
                  </tr>

                  <tr>
                     <td colspan="1"><strong>BENEFICIARY'S BANK:</strong>
                      <pre style="margin-top:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                     </td> 
                     <td colspan="7">
                     <pre style="margin-top:0px;"><strong>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                        </pre>
                     </td>                                       
                  </tr>   


                  <tr style="text-align:center;">
                     <td colspan="1"><strong>PRODUCT DESCRIPTION</strong></td> 
                     <td colspan="1"><strong>SIZE<br>gm/ml</strong></td> 
                     <td colspan="1"><strong>UNIT<br>/CTN</strong></td> 
                     <td colspan="1"><strong>HS<br> CODE</strong></td> 
                     <td colspan="1"><strong>TOTAL<br>CTNS</strong></td>  
                     <td colspan="1"><strong>TOTAL<br>PCS</strong></td> 
                     <td colspan="1"><strong>RATE<br>(USD)/CTN</strong></td> 
                     <td colspan="1"><strong>TOTAL <br> VALUE</strong></td> 
                  </tr>
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
                                     $carton_fright_pl_rate=round($caton_fright+$sale_contract_detail->rate_per_ctn, 3);
                                     

                                  }else{

                                    $carton_fright_pl_rate="0";

                                  }
                            }catch (Exception $e) {


                              
                            }      
                            
                        ?>
                        <tr style="text-align:right;">
                            <td colspan="1" style="text-align:left;">{{$sale_contract_detail->duplicate_name}}</td>
                            <td colspan="1">{{$sale_contract_detail->p_net_weight}}</td>
                            <td colspan="1">{{$sale_contract_detail->ci_factor}}</td>
                            <td colspan="1">{{$obj->get_first_hs_code($sale_contract->id,$sale_contract_detail->ci_item_name)}}</td>
                            <td colspan="1">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                            <td colspan="1">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                            <td colspan="1">$<?php echo $carton_fright_pl_rate?></td>
                            <td colspan="1">$
                               <?php
                                     
                                     echo number_format($carton_fright_pl_rate*$sale_contract_detail->ctn,2);
                                     $total_sum=$total_sum+round($carton_fright_pl_rate*$sale_contract_detail->ctn,2);

                                 ?>
                            </td>
                        </tr>
                   @endforeach  
                  <tr style="text-align:right;">
                     <td colspan="1" style="text-align:left;"><strong>TOTAL</strong></td> 
                     <td colspan="1"></td>
                     <td colspan="1"></td>
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong>{{$total_ctn}}</strong></td>  
                     <td colspan="1"><strong>{{$total_pcs_in_ctn}}</strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong>$ {{number_format(round($total_sum,2),2)}}</strong></td> 
                  </tr>
                   @if($sale_contract->container_1 || $sale_contract->container_2 || $sale_contract->container_3)
                  <tr>
                     <td colspan="8"><strong>CONTAINER:
                        {{$sale_contract->container_1}}
                        @if($sale_contract->container_1)
                             {{","}}
                        @endif
                        {{$sale_contract->container_2}} 
                        @if($sale_contract->container_2)
                             {{","}}
                        @endif
                        {{$sale_contract->container_3}}
                     </strong></td>                  
                  </tr>
                  @endif
                  <tr>
                     <td colspan="8"><strong>TERMS AND CONDITIONS:</strong><br>
                     <pre style="margin-top:0px;">{{$sale_contract->terms_and_condition}}</pre>                     
                     </td>                  
                  </tr>
            </tbody>
         </table>
      </div> <!-- col-md-12 end -->
</div>
<script>document.title = 'ci_sale_contract_{{$sale_contract->sales_contract_no}}';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "ci_sale_contract_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script>
<?php }?> 


