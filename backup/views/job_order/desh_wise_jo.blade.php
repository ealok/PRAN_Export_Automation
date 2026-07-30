<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content') 
<style>
  .date-filter-container {
    background: #f4f4f4;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 4px;
    border: 1px solid #ddd;
  }
  
  .date-filter-row {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
  }
  
  .date-input-group {
    display: flex;
    align-items: center;
    gap: 5px;
  }
  
  .date-input-group label {
    margin-right: 5px;
    white-space: nowrap;
    font-weight: bold;
    font-size: 13px;
  }
  
  .date-input-group input {
    padding: 5px 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    height: 30px;
    width: 150px;
  }
  
  .filter-buttons {
    display: flex;
    gap: 10px;
  }
  
  .create-button-container {
    display: flex;
    gap: 10px;
    margin-left: auto;
  }
  
  .table > thead:first-child > tr:first-child > th {
    border: 1px solid #222;
    color: #3c2608;
    text-align: center;
    padding: 8px 4px;
  }
  
  .table-bordered > tbody > tr > td {
    border: 1px solid #222;
    padding: 1px 8px;
    font-weight: bold;
    vertical-align: middle;
  }
  
  table.dataTable {
    width: 99%;
    margin: 0 auto;
    clear: both;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 12px;
  }
  
  .table-bordered > tbody > tr:hover {
    background-color: rgba(101, 212, 97, 0.836);
  }
  
  .loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
  .alert {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 4px;
  }
  
  .btn-flat {
    border-radius: 3px;
    margin: 1px;
    padding: 3px 8px;
    font-size: 12px;
  }

  #jobOrderTable {
    border-collapse: collapse !important;
  }

  /* Or more specifically */
  table#jobOrderTable.dataTable {
    border-collapse: collapse !important;
  }
   
  table.dataTable {
    width: 99%;
    margin: 0 auto;
    clear: both;
    font-size: 11px;
  }

  .btn-flat {
    border-radius: 3px;
    margin: 1px;
    padding: 2px 6px;
    font-size: 11px;
  }
  
  @media (max-width: 768px) {
    .date-filter-row {
      flex-direction: column;
      align-items: flex-start;
    }
    
    .date-input-group {
      width: 100%;
      justify-content: space-between;
    }
    
    .date-input-group input {
      width: 60%;
    }
    
    .filter-buttons {
      width: 100%;
      justify-content: flex-start;
      margin-top: 10px;
    }
    
    .create-button-container {
      margin-left: 0;
      width: 100%;
      justify-content: flex-end;
      margin-top: 10px;
    }
  }
</style>

<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="{{url('/desk/wise/notify/party')}}"><i class="fa fa-dashboard"></i> Notify_Party_List</a></li>
      <li class="active"><a href="{{url('/notify/party/list/desk')}}/{{\Crypt::encrypt($party_id)}}"><i class="fa fa-dashboard"></i> SC_List</a></li>
    </ol>
</section>

<div class="row">
  <div class="col-md-12">
    <!-- Success/Error Messages -->
    @if(Session::has('success'))
      <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success! </strong> {{ Session::get('success') }}
      </div>
    @endif 
    
    @if(Session::has('danger'))
      <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Alert! </strong>{{ Session::get('danger')}}
      </div> 
    @endif 
    
    <div class="box box-primary" style="position: relative; width: 100%;"> 
      
      <!-- Date Filter Section -->
      <div class="date-filter-container">
        <div class="date-filter-row">
          <div class="date-input-group">
            <label for="from_date">From Date:</label>
            <input type="date" id="from_date" name="from_date" class="form-control input-sm" 
                   value="{{$lastDay}}">
          </div>
          <div class="date-input-group">
            <label for="to_date">To Date:</label>
            <input type="date" id="to_date" name="to_date" class="form-control input-sm" 
                   value="{{$firstDay}}">
          </div>
          <!-- Filter Buttons -->
          <div class="filter-buttons">
            <button id="previewBtn" class="btn btn-sm btn-info btn-flat">
              <i class="fa fa-eye"></i> Preview
            </button>
            
            <button id="resetBtn" class="btn btn-sm btn-danger btn-flat">
              <i class="fa fa-refresh"></i> Clear
            </button>
          </div>
        </div>
      </div>
      
      <!-- Hidden Inputs -->
      <input type="hidden" id="party_id" value="{{ $party_id }}">
      <input type="hidden" id="encrypted_party_id" value="{{\Crypt::encrypt($party_id)}}">
      <input type="hidden" id="initial_from_date" value="{{$lastDay}}">
      <input type="hidden" id="initial_to_date" value="{{$firstDay}}">
      
      <!-- Data Table with Loading Overlay -->
      <div class="panel-body table-responsive" style="padding: 0px; position: relative;">
        <div id="loadingOverlay" class="loading-overlay" style="display: none;">
          <div class="text-center">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
            <br>
            <span>Loading data...</span>
          </div>
        </div>
        <div class="table-responsive">
          <table id="jobOrderTable" class="table table-bordered table-responsive table-condenced">
            <thead>
              <tr> 
                <th style="width: 89px; text-align: center;">#ID</th>
                <th style="width: 89px; text-align: center;">JOB Number</th>
                <th style="width: 121px; text-align: center;">Prod_Floor / Out Depo</th>
                <th style="width: 109.6px; text-align: center;">DO Number</th>
                <th style="width: 25px; text-align: center;">Party</th>
                <th style="width: 110.3px; text-align: center;">Invoice No</th>
                <th style="width: 41.9333px; text-align: center;">Status</th>
                <th style="width: 203px; text-align: center;">Action</th>
              </tr>  
            </thead>
            <tbody>
              <!-- Data will be loaded via AJAX -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Item Modal -->
