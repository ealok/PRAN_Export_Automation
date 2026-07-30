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

@page {margin-bottom: 150px;margin-top: 100px}

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

  font-family: "Open Sans", sans-serif;
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
#heading::after{

    content: "";
	background-image: url('iso.png');
	width: 114px;
	height: 87px;
	position: absolute;
	margin: -28px 17px 0px 1px;    

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
#heading::after{

    content: "";
	background-image: url('iso.png');
	width: 114px;
	height: 87px;
	position: absolute;
	margin: -28px 17px 0px 1px;    

}
#under{
   
   border-bottom: 2px solid;
}
   </style>   
  <table id="inv" style="margin-left: 35px">
    <h4></h4>
	<tr style="border: hidden;">
    <td style="font-size:12px; font-weight:bold; text-align:left;" colspan="5">OUR REF. NO: {{$comInvMaster->ref_name}}</td>
	  <td style="font-size:12px; font-weight:bold; text-align:left;border-left: hidden;" colspan="3">
      Date: <?php if($status==1) { ?>@if($comInvMaster->date){{date("d/m/Y", strtotime($comInvMaster->date))}}@else{{""}}@endif
      <?php }?>
    </td>
    </tr>
  <tr style="border: hidden;height: 10px"></tr>  
	<tr style="border: hidden;">
      <td style="font-size:14px; font-weight:bold; text-align:left" colspan="8"><pre style="font-size: 12px;font-family:'Times New Roman'">THE MANAGER<br>{{$bank->name}}<br>{{$bank->branch}}{{$bank->address}}</pre>
      </td>
    </tr>
  <tr style="border: hidden;height: 10px"></tr>  
	<tr style="border: hidden;">
      <td style="font-size:13px; font-weight:normal; text-align:left" colspan="8">
	    Index  of  Export  documents  pertaining  to  Cash  Subsidy Claim  in terms  of  Circular  Letter  No.								
		FEPD  (Export-1) 291 /  Agro  Products Policy  /2005-540 dated 11-08-2005 read with F.E. Circular									
		No.10 dated 06-07-2005  &  F.E. Circular No. 15  dated 06-10-2005  issued  by  Bangladesh Bank.
		   <p>INVOICE NO: {{$comInvMaster->invoice_no}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATED: @if($sale_contract->invoice_date){{date("d/m/Y", strtotime($sale_contract->invoice_date))}}@else{{""}}@endif</p>
		   <p>USD: {{$comInvMaster->exp_value}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AGAINST EXP. NO:{{$comInvMaster->exp_no}}</p>
      </td>
    </tr>
  <tr style="border: hidden;height: 25px"></tr>  
	<tr style="border: hidden;">
      <td style="font-size:10px; font-weight:bold; text-align:left;" colspan="2"><span style="border-bottom: 1px solid">SL.No.</span></td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2"><span style="border-bottom: 1px solid">DESCRIPTION</span></td>
	  <td style="font-size:10px;border-left: hidden;text-align: left;font-weight: bold;" colspan="2"><span style="border-bottom: 1px solid">ANNEXURE</span></td>
	  <td style="font-size:10px;border-left: hidden;text-align: left;font-weight: bold;" colspan="2"><span style="border-bottom: 1px solid">PAGE NO.</span></td>
    </tr>
	<tr style="border: hidden;">
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">01</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">CALCULATION SHEET</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">A-1</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">001 TO 001</td>
	</tr>
	<tr style="border: hidden;">
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">02</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">BAPA CERTIFICATE</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">A-2</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">002 TO 002</td>
	</tr>
	<tr style="border: hidden;">
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">03</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">DECLARATION</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">A-3</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">003 TO 003</td>
	</tr>
	<tr style="border: hidden;">
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">04</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">FORM (ফরম-খ)</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">B</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">004 TO 004</td>
	</tr>
	<tr style="border: hidden;">
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">05</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">DETAIL OF PARA (ঘ)-১ FROM (ফরম-খ)</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">C</td>
	  <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">005 TO 005</td>
	</tr>
  <tr style="border: hidden;">
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">06</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">DETAIL OF PARA (ঘ)-১ FROM (ফরম-খ)</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">D</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">006 TO 006</td>
  </tr>
  <tr style="border: hidden;">
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">07</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">SALES CONTRACT</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">G</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">007 TO 007</td>
  </tr>
  <tr style="border: hidden;">
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">08</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">EXP FORM</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">H</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">008 TO 008</td>
  </tr>
  <tr style="border: hidden;">
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">09</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">COMMERCIAL INVOICE</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">I</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">009 TO 009</td>
  </tr>
  <tr style="border: hidden;">
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">10</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">PACKING LIST</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">J</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">010 TO 010</td>
  </tr>
  <tr style="border: hidden;">
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">11</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">SHIPPING BILL</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">K</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">011 TO 011</td>
  </tr>
  <tr style="border: hidden;">
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">12</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">BILL OF LADING</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">L</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">012 TO 012</td>
  </tr>
  <tr style="border: hidden;">
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">13</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">FREIGHT BILL</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">M</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">013 TO 013</td>
  </tr>
  <tr style="border: hidden;">
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">14</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">P.R.C.(PROCEEDS REALIZATION CERTIFICATE)</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">N</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">014 TO 014</td>
  </tr>
  <tr style="border: hidden;">
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">15</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">FORM (ফরম-খ) PAGE # 2</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">O</td>
    <td style="font-size:10px; font-weight:bold; text-align:left;border-left: hidden;" colspan="2">015 TO 015</td>
  </tr>
</table>
<script>document.title = 'Annexure | Report';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "Annexure_report.xls"); // Choose the file name
  return false;
}
</script>
</body>
</html>
