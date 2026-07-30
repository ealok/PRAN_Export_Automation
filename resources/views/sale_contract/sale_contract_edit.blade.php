<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content')
<style>
      /* Table font sizes */
    .table thead th {
        font-size: 11px !important; /* Reduced from 12px */
        padding: 8px 6px !important; /* Adjusted padding */
        text-align: center !important;
        vertical-align: middle !important;
    }
    
    .table tbody td {
        font-size: 11px !important; /* Reduced from 12px */
        padding: 6px 4px !important; /* Adjusted padding */
        text-align: center !important; /* Center align all cells */
        vertical-align: middle !important;
    }
    
    /* Specific alignment for certain columns */
    .table tbody td:first-child {
        text-align: center !important; /* Checkbox column */
    }
    
    .table tbody td:nth-child(2), /* Item code */
    .table tbody td:nth-child(4), /* Hs code */
    .table tbody td:nth-child(5), /* Ctn (qty) */
    .table tbody td:nth-child(6), /* Rate /ctn (act) */
    .table tbody td:nth-child(7), /* Total(act) */
    .table tbody td:nth-child(8), /* Rate /ctn(party) */
    .table tbody td:nth-child(9), /* Total(Party) */
    .table tbody td:nth-child(10), /* Rate /ctn(CI) */
    .table tbody td:nth-child(11), /* Total (CI) */
    .table tbody td:nth-child(12), /* Cbm /ctn */
    .table tbody td:nth-child(13), /* Total cbm */
    .table tbody td:nth-child(14), /* Gross Weight */
    .table tbody td:nth-child(15) { /* Pcs in ctn */
        text-align: center !important;
    }
    
    /* Third column (Ci item) align left for readability */
    .table tbody td:nth-child(3) {
        text-align: left !important;
        padding-left: 8px !important;
    }
    
    /* Increase last column width for buttons */
    .table tbody td:last-child {
        text-align: center !important;
        white-space: nowrap !important;
    }
    
    /* Adjust button sizing in last column to fit better */
    .table td:last-child .btn {
        font-size: 10px !important; /* Reduced font size */
        padding: 3px 6px !important; /* Reduced padding */
        margin: 1px 2px !important;
        min-width: 70px !important; /* Minimum width for consistency */
        display: inline-block !important;
        white-space: nowrap !important;
    }
    
    /* Total row font adjustment */
    .table tbody tr[style*="background: aquamarine"] td {
        font-size: 12px !important; /* Slightly larger for emphasis */
        text-align: center !important;
    }
        
    .table td:last-child .btn-xs {
        line-height: 1.2 !important;
        height: 24px !important;
    }
    
    /* Responsive adjustments for very small screens */
    @media (max-width: 768px) {
        .table thead th {
            font-size: 10px !important;
            padding: 6px 4px !important;
        }
        
        .table tbody td {
            font-size: 10px !important;
            padding: 4px 3px !important;
        }
        
        .table tbody td:last-child {
            width: 180px !important;
        }
        
        .table td:last-child .btn {
            font-size: 9px !important;
            padding: 2px 4px !important;
            min-width: 65px !important;
        }
    }
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
    #make_priceSame_id,
    .btn-primary[type="button"] {
        background-color: #3b82f6 !important;
        color: white !important;
        font-weight: 500;
    }
    
    .btn-primary:hover,
    .btn-primary.btn-flat:hover,
    #make_priceSame_id:hover {
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
    .btn-danger.btn-sm,
    .delete_all,
    .delete_all.btn-sm {
        background-color: #ef4444 !important;
        border: 2px solid #ef4444 !important;
        color: white !important;
        font-weight: 500;
    }
    
    .btn-danger:hover,
    .btn-danger.btn-sm:hover,
    .delete_all:hover {
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
    .btn-success.btn-flat,
    .edit-desk-btn,
    a .btn-success,
    a .btn-success.btn-sm {
        background-color: #10b981 !important;
        border: 2px solid #10b981 !important;
        color: white !important;
        font-weight: 500;
    }
    
    .btn-success:hover,
    .btn-success.btn-sm:hover,
    .btn-success.btn-flat:hover,
    .edit-desk-btn:hover {
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
    
    /* Edit CI Button - Blue Theme */
    .edit-ci-btn,
    .btn-primary.btn-flat.edit-ci-btn {
        background-color: #3b82f6 !important;
        border: 2px solid #3b82f6 !important;
        color: white !important;
        font-weight: 500;
    }
    
    .edit-ci-btn:hover {
        background-color: #2563eb !important;
        border-color: #2563eb !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
    
    /* Delete Modal Button */
    #delete_modal_form .btn-info.pull-left {
        background-color: #ef4444 !important;
        border: 2px solid #ef4444 !important;
        color: white !important;
        font-weight: 500;
    }
    
    #delete_modal_form .btn-info.pull-left:hover {
        background-color: #dc2626 !important;
        border-color: #dc2626 !important;
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
     /* à¦¨à¦¤à§à¦¨ à¦¸à§à¦Ÿà¦¾à¦‡à¦²à¦¸ */
    .dual-form-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }
    
    .form-section {
        flex: 1;
        min-width: 300px;
        background: #ffffff;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .form-header {
        background: #4f46e5;
        color: white;
        padding: 10px 15px;
        margin: -20px -20px 20px -20px;
        border-radius: 6px 6px 0 0;
        font-weight: bold;
        text-align: center;
    }

    .modal-content .form-group {
       margin-bottom: -2px !important;
    }
    
    .form-section.desk-form .form-header {
        background: #10b981;
    }
    .btn-danger[data-dismiss="modal"] {
        background-color: #ff0909 !important;
        color: white !important;
        font-weight: 500;
    }
    
    .form-section.ci-form .form-header {
        background: #3b82f6;
    }
    
    .tab-container {
        margin-top: 20px;
    }
    
    .nav-tabs {
        border-bottom: 2px solid #e5e7eb;
        margin-bottom: 20px;
    }
    
    .nav-tabs .nav-link {
        border: 2px solid transparent;
        border-bottom: none;
        border-radius: 6px 6px 0 0;
        padding: 10px 20px;
        font-weight: 500;
        color: #6b7280;
        transition: all 0.3s;
    }
    
    .nav-tabs .nav-link.active {
        color: #4f46e5;
        background-color: #f8fafc;
        border-color: #e5e7eb #e5e7eb #ffffff;
    }
    
    .nav-tabs .nav-link:hover {
        border-color: #e5e7eb;
        color: #4f46e5;
    }
    
    .tab-content {
        padding: 20px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 0 0 6px 6px;
    }
    
    .toggle-view-btn {
        background: #8b5cf6;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
    }
    
    .toggle-view-btn:hover {
        background: #7c3aed;
        transform: translateY(-1px);
    }
    
    .single-view {
        max-width: 800px;
        margin: 0 auto;
    }
    /* Add this to your CSS file */
    .empty-state {
        background-color: #f9f9f9;
        border: 1px dashed #ddd;
    }

    .empty-state td {
        color: #666;
        font-style: italic;
    }

    /* Ensure table headers stay visible */
    #tblMain thead {
        background-color: #f5f5f5;
    }

    /* Style for the empty state icon */
    .fa-box-open {
        opacity: 0.5;
    }
    /* Remove all default margins in the edit desk modal */
    #editDeskModal .modal-body .form-group {
        margin-bottom: 0 !important;
    }

    #editDeskModal .modal-body input,
    #editDeskModal .modal-body select,
    #editDeskModal .modal-body textarea,
    #editDeskModal .modal-body .form-control {
        margin-bottom: 0 !important;
    }

    /* Add custom spacing if needed */
    #editDeskModal .modal-body .form-group + .form-group {
        margin-top: 15px; /* Add spacing between form groups */
    }
    close {
        float: right;
        font-size: 21px;
        font-weight: 700;
        line-height: 1;
        color: #fffbfb;
   }
   .total-row {
        background: #0a1c7be8 !important;
        color: white !important;
        font-weight: bold;
    }

    .total-row td {
        font-weight: bold;
        text-align: center !important;
    } 
