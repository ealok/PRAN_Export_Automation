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
        padding: 20px 0 30px;
        overflow-x: auto;
        scrollbar-width: none;
        gap: 4px;
        margin-top: -40px;
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

    /* Form enhancements */
    .form-control, .form-select {
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
    .open > .dropdown-menu {
        display: block;
        width: 197px !important;
        font-size: 12px;
    }
  </style>
</head>
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
            <button class="progress-tab" id="tab-skills" data-target="#pane-skills">
              <i class="bi bi-lightbulb"></i>
              <span>Items</span>
            </button>
          </div>
          <div class="tab-content" style="margin-top: -40px;">
            <!-- Address -->
            <div class="tab-pane fade" id="pane-address">
              <hr>
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
                            <input name="invoice_no" type="text" id="invoice_no" class="form-control input-sm"   value=""  autofocus max="191"  placeholder="Enter Invoice Number" onkeyup="checkInvoiceNumberExistOrNot()" required="">
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
                               
                            </select>
                            @if ($errors->has('notify_pary_id'))
                                <span class="help-block"><strong>{{ $errors->first('notify_pary_id') }}</strong></span>
                            @endif  
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="party_name">Party Name<span class="req_style_id">*</span></label>
                            <input name="party_name" type="text" id="party_name" class="form-control input-sm"  placeholder="Auto Field Notify Party Name" value="">
                            @if ($errors->has('party_name'))
                                <span class="help-block"><strong>{{ $errors->first('party_name') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="party_address">Party Addr.<span class="req_style_id">*</span></label>
                            <textarea name="party_address" type="text" id="party_address" class="form-control input-sm"  placeholder="Auto Field Notify Party Address Here" style="width: 203px; height: 26px;"></textarea>
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
                            <textarea name="importer_address" type="text" id="importer_address" class="form-control input-sm" placeholder="Importer Address(Auto Field)" required style="width: 203px; height: 26px;"></textarea>
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
                            <input type="text" class="form-control  group-input-style" placeholder="Qty" id="container_1" name="container_1">
                            <input type="text" class="form-control  group-input-style" placeholder="Amount">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="inline-form-group">
                        <label>40ft Cont.</label>
                        <div class="input-group">
                            <input type="text" class="form-control  group-input-style" placeholder="Qty" id="container_1" name="container_1">
                            <input type="text" class="form-control  group-input-style" placeholder="Amount">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="inline-form-group">
                        <label>40ft HC Cont.</label>
                        <div class="input-group">
                            <input type="text" class="form-control  group-input-style" placeholder="Qty" id="container_1" name="container_1">
                            <input type="text" class="form-control  group-input-style" placeholder="Amount">
                        </div>
                    </div>
                </div>
                   <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="discharge_port">Total Freight Accts<span class="req_style_id">*</span></label>
                            <input name="discharge_port" type="number" id="discharge_port" class="form-control input-sm"   value="0"  autofocus placeholder="Total Freight(Auto Cal..)" readonly>
                            @if ($errors->has('discharge_port'))
                                <span class="help-block"><strong>{{ $errors->first('discharge_port') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="discharge_port">Freight Accts(If Revised)</label>
                            <input name="discharge_port" type="number" id="discharge_port" class="form-control input-sm" value="0" placeholder="">
                            @if ($errors->has('discharge_port'))
                                <span class="help-block"><strong>{{ $errors->first('discharge_port') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="discharge_port">Freight(Documents)</label>
                            <input name="discharge_port" type="number" id="discharge_port" class="form-control input-sm" value="0" placeholder="">
                            @if ($errors->has('discharge_port'))
                                <span class="help-block"><strong>{{ $errors->first('discharge_port') }}</strong></span>
                            @endif
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
                            <label for="footer_importer_address" >Footer Importer addr.</label><br>
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
            </div>
            <!-- Education -->
            <div class="tab-pane fade" id="pane-education">
              <hr>
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
                            <label for="formated_file">LC Terms(Only For India)</label>
                            <input name="lc_term_for_india" type="text"  class="form-control input-sm" value="" placeholder="Enter LC Terms(Only India)">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="formated_file">Advance Payment</label>
                            <input name="advance_payment" type="text"  class="form-control input-sm"   value="" placeholder="Enter Advance Payment">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                           <label for="formated_file">Freight Charge(For India)</label>
                           <input name="freight_charge_india" type="text"  class="form-control input-sm"   value="" placeholder="Enter Freight Charge(Only India)">
                        </div>    
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="formated_file">Lot Number(For India)</label>
                            <input name="lot_number" type="text"  class="form-control input-sm"   value="" placeholder="Enter lot Number(Only India)">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                         <label for="formated_file">Best Before(For India)</label>
                         <input name="best_before_india" type="text"  class="form-control input-sm"   value="" placeholder="Enter Best Before(Only India)">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                           <label for="formated_file">GSP Ref. No.</label>
                           <input name="gsp_ref_number" type="text"  class="form-control input-sm"   value="" placeholder="Enter GSP Ref no"> 
                        </div>    
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="formated_file">Shipping Mark(For India)</label>
                            <input name="shipping_mark_india" type="text"  class="form-control input-sm"   value="" placeholder="Enter Shipping Mark(Only India)">
                        </div>
                    </div>
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
                </div>    
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="arv_amount_received_date">ARV Amt Receipt Dt(For India)</label>
                            <input name="arv_amount_received_date" type="text" class="form-control datepicker input-sm"  value=""  placeholder="Select Date"  autocomplete="off"  is_date="1" >
                            @if ($errors->has('arv_amount_received_date'))
                                <span class="help-block"><strong>{{ $errors->first('arv_amount_received_date') }}</strong></span>
                            @endif
                        </div>
                    </div>
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
                            </select>  
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="custom_station_id">Custom Station</label>
                            <select name="custom_station_id" id="custom_station_id" data-live-search="true" class="form-control select2 selectpicker input-sm"  type="select"  value="1" >
                                <option value="">Select</option>
                            </select>  
                        </div>
                    </div>
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
                            </select>
                            @if ($errors->has('shipping_line_id'))
                                <span class="help-block"><strong>{{ $errors->first('shipping_line_id') }}</strong></span>
                            @endif  
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="name_of_shipping_line_id">Name Of Shipping Line</label>
                            <select name="name_of_shipping_line_id" id="name_of_shipping_line_id" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1">
                                <option value="">Select</option>
                            </select>
                            @if ($errors->has('name_of_shipping_line_id'))
                                <span class="help-block"><strong>{{ $errors->first('name_of_shipping_line_id') }}</strong></span>
                            @endif  
                        </div>
                    </div>
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
                            <input name="freight_amount_btd" type="text" class="form-control input-sm"  value=""  placeholder="Enter Freight Amount (BDT)">
                            @if ($errors->has('freight_amount_btd'))
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
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="">House Airway Bill Date</label>
                            <input name="master_airway_bill_date" type="text" class="form-control input-sm datepicker"  value=""  placeholder="Enter House Airway Bill Date">
                            @if ($errors->has('master_airway_bill_date'))
                                <span class="help-block"><strong>{{ $errors->first('master_airway_bill_date') }}</strong></span>
                            @endif
                        </div>
                    </div>
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
                                <input type="radio" name="is_notify_also_notity" id="is_notify_also_notity" value="0" >No
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="tr_no_is_exist" >TR No.(Land Only)</label><br>
                            <label class="radio-inline">
                                <input type="radio" name="tr_no_is_exist"   value="1"   id="tr_no_is_exist" >Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="tr_no_is_exist" id="tr_no_is_exist" value="0" >No
                            </label>
                        </div>
                    </div>
                     <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="address_replace" >Address Replace</label><br>
                            <label class="radio-inline">
                                <input type="radio" name="address_replace"   value="1"   id="address_replace" >Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="address_replace"   value="0"   id="address_replace" >No
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
                                <input type="radio" name="is_total_amount_oceania"  value="0" >No
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
                                <input type="radio" name="add_also_notify_party" id="add_also_notify_party" value="0" >No
                            </label>
                        </div>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="inline-form-group">
                            <label for="mfg_date_india" >Is Hs Code2</label><br>
                            <label class="radio-inline">
                                <input type="radio" name="is_hscode2" id="is_hscode2" value="1">Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="is_hscode2" id="is_hscode2" value="0">No
                            </label>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <!-- Employment -->
            <div class="tab-pane fade" id="pane-skills">
              <hr>            
              <div class="form-section">
                <div class="row">
                  <div class="col-md-6">
                    <div class="inline-form-group">
                      <label class="control-label req">Formated File</label>
                      <input type="file" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="inline-form-group">
                      <label class="control-label">PI File</label>
                      <input type="file" class="form-control">
                    </div>
                  </div>
                </div>
                <hr>
                <table class="table table-bordered table-condenced" id="sc_items">
                    <thead>
                        <tr style="font-size: 12px">
                            <th>#SL</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Factor</th>
                            <th>Acc Rate</th>
                            <th>Party Rate</th>
                            <th>SC Qty</th>
                            <th>Total Value(USD)</th>
                        </tr>  
                    </thead>
                    <tbody id="po_details" style="font-size: 11px"></tbody>
                </table> 
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="sticky-actions clearfix">
            <div class="pull-left">
              <button class="btn btn-default" id="btnPrev"><i class="bi bi-arrow-left"></i> Previous</button>
            </div>
            <div class="pull-right">
              <button class="btn btn-primary" id="btnNext">Save And Next<i class="bi bi-arrow-right"></i></button>
              <button class="btn btn-success" id="btnSave" style="display: none;"><i class="bi bi-check2-circle"></i> Save & Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>document.title = 'Sales Contract | Process';</script>
  <script>
    setTimeout(function() { $('.sr-only').click();}, 0.0001);
    $('#sc_items').DataTable({
        "order": [[ 0, "DESC" ]],
        "lengthMenu": [[-1], ["All"]],
        "pageLength": -1,  // Always show all rows
        "bLengthChange": false  // Hide the length menu dropdown
    });
    $(document).ready(function() {
      var tabs = $('.progress-tab');
      var panes = $('.tab-pane');
      var nextBtn = $('#btnNext');
      var prevBtn = $('#btnPrev');
      var saveBtn = $('#btnSave');
      var currentTab = 0;

      // Function to update the UI based on current tab
      function updateUI() {
        // Update tabs
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

        // Show/hide navigation buttons
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

        // Activate the corresponding tab pane
        var targetPane = $(tabs[currentTab]).data('target');
        $('.tab-pane').removeClass('in active');
        $(targetPane).addClass('in active');
      }

      // Next button click handler
      nextBtn.on('click', function() {
        if (currentTab < tabs.length - 1) {
          currentTab++;
          updateUI();
        }
      });

      // Previous button click handler
      prevBtn.on('click', function() {
        if (currentTab > 0) {
          currentTab--;
          updateUI();
        }
      });

      // Tab click handler
      tabs.on('click', function() {
        currentTab = $(this).index();
        updateUI();
      });

      // Initialize UI
      updateUI();
    });
  </script>
@endsection