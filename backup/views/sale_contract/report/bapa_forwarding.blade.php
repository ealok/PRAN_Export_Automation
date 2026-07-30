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
	<tr style="border:hidden;">
	   <td colspan='6' style=
     'font-size:18px;font-weight: bold;font-family: SutonnyMJ;'>evsjv‡`k G‡MÖv-cÖ‡mmim& G‡mvwm‡qkb (evcv)</td>
	</tr>
    <tr style="border:none">
	   <td colspan='6' style=
	   'font-size:18px;font-weight: bold;border-left: hidden;border-right: hidden;font-family: SutonnyMJ;'>ißvbxi wecix‡Z fZz©Kxi mb`cÎ MÖn‡bi Rb¨ cÖ`Ë Z_¨ I KvMRcÎ hvPvB ZvwjKv</td>
	</tr>
  <tr style="border:hidden;height: 15px"></tr>
    <tr style="border:hidden;">
	   <td colspan='3' style="font-size: 13px;text-align: left;border-right: hidden;font-family: SutonnyMJ;">ißvbxKvi‡Ki bvg t : <span style="font-size: 13px;font-family:Times New Roman;"> {{$company->name}}</span> 
</td>
	   <td colspan="3" style="font-size: 13px;font-family: SutonnyMJ;">m`m¨ bs: <span style="font-size:15px;font-family: Times New Roman">{{$company->membership_number}}</span></td>
	</tr>
    <tr style="border:none">
	   <td colspan='3' style="font-size: 13px;border-left: hidden;border-right: hidden;text-align: left;font-family: SutonnyMJ;">ißvbx FYcÎ/Pzw³cÎ Gi b¤^it: <span style="font-size: 14px;font-family: Times New Roman;">@if($sci->lc_number){{$sci->lc_number}}@else{{$comInvMaster->sc_no}}@endif</span></td>
	   <td style="font-size: 13px;font-family: SutonnyMJ;">ZvwiLt: <span style="font-size: 14px;font-family: Times New Roman">@if($sci->lc_date){{$sci->lc_date}}@else{{date('d/m/Y',strtotime($comInvMaster->sc_date))}}@endif</span></td>
	   <td style="font-size: 13px;border-right: hidden;border-left: hidden;font-family: SutonnyMJ">g~j¨gvbt: <span style="font-family: Times New Roman;font-size: 13px">$@if($sci->lc_number){{$sci->lc_value}}@else{{$comInvMaster->sc_value}}@endif</span></td>
     <td style="font-size: 13px;border-right: hidden;"></td>
	</tr>
  <tr style="border-left:hidden;border-right: hidden;border-top: hidden; height: 15px"></tr>
  <tr>
      <td rowspan="2" style="font-size: 13px;font-family: SutonnyMJ;">µwgK bs</td>
      <td colspan="2" rowspan="2" style="font-size: 13px;font-family: SutonnyMJ;">weeib</td>
      <td colspan="2" style="font-size: 13px;font-family: SutonnyMJ;">ißvbxKviK KZ…©K cyibxq</td>
      <td rowspan="2" style="font-size: 13px;font-family: SutonnyMJ;">hvPvBKvixi gšÍe¨</td>
  </tr>
   <tr>
      <td style="font-size: 13px;font-family: SutonnyMJ;">nuv</td>
      <td style="font-size: 13px;font-family: SutonnyMJ;">bv</td>
  </tr>
  <tr>
      <td scope="row" data-label="Account" style="font-size: 13px">১</td>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">ißvYxKvi‡Ki ißvbx m¤úbœ fZz©Kx Av‡e`bK…Z cY¨ ev cY¨ mgy‡ni Drcv`b Pvjyy Av‡Q wKbv</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
  <tr>
      <td scope="row" data-label="Account" style="font-size: 13px">২</td>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">fZz©Kxi Rb¨ Av‡e`bK…Z cb¨ mgyn ißvbxi †ÿ‡Î D³ cY¨ ev cY¨ mgy‡ni Drcv`b, DcKi‡bi gRy` I c¨v‡KwRs cÖwµqv evcv‡K †`Lv‡bv n‡q‡Q wKbv</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
  <tr>
      <td scope="row" data-label="Account" style="font-size: 13px">৩</td>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">evcv cÖ`Ë ÒBbdi‡gkb kxUÓ -G BÛvwóª/d¨v±ix-‡Z cY¨ cÖwµqvRvZKiY msµvšÍ Z_¨ cÖ`vb Kiv n‡q‡Q wKbv</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
  <tr>
      <td scope="row" data-label="Account" style="font-size: 13px">৪</td>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;font-weight: bold" colspan="2">ißvbx msµvšÍ bw_, h_v t :</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
   <tr>
      <td scope="row" data-label="Account" style="font-size: 13px" rowspan="10"></td>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">K. ißvbx FYcÎ/Pzw³cÎ</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
   <tr>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">L. Kgvwm©qvj Bbf‡qm</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
   <tr>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">M. c¨vwKs wj÷</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
   <tr>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">N. wUwU Kwc</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
   <tr>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">O. wej Ad G·‡cvU©</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
  <tr>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">P. BG·wc</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
  <tr>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">Q. wej Ad j¨vwWs</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
  <tr>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">R. ‡d«BU Bbf‡qm</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
  <tr>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">S. Ab jvB‡b weGj UªvwKs n‡q‡Q wKbv (hvPvB Kvixi Rb¨)</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
  <tr>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">Dc‡iv³ bw_ mg~n wWjvi e¨vsK KZ©„K mZ¨vwqZ Kwc mieivn Kiv n‡q‡Q wKbv</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
  <tr>
      <td scope="row" data-label="Account" style="font-size: 13px">৫</td>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">Kgvwm©qvj Bbf‡qm, c¨vwKs wj÷ I BG·wc Kwc Kv÷gm& KZ…©cÿ KZ…©K ¯^vÿi I wmj †gvniK…Z wKbv</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" height="20px" alt="no"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
  <tr>
      <td scope="row" data-label="Account" style="font-size: 13px">৬</td>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">evcv cÖ`Ë ÔQKÕ-G c‡Y¨ e¨eüZ ¯’vbxq c‡Y¨i nvi msµvšÍ Z_¨ cÖ`vb Kiv n‡q‡Q wKbv</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
  <tr>
      <td scope="row" data-label="Account" style="font-size: 13px">৭</td>
      <td data-label="Due Date" style="font-size: 13px;text-align:left;font-family: SutonnyMJ;" colspan="2">evsjv‡`k e¨vs‡Ki Gd.B 15 bs mvKz©jv‡ii mv‡_ mshy³ ÔPÕ di‡gi 6 bs Kjvg †gvZv‡eK cÖwZwU c‡Y¨i DcKiY wfwËK cwigvY I g~j¨ Ges DcKiY mieivnKvixi wVKvbv  (†dvb bs mn) `vwLj Kiv n‡q‡Q wKbv| DcKiY mg~n µ‡qi iwm`/‡g‡gv evcvÕi Pvwn`v Abyhvqx `wjjvw` msiÿb Kiv n‡q‡Q wKbv</td>
      <td data-label="Amount"><img src="{{asset('img/tik.png')}}" alt="no" height="20px"></td>
      <td data-label="Period"></td>
      <td data-label="Period"></td>
  </tr>
  <tr style="border-left:hidden;border-right:hidden;border-bottom:hidden;height: 60px"></tr>
  <tr style="border:none">
     <td colspan='3' style="font-size: 18px;border-left: hidden;border-right: hidden;border-bottom: hidden;font-family: SutonnyMJ;font-weight: bold;"><br><br>ißvbxKvi‡Ki ¯^vÿi I ZvwiL</td>
     <td colspan="3" style="font-size: 18px;border-right: hidden;border-bottom: hidden;font-family: SutonnyMJ;font-weight: bold;"><br><br>Z_¨ hvPvBKvixi ¯^vÿi I ZvwiL</td>
  </tr>
</table>
<script>document.title = 'Bapa Farwarding | Report';
  function exportF(elem) {
    var table = document.getElementById("inv");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
    elem.setAttribute("href", url);
    elem.setAttribute("download", "Bapa_forwarding.xls"); // Choose the file name
    return false;
  }
</script>
</body>
</html>
