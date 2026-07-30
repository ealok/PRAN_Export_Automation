@extends('layouts.master')
@section('content')
<style type="text/css">
    .table-bordered > thead > tr > th{
        border: 1px solid #919191;
    }
    .th_width_line{
        color: white;
    }
    tbody {
        overflow-x: auto;   
    }
    .table-bordered > tbody > tr > td{
        border: 1px solid #5e4545;
    }
    
    /* Search Section Styles */
    .search-section {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .search-section h4 {
        color: #3f5164;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #3f5164;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 5px;
        display: block;
    }
    
 
    .form-control {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 8px 12px;
        height: 38px;
    }
    
    .form-control:focus {
        border-color: #3f5164;
        box-shadow: 0 0 0 0.2rem rgba(63, 81, 100, 0.25);
    }
    
    .form-control.error {
        border-color: red;
    }
    
    .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
        display: none;
    }
    
    .checkbox-group {
        display: flex;
        align-items: center;
        margin-top: 25px;
    }
    
    .checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-right: 8px;
        cursor: pointer;
    }
    
    .checkbox-group label {
        margin-bottom: 0;
        cursor: pointer;
        font-weight: 500;
    }
    
    .btn-search {
        background-color: #3f5164;
        border: none;
        padding: 8px 25px;
        font-weight: 600;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        height: 38px;
        margin-top: 25px;
    }
    
    .btn-search:hover {
        background-color: #2c3b4a;
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    
    .btn-search:active {
        transform: translateY(0);
    }
    
    .btn-search:disabled {
        background-color: #6c757d;
        cursor: not-allowed;
        transform: none;
    }
    
    .results-section {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
    }
    
    .results-section h4 {
        color: #3f5164;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #3f5164;
    }
    
    /* Responsive adjustments */
    @media (min-width: 768px) {
        .search-row {
            display: flex;
            gap: 15px;
            align-items: flex-end;
        }
        
        .search-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }
        
        .checkbox-group {
            margin-top: 0;
        }
        
        .btn-search {
            margin-top: 0;
        }
    }
    
    /* Loading indicator */
    .loading {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
    }
    
    .loading-spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3f5164;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Export button styling */
    .dt-buttons {
        margin-bottom: 15px;
    }
    
    .buttons-excel {
        background-color: #28a745 !important;
        color: white !important;
        border: none !important;
        padding: 5px 15px !important;
        border-radius: 4px !important;
    }
    
    .buttons-excel:hover {
        background-color: #218838 !important;
    }
</style>

<!-- Loading Indicator -->
<div class="loading">
    <div class="loading-spinner"></div>
</div>

<!-- Search Section -->
<div class="search-section">
    <h4><i class="fa fa-search" style="margin-right: 8px;"></i>Search Filters</h4>
    <form id="searchForm">
        <div class="search-row">
            <div class="form-group">
                <label for="from_date" class="required">From Date</label>
                <input type="text" class="form-control datepicker" id="from_date" name="from_date" value="" placeholder="Select from date" required>
                <div class="error-message" id="from_date_error">From Date is required</div>
            </div>
            <div class="form-group">
                <label for="to_date" class="required">To Date</label>
                <input type="text" class="form-control datepicker" id="to_date" name="to_date" value="" placeholder="Select to Date" required>
                <div class="error-message" id="to_date_error">To Date is required</div>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="check_ok" name="check_ok" checked>
                <label for="check_ok">Is Prc?</label>
            </div>
            <button type="button" id="searchBtn" class="btn btn-search">
                <i class="fa fa-search" style="margin-right: 5px;"></i>Search
            </button>
        </div>
    </form>
</div>

<!-- Results Section -->
<div class="results-section">
    <h4><i class="fa fa-list" style="margin-right: 8px;"></i>Results</h4>
    <div class="table-responsive">
        <table class="table table-condensed table-bordered" id="example1" style="width:100%">
            <thead style="font-size: 13px">
                <tr style="background: #3f5164;">        
                    <th class="th_width_line">#SL</th>
                    <th class="th_width_line">Invoice Number</th>
                    <th class="th_width_line">Exp Number</th>
                    <th class="th_width_line">Exp Date</th>
                    <th class="th_width_line">Company</th>
                    <th class="th_width_line">Shadow File</th>
                    <th class="th_width_line">PRC Number</th>
                    <th class="th_width_line">PRC Date</th>
                </tr>
            </thead>
            <tbody>
                <!-- DataTable will populate this automatically -->
            </tbody>
        </table>
    </div>
