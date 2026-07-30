@extends('layouts.master')
@section('content')
<style>
    .btn {
        padding: 4px 12px;
            padding-right: 12px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-image: none;
    }
    .form-group {
        margin-bottom: 2px;
    }
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1>SaleContract<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/sale_contract/create')}}"><i class="fa fa-dashboard"></i>sale_contract Create</a></li>
    </ol>
    <br>
</section>
<div class="row">    
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <form enctype="multipart/form-data" id="createForm">  
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                        
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
                        <label for="sales_contract_no">Sales contract no</label>
                        <input name="sales_contract_no" type="text" id="sales_contract_no" class="form-control input-sm"   value=""   required autofocus max="191"  placeholder="Sales contract no" >
                        @if ($errors->has('sales_contract_no'))
                            <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                        @endif
                    </div>
                </div> 

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('dated') ? 'has-error' : '' }}">
                        <label for="dated">Dated</label>
                        <input name="dated" type="text" id="dated"class="form-control datepicker input-sm"  value=""   required autofocus placeholder="Dated"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('dated'))
                            <span class="help-block"><strong>{{ $errors->first('dated') }}</strong></span>
                        @endif
                    </div>
                </div> 

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('invoice_no') ? 'has-error' : '' }}">
                        <label for="invoice_no">Invoice no</label>
                        <input name="invoice_no" type="text" id="invoice_no" class="form-control input-sm"   value=""  autofocus max="191"  placeholder="Invoice No" onkeyup="checkInvoiceNumberExistOrNot()" required="">
                        <span id="mobile_number_error" style="color: red;position: absolute;margin-top: -55px;margin-left: 107px;"></span>
                        @if ($errors->has('invoice_no'))
                            <span class="help-block"><strong>{{ $errors->first('invoice_no') }}</strong></span>
                        @endif
                    </div>
                </div> 

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('invoice_date') ? 'has-error' : '' }}">
                        <label for="invoice_date">invoice date</label>
                        <input name="invoice_date" type="text" id="invoice_date"class="form-control datepicker input-sm"  value=""  autofocus placeholder="invoice_date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('invoice_date'))
                            <span class="help-block"><strong>{{ $errors->first('invoice_date') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('export_no') ? 'has-error' : '' }}">
                        <label for="export_no">Exp no</label>
                        <input name="export_no" type="text" id="export_no" class="form-control input-sm"   value=""  autofocus max="191"  placeholder="Export No" >
                        @if ($errors->has('export_no'))
                            <span class="help-block"><strong>{{ $errors->first('export_no') }}</strong></span>
                        @endif
                    </div>
                </div> 
                 
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('export_date') ? 'has-error' : '' }}">
                        <label for="export_date">Exp date</label>
                        <input name="export_date" type="text" id="export_date"class="form-control datepicker input-sm"  value=""    autofocus placeholder="Export date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('export_date'))
                            <span class="help-block"><strong>{{ $errors->first('export_date') }}</strong></span>
                        @endif
                    </div>
                </div>  

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('discharge_port') ? 'has-error' : '' }}">
                        <label for="discharge_port">Discharge Port</label>
                        <input name="discharge_port" type="text" id="discharge_port" class="form-control input-sm"   value=""  autofocus max="191"  placeholder="Discharge Port" >
                        @if ($errors->has('discharge_port'))
                            <span class="help-block"><strong>{{ $errors->first('discharge_port') }}</strong></span>
                        @endif
                    </div>
                </div>  

                
                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('country_id') ? 'has-error' : '' }}">
                        <label for="country_id">Country </label>
                        <select name="country_id" id="country_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                             @foreach($countries as $country)
                             <option value="{{$country->id}}">{{$country->name}}</option>
                             @endforeach
                        </select>
                        @if ($errors->has('country_id'))
                            <span class="help-block"><strong>{{ $errors->first('country_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('sales_term_id') ? 'has-error' : '' }}">
                        <label for="sales_term_id">Sales term </label>
                        <select name="sales_term_id" id="sales_term_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                            <option value="">Select Sales term</option>
                            @foreach($sales_terms as $sales_term)
                             <option value="{{$sales_term->id}}">{{$sales_term->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('sales_term_id'))
                            <span class="help-block"><strong>{{ $errors->first('sales_term_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('company_id') ? 'has-error' : '' }}">
                        <label for="company_id">Company </label>
                        <select name="company_id" id="company_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
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

                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('bank_id') ? 'has-error' : '' }}">
                        <label for="bank_id">Bank </label>
                        <select name="bank_id" id="bank_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                            <option value="">Select Bank</option>
                           
                        </select>
                        @if ($errors->has('bank_id'))
                            <span class="help-block"><strong>{{ $errors->first('bank_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('importer_id') ? 'has-error' : '' }}">
                        <label for="importer_id">Importer </label>
                        <select name="importer_id" id="importer_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                            <option value="">Select Importer</option>
                            @foreach($importers as $importer)
                             <option value="{{$importer->id}}">{{$importer->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('importer_id'))
                            <span class="help-block"><strong>{{ $errors->first('importer_id') }}</strong></span>
                        @endif  
                    </div>
                </div> 
                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('bank_importer_id') ? 'has-error' : '' }}">
                        <label for="bank_importer_id">Importer Bank </label>
                        <select name="bank_importer_id" id="bank_importer_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                            <option value="">Select Importer</option>
                            @foreach($bank_importers as $bank_importer)
                             <option value="{{$bank_importer->id}}">{{$bank_importer->bank_name}} - {{$bank_importer->account_name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('bank_importer_id'))
                            <span class="help-block"><strong>{{ $errors->first('bank_importer_id') }}</strong></span>
                        @endif  
                    </div>
                </div>   

                
                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('notify_pary_id') ? 'has-error' : '' }}">
                        <label for="notify_pary_id">Notify pary </label>
                        <select name="notify_pary_id" id="notify_pary_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                            @if($notify_parties->count())
                            @foreach($notify_parties as $notify_partie)
                            <option value="{{$notify_partie->id}}" {{$id==$notify_partie->id ? 'selected="selected"' : '' }}>{{ $notify_partie->name}}
                            </option>
                            @endforeach
                            @endif

                        </select>
                        @if ($errors->has('notify_pary_id'))
                            <span class="help-block"><strong>{{ $errors->first('notify_pary_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('carrying_mode_id') ? 'has-error' : '' }}">
                        <label for="carrying_mode_id">Carrying mode </label>
                        <select name="carrying_mode_id" id="carrying_mode_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                            <option value="">Select Carrying mode</option>
                            @foreach($carrying_modes as $carrying_mode)
                             <option value="{{$carrying_mode->id}}">{{$carrying_mode->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('carrying_mode_id'))
                            <span class="help-block"><strong>{{ $errors->first('carrying_mode_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('loading_place_id') ? 'has-error' : '' }}">
                        <label for="loading_place_id">Loading place </label>
                        <select name="loading_place_id" id="loading_place_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                            <option value="">Select Loading place</option>
                            @foreach($loading_places as $loading_place)
                             <option value="{{$loading_place->id}}">{{$loading_place->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('loading_place_id'))
                            <span class="help-block"><strong>{{ $errors->first('loading_place_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('final_destination') ? 'has-error' : '' }}">
                        <label for="final_destination">Final destination</label>
                        <input name="final_destination" type="text" id="final_destination" class="form-control input-sm"   value=""   required autofocus max="191"  placeholder="Final destination" >
                        @if ($errors->has('final_destination'))
                            <span class="help-block"><strong>{{ $errors->first('final_destination') }}</strong></span>
                        @endif
                    </div>
                </div> 

                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('container_1') ? 'has-error' : '' }}">
                        <label for="container_1">Container_1(20 Feet)</label>    
                        <input name="container_1" type="text" id="container_1" class="form-control input-sm"   value="20 Feet"   autofocus max="191"  placeholder="container_1" readonly>
                        @if ($errors->has('container_1'))
                            <span class="help-block"><strong>{{ $errors->first('container_1') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group {{ $errors->has('container_qty_1') ? 'has-error' : '' }}">
                        <label for="container_qty_1">Qty</label>    
                        <input name="container_qty_1" type="text" id="positiveNumberInput" class="form-control input-sm"   value="0"   autofocus max="191"  placeholder="" >
                        @if ($errors->has('container_qty_1'))
                            <span class="help-block"><strong>{{ $errors->first('container_qty_1') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('container_2') ? 'has-error' : '' }}">
                        <label for="container_2">Container_2(40 Feet)</label>
                        <input name="container_2" type="text" id="container_2" class="form-control input-sm"   value="40 Feet"   autofocus max="191"  placeholder="container_2" readonly>
                        @if ($errors->has('container_2'))
                            <span class="help-block"><strong>{{ $errors->first('container_2') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group {{ $errors->has('container_qty_2') ? 'has-error' : '' }}">
                        <label for="container_qty_2">Qty</label>    
                        <input name="container_qty_2" type="text" id="positiveNumberInput" class="form-control input-sm"   value="0"   autofocus max="191"  placeholder="" >
                        @if ($errors->has('container_qty_2'))
                            <span class="help-block"><strong>{{ $errors->first('container_qty_2') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('container_3') ? 'has-error' : '' }}">
                        <label for="container_3">Container_3(40 HC)</label>
                        <input name="container_3" type="text" id="container_3" class="form-control input-sm"   value="40 HC"   autofocus max="191"  placeholder="container_3" readonly>
                        @if ($errors->has('container_3'))
                            <span class="help-block"><strong>{{ $errors->first('container_3') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group {{ $errors->has('container_qty_3') ? 'has-error' : '' }}">
                        <label for="container_qty_3">Qty</label>    
                        <input name="container_qty_3" type="text" id="positiveNumberInput" class="form-control input-sm"   value="0"   autofocus max="191"  placeholder="" >
                        @if ($errors->has('container_qty_3'))
                            <span class="help-block"><strong>{{ $errors->first('container_qty_3') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('freight_cost_1') ? 'has-error' : '' }}">
                        <label for="freight_cost_1">Freight_cost_1(20 Feet)</label>
                        <input name="freight_cost_1" type="text" id="freight_cost_1" class="form-control input-sm"   value="0"    autofocus max="191"  placeholder="freight_cost_1" >
                        @if ($errors->has('freight_cost_1'))
                            <span class="help-block"><strong>{{ $errors->first('freight_cost_1') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('freight_cost_2') ? 'has-error' : '' }}">
                        <label for="freight_cost_2">Freight_cost_2(40 Feet)</label>
                        <input name="freight_cost_2" type="text" id="freight_cost_2" class="form-control input-sm"   value="0"    autofocus max="191"  placeholder="freight_cost_2" >
                        @if ($errors->has('freight_cost_2'))
                            <span class="help-block"><strong>{{ $errors->first('freight_cost_2') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('freight_cost_3') ? 'has-error' : '' }}">
                        <label for="freight_cost_3">Freight_cost_3(40 HC)</label>
                        <input name="freight_cost_3" type="text" id="freight_cost_3" class="form-control input-sm"   value="0"    autofocus max="191"  placeholder="freight_cost_3" >
                        @if ($errors->has('freight_cost_3'))
                            <span class="help-block"><strong>{{ $errors->first('freight_cost_3') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('ci_note') ? 'has-error' : '' }}">
                        <label for="ci_note">Ci_note</label>
                        <input name="ci_note" type="text" id="ci_note" class="form-control input-sm"   value=""   autofocus max="191"  placeholder="ci_note">
                        @if ($errors->has('ci_note'))
                            <span class="help-block"><strong>{{ $errors->first('ci_note') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('angikar_given_by') ? 'has-error' : '' }}">
                        <label for="angikar_given_by">Angikar  Given By</label>
                        <textarea rows="5" name="angikar_given_by" type="text" id="angikar_given_by" class="form-control input-sm"      autofocus max="191"  placeholder="" ></textarea>
                        @if ($errors->has('angikar_given_by'))
                            <span class="help-block"><strong>{{ $errors->first('angikar_given_by') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('terms_and_condition') ? 'has-error' : '' }}">
                        <label for="terms_and_condition">Terms And Conditions</label>
                        <textarea rows="5" cols="3" name="terms_and_condition" type="text" id="terms_and_condition" class="form-control input-sm" required autofocus max="191"  placeholder="" >
@if(old('terms_and_condition')){{old('terms_and_condition')}}@else{{"1. PAYMENT BY TT.
2. TRANSPORT BY SEA. 
3. LOADING OF THE GOODS : WITHIN 90 DAYS FROM THE DATE OF SALES CONTRACT. 
4. PART SHIPMENT & TRANS-SHIPMENT ALLOWED. 
5. ALL BANKING CHARGES OUTSIDE BANGLADESH INCLUDING REMITTING CHARGES ARE ON APPLICANT'S ACCOUNT. 
6. MARKS: PRAN "}} 
@endif
                        </textarea>
                        @if ($errors->has('terms_and_condition'))
                            <span class="help-block"><strong>{{ $errors->first('terms_and_condition') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('terms_and_condition_desk_inv') ? 'has-error' : '' }}">
                        <label for="terms_and_condition_desk_inv">Terms And Conditions Desk com Inv</label>
                        <textarea rows="5" name="terms_and_condition_desk_inv" type="text" id="terms_and_condition_desk_inv" class="form-control input-sm"     autofocus max="191"  placeholder="" ></textarea>
                        @if ($errors->has('terms_and_condition_desk_inv'))
                            <span class="help-block"><strong>{{ $errors->first('terms_and_condition_desk_inv') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('importer_country') ? 'has-error' : '' }}">
                        <label for="importer_country">Importer Country</label>
                        <input name="importer_country" type="text" id="importer_country" class="form-control input-sm"   value=""   max="191"  placeholder="importer_country" >
                        @if ($errors->has('importer_country'))
                            <span class="help-block"><strong>{{ $errors->first('importer_country') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <label for="formated_file">Formatted File</label>
                    <input name="formated_file" type="file" id="fiformated_filele" class="form-control input-sm"   value=""   autofocus   >
                    <input type="hidden" name="notify_id" id="notify_id" value="{{$id}}">
                </div>
                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('po_id') ? 'has-error' : '' }}">
                        <label for="po_id">PO Number</label>
                        <select name="po_id" id="po_id" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1" required>
                            <option value="">Select</option>
                            
                        </select>
                        @if ($errors->has('bank_id'))
                            <span class="help-block"><strong>{{ $errors->first('bank_id') }}</strong></span>
                        @endif  
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('currency_id') ? 'has-error' : '' }}">
                        <label for="currency_id">Currency</label>
                        <select name="currency_id" id="currency_id" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1" required>
                            <option value="">Select</option>
                            @foreach($currency as $value)
                             <option value="{{$value->id}}" @if($value->id==1) {{'selected'}} @endif>{{$value->currency_name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('currency_id'))
                            <span class="help-block"><strong>{{ $errors->first('currency_id') }}</strong></span>
                        @endif  
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                        <label for="is_revised" >Is revised</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="is_revised"   value="1"   id="is_revised"  autofocus >Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_revised"  value="0"  checked>No
                        </label>
                        @if ($errors->has('is_revised'))
                            <span class="help-block"><strong>{{ $errors->first('is_revised') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-3">
                    <div class="form-group form-group {{ $errors->has('is_proforma_invoice') ? 'has-error' : '' }}">
                        <label for="is_proforma_invoice" >Is proforma invoice</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="is_proforma_invoice"   value="1"   id="is_proforma_invoice"  autofocus >Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_proforma_invoice"  value="0"  checked>No
                        </label>
                        @if ($errors->has('is_proforma_invoice'))
                            <span class="help-block"><strong>{{ $errors->first('is_proforma_invoice') }}</strong></span>
                        @endif
                    </div>
                </div> 

                <div class="col-sm-3">
                    <div class="form-group form-group {{ $errors->has('is_master') ? 'has-error' : '' }}">
                        <label for="is_master" >Is Master</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="is_master"   value="1"   id="is_master"  autofocus >Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_master"  value="0"  checked>No
                        </label>
                        @if ($errors->has('is_master'))
                            <span class="help-block"><strong>{{ $errors->first('is_master') }}</strong></span>
                        @endif
                    </div>
                </div> 
                 <div class="col-sm-3">
                    <div class="form-group form-group {{ $errors->has('footer_importer_address') ? 'has-error' : '' }}">
                        <label for="footer_importer_address" >Footer importer address</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="footer_importer_address"   value="1"   id="footer_importer_address"  autofocus >Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="footer_importer_address" checked  value="0" >No
                        </label>
                        @if ($errors->has('footer_importer_address'))
                            <span class="help-block"><strong>{{ $errors->first('footer_importer_address') }}</strong></span>
                        @endif
                    </div>
                </div>   
                <div class="col-sm-5"></div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-info btn-flat"  id="nextButton" style="margin-top: 22px">Create Sales Contract</button> 
                </div>
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
        </div>
           <!-- /.box -->  


<script>document.title = 'SaleContract | Create';</script>
<script type="text/javascript">
    
    setTimeout(function() { 
          $('.sr-only').click();
    }, 0.0001);

    $('#positiveNumberInput').keypress(function(event) {
        var keyCode = event.which;
        if (keyCode !== 8 && keyCode !== 0 && (keyCode < 48 || keyCode > 57)) {
        event.preventDefault();
        }
    });
    //@@@Submit Create Form@@@@
    $("#createForm").submit(function (e) {

        e.preventDefault(); 
        var formData = new FormData($(this)[0]);
        var excelFile = formData.get('formated_file');
        $.ajax({
            type:'POST',
            url: "{{ url('/sale_contract')}}",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: (res) => {
                
                if(res.code==200){
                
                   Swal.fire({
                       position: 'top-end',
                       icon: 'success',
                       title: 'Create Successfully Done..!!',
                       showConfirmButton: false,
                       timer: 1500
                   });

                   resetFrom();
                
                }else if(res.code==500){

                   Swal.fire({
                       icon: 'error',
                       title: 'Oops...',
                       text: 'Something went wrong!'
                   });

                }else if(res.code==409){
                      
                    Swal.fire({
                       icon: 'warning',
                       title: 'Oops...',
                       text: 'Already exist this invoice..!'
                   }); 

                }
                                      
            },
            error: function(data){

                console.log(data);
                
            }
        });

    }); //@@@@-End Submit Create Form

    function resetFrom() {

        $("#createForm")[0].reset();
        $('#country_id').val('').selectpicker('refresh');
        $('#sales_term_id').val('').selectpicker('refresh');
        $('#company_id').val('').selectpicker('refresh');
        $('#bank_id').val('').selectpicker('refresh');
        $('#importer_id').val('').selectpicker('refresh');
        $('#bank_importer_id').val('').selectpicker('refresh');
        $('#carrying_mode_id').val('').selectpicker('refresh');
        $('#loading_place_id').val('').selectpicker('refresh');
        $('#po_id').val('').selectpicker('refresh');

    }

    function loadPO(){
            
        var notify_pary_id=$('#notify_id').val();
        var url = "{{url('/')}}"+"/json/get_sc_create_po_list?party_id="+notify_pary_id;
        var $el = $('#po_id');
        $.get(url,function(data) {

            if(!data){

                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("---"));
                $el.selectpicker('destroy');

            }else{

                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function(key,value) {
                    $el.append($("<option></option>").attr("value", value['PO_NO']).text(value['PO_NO']));
                });
                $el.selectpicker('refresh');
            }

        }); 
            
    }  
        
    loadPO();
    
    $("#company_id").change(function(){

        var company_id = $(this).val();
        var url = "{{url('/')}}"+"/json/get_company_bank?company_id="+company_id;
        var $el = $('#bank_id');
        $.get( url, function( data ) {
            if(!data){
                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("---"));
                $el.selectpicker('destroy');
            }else{

                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function(key,value) {
                    $el.append($("<option></option>").attr("value", value['id']).text(value['name']));
                });
                $el.selectpicker('refresh');
            }

        }); // get end

    });

    $("#currency_id").change(function(){

        var currency_id = $(this).val();
        var url = "{{url('/')}}"+"/json/get_currency_rate?currency_id="+currency_id;
        $.get( url, function(data) {
            
            Swal.fire({
                text: "Your Executable Rate: "+data.rate,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
               
            })

        });

    });

    function checkInvoiceNumberExistOrNot(){


        var invoice_no=document.getElementById('invoice_no').value;
        $.ajax({
            type: "GET",
            url: "{{url('/check/invoice/number/exist/ornot')}}?invoice_no=" + invoice_no,
            success: function (data) {

                console.log(data);

                if(data=='1'){
    
                    document.getElementById('mobile_number_error').innerHTML="Already Exists..!!";
                    $('#nextButton').prop("disabled", true);

                }else{

                    document.getElementById('mobile_number_error').innerHTML="Not Exists..!!";
                    $('#nextButton').removeAttr('disabled');
                }
            
            }
        });

    }
</script>
@endsection