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
        page-break-after: always;
    }
    .noprint {display:none;}
}
</style>

<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style="font-size: 30px;">ACC PACKAGING  
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1> 
</section>
</div>


<div class="row">
<br>
<br>
        <div class="col-md-12">
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr>
                     <td colspan="11" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong style="font-size:15px;">PACKING & WEIGHT </strong></td>                  
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
                         <strong>EXP Date:</strong>{{date("d-m-Y",strtotime( $sale_contract->export_date))}}
                     </td> 
                     <td colspan="3">
                         {{$sale_contract->ci_note}}
                     </td>                
                  </tr>
                  <tr>
                     <td colspan="@if($sale_contract->importer_id == 1){{'6'}}@else{{'5'}}@endif">
                        <strong>EXPORTER / SHIPPER:</strong><br>
                        <pre style="margin-top:0px;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>FACTORY: {{$sale_contract->company->factory_address}} </pre>            
                     </td> 
                     
                     @if($sale_contract->importer_id != 1)
                     <td colspan="3">
                        <strong>IMPORTER</strong><br>
                        <pre style="margin-top:0px;">{{$sale_contract->importer->name}}<br>{{$sale_contract->importer->address}}</pre>
                     </td> 
                     @endif
                     <td colspan="@if($sale_contract->importer_id == 1){{'5'}}@else{{'3'}}@endif">
                        <strong>@if($sale_contract->importer_id == 1){{'IMPORTER'}}@else{{' NOTIFY PARTY'}}@endif</strong><br>
                        <pre style="margin-top:0px;">{{$sale_contract->notify_pary->name}}<br>{{$sale_contract->notify_pary->address}}</pre>
                     </td>                  
                  </tr>

                 

                  <tr>
                     <td colspan="@if($sale_contract->bank_importer_id == 1){{'6'}}@else{{'5'}}@endif"><strong>BENEFICIARY'S BANK:</strong>
                        <pre style="margin-top:0px;  border:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                     </td> 
                     @if($sale_contract->bank_importer_id != 1)
                     <td colspan="3"><strong>IMPORTER'S BANK:</strong>
                        <pre style="margin-top:0px;  border:0px;">{{$sale_contract->bank_importer->bank_name}}<br>{{$sale_contract->bank_importer->account_name}}<br>{{$sale_contract->bank_importer->branch}}<br>AC/IBAN:{{$sale_contract->bank_importer->ac_or_iban}}<br>SWIFT CODE: {{$sale_contract->bank_importer->swift_code}}</pre>
                     </td> 
                     @endif

                     <td colspan="@if($sale_contract->bank_importer_id == 1){{'5'}}@else{{'3'}}@endif">
                        <pre style="margin-top:0px;  border:0px;"><strong><br>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                        </pre>
                     </td>                                       
                  </tr>      


                  <tr style="text-align:center;">
                     <td colspan="1" style="width:60px;"><strong>MARKS&nbsp;&&nbsp;NOS</strong></td> 
                     <td colspan="@if($sale_contract_details ->first()) @if($sale_contract_details ->first()->mfg) {{'1'}} @else {{'3'}}  @endif @endif"><strong>PRODUCT DESCRIPTION</strong></td>
                     @if($sale_contract_details ->first()) @if($sale_contract_details ->first()->mfg)
                     <td colspan="1"><strong>@if($sale_contract_details ->first()) @if($sale_contract_details ->first()->mfg)  MFG @endif @endif</strong></td> 
                     <td colspan="1"><strong>@if($sale_contract_details ->first()) @if($sale_contract_details ->first()->mfg)  EXP @endif @endif</strong></td> 
                     @endif @endif
                     <td colspan="1"><strong>SIZE<br>gm/ml</strong></td> 
                     <td colspan="1"><strong>UNIT<br>/CTN</strong></td> 
                     <td colspan="1"><strong>HS<br> CODE</strong></td> 
                     <td colspan="1"><strong>TOTAL<br>CTNS</strong></td>  
                     <td colspan="1"><strong>TOTAL<br>PCS</strong></td> 
                     <td colspan="1"><strong>NET <br> WEIGHT <br> KG</strong></td> 
                     <td colspan="1"><strong>GROSS <br> WEIGHT <br> KG</strong></td>
                  </tr>

         

                  <?php  $key=0; $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount = 0; $net_weight_kg_total = 0; $gross_weight_kg_total = 0; ?>
                  @foreach ($sale_contract_details as $sale_contract_detail)
                        <?php $prev = $sale_contract_details->get($key-1);$next = $sale_contract_details->get($key+1);?>
                        <tr style="text-align:right;">
                            <td  style="width:60px;">
                                @if(!$prev){{'1-'.$sale_contract_detail->ccq}}
                                @else {{(int)$prev['ccq']+1 .'-'.$sale_contract_detail->ccq}}
                                @endif
                            </td>
                            <td colspan="@if($sale_contract_details ->first()) @if($sale_contract_details ->first()->mfg) {{'1'}} @else {{'3'}}  @endif @endif" style="text-align:left;">{{$sale_contract_detail->desk_item_name}}</td>
                            @if($sale_contract_details ->first()) @if($sale_contract_details ->first()->mfg)
                            <td colspan="1">@if($sale_contract_detail->mfg){{date("d-m-Y",strtotime($sale_contract_detail->mfg))}}@endif</td>
                            <td colspan="1">@if($sale_contract_detail->exp){{date("d-m-Y",strtotime($sale_contract_detail->exp))}}@endif</td>
                            @endif @endif
                            <td colspan="1">{{$sale_contract_detail->ci_item->p_net_weight}}</td>
                            <td colspan="1">{{$sale_contract_detail->ci_item->ci_factor}}</td>
                            <td colspan="1">{{$sale_contract_detail->hs_code}}@if($sale_contract_detail->hs_code_2)<br>{{$sale_contract_detail->hs_code_2}}@endif</td>
                            <td colspan="1">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                            <td colspan="1">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                            <td colspan="1">{{number_format($sale_contract_detail->net_weight_kg,2)}} <?php $net_weight_kg_total+=$sale_contract_detail->net_weight_kg ;?></td>
                            <td colspan="1">{{number_format($sale_contract_detail->gross_weight_kg,2)}} <?php $gross_weight_kg_total+=$sale_contract_detail->gross_weight_kg ;?></td>
                        </tr>
                        <?php $key++; ?>
                   @endforeach  
     
               
                  <tr style="text-align:right;">
                     <td colspan="1" style="text-align:left; width:10px;">TOTAL</td>
                     <td colspan="@if($sale_contract_details ->first()) @if($sale_contract_details ->first()->mfg) {{'1'}} @else {{'3'}}  @endif @endif"><strong></strong></td>  
                     @if($sale_contract_details ->first()) @if($sale_contract_details ->first()->mfg)
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong></strong></td>  
                     @endif @endif
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong>{{$total_ctn}}</strong></td>  
                     <td colspan="1"><strong>{{$total_pcs_in_ctn}}</strong></td> 
                     <td colspan="1"><strong>{{number_format($net_weight_kg_total,2)}}</strong></td> 
                     <td colspan="1"><strong>{{number_format($gross_weight_kg_total,2)}}</strong></td>
                  </tr> 

                  @if($sale_contract->container_1)
                  <tr style="text-align:right;">
                     <td colspan="11"  style="text-align:left;"><strong>CONTAINER: {{$sale_contract->container}}</strong></td> 
                     
                  </tr>
                  @endif

                  @if($sale_contract->container_2)
                  <tr style="text-align:right;">
                     <td colspan="11"  style="text-align:left;"><strong>CONTAINER: {{$sale_contract->container_2}}</strong></td> 
                  </tr>
                  @endif

                  @if($sale_contract->container_3)
                  <tr style="text-align:right;">
                     <td colspan="11"  style="text-align:left;"><strong>CONTAINER: {{$sale_contract->container_3}}</strong></td> 
                  </tr>
                  @endif

                
                  <tr>
                     <td colspan="11"><strong>TERMS AND CONDITIONS:</strong><br>
                     <pre style="margin-top:0px;">1. QUANTITY, QUALITY, RATE AND ALL OTHER DETAILS OF GOODS ARE IN THE ACCORDENCE WITH 
@if($sale_contract->is_revised == 1){{"REVISED "}}@endif @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE "}}@else {{"SALES CONTRACT "}}@endif NO :{{$sale_contract->sales_contract_no}} , {{date("d-m-Y",strtotime( $sale_contract->dated))}}
2. SOME PROMOTIONAL ITEM MAY GO IN THIS INVOICE WHICE HAVE NO COMMERCIAL VALUE
                     </pre>                     
                     </td>                  
                  </tr>  

            </tbody>
         </table>
     
      
      </div> <!-- col-md-12 end -->
</div> 


<script>document.title = 'acc_packaging_{{$sale_contract->sales_contract_no}}';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "acc_packaging_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script>





