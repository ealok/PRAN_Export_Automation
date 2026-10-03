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
            height: 40px;
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
            height: 31px;
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

    </style>
</head>
<body>
<div class="row">
    <div class="col-md-12"> 
        <!-- JO Receive Form -->
        <div class="card">
            <div class="card-header">
                <div class="header-icon">
                   <i class="fa fa-tasks"></i>
                </div>
                <h1>Sales Contract</h1>
            </div>
            <div class="card-body">                
                <form class="" role="form" method="POST" action="{{url('/notify_party/upload') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <!-- Form Input Section -->
                    <div class="form-section" style="background-color: #f9f9f9; padding: 20px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #ddd;">
                        <h5 class="section-title" style="color: #3c8dbc; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #eaeaea;">
                            <i class="fa fa-info-circle me-2">&nbsp;</i>Filter Options
                        </h5>
                        <div class="row">
                            <div class="col-sm-offset-3 col-sm-4">
                                <div class="inline-form-group">
                                    <label for="party_id">Party:</label>
                                    <select name="party_id" id="party_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1">
                                        <option value="">Select</option>
                                        @foreach ($notify_parties as $notify_party)
                                        <option value="{{$notify_party->id}}">{{$notify_party->code}}/ {{$notify_party->name}} / {{$notify_party->ref_name}}</option>    
                                        @endforeach
                                    </select>
                                    @if ($errors->has('party_id'))
                                        <span class="help-block"><strong>{{ $errors->first('party_id') }}</strong></span>
                                    @endif  
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Results Section -->
                    <div class="results-section" style="background-color: #fff; padding: 20px; border-radius: 5px; border: 1px solid #ddd;">
                        <h5 class="section-title">
                            <i class="fa fa-list me-2">&nbsp;&nbsp;</i>Sales Contract List <input type="button" class="btn btn-sm btn-success pull-right create-new" value="+Create New">
                        </h5>                      
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="example2">
                                <thead>
                                    <tr> 
                                        <th>#SL</th>
                                        <th>SC NO</th>
                                        <th>SC DATE</th>
                                        <th>INV NO</th>
                                        <th>Exporter</th>
                                        <th>Bank/Exp</th>
                                        <th>Status</th>
                                        <th>Control</th>
                                    </tr> 
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>document.title = 'Desk Sales Contract';</script>
<script>
    // Track if we're navigating away to create a new SC
    let navigatingToCreate = false;
    let currentPage = 0; // Track current page
    $(".preload").hide();
    setTimeout(function() { $('.sr-only').click(); }, 0.0001);  
    
    // Clear any existing localStorage on page load
    // window.onload = function() {
    //     localStorage.clear(); 
    // };

    // DataTable initialization
    var table = $("#example2").DataTable({
        paging: true,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false,
        language: {
            emptyTable: "No sales contracts found for the selected party"
        },
        stateSave: true, // Enable state saving
        stateDuration: -1 // Retain state indefinitely
    });

    // Get Local Storage key for a party
    function getStorageKey(party_id){
        return 'scList_party_' + party_id;
    }

    // Save current page state
    function saveCurrentPage() {
        currentPage = table.page();
    }

    // Restore to saved page
    function restorePage() {
        if (currentPage !== null) {
            table.page(currentPage).draw('page');
        }
    }

    // Load SC data from server (primary source)
    function loadSCData(party_id) {
        if (!party_id) {
            table.clear().draw();
            return;
        }

        $(".preload").show();
        
        $.ajax({
            method: 'GET',
            url: "/party/sc_list",
            data: { 'party_id': party_id },
            success: function(res) {
                $(".preload").hide();
                if(res.code === 200) {
                    // Update localStorage as cache
                    let storageKey = getStorageKey(party_id);
                    localStorage.setItem(storageKey, JSON.stringify(res.results));
                    populateTable(res.results);
                } else {
                    Swal.fire('Error!', 'Failed to load sales contracts', 'error');
                    table.clear().draw();
                }
            },
            error: function(xhr, status, error) {
                $(".preload").hide();
                console.error('Error loading SC data:', error);
                
                // Fallback to localStorage if available
                let storageKey = getStorageKey(party_id);
                let cachedData = localStorage.getItem(storageKey);
                if (cachedData) {
                    populateTable(JSON.parse(cachedData));
                    Swal.fire('Info', 'Showing cached data. Please refresh for latest updates.', 'info');
                } else {
                    Swal.fire('Error!', 'Failed to load sales contracts', 'error');
                    table.clear().draw();
                }
            }
        });
    }

    // Populate DataTable with fresh data
    function populateTable(data) {

        var dataSet = [];
        if (data.length === 0) {
            table.clear().draw();
            return;
        }

        $.each(data, function(index, item) {

            let statusHtml = '';
            if (item.status === 'Desk Approved') {
                statusHtml = "<span class='badge badge-info'>Desk Approved</span>";
            } else if (item.status === 'Not Approved') {
                statusHtml = "<span class='badge badge-danger'>Not Approved</span>";
            } else {
                statusHtml = "<span class='badge badge-warning'>" + (item.status || 'Pending') + "</span>";
            }

            let actionButtons = "";
            
            // If status is "Desk Approved" - show only duplicate and details
            if (item.status === 'Desk Approved') {
                actionButtons += "<button class='btn btn-sm btn-primary edit_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' title='SC Edit'><i class='fa fa-edit'></i></button> ";
                actionButtons += "<button class='btn btn-sm btn-warning duplicate_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' title='SC Duplicate'><i class='fa fa-copy'></i></button> ";
                actionButtons += "<button class='btn btn-sm btn-info details_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' title='SC Details'><i class='fa fa-eye'></i></button>";
            } 
            // For all other statuses (Not Approved, Pending, etc.) - show all buttons
            else {
                actionButtons += "<button class='btn btn-sm btn-primary edit_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' title='SC Edit'><i class='fa fa-edit'></i></button> ";
                actionButtons += "<button class='btn btn-sm btn-warning duplicate_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' title='SC Duplicate'><i class='fa fa-copy'></i></button> ";
                actionButtons += "<button class='btn btn-sm btn-danger inactive_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' title='SC Inactive'><i class='fa fa-ban'></i></button>";
                actionButtons += "<button class='btn btn-sm btn-info details_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' title='SC Details'><i class='fa fa-eye'></i></button>";
                actionButtons += "<button class='btn btn-sm btn-success approve_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' title='SC Post'><i class='fa fa-check'></i></button>";
            }
            // if Sales Contract number exists, show Order Process button
            if(item.sales_contract_no) {
                actionButtons += "<button class='btn btn-sm btn-primary order_process_btn' " +
                    "data-scid='" + item.encrypted_id + "' " +
                    "data-party='" + item.encrypted_party_id + "' " +
                    "title='Create JO'>" +
                    "<i class='fa fa-clipboard'></i></button>";
            }
            const bankExport = (item.bank || 'N/A') + ' / ' + (item.export_no || 'N/A');    
            dataSet.push([
                "<div class='text-center'>" + (index + 1) + "</div>", // Centered index number
                item.sales_contract_no || 'N/A',
                item.sales_contract_date || 'N/A',
                item.invoice_no || 'N/A',
                item.company || 'N/A',
                bankExport,
                statusHtml,
                actionButtons
            ]);
        });

        // Save current page before updating data
        saveCurrentPage();
        
        table.clear().rows.add(dataSet).draw();
        
        // Restore to the previous page after data is loaded
        setTimeout(() => {
            restorePage();
        }, 100);
    }

    // Refresh SC data (clear cache and reload from server) with page preservation
    function refreshSCData(party_id) {
        if (party_id) {
            // Save current page before refresh
            saveCurrentPage();
            
            let storageKey = getStorageKey(party_id);
            localStorage.removeItem(storageKey);
            loadSCData(party_id);
        }
    }

    // Duplicate SC with page preservation
    function duplicateSC(scid, party_id) {
        // Save current page before operation
        saveCurrentPage();
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to duplicate this Sales Contract?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Duplicate!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $(".preload").show();
                $.ajax({
                    method: 'GET',
                    url: "/duplicate/sc",
                    data: { 'scid': scid },
                    success: function(res) {
                        $(".preload").hide();
                        if (res.code == 200) {
                            Swal.fire('Success!', res.msg, 'success');
                            refreshSCData(party_id);
                        } else {
                            Swal.fire('Error!', res.msg || 'Something went wrong!', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        $(".preload").hide();
                        Swal.fire('Error!', 'Duplication failed: ' + error, 'error');
                    }
                });
            }
        });
    }

    // Inactive SC with page preservation
    function inactiveSC(scid, party_id) {
        
        saveCurrentPage(); // Save current page before operation
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to mark this Sales Contract as inactive?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Inactive!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $(".preload").show();
                $.ajax({
                    method: 'GET',
                    url: '/sc/inactive',
                    data: { 
                        'scid': scid, 
                        'party_id': party_id, 
                        '_token': '{{ csrf_token() }}' 
                    },
                    success: function(res) {

                        $(".preload").hide();
                        if (res.code == 200) {
                            Swal.fire('Success!', res.msg, 'success');
                            refreshSCData(party_id);
                        } else {
                            Swal.fire('Error!', res.msg || 'Something went wrong!', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        $(".preload").hide();
                        Swal.fire('Error!', 'Inactive operation failed: ' + error, 'error');
                    }
                });
            }
        });
    }

    // Approve SC - FIXED VERSION with page preservation
    function approveSC(scid, party_id) {
        // Save current page before operation
        saveCurrentPage();
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to Post this Sales Contract?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Post!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $(".preload").show();
                $.ajax({
                    method: 'GET',
                    url: '/approve/sale_contract',
                    data: { 
                        scid: btoa(scid), 
                        party_id: party_id, 
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function(res) {
                        $(".preload").hide();
                        if (res.code === 200) {
                            Swal.fire('Approved!', res.message, 'success');
                            // Clear cache and reload fresh data from server
                            refreshSCData(party_id);
                        } else {
                            Swal.fire('Error!', res.message || 'Posted failed!', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        $(".preload").hide();
                        Swal.fire('Error!', 'Posted failed: ' + error, 'error');
                    }
                });
            }
        });
    }

    // Create New SC
    function createNewSalesContract() {
        var party_id = $('#party_id').val();
        if(!party_id) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'Please select a party first',
                confirmButtonText: 'Ok'
            });
            return;
        }

        // Set flag indicating we're navigating to create page
        navigatingToCreate = true;
        var encodedPartyId = btoa(party_id);
        window.location.href = `/quick_sc/create?partyId=${encodedPartyId}`;
    }

    // View SC Details
    function viewSCDetails(scid, party_id) {
        window.location.href = `/sales_contact/details?partyId=${btoa(party_id)}&scid=${btoa(scid)}`;
    }

    // Edit SC
    function editSC(scid, party_id) {
        window.location.href = `/sales_contact/edit?partyId=${btoa(party_id)}&scid=${btoa(scid)}`;
    }

    function orderProcess(sale_contact_id, party_id) {
       window.location.href = `/jo/create/${sale_contact_id}/${party_id}`;
    }
    // Page Visibility API implementation
    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible') {
            if (navigatingToCreate) {
                const party_id = $('#party_id').val();
                if (party_id) {
                    refreshSCData(party_id);
                }
                navigatingToCreate = false;
            }
        }
    });

    // Event Bindings
    $(document).ready(function() {
        // Initialize with any previously selected party
        let selectedPartyId = localStorage.getItem('selected_party_id');
        if (selectedPartyId) {
            $('#party_id').val(selectedPartyId).trigger('change');
            // Small delay to ensure select2 is initialized
            setTimeout(() => {
                loadSCData(selectedPartyId);
            }, 100);
        }

        // Party ID change event
        $("#party_id").change(function() {
            var party_id = $(this).val(); 
            if(party_id){
                localStorage.setItem('selected_party_id', party_id);
                loadSCData(party_id);
            } else {
                table.clear().draw();
            }
        });

        // Event listeners for various actions
        $(document).on('click', '.duplicate_btn', function(e) {
            e.preventDefault();
            duplicateSC($(this).data('scid'), $(this).data('party'));
        });

        $(document).on('click', '.inactive_btn', function(e) {
            e.preventDefault();
            inactiveSC($(this).data('scid'), $(this).data('party'));
        });

        $(document).on('click', '.approve_btn', function(e) {
            e.preventDefault();
            approveSC($(this).data('scid'), $(this).data('party'));
        });

        $(document).on('click', '.details_btn', function(e) {
            e.preventDefault();
            viewSCDetails($(this).data('scid'), $(this).data('party'));
        });

        $(document).on('click', '.edit_btn', function(e) {
            e.preventDefault();
            editSC($(this).data('scid'), $(this).data('party'));
        });

        $(document).on('click', '.create-new', function(e) {
            e.preventDefault();
            createNewSalesContract();
        });

        $(document).on('click', '.order_process_btn', function (e) {
            e.preventDefault();
            orderProcess($(this).data('scid'), $(this).data('party'));
            
        });

        // Refresh button (optional - you can add this to your HTML)
        $(document).on('click', '.refresh-btn', function(e) {
            e.preventDefault();
            const party_id = $('#party_id').val();
            if (party_id) {
                refreshSCData(party_id);
                Swal.fire('Refreshed!', 'Data refreshed successfully', 'success');
            } else {
                Swal.fire('Warning!', 'Please select a party first', 'warning');
            }
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function(event) {
            const party_id = $('#party_id').val();
            if (party_id) {
                refreshSCData(party_id);
            }
        });
    });

    // Global error handler for AJAX requests
    $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
        if (jqxhr.status === 401) {
            Swal.fire('Session Expired!', 'Please login again.', 'error').then(() => {
                window.location.reload();
            });
        } else if (jqxhr.status === 500) {
            Swal.fire('Server Error!', 'Please try again later.', 'error');
        }
    });
</script>
@endsection