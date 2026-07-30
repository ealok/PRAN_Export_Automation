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
  <tr>
    <td style="font-size:14px; font-weight:bold; text-align:left;text-align: center;" colspan="9">Annexure 'D'</td>
  </tr>
  <tr>
    <td style="font-size:12px; font-weight:bold; text-align:center;" colspan="5">{{$sale_contract->invoice_no}}</td>
    <td style="font-size:12px;font-weight: bold;" colspan="2">@if(!empty($sale_contract->invoice_date)){{date("d-m-Y", strtotime($sale_contract->invoice_date))}}@endif</td>
    <td style="font-size:12px;font-weight: bold;"></td>
  </tr>  
  <tr>
    <td style="font-size:12px; font-weight:bold; text-align:center;" colspan="5">Supplier Name & Address</td>
    <td style="font-size:12px;font-weight: bold;" colspan="2">Raw Materials Name</td>
    <td style="font-size:12px;font-weight: bold;">Quantity(kgs/Ltr)</td>
    <td style="font-size:12px;font-weight: bold;">Value(USD)</td>
  </tr>
  @foreach($results as $result)
  <tr>
    <td style="font-size:10px; font-weight:bold; text-align:left;" colspan="5">{{$result->source_address}}</td>
    <td style="font-size:10px" colspan="2">{{$result->raw_material}}</td>
    <td style="font-size:10px">{{number_format($result->quantity,3)}}</td>
    <td style="font-size:10px">{{number_format($result->value,3)}}</td>
  </tr>
  @endforeach
  <tr>
    <td style="font-size:12px; font-weight:bold; text-align:center;" colspan="8">TOTAL VALUE</td>
    <td style="font-size:12px;font-weight: bold;">{{$imported_material_as_per_kha}}</td>
  </tr>
</table>
<script>document.title = 'Annexure 'D' | Report';</script>
<script>
  function exportF(elem) {
    var table = document.getElementById("inv");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
    elem.setAttribute("href", url);
    elem.setAttribute("download", "Annexure_d.xls"); // Choose the file name
    return false;
  }
</script>
</body>
</html>
