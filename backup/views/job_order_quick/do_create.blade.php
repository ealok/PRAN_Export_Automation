@extends('layouts.master')
@section('content') 
<style type="text/css">
  /* ===== BASE STYLES ===== */
  .main {
    position: absolute;
    border: 1px solid #222;
    top: -13px;
    left: 35px;
    background: burlywood;
    width: 200px;
    text-align: center;
    height: 24px;
  }
  
  .req_style_id {
    color: red;
  }

  /* ===== FORM STYLES ===== */
  .inline-form-group {
    flex: 1;
    min-width: 180px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    margin-bottom: 3px;
    border-radius: 8px;
    transition: all 0.3s ease;
    border: 1px solid #ddd9d963;
  }
  
  .inline-form-group label {
    white-space: nowrap;
    margin-right: 10px;
    font-weight: 600;
    color: #2c3e50;
    min-width: 120px;
  }

  .form-group {
    margin-bottom: 0px;
  }

  .form-control {
    border-radius: 4px;
    border: 1px solid #ced4da;
    padding: 6px 12px;
    font-size: 12px;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  }
  
  .form-control:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
  }

  /* ===== TABLE STYLES ===== */
  .table-container {
    max-height: 400px;
    overflow-y: auto;
    border: 1px solid #e1e5e9;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  }

  .modern-table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
  }
  
  .modern-table thead th {
    position: sticky;
    top: 0;
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    font-weight: 600;
    border: none;
    padding: 14px 10px;
    font-size: 11px;
    text-align: center;
    vertical-align: middle;
    border-right: 1px solid rgba(255,255,255,0.2);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    z-index: 2;
  }
  
  .modern-table thead th:last-child {
    border-right: none;
  }
  
  .modern-table tbody tr {
    transition: all 0.2s ease;
  }
  
  .modern-table tbody tr:nth-child(odd) {
    background-color: #f8fafc;
  }
  
  .modern-table tbody tr:nth-child(even) {
    background-color: #f1f5f9;
  }
  
  .modern-table tbody tr:hover {
    background-color: #e1f5fe;
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
  }
  
  .modern-table td {
    padding: 2px 10px;
    border: none;
    font-size: 11px;
    vertical-align: middle;
    color: #2d3748;
  }
  
  .modern-table tbody tr:last-child td {
    border-bottom: none;
  }

  /* Table Inputs & Selects */
  .table-select {
    width: 100%;
    border: 1px solid #e1e5e9;
    border-radius: 4px;
    padding: 6px 8px;
    font-size: 12px;
    background-color: #e8e8e8;
    transition: all 0.2s ease;
    color: #151515;
  }
  
  .table-select:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
  }
  
  .table-input {
    width: 100%;
    border: 1px solid #e1e5e9;
    border-radius: 4px;
    padding: 5px 0px;
    font-size: 10px;
    background-color: white;
    transition: all 0.2s ease;
  }
  
  .table-input:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
  }

  /* ===== BUTTON STYLES ===== */
  .btn {
    border-radius: 6px;
    font-weight: 600;
    padding: 8px 16px;
    transition: all 0.3s ease;
    font-size: 13px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    border: none;
    cursor: pointer;
    min-width: 120px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }
  
  .btn:after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 5px;
    height: 5px;
    background: rgba(255, 255, 255, 0.5);
    opacity: 0;
    border-radius: 100%;
    transform: scale(1, 1) translate(-50%);
    transform-origin: 50% 50%;
  }
  
  .btn:focus:not(:active)::after {
    animation: ripple 1s ease-out;
  }
  
  @keyframes ripple {
    0% {
      transform: scale(0, 0);
      opacity: 0.5;
    }
    100% {
      transform: scale(20, 20);
      opacity: 0;
    }
  }
  
  .btn-info {
    background: linear-gradient(135deg, #17a2b8, #138496);
    color: white;
  }
  
  .btn-info:hover {
    background: linear-gradient(135deg, #138496, #117a8b);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(23, 162, 184, 0.3);
  }
  
  .btn-success {
    background: linear-gradient(135deg, #28a745, #218838);
    color: white;
  }
  
  .btn-success:hover {
    background: linear-gradient(135deg, #218838, #1e7e34);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
  }
  
  .btn-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
  }
  
  .btn-danger:hover {
    background: linear-gradient(135deg, #c82333, #bd2130);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
  }
  
  .btn-warning {
    background: linear-gradient(135deg, #ffc107, #e0a800);
    color: #212529;
  }
  
  .btn-warning:hover {
    background: linear-gradient(135deg, #e0a800, #d39e00);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(255, 193, 7, 0.3);
  }
  
  .btn-flat {
    border-radius: 4px;
  }
  
  .btn:active {
    transform: translateY(0);
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
  }
  
  .btn-sm {
    padding: 6px 12px;
    font-size: 12px;
    min-width: 100px;
    height: 32px;
  }
  
  .btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
  }

  /* ===== ACTION BUTTONS ===== */
  .table_footer {
    text-align: center;
    margin-top: 25px;
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
  } 

  .action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
    flex-wrap: wrap;
  }
  
  .action-buttons .btn {
    flex: 0 0 auto;
  }

  /* ===== HEADER & SECTION STYLES ===== */
  .section-header {
    background: #138bc6;
    color: white;
    padding: 12px 15px;
    border-radius: 8px;
    margin-top: -15px;
    text-align: center;
    font-weight: bold;
    font-size: 18px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }

  .panel-body {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    padding: 20px;
  }

  label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
    font-size: 12px;
  }

  /* ===== ORDER SUMMARY STYLES ===== */
  .order-summary {
    margin-top: 20px;
    padding: 20px;
    background: #a4a4bf38;
    border-radius: 8px;
    border: 1px solid #e1e5e9;
    box-shadow: 0 2px 8px rgba(96, 89, 89, 0.34);
  }

  .summary-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: white;
  }

  .summary-header:hover {
    background-color: #f8f9fa;
  }

  .summary-header-left {
    display: flex;
    align-items: center;
  }

  .summary-header i {
    font-size: 18px;
    color: #ff8125;
    margin-right: 10px;
  }

  .summary-title {
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .toggle-icon {
    font-size: 16px;
    color: #6c757d;
    transition: transform 0.3s ease;
    padding: 5px;
    border-radius: 4px;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .toggle-icon:hover {
    background-color: #e9ecef;
    color: #3498db;
  }

  .summary-content {
    transition: all 0.3s ease;
    margin-top: 15px;
  }

  .summary-content.collapsed {
    display: none;
  }

  .summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    padding: 8px 12px;
    border-radius: 6px;
    transition: all 0.2s ease;
  }

  .summary-row:hover {
    background-color: #f8f9fa;
  }

  .summary-row:nth-child(1) {
    background-color: rgba(52, 152, 219, 0.2);
    border-left: 3px solid #3498db;
  }

  .summary-row:nth-child(2) {
    background-color: rgba(46, 204, 113, 0.19);
    border-left: 3px solid #2ecc71;
  }

  .summary-row:nth-child(3) {
    background-color: rgba(231, 76, 60, 0.18);
    border-left: 3px solid #e74c3c;
  }

  .summary-row:nth-child(4) {
    background-color: rgba(249, 7, 199, 0.24);
    border-left: 3px solid #6247e6;
  }

  .summary-row:last-child {
    background-color: rgba(52, 152, 219, 0.17);
    border-left: 3px solid #2980b9;
    margin-bottom: 0;
    padding-top: 10px;
    padding-bottom: 10px;
    font-weight: 600;
    font-size: 15px;
  }

  .summary-label {
    font-weight: 500;
    color: #495057;
    display: flex;
    align-items: center;
  }

  .summary-label i {
    margin-right: 8px;
    font-size: 14px;
    width: 16px;
    text-align: center;
  }

  .summary-row:nth-child(1) .summary-label i {
    color: #3498db;
  }

  .summary-row:nth-child(2) .summary-label i {
    color: #2ecc71;
  }

  .summary-row:nth-child(3) .summary-label i {
    color: #e74c3c;
  }

  .summary-row:last-child .summary-label i {
    color: #2980b9;
  }

  .summary-value {
    font-weight: 500;
    color: #2c3e50;
  }

  .summary-row:last-child .summary-value {
    font-weight: 600;
  }

  .total-input {
    width: 180px;
    border: 1px solid #28a745;
    border-radius: 4px;
    padding: 3px 12px;
    font-size: 14px;
    font-weight: 600;
    text-align: right;
    background: linear-gradient(135deg, #f8fff9, #e8f5e9);
    color: #155724;
    transition: all 0.2s ease;
  }

  .total-input:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.2);
    border-color: #28a745;
  }

  /* ===== SEARCH & FILTER STYLES ===== */
  .table-search-container {
    margin-bottom: 5px;
    display: flex;
    justify-content: flex-end;
    margin-top: -31px;
  }
  
  .table-search-input {
    width: 250px;
    border: 1px solid #15bbd7;
    border-radius: 4px;
    padding: 5px 12px;
    font-size: 12px;
    transition: all 0.2s ease;
  }
  
  .table-search-input:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
  }

  /* No Records Found Styling */
  .no-records-container {
    max-width: 400px;
    margin: 0 auto;
  }

  .no-records-icon {
    color: #6c757d;
  }

  .no-records-title {
    font-size: 18px;
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
  }

  .no-records-subtitle {
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 12px;
  }

  .no-records-tips {
    font-size: 12px;
    color: #868e96;
    font-style: italic;
    margin-top: 15px;
    padding-top: 15px;
  }

  /* Search counter styling */
  .search-counter {
    font-size: 12px;
    color: #28a745;
    font-weight: 500;
  }

  /* Highlight search terms in results */
  .highlight {
    background-color: #fff3cd;
    padding: 2px 4px;
    border-radius: 3px;
    font-weight: 600;
  }

  /* ===== MODAL & SWEETALERT STYLES ===== */
  .modal-dialog {
    width: 1000px;
    margin: 30px auto;
  }

  .modal-header {
    padding: 12px;
    border-bottom: 1px solid #dfdddda3 !important;
  }

  .modal-header .close {
    display: none;
  }

  .swal2-popup {
    display: none;
    position: relative;
    box-sizing: border-box;
    flex-direction: column;
    justify-content: center;
    width: 38em;
    max-width: 100%;
    padding: 1.25em;
    border: none;
    border-radius: .3125em;
    background: #fff;
    font-family: inherit;
    font-size: 1rem;
    height: 200px;
  }

  /* ===== SCROLLBAR STYLING ===== */
  .table-container::-webkit-scrollbar {
    width: 8px;
  }
  
  .table-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 0 10px 10px 0;
  }
  
  .table-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
  }
  
  .table-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
  }

  /* ===== MISC STYLES ===== */
  .content-header>.breadcrumb>li>a {
    color: #206C8A;
    text-decoration: none;
    display: inline-block;
    font-size: 13px;
    font-weight: bold;
  }

  .select2-container--default .select2-selection--single {
    border-radius: 4px;
    height: 34px;
    padding: 3px;
  }

  table.dataTable.no-footer {
    border-bottom: none;
  }

  table.dataTable thead th{
    padding: 0px 6px;
    border-bottom: none;
    font-size: 11px;
  }

  table.dataTable tbody td {
    padding: 0px 1px;
    font-size: 10px;
  }

  table.dataTable {
    width: 99%;
    margin: 0 auto;
    clear: both;
    border-collapse: collapse;
  }

  .dataTables_wrapper .dataTables_paginate {
    float: right;
    text-align: right;
    padding-top: .25em;
    display: none;
  }
  
  .dataTables_wrapper .dataTables_info {
    clear: both;
    float: left;
    padding-top: .755em;
    display: none;
  }

  .dataTables_wrapper .dataTables_filter input {
    border: 1px solid #aaa;
    border-radius: 3px;
    padding: 1px;
    background-color: transparent;
    margin-left: 3px;
  }

  .ellipsis {
    max-width: 40px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
  }

  input[type="checkbox"] {
    transform: scale(1.2);
    margin-right: 5px;
  }

  /* Non-selectable dropdown styling */
  .non-selectable {
    background-color: #f5f5f5 !important;
    cursor: not-allowed !important;
    opacity: 0.7;
  }
  
  .non-selectable option {
    color: #999;
  }

  /* ===== RESPONSIVE STYLES ===== */
  @media (max-width: 768px) {
    .order-summary {
        padding: 15px;
    }
    
    .summary-row {
        flex-direction: column;
        align-items: flex-start;
        padding: 10px 8px;
    }
    
    .summary-label {
        margin-bottom: 4px;
    }
    
    .total-input {
        width: 100%;
        margin-top: 5px;
    }
    
    .table-search-container {
      justify-content: flex-start;
    }
    
    .table-search-input {
      width: 100%;
    }

    .action-buttons {
      flex-direction: column;
      align-items: center;
    }

    .btn {
      min-width: 100%;
      margin-bottom: 8px;
    }

    .modal-dialog {
      width: 95%;
      margin: 20px auto;
    }
  }

  @media (max-width: 480px) {
    .section-header {
      font-size: 16px;
      padding: 10px;
    }

    .inline-form-group {
      flex-direction: column;
      align-items: flex-start;
    }

    .inline-form-group label {
      margin-bottom: 5px;
      min-width: auto;
    }

    .table_footer {
      flex-direction: column;
      gap: 8px;
    }
  }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="col-md-12">
      @if(Session::has('success'))
        <div class="callout callout-success">
            <strong>Success!</strong>{{ Session::get('success') }}
        </div> 
      @endif 
      @if(Session::has('danger'))
        <div class="callout callout-danger">
            <strong>Unsuccessful!</strong>{{ Session::get('danger') }}
        </div> 
      @endif 
      <div class="box box-primary" style="background: white; border-top-color: #e3e5e6; position: relative; width: 100%; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div class="panel-body" style="border: 1px solid #e3e5e6; border-radius: 8px;">
          <div class="section-header">DO Create Form</div>
          <div class="box-body">
            <div class="row">    
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Party Code<span class="req_style_id">*</span></label>
                  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <input type="text" class="form-control input-sm" name="importer_code" id="importer_code" value="{{$jobHeaderInfo->code}}" readonly>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Party Name<span class="req_style_id">*</span></label>
                  <input type="text" class="form-control input-sm" name="importer_name" id="importer_name" value="{{$jobHeaderInfo->name}}" readonly>
                  <input type="hidden" id="sale_contract_id" name="sale_contract_id" value="@if(!empty($sale_contract_id)){{$sale_contract_id}}@endif">
                  @if ($errors->has('name'))
                    <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                  @endif
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Party Address<span class="req_style_id">*</span></label>
                  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <textarea class="form-control input-sm" id="importer_address" readonly style="height: 30px;">{{$jobHeaderInfo->address}}</textarea>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Inv Number<span class="req_style_id">*</span></label>
                  <input type="text" class="form-control input-sm" name="" value="{{$jobHeaderInfo->invoice_no}}" id="invoice_no" readonly required>
                  <input type="hidden" class="form-control" name="sc_id" id="sc_id" value="{{$salesContact->id}}"> 
                  @if ($errors->has('invoice_no'))
                    <span class="help-block"><strong>{{ $errors->first('invoice_no') }}</strong></span>
                  @endif
                </div>
              </div>
            </div>
            <div class="row">
               <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Issue Date<span class="req_style_id">*</span></label>
                  <input name="text" type="text" class="form-control input-sm" id="issue_date" value="{{$jobHeaderInfo->issue_date}}" readonly>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Delivery Date<span class="req_style_id">*</span></label>
                  <input name="dated" type="text" id="delivery_date" class="form-control input-sm" value="{{$jobHeaderInfo->delivery_date}}" placeholder="Select Delivery Date" readonly>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">MFG Date<span class="req_style_id">*</span></label>
                  <input type="text" class="form-control input-sm" name="" value="{{$jobHeaderInfo->mfg_date_orginal}}" id="mfg_date" readonly placeholder="Auto Select">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Note<span class="req_style_id">*</span></label>
                  <input type="text" class="form-control input-sm" name="" value="@if(!empty($jobHeaderInfo->note)){{$jobHeaderInfo->note}}@endif" id="note">
                  @if ($errors->has('name'))
                    <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                  @endif
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Shipping Mark<span class="req_style_id">*</span></label>
                  <textarea class="form-control input-sm" id="shipping_mark" style="height: 30px;" placeholder="Enter Shipping Mark">@if(!empty($jobHeaderInfo->shipping_mask)){{$jobHeaderInfo->shipping_mask}}@endif</textarea>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Batch No</label>
                  <input name="text" type="text" class="form-control input-sm" id="batch_number" value="{{$jobHeaderInfo->batch_number}}" placeholder="Enter Batch Number" readonly>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Currency</label>
                  <input name="text" type="text" class="form-control input-sm" id="currency_rate" value="USD" placeholder="Enter Currency" readonly> 
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">JOB Order</label>
                  <input id="job_order_no" name="job_order_no" type="text" class="form-control input-sm" value="{{$jobHeaderInfo->job_order_number}}" placeholder="JOB Order Number" readonly>
                  <input type="hidden" value="{{$id}}" id="job_order_id">
                </div>
              </div>
            </div>
            <div class="row" style="margin-bottom: 25px;">
                <div class="col-sm-3">
                  <div class="inline-form-group">
                    <label for="dated">Credit Limit</label>
                    <input name="text" type="text" class="form-control" id="blimit" value="99999999" readonly>
                  </div>
                </div>
                 <div class="col-sm-3">
                  <div class="inline-form-group">
                    <label for="dated">Undelivered Value</label>
                    <input name="text" type="text" class="form-control" id="bundelivered" value="" readonly>
                  </div>
                </div>
                 <div class="col-sm-3">
                  <div class="inline-form-group">
                    <label for="dated">Balance</label>
                    <input name="text" type="text" class="form-control" id="bbalance" value="" readonly>
                  </div>
                </div>
                 <div class="col-sm-3">
                  <div class="inline-form-group">
                    <label for="dated">Rate(USD)</label>
                    <input name="text" type="text" class="form-control" id="brate" value="" readonly>
                  </div>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <form method="post" id="insert_form">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" id="job_order_id" name="job_order_id" value="{{$jobHeaderInfo->id}}">
                <input type="hidden" id="total_rate" name="total_rate" value="0">
                
                <!-- NEW: Table Search Input -->
                <div class="table-search-container">
                  <input type="text" id="tableSearch" class="table-search-input" placeholder="Search items by code, name, or any field...">
                </div>
                
                <div class="table-container">
                  <table class="modern-table" id="tblMain">
                    <thead>
                      <tr>
                        <th style="width: 45px;">Item Code</th>
                        <th>Item Name</th>
                        <th style="width: 45px;">Shelf Life</th>
                        <th style="width: 73px;">Ctn<br>Qty</th>
                        <th>Factor</th>
                        <th style="width: 84px;">DU Unit</th>
                        <th style="width: 70px;">SC Qty</th>
                        <th style="width: 80px;">ORQT</th>
                        <th style="width: 107px;">DO QTY</th>
                        <th style="width: 66px;">Bal.Qty</th>
                        <th style="width: 84px;">SMQT</th>
                        <th style="width: 84px;">RU Unit</th>
                        <!-- REMOVED: Coding Matter and Special Requirement columns -->
                        <th style="width: 111px;">
                            <span>Depot</span>
                            <select name="dunit" id="dunit" class="table-select">
                              <option value="">Select</option>
                              @foreach($depots as $depot)
                              <option value="{{$depot->id}}">{{$depot->p_code}}</option>
                              @endforeach
                            </select>
                        </th>
                        <th style="width: 70px;">Rate</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $j=0;?>
                      @if(!empty($jobItemDetails))
                      @foreach($jobItemDetails as $sale_contract_detail)
                        <tr>
                          <td>{{$sale_contract_detail->ci_item_code}}</td>
                          <td><input type="text" value="{{$sale_contract_detail->ci_item_name}}" class="table-input" title="{{$sale_contract_detail->ci_item_name}}"></td>
                          <td><input type="text" value="{{$sale_contract_detail->self_line}}" class="table-input" readonly></td>
                          <td><input type="number" value="{{$sale_contract_detail->qty}}" class="table-input" readonly></td>
                          <td><input type="number" value="{{$sale_contract_detail->qty}}" class="table-input" readonly></td>
                          <td>
                            <select name="dunit" id="dunit" class="table-select non-selectable" disabled>
                              <option value="">Select</option>
                              @foreach($dunits as $dunit)
                                <option value="{{$dunit->id}}" @if($dunit->id==$sale_contract_detail->du_unit) {{'selected'}}@endif>{{$dunit->dunit_name}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td><input type="text" value="{{$sale_contract_detail->pcs_in_ctn}}" class="table-input" readonly></td>
                          <td><input type="text" value="{{$sale_contract_detail->orqt}}" class="table-input oder_qty"></td>
                          <td><input type="text" value="{{$sale_contract_detail->orqt}}" class="table-input do-qty"></td>
                          <td><input type="number" value="{{$sale_contract_detail->balance}}" class="table-input pending-qty" readonly></td>
                          <td><input type="number" value="{{$sale_contract_detail->sample_qty}}" class="table-input smqt"></td>
                          <td>
                            <select name="runit" id="runit" class="table-select non-selectable">
                              <option value="">Select</option>
                              @foreach($runits as $runit)
                                <option value="{{$runit->id}}" @if($runit->id==$sale_contract_detail->ru_unit) {{'selected'}}@endif>{{$runit->runit_name}}</option>
                              @endforeach
                            </select>
                          </td>
                          <!-- REMOVED: Coding Matter and Special Requirement columns -->
                          <td>
                            <select name="dunit" id="dunit" class="table-select non-selectable">
                              <option value="">Select</option>
                              @foreach($depots as $depot)
                              <option value="{{$depot->id}}" {{ $depot->id == $sale_contract_detail->wh_id ? 'selected' : '' }}>{{$depot->p_code}}-{{$depot->p_name}}
                              </option>
                              @endforeach
                            </select>
                          </td>
                          <td><input type="text" name="rate" value="{{$sale_contract_detail->rate}}" class="table-input" readonly></td>
                          <td style="display: none"><input type="number" name="line_id" id="line_id" value="{{$sale_contract_detail->line_id}}"></td>
                        </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>
                
                <!-- UPDATED: Order Summary Section (Collapsed by default) -->
                <div class="order-summary">
                    <div class="summary-header" id="summaryToggle">
                        <div class="summary-header-left">
                            <i class="fas fa-clipboard-list"></i>
                            <h3 class="summary-title">DO Summary</h3>
                        </div>
                        <div class="toggle-icon">
                            <i class="fas fa-plus" id="toggleIcon"></i>
                        </div>
                    </div>
                    <div class="summary-content collapsed" id="summaryContent">
                        <div class="summary-row">
                            <span class="summary-label"><i class="fas fa-cube"></i> Total Items:</span>
                            <span class="summary-value" id="totalItems">0</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label"><i class="fas fa-boxes"></i> Total Ctn Quantity:</span>
                            <span class="summary-value" id="totalCtnQuantity">0</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label"><i class="fas fa-hourglass-half"></i> Total Pending Quantity:</span>
                            <span class="summary-value" id="pendingQuantity">0</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label"><i class="fas fa-vial"></i> Sample Quantity:</span>
                            <span class="summary-value" id="smqtQuantity">0</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label"><i class="fas fa-dollar-sign"></i> Grand Total:</span>
                            <input type="text" class="total-input" id="grandTotal" value="$0.00" readonly>
                        </div>
                    </div>
                </div>
                <div class="table_footer">
                  <div class="action-buttons">
                    <input type="button" class="btn btn-info btn-sm" id="check_balance" value="Verify Balance">
                    <input type="submit" name="submit" class="btn btn-success btn-sm" id="create_do" value="Create DO"/>
                  </div>
                </div>  
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>document.title = 'Create | DO';</script>
<script>
document.title = 'Create | DO';
setTimeout(function() { $('.sr-only').click();}, 0.0001);

// ===== GLOBAL VARIABLES =====
let currentDepotFilter = ''; // Track current depot filter

$(document).ready(function () {
    
    // Remove disabled attribute and non-selectable class from depot dropdowns
    $('td:nth-child(13) select').each(function() {
        $(this).removeAttr('disabled');
        $(this).removeClass('non-selectable');
    });

    // ===== DEPOT FILTER FUNCTIONALITY =====
    
    // Depot Selection Handler
    $("#dunit").change(function () {
        var selectedDepot = $(this).val();
        filterItemsByDepot(selectedDepot);
    });

    // Individual row depot selection handler
    $("#tblMain").on('change', 'tbody select', function () {
        var rowDepotValue = $(this).val();
        var row = $(this).closest('tr');
        
        if (rowDepotValue === "") {
            $(this).html('<option value="">Select</option>');
        }
        
        if (currentDepotFilter && currentDepotFilter !== "" && rowDepotValue !== currentDepotFilter) {
            row.hide();
            updateOrderSummary();
            updateActionButtonsState();
        }
        
        if (currentDepotFilter && currentDepotFilter !== "" && rowDepotValue === currentDepotFilter) {
            row.show();
            updateOrderSummary();
            updateActionButtonsState();
        }
        
        if (rowDepotValue && rowDepotValue !== "") {
            row.css('background-color', '');
            row.find("TD").eq(12).css('background-color', '');
            $(this).css('border', '');
        } else {
            row.css('background-color', '#ffebee');
            row.find("TD").eq(12).css('background-color', '#ffcdd2');
            $(this).css('border', '2px solid #f44336');
        }
    });

    // ===== SEARCH FUNCTIONALITY =====
    
    // Table search functionality
    $("#tableSearch").on("keyup", function() {
        var value = $(this).val().toLowerCase().trim();
        var visibleRows = 0;
        var totalRows = $("#tblMain tbody tr").not('.no-records-message').length;
        
        $("#tblMain tbody tr").not('.no-records-message').each(function() {
            var row = $(this);
            var rowText = row.text().toLowerCase();
            var isVisibleBySearch = rowText.indexOf(value) > -1;
            
            var matchesDepot = true;
            if (currentDepotFilter && currentDepotFilter !== "") {
                var rowDepotSelect = row.find("TD").eq(12).find("select");
                var rowDepotValue = rowDepotSelect.val();
                matchesDepot = (rowDepotValue === currentDepotFilter);
            }
            
            var shouldBeVisible = isVisibleBySearch && matchesDepot;
            row.toggle(shouldBeVisible);
            
            if (shouldBeVisible) {
                visibleRows++;
            }
        });
        
        if (value !== '' && visibleRows === 0) {
            showNoRecordsMessage(true, value, totalRows);
        } else if (visibleRows === 0 && currentDepotFilter) {
            showNoRecordsMessage(true, `depot: ${currentDepotFilter}`, totalRows);
        } else {
            showNoRecordsMessage(false);
        }
        
        updateOrderSummary();
        updateActionButtonsState();
    });

    $("#tableSearch").on('input', function() {
        if ($(this).val() === '') {
            showNoRecordsMessage(false);
            if (currentDepotFilter && currentDepotFilter !== "") {
                filterItemsByDepot(currentDepotFilter);
            } else {
                updateActionButtonsState();
            }
        }
    });

    // Initialize on page load
    var totalRows = $("#tblMain tbody tr").not('.no-records-message').length;
    if (totalRows === 0) {
        showNoRecordsMessage(true, '', 0);
    }
    updateActionButtonsState();

    // Initialize with Create DO button disabled
    $('#create_do').prop('disabled', true);

    // Real-time quantity validation for DO QTY column (column 9)
    $("#tblMain").on('input', 'td:nth-child(9) input', function () { // Column 9 is DO QTY
        var row = $(this).closest('tr');
        var salesContractQty = parseInt(row.find("TD").eq(7).find("input").val()) || 0; // Column 7 is SC Qty
        var orderQty = parseInt($(this).val()) || 0;
        var quantityInput = $(this);
        
        if (orderQty > salesContractQty) {
            // Show warning styling
            row.css('background-color', '#fff3cd');
            row.find("TD").eq(8).css('background-color', '#ffeaa7');
            quantityInput.css('border', '2px solid #f39c12');
            
            // Show inline warning message
            if (!row.find('.quantity-warning').length) {
                row.find("TD").eq(8).append('<div class="quantity-warning" style="color: #e74c3c; font-size: 10px; margin-top: 2px;">Exceeds contract quantity</div>');
            }
        } else {
            // Remove warning styling
            row.css('background-color', '');
            row.find("TD").eq(8).css('background-color', '');
            quantityInput.css('border', '');
            row.find('.quantity-warning').remove();
        }
        
        // Update order summary in real-time
        updateOrderSummary();
    });
    
    // Also validate when sales contract quantity changes
    $("#tblMain").on('input', 'td:nth-child(7) input', function () { // Column 7 is SC Qty
        var row = $(this).closest('tr');
        var orderQtyInput = row.find("TD").eq(8).find("input"); // DO QTY column
        var salesContractQty = parseInt($(this).val()) || 0;
        var orderQty = parseInt(orderQtyInput.val()) || 0;
        
        if (orderQty > salesContractQty) {
            row.css('background-color', '#fff3cd');
            row.find("TD").eq(8).css('background-color', '#ffeaa7');
            orderQtyInput.css('border', '2px solid #f39c12');
            
            if (!row.find('.quantity-warning').length) {
                row.find("TD").eq(8).append('<div class="quantity-warning" style="color: #e74c3c; font-size: 10px; margin-top: 2px;">Exceeds contract quantity</div>');
            }
        } else {
            row.css('background-color', '');
            row.find("TD").eq(8).css('background-color', '');
            orderQtyInput.css('border', '');
            row.find('.quantity-warning').remove();
        }
        
        updateOrderSummary();
    });

    // Search functionality
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#item_status tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Remove item from status table
    $("#item_status").on('click','.remCF',function(){
        $(this).parent().parent().remove();
    });

    // Initial order summary update
    updateOrderSummary();

    // UPDATED: Toggle order summary visibility (now starts collapsed)
    $('#summaryToggle').click(function () {
        $('#summaryContent').slideToggle(300, function () {
            if ($('#summaryContent').is(':visible')) {
                $('#toggleIcon').removeClass('fa-plus').addClass('fa-minus');
            } else {
                $('#toggleIcon').removeClass('fa-minus').addClass('fa-plus');
            }
        });
    });
});

// ===== DEPOT FILTER FUNCTIONS =====

// Function to enable/disable action buttons based on visible rows
function updateActionButtonsState() {
    const visibleRows = $("#tblMain TBODY TR:visible").not('.no-records-message').length;
    const hasVisibleRows = visibleRows > 0;
    
    // Disable buttons if no visible rows
    $('.btn-info, #create_do').prop('disabled', !hasVisibleRows);
    
    // Add visual feedback for disabled state
    if (!hasVisibleRows) {
        $('.btn-info, #create_do').css('opacity', '0.6');
        $('.btn-info, #create_do').attr('title', 'No items available for action');
    } else {
        $('.btn-info, #create_do').css('opacity', '1');
        $('.btn-info, #create_do').removeAttr('title');
    }
}

// Function to filter items by depot - ONLY show matching depot items
function filterItemsByDepot(depotCode) {
    currentDepotFilter = depotCode;
    
    if (!depotCode || depotCode === "") {
        // Show all items when no depot is selected
        $("#tblMain TBODY TR").show();
        showNoRecordsMessage(false);
        // Enable buttons when no filter is applied
        updateActionButtonsState();
        return;
    }
    
    let visibleRows = 0;
    
    $("#tblMain TBODY TR").each(function () {
        var row = $(this);
        var rowDepotSelect = row.find("TD").eq(12).find("select");
        var rowDepotValue = rowDepotSelect.val();
        
        // Show row ONLY if depot EXACTLY matches the filter
        // Items without depot selection (empty) will NOT be shown
        if (rowDepotValue === depotCode) {
            row.show();
            visibleRows++;
        } else {
            row.hide();
        }
    });
    
    // Show "no records found" message if no items match the depot
    if (visibleRows === 0) {
        showNoRecordsMessage(true, `depot: ${depotCode}`, $("#tblMain tbody tr").length);
    } else {
        showNoRecordsMessage(false);
    }
    
    // Update order summary after filtering
    updateOrderSummary();
    
    // Update button states based on visible rows
    updateActionButtonsState();
}

// Function to show/hide "no records found" message
function showNoRecordsMessage(show, searchTerm = '', totalRows = 0) {
    var noRecordsRow = $("#tblMain").find(".no-records-message");
    if (show) {
        if (noRecordsRow.length === 0) {
            var messageContent = '';
            
            if (totalRows === 0) {
                messageContent = 
                    '<div class="no-records-icon">' +
                    '<i class="fas fa-database" style="font-size: 32px; margin-bottom: 15px;"></i>' +
                    '</div>' +
                    '<div class="no-records-title">No Data Available</div>' +
                    '<div class="no-records-subtitle">There are no records to display</div>';
            } else {
                messageContent = 
                    '<div class="no-records-icon">' +
                    '<i class="fas fa-search" style="font-size: 32px; margin-bottom: 15px;"></i>' +
                    '</div>' +
                    '<div class="no-records-title">No Matching Records</div>' +
                    '<div class="no-records-tips">' +
                    '</div>';
            }
            
            var messageRow = '<tr class="no-records-message">' +
                '<td colspan="14" style="text-align: center; padding: 12px 20px; background-color: #f8f9fa;">' +
                '<div class="no-records-container">' +
                messageContent +
                '</div>' +
                '</td>' +
                '</tr>';
            $("#tblMain tbody").append(messageRow);
        }
    } else {
        noRecordsRow.remove();
    }
}

// Utility function to escape HTML (for security)
function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

// ===== EXISTING FUNCTIONS =====

// Order Summary Function
function updateOrderSummary() {
    let totalItems = 0;
    let totalCtnQuantity = 0;
    let pendingQuantity = 0;
    let smqtQuantity = 0;
    let grandTotal = 0;

    $("#tblMain TBODY TR:visible").each(function () {
        totalItems++;
        let row = $(this);
        let ctnQty = parseInt(row.find("TD").eq(3).find("input").val()) || 0; // Ctn Qty column (4)
        let pendingQty = parseInt(row.find("TD").eq(9).find("input").val()) || 0; // Bal.Qty column (10)
        let smqt = parseInt(row.find("TD").eq(10).find("input").val()) || 0; // SMQT column (11)
        let rate = parseFloat(row.find("TD").eq(13).find("input").val()) || 0; // Rate column (14)
        let doQty = parseInt(row.find("TD").eq(8).find("input").val()) || 0; // DO QTY column (9)
        
        totalCtnQuantity += ctnQty;
        pendingQuantity += pendingQty;
        smqtQuantity += smqt;
        grandTotal += rate * doQty;
    });

    $('#totalItems').text(totalItems);
    $('#totalCtnQuantity').text(totalCtnQuantity);
    $('#pendingQuantity').text(pendingQuantity);
    $('#smqtQuantity').text(smqtQuantity);
    $('#grandTotal').val('$' + grandTotal.toFixed(2));
    $('#total_rate').val(grandTotal.toFixed(2));
}

// Recalculate order summary on input changes
$('#tblMain').on('input', 'input', function () {
    updateOrderSummary();
});

$('#check_balance').on('click', function(e) {
    var party_code = $('#importer_code').val();
    var total_balance = $("#total_rate").val();
    var jo_id = $('#job_order_id').val();
    if(!party_code){
        Swal.fire({
            icon: 'warning',
            title: 'Missing Information',
            text: 'Party code is required.',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Show loading state
    Swal.fire({
        title: 'Verifying Credit',
        text: 'Please wait...',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    $.ajax({
        type: "GET",
        url: "{{url('/check/do_balance')}}?party_code=" + party_code + "&total_balance=" + total_balance + "&jo_id=" + jo_id,
        success: function (data) {
            
            $('#create_do').prop("disabled", true);
            
            if(data.status != "success"){
                Swal.fire({
                    icon: 'error',
                    title: 'Verification Failed',
                    text: 'Please try again.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Update form fields
            $('#bundelivered').val(data.undelivered);
            $('#blimit').val(data.credit_limit);
            $('#bbalance').val(data.blance);
            $('#brate').val(data.rate);
            
            if(data.check_status == "Y"){
                // SUFFICIENT CREDIT
                Swal.fire({
                    icon: 'success',
                    title: 'Credit Approved',
                    text: 'Sufficient credit available.',
                    confirmButtonText: 'OK'
                });
                $('#create_do').prop("disabled", false);

            } else if(data.check_status == "N"){
                // INSUFFICIENT CREDIT - Simple confirmation
                Swal.fire({
                    icon: 'warning',
                    title: 'Insufficient Credit',
                    text: 'Do you want to send approval mail?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Send Mail',
                    cancelButtonText: 'No, Cancel',
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if(result.isConfirmed){
                        sendApprovalRequest(jo_id);
                    }
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Connection Error',
                text: 'Please try again.',
                confirmButtonText: 'OK'
            });
        }
    });
});

// Simple function for sending approval request
function sendApprovalRequest(jo_id) {
    if(!jo_id) return;
    var credit_limit = $('#blimit').val();
    var undelivered = $('#bundelivered').val();
    var balance = $('#bbalance').val();
    var rate = $('#brate').val();

    // Show sending state
    Swal.fire({
        title: 'Sending Mail...',
        text: 'Please wait',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    $.ajax({
        type: "GET",
        url: "/balance_breaker/approval/mail",
        data: {
            'jo_id': jo_id,
            'credit_limit': credit_limit,
            'undelivered': undelivered,
            'balance': balance,
            'rate': rate,
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            if(data.status == 'Success'){
                Swal.fire({
                    icon: 'success',
                    title: 'Mail Sent',
                    text: 'Approval request sent successfully.',
                    confirmButtonText: 'OK'
                });
            } else if(data.status == 'Approve'){
                Swal.fire({
                    icon: 'info', 
                    title: 'Already Approved',
                    text: 'Request already approved.',
                    confirmButtonText: 'OK'
                });
            } else if(data.status == 'Sent'){
                Swal.fire({
                    icon: 'info',
                    title: 'Already Sent',
                    text: 'Approval request already sent.',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Unable to send request.',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Unable to send mail.',
                confirmButtonText: 'OK'
            });
        }
    });
}

// Depot Validation Functions
function validateDepotSelection() {
    let hasErrors = false;
    $("#tblMain TBODY TR:visible").each(function () {
        $(this).css('background-color', '');
        $(this).find("TD").eq(12).css('background-color', '');
        $(this).find("TD").eq(12).find("select").css('border', '');
    });
    
    $("#tblMain TBODY TR:visible").each(function () {
        var row = $(this);
        var depotSelect = row.find("TD").eq(12).find("select");
        var depotValue = depotSelect.val();
        
        if (!depotValue || depotValue === "") {
            hasErrors = true;
            row.css('background-color', '#ffebee');
            row.find("TD").eq(12).css('background-color', '#ffcdd2');
            depotSelect.css('border', '2px solid #f44336');
        }
    });
    
    return !hasErrors;
}

function showDepotValidationError() {
    Swal.fire({
        icon: 'error',
        title: 'Depot Selection Required',
        html: 'Please select depot for all items.<br>Rows with missing depot selection are highlighted in red.',
        confirmButtonText: 'OK',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            const firstEmptySelect = $("#tblMain TBODY TR:visible").find("TD").eq(12).find("select").filter(function() {
                return !$(this).val() || $(this).val() === "";
            }).first();
            
            if (firstEmptySelect.length > 0) {
                firstEmptySelect.focus();
            }
        }
    });
}

// Quantity Validation Functions
function validateOrderQuantities() {
    let hasErrors = false;
    let errorMessages = [];
    
    // Reset all quantity validation styling
    $("#tblMain TBODY TR:visible").each(function () {
        $(this).css('background-color', '');
        $(this).find("TD").eq(8).css('background-color', ''); // DO QTY column
        $(this).find("TD").eq(8).find("input").css('border', '');
        $(this).find('.quantity-warning').remove();
    });
    
    // Check each row for quantity validation
    $("#tblMain TBODY TR:visible").each(function () {
        var row = $(this);
        var itemCode = row.find("TD").eq(0).html();
        var itemName = row.find("TD").eq(1).find("input").val();
    
        // Get sales contract quantity (from column 7 - SC Qty)
        var salesContractQty = parseInt(row.find("TD").eq(7).find("input").val()) || 0;
        
        // Get order quantity (from column 9 - DO QTY)
        var orderQty = parseInt(row.find("TD").eq(8).find("input").val()) || 0;
        
        if (orderQty > salesContractQty) {
            hasErrors = true;
            
            // Highlight the row and quantity input
            row.css('background-color', '#fff3cd');
            row.find("TD").eq(8).css('background-color', '#ffeaa7');
            row.find("TD").eq(8).find("input").css('border', '2px solid #f39c12');
            
            errorMessages.push(`• ${itemName} (${itemCode}): DO Qty (${orderQty}) > Sales Contract Qty (${salesContractQty})`);
        }
    });
    
    return {
        isValid: !hasErrors,
        errors: errorMessages
    };
}

function showQuantityValidationError(errorMessages) {
    Swal.fire({
        icon: 'error',
        title: 'Quantity Validation Failed',
        html: `DO quantity cannot exceed sales contract quantity:<br><br>${errorMessages.join('<br>')}`,
        confirmButtonText: 'OK',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            // Focus on the first problematic quantity input
            const firstErrorInput = $("#tblMain TBODY TR:visible").find("TD").eq(8).find("input").filter(function() {
                var row = $(this).closest('tr');
                var salesContractQty = parseInt(row.find("TD").eq(7).find("input").val()) || 0;
                var orderQty = parseInt($(this).val()) || 0;
                return orderQty > salesContractQty;
            }).first();
            
            if (firstErrorInput.length > 0) {
                firstErrorInput.focus();
                firstErrorInput.select();
            }
        }
    });
}

// Date Handling Functions
$('#delivery_date').on('change', function() {
    var currentDate = new Date();
    var deliveryDate=$(this).val();

    var year = currentDate.getFullYear();
    var month = String(currentDate.getMonth() + 1).padStart(2, '0');
    var day = String(currentDate.getDate()).padStart(2, '0');
    var currentFormattedDate = year + '-' + month + '-' + day;

    var parts = deliveryDate.split('-');
    var deliveryFormatedDate = parts[2] + '-' + parts[1].padStart(2, '0') + '-' + parts[0].padStart(2, '0');
    var selectedDate = new Date(deliveryFormatedDate);
    selectedDate.setDate(selectedDate.getDate() - 1);
    
    if(deliveryFormatedDate < currentFormattedDate){
        Swal.fire({icon: 'warning', title: 'Oops...', text: 'Delivery date can not less than create date..!!'});
        $('#create_do').prop('disabled', true);
        $('#mfg_date').val("");
        $('#delivery_date').val("");
    } else {
        $('#create_do').prop('disabled', false);
        var formattedDate = formatDate(selectedDate);
        $('#mfg_date').val(formattedDate);
    }
});

function formatDate(date) {
    var year = date.getFullYear();
    var month = ('0' + (date.getMonth() + 1)).slice(-2);
    var day = ('0' + date.getDate()).slice(-2);
    return day + '-' + month + '-' + year;
}

// Form Submission with All Validations
$('#insert_form').on('submit', function(event){
    event.preventDefault();
    $('#create_do').prop('disabled', true);
    
    // 1. Validate Basic Form Fields
    const basicValidation = validateBasicFormFields();
    if (!basicValidation.isValid) {
        showBasicValidationError(basicValidation.errors);
        $('#create_do').prop('disabled', false);
        return false;
    }
    
    // 2. Validate order quantities before submission
    const quantityValidation = validateOrderQuantities();
    if (!quantityValidation.isValid) {
        showQuantityValidationError(quantityValidation.errors);
        $('#create_do').prop('disabled', false);
        return false;
    }
    
    // 3. Validate depot selection
    if (!validateDepotSelection()) {
        showDepotValidationError();
        $('#create_do').prop('disabled', false);
        return false;
    }
    
    // 4. Validate DU Unit and RU Unit selection
    const unitValidation = validateUnitSelection();
    if (!unitValidation.isValid) {
        showUnitValidationError(unitValidation.errors);
        $('#create_do').prop('disabled', false);
        return false;
    }
     
    // All validations passed - proceed with form submission
    submitFormData();
});

// ===== VALIDATION FUNCTIONS =====

// 1. Basic Form Fields Validation
function validateBasicFormFields() {
    let errors = [];
    let isValid = true;

    const fields = [
        { id: 'importer_code', name: 'Importer Code' },
        { id: 'invoice_no', name: 'Invoice Number' },
        { id: 'importer_name', name: 'Importer Name' },
        { id: 'importer_address', name: 'Importer Address' },
        { id: 'note', name: 'Note' },
        { id: 'issue_date', name: 'Issue Date' },
        { id: 'shipping_mark', name: 'Shipping Mark' },
        { id: 'delivery_date', name: 'Delivery Date' },
        { id: 'mfg_date', name: 'MFG Date' },
        { id: 'batch_number', name: 'Batch Number' }
    ];

    fields.forEach(field => {
        const value = document.getElementById(field.id).value.trim();
        if (value === "") {
            errors.push(`${field.name} cannot be empty`);
            isValid = false;
            
            // Highlight the field
            $(`#${field.id}`).css('border-color', '#dc3545');
        } else {
            $(`#${field.id}`).css('border-color', '');
        }
    });

    return { isValid, errors };
}

// 2. Order Quantities Validation
function validateOrderQuantities() {
    let hasErrors = false;
    let errorMessages = [];
    
    // Reset all quantity validation styling
    $("#tblMain TBODY TR:visible").each(function () {
        $(this).css('background-color', '');
        $(this).find("TD").eq(8).css('background-color', '');
        $(this).find("TD").eq(8).find("input").css('border', '');
        $(this).find('.quantity-warning').remove();
    });
    
    // Check each row for quantity validation
    $("#tblMain TBODY TR:visible").each(function () {
        var row = $(this);
        var itemCode = row.find("TD").eq(0).html();
        var itemName = row.find("TD").eq(1).find("input").val();
        
        // Get sales contract quantity (from column 7 - SC Qty)
        var salesContractQty = parseInt(row.find("TD").eq(7).find("input").val()) || 0;
        
        // Get order quantity (from column 9 - DO QTY)
        var orderQty = parseInt(row.find("TD").eq(8).find("input").val()) || 0;
        
        if (orderQty > salesContractQty) {
            hasErrors = true;
            
            // Highlight the row and quantity input
            row.css('background-color', '#fff3cd');
            row.find("TD").eq(8).css('background-color', '#ffeaa7');
            row.find("TD").eq(8).find("input").css('border', '2px solid #f39c12');
            
            errorMessages.push(`• ${itemName} (${itemCode}): DO Qty (${orderQty}) > Sales Contract Qty (${salesContractQty})`);
        }
    });
    
    return {
        isValid: !hasErrors,
        errors: errorMessages
    };
}

// 3. Depot Selection Validation
function validateDepotSelection() {
    let hasErrors = false;
    $("#tblMain TBODY TR:visible").each(function () {
        $(this).css('background-color', '');
        $(this).find("TD").eq(12).css('background-color', '');
        $(this).find("TD").eq(12).find("select").css('border', '');
    });
    
    $("#tblMain TBODY TR:visible").each(function () {
        var row = $(this);
        var depotSelect = row.find("TD").eq(12).find("select");
        var depotValue = depotSelect.val();
        
        if (!depotValue || depotValue === "") {
            hasErrors = true;
            row.css('background-color', '#ffebee');
            row.find("TD").eq(12).css('background-color', '#ffcdd2');
            depotSelect.css('border', '2px solid #f44336');
        }
    });
    
    return !hasErrors;
}

// 4. Unit Selection Validation (DU Unit and RU Unit)
function validateUnitSelection() {
    let hasErrors = false;
    let errorMessages = [];
    
    $("#tblMain TBODY TR:visible").each(function () {
        var row = $(this);
        var itemCode = row.find("TD").eq(0).html();
        var itemName = row.find("TD").eq(1).find("input").val();
        
        // Check DU Unit (column 6)
        var duUnitSelect = row.find("TD").eq(5).find("select");
        var duUnitValue = duUnitSelect.val();
        
        // Check RU Unit (column 12)
        var ruUnitSelect = row.find("TD").eq(11).find("select");
        var ruUnitValue = ruUnitSelect.val();
        
        if (!duUnitValue || duUnitValue === "") {
            hasErrors = true;
            duUnitSelect.css('border', '2px solid #f44336');
            errorMessages.push(`• ${itemName} (${itemCode}): DU Unit not selected`);
        } else {
            duUnitSelect.css('border', '');
        }
        
        if (!ruUnitValue || ruUnitValue === "") {
            hasErrors = true;
            ruUnitSelect.css('border', '2px solid #f44336');
            errorMessages.push(`• ${itemName} (${itemCode}): RU Unit not selected`);
        } else {
            ruUnitSelect.css('border', '');
        }
    });
    
    return {
        isValid: !hasErrors,
        errors: errorMessages
    };
}

// ===== ERROR DISPLAY FUNCTIONS =====

function showBasicValidationError(errors) {
    Swal.fire({
        icon: 'warning',
        title: 'Required Fields Missing',
        html: `Please fill in all required fields:<br><br>${errors.join('<br>')}`,
        confirmButtonText: 'OK',
        confirmButtonColor: '#d33'
    });
}

function showQuantityValidationError(errorMessages) {
    Swal.fire({
        icon: 'error',
        title: 'Quantity Validation Failed',
        html: `DO quantity cannot exceed sales contract quantity:<br><br>${errorMessages.join('<br>')}`,
        confirmButtonText: 'OK',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            const firstErrorInput = $("#tblMain TBODY TR:visible").find("TD").eq(8).find("input").filter(function() {
                var row = $(this).closest('tr');
                var salesContractQty = parseInt(row.find("TD").eq(7).find("input").val()) || 0;
                var orderQty = parseInt($(this).val()) || 0;
                return orderQty > salesContractQty;
            }).first();
            
            if (firstErrorInput.length > 0) {
                firstErrorInput.focus();
                firstErrorInput.select();
            }
        }
    });
}

function showDepotValidationError() {
    Swal.fire({
        icon: 'error',
        title: 'Depot Selection Required',
        html: 'Please select depot for all items.<br>Rows with missing depot selection are highlighted in red.',
        confirmButtonText: 'OK',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            const firstEmptySelect = $("#tblMain TBODY TR:visible").find("TD").eq(12).find("select").filter(function() {
                return !$(this).val() || $(this).val() === "";
            }).first();
            
            if (firstEmptySelect.length > 0) {
                firstEmptySelect.focus();
            }
        }
    });
}

function showUnitValidationError(errorMessages) {
    Swal.fire({
        icon: 'error',
        title: 'Unit Selection Required',
        html: `Please select both DU Unit and RU Unit for all items:<br><br>${errorMessages.join('<br>')}`,
        confirmButtonText: 'OK',
        confirmButtonColor: '#d33'
    });
}

// ===== FORM SUBMISSION FUNCTION =====

function submitFormData() {
    var party_code=document.getElementById('importer_code').value;
    var shipping_mark=document.getElementById('shipping_mark').value;
    var note=document.getElementById('note').value;
    var sc_id=document.getElementById('sc_id').value;
    var job_order_id=document.getElementById('job_order_id').value;
    var job_order_no=document.getElementById('job_order_no').value;
    var currency_rate=document.getElementById('currency_rate').value;
    var batch_number=document.getElementById('batch_number').value;
    var issue_date=document.getElementById('issue_date').value;
    var delivery_date=document.getElementById('delivery_date').value;
    var mfg_date=document.getElementById('mfg_date').value;
    var unit_data = $("#insert_form").serializeArray();
    var info_details = new Array();
    
    $("#tblMain TBODY TR:visible").each(function () {
        var row = $(this);
        var do_qty_input = row.find("TD").eq(8).find("input").val(); // DO QTY (column 9)
        var do_qty = parseFloat(do_qty_input) || 0;
        
        // Only include items with do_qty > 0 and not empty
        if (do_qty > 0 && do_qty_input !== "" && !isNaN(do_qty)) {
            var dist_info = {};
            dist_info.item_code = row.find("TD").eq(0).html();
            dist_info.item_name = row.find("TD").eq(1).find("input").val();
            dist_info.self_life = row.find("TD").eq(2).find("input").val();
            dist_info.qty = row.find("TD").eq(3).find("input").val();
            dist_info.sale_contact_qty = row.find("TD").eq(6).find("input").val(); // SC Qty (column 6)
            dist_info.orqt = row.find("TD").eq(7).find("input").val(); // Orqt Qty (column 7)
            dist_info.do_qty = do_qty; // DO QTY (column 9)
            dist_info.bal_qty = row.find("TD").eq(9).find("input").val(); // Bal.Qty (column 10)
            dist_info.smqt = row.find("TD").eq(10).find("input").val(); // SMQT (column 11)
            
            // REMOVED: Coding Matter and Special Requirement fields
            
            dist_info.rate = row.find("TD").eq(13).find("input").val(); // Rate (column 14)
            dist_info.line_id = row.find("TD").eq(14).find("input").val(); // line_id (column 15)
            
            // Get DU Unit and RU Unit values
            var duUnitSelect = row.find("TD").eq(5).find("select"); // DU Unit (column 6)
            dist_info.du_unit = duUnitSelect.val();
            
            var ruUnitSelect = row.find("TD").eq(11).find("select"); // RU Unit (column 12)
            dist_info.ru_unit = ruUnitSelect.val();
            
            var depotSelect = row.find("TD").eq(12).find("select"); // Depot (column 13)
            dist_info.depot = depotSelect.val();
            
            info_details.push(dist_info);
        }
    });

    if (info_details.length < 1) {
        Swal.fire({
            icon: 'warning', 
            title: 'No Items to Create DO', 
            text: 'Please enter DO quantity for at least one item to create DO'
        });
        $('#create_do').prop('disabled', false);
        return false;
    }

    // Show loading state
    Swal.fire({
        title: 'Creating DO...',
        text: 'Please wait while we process your request',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        method: 'POST',
        url: "/quick/create_do",
        data: {
            'job_order_id':job_order_id,
            'job_order_no':job_order_no,
            'currency_rate':currency_rate,
            'batch_number':batch_number,
            'shipping_mark':shipping_mark,
            'sc_id':sc_id,
            'party_code':party_code,
            'note':note,
            'issue_date':issue_date,
            'delivery_date':delivery_date,
            'mfg_date':mfg_date,
            'party_code':party_code,
            'info_details': info_details,
            '_token': $('input[name=_token]').val()
        },
        success: function (response) {
            Swal.close();
            if(response.status === 'success') {
                let successMessage = 'DO Created Successfully!<br><br>';  
                if (response.do_numbers && response.do_numbers.length > 0) {
                    response.do_numbers.forEach(doInfo => {
                        successMessage += `<strong>Depot ${doInfo.depot_name}:</strong> DO Number: ${doInfo.do_number}<br>`;
                    });
                }
                
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    html: successMessage,
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "DO Creation Failed",
                    text: response.message || "There was an error creating the DO.",
                    confirmButtonText: 'OK'
                });
            }
            $('#create_do').prop('disabled', true);
        },
        error: function (e) {
            Swal.close();
            console.log(e);
            Swal.fire({
                icon: "error",
                title: "Network Error",
                text: "Failed to submit the form. Please check your connection and try again.",
                confirmButtonText: 'OK'
            });
            $('#create_do').prop('disabled', false);
        }
    });
}

// ===== REAL-TIME VALIDATION =====

// Real-time validation for basic form fields
$('#importer_code, #invoice_no, #importer_name, #importer_address, #note, #issue_date, #shipping_mark, #delivery_date, #mfg_date, #batch_number').on('input', function() {
    var value = $(this).val().trim();
    if (value === "") {
        $(this).css('border-color', '#dc3545');
    } else {
        $(this).css('border-color', '');
    }
});
</script>
@endsection