@extends('layouts.master')
@section('content') 
<style>

.box-header.with-border {

    border-bottom: 2px solid #110e0e82;
}
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
.table-bordered > tbody > tr:hover{

  background-color: rgba(101, 212, 97, 0.836);

}
</style>
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/mytask')}}"><i class="fa fa-dashboard"></i>My Task</a></li>
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
        <div class="alert alert-warning alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
          <strong>Alert! </strong>{{ Session::get('danger') }}
        </div>
      @endif
      <div class="box box-primary">
        <div class="box-header with-border">Desk List<a href="{{url('/desk/create')}}">
          <button class="btn btn-xs btn-success pull-right btn-flat">Create Desk</button></a>
        </div>
        <div class="panel-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive table-condenced">
              <thead>
                  <tr>
                      <th>#SL</th>
                      <th>Desk</th>
                      <th>Controls</th>
                  </tr>  
              </thead>
               <tbody>
                    @foreach ($desks as $key=>$desk)
                    <tr>
                       <td>{{$key+1}}</td>
                       <td>{{$desk->name}}</td>
                       <td>
                          <a href="{{url('/desk/'.$desk->id.'/edit')}}" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>
                          <a id="openDeleteModal" data-toggle="modal" data-id="{{$desk->id}}" title="Delete"  href=""><button type="button" class="btn btn-xs btn-danger btn-flat">Del</button></a>
                       </td>
                    </tr>
                    @endforeach 
              </tbody>  
          </table>
        </div>
    </div>
  </div>
</div>
<script>document.title = 'My Task';</script>

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
<script>document.title = 'Country';</script>
<script type="text/javascript">
  $(document).on("click", "#openDeleteModal", function () {
       var delId = $(this).data("id");
       $("#delete_modal_form").attr("action", "{{url('/desk')}}/" + delId);
       $(".modal-body #delete_id").val( delId );
       $("#myModal").modal("show");
  });
  </script>
@endsection