@extends('layouts.master')
@section('content') 
<style>
  .table > thead:first-child > tr:first-child > th {
  
     border: 1px solid #222;

  }
  .modal-header {
    border-bottom-color: #eee8e8;
  }
  .modal-footer {
    border-top-color: #eee8e8;
  }
  .panel-body{
    padding: 7px;
    margin-top: -11px;
  }
  .table-bordered > tbody > tr > td{

    border: 1px solid #222;

  }
  table.dataTable thead th{
    padding: 3px 0px;
    font-size: 11px;
  }

  .table > tbody > tr > td{
  
    padding: 1px;
    line-height: 1.42857143;
    vertical-align: top;
    font-size: 9px

  }
  .table-bordered > tbody > tr > td{
    
    border: 1px solid #201f1f;
    padding: 1px;
    font-weight: bold;
  
  }

  .table-bordered > tbody > tr:hover{
  
    background-color: rgba(101, 212, 97, 0.836);
  }
  
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/cvr')}}"><i class="fa fa-dashboard"></i>RIU</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary">
        <br>
        <div class="panel-body table-responsive">
          <table class="table table-bordered table-responsive table-condenced" style="width: 63%;margin: auto;">
              <thead>
                 <tr>
                    <th style="width: 30px;">#Sl</th>
                    <th style="width: 100px;">Ingredient</th>
                    <th style="width: 80px;">Unit</th>
                    <th style="width: 100px;">Source_Type</th>
                    <th style="width: 300px">Source Address</th>
                    <th style="width: 100px;">Price(TK)</th>
                 </tr> 
              </thead>
              <tbody>
                @php
                  $i=1;  
                @endphp
                @foreach($results as $result)
                  <tr>
                    <td>{{$i++}}</td>
                    <td><input type="text" name="ingredient" id="ingredient" value="{{$result->ingredient}}" readonly></td>
                    <td><input type="text" name="rcpe_unit" id="rcpe_unit" value="{{$result->rcpe_unit}}"></td>
                    <td><input type="text" name="source_type" id="source_type" value="{{$result->source_type}}"></td>
                    <td><textarea name="source" id="source" style="width: 350px;height: 33px;">{{$result->source_address}}</textarea></td>
                    <td><input type="text" name="price" id="price" value="{{$result->rate}}"></td>
                  </tr>
                @endforeach  
              </tbody>
              <tfoot>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><input type="button" class="btn btn-info" id="" value="Save Info"></td>
                </tr>
              </tfoot>
          </table>
        </div>
    </div>
  </div>
</div>
<script>document.title = 'Export | RIU';</script>
<script type="text/javascript">
   
    setTimeout(function() { 
          $('.sr-only').click();
    }, 0.0001);

    $(document).ready(function(){
      

      $('.btn-info').click(function(){

        var dataArray = []; 
        $('tbody tr').each(function() {
            var row = $(this);
            var rowData = {  
                ingredient: row.find('input[name="ingredient"]').val(),
                rcpe_unit: row.find('input[name="rcpe_unit"]').val(),
                source_type: row.find('input[name="source_type"]').val(),
                source_address: row.find('textarea[name="source"]').val(),
                rate: row.find('input[name="price"]').val()
            };
            dataArray.push(rowData); 
        });

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        if(dataArray.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "Oops...",
                text: "Sorry You Cannot Save..!",
            });
        } else {
            $.ajax({
                type: 'POST',
                url: '/save-riu-data', 
                data: {data: dataArray,_token: csrfToken}, 
                success: function(res) {

                    Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: res.message,
                      showConfirmButton: false,
                      timer: 1500
                    });

                },
                error: function(xhr, status, error) {
                   
                }
            });
        }

    });

  });
</script>
@endsection