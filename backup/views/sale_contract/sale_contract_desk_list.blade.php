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
    font-size: 12px;
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
              <input type="date" id="from_date" name="from_date" class="form-control input-sm" value="{{$firstDay}}">
            </div>
            
            <div class="date-input-group">
              <label for="to_date">To Date:</label>
              <input type="date" id="to_date" name="to_date" class="form-control input-sm" value="{{$firstDay}}">
            </div>
            
            <div class="filter-buttons">
              <button id="previewBtn" class="btn btn-sm btn-info btn-flat">
                <i class="fa fa-eye"></i> Preview
              </button>
              
              <button id="resetBtn" class="btn btn-sm btn-danger btn-flat">
                <i class="fa fa-refresh"></i> Reset
              </button>
              
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
        
        <div class="panel-body table-responsive">
          <table id="saleContractTable" class="table table-bordered table-responsive table-condenced">
            <thead style="background: #68ceac;">
              <tr>
                <th>Id</th>
                <th>Sales_contract_no</th>
                <th>Dated</th>
                <th style="width: 205.183px;">Invoice No</th>
                <th>Company</th>
                <th>Bank</th>
                <th>Importer</th>
                <th style="width: 99.017px;">Controls</th>
              </tr>
            </thead>
            <tbody id="saleContractBody">
              <!-- Data will be loaded here via AJAX -->
              <tr>
                <td colspan="8" class="text-center">
                  <i class="fa fa-spinner fa-spin"></i> Loading sale contracts...
                </td>
              </tr>
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

<script>document.title = 'SaleContract';</script>

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

    let table = $('#saleContractTable').DataTable({
        processing: true,
        serverSide: false,

        // ✅ Default sorting by DATE (column index 2)
        order: [[1, 'desc']],

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

                    // ---------- FORMAT DATE ----------
                    let formattedDate = '';
                    if (contract.dated) {
                        let date = new Date(contract.dated);
                        formattedDate =
                            ('0' + date.getDate()).slice(-2) + '-' +
                            ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                            date.getFullYear();
                    }

                    // ---------- ACTION BUTTONS ----------
                    let actions =
                        `<a href="/jo/create/${contract.encrypted_id}/${contract.encrypted_party_id}"
                            class="btn btn-xs btn-primary">Create JO</a>
                         <a href="/view/sale_contact/${contract.encrypted_id}/${contract.encrypted_party_id}"
                            class="btn btn-xs btn-xs btn-success">Show</a>`;

                    return {
                        id: contract.id,
                        sales_contract_no: contract.sales_contract_no,

                        // ✅ DATE OBJECT FOR SORTING + DISPLAY
                        dated: {
                            display: formattedDate,     // shown in UI
                            sort: contract.dated        // raw DB date
                        },

                        invoice_no: contract.invoice_no ?? '',
                        company: contract.company,
                        bank: (contract.bank_name ?? ''),
                        importer: contract.final_destination,
                        controls: actions,
                        bgColor:
                            contract.approver_id ? '#668cff' :
                            contract.desk_approver_id ? '#99ffe6' : ''
                    };
                });
            }
        },

        columns: [
            { data: 'id' },
            { data: 'sales_contract_no' },
            {
                data: 'dated',
                render: {
                    _: 'display',
                    sort: 'sort'
                }
            },
            { data: 'invoice_no' },
            { data: 'company' },
            { data: 'bank' },
            { data: 'importer' },
            { data: 'controls', orderable: false, searchable: false }
        ],

        createdRow: function (row, data) {
            if (data.bgColor) {
                $(row).css('background-color', data.bgColor);
            }
        }
    });

    // 🔄 Reload table on preview
    $('#previewBtn').on('click', function () {
        table.ajax.reload();
    });

});
</script>
@endsection