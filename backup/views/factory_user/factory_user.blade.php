@extends('layouts.master')
@section('content') 
<style>
.form-control {
  border-radius: 0;
  box-shadow: none;
  border-color: #0d18b9;
}
.form-group {
   margin-bottom: 0px;
}
.form-control[disabled]{
  background-color: #288a37;
}
#party{
    position: absolute;
    left: -346px;
    top: 1px;
}
.select2{
    position: absolute;
    left: -248px;
    top: -5px;
}
.bootstrap-select > .dropdown-toggle.bs-placeholder{
  color: #222;
  border: 1px solid #0f0f1a;
  border-radius: 10px;
  width: 176px;
}
.btn-default {
background-color: #FFFFFF;
}
.bootstrap-select > .dropdown-toggle.bs-placeholder,.bootstrap-select > .dropdown-toggle.bs-placeholder:hover {
  color: #222;
  border: 1px solid #0f0f1a;
  border-radius: 10px;
}
.btn dropdown-toggle btn-default{
  border-radius: 10px;
}
.form-control{
  border-radius: 10px;
}
.task_class_id{
  color: #ae6911f2;
  font-weight: bold;
}
.mail_send{
  color: brown;
  font-weight: bold;
}
.col-sm-7 {
  width: 65.333%;
}
#po_details_style{
  position: absolute;
  top: -15px;
  border: 2px solid blue;
  background: #FFF;
  width: 167px;
  text-align: center;
  font-weight: bold;
  padding: 3px;
  font-style: oblique;
}
#task_details_style{
  position: absolute;
  top: -15px;
  border: 2px solid blue;
  background: #FFF;
  width: 198px;
  text-align: center;
  font-weight: bold;
  padding: 3px;
  font-style: oblique;
}
.table > thead:first-child > tr:first-child > th {
  border: 1px solid #222;
}
.table-bordered > tbody > tr > td{
  border: 1px solid #201f1f;
  padding: 0px;
  font-weight: normal;
  font-family: initial;
}
.table > tbody > tr > td{
  padding: 1px;
  line-height: 1.42857143;
  vertical-align: top;
}
.table-bordered > tbody > tr > td{
  border: 1px solid #201f1f;
  padding: 1px;
  font-weight: bold;
}
.btn-sm {
  padding: 1px 7px 0px 6px;
  font-size: 12px;
  line-height: 1.5;
}
.table-bordered > tbody > tr:hover{
  background-color: rgba(101, 212, 97, 0.836);
}
.content-header > .breadcrumb {
  float: right;
  background: transparent;
  margin-top: 0;
  margin-bottom: 0;
  font-size: 12px;
  padding: 7px 5px;
  position: absolute;
  top: -14px;
  right: 10px;
  border-radius: 2px;
}
.preload {
  margin:0;
  position:absolute;
  top:50%;
  left:50%;
  margin-right: -50%;
  transform:translate(-50%, -50%);
}
img{
  height: 386px;
}
.form-horizontal .form-group {
  margin-right: 0px;
  margin-left: 0px;
}
.modal-content{
  width: 525px;
}
#po_detils{
  height: 358px;      
  overflow-y: auto;    
  overflow-x: hidden;  
}
.row {
  margin-right: -15px;
  margin-left: -7px;
}
.box-header.with-border {
  border-bottom: 3px solid #3C8DBC;
  font-weight: bold;
}
.box.box-primary {
  border-top-color: #FFFFFF;
}
.modal-body{
  position: relative;
  top: -12px;
  padding: 18px;
}
.modal-header .close {
  margin-top: -22px;
}
.modal-header {
  border-bottom-color: #cac4c4;
}
.modal-title{
  text-align: left;
  font-size: 12px;
  text-transform: uppercase;
  font-weight: bold;
}
.modal-footer {
  padding: 14px;
  border-top: 1px solid #c4c2c2;
}
#img_toggle_id{
  height: 40px;
  position: absolute;
  top: -3px;
  left: 845px;
}
.box-header.with-border {
  border-bottom: none;
}
.box {
  position: relative;
  border-radius: 3px;
  background: #ffffff;
  border-top: 3px solid #d2d6de;
  margin-bottom: 20px;
  width: 100%;
  box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}
