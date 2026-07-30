@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>SaleContractDetail<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/sale_contract_detail')}}"><i class="fa fa-dashboard"></i>sale_contract_detail</a></li>
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
        <div class="box-header with-border">SaleContractDetail <a href="{{url('/sale_contract_detail/create')}}">
            <button class="btn btn-xs btn-success pull-right btn-flat">Create SaleContractDetail</button></a>
        </div>
        <div class="panel-body table-responsive">

          <table class="table table-bordered table-responsive table-condenced ">
              <thead>
                  <th>Id</th>
                  <th>Ci item</th>
                  <th>Sale contract</th>
                  <th>Hs code</th>
                  <th>Rate per ctn</th>
                  <th>Ctn</th>
                  <th>Pcs in ctn</th>
                  <th>Total amount</th>

                  <th>Controls</th>
              </thead>
              <tbody>
                @foreach ($sale_contract_details as $sale_contract_detail)
                  <tr>
                      <td>{{$sale_contract_detail->id}}</td>
                      <td>{{$sale_contract_detail->ci_item->name}}</td>
                      <td>{{$sale_contract_detail->sale_contract->name}}</td>
                      <td>{{$sale_contract_detail->hs_code}}</td>
                      <td>{{$sale_contract_detail->rate_per_ctn}}</td>
                      <td>{{$sale_contract_detail->ctn}}</td>
                      <td>{{$sale_contract_detail->pcs_in_ctn}}</td>
                      <td>{{$sale_contract_detail->total_amount}}</td>
                     
                      <td>
                          <a href="{{url('/sale_contract_detail/'.$sale_contract_detail->id)}}" title="Show" ><button type="button" class="btn btn-xs btn-primary btn-flat">Show</button></a>
                          <a href="{{url('/sale_contract_detail/'.$sale_contract_detail->id.'/edit')}}" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>
                          <a id="openDeleteModal" data-toggle="modal" data-id="{{$sale_contract_detail->id}}" title="Delete"  href=""><button type="button" class="btn btn-xs btn-danger btn-flat">Del</button></a>
                      </td>
                  </tr>
                @endforeach  
              </tbody>
          </table>
          {{$sale_contract_details->links()}}
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
<script>document.title = 'SaleContractDetail';</script>
<script type="text/javascript">
$(document).on("click", "#openDeleteModal", function () {
     var delId = $(this).data("id");
     $("#delete_modal_form").attr("action", "{{url('/sale_contract_detail')}}/" + delId);
     $(".modal-body #delete_id").val( delId );
     $("#myModal").modal("show");
});
</script>
@endsection