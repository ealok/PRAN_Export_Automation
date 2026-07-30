@extends('layouts.master')
@section('content')
<style>
    /* Modern Color Scheme */
    :root {
        --primary: #2c3e50;
        --secondary: #3498db;
        --accent: #2980b9;
        --success: #27ae60;
        --light-bg: #f8f9fa;
        --border: #e1e5eb;
        --text: #2c3e50;
        --text-light: #7b8a8b;
    }

    /* Main Container Styles */
    .dashboard-container {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 30px;
        border: 1px solid var(--border);
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        color: white;
        padding: 1px 26px; /* Reduced padding */
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .dashboard-body {
        padding: 30px;
    }

    /* Filter Section */
    .filter-card {
        background: var(--light-bg);
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 30px;
        border: 1px solid var(--border);
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }

    .filter-title {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 15px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border);
        font-size: 16px;
        display: flex;
        align-items: center;
    }

    .filter-title i {
        background: var(--secondary);
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 13px;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: 600;
        color: var(--text);
        margin-bottom: 6px;
        font-size: 12px;
        display: block;
    }

    .form-control {
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 5px 12px;
        height: 30px;
        font-size: 13px;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: var(--secondary);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);
    }

    .select2-container--default .select2-selection--single {
        border: 1px solid var(--border);
        border-radius: 6px;
        height: 38px;
        padding: 8px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }

    /* Radio Buttons - Fixed inline display */
    .radio-group {
        padding: 10px 0;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .radio-inline {
        display: inline-flex;
        align-items: center;
        margin: 0;
        font-weight: 500;
        color: var(--text);
        position: relative;
        padding-left: 25px;
        cursor: pointer;
        white-space: nowrap;
    }

    .radio-inline input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 18px;
        width: 18px;
        background-color: #fff;
        border: 2px solid var(--border);
        border-radius: 50%;
    }

    .radio-inline input[type="radio"]:checked ~ .checkmark {
        background-color: var(--secondary);
        border-color: var(--secondary);
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .radio-inline input[type="radio"]:checked ~ .checkmark:after {
        display: block;
    }

    .radio-inline .checkmark:after {
        top: 4px;
        left: 4px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }

    /* Buttons */
    .btn-submit {
        background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
        color: white;
        border: none;
        border-radius: 6px;
        padding: 4px 4px; /* Decreased padding */
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 3px 8px rgba(0,0,0,0.12);
        display: inline-flex;
        align-items: center;
        font-size: 13px; /* Decreased font size */
        float: right;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(0,0,0,0.18);
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    }

    .btn-download {
        background: linear-gradient(135deg, var(--success) 0%, #2ecc71 100%);
        color: white;
        border: none;
        border-radius: 6px;
        padding: 4px 5px; /* Decreased padding */
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 3px 8px rgba(0,0,0,0.12);
        display: inline-flex;
        align-items: center;
        font-size: 13px; /* Decreased font size */
        float: right;
        margin-right: 10px;
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(0,0,0,0.18);
        background: linear-gradient(135deg, #2ecc71 0%, var(--success) 100%);
    }

    .btn-download i, .btn-submit i {
        margin-right: 2px;
    }

    /* Preloader (Fix only within report div) */
    .preload {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.95);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        flex-direction: column;
        display: none; /* Default hidden */
    }

    .preload img {
        height: 60px;
        margin-bottom: 15px;
    }

    .preload-text {
        color: var(--text);
        font-size: 15px;
        font-weight: 500;
    }

    /* Tables */
    .table-container {
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        margin-top: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }

    .table-title {
        background: var(--light-bg);
        padding: 15px 20px;
        font-weight: 600;
        color: var(--primary);
        border-bottom: 1px solid var(--border);
        font-size: 16px;
        display: flex;
        align-items: center;
    }

    .table-title i {
        margin-right: 10px;
        color: var(--secondary);
    }

    .table-responsive {
        border-radius: 10px;
        max-height: 500px;
        overflow-y: auto;
    }

    .table-bordered > thead > tr > th {
        background: var(--primary);
        color: white;
        border: 1px solid #3a516e;
        padding: 14px 16px;
        text-align: center;
        vertical-align: middle;
        font-weight: 600;
        font-size: 13px;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table-bordered > tbody > tr > td {
        border: 1px solid var(--border);
        padding: 12px 16px;
        vertical-align: middle;
        font-size: 13px;
        color: var(--text);
    }

    .table tbody tr:nth-child(even) {
        background-color: rgba(248, 249, 250, 0.5);
    }

    .table tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.05);
    }

    .text-right {
        text-align: right;
    }
    .table-bordered > tbody > tr > td {
        border: 1px solid var(--border);
        padding: 2px 9px;
        vertical-align: middle;
        font-size: 11px;
        color: var(--text);
    }
</style>

<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/home')}}"><i class="fa fa-home mr-1"></i>Home</a></li>
        <li class="breadcrumb-item active">Production Report</li>
    </ol>
</section>

<div class="row">
    <div class="col-md-12">
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                <i class="fa fa-check-circle"></i>
                <div>
                    <strong>Success!</strong> {{ Session::get('success') }}
                </div>
            </div>
        @endif
        @if(Session::has('danger'))
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                <i class="fa fa-exclamation-circle"></i>
                <div>
                    <strong>Failed!</strong> {{ Session::get('danger') }}
                </div>
            </div>
        @endif
        
        <div class="dashboard-container">
            <div class="dashboard-header">
                <h3 class="m-0"><i class="fa fa-file-text-o mr-2"></i> Production Report</h3>
                <p class="m-0 mt-1" style="font-size: 14px; opacity: 0.9;">Generate and analyze production reports</p>
            </div>
            
            <div class="dashboard-body">
                <div class="filter-card">
                    <div class="filter-title">
                        <i class="fa fa-filter"></i> Report Filters
                    </div>
                    
                    <form id="reportForm">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="from_date">From Date:</label>
                                    <input name="from_date" type="text" id="from_date" class="form-control datepicker" value="{{date('d-m-Y', strtotime($previous_date))}}" placeholder="Select From Date">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="to_date">To Date:</label>
                                    <input name="to_date" type="text" id="to_date" class="form-control datepicker" value="{{date('d-m-Y', strtotime($current_date))}}" placeholder="Select To Date">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location_id">Production Location:</label>
                                    <select name="location_id" id="location_id" class="form-control select2" required>
                                        <option value="All">All Locations</option>
                                        @foreach ($p_floors as $p_floor)
                                            <option value="{{$p_floor->id}}">{{$p_floor->p_code}} - {{$p_floor->p_name}}</option>  
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="report_type">Report Type:</label>
                                    <div class="radio-group">
                                        <label class="radio-inline">
                                            <input type="radio" name="report_type" value="1">
                                            <span class="checkmark"></span>
                                            Summary Report
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="report_type" value="0">
                                            <span class="checkmark"></span>
                                            Detailed Report
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button type="button" class="btn-submit" id="check_button_id" style="margin-top: -26px"><i class="fa fa-search"></i>Generate Report</button>
                            <button type="button" id="btnExport" class="btn-download" style="margin-top: -26px"><i class="fa fa-download"></i>Download Report</button>
                        </div>
                    </form>
                </div>

                <!-- Summary Report Table -->
                <div class="table-container" id="summarySection">
                    <div class="table-title">
                        <i class="fa fa-table"></i> Production Summary Report
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="summaryTable">
                            <thead>
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Order Qty</th>
                                    <th>Production Qty</th>
                                    <th>Pending Qty</th>
                                </tr>
                            </thead>
                            <tbody id="item_summary">
                                <tr class="empty-row">
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <i class="fa fa-table"></i>
                                            <p>No data available. Generate a report to view data.</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Detailed Report Table -->
                <div class="table-container" id="detailsSection">
                    <div class="table-title">
                        <i class="fa fa-list-alt"></i> Production Detailed Report
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="itemDetailsTable">
                            <thead>
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Order Qty</th>
                                    <th>Production Qty</th>
                                    <th>Due Qty</th>
                                </tr>
                            </thead>
                            <tbody id="ItemDetails">
                                <tr class="empty-row">
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="fa fa-list-alt"></i>
                                            <p>No data available. Generate a report to view data.</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>document.title = 'Production | Report';</script>
<script>
    // Initialize page state
    setTimeout(function() { $('.sr-only').click();}, 0.0001);
    $(".preload").hide(); // Hide preloader initially
    $('.btn-download').hide();
    $('#summarySection').hide();
    $('#detailsSection').hide();
    
    // Handle form submission
    $("#check_button_id").click(function(){
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var location_id = $('#location_id').val();
        var report_type = $("[name=report_type]:checked").val();
        
        if(from_date == ""){
            Swal.fire({
                icon: 'warning',
                title: 'Missing Information',
                text: 'From date is required.',
                confirmButtonColor: '#3498db'
            });
            return false;
        } else if(to_date == ""){
            Swal.fire({
                icon: 'warning',
                title: 'Missing Information',
                text: 'To date is required.',
                confirmButtonColor: '#3498db'
            });
            return false;
        } else if(report_type == undefined){
            Swal.fire({
                icon: 'warning',
                title: 'Missing Information',
                text: 'Please select report type.',
                confirmButtonColor: '#3498db'
            });
            return false;
        } else {
            var url = "{{url('/json/load/production/report')}}?from_date="+from_date+'&to_date='+to_date+"&report_type="+report_type+"&location_id="+location_id;
            
            // Show loading spinner within the report section
            $(".preload").show();
            
            $.get(url, function(data) {
                console.log(data);
                
                if(data.report_type == 1) {
                    // Summary Report
                    if(data.results.length > 0) {
                        var rows = '';
                        $.each(data.results, function (key, value) {
                            rows += '<tr>';
                            rows += '<td>' + value.invoice_no + '</td>';
                            rows += '<td class="text-right">' + value.order_qty + '</td>';
                            rows += '<td class="text-right">' + value.prod_qty + '</td>';
                            rows += '<td class="text-right">' + value.due_qty + '</td>';
                            rows += '</tr>';
                        });
                        
                        $("#item_summary").html(rows);
                        $("#summarySection").show();
                        $("#detailsSection").hide();
                    } else {
                        $("#item_summary").html('<tr><td colspan="4"><div class="empty-state"><i class="fa fa-table"></i><p>No data available for the selected criteria.</p></div></td></tr>');
                        $("#summarySection").show();
                        $("#detailsSection").hide();
                    }
                } else {
                    // Detailed Report
                    if(data.results.length > 0) {
                        var rows = '';
                        $.each(data.results, function (key, value) {
                            rows += '<tr>';
                            rows += '<td>' + value.invoice_no + '</td>';
                            rows += '<td>' + value.item_code + '</td>';
                            rows += '<td>' + value.item_name + '</td>';
                            rows += '<td class="text-right">' + value.order_qty + '</td>';
                            rows += '<td class="text-right">' + value.prod_qty + '</td>';
                            rows += '<td class="text-right">' + value.due_qty + '</td>';
                            rows += '</tr>';
                        });
                        
                        $("#ItemDetails").html(rows);
                        $("#detailsSection").show();
                        $("#summarySection").hide();
                    } else {
                        $("#ItemDetails").html('<tr><td colspan="6"><div class="empty-state"><i class="fa fa-list-alt"></i><p>No data available for the selected criteria.</p></div></td></tr>');
                        $("#detailsSection").show();
                        $("#summarySection").hide();
                    }
                }
                
                $(".preload").hide(); // Hide preloader when data is loaded
                $('.btn-download').show(); // Show download button
            }).fail(function() {
                $(".preload").hide(); // Hide preloader in case of error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load report data.',
                    confirmButtonColor: '#3498db'
                });
            });
        }
    });
    
    // Handle Excel export
    $(function() {
        $("#btnExport").click(function() {
            var report_type = $("[name=report_type]:checked").val();  
            
            if(report_type == 1) {
                $("#summaryTable").table2excel({
                    filename: "Production_Summary_Report.xls"
                }); 
            } else if(report_type == 0) {
                $("#itemDetailsTable").table2excel({
                    filename: "Production_Detailed_Report.xls"
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Action Required',
                    text: 'Please generate a report first.',
                    confirmButtonColor: '#3498db'
                });
            }
        }); 
    });
    
    // Initialize components
    $(document).ready(function(){
        // Initialize select2
        $('.select2').select2({
            width: '100%',
            placeholder: "Select a location"
        });
        
        // Initialize datepicker
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>   
@endsection