#tblMain {
   display: block;
}
#tblMain{
  height: 358px;      
  overflow-y: auto;    
  overflow-x: hidden;  
}

/* New styles for multiple truck modal */
.truck-entry {
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 15px;
    padding: 15px;
    background: #f9f9f9;
}
.truck-header {
    background: #e9ecef;
    padding: 8px 15px;
    margin: -15px -15px 15px -15px;
    border-radius: 5px 5px 0 0;
    border-bottom: 1px solid #ddd;
}
.remove-truck {
    float: right;
    cursor: pointer;
    color: #dc3545;
}
.remove-truck:hover {
    color: #bd2130;
}
.is-invalid {
    border-color: #dc3545 !important;
}
.modal-lg {
    max-width: 900px;
}
.truck-totals {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
    margin-top: 15px;
    border: 1px solid #dee2e6;
}
.truck-totals h5 {
    margin-bottom: 10px;
    color: #495057;
}
</style>

<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/po')}}"><i class="fa fa-dashboard"></i>Unposted Ci Doc</a></li>
    </ol>
    <br>
</section>

<div class="row">
  <div class="col-md-12">
      <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px;min-height: 190px;">
            <div class="box-header with-border">
                <div class="row" style="margin-left: 154px;margin-top: 61px;">
                    <div class="col-sm-3" style="text-align: right;margin-top: 7px;">Sales Contract No:</div>
                    <div class="col-sm-3">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                          <input type="text" name="sales_contact_no" id="sales_contact_no" class="form-control" required="" placeholder="Enter Sales Contract No">
                        </div>
                    </div>
                    <div class="col-sm-3">
                      <button class="btn btn-info" style="margin-top: -1px" id="search_btn_id">Search</button>
                    </div>
                </div>
            </div>
        <br>
      </div>
      <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;min-height: 190px;margin-top: -10px;">
        <div class="box-header with-border">
          <table id="example1" class="table table-bordered table-responsive table-condenced">
              <thead style="background: #68ceac;">
                <tr>
                  <th>#SL</th>
                  <th>Sales_contract_no</th>
                  <th>Dated</th>
                  <th>Invoice No</th>
                  <th>Company</th>
                  <th>Bank</th>
                  <th>Importer</th>
                  <th>Status</th>
                  <th style="width: 160px">Action</th>
                </tr>  
              </thead>
              <tbody>
                  
              </tbody>
          </table>
        </div>
    <br>
  </div>
  </div>
</div>

<!--@@@@@@@ Old Modal (Simple Truck Numbers) @@@@@@@-->
<div class="modal fade" id="factoryUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form enctype="multipart/form-data" id="upateSubmitFormId">
    {{csrf_field()}} 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Truck Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="box-header with-border">
            <div class="col-sm-4">
                <label for="truck_numbers" id="truck_numbers">Truck Numbers:</label>
                <div class="form-group {{ $errors->has('truck_numbers') ? 'has-error' : '' }}">
                    <textarea rows="5" cols="500" class="form-control" placeholder="Enter your truck numbers" name="truck_numbers" id="truck_numbers" style="width: 440px;height: 147px;"></textarea>
                </div>
                <input type="hidden" id="sales_contact_id" name="sales_contact_id">
            </div>
            <div class="col-sm-12">
              <label for="truck_numbers" id="truck_numbers">Truck Loaded Date:</label>
              <div class="form-group {{ $errors->has('truck_numbers') ? 'has-error' : '' }}">
                 <input type="text" class="form-control datepicker" name="truck_loaded_date" id="truck_loaded_date">
              </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </div>
    </form>
  </div>
</div><!--@@@@@@@ End Old Modal @@@@@@@-->

