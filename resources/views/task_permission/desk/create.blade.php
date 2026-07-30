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
               <h3 class="box-title">Create Desk</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('desk.store') }}">
                {{ csrf_field() }}
                 <div class="box-body"> 
                    <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="factory_address_type_id">Desk Name</label>
                            <input name="name" id="name" type="text"  class="form-control"  required autofocus max="191"  placeholder="Name" >
                        </div>
                    </div>        
                 </div> 
                 <div class="box-footer">
                   <button type="submit" class="btn btn-info btn-flat">Create</button>
                 </div>
             </form>
           </div>
      </div>
</div> 
<script>document.title = 'Desk | Create';</script>
@endsection