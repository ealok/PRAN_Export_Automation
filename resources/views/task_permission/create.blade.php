@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/desk')}}"><i class="fa fa-dashboard"></i>Desk List</a></li>
    </ol>
    <br>
</section>
<div class="row">
        @if(Session::has('success'))
       <div class="alert alert-success">
               <strong>Success!</strong>{{ Session::get('success') }}
       </div> 
       @endif 
       @if(Session::has('danger'))
       <div class="alert alert-danger">
               <strong>Failed !</strong>{{ Session::get('danger') }}
       </div> 
       @endif
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Task Permission</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('desk_setup.store') }}">
                {{ csrf_field() }}
                 <div class="box-body"> 
                    <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('country_id') ? 'has-error' : '' }}">
                            <label for="factory_address_type_id">Task type</label>
                            <select name="desk_id" id="desk_id" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" >
                                <option value="">Select</option>  
                                @foreach($task_types as $task_type)
                                 <option value="{{$task_type->id}}">{{$task_type->name}}</option>
                                @endforeach
                            </select>  
                        </div>
                    </div>    
                    <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('country_id') ? 'has-error' : '' }}">
                            <label for="factory_address_type_id">User</label>
                            <select name="desk_head_id" id="desk_head_id" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" >
                                <option value="">Select</option>  
                                
                            </select>  
                        </div>
                    </div>    
                 </div> 
                 <div class="box-footer">
                   <button type="submit" class="btn btn-info pull-right btn-flat">Create</button>
                 </div>
             </form>
           </div>
      </div>
</div> 
<script>document.title = 'Desk Setup | Create';</script>
@endsection