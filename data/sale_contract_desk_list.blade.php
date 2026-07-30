@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>SaleContract<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/sale_contract')}}"><i class="fa fa-dashboard"></i>sale_contract</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
  @if(Session::has('success'))
    <div class="callout callout-success">
        <strong>Success!</strong>{{ Session::get('success') }}
    </div> 
  @endif 
  @if(Session::has('danger'))
    <div class="callout callout-danger">
        <strong>Unsuccessful!</strong>{{ Session::get('danger') }}
    </div> 
  @endif 
  <div>
  <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
         <form class="" method="get" action="/sale_contract/create">
            <input type="hidden" name="id" value="{{$party_id}}"> 
            <button type="submit" class="btn btn-xs btn-success pull-right btn-flat">Create SaleContract</button>
         </form>    
        </div>
        <div class="panel-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive table-condenced">
              <thead>
                  <th>Id</th>
                  <th>Sales contract no</th>
                  <th>Dated</th>
                  <th>Invoice No</th>
                  <th>Company</th>
                  <th>Bank</th>
                  <th>Importer</th>
                  <th>Controls</th>
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
                      <td>{{$sale_contract->bank->name}}</td>
                      <td>{{$sale_contract->final_destination}}</td>
                      <td>
                          <form class="" method="get" action="{{url('/sale_contract',$sale_contract->id)}}">
                             <input type="hidden" name="party_id" value="{{$party_id}}">
                             <button type="submit" class="btn btn-xs btn-primary btn-flat">Show</button> 
                          </form>
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
@endsection