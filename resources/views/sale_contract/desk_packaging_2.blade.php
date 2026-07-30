<!-- <link rel="stylesheet" href="{{asset('admin_template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}"> -->

<style>

*{
    font-size: 9px;
    font-family: "Arial Narrow", Arial, sans-serif;
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
@page {margin-bottom: 150px;margin-top: 100px}
</style>

<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style="font-size: 30px;">DESK PACKAGING  
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1> 
</section>
</div>


<div class="row">
<br>
<br>
        <div class="col-md-12" style="margin-top: -25px">
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
                        <pre style="margin-top:0px;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>@if($factory_address)FACTORY: {{$factory_address}}@endif</pre>            
                     </td> 
                     
                     @if($sale_contract->importer_id != 1)
                     <td colspan="3">
                        <strong>IMPORTER</strong><br>
                        @if($sale_contract->address_replace==1)
                        <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                        @else
                        <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                        @endif
                     </td> 
                     @endif
                     <td colspan="@if($sale_contract->importer_id == 1){{'5'}}@else{{'3'}}@endif">
                        <strong>@if($sale_contract->importer_id == 1){{'IMPORTER'}}@else{{' NOTIFY PARTY'}}@endif</strong><br>
                        @if($sale_contract->address_replace==1)
                        <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre> 
                        @else
                        <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                        @endif
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
                     <td colspan="3"><strong>PRODUCT DESCRIPTION</strong></td>
                     <td colspan="1"><strong>MFG</strong></td> 
                     <td colspan="1"><strong>EXP</strong></td> 
                     <td colspan="1" style="width:60px;"><strong>H.S.CODE</strong></td> 
                     <td colspan="1"><strong>BATCH NO</strong></td> 
                     <td colspan="1"><strong>PCS IN CTN</strong></td>  
                     <td colspan="1"><strong>TOTAL CARTON</strong></td> 
                     <td colspan="1"><strong>NET WEIGHT <br>IN(KGS)</strong></td> 
                     <td colspan="1"><strong>GROSS WEIGHT IN<br>KG</strong></td>
                  </tr>
                      <?php $i=1 ?>
                      <?php $total_carton=0; $net_weight=0; $gross_weight=0;?>
                      @foreach ($containerDetails as $sale_contract_detail) 
                        <tr><td colspan="11">{{$i++}}. {{$sale_contract_detail->container_no}}</td></tr>
                        <?php 

                            $results=DB::select("SELECT * FROM `sale_contract_details` WHERE sale_contract_details.sale_contract_id='$sale_contract_detail->sale_contract_id' AND sale_contract_details.container_no='$sale_contract_detail->container_no'"); 

                        ?>
                        @foreach($results as $result)
                        <tr style="text-align:right;">
                          <td colspan="3" style="text-align:left;">{{$result->ci_item_name}}</td>
                          <td colspan="1">{{$result->mfg}}</td>
                          <td colspan="1">{{$result->exp}}</td>
                          <td colspan="1">{{$result->hs_code}}</td>
                          <td colspan="1">{{$result->batch_no}}</td>
                          <td colspan="1">{{$result->pcs_in_ctn}}</td>
                          <td colspan="1">{{$result->ctn}}</td>
                          <td colspan="1">{{$result->net_weight_kg}}</td>
                          <td colspan="1">{{$result->gross_weight_kg}}</td>
                       </tr>
                       <?php 
                            $total_carton=$total_carton+$result->pcs_in_ctn;
                            $net_weight=$net_weight+$result->net_weight_kg;
                            $gross_weight=$gross_weight+$result->gross_weight_kg;
                       ?>
                       @endforeach
                       <tr style="text-align:right;">
                          <td colspan="8" style="text-align:left;"><strong>TOTAL:</strong></td>
                          <td colspan="1">{{$total_carton}}</td>
                          <td colspan="1">{{$net_weight}}</td>
                          <td colspan="1">{{$gross_weight}}</td>
                       </tr>
                       <?php $total_carton=0; $net_weight=0; $gross_weight=0;?>
                    @endforeach

                    @foreach($total_amounts as $total_amount)  
                    <tr style="text-align:right;">
                     <td colspan="3" style="text-align:left;"><strong>GRAND TOTAL</strong></td>
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong>{{$total_amount->ctn}}</strong></td> 
                     <td colspan="1"><strong>{{$total_amount->net_weight_kg}}</strong></td> 
                     <td colspan="1"><strong>{{$total_amount->gross_weight_kg}}</strong></td>
                  </tr>  
                  @endforeach

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





