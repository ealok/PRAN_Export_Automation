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

    /* ===== SUMMARY CARDS + CHART ===== */
    .summary-container {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        flex-wrap: wrap;
        align-items: stretch;
    }
    .chart-container {
        width: 160px;
        min-width: 160px;
        background: #ffffff;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 6px 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        height: 70px;
        max-height: 70px;
        min-height: 60px;
        flex-shrink: 0;
        order: 0;
    }
    .chart-container canvas {
        width: auto !important;
        height: 50px !important;
        max-width: 130px;
        max-height: 50px;
    }
    .summary-cards {
        flex: 1;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        min-width: 300px;
        order: 1;
    }
    .summary-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 6px 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        height: 70px;
        max-height: 70px;
        min-height: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.10);
    }
    .summary-card .card-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 22px;
        opacity: 0.12;
    }
    .summary-card .card-number {
        font-size: 18px;
        font-weight: 700;
        color: #1a2a44;
        display: block;
        line-height: 1.1;
    }
    .summary-card .card-label {
        font-size: 9px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #6a7b9c;
    }
    .summary-card.card-total { border-left: 4px solid #1e4a7a; }
    .summary-card.card-complete { border-left: 4px solid #2e7d32; }
    .summary-card.card-pending { border-left: 4px solid #e65100; }
    .summary-card.card-reject { border-left: 4px solid #c62828; }
    .summary-card.card-total .card-number { color: #1e4a7a; }
    .summary-card.card-complete .card-number { color: #2e7d32; }
    .summary-card.card-pending .card-number { color: #e65100; }
    .summary-card.card-reject .card-number { color: #c62828; }
    .summary-card.active {
        border: 2px solid #1e4a7a;
        box-shadow: 0 4px 16px rgba(30, 74, 122, 0.15);
    }
    .summary-card.card-total.active { border-color: #1e4a7a; background: #f0f6fe; }
    .summary-card.card-complete.active { border-color: #2e7d32; background: #e8f5e9; }
    .summary-card.card-pending.active { border-color: #e65100; background: #fff3e0; }
    .summary-card.card-reject.active { border-color: #c62828; background: #fce4ec; }

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
        min-width: 800px;
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
        padding: 6px 4px;
        border: 1px solid #0b2a4a;
        position: sticky;
        top: 0;
        z-index: 20;
        white-space: nowrap;
    }
    .custom-table tbody td {
        padding: 5px 4px;
        border: 1px solid #e2e8f0;
        vertical-align: middle;
        color: #1a2a44;
        font-weight: 500;
        white-space: nowrap;
        transition: all 0.2s ease;
        font-size: 9px;
        text-align: center !important;
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
    .custom-table tbody td:first-child {
        font-weight: 700;
    }
    .custom-table tbody td:nth-child(2) {
        text-align: left !important;
        font-weight: 700;
        padding-left: 12px;
    }
    .custom-table tbody td:nth-child(3),
    .custom-table tbody td:nth-child(4),
    .custom-table tbody td:nth-child(5),
    .custom-table tbody td:nth-child(6) {
        text-align: center !important;
        font-weight: 700;
    }

    .badge-status {
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 7px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
        white-space: nowrap;
    }
    .badge-complete { background: #e8f5e9; color: #2e7d32; }
    .badge-pending { background: #fff3e0; color: #e65100; }
    .badge-reject { background: #fce4ec; color: #c62828; }

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

    @media (max-width: 992px) {
        .filter-section { flex-direction: column; align-items: stretch; }
        .filter-group { flex-direction: column; align-items: stretch; }
        .filter-group .form-group { flex: 1 1 auto; min-width: 100%; }
        .date-group { flex-direction: column; align-items: stretch; }
        .date-group > div { flex: 1 1 auto; min-width: 100%; }
        .action-group { margin-left: 0; justify-content: stretch; }
        .btn-submit, .btn-export-excel { width: 100%; justify-content: center; }
        .custom-table { font-size: 8px; min-width: 700px; }
        .summary-cards { grid-template-columns: repeat(2, 1fr); }
        .summary-container { flex-direction: column; align-items: stretch; }
        .chart-container { 
            width: 100%; 
            min-width: unset; 
            height: 70px;
            max-height: 70px;
            order: 0;
        }
        .chart-container canvas { 
            max-width: 160px; 
            height: 50px !important;
            margin: 0 auto;
        }
        .report-header { flex-direction: column; align-items: flex-start; gap: 6px; }
        .table-search-section { flex-direction: column; align-items: stretch; }
        .table-search-section .search-box { min-width: 100%; }
    }
    @media (max-width: 480px) {
        .summary-cards { grid-template-columns: 1fr 1fr; }
        .summary-card { height: 60px; max-height: 60px; min-height: 50px; padding: 4px 8px; }
        .summary-card .card-number { font-size: 15px; }
        .summary-card .card-label { font-size: 7px; }
        .summary-card .card-icon { font-size: 16px; right: 6px; }
        .chart-container { height: 60px; max-height: 60px; min-height: 50px; padding: 4px; }
        .chart-container canvas { height: 44px !important; }
    }
</style>

<div class="container-fluid">
    <div class="report-header">
        <div>
            <h4>
                <i class="fa fa-file-text-o"></i> Item Opening Report
                <small></small>
            </h4>
        </div>
    </div>

    <!-- ===== FILTER SECTION ===== -->
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
            <div class="form-group" style="min-width: 180px;">
                <label for="country_search"><i class="fa fa-globe"></i> Country</label>
                <select name="country_list[]" id="country_search" multiple="multiple"></select>
            </div>
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
        </div>
        <div class="action-group">
            <button class="btn-submit" id="submitBtn"><i class="fa fa-search"></i> Show</button>
            <button class="btn-export-excel" id="exportBtn" onclick="exportF(this)" disabled><i class="fa fa-file-excel-o"></i> Export</button>
        </div>
    </div>

    <!-- Alert -->
    <div class="alert-custom" id="alertMessage"></div>

    <!-- ===== SUMMARY CARDS + CHART ===== -->
    <div class="summary-container">
        <div class="chart-container">
            <canvas id="donutChart"></canvas>
        </div>
        <div class="summary-cards" id="summaryCards">
            <div class="summary-card card-total active" data-filter="all" onclick="filterTableByStatus('all')">
                <span class="card-icon"><i class="fa fa-list"></i></span>
                <span class="card-number" id="totalCount">0</span>
                <span class="card-label">Total Requisition</span>
            </div>
            <div class="summary-card card-complete" data-filter="complete" onclick="filterTableByStatus('complete')">
                <span class="card-icon"><i class="fa fa-check-circle"></i></span>
                <span class="card-number" id="completeCount">0</span>
                <span class="card-label">Complete</span>
            </div>
            <div class="summary-card card-pending" data-filter="pending" onclick="filterTableByStatus('pending')">
                <span class="card-icon"><i class="fa fa-clock-o"></i></span>
                <span class="card-number" id="pendingCount">0</span>
                <span class="card-label">Pending</span>
            </div>
            <div class="summary-card card-reject" data-filter="reject" onclick="filterTableByStatus('reject')">
                <span class="card-icon"><i class="fa fa-times-circle"></i></span>
                <span class="card-number" id="rejectCount">0</span>
                <span class="card-label">Reject</span>
            </div>
        </div>
    </div>

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
                        <th>#</th>
                        <th>Region</th>
                        <th>Total Requisition</th>
                        <th>Complete</th>
                        <th>Pending</th>
                        <th>Reject</th>
                    </tr>
                </thead>
                <tbody id="reportBody">
                    <!-- Demo Data will be rendered here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>    
document.title = 'Item Opening Report';

// ============================================================
// DEMO DATA
// ============================================================
var demoData = [
    { region: 'Dhaka', total: 150, complete: 120, pending: 20, reject: 10 },
    { region: 'Chittagong', total: 100, complete: 70, pending: 20, reject: 10 },
    { region: 'Rajshahi', total: 80, complete: 50, pending: 15, reject: 15 },
    { region: 'Khulna', total: 60, complete: 40, pending: 10, reject: 10 },
    { region: 'Sylhet', total: 45, complete: 25, pending: 15, reject: 5 },
    { region: 'Barishal', total: 30, complete: 20, pending: 5, reject: 5 },
    { region: 'Rangpur', total: 25, complete: 15, pending: 8, reject: 2 },
    { region: 'Mymensingh', total: 20, complete: 12, pending: 5, reject: 3 },
];

var donutChart = null;
var currentFilter = 'all';

// ============================================================
// RENDER TABLE
// ============================================================
function renderTableData(data) {
    var tbody = $('#reportBody');
    tbody.empty();
    
    if (!data || data.length === 0) {
        tbody.html('<tr><td colspan="6"><div class="no-data"><i class="fa fa-info-circle"></i>No records found</div></td></tr>');
        return;
    }

    var sl = 0;
    $.each(data, function(index, row) {
        sl++;
        var rowHtml = '<tr>' +
            '<td>' + sl + '</td>' +
            '<td><strong>' + row.region + '</strong></td>' +
            '<td><strong>' + row.total + '</strong></td>' +
            '<td style="color:#2e7d32;"><strong>' + row.complete + '</strong></td>' +
            '<td style="color:#e65100;"><strong>' + row.pending + '</strong></td>' +
            '<td style="color:#c62828;"><strong>' + row.reject + '</strong></td>' +
            '</tr>';
        tbody.append(rowHtml);
    });
    
    updateSummaryCards(data);
    updateDonutChart(data);
    updateTableCounts();
    $('#exportBtn').prop('disabled', false);
}

// ============================================================
// UPDATE SUMMARY CARDS
// ============================================================
function updateSummaryCards(data) {
    var total = 0, complete = 0, pending = 0, reject = 0;
    
    $.each(data, function(index, row) {
        total += row.total;
        complete += row.complete;
        pending += row.pending;
        reject += row.reject;
    });
    
    $('#totalCount').text(total);
    $('#completeCount').text(complete);
    $('#pendingCount').text(pending);
    $('#rejectCount').text(reject);
}

// ============================================================
// DONUT CHART
// ============================================================
function updateDonutChart(data) {
    var complete = 0, pending = 0, reject = 0;
    
    $.each(data, function(index, row) {
        complete += row.complete;
        pending += row.pending;
        reject += row.reject;
    });
    
    var ctx = document.getElementById('donutChart').getContext('2d');
    
    if (donutChart) {
        donutChart.destroy();
    }
    
    donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Complete', 'Pending', 'Reject'],
            datasets: [{
                data: [complete, pending, reject],
                backgroundColor: ['#2e7d32', '#e65100', '#c62828'],
                borderWidth: 1.5,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%'
        }
    });
}

// ============================================================
// FILTER TABLE BY STATUS (Card Click)
// ============================================================
function filterTableByStatus(status) {
    currentFilter = status;
    
    $('.summary-card').removeClass('active');
    $('.summary-card[data-filter="' + status + '"]').addClass('active');
    
    var filteredData = [];
    if (status === 'all') {
        filteredData = demoData;
    } else {
        $.each(demoData, function(index, row) {
            if (row.status === status) {
                filteredData.push(row);
            }
        });
    }
    renderTableData(filteredData);
}

// ============================================================
// TABLE SEARCH
// ============================================================
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
        for (var j = 1; j < cells.length; j++) {
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
            newRow.innerHTML = '<td colspan="6"><div class="no-data"><i class="fa fa-info-circle"></i>No matching records for "<strong>' + filter + '</strong>"</div></td>';
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

// ============================================================
// EXPORT
// ============================================================
function exportF(elem) {
    if ($('#reportBody tr').length === 0 || $('#reportBody tr td .no-data').length > 0) {
        Swal.fire({ icon: 'warning', title: 'No Data', text: 'No data to export.', confirmButtonColor: '#e65100' });
        return false;
    }

    $(elem).prop('disabled', true).addClass('btn-loading');
    Swal.fire({ title: 'Exporting...', text: 'Please wait...', allowOutsideClick: false, didOpen: function() { Swal.showLoading(); } });

    setTimeout(function() {
        Swal.close();
        $(elem).prop('disabled', false).removeClass('btn-loading');
        Swal.fire({ icon: 'success', title: 'Exported!', text: 'Report exported successfully.', timer: 1500, showConfirmButton: false });
    }, 2000);
    return false;
}

// ============================================================
// DOCUMENT READY
// ============================================================
$(document).ready(function() {
    var today = new Date();
    var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    $('#fromDate').val(formatDateForInput(firstDay));
    $('#toDate').val(formatDateForInput(today));
    
    renderTableData(demoData);

    // ===== REGION CHANGE =====
    $('#region_id').on('change', function() {
        var regionId = $(this).val();
        var countrySelect = $('#country_search');
        countrySelect.empty();
        
        if (regionId) {
            var countries = {
                '1': ['Bangladesh', 'India', 'Pakistan'],
                '2': ['USA', 'Canada', 'Mexico'],
                '3': ['UK', 'France', 'Germany'],
                '4': ['UAE', 'Saudi Arabia', 'Egypt'],
                '5': ['China', 'Japan', 'South Korea']
            };
            
            var countryList = countries[regionId] || [];
            if (countryList.length > 0) {
                $.each(countryList, function(index, country) {
                    countrySelect.append('<option value="' + country + '">' + country + '</option>');
                });
            } else {
                countrySelect.append('<option value="">No countries available</option>');
            }
        } else {
            countrySelect.append('<option value="">Select region first</option>');
        }
        
        if ($.fn.multiselect) {
            countrySelect.multiselect('rebuild');
        }
    });

    // ===== DATE PICKER =====
    if ($.fn.datepicker) {
        $(".datepicker").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            autoclose: true
        });
    }
});

function formatDateForInput(date) {
    var day = String(date.getDate()).padStart(2, '0');
    var month = String(date.getMonth() + 1).padStart(2, '0');
    var year = date.getFullYear();
    return day + '-' + month + '-' + year;
}

// ============================================================
// SUBMIT BUTTON
// ============================================================
$('#submitBtn').on('click', function(e) {
    e.preventDefault();
    
    $(this).prop('disabled', true).addClass('btn-loading');
    
    setTimeout(function() {
        renderTableData(demoData);
        $('#submitBtn').prop('disabled', false).removeClass('btn-loading');
        
        Swal.fire({
            icon: 'success',
            title: 'Loaded!',
            text: 'Report loaded successfully.',
            timer: 1500,
            showConfirmButton: false
        });
    }, 1000);
});
</script>
@endsection