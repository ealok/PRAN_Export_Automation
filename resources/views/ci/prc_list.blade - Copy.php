@extends('layouts.master')
@section('content')
<h4 class="text-center" style="font-weight: bold;text-transform: uppercase;margin-bottom: -25px">CI PRC List</h4><p style="text-align: right;">Search:<input type="text" placeholder="Invoice Number" id="search" onkeyup="">&nbsp;&nbsp;&nbsp;&nbsp;<a hre="" onclick="exportF(this)"></a></p>
<style type="text/css">
    .table-bordered > thead > tr > th{

        border: 1px solid #919191;
    }
    .th_width_line{

         color: white;
    }

    tbody {

      overflow-x: auto;   
    }
    .table-bordered > tbody > tr > td{
      
       border: 1px solid #5e4545;
    }  
</style>
<div class="table-responsive">
<table class="table table-condensed table-bordered" id="inv" width="100%" style="border: 1px solid #222">
        <thead style="font-size: 13px">
            <tr style="background: #3f5164;">        
                <th class="th_width_line">Exp_Number</th>
                <th class="th_width_line">Exp_Date</th>
                <th class="th_width_line">Exp_Submit_Date</th>
                <th class="th_width_line">Invoice_No</th>
                <th class="th_width_line">Invoice_Date</th>    
                <th class="th_width_line">Invoice_Amount</th>
                <th class="th_width_line">Realized_Value</th>
                <th class="th_width_line">Date</th>
                <th class="th_width_line">Shipped_On_Board_Date</th>
                <th class="th_width_line">B/L_No/<br>Truck_Challan_NO</th>
                <th class="th_width_line">B/L_Date/<br>Truck_Challan_Date</th>
                <th class="th_width_line">Name_Of<br>Discharging_Port</th>
                <th class="th_width_line">Freight</th>
                <th class="th_width_line">Country_Name</th>
                <th class="th_width_line">S/C_NO</th>
                <th class="th_width_line">S/C_Date</th>
            </tr>
        </thead>
        <tbody>
          @foreach($results as $result)
          <tr>
              <td>{{$result->export_no}}</td> 
              <td>{{$result->export_date}}</td> 
              <td>{{$result->exp_submit_date}}</td> 
              <td>{{$result->invoice_no}}</td> 
              <td>{{$result->invoice_date}}</td> 
              <td>{{$result->invoice_amount}}</td>
              <td>{{$result->realized_amount}}</td>
              <td>{{$result->realized_date}}</td>
              <td>{{$result->shipped_on_board_date}}</td>
              <td>{{$result->bl_no}}</td>
              <td>{{$result->bl_date}}</td>
              <td>{{$result->discharge_port}}</td>
              <td>{{$result->freight_cost}}</td>
              <td>{{$result->importer_country}}</td>
              <td>{{$result->sales_contract_no}}</td> 
              <td>{{$result->dated}}</td> 
          </tr>
          @endforeach
        </tbody>
    </table>
    {{$results->links()}}
</div>
<script>document.title = 'CI PRC | List'</script>
<script>
    $(document).ready(function () {
    $("#search").keyup(function () {
        var data = $(this).val();
        $.ajax({
            method: 'get',
            url: "{{url('/json/invoice/search/prc_list')}}",
            data: {'data': data, '_token': $('input[name=_token]').val()},
            success: function (data) {
                var rows = '';
                $.each(data, function (key, value) {
                  rows = rows + '<tr>';
                  rows = rows + '<td>' + value.export_no + '</td>';
                  rows = rows + '<td>' + value.export_date + '</td>';
                  rows = rows + '<td>' + value.exp_submit_date + '</td>';
                  rows = rows + '<td>' + value.invoice_no + '</td>';
                  rows = rows + '<td>' + value.invoice_date + '</td>';
                  rows = rows + '<td>' + value.invoice_amount + '</td>';
                  rows = rows + '<td>' + value.realized_amount + '</td>';
                  rows = rows + '<td>' + value.realized_date + '</td>';
                  rows = rows + '<td>' + value.shipped_on_board_date + '</td>';
                  rows = rows + '<td>' + value.bl_no + '</td>';
                  rows = rows + '<td>' + value.bl_date + '</td>';
                  rows = rows + '<td>' + value.discharge_port + '</td>';
                  rows = rows + '<td>' + value.freight_cost + '</td>';
                  rows = rows + '<td>' + value.importer_country + '</td>';
                  rows = rows + '<td>' + value.sales_contract_no + '</td>';
                  rows = rows + '<td>' + value.dated + '</td>';
                  rows = rows + '/<tr>';
                });
                $("tbody").html(rows);                     
            },
            error: function (e) {
                console.log(e);
            }

            });

        });

    });

    function exportF(elem) {

        var table = document.getElementById("inv");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Manufacturing_deshboard.xls"); // Choose the file name
        return false;
    }

</script>
@endsection    

    


