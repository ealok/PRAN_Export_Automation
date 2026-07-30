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
 #left_side_style{

    border: 2px solid blue;
    min-height: 440px;  
 }

 .form-control[disabled]{

  background-color: #288a37;
  
 }
 #button_grouo_id{

    position: absolute;
    left: 206px;
    top: 4px;
    z-index: 1;

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

 #right_side_style{
 
  border: 2px solid blue;
  min-height: 439px;
  margin-left: 5px;  

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
.modal-title{
  text-align: center;
  font-size: 17px;
  text-transform: uppercase;
}
.modal-footer {

  padding: 14px; 
  text-align: center;
  margin-top: 181px;
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

  width: 900px;
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
img{

  height: 40px;
  position: absolute;
  top: -3px;
  left: 1051px;

}
.box-header.with-border {

  border-bottom: none;

}

.bootstrap-select > .dropdown-toggle.bs-placeholder {

   width: 358px;

}

.modal-body{
  width: 426px;
  margin: auto;
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
.bootstrap-select > .dropdown-toggle.bs-placeholder, .bootstrap-select > .dropdown-toggle.bs-placeholder:hover {
  color: #222;
  border: 1px solid #0D18B9;
  border-radius: 10px;
}
.modal-footer {
  padding: 14px;
  text-align: center;
}

#tblMain {

   display: block;

}

#po_details_table_id_wrapper{

  padding: 13px;
  margin: auto;

}

#item_add_btn_id{

  padding: 2px 3px;
  font-weight: bold;

}

#tblMain{

  height: 358px;      
  overflow-y: auto;    
  overflow-x: hidden;  
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
hr{

  margin-top: 36px;
  margin-bottom: -20px;
  border-top: 1px solid #d7d2d2;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
    border: 0.25em solid rgba(0, 0, 0, 0.1);
    border-top: 0.25em solid #007bff;
    border-radius: 50%;
    animation: spin 0.75s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

</style>
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/po')}}"><i class="fa fa-dashboard"></i>PO List</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px">
        <div class="box-header with-border">
          <div class="col-sm-4"></div>
          <div class="col-sm-3">
              <label for="name" id="party">Notify Party :</label>
              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                  <select name="party_id" id="party_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                       <option value="">Select</option>
                       @foreach($notifyParties as $notifyParty)
                        <option value="{{$notifyParty->code}}">{{$notifyParty->code}}-{{$notifyParty->name}}</option>
                       @endforeach
                  </select>
              </div>
          </div>
          <hr>
          
        </div>
        <div class="panel-body table-responsive">
          <table id="example" class="table table-bordered table-responsive table-condenced" style="font-size: 12px">
              <thead style="font-size: 12px">
                    <tr>
                        <th>#SL</th>
                        <th>Party</th>
                        <th>Country</th>
                        <th>PO_Number</th>
                        <th>Customer_PO</th>
                        <th>Order_Qty</th>
                        <th>Order_Date</th>
                        <th>Status</th>
                        <th>Doc</th>
                        <th>Action</th>
                    </tr>  
              </thead>
              <tbody></tbody>
          </table>
        </div>
    </div>
  </div>
  <div id="loading-spinner" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); z-index:9999;">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
  </div>
  <div class="col-md-12" id="po_details_div_id">
    <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px;">
          <table class="table table-bordered table-responsive table-condenced" style="margin:auto;margin-top:21px;width: 100%" id="po_details_table_id">
            <thead>
                  <tr style="font-size: 12px">
                      <th>Code</th>
                      <th style="width:3000px">Name</th>
                      <th>Factor</th>
                      <th>Rate_Per(Ctn)</th>
                      <th>Order_Qty(Ctn)</th>
                      <th>Coding_Matter</th>
                      <th>Special_Matter</th>
                      <th>Comments</th>
                  </tr>  
            </thead>
            <tbody id="po_details" style="font-size: 11px"></tbody>
          </table>
        <br></br>
    </div>
  </div>