<div id="addItemModal" class="modal fade" role="dialog">
  <div class="modal-dialog">  
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Item to Job Order</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="depo_id">Depo</label>
          <select name="depo_id" id="depo_id" class="form-control" required>
            <!-- Options will be loaded dynamically -->
          </select>
        </div>
        <div class="form-group">
          <label for="sc_item_id">Item</label>
          <select name="sc_item_id" id="sc_item_id" class="form-control" required>
            <option value="">Select Item</option>
            <!-- Options will be loaded dynamically -->
          </select>
        </div>
        <div>
          <input type="hidden" class="form-control" id="job_order_number">
          <input type="hidden" class="form-control" id="sc_id">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info btn-sm" onclick="addNewJobOrderItem()">
          <i class="fa fa-plus"></i> Add Item
        </button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<script>
  document.title = 'Desk Wise JOB';
</script>
<script type="text/javascript">
  $(document).ready(function() {
    // Remove the problematic setTimeout click
    setTimeout(function() { 
      $('.sr-only').click();
    }, 0.0001);
    
    let table;
    
    // Function to show loading overlay
    function showLoading() {
      $('#loadingOverlay').show();
    }
    
    // Function to hide loading overlay
    function hideLoading() {
      $('#loadingOverlay').hide();
    }
    
    // Function to clear table data completely
    function clearTableData() {
      showLoading();
      
      // Destroy existing DataTable if it exists
      if ($.fn.DataTable.isDataTable('#jobOrderTable')) {
        table.destroy();
        $('#jobOrderTable').DataTable().clear().destroy();
      }
      
      // Clear the table body completely
      $('#jobOrderTable tbody').empty();
      
      // Add a message indicating no data
      $('#jobOrderTable tbody').html(
        '<tr><td colspan="7" class="text-center" style="padding: 20px; font-style: italic; color: #666;">' +
        'No data available. Click "Preview" to load data.' +
        '</td></tr>'
      );
      
      // Hide loading
      hideLoading();
    }
    
    // Function to initialize or reload DataTable
    function initializeDataTable() {
      showLoading();
      
      // Destroy existing DataTable if it exists
      if ($.fn.DataTable.isDataTable('#jobOrderTable')) {
        table.destroy();
        $('#jobOrderTable tbody').empty();
      }
      
      // Get filter values
      const partyId = $('#party_id').val();
      const fromDate = $('#from_date').val();
      const toDate = $('#to_date').val();
      
      // Validate dates
      if (fromDate && toDate) {
        if (new Date(fromDate) > new Date(toDate)) {
          alert('From date cannot be greater than To date');
          hideLoading();
          return;
        }
      }
      
      // Initialize DataTable
      table = $('#jobOrderTable').DataTable({
        processing: false,
        serverSide: false,
        searching: true,
        paging: true,
        ordering: true,
        info: true,
        autoWidth: false,
        order: [[0, 'desc']],
        pageLength: 25,
        lengthMenu: [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
        ajax: {
          url: '/json/get/job_order/list',
          type: 'GET',
          data: function(d) {
            return {
              party_id: partyId,
              from_date: fromDate,
              to_date: toDate
            };
          },
          dataSrc: function(json) {

            hideLoading();
            if (!json.success) {
              console.error('API Error:', json.message);
              $('#jobOrderTable tbody').html(
                '<tr><td colspan="7" class="text-center text-danger">' + 
                (json.message || 'Error loading data') + 
                '</td></tr>'
              );
              return [];
            }
            
            // If no data returned, show empty message
            if (!json.data || json.data.length === 0) {
              $('#jobOrderTable tbody').html(
                '<tr><td colspan="7" class="text-center" style="padding: 20px; font-style: italic; color: #666;">' +
                'No job orders found for the selected date range.' +
                '</td></tr>'
              );
              return [];
            }
            
            return json.data.map(function(jobOrder) {
              
              let statusHtml = '';
              let statusColor = '';
              
              if(jobOrder.status == '1') {
                statusHtml = 'Not Approved';
                statusColor = 'black';
              } else if(jobOrder.status == '2') {
                statusHtml = 'Approved';
                statusColor = 'green';
              } else if(jobOrder.status == '3') {
                statusHtml = 'Cancel';
                statusColor = 'red';
              }
              
              let actionsHtml = `
                <a href="/job_order/show/${jobOrder.encrypted_id}" title="Report">
                  <button type="button" class="btn btn-xs btn-primary btn-flat">Report</button>
                </a>`;
              
              if(jobOrder.status == '2') {
                if(jobOrder.job_order_do_status != 'OK') {
                  actionsHtml += `
                    <a href="/job_order/do/create/${jobOrder.encrypted_id}" title="DO">
                      <button type="button" class="btn btn-xs btn-success btn-flat">Do</button>
                    </a>`;
                }
              }
              
              if(jobOrder.status != '2' && jobOrder.status != '3') {
                actionsHtml += `
                  <a href="/job/order/edit/${jobOrder.encrypted_id}" title="Edit">
                    <button type="button" class="btn btn-xs btn-info btn-flat">Edit</button>
                  </a>
                  <button type="button" class="btn btn-xs btn-danger btn-flat use-address" 
                          data-toggle="modal" data-target="#addItemModal" 
                          data-job-number="${jobOrder.job_order_number}">
                    Add Item
                  </button>`;
              }
              
              if(jobOrder.status != '2' && jobOrder.status != '3') {
                actionsHtml += `
                  <a href="/job_order/approve/${jobOrder.encrypted_id}" title="Approve">
                    <button type="button" class="btn btn-xs btn-success btn-flat" 
                            style="background: #3b3c3a;">
                      Approve
                    </button>
                  </a>`;
              }
              
              if(jobOrder.status != '2' && jobOrder.status == '1') {
                actionsHtml += `
                  <a href="/job_order/cancel/${jobOrder.id}" title="Cancel">
                    <button type="button" class="btn btn-xs btn-danger btn-flat">
                      Cancel
                    </button>
                  </a>`;
              }
              
              return {
                sc_id: jobOrder.sc_id,
                job_order_number: jobOrder.job_order_number || '-',
                prod_floor: jobOrder.prod_floor || '-',
                out_depo: jobOrder.out_depo || '-',
                do_number: jobOrder.job_order_do_number || '-',
                party_code: jobOrder.code || '-',
                invoice_no: jobOrder.invoice_no || '-',
                status: `<span style="color:${statusColor}; font-weight:bold;">${statusHtml}</span>`,
                actions: `<div style="flex-wrap: wrap; gap: 2px;text-align:left">${actionsHtml}</div>`
              };
            });
          },
          error: function(xhr, status, error) {
            hideLoading();
            console.error('AJAX Error:', status, error);
            $('#jobOrderTable tbody').html(
              '<tr><td colspan="7" class="text-center text-danger">' +
              'Error loading data. Please try again.' +
              '</td></tr>'
            );
          }
        },
        columns: [
          { 
            data: 'sc_id',
            className: 'text-center'
          },
          { 
            data: 'job_order_number',
            className: 'text-center'
          },
          { 
            data: null,
            render: function(data, type, row) {
              return `${row.prod_floor} / ${row.out_depo}`;
            },
            className: 'text-center'
          },
          { 
            data: 'do_number',
            className: 'text-center'
          },
          { 
            data: 'party_code',
            className: 'text-center'
          },
          { 
            data: 'invoice_no',
            className: 'text-center'
          },
          { 
            data: 'status',
            className: 'text-center'
          },
          { 
            data: 'actions',
            className: 'text-center',
            orderable: false,
            searchable: false
          }
        ],
        language: {
          emptyTable: "No job orders found",
          zeroRecords: "No matching records found",
          info: "Showing _START_ to _END_ of _TOTAL_ entries",
          infoEmpty: "Showing 0 to 0 of 0 entries",
          infoFiltered: "(filtered from _MAX_ total entries)",
          lengthMenu: "Show _MENU_ entries",
          loadingRecords: "Loading...",
          processing: "",
          search: "Search:",
          paginate: {
            first: "First",
            last: "Last",
            next: "Next",
            previous: "Previous"
          }
        },
        initComplete: function() {
          
          $('#jobOrderTable tbody').on('click', '.use-address', function() {
            const jobNumber = $(this).data('job-number');
            loadModalOptions(jobNumber);
          });
        },
        drawCallback: function() {

        }
      });
    }
    
    // Preview Button Click
    $('#previewBtn').on('click', function() {
      initializeDataTable();
    });

    // Reset Button Click - Clears table data and resets dates
    $('#resetBtn').on('click', function() {
      // Get initial dates from hidden inputs
      const initialFromDate = $('#initial_from_date').val();
      const initialToDate = $('#initial_to_date').val();
      
      // Set date inputs to initial values
      $('#from_date').val(initialFromDate);
      $('#to_date').val(initialToDate);
      
      // Clear all table data
      clearTableData();
    });
    
    // Enter key in date inputs
    $('#from_date, #to_date').on('keypress', function(e) {
      if (e.which === 13) {
        $('#previewBtn').click();
      }
    });
    
    // Load modal options
    function loadModalOptions(jobNumber) {
      if (!jobNumber) {
        alert('Job number is missing');
        return;
      }
      
      $.ajax({
        type: "GET",
        url: "{{ url('/job/order/add_item/edit_option') }}",
        data: { job_number: jobNumber },
        success: function (data) {
          if (data && data.length >= 4) {
            // Load depo options
            const depoSelect = $('#depo_id');
            depoSelect.empty();
            if (data[2] && data[2].length > 0) {
              $.each(data[2], function (key, value) {
                depoSelect.append(
                  $("<option></option>")
                    .attr("value", value.id)
                    .text(value.d_code + (value.d_name ? ' - ' + value.d_name : ''))
                );
              });
            }
            
            // Load item options
            const itemSelect = $('#sc_item_id');
            itemSelect.empty();
            itemSelect.append($("<option></option>").attr("value", "").text("Select Item"));
            if (data[0] && data[0].length > 0) {
              $.each(data[0], function (key, value) {
                itemSelect.append(
                  $("<option></option>")
                    .attr("value", value.item_id)
                    .text((value.ci_item_code || '') + " - " + (value.ci_item_name || ''))
                );
              });
            }
            
            $('#job_order_number').val(data[1] || jobNumber);
            $('#sc_id').val(data[3] || '');
          }
        },
        error: function() {
          alert('Error loading options. Please try again.');
        }
      });
    }
    
    // Initial load - Load data based on initial dates on page load
    initializeDataTable();
  });
  
  // Approve Job Order confirmation
  function approveJobOrder(e) {
    const check = confirm("Are you sure you want to Approve?");
    if (!check) {
      e.preventDefault();
      return false;
    }
    return true;
  }
  
  // Cancel Job Order confirmation
  function cancelJobOrder(e) {
    const check = confirm("Are you sure you want to Cancel?");
    if (!check) {
      e.preventDefault();
      return false;
    }
    return true;
  }
  
  // Add new job order item
  function addNewJobOrderItem() {
    const jobOrderNumber = $('#job_order_number').val();
    const scItemId = $('#sc_item_id').val();
    const scId = $('#sc_id').val();
    
    if (!scItemId) {
      alert('Please select an item first.');
      return;
    }
    
    if (!jobOrderNumber) {
      alert('Job order information is missing.');
      return;
    }
    
    $.ajax({
      method: 'POST',
      url: "{{ url('/add_new/job_order/item') }}",
      data: {
        'sc_item_id': scItemId,
        'job_order_number': jobOrderNumber,
        'sc_id': scId,
        '_token': '{{ csrf_token() }}'
      },
      success: function (response) {
        if (response === "item_exist") {
          alert('Item already exists in this job order.');
        } else if (response === "success") {
          alert('Item added successfully.');
          $('#addItemModal').modal('hide');
          // Reload the DataTable
          if ($.fn.DataTable.isDataTable('#jobOrderTable')) {
            $('#jobOrderTable').DataTable().ajax.reload();
          }
        } else if (response === "not_approve") {
          alert('Item approval is not done yet.');
        } else {
          alert('Unexpected response from server.');
        }
      },
      error: function (xhr, status, error) {
        alert('Error adding item: ' + error);
        console.error('AJAX Error:', xhr.responseText);
      }
    });
  }
  
  // Prevent form submission on enter in modal
  $(document).on('keypress', '#addItemModal input, #addItemModal select', function(e) {
    if (e.which === 13) {
      e.preventDefault();
      return false;
    }
  });
</script>
@endsection