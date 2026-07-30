<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>Do List<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/do')}}"><i class="fa fa-dashboard"></i>Do List</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
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
      <div class="box box-primary" style="background: rgba(206, 201, 201, 0.35); border-top-color: #e3e5e6;">
        <div class="box-header with-border" style="border-bottom: 1px solid #d0d0d0;"> 
            <a href="{{url('/do/create')}}"><button type="submit" class="btn btn-xs btn-success pull-right btn-flat">Create Do</button></a>
        </div>
        <div class="panel-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive table-condenced">
              <thead style="background: #68ceac;">
                  <th>Id</th>
                  <th>Do Number</th>
                  <th>Depo Code</th>
                  <th>Depo Name</th>
                  <th>Action</th>
              </thead>
              <tbody>
                 
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
<script>document.title = 'SaleContract';</script>
@endsection