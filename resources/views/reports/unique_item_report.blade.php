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
    .filter-group .form-group label .required-star {
        color: #d0314a;
        margin-left: 2px;
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
    .date-group label .required-star {
        color: #d0314a;
        margin-left: 2px;
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
    .date-group input.error {
        border-color: #d0314a;
        background: #fff5f5;
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
        min-width: 1300px;
        background: #fff;
        margin-bottom: 0;
    }
    .custom-table thead th {
        background: #0b2a4a;
        color: #ffffff;
        text-align: center;
        text-transform: uppercase;
        font-size: 8px;
        font-weight: 700;
        letter-spacing: 0.3px;
        padding: 8px 6px;
        border: 1px solid #0b2a4a;
        position: sticky;
        top: 0;
        z-index: 20;
        white-space: nowrap;
    }
    .custom-table tbody td {
        padding: 6px 6px;
        border: 1px solid #e2e8f0;
        vertical-align: middle;
        color: #1a2a44;
        font-weight: 500;
        white-space: nowrap;
        transition: all 0.2s ease;
        font-size: 10px;
        text-align: center;
    }
    .custom-table tbody tr:hover td {
        background-color: #f0f6fe !important;
    }
    .custom-table tbody tr:nth-child(even):hover td {
        background-color: #eaf2fa !important;
    }
    .custom-table tbody tr:nth-child(even) td {
        background-color: #f9fbfe;
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
        .custom-table { font-size: 9px; min-width: 1000px; }
        .report-header { flex-direction: column; align-items: flex-start; gap: 6px; }
        .table-search-section { flex-direction: column; align-items: stretch; }
        .table-search-section .search-box { min-width: 100%; }
    }
    @media (max-width: 576px) {
        .custom-table { font-size: 8px; min-width: 800px; }
        .custom-table thead th { font-size: 7px; padding: 4px 3px; }
        .custom-table tbody td { font-size: 7px; padding: 3px 3px; }
    }

    /* ===== MULTISELECT FIX ===== */
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

    /* ===== CTN Badge ===== */
    .badge-ctn {
        display: inline-block;
        background: #e3edf7;
        color: #1e4a7a;
        padding: 1px 6px;
        border-radius: 4px;
        font-size: 8px;
        font-weight: 600;
        margin-left: 4px;
    }
</style>

<div class="container-fluid">
    <div class="report-header">
        <div>
            <h4>
                <i class="fa fa-file-text-o"></i> Unique Item Report
                <small></small>
            </h4>
        </div>
    </div>

    <!-- ===== FILTER SECTION ===== -->
    <div class="filter-section">
        <div class="filter-group">
            <div class="form-group">
                <label for="region_id"><i class="fa fa-map-marker"></i> Region <span class="required-star">*</span></label>
                <select name="region_id" id="region_id" class="form-control">
                    <option value="">Select</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="min-width: 180px;">
                <label for="country_search"><i class="fa fa-globe"></i> Country <span class="required-star">*</span></label>
                <select name="country_list[]" id="country_search" multiple="multiple"></select>
            </div>
            <div class="date-group">
                <div>
                    <label><i class="fa fa-calendar"></i> From <span class="required-star">*</span></label>
                    <input name="formDate" type="text" id="fromDate" class="datepicker form-control" placeholder="DD-MM-YYYY" autocomplete="off">
                </div>
                <div>
                    <label><i class="fa fa-calendar"></i> To <span class="required-star">*</span></label>
                    <input name="toDate" type="text" id="toDate" class="datepicker form-control" placeholder="DD-MM-YYYY" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="action-group">
            <button class="btn-submit" id="submitBtn"><i class="fa fa-search"></i> Show</button>
            <button class="btn-export-excel" id="exportBtn" onclick="exportF(this)" disabled><i class="fa fa-file-excel-o"></i> Export</button>
        </div>
    </div>

    <!-- Alert -->
    <div class="alert-custom" id="alertMessage"></div>

    <!-- ===== TABLE SEARCH FILTER ===== -->
    <div class="table-search-section" id="tableSearchSection">
        <div class="search-box">
            <i class="fa fa-search"></i>
            <input type="text" id="tableSearchInput" placeholder="Search in table..." onkeyup="filterTable()">
            <button class="clear-search" id="clearSearchBtn" onclick="clearTableSearch()"><i class="fa fa-times-circle"></i></button>
        </div>
        <div class="search-info">
            Total: <strong id="totalRowCount">0</strong> | Showing: <strong id="visibleRowCount">0</strong>
        </div>
    </div>

    <!-- ===== TABLE ===== -->
    <div class="custom-table-wrapper" id="tableContainer">
        <div class="table-scroll">
            <table class="custom-table table" id="inv">
                <thead>
                    <tr>
                        <th style="min-width:40px;">#</th>
                        <th style="min-width:120px;">Report Month</th>
                        <th style="min-width:80px;">Total Items</th>
                        <th style="min-width:80px;">New Items</th>
                        <th style="min-width:80px;">Old Items</th>
                        <th style="min-width:80px;">Unique Items</th>
                        <th style="min-width:80px;">Total JO</th>
                        <th style="min-width:80px;">Total DO</th>
                        <th style="min-width:110px;">Total JO Qty <span class="badge-ctn">CTN</span></th>
                        <th style="min-width:110px;">Total DO Qty <span class="badge-ctn">CTN</span></th>
                        <th style="min-width:110px;">Pending Qty <span class="badge-ctn">CTN</span></th>
                        <th style="min-width:100px;">Total Value</th>
                        <th style="min-width:110px;">Avg DO/DO <span class="badge-ctn">CTN</span></th>
                        <th style="min-width:110px;">Avg JO/JO <span class="badge-ctn">CTN</span></th>
                    </tr>
                </thead>
                <tbody id="reportBody">
                    <tr>
                        <td colspan="14">
                            <div class="no-data">
                                <i class="fa fa-info-circle"></i>
                                Please select filters and click "Show"
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="report-footer" id="reportFooterInfo" style="display: none;">
        <span><i class="fa fa-clock-o"></i> Generated: <span id="generatedTime"></span></span>
        <span><i class="fa fa-file-text-o"></i> Total New Items: <span id="totalRecords">0</span></span>
    </div>
</div>

<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}">

<script>    
document.title = 'Unique Item Report';
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

// ===== TABLE SEARCH =====
function filterTable() {
    var input = document.getElementById('tableSearchInput');
    var filter = input.value.toLowerCase().trim();
    var rows = document.querySelectorAll('#reportBody tr');
    var visibleCount = 0;
    var clearBtn = document.getElementById('clearSearchBtn');
    
    clearBtn.style.display = filter.length > 0 ? 'inline-block' : 'none';
    
    if (rows.length === 1 && rows[0].querySelector('.no-data')) return;
    
    var dataRows = 0;
    rows.forEach(function(row) {
        if (row.querySelector('.no-data')) return;
        dataRows++;
        var cells = row.getElementsByTagName('td');
        var found = false;
        for (var j = 0; j < cells.length; j++) {
            if (cells[j].textContent.toLowerCase().trim().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        row.style.display = found ? '' : 'none';
        if (found) visibleCount++;
    });
    
    document.getElementById('totalRowCount').textContent = dataRows;
    document.getElementById('visibleRowCount').textContent = visibleCount;
    
    var existing = document.querySelector('#reportBody tr .no-data');
    if (visibleCount === 0 && dataRows > 0) {
        if (!existing) {
            var newRow = document.createElement('tr');
            newRow.innerHTML = '<td colspan="14"><div class="no-data"><i class="fa fa-info-circle"></i> No matching records for "<strong>' + filter + '</strong>"</div></td>';
            document.getElementById('reportBody').appendChild(newRow);
        }
    } else if (existing) {
        existing.closest('tr').remove();
    }
}

function clearTableSearch() {
    document.getElementById('tableSearchInput').value = '';
    document.getElementById('clearSearchBtn').style.display = 'none';
    filterTable();
}

function updateTableCounts() {
    var rows = document.querySelectorAll('#reportBody tr');
    var dataRows = 0;
    rows.forEach(function(row) {
        if (!row.querySelector('.no-data')) dataRows++;
    });
    document.getElementById('totalRowCount').textContent = dataRows;
    document.getElementById('visibleRowCount').textContent = dataRows;
}

// ===== VALIDATION =====
function validateFilters() {
    var regionId = $('#region_id').val();
    var countries = $('#country_search').val();
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    
    if (!regionId) {
        showAlert('Please select a Region', 'warning');
        return false;
    }
    if (!countries || countries.length === 0) {
        showAlert('Please select at least one Country', 'warning');
        return false;
    }
    if (!fromDate || !toDate) {
        showAlert('Please select both From Date and To Date', 'warning');
        return false;
    }
    if (!validateDateRange(fromDate, toDate)) {
        showAlert('From date must be earlier than or equal to To date', 'danger');
        return false;
    }
    return true;
}

// ===== LOAD DATA =====
function loadReportData() {
    if (!validateFilters()) return;

    var formData = new FormData();
    formData.append('fromDate', $('#fromDate').val());
    formData.append('toDate', $('#toDate').val());
    formData.append('_token', '{{ csrf_token() }}');
    
    var regionId = $('#region_id').val();
    if (regionId) formData.append('region_id', regionId);
    
    var countries = $('#country_search').val();
    if (countries) {
        for (var i = 0; i < countries.length; i++) {
            formData.append('country_list[]', countries[i]);
        }
    }

    $('#alertMessage').hide();
    $('#loadingSpinner').addClass('show');
    $('#reportFooterInfo').hide();
    $('#exportBtn').prop('disabled', true);
    $('#submitBtn').prop('disabled', true).addClass('btn-loading');

    $.ajax({
        url: "{{url('/json_get/unique_item/report_data')}}",
        type: "POST",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        timeout: 30000,
        success: function(response) {
            if (response.status === 'success' && response.data && response.data.length > 0) {
                renderTableData(response.data);
                $('#totalRecords').text(response.data.length);
                $('#generatedTime').text(new Date().toLocaleString());
                $('#reportFooterInfo').show();
                $('#exportBtn').prop('disabled', false);
                showAlert('Loaded ' + response.data.length + ' records', 'success');
                setTimeout(function() { $('#alertMessage').fadeOut('slow'); }, 3000);
                setTimeout(updateTableCounts, 100);
            } else {
                showNoData(response.message || 'No records found');
                showAlert('No records found', 'warning');
            }
        },
        error: function(xhr, status) {
            var msg = 'Failed to load. ';
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

// ===== RENDER TABLE (UPDATED - CTN) =====
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
        
        var rowHtml = '<tr>' +
            '<td>' + sl + '</td>' +
            '<td><strong>' + (row.Report_Month_Name || '-') + '</strong></td>' +
            '<td><strong>' + (row.Total_Items || '0') + '</strong></td>' +
            '<td><span style="color:#1a8a4a;font-weight:600;">' + (row.New_Items || '0') + '</span></td>' +
            '<td><span style="color:#b86a1a;font-weight:600;">' + (row.Old_Items || '0') + '</span></td>' +
            '<td><span style="color:#1e4a7a;font-weight:700;">' + (row.Unique_Items || '0') + '</span></td>' +
            '<td><span style="color:#5e35b1;font-weight:600;">' + (row.Total_JO || '0') + '</span></td>' +
            '<td><span style="color:#0d47a1;font-weight:600;">' + (row.Total_DO || '0') + '</span></td>' +
            '<td><strong>' + (row.Total_JO_Qty_CTN || '0.00') + '</strong></td>' +
            '<td><strong>' + (row.Total_DO_Qty_CTN || '0.00') + '</strong></td>' +
            '<td><strong style="color:#c62828;">' + (row.Total_Pending_Qty_CTN || '0.00') + '</strong></td>' +
            '<td><strong style="color:#1e4a7a;">' + (row.Total_Value || '0.000') + '</strong></td>' +
            '<td>' + (row.Avg_DO_Qty_CTN_Per_DO || '0.00') + '</td>' +
            '<td>' + (row.Avg_JO_Qty_CTN_Per_JO || '0.00') + '</td>' +
            '</tr>';
        
        tbody.append(rowHtml);
    });
    
    $('#totalRecords').text(data.length);
}

// ===== HELPERS =====
function showNoData(message) {
    var tbody = $('#reportBody');
    tbody.html('<tr><td colspan="14"><div class="no-data"><i class="fa fa-info-circle"></i> ' + message + '</div></td></tr>');
    $('#exportBtn').prop('disabled', true);
    $('#reportFooterInfo').hide();
    document.getElementById('totalRowCount').textContent = '0';
    document.getElementById('visibleRowCount').textContent = '0';
}

function showAlert(message, type) {
    var alertDiv = $('#alertMessage');
    alertDiv.removeClass('alert-danger alert-success alert-warning').addClass('alert-' + type);
    var icon = type === 'danger' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle';
    alertDiv.html('<i class="fa fa-' + icon + '"></i> ' + message).show();
    if (type === 'success') setTimeout(function() { alertDiv.fadeOut('slow'); }, 5000);
}

function validateDateRange(fromDate, toDate) {
    var from = parseDate(fromDate);
    var to = parseDate(toDate);
    return from && to && from <= to;
}

function parseDate(dateStr) {
    var parts = dateStr.split('-');
    if (parts.length !== 3) return null;
    var day = parseInt(parts[0]), month = parseInt(parts[1]) - 1, year = parseInt(parts[2]);
    if (isNaN(day) || isNaN(month) || isNaN(year)) return null;
    return new Date(year, month, day);
}

// ===== EXPORT =====
function exportF(elem) {
    if ($('#reportBody tr').length === 0 || $('#reportBody tr td .no-data').length > 0) {
        Swal.fire({ icon: 'warning', title: 'No Data', text: 'No data to export.', confirmButtonColor: '#e65100' });
        return false;
    }

    $(elem).prop('disabled', true).addClass('btn-loading');
    Swal.fire({ title: 'Exporting...', text: 'Please wait...', allowOutsideClick: false, didOpen: function() { Swal.showLoading(); } });

    var url = "{{ url('/export-unique-item-report') }}";
    var params = [];
    var fromDate = $('#fromDate').val();
    if (fromDate) params.push('fromDate=' + encodeURIComponent(fromDate));
    var toDate = $('#toDate').val();
    if (toDate) params.push('toDate=' + encodeURIComponent(toDate));
    var regionId = $('#region_id').val();
    if (regionId) params.push('region_id=' + encodeURIComponent(regionId));
    var countries = $('#country_search').val();
    if (countries) {
        for (var i = 0; i < countries.length; i++) {
            params.push('country_list[]=' + encodeURIComponent(countries[i]));
        }
    }
    if (params.length > 0) url += '?' + params.join('&');

    window.open(url, '_blank');
    setTimeout(function() {
        Swal.close();
        $(elem).prop('disabled', false).removeClass('btn-loading');
    }, 2000);
    return false;
}
</script>
@endsection