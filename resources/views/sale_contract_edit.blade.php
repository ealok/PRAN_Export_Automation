<?php use App\Http\Controllers\AdminController;?>
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
    <h1>Sales Contract Edit<small></small></h1>
    <br>
</section>
<div class="row">
        <div class="col-md-12">
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> {{ Session::get('success') }}
            </div> 
        @endif 
        @if(Session::has('danger'))
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> {{ Session::get('danger') }}
            </div>
        @endif
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <form enctype="multipart/form-data" id="UpdateForm">
                {{ csrf_field() }}
                <!-- /.box-body-start -->    
                <div class="box-body"> 
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
                    <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
                        <label for="sales_contract_no">Sales Contract No</label>
                        <input name="sales_contract_no" type="text" id="sales_contract_no" class="form-control input-sm"   value="{{$sale_contract->sales_contract_no}}"   required  max="191"  placeholder="Sales contract no" >
                        @if ($errors->has('sales_contract_no'))
                            <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('dated') ? 'has-error' : '' }}">
                        <label for="dated">Sales Contract Dated</label>
                        <input name="dated" type="text" id="dated"class="form-control datepicker input-sm"  value="{{date('d-m-Y', strtotime($sale_contract->dated))}}"   required  placeholder="Dated"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('dated'))
                            <span class="help-block"><strong>{{ $errors->first('dated') }}</strong></span>
                        @endif
                    </div>
                </div>  
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('invoice_no') ? 'has-error' : '' }}">
                        <label for="invoice_no">Invoice No</label>
                        <input name="invoice_no" type="text" id="invoice_no" class="form-control input-sm"   value="{{ $sale_contract->invoice_no }}"   max="191"  placeholder="Invoice No" onkeyup="checkInvoiceNumberExistOrNot()" required="">
                        <span id="mobile_number_error" style="color: red"></span>
                        @if ($errors->has('invoice_no'))
                            <span class="help-block"><strong>{{ $errors->first('invoice_no') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('invoice_date') ? 'has-error' : '' }}">
                        <label for="invoice_date">Invoice Date</label>
                        <input name="invoice_date" type="text" id="invoice_date" class="form-control datepicker input-sm"  value="@if($sale_contract->invoice_date){{date('d-m-Y', strtotime($sale_contract->invoice_date))}}@endif"   placeholder="invoice_date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('invoice_date'))
                            <span class="help-block"><strong>{{ $errors->first('invoice_date') }}</strong></span>
                        @endif
                    </div>
                </div>                
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('export_no') ? 'has-error' : '' }}">
                        <label for="export_no">Exp No</label>
                        <input name="export_no" type="text" id="export_no" class="form-control input-sm"   value="{{ $sale_contract->export_no}}"   max="191"  placeholder="Export No" >
                        @if ($errors->has('export_no'))
                            <span class="help-block"><strong>{{ $errors->first('export_no') }}</strong></span>
                        @endif
                    </div>
                </div> 
                 
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('export_date') ? 'has-error' : '' }}">
                        <label for="export_date">Exp Date</label>
                        <input name="export_date" type="text" id="export_date"class="form-control datepicker input-sm"  value="@if($sale_contract->export_date){{date('d-m-Y', strtotime($sale_contract->export_date))}}@endif"     placeholder="Export date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('export_date'))
                            <span class="help-block"><strong>{{ $errors->first('export_date') }}</strong></span>
                        @endif
                    </div>
                </div>  

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('discharge_port') ? 'has-error' : '' }}">
                        <label for="discharge_port">Discharge Port</label>
                        <input name="discharge_port" type="text" id="discharge_port" class="form-control input-sm"   value="{{ $sale_contract->discharge_port }}"   max="191"  placeholder="Discharge Port" >
                        @if ($errors->has('discharge_port'))
                            <span class="help-block"><strong>{{ $errors->first('discharge_port') }}</strong></span>
                        @endif
                    </div>
                </div>  

                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('country_id') ? 'has-error' : '' }}">
                        <label for="country_id">Country </label>
                        <select name="country_id" id="country_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                             <option value="{{$country->id}}"  @if($country->id == $sale_contract->country_id){{"selected"}} @endif >{{$country->name}}</option>
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
                        <select name="sales_term_id" id="sales_term_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                            <option value="">Select Sales term</option>
                            @foreach($sales_terms as $sales_term)
                             <option value="{{$sales_term->id}}"  @if($sales_term->id == $sale_contract->sales_term_id){{"selected"}} @endif >{{$sales_term->name}}</option>
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
                        <select name="company_id" id="company_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                             <option value="{{$company->id}}"@if($company->id == $sale_contract->company_id){{"selected"}} @endif >{{$company->name}}</option>
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
                        <select name="bank_id" id="bank_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                            <option value="">Select Bank</option>
                            @foreach($banks as $bank)
                             <option value="{{$bank->id}}"  @if($bank->id == $sale_contract->bank_id){{"selected"}} @endif >{{$bank->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('bank_id'))
                            <span class="help-block"><strong>{{ $errors->first('bank_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('importer_id') ? 'has-error' : '' }}">
                        <label for="importer_id">Importer </label>
                        <select name="importer_id" id="importer_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                            <option value="">Select Importer</option>
                            @foreach($importers as $importer)
                             <option value="{{$importer->id}}"  @if($importer->id == $sale_contract->importer_id){{"selected"}} @endif >{{$importer->name}}</option>
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
                        <select name="bank_importer_id" id="bank_importer_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"   value="1" >
                            <option value="">Select Importer</option>
                            @foreach($bank_importers as $bank_importer)
                             <option value="{{$bank_importer->id}}" @if($bank_importer->id == $sale_contract->bank_importer_id){{"selected"}} @endif>{{$bank_importer->bank_name}} - {{$bank_importer->account_name}}</option>
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
                        <select name="notify_pary_id" id="notify_pary_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                            <option value="">Select Notify pary</option>
                            @foreach($notify_parties as $notify_party)
                             <option value="{{$notify_party->id}}"  @if($notify_party->id == $sale_contract->notify_pary_id){{"selected"}} @endif >{{$notify_party->code}} - {{$notify_party->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('notify_pary_id'))
                            <span class="help-block"><strong>{{ $errors->first('notify_pary_id') }}</strong></span>
                        @endif  
                    </div>
                </div>  
                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('carrying_mode_id') ? 'has-error' : '' }}">
                        <label for="carrying_mode_id">Carrying mode </label>
                        <select name="carrying_mode_id" id="carrying_mode_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                            <option value="">Select Carrying mode</option>
                            @foreach($carrying_modes as $carrying_mode)
                             <option value="{{$carrying_mode->id}}"  @if($carrying_mode->id == $sale_contract->carrying_mode_id){{"selected"}} @endif >{{$carrying_mode->name}}</option>
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
                        <select name="loading_place_id" id="loading_place_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                            <option value="">Select Loading place</option>
                            @foreach($loading_places as $loading_place)
                             <option value="{{$loading_place->id}}"  @if($loading_place->id == $sale_contract->loading_place_id){{"selected"}} @endif >{{$loading_place->name}}</option>
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
                        <input name="final_destination" type="text" id="final_destination" class="form-control input-sm"   value="{{$sale_contract->final_destination}}"   required  max="191"  placeholder="Final destination" >
                        @if ($errors->has('final_destination'))
                            <span class="help-block"><strong>{{ $errors->first('final_destination') }}</strong></span>
                        @endif
                    </div>
                </div> 
                 <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('importer_country') ? 'has-error' : '' }}">
                        <label for="importer_country">Importer Country</label>
                        <input name="importer_country" type="text" id="importer_country" class="form-control input-sm"   value="{{ $sale_contract->importer_country }}"   max="191"  placeholder="importer_country" >
                        @if ($errors->has('importer_country'))
                            <span class="help-block"><strong>{{ $errors->first('importer_country') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('container_1') ? 'has-error' : '' }}">
                        <label for="container_1">container_1(20 FEET)</label>
                        <input name="container_1" type="text" id="container_1" class="form-control input-sm"   value="20 Feet"   autofocus max="191"  placeholder="container_1" readonly>
                        @if ($errors->has('container_1'))
                            <span class="help-block"><strong>{{ $errors->first('container_1') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group {{ $errors->has('container_qty_1') ? 'has-error' : '' }}">
                        <label for="container_qty_1">Qty</label>    
                        <input name="container_qty_1" type="text" id="positiveNumberInput" class="form-control input-sm"   value="{{$container_qty1}}"   autofocus max="191"  placeholder="">
                        @if ($errors->has('container_qty_1'))
                            <span class="help-block"><strong>{{ $errors->first('container_qty_1') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('container_2') ? 'has-error' : '' }}">
                        <label for="container_2">container_2(40 FEET)</label>
                        <input name="container_2" type="text" id="container_2" class="form-control input-sm"   value="40 Feet"   autofocus max="191"  placeholder="container_2" readonly>
                        @if ($errors->has('container_2'))
                            <span class="help-block"><strong>{{ $errors->first('container_2') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group {{ $errors->has('container_qty_2') ? 'has-error' : '' }}">
                        <label for="container_qty_2">Qty</label>    
                        <input name="container_qty_2" type="text" id="positiveNumberInput" class="form-control input-sm"   value="{{$container_qty2}}"   autofocus max="191"  placeholder="">
                        @if ($errors->has('container_qty_2'))
                            <span class="help-block"><strong>{{ $errors->first('container_qty_2') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('container_3') ? 'has-error' : '' }}">
                        <label for="container_3">container_3(40 HC)</label>
                        <input name="container_3" type="text" id="container_3" class="form-control input-sm"   value="40 HC"  autofocus max="191"  placeholder="container_3" readonly>
                        @if ($errors->has('container_3'))
                            <span class="help-block"><strong>{{ $errors->first('container_3') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group {{ $errors->has('container_qty_3') ? 'has-error' : '' }}">
                        <label for="container_qty_3">Qty</label>    
                        <input name="container_qty_3" type="text" id="positiveNumberInput" class="form-control input-sm"   value="{{$container_qty3}}"   autofocus max="191"  placeholder="">
                        @if ($errors->has('container_qty_3'))
                            <span class="help-block"><strong>{{ $errors->first('container_qty_3') }}</strong></span>
                        @endif
                    </div>
                </div>
                @if($sale_contract->desk_approver_id)
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('freight_cost_1') ? 'has-error' : '' }}">
                        <label for="freight_cost_1">freight_cost_1(20 FEET)</label>
                        <input name="freight_cost_1" type="text" id="freight_cost_1" class="form-control input-sm"   value="{{$sale_contract->freight_cost_1}}"    autofocus max="191"  placeholder="freight_cost_1" readonly="">
                        @if ($errors->has('freight_cost_1'))
                            <span class="help-block"><strong>{{ $errors->first('freight_cost_1') }}</strong></span>
                        @endif
                    </div>
                </div>
                @else
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('freight_cost_1') ? 'has-error' : '' }}">
                        <label for="freight_cost_1">freight_cost_1(20 FEET)</label>
                        <input name="freight_cost_1" type="text" id="freight_cost_1" class="form-control input-sm"   value="{{$sale_contract->freight_cost_1}}"    autofocus max="191"  placeholder="freight_cost_1">
                        @if ($errors->has('freight_cost_1'))
                            <span class="help-block"><strong>{{ $errors->first('freight_cost_1') }}</strong></span>
                        @endif
                    </div>
                </div>
                @endif
                @if($sale_contract->desk_approver_id)
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('freight_cost_2') ? 'has-error' : '' }}">
                        <label for="freight_cost_2">freight_cost_2(40 FEET)</label>
                        <input name="freight_cost_2" type="text" id="freight_cost_2" class="form-control input-sm"   value="{{$sale_contract->freight_cost_2}}"    autofocus max="191"  placeholder="freight_cost_2" readonly="">
                        @if ($errors->has('freight_cost_2'))
                            <span class="help-block"><strong>{{ $errors->first('freight_cost_2') }}</strong></span>
                        @endif
                    </div>
                </div>
                @else
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('freight_cost_2') ? 'has-error' : '' }}">
                        <label for="freight_cost_2">freight_cost_2(40 FEET)</label>
                        <input name="freight_cost_2" type="text" id="freight_cost_2" class="form-control input-sm"   value="{{$sale_contract->freight_cost_2}}"    autofocus max="191"  placeholder="freight_cost_2">
                        @if ($errors->has('freight_cost_2'))
                            <span class="help-block"><strong>{{ $errors->first('freight_cost_2') }}</strong></span>
                        @endif
                    </div>
                </div>
                @endif
                @if($sale_contract->desk_approver_id)
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('freight_cost_3') ? 'has-error' : '' }}">
                        <label for="freight_cost_3">freight_cost_3(40 HC)</label>
                        <input name="freight_cost_3" type="text" id="freight_cost_3" class="form-control input-sm"   value="{{$sale_contract->freight_cost_3}}"   autofocus max="191"  placeholder="freight_cost_3" readonly="">
                        @if ($errors->has('freight_cost_3'))
                            <span class="help-block"><strong>{{ $errors->first('freight_cost_3') }}</strong></span>
                        @endif
                    </div>
                </div>
                @else
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('freight_cost_3') ? 'has-error' : '' }}">
                        <label for="freight_cost_3">freight_cost_3(40 HC)</label>
                        <input name="freight_cost_3" type="text" id="freight_cost_3" class="form-control input-sm"   value="{{$sale_contract->freight_cost_3}}"   autofocus max="191"  placeholder="freight_cost_3" style="@if($sale_contract->desk_approver_id)readonly @endif">
                        @if ($errors->has('freight_cost_3'))
                            <span class="help-block"><strong>{{ $errors->first('freight_cost_3') }}</strong></span>
                        @endif
                    </div>
                </div>
                @endif
                 @if(AdminController::isAccessable(41))
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('freight_cost') ? 'has-error' : '' }}">
                        <label for="freight_cost">freight_cost(ci  use only)</label>
                        <input name="freight_cost" type="text" id="freight_cost" class="form-control input-sm"   value="{{$sale_contract->freight_cost}}"   autofocus max="191"  placeholder="freight_cost" >
                        @if ($errors->has('freight_cost'))
                            <span class="help-block"><strong>{{ $errors->first('freight_cost') }}</strong></span>
                        @endif
                    </div>
                </div>
                
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('container') ? 'has-error' : '' }}">
                        <label for="container">Container (Ci use Only)</label>
                        <input name="container" type="text" id="container" class="form-control input-sm"   value="{{$sale_contract->container}}"   autofocus max="191"  placeholder="Container" >
                        @if ($errors->has('container'))
                            <span class="help-block"><strong>{{ $errors->first('container') }}</strong></span>
                        @endif
                    </div>
                </div>
                @endif
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('desk_freight_cost') ? 'has-error' : '' }}">
                        <label for="desk_freight_cost">Freight Cost Desk(If Revise)</label>
                        <input name="desk_freight_cost" type="text" id="desk_freight_cost" class="form-control input-sm"   value="{{ $sale_contract->desk_freight_cost }}"   max="191"  placeholder="desk_freight_cost">
                        @if ($errors->has('desk_freight_cost'))
                            <span class="help-block"><strong>{{ $errors->first('desk_freight_cost') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('ci_note') ? 'has-error' : '' }}">
                        <label for="ci_note">Note If Any(Shipping Mark)</label>
                        <input name="ci_note" type="text" id="ci_note" class="form-control input-sm"   value="{{ $sale_contract->ci_note }}"   max="191"  placeholder="ci_note" >
                        @if ($errors->has('ci_note'))
                            <span class="help-block"><strong>{{ $errors->first('ci_note') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('bl_no') ? 'has-error' : '' }}">
                        <label for="bl_no">BL no(For CO)</label>
                        <input name="bl_no" type="text" id="bl_no" class="form-control input-sm"   value="{{ $sale_contract->bl_no }}"   max="191"  placeholder="bl_no">
                        @if ($errors->has('bl_no'))
                            <span class="help-block"><strong>{{ $errors->first('bl_no') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('bl_date') ? 'has-error' : '' }}">
                        <label for="bl_date">BL date(For CO)</label>
                        <input name="bl_date" type="text" id="bl_date" class="form-control datepicker input-sm"  value="@if($sale_contract->bl_date){{date('d-m-Y', strtotime($sale_contract->bl_date))}}@endif"   autofocus placeholder="Bl date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('bl_date'))
                            <span class="help-block"><strong>{{ $errors->first('bl_date') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('bl_date_cer') ? 'has-error' : '' }}">
                        <label for="bl_date_cer">BL date(For CER)</label>
                        <input name="bl_date_cer" type="text" id="bl_date_cer" class="form-control datepicker input-sm"  value="@if($sale_contract->bl_date_cer){{date('d-m-Y', strtotime($sale_contract->bl_date_cer))}}@endif"   autofocus placeholder="Bl date for cer"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('bl_date_cer'))
                            <span class="help-block"><strong>{{$errors->first('bl_date_cer')}}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-3">
                    <div class="form-group form-group {{ $errors->has('is_proforma_invoice') ? 'has-error' : '' }}">
                        <label for="is_proforma_invoice" >Vessel Name(For CO)</label><br>
                        <input name="vehicle" type="text" id="" class="form-control input-sm"   value="{{$sale_contract->vehicle}}"  placeholder="vehicle Name" >
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-group {{ $errors->has('is_proforma_invoice') ? 'has-error' : '' }}">
                        <label for="is_proforma_invoice" >Product Name(For CO)</label><br>
                        <input name="revise_product_name" type="text" id="" class="form-control input-sm"   value="{{$sale_contract->revise_product_name}}"  placeholder="Product Name">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('bl_date') ? 'has-error' : '' }}">
                        <label for="bl_date">Tr Report Date</label>
                        <input name="tr_report_date" type="text" id="tr_report_date" class="form-control datepicker input-sm"  value="{{$sale_contract->tr_report_date}}"   autofocus placeholder="">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="phyto_product_name">Insurance Charge</label>
                        <input name="insurance_charge" type="text" id="insurance_charge" class="form-control input-sm"   value="{{ $sale_contract->insurance_charge }}"   max="191"  placeholder="Enter Insurance Charge">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="phyto_product_name">Pallet Change</label>
                        <input name="pallet_charge" type="text" id="pallet_charge" class="form-control input-sm"   value="{{ $sale_contract->pallet_charge }}"   max="191"  placeholder="Enter Pallet Charge">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('terms_and_condition') ? 'has-error' : '' }}">
                        <label for="terms_and_condition">Terms And Conditions</label>
                        <textarea rows="5" name="terms_and_condition" type="text" id="terms_and_condition" class="form-control input-sm"     required  max="191"  placeholder="" >{{$sale_contract->terms_and_condition}}
                        </textarea>
                        @if ($errors->has('terms_and_condition'))
                            <span class="help-block"><strong>{{ $errors->first('terms_and_condition') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('terms_and_condition_desk_inv') ? 'has-error' : '' }}">
                        <label for="terms_and_condition_desk_inv">Terms And Conditions desk inv</label>
                        <textarea rows="5" name="terms_and_condition_desk_inv" type="text" id="terms_and_condition_desk_inv" class="form-control input-sm"       max="191"  placeholder="" >{{$sale_contract->terms_and_condition_desk_inv}}</textarea>
                        @if ($errors->has('terms_and_condition_desk_inv'))
                            <span class="help-block"><strong>{{ $errors->first('terms_and_condition_desk_inv') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('angikar_given_by') ? 'has-error' : '' }}">
                        <label for="angikar_given_by">Angikar  Given By</label>
                        <textarea rows="5" name="angikar_given_by" type="text" id="angikar_given_by" class="form-control input-sm"     autofocus max="191"  placeholder="" >{{$sale_contract->angikar_given_by}}</textarea>
                        @if ($errors->has('angikar_given_by'))
                            <span class="help-block"><strong>{{ $errors->first('angikar_given_by') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('phyto_product_name') ? 'has-error' : '' }}">
                        <label for="phyto_product_name">Phyto Product Name</label>
                        <textarea rows="5" name="phyto_product_name" type="text" id="phyto_product_name" class="form-control input-sm"     autofocus max="191"  placeholder="" >{{$sale_contract->phyto_product_name}}</textarea>
                        @if ($errors->has('phyto_product_name'))
                            <span class="help-block"><strong>{{ $errors->first('phyto_product_name') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3"><strong>3rd Notify Party</strong><br><textarea class="form-control input-sm" name="third_notify_party">{{$sale_contract->third_notify_party}}</textarea></div>
                <div class="col-sm-3"><strong>Bank Address(Only For India)</strong><br><textarea class="form-control input-sm" name="bank_address_for_india">{{$sale_contract->bank_address_for_india}}</textarea></div>    
                <div class="col-sm-3"><strong>Custom Decleration(For India)</strong><br><textarea class="form-control" name="custom_decleration">{{$sale_contract->custom_decleration}}</textarea></div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('country_id') ? 'has-error' : '' }}">
                        <label for="factory_address_type_id">Factory Address(If Need)</label>
                        <select name="factory_address_type_id" id="factory_address_type_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                            <option value="1">Select</option>
                            @if($sale_contract->factory_address_type==1)
                             <option value="1" selected="">Default Address</option>
                             <option value="0">N/A</option>
                             <option value="2">Factory Address Details</option>
                            @endif
                            @if($sale_contract->factory_address_type==2)
                            <option value="2" selected="">Factory Address Details</option>
                            <option value="0">N/A</option>
                            <option value="1">Default Address</option>
                            @endif
                            @if($sale_contract->factory_address_type==0)
                              <option value="0" selected="">N/A</option>
                              <option value="1">Default Address</option>
                              <option value="2">Factory Address Details</option>
                            @endif  
                        </select>  
                    </div>
                </div>
                 <div class="col-sm-3">
                    <div class="form-group">
                        <label for="phyto_product_name">Foreign Port(Only For Land)</label>
                        <input name="foreign_port" type="text" id="foreign_port" class="form-control input-sm"   value="{{ $sale_contract->foreign_port }}"   max="191"  placeholder="">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="phyto_product_name">BD Port(ONly For Land)</label>
                        <input name="bd_port" type="text" id="bd_port" class="form-control  input-sm"   value="{{ $sale_contract->bd_port }}"   max="191"  placeholder="">
                    </div>
                </div>
                <div class="col-sm-3">
                    <label for="formated_file">Lc Terms(Only For India)</label>
                    <input name="lc_term_for_india" type="text"  class="form-control input-sm" value="{{$sale_contract->lc_term_for_india}}">
                </div>
                <div class="col-sm-3">
                    <label for="formated_file">Advance Payment</label>
                    <input name="advance_payment" type="text"  class="form-control input-sm"   value="{{$sale_contract->advance_payment}}">
                </div>
                <div class="col-sm-3">
                    <label for="formated_file">Freight Charge(For India)</label>
                    <input name="freight_charge_india" type="text"  class="form-control input-sm"   value="{{$sale_contract->freight_charge_india}}">
                </div>
                <div class="col-sm-3">
                    <label for="formated_file">Lot Number(For India)</label>
                    <input name="lot_number" type="text"  class="form-control input-sm"   value="{{$sale_contract->lot_number}}">
                </div>
                 <div class="col-sm-3">
                    <label for="formated_file">Best Before(For India)</label>
                    <input name="best_before_india" type="text"  class="form-control input-sm"   value="{{$sale_contract->best_before_india}}">
                </div>
                <div class="col-sm-3">
                    <label for="formated_file">GSP REF# NO</label>
                    <input name="gsp_ref_number" type="text"  class="form-control input-sm"   value="{{$sale_contract->gsp_ref_number}}">
                </div>
                <div class="col-sm-3">
                    <label for="formated_file">Shipping Mark(India)</label>
                    <input name="shipping_mark_india" type="text"  class="form-control input-sm"   value="{{$sale_contract->shipping_mark_india}}">
                </div>
                
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('dated') ? 'has-error' : '' }}">
                        <label for="dated">Safta Date(For India)</label>
                        <input name="safta_dated" type="text" id="dated"class="form-control datepicker input-sm"  value="@if(!empty($sale_contract->safta_dated)){{date('d-m-Y', strtotime($sale_contract->safta_dated))}}@endif"  placeholder="Dated"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('dated'))
                            <span class="help-block"><strong>{{ $errors->first('dated') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('dated') ? 'has-error' : '' }}">
                        <label for="dated">Freight Date(For India)</label>
                        <input name="freight_date" type="text" id="dated" class="form-control datepicker input-sm"  value="@if(!empty($sale_contract->freight_date)){{date('d-m-Y', strtotime($sale_contract->freight_date))}}@endif"  placeholder="Dated"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('dated'))
                            <span class="help-block"><strong>{{ $errors->first('dated') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('arv_amount') ? 'has-error' : '' }}">
                        <label for="arv_amount">Arv Amount(For India)</label>
                        <input name="arv_amount" type="text" class="form-control input-sm"  value="{{$sale_contract->arv_amount}}"  placeholder="Arv_amount"  autocomplete="off">
                        @if ($errors->has('arv_amount'))
                            <span class="help-block"><strong>{{ $errors->first('arv_amount') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('arv_amount_received_date') ? 'has-error' : '' }}">
                        <label for="arv_amount_received_date">Arv Amount Received Date(For India)</label>
                        <input name="arv_amount_received_date" type="text" class="form-control datepicker input-sm"  value="@if(!empty($sale_contract->arv_amount_received_date)){{date('d-m-Y', strtotime($sale_contract->arv_amount_received_date))}}@endif"  placeholder="Dated"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('arv_amount_received_date'))
                            <span class="help-block"><strong>{{ $errors->first('arv_amount_received_date') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('dcc_memo_no') ? 'has-error' : '' }}">
                        <label for="">DCC Memo NO:</label>
                        <input name="dcc_memo_no" type="text" class="form-control input-sm"  value="{{$sale_contract->dcc_memo_no}}"  placeholder="Enter Dcc Memo No"  autocomplete="off"  is_date="1">
                        @if ($errors->has('dcc_memo_no'))
                            <span class="help-block"><strong>{{ $errors->first('dcc_memo_no') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('india_mfg_setup_date') ? 'has-error' : '' }}">
                        <label for="">Mfg Date(For India)</label>
                        <input name="india_mfg_setup_date" type="text" class="form-control input-sm"  value="{{$sale_contract->india_mfg_setup_date}}"  placeholder="Mfg Date"  autocomplete="off"  is_date="1">
                        @if ($errors->has('india_mfg_setup_date'))
                            <span class="help-block"><strong>{{ $errors->first('india_mfg_setup_date') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('country_id') ? 'has-error' : '' }}">
                        <label for="transport_agency_id">Transport Agency</label>
                        <select name="transport_agency_id" id="transport_agency_id" data-live-search="true" class="form-control select2 selectpicker input-sm"  type="select"  value="1" >
                           <option value="">Select</option>
                            @foreach($transportAgencyies as $transportAgency)
                             <option value="{{$transportAgency->id}}"  @if($transportAgency->id == $sale_contract->transport_agency_id){{"selected"}} @endif>{{$transportAgency->transport_agency_info}}</option>
                            @endforeach
                        </select>  
                    </div>
                </div>
                <input type="hidden" name="sale_contract_id" id="sale_contract_id" value="{{$sale_contract->id}}">
                <input type="hidden" name="po_no"  id="po_no" value="{{$po_no}}">  
                <div class="col-sm-3">
                    <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                        <label for="is_revised" >Is revised</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="is_revised"   value="1"   id="is_revised"  autofocus  @if($sale_contract->is_revised==1){{"checked"}}@endif >Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_revised"  value="0" @if($sale_contract->is_revised==0){{"checked"}}@endif >No
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
                            <input type="radio" name="is_proforma_invoice"   value="1"   id="is_proforma_invoice"  autofocus  @if($sale_contract->is_proforma_invoice==1){{"checked"}}@endif >Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_proforma_invoice"  value="0" @if($sale_contract->is_proforma_invoice==0){{"checked"}}@endif >No
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
                            <input type="radio" name="is_master"   value="1"   id="is_master"  autofocus  @if($sale_contract->is_master==1){{"checked"}}@endif >Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_master"  value="0" @if($sale_contract->is_master==0){{"checked"}}@endif >No
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
                            <input type="radio" name="footer_importer_address"   value="1"   id="footer_importer_address"  autofocus  @if($sale_contract->footer_importer_address==1){{"checked"}}@endif >Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="footer_importer_address"  value="0" @if($sale_contract->footer_importer_address==0){{"checked"}}@endif >No
                        </label>
                        @if ($errors->has('footer_importer_address'))
                            <span class="help-block"><strong>{{ $errors->first('footer_importer_address') }}</strong></span>
                        @endif
                    </div>
                    <input type="hidden" name="party_id" id="party_id" value="{{$party_id}}"> 
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-group {{ $errors->has('is_notify_also_notity') ? 'has-error' : '' }}">
                        <label for="is_notify_also_notity" >Is Notify/Also Notify</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="is_notify_also_notity"   value="1"   id="is_notify_also_notity" @if($sale_contract->is_notify_also_notity==1){{"checked"}}@endif>Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_notify_also_notity" id="is_notify_also_notity" value="0" @if($sale_contract->is_notify_also_notity=='0'){{"checked"}}@endif>No
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-group {{ $errors->has('tr_no_is_exist') ? 'has-error' : '' }}">
                        <label for="tr_no_is_exist" >TR NO(Only For Land)</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="tr_no_is_exist"   value="1"   id="tr_no_is_exist" @if($sale_contract->tr_no_is_exist==1){{"checked"}}@endif>Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="tr_no_is_exist" id="tr_no_is_exist" value="0" @if($sale_contract->tr_no_is_exist=='0'){{"checked"}}@endif>No
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-group {{ $errors->has('address_replace') ? 'has-error' : '' }}">
                        <label for="address_replace" >Address Replace</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="address_replace"   value="1"   id="address_replace" @if($sale_contract->address_replace==1){{"checked"}}@endif>Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="address_replace" id="address_replace" value="0" @if($sale_contract->address_replace=='0'){{"checked"}}@endif>No
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-group {{ $errors->has('is_total_amount_oceania') ? 'has-error' : '' }}">
                        <label for="is_total_amount_oceania">Is Total Amount Visible(Oceania Desk)</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="is_total_amount_oceania"   value="1"   id="is_total_amount_oceania"  autofocus  @if($sale_contract->is_total_amount_oceania==1){{"checked"}}@endif >Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_total_amount_oceania"  value="0" @if($sale_contract->is_total_amount_oceania==0){{"checked"}}@endif >No
                        </label>
                        @if ($errors->has('is_total_amount_oceania'))
                            <span class="help-block"><strong>{{ $errors->first('is_total_amount_oceania') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-group {{ $errors->has('mfg_date_india') ? 'has-error' : '' }}">
                        <label for="mfg_date_india" >Mfg Date(India)</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="mfg_date_india"   value="1"   id="mfg_date_india" @if($sale_contract->mfg_date_india==1){{"checked"}}@endif>Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="mfg_date_india" id="mfg_date_india" value="0" @if($sale_contract->mfg_date_india=='0'){{"checked"}}@endif>No
                        </label>
                    </div>
                </div>
                
                
                <div class="col-sm-3">
                    <label for="formated_file">Formatted File</label>
                    <input name="formated_file" type="file"  class="form-control input-sm"   value=""   autofocus   >
                </div>
                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('currency_id') ? 'has-error' : '' }}">
                        <label for="currency_id">Currency</label>
                        <select name="currency_id" id="currency_id" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1" required>
                            <option value="">Select</option>
                            @foreach($currency as $value)
                             <option value="{{$value->id}}" @if($value->id==$sale_contract->currency_id) {{'selected'}} @endif>{{$value->currency_name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('currency_id'))
                            <span class="help-block"><strong>{{ $errors->first('currency_id') }}</strong></span>
                        @endif  
                    </div>
                </div>
                {{-- @endif --}}
                <div class="col-sm-6"></div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-info btn-flat"  id="nextButton" style="margin-top: 22px">Update</button> 
                </div>        
                 </div>  <!-- /.box-body -->
                 <div class="box-footer"></div>
             </form>
             <hr>
             @if(!$sale_contract->desk_approver_id) 
             <div class="box-body"> <!-- Sale contract detail add -->
             <form class="" role="form" method="POST" action="{{ route('sale_contract_detail.store') }}">
                {{ csrf_field() }} 
                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('ci_item_id') ? 'has-error' : '' }}">
                        <label for="ci_item_id">Ci item </label>
                       <select name="ci_item_id" id="ci_item_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required   type="select"  value="1" >
                            <option value="">Select Ci item</option>
                            
                        </select> 
                        @if ($errors->has('ci_item_id'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_id') }}</strong></span>
                        @endif  
                    </div>
                </div>  

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('ctn') ? 'has-error' : '' }}">
                        <label for="ctn">Ctn(qty)</label>
                        <input name="ctn" type="number" id="ctn" class="form-control input-sm"   value="{{ old('ctn') }}"   required autofocus step="any"  placeholder="Ctn" >
                        @if ($errors->has('ctn'))
                            <span class="help-block"><strong>{{ $errors->first('ctn') }}</strong></span>
                        @endif
                    </div>
                </div>  

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('rate_per_ctn_for_acc') ? 'has-error' : '' }}">
                        <label for="rate_per_ctn_for_acc">Rate per ctn (act)</label>
                        <input name="rate_per_ctn_for_acc" type="number" id="rate_per_ctn_for_acc" class="form-control input-sm"   value="{{ old('rate_per_ctn_for_acc') }}"   required  step="any"  placeholder="Rate per ctn" readonly="true">
                        @if ($errors->has('rate_per_ctn_for_acc'))
                            <span class="help-block"><strong>{{ $errors->first('rate_per_ctn_for_acc') }}</strong></span>
                        @endif
                    </div>
                </div>  

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('rate_per_ctn_for_party') ? 'has-error' : '' }}">
                        <label for="rate_per_ctn_for_party">Rate per ctn (Party)</label>
                        <input name="rate_per_ctn_for_party" type="number" id="rate_per_ctn_for_party" class="form-control input-sm"   value="{{ old('rate_per_ctn_for_party') }}"   required  step="any"  placeholder="Rate per ctn" >
                        @if ($errors->has('rate_per_ctn_for_party'))
                            <span class="help-block"><strong>{{ $errors->first('rate_per_ctn_for_party') }}</strong></span>
                        @endif
                    </div>
                </div>   

                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('cbm_per_ctn') ? 'has-error' : '' }}">
                        <label for="cbm_per_ctn">cbm/ctn</label>
                        <input name="cbm_per_ctn" type="text" id="cbm_per_ctn" readonly="true" class="form-control input-sm"  value="{{ old('cbm_per_ctn') }}"   required  placeholder="cbm_per_ctn"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('cbm_per_ctn'))
                            <span class="help-block"><strong>{{ $errors->first('cbm_per_ctn') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('cbm_per_ctn') ? 'has-error' : '' }}">
                        <label for="cbm_per_ctn">Gross Weight</label>
                        <input name="gross_weight" type="text" id="gross_weight" class="form-control input-sm"  value="" required="">
                        @if ($errors->has('cbm_per_ctn'))
                            <span class="help-block"><strong>{{ $errors->first('cbm_per_ctn') }}</strong></span>
                        @endif
                    </div>
                </div>
                
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('desk_item_name') ? 'has-error' : '' }}">
                        <label for="desk_item_name">desk_item_name</label>
                        <input name="desk_item_name" type="text" id="desk_item_name" class="form-control input-sm"   value="{{ old('desk_item_name') }}"   required autofocus step="any"  placeholder="desk_item_name" >
                        @if ($errors->has('desk_item_name'))
                            <span class="help-block"><strong>{{ $errors->first('desk_item_name') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <input type="hidden" name="sc_id" id="sc_id" value="{{$sale_contract->id}}">
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('hs_code') ? 'has-error' : '' }}">
                        <label for="hs_code">HS Code</label>
                        <input name="hs_code" type="text" id="hs_code"class="form-control input-sm"  value="{{ old('hs_code') }}"   required  placeholder="hs_code"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('hs_code'))
                            <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('hs_code_2') ? 'has-error' : '' }}">
                        <label for="hs_code_2">HS Code 2</label>
                        <input name="hs_code_2" type="text" id="hs_code_2"class="form-control input-sm"  value="{{ old('hs_code_2') }}"    placeholder="hs_code_2"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('hs_code_2'))
                            <span class="help-block"><strong>{{ $errors->first('hs_code_2') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('mfg') ? 'has-error' : '' }}">
                        <label for="mfg">MFG</label>
                        <input name="mfg" type="text" id="mfg"class="form-control datepicker input-sm"  value=""    placeholder="mfg"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('mfg'))
                            <span class="help-block"><strong>{{ $errors->first('mfg') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('exp') ? 'has-error' : '' }}">
                        <label for="exp">Exp</label>
                        <input name="exp" type="text" id="exp"class="form-control datepicker input-sm"  value=""    placeholder="exp"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('exp'))
                            <span class="help-block"><strong>{{ $errors->first('exp') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('container_no') ? 'has-error' : '' }}">
                        <label for="container_no">Container No</label>
                        <input name="container_no" type="text" id="container_no" class="form-control input-sm"   value=""  placeholder="Container No" >
                        @if ($errors->has('container_no'))
                            <span class="help-block"><strong>{{ $errors->first('container_no') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('batch_no') ? 'has-error' : '' }}">
                        <label for="batch_no">Batch No</label>
                        <input name="batch_no" type="text" id="batch_no" class="form-control input-sm"   value=""  placeholder="Batch No" >
                        @if ($errors->has('batch_no'))
                            <span class="help-block"><strong>{{ $errors->first('batch_no') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('total_amount_party') ? 'has-error' : '' }}">
                        <label for="total_amount_party">Total amount (Party)</label>
                        <input name="total_amount_party" type="number"  id="total_amount_party" class="form-control input-sm"   value="{{ old('total_amount_party') }}"   required  step="any"  placeholder="amount party" >
                        @if ($errors->has('total_amount_party'))
                            <span class="help-block"><strong>{{ $errors->first('total_amount_party') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('total_amount_acc') ? 'has-error' : '' }}">
                        <label for="total_amount_acc">Total amount(Acc) </label>
                        <input name="total_amount_acc" type="number"  id="total_amount_acc" class="form-control input-sm"   value="{{ old('total_amount_acc') }}"   required  step="any"  placeholder="Total amount" >
                        <input type="hidden" name="party_id"  id="party_id" value="{{$party_id}}"> 
                        @if ($errors->has('total_amount_acc'))
                            <span class="help-block"><strong>{{ $errors->first('total_amount_acc') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-info  btn-flat input-sm" style="margin-top: 22px">Add Item</button>    
                </div>
             </form>
             </div> <!-- Sale contract detail add -->
             @endif
             <?php
                session_start();
                if(isset($_SESSION['party_id']))
                {
                     echo $party_id=Session::get('party_id');
                }
                               
                if(isset($_SESSION['sale_contract_no']))
                {
                    $party_id=Session::get('sale_contract_no');

                }
             ?>
             <div> <!-- Table Start -->
                  <table style="background-color:#dfdfdf" class="table table-bordered table-responsive table-condensed  table-hover">
                     @if(!$sale_contract->desk_approver_id)
                     <button style="margin-bottom: 10px" class="btn btn-danger delete_all btn-sm" data-url="{{ url('/delete/sales/contact/item') }}">Deleted</button> 
                     @endif
                    <thead >
                        <th width="50px">All<br><input type="checkbox" id="master"></th>
                        <th>Ci item code</th>
                        <th>Ci item</th>
                        <th>Hs code</th>
                        <th>Ctn <br>(qty)</th>
                        @if(AdminController::isAccessable(19))
                        <th>Rate <br>/ctn <br>(act)</th>
                        <th>Total<br><(act) </th>  
                        <th style="background-color:#ccffe6;"> Rate <br>/ctn<br>(party)</th>
                        <th style="background-color:#ccffe6;">Total<br>(Party)</th> 
                        @endif
                        @if(AdminController::isAccessable(20))
                        <th style="background-color:#b3d9ff;">Rate <br> /ctn<br>(CI)</th>
                        <th style="background-color:#b3d9ff;">Total<br> (CI)</th>
                        @endif
                        <th>Cbm <br>/ctn</th> 
                        <th>Total cbm</th>
                        <th>Gross Weight</th>   
                        <th>Pcs in ctn</th> 
                        <th>Controls</th>
                    </thead>
                    <tbody>
                        <?php 
                           $total_cbm = 0;
                           $total_amount = 0;
                           $total_amount_party = 0;
                           $total_amount_acc = 0;
                           $total_ctn = 0;
                           $total_gross_weight_kg=0;
                           $key=0;
                           $pcs_in_carton=0;
                        ?>
                        @foreach ($sale_contract->sale_contract_details as $sale_contract_detail)
                        <?php $prev = $sale_contract->sale_contract_details->get($key-1);$next = $sale_contract->sale_contract_details->get($key+1);?>
                        <tr >
                            <td><input type="checkbox" class="sub_chk" data-id="{{$sale_contract_detail->id}}"></td>
                            <td>{{$sale_contract_detail->ci_item->ci_item_code}}</td>
                            <td>@if(AdminController::isAccessable(27)) CI:{{$sale_contract_detail->ci_item->duplicate_name}}@endif<br>
                            @if(AdminController::isAccessable(30))
                            <!-- {{$sale_contract_detail->ci_item->ci_item_name}}<br> -->    
                            Desk:{{$sale_contract_detail->desk_item_name}}
                            @endif
                            </td>
                            <td>{{$sale_contract_detail->hs_code}} <br>{{$sale_contract_detail->hs_code_2}}</td>
                            <td>{{$sale_contract_detail->ctn}} <?php $total_ctn +=$sale_contract_detail->ctn;?> </td>
                            @if(AdminController::isAccessable(19))
                            <td>{{$sale_contract_detail->rate_per_ctn_for_acc}}</td>
                            <td>{{$sale_contract_detail->total_amount_acc}} <?php $total_amount_acc += $sale_contract_detail->total_amount_acc;?></td>  
                            <td style="background-color:#ccffe6;">{{$sale_contract_detail->rate_per_ctn_for_party}}</td>
                            <td style="background-color:#ccffe6;">{{$sale_contract_detail->total_amount_party}} <?php $total_amount_party += $sale_contract_detail->total_amount_party;?></td>
                            @endif
                            @if(AdminController::isAccessable(20))                            
                            <td style="background-color:#b3d9ff;">{{$sale_contract_detail->rate_per_ctn}}</td>
                            <td style="background-color:#b3d9ff;">{{$sale_contract_detail->total_amount}} <?php $total_amount += $sale_contract_detail->total_amount; ?></td>
                            @endif 
                            <td>{{number_format($sale_contract_detail->cbm_per_ctn,3)}}</td>
                            <td>{{number_format($sale_contract_detail->total_cbm,3)}} <?php  $total_cbm += $sale_contract_detail->total_cbm?></td>
                            <td>{{$sale_contract_detail->gross_weight_kg}} <?php  $total_gross_weight_kg += $sale_contract_detail->gross_weight_kg?></td>
                            <td>{{$sale_contract_detail->pcs_in_ctn}} <?php  $pcs_in_carton += $sale_contract_detail->pcs_in_ctn?></td>
                            <td>
                                @if(AdminController::isAccessable(24))
                                 <a href="{{url('/sale_contract_detail')}}/{{\Crypt::encrypt($sale_contract_detail->id)}}/edit_desk/{{\Crypt::encrypt($party_id)}}"><button type="submit" class="btn btn-xs btn-success btn-flat">Edit Desk</button></a>
                                @endif
                                @if(AdminController::isAccessable(23))
                                <a href="{{url('/sale_contract_detail')}}/{{\Crypt::encrypt($sale_contract_detail->id)}}/edit/{{\Crypt::encrypt($party_id)}}"><button type="submit" class="btn btn-xs btn-primary btn-flat">Edit CI</button></a>  
                                @endif
                            </td>
                        </tr>
                        <?php $key++;?>
                        @endforeach  

                        <tr style="background: aquamarine;">
                           <td></td> 
                           <td><strong>Total</strong></td>
                           <td></td>
                           <td></td>
                           <td><span id="totalCtn" style="font-weight: bold;">{{$total_ctn}}</span></td>
                           @if(AdminController::isAccessable(19))
                           <td></td>
                           <td><span id="total_amount_accc" style="font-weight: bold;">{{$total_amount_acc}}</span></td>
                           <td></td>
                           <td><span id="total_amount_partyy" style="font-weight: bold;">{{$total_amount_party}}</span></td>
                           @endif
                           @if(AdminController::isAccessable(20))
                           <td></td>
                           <td><span id="total_amount" style="font-weight: bold;">{{$total_amount}}</span></td>
                           @endif
                           <td></td>
                           <td><span id="total_cbm" style="font-weight: bold;">{{number_format($total_cbm,3)}}</span></td>
                           <td><span id="total_gross_weight_kg" style="font-weight: bold;">{{$total_gross_weight_kg}}</span></td>
                           <td><span id="pcs_in_carton" style="font-weight: bold;">{{$pcs_in_carton}}</span></td>
                           <td></td>
                        </tr>
                     </tbody>
                </table>
             </div> <!-- Table end  -->
      </div> <!-- col-md-8 end -->
</div>
<div class="row">
    <div class="col-md-5">
         @if(AdminController::isAccessable(26))
            @if(!$sale_contract->approved_at)
            <button type="button" class="btn btn-sm btn-primary btn-flat" value="{{$sale_contract->id}}" id="make_priceSame_id" style="margin-left: 14px">MAKE PRICE SAME</button>
            @endif
        @endif   
    </div>
    <div class="col-md-3">
         <a href="{{url('/return/direct')}}/{{\Crypt::encrypt($sale_contract->id)}}/{{\Crypt::encrypt($party_id)}}"><button class="btn btn-sm btn-success">Show</button></a>   
    </div>
</div> 
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
  <form class="form-horizontal" id="delete_modal_form" role="form" method="POST" action="">
    {{ csrf_field() }}
    {{ method_field("DELETE") }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete item</h4>
      </div>
      <div class="modal-body">
        <h4>Do you want to delete This item ??</h4>
        <input id="delete_id" type="hidden" name="id">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-info pull-left" >Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
    </form>
  </div>
</div>
<script>document.title = 'SaleContractDetail';</script>
<script type="text/javascript">
$(document).on("click", "#openDeleteModal", function () {
     var delId = $(this).data("id");
     $("#delete_modal_form").attr("action", "{{url('/sale_contract_detail')}}/" + delId);
     $(".modal-body #delete_id").val( delId );
     $("#myModal").modal("show");
});
</script>
<script>document.title = 'SaleContract | Edit';</script>
<script type="text/javascript">

    setTimeout(function() { $('.sr-only').click(); }, 0.0001);
    //@@@Submit Create Form@@@@
    $("#UpdateForm").submit(function (e) {

        e.preventDefault(); 
        var formData = new FormData($(this)[0]);
        $.ajax({
            type:'POST',
            url: '/sc_update',
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: (res) => {
                  
                
                if(res.code==200){
                
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: res.status,
                        showConfirmButton: false,
                        timer: 1500
                    });

                }else if(res.code==422){

                    Swal.fire({
                        icon: 'warning',
                        title: res.status,
                    });

                }
                                    
            },
            error: function(data){

                console.log(data);
                
            }
        });


    }); //@@@@-End Submit Create Form

    function loadPO(){
            
            var notify_pary_id=$('#party_id').val();
            var sc_id=$('#sale_contract_id').val();
            var po_no=$('#po_no').val();
            console.log(po_no);
            var url = "{{url('/')}}"+"/json/get_sc_edit_po_list?party_id="+notify_pary_id+"&sc_id="+sc_id;
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

                        $('select[name="po_id"]').append(`<option value="${value.PO_NO}" ${value.PO_NO == po_no ? 'selected' : ''}>${value.PO_NO}</option>`);
                        
                    });
                    $el.selectpicker('refresh');
                }
        
            }); 
                
        }  
            
    loadPO();

    $('#make_priceSame_id').click(function(e) {
        
        e.preventDefault();
        var sa_id = $(this).val();
        var url = "{{url('/')}}"+"/ci_make_price_same?sale_contact_id="+$(this).val();
        Swal.fire({

            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Merge it!'

        }).then((result) => {

            if (result.isConfirmed) {
                 
                $.get(url,function(res) {
             
                    if(res.code==200){
                        
                        Swal.fire(
                            'Merge!',
                            'Your Item has been Merged.',
                            'success'
                        )
                                
                    }else if(res.code==500){
        
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
        
                    }      
 
                });  
                
            }

        });
        
    });
    
    $("#ctn,#rate_per_ctn_for_acc").change(function(){

        var ctn = $('#ctn').val();
        var rate_per_ctn = $('#rate_per_ctn_for_acc').val();
        $('#total_amount_acc').val(ctn*rate_per_ctn);

    });

    $("#ctn, #rate_per_ctn_for_party").change(function(){

        var ctn = $('#ctn').val();
        var rate_per_ctn = $('#rate_per_ctn_for_party').val();
        $('#total_amount_party').val(ctn*rate_per_ctn);

    })


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
    })

    var notify_pary_id = $('#notify_pary_id').val();
    var url = "{{url('/')}}"+"/json/get_item_of_notify_party?notify_party_id="+notify_pary_id;
    var $el = $('#ci_item_id');
        $.get( url, function( data ) {
            if(!data){
                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("---"));
                $el.selectpicker('destroy');
            }else{

                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function(key,value) {
                    $el.append($("<option></option>").attr("value", value['id']).text(value['ci_item_code']+'-'+value['ci_item_name']));
                });
                $el.selectpicker('refresh');
            }

        }); // get end


    $("#notify_pary_id").change(function(){
        var notify_pary_id = $(this).val();
        var url = "{{url('/')}}"+"/json/get_item_of_notify_party?notify_party_id="+notify_pary_id;
        
        var $el = $('#ci_item_id');
        $.get( url, function( data ) {
            if(!data){
                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("---"));
                $el.selectpicker('destroy');
            }else{

                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function(key,value) {
                    $el.append($("<option></option>").attr("value", value['id']).text(value['ci_item_code']+'-'+value['ci_item_name']));
                });
                $el.selectpicker('refresh');
            }

        }); // get end
    })


    $("#ci_item_id").change(function(){

        var ci_item_id = $("#ci_item_id").val();
        var notify_pary_id = $('#notify_pary_id').val();
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
            $('#gross_weight').val(data['gross_weight']);
    
            }

        }); 
    })

    // scroll 
    $(function () {
        $("html, body").animate({

           scrollTop: $('html, body').get(0).scrollHeight

        }, 2000);
    });
    
