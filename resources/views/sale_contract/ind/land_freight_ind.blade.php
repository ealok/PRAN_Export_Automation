<style>

*{
    font-size: 10px;
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

@page {margin-bottom: 150px;margin-top: 20px,margin-left:20px;margin-right: 15px}

</style>
<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
</section>
</div>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
</head>
<body>
  <style>
body {

  font-family: "Times New Roman";
  line-height: 1.25;
  
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
#inv{
   
   margin-left: 37px;

}
}
</style>
<table id="inv" style="margin-left: 0px;margin-left: 50px">
    <h4></h4>
    <tr style="border:hidden" height="30px"></tr>
  	<tr style="border:hidden;">
  	   <td colspan='8' style="text-align: left;background-color: #fff;font-size:32px;font-weight:bold;text-align: center;position: relative;"><spna style="font-size:32px;font-weight:bold;position: absolute;left: 123px;top: -52px;">@if(!empty($agency->transport_agency_info)){{$agency->transport_agency_info}}@endif</spna><br><span style="font-weight: normal;font-size: 17px;font-style: italic;word-spacing: 3.1;position: absolute;left: 144px;top:-11px">@if(!empty($agency->sloga)){{$agency->slogan}}@endif</span></td>
  	</tr>
    <tr style="border:hidden" height="40px"></tr>
    <tr style="border:hidden;">
       <td colspan='8' style="text-align: left;background-color: #fff"><pre style="font-size: 15px;font-weight: bold">@if(!empty($agency->description)){{$agency->description}}@endif</pre></td>
    </tr>
    <tr style="border:hidden" height="20px"></tr>
    <tr style="border:hidden;">
       <td colspan='8' style="text-align: left;background-color: #fff;font-size: 15px;font-weight: bold;text-transform: uppercase">Date: @if(!empty($sale_contract->freight_date)){{date("d-m-Y", strtotime($sale_contract->freight_date))}}@endif</td>
    </tr>
    <tr style="border:hidden;text-align: center;" height="40px"></tr>
    <tr style="border:hidden;">
       <td colspan='8' style="text-align: left;background-color: #fff;"><span style="margin-left: 202px;font-size: 18px;font-weight: bold">TO WHOM IT MAY CONCERN</span></td>
    </tr>
    <tr style="border:hidden;text-align: center;" height="50px"></tr>
    <tr style="border:hidden;">
       <td colspan='8' style="text-align: left;background-color: #fff;line-height: 2.5;font-weight: normal;font-size: 12px;">
         THIS IS CERTIFY THAT WE HAVE RECEIVED FROM "{{$sale_contract->company->name}}" {{$sale_contract->currency->currency_name}} {{$sale_contract->freight_charge_india*$exchange_rate}} AS FREIGHT FOR CARRYING PRAN PRODUCTS<br>AGANINST THE SALES CONTRACT NO: {{$sale_contract->sales_contract_no}}, DATE: @if(!empty($sale_contract->dated)) {{date("d-m-Y", strtotime($sale_contract->dated))}}@endif, INVOICE NO: {{$sale_contract->invoice_no}}, DATE: @if(!empty($sale_contract->invoice_date)) {{date("d-m-Y", strtotime($sale_contract->invoice_date))}}@endif
       </td>
    </tr>
    <tr style="border:hidden;text-align: center;" height="150px"></tr>
    <tr style="border:hidden;">
       <td colspan='8' style="text-align: left;background-color: #fff;font-size: 17px;font-weight: bold;">Signature of the transport operator............................</span></td>
    </tr>
</table>
<script>document.title = 'Forwarding | Report';
  function exportF(elem) {
    var table = document.getElementById("inv");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
    elem.setAttribute("href", url);
    elem.setAttribute("download", "forwarding.xls"); // Choose the file name
    return false;
  }
</script>
</body>
</html>
