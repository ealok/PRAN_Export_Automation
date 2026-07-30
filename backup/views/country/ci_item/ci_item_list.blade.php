@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>CiItem<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/ci_item')}}"><i class="fa fa-dashboard"></i>ci_item</a></li>
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
        <div class="box-header with-border">CiItem <a href="{{url('/ci_item/create')}}">
            <button class="btn btn-xs btn-success pull-right btn-flat">Create CiItem</button></a>
        </div>
        <div class="panel-body table-responsive">

          <table id="example1" class="table table-bordered table-responsive table-condenced ">
              <thead>
                  <th>Id</th>
                  <th>Item_name</th>
                  <th>CI_item_name</th>
                  <th>Item_code</th>
                  <th>P_net_weight</th>
                  <th>Factor</th>
                  <th>Ci_factor</th>
                  <th>D_net_weight</th>
                  <th>D_gross_weight</th>
                  <th>Ci_item_rate</th>
                  <th>Hs_code</th>
                  <th>Bapa_percent</th>
                  <th>Bu</th>
                  <th>Is_ci_eligible</th>
                  <th>Controls</th>
              </thead>
              <tbody>
                @foreach ($ci_items as $ci_item)
                  <tr>
                      <td>{{$ci_item->id}}</td>
                      <td>{{$ci_item->ci_item_name}}</td>
                      <td>{{$ci_item->duplicate_name}}</td>
                      <td>{{$ci_item->ci_item_code}}</td>
                      <td>{{$ci_item->p_net_weight}}</td>
                      <td>{{$ci_item->factor}}</td>
                      <td>{{$ci_item->ci_factor}}</td>
                      <td>{{$ci_item->d_net_weight}}</td>
                      <td>{{$ci_item->d_gross_weight}}</td>
                      <td>{{$ci_item->ci_item_rate}}</td>
                      <td>{{$ci_item->hs_code}}</td>
                      <td>{{$ci_item->bapa_percent}}</td>
                      <td>{{$ci_item->bu->name}}</td>
                      <td>@if($ci_item->is_ci_eligible){{"Yes"}}@else{{"No"}}@endif</td>
                      <td>
                          <a href="{{url('/ci_item/'.$ci_item->id)}}" title="Show" ><button type="button" class="btn btn-xs btn-primary btn-flat">Show</button></a>
                          <a href="{{url('/ci_item/'.$ci_item->id.'/edit')}}" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>
                          <a id="openDeleteModal" data-toggle="modal" data-id="{{$ci_item->id}}" title="Delete"  href=""><button type="button" class="btn btn-xs btn-danger btn-flat">Del</button></a>
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
<script>document.title = 'CiItem';</script>
<script type="text/javascript">
$(document).on("click", "#openDeleteModal", function () {
     var delId = $(this).data("id");
     $("#delete_modal_form").attr("action", "{{url('/ci_item')}}/" + delId);
     $(".modal-body #delete_id").val( delId );
     $("#myModal").modal("show");
});
</script>
@endsection