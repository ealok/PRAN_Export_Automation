@extends('layouts.master')
@section('content')
<style>
  /* Styling for the loading spinner */
  .spinner-container {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
    text-align: center;
  }
  .spinner {
    border: 4px solid #f3f3f3; /* Light gray */
    border-top: 4px solid #3498db; /* Blue spinner */
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 2s linear infinite;
  }
  .panel {
    margin-bottom: 20px;
    background-color: #fff;
    border: 1px solid transparent;
      border-top-color: transparent;
      border-right-color: transparent;
      border-bottom-color: transparent;
      border-left-color: transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
    box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
  }
  .panel-default > .panel-heading {
    color: #333;
    background-color: #e8eeeb;
    border-color: #ddd;
  }
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  .box {
    position: relative;
    border-radius: 3px;
    background: #ffffff;
    margin-bottom: 20px;
    width: 100%;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px;
    border-top: 2px solid #3c8dbc;
  }
  #taskTableBody{
    font-size: 12px;
  } 
  .input-group {
    margin-bottom: 3px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .page-btn.active {
    background-color: #171111c2;
    color: white;
    font-weight: bold;
  }
  .input-inline {
    display: flex;
    flex-direction: column;
  }

  .form-control {
    width: 200px;
  }
  /* Table Styling */
  table {
    border-collapse: collapse;
    width: 100%;
    font-size: 14px;
    font-family: 'Arial', sans-serif;
    color: #333;
  }

  th, td {
    border: 1px solid #ddd;
    padding: 12px 15px;
    text-align: center;
  }

  th {
    background-color: #4CAF50; /* Green header */
    color: white;
    font-weight: bold;
    text-transform: uppercase;
  }

  tr:nth-child(even) { background-color: #f9f9f9; }
  tr:nth-child(odd) { background-color: #f2f2f2; }
  tr:hover { background-color: #f1f1f1; }

  /* Country Search Positioned to the Right */
  .search-container {
    position: absolute;
    top: 132px;
    right: 32px;
  }
  .pagination {
    margin-top: -19px;
    float: right;
  }
  .page-btn {
    padding: 5px 10px;
    margin: 2px;
    border: 1px solid #ddd;
    background-color: #f8f9fa;
    cursor: pointer;
    border-radius: 96px;
  }
  .page-btn {
      padding: 5px 10px;
      margin: 2px;
      border: 1px solid #ddd;
      background-color: #f8f9fa;
      cursor: pointer;
  }

  .page-btn.active {
      background-color: #007bff;
      color: white;
      font-weight: bold;
  }
  .bootstrap-select > .dropdown-toggle.bs-placeholder{
    color: #222;
    border: 1px solid;
    width: 191px;
    padding:4px;
    margin-top: 2px;
  }
  .pagination {
    margin-top: -15px;
    float: right;
    position: absolute;
    left: 629px;
  }
  #doDetailsTableBody{
    font-size: 11px;
  }
</style>
<!-- Loading Spinner -->
<div class="spinner-container" id="spinner">
  <div class="spinner"></div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <strong>DO Query</strong>
  </div>
  <div class="panel-body">
    <!-- Date Range Selection and Submit Button -->
    <div class="input-group" style="margin-left: 1px;margin-top: -16px;">
      <div class="input-inline">
        <label for="fromDate"><strong>Buyer</strong></label>
        <select name="party_id" id="party_id" data-live-search="true" class="form-control select2 selectpicker" required type="select"  value="1">
          <option value="">Select</option>
          @foreach ($importers as $importer)
          <option value="{{$importer->id}}">{{$importer->code}}/{{$importer->name}}</option>
          @endforeach  
        </select>
      </div>
      <div class="input-inline">
        <label for="fromDate"><strong>From Date</strong></label>
        <input type="text" id="fromDate" name="fromDate" class="form-control input-sm" placeholder="Select From Date">
        <script>
            $(document).ready(function(){
                var date_input = $('input[name="fromDate"]'); // our date input
                var options = {
                    dateFormat: 'dd-mm-yy', // Format the date
                    todayHighlight: true,   // Highlight today's date
                    autoclose: true        // Close the date picker after selection
                };
                date_input.datepicker(options);
            });
        </script>
      </div>
      <div class="input-inline">
        <label for="toDate"><strong>To Date</strong></label>
        <input type="text" id="toDate" name="toDate" class="form-control input-sm" placeholder="Select To Date">
        <script>
          $(document).ready(function(){
              var date_input = $('input[name="toDate"]'); // our date input
              var options = {
                  dateFormat: 'dd-mm-yy', // Format the date
                  todayHighlight: true,   // Highlight today's date
                  autoclose: true        // Close the date picker after selection
              };
              date_input.datepicker(options);
          });
        </script>
      </div>
      <div class="input-inline">
        <button class="btn btn-primary input-sm" id="searchBtn" style="margin-top: 22px;">Submit</button>
      </div>
    </div>
    <!-- Table for displaying data -->
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>JO Number</th>
          <th>DO Number</th>
          <th>Delivery Invoice</th>
          <th>Total Qty</th>
          <th>Total Value</th>
          <th>DO Date</th>
          <th>Created By</th>
        </tr>
      </thead>
      <tbody id="taskTableBody">
        <!-- Dynamic Task Data will be inserted here -->
      </tbody>
    </table>
    <div id="paginationContainer" class="pagination"></div>
    <table class="table table-bordered" style="margin-top: 45px" id="do_details_table">
      <thead>
          <tr>
              <th>Item_Code</th>
              <th>Item_Name</th>
              <th>DO_Qty</th>
              <th>Sample_Qty</th>
              <th>Depot</th>
              <th>Rate</th>
              <th>Total_Value</th>
          </tr>
      </thead>
      <tbody id="doDetailsTableBody"></tbody>
    </table>
  </div>
</div>

<!-- Country Search Box Positioned to the Right -->
<div class="search-container">
  <div class="input-inline">
    <input type="text" id="searchBuyer" class="form-control input-sm" placeholder="Search.." onkeyup="searchTable()">
  </div>
</div>
<script>document.title = 'DO Query';</script>
<script type="text/javascript">
  setTimeout(function() { $('.sr-only').click(); }, 0.0001); //@@-End
  $('#spinner').hide(); // Show loading spinner
  $('#do_details_table').hide();
  $(document).ready(function() {
    
    const rowsPerPage = 10;
    let currentPage = 1;
    let doSummary = [];
    let filteredTasks = [];
    let doDetails = [];

    // Do NOT call getDefaultDates() on page load anymore
    // Don't prefill date fields here

    function fetchData(partyId = '', fromDate = '', toDate = '') {

        $.ajax({
            url: '/buyer/do_summary',
            type: 'GET',
            dataType: 'json',
            data: { party_id: partyId, from_date: fromDate, to_date: toDate },
            success: function(response) {
              
              doSummary = response.data;  
              filteredTasks = doSummary;
              displayDOData();    
              $('#spinner').hide(); 

            },
            error: function() {
                $('#spinner').hide();
            }
        });
        
    }

    function searchTable() {

        $('#spinner').show();
        let searchQuery = $('#searchBuyer').val().toLowerCase();
        filteredTasks = doSummary.filter(task => 
            task.jo_number.toLowerCase().includes(searchQuery) ||
            task.do_number.toString().includes(searchQuery) ||
            task.delivery_invoice.toString().includes(searchQuery) || 
            task.creator.toString().includes(searchQuery)
        );

        currentPage = 1;
        if(filteredTasks.length === 0) {
            $('#taskTableBody').html('<tr><td colspan="7">No matching data is available to display !!!</td></tr>');
        }else {
          displayDOData();
        }
        $('#spinner').hide();

    }

    $('#searchBuyer').on('keyup', function() {
        searchTable();
    });

    function displayDOData() {
        
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const currentPageData = filteredTasks.slice(start, end);
        let tableBody = '';
        $.each(currentPageData, function(index, item) {
            tableBody += `<tr>
                <td>${item.jo_number}</td>
                <td><a href="javascript:void(0);" class="do-number" data-code="${item.do_number}">${item.do_number}</a></td>
                <td>${item.delivery_invoice}</td>
                <td>${item.total_qty}</td>
                <td>${item.total_value}</td>
                <td>${item.do_date}</td>
                <td>${item.creator}</td>
            </tr>`;
        });

        $('#taskTableBody').html(tableBody);
        generatePagination();

    }

    $(document).on('click', '.do-number', function () {
        
        $('#spinner').show();
        const doNumber = $(this).data('code');
        $.ajax({
            url: '/buyer/do_details',
            type: 'GET',
            dataType: 'json',
            data: { doNumber: doNumber},
            success: function(response) {
              
              doDetails=response.data;
              displayDODetails();
              $('#do_details_table').show();    
              $('#spinner').hide(); 


            },
            error: function() {
                $('#spinner').hide();
            }
        });

    }); 


    function displayDODetails() {
            
      let tableBody = '';
      $.each(doDetails, function(index, value) {
          tableBody += `<tr>
              <td>${value.item_code}</td>
              <td style="text-align: left">${value.item_name}</td>
              <td>${value.do_qty}</td>
              <td>${value.sample}</td>
              <td>${value.depot}</td>
              <td>${value.rate}</td>
              <td>${value.total_value}</td>
          </tr>`;
      });
      $('#doDetailsTableBody').html(tableBody);      

    }

    

    function generatePagination() {

        const totalPages = Math.ceil(filteredTasks.length / rowsPerPage);
        let paginationHtml = '';
        for (let i = 1; i <= totalPages; i++) {
            paginationHtml += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
        }
        $('#paginationContainer').html(paginationHtml);

    }

    window.changePage = function(pageNumber) {

        if (pageNumber >= 1 && pageNumber <= Math.ceil(filteredTasks.length / rowsPerPage)) {
            currentPage = pageNumber;
            displayDOData();
        }
    }

    $('#searchBtn').click(function() {
        $('#spinner').show();
        let fromDate = $('#fromDate').val();
        let toDate = $('#toDate').val();
        let party_id = $('#party_id').val();
        if(!fromDate || !toDate || !party_id) {

            let defaultDates = getDefaultDates();
            fromDate = defaultDates.fromDate;
            toDate = defaultDates.toDate;
            $('#fromDate').val(fromDate);
            $('#toDate').val(toDate);
        }
        fetchData(party_id, fromDate, toDate);

    });
});
</script>
@endsection
