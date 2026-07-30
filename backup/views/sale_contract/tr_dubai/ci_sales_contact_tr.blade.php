<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">Sale Contract for  TR
    <?php use App\Http\Controllers\AdminController;?>
     @if(AdminController::isAccessable(31))
    <a class="noprint" href="{{url('/sale_contract/'.$sale_contract->id)}}/approve"><button style=" font-size: 30px;" class="btn btn-xs btn-success">Approve</button></a>
    @endif
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
   
    </h1>
</section>
</div>
 <!-- <link rel="stylesheet" href="{{asset('admin_template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}"> -->
<style>
*{
    font-size: 10px;
    font-family: arial Narrow
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
@page { margin-top:110px; margin-bottom: 135px}
</style>
<div class="row">
<br>
<br>
<br>    
        <div class="col-md-12" style="margin-top: -40px">
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
                        <pre style="margin-top:0px;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                     </td> 
                     @endif
                     <td colspan="@if($sale_contract->importer_id == 1){{'7'}}@else{{'4'}}@endif">
                        <strong>@if($sale_contract->importer_id == 1){{'IMPORTER'}}@else{{' NOTIFY PARTY'}}@endif</strong><br>
                        <pre style="margin-top:0px;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
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
                     <td colspan="1" style="width: 100px"><strong>TOTAL <br> VALUE USD</strong></td> 
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
                            <td colspan="1" style="text-align:left;font-weight: bold;">{{$sale_contract_detail->duplicate_name}}</td>
                            <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->p_net_weight}}</td>
                            <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->ci_factor}}</td>
                            <td colspan="1" style="font-weight: bold;">{{$obj->get_first_hs_code($sale_contract->id,$sale_contract_detail->ci_item_name)}}</td>
                            <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                            <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                            <td colspan="1" style="font-weight: bold;">{{'$'}}<?php echo $carton_fright_pl_rate?></td>
                            <td colspan="1" style="font-weight: bold;">{{'$'}}
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
                     <td colspan="1"><strong><span>{{'$'}}{{number_format(round($total_sum,2),2)}}</span></strong></td> 
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
                  @php

                  $lines = explode("\n", $sale_contract->terms_and_condition);
                  $filtered_lines = array_filter($lines, function($line) {
                      return stripos($line, 'EXPIRY OF THIS SALES CONTRACT ON') === false;
                  });
                  $cleaned_terms = implode("\n", $filtered_lines);
                  
                @endphp
              
              <tr>
                  <td colspan="9" style="@if($sale_contract->footer_importer_address == 1) border-bottom:0px solid white; @endif">
                      <strong>TERMS AND CONDITIONS:</strong><br>
                      <pre style="margin-top:0px;height: 72px;">{{ $cleaned_terms }}</pre>
                  </td>
              </tr>
                  <tr>
                      <td colspan="8" style="border-left: hidden;border-right: hidden;border-bottom: hidden">
                           @if($sale_contract->footer_importer_address == 1)
                              <pre  style="margin-top:35px; float:right;">{{$sale_contract->notify_pary->name}}<br>{{$sale_contract->notify_pary->address}}</pre>
                           @endif
                      </td>
                  </tr>
            </tbody>
         </table>
      </div> <!-- col-md-12 end -->
</div>
<script>document.title = 'ci_sale_contract_{{$sale_contract->sales_contract_no}} | {{$sale_contract->company->code}}';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "ci_sale_contract_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script>