</script>
<script type="text/javascript">

    $(document).ready(function () {


        $('#master').on('click', function(e) {

         if($(this).is(':checked',true))  

         {

            $(".sub_chk").prop('checked', true);  

         } else {  

            $(".sub_chk").prop('checked',false);  

         }  

        });


        $('.delete_all').on('click', function(e) {

            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  
            if(allVals.length <=0)  
            {  

                swal("Alert", "Please Select Row..!!");

            }
            else {  
                var check = confirm("Are you sure you want to delete this row?");  
                if(check == true){  
                    var join_selected_values = allVals.join(",");
                    var sale_contract_no=$('#my_sale_contract_id').val();
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'ids': join_selected_values, 'sale_contract_no': sale_contract_no},
                        success: function (data) {
                            var ctn=data['0'];
                            var total_amount_acc=data['1'];
                            var total_amount_party=data['2'];
                            var total_amount=data['3'];
                            var total_cbm=data['4'];
                            var total_gross_weight_kg=data['5'];
                            var pcs_in_carton=data['6'];
                            if(ctn!='0'){
                          
                                 $('#totalCtn').html(ctn);
                                 $('#total_amount_accc').html(total_amount_acc);
                                 $('#total_amount_partyy').html(total_amount_party);
                                 $('#total_amount').html(total_amount);
                                 $('#total_cbm').html(total_cbm);
                                 $('#total_gross_weight_kg').html(total_gross_weight_kg);
                                 $('#pcs_in_carton').html(pcs_in_carton);
                                 $(".sub_chk:checked").each(function() {  

                                    $(this).parents("tr").remove();

                                });

                                swal("Alert", "Item Delete Sucessfull..!!");
                               
                            }else{
                                 
                                 $('#totalCtn').html('0');
                                 $('#total_amount_accc').html('0');
                                 $('#total_amount_partyy').html('0');
                                 $('#total_amount').html('0');
                                 $('#total_cbm').html('0');
                                 $('#total_gross_weight_kg').html('0');
                                 $('#pcs_in_carton').html('0');
                                 $(".sub_chk:checked").each(function() {  

                                    $(this).parents("tr").remove();

                                });
                                swal("Alert", "Item Delete Sucessfull..!!");

                            }
                           
                        },
                        error: function (data) {

                            console.log(data);

                        }
                    });
                  $.each(allVals, function( index, value ) {
                      $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }  
            }  
        });

    });

    function checkInvoiceNumberExistOrNot(){

            var invoice_no=document.getElementById('invoice_no').value;
            $.ajax({
                type: "GET",
                url: "{{url('/check/invoice/number/exist/ornot')}}?invoice_no=" + invoice_no,
                success: function (data) {

                    if(data=='1'){

                        document.getElementById('mobile_number_error').innerHTML="Already Exists..!!";
                       $('#editSalesContactId').prop("disabled", true);

                    }else{

                         document.getElementById('mobile_number_error').innerHTML="Not Exists..!!";
                         $('#editSalesContactId').removeAttr('disabled');
                    }
                   
                }
            });

    }

</script>
@endsection

