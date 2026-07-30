@extends('layouts.master')
@section('content')
<style>
    /* ===== REPORT STYLING ===== */
    * { box-sizing: border-box; }
    
    .report-header {
        background: linear-gradient(145deg, #0b2a4a 0%, #1e4a7a 100%);
        color: #fff;
        padding: 10px 20px;
        border-radius: 6px 6px 0 0;
        margin-bottom: 15px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
    }
    .report-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .report-header h4 i {
        font-size: 16px;
        opacity: 0.85;
    }

    /* ===== FILTER SECTION ===== */
    .filter-section {
        background: #ffffff;
        padding: 10px 16px;
        border-radius: 6px;
        margin-bottom: 15px;
        border: 1px solid #e8ecf1;
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
        min-width: 100px;
        flex: 0 1 auto;
    }
    .filter-group .form-group label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        color: #4a5f7a;
        margin-bottom: 2px;
        letter-spacing: 0.3px;
    }
    .filter-group .form-group select,
    .filter-group .form-group input {
        width: 100%;
        padding: 3px 8px;
        border: 1px solid #d6dee9;
        border-radius: 4px;
        background: #fafcff;
        font-size: 11px;
        height: 28px;
        color: #1f2a44;
        transition: 0.2s;
    }
    .filter-group .form-group select:focus,
    .filter-group .form-group input:focus {
        border-color: #1e4a7a;
        outline: none;
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.08);
    }
    .date-group {
        display: flex;
        align-items: flex-end;
        gap: 4px 8px;
        flex-wrap: wrap;
    }
    .date-group > div {
        flex: 0 1 auto;
        min-width: 70px;
    }
    .date-group label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        color: #4a5f7a;
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 3px;
    }
    .date-group label i {
        color: #2a5298;
        font-size: 11px;
    }
    .date-group input {
        padding: 3px 8px;
        border: 1px solid #d6dee9;
        border-radius: 4px;
        background: #fafcff;
        font-size: 11px;
        min-width: 70px;
        height: 28px;
        transition: 0.2s;
    }
    .date-group input:focus {
        border-color: #1e4a7a;
        outline: none;
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.08);
    }
    .action-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px;
        margin-left: auto;
    }
    .btn-submit, .btn-export-excel {
        border: none;
        padding: 3px 14px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        cursor: pointer;
        height: 28px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: 0.2s;
        letter-spacing: 0.3px;
    }
    .btn-submit {
        background: #1a4a7a;
        color: #fff;
    }
    .btn-submit:hover {
        background: #0f3b63;
    }
    .btn-export-excel {
        background: #1f8b4c;
        color: #fff;
    }
    .btn-export-excel:hover {
        background: #14733b;
    }
    .btn-submit:disabled, .btn-export-excel:disabled {
        opacity: 0.55;
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

    /* ===== TABLE WITH FIXED LAST COLUMN ===== */
    .custom-table-wrapper {
        border-radius: 6px;
        border: 1px solid #e8ecf1;
        overflow: hidden;
        background: #fff;
        position: relative;
    }
    
    .table-scroll-container {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 550px;
        position: relative;
    }
    
    /* Track for scrollbar */
    .table-scroll-container::-webkit-scrollbar {
        height: 8px;
        width: 8px;
    }
    .table-scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .table-scroll-container::-webkit-scrollbar-thumb {
        background: #c1c7d0;
        border-radius: 4px;
    }
    .table-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #a8b0bb;
    }
    
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 11px;
        background: #fff;
        margin-bottom: 0;
        table-layout: fixed;
    }
    
    /* Fixed Last Column */
    .custom-table th:last-child,
    .custom-table td:last-child {
        position: sticky;
        right: 0;
        z-index: 10;
        background: #ffffff;
        border-left: 2px solid #d6dee9;
        box-shadow: -2px 0 5px rgba(0,0,0,0.05);
        min-width: 80px;
        max-width: 100px;
        width: 80px;
    }
    
    .custom-table thead th:last-child {
        background: #1a2a4a;
        z-index: 20;
        border-left: 2px solid #2a3a5a;
    }
    
    /* Even row background for fixed column */
    .custom-table tbody tr:nth-child(even) td:last-child {
        background: #fafcff;
    }
    
    .custom-table tbody tr:hover td:last-child {
        background: #f0f4fa;
    }
    
    /* Column Widths */
    .custom-table th:nth-child(1), .custom-table td:nth-child(1) { width: 4%; min-width: 35px; }
    .custom-table th:nth-child(2), .custom-table td:nth-child(2) { width: 10%; min-width: 90px; }
    .custom-table th:nth-child(3), .custom-table td:nth-child(3) { width: 8%; min-width: 80px; }
    .custom-table th:nth-child(4), .custom-table td:nth-child(4) { width: 8%; min-width: 80px; }
    .custom-table th:nth-child(5), .custom-table td:nth-child(5) { width: 7%; min-width: 70px; }
    .custom-table th:nth-child(6), .custom-table td:nth-child(6) { width: 10%; min-width: 90px; }
    .custom-table th:nth-child(7), .custom-table td:nth-child(7) { width: 8%; min-width: 70px; }
    .custom-table th:nth-child(8), .custom-table td:nth-child(8) { width: 8%; min-width: 70px; }
    .custom-table th:nth-child(9), .custom-table td:nth-child(9) { width: 8%; min-width: 70px; }
    .custom-table th:nth-child(10), .custom-table td:nth-child(10) { width: 12%; min-width: 100px; }
    .custom-table th:nth-child(11), .custom-table td:nth-child(11) { width: 7%; min-width: 80px; }
    
    .custom-table thead th {
        background: #1a2a4a;
        color: #ffffff;
        text-align: center;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 7px 4px;
        border: 1px solid #1a2a4a;
        position: sticky;
        top: 0;
        z-index: 15;
        white-space: nowrap;
    }
    
    .custom-table thead th:last-child {
        z-index: 20;
    }
    
    .custom-table tbody td {
        padding: 6px 4px;
        border-bottom: 1px solid #eef2f7;
        text-align: center;
        font-size: 11px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .custom-table tbody tr:hover td {
        background: #f0f4fa;
    }
    .custom-table tbody tr:nth-child(even) td {
        background: #fafcff;
    }
    .custom-table tbody tr:nth-child(even):hover td {
        background: #f0f4fa;
    }
    
    .badge-status {
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
        white-space: nowrap;
    }
    .badge-delivered {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .badge-partial {
        background: #fff3e0;
        color: #e65100;
    }
    .badge-pending {
        background: #fce4ec;
        color: #c62828;
    }
    .no-data {
        text-align: center;
        padding: 30px 20px;
        color: #6a7b9c;
        font-size: 11px;
    }
    .no-data i { font-size: 28px; display: block; margin-bottom: 8px; color: #d0d9e8; }

    /* ===== MULTISELECT ===== */
    .multiselect-container {
        width: 100% !important;
        min-width: 260px !important;
        max-width: 400px !important;
        border-radius: 4px !important;
        border: 1px solid #c5d0df !important;
        box-shadow: 0 4px 15px rgba(0, 20, 50, 0.10) !important;
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
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.08) !important;
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
        border-bottom: 1px solid #e8ecf1 !important;
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
    .btn.multiselect {
        background: #fafcff !important;
        border: 1px solid #d6dee9 !important;
        border-radius: 4px !important;
        padding: 3px 8px !important;
        font-weight: 500 !important;
        text-align: left !important;
        color: #1f2a44 !important;
        width: 100% !important;
        font-size: 11px !important;
        height: 28px !important;
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
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.08) !important;
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

    /* ===== SCROLL INDICATOR ===== */
    .scroll-indicator {
        position: sticky;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to right, transparent, rgba(26, 42, 74, 0.05) 40%, rgba(26, 42, 74, 0.1));
        padding: 4px 0;
        text-align: center;
        font-size: 9px;
        color: #8a9bb5;
        border-top: 1px solid #e8ecf1;
        display: none;
        z-index: 5;
    }
    .scroll-indicator i {
        margin: 0 4px;
    }
    .scroll-indicator.show {
        display: block;
    }

    @media (max-width: 768px) {
        .multiselect-container {
            min-width: 220px !important;
            max-width: 320px !important;
        }
        .filter-section { flex-direction: column; align-items: stretch; }
        .filter-group { flex-direction: column; align-items: stretch; }
        .filter-group .form-group { min-width: 100%; }
        .date-group { flex-direction: column; align-items: stretch; }
        .date-group > div { min-width: 100%; }
        .action-group { margin-left: 0; flex-wrap: wrap; }
        .btn-submit, .btn-export-excel { width: 100%; justify-content: center; }
        
        .custom-table td, .custom-table th {
            font-size: 9px;
            padding: 4px 2px !important;
        }
        .custom-table th:last-child,
        .custom-table td:last-child {
            min-width: 60px;
            width: 60px;
        }
    }
</style>

<div class="container-fluid">
    <!-- HEADER -->
    <div class="report-header">
        <h4><i class="fa fa-file-text-o"></i>Shipment Tracking Report</h4>
    </div>

    <!-- FILTER SECTION -->
    <div class="filter-section">
        <div class="filter-group">
            <div class="form-group">
                <label for="region_id"><i class="fa fa-map-marker"></i> Region</label>
                <select name="region_id" id="region_id" class="form-control">
                    <option value="">Select</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="min-width: 160px;">
                <label for="country_search"><i class="fa fa-globe"></i> Country</label>
                <select name="country_list[]" id="country_search" multiple="multiple"></select>
            </div>
            <div class="form-group" style="min-width: 160px;">
                <label for="party_search"><i class="fa fa-user"></i> Party</label>
                <select name="party_list[]" id="party_search" multiple="multiple"></select>
            </div>
            <div class="date-group">
                <div>
                    <label><i class="fa fa-calendar"></i> From</label>
                    <input type="text" id="fromDate" class="datepicker form-control" placeholder="DD-MM-YYYY" autocomplete="off">
                </div>
                <div>
                    <label><i class="fa fa-calendar"></i> To</label>
                    <input type="text" id="toDate" class="datepicker form-control" placeholder="DD-MM-YYYY" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="action-group">
            <button class="btn-submit" id="submitBtn"><i class="fa fa-search"></i> Show</button>
            <button class="btn-export-excel" id="exportBtn" onclick="exportF(this)" disabled><i class="fa fa-file-excel-o"></i> Export</button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="custom-table-wrapper">
        <div class="table-scroll-container" id="tableScrollContainer">
            <table class="custom-table" id="shipmentTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Party Code</th>
                        <th>Party Name</th>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Container</th>
                        <th>Issue Date</th>
                        <th>Order Number</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>SC QTY</th>
                        <th>Order QTY</th>
                        <th>Due Qty</th>
                        <th>Factory</th>
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
            </table>
        </div>
        <div class="scroll-indicator" id="scrollIndicator">
            <i class="fa fa-arrows-h"></i> Scroll right to see Status <i class="fa fa-arrow-right"></i>
        </div>
    </div>
</div>

<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}">
<script>
$(function() {
    // ===== DATE PICKER =====
    $(".datepicker").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        autoclose: true,
        showOn: 'focus',
        yearRange: 'c-10:c+10'
    });
    
    var today = new Date();
    var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    $('#fromDate').datepicker('setDate', firstDay);
    $('#toDate').datepicker('setDate', today);

    // ===== MULTISELECT INITIALIZATION =====
    initializeCountryMultiselect();
    initializePartyMultiselect(true);

    // ===== SCROLL INDICATOR =====
    $('#tableScrollContainer').on('scroll', function() {
        var scrollLeft = $(this).scrollLeft();
        var maxScroll = $(this)[0].scrollWidth - $(this).width();
        
        if (scrollLeft > 50) {
            $('#scrollIndicator').fadeOut(300);
        } else {
            $('#scrollIndicator').fadeIn(300);
        }
    });

    // Check if scroll is needed after data load
    function checkScrollNeeded() {
        var container = $('#tableScrollContainer')[0];
        if (container) {
            if (container.scrollWidth > container.clientWidth) {
                $('#scrollIndicator').addClass('show');
            } else {
                $('#scrollIndicator').removeClass('show');
            }
        }
    }

    // ===== REGION CHANGE =====
    $('#region_id').on('change', function() {
        var regionId = $(this).val();
        if (regionId) {
            $.get("{{ url('/json/get_region_wise_country_list') }}?region_id=" + regionId, function(res) {
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
                initializeCountryMultiselect(false);
                resetPartyMultiselect();
            });
        } else {
            if ($('#country_search').data('multiselect')) {
                $('#country_search').multiselect('destroy');
            }
            $('#country_search').html('');
            initializeCountryMultiselect(true);
            resetPartyMultiselect();
        }
    });

    // ===== COUNTRY CHANGE =====
    $('#country_search').on('change', function() {
        var selectedCountries = $(this).val();
        if (selectedCountries && selectedCountries.length > 0) {
            loadPartiesByCountries(selectedCountries);
        } else {
            resetPartyMultiselect();
        }
    });

    // ===== SUBMIT =====
    $('#submitBtn').on('click', function(e) {
        e.preventDefault();
        loadReportData();
    });

    // ===== ENTER KEY =====
    $('.datepicker').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            loadReportData();
        }
    });
});

