@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/cash/insentive/report/view')}}"><i class="fa fa-dashboard"></i>Insentive Report</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-6 col-md-offset-2">
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
           <!-- Horizontal Form -->
           <div class="box box-info" style="margin-top: -16px"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Inserntive Report</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{url('/cash/insentive/report/show')}}">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                <div class="box-body"> 
                  <div class="col-sm-10">
                      <div class="form-group {{ $errors->has('fromDate') ? 'has-error' : '' }}">
                          <label for="name">Form Date</label>
                          <input name="fromDate" type="text" class="form-control datepicker"   value=""   required placeholder="Select Form Date">
                          @if ($errors->has('fromDate'))
                              <span class="help-block"><strong>{{ $errors->first('fromDate') }}</strong></span>
                          @endif
                      </div>
                  </div>  
                  <div class="col-sm-10" style="margin-top: -12px">
                      <div class="form-group {{ $errors->has('toDate') ? 'has-error' : '' }}">
                          <label for="toDate">To Date</label>
                          <input name="toDate" type="text" id="toDate" class="form-control datepicker"      required  placeholder="Select To Date" >
                          @if ($errors->has('toDate'))
                              <span class="help-block"><strong>{{ $errors->first('toDate') }}</strong></span>
                          @endif
                      </div>
                  </div>   
                  <div class="col-sm-10">
                    <div class="form-group {{ $errors->has('fromDate') ? 'has-error' : '' }}">
                      <label for="toDate">Region</label>
                      <select name="region" id="region" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                        <option value="All">All</option>
                        @foreach($regions as $region)
                        <option value="{{$region->region_code}}">{{$region->region}}</option>
                        @endforeach
                      </select>  
                    </div>
                  </div>  
                  <div class="col-sm-6"></div>
                  <div class="col-sm-4">
                       <button type="submit" class="btn btn-info pull-right btn-flat">View</button> 
                  </div> 
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Country | Create';</script>
@endsection