</div>
<script>document.title = 'GT | Order';</script>
<script type="text/javascript">
  $('#po_details_div_id').hide();
  function showSpinner() {
    $('#loading-spinner').show();
  }

  // Hide the spinner
  function hideSpinner() {
      $('#loading-spinner').hide();
  }
   $(document).ready(function() {

        setTimeout(function() { 
          $('.sr-only').click();
        }, 0.0001);

        $('#po_details_table_id_filter input').on('keyup', function () {

          var columnIndex = $(this).data('column'); // Get the column index
          var searchText = $(this).val().toLowerCase(); // Get the search text
          table.column(columnIndex).search(searchText).draw();
          
        });
         
        $("#party_id").change(function(){
            
           var party_code=$(this).val();
           displayPartyPOs(party_code);
           
        }); 
        function getStatusButtons(row) {
          switch (row.status) {
              case 'Not Rcv':
                  return `
                      <button data-id="${row.id}" class="btn btn-success btn-sm btn-received" title="Received" data-toggle="tooltip">
                          <span class="glyphicon glyphicon-ok"></span>
                      </button>
                      <button data-id="${row.id}" class="btn btn-info btn-sm btn-proced" title="Proceed Order" data-toggle="tooltip" disabled>
                          <span class="glyphicon glyphicon-forward"></span>
                      </button>
                      <button data-id="${row.id}" class="btn btn-danger btn-sm btn-cancel" title="Cancel Report" data-toggle="tooltip">
                          <span class="glyphicon glyphicon-remove"></span>
                      </button>
                  `;
              case 'Rcv':
                  return `
                      <button data-id="${row.id}" class="btn btn-success btn-sm btn-proced" title="Received" data-toggle="tooltip" disabled>
                          <span class="glyphicon glyphicon-ok"></span>
                      </button>
                      <button data-id="${row.id}" class="btn btn-info btn-sm btn-proced" title="Proceed Order" data-toggle="tooltip">
                          <span class="glyphicon glyphicon-forward"></span>
                      </button>
                      <button data-id="${row.id}" class="btn btn-danger btn-sm btn-cancel" title="Cancel Report" data-toggle="tooltip">
                          <span class="glyphicon glyphicon-remove"></span>
                      </button>
                  `;
              case 'Proced':
                  return `
                      <button data-id="${row.id}" class="btn btn-success btn-sm btn-proced" title="Proceed" data-toggle="tooltip" disabled>
                          <span class="glyphicon glyphicon-ok"></span>
                      </button>
                      <button data-id="${row.id}" class="btn btn-info btn-sm btn-proced" title="Proceed Order" data-toggle="tooltip" disabled>
                          <span class="glyphicon glyphicon-forward"></span>
                      </button>
                      <button data-id="${row.id}" class="btn btn-danger btn-sm btn-cancel" title="Cancel Report" data-toggle="tooltip" disabled>
                          <span class="glyphicon glyphicon-remove"></span>
                      </button>
                  `;
              case 'Cancel':
                  return `
                      <button data-id="${row.id}" class="btn btn-success btn-sm btn-proced" title="Proceed" data-toggle="tooltip" disabled>
                          <span class="glyphicon glyphicon-ok"></span>
                      </button>
                      <button data-id="${row.id}" class="btn btn-info btn-sm btn-proced" title="Proceed Order" data-toggle="tooltip" disabled>
                          <span class="glyphicon glyphicon-forward"></span>
                      </button>
                      <button data-id="${row.id}" class="btn btn-danger btn-sm btn-cancel" title="Cancel Report" data-toggle="tooltip" disabled>
                          <span class="glyphicon glyphicon-remove"></span>
                      </button>
                  `;   
              default:
                return `
                    <button data-id="${row.id}" class="btn btn-success btn-sm btn-received" title="Received" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-ok"></span>
                    </button>
                    <button data-id="${row.id}" class="btn btn-info btn-sm btn-proced" title="Proceed Order" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-forward" disabled></span>
                    </button>
                    <button data-id="${row.id}" class="btn btn-danger btn-sm btn-cancel" title="Cancel Report" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                `;
          }
        }
        function displayPartyPOs(party_code){
          
          $(".preload").show();
          $('#example').dataTable().fnDestroy();
          var table = $('#example').DataTable({
              "ajax": {
                  "url": "/json/get/gt_order/list",
                  "type": "GET",
                  "data": {
                      "party_code": party_code,
                      "_token": $('input[name=_token]').val()
                  },
                  "dataSrc": function (json) {
                      return json.data.length > 0 ? json.data : false;
                  }
              },
              "columns": [
                  {
                      "data": null, // For serial number
                      "render": function(data, type, row, meta) {
                          return meta.row + 1; // Auto-increment based on row index
                      }
                  },
                  { "data": "party" },
                  { "data": "country" },
                  {
                      "data": null,
                      render: function(data, type, row) {
                        return `<a href="/demand/${row.id}" class="po_details">${row.po_no}</a>`;
                      }
                  },
                  { "data": "buyer_po" },
                  { "data": "order_qty" },
                  { "data": "order_date" },
                  { "data": "status" },
                  {
                      "data": null,
                      "render": function(data, type, row) {
                        if (row.gt_doc_ref) {
                            return '<a href="http://rqc.rflgroupbd.com:8016/storage/' + row.gt_doc_ref + '" download>' + "Download" + '</a>';
                        } else {
                            return 'No Attach.';
                        }
                      }
                  },
                  {
                      "data": null,
                      "render": function(data, type, row) {
                          return getStatusButtons(row);
                      }
                  }
              ],
              "columnDefs": [
                  { 
                      "width": "20%", // Set width for the "party" column
                      "targets": 1    // Index of the "party" column (zero-based)
                  }
              ],
              "language": {
                  "emptyTable": "No records available"
              }
          });
          
        }
        // Enable tooltips
        $('#example').on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip(); 
        });
        // Handle click Received button
        $('#example tbody').on('click', '.btn-received', function (e) {
            var sc_id = $(this).data('id');
            if (sc_id) {
                Swal.fire({
                    title: "Are you sure?",
                    icon: "warning", // Correct parameter
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Received it!"
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ url('/received/gt_order') }}",
                            type: "get",
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "order_id": sc_id,
                                "template_id": result.value
                            },
                            success: function (res) {
                                
                                if(res.code == 200) {

                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success', // Correct parameter
                                        title: res.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    var table1 = $('#example').DataTable();
                                    table1.ajax.reload(null, false);

                                } else {

                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'error', // Correct parameter
                                        title: res.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                }
                            }
                        });
                    }
                });
            }
        });
        // Handle click Proced button
        $('#example tbody').on('click', '.btn-proced', function (e) {
          var sc_id = $(this).data('id');
          if (sc_id) {
              Swal.fire({
                  title: "Attach a File",
                  html: `
                      <input type="file" id="attachmentFile" class="swal2-input" style="width: auto;">
                      <p>Please select a document to attach before proceeding.</p>
                  `,
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "Proceed",
                  preConfirm: () => {
                      const fileInput = document.getElementById('attachmentFile');
                      if (!fileInput.files.length) {
                          Swal.showValidationMessage('Please select a file!');
                          return false;
                      }

                      const file = fileInput.files[0];
                      const allowedExtensions = ['xlsx', 'xls', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif'];
                      const fileExtension = file.name.split('.').pop().toLowerCase();

                      if (!allowedExtensions.includes(fileExtension)) {
                          Swal.showValidationMessage(
                              'Invalid file format! Only .xlsx, .xls, .doc, .docx, and image files (.jpg, .jpeg, .png, .gif) are allowed.'
                          );
                          return false;
                      }

                      return file; // Return the selected file if valid
                  }
              }).then((result) => {
                  if (result.isConfirmed) {
                      const file = result.value; // Get the selected file
                      if (file) {
                          // Prepare FormData to send file and other data
                          var formData = new FormData();
                          formData.append("_token", "{{ csrf_token() }}");
                          formData.append("order_id", sc_id);
                          formData.append("attachment", file); // Attach the file

                          $.ajax({
                              url: "{{ url('/proced/gt_order') }}",
                              type: "POST",
                              data: formData,
                              processData: false, // Prevent jQuery from processing data
                              contentType: false, // Prevent jQuery from setting Content-Type
                              success: function (res) {
                                  if (res.code == 200) {
                                      Swal.fire({
                                          position: 'top-end',
                                          icon: 'success',
                                          title: res.message,
                                          showConfirmButton: false,
                                          timer: 1500
                                      });
                                      var table1 = $('#example').DataTable();
                                      table1.ajax.reload(null, false);
                                  } else {
                                      Swal.fire({
                                          position: 'top-end',
                                          icon: 'error',
                                          title: res.message,
                                          showConfirmButton: false,
                                          timer: 1500
                                      });
                                  }
                              },
                              error: function (err) {
                                  Swal.fire({
                                      position: 'top-end',
                                      icon: 'error',
                                      title: 'Error occurred!',
                                      text: err.responseJSON.message,
                                      showConfirmButton: false,
                                      timer: 1500
                                  });
                              }
                          });
                      }
                  }
              });
          }
        });
         // Handle click Received button
        $('#example tbody').on('click', '.btn-received', function (e) {
            var sc_id = $(this).data('id');
            if (sc_id) {
                Swal.fire({
                    title: "Are you sure?",
                    icon: "warning", // Correct parameter
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Received it!"
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ url('/received/gt_order') }}",
                            type: "get",
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "order_id": sc_id,
                                "template_id": result.value
                            },
                            success: function (res) {
                                
                                if(res.code == 200) {

                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success', // Correct parameter
                                        title: res.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    var table1 = $('#example').DataTable();
                                    table1.ajax.reload(null, false);

                                } else {

                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'error', // Correct parameter
                                        title: res.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                }
                            }
                        });
                    }
                });
            }
        });
        // Handle click Cancel button
        $('#example tbody').on('click', '.btn-cancel', function (e) {
          var sc_id = $(this).data('id');
          if (sc_id) {
              Swal.fire({
                  title: "Are you sure?",
                  icon: "warning",
                  html: `
                      <textarea id="rejectNote" class="swal2-textarea" placeholder="Write your reject note here..." style="width: 100%; height: 100px;"></textarea>
                  `,
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "Submit",
                  preConfirm: () => {
                      const note = document.getElementById('rejectNote').value;
                      if (!note) {
                          Swal.showValidationMessage("Please write a reject note!");
                      }
                      return note;
                  }
              }).then((result) => {
                  if (result.isConfirmed) {
                      const cancelNote = result.value; // Get the reject note
                      $.ajax({
                          url: "{{ url('/cancel/gt_order') }}",
                          type: "get",
                          dataType: 'json',
                          data: {
                              "_token": "{{ csrf_token() }}",
                              "order_id": sc_id,
                              "cancel_note": cancelNote
                          },
                          success: function (res) {

                              if (res.code === 200) {
                                  Swal.fire({
                                      position: 'top-end',
                                      icon: 'success',
                                      title: res.message,
                                      showConfirmButton: false,
                                      timer: 1500
                                  });
                                  var table1 = $('#example').DataTable();
                                  table1.ajax.reload(null, false);
                              } else {
                                  Swal.fire({
                                      position: 'top-end',
                                      icon: 'error',
                                      title: res.message,
                                      showConfirmButton: false,
                                      timer: 1500
                                  });
                              }

                          },
                          error: function () {
                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'error',
                                  title: 'Something went wrong!',
                                  showConfirmButton: false,
                                  timer: 1500
                              });
                          }
                      });
                  }
              });
          }
        });
        
        // PO Details
        $('#example tbody').on('click', '.po_details', function(e) {
          
          e.preventDefault();
          $('#po_details_div_id').show();  
          $('#po_details_table_id').dataTable().fnDestroy(); 
          var po_id=$(this).data('id');
          var url = $(this).attr('href');
          var table = $('#po_details_table_id').DataTable( {
                paging: false,
                dom: 'Bfrtip', 
                buttons: [
                    'csv', 'excel'
                ],
                ajax:{
                      type: "GET",
                      url: url,
                      data: {'_token': $('input[name=_token]').val()},
                      "dataSrc": function (json) {
                          
                          $('#edit_po_id').val(json.po_edit_id); 
                          if(json.approveStatus=="Y"){
                            
                            $("#item_add_btn_id").attr("disabled", true);
                            $(".edit_all").attr("disabled", true);
                            $(".inactive-item").attr("disabled", true);

                          }else{

                            $("#item_add_btn_id").attr("disabled", false);
                            $(".edit_all").attr("disabled", false);
                            $(".inactive-item").attr("disabled", false);

                          }
                          
                          if(json.data.length > 0) {
                              
                              return json.data;
                              
                          } else {

                              return false;

                          }

                      }
                  },
                columns: [
                  { 
                      "data": null,
                      "render": function (data, type, row) {

                            return '<input type="text"  value="'+row.code+'" disabled>';
                      }

                  },
                  { "data": "item_name" },
                  { "data": "factor" },
                  { "data": "rate_per_ctn" },
                  { 
                      "data": null,
                      render: function(data, type, row) {

                         return '<input type="text" value="'+row.order_qty_ctn+'" width="150px">';  
                      
                      }

                  },
                  { 
                      "data": null,
                      render: function(data, type, row) {

                         return '<input type="text" value="'+row.coding_matter+'" width="150px">';  
                      
                      }

                  },
                  { 
                      "data": null,
                      render: function(data, type, row) {

                         return '<input type="text" value="'+row.special_requirement+'" width="150px">';  
                      
                      }

                  },
                  { 
                      "data": null,
                      render: function(data, type, row) {

                         return '<input type="text" value="'+row.remarks+'" width="150px">';  
                      
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

        $('#example tbody').on('click', '.btn-download', function(e) {

            e.preventDefault();
            const url = "/download/gt_attach"; // The endpoint for downloading
            const docRef = $(this).data('doc'); // Get the document reference
            
            // Send the GET request with docRef as a query parameter
            $.get(url, { docRef: docRef }, function(data) {
                // Assuming the server returns the file URL or file data
                if (data.fileUrl) {
                    // If the server returns a URL for the file
                    const a = document.createElement('a');
                    a.href = data.fileUrl; // Set the file URL
                    a.download = data.fileName || 'downloaded_file'; // Optional: specify a default file name
                    a.click(); // Trigger the download
                } else {
                    console.error('No file URL received');
                }
            }).fail(function(xhr, status, error) {
                console.error("Error:", error); // Handle errors
            });

        });
  
     });
</script>
<script>
  $('#example').DataTable({
    "order": [[ 0, "DESC" ]],
    "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100,"All"]]
  });
  $('#po_details_table_id').DataTable({
    "order": [[ 0, "DESC" ]],
    "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100,"All"]]
  });
</script>
@endsection