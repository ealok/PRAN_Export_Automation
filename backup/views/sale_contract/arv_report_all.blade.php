<style>

*{
    font-size: 13px;
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
<?php 
     
    try { 

        $total_net_weight=$total_net_weight;
        $freight_cost=$sale_contract->freight_cost;
        $per_unit_freight=$freight_cost/$total_net_weight;

    }catch (Exception $e) {


    }    
     
?>
<?php $total_pcs_in_ctn = 0; $total_ctn = 0; $total_sum = 0;?>
@foreach ($sale_contract_details as $sale_contract_detail)
   <?php 
      try { 
            if($sale_contract_detail->ci_factor!=0){

               $per_net_weight_kg_fright=$per_unit_freight*$sale_contract_detail->net_weight_kg;
               $caton_fright=$per_net_weight_kg_fright/$sale_contract_detail->ctn;
               $carton_fright_pl_rate=round($caton_fright+$sale_contract_detail->rate_per_ctn,3);            
               $total_sum=$total_sum+round($carton_fright_pl_rate*$sale_contract_detail->ctn,2);

            }
      }catch (Exception $e) {
      
      }          
   ?>
@endforeach
<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 13px;">
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 13px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 13px;" onClick="window.print()">Print</button></h1>
</section>
</div>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
  <style>
body {

  line-height: 1.25;
  
}

@font-face {
  
    /*font-family: SutonnyMJ:'Arial Narrow', Arial, sans-serif;;
    src: url('{{asset('font/SutonnyMJ Regular.ttf')}}');*/
}

table {
  border: 1px solid #ccc;
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
}

table caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
}

table tr {
  background-color: #f8f8f8;
  border: 1px solid #222;
  padding: .35em;
}

table th,
table td {
  padding: .625em;
  text-align: center;
  border:1px solid #222;
}

table th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
  border:1px solid #222;
}