function initializeCountryMultiselect(emptyState) {
    emptyState = emptyState || false;
    var config = {
        columns: 1,
        placeholder: emptyState ? 'Select region' : 'Search',
        search: !emptyState,
        selectAll: !emptyState,
        selectAllText: 'Select All',
        includeSelectAllOption: !emptyState,
        enableFiltering: !emptyState,
        filterPlaceholder: 'Search...',
        enableCaseInsensitiveFiltering: true,
        maxHeight: 300,
        buttonClass: 'btn btn-block',
        buttonWidth: '100%',
        nonSelectedText: emptyState ? 'Select region' : 'Select countries',
        nSelectedText: 'selected',
        allSelectedText: 'All selected'
    };
    $('#country_search').multiselect(config);
}

function initializePartyMultiselect(emptyState) {

    emptyState = emptyState || false;
    var config = {
        columns: 1,
        placeholder: emptyState ? 'Select country' : 'Search',
        search: !emptyState,
        selectAll: !emptyState,
        selectAllText: 'Select All',
        includeSelectAllOption: !emptyState,
        enableFiltering: !emptyState,
        filterPlaceholder: 'Search...',
        enableCaseInsensitiveFiltering: true,
        maxHeight: 300,
        buttonClass: 'btn btn-block',
        buttonWidth: '100%',
        nonSelectedText: emptyState ? 'Select country' : 'Select parties',
        nSelectedText: 'parties',
        allSelectedText: 'All selected'
    };
    $('#party_search').multiselect(config);
}

