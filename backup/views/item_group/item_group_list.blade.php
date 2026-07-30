@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>Item Group<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/item_group')}}"><i class="fa fa-dashboard"></i>item_group</a></li>
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
        <strong>Failed!</strong>{{ Session::get('danger') }}
      </div>
    @endif  
  <div>
  <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">Item Group Name<a href="{{url('/item_group/create')}}">
            <button class="btn btn-xs btn-success pull-right btn-flat">Create Item Group</button></a>
        </div>
        <div class="panel-body table-responsive">

          <table id="example1" class="table table-bordered table-responsive table-condenced ">
              <thead>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Short_Name</th>
                  <th>Controls</th>
              </thead>
              <tbody>
                 <?php $i=1;?>
                 @foreach($itemGroups as $itemGroup)
                 <tr>
                    <td>{{$itemGroup->id}}</td>
                    <td>{{$itemGroup->item_group_name}}</td>
                    <td>{{$itemGroup->short_name}}</td>
                    <td>
                       <a href="{{url('/item_group/'.$itemGroup->id.'/edit')}}" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>
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
<script>document.title = 'Item Group | Home';</script>
<script type="text/javascript">
$(document).on("click", "#openDeleteModal", function () {
     var delId = $(this).data("id");
     $("#delete_modal_form").attr("action", "{{url('/notify_party_user')}}/" + delId);
     $(".modal-body #delete_id").val( delId );
     $("#myModal").modal("show");
});
</script>
@endsection