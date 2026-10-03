<div class="noprint" style="margin-bottom: 100px">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <a href="{{url('/sale_contract/'.$sale_contract->id)}}/health_certificate_phl_pad"><button style="float:right; font-size: 30px; margin-left:10px;">PAD</button></a>
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
  <div class="col-md-11" style="width: 1050;margin:0px auto;margin-top: 100px">
    <table id="inv"  class="table table-responsive table-condensed" style="margin:0 auto; width:100%;">
        <thead>
          <tr>
              <td colspan="12" style="text-align: center;height: 60px">
                <div style="text-align: center; margin-bottom: 20px;">
                      <div style="font-size: 28px; font-weight: bold; text-transform: uppercase; letter-spacing: 3px; border-bottom: 3px solid #000;display: inline-block;">
                          HEALTH & FREE SALE CERTIFICATE
                      </div>
                      <br>
                      <div style="color: #555; margin-top: 5px;font-size: 22px;">(For Export Products Only)</div>
                  </div>
              </td>
          </tr>    
        </thead>
        <tbody>
          <tr>
              <td colspan="12" style="font-size: 19px">
                This is to certify that the Following Products to be exported to Philippines are produced by <span style="font-size: 14px;font-weight: bold;">{{$sale_contract->company->name}}</span>The sister concerns of PRAN-RFL Group, PRAN-RFL Center, 105, Middle Badda, Dhaka-1212, Bangladesh. 
              </td>
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px;height: 20px"></td> 
          </tr>
          <tr style="border: 1px solid">
             <td colspan="8" style="font-size: 19px;text-align: center;font-weight: bold;border: 1px solid">PRODUCT NAME</td>
             <td colspan="2" style="font-size: 19px;font-weight: bold;text-align: center;border: 1px solid">SIZE gm/ml</td>
             <td colspan="2" style="font-size: 19px;text-align: center;font-weight: bold;">TOTAL CARTON</td>
          </tr>
          <?php $total_ctn=0; ?>
          @foreach ($sale_contract_details  as $sale_contract_detail)
          <tr style="border: 1px solid">
             <td colspan="8" style="font-size: 17px;text-align: left;border: 1px solid">{{$sale_contract_detail->desk_item_name}}</td>
             <td colspan="2" style="font-size: 17px;border: 1px solid;text-align: center;">{{$sale_contract_detail->ci_item->ci_factor}}</td>
             <td colspan="2" style="font-size: 17px;text-align: center;">{{$sale_contract_detail->ctn}}</td>
             <?php $total_ctn+=$sale_contract_detail->ctn ;?>
          </tr>
          @endforeach
          <tr style="border: 1px solid">
             <td colspan="8" style="font-size: 19px;text-align: center;font-weight: bold;border: 1px solid">TOTAL</td>
             <td colspan="2" style="font-size: 19px;border: 1px solid"></td>
             <td colspan="2" style="font-size: 19px;font-weight: bold;text-align: center;">{{$total_ctn}}</td>
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px;height: 20px"></td> 
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px">
                These products have been manufactured in a fully automatic processing system and maintains HACCP & GMP in our whole processing system to obtain a standard process food which is suitable for human consumption.
            </td>
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px;height: 20px"></td> 
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px;font-weight: bold;">
              So, these products can be freely sold throughout over Bangladesh and in Abroad at Whole sales, Street vendors, Super market and traditional market as healthy food products.
            </td> 
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px;height: 90px"></td> 
          </tr>
          <tr>
              <td colspan="12" style="padding: 10px 30px 10px 0; text-align: right;">
                  <div style="display: flex; align-items: center; justify-content: flex-end; gap: 15px;">
                      <div style="font-size: 18px; font-weight: bold;">
                          Seal & Signature 
                      </div>
                  </div>
              </td>
          </tr>
        </tbody>
     </table>
  </div> 
</div>
<script>document.title = 'Health | Certificate';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "Noc_report_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script>




