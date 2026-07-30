@extends('layouts.master')
@section('content')
<style>
    /* ========== PROFESSIONAL REPORT STYLING ========== */
    * {
        box-sizing: border-box;
    }
    
    /* ----- Report Header ----- */
    .report-header {
        background: linear-gradient(145deg, #0b2a4a 0%, #1e4a7a 100%);
        color: #fff;
        padding: 12px 20px;
        border-radius: 8px 8px 0 0;
        margin-bottom: 15px;
        box-shadow: 0 4px 15px rgba(0,20,50,0.10);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
    }
    .report-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 15px;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .report-header h4 i {
        font-size: 16px;
        opacity: 0.85;
    }
    .report-header small {
        font-weight: 300;
        opacity: 0.85;
        font-size: 11px;
        letter-spacing: 0.5px;
        margin-left: 6px;
    }

    /* ----- Export Details Button ----- */
    .btn-export-details {
        background: rgba(255,255,255,0.15);
        border: none;
        color: #fff;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .btn-export-details:hover {
        background: rgba(255,255,255,0.25);
        transform: scale(1.02);
    }
    .btn-export-details:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
    }

    /* ----- FILTER SECTION ----- */
    .filter-section {
        background: #ffffff;
        padding: 12px 16px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 20, 40, 0.04);
        margin-bottom: 15px;
        border: 1px solid #e9edf4;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 8px 12px;
    }
    .filter-group {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 8px 12px;
        flex: 2 1 600px;
    }
    .filter-group .form-group {
        margin-bottom: 0;
        min-width: 110px;
        flex: 0 1 auto;
    }
    .filter-group .form-group label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #3a507a;
        margin-bottom: 3px;
    }
    .filter-group .form-group select,
    .filter-group .form-group input {
        width: 100%;
        padding: 4px 10px;
        border: 1px solid #d6dee9;
        border-radius: 6px;
        background: #fafcff;
        font-size: 11px;
        transition: 0.2s;
        color: #1f2a44;
        font-weight: 500;
        height: 30px;
    }
    .filter-group .form-group select:focus,
    .filter-group .form-group input:focus {
        border-color: #1e4a7a;
        outline: none;
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.10);
        background: #fff;
    }
    .date-group {
        display: flex;
        align-items: flex-end;
        gap: 4px 8px;
        flex-wrap: wrap;
        flex: 0 1 auto;
    }
    .date-group > div {
        flex: 0 1 auto;
        min-width: 80px;
    }
    .date-group label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #3a507a;
        margin-bottom: 3px;
        display: flex;
        align-items: center;
        gap: 3px;
    }
    .date-group label i {
        color: #2a5298;
        font-size: 11px;
    }
    .date-group input {
        padding: 4px 10px;
        border: 1px solid #d6dee9;
        border-radius: 6px;
        background: #fafcff;
        font-size: 11px;
        min-width: 80px;
        transition: 0.2s;
        width: 100%;
        height: 30px;
    }
    .date-group input:focus {
        border-color: #1e4a7a;
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.10);
        outline: none;
    }
    .action-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px;
        margin-left: auto;
        flex: 0 1 auto;
    }
    .btn-submit, .btn-export-excel {
        border: none;
        padding: 4px 14px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 11px;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        transition: 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        white-space: nowrap;
        cursor: pointer;
        height: 30px;
        line-height: 1;
    }
    .btn-submit {
        background: linear-gradient(135deg, #1a4a7a, #0f3b63);
        color: #fff;
    }
    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(20, 60, 120, 0.20);
        background: linear-gradient(135deg, #235a8f, #13406b);
    }
    .btn-export-excel {
        background: linear-gradient(135deg, #1f8b4c, #14733b);
        color: #fff;
    }
    .btn-export-excel:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(30, 130, 70, 0.20);
        background: linear-gradient(135deg, #28a05a, #1a7e44);
    }
    .btn-submit:disabled, .btn-export-excel:disabled {
        opacity: 0.55;
        transform: none !important;
        box-shadow: none !important;
        cursor: not-allowed;
    }
    .btn-loading {
        pointer-events: none;
        color: transparent !important;
        position: relative;
    }
    .btn-loading::after {
        content: '';
        position: absolute;
        width: 12px;
        height: 12px;
        top: 50%;
        left: 50%;
        margin-left: -6px;
        margin-top: -6px;
        border: 2px solid rgba(255,255,255,0.25);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 0.6s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* Required field indicator */
    .required-star {
        color: #d0314a;
        font-weight: 700;
        margin-left: 2px;
    }
    .required-hint {
        font-size: 10px;
        color: #8a9bb5;
        font-weight: 400;
        text-transform: none;
        letter-spacing: 0;
    }
    .invoice-search-wrapper {
        position: relative;
    }
    .invoice-search-wrapper input {
        padding-right: 30px !important;
    }
    .invoice-search-wrapper .search-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0b0c8;
        font-size: 12px;
    }

    /* ----- TABLE STYLES ----- */
    .custom-table-wrapper {
        position: relative;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        background: #fff;
    }
    .custom-table-wrapper .table-scroll {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 550px;
        position: relative;
    }
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 11px;
        min-width: 1200px;
        background: #fff;
        margin-bottom: 0;
    }
    .custom-table thead th {
        background: #0b2a4a;
        color: #ffffff;
        text-align: center;
        text-transform: uppercase;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 8px 6px;
        border: 1px solid #0b2a4a;
        position: sticky;
        top: 0;
        z-index: 20;
        white-space: nowrap;
    }
    .custom-table thead th:last-child {
        position: sticky;
        right: 0;
        z-index: 30;
        background: #0b2a4a;
        border-left: 2px solid #2a5298;
        min-width: 75px;
    }
    .custom-table tbody td {
        padding: 6px 6px;
        border: 1px solid #e2e8f0;
        vertical-align: middle;
        color: #1a2a44;
        font-weight: 500;
        white-space: nowrap;
        transition: all 0.2s ease;
        font-size: 11px;
    }
    .custom-table tbody td:last-child {
        position: sticky;
        right: 0;
        z-index: 10;
        background: #fff;
        border-left: 2px solid #e2e8f0;
        min-width: 75px;
        text-align: right;
        font-weight: 700;
    }
    
    /* Hover Effects */
    .custom-table tbody tr:hover td {
        background-color: #f0f6fe !important;
        transition: all 0.2s ease;
    }
    .custom-table tbody tr:nth-child(even):hover td {
        background-color: #eaf2fa !important;
    }
    .custom-table tbody tr:hover td:last-child {
        background: #f0f6fe !important;
        z-index: 15;
        box-shadow: -4px 0 12px rgba(30, 74, 122, 0.08);
        transition: all 0.2s ease;
    }
    .custom-table tbody tr:nth-child(even):hover td:last-child {
        background: #eaf2fa !important;
    }
    .custom-table tbody tr:nth-child(even) td {
        background-color: #f9fbfe;
    }
    .custom-table tbody tr:nth-child(even) td:last-child {
        background-color: #f9fbfe;
    }
    
    /* Highlight selected row */
    .custom-table tbody tr.active-row td {
        background-color: #dce8f8 !important;
    }
    .custom-table tbody tr.active-row td:last-child {
        background-color: #dce8f8 !important;
    }

    /* Clickable Invoice Number */
    .invoice-link {
        color: #1e4a7a;
        font-weight: 600;
        cursor: pointer;
        text-decoration: underline;
        text-underline-offset: 2px;
        text-decoration-color: #b0c8e0;
        transition: all 0.2s ease;
    }
    .invoice-link:hover {
        color: #0b2a4a;
        text-decoration-color: #1e4a7a;
    }

    .gp-positive { color: #1a8a4a; font-weight: 700; }
    .gp-negative { color: #d0314a; font-weight: 700; }
    .badge-country {
        background: #1e7a8a;
        color: #fff;
        padding: 2px 10px;
        border-radius: 16px;
        font-size: 10px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    /* Loading overlay */
    .loading-overlay {
        position: relative;
        border-radius: 8px;
    }
    .loading-overlay .loading-spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 100;
        display: none;
    }
    .loading-overlay .loading-spinner.show {
        display: block;
    }
    .loading-spinner .spinner-border {
        width: 30px;
        height: 30px;
        border: 3px solid #e2e8f0;
        border-top: 3px solid #1e4a7a;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: inline-block;
    }
    .loading-spinner p {
        margin-top: 8px;
        color: #1e4a7a;
        font-weight: 600;
        font-size: 11px;
    }

    .no-data {
        text-align: center;
        padding: 30px 20px;
        color: #6a7b9c;
        font-size: 11px;
    }
    .no-data i { font-size: 28px; display: block; margin-bottom: 8px; color: #d0d9e8; }

    .alert-custom {
        padding: 8px 14px;
        border-radius: 6px;
        margin-bottom: 12px;
        font-size: 11px;
        display: none;
        border-left: 3px solid transparent;
    }
    .alert-custom.alert-danger { background: #fce9ec; border-left-color: #d0314a; color: #8a1a2a; display: block; }
    .alert-custom.alert-success { background: #e3f5eb; border-left-color: #1a8a4a; color: #0f5a2a; display: block; }
    .alert-custom.alert-warning { background: #fef6e0; border-left-color: #b68a20; color: #7a5a10; display: block; }

    /* ===== INVOICE DETAILS SECTION ===== */
    .invoice-details-container {
        display: none;
        margin-top: 0;
        border: 1px solid #e2e8f0;
        border-radius: 0 0 8px 8px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        animation: slideDown 0.3s ease;
        overflow: hidden;
    }
    .invoice-details-container.show {
        display: block;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .invoice-details-header {
        background: linear-gradient(145deg, #0b2a4a 0%, #1e4a7a 100%);
        color: #fff;
        padding: 10px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .invoice-details-header h6 {
        margin: 0;
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .invoice-details-header h6 i {
        font-size: 14px;
        opacity: 0.85;
    }
    .invoice-details-header .close-details {
        background: rgba(255,255,255,0.15);
        border: none;
        color: #fff;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .invoice-details-header .close-details:hover {
        background: rgba(255,255,255,0.25);
        transform: rotate(90deg);
    }
    .invoice-details-body {
        padding: 15px 16px;
        overflow-x: auto;
        max-height: 400px;
        overflow-y: auto;
    }
    .invoice-details-body .loading-details {
        text-align: center;
        padding: 30px 20px;
        color: #6a7b9c;
        font-size: 12px;
    }
    .invoice-details-body .loading-details .spinner-border-sm {
        width: 20px;
        height: 20px;
        border: 2px solid #e2e8f0;
        border-top: 2px solid #1e4a7a;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: inline-block;
        margin-right: 10px;
        vertical-align: middle;
    }
    .invoice-details-body table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
    }
    .invoice-details-body table th {
        background: #f0f4fa;
        color: #1a2a44;
        font-weight: 700;
        padding: 7px 10px;
        border: 1px solid #e2e8f0;
        text-align: left;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        position: sticky;
        top: 0;
        z-index: 5;
    }
    .invoice-details-body table td {
        padding: 6px 10px;
        border: 1px solid #e2e8f0;
        color: #1a2a44;
        font-size: 11px;
    }
    .invoice-details-body table tr:nth-child(even) td {
        background: #f9fbfe;
    }
    .invoice-details-body table tr:hover td {
        background: #f0f6fe !important;
    }
    .invoice-details-body .no-data-details {
        text-align: center;
        padding: 30px 20px;
        color: #6a7b9c;
    }
    .invoice-details-body .no-data-details i {
        font-size: 28px;
        display: block;
        margin-bottom: 8px;
        color: #d0d9e8;
    }
    .invoice-details-body .detail-label {
        font-weight: 600;
        color: #3a507a;
        min-width: 140px;
        background: #f5f8fc !important;
    }
    .invoice-details-body .detail-value {
        font-weight: 500;
    }

    .report-footer {
        margin-top: 12px;
        padding: 6px 16px;
        background: #f8faff;
        border-radius: 6px;
        font-size: 11px;
        color: #3a507a;
        border: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .filter-section { flex-direction: column; align-items: stretch; }
        .filter-group { flex-direction: column; align-items: stretch; }
        .filter-group .form-group { flex: 1 1 auto; min-width: 100%; }
        .date-group { flex-direction: column; align-items: stretch; }
        .date-group > div { flex: 1 1 auto; min-width: 100%; }
        .action-group { margin-left: 0; justify-content: stretch; }
        .btn-submit, .btn-export-excel { width: 100%; justify-content: center; }
        .custom-table { font-size: 10px; min-width: 900px; }
        .report-header { flex-direction: column; align-items: flex-start; gap: 6px; }
        .invoice-details-body table { font-size: 10px; }
        .invoice-details-body table th,
        .invoice-details-body table td { padding: 4px 6px; font-size: 10px; }
    }

    /* ===== MULTISELECT ===== */
    .multiselect-container {
        width: 100% !important;
        min-width: 260px !important;
        max-width: 400px !important;
        border-radius: 6px !important;
        border: 1px solid #c5d0df !important;
        box-shadow: 0 6px 20px rgba(0, 20, 50, 0.12) !important;
        padding: 4px 0 !important;
        max-height: 300px !important;
        overflow-y: auto !important;
        background: #ffffff !important;
        z-index: 9999 !important;
    }
    .multiselect-container .multiselect-filter {
        padding: 0 10px 6px 10px !important;
        border-bottom: 1px solid #e8edf4 !important;
        margin-bottom: 4px !important;
    }
    .multiselect-container .multiselect-filter .input-group {
        display: flex !important;
        align-items: center !important;
        background: #f5f8fc !important;
        border-radius: 4px !important;
        border: 1px solid #d6dee9 !important;
        transition: all 0.2s ease !important;
    }
    .multiselect-container .multiselect-filter .input-group:focus-within {
        border-color: #1e4a7a !important;
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.10) !important;
        background: #ffffff !important;
    }
    .multiselect-container .multiselect-filter .input-group .form-control {
        border: none !important;
        background: transparent !important;
        padding: 4px 10px !important;
        font-size: 11px !important;
        color: #1f2a44 !important;
        border-radius: 4px !important;
        height: 28px !important;
        box-shadow: none !important;
        width: 100% !important;
    }
    .multiselect-container li {
        padding: 0 !important;
        margin: 0 !important;
        list-style: none !important;
    }
    .multiselect-container li a {
        padding: 4px 14px !important;
        font-size: 11px !important;
        color: #1f2a44 !important;
        display: flex !important;
        align-items: center !important;
        border-left: 2px solid transparent !important;
        transition: all 0.15s ease !important;
        text-decoration: none !important;
        min-height: 28px !important;
    }
    .multiselect-container li a:hover {
        background: #eef4fc !important;
        border-left-color: #1e4a7a !important;
    }
    .multiselect-container li a label {
        font-size: 11px !important;
        color: #1f2a44 !important;
        cursor: pointer !important;
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        font-weight: normal !important;
    }
    .multiselect-container li a label input[type="checkbox"] {
        margin: 0 !important;
        width: 14px !important;
        height: 14px !important;
        accent-color: #1e4a7a !important;
        cursor: pointer !important;
        flex-shrink: 0 !important;
        vertical-align: middle !important;
        position: relative !important;
        top: 0 !important;
        display: inline-block !important;
    }
    .multiselect-container li.multiselect-all {
        border-bottom: 1px solid #e2e8f0 !important;
        margin-bottom: 3px !important;
        padding-bottom: 3px !important;
        background: #f8faff !important;
    }
    .multiselect-container li.multiselect-all a {
        font-weight: 700 !important;
        color: #0b2a4a !important;
        background: #f8faff !important;
        padding: 6px 14px !important;
    }
    .btn.multiselect {
        background: #fafcff !important;
        border: 1px solid #d6dee9 !important;
        border-radius: 6px !important;
        padding: 4px 10px !important;
        font-weight: 500 !important;
        text-align: left !important;
        color: #1f2a44 !important;
        width: 100% !important;
        font-size: 11px !important;
        height: 30px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        transition: all 0.2s ease !important;
        line-height: 1.3 !important;
    }
    .btn.multiselect:hover {
        border-color: #b0c0d4 !important;
        background: #f5f8fc !important;
    }
    .btn.multiselect .caret {
        margin-left: auto;
        border-top: 4px solid #4a5f7a;
        border-right: 4px solid transparent;
        border-left: 4px solid transparent;
        transition: transform 0.2s ease;
        flex-shrink: 0;
    }
    .btn.multiselect.open .caret {
        transform: rotate(180deg);
    }
    @media (max-width: 768px) {
        .multiselect-container {
            min-width: 220px !important;
            max-width: 320px !important;
        }
    }
</style>

<div class="container-fluid">
    <!-- ===== HEADER ===== -->
    <div class="report-header">
        <div>
            <h4>
                <i class="fa fa-file-text-o"></i> Invoice Wise GP Summary
                <small></small>
            </h4>
        </div>
    </div>

    <!-- ===== FILTER SECTION ===== -->
    <div class="filter-section">
        <div class="filter-group">
            <!-- Region -->
            <div class="form-group" id="regionGroup">
                <label for="region_id">
                    <i class="fa fa-map-marker"></i> Region 
                    <span class="required-star" id="regionRequired">*</span>
                </label>
                <select name="region_id" id="region_id" class="form-control">
                    <option value="">Select</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Country -->
            <div class="form-group" style="min-width: 180px;" id="countryGroup">
                <label for="country_search">
                    <i class="fa fa-globe"></i> Country 
                    <span class="required-star" id="countryRequired">*</span>
                </label>
                <select name="country_list[]" id="country_search" multiple="multiple"></select>
            </div>

            <!-- Date Range -->
            <div class="date-group">
                <div id="fromDateGroup">
                    <label>
                        <i class="fa fa-calendar"></i> From 
                        <span class="required-star" id="fromDateRequired">*</span>
                    </label>
                    <input name="formDate" type="text" id="fromDate" class="datepicker form-control" placeholder="DD-MM-YYYY" autocomplete="off">
                </div>
                <div id="toDateGroup">
                    <label>
                        <i class="fa fa-calendar"></i> To 
                        <span class="required-star" id="toDateRequired">*</span>
                    </label>
                    <input name="toDate" type="text" id="toDate" class="datepicker form-control" placeholder="DD-MM-YYYY" autocomplete="off">
                </div>
            </div>
            
            <!-- Invoice No -->
            <div class="form-group" style="min-width: 160px;">
                <label for="invoice_search">
                    <i class="fa fa-file-text"></i> Invoice No 
                    <span class="required-hint">(optional)</span>
                </label>
                <div class="invoice-search-wrapper">
                    <input type="text" id="invoice_search" class="form-control" 
                           placeholder="Enter Invoice No..." autocomplete="off">
                    <i class="fa fa-search search-icon"></i>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-group">
            <button class="btn-submit" id="submitBtn">
                <i class="fa fa-search"></i> Show
            </button>
            <button class="btn-export-excel" id="exportBtn" onclick="exportF(this)" disabled>
                <i class="fa fa-file-excel-o"></i> Export
            </button>
        </div>
    </div>

    <!-- Alert -->
    <div class="alert-custom" id="alertMessage"></div>

    <!-- ===== TABLE WITH DETAILS ===== -->
    <div class="custom-table-wrapper" id="tableContainer">
        {{-- <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner-border"></div>
                <p>Loading report data...</p>
            </div>
        </div> --}}
        <div class="table-scroll">
            <table class="custom-table table" id="inv">
                <thead>
                    <tr>
                        <th>Contract No</th>
                        <th>Created Date</th>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Party Name</th>
                        <th>Country</th>
                        <th>CTN</th>
                        <th>PCS</th>
                        <th>New Item Value</th>
                        <th>Total Value</th>
                        <th>Total Cost</th>
                        <th style="min-width:75px;">GP %</th>
                    </tr>
                </thead>
                <tbody id="reportBody">
                    <tr>
                        <td colspan="14">
                            <div class="no-data">
                                <i class="fa fa-info-circle"></i>
                                Please select filters and click "Show" to load report data
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tfoot id="reportFooter" style="display: none;"></tfoot>
            </table>
        </div>
        
        <!-- ===== INVOICE DETAILS SECTION ===== -->
        <div class="invoice-details-container" id="invoiceDetailsContainer">
            <div class="invoice-details-header">
                <h6>
                    <i class="fa fa-file-text"></i> 
                    Invoice Details: <span id="detailsTitle">-</span>
                </h6>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <button class="btn-export-details" onclick="exportInvoiceDetails()" 
                            title="Export Invoice Details" id="exportDetailsBtn" disabled>
                        <i class="fa fa-file-excel-o"></i> Export
                    </button>
                    <button class="close-details" onclick="closeInvoiceDetails()" title="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="invoice-details-body" id="detailsBody">
                <div class="loading-details">
                    <div class="spinner-border-sm"></div> Loading invoice details...
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="report-footer" id="reportFooterInfo" style="display: none;">
        <span><i class="fa fa-clock-o"></i> Generated: <span id="generatedTime">{{ date('d M Y h:i A') }}</span></span>
        <span style="display: none"><i class="fa fa-file-text-o"></i> Total Invoices: <span id="totalRecords">0</span></span>
    </div>
</div>

<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}">

<script>    
document.title = 'Invoice Wise GP Summary | Desk';
setTimeout(function() { $('.sr-only').click(); }, 0.0001);

$(function() {
    // ===== Datepickers =====
    $(".datepicker").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        autoclose: true
    });
    
    var today = new Date();
    var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    $('#fromDate').datepicker('setDate', firstDay);
    $('#toDate').datepicker('setDate', today);

    // ===== Multiselect =====
    initializeMultiselect();

    // ===== Region Change =====
    $('#region_id').on('change', function() {
        var regionId = $(this).val();
        if (regionId) {
            var url = "{{ url('/json/get_region_wise_country_list') }}?region_id=" + regionId;
            $.get(url, function(res) {
                var option = '';
                if (res.data && res.data.length > 0) {
                    $.each(res.data, function(key, value) {
                        option += '<option value="'+value.country+'">'+ value.country +'</option>';
                    });
                }
                if ($('#country_search').data('multiselect')) {
                    $('#country_search').multiselect('destroy');
                }
                $('#country_search').html(option);
                initializeMultiselect(false);
            });
        } else {
            if ($('#country_search').data('multiselect')) {
                $('#country_search').multiselect('destroy');
            }
            $('#country_search').html('');
            initializeMultiselect(true);
        }
    });

    // ===== Submit =====
    $('#submitBtn').on('click', function(e) {
        e.preventDefault();
        loadReportData();
    });

    // ===== Enter key =====
    $('.datepicker, #invoice_search').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            loadReportData();
        }
    });
    
    // ===== Invoice input change - Toggle required fields =====
    $('#invoice_search').on('input', function() {
        var hasInvoice = $(this).val().trim() !== '';
        toggleRequiredFields(hasInvoice);
    });
});

// ===== TOGGLE REQUIRED FIELDS =====
function toggleRequiredFields(hasInvoice) {
    if (hasInvoice) {
        // Invoice exists - region, country, dates become optional
        $('#regionRequired').hide();
        $('#countryRequired').hide();
        $('#fromDateRequired').hide();
        $('#toDateRequired').hide();
        
        $('#regionGroup label .required-hint').remove();
        $('#countryGroup label .required-hint').remove();
        $('#fromDateGroup label .required-hint').remove();
        $('#toDateGroup label .required-hint').remove();
        
        // Add optional text
        $('#regionGroup label').append(' <span class="required-hint">(optional)</span>');
        $('#countryGroup label').append(' <span class="required-hint">(optional)</span>');
        $('#fromDateGroup label').append(' <span class="required-hint">(optional)</span>');
        $('#toDateGroup label').append(' <span class="required-hint">(optional)</span>');
    } else {
        // No invoice - all fields required
        $('#regionRequired').show();
        $('#countryRequired').show();
        $('#fromDateRequired').show();
        $('#toDateRequired').show();
        
        // Remove optional text
        $('#regionGroup label .required-hint').remove();
        $('#countryGroup label .required-hint').remove();
        $('#fromDateGroup label .required-hint').remove();
        $('#toDateGroup label .required-hint').remove();
    }
}

// ===== MULTISELECT INIT =====
function initializeMultiselect(emptyState) {
    emptyState = emptyState || false;
    var config = {
        columns: 1,
        placeholder: emptyState ? 'Select region first' : 'Search & select',
        search: !emptyState,
        selectAll: !emptyState,
        selectAllText: 'Select All Countries',
        includeSelectAllOption: !emptyState,
        enableFiltering: !emptyState,
        filterPlaceholder: 'Search countries...',
        enableCaseInsensitiveFiltering: true,
        maxHeight: 300,
        buttonClass: 'btn btn-block',
        buttonWidth: '100%',
        nonSelectedText: emptyState ? 'Select region first' : 'Select countries',
        nSelectedText: 'selected',
        allSelectedText: 'All selected'
    };
    $('#country_search').multiselect(config);
}

// ===== LOAD REPORT DATA =====
function loadReportData() {
    // Get all filter values
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    var regionId = $('#region_id').val();
    var invoiceNo = $('#invoice_search').val().trim();
    var selectedCountries = $('#country_search').val();
    
    // ===== VALIDATION LOGIC =====
    // Check if invoice number is provided
    if (invoiceNo && invoiceNo !== '') {
        // ===== INVOICE EXISTS - ONLY DATE REQUIRED =====
        if (!fromDate || !toDate) {
            showAlert('Please select both From and To dates for invoice search', 'warning');
            return false;
        }
        
        if (!validateDateRange(fromDate, toDate)) {
            showAlert('From date must be earlier than To date', 'danger');
            return false;
        }
        
        // Region and Country are optional when invoice exists
        // We'll send them if they have values
        
    } else {
        // ===== NO INVOICE - ALL FILTERS REQUIRED =====
        // Check if region is selected
        if (!regionId || regionId === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Selection Required',
                text: 'Please select a region!',
                confirmButtonColor: '#1e4a7a',
                confirmButtonText: 'OK'
            });
            return false;
        }
        
        // Check if countries are selected
        if (!selectedCountries || selectedCountries.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Selection Required',
                text: 'Please select at least one country!',
                confirmButtonColor: '#1e4a7a',
                confirmButtonText: 'OK'
            });
            return false;
        }
        
        // Check if both dates are provided
        if (!fromDate || !toDate) {
            showAlert('Please select both From and To dates', 'warning');
            return false;
        }
        
        // Validate date range
        if (!validateDateRange(fromDate, toDate)) {
            showAlert('From date must be earlier than To date', 'danger');
            return false;
        }
    }

    // ===== CLOSE ANY OPEN DETAILS =====
    closeInvoiceDetails();
    $('#alertMessage').hide();
    $('#loadingSpinner').addClass('show');
    $('#reportFooterInfo').hide();
    $('#exportBtn').prop('disabled', true);
    $('#submitBtn').prop('disabled', true).addClass('btn-loading');

    // ===== BUILD FORM DATA =====
    var formData = new FormData();
    formData.append('fromDate', fromDate);
    formData.append('toDate', toDate);
    formData.append('_token', '{{ csrf_token() }}');
    
    // Add invoice number if exists
    if (invoiceNo && invoiceNo !== '') {
        formData.append('invoice_search', invoiceNo);
    }
    
    // Add region if exists
    if (regionId && regionId !== '') {
        formData.append('region_id', regionId);
    }
    
    // Add countries if exists
    if (selectedCountries && selectedCountries.length > 0) {
        for (var i = 0; i < selectedCountries.length; i++) {
            formData.append('country_list[]', selectedCountries[i]);
        }
    }

    // ===== AJAX REQUEST =====
    $.ajax({
        url: "{{ url('/json_get/gp_summary/data') }}",
        type: "POST",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        timeout: 30000,
        success: function(response) {
            if (response.status === 'success') {
                if (response.data && response.data.length > 0) {
                    renderTableData(response.data);
                    $('#totalRecords').text(response.data.length);
                    $('#generatedTime').text(new Date().toLocaleString());
                    $('#reportFooterInfo').show();
                    $('#exportBtn').prop('disabled', false);
                    
                    var message = invoiceNo ? 'Found ' + response.data.length + ' invoices matching "' + invoiceNo + '"' : 'Report loaded! ' + response.data.length + ' invoices found.';
                    showAlert(message, 'success');
                    setTimeout(function() {
                        $('#alertMessage').fadeOut('slow');
                    }, 3000);
                } else {
                    var message = invoiceNo ? 'No invoices found for "' + invoiceNo + '"' : 'No records found for the selected filters';
                    showNoData(message);
                    showAlert(message, 'warning');
                }
            } else {
                showNoData('Error: ' + (response.message || 'Unknown error'));
                showAlert('Error: ' + (response.message || 'Unknown error'), 'danger');
            }
        },
        error: function(xhr, status) {
            var msg = 'Failed to load report. ';
            if (status === 'timeout') msg += 'Request timed out.';
            else if (xhr.status === 404) msg += 'URL not found.';
            else if (xhr.status === 500) msg += 'Server error.';
            else msg += 'Please try again.';
            showNoData(msg);
            showAlert(msg, 'danger');
        },
        complete: function() {
            $('#loadingSpinner').removeClass('show');
            $('#submitBtn').prop('disabled', false).removeClass('btn-loading');
        }
    });
}