function resetPartyMultiselect() {
    if ($('#party_search').data('multiselect')) {
        $('#party_search').multiselect('destroy');
    }
    $('#party_search').html('');
    initializePartyMultiselect(true);
}

function loadPartiesByCountries(countries) {

    if ($('#party_search').data('multiselect')) {
        $('#party_search').multiselect('destroy');
    }
    $('#party_search').html('<option value="">Loading...</option>');
    initializePartyMultiselect(true);
    
    var formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    for (var i = 0; i < countries.length; i++) {
        formData.append('countries[]', countries[i]);
    }
    
    $.ajax({
        url: "{{ url('/json/get_party/by_country') }}",
        type: "POST",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        timeout: 15000,
        success: function(response) {
            if($('#party_search').data('multiselect')) {
                $('#party_search').multiselect('destroy');
            }
            var option = '';
            if (response.status === 'success' && response.data && response.data.length > 0) {
                $.each(response.data, function(key, value) {
                    var partyName = value.party_name || value.name || value;
                    var partyCode = value.party_code || value.code || '';
                    var partyId = value.id || value.party_id || partyName;
                    var displayText = partyCode ? partyCode + ' - ' + partyName : partyName;
                    option += '<option value="'+partyId+'">'+ displayText +'</option>';
                });
            }
            $('#party_search').html(option);
            initializePartyMultiselect(!option);
        },
        error: function() {
            if ($('#party_search').data('multiselect')) {
                $('#party_search').multiselect('destroy');
            }
            $('#party_search').html('');
            initializePartyMultiselect(true);
        }
    });
}

