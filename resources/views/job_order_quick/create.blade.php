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
    background: #a4a4a438;
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
          <div class="section-header">JO Create Form</div>
          <div class="box-body">
            <div class="row">    
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Party Code<span class="req_style_id">*</span></label>
                  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <input type="text" class="form-control input-sm" name="importer_code" id="importer_code" value="@if(!empty($importer_code)){{$importer_code}}@endif" readonly>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Party Name<span class="req_style_id">*</span></label>
                  <input type="text" class="form-control input-sm" name="importer_name" id="importer_name" value="@if(!empty($importer_name)){{$importer_name}}@endif" readonly>
                  <input type="hidden" id="sale_contract_id" name="sale_contract_id" value="{{$sale_contract_id}}">
                  @if ($errors->has('name'))
                    <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                  @endif
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Party Address<span class="req_style_id">*</span></label>
                  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <textarea class="form-control input-sm" id="importer_address" readonly style="height: 30px;">{{$sale_contract->party_address}}</textarea>
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
                  <input name="text" type="text" class="form-control input-sm" id="issue_date" value="<?php echo $date = date('d-m-Y')?>" readonly>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Delivery Date<span class="req_style_id">*</span></label>
                  <input name="dated" type="text" id="delivery_date" class="form-control datepicker input-sm" value="@if(!empty($delivery_date)){{$delivery_date}}@endif" placeholder="Select Delivery Date">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">MFG Date<span class="req_style_id">*</span></label>
                  <input type="text" class="form-control input-sm" name="" value="@if(!empty($mfg_date)){{$mfg_date}}@endif" id="mfg_date" readonly placeholder="Auto Select">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Note<span class="req_style_id">*</span></label>
                  <input type="text" class="form-control input-sm" name="" value="@if(!empty($note)){{$note}} @else {{$invoice_no}} @endif" id="note">
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
                  <textarea class="form-control input-sm" id="shipping_mark" style="height: 30px;">@if(!empty($shipping_mark)){{$shipping_mark}}@endif</textarea>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Batch No</label>
                  <input name="text" type="text" class="form-control input-sm" id="batch_number" value="@if(!empty($batch_number)){{$batch_number}}@endif" placeholder="Enter Batch Number">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">IMP BY</label>
                  <input name="text" type="text" class="form-control input-sm" id="imp_by" value="@if(!empty($imp_by)){{$imp_by}}@endif" placeholder="Enter IMP By">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Distributed By</label>
                  <input name="distributed_by" type="text" class="form-control input-sm" id="distributed_by" value="@if(!empty($distributed_by)){{$distributed_by}}@endif" placeholder="Enter Distributed By">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-3">
                <div class="inline-form-group">
                  <label for="dated">Best Before</label>
                  <input id="best_before" type="checkbox" value="1" name="best_before">
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
                        <th style="width:250px">Item Name</th>
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
                        <th style="width: 111px;">
                          <span>Depot</span>
                          <select name="dunit" id="dunit" class="table-select">
                            <option value="">Select</option>
                            @foreach($depots as $depot)
                            <option value="{{$depot->p_code}}">{{$depot->p_code}}</option>
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
                      @if(!empty($salesContactItems))
                      @foreach($salesContactItems as $sale_contract_detail)
                        <tr>
                          <td>{{$sale_contract_detail->ci_item_code}}</td>
                          <td><input type="text" value="{{$sale_contract_detail->ci_item_name}}" class="table-input" title="{{$sale_contract_detail->ci_item_name}}"></td>
                          <td><input type="text" value="{{$sale_contract_detail->self_line}}" class="table-input" readonly></td>
                          <td><input type="number" value="{{$sale_contract_detail->qty}}" class="table-input ctn-qty"></td>
                          <td><input type="number" value="{{$sale_contract_detail->factor}}" class="table-input factor" readonly></td>
                          <td>
                            <select name="dunit" id="dunit" class="table-select">
                              <option value="">Select</option>
                              @foreach($dunits as $dunit)
                                <option value="{{$dunit->id}}" @if($dunit->id==$sale_contract_detail->du_unit) {{'selected'}}@endif>{{$dunit->dunit_name}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td><input type="text" value="{{$sale_contract_detail->pcs_in_ctn}}" class="table-input sc-qty" readonly></td>
                          <td><input type="number" value="{{$sale_contract_detail->pcs_in_ctn}}" class="table-input navigateTest order-qty" readonly></td>
                          <td><input type="number" value="{{$sale_contract_detail->sample_qty}}" class="table-input smqt"></td>
                          <td>
                            <select name="runit" id="runit" class="table-select">
                              <option value="">Select</option>
                              @foreach($runits as $runit)
                                <option value="{{$runit->id}}" @if($runit->id==$sale_contract_detail->ru_unit) {{'selected'}}@endif>{{$runit->runit_name}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td><input type="text" value="{{$sale_contract_detail->coding_mater}}" class="table-input coding_matter" data-original-text="{{$sale_contract_detail->coding_mater}}"></td>
                          <td><input type="text" value="{{$sale_contract_detail->special_requirment}}" class="table-input special-requirement" data-original-text="{{$sale_contract_detail->special_requirment}}"></td>
                          <td>
                            <select name="dunit" id="dunit" class="table-select">
                              <option value="">Select</option>
                              @foreach($depots as $depot)
                              <option value="{{$depot->p_code}}" @if($depot->p_code==$sale_contract_detail->p_code){{'selected'}}@endif>{{$depot->p_code}}-{{$depot->p_name}}</option>
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
                
                <!-- UPDATED: Order Summary Section (Starts collapsed by default) -->
                <div class="order-summary">
                    <div class="summary-header" id="summaryToggle">
                        <div class="summary-header-left">
                            <i class="fas fa-clipboard-list"></i>
                            <h3 class="summary-title">Order Summary</h3>
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
                            <span class="summary-label"><i class="fas fa-boxes"></i> Total Carton Qty:</span>
                            <span class="summary-value" id="totalCartonQty">0</span>
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
                    <input type="button" class="btn btn-primary btn-sm rate_varifying_btn_id" id="{{$sale_contract_id}}" value="Rate Verifying" onclick="rateVerifying(this.id)">
                    <button type="button" onclick="remove('tblMain');" class="btn btn-danger btn-sm">Remove</button>
                    <input type="submit" name="submit" class="btn btn-success btn-sm" id="create_jo" value="Create"/>
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
  // ===== GLOBAL VARIABLES =====
  let currentDepotFilter = ''; // Track current depot filter
  
  // ===== GLOBAL FUNCTIONS =====
  
  // NEW: Function to enable/disable action buttons based on visible rows
  function updateActionButtonsState() {
      const visibleRows = $("#tblMain TBODY TR:visible").not('.no-records-message').length;
      const hasVisibleRows = visibleRows > 0;
      
      // Disable buttons if no visible rows
      $('.rate_varifying_btn_id, #create_jo, .btn-danger').prop('disabled', !hasVisibleRows);
      
      // Add visual feedback for disabled state
      if (!hasVisibleRows) {
          $('.rate_varifying_btn_id, #create_jo, .btn-danger').css('opacity', '0.6');
          $('.rate_varifying_btn_id, #create_jo, .btn-danger').attr('title', 'No items available for action');
      } else {
          $('.rate_varifying_btn_id, #create_jo, .btn-danger').css('opacity', '1');
          $('.rate_varifying_btn_id, #create_jo, .btn-danger').removeAttr('title');
          
          // Re-check quantity validation for create button
          checkOrderQuantitiesAndDisableButton();
      }
  }

  // NEW: Function to filter items by depot - ONLY show matching depot items
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

  // Function to check if any order quantity exceeds contract quantity and disable button
  function checkOrderQuantitiesAndDisableButton() {
      // First check if there are any visible rows
      const visibleRows = $("#tblMain TBODY TR:visible").not('.no-records-message').length;
      if (visibleRows === 0) {
          $('#create_jo').prop('disabled', true);
          $('#create_jo').css('opacity', '0.6');
          $('#create_jo').attr('title', 'No items available for action');
          return false;
      }
      
      let hasExceededQuantity = false;
      
      $("#tblMain TBODY TR:visible").each(function () {
          var row = $(this);
          var salesContractQty = parseInt(row.find("TD").eq(6).find("input").val()) || 0;
          var orderQty = parseInt(row.find("TD").eq(7).find("input").val()) || 0;
          
          if (orderQty > salesContractQty) {
              hasExceededQuantity = true;
              return false; // Break out of the loop early
          }
      });
      
      // Disable or enable the create button based on validation
      if (hasExceededQuantity) {
          $('#create_jo').prop('disabled', true);
          $('#create_jo').css('opacity', '0.6');
          $('#create_jo').attr('title', 'Cannot create JO: Some items exceed contract quantity');
      } else {
          $('#create_jo').prop('disabled', false);
          $('#create_jo').css('opacity', '1');
          $('#create_jo').removeAttr('title');
      }
      
      return !hasExceededQuantity;
  }

  // Order Summary Function
  function updateOrderSummary() {
      let totalItems = 0;
      let totalCartonQty = 0;
      let smqtQuantity = 0;
      let grandTotal = 0;

      $("#tblMain TBODY TR:visible").each(function () {
          totalItems++;
          let row = $(this);
          let cartonQty = parseInt(row.find("TD").eq(3).find("input").val()) || 0;
          let smqt = parseInt(row.find("TD").eq(8).find("input").val()) || 0;
          let rate = parseFloat(row.find("TD").eq(13).find("input").val()) || 0;
          let orderQty = parseInt(row.find("TD").eq(7).find("input").val()) || 0;
          
          totalCartonQty += cartonQty;
          smqtQuantity += smqt;
          grandTotal += rate * orderQty;
      });

      $('#totalItems').text(totalItems);
      $('#totalCartonQty').text(totalCartonQty);
      $('#smqtQuantity').text(smqtQuantity);
      $('#grandTotal').val('$' + grandTotal.toFixed(2));
  }

  // Function to update rate verification status
  function updateRateStatus(itemCode, status, message = '') {
      const statusElement = $(`#rate-status-${itemCode}`);  
      statusElement.removeClass('rate-pending rate-verified rate-failed rate-needs-approval');
      
      switch(status) {
          case 'verified':
              statusElement.addClass('rate-verified').text('Verified');
              break;
          case 'failed':
              statusElement.addClass('rate-failed').text('Failed');
              if (message) statusElement.attr('title', message);
              break;
          case 'needs_approval':
              statusElement.addClass('rate-needs-approval').text('Not Verified');
              if (message) statusElement.attr('title', message);
              break;
          default:
              statusElement.addClass('rate-pending').text('Pending');
              break;
      }
  }

  // Function to update status for a specific table row
  function updateRateStatusForRow(row, status, message = '') {
      const statusElement = row.find("TD").eq(14).find(".rate-status");
      const itemCode = row.find("TD").eq(0).html();
      const lineId = row.find("TD").eq(15).find("input").val();
      
      statusElement.removeClass('rate-pending rate-verified rate-failed rate-needs-approval');
      
      switch(status) {
          case 'verified':
              statusElement.addClass('rate-verified').text('Verified');
              break;
          case 'failed':
              statusElement.addClass('rate-failed').text('Failed');
              if (message) statusElement.attr('title', message);
              break;
          case 'needs_approval':
              statusElement.addClass('rate-needs-approval').text('Not Verified');
              if (message) statusElement.attr('title', message);
              break;
          case 'pending':
              statusElement.addClass('rate-pending').text('Pending');
              break;
          default:
              statusElement.addClass('rate-pending').text('Pending');
              break;
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
                      '<div class="no-records-subtitle">No results found for "<strong>' + 
                      escapeHtml(searchTerm) + 
                      '</strong>"</div>' +
                      '<div class="no-records-tips">' +
                      '</div>';
              }
              
              var messageRow = '<tr class="no-records-message">' +
                  '<td colspan="16" style="text-align: center; padding: 17px 20px; background-color: #f8f9fa;">' +
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

  // Date Handling Functions
  function formatDate(date) {
      var year = date.getFullYear();
      var month = ('0' + (date.getMonth() + 1)).slice(-2);
      var day = ('0' + date.getDate()).slice(-2);
      return day + '-' + month + '-' + year;
  }

  // Function to calculate order quantity from carton quantity
  function calculateOrderQtyFromCtnQty(ctnQtyInput) {
      const row = ctnQtyInput.closest('tr');
      const ctnQty = parseInt(ctnQtyInput.val()) || 0;
      const factor = parseInt(row.find('.factor').val()) || 1;
      const orderQtyInput = row.find('.order-qty');
      
      const calculatedOrderQty = ctnQty * factor;
      orderQtyInput.val(calculatedOrderQty);
      
      updateOrderSummary();
      checkOrderQuantitiesAndDisableButton();
  }

  // Function to calculate carton quantity from order quantity
  function calculateCtnQtyFromOrderQty(orderQtyInput) {
      const row = orderQtyInput.closest('tr');
      const orderQty = parseInt(orderQtyInput.val()) || 0;
      const factor = parseInt(row.find('.factor').val()) || 1;
      const ctnQtyInput = row.find('.ctn-qty');
      
      if (factor > 0) {
          const calculatedCtnQty = orderQty / factor;
          
          if (Number.isInteger(calculatedCtnQty)) {
              ctnQtyInput.val(calculatedCtnQty);
          } else {
              Swal.fire({
                  icon: 'error',
                  title: 'Invalid Quantity',
                  html: `Order quantity (${orderQty}) divided by factor (${factor}) results in a fractional carton quantity (${calculatedCtnQty.toFixed(2)}).<br><br>Please enter an order quantity that is a multiple of ${factor}.`,
                  confirmButtonText: 'OK'
              });
              
              const previousOrderQty = parseInt(orderQtyInput.attr('data-previous-value')) || 0;
              orderQtyInput.val(previousOrderQty);
              return false;
          }
          
          updateOrderSummary();
          checkOrderQuantitiesAndDisableButton();
      }
      
      return true;
  }

  // Function to validate carton quantities are whole numbers
  function validateCtnQuantities() {
      let hasFractionalValues = false;
      let fractionalItems = [];
      
      $("#tblMain TBODY TR").each(function () {
          const row = $(this);
          const ctnQtyInput = row.find('.ctn-qty');
          const ctnQty = parseFloat(ctnQtyInput.val());
          const itemCode = row.find("TD").eq(0).html();
          const itemName = row.find("TD").eq(1).find("input").val();
          
          if (!Number.isInteger(ctnQty) && !isNaN(ctnQty)) {
              hasFractionalValues = true;
              fractionalItems.push({
                  code: itemCode,
                  name: itemName,
                  quantity: ctnQty
              });
              
              ctnQtyInput.css('border', '2px solid #dc3545');
              ctnQtyInput.css('background-color', '#f8d7da');
          } else {
              ctnQtyInput.css('border', '');
              ctnQtyInput.css('background-color', '');
          }
      });
      
      return {
          isValid: !hasFractionalValues,
          fractionalItems: fractionalItems
      };
  }

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
      
      $("#tblMain TBODY TR").each(function () {
          $(this).css('background-color', '');
          $(this).find("TD").eq(7).css('background-color', '');
          $(this).find("TD").eq(7).find("input").css('border', '');
          $(this).find('.quantity-warning').remove();
      });
      
      $("#tblMain TBODY TR").each(function () {
          var row = $(this);
          var itemCode = row.find("TD").eq(0).html();
          var itemName = row.find("TD").eq(1).find("input").val();
          var salesContractQty = parseInt(row.find("TD").eq(6).find("input").val()) || 0;
          var orderQty = parseInt(row.find("TD").eq(7).find("input").val()) || 0;
          
          if (orderQty > salesContractQty) {
              hasErrors = true;
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
          $(this).find("TD").eq(12).css('background-color', '');
          $(this).find("TD").eq(12).find("select").css('border', '');
      });
      
      $("#tblMain TBODY TR").each(function () {
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
      
      $("#tblMain TBODY TR").each(function () {
          var row = $(this);
          var itemCode = row.find("TD").eq(0).html();
          var itemName = row.find("TD").eq(1).find("input").val();
          
          var duUnitSelect = row.find("TD").eq(5).find("select");
          var duUnitValue = duUnitSelect.val();
          
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

  // 5. Rate Verification Validation
  function validateAllItemsVerified() {
      let allVerified = true;
      let unverifiedItems = [];
      
      $("#tblMain TBODY TR").each(function () {
          var row = $(this);
          var statusElement = row.find("TD").eq(14).find(".rate-status");
          var currentStatus = statusElement.text().trim();
          var itemCode = row.find("TD").eq(0).html();
          var itemName = row.find("TD").eq(1).find("input").val();
          
          if (currentStatus !== 'Verified') {
              allVerified = false;
              unverifiedItems.push({
                  code: itemCode,
                  name: itemName,
                  status: currentStatus
              });
              row.css('background-color', '#fff3cd');
              statusElement.css('border', '2px solid #f39c12');
          } else {
              row.css('background-color', '');
              statusElement.css('border', '');
          }
      });
      
      return {
          isValid: allVerified,
          unverifiedItems: unverifiedItems
      };
  }

  // 6. Numeric Fields Validation
  function validateNumericFields() {
      let hasErrors = false;
      let errorMessages = [];
      
      $("#tblMain TBODY TR").each(function () {
          var row = $(this);
          var itemCode = row.find("TD").eq(0).html();
          var itemName = row.find("TD").eq(1).find("input").val();
          
          var orqtInput = row.find("TD").eq(7).find("input");
          var orqtValue = orqtInput.val();
          
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

  // Carton Quantity Validation (Fraction Check)
  function showCtnFractionError(fractionalItems) {
      let errorMessage = 'Carton quantities cannot be fractional values:<br><br>';
      fractionalItems.forEach(item => {
          errorMessage += `• ${item.name} (${item.code}): ${item.quantity}<br>`;
      });
      errorMessage += '<br>Please adjust order quantities to avoid fractional carton values.';
      
      Swal.fire({
          icon: 'error',
          title: 'Fractional Carton Quantities',
          html: errorMessage,
          confirmButtonText: 'OK',
          confirmButtonColor: '#d33'
      });
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
              const firstEmptySelect = $("#tblMain TBODY TR").find("TD").eq(12).find("select").filter(function() {
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
                      var status = $(this).find("TD").eq(14).find(".rate-status").text().trim();
                      return status !== 'Verified';
                  }).first();
                  
                  if (firstUnverifiedRow.length > 0) {
                      $('.table-container').animate({
                          scrollTop: firstUnverifiedRow.offset().top - $('.table-container').offset().top + $('.table-container').scrollTop() - 50
                      }, 500);
                      
                      firstUnverifiedRow.css('background-color', '#fff3cd');
                      setTimeout(() => {
                          if (firstUnverifiedRow.find("TD").eq(14).find(".rate-status").text().trim() !== 'Verified') {
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
      var unit_data = $("#insert_form").serializeArray();
      var info_details = new Array();
      
      $("#tblMain TBODY TR").each(function () {
          var row = $(this);
          var dist_info = {};
          dist_info.item_code = row.find("TD").eq(0).html();
          dist_info.item_name = row.find("TD").eq(1).find("input").val();
          dist_info.self_life = row.find("TD").eq(2).find("input").val();
          dist_info.qty = row.find("TD").eq(3).find("input").val();
          dist_info.factor = row.find("TD").eq(4).find("input").val();
          dist_info.sale_contact_qty = row.find("TD").eq(6).find("input").val();
          dist_info.orqt = row.find("TD").eq(7).find("input").val();
          dist_info.smqt = row.find("TD").eq(8).find("input").val();
          dist_info.coding_matter = row.find("TD").eq(10).find("input").val();
          dist_info.sreq = row.find("TD").eq(11).find("input").val();
          dist_info.rate = row.find("TD").eq(13).find("input").val();
          dist_info.line_id = row.find("TD").eq(15).find("input").val();
          
          var duUnitSelect = row.find("TD").eq(5).find("select");
          dist_info.du_unit = duUnitSelect.val();
          
          var ruUnitSelect = row.find("TD").eq(9).find("select");
          dist_info.ru_unit = ruUnitSelect.val();
          
          var depotSelect = row.find("TD").eq(12).find("select");
          dist_info.depot = depotSelect.val();
          info_details.push(dist_info);
      });    

      if (info_details.length < 1) {
          Swal.fire({icon: 'warning', title: 'Alert!', text: 'Sales Contract Item Can Not Empty'});
          $('#create_jo').prop('disabled', false);
          return false;
      }

      Swal.fire({
          title: 'Creating Job Order...',
          text: 'Please wait while we process your request',
          allowOutsideClick: false,
          didOpen: () => {
              Swal.showLoading();
          }
      });

      $.ajax({
          method: 'POST',
          url: "/create/job_order",
          data: {
              'info_details': info_details,
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
              '_token': $('input[name=_token]').val()
          },
          success: function (response) {
            Swal.close();
            console.log(response);
            if (response.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    html: "JO Created Successfully!<br><br><strong>Job Order Number: " + response.job_order_number + "</strong>",
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Submission Failed",
                    text: response.message || "There was an error creating the job order.",
                    confirmButtonText: 'OK'
                });
            }
            $('#create_jo').prop('disabled', false);
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
              $('#create_jo').prop('disabled', false);
          }
      });
  }

  // ===== EVENT HANDLERS =====

  $(document).ready(function () {
      // Initialize button state on page load
      setTimeout(function() {
          checkOrderQuantitiesAndDisableButton();
          updateActionButtonsState();
      }, 500);
      
      $(document).on('DOMSubtreeModified', '#tblMain tbody', function() {
          setTimeout(function() {
              checkOrderQuantitiesAndDisableButton();
              updateActionButtonsState();
          }, 100);
      });

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

      // Carton Qty to Order Qty synchronization
      $("#tblMain").on('input', '.ctn-qty', function () {
          calculateOrderQtyFromCtnQty($(this));
      });

      // Order Qty to Carton Qty synchronization
      $("#tblMain").on('input', '.order-qty', function () {
          const input = $(this);
          input.attr('data-previous-value', input.val());
          calculateCtnQtyFromOrderQty(input);
      });

      // Coding Matter Editor
      $("#tblMain").on('click', '.coding_matter', function () {
        var targetCell = $(this);
        var currentText = targetCell.val() || '';
        var formattedText = currentText.trim().replace(/\s+/g, ' ');
        formattedText = formattedText.replace(/#\s*/g, '\n# ');
        formattedText = formattedText.replace(/(\d+\.)/g, '\n$1');
        formattedText = formattedText.replace(/\.([A-Z])/g, '.\n$1');
        formattedText = formattedText.replace(/\n{2,}/g, '\n').replace(/^\n/, '');

        var tempTextarea = $('<textarea style="width: 100%; height: 180px; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-family: Arial, sans-serif; resize: vertical;">' + formattedText + '</textarea>');

        Swal.fire({
            title: 'Edit Coding Matter',
            html: tempTextarea[0],
            width: 600,
            showCancelButton: true,
            confirmButtonText: 'Save Changes',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            preConfirm: () => {
                var newText = tempTextarea.val().trim();
                if (!newText) {
                    Swal.showValidationMessage('You need to write something!');
                    return false;
                }
                return newText;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                targetCell.val(result.value);
            }
        });
        setTimeout(() => tempTextarea.focus(), 100);
      });

      // Special Requirement Editor
      $("#tblMain").on('click', '.special-requirement', function () {
        var targetCell = $(this);
        var currentText = targetCell.val() || '';
        var formattedText = currentText.trim().replace(/\s+/g, ' ');
        formattedText = formattedText.replace(/#\s*/g, '\n# ');
        formattedText = formattedText.replace(/(\d+\.)/g, '\n$1');
        formattedText = formattedText.replace(/\.([A-Z])/g, '.\n$1');
        formattedText = formattedText.replace(/\n{2,}/g, '\n').replace(/^\n/, '');

        var tempTextarea = $('<textarea style="width: 100%; height: 200px; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-family: Arial, sans-serif; resize: vertical;">' + formattedText + '</textarea>');

        Swal.fire({
            title: 'Edit Special Requirement',
            html: tempTextarea[0],
            width: 600,
            showCancelButton: true,
            confirmButtonText: 'Save Changes',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            preConfirm: () => {
                return tempTextarea.val().trim();
            }
        }).then((result) => {
            if (result.isConfirmed) {
                targetCell.val(result.value);
            }
        });
        setTimeout(() => tempTextarea.focus(), 100);
      });

      // Real-time validation when depot select changes
      $("#tblMain").on('change', 'tbody select', function () {
          var row = $(this).closest('tr');
          var depotValue = $(this).val();
          var selectElement = $(this);
          
          if (depotValue && depotValue !== "") {
              row.css('background-color', '');
              row.find("TD").eq(12).css('background-color', '');
              selectElement.css('border', '');
          } else {
              row.css('background-color', '#ffebee');
              row.find("TD").eq(12).css('background-color', '#ffcdd2');
              selectElement.css('border', '2px solid #f44336');
          }
      });

      // Real-time quantity validation
      $("#tblMain").on('input', 'td:nth-child(8) input', function () {
          var row = $(this).closest('tr');
          var salesContractQty = parseInt(row.find("TD").eq(6).find("input").val()) || 0;
          var orderQty = parseInt($(this).val()) || 0;
          var quantityInput = $(this);
          
          if (orderQty > salesContractQty) {
              row.css('background-color', '#fff3cd');
              row.find("TD").eq(7).css('background-color', '#ffeaa7');
              quantityInput.css('border', '2px solid #f39c12');
              
              if (!row.find('.quantity-warning').length) {
                  row.find("TD").eq(7).append('<div class="quantity-warning" style="color: #e74c3c; font-size: 10px; margin-top: 2px;">Exceeds contract quantity</div>');
              }
          } else {
              row.css('background-color', '');
              row.find("TD").eq(7).css('background-color', '');
              quantityInput.css('border', '');
              row.find('.quantity-warning').remove();
          }
          
          updateOrderSummary();
          checkOrderQuantitiesAndDisableButton();
      });
      
      $("#tblMain").on('input', 'td:nth-child(7) input', function () {
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
          checkOrderQuantitiesAndDisableButton();
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

      // Toggle order summary visibility
      $('#summaryToggle').click(function () {
          $('#summaryContent').slideToggle(300, function () {
              if ($('#summaryContent').is(':visible')) {
                  $('#toggleIcon').removeClass('fa-plus').addClass('fa-minus');
                  $('#summaryContent').removeClass('collapsed');
              } else {
                  $('#toggleIcon').removeClass('fa-minus').addClass('fa-plus');
                  $('#summaryContent').addClass('collapsed');
              }
          });
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

      // Recalculate order summary on input changes
      $('#tblMain').on('input', 'input', function () {
          updateOrderSummary();
          updateActionButtonsState();
      });
  });

  // ===== FORM SUBMISSION HANDLER =====

  $('#insert_form').on('submit', function(event){
      event.preventDefault();
      
      const visibleRows = $("#tblMain TBODY TR:visible").not('.no-records-message').length;
      if (visibleRows === 0) {
          Swal.fire({
              icon: 'warning',
              title: 'No Items Available',
              text: 'There are no items to create job order for.',
              confirmButtonText: 'OK'
          });
          return false;
      }
      
      $('#create_jo').prop('disabled', true);  
      
      const ctnValidation = validateCtnQuantities();
      if (!ctnValidation.isValid) {
          showCtnFractionError(ctnValidation.fractionalItems);
          $('#create_jo').prop('disabled', false);
          return false;
      }
      
      const basicValidation = validateBasicFormFields();
      if (!basicValidation.isValid) {
          showBasicValidationError(basicValidation.errors);
          $('#create_jo').prop('disabled', false);
          return false;
      }
      
      if (!checkOrderQuantitiesAndDisableButton()) {
          let firstErrorItem = '';
          $("#tblMain TBODY TR").each(function () {
              var row = $(this);
              var salesContractQty = parseInt(row.find("TD").eq(6).find("input").val()) || 0;
              var orderQty = parseInt(row.find("TD").eq(7).find("input").val()) || 0;
              var itemName = row.find("TD").eq(1).find("input").val();
              var itemCode = row.find("TD").eq(0).html();
              
              if (orderQty > salesContractQty && !firstErrorItem) {
                  firstErrorItem = `${itemName} (${itemCode})`;
              }
          });
          
          Swal.fire({
              icon: 'error',
              title: 'Quantity Validation Failed',
              html: `Order quantity cannot exceed sales contract quantity.<br><br>Please fix the quantities before creating JO.`,
              confirmButtonText: 'OK',
              confirmButtonColor: '#d33'
          });
          $('#create_jo').prop('disabled', true);
          return false;
      }
      
      if (!validateDepotSelection()) {
          showDepotValidationError();
          $('#create_jo').prop('disabled', false);
          return false;
      }
      
      const unitValidation = validateUnitSelection();
      if (!unitValidation.isValid) {
          showUnitValidationError(unitValidation.errors);
          $('#create_jo').prop('disabled', false);
          return false;
      }
      
      const verificationResult = validateAllItemsVerified();
      if (!verificationResult.isValid) {
          showRateVerificationError(verificationResult);
          $('#create_jo').prop('disabled', false);
          return false;
      }
      
      const numericValidation = validateNumericFields();
      if (!numericValidation.isValid) {
          showNumericValidationError(numericValidation.errors);
          $('#create_jo').prop('disabled', false);
          return false;
      }
      
      submitFormData();
  });

  // ===== OTHER FUNCTIONS =====

  function rateVerifying(id){
      const visibleRows = $("#tblMain TBODY TR:visible").not('.no-records-message').length;
      if (visibleRows === 0) {
          Swal.fire({
              icon: 'warning',
              title: 'No Items Available',
              text: 'There are no items to verify rates for.',
              confirmButtonText: 'OK'
          });
          return false;
      }

      if(!validateDepotSelection()) {
          showDepotValidationError();
          return false;
      }
      
      const quantityValidation = validateOrderQuantities();
      if (!quantityValidation.isValid) {
          showQuantityValidationError(quantityValidation.errors);
          return false;
      }
      
      var matching_info = new Array();
      var pendingItemsCount = 0;
      
      $("#tblMain TBODY TR").each(function () {
          var row = $(this);
          var statusElement = row.find("TD").eq(14).find(".rate-status");
          var currentStatus = statusElement.text().trim();
          if (currentStatus === 'Pending') {
              var dist_info = {};
              dist_info.item_code = row.find("TD").eq(0).html();
              dist_info.item_name = row.find("TD").eq(1).find("input").val();
              var depotSelect = row.find("TD").eq(12).find("select");
              dist_info.depo_code = depotSelect.val();
              dist_info.rate = row.find("TD").eq(13).find("input").val();
              dist_info.line_id = row.find("TD").eq(15).find("input").val();
              dist_info.current_status = currentStatus;
              matching_info.push(dist_info);
              pendingItemsCount++;
          }
      });

      if (pendingItemsCount === 0) {
          Swal.fire({
              icon: "info",
              title: "No Pending Items",
              text: "All items have already been verified. No pending items to verify."
          });
          return false;
      }

      $('.rate_varifying_btn_id').prop('disabled', true).val('Verifying...');
      
      $("#tblMain TBODY TR").each(function () {
          var row = $(this);
          var statusElement = row.find("TD").eq(14).find(".rate-status");
          var currentStatus = statusElement.text().trim();
          
          if (currentStatus === 'Pending') {
              updateRateStatusForRow(row, 'pending');
          }
      });

      $.ajax({
          method: 'POST',
          url: "/quick_order/rate_matching",
          data: {
              'id': id, 
              'matching_info': matching_info, 
              '_token': $('input[name=_token]').val()
          },
          success: function (response) {
              console.log('Rate verification response:', response);
              
              $('.rate_varifying_btn_id').prop('disabled', false).val('Rate Verifying');
              if (response && response.item_statuses) {
                  let updatedItemsCount = 0;
                  $("#tblMain TBODY TR").each(function (index) {
                      var row = $(this);
                      var itemCode = row.find("TD").eq(0).html();
                      var lineId = row.find("TD").eq(15).find("input").val();
                      const itemStatus = response.item_statuses.find(status => 
                          status.item_code === itemCode
                      );
                      
                      if (itemStatus) {
                          console.log(`Updating row ${index}:`, itemCode, 'with status:', itemStatus.status);
                          updateRateStatusForRow(row, itemStatus.status, itemStatus.message);
                          updatedItemsCount++;
                      }
                  });
                  
                  if (response.overall_status === 'success') {
                      Swal.fire({
                          icon: "success", 
                          title: "Success!", 
                          text: `Successfully verified ${updatedItemsCount} pending item(s)!`
                      });
                  } else if (response.overall_status === 'needs_approval') {
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
                  
              } else if (typeof response === 'string' && (response == "Ed" || response == "Md" || response == "S" || response == "success")) {
                  console.log('Old format response detected:', response);
                  
                  let status = 'needs_approval';
                  let message = 'Not Verified';
                  
                  if (response === "success") {
                      status = 'verified';
                      message = 'Verified';
                  }
                  
                  $("#tblMain TBODY TR").each(function () {
                      var row = $(this);
                      var statusElement = row.find("TD").eq(14).find(".rate-status");
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

  // Next to Proceed Action
  function nextToProceedAction(id){
      var wh_id=$('#depo_id').val();
      if(wh_id==""){
          Swal.fire({title: 'Select Your Depo First.!!'});
          return false;
      }

      if (!validateDepotSelection()) {
          showDepotValidationError();
          return false;
      }
      
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
          var depotSelect = row.find("TD").eq(12).find("select");
          dist_info.depo_code = depotSelect.find("option:selected").text().split('-')[0];
          dist_info.rate = row.find("TD").eq(13).find("input").val();
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

  // Remove Items Function with Confirmation
  function remove(tableID) {
      const visibleRows = $("#tblMain TBODY TR:visible").not('.no-records-message').length;
      if (visibleRows === 0) {
          Swal.fire({
              icon: 'warning',
              title: 'No Items Available',
              text: 'There are no items to remove.',
              confirmButtonText: 'OK'
          });
          return false;
      }

      var table = document.getElementById(tableID).tBodies[0];
      var rowCount = table.rows.length;
      var checkedItems = [];  
      
      for(var i = 0; i < rowCount; i++) {
          var row = table.rows[i];
          var chkbox = row.cells[16].getElementsByTagName('input')[0];
          if(null != chkbox && true == chkbox.checked) {
              var itemCode = row.cells[0].innerHTML;
              var itemName = row.cells[1].getElementsByTagName('input')[0].value;
              checkedItems.push({
                  code: itemCode,
                  name: itemName,
                  index: i
              });
          }
      }
      
      if (checkedItems.length === 0) {
          Swal.fire({
              icon: 'warning',
              title: 'No Selection',
              text: 'Please check items to remove',
              confirmButtonText: 'OK'
          });
          return false;
      }
      
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
              var removedCount = 0;
              for(var i = rowCount - 1; i >= 0; i--) {
                  var row = table.rows[i];
                  var chkbox = row.cells[16].getElementsByTagName('input')[0];
                  if(null != chkbox && true == chkbox.checked) {
                      table.deleteRow(i);
                      removedCount++;
                  }
              }
              
              updateOrderSummary();
              $('#selectAll').prop('checked', false);
              updateActionButtonsState();
              
              Swal.fire({
                  icon: 'success',
                  title: 'Items Removed!',
                  text: removedCount + ' item(s) successfully removed from table',
                  timer: 2000,
                  showConfirmButton: false
              });
          }
      });
  }
</script>
@endsection