</style>
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
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
                                <label for="sales_contract_no">Sales Contract No</label>
                                <input name="sales_contract_no" type="text" id="sales_contract_no" class="form-control input-sm"   value="{{$sale_contract->sales_contract_no}}"   required  max="191"  placeholder="Sales contract no" >
                                @if ($errors->has('sales_contract_no'))
                                    <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('dated') ? 'has-error' : '' }}">
                                <label for="dated">Sales Contract Date</label>
                                <input name="dated" type="text" id="dated" class="form-control datepicker input-sm" value="{{date('d-m-Y', strtotime($sale_contract->dated))}}" required placeholder="Dated" autocomplete="off" is_date="1" readonly>
                                @if ($errors->has('dated'))
                                    <span class="help-block"><strong>{{ $errors->first('dated') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('invoice_no') ? 'has-error' : '' }}">
                                <label for="invoice_no">Invoice No</label>
                                <input name="invoice_no" type="text" id="invoice_no" class="form-control input-sm"   value="{{ $sale_contract->invoice_no }}"   max="191"  placeholder="Invoice No" required="">
                                <span id="mobile_number_error" style="color: red;position: absolute;top: 0px;left: 97px;"></span>
                                @if ($errors->has('invoice_no'))
                                    <span class="help-block"><strong>{{ $errors->first('invoice_no') }}</strong></span>
                                @endif
                            </div>
                        </div>
                       <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('invoice_date') ? 'has-error' : '' }}">
                                <label for="invoice_date">Invoice Date</label>
                                <input name="invoice_date" type="text" id="invoice_date" class="form-control datepicker input-sm" value="@if($sale_contract->invoice_date){{date('d-m-Y', strtotime($sale_contract->invoice_date))}}@endif" placeholder="invoice_date" autocomplete="off" is_date="1" readonly>
                                @if ($errors->has('invoice_date'))
                                    <span class="help-block"><strong>{{ $errors->first('invoice_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('discharge_port') ? 'has-error' : '' }}">
                                <label for="discharge_port">Discharge Port</label>
                                <input name="discharge_port" type="text" id="discharge_port" class="form-control input-sm"   value="{{ $sale_contract->discharge_port }}"   max="191"  placeholder="Discharge Port" >
                                @if ($errors->has('discharge_port'))
                                    <span class="help-block"><strong>{{ $errors->first('discharge_port') }}</strong></span>
                                @endif
                            </div>
                        </div>  
                        <div class="col-sm-2">
                            <div class="form-group{{ $errors->has('country_id') ? 'has-error' : '' }}">
                                <label for="country_id">Country</label>
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
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group{{ $errors->has('sales_term_id') ? 'has-error' : '' }}">
                                <label for="sales_term_id">Sales Term</label>
                                <select name="sales_term_id" id="sales_term_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1"  @if($freightSynStatus){{'disabled'}}@endif>
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
                        <div class="col-sm-2">
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
                        <div class="col-sm-2">
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
                        <div class="col-sm-2">
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
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('importer_name') ? 'has-error' : '' }}">
                                <label for="importer_name">Importer Name</label>
                                <input name="importer_name" type="text" id="importer_name" class="form-control input-sm" value="{{$sale_contract->importer_name}}" placeholder="Auto Field Importer Name" required readonly>
                                @if ($errors->has('importer_name')) 
                                    <span class="help-block"><strong>{{ $errors->first('importer_name') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('importer_address') ? 'has-error' : '' }}">
                                <label for="importer_address">Importer Address</label>
                                <textarea name="importer_address" type="text" id="importer_address" class="form-control input-sm" placeholder="Auto Field Importer Address" required readonly>{{$sale_contract->importer_address}}</textarea>
                                @if ($errors->has('importer_address'))
                                    <span class="help-block"><strong>{{ $errors->first('importer_address') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group{{ $errors->has('bank_importer_id') ? 'has-error' : '' }}">
                                <label for="bank_importer_id">Importer Bank </label>
                                <select name="bank_importer_id" id="bank_importer_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"   value="1" >
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
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('importer_country') ? 'has-error' : '' }}">
                                <label for="importer_country">Importer Country</label>
                                <input name="importer_country" type="text" id="importer_country" class="form-control input-sm"   value="{{ $sale_contract->importer_country }}"   max="191"  placeholder="importer_country" >
                                @if ($errors->has('importer_country'))
                                    <span class="help-block"><strong>{{ $errors->first('importer_country') }}</strong></span>
                                @endif
                            </div>
                        </div> 
                        <div class="col-sm-2">
                            <div class="form-group{{ $errors->has('notify_pary_id') ? 'has-error' : '' }}">
                                <label for="notify_pary_id">Notify Party</label>
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
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('party_name') ? 'has-error' : '' }}">
                                <label for="party_name">Notify Party Name</label>
                                <input name="party_name" type="text" id="party_name" class="form-control input-sm"  placeholder="Auto Field Notify Party Name" value="{{$sale_contract->party_name}}">
                                @if ($errors->has('party_name'))
                                    <span class="help-block"><strong>{{ $errors->first('party_name') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('party_address') ? 'has-error' : '' }}">
                                <label for="party_address">Notify Party Address</label>
                                <textarea name="party_address" type="text" id="party_address" class="form-control input-sm"  placeholder="Auto Field Notify Party Address Here">{{$sale_contract->party_address}}</textarea>
                                @if ($errors->has('party_address'))
                                    <span class="help-block"><strong>{{ $errors->first('party_address') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group{{ $errors->has('carrying_mode_id') ? 'has-error' : '' }}">
                                <label for="carrying_mode_id">Carrying Mode </label>
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
                    </div>  
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group{{ $errors->has('loading_place_id') ? 'has-error' : '' }}">
                                <label for="loading_place_id">Loading Place</label>
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
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('final_destination') ? 'has-error' : '' }}">
                                <label for="final_destination">Final Destination</label>
                                <input name="final_destination" type="text" id="final_destination" class="form-control input-sm"   value="{{$sale_contract->final_destination}}"   required  max="191"  placeholder="Final destination" >
                                @if ($errors->has('final_destination'))
                                    <span class="help-block"><strong>{{ $errors->first('final_destination') }}</strong></span>
                                @endif
                            </div>
                        </div> 
                        <div class="col-sm-1">
                            <div class="form-group {{ $errors->has('container_1') ? 'has-error' : '' }}">
                                <label for="container_1">C1_20FT</label>
                                <input name="container_1" type="text" id="container_1" class="form-control input-sm"   value="20 Feet"    max="191"  placeholder="container_1" readonly>
                                @if ($errors->has('container_1'))
                                    <span class="help-block"><strong>{{ $errors->first('container_1') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group {{ $errors->has('container_qty_1') ? 'has-error' : '' }}">
                                <label for="container_qty_1">Qty</label>    
                                <input name="container_qty_1" type="text" id="container_qty_1" class="form-control input-sm"   value="{{$container_qty1}}"    max="191"  placeholder="" @if($freightSynStatus){{'readonly'}}@endif>
                                @if ($errors->has('container_qty_1'))
                                    <span class="help-block"><strong>{{ $errors->first('container_qty_1') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group {{ $errors->has('container_2') ? 'has-error' : '' }}">
                                <label for="container_2">C2_40FT</label>
                                <input name="container_2" type="text" id="container_2" class="form-control input-sm"   value="40 Feet"    max="191"  placeholder="container_2" readonly>
                                @if ($errors->has('container_2'))
                                    <span class="help-block"><strong>{{ $errors->first('container_2') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group {{ $errors->has('container_qty_2') ? 'has-error' : '' }}">
                                <label for="container_qty_2">Qty</label>    
                                <input name="container_qty_2" type="text" id="container_qty_2" class="form-control input-sm"   value="{{$container_qty2}}"    max="191"  placeholder="" @if($freightSynStatus){{'readonly'}}@endif>
                                @if ($errors->has('container_qty_2'))
                                    <span class="help-block"><strong>{{ $errors->first('container_qty_2') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group {{ $errors->has('container_3') ? 'has-error' : '' }}">
                                <label for="container_3">C3_40HC</label>
                                <input name="container_3" type="text" id="container_3" class="form-control input-sm"   value="40 HC"   max="191"  placeholder="container_3" readonly>
                                @if ($errors->has('container_3'))
                                    <span class="help-block"><strong>{{ $errors->first('container_3') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group {{ $errors->has('container_qty_3') ? 'has-error' : '' }}">
                                <label for="container_qty_3">Qty</label>    
                                <input name="container_qty_3" type="text" id="container_qty_3" class="form-control input-sm"   value="{{$container_qty3}}"    max="191"  placeholder="" @if($freightSynStatus){{'readonly'}}@endif>
                                @if ($errors->has('container_qty_3'))
                                    <span class="help-block"><strong>{{ $errors->first('container_qty_3') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group {{ $errors->has('freight_cost_1') ? 'has-error' : '' }}">
                                <label for="freight_cost_1">Frt_20â€™C1</label>
                                <input name="freight_cost_1" type="text" id="freight_cost_1" class="form-control input-sm"   value="{{$sale_contract->freight_cost_1}}"     max="191"  placeholder="freight_cost_1" @if($freightSynStatus){{'readonly'}}@endif>
                                @if ($errors->has('freight_cost_1'))
                                    <span class="help-block"><strong>{{ $errors->first('freight_cost_1') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group {{ $errors->has('freight_cost_2') ? 'has-error' : '' }}">
                                <label for="freight_cost_2">Frt_40'C2</label>
                                <input name="freight_cost_2" type="text" id="freight_cost_2" class="form-control input-sm"   value="{{$sale_contract->freight_cost_2}}"     max="191"  placeholder="freight_cost_2" @if($freightSynStatus){{'readonly'}}@endif>
                                @if ($errors->has('freight_cost_2'))
                                    <span class="help-block"><strong>{{ $errors->first('freight_cost_2') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('freight_cost_3') ? 'has-error' : '' }}">
                                <label for="freight_cost_3">Frt_40HC'C3</label>
                                <input name="freight_cost_3" type="text" id="freight_cost_3" class="form-control input-sm"   value="{{$sale_contract->freight_cost_3}}"    max="191"  placeholder="freight_cost_3" @if($sale_contract->desk_approver_id){{'readonly'}}@endif>
                                @if ($errors->has('freight_cost_3'))
                                    <span class="help-block"><strong>{{ $errors->first('freight_cost_3') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('desk_freight_cost') ? 'has-error' : '' }}">
                                <label for="desk_freight_cost">FrtCstDsk(Rev)</label>
                                <input name="desk_freight_cost" type="text" id="desk_freight_cost" class="form-control input-sm"   value="{{ $sale_contract->desk_freight_cost }}"   max="191"  placeholder="desk_freight_cost">
                                @if ($errors->has('desk_freight_cost'))
                                    <span class="help-block"><strong>{{ $errors->first('desk_freight_cost') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('qtan_freight_cost') ? 'has-error' : '' }}">
                                <label for="desk_freight_cost">Frt Cost(QTAN)</label>
                                <input name="qtan_freight_cost" type="number" min="0" step="any" id="qtan_freight_cost" class="form-control input-sm"   value="{{ $sale_contract->qtan_freight_cost }}"  placeholder="Enter QTAN Freight Cost" @if($freightSynStatus){{'readonly'}}@endif>
                                @if ($errors->has('qtan_freight_cost'))
                                    <span class="help-block"><strong>{{ $errors->first('qtan_freight_cost') }}</strong></span>
                                @endif
                            </div>
                        </div>           
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('export_no') ? 'has-error' : '' }}">
                                <label for="export_no">Exp No</label>
                                <input name="export_no" type="text" id="export_no" class="form-control input-sm"   value="{{ $sale_contract->export_no}}"   max="191"  placeholder="Export No" >
                                @if ($errors->has('export_no'))
                                    <span class="help-block"><strong>{{ $errors->first('export_no') }}</strong></span>
                                @endif
                            </div>
                        </div> 
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('export_date') ? 'has-error' : '' }}">
                                <label for="export_date">Exp Date</label>
                                <input name="export_date" type="text" id="export_date" class="form-control datepicker input-sm" value="@if($sale_contract->export_date){{date('d-m-Y', strtotime($sale_contract->export_date))}}@endif" placeholder="Export date" autocomplete="off" is_date="1" readonly>
                                @if ($errors->has('export_date'))
                                    <span class="help-block"><strong>{{ $errors->first('export_date') }}</strong></span>
                                @endif
                            </div>
                        </div>  
                        <div class="col-sm-2">
                            <div class="form-group {{ $errors->has('container') ? 'has-error' : '' }}">
                                <label for="container">Container(CI Use Only)</label>
                                <input name="container" type="text" id="container" class="form-control input-sm"   value="{{$sale_contract->container}}"    max="191"  placeholder="Container" >
                                @if ($errors->has('container'))
                                    <span class="help-block"><strong>{{ $errors->first('container') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
                                <label for="bl_no">BL No(For CO)</label>
                                <input name="bl_no" type="text" id="bl_no" class="form-control input-sm"   value="{{ $sale_contract->bl_no }}"   max="191"  placeholder="bl_no">
                                @if ($errors->has('bl_no'))
                                    <span class="help-block"><strong>{{ $errors->first('bl_no') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('bl_date') ? 'has-error' : '' }}">
                                <label for="bl_date">BL Date(For CO)</label>
                                <input name="bl_date" type="text" id="bl_date" class="form-control datepicker input-sm"  value="@if($sale_contract->bl_date){{date('d-m-Y', strtotime($sale_contract->bl_date))}}@endif"    placeholder="Bl date"  autocomplete="off"  is_date="1" >
                                @if ($errors->has('bl_date'))
                                    <span class="help-block"><strong>{{ $errors->first('bl_date') }}</strong></span>
                                @endif
                            </div>
                        </div> 
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('bl_date_cer') ? 'has-error' : '' }}">
                                <label for="bl_date_cer">BL Date(For CER)</label>
                                <input name="bl_date_cer" type="text" id="bl_date_cer" class="form-control datepicker input-sm"  value="@if($sale_contract->bl_date_cer){{date('d-m-Y', strtotime($sale_contract->bl_date_cer))}}@endif"    placeholder="Bl date for cer"  autocomplete="off"  is_date="1" >
                                @if ($errors->has('bl_date_cer'))
                                    <span class="help-block"><strong>{{$errors->first('bl_date_cer')}}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group form-group {{ $errors->has('is_proforma_invoice') ? 'has-error' : '' }}">
                                <label for="is_proforma_invoice" >Vessel/VOY Name(For CO)</label><br>
                                <input name="vehicle" type="text" id="" class="form-control input-sm"   value="{{$sale_contract->vehicle}}"  placeholder="vehicle Name" >
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('mv_or_voy') ? 'has-error' : '' }}">
                                <label for="mv_or_voy">M.V. /VOY: </label>
                                <input name="mv_or_voy" type="text" id="mv_or_voy" class="form-control input-sm"  placeholder="Enter Your MV/VOY Name" value="{{$sale_contract->mv_or_voy}}">
                                @if ($errors->has('mv_or_voy'))
                                    <span class="help-block"><strong>{{ $errors->first('mv_or_voy') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('container_number') ? 'has-error' : '' }}">
                                <label for="container_number">Container Number: </label>
                                <input name="container_number" type="text" id="container_number" class="form-control input-sm"  placeholder="Enter Your Container Number" value="{{$sale_contract->container_number}}">
                                @if ($errors->has('container_number'))
                                    <span class="help-block"><strong>{{ $errors->first('container_number') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group form-group {{ $errors->has('is_proforma_invoice') ? 'has-error' : '' }}">
                                <label for="is_proforma_invoice" >Product Name(For CO)</label><br>
                                <input name="revise_product_name" type="text" id="" class="form-control input-sm"   value="{{$sale_contract->revise_product_name}}"  placeholder="Product Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">    
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('bl_date') ? 'has-error' : '' }}">
                                <label for="bl_date">Tr Report Date</label>
                                <input name="tr_report_date" type="text" id="tr_report_date" class="form-control datepicker input-sm"  value="{{$sale_contract->tr_report_date}}"  placeholder="Select TR Report Date">
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
                            <div class="form-group">
                                <label for="phyto_product_name">Foreign Port(Only For Land)</label>
                                <input name="foreign_port" type="text" id="foreign_port" class="form-control input-sm"   value="{{ $sale_contract->foreign_port }}"   max="191"  placeholder="Foreign Port (For Land)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="phyto_product_name">Foreign Port(Only For Land)</label>
                                <input name="foreign_port" type="text" id="foreign_port" class="form-control input-sm"   value="{{ $sale_contract->foreign_port }}"   max="191"  placeholder="Foreign Port (For Land)">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('terms_and_condition') ? 'has-error' : '' }}">
                                <label for="terms_and_condition">Terms And Conditions</label>
                                <textarea rows="5" name="terms_and_condition" type="text" id="terms_and_condition" class="form-control input-sm"     required  max="191"  placeholder="" style="width: 285px; height: 83px;">{{$sale_contract->terms_and_condition}}
                                </textarea>
                                @if ($errors->has('terms_and_condition'))
                                    <span class="help-block"><strong>{{ $errors->first('terms_and_condition') }}</strong></span>
                                @endif
                            </div>
                        </div> 
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('terms_and_condition_desk_inv') ? 'has-error' : '' }}">
                                <label for="terms_and_condition_desk_inv">Terms And Conditions(Com Inv)</label>
                                <textarea rows="5" name="terms_and_condition_desk_inv" type="text" id="terms_and_condition_desk_inv" class="form-control input-sm"       max="191"  placeholder="Enter Terms And Condtions" style="width: 285px; height: 83px;">{{$sale_contract->terms_and_condition_desk_inv}}</textarea>
                                @if ($errors->has('terms_and_condition_desk_inv'))
                                    <span class="help-block"><strong>{{ $errors->first('terms_and_condition_desk_inv') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('angikar_given_by') ? 'has-error' : '' }}">
                                <label for="angikar_given_by">Angikar  Given By</label>
                                <textarea rows="5" name="angikar_given_by" type="text" id="angikar_given_by" class="form-control input-sm"      max="191"  placeholder="Enter Angikar" style="width: 285px; height: 83px;">{{$sale_contract->angikar_given_by}}</textarea>
                                @if ($errors->has('angikar_given_by'))
                                    <span class="help-block"><strong>{{ $errors->first('angikar_given_by') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>   
                    <div class="row">  
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('phyto_product_name') ? 'has-error' : '' }}">
                                <label for="phyto_product_name">Phyto Product Name</label>
                                <textarea rows="5" name="phyto_product_name" type="text" id="phyto_product_name" class="form-control input-sm"      max="191"  placeholder="Enter Phyto Product Name" style="width: 285px; height: 83px;">{{$sale_contract->phyto_product_name}}</textarea>
                                @if ($errors->has('phyto_product_name'))
                                    <span class="help-block"><strong>{{ $errors->first('phyto_product_name') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3"><strong>Also Notify Party</strong><br><textarea class="form-control input-sm" rows="5" name="third_notify_party" placeholder="Enter Also Notify Party" style="width: 285px; height: 83px;">{{$sale_contract->third_notify_party}}</textarea></div>
                        <div class="col-sm-3"><strong>Bank Address(Only For India)</strong><br><textarea class="form-control input-sm" rows="5" name="bank_address_for_india" placeholder="Enter Bank Address" style="width: 285px; height: 83px;">{{$sale_contract->bank_address_for_india}}</textarea></div>    
                        <div class="col-sm-3"><strong>Custom Decleration(For India)</strong><br><textarea class="form-control input-sm" rows="5" name="custom_decleration" placeholder="Enter Custom Decleration" style="width: 285px; height: 83px;">{{$sale_contract->custom_decleration}}</textarea></div>
                    </div>
                    <div class="row">
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
                                <label for="phyto_product_name">BD Port(ONly For Land)</label>
                                <input name="bd_port" type="text" id="bd_port" class="form-control  input-sm"   value="{{ $sale_contract->bd_port }}"   max="191"  placeholder="">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="formated_file">LC Terms(Only For India)</label>
                            <input name="lc_term_for_india" type="text"  class="form-control input-sm" value="{{$sale_contract->lc_term_for_india}}" placeholder="Enter LC Terms(Only India)">
                        </div>
                        <div class="col-sm-3">
                            <label for="formated_file">Advance Payment</label>
                            <input name="advance_payment" type="text"  class="form-control input-sm"   value="{{$sale_contract->advance_payment}}" placeholder="Enter Advance payment">
                        </div>
                    </div>  
                    <div class="row">  
                        <div class="col-sm-3">
                            <label for="formated_file">Freight Charge(For India)</label>
                            <input name="freight_charge_india" type="text"  class="form-control input-sm"   value="{{$sale_contract->freight_charge_india}}" placeholder="Enter Freight Charge(Only India)">
                        </div>
                        <div class="col-sm-3">
                            <label for="formated_file">Lot Number(For India)</label>
                            <input name="lot_number" type="text"  class="form-control input-sm"   value="{{$sale_contract->lot_number}}" placeholder="Enter lot Number(Only India)">
                        </div>
                        <div class="col-sm-3">
                            <label for="formated_file">Best Before(For India)</label>
                            <input name="best_before_india" type="text"  class="form-control input-sm"   value="{{$sale_contract->best_before_india}}" placeholder="Enter Best Before(Only India)">
                        </div>
                        <div class="col-sm-3">
                            <label for="formated_file">GSP Ref# NO</label>
                            <input name="gsp_ref_number" type="text"  class="form-control input-sm"   value="{{$sale_contract->gsp_ref_number}}" placeholder="Enter GSP REF# NO">
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="formated_file">Shipping Mark(India)</label>
                            <input name="shipping_mark_india" type="text"  class="form-control input-sm"   value="{{$sale_contract->shipping_mark_india}}" placeholder="Enter Shipping Mark(Only India)">
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
                    </div>
                    <div class="row">    
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('arv_amount_received_date') ? 'has-error' : '' }}">
                                <label for="arv_amount_received_date">ArvAmtRecDate_India</label>
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
                    </div>
                    <div class="row">    
                        <div class="col-sm-3">
                            <div class="form-group{{ $errors->has('custom_station_id') ? 'has-error' : '' }}">
                                <label for="custom_station_id">Custom Station</label>
                                <select name="custom_station_id" id="custom_station_id" data-live-search="true" class="form-control select2 selectpicker input-sm"  type="select"  value="1" >
                                    <option value="">Select</option>
                                    @foreach($customStations as $customStation)
                                        <option value="{{$customStation->id}}"  @if($customStation->id == $sale_contract->custom_station_id){{"selected"}} @endif>{{$customStation->agent_name}}</option>
                                    @endforeach
                                </select>  
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('cnf_print_date') ? 'has-error' : '' }}">
                                <label for="">App For CNF(Print Date)</label>
                                <input name="cnf_print_date" type="text" class="form-control input-sm datepicker"  value="{{$sale_contract->cnf_print_date}}"  placeholder="App for cnf print date"  autocomplete="off"  is_date="1">
                                @if ($errors->has('cnf_print_date'))
                                    <span class="help-block"><strong>{{ $errors->first('cnf_print_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="sale_contract_id" id="sale_contract_id" value="{{$sale_contract->id}}">
                        <input type="hidden" name="po_no"  id="po_no" value="{{$po_no}}">  
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
                        <div class="col-sm-3">
                            <div class="form-group{{ $errors->has('shipping_line_id') ? 'has-error' : '' }}">
                                <label for="shipping_line_id">Freight Forwarder Name</label>
                                <select name="shipping_line_id" id="shipping_line_id" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1">
                                    <option value="">Select</option>
                                    @foreach($shippingLines as $shippingLine)
                                    <option value="{{$shippingLine->id}}" @if($shippingLine->id==$sale_contract->shipping_line_id){{'selected'}}@endif>{{$shippingLine->shipping_name}} / {{$shippingLine->license_number}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('shipping_line_id'))
                                    <span class="help-block"><strong>{{ $errors->first('shipping_line_id') }}</strong></span>
                                @endif  
                            </div>
                        </div>
                    </div>
                    <div class="row">    
                        <div class="col-sm-3">
                            <div class="form-group{{ $errors->has('name_of_shipping_line_id') ? 'has-error' : '' }}">
                                <label for="name_of_shipping_line_id">Name Of Shipping Line</label>
                                <select name="name_of_shipping_line_id" id="name_of_shipping_line_id" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1">
                                    <option value="">Select</option>
                                    @foreach($shippingLines as $shippingLine)
                                    <option value="{{$shippingLine->id}}" @if($shippingLine->id==$sale_contract->name_of_shipping_line_id){{'selected'}}@endif>{{$shippingLine->shipping_name}} / {{$shippingLine->license_number}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('name_of_shipping_line_id'))
                                    <span class="help-block"><strong>{{ $errors->first('name_of_shipping_line_id') }}</strong></span>
                                @endif  
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('freight_amount_fc') ? 'has-error' : '' }}">
                                <label for="">Freight Amount(FC)</label>
                                <input name="freight_amount_fc" type="text" class="form-control input-sm"  value="{{$sale_contract->freight_amount_fc}}"  placeholder="Enter Freight Amount (FC)">
                                @if ($errors->has('freight_amount_fc'))
                                    <span class="help-block"><strong>{{ $errors->first('freight_amount_fc') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('freight_amount_btd') ? 'has-error' : '' }}">
                                <label for="">Freight Amount(BDT)</label>
                                <input name="freight_amount_btd" type="text" class="form-control input-sm"  value="{{$sale_contract->freight_amount_btd}}"  placeholder="Enter Freight Amount (BDT)">
                                @if ($errors->has('freight_amount_btd'))
                                    <span class="help-block"><strong>{{ $errors->first('freight_amount_btd') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('master_airway_bill_no') ? 'has-error' : '' }}">
                                <label for="master_airway_bill_no">House Airway Bill No</label>
                                <input name="master_airway_bill_no" type="text" class="form-control input-sm"  value="{{$sale_contract->master_airway_bill_no}}"  placeholder="Enter House Airway Bill No">
                                @if ($errors->has('master_airway_bill_no'))
                                    <span class="help-block"><strong>{{ $errors->first('master_airway_bill_no') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>    
                    <div class="row">  
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('master_airway_bill_date') ? 'has-error' : '' }}">
                                <label for="">House Airway Bill Date</label>
                                <input name="master_airway_bill_date" type="text" class="form-control input-sm datepicker"  value="@if($sale_contract->master_airway_bill_date){{date('d-m-Y', strtotime($sale_contract->master_airway_bill_date))}}@endif"  placeholder="Enter House Airway Bill Date">
                                @if ($errors->has('master_airway_bill_date'))
                                    <span class="help-block"><strong>{{ $errors->first('master_airway_bill_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="formated_file">Formatted File</label>
                            <input name="formated_file" type="file"  class="form-control input-sm"   value="">
                        </div>
                        <div class="col-sm-3">
                            <label for="pi_file">PI Upload</label>
                            <input name="pi_upload" type="file" id="pi_upload" class="form-control input-sm"   value="">
                            @if($sale_contract->gt_doc_ref)
                            <a href="{{url('http://rqc.rflgroupbd.com:8016/storage/'.$sale_contract->gt_doc_ref) }}">Download</a>  
                            @endif  
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('salary_adjustment') ? 'has-error' : '' }}">
                                <label for="salary_adjustment">Salary Adjustment:</label>
                                <input name="salary_adjustment" type="text" id="salary_adjustment" class="form-control input-sm"  placeholder="Enter Your Salary Adjustment" value="{{$sale_contract->salary_adjustment}}">
                                @if ($errors->has('salary_adjustment'))
                                    <span class="help-block"><strong>{{ $errors->first('salary_adjustment') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('port_of_shipment') ? 'has-error' : '' }}">
                                <label for="port_of_shipment">Port Of Shipment:</label>
                                <input name="port_of_shipment" type="text" id="port_of_shipment" class="form-control input-sm"  placeholder="Port Of Shipment" value="{{$sale_contract->port_of_shipment}}">
                                @if ($errors->has('port_of_shipment'))
                                    <span class="help-block"><strong>{{ $errors->first('port_of_shipment') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('oc_date') ? 'has-error' : '' }}">
                                <label for="oc_date">OC Date:</label>
                                <input name="oc_date" type="text" id="oc_date" class="form-control input-sm datepicker"  placeholder="Select OC Date" value="{{$sale_contract->oc_date}}">
                                @if ($errors->has('oc_date'))
                                    <span class="help-block"><strong>{{ $errors->first('oc_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('adj_percent') ? 'has-error' : '' }}">
                                <label for="adj_percent">Adj_percent:</label>
                                <input name="adj_percent" type="number" id="adj_percent" class="form-control input-sm"  placeholder="Enter adj percent value" value="{{$sale_contract->adj_percent}}" readonly>
                                @if ($errors->has('adj_percent'))
                                    <span class="help-block"><strong>{{ $errors->first('adj_percent') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                                <label for="is_revised" >Is revised</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_revised"   value="1"   id="is_revised"    @if($sale_contract->is_revised==1){{"checked"}}@endif >Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_revised"  value="0" @if($sale_contract->is_revised==0){{"checked"}}@endif >No
                                </label>
                                @if ($errors->has('is_revised'))
                                    <span class="help-block"><strong>{{ $errors->first('is_revised') }}</strong></span>
                                @endif
                            </div>
                        </div>   
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group form-group {{ $errors->has('is_proforma_invoice') ? 'has-error' : '' }}">
                                <label for="is_proforma_invoice" >Is Proforma Invoice</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_proforma_invoice"   value="1"   id="is_proforma_invoice"    @if($sale_contract->is_proforma_invoice==1){{"checked"}}@endif >Yes
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
                                    <input type="radio" name="is_master"   value="1"   id="is_master"    @if($sale_contract->is_master==1){{"checked"}}@endif >Yes
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
                                <label for="footer_importer_address" >Footer Importer Address</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="footer_importer_address"   value="1"   id="footer_importer_address"    @if($sale_contract->footer_importer_address==1){{"checked"}}@endif >Yes
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
                    </div>
                    <div class="row">   
                        <div class="col-sm-3">
                            <div class="form-group form-group {{ $errors->has('tr_no_is_exist') ? 'has-error' : '' }}">
                                <label for="tr_no_is_exist" >TR No(Only For Land)</label><br>
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
                                    <input type="radio" name="address_replace"   value="1"   id="address_replace"  @if($sale_contract->address_replace==1){{"checked"}}@endif>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="address_replace"   value="0"   id="address_replace"  @if($sale_contract->address_replace=='0'){{"checked"}}@endif>No
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group form-group {{ $errors->has('is_total_amount_oceania') ? 'has-error' : '' }}">
                                <label for="is_total_amount_oceania">Is Total Amount Visible(Oceania Desk)</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_total_amount_oceania"   value="1"   id="is_total_amount_oceania"    @if($sale_contract->is_total_amount_oceania==1){{"checked"}}@endif >Yes
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
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group form-group {{ $errors->has('mfg_date_india') ? 'has-error' : '' }}">
                                <label for="mfg_date_india" >Add Also Notify Party</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="add_also_notify_party"   value="1"   id="add_also_notify_party" @if($sale_contract->add_also_notify_party==1){{"checked"}}@endif>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="add_also_notify_party" id="add_also_notify_party" value="0" @if($sale_contract->add_also_notify_party=='0'){{"checked"}}@endif>No
                                </label>
                            </div>
                        </div>    
                        <div class="col-sm-3">
                            <div class="form-group form-group {{ $errors->has('mfg_date_india') ? 'has-error' : '' }}">
                                <label for="mfg_date_india" >Is Hs Code2</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_hscode2" id="is_hscode2" value="1" @if($sale_contract->is_hscode2==1){{"checked"}}@endif>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_hscode2" id="is_hscode2" value="0" @if($sale_contract->is_hscode2=='0'){{"checked"}}@endif>No
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group form-group {{ $errors->has('mfg_date_india') ? 'has-error' : '' }}">
                                <label for="mfg_date_india" >Is FOB ?</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_fob" id="is_fob" value="1" @if($sale_contract->is_fob==1){{"checked"}}@endif>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_fob" id="is_fob" value="0" @if($sale_contract->is_fob=='0'){{"checked"}}@endif>No
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-offset-1 col-sm-3">
                            <div class="form-group form-group {{ $errors->has('footer_importer_address') ? 'has-error' : '' }}">
                                <label for="footer_importer_address" >With/Without Expiry</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="expaire_show_status"   value="1"   id="expaire_show_status"  @if($sale_contract->expaire_show_status=="1"){{"checked"}}@endif>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="expaire_show_status"   value="0" @if($sale_contract->expaire_show_status=="0"){{"checked"}}@endif>No
                                </label>
                                @if ($errors->has('footer_importer_address'))
                                    <span class="help-block"><strong>{{ $errors->first('footer_importer_address') }}</strong></span>
                                @endif
                            </div>
                        </div> 
                    </div>    
                    <div class="row">    
                        <div class="col-sm-8"></div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-info btn-flat"  id="nextButton" style="margin-top: 22px">Update Sales Contract</button> 
                        </div>        
                    </div>
             </form>
             <hr>
             @if(!$sale_contract->desk_approver_id) 
                <div class="box-body" id="addItemFormContainer">
                    <form id="addItemForm">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="ci_item_id">Item</label>
                                    <select name="ci_item_id" id="ci_item_id" class="form-control input-sm" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="ctn">Ctn(Qty)</label>
                                    <input name="ctn" type="number" id="ctn" class="form-control input-sm" required step="any" placeholder="Enter Ctn Qty">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="rate_per_ctn_for_acc">Rate/Ctn(Acct)</label>
                                    <input name="rate_per_ctn_for_acc" type="number" id="rate_per_ctn_for_acc" class="form-control input-sm" required step="any" placeholder="Rate per ctn" readonly>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="rate_per_ctn_for_party">Rate/Ctn(Party)</label>
                                    <input name="rate_per_ctn_for_party" type="number" id="rate_per_ctn_for_party" class="form-control input-sm" required step="any" placeholder="Rate per ctn">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="cbm_per_ctn">CBM/Ctn</label>
                                    <input name="cbm_per_ctn" type="text" id="cbm_per_ctn" class="form-control input-sm" required placeholder="CBM per ctn" readonly>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="gross_weight">Gross Weight</label>
                                    <input name="gross_weight" type="text" id="gross_weight" class="form-control input-sm" required placeholder="Gross Weight">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="desk_item_name">Desk Item Name</label>
                                    <input name="desk_item_name" type="text" id="desk_item_name" class="form-control input-sm" required placeholder="Desk Item Name">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="hs_code">HS Code</label>
                                    <input name="hs_code" type="text" id="hs_code" class="form-control input-sm" required placeholder="HS Code">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="hs_code_2">HS Code2</label>
                                    <input name="hs_code_2" type="text" id="hs_code_2" class="form-control input-sm" placeholder="HS Code2">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="total_amount_party">Total Amount(Party)</label>
                                    <input name="total_amount_party" type="number" id="total_amount_party" class="form-control input-sm" required step="any" placeholder="Total Amount Party">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="total_amount_acc">Total Amount(Acc)</label>
                                    <input name="total_amount_acc" type="number" id="total_amount_acc" class="form-control input-sm" required step="any" placeholder="Total Amount Acc">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <input type="hidden" name="sc_id" id="sc_id" value="{{$sale_contract->id}}">
                                <input type="hidden" name="party_id" id="party_id" value="{{$party_id}}">
                                <button type="submit" class="btn btn-primary btn-flat input-sm" style="margin-top: 22px">Add Item</button>
                            </div>
                        </div>
                    </form>
                </div>
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
                  <div class="row">
                        <div class="col-sm-6">
                            @if(!$sale_contract->desk_approver_id)
                                <button class="btn btn-sm delete_all" 
                                        data-url="{{ url('/delete/sales/contact/item') }}"
                                        style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
                                            border: none;
                                            color: white;
                                            font-weight: 600;
                                            border-radius: 6px;
                                            transition: all 0.3s ease;">
                                    <i class="fa fa-trash"></i> Deleted
                                </button> 
                            @endif   
                        </div>
                        <div class="col-sm-6" style="text-align: right">
                           @if(AdminController::isAccessable(26))
                                @if(!$sale_contract->approved_at)
                                    <button type="button" 
                                            class="btn btn-sm btn-flat" 
                                            value="{{$sale_contract->id}}" 
                                            id="make_priceSame_id"
                                            style="background: linear-gradient(135deg, #ff9900 0%, #ff6600 100%); 
                                                border: none; 
                                                color: white;
                                                font-weight: bold;
                                                box-shadow: 0 2px 5px rgba(255, 102, 0, 0.3);">
                                        MAKE PRICE SAME
                                    </button>
                                @endif
                            @endif
                            <button class="btn btn-sm btn-show-direct" 
                                    data-encrypted-contract="{{ Crypt::encrypt($sale_contract->id) }}"
                                    data-encrypted-party="{{ Crypt::encrypt($party_id) }}"
                                    style="background: linear-gradient(135deg, #9933cc 0%, #6600cc 100%); border: none; color: white; font-weight: bold; box-shadow: 0 2px 5px rgba(153, 51, 204, 0.3);">Show Report
                            </button>
                            @if(AdminController::isAccessable(61))
                            <button class="btn btn-sm btn-adj-percent" 
                                    id="adjPercentBtn"
                                    data-contract-id="{{$sale_contract->id}}"
                                    data-party-id="{{$party_id}}"
                                    style="background: linear-gradient(135deg, #186a16 0%, #306a20ad 100%);
                                        border: none; 
                                        color: white; 
                                        font-weight: bold; 
                                        margin-left: 5px;
                                        box-shadow: 0 2px 5px rgba(249, 115, 22, 0.3);">
                                <i class="fa fa-percent"></i> Adj Percent
                            </button>
                            @endif
                        </div>
                    </div> 
                     <table style="background-color:#dfdfdf" class="table table-bordered table-responsive table-condensed table-hover" id="tblMain">
                    <thead>
                        <tr>
                            <th width="50px">All<br><input type="checkbox" id="master"></th>
                            <th>Item code</th>
                            <th>Item Name</th>
                            <th>Hs code</th>
                            <th>Ctn<br>(qty)</th>
                            {{-- @if(AdminController::isAccessable(19)) --}}
                            <th>Rate<br>/ctn<br>(act)</th>
                            <th>Total<br>(act)</th>  
                            <th style="background-color:#a2045ded;">Rate<br>/ctn<br>(party)</th>
                            <th style="background-color:#a2045ded;">Total<br>(Party)</th> 
                            {{-- @endif --}}
                            {{-- @if(AdminController::isAccessable(20)) --}}
                            <th style="background-color:#a2045ded;">Rate<br>/ctn<br>(CI)</th>
                            <th style="background-color:#a2045ded;">Total<br>(CI)</th>
                            {{-- @endif --}}
                            <th>Cbm<br>/ctn</th> 
                            <th>Total cbm</th>
                            <th>Gross Weight</th>   
                            <th>Pcs in ctn</th> 
                            <th>Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $total_cbm = 0;
                            $total_amount = 0;
                            $total_amount_party = 0;
                            $total_amount_acc = 0;
                            $total_ctn = 0;
                            $total_gross_weight_kg = 0;
                            $pcs_in_carton = 0;
                            $key = 0;
                        ?>
                        
                        @foreach ($sale_contract->sale_contract_details as $sale_contract_detail)
                        <?php 
                            // Calculate totals for each row
                            $total_cbm += $sale_contract_detail->total_cbm;
                            $total_amount += $sale_contract_detail->total_amount;
                            $total_amount_party += $sale_contract_detail->total_amount_party;
                            $total_amount_acc += $sale_contract_detail->total_amount_acc;
                            $total_ctn += $sale_contract_detail->ctn;
                            $total_gross_weight_kg += $sale_contract_detail->gross_weight_kg;
                            $pcs_in_carton += $sale_contract_detail->pcs_in_ctn;
                        ?>
                        <tr>
                            <td><input type="checkbox" class="sub_chk" data-id="{{$sale_contract_detail->id}}"></td>
                            <td>{{$sale_contract_detail->ci_item->ci_item_code}}</td>
                            <td>
                                @if(AdminController::isAccessable(27)) 
                                CI:{{$sale_contract_detail->ci_item_name}}<br>
                                @endif
                                @if(AdminController::isAccessable(30))  
                                Desk:{{$sale_contract_detail->desk_item_name}}
                                @endif
                            </td>
                            <td>
                                {{$sale_contract_detail->hs_code}} 
                                @if($sale_contract_detail->hs_code_2)
                                <br>{{$sale_contract_detail->hs_code_2}}
                                @endif
                            </td>
                            <td>{{$sale_contract_detail->ctn}}</td>
                            {{-- @if(AdminController::isAccessable(19)) --}}
                            <td>{{number_format($sale_contract_detail->rate_per_ctn_for_acc, 2)}}</td>
                            <td>{{$sale_contract_detail->total_amount_acc}}</td>  
                            <td style="background-color:#a2045ded;color:white">{{number_format($sale_contract_detail->rate_per_ctn_for_party,2)}}</td>
                            <td style="background-color:#a2045ded;color:white">{{$sale_contract_detail->total_amount_party}}</td>
                            {{-- @endif --}}
                            {{-- @if(AdminController::isAccessable(20))                             --}}
                            <td style="background-color:#a2045ded;color:white">{{number_format($sale_contract_detail->rate_per_ctn, 2)}}</td>
                            <td style="background-color:#a2045ded;color:white">{{$sale_contract_detail->total_amount}}</td>
                            {{-- @endif  --}}
                            <td>{{number_format($sale_contract_detail->cbm_per_ctn, 3)}}</td>
                            <td>{{number_format($sale_contract_detail->total_cbm, 3)}}</td>
                            <td>{{number_format($sale_contract_detail->gross_weight_kg, 2)}}</td>
                            <td>{{$sale_contract_detail->pcs_in_ctn}}</td>
                            <td>
                                @if(AdminController::isAccessable(24))
                                <button type="button" 
                                        class="btn btn-xs btn-success btn-flat edit-desk-btn" 
                                        data-id="{{ \Crypt::encrypt($sale_contract_detail->id) }}"
                                        data-party-id="{{ \Crypt::encrypt($party_id) }}">Edit Desk</button>
                                @endif
                                @if(AdminController::isAccessable(23))
                                <button type="button" 
                                        class="btn btn-xs btn-primary btn-flat edit-ci-btn" 
                                        data-id="{{ \Crypt::encrypt($sale_contract_detail->id) }}"
                                        data-party-id="{{ \Crypt::encrypt($party_id) }}"
                                        data-sc-id="{{ \Crypt::encrypt($sale_contract_detail->sale_contract_id)}}"
                                        data-type="ci">Edit CI</button>      
                                @endif
                            </td>
                        </tr>
                        <?php $key++;?>
                        @endforeach  
                        
                        <!-- FIXED TOTAL ROW - Proper column alignment -->
                        <tr class="total-row">
                            <td></td> 
                            <td><strong>Total</strong></td>
                            <td></td>
                            <td></td>
                            <td><span id="totalCtn">{{$total_ctn}}</span></td>
                            {{-- @if(AdminController::isAccessable(19)) --}}
                            <td></td>
                            <td><span id="total_amount_accc">{{number_format($total_amount_acc, 2)}}</span></td>
                            <td></td>
                            <td><span id="total_amount_partyy">{{number_format($total_amount_party, 2)}}</span></td>
                            {{-- @endif --}}
                            {{-- @if(AdminController::isAccessable(20)) --}}
                            <td></td>
                            <td><span id="total_amount">{{number_format($total_amount, 2)}}</span></td>
                            {{-- @endif --}}
                            <td></td>
                            <td><span id="total_cbm">{{number_format($total_cbm, 3)}}</span></td>
                            <td><span id="total_gross_weight_kg">{{number_format($total_gross_weight_kg, 2)}}</span></td>
                            <td><span id="pcs_in_carton">{{$pcs_in_carton}}</span></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </form>
             </div> <!-- Table end  -->
      </div> <!-- col-md-8 end -->
</div>
<!-- Edit Desk Modal -->
<div class="modal fade" id="editDeskModal" tabindex="-1" role="dialog" aria-labelledby="editDeskModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="editDeskModalLabel">
                    <i class="fa fa-edit"></i>Edit Desk Information
                </h4>
            </div>
            <form id="editDeskForm" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div id="deskModalContent">
                        <!-- Dynamic content will load here -->
                        <div class="text-center">
                            <i class="fa fa-spinner fa-spin fa-3x"></i>
                            <p>Loading...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> Update Desk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit CI Modal -->
<div class="modal fade" id="editCIModal" tabindex="-1" role="dialog" aria-labelledby="editCIModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="editCIModalLabel">
                    <i class="fa fa-file-text"></i> Edit CI Information
                </h4>
            </div>
            <form id="editCIForm" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div id="ciModalContent">
                        <!-- Dynamic content will load here -->
                        <div class="text-center">
                            <i class="fa fa-spinner fa-spin fa-3x"></i>
                            <p>Loading...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i>Update Doc
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>document.title = 'Sales Contract | Edit';</script>
<script>
setTimeout(function() { 
  $('.sr-only').click();
}, 0.0001);    

$(document).ready(function() {

     $('#invoice_no').on('keyup paste change', function() {
        var value = $(this).val();
        var sc_id = $('#sc_id').val(); // Edit à¦¹à¦²à§‡ ID à¦¥à¦¾à¦•à¦¬à§‡, Create à¦¹à¦²à§‡ empty
        
        // Remove spaces
        value = value.replace(/\s/g, '');
        $(this).val(value);
        
        if (value.length > 3) {
            $.ajax({
                type: "GET",
                url: "/check/invoice/number/exist/ornot",
                data: {
                    invoice_no: value,
                    id: sc_id || null  // ðŸ‘ˆ sc_id à¦ªà¦¾à¦ à¦¾à¦¨
                },
                success: function (data) {
                    if (data == '1') {
                        if (sc_id) {
                            $('#mobile_number_error').html("âš ï¸ Already Exists in another contract!");
                        } else {
                            $('#mobile_number_error').html("âš ï¸ Already Exists!");
                        }
                        $('#nextButton').prop("disabled", true);
                    } else {
                        $('#mobile_number_error').html("âœ… Available");
                        $('#nextButton').prop("disabled", false);
                    }
                },
                error: function() {
                    $('#mobile_number_error').html("Error checking!");
                }
            });
        } else {
            $('#mobile_number_error').html("");
            $('#nextButton').prop("disabled", false);
        }
    });

     function redirectToShowPage() {
        const encryptedContract = $(this).data('encrypted-contract');
        const encryptedParty = $(this).data('encrypted-party');
        
        // Encode URL parameters
        const encodedContract = encodeURIComponent(encryptedContract);
        const encodedParty = encodeURIComponent(encryptedParty);
        
        // Redirect
        window.location.href = `/return/direct/${encodedContract}/${encodedParty}`;
        
    }

     $('.btn-show-direct').on('click', redirectToShowPage);
    // =========== TABLE MANAGEMENT FUNCTIONS ===========
    // Function to show empty table state
    function showEmptyTableState() {
        const tableBody = $('#tblMain tbody');
        const colCount = $('#tblMain thead th').length;
        
        tableBody.html(`
            <tr class="empty-state">
                <td colspan="${colCount}" style="text-align: center; padding: 40px 20px; color: #666; background: #f9f9f9;">
                    <div style="margin-bottom: 10px;">
                        <i class="fa fa-box-open fa-3x" style="color: #ccc;"></i>
                    </div>
                    <h5 style="margin-bottom: 5px; font-weight: 400;">No items added yet</h5>
                    <p style="margin: 0; font-size: 14px; color: #999;">
                        Click "Add Item" to add your first item
                    </p>
                </td>
            </tr>
        `);
        
        // Reset all totals to 0
        resetAllTotals();
    }
    
    // Function to reset all totals to 0
    function resetAllTotals() {
        $('#totalCtn').text('0');
        $('#total_amount_accc').text('0.00');
        $('#total_amount_partyy').text('0.00');
        $('#total_amount').text('0.00');
        $('#total_cbm').text('0.000');
        $('#total_gross_weight_kg').text('0.00');
        $('#pcs_in_carton').text('0');
    }
    
    // Function to check if table is empty and show appropriate state
    function checkTableEmptyState() {
        const tableBody = $('#tblMain tbody');
        const rows = tableBody.find('tr');
        
        // Check if table has no rows or only has empty state row
        if (rows.length === 0 || rows.length === 1 && rows.hasClass('empty-state')) {
            return true;
        }
        
        // Check if all rows are empty state rows
        let isEmpty = true;
        rows.each(function() {
            if (!$(this).hasClass('empty-state')) {
                isEmpty = false;
                return false; // break loop
            }
        });
        
        return isEmpty;
    }
    
    // =========== NOTIFY PARTY ITEMS LOAD ===========
    function loadNotifyPartyItems() {
        var notify_pary_id = $('#notify_pary_id').val();
        if(notify_pary_id) {
            $.ajax({
                url: "/json/get_item_of_notify_party",
                data: { notify_party_id: notify_pary_id },
                success: function(data) {
                    var $el = $('#ci_item_id');
                    $el.empty().append('<option value="">Select</option>');
                    
                    if(data && data.length > 0) {
                        $.each(data, function(key, value) {
                            $el.append($('<option></option>')
                                .attr('value', value.id)
                                .text(value.ci_item_code + '-' + value.ci_item_name));
                        });
                    }
                    $el.selectpicker('refresh');
                }
            });
        }
    }
    
    // Initial load and on change
    loadNotifyPartyItems();
    $('#notify_pary_id').change(loadNotifyPartyItems);
    
    // =========== CI ITEM CHANGE EVENT ===========
    $(document).on('change', '#ci_item_id', function() {
        var ci_item_id = $(this).val();
        var notify_pary_id = $('#notify_pary_id').val();
        var ctn = $('#ctn').val() || 1;
        
        if(ci_item_id && notify_pary_id) {
            $.ajax({
                url: '/json/get_item_reate_for_notify_party',
                data: {
                    ci_item_id: ci_item_id,
                    notify_party_id: notify_pary_id
                },
                success: function(data) {
                    if(data) {
                        $('#rate_per_ctn_for_acc').val(data.acc_rate || '');
                        $('#rate_per_ctn_for_party').val(data.party_rate || '');
                        $('#cbm_per_ctn').val(data.cbm_per_ctn || '');
                        $('#desk_item_name').val(data.desk_item_name || '');
                        $('#hs_code').val(data.hs_code || '');
                        $('#gross_weight').val(data.gross_weight || '');
                        
                        // Auto calculate totals
                        if(data.acc_rate && ctn) {
                            $('#total_amount_acc').val((ctn * data.acc_rate).toFixed(2));
                        }
                        if(data.party_rate && ctn) {
                            $('#total_amount_party').val((ctn * data.party_rate).toFixed(2));
                        }
                    }
                }
            });
        }
    });
    
    // =========== AUTO CALCULATE TOTAL AMOUNTS ===========
    $(document).on('change', '#ctn, #rate_per_ctn_for_acc', function() {
        var ctn = $('#ctn').val();
        var rate = $('#rate_per_ctn_for_acc').val();
        if(ctn && rate) {
            $('#total_amount_acc').val((ctn * rate).toFixed(2));
        }
    });
    
    $(document).on('change', '#ctn, #rate_per_ctn_for_party', function() {
        var ctn = $('#ctn').val();
        var rate = $('#rate_per_ctn_for_party').val();
        if(ctn && rate) {
            $('#total_amount_party').val((ctn * rate).toFixed(2));
        }
    });
    
    $('#addItemForm').submit(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var formData = $(this).serialize();
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Adding...');
        $.ajax({
            type: 'POST',
            url: '/ajax/add-sale-contract-item',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                
                if(response.status==200) {
                    
                    $('#addItemForm')[0].reset();
                    $('#ci_item_id').selectpicker('refresh');
                    refreshSaleContractTable();
                    updateTotals(response.totals);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Item added successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Failed to add item'
                    });
                }
            },
            error: function(xhr) {
                var errorMessage = 'Something went wrong';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if(xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: errorMessage
                });
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
        
        return false;
    });
    
    function refreshSaleContractTable() {

        var saleContractId = $('#sale_contract_id').val();
        var partyId = $('#party_id').val();
        $.ajax({
            url: '/ajax/get-sale-contract-details/' + saleContractId,
            type: 'GET',
            data: { party_id: partyId },
            beforeSend: function() {
                $('#tblMain tbody').html('<tr><td colspan="15" class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</td></tr>');
            },
            success: function(response) {
                console.log('Table refresh response:', response);
                
                // Check if response is successful
                if(response.success) {
                    // Check if response has data
                    if(response.html && response.html.trim().length > 0) {
                        $('#tblMain tbody').html(response.html);
                    } else {
                        // Show empty state if no data
                        showEmptyTableState();
                    }
                    
                    // Re-attach button listeners
                    attachButtonListeners();
                    
                    // Update totals
                    if(response.totals && typeof response.totals === 'object') {
                        updateTotals(response.totals);
                    } else {
                        // If totals not in response, calculate from table
                        calculateAndUpdateTotals();
                    }
                } else {
                    // Handle unsuccessful response
                    if (checkTableEmptyState()) {
                        showEmptyTableState();
                    } else {
                        $('#tblMain tbody').html('<tr><td colspan="15" class="text-center text-danger">' + (response.message || 'Error loading data') + '</td></tr>');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error refreshing table:', xhr, status, error);
                if (checkTableEmptyState()) {
                    showEmptyTableState();
                } else {
                    $('#tblMain tbody').html('<tr><td colspan="15" class="text-center text-danger">Error loading data: ' + error + '</td></tr>');
                }
            }
        });
    }

    // Modified updateTotals function with safety checks
    function updateTotals(totals) {
        if(!totals) {
            console.error('Totals is undefined or null');
            return;
        }
        
        // Update each total with safety checks
        if(totals.total_ctn !== undefined) {
            $('#totalCtn').text(totals.total_ctn);
        }
        if(totals.total_amount_acc !== undefined) {
            $('#total_amount_accc').text(totals.total_amount_acc);
        }
        if(totals.total_amount_party !== undefined) {
            $('#total_amount_partyy').text(totals.total_amount_party);
        }
        if(totals.total_amount !== undefined) {
            $('#total_amount').text(totals.total_amount);
        }
        if(totals.total_cbm !== undefined) {
            $('#total_cbm').text(parseFloat(totals.total_cbm).toFixed(3));
        }
        if(totals.total_gross_weight_kg !== undefined) {
            $('#total_gross_weight_kg').text(totals.total_gross_weight_kg);
        }
        if(totals.pcs_in_carton !== undefined) {
            $('#pcs_in_carton').text(totals.pcs_in_carton);
        }
    }

    // Alternative function to calculate totals from table data
    function calculateAndUpdateTotals() {

        var totalCtn = 0;
        var totalAmountAcc = 0;
        var totalAmountParty = 0;
        var totalAmount = 0;
        var totalCbm = 0;
        var totalGrossWeightKg = 0;
        var pcsInCarton = 0;
        
        // Check if table is empty
        if (checkTableEmptyState()) {
            resetAllTotals();
            return;
        }
        
        // Calculate from all rows except the total row and empty state
        $('#tblMain tbody tr:not(.empty-state)').each(function() {
            // Skip if this is the total row (check for background color or class)
            if(!$(this).hasClass('total-row') && !$(this).css('background-color').includes('rgb(10, 28, 123)')) {
                // Column indices (adjust based on your table structure):
                // 5: ctn, 7: total_amount_acc, 9: total_amount_party, 11: total_amount, 13: total_cbm, 14: gross_weight_kg, 15: pcs_in_ctn
                var ctn = parseFloat($(this).find('td:nth-child(5)').text().trim()) || 0;
                var acc = parseFloat($(this).find('td:nth-child(7)').text().trim()) || 0;
                var party = parseFloat($(this).find('td:nth-child(9)').text().trim()) || 0;
                var ci = parseFloat($(this).find('td:nth-child(11)').text().trim()) || 0;
                var cbm = parseFloat($(this).find('td:nth-child(13)').text().trim()) || 0;
                var weight = parseFloat($(this).find('td:nth-child(14)').text().trim()) || 0;
                var pcs = parseFloat($(this).find('td:nth-child(15)').text().trim()) || 0;
                
                totalCtn += ctn;
                totalAmountAcc += acc;
                totalAmountParty += party;
                totalAmount += ci;
                totalCbm += cbm;
                totalGrossWeightKg += weight;
                pcsInCarton += pcs;
            }
        });
        
        // Update total row
        $('#totalCtn').text(totalCtn);
        $('#total_amount_accc').text(totalAmountAcc.toFixed(2));
        $('#total_amount_partyy').text(totalAmountParty.toFixed(2));
        $('#total_amount').text(totalAmount.toFixed(2));
        $('#total_cbm').text(totalCbm.toFixed(3));
        $('#total_gross_weight_kg').text(totalGrossWeightKg.toFixed(2));
        $('#pcs_in_carton').text(pcsInCarton);
        
    }
        
    function attachButtonListeners() {
        // Edit Desk Button
        $('.edit-desk-btn').off('click').on('click', function(e) {
            e.preventDefault();
            var encryptedId = $(this).data('id');
            var encryptedPartyId = $(this).data('party-id');
            $('#editDeskModal').modal('show');
            $.ajax({
                url: '/sale_contract_detail/' + encryptedId + '/edit_desk/' + encryptedPartyId,
                type: 'GET',
                beforeSend: function() {
                    $('#deskModalContent').html(`
                        <div class="text-center">
                            <i class="fa fa-spinner fa-spin fa-3x"></i>
                            <p>Loading form...</p>
                        </div>
                    `);
                },
                success: function(response) {
                    $('#deskModalContent').html(response);
                    var actionUrl = '/sale_contract_detail/' + encryptedId + '/update_desk';
                    $('#editDeskForm').attr('action', actionUrl);
                    $('.datepicker').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                        todayHighlight: true,
                    });
                    $('.selectpicker').selectpicker();
                },
                error: function() {
                    $('#deskModalContent').html(`
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-triangle"></i>
                            Failed to load form. Please try again.
                        </div>
                    `);
                }
            });
        });
        
        // Edit CI Button
        $('.edit-ci-btn').off('click').on('click', function(e) {
            e.preventDefault();
            
            var encryptedId = $(this).data('id');
            var encryptedPartyId = $(this).data('party-id');
            var encryptedScId = $(this).data('sc-id');
            
            $('#editCIModal').modal('show');
            $.ajax({
                url: '/sale_contract_detail/' + encryptedId + '/edit_ci/' + encryptedPartyId + '/sc_id/' + encryptedScId,
                type: 'GET',
                beforeSend: function() {
                    $('#ciModalContent').html(`
                        <div class="text-center">
                            <i class="fa fa-spinner fa-spin fa-3x"></i>
                            <p>Loading form...</p>
                        </div>
                    `);
                },
                success: function(response) {
                    $('#ciModalContent').html(response);
                    var actionUrl = '/sale_contract_detail/' + encryptedId + '/update';
                    $('#editCIForm').attr('action', actionUrl);
                    $('.datepicker').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                        todayHighlight: true,
                    });
                    $('.selectpicker').selectpicker();
                },
                error: function() {
                    $('#ciModalContent').html(`
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-triangle"></i>
                            Failed to load form. Please try again.
                        </div>
                    `);
                }
            });
        });
    }
    
    // =========== ADJ PERCENT FUNCTIONALITY ===========
    $(document).on('click', '#adjPercentBtn', function(e) {

        e.preventDefault();
        var contractId = $(this).data('contract-id');
        var partyId = $(this).data('party-id');
        var button = $(this);
        Swal.fire({
            title: 'Enter Adjustment Percentage',
            html: `
                <div style="text-align: left;">
                    <label for="adj_percent_value">Percentage (%):</label>
                    <input type="number" 
                        id="adj_percent_value" 
                        class="swal2-input" 
                        placeholder="Enter percentage (e.g., 10)"
                        min="0"
                        max="100"
                        step="0.01"
                        style="width: 100%; padding: 10px; margin-top: 10px;">
                    <p style="color: #666; font-size: 12px; margin-top: 5px;">Enter 0-100 value</p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Apply',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            preConfirm: () => {
                const percentage = $('#adj_percent_value').val();
                if (!percentage) {
                    Swal.showValidationMessage('Please enter a percentage value');
                    return false;
                }
                if (percentage < 0 || percentage > 100) {
                    Swal.showValidationMessage('Percentage must be between 0 and 100');
                    return false;
                }
                return percentage;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                var percentage = result.value;
                
                // Show loading state
                button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Applying...');
                // Make AJAX call
                $.ajax({
                    url: '/update/report_percentage', // You need to define this route
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        contract_id: contractId,
                        party_id: partyId,
                        percentage: percentage
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message || 'Adjustment percentage applied successfully',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                // Reload or update the table with new values
                                refreshSaleContractTable();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to apply adjustment percentage'
                            });
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = 'Something went wrong';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage
                        });
                    },
                    complete: function() {
                        // Restore button state
                        button.prop('disabled', false).html('<i class="fa fa-percent"></i> Adj Percent');
                    }
                });
            }
        });
    });

     // =========== MODAL FORM SUBMISSION ===========
    $('#editDeskForm').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        var originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');
        var customUrl = '/sale_contract_detail/update_desk';
        
        $.ajax({
            type: 'POST',
            url: customUrl,
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.success || response.status === 'success' || response.code === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Desk information updated successfully',
                        timer: 1500,
                        showConfirmButton: false,
                        position: 'top-end'
                    });
                    
                    $('#editDeskModal').modal('hide');
                    refreshSaleContractTable();
                    
                } else if (response.code === 422 || response.errors) {
                    // Validation errors
                    var errorMessages = '';
                    if (response.errors) {
                        $.each(response.errors, function(field, messages) {
                            errorMessages += messages.join('<br>') + '<br>';
                        });
                    } else {
                        errorMessages = response.message || 'Validation failed';
                    }
                    
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        html: errorMessages
                    });
                    
                } else {
                    // Other errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Failed to update desk information'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                var errorMessage = 'Something went wrong while updating';
                if (xhr.status === 422) {
                    // Laravel validation errors
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value.join('<br>') + '<br>';
                        });
                    }
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error occurred. Please try again later.';
                } else if (xhr.status === 404) {
                    errorMessage = 'Requested resource not found.';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Update Failed',
                    html: errorMessage,
                    confirmButtonText: 'OK'
                });
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    $('#editCIForm').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        var originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');
        var customUrl = '/sale_contract_detail/update_ci';
        
        $.ajax({
            type: 'POST',
            url: customUrl,
            data: form.serialize(),
            success: function(response) {
                if(response.success || response.status === 'success' || response.code === 200) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'CI information updated successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    
                    $('#editCIModal').modal('hide');
                    refreshSaleContractTable();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Failed to update'
                    });
                }
            },
            error: function(xhr) {
                var errorMessage = 'Something went wrong';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if(xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: errorMessage
                });
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    // COMPANY BANK LOAD
    $('#company_id').change(function() {
        var company_id = $(this).val();
        if(company_id) {
            $.ajax({
                url: "/json/get_company_bank",
                data: { company_id: company_id },
                success: function(data) {
                    var $el = $('#bank_id');
                    $el.empty().append('<option value="">Select</option>');
                    
                    if(data && data.length > 0) {
                        $.each(data, function(key, value) {
                            $el.append($('<option></option>')
                                .attr('value', value.id)
                                .text(value.name));
                        });
                    }
                    $el.selectpicker('refresh');
                }
            });
        }
    });
    
    // IMPORTER CHANGE
    $('#importer_id').change(function() {
        var importer_id = $(this).val(); 
        if(importer_id) {
            $.ajax({
                url: "/json/get/party/last_shipment/histroy",
                data: { importer_id: importer_id },
                success: function(res) {
                    if(res) {
                        $('#importer_name').val(res.importer_name || '');
                        $('#importer_address').val(res.importer_address || '');
                    }
                }
            });
        }
    });
    
    // MAIN UPDATE FORM AJAX
    $("#UpdateForm").submit(function (e) {

        e.preventDefault();
        const $btn = $(this).find('button[type="submit"]');
        const originalText = $btn.html();
        // Show loading state
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');
        $.ajax({
            type: 'POST',
            url: '/sc_update',
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false
        })
        .done(handleSuccess)
        .fail(handleError)
        .always(() => $btn.prop('disabled', false).html(originalText));
        function handleSuccess(res) {
            if (res.code === 200) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: res.status || 'Updated Successfully!',
                    timer: 2000,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });

                if (res.call_status === 1) {
                    $('#container_qty_1, #container_qty_2, #container_qty_3, #freight_cost_1, #freight_cost_2, #freight_cost_3, #desk_freight_cost, #qtan_freight_cost').prop('readonly', true);
                    $('#sales_term_id').prop('disabled', true);
                }
            } else if (res.code === 422) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Validation Error!',
                    text: res.status || 'Please check your input.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
            } else if (res.code === 409) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Duplicate Entry!',
                    text: res.message || 'This record already exists.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: res.status || res.message || 'Something went wrong.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33'
                });
            }
        }

        function handleError(xhr) {
            let message = 'Something went wrong. Please try again.';

            if (xhr.status === 422) {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    let errorList = '';
                    $.each(errors, function(key, value) {
                        errorList += `<li><strong>${key}:</strong> ${value.join(', ')}</li>`;
                    });
                    message = `<ul style="text-align: left;">${errorList}</ul>`;
                }
            } else if (xhr.responseJSON?.status) {
                message = xhr.responseJSON.status;
            } else if (xhr.responseJSON?.message) {
                message = xhr.responseJSON.message;
            } else if (xhr.status === 500) {
                message = 'Server error. Please try again later.';
            }

            Swal.fire({
                icon: 'error',
                title: 'Request Failed!',
                html: message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            });
        }
    });
    
    // PRICE SAME BUTTON
    $('#make_priceSame_id').click(function(e) {
        e.preventDefault();
        var sa_id = $(this).val();
        var url = "/ci_make_price_same?sale_contact_id=" + sa_id;
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Merge it!'
        }).then((result) => {
            if(result.isConfirmed) {
                var $btn = $(this);
                var originalText = $btn.html();
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Merging...');
                $.get(url, function(res) {
                    if(res.code == 200) {
                        Swal.fire({
                            title: 'Merge!',
                            text: 'Your Item has been Merged.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        
                        if(res.redirect) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        }
                    } else if(res.code == 500) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
                    }
                    $btn.prop('disabled', false).html(originalText);
                }).fail(function() {
                    Swal.fire('Error!', 'Failed to merge items', 'error');
                    $btn.prop('disabled', false).html(originalText);
                });
            }
        });
    });
    
    $(document).on('click', '.delete_all', function(e) {

        e.preventDefault();
        var allVals = [];  
        $(".sub_chk:checked").each(function() {  
            allVals.push($(this).attr('data-id'));
        });  
        
        if(allVals.length <= 0) {  
            Swal.fire("Alert", "Please Select Row..!!");
            return;
        }
        
        var $deleteBtn = $(this);
        var originalText = $deleteBtn.html();
        $deleteBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Deleting...');
        Swal.fire({
            title: 'Are you sure?',
            text: "Items already sent for approval will be skipped.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $deleteBtn.data('url'),
                    type: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        'ids': allVals.join(","), 
                        'sale_contract_no': $('#sale_contract_id').val()
                    },
                    success: function(response) {
                        if(response.success) {
                            
                            $(".sub_chk:checked").each(function() {
                                $(this).closest("tr").remove(); 
                            });
                            
                            $(".sub_chk").prop('checked', false);
                            $("#master").prop('checked', false);
                            
                            if(response.totals) {
                                updateTotals(response.totals);
                            }
                            
                            if ($('#tblMain tbody tr').length === 0) {
                                showEmptyTableState();
                            }
                            
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Nothing to Delete!',
                                text: response.message || 'Selected items cannot be deleted.',
                                confirmButtonText: 'OK'
                            });
                        }
                        $deleteBtn.prop('disabled', false).html(originalText);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Something went wrong.',
                            confirmButtonText: 'OK'
                        });
                        $deleteBtn.prop('disabled', false).html(originalText);
                    }
                });
            } else {
                $deleteBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Totals Update Function
    function updateTotals(totals) {
        if(!totals) return;
        $('#totalCtn').text(totals.total_ctn);
        $('#total_amount_accc').text(totals.total_amount_acc);
        $('#total_amount_partyy').text(totals.total_amount_party);
        $('#total_amount').text(totals.total_amount);
        $('#total_cbm').text(totals.total_cbm);
        $('#total_gross_weight_kg').text(totals.total_gross_weight_kg);
        $('#pcs_in_carton').text(totals.pcs_in_carton);
    }

    // Empty State Function
    function showEmptyTableState() {
        $('#tblMain tbody').html(`
            <tr class="empty-state">
                <td colspan="15" style="text-align: center; padding: 40px; color: #999;">
                    <i class="fa fa-box-open fa-3x" style="color: #ccc; display: block; margin-bottom: 10px;"></i>
                    No items found
                </td>
            </tr>
        `);
    }
    
    // CHECK ALL CHECKBOX
    $(document).on('click', '#master', function(e) {
        if($(this).is(':checked', true)) {
            $(".sub_chk").prop('checked', true);  
        } else {  
            $(".sub_chk").prop('checked', false);  
        }  
    });
    
    // Function to initialize table on page load
    function initializeTable() {

        if ($('#tblMain tbody tr').length === 0) {
            showEmptyTableState();
        } else {
            calculateAndUpdateTotals();
        }
    }
    
    // Initialize on page load
    initializeTable();
    attachButtonListeners();
});
</script>
@endsection

