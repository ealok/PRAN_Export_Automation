@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>SaleContractDetail<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{ route('sale_contract_detail.update',$sale_contract_detail->id ) }}"><i class="fa fa-dashboard"></i>sale_contract_detail Update</a></li>
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
           <div class="box box-info">
             <div class="box-header with-border">
               <h3 class="box-title">Detail edit (CI)</h3>
             </div>
            <form class="" role="form" method="POST" action="{{ route('sale_contract_detail.update',\Crypt::encrypt($sale_contract_detail->id))}}">
                {{ csrf_field() }}
                {{ method_field('PUT') }}   
                 <div class="box-body"> 
                   <div class="row">     
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('ci_item_id') ? 'has-error' : '' }}">
                                <label for="ci_item_id">Item Name</label>
                                <input type="hidden" name="ci_item_id" value="{{$sale_contract_detail->ci_item_id}}">
                                <input class="form-control" value="{{$sale_contract_detail->ci_item->ci_item_code}}  -{{$sale_contract_detail->ci_item->ci_item_name}}"> 
                            </div>
                        </div>    
                        <input name="sale_contract_id" id="sale_contract_id" type="hidden"  value="{{$sale_contract_detail->sale_contract_id}}" >
                        <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('rate_per_ctn') ? 'has-error' : '' }}">
                                <label for="rate_per_ctn">Rate/CI</label>
                                <input name="rate_per_ctn" type="number" id="rate_per_ctn" class="form-control"   value="{{$sale_contract_detail->rate_per_ctn}}"   required autofocus step="any"  placeholder="Rate per ctn" >
                                @if ($errors->has('rate_per_ctn'))
                                    <span class="help-block"><strong>{{ $errors->first('rate_per_ctn') }}</strong></span>
                                @endif
                            </div>
                        </div> 
                   </div>
                   <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('ci_item_name') ? 'has-error' : '' }}">
                                <label for="ci_item_name">Item Name</label>
                                <input name="ci_item_name" type="text" id="ci_item_name" class="form-control"   value="{{$sale_contract_detail->ci_item_name}}"   required autofocus step="any"  placeholder="ci item name" >
                                @if ($errors->has('ci_item_name'))
                                    <span class="help-block"><strong>{{ $errors->first('ci_item_name') }}</strong></span>
                                @endif
                            </div>
                        </div> 
                        <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('hs_code') ? 'has-error' : '' }}">
                                <label for="hs_code">HS Code</label>
                                <input name="hs_code" type="text" id="hs_code" class="form-control"   value="{{$sale_contract_detail->hs_code}}"   required autofocus step="any"  placeholder="Enter hs code" >
                                @if ($errors->has('ci_item_name'))
                                    <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                                @endif
                            </div>
                        </div> 
                   </div>  
                   <div class="row"> 
                        <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('total_amount') ? 'has-error' : '' }}">
                                <label for="total_amount">Total Amount</label>
                                <input name="total_amount" type="number" id="total_amount"  readonly="true" class="form-control"   value="{{$sale_contract_detail->total_amount}}"   required autofocus step="any"  placeholder="Total amount" >
                                @if ($errors->has('total_amount'))
                                    <span class="help-block"><strong>{{ $errors->first('total_amount') }}</strong></span>
                                @endif
                            </div>
                            <input type="hidden" name="party_id" value="{{$party_id}}">
                        </div>    
                        <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('ctn') ? 'has-error' : '' }}">
                                <label for="ctn">Ctn(Qty)</label>
                                <input name="ctn" type="number" id="ctn" class="form-control" readonly="true"  value="{{$sale_contract_detail->ctn}}"   required autofocus step="any"  placeholder="Ctn" >
                                @if ($errors->has('ctn'))
                                    <span class="help-block"><strong>{{ $errors->first('ctn') }}</strong></span>
                                @endif
                            </div>
                        </div> 
                   </div>       
                   <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('rate_per_ctn_for_party') ? 'has-error' : '' }}">
                            <label for="rate_per_ctn_for_party" style="display: none">Rate/Ctn(Party)</label>
                            <input name="rate_per_ctn_for_party" type="hidden" id="rate_per_ctn_for_party" class="form-control"   value="{{$sale_contract_detail->rate_per_ctn_for_party}}"  readonly="true" autofocus step="any"  placeholder="Rate per ctn" >
                            @if ($errors->has('rate_per_ctn_for_party'))
                                <span class="help-block"><strong>{{ $errors->first('rate_per_ctn_for_party') }}</strong></span>
                            @endif
                        </div>
                    </div> 
                {{-- <!-- <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('pcs_in_ctn') ? 'has-error' : '' }}">
                        <label for="pcs_in_ctn">Pcs in ctn</label>
                        <input name="pcs_in_ctn" type="number" id="pcs_in_ctn"  class="form-control"   value="{{$sale_contract_detail->pcs_in_ctn}}"   required autofocus placeholder="Pcs in ctn" >
                        @if ($errors->has('pcs_in_ctn'))
                            <span class="help-block"><strong>{{ $errors->first('pcs_in_ctn') }}</strong></span>
                        @endif
                    </div>
                </div>     --> --}}   
                 </div> 
                 <!-- /.box-body -->
                 <div class="box-footer">
                   <button type="submit" class="btn btn-info pull-right btn-flat">Update</button>
                 </div>
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'SaleContractDetail | Edit';
$("#ctn,#rate_per_ctn").change(function(){
   var ctn = $('#ctn').val();
   var rate_per_ctn = $('#rate_per_ctn').val();
   $('#total_amount').val(ctn*rate_per_ctn);
});
</script>
@endsection