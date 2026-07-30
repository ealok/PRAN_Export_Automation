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
<div class="row">
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
        <div class="col-md-16">
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr> 
                     <td colspan="2" width="70px" style="border:hidden">&nbsp;</td>
                     <td colspan="3" style="border:hidden;">
                       <span style="font-size: 16px"><span style="font-weight: bold;font-size: 20px;font-family: 'Times New Roman', Times, serif;">REF: <span style="font-size: 20px;font-weight: bold;">PRAN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE: <?php echo $today = date("d-m-Y");?></span></span></span>
                       <pre style="border:0px;font-size: 18px;font-family: 'Times New Roman', Times, serif;margin-left: 195px"><span style="font-weight: bold;font-size: 18px">TO WHOM IT MAY CONCERN</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=================<br><span style="font-size: 14px;font-weight: bold;">SUB: NOC AND SURRENDER REQUEST.</span><br></pre>
                     </td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;"><br><br>Dear Sir(s),</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><br>This is to confirm that we have received full payment through {{$bank}} from our buyer against below shipment.<br><br><br><br><span style="font-size: 15px;">BL NO</span>:{{$sale_contract->bl_no}}</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;">EXP NO</span>: {{$sale_contract->export_no}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE:{{$sale_contract->export_date}}</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;">INVOICE NO</span>: {{$sale_contract->invoice_no}}&nbsp;&nbsp;&nbsp;DATE:{{$sale_contract->invoice_date}}</span></td>                 
                  </tr>
                  <tr style="height: 20px"> 
                     <td colspan="2" width="70px" style="border:hidden"></td>
                     <td colspan="3" style="border:hidden;"></td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;">We cordially request you to take NA to do the telex arrangement from here to avoid penalty by shipping line and port authority.</span></span></td>                 
                  </tr>
                  <tr style="height: 10px"> 
                     <td colspan="2" width="70px" style="border:hidden"></td>
                     <td colspan="3" style="border:hidden;"></td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;">Now we surrender the OBL at your good self and we have no objection to deliver the cargo without present OBL to {{$sale_contract->party_name}} {{$sale_contract->party_address}}</span></span></td>                 
                  </tr>
                  <tr style="border: hidden;height: 20px"></tr> 
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;">Note: Please send Surrender/Telex confirmation to this Mail - <span style="font-size: 15px;font-weight: bold;">{{$email}}</span></span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px">
                       <br><br><br><br><br><br>Thanking You.<br><br>
                     </span></td>                 
                  </tr> 
            </tbody>
         </table>
      </div> <!-- col-md-16 end -->
</div> 
<script>document.title = 'Noc Canada|Usa';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "Noc_report_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script>




