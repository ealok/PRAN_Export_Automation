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
    .panel {
        border-radius: var(--radius-lg);
        background: #ffffff;
        border-top: 4px solid var(--primary);
        margin-bottom: 20px;
        width: 100%;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: none;
    }

    .panel-default { border-color: #e5e7eb; }
    .panel-default > .panel-heading {
        background: linear-gradient(135deg, var(--gray-50) 0%, #ffffff 100%);
        border-bottom: 1px solid var(--gray-200);
        padding: 12px 18px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        color: var(--gray-800);
        font-weight: 600;
        font-size: 14px;
        border-color: #e5e7eb;
    }

    .panel-default > .panel-heading i {
        color: var(--primary);
        font-size: 16px;
        margin-right: 8px;
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

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(79, 70, 229, 0.3);
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

    .btn-xs {
        padding: 2px 8px;
        font-size: 10px;
        height: 22px;
        border-radius: 4px;
    }

    .btn-flat { border-radius: var(--radius); }

    .pull-right { float: right !important; }

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
        min-width: 700px;
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
    .table thead th:nth-child(1) { width: 40px; }  /* Sl */
    .table thead th:nth-child(2) { width: 20%; }  /* Admin Name */
    .table thead th:nth-child(3) { width: 20%; }  /* Email */
    .table thead th:nth-child(4) { width: 10%; }  /* Head */
    .table thead th:nth-child(5) { width: 80px; } /* Access */
    .table thead th:nth-child(6) { width: 160px; }/* Details */

    /* Text Alignment - Center all, Left for Name & Email */
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

    .table .btn-group-actions .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        color: white !important;
    }
    .table .btn-group-actions .btn-primary:hover { transform: scale(1.05); }

    /* ===== ROW STATUS ===== */
    .row-inactive td {
        background-color: #fef2f2 !important;
        border-left: 3px solid var(--danger);
    }
    .row-inactive td:first-child { border-left: none; }
    .row-inactive:hover td { background-color: #fee2e2 !important; }

    .row-active td {
        background-color: #f0fdf4 !important;
        border-left: 3px solid var(--success);
    }
    .row-active td:first-child { border-left: none; }
    .row-active:hover td { background-color: #dcfce7 !important; }

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

    .modal-body .help-block {
        color: var(--danger);
        font-size: 11px;
        margin-top: 3px;
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

    .modal-footer .btn-primary {
        background: var(--primary) !important;
    }
    .modal-footer .btn-primary:hover {
        background: var(--primary-dark) !important;
    }
    .modal-footer .btn-default {
        background: white;
        color: var(--gray-600);
        border: 1.5px solid var(--gray-200);
    }
    .modal-footer .btn-default:hover {
        background: var(--gray-50);
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

    /* ===== ALERT ===== */
    .alert {
        border-radius: var(--radius);
        padding: 12px 18px;
        margin-bottom: 16px;
    }
    .alert-success {
        background: #ecfdf5;
        border-left: 4px solid var(--success);
        color: #065f46;
    }
    .alert-danger {
        background: #fef2f2;
        border-left: 4px solid var(--danger);
        color: #991b1b;
    }

    .alert .close {
        float: right;
        font-size: 18px;
        font-weight: 700;
        line-height: 1;
        color: inherit;
        opacity: 0.6;
        text-decoration: none;
        cursor: pointer;
    }
    .alert .close:hover {
        opacity: 1;
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
        .panel-default > .panel-heading {
            flex-direction: column;
            align-items: stretch;
        }
        .modal-dialog {
            width: 95%;
            margin: 10px auto;
        }
        .table {
            font-size: 10px !important;
            min-width: 600px;
        }
        .table thead th {
            font-size: 8px !important;
            padding: 4px 4px !important;
        }
        .table tbody td {
            font-size: 10px !important;
            padding: 3px 4px !important;
        }
        .modal-body {
            padding: 12px 16px;
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

    /* ===== UTILITY ===== */
    .text-muted { color: var(--gray-400); }
    .fw-600 { font-weight: 600; }
</style>

<!-- ===== MAIN CONTENT ===== -->
<div class="row">
    <div class="col-md-11">
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <strong>Success !</strong> {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::has('danger'))
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <strong>Alert !</strong> {{ Session::get('danger') }}
            </div>
        @endif

        <div class="panel panel-default">
            <!-- ===== PANEL HEADER ===== -->
            <div class="panel-heading">
                <span><i class="fa fa-users"></i>User's Management</span>
            </div>

            <div class="panel-body table-responsive">
                <table class="table table-bordered table-hover" id="example1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Admin Name</th>
                            <th>Email</th>
                            <th>Head</th>
                            <th>Access</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($admins as $admin)
                        <tr class="{{ $admin->active == '0' ? 'row-inactive' : 'row-active' }}">
                            <td>{{ $i++ }}</td>
                            <td><strong>{{ $admin->username }} - {{ $admin->name }}</strong></td>
                            <td>{{ $admin->email }}</td>
                            <td>—</td>
                            <td>
                                <div class="btn-group-actions">
                                    <a href="/admin/access/{{ $admin->id }}">
                                        <button type="button" class="btn btn-info btn-xs btn-flat">
                                            <i class="fa fa-key"></i>
                                        </button>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group-actions">
                                    <a href="/admin/{{ $admin->id }}/edit">
                                        <button type="button" class="btn btn-info btn-xs btn-flat">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </a>
                                    <a data-toggle="modal" data-id="{{ $admin->id }}" class="open-AddBookDialog btn btn-primary btn-xs btn-flat" href="#resetPasswordModal">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== RESET PASSWORD MODAL ===== -->
<!-- ============================================================ -->
<div class="modal fade" id="resetPasswordModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-refresh"></i> Reset Password</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/reset_password') }}">
                    {{ csrf_field() }}
                    
                    <input type="hidden" id="admin_id" name="id">
                    
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">New Password <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" placeholder="Enter new password">
                            @if ($errors->has('password'))
                                <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm" class="col-md-4 control-label">Confirm Password <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('admin_password') ? ' has-error' : '' }}">
                        <label for="admin_password" class="col-md-4 control-label">Your Password <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input id="admin_password" type="password" class="form-control" name="admin_password" placeholder="Enter your admin password">
                            @if ($errors->has('admin_password'))
                                <span class="help-block"><strong>{{ $errors->first('admin_password') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary btn-flat">
                                <i class="fa fa-check"></i> Reset Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
<script>document.title = "Users | Management";</script>
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
            "paging": true,
            "searching": true,
            "info": true,
            "ordering": true,
            "order": [[0, 'asc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "language": {
                "search": "Search: ",
                "zeroRecords": "No records found",
                "emptyTable": "No records available",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "lengthMenu": "Show _MENU_ entries",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                }
            },
            "columnDefs": [
                { "targets": [0], "orderable": true, "width": "40px" },
                { "targets": [1], "orderable": true, "width": "20%" },
                { "targets": [2], "orderable": true, "width": "20%" },
                { "targets": [3], "orderable": false, "width": "10%" },
                { "targets": [4], "orderable": false, "width": "80px" },
                { "targets": [5], "orderable": false, "width": "160px" }
            ],
            "autoWidth": false,
            "responsive": true
        });

        // ===== SEARCH INPUT STYLING =====
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

        // ===== MODAL HANDLER =====
        $(document).on("click", ".open-AddBookDialog", function () {
            var Id = $(this).data('id');
            $(".modal-body #admin_id").val(Id);
            $('#resetPasswordModal').modal('show');
        });
    });
</script>
@endsection