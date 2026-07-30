@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>NotifyPartyItem<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/notify_party_item')}}"><i class="fa fa-dashboard"></i>notify_party_item</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
     @if(Session::has('success'))
      <div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>Success!</strong>{{ Session::get('success') }}
      </div> 
    @endif 
    @if(Session::has('danger'))
      <div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>Alert!</strong> {{ Session::get('danger') }}
      </div>  
    @endif 
      <div class="box box-primary">  
        <div class="panel-body table-responsive">
          <form class="" method="get" action="{{url('/notify_party_item/create')}}">
              <input type="hidden" name="party_id" value="{{$id}}">
              <button class="btn btn-xs btn-success pull-right btn-flat">Create NotifyPartyItem</button></a>
          </form>  
          <table id="example1" class="table table-bordered table-responsive table-condenced ">
              <thead>
                  <th>Id</th>
                  <th>Notify party</th>
                  <th>Ci_item</th>
                  <th>Desk_item_name</th>
                  <th>Acc_rate</th>
                  <th>Party_rate</th>
                  <th>Cbm</th>
                  <th>Gross_Weight</th>
                  <th>Shelf_Life</th>
                  <th>Status</th>
                  <th>Controls</th>
              </thead>
              <tbody>
                @foreach ($notify_party_items as $notify_party_item)
                  <tr>
                      <td>{{$notify_party_item->id}}</td>
                      <td>{{$notify_party_item->code}} - {{$notify_party_item->name}}</td>
                      <td>{{$notify_party_item->ci_item_code}} - {{$notify_party_item->ci_item_name}}</td>
                      <td>{{$notify_party_item->desk_item_name}}</td>
                      <td>{{$notify_party_item->acc_rate}}</td>
                      <td>{{$notify_party_item->party_rate}}</td>
                      <td>{{$notify_party_item->cbm_per_ctn}}</td>
                      <td>{{$notify_party_item->gross_weight}}</td>
                      <td>{{$notify_party_item->shelf_life}}</td>
                      <td>@if($notify_party_item->status=="1"){{"Active"}}@else{{"Inactive"}}@endif</td>
                      <td>
                          <form class="" method="get" action="{{url('/notify_party_item/'.$notify_party_item->id.'/edit')}}">
                          <input type="hidden" name="id" value="{{$id}}">
                          <button type="submit" class="btn btn-xs btn-info btn-flat">Edit</button>
                          </form>
                          <a id="openDeleteModal" data-toggle="modal" data-id="{{$notify_party_item->id}}" title="Delete"  href=""><button type="button" class="btn btn-xs btn-danger btn-flat">Del</button></a>
                      </td>
                  </tr>
                @endforeach  
              </tbody>
          </table>
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
<script>document.title = 'NotifyPartyItem';</script>
<script type="text/javascript">
$(document).on("click", "#openDeleteModal", function () {
     var delId = $(this).data("id");
     $("#delete_modal_form").attr("action", "{{url('/notify_party_item')}}/" + delId);
     $(".modal-body #delete_id").val( delId );
     $("#myModal").modal("show");
});
</script>
@endsection