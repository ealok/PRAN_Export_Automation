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
    <h1 style="font-size: 30px;">MCB REPORT
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
                  <th>Id</th>
                  <th>Sale contract</th>
                  <th>Ad code</th>
                  
                  <th>EXP NO</th>
                  <th>EXP date</th>
                  <th>Invoice No</th>
                  <th>Invoice Date</th>
                  <th>Exp Amount</th>

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
                  <th>Subsidy rece date 70 perc</th>
                  <th>Subsidy rece date 30 perc</th>
                  <th>Shipped on board date</th>
                  <th>Bl date</th>
                  <th>Challan date</th>
                  <th>Challan no</th>
                  <th>Shipping bill no</th>
                  <th>Shipping bill date</th>
                  <th>Lc date</th>
                  <th>Bb prc date</th>
                  <th>Country of importer</th>
              </thead>
              <tbody>
                @foreach ($scis as $sci)
                  <tr>
                      <td>{{$sci->id}}</td>
                      <td>{{$sci->sales_contract_no}}</td>
                      <td>{{$sci->ad_code}}</td>
                      <td>{{$sci->export_no}}</td>
                      <td>@if($sci->export_date){{date("d-m-Y",strtotime( $sci->export_date))}}@endif</td>
                      <td>{{$sci->invoice_no}}</td>
                      <td>@if($sci->invoice_date){{date("d-m-Y",strtotime( $sci->invoice_date))}}@endif</td>
                      <td>Exp Amount</td>
                      <td>@if($sci->exp_submit_date){{date("d-m-Y",strtotime( $sci->exp_submit_date))}}@endif</td>
                      <td>{{$sci->status}}</td>
                      <td>{{$sci->office_file_ref_no}}</td>
                      <td>@if($sci->last_date_for_lodging_claim){{date("d-m-Y",strtotime( $sci->last_date_for_lodging_claim))}}@endif</td>
                      <td>{{$sci->non_eligible_item_total}}</td>
                      <td>@if( $sci->proceeds_realization_date){{date("d-m-Y",strtotime( $sci->proceeds_realization_date))}}@endif</td>
                      <td>{{$sci->amount_of_proceed_realized}}</td>
                      <td>{{$sci->short_realized}}</td>
                      <td>@if($sci->prc_issue_date){{date("d-m-Y",strtotime( $sci->prc_issue_date))}} @endif</td>
                      <td>@if($sci->bapa_application_submit_date){{date("d-m-Y",strtotime( $sci->bapa_application_submit_date))}} @endif</td>
                      <td>@if($sci->bapa_certificate_date){{date("d-m-Y",strtotime( $sci->bapa_certificate_date))}} @endif</td>
                      <td>@if($sci->claim_submission_date){{date("d-m-Y",strtotime( $sci->claim_submission_date))}} @endif</td>
                      <td>{{$sci->claim_amount_usd}}</td>
                      <td>@if($sci->audit_report_date){{date("d-m-Y",strtotime( $sci->audit_report_date))}}@endif</td>
                      <td>{{$sci->auditted_amount}}</td>
                      <td>{{$sci->exchange_rate}}</td>
                      <td>{{$sci->auditted_amount_tk}}</td>
                      <td>@if($sci->subsidy_rece_date_100_perc){{$sci->subsidy_rece_date_100_perc}}@endif</td>
                      <td>@if($sci->subsidy_rece_date_70_perc){{$sci->subsidy_rece_date_70_perc}}@endif</td>
                      <td>@if($sci->subsidy_rece_date_30_perc){{$sci->subsidy_rece_date_30_perc}}@endif</td>
                      <td>@if($sci->shipped_on_board_date){{date("d-m-Y",strtotime( $sci->shipped_on_board_date))}}@endif</td>
                      <td>@if($sci->bl_date){{date("d-m-Y",strtotime( $sci->bl_date))}} @endif</td>
                      <td>@if($sci->challan_date){{date("d-m-Y",strtotime( $sci->challan_date))}} @endif</td>
                      <td>{{$sci->challan_no}}</td>
                      <td>{{$sci->shipping_bill_no}}</td>
                      <td>@if($sci->shipping_bill_date){{date("d-m-Y",strtotime( $sci->shipping_bill_date))}}@endif</td>
                      <td>@if($sci->lc_date){{date("d-m-Y",strtotime( $sci->lc_date))}} @endif</td>
                      <td>@if($sci->bb_prc_date){{date("d-m-Y",strtotime( $sci->bb_prc_date))}} @endif</td>
                      <td>{{$sci->country_of_importer}}</td>
                     
                   
                  </tr>
                @endforeach  
              </tbody>
          </table> 
      
      </div> <!-- col-md-12 end -->
</div> 


<script>document.title = 'mcb_report';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "mcb_report.xls"); // Choose the file name
  return false;
}
</script>





