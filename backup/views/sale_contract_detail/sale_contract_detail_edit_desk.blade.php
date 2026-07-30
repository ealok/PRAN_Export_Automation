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
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Edit FROM DESK</h3>
             </div><!-- /.box-header-end -->
            <form class="" role="form" method="POST" action="{{url('/sale_contract_detail')}}/{{\Crypt::encrypt($sale_contract_detail->id)}}/update_desk">
                {{ csrf_field() }}
                {{ method_field('PUT') }} 
                <!-- /.box-body-start -->    
                <div class="box-body">         
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('ci_item_id') ? 'has-error' : '' }}">
                        <label for="ci_item_id">CI Item </label>
                        <select name="ci_item_id" id="ci_item_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                            <option value="">Select Ci item</option>
                            @foreach($ci_items as $ci_item)
                             <option value="{{$ci_item->id}}"  @if($ci_item->id == $sale_contract_detail->ci_item_id){{"selected"}} @endif >{{$ci_item->ci_item_code}} - {{$ci_item->ci_item_name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('ci_item_id'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    
                {{-- @if(!$sale_contract->desk_approver_id) --}}
                <input name="sale_contract_id" id="sale_contract_id" type="hidden"  value="{{$sale_contract_detail->sale_contract_id}}" >
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ctn') ? 'has-error' : '' }}">
                        <label for="ctn">Ctn(Qty)</label>
                        <input  type="" name="ctn"  type="number" id="ctn" class="form-control"   value="{{$sale_contract_detail->ctn}}"   required autofocus step="any"  placeholder="Ctn" {{$sale_contract->desk_approver_id ? 'readonly' : ''}}>
                        @if ($errors->has('ctn'))
                            <span class="help-block"><strong>{{ $errors->first('ctn') }}</strong></span>
                        @endif
                    </div>
                </div>  
                {{-- @endif --}}
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('rate_per_ctn_for_acc') ? 'has-error' : '' }}">
                        <label for="rate_per_ctn_for_acc">Rate/Ctn(Acct)</label>
                        <input name="rate_per_ctn_for_acc" type="number" id="rate_per_ctn_for_acc" class="form-control"   value="{{$sale_contract_detail->rate_per_ctn_for_acc}}"   required autofocus step="any"  placeholder="Rate per ctn" readonly="true">
                        @if ($errors->has('rate_per_ctn_for_acc'))
                            <span class="help-block"><strong>{{ $errors->first('rate_per_ctn_for_acc') }}</strong></span>
                        @endif
                    </div>
                </div>  

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('rate_per_ctn_for_party') ? 'has-error' : '' }}">
                        <label for="rate_per_ctn_for_party">Rate/Ctn (Party)</label>
                        <input name="rate_per_ctn_for_party" type="number" id="rate_per_ctn_for_party" class="form-control"   value="{{$sale_contract_detail->rate_per_ctn_for_party}}"   required autofocus step="any"  placeholder="Rate per ctn" >
                        @if ($errors->has('rate_per_ctn_for_party'))
                            <span class="help-block"><strong>{{ $errors->first('rate_per_ctn_for_party') }}</strong></span>
                        @endif
                    </div>
                </div> 

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('total_amount_acc') ? 'has-error' : '' }}">
                        <label for="total_amount_acc">Total Amount</label>
                        <input name="total_amount_acc" type="number" readonly="true" id="total_amount_acc" class="form-control"   value="{{$sale_contract_detail->total_amount_acc}}"   required autofocus step="any"  placeholder="Total amount" >
                        @if ($errors->has('total_amount_acc'))
                            <span class="help-block"><strong>{{ $errors->first('total_amount_acc') }}</strong></span>
                        @endif
                    </div>
                </div>   

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('total_amount_party') ? 'has-error' : '' }}">
                        <label for="total_amount_party">Total Amount(Party)</label>
                        <input name="total_amount_party" type="number" readonly="true" id="total_amount_party" class="form-control"   value="{{$sale_contract_detail->total_amount_party}}"   required autofocus step="any"  placeholder="Total amount" >
                        @if ($errors->has('total_amount_party'))
                            <span class="help-block"><strong>{{ $errors->first('total_amount_party') }}</strong></span>
                        @endif
                    </div>
                </div>  
                
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('desk_item_name') ? 'has-error' : '' }}">
                        <label for="desk_item_name">Desk Item Name</label>
                        <input name="desk_item_name" type="text" id="desk_item_name" class="form-control"   value="{{ $sale_contract_detail->desk_item_name }}"   required autofocus step="any"  placeholder="desk_item_name" >
                        @if ($errors->has('desk_item_name'))
                            <span class="help-block"><strong>{{ $errors->first('desk_item_name') }}</strong></span>
                        @endif
                    </div>
                </div> 

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('hs_code') ? 'has-error' : '' }}">
                        <label for="hs_code">HS Code</label>
                        <input name="hs_code" type="text" id="hs_code"class="form-control"  value="{{ $sale_contract_detail->hs_code }}"   required  placeholder="hs_code"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('hs_code'))
                            <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('hs_code_2') ? 'has-error' : '' }}">
                        <label for="hs_code_2">HS Code2</label>
                        <input name="hs_code_2" type="text" id="hs_code_2"class="form-control"  value="{{ $sale_contract_detail->hs_code_2 }}"    placeholder="hs_code_2"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('hs_code_2'))
                            <span class="help-block"><strong>{{ $errors->first('hs_code_2') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('safta_percentage') ? 'has-error' : '' }}">
                        <label for="safta_percentage">Safta Percentage(For India)</label>
                        <input name="safta_percentage" type="text" id="safta_percentage"class="form-control"  value="{{ $sale_contract_detail->safta_percentage}}"     placeholder="safta_percentage"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('safta_percentage'))
                            <span class="help-block"><strong>{{ $errors->first('safta_percentage') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('cbm_per_ctn') ? 'has-error' : '' }}">
                        <label for="cbm_per_ctn">CBM/Ctn</label>
                        <input name="cbm_per_ctn" type="text" id="cbm_per_ctn" readonly="true" class="form-control"  value="{{ $sale_contract_detail->cbm_per_ctn }}"   required  placeholder="cbm_per_ctn"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('cbm_per_ctn'))
                            <span class="help-block"><strong>{{ $errors->first('cbm_per_ctn') }}</strong></span>
                        @endif
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('mfg') ? 'has-error' : '' }}">
                        <label for="mfg">MFG Date</label>
                        <input name="mfg" type="text" id="mfg"class="form-control datepicker"  value="@if($sale_contract_detail->mfg!='0000-00-00'){{$sale_contract_detail->mfg}}@else{{''}}@endif"    placeholder="mfg"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('mfg'))
                            <span class="help-block"><strong>{{ $errors->first('mfg') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('exp') ? 'has-error' : '' }}">
                        <label for="exp">Exp Date</label>
                        <input name="exp" type="text" id="exp"class="form-control datepicker"  value="@if($sale_contract_detail->exp!='0000-00-00'){{$sale_contract_detail->exp}}@else{{''}}@endif"     placeholder="exp"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('exp'))
                            <span class="help-block"><strong>{{ $errors->first('exp') }}</strong></span>
                        @endif
                    </div>
                </div>  
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('container_no') ? 'has-error' : '' }}">
                        <label for="container_no">Container No</label>
                        <input name="container_no" type="text" id="container_no" class="form-control"   value="{{$sale_contract_detail->container_no}}"  placeholder="Container No" >
                        @if ($errors->has('container_no'))
                            <span class="help-block"><strong>{{ $errors->first('container_no') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('batch_no') ? 'has-error' : '' }}">
                        <label for="batch_no">Batch No</label>
                        <input name="batch_no" type="text" id="batch_no" class="form-control"   value="{{$sale_contract_detail->batch_no}}" placeholder="Container No" >
                        @if ($errors->has('batch_no'))
                            <span class="help-block"><strong>{{ $errors->first('batch_no') }}</strong></span>
                        @endif
                        <input type="hidden" name="party_id" value="{{$party_id}}">
                    </div>
                </div>
                {{-- @if(!$sale_contract->desk_approver_id) --}}
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('batch_no') ? 'has-error' : '' }}">
                        <label for="batch_no">Gross Weight</label>
                        <input name="gross_weight" type="text" id="gross_weight" class="form-control"   value="{{$item_gross_weight->gross_weight}}" placeholder="Container No" {{$sale_contract->desk_approver_id ? 'readonly' : ''}}>
                        @if ($errors->has('batch_no'))
                            <span class="help-block"><strong>{{ $errors->first('batch_no') }}</strong></span>
                        @endif
                    </div>
                </div>
                {{-- @endif --}}
                <div class="col-sm-6"></div>
                <div class="col-sm-2"><button type="submit" class="btn btn-info pull-right btn-flat" style="margin-top: 25px;">Update</button></div> 
                </div>                 
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'SaleContractDetail | Edit';
$("#ctn, #rate_per_ctn_for_party").change(function(){
   var ctn = $('#ctn').val();
   var rate_per_ctn = $('#rate_per_ctn_for_party').val();
   $('#total_amount_party').val(ctn*rate_per_ctn);
});

