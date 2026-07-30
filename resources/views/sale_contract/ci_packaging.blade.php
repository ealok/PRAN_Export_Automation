<!-- <link rel="stylesheet" href="{{asset('admin_template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}"> -->

<style>

*{
    font-size: 9px;
    font-family: arial Narrow;
    font-weight: bold;
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

<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style="font-size: 30px;">PACKAGING for  CI  
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1> 
</section>
</div>


<div class="row" style="margin-top:-40px;">
<br>
<br>
<br>
        <div class="col-md-12">
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr>
                     <td colspan="9" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong style="font-size:15px;">PACKING & WEIGHT LIST</strong></td>                  
                  </tr>
                  <tr>
                     <td colspan="3">
                         <strong>INVOICE NO:{{$sale_contract->invoice_no}}</strong><br>
                         <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->invoice_date))}}</strong>
                     </td> 
                     <td colspan="3">
                         <strong>SALES CONTRACT NO:{{$sale_contract->sales_contract_no}}</strong><br>
                         <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                     </td> 
                     <td colspan="3">
                        <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                        <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                     </td>                  
                  </tr>
                  <tr>
                     
                     <td colspan="3">
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
                     <td colspan="@if($sale_contract->importer_id == 1){{'5'}}@else{{'3'}}@endif">
                        <strong>EXPORTER / SHIPPER:</strong><br>
                        <pre style="margin-top:0px;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>FACTORY: {{$sale_contract->company->factory_address}} </pre>            
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
                     <td colspan="@if($sale_contract->importer_id == 1){{'4'}}@else{{'3'}}@endif">
                        <strong>@if($sale_contract->importer_id == 1){{'IMPORTER'}}@else{{' NOTIFY PARTY'}}@endif</strong><br>
                        @if($sale_contract->address_replace==1)
                        <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre> 
                        @else
                        <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                        @endif
                     </td>                  
                  </tr>

                  <tr>
                     <td colspan="3"><strong>BENEFICIARY'S BANK:</strong>
                      <pre style="margin-top:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                     </td> 
                     @if($sale_contract->third_notify_party)
                     <td colspan="3">
                         <pre><strong>ALSO NOTIFY PARTY</strong><br>{{$sale_contract->third_notify_party}}</pre>
                     </td>
                     @endif 
                     <td colspan="@if($sale_contract->third_notify_party){{'4'}}@else{{'7'}}@endif">
                     <pre style="margin-top:0px;"><strong>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                        </pre>
                     </td>                                       
                  </tr>   


                  <tr style="text-align:center;font-weight: bold;">
                     <td colspan="1" style="width:75px;"><strong>MARKS&nbsp;&<br>NOS</strong></td> 
                     <td colspan="1"><strong>PRODUCT DESCRIPTION</strong></td> 
                     <td colspan="1"><strong>SIZE<br>gm/ml</strong></td> 
                     <td colspan="1"><strong>UNIT<br>/CTN</strong></td> 
                     <td colspan="1"><strong>HS<br> CODE</strong></td> 
                     <td colspan="1"><strong>TOTAL<br>CTNS</strong></td>  
                     <td colspan="1"><strong>TOTAL<br>PCS</strong></td> 
                     <td colspan="1"><strong>NET <br> WEIGHT <br> KG</strong></td> 
                     <td colspan="1"><strong>GROSS <br> WEIGHT <br> KG</strong></td>
                  </tr>

                  <?php $i=0;?>
                  <?php $sale_contract_details = $sale_contract_details ; $key=0; $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount = 0; $net_weight_kg_total = 0; $gross_weight_kg_total = 0; $prev_name=[];?>
                  @foreach($sale_contract_details as $sale_contract_detail)
                        <tr style="text-align:right;">
                            <td colspan="1"  style="width:75px;"><?php echo $nocs_array[$i++]?></td>
                            <td colspan="1" style="text-align:left;">{{$sale_contract_detail->ci_item_name}}</td>
                            <td colspan="1">{{$sale_contract_detail->p_net_weight}}</td>
                            <td colspan="1">{{$sale_contract_detail->ci_factor}}</td>
                            <td colspan="1">{{$sale_contract_detail->hs_code}}</td>
                            <td colspan="1">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                            <td colspan="1">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                            <td colspan="1">{{number_format($sale_contract_detail->net_weight_kg,2)}} <?php $net_weight_kg_total+=$sale_contract_detail->net_weight_kg ;?></td>
                            <td colspan="1">{{number_format($sale_contract_detail->gross_weight_kg,2)}} <?php $gross_weight_kg_total+=$sale_contract_detail->gross_weight_kg ;?></td>
                        </tr>
                   @endforeach
                  <tr style="text-align:right;">
                     <td colspan="1" style="text-align:left; width:10px;">TOTAL</td>
                     <td colspan="1"><strong></strong></td>  
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong>{{$total_ctn}}</strong></td>  
                     <td colspan="1"><strong>{{$total_pcs_in_ctn}}</strong></td> 
                     <td colspan="1"><strong>{{number_format($net_weight_kg_total,2)}}</strong></td> 
                     <td colspan="1"><strong>{{number_format($gross_weight_kg_total,2)}}</strong></td>
                  </tr> 

                 @if($sale_contract->container)  
                  <tr>
                     <td colspan="9"><strong>CONTAINER: {{$sale_contract->container}}</strong></td>                  
                  </tr>
                 @endif

                
                 <tr>
                     <td colspan="9"><strong>TERMS AND CONDITIONS:</strong><br>
                     <pre style="margin-top:0px;">1. QUANTITY, QUALITY, RATE AND ALL OTHER DETAILS OF GOODS ARE IN THE ACCORDENCE WITH 
SALE CONTRACT NO :{{$sale_contract->sales_contract_no}} ,DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}
2. SOME PROMOTIONAL ITEM MAY GO IN THIS INVOICE WHICE HAVE NO COMMERCIAL VALUE
                     </pre>                     
                     </td>                  
                  </tr> 

            </tbody>
         </table>
      
      </div> <!-- col-md-12 end -->
</div> 


<script>document.title = 'ci_packaging_{{$sale_contract->sales_contract_no}} | {{$sale_contract->company->code}}';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "ci_pwl_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script>





