<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
</section>
</div>
<style>

*{
    font-size: 25px;
    font-family: "Arial Narrow";
}


@media print {
    .row {
        clear: both;
        page-break-after: always;
    }
    .noprint {display:none;}
}
</style>
<div class="row">
  <div class="col-md-11" style="width: 1050;margin:0px auto">
    <table id="inv" class="table" style="margin:0 auto; width:100%;">
        <thead>
          <tr>
              <td colspan="12" style="text-align: center;height: 60px;position: relative;"></td>
          </tr>    
        </thead>
        <tbody>
          <tr>
              <td colspan="12" style="font-size: 19px;font-weight: bold;"></td>
          </tr>
          <tr style="border-top: 1px solid">
              <td colspan="12" style="font-weight: bold;">Date:<?php echo date('d-m-Y') ?></td>
          </tr>
          <tr style="border-top: 1px solid">
              <td colspan="4">Ref No:{{$sale_contract->invoice_no}}</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
          </tr>
          <tr style="border: hidden;">
              <td colspan="12" style="width: 10px"></td>
          </tr>
          <tr style="border-top: 1px solid">
              <td colspan="4"><pre><span style="text-transform: uppercase;font-size: 20px">The Manager</span><br>{{$sale_contract->bank->name}}<br>{{$sale_contract->bank->address}}</pre></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
          </tr>
          <tr style="border-top: 1px solid">
              <td colspan="12">SUBMISSION OF EXPORT DOCUMENT AGAINST @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT NO"}} @endif: {{$sale_contract->sales_contract_no}}, DT: {{date("d-m-Y",strtotime( $sale_contract->dated))}}, </br>{{$lc_number}} {{$lc_date}},EXP NO: {{$sale_contract->export_no}}, EXP DATE: @if(!empty($sale_contract->export_date)){{date("d-m-Y",strtotime($sale_contract->export_date))}}@endif</td>
          </tr>
          <tr style="border-top: 1px solid">
              <td colspan="12">Dear Sir,<br>
              We invite your kind attention that an LC of US ${{$total_amount}} received by us through normal banking channel,</br> out of which; We have export the ordered goods against above @if($sale_contract->is_proforma_invoice == 1){{"Proforma Invoice No"}}@else {{"Sales Contract No"}}: {{$sale_contract->sales_contract_no}} @endif {{$sale_contract->party_name}}<br> For US ${{$total_amount}} & Invoice No:{{$sale_contract->invoice_no}},Value US ${{$total_amount}}</td>
          </tr>
          <tr>
             <td colspan="12" style="height:30px"></td>
          </tr>
          <tr style="border-top: 1px solid">
              <td colspan="12">We are enclosing herewith the following export documents for your information and record:</td>
          </tr>
          <tr style="border-top: 1px solid">
              <td colspan="12">1.BIll of EXCHANGE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;01.No (Two Set)</td>
          </tr>
          <tr style="border-top: 1px solid">
              <td colspan="12">2.Proforma Invoice&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;01.No (Two Set)</td>
          </tr>
          <tr style="border-top: 1px solid">
              <td colspan="12">3.EXP form&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;01.(Dup)</td>
          </tr>
          <tr style="border-top: 1px solid">
              <td colspan="12">4.Invoice&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;05. Noc(Two Set)</td>
          </tr>
          <tr style="border-top: 1px solid">
              <td colspan="12">5.Packing List&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;05. Noc(Two Set)</td>
          </tr><tr style="border-top: 1px solid">
              <td colspan="12">6.Truck Receipt/BL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;03. Nos(Org+N/N)(Two Set)</td>
          </tr><tr style="border-top: 1px solid">
              <td colspan="12">7. Certificat Of Origin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;04. No(Two Set)</td>
          </tr><tr style="border-top: 1px solid">
              <td colspan="12">8.TT/ARV/LC Copy&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;01. No(Two Set)</td>
          </tr><tr style="border-top: 1px solid">
              <td colspan="12">9.Bill Of Export&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;01. No</td>
          </tr>
           <tr style="border-top: 1px solid">
              <td colspan="12">Please send the documents to collect the proceeds to the buyers Bank by immediately to the following address:</td>
          </tr>
           <tr style="border-top: 1px solid">
              <td colspan="12" style="font-weight: bold;"><pre>{{$sale_contract->bank_address_for_india}}</pre></td>
          </tr>
           <tr style="border-top: 1px solid">
              <td colspan="12">Kindly acknowledge receipt.</td>
          </tr>
          <tr style="border-top: 1px solid">
              <td colspan="12">Thanking You.</td>
          </tr>     
        </tbody>
     </table>
  </div> 
</div>
<script>document.title = 'BILL OF EXCHANGE';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "Noc_report.xls"); // Choose the file name
  return false;
}
</script>
