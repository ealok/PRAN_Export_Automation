@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>CI Item List<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/item_group_assign')}}"><i class="fa fa-dashboard"></i>CI Item List</a></li>
    </ol>
    <br>
</section>

<div class="row">
  <div class="col-md-12">
    @if(Session::has('success')) 
    <div class="alert alert-success alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <strong>Success!</strong>{{ Session::get('success') }}
    </div>
    @endif 
    @if(Session::has('danger')) 
    <div class="alert alert-danger alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <strong>Failed!</strong>{{ Session::get('danger') }}
    </div>
    @endif  
  </div>

  <div class="col-md-12">
    <div class="box box-primary">
      <div class="panel-body table-responsive">
        <table id="itemTable" class="table table-bordered table-responsive table-condenced">
          <thead>
            <th>Id</th>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Item Group</th>
            <th>Recipe</th>
            <th>Claim Name</th>
            <th>Claim Percent</th>
            <th>Is Eligible</th>
            <th>Controls</th>
          </thead>
          <tbody>
            <!-- Data will be loaded via DataTable AJAX -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form class="form-horizontal" id="delete_modal_form" role="form" method="POST" action="">
      {{ csrf_field() }}
      {{ method_field("DELETE") }}
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Item</h4>
        </div>
        <div class="modal-body">
          <h4>Do you want to delete this item?</h4>
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

<script>
document.title = 'Item Group | List';

$(document).ready(function() {
    // Initialize DataTable
    $('#itemTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ url('/get-item-list') }}",
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: 'id' },
            { data: 'ci_item_code' },
            { 
                data: null,
                render: function(data) {
                    return data.duplicate_name || data.ci_item_name || '';
                }
            },
            { data: 'item_group_name' },
            { data: 'rcpe_name' },
            { data: 'claim_name' },
            { 
                data: 'claim_percentage',
                render: function(data) {
                    return data ? data + '%' : '';
                }
            },
            {
                data: 'status',
                render: function(data) {
                    if (data == 'Eligible') {
                        return '<span class="label label-success">Eligible</span>';
                    } else {
                        return '<span class="label label-danger">Not Eligible</span>';
                    }
                }
            },
            {
                data: 'id',
                render: function(data) {
                    return '<a href="{{url("/item_group_assign")}}/' + data + '/edit" title="Edit">' +
                           '<button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>';
                },
                orderable: false,
                searchable: false
            }
        ],
        order: [[0, 'desc']],
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        language: {
            emptyTable: "No data available in table",
            processing: "Loading...",
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        // Optional: Add custom classes
        dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-5"i><"col-sm-7"p>>',
        // Optional: Add responsive design
        responsive: true,
        // Optional: Auto width
        autoWidth: false
    });
});

// Delete function
function deleteItem(id) {
    if (confirm('Are you sure you want to delete this item?')) {
        $.ajax({
            url: "{{ url('/item_group_assign') }}/" + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    toastr.success('Item deleted successfully');
                    // Reload DataTable
                    $('#itemTable').DataTable().ajax.reload();
                }
            },
            error: function(xhr) {
                toastr.error('Failed to delete item');
            }
        });
    }
}

// Modal event handler
$(document).on("click", "#openDeleteModal", function () {
    var delId = $(this).data("id");
    $("#delete_modal_form").attr("action", "{{url('/notify_party_user')}}/" + delId);
    $(".modal-body #delete_id").val(delId);
    $("#myModal").modal("show");
});

// Optional: Add custom search with debounce
// $('#customSearch').on('keyup', function() {
//     $('#itemTable').DataTable().search(this.value).draw();
// });

// Optional: Reload data every 5 minutes
// setInterval(function() {
//     $('#itemTable').DataTable().ajax.reload(null, false);
// }, 300000);
</script>

<!-- Optional: Add custom CSS for better styling -->
<style>
/* DataTable custom styling */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.5em 1em;
}
.dataTables_wrapper .dataTables_filter input {
    margin-left: 0.5em;
    padding: 0.3em 0.5em;
    border: 1px solid #ccc;
    border-radius: 3px;
}
.dataTables_wrapper .dataTables_length select {
    padding: 0.3em 0.5em;
    border: 1px solid #ccc;
    border-radius: 3px;
}
.dataTables_wrapper .dataTables_info {
    padding-top: 0.85em;
}
/* Status label styling */
.label {
    padding: 3px 10px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 600;
}
.label-success {
    background-color: #5cb85c;
    color: white;
}
.label-danger {
    background-color: #d9534f;
    color: white;
}
/* Table styling */
.table-condenced > thead > tr > th,
.table-condenced > tbody > tr > td {
    padding: 1px 8px;
    vertical-align: middle;
}
/* Hover effect on rows */
.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}
</style>

@endsection