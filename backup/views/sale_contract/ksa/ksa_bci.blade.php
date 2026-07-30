<div class="noprint">
    <section class="content-header noprint" style="padding-top: 0px;">
        <h1 style=" font-size: 30px;">
        <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
        <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
    </section>
    </div>
    <style>
    
    @media print {
        .row {
            clear: both;
            page-break-after: always;
        }
        .noprint {display:none;}
    }
      
    
    *{
        font-size: 9px;
    }
    
    table {
      border-collapse: collapse;
    }
    table, th, td {
      border: 1px solid black;
    }
    
    
    @media print {
        .row {
            clear: both;
            page-break-after: always;
        }
        .noprint {display:none;}
    }
    </style>
    <div class="row">
    <br>
    <br>

   
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

    <?php $total_pcs_in_ctn = 0; $total_ctn = 0; $total_sum = 0;?>
    @foreach ($sale_contract_details as $sale_contract_detail)
      <?php 
        try { 
              

            $total_sum+=$sale_contract_detail->ci_item_rate*$sale_contract_detail->ctn;


        }catch (Exception $e) {
        
        }          
      ?>
    @endforeach
       </style>
      <table style="margin-top: 40px">
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
         <td style="font-size:11px;border-right:hidden">${{number_format($total_sum,2)}}</td>
      </tr>
      <tr style="border:hidden">
         <td colspan="8" style="text-align:left; height:50px"><span style="border-bottom:1px solid; font-weight:bold;font-size: 12px;margin-left: 56px">DECLARATION:</span><p><span style="font-size: 10px;margin-left: 100px">WE HEREBY, DECLARE THAT DESCRIPTIO OF GOODS, QUALITY, QUANTITY. PRICE NET & GROSS WEIGHT ARE IN</span><br><span style="font-size: 10px;margin-left: 100px">ACCORDANCE WITH SALES CONTRACT NO : {{$sale_contract->sales_contract_no}} DATE: {{date('d-m-Y',strtotime($sale_contract->dated))}}(COPY OF SALES CONTRACT,</span><br><span style="font-size: 10px;margin-left: 100px">COMMERCIAL INVOICE, PACKING LIST AND BILL OF LADING ARE ENCLOSED FOR INFORMATION AND RECORD)</span><br><br>
          <span style="font-weight:bold;margin-left: 150px;font-size: 10px;margin-top: -20px">SALES CONTRACT NO : {{$sale_contract->sales_contract_no}}</span><br>
          <span style="font-weight:bold;margin-left: 150px;font-size: 10px;margin-top: -20px">DATE: {{date('d-m-Y',strtotime($sale_contract->dated))}}</span><br>
          <span style="font-weight:bold;margin-left: 150px;font-size: 10px;margin-top: -20px">INVOICE NO: {{$sale_contract->invoice_no}}</span><br>
          <span style="font-weight:bold;margin-left: 150px;font-size: 10px;margin-top: -20px">DATE: {{date('d-m-Y',strtotime($sale_contract->invoice_date))}}</span><br>
          <span style="font-weight:bold;margin-left: 150px;font-size: 10px;margin-top: -20px">B/L NO:{{$sale_contract->bl_no}}</span><br>
          <span style="font-weight:bold;margin-left: 150px;font-size: 10px;margin-top: -20px">Date: @if($sale_contract->bl_date){{date('d-m-Y',strtotime($sale_contract->bl_date))}}@endif</span>
          <br><br><br><br><br><br><br><br>
          <br><br><br><br><br><br><br><br><br><br>
          <p></p>
         </td>
      </tr>
      <tr style="border-left:hidden;border-bottom:hidden;border-right:hidden;position: relative;">
         <td colspan="8" style="text-align:left">
            <span style="margin-left: 360px;font-size: 11px;position: absolute;margin-top: 20px">{{$sale_contract->discharge_port}}</span> 
          <br><br> 
         <span style="font-size: 11px;margin-left: 120px;position: absolute;margin-top: 18px">{{$sale_contract->loading_place->name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$sale_contract->vehicle}}</span>
         <br><br>
         <span style="font-size: 11px;margin-left: 300px;position: absolute;margin-top: 9px">@if($sale_contract->bl_date){{date('d-m-Y',strtotime($sale_contract->bl_date))}}@endif{{""}}</span>
         </td>
      </tr>
    </table> 
    
    <script>document.title = 'BCI';
    function exportF(elem) {
      var table = document.getElementById("inv");
      var html = table.outerHTML;
      var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
      elem.setAttribute("href", url);
      elem.setAttribute("download", "Noc_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
      return false;
    }
    </script>
    