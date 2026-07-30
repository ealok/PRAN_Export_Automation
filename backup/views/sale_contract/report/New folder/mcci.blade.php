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
@media print {
    .row {
        clear: both;
        page-break-after: always;
    }
    .noprint {display:none;}
}
    
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

#under{
   
   border-bottom: 2px solid;
}

 <?php $total_amount = 0;?>
  @foreach ($sale_contract_details as $sale_contract_detail)
     <?php $total_amount+=$sale_contract_detail->total_amount ;?>
  @endforeach                    

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
  <tr style="height:121px;border-top:hidden; border-left:hidden; border-right: hidden">
     <td colspan="8"></td>
  </tr>
  <br>
  <tr style="border-bottom:hidden; border-left:hidden; border-right:hidden;border-top: hidden;">
     <td style="font-size:11px; border-right: hidden;">1-{{$noce_value}}</td>
     <td colspan="2" style="font-size:11px; border-right:hidden"> {{$all_sum->all_ctn_qty}} Cartons</td>
     <td colspan="2" style="font-size:11px;border-right:hidden">{{$sale_contract->revise_product_name}}</td>
     <td colspan="2" style="font-size:11px;border-right:hidden"><br>&nbsp;&nbsp;&nbsp;&nbsp;NET WT {{$all_sum->total_net_weight_kg}} KGS<br>&nbsp;&nbsp;&nbsp;&nbsp;GRS WT {{ $all_sum->total_gross_weight_kg}} KGS</td>
     <td style="font-size:11px;border-right:hidden">@if($sale_contract->is_total_amount_oceania)${{$total_amount_with_freight}}@else{{""}}@endif</td>
  </tr>
  <tr style="border:hidden">
     <td colspan="8" style="text-align:left; height:50px"><span style="border-bottom:1px solid; font-weight:bold;font-size: 12px;margin-left: 56px">DECLARATION:</span><p><span style="font-size: 10px;margin-left: 80px">WE HEREBY, DECLARE THAT DESCRIPTION OF GOODS, QUALITY, QUANTITY, PRICE, NET & GROSS WEIGHT</span><br><span style="font-size: 10px;margin-left: 80px">UNDER THE SALES CONTRACT NO: {{$sale_contract->sales_contract_no}} DATE: {{date('d-m-Y',strtotime($sale_contract->dated))}}(COPY OF SALES CONTRACT,</span><br><span style="font-size: 10px;margin-left: 80px">COMMERCIAL INVOICE, PACKING LIST AND BILL OF LADING ARE ENCLOSED FOR INFORMATION AND RECORD)</span><br><br>
      <span style="font-weight:bold;margin-left: 150px;font-size: 10px;margin-top: -20px">SALES CONTRACT NO : {{$sale_contract->sales_contract_no}}</span><br>
      <span style="font-weight:bold;margin-left: 150px;font-size: 10px;margin-top: -20px">DATE: {{date('d-m-Y',strtotime($sale_contract->dated))}}</span><br>
      <span style="font-weight:bold;margin-left: 150px;font-size: 10px;margin-top: -20px">INVOICE NO: {{$sale_contract->invoice_no}}</span><br>
      <span style="font-weight:bold;margin-left: 150px;font-size: 10px;margin-top: -20px">DATE:@if(!empty($sale_contract->invoice_date)){{date('d-m-Y',strtotime($sale_contract->invoice_date))}}@endif</span><br>
      <span style="font-weight:bold;margin-left: 150px;font-size: 10px;margin-top: -20px">B/L NO:{{$sale_contract->bl_no}}</span><br>
      <span style="font-weight:bold;margin-left: 150px;font-size: 10px;margin-top: -20px">Date: @if($sale_contract->bl_date){{date('d-m-Y',strtotime($sale_contract->bl_date))}}@endif</span>
      <br><br><br><br><br><br><br><br>
      <p></p>
     </td>
  </tr>
  <tr style="border-left:hidden;border-bottom:hidden;border-right:hidden;position: relative;">
     <td colspan="8" style="text-align:left">
        <span style="margin-left: 378px;font-size: 11px;position: absolute;margin-top: 20px">{{$sale_contract->discharge_port}}</span> 
      <br>
     <span style="font-size: 11px;margin-left: 167px;position: absolute;margin-top: 20px">{{$sale_contract->loading_place->name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$sale_contract->vehicle}}</span>
     <br>
     <span style="font-size: 11px;margin-left: 300px;position: absolute;margin-top: 20px">@if($sale_contract->bl_date){{date('d-m-Y',strtotime($sale_contract->bl_date))}}@endif{{""}}</span>
     </td>
  </tr>
</table> 
</body>
<script>document.title = 'MCCI Report';
  function exportF(elem) {
    var table = document.getElementById("inv");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
    elem.setAttribute("href", url);
    elem.setAttribute("download", "MCI_report_download.xls"); // Choose the file name
    return false;
  }
</script>
</html>


