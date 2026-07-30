@extends('layouts.master')
@section('content')
<style>
    /* ============================================
       RESET & BASE
    ============================================ */
    * { box-sizing: border-box; }

    /* ============================================
       REPORT HEADER
    ============================================ */
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

    /* ============================================
       FILTER SECTION
    ============================================ */
    .filter-section {
        background: #ffffff;
        padding: 12px 20px;
        border-radius: 6px;
        margin-bottom: 15px;
        border: 1px solid #e8ecf1;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px 15px;
    }
    .filter-section .form-group {
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1 1 300px;
    }
    .filter-section .form-group label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: #4a5f7a;
        margin-bottom: 0;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }
    .filter-section .form-group label i {
        margin-right: 4px;
        color: #1e4a7a;
    }
    .filter-section .form-group input {
        flex: 1;
        padding: 6px 12px;
        border: 1px solid #d6dee9;
        border-radius: 4px;
        background: #fafcff;
        font-size: 13px;
        height: 34px;
        color: #1f2a44;
        transition: 0.2s;
        min-width: 200px;
    }
    .filter-section .form-group input:focus {
        border-color: #1e4a7a;
        outline: none;
        box-shadow: 0 0 0 3px rgba(30, 74, 122, 0.08);
    }
    .filter-section .form-group input::placeholder {
        color: #b0bccf;
        font-size: 12px;
    }
    .action-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }
    .btn-submit,
    .btn-export-excel {
        border: none;
        padding: 6px 18px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        cursor: pointer;
        height: 34px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: 0.2s;
        letter-spacing: 0.3px;
        white-space: nowrap;
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
    .btn-submit:disabled,
    .btn-export-excel:disabled {
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
        width: 14px;
        height: 14px;
        top: 50%;
        left: 50%;
        margin-left: -7px;
        margin-top: -7px;
        border: 2px solid rgba(255, 255, 255, 0.25);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 0.6s linear infinite;
    }
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* ============================================
       TABLE WRAPPER
    ============================================ */
    .custom-table-wrapper {
        border-radius: 6px;
        border: 1px solid #e8ecf1;
        overflow: hidden;
        background: #fff;
        position: relative;
    }

    /* ============================================
       SCROLL CONTAINER (Horizontal Scroll)
    ============================================ */
    .table-scroll-container {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 580px;
        position: relative;
        scroll-behavior: smooth;
    }

    /* Custom Scrollbar */
    .table-scroll-container::-webkit-scrollbar {
        height: 10px;
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

    /* Scroll Indicator - Bottom */
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
        letter-spacing: 0.5px;
    }
    .scroll-indicator i {
        margin: 0 4px;
    }
    .scroll-indicator.show {
        display: block;
    }

    /* ============================================
       TABLE STYLING - NO FIXED WIDTH
    ============================================ */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        background: #fff;
        margin-bottom: 0;
        border: 1px solid #e8ecf1;
        min-width: 1400px;
    }

    .custom-table thead th {
        background: #1a2a4a;
        color: #ffffff;
        text-align: center;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 8px 10px;
        border: 1px solid #1a2a4a;
        position: sticky;
        top: 0;
        z-index: 15;
        white-space: nowrap;
    }

    .custom-table tbody td {
        padding: 6px 10px;
        border: 1px solid #eef2f7;
        text-align: center;
        font-size: 11px;
        vertical-align: middle;
        white-space: normal;
        word-wrap: break-word;
        max-width: 250px;
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

    /* ============================================
       COLUMN MIN-WIDTH (Only minimum, no max)
    ============================================ */
    .custom-table td:nth-child(1) { min-width: 35px; }
    .custom-table td:nth-child(2) { min-width: 100px; }
    .custom-table td:nth-child(3) { min-width: 85px; }
    .custom-table td:nth-child(4) { min-width: 100px; }
    .custom-table td:nth-child(5) { min-width: 70px; }
    .custom-table td:nth-child(6) { min-width: 120px; }
    .custom-table td:nth-child(7) { min-width: 70px; }
    .custom-table td:nth-child(8) { min-width: 140px; }
    .custom-table td:nth-child(9) { min-width: 55px; }
    .custom-table td:nth-child(10) { min-width: 120px; }
    .custom-table td:nth-child(11) { min-width: 55px; }
    .custom-table td:nth-child(12) { min-width: 70px; }
    .custom-table td:nth-child(13) { min-width: 80px; }
    .custom-table td:nth-child(14) { min-width: 90px; }
    .custom-table td:nth-child(15) { min-width: 90px; }

    /* ============================================
       TOOLTIP
    ============================================ */
    .custom-table tbody td[title] {
        cursor: help;
    }

    /* ============================================
       NO DATA
    ============================================ */
    .no-data {
        text-align: center;
        padding: 40px 20px;
        color: #6a7b9c;
        font-size: 13px;
    }
    .no-data i {
        font-size: 32px;
        display: block;
        margin-bottom: 10px;
        color: #d0d9e8;
    }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 768px) {
        .filter-section {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-section .form-group {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-section .form-group input {
            min-width: 100%;
        }
        .action-group {
            width: 100%;
        }
        .btn-submit,
        .btn-export-excel {
            flex: 1;
            justify-content: center;
        }
        .custom-table td,
        .custom-table th {
            font-size: 9px;
            padding: 4px 6px !important;
        }
        .custom-table td { min-width: 60px !important; }
    }

    /* ============================================
       PRINT STYLES
    ============================================ */
    @media print {
        .filter-section,
        .btn-submit,
        .btn-export-excel,
        .scroll-indicator {
            display: none !important;
        }
        .custom-table-wrapper {
            border: none !important;
        }
        .custom-table thead th {
            background: #1a2a4a !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .table-scroll-container {
            overflow-x: visible !important;
            overflow-y: visible !important;
            max-height: none !important;
        }
        .custom-table {
            min-width: 100% !important;
        }
    }
</style>

<div class="container-fluid">
    <!-- HEADER -->
    <div class="report-header">
        <h4><i class="fa fa-file-text-o"></i> Invoice / JO Details Report</h4>
        <span style="font-size:11px; opacity:0.8;">
            <i class="fa fa-calendar"></i> {{ date('d-m-Y H:i:s') }}
        </span>
    </div>

    <!-- FILTER SECTION -->
    <div class="filter-section">
        <div class="form-group">
            <label for="searchInput"><i class="fa fa-search"></i> Search</label>
            <input type="text" id="searchInput" class="form-control" 
                   placeholder="Enter Invoice No or JO Number..." 
                   autocomplete="off">
        </div>
        <div class="action-group">
            <button class="btn-submit" id="submitBtn"><i class="fa fa-search"></i> Show</button>
            <button class="btn-export-excel" id="exportBtn" onclick="exportF(this)" disabled><i class="fa fa-file-excel-o"></i> Export</button>
        </div>
    </div>

    <!-- TABLE WRAPPER -->
    <div class="custom-table-wrapper">
        <div class="table-scroll-container" id="tableScrollContainer">
            <table class="custom-table" id="shipmentTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Contract No</th>
                        <th>Contract Date</th>
                        <th>Invoice No</th>
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
                    </tr>
                </thead>
                <tbody id="reportBody">
                    <tr>
                        <td colspan="15">
                            <div class="no-data">
                                <i class="fa fa-info-circle"></i>
                                Enter Invoice or JO Number and click "Show"
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="scroll-indicator" id="scrollIndicator">
            <i class="fa fa-arrows-h"></i> Scroll right to see more <i class="fa fa-arrow-right"></i>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        $('.sr-only').click();
    }, 0.0001);
    document.title = 'Invoice | JO Details Report';
    $(function() {
        $('#searchInput').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                loadReportData();
            }
        });

        $('#submitBtn').on('click', function(e) {
            e.preventDefault();
            loadReportData();
        });

        $('#tableScrollContainer').on('scroll', function() {
            var container = $(this);
            var scrollLeft = container.scrollLeft();
            var maxScroll = container[0].scrollWidth - container.width();

            if (scrollLeft > 50 && scrollLeft < maxScroll - 50) {
                $('#scrollIndicator').fadeOut(300);
            } else if (scrollLeft > maxScroll - 50) {
                $('#scrollIndicator').fadeOut(300);
            } else {
                $('#scrollIndicator').fadeIn(300);
            }
        });

        checkScrollNeeded();
    });

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

    function loadReportData() {
        var searchValue = $('#searchInput').val().trim();

        if (!searchValue) {
            Swal.fire({
                icon: 'warning',
                title: 'Empty Search',
                text: 'Please enter an Invoice or JO Number!',
                confirmButtonColor: '#e65100',
                confirmButtonText: 'OK'
            });
            return;
        }

        $('#exportBtn').prop('disabled', true);
        $('#submitBtn').prop('disabled', true).addClass('btn-loading');
        $('#scrollIndicator').removeClass('show');

        var url = "{{ url('/json/get/jo/invoice/details') }}";
        url += '?search=' + encodeURIComponent(searchValue);

        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            cache: false,
            timeout: 30000,
            success: function(response) {
                if (response.status === 'success') {
                    if (response.data && response.data.length > 0) {
                        renderTableData(response.data);
                        $('#exportBtn').prop('disabled', false);
                        setTimeout(function() { checkScrollNeeded(); }, 200);
                    } else {
                        showNoData('No records found for: ' + searchValue);
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

        if (!data || data.length === 0) {
            showNoData('No records found');
            return;
        }

        var sl = 0;
        $.each(data, function(index, row) {
            sl++;
            var rowHtml = '<tr>' +
                '<td>' + sl + '</td>' +
                '<td>' + (row.contract_no || '-') + '</td>' +
                '<td>' + (row.contract_date || '-') + '</td>' +
                '<td>' + (row.invoice_no || '-') + '</td>' +
                '<td>' + (row.party_code || '-') + '</td>' +
                '<td>' + (row.party_name || '-') + '</td>' +
                '<td>' + (row.ci_item_code || '-') + '</td>' +
                '<td>' + (row.ci_item_name || '-') + '</td>' +
                '<td><strong>' + (row.sc_qty || '0') + '</strong></td>' +
                '<td>' + (row.jo_number || '-') + '</td>' +
                '<td><strong>' + (row.jo_qty || '0') + '</strong></td>' +
                '<td>' + (row.fob_rate ? parseFloat(row.fob_rate).toFixed(6) : '0.000000') + '</td>' +
                '<td>' + (row.jo_date || '-') + '</td>' +
                '<td>' + (row.jo_creator || '-') + '</td>' +
                '<td>' + (row.contract_creator || '-') + '</td>' +
                '</tr>';

            tbody.append(rowHtml);
        });

        $('#exportBtn').prop('disabled', false);
        setTimeout(function() { checkScrollNeeded(); }, 200);
    }

    function showNoData(message) {
        var tbody = $('#reportBody');
        tbody.empty();
        tbody.html('<tr><td colspan="15"><div class="no-data"><i class="fa fa-info-circle"></i>' + message + '</div></td></tr>');
        $('#exportBtn').prop('disabled', true);
        $('#scrollIndicator').removeClass('show');
    }

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

        var searchValue = $('#searchInput').val().trim();
        var url = "{{ url('/export-jo-invoice-details') }}";
        url += '?search=' + encodeURIComponent(searchValue);

        window.open(url, '_blank');

        setTimeout(function() {
            Swal.close();
            $(elem).prop('disabled', false).removeClass('btn-loading');
        }, 2000);
    }
</script>
@endsection