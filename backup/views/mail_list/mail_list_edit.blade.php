@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>MailList<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{ route('mail_list.update',$mail_list->id ) }}"><i class="fa fa-dashboard"></i>mail_list Update</a></li>
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
               <h3 class="box-title">MailList</h3>
             </div><!-- /.box-header-end -->
            <form class="" role="form" method="POST" action="{{ route('mail_list.update',$mail_list->id ) }}">
                {{ csrf_field() }}
                {{ method_field('PUT') }} 
                <!-- /.box-body-start -->    
                 <div class="box-body"> 
                        
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">Email</label>
                        <input name="email" type="email" id="email" class="form-control"   value="{{$mail_list->email}}"   required autofocus max="191"  placeholder="Email" >
                        @if ($errors->has('email'))
                            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Name</label>
                        <input name="name" type="text" id="name" class="form-control"   value="{{$mail_list->name}}"   required autofocus max="191"  placeholder="Name" >
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                        <label for="is_active" >Is active</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="is_active"   value="1"   id="is_active"  autofocus  @if($mail_list->is_active==1){{"checked"}}@endif >Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_active"  value="0" @if($mail_list->is_active==0){{"checked"}}@endif>No
                        </label>
                        @if ($errors->has('is_active'))
                            <span class="help-block"><strong>{{ $errors->first('is_active') }}</strong></span>
                        @endif
                    </div>
                </div>    
   
                 </div> 
                 <!-- /.box-body -->
                 <div class="box-footer">
                   <button type="submit" class="btn btn-info pull-right btn-flat">Edit</button>
                 </div>
                
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'MailList | Edit';</script>
@endsection


