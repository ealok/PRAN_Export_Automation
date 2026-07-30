@extends('layouts.master')
@section('content')
<h4 class="text-center" style="font-weight: bold;text-transform: uppercase;margin-bottom: -25px">CI over due List</h4><p style="text-align: right;">Search:<input type="text" placeholder="Invoice Number" id="search" onkeyup="">&nbsp;&nbsp;&nbsp;&nbsp;<a hre="" onclick="exportF(this)"></a></p>
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
                <th class="th_width_line">INVOICE</th>
                <th class="th_width_line">Invoice_Amount</th>
                <th class="th_width_line">Break Up</th>    
                <th class="th_width_line">OVERDUE</th>
                <th class="th_width_line">Shipped_On_Board_Date</th>
                <th class="th_width_line">Over Due</th>
                <th class="th_width_line">Company</th>
                <th class="th_width_line">Country</th>
            </tr>
        </thead>
        <tbody>
          <?php $i=1?>
          @foreach($results as $result)
          <tr style="background: lightsalmon;">
              <td>{{$result->export_no}}</td> 
              <td>{{$result->invoice_no}}</td> 
              <td>{{$result->invoice_amount}}</td> 
              <td>{{$result->break_up}}</td> 
              <td>{{$result->over_due}}</td> 
              <td>{{$result->shipped_on_board_date}}</td>
              <td>{{$result->over_due_date}}</td>
              <td>{{$result->company}}</td>
              <td>{{$result->country}}</td> 
          </tr>
          @endforeach
        </tbody>
    </table>
    {{$results->links()}}
</div>
<script>document.title = 'CI Over Due | List'</script>
<script>
    $(document).ready(function () {
    $("#search").keyup(function () {
        var data = $(this).val();
        $.ajax({
            method: 'get',
            url: "{{url('/json/invoice/search')}}",
            data: {'data': data, '_token': $('input[name=_token]').val()},
            success: function (data) {

                var rows = '';
                $.each(data, function (key, value) {
                  rows = rows + '<tr>';
                  rows = rows + '<td>' + value.export_no + '</td>';
                  rows = rows + '<td>' + value.invoice_no + '</td>';
                  rows = rows + '<td>' + value.invoice_amount + '</td>';
                  rows = rows + '<td>' + value.break_up + '</td>';
                  rows = rows + '<td>' + value.over_due + '</td>';
                  rows = rows + '<td>' + value.shipped_on_board_date + '</td>';
                  rows = rows + '<td>' + value.over_due_date + '</td>';
                  rows = rows + '<td>' + value.company + '</td>';
                  rows = rows + '<td>' + value.country + '</td>';
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

    


