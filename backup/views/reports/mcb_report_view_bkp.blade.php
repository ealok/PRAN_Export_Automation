<!-- <link rel="stylesheet" href="{{asset('admin_template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}"> -->

<style>

/* *{
    font-size: 9px;
} */

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

<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">MCB REPORT
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
</section>
</div>


<div class="row">

     <div class="col-md-12">
     <h4 style="text-align:center;">MCB REPORT</h4>
     <p style="text-align:center;">From: {{$dateFrom}} To: {{$dateTo}}</p>
     <table class="table table-bordered table-responsive table-condenced ">
              <thead>
                  <th>Sale contract</th>
                  <th>Ad code</th>
                  <th>Exp submit date</th>
                  <th>Status</th>
                  <th>Office file ref no</th>
                  <th>Last date for lodging claim</th>
                  <th>Non eligible item total</th>
                  <th>Proceeds realization date</th>
                  <th>Amount of proceed realized</th>
                  <th>Short realized</th>
                  <th>Prc issue date</th>
                  <th>Bapa application submit date</th>
                  <th>Bapa certificate date</th>
                  <th>Claim submission date</th>
                  <th>Claim amount usd</th>
                  <th>Audit report date</th>
                  <th>Auditted amount</th>
                  <th>Exchange rate</th>
                  <th>Auditted amount tk</th>
                  <th>Subsidy rece date 100 perc</th>
                  <th>Shipped on board date</th>
                  <th>Bl date</th>
                  <th>Challan date</th>
              </thead>
              <tbody>
                @foreach ($scis as $sci)
                  <tr>
                      <td>{{$sci->sales_contract_no}}</td>
                      <td>{{$sci->ad_code}}</td>
                      <td>{{date("d-m-Y",strtotime( $sci->exp_submit_date))}}</td>
                      <td>{{$sci->status}}</td>
                      <td>{{$sci->office_file_ref_no}}</td>
                      <td>{{date("d-m-Y",strtotime( $sci->last_date_for_lodging_claim))}}</td>
                      <td>{{$sci->non_eligible_item_total}}</td>
                      <td>{{date("d-m-Y",strtotime( $sci->proceeds_realization_date))}}</td>
                      <td>{{$sci->amount_of_proceed_realized}}</td>
                      <td>{{$sci->short_realized}}</td>
                      <td>{{date("d-m-Y",strtotime( $sci->prc_issue_date))}}</td>
                      <td>{{date("d-m-Y",strtotime( $sci->bapa_application_submit_date))}}</td>
                      <td>{{date("d-m-Y",strtotime( $sci->bapa_certificate_date))}}</td>
                      <td>{{date("d-m-Y",strtotime( $sci->claim_submission_date))}}</td>
                      <td>{{$sci->claim_amount_usd}}</td>
                      <td>{{date("d-m-Y",strtotime( $sci->audit_report_date))}}</td>
                      <td>{{$sci->auditted_amount}}</td>
                      <td>{{$sci->exchange_rate}}</td>
                      <td>{{$sci->auditted_amount_tk}}</td>
                      <td>{{$sci->subsidy_rece_date_100_perc}}</td>
                      <td>{{date("d-m-Y",strtotime( $sci->shipped_on_board_date))}}</td>
                      <td>{{date("d-m-Y",strtotime( $sci->bl_date))}}</td>
                      <td>{{date("d-m-Y",strtotime( $sci->challan_date))}}</td>             
                  </tr>
                @endforeach  
              </tbody>
          </table>  
      
      </div> <!-- col-md-12 end -->
</div> 


<script>document.title = 'mcb report';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "mcb_report.xls"); // Choose the file name
  return false;
}


</script>





