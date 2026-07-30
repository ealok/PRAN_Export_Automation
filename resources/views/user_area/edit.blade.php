@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/user_area')}}"><i class="fa fa-dashboard"></i>User_area List</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Edit Area Setup</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('user_area.update',$userArea->id)}}">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                 <!-- /.box-body-start --> 
                 <div class="box-body">    
                  <div class="col-sm-6">
                    <label for="name">User</label>
                      <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                          <select name="user_id" id="user_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                            <option value="">Select</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}"  @if($user->id == $userArea->user_id){{"selected"}} @endif>{{$user->username}}-{{$user->name}}</option>  
                            @endforeach
                          </select>
                      </div>
                  </div>    
                  <div class="col-sm-6">
                    <label for="name">Area</label>
                      <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                          <select name="area_id" id="area_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                            <option value="">Select</option>
                            @foreach($areas as $area) 
                            <option value="{{$area->id}}"  @if($area->id == $userArea->area_id){{"selected"}} @endif>{{$area->name}}</option>
                            @endforeach   
                          </select>
                      </div>
                  </div>     
                 </div> 
                 <!-- /.box-body -->
                 <div class="box-footer">
                   <button type="submit" class="btn btn-info pull-right btn-flat">Update</button>
                 </div>
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'User Area | Edit';</script>
@endsection