@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>SaleContractDetail<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/sale_contract_detail/create')}}"><i class="fa fa-dashboard"></i>sale_contract_detail Create</a></li>
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
               <h3 class="box-title">SaleContractDetail</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('sale_contract_detail.store') }}">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                        
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('ci_item_id') ? 'has-error' : '' }}">
                        <label for="ci_item_id">Ci item </label>
                        <select name="ci_item_id" id="ci_item_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                            <option value="">Select Ci item</option>
                            @foreach($ci_items as $ci_item)
                             <option value="{{$ci_item->id}}">{{$ci_item->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('ci_item_id'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('sale_contract_id') ? 'has-error' : '' }}">
                        <label for="sale_contract_id">Sale contract </label>
                        <select name="sale_contract_id" id="sale_contract_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                            <option value="">Select Sale contract</option>
                            @foreach($sale_contracts as $sale_contract)
                             <option value="{{$sale_contract->id}}">{{$sale_contract->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('sale_contract_id'))
                            <span class="help-block"><strong>{{ $errors->first('sale_contract_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('hs_code') ? 'has-error' : '' }}">
                        <label for="hs_code">Hs code</label>
                        <input name="hs_code" type="text" id="hs_code" class="form-control"   value=""   required autofocus max="191"  placeholder="Hs code" >
                        @if ($errors->has('hs_code'))
                            <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('rate_per_ctn') ? 'has-error' : '' }}">
                        <label for="rate_per_ctn">Rate per ctn</label>
                        <input name="rate_per_ctn" type="number" id="rate_per_ctn" class="form-control"   value=""   required autofocus step="any"  placeholder="Rate per ctn" >
                        @if ($errors->has('rate_per_ctn'))
                            <span class="help-block"><strong>{{ $errors->first('rate_per_ctn') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ctn') ? 'has-error' : '' }}">
                        <label for="ctn">Ctn</label>
                        <input name="ctn" type="number" id="ctn" class="form-control"   value=""   required autofocus step="any"  placeholder="Ctn" >
                        @if ($errors->has('ctn'))
                            <span class="help-block"><strong>{{ $errors->first('ctn') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('pcs_in_ctn') ? 'has-error' : '' }}">
                        <label for="pcs_in_ctn">Pcs in ctn</label>
                        <input name="pcs_in_ctn" type="number" id="pcs_in_ctn" class="form-control"   value=""   required autofocus placeholder="Pcs in ctn" >
                        @if ($errors->has('pcs_in_ctn'))
                            <span class="help-block"><strong>{{ $errors->first('pcs_in_ctn') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('total_amount') ? 'has-error' : '' }}">
                        <label for="total_amount">Total amount</label>
                        <input name="total_amount" type="number" id="total_amount" class="form-control"   value=""   required autofocus step="any"  placeholder="Total amount" >
                        @if ($errors->has('total_amount'))
                            <span class="help-block"><strong>{{ $errors->first('total_amount') }}</strong></span>
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
<script>document.title = 'SaleContractDetail | Create';</script>
@endsection