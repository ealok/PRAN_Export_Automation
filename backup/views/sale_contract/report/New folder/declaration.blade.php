<style>

*{
    font-size: 15px;
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

@page {margin-bottom: 150px;margin-top: 30px}

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

   font-size:28px;
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
  <table id="inv">
    <h4></h4>
	<tr style="border:1px solid #ddd;border: hidden;">
	   <td colspan='8' style="font-weight:bold;position: relative;"><p id="heading"><img src="{{asset('img/pran_logo.png')}}" width="80px" height="45px" style="position: absolute;left: -12px;top: -9px;font-size: 20px">{{$company->name}}</p></td>
	</tr>
    <tr>
     <td colspan="8" style="height: 30px;border-left: hidden;border-right: hidden;"></td>
  </tr>
    <tr style="border:1px solid #ddd;border: hidden;">
	   <td colspan='8' style="font-style: oblique;font-size:15px">
	      HEAD OFFICE: PRAN-RFL CENTRE, 105 MIDDLE BADDA, DHAKA-1212, BANGLADESH<br>
		  PHONE: 88-02-9881792, FAX: 880 - (02) - 8837464<br>										
	      FACTORY: {{$company->factory_address}}
	   </td>
	</tr>
  <tr>
     <td colspan="8" style="height: 10px;border-left: hidden;border-right: hidden;"></td>
  </tr>
  <tr style="border-left: hidden;border-right: hidden;border-top: hidden;">
     <td colspan="8" style="height: 50px"></td>
  </tr>
  <tr style="border:1px solid #ddd;border: hidden;">
     <td colspan='8' style="font-size: 15px;font-weight: bold;text-transform: uppercase;"><span style="border-bottom: 3px solid;font-size: 25">Decleration</span>
     </td>
  </tr>
  <tr style="border-left: hidden;border-right: hidden;">
     <td colspan="8" style="height: 40px"></td>
  </tr>
  <tr style="border:1px solid #ddd;border: hidden;">
     <td colspan='1' style="font-size:20px;"></td>
     <td colspan='3' style="font-size:12px;border-right: hidden;border-left: hidden;">INVOICE NO.{{$comInvMaster->invoice_no}}</td>
     <td colspan='2' style="font-size:12px;border-right: hidden;">DATED. @if($sale_contract->invoice_date){{date("d/m/Y", strtotime($sale_contract->invoice_date))}}@endif</td>
     <td colspan='2' style="font-size:115px;"></td>
  </tr>
  <tr style="border:1px solid #ddd;">
     <td colspan='1' style="font-size:15px;border-left: hidden;"></td>
     <td colspan='3' style="font-size:12px;border-right: hidden;border-left: hidden;">USD {{$comInvMaster->invoice_value}} AGAINST </td>
     <td colspan='3' style="font-size:12px;border-right: hidden;text-align: left;">EXP.NO.{{$comInvMaster->exp_no}}</td>
     <td colspan='1' style="font-size:15px;border-right: hidden;"></td>
  </tr>
  <tr style="border:1px solid #ddd;border: hidden;height: 40px"></tr>
  <tr style="border:1px solid #ddd;border: hidden;">
     <td colspan='8' style="font-size:20px;text-align: left;"><p>We,{{$company->name}}, PRAN RFLCENTER,105, Middle Badda,Dhaka-1212. Bangladesh do  hereby declared as required by Bangladesh  Bank  that  we  have  not availed and  /  or will  not avail any Duty Draw-back Facility and / or Bond Facility against exported goods.</p>
     </td>
  </tr>
  <tr style="border:1px solid #ddd;border: hidden;height: 10px"></tr>
  <tr style="border:1px solid #ddd;border: hidden;">
     <td colspan='8' style="font-size:20px;text-align: left;"><p>We,hereby  further  declared  that  percentage  of Local Ingredients  used  in  our Exported products  along with in  this claim is  true  and  correct  to the best of our Knowledge and belief.</p>               
     </td>
  </tr>
  <tr style="border:1px solid #ddd;border: hidden;height: 10px"></tr>
  <tr style="border:1px solid #ddd;border: hidden;">
     <td colspan='8' style="font-size:20px;text-align: left;"><p>We,  hereby  further  declared that we are applying only for Cash Incentive Facility against Export of Agro Processed  Products in terms of Circular Letter No.FEPD (Export-1)  291  /  Agro  Products Policy  /  2005-540  dated 11-08-2005 read with F.E. Circular No. 10 dated 06-07-2005 and F.E. Circular No. 15 dated  06-10-2005 issued by Bangladesh Bank.</p>
     </td>
  </tr>
	<tr style="border:hidden;">
	   <td colspan='8' style="font-weight:bold;text-align:left;font-size:15px"><br><br><br>
			For {{$company->name}}<br><br><br><br>			
			
      ---------------------------------------------<br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($is_director==1) {?>Director<?php } ?><br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date : <?php if($status==1){ ?>{{date("d-m-Y", strtotime($comInvMaster->date))}}<br>
      <?php }?>		 
	   </td>
	</tr>
</table>
<script>document.title = 'Declaration | Report';
  function exportF(elem) {
    var table = document.getElementById("inv");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
    elem.setAttribute("href", url);
    elem.setAttribute("download", "Declaration.xls"); // Choose the file name
    return false;
  }
</script>
</body>
</html>
