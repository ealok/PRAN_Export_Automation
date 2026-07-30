@extends('layouts.master')
@section('content')
<style>
    /* ========== PROFESSIONAL REPORT STYLING ========== */
    * { box-sizing: border-box; }
    
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

    /* ===== TABLE SEARCH FILTER ===== */
    .table-search-section {
        background: #f8faff;
        padding: 8px 16px;
        border: 1px solid #e2e8f0;
        border-bottom: none;
        border-radius: 8px 8px 0 0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .table-search-section .search-box {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        min-width: 200px;
    }
    .table-search-section .search-box input {
        flex: 1;
        padding: 5px 12px;
        border: 1px solid #d6dee9;
        border-radius: 4px;
        font-size: 11px;
        height: 30px;
        background: #fff;
        transition: 0.2s;
        min-width: 150px;
    }
    .table-search-section .search-box input:focus {
        border-color: #1e4a7a;
        outline: none;
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.10);
    }
    .table-search-section .search-box input::placeholder {
        color: #b0bccf;
        font-size: 11px;
    }
    .table-search-section .search-box i {
        color: #4a5f7a;
        font-size: 13px;
    }
    .table-search-section .search-info {
        font-size: 10px;
        color: #6a7b9c;
        white-space: nowrap;
    }
    .table-search-section .search-info strong {
        color: #1e4a7a;
        font-weight: 700;
    }
    .table-search-section .clear-search {
        background: none;
        border: none;
        color: #d0314a;
        cursor: pointer;
        font-size: 12px;
        padding: 2px 6px;
        display: none;
    }
    .table-search-section .clear-search:hover {
        color: #a02030;
    }

    .custom-table-wrapper {
        position: relative;
        border-radius: 0 0 8px 8px;
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
        min-width: 1600px;
        background: #fff;
        margin-bottom: 0;
    }
    .custom-table thead th {
        background: #0b2a4a;
        color: #ffffff;
        text-align: center;
        text-transform: uppercase;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.3px;
        padding: 8px 5px;
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
        padding: 6px 5px;
        border: 1px solid #e2e8f0;
        vertical-align: middle;
        color: #1a2a44;
        font-weight: 500;
        white-space: nowrap;
        transition: all 0.2s ease;
        font-size: 10px;
    }
    .custom-table tbody td:last-child {
        position: sticky;
        right: 0;
        z-index: 10;
        background: #fff;
        border-left: 2px solid #e2e8f0;
        min-width: 75px;
        text-align: center;
        font-weight: 700;
    }
    
    .custom-table tbody tr:hover td {
        background-color: #f0f6fe !important;
    }
    .custom-table tbody tr:nth-child(even):hover td {
        background-color: #eaf2fa !important;
    }
    .custom-table tbody tr:hover td:last-child {
        background: #f0f6fe !important;
        z-index: 15;
        box-shadow: -4px 0 12px rgba(30, 74, 122, 0.08);
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

    /* Table row highlight for search */
    .custom-table tbody tr.highlight-row td {
        background-color: #fff3cd !important;
    }
    .custom-table tbody tr.highlight-row td:last-child {
        background-color: #fff3cd !important;
    }

    .invoice-text {
        color: #1a2a44;
        font-weight: 600;
    }

    .gp-positive { color: #1a8a4a; font-weight: 700; }
    .gp-negative { color: #d0314a; font-weight: 700; }
    .badge-country {
        background: #1e7a8a;
        color: #fff;
        padding: 2px 10px;
        border-radius: 16px;
        font-size: 9px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }
    .badge-jo-exists {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
        white-space: nowrap;
    }
    .badge-no-jo {
        background: #fce4ec;
        color: #c62828;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
        white-space: nowrap;
    }

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

    @media (max-width: 992px) {
        .filter-section { flex-direction: column; align-items: stretch; }
        .filter-group { flex-direction: column; align-items: stretch; }
        .filter-group .form-group { flex: 1 1 auto; min-width: 100%; }
        .date-group { flex-direction: column; align-items: stretch; }
        .date-group > div { flex: 1 1 auto; min-width: 100%; }
        .action-group { margin-left: 0; justify-content: stretch; }
        .btn-submit, .btn-export-excel { width: 100%; justify-content: center; }
        .custom-table { font-size: 9px; min-width: 1200px; }
        .report-header { flex-direction: column; align-items: flex-start; gap: 6px; }
        .table-search-section { flex-direction: column; align-items: stretch; }
        .table-search-section .search-box { min-width: 100%; }
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
    .multiselect-container .multiselect-filter .input-group .form-control:focus {
        box-shadow: none !important;
        outline: none !important;
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
        gap: 10px !important;
        font-weight: normal !important;
        margin: 0 !important;
    }
    .multiselect-container li a label input[type="checkbox"] {
        margin: 0 !important;
        width: 14px !important;
        height: 14px !important;
        accent-color: #1e4a7a !important;
        cursor: pointer !important;
        flex-shrink: 0 !important;
        vertical-align: middle !important;
        display: inline-block !important;
        position: relative !important;
        top: 0 !important;
    }
    .multiselect-container li a label .multiselect-text {
        flex: 1 !important;
        padding-left: 0 !important;
        font-size: 11px !important;
        display: inline-block !important;
        color: #1f2a44 !important;
        margin: 0 !important;
        line-height: 1.3 !important;
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
    .multiselect-container li.multiselect-all a:hover {
        background: #e3edf7 !important;
    }
    .multiselect-container li.multiselect-all a label {
        font-weight: 700 !important;
        color: #0b2a4a !important;
        gap: 10px !important;
    }
    .multiselect-container li.multiselect-all a label input[type="checkbox"] {
        accent-color: #0b2a4a !important;
    }
    .multiselect-container li.active a {
        background: #e3edf7 !important;
        border-left-color: #1e4a7a !important;
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
    .btn.multiselect:focus {
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.10) !important;
        border-color: #1e4a7a !important;
    }
    .btn.multiselect .multiselect-selected-text {
        display: inline-block;
        max-width: 78%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 11px !important;
        color: #1f2a44 !important;
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
    .multiselect-container .multiselect-no-results {
        padding: 8px 14px !important;
        color: #8a9bb5 !important;
        font-size: 11px !important;
        text-align: center !important;
        font-style: italic !important;
        background: #f8faff !important;
    }
    .multiselect-container::-webkit-scrollbar {
        width: 4px;
    }
    .multiselect-container::-webkit-scrollbar-track {
        background: #f1f4f9;
        border-radius: 2px;
    }
    .multiselect-container::-webkit-scrollbar-thumb {
        background: #b8c8dd;
        border-radius: 2px;
    }
    .multiselect-container::-webkit-scrollbar-thumb:hover {
        background: #8a9bb5;
    }
    @media (max-width: 768px) {
        .multiselect-container {
            min-width: 220px !important;
            max-width: 320px !important;
        }
    }
</style>

<div class="container-fluid">
    <div class="report-header">
        <div>
            <h4>
                <i class="fa fa-file-text-o"></i> SC VS JO Report
                <small></small>
            </h4>
        </div>
    </div>

    <!-- ===== FILTER SECTION ===== -->
    <div class="filter-section">
        <div class="filter-group">
            <!-- Region -->
            <div class="form-group">
                <label for="region_id"><i class="fa fa-map-marker"></i> Region</label>
                <select name="region_id" id="region_id" class="form-control">
                    <option value="">Select</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Country -->
            <div class="form-group" style="min-width: 180px;">
                <label for="country_search"><i class="fa fa-globe"></i> Country</label>
                <select name="country_list[]" id="country_search" multiple="multiple"></select>
            </div>
            <!-- Date Range -->
            <div class="date-group">
                <div>
                    <label><i class="fa fa-calendar"></i> From</label>
                    <input name="formDate" type="text" id="fromDate" class="datepicker form-control" placeholder="DD-MM-YYYY" autocomplete="off">
                </div>
                <div>
                    <label><i class="fa fa-calendar"></i> To</label>
                    <input name="toDate" type="text" id="toDate" class="datepicker form-control" placeholder="DD-MM-YYYY" autocomplete="off">
                </div>
            </div>
            <!-- Invoice Number -->
            <div class="form-group" style="min-width: 160px;">
                <label for="invoice_search"><i class="fa fa-file-text"></i> Invoice No</label>
                <input type="text" id="invoice_search" class="form-control" 
                       placeholder="Enter Invoice No..." autocomplete="off">
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

    <!-- ===== TABLE SEARCH FILTER ===== -->
    <div class="table-search-section" id="tableSearchSection">
        <div class="search-box">
            <i class="fa fa-search"></i>
            <input type="text" id="tableSearchInput" placeholder="Search in table... (Invoice, Item, Party, JO)" onkeyup="filterTable()">
            <button class="clear-search" id="clearSearchBtn" onclick="clearTableSearch()"><i class="fa fa-times-circle"></i></button>
        </div>
        <div class="search-info">
            Total: <strong id="totalRowCount">0</strong> records | 
            Showing: <strong id="visibleRowCount">0</strong> records
        </div>
    </div>

    <!-- ===== TABLE ===== -->
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
                        <th>#</th>
                        <th>Contract No</th>
                        <th>Contract Date</th>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Party Code</th>
                        <th>Party Name</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>SC Qty(Ctn)</th>
                        <th>JO Number</th>
                        <th>JO Qty(Ctn)</th>
                        <th>Rate</th>
                        <th>JO Date</th>
                        <th>JO Creator</th>
                        <th>Contract Creator</th>
                        <th>JO Status</th>
                    </tr>
                </thead>
                <tbody id="reportBody">
                    <tr>
                        <td colspan="17">
                            <div class="no-data">
                                <i class="fa fa-info-circle"></i>
                                Please select filters and click "Show" to load report data
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="report-footer" id="reportFooterInfo" style="display: none;">
        <span><i class="fa fa-clock-o"></i> Generated: <span id="generatedTime">{{ date('d M Y h:i A') }}</span></span>
        <span><i class="fa fa-file-text-o"></i> Total Records: <span id="totalRecords">0</span></span>
    </div>
</div>

<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}">

<script>    
document.title = 'SC VS JO Report';
setTimeout(function() { $('.sr-only').click(); }, 0.0001);

$(function() {
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

    initializeMultiselect();

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

    $('#submitBtn').on('click', function(e) {
        e.preventDefault();
        loadReportData();
    });

    $('.datepicker').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            loadReportData();
        }
    });
    
    $('#invoice_search').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            loadReportData();
        }
    });
});

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

