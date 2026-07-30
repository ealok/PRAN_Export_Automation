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
    .table > tbody > tr > td{
        padding: 6px;
        line-height: 1;
        vertical-align: top;
    }
    .report-header small {
        font-weight: 300;
        opacity: 0.85;
        font-size: 11px;
        letter-spacing: 0.5px;
        margin-left: 6px;
    }
    .header-date-badge {
        background: rgba(255,255,255,0.12);
        padding: 3px 14px;
        border-radius: 30px;
        font-size: 11px;
        border: 1px solid rgba(255,255,255,0.08);
    }

    /* ----- FILTER SECTION - Compact Inline ----- */
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
        transition: background 0.15s;
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
    .custom-table tbody tr:hover td:last-child {
        background: #e3f0ff;
        z-index: 15;
        box-shadow: -4px 0 12px rgba(0,0,0,0.06);
    }
    .custom-table tbody tr:nth-child(even) td {
        background-color: #f9fbfe;
    }
    .custom-table tbody tr:nth-child(even) td:last-child {
        background-color: #f9fbfe;
    }
    .custom-table tbody tr:hover td {
        background-color: #eef4fc !important;
    }
    .custom-table tbody tr:hover td:last-child {
        background-color: #eef4fc !important;
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
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.92);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 100;
        border-radius: 8px;
    }
    .loading-overlay.show { display: flex; }
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
        pointer-events: none;
    }
    .required-hint {
        font-size: 10px;
        color: #8a9bb5;
        font-weight: 400;
        text-transform: none;
        letter-spacing: 0;
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
    }

    /* ============================================================
       MULTISELECT - Fixed spacing between checkbox and text
       ============================================================ */
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
    .multiselect-container li a label .multiselect-text {
        flex: 1 !important;
        padding-left: 2px !important;
        font-size: 11px !important;
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
    .multiselect-container li.multiselect-all a:hover {
        background: #e3edf7 !important;
    }
    .multiselect-container li.multiselect-all a label {
        font-weight: 700 !important;
        color: #0b2a4a !important;
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
    <!-- ===== HEADER ===== -->
    <div class="report-header">
        <div>
            <h4>
                <i class="fa fa-file-text-o"></i>GP Details Report
                <small></small>
            </h4>
        </div>
        <div class="header-date-badge">
            <i class="fa fa-calendar"></i> 
            <span id="currentDate">{{ date('d M Y') }}</span>
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

    <!-- ===== TABLE ===== -->
    <div class="custom-table-wrapper" id="tableContainer">
        {{-- <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner">
                <div class="spinner-border"></div>
                <p>Loading report data...</p>
            </div>
        </div> --}}
        <div class="table-scroll">
            <table class="custom-table table" id="inv">
                <thead>
                    <tr>
                        <th>Contract No</th>
                        <th>Contract Date</th>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Pcs/Ctn</th>
                        <th>Total CTN</th>
                        <th>Total PCS</th>
                        <th>FOB</th>
                        <th>Mate Cost</th>
                        <th style="min-width:75px;">GP %</th>
                    </tr>
                </thead>
                <tbody id="reportBody">
                    <tr>
                        <td colspan="12">
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
    {{-- <div class="report-footer" id="reportFooterInfo" style="display: none;">
        <span><i class="fa fa-clock-o"></i> Generated: <span id="generatedTime">{{ date('d M Y h:i A') }}</span></span>
        <span><i class="fa fa-file-text-o"></i> Total Invoices: <span id="totalRecords">0</span></span>
    </div> --}}
</div>

<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}">

<script>
document.title = 'GP Details | Report';
 setTimeout(function() {           // toggle btn 
      $('.sr-only').click();
    },0.0001);
$(function() {
    // ===== Initialize Datepickers =====
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

    // ===== Initialize Country Multiselect =====
    initializeMultiselect();

    // ===== Region Change - Load Countries =====
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

    // ===== Enter key on date fields =====
    $('.datepicker').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            loadReportData();
        }
    });
});

// ===== MULTISELECT INIT =====
function initializeMultiselect(emptyState) {
    emptyState = emptyState || false;
    
    var config = {
        columns: 1,
        placeholder: emptyState ? 'Select region first' : 'Search & select',
        search: !emptyState,
        searchOptions: {
            'default': 'Search countries...'
        },
        selectAll: !emptyState,
        selectAllText: '✓ Select All Countries',
        includeSelectAllOption: !emptyState,
        enableFiltering: !emptyState,
        filterPlaceholder: 'Search countries...',
        enableCaseInsensitiveFiltering: true,
        maxHeight: 300,
        buttonClass: 'btn btn-block',
        buttonWidth: '100%',
        nonSelectedText: emptyState ? 'Select region first' : 'Select countries',
        nSelectedText: 'selected',
        allSelectedText: 'All selected',
        onDropdownShow: function() {
            setTimeout(function() {
                $('.multiselect-search').focus();
            }, 100);
        }
    };

    $('#country_search').multiselect(config);
}

