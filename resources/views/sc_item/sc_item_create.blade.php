@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>ScItem<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/sc_item/create')}}"><i class="fa fa-dashboard"></i>sc_item Create</a></li>
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
               <h3 class="box-title">ScItem</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('sc_item.store') }}">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                        
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                        <label for="code">Code</label>
                        <input name="code" type="text" id="code" class="form-control"   value=""   required autofocus max="191"  placeholder="Code" >
                        @if ($errors->has('code'))
                            <span class="help-block"><strong>{{ $errors->first('code') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Name</label>
                        <input name="name" type="text" id="name" class="form-control"   value=""   required autofocus max="191"  placeholder="Name" >
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ci_item_code') ? 'has-error' : '' }}">
                        <label for="ci_item_code">Ci item code</label>
                        <input name="ci_item_code" type="text" id="ci_item_code" class="form-control"   value=""   required autofocus max="191"  placeholder="Ci item code" >
                        @if ($errors->has('ci_item_code'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_code') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ci_item_name') ? 'has-error' : '' }}">
                        <label for="ci_item_name">Ci item name</label>
                        <input name="ci_item_name" type="text" id="ci_item_name" class="form-control"   value=""   required autofocus max="191"  placeholder="Ci item name" >
                        @if ($errors->has('ci_item_name'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_name') }}</strong></span>
                        @endif
                    </div>
                </div>    
   
                 </div> 
                 <!-- /.box-body -->
                 <div class="box-footer">
                   <button type="submit" class="btn btn-info pull-right btn-flat">Create</button>
                 </div>
                
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'ScItem | Create';</script>
@endsection