<!--@@@@@@@ NEW Modal for Multiple Truck Details @@@@@@@-->
<div class="modal fade" id="multipleTruckModal" tabindex="-1" role="dialog" aria-labelledby="multipleTruckModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form enctype="multipart/form-data" id="multipleTruckForm">
    {{csrf_field()}} 
    <div class="modal-content" style="width: 800px;">
      <div class="modal-header">
        <h5 class="modal-title" id="multipleTruckModalLabel">Update Multiple Truck Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" id="multiple_sales_contact_id" name="sales_contact_id">
          
          <div class="row">
            <div class="col-md-12">
              <label for="truck_loaded_date_multi">Truck Loaded Date:</label>
              <div class="form-group">
                 <input type="text" class="form-control datepicker" name="truck_loaded_date" id="truck_loaded_date_multi" required>
              </div>
            </div>
          </div>
          
          <div id="truck-container">
            <!-- Truck entries will be added here dynamically -->
          </div>
          
          <div class="row mt-3">
            <div class="col-md-12 text-right">
              <button type="button" class="btn btn-sm btn-success" id="add-truck-btn">
                <i class="fa fa-plus"></i> Add Another Truck
              </button>
            </div>
          </div>
          
          <!-- Truck Totals Section - Removed Total Units -->
          <div class="truck-totals">
            <h5>Truck Totals</h5>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Total Trucks:</label>
                  <input type="text" class="form-control" id="total-trucks" readonly value="1">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Total Net Weight (KGS):</label>
                  <input type="text" class="form-control" id="total-net-weight" readonly value="0.00">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Total Gross Weight (KGS):</label>
                  <input type="text" class="form-control" id="total-gross-weight" readonly value="0.00">
                </div>
              </div>
            </div>
          </div>
          
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update Truck Details</button>
      </div>
    </div>
    </form>
  </div>
</div><!--@@@@@@@ End New Modal @@@@@@@-->

<!-- Hidden Truck Entry Template -->
<div id="truck-entry-template" style="display: none;">
  <div class="truck-entry" data-index="0">
    <div class="truck-header">
      <strong>Truck #<span class="truck-number-display">1</span></strong>
      <span class="remove-truck"><i class="fa fa-times"></i> Remove</span>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label>Truck Number *</label>
          <input type="text" class="form-control truck-no-input" name="truck_numbers[]" placeholder="Truck Number" required>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Units (Pcs/Ctn) *</label>
          <input type="text" class="form-control unit-input" name="unit_count[]" placeholder="Units" required>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Net Weight (KGS) *</label>
          <input type="number" class="form-control net-weight-input" name="net_weight[]" placeholder="Net Weight" step="0.01" min="0" required>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Gross Weight (KGS) *</label>
          <input type="number" class="form-control gross-weight-input" name="gross_weight[]" placeholder="Gross Weight" step="0.01" min="0" required>
        </div>
      </div>
    </div>
  </div>
</div>

