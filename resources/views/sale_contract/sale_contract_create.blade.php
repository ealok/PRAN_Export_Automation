@extends('layouts.master')
@section('content')
<style>
    .box {
        position: relative;
        background: #ffffff;
        width: 98%;
        box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
        margin: auto;
    }
    .box.box-info {
      border-top-color: #ebf1f2;
    }
    
    .modal-header .close {
     margin-top: -16px;
    }
    #tblMain {
        max-height: 338px;
        overflow-y: auto;
        display: block;
    }
    #po_details_style{

        position: absolute;
        top: -15px;
        border: 2px solid #4f46e5;
        background: #4f46e5;
        color: white;
        width: 167px;
        text-align: center;
        font-weight: bold;
        padding: 3px;
        font-style: oblique;
        border-radius: 4px;

    }
    #left_side_style{

        border: 2px solid #e5e7eb;
        min-height: 381px;
        border-radius: 6px;
        padding: 10px;

    }

    #right_side_style{

        border: 2px solid #e5e7eb;
        min-height: 381px;
        margin-left: 5px;
        width: 361px; 
        border-radius: 6px;
        padding: 10px;

    }
    #task_details_style{

        position: absolute;
        top: -15px;
        border: 2px solid #10b981;
        background: #10b981;
        color: white;
        width: 198px;
        text-align: center;
        font-weight: bold;
        padding: 3px;
        font-style: oblique;
        border-radius: 4px;

    }
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
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    .form-group {
        margin-bottom: 2px;
    }
    .req_style_id{
        color: #dc2626;
    }
    
    /* Professional Form Control Borders */
    .form-control.input-sm {
        border: 2px solid #d1d5db;
        border-radius: 6px;
        transition: border-color 0.2s ease;
    }
    
    .form-control.input-sm:focus {
        border-color: #4f46e5;
        outline: none;
    }
    
    .form-control.input-sm:hover {
        border-color: #9ca3af;
    }
    
    /* Professional Select Box Borders */
    .select2-container .select2-selection--single,
    .bootstrap-select .dropdown-toggle {
        border: 2px solid #d1d5db !important;
        border-radius: 6px !important;
        transition: border-color 0.2s ease !important;
    }
    
    .select2-container--default.select2-container--focus .select2-selection--single,
    .bootstrap-select .dropdown-toggle:focus {
        border-color: #4f46e5 !important;
        outline: none !important;
    }
    
    .select2-container--default .select2-selection--single:hover,
    .bootstrap-select .dropdown-toggle:hover {
        border-color: #9ca3af !important;
    }
    
    /* Datepicker Professional Borders */
    .datepicker {
        border: 2px solid #d1d5db;
        border-radius: 6px;
        transition: border-color 0.2s ease;
    }
    
    .datepicker:focus {
        border-color: #4f46e5;
        outline: none;
    }
    
    .datepicker:hover {
        border-color: #9ca3af;
    }
    
    /* Textarea Professional Borders */
    textarea.form-control.input-sm {
        border: 2px solid #d1d5db;
        border-radius: 6px;
        transition: border-color 0.2s ease;
    }
    
    textarea.form-control.input-sm:focus {
        border-color: #4f46e5;
        outline: none;
    }
    
    textarea.form-control.input-sm:hover {
        border-color: #9ca3af;
    }
    
    /* File Input Professional Borders */
    input[type="file"].form-control.input-sm {
        border: 2px solid #d1d5db;
        border-radius: 6px;
        transition: border-color 0.2s ease;
    }
    
    input[type="file"].form-control.input-sm:focus {
        border-color: #4f46e5;
        outline: none;
    }
    
    input[type="file"].form-control.input-sm:hover {
        border-color: #9ca3af;
    }
    
    /* Error State Borders */
    .has-error .form-control.input-sm,
    .has-error .select2-container .select2-selection--single,
    .has-error .bootstrap-select .dropdown-toggle,
    .has-error .datepicker,
    .has-error textarea.form-control.input-sm {
        border-color: #dc2626 !important;
    }
    
    .has-error .form-control.input-sm:focus,
    .has-error .select2-container--default.select2-container--focus .select2-selection--single,
    .has-error .bootstrap-select .dropdown-toggle:focus,
    .has-error .datepicker:focus,
    .has-error textarea.form-control.input-sm:focus {
        border-color: #b91c1c !important;
    }
    
    /* Table Professional Borders */
    .table-bordered {
        border: 2px solid #e5e7eb;
        border-radius: 6px;
        overflow: hidden;
    }
    
    .table-bordered th {
        background-color: #4f46e5;
        color: white;
        border: 1px solid #4338ca;
    }
    
    .table-bordered td {
        border: 1px solid #e5e7eb;
    }
    
    /* Modal Professional Borders */
    .modal-content {
        border-radius: 8px;
        border: 2px solid #e5e7eb;
    }
    
    .modal-header {
        border-bottom: 2px solid #e5e7eb;
        background-color: #f8fafc;
    }
    
    /* ===== PROFESSIONAL BUTTON STYLES ===== */
    /* Primary/Info Button - Indigo Theme */
    .btn-info,
    .btn-info.btn-flat,
    #nextButton,
    button[type="submit"].btn-info,
    button[type="submit"].btn-info.btn-flat {
        background-color: #4f46e5 !important;
        border: 2px solid #4f46e5 !important;
        color: white !important;
        font-weight: 500;
    }
    
    .btn-info:hover,
    .btn-info.btn-flat:hover,
    #nextButton:hover,
    button[type="submit"].btn-info:hover,
    button[type="submit"].btn-info.btn-flat:hover {
        background-color: #4338ca !important;
        border-color: #4338ca !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .btn-info:active,
    .btn-info.btn-flat:active,
    #nextButton:active {
        background-color: #3730a3 !important;
        border-color: #3730a3 !important;
        transform: translateY(0);
    }
    
    /* Primary Button - Blue Theme */
    .btn-primary,
    .btn-primary.btn-flat,
    .btn-primary[type="button"] {
        background-color: #3b82f6 !important;
        border: 2px solid #3b82f6 !important;
        color: white !important;
        font-weight: 500;
    }
    
    .btn-primary:hover,
    .btn-primary.btn-flat:hover {
        background-color: #2563eb !important;
        border-color: #2563eb !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .btn-primary:active,
    .btn-primary.btn-flat:active {
        background-color: #1d4ed8 !important;
        border-color: #1d4ed8 !important;
        transform: translateY(0);
    }
    
    /* Danger Button - Red Theme */
    .btn-danger,
    .btn-danger.btn-sm {
        background-color: #ef4444 !important;
        border: 2px solid #ef4444 !important;
        color: white !important;
        font-weight: 500;
    }
    
    .btn-danger:hover,
    .btn-danger.btn-sm:hover {
        background-color: #dc2626 !important;
        border-color: #dc2626 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .btn-danger:active,
    .btn-danger.btn-sm:active {
        background-color: #b91c1c !important;
        border-color: #b91c1c !important;
        transform: translateY(0);
    }
    
    /* Success Button - Green Theme */
    .btn-success,
    .btn-success.btn-sm,
    .btn-success.btn-flat {
        background-color: #10b981 !important;
        border: 2px solid #10b981 !important;
        color: white !important;
        font-weight: 500;
    }
    
    .btn-success:hover,
    .btn-success.btn-sm:hover,
    .btn-success.btn-flat:hover {
        background-color: #059669 !important;
        border-color: #059669 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .btn-success:active,
    .btn-success.btn-sm:active {
        background-color: #047857 !important;
        border-color: #047857 !important;
        transform: translateY(0);
    }
    
    /* Default Button - Gray Theme */
    .btn-default,
    .btn-default[data-dismiss="modal"] {
        background-color: #306be1 !important;
        border: 2px solid #6b7280 !important;
        color: white !important;
        font-weight: 500;
    }
    
    .btn-default:hover {
        background-color: #306be1 !important;
        border-color: #4b5563 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    /* Modal Save Button */
    #saveBtnID,
    .btn-primary#saveBtnID {
        background-color: #10b981 !important;
        border: 2px solid #10b981 !important;
        color: white !important;
        font-weight: 500;
    }
    
    #saveBtnID:hover {
        background-color: #059669 !important;
        border-color: #059669 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    /* Modal Close Button */
    .btn-danger[data-dismiss="modal"] {
        background-color: #6b7280 !important;
        border: 2px solid #6b7280 !important;
        color: white !important;
        font-weight: 500;
    }
    
    .btn-danger[data-dismiss="modal"]:hover {
        background-color: #4b5563 !important;
        border-color: #4b5563 !important;
    }
    
    /* Table Button Sizes */
    .btn-xs {
        padding: 2px 8px;
        font-size: 12px;
    }
    
    .btn-sm {
        padding: 3px 10px;
        font-size: 13px;
    }
    
    /* Button Focus States */
    .btn:focus,
    .btn-flat:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.3);
    }
    
    /* Button Disabled State */
    .btn:disabled,
    .btn.btn-flat:disabled {
        background-color: #9ca3af !important;
        border-color: #9ca3af !important;
        color: #e5e7eb !important;
        cursor: not-allowed;
        opacity: 0.7;
        transform: none !important;
        box-shadow: none !important;
    }
    
    /* Small Button Styling */
    .btn.btn-flat.input-sm {
        padding: 3px 10px;
        font-size: 13px;
    }
    
    /* Radio Button Styling */
    .radio-inline input[type="radio"] {
        margin-right: 5px;
    }
    
    .radio-inline {
        margin-right: 15px;
    }
    
    /* Delete Button Styling in Table */
    .btnDelete {
        background-color: #ef4444 !important;
        border: 2px solid #ef4444 !important;
        color: white !important;
        font-weight: 500;
        padding: 2px 6px;
        font-size: 12px;
    }
    
    .btnDelete:hover:not(:disabled) {
        background-color: #dc2626 !important;
        border-color: #dc2626 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .btnDelete:disabled {
        background-color: #9ca3af !important;
        border-color: #9ca3af !important;
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
<div class="row">    
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <form enctype="multipart/form-data" id="createForm">  
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                        
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
                        <label for="sales_contract_no">Sales Contract No<span class="req_style_id">(*)</span></label>
                        <input name="sales_contract_no" type="text" id="sales_contract_no" class="form-control input-sm"   value=""   required autofocus max="191"  placeholder="Sales contract no" >
                        @if ($errors->has('sales_contract_no'))
                            <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                        @endif
                    </div>
                </div> 

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('dated') ? 'has-error' : '' }}">
                        <label for="dated">Sales Contract Date<span class="req_style_id">(*)</span></label>
                        <input name="dated" type="text" id="dated" class="form-control datepicker input-sm" value="" required placeholder="Select Sales Contract Date" autocomplete="off">
                        @if ($errors->has('dated'))
                            <span class="help-block"><strong>{{ $errors->first('dated') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('invoice_no') ? 'has-error' : '' }}">
                        <label for="invoice_no">Invoice No</label>
                        <input name="invoice_no" type="text" id="invoice_no" class="form-control input-sm"   value=""   max="191"  placeholder="Invoice No" required="">
                        <span id="mobile_number_error" style="color: red;position: absolute;top: 0px;left: 97px;"></span>
                        @if ($errors->has('invoice_no'))
                            <span class="help-block"><strong>{{ $errors->first('invoice_no') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('invoice_date') ? 'has-error' : '' }}">
                        <label for="invoice_date">Invoice Date</label>
                         <input name="invoice_date" type="text" id="invoice_date" class="form-control datepicker input-sm" value="" autofocus placeholder="Select Invoice Date" autocomplete="off" is_date="1">
                        @if ($errors->has('invoice_date'))
                            <span class="help-block"><strong>{{ $errors->first('invoice_date') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('export_no') ? 'has-error' : '' }}">
                        <label for="export_no">Exp No</label>
                        <input name="export_no" type="text" id="export_no" class="form-control input-sm"   value=""  autofocus max="191"  placeholder="Enter Export No" >
                        @if ($errors->has('export_no'))
                            <span class="help-block"><strong>{{ $errors->first('export_no') }}</strong></span>
                        @endif
                    </div>
                </div> 
                 
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('export_date') ? 'has-error' : '' }}">
                        <label for="export_date">Exp Date</label>
                        <input name="export_date" type="text" id="export_date"class="form-control datepicker input-sm"  value=""    autofocus placeholder="Enter Export Date"  autocomplete="off"  is_date="1" >
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
                        <label for="sales_term_id">Sales Term<span class="req_style_id">(*)</span></label>
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
                        <label for="company_id">Company<span class="req_style_id">(*)</span></label>
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
                        <label for="bank_id">Bank<span class="req_style_id">(*)</span></label>
                        <select name="bank_id" id="bank_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
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

                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('importer_id') ? 'has-error' : '' }}">
                        <label for="importer_id">Importer <span class="req_style_id">(*)</span></label>
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
                        <label for="bank_importer_id">Importer Bank <span class="req_style_id">(*)</span></label>
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
                        <label for="notify_pary_id">Notify Party <span class="req_style_id">(*)</span></label>
                        <select name="notify_pary_id" id="notify_pary_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                        @foreach($notify_parties as $notify_partie)
                        <option value="{{$notify_partie->id}}">{{ $notify_partie->name}}
                        </option>
                        @endforeach
                        </select>
                        @if ($errors->has('notify_pary_id'))
                            <span class="help-block"><strong>{{ $errors->first('notify_pary_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    
               
                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('carrying_mode_id') ? 'has-error' : '' }}">
                        <label for="carrying_mode_id">Carrying Mode <span class="req_style_id">(*)</span></label>
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
                        <label for="loading_place_id">Loading Place <span class="req_style_id">(*)</span></label>
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
                        <label for="final_destination">Final Destination<span class="req_style_id">(*)</span></label>
                        <input name="final_destination" type="text" id="final_destination" class="form-control input-sm"   value=""   required autofocus   placeholder="Final destination" >
                        @if ($errors->has('final_destination'))
                            <span class="help-block"><strong>{{ $errors->first('final_destination') }}</strong></span>
                        @endif
                    </div>
                </div> 

                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('container_1') ? 'has-error' : '' }}">
                        <label for="container_1">Container_1(20 Feet)</label>    
                        <input name="container_1" type="text" id="container_1" class="form-control input-sm"   value="20 Feet"   autofocus   placeholder="container_1" readonly>
                        @if ($errors->has('container_1'))
                            <span class="help-block"><strong>{{ $errors->first('container_1') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group {{ $errors->has('container_qty_1') ? 'has-error' : '' }}">
                        <label for="container_qty_1">Qty</label>    
                        <input name="container_qty_1" type="text" id="container_qty_1" class="form-control input-sm"   value="0"   autofocus   placeholder="" >
                        @if ($errors->has('container_qty_1'))
                            <span class="help-block"><strong>{{ $errors->first('container_qty_1') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('container_2') ? 'has-error' : '' }}">
                        <label for="container_2">Container_2(40 Feet)</label>
                        <input name="container_2" type="text" id="container_2" class="form-control input-sm"   value="40 Feet"   autofocus   placeholder="container_2" readonly>
                        @if ($errors->has('container_2'))
                            <span class="help-block"><strong>{{ $errors->first('container_2') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group {{ $errors->has('container_qty_2') ? 'has-error' : '' }}">
                        <label for="container_qty_2">Qty</label>    
                        <input name="container_qty_2" type="text" id="container_qty_2" class="form-control input-sm"   value="0"   autofocus   placeholder="" >
                        @if ($errors->has('container_qty_2'))
                            <span class="help-block"><strong>{{ $errors->first('container_qty_2') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group {{ $errors->has('container_3') ? 'has-error' : '' }}">
                        <label for="container_3">Container_3(40 HC)</label>
                        <input name="container_3" type="text" id="container_3" class="form-control input-sm"   value="40 HC"   autofocus   placeholder="container_3" readonly>
                        @if ($errors->has('container_3'))
                            <span class="help-block"><strong>{{ $errors->first('container_3') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group {{ $errors->has('container_qty_3') ? 'has-error' : '' }}">
                        <label for="container_qty_3">Qty</label>    
                        <input name="container_qty_3" type="text" id="container_qty_3" class="form-control input-sm"   value="0"   autofocus  placeholder="" >
                        @if ($errors->has('container_qty_3'))
                            <span class="help-block"><strong>{{ $errors->first('container_qty_3') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('freight_cost_1') ? 'has-error' : '' }}">
                        <label for="freight_cost_1">Freight_cost_1(20 Feet)</label>
                        <input name="freight_cost_1" type="text" id="freight_cost_1" class="form-control input-sm"   value="0"    autofocus  placeholder="freight_Cost_1" >
                        @if ($errors->has('freight_cost_1'))
                            <span class="help-block"><strong>{{ $errors->first('freight_cost_1') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('freight_cost_2') ? 'has-error' : '' }}">
                        <label for="freight_cost_2">Freight_Cost_2(40 Feet)</label>
                        <input name="freight_cost_2" type="text" id="freight_cost_2" class="form-control input-sm"   value="0"    autofocus   placeholder="freight_Cost_2" >
                        @if ($errors->has('freight_cost_2'))
                            <span class="help-block"><strong>{{ $errors->first('freight_cost_2') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('freight_cost_3') ? 'has-error' : '' }}">
                        <label for="freight_cost_3">Freight_Cost_3(40 HC)</label>
                        <input name="freight_cost_3" type="text" id="freight_cost_3" class="form-control input-sm"   value="0"    autofocus  placeholder="freight_Cost_3" >
                        @if ($errors->has('freight_cost_3'))
                            <span class="help-block"><strong>{{ $errors->first('freight_cost_3') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('qtan_freight_cost') ? 'has-error' : '' }}">
                        <label for="desk_freight_cost">Freight Cost(For QTAN)</label>
                        <input name="qtan_freight_cost" type="number" step="any" id="qtan_freight_cost" class="form-control input-sm"   value="0"     placeholder="Enter QTAN Freight Cost">
                        @if ($errors->has('qtan_freight_cost'))
                            <span class="help-block"><strong>{{ $errors->first('qtan_freight_cost') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('ci_note') ? 'has-error' : '' }}">
                        <label for="ci_note">CI Note</label>
                        <textarea rows="5" name="ci_note" type="text" id="ci_note" class="form-control input-sm" autofocus  placeholder="Enter CI Note Here" ></textarea>
                        @if ($errors->has('ci_note'))
                            <span class="help-block"><strong>{{ $errors->first('ci_note') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('angikar_given_by') ? 'has-error' : '' }}">
                        <label for="angikar_given_by">Angikar  Given By</label>
                        <textarea rows="5" name="angikar_given_by" type="text" id="angikar_given_by" class="form-control input-sm"      autofocus  placeholder="Enter Angikar Details" ></textarea>
                        @if ($errors->has('angikar_given_by'))
                            <span class="help-block"><strong>{{ $errors->first('angikar_given_by') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('terms_and_condition') ? 'has-error' : '' }}">
                        <label for="terms_and_condition">Terms & Conditions<span class="req_style_id">(*)</span></label>
                        <textarea rows="5" cols="3" name="terms_and_condition" type="text" id="terms_and_condition" class="form-control input-sm" required autofocus   placeholder="" >
@if(old('terms_and_condition')){{old('terms_and_condition')}}@else{{"1. PAYMENT BY TT.
2. TRANSPORT BY SEA. 
3. LOADING OF THE GOODS : WITHIN 90 DAYS FROM THE DATE OF SALES CONTRACT. 
4. PART SHIPMENT & TRANS-SHIPMENT ALLOWED. 
5. ALL BANKING CHARGES OUTSIDE BANGLADESH INCLUDING REMITTING CHARGES ARE ON APPLICANT'S ACCOUNT. 
6. MARKS: PRAN 
7. EXPIRY OF THIS SALES CONTRACT ON:"}} 
@endif
                        </textarea>
                        @if ($errors->has('terms_and_condition'))
                            <span class="help-block"><strong>{{ $errors->first('terms_and_condition') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('terms_and_condition_desk_inv') ? 'has-error' : '' }}">
                        <label for="terms_and_condition_desk_inv">Terms & Conditions(Com Inv)</label>
                        <textarea rows="5" name="terms_and_condition_desk_inv" type="text" id="terms_and_condition_desk_inv" class="form-control input-sm"     autofocus max="191"  placeholder="Enter Terms And Conditions" ></textarea>
                        @if ($errors->has('terms_and_condition_desk_inv'))
                            <span class="help-block"><strong>{{ $errors->first('terms_and_condition_desk_inv') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('importer_name') ? 'has-error' : '' }}">
                        <label for="importer_name">Importer Name</label>
                        <input name="importer_name" type="text" id="importer_name" class="form-control input-sm" placeholder="Auto Field Importer Name" required>
                        @if ($errors->has('importer_name')) 
                            <span class="help-block"><strong>{{ $errors->first('importer_name') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('importer_address') ? 'has-error' : '' }}">
                        <label for="importer_address">Importer Address</label>
                        <textarea name="importer_address" type="text" id="importer_address" class="form-control input-sm" placeholder="Auto Field Importer Address" style="width: 277px; height: 67px;" required></textarea>
                        @if ($errors->has('importer_address'))
                            <span class="help-block"><strong>{{ $errors->first('importer_address') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('party_name') ? 'has-error' : '' }}">
                        <label for="party_name">Notify Party Name</label>
                        <input name="party_name" type="text" id="party_name" class="form-control input-sm"  placeholder="Auto Field Notify Party Name" value="{{$party_name}}">
                        @if ($errors->has('party_name'))
                            <span class="help-block"><strong>{{ $errors->first('party_name') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('party_address') ? 'has-error' : '' }}">
                        <label for="party_address">Notify Party Address</label>
                        <textarea name="party_address" type="text" id="party_address" class="form-control input-sm"  placeholder="Auto Field Notify Party Address Here" style="width: 277px; height: 67px;">{{$party_address}}</textarea>
                        @if ($errors->has('party_address'))
                            <span class="help-block"><strong>{{ $errors->first('party_address') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group {{ $errors->has('party_address') ? 'has-error' : '' }}">
                            <label for="party_address">Also Notify Party</label>
                            <textarea name="third_notify_party" type="text" id="third_notify_party" class="form-control input-sm"  placeholder="Auto Field Also Notify Party" style="width: 277px; height: 67px;">{{$also_notify_party}}</textarea>
                            @if ($errors->has('party_address'))
                                <span class="help-block"><strong>{{ $errors->first('party_address') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group {{ $errors->has('importer_country') ? 'has-error' : '' }}">
                            <label for="importer_country">Importer Country</label>
                            <textarea name="importer_country" type="text" id="importer_country" class="form-control input-sm"      autofocus max="191"  placeholder="Enter Importer Country Name Here" style="width: 277px; height: 67px;"></textarea>
                            @if ($errors->has('importer_country'))
                                <span class="help-block"><strong>{{ $errors->first('importer_country') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="formated_file">Formatted File</label>
                        <input name="formated_file" type="file" id="fiformated_filele" class="form-control input-sm"   value=""   autofocus>
                    </div>
                    <div class="col-sm-3">
                        <label for="pi_file">PI Upload</label>
                        <input name="pi_upload" type="file" id="pi_upload" class="form-control input-sm"   value=""   autofocus>
                    </div>
                </div>
                <div class="row">
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
                            <label for="is_proforma_invoice" >Is Proforma Invoice</label><br>
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
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group form-group {{ $errors->has('footer_importer_address') ? 'has-error' : '' }}">
                            <label for="footer_importer_address" >Footer Importer Address</label><br>
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
                    <div class="col-sm-3">
                        <div class="form-group form-group {{ $errors->has('footer_importer_address') ? 'has-error' : '' }}">
                            <label for="footer_importer_address">With/Without Expiry</label><br>
                            <label class="radio-inline">
                                <input type="radio" name="expaire_show_status"   value="1"   id="footer_importer_address"  autofocus >Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="expaire_show_status" checked  value="0" >No
                            </label>
                            @if ($errors->has('footer_importer_address'))
                                <span class="help-block"><strong>{{ $errors->first('footer_importer_address') }}</strong></span>
                            @endif
                        </div>
                    </div>  
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-info btn-flat"  id="nextButton" style="margin-top: 22px">Create Sales Contract</button> 
                    </div>
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
        </div>
<!-- PO Create Modal -->  
<div class="modal fade" id="po_modal_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PO CREATE FORM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" role="form" method="POST" action="" id="po_definition">
                    {{ csrf_field() }}
                        <div class="box-body">
                          <div class="row">
                              <div class="col-sm-12"> 
                                  <div class="col-sm-4" id="left_side_style">
                                    <span id="po_details_style">Task Master</span>
                                    <br>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <label for="name">Party</label>
                                      <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                        <select name="party_id" id="party_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" required>
                                          <option value="">Select</option>
                                        </select> 
                                      </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                      <label for="name">Date:</label>
                                      <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                                        <input name="create_date" type="text" id="create_date" class="form-control datepicker"  value="<?php echo date('d-m-Y')?>"  placeholder="Select Dated">
                                      </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                      <label for="name">Order Qty</label>
                                      <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                                          <input type="text" name="order_qty"  id="order_qty" class="form-control"  value=""  placeholder="Order Qty">
                                      </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label for="name">Template:</label>
                                        <select name="template_id" id="template_id" data-live-search="true" class="form-control select2 selectpicker" onchange="getTemplateDetails()" "select" required>
                                          <option value="">Select</option>
                                          @foreach($templateNames as $value)
                                            <option value="{{$value->ID}}">{{$value->DESCRIPTION}}</option>
                                          @endforeach
                                        </select> 
                                    </div>
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                      <label for="name">Remarks</label>
                                      <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                                          <textarea class="form-control" id="remark" name="remark"></textarea>
                                      </div>
                                    </div>
                                    <br>
                                    </div>
                                  <div class="col-sm-7" id="right_side_style">
                                    <span id="task_details_style">Task Details</span>
                                     <br>
                                      <div class="row">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="tblMain">
                                                <thead>
                                                    <tr style="background-color: #C9DEE3;">
                                                        <th scope="col" style="width:389px">Task_Name</th>
                                                        <th scope="col" style="width:515px">Assigne</th>
                                                        <th scope="col" style="width:194px">Std_Days</th>
                                                        <th scope="col" style="width:194px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="po_detils">
                                                </tbody>
                                            </table>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                          </div>   
                        </div> 
                  </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBtnID" onclick="return savePODetails()">Submit</button>
            </div>
        </div>
    </div>
</div>        
<script>document.title = 'SalesContract | Create';</script>
<script type="text/javascript">
    $(document).ready(function() {

        setTimeout(function() { 
            $('.sr-only').click();
        }, 0.0001);

        $('#invoice_no').on('keyup paste change', function() {
            var value = $(this).val();
            value = value.replace(/\s/g, '');
            $(this).val(value);
            if (value.length > 3) {
                $.ajax({
                    type: "GET",
                    url: "/check/invoice/number/exist/ornot?invoice_no=" + value,
                    success: function (data) {
                        if (data=='1') {
                            $('#mobile_number_error').html("Already Exists..!!");
                            $('#nextButton').prop("disabled", true);
                        } else {
                            $('#mobile_number_error').html("Not Exists..!!");
                            $('#nextButton').prop("disabled", false);
                        }
                    }
                });
            }
        });

        $('#sales_contract_no').on('keyup paste change input', function() {
            var value = $(this).val();
            var cleaned = value.replace(/\s/g, '');
            if (value !== cleaned) {
                $(this).val(cleaned);
            }
        });

        $(document).on('focus', '.datepicker', function() {
            $(this).prop('readonly', true);
        });

        $('.datepicker').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '2020:2030',
            showButtonPanel: true,
            onSelect: function() {
                $(this).prop('readonly', true);
            }
        });

        $(document).on('keydown', '.datepicker', function(e) {

            var allowedKeys = [8, 9, 27, 46];
            if (allowedKeys.indexOf(e.keyCode) !== -1) {
                return true;
            }
            e.preventDefault();
            return false;
        });

    });

    $('#positiveNumberInput').keypress(function(event) {
        var keyCode = event.which;
        if (keyCode !== 8 && keyCode !== 0 && (keyCode < 48 || keyCode > 57)) {
        event.preventDefault();
        }
    });

    $('#create_po_button').click(function(e){
      
       var party_id=$("#notify_id").val();
       $.ajax({
            method: 'GET',
            url: "/json/get/notify_party",
            success: function (data) {

                if(data.results){

                    var $el = $('#party_id');
                    $el.html('');
                    $el.append($("<option></option>").attr("value", "").text("--Select--"));
                    $.each(data.results, function (key, value) {
                       
                        $('select[name="party_id"]').append(`<option value="${value.id}" ${value.id == party_id ? 'selected' : ''}>${value.code}-${value.name}</option>`)

                    });
                    $el.selectpicker('refresh');


                }else{

                    var $el = $('#party_id');
                    $el.html(' ');
                    $el.append($("<option></option>").attr("value", "").text("Select"));
                    $el.selectpicker('refresh'); 

                }    

            },
            error: function (e) {

                console.log(e);

            }

         });
       
         $('#po_modal_id').modal('show');
         
    });

    function savePODetails(){

        var party_id=$('#party_id').val();
        var create_date=$('#create_date').val();
        var order_qty=$('#order_qty').val(); 
        var template_id=$('#template_id').val();
        var remark=$('#remark').val();
        if(party_id==""){
        
        Swal.fire({

            title: 'Alert ! <br> Please Select Notify Party..!!',
            
        });
            
        return false;

        }else if(create_date==""){

        Swal.fire({

            title: 'Alert ! <br> Create Date Connot Be Empty..!!',

        });

        return false; 

        }else if(order_qty==""){

        Swal.fire({

            title: 'Alert ! <br> Order Qty Connot Be Empty..!!',

        });

        return false;

        }else if(template_id==""){

            Swal.fire({

            title: 'Alert !<br>Template Can Not Be Empty..!!',

            });

            return false;

        }else{
            
            $(".preload").show();
            var results = new Array();
            $("#tblMain tbody TR").each(function () {

                var row = $(this);
                var po_info = {};
                po_info.task_id = row.find("TD").eq(1).html();
                po_info.type_id = $(this).find("select").val();
                po_info.status=$(this).find('option:selected').attr("name");
                po_info.std=$(this).find("td:eq(3) input[type='text']").val();
                results.push(po_info);

            });
                    
            $.ajax({
                method: 'POST',
                url: "/po",
                data: {
                    'results': results,
                    'party_id': party_id,
                    'create_date':create_date,
                    'order_qty':order_qty,
                    'template_id':template_id,
                    'remark':remark,
                    '_token': $('input[name=_token]').val()
                },
                success: function (res){

                    if(res.status=='Success'){
                        
                        Swal.fire({  
                                icon: 'success',
                                title: 'Success <br><br><br><br> PO NO : ' + res.po_number,    
                                denyButtonText: `Don't save`,
                            })

                        $('#po_definition').trigger("reset");
                        $('#template_id').selectpicker('refresh');
                        $('#party_id').selectpicker('refresh');
                        $("#po_detils").empty();
                        $('#po_modal_id').modal('hide');
                        loadPO();


                    }else if(res.status=='Error'){

                        Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'PO already create this party..!!',
                        showConfirmButton: false,
                        timer: 1500
                        });

                    }
                    
                    $(".preload").hide();

                },
                error: function (e) {

                    console.log(e);

                }

            }); 

        }

    }

    function getTemplateDetails(){             
       
       $(".preload").show();
       var template_id=$('#template_id').val();
       if(template_id){
         $.ajax({
               method: 'GET',
               url: "/json/get/template/details",
               data: {
                 'template_id': template_id,
                 '_token': $('input[name=_token]').val()
               },
               success: function (res) {
                  
                 console.log(res);
 
                 if(res.results.length>0){
                       
                     var rows = '';
 
                     $.each(res.results, function (key, value) {
 
                       var user=res.user;
                       var userTypes=res.userTypes;
                       var desk_user=res.desk_user;
                       var select='<select class="form-control input-sm" id="user_id" name="user_id">';
                       for(var i=0; i<userTypes.length; i++){
                              
                           if(value.user_type==userTypes[i].id && value.user_type==1){
 
                             select+='<option value="'+userTypes[i].id+'" name="parent">'+userTypes[i].name+'</option>';
                             
                             for(var j=0; j<desk_user.length; j++){
                                 
                                select+='<option value="'+desk_user[j].id+'" name="child">'+desk_user[j].name+'</option>';
 
                             }
 
                           }
 
                           if(value.user_type==userTypes[i].id){
 
                             select+='<option value="'+userTypes[i].id+'" name="parent">'+userTypes[i].name+'</option>';
 
                             for(var j=0; j<user.length; j++){
                                 
                               if(userTypes[i].id==user[j].type_id){
                                 
                                 select+='<option value="'+user[j].id+'" name="child">'+user[j].name+'</option>';
 
                               }
 
                             }
 
                           }
                           
                       }
 
                       select+="</select>";
 
                       var buttonStatus = (value.status==1) ? 'disabled' : '';
                       rows = rows + '<tr>';
                       rows = rows + '<td style="font-weight:bold;width:200px">' + value.template_name + '</td>';
                       rows = rows + '<td style="display:none">' + value.id + '</td>';
                       rows = rows + '<td style="font-weight:bold">'+select+'</td>';
                       rows = rows + '<td style="font-weight:bold">'+'<input type="text" name="std" id="std" value="'+value.std+'" style="width: 117px;">'+'</td>';
                       rows = rows + '<td style="font-weight:bold;width: 89px;">'+'<input type="button" class="btn btn-sm btn-danger btnDelete" value="X" style="width: 42%;height: 25px;padding: 2px 2px;" '+buttonStatus+'>'+'</td>';
                       rows = rows + '</tr>';
 
                     });
 
                     $("#po_detils").html(rows);
                     $(".preload").hide();
                     $("#saveBtnID").attr("disabled",false);
 
                 }else{
 
                   Swal.fire('Alert','Your Desk Not Setup..!!');
                   $(".preload").hide();
                   $("#saveBtnID").attr("disabled",true);
                   return false;
 
                 }
 
               },
               error: function (e) {
 
                   console.log(e);
 
               }
 
         });
 
       } 
        
     } 

    //@@@Submit Create Form@@@@
    $("#createForm").submit(function (e) {

        e.preventDefault(); 
        var formData = new FormData($(this)[0]);
        var excelFile = formData.get('formated_file');
        var pi_upload = formData.get('pi_upload');
        $.ajax({
            type:'POST',
            url: "{{ url('/sale_contract')}}",
            data: formData,
            cache: false,
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

                   if(res.call_status==1){

                        $("#container_qty_1").prop("readonly", true);
                        $("#container_qty_2").prop("readonly", true);
                        $("#container_qty_3").prop("readonly", true);
                        $("#qtan_freight_cost").prop("readonly", true);

                   }

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
                       text: res.message
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
                    $el.append($("<option></option>").attr("value", value['PO_NO']).text(value['SPO_NO']));
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


    $('#importer_id').change(function(){

        var importer_id = $(this).val(); 
        var url = "{{url('/')}}"+"/json/get/party/last_shipment/histroy?importer_id="+importer_id;
        $.get(url,function(res){
           
            $('#importer_name').val(res.importer_name);
            $('#importer_address').val(res.importer_address);

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

</script>
@endsection