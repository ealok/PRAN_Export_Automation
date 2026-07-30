<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content') 
<style>
  .table > thead:first-child > tr:first-child > th {
  
    border: 1px solid #222;
  
  }
  
  .table-bordered > tbody > tr > td{
  
    border: 1px solid #222;
  
  }
  
  .table > tbody > tr > td{
  
    padding: 1px;
    line-height: 1.42857143;
    vertical-align: top;
  
  }
  
  .table-bordered > tbody > tr > td{
  
    border: 1px solid #201f1f;
    padding: 1px;
    font-weight: bold;
  
  }
  
  table.dataTable {
  
    width: 99%;
    margin: 0 auto;
    clear: both;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 12px;
  }
  
  .table-bordered > tbody > tr:hover{
  
    background-color: rgba(101, 212, 97, 0.836);
  
  }

  .breadcrumb{

    position: absolute;
    left: -13px;
    top: 3px;
    padding: 0px 15px;

  }
  a {
    color: #3c8dbc;
  }
  label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 0px;
    font-weight: 700;
  }
  .panel-body {

    padding: 0px;

  }
  </style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="col-md-12">
      @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success! </strong> {{ Session::get('success') }}
        </div>
      @endif 
      @if(Session::has('danger'))
        <div class="alert alert-danger alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Alert! </strong>{{ Session::get('danger')}}
        </div> 
      @endif 
      <div>
      <div class="box box-primary">
        <div class="box-header with-border">
          <ol class="breadcrumb">
            <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>&nbsp;Home</a></li>
            <li class="active"><a href="{{url('/access_notify_party_list')}}"><i class="fa fa-dashboard"></i>&nbsp;Notify_Party_List</a></li>
            <li class="active"><a href="{{url('/notify/party/job/order/list')}}/{{\Crypt::encrypt($party_id)}}"><i class="fa fa-dashboard"></i>&nbsp;JO List</a></li>
          </ol>  
          @if(AdminController::isAccessable(28))  
              <a href="{{url('/sale_contract/create')}}/{{\Crypt::encrypt($party_id)}}"><button type="submit" class="btn btn-xs btn-primary btn-flat pull-right">Create SaleContract</button></a> 
          @endif
        </div>
        <div class="panel-body table-responsive">
          <table id="example2" class="table table-bordered table-responsive table-condenced">
              <thead style="background: #68ceac;">
                  <th>Id</th>
                  <th>Sales_contract_no</th>
                  <th>Dated</th>
                  <th style="width: 205.183px;">Invoice No</th>
                  <th>Company</th>
                  <th>Bank</th>
                  <th>Importer</th>
                  <th style="width: 99.017px;">Controls</th>
              </thead>
              <tbody>
                @foreach ($sale_contracts as $sale_contract)
                  <tr style="background-color:
                      @if($sale_contract->approver_id != null){{'#668cff'}} 
                      @elseif($sale_contract->desk_approver_id != null){{'#99ffe6'}}
                      @endif;">
                      <td>{{$sale_contract->id}}</td>
                      <td>{{$sale_contract->sales_contract_no}}</td>
                      <td>{{date("d-m-Y",strtotime( $sale_contract->dated))}}</td>
                      <td>{{$sale_contract->invoice_no}}</td>
                      <td>{{$sale_contract->company->name}}</td>
                      <td>{{ isset($sale_contract->bank) ? $sale_contract->bank->name : '' }}<br><span style="font-size: 10px;font-weight: bold;">{{$sale_contract->export_no}}</span></td>
                      <td>{{$sale_contract->final_destination}}</td>
                      <td>
                         <a href="{{url('/jo/create')}}/{{\Crypt::encrypt($sale_contract->id)}}/{{\Crypt::encrypt($party_id)}}"><button type="button" class="btn btn-xs btn-primary pull-right btn-flat" style="margin-left: 4px">Create JO</button></a> 
                         <a href="{{url('/view/com_inv/details')}}/{{\Crypt::encrypt($sale_contract->id)}}/{{\Crypt::encrypt($party_id)}}"><button type="button" class="btn btn-xs btn-success pull-right btn-flat">Show</button></a>
                      </td>
                  </tr>
                @endforeach  
              </tbody>
          </table>
          <script>
              $('#notify_party_id').change(function(){
                  var val = $(this).val();
                  location.href = '/sale_contract?notify_party_id='+val;
              });
          </script>
        </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
  <form class="form-horizontal" id="delete_modal_form" role="form" method="POST" action="">
    {{ csrf_field() }}
    {{ method_field("DELETE") }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete item</h4>
      </div>
      <div class="modal-body">
        <h4>Do you want to delete This item ??</h4>
        <input id="delete_id" type="hidden" name="id">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-info pull-left" >Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
    </form>

  </div>
</div>
<script>document.title = 'SaleContract';</script>
<script type="text/javascript">
$(document).on("click", "#openDeleteModal", function () {
     var delId = $(this).data("id");
     $("#delete_modal_form").attr("action", "{{url('/sale_contract')}}/" + delId);
     $(".modal-body #delete_id").val( delId );
     $("#myModal").modal("show");
});
</script>

<script type="text/javascript">
    var elems = document.getElementsByClassName('duplicate_confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure want to duplicate?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>
<script>
   $(document).ready(function(){
      setTimeout(function() { 

          $('.sr-only').click();

      }, 0.0001);
  });

  $('#example2').DataTable({
    "order": [[ 0, "DESC" ]],
    "lengthMenu": [[25, 50,100, -1], [25, 50,100,"All"]]
  });
</script>
@endsection