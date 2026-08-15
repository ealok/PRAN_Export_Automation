@extends('layouts.master')
@section('content') 
<style>
    /* ===== MODERN DESIGN SYSTEM ===== */
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --primary-light: #818cf8;
        --success: #10b981;
        --success-dark: #059669;
        --danger: #ef4444;
        --danger-dark: #dc2626;
        --warning: #f59e0b;
        --info: #0ea5e9;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.04);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.08), 0 4px 6px rgba(0,0,0,0.04);
        --radius: 8px;
        --radius-lg: 12px;
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body { background: #f1f5f9; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }

    /* ============================================================ */
    /* ===== BOX ===== */
    /* ============================================================ */
    .box {
        position: relative;
        border-radius: var(--radius-lg);
        background: #ffffff;
        border-top: 4px solid var(--primary);
        margin-bottom: 20px;
        width: 100%;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }

    .box.box-primary { border-top-color: var(--primary); }

    /* ============================================================ */
    /* ===== TOP BAR: CARDS + CREATE BUTTON ===== */
    /* ============================================================ */
    .top-bar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        padding: 12px 18px 10px 18px;
        background: white;
        border-bottom: 1px solid var(--gray-200);
        gap: 12px;
    }

    .top-bar .summary-cards {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        flex: 1;
    }

    .top-bar .action-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    /* ============================================================ */
    /* ===== SUMMARY CARDS - SMALL & COMPACT ===== */
    /* ============================================================ */
    .summary-card {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: var(--radius);
        background: white;
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow);
        cursor: pointer;
        transition: var(--transition);
        min-width: 100px;
    }

    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .summary-card.active {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.15), var(--shadow-md);
    }

    .summary-card .card-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
    }

    .summary-card .card-icon.total { background: #e0e7ff; color: var(--primary); }
    .summary-card .card-icon.active { background: #d1fae5; color: var(--success); }
    .summary-card .card-icon.inactive { background: #fee2e2; color: var(--danger); }

    .summary-card .card-info {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .summary-card .card-number {
        font-size: 16px;
        font-weight: 700;
        color: var(--gray-900);
    }

    .summary-card .card-label {
        font-size: 9px;
        font-weight: 500;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .summary-card.card-total { border-left: 3px solid var(--primary); }
    .summary-card.card-active { border-left: 3px solid var(--success); }
    .summary-card.card-inactive { border-left: 3px solid var(--danger); }

    /* ============================================================ */
    /* ===== BUTTONS ===== */
    /* ============================================================ */
    .btn {
        padding: 4px 14px;
        font-size: 11px;
        font-weight: 500;
        border-radius: var(--radius);
        border: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        line-height: 1.5;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        height: 28px;
    }

    .btn i { font-size: 12px; }

    .btn-success {
        background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }
    .btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(79, 70, 229, 0.3);
    }

    .btn-danger {
        background: linear-gradient(135deg, var(--danger) 0%, var(--danger-dark) 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
    }
    .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
    }

    .btn-warning {
        background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(245, 158, 11, 0.2);
    }
    .btn-warning:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);
    }

    .btn-sm {
        padding: 3px 10px;
        font-size: 10px;
        height: 26px;
    }

    /* ============================================================ */
    /* ===== TABLE - PROFESSIONAL & COMPACT ===== */
    /* ============================================================ */
    .panel-body {
        padding: 10px 14px;
        background: white;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px !important;
        border-radius: var(--radius);
        overflow: hidden;
        min-width: 1000px;
    }

    .table thead th {
        background: var(--gray-900);
        color: white;
        font-weight: 600;
        font-size: 9px !important;
        padding: 5px 5px !important;
        text-align: center;
        border: 1px solid var(--gray-700);
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table tbody td {
        padding: 3px 4px !important;
        border-bottom: 1px solid var(--gray-200);
        color: var(--gray-700);
        vertical-align: middle;
        text-align: center;
        font-size: 10px !important;
        transition: var(--transition);
        height: 26px;
    }

    .table tbody tr:hover td { background: var(--gray-50); }
    .table tbody tr:nth-child(even) td { background: #fafafa; }
    .table tbody tr:nth-child(odd) td { background: #ffffff; }
    .table tbody tr:last-child td { border-bottom: none; }

    /* ===== ROW STATUS ===== */
    .row-status-inactive td {
        background-color: #fef2f2 !important;
        border-left: 3px solid var(--danger);
    }
    .row-status-inactive td:first-child { border-left: none; }
    .row-status-inactive:hover td { background-color: #fee2e2 !important; }

    .row-status-active td {
        background-color: #f0fdf4 !important;
        border-left: 3px solid var(--success);
    }
    .row-status-active td:first-child { border-left: none; }
    .row-status-active:hover td { background-color: #dcfce7 !important; }

    /* ===== TABLE ACTION BUTTONS ===== */
    .table .btn-edit,
    .table .btn-inactive,
    .table .btn-active {
        display: inline-block !important;
        width: auto !important;
        height: auto !important;
        padding: 2px 8px !important;
        font-size: 9px !important;
        border-radius: 4px !important;
        margin: 1px 2px !important;
        border: none !important;
        cursor: pointer !important;
        transition: var(--transition) !important;
        min-width: 45px;
        text-align: center;
        line-height: 16px;
    }

    .table .btn-edit {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        color: white !important;
    }
    .table .btn-edit:hover { transform: scale(1.05); }

    .table .btn-inactive {
        background: linear-gradient(135deg, var(--danger) 0%, var(--danger-dark) 100%) !important;
        color: white !important;
    }
    .table .btn-inactive:hover { transform: scale(1.05); }

    .table .btn-active {
        background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%) !important;
        color: white !important;
    }
    .table .btn-active:hover { transform: scale(1.05); }

    /* ============================================================ */
    /* ===== MODAL ===== */
    /* ============================================================ */
    .modal-content {
        border-radius: var(--radius-lg);
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        overflow: hidden;
    }

    .modal-header {
        padding: 12px 24px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-bottom: none;
    }

    .modal-header .modal-title {
        color: white;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .modal-header .close {
        color: white;
        opacity: 0.8;
        text-shadow: none;
        transition: var(--transition);
        margin-top: -4px;
        font-size: 22px;
    }
    .modal-header .close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 16px 20px;
        background: var(--gray-50);
    }

    .modal-footer {
        padding: 10px 20px;
        border-top: 1px solid var(--gray-200);
        background: white;
        border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .modal-footer .btn {
        margin-top: 0 !important;
        margin-left: 0 !important;
        position: relative !important;
        left: 0 !important;
    }

    /* ============================================================ */
    /* ===== FORM ===== */
    /* ============================================================ */
    .form-group {
        margin-bottom: 10px;
    }

    .form-group label {
        font-size: 11px;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 2px;
        display: block;
        letter-spacing: 0.3px;
    }

    .form-group label .text-danger {
        color: var(--danger);
        margin-left: 2px;
    }

    .form-control {
        border: 2px solid var(--gray-200);
        border-radius: var(--radius);
        padding: 5px 10px;
        font-size: 12px;
        height: 32px;
        transition: var(--transition);
        background: white;
        width: 100%;
        color: var(--gray-800);
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    .form-control:hover { border-color: var(--gray-400); }
    .form-control::placeholder { color: var(--gray-400); font-size: 11px; }

    /* ===== SELECT2 ===== */
    .select2-container .select2-selection--single {
        border: 2px solid var(--gray-200) !important;
        border-radius: var(--radius) !important;
        height: 32px !important;
        padding: 4px 10px !important;
        font-size: 12px !important;
        transition: var(--transition) !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 26px !important;
        padding-left: 0 !important;
        font-size: 12px !important;
        color: var(--gray-700) !important;
    }

    .select2-container .select2-selection--single .select2-selection__arrow {
        height: 28px !important;
    }

    .select2-dropdown {
        border: 2px solid var(--gray-200) !important;
        border-radius: var(--radius) !important;
    }

    /* ===== CHECK BUTTON ===== */
    #check_btn_id,
    #echeck_btn_id {
        background: linear-gradient(135deg, #34d399 0%, #10b981 100%) !important;
        color: white !important;
        border: none !important;
        padding: 3px 12px !important;
        font-size: 11px !important;
        font-weight: 500 !important;
        border-radius: var(--radius) !important;
        transition: var(--transition) !important;
        margin-top: 0 !important;
        cursor: pointer !important;
        height: 32px;
        white-space: nowrap;
    }

    #check_btn_id:hover,
    #echeck_btn_id:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }

    /* ============================================================ */
    /* ===== DATA TABLE OVERRIDE ===== */
    /* ============================================================ */
    .dataTables_wrapper .dataTables_length select {
        border: 2px solid var(--gray-200) !important;
        border-radius: var(--radius) !important;
        height: 26px !important;
        padding: 0 6px !important;
        font-size: 10px !important;
    }

    .dataTables_wrapper .dataTables_length label {
        font-size: 10px !important;
        color: var(--gray-600);
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid var(--gray-200) !important;
        border-radius: var(--radius) !important;
        height: 26px !important;
        padding: 0 8px !important;
        font-size: 10px !important;
    }

    .dataTables_wrapper .dataTables_filter label {
        font-size: 10px !important;
        color: var(--gray-600);
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
        outline: none !important;
    }

    .dataTables_wrapper .dataTables_info {
        font-size: 10px !important;
        color: var(--gray-500) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 2px 6px !important;
        font-size: 10px !important;
        border-radius: 4px !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary) !important;
        color: white !important;
        border-color: var(--primary) !important;
    }

    /* ============================================================ */
    /* ===== BREADCRUMB ===== */
    /* ============================================================ */
    .content-header > .breadcrumb {
        float: right;
        background: transparent;
        margin-top: 0;
        margin-bottom: 0;
        font-size: 12px;
        padding: 7px 5px;
        border-radius: 2px;
    }

    .content-header > .breadcrumb > li > a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    /* ============================================================ */
    /* ===== RESPONSIVE ===== */
    /* ============================================================ */
    @media (max-width: 768px) {
        .top-bar {
            flex-direction: column;
            align-items: stretch;
            padding: 10px 14px;
        }
        .top-bar .summary-cards {
            justify-content: center;
        }
        .top-bar .action-right {
            justify-content: center;
        }
        .summary-card {
            min-width: 80px;
            padding: 4px 10px;
            flex: 1;
        }
        .summary-card .card-number { font-size: 14px; }
        .summary-card .card-label { font-size: 8px; }
        .summary-card .card-icon { width: 24px; height: 24px; font-size: 11px; }
        .modal-dialog {
            width: 95%;
            margin: 10px auto;
        }
        .table {
            font-size: 9px !important;
            min-width: 800px;
        }
        .table thead th { font-size: 8px !important; padding: 4px 3px !important; }
        .table tbody td { font-size: 9px !important; padding: 3px 3px !important; height: 22px; }
        .table .btn-edit,
        .table .btn-inactive,
        .table .btn-active {
            font-size: 8px !important;
            padding: 1px 5px !important;
            min-width: 35px;
            line-height: 14px;
        }
        .modal-body { padding: 12px 14px; }
        .form-control { font-size: 11px; height: 28px; }
        .select2-container .select2-selection--single { height: 28px !important; }
    }

    @media (max-width: 480px) {
        .summary-card { min-width: 60px; padding: 3px 8px; }
        .summary-card .card-number { font-size: 12px; }
        .summary-card .card-label { font-size: 7px; }
        .summary-card .card-icon { width: 20px; height: 20px; font-size: 9px; }
        .table thead th { font-size: 7px; padding: 3px 2px; }
        .table tbody td { font-size: 8px; padding: 2px 2px; height: 20px; }
        .btn { font-size: 9px; padding: 2px 8px; height: 22px; }
    }

    /* ===== SCROLLBAR ===== */
    ::-webkit-scrollbar { width: 4px; height: 4px; }
    ::-webkit-scrollbar-track { background: var(--gray-100); border-radius: 4px; }
    ::-webkit-scrollbar-thumb { background: var(--gray-300); border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--gray-400); }

    /* ===== UTILITY ===== */
    .text-muted { color: var(--gray-400); }
    .fw-600 { font-weight: 600; }
    .gap-1 { gap: 4px; }
    .d-flex { display: flex; }
    .align-center { align-items: center; }
    .flex-wrap { flex-wrap: wrap; }
    .justify-between { justify-content: space-between; }
    .cursor-pointer { cursor: pointer; }
</style>

<!-- ===== BREADCRUMB ===== -->
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{url('/ci_item')}}"><i class="fa fa-list"></i> CI Item List</a></li>
    </ol>
    <br>
</section>

<!-- ===== MAIN CONTENT ===== -->
<div class="row">
    <div class="col-md-12">
        @if(Session::has('success'))
            <div class="callout callout-success">
                <strong>Success!</strong> {{ Session::get('success') }}
            </div> 
        @endif 
        @if(Session::has('danger'))
            <div class="callout callout-danger">
                <strong>Unsuccessful!</strong> {{ Session::get('danger') }}
            </div> 
        @endif 

        <div class="box box-primary">
            <!-- ===== TOP BAR: SUMMARY CARDS (LEFT) + CREATE BUTTON (RIGHT) ===== -->
            <div class="top-bar">
                <div class="summary-cards">
                    <div class="summary-card card-total active" data-filter="all" onclick="filterTable('all')">
                        <div class="card-icon total"><i class="fa fa-database"></i></div>
                        <div class="card-info">
                            <div class="card-number" id="totalCount">0</div>
                            <div class="card-label">Total</div>
                        </div>
                    </div>
                    <div class="summary-card card-active" data-filter="active" onclick="filterTable('active')">
                        <div class="card-icon active"><i class="fa fa-check-circle"></i></div>
                        <div class="card-info">
                            <div class="card-number" id="activeCount">0</div>
                            <div class="card-label">Active</div>
                        </div>
                    </div>
                    <div class="summary-card card-inactive" data-filter="inactive" onclick="filterTable('inactive')">
                        <div class="card-icon inactive"><i class="fa fa-times-circle"></i></div>
                        <div class="card-info">
                            <div class="card-number" id="inactiveCount">0</div>
                            <div class="card-label">Inactive</div>
                        </div>
                    </div>
                </div>
                <div class="action-right">
                    <button class="btn btn-success btn-sm btn-flat create-btn-id">
                        <i class="fa fa-plus"></i> Create Item
                    </button>
                </div>
            </div>

            <!-- ===== TABLE ===== -->
            <div class="panel-body table-responsive">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="display:none;">ID</th>
                            <th style="min-width:60px;">Item Code</th>
                            <th style="min-width:100px;">Item Name</th>
                            <th style="min-width:100px;">Duplicate Name</th>
                            <th style="width:55px;">P Weight</th>
                            <th style="width:48px;">Factor</th>
                            <th style="width:48px;">CI Factor</th>
                            <th style="width:55px;">D Weight</th>
                            <th style="width:55px;">CI Rate</th>
                            <th style="width:60px;">HS Code</th>
                            <th style="min-width:50px;">BU</th>
                            <th style="min-width:70px;">Category</th>
                            <th style="width:65px;">Status</th>
                            <th style="min-width:160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== CREATE MODAL ===== -->
<!-- ============================================================ -->
<div id="createModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <form class="form-horizontal" id="CreateFormId">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Create CI Item</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_type_id">Category <span class="text-danger">*</span></label>
                                <select name="item_type_id" id="item_type_id" data-live-search="true" class="form-control select2 selectpicker" required>
                                    <option value="">Select Category</option>
                                    @foreach($itemTypes as $itemType)
                                    <option value="{{$itemType->id}}">{{$itemType->name}}</option> 
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="ci_item_code">CI Item Code <span class="text-danger">*</span></label>
                                <div class="d-flex gap-1 align-center">
                                    <input name="ci_item_code" type="text" id="ci_item_code" class="form-control" placeholder="Enter item code" style="flex:1;">
                                    <input type="button" value="Check" class="btn btn-success btn-sm" id="check_btn_id" style="flex-shrink:0;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ci_item_name">CI Item Name <span class="text-danger">*</span></label>
                                <input name="ci_item_name" type="text" id="ci_item_name" class="form-control" placeholder="Enter item name">
                            </div>

                            <div class="form-group">
                                <label for="duplicate_name">Duplicate Name</label>
                                <input name="duplicate_name" type="text" id="duplicate_name" class="form-control" placeholder="Enter duplicate name">
                            </div>

                            <div class="form-group">
                                <label for="p_net_weight">P Net Weight <span class="text-danger">*</span></label>
                                <input name="p_net_weight" type="number" id="p_net_weight" class="form-control" step="any" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="factor">Factor <span class="text-danger">*</span></label>
                                <input name="factor" type="number" id="factor" class="form-control" step="any" placeholder="0">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ci_factor">CI Factor <span class="text-danger">*</span></label>
                                <input name="ci_factor" type="number" id="ci_factor" class="form-control" step="any" placeholder="0">
                            </div>

                            <div class="form-group">
                                <label for="d_net_weight">D Net Weight <span class="text-danger">*</span></label>
                                <input name="d_net_weight" type="number" id="d_net_weight" class="form-control" step="any" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="d_gross_weight">D Gross Weight <span class="text-danger">*</span></label>
                                <input name="d_gross_weight" type="number" id="d_gross_weight" class="form-control" step="any" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="ci_item_rate">CI Item Rate <span class="text-danger">*</span></label>
                                <input name="ci_item_rate" type="number" id="ci_item_rate" class="form-control" step="any" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="hs_code">HS Code <span class="text-danger">*</span></label>
                                <input name="hs_code" type="text" id="hs_code" class="form-control" placeholder="Enter HS code">
                            </div>

                            <div class="form-group">
                                <label for="bu_id">BU <span class="text-danger">*</span></label>
                                <select name="bu_id" id="bu_id" data-live-search="true" class="form-control select2 selectpicker" required>
                                    <option value="">Select BU</option>
                                    @foreach($bus as $bu)
                                    <option value="{{$bu->id}}">{{$bu->code}} - {{$bu->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="class_name">Class</label>
                                <input name="class_name" type="text" id="class_name" class="form-control" placeholder="Enter class name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="create_button_id">
                        <i class="fa fa-check"></i> Create
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== EDIT MODAL ===== -->
<!-- ============================================================ -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <form class="form-horizontal" id="updateFormId">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-pencil-square-o"></i> Update CI Item</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="eitem_type_id">Category <span class="text-danger">*</span></label>
                                <select name="eitem_type_id" id="eitem_type_id" data-live-search="true" class="form-control select2 selectpicker" required>
                                    <option value="">Select Category</option>
                                    @foreach($itemTypes as $itemType)
                                    <option value="{{$itemType->id}}">{{$itemType->name}}</option> 
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="eci_item_code">CI Item Code <span class="text-danger">*</span></label>
                                <div class="d-flex gap-1 align-center">
                                    <input name="ci_item_code" type="text" id="eci_item_code" class="form-control" placeholder="Enter item code" style="flex:1;">
                                    <input type="button" value="Check" class="btn btn-success btn-sm" id="echeck_btn_id" style="flex-shrink:0;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="eci_item_name">CI Item Name <span class="text-danger">*</span></label>
                                <input name="ci_item_name" type="text" id="eci_item_name" class="form-control" placeholder="Enter item name">
                            </div>

                            <div class="form-group">
                                <label for="eduplicate_name">Duplicate Name</label>
                                <input name="duplicate_name" type="text" id="eduplicate_name" class="form-control" placeholder="Enter duplicate name">
                            </div>

                            <div class="form-group">
                                <label for="ep_net_weight">P Net Weight <span class="text-danger">*</span></label>
                                <input name="p_net_weight" type="number" id="ep_net_weight" class="form-control" step="any" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="efactor">Factor <span class="text-danger">*</span></label>
                                <input name="factor" type="number" id="efactor" class="form-control" step="any" placeholder="0">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="eci_factor">CI Factor <span class="text-danger">*</span></label>
                                <input name="ci_factor" type="number" id="eci_factor" class="form-control" step="any" placeholder="0">
                            </div>

                            <div class="form-group">
                                <label for="ed_net_weight">D Net Weight <span class="text-danger">*</span></label>
                                <input name="d_net_weight" type="number" id="ed_net_weight" class="form-control" step="any" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="ed_gross_weight">D Gross Weight <span class="text-danger">*</span></label>
                                <input name="d_gross_weight" type="number" id="ed_gross_weight" class="form-control" step="any" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="eci_item_rate">CI Item Rate <span class="text-danger">*</span></label>
                                <input name="ci_item_rate" type="number" id="eci_item_rate" class="form-control" step="any" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="ehs_code">HS Code <span class="text-danger">*</span></label>
                                <input name="hs_code" type="text" id="ehs_code" class="form-control" placeholder="Enter HS code">
                            </div>

                            <div class="form-group">
                                <label for="ebu_id">BU <span class="text-danger">*</span></label>
                                <select name="bu_id" id="ebu_id" data-live-search="true" class="form-control select2 selectpicker" required>
                                    <option value="">Select BU</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="eclass_name">Class</label>
                                <input name="class_name" type="text" id="eclass_name" class="form-control" placeholder="Enter class name">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="edit_id" id="edit_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning" id="update-btn-id">
                        <i class="fa fa-check"></i> Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>document.title = 'Export | Items';</script>
<script type="text/javascript">
     
    $('#create_button_id').prop("disabled", true);
    $('#edit_button_id').prop("disabled", true);
    $('#check_btn_id').prop("disabled", true);
    setTimeout(function() { $('.sr-only').click(); }, 0.0001);
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ===== FILTER FUNCTION =====
    let currentFilter = 'all';

    function filterTable(filter) {
        currentFilter = filter;
        
        // Update card active state
        $('.summary-card').removeClass('active');
        $(`.summary-card[data-filter="${filter}"]`).addClass('active');
        
        // Reload table with filter
        var table = $('#example1').DataTable();
        table.ajax.reload(null, false);
    }

    // ===== UPDATE SUMMARY COUNTS =====
    function updateSummaryCounts(data) {
        var total = data.length;
        var active = data.filter(item => item.status == 'Y' || item.status == '1' || item.is_api == null || item.is_api == 'N').length;
        var inactive = data.filter(item => item.status == 'N' || item.status == '0' || item.is_api == 'Y').length;
        
        $('#totalCount').text(total);
        $('#activeCount').text(active);
        $('#inactiveCount').text(inactive);
    }

    $(document).ready(function(){

        // ===== INITIALIZE WITH TOTAL FILTER =====
        currentFilter = 'all';
        $('.summary-card[data-filter="all"]').addClass('active');

        $('#item_type_id').change(function(){
            var item_type_id = $(this).val();
            if(parseInt(item_type_id)==1 || parseInt(item_type_id)==2){
                $('#check_btn_id').show(); 
                $('#check_btn_id').prop("disabled", false);
                $('#create_button_id').prop("disabled", true);
                resetForm();
            } else if(parseInt(item_type_id)==3){
                $('#check_btn_id').hide();
                $('#check_btn_id').prop("disabled", true);
                $('#create_button_id').prop("disabled", false);
                resetForm();
            }
        });

        function resetForm(){
            $('#ci_item_code').val("");
            $('#ci_item_name').val("");
            $('#duplicate_name').val("");
            $('#p_net_weight').val("");
            $('#factor').val("");
            $('#ci_factor').val("");
            $('#d_net_weight').val("");
            $('#d_gross_weight').val("");
            $('#ci_item_rate').val("");
            $('#hs_code').val("");
            $('#cat_name').val("");
            $('#class_name').val("");
            $('#bu_id').val('').selectpicker('refresh');
        }

        $('.create-btn-id').click(function(){
            $('#createModal').modal('show');
        });
        
        $('#example1').dataTable().fnDestroy(); 
        
        var table = $('#example1').DataTable({
            "order": [[0, "desc"]],
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": "/get/ci_itemList",
                "type": "GET",
                "dataSrc": function (json) {
                    var data = json.data || [];
                    
                    // Apply filter FIRST
                    var filteredData = [];
                    if (currentFilter === 'active') {
                        filteredData = data.filter(item => item.status == 'Y' || item.status == '1' || item.is_api == null || item.is_api == 'N');
                    } else if (currentFilter === 'inactive') {
                        filteredData = data.filter(item => item.status == 'N' || item.status == '0' || item.is_api == 'Y');
                    } else {
                        filteredData = data;
                    }
                    
                    // Update summary counts with ALL data (not filtered)
                    updateSummaryCounts(data);
                    
                    // Return filtered data
                    return filteredData;
                },
                "error": function(xhr, error, thrown) {
                    console.log("DataTable Error: " + error);
                    return [];
                }
            },
            "columns": [
                { "data": "id", "visible": false }, 
                { "data": "ci_item_code", "title": "Item Code" },
                { "data": "ci_item_name", "title": "Item Name" },
                { "data": "duplicate_name", "title": "Duplicate Name" },
                { "data": "p_net_weight", "title": "P Net Weight" },
                { "data": "factor", "title": "Factor" },
                { "data": "ci_factor", "title": "CI Factor" },
                { "data": "d_net_weight", "title": "D Net Weight" },
                { "data": "ci_item_rate", "title": "Item Rate" },
                { "data": "hs_code", "title": "HS Code" },
                { "data": "bu", "title": "BU" },
                { "data": "category", "title": "Category" },
                { 
                    "data": "status",
                    "title": "Status",
                    "render": function(data, type, row) {
                        // Check if item is inactive
                        if (row.is_api === 'Y' || data == 'N' || data == '0') {
                            return '<span class="badge" style="background:#ef4444;color:white;padding:2px 10px;border-radius:50px;font-size:9px;">Inactive</span>';
                        } else {
                            return '<span class="badge" style="background:#10b981;color:white;padding:2px 10px;border-radius:50px;font-size:9px;">Active</span>';
                        }
                    }
                },
                { 
                    "data": null,
                    "title": "Actions",
                    "render": function(data, type, row) {
                        var buttons = '';
                        @if($viewPermissions->can_update)
                            buttons += '<button data-id="'+row.id+'" class="btn-edit" title="Edit"><i class="fa fa-pencil"></i></button> ';
                        @endif
                        @if($viewPermissions->can_delete)
                            if (row.is_api === 'Y' || row.status == 'N' || row.status == '0') {
                                buttons += '<button data-id="'+row.id+'" class="btn-active" title="Active"><i class="fa fa-check-circle"></i> Active</button> ';
                            } else {
                                buttons += '<button data-id="'+row.id+'" class="btn-inactive" title="Inactive"><i class="fa fa-ban"></i> Inactive</button> ';
                            }
                        @endif
                        return buttons ? buttons : '<span class="text-muted">No Actions</span>';
                    }
                }
            ],
            "language": {
                "emptyTable": "No records available",
                "processing": "Loading...",
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                },
                "zeroRecords": "No matching records found"
            },
            "rowCallback": function(row, data) {
                if (data.is_api === 'Y' || data.status == 'N' || data.status == '0') {
                    $(row).addClass('row-status-inactive');
                } else {
                    $(row).addClass('row-status-active');
                }
            },
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "searching": true,
            "ordering": true,
            "paging": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });

        // Check Item
        $('#check_btn_id').on('click', function(e) {
            var ci_item_code = $('#ci_item_code').val();
            if(ci_item_code == ""){
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Item Code Can Not Empty!',
                }); 
            } else {
                var url = "{{url('/json/ci_item/details')}}/"+ci_item_code;
                var bu='';
                $.get(url, function(data) {
                    bu = data.bus;
                    var object = JSON.parse(data.itemDetails);
                    var data = object;
                    if(data == "") {
                        Swal.fire({ title: 'Sorry!! Item Not Found..?' });
                        $("#SubmitForm")[0].reset();
                        loadBU('','');
                    } else {
                        var result = (Object.entries(data));
                        $('#ci_item_name').val(result[0][1]['ITEM_NAME']);
                        $('#duplicate_name').val(result[0][1]['ITEM_NAME']);
                        $('#factor').val(result[0][1]['D_U_FACT']);
                        $('#ci_factor').val(result[0][1]['D_U_FACT']);
                        $('#cat_name').val(result[0][1]['CAT_NAME']);
                        $('#class_name').val(result[0][1]['CLASS_NAME']);
                        loadBU(bu, result[0][1]['COMPANY_ID']);
                        $('#create_button_id').prop("disabled", false);   
                    }
                }); 
            }
        });

        // Check Item Edit Form
        $('#echeck_btn_id').on('click', function(e) {
            var ci_item_code = $('#eci_item_code').val();
            if(ci_item_code == ""){
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Item Code Can Not Empty!',
                }); 
            } else {
                var url = "{{url('/json/ci_item/details')}}/"+ci_item_code;
                var bu='';
                var ci_item_rate=0;
                var hs_code='';
                $.get(url, function(data) {
                    bu = data.bus;
                    ci_item_rate = data.ci_item_rate;
                    hs_code = data.hs_code;
                    var object = JSON.parse(data.itemDetails);
                    var data = object;
                    if(data == "") {
                        Swal.fire({ title: 'Sorry!! Item Not Found..?' });
                        $("#SubmitForm")[0].reset();
                        loadBUEdit('','');
                    } else {
                        var result = (Object.entries(data));
                        $('#eci_item_name').val(result[0][1]['ITEM_NAME']);
                        $('#efactor').val(result[0][1]['D_U_FACT']);
                        $('#eci_factor').val(result[0][1]['D_U_FACT']);
                        $('#ecat_name').val(result[0][1]['CAT_NAME']);
                        $('#eclass_name').val(result[0][1]['CLASS_NAME']);
                        $('#eci_item_rate').val(ci_item_rate);
                        $('#ehs_code').val(hs_code);
                        loadBUEdit(bu, result[0][1]['COMPANY_ID']);
                        $('#update-btn-id').prop("disabled", false);   
                    }
                }); 
            }
        });

        // Edit Item
        $('#example1 tbody').on('click', '.btn-edit', function(e) {
            e.preventDefault();
            var item_id = $(this).data("id");
            if(item_id){
                $.ajax({
                    method: 'GET',
                    url: `/ci_item/${item_id}`,
                    data: {'item_id':item_id, '_token': $('input[name=_token]').val()},
                    success: function (res) {
                        if(res.data){
                            $('#eci_item_name').val(res.data.ci_item_name);
                            $('#eci_item_code').val(res.data.ci_item_code);
                            $('#eduplicate_name').val(res.data.duplicate_name);
                            $('#ep_net_weight').val(res.data.p_net_weight);
                            $('#efactor').val(res.data.factor);
                            $('#eci_factor').val(res.data.ci_factor);
                            $('#ed_net_weight').val(res.data.d_net_weight);
                            $('#ed_gross_weight').val(res.data.d_gross_weight);
                            $('#eci_item_rate').val(res.data.ci_item_rate);
                            $('#ehs_code').val(res.data.hs_code);
                            $('#ecat_name').val(res.data.cat_name);
                            $('#eclass_name').val(res.data.class_name);
                            $('#edit_id').val(item_id);
                            loadBUOnEditForm(res.bus, res.data.company_id); 
                            loadCategroyOnEditForm(res.categories, res.data.item_type_id); 
                            if(res.data.item_type_id == 3){
                                $('#echeck_btn_id').hide();
                                $('#echeck_btn_id').prop("disabled", true);
                                $('#update-btn-id').prop("disabled", false);
                            } else {
                                $('#echeck_btn_id').show(); 
                                $('#echeck_btn_id').prop("disabled", false);
                                $('#update-btn-id').prop("disabled", true);
                            }
                            var table2 = $('#example1').DataTable();
                            table.ajax.reload();
                        } else {
                            Swal.fire({ title: 'Sorry!! Item Not Found..?' });
                            $("#formId")[0].reset();
                            loadBUOnEditForm('','');
                            loadCategroyOnEditForm('','');
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            }
            $("#editModal").modal("show");
        });

        // Load BU Create Form
        function loadBU(data, bu_code){
            if(data){
                var $el = $('#bu_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function (key, value) {
                    $('select[name="bu_id"]').append(`<option value="${value.id}" ${value.code == parseInt(bu_code) ? 'selected' : ''}>${value.code}-${value.name}</option>`)
                });
                $el.selectpicker('refresh');
            } else {
                var $el = $('#bu_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $el.selectpicker('refresh'); 
            }
        }

        // Load BU Edit Form
        function loadBUEdit(data, bu_code){
            if(data){
                var $el = $('#ebu_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function (key, value) {
                    $el.append(`<option value="${value.id}" ${value.code == parseInt(bu_code) ? 'selected' : ''}>${value.code}-${value.name}</option>`)
                });
                $el.selectpicker('refresh');
            } else {
                var $el = $('#ebu_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $el.selectpicker('refresh'); 
            }
        }

        // Load BU On Edit Form
        function loadBUOnEditForm(data, bu_code){
            if(data){
                var $el = $('#ebu_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function (key, value) {
                    $el.append(`<option value="${value.id}" ${value.code == parseInt(bu_code) ? 'selected' : ''}>${value.code}-${value.name}</option>`)
                });
                $el.selectpicker('refresh');
            } else {
                var $el = $('#ebu_id');
                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $el.selectpicker('refresh'); 
            }
        }

        // Load Category On Edit Form
        function loadCategroyOnEditForm(data, category_id){
            if(data){
                var $el = $('#eitem_type_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function (key, value) {
                    $el.append(`<option value="${value.id}" ${value.id == parseInt(category_id) ? 'selected' : ''}>${value.name}</option>`)
                });
                $el.selectpicker('refresh');
            } else {
                var $el = $('#eitem_type_id');
                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $el.selectpicker('refresh'); 
            }
        }

        // Item Inactive
        $('#example1 tbody').on('click', '.btn-inactive', function(e) {
            var inactiveID = $(this).data("id");   
            if(inactiveID){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Inactive it!'
                }).then((result) => {
                    if (result.isConfirmed == true) {
                        $.ajax({
                            type: "GET",
                            url: "/item_inactive"+'/'+inactiveID,
                            datatype: "json",
                            success: function(res){
                                if(res.code == 200){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Inactive Successfully Done',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    var table2 = $('#example1').DataTable();
                                    table2.ajax.reload();
                                } else if(res.code == 500){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong!'
                                    });
                                }
                            }
                        })
                    };
                });
            }
        });

        // Item Active
        $('#example1 tbody').on('click', '.btn-active', function(e) {
            var active_id = $(this).data("id");   
            if(active_id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Active it!'
                }).then((result) => {
                    if (result.isConfirmed == true) {
                        $.ajax({
                            type: "GET",
                            url: "/item_active"+'/'+active_id,
                            datatype: "json",
                            success: function(res){
                                if(res.code == 200){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Active Successfully Done',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    var table2 = $('#example1').DataTable();
                                    table2.ajax.reload();
                                } else if(res.code == 500){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong!'
                                    });
                                }
                            }
                        })
                    };
                });
            }
        });

        // Create Form Submit
        $("#CreateFormId").submit(function (e) {
            e.preventDefault(); 
            $.ajax({
                type:'POST',
                url: "/ci_item",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: (res) => {
                    if(res.code == 200){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        resetForm();
                        $("#createModal").modal("hide");
                        var table2 = $('#example1').DataTable();
                        table2.ajax.reload();
                    } else if(res.code == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.message
                        });
                    }
                },
                error: function(data){
                    console.log(data);
                }
            });
        });

        // Update Form Submit
        $("#updateFormId").submit(function (e) {
            e.preventDefault(); 
            $.ajax({
                type:'POST',
                url: "/update/ci_item",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: (res) => {
                    if(res.code == 200){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Update Successfully Done..!!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $(this).trigger('reset');
                        $('#bu_id').val('').selectpicker('refresh');
                        $('#edit_button_id').prop("disabled", true);
                        $("#editModal").modal("hide");
                        var table2 = $('#example1').DataTable();
                        table2.ajax.reload();
                    } else if(res.code == 500){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
                    }
                },
                error: function(data){
                    console.log(data);
                }
            });
        });

        $('.close,.btn-danger').click(function(){
            resetForm();
        });    

    });
</script>
@endsection