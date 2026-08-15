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

    .btn-info {
        background: linear-gradient(135deg, var(--info) 0%, #0284c7 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(14, 165, 233, 0.2);
    }
    .btn-info:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(14, 165, 233, 0.3);
    }

    .btn-success {
        background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }
    .btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
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
    .table thead th:nth-child(2) { width: 35%; }  /* Line Name */
    .table thead th:nth-child(3) { width: 30%; }  /* License Number */
    .table thead th:nth-child(4) { width: 100px; }/* Actions */

    /* Text Alignment - Center all, Left for Name & License */
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

    .table .btn-group-actions .btn-success {
        background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%) !important;
        color: white !important;
    }
    .table .btn-group-actions .btn-success:hover { transform: scale(1.05); }

    /* ===== MODAL ===== */
    .modal-content {
        border-radius: var(--radius-lg);
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        overflow: hidden;
        padding: 0 !important;
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
        .modal-body .form-control {
            font-size: 11px;
            height: 30px;
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
            height: 28px;
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

<!-- ===== BREADCRUMB ===== -->
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{url('/pfp')}}"><i class="fa fa-ship"></i> Shipping Line</a></li>
    </ol>
    <br>
</section>

<!-- ===== MAIN CONTENT ===== -->
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <!-- ===== BOX HEADER ===== -->
            <div class="box-header with-border">
                <div class="header-title">
                    <i class="fa fa-ship"></i> Shipping Line List
                </div>
                <button class="btn btn-info btn-xs btn-flat" id="permission_btn_id">
                    <i class="fa fa-plus"></i> Add New
                </button>
            </div>

            <div class="panel-body table-responsive">
                <table class="table table-bordered table-hover" id="example1">
                    <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th>Line Name</th>
                            <th>License Number</th>
                            <th style="width:100px;">Actions</th>
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
    <div class="modal-dialog">
        <form enctype="multipart/form-data" id="SubmitFormId">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Create Shipping Line</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="shipping_name">Shipping Line Name <span class="text-danger">*</span></label>
                        <input type="text" name="shipping_name" id="shipping_name" class="form-control" placeholder="Enter Shipping Line Name">
                    </div>
                    <div class="form-group">
                        <label for="license_number">License Number <span class="text-danger">*</span></label>
                        <input type="text" name="license_number" id="license_number" class="form-control" placeholder="Enter License Number">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="fa fa-check"></i> Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== UPDATE MODAL ===== -->
<!-- ============================================================ -->
<div id="updateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form enctype="multipart/form-data" id="updateFormId">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-pencil-square-o"></i> Update Shipping Line</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="eshipping_name">Shipping Line Name <span class="text-danger">*</span></label>
                        <input type="text" name="shipping_name" id="eshipping_name" class="form-control" placeholder="Enter Shipping Line Name">
                    </div>
                    <div class="form-group">
                        <label for="elicense_number">License Number <span class="text-danger">*</span></label>
                        <input type="text" name="license_number" id="elicense_number" class="form-control" placeholder="Enter License Number">
                    </div>
                    <input type="hidden" class="form-control" id="edit_id" name="edit_id">
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
<script>document.title = 'Shipping Line | Details';</script>
<script type="text/javascript">
    
    setTimeout(function() { 
        $('.sr-only').click();
    }, 0.0001);  

    $(document).ready(function() {   

        // ============================================================
        // CREATE FORM SUBMIT
        // ============================================================
        $("#SubmitFormId").submit(function(e) {
            e.preventDefault(); 
            $.ajax({
                type: 'POST',
                url: "{{ url('/shipping_line')}}",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    var table1 = $('#example1').DataTable();
                    table1.ajax.reload();
                    $('#shipping_name').val(""); 
                    $('#license_number').val(""); 
                    $("#createModal").modal("hide");
                    
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Created Successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(data) {
                    console.log(data);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to create shipping line.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });   
        });

        // ============================================================
        // UPDATE FORM SUBMIT
        // ============================================================
        $("#updateFormId").submit(function(e) {
            e.preventDefault(); 
            $.ajax({
                type: 'POST',
                url: "{{ url('/shipping_line/update')}}",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('#eshipping_name').val(""); 
                    $('#elicense_number').val(""); 
                    $("#updateModal").modal("hide");
                    var table2 = $('#example1').DataTable();
                    table2.ajax.reload();
                    
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Updated Successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(data) {
                    console.log(data);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update shipping line.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });   
        });

        // ============================================================
        // OPEN CREATE MODAL
        // ============================================================
        $('#permission_btn_id').click(function(e) {   
            e.preventDefault();
            $("#createModal").modal("show");
        });

        // ============================================================
        // SHOW SHIPPING LINE DETAILS
        // ============================================================
        function showShippingLinedetails() {
            $(".preload").show();
            
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }
            
            var table = $('#example1').DataTable({
                "ajax": {
                    "url": "/json/get/shipping/line_details",
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
                    { "data": "shipping_name" },
                    { "data": "license_number" },
                    { 
                        "data": null,
                        render: function(data, type, row) {
                            return '<div class="btn-group-actions">' +
                                '<button data-id="'+row.id+'" class="btn btn-success btn-xs btn-flat edit_data_id">' +
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
                    { "targets": [1], "orderable": true, "width": "35%" },
                    { "targets": [2], "orderable": true, "width": "30%" },
                    { "targets": [3], "orderable": false, "width": "100px" }
                ],
                "rowCallback": function(row, data) {
                    // You can add row styling here if needed
                },
                "drawCallback": function() {
                    $(".preload").hide();
                }
            });
        }

        // ============================================================
        // INITIALIZE TABLE
        // ============================================================
        showShippingLinedetails();

        // ============================================================
        // EDIT BUTTON CLICK
        // ============================================================
        $('#example1 tbody').on('click', '.edit_data_id', function(e) {
            e.preventDefault();
            var edit_id = $(this).data('id');
            
            if (edit_id) {
                $.ajax({
                    url: "{{url('/json/get/edit_details')}}",
                    type: "get",
                    dataType: "json",
                    data: {
                        'edit_id': edit_id,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(res) {
                        $('#eshipping_name').val(res.data.shipping_name);  
                        $('#elicense_number').val(res.data.license_number);  
                        $('#edit_id').val(res.edit_id);
                        $("#updateModal").modal("show");
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
            }
        });

        // ============================================================
        // SEARCH INPUT STYLING
        // ============================================================
        $(document).on('init.dt', function() {
            $('.dataTables_filter input').addClass('form-control input-sm');
            $('.dataTables_filter input').css({
                'border': '1.5px solid #e2e8f0',
                'border-radius': '6px',
                'height': '28px',
                'padding': '0 10px',
                'font-size': '11px',
                'margin-left': '6px'
            });
        });

    });
</script>
@endsection