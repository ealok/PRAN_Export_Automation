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
        .add-item-btn{
            background: #007bff;
            color: cornsilk;
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

        .report_btn{
            background: #0056b3;
            color: white;
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

        .modal-header .close {
           margin-top: -18px;
        }

        .custom-header {
            background: #367FA9;
            color: #fff;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        @media (min-width: 992px) {
            .modal-lg {
                width: 1100px;
            }
        }
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
        
        .dropdown-toggle {
            height: 33px;
        }

        /* Add Item Modal Styles */
        #availableItemsTable thead th {
            background-color: #367FA9;
            color: white;
            vertical-align: middle;
            padding: 8px 12px;
        }

        #availableItemsTable tbody td {
            padding: 6px 12px;
            vertical-align: middle;
        }

        .modal-body {
            max-height: 60vh;
            overflow-y: auto;
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

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content custom-modal">
            <div class="modal-header custom-header">
                <h5 class="modal-title" id="addItemModalLabel">
                    <i class="fa fa-cube me-2"></i>&nbsp;Add Items to Job Order
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> 
                            Showing items that are not yet added to the Job Order
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="availableItemsTable">
                        <thead>
                            <tr>
                                <th style="text-align:center">#SL</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>CTN Qty</th>
                                <th>Rate/Pcs</th>
                                <th>Prime Cost</th>
                                <th>GP%</th>
                                <th style="width: 100px">Depot</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="availableItemsBody">
                            <!-- Items will be loaded here dynamically -->
                        </tbody>
                    </table>
                </div>
                <div id="noItemsMessage" class="text-center" style="display: none;">
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i>
                        No items available to add. All items are already in the Job Order.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fa fa-times"></i> Close
                </button>
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
    let currentScId = null;
    let currentJoId = null;
    let currentPartyId = null;
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

            // Status-based logic
            if (item.status === 'Approved') {

                statusHtml = "<span class='badge badge-info'>Approved</span>";
                buttonsHtml = "<button class='btn btn-sm btn-warning create_do_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='Create DO'><i class='fa fa-file'></i></button> " +
                            "<button class='btn btn-sm report_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='Generate Report'><i class='fa fa-print'></i></button>";

            } else if (item.status === 'Not Created') {

                statusHtml = "<span class='badge badge-success'>Not Created</span>";
                // ✅ Show only the Create New button for 'Not Created'
                buttonsHtml = "<button class='btn btn-sm btn-success create-new' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='Create New'><i class='fa fa-plus'></i></button>";

            } else if (item.status === 'Pending') {

                statusHtml = "<span class='badge badge-danger'>Not Approved</span>";
                buttonsHtml = "<button class='btn btn-sm btn-primary edit_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='JO Edit'><i class='fa fa-edit'></i></button> " +
                            "<button class='btn btn-sm btn-dark add-item-btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='Add Item'><i class='fa fa-cube'></i></button> " +
                            "<button class='btn btn-sm btn-danger inactive_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='Inactive JO'><i class='fa fa-ban'></i></button> " +
                            "<button class='btn btn-sm btn-info approve_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='JO Approved'><i class='fa fa-check'></i></button> " +
                            "<button class='btn btn-sm btn-secondary report_btn' data-scid='" + item.id + "' data-party='" + item.party_id + "' data-joid='" + item.jo_id + "' title='Generate Report'><i class='fa fa-print'></i></button>";
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
        restorePage();
    }


    // Function to load available items for the Job Order
    function loadAvailableItems(scid, joid, partyId) {
    $('#availableItemsBody').empty();
    $('#noItemsMessage').hide();

    // Loading state
    $('#availableItemsBody').html(`
        <tr>
            <td colspan="9" class="text-center">
                <i class="fa fa-spinner fa-spin"></i> Loading available items...
            </td>
        </tr>
    `);

    $.ajax({
        method: 'GET',
        url: '/get/available/items/for/jo',
        data: {
            sc_id: scid,
            jo_id: joid,
            party_id: partyId
        },
        success: function (res) {
            $('#availableItemsBody').empty();

            if (res.code === 200 && res.data.length > 0) {
                // Build depot options
                let depotOptions = '<option value="">Select Depot</option>';
                res.depots.forEach(function (depot) {
                    depotOptions += `<option value="${depot.p_code}">${depot.p_code} - ${depot.p_name}</option>`;
                });

                // Build rows
                res.data.forEach(function (item, index) {
                    const row = $(`
                        <tr>
                            <td style="text-align:center">${index + 1}</td>
                            <td>${item.ci_item_code || 'N/A'}</td>
                            <td>${item.ci_item_name || 'N/A'}</td>
                            <td>${item.ctn || 0}</td>
                            <td>${item.rate || '0.00'}</td>
                            <td>${item.prime_cost || '0.00'}</td>
                            <td>${item.gp_percent || '0'}%</td>
                            <td>
                                <select class="form-control depot-select">
                                    ${depotOptions}
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-success verify-btn" data-item-id="${item.id}">
                                    <i class="fa fa-check"></i> Verify
                                </button>
                                <button class="btn btn-sm btn-primary add-btn" data-item-id="${item.id}" disabled>
                                    <i class="fa fa-plus"></i> Add
                                </button>
                            </td>
                        </tr>
                    `);

                    // Append row
                    $('#availableItemsBody').append(row);

                    // If depot already exists in DB, select it
                    if (item.depo_code) {
                        const depotSelect = row.find('.depot-select');
                        depotSelect.val(item.depo_code);

                        // If already verified
                        if (item.status && item.status.toLowerCase() === 'verified') {
                            row.find('.verify-btn')
                               .prop('disabled', true)
                               .removeClass('btn-success')
                               .addClass('btn-secondary')
                               .html('<i class="fa fa-check-circle"></i> Verified');

                            row.find('.add-btn').prop('disabled', false);
                        }
                    }
                });
            } else {
                $('#noItemsMessage').show();
            }
        },
        error: function () {
            $('#availableItemsBody').html(`
                <tr>
                    <td colspan="9" class="text-center text-danger">
                        <i class="fa fa-exclamation-triangle"></i> Error loading items. Please try again.
                    </td>
                </tr>
            `);
        }
    });
}



    $(document).on('click', '.verify-btn', function () {

        let btn = $(this);
        let row = btn.closest('tr');

        // Collect item information from the row
         let itemId   = btn.data('item-id');
        let itemCode = row.find('td:nth-child(2)').text().trim();
        let itemName = row.find('td:nth-child(3)').text().trim();
        let rate     = row.find('td:nth-child(5)').text().trim();
        let primeCost = row.find('td:nth-child(6)').text().trim();
        let depoCode = row.find('.depot-select').val();
        let gpPercent = row.find('td:nth-child(7)').text().trim();
        let status   = row.find('td:nth-child(7)').text().trim();
        let scId     = currentScId; 
        if (!depoCode) {
            Swal.fire('Warning!', 'Please select a Depot before verifying this item.', 'warning');
            return;
        }
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Verifying...');
        const postData = {
            id: scId,
            matching_info: [
                {
                    item_code: itemCode,
                    item_name: itemName,
                    depo_code: depoCode,
                    rate: rate,
                    line_id: itemId,
                    current_status: status
                }
            ],
            _token: '{{ csrf_token() }}'
        };
        $.ajax({
            method: 'POST',
            url: '/quick_order/rate_matching',
            data: postData,
            success: function (response) {

                console.log('Verification response:', response);
                btn.prop('disabled', false).html('<i class="fa fa-check"></i> Verify');
                if (response && response.item_statuses) {

                    const itemStatus = response.item_statuses.find(i => i.item_code === itemCode);
                    if (itemStatus) {
                        row.find('td:nth-child(7)').text(itemStatus.status);
                        row.find('td:nth-child(8)').text(itemStatus.rate_percent + '%');
                    }

                    if (response.overall_status === 'success') {

                        btn.prop('disabled', true)
                            .removeClass('btn-success')
                            .addClass('btn-secondary')
                            .html('<i class="fa fa-check-circle"></i> Verified');

                        row.find('.add-btn').prop('disabled', false);

                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: response.message || "Item verified successfully!"
                        });
                    }

                    else if (response.overall_status === 'needs_approval') {

                        row.find('.depot-select').val(depoCode).prop('disabled', true);
                        let approvalMessage = response.message || 'Item requires higher authority approval!';
                        Swal.fire({
                            icon: "warning",
                            title: "Approval Required",
                            text: approvalMessage,
                            showCancelButton: true,
                            confirmButtonText: "Send Mail",
                            cancelButtonText: "Close",
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: "Are you sure?",
                                    text: "Do you want to send the approval mail?",
                                    icon: "question",
                                    showCancelButton: true,
                                    confirmButtonText: "Yes, Send it",
                                    cancelButtonText: "No, Cancel",
                                    confirmButtonColor: "#28a745",
                                    cancelButtonColor: "#d33",
                                }).then((confirmResult) => {
                                    if (confirmResult.isConfirmed) {
                                        $.ajax({
                                            url: '/send-approval-mail',
                                            type: 'POST',
                                            data: {
                                                id: scId,
                                                approval_type: response.approval_type,
                                                message: approvalMessage,
                                                _token: '{{ csrf_token() }}'
                                            },
                                            success: function () {
                                                Swal.fire("Mail Sent!", "Approval mail has been sent successfully.", "success");
                                            },
                                            error: function () {
                                                Swal.fire("Error!", "Failed to send the mail.", "error");
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                }

                else if (typeof response === 'string' &&
                        (response == "Ed" || response == "Md" || response == "S" || response == "success")) {

                    let status = 'needs_approval';
                    let message = 'Not Verified';

                    if (response === "success") {
                        status = 'verified';
                        message = 'Verified';
                    }

                    row.find('td:nth-child(7)').text(status);
                    row.find('td:nth-child(8)').text('—');
                    row.find('.depot-select').val(depoCode).prop('disabled', true);

                    if (response === "success") {
                        btn.prop('disabled', true)
                            .removeClass('btn-success')
                            .addClass('btn-secondary')
                            .html('<i class="fa fa-check-circle"></i> Verified');
                        row.find('.add-btn').prop('disabled', false);

                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: "Item verified successfully!"
                        });
                    } else {
                        let approvalMessage = 'Item not verified, need approval!';
                        if (response === "Ed") approvalMessage = 'Item not verified, need ED (Export) approval!';
                        else if (response === "Md") approvalMessage = 'Item not verified, need MD (PRAN) approval!';
                        else if (response === "S") approvalMessage = 'Item not verified, need Samia madam approval!';

                        Swal.fire({ icon: "warning", title: "Approval Required", text: approvalMessage });
                    }
                }

                else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Unexpected response from server!"
                    });
                }
            },
            error: function (err) {
                console.log('AJAX Error:', err);
                btn.prop('disabled', false).html('<i class="fa fa-check"></i> Verify');
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to verify item. Please try again."
                });
            }
        });
    });

    $(document).on('click', '.add-btn', function () {

        let btn = $(this);
        let row = btn.closest('tr');
        let itemId   = btn.data('item-id');
        let scId     = currentScId;
        let joId     = currentJoId;

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
        $.ajax({
            url: '/job_order/add_item',
            type: 'POST',
            data: {
                sc_id: scId,
                jo_id: joId,
                item_id: itemId,
                _token: '{{ csrf_token() }}'
            },
            success: function (res) {

                if(res.code === 200) {

                    Swal.fire('Success!', res.message, 'success');
                    // Lock row UI
                    row.find('.add-btn')
                        .prop('disabled', true)
                        .removeClass('btn-primary')
                        .addClass('btn-secondary')
                        .html('<i class="fa fa-check-circle"></i> Added');
                    
                    $('#addItemModal').modal('show');    

                }

                // Already exists
                else if (res.code === 409) {

                    Swal.fire('Warning!', res.message, 'warning');
                    btn.prop('disabled', false).html('<i class="fa fa-plus"></i> Add');
                }

                // Server error
                else {

                    Swal.fire('Error!', 'Unexpected response from server.', 'error');
                    btn.prop('disabled', false).html('<i class="fa fa-plus"></i> Add');
                }
            },
            error: function (err) {
                console.error(err);
                Swal.fire('Error!', 'Something went wrong while saving the item.', 'error');
                btn.prop('disabled', false).html('<i class="fa fa-plus"></i> Add');
            }
        });

    });
 
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
                    url: '/quick/jo_order/approve',
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
        window.location.href = `/create_new/jo?partyId=${btoa(party_id)}&scid=${btoa(scid)}&joid=${btoa(joid)}`;
    }

    function editJobOrder(joid, party_id) {
        navigatingToCreate = true; // CRITICAL: Set flag before navigation
        dataLoaded = false; // Reset loaded flag when navigating away
        window.location.href = `/edit_jo?partyId=${btoa(party_id)}&joid=${btoa(joid)}`;
    }

    function createDOBtn(joid, party_id){
        navigatingToCreate = true; // CRITICAL: Set flag before navigation
        dataLoaded = false; // Reset loaded flag when navigating away
        window.location.href = `/quick/create_do?partyId=${btoa(party_id)}&joid=${btoa(joid)}`;
    }

    function printReport(joid, party_id){
        navigatingToCreate = true; 
        dataLoaded = false;
        window.open(`/job_report/view?joid=${btoa(joid)}`, '_blank'); 
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

        //@@@@--Handle Report Print Button---
        $(document).on('click', '.report_btn', function(e) {

            e.preventDefault();
            let partyId = $(this).data('party');
            let joid = $(this).data('joid');
            // Check if JO exists
            if (!joid || joid === 'null' || joid === 'undefined') {
                Swal.fire('Warning!', 'Please create a Job Order first before creating DO.', 'warning');
                return;
            }
            printReport(joid, partyId);

        });

        //@@@@--Handle Add Item Button---
        $(document).on('click', '.add-item-btn', function(e) {
            e.preventDefault();
            currentScId = $(this).data('scid');
            currentJoId = $(this).data('joid');
            currentPartyId = $(this).data('party');
            
            // Check if JO exists
            if (!currentJoId || currentJoId === 'null' || currentJoId === 'undefined') {
                Swal.fire('Warning!', 'Please create a Job Order first before adding items.', 'warning');
                return;
            }
            
            // Load available items and show modal
            loadAvailableItems(currentScId, currentJoId, currentPartyId);
            $('#addItemModal').modal('show');
        });

    });
</script>
@endsection