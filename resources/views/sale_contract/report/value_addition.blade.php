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
   </style>
  <table style="margin-left: 0px">
    <h4></h4>
    <tr>
	    <td colspan='8' style="font-style: oblique;border-right: hidden;border-left: hidden;border-top:hidden;font-family: SutonnyMJ;font-size: 30px">¯’vbxqg~j¨ ms‡hvR‡binvi<br>GdBmvK©yjvi bs 29, †m‡Þ¤^i 20, 2021
      </td>
	  </tr> 
  <tr>
    <td colspan='8'><span style="font-style: oblique;border-right: hidden;border-left: hidden;border-top:hidden;font-family: SutonnyMJ;text-align: left;font-weight: bold;font-size: 20px;margin-left: -400px;">Bbf‡qm bv¤^vi </span>: <span style="font-size:20px">{{$sale_contract->invoice_no}}</span></td>
  </tr>  
	<tr>
    <td style="font-size:20px; font-weight:bold;font-family: SutonnyMJ" colspan="2">cÖZ¨vevwmZißvwbg~j¨</td> 
	  <td data-label="Amount" style="font-size:20px;font-weight:bold;font-family: SutonnyMJ" colspan="2">cÖ‡hvR¨ †ÿ‡Î RvnvR fvovi cwigvY
    </td>
	  <td data-label="Amount" style="font-size:20px;font-weight:bold;font-family: SutonnyMJ" colspan="2">‰e‡`wkKgy`ªvqcwi‡kva¨ Kwgkb, BÝy‡iÝBZ¨vw` (hw` _v‡K)
    </td>
	  <td data-label="Amount" style="font-size:20px;font-weight:bold;font-family: SutonnyMJ" colspan="2">bxUGdIweißvwbg~j¨<br>1-(2+3)</td>
  </tr>
	<tr>
    <td style="font-size:15px; font-weight:normal" colspan="2">১</td>
	  <td data-label="Amount" style="font-size:15px;font-weight:normal" colspan="2">২</td>
	  <td data-label="Amount" style="font-size:15px;font-weight:normal" colspan="2">৩</td>
	  <td data-label="Amount" style="font-size:15px;font-weight:normal" colspan="2">৪</td>
  </tr>
  <tr>
    <td style="font-size:20px; font-weight:bold" colspan="2">USD {{$comInvMaster->realise_value}}</td>
	  <td data-label="Amount" style="font-size:20px;font-weight:bold" colspan="2">USD {{$comInvMaster->freight_cost}}</td>
	  <td data-label="Amount" style="font-size:20px;font-weight:bold" colspan="2">USD {{$comInvMaster->non_eligible_item}}</td>
	  <td data-label="Amount" style="font-size:20px;font-weight:bold" colspan="2">USD {{round($net_fob_value,2)}}</td>
  </tr>
  <tr style="border-left: hidden;border-right: hidden;">
      <td colspan="8"></td>
  </tr>  
	<tr>
	  <td data-label="Amount" style="font-size:20px;font-weight:bold;font-family: SutonnyMJ" colspan="4">ißvwbcY¨ Drcv`‡b e¨eüZ c‡Y¨ig~j¨
    </td>
	  <td data-label="Amount" style="font-size:20px;font-weight:bold;font-family: SutonnyMJ" colspan="4" rowspan="2">¯’vbxqg~j¨ ms‡hvR‡binvi<br>[(4-5)/4]*100
    </td>
  </tr>
	<tr>
    <td style="font-size:20px; font-weight:bold;font-family: SutonnyMJ" colspan="4">Avg`vbxK…Z cY¨</td>
  </tr>
  <tr>
    <td style="font-size:20px; font-weight:normal;font-family: SutonnyMJ" colspan="4">5</td>
    <td data-label="Amount" style="font-size:20px;font-weight:normal;font-family: SutonnyMJ" colspan="4">6</td>
  </tr>
  <tr>
	  <td data-label="Amount" style="font-size:20px;font-weight:bold" colspan="4">USD {{round($imported_value,2)}}</td>
    <td data-label="Amount" style="font-size:20px;font-weight:bold" colspan="4">{{round($result,2)}}%</td>
  </tr>
  <tr style="border-left:hidden;border-right:hidden;border-bottom:hidden;height: 200px;"></tr>
  <tr style="border-left:hidden;border-right:hidden;border-bottom:hidden">
      <td style="font-size: 15px; font-weight:bold;font-family: SutonnyMJ" colspan="8"><span style="position: absolute;left: 102px;">ZvwiL : {{date("d-m-Y", strtotime($comInvMaster->date))}}</span><span style="margin-right: -400px;font-size: 18px">Av‡e`bKvix cÖwZôv‡bi ¯^Z¡vwaKvix/¶gZvcÖvßKg©KZ©vi<br></span><span style="margin-right: -400px;font-size: 18px;">¯^v¶i</span></td>
  </tr>
</table>
<script>document.title = 'Value Addition| Report';
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
