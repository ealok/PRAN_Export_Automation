@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>Bank<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/bank/create')}}"><i class="fa fa-dashboard"></i>bank Create</a></li>
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
               <h3 class="box-title">Bank</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('bank.store') }}">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                        
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
                    <div class="form-group {{ $errors->has('branch') ? 'has-error' : '' }}">
                        <label for="branch">Branch</label>
                        <input name="branch" type="text" id="branch" class="form-control"   value=""   required autofocus max="191"  placeholder="Branch" >
                        @if ($errors->has('branch'))
                            <span class="help-block"><strong>{{ $errors->first('branch') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
        
                        <div class="form-group {{$errors->has('address') ? 'has-error' : '' }}">
                            <label for="address" class="col-sm-3 control-label">Address</label>
                            <textarea name="address" id="address" rows="4" type="text" class="form-control"  required autofocus>{{ old('address') }}</textarea>
                            @if ($errors->has('address'))
                                <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
                            @endif
                        </div>
    
                </div>        

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('swift_code') ? 'has-error' : '' }}">
                        <label for="swift_code">Swift code</label>
                        <input name="swift_code" type="text" id="swift_code" class="form-control"   value=""   required autofocus max="191"  placeholder="Swift code" >
                        @if ($errors->has('swift_code'))
                            <span class="help-block"><strong>{{ $errors->first('swift_code') }}</strong></span>
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
<script>document.title = 'Bank | Create';</script>
@endsection