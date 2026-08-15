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
        min-width: 550px;
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
    .table thead th:nth-child(2) { width: 25%; }  /* Category */
    .table thead th:nth-child(3) { width: 30%; }  /* Subcategory */
    .table thead th:nth-child(4) { width: 140px; }/* Actions */

    /* Text Alignment - Center all, Left for Name */
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
        margin-bottom: 12px;
    }

    .modal-body .form-group label {
        font-size: 11px;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 3px;
        display: block;
        letter-spacing: 0.3px;
    }

    .modal-body .form-control {
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

    .modal-body .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    .modal-body .form-control:hover {
        border-color: var(--gray-400);
    }

    .modal-body .radio-inline {
        margin-right: 15px;
        font-weight: 500;
        color: var(--gray-700);
        font-size: 12px;
    }

    .modal-body .radio-inline input[type="radio"] {
        margin-right: 4px;
        accent-color: var(--primary);
    }

    /* ===== SELECT2 OVERRIDE ===== */
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
        line-height: 28px !important;
        padding-left: 0 !important;
        font-size: 12px !important;
        color: var(--gray-700) !important;
    }

    .select2-container .select2-selection--single .select2-selection__arrow {
        height: 30px !important;
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

    /* ===== ERROR MESSAGE ===== */
    .text-danger {
        color: var(--danger) !important;
        font-size: 11px;
        margin-top: 3px;
        display: block;
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
                    <i class="fa fa-tags"> Subcategories Management</i> 
                </div>
                <button class="btn btn-success btn-xs btn-flat" id="add_new">
                    <i class="fa fa-plus"></i> Add New
                </button>
            </div>

            <div class="panel-body table-responsive">
                <table class="table table-bordered table-hover" id="example1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Subcategory</th>
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
<div id="createModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form class="form-horizontal" id="create_form">
            {{csrf_field()}}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Add New Subcategory</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" data-live-search="true" class="form-control select2 selectpicker" type="select">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>  
                                    @endforeach
                                </select>
                                <span class="text-danger" id="category_id_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Subcategory Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Subcategory Name" value="">
                                <span class="text-danger" id="name_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-info btn-sm">
                        <i class="fa fa-check"></i> Add New
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
        <form class="form-horizontal" id="update_form">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-pencil-square-o"></i> Update Subcategory</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="from_date">From Date</label>
                                <input name="from_date" type="text" id="from_date" class="form-control datepicker" placeholder="Enter From Date" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="to_date">To Date</label>
                                <input name="to_date" type="text" id="to_date" class="form-control datepicker" placeholder="Enter To Date" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cvr_rate">CVR Rate</label>
                                <input name="cvr_rate" type="number" id="cvr_rate" class="form-control" placeholder="Enter Conversion Rate" value="" step="any">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="N" id="active"> Active
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="Y" id="inactive"> Inactive
                                </label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="editId" name="editId" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-info btn-sm">
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
<script>document.title = 'SubCategories';</script>
<script type="text/javascript">
   
    setTimeout(function() { 
        $('.sr-only').click();
    }, 0.0001);

    $(document).ready(function(){
         
        function getListOfCategory(){
            
            $('#example1').dataTable().fnDestroy(); 
            var table = $('#example1').DataTable({
                "ajax": {
                    url: "{{ route('subcategories.getSubList') }}",
                    "type": "GET",
                    "dataSrc": function (json) {
                        if(json.data.length > 0) {
                            return json.data;
                        } else {
                            return false;
                        }
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "category" },
                    { "data": "sub_category" },
                    { 
                        "data": null,
                        render: function(data, type, row){
                            return '<div class="btn-group-actions">' +
                                '<button data-id="'+row.id+'" class="btn btn-info btn-xs btn-edit" disabled>' +
                                    '<i class="fa fa-pencil"></i>' +
                                '</button>' +
                            '</div>';
                        }
                    }
                ],
                "language": {
                    "emptyTable": "No records available"
                }
            });
        }  
        
        getListOfCategory();

        $('#add_new').click(function(){
            $('#createModal').modal('show');
        });

        // ============================================================
        // CREATE MODAL SUBMIT
        // ============================================================
        $("#create_form").submit(function (e) {
            e.preventDefault(); 
            $.ajax({
                type: 'POST',
                url: "{{route('subcategories.store')}}",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('span.text-danger').text('');
                    
                    if (res.errors) {
                        $.each(res.errors, function (key, value) {
                            $('#' + key + '_error').text(value[0]);
                        });
                    } 

                    if(res.code == 200){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Create Successfully Done..!!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $(this).trigger('reset');
                        $('#category_id').val('').selectpicker('refresh');
                        var table2 = $('#example1').DataTable();
                        table2.ajax.reload(null, false);
                        table2.draw(false); 
                        $('#createModal').modal('hide');
                    } else if(res.code == 500){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
                        $(this).trigger('reset');
                    }
                },
                error: function(data){
                    console.log(data);
                }
            });
        });

        // ============================================================
        // LOAD EDIT MODAL
        // ============================================================
        $('#example1').on('click', '.btn-edit', function(event) {
            event.preventDefault();
            $.ajax({
                url: '/json/get/cvr/edit_data',
                method: 'GET',
                data: { id: $(this).data('id') },
                success: function(response) {
                    console.log(response);
                    $('#editId').val(response.data[0].id);
                    $('#from_date').val(response.data[0].from_date);
                    $('#to_date').val(response.data[0].to_date);
                    $('#cvr_rate').val(response.data[0].cvr_rate);
                    
                    if(response.data[0].status == 'N') {
                        $('#active').prop('checked', true);
                    } else {
                        $('#inactive').prop('checked', true);
                    }
                    
                    $('#editModal').modal('show'); 
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch data:', error);
                }
            });
        });

        // ============================================================
        // UPDATE MODAL SUBMIT
        // ============================================================
        $("#update_form").submit(function (e) {
            e.preventDefault(); 
            $.ajax({
                type: 'POST',
                url: "{{ url('/update/cvr')}}",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if(res.status == "success"){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Update Successfully Done..!!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        var table2 = $('#example1').DataTable();
                        table2.ajax.reload(null, false);
                        table2.draw(false); 
                        $('#editModal').modal('hide');
                    } else {
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

        // ============================================================
        // DATEPICKER INITIALIZE
        // ============================================================
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

    });
</script>
@endsection