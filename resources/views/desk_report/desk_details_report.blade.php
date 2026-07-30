@extends('layouts.master')
@section('content')
<style type="text/css">
    /* Professional Report Styling */
    .report-header {
        background: linear-gradient(135deg, #1a3a5c 0%, #2a5298 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 8px 8px 0 0;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .report-header h4 {
        margin: 0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 20px;
    }
    
    .report-header small {
        color: #b8d4f0;
        font-weight: 300;
        letter-spacing: 1px;
    }
    
    .filter-section {
        background: #f8f9fa;
        padding: 15px 20px;
        border-radius: 0 0 8px 8px;
        margin-bottom: 25px;
        border: 1px solid #e9ecef;
        border-top: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .filter-section .filter-group {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .filter-section .date-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .filter-section label {
        margin: 0;
        font-size: 12px;
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .filter-section .datepicker {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 6px 12px;
        font-size: 12px;
        width: 140px;
        transition: all 0.3s ease;
        background: white;
    }
    
    .filter-section .datepicker:focus {
        border-color: #2a5298;
        box-shadow: 0 0 0 0.2rem rgba(42, 82, 152, 0.25);
        outline: none;
    }
    
    .filter-section .action-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #0066cc 0%, #004d99 100%);
        color: white;
        border: none;
        padding: 7px 25px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 102, 204, 0.3);
    }
    
    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 102, 204, 0.4);
        background: linear-gradient(135deg, #0073e6 0%, #0055b3 100%);
    }
    
    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    .btn-export-excel {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        color: white;
        border: none;
        padding: 7px 20px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
    }
    
    .btn-export-excel:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.4);
        background: linear-gradient(135deg, #34ce57 0%, #218838 100%);
    }
    
    .btn-export-excel:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    .btn-export-excel i, .btn-submit i {
        margin-right: 5px;
    }
    
    .btn-loading {
        position: relative;
        pointer-events: none;
        color: transparent !important;
    }
    
    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 0.6s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .table-responsive {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        overflow-x: auto;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: relative;
        min-height: 200px;
    }
    
    .table-bordered > thead > tr > th {
        border: 1px solid #1a3a5c;
        background: #1a3a5c;
        color: #ffffff;
        text-align: center;
        text-transform: uppercase;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.5px;
        padding: 10px 6px;
        vertical-align: middle;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .table-bordered > tbody > tr > td {
        border: 1px solid #dee2e6;
        font-size: 11px;
        padding: 8px 6px;
        vertical-align: middle;
        color: #212529;
        font-weight: 500;
    }
    
    .table-bordered > tbody > tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    .table-bordered > tbody > tr:hover {
        background-color: #e3f2fd;
        transition: background-color 0.2s ease;
    }
    
    .table-bordered > tbody > tr > td:first-child {
        font-weight: 600;
        color: #1a3a5c;
    }
    
    .table-responsive::-webkit-scrollbar {
        height: 8px;
        width: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: #2a5298;
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #1a3a5c;
    }
    
    .report-footer {
        margin-top: 20px;
        padding: 10px 15px;
        background: #f8f9fa;
        border-radius: 4px;
        font-size: 12px;
        color: #6c757d;
        text-align: right;
        border: 1px solid #e9ecef;
    }
    
    .status-badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 9px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-active {
        background: #d4edda;
        color: #155724;
    }
    
    /* Loading Overlay */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 100;
        border-radius: 8px;
    }
    
    .loading-overlay.show {
        display: flex;
    }
    
    .loading-spinner {
        text-align: center;
    }
    
    .loading-spinner .spinner-border {
        width: 40px;
        height: 40px;
        border: 4px solid #e9ecef;
        border-top: 4px solid #1a3a5c;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: inline-block;
    }
    
    .loading-spinner p {
        margin-top: 10px;
        color: #1a3a5c;
        font-weight: 600;
    }
    
    /* No data message */
    .no-data {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
        font-size: 14px;
    }
    
    .no-data i {
        font-size: 40px;
        display: block;
        margin-bottom: 10px;
        color: #dee2e6;
    }
    
    /* Alert Messages */
    .alert-custom {
        padding: 10px 15px;
        border-radius: 4px;
        margin-bottom: 15px;
        font-size: 13px;
        display: none;
    }
    
    .alert-custom.alert-danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
        display: block;
    }
    
    .alert-custom.alert-success {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
        display: block;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .filter-section {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-section .filter-group {
            justify-content: center;
        }
        
        .filter-section .action-group {
            justify-content: center;
        }
        
        .btn-submit, .btn-export-excel {
            width: 100%;
        }
    }
</style>

<div class="container-fluid">
    <!-- Report Header -->
    <div class="report-header">
        <div class="row">
            <div class="col-md-8">
                <h4>
                    <i class="fa fa-file-text-o" style="margin-right: 10px;"></i>
                    Export Details Report
                </h4>
                <small>Comprehensive export transaction summary</small>
            </div>
            <div class="col-md-4 text-right" style="padding-top: 5px;">
                <span style="background: rgba(255,255,255,0.2); padding: 3px 15px; border-radius: 20px; font-size: 12px;">
                    <i class="fa fa-calendar"></i> 
                    <span id="currentDate">{{ date('d M Y') }}</span>
                </span>
            </div>
        </div>
    </div>
    
    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-group">
            <div class="date-group">
                <label><i class="fa fa-calendar"></i> From:</label>
                <input name="formDate" type="text" id="fromDate" class="datepicker" placeholder="DD-MM-YYYY">
            </div>
            <div class="date-group">
                <label><i class="fa fa-calendar"></i> To:</label>
                <input name="toDate" type="text" id="toDate" class="datepicker" placeholder="DD-MM-YYYY">
            </div>
        </div>
        <div class="action-group">
            <button class="btn-submit" id="submitBtn">
                <i class="fa fa-search"></i> Show Report
            </button>
            <button class="btn-export-excel" id="exportBtn" onclick="exportF(this)" disabled>
                <i class="fa fa-file-excel-o"></i> Export Excel
            </button>
        </div>
    </div>
    
    <!-- Alert Messages -->
    <div class="alert-custom" id="alertMessage"></div>
    
    <!-- Table -->
    <div class="table-responsive" id="tableContainer">
        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner">
                <div class="spinner-border"></div>
                <p>Loading report data...</p>
            </div>
        </div>
        <table class="table table-condensed table-bordered" id="inv" width="100%" style="display: none;">
            <thead>
                <tr>
                    <th style="min-width: 80px;">SC No.</th>
                    <th style="min-width: 90px;">SC Date</th>
                    <th style="min-width: 150px;">Company</th>
                    <th style="min-width: 150px;">Bank Name</th>
                    <th style="min-width: 100px;">EXP No.</th>
                    <th style="min-width: 100px;">EXP Date</th>
                    <th style="min-width: 110px;">Invoice Amt</th>
                    <th style="min-width: 100px;">Freight</th>
                    <th style="min-width: 110px;">Sales Terms</th>
                    <th style="min-width: 100px;">Invoice No.</th>
                    <th style="min-width: 100px;">Invoice Date</th>
                    <th style="min-width: 130px;">Bank Submission</th>
                    <th style="min-width: 110px;">AC Amount</th>
                    <th style="min-width: 200px;">Importer</th>
                    <th style="min-width: 200px;">Notify Party</th>
                    <th style="min-width: 120px;">User/Staff</th>
                    <th style="min-width: 150px;">Discharge Port</th>
                    <th style="min-width: 150px;">Final Destination</th>
                </tr>
            </thead>
            <tbody id="reportBody">
                <!-- Data will be loaded here via AJAX -->
            </tbody>
        </table>
    </div>
    
    <!-- Report Footer -->
    <div class="report-footer" id="reportFooter" style="display: none;">
        <span><i class="fa fa-clock-o"></i> Generated on: <span id="generatedTime">{{ date('d M Y h:i A') }}</span></span>
        <span style="margin-left: 20px;"><i class="fa fa-file-text-o"></i> Total Records: <span id="totalRecords">0</span></span>
    </div>
</div>
<script>
    document.title = 'Export Details Report | Desk';
    setTimeout(function() { 
  $('.sr-only').click();
}, 0.0001); 
    $(document).ready(function() {
        // Initialize datepickers
        $(".datepicker").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            autoclose: true
        });
        
        // Set default dates (current date and 30 days ago)
        var today = new Date();
        var thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(today.getDate() - 30);
        
        $('#fromDate').datepicker('setDate', thirtyDaysAgo);
        $('#toDate').datepicker('setDate', today);
        
        // Submit button click handler
        $('#submitBtn').on('click', function(e) {
            e.preventDefault();
            loadReportData();
        });
        
        // Enter key press handler for date inputs
        $('.datepicker').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                loadReportData();
            }
        });
    });
    
    // Function to load report data via AJAX
    function loadReportData() {

        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();
        
        // Validate dates
        if (!fromDate || !toDate) {
            showAlert('Please select both From and To dates', 'danger');
            return;
        }
        
        // Validate date range
        if (!validateDateRange(fromDate, toDate)) {
            showAlert('From date must be earlier than To date', 'danger');
            return;
        }
        
        // Hide any previous alerts
        $('#alertMessage').hide();
        
        // Show loading overlay
        $('#loadingOverlay').addClass('show');
        $('#inv').hide();
        $('#reportFooter').hide();
        $('#exportBtn').prop('disabled', true);
        $('#submitBtn').prop('disabled', true).addClass('btn-loading');
        
        // Make AJAX request
        $.ajax({
            url: "{{ url('/export/details_report/data') }}",
            type: "GET",
            data: {
                fromDate: fromDate,
                toDate: toDate
            },
            dataType: "json",
            timeout: 30000, // 30 seconds timeout
            success: function(response) {

                if (response.status === 'success') {
                    if (response.data && response.data.length > 0) {
                        renderTableData(response.data);
                        $('#totalRecords').text(response.data.length);
                        $('#generatedTime').text(new Date().toLocaleString());
                        $('#reportFooter').show();
                        $('#exportBtn').prop('disabled', false);
                        showAlert('Report loaded successfully! Found ' + response.data.length + ' records.', 'success');
                    } else {
                        showNoData('No records found for the selected date range');
                        showAlert('No records found for the selected date range', 'warning');
                    }
                } else {
                    showNoData('Error: ' + response.message);
                    showAlert('Error: ' + response.message, 'danger');
                }
            },
            error: function(xhr, status, error) {
                
                var errorMessage = 'Failed to load report data. ';
                if (status === 'timeout') {
                    errorMessage += 'The request timed out. Please try again.';
                } else if (xhr.status === 404) {
                    errorMessage += 'The requested URL was not found.';
                } else if (xhr.status === 500) {
                    errorMessage += 'Server error occurred. Please try again later.';
                } else {
                    errorMessage += 'Please try again.';
                }
                
                showNoData(errorMessage);
                showAlert(errorMessage, 'danger');
            },
            complete: function() {
                $('#loadingOverlay').removeClass('show');
                $('#submitBtn').prop('disabled', false).removeClass('btn-loading');
            }
        });
    }
    
    // Function to validate date range
    function validateDateRange(fromDate, toDate) {
        var from = parseDate(fromDate);
        var to = parseDate(toDate);
        
        if (!from || !to) return false;
        
        return from <= to;
    }
    
    // Function to parse date from dd-mm-yyyy format
    function parseDate(dateStr) {
        var parts = dateStr.split('-');
        if (parts.length !== 3) return null;
        
        var day = parseInt(parts[0]);
        var month = parseInt(parts[1]) - 1;
        var year = parseInt(parts[2]);
        
        if (isNaN(day) || isNaN(month) || isNaN(year)) return null;
        
        return new Date(year, month, day);
    }
    
    // Function to show alert messages
    function showAlert(message, type) {
        var alertDiv = $('#alertMessage');
        alertDiv.removeClass('alert-danger alert-success alert-warning');
        
        if (type === 'danger') {
            alertDiv.addClass('alert-danger');
        } else if (type === 'success') {
            alertDiv.addClass('alert-success');
        } else if (type === 'warning') {
            alertDiv.addClass('alert-warning');
            alertDiv.css({
                'background': '#fff3cd',
                'border': '1px solid #ffeeba',
                'color': '#856404',
                'display': 'block'
            });
        }
        
        alertDiv.html('<i class="fa fa-' + (type === 'danger' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle') + '"></i> ' + message);
        alertDiv.show();
        
        // Auto hide after 5 seconds for success messages
        if (type === 'success') {
            setTimeout(function() {
                alertDiv.fadeOut('slow');
            }, 5000);
        }
    }
    
    // Function to render table data
    function renderTableData(data) {
        var tbody = $('#reportBody');
        tbody.empty();
        
        if (!data || data.length === 0) {
            showNoData('No records found for the selected date range');
            return;
        }
        
        $.each(data, function(index, result) {
            var row = `
                <tr>
                    <td><strong>${result.sc_no || '-'}</strong></td>
                    <td>${result.sc_date || '-'}</td>
                    <td>${result.company_name || '-'}</td>
                    <td>${result.bank_name || '-'}</td>
                    <td>${result.export_no || '-'}</td>
                    <td>${result.export_date ? formatDate(result.export_date) : '-'}</td>
                    <td style="font-weight: 600; color: #1a3a5c; text-align: right;">${result.invoice_amount ? formatCurrency(result.invoice_amount) : '0.00'}</td>
                    <td style="text-align: right;">${result.freight_cost ? formatCurrency(result.freight_cost) : '0.00'}</td>
                    <td><span class="status-badge status-active">${result.sales_term || '-'}</span></td>
                    <td>${result.invoice_no || '-'}</td>
                    <td>${result.invoice_date || '-'}</td>
                    <td>${result.bank_for_print_date || '-'}</td>
                    <td style="font-weight: 600; color: #28a745; text-align: right;">${result.ac_amount ? formatCurrency(result.ac_amount) : '0.00'}</td>
                    <td>${result.importer_name || '-'}</td>
                    <td>${result.notify_pary_name || '-'}</td>
                    <td>${result.user_Name || '-'}</td>
                    <td>${result.discharge_port || '-'}</td>
                    <td>${result.final_destination || '-'}</td>
                </tr>
            `;
            tbody.append(row);
        });
        
        $('#inv').show();
    }
    
    // Function to show no data message
    function showNoData(message) {
        var tbody = $('#reportBody');
        tbody.empty();
        tbody.html(`
            <tr>
                <td colspan="18">
                    <div class="no-data">
                        <i class="fa fa-info-circle"></i>
                        ${message}
                    </div>
                </td>
            </tr>
        `);
        $('#inv').show();
        $('#reportFooter').hide();
        $('#exportBtn').prop('disabled', true);
    }
    
    // Helper function to format date
    function formatDate(dateString) {
        if (!dateString) return '';
        try {
            var date = new Date(dateString);
            if (isNaN(date.getTime())) return dateString;
            var day = String(date.getDate()).padStart(2, '0');
            var month = String(date.getMonth() + 1).padStart(2, '0');
            var year = date.getFullYear();
            return `${day}-${month}-${year}`;
        } catch (e) {
            return dateString;
        }
    }
    
    // Helper function to format currency
    function formatCurrency(amount) {
        if (!amount) return '0.00';
        var num = parseFloat(amount);
        if (isNaN(num)) return '0.00';
        return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
    
    // Function to export to Excel with current data
    function exportF(elem) {
        // Get the current table
        var table = document.getElementById("inv");
        
        // Check if table has data
        if ($('#reportBody tr').length === 0 || $('#reportBody tr td .no-data').length > 0) {
            showAlert('No data available to export', 'warning');
            return false;
        }
        
        // Show loading state on export button
        $(elem).prop('disabled', true).addClass('btn-loading');
        
        try {
            // Build Excel content
            var excelContent = '';
            
            // Add report title
            excelContent += 'Export Details Report\n';
            excelContent += 'Generated on: ' + new Date().toLocaleString() + '\n';
            excelContent += 'From: ' + $('#fromDate').val() + ' To: ' + $('#toDate').val() + '\n\n';
            
            // Get headers
            var headers = [];
            $('#inv thead th').each(function() {
                headers.push($(this).text().trim());
            });
            excelContent += headers.join('\t') + '\n';
            
            // Get data rows
            $('#reportBody tr').each(function() {
                var row = [];
                $(this).find('td').each(function() {
                    var text = $(this).text().trim();
                    // Remove currency symbols and extra spaces
                    text = text.replace(/[$,]/g, '').replace(/\s+/g, ' ').trim();
                    row.push(text);
                });
                if (row.length > 0) {
                    excelContent += row.join('\t') + '\n';
                }
            });
            
            // Add footer
            excelContent += '\nTotal Records: ' + $('#totalRecords').text();
            
            // Create Blob and download
            var blob = new Blob([excelContent], { 
                type: 'application/vnd.ms-excel;charset=utf-8' 
            });
            
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            var fileName = `export_details_report_${new Date().toISOString().split('T')[0]}.xls`;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
            
            showAlert('Report exported successfully!', 'success');
            
        } catch (error) {
            console.error('Export error:', error);
            showAlert('Failed to export report. Please try again.', 'danger');
        } finally {
            // Remove loading state
            $(elem).prop('disabled', false).removeClass('btn-loading');
        }
        
        return false;
    }
</script>
@endsection