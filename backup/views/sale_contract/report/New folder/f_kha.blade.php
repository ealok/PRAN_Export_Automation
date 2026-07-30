<style>

*{
    font-size: 9px;
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
<meta charset="utf-8" />
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

    text-align: center;
    border: 1px solid #222;
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
}
   </style>
  <table id="inv">
    <h4></h4>
	<tr style="border: hidden;">
      <td style="font-size: 15px; font-weight:bold; text-align:left;font-family: SutonnyMJ" colspan="4">(Aby‡”Q` 03 (L), GdB mvKz©jvi bs- 15/2005 `ªóe¨)</td>
	  <td style="font-size: 15px; font-weight:bold; text-align:right;border-right: hidden;border-left: hidden;font-family: SutonnyMJ" colspan="2">dig--L<br></td>
	  <td style="font-size: 15px; font-weight:bold; text-align:left;font-family: SutonnyMJ" colspan="2"><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c„ôv-1</td>
    </tr>
	<tr height="40">
      <td style="font-size:20px; font-weight:bold; text-align:center;border-left: hidden;border-right: hidden;font-family: SutonnyMJ" colspan="8">cÖwµqvRvZ (G‡MÖvcÖ‡mwms) K…wlcY¨ ißvbxi wecix‡Z fZy©Kxi Rb¨ Av‡e`bcÎ|</td>
  </tr>
	<tr style="border: hidden;">
      <td style="font-size: 15px; font-weight:bold; text-align:left" colspan="8"><span style="font-weight:bold;font-size: 15px;font-family: SutonnyMJ">(K) Av‡e`bKvixi bvg I wVKvbv t  </span><span style="font-size: 15px;font-family: Times New Roman">{{$company->name}}, PRAN-RFL CENTRE 105, MIDDLE BADDA, DHAKA-1212,  BANGLADESH</span><br><span style="font-weight:bold;font-size: 15px;font-family: SutonnyMJ">ißvwb wbeÜb mb`cÎ b¤^i  t </span><span style="font-size: 15px;font-family: Times New Roman">{{$company->reg_number}}</span></td>
    </tr>
  <tr style="border-left: hidden;border-right: hidden;border-top: hidden;">
      <td colspan="8" height="5px"></td>
  </tr>   
	<tr style="border: hidden;">
      <td style="font-size: 15px; font-weight:bold; text-align:left;border-right: hidden;" colspan="3"><span style="font-weight:bold;font-size: 15px;font-family: SutonnyMJ">(L) ißvwb FYcÎ/Pzw³c‡Îi b¤^i, ZvwiL I g~j¨ t<br><span style="font-size: 15px;font-family: SutonnyMJ">(cvV‡hvM¨ mZ¨vwqZ Kwc `vwLj Ki‡Z nB‡e)</span></span></td>

	    <td colspan="2" style="font-size: 11px;border-right: hidden;">@if($sci->lc_number){{$sci->lc_number}}@else{{$comInvMaster->sc_no}}@endif</td>
	    <td colspan="2" style="font-size: 11px;border-right: hidden;">@if($sci->lc_date){{$sci->lc_date}}@else{{date("d/m/Y", strtotime($comInvMaster->sc_date))}}@endif</td>
	    <td style="font-size: 11px">USD @if($sci->lc_number){{$sci->lc_value}}@else{{$comInvMaster->sc_value}}@endif</td>
    </tr>
    <tr style="border-left: hidden;border-right: hidden;border-top: hidden;">
      <td colspan="8" height="5px"></td>
  </tr>   
	<tr style="border: hidden;">
      <td style="font-size: 15px; font-weight:bold; text-align:left;border-right: hidden;" colspan="3"><span style="font-weight:bold;font-size: 15px;font-family: SutonnyMJ">(M) wUwUi b¤^i, ZvwiL I gyj¨ t</span></td>
	  <td style="font-size: 11px;border-right: hidden;font-family: Times New Roman" colspan="2">{{$sci->tt_number}}</td>
	  <td style="font-size: 11px;border-right: hidden;text-align: center;font-family: Times New Roman" colspan="2">@if($sci->tt_date){{date("d/m/Y", strtotime($sci->tt_date))}}@else{{""}}@endif</td>
	  <td style="font-size: 11px;font-family: Times New Roman">USD {{$sci->tt_amount}}</td>
    </tr>
  <tr style="border-left: hidden;border-right: hidden;border-top: hidden;">
      <td colspan="8" height="5px"></td>
  </tr>     
	<tr style="border: hidden;">
      <td style="font-size: 15px; font-weight:normal; text-align:left;font-family: SutonnyMJ" colspan="8">(we‡`k nB‡Z wUwUi gva¨‡g ißvbx g~j¨ cÖZ¨vevwmZ nB‡j wUwUi gva¨‡g cÖvwß mswk­ó ißvbxi wecix‡Z nBevi welqwU wUwUi fvl¨ nB‡Z e¨vsK KZ©„K wbwðZ  nBqv jB‡Z nB‡e)</td>
    </tr>
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:left;border-left: hidden;border-right: hidden;font-family: SutonnyMJ" colspan="8">(N) ißvwbK…Z cY¨ Drcv`‡b e¨eüZ DcKibvw`i msMÖn m~Î t</td>
    </tr>
	<tr height="40px">
      <td style="font-size: 15px; font-weight:bold; text-align:left;border-left: hidden;border-top: hidden;border-right: hidden;font-family: SutonnyMJ" colspan="8">(1) †`kxq DcKibvw`t</td>
  </tr>
  <tr style="border-left: hidden;border-right: hidden;border-top: hidden;">
      <td colspan="8"></td>
  </tr>
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 15px">mieivnKvixi bvg I wVKvbv</span></td>
	  <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 15px">c‡Y¨i bvg I cwigvY</span></td>
	  <td style="font-size: 15px;font-family: SutonnyMJ;font-size: 15px" colspan="4">g~j¨</td>
    </tr>
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 10px">১</span></td>
	  <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 10px">২</span></td>
    <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="4"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 10px">৩</span></td>
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-size: 11px">Annexure-C</span></td>
	    <td style="font-size: 11px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-size: 11px">Annexure-C</span></td>
	    <td style="font-size: 11px; font-weight:normal; text-align:center" colspan="4">USD:{{number_format($comInvMaster->local_material,2)}}</td>
  </tr>
	<tr height="10px">
      <td style="font-size: 12px; font-weight:normal; text-align:left;border-left: hidden;border-right: hidden;border-bottom: hidden;font-family: SutonnyMJ" colspan="8">(ißvbx c‡Y¨i eY©bv, cwigvY, g~j¨ Ges msMÖnm~‡Îi wel‡q ißvbx Dbœqb ey¨‡iv/mswk­ó G‡mvwm‡qkb cÖ`Ë mb`cÎ `vwLj Kwi‡Z nB‡e)</td>
    </tr>  
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:left;border-left: hidden;border-right: hidden;border-right: hidden;font-family: SutonnyMJ" colspan="8" height="30px">(2) Avg`vbxK…Z / we‡`‡k Drcvw`Z DcKibvw`t</td>
  </tr>
  <tr style="border-left: hidden;border-right: hidden;border-top: hidden;">
      <td colspan="8"></td>
  </tr>
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 15px">mieivnKvixi bvg I wVKvbv</span></td>
	  <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 15px">c‡Y¨i bvg I cwigvY</span></td>
	  <td style="font-size: 15px;font-family: SutonnyMJ" colspan="3">we‡`k nB‡Z Avg`vbxi †¶‡Î FYc‡Îi b¤^i, ZvwiL</td>
	  <td style="font-size: 15px;font-family: SutonnyMJ">g~j¨</td>
    </tr>
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 10px">১</span></td>
	  <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 10px">২</span></td>
    <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="3"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 10px">৩</span></td>
    <td style="font-size: 15px; font-weight:bold; text-align:center"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 10px">৪</span></td>
    </tr>
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-size: 11px">Annexure-D</span></td>
	  <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-size: 11px">Annexure-D</span></td>
	  <td style="font-size: 11px" colspan="3">Annexure-D</td>
	  <td style="font-size: 11px">USD {{$showValue}}</td>
    </tr>
	<tr height="50px">
      <td style="font-size: 12px; font-weight:normal; text-align:left;border-left: hidden;border-right: hidden;font-family: SutonnyMJ" colspan="8">(3bs Kjv‡g Dwj­wLZ FYcÎ¸wji cvV‡hvM¨ mZ¨vwqZ Kwc `vwLj Kwi‡Z nB‡e| GB ißvbx‡Z e¨eüZ DcKibvw`i Rb¨ ïé eÛ myweav MÖnY<br>Kiv nq bvB Ges wWDwU Wª e¨vK A_ev fZ©ywK myweavi Av‡e`bI Kiv nq bvB I nB‡e bv GB g‡g© ißvbxKvi‡Ki †Nvlbv cÎ `vwLj Kwi‡Z nB‡e|)</td>
    </tr>
	<tr hidden="50px">
      <td style="font-size: 15px; font-weight:bold; text-align:left;border-left: hidden;border-right: hidden;border-top: hidden;font-family: SutonnyMJ" colspan="8" height="30px">(ঙ) রপ্তানি চালানের বিবরণঃ</td>
    </tr>
   <tr style="border-left: hidden;border-right: hidden;border-top: hidden;">
      <td colspan="8"></td>
