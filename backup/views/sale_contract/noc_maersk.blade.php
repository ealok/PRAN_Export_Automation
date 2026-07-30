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
                       <span style="font-size: 16px"><span style="font-weight: bold;font-size: 20px;font-family: 'Times New Roman', Times, serif;">DATE: <?php echo $today = date("d-m-Y");?></span>
                       <pre style="border:0px;font-size: 18px;font-family: 'Times New Roman', Times, serif;margin-left: 195px"><span style="font-weight: bold;font-size: 18px">TO WHOM IT MAY CONCERN</span><br>==========================<br><span style="font-size: 14px;font-weight: bold;">NO OBJECTION LETTER</span><br></pre>
                     </td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="20px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;"><br>Dear Sir,</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="20px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px;font-weight: bold"><br><br><span style="font-size: 15px;">BL NO</span>: {{$sale_contract->bl_no}}</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-weight: bold"><span style="font-size: 16px"><span style="font-size: 15px;font-weight: bold"></br>EXP NO</span>: {{$sale_contract->export_no}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE: {{date("d-m-Y", strtotime($sale_contract->export_date))}}</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-weight: bold"><span style="font-size: 16px"><span style="font-size: 15px;font-weight: bold"></br>INVOICE NO</span>: {{$sale_contract->invoice_no}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE: {{date("d-m-Y", strtotime($sale_contract->invoice_date))}}</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-weight: bold"><span style="font-size: 16px"><span style="font-size: 15px;font-weight: bold"></br>LC NO</span>:--------N/A--------</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-weight: bold"><span style="font-size: 16px"><span style="font-size: 15px;font-weight: bold"></br>LC DATE</span>: --------N/A--------</span></td>                 
                  </tr>
                  <tr style="height: 10px"> 
                     <td colspan="2" width="70px" style="border:hidden"></td>
                     <td colspan="3" style="border:hidden;"></td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;">This is to confirm that we have accomplished our full export processes and received full payment through  {{$sale_contract->bank->name}} from our buyer against the above shipment and there has no objection to {{$sale_contract->notify_pary->name}},{{$sale_contract->notify_pary->address}}</span></span></td>                 
                  </tr>
                  <tr style="height: 10px"> 
                     <td colspan="2" width="70px" style="border:hidden"></td>
                     <td colspan="3" style="border:hidden;"></td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;">We declare that Maersk Line will not be held responsible for any payment related issue in future. </span></span></td>                 
                  </tr>
                  <tr style="border: hidden;height: 20px"></tr> 
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;">We also mention that we will surrender the first 2 copies of OB/L to your local office and the 3rd copy will be kept with us. We will take entire responsibility for this 3rd copy and if any dispute arises, we will be fully responsible for this.</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px">
                       <br><br><br><br><br><br>Regards.<br><br>
                     </span></td>                 
                  </tr> 
            </tbody>
         </table>
      </div> <!-- col-md-16 end -->
</div> 
<script>document.title = 'NOC | Maersk';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "Noc_Maersh_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script>




