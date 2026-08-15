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
        border-bottom: 2px solid rgba(17, 14, 14, 0.51) !important;
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
        border: 1px solid #222 !important;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    /* Table Body */
    .table tbody td {
        padding: 1px !important;
        border: 1px solid #201f1f !important;
        color: var(--gray-700);
        vertical-align: middle;
        text-align: center;
        font-size: 11px !important;
        transition: var(--transition);
        height: 28px;
        word-break: break-word;
        font-weight: bold !important;
        line-height: 1.42857143;
    }

    .table tbody tr {
        transition: var(--transition);
        cursor: default;
    }

    .table tbody tr:hover td {
        background-color: rgba(101, 212, 97, 0.836) !important;
    }

    .table tbody tr:nth-child(even) td {
        background: #fafafa;
    }
    .table tbody tr:nth-child(odd) td {
        background: #ffffff;
    }
    .table tbody tr:last-child td { border-bottom: 1px solid #201f1f !important; }

    /* ===== COLUMN WIDTH (Content based) ===== */
    .table thead th:nth-child(1) { width: 50px; }  /* ID */
    .table thead th:nth-child(2) { width: 12%; }  /* Code */
    .table thead th:nth-child(3) { width: 30%; }  /* Name */
    .table thead th:nth-child(4) { width: 25%; }  /* BUH Name */
    .table thead th:nth-child(5) { width: 180px; }/* Controls */

    /* Text Alignment - Center all, Left for Name & BUH Name */
    .table tbody td:nth-child(3),
    .table tbody td:nth-child(4) {
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

    .table .btn-group-actions .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        color: white !important;
    }
    .table .btn-group-actions .btn-primary:hover { transform: scale(1.05); }

    .table .btn-group-actions .btn-info {
        background: linear-gradient(135deg, var(--info) 0%, #0284c7 100%) !important;
        color: white !important;
    }
    .table .btn-group-actions .btn-info:hover { transform: scale(1.05); }

    .table .btn-group-actions .btn-danger {
        background: linear-gradient(135deg, var(--danger) 0%, var(--danger-dark) 100%) !important;
        color: white !important;
    }
    .table .btn-group-actions .btn-danger:hover { transform: scale(1.05); }

    /* ===== PAGINATION ===== */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0 4px 0;
        flex-wrap: wrap;
        gap: 8px;
    }

    .pagination-container .page-info {
        font-size: 11px;
        color: var(--gray-500);
        font-weight: 500;
    }

    .pagination-container .pagination {
        margin: 0;
        display: flex;
        gap: 3px;
        flex-wrap: wrap;
    }

    .pagination-container .pagination .page-item .page-link {
        padding: 3px 10px;
        font-size: 11px;
        border-radius: var(--radius);
        border: 1.5px solid var(--gray-200);
        color: var(--gray-600);
        background: white;
        transition: var(--transition);
        line-height: 1.4;
    }

    .pagination-container .pagination .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .pagination-container .pagination .page-item .page-link:hover:not(.active) {
        background: var(--gray-50);
        border-color: var(--gray-300);
    }

    .pagination-container .pagination .page-item.disabled .page-link {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* ===== MODAL ===== */
    .modal-content {
        border-radius: var(--radius-lg);
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        overflow: hidden;
    }

    .modal-header {
        padding: 12px 20px;
        background: linear-gradient(135deg, var(--danger) 0%, var(--danger-dark) 100%);
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
        text-align: center;
    }

    .modal-body .delete-icon {
        font-size: 48px;
        color: var(--danger);
        display: block;
        margin-bottom: 12px;
    }

    .modal-body h4 {
        color: var(--gray-700);
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 4px;
    }

    .modal-body .delete-text {
        color: var(--gray-500);
        font-size: 12px;
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

    .modal-footer .btn-danger {
        background: var(--danger) !important;
    }
    .modal-footer .btn-danger:hover {
        background: var(--danger-dark) !important;
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

    /* ===== BU BADGES ===== */
    .bu-code-badge {
        background: var(--gray-100);
        padding: 3px 12px;
        border-radius: 12px;
        font-weight: 600;
        color: var(--gray-700);
        font-size: 10px;
        letter-spacing: 0.5px;
        border: 1px solid var(--gray-200);
        display: inline-block;
    }

    .bu-name-badge {
        background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
        padding: 4px 14px;
        border-radius: 12px;
        font-weight: 600;
        color: white;
        font-size: 11px;
        letter-spacing: 0.3px;
        display: inline-block;
        box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
    }

    .bu-name-badge i {
        margin-right: 4px;
    }

    .buh-name-badge {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        padding: 4px 14px;
        border-radius: 12px;
        font-weight: 600;
        color: white;
        font-size: 11px;
        letter-spacing: 0.3px;
        display: inline-block;
        box-shadow: 0 2px 4px rgba(245, 158, 11, 0.2);
    }

    .buh-name-badge i {
        margin-right: 4px;
    }

    .bu-id-badge {
        background: var(--gray-200);
        padding: 2px 10px;
        border-radius: 12px;
        font-weight: 600;
        color: var(--gray-600);
        font-size: 10px;
        display: inline-block;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .box-header.with-border {
            flex-direction: column;
            align-items: stretch;
        }
        .box-header.with-border .header-title {
            margin-right: 0;
        }
        .modal-dialog {
            width: 95%;
            margin: 10px auto;
        }
        .table {
            font-size: 10px !important;
            min-width: 450px;
        }
        .table thead th {
            font-size: 8px !important;
            padding: 4px 4px !important;
        }
        .table tbody td {
            font-size: 10px !important;
            padding: 3px 4px !important;
            height: 24px;
        }
        .pagination-container {
            flex-direction: column;
            align-items: center;
        }
        .modal-body {
            padding: 12px 16px;
        }
        .content-header h1 {
            font-size: 16px;
        }
        .content-header > .breadcrumb {
            float: none;
            text-align: right;
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
            height: 22px;
        }
        .btn {
            font-size: 9px;
            padding: 2px 8px;
            height: 22px;
        }
        .pagination-container .pagination .page-item .page-link {
            padding: 2px 6px;
            font-size: 9px;
        }
        .table .btn-group-actions .btn {
            font-size: 8px !important;
            padding: 1px 4px !important;
            height: 18px !important;
            min-width: 22px;
        }
        .table .btn-group-actions .btn i {
            font-size: 8px !important;
        }
        .bu-name-badge,
        .buh-name-badge {
            font-size: 9px;
            padding: 3px 10px;
        }
        .bu-code-badge {
            font-size: 8px;
            padding: 2px 8px;
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
                <strong><i class="fa fa-check-circle"></i> Success!</strong> {{ Session::get('success') }}
            </div> 
        @endif 
        
        @if(Session::has('danger'))
            <div class="callout callout-danger">
                <strong><i class="fa fa-exclamation-triangle"></i> Unsuccessful!</strong> {{ Session::get('danger') }}
            </div> 
        @endif 

        <div class="box box-primary">
            <!-- ===== BOX HEADER ===== -->
            <div class="box-header with-border">
                <div class="header-title">
                    <i class="fa fa-building"></i> Business Management
                </div>
                <a href="{{url('/bu/create')}}">
                    {{-- @if($viewPermissions->can_create) --}}
                    <button class="btn btn-success btn-xs btn-flat">
                        <i class="fa fa-plus"></i> Create Business Unit
                    </button>
                    {{-- @endif --}}
                </a>
            </div>

            <div class="panel-body table-responsive">
                <table class="table table-bordered table-responsive table-condenced" id="example1">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>BUH Name</th>
                            <th>Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($bus->isEmpty())
                            <tr>
                                <td colspan="5" style="text-align:center; padding:30px 0; color:var(--gray-500); font-weight:normal !important;">
                                    <i class="fa fa-building-o" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                    No business units found. Click "Create Business Unit" to add one.
                                </td>
                            </tr>
                        @else
                            @foreach ($bus as $bu)
                            <tr>
                                <td><span class="bu-id-badge">#{{ $bu->id }}</span></td>
                                <td><span class="bu-code-badge">{{ $bu->code ? $bu->code : 'N/A' }}</span></td>
                                <td>
                                    <span class="bu-name-badge">
                                        <i class="fa fa-building"></i>
                                        {{ $bu->name ? $bu->name : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="buh-name-badge">
                                        <i class="fa fa-user-tie"></i>
                                        {{ $bu->buh_name ? $bu->buh_name : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group-actions">
                                        {{-- @if($viewPermissions->can_view) --}}
                                        <a href="{{ url('/bu/'.$bu->id) }}" title="View Details">
                                            <button type="button" class="btn btn-primary btn-xs btn-flat">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </a>
                                        {{-- @endif --}}
                                        
                                        {{-- @if($viewPermissions->can_update) --}}
                                        <a href="{{ url('/bu/'.$bu->id.'/edit') }}" title="Edit Business Unit">
                                            <button type="button" class="btn btn-info btn-xs btn-flat">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                        </a>
                                        {{-- @endif --}}
                                        
                                        {{-- @if($viewPermissions->can_delete) --}}
                                        <a id="openDeleteModal" data-toggle="modal" data-id="{{ $bu->id }}" data-name="{{ $bu->name }}" title="Delete Business Unit">
                                            <button type="button" class="btn btn-danger btn-xs btn-flat">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </a>
                                        {{-- @endif --}}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <!-- ===== PAGINATION ===== -->
                @if(isset($bus) && method_exists($bus, 'links'))
                <div class="pagination-container">
                    <div class="page-info">
                        Showing {{ $bus->firstItem() ? $bus->firstItem() : 0 }} 
                        to {{ $bus->lastItem() ? $bus->lastItem() : 0 }} 
                        of {{ $bus->total() ? $bus->total() : 0 }} entries
                    </div>
                    <div class="pagination">
                        {{ $bus->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== DELETE MODAL ===== -->
<!-- ============================================================ -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form class="form-horizontal" id="delete_modal_form" role="form" method="POST" action="">
            {{ csrf_field() }}
            {{ method_field("DELETE") }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Delete Business Unit</h4>
                </div>
                <div class="modal-body">
                    <i class="fa fa-trash-o delete-icon"></i>
                    <h4>Are you sure?</h4>
                    <p class="delete-text">This action cannot be undone. This will permanently delete the business unit.</p>
                    <input id="delete_id" type="hidden" name="id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-check"></i> Yes, Delete
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== SCRIPTS ===== -->
<!-- ============================================================ -->
<script>document.title = 'Business Units';</script>
<script type="text/javascript">
    setTimeout(function() { 
        $('.sr-only').click();
    }, 0.0001);
    // ===== DELETE MODAL HANDLER =====
    $(document).on("click", "#openDeleteModal", function (e) {
        e.preventDefault();
        var delId = $(this).data("id");
        var buName = $(this).data("name") || "this business unit";
        
        $("#delete_modal_form").attr("action", "{{ url('/bu') }}/" + delId);
        $(".modal-body #delete_id").val(delId);
        $(".modal-body .delete-text").html(
            'You are about to delete <strong>"' + buName + '"</strong>. This action cannot be undone.'
        );
        $("#myModal").modal("show");
    });

</script>
@endsection