<style>
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

@page {margin-bottom: 150px;margin-top: 100px}

</style>
<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" ></button></a>
    <button style="float:right; font-size: 30px; position: static !important;" onClick="window.print()"></button></h1>
</section>
</div>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
</head>
<body style="margin-top: -19px">
  <style> 
body {

  font-family: "Arial Narrow", Arial, sans-serif;

  
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

  text-align: center;
  border:1px solid #222;
}

table th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
  border:1px solid #222;
}
#heading{

   font-size:30px;
   position: relative;
}

#heading::before{

    content: "";
	background-image: url('logo.png');
	width: 120px;
	height: 109px;
	position: absolute;
	margin: -40px 17px 0px -140px;


}

#under{
   
   border-bottom: 2px solid;
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
  
  #heading{

   font-size:30px;
   position: relative;
}

#heading::before{

    content: "";
	background-image: url('logo.png');
	width: 120px;
	height: 109px;
	position: absolute;
	margin: -40px 17px 0px -140px;


}

#under{
   
   border-bottom: 2px solid;
}
}
   </style>
<div id="inv" style="position: relative;">   
  <table style="margin-top: 18px">
  	<br>
  	<tr style="border:hidden">
	   <td colspan="4" style="text-align:left;font-size:9px;border-right:hidden;position: relative;">
	       <br><br><br>
	        <span style="position: absolute;top: 34px;left: 12px;"> 
		    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="margin-left: -13px">{{$sale_contract->company->name}}</span><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="margin-left: -13px">FACTORY: {{$sale_contract->company->factory_address}}</span><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="margin-left: -13px">H/O:PRAN RFL CENTER, 105 MIDDLE BADDA,DHAKA 1212 ,<br>&nbsp;&nbsp;&nbsp;BANGLADESH.</span><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:normal;margin-left: -13px">ENROLMENT NO: {{$sale_contract->company->enrolment_no}}</span>
            </span>	
	   </td>
	   <td colspan="4" style="text-transform: uppercase;font-size: 11px;margin-left: -13px;position: relative;"><br><br><br><br><br><span style="position: absolute;margin-top: 21px;margin-left: -36px;">Bangladesh</span></td>
	</tr>
	<tr>
		<td height="26px" colspan="8" style="border-left: hidden;border-right: hidden;"></td>
	</tr>
	<tr>
		<td style="height: 10px;border: hidden;" colspan="8"></td> 
	</tr>
	<tr style="border:hidden">
	   <td colspan="4" style="text-align:left;font-size:9px;border-right:hidden;border-left:hidden;border-left:hidden;position: relative;">
		     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="margin-left: -2px;top: 57px;position: absolute;">{{$sale_contract->notify_pary->name}}<br>{{$sale_contract->notify_pary->address}}</pre></span>
						
	   </td>
	   <td colspan="4" style="text-align:left; font-weight:bold; font-size:20px;border-right:hidden"></td>
	</tr>
	<tr>
		<td style="height: 30px;border: hidden;" colspan="8"></td> 
	</tr>
	<tr style="border:hidden">
	   <td colspan="4" style="text-align:left;font-size:9px;border-right:hidden;position: relative;">
		    <pre style="position: absolute;top: 93px;left: 17px">{{$sale_contract->loading_place->name}}<br>to {{$sale_contract->discharge_port}}<br>BY TRUCK</pre>				
	   </td>
	   <td colspan="4" colspan="4" style="text-align:left; font-weight:bold; font-size:20px"></td>
	</tr>
	<tr>
		<td style="height: 100px;border: hidden;" colspan="8"></td> 
	</tr>
