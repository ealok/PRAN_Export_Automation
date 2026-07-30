@extends('layouts.master')

@section('content') 
<style>
  #example1_wrapper{
    padding: 8px;
  }
</style>

<section class="content-header" style="padding-top: 0;">
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-dashboard"></i> Unposted Ci Doc</li>
    </ol>
    <br>
</section>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px; min-height: 190px;">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-sm-3" style="text-align: right; margin-top: 7px;font-weight: bold">Invoice Number:</div>
                    <div class="col-sm-3">
                        <div class="form-group {{ $errors->has('invoice_no') ? 'has-error' : '' }}">
                            <input type="text" name="invoice_no" id="invoice_no" class="form-control input-sm" required placeholder="Enter Invoice Number">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-info btn-sm" style="margin-top: -1px" id="search_btn_id">Search</button>
                    </div>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-condensed table-hover">
                    <thead style="background: #68ceac;">
                        <tr>
                            <th>#SL</th>
                            <th>PO No</th>
                            <th>Invoice No</th>
                            <th>Invoice Date</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>

    document.title = 'TNA | Final Approval';
    $(document).ready(function() {
        setTimeout(function() { $('.sr-only').click();}, 0.0001);
        $('#search_btn_id').click(function() {
            var invoice_no = $('#invoice_no').val();
            if (invoice_no === "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Invoice cannot be empty..!!',
                });
            } else {
                $('#sales_contract_no').val("");
                $('#example1').dataTable().fnDestroy();
                var table = $('#example1').DataTable({
                    "ajax": {
                        "url": "/search/inv/for/tna_approval",
                        "type": "GET",
                        "data": {
                            "sales_contract_no": invoice_no,
                            "_token": $('input[name=_token]').val()
                        },
                        "dataSrc": function(json) {
                            return json.data || [];
                        }
                    },
                    "columns": [
                        {
                            "data": null,
                            "render": function(data, type, full, meta) {
                                return meta.row + 1;
                            }
                        },
                        { "data": "po_number" },
                        { "data": "invoice_no" },
                        { "data": "invoice_date" },
                        { "data": "status" },
                        {
                          "data": null,
                          "render": function(data, type, row) {

                              return '<button type="button" class="btn btn-xs btn-success btn-flat btn-approve" data-id="'+data.id+'">Approve</button>';

                          }
                        }
                    ],
                    "language": {

                      "emptyTable": "No records available"

                    }
                });
            }
        });

        $('#example1 tbody').on('click', '.btn-approve', function(e) {

            e.preventDefault();
            var sc_id = $(this).data('id');
            if(sc_id){

              Swal.fire({
                title: "Are you sure?",
                text: "You want to approve this.!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Approve it!"
              }).then((result) => {

                  if (result.isConfirmed) {

                    $.ajax({
                        type: 'GET',
                        url: "{{ url('/json/make/tna/final_approval') }}",
                        data: { 'sc_id': sc_id, '_token': $('input[name=_token]').val() },
                        success: function(res) {
                           
                          if(res.code==200){

                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: 'Approval Successfully Done',
                                  showConfirmButton: false,
                                  timer: 1500
                              });

                              var table = $('#example1').DataTable();
                              table.ajax.reload();

                          }else if(res.code==500){

                              Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: 'Approval Fail, For PO Problem'
                              });

                          }

                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });

                  }

              });

            }
            
        });

    });
</script>
@endsection
