<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
</section>
</div>
<style>

*{
    font-size: 9px;
    font-family: "Arial Narrow";
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
</style>
<div class="row">
  <div class="col-md-11" style="width: 1050;margin:0px auto">
    <table id="inv" class="table  table-bordered" style="margin:0 auto; width:100%;border: 1px solid">
        <thead>
          <tr>
              <td colspan="12" style="text-align: center;height: 60px;border-bottom: 1px solid"><span style="font-size: 35px;border-bottom: 3px solid">BILL OF EXCHANGE</span></td>
          </tr>    
        </thead>
        <tbody>
          <tr>
              <td colspan="12" style="font-size: 19px;font-weight: bold;">
                DRAWN UNDER {{$sale_contract->ci_note}} OF {{$shipping_mark}}
              </td>
          </tr>
          <tr>
              <td colspan="12" style="font-size: 19px;font-weight: bold;height: 10px"></td>
          </tr>
          <tr>
              <td style="font-size: 19px" colspan="10">{{$lc_number}}</td>
              <td style="font-size: 19px" colspan="2">DATE:<?php echo date("d-m-Y") ?></td>
          </tr>
          <tr>
              <td colspan="12" style="font-size: 19px;font-weight: bold;height: 10px"></td>
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px">
               EXCHANGE FOR US DOLLAR = ${{$total_amount}}<br> 
               PLEASE PAY {{$sale_contract->lc_term_for_india}} OF THIS FIRST OF EXCHANGE (SECOND OF THE SAME TENOR AND DATE BEING UNPAID) TO THE ORDER OF {{$sale_contract->bank->name}} {{$sale_contract->bank->address}}.THE SUM OF US ${{$total_amount}} (US DOLLAR <span style="text-transform: uppercase;font-size: 20px">{{$new_total_amount1}} @if(!empty($new_total_amount2)){{"and"}} {{$new_total_amount2}} {{"Sen"}}@endif</span> ONLY) FOR THE VALUE UNDER {{$sale_contract->bl_no}}, DATED:@if($sale_contract->bl_date){{date('d-m-Y',strtotime($sale_contract->bl_date))}}@endif.
            </td>
          </tr>
          <tr>
            <td style="font-size: 19px;width: 531px" colspan="11"></td>
            <td style="font-size: 19px"><span style="font-weight: bold;font-size: 16px">FOR {{$sale_contract->company->name}}</span></td>
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px"><span style="font-size: 19px;font-weight: bold;">TO</span><br><pre style="font-size: 19px">{{$sale_contract->bank_address_for_india}}</pre><span style="font-size: 19px;font-weight: bold;text-transform: uppercase;">On Account Of:</span><br><pre style="font-size: 19px">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre></td> 
          </tr>
        </tbody>
     </table>
     <table id="inv"   class="table  table-condensed" style="margin:0 auto; width:100%;margin-top: 150px;border: 1px solid">
        <thead>
          <tr>
              <td colspan="12" style="text-align: center;height: 60px;border-bottom:1px solid"><span style="font-size: 35px;border-bottom: 3px solid;">BILL OF EXCHANGE</span></td>
          </tr>    
        </thead>
        <tbody>
          <tr>
              <td colspan="12" style="font-size: 19px;font-weight: bold;">
                DRAWN UNDER {{$sale_contract->ci_note}} OF <span style="text-transform: uppercase;font-size: 19px">{{$shipping_mark}}</span>
              </td>
          </tr>
          <tr>
              <td colspan="12" style="font-size: 19px;font-weight: bold;height: 10px"></td>
          </tr>
          <tr>
              <td style="font-size: 19px" colspan="10">{{$lc_number}}</td>
              <td style="font-size: 19px" colspan="2">DATE: <?php echo date("d-m-Y") ?></td>
          </tr>
          <tr>
              <td colspan="12" style="font-size: 19px;font-weight: bold;height: 10px"></td>
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px">
               EXCHANGE FOR US DOLLAR = ${{$total_amount}}<br> 
               PLEASE PAY {{$sale_contract->lc_term_for_india}} OF THIS SECOND OF EXCHANGE (FIRST OF THE SAME TENOR AND DATE BEING UNPAID) TO THE ORDER OF {{$sale_contract->bank->name}} {{$sale_contract->bank->address}}, BANGLADESH.THE SUM OF US ${{$total_amount}} (US DOLLAR <span style="text-transform: uppercase;font-size: 20px">{{$new_total_amount1}}@if(!empty($new_total_amount2)){{"and"}} {{$new_total_amount2}} {{"Sen"}}@endif</span> ONLY) FOR THE VALUE UNDER {{$sale_contract->bl_no}}, DATED: @if($sale_contract->bl_date){{date('d-m-Y',strtotime($sale_contract->bl_date))}}@endif.
            </td>
          </tr>
          <tr>
            <td style="font-size: 19px;width: 531px" colspan="11"></td>
            <td style="font-size: 19px"><span style="font-weight: bold;font-size: 16px">FOR {{$sale_contract->company->name}}</span></td>
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px"><span style="font-size: 19px;font-weight: bold;">TO</span><br><pre style="font-size: 19px">{{$sale_contract->bank_address_for_india}}</pre><span style="font-size: 19px;font-weight: bold;text-transform: uppercase;">On Account Of:</span><br><pre style="font-size: 19px">{{$notify_party_name}}<br>{{$notify_party_address}}</pre></td> 
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
  elem.setAttribute("download", "Noc_report_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script>
