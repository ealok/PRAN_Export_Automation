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
  <div class="col-md-11" style="width: 1050;margin:0px auto;margin-top: 100px">
    <table id="inv"  class="table table-responsive table-condensed" style="margin:0 auto; width:100%;">
        <thead>
          <tr>
              <td colspan="12" style="text-align: center;height: 60px"><span style="font-size: 35px;border-bottom: 3px solid">Health Certificate</span></td>
          </tr>    
        </thead>
        <tbody>
          <tr>
              <td colspan="12" style="font-size: 19px">
                I, the Scientific Officer hereby declare that the following consignment for {{$sale_contract->party_name}} {{$sale_contract->party_address}}, PROFORMA INVOICE NO: {{$sale_contract->sales_contract_no}} DATE:@if(!empty($sale_contract->dated)){{date("d-m-Y",strtotime( $sale_contract->dated))}}@endif, containing the following products:
              </td>
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px;height: 20px"></td> 
          </tr>
          <tr style="border: 1px solid">
             <td colspan="8" style="font-size: 19px;text-align: center;font-weight: bold;border: 1px solid">DESCRIPTION OF GOODS</td>
             <td colspan="2" style="font-size: 19px;font-weight: bold;text-align: center;border: 1px solid">PIECES IN CTN/BAG</td>
             <td colspan="2" style="font-size: 19px;text-align: center;font-weight: bold;">TOTAL CTN/BAG</td>
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
                The above products have been producing in a hygienic way and the packing materials were supplied by our registered suppliers and also these packing materials are free from any types of toxic matter.
            </td>
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px;height: 20px"></td> 
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px">
              I, the Scientific Officer, hereby declare that the above products information are correct and documented and also I assured that these products are fit for human consumption.
            </td> 
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px;height: 90px"></td> 
          </tr>
          <tr>
            <td colspan="12" style="font-size: 19px">Signature & Seal of Scientific Officer<br>Dated:</td> 
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




