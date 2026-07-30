<div class="noprint" style="margin-bottom: 100px">
    <section class="content-header noprint" style="padding-top: 0px;">
        <h1 style=" font-size: 30px;">
        <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
        <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
    </section>
    </div>
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
    <div class="row">
      <br>
      <div class="date" style="position: relative">
           <span style="position: absolute;top: 70px;left: 66px;font-size: 22px;  font-weight: bold;"></span>
      </div>
      <div class="col-md-11" style="width: 1050;margin:0px auto;margin-top: 100px">
        <table id="inv"  class="table table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <thead>
              <tr>
                  <td colspan="12" style="text-align: center;height: 60px"><span style="font-size: 37px;font-weight:bold;text-transform: uppercase">To Whom It May Concern</span><br><span style="font-size: 31px">(Physical Verification Certificate)</span><br><span style="font-size: 25px;font-weight:bold">(FE CIRCULAR No-05, Date:18/04/2022)</span></td>
              </tr>    
            </thead>
            <tbody>
              <tr>
                <td colspan="12" style="font-size: 22px;height: 80px"></td> 
              </tr>
              <tr style="border: hidden">
                 <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:28px">Name of Sector : Agro and Agro Processing Sector.</span></td>
              </tr>
              <tr>
                <td colspan="12" style="font-size: 22px;height: 20px"></td> 
              </tr>
              <tr style="border: hidden">
                <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:25px;font-weight:bold">Name of Exporter: </span><span style="font-size: 19px;font-weight: normal">{{$sale_contract->company->name}}</span></td>
             </tr>
             <tr style="border: hidden">
                <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:25px;font-weight:bold">Name of Importer:</span> <span style="font-size: 19px">@if($sale_contract->importer->name=="N/A"){{$sale_contract->notify_pary->name}}@else{{$sale_contract->importer->name}}@endif</span></td>
             </tr>
             <tr style="border: hidden">
                <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:25px;font-weight:bold">Sales Contract Number:</span> <span style="font-size: 19px">{{$sale_contract->sales_contract_no}}</span></td>
             </tr>

             <tr style="border: hidden">
                <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:25px;font-weight:bold">Sales Contract Date:</span> <span style="font-size: 19px">{{$sale_contract->dated}}</span></td>
             </tr>
             <tr style="border: hidden">
                <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:25px;font-weight:bold">Exp Number:</span> <span style="font-size: 19px">{{$sale_contract->export_no}}</span></td>
             </tr>
             <tr style="border: hidden">
                <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:25px;font-weight:bold">Exp Date:</span> <span style="font-size: 19px">{{$sale_contract->export_date}}</span></td>
             </tr>
             <tr style="border: hidden">
                <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:25px;font-weight:bold">Invoice Number:</span> <span style="font-size: 19px">{{$sale_contract->invoice_no}}</span></td>
             </tr>
             <tr style="border: hidden">
                <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:25px;font-weight:bold">Invoice Date:</span> <span style="font-size: 19px">{{$sale_contract->invoice_date}}</span></td>
             </tr>
             @if($sale_contract->bl_no)
             <tr style="border: hidden">
               <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:25px;font-weight:bold">BL Number:</span> <span style="font-size: 19px">{{$sale_contract->bl_no}}</span></td>
             </tr>
             @endif
             @if($sale_contract->bl_date_cer)
             <tr style="border: hidden">
               <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:25px;font-weight:bold">BL Date:</span> <span style="font-size: 19px">@if($sale_contract->bl_date_cer){{date('d-m-Y', strtotime($sale_contract->bl_date_cer))}}@endif</span></td>
             </tr>
             @endif
             <tr>
                <td colspan="12" style="font-size: 22px;height: 50px"></td> 
              </tr>
              <tr style="border: hidden">
                <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:28px">This is to certify that the above mention information are correct and all exported</span></td>                
             </tr>
             @if(!$sale_contract->is_proforma_invoice)
             <tr style="border: hidden">
               <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:28px">goods are Physical Verified and got as same as with Invoice, Exp and Packing List.</span></td>
             </tr> 
             @endif
             @if($sale_contract->is_proforma_invoice)
             <tr style="border: hidden">
               <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:28px">goods are Partially Physical Verified and got as same as with Invoice, Exp and</span></td>
             </tr> 
             <tr style="border: hidden">
               <td colspan="8" style="font-size: 22px;"><span style="margin-left: 70px;font-size:28px">Packing List.</span></td>
             </tr>
             @endif
             <tr>
                <td colspan="12" style="font-size: 22px;height: 120px"></td> 
             </tr>
             <tr style="border: hidden">
                <td colspan="8" style="font-size: 30px;"><span style="margin-left: 500px;font-size:30px">Signature of Custom Officer<br><span style="margin-left: 595px;font-size: 28px;">with Seal.</span></span></td>
             </tr>
            </tbody>
         </table>
      </div> 
    </div>
    <script>document.title = 'Custom Cer';
    function exportF(elem) {
      var table = document.getElementById("inv");
      var html = table.outerHTML;
      var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
      elem.setAttribute("href", url);
      elem.setAttribute("download", "custom_cer{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
      return false;
    }
    </script>
    
    
    
    
    