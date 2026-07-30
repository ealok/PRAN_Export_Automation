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
</head>
<body>
  <style>
body {

  line-height: 1.25;
  
}

@font-face {
  
    font-family: SutonnyMJ;
    src: url('{{asset('font/SutonnyMJ Regular.ttf')}}');
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
    <h4></h4>
	<tr style="border:1px solid #ddd;border: hidden;">
	   <td colspan='12' style="font-family: SutonnyMJ;font-size: 20px">(fZ©~wK cwi‡kvaKvix e¨vsK kvLv KZ©„K e¨envh©  Ask)</td>
	</tr>
    <tr style="border:hidden;">
	   <td colspan='10' style="font-size: 13px"> </td>
	   <td style="font-size: 13px;border-left: hidden;font-family: SutonnyMJ" colspan="2">dig - L</td>
	</tr>
    <tr>
	   <td colspan='10' style="font-size: 13px;border-left: hidden;"></td>
	   <td style="font-size: 13px;border-left: hidden;border-right: hidden;font-family: SutonnyMJ" colspan="2">c„ôv-2</td>
	</tr>
  <tr>
      <td scope="col" colspan="10" style="font-size: 13px;border-top: hidden;border-left: hidden;text-align: left;font-family: SutonnyMJ">(Q) fZ~©wKi cwi‡kva¨ cwigvb wnmvevqb t  </td>
	  <td data-label="Amount" style="font-size: 13px;border-top: hidden;border-left: hidden;border-right: hidden;font-family: SutonnyMJ" colspan="2">(ˆe‡`wkK gy`ªvq)</td>
    </tr>
	<tr>
      <td style="font-size: 13px;font-family: SutonnyMJ">ißvwbc‡Y¨i eY©bv</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: SutonnyMJ">‡gvU cÖZ¨vevwmZ ißvwbgyj¨</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: SutonnyMJ">cÖ‡hvR¨ †¶‡Î RvnvR<br>fvovi cwigvb</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: SutonnyMJ" colspan="2">‰e‡`wkK gy`ªvq we‡`‡k cwi‡kva¨ Kwgkb,<br>Bbmy¨‡iÝ BZ¨vw` (hw` _v‡K)</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: SutonnyMJ">bxU GdIwe ißvwbgyj¨<br>২ - (৩+৪)</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: SutonnyMJ" colspan="2">ißvwb cY¨ Drcv`‡b e¨eüZ ¯’vbxq DcKibvw`i  <br>gyj¨ N(1) Aby‡”Q‡`i 3bs Kjvg †gvZv‡eK</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: SutonnyMJ" colspan="2">ißvwb Av‡qi g‡a¨ †`kxq DcKibvw`<br>e¨env‡ii kZKiv nvi (5/4) <span style="font-family: Times New Roman;font-size: 13px">x</span> 100</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: SutonnyMJ" colspan="2">cwi‡kva‡hvM¨ fZ©ywKi cwigvb (UvKvq) t<br>5 Gi {{$comInvMaster->claim_percent}} * ißvbxg~j¨  cÖZ¨vevm<br>Zvwi‡L mswk­ó ‰e‡`wkK gy`ªvi IwW mvBU µq nvi</td>
    </tr>
	<tr>
    <td style="font-size: 13px;font-family: SutonnyMJ">১</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: SutonnyMJ">২</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: SutonnyMJ">৩</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: SutonnyMJ" colspan="2">৪</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: SutonnyMJ">৫</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: SutonnyMJ" colspan="2">৬</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: SutonnyMJ" colspan="2">৭</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: SutonnyMJ" colspan="2">৮</td>
    </tr>
	<tr>
    <td style="font-size: 13px;font-family: Times New Roman">PRAN FOOD STUFF</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: Times New Roman">{{number_format($comInvMaster->realise_value,2)}}</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: Times New Roman">{{number_format($comInvMaster->freight_cost,2)}}</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: Times New Roman" colspan="2">{{number_format($comInvMaster->insurance,2)}}</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: Times New Roman">{{number_format($comInvMaster->net_fob,2)}}</td>
	  <td data-label="Amount" style="font-size: 13px;font-family: Times New Roman" colspan="2">{{number_format($comInvMaster->local_material,2)}}</td>
	  <td data-label="Amount" style="font-size: 13px" colspan="2">{{number_format((($comInvMaster->local_material/$comInvMaster->net_fob)*100),2)}}%</td>
    <?php $uses_rate=$comInvMaster->net_fob*$comInvMaster->claim_percent/100;?>
	  <td data-label="Amount" style="font-size: 13px" colspan="2">{{number_format($uses_rate,2)}}</td>
  </tr>
	<tr>
      <td style="font-size: 13px;border-right:hidden;border-left:hidden;font-family: SutonnyMJ" colspan="6">* Ab~¨b 80% ¯’vbxq DcKib e¨eüZ nB‡j 30% Ges Ab~¨b 70% ¯’vbxq DcKib e¨eüZ nB‡j 20% fZz©Kx cÖvc¨ nB‡e|</td>
	  <td data-label="Amount" style="font-size: 13px;border-right: hidden;" colspan="2">@</td>
	  <td data-label="Amount" style="font-size: 13px" colspan="2">{{$comInvMaster->od_sight_rate}}</td>
	  <td data-label="Amount" style="font-size: 13px;border-right: hidden;border-left: hidden;" colspan="2">BDT {{number_format($uses_rate*$comInvMaster->od_sight_rate,2)}}</td>
    </tr>
  <tr style="border:hidden;">
     <td colspan="12" style="height: 60px;"></td>
  </tr>  
	<tr style="border: hidden;">
      <td style="font-size: 13px;border-right: hidden;text-align: left;font-family: SutonnyMJ" colspan="3">cwi‡kvwaZ fZ~©wKi cwigvb (UvKvq) t <br><br><br>cwi‡kv‡ai ZvwiL t </td>
	  <td data-label="Amount" style="font-size: 13px" colspan="7"></td>
	  <td data-label="Amount" style="font-size: 13px;border-left:hidden;font-family: SutonnyMJ" colspan="2">
-------------------------------------------<br>
      fZ’©wK Aby‡gv`‡bi ¶gZvcÖvß e¨vsK<br>Kg©KZ©vi ¯^v¶i, bvg I c`ex |</td>
    </tr>
	<tr style="border: hidden;">
      <td style="font-size: 13px;border-right: hidden;text-align: left;" colspan="2"></td>
	  <td data-label="Amount" style="font-size: 13px" colspan="10"></td>
    </tr>
</table>
<script>document.title = 'F_kha_2 | Report';
  function exportF(elem) {
    var table = document.getElementById("inv");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
    elem.setAttribute("href", url);
    elem.setAttribute("download", "f_kha_2.xls"); // Choose the file name
    return false;
  }
</script>
</body>
</html>
