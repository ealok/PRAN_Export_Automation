@extends('layouts.master')
@section('content')
<style>
    /* ========== PROFESSIONAL DASHBOARD STYLING ========== */
    * { box-sizing: border-box; }
    
    .report-header {
        background: linear-gradient(145deg, #0b2a4a 0%, #1e4a7a 100%);
        color: #fff;
        padding: 10px 18px;
        border-radius: 8px 8px 0 0;
        margin-bottom: 12px;
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
        font-size: 12px;
        opacity: 0.8;
        font-weight: 400;
    }

    /* ===== FILTER SECTION ===== */
    .filter-section {
        background: #ffffff;
        padding: 10px 14px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 20, 40, 0.04);
        margin-bottom: 12px;
        border: 1px solid #e9edf4;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 6px 10px;
    }
    .filter-group {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 6px 10px;
        flex: 2 1 600px;
    }
    .filter-group .form-group {
        margin-bottom: 0;
        min-width: 160px;
        flex: 0 1 auto;
    }
    .filter-group .form-group label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #3a507a;
        margin-bottom: 2px;
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
        font-size: 12px;
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
        gap: 6px 10px;
        flex-wrap: wrap;
        flex: 0 1 auto;
    }
    .date-group > div {
        flex: 0 1 auto;
        min-width: 120px;
    }
    .date-group label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #3a507a;
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 3px;
    }
    .date-group label i {
        color: #2a5298;
        font-size: 12px;
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
        font-size: 12px;
        min-width: 120px;
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
        padding: 4px 16px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 12px;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        transition: 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
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
        width: 14px;
        height: 14px;
        top: 50%;
        left: 50%;
        margin-left: -7px;
        margin-top: -7px;
        border: 2px solid rgba(255,255,255,0.25);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 0.6s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ===== STATISTICS CARDS ===== */
    .stats-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 10px;
        margin-bottom: 12px;
    }
    .stat-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 10px 14px;
        box-shadow: 0 2px 10px rgba(0, 20, 40, 0.05);
        border: 1px solid #e9edf4;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        min-height: 70px;
        max-height: 85px;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 20, 40, 0.08);
    }
    .stat-card .stat-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        margin-bottom: 4px;
        float: left;
        margin-right: 10px;
    }
    .stat-card .stat-icon.blue { background: #e3edf7; color: #1e4a7a; }
    .stat-card .stat-icon.green { background: #e3f5eb; color: #1a8a4a; }
    .stat-card .stat-icon.orange { background: #fef3e0; color: #b86a1a; }
    .stat-card .stat-icon.purple { background: #ede7f6; color: #5e35b1; }

    .stat-card .stat-number {
        font-size: 20px;
        font-weight: 700;
        color: #0b2a4a;
        line-height: 1.2;
    }
    .stat-card .stat-label {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #6a7b9c;
    }
    .stat-card .stat-trend {
        font-size: 9px;
        font-weight: 600;
        margin-top: 2px;
        display: inline-block;
        padding: 1px 8px;
        border-radius: 20px;
    }
    .stat-card .stat-trend.up { background: #e3f5eb; color: #1a8a4a; }
    .stat-card .stat-trend.down { background: #fce9ec; color: #c62828; }
    .stat-card .stat-trend.neutral { background: #f0f2f5; color: #5a6b7a; }

    .stat-card .stat-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 2px;
        border-radius: 0 0 8px 8px;
    }
    .stat-card .stat-bar.blue { background: linear-gradient(90deg, #1e4a7a, #4a7ab0); width: 100%; }
    .stat-card .stat-bar.green { background: linear-gradient(90deg, #1a8a4a, #4ac080); width: 70%; }
    .stat-card .stat-bar.orange { background: linear-gradient(90deg, #b86a1a, #e8a040); width: 45%; }
    .stat-card .stat-bar.purple { background: linear-gradient(90deg, #5e35b1, #9a7ac8); width: 60%; }

    .stat-card.highlight {
        border-color: #1e4a7a;
        background: #f5f9ff;
    }

    /* ===== ALERT MESSAGE ===== */
    .alert-custom {
        padding: 6px 12px;
        border-radius: 6px;
        margin-bottom: 10px;
        font-size: 12px;
        display: none;
        border-left: 3px solid transparent;
        clear: both;
    }
    .alert-custom.alert-danger { background: #fce9ec; border-left-color: #d0314a; color: #8a1a2a; display: block; }
    .alert-custom.alert-success { background: #e3f5eb; border-left-color: #1a8a4a; color: #0f5a2a; display: block; }
    .alert-custom.alert-warning { background: #fef6e0; border-left-color: #b68a20; color: #7a5a10; display: block; }

    /* ===== REGION TABLE ===== */
    .region-table-wrapper {
        background: #ffffff;
        border-radius: 8px;
        padding: 10px 14px;
        border: 1px solid #e9edf4;
        box-shadow: 0 2px 10px rgba(0, 20, 40, 0.04);
        margin-bottom: 12px;
    }
    .region-table-wrapper h6 {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #3a507a;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .region-table-wrapper h6 i {
        color: #1e4a7a;
    }

    .region-table-scroll {
        max-height: 420px;
        overflow-y: auto;
        overflow-x: auto;
        position: relative;
        border-radius: 6px;
    }
    .region-table-scroll::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .region-table-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .region-table-scroll::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    .region-table-scroll::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    .region-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        min-width: 650px;
    }
    .region-table thead th {
        background: #0b2a4a;
        color: #ffffff;
        text-align: left;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 6px 10px;
        border-bottom: 2px solid #1a3a5a;
        position: sticky;
        top: 0;
        z-index: 10;
        white-space: nowrap;
    }
    .region-table tbody td {
        padding: 5px 8px;
        border-bottom: 1px solid #e9edf4;
        color: #1a2a44;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        font-size: 11px;
        line-height: 1.4;
    }
    .region-table tbody td:first-child {
        text-align: left;
        font-weight: 600;
        font-size: 11px;
    }
    .region-table tbody tr:hover td {
        background-color: #f0f6fe;
    }
    .region-table tbody td .badge-count {
        display: inline-block;
        padding: 1px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
    }
    .badge-count.total { background: #e3edf7; color: #1e4a7a; }
    .badge-count.approved { background: #e3f5eb; color: #1a8a4a; }
    .badge-count.pending { background: #fef3e0; color: #b86a1a; }
    .badge-count.rejected { background: #fce9ec; color: #c62828; }

    .region-click {
        color: #1e4a7a;
        font-weight: 600;
        text-decoration: underline dotted;
        cursor: pointer;
        font-size: 11px;
    }
    .region-click:hover {
        color: #0b2a4a;
    }
    .btn-view-region {
        background: none;
        border: 1px solid #1e4a7a;
        color: #1e4a7a;
        padding: 1px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-view-region:hover {
        background: #1e4a7a;
        color: #fff;
    }

    .filter-badge {
        display: inline-block;
        background: #e3edf7;
        color: #1e4a7a;
        padding: 1px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        margin-left: 6px;
    }

    /* ===== TABLE CONTAINER WRAPPER ===== */
    #tableContainerWrapper {
        display: none;
        animation: slideDown 0.3s ease;
    }
    #tableContainerWrapper.visible {
        display: block;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .table-header-bar {
        background: #f8faff;
        padding: 6px 14px;
        border: 1px solid #e2e8f0;
        border-bottom: none;
        border-radius: 8px 8px 0 0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .table-header-bar .table-title {
        font-size: 13px;
        font-weight: 700;
        color: #1e4a7a;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .table-header-bar .table-title i {
        color: #1e4a7a;
        font-size: 14px;
    }
    .table-header-bar .table-title .region-badge {
        background: #e3edf7;
        color: #1e4a7a;
        padding: 1px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
    }
    .btn-close-table {
        background: none;
        border: none;
        color: #d0314a;
        font-size: 14px;
        cursor: pointer;
        padding: 3px 8px;
        border-radius: 4px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 600;
        font-size: 12px;
    }
    .btn-close-table:hover {
        background: #fce9ec;
    }

    .table-search-section {
        background: #f8faff;
        padding: 6px 14px;
        border: 1px solid #e2e8f0;
        border-top: none;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .table-search-section .search-box {
        display: flex;
        align-items: center;
        gap: 6px;
        flex: 1;
        min-width: 180px;
    }
    .table-search-section .search-box input {
        flex: 1;
        padding: 4px 10px;
        border: 1px solid #d6dee9;
        border-radius: 4px;
        font-size: 11px;
        height: 30px;
        background: #fff;
        transition: 0.2s;
        min-width: 120px;
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
        font-size: 11px;
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
        padding: 2px 4px;
        display: none;
    }
    .table-search-section .clear-search:hover {
        color: #a02030;
    }

    /* ===== DETAIL TABLE ===== */
    .custom-table-wrapper {
        position: relative;
        border-radius: 0 0 8px 8px;
        border: 1px solid #e2e8f0;
        border-top: none;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        background: #fff;
    }
    .custom-table-wrapper .table-scroll {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 420px;
        position: relative;
    }
    .custom-table-wrapper .table-scroll::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .custom-table-wrapper .table-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .custom-table-wrapper .table-scroll::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    .custom-table-wrapper .table-scroll::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 11px;
        min-width: 850px;
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
        letter-spacing: 0.3px;
        padding: 6px 6px;
        border: 1px solid #0b2a4a;
        position: sticky;
        top: 0;
        z-index: 20;
        white-space: nowrap;
    }
    .custom-table tbody td {
        padding: 4px 6px;
        border: 1px solid #e2e8f0;
        vertical-align: middle;
        color: #1a2a44;
        font-weight: 500;
        white-space: nowrap;
        transition: all 0.2s ease;
        font-size: 10px;
        text-align: center;
        line-height: 1.4;
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

    .badge-status {
        padding: 1px 8px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
        white-space: nowrap;
    }
    .badge-status.completed { background: #e3f5eb; color: #1a8a4a; }
    .badge-status.pending { background: #fef3e0; color: #b86a1a; }
    .badge-status.reject { background: #fce9ec; color: #c62828; }

    .no-data {
        text-align: center;
        padding: 25px 20px;
        color: #6a7b9c;
        font-size: 13px;
    }
    .no-data i { font-size: 24px; display: block; margin-bottom: 6px; color: #d0d9e8; }

    /* ===== FOOTER ===== */
    .report-footer {
        margin-top: 10px;
        padding: 6px 14px;
        background: #f8faff;
        border-radius: 6px;
        font-size: 12px;
        color: #3a507a;
        border: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
    }
    .report-footer span i {
        margin-right: 4px;
        color: #1e4a7a;
    }

    @media (max-width: 992px) {
        .stats-row { grid-template-columns: 1fr 1fr; }
        .filter-section { flex-direction: column; align-items: stretch; }
        .filter-group { flex-direction: column; align-items: stretch; }
        .filter-group .form-group { flex: 1 1 auto; min-width: 100%; }
        .date-group { flex-direction: column; align-items: stretch; }
        .date-group > div { flex: 1 1 auto; min-width: 100%; }
        .action-group { margin-left: 0; justify-content: stretch; }
        .btn-submit, .btn-export-excel { width: 100%; justify-content: center; }
        .custom-table { font-size: 10px; min-width: 600px; }
        .report-header { flex-direction: column; align-items: flex-start; gap: 4px; }
        .table-search-section { flex-direction: column; align-items: stretch; }
        .table-search-section .search-box { min-width: 100%; }
        .region-table { font-size: 10px; }
        .region-table-scroll { max-height: 320px; }
        .custom-table-wrapper .table-scroll { max-height: 320px; }
    }
    @media (max-width: 576px) {
        .stats-row { grid-template-columns: 1fr 1fr; }
        .stat-card { min-height: 60px; max-height: 75px; }
        .stat-card .stat-number { font-size: 17px; }
        .table-header-bar { flex-direction: column; align-items: stretch; text-align: center; }
        .btn-close-table { justify-content: center; }
        .region-table-scroll { max-height: 250px; }
        .custom-table-wrapper .table-scroll { max-height: 250px; }
        .region-table { font-size: 10px; min-width: 500px; }
        .region-table tbody td { padding: 4px 6px; }
        .custom-table { font-size: 10px; min-width: 500px; }
        .custom-table tbody td { padding: 3px 4px; }
    }
</style>

<!-- ===== HTML CONTENT ===== -->
<div class="container-fluid">
    <!-- HEADER -->
    <div class="report-header">
        <div>
            <h4>
                <i class="fa fa-file-text-o"></i>Item Opening Report
                <small>Region Wise Requisition Summary</small>
            </h4>
        </div>
    </div>

    <!-- FILTER SECTION -->
    <div class="filter-section">
        <div class="filter-group">
            <div class="form-group">
                <label for="region_id"><i class="fa fa-map-marker"></i> Region</label>
                <select name="region_id" id="region_id" class="form-control">
                    <option value="">All Regions</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
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

    <!-- STATISTICS CARDS -->
    <div class="stats-row" id="statsRow">
        <div class="stat-card highlight" id="cardTotal">
            <div class="stat-icon blue"><i class="fa fa-list"></i></div>
            <div class="stat-number" id="totalRequisition">0</div>
            <div class="stat-label">Total Requisition</div>
            <span class="stat-trend neutral">All Regions</span>
            <div class="stat-bar blue"></div>
        </div>
        <div class="stat-card" id="cardApproved">
            <div class="stat-icon green"><i class="fa fa-check-circle"></i></div>
            <div class="stat-number" id="totalApproved">0</div>
            <div class="stat-label">Approved</div>
            <span class="stat-trend up"><i class="fa fa-arrow-up"></i> 12%</span>
            <div class="stat-bar green"></div>
        </div>
        <div class="stat-card" id="cardPending">
            <div class="stat-icon orange"><i class="fa fa-clock-o"></i></div>
            <div class="stat-number" id="totalPending">0</div>
            <div class="stat-label">Pending</div>
            <span class="stat-trend neutral"><i class="fa fa-minus"></i> 5%</span>
            <div class="stat-bar orange"></div>
        </div>
        <div class="stat-card" id="cardRejected">
            <div class="stat-icon purple"><i class="fa fa-times-circle"></i></div>
            <div class="stat-number" id="totalRejected">0</div>
            <div class="stat-label">Rejected</div>
            <span class="stat-trend down"><i class="fa fa-arrow-down"></i> 3%</span>
            <div class="stat-bar purple"></div>
        </div>
    </div>

    <!-- ALERT MESSAGE -->
    {{-- <div class="alert-custom" id="alertMessage"></div> --}}

    <!-- REGION WISE SUMMARY TABLE -->
    <div class="region-table-wrapper">
        <h6>
            <span><i class="fa fa-map-marker"></i> Region Wise Requisition Summary</span>
            <span class="filter-badge" id="regionFilterBadge">All</span>
        </h6>
        <div class="region-table-scroll">
            <table class="region-table" id="regionTable">
                <thead>
                    <tr>
                        <th style="text-align:left;min-width:130px;">Region</th>
                        <th style="text-align:center;min-width:90px;">Total</th>
                        <th style="text-align:center;min-width:90px;">Approved</th>
                        <th style="text-align:center;min-width:90px;">Pending</th>
                        <th style="text-align:center;min-width:90px;">Rejected</th>
                        <th style="text-align:center;min-width:80px;">Action</th>
                    </tr>
                </thead>
                <tbody id="regionBody">
                    <!-- Populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- TABLE CONTAINER WRAPPER -->
    <div id="tableContainerWrapper">
        <div class="table-header-bar">
            <div class="table-title">
                <i class="fa fa-list-ul"></i> 
                Requisition Details
                <span class="region-badge" id="detailsRegionBadge">-</span>
                <span style="font-size:11px;font-weight:400;color:#6a7b9c;" id="detailsCount">(0 records)</span>
            </div>
            <button class="btn-close-table" onclick="closeTableContainer()">
                <i class="fa fa-times-circle"></i> Close
            </button>
        </div>

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

        <div class="custom-table-wrapper" id="tableContainer">
            <div class="table-scroll">
                <table class="custom-table table" id="inv">
                    <thead>
                        <tr>
                            <th style="min-width:45px;">#</th>
                            <th style="min-width:90px;">Date</th>
                            <th style="min-width:130px;">Product</th>
                            <th style="min-width:90px;">Item Code</th>
                            <th style="min-width:110px;">Req. No</th>
                            <th style="min-width:110px;">App ID</th>
                            <th style="min-width:90px;">Status</th>
                            <th style="min-width:70px;">Days</th>
                            <th style="min-width:110px;">Note</th>
                        </tr>
                    </thead>
                    <tbody id="reportBody">
                        <tr>
                            <td colspan="9">
                                <div class="no-data">
                                    <i class="fa fa-info-circle"></i>
                                    Click on a Region or View button to see details
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="report-footer" id="reportFooterInfo" style="display: none;">
        <span><i class="fa fa-file-text-o"></i> Total Records: <strong id="totalRecords">0</strong></span>
    </div>
</div>

<!-- ===== SCRIPTS ===== -->
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}">

<script>
document.title = 'Report | Item Opening';
setTimeout(function() { $('.sr-only').click(); }, 0.0001);

// ===== GLOBALS =====
let allData = [];
let regionWiseData = {};
let allSummaryData = [];
let allDetailData = [];

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

    setTimeout(loadReportData, 500);
});

// ===== CONVERT DATE FORMAT =====
function convertDateToYMD(dateStr) {
    if (!dateStr) return null;
    var parts = dateStr.split('-');
    if (parts.length !== 3) return null;
    return parts[2] + '-' + parts[1] + '-' + parts[0];
}

// ===== LOAD REPORT DATA =====
function loadReportData() {
    if (!validateFilters()) return;

    $('#alertMessage').hide();
    $('#submitBtn').prop('disabled', true).addClass('btn-loading');
    $('#exportBtn').prop('disabled', true);

    var regionId = $('#region_id').val() || null;
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();

    $.ajax({
        url: '{{ url("/json/get-item-opening-report") }}',
        type: 'POST',
        data: {
            region_id: regionId,
            from_date: convertDateToYMD(fromDate),
            to_date: convertDateToYMD(toDate),
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                processReportData(response.data);
                renderDashboard();
                renderRegionTable(regionWiseData);
                
                if (Object.keys(regionWiseData).length === 0) {
                    showAlert('No records found for selected filters', 'warning');
                    $('#tableContainerWrapper').removeClass('visible');
                } else {
                    var totalRecords = Object.values(regionWiseData).reduce((sum, r) => sum + r.total_count, 0);
                    showAlert('Loaded ' + totalRecords + ' records successfully', 'success');
                }

                $('#reportFooterInfo').show();
                var total = Object.values(regionWiseData).reduce((sum, r) => sum + r.total_count, 0);
                $('#totalRecords').text(total || 0);
                $('#exportBtn').prop('disabled', false);
                
                setTimeout(function() { 
                    $('#alertMessage').fadeOut('slow'); 
                }, 3000);
                
            } else {
                showAlert(response.message || 'Error loading data', 'danger');
            }
        },
        error: function(xhr) {
            var errorMsg = xhr.responseJSON?.message || 'Error loading data. Please try again.';
            showAlert(errorMsg, 'danger');
            console.error(xhr.responseText);
        },
        complete: function() {
            $('#submitBtn').prop('disabled', false).removeClass('btn-loading');
            setTimeout(updateTableCounts, 100);
        }
    });
}

// ===== PROCESS REPORT DATA (Based on SP_ItemOpeningReport) =====
function processReportData(data) {
    const regionMap = {};
    allSummaryData = [];
    allDetailData = [];

    data.forEach(item => {
        if (item.Report_Type === 'summary') {
            // Summary Data
            const region = item.Region_Name || 'Unknown';
            if (!regionMap[region]) {
                regionMap[region] = {
                    region: region,
                    total_count: parseInt(item.Total_Count) || 0,
                    complete_count: parseInt(item.Complete_Count) || 0,
                    pending_count: parseInt(item.Pending_Count) || 0,
                    reject_count: parseInt(item.Reject_Count) || 0,
                    details: []
                };
            }
            allSummaryData.push(item);
        } else if (item.Report_Type === 'detail') {
            // Detail Data
            const region = item.Region_Name || 'Unknown';
            if (!regionMap[region]) {
                regionMap[region] = {
                    region: region,
                    total_count: 0,
                    complete_count: 0,
                    pending_count: 0,
                    reject_count: 0,
                    details: []
                };
            }
            regionMap[region].details.push({
                requisition_date: item.Requisition_Date || '-',
                product_name: item.Product_Name || '-',
                item_code: item.Item_Code || '-',
                requisition_number: item.Requisition_Number || '-',
                application_id: item.Application_Id || '-',
                status: item.Status || 'pending',
                days_passed: parseInt(item.Days_Passed) || 0,
                note: item.Note || '-'
            });
            allDetailData.push(item);
        }
    });

    regionWiseData = regionMap;
}

// ===== RENDER DASHBOARD STATISTICS =====
function renderDashboard() {
    var total = 0, approved = 0, pending = 0, rejected = 0;
    
    Object.values(regionWiseData).forEach(region => {
        total += region.total_count;
        approved += region.complete_count;
        pending += region.pending_count;
        rejected += region.reject_count;
    });

    animateNumber('totalRequisition', 0, total);
    animateNumber('totalApproved', 0, approved);
    animateNumber('totalPending', 0, pending);
    animateNumber('totalRejected', 0, rejected);
}

function animateNumber(elementId, start, end) {
    const el = document.getElementById(elementId);
    if (!el) return;
    const duration = 800;
    const startTime = performance.now();
    
    function update(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const current = Math.round(start + (end - start) * progress);
        el.textContent = current;
        if (progress < 1) {
            requestAnimationFrame(update);
        }
    }
    requestAnimationFrame(update);
}

// ===== RENDER REGION SUMMARY TABLE =====
function renderRegionTable(regionData) {
    const tbody = $('#regionBody');
    tbody.empty();

    const regions = Object.keys(regionData).sort();

    if (regions.length === 0) {
        tbody.html('<tr><td colspan="6" style="text-align:center;color:#6a7b9c;padding:15px;">No region data available</td></tr>');
        return;
    }

    regions.forEach(region => {
        const stats = regionData[region];
        const rowHtml = `
            <tr>
                <td style="text-align:left;">
                    <strong class="region-click" data-region="${region}">
                        ${region}
                    </strong>
                </td>
                <td><span class="badge-count total">${stats.total_count}</span></td>
                <td><span class="badge-count approved">${stats.complete_count}</span></td>
                <td><span class="badge-count pending">${stats.pending_count}</span></td>
                <td><span class="badge-count rejected">${stats.reject_count}</span></td>
                <td>
                    <button class="btn-view-region" onclick="showRegionDetails('${region}')">
                        <i class="fa fa-eye"></i> View
                    </button>
                </td>
            </tr>
        `;
        tbody.append(rowHtml);
    });

    $('.region-click').on('click', function() {
        const region = $(this).data('region');
        showRegionDetails(region);
    });
}

// ===== SHOW REGION DETAILS =====
function showRegionDetails(region) {
    const regionData = regionWiseData[region];
    
    if (!regionData || regionData.details.length === 0) {
        showAlert('No data found for region: ' + region, 'warning');
        return;
    }

    $('#tableContainerWrapper').addClass('visible');
    $('#detailsRegionBadge').text(region);
    $('#detailsCount').text('(' + regionData.details.length + ' records)');

    renderDetailTable(regionData.details);
    $('#totalRecords').text(regionData.details.length);

    // Highlight selected region
    $('#regionBody tr').each(function() {
        $(this).css('background', 'transparent');
        if ($(this).find('.region-click').text().trim() === region) {
            $(this).css('background', '#e3edf7');
        }
    });

    $('#regionFilterBadge').text(region);
    showAlert('Showing details for region: ' + region, 'success');
    setTimeout(function() { $('#alertMessage').fadeOut('slow'); }, 2000);
    setTimeout(updateTableCounts, 100);
}

// ===== CLOSE TABLE CONTAINER =====
function closeTableContainer() {
    $('#tableContainerWrapper').removeClass('visible');
    $('#detailsRegionBadge').text('-');
    $('#detailsCount').text('(0 records)');
    
    $('#regionBody tr').each(function() {
        $(this).css('background', 'transparent');
    });

    $('#regionFilterBadge').text('All');
    var total = Object.values(regionWiseData).reduce((sum, r) => sum + r.total_count, 0);
    $('#totalRecords').text(total || 0);

    var tbody = $('#reportBody');
    tbody.html('<tr><td colspan="9"><div class="no-data"><i class="fa fa-info-circle"></i> Click on a Region or View button to see details</div></td></tr>');
    document.getElementById('totalRowCount').textContent = '0';
    document.getElementById('visibleRowCount').textContent = '0';
    
    showAlert('Closed region details', 'success');
    setTimeout(function() { $('#alertMessage').fadeOut('slow'); }, 1500);
}

// ===== RENDER DETAIL TABLE =====
function renderDetailTable(data) {
    var tbody = $('#reportBody');
    tbody.empty();
    
    if (!data || data.length === 0) {
        showNoData('No records found');
        return;
    }

    var sl = 0;
    $.each(data, function(index, row) {
        sl++;
        var statusClass = row.status ? row.status.toLowerCase() : 'pending';
        var rowHtml = '<tr>' +
            '<td>' + sl + '</td>' +
            '<td>' + (row.requisition_date || '-') + '</td>' +
            '<td>' + (row.product_name || '-') + '</td>' +
            '<td><code>' + (row.item_code || '-') + '</code></td>' +
            '<td><strong>' + (row.requisition_number || '-') + '</strong></td>' +
            '<td>' + (row.application_id || '-') + '</td>' +
            '<td><span class="badge-status ' + statusClass + '">' + (row.status || 'Pending') + '</span></td>' +
            '<td>' + (row.days_passed || 0) + ' days</td>' +
            '<td>' + (row.note || '-') + '</td>' +
            '</tr>';
        
        tbody.append(rowHtml);
    });
    updateTableCounts();
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
            newRow.innerHTML = '<td colspan="9"><div class="no-data"><i class="fa fa-info-circle"></i> No matching records for "<strong>' + filter + '</strong>"</div></td>';
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
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    
    $('#fromDate, #toDate').removeClass('error');

    if (!fromDate || !toDate) {
        if (!fromDate) $('#fromDate').addClass('error');
        if (!toDate) $('#toDate').addClass('error');
        showAlert('Please select both From Date and To Date', 'danger');
        return false;
    }
    
    if (!validateDateRange(fromDate, toDate)) {
        $('#fromDate, #toDate').addClass('error');
        showAlert('From date must be earlier than or equal to To date', 'danger');
        return false;
    }
    
    return true;
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

function showNoData(message) {
    var tbody = $('#reportBody');
    tbody.html('<tr><td colspan="9"><div class="no-data"><i class="fa fa-info-circle"></i> ' + message + '</div></td></tr>');
    document.getElementById('totalRowCount').textContent = '0';
    document.getElementById('visibleRowCount').textContent = '0';
}

function showAlert(message, type) {
    var alertDiv = $('#alertMessage');
    alertDiv.removeClass('alert-danger alert-success alert-warning').addClass('alert-' + type);
    var icon = type === 'danger' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle';
    alertDiv.html('<i class="fa fa-' + icon + '"></i> ' + message).show();
}

// ===== EXPORT =====
function exportF(elem) {
    if ($('#reportBody tr').length === 0 || $('#reportBody tr td .no-data').length > 0) {
        alert('No data to export!');
        return false;
    }

    $(elem).prop('disabled', true).addClass('btn-loading');
    
    var rows = document.querySelectorAll('#reportBody tr:not(.no-data)');
    var csvData = [];
    var headers = ['SL', 'Date', 'Product', 'Item Code', 'Requisition No', 'App ID', 'Status', 'Days Passed', 'Note'];
    csvData.push(headers.join(','));
    
    rows.forEach(function(row) {
        if (row.querySelector('.no-data')) return;
        var cells = row.getElementsByTagName('td');
        var rowData = [];
        for (var j = 0; j < cells.length; j++) {
            rowData.push('"' + cells[j].textContent.trim() + '"');
        }
        csvData.push(rowData.join(','));
    });
    
    var csv = csvData.join('\n');
    var blob = new Blob([csv], { type: 'text/csv' });
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'Item_Opening_Report_' + new Date().toISOString().slice(0,10) + '.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    setTimeout(function() {
        $(elem).prop('disabled', false).removeClass('btn-loading');
    }, 500);
    return false;
}
</script>
@endsection