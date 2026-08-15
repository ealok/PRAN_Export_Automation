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

    .btn-xs {
        padding: 2px 8px;
        font-size: 10px;
        height: 22px;
        border-radius: 4px;
    }

    .btn-flat { border-radius: var(--radius); }

    /* ===== TABLE - COMPACT & PROFESSIONAL ===== */
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
        font-size: 11px !important;
        border-radius: var(--radius);
        overflow: hidden;
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
    .table thead th:nth-child(1) { width: 40px; }  /* # */
    .table thead th:nth-child(2) { width: auto; }  /* Name */
    .table thead th:nth-child(3) { width: auto; }  /* Description */
    .table thead th:nth-child(4) { width: 100px; }/* Actions */

    /* Text Alignment - Center all, Left for Name & Description */
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
        padding: 2px 8px !important;
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
        .box-header.with-border .header-title {
            margin-right: 0;
        }
        .table {
            font-size: 10px !important;
        }
        .table thead th {
            font-size: 8px !important;
            padding: 4px 4px !important;
        }
        .table tbody td {
            font-size: 10px !important;
            padding: 3px 4px !important;
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
                    <i class="fa fa-truck"></i> Transport Agency Management
                </div>
                <a href="{{url('/transportagency/create')}}">
                    <button class="btn btn-success btn-xs btn-flat">
                        <i class="fa fa-plus"></i> Create
                    </button>
                </a>
            </div>

            <div class="panel-body table-responsive">
                <table class="table table-bordered table-hover" id="example1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($results as $result)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td><strong>{{ $result->transport_agency_info ? $result->transport_agency_info : 'N/A' }}</strong></td>
                            <td>{{ $result->description ? $result->description : 'N/A' }}</td>
                            <td>
                                <div class="btn-group-actions">
                                    <a href="{{ url('/transportagency/'.$result->id.'/edit') }}" title="Edit">
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
<!-- ===== SCRIPTS ===== -->
<!-- ============================================================ -->
<script>document.title = 'Transport Agency | Home';</script>
<script type="text/javascript">
    setTimeout(function() { 
        $('.sr-only').click();
    }, 0.0001);

    $(document).ready(function() {
        // ===== DESTROY EXISTING DATATABLE IF ANY =====
        if ($.fn.DataTable.isDataTable('#example1')) {
            $('#example1').DataTable().destroy();
        }

        // ===== INITIALIZE DATATABLE =====
        var table = $('#example1').DataTable({
            "paging": false,
            "searching": true,
            "info": false,
            "ordering": true,
            "order": [[0, 'asc']],
            "language": {
                "search": "Search: ",
                "zeroRecords": "No records found",
                "emptyTable": "No records available"
            },
            "columnDefs": [
                { "targets": [0], "orderable": true, "width": "40px" },
                { "targets": [1], "orderable": true, "width": "30%" },
                { "targets": [2], "orderable": true, "width": "auto" },
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