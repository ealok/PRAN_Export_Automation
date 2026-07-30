<style>

*{
    font-size: 9px;
    font-family: "Arial Narrow", Arial, sans-serif;
    font-weight: bold
}

table {
  border-collapse: collapse;
}

@media print {
    .row {
        clear: both;
        page-break-after: always;
    }
    .noprint {display:none;}
}

@page {margin-bottom: 150px;margin-top: 100px}

</style>

<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">SALES CONTRACT DESK
     <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/sc_desk_pad"><button style="float:right; font-size: 30px; margin-left:10px;">PAD</button></a>
     <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
</section>
</div>
<div class="row">
<br>
<br>
<br>
        <div class="col-md-12" style="margin-top: -30px">
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr>
                     <td colspan="9" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong  style="font-size:15px;">
                         @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE"}}@else {{"SALES CONTRACT"}} @endif
                     </strong></td>                  
                  </tr>
                  <tr>
                     <td colspan="1">
                         <strong> @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT NO"}} @endif:{{$sale_contract->sales_contract_no}}</strong><br>
                         <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                     </td> 
                     <td colspan="@if($sale_contract->ci_note){{'3'}}@else{{'8'}}@endif">
                        <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                        <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                     </td>
                     @if($sale_contract->ci_note)
                     <td colspan="5">
                        {{$sale_contract->ci_note}}
                     </td>
                     @endif                  
                  </tr>
                  <tr>
                     <td colspan="@if($sale_contract->importer_id == 1){{'1'}}@else{{'1'}}@endif">
                        <strong>EXPORTER / SHIPPER:</strong>
                        @if($sale_contract->notify_pary_id==1289)
                        <pre style="margin-top: -9px;">                       
{{$sale_contract->company->name}}
PRAN RFL CENTER,<br>105 PRAGATI SARANI MIDDLE BADDA,   
DHAKA-1212. BANGLADESH 
@if($factory_address)FACTORY: {{$factory_address}}@endif
                        </pre>
                        @else
                        <pre>
{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}
@if($factory_address)FACTORY: {{$factory_address}}@endif
                        </pre>
                        @endif
                             
                     </td> 
                     
                     @if($sale_contract->importer_id != 1)
                     <td colspan="3">
                        <strong>@if($sale_contract->is_notify_also_notity==1){{"NOTIFY PARTY"}}@else{{"IMPORTER"}}@endif</strong><br>
                        @if($sale_contract->address_replace==1)
                          <pre style="margin-top:0px;">{{$sale_contract->party_name}}<br><?php echo wordwrap($sale_contract->party_address,100, "\n", true);?></pre>
                        @else
                          <pre style="margin-top:0px;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                        @endif
                     </td> 
                     @endif
                     <td colspan="@if($sale_contract->importer_id == 1){{'8'}}@elseif($sale_contract->is_hscode2==1){{'6'}}@else{{'5'}}@endif">
                        <strong>
                            @if($sale_contract->importer_id == 1)
                                {{"IMPORTER"}}
                            @elseif ($sale_contract->is_notify_also_notity==1)
                                {{"ALSO NOTIFY PARTY"}}
                            @else
                                {{"NOTIFY PARTY"}}
                            @endif 
                        </strong>
                        @if($sale_contract->address_replace==1)
                           <pre style="margin-top:0px;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                        @else
                           <pre style="margin-top:0px;">{{$sale_contract->party_name}}<br><?php echo wordwrap($sale_contract->party_address,100, "\n", true);?></pre>
                        @endif
                     </td>                  
                  </tr>
                  <tr>
                     <td colspan="@if($sale_contract->bank_importer_id == 1){{'1'}}@else{{'1'}}@endif">@if($sale_contract->is_bank)<strong>BENEFICIARY'S BANK:@endif</strong>
                        @if($sale_contract->is_bank)
                           <pre style="margin-top:0px;  border:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                        @endif
                     </td> 
                     @if($sale_contract->bank_importer_id != 1)
                        <td colspan="3"><strong>IMPORTER'S BANK:</strong>
                          <pre style="margin-top:0px;  border:0px;">{{$sale_contract->bank_importer->bank_name}}<br>{{$sale_contract->bank_importer->account_name}}<br>{{$sale_contract->bank_importer->branch}}<br>AC/IBAN:{{$sale_contract->bank_importer->ac_or_iban}}<br>SWIFT CODE: {{$sale_contract->bank_importer->swift_code}}</pre>
                        </td>  
                     @elseif($sale_contract->add_also_notify_party==1) 
                        <td colspan="3"><strong>ALSO NOTIFY PARTY:</strong>
                           <pre style="margin-top:0px;  border:0px;">{{$sale_contract->third_notify_party}}</pre>
                        </td>   
                     @endif
                     <td colspan="@if($sale_contract->bank_importer_id == 1){{'8'}}@else{{'5'}}@endif">
                        <pre style="margin-top:0px;  border:0px;"><strong><br>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                        </pre>
                     </td>                                       
                  </tr>   

                  <tr style="text-align:center;">
                     <td colspan="1"><strong>PRODUCT DESCRIPTION</strong></td> 
                     <td colspan="1"><strong>SIZE<br>gm/ml</strong></td> 
                     <td colspan="1"><strong>UNIT<br>CTN/BAG</strong></td> 
                     <td colspan="1"><strong>@if($sale_contract->is_hscode2==1){!! "BD <br>HS CODE" !!}@else{!! "HS<br>CODE" !!}@endif</strong></td> 
                     @if($sale_contract->is_hscode2==1)
                     <td colspan="1"><strong>{!! "NEPAL HS<br>CODE" !!}</strong></td>     
                     @endif
                     <td colspan="1"><strong>TOTAL<br>CTNS/BAG</strong></td>
                     <td colspan="1"><strong>TOTAL<br>PCS/BAG</strong></td> 
                     <td colspan="1"><strong>RATE<br>CTN/BAG(USD)</strong></td>
                     <td colspan="1"><strong>TOTAL<br>VALUE(USD)</strong></td> 
                  </tr>
                    
                 
      
                  <?php $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount = 0;?>
                  @foreach ($sale_contract_details  as $sale_contract_detail)
                        <tr style="text-align:right;">
                            <td colspan="1" style="text-align:left;">{{$sale_contract_detail->desk_item_name}}</td>
                            <td colspan="1">{{$sale_contract_detail->ci_item->p_net_weight}}</td>
                            <td colspan="1">{{$sale_contract_detail->ci_item->ci_factor}}</td>
                            <td colspan="1" style="text-align: center">{{$sale_contract_detail->hs_code}}<br>{{$sale_contract_detail->hs_code_2}}</td>
                            @if($sale_contract->is_hscode2==1)
                            <td colspan="1" style="text-align: center">{{$sale_contract_detail->hs_code_2}}</td>
                            @endif
                            <td colspan="1">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                            <td colspan="1">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?></td>
                            <td colspan="1">$ {{number_format(round($sale_contract_detail->rate_per_ctn_for_party,3),3)}}</td>
                            <td colspan="1">$ {{number_format($sale_contract_detail->total_amount_party,2)}} <?php $total_amount+=$sale_contract_detail->total_amount_party ;?></td>
                        </tr>
                   @endforeach  
                   
                  <tr style="text-align:right;">
                     <td colspan="1" style="text-align:left;"><strong>TOTAL</strong></td> 
                     <td colspan="1"></td>
                     <td colspan="1"></td>
                     @if($sale_contract->is_hscode2==1)
                     <td colspan="1"></td>
                     @endif
                     <td colspan="2"><strong>{{$total_ctn}}</strong></td>
                     <td colspan="1"><strong>{{$total_pcs_in_ctn}}</strong></td>  
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong>$ {{number_format($total_amount+$sale_contract->other_charge,2)}}</strong></td> 
                  </tr>

                  <?php 

                       $freight=0;
                       $freight=$sale_contract->desk_freight_cost;
                       $other_charge=$sale_contract->other_charge;
                       $total_cfr=$freight+$total_amount;
                       $insurance_charge=$insurance_charge;
                       $pallet_charge=$pallet_charge;
                    
                  ?>
                  <?php if($insurance_charge || $pallet_charge || $freight || $pallet_charge) { ?>     
                      
                      <?php if($freight && $insurance_charge) { $total_cif=$total_cfr+$insurance_charge;?>
                         <tr style="text-align:right;">
                           <td colspan="@if($sale_contract->is_hscode2==1){{'8'}}@else{{'7'}}@endif"  style="text-align:left;"><strong>FREIGHT:</strong></td>  
                           <td colspan="1"><strong>$ {{number_format($freight,2)}} </strong></td> 
                         </tr>
                        <tr style="text-align:right;">
                           <td colspan="@if($sale_contract->is_hscode2==1){{'8'}}@else{{'7'}}@endif"  style="text-align:left;"><strong>INSURANCE:</strong></td>  
                           <td colspan="1"><strong>$ {{number_format($insurance_charge,2)}} </strong></td> 
                        </tr>
                        <tr style="text-align:right;">
                           <td colspan="@if($sale_contract->is_hscode2==1){{'8'}}@else{{'7'}}@endif"  style="text-align:left;"><strong>TOTAL CIF:</strong></td>  
                           <td colspan="1"><strong>$ {{number_format($total_cif,2)}}</strong></td> 
                        </tr>
                      <?php  } else if($freight && $pallet_charge) { $total_crf_with_pallet=$total_cfr+$pallet_charge; ?>
                         <tr style="text-align:right;">
                           <td colspan="@if($sale_contract->is_hscode2==1){{'8'}}@else{{'7'}}@endif"  style="text-align:left;"><strong>FREIGHT:</strong></td>  
                           <td colspan="1"><strong>$ {{number_format($freight,2)}} </strong></td> 
                        </tr>
                        <tr style="text-align:right;">
                           <td colspan="@if($sale_contract->is_hscode2==1){{'8'}}@else{{'7'}}@endif"  style="text-align:left;"><strong>PALLET:</strong></td>  
                           <td colspan="1"><strong>$ {{number_format($pallet_charge,2)}} </strong></td> 
                        </tr>
                        <tr style="text-align:right;">
                           <td colspan="@if($sale_contract->is_hscode2==1){{'8'}}@else{{'7'}}@endif"  style="text-align:left;"><strong>TOTAL CRF (WITH PALLET)</strong></td>  
                           <td colspan="1"><strong>$ {{number_format($total_crf_with_pallet,2)}}</strong></td> 
                        </tr>
                      <?php } else if($pallet_charge) {?>
                         <tr style="text-align:right;">
                            <td colspan="@if($sale_contract->is_hscode2==1){{'8'}}@else{{'7'}}@endif"  style="text-align:left;"><strong>PALLET:</strong></td>  
                            <td colspan="1"><strong>$ {{number_format($pallet_charge,2)}} </strong></td> 
                          </tr>
                          <tr style="text-align:right;">
                            <td colspan="@if($sale_contract->is_hscode2==1){{'8'}}@else{{'7'}}@endif"  style="text-align:left;"><strong>TOTAL CRF(WITH PALLET)</strong></td>  
                            <td colspan="1"><strong>$ {{number_format($total_amount+$pallet_charge,2)}}</strong></td> 
                          </tr>
                      <?php } else if ($freight) {?>
                          <tr style="text-align:right;">
                             <td colspan="@if($sale_contract->is_hscode2==1){{'8'}}@else{{'7'}}@endif"  style="text-align:left;"><strong>FREIGHT:</strong></td>  
                             <td colspan="1"><strong>$ {{number_format($freight,2)}} </strong></td> 
                          </tr>
                          <tr style="text-align:right;">
                             <td colspan="@if($sale_contract->is_hscode2==1){{'8'}}@else{{'7'}}@endif"  style="text-align:left;"><strong>TOTAL CFR:</strong></td>  
                             <td colspan="1"><strong>$ {{number_format($total_cfr,2)}}</strong></td> 
                          </tr> 
                      <?php }?> 
                  <?php }?>    
                  @if($sale_contract->container_1 || $sale_contract->container_2 || $sale_contract->container_3)
                  <tr style="text-align:right;">
                     <td colspan="9" style="text-align:left;text-align: left;"><strong>CONTAINER:</strong>
                           {{$sale_contract->container_1}}
                           @if($sale_contract->container_1)
                             {{","}}
                           @endif
                           {{$sale_contract->container_2}} 
                           @if($sale_contract->container_2)
                             {{","}}
                           @endif
                           {{$sale_contract->container_3}}
                     </td> 
                  </tr>
                  @endif  
                   <tr>
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
                     <pre style="margin-top:0px;min-height: 72px;">{{ $cleaned_terms }}</pre>
                   </td>
                 </tr>
                   </tr>
                      <td colspan="9" style="border-left: hidden;border-right: hidden;border-bottom: hidden">
                           @if($sale_contract->footer_importer_address == 1)
                              <pre  style="margin-top:35px; float:right;">{{$sale_contract->notify_pary->name}}<br>{{$sale_contract->notify_pary->address}}</pre>
                           @endif
                      </td>
                  </tr>
            </tbody>
         </table> 
      </div> <!-- col-md-12 end -->
</div> 


<script>document.title = 'desk_sale_contract_{{$sale_contract->sales_contract_no}}';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "desk_sale_contract_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script>





