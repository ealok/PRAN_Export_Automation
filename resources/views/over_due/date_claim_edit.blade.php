@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/ci_item_claim/create')}}"><i class="fa fa-dashboard"></i>Date Claim Edit</a></li>
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
               <h3 class="box-title">Date Claim Edit</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('over_due.update', $dateClaim->id) }}">
                 {{ csrf_field() }}
                 {{ method_field('PUT')}}
                 <div class="box-body"> 
                      <div class="col-sm-6">
                          <div class="form-group {{ $errors->has('days') ? 'has-error' : '' }}">
                              <label for="days">Number Of Days</label>
                              <input name="days" type="Number" id="" class="form-control"   value="{{$dateClaim->days}}"   required autofocus max="191"  placeholder="Enter Your Days">
                              @if ($errors->has('days'))
                                  <span class="help-block"><strong>{{ $errors->first('days') }}</strong></span>
                              @endif
                          </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                            <label for="date">Date</label>
                            <input name="date" type="text" id="" class="form-control datepicker"   value="{{$dateClaim->date}}"   required autofocus  placeholder="Select Your Date">
                            @if ($errors->has('date'))
                                <span class="help-block"><strong>{{ $errors->first('date') }}</strong></span>
                            @endif
                        </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group{{ $errors->has('status') ? 'has-error' : '' }}">
                              <label for="status">Status</label>
                              <select name="status" id="status" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" required="">
                                   @if($dateClaim->status==1)
                                     <option value="1" selected="">Active</option>
                                     <option value="2">Inactive</option>
                                   @endif
                                   @if($dateClaim->status==2)
                                      <option value="1">Active</option>
                                      <option value="2" selected="">Inactive</option> 
                                   @endif
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
<script>document.title = 'Date Claim | Edit';</script>
@endsection