$("#ctn,#rate_per_ctn_for_acc").change(function(){
   var ctn = $('#ctn').val();
   var rate_per_ctn = $('#rate_per_ctn_for_acc').val();
   $('#total_amount_acc').val(ctn*rate_per_ctn);
});


$("#ci_item_id").change(function(){
    var ci_item_id = $("#ci_item_id").val();
    var notify_pary_id = '{{$sale_contract_detail->sale_contract->notify_pary_id}}';
    var ctn = $('#ctn').val();
    var url = "{{url('/')}}"+"/json/get_item_reate_for_notify_party?ci_item_id="+ci_item_id+"&notify_party_id="+notify_pary_id;
    
    $.get( url, function( data ) {
        if(!data){
            alert("no rate defined");
            $('#total_amount_acc').val(0);
            $('#total_amount_party').val(0);
        }else{
           $('#rate_per_ctn_for_acc').val(data['acc_rate']);
           $('#rate_per_ctn_for_party').val(data['party_rate']);
           $('#cbm_per_ctn').val(data['cbm_per_ctn']);
           
           $('#desk_item_name').val(data['desk_item_name']);
           $('#hs_code').val(data['hs_code']);

           $('#total_amount_acc').val(ctn*data['acc_rate']);
           $('#total_amount_party').val(ctn*data['party_rate']);
           
        }

    }); // get end
})



</script>
@endsection


