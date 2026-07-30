@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>CompanyBank<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/company_bank/create')}}"><i class="fa fa-dashboard"></i>company_bank Create</a></li>
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
               <h3 class="box-title">CompanyBank</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('company_bank.store') }}">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                        
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('company_id') ? 'has-error' : '' }}">
                        <label for="company_id">Company </label>
                        <select name="company_id" id="company_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                             <option value="{{$company->id}}">{{$company->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('company_id'))
                            <span class="help-block"><strong>{{ $errors->first('company_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('bank_id') ? 'has-error' : '' }}">
                        <label for="bank_id">Bank </label>
                        <select name="bank_id" id="bank_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                            <option value="">Select Bank</option>
                            @foreach($banks as $bank)
                             <option value="{{$bank->id}}">{{$bank->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('bank_id'))
                            <span class="help-block"><strong>{{ $errors->first('bank_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('account_number') ? 'has-error' : '' }}">
                        <label for="account_number">Account number</label>
                        <input name="account_number" type="text" id="account_number" class="form-control"   value=""   required autofocus max="191"  placeholder="Account number" >
                        @if ($errors->has('account_number'))
                            <span class="help-block"><strong>{{ $errors->first('account_number') }}</strong></span>
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
<script>document.title = 'CompanyBank | Create';</script>
@endsection