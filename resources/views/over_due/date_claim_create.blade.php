@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/over_due/create')}}"><i class="fa fa-dashboard"></i>Over Due Create</a></li>
    </ol>
    <br>
</section>
<div class="row">
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
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Over Due Create</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('over_due.store') }}">
                 {{ csrf_field() }}
                 <div class="box-body"> 
                      <div class="col-sm-6">
                          <div class="form-group {{ $errors->has('days') ? 'has-error' : '' }}">
                              <label for="days">Number Of Days</label>
                              <input name="days" type="Number" id="" class="form-control"   value=""   required autofocus max="191"  placeholder="Enter Your Days">
                              @if ($errors->has('days'))
                                  <span class="help-block"><strong>{{ $errors->first('days') }}</strong></span>
                              @endif
                          </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                            <label for="date">Date</label>
                            <input name="date" type="text" id="" class="form-control datepicker"   value=""   required autofocus  placeholder="Select Your Date">
                            @if ($errors->has('date'))
                                <span class="help-block"><strong>{{ $errors->first('date') }}</strong></span>
                            @endif
                        </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group{{ $errors->has('status') ? 'has-error' : '' }}">
                              <label for="status">Status</label>
                              <select name="status" id="status" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" required="">
                                   <option value="1">Active</option>
                                   <option value="2" selected="">Inactive</option>
                              </select>
                              @if ($errors->has('status'))
                                  <span class="help-block"><strong>{{ $errors->first('status') }}</strong></span>
                              @endif  
                          </div>
                      </div>
                      <div class="col-sm-2">
                           <button type="submit" class="btn btn-info btn-flat" style="margin-top: 24px">Create</button>
                      </div>     
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Over Due | Create';</script>
<!-- <script language=Javascript>
    function isNumberKey(evt)
    {
       var charCode = (evt.which) ? evt.which : event.keyCode
       if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;

       return true;
    }
</script> -->
@endsection