// ===== TABLE SEARCH FUNCTION =====
function filterTable() {
    var input = document.getElementById('tableSearchInput');
    var filter = input.value.toLowerCase().trim();
    var table = document.getElementById('inv');
    var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    var visibleCount = 0;
    var clearBtn = document.getElementById('clearSearchBtn');
    
    // Show clear button if there's text
    if (filter.length > 0) {
        clearBtn.style.display = 'inline-block';
    } else {
        clearBtn.style.display = 'none';
    }
    
    // If no data row with "no-data" class, skip
    if (rows.length === 1 && rows[0].querySelector('.no-data')) {
        return;
    }
    
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var cells = row.getElementsByTagName('td');
        var found = false;
        
        // Skip if row has no-data class
        if (row.querySelector('.no-data')) {
            continue;
        }
        
        // Search through all cells (skip first column - #)
        for (var j = 1; j < cells.length; j++) {
            var cellText = cells[j].textContent.toLowerCase().trim();
            if (cellText.indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        
        if (found) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    }
    
    // Update counts
    var totalRows = rows.length;
    // Count only visible rows (excluding no-data row)
    var totalCount = 0;
    for (var k = 0; k < rows.length; k++) {
        if (!rows[k].querySelector('.no-data') && rows[k].style.display !== 'none') {
            totalCount++;
        }
    }
    // Recalculate total (only data rows)
    var dataRows = 0;
    for (var m = 0; m < rows.length; m++) {
        if (!rows[m].querySelector('.no-data')) {
            dataRows++;
        }
    }
    
    document.getElementById('totalRowCount').textContent = dataRows;
    document.getElementById('visibleRowCount').textContent = visibleCount;
    
    // Show "no results" message if no visible rows
    var noDataRow = rows[0];
    if (visibleCount === 0 && dataRows > 0) {
        // Check if no-data row already exists
        var existingNoData = document.querySelector('#reportBody tr .no-data');
        if (!existingNoData) {
            var newRow = document.createElement('tr');
            newRow.innerHTML = '<td colspan="17"><div class="no-data"><i class="fa fa-info-circle"></i> No matching records found for "<strong>' + filter + '</strong>"</div></td>';
            document.getElementById('reportBody').appendChild(newRow);
        } else {
            existingNoData.closest('tr').style.display = '';
            existingNoData.innerHTML = '<i class="fa fa-info-circle"></i> No matching records found for "<strong>' + filter + '</strong>"';
        }
    } else {
        // Remove no-data row if exists and we have results
        var noDataElement = document.querySelector('#reportBody tr .no-data');
        if (noDataElement) {
            noDataElement.closest('tr').remove();
        }
    }
}

function clearTableSearch() {
    document.getElementById('tableSearchInput').value = '';
    document.getElementById('clearSearchBtn').style.display = 'none';
    filterTable();
}

// Update counts after table render
function updateTableCounts() {
    var rows = document.getElementById('reportBody').getElementsByTagName('tr');
    var dataRows = 0;
    for (var i = 0; i < rows.length; i++) {
        if (!rows[i].querySelector('.no-data')) {
            dataRows++;
        }
    }
    document.getElementById('totalRowCount').textContent = dataRows;
    document.getElementById('visibleRowCount').textContent = dataRows;
}

// ===== VALIDATION FUNCTION =====
function validateFilters() {

    var invoiceNo = $('#invoice_search').val().trim();
    var regionId = $('#region_id').val();
    var selectedCountries = $('#country_search').val();
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    var isValid = true;
    var errorMessage = '';
    // If Invoice No is provided, skip other validations
    if (invoiceNo && invoiceNo !== '') {
        return true;
    }
    
    // Validate Region
    if (!regionId || regionId === '') {
        errorMessage += 'Region is required. ';
        isValid = false;
    }
    
    // Validate Country
    if (!selectedCountries || selectedCountries.length === 0) {
        errorMessage += 'Country is required. ';
        isValid = false;
    }
    
    // Validate Date Range
    if (!fromDate || fromDate === '') {
        errorMessage += 'From Date is required. ';
        isValid = false;
    }
    if (!toDate || toDate === '') {
        errorMessage += 'To Date is required. ';
        isValid = false;
    }
    
    if (fromDate && toDate && !validateDateRange(fromDate, toDate)) {
        errorMessage += 'From Date must be earlier than To Date. ';
        isValid = false;
    }
    
    if (!isValid) {
        showAlert('Please provide either an Invoice No OR all of: Region, Country, From Date, To Date.', 'warning');
    }
    
    return isValid;
}

// ===== LOAD REPORT DATA =====
function loadReportData() {
    // Validate filters first
    if (!validateFilters()) {
        return;
    }

    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    var regionId = $('#region_id').val();
    var selectedCountries = $('#country_search').val();
    var invoiceNo = $('#invoice_search').val().trim();

    $('#alertMessage').hide();
    $('#loadingSpinner').addClass('show');
    $('#reportFooterInfo').hide();
    $('#exportBtn').prop('disabled', true);
    $('#submitBtn').prop('disabled', true).addClass('btn-loading');

    var formData = new FormData();
    formData.append('fromDate', fromDate);
    formData.append('toDate', toDate);
    formData.append('_token', '{{ csrf_token() }}');
    
    if (invoiceNo) {
        formData.append('search', invoiceNo);
    }
    if (regionId && regionId !== '') {
        formData.append('region_id', regionId);
    }
    for (var i = 0; i < selectedCountries.length; i++) {
        formData.append('country_list[]', selectedCountries[i]);
    }

    $.ajax({
        url: "{{url('/json_get/sc_vs_jo_do/data')}}",
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
                    showAlert('Report loaded! ' + response.data.length + ' records found.', 'success');
                    setTimeout(function() {
                        $('#alertMessage').fadeOut('slow');
                    }, 3000);
                    // Update table search counts
                    setTimeout(function() {
                        updateTableCounts();
                    }, 100);
                } else {
                    showNoData('No records found for the selected filters');
                    showAlert('No records found', 'warning');
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

// ===== RENDER TABLE =====
// ===== RENDER TABLE =====
function renderTableData(data) {
    var tbody = $('#reportBody');
    tbody.empty();
    
    if (!data || data.length === 0) {
        showNoData('No records found');
        return;
    }

    var sl = 0;
    $.each(data, function(index, row) {
        sl++;
        
        var joStatus = row.JO_Status || 'No JO';
        var statusClass = joStatus === 'JO Exists' ? 'badge-jo-exists' : 'badge-no-jo';

        var rowHtml = '<tr>' +
            '<td>' + sl + '</td>' +
            '<td title="' + (row.Contract_No || '-') + '">' + (row.Contract_No || '-') + '</td>' +
            '<td>' + (row.Contract_Date || '-') + '</td>' +
            '<td title="' + (row.Invoice_No || '-') + '">' + (row.Invoice_No || '-') + '</td>' +
            '<td>' + (row.Invoice_Date || '-') + '</td>' +
            '<td>' + (row.Party_Code || '-') + '</td>' +
            '<td title="' + (row.Party_Name || '-') + '">' + (row.Party_Name || '-') + '</td>' +
            '<td>' + (row.CI_Item_Code || '-') + '</td>' +
            '<td title="' + (row.CI_Item_Name || '-') + '">' + (row.CI_Item_Name || '-') + '</td>' +
            '<td><strong>' + (row.SC_Qty || '0') + '</strong></td>' +
            '<td title="' + (row.JO_Number || '-') + '">' + (row.JO_Number || '-') + '</td>' +
            '<td><strong>' + (row.JO_Qty || '0') + '</strong></td>' +
            '<td>' + (row.FOB_Rate || '0.00') + '</td>' +
            '<td>' + (row.JO_Date || '-') + '</td>' +
            '<td title="' + (row.JO_Creator || '-') + '">' + (row.JO_Creator || '-') + '</td>' +
            '<td title="' + (row.Contract_Creator || '-') + '">' + (row.Contract_Creator || '-') + '</td>' +
            '<td><span class="' + statusClass + '">' + joStatus + '</span></td>' +
            '</tr>';
        
        tbody.append(rowHtml);
    });
}

// ===== HELPERS =====
function showNoData(message) {
    var tbody = $('#reportBody');
    tbody.empty();
    tbody.html('<tr><td colspan="17"><div class="no-data"><i class="fa fa-info-circle"></i>' + message + '</div></td></tr>');
    $('#exportBtn').prop('disabled', true);
    $('#reportFooterInfo').hide();
    document.getElementById('totalRowCount').textContent = '0';
    document.getElementById('visibleRowCount').textContent = '0';
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
        Swal.fire({
            icon: 'warning',
            title: 'No Data',
            text: 'No data to export. Please load data first.',
            confirmButtonColor: '#e65100',
            confirmButtonText: 'OK'
        });
        return false;
    }

    $(elem).prop('disabled', true).addClass('btn-loading');

    Swal.fire({
        title: 'Exporting...',
        text: 'Please wait while we prepare your file.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: function() {
            Swal.showLoading();
        }
    });

    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    var regionId = $('#region_id').val();
    var selectedCountries = $('#country_search').val();
    var invoiceNo = $('#invoice_search').val().trim();

    var url = "{{ url('/export-sc-vs-jo-report') }}";
    url += '?search=' + encodeURIComponent(invoiceNo);
    url += '&fromDate=' + encodeURIComponent(fromDate);
    url += '&toDate=' + encodeURIComponent(toDate);
    
    if (regionId && regionId !== '') {
        url += '&region_id=' + encodeURIComponent(regionId);
    }
    if (selectedCountries && selectedCountries.length > 0) {
        for (var i = 0; i < selectedCountries.length; i++) {
            url += '&country_list[]=' + encodeURIComponent(selectedCountries[i]);
        }
    }

    window.open(url, '_blank');

    setTimeout(function() {
        Swal.close();
        $(elem).prop('disabled', false).removeClass('btn-loading');
    }, 2000);
}
</script>
@endsection