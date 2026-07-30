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
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;"><br>To,<pre style="font-size: 15px;font-weight: normal"><span style="font-weight: bold;font-size: 15px;font-family: Times New Roman;">CMA CGM.</br>4 Quai d'Arenc - 13002 Marseille<br>France</span></pre></span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="20px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 15px;"></br>Vassel & Voyage: {{$sale_contract->vehicle}}<br>Port of Loading: {{$sale_contract->loading_place->name}}<br>Port of Discharge: {{$sale_contract->discharge_port}}<br>B/L No: {{$sale_contract->bl_no}}<br>Container No: {{$sale_contract->container_number}}<br>Description Of Goods: FOOD STUFF</span></td>                 
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
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;">The above goods were shipped on the above vessel by Messrs. ({{$sale_contract->company->name}},{{$sale_contract->company->ho_address}}) and consigned to Messrs. ({{$sale_contract->notify_pary->name}},{{$sale_contract->notify_pary->address}}) The relevant full set of original bills of lading NO: {{$sale_contract->bl_no}} has been surrendered in APL (Bangladesh) Pvt. Ltd. as agent for the carrier APL Co. Pte Ltd.</span></span></td>                 
                  </tr>
                  <tr style="border: hidden;height: 5px"></tr> 
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;">We hereby confirm that the value of the cargo above referred, has been fully paid as per terms of sales agreed between parties.</span></span></td>                 
                  </tr>
                  
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;">Therefore we irrevocably instruct you to deliver the above mentioned goods without production of the original bills of lading {{$sale_contract->bl_no}} to Messrs:</span></span></td>                 
                  </tr>
                  <tr style="height: 10px"> 
                     <td colspan="2" width="20px" style="border:hidden"></td>
                     <td colspan="3" style="border:hidden;"></td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><pre style="font-family: Times New Roman;font-size: 12px">{{$sale_contract->notify_pary->name}}<br>{{$sale_contract->notify_pary->address}}</pre></span></td>                 
                  </tr>
                  <tr style="border: hidden;height: 5px"></tr> 
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;">We confirm having read and accepted the terms and conditions of the CMA CGM bill of lading NO. which are located on the CMA CGM Web site at the following address:<br><span><u style="font-size: 15px">http://www.cma-cgm.com/ProductsServices/ContainerShipping/ShippingGuide/BLClauses.aspx</u></span></span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><span style="font-size: 15px;"></br></br>We hereby undertake to hold Messrs. CMA CGM, its underwriters, subsidiaries, agencies, sub-agencies, all their representative directors and employees harmless in respect of any liability, loss or damage of whatsoever nature which you may sustain in respect with your complying with our instruction and that we shall not make any claim, nor issue any proceedings, for wrongful delivery of cargo.</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px">
                       <br><br>Best Regards.<br><br>
                     </span></td>                 
                  </tr> 
            </tbody>
         </table>
      </div> <!-- col-md-16 end -->
</div> 
<script>document.title = 'NOC CMA|GMC';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "Noc-CMA-CGM_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script>




