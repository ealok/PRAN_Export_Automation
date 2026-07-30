<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>NotifyParty<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/notify_party')}}"><i class="fa fa-dashboard"></i>notify_party</a></li>
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
        <div class="box-header with-border">NotifyParty <a href="{{url('/notify_party/create')}}">
            <button class="btn btn-xs btn-success pull-right btn-flat">Create NotifyParty</button></a>
        </div>
        <div class="panel-body table-responsive">

          <table id="example1" class="table table-bordered table-responsive table-condenced ">
              <thead>
                  <th>Id</th>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Ref_Name</th>
                  <th>Controls</th>
              </thead>
              <tbody>
                @foreach ($notify_parties as $notify_party)
                  <tr>
                      <td>{{$notify_party->id}}</td>
                      <td>{{$notify_party->code}}</td>
                      <td>{{$notify_party->name}}</td>
                      <td>{{$notify_party->address}}</td>
                      <td style="background: #ddd">{{$notify_party->ref_name}}</td>
                      <td>
                          <a href="{{url('/notify_party/'.$notify_party->id)}}" title="Show" ><button type="button" class="btn btn-xs btn-primary btn-flat">Show</button></a>
                          {{-- @if(AdminController::isAccessable(3)) --}}
                          <a href="{{url('/notify_party/'.$notify_party->id.'/edit')}}" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>
                          {{-- @endif --}}
                          @if(AdminController::isAccessable(4))
                          <a id="openDeleteModal" data-toggle="modal" data-id="{{$notify_party->id}}" title="Delete"  href=""><button type="button" class="btn btn-xs btn-danger btn-flat">Del</button></a>
                          @endif
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
<script>document.title = 'NotifyParty';</script>
<script type="text/javascript">
  setTimeout(function() { 
      $('.sr-only').click();
  }, 0.0001);
  
  $(document).on("click", "#openDeleteModal", function () {
      var delId = $(this).data("id");
      $("#delete_modal_form").attr("action", "{{url('/notify_party')}}/" + delId);
      $(".modal-body #delete_id").val( delId );
      $("#myModal").modal("show");
  });
</script>
@endsection