</table>
<div style="position:relative;">
	<table style="position: absolute;top: 137px;">
		 <tr style="border:hidden;">
		   <td style="border-right:hidden;"></td>
		   <td style="border-right:hidden"></td>
		   <td colspan="2" style="border-right:hidden"></td>
		   <td style="border-right:hidden"></td>
		   <td style="border-right:hidden"></td>
		   <td style="border-right:hidden"></td>
		   <td style="border-right:hidden"></td>
		</tr>
		<tr style="border:hidden;">
		   <td style="border-right:hidden"><span style="font-size:7px;font-weight: bold;"></span></td>
		   <td style="border-right:hidden"><span style="font-weight:bold"></span><br></td>
		   <td colspan="2" style="border-right:hidden;position: relative;"><span style="font-size:8px;font-weight: bold;position: absolute;left: 10px;top: -4px">{{$total_carton}} CTN/BAG:</span></td>
		   <td style="border-right:hidden"></td>
		   <td style="border-right:hidden"><span style="font-weight:bold"></td>
		   <td style="border-right:hidden"><span style="font-weight:bold"></span></td>
		   <td style="border-right:hidden"><span style="font-weight:bold"></span></td>
		</tr>
		<?php $i=0;$j=0;$net_weight_kg_total=0;$gross_weight_kg_total=0;?>
		@foreach($sale_contract_details as $sale_contract_detail)
		<?php $i++; ?>
		<tr style="border:hidden;position: relative;top: -16px">
		   <td style="border-right:hidden;position: relative;"><span style="font-size:9px;position: absolute;left:20px;top:2px">{{$sale_contract_detail->group_name}}@if($sale_contract_detail->hs_code)<br>{{$sale_contract_detail->hs_code}}@endif<br>@if($sale_contract_detail->hs_code_2)
		   <span>{{$sale_contract_detail->hs_code_2}}</span>@endif</td>
		   <td style="border-right:hidden;position: relative;"><span style="font-weight:normal;font-size: 9px;position: absolute;left: -5px">{{$shiping_mark[$j++]}}</span><br></td>
		   <td colspan="2" style="border-right:hidden;left: 35px;position: relative;"><span style="font-weight:normal;font-size: 9px"><pre style="text-align: left;position: absolute;left: -54px;top: -4px"><?php 
		   echo wordwrap($sale_contract_detail->desk_item_name, 33, "\r\n", true); ?></pre>	
		   </span></td>
		   <td style="border-right:hidden;font-size: 9px;text-align: left;position: relative;"><span style="font-size: 9px;left:-38px;position: absolute;">{{$sale_contract_detail->safta_percentage}}</span></td>
		   <td style="border-right:hidden;text-align: left;position: relative;"><span style="font-size: 9px;text-align: left;position: absolute;left: -42px;top:-13px">@if($i==1){{"TOTAL"}}@endif <br> @if($i==1){{"GROSS WT:"}}<br> {{number_format($total_gross_weight,2)}} {{"KGS"}}@endif<br>@if($i==1){{"NET WT:"}}<br>{{number_format($total_net_weight,2)}} {{"KGS/LTR"}}@endif</span></td>
		   <td style="border-right:hidden;text-align: left;position: relative;"><span style="font-weight:normal;font-size: 9px;position: absolute;left: -41px;top: 1px">@if($i==1){{"INVOICE NO:"}}<br><pre style="position: absolute;left: -1px;top:3px">{{$sale_contract->invoice_no}}<br>@if(!empty($sale_contract->invoice_date)){{"DT :".date("d-m-Y", strtotime($sale_contract->invoice_date))}}@endif</pre>@endif</span></td>
		   <td style="border-right:hidden;font-size: 9px;position: relative;"><span style="font-weight:normal;position: absolute;left: -21px">@if($i==1){{'$ '}}{{number_format($total_amount-$freight_charge,2)}}@endif</span></td>
		</tr>
		<tr style="height:15px;border-left: hidden;border-right: hidden;border-bottom: hidden;">
		@endforeach
			<tr style="height:0px;border-left: hidden;border-right: hidden;">
			<td colspan="8" style="border-color: #FFFFFF"></td> 
		</tr>
		<tr style="position:relative;">
			<td style="border: hidden;"></td>
			<td style="border: hidden;"></td>
			<td style="text-align: left;font-size: 9px;border: hidden;position: relative;" colspan="2"><span style="position: absolute;left: -12px;top: -3px;line-height: 11px">@if($sale_contract->is_proforma_invoice == 1){{"PI"}}@else {{"S/C"}} @endif:<br>{{$sale_contract->sales_contract_no}}<br>DT: {{date("d-m-Y", strtotime($sale_contract->dated))}}<br>EXP: {{$sale_contract->export_no}}<br>
			@if($sale_contract->mfg_date_india)MFG: {{$mfg_date}}@endif<br>
			@if(!empty($lot_number))LOT: {{$lot_number}}@endif	
			</span></td>
			<td colspan="4" style="border: hidden;"></td>
		</tr>
	</table>
</div>
<table style="margin-top: 100px">
	 <tr style="border:hidden;">
	   <td style="border-right:hidden;"></td>
	   <td style="border-right:hidden"></td>
	   <td colspan="2" style="border-right:hidden"></td>
	   <td style="border-right:hidden"></td>
	   <td style="border-right:hidden"></td>
	   <td style="border-right:hidden"></td>
	   <td style="border-right:hidden"></td>
	</tr>
	<tr style="border:hidden;">
	   <td colspan="8" style="text-align:left;font-size:7px;border-right:hidden">
	       <br><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   </td>
	</tr>
</table>
 <div class="footer" style="position: relative;">
  	 <div style="font-size: 10px;position: absolute;top: 335;left:178px;">Bangladesh</div> 
  	 <span><p style="font-size: 10px;margin-left: 193px;position:absolute;top:410px;">INDIA</p></span><br>
  	 <span><p style="font-size: 10px;left: 80px;position:absolute;top: 469px;">Dhaka<br>@if(!empty($sale_contract->safta_dated)){{date("d-m-Y", strtotime($sale_contract->safta_dated))}}@endif</p></span>
  </div>
 </div> 
</script>
</body>
</html>

