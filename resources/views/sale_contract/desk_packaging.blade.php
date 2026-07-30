<!-- <link rel="stylesheet" href="{{asset('admin_template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}"> -->
<style>

*{
    font-size: 10px;
    font-family: "Arial Narrow", Arial, sans-serif;
    font-weight: bold
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
@page { margin-top:100px;margin-bottom: 150px;}
</style>

<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style="font-size: 30px;">DESK PACKAGING  
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packing_pad"><button style="float:right; font-size: 30px; margin-left:10px;">PAD</button></a>
    <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1> 
</section>
</div>

<div class="row">
<br>
<br>
        <div class="col-md-12" style="margin-top: -20px;">
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr>
                     <td colspan="11" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong style="font-size:15px;">PACKING & WEIGHT LIST</strong></td>                  
                  </tr>
                  <tr>
                     <td colspan="5">
                         <strong>INVOICE NO:{{$sale_contract->invoice_no}}</strong><br>
                         <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->invoice_date))}}</strong>
                     </td> 
                     <td colspan="3">
                         <strong>
                         @if($sale_contract->is_revised == 1){{"REVISED "}}@endif
                         @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE"}}@else {{"SALES CONTRACT"}} @endif NO:{{$sale_contract->sales_contract_no}}</strong><br>
                         <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                     </td> 
                     <td colspan="3">
                        <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                        <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                     </td>                  
                  </tr>
                  <tr>
                      
                     <td colspan="5">
                        <strong>EXP NO:</strong> {{$sale_contract->export_no}}
                     </td>  
                     <td colspan="3">
                         <strong>EXP DATE:</strong>{{date("d-m-Y",strtotime( $sale_contract->export_date))}}
                     </td> 
                     <td colspan="3">
                         {{$sale_contract->ci_note}}
                     </td>                
                  </tr>
                  <tr>
                     <td colspan="@if($sale_contract->importer_id == 1){{'6'}}@else{{'5'}}@endif">
                        <strong>EXPORTER / SHIPPER:</strong><br>
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
                        <strong>
                           @if($sale_contract->importer_id == 1)
                           {{"NOTIFY PARTY"}}
                           @elseif ($sale_contract->is_notify_also_notity==1)
                           {{"ALSO NOTIFY PARTY"}}
                           @else
                           {{"IMPORTER"}}
                           @endif
                        </strong><br>
                        @if($sale_contract->address_replace==1)
                          <pre style="margin-top:0px;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                        @else
                          <pre style="margin-top:0px;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                        @endif
                     </td> 
                     @endif
                     <td colspan="@if($sale_contract->importer_id == 1){{'5'}}@else{{'3'}}@endif">
                        <strong>
                            @if($sale_contract->importer_id == 1)
                                 @if($sale_contract->billed_to)
                                    {{"BILLED TO"}}
                                 @else
                                    {{"NOTIFY PARTY"}}
                                 @endif
                            @elseif ($sale_contract->is_notify_also_notity==1)
                                {{"ALSO NOTIFY PARTY"}}
                            @else
                                 @if($sale_contract->billed_to)
                                    {{"BILLED TO"}}
                                 @else
                                    {{"NOTIFY PARTY"}}
                                 @endif
                            @endif
                        </strong><br>
                        @if($sale_contract->address_replace==1)
                          <pre style="margin-top:0px;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                        @else
                          <pre style="margin-top:0px;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                        @endif
                     </td>                  
                  </tr>

               
                  <tr>
                     <td colspan="@if($sale_contract->bank_importer_id == 1){{'5'}}@else{{'5'}}@endif">@if($sale_contract->is_bank)<strong>BENEFICIARY'S BANK:</strong>@endif
                        @if($sale_contract->is_bank) <pre style="margin-top:0px;  border:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>@endif
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
                     <td colspan="@if($sale_contract->bank_importer_id == 1){{'6'}}@else{{'3'}}@endif">
                        <pre style="margin-top:0px;  border:0px;"><strong><br>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                        </pre>
                     </td>                                       
                  </tr>      

                  <tr style="text-align:center;">
                     <td colspan="1" style="width:60px;"><strong>MARKS&nbsp;&<br>&nbsp;NOS</strong></td> 
                     <td colspan="3"><strong>PRODUCT DESCRIPTION</strong></td>
                     <td colspan="1"><strong>SIZE<br>gm/ml</strong></td> 
                     <td colspan="1"><strong>UNIT<br>CTN/BAG</strong></td> 
                     <td colspan="1"><strong>HS<br>CODE</strong></td> 
                     <td colspan="1"><strong>TOTAL<br>CTNS/BAG</strong></td>  
                     <td colspan="1"><strong>TOTAL<br>PCS/BAG</strong></td> 
                     <td colspan="1"><strong>NET<br>WEIGHT<br>KG/LTR</strong></td> 
                     <td colspan="1"><strong>GROSS<br>WEIGHT<br>KG/LTR</strong></td>
                  </tr>

         
                  <?php $i=0;?>
                  <?php $sale_contract_details = $sale_contract_details  ; $key=0; $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount = 0; $net_weight_kg_total = 0; $gross_weight_kg_total = 0; ?>
                  @foreach ($sale_contract_details as $sale_contract_detail) 
                  <tr style="text-align:right;">
                        <td  style="width:60px;"><?php echo $nocs_array[$i++]?></td>
                        <td colspan="3" style="text-align:left;">{{$sale_contract_detail->desk_item_name}}</td>
                        <td colspan="1">{{$sale_contract_detail->ci_item->p_net_weight}}</td>
                        <td colspan="1">{{$sale_contract_detail->ci_item->ci_factor}}</td>
                        <td colspan="1">{{$sale_contract_detail->hs_code}}@if($sale_contract_detail->hs_code_2)<br>{{$sale_contract_detail->hs_code_2}}@endif</td>
                        <td colspan="1">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                        <td colspan="1">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                        <td colspan="1">{{number_format($sale_contract_detail->net_weight_kg,2)}} <?php $net_weight_kg_total+=$sale_contract_detail->net_weight_kg ;?></td>
                        <td colspan="1">{{number_format($sale_contract_detail->gross_weight_kg,2)}} <?php $gross_weight_kg_total+=$sale_contract_detail->gross_weight_kg ;?></td>
                  </tr>
                  @endforeach
                  <tr style="text-align:right;">
                     <td colspan="1" style="text-align:left; width:10px;">TOTAL</td>
                     <td colspan="3"><strong></strong></td>    
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong>{{$total_ctn}}</strong></td>  
                     <td colspan="1"><strong>{{$total_pcs_in_ctn}}</strong></td> 
                     <td colspan="1"><strong>{{ number_format($net_weight_kg_total,2)}}</strong></td> 
                     <td colspan="1"><strong>{{ number_format($gross_weight_kg_total,2)}}</strong></td>
                  </tr> 
                  @if($sale_contract->container_1 || $sale_contract->container_2 || $sale_contract->container_3)
                  <tr style="text-align:right;">
                     <td colspan="12" style="text-align:left;text-align: left;border-right: 1px solid"><strong>CONTAINER:</strong>
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
                     <td colspan="11"><strong>TERMS AND CONDITIONS:</strong><br>
                     <p style="margin-top:0px;">1. QUANTITY, QUALITY, RATE AND ALL OTHER DETAILS OF GOODS ARE IN THE ACCORDANCE WITH<br> 
@if($sale_contract->is_revised == 1){{"REVISED "}}@endif @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE "}}@else {{"SALES CONTRACT "}}@endif NO :{{$sale_contract->sales_contract_no}} , DATE: {{date("d-m-Y",strtotime( $sale_contract->dated))}}<br>
{{$sale_contract->terms_and_condition_desk_inv}}
</p>

                     </pre>                     
                     </td>                  
                  </tr>  

            </tbody>
         </table>
     
      
      </div> <!-- col-md-12 end -->
</div> 


<script>document.title = 'desk_packaging_{{$sale_contract->sales_contract_no}}';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "desk_packaging_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script>





