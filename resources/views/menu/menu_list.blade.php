@extends('layouts.master')
@section('content')
<style>
    #example_filter {
        float: right;
    }
    #example_filter input[type="search"] {
        float: right;
    }
</style> 
<section class="content-header" style="padding-top: 0px;">
    <h1>Menu Setup<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/menu')}}"><i class="fa fa-dashboard"></i>Menu Setup List</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      @if(Session::has('success'))
      <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong>{{ Session::get('success') }}
      </div> 
      @endif 
      @if(Session::has('danger'))
        <div class="alert alert-danger">>
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Failed !</strong>{{ Session::get('danger') }}
        </div> 
      @endif
      <div class="box box-primary">
        <div class="box-header with-border">Menu Setup<a href="{{route('menu.create')}}">
            <button class="btn btn-xs btn-success pull-right btn-flat">Create New</button></a>
        </div>
        <div class="panel-body table-responsive">
          <table class="table table-bordered table-responsive table-condenced" id="example1">
              <thead>
                  <th>Id</th>
                  <th>Root</th>
                  <th>Root_Url</th>
                  <th>Root_Icon</th>
                  <th>Menu</th>
                  <th>Menu_Url</th>
                  <th>Menu_Icon</th>
                  <th>Color</th>
                  <th>Controls</th>
              </thead>
              <tbody>
                <?php $i=1;?>
                @foreach ($menuList as $result)
                  <tr>
                      <td>{{$i++}}</td>
                      <td>{{$result->root}}</td>
                      <td>{{$result->root_url}}</td>
                      <td>{{$result->root_icon}}</td>
                      <td>{{$result->menu}}</td>
                      <td>{{$result->menu_url}}</td>
                      <td>{{$result->menu_icon}}</td>
                      <td>{{$result->color}}</td>
                      <td>
                          <a href="/menu/{{$result->id }}/edit"><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>
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
<script>document.title = 'Menu | Setup';</script>
<script type="text/javascript">
    setTimeout(function() { 
  $('.sr-only').click();
}, 0.0001);
  $(document).on("click", "#openDeleteModal", function () {
      var delId = $(this).data("id");
      $("#delete_modal_form").attr("action", "group/" + delId);
      $(".modal-body #delete_id").val( delId );
      $("#myModal").modal("show");
  });
</script>
@endsection