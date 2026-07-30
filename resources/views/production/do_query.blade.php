@extends('layouts.master')
@section('content')
<style>
    .table-bordered > thead > tr > th {
        border-bottom-width: 1px;
    }
    .table-bordered > thead > tr > th {
        border: 1px solid #151313;
    }
    .table-bordered > thead > tr {
        border-top: 1px solid;
    }
    .table-bordered > tbody > tr > td {
        border: 1px solid #151313;
    }
    .table-bordered > tbody > tfoot > tr > td {
        border: 1px solid #151313;
    }

    .preload {
        margin: 0;
        position: absolute;
        top: 86%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
    }

    img {
        height: 386px;
    }

    .btn {
        padding: 4px 12px;
    }

    .table > tbody > tr > td {
        padding: 2px;
        line-height: 1.2;
        vertical-align: top;
    }

    /* New enhanced styles */
    body {
        background-color: #f5f7fb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: none;
        margin-bottom: 20px;
    }
    
    .card-header {
        background: linear-gradient(45deg, #3c8dbc, #5faee3);
        color: white;
        border-radius: 10px 10px 0 0 !important;
        padding: 15px 20px;
        font-weight: 600;
    }
    
    .section-title {
        color: #3c8dbc;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eaeaea;
    }
    
    .form-control, .select2-container--default .select2-selection--single {
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 8px 12px;
        height: 40px;
    }
    
    .form-control:focus {
        border-color: #3c8dbc;
        box-shadow: 0 0 0 0.25rem rgba(60, 141, 188, 0.25);
    }
    
    .btn-primary {
        background: linear-gradient(45deg, #3c8dbc, #5faee3);
        border: none;
        border-radius: 5px;
        padding: 8px 20px;
    }
    
    .btn-primary:hover {
        background: linear-gradient(45deg, #337ba7, #4c9bd4);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .btn-info {
        background: linear-gradient(45deg, #00c0ef, #2cd6f8);
        border: none;
        border-radius: 5px;
        padding: 8px 20px;
    }
    
    .table th {
        background-color: #3c8dbc;
        color: white;
        vertical-align: middle;
    }
    
    .table-responsive {
        border-radius: 5px;
        overflow: hidden;
    }
    
    .preload {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 20px;
    }
    
    .alert {
        border-radius: 5px;
        border: none;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .search-box {
        position: relative;
        margin-bottom: 20px;
    }
    
    .search-box i {
        position: absolute;
        left: 15px;
        top: 12px;
        color: #6c757d;
    }
    
    .search-box input {
        padding-left: 40px;
        border-radius: 50px;
    }
    
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }
    
    /* Custom width for dropdowns */
    .dropdown-width-control {
        width: 100%;
    }
    
    @media (min-width: 992px) {
        .dropdown-width-control {
            width: 100%;
        }
    }
    
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 8px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(60, 141, 188, 0.1);
    }
    
    .status-badge {
        padding: 5px 10px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-success {
        background-color: #d4edda;
        color: #155724;
    }
    
    .badge-warning {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .form-section {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
    }

    .results-section {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        border: 1px solid #ddd;
        display: none;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -5px;
        margin-left: -5px;
    }

    .form-col {
        padding-right: 5px;
        padding-left: 5px;
        flex: 1 0 0%;
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .form-col {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>

<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active"><a href="{{url('/production/update')}}"><i class="fa fa-dashboard"></i>Production Update</a></li>
    </ol>
    <br>
</section>

<div class="row">
    <div class="col-md-12">
        @if(Session::has('success')) 
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif 
        @if(Session::has('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Failed!</strong> {{ Session::get('danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <!-- Production Update Form -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fa fa-sync-alt me-2"></i>Production Update</h5>
            </div>
            <div class="card-body">
                <div class="preload">
                    <div class="text-center">
                        <img src="{{asset('/img/loading_spinner.gif')}}" alt="Loading..." width="80">
                        <p class="mt-2">Processing your request...</p>
                    </div>
                </div>
                
                <form class="" role="form" method="POST" action="{{url('/notify_party/upload') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <!-- Form Input Section -->
                    <div class="form-section">
                        <h5 class="section-title"><i class="fa fa-info-circle me-2"></i>Production Details</h5>
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group {{ $errors->has('from_date') ? 'has-error' : '' }}">
                                    <label for="name" class="form-label">From Date:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                        <input name="from_date" type="text" id="from_date" class="form-control datepicker input-sm"  value="{{date("d-m-Y", strtotime($previous_date))}}"  placeholder="Select From Date">
                                    </div>
                                </div> 
                            </div>
                            <div class="form-col">
                                <div class="form-group {{ $errors->has('to_date') ? 'has-error' : '' }}">
                                    <label for="name" class="form-label">To Date:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                        <input name="to_date" type="text" id="to_date" class="form-control datepicker input-sm"  value="{{date("d-m-Y", strtotime($current_date))}}"  placeholder="Select To Date">
                                    </div>
                                </div> 
                            </div>
                            <div class="form-col">
                                <div class="form-group {{ $errors->has('pfloor_id') ? 'has-error' : '' }}">
                                    <label for="pfloor_id" class="form-label">Production Floor</label>
                                    <select name="pfloor_id" id="pfloor_id" class="form-control select2 selectpicker input-sm dropdown-width-control" required autofocus>
                                        <option value="">Select</option>
                                        @foreach($p_floors as $p_floor)
                                            <option value="{{$p_floor->id}}">{{$p_floor->p_code}}-{{$p_floor->p_name}}</option>
                                        @endforeach  
                                    </select>  
                                </div> 
                            </div>
                            <div class="form-col">
                                <div class="form-group {{ $errors->has('job_order_id') ? 'has-error' : '' }}">
                                    <label for="job_order_id" class="form-label">SC/JO Number</label>
                                    <select name="job_order_id" id="job_order_id" class="form-control select2 selectpicker input-sm dropdown-width-control" required autofocus>
                                        <option value="">Select</option>
                                    </select>  
                                </div>
                            </div>
                            <div class="form-col" style="display: flex; align-items: flex-end;">
                                <div class="form-group">
                                   <button type="button" class="btn btn-info" id="check_button_id">
                                       <i class="fa fa-search me-1"></i> Search
                                   </button>
                                </div>
                             </div> 
                        </div> 
                    </div>
                    
                    <!-- Results Section -->
                    <div class="results-section" id="resultsSection">
                        <h5 class="section-title"><i class="fa fa-list me-2"></i>Job Order Details</h5>
                        
                        <div class="search-box">
                            <i class="fa fa-search"></i>
                            <input type="text" id="myInput" class="form-control" placeholder="Search...">
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr> 
                                        <th width="80">Action</th>
                                        <th>Item Code</th>
                                        <th>Item Name</th>
                                        <th>Order Qty (CTN)</th>
                                        <th>Prod Qty (CTN)</th>
                                        <th>Last Entry Date</th>
                                        <th>Entered Qty (CTN)</th>
                                        <th width="120">Status</th>
                                    </tr> 
                                </thead>
                                <tbody id="job_details">
                                </tbody>
                                <tfoot id="hide_tfood_id">
                                    <tr>
                                       <td colspan="8" class="text-end">
                                            <button type="button" class="btn btn-danger btn-sm delete-row">
                                                <i class="fa fa-trash me-1"></i> Delete Selected
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm ms-2 save_data">
                                                <i class="fa fa-save me-1"></i> Save Changes
                                            </button>
                                       </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>document.title = 'Prod Update';</script>
<script>
    $(".preload").hide();
    $('#hide_tfood_id').hide();
    $(document).ready(function(){ 
        // Initialize Select2 with proper width control
        $('.dropdown-width-control').select2({
            width: '100%'
        });
        
        $("#pfloor_id").change(function() {
            var pfloor_id=$(this).val();
            var from_date=$('#from_date').val();
            var to_date=$('#to_date').val();
            var $el = $('#job_order_id');
            if(pfloor_id){
                $.ajax({
                    method: 'GET',
                    url: "/json/get/production_floor/sc_jo_list",
                    data: {
                        'pfloor_id': pfloor_id,
                        'from_date':from_date,
                        'to_date':to_date,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (response) {
                        if(!response.results){
                            $el.html('');
                            $el.append($("<option></option>").attr("value", "").text("---"));
                            $el.selectpicker('destroy');
                            $el.selectpicker('refresh');
                        }else{
                            $el.html('');
                            $el.append($("<option></option>").attr("value", "").text("Select"));
                            $.each(response.results, function(key,value) {
                                $el.append($("<option></option>").attr("value", value['id']).text(value.invoice_no+' / '+value.country+' / '+value.job_order_number));
                            });
                            $el.selectpicker('refresh');
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                }); 
            }
        });

        $(".save_data").click(function(){
            var prod_details = new Array(); 
            $(".preload").show();
            $(".table-bordered TBODY TR").each(function () {
                var row = $(this);
                var dist_info = {};
                dist_info.item_id = row.find("TD").eq(1).html();
                dist_info.order_qty = $(this).find("td:eq(4) input[type='text']").val();
                dist_info.prod_qty = row.find("TD").eq(5).html();
                dist_info.entered_qty = $(this).find("td:eq(7) input[type='text']").val();
                dist_info.prod_floor = $('#pfloor_id').val();
                prod_details.push(dist_info);
            });

            if(prod_details.length>0){
                $.ajax({
                    method: 'POST',
                    url: "/store/prod/details",
                    data: {
                        'job_order_id': $('#job_order_id').val(), 
                        'prod_details': prod_details, 
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Information Save Successfully..!!',
                            timer: 1500
                        });
                        $(".preload").hide();
                        $('#hide_tfood_id').hide();
                        $('#job_details').hide();
                    },
                    error: function (e) {
                       console.log(e);
                    }
                });
            }
        });

        $("#check_button_id").click(function(){
            var job_order_id = $('#job_order_id').val();
            if(job_order_id==""){
                Swal.fire({ 
                   title: 'Alert!! <br> Please Select JO/SC Number..!!',
                });
            }else{
                var url = "{{url('/json/get/jo_details')}}?job_order_id="+job_order_id;
                $.get(url, function(data) {
                    if(data.results.length>0){
                        var rows = '';
                        $.each(data.results, function (key, value) {
                            // Determine status based on production progress
                            var statusClass = 'badge-warning';
                            var statusText = 'In Progress';
                            if (parseInt(value.prod_qty) >= parseInt(value.order_qty)) {
                                statusClass = 'badge-success';
                                statusText = 'Completed';
                            }
                            
                            rows = rows + '<tr>';
                            rows = rows + '<td class="text-center">' + "<input type='checkbox' name='record' class='form-check-input'>"+'</td>';
                            rows = rows + '<td style="display:none">' + value.item_id + '</td>';
                            rows = rows + '<td>' + value.item_code + '</td>';
                            rows = rows + '<td>' + value.item_name + '</td>';
                            rows = rows + '<td>' + '<input type="text" class="form-control form-control-sm" value="'+value.order_qty+'" readonly>'+'</td>';
                            rows = rows + '<td>' + value.prod_qty + '</td>';
                            rows = rows + '<td>' + value.date + '</td>';
                            rows = rows + '<td>' + '<input type="number" class="form-control form-control-sm" value="0" min="0">' + '</td>';
                            rows = rows + '<td><span class="status-badge ' + statusClass + '">' + statusText + '</span></td>';
                            rows = rows + '</tr>';
                        });
                        $("#job_details").html(rows);
                        $("#job_details").show();
                        $('#hide_tfood_id').show();
                        $('#resultsSection').show(); // Show the results section
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Alert',
                            text: 'Production Done This JO..!!',
                            timer: 1500
                        });
                        $('#hide_tfood_id').hide();
                    }
                });
            }  
        });

        $(".delete-row").click(function(){
            $("table tbody").find('input[name="record"]').each(function(){
            	if($(this).is(":not(:checked)")){
                    $(this).parents("tr").remove();
                }
            });
            
            // Show confirmation message
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'Selected items have been removed.',
                timer: 1500
            });
        });
        
        // Search functionality
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#job_details tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection