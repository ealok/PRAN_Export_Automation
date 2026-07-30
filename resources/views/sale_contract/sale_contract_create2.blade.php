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
    .bootstrap-select > .dropdown-toggle.bs-placeholder{
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
    .req_style_id{
        color:red
    }
    .app-shell { 
      padding: 0 15px;
    }
    #sc_items_wrapper{
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
    table.dataTable thead th{
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
      padding: 3px 5px;;
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
    .form-control {
        border-radius: 8px;
        padding: 1px 4px !important;
        border: 1px solid #ced3d7;
        transition: all 0.3s ease;
        height: auto;
    }
    /* Form enhancements */
    .form-select {
      border-radius: 8px;
      padding:4px 10px;
      border: 1px solid var(--gray-300);
      transition: all 0.3s ease;
      height: auto;
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 0.25rem rgba(31, 122, 224, 0.15);
    }
    h5{
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
    .section-title{
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
    .bootstrap-select > select {
        position: absolute !important;
        bottom: 0;
        left: 50%;
        height: 100% !important;
        padding: 0 !important;
        opacity: 0 !important;
        border: none;
        display: none !important;
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
        margin-right: 10px; /* Optional: Adjust spacing between label and input */
    }
    .fa-circle-info::before, .fa-info-circle::before {
        content: "\f05a";
        color: #0a932c;
    }
    .btn-remove{
        padding: 0px 17px;
    }
    .form-control[readonly]{
        background-color: #fdfdfd !important;
        opacity: 1;
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
     
    .bootstrap-select .dropdown-toggle {
        width: 100% !important;
        min-width: 100% !important;
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
    .results-section{
        background-color: #eaeaea !important;
        padding: 0px !important;
        border-radius: 5px !important;
        margin-top: 21px;
    }
    h5{
        background: #4595C6;
        padding: 6px;
        color: white !important;
    }

    .form-control{
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
    
    .small-input {
        font-size: 10px !important;
        padding: 2px 4px;
    }
   
    #deleteButton {
        background-color: #dc3545;
        color: white;
        border: none;
        font-size: 11px;
        position: relative;
        font-weight: bold;
        margin-right: 15px;
    }

    #deleteButton::before {
        content: "\f2ed"; /* Unicode for the trash icon from FontAwesome */
        font-family: "Font Awesome 5 Free"; /* Font Awesome family */
        font-weight: 900; /* Required for icons */
        position: absolute;
        left: 5px;
        top: 50%;
        transform: translateY(-50%);
    }
    #sc_items_filter{
        margin-top: 12px;
    }

    label {
        display: inline-block;
        max-width: 100%;
        margin-top: 2px;
        font-size: 12px;
        font-weight: bolder;
        color: black;
    }
    
    /* NEW: Table responsive with vertical scroll */
    .table-responsive {
        max-height: 400px; /* Fixed height for vertical scroll */
        overflow-y: auto; /* Vertical scroll */
        overflow-x: auto; /* Horizontal scroll for small screens */
        border-radius: 5px;
        margin-top: 10px;
        position: relative;
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
        border-bottom: 1px solid #c6c6c6 !important;
    }
    
    /* Ensure inline form groups handle dropdowns properly */
    .inline-form-group .bootstrap-select {
        flex: 1;
        min-width: 0; /* Allow shrinking */
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
        
        .inline-form-group {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .inline-form-group label {
            margin-right: 0;
            margin-bottom: 5px;
        }
    }
    
    /* Custom scrollbar for table */
    .table-responsive::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
<body>
  <div class="app-shell">
    <div class="row">
      <!-- Content -->
      <div class="col-xs-12">
        <div class="content-card">
          <!-- Tab Progress Indicator -->
          <div class="tab-progress">
            <button class="progress-tab" id="tab-address" data-target="#pane-address">
              <i class="bi bi-house-door"></i>
              <span>Desk</span>
            </button>
            <button class="progress-tab" id="tab-education" data-target="#pane-education">
              <i class="bi bi-mortarboard"></i>
              <span>Commercial</span>
            </button>
          </div>
          <div class="tab-content" style="margin-top: -25px;">
            <div class="tab-pane fade" id="pane-address">
              <hr>
               <form id="formStep1">
                <div class="row">    
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="dated">Sales Contact NO<span class="req_style_id">*</span></label>
                            <input name="sales_contract_no" type="text" id="sales_contract_no" class="form-control input-sm"   value=""   required autofocus max="191"  placeholder="Sales contract no" >
                            @if ($errors->has('sales_contract_no'))
                                <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                            @endif
                        </div>
                    </div> 
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="dated">Sales Contract Date<span class="req_style_id">*</span></label>
                            <input name="dated" type="text" id="dated"class="form-control datepicker input-sm"  value=""   required autofocus placeholder="Select Date"  autocomplete="off"  is_date="1" >
                            @if ($errors->has('dated'))
                                <span class="help-block"><strong>{{ $errors->first('dated') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="invoice_no">Invoice NO<span class="req_style_id">*</span></label>
                            <input name="invoice_no" type="text" id="invoice_no" class="form-control input-sm"   value=""  autofocus max="191"  placeholder="Enter Invoice Number" required="">
                            <span id="mobile_number_error" style="color: red;position: absolute;margin-top: -55px;margin-left: 107px;"></span>
                            @if ($errors->has('invoice_no'))
                                <span class="help-block"><strong>{{ $errors->first('invoice_no') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="company_id">Company<span class="req_style_id">*</span></label>
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
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="notify_pary_id">Party Code<span class="req_style_id">*</span></label>
                            <select name="notify_pary_id" id="notify_pary_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                                <option value="">Select</option>
                                @foreach($notify_parties as $notify_party)
                                <option value="{{$notify_party->id}}" @if($notify_party->id==$id){{'selected'}}@endif>{{$notify_party->code}}</option>
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
                            <input name="party_name" type="text" id="party_name" class="form-control input-sm"  placeholder="Auto Field Notify Party Name" required value="{{$party_name}}">
                            @if ($errors->has('party_name'))
                                <span class="help-block"><strong>{{ $errors->first('party_name') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="party_address">Party Addr.<span class="req_style_id">*</span></label>
                            <textarea name="party_address" type="text" id="party_address" class="form-control input-sm"  placeholder="Auto Field Notify Party Address Here" style="width: 203px; height: 26px;" required>{{$party_address}}</textarea>
                            @if ($errors->has('party_address'))
                                <span class="help-block"><strong>{{ $errors->first('party_address') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="bank_id">Beneficiary Bank<span class="req_style_id">*</span></label>
                            <select name="bank_id" id="bank_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                                <option value="">Select Bank</option>
                            
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
                            <select name="importer_id" id="importer_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                                <option value="">Select</option>
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
                        <div class="inline-form-group">
                            <label for="importer_address">Importer Addr.<span class="req_style_id">*</span></label>
                            <textarea name="importer_address" type="text" id="importer_address" class="form-control input-sm" placeholder="Importer Address(Auto Field)" required style="width: 203px; height: 26px;" required></textarea>
                            @if ($errors->has('importer_address'))
                                <span class="help-block"><strong>{{ $errors->first('importer_address') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="bank_importer_id">Importer Bank<span class="req_style_id">*</span></label>
                            <select name="bank_importer_id" id="bank_importer_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                                <option value="">Select</option>
                                @foreach($bank_importers as $id => $bankName)
                                    <option value="{{ $id }}">{{ $bankName }}</option>
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
                            <textarea name="importer_country" type="text" id="importer_country" class="form-control input-sm" autofocus placeholder="Enter Importer Country Name Here" style="width: 203px; height: 26px;"></textarea>
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
                            <input name="final_destination" type="text" id="final_destination" class="form-control input-sm"   value=""   required autofocus max="191"  placeholder="Final destination" >
                            @if ($errors->has('final_destination'))
                                <span class="help-block"><strong>{{ $errors->first('final_destination') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="discharge_port">Discharge Port<span class="req_style_id">*</span></label>
                            <input name="discharge_port" type="text" id="discharge_port" class="form-control input-sm"   value=""  autofocus max="191"  placeholder="Discharge Port" >
                            @if ($errors->has('discharge_port'))
                                <span class="help-block"><strong>{{ $errors->first('discharge_port') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="loading_place_id">Loading Place <span class="req_style_id">*</span></label>
                            <select name="loading_place_id" id="loading_place_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                                <option value="">Select</option>
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
                        <div class="inline-form-group">
                            <label for="country_id">Exporter Country<span class="req_style_id">*</span></label>
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
                </div>   
                <div class="row">
                    <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="carrying_mode_id">Carrying Mode<span class="req_style_id">*</span></label>
                                <select name="carrying_mode_id" id="carrying_mode_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                                    <option value="">Select</option>
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
                        <div class="inline-form-group">
                            <label for="sales_term_id">Sales Terms<span class="req_style_id">*</span></label>
                            <select name="sales_term_id" id="sales_term_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                                <option value="">Select</option>
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
                        <textarea name="terms_and_condition" type="text" id="terms_and_condition" class="form-control input-sm" required autofocus   placeholder="" style="width: 225px; height: 26px;">
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

              </div>
              <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label>20ft Cont.</label>
                            <div class="input-group">
                                <input type="text" class="form-control  group-input-style" placeholder="Qty" id="container_qty_1" name="container_qty_1">
                                <input type="text" id="freight_cost_1"  name="freight_cost_1" class="form-control  group-input-style" placeholder="Amount">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label>40ft Cont.</label>
                            <div class="input-group">
                                <input type="text" class="form-control  group-input-style" placeholder="Qty" id="container_qty_2" name="container_qty_2">
                                <input type="text" id="freight_cost_2" name="freight_cost_2" class="form-control  group-input-style" placeholder="Amount">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label>40ft HC Cont.</label>
                            <div class="input-group">
                                <input type="text" class="form-control  group-input-style" placeholder="Qty" id="container_qty_3" name="container_qty_3">
                                <input type="text" name="freight_cost_3" id="freight_cost_3" class="form-control  group-input-style" placeholder="Amount">
                            </div>
                        </div>
                    </div>
                   <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="total_freight_cost">Total Freight Accts<span class="req_style_id">*</span></label>
                            <input type="number" name="total_freight_cost" id="total_freight_cost" class="form-control input-sm" value="0"  autofocus placeholder="Total Freight(Auto Cal..)" readonly>
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
                            <input name="qtan_freight_cost" type="number" id="qtan_freight_cost" class="form-control input-sm" value="0" placeholder="">
                            @if ($errors->has('qtan_freight_cost'))
                                <span class="help-block"><strong>{{ $errors->first('qtan_freight_cost') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="desk_freight_cost">Freight(Document)</label>
                            <input name="desk_freight_cost" type="number" id="desk_freight_cost" class="form-control input-sm" value="0" placeholder="">
                            @if ($errors->has('desk_freight_cost'))
                                <span class="help-block"><strong>{{ $errors->first('desk_freight_cost') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="">Advance Payment</label>
                            <input name="advance_payment" type="text"  class="form-control input-sm"   value="" placeholder="Enter Advance Payment">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="is_revised" >Is revised?</label><br>
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
                        <div class="inline-form-group">
                            <label for="is_proforma_invoice" >Is PI ?</label><br>
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
                        <div class="inline-form-group">
                            <label for="is_master" >Is Master ?</label><br>
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
                        <div class="inline-form-group">
                            <label for="footer_importer_address" >Footer addr.</label><br>
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
                </div>
                <div class="results-section" style="background-color: #fff; padding: 20px; border-radius: 5px; border: 1px solid #ddd;">
                    <h5 class="section-title">
                        <i class="fa fa-list me-2" style="padding: 5px">&nbsp;&nbsp;</i><span>Item Details</span>
                    </h5>
                    <p class="section-title" style="color: #3c8dbc; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #eaeaea;">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="inline-form-group">
                                    <label><i class="fa fa-info-circle me-2">&nbsp;</i>Upload From</label><br>
                                    <label class="radio-inline">
                                        <input type="radio" name="upload_from"  value="1" id="by_excel">Excel
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="upload_from"  value="3" id="add_item">Manual
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="upload_from"  value="2" id="by_order">Order
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-3 excel_div" style="display: none">
                                <div class="inline-form-group">
                                    <label for="formated_file">Upload Excel</label>
                                    <input  type='file' name="formated_file"  id="formated_file" class="form-control input-sm"  autofocus style="padding: 0px 5px;">
                                    @if ($errors->has('final_destination'))
                                        <span class="help-block"><strong>{{ $errors->first('final_destination') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-3 order_div" style="display: none">
                                <div class="inline-form-group">
                                    <label for="">Order Number</label>
                                    <select name="po_id" id="po_id" data-live-search="true" class="form-control select2 selectpicker input-sm" autofocus type="select"  value="1" >
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                      </p>      
                    <hr>
                    <div class="add_item" style="display: none">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="inline-form-group">
                                    <label for="ci_item_id">Code</label>
                                    <select name="ci_item_id" id="ci_item_id" data-live-search="true" class="form-control select2 selectpicker input-sm" autofocus type="select"  value="1" >
                                        <option value="">Select</option>
                                        @foreach($party_items as $party_item)
                                        <option value="{{$party_item->item_id}}">{{$party_item->ci_item_code}}/{{$party_item->ci_item_name}}</option>    
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ci_item_id'))
                                        <span class="help-block"><strong>{{ $errors->first('ci_item_id') }}</strong></span>
                                    @endif  
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="inline-form-group">
                                    <label for="desk_item_name">Party I.Name</label>
                                    <input name="desk_item_name" type="text" id="desk_item_name" class="form-control input-sm"   value=""  autofocus max="191"  placeholder="" >
                                    @if ($errors->has('desk_item_name'))
                                        <span class="help-block"><strong>{{ $errors->first('desk_item_name') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="inline-form-group">
                                    <label for="ctn">Ctn(Qty)</label>
                                    <input name="ctn" type="text" id="ctn" class="form-control input-sm"   value=""    autofocus max="191"  placeholder="" >
                                    @if ($errors->has('ctn'))
                                        <span class="help-block"><strong>{{ $errors->first('ctn') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="inline-form-group">
                                    <label for="rate_per_ctn_for_acc">R/CTN(Act)</label>
                                    <input name="rate_per_ctn_for_acc" type="text" id="rate_per_ctn_for_acc" class="form-control input-sm"   value=""    autofocus max="191"  placeholder="" readonly>
                                    @if ($errors->has('rate_per_ctn_for_acc'))
                                        <span class="help-block"><strong>{{ $errors->first('rate_per_ctn_for_acc') }}</strong></span>
                                    @endif
                                </div>
                            </div> 
                            <div class="col-sm-2">
                                <div class="inline-form-group">
                                    <label for="rate_per_ctn_for_party">R/CTN(Party)</label>
                                    <input name="rate_per_ctn_for_party" type="text" id="rate_per_ctn_for_party" class="form-control input-sm"   value=""    autofocus max="191"  placeholder="" readonly>
                                    @if ($errors->has('rate_per_ctn_for_party'))
                                        <span class="help-block"><strong>{{ $errors->first('rate_per_ctn_for_party') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="inline-form-group">
                                    <label for="cbm_per_ctn">CBM/CTN</label>
                                    <input name="cbm_per_ctn" type="text" id="cbm_per_ctn" class="form-control input-sm"   value=""    autofocus max="191"  placeholder="" readonly>
                                    @if ($errors->has('cbm_per_ctn'))
                                        <span class="help-block"><strong>{{ $errors->first('cbm_per_ctn') }}</strong></span>
                                    @endif
                                </div>
                            </div>   
                        </div> 
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="inline-form-group">
                                    <label for="gross_weight">Gross Weight/CTN</label>
                                    <input name="gross_weight" type="text" id="gross_weight" class="form-control input-sm"   value=""    autofocus max="191"  placeholder="">
                                    @if ($errors->has('gross_weight'))
                                        <span class="help-block"><strong>{{ $errors->first('gross_weight') }}</strong></span>
                                    @endif
                                </div>
                            </div> 
                            <div class="col-sm-2">
                                <div class="inline-form-group">
                                    <label for="hs_code">HS Code</label>
                                    <input name="hs_code" type="text" id="hs_code" class="form-control input-sm"   value=""    autofocus max="191"  placeholder="" >
                                    @if ($errors->has('hs_code'))
                                        <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="inline-form-group">
                                    <label for="hs_code_2">HS Code2</label>
                                    <input name="hs_code_2" type="text" id="hs_code_2" class="form-control input-sm"   value=""    autofocus max="191"  placeholder="" >
                                    @if ($errors->has('hs_code_2'))
                                        <span class="help-block"><strong>{{ $errors->first('hs_code_2') }}</strong></span>
                                    @endif
                                </div>
                            </div> 
                            <div class="col-sm-2">
                                <div class="inline-form-group">
                                    <label for="total_amount_acc">TA (Acc)</label>
                                    <input name="total_amount_acc" type="text" id="total_amount_acc" class="form-control input-sm"   value=""    autofocus max="191"  placeholder="" readonly>
                                    @if ($errors->has('total_amount_acc'))
                                        <span class="help-block"><strong>{{ $errors->first('total_amount_acc') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="inline-form-group">
                                    <label for="total_amount_party">TA (Party)</label>
                                    <input name="total_amount_party" type="text" id="total_amount_party" class="form-control input-sm"   value=""    autofocus max="191"  placeholder="" readonly>
                                    @if ($errors->has('total_amount_party'))
                                        <span class="help-block"><strong>{{ $errors->first('total_amount_party') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="inline-form-group">
                                    <label for="sample_qty">Smpl</label>
                                    <input name="sample_qty" type="text" id="esample_qty" class="form-control input-sm"   value=""   autofocus max="191"  placeholder="" style="width:58px">
                                    @if ($errors->has('sample_qty'))
                                        <span class="help-block"><strong>{{ $errors->first('sample_qty') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="inline-form-group">
                                    <button type="button" class="btn btn-primary btn-sm pull-right" id="addItemBtn"><i class="fa fa-plus"></i>&nbsp;Add</button>
                                </div>
                            </div>     
                        </div>
                    </div>
                    <div style="position: relative">
                      <button type="button" class="btn btn-danger btn-sm pull-right" id="deleteButton" style="position: absolute;z-index: 1;"><i class="fas fa-trash-alt"></i>&nbsp;Delete Items</button>
                    </div>                       
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="sc_items">
                            <thead>
                                 <tr> 
                                    <th><input type="checkbox" id="check_all"><span style="position: absolute"></span></th>
                                    <th>Code</th>
                                    <th style="width: 116px">Desk Name</th>
                                    <th>Ctn(Qty)</th>
                                    <th>R/CTN(Act)</th>
                                    <th>R/CTN(Party)</th>
                                    <th>CBM/CTN</th>
                                    <th>T.CBM</th>
                                    <th>GW(Total)</th>
                                    <th>HS Code</th>
                                    <th>HS Code2</th>
                                    <th>TA Amt(Party)</th>
                                    <th>TA Amt(Acc)</th>
                                    <th>Smpl(Qty)</th>
                                </tr> 
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <input type="hidden" id="selectedparty" value="{{$xxxx_party_id}}">
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
                                <input name="invoice_date" type="text" id="invoice_date"class="form-control datepicker input-sm"  value=""  autofocus placeholder="invoice_date"  autocomplete="off"  is_date="1" >
                                @if ($errors->has('invoice_date'))
                                    <span class="help-block"><strong>{{ $errors->first('invoice_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="export_no">Exp No</label>
                                <input name="export_no" type="text" id="export_no" class="form-control input-sm" value="" placeholder="Export Exp No" >
                                @if ($errors->has('export_no'))
                                    <span class="help-block"><strong>{{ $errors->first('export_no') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="export_date">Exp Date</label>
                                <input name="export_date" type="text" id="export_date"class="form-control datepicker input-sm"  value=""  placeholder="Select Exp Date">
                                @if ($errors->has('export_date'))
                                    <span class="help-block"><strong>{{ $errors->first('export_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="ci_note">CI Note</label>
                                <textarea name="ci_note" type="text" id="ci_note" class="form-control input-sm" placeholder="Enter CI Note" style="width: 203px; height: 26px;"></textarea>
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
                                <input name="insurance_charge" type="text" id="insurance_charge" class="form-control input-sm"   value=""   max="191"  placeholder="Enter Insurance Charge">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="phyto_product_name">Pallet Change</label>
                                <input name="pallet_charge" type="text" id="pallet_charge" class="form-control input-sm"   value=""   max="191"  placeholder="Enter Pallet Charge">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="freight_cost">Freight_Cost(For CI)</label>
                                <input name="freight_cost" type="text" id="freight_cost" class="form-control input-sm"   value=""   autofocus max="191"  placeholder="Enter Freight Cost" >
                                @if ($errors->has('freight_cost'))
                                    <span class="help-block"><strong>{{ $errors->first('freight_cost') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="container">Container(For CI)</label>
                                <input name="container" type="text" id="container" class="form-control input-sm"   value=""   autofocus max="191"  placeholder="Enter Container Number" >
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
                                <input name="bl_no" type="text" id="bl_no" class="form-control input-sm"   value=""   max="191"  placeholder="Enter BL No">
                                @if ($errors->has('bl_no'))
                                    <span class="help-block"><strong>{{ $errors->first('bl_no') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="bl_date">BL Date(For CO)</label>
                                <input name="bl_date" type="text" id="bl_date" class="form-control datepicker input-sm"  value=""   autofocus placeholder="Bl date for CO"  autocomplete="off"  is_date="1" >
                                @if ($errors->has('bl_date'))
                                    <span class="help-block"><strong>{{ $errors->first('bl_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="is_proforma_invoice" >Vessel/VOY Name(For CO)</label><br>
                                <input name="vehicle" type="text" id="" class="form-control input-sm"   value=""  placeholder="vehicle Name" >
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="is_proforma_invoice" >Product Name(For CO)</label><br>
                                <input name="revise_product_name" type="text" id="" class="form-control input-sm"   value=""  placeholder="Product Name For CO">
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="ci_note">Note If Any(Shipping Mark)</label>
                                <input name="ci_note" type="text" id="ci_note" class="form-control input-sm"   value=""   max="191"  placeholder="ci_note" >
                                @if ($errors->has('ci_note'))
                                    <span class="help-block"><strong>{{ $errors->first('ci_note') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="bl_date_cer">BL Date(For CER)</label>
                                <input name="bl_date_cer" type="text" id="bl_date_cer" class="form-control datepicker input-sm"  value=""   autofocus placeholder="Bl date for cer"  autocomplete="off"  is_date="1" >
                                @if ($errors->has('bl_date_cer'))
                                    <span class="help-block"><strong>{{$errors->first('bl_date_cer')}}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="mv_or_voy">M.V. /VOY: </label>
                                <input name="mv_or_voy" type="text" id="mv_or_voy" class="form-control input-sm"  placeholder="Enter Your MV/VOY Name" value="">
                                @if ($errors->has('mv_or_voy'))
                                    <span class="help-block"><strong>{{ $errors->first('mv_or_voy') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="container_number">Container Number: </label>
                                <input name="container_number" type="text" id="container_number" class="form-control input-sm"  placeholder="Enter Container Number" value="">
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
                                <input name="tr_report_date" type="text" id="tr_report_date" class="form-control datepicker input-sm"  value=""   autofocus placeholder="Select Tr Report Date">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="phyto_product_name">Foreign Port(For Land)</label>
                                <input name="foreign_port" type="text" id="foreign_port" class="form-control input-sm"   value=""   max="191"  placeholder="Foreign Port (For Land)">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="terms_and_condition_desk_inv">T&C(For Com)</label>
                                <textarea name="terms_and_condition_desk_inv" type="text" id="terms_and_condition_desk_inv" class="form-control input-sm" placeholder="Enter T&C For Com" style="width: 203px;height: 26px;"></textarea>
                                @if ($errors->has('terms_and_condition_desk_inv'))
                                    <span class="help-block"><strong>{{ $errors->first('terms_and_condition_desk_inv') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="angikar_given_by">Angikar  Given By</label>
                                <textarea name="angikar_given_by" type="text" id="angikar_given_by" class="form-control input-sm" placeholder="Enter Angikar Given By" style="width: 203px; height: 26px"></textarea>
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
                                <textarea name="phyto_product_name" type="text" id="phyto_product_name" class="form-control input-sm" placeholder="Enter Phyto Product Name" style="width: 203px; height: 26px;"></textarea>
                                @if ($errors->has('phyto_product_name'))
                                    <span class="help-block"><strong>{{ $errors->first('phyto_product_name') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="phyto_product_name">Also Notify Party</label>
                                <textarea class="form-control input-sm" name="third_notify_party" placeholder="Enter Also Notify Party" style="width: 203px; height: 26px;"></textarea>
                                @if ($errors->has('phyto_product_name'))
                                    <span class="help-block"><strong>{{ $errors->first('phyto_product_name') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="phyto_product_name">Bank Addr.(India)</label>
                                <textarea class="form-control input-sm" name="bank_address_for_india" placeholder="Enter Bank Address" style="width: 203px; height: 26px;"></textarea>
                                @if ($errors->has('phyto_product_name'))
                                    <span class="help-block"><strong>{{ $errors->first('phyto_product_name') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="phyto_product_name">Customs Decl.(For India)</label>
                                <textarea class="form-control" name="custom_declaration" placeholder="Enter Custom Declaration" style="width: 203px; height: 26px;"></textarea>
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
                                <select name="factory_address_type_id" id="factory_address_type_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                                    <option value="1">Select</option>
                                </select>  
                            </div>
                        </div> 
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="phyto_product_name">BD Port(For Land)</label>
                                <input name="bd_port" type="text" id="bd_port" class="form-control  input-sm"   value=""   max="191"  placeholder="Enter DB Port">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">LC Terms(Only For India)</label>
                                <input name="lc_term_for_india" type="text"  class="form-control input-sm" value="" placeholder="Enter LC Terms(Only India)">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                            <label for="">Freight Charge(For India)</label>
                            <input name="freight_charge_india" type="text"  class="form-control input-sm"   value="" placeholder="Enter Freight Charge(Only India)">
                            </div>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">Lot Number(For India)</label>
                                <input name="lot_number" type="text"  class="form-control input-sm"   value="" placeholder="Enter lot Number(Only India)">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                            <label for="">Best Before(For India)</label>
                            <input name="best_before_india" type="text"  class="form-control input-sm"   value="" placeholder="Enter Best Before(Only India)">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                            <label for="">GSP Ref. No.</label>
                            <input name="gsp_ref_number" type="text"  class="form-control input-sm"   value="" placeholder="Enter GSP Ref no"> 
                            </div>    
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">Shipping Mark(For India)</label>
                                <input name="shipping_mark_india" type="text"  class="form-control input-sm"   value="" placeholder="Enter Shipping Mark(Only India)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="dated">Safta Date(For India)</label>
                                <input name="safta_dated" type="text" id="dated"class="form-control datepicker input-sm"  value=""  placeholder="Select Date"  autocomplete="off"  is_date="1" >
                                @if ($errors->has('dated'))
                                    <span class="help-block"><strong>{{ $errors->first('dated') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="dated">Freight Date(For India)</label>
                                <input name="freight_date" type="text" id="dated" class="form-control datepicker input-sm"  value=""  placeholder="Select Date"  autocomplete="off"  is_date="1" >
                                @if ($errors->has('dated'))
                                    <span class="help-block"><strong>{{ $errors->first('dated') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="arv_amount">Arv Amount(For India)</label>
                                <input name="arv_amount" type="text" class="form-control input-sm"  value=""  placeholder="Arv_amount"  autocomplete="off">
                                @if ($errors->has('arv_amount'))
                                    <span class="help-block"><strong>{{ $errors->first('arv_amount') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="arv_amount_received_date">ARV Amt Receipt Dt(For India)</label>
                                <input name="arv_amount_received_date" type="text" class="form-control datepicker input-sm"  value=""  placeholder="Select Date"  autocomplete="off"  is_date="1" >
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
                                <input name="dcc_memo_no" type="text" class="form-control input-sm"  value=""  placeholder="Enter Dcc Memo No"  autocomplete="off"  is_date="1">
                                @if ($errors->has('dcc_memo_no'))
                                    <span class="help-block"><strong>{{ $errors->first('dcc_memo_no') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">Mfg Date(For India)</label>
                                <input name="india_mfg_setup_date" type="text" class="form-control input-sm"  value=""  placeholder="Mfg Date"  autocomplete="off"  is_date="1">
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
                                <option value="{{$transportAgency->id}}">{{$transportAgency->transport_agency_info}}</option>
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
                                    <option value="{{$customStation->id}}">{{$customStation->agent_name}}</option>
                                    @endforeach
                                </select>  
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">App for CNF (Print Dt)</label>
                                <input name="cnf_print_date" type="text" class="form-control input-sm datepicker"  value=""  placeholder="App for cnf print date"  autocomplete="off"  is_date="1">
                                @if ($errors->has('cnf_print_date'))
                                    <span class="help-block"><strong>{{ $errors->first('cnf_print_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="shipping_line_id">Freight Forwarder</label>
                                <select name="shipping_line_id" id="shipping_line_id" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1">
                                    <option value="">Select</option>
                                    @foreach($shippingLines as $shippingLine)
                                    <option value="{{$shippingLine->id}}">{{$shippingLine->shipping_name}} / {{$shippingLine->license_number}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('shipping_line_id'))
                                    <span class="help-block"><strong>{{ $errors->first('shipping_line_id') }}</strong></span>
                                @endif  
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="shipping_line_id">Freight Forwarder Name</label>
                                <select name="shipping_line_id" id="shipping_line_id" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1">
                                    <option value="">Select</option>
                                    @foreach($shippingLines as $shippingLine)
                                    <option value="{{$shippingLine->id}}">{{$shippingLine->shipping_name}} / {{$shippingLine->license_number}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('shipping_line_id'))
                                    <span class="help-block"><strong>{{ $errors->first('shipping_line_id') }}</strong></span>
                                @endif  
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="name_of_shipping_line_id">Name Of Shipping Line</label>
                                <select name="name_of_shipping_line_id" id="name_of_shipping_line_id" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1">
                                    <option value="">Select</option>
                                    @foreach($shippingLines as $shippingLine)
                                    <option value="{{$shippingLine->id}}">{{$shippingLine->shipping_name}} / {{$shippingLine->license_number}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('name_of_shipping_line_id'))
                                    <span class="help-block"><strong>{{ $errors->first('name_of_shipping_line_id') }}</strong></span>
                                @endif  
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">Freight Amount(FC)</label>
                                <input name="freight_amount_fc" type="text" class="form-control input-sm"  value=""  placeholder="Enter Freight Amount (FC)">
                                @if ($errors->has('freight_amount_fc'))
                                    <span class="help-block"><strong>{{ $errors->first('freight_amount_fc') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">Freight Amount (BDT)</label>
                                <input name="freight_amount_btd" type="text" class="form-control input-sm"  value=""  placeholder="Enter 0000000
                                0A0*1mount (BDT)">
                                @if($errors->has('freight_amount_btd'))
                                    <span class="help-block"><strong>{{ $errors->first('freight_amount_btd') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="master_airway_bill_no">House Airway Bill No</label>
                                <input name="master_airway_bill_no" type="text" class="form-control input-sm"  value=""  placeholder="Enter House Airway Bill No">
                                @if ($errors->has('master_airway_bill_no'))
                                    <span class="help-block"><strong>{{ $errors->first('master_airway_bill_no') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="">House Airway Bill Date</label>
                                <input name="master_airway_bill_date" type="text" class="form-control input-sm datepicker"  value=""  placeholder="Enter House Airway Bill Date">
                                @if ($errors->has('master_airway_bill_date'))
                                    <span class="help-block"><strong>{{ $errors->first('master_airway_bill_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="oc_date">OC Date:</label>
                                <input name="oc_date" type="text" id="oc_date" class="form-control input-sm datepicker"  placeholder="Select OC Date" value="">
                                @if ($errors->has('oc_date'))
                                    <span class="help-block"><strong>{{ $errors->first('oc_date') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="salary_adjustment">Salary Adjustment:</label>
                                <input name="salary_adjustment" type="text" id="salary_adjustment" class="form-control input-sm"  placeholder="Enter Your Salary Adjustment" value="">
                                @if ($errors->has('salary_adjustment'))
                                    <span class="help-block"><strong>{{ $errors->first('salary_adjustment') }}</strong></span>
                                @endif
                            </div>  
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="is_notify_also_notity" >Notify/Also Notify</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_notify_also_notity"   value="1"   id="is_notify_also_notity" >Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_notify_also_notity" id="is_notify_also_notity" value="0" checked>No
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="tr_no_is_exist" >TR No.(Land Only)</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="tr_no_is_exist"   value="1"   id="tr_no_is_exist" >Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="tr_no_is_exist" id="tr_no_is_exist" value="0" checked>No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="address_replace" >Address Replace</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="address_replace"   value="1"   id="address_replace" >Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="address_replace"   value="0"   id="address_replace" checked>No
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="is_total_amount_oceania">T.A. Visible(Oceania)</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_total_amount_oceania"   value="1"   id="is_total_amount_oceania"  autofocus  >Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_total_amount_oceania"  value="0" checked>No
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
                                    <input type="radio" name="add_also_notify_party"   value="1"   id="add_also_notify_party">Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="add_also_notify_party" id="add_also_notify_party" value="0" checked>No
                                </label>
                            </div>
                        </div> 
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="mfg_date_india" >Is Hs Code2</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_hscode2" id="is_hscode2" value="1">Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_hscode2" id="is_hscode2" value="0" checked>No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="inline-form-group">
                                <label for="mfg_date_india" >Is FOB ?</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_fob" id="is_fob" value="1">Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_fob" id="is_fob" value="0" checked>No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="insert_sc_id" id="insert_sc_id">  
             </form>   
            </div>
          </div>
          <!-- Actions -->
          <div class="sticky-actions clearfix">
            <div class="pull-left">
              <button class="btn btn-btnPrev" id="btnPrev"><i class="bi bi-arrow-left"></i> Previous</button>
            </div>
            <div class="pull-right">
              <button class="btn btn-primary btn-flat" id="btnNext">Save And Next<i class="bi bi-arrow-right"></i></button>
              <button class="btn btn-success btn-flat" id="btnSave" style="display: none;"><i class="bi bi-check2-circle"></i> Save & Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>document.title = 'Sales Contract | Create';</script>
  <script>
document.title = 'Sales Contract | Create';

setTimeout(function() { 
    $('.sr-only').click();
}, 0.0001);

$(document).ready(function() {

    // ============================================
    // 1. DATE PICKER INITIALIZATION
    // ============================================
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

    // ============================================
    // 2. DELETE TEMP ITEMS ON PAGE LOAD
    // ============================================
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

    // ============================================
    // 3. SETUP EVENT LISTENERS
    // ============================================
    setupInputChangeListeners();
    setupItemNameChangeListeners();

    // ============================================
    // 4. NOTIFY PARTY CHANGE EVENT
    // ============================================
    $('#notify_pary_id').on('change', function() {
        var notify_pary_id = $(this).val();
        var url = "{{url('/')}}"+"/json/get_buyer/po_list?party_id="+notify_pary_id;
        var $el = $('#po_id');
        $.get(url, function(data) {
            if (!data) {
                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("---"));
                $el.selectpicker('destroy');
            } else {
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function(key, value) {
                    $el.append($("<option></option>").attr("value", value['ID']).text(value['PO_NO']));
                });
                $el.selectpicker('refresh');
            }
        });
    });

    // ============================================
    // 5. RADIO BUTTON CONTROL
    // ============================================
    $('input[name="upload_from"]').on('change', function() {
        if ($("#by_excel").is(":checked")) {
            $(".excel_div").show();
            $(".order_div, .add_item").hide();
        } else if ($("#by_order").is(":checked")) {
            $(".order_div").show();
            $(".excel_div, .add_item").hide();
        } else if ($("#add_item").is(":checked")) {
            $(".add_item").show();
            $(".excel_div, .order_div").hide();
        }
    });

    // ============================================
    // 6. FETCH PARTY PO LIST
    // ============================================
    var party_id = $("#selectedparty").val();
    fetchPartyPos(party_id);

    function fetchPartyPos(party_id) {
        var url = "{{url('/')}}"+"/json/get_buyer/po_list?party_id="+party_id;
        var $el = $('#po_id');
        $.get(url, function(data) {
            if (!data) {
                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("---"));
                $el.selectpicker('destroy');
            } else {
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function(key, value) {
                    $el.append($("<option></option>").attr("value", value['ID']).text(value['PO_NO']));
                });
                $el.selectpicker('refresh');
            }
        });
    }

    // ============================================
    // 7. PO CHANGE EVENT
    // ============================================
    $('#po_id').on('change', function() {
        var po_id = $(this).val();
        if (!po_id) {
            $('#sc_items tbody').empty();
            $('#sc_items tbody').append('<tr><td colspan="15" class="text-center">Please select a PO</td></tr>');
            calculateAndDisplayTotals();
            return;
        }
        
        $.ajax({
            url: '/json/get/po_items',
            type: 'GET',
            data: {'po_id': po_id},
            success: function(res) {
                ploatPOItems(res.data);
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred. Please try again.'
                });
            }
        });
    });

    // ============================================
    // 8. INVOICE NUMBER VALIDATION
    // ============================================
    $('#invoice_no').on('keyup input', function() {
        var invoiceNumber = $(this).val().replace(/\s/g, '');
        $(this).val(invoiceNumber);
        
        if (invoiceNumber.trim() === '' || invoiceNumber.length < 6) {
            $('#invoice_no_error').text('');
            $(this).css('border-color', '');
            $('#btnNext').prop("disabled", false);
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

    // ============================================
    // 9. FREIGHT COST CALCULATION
    // ============================================
    $('#freight_cost_1, #freight_cost_2, #freight_cost_3').on('keyup input', function() {
        var freightCost1 = parseFloat($('#freight_cost_1').val()) || 0;
        var freightCost2 = parseFloat($('#freight_cost_2').val()) || 0;
        var freightCost3 = parseFloat($('#freight_cost_3').val()) || 0;
        var totalFreightCost = freightCost1 + freightCost2 + freightCost3;
        $('#total_freight_cost').val(totalFreightCost.toFixed(3));
    });

    // ============================================
    // 10. EXCEL FILE UPLOAD
    // ============================================
    $('#formated_file').change(function() {
        var files = document.getElementById('formated_file').files;
        var party_id = $('#notify_pary_id').val();
        
        if (!party_id) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please select party first.',
            });
            return;
        }
        
        if (files.length == 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please choose a file.',
            });
            return;
        }
        
        var filename = files[0].name;
        var extension = filename.substring(filename.lastIndexOf(".")).toUpperCase();
        
        if (extension == '.XLSX' || extension == '.XLS') {
            var formData = new FormData();
            var fileInput = document.getElementById('formated_file');
            formData.append('file', fileInput.files[0]);
            formData.append('party_id', party_id);
            
            $.ajax({
                url: '/json/save/temp_table/sc_items',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    ploatSalesContractItems(res.data);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
            $('#nextButton').prop("disabled", false);
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Only .XLSX & .XLS files are allowed.',
            });
            $('#formated_file').val("");
            $('#nextButton').prop("disabled", true);
        }
    });

    // ============================================
    // 11. ADD ITEM BUTTON
    // ============================================
    $('#addItemBtn').on('click', function() {
        var formData = {
            ci_item_id: $('#ci_item_id').val(),
            desk_item_name: $('#desk_item_name').val(),
            ctn: $('#ctn').val(),
            rate_per_ctn_for_acc: $('#rate_per_ctn_for_acc').val(),
            rate_per_ctn_for_party: $('#rate_per_ctn_for_party').val(),
            cbm_per_ctn: $('#cbm_per_ctn').val(),
            gross_weight: $('#gross_weight').val(),
            hs_code: $('#hs_code').val(),
            hs_code_2: $('#hs_code_2').val(),
            total_amount_acc: $('#total_amount_acc').val(),
            total_amount_party: $('#total_amount_party').val(),
            sample_qty: $('#esample_qty').val()
        };

        var errors = addItemvalidate(formData);
        if (errors.length > 0) {
            showSweetAlert(errors);
            return;
        }

        $.ajax({
            url: '/add/sc/temp_item',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if (res.code === 200) {
                    ploatSalesContractItems(res.data);
                    clearInput();
                } else if (res.code === 409) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Item Already Exists',
                        text: res.message || 'This item is already added to the table.',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.message || 'An error occurred while adding the item.',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred. Please try again.'
                });
            }
        });
    });

    // ============================================
    // 12. CLEAR INPUT FIELDS
    // ============================================
    function clearInput() {
        $('#ci_item_id').val('').selectpicker('refresh');
        $('#desk_item_name').val("");
        $('#ctn').val("");
        $('#rate_per_ctn_for_acc').val("");
        $('#rate_per_ctn_for_party').val("");
        $('#cbm_per_ctn').val("");
        $('#gross_weight').val("");
        $('#hs_code').val("");
        $('#hs_code_2').val("");
        $('#total_amount_acc').val("");
        $('#total_amount_party').val("");
        $('#esample_qty').val("0");
    }

    // ============================================
    // 13. FORM VALIDATION
    // ============================================
    function addItemvalidate(data) {
        var errors = [];
        if (!data.ci_item_id) {
            errors.push('Item Code is required.');
        }
        if (!data.ctn) {
            errors.push('Ctn(Qty) is required.');
        }
        return errors;
    }

    function showSweetAlert(errors) {
        var errorMessages = '<ul>';
        errors.forEach(function(error) {
            errorMessages += '<li>' + error + '</li>';
        });
        errorMessages += '</ul>';
        Swal.fire({
            title: 'Validation Errors',
            html: errorMessages,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }

    // ============================================
    // 14. CHECK ALL FUNCTIONALITY
    // ============================================
    $('#check_all').change(function() {
        if ($(this).prop('checked')) {
            $('.sub_chk').prop('checked', true);
        } else {
            $('.sub_chk').prop('checked', false);
        }
    });

    // ============================================
    // 15. DELETE SELECTED ITEMS
    // ============================================
    $('#deleteButton').click(function() {
        var selectedItems = [];
        $('.sub_chk:checked').each(function() {
            selectedItems.push($(this).data('id'));
        });

        if (selectedItems.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please select at least one item to delete!',
            });
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover these items!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var hasUndefinedIds = selectedItems.some(function(itemId) {
                    return itemId === undefined;
                });

                if (hasUndefinedIds) {
                    $('.sub_chk:checked').closest('tr').remove();
                    calculateAndDisplayTotals();
                    Swal.fire('Deleted!', 'The selected items have been deleted.', 'success');
                } else {
                    $.ajax({
                        url: '/delete/sc_temp/item',
                        type: 'POST',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "item_ids": selectedItems
                        },
                        success: function(res) {
                            if (res.code == 200) {
                                $('.sub_chk:checked').closest('tr').remove();
                                calculateAndDisplayTotals();
                                Swal.fire('Deleted!', 'The selected items have been deleted.', 'success');
                            } else {
                                Swal.fire('Error!', 'Something went wrong. Please try again later.', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'Something went wrong with the request.', 'error');
                        }
                    });
                }
            }
        });
    });

    // ============================================
    // 16. COMPANY CHANGE EVENT
    // ============================================
    $("#company_id").change(function() {
        var company_id = $(this).val();
        var url = "{{url('/')}}"+"/json/get_company_bank?company_id="+company_id;
        var $el = $('#bank_id');
        $.get(url, function(data) {
            if (!data) {
                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("---"));
                $el.selectpicker('destroy');
            } else {
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function(key, value) {
                    $el.append($("<option></option>").attr("value", value['id']).text(value['name']));
                });
                $el.selectpicker('refresh');
            }
        });
    });

    // ============================================
    // 17. NOTIFY PARTY DETAILS
    // ============================================
    $('#notify_pary_id').on('change', function() {
        var party_id = $(this).val();
        var url = "{{url('/')}}"+"/json/get/party_items/ship_details?party_id="+party_id;
        var $el = $('#ci_item_id');
        $.get(url, function(res) {
            if (!res.data) {
                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("---"));
                $el.selectpicker('destroy');
            } else {
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(res.data, function(key, value) {
                    $el.append($("<option></option>").attr("value", value.item_id).text(value.ci_item_code + '/ ' + value.ci_item_name));
                });
                $el.selectpicker('refresh');
            }
            $('#party_name').val(res.partyName);
            $('#party_address').val(res.partyAddress);
        });
    });

    // ============================================
    // 18. IMPORTER DETAILS
    // ============================================
    $('#importer_id').on('change', function() {
        var imp_id = $(this).val();
        var url = "{{url('/')}}"+"/json/get/imp/ship_details?imp_id="+imp_id;
        $.get(url, function(res) {
            $('#importer_address').val(res.impAddress);
        });
    });

    // ============================================
    // 19. ITEM RATE CALCULATION
    // ============================================
    $("#ci_item_id").change(function() {
        var ci_item_id = $("#ci_item_id").val();
        var notify_pary_id = $('#notify_pary_id').val();
        var ctn = $('#ctn').val() || 0;
        var url = "{{url('/')}}"+"/json/get_item_reate_for_notify_party?ci_item_id="+ci_item_id+"&notify_party_id="+notify_pary_id;
        $.get(url, function(data) {
            if (!data) {
                alert("no rate defined");
                $('#total_amount_acc').val(0);
                $('#total_amount_party').val(0);
            } else {
                $('#rate_per_ctn_for_acc').val(data['acc_rate']);
                $('#rate_per_ctn_for_party').val(data['party_rate']);
                $('#cbm_per_ctn').val(data['cbm_per_ctn']);
                $('#desk_item_name').val(data['desk_item_name']);
                $('#hs_code').val(data['hs_code']);
                $('#total_amount_acc').val((ctn * data['acc_rate']).toFixed(3));
                $('#total_amount_party').val((ctn * data['party_rate']).toFixed(3));
                $('#gross_weight').val(data['gross_weight']);
            }
        });
    });

    // ============================================
    // 20. CALCULATE TOTAL AMOUNTS
    // ============================================
    $("#ctn, #rate_per_ctn_for_acc, #rate_per_ctn_for_party").keyup(function() {
        var ctn = parseFloat($('#ctn').val());
        var rate_per_ctn_for_acc = parseFloat($('#rate_per_ctn_for_acc').val());
        var rate_per_ctn_for_party = parseFloat($('#rate_per_ctn_for_party').val());

        if (isNaN(ctn) || isNaN(rate_per_ctn_for_acc) || isNaN(rate_per_ctn_for_party)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Input',
                text: 'Please enter valid numbers for Ctn and Rate per Ctn fields.',
                confirmButtonText: 'OK'
            });
            return;
        }

        var totalAmountAcc = ctn * rate_per_ctn_for_acc;
        var totalAmountParty = ctn * rate_per_ctn_for_party;
        $('#total_amount_acc').val(totalAmountAcc.toFixed(3));
        $('#total_amount_party').val(totalAmountParty.toFixed(3));
    });

    // ============================================
    // 21. TOTALS FUNCTIONALITY
    // ============================================
    function calculateAndDisplayTotals() {
        var totalCtn = 0;
        var totalAccValue = 0;
        var totalPartyValue = 0;
        var totalCbm = 0;
        var totalGrossWeight = 0;
        var totalSample = 0;

        $('#sc_items tbody tr:not(.totals-row)').each(function() {
            if ($(this).text().includes('No data available') || $(this).text().includes('Please select a PO')) {
                return true;
            }

            var $row = $(this);
            var ctn = parseFloat($row.find('td:eq(3) input').val()) || parseFloat($row.find('td:eq(3)').text()) || 0;
            var accValue = parseFloat($row.find('td:eq(12) input').val()) || parseFloat($row.find('td:eq(12)').text()) || 0;
            var partyValue = parseFloat($row.find('td:eq(11) input').val()) || parseFloat($row.find('td:eq(11)').text()) || 0;
            var cbm = parseFloat($row.find('td:eq(7) input').val()) || parseFloat($row.find('td:eq(7)').text()) || 0;
            var grossWeight = parseFloat($row.find('td:eq(8) input').val()) || parseFloat($row.find('td:eq(8)').text()) || 0;
            var sampleQty = parseFloat($row.find('td:eq(13) input').val()) || parseFloat($row.find('td:eq(13)').text()) || 0;

            totalCtn += ctn;
            totalAccValue += accValue;
            totalPartyValue += partyValue;
            totalCbm += cbm;
            totalGrossWeight += grossWeight;
            totalSample += sampleQty;
        });

        $('#sc_items tbody .totals-row').remove();

        if ($('#sc_items tbody tr:not(.totals-row)').length > 0) {
            var totalsRow = `
                <tr class="totals-row" style="background-color: #4595C6; font-weight: bold; color: white;">
                    <td colspan="3" style="text-align: center; color: #FFFFFF;">GRAND TOTALS :</td>
                    <td>${totalCtn.toFixed(2)}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>${totalCbm.toFixed(2)}</td>
                    <td>${totalGrossWeight.toFixed(3)}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>${totalPartyValue.toFixed(3)}</td>
                    <td>${totalAccValue.toFixed(3)}</td>
                    <td>${totalSample}</td>
                </tr>
            `;
            $('#sc_items tbody').append(totalsRow);
        }
    }

    function setupInputChangeListeners() {
        $('#sc_items').on('input', '.total_ctn, .acc_rate_per_ctn, .party_rate_per_ctn, .cbm_per_ctn, .gross_weight', function() {
            var $row = $(this).closest('tr');
            var totalCtn = parseFloat($row.find('.total_ctn').val()) || 0;
            var accRate = parseFloat($row.find('.acc_rate_per_ctn').val()) || 0;
            var partyRate = parseFloat($row.find('.party_rate_per_ctn').val()) || 0;

            var totalAccValue = (totalCtn * accRate).toFixed(3);
            var totalPartyValue = (totalCtn * partyRate).toFixed(3);

            $row.find('.total_acc_value').val(totalAccValue);
            $row.find('.total_party_value').val(totalPartyValue);

            setTimeout(calculateAndDisplayTotals, 100);
        });
    }

    function setupItemNameChangeListeners() {
        $('#sc_items').on('input', '.item_name_input', function() {
            setTimeout(calculateAndDisplayTotals, 100);
        });
    }

    // ============================================
    // 22. PLOT PO ITEMS
    // ============================================
    function ploatPOItems(data) {
        $('#sc_items tbody').empty();

        if (data && data.length > 0) {
            data.forEach(function(item, index) {
                var totalCbm = parseFloat(item.total_cbm || 0).toFixed(2);
                var grossWeight = parseFloat(item.gross_weight || 0).toFixed(3);
                var totalPartyValue = parseFloat(item.total_party_value || 0).toFixed(3);
                var totalAccValue = parseFloat(item.total_acc_value || 0).toFixed(3);

                var rowId = 'po-item-' + item.id + '-' + index;
                var row = '<tr id="' + rowId + '" class="po-item-row">' +
                    '<td style="width: 30px; text-align: center; vertical-align: middle;">' +
                        '<input type="checkbox" class="sub_chk" data-id="' + item.id + '" style="margin: 0;">' +
                    '</td>' +
                    '<td style="width: 80px; vertical-align: middle;">' +
                        '<input type="text" class="form-control form-control-sm input-sm item_code" style="font-size: 10px; width: 100%; padding: 2px 4px; height: 24px;" value="' + (item.item_code || '') + '" data-id="' + item.id + '" readonly>' +
                    '</td>' +
                    '<td style="width: 120px; vertical-align: middle;">' +
                        '<input type="text" class="form-control form-control-sm input-sm item_name" style="font-size: 10px; width: 100%; padding: 2px 4px; height: 24px;" value="' + (item.item_name || '') + '" data-id="' + item.id + '">' +
                    '</td>' +
                    '<td style="width: 70px; vertical-align: middle;">' +
                        '<input type="number" class="form-control form-control-sm input-sm total_ctn" style="font-size: 10px; width: 100%; padding: 2px 4px; height: 24px; text-align: right;" value="' + (item.total_ctn || 0) + '" data-id="' + item.id + '">' +
                    '</td>' +
                    '<td style="width: 80px; vertical-align: middle;">' +
                        '<input type="number" step="any" class="form-control form-control-sm input-sm acc_rate_per_ctn" style="font-size: 10px; width: 100%; padding: 2px 4px; height: 24px; text-align: right;" value="' + (item.acc_rate_per_ctn || 0) + '" data-id="' + item.id + '">' +
                    '</td>' +
                    '<td style="width: 80px; vertical-align: middle;">' +
                        '<input type="number" step="any" class="form-control form-control-sm input-sm party_rate_per_ctn" style="font-size: 10px; width: 100%; padding: 2px 4px; height: 24px; text-align: right;" value="' + (item.party_rate_per_ctn || 0) + '" data-id="' + item.id + '">' +
                    '</td>' +
                    '<td style="width: 75px; vertical-align: middle;">' +
                        '<input type="number" step="any" class="form-control form-control-sm input-sm cbm_per_ctn" style="font-size: 10px; width: 100%; padding: 2px 4px; height: 24px; text-align: right;" value="' + (item.cbm_per_ctn || 0) + '" data-id="' + item.id + '">' +
                    '</td>' +
                    '<td style="width: 70px; vertical-align: middle;">' +
                        '<input type="number" step="any" class="form-control form-control-sm input-sm total_cbm" style="font-size: 10px; width: 100%; padding: 2px 4px; height: 24px; text-align: right;" value="' + totalCbm + '" data-id="' + item.id + '" readonly>' +
                    '</td>' +
                    '<td style="width: 75px; vertical-align: middle;">' +
                        '<input type="number" step="any" class="form-control form-control-sm input-sm gross_weight" style="font-size: 10px; width: 100%; padding: 2px 4px; height: 24px; text-align: right;" value="' + grossWeight + '" data-id="' + item.id + '" readonly>' +
                    '</td>' +
                    '<td style="width: 80px; vertical-align: middle;">' +
                        '<input type="text" class="form-control form-control-sm input-sm hs_code" style="font-size: 10px; width: 100%; padding: 2px 4px; height: 24px;" value="' + (item.hs_code || '') + '" data-id="' + item.id + '">' +
                    '</td>' +
                    '<td style="width: 80px; vertical-align: middle;">' +
                        '<input type="text" class="form-control form-control-sm input-sm hs_code2" style="font-size: 10px; width: 100%; padding: 2px 4px; height: 24px;" value="' + (item.hs_code2 || '') + '" data-id="' + item.id + '">' +
                    '</td>' +
                    '<td style="width: 90px; vertical-align: middle;">' +
                        '<input type="number" step="any" class="form-control form-control-sm input-sm total_party_value" style="font-size: 10px; width: 100%; padding: 2px 4px; height: 24px; text-align: right; font-weight: bold; color: #0d6efd;" value="' + totalPartyValue + '" data-id="' + item.id + '" readonly>' +
                    '</td>' +
                    '<td style="width: 90px; vertical-align: middle;">' +
                        '<input type="number" step="any" class="form-control form-control-sm input-sm total_acc_value" style="font-size: 10px; width: 100%; padding: 2px 4px; height: 24px; text-align: right; font-weight: bold; color: #198754;" value="' + totalAccValue + '" data-id="' + item.id + '" readonly>' +
                    '</td>' +
                    '<td style="width: 65px; vertical-align: middle;">' +
                        '<input type="number" step="any" class="form-control form-control-sm input-sm sample_qty" style="font-size: 10px; width: 100%; padding: 2px 4px; height: 24px; text-align: right;" value="0" data-id="' + item.id + '">' +
                    '</td>' +
                    '<td style="display: none;">' +
                        '<input type="hidden" class="po_line_id" value="' + item.id + '">' +
                    '</td>' +
                '</tr>';
                $('#sc_items tbody').append(row);
            });

            // Event handler for input changes
            $('#sc_items').off('input', '.total_ctn, .acc_rate_per_ctn, .party_rate_per_ctn');
            $('#sc_items').on('input', '.total_ctn, .acc_rate_per_ctn, .party_rate_per_ctn', function() {
                var row = $(this).closest('tr');
                var total_ctn = parseFloat(row.find('.total_ctn').val()) || 0;
                var acc_rate = parseFloat(row.find('.acc_rate_per_ctn').val()) || 0;
                var party_rate = parseFloat(row.find('.party_rate_per_ctn').val()) || 0;

                var total_acc_value = (total_ctn * acc_rate).toFixed(3);
                var total_party_value = (total_ctn * party_rate).toFixed(3);

                row.find('.total_acc_value').val(total_acc_value);
                row.find('.total_party_value').val(total_party_value);

                var cbm_per_ctn = parseFloat(row.find('.cbm_per_ctn').val()) || 0;
                var total_cbm = (total_ctn * cbm_per_ctn).toFixed(2);
                row.find('.total_cbm').val(total_cbm);

                setTimeout(calculateAndDisplayTotals, 100);
            });

            $('#sc_items').off('input', '.cbm_per_ctn');
            $('#sc_items').on('input', '.cbm_per_ctn', function() {
                var row = $(this).closest('tr');
                var cbm_per_ctn = parseFloat($(this).val()) || 0;
                var total_ctn = parseFloat(row.find('.total_ctn').val()) || 0;
                var total_cbm = (total_ctn * cbm_per_ctn).toFixed(2);
                row.find('.total_cbm').val(total_cbm);
                setTimeout(calculateAndDisplayTotals, 100);
            });

            calculateAndDisplayTotals();
        } else {
            $('#sc_items tbody').append('<tr><td colspan="15" class="text-center">No data available</td></tr>');
        }
    }

    // ============================================
    // 23. PLOT SALES CONTRACT ITEMS
    // ============================================
    function ploatSalesContractItems(data) {
        $('#sc_items tbody').empty();

        if (data && data.length > 0) {
            data.forEach(function(item) {
                var totalCbm = parseFloat(item.total_cbm || 0).toFixed(2);
                var grossWeight = parseFloat(item.gross_weight || 0).toFixed(3);
                var totalPartyValue = parseFloat(item.total_party_value || 0).toFixed(3);
                var totalAccValue = parseFloat(item.total_acc_value || 0).toFixed(3);

                var row = '<tr>' +
                    '<td><input type="checkbox" class="sub_chk" data-id="' + item.id + '"></td>' +
                    '<td>' + (item.item_code || '') + '</td>' +
                    '<td><input type="text" class="form-control form-control-sm item_name_input small-input" style="font-size:11px;" value="' + (item.item_name || '') + '" data-id="' + item.id + '"></td>' +
                    '<td>' + (item.total_ctn || 0) + '</td>' +
                    '<td>' + (item.acc_rate_per_ctn || 0) + '</td>' +
                    '<td>' + (item.party_rate_per_ctn || 0) + '</td>' +
                    '<td>' + (item.cbm_per_ctn || 0) + '</td>' +
                    '<td>' + totalCbm + '</td>' +
                    '<td>' + grossWeight + '</td>' +
                    '<td>' + (item.hs_code || '') + '</td>' +
                    '<td>' + (item.hs_code2 || '') + '</td>' +
                    '<td>' + totalPartyValue + '</td>' +
                    '<td>' + totalAccValue + '</td>' +
                    '<td>' + (item.sample_qty || 0) + '</td>' +
                '</tr>';
                $('#sc_items tbody').append(row);
            });

            calculateAndDisplayTotals();
        } else {
            $('#sc_items tbody').append('<tr><td colspan="13" class="text-center">No data available</td></tr>');
        }
    }

    // ============================================
    // 24. TAB NAVIGATION
    // ============================================
    var tabs = $('.progress-tab');
    var nextBtn = $('#btnNext');
    var prevBtn = $('#btnPrev');
    var saveBtn = $('#btnSave');
    var currentTab = 0;
    var isFirstSubmission = true;

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

    function validateForm(formId) {
        var isValid = true;
        var missingFields = [];
        
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

    function submitFormViaAjax(formId, action, callback) {
        
        const form = $('#' + formId);
        let formData = form.serialize() + '&action=' + action;

        if ($("#by_order").is(":checked")) {
            const poItems = collectPOItemsFromUI();
            if (poItems.length > 0) {
                formData += '&po_items=' + JSON.stringify(poItems)
                        + '&upload_from=order'
                        + '&po_id=' + $('#po_id').val();
            }
        }

        if ($("#by_excel").is(":checked") || $("#add_item").is(":checked")) {
            formData += '&upload_from=other';
        }

        $.ajax({
            type: 'POST',
            url: '/xyz',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: handleSuccess,
            error: handleError
        });

        function handleSuccess(response) {
            if (response.code === 409) {
                showAlert('warning', 'Duplicate Entry!', response.message || 'Invoice number already exists');
                callback(false, response);
                return;
            }

            if (response.success) {
                $('#insert_sc_id').val(response.scId);
                showToast('success', response.message || 'Data saved successfully');
                callback(true, response);
            } else {
                showAlert('error', 'Error!', response.message || 'Failed to save');
                callback(false, response);
            }
        }

        function handleError(xhr) {
            const message = xhr.responseJSON?.message || 'Something went wrong. Please try again.';
            showAlert('error', 'Error!', message);
            callback(false, xhr.responseJSON);
        }

        function showAlert(icon, title, text) {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                confirmButtonText: 'OK',
                confirmButtonColor: icon === 'warning' ? '#f39c12' : '#d33'
            });
        }

        function showToast(icon, title) {
            Swal.fire({
                icon: icon,
                title: title,
                timer: 1500,
                showConfirmButton: false,
                position: 'top-end',
                toast: true
            });
        }
    }

    // ============================================
    // 25. PO ITEMS COLLECTION
    // ============================================
    function collectPOItemsFromUI() {
        var poItems = [];
        $('.po-item-row').each(function() {
            var $row = $(this);
            var item = {
                po_line_id: $row.find('.po_line_id').val() || 0,
                item_code: $row.find('.item_code').val() || '',
                item_name: $row.find('.item_name').val() || '',
                total_ctn: +$row.find('.total_ctn').val() || 0,
                party_rate_per_ctn: +$row.find('.party_rate_per_ctn').val() || 0,
                acc_rate_per_ctn: +$row.find('.acc_rate_per_ctn').val() || 0,
                cbm_per_ctn: +$row.find('.cbm_per_ctn').val() || 0,
                total_cbm: +$row.find('.total_cbm').val() || 0,
                gross_weight: +$row.find('.gross_weight').val() || 0,
                hs_code: $row.find('.hs_code').val() || '',
                hs_code2: $row.find('.hs_code2').val() || '',
                total_party_value: +$row.find('.total_party_value').val() || 0,
                total_acc_value: +$row.find('.total_acc_value').val() || 0,
                sample_qty: +$row.find('.sample_qty').val() || 0
            };
            poItems.push(item);
        });
        return poItems;
    }

    // ============================================
    // 26. BUTTON EVENTS
    // ============================================
    nextBtn.on('click', function() {
        if(validateForm('formStep1')) {
            if (isFirstSubmission) {
                submitFormViaAjax('formStep1', 'insert', function(success, response) {
                    if (success) {
                        isFirstSubmission = false;
                        currentTab++;
                        updateUI();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: response?.message || "Please fill out the required field.",
                            confirmButtonText: "OK"
                        });
                    }
                });
            } else {
                currentTab++;
                updateUI();
            }
        }
    });

    saveBtn.on('click', function() {
        var insertScIdValue = $('#insert_sc_id').val();
        if (insertScIdValue && validateForm('formStep2')) {
            submitFormViaAjax('formStep2', 'update', function(success) {
                if (success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Sales Contract Created Successfully..!!',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong while updating the data.',
                    });
                }
            });
        } else if (!insertScIdValue) {
            Swal.fire({
                icon: 'warning',
                title: "Sorry! Could't be Updated ?",
                text: 'Please Create Sales Contract First!',
            });
        }
    });

    prevBtn.on('click', function() {
        if (currentTab > 0) {
            currentTab--;
            updateUI();
        }
    });

    tabs.on('click', function() {
        currentTab = $(this).index();
        updateUI();
    });

    // ============================================
    // 27. DATATABLE INITIALIZATION
    // ============================================
    $('#sc_items').DataTable({
        "ordering": false,
        "stateSave": true,
        "lengthMenu": [[-1], ["All"]],
        "pageLength": -1,
        "bLengthChange": false,
        "order": [[0, "asc"]]
    });

    // ============================================
    // 28. INITIALIZE UI
    // ============================================
    updateUI();

});
</script>
@endsection