
<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content') 
<style type="text/css">
  .main{

         position: absolute;
         border:1px solid #222;
         top: -13px;
         left: 35px;
         background: burlywood;
         width: 200px;
         text-align: center;
         height: 24px;

  }
  .form-group{
  
    margin-bottom: 0px;

  }
    tr:nth-child(1n+1) {background: #ced9dd;}
    tr:nth-child(2n+0) {background: #c4c8c4}
    /*tr:hover{

      background: #ede7f6;
    }*/
  table td:hover {

    background-color: #ec407a;
    color:black;

  }

  table {

    table-layout: fixed;

  }  
  .ellipsis {

    max-width: 40px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;

  }
  .table_footer{

    text-align: center;
    
  } 
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/job_order/create')}}"><i class="fa fa-dashboard"></i>Job Order Process</a></li>
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
      <div class="box box-primary" style="background: rgba(206, 201, 201,); border-top-color: #e3e5e6;position: relative; width: 100%">
        <form class="" role="form" method="POST" action="{{url('/factory/job_order/setup/update',$setUpRow->id)}}">
        {{ csrf_field() }}
        <div class="panel-body table-responsive" style="border: 3px solid #c67520;">
             <div class="box-body">      
                <div class="col-md-offset-3 col-sm-8">
                    <label for="recipient-name" class="col-form-label">User:</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <select name="user_id" id="user_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                             <option value="">Select</option>
                             @foreach($users as $user)
                             <option value="{{$user->id}}" @if($user->id == $setUpRow->user_id) {{'selected'}} @endif>{{$user->username}} || {{$user->name}}</option>
                             @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-offset-3 col-sm-8">
                  <label for="recipient-name" class="col-form-label">Production Floor:</label>
                  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                      <select name="p_floor_id" id="p_floor_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                           <option value="">Select</option>
                           @foreach($productionFloors as $productionFloor)
                           <option value="{{$productionFloor->id}}" @if($productionFloor->id == $setUpRow->production_floor_id) {{'selected'}} @endif>{{$productionFloor->p_code}} || {{$productionFloor->p_name}}</option>
                           @endforeach
                      </select>
                  </div>    
                </div>
                <div class="col-md-offset-3 col-sm-8">
                    <button type="submit" class="btn btn-info pull-right btn-flat" style="margin-top: 28px;">Edit</button>
                </div>  
               </div>
          </form> 
        </div>
        <label for="name" style="position: absolute;top: -21px;left: 40px;width: 252px;height: 23px;text-align: center;padding: 11px 15px 30px 18px;background: darkorange;color: black;border-radius: 20px;">Edit Setup</label>
    </div>
  </div>
</div>
<script>document.title = 'Production Floor Setup | Edit';</script>
@endsection