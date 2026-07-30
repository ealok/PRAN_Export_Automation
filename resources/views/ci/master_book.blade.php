@extends('layouts.master')
@section('content')
<h4 class="text-center" style="font-weight: bold;text-transform: uppercase;margin-bottom: -25px">ci Master Book List</h4><p style="text-align: right;">Search:<input type="text" placeholder="Enter Invoice Number" id="invoice_no">&nbsp;&nbsp;<button class="btn btn-info btn-sm" id="search">Search</button>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{url('/download/master_book/record/current')}}" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">Excel</button></a></p>
<style type="text/css">
    .table-bordered > thead > tr > th{

        border: 1px solid #919191;
        text-align: center;
        text-transform: uppercase;
        font-size: 11px;
        color: moccasin;
    }
    .th_width_line{

         color: white;
    }


    .table-bordered > tbody > tr > td{

      border: 1px solid #5e4545;
      font-size: 10px;
      font-weight: bold;
    }

</style>
<div class="table-responsive">
<table class="table table-condensed table-bordered" id="inv" width="100%" style="border: 1px solid #222">
        <thead style="font-size: 13px;">
            <tr style="background: #3f5164;">
                <th class="th_width_line">Action</th>
                <th class="th_width_line">SL</th>    
                <th class="th_width_line">AD_Code</th>
                <th class="th_width_line">Exp_Form_No</th>
                <th class="th_width_line">Exp_Date</th>
                <th class="th_width_line">Exp_Submit_Date</th>    
                <th class="th_width_line">Status</th>
                <th class="th_width_line">C.I.Shadow_file</th>
                <th class="th_width_line">Last_Date<br>(Loading_The_Claim)</th>
                <th class="th_width_line">Invoice_No</th>
                <th class="th_width_line">Invoice_Date</th>
                <th class="th_width_line">Exp Amount<br>(In USD)</th>
                <th class="th_width_line">Non_Eligible<br>item_Value</th>
                <th class="th_width_line">No.Of_Carton<br>Exported</th>
                <th class="th_width_line">Proceeds_Realization<br>Date</th>
                <th class="th_width_line">Amount_OF_proceeds_Realized<br>(In USD)</th>
                <th class="th_width_line">Short_Realized<br>(In USD)</th>
                <th class="th_width_line">PRC_Issued<br>Date</th>
                <th class="th_width_line">Bapa_Application<br>Submit_Date</th>
                <th class="th_width_line">Bapa_Certificate<br>Date</th>
                <th class="th_width_line">Claim_Submission<br>Date</th>
                <th class="th_width_line">Claim_Amount<br>(In USD)</th>
                <th class="th_width_line">Audit_Report<br>Date</th>
                <th class="th_width_line">Audit_Amount<br>(In USD)</th>
                <th class="th_width_line">Exchang<br>e-Rate</th>
                <th class="th_width_line">Audit_Amount<br>(In TK)</th>
                <th class="th_width_line">Shipped_On<br>(Board_Date)</th>
                <th class="th_width_line">Over Due</th>
                <th class="th_width_line">B/L_NO/Truck<br>(Challan_NO)</th>
                <th class="th_width_line">B/L_Date/<br>(challan_date)</th>
                <th class="th_width_line">Dischargeing_Port<br></th>
                <th class="th_width_line">Sea/Freight<br>(US $)</th>
                <th class="th_width_line">Company<br>(Exported_Co)Name</th>
                <th class="th_width_line">Country(Exported_to/)<br>Name<br></th>
                <th class="th_width_line">Sales Contract/<br>Letter_OF_Credit</th>
                <th class="th_width_line">Sales Contract/<br>Letter_OF_Credit_Date</th>
                <th class="th_width_line">Bill_Of_Export_NO<br>(Shipping_Bill_NO)</th>
                <th class="th_width_line">Bill_Of_Export_Date<br>(Shipping_Bill_Date)</th>
                <th class="th_width_line">Insurance</th>
                <th class="th_width_line">Non_Eligible_item_name</th>

            </tr>
        </thead>
        <tbody>
          <?php $i=1?>
          @foreach($scis as $sci)
          <tr style="@if($sci->over_due_status_id==1) background-color:lightsalmon;@endif">
              <td><a href="{{url('/master/book/edit/view',$sci->id)}}" title="Edit" ><button type="button" class="btn btn-xs btn-danger btn-flat">Edit</button></a></td>
              <td>{{$i++}}</td> 
              <td>{{$sci->ad_code}}</td> 
              <td>{{$sci->exp_no}}</td> 
              <td>@if($sci->exp_date!='0000-00-00'){{$sci->exp_date}}@endif</td> 
              <td>@if($sci->exp_submit_date!='0000-00-00'){{$sci->exp_submit_date}}@endif</td> 
              <td>{{$sci->sci_status->name}}</td> 
              <td>{{$sci->ci_shadow_file}}</td>
              <td>{{$sci->last_date_for_lodging_claim}}</td>
              <td>{{$sci->invoice_no}}</td>
              <td>{{$sci->invoice_date}}</td>
              <td>${{$sci->exp_amount_usd}}</td>
              <td>{{$sci->non_eligible_item_value}}</td> 
              <td>{{$sci->no_of_carton_exported}}</td> 
              <td>{{$sci->proceeds_realization_date}}</td>
              <td>{{$sci->amount_of_proceed_realized}}</td> 
              <td>{{$sci->short_realized}}</td>
              <td>{{$sci->prc_issue_date}}</td>
              <td>{{$sci->bapa_application_submit_date}}</td>
              <td>{{$sci->bapa_certificate_date}}</td>
              <td>{{$sci->claim_submission_date}}</td>
              <td>{{$sci->claim_amount_usd}}</td>
              <td>{{$sci->audit_report_date}}</td> 
              <td>${{$sci->auditted_amount}}</td> 
              <td>{{$sci->exchange_rate}}</td> 
              <td>{{$sci->auditted_amount_tk}}</td> 
              <td>{{$sci->shipped_on_board_date}}</td>
              <td>{{$sci->over_due}}</td>
              <td>{{$sci->bl_or_challan_no}}</td>
              <td>{{$sci->bl_or_challan_date}}</td>
              <td>{{$sci->discharge_port}}</td>
              <td>{{$sci->see_freight}}</td>
              <td>{{$sci->company_or_exporter_name}}</td> 
              <td>{{$sci->country_or_expored_name}}</td> 
              <td>{{$sci->sale_contract->sales_contract_no}}</td>
              <td>{{date("d-m-Y", strtotime($sci->sale_contract->dated))}}</td>
              <td>{{$sci->shipping_bill_no}}</td>
              <td>{{$sci->shipping_bill_date}}</td>  
              <td>{{$sci->insurance}}</td>
              <td>{{$sci->non_eligible_item_name}}</td>
          </tr>    
          @endforeach
        </tbody>
    </table>
    {{$scis->links()}}
