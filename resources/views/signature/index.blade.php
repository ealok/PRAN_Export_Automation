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

    /* ===== BOX ===== */
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

    /* ===== BOX HEADER ===== */
    .box-header.with-border {
        padding: 12px 18px;
        background: linear-gradient(135deg, var(--gray-50) 0%, #ffffff 100%);
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    .box-header.with-border .header-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--gray-800);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-right: auto;
    }

    .box-header.with-border .header-title i {
        color: var(--primary);
        font-size: 16px;
    }

    /* ===== BUTTONS ===== */
    .btn {
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 500;
        border-radius: var(--radius);
        border: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 4px;
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

    .btn-info {
        background: linear-gradient(135deg, var(--info) 0%, #0284c7 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(14, 165, 233, 0.2);
    }
    .btn-info:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(14, 165, 233, 0.3);
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

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(79, 70, 229, 0.3);
    }

    .btn-xs {
        padding: 2px 8px;
        font-size: 10px;
        height: 22px;
        border-radius: 4px;
    }
    .btn-sm {
        padding: 3px 10px;
        font-size: 10px;
        height: 26px;
    }

    .btn-flat { border-radius: var(--radius); }

    /* ===== TABLE - COMPACT & PROFESSIONAL ===== */
    .panel-body {
        padding: 12px 16px;
        background: white;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px !important;
        border-radius: var(--radius);
        overflow: hidden;
        min-width: 600px;
    }

    /* Table Header */
    .table thead th {
        background: var(--gray-900);
        color: white;
        font-weight: 600;
        font-size: 9px !important;
        padding: 6px 6px !important;
        text-align: center;
        border: 1px solid var(--gray-700);
        text-transform: uppercase;
        letter-spacing: 0.4px;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    /* Table Body - NO height used */
    .table tbody td {
        padding: 4px 6px !important;
        border-bottom: 1px solid var(--gray-200);
        color: var(--gray-700);
        vertical-align: middle;
        text-align: center;
        font-size: 11px !important;
        transition: var(--transition);
        word-break: break-word;
    }

    .table tbody tr {
        transition: var(--transition);
        cursor: default;
    }

    .table tbody tr:hover td {
        background: var(--gray-50);
    }

    .table tbody tr:nth-child(even) td {
        background: #fafafa;
    }
    .table tbody tr:nth-child(odd) td {
        background: #ffffff;
    }
    .table tbody tr:last-child td { border-bottom: none; }

    /* ===== COLUMN WIDTH (Content based) ===== */
    .table thead th:nth-child(1) { width: 40px; }  /* Id */
    .table thead th:nth-child(2) { width: 20%; }  /* Name */
    .table thead th:nth-child(3) { width: 15%; }  /* Company */
    .table thead th:nth-child(4) { width: 25%; }  /* Signature */
    .table thead th:nth-child(5) { width: 100px; }/* Actions */

    /* Text Alignment - Center all, Left for Name & Company */
    .table tbody td:nth-child(2),
    .table tbody td:nth-child(3) {
        text-align: left !important;
        padding-left: 8px !important;
    }

    .table tbody td:nth-child(1) {
        text-align: center !important;
        font-weight: 600;
        color: var(--gray-500);
    }

    /* Signature Image Style */
    .table tbody td:nth-child(4) img {
        max-width: 100px;
        max-height: 50px;
        border-radius: 4px;
        border: 1px solid var(--gray-200);
        padding: 2px;
        background: white;
    }

    /* ===== TABLE ACTION BUTTONS ===== */
    .table .btn-group-actions {
        display: flex;
        gap: 3px;
        justify-content: center;
        flex-wrap: nowrap;
    }

    .table .btn-group-actions .btn {
        font-size: 9px !important;
        padding: 2px 6px !important;
        height: 20px !important;
        border-radius: 4px !important;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        min-width: 28px;
        justify-content: center;
    }

    .table .btn-group-actions .btn i {
        font-size: 10px !important;
        margin-right: 0 !important;
    }

    .table .btn-group-actions .btn-info {
        background: linear-gradient(135deg, var(--info) 0%, #0284c7 100%) !important;
        color: white !important;
    }
    .table .btn-group-actions .btn-info:hover { transform: scale(1.05); }

    /* ===== MODAL ===== */
    .modal-content {
        border-radius: var(--radius-lg);
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        overflow: hidden;
    }

    .modal-header {
        padding: 12px 20px;
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
        padding: 20px 24px;
        background: var(--gray-50);
    }

    .modal-body .form-group {
        margin-bottom: 15px;
    }

    .modal-body .form-group label {
        font-size: 12px;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 4px;
        display: block;
        letter-spacing: 0.3px;
    }

    .modal-body .form-control {
        border: 2px solid var(--gray-200);
        border-radius: var(--radius);
        padding: 5px 10px;
        font-size: 12px;
        height: 34px;
        transition: var(--transition);
        background: white;
        width: 100%;
        color: var(--gray-800);
    }

    .modal-body .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    .modal-body .form-control:hover {
        border-color: var(--gray-400);
    }

    .modal-body .form-control::placeholder {
        color: var(--gray-400);
        font-size: 11px;
    }

    .modal-body input[type="file"] {
        padding: 6px 10px;
        height: auto;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius);
        background: white;
        width: 100%;
        color: var(--gray-800);
        font-size: 12px;
    }

    .modal-body input[type="file"]:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
    }

    /* ===== SELECT2 OVERRIDE ===== */
    .select2-container .select2-selection--single {
        border: 2px solid var(--gray-200) !important;
        border-radius: var(--radius) !important;
        height: 34px !important;
        padding: 4px 10px !important;
        font-size: 12px !important;
        transition: var(--transition) !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 30px !important;
        padding-left: 0 !important;
        font-size: 12px !important;
        color: var(--gray-700) !important;
    }

    .select2-container .select2-selection--single .select2-selection__arrow {
        height: 32px !important;
    }

    .select2-dropdown {
        border: 2px solid var(--gray-200) !important;
        border-radius: var(--radius) !important;
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
        height: 30px;
        padding: 4px 16px;
    }

    .modal-footer .btn-info {
        background: var(--primary) !important;
    }
    .modal-footer .btn-info:hover {
        background: var(--primary-dark) !important;
    }
    .modal-footer .btn-danger {
        background: var(--danger) !important;
    }
    .modal-footer .btn-danger:hover {
        background: var(--danger-dark) !important;
    }

    /* ===== BREADCRUMB ===== */
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

    .content-header > .breadcrumb > li > a:hover {
        color: var(--primary-dark);
    }

    .content-header h1 {
        font-size: 20px;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 4px;
    }
    .content-header h1 small {
        font-size: 14px;
        color: var(--gray-500);
        font-weight: 400;
    }

    /* ===== CALL OUT ===== */
    .callout {
        border-radius: var(--radius);
        padding: 12px 18px;
        margin-bottom: 16px;
    }
    .callout-success {
        background: #ecfdf5;
        border-left: 4px solid var(--success);
        color: #065f46;
    }
    .callout-danger {
        background: #fef2f2;
        border-left: 4px solid var(--danger);
        color: #991b1b;
    }

    /* ===== DATA TABLE SEARCH ===== */
    .dataTables_wrapper .dataTables_filter input {
        border: 1.5px solid var(--gray-200);
        border-radius: var(--radius);
        height: 28px;
        padding: 0 10px;
        font-size: 11px;
        margin-left: 6px;
        transition: var(--transition);
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
    }
    .dataTables_wrapper .dataTables_filter label {
        font-size: 11px;
        color: var(--gray-600);
        font-weight: 500;
    }

    .dataTables_wrapper .dataTables_length label {
        font-size: 11px;
        color: var(--gray-600);
        font-weight: 500;
    }

    .dataTables_wrapper .dataTables_info {
        font-size: 11px;
        color: var(--gray-500);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 2px 8px;
        font-size: 11px;
        border-radius: 4px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .box-header.with-border {
            flex-direction: column;
            align-items: stretch;
        }
        .modal-dialog {
            width: 95%;
            margin: 10px auto;
        }
        .table {
            font-size: 10px !important;
            min-width: 500px;
        }
        .table thead th {
            font-size: 8px !important;
            padding: 4px 4px !important;
        }
        .table tbody td {
            font-size: 10px !important;
            padding: 3px 4px !important;
        }
        .table tbody td:nth-child(4) img {
            max-width: 60px;
            max-height: 35px;
        }
        .modal-body {
            padding: 12px 16px;
        }
        .modal-body .form-control {
            font-size: 11px;
            height: 30px;
        }
        .content-header h1 {
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .table thead th {
            font-size: 7px;
            padding: 3px 3px;
        }
        .table tbody td {
            font-size: 9px;
            padding: 2px 3px;
        }
        .btn {
            font-size: 9px;
            padding: 2px 8px;
            height: 22px;
        }
        .table .btn-group-actions .btn {
            font-size: 8px !important;
            padding: 1px 5px !important;
            height: 18px !important;
            min-width: 22px;
        }
        .table .btn-group-actions .btn i {
            font-size: 8px !important;
        }
        .table tbody td:nth-child(4) img {
            max-width: 50px;
            max-height: 30px;
        }
        .modal-body .form-control {
            font-size: 11px;
            height: 28px;
        }
        .select2-container .select2-selection--single {
            height: 28px !important;
        }
    }

    /* ===== SCROLLBAR ===== */
    ::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }
    ::-webkit-scrollbar-track {
        background: var(--gray-100);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb {
        background: var(--gray-300);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: var(--gray-400);
    }
</style>
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
            <!-- ===== BOX HEADER ===== -->
            <div class="box-header with-border">
                <div class="header-title">
                    <i class="fa fa-pencil-square-o"> Signature Management</i> 
                </div>
                <a id="openCreateModal" data-toggle="modal">
                    <button type="button" class="btn btn-success btn-xs btn-flat">
                        <i class="fa fa-upload"></i> Upload
                    </button>
                </a>
            </div>
            
            <div class="panel-body table-responsive">
                <table class="table table-bordered table-hover" id="example1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Signature</th>
                            <th>Actions</th>
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
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form enctype="multipart/form-data" id="createForm">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-upload"></i> Upload Signature</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_id">User <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" data-live-search="true" class="form-control select2 selectpicker" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}} - {{$user->username}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="company_id">Company <span class="text-danger">*</span></label>
                        <select name="company_id" id="company_id" data-live-search="true" class="form-control select2 selectpicker" required>
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                            <option value="{{$company->id}}">{{$company->code}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="signature">Signature Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="signature" name="signature" placeholder="" required>
                        <small class="text-muted">Supported formats: JPG, PNG, GIF (Max 2MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="fa fa-check"></i> Upload
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
    <div class="modal-dialog">
        <form enctype="multipart/form-data" id="updateForm">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-pencil-square-o"></i> Update Signature</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="euser_id">User <span class="text-danger">*</span></label>
                        <select name="euser_id" id="euser_id" data-live-search="true" class="form-control select2 selectpicker" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}} - {{$user->username}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ecompany_id">Company <span class="text-danger">*</span></label>
                        <select name="ecompany_id" id="ecompany_id" data-live-search="true" class="form-control select2 selectpicker" required>
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                            <option value="{{$company->id}}">{{$company->code}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="esignature">Signature Image</label>
                        <input type="file" class="form-control" id="esignature" name="esignature" placeholder="">
                        <small class="text-muted">Leave empty to keep current signature</small>
                    </div>
                    <input type="hidden" value="" id="edit_id" name="edit_id"> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="fa fa-check"></i> Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== SCRIPTS ===== -->
<!-- ============================================================ -->
<script>document.title = 'Signature Upload';</script>
<script type="text/javascript">

    $(document).ready(function() {

        setTimeout(function() { 
            $('.sr-only').click();
        }, 0.0001);  
        
        // ===== DESTROY EXISTING DATATABLE IF ANY =====
        if ($.fn.DataTable.isDataTable('#example1')) {
            $('#example1').DataTable().destroy();
        }

        // ===== INITIALIZE DATATABLE =====
        var table = $('#example1').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-text-o"></i> CSV',
                    className: 'btn btn-info btn-xs'
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    className: 'btn btn-success btn-xs'
                }
            ],
            "ajax": {
                "url": "/json/get/user_singature",
                "type": "GET",
                "dataSrc": function(json) {
                    if (json.data && json.data.length > 0) {
                        return json.data;
                    } else {
                        return [];
                    }
                }
            },
            "columns": [
                { 
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                { "data": "user" },
                { "data": "company" },
                { 
                    "data": "image",
                    "render": function(data, type, row) {
                        if (data) {
                            return '<img src="' + data + '" alt="Signature" width="80" height="40">';
                        }
                        return '<span class="text-muted">No Image</span>';
                    }
                },
                { 
                    "data": null,
                    render: function(data, type, row) {
                        return '<div class="btn-group-actions">' +
                            '<button data-id="'+row.id+'" class="btn btn-info btn-xs btn-flat btn-edit">' +
                                '<i class="fa fa-pencil"></i>' +
                            '</button>' +
                        '</div>';
                    }
                }
            ],
            "language": {
                "emptyTable": "No records available",
                "search": "Search: ",
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
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "searching": true,
            "ordering": true,
            "paging": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "columnDefs": [
                { "targets": [0], "orderable": true, "width": "40px" },
                { "targets": [1], "orderable": true, "width": "20%" },
                { "targets": [2], "orderable": true, "width": "15%" },
                { "targets": [3], "orderable": false, "width": "25%" },
                { "targets": [4], "orderable": false, "width": "100px" }
            ],
            "rowCallback": function(row, data) {
                // You can add row styling here if needed
            }
        });

        // ============================================================
        // SEARCH INPUT STYLING
        // ============================================================
        $('.dataTables_filter input').addClass('form-control input-sm');
        $('.dataTables_filter input').css({
            'border': '1.5px solid #e2e8f0',
            'border-radius': '6px',
            'height': '28px',
            'padding': '0 10px',
            'font-size': '11px',
            'margin-left': '6px'
        });

        $('.dataTables_filter input').on('focus', function() {
            $(this).css({
                'border-color': '#4f46e5',
                'outline': 'none',
                'box-shadow': '0 0 0 3px rgba(79, 70, 229, 0.12)'
            });
        });

        $('.dataTables_filter input').on('blur', function() {
            $(this).css({
                'border-color': '#e2e8f0',
                'box-shadow': 'none'
            });
        });

        // ============================================================
        // OPEN CREATE MODAL
        // ============================================================
        $(document).on("click", "#openCreateModal", function() {
            $("#myModal").modal("show");
        });

        // ============================================================
        // LOAD EDIT MODAL
        // ============================================================
        $('#example1 tbody').on('click', '.btn-edit', function(e) {
            var edit_id = $(this).data('id');
            
            $.ajax({
                type: "GET",
                url: "{{url('/json/get/signature_edit/data')}}?edit_id=" + edit_id,
                success: function(response) {
                    var updatedUser = response.users;
                    var updatedComapany = response.companies;
                    var updatedUserId = response.updatedUserId;
                    var updatedCompanyId = response.updatedCompanyId;
                    
                    $('#euser_id').empty();
                    $('#ecompany_id').empty();
                    
                    $.each(updatedUser, function(index, user) {
                        var selected = (user.id == updatedUserId) ? 'selected' : '';
                        $('#euser_id').append('<option value="' + user.id + '" ' + selected + '>' + user.name + ' - ' + user.username + '</option>');
                    });

                    $.each(updatedComapany, function(index, company) {
                        var selected = (company.id == updatedCompanyId) ? 'selected' : '';
                        $('#ecompany_id').append('<option value="' + company.id + '" ' + selected + '>' + company.code + '</option>');
                    });

                    $('#euser_id, #ecompany_id').selectpicker('refresh');
                    $("#editModal #edit_id").val(edit_id);
                    $("#editModal").modal("show");
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to load data.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        });

        // ============================================================
        // CREATE FORM SUBMIT
        // ============================================================
        $("#createForm").submit(function(e) {
            e.preventDefault(); 
            
            $.ajax({
                type: 'POST',
                url: "{{ url('/signature')}}",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.code == 200) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Upload Successfully Done!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $(this).trigger('reset');
                        $('#user_id').val('').selectpicker('refresh');
                        $('#company_id').val('').selectpicker('refresh');
                        $("#myModal").modal("hide");
                        var table2 = $('#example1').DataTable();
                        table2.ajax.reload();
                    } else if (res.code == 500) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            confirmButtonColor: '#ef4444'
                        });
                    } else if (res.code == 404) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Already Assigned!',
                            text: 'Signature already assigned to this user.',
                            confirmButtonColor: '#f59e0b'
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to upload signature.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        });

        // ============================================================
        // UPDATE FORM SUBMIT
        // ============================================================
        $("#updateForm").submit(function(e) {
            e.preventDefault(); 
            
            $.ajax({
                type: 'POST',
                url: "{{ url('/update/signature')}}",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    console.log(res);
                    
                    if (res.code == 200) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Updated Successfully Done!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $(this).trigger('reset');
                        $('#euser_id').val('').selectpicker('refresh');
                        $('#ecompany_id').val('').selectpicker('refresh');
                        $("#editModal").modal("hide");
                        var table3 = $('#example1').DataTable();
                        table3.ajax.reload();
                    } else if (res.code == 500) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            confirmButtonColor: '#ef4444'
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update signature.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        });

    });
</script>
@endsection