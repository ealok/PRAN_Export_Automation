@extends('layouts.master')
@section('content')
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: none;
            margin-bottom: 20px;
        }
        .card-header {
            background: linear-gradient(45deg, #3c8dbc, #5faee3);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 7px 20px;
            font-weight: 600;
        }
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 20px;
        }
        .alert {
            border-radius: 5px;
            border: none;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .form-control, .select2-container--default .select2-selection--single {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 8px 12px;
        }
        
        .form-control:focus {
            border-color: #3c8dbc;
            box-shadow: 0 0 0 0.25rem rgba(60, 141, 188, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #3c8dbc, #5faee3);
            border: none;
            border-radius: 5px;
            padding: 8px 20px;
        }
        
        .btn-info {
            background: linear-gradient(45deg, #00c0ef, #2cd6f8);
            border: none;
            border-radius: 5px;
            padding: 8px 20px;
        }
        
        .btn-success {
            background: linear-gradient(45deg, #00a65a, #00ca6d);
            border: none;
            border-radius: 5px;
            padding: 8px 20px;
        }
        
        .btn-danger {
            background: linear-gradient(45deg, #dd4b39, #ff6654);
            border: none;
            border-radius: 5px;
            padding: 8px 20px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .table th {
            background-color: #3c8dbc;
            color: white;
            vertical-align: middle;
        }
        
        .table-responsive {
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(60, 141, 188, 0.1);
        }
        
        .search-box {
            position: relative;
            margin-bottom: 20px;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #6c757d;
        }
        
        .search-box input {
            padding-left: 40px;
            border-radius: 50px;
        }
        
        /* Form layout */
        .inline-form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
        }
        
        .inline-form-group {
            flex: 1;
            min-width: 180px;
        }

        .section-title{
            color: #3c8dbc;
            font-weight: 600; 
            margin-bottom: 20px; 
            padding-bottom: 10px; 
            border-bottom: 2px solid #eaeaea;
            margin-top: -10px;
        }

        .results-section{
            margin-top: -13px;
        }
        
        @media (max-width: 992px) {
            .inline-form-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .inline-form-group {
                min-width: auto;
            }
        }
        
        /* Status badges */
        .status-badge {
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        /* Modal styling */
        .modal-content {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .modal-header {
            background: linear-gradient(45deg, #3c8dbc, #5faee3);
            color: white;
            border-radius: 10px 10px 0 0;
            border: none;
        }
        
        .modal-title {
            font-weight: 600;
        }
        
        .close {
            color: white;
            opacity: 0.8;
        }
        
        .close:hover {
            color: white;
            opacity: 1;
        }
        
        /* Table styling */
        .table-bordered > thead > tr > th {
            border: 1px solid #dee2e6;
        }
        
        .table-bordered > tbody > tr > td {
            border: 1px solid #dee2e6;
            padding: 8px;
            vertical-align: middle;
        }
        
        .table > tbody > tr > td {
            padding: 8px;
            line-height: 1.4;
            vertical-align: middle;
        }
        
        /* Page header */
        .page-header {
            background: linear-gradient(90deg, #3c8dbc, #5faee3);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }
        
        .page-header h1 {
           margin-top: -27px;
           margin-left: 50px;
           font-size: 18px;
           text-transform: uppercase;
        }
        
        .header-icon {
            background-color: rgba(255, 255, 255, 0.2);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 18px;
        }
        .inline-form-group {
            display: flex;
            align-items: center;
            margin-bottom: 3px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid #ddd9d963;
        }
        .inline-form-group label {
            white-space: nowrap;
            margin-right: 10px; /* Optional: Adjust spacing between label and input */
        }
        h1{
            margin-top: -26px;
            margin-left: 50px;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .btn-default {
          background-color: #fff;
        }
        .dataTables_length {
            display: none;
        }
        .invoice-input-wrapper input {
            padding-left: 40px;
            border: 1px solid;
        }
        .table > thead > tr > th {
          border: 1px solid #fff !important;
        }
        .table > tbody > tr > td {
            padding: 1px;
            line-height: 1.4;
            vertical-align: middle;
            font-size: 12px;
            font-weight: bold;
        }
        table.dataTable.no-footer {
          border-bottom: #c6c6c6;
        }
        table.dataTable thead th{
            padding: 4px 18px;
        }
        .table-bordered {
          border: none;
        }
        .table-responsive {
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-top: -13px;
        }
        .form-control{
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 4px 12px;
        }
        .btn {
            padding: 0px 8px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            touch-action: manipulation;
            cursor: pointer;
            user-select: none;
            border: 1px solid #ddd !important;
            transition: all 0.2s ease-in-out; /* smooth hover effect */
        }
        .custom-modal {
            border-radius: 8px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.3);
        }

        .custom-header {
            background: #367FA9;
            color: #fff;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        #search_btn{
            padding: 7px 7px;
            background: #5a9b0b;
        }

        /* .custom-footer {
            background: #367FA9;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 6px;
        } */
        .modal-footer {
            padding: 6px;
            text-align: right;
            border-top: 1px solid #e5e5e5;
        }  
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #aaa;
            border-radius: 3px;
            padding: 0px;
            background-color: transparent;
            margin-left: 3px;
            width: 130px;
        }  
        #itemTable thead th {
            padding: 0px 18px;
        }
        #itemTable > tbody > tr > td {
            padding: 1px;
            line-height: 1.4;
            vertical-align: middle;
            font-size: 10px;
            font-weight: bold;
        }
        @media (min-width: 992px) {
            .modal-lg {
                min-width: 1245px;
                margin-left: 71px;
            }
        }
        .dropdown-toggle {
            height: 33px;
        }

        /* New styles for invoice search */
        .invoice-search-container {
            display: flex;
            gap: 15px;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        
        .invoice-input-group {
            flex: 1;
            min-width: 300px;
        }
        
        .invoice-search-btn {
            flex-shrink: 0;
        }
        
        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .invoice-input-wrapper {
            position: relative;
        }
        
        .invoice-input-wrapper input {
            padding-left: 40px;
        }
        
        @media (max-width: 768px) {
            .invoice-search-container {
                flex-direction: column;
                align-items: stretch;
            }
            
            .invoice-input-group {
                min-width: auto;
            }
        }

    </style>
</head>
<body>
@if(Session::has('danger'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <strong>Warning!</strong> {{ Session::get('danger') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-md-12"> 
        <!-- JO Receive Form -->
        <div class="card">
            <div class="card-header">
                <div class="header-icon">
                   <i class="fa fa-tasks"></i>
                </div>
                <h1>Sales Contract CI</h1>
            </div>
            <div class="card-body">                
                <div class="form-section" style="background-color: #f9f9f9; padding: 20px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #ddd;">
                    <h5 class="section-title" style="color: #3c8dbc; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #eaeaea;">
                        <i class="fa fa-search me-2">&nbsp;</i>Search Invoice
                    </h5>
                    <div class="invoice-search-container">
                        <div class="col-sm-offset-2 col-sm-6">
                            <div class="invoice-input-group">
                                <label for="invoice_search"></label>
                                <div class="invoice-input-wrapper">
                                    <i class="fa fa-file-invoice search-icon"></i>
                                    <input type="text" class="form-control" id="invoice_search" name="invoice_search" placeholder="Enter invoice number to search...">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="invoice-search-btn">
                                <button type="button" class="btn btn-primary" id="search_btn">
                                    <i class="fa fa-search me-1"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Results Section -->
                <div class="results-section" style="background-color: #fff; padding: 20px; border-radius: 5px; border: 1px solid #ddd;">
                    <h5 class="section-title">
                        <i class="fa fa-list me-2">&nbsp;&nbsp;</i>Sales Contract List
                    </h5>                      
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="example2">
                            <thead>
                                <tr> 
                                    <th>#SL</th>
                                    <th>SC NO</th>
                                    <th>SC DATE</th>
                                    <th>INV NO</th>
                                    <th>Company</th>
                                    <th>Bank</th>
                                    <th>Status</th>
                                    <th>Control</th>
                                </tr> 
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>document.title = 'CI Sales Contract';
$(document).ready(function() {
    setTimeout(function() { $('.sr-only').click(); }, 0.0001);  
    // DataTable initialization
    var table = $("#example2").DataTable({
        paging: true,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false
    });

    // Define all functions first
    const helpers = {
        showLoading: function() {
            $('#search_btn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Searching...');
        },
        hideLoading: function() {
            $('#search_btn').prop('disabled', false).html('<i class="fa fa-search me-1"></i> Search');
        },
        showError: function(message) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                confirmButtonText: 'Ok'
            });
        },
        populateTable: function(data) {
            var dataSet = [];
            
            if (!data || data.length === 0) {
                helpers.showError('No invoice number Found !');
                return;
            }
            
            $.each(data, function(index, item) {
                let statusHtml = '';
                if (item.status === 'Desk Approved') statusHtml = "<span class='badge badge-info'>Desk Approved</span>";
                else if (item.status === 'Com Approved') statusHtml = "<span class='badge badge-success'>Com Approved</span>";
                else if (item.status === 'Not Approved') statusHtml = "<span class='badge badge-danger'>Not Approved</span>";
                
                dataSet.push([
                    index + 1,
                    item.sales_contract_no,
                    item.sales_contract_date,
                    item.invoice_no,
                    item.company,
                    item.bank,
                    statusHtml,
                    "<button class='btn btn-sm btn-primary edit_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' title='Doc Process'><i class='fa fa-file'></i></button> " +
                    "<button class='btn btn-sm btn-info details_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' title='SC Details'><i class='fa fa-eye'></i></button>"
                ]);
            });
            table.clear().rows.add(dataSet).draw();
        },
        getStorageKey: function(invoice_no) {
            return 'scList_invoice_' + invoice_no;
        },
        getLastSearchedInvoice: function() {
            return localStorage.getItem('last_searched_invoice');
        },
        setLastSearchedInvoice: function(invoice_no) {
            localStorage.setItem('last_searched_invoice', invoice_no);
        },
        loadLastSearchedInvoice: function() {
            const lastInvoice = helpers.getLastSearchedInvoice();
            if (lastInvoice) {
                $('#invoice_search').val(lastInvoice);
                helpers.loadSCData(lastInvoice, false);
            }
        },
        loadSCData: function(invoice_no, showLoadingIndicator = true) {
            if (showLoadingIndicator) {
                helpers.showLoading();
            }
            
            let storageKey = helpers.getStorageKey(invoice_no);
            const cachedData = localStorage.getItem(storageKey);
            
            if (cachedData) {
                const results = JSON.parse(cachedData);
                helpers.populateTable(results);
                if (showLoadingIndicator) {
                    helpers.hideLoading();
                }
            } else {
                $.ajax({
                    method: 'GET',
                    url: "/party/sc_list/for_ci",
                    data: { 'invoice_no': invoice_no },
                    success: function(res) {
                        if(res.code === 200) {
                            localStorage.setItem(storageKey, JSON.stringify(res.results));
                            helpers.setLastSearchedInvoice(invoice_no);
                            helpers.populateTable(res.results);
                        } else {
                            helpers.showError('No data found for this invoice number');
                        }
                        if (showLoadingIndicator) {
                            helpers.hideLoading();
                        }
                    },
                    error: function(xhr, status, error) {
                        helpers.showError('Error loading data: ' + error);
                        if (showLoadingIndicator) {
                            helpers.hideLoading();
                        }
                    }
                });
            }
        }
    };

    // Event handlers
    $("#search_btn").click(function() {
        var invoiceNumber = $("#invoice_search").val().trim();
        if(invoiceNumber) {
            helpers.loadSCData(invoiceNumber, true);
        } else {
            helpers.showError('Please enter an invoice number to search');
        }
    });

    $("#invoice_search").keypress(function(e) {
        if(e.which === 13) {
            $("#search_btn").click();
        }
    });

    $(document).on('click', '.details_btn', function(e) {
        e.preventDefault();
        let scid = $(this).data('scid');
        let partyId = $(this).data('party');
        window.location.href = `/sales_contact/details?partyId=${btoa(partyId)}&scid=${btoa(scid)}`;
    });

    $(document).on('click', '.edit_btn', function(e) {
        e.preventDefault();
        let scid = $(this).data('scid');
        window.location.href = `/sci_doc?sc_id=${btoa(scid)}`;
    });

    // Load last searched invoice when page loads
    helpers.loadLastSearchedInvoice();
});
</script>
@endsection