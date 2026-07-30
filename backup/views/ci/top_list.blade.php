@extends('layouts.master')
@section('content')
<h4 class="text-center" style="font-weight: bold;text-transform: uppercase;margin-bottom: -25px">ci top list</h4><p style="text-align: right;">Search:<input type="text" placeholder="Invoice Number" id="search" onkeyup="">&nbsp;&nbsp;&nbsp;&nbsp;<a hre="" onclick="exportF(this)"><button class="btn btn-info btn-sm btn-flat" style="margin-right: 8px;margin-left: -3px;margin-top: -3px">Excel</button></a></p>
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
                <th class="th_width_line">ZONE</th>
                <th class="th_width_line">INVOICE</th>
                <th class="th_width_line">EXP_VALUE<br>(As Per Acc)</th>
                <th class="th_width_line">S/C</th>    
                <th class="th_width_line">EXP</th>
                <th class="th_width_line">C/I</th>
                <th class="th_width_line">P&W</th>
                <th class="th_width_line">B/E</th>
                <th class="th_width_line">FR</th>
                <th class="th_width_line">TT</th>
                <th class="th_width_line">Frwd</th>
            </tr>
        </thead>
        <tbody>
          <?php $i=1?>
          @foreach($saleContracts as $saleContract)
          <tr>
              <td>{{$i++}}</td> 
              <td></td> 
              <td>{{$saleContract->invoice_no}}</td> 
              <td></td> 
              <td></td> 
              <td></td> 
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td> 
          </tr>
          @endforeach
        </tbody>
    </table>
    {{$saleContracts->links()}}
</div>
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
                  rows = rows + '<td>' + value.id + '</td>';
                  rows = rows + '<td>' + ' ' + '</td>';
                  rows = rows + '<td>' + value.invoice_no + '</td>';
                  rows = rows + '<td>' + ' ' + '</td>';
                  rows = rows + '<td>' + ' ' + '</td>';
                  rows = rows + '<td>' + ' ' + '</td>';
                  rows = rows + '<td>' + ' ' + '</td>';
                  rows = rows + '<td>' + ' ' + '</td>';
                  rows = rows + '<td>' + ' ' + '</td>';
                  rows = rows + '<td>' + ' ' + '</td>';
                  rows = rows + '<td>' + ' ' + '</td>';
                  rows = rows + '<td>' + ' ' + '</td>';
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

    


