@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>Company<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/company')}}"><i class="fa fa-dashboard"></i>company</a></li>
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
        <div class="box-header with-border">Company <a href="{{url('/company/create')}}">
            <button class="btn btn-xs btn-success pull-right btn-flat">Create Company</button></a>
        </div>
        <div class="panel-body table-responsive">

          <table class="table table-bordered table-responsive table-condenced" id="example1">
              <thead>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Ho address</th>
                  <th>Code</th>
                  <th>Erc no</th>
                  <th>Bin no</th>
                  {{-- <th>Factory name</th>
                  <th>Factory address</th>
                  <th>Factory address details</th> --}}
                  {{-- <th>Ho address</th> --}}
                  {{-- <th>Group</th> --}}
                  <th>Enrolment_No</th>
                  <th>Controls</th>
              </thead>
              <tbody>
                @foreach ($companies as $company)
                  <tr>
                      <td>{{$company->id}}</td>
                      <td>{{$company->name}}</td>
                      <td>{{$company->ho_address}}</td>
                      <td>{{$company->code}}</td>
                      <td>{{$company->erc_no}}</td>
                      <td>{{$company->bin_no}}</td>
                      {{-- <td>{{$company->factory_name}}</td>
                      <td>{{$company->factory_address}}</td>
                      <td>{{$company->factory_address_details}}</td> --}}
                      {{-- <td>{{$company->group->name}}</td> --}}
                      <td>{{$company->enrolment_no}}</td>
                      <td>
                          <a href="{{url('/company/'.$company->id)}}" title="Show" ><button type="button" class="btn btn-xs btn-primary btn-flat">Show</button></a>
                          <a href="{{url('/company/'.$company->id.'/edit')}}" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>
                          <a id="openDeleteModal" data-toggle="modal" data-id="{{$company->id}}" title="Delete"  href=""><button type="button" class="btn btn-xs btn-danger btn-flat">Del</button></a>
                      </td>
                  </tr>
                @endforeach  
              </tbody>
          </table>
          {{$companies->links()}}
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
<script>document.title = 'Company';</script>
<script type="text/javascript">
$(document).on("click", "#openDeleteModal", function () {
     var delId = $(this).data("id");
     $("#delete_modal_form").attr("action", "{{url('/company')}}/" + delId);
     $(".modal-body #delete_id").val( delId );
     $("#myModal").modal("show");
});
</script>
@endsection