@media screen and (max-width: 600px) {
  table {
    border: 0;
  }

  table caption {
    font-size: 1.3em;
  }
  
  table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }
  
  table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }
  
  table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }
  
  table td::before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  
  table td:last-child {
    border-bottom: 0;
  }
}
   </style>
  <table id="inv">
    <h4 style="margin-top: 30px;"></h4>
  <tr style="border:1px solid #ddd;">
      <td colspan="2">See Chapter 2</td>
      <td colspan="2">Para 8(a)</td>
      <td colspan="6" style="border-top: hidden;border-bottom: hidden;"></td>
      <td>APP.19</td>
      <td style="border:hidden;border-left:none"></td>
  </tr>
  <tr style="border:1px solid #ddd;">
      <td colspan="10" style="border-left: hidden;border-right: hidden;"></td>
      <td style="border-left: hidden;border-right: hidden;">ORIGINAL</td>
      <td style="border-right:hidden"></td>
  </tr>  
	<tr style="border:1px solid #ddd;">
	   <td colspan='12' style="font-family:'Arial Narrow', Arial, sans-serif;;font-size: 15px;font-weight: bold;height: 70px;border-left: hidden;border-top: hidden;border-right: hidden;">ADVANCE RECEIPT VOUCHER</td>
	</tr>
  <tr>
	   <td colspan='9' style="font-size: 13px;text-align: left;border-top: hidden;border-left: hidden;">Name and address of Authorized dealer: {{$sale_contract->bank->name}}</td>
	   <td style="font-size: 13px;font-family:'Arial Narrow', Arial, sans-serif;" colspan="3">AD CODE: {{$ad_code}}</td>
	</tr>
	<tr>
    <td>Sl No.</td>
	  <td colspan="3">Items</td>
	  <td colspan="8">Particulars</td>
  </tr>
  <tr>
    <td>1.</td>
    <td colspan="3" style="text-align: left;">EXP Form Number</td>
    <td colspan="8" style="text-align: left;">
        <p>EXP NO : {{$sale_contract->export_no}}</p>
        <p>EXP DATE : @if(!empty($sale_contract->export_date)){{date("d-m-Y", strtotime($sale_contract->export_date))}}@endif</p>
        <p>VALUE: ${{$total_sum}}</p>
    </td>
  </tr>
  <tr>
    <td>2.</td>
    <td colspan="3" style="text-align: left;">Name of the exporter (in block letter) with address
    </td>
    <td colspan="8" style="text-align: left;">
       {{$sale_contract->company->name}}<br>
       {{$sale_contract->company->ho_address}}
    </td>
  </tr>
  <tr>
    <td>3.</td>
    <td colspan="3" style="text-align: left;">CCI & E's Registration No. and date of exporter</td>
    <td colspan="8" style="text-align: left;">{{$sale_contract->company->erc_no}}</td>
  </tr>
  <tr>
    <td>4.</td>
    <td colspan="3" style="text-align: left;">Sector (Public or Private) under which exporter falls</td>
    <td colspan="7" style="text-align: left;">PRIVATE</td>
    <td>2</td>
  </tr>
  <tr>
    <td>5.</td>
    <td colspan="3" style="text-align: left;">Name of the foreign buyer</td>
    <td colspan="8" style="text-align: left;font-size: 9px">
       @if($sale_contract->importer_name!="N/A")<span style="font-size: 9px;text-transform: uppercase;">Importer</span>: {{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}@endif<br>
       @if($sale_contract->party_name)<span style="font-size: 9px;text-transform: uppercase;">Notify party</span>: {{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}@endif<br>
       <span style="font-weight: bold;font-size: 9px">Invoice No: {{$sale_contract->invoice_no}} &nbsp;&nbsp;Invoice Date: @if(!empty($sale_contract->invoice_date)){{date("d-m-Y", strtotime($sale_contract->invoice_date))}}@endif</span><br>
       <span style="font-weight: bold;"></span>
    </td>
  </tr>
  <tr>
    <td>6.</td>
    <td colspan="3" style="text-align: left;">Commodity exported</td>
    <td colspan="6" style="text-align: left;">
      {{$total_ctn_number}} CTN/BAG/WRAPPER (NW: {{$total_net_weight}} KG/LTR)
    </td>
    <td colspan="2">{{$salesContactdetails->hs_code}}</td>
  </tr>
  <tr>
    <td>7.</td>
    <td colspan="3" style="text-align: left;">Country of destination</td>
    <td colspan="7" style="text-align: left;">{{$sale_contract->notify_pary->country}}</td>
    <td>{{$sale_contract->notify_pary->country_code}}</td>
  </tr>
  <tr>
    <td>8.</td>
    <td colspan="3" style="text-align: left;">Port of shipment</td>
    <td colspan="8" style="text-align: left;">{{$sale_contract->discharge_port}}</td>
  </tr>
  <tr>
    <td rowspan="3">9.</td>
    <td rowspan="3">Amount Of Receive</td>
    <td colspan="2" style="text-align: left;">Currency in which received</td>
    <td colspan="6" style="text-align: left;">US DOLLAR</td>
    <td>0</td>
    <td>1</td>
  </tr>
  <tr>
    <td colspan="2" style="text-align: left;">Amount</td>
    <td colspan="8" style="text-align: left;">${{$sale_contract->arv_amount}}</td>
  </tr>
  <tr>
    <td colspan="2" style="text-align: left;">Date of Receipt of the amount</td>
    <td colspan="8" style="text-align: left;">@if(!empty($sale_contract->arv_amount_received_date)){{date("d-m-Y", strtotime($sale_contract->arv_amount_received_date))}}@endif</td>
  </tr>
  <tr>
    <td>10.</td>
    <td colspan="3" style="text-align: left;">Reporting period</td>
    <td colspan="8" style="text-align: left;text-transform: uppercase;"><?php echo date("M Y") . "<br>";?></td>
  </tr>
  <tr style="height: 200px">
    <td colspan="12" style="text-align: left;border-left: hidden;border-right: hidden;border-bottom: hidden;">
      @if($signatureImg)
			<img style="width: 100;height: 75px;" src="{{asset($signatureImg)}}" style="margin-left: 17px">
			@endif
      <br><br><br><br>
      <p>&nbsp;&nbsp;&nbsp;&nbsp;Authorized Signature<br><br>&nbsp;&nbsp;&nbsp;&nbsp;Date: </p>
    </td>
  </tr>
</table>
<script>document.title = 'ARV | Report All';
  function exportF(elem) {
    var table = document.getElementById("inv");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
    elem.setAttribute("href", url);
    elem.setAttribute("download", "Arv_Report.xls"); // Choose the file name
    return false;
  }
</script>
</body>
</html>
