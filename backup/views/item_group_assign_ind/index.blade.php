@extends('layouts.master')
@section('content') 
<style type="text/css">
    .form-group {

       margin-bottom: 0px;

    }
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1>Item Group Assign<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/assign_item_gorup_india')}}"><i class="fa fa-dashboard"></i>Item Group Assign List</a></li>
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
        <div class="box-header with-border">
            <a href="{{url('/assign_item_gorup_india/create')}}"><button class="btn btn-xs btn-success pull-right btn-flat" data-toggle="modal" data-target="#exampleModal">+ Assign Group</button></a>
        </div>
        <div class="panel-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive table-condenced ">
              <thead>
                  <th>Id</th>
                  <th>Group Name</th>
                  <th>Item Name</th>
                  <th>Hs Code1</th>
                  <th>Short Name</th>
                  <th>Controls</th>
              </thead>
              <tbody>
                  <?php $i=1;?>
                  @foreach($results as $result)
                   <tr>
                      <td>{{$i++}}</td>
                      <td>{{$result->itemGroupIndia[0]->group_name}}</td>
                      <td>{{$result->item_name[0]->ci_item_code}}-{{$result->item_name[0]->ci_item_name}}</td>
                      <td>{{$result->hs_code1}}</td>
                      <td>{{$result->hs_code2}}</td>
                      <td>
                         <a href="{{url('assign_item_gorup_india/'.$result->id.'/edit')}}"><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>
                      </td>
                   </tr>
                  @endforeach 
              </tbody>
          </table>
        </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
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
<script>document.title = 'Item Group | List';</script>
<script type="text/javascript">
$(document).on("click", "#openDeleteModal", function () {

     var delId = $(this).data("id");
     $("#delete_modal_form").attr("action", "{{url('/notify_party_user')}}/" + delId);
     $(".modal-body #delete_id").val( delId );
     $("#myModal").modal("show");

});


$(document).on("click", "#openEditModal", function () {

    var delId = $(this).data("id");
    $("#editModal").modal("show");

});
</script>
@endsection