</div>
<script>document.title = 'CI Master | Book'</script>
<script>
     setTimeout(function() { 
          $('.sr-only').click();
    }, 0.0001);
    $(document).ready(function () {

      $("#search").click(function () {

        var data = $('#invoice_no').val();

        $.ajax({
            method: 'get',
            url: "{{url('/json/invoice/search/masterbook')}}",
            data: {'data': data, '_token': $('input[name=_token]').val()},
            success: function (data) {

                console.log(data);

                var rows = '';
                $.each(data, function (key, value) {
                  rows = rows + '<tr>';
                  rows = rows + '<td> <a href="{{url("/master/book/edit/view")}}/' + value.id + '"><button type="button" class="btn btn-xs btn-danger btn-flat" onclick="editSwift(this.id)">Edit</button></td>';
                  rows = rows + '<td>' + value.id + '</td>';
                  rows = rows + '<td>' + value.ad_code  + '</td>';
                  rows = rows + '<td>' + value.exp_no + '</td>';
                  rows = rows + '<td>' + value.exp_date + '</td>';
                  rows = rows + '<td>' + value.exp_submit_date + '</td>';
                  rows = rows + '<td>' + value.name + '</td>';
                  rows = rows + '<td>' + value.ci_shadow_file + '</td>';
                  rows = rows + '<td>' + value.last_date_for_lodging_claim + '</td>';
                  rows = rows + '<td>' + value.invoice_no + '</td>';
                  rows = rows + '<td>' + value.invoice_date + '</td>';
                  rows = rows + '<td>' + value.exp_amount_usd + '</td>';
                  rows = rows + '<td>' + value.non_eligible_item_value + '</td>';
                  rows = rows + '<td>' + value.no_of_carton_exported + '</td>';
                  rows = rows + '<td>' + value.proceeds_realization_date + '</td>';
                  rows = rows + '<td>' + value.amount_of_proceed_realized + '</td>';
                  rows = rows + '<td>' + value.short_realized + '</td>';
                  rows = rows + '<td>' + value.prc_issue_date + '</td>';
                  rows = rows + '<td>' + value.bapa_application_submit_date + '</td>';
                  rows = rows + '<td>' + value.bapa_certificate_date + '</td>';
                  rows = rows + '<td>' + value.claim_submission_date + '</td>';
                  rows = rows + '<td>' + value.claim_amount_usd + '</td>';
                  rows = rows + '<td>' + value.audit_report_date + '</td>';
                  rows = rows + '<td>' + value.auditted_amount + '</td>';
                  rows = rows + '<td>' + value.exchange_rate + '</td>';
                  rows = rows + '<td>' + value.auditted_amount_tk + '</td>';
                  rows = rows + '<td>' + value.shipped_on_board_date + '</td>';
                  rows = rows + '<td>' + value.over_due + '</td>';
                  rows = rows + '<td>' + value.bl_or_challan_no + '</td>';
                  rows = rows + '<td>' + value.bl_or_challan_date + '</td>';
                  rows = rows + '<td>' + value.discharge_port + '</td>';
                  rows = rows + '<td>' + value.see_freight + '</td>';
                  rows = rows + '<td>' + value.company_or_exporter_name + '</td>';
                  rows = rows + '<td>' + value.country_or_expored_name + '</td>';
                  rows = rows + '<td>' + value.sales_contract_no + '</td>';
                  rows = rows + '<td>' + value.dated + '</td>';
                  rows = rows + '<td>' + value.shipping_bill_no + '</td>';
                  rows = rows + '<td>' + value.shipping_bill_date + '</td>';
                  rows = rows + '<td>' + value.insurance + '</td>';
                  rows = rows + '<td>' + value.non_eligible_item_name + '</td>';
                  rows = rows + '/<tr>';
                });
                $("#inv tbody tr").addClass('ct-active');
                $("tbody").html(rows);                     
            },
            error: function (e) {
                console.log(e);
            }

            });

        });

    });
</script>
@endsection    

    


