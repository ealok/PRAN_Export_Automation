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
        <div class="col-md-16">
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;font-family:Times New Roman">
            <tbody>
                  <tr> 
                     <td colspan="2" width="70px" style="border:hidden">&nbsp;</td>
                     <td colspan="3" style="border:hidden;">
                       <span style="font-size: 16px"><span style="font-weight: bold;font-size: 15px;font-family:Times New Roman">DATE: <?php echo $today = date("d-m-Y");?></span>
                     </td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="20px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;"><br>To,<pre style="font-size: 15px;font-weight: normal"><span style="font-weight: bold;font-size: 15px;font-family: Times New Roman;">MEDITERRANEAN SHIPPING COMPANY BANGLADESH LTD.</br>HR Bhaban (7th Floor) 26/1 kakrail,<br>Dhaka-1000, Bangladesh.</span></pre></span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="20px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 15px;font-weight: bold">REQUEST FOR TELEX RELEASE</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="20px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 15px;"></br>FDR VSL/VOY: {{$sale_contract->vehicle}}<br>M.V. /VOY: {{$sale_contract->mv_or_voy}}<br>Port of Loading: {{$sale_contract->loading_place->name}}<br>Port of Discharge: {{$sale_contract->discharge_port}}<br>B/L No: {{$sale_contract->bl_no}}<br>Container No: {{$sale_contract->container_number}}<br>Cargo: FOOD STUFF<br>Weight: {{$gross_weight}} KGS</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-weight: bold"><span style="font-size: 16px"><span style="font-size: 15px;font-weight: bold"><br>Dear Sir,</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-weight: bold"><span style="font-size: 16px"><span style="font-size: 15px;font-weight: bold"></span></td>                 
                  </tr>
                  <tr style="height: 10px"> 
                     <td colspan="2" width="70px" style="border:hidden"></td>
                     <td colspan="3" style="border:hidden;"></td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;">We confirm and hereby authorize a telex release of the above mentioned container(s)/cargo for which we surrender original Bill of Lading to you to release the containers/cargo to:</span></span></td>                 
                  </tr>
                  <tr style="height: 10px"> 
                     <td colspan="2" width="70px" style="border:hidden"></td>
                     <td colspan="3" style="border:hidden;"></td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><pre style="font-family: Times New Roman;font-size: 12px">{{$sale_contract->notify_pary->name}}<br>{{$sale_contract->notify_pary->address}}</pre></span></td>                 
                  </tr>
                  <tr style="border: hidden;height: 5px"></tr> 
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;">We also confirm that our own Bill of Lading is issued in accordance with the terms and conditions of Foreign Exchange Regulation of Bangladesh Central Bank, and the duly endorsed Bill of Lading is in our possession. We accept full responsibility of all consequences for delivering container(s) /cargo against this telex release to the agent or authorized dealer of the agent, or authorized concern as per destination local regulation.</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;"></br></br>We hereby further confirm that Messrs. Mediterranean Shipping Company S.A, its underwriters, subsidiaries, agencies, sub-agencies, all their representative directors and employees will not be liable in respect of any Obligation/Objection/Claim raised against this export proceeds and delivery of the container(s)/cargo.</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px">
                       <br><br><br><br><br><br>Best Regards.<br><br>
                     </span></td>                 
                  </tr> 
            </tbody>
         </table>
      </div> <!-- col-md-16 end -->
</div> 
<script>document.title = 'NOC | MSC';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "Noc_MSC{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script>




