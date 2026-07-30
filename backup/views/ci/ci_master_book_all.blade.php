@extends('layouts.master')
@section('content')
<h4 class="text-center" style="font-weight: bold;text-transform: uppercase;margin-bottom: -25px">ci Master Book List All</h4>&nbsp;&nbsp;&nbsp;&nbsp;<p style="text-align: right;"><form action="{{url('/download/master_book/record')}}"><input type="text" placeholder="Form Date" name="form_date" id="form_date" class="datepicker">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" placeholder="To Date" name="to_date" id="to_date" onchange="" class="datepicker"><a hre="" onclick="exportF(this)">&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-sm btn-success btn-flat" style="margin-top: -6px">Excel</button></form></p>
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

    tbody {

      overflow-x: auto;   
    }
    .table-bordered > tbody > tr > td{
      
      border: 1px solid #5e4545;
      font-size: 10px;
      font-weight: bold;
    }
    ct-active{
       
       border-bottom: 1px solid #222;

    }


</style>
<input id="myInput" type="text" placeholder="Search.." style="margin-top: -20px;margin-bottom: 5px">
<br>
<div class="table-responsive">
<table class="table table-condensed table-bordered" id="inv" width="100%" style="border: 1px solid #222">
        <thead style="font-size: 13px">
            <tr style="background: #3f5164;">
                <th class="th_width_line">Operation</th>
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
        <tbody id="search_data">
          
        </tbody>
    </table>
</div>
<script>document.title = 'Master | Book List ALL'</script>
<script>

     
    $( "#to_date" ).change(function() {

       var form_date = $('#form_date').val();
       var to_date = $(this).val();

        $.ajax({
            method: 'get',
            url: "{{url('/json/invoice/search/masterbook/all')}}",
            data: {'form_date': form_date,'to_date':to_date, '_token': $('input[name=_token]').val()},
            success: function (data) {

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
</script>
<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#search_data tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection    

    


