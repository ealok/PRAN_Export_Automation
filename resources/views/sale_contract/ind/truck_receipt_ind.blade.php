<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;padding-bottom: 33px">
    <h1 style=" font-size: 30px;">
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:9px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
</section>
</div>
<style>

*{
    font-size: 10px;
    font-family: arial Narrow;
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
/*.row
{
    display:block;
    -webkit-transform: rotate(-90deg); 
    -moz-transform: rotate(-90deg); 
    filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3); //For IE support
}*/
</style>
<div class="row">
  <div class="col-md-11" style="margin:0px auto">
    <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:90%;">
        <thead>
          <tr>
              <td colspan="2" style="border:hidden;border-bottom: 1px solid"><pre style="font-size: 13px;font-weight: bold;border: hidden;">{{$transport_agency_info}}</pre></td>
              <td colspan="7" style="border:hidden;border-bottom: 1px solid"></td>
              <td colspan="3" style="border:hidden;border-bottom: 1px solid"><pre style="font-size: 10px;font-weight: bold;">{{$transport_agency_details}}</pre></td>
          </tr>    
        </thead>
        <tbody>
          <tr>
              <td colspan="2" style="font-size: 9px">The Consignment will not be detained<br>
                diverted,re-routed or re-booked without<br>
                Consignee Bank's written premission will<br>be delivered at the destination</td>
              <td colspan="4" style="text-align: center;"><span style="font-weight: bold;font-size: 20px;"></span></td>
              <td colspan="4"><span style="font-weight: bold;font-size: 9px;width: 450px">SCHEDULE OF DEMURRAGE CHARGES</span><br>
                <span style="font-size: 9px">demurrage chargeable after......days from today
              @Tk per day per ton on weight charge</span></td>
              <td colspan="2" style="font-size: 9px">Adress of issuing office<br>or name and address of<br>agent</td>
          </tr>
          <tr>
              <td colspan="2" style="font-size: 9px">Address of delivery office</td>
              <td colspan="4" style="font-size: 9px;text-align: center;font-weight: bold;width: 1085px">AT OWNER'S RISK INSURANCE</td>
              <td colspan="4" rowspan="8" style="width: 91px"><p style="text-align: center;margin-top: -9px;margin-bottom: -12px;font-weight: bold;font-size: 12px">NOTICE</p><br><span style="font-size: 9px">
              The consignment covered by this seal of special Lorry Receipt
              Form shall be stored at the destination under the control of the
              Transport Operator and shall be delivered to or to the order of
              the Consignee Bank whose name is mentioned in the Lorry
              Receipt. It will under no circumstances be delivered to anyone
              without the written authority from the Consignee Bank or its
              order, endorsed on the Consignee Copy or on a separate letter of Authority</span></td>
              <td colspan="2" rowspan="8" style="text-align: left;font-weight: bold;font-size: 9px"><span style="border-bottom:1px solid;text-transform: uppercase">Truck No:</span><pre style="font-size: 9px;font-family: arial Narrow">{{$sale_contract->truck_numbers}}</pre><br><span>LOADED ON TRUCK DATE :</span><br>{{$sale_contract->truck_loaded_date}}</td>
          </tr> 
          <tr>
              <td colspan="2" style="border: hidden;border-left: 1px solid;border-right: 1px solid"></td>
              <td colspan="4" rowspan="2" style="font-size: 9px">The Customer has stated that he has not insured the consignment or he has insured the consignment</td>
          </tr>  
          <tr>
              <td colspan="2"></td>
          </tr>  
          <tr>
              <td colspan="2" style="text-align: center;font-weight: bold;font-size: 9px">CONSIGNMENT NOTE</td>
              <td colspan="4" style="font-size: 9px;font-weight: bold">Company:</td>
          </tr>  
           <tr>
              <td colspan="2"></td>
              <td colspan="4" style="font-size: 9px;font-weight: bold">Policy No:</td>
          </tr> 
           <tr>
              <td colspan="2" style="font-size: 9px"><span style="font-size: 9px;font-weight: bold;">Challan No</span>: {{$sale_contract->bl_no}}</td>
              <td colspan="4" style="font-size: 9px;font-weight: bold">Date:</td>
          </tr>  
          <tr>
              <td colspan="2"><span style="font-size: 9px;font-weight: bold;">@if($sale_contract->oc_date){{"Challan Date :"}}{{date("d-m-Y", strtotime($sale_contract->oc_date))}}@endif</span></td>
              <td colspan="4" style="font-size: 9px;font-weight: bold">Amount:</td>
          </tr>  
           <tr>
              <td colspan="2" style="font-size: 9px;font-weight: bold"></td>
              <td colspan="4" style="font-size: 9px;font-weight: bold">Risk:</td>
          </tr>  
           <tr>
              <td colspan="12" style="height: 14px;border-left: hidden;border-right: hidden;"></td>
          </tr>
          <tr>
             <td colspan="6" rowspan="3" style="font-size: 9px"><span style="font-size: 9px;font-weight: bold;"></td>
             <td colspan="4" rowspan="7" style="font-size: 9px">From:</br>{{$sale_contract->company->factory_address}}<br>To:<br>@if($sale_contract->discharge_port){{"Discharge Port: ".$sale_contract->discharge_port}}@endif</td>
          </tr>
          <tr>
             <td style="height: 30px;font-size: 9px;border-bottom: hidden;border-top: hidden;" colspan="2">M.R.No:</td>
          </tr>
          <tr>
             <td style="height: 30px;font-size: 9px;border-bottom: hidden;" colspan="2">Code No.</td>
          </tr>
          <tr>
             <td colspan="6" style="font-size: 9px;border:hidden;border-left: 1px solid;border-top: 1px solid;border-right: 1px solid"><span style="font-size: 9px;font-weight: bold;">NOTIFY:</span>{{$sale_contract->party_name}} {{$sale_contract->party_address}}</td>
             <td colspan="2" rowspan="4"></td>
          </tr>
          <tr>
             <td colspan="6" style="font-size: 9px"></td>
          </tr>
          <tr>
             <td colspan="6" style="font-size: 9px"><span style="font-size: 9px;font-weight: bold;">Exporter :</span>{{$sale_contract->company->name}} FACTORY: {{$sale_contract->company->factory_address}}</td>
          </tr>
          <tr>
             <td colspan="6" style="font-size: 9px">H\O:PRAN CENTRE, GA-105/1,MIDDLE BADDA, DHAKA-1212, BANGLADESH</td>
          </tr>
          <tr>
             <td colspan="12" style="height: 9px;border-left: hidden;border-right: hidden;"></td>
          </tr>
          <tr>
             <td rowspan="7" style="text-align: center;font-size: 9px;width: 80px">Packages<br>{{$number_of_ctn}}<br> BAG/CTN/WRAPPER</td>
             <td colspan="4" style="text-align: center;font-size: 9px">Description(Said To Contain)</td>
             <td colspan="2" style="text-align: center;font-size: 9px">Weight</td>
             <td colspan="3" style="text-align: center;font-size: 9px">Destination</td>
             <td style="text-align: center;font-size: 9px">Amount</td>
             <td></td>
          </tr>
          <tr>
             <td colspan="4" rowspan="3" style="text-align: center;font-size: 9px">
                @foreach($sale_contract_details as $sale_contract_detail)
                  <p style="font-weight: normal;font-size: 7px;text-align: left;font-weight: bold;">{{$sale_contract_detail->desk_item_name}}</p>
                @endforeach
             </td>
             <td colspan="2" rowspan="6" style="text-align: center;font-size: 9px">NET WEIGHT<br>{{number_format($net_weight,2)}} KGS/LTR<br><br>GROSS WEIGHT<br>{{number_format($gross_weight,2)}} KGS<br></td>
             <td colspan="3" rowspan="5" style="font-size: 9px"><pre></pre>As Agreed<br><br>FOB AMOUNT:<br>FREIGHT:</td>
             <td rowspan="5" style="text-align: right;"><br><br>{{number_format(($total_amount-$sale_contract->freight_charge_india)*$exchange_rate,2)}}<br>{{number_format($sale_contract->freight_charge_india*$exchange_rate,2)}}</td>
             <td style="font-size: 9px">Consignee<br><br>S.S.T.No</td>
          </tr>
          <tr> 
             <td style="font-size: 9px">Consignor<br>C.S.T. No.</td>
          </tr>
          <tr>
             <td style="font-size: 9px">S.S.T. NO:</td>
          </tr>
          <tr>
            <td colspan="4" rowspan="3" style="font-size: 9px;width: 854px"><span style="font-size: 9px;font-weight: bold;">EXP NO: {{$sale_contract->export_no}}&nbsp;&nbsp;&nbsp;Date: @if(!empty($sale_contract->export_date)){{date("d-m-Y",strtotime($sale_contract->export_date))}}@endif<br><br>INVOICE NO:</span><br>{{$sale_contract->invoice_no}}, DATE: @if(!empty($sale_contract->dated)){{date("d-m-Y",strtotime($sale_contract->invoice_date))}}@endif<br>{{$sale_contract->ci_note}}<br><span style="font-size: 9px;font-weight: bold">@if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE:"}}@else {{"SALES CONTRACT:"}} @endif<br><span>{{$sale_contract->sales_contract_no}}, DATE: @if(!empty($sale_contract->dated)){{date("d-m-Y",strtotime($sale_contract->dated))}}@endif
             </td>
             <td rowspan="1" style="font-size: 9px">ENDORSEMENT</br>
                It is intended to use the</br>
                CONSIGNEE COPY
                of this set for the</br>
                purpose of borrowing from</td>
          </tr>
          <tr>
             <td style="font-size: 9px;border-top: hidden;">the Consignee Bank</td>
          </tr>
          <tr>
             <td colspan="3" style="font-size: 9px;text-align: center">Total ({{$sale_contract->currency->currency_name}})</td>
             <td style="font-size: 9px">{{number_format($total_amount*$exchange_rate,2)}}</td>
          </tr>
          <tr>
             <td colspan="12" style="height:9px;border-left: hidden;border-right: hidden;"></td>
          </tr>
          <tr>
             <td colspan="12" style="height:30px;font-size: 12px;border:hidden">Signature of the transport operator....................................</td>
          </tr>  
        </tbody>
     </table>
  </div> 
</div>
<script>document.title = 'Truck Receipt | Report';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "Noc_report_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script>




