<style>

*{
    font-size: 10px;
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

   font-size:27px;
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
  <table id="inv" style="margin-left: 0px">
    <h4></h4>
  <tr style="border:hidden" height="10px"></tr>  
	<tr style="border:1px solid #ddd;border: hidden;">
	   <td colspan='8' style="font-weight:bold;position: relative;overflow: hidden;"><p id="heading"><img src="{{asset('img/pran_logo.png')}}" width="45px" height="30px" style="position: absolute;left: -1px;top: -1px;">{{$company->name}}</p></td>
	</tr>
   <tr style="border:hidden" height="24px"></tr>
  <tr style="border:1px solid #ddd;border: hidden;margin-bottom: 5px">
	   <td colspan='8' style="font-style: oblique;font-size:13px">
	      HEAD OFFICE: PRAN-RFL CENTRE, 105 MIDDLE BADDA, DHAKA-1212, BANGLADESH<br>
		  PHONE: 88-02-9881792, FAX: 880 - (02) - 8837464<br>										
	      FACTORY:{{$company->factory_address}}
	   </td>
	</tr>
   <tr style="border:hidden" height="20px"></tr>
  <tr style="border:hidden;">
     <td colspan='6' style="font-weight:bold;text-align:left;font-size:15px">OUR REF. NO: {{$comInvMaster->ref_name}}</td>
     <td colspan='2' style="font-weight:bold;text-align:left;border-left: hidden;font-size:15px">
      Date: <?php if($status==1){ ?>@if($comInvMaster->date){{date("d/m/Y", strtotime($comInvMaster->date))}}@else{{''}}@endif
      <?php }?>
     </td>
  </tr>
  <tr style="border:hidden" height="15px"></tr>
	<tr style="border:hidden;">
	   <td colspan='8' style="font-weight:bold;text-align:left;font-family: 'Times New Roman'"><pre style="font-size: 15px">THE MANAGER<br>{{$bank->name}}<br>{{$bank->address}}</pre></td>
	</tr>
	<tr style="border:hidden;">
	   <td colspan='8' style="font-weight:normal;text-align:left;font-size:15px;font-family: 'Times New Roman'">EXPORT OF PRAN AGRO PROCESSING PRODUCTS UNDER CLAIM FOR CASH  SUBSIDY VIDE F.E CIRCULAR 										
		NO. 15  DATED  06-10-2005 & F.E CIRCULAR NO. 10  DATED 06-07-2005 READ WITH  CIRCULAR										
		LETTER  NO. FEPD (EXPORT-1)  291  /  AGRO PRODUCTS / POLICY / 2005-540  DATED 11-08-2005 										
		ISSUED BY BANGLADESH BANK AGAINST EXP FORM NO.& DATE {{$sale_contract->export_no}} & @if($sale_contract->export_date){{date("d/m/Y", strtotime($sale_contract->export_date))}}@else{{""}}@endif
		<br><br><span style="font-size: 15px;font-weight: bold;">Dear Sir<br><br>																		
        We are taking this opportunity in introducing our selves as Manufacturers/Exporters of Value 										
        added Agro Products from Bangladesh name of “PRAN” AGRO PRODUCTS.</span>										
	   </td>
	</tr>
  <tr style="border:hidden;" height="10px"></tr>
	<tr style="border:hidden;">
	   <td colspan='8' style="text-align:left;font-size:15px;font-family:'Times New Roman';font-weight: bold;">
            1 We  are  submitting  by  enclose  herewith  Cash  Subsidy  Claim,  calculated  @ {{$comInvMaster->claim_percent}}% on 									
			Net   FOB  value,  duly   supported  by  Certificates  issued by   Bangladesh  Agro  Processor’s										
			Association  (BAPA)  along-with  relevant  documents, together  with "(ফরম-খ)" duly filed and 										
			signed  by us, in  terms of  Circular Letter No. FEPD (Export-1) 291 / Agro Products / Policy /										
			2005-540 dated  11-08-2005  read  with F.E. Circular No. 10 dated 06-07-2005& F.E. Circular										
			No. 15 dated  06-10-2005  issued  by  Bangladesh  Bank.										
				   
	   </td>
	</tr>
  <tr style="border:hidden;" height="10px"></tr>
	<tr style="border:hidden;">
	   <td colspan='8' style="text-align:left;font-size:15px;font-weight: bold;">
            2	In  this  connection,  we  would  like to add here that over and  above 70%  of  Local  Raw 									
            materials are  / were used in the exported goods as confirmed by Bangladesh Agro Processor’s										
            Association  (BAPA).											   
	   </td>
	</tr>
  <tr style="border:hidden;" height="10px"></tr>
	<tr style="border:hidden;">
	   <td colspan='8' style="text-align:left;font-size:15px;font-weight: bold;">
            3	Further you are requested to credit our Account with 70% advance as per Bangladesh								
            Bank F.E. circular No. 15, Dated: 08 Sep 2009																	   
	   </td>
	</tr>
  <tr style="border:hidden;" height="10px"></tr>
	<tr style="border:hidden;">
	   <td colspan='8' style="text-align:left;font-size:15px;font-weight: bold;">
            4	 You  are,  therefore,  requested  to  please  forward  our  Cash  Subsidy   Claim  to 									
			Bangladesh  Bank  after  Audit  /  Scrutiny  of all  the shipping  / export documents, for which 										
			charges be debited to our account with you.										
																			   
	   </td>
	</tr>
  <tr style="border:hidden;" height="10px"></tr>
	<tr style="border:hidden;">
	   <td colspan='8' style="text-align:left;font-size:15px;font-weight: bold;">
            5	Please  expedite  acknowledging  receipt  of  the above  for our information and convince									
              us, that the matter is receiving your best attention.	<br><br>
            Thanking you in anticipation and with best regards.<br><br>
            Yours faithfully,<br>
            {{$company->name}}					
            <br><br><br><br>
			-------------------------------
            <br>			
			Authorize Signature<br><br><br><br>			
			Encl: Export Documents containing “ 15 “ pages.							
            <br><br>
			Copy forwarded for information and record to:-<br>
      ------------------------------------------------------------------
      <br>							
			The Honorable President,<br>							
			Bangladesh Agro Processor's Association<br>							
			Navana Newbury Place, Flat # D-6(6th Floor), 4/1/A, Sobhanbagh,<br>							
			Dhanmondi, Dhaka-1207<br>							
   
	   </td>
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
