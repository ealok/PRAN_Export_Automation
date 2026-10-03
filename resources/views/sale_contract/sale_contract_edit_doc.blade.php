@extends('layouts.master')
@section('content')
<style>
    :root {
      --primary: #1f7ae0;
      --primary-dark: #0d6ac7;
      --primary-light: rgba(31, 122, 224, 0.1);
      --secondary: #6c757d;
      --light-bg: #f8fafc;
      --card-shadow: 0 10px 30px rgba(0,0,0,0.08);
      --success: #198754;
      --success-light: rgba(25, 135, 84, 0.1);
      --gray-100: #f8f9fa;
      --gray-200: #e9ecef;
      --gray-300: #dee2e6;
      --gray-600: #6c757d;
      --gray-800: #343a40;
    }

    .datepicker {
        z-index: 99999 !important;
    }
    
    /* Force red border for error state */
    .bootstrap-select.error .dropdown-toggle,
    .bootstrap-select.error .btn.dropdown-toggle,
    .bootstrap-select.error > .dropdown-toggle {
        border-color: #D72E2E !important;
        box-shadow: 0 0 0 0.2rem rgba(215, 46, 46, 0.25) !important;
    }

    /* Regular fields */
    .field-error {
        border: 1px solid #D72E2E !important;
        border-color: #D72E2E !important;
        box-shadow: 0 0 0 0.2rem rgba(215, 46, 46, 0.25) !important;
    }
    
    label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 2px;
        font-size: 12px;
        font-weight: bolder;
        color: black;
    }
    
    .btn-default {
        background-color: #FFFFFF;
        color: #444;
        border-color: #ddd;
    }
    
    .bootstrap-select > .dropdown-toggle.bs-placeholder {
        color: #222 !important;
        border: 1px solid #DEE2E6 !important;
    }
    
    .table-bordered > tbody > tr > td {
        border: 1px solid #ddd8d8;
        padding: 1px;
        font-weight: bold;
    }
    
    .table-bordered > thead > tr > th {
       border: 1px solid #c6c6c6 !important;
    }
    
    .table-bordered {
      border: 1px solid #d7cece;
    }  
    
    table.dataTable.no-footer {
      border-bottom: 1px solid #d9cece;
    }
    
    body { 
      background: var(--light-bg); 
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      color: #334155;
      line-height: 1.6;
    }
    
    .req_style_id {
        color: red;
    }
    
    .app-shell { 
      padding: 0 15px;
    }
    
    #sc_items_wrapper {
        margin-top: -13px;
    }
    
    .btn {
        border-radius: 8px;
        padding: 3px 7px;
        padding-right: 7px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .tab-progress {
        display: flex;
        justify-content: center;
        padding: 19px 0 44px;
        overflow-x: auto;
        scrollbar-width: none;
        gap: 4px;
        margin-top: -45px;
    }
    
    .content-card { 
      background: #fff; 
      border-radius: 12px; 
      box-shadow: var(--card-shadow);
      overflow: hidden;
      padding: 30px;
    }
    
    .form-title { 
      font-weight: 600;
      color: #1e293b;
      margin-bottom: 20px;
      padding-bottom: 12px;
      border-bottom: 1px solid #e2e8f0;
      font-size: 22px;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        box-sizing: border-box;
        display: inline-block;
        min-width: 1.5em;
        padding: .1em .5em;
        margin-left: 2px;
        text-align: center;
        text-decoration: none !important;
        cursor: pointer;
        *cursor: hand;
        color: #333 !important;
        border: 1px solid transparent;
        border-radius: 2px;
    }
    
    /* Enhanced Tab Design - Button Style */
    .tab-progress {
      display: flex;
      justify-content: center;
      padding: 20px 0 30px;
      overflow-x: auto;
      scrollbar-width: none;
      gap: 4px;
    }
    
    .tab-progress::-webkit-scrollbar {
      display: none;
    }
    
    .progress-tab {
        display: flex;
        align-items: center;
        cursor: pointer;
        padding: 3px 8px;
        border-radius: 8px;
        margin: 0 2px;
        white-space: nowrap;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        font-size: 15px;
        position: relative;
    }
    
    table.dataTable thead th {
        padding: 4px 15px;
    }
    
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #aaa;
        border-radius: 3px;
        padding: 0px;
        background-color: transparent;
        margin-left: 3px;
    }
    
    .progress-tab.active {
      background: var(--primary);
      color: white;
      box-shadow: 0 4px 10px rgba(31, 122, 224, 0.25);
    }
    
    .progress-tab.completed {
      background: var(--success-light);
      color: var(--success);
    }
    
    .progress-tab i {
      margin-right: 8px;
      font-size: 18px;
      transition: all 0.3s ease;
    }
    
    .progress-tab:hover:not(.active) {
      background: rgba(31, 122, 224, 0.08);
      color: var(--primary);
    }
    
    .progress-tab.active i {
      transform: scale(1.1);
    }
    
    /* Form styling */
    .form-label.req::after {
      content: "*";
      color: #dc3545;
      margin-left: 4px;
    }
    
    .sticky-actions {
      position: sticky;
      bottom: 0;
      background: rgba(255, 255, 255, 0.95);
    }
    
    /* Enhanced buttons */
    .btn {
      border-radius: 8px;
      padding: 1px 4px;
      font-weight: 500;
      transition: all 0.2s ease;
    }
    
    .btn-primary {
      background: linear-gradient(to right, var(--primary), var(--primary-dark));
      border: none;
      box-shadow: 0 4px 6px rgba(31, 122, 224, 0.2);
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(31, 122, 224, 0.3);
    }
    
    .btn-outline-secondary {
      border: 1px solid var(--gray-300);
      color: #333;
      background: transparent;
    }
    
    .btn-outline-secondary:hover {
      background: var(--gray-100);
      border-color: var(--gray-400);
      color: #333;
    }
    
    /* Form enhancements */
    .form-control, .form-select {
      border-radius: 8px;
      padding: 4px 10px;
      border: 1px solid var(--gray-300);
      transition: all 0.3s ease;
      height: auto;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 0.25rem rgba(31, 122, 224, 0.15);
    }

    .item_name_input{
        font-size: 9px !important;
    }
    
    h5 {
       margin-top: -13px;
       margin-bottom: 10px; 
    }
    
    .form-section {
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 1px solid var(--gray-200);
    }
    
    .form-section-title {
      font-weight: 600;
      color: var(--primary);
      margin-bottom: 15px;
      font-size: 18px;
    }
    
    hr {
        margin-bottom: 5px;
        margin-top: -10px;
        border-top: 2px solid #f9f9f9;
    }
    
    .section-title {
        color: #3a5277;
        font-weight: 600;
        padding-bottom: 0px !important;
        border-bottom: none !important;
        font-size: 12px !important;
        margin-bottom: 4px !important;
        margin-top: -8px !important;
        font-weight: bold;
        color: #0f0e0e;
        margin-top: -1px !important;
    }
    
    .fa-trash::before {
        content: "\f1f8";
        color: #b90c2c;
    }
    
    /* Responsive Design */
    @media (max-width: 992px) {
      .sticky-actions {
        position: relative;
        backdrop-filter: none;
      }

      .tab-progress {
        justify-content: flex-start;
      }
    }

    @media (max-width: 768px) {
      .progress-tab span {
        display: none;
      }

      .progress-tab i {
        margin-right: 0;
        font-size: 18px;
      }

      .progress-tab {
        padding: 12px;
      }
    }
    
    .input-group .group-input-style {
      width: 50%;   
      box-shadow: none;
    }
    
    .inline-form-group {
        display: flex;
        align-items: center;
        margin-bottom: 3px;
        border-radius: 8px;
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }
    
    .inline-form-group label {
        white-space: nowrap;
        margin-right: 10px;
    }
    
    .fa-circle-info::before, .fa-info-circle::before {
        content: "\f05a";
        color: #0a932c;
    }
    
    .btn-remove {
        padding: 0px 17px;
    }
    
    @media (max-width: 576px) {
      .app-shell {
        padding: 0 10px;
      }

      .content-card {
        padding: 20px;
      }

      .btn {
        padding: 10px 16px;
        font-size: 14px;
      }

      .tab-progress {
        padding: 15px 0;
      }
    }
    
    .table-bordered > tbody > tr > td {
        border: 1px solid #ddd8d8;
        padding: 1px;
        font-weight: bold;
        font-size: 10px;
    }
    
    .table > thead > tr > th {
        padding: 2px;
        line-height: 1.42857143;
        font-size: 12px;
        background-color: #4595C6;
        color: #fff;
    }
    
    .results-section {
        background-color: #eaeaea !important;
        padding: 0px !important;
        border-radius: 5px !important;
        margin-top: 21px;
    }
    
    h5 {
        background: #4595C6;
        padding: 6px;
        color: white !important;
    }

    .form-control {
        border-radius: 8px;
        padding: 4px 10px;
        border: 1px solid #ced3d7;
        transition: all 0.3s ease;
        height: auto;
    }
    
    .glyphicon-trash::before {
        content: "\e020";
        color: red;
    }   
   
    #deleteButton {
        color: white;
        border: none;
        font-size: 11px;
        position: relative;
        font-weight: bold;
        margin-right: 15px;
    }

    /* Modal styling */
    .modal-content {
        border-radius: 10px;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .modal-header {
        background: linear-gradient(45deg, #3c8dbc, #5faee3);
        color: white;
        border-radius: 10px 10px 0 0;
        border: none;
    }
    
    .modal-title {
        font-weight: 600;
    }

    #deleteButton::before {
        content: "\f2ed";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        left: 5px;
        top: 50%;
        transform: translateY(-50%);
    }
    
    #sc_items_filter {
        margin-top: 12px;
    }
    
    /* NEW: Table responsive with vertical scroll */
    .table-responsive {
        max-height: 400px; /* Fixed height for vertical scroll */
        overflow-y: auto; /* Vertical scroll */
        overflow-x: auto; /* Horizontal scroll for small screens */
        border-radius: 5px;
        margin-top: 10px;
    }
    
    .table-responsive table {
        margin-bottom: 0; /* Remove default margin */
        width: 100%;
        min-width: 800px; /* Minimum width to prevent too much compression */
    }
    
    .table-responsive thead th {
        position: sticky;
        top: 0;
        background-color: #4595C6;
        z-index: 10;
    }

    .dropdown-menu {
        font-size: 11px !important;
        text-align: left;
        list-style: none;
    }
    
    /* NEW: Fixed dropdown width */
    .bootstrap-select {
        width: 100% !important; /* Force full width */
    }
    
    .bootstrap-select .dropdown-toggle {
        width: 100% !important; /* Ensure toggle button takes full width */
        text-align: left;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
        
    /* Ensure consistent select box appearance */
    .form-control.selectpicker {
        width: 100% !important;
    }
    
    /* Style for dropdown items to handle long text */
    .bootstrap-select .dropdown-menu li a {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 5px 12px;
    }
    
    /* Responsive adjustments for dropdowns */
    @media (max-width: 768px) {
        .table-responsive {
            max-height: 300px;
        }
        
        .bootstrap-select .dropdown-menu {
            position: fixed !important;
            left: 10px !important;
            right: 10px !important;
            width: auto !important;
        }
    }
    
    /* Ensure inline form groups handle dropdowns properly */
    .inline-form-group .bootstrap-select {
        flex: 1;
        min-width: 0; /* Allow shrinking */
    }
</style>
  <div class="app-shell">
    <div class="row">
      <!-- Content -->
      <div class="col-xs-12">
        <div class="content-card">
          <!-- Tab Progress Indicator -->
          <div class="tab-progress">
            <button class="progress-tab active" id="tab-address" data-target="#pane-address">
              <i class="bi bi-house-door"></i>
              <span>Desk</span>
            </button>
            <button class="progress-tab" id="tab-education" data-target="#pane-education">
              <i class="bi bi-mortarboard"></i>
              <span>Commercial</span>
            </button>
          </div>
          <div class="tab-content" style="margin-top: -25px;">
            <!-- Address -->
            <div class="tab-pane fade in active" id="pane-address">
              <hr>
               <form id="formStep1">
                <div class="row">    
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="dated">Sales Contact NO<span class="req_style_id">*</span></label>
                            <input name="sales_contract_no" type="text" id="sales_contract_no" class="form-control input-sm"   value="{{$sale_contract->sales_contract_no}}"   required  max="191"  placeholder="Sales contract no" >
                            @if ($errors->has('sales_contract_no'))
                                <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                            @endif
                        </div>
                    </div> 
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="dated">Sales Contract Date<span class="req_style_id">*</span></label>
                            <input name="dated" type="text" id="dated"class="form-control datepicker input-sm"  value="{{date('d-m-Y', strtotime($sale_contract->dated))}}"   required  placeholder="Select Date"  autocomplete="off"  is_date="1" >
                            @if ($errors->has('dated'))
                                <span class="help-block"><strong>{{ $errors->first('dated') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="invoice_no">Invoice NO<span class="req_style_id">*</span></label>
                            <input name="invoice_no" type="text" id="invoice_no" class="form-control input-sm"   value="{{ $sale_contract->invoice_no }}"   max="191"  placeholder="Enter Invoice Number" required="">
                            <span id="mobile_number_error" style="color: red;position: absolute;margin-top: -55px;margin-left: 107px;"></span>
                            @if ($errors->has('invoice_no'))
                                <span class="help-block"><strong>{{ $errors->first('invoice_no') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="company_id">Company<span class="req_style_id">*</span></label>
                            <select name="company_id" id="company_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select">
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
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="notify_pary_id">Party Code<span class="req_style_id">*</span></label>
                            <select name="notify_pary_id" id="notify_pary_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                                <option value="">Select</option>
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
                        <div class="inline-form-group">
                            <label for="party_name">Party Name<span class="req_style_id">*</span></label>
                            <input name="party_name" type="text" id="party_name" class="form-control input-sm"  placeholder="Auto Field Notify Party Name" value="{{$sale_contract->party_name}}">
                            @if ($errors->has('party_name'))
                                <span class="help-block"><strong>{{ $errors->first('party_name') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="party_address">Party Addr.<span class="req_style_id">*</span></label>
                            <textarea name="party_address" type="text" id="party_address" class="form-control input-sm"  placeholder="Auto Field Notify Party Address Here">{{$sale_contract->party_address}}</textarea>
                            @if ($errors->has('party_address'))
                                <span class="help-block"><strong>{{ $errors->first('party_address') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="bank_id">Beneficiary Bank<span class="req_style_id">*</span></label>
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
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="importer_id">Importer<span class="req_style_id">*</span></label>
                            <select name="importer_id" id="importer_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                                <option value="">Select</option>
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
                        <div class="inline-form-group">
                            <label for="importer_address">Importer Addr.<span class="req_style_id">*</span></label>
                            <textarea name="importer_address" type="text" id="importer_address" class="form-control input-sm" placeholder="Importer Address(Auto Field)" required>{{$sale_contract->importer_address}}</textarea>
                            @if ($errors->has('importer_address'))
                                <span class="help-block"><strong>{{ $errors->first('importer_address') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="bank_importer_id">Importer Bank</label>
                            <select name="bank_importer_id" id="bank_importer_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                                <option value="">Select</option>
                                @foreach($bank_importers as $id => $bankName)
                                <option value="{{ $id }}" @if($id == $sale_contract->bank_importer_id){{"selected"}}@endif>{{ $bankName }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('bank_importer_id'))
                                <span class="help-block"><strong>{{ $errors->first('bank_importer_id') }}</strong></span>
                            @endif  
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="importer_country">Importer Country</label>
                            <textarea name="importer_country" type="text" id="importer_country" class="form-control input-sm"  placeholder="Enter Importer Country Name Here">{{ $sale_contract->importer_country}}</textarea>
                            @if ($errors->has('importer_country'))
                                <span class="help-block"><strong>{{ $errors->first('importer_country') }}</strong></span>
                            @endif
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="final_destination">Final Destination<span class="req_style_id">*</span></label>
                            <input name="final_destination" type="text" id="final_destination" class="form-control input-sm"   value="{{$sale_contract->final_destination}}"   required  max="191"  placeholder="Final destination" >
                            @if ($errors->has('final_destination'))
                                <span class="help-block"><strong>{{ $errors->first('final_destination') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="discharge_port">Discharge Port<span class="req_style_id">*</span></label>
                            <input name="discharge_port" type="text" id="discharge_port" class="form-control input-sm"   value="{{ $sale_contract->discharge_port }}"   max="191"  placeholder="Discharge Port" >
                            @if ($errors->has('discharge_port'))
                                <span class="help-block"><strong>{{ $errors->first('discharge_port') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="loading_place_id">Loading Place <span class="req_style_id">*</span></label>
                            <select name="loading_place_id" id="loading_place_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                                <option value="">Select</option>
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
                        <div class="inline-form-group">
                            <label for="country_id">Exporter Country<span class="req_style_id">*</span></label>
                            <select name="country_id" id="country_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
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
                    <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="carrying_mode_id">Carrying Mode<span class="req_style_id">*</span></label>
                                <select name="carrying_mode_id" id="carrying_mode_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                                    <option value="">Select</option>
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
                        <div class="inline-form-group">
                            <label for="sales_term_id">Sales Terms<span class="req_style_id">*</span></label>
                            <select name="sales_term_id" id="sales_term_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                                <option value="">Select</option>
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
                        <div class="inline-form-group">
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
                    <div class="inline-form-group">
                        <label for="terms_and_condition">T&C<span class="req_style_id">*</span></label>
                        <textarea name="terms_and_condition" type="text" id="terms_and_condition" class="form-control input-sm" required    placeholder="">{{$sale_contract->terms_and_condition}}</textarea>
                        @if ($errors->has('terms_and_condition'))
                            <span class="help-block"><strong>{{ $errors->first('terms_and_condition') }}</strong></span>
                        @endif
                    </div>
                </div>

              </div>
              <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label>20ft Cont.</label>
                            <div class="input-group">
                                <input type="text" class="form-control  group-input-style" placeholder="Qty" id="container_qty_1" name="container_qty_1" value="{{$container_qty1}}">
                                <input type="text" id="freight_cost_1"  name="freight_cost_1" class="form-control  group-input-style" placeholder="Amount" value="{{$sale_contract->freight_cost_1}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label>40ft Cont.</label>
                            <div class="input-group">
                                <input type="text" class="form-control  group-input-style" placeholder="Qty" id="container_qty_2" name="container_qty_2" value="{{$container_qty2}}">
                                <input type="text" id="freight_cost_2" name="freight_cost_2" class="form-control  group-input-style" placeholder="Amount" value="{{$sale_contract->freight_cost_2}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label>40ft HC Cont.</label>
                            <div class="input-group">
                                <input type="text" class="form-control  group-input-style" id="container_qty_3" name="container_qty_3" value="{{$container_qty3}}" placeholder="Qty">
                                <input type="text" name="freight_cost_3" id="freight_cost_3" class="form-control  group-input-style" placeholder="Amount" value="{{$sale_contract->freight_cost_3}}">
                            </div>
                        </div>
                    </div>
                   <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="total_freight_cost">Total Freight Accts<span class="req_style_id">*</span></label>
                            <input type="number" name="total_freight_cost" id="total_freight_cost" class="form-control input-sm"   placeholder="Total Freight(Auto Cal..)" readonly value="{{$sale_contract->freight_cost}}">
                            @if ($errors->has('total_freight_cost'))
                                <span class="help-block"><strong>{{ $errors->first('total_freight_cost') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="qtan_freight_cost">Freight Accts(If Revised)</label>
                            <input name="qtan_freight_cost" type="number" id="qtan_freight_cost" class="form-control input-sm"  placeholder="Revised Freight Cost" value="{{ $sale_contract->qtan_freight_cost}}">
                            @if ($errors->has('qtan_freight_cost'))
                                <span class="help-block"><strong>{{ $errors->first('qtan_freight_cost') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="desk_freight_cost">Freight(Document)</label>
                            <input name="desk_freight_cost" type="number" id="desk_freight_cost" class="form-control input-sm" placeholder="Document Freight Cost" value="{{$sale_contract->desk_freight_cost}}">
                            @if ($errors->has('desk_freight_cost'))
                                <span class="help-block"><strong>{{ $errors->first('desk_freight_cost') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="">Advance Payment</label>
                            <input name="advance_payment" type="text"  class="form-control input-sm"   value="{{$sale_contract->advance_payment}}" placeholder="Enter Advance Payment">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
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
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="is_proforma_invoice" >Is PI ?</label><br>
                            <label class="radio-inline">
                                <input type="radio" name="is_proforma_invoice"   value="1"   id="is_proforma_invoice"    @if($sale_contract->is_proforma_invoice==1){{"checked"}}@endif >Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="is_proforma_invoice"  value="0" @if($sale_contract->is_proforma_invoice==0){{"checked"}}@endif >No
                            </label>
                        </div>
                    </div> 
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="is_master" >Is Master ?</label><br>
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
                        <div class="inline-form-group">
                           <label for="footer_importer_address" >Footer addr.</label><br>
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
                    </div>   
                </div>
                <div class="results-section" style="background-color: #fff; padding: 20px; border-radius: 5px; border: 1px solid #ddd;">
                    <h5 class="section-title">
                        <i class="fa fa-list me-2" style="padding: 5px">&nbsp;&nbsp;</i><span>Doc Update</span>
                    </h5>
                    <div style="position: relative">
                      <button type="button" class="btn btn-success btn-sm pull-right" id="deleteButton" style="position: absolute;z-index: 1;bottom: -27px"><i class="fas fa-trash-alt"></i>&nbsp;Match Price</button>
                    </div>  
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="sc_items">
                            <thead>
                                <tr> 
                                    <th>Code</th>
                                    <th style="width: 116px">Doc Name</th>
                                    <th>HS Code</th>
                                    <th>Ctn(Qty)</th>
                                    <th>R/CTN(Act)</th>
                                    <th>TA Amt(Act)</th>
                                    <th>R/CTN(Party)</th>
                                    <th>TA Amt(Party)</th>
                                    <th>T/CTN (CI)</th>
                                    <th>TA Amt(CI)</th>
                                    <th>CBM/CTN</th>
                                    <th>T. CBM</th>
                                    <th>Gross WT</th>
                                    <th>Action</th>
                                </tr> 
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div>
                  </div>
                  <input type="hidden" id="sc_header_editId" name="sc_header_editId" value="{{$scid}}">
               </form> 
            </div>
            <!-- Education -->
            <div class="tab-pane fade" id="pane-education">
              <hr>
              <form id="formStep2"> 
                <div class="form-section">
                    <div class="row">
                    <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="invoice_date">Invoice Date</label>
                                <input name="invoice_date" type="text" id="invoice_date"class="form-control datepicker input-sm"  value="@if($sale_contract->invoice_date){{date('d-m-Y', strtotime($sale_contract->invoice_date))}}@endif" placeholder="invoice_date"  autocomplete="off"  is_date="1" >
                                @if ($errors->has('invoice_date'))
                                    <span class="help-block"><strong>{{ $errors->first('invoice_date') }}</strong></span>
                                @endif
                            </div>
                    </div>
                    <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="export_no">Exp No</label>
                                <input name="export_no" type="text" id="export_no" class="form-control input-sm" value="{{ $sale_contract->export_no}}" placeholder="Export Exp No" >
                                @if ($errors->has('export_no'))
                                    <span class="help-block"><strong>{{ $errors->first('export_no') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="export_date">Exp Date</label>
                                <input name="export_date" type="text" id="export_date"class="form-control datepicker input-sm"  value="@if($sale_contract->export_date){{date('d-m-Y', strtotime($sale_contract->export_date))}}@endif"  placeholder="Select Exp Date" autocomplete="off">
                                @if ($errors->has('export_date'))
                                    <span class="help-block"><strong>{{ $errors->first('export_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="ci_note">CI Note</label>
                                <textarea name="ci_note" type="text" id="ci_note" class="form-control input-sm" placeholder="Enter CI Note">{{$sale_contract->ci_note}}</textarea>
                                @if ($errors->has('ci_note'))
                                    <span class="help-block"><strong>{{ $errors->first('ci_note') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="phyto_product_name">Ins. Charge</label>
                                <input name="insurance_charge" type="text" id="insurance_charge" class="form-control input-sm"   value="{{$sale_contract->pallet_charge}}"   max="191"  placeholder="Enter Insurance Charge">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="phyto_product_name">Pallet Change</label>
                                <input name="pallet_charge" type="text" id="pallet_charge" class="form-control input-sm"   value="{{$sale_contract->pallet_charge}}"   max="191"  placeholder="Enter Pallet Charge">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="freight_cost">Freight_Cost(For CI)</label>
                                <input name="freight_cost" type="text" id="freight_cost" class="form-control input-sm"   value="{{$sale_contract->freight_cost}}"    max="191"  placeholder="Enter Freight Cost" >
                                @if ($errors->has('freight_cost'))
                                    <span class="help-block"><strong>{{ $errors->first('freight_cost') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="container">Container(For CI)</label>
                                <input name="container" type="text" id="container" class="form-control input-sm"   value="{{$sale_contract->container}}"    max="191"  placeholder="Enter Container Number" >
                                @if ($errors->has('container'))
                                    <span class="help-block"><strong>{{ $errors->first('container') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="bl_no">BL No(For CO)</label>
                                <input name="bl_no" type="text" id="bl_no" class="form-control input-sm"   value="{{$sale_contract->bl_no}}"   max="191"  placeholder="Enter BL No">
                                @if ($errors->has('bl_no'))
                                    <span class="help-block"><strong>{{ $errors->first('bl_no') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="bl_date">BL Date(For CO)</label>
                                <input name="bl_date" type="text" id="bl_date" class="form-control datepicker input-sm"  value="@if($sale_contract->bl_date){{date('d-m-Y', strtotime($sale_contract->bl_date))}}@endif" placeholder="Bl date for CO"  autocomplete="off"  is_date="1" >
                                @if ($errors->has('bl_date'))
                                    <span class="help-block"><strong>{{ $errors->first('bl_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="is_proforma_invoice" >Vessel/VOY Name(For CO)</label><br>
                                <input name="vehicle" type="text" id="vehicle" class="form-control input-sm"   value="{{$sale_contract->vehicle}}"  placeholder="vehicle Name" >
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="is_proforma_invoice" >Product Name(For CO)</label><br>
                                <input name="revise_product_name" type="text" id="revise_product_name" class="form-control input-sm"   value="{{$sale_contract->revise_product_name}}"  placeholder="Product Name For CO" autocomplete="on">
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="ci_note">Note If Any(Shipping Mark)</label>
                                <input name="ci_note" type="text" id="ci_note" class="form-control input-sm"   value="{{$sale_contract->ci_note}}"   max="191"  placeholder="Enter note">
                                @if ($errors->has('ci_note'))
                                    <span class="help-block"><strong>{{ $errors->first('ci_note') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="bl_date_cer">BL Date(For CER)</label>
                                <input name="bl_date_cer" type="text" id="bl_date_cer" class="form-control datepicker input-sm"  value="{{$sale_contract->bl_date_cer}}"  placeholder="Bl date for cer"  autocomplete="off"  is_date="1" >
                                @if ($errors->has('bl_date_cer'))
                                    <span class="help-block"><strong>{{$errors->first('bl_date_cer')}}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="mv_or_voy">M.V. /VOY: </label>
                                <input name="mv_or_voy" type="text" id="mv_or_voy" class="form-control input-sm"  placeholder="Enter Your MV/VOY Name" value="{{$sale_contract->mv_or_voy}}">
                                @if ($errors->has('mv_or_voy'))
                                    <span class="help-block"><strong>{{ $errors->first('mv_or_voy') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="container_number">Container Number: </label>
                                <input name="container_number" type="text" id="container_number" class="form-control input-sm"  placeholder="Enter Container Number" value="{{$sale_contract->container_number}}">
                                @if ($errors->has('container_number'))
                                    <span class="help-block"><strong>{{ $errors->first('container_number') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="bl_date">Tr Report Date</label>
                                <input name="tr_report_date" type="text" id="tr_report_date" class="form-control datepicker input-sm"  value="{{$sale_contract->tr_report_date}}"    placeholder="Select Tr Report Date" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="phyto_product_name">Foreign Port(For Land)</label>
                                <input name="foreign_port" type="text" id="foreign_port" class="form-control input-sm"   value="{{$sale_contract->foreign_port}}"   max="191"  placeholder="Foreign Port (For Land)">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="terms_and_condition_desk_inv">T&C(For Com)</label>
                                <textarea name="terms_and_condition_desk_inv" type="text" id="terms_and_condition_desk_inv" class="form-control input-sm" placeholder="Enter T&C For Com">{{$sale_contract->terms_and_condition_desk_inv}}</textarea>
                                @if ($errors->has('terms_and_condition_desk_inv'))
                                    <span class="help-block"><strong>{{ $errors->first('terms_and_condition_desk_inv') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="angikar_given_by">Angikar  Given By</label>
                                <textarea name="angikar_given_by" type="text" id="angikar_given_by" class="form-control input-sm" placeholder="Enter Angikar Given By">{{$sale_contract->angikar_given_by}}</textarea>
                                @if ($errors->has('angikar_given_by'))
                                    <span class="help-block"><strong>{{ $errors->first('angikar_given_by') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="phyto_product_name">Phyto Product Name</label>
                                <textarea name="phyto_product_name" type="text" id="phyto_product_name" class="form-control input-sm" placeholder="Enter Phyto Product Name">{{$sale_contract->phyto_product_name}}</textarea>
                                @if ($errors->has('phyto_product_name'))
                                    <span class="help-block"><strong>{{ $errors->first('phyto_product_name') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="phyto_product_name">Also Notify Party</label>
                                <textarea class="form-control input-sm" name="third_notify_party" placeholder="Enter Also Notify Party">{{$sale_contract->third_notify_party}}</textarea>
                                @if ($errors->has('phyto_product_name'))
                                    <span class="help-block"><strong>{{ $errors->first('phyto_product_name') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="phyto_product_name">Bank Addr.(India)</label>
                                <textarea class="form-control input-sm" name="bank_address_for_india" placeholder="Enter Bank Address">{{$sale_contract->bank_address_for_india}}</textarea>
                                @if ($errors->has('phyto_product_name'))
                                    <span class="help-block"><strong>{{ $errors->first('phyto_product_name') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="phyto_product_name">Customs Decl.(For India)</label>
                                <textarea class="form-control" name="custom_declaration" placeholder="Enter Custom Declaration">{{$sale_contract->custom_declaration}}</textarea>
                                @if ($errors->has('phyto_product_name'))
                                    <span class="help-block"><strong>{{ $errors->first('phyto_product_name') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="factory_address_type_id">Factory Address(If Need)</label>
                                <select name="factory_address_type_id" id="factory_address_type_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select">
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
                            <div class="inline-form-group">
                                <label for="phyto_product_name">BD Port(For Land)</label>
                                <input name="bd_port" type="text" id="bd_port" class="form-control  input-sm"   value="{{$sale_contract->bd_port}}"   max="191"  placeholder="Enter DB Port">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">LC Terms(Only For India)</label>
                                <input name="lc_term_for_india" type="text"  class="form-control input-sm" value="{{$sale_contract->lc_term_for_india}}" placeholder="Enter LC Terms(Only India)">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                            <label for="">Freight Charge(For India)</label>
                            <input name="freight_charge_india" type="text"  class="form-control input-sm"   value="{{$sale_contract->freight_charge_india}}" placeholder="Enter Freight Charge(Only India)">
                            </div>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">Lot Number(For India)</label>
                                <input name="lot_number" type="text"  class="form-control input-sm"   value="{{$sale_contract->lot_number}}" placeholder="Enter lot Number(Only India)">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                            <label for="">Best Before(For India)</label>
                            <input name="best_before_india" type="text"  class="form-control input-sm"   value="{{$sale_contract->best_before_india}}" placeholder="Enter Best Before(Only India)">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                            <label for="">GSP Ref. No.</label>
                            <input name="gsp_ref_number" type="text"  class="form-control input-sm"   value="{{$sale_contract->gsp_ref_number}}" placeholder="Enter GSP Ref no"> 
                            </div>    
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">Shipping Mark(For India)</label>
                                <input name="shipping_mark_india" type="text"  class="form-control input-sm"   value="{{$sale_contract->shipping_mark_india}}" placeholder="Enter Shipping Mark(Only India)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="dated">Safta Date(For India)</label>
                                <input name="safta_dated" type="text" id="dated"class="form-control datepicker input-sm"  value="@if(!empty($sale_contract->safta_dated)){{date('d-m-Y', strtotime($sale_contract->safta_dated))}}@endif"  placeholder="Select Date"  autocomplete="off"  is_date="1">
                                @if ($errors->has('dated'))
                                    <span class="help-block"><strong>{{ $errors->first('dated') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="dated">Freight Date(For India)</label>
                                <input name="freight_date" type="text" id="dated" class="form-control datepicker input-sm"  value="@if(!empty($sale_contract->freight_date)){{date('d-m-Y', strtotime($sale_contract->freight_date))}}@endif"  placeholder="Select Date"  autocomplete="off"  is_date="1" >
                                @if ($errors->has('dated'))
                                    <span class="help-block"><strong>{{ $errors->first('dated') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="arv_amount">Arv Amount(For India)</label>
                                <input name="arv_amount" type="text" class="form-control input-sm"  value="{{$sale_contract->arv_amount}}"  placeholder="Arv_amount"  autocomplete="off">
                                @if ($errors->has('arv_amount'))
                                    <span class="help-block"><strong>{{ $errors->first('arv_amount') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="arv_amount_received_date">ARV Amt Receipt Dt(For India)</label>
                                <input name="arv_amount_received_date" type="text" class="form-control datepicker input-sm"  value="{{$sale_contract->arv_amount_received_date}}"  placeholder="Select Date"  autocomplete="off"  is_date="1" >
                                @if ($errors->has('arv_amount_received_date'))
                                    <span class="help-block"><strong>{{ $errors->first('arv_amount_received_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">DCC Memo No:</label>
                                <input name="dcc_memo_no" type="text" class="form-control input-sm"  value="{{$sale_contract->dcc_memo_no}}"  placeholder="Enter Dcc Memo No"  autocomplete="off"  is_date="1">
                                @if ($errors->has('dcc_memo_no'))
                                    <span class="help-block"><strong>{{ $errors->first('dcc_memo_no') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">Mfg Date(For India)</label>
                                <input name="india_mfg_setup_date" type="text" class="form-control input-sm"  value="{{$sale_contract->india_mfg_setup_date}}"  placeholder="Mfg Date"  autocomplete="off"  is_date="1">
                                @if ($errors->has('india_mfg_setup_date'))
                                    <span class="help-block"><strong>{{ $errors->first('india_mfg_setup_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="transport_agency_id">Transport Agency</label>
                                <select name="transport_agency_id" id="transport_agency_id" data-live-search="true" class="form-control select2 selectpicker input-sm"  type="select"  value="1" >
                                    <option value="">Select</option>
                                    @foreach($transportAgencyies as $transportAgency)
                                    <option value="{{$transportAgency->id}}"  @if($transportAgency->id == $sale_contract->transport_agency_id){{"selected"}} @endif>{{$transportAgency->transport_agency_info}}</option>
                                    @endforeach
                                </select>  
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="custom_station_id">Custom Station</label>
                                <select name="custom_station_id" id="custom_station_id" data-live-search="true" class="form-control select2 selectpicker input-sm"  type="select"  value="1" >
                                    <option value="">Select</option>
                                    @foreach($customStations as $customStation)
                                    <option value="{{$customStation->id}}"  @if($customStation->id == $sale_contract->custom_station_id){{"selected"}} @endif>{{$customStation->agent_name}}</option>
                                    @endforeach
                                </select>  
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">App for CNF (Print Dt)</label>
                                <input name="cnf_print_date" type="text" class="form-control input-sm datepicker"  value="{{$sale_contract->cnf_print_date}}"  placeholder="App for cnf print date"  autocomplete="off"  is_date="1">
                                @if ($errors->has('cnf_print_date'))
                                    <span class="help-block"><strong>{{ $errors->first('cnf_print_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="shipping_line_id">Freight Forwarder Name</label>
                                <select name="shipping_line_id" id="shipping_line_id" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1">
                                    <option value="">Select</option>
                                    @foreach($shippingLines as $shippingLine)
                                    <option value="{{$shippingLine->id}}" @if($shippingLine->id==$sale_contract->shipping_line_id){{'selected'}}@endif>{{$shippingLine->shipping_name}} / {{$shippingLine->license_number}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="shipping_line_id">Name Of Shipping Line</label>
                                <select name="name_of_shipping_line_id" id="name_of_shipping_line_id" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1">
                                    <option value="">Select</option>
                                    @foreach($shippingLines->where('type', 'Shipper') as $shippingLine)
                                        <option value="{{ $shippingLine->id }}"
                                            @if($shippingLine->id == $sale_contract->name_of_shipping_line_id)
                                                selected
                                            @endif>
                                            {{ $shippingLine->shipping_name }} / {{ $shippingLine->license_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('name_of_shipping_line_id'))
                                    <span class="help-block"><strong>{{ $errors->first('name_of_shipping_line_id') }}</strong></span>
                                @endif   
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">Freight Amount(FC)</label>
                                <input name="freight_amount_fc" type="text" class="form-control input-sm"  value="{{$sale_contract->freight_amount_fc}}"  placeholder="Enter Freight Amount (FC)">
                                @if ($errors->has('freight_amount_fc'))
                                    <span class="help-block"><strong>{{ $errors->first('freight_amount_fc') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">Freight Amount (BDT)</label>
                                <input name="freight_amount_btd" type="text" class="form-control input-sm"  value="{{$sale_contract->freight_amount_btd}}"  placeholder="Enter 0000000
                                0A0*1mount (BDT)">
                                @if($errors->has('freight_amount_btd'))
                                    <span class="help-block"><strong>{{ $errors->first('freight_amount_btd') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="master_airway_bill_no">House Airway Bill No</label>
                                <input name="master_airway_bill_no" type="text" class="form-control input-sm"  value="{{$sale_contract->master_airway_bill_no}}"  placeholder="Enter House Airway Bill No">
                                @if ($errors->has('master_airway_bill_no'))
                                    <span class="help-block"><strong>{{ $errors->first('master_airway_bill_no') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">House Airway Bill Date</label>
                                <input name="master_airway_bill_date" type="text" class="form-control input-sm datepicker"  value="@if($sale_contract->master_airway_bill_date){{date('d-m-Y', strtotime($sale_contract->master_airway_bill_date))}}@endif"  placeholder="Enter House Airway Bill Date" autocomplete="off">
                                @if ($errors->has('master_airway_bill_date'))
                                    <span class="help-block"><strong>{{ $errors->first('master_airway_bill_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="oc_date">OC Date:</label>
                                <input name="oc_date" type="text" id="oc_date" class="form-control input-sm datepicker"  placeholder="Select OC Date" value="{{$sale_contract->oc_date}}" autocomplete="off">
                                @if ($errors->has('oc_date'))
                                    <span class="help-block"><strong>{{ $errors->first('oc_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="salary_adjustment">Salary Adjustment:</label>
                                <input name="salary_adjustment" type="text" id="salary_adjustment" class="form-control input-sm"  placeholder="Enter Your Salary Adjustment" value="{{$sale_contract->salary_adjustment}}">
                                @if ($errors->has('salary_adjustment'))
                                    <span class="help-block"><strong>{{ $errors->first('salary_adjustment') }}</strong></span>
                                @endif
                            </div>  
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="is_notify_also_notity" >Notify/Also Notify</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_notify_also_notity"   value="1"   id="is_notify_also_notity" @if($sale_contract->is_notify_also_notity==1){{"checked"}}@endif>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_notify_also_notity" id="is_notify_also_notity" value="0" @if($sale_contract->is_notify_also_notity=='0'){{"checked"}}@endif>No
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="tr_no_is_exist" >TR No.(Land Only)</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="tr_no_is_exist"   value="1"   id="tr_no_is_exist" @if($sale_contract->tr_no_is_exist==1){{"checked"}}@endif>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="tr_no_is_exist" id="tr_no_is_exist" value="0" @if($sale_contract->tr_no_is_exist=='0'){{"checked"}}@endif>No
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="address_replace" >Address Replace</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="address_replace"   value="1"   id="address_replace"  @if($sale_contract->address_replace==1){{"checked"}}@endif>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="address_replace"   value="0"   id="address_replace"  @if($sale_contract->address_replace=='0'){{"checked"}}@endif>No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="is_total_amount_oceania">T.A. Visible(Oceania)</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_total_amount_oceania"   value="1"   id="is_total_amount_oceania"  @if($sale_contract->is_total_amount_oceania==1){{"checked"}}@endif >Yes
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
                            <div class="inline-form-group">
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
                            <div class="inline-form-group">
                                <label for="mfg_date_india" >Is Hs Code2 ?</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_hscode2" id="is_hscode2" value="1" @if($sale_contract->is_hscode2==1){{"checked"}}@endif>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_hscode2" id="is_hscode2" value="0" @if($sale_contract->is_hscode2=='0'){{"checked"}}@endif>No
                                </label>
                            </div>
                        </div> 
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="mfg_date_india" >Is FOB ?</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_fob" id="is_fob" value="1" @if($sale_contract->is_fob==1){{"checked"}}@endif>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_fob" id="is_fob" value="0" @if($sale_contract->is_fob=='0'){{"checked"}}@endif>No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="mfg_date_india" >Is Bank ?</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_bank" id="is_bank" value="1" @if($sale_contract->is_bank==1){{"checked"}}@endif>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_bank" id="is_bank" value="0" @if($sale_contract->is_bank=='0'){{"checked"}}@endif>No
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="mfg_date_india" >Billed To?</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_billed_to" id="is_billed_to" value="1" @if($sale_contract->billed_to==1){{"checked"}}@endif>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_billed_to" id="is_billed_to" value="0" @if($sale_contract->billed_to==0){{"checked"}}@endif>No
                                </label>
                            </div>
                        </div>
                         <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="mfg_date_india" >Is Hs Code?</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_hscode" id="is_hscode" value="1" @if($sale_contract->is_hscode==1){{"checked"}}@endif>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_hscode" id="is_hscode" value="0" @if($sale_contract->is_hscode==0){{"checked"}}@endif>No
                                </label>
                            </div>
                        </div>
                    </div>
                  </div>
                 <input type="hidden" id="sc_line_editId" name="sc_line_editId" value="{{$scid}}">
             </form>    
            </div>
            <!-- Modal -->
            <div class="modal fade" id="desk_update" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" style="margin-top: 80px;">
                    <div class="modal-content custom-modal">
                        <!-- Header -->
                        <div class="modal-header custom-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">
                            <i class="glyphicon glyphicon-list-alt"></i>&nbsp;Doc Item Update
                            </h4>
                        </div>
                        <form id="itemDetailsForm"> 
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="inline-form-group">
                                            <label for="ci_item_id">Code</label>
                                            <select name="e_ci_item_id" id="e_ci_item_id" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1" required>
                                                <option value="">Select</option>
                                            </select>
                                            @if ($errors->has('ci_item_id'))
                                                <span class="help-block"><strong>{{ $errors->first('ci_item_id') }}</strong></span>
                                            @endif  
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="inline-form-group">
                                            <label for="desk_item_name">Desk Name</label>
                                            <input name="e_desk_item_name" type="text" id="e_desk_item_name" class="form-control input-sm "  placeholder="Party Item Name" value="" readonly>
                                            @if ($errors->has('desk_item_name'))
                                                <span class="help-block"><strong>{{ $errors->first('desk_item_name') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="inline-form-group">
                                            <label for="rate_per_ctn_for_acc">Doc Name</label>
                                            <input name="e_doc_name" type="text" id="e_doc_name" class="form-control input-sm"  placeholder="Enter R/CTN(Act)" value="{{$sale_contract->oc_date}}">
                                            @if ($errors->has('e_doc_name'))
                                                <span class="help-block"><strong>{{ $errors->first('e_doc_name') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="inline-form-group">
                                            <label for="ctn">Ctn(Qty)</label>
                                            <input name="e_ctn" type="text" id="e_ctn" class="form-control input-sm "  placeholder="Enter Ctn(Qty)" value="">
                                            @if ($errors->has('ctn'))
                                                <span class="help-block"><strong>{{ $errors->first('ctn') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="inline-form-group">
                                            <label for="e_doc_ctn_rate">Doc Rate</label>
                                            <input name="e_doc_ctn_rate" type="text" id="e_doc_ctn_rate" class="form-control input-sm"  placeholder="Doc Ctn Rate" value="">
                                            @if ($errors->has('e_doc_ctn_rate'))
                                                <span class="help-block"><strong>{{ $errors->first('e_doc_ctn_rate') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="inline-form-group">
                                            <label for="rate_per_ctn_for_party">Tot Amt(Doc)</label>
                                            <input name="e_doc_total_amt" type="text" id="e_doc_total_amt" class="form-control input-sm"  placeholder="Total Doc Amount" value="" readonly>
                                            @if ($errors->has('rate_per_ctn_for_party'))
                                                <span class="help-block"><strong>{{ $errors->first('rate_per_ctn_for_party') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="inline-form-group">
                                            <label for="hs_code">HS Code</label>
                                            <input name="e_hs_code" type="text" id="e_hs_code" class="form-control input-sm "  placeholder="Enter HS Code" value="">
                                            @if ($errors->has('hs_code'))
                                                <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="inline-form-group">
                                            <label for="hs_code">HS Code2</label>
                                            <input name="e_hs_code2" type="text" id="e_hs_code2" class="form-control input-sm "  placeholder="Enter HS Code2" value="">
                                            @if ($errors->has('hs_code'))
                                                <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="inline-form-group">
                                            <label for="hs_code">Cbm/Ctn</label>
                                            <input name="e_cbm_per_ctn" type="text" id="e_cbm_per_ctn" class="form-control input-sm "  placeholder="Enter Cbm/Ctn" value="" required readonly>
                                            @if ($errors->has('hs_code'))
                                                <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="inline-form-group">
                                            <label for="hs_code">Total Cbm</label>
                                            <input name="e_total_cbm" type="text" id="e_total_cbm" class="form-control input-sm "  placeholder="Enter total cbm" value="" required readonly>
                                            @if ($errors->has('hs_code'))
                                                <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <input type="hidden" value="" id="item_line_id" name="item_line_id">                            
                                </div>
                            </div>
                        <!-- Footer -->
                        <div class="modal-footer custom-footer">
                            <button type="button" class="btn btn-success update_item"><i class="glyphicon glyphicon-download"></i>Update</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" style="background: #ff1515b2;">Close</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
          </div>
          <!-- Actions -->
          <div class="sticky-actions clearfix">
            <div class="pull-left">
              <button class="btn btn-info" id="btnPrev"><i class="bi bi-arrow-left"></i> Previous</button>
            </div>
            <div class="pull-right">
              <button class="btn btn-primary btn-flat" id="btnNext">Update And Next<i class="bi bi-arrow-right"></i></button>
              <button class="btn btn-success btn-flat" id="btnSave"><i class="bi bi-check2-circle"></i> Update & Submit</button>
            </div>
          </div>
          <input type="hidden" id="selectedScId" value="{{$scid}}">
          <input type="hidden" id="selectedparty" value="{{$partyId}}"> 
        </div>
      </div>
    </div>
  </div>
  <script>document.title = 'Sales Contract | Edit';
    setTimeout(function() { 
        $('.sr-only').click();
    }, 0.0001);

    $(document).ready(function() {

        // Initialize DataTable
        $('#sc_items').DataTable({
            "ordering": false,
            "stateSave": true,
            "lengthMenu": [[-1], ["All"]],
            "pageLength": -1,
            "bLengthChange": false,
            "order": [[0, "asc"]]
        });

        // Delete temp table data on page load
        $.ajax({
            url: '/page_load/delete/temp_item',
            type: 'GET',
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });

        // Load initial data
        let sc_id = $("#selectedScId").val();
        fetchBuyerTasks(sc_id);
        freightHandlerFun(sc_id);
        
        let party_id = $("#selectedparty").val();
        fetchPartyPos(party_id);

        // Function to calculate and display summary row
        function addSummaryRow() {
            let totalCtn = 0;
            let totalAccValue = 0;
            let totalPartyValue = 0;
            let totalCbm = 0;
            let totalGrossWeight = 0;

            $('#sc_items tbody tr').each(function() {
                const $row = $(this);               
                if ($row.hasClass('summary-row')) return;
                
                const ctn = parseFloat($row.find('td').eq(3).text().trim()) || parseFloat($row.find('td').eq(3).find('input').val()) || 0;
                const accValue = parseFloat($row.find('td').eq(5).text().trim()) || parseFloat($row.find('td').eq(5).find('input').val()) || 0;
                const partyValue = parseFloat($row.find('td').eq(7).text().trim()) || parseFloat($row.find('td').eq(7).find('input').val()) || 0;
                const cbm = parseFloat($row.find('td').eq(11).text().trim()) || parseFloat($row.find('td').eq(11).find('input').val()) || 0;
                const grossWeight = parseFloat($row.find('td').eq(12).text().trim()) || parseFloat($row.find('td').eq(12).find('input').val()) || 0;

                totalCtn += ctn;
                totalAccValue += accValue;
                totalPartyValue += partyValue;
                totalCbm += cbm;
                totalGrossWeight += grossWeight;
            });

            $('#sc_items tbody .summary-row').remove();

            const summaryRow = `
                <tr class="summary-row" style="background-color: #4595C6; font-weight: bold;color: white">
                    <td colspan="3" style="text-align: center; color: #FFFFFF;">GRAND TOTALS :</td>
                    <td>${totalCtn.toFixed(2)}</td>
                    <td>-</td>
                    <td>${totalAccValue.toFixed(2)}</td>
                    <td>-</td>
                    <td>${totalPartyValue.toFixed(2)}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>${totalCbm.toFixed(3)}</td>
                    <td>${totalGrossWeight.toFixed(3)}</td>
                    <td>-</td>
                </tr>
            `;
            
            $('#sc_items tbody').append(summaryRow);
        }

        // Plot Sales Contract Items
        function fetchBuyerTasks(sc_id) {
            $.ajax({
                url: '/json/get/sc_edit/items',
                type: 'GET',
                data: {sc_id: sc_id },
                success: function(res) {

                    ploatSalesContractItems(res.data);
                },
                error: function(xhr, status, error) {
                    console.error('Error checking invoice number: ', error);
                }
            });
        }

        function ploatSalesContractItems(data) {

            $('#sc_items tbody').empty();
            if(data.length > 0) {
                data.forEach(function(item) {
                    var row = '<tr>' +
                        '<td>' + item.item_code + '</td>' +
                        '<td><input type="text" class="form-control form-control-sm item_name_input" value="' + item.doc_name + '" data-id="' + item.id + '"></td>' +
                        '<td>' + item.hs_code + '</td>' +
                        '<td>' + item.total_ctn + '</td>' +
                        '<td>' + item.acc_rate_per_ctn + '</td>' +
                        '<td>' + item.total_acc_value + '</td>' +
                        '<td>' + item.party_rate_per_ctn + '</td>' +
                        '<td>' + item.total_party_value + '</td>' +
                        '<td>' + item.ci_rate_per_ctn + '</td>' +
                        '<td>' + item.total_ci_value + '</td>' +
                        '<td>' + item.cbm_per_ctn + '</td>' +
                        '<td>' + item.total_cbm + '</td>' +
                        '<td>' + item.gross_weight + '</td>' +
                        '<td><button type="button" class="btn btn-sm btn-primary update-btn" data-id="' + item.id + '" title="Desk Update"><i class="fa fa-edit"></i></button></td>' +
                    '</tr>';
                    $('#sc_items tbody').append(row);
                });
                
                addSummaryRow();
            } else {
                $('#sc_items tbody').append('<tr><td colspan="14" class="text-center">No data available</td></tr>');
            }
        }

        // Freight Handler
        function freightHandlerFun(sc_id) {
            $.ajax({
                url: '/json/handle/freight/control',
                type: 'GET',
                data: {sc_id: sc_id },
                success: function(res) {
                    if(res.status){
                        $("#container_qty_1").prop("readonly", true);
                        $("#container_qty_2").prop("readonly", true);
                        $("#container_qty_3").prop("readonly", true);
                        $("#freight_cost_1").prop("readonly", true);
                        $("#freight_cost_2").prop("readonly", true);
                        $("#freight_cost_3").prop("readonly", true);
                        $("#desk_freight_cost").prop("readonly", false);
                        $("#qtan_freight_cost").prop("readonly", true);
                        $("#sales_term_id").prop("readonly", true); 
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error checking invoice number: ', error);
                }
            });
        }

        // Fetch Party Wise PO List
        function fetchPartyPos(party_id) {
            var url = "{{url('/')}}"+"/json/get_buyer/po_list?party_id="+party_id;
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
                        $el.append($("<option></option>").attr("value", value['ID']).text(value['PO_NO']));
                    });
                    $el.selectpicker('refresh');
                }
            }); 
        }

        //@@@@---make price same---
        $('#deleteButton').click(function() {

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to revise item rate!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Match!'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '/doc_make_price_same',
                        type: 'GET',
                        data: {
                            "sale_contact_id": $('#sc_header_editId').val()
                        },
                        success: function(res) {

                            if(res.code == 200){
                                $('.sub_chk:checked').closest('tr').remove();
                                addSummaryRow();
                                Swal.fire('Success!', 'The item rate matching successfully.!', 'success');
                            } else {
                                Swal.fire('Error!', 'Something went wrong. Please try again later.', 'error');

                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'Something went wrong with the request.', 'error');
                        }
                    });
                }
            });
        });

        // Check Invoice Number Existence
        $('#invoice_no').on('keyup input', function() {
            var invoiceNumber = $(this).val();
            if (invoiceNumber.trim() === '' || invoiceNumber.length < 8) {
                $('#invoice_no_error').text('');
                $(this).css('border-color', '');
                return;
            }

            $.ajax({
                url: '/check/invoice/number/exist/ornot',
                type: 'GET',
                data: { invoice_no: invoiceNumber },
                success: function(data) {
                    if (data == '1') {
                        $('#invoice_no_error').text('Invoice number already exists.');
                        $('#invoice_no').css('border-color', 'red');
                        $('#btnNext').prop("disabled", true);
                    } else {
                        $('#invoice_no_error').text('');
                        $('#invoice_no').css('border-color', 'green');
                        $('#btnNext').prop("disabled", false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error checking invoice number: ', error);
                }
            });
        });

        $('#sales_contract_no').on('keyup paste change input', function() {
            var value = $(this).val();
            var cleaned = value.replace(/\s/g, '');
            if (value !== cleaned) {
                $(this).val(cleaned);
            }
        });

        // Total Freight Cost Calculation
        $('#freight_cost_1, #freight_cost_2, #freight_cost_3').on('keyup input', function() {
            var freightCost1 = parseFloat($('#freight_cost_1').val()) || 0;
            var freightCost2 = parseFloat($('#freight_cost_2').val()) || 0;
            var freightCost3 = parseFloat($('#freight_cost_3').val()) || 0;
            var totalFreightCost = freightCost1 + freightCost2 + freightCost3;
            $('#total_freight_cost').val(totalFreightCost.toFixed(3));
        });

        // calculate total cbm on ctn Qty field
        $('#e_ctn').on('keyup', function() {
            var cbmPerCtn = parseFloat($('#e_cbm_per_ctn').val()) || 0;
            var ctnQty = parseFloat($(this).val()) || 0;
            var totalCbm = cbmPerCtn * ctnQty;
            $('#e_total_cbm').val(totalCbm.toFixed(3));
        });

        // Update Item Modal
        $(document).on('click', '.update-btn', function() {
            var itemId = $(this).data('id');
            var sc_id = $('#sc_header_editId').val();
            // Make the Item Code field read-only
            $('#e_ci_item_id').prop('disabled', true);
            $.ajax({
                url: '/json/get/sales_contract/doc_item',
                type: 'GET',
                data: {'itemId': itemId,'sc_id': sc_id},
                success: function(res) {

                    updateItem(res.items, res.data.item_id);
                    $('#e_desk_item_name').val(res.data.item_name);
                    $('#e_doc_name').val(res.data.doc_name);
                    $('#e_ctn').val(res.data.total_ctn);
                    $('#e_doc_ctn_rate').val(res.data.ci_rate_per_ctn);
                    $('#e_doc_total_amt').val(res.data.total_ci_value);
                    $('#e_hs_code').val(res.data.hs_code);
                    $('#e_cbm_per_ctn').val(res.data.cbm_per_ctn);
                    $('#e_total_cbm').val(res.data.total_cbm);
                    $('#item_line_id').val(itemId);

                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
            $('#desk_update').modal('show');
        });

        // Re-enable the field when modal is closed
        $('#desk_update').on('hidden.bs.modal', function () {
            $('#e_ci_item_id').prop('disabled', false);
        });

       $('.update_item').on('click', function(e) {

            e.preventDefault(); 
            var formData = $('#itemDetailsForm').serialize();  
            var sc_id = $('#sc_header_editId').val();
            formData += '&sc_id=' + encodeURIComponent(sc_id);

            $.ajax({
                url: '/update/item_info/for_doc', 
                type: 'POST', 
                data: formData, 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    if (res.status === 'success') {
                        Swal.fire('Success', res.msg, 'success');
                        ploatSalesContractItems(res.data);
                        $('#desk_update').modal('hide');
                    } else {
                        Swal.fire('Failed', res.msg, 'warning');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                }

            });
            
        });


        function updateItem(data,item_id){

            if(data){
                var $el = $('#e_ci_item_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function (key, value) {
                    $('select[name="e_ci_item_id"]').append(`<option value="${value.id}" ${value.item_id == item_id ? 'selected' : ''}>${value.item_code}</option>`)
                });
                $el.selectpicker('refresh');
            }else{
                var $el = $('#e_ci_item_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $el.selectpicker('refresh'); 
            }
        }

        // Company Bank Change
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
            });
        });

        // Importer Change
        $('#importer_id').on('change',function (){
            var imp_id = $(this).val();
            var url = "{{url('/')}}"+"/json/get/imp/ship_details?imp_id="+imp_id;
            $.get(url,function(res) {                 
                $('#importer_address').val(res.impAddress);
            });
        });

        // Update summary when items are modified
        $(document).on('input', '.item_name_input, .total_ctn, .acc_rate_per_ctn, .party_rate_per_ctn, .cbm_per_ctn, .gross_weight, .total_party_value, .total_acc_value', function() {
            setTimeout(addSummaryRow, 100);
        });

        // Tab Navigation Logic
        var tabs = $('.progress-tab');
        var nextBtn = $('#btnNext');
        var prevBtn = $('#btnPrev');
        var saveBtn = $('#btnSave');
        var currentTab = 0; // Start with tab-address (index 0) - Desk tab
        let isFirstSubmission = true;

        function updateUI() {
            tabs.each(function(index) {
                if (index < currentTab) {
                    $(this).addClass('completed');
                    $(this).removeClass('active');
                } else if (index === currentTab) {
                    $(this).addClass('active');
                    $(this).removeClass('completed');
                } else {
                    $(this).removeClass('active completed');
                }
            });

            if (currentTab === 0) {
                prevBtn.css('visibility', 'hidden');
            } else {
                prevBtn.css('visibility', 'visible');
            }

            if (currentTab === tabs.length - 1) {
                nextBtn.hide();
                saveBtn.show();
            } else {
                nextBtn.show();
                saveBtn.hide();
            }

            var targetPane = $(tabs[currentTab]).data('target');
            $('.tab-pane').removeClass('in active');
            $(targetPane).addClass('in active');
        }

        function collectTableItems() {
            var tableItems = [];
            $('#sc_items tbody tr').each(function() {
                var row = $(this);
                
                if ($(this).hasClass('summary-row')) return;
                
                function getCellValue(cellIndex) {
                    var cell = row.find('td').eq(cellIndex);
                    var input = cell.find('input');
                    if (input.length > 0) {
                        return input.val() ? input.val().trim() : '';
                    } else {
                        return cell.text().trim();
                    }
                }
                
                var itemData = {
                    id: row.find('.update-btn').data('id'),
                    item_code: getCellValue(0),
                    item_name: getCellValue(1),
                    hs_code: getCellValue(2),
                    total_ctn: getCellValue(3),
                    acc_rate_per_ctn: getCellValue(4),
                    total_acc_value: getCellValue(5),
                    party_rate_per_ctn: getCellValue(6),
                    total_party_value: getCellValue(7),
                    ci_rate_per_ctn: getCellValue(8),
                    total_ci_value: getCellValue(9),
                    cbm_per_ctn: getCellValue(10),
                    total_cbm: getCellValue(11),
                    gross_weight: getCellValue(12)
                };
                
                tableItems.push(itemData);
            });
            
            return tableItems;
        }

        $('#tab-education').on('click', function() {
            var invoiceNo = $('#invoice_no').val();
            if (invoiceNo) {
                $('#desk-info-display').remove();
                $('#pane-education').prepend(`
                    <div id="desk-info-display" style="margin-bottom: 10px; font-weight: bold; background: #eaeaea; padding: 5px 10px; border-radius: 4px;">
                        Invoice No: <span style="color: #d35400; font-weight: 800;">${invoiceNo}</span>
                    </div>
                `);
            }
        });

        // Form validation function
        function validateForm(formId) {
            let isValid = true;
            let missingFields = [];
            $('.field-error').removeClass('field-error');
            $('.bootstrap-select.error').removeClass('error');
            
            $('#' + formId + ' select[required]').each(function() {
                var field = $(this);
                var fieldValue = field.val() ? field.val().trim() : '';                
                var container = field.next('.bootstrap-select');
                if (!container.length) {
                    container = field.closest('.bootstrap-select');
                }
                if (!container.length) {
                    container = field.parent().find('.bootstrap-select');
                }

                if (fieldValue === "") {
                    isValid = false;
                    missingFields.push(field.attr('id'));
                    if (container.length) {
                        container.addClass('error');
                    } else {
                        field.addClass('field-error');
                    }
                } else {
                    if (container.length) {
                        container.removeClass('error');
                    }
                }
            });

            $('#' + formId + ' input[required], #' + formId + ' textarea[required]').each(function() {
                var field = $(this);
                var fieldValue = field.val() ? field.val().trim() : '';
                if (fieldValue === "") {
                    isValid = false;
                    missingFields.push(field.attr('id'));
                    field.addClass('field-error');
                } else {
                    field.removeClass('field-error');
                }
            });

            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill out all required fields.'
                });
            }
            return isValid;
        }

        function resetErrorStyles() {
            $('.form-control').css('border-color', '');
            $('.error-message').text('');
        }

        // Next Button Handler
        nextBtn.on('click', function() {
            if (validateForm('formStep1')) {
                if (isFirstSubmission) {
                    submitFormViaAjax('formStep1', 'insert', function(success) {
                        if(success) {
                            isFirstSubmission = false;
                            currentTab++;
                            updateUI();
                        } else {
                            alert("Failed to submit Step 1.");
                        }
                    });
                } else {
                    currentTab++;
                    updateUI();
                }
            }
        });

        // AJAX Form Submission
       function submitFormViaAjax(formId, action, callback) {

            var form = $('#' + formId)[0];
            var $salesTermSelect = $('#sales_term_id');
            var salesTermValue = $salesTermSelect.val(); 
            $salesTermSelect.prop('disabled', false);
            var formData = new FormData(form);
            formData.append('sales_term_id', salesTermValue);
            $salesTermSelect.prop('disabled', true);
            var tableItems = collectTableItems();
            formData.append('action', action);
            formData.append('table_items', JSON.stringify(tableItems));
            formData.append('sc_header_editId', $('#sc_header_editId').val());
            $.ajax({
                type: 'POST',
                url: '/xyz/update',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
        
                        $("#container_qty_1, #container_qty_2, #container_qty_3, #freight_cost_1, #freight_cost_2, #freight_cost_3, #total_freight_cost, #qtan_freight_cost")
                            .prop("readonly", true);

                        $("#sales_term_id").prop("disabled", true);

                        callback(true);
                    } else {
                        callback(false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong!',
                        text: error || 'An unknown error occurred.',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        callback(false);
                    });
                }
            });
        }

        // Save & Submit Button
        saveBtn.on('click', function() {
            submitFormViaAjax('formStep2', 'update', function(success) {
                if (success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Sales Contract Updated Successfully..!!',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong while updating the data.',
                    });
                }
            });
        });

        // Previous Button
        prevBtn.on('click', function() {
            if(currentTab > 0) {
                currentTab--;
                updateUI();
            }
        });

        // Tab Click Handler
        tabs.on('click', function() {
            currentTab = $(this).index();
            updateUI();
        });

        // Initialize UI
        updateUI();
    });
</script>
@endsection