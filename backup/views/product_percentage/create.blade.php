@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/item_group/create')}}"><i class="fa fa-dashboard"></i>Product Percentage Create</a></li>
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
               <h3 class="box-title">Create Item Group</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('product_percentage.store') }}">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body">    
                  <div class="col-sm-6">
                      <div class="form-group {{ $errors->has('product_name') ? 'has-error' : '' }}">
                          <label for="product_name">Product Name</label>
                          <input name="product_name" type="text" id="product_name" class="form-control"   value=""   required autofocus max="191"  placeholder="" >
                          @if ($errors->has('product_name'))
                              <span class="help-block"><strong>{{ $errors->first('product_name') }}</strong></span>
                          @endif
                      </div>
                  </div>
                  <div class="col-sm-6">
                      <div class="form-group {{ $errors->has('percentage') ? 'has-error' : '' }}">
                          <label for="percentage">Percentage</label>
                          <input name="percentage" type="text" id="percentage" class="form-control"   value=""   required autofocus max="191"  placeholder="" >
                          @if ($errors->has('percentage'))
                              <span class="help-block"><strong>{{ $errors->first('percentage') }}</strong></span>
                          @endif
                      </div>
                  </div>
                  <div class="col-sm-6"></div>
                  <div class="col-sm-6">
                       <button type="submit" class="btn btn-info btn-flat" style="margin-top: 23px">Create</button>
                  </div>         
                 </div> 
                 <!-- /.box-body -->                
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Product Percentage | Create';</script>
@endsection