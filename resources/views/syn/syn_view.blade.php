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

    .box.box-info {
        border-top-color: var(--primary);
        border: 1px solid var(--gray-200) !important;
    }

    /* ===== BOX HEADER ===== */
    .box-header.with-border {
        padding: 12px 18px;
        background: linear-gradient(135deg, var(--gray-50) 0%, #ffffff 100%);
        border-bottom: 1px solid var(--gray-200);
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

    .btn-danger {
        background: linear-gradient(135deg, var(--danger) 0%, var(--danger-dark) 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
    }
    .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
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

    .btn-info {
        background: linear-gradient(135deg, var(--info) 0%, #0284c7 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(14, 165, 233, 0.2);
    }
    .btn-info:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(14, 165, 233, 0.3);
    }

    .btn-sm {
        padding: 3px 10px;
        font-size: 10px;
        height: 26px;
    }

    .btn-flat { border-radius: var(--radius); }

    /* ===== TABLE ===== */
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

    /* Table Body */
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

    /* ===== COLUMN WIDTH ===== */
    .table thead th:nth-child(1) { width: 40px; }
    .table thead th:nth-child(2) { width: 20%; }
    .table thead th:nth-child(3) { width: 12%; }
    .table thead th:nth-child(4) { width: 30%; }
    .table thead th:nth-child(5) { width: 100px; }

    /* Text Alignment - Left for Name, URL */
    .table tbody td:nth-child(2),
    .table tbody td:nth-child(4) {
        text-align: left !important;
        padding-left: 8px !important;
    }

    .table tbody td:nth-child(1) {
        text-align: center !important;
        font-weight: 600;
        color: var(--gray-500);
    }

    /* ===== FORM ===== */
    .form-group {
        margin-bottom: 0px;
    }

    .form-control {
        border: 2px solid var(--gray-200);
        border-radius: var(--radius);
        padding: 4px 10px;
        font-size: 12px;
        height: 30px;
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

    .form-control:hover {
        border-color: var(--gray-400);
    }

    .form-control::placeholder {
        color: var(--gray-400);
        font-size: 11px;
    }

    /* ===== TEMPLATE LABEL ===== */
    .template-label {
        position: absolute;
        left: 20px;
        background: var(--primary);
        color: white;
        padding: 4px 20px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 13px;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
        z-index: 5;
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

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
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
        .form-control {
            font-size: 11px;
            height: 28px;
        }
        .template-label {
            font-size: 11px;
            padding: 3px 14px;
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
        .form-control {
            font-size: 11px;
            height: 26px;
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

    /* ===== INLINE INPUT ===== */
    .inline-input {
        display: inline-block;
        width: 120px;
        height: 28px;
        padding: 2px 8px;
        font-size: 11px;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius);
        transition: var(--transition);
        background: white;
        color: var(--gray-800);
    }

    .inline-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    .inline-input:hover {
        border-color: var(--gray-400);
    }

    .inline-input::placeholder {
        color: var(--gray-400);
        font-size: 10px;
    }
</style>
<!-- ===== MAIN CONTENT ===== -->
<div class="row">
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
                <strong>Failed!</strong> {{ Session::get('danger') }}
            </div> 
        @endif

        <div class="box box-info" style="position: relative; border: 1px solid var(--gray-200) !important;">
            <!-- ===== TEMPLATE LABEL ===== -->
            <div class="template-label">
                <i class="fa fa-exchange"></i> Data Syn
            </div>

            <div class="box-body" style="padding-top: 28px;">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>Name</th>
                                <th>Time</th>
                                <th>URL</th>
                                <th style="width:120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><strong>JO Data Rcv</strong></td>
                                <td><span class="badge" style="background:var(--primary);">11:00</span></td>
                                <td><code>/kyv/jo_order/receive</code></td>
                                <td>
                                    <button class="btn btn-danger btn-xs btn-flat" id="jo_syn_btn_rcv">
                                        <i class="fa fa-play"></i> Run
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><strong>JO Update</strong></td>
                                <td><span class="badge" style="background:var(--primary);">11:30</span></td>
                                <td><code>/kyv/jo/updated/receive</code></td>
                                <td>
                                    <button class="btn btn-danger btn-xs btn-flat" id="jo_syn_btn_updated_rcv">
                                        <i class="fa fa-play"></i> Run
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><strong>Do Data Update Rcv</strong></td>
                                <td><span class="badge" style="background:var(--primary);">12:00</span></td>
                                <td><code>/kyv/do/updated/receive</code></td>
                                <td>
                                    <button class="btn btn-danger btn-xs btn-flat" id="do_syn_btn_updated_rcv">
                                        <i class="fa fa-play"></i> Run
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><strong>Freight Rcv</strong></td>
                                <td><span class="badge" style="background:var(--warning);">Manual</span></td>
                                <td><code>/invoice/freight/fatching</code></td>
                                <td>
                                    <button class="btn btn-danger btn-xs btn-flat" id="inv_freight_fatch_id">
                                        <i class="fa fa-play"></i> Run
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><strong>OC Update</strong></td>
                                <td><span class="badge" style="background:var(--primary);">12:30</span></td>
                                <td><code>/oc/updated</code></td>
                                <td>
                                    <button class="btn btn-danger btn-xs btn-flat" id="oc_fatch_id">
                                        <i class="fa fa-play"></i> Run
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><strong>Trading Item</strong></td>
                                <td>
                                    <input type="text" id="party_code" name="party_code" class="inline-input" placeholder="Party Code">
                                </td>
                                <td><code>/syn/trading_item</code></td>
                                <td>
                                    <button class="btn btn-danger btn-xs btn-flat" id="trading_syn_id">
                                        <i class="fa fa-play"></i> Run
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td><strong>CI Value Syn</strong></td>
                                <td><span class="badge" style="background:var(--warning);">Manual</span></td>
                                <td><code>/ci_value/syn</code></td>
                                <td>
                                    <button class="btn btn-danger btn-xs btn-flat" id="ci_syn_id">
                                        <i class="fa fa-play"></i> Run
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td><strong>JO NO</strong></td>
                                <td>
                                    <input type="text" id="jo_no" name="jo_no" class="inline-input" placeholder="JO Number">
                                </td>
                                <td><code>/jo_receive/using/jo_number</code></td>
                                <td>
                                    <button class="btn btn-danger btn-xs btn-flat" id="jo_single_id">
                                        <i class="fa fa-play"></i> Run
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td><strong>Item Requisition</strong></td>
                                <td>
                                    <input type="text" id="requistion_no" name="requistion_no" class="inline-input" placeholder="Requisition No">
                                </td>
                                <td><code>/manual_item_requistion</code></td>
                                <td>
                                    <button class="btn btn-danger btn-xs btn-flat" id="item_requistion">
                                        <i class="fa fa-play"></i> Run
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td><strong>CI Value Syn By Invoice</strong></td>
                                <td>
                                    <input type="text" id="invoice_no" name="invoice_no" class="inline-input" placeholder="Invoice No">
                                </td>
                                <td><code>/update/ci/total_value</code></td>
                                <td>
                                    <button class="btn btn-danger btn-xs btn-flat" id="ci_value">
                                        <i class="fa fa-play"></i> Run
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td><strong>CRM Order Receive</strong></td>
                                <td><span class="badge" style="background:var(--primary);">01:35</span></td>
                                <td><code>/crm/order_receive</code></td>
                                <td>
                                    <button class="btn btn-danger btn-xs btn-flat" id="crm_order_receive">
                                        <i class="fa fa-play"></i> Run
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td><strong>CRM Order Update Receive</strong></td>
                                <td><span class="badge" style="background:var(--primary);">04:07</span></td>
                                <td><code>/crm/order_update_receive</code></td>
                                <td>
                                    <button class="btn btn-danger btn-xs btn-flat" id="crm_order_update_receive">
                                        <i class="fa fa-play"></i> Run
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== SCRIPTS ===== -->
<!-- ============================================================ -->
<script>document.title = 'Data Syn';</script>
<script type="text/javascript">
    
    setTimeout(function() { 
        $('.sr-only').click();
    }, 0.0001);

    $(document).ready(function(){

        // ===== JO DATA RCV =====
        $("#jo_syn_btn_rcv").click(function(){
            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var url = "{{url('/')}}"+"/kyv/jo_order/receive";
            $.get(url, function(res) {
                console.log(res);
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'JO Data Rcv executed successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to execute JO Data Rcv.',
                    confirmButtonColor: '#ef4444'
                });
            }).always(function() {
                $btn.prop('disabled', false).html(originalText);
            });
        });

        // ===== JO UPDATE RCV =====
        $("#jo_syn_btn_updated_rcv").click(function(){
            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var url = "{{url('/')}}"+"/kyv/jo/updated/receive";
            $.get(url, function(res) {
                console.log(res);
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'JO Update Rcv executed successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to execute JO Update Rcv.',
                    confirmButtonColor: '#ef4444'
                });
            }).always(function() {
                $btn.prop('disabled', false).html(originalText);
            });
        });

        // ===== DO DATA UPDATE RCV =====
        $("#do_syn_btn_updated_rcv").click(function(){
            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var url = "{{url('/')}}"+"/kyv/do/updated/receive";
            $.get(url, function(res) {
                console.log(res);
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'DO Data Update Rcv executed successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to execute DO Data Update Rcv.',
                    confirmButtonColor: '#ef4444'
                });
            }).always(function() {
                $btn.prop('disabled', false).html(originalText);
            });
        });

        // ===== FREIGHT RCV =====
        $("#inv_freight_fatch_id").click(function(){
            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var url = "{{url('/')}}"+"/invoice/freight/fatching";
            $.get(url, function(res) {
                console.log(res);
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Freight Rcv executed successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to execute Freight Rcv.',
                    confirmButtonColor: '#ef4444'
                });
            }).always(function() {
                $btn.prop('disabled', false).html(originalText);
            });
        });

        // ===== OC UPDATE =====
        $("#oc_fatch_id").click(function(){
            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var url = "{{url('/')}}"+"/oc/updated";
            $.get(url, function(res) {
                console.log(res);
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'OC Update executed successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to execute OC Update.',
                    confirmButtonColor: '#ef4444'
                });
            }).always(function() {
                $btn.prop('disabled', false).html(originalText);
            });
        });

        // ===== TRADING ITEM =====
        $("#trading_syn_id").click(function(){
            var party_code = $('#party_code').val();
            if(party_code == "") {
                Swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    text: "Party code cannot be empty!",
                    confirmButtonColor: '#f59e0b'
                });
                return;
            }

            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var url = "{{ url('/syn/trading_item')}}?party_code=" + encodeURIComponent(party_code);
            $.get(url, function(res) {
                console.log(res);
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Trading Item synced successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to sync Trading Item.',
                    confirmButtonColor: '#ef4444'
                });
            }).always(function() {
                $btn.prop('disabled', false).html(originalText);
            });
        });

        // ===== CI VALUE SYN =====
        $("#ci_syn_id").click(function(){
            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var url = "{{url('/')}}"+"/ci_value/syn";
            $.get(url, function(res) {
                console.log(res);
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'CI Value Syn executed successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to execute CI Value Syn.',
                    confirmButtonColor: '#ef4444'
                });
            }).always(function() {
                $btn.prop('disabled', false).html(originalText);
            });
        });

        // ===== JO SINGLE =====
        $('#jo_single_id').click(function() {
            var joNo = $("input[name='jo_no']").val();
            if(joNo == "") {
                Swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    text: "JO Number cannot be empty!",
                    confirmButtonColor: '#f59e0b'
                });
                return;
            }

            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var url = "{{url('/')}}/jo_receive/by/jo?jo_no=" + encodeURIComponent(joNo);
            $.get(url, function(res) {
                if(res.code == 200) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: res.msg || 'JO received successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: res.msg || 'Failed to receive JO.',
                        confirmButtonColor: '#f59e0b'
                    });
                }
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to execute JO Single.',
                    confirmButtonColor: '#ef4444'
                });
            }).always(function() {
                $btn.prop('disabled', false).html(originalText);
            });
        });

        // ===== ITEM REQUISITION =====
        $('#item_requistion').click(function() {
            var requistionNo = $("input[name='requistion_no']").val();
            if(requistionNo == "") {
                Swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    text: "Requisition number cannot be empty!",
                    confirmButtonColor: '#f59e0b'
                });
                return;
            }

            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var url = "{{url('/')}}/manual_item_requistion?requistion_no=" + encodeURIComponent(requistionNo);
            $.get(url, function(res) {
                if(res.code == 200) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: res.msg || 'Item requisition processed successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: res.msg || 'Failed to process item requisition.',
                        confirmButtonColor: '#f59e0b'
                    });
                }
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to execute Item Requisition.',
                    confirmButtonColor: '#ef4444'
                });
            }).always(function() {
                $btn.prop('disabled', false).html(originalText);
            });
        });

        // ===== CI VALUE BY INVOICE =====
        $('#ci_value').click(function() {
            var invoiceNo = $("input[name='invoice_no']").val();
            if(invoiceNo == "") {
                Swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    text: "Invoice number cannot be empty!",
                    confirmButtonColor: '#f59e0b'
                });
                return;
            }

            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var url = "{{url('/')}}/update/ci/total_value?invoice_no=" + encodeURIComponent(invoiceNo);
            $.get(url, function(res) {
                if(res.code == 200) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: res.msg || 'CI value updated successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: res.msg || 'Failed to update CI value.',
                        confirmButtonColor: '#f59e0b'
                    });
                }
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to execute CI Value by Invoice.',
                    confirmButtonColor: '#ef4444'
                });
            }).always(function() {
                $btn.prop('disabled', false).html(originalText);
            });
        });

        // ===== CRM ORDER RECEIVE =====
        $("#crm_order_receive").click(function(){
            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var url = "{{url('/')}}"+"/crm/order_receive";
            $.get(url, function(res) {
                console.log(res);
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'CRM Order Receive executed successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to execute CRM Order Receive.',
                    confirmButtonColor: '#ef4444'
                });
            }).always(function() {
                $btn.prop('disabled', false).html(originalText);
            });
        });

        // ===== CRM ORDER UPDATE RECEIVE =====
        $("#crm_order_update_receive").click(function(){
            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            var url = "{{url('/')}}"+"/crm/order_update_receive";
            $.get(url, function(res) {
                console.log(res);
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'CRM Order Update Receive executed successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to execute CRM Order Update Receive.',
                    confirmButtonColor: '#ef4444'
                });
            }).always(function() {
                $btn.prop('disabled', false).html(originalText);
            });
        });

    });
</script>
@endsection