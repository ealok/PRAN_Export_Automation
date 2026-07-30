@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/bapa_bill_setup')}}"><i class="fa fa-dashboard"></i>Setup List</a></li>
    </ol>
    <br>
</section>
<div class="row">
        @if(Session::has('success')) 
          <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
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
               <h3 class="box-title">Bill Setup Create</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{route('bapa_bill_setup.store')}}">
                  {{ csrf_field() }}
                 <div class="box-body"> 
                      <div class="col-sm-6">
                          <div class="form-group {{ $errors->has('claim_percent') ? 'has-error' : '' }}">
                              <label for="claim_percent">Claim(%)</label>
                              <input name="claim_percent" type="text" id="claim_percent" class="form-control"   value=""   required autofocus max="191"  placeholder="Enter Claim Percentage">
                              @if ($errors->has('claim_percent'))
                                  <span class="help-block"><strong>{{ $errors->first('claim_percent') }}</strong></span>
                              @endif
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group {{ $errors->has('subsidy_percent') ? 'has-error' : '' }}">
                              <label for="subsidy_percent">Subsidy(%)</label>
                              <input name="subsidy_percent" type="text" id="" class="form-control"   value=""   required autofocus max="191"  placeholder="Enter Subsidy Percentage">
                              @if ($errors->has('subsidy_percent'))
                                  <span class="help-block"><strong>{{ $errors->first('subsidy_percent') }}</strong></span>
                              @endif
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group {{ $errors->has('processing_fee') ? 'has-error' : '' }}">
                              <label for="processing_fee">Processing Fee</label>
                              <input name="processing_fee" type="text" id="" class="form-control"   value=""   required autofocus max="191"  placeholder="Enter Processing Fee">
                              @if ($errors->has('processing_fee'))
                                  <span class="help-block"><strong>{{ $errors->first('processing_fee') }}</strong></span>
                              @endif
                          </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('use_rate') ? 'has-error' : '' }}">
                            <label for="use_rate">Rate(USD)</label>
                            <input name="use_rate" type="text" id="" class="form-control"   value=""   required autofocus max="191"  placeholder="Running Rate(USD)">
                            @if ($errors->has('use_rate'))
                                <span class="help-block"><strong>{{ $errors->first('use_rate') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6"></div>
                    <div class="col-sm-2">
                        <label for="processing_fee"></label>
                        <button type="submit" class="btn btn-info pull-right btn-flat" style="margin-top: 22px">Create</button>
                    </div>    
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Bill Setup| Create';</script>
@endsection