</div>
<script>document.title = 'PRC'</script>
<script>document.title = 'PRC'</script>
<script>
    setTimeout(function() { $('.sr-only').click(); }, 0.0001);
    $(document).ready(function () {
        // Set CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });
        
        // Initialize datepicker
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });
        
        // Initialize DataTable
        var table = $('#example1').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i> Export to Excel',
                    titleAttr: 'Export to Excel',
                    className: 'btn btn-success buttons-excel',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6,7]
                    }
                }
            ],
            columns: [
                { data: 'id' },
                { data: 'invoice_no' },
                { data: 'exp_no'},
                { data: 'exp_date'},
                { data: 'company'},
                { data: 'ci_shadow_file'},
                { data: 'prc_issue_number'},
                { data: 'prc_issue_date'}
            ],
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            language: {
                emptyTable: "No data available. Please search with date range.",
                loadingRecords: "Loading...",
                zeroRecords: "No matching records found",
                search: "Search:",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            order: [[0, 'desc']], // Changed from [[3, 'desc']] to [[0, 'desc']] for ID descending
            responsive: true,
            destroy: true // Add this if you need to reinitialize
        });
        
        // Validation function - updated to check date fields only when checkbox is checked
        function validateForm() {
            var isValid = true;
            var fromDate = $('#from_date').val();
            var toDate = $('#to_date').val();
            var isCheckboxChecked = $('#check_ok').is(':checked');
            
            // Reset error states
            $('.form-control').removeClass('error');
            $('.error-message').hide();
            
            // Only validate dates if checkbox is checked
            if (isCheckboxChecked) {
                // Validate From Date
                if (!fromDate) {
                    $('#from_date').addClass('error');
                    $('#from_date_error').show();
                    isValid = false;
                }
                
                // Validate To Date
                if (!toDate) {
                    $('#to_date').addClass('error');
                    $('#to_date_error').show();
                    isValid = false;
                }
                
                // Parse dates for comparison (DD-MM-YYYY format)
                if (fromDate && toDate) {
                    var fromParts = fromDate.split('-');
                    var toParts = toDate.split('-');
                    
                    var fromDateObj = new Date(fromParts[2], fromParts[1] - 1, fromParts[0]);
                    var toDateObj = new Date(toParts[2], toParts[1] - 1, toParts[0]);
                    
                    if (fromDateObj > toDateObj) {
                        $('#from_date').addClass('error');
                        $('#to_date').addClass('error');
                        alert('From Date cannot be greater than To Date');
                        isValid = false;
                    }
                }
            }
            
            return isValid;
        }
        
        // Search button click handler
        $('#searchBtn').click(function() {
            // Validate form
            if (!validateForm()) {
                return;
            }
            
            // Show loading indicator
            $('.loading').show();
            $(this).prop('disabled', true);
            
            // Get form data
            var formData = {
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
                check_ok: $('#check_ok').is(':checked') ? 1 : 0
            };
            
            // Make AJAX call
            $.ajax({
                url: '{{ url("/prc") }}',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    $('.loading').hide();
                    $('#searchBtn').prop('disabled', false);
                    
                    if(response.success) {
                        var data = response.data || [];
                        
                        // Clear and add new data to DataTable
                        table.clear();
                        
                        if(data.length > 0) {
                            table.rows.add(data).draw();
                            
                            // Show total records
                            $('#totalRecords').show();
                            $('#recordCount').text(data.length);
                        } else {
                            table.draw(); // Draw empty table
                            $('#totalRecords').hide();
                            
                            // Show notification
                            if(typeof toastr !== 'undefined') {
                                toastr.info('No records found for the selected criteria.');
                            } else {
                                alert('No records found for the selected criteria.');
                            }
                        }
                    } else {
                        alert(response.message || 'An error occurred');
                        table.clear().draw();
                        $('#totalRecords').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    console.error('Response:', xhr.responseText);
                    
                    var errorMsg = 'An error occurred while searching. Please try again.';
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    
                    alert(errorMsg);
                    
                    $('.loading').hide();
                    $('#searchBtn').prop('disabled', false);
                    table.clear().draw();
                    $('#totalRecords').hide();
                }
            });
        });
        
        // Trigger search on Enter key
        $('#from_date, #to_date').keypress(function(e) {
            if(e.which == 13) {
                $('#searchBtn').click();
            }
        });
        
        // Remove error class when user changes date
        $('#from_date, #to_date').on('change', function() {
            $(this).removeClass('error');
            $('#' + $(this).attr('id') + '_error').hide();
        });
        
        // For datepicker change event
        $('.datepicker').on('changeDate', function() {
            $(this).removeClass('error');
            $('#' + $(this).attr('id') + '_error').hide();
        });
    });
</script>
@endsection