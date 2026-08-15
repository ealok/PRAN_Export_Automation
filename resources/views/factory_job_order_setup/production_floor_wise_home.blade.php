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

    .btn-secondary {
        background: white;
        color: var(--gray-600);
        border: 1.5px solid var(--gray-200);
    }
    .btn-secondary:hover {
        background: var(--gray-50);
    }

    .btn-xs {
        padding: 2px 8px;
        font-size: 10px;
        height: 22px;
        border-radius: 4px;
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
        min-width: 500px;
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
    .table thead th:nth-child(1) { width: 40px; }  /* SL# */
    .table thead th:nth-child(2) { width: 35%; }  /* Production Floor */
    .table thead th:nth-child(3) { width: 35%; }  /* User */
    .table thead th:nth-child(4) { width: 100px; }/* Action */

    /* Text Alignment - Center all, Left for Production Floor & User */
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

    .modal-footer .btn-primary {
        background: var(--primary) !important;
    }
    .modal-footer .btn-primary:hover {
        background: var(--primary-dark) !important;
    }
    .modal-footer .btn-secondary {
        background: white;
        color: var(--gray-600);
        border: 1.5px solid var(--gray-200);
    }
    .modal-footer .btn-secondary:hover {
        background: var(--gray-50);
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
            min-width: 400px;
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
        .modal-body .form-control {
            font-size: 11px;
            height: 30px;
        }
        .select2-container .select2-selection--single {
            height: 30px !important;
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

    /* ===== LABEL STYLE ===== */
    .setup-label {
        position: absolute;
        top: -18px;
        left: 40px;
        background: var(--warning);
        color: #000;
        padding: 8px 24px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        z-index: 5;
    }
</style>

<!-- ===== MAIN CONTENT ===== -->
<div class="row" style="margin-top: -10px;">
    <div class="col-md-12">
        @if(Session::has('success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> {{ Session::get('success') }}
            </div>
        @endif 
        @if(Session::has('danger'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Alert!</strong> {{ Session::get('danger') }}
            </div>
        @endif 
        <div class="box box-primary" style="position: relative;">
            <!-- ===== BOX HEADER ===== -->
            <div class="box-header with-border" style="padding-top: 28px;">
                <div class="header-title">
                    <i class="fa fa-truck"></i> Production Floor Management
                </div>
                <div style="flex:1;"></div>
                <button class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-plus"></i> Setup Create
                </button>
            </div>

            <div class="panel-body table-responsive">
                <table class="table table-bordered table-hover" id="example1">
                    <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th>Production Floor</th>
                            <th>User</th>
                            <th style="width:100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($results as $result)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td><strong>{{ $result->p_code }} / {{ $result->p_name }}</strong></td>
                            <td>{{ $result->user_name }} / {{ $result->staff_id }}</td>
                            <td>
                                <div class="btn-group-actions">
                                    <a href="#" title="Edit">
                                        <button type="button" class="btn btn-info btn-xs btn-flat">
                                            <i class="fa fa-pencil"></i>
                                        </button>
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
<!-- ===== CREATE MODAL ===== -->
<!-- ============================================================ -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus-circle"></i> Create Setup</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="user_id" class="col-form-label">User <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" data-live-search="true" class="form-control select2 selectpicker" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->username}} || {{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="p_floor_id" class="col-form-label">Production Floor <span class="text-danger">*</span></label>
                        <select name="p_floor_id" id="p_floor_id" data-live-search="true" class="form-control select2 selectpicker" required>
                            <option value="">Select Production Floor</option>
                            @foreach($productionFloors as $productionFloor)
                            <option value="{{$productionFloor->id}}">{{$productionFloor->p_code}} → {{$productionFloor->p_name}} ({{$productionFloor->short_name}})</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Close
                </button>
                <button type="button" class="btn btn-primary" onclick="onSaveProductionFloorDetals()">
                    <i class="fa fa-check"></i> Create
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== SCRIPTS ===== -->
<!-- ============================================================ -->
<script>document.title = 'Production Floor | Management';</script>
<script type="text/javascript">
    setTimeout(function() { 
        $('.sr-only').click();
    }, 0.0001);
    function onSaveProductionFloorDetals() {
        var user_id = $('#user_id').val();
        var p_floor_id = $('#p_floor_id').val();
        var url = "{{url('/json/saveProduction/floor/details')}}?user_id=" + user_id + "&p_floor_id=" + p_floor_id;
        
        if (user_id == "" || p_floor_id == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Alert!',
                text: 'Please select both User and Production Floor.',
                confirmButtonColor: '#4f46e5'
            });
            return;
        }

        $.get(url, function(data) {
            console.log(data);
            if (data == 'Success') {
                $('#exampleModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Setup created successfully!',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else if (data == 'created') {
                $('#exampleModal').modal('hide');
                Swal.fire({
                    icon: 'warning',
                    title: 'Already Exists!',
                    text: 'This setup has already been created.',
                    confirmButtonColor: '#f59e0b'
                });
            } else {
                $('#exampleModal').modal('hide');
                Swal.fire({
                    icon: 'error',
                    title: 'Failed!',
                    text: 'Failed to create setup. Please try again.',
                    confirmButtonColor: '#ef4444'
                });
            }
        });
    }

    $(document).ready(function() {
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
                { "targets": [1], "orderable": true, "width": "35%" },
                { "targets": [2], "orderable": true, "width": "35%" },
                { "targets": [3], "orderable": false, "width": "100px" }
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
    });
</script>
@endsection