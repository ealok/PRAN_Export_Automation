@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>Company<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{ route('company.update',$company->id ) }}"><i class="fa fa-dashboard"></i>company Update</a></li>
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
               <h3 class="box-title">Company</h3>
             </div><!-- /.box-header-end -->
            <form class="" role="form" method="POST" action="{{ route('company.update',$company->id ) }}">
                {{ csrf_field() }}
                {{ method_field('PUT') }} 
                <!-- /.box-body-start -->    
                 <div class="box-body"> 
                        
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Name</label>
                        <input name="name" type="text" id="name" class="form-control"   value="{{$company->name}}"   required autofocus max="191"  placeholder="Name" >
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                        <label for="code">Code</label>
                        <input name="code" type="text" id="code" class="form-control"   value="{{$company->code}}"   required autofocus max="191"  placeholder="Code" >
                        @if ($errors->has('code'))
                            <span class="help-block"><strong>{{ $errors->first('code') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('erc_no') ? 'has-error' : '' }}">
                        <label for="erc_no">Erc no</label>
                        <input name="erc_no" type="text" id="erc_no" class="form-control"   value="{{$company->erc_no}}"   required autofocus max="191"  placeholder="Erc no" >
                        @if ($errors->has('erc_no'))
                            <span class="help-block"><strong>{{ $errors->first('erc_no') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('bin_no') ? 'has-error' : '' }}">
                        <label for="bin_no">Bin no</label>
                        <input name="bin_no" type="text" id="bin_no" class="form-control"   value="{{$company->bin_no}}"   required autofocus max="191"  placeholder="Bin no" >
                        @if ($errors->has('bin_no'))
                            <span class="help-block"><strong>{{ $errors->first('bin_no') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                        <div class="form-group {{$errors->has('factory_name') ? 'has-error' : '' }}">
                            <label for="factory_name" class="col-sm-12 control-label">Factory name</label>
                            <textarea name="factory_name" id="factory_name" type="text" class="form-control"  required autofocus>{{ $company->factory_name }}</textarea>
                            @if ($errors->has('factory_name'))
                                <span class="help-block"><strong>{{ $errors->first('factory_name') }}</strong></span>
                            @endif
                        </div>
                </div>        

                <div class="col-sm-6">
                        <div class="form-group {{$errors->has('factory_address') ? 'has-error' : '' }}">
                            <label for="factory_address" class="col-sm-12 control-label">Factory address</label>
                            <textarea name="factory_address" id="factory_address" type="text" class="form-control"  required autofocus>{{ $company->factory_address }}</textarea>
                            @if ($errors->has('factory_address'))
                                <span class="help-block"><strong>{{ $errors->first('factory_address') }}</strong></span>
                            @endif
                        </div>
                </div>        
                <div class="col-sm-6">
                    <div class="form-group {{$errors->has('factory_address_details') ? 'has-error' : '' }}">
                        <label for="factory_address_details" class="col-sm-3 control-label">Factory_address_details</label>
                        <textarea name="factory_address_details" id="factory_address_details" type="text" class="form-control"  required autofocus>{{$company->factory_address_details}}</textarea>
                        @if ($errors->has('factory_address_details'))
                            <span class="help-block"><strong>{{ $errors->first('factory_address_details') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                        <div class="form-group {{$errors->has('ho_address') ? 'has-error' : '' }}">
                            <label for="ho_address" class="col-sm-12 control-label">Ho address</label>
                            <textarea name="ho_address" id="ho_address" type="text" class="form-control"  required autofocus>{{ $company->ho_address }}</textarea>
                            @if ($errors->has('ho_address'))
                                <span class="help-block"><strong>{{ $errors->first('ho_address') }}</strong></span>
                            @endif
                        </div>
                </div>        

                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('group_id') ? 'has-error' : '' }}">
                        <label for="group_id">Group </label>
                        <select name="group_id" id="group_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                            <option value="">Select Group</option>
                            @foreach($groups as $group)
                             <option value="{{$group->id}}"  @if($group->id == $company->group_id){{"selected"}} @endif >{{$group->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('group_id'))
                            <span class="help-block"><strong>{{ $errors->first('group_id') }}</strong></span>
                        @endif  
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('group_id') ? 'has-error' : '' }}">
                        <label for="group_id">Enrolment No</label>
                        <input name="enrolment_no" type="text" id="enrolment_no" class="form-control"   value="{{$company->enrolment_no}}" autofocus max="191"  placeholder="Enrolment No">
                        @if ($errors->has('group_id'))
                            <span class="help-block"><strong>{{ $errors->first('group_id') }}</strong></span>
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
<script>document.title = 'Company | Edit';</script>
@endsection


