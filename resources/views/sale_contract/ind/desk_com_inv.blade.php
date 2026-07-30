<style>

*{
    font-size: 10px;
    font-family: arial Narrow;
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
    <h1 style=" font-size: 30px;">DESK COM INV IND
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_invoice_ind_pad"><button style="float:right; font-size: 30px; margin-left:10px;">PAD</button></a>
    <button style="float:right; font-size: 30px;" onClick="makePrint()">Print</button></h1> 
</section>
</div>
<div class="row">
<br>
<br>
<br>
        <div class="col-md-12" style="margin-top: -25px">
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr>
                     <td colspan="11" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong  style="font-size:15px;">COMMERCIAL INVOICE AND PACKING & WEIGHT </strong></td>                  
                  </tr>
                  <tr>
                     <td colspan="2">
                         <strong>@if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT"}} @endif:{{$sale_contract->sales_contract_no}}</strong><br>
                         <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                     </td> 
                     <td colspan="5">
                         <strong>INVOICE NO:{{$sale_contract->invoice_no}}</strong><br>
                         <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->invoice_date))}}</strong>
                     </td> 
                     <td colspan="4">
                        <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                        <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                     </td>                  
                  </tr>
                  <tr>
                     
                     <td colspan="2">
                        <strong>EXP NO:</strong> {{$sale_contract->export_no}}
                     </td>  
                     <td colspan="5">
                         <strong>EXP Date:</strong>{{date("d-m-Y",strtotime( $sale_contract->export_date))}}
                     </td> 
                     <td colspan="4">
                         @if($sale_contract->shipping_mark_india){{"Shipping Mark:".$sale_contract->shipping_mark_india}}@endif
                     </td>                 
                  </tr>
                  <tr>
                     <td colspan="@if($sale_contract->importer_id == 1){{'2'}}@else{{'2'}}@endif">
                        <strong>EXPORTER / SHIPPER:</strong><br>
                        <pre style="margin-top:0px;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>@if($factory_address)FACTORY: {{$factory_address}}@endif</pre>            
                     </td> 
                     
                     @if($sale_contract->importer_id != 1)
                     <td colspan="5">
                        <strong>IMPORTER</strong><br>
                        <pre style="margin-top:0px;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                     </td> 
                     @endif
                     <td colspan="@if($sale_contract->importer_id == 1){{'9'}}@else{{'9'}}@endif">
                        <strong>@if($sale_contract->importer_id == 1){{'IMPORTER'}}@else{{' NOTIFY PARTY'}}@endif</strong><br>
                        <pre style="margin-top:0px;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                     </td>                  
                  </tr>

                  <tr>
                     <td colspan="2"><strong>BENEFICIARY'S BANK:</strong>
                      <pre style="margin-top:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                     </td> 
                     <td colspan="9">
                     <pre style="margin-top:0px;"><strong>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}<br>@if($sale_contract->salary_adjustment)<strong>PORT OF SHIPMENT:</strong>  {{"HILI L.C. STATION, BANGLADESH."}}@endif
                        </pre>
                     </td>                                       
                  </tr>   


                  <tr style="text-align:center;">
                     <td colspan="1"><strong>PRODUCT DESCRIPTION</strong></td>
                     <td colspan="1"><strong>SIZE<br>gm/ml</strong>  
                     <td colspan="1"><strong>UNIT<br>/CTN/BAG/<br>WRAPPER/TRAY</strong></td> 
                     <td colspan="1"><strong>HS<br> CODE</strong></td> 
                     <td colspan="1"><strong>TOTAL<br>CTN/BAG/<br>WRAPPER</strong></td>  
                     <td colspan="1"><strong>TOTAL<br>PCS</strong></td> 
                     <td colspan="1"><strong>RATE<br>/CTN/BAG/<br>WRAPPER/TRAY({{$sale_contract->currency->currency_name}})</strong></td>
                     <td colspan="1"><strong>RATE/CTN<br>OR LTR({{$sale_contract->currency->currency_name}})</strong></td>  
                     <td colspan="1"><strong>TOTAL <br> VALUE</strong></td> 
                     <td colspan="1"><strong>NET <br> WEIGHT <br> KG/LTR</strong></td> 
                     <td colspan="1"><strong>GROSS <br> WEIGHT <br> KG</strong></td>
                  </tr>

            
                   <?php $i=0;?> 
                  <?php $key=0; $sale_contract_details=$sale_contract_details ; $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount_party = 0; $net_weight_kg_total = 0; $gross_weight_kg_total = 0; ?>
                  @foreach ($sale_contract_details as $sale_contract_detail)
                     <tr style="text-align:right;">
                        <td colspan="1" style="text-align:left;">{{$sale_contract_detail->desk_item_name}}</td>
                        <td>{{$sale_contract_detail->p_net_weight}}</td>
                        <td colspan="1" style="text-align: center;">{{$sale_contract_detail->ci_factor}}</td>
                        <td colspan="1">{{$sale_contract_detail->hs_code}}@if($sale_contract_detail->hs_code_2)<br>{{$sale_contract_detail->hs_code_2}}@endif</td>
                        <td colspan="1">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                        <td colspan="1">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                        <td colspan="1">{{number_format(round($sale_contract_detail->rate_per_ctn_for_party*$exchange_rate,3),3)}}</td>
                        <td colspan="1">{{number_format($sale_contract_detail->total_amount_party*$exchange_rate/$sale_contract_detail->net_weight_kg,6)}}</td>
                        <td colspan="1">{{number_format(round($sale_contract_detail->total_amount_party*$exchange_rate,2),2)}} <?php $total_amount_party+=$sale_contract_detail->total_amount_party*$exchange_rate ;?></td>
                        <td colspan="1">{{number_format($sale_contract_detail->net_weight_kg,2)}} <?php $net_weight_kg_total+=$sale_contract_detail->net_weight_kg ;?></td>
                        <td colspan="1">{{number_format($sale_contract_detail->gross_weight_kg,2)}} <?php $gross_weight_kg_total+=$sale_contract_detail->gross_weight_kg ;?></td>
                     </tr>    
                  @endforeach  
                  <tr style="text-align:right;">
                     <td colspan="1" style="text-align: left;"><strong>GRAND TOTAL</strong></td><td colspan="1"><strong></strong></td>  
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong>{{$total_ctn}}</strong></td>  
                     <td colspan="1"><strong>{{$total_pcs_in_ctn}}</strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong></strong></td>
                     <td colspan="1"><strong>{{$sale_contract->currency->currency_name}} {{number_format(round($total_amount_party,2),2)}}</strong></td> 
                     <td colspan="1"><strong>{{number_format($net_weight_kg_total,2)}}</strong></td> 
                     <td colspan="1"><strong>{{number_format($gross_weight_kg_total,2)}}</strong></td>
                  </tr> 
                 <tr style="text-align:right;">
                     <td colspan="8" style="text-align: left;"><strong>FOB AMOUNT</strong></td>  
                     <td colspan="1"><strong>
                     <?php $total_amount=$total_amount_party-$freight_charge_india*$exchange_rate;?> 
                     {{$sale_contract->currency->currency_name}} {{number_format($total_amount,2)}}</strong></td>
                     <?php 

                        $total_amount_party=number_format(round($total_amount_party,2),2);
                        $total_amount_party=str_replace(",", "", $total_amount_party);

                     ?>
                     <td colspan="1"><strong><input type="hidden" name="total_amount" id="total_amount" value="{{$total_amount_party}}"></strong></td> 
                     <td colspan="1"><strong></strong></td>
                  </tr>  
                  <tr style="text-align:right;">
                     <td colspan="8" style="text-align: left;"><strong>FREIGHT CHARGE</strong></td>  
                     <td colspan="1"><strong>{{$sale_contract->currency->currency_name}} {{number_format($freight_charge_india*$exchange_rate,2)}}</strong></td> 
                     <td colspan="1"><strong></strong></td> 
                     <td colspan="1"><strong></strong></td>
                  </tr> 
                  <tr style="text-align:right;">
                     <td colspan="11" style="text-align: left;"><strong>TOTAL AMOUNT: {{$sale_contract->currency->currency_name}} <span id="convert_result" style="text-transform: uppercase;font-size: 9px"></span>@if($sale_contract->currency_id==1)<span style="text-transform: uppercase;font-size: 9px">{{'ONLY'}}</span>@else<span style="text-transform: uppercase;font-size: 9px">{{'ONLY'}}@endif</strong></td>  
                  </tr>               
                  <tr>
                     <td colspan="11"><strong>TERMS AND CONDITIONS:</strong><br>
                     <p style="margin-top:0px;">1. QUANTITY, QUALITY, RATE AND ALL OTHER DETAILS OF GOODS ARE IN THE ACCORDENCE WITH<br> 
                     @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT"}}@endif:{{$sale_contract->sales_contract_no}} ,{{date("d-m-Y",strtotime( $sale_contract->dated))}}<br>
                     2. SOME PROMOTIONAL ITEM MAY GO IN THIS INVOICE WHICE HAVE NO COMMERCIAL VALUE</p>
                     </pre>
                     <span id="best_before_id" style="display: none">{{$sale_contract->best_before_india}}</span>
                     </td>                  
                  </tr>
                  @if($sale_contract->custom_decleration || $lot_number)
                  <tr>
                     <td colspan="11">
                      <span style="font-size: 11px">@if($sale_contract->custom_decleration){{$sale_contract->custom_decleration}}@endif</span><br>
                      @foreach ($sale_contract_details as $sale_contract_detail)
                        {{$sale_contract_detail->desk_item_name}},&nbsp;&nbsp;MRP RS:{{number_format($sale_contract_detail->mrp_rs,2)}}<br>
                      @endforeach
                      <pre style="margin-bottom: 24px;margin-top: 2px;">MFG: {{$sale_contract->india_mfg_setup_date }}<br>LOT/BATCH: {{$lot_number}}<br></pre>
                      @foreach ($sale_contract_details as $sale_contract_detail)
                        <pre style="margin-top: -20px">BEST BEFORE {{$sale_contract_detail->shelf_life}} MONTH FROM MFG FOR {{$sale_contract_detail->desk_item_name}}</pre>&nbsp;&nbsp;&nbsp;,
                      @endforeach
                     </td>                  
                  </tr>
                  @endif  
            </tbody>
         </table>
      </div> <!-- col-md-12 end -->
</div> 

<script>document.title = 'desk_com_inv_ind_{{$sale_contract->sales_contract_no}}';
function exportF(elem) {

  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
function makePrint(){
 
   print1();
   print2(); 
   print3();
      

}

function print1(){

    var total_amount = document.getElementById("total_amount").value;
    var total_amount2=total_amount;
    var total_amount=parseFloat(total_amount);
    var beforePoint=parseInt(total_amount);
    var afterPoint=(total_amount2 + "").split(".")[1];

    if(afterPoint>0){
        
        var x=inWords(beforePoint);
        var y=inWords(afterPoint);

        document.getElementById("convert_result").innerHTML = x + 'And ' + y;

    }
    else{
        
       var x=inWords(total_amount);
       document.getElementById("convert_result").innerHTML = x; 
      
    } 

}

function print3(){

    var best_before_id =parseInt(document.getElementById("best_before_id").innerHTML);
    if(best_before_id=='0'){

    }else{

       var y=inWords(best_before_id);
       document.getElementById("best_before_res").innerHTML = y;

    }
    
}

var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

function inWords (num) {

    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + ' ' : '';
    return str;
}

function print2(){

  window.print()

}

</script>





