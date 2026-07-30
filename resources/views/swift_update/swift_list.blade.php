@extends('layouts.master')
@section('content')
<h4 class="text-center" style="font-weight: bold;text-transform: uppercase;margin-bottom: -25px">Swift list</h4><p style="text-align: right;">Search:<input type="text" placeholder="" id="search" onkeyup="">&nbsp;&nbsp;&nbsp;&nbsp;<a hre="" onclick="exportF(this)"><button class="btn btn-info btn-sm btn-flat" style="margin-right: 8px;margin-left: -3px;margin-top: -3px">Excel</button></a></p>
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
                <th class="th_width_line">SL</th>
                <th class="th_width_line">TT_Number</th>    
                <th class="th_width_line">Invoice_No</th>
                <th class="th_width_line">Bank_Name</th>
                <th class="th_width_line">Company</th>
                <th class="th_width_line">Remittance</th>
                <th class="th_width_line">Realized</th>
                <th class="th_width_line">Break_Up</th>
                <th class="th_width_line">Value_Date</th>
                <th class="th_width_line">Remiter</th>
                <th class="th_width_line">Arv</th>
                <th class="th_width_line">Realized_Date</th>
                <th class="th_width_line">Status</th>
            </tr>
        </thead>
        <tbody>
          <?php $i=1?>
          @foreach($results as $result)
          <tr>
              <td>{{$i++}}</td> 
              <td>{{$result->tt_number}}</td> 
              <td>{{$result->invoice_no}}</td> 
              <td>{{$result->bank_name}}</td> 
              <td>{{$result->company}}</td> 
              <td>{{$result->remittance_amount}}</td> 
              <td>{{$result->realized_amount}}</td> 
              <td>{{$result->total}}</td> 
              <td>{{$result->value_date}}</td> 
              <td>{{$result->remiter}}</td> 
              <td>{{$result->arv}}</td> 
              <td>{{$result->realized_date}}</td> 
              <td>{{$result->status}}</td> 
          </tr>
          @endforeach
        </tbody>
    </table>
    {{$results->links()}}
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">EDIT SWIFT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
    
    function editSwift(even){
              
       event.preventDefault();      
 
    }

    $(document).ready(function () {
    $("#search").keyup(function () {
        var data = $(this).val();
        $.ajax({
            method: 'get',
            url: "{{url('/json/get/swift/list')}}",
            data: {'data': data, '_token': $('input[name=_token]').val()},
            success: function (data) {;
                var rows = '';
                var i=1;
                $.each(data, function (key, value) {
                  rows = rows + '<tr>';
                  rows = rows + '<td>' + i++ + '</td>';
                  rows = rows + '<td>' + value.tt_number + '</td>';
                  rows = rows + '<td>' + value.invoice_no + '</td>';
                  rows = rows + '<td>' + value.bank_name + '</td>';
                  rows = rows + '<td>' + value.company + '</td>';
                  rows = rows + '<td>' + value.remittance_amount + '</td>';
                  rows = rows + '<td>' + value.realized_amount + '</td>';
                  rows = rows + '<td>' + value.total + '</td>';
                  rows = rows + '<td>' + value.value_date + '</td>';
                  rows = rows + '<td>' + value.remiter + '</td>';
                  rows = rows + '<td>' + value.arv + '</td>';
                  rows = rows + '<td>' + value.realized_date + '</td>';
                  rows = rows + '<td>' + value.status + '</td>';
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

    


