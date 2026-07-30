@extends('layouts.master')
@section('content')
<style>
  .form-group {
     margin-bottom: 5px;
  }
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{route('role.index')}}"><i class="fa fa-dashboard"></i>Role List</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Role Create Form</h3>
             </div><!-- /.box-header-end -->
             <form class="form-horizontal" role="form" method="POST" action="{{route('role.store')}}">
                 {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                      <label for="role" class="col-sm-3 control-label">Role</label>
                      <div class="col-sm-8">
                         <input name="name" type="text" id="name" class="form-control input-sm"   value=""   required  max="200"  placeholder="Enter Role Name" >
                          @if ($errors->has('name'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('name') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>
                  <div class="col-sm-9"></div>
                  <div class="col-sm-2">
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info pull-right btn-flat">Create</button>
                    </div>
                  </div>
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Role | Create';</script>
<script>
  $(document).ready(function () {
      $('form').on('submit', function () {
          
          if ($('#status').is(':checked')) {
             
              $('#status').val(1);
          } else {
              
              $('#status').val(0);
          }
          return true;

      });
  });
</script>
@endsection