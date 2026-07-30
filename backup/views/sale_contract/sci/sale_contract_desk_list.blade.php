<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content') 
<style>
  .table > thead:first-child > tr:first-child > th {
    border: 1px solid #222;
  }
  
  .table-bordered > tbody > tr > td{
    border: 1px solid #222;
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
  
  table.dataTable {
    width: 99%;
    margin: 0 auto;
    clear: both;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 11px;
  }
  
  .table-bordered > tbody > tr:hover{
    background-color: rgba(101, 212, 97, 0.836);
  }

  .breadcrumb{
    position: absolute;
    left: -13px;
    top: 3px;
    padding: 0px 15px;
  }
  
  a {
    color: #3c8dbc;
  }
  
  label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 0px;
    font-weight: 700;
  }
  
  .panel-body {
    padding: 0px;
  }
  
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
  }
  
  .date-input-group input {
    padding: 5px 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    height: 30px;
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
  
  @media (max-width: 768px) {
    .date-filter-row {
      flex-direction: column;
      align-items: flex-start;
    }
    
    .date-input-group {
      width: 100%;
      justify-content: space-between;
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
<div class="row">
  <div class="col-md-12">
    <div class="col-md-12">
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
      <div class="box box-primary">        
        <!-- Date Filter Section -->
        <div class="date-filter-container">
          <div class="date-filter-row">
            <div class="date-input-group">
              <label for="from_date">From Date:</label>
              <input type="date" id="from_date" name="from_date" class="form-control input-sm" value="{{$lastDay}}">
            </div>
            
            <div class="date-input-group">
              <label for="to_date">To Date:</label>
              <input type="date" id="to_date" name="to_date" class="form-control input-sm" value="{{$firstDay}}">
            </div>
            
            <!-- Filter buttons placed after date fields -->
            <div class="filter-buttons">
              <button id="previewBtn" class="btn btn-sm btn-info btn-flat">
                <i class="fa fa-eye"></i> Preview
              </button>
              
              <button id="resetBtn" class="btn btn-sm btn-danger btn-flat">
                <i class="fa fa-refresh"></i> Clear
              </button>
            </div>
            
            
            <!-- Create Sales Contract button on the right -->
            <div class="create-button-container">
              @if(AdminController::isAccessable(28))  
                <a href="{{url('/sale_contract/create')}}/{{\Crypt::encrypt($party_id)}}">
                  <button type="button" class="btn btn-sm btn-primary btn-flat">
                    <i class="fa fa-plus"></i> Create Sales Contract
                  </button>
                </a> 
              @endif
            </div>
          </div>
        </div>
        <input type="hidden" id="initial_from_date" value="{{$lastDay}}">
        <input type="hidden" id="initial_to_date" value="{{$firstDay}}">
        <div class="panel-body table-responsive">
          <table id="saleContractTable" class="table table-bordered table-responsive table-condenced">
            <thead style="background: #68ceac;">
              <tr>
                <th>SL</th>
                <th>SC NO</th>
                <th style="width: 80px">SC Date</th>
                <th style="width: 120px">Invoice No</th>
                <th>Company</th>
                <th>Bank</th>
                <th>Importer</th>
                <th style="width: 56px">Status</th>
                <th style="width: 100px">Controls</th>
              </tr>
            </thead>
            <tbody id="saleContractBody">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
    <form class="form-horizontal" id="delete_modal_form" role="form" method="POST" action="">
      {{ csrf_field() }}
      {{ method_field("DELETE") }}
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete item</h4>
        </div>
        <div class="modal-body">
          <h4>Do you want to delete This item ??</h4>
          <input id="delete_id" type="hidden" name="id">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info pull-left">Yes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>document.title = 'SalesContract';</script>

  <script type="text/javascript">
    setTimeout(function() { 
      $('.sr-only').click();
    }, 0.0001);
    
    $(document).on("click", "#openDeleteModal", function () {
      var delId = $(this).data("id");
      $("#delete_modal_form").attr("action", "{{url('/sale_contract')}}/" + delId);
      $(".modal-body #delete_id").val(delId);
      $("#myModal").modal("show");
    });
  </script>

  <script type="text/javascript">
    var elems = document.getElementsByClassName('duplicate_confirmation');
    var confirmIt = function (e) {
      if (!confirm('Are you sure want to duplicate?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
      elems[i].addEventListener('click', confirmIt, false);
    }
  </script>
 <script>
   $(document).ready(function () {

    let party_id = "{{ $party_id }}";
    
    // Get initial values from hidden inputs
    let initialFromDate = $('#initial_from_date').val();
    let initialToDate = $('#initial_to_date').val();
    
    // Also get from visible inputs for backup
    let originalFromDate = $('#from_date').val();
    let originalToDate = $('#to_date').val();
    
    let table = $('#saleContractTable').DataTable({
        processing: true,
        serverSide: false,
        order: [[0, 'desc']],
        pageLength: 25, // Show 100 rows by default
        lengthMenu: [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]], // Custom dropdown
        
        language: {
            processing: '<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><br></div>',
            emptyTable: "No sale contracts found for the selected date range",
            zeroRecords: "No matching records found"
        },
        ajax: {
            url: '/json/get/sc_party/list',
            type: 'GET',
            data: function (d) {
                d.party_id  = party_id;
                d.from_date = $('#from_date').val();
                d.to_date   = $('#to_date').val();
            },
            dataSrc: function (json) {
                if (!json.success) {
                    return [];
                }
                return json.data.map(function (contract) {
                    let formattedDate = '';
                    if (contract.dated) {
                        let date = new Date(contract.dated);
                        formattedDate =
                            ('0' + date.getDate()).slice(-2) + '-' +
                            ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                            date.getFullYear();
                    }

                    let actions =
                        `<a href="/view/sale_contact/${contract.encrypted_id}/${contract.encrypted_party_id}"
                            class="btn btn-xs btn-success">Show</a>
                        <a href="/jo/create/${contract.encrypted_id}/${contract.encrypted_party_id}"
                            class="btn btn-xs btn-primary" style="margin-left: 4px">Create JO</a>`;
                    return {
                        id: contract.id,
                        sales_contract_no: contract.sales_contract_no,
                        dated: formattedDate,
                        invoice_no: contract.invoice_no ?? '',
                        company: contract.company,
                        bank: (contract.bank_name ?? '') + 
                              (contract.export_no ? '<br><span style="font-size: 10px;font-weight: bold;">' + contract.export_no + '</span>' : ''),
                        importer: contract.final_destination,
                        status: contract.status || '',
                        controls: actions,
                        bgColor:
                            contract.approver_id ? '#668cff' :
                            contract.desk_approver_id ? '#99ffe6' : ''
                    };
                });
            },
            error: function(xhr, error, thrown) {
                table.processing(false);
                $('#saleContractTable tbody').html(
                    '<tr><td colspan="9" class="text-center text-danger">' +
                    'Error loading data. Please try again.' +
                    '</td></tr>'
                );
            }
        },
        columns: [
            { data: 'id' },
            { data: 'sales_contract_no' },
            { data: 'dated' },
            { data: 'invoice_no' },
            { data: 'company' },
            { data: 'bank' },
            { data: 'importer' },
            { data: 'status' },
            { data: 'controls', orderable: false, searchable: false }
        ],
        createdRow: function (row, data) {
            if (data.bgColor) {
                $(row).css('background-color', data.bgColor);
            }
        }
    });

    $('#previewBtn').on('click', function () {
        let fromDate = $('#from_date').val();
        let toDate = $('#to_date').val();
        if (fromDate && toDate) {
            if (new Date(fromDate) > new Date(toDate)) {
                alert('From date cannot be greater than To date');
                return;
            }
        }
        
        table.ajax.reload(null, false);
    });

    $('#resetBtn').on('click', function () {
        // Clear the table
        table.clear().draw();
        $('#saleContractTable tbody').html(
            '<tr><td colspan="9" class="text-center">' +
            'No sale contracts found for the selected date range' +
            '</td></tr>'
        );

        // Reset to initial dates from hidden inputs
        $('#from_date').val(formatDateForInput(initialFromDate));
        $('#to_date').val(formatDateForInput(initialToDate));
    });

    function formatDateForInput(dateString) {

        if (!dateString) return '';
        
        // Check if already in YYYY-MM-DD format
        if (/^\d{4}-\d{2}-\d{2}$/.test(dateString)) {
            return dateString;
        }
        
        // Handle mm/dd/yyyy format
        if (/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(dateString)) {
            const parts = dateString.split('/');
            const month = parts[0].padStart(2, '0');
            const day = parts[1].padStart(2, '0');
            const year = parts[2];
            return `${year}-${month}-${day}`;
        }
        
        // Handle dd-mm-yyyy format if needed
        if (/^\d{1,2}-\d{1,2}-\d{4}$/.test(dateString)) {
            const parts = dateString.split('-');
            const month = parts[1].padStart(2, '0');
            const day = parts[0].padStart(2, '0');
            const year = parts[2];
            return `${year}-${month}-${day}`;
        }
        
        // Try default Date constructor as fallback
        const date = new Date(dateString);
        if (isNaN(date.getTime())) {
            console.error('Invalid date format:', dateString);
            return '';
        }
        
        // Format to YYYY-MM-DD
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`; // Fixed: Changed slash to hyphen
    }
    setTimeout(function() {
        $('#saleContractTable').css('border-collapse', 'collapse');
    }, 100);
    $('#from_date, #to_date').on('keypress', function(e) {
        if (e.which === 13) {
            $('#previewBtn').click();
        }
    });
});
</script>
@endsection