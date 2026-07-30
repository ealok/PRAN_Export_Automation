@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>Bank<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/bank')}}"><i class="fa fa-dashboard"></i>bank</a></li>
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
        <div class="box-header with-border">Bank <a href="{{url('/bank/create')}}">
            <button class="btn btn-xs btn-success pull-right btn-flat">Create Bank</button></a>
        </div>
        <div class="panel-body table-responsive">

          <table class="table table-bordered table-responsive table-condenced ">
              <thead>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Branch</th>
                  <th>Address</th>
                  <th>Swift code</th>

                  <th>Controls</th>
              </thead>
              <tbody>
                @foreach ($banks as $bank)
                  <tr>
                      <td>{{$bank->id}}</td>
                      <td>{{$bank->name}}</td>
                      <td>{{$bank->branch}}</td>
                      <td>{{$bank->address}}</td>
                      <td>{{$bank->swift_code}}</td>
                     
                      <td>
                          <a href="{{url('/bank/'.$bank->id)}}" title="Show" ><button type="button" class="btn btn-xs btn-primary btn-flat">Show</button></a>
                          <a href="{{url('/bank/'.$bank->id.'/edit')}}" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>
                          <a id="openDeleteModal" data-toggle="modal" data-id="{{$bank->id}}" title="Delete"  href=""><button type="button" class="btn btn-xs btn-danger btn-flat">Del</button></a>
                      </td>
                  </tr>
                @endforeach  
              </tbody>
          </table>
          {{$banks->links()}}
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
<script>document.title = 'Bank';</script>
<script type="text/javascript">
$(document).on("click", "#openDeleteModal", function () {
     var delId = $(this).data("id");
     $("#delete_modal_form").attr("action", "{{url('/bank')}}/" + delId);
     $(".modal-body #delete_id").val( delId );
     $("#myModal").modal("show");
});
</script>
@endsection