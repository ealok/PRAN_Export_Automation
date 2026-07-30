@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>Product Percentage<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/product_percentage')}}"><i class="fa fa-dashboard"></i>Product Percentage</a></li>
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
        <div class="box-header with-border">Item Group Name<a href="{{url('/product_percentage/create')}}">
            <button class="btn btn-xs btn-success pull-right btn-flat">Create</button></a>
        </div>
        <div class="panel-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive table-condenced ">
              <thead>
                  <th>Id</th>
                  <th>Item_Group</th>
                  <th>Product</th>
                  <th>Percentage</th>
                  <th>Controls</th>
              </thead>
              <tbody>
                 @foreach($results as $result)
                  <tr>
                    <td>{{$result->id}}</td>
                    <td>{{$result->item_group_name}}</td>
                    <td>{{$result->product_name}}</td>
                    <td>{{$result->percentage}}</td>
                    <td>
                       <a href="{{url('/percentage_setup/'.$result->id.'/edit')}}" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>
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
<script>document.title = 'product Percentage | Setup';</script>
@endsection