@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>BankImporter<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{ route('bank_importer.update',$bank_importer->id ) }}"><i class="fa fa-dashboard"></i>bank_importer Update</a></li>
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
               <h3 class="box-title">BankImporter</h3>
             </div><!-- /.box-header-end -->
            <form class="" role="form" method="POST" action="{{ route('bank_importer.update',$bank_importer->id ) }}">
                {{ csrf_field() }}
                {{ method_field('PUT') }} 
                <!-- /.box-body-start -->    
                 <div class="box-body"> 
                        
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('bank_name') ? 'has-error' : '' }}">
                        <label for="bank_name">Bank name</label>
                        <input name="bank_name" type="text" id="bank_name" class="form-control"   value="{{$bank_importer->bank_name}}"   required autofocus max="191"  placeholder="Bank name" >
                        @if ($errors->has('bank_name'))
                            <span class="help-block"><strong>{{ $errors->first('bank_name') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('account_name') ? 'has-error' : '' }}">
                        <label for="account_name">Account name</label>
                        <input name="account_name" type="text" id="account_name" class="form-control"   value="{{$bank_importer->account_name}}"   required autofocus max="191"  placeholder="Account name" >
                        @if ($errors->has('account_name'))
                            <span class="help-block"><strong>{{ $errors->first('account_name') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
               
                        <div class="form-group {{$errors->has('branch') ? 'has-error' : '' }}">
                            <label for="branch" class="col-sm-3 control-label">Branch</label>
                            <textarea name="branch" id="branch" type="text" class="form-control"  required autofocus>{{$bank_importer->branch}}</textarea>
                            @if ($errors->has('branch'))
                                <span class="help-block"><strong>{{ $errors->first('branch') }}</strong></span>
                            @endif
                        </div>
                    
                </div>        

                <div class="col-sm-6">

                        <div class="form-group {{$errors->has('ac_or_iban') ? 'has-error' : '' }}">
                            <label for="ac_or_iban" class="col-sm-3 control-label">Ac or iban</label>
                            <textarea name="ac_or_iban" id="ac_or_iban" type="text" class="form-control"  required autofocus>{{$bank_importer->ac_or_iban }}</textarea>
                            @if ($errors->has('ac_or_iban'))
                                <span class="help-block"><strong>{{ $errors->first('ac_or_iban') }}</strong></span>
                            @endif
                        </div>
  
                </div>        

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('swift_code') ? 'has-error' : '' }}">
                        <label for="swift_code">Swift code</label>
                        <input name="swift_code" type="text" id="swift_code" class="form-control"   value="{{$bank_importer->swift_code}}"   required autofocus max="191"  placeholder="Swift code" >
                        @if ($errors->has('swift_code'))
                            <span class="help-block"><strong>{{ $errors->first('swift_code') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                 
                        <div class="form-group {{$errors->has('other') ? 'has-error' : '' }}">
                            <label for="other" class="col-sm-3 control-label">Other</label>
                            <textarea name="other" id="other" type="text" class="form-control"  required autofocus>{{ $bank_importer->other }}</textarea>
                            @if ($errors->has('other'))
                                <span class="help-block"><strong>{{ $errors->first('other') }}</strong></span>
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
<script>document.title = 'BankImporter | Edit';</script>
@endsection