</tr> 
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:center"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 15px">c‡Y¨i eY©bv</span></td>
	  <td style="font-size: 15px; font-weight:bold; text-align:center"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 15px">cwigvb</span></td>
	  <td style="font-size: 15px;font-family: SutonnyMJ">Bbf‡qm g~j¨<br>(ˆe‡`wkK g~`ªvq)</td>
	  <td style="font-size: 15px;font-family: SutonnyMJ">RvnvRxKi‡bi ZvwiL</td>
	  <td style="font-size: 15px;font-family: SutonnyMJ" colspan="2">BGK&ª wc b¤^i</td>
	  <td style="font-size: 15px;font-family: SutonnyMJ" colspan="2">ˆe‡`wkKg~`ªvcÖZ¨vevwmZißvwb g~j¨ I cÖZ¨vevm‡bi ZvwiL</td>
    </tr>
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:center"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 10px">১</span></td>
	   <td style="font-size: 15px; font-weight:bold; text-align:center"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 10px">২</span></td>
	   <td style="font-size: 15px;font-family: SutonnyMJ;font-size: 10px">৩</td>
	   <td style="font-size: 15px;font-family: SutonnyMJ;font-size: 10px">৪</td>
	   <td style="font-size: 15px;font-family: SutonnyMJ;font-size: 10px" colspan="2">৫</td>
	   <td style="font-size: 15px;font-family: SutonnyMJ;font-size: 10px" colspan="2">৬</td>
  </tr>
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:center"><span style="font-weight:normal;font-size: 11px">As per Packing & Weight list</span></td>
	    <td style="font-size: 15px; font-weight:bold; text-align:center"><span style="font-weight:normal;font-size: 11px">As per Packing & Weight list</span></td>
	    <td style="font-size: 11px">USD {{number_format($comInvMaster->invoice_value,2)}}</td>
	    <td style="font-size: 11px">@if($sci->shipped_on_board_date){{date("d/m/Y", strtotime($sci->shipped_on_board_date))}}@endif</td>
      <td style="font-size: 11px" colspan="2">{{$comInvMaster->exp_no}}</td>
	    <td style="font-size: 11px" colspan="2">USD {{number_format($comInvMaster->realise_value,2)}}<br>@if($sci->proceeds_realization_date){{date("d/m/Y", strtotime($sci->proceeds_realization_date))}}@else{{""}}@endif</td>
  </tr>
	<tr height="47px">
      <td style="font-size: 12px;text-align:left;border-left: hidden;border-right: hidden;font-family: SutonnyMJ" colspan="7">(ißvbx Bbf‡qm, c¨vwKs wjó Ges wej Ae †jwWs/GqviI‡q wej Gi mZ¨vwqZ cvV‡hvM¨ Kwc g~j ißvbxg~j¨ cÖZ¨vevmb mb`cÎ (wcAviwm)<br>`vwLj Kwi‡Z nB‡e| ißvbxK…Z c‡Y¨i g~j¨ I cwigv‡bi mwVKZvi welq Ges ¯^xq cÖwZóv‡b Drcv`b m¤ú‡K© ißvbx Dbœqb ey¨‡iv/mswk­ó<br>G‡mvwm‡qkb cÖ`Ë mb`cÎ `vwLj Kwi‡Z nB‡e)</td>
      <td style="font-size: 15px;border-right: hidden;"></td> 
	</tr>
	<tr height="30px">
      <td style="font-size: 15px; font-weight:bold; text-align:left;border-left: hidden;border-right: hidden;border-top: hidden;font-family: SutonnyMJ" colspan="6" he>(P) fZ’©Kxi Av‡e`bK…Z AsK t </td>
      <td style="font-size:15px; font-weight:bold; text-align:right;border-left: hidden;border-right: hidden;border-top: hidden;font-family: SutonnyMJ" colspan="2">(ˆe‡`wkK gy`ªvq)</td>
    </tr>
  <tr style="border-left: hidden;border-right: hidden;border-top: hidden;">
      <td colspan="8"></td>
   </tr>  
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 15px">cÖZ¨vevwmZ ißvwb g~j¨</span></td>
	  <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 15px">cÖ‡hvR¨ ‡¶‡Î RvnvR fvovi cwigvb</span></td>
	  <td style="font-size: 15px;font-family: SutonnyMJ" colspan="3">ˆe‡`wkK g~`ªvq we‡`‡k cwi‡kva¨ Kwgkb, Bbmy‡iÝ BZ¨vw`</td>
	  <td style="font-size: 15px;font-family: SutonnyMJ">bxU Gd I we ißvwb g~j¨ <br>(১)-(২+৩)</td>
  </tr>
  <tr>
    <td style="font-size: 10px; font-weight:normal; text-align:center;font-family: SutonnyMJ" colspan="2">১</td>
    <td style="font-size: 10px; font-weight:normal; text-align:center;font-family: SutonnyMJ" colspan="2">২</td>
    <td style="font-size: 10px;font-weight: normal;font-family: SutonnyMJ" colspan="3">৩</td>
    <td style="font-size: 10px;font-weight: normal;font-family: SutonnyMJ">৪</td>
  </tr>
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-size: 15px">USD {{number_format($comInvMaster->realise_value,2)}}</span></td>
	  <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="2"><span style="font-weight:normal;font-size: 15px">USD {{number_format($comInvMaster->freight_cost,2)}}</span></td>
	  <td style="font-size: 15px" colspan="3">@if($comInvMaster->insurance){{number_format($comInvMaster->insurance,2)}}@else{{number_format(0,2)}}@endif</td>
	  <td style="font-size: 15px">USD @if($comInvMaster->net_fob){{number_format($comInvMaster->net_fob,2)}}@endif</td>
    </tr>
	<tr height="20px">
      <td style="font-size: 12px; font-weight:bold; text-align:left;border-left: hidden;border-right: hidden;font-family: SutonnyMJ" colspan="7" height="20px;">(cÖ‡hvR¨ †¶‡Î RvnvR fvovi D‡j­L m¤^wjZ †d«BU mvwU©wd‡K‡Ui mZ¨vwqZ Kwc `vwLj Kwi‡Z nB‡e|)</td>
      <td style="font-size:8px;border-right: hidden;"></td>
	</tr>
  <tr>
      <td style="font-size:15px; font-weight:bold; text-align:right;border-left: hidden;border-right: hidden;border-top: hidden;font-family: SutonnyMJ" colspan="8">(ˆe‡`wkK gy`ªvq)</td>
  </tr>
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="3"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 15px">ißvbx cY¨ Drcvw`Z e¨eüZ ¯’vbxq DcKibvw`i g~j¨ N (1) Aby‡”Q‡`i 3bs Kjvg †gvZv‡eK</span></td>
	    <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="3"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 15px">ißvbx Av‡qi g‡a¨ †`kxq DcKibvw` e¨env‡ii kZKiv nvi(৫/৪)<span style="font-family:Times New Roman">X</span>১০০</td>
	    <td style="font-size: 15px;font-family: SutonnyMJ" colspan="2">cÖvc¨ fZ©~wK<br>৪<span style="font-family: Times New Roman">X</span>(২০% বা ৩০%)</td>
  </tr>
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:center;font-family: SutonnyMJ" colspan="3"><span style="font-weight:normal;font-size: 10px;font-family: SutonnyMJ">৫</span></td>
	  <td style="font-size: 15px; font-weight:bold; text-align:center;font-family: SutonnyMJ" colspan="3"><span style="font-weight:normal;font-family: SutonnyMJ;font-size: 10px">৬</span></td>
	  <td style="font-size: 10px;font-family: SutonnyMJ" colspan="2">৭</td>
    </tr>
	<tr>
      <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="3"><span style="font-weight:normal;font-size: 15px">USD {{number_format($comInvMaster->local_material,2)}}</span></td>
	  <td style="font-size: 15px; font-weight:bold; text-align:center" colspan="3"><span style="font-weight:normal;font-size: 15px">{{number_format(($comInvMaster->local_material/$comInvMaster->net_fob)*100,2)}}%</span></td>
	  <td style="font-size: 15px" colspan="2">USD {{number_format($comInvMaster->net_fob*0.2,2)}}</td>
    </tr>
	<tr height="75px">
      <td style="font-size: 15px; font-weight:normal; text-align:left;border-right: hidden;border-left: hidden;font-family: SutonnyMJ" colspan="8">* Ab~¨b 80% ¯’vbxq DcKib e¨eüZ nB‡j 30% Ges 70%¯’vbxq DcKib e¨eüZ nB‡j 20% fZ…ywK cÖvc¨ nB‡e|<br><br><span style="font-size: 15px;font-weight: bold;">GB g‡g© A½xKvi Kiv hvB‡Z‡Q †h, ‡`‡k Drcvw`Z KvuPvgvj kZKiv 80/70 fv‡Mi D‡aŸ© e¨envi Kwiqv ißvwb cY¨ ˆZix Kiv nBqv‡Q hvnv ißvwbi wecix‡Z fZz©Kxi Av‡e`b Kiv nBj| GB Av‡e`bc‡Î cÖ`Ë Z_¨vw` / †NvlYv m¤ú~Y© mwVK| hw` cieZx©‡Z
      Bnv‡Z †Kvb fyj/AmZ¨/cÖZviYv/RvwjqvwZ cÖgvwbZ nq Z‡e M„wnZ fZ©~Kxi mgy`q A_© ev Dnvi Askwe‡kl Avgvi/Avgv‡`i wbKU nB‡Z Avgvi/Avgv‡`i e¨vsK wnmve nB‡Z Av`vq Kwiqv jIqv hvB‡e|</span>
      </td>
	</tr>
  <tr style="border-left: hidden;border-right: hidden;border-top: hidden;">
      <td colspan="8" height="30px"></td>
  </tr> 
	<tr style="border:hidden;">
	  <td style="font-size: 15px;border-right: hidden;font-family: SutonnyMJ">ZvwiL t</td>
	  <td style="font-size: 15px;border-right: hidden;font-family: SutonnyMJ"><?php if($status==1) { ?>{{date("d/m/Y", strtotime($comInvMaster->date))}}<?php }?></td>
	  <td style="font-size: 15px; font-weight:bold;font-family: SutonnyMJ" colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 15px">
      -----------------------------------------------------<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Av‡e`bKvix cÖwZôv‡bi ¯^Z¡vwaKvix/¶gZvcÖvßKg©KZ©vi<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;¯^v¶i I c`we|</span></td>
  </tr>
</table>
<script>document.title = 'F_kha | Report';
  function exportF(elem) {
    var table = document.getElementById("inv");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
    elem.setAttribute("href", url);
    elem.setAttribute("download", "f_kha.xls"); // Choose the file name
    return false;
  }
</script>
</body>
</html>