// ===== LOAD REPORT DATA =====
// ===== LOAD REPORT DATA =====
function loadReportData() {

    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    var regionId = $('#region_id').val();
    var selectedCountries = $('#country_search').val();
    var invoiceNo = $('#invoice_search').val().trim(); // Get invoice number
    // If invoice number is provided, only dates are required
    if(invoiceNo && invoiceNo !== '') {
        
        if (!fromDate || !toDate) {
            showAlert('Please select both From and To dates for invoice search', 'warning');
            return;
        }
        
        if (!validateDateRange(fromDate, toDate)) {
            showAlert('From date must be earlier than To date', 'danger');
            return;
        }
        
    } else {

        // Validate Region
        if (!regionId || regionId === '') {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Selection Required',
                    text: 'Please select a region!',
                    confirmButtonColor: '#1e4a7a',
                    confirmButtonText: 'OK'
                });
            } else {
                alert('Please select a region!');
            }
            return;
        }
        
        // Validate Country
        if (!selectedCountries || selectedCountries.length === 0) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Selection Required',
                    text: 'Please select at least one country!',
                    confirmButtonColor: '#1e4a7a',
                    confirmButtonText: 'OK'
                });
            } else {
                alert('Please select at least one country!');
            }
            return;
        }
        
        // Validate Dates
        if (!fromDate || !toDate) {
            showAlert('Please select both From and To dates', 'danger');
            return;
        }
        
        if (!validateDateRange(fromDate, toDate)) {
            showAlert('From date must be earlier than To date', 'danger');
            return;
        }
    }


    $('#alertMessage').hide();
    $('#loadingOverlay').addClass('show');
    $('#inv').show();
    $('#reportFooterInfo').hide();
    $('#exportBtn').prop('disabled', true);
    $('#submitBtn').prop('disabled', true).addClass('btn-loading');

    var formData = new FormData();
    formData.append('fromDate', fromDate);
    formData.append('toDate', toDate);
    formData.append('_token', '{{ csrf_token() }}');
    if (invoiceNo && invoiceNo !== '') {
        formData.append('invoice_search', invoiceNo);
    }

    if (regionId && regionId !== '') {
        formData.append('region_id', regionId);
    }
    
    if (selectedCountries && selectedCountries.length > 0) {
        for (var i = 0; i < selectedCountries.length; i++) {
            formData.append('country_list[]', selectedCountries[i]);
        }
    }

    $.ajax({
        url: "{{ url('/json_get/gp_details/data') }}",
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
                    
                    var message = invoiceNo ? 
                        'Found ' + response.data.length + ' records matching "' + invoiceNo + '"' : 
                        'Report loaded! ' + response.data.length + ' records found.';
                    showAlert(message, 'success');
                    setTimeout(function() {
                        $('#alertMessage').fadeOut('slow');
                    }, 3000);
                } else {
                    var message = invoiceNo ? 
                        'No records found for "' + invoiceNo + '"' : 
                        'No records found for the selected filters';
                    showNoData(message);
                    showAlert(message, 'warning');
                }
            } else {
                showNoData('Error: ' + (response.message || 'Unknown error'));
                showAlert('Error: ' + (response.message || 'Unknown error'), 'danger');
            }
        },
        error: function(xhr, status, error) {
            var msg = 'Failed to load report. ';
            if (status === 'timeout') {
                msg += 'Request timed out.';
            } else if (xhr.status === 404) {
                msg += 'URL not found.';
            } else if (xhr.status === 500) {
                msg += 'Server error.';
            } else {
                msg += 'Please try again.';
            }
            showNoData(msg);
            showAlert(msg, 'danger');
        },
        complete: function() {
            $('#loadingOverlay').removeClass('show');
            $('#submitBtn').prop('disabled', false).removeClass('btn-loading');
        }
    });
}

// ===== RENDER TABLE =====
function renderTableData(data) {
    var tbody = $('#reportBody');
    tbody.empty();
    
    if (!data || data.length === 0) {
        showNoData('No records found');
        return;
    }

    $.each(data, function(index, result) {
        var gpPercent = parseFloat(result['GP Percentage'] || 0);
        var gpClass = gpPercent >= 0 ? 'gp-positive' : 'gp-negative';
        
        var row = '<tr>' +
            '<td>' + (result['Contract No'] || '-') + '</td>' +
            '<td>' + (result['Contract Date'] || '-') + '</td>' +
            '<td>' + (result['Invoice No'] || '-') + '</td>' +
            '<td>' + (result['Invoice Date'] || '-') + '</td>' +
            '<td>' + (result['Item Code'] || '-') + '</td>' +
            '<td>' + (result['Item Name'] || '-') + '</td>' +
            '<td>' + (result['Factor'] || '-') + '</td>' +
            '<td style="text-align:center;">' + (result['CTN'] || 0) + '</td>' +
            '<td style="text-align:center;">' + (result['Total PCS'] || 0) + '</td>' +
            '<td style="text-align:center;">' + (result['Per PCS Rate (FOB)'] || 0) + '</td>' +
            '<td style="text-align:center;">' + (result['Prime Cost (Mate Cost/PCS)'] || 0) + '</td>' +
            '<td style="text-align:right;font-weight:700;" class="' + gpClass + '">' + gpPercent.toFixed(2) + '%</td>' +
            '</tr>';
        tbody.append(row);
    });

    $('#inv').show();
}

// ===== HELPERS =====
function showNoData(message) {
    var tbody = $('#reportBody');
    tbody.empty();
    tbody.html('<tr><td colspan="12"><div class="no-data"><i class="fa fa-info-circle"></i>' + message + '</div></td></tr>');
    $('#inv').show();
    $('#reportFooterInfo').hide();
    $('#exportBtn').prop('disabled', true);
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

// ===== EXPORT =====
function exportF(elem) {
    if ($('#reportBody tr').length === 0 || $('#reportBody tr td .no-data').length > 0) {
        showAlert('No data to export', 'warning');
        return false;
    }

    $(elem).prop('disabled', true).addClass('btn-loading');

    try {
        // Start with headers only - no extra information
        var content = '';
        
        // Get headers from the table
        var headers = [];
        $('#inv thead th').each(function() {
            headers.push($(this).text().trim());
        });
        content += headers.join('\t') + '\n';

        // Get data rows
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
        a.download = 'GP_Details.xls';  // Simple filename without date
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
</script>
@endsection