<script>document.title = 'Export | Factory Report';</script>
<script type="text/javascript">
$(document).ready(function() {
    let truckCounter = 1;
    
    // Initialize datepicker
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
    
    setTimeout(function() { 
        $('.sr-only').click();
    }, 0.0001);
    
    // Function to add truck entry
    function addTruckEntry(truckData = null) {
        const template = $('#truck-entry-template .truck-entry').clone();
        
        // Update index and display number
        template.attr('data-index', truckCounter);
        template.find('.truck-number-display').text(truckCounter);
        
        // If data provided, fill the fields
        if (truckData) {
            template.find('.truck-no-input').val(truckData.truck_number || '');
            template.find('.unit-input').val(truckData.unit_count || '');
            template.find('.net-weight-input').val(truckData.net_weight || '');
            template.find('.gross-weight-input').val(truckData.gross_weight || '');
        }
        
        $('#truck-container').append(template);
        truckCounter++;
        updateTruckNumbers();
        calculateTotals();
    }
    
    // Function to update truck numbers
    function updateTruckNumbers() {
        $('#truck-container .truck-entry').each(function(index) {
            $(this).find('.truck-number-display').text(index + 1);
        });
        $('#total-trucks').val($('#truck-container .truck-entry').length);
    }
    
    // Function to calculate totals - Only weights, not units
    function calculateTotals() {
        let totalNetWeight = 0;
        let totalGrossWeight = 0;
        
        $('#truck-container .truck-entry').each(function() {
            const netWeight = parseFloat($(this).find('.net-weight-input').val()) || 0;
            const grossWeight = parseFloat($(this).find('.gross-weight-input').val()) || 0;
            
            totalNetWeight += netWeight;
            totalGrossWeight += grossWeight;
        });
        
        $('#total-net-weight').val(totalNetWeight.toFixed(2));
        $('#total-gross-weight').val(totalGrossWeight.toFixed(2));
    }
    
    // Function to remove truck entry
    $(document).on('click', '.remove-truck', function() {
        if ($('#truck-container .truck-entry').length > 1) {
            $(this).closest('.truck-entry').remove();
            updateTruckNumbers();
            calculateTotals();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Cannot Remove',
                text: 'At least one truck entry is required.',
            });
        }
    });
    
    // Add truck button click handler
    $('#add-truck-btn').click(function() {
        addTruckEntry();
    });
    
    // Recalculate totals when weight inputs change
    $(document).on('input', '.net-weight-input, .gross-weight-input', function() {
        calculateTotals();
    });
    
    // Validate weight (gross should be >= net)
    $(document).on('blur', '.gross-weight-input', function() {
        const $entry = $(this).closest('.truck-entry');
        const netWeight = parseFloat($entry.find('.net-weight-input').val()) || 0;
        const grossWeight = parseFloat($(this).val()) || 0;
        
        if (grossWeight < netWeight) {
            $(this).addClass('is-invalid');
            Swal.fire({
                icon: 'warning',
                title: 'Weight Validation',
                text: 'Gross weight cannot be less than net weight.',
            });
        } else {
            $(this).removeClass('is-invalid');
        }
        calculateTotals();
    });
    
    // Initialize with one truck entry
    addTruckEntry();
    
    $('#search_btn_id').click(function(){
        var sales_contract_no = $('#sales_contact_no').val();
        if(sales_contract_no == ""){
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Sales contract can not empty..!!',
            });
            return;
        }
        
        $('#sales_contact_no').val("");
        $('#example1').dataTable().fnDestroy(); 
        var table = $('#example1').DataTable({
            "ajax": {
                "url": "/search/sales_contact",
                "type": "GET",
                "data": {
                    "sales_contract_no": sales_contract_no,
                    "_token": $('input[name=_token]').val()
                },
                "dataSrc": function (json) {
                    if(json.data && json.data.length > 0) {
                        return json.data;
                    } else {
                        return false;
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
                { "data": "sales_contract_no"},
                { "data": "sales_contract_date"},
                { "data": "invoice_no"},
                { "data": "company"},
                { "data": "bank"},
                { "data": "final_destination"},
                { "data": "status"},
                { 
                    "data": null,
                    render: function(data, type, row){
                        return '<a href="{{url("/sale_contract/factory_details")}}/'+row.id+'"><button type="button" class="btn btn-xs btn-info btn-flat">View</button></a> ' +
                               '<button type="button" class="btn btn-xs btn-success btn-flat btn-truck-simple" data-id="'+row.id+'" title="Simple Truck Update">Truck</button> ' +
                               '<button type="button" class="btn btn-xs btn-warning btn-flat btn-truck-details" data-id="'+row.id+'" title="Detailed Truck Update">Truck Details</button>';
                    }
                }
            ],
            "language": {
                "emptyTable": "No records available"
            },
            "dataSrc": function (json) {
                if (!json.data || json.data.length === 0) {
                    return false;
                }
                return json.data;
            }
        });
    });

    // Simple truck modal open handler
    $('#example1').on('click', '.btn-truck-simple', function (e) {
        e.preventDefault();
        var sales_contact_id = $(this).data('id');
        if(sales_contact_id){
            $.ajax({
                type: 'GET',
                url: "{{url('/json/get/truck/numbers')}}",
                data: {'sale_contract_id': sales_contact_id, '_token': $('input[name=_token]').val()},
                success: (res) => {
                    $('#factoryUpdateModal #sales_contact_id').val(sales_contact_id);
                    $('#factoryUpdateModal #truck_numbers').val(res.msg || '');
                    $('#factoryUpdateModal #truck_loaded_date').val(res.date || '');
                    $('#factoryUpdateModal').modal('show');
                },
                error: function(data){
                    console.log(data);
                }
            });
        }
    });

    // Multiple truck modal open handler
    $('#example1').on('click', '.btn-truck-details', function (e) {
        e.preventDefault();
        var sales_contact_id = $(this).data('id');
        if(sales_contact_id){
            // Reset form
            $('#multipleTruckForm')[0].reset();
            $('#truck-container').empty();
            truckCounter = 1;
            
            // Set sales contract ID
            $('#multiple_sales_contact_id').val(sales_contact_id);
            
            // Get existing truck data
            $.ajax({
                type: 'GET',
                url: "{{url('/json/get/truck/details')}}",
                data: {
                    'sale_contract_id': sales_contact_id,
                    '_token': $('input[name=_token]').val()
                },
                success: (res) => {
                    // Set date
                    if(res.date) {
                        $('#truck_loaded_date_multi').val(res.date);
                    }
                    
                    // Check if we have detailed truck data
                    if(res.trucks && res.trucks.length > 0) {
                        // Add entries for each truck
                        res.trucks.forEach(function(truck) {
                            addTruckEntry(truck);
                        });
                    } else {
                        // Check if we have simple truck data
                        if(res.msg) {
                            // Parse simple truck numbers (comma separated)
                            const truckNumbers = res.msg.split(',').map(num => num.trim()).filter(num => num !== '');
                            truckNumbers.forEach(function(truckNumber) {
                                addTruckEntry({truck_number: truckNumber});
                            });
                        } else {
                            // Add one empty entry
                            addTruckEntry();
                        }
                    }
                    
                    $('#multipleTruckModal').modal('show');
                },
                error: function(xhr) {
                    // If detailed endpoint fails, show empty form
                    addTruckEntry();
                    $('#multipleTruckModal').modal('show');
                }
            });
        }
    });

    // Simple truck form submission
    $("#upateSubmitFormId").submit(function (e) {
        e.preventDefault(); 
        $.ajax({
            type: 'POST',
            url: "{{ url('/update/truck/numbers')}}",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: (res) => {
                if(res.code == 200){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Updated Successfully Done..!!',
                        showConfirmButton: false,
                        timer: 1500
                    });   
                    $('#factoryUpdateModal').modal('hide');
                }
            },
            error: function(data){
                console.log(data);
            }
        });    
    });

    // Multiple truck form submission
    $("#multipleTruckForm").submit(function (e) {
        e.preventDefault();
        
        // Validate form
        let isValid = true;
        let errorMessages = [];
        
        // Check required fields - Added unit-input back
        $('.truck-no-input, .unit-input, .net-weight-input, .gross-weight-input').each(function() {
            if ($(this).val().trim() === '') {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        // Check weight validation
        $('.truck-entry').each(function(index) {
            const netWeight = parseFloat($(this).find('.net-weight-input').val()) || 0;
            const grossWeight = parseFloat($(this).find('.gross-weight-input').val()) || 0;
            
            if (grossWeight < netWeight) {
                isValid = false;
                errorMessages.push(`Truck ${index + 1}: Gross weight cannot be less than net weight`);
                $(this).find('.gross-weight-input').addClass('is-invalid');
            }
        });
        
        // Check if date is filled
        if ($('#truck_loaded_date_multi').val().trim() === '') {
            isValid = false;
            errorMessages.push('Truck loaded date is required');
            $('#truck_loaded_date_multi').addClass('is-invalid');
        }
        
        // Add totals to form data - No total_units
        const formData = new FormData(this);
        formData.append('total_net_weight', $('#total-net-weight').val());
        formData.append('total_gross_weight', $('#total-gross-weight').val());
        formData.append('total_trucks', $('#total-trucks').val());
        formData.append('is_detailed', '1');
        
        // Show loading
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');
        
        // Submit the form
        $.ajax({
            type: 'POST',
            url: "{{ url('/update/truck/details')}}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (res) => {
                if(res.code == 200){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Truck details updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });   

                    $('#multipleTruckModal').modal('hide');
                    if ($.fn.DataTable.isDataTable('#example1')) {
                        $('#example1').DataTable().ajax.reload();
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: res.message || 'Failed to update truck details.',
                    });
                }
            },
            error: function(xhr) {
                let errorMsg = 'An error occurred while updating.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMsg,
                });
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Reset multiple truck modal on close
    $('#multipleTruckModal').on('hidden.bs.modal', function () {
        $('#truck-container').empty();
        truckCounter = 1;
        addTruckEntry();
        calculateTotals();
    });
});
</script>
@endsection