function loadReportData() {

    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    var regionId = $('#region_id').val();
    var selectedCountries = $('#country_search').val();
    var selectedParties = $('#party_search').val();
    
    if(!selectedCountries || selectedCountries.length === 0) {
        alert('Please select at least one country!');
        return;
    }
    if(!fromDate || !toDate) {
        alert('Please select both From and To dates');
        return;
    }
    
    $('#exportBtn').prop('disabled', true);
    $('#submitBtn').prop('disabled', true).addClass('btn-loading');
    $('#scrollIndicator').removeClass('show');

    var formData = new FormData();
    formData.append('fromDate', fromDate);
    formData.append('toDate', toDate);
    formData.append('_token', '{{ csrf_token() }}');
    if(regionId && regionId !== '') {
        formData.append('region_id', regionId);
    }
    for(var i = 0; i < selectedCountries.length; i++) {
        formData.append('country_list[]', selectedCountries[i]);
    }
    if(selectedParties && selectedParties.length > 0) {
        for (var j = 0; j < selectedParties.length; j++) {
            formData.append('party_list[]', selectedParties[j]);
        }
    }

    $.ajax({
        url: "{{ url('/json/get/jo/report_date') }}",
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
                    $('#exportBtn').prop('disabled', false);
                    setTimeout(function() {
                        if ($('#tableScrollContainer')[0].scrollWidth > $('#tableScrollContainer')[0].clientWidth) {
                            $('#scrollIndicator').addClass('show');
                        }
                    }, 200);
                } else {
                    showNoData('No records found');
                }
            } else {
                showNoData('Error: ' + (response.message || 'Unknown error'));
            }
        },
        error: function(xhr, status) {
            var msg = 'Failed to load. ';
            if (status === 'timeout') msg += 'Request timed out.';
            else if (xhr.status === 404) msg += 'URL not found.';
            else if (xhr.status === 500) msg += 'Server error.';
            else msg += 'Please try again.';
            showNoData(msg);
        },
        complete: function() {
            $('#submitBtn').prop('disabled', false).removeClass('btn-loading');
        }
    });
}

function renderTableData(data) {
    var tbody = $('#reportBody');
    tbody.empty();
    
    var sl = 0;
    $.each(data, function(index, row) {
        var statusText = 'Pending';
        var statusClass = 'badge-pending';
        var delivered = parseFloat(row.delivery_qty) || 0;
        var pending = parseFloat(row.pending_qty) || 0;
        var totalPcs = delivered + pending;
        
        if (pending === 0 && totalPcs > 0) {
            statusText = 'Delivered';
            statusClass = 'badge-delivered';
        } else if (pending > 0 && delivered > 0) {
            statusText = 'Partial';
            statusClass = 'badge-partial';
        }
        
        sl++;
        var rowHtml = '<tr>' +
            '<td>' + sl + '</td>' +
            '<td title="' + (row.invoice_no || '-') + '">' + (row.invoice_no || '-') + '</td>' +
            '<td>' + (row.invoice_date || '-') + '</td>' +
            '<td>' + (row.stuffing_date || '-') + '</td>' +
            '<td>' + (row.container || '-') + '</td>' +
            '<td title="' + (row.bl_no || '-') + '">' + (row.bl_no || '-') + '</td>' +
            '<td><strong>' + totalPcs.toFixed(0) + '</strong></td>' +
            '<td style="color:#2e7d32;font-weight:600;">' + delivered.toFixed(0) + '</td>' +
            '<td style="color:#c62828;font-weight:600;">' + pending.toFixed(0) + '</td>' +
            '<td title="' + (row.party_name || '-') + '">' + (row.party_name || '-') + '</td>' +
            '<td><span class="badge-status ' + statusClass + '">' + statusText + '</span></td>' +
            '</tr>';
        tbody.append(rowHtml);
    });
}

function showNoData(message) {
    var tbody = $('#reportBody');
    tbody.empty();
    tbody.html('<tr><td colspan="11"><div class="no-data"><i class="fa fa-info-circle"></i>' + message + '</div></td></tr>');
    $('#exportBtn').prop('disabled', true);
    $('#scrollIndicator').removeClass('show');
}

function exportF(elem) {
    if ($('#reportBody tr').length === 0 || $('#reportBody tr td .no-data').length > 0) {
        alert('No data to export. Please load data first.');
        return false;
    }

    $(elem).prop('disabled', true).addClass('btn-loading');

    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    var regionId = $('#region_id').val();
    var selectedCountries = $('#country_search').val();
    var selectedParties = $('#party_search').val();

    var url = "{{ url('/export-shipment-tracking') }}";
    url += '?fromDate=' + encodeURIComponent(fromDate);
    url += '&toDate=' + encodeURIComponent(toDate);
    
    if (regionId && regionId !== '') {
        url += '&region_id=' + encodeURIComponent(regionId);
    }
    if (selectedCountries && selectedCountries.length > 0) {
        for (var i = 0; i < selectedCountries.length; i++) {
            url += '&country_list[]=' + encodeURIComponent(selectedCountries[i]);
        }
    }
    if (selectedParties && selectedParties.length > 0) {
        for (var j = 0; j < selectedParties.length; j++) {
            url += '&party_list[]=' + encodeURIComponent(selectedParties[j]);
        }
    }

    window.open(url, '_blank');

    setTimeout(function() {
        $(elem).prop('disabled', false).removeClass('btn-loading');
    }, 2000);
}
</script>
@endsection