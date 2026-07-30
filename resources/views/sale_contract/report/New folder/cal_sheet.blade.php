<style>

*{
    font-size: 20px;
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

@page {margin-bottom: 150px;margin-top: 100px;margin-left:15px;margin-right: 5px}

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
	margin: -39px 17px 0px -120px;


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
	margin: -40px 17px 0px -120px;


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
}
   </style>
  <table style="margin-left: 0px">
    <h4></h4>
	<tr style="border:1px solid #ddd;border: hidden;position: relative">
	   <td colspan='8' style="font-weight:bold"><p id="heading"><img src="{{asset('img/pran_logo.png')}}" width="78px" height="62px" style="position: absolute;top: -13px;left: 30px;">CASH SUBSIDY<img src="{{asset('img/iso.png')}}" width="78px" height="62px" style="position: absolute;top:-11px;left: 1100px;"></p></td>
	</tr>
    <tr style="border:1px solid #ddd">
	   <td colspan='8' style="font-style: oblique;border-right: hidden;border-left: hidden;"><span id="under">CALCULATION SHEET</span></td>
	</tr>
	<tr>
      <td style="font-size:11px; font-weight:bold">EXP FORM NO.</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">{{$comInvMaster->exp_no}}</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">INVOICE NO.</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">{{$comInvMaster->invoice_no}}</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">INVOICE AMOUNT</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">USD {{$comInvMaster->exp_value}}</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">AMOUNT REALIZED</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">USD {{$comInvMaster->realise_value}}</td>
    </tr>
	<tr>
      <td style="font-size:11px;font-weight:bold">DATED</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">
    @if($comInvMaster->exp_date){{date("d/m/Y", strtotime($comInvMaster->exp_date))}}@else{{""}}@endif  
    </td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">DATED</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">@if($comInvMaster->invoice_date){{date("d/m/Y", strtotime($comInvMaster->invoice_date))}}@else{{""}}@endif</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">NO OF EXPORTED CARTON</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">{{$comInvMaster->carton}}</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">REALIZED DATE:</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">@if($sci->proceeds_realization_date){{date("d-m-Y", strtotime($sci->proceeds_realization_date))}}@endif</td>
    </tr>
  <tr style="border-left: hidden;border-right: hidden;">
      <td colspan="8"></td>
  </tr>  
	<tr>
      <td style="font-size:11px;font-weight:bold">Realized<br>Amount</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">Freight<br>Amount</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">Commission/<br>Insurance</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">F.O.B. Value<br>Col. 1-(2+3)</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">Amount of Product<br>Not Eligible For Cash<br>Subsidy</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">Amount Eligible For<br>Cash Subsidy<br>Col.(4-5)</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold" colspan="2">Claim Amount @ 20%<br>On Net F.O.B. Value Col.<br>(6/100X20)</td>
    </tr>
	<tr>
      <td style="font-size:11px;font-weight:bold">Col-1</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">Col-2</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">Col-3</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">Col-4</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">Col-5</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">Col-6</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold" colspan="2">Col-7</td>
    </tr>
	<tr>
      <td style="font-size:11px;font-weight:bold">${{number_format($comInvMaster->realise_value,2)}}</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">${{number_format($comInvMaster->freight_cost,2)}}</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">@if($comInvMaster->insurance)${{number_format($comInvMaster->insurance,2)}}@else{{"0"}}@endif</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">${{number_format($comInvMaster->realise_value-$comInvMaster->freight_cost-$comInvMaster->insurance,2)}}</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">${{number_format($comInvMaster->non_eligible_item,2)}}</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold">${{number_format($comInvMaster->realise_value-$comInvMaster->freight_cost-$comInvMaster->insurance-$comInvMaster->non_eligible_item,2)}}</td>
	  <td data-label="Amount" style="font-size:12px;font-weight:bold" colspan="2">${{number_format($comInvMaster->net_fob*0.2,2)}}</td>
    </tr>
</table>
<script>document.title = 'Cash Subsidy| Report';
  function exportF(elem) {
    var table = document.getElementById("inv");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
    elem.setAttribute("href", url);
    elem.setAttribute("download", "cal_sheet.xls"); // Choose the file name
    return false;
  }
</script>
</body>
</html>
