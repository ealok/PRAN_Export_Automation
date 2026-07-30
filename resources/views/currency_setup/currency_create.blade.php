@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/currency/create')}}"><i class="fa fa-dashboard"></i>Setup Create</a></li>
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
               <h3 class="box-title">Create Form</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('currency.store') }}">
                {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body">    
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('currency_name') ? 'has-error' : '' }}">
                            <label for="currency_name">Currency Name</label>
                            <input name="currency_name" type="text" id="currency_name" class="form-control"   value=""   required autofocus   placeholder="Enter Currency Name" >
                            @if ($errors->has('currency_name'))
                                <span class="help-block"><strong>{{ $errors->first('currency_name') }}</strong></span>
                            @endif
                        </div>
                    </div>    
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('currency_rate') ? 'has-error' : '' }}">
                            <label for="currency_rate">Exchange Rate</label>
                            <input name="currency_rate" type="text" id="currency_rate" class="form-control"   value=""   required autofocus  placeholder="Enter Currency Rate" >
                            @if ($errors->has('currency_rate'))
                                <span class="help-block"><strong>{{ $errors->first('currency_rate') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6"></div>  
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-info btn-flat" style="margin-top: 24px;">Create</button>
                    </div>
                </div>
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Currency | Setup';</script>
@endsection