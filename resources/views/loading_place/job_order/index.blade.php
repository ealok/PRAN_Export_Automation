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
        .sl-number {
            text-align: center;
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
                <h1>JO Create</h1>
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="example2">
                                <thead>
                                    <tr> 
                                        <th style="text-align: center">#SL</th>
                                        <th>SC NO</th>
                                        <th>INV NO</th>
                                        <th>JO Number</th>
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
<script>document.title = 'JO Create';</script>
<script>
    // Track if we're navigating away to create a new SC
    let navigatingToCreate = false;
    let currentPage = 0; // Track current page
    let dataLoaded = false; // Track if data is already loaded
    $(".preload").hide();
    setTimeout(function() { $('.sr-only').click(); }, 0.0001);  

    // DataTable initialization with state saving
    var table = $("#example2").DataTable({
        paging: true,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false,
        stateSave: false, // Disable DataTable state save as we handle it manually
    });

    // Get Local Storage key for a party
    function getStorageKey(party_id){
        return 'scList_party_' + party_id;
    }

    // Save current page state
    function saveCurrentPage() {
        currentPage = table.page();
        console.log('Current page saved:', currentPage);
    }

    // Restore to saved page
    function restorePage() {
        if (currentPage !== null && currentPage !== undefined && currentPage >= 0) {
            console.log('Restoring to page:', currentPage);
            setTimeout(() => {
                table.page(currentPage).draw('page');
            }, 50);
        }
    }

    // Load SC data (Local Storage first, fallback AJAX)
    function loadSCData(party_id, forceReload = false) {
        if(!party_id) return;
        
        // Don't reload if data is already loaded and not forced
        if (dataLoaded && !forceReload) {
            console.log('Data already loaded, skipping reload');
            return;
        }
        
        // Save current page before loading new data
        saveCurrentPage();
        
        let storageKey = getStorageKey(party_id);
        $.ajax({
            method: 'GET',
            url: "/party_wise/sc_jo/list",
            data: { 'party_id': party_id },
            success: function(res) {
                if(res.code === 200) {
                    localStorage.setItem(storageKey, JSON.stringify(res.results));
                    populateTable(res.results);
                    dataLoaded = true; // Mark data as loaded
                }
            },
            error: function() {
                $(".preload").hide();
                dataLoaded = true; // Mark as loaded even on error to prevent retries
            }
        });
    }

    // Populate DataTable
    function populateTable(data) {
        var dataSet = [];
        $.each(data, function(index, item) {
            let statusHtml = '';
            let buttonsHtml = '';
            
            if (item.status === 'Approved') {
                statusHtml = "<span class='badge badge-info'>Approved</span>";
                // Only show create_do_btn for Approved status
                buttonsHtml = "<button class='btn btn-sm btn-warning create_do_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='Create DO'><i class='fa fa-file'></i></button>";
            } 
            else if (item.status === 'Not Created') {
                statusHtml = "<span class='badge badge-success'>Not Created</span>";
                // Show all buttons except create_do_btn for Not Created status
                buttonsHtml = "<button class='btn btn-sm btn-success create-new' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='Create New'><i class='fa fa-plus'></i></button> " +
                            "<button class='btn btn-sm btn-primary edit_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='JO Edit'><i class='fa fa-edit'></i></button> " +
                            "<button class='btn btn-sm btn-danger inactive_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='Inactive JO'><i class='fa fa-ban'></i></button>" +
                            "<button class='btn btn-sm btn-info approve_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='JO Approved'><i class='fa fa-check'></i></button>";
            } 
            else if (item.status === 'Pending') {
                statusHtml = "<span class='badge badge-danger'>Not Approved</span>";
                // Show all buttons except create_do_btn for Pending status
                buttonsHtml = "<button class='btn btn-sm btn-success create-new' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='Create New'><i class='fa fa-plus'></i></button> " +
                            "<button class='btn btn-sm btn-primary edit_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='JO Edit'><i class='fa fa-edit'></i></button> " +
                            "<button class='btn btn-sm btn-danger inactive_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='Inactive JO'><i class='fa fa-ban'></i></button>" +
                            "<button class='btn btn-sm btn-info approve_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='JO Approved'><i class='fa fa-check'></i></button>";
            }

            dataSet.push([
                "<div class='sl-number'>" + (index + 1) + "</div>",
                item.sales_contract_no,
                item.invoice_no,
                item.jo_number,
                statusHtml,
                buttonsHtml
            ]);
        });
        
        table.clear().rows.add(dataSet).draw();
        
        // Restore to the previous page after data is loaded
        restorePage();
    }

    // Add new SC to Local Storage & Table
    function addNewSCToStorage(newSC, party_id) {
        let storageKey = getStorageKey(party_id);
        let scList = JSON.parse(localStorage.getItem(storageKey) || '[]');
        scList.push(newSC);
        localStorage.setItem(storageKey, JSON.stringify(scList));
        populateTable(scList);
    }

    // Inactive SC with page preservation
    function inactiveJO(joId) {
        // Save current page before operation
        saveCurrentPage();
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to mark this JO inactive?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Inactive!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'GET',
                    url: '/cancel/job_order',
                    data: {'joId': joId},
                    success: function(res) {
                        if (res.code == 200) {
                            Swal.fire('Success!', res.msg, 'success');
                            // Reload data for current party with force reload
                            const party_id = $('#party_id').val();
                            dataLoaded = false; // Reset loaded flag
                            loadSCData(party_id, true);
                        } else {
                            Swal.fire('Error!', res.msg || 'Something went wrong!', 'error');
                        }
                    }
                });
            }
        });
    }

    // Approve JO with page preservation
    function approveJO(joId) {
        // Save current page before operation
        saveCurrentPage();
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to approve this Job Order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Approved!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'GET',
                    url: '/approve/job_order',
                    data: {'joId': joId},
                    success: function(res) {
                        if (res.code == 200) {
                            Swal.fire('Success!', res.msg, 'success');
                            // Reload data for current party with force reload
                            const party_id = $('#party_id').val();
                            dataLoaded = false; // Reset loaded flag
                            loadSCData(party_id, true);
                        } else {
                            Swal.fire('Error!', res.msg || 'Something went wrong!', 'error');
                        }
                    }
                });
            }
        });
    }

    // Navigation functions - SET THE FLAG when navigating away
    function createNewSalesContract(scid, party_id, joid) {
        navigatingToCreate = true; // CRITICAL: Set flag before navigation
        dataLoaded = false; // Reset loaded flag when navigating away
        window.location.href = `/creae_new/jo?partyId=${btoa(party_id)}&scid=${btoa(scid)}&joid=${btoa(joid)}`;
    }

    function editJobOrder(joid, party_id) {
        navigatingToCreate = true; // CRITICAL: Set flag before navigation
        dataLoaded = false; // Reset loaded flag when navigating away
        window.location.href = `/edit_jo?partyId=${btoa(party_id)}&joid=${btoa(joid)}`;
    }

    function createDOBtn(joid, party_id){
        navigatingToCreate = true; // CRITICAL: Set flag before navigation
        dataLoaded = false; // Reset loaded flag when navigating away
        window.location.href = `/create_do?partyId=${btoa(party_id)}&joid=${btoa(joid)}`;
    }

    // Improved Page Visibility API implementation
    let visibilityTimeout;
    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible') {
            // Clear any existing timeout
            if (visibilityTimeout) {
                clearTimeout(visibilityTimeout);
            }
            
            // Only refresh if we were navigating to create AND data is not already loaded
            if (navigatingToCreate && !dataLoaded) {
                console.log('Page visible after navigation - refreshing data');
                visibilityTimeout = setTimeout(() => {
                    const party_id = $('#party_id').val();
                    if (party_id) {
                        loadSCData(party_id, true);
                    }
                    navigatingToCreate = false;
                }, 500); // Small delay to ensure page is fully loaded
            } else {
                console.log('Page visible but no refresh needed - data already loaded or not from navigation');
                navigatingToCreate = false;
            }
        }
    });

    // Remove the pageshow event listener as it's causing duplicate loads
    // $(window).on('pageshow', function() { ... });

    // Event Bindings
    $(document).ready(function() {
        let selectedPartyId = localStorage.getItem('selected_party_id');
        if (selectedPartyId) {
            $('#party_id').val(selectedPartyId).trigger('change');
            // Initial load
            loadSCData(selectedPartyId);
        }

        // Party ID change event
        $("#party_id").change(function() {
           var party_id = $(this).val(); 
           if(party_id){
                localStorage.setItem('selected_party_id', party_id);
                dataLoaded = false; // Reset when party changes
                loadSCData(party_id, true);
            }
        });

        //@@@@--Handle Create New JO Button---
        $(document).on('click', '.create-new', function(e) {
            e.preventDefault();
            let scid = $(this).data('scid');
            let joid = $(this).data('joid');
            let partyId = $(this).data('party');
            createNewSalesContract(scid, partyId, joid);
        });

        //@@@@--Handle Edit JO Button---
        $(document).on('click', '.edit_btn', function(e) {
            e.preventDefault();
            let scid = $(this).data('scid');
            let partyId = $(this).data('party');
            let joid = $(this).data('joid');
            
            // Check if JO exists
            if (!joid || joid === 'null' || joid === 'undefined') {
                Swal.fire('Warning!', 'Please create a Job Order first before editing.', 'warning');
                return;
            }
            
            editJobOrder(joid, partyId);
        });

        //@@@@--Handle Inactive JO Button---
        $(document).on('click', '.inactive_btn', function(e) {
            e.preventDefault();
            let joid = $(this).data('joid');
            
            // Check if JO exists
            if (!joid || joid === 'null' || joid === 'undefined') {
                Swal.fire('Warning!', 'No Job Order found to inactive. Please create a Job Order first.', 'warning');
                return;
            }
            
            inactiveJO(joid);
        });

        //@@@@--Handle JO Approve Button---
        $(document).on('click', '.approve_btn', function(e) {
            e.preventDefault();
            let joid = $(this).data('joid');
            
            // Check if JO exists
            if (!joid || joid === 'null' || joid === 'undefined') {
                Swal.fire('Warning!', 'No Job Order found to approve. Please create a Job Order first.', 'warning');
                return;
            }
            
            approveJO(joid);
        });

        //@@@@--Handle DO Button---
        $(document).on('click', '.create_do_btn', function(e) {
            e.preventDefault();
            let partyId = $(this).data('party');
            let joid = $(this).data('joid');
            
            // Check if JO exists
            if (!joid || joid === 'null' || joid === 'undefined') {
                Swal.fire('Warning!', 'Please create a Job Order first before creating DO.', 'warning');
                return;
            }
            
            createDOBtn(joid, partyId);
        });

    });
</script>
@endsection