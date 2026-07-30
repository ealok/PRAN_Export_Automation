<div class="noprint">
    <section class="content-header noprint" style="padding-top: 0px;">
        <h1 style=" font-size: 30px;">All for  CI 
        <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>    
        <a href="{{url('/sale_contract/'.$sale_contract->id)}}/pad_pwl"><button style="float:right; font-size: 30px; margin-left:10px;">PAD</button></a>    
        <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1> 
    </section>
</div>
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
        page-break-after: always;
    }
    .noprint {display:none;}
}
@page {margin-top:110px; margin-bottom: 135px}
</style>
    <div class="row">
    <br>
    <br>
    <br>    
            <div class="col-md-12" style="margin-top: -40px">
            <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
                <tbody>
                      <tr>
                         <td colspan="11" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong  style="font-size:15px;">COMMERCIAL INVOICE AND PACKING & WEIGHT LIST</strong></td>                  
                      </tr>
                      <tr>
                         <td colspan="2" style="width: 500px">
                             <strong>INVOICE NO:{{$sale_contract->invoice_no}}</strong><br>
                             <strong>DATE:
                                @if(!empty($sale_contract->invoice_date))
                                  {{date("d-m-Y",strtotime( $sale_contract->invoice_date))}}
                                @else
                                  {{""}}
                                @endif
                              </strong>
                         </td> 
                         <td colspan="5">
                             <strong>@if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE"}}@else {{"SALES CONTRACT"}} @endif:{{$sale_contract->sales_contract_no}}</strong><br>
                             <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                         </td> 
                         <td colspan="4">
                            <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                            <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                         </td>                  
                      </tr>
                      <tr>
                         
                         <td colspan="2">
                            <strong>EXP NO:<span style="color: #222;font-weight: bold;font-family: 'Arial Narrow'">{{$sale_contract->export_no}}</strong>
                         </td>  
                         <td colspan="5">
                             <strong>EXP DATE: <span style="color: #222;font-weight: bold;font-family: arial-narrow;">{{date("d-m-Y",strtotime( $sale_contract->export_date))}}</strong>
                         </td> 
                         <td colspan="4">
                             {{$sale_contract->ci_note}}
                         </td>                 
                      </tr>
                      <tr>
                         <td colspan="@if($sale_contract->importer_id == 1){{'2'}}@else{{'2'}}@endif">
                            <strong>EXPORTER / SHIPPER:</strong><br>
                            <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>FACTORY: {{$sale_contract->company->factory_address}} </pre>            
                         </td> 
                         
                         @if($sale_contract->importer_id != 1)
                         <td colspan="5">
                            <strong>IMPORTER</strong><br>
                            @if($sale_contract->address_replace==1)
                            <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                            @else
                            <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                            @endif
                         </td> 
                         @endif
                         <td colspan="@if($sale_contract->importer_id == 1){{'9'}}@else{{'4'}}@endif">
                            <strong>@if($sale_contract->importer_id == 1){{'IMPORTER'}}@else{{' NOTIFY PARTY'}}@endif</strong><br>
                            @if($sale_contract->address_replace==1)
                            <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre> 
                            @else
                            <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                            @endif
                         </td>                  
                      </tr>
    
                      <tr>
                         <td colspan="2"><strong>BENEFICIARY'S BANK:</strong>
                            <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                         </td> 
                         @if($sale_contract->notify_pary_id==798)
                         <td colspan="9">
                           <pre style="margin-top:0px;font-weight: bold;"><strong>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                           </pre>
                         </td>
                         @else
                         @if($sale_contract->third_notify_party)
                         <td colspan="5">
                           <strong>ALSO NOTIFY PARTY</strong><br>
                            <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->third_notify_party}}</pre>
                         </td>
                         @endif
                         <td colspan="@if($sale_contract->third_notify_party){{'4'}}@else{{'9'}}@endif">
                            <pre style="margin-top:0px;font-weight: bold;"><strong>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                            </pre>
                         </td>   
                         @endif                                    
                      </tr>   
    
                      <?php 
                           
                          try { 
    
                              $total_net_weight=$total_net_weight;
                              $freight_cost=$sale_contract->freight_cost;
                              $per_unit_freight=$freight_cost/$total_net_weight;
    
                          }catch (Exception $e) {
    
    
                          }    
                           
                      ?>
                      <tr style="text-align:center;">
                         <td colspan="1"><strong>MARKS&nbsp;&<br>NOS</strong></td>
                         <td colspan="1" style="width: 340px"><strong>PRODUCT DESCRIPTION</strong></td>  
                         <td colspan="1" style="width: 40px"><strong>SIZE<br>gm/ml</strong></td> 
                         <td colspan="1" style="width: 40px"><strong>UNIT<br>/CTN</strong></td> 
                         <td colspan="1" style="width: 60px"><strong>HS<br> CODE</strong></td> 
                         <td colspan="1" style="width: 50px"><strong>TOTAL<br>CTNS</strong></td>  
                         <td colspan="1" style="width: 40px"><strong>TOTAL<br>PCS</strong></td> 
                         <td colspan="1" style="width: 100px"><strong>RATE<br>USD/CTN</strong></td> 
                         <td colspan="1" style="width: 200px"><strong>TOTAL <br> VALUE(USD)</strong></td> 
                         <td colspan="1"><strong>NET <br> WEIGHT <br> KG</strong></td> 
                         <td colspan="1"><strong>GROSS <br> WEIGHT <br> KG</strong></td>
                      </tr>
    
                
                      <?php $i=0; $total_sum=0; ?>
                      <?php $key=0; $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount = 0; $net_weight_kg_total = 0; $gross_weight_kg_total = 0; ?>
                      @foreach ($sale_contract_details as $sale_contract_detail)
                           <?php 
                                 try { 
                                      if($sale_contract_detail->ci_factor!=0){
    
                                         $per_net_weight_kg_fright=$per_unit_freight*$sale_contract_detail->net_weight_kg;
                                         
                                         $caton_fright=$per_net_weight_kg_fright/$sale_contract_detail->ctn;
                                         
    
                                         $carton_fright_pl_rate=round($caton_fright+$sale_contract_detail->rate_per_ctn,3);
    
                                      }else{
    
                                        $carton_fright_pl_rate="0";
    
                                      }
                                }catch (Exception $e) {
    
    
                                  
                                }      
                                
                            ?>                   
                            <tr style="text-align:right;">
                                <td colspan="1" style="width:60px;font-weight: bold;"><?php echo $nocs_array[$i++]?></td>
                                <td colspan="1" style="text-align:left;width: 340px;font-weight: bold;">{{$sale_contract_detail->ci_item_name}}</td>
                                <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->p_net_weight}}</td>
                                <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->ci_factor}}</td>
                                <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->hs_code}}</td>
                                <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                                <td colspan="1" style="width: 100px;font-weight: bold;">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                                <td colspan="1" style="font-weight: bold">${{$carton_fright_pl_rate}}</td>
                                <td colspan="1" style="width:200px;font-weight: bold">$
                                     <?php
                                         
                                         echo number_format($carton_fright_pl_rate*$sale_contract_detail->ctn,2);
                                         $total_sum=$total_sum+round($carton_fright_pl_rate*$sale_contract_detail->ctn,2);
    
                                     ?>
                                </td>
                                <td colspan="1" style="font-weight: bold;">{{number_format($sale_contract_detail->net_weight_kg,2)}} <?php $net_weight_kg_total+=$sale_contract_detail->net_weight_kg ;?></td>
                                <td colspan="1" style="font-weight: bold;">{{number_format($sale_contract_detail->gross_weight_kg,2)}} <?php $gross_weight_kg_total+=$sale_contract_detail->gross_weight_kg ;?></td>
                            </tr>
                       @endforeach
                      <tr style="text-align:right;">
                         <td colspan="1" style="text-align:left;">TOTAL</td>
                         <td colspan="1"><strong></strong></td>  
                         <td colspan="1"><strong></strong></td> 
                         <td colspan="1"><strong></strong></td> 
                         <td colspan="1"><strong></strong></td> 
                         <td colspan="1"><strong>{{$total_ctn}}</strong></td>  
                         <td colspan="1"><strong>{{$total_pcs_in_ctn}}</strong></td> 
                         <td colspan="1"><strong></strong></td> 
                         <td colspan="1"><strong>$<?php echo number_format($total_sum,2)?></strong></td> 
                         <td colspan="1"><strong>{{number_format($net_weight_kg_total,2)}}</strong></td> 
                         <td colspan="1"><strong>{{number_format($gross_weight_kg_total,2)}}</strong></td>
                      </tr> 
                       @if($sale_contract->container_1 || $sale_contract->container_2 || $sale_contract->container_3)
                      <tr>
                         <td colspan="11"><strong>CONTAINER: 
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
    
                         <td colspan="11"><strong>TERMS AND CONDITIONS:</strong>
                         <p style="margin-top: -1px;font-weight: bold;">1. QUANTITY, QUALITY, RATE AND ALL OTHER DETAILS OF GOODS ARE IN THE ACCORDENCE WITH<br> 
                          SALE CONTRACT NO :{{$sale_contract->sales_contract_no}} ,DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}<br>
                          2. SOME PROMOTIONAL ITEM MAY GO IN THIS INVOICE WHICE HAVE NO COMMERCIAL VALUE
                          <BR>
                          {{$sale_contract->terms_and_condition_desk_inv}}
                         </p>                     
                         </td>                  
                      </tr>  
    
                </tbody>
             </table>
          
          </div> <!-- col-md-12 end -->
    </div> 

    <script>document.title = 'ci_all_{{$sale_contract->sales_contract_no}} | {{$sale_contract->company->code}}';
    function exportF(elem) {
      var table = document.getElementById("inv");
      var html = table.outerHTML;
      var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
      elem.setAttribute("href", url);
      elem.setAttribute("download", "ci_all_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
      return false;
    }
    </script>
    
    
    
    
    
    
    