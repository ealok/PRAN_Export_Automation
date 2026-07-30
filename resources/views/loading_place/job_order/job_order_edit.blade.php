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
    background-color: #205879;
    transition: all 0.2s ease;
    color: white;
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

  /* ===== RATE STATUS BADGES ===== */
  .rate-status {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    text-align: center;
    min-width: 40px;
    border: 1px solid transparent;
  }
  
  .rate-verified {
    background-color: #d4edda;
    color: #155724;
    border-color: #c3e6cb;
  }
  
  .rate-pending {
    background-color: #fff3cd;
    color: #856404;
    border-color: #ffeaa7;
  }
  
  .rate-failed {
    background-color: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
  }
  
  .rate-needs-approval {
    background-color: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
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
    color: #3498db;
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
    margin-top: -21px;
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
    margin-bottom: 15px;
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
    border-top: 1px solid #dee2e6;
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

  /* Status badges for modal table */
  .status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
  }
  
  .status-approved {
    background-color: #d4edda;
    color: #155724;
  }
  
  .status-pending {
    background-color: #fff3cd;
    color: #856404;
  }
  
  .status-rejected {
    background-color: #f8d7da;
    color: #721c24;
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
          <div class="section-header">JO Edit Form</div>
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
                  <input type="text" class="form-control input-sm" name="" value="@if(!empty($invoice_no)){{$invoice_no}}@endif" id="invoice_no" readonly required>
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
                  <input name="dated" type="text" id="delivery_date" class="form-control datepicker input-sm" value="{{$jobHeaderInfo->delivery_date}}" placeholder="Select Delivery Date">
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
                  <input type="hidden" class="form-control" name="edit_id" value="{{$edit_id}}" id="edit_id">
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
                  <textarea class="form-control input-sm" id="shipping_mark" style="height: 30px;" placeholder="Enter Shipping Mark">@if(!empty($jobOrderMasterResult->address)){{$jobOrderMasterResult->shipping_mask}}@endif</textarea>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Batch No</label>
                  <input name="text" type="text" class="form-control input-sm" id="batch_number" value="{{$jobHeaderInfo->batch_number}}" placeholder="Enter Batch Number">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">IMP BY</label>
                  <input name="text" type="text" class="form-control input-sm" id="imp_by" value="{{$jobHeaderInfo->imp_by}}" placeholder="Enter IMP By">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Distributed By</label>
                  <input name="distributed_by" type="text" class="form-control input-sm" id="distributed_by" value="{{$jobHeaderInfo->distributed_by}}" placeholder="Enter Distributed By">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Best Before</label>
                    @if($jobHeaderInfo->best_before=='1')
                    <input id="best_before" type="checkbox" name="best_before">
                    @endif
                    @if($jobHeaderInfo->best_before=='0')
                    <input id="best_before" type="checkbox" name="best_before">
                    @endif
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <form method="post" id="insert_form">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                
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
                        <th style="width: 66px;">SMQT</th>
                        <th style="width: 84px;">RU Unit</th>
                        <th>Coding<br>Matter</th>
                        <th style="width: 71px;">SREQ</th>
                        <th style="min-width: 95px;"><sapn>Factory</sapn>
                            <select name="factory" id="factory" class="table-select">
                              <option value="">Select</option>
                              @foreach($factories as $factory)
                                <option value="{{$factory->id}}">{{$factory->short_name}}</option>
                              @endforeach
                            </select>
                        </th>
                        <th style="width: 111px;">
                          <span>Depot</span>
                          <select name="dunit" id="dunit" class="table-select">
                            <option value="">Select</option>
                            @foreach($depots as $depot)
                            <option value="{{$depot->id}}">{{$depot->d_code}}</option>
                            @endforeach
                          </select>
                        </th>
                        <th style="width: 70px;">Rate</th>
                        <!-- NEW: Status Column -->
                        <th style="width: 73px;">Status</th>
                        <th style="width: 23px;"><input type="checkbox" id="selectAll"/>All</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $j=0;?>
                      @if(!empty($jobItemDetails))
                      @foreach($jobItemDetails as $sale_contract_detail)
                        <tr>
                          <td>{{$sale_contract_detail->ci_item_code}}</td>
                          <td><input type="text" value="{{$sale_contract_detail->ci_item_name}}" class="table-input" title="{{$sale_contract_detail->ci_item_name}}"></td>
                          <td><input type="text" value="{{$sale_contract_detail->self_line}}" class="table-input"></td>
                          <td><input type="number" value="{{$sale_contract_detail->qty}}" class="table-input" readonly></td>
                          <td><input type="number" value="{{$sale_contract_detail->factor}}" class="table-input" readonly></td>
                          <td>
                            <select name="dunit" id="dunit" class="table-select">
                              <option value="">Select</option>
                              @foreach($dunits as $dunit)
                                <option value="{{$dunit->id}}" @if($dunit->id==$sale_contract_detail->du_unit) {{'selected'}}@endif>{{$dunit->dunit_name}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td><input type="text" value="{{$sale_contract_detail->pcs_in_ctn}}" class="table-input"></td>
                          <td><input type="number" value="{{$sale_contract_detail->pcs_in_ctn}}" class="table-input navigateTest"></td>
                          <td><input type="number" value="{{$sale_contract_detail->sample_qty}}" class="table-input smqt"></td>
                          <td>
                            <select name="runit" id="runit" class="table-select">
                              <option value="">Select</option>
                              @foreach($runits as $runit)
                                <option value="{{$runit->id}}" @if($runit->id==$sale_contract_detail->ru_unit) {{'selected'}}@endif>{{$runit->runit_name}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td><input type="text" value="{{$sale_contract_detail->coding_mater}}" class="table-input coding_matter"></td>
                          <td><input type="text" value="{{$sale_contract_detail->special_requirment}}" class="table-input special-requirement"></td>
                          <td>
                            <select name="factory" id="factory" class="table-select">
                              <option value="">Select</option>
                              @foreach($factories as $factory)
                                <option value="{{$factory->id}}" {{ $factory->id == $sale_contract_detail->factory ? 'selected' : '' }}>{{$factory->short_name}}
                              </option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                            <select name="dunit" id="dunit" class="table-select">
                              <option value="">Select</option>
                              @foreach($depots as $depot)
                              <option value="{{$depot->id}}" {{ $depot->id == $sale_contract_detail->wh_id ? 'selected' : '' }}>
                                  {{$depot->d_code}}-{{$depot->d_name}}
                              </option>
                              @endforeach
                            </select>
                          </td>
                          <td><input type="text" name="rate" value="{{$sale_contract_detail->rate}}" class="table-input" readonly></td>
                          <td>
                            <span class="rate-status 
                              @if(isset($sale_contract_detail->rate_status))
                                @if($sale_contract_detail->rate_status == 'Y') rate-verified
                                @elseif($sale_contract_detail->rate_status == 'M' || $sale_contract_detail->rate_status == 'E' || $sale_contract_detail->rate_status == 'S') rate-needs-approval
                                @else rate-pending
                                @endif
                              @else
                                rate-pending
                              @endif" 
                              id="rate-status-{{$sale_contract_detail->ci_item_code}}">
                              @if(isset($sale_contract_detail->rate_status))
                                @if($sale_contract_detail->rate_status == 'Y') Verified
                                @elseif($sale_contract_detail->rate_status == 'M') Not Verified
                                @elseif($sale_contract_detail->rate_status == 'E') Not Verified
                                @elseif($sale_contract_detail->rate_status == 'S') Not Verified
                                @else Pending
                                @endif
                              @else
                                Pending
                              @endif
                            </span>
                        </td>
                          <td style="display: none"><input type="number" name="line_id" id="line_id" value="{{$sale_contract_detail->line_id}}"></td>
                          <td style="text-align: center">
                            <input type="checkbox" value="one">
                          </td>
                        </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>
                
                <!-- UPDATED: Order Summary Section (Always visible by default) -->
                <div class="order-summary">
                    <div class="summary-header" id="summaryToggle">
                        <div class="summary-header-left">
                            <i class="fas fa-clipboard-list"></i>
                            <h3 class="summary-title">Order Summary</h3>
                        </div>
                        <div class="toggle-icon">
                            <i class="fas fa-minus" id="toggleIcon"></i>
                        </div>
                    </div>
                    <div class="summary-content" id="summaryContent">
                        <div class="summary-row">
                            <span class="summary-label"><i class="fas fa-cube"></i> Total Items:</span>
                            <span class="summary-value" id="totalItems">0</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label"><i class="fas fa-boxes"></i> Total Quantity:</span>
                            <span class="summary-value" id="totalQuantity">0</span>
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
                    <button type="button" onclick="remove('tblMain');" class="btn btn-danger btn-sm">Remove</button>
                    <input type="submit" name="submit" class="btn btn-success btn-sm" id="create_jo" value="Update"/>
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
<script>document.title = 'Create New | JO';</script>
<script type="text/javascript">
setTimeout(function() { $('.sr-only').click();}, 0.0001);
$(document).ready(function () {
    
    // ENHANCED: Table search functionality with better "no records found" message
    $("#tableSearch").on("keyup", function() {
        var value = $(this).val().toLowerCase().trim();
        var visibleRows = 0;
        var totalRows = $("#tblMain tbody tr").not('.no-records-message').length;
        
        // Search through table rows (excluding the message row itself)
        $("#tblMain tbody tr").not('.no-records-message').each(function() {
            var rowText = $(this).text().toLowerCase();
            var isVisible = rowText.indexOf(value) > -1;
            $(this).toggle(isVisible);
            
            if (isVisible) {
                visibleRows++;
            }
        });
        
        // Show/hide "no records found" message
        if (value !== '' && visibleRows === 0) {
            showNoRecordsMessage(true, value, totalRows);
        } else {
            showNoRecordsMessage(false);
        }
        
    });

    // Enhanced function to show/hide "no records found" message
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
                        '<div class="no-records-subtitle">No results found for "<strong>' + 
                        escapeHtml(searchTerm) + 
                        '</strong>"</div>' +
                        '<div class="no-records-tips">' +
                        'Try adjusting your search terms or check for spelling errors' +
                        '</div>';
                }
                
                var messageRow = '<tr class="no-records-message">' +
                    '<td colspan="17" style="text-align: center; padding: 40px 20px; background-color: #f8f9fa;">' +
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

    // Handle when search is cleared
    $("#tableSearch").on('input', function() {
        if ($(this).val() === '') {
            showNoRecordsMessage(false);
        }
    });

    // Initialize on page load
    $(document).ready(function() {
        var totalRows = $("#tblMain tbody tr").not('.no-records-message').length;
        if (totalRows === 0) {
            showNoRecordsMessage(true, '', 0);
        }
    });

    // Function to show/hide "no records found" message
    function showNoRecordsMessage(show) {
        var noRecordsRow = $("#tblMain").find(".no-records-message");
        
        if (show) {
            if (noRecordsRow.length === 0) {
                // Create and append "no records found" row
                var messageRow = '<tr class="no-records-message">' +
                    '<td colspan="17" style="text-align: center; padding: 20px; background-color: #f8f9fa; color: #6c757d; font-style: italic;">' +
                    '<i class="fas fa-search" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>' +
                    'No records found matching your search criteria' +
                    '</td>' +
                    '</tr>';
                $("#tblMain tbody").append(messageRow);
            }
        } else {
            // Remove "no records found" row if it exists
            noRecordsRow.remove();
        }
    }

    // Also handle when search is cleared
    $("#tableSearch").on('input', function() {
        if ($(this).val() === '') {
            showNoRecordsMessage(false);
        }
    });

    // Coding Matter Editor
    $(".coding_matter").click(function () {
        var targetCell = $(this);
        var currentText = targetCell.val();
        Swal.fire({
            title: 'Edit Coding Matter',
            input: 'textarea',
            inputValue: currentText,
            inputAttributes: {'aria-label': 'Edit Coding Matter'},
            showCancelButton: true,
            confirmButtonText: 'Save Changes',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: (newText) => {
                if (newText !== null) {
                    targetCell.val(newText);
                }
            },
            allowOutsideClick: false,
            inputValidator: (value) => {
                if (!value) return 'You need to write something!';
            }
        });
    });

    // Special Requirement Editor
    $(".special-requirement").click(function () {
        var targetCell = $(this);
        var currentText = targetCell.val();
        Swal.fire({
            title: 'Edit Special Requirement:',
            input: 'textarea',
            inputValue: currentText,
            inputAttributes: {'aria-label': 'Edit Special Requirement:'},
            showCancelButton: true,
            confirmButtonText: 'Save Changes',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: (newText) => {
                if(newText !== null) targetCell.val(newText);
            },
            allowOutsideClick: false
        });
    });

    // Factory Selection Handling
    $("#factory").change(function () {
        let selectedFactory = $(this).val();
        $('#tblMain tbody select[name="factory"]').val(selectedFactory);
    });
    // Depot Selection Handling
    $("#dunit").change(function () {
        var selectedDepot = $(this).val();
        $("#tblMain tbody tr").each(function () {
            var rowDepotSelect = $(this).find("td").eq(13).find("select");
            rowDepotSelect.val(selectedDepot);
            if (rowDepotSelect.val() === "") {
                rowDepotSelect.html('<option value="">Select</option>');
            }
        });
    });

    $("#tblMain").on('change', 'tbody select', function () {
        var rowDepotValue = $(this).val();
        if (rowDepotValue === "") {
            $(this).html('<option value="">Select</option>');
        }
    });

    // Real-time validation when depot select changes
    $("#tblMain").on('change', 'tbody select', function () {
        var row = $(this).closest('tr');
        var depotValue = $(this).val();
        var selectElement = $(this);
        
        if (depotValue && depotValue !== "") {
            row.css('background-color', '');
            row.find("TD").eq(13).css('background-color', '');
            selectElement.css('border', '');
        } else {
            row.css('background-color', '#ffebee');
            row.find("TD").eq(13).css('background-color', '#ffcdd2');
            selectElement.css('border', '2px solid #f44336');
        }
    });

    // Enhanced select change handler
    $("#tblMain").on('change', 'tbody select', function () {
        var rowDepotValue = $(this).val();
        if (rowDepotValue === "") {
            var row = $(this).closest('tr');
            row.css('background-color', '#ffebee');
            row.find("td").eq(13).css('background-color', '#ffcdd2');
            $(this).css('border', '2px solid #f44336');
        }
    });

    // Real-time quantity validation
    $("#tblMain").on('input', 'td:nth-child(8) input', function () { // Column 8 is ORQT
        var row = $(this).closest('tr');
        var salesContractQty = parseInt(row.find("TD").eq(6).find("input").val()) || 0; // Column 7 is SC Qty
        var orderQty = parseInt($(this).val()) || 0;
        var quantityInput = $(this);
        
        if (orderQty > salesContractQty) {
            // Show warning styling
            row.css('background-color', '#fff3cd');
            row.find("TD").eq(7).css('background-color', '#ffeaa7');
            quantityInput.css('border', '2px solid #f39c12');
            
            // Show inline warning message
            if (!row.find('.quantity-warning').length) {
                row.find("TD").eq(7).append('<div class="quantity-warning" style="color: #e74c3c; font-size: 10px; margin-top: 2px;">Exceeds contract quantity</div>');
            }
        } else {
            // Remove warning styling
            row.css('background-color', '');
            row.find("TD").eq(7).css('background-color', '');
            quantityInput.css('border', '');
            row.find('.quantity-warning').remove();
        }
        
        // Update order summary in real-time
        updateOrderSummary();
    });
    
    // Also validate when sales contract quantity changes
    $("#tblMain").on('input', 'td:nth-child(7) input', function () { // Column 7 is SC Qty
        var row = $(this).closest('tr');
        var orderQtyInput = row.find("TD").eq(7).find("input");
        var salesContractQty = parseInt($(this).val()) || 0;
        var orderQty = parseInt(orderQtyInput.val()) || 0;
        
        if (orderQty > salesContractQty) {
            row.css('background-color', '#fff3cd');
            row.find("TD").eq(7).css('background-color', '#ffeaa7');
            orderQtyInput.css('border', '2px solid #f39c12');
            
            if (!row.find('.quantity-warning').length) {
                row.find("TD").eq(7).append('<div class="quantity-warning" style="color: #e74c3c; font-size: 10px; margin-top: 2px;">Exceeds contract quantity</div>');
            }
        } else {
            row.css('background-color', '');
            row.find("TD").eq(7).css('background-color', '');
            orderQtyInput.css('border', '');
            row.find('.quantity-warning').remove();
        }
        
        updateOrderSummary();
    });

    // Select All functionality
    $('#selectAll').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
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

    // UPDATED: Toggle order summary visibility (now starts expanded)
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

// Order Summary Function
function updateOrderSummary() {

    let totalItems = 0;
    let totalQuantity = 0;
    let smqtQuantity = 0;
    let grandTotal = 0;

    $("#tblMain TBODY TR").each(function () {
        totalItems++;
        let row = $(this);
        let qty = parseInt(row.find("TD").eq(7).find("input").val()) || 0;
        let smqt = parseInt(row.find("TD").eq(8).find("input").val()) || 0;
        let rate = parseFloat(row.find("TD").eq(14).find("input").val()) || 0;
        totalQuantity += qty;
        smqtQuantity += smqt;
        grandTotal += rate * qty;
    });

    $('#totalItems').text(totalItems);
    $('#totalQuantity').text(totalQuantity);
    $('#smqtQuantity').text(smqtQuantity);
    $('#grandTotal').val('$' + grandTotal.toFixed(2));
}

// Recalculate order summary on input changes
$('#tblMain').on('input', 'input', function () {
    updateOrderSummary();
});

// NEW: Function to update rate verification status in the dedicated Status column
function updateRateStatus(itemCode, status, message = '') {
    const statusElement = $(`#rate-status-${itemCode}`);
    
    // Remove all status classes
    statusElement.removeClass('rate-pending rate-verified rate-failed rate-needs-approval');
    
    // Add appropriate class and text based on status
    switch(status) {
        case 'verified':
            statusElement.addClass('rate-verified').text('Verified');
            break;
        case 'failed':
            statusElement.addClass('rate-failed').text('Failed');
            if (message) {
                statusElement.attr('title', message);
            }
            break;
        case 'needs_approval':
            statusElement.addClass('rate-needs-approval').text('Needs Approval');
            if (message) {
                statusElement.attr('title', message);
            }
            break;
        default:
            statusElement.addClass('rate-pending').text('Pending');
            break;
    }
}

// Depot Validation Functions
function validateDepotSelection() {
    let hasErrors = false;
    $("#tblMain TBODY TR").each(function () {
        $(this).css('background-color', '');
        $(this).find("TD").eq(13).css('background-color', '');
        $(this).find("TD").eq(13).find("select").css('border', '');
    });
    
    $("#tblMain TBODY TR").each(function () {
        var row = $(this);
        var depotSelect = row.find("TD").eq(13).find("select");
        var depotValue = depotSelect.val();
        
        if (!depotValue || depotValue === "") {
            hasErrors = true;
            row.css('background-color', '#ffebee');
            row.find("TD").eq(13).css('background-color', '#ffcdd2');
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
            const firstEmptySelect = $("#tblMain TBODY TR").find("TD").eq(13).find("select").filter(function() {
                return !$(this).val() || $(this).val() === "";
            }).first();
            
            // if (firstEmptySelect.length > 0) firstEmptySelect.focus();
        }
    });
}

// Quantity Validation Functions
function validateOrderQuantities() {
    let hasErrors = false;
    let errorMessages = [];
    
    // Reset all quantity validation styling
    $("#tblMain TBODY TR").each(function () {
        $(this).css('background-color', '');
        $(this).find("TD").eq(7).css('background-color', ''); // ORQT column
        $(this).find("TD").eq(7).find("input").css('border', '');
        $(this).find('.quantity-warning').remove();
    });
    
    // Check each row for quantity validation
    $("#tblMain TBODY TR").each(function () {
        var row = $(this);
        var itemCode = row.find("TD").eq(0).html();
        var itemName = row.find("TD").eq(1).find("input").val();
        
        // Get sales contract quantity (from column 6 - SC Qty)
        var salesContractQty = parseInt(row.find("TD").eq(6).find("input").val()) || 0;
        
        // Get order quantity (from column 7 - ORQT)
        var orderQty = parseInt(row.find("TD").eq(7).find("input").val()) || 0;
        
        if (orderQty > salesContractQty) {
            hasErrors = true;
            
            // Highlight the row and quantity input
            row.css('background-color', '#fff3cd');
            row.find("TD").eq(7).css('background-color', '#ffeaa7');
            row.find("TD").eq(7).find("input").css('border', '2px solid #f39c12');
            
            errorMessages.push(`• ${itemName} (${itemCode}): Order Qty (${orderQty}) > Sales Contract Qty (${salesContractQty})`);
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
        html: `Order quantity cannot exceed sales contract quantity:<br><br>${errorMessages.join('<br>')}`,
        confirmButtonText: 'OK',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            // Focus on the first problematic quantity input
            const firstErrorInput = $("#tblMain TBODY TR").find("TD").eq(7).find("input").filter(function() {
                var row = $(this).closest('tr');
                var salesContractQty = parseInt(row.find("TD").eq(6).find("input").val()) || 0;
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

function rateVerifying(id){
    if(!validateDepotSelection()) {
        showDepotValidationError();
        return false;
    }
    
    // Validate order quantities
    const quantityValidation = validateOrderQuantities();
    if (!quantityValidation.isValid) {
        showQuantityValidationError(quantityValidation.errors);
        return false;
    }
     
    var matching_info = new Array();
    var pendingItemsCount = 0;
    
    $("#tblMain TBODY TR").each(function () {
        var row = $(this);
        var statusElement = row.find("TD").eq(15).find(".rate-status");
        var currentStatus = statusElement.text().trim();
        
        // Only include items that are still pending
        if (currentStatus === 'Pending') {
            var dist_info = {};
            dist_info.item_code = row.find("TD").eq(0).html();
            dist_info.item_name = row.find("TD").eq(1).find("input").val();
            var depotSelect = row.find("TD").eq(13).find("select");
            dist_info.depo_code = depotSelect.find("option:selected").text().split('-')[0];
            dist_info.rate = row.find("TD").eq(14).find("input").val();
            dist_info.line_id = row.find("TD").eq(16).find("input").val();
            dist_info.current_status = currentStatus; // Send current status to backend
            matching_info.push(dist_info);
            pendingItemsCount++;
        }
    });

    // Check if there are any pending items to verify
    if (pendingItemsCount === 0) {
        Swal.fire({
            icon: "info",
            title: "No Pending Items",
            text: "All items have already been verified. No pending items to verify."
        });
        return false;
    }

    console.log(`Verifying ${pendingItemsCount} pending items out of ${$("#tblMain TBODY TR").length} total items`);

    // Show loading state for rate verification
    $('.rate_varifying_btn_id').prop('disabled', true).val('Verifying...');
    
    // Reset only pending rate statuses to pending (in case they were changed)
    $("#tblMain TBODY TR").each(function () {
        var row = $(this);
        var statusElement = row.find("TD").eq(15).find(".rate-status");
        var currentStatus = statusElement.text().trim();
        
        if (currentStatus === 'Pending') {
            updateRateStatusForRow(row, 'pending');
        }
    });

    $.ajax({
        method: 'POST',
        url: "/job/order/rate_matching",
        data: {
            'id': id, 
            'matching_info': matching_info, 
            '_token': $('input[name=_token]').val()
        },
        success: function (response) {
            console.log('Rate verification response:', response);
            
            $('.rate_varifying_btn_id').prop('disabled', false).val('Rate Verifying');
            
            // Check if response is JSON object with item_statuses (new format)
            if (response && response.item_statuses) {
                console.log('Found item_statuses:', response.item_statuses);
                
                let updatedItemsCount = 0;
                
                // Update each table row with its corresponding status
                $("#tblMain TBODY TR").each(function (index) {
                    var row = $(this);
                    var itemCode = row.find("TD").eq(0).html();
                    var lineId = row.find("TD").eq(16).find("input").val();
                    
                    // Find the status for this specific line_id
                    const itemStatus = response.item_statuses.find(status => 
                        status.item_code === itemCode
                    );
                    
                    if (itemStatus) {
                        console.log(`Updating row ${index}:`, itemCode, 'with status:', itemStatus.status);
                        updateRateStatusForRow(row, itemStatus.status, itemStatus.message);
                        updatedItemsCount++;
                    }
                });
                
                // Show appropriate message based on overall status
                if (response.overall_status === 'success') {
                    Swal.fire({
                        icon: "success", 
                        title: "Success!", 
                        text: `Successfully verified ${updatedItemsCount} pending item(s)!`
                    });
                } else if (response.overall_status === 'needs_approval') {
                    // Use the message from backend response
                    let approvalMessage = response.message || `${updatedItemsCount} item(s) need higher authority approval!`;
                    
                    Swal.fire({
                        icon: "warning",
                        title: "Approval Required",
                        text: approvalMessage,
                        showCancelButton: true,
                        confirmButtonText: "Send Mail",
                        cancelButtonText: "Close",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Are you sure?",
                                text: "Do you want to send the approval mail?",
                                icon: "question",
                                showCancelButton: true,
                                confirmButtonText: "Yes, Send it",
                                cancelButtonText: "No, Cancel",
                                confirmButtonColor: "#28a745",
                                cancelButtonColor: "#d33",
                            }).then((confirmResult) => {
                                if(confirmResult.isConfirmed) {
                                    $.ajax({
                                        url: '/send-approval-mail', 
                                        type: 'POST',
                                        data: { 
                                            id: id,
                                            approval_type: response.approval_type,
                                            message: approvalMessage,
                                            '_token': $('input[name=_token]').val()
                                        },
                                        success: function (mailResponse) {
                                            Swal.fire("Mail Sent!", "Approval mail has been sent successfully.", "success");
                                        },
                                        error: function () {
                                            Swal.fire("Error!", "Failed to send the mail.", "error");
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
                
            } 
            // Fallback for old string response format
            else if (typeof response === 'string' && (response == "Ed" || response == "Md" || response == "S" || response == "success")) {
                console.log('Old format response detected:', response);
                
                let status = 'needs_approval';
                let message = 'Not Verified';
                
                if (response === "success") {
                    status = 'verified';
                    message = 'Verified';
                }
                
                // Only update items that were pending
                $("#tblMain TBODY TR").each(function () {
                    var row = $(this);
                    var statusElement = row.find("TD").eq(15).find(".rate-status");
                    var currentStatus = statusElement.text().trim();
                    
                    if (currentStatus === 'Pending') {
                        updateRateStatusForRow(row, status, message);
                    }
                });
                
                if (response === "success") {
                    Swal.fire({icon: "success", title: "Success!", text: `Successfully verified ${pendingItemsCount} pending item(s)!`});
                } else {
                    let approvalMessage = `${pendingItemsCount} item(s) are not Verified, Need approval..!!`;
                    if (response === "Ed") approvalMessage = `${pendingItemsCount} item(s) are not Verified, Need ED(Export) approval..!!`;
                    else if (response === "Md") approvalMessage = `${pendingItemsCount} item(s) are not Verified, Need MD(PRAN) approval..!!`;
                    else if (response === "S") approvalMessage = `${pendingItemsCount} item(s) are not Verified, Need Samia madam approval..!!!`;
                    
                    Swal.fire({icon: "warning", title: "Approval Required", text: approvalMessage});
                }
            } else {
                console.log('Unexpected response format:', response);
                Swal.fire({icon: "error", title: "Error", text: 'An unexpected error occurred..!!'});
            }
        },
        error: function (e) {
            console.log('AJAX Error:', e);
            $('.rate_varifying_btn_id').prop('disabled', false).val('Rate Verifying');
            Swal.fire({icon: "error", title: "Error", text: 'Failed to verify rates. Please try again.'});
        }
    });
}

// Function to update status for a specific table row
function updateRateStatusForRow(row, status, message = '') {

    const statusElement = row.find("TD").eq(15).find(".rate-status"); // Status is in column 15
    const itemCode = row.find("TD").eq(0).html();
    const lineId = row.find("TD").eq(16).find("input").val();
    
    console.log(`Updating row - Item: ${itemCode}, Line: ${lineId}, Status: ${status}`);
    
    // Remove all status classes
    statusElement.removeClass('rate-pending rate-verified rate-failed rate-needs-approval');
    
    // Add appropriate class and text based on status
    switch(status) {
        case 'verified':
            statusElement.addClass('rate-verified').text('Verified');
            break;
        case 'failed':
            statusElement.addClass('rate-failed').text('Failed');
            if (message) {
                statusElement.attr('title', message);
            }
            break;
        case 'needs_approval':
            statusElement.addClass('rate-needs-approval').text('Not Verified');
            if (message) {
                statusElement.attr('title', message);
            }
            break;
        case 'pending':
            statusElement.addClass('rate-pending').text('Pending');
            break;
        default:
            statusElement.addClass('rate-pending').text('Pending');
            break;
    }
}

// Next to Proceed Action
function nextToProceedAction(id){
    var wh_id=$('#depo_id').val();
    if(wh_id==""){
        Swal.fire({title: 'Select Your Depo First.!!'});
        return false;
    }

    // Validate depot selection
    if (!validateDepotSelection()) {
        showDepotValidationError();
        return false;
    }
    
    // Validate order quantities
    const quantityValidation = validateOrderQuantities();
    if (!quantityValidation.isValid) {
        showQuantityValidationError(quantityValidation.errors);
        return false;
    }

    var matching_info = new Array();
    $("#tblMain TBODY TR").each(function () {
        var row = $(this);
        var dist_info = {};
        dist_info.item_code = row.find("TD").eq(0).html();
        dist_info.item_name = row.find("TD").eq(1).find("input").val();
        var depotSelect = row.find("TD").eq(13).find("select");
        dist_info.depo_code = depotSelect.find("option:selected").text().split('-')[0];
        dist_info.rate = row.find("TD").eq(14).find("input").val();
        matching_info.push(dist_info);
    });

    Swal.fire({
        title: 'Are you sure ??',
        text: "Do you want to send your approval mail..??",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then(function(isConfirm) {
        if(isConfirm.value==true){
            $.ajax({
                method: 'POST',
                url: "/send/approval_mail",
                data: {
                    'id': id, 
                    'wh_id':wh_id,
                    'matching_info': matching_info, 
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    console.log(data);
                    if(data=="Nm"){
                        Swal.fire({icon: "warning", title: "Oops...", text: "Rate verifying first..!!"});
                    } else if(data=="Am"){
                        Swal.fire({icon: "warning", title: "Oops...", text: "Your items already rate verified..!!"});
                    } else if(data=="As"){
                        Swal.fire({icon: "warning", title: "Oops...", text: "You already sent your approval mail..!!"});
                    } else if(data=="Ed"){
                        Swal.fire({icon: "success", title: "success", text: "Successfully sent to ED Sir..!!"});
                    } else if(data=="Md"){
                        Swal.fire({icon: "success", title: "success", text: "Successfully sent to MD Sir..!!"});
                    } else if(data=="S"){
                        Swal.fire({icon: "success", title: "success", text: "Successfully sent to Samia Madam..!!"});
                    } else if(data=="success"){
                        Swal.fire({icon: "success", title: "success", text: "There is no items for approval !!"});
                    }
                },
                error: function (e) {
                    console.log(e);
                }
            });
        } else {
            Swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
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
        $('#create_jo').prop('disabled', true);
        $('#mfg_date').val("");
        $('#delivery_date').val("");
    } else {
        $('#create_jo').prop('disabled', false);
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

function remove(tableID) {

    var table = document.getElementById(tableID).tBodies[0];
    var rowCount = table.rows.length;
    var checkedItems = [];  
    
    // First, collect all checked items with line_id
    for(var i = 0; i < rowCount; i++) {
        var row = table.rows[i];
        var chkbox = row.cells[17].getElementsByTagName('input')[0];
        if(null != chkbox && true == chkbox.checked) {
            var itemCode = row.cells[0].innerHTML;
            var itemName = row.cells[1].getElementsByTagName('input')[0].value;
            var lineId = row.cells[16].getElementsByTagName('input')[0].value;
            checkedItems.push({
                code: itemCode,
                name: itemName,
                lineId: lineId,
                index: i
            });
        }
    }
    
    // If no items are checked, show alert
    if (checkedItems.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'No Item Selection',
            text: 'Please check items to remove',
            confirmButtonText: 'OK'
        });
        return false;
    }
    
    // Show confirmation dialog
    Swal.fire({
        title: 'Confirm Removal',
        html: `Are you sure you want to remove ${checkedItems.length} item(s) from the table?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Remove!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send AJAX request to remove from backend first
            removeItemsFromBackend(checkedItems, table);
        }
    });
}

// Function to remove items from backend via AJAX
function removeItemsFromBackend(checkedItems, table) {
    // Show loading state
    Swal.fire({
        title: 'Removing Items...',
        text: 'Please wait while we remove the selected items',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Extract line_ids for backend deletion
    var lineIds = checkedItems.map(item => item.lineId);
    
    // Send AJAX request to remove from backend
    $.ajax({
        method: 'POST',
        url: "/remove/job_order/items", // Your backend endpoint
        data: {
            'line_ids': lineIds,
            'sale_contract_id': $('#sale_contract_id').val(),
            '_token': $('input[name=_token]').val()
        },
        success: function (response) {
            Swal.close();
            
            if (response.success) {
                // Backend removal successful - now remove from table
                removeItemsFromTable(checkedItems, table);
                
                Swal.fire({
                    icon: 'success',
                    title: 'Items Removed!',
                    text: checkedItems.length + ' item(s) successfully removed',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                // Backend removal failed
                Swal.fire({
                    icon: 'error',
                    title: 'Removal Failed',
                    text: response.message || 'Failed to remove items from system',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Network Error',
                text: 'Failed to remove items. Please try again.',
                confirmButtonText: 'OK'
            });
            console.error('Remove items error:', error);
        }
    });
}

// Function to remove items from HTML table
function removeItemsFromTable(checkedItems, table) {

    var removedCount = 0;  
    // Remove rows from table (working backwards to avoid index issues)
    for(var i = table.rows.length - 1; i >= 0; i--) {
        var row = table.rows[i];
        var chkbox = row.cells[17].getElementsByTagName('input')[0];
        if(null != chkbox && true == chkbox.checked) {
            table.deleteRow(i);
            removedCount++;
        }
    }
    
    // Update UI after removal
    updateOrderSummary();
    $('#selectAll').prop('checked', false);
    return removedCount;

}

function remove(tableID) {

    var table = document.getElementById(tableID).tBodies[0];
    var rowCount = table.rows.length;
    var checkedItems = [];  
    // First, collect all checked items with line_id
    for(var i = 0; i < rowCount; i++) {

        var row = table.rows[i];
        var chkbox = row.cells[17].getElementsByTagName('input')[0];
        if(null != chkbox && true == chkbox.checked) {
            var itemCode = row.cells[0].innerHTML;
            var itemName = row.cells[1].getElementsByTagName('input')[0].value;
            var lineId = row.cells[16].getElementsByTagName('input')[0].value;
            checkedItems.push({
                code: itemCode,
                name: itemName,
                lineId: lineId,
                index: i
            });
        }

    }
    
    // If no items are checked, show alert
    if (checkedItems.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'No Item Selection',
            text: 'Please check items to remove',
            confirmButtonText: 'OK'
        });
        return false;
    }
    
    // Show confirmation dialog
    Swal.fire({
        title: 'Confirm Removal',
        html: `Are you sure you want to remove ${checkedItems.length} item(s) from the table?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Remove!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send AJAX request to remove from backend first
            removeItemsFromBackend(checkedItems, table);
        }
    });
}

// Function to remove items from backend via AJAX
function removeItemsFromBackend(checkedItems, table) {
    // Show loading state
    Swal.fire({
        title: 'Removing Items...',
        text: 'Please wait while we remove the selected items',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Extract line_ids for backend deletion
    var lineIds = checkedItems.map(item => item.lineId);
    // Send AJAX request to remove from backend
    $.ajax({

        method: 'DELETE',
        url: "/delete/job/order/item", // Your backend endpoint
        data: {
            'line_ids': lineIds,
            '_token': $('input[name=_token]').val()
        },
        success: function (response) {

            Swal.close();  
            if (response.success) {
                
                removeItemsFromTable(checkedItems, table);
                Swal.fire({
                    icon: 'success',
                    title: 'Items Removed!',
                    text: checkedItems.length + ' item(s) successfully removed',
                    timer: 2000,
                    showConfirmButton: false
                });

            } else {
                
                Swal.fire({
                    icon: 'error',
                    title: 'Removal Failed',
                    text: response.message || 'Failed to remove items from system',
                    confirmButtonText: 'OK'
                });
            }

        },
        error: function (xhr, status, error) {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Network Error',
                text: 'Failed to remove items. Please try again.',
                confirmButtonText: 'OK'
            });
            console.error('Remove items error:', error);
        }
    });
}

// Function to remove items from HTML table
function removeItemsFromTable(checkedItems, table) {

    var removedCount = 0;
    // Remove rows from table (working backwards to avoid index issues)
    for(var i = table.rows.length - 1; i >= 0; i--) {
        var row = table.rows[i];
        var chkbox = row.cells[17].getElementsByTagName('input')[0];
        if(null != chkbox && true == chkbox.checked) {
            table.deleteRow(i);
            removedCount++;
        }
    }
    
    // Update UI after removal
    updateOrderSummary();
    $('#selectAll').prop('checked', false);
    return removedCount;

}

// Form Submission with All Validations
$('#insert_form').on('submit', function(event){

    event.preventDefault();
    $('#create_jo').prop('disabled', true);  
    // 1. Validate Basic Form Fields
    const basicValidation = validateBasicFormFields();
    if (!basicValidation.isValid) {
        showBasicValidationError(basicValidation.errors);
        $('#create_jo').prop('disabled', false);
        return false;
    }
    
    // 2. Validate order quantities before submission
    const quantityValidation = validateOrderQuantities();
    if (!quantityValidation.isValid) {
        showQuantityValidationError(quantityValidation.errors);
        $('#create_jo').prop('disabled', false);
        return false;
    }
    
    // 3. Validate depot selection
    if (!validateDepotSelection()) {
        showDepotValidationError();
        $('#create_jo').prop('disabled', false);
        return false;
    }
    
    // 4. Validate factory fields for all items
    if (!validateFactoryFields()) {
        showFactoryValidationError();
        $('#create_jo').prop('disabled', false);
        return false;
    }
    
    // 5. Validate DU Unit and RU Unit selection
    const unitValidation = validateUnitSelection();
    if (!unitValidation.isValid) {
        showUnitValidationError(unitValidation.errors);
        $('#create_jo').prop('disabled', false);
        return false;
    }
    
    // 6. Validate that all items are rate verified
    const verificationResult = validateAllItemsVerified();
    if (!verificationResult.isValid) {
        showRateVerificationError(verificationResult);
        $('#create_jo').prop('disabled', false);
        return false;
    }
    
    // 7. Validate required numeric fields
    const numericValidation = validateNumericFields();
    if (!numericValidation.isValid) {
        showNumericValidationError(numericValidation.errors);
        $('#create_jo').prop('disabled', false);
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
    $("#tblMain TBODY TR").each(function () {
        $(this).css('background-color', '');
        $(this).find("TD").eq(7).css('background-color', '');
        $(this).find("TD").eq(7).find("input").css('border', '');
        $(this).find('.quantity-warning').remove();
    });
    
    // Check each row for quantity validation
    $("#tblMain TBODY TR").each(function () {
        var row = $(this);
        var itemCode = row.find("TD").eq(0).html();
        var itemName = row.find("TD").eq(1).find("input").val();
        
        // Get sales contract quantity (from column 6 - SC Qty)
        var salesContractQty = parseInt(row.find("TD").eq(6).find("input").val()) || 0;
        
        // Get order quantity (from column 7 - ORQT)
        var orderQty = parseInt(row.find("TD").eq(7).find("input").val()) || 0;
        
        if (orderQty > salesContractQty) {
            hasErrors = true;
            
            // Highlight the row and quantity input
            row.css('background-color', '#fff3cd');
            row.find("TD").eq(7).css('background-color', '#ffeaa7');
            row.find("TD").eq(7).find("input").css('border', '2px solid #f39c12');
            
            errorMessages.push(`• ${itemName} (${itemCode}): Order Qty (${orderQty}) > Sales Contract Qty (${salesContractQty})`);
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
    $("#tblMain TBODY TR").each(function () {
        $(this).css('background-color', '');
        $(this).find("TD").eq(13).css('background-color', '');
        $(this).find("TD").eq(13).find("select").css('border', '');
    });
    
    $("#tblMain TBODY TR").each(function () {

        var row = $(this);
        var depotSelect = row.find("TD").eq(13).find("select");
        var depotValue = depotSelect.val();
        
        if (!depotValue || depotValue === "") {
            hasErrors = true;
            row.css('background-color', '#ffebee');
            row.find("TD").eq(13).css('background-color', '#ffcdd2');
            depotSelect.css('border', '2px solid #f44336');
        }

    });
    
    return !hasErrors;
}

// 4. Factory Fields Validation
function validateFactoryFields() {

    let isValid = true;  
    // Remove previous red backgrounds
    $("#tblMain TBODY TR").each(function () {
        var factorySelect = $(this).find("TD").eq(12).find("select");
        factorySelect.css('background-color', '');
    });
    
    // Check each row for factory value
    $("#tblMain TBODY TR").each(function () {
        var factorySelect = $(this).find("TD").eq(12).find("select");
        var factoryValue = factorySelect.val();
        
        if (factoryValue === "" || factoryValue === null) {
            factorySelect.css('background-color', '#f01736');
            isValid = false;
        }
    });
    
    return isValid;
}

// 5. Unit Selection Validation (DU Unit and RU Unit)
function validateUnitSelection() {

    let hasErrors = false;
    let errorMessages = [];
    
    $("#tblMain TBODY TR").each(function () {
        var row = $(this);
        var itemCode = row.find("TD").eq(0).html();
        var itemName = row.find("TD").eq(1).find("input").val();
        
        // Check DU Unit (column 5)
        var duUnitSelect = row.find("TD").eq(5).find("select");
        var duUnitValue = duUnitSelect.val();
        
        // Check RU Unit (column 9)
        var ruUnitSelect = row.find("TD").eq(9).find("select");
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

// 6. Rate Verification Validation
function validateAllItemsVerified() {
    let allVerified = true;
    let unverifiedItems = [];
    
    $("#tblMain TBODY TR").each(function () {
        var row = $(this);
        var statusElement = row.find("TD").eq(15).find(".rate-status");
        var currentStatus = statusElement.text().trim();
        var itemCode = row.find("TD").eq(0).html();
        var itemName = row.find("TD").eq(1).find("input").val();
        
        // Check if status is NOT "Verified"
        if (currentStatus !== 'Verified') {
            allVerified = false;
            unverifiedItems.push({
                code: itemCode,
                name: itemName,
                status: currentStatus
            });
            
            // Highlight unverified rows
            row.css('background-color', '#fff3cd');
            statusElement.css('border', '2px solid #f39c12');
        } else {
            // Remove highlighting for verified rows
            row.css('background-color', '');
            statusElement.css('border', '');
        }
    });
    
    return {
        isValid: allVerified,
        unverifiedItems: unverifiedItems
    };
}

// 7. Numeric Fields Validation
function validateNumericFields() {
    let hasErrors = false;
    let errorMessages = [];
    
    $("#tblMain TBODY TR").each(function () {
        var row = $(this);
        var itemCode = row.find("TD").eq(0).html();
        var itemName = row.find("TD").eq(1).find("input").val();
        
        // Check ORQT (column 7)
        var orqtInput = row.find("TD").eq(7).find("input");
        var orqtValue = orqtInput.val();
        
        // Check SMQT (column 8)
        var smqtInput = row.find("TD").eq(8).find("input");
        var smqtValue = smqtInput.val();
        
        if (!orqtValue || orqtValue === "" || isNaN(orqtValue) || parseInt(orqtValue) <= 0) {
            hasErrors = true;
            orqtInput.css('border', '2px solid #f44336');
            errorMessages.push(`• ${itemName} (${itemCode}): Order Quantity (ORQT) must be a valid positive number`);
        } else {
            orqtInput.css('border', '');
        }
        
        if (!smqtValue || smqtValue === "" || isNaN(smqtValue) || parseInt(smqtValue) < 0) {
            hasErrors = true;
            smqtInput.css('border', '2px solid #f44336');
            errorMessages.push(`• ${itemName} (${itemCode}): Sample Quantity (SMQT) must be a valid number`);
        } else {
            smqtInput.css('border', '');
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
        html: `Order quantity cannot exceed sales contract quantity:<br><br>${errorMessages.join('<br>')}`,
        confirmButtonText: 'OK',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            const firstErrorInput = $("#tblMain TBODY TR").find("TD").eq(7).find("input").filter(function() {
                var row = $(this).closest('tr');
                var salesContractQty = parseInt(row.find("TD").eq(6).find("input").val()) || 0;
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
            const firstEmptySelect = $("#tblMain TBODY TR").find("TD").eq(13).find("select").filter(function() {
                return !$(this).val() || $(this).val() === "";
            }).first();
            
            if (firstEmptySelect.length > 0) {
                firstEmptySelect.focus();
            }
        }
    });

}

function showFactoryValidationError() {

    Swal.fire({
        icon: 'warning', 
        title: 'Factory Selection Required', 
        text: 'Factory field cannot be empty for any item. Please select factory for all items.'
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

function showRateVerificationError(verificationCheck) {

    if (!verificationCheck.isValid) {
        let errorMessage = 'All items must be rate verified before submission.<br><br>';    
        Swal.fire({
            icon: 'error',
            title: 'Rate Verification Required',
            html: errorMessage,
            confirmButtonText: 'OK',
            confirmButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                const firstUnverifiedRow = $("#tblMain TBODY TR").filter(function() {
                    var status = $(this).find("TD").eq(15).find(".rate-status").text().trim();
                    return status !== 'Verified';
                }).first();
                
                if (firstUnverifiedRow.length > 0) {
                    $('.table-container').animate({
                        scrollTop: firstUnverifiedRow.offset().top - $('.table-container').offset().top + $('.table-container').scrollTop() - 50
                    }, 500);
                    
                    firstUnverifiedRow.css('background-color', '#fff3cd');
                    setTimeout(() => {
                        if (firstUnverifiedRow.find("TD").eq(15).find(".rate-status").text().trim() !== 'Verified') {
                            firstUnverifiedRow.css('background-color', '#fff3cd');
                        }
                    }, 2000);
                }
            }
        });
    }
}

function showNumericValidationError(errorMessages) {

    Swal.fire({
        icon: 'error',
        title: 'Invalid Numeric Values',
        html: `Please enter valid numeric values:<br><br>${errorMessages.join('<br>')}`,
        confirmButtonText: 'OK',
        confirmButtonColor: '#d33'
    });

}

// ===== FORM SUBMISSION FUNCTION =====

function submitFormData() {
    var sale_contact_id = document.getElementById('sale_contract_id').value;
    var importer_code = document.getElementById('importer_code').value;
    var importer_name = document.getElementById('importer_name').value;
    var importer_address = document.getElementById('importer_address').value;
    var shipping_mark = document.getElementById('shipping_mark').value;
    var note = document.getElementById('note').value;
    var issue_date = document.getElementById('issue_date').value;
    var delivery_date = document.getElementById('delivery_date').value;
    var mfg_date = document.getElementById('mfg_date').value;
    var batch_number = document.getElementById('batch_number').value;
    var imp_by = document.getElementById('imp_by').value;
    var distributed_by = document.getElementById('distributed_by').value;
    var invoice_no = document.getElementById('invoice_no').value;
    var bestBefore = $('#best_before').is(':checked') ? 1 : 0;
    var edit_id = document.getElementById('edit_id').value;
    var unit_data = $("#insert_form").serializeArray();
    var info_details = new Array();
    
    $("#tblMain TBODY TR").each(function () {
        var row = $(this);
        var dist_info = {};
        dist_info.item_code = row.find("TD").eq(0).html();
        dist_info.item_name = row.find("TD").eq(1).find("input").val();
        dist_info.self_life = row.find("TD").eq(2).find("input").val();
        dist_info.qty = row.find("TD").eq(3).find("input").val();
        dist_info.sale_contact_qty = row.find("TD").eq(6).find("input").val();
        dist_info.orqt = row.find("TD").eq(7).find("input").val();
        dist_info.smqt = row.find("TD").eq(8).find("input").val();
        dist_info.coding_matter = row.find("TD").eq(10).find("input").val();
        dist_info.sreq = row.find("TD").eq(11).find("input").val();
        
        // Get factory dropdown value (column 12)
        var factorySelect = row.find("TD").eq(12).find("select");
        dist_info.factory = factorySelect.val();
        
        dist_info.rate = row.find("TD").eq(14).find("input").val();
        dist_info.line_id = row.find("TD").eq(17).find("input").val();
        
        // Get DU Unit and RU Unit values
        var duUnitSelect = row.find("TD").eq(5).find("select");
        dist_info.du_unit = duUnitSelect.val();
        
        var ruUnitSelect = row.find("TD").eq(9).find("select");
        dist_info.ru_unit = ruUnitSelect.val();
        
        var depotSelect = row.find("TD").eq(13).find("select");
        dist_info.depot = depotSelect.val();
        info_details.push(dist_info);
    });

    if (info_details.length < 1) {
        Swal.fire({icon: 'warning', title: 'Alert!', text: 'Sales Contract Item Can Not Empty'});
        $('#create_jo').prop('disabled', false);
        return false;
    }

    // Show loading state
    Swal.fire({
        title: 'Updating Job Order...',
        text: 'Please wait while we process your request',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        method: 'POST',
        url: "/update/job_order",
        data: {
            'sale_contact_id': sale_contact_id,
            'importer_code': importer_code,
            'shipping_mark': shipping_mark,
            'note': note,
            'issue_date': issue_date,
            'delivery_date': delivery_date,
            'mfg_date': mfg_date,
            'batch_number': batch_number,
            'unit_data': unit_data,
            'bestBefore': bestBefore,
            'distributed_by': distributed_by,
            'imp_by': imp_by,
            'edit_id': edit_id,
            'info_details': info_details,
            '_token': $('input[name=_token]').val()
        },
        success: function (response) {

            Swal.close();
            if (response.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: response.message || "Job Order updated successfully!",
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Update Failed",
                    text: response.message || "There was an error updating the job order.",
                    confirmButtonText: 'OK'
                });
            }
            $('#create_jo').prop('disabled', false);

        },
        error: function (xhr, status, error) {
            Swal.close();
            console.log(xhr.responseText);
            Swal.fire({
                icon: "error",
                title: "Network Error",
                text: "Failed to update the form. Please check your connection and try again.",
                confirmButtonText: 'OK'
            });
            $('#create_jo').prop('disabled', false);
        }
    });
}
// ===== REAL-TIME VALIDATION =====

// Real-time validation for factory fields
$(document).on('change', '#tblMain TBODY TR TD select', function() {
    var select = $(this);
    var value = select.val();
    
    // Check if this is a factory dropdown (column index 12)
    var cellIndex = select.closest('td').index();
    if (cellIndex === 12) {
        if (value === "" || value === null) {
            select.css('background-color', '#ffcccc');
        } else {
            select.css('background-color', '');
        }
    }
});

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