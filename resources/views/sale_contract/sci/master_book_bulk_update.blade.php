@extends('layouts.master')
@section('content') 
<style>
    .upload-section {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        padding: 20px;
        margin-bottom: 15px;
        border: 1px solid #e9edf2;
    }
    .upload-section .upload-title {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .upload-section .upload-title i {
        color: #2563eb;
    }
    .upload-section .upload-area {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }
    .upload-section .upload-area .file-input-wrap {
        flex: 1;
        min-width: 250px;
    }
    .upload-section .upload-area .file-input-wrap input[type="file"] {
        width: 100%;
        padding: 8px 12px;
        border: 2px dashed #d1d5db;
        border-radius: 6px;
        font-size: 12px;
        background: #f8fafc;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .upload-section .upload-area .file-input-wrap input[type="file"]:hover {
        border-color: #2563eb;
        background: #eff6ff;
    }
    .upload-section .upload-area .btn-upload {
        padding: 8px 25px;
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
        height: 40px;
    }
    .upload-section .upload-area .btn-upload:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
    }
    .upload-section .upload-area .btn-upload:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    .upload-section .upload-info {
        font-size: 11px;
        color: #64748b;
        margin-top: 8px;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    .upload-section .upload-info span {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .upload-section .upload-info i {
        color: #2563eb;
    }

    /* ===== TABLE WITH VERTICAL SCROLL ===== */
    .table-wrapper {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        padding: 15px 18px;
        border: 1px solid #e9edf2;
        margin-top: 15px;
    }
    .table-wrapper .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 10px;
        margin-bottom: 12px;
        flex-wrap: wrap;
        gap: 10px;
    }
    .table-wrapper .table-header .table-title {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .table-wrapper .table-header .table-title i {
        color: #2563eb;
    }
    .table-wrapper .table-header .table-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }
    .table-wrapper .table-header .table-actions .btn-sm {
        padding: 4px 14px;
        font-size: 11px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .table-wrapper .table-header .table-actions .btn-sm.btn-success {
        background: #16a34a;
        color: #fff;
    }
    .table-wrapper .table-header .table-actions .btn-sm.btn-success:hover {
        background: #15803d;
    }
    .table-wrapper .table-header .table-actions .btn-sm.btn-danger {
        background: #dc2626;
        color: #fff;
    }
    .table-wrapper .table-header .table-actions .btn-sm.btn-danger:hover {
        background: #b91c1c;
    }
    .table-wrapper .table-header .table-actions .btn-sm.btn-info {
        background: #2563eb;
        color: #fff;
    }
    .table-wrapper .table-header .table-actions .btn-sm.btn-info:hover {
        background: #1d4ed8;
    }

    /* Scrollable Table */
    .table-scroll-container {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 500px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
    }
    .table-scroll-container table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        min-width: 1200px;
    }
    .table-scroll-container table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .table-scroll-container table thead th {
        background: #1e293b;
        color: #f1f5f9;
        padding: 8px 8px;
        text-align: left;
        font-weight: 700;
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border-bottom: 2px solid #0f172a;
        white-space: nowrap;
    }
    .table-scroll-container table tbody td {
        padding: 6px 8px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
        font-size: 11px;
        color: #1e293b;
    }
    .table-scroll-container table tbody tr:hover {
        background: #f8fafc;
    }
    .table-scroll-container table tbody tr:nth-child(even) {
        background: #fafbfc;
    }
    .table-scroll-container table tbody tr:nth-child(even):hover {
        background: #f1f3f5;
    }
    /* Last column sticky */
    .table-scroll-container table td:last-child,
    .table-scroll-container table th:last-child {
        position: sticky;
        right: 0;
        background: #1e293b;
        z-index: 5;
        border-left: 2px solid #334155;
        min-width: 100px;
    }
    .table-scroll-container table tbody td:last-child {
        background: #fff;
        border-left: 2px solid #e2e8f0;
        box-shadow: -2px 0 8px rgba(0,0,0,0.05);
    }
    .table-scroll-container table tbody tr:nth-child(even) td:last-child {
        background: #fafbfc;
    }
    .table-scroll-container table tbody tr:hover td:last-child {
        background: #f8fafc;
    }
    .table-scroll-container table td:last-child .status-label {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 8px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .table-scroll-container table td:last-child .status-label.saved {
        background: #dcfce7;
        color: #166534;
    }
    .table-scroll-container table td:last-child .status-label.not-saved {
        background: #fee2e2;
        color: #991b1b;
    }

    /* ===== SUMMARY CARD ===== */
    .summary-wrapper {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 15px;
    }
    .summary-card {
        flex: 1;
        min-width: 150px;
        background: #f8fafc;
        border-radius: 8px;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        text-align: center;
        transition: all 0.3s ease;
    }
    .summary-card:hover {
        border-color: #2563eb;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.1);
    }
    .summary-card .summary-number {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        display: block;
        line-height: 1.2;
    }
    .summary-card .summary-label {
        font-size: 9px;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-top: 2px;
    }
    .summary-card .summary-number.blue { color: #2563eb; }
    .summary-card .summary-number.green { color: #16a34a; }
    .summary-card .summary-number.orange { color: #f59e0b; }
    .summary-card .summary-number.purple { color: #7c3aed; }
    .summary-card .summary-number.red { color: #dc2626; }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #94a3b8;
    }
    .empty-state i {
        font-size: 40px;
        display: block;
        margin-bottom: 10px;
        color: #cbd5e1;
    }
    .empty-state .empty-title {
        font-size: 16px;
        font-weight: 600;
        color: #475569;
    }
    .empty-state .empty-sub {
        font-size: 12px;
        color: #94a3b8;
    }

    .loading-spinner {
        width: 25px;
        height: 25px;
        border: 2px solid #f1f5f9;
        border-top-color: #2563eb;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @media (max-width: 768px) {
        .upload-section .upload-area {
            flex-direction: column;
            align-items: stretch;
        }
        .upload-section .upload-area .file-input-wrap {
            min-width: 100%;
        }
        .upload-section .upload-area .btn-upload {
            width: 100%;
            justify-content: center;
        }
        .table-wrapper .table-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .summary-wrapper {
            flex-direction: column;
        }
        .summary-card {
            min-width: 100%;
        }
        .table-scroll-container {
            max-height: 350px;
        }
        .table-scroll-container table {
            font-size: 9px;
            min-width: 900px;
        }
        .table-scroll-container table thead th {
            font-size: 8px;
            padding: 4px 4px;
        }
        .table-scroll-container table tbody td {
            padding: 3px 4px;
            font-size: 9px;
        }
    }
</style>

<!-- ===== UPLOAD SECTION ===== -->
<div class="upload-section">
    <div class="upload-title">
        <i class="fa fa-upload"></i> Upload Excel File
    </div>
    <div class="upload-area">
        <div class="file-input-wrap">
            <input type="file" id="excelFile" accept=".xlsx,.xls" class="form-control">
        </div>
        <button class="btn-upload" id="uploadBtn">
            <i class="fa fa-cloud-upload"></i> Upload & Preview
        </button>
    </div>
    <div class="upload-info">
        <span><i class="fa fa-file-excel-o"></i> Supported: .xlsx, .xls</span>
        <span><i class="fa fa-info-circle"></i> Max file size: 5MB</span>
        <span><i class="fa fa-columns"></i> Required columns: Invoice Number, TT Amount, Realized Amount(In USD), TT Date, Proceeds realization date, OD Sight Rate, PRC Issue Number, TT Number, Importer Bank, Bank Address</span>
    </div>
</div>

<!-- ===== TABLE SECTION ===== -->
<div class="table-wrapper" id="tableWrapper" style="display:none;">
    <div class="table-header">
        <div class="table-title">
            <i class="fa fa-table"></i> Excel Data Preview
            <span style="font-size:11px; font-weight:400; color:#64748b; margin-left:8px;" id="recordCount">0 records</span>
        </div>
        <div class="table-actions">
            <button class="btn-sm btn-success" id="saveDataBtn">
                <i class="fa fa-save"></i> Save All
            </button>
            <button class="btn-sm btn-danger" id="clearDataBtn">
                <i class="fa fa-trash"></i> Clear All
            </button>
        </div>
    </div>

    <!-- Scrollable Table -->
    <div class="table-scroll-container" id="tableContainer">
        <table>
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Invoice Number</th>
                    <th style="text-align:right;">TT Amount</th>
                    <th style="text-align:right;">Realized Amount (USD)</th>
                    <th>TT Date</th>
                    <th>Proceeds Realization Date</th>
                    <th style="text-align:right;">OD Sight Rate</th>
                    <th>PRC Issue Number</th>
                    <th>TT Number</th>
                    <th>Importer Bank</th>
                    <th>Bank Address</th>
                    <th style="min-width:100px; text-align:center;">Status</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Data will be loaded here -->
            </tbody>
        </table>
    </div>

    <!-- ===== SUMMARY SECTION ===== -->
    <div class="summary-wrapper" id="summaryWrapper">
        <div class="summary-card">
            <span class="summary-number blue" id="totalRecords">0</span>
            <span class="summary-label">Total Records</span>
        </div>
        <div class="summary-card">
            <span class="summary-number orange" id="totalTTAmount">0.00</span>
            <span class="summary-label">Total TT Amount</span>
        </div>
        <div class="summary-card">
            <span class="summary-number green" id="totalRealized">0.00</span>
            <span class="summary-label">Total Realized Amount</span>
        </div>
        <div class="summary-card">
            <span class="summary-number red" id="pendingCount">0</span>
            <span class="summary-label">Pending (No TT Date)</span>
        </div>
        <div class="summary-card" style="border-color:#dc2626;">
            <span class="summary-number red" id="notSavedCount">0</span>
            <span class="summary-label">Not Saved</span>
        </div>
    </div>
</div>
<script>
document.title = 'Excel Upload';

$(document).ready(function() {
    setTimeout(function() { $('.sr-only').click(); }, 0.0001);
    let tableData = [];

    // ===== HELPER: Check if value is a date serial number =====
    function isDateSerialNumber(value) {
        if (typeof value === 'number' && !isNaN(value) && value > 0 && value < 100000) {
            var date = new Date((value - 25569) * 86400 * 1000);
            var year = date.getFullYear();
            return year >= 1900 && year <= 2100;
        }
        return false;
    }

    // ===== HELPER: Convert serial number to date string =====
    function serialToDate(value) {
        if (!value) return '';
        var date = new Date((value - 25569) * 86400 * 1000);
        var year = date.getFullYear();
        var month = ('0' + (date.getMonth() + 1)).slice(-2);
        var day = ('0' + date.getDate()).slice(-2);
        return year + '-' + month + '-' + day;
    }

    // ===== UPLOAD BUTTON =====
    $('#uploadBtn').on('click', function() {
        var fileInput = document.getElementById('excelFile');
        var file = fileInput.files[0];

        if (!file) {
            Swal.fire({
                icon: 'warning',
                title: 'No File Selected',
                text: 'Please select an Excel file to upload.',
                confirmButtonText: 'OK'
            });
            return;
        }

        var validTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
        if (!validTypes.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid File Type',
                text: 'Please upload a valid Excel file (.xlsx or .xls).',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File Too Large',
                text: 'Please upload a file smaller than 5MB.',
                confirmButtonText: 'OK'
            });
            return;
        }

        var reader = new FileReader();
        reader.onload = function(e) {
            try {
                var data = new Uint8Array(e.target.result);
                var workbook = XLSX.read(data, { 
                    type: 'array',
                    cellDates: false,
                    cellText: false,
                    cellNF: false,
                    cellStyles: false,
                    raw: true
                });
                
                var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                var jsonData = XLSX.utils.sheet_to_json(firstSheet, { 
                    header: 1,
                    defval: '',
                    raw: true
                });

                if (!jsonData || jsonData.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Empty File',
                        text: 'The Excel file is empty or has no data.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Skip header row if present
                var startRow = 0;
                var firstRow = jsonData[0] || [];
                
                var hasHeaders = firstRow.some(function(cell) {
                    return typeof cell === 'string' && (
                        cell.toLowerCase().includes('invoice') ||
                        cell.toLowerCase().includes('tt') ||
                        cell.toLowerCase().includes('amount') ||
                        cell.toLowerCase().includes('date') ||
                        cell.toLowerCase().includes('bank')
                    );
                });

                if (hasHeaders) {
                    startRow = 1;
                }

                // Map data column wise
                tableData = [];
                for (var i = startRow; i < jsonData.length; i++) {
                    var row = jsonData[i];
                    if (!row || row.length === 0) continue;
                    
                    var hasData = row.some(function(cell) {
                        return cell !== '' && cell !== null && cell !== undefined;
                    });
                    
                    if (!hasData) continue;

                    // Process date columns
                    var ttDate = row[3] || '';
                    var proceedsDate = row[4] || '';

                    if (isDateSerialNumber(ttDate)) {
                        ttDate = serialToDate(ttDate);
                    }
                    if (isDateSerialNumber(proceedsDate)) {
                        proceedsDate = serialToDate(proceedsDate);
                    }

                    tableData.push({
                        id: i - startRow + 1,
                        invoice_no: row[0] || '',
                        tt_amount: row[1] || '',
                        realized_amount: row[2] || '',
                        tt_date: ttDate,
                        proceeds_date: proceedsDate,
                        od_sight_rate: row[5] || '',
                        prc_issue_no: row[6] || '',
                        tt_no: row[7] || '',
                        importer_bank: row[8] || '',
                        bank_address: row[9] || '',
                        is_saved: false
                    });
                }

                if (tableData.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'No Data Found',
                        text: 'No valid data found in the Excel file. Please check the format.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                renderTable(tableData);
                updateSummary(tableData);

                $('#tableWrapper').show();

                Swal.fire({
                    icon: 'success',
                    title: 'File Loaded!',
                    text: 'Successfully loaded ' + tableData.length + ' records.',
                    timer: 1500,
                    showConfirmButton: false
                });

            } catch (error) {
                console.error('Error parsing Excel:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to parse the Excel file. Please check the format.',
                    confirmButtonText: 'OK'
                });
            }
        };
        reader.readAsArrayBuffer(file);
    });

    // ===== RENDER TABLE =====
    function renderTable(data) {
        var tbody = $('#tableBody');
        tbody.empty();

        if (!data || data.length === 0) {
            tbody.html('<tr><td colspan="12" class="empty-state"><i class="fa fa-inbox"></i><div class="empty-title">No Data</div><div class="empty-sub">Upload an Excel file to see data here.</div></td></tr>');
            $('#recordCount').text('0 records');
            return;
        }

        data.forEach(function(item, index) {
            var statusLabel = item.is_saved 
                ? '<span class="status-label saved">✓ Saved</span>'
                : '<span class="status-label not-saved">✗ Not Saved</span>';

            var row = '<tr>';
            row += '<td>' + (index + 1) + '</td>';
            row += '<td>' + (item.invoice_no || '-') + '</td>';
            row += '<td style="text-align:right;">' + (item.tt_amount || '0.00') + '</td>';
            row += '<td style="text-align:right;">' + (item.realized_amount || '0.00') + '</td>';
            row += '<td>' + (item.tt_date || '-') + '</td>';
            row += '<td>' + (item.proceeds_date || '-') + '</td>';
            row += '<td style="text-align:right;">' + (item.od_sight_rate || '0.00') + '</td>';
            row += '<td>' + (item.prc_issue_no || '-') + '</td>';
            row += '<td>' + (item.tt_no || '-') + '</td>';
            row += '<td>' + (item.importer_bank || '-') + '</td>';
            row += '<td>' + (item.bank_address || '-') + '</td>';
            row += '<td style="text-align:center;">' + statusLabel + '</td>';
            row += '</tr>';
            tbody.append(row);
        });

        $('#recordCount').text(data.length + ' records');
    }

    // ===== UPDATE SUMMARY =====
    function updateSummary(data) {
        if (!data || data.length === 0) {
            $('#totalRecords').text('0');
            $('#totalTTAmount').text('0.00');
            $('#totalRealized').text('0.00');
            $('#pendingCount').text('0');
            $('#notSavedCount').text('0');
            return;
        }

        var totalRecords = data.length;
        var totalTT = 0;
        var totalRealized = 0;
        var pending = 0;
        var notSaved = 0;

        data.forEach(function(item) {
            totalTT += parseFloat(item.tt_amount) || 0;
            totalRealized += parseFloat(item.realized_amount) || 0;
            if (!item.tt_date || item.tt_date === '') {
                pending++;
            }
            if (!item.is_saved) {
                notSaved++;
            }
        });

        $('#totalRecords').text(totalRecords);
        $('#totalTTAmount').text(totalTT.toFixed(2));
        $('#totalRealized').text(totalRealized.toFixed(2));
        $('#pendingCount').text(pending);
        $('#notSavedCount').text(notSaved);
    }

    // ===== CLEAR ALL DATA =====
    $('#clearDataBtn').on('click', function() {
        if (tableData.length === 0) {
            Swal.fire('Info', 'No data to clear.', 'info');
            return;
        }

        Swal.fire({
            title: 'Clear All Data?',
            text: 'This will remove all records from the table.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, Clear All',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                tableData = [];
                renderTable(tableData);
                updateSummary(tableData);
                $('#tableWrapper').hide();
                Swal.fire('Cleared!', 'All records have been cleared.', 'success');
            }
        });
    });

    // ===== SAVE ALL DATA =====
    $('#saveDataBtn').on('click', function() {
        if (tableData.length === 0) {
            Swal.fire('Info', 'No data to save.', 'info');
            return;
        }

        Swal.fire({
            title: 'Saving...',
            text: 'Please wait while saving data.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '/save_master_book/bulk_upload',
            type: 'POST',
            data: {
                data: tableData,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.saved_invoices) {
                    tableData = tableData.map(function(item) {
                        if (response.saved_invoices.includes(item.invoice_no)) {
                            item.is_saved = true;
                        }
                        return item;
                    });
                    
                    var notSavedData = tableData.filter(function(item) {
                        return !item.is_saved && item.invoice_no !== '';
                    });

                    if (notSavedData.length > 0) {
                        var notSavedList = notSavedData.map(function(item) {
                            return item.invoice_no;
                        });

                        var html = '<div style="text-align:left; max-height:300px; overflow-y:auto;">';
                        html += '<p style="font-weight:600; color:#dc2626; margin-bottom:10px;">The following invoices were not saved:</p>';
                        html += '<ul style="list-style:none; padding:0; margin:0;">';
                        notSavedList.forEach(function(invoice) {
                            html += '<li style="padding:3px 0; border-bottom:1px solid #f1f5f9; color:#991b1b;">✗ ' + invoice + '</li>';
                        });
                        html += '</ul>';
                        html += '<p style="margin-top:10px; font-size:12px; color:#64748b;">Please check and try again.</p>';
                        html += '</div>';

                        Swal.fire({
                            icon: 'warning',
                            title: 'Partial Save',
                            html: html,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#2563eb'
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: response.message || 'All records have been saved successfully.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#16a34a'
                        });
                    }

                    renderTable(tableData);
                    updateSummary(tableData);
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Failed to save data.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // ===== EXPORT =====
    $('#exportBtn').on('click', function() {
        if (tableData.length === 0) {
            Swal.fire('Info', 'No data to export.', 'info');
            return;
        }

        var exportData = tableData.map(function(item) {
            return {
                'Invoice Number': item.invoice_no || '',
                'TT Amount': item.tt_amount || '0.00',
                'Realized Amount(In USD)': item.realized_amount || '0.00',
                'TT Date': item.tt_date || '',
                'Proceeds realization date': item.proceeds_date || '',
                'OD Sight Rate': item.od_sight_rate || '0.00',
                'PRC Issue Number': item.prc_issue_no || '',
                'TT Number': item.tt_no || '',
                'Importer Bank': item.importer_bank || '',
                'Bank Address': item.bank_address || '',
                'Status': item.is_saved ? 'Saved' : 'Not Saved'
            };
        });

        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.json_to_sheet(exportData);
        XLSX.utils.book_append_sheet(wb, ws, 'Data');
        XLSX.writeFile(wb, 'Excel_Data_Export_' + new Date().toISOString().slice(0,10) + '.xlsx');

        Swal.fire({
            icon: 'success',
            title: 'Exported!',
            text: 'File downloaded successfully.',
            timer: 1500,
            showConfirmButton: false
        });
    });

});
</script>
@endsection