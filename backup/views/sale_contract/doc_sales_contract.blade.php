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
                <h1>Doc Sales Contract</h1>
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
                                        <option value="{{$notify_party->id}}">{{$notify_party->code}}/ {{$notify_party->name}} /{{$notify_party->ref_name}}</option>    
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
<script>document.title = 'Doc Sales Contract';</script>
<script>
    // Track if we're navigating away to create a new SC
    let navigatingToCreate = false;
    let currentPage = 0; // Track current page
    
    $(".preload").hide();
    setTimeout(function() { $('.sr-only').click(); }, 0.0001);  

    // DataTable initialization with proper state saving
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

    // Get approval effect storage key
    function getApprovalEffectKey(party_id) {
        return 'approved_sc_' + party_id;
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

    // Apply approval visual effect to recently approved rows
    function applyApprovalEffect() {

        const party_id = $('#party_id').val();
        if (!party_id) return;
        const approvalKey = getApprovalEffectKey(party_id);
        const approvedSCIds = JSON.parse(localStorage.getItem(approvalKey) || '[]');
        if (approvedSCIds.length > 0) {
            approvedSCIds.forEach(scid => {
                const row = $(`button[data-scid="${scid}"]`).closest('tr');
                if (row.length) {
                    // Add approval effect classes
                    row.addClass('approved-effect');
                    
                    // Update status badge to approved style
                    const statusCell = row.find('td:eq(6)');
                    statusCell.find('.badge').removeClass('badge-info badge-danger').addClass('badge-success status-approved').text('Doc Approved');
                    
                    // Remove from localStorage after applying effect
                    const updatedApprovedIds = approvedSCIds.filter(id => id !== scid);
                    localStorage.setItem(approvalKey, JSON.stringify(updatedApprovedIds));
                    
                    // Remove effect after animation completes
                    setTimeout(() => {
                        row.removeClass('approved-effect');
                    }, 2000);
                }
            });
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
            url: "/party_wise/doc/sc_list",
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
            if (item.status === 'Desk Approved')
                statusHtml = "<span class='badge badge-info'>Desk Approved</span>";
            else if (item.status === 'Doc Approved')
                statusHtml = "<span class='badge badge-success status-approved'>Doc Approved</span>";
            else if (item.status === 'Not Approved')
                statusHtml = "<span class='badge badge-danger'>Not Approved</span>";

            // Determine button states
            const isDocApproved = item.status === 'Doc Approved';
            const isDeskApproved = item.status === 'Desk Approved';

            // Edit button - disabled if already Doc Approved
            const editButton = isDocApproved 
                ? `<button class="btn btn-sm btn-warning" disabled title="Cannot Edit - Already Posted">
                        <i class="fa fa-edit"></i>
                    </button>`
                : `<button class="btn btn-sm btn-warning edit_btn" data-scid="${item.id}" title="Edit SC">
                        <i class="fa fa-edit"></i>
                    </button>`;

            // Approve button - disabled if already Doc Approved
            const approveButton = isDocApproved 
                ? `<button class="btn btn-sm btn-success" disabled title="Already Posted">
                        <i class="fa fa-check"></i>
                    </button>`
                : `<button class="btn btn-sm btn-success approve_btn" data-scid="${item.id}" title="Post SC">
                        <i class="fa fa-check"></i>
                    </button>`;

            // Unpost button - only show if Desk Approved
            const unpostButton = isDeskApproved
                ? `<button class="btn btn-sm btn-danger unpost_btn" data-scid="${item.id}" title="Unpost SC">
                        <i class="fa fa-times"></i>
                    </button>`
                : '';

            let actionButtons = `
                ${editButton}
                <button class="btn btn-sm btn-info details_btn" data-scid="${item.id}" data-party="${item.party_id}" title="SC Details">
                    <i class="fa fa-eye"></i>
                </button>
                ${approveButton}
                ${unpostButton}
            `;
            const bankExport = (item.bank || 'N/A') + ' / ' + (item.export_no || 'N/A');    
            dataSet.push([
                "<div class='text-center'>" + (index + 1) + "</div>",
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
            // Apply approval effects after table is rendered
            setTimeout(applyApprovalEffect, 100);
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

        navigatingToCreate = true;
        var encodedPartyId = btoa(party_id);
        window.location.href = `/quick_sc/create?partyId=${encodedPartyId}`;
    }

    // Edit SC
    function editSC(scid) {
        window.location.href = `/sales_contact/edit_doc?scid=${btoa(scid)}`;
    }

    // View SC Details
    function viewSCDetails(scid, party_id) {
        window.location.href = `/com_inv/details?partyId=${btoa(party_id)}&scid=${btoa(scid)}`;
    }

    // Approve SC - FIXED VERSION with proper page preservation
    function approveSC(scid) {
        // Save current page before operation
        saveCurrentPage();
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to post this Sales Contract?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Post!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $(".preload").show();
                const party_id = $('#party_id').val();
                $.ajax({
                    method: 'GET',
                    url: '/doc/approve/sale_contract',
                    data: { 
                        scid: btoa(scid),
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function(res) {
                        $(".preload").hide();
                        if (res.code === 200) {
                            // Store approved SC ID for visual effect
                            if (party_id) {
                                const approvalKey = getApprovalEffectKey(party_id);
                                const approvedSCIds = JSON.parse(localStorage.getItem(approvalKey) || '[]');
                                approvedSCIds.push(scid);
                                localStorage.setItem(approvalKey, JSON.stringify(approvedSCIds));
                            }
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Approved!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                // Clear cache and reload fresh data from server with page preservation
                                refreshSCData(party_id);
                            });
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

    function unpostedSC(scid) {
        // Save current page before operation
        saveCurrentPage();
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to Unposted this Sales Contract?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Unpost!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $(".preload").show();
                const party_id = $('#party_id').val();
                $.ajax({
                    method: 'GET',
                    url: '/unposted/approve_desk',
                    data: { 
                        scid: btoa(scid),
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function(res) {
                        $(".preload").hide();
                        if (res.code === 200) {
                            // Store approved SC ID for visual effect
                            if (party_id) {
                                const approvalKey = getApprovalEffectKey(party_id);
                                const approvedSCIds = JSON.parse(localStorage.getItem(approvalKey) || '[]');
                                approvedSCIds.push(scid);
                                localStorage.setItem(approvalKey, JSON.stringify(approvedSCIds));
                            }
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Approved!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                // Clear cache and reload fresh data from server with page preservation
                                refreshSCData(party_id);
                            });
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
        $(document).on('click', '.details_btn', function(e) {
            e.preventDefault();
            viewSCDetails($(this).data('scid'), $(this).data('party'));
        });

        $(document).on('click', '.edit_btn', function(e) {
            e.preventDefault();
            editSC($(this).data('scid'));
        });

        $(document).on('click', '.approve_btn', function(e) {
            e.preventDefault();
            approveSC($(this).data('scid'));
        });

        $(document).on('click', '.create-new', function() {
            createNewSalesContract();
        });

        $(document).on('click', '.unpost_btn', function(e) {
            e.preventDefault();
            unpostedSC($(this).data('scid'));
        });

        // Apply approval effects on page load
        setTimeout(applyApprovalEffect, 100);

        // Global error handler for AJAX requests
        $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
            if (jqxhr.status === 401) {
                Swal.fire('Session Expired!', 'Please login again.', 'error').then(() => {
                    window.location.reload();
                });
            } else if (jqxhr.status === 100) {
                Swal.fire('Server Error!', 'Please try again later.', 'error');
            }
        });
    });
</script>
@endsection