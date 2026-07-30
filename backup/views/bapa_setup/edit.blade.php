@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/ci_item_claim/create')}}"><i class="fa fa-dashboard"></i>IMP Update</a></li>
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
               <h3 class="box-title">IMP Update</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{url('/update/imp') }}">
                {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                      <div class="col-sm-6">
                          <div class="form-group {{ $errors->has('ci_item_claim_name') ? 'has-error' : '' }}">
                              <label for="ci_item_claim_name">Percentage</label>
                              <input name="update_percentage" type="text" id="" class="form-control"   value="{{$impValue}}"   required autofocus max="191"  placeholder="Enter Percentage Value">
                              @if ($errors->has('ci_item_claim_name'))
                                  <span class="help-block"><strong>{{ $errors->first('ci_item_claim_name') }}</strong></span>
                              @endif
                              <input type="hidden" name="sc_id" value="{{$id}}">
                          </div>
                      </div>
                      <div class="col-sm-2">
                         <label for="ci_item_claim_name"></label>
                         <button type="submit" class="btn btn-info pull-right btn-flat" style="margin-top: 22px">Update</button>
                      </div>    
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Imp | Update';</script>
@endsection