// ===== RENDER TABLE DATA =====
function renderTableData(data) {
    var tbody = $('#reportBody');
    tbody.empty();
    
    if (!data || data.length === 0) {
        showNoData('No records found');
        return;
    }

    $.each(data, function(index, result) {
        var contractId = result['Contract ID'] || result['contract_id'] || '';
        var gpPercent = parseFloat(result['GP Percentage'] || 0);
        var gpClass = gpPercent >= 0 ? 'gp-positive' : 'gp-negative';
        var invoiceNo = result['Invoice No'] || '';

        var contractIdStr = String(contractId).replace(/'/g, "\\'");
        var invoiceNoStr = String(invoiceNo).replace(/'/g, "\\'");

        var row = '<tr data-contract-id="' + contractId + '">' +
            '<td>' + (result['Contract No'] || '-') + '</td>' +
            '<td>' + (result['Created Date'] ? formatDate(result['Created Date']) : '-') + '</td>' +
            '<td><span class="invoice-link" onclick="showInvoiceDetails(\'' + contractIdStr + '\', \'' + invoiceNoStr + '\', this)">' + invoiceNo + '</span></td>' +
            '<td>' + (result['Invoice Date'] || '-') + '</td>' +
            '<td>' + (result['Party Name'] || '-') + '</td>' +
            '<td><span class="badge-country">' + (result['Country Name'] || '-') + '</span></td>' +
            '<td style="text-align:center;">' + (result['Total CTN'] || 0) + '</td>' +
            '<td style="text-align:center;">' + (result['Total PCS'] || 0) + '</td>' +
            '<td style="text-align:right;color:#6a7b9c;">' + formatCurrency(result['New Item Value'] || 0) + '</td>' +
            '<td style="text-align:right;font-weight:600;color:#1a3a5c;">' + formatCurrency(result['Total Value'] || 0) + '</td>' +
            '<td style="text-align:right;color:#d0314a;">' + formatCurrency(result['Total Cost'] || 0) + '</td>' +
            '<td style="text-align:right;font-weight:700;" class="' + gpClass + '">' + gpPercent.toFixed(2) + '%</td>' +
            '</tr>';
        tbody.append(row);
    });
}

// ===== SHOW INVOICE DETAILS =====
function showInvoiceDetails(contractId, invoiceNo, element) {
    closeInvoiceDetails();
    
    $('.custom-table tbody tr').removeClass('active-row');
    $(element).closest('tr').addClass('active-row');
    
    var container = $('#invoiceDetailsContainer');
    var title = $('#detailsTitle');
    var body = $('#detailsBody');
    var exportBtn = $('#exportDetailsBtn');
    
    exportBtn.prop('disabled', true);
    title.text(invoiceNo || 'Details');
    body.html('<div class="loading-details"><div class="spinner-border-sm"></div> Loading invoice details...</div>');
    container.show();
    
    $('html, body').animate({
        scrollTop: container.offset().top - 20
    }, 300);
    
    var formData = new FormData();
    formData.append('contractId', contractId);
    formData.append('_token', '{{ csrf_token() }}');
    
    $.ajax({
        url: "{{url('/json_get/invoice/gp_details')}}",
        type: "POST",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        timeout: 15000,
        success: function(response) {
            if (response.status === 'success' && response.data) {
                renderDetailsData(response.data);
                exportBtn.prop('disabled', false);
            } else {
                body.html('<div class="no-data-details"><i class="fa fa-exclamation-circle"></i> No details found</div>');
                exportBtn.prop('disabled', true);
            }
        },
        error: function() {
            body.html('<div class="no-data-details"><i class="fa fa-exclamation-circle"></i> Failed to load details</div>');
            exportBtn.prop('disabled', true);
        }
    });
}

// ===== RENDER DETAILS DATA =====
function renderDetailsData(data) {
    var body = $('#detailsBody');
    var exportBtn = $('#exportDetailsBtn');
    
    if (Array.isArray(data) && data.length > 0) {
        var columnMap = {
            'sales_contract_no': 'Contract No',
            'dated': 'Contract Date',
            'invoice_no': 'Invoice No',
            'invoice_date': 'Invoice Date',
            'ci_item_code': 'Item Code',
            'ci_item_name': 'Item Name',
            'ci_factor': 'Unit Factor',
            'ctn': 'CTN',
            'pcs_in_ctn': 'PCS in CTN',
            'per_ctn_rate': 'Per CTN Rate',
            'per_pcs_rate': 'Per PCS Rate',
            'prime_cost': 'Mat Cost',
            'gp_percent': 'GP %'
        };
        
        var currencyColumns = ['per_ctn_rate', 'per_pcs_rate', 'prime_cost'];
        var headers = Object.keys(data[0]);
        
        var html = '<div style="overflow-x:auto;"><table><thead><tr>';
        headers.forEach(function(key) {
            var displayName = columnMap[key] || key.replace(/_/g, ' ').toUpperCase();
            html += '<th>' + displayName + '</th>';
        });
        html += '</tr></thead><tbody>';
        
        data.forEach(function(row) {
            html += '<tr>';
            headers.forEach(function(key) {
                var value = row[key];
                if (value === null || value === undefined) value = '-';
                
                if ((key === 'dated' || key === 'invoice_date') && value && value !== '-') {
                    value = formatDate(value);
                }
                
                if (currencyColumns.includes(key)) {
                    var numValue = parseFloat(value);
                    value = !isNaN(numValue) ? formatCurrency(numValue) : formatCurrency(0);
                }
                
                if (key === 'gp_percent') {
                    var numValue = parseFloat(value);
                    value = !isNaN(numValue) ? numValue.toFixed(2) + '%' : '0.00%';
                }
                
                html += '<td>' + value + '</td>';
            });
            html += '</tr>';
        });
        html += '</tbody></table></div>';
        body.html(html);
        exportBtn.prop('disabled', false);
        
    } else if (typeof data === 'object' && data !== null && !Array.isArray(data)) {
        var columnMap = {
            'sales_contract_no': 'Sales Contract No',
            'dated': 'Contract Date',
            'invoice_no': 'Invoice No',
            'invoice_date': 'Invoice Date',
            'ci_item_code': 'Item Code',
            'ci_item_name': 'Item Name',
            'ci_factor': 'Pcs/Ctn',
            'ctn': 'CTN',
            'pcs_in_ctn': 'PCS in CTN',
            'per_ctn_rate': 'Per CTN Rate',
            'per_pcs_rate': 'Per PCS Rate',
            'prime_cost': 'Prime Cost',
            'gp_percent': 'GP %'
        };
        
        var currencyColumns = ['per_ctn_rate', 'per_pcs_rate', 'prime_cost'];
        var dateColumns = ['dated', 'invoice_date'];
        
        var html = '<table><tbody>';
        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                var value = data[key];
                var displayName = columnMap[key] || key.replace(/_/g, ' ').toUpperCase();
                if (value === null || value === undefined) value = '-';
                
                if (dateColumns.includes(key) && value && value !== '-') {
                    value = formatDate(value);
                }
                
                if (currencyColumns.includes(key)) {
                    var numValue = parseFloat(value);
                    value = !isNaN(numValue) ? formatCurrency(numValue) : formatCurrency(0);
                }
                
                if (key === 'gp_percent') {
                    var numValue = parseFloat(value);
                    value = !isNaN(numValue) ? numValue.toFixed(2) + '%' : '0.00%';
                }
                
                html += '<tr><td class="detail-label">' + displayName + '</td><td class="detail-value">' + value + '</td></tr>';
            }
        }
        html += '</tbody></table>';
        body.html(html);
        exportBtn.prop('disabled', false);
        
    } else {
        body.html('<div class="no-data-details"><i class="fa fa-info-circle"></i> No data available</div>');
        exportBtn.prop('disabled', true);
    }
}

// ===== CLOSE INVOICE DETAILS =====
function closeInvoiceDetails() {
    $('#invoiceDetailsContainer').hide();
    $('.custom-table tbody tr').removeClass('active-row');
    $('#exportDetailsBtn').prop('disabled', true);
}

// ===== HELPERS =====
function showNoData(message) {
    var tbody = $('#reportBody');
    tbody.empty();
    tbody.html('<tr><td colspan="14"><div class="no-data"><i class="fa fa-info-circle"></i>' + message + '</div></td></tr>');
    $('#exportBtn').prop('disabled', true);
    $('#reportFooterInfo').hide();
}

function validateDateRange(fromDate, toDate) {
    var from = parseDate(fromDate);
    var to = parseDate(toDate);
    if (!from || !to) return false;
    return from <= to;
}

function parseDate(dateStr) {
    var parts = dateStr.split('-');
    if (parts.length !== 3) return null;
    var day = parseInt(parts[0]);
    var month = parseInt(parts[1]) - 1;
    var year = parseInt(parts[2]);
    if (isNaN(day) || isNaN(month) || isNaN(year)) return null;
    return new Date(year, month, day);
}

function showAlert(message, type) {
    var alertDiv = $('#alertMessage');
    alertDiv.removeClass('alert-danger alert-success alert-warning');
    alertDiv.addClass('alert-' + type);
    var icon = type === 'danger' ? 'exclamation-circle' : 
               type === 'success' ? 'check-circle' : 'info-circle';
    alertDiv.html('<i class="fa fa-' + icon + '"></i> ' + message);
    alertDiv.show();
    if (type === 'success') {
        setTimeout(function() { alertDiv.fadeOut('slow'); }, 5000);
    }
}

function formatDate(dateString) {
    if (!dateString) return '';
    try {
        var date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString;
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        return day + '-' + month + '-' + year;
    } catch(e) {
        return dateString;
    }
}

function formatCurrency(amount) {
    if (!amount) return '0.00';
    var num = parseFloat(amount);
    if (isNaN(num)) return '0.00';
    return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// ===== EXPORT MAIN REPORT =====
function exportF(elem) {
    if ($('#reportBody tr').length === 0 || $('#reportBody tr td .no-data').length > 0) {
        showAlert('No data to export', 'warning');
        return false;
    }

    $(elem).prop('disabled', true).addClass('btn-loading');

    try {
        var content = '';
        var headers = [];
        $('#inv thead th').each(function() {
            headers.push($(this).text().trim());
        });
        content += headers.join('\t') + '\n';

        $('#reportBody tr').each(function() {
            var row = [];
            $(this).find('td').each(function() {
                var text = $(this).text().trim().replace(/[$,]/g, '').replace(/\s+/g, ' ').trim();
                row.push(text);
            });
            if (row.length) content += row.join('\t') + '\n';
        });

        var blob = new Blob([content], { type: 'application/vnd.ms-excel;charset=utf-8' });
        var url = window.URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = 'GP_Summary_Report.xls';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        showAlert('Export successful!', 'success');

    } catch (e) {
        console.error('Export error:', e);
        showAlert('Export failed. Please try again.', 'danger');
    } finally {
        $(elem).prop('disabled', false).removeClass('btn-loading');
    }
    return false;
}

// ===== EXPORT INVOICE DETAILS =====
function exportInvoiceDetails() {
    var detailsBody = $('#detailsBody');
    var table = detailsBody.find('table');
    
    if (table.length === 0 || table.find('tbody tr').length === 0) {
        showAlert('No invoice details to export.', 'warning');
        return;
    }

    var title = $('#detailsTitle').text() || 'Invoice_Details';
    var content = '';
    var headers = [];

    table.find('thead th').each(function() {
        headers.push($(this).text().trim());
    });
    content += headers.join('\t') + '\n';

    table.find('tbody tr').each(function() {
        var row = [];
        $(this).find('td').each(function() {
            var text = $(this).text().trim().replace(/[$,]/g, '').replace(/\s+/g, ' ').trim();
            row.push(text);
        });
        if (row.length) content += row.join('\t') + '\n';
    });

    var blob = new Blob([content], { type: 'application/vnd.ms-excel;charset=utf-8' });
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'Invoice_Details_' + title.replace(/\s+/g, '_') + '.xls';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);

    showAlert('Invoice details exported successfully!', 'success');
}
</script>
@endsection