<div class="noprint">
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
      <div class="col-md-11" style="width: 1050;margin:0px auto;">
        <table id="inv"  class="table table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <thead>
              <tr>
                <td colspan="12" style="text-align: center;height: 60px;font-size: 20px;position: relative;">
                     <span style="position: absolute;left: 200px;top: 9px;"><img src="{{asset('/logo/dcc.png')}}" width="100px" height="80px"></span>
                     <span style="font-size: 38px">Dhaka City Corporation</span><br>
                     <span style="font-size: 27px">Public Health Laboratory</span><br>
                     <span style="font-size: 20px">Fulbari, Dhaka, Bangladesh.</span>
                </td>
              </tr>
              <tr>
                <td colspan="12" style="text-align: center;height: 60px;font-size: 20px;text-align: left">Memo N. DCC/PHL/Food: {{$sale_contract->dcc_memo_no}}</td>
              </tr>
              <tr>
                  <td colspan="12" style="text-align: center;height: 100px"><span style="font-size: 23px;border-bottom: 3px solid;font-weight: bold;text-transform: uppercase;">Health Certificate</span></td>
              </tr>    
            </thead>
            <tbody>
              <tr>
                  <td colspan="12" style="font-size: 20px">
                    This is to certifiy that {{$sale_contract->company->name}} PRAN RFL CENTEr, 105, MIDDLE BADDA, DHAKA-1212, BANGLADESH, and Produced and exported the following food staff to their importer
                    {{$sale_contract->party_name}}.{{$sale_contract->party_address}},And the INVOICE NO: {{$sale_contract->invoice_no}}. DATE: @if($sale_contract->invoice_date){{date("d-m-Y", strtotime($sale_contract->invoice_date))}}@endif. BL NO: {{$sale_contract->bl_no}}
                  </td>
              </tr>
              <tr>
                <td colspan="12" style="font-size: 15px;height: 20px"></td> 
              </tr>
              <tr style="border: 1px solid">
                 <td style="font-size: 20px;text-align: left;font-weight: bold;border: 1px solid">SL NO</td>
                 <td colspan="7" style="font-size: 20px;text-align: center;font-weight: bold;border: 1px solid">DESCRIPTION OF GOODS</td>
                 <td colspan="2" style="font-size: 20px;font-weight: bold;text-align: center;border: 1px solid;text-transform: uppercase">total<br>Carton IN</td>
                 <td colspan="2" style="font-size: 20px;text-align: center;font-weight: bold;border-top: 1px solid;text-transform: uppercase">gross weight<br>IN (KGS)</td>
              </tr>
              <?php $total_ctn=0; $i=0; $gross_weight_kg_total = 0;$m=1;?>
              @foreach ($sale_contract_details  as $sale_contract_detail)
              <tr style="border: 1px solid">
                 <td style="font-size: 15px;text-align: left;border: 1px solid"><?php echo $nocs_array[$i++]?></td>
                 <td colspan="7" style="font-size: 15px;text-align: left;border: 1px solid">{{$m++}}. {{$sale_contract_detail->desk_item_name}}</td>
                 <td colspan="2" style="font-size: 15px;border: 1px solid;text-align: center;">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                 <td colspan="2" style="font-size: 15px;text-align: center;">{{number_format($sale_contract_detail->gross_weight_kg,2)}} <?php $gross_weight_kg_total+=$sale_contract_detail->gross_weight_kg ;?></td>
              </tr>
              @endforeach
              <tr style="border: 1px solid">
                 <td colspan="8" style="font-size: 15px;text-align: left;font-weight: bold;border: 1px solid">TOTAL</td>
                 <td colspan="2" style="font-size: 15px;border: 1px solid;text-align: center;font-weight: bold">{{round($total_ctn,2)}}</td>
                 <td colspan="2" style="font-size: 15px;font-weight: bold;text-align: center;">{{round($gross_weight_kg_total,2)}}</td>
              </tr>
              <tr>
                <td colspan="12" style="font-size: 15px;height: 20px"></td> 
              </tr>
              <tr>
                <td colspan="12" style="font-size: 20px">
                   The is to certify that the Chemical analysis and Microbiological examinations where performed with the supplied samples of the above items and confirmed that the above items ae free from poisonous contaminates and human health hazard. Accordint to the laboratory text, we can assure that these products are <span style="font-size: 22px;text-transform:uppercase;font-weight: bold">"fit for human consumptions"</span>.
                </td>
              </tr>
              <tr>
                <td colspan="12" style="font-size: 15px;height: 20px"></td> 
              </tr>
              <tr>
                <td colspan="12" style="font-size: 15px;height: 60px"></td> 
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
    