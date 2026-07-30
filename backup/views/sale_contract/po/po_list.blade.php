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
  left: 254px;
  top: 7px;
  z-index: 1;

 } 

 .modal-body{

  position: relative;
  top: -12px;
  padding: 18px;
  width: 426px;
  margin: auto;
  min-height: 200px;

 }

 .modal-header .close {

  margin-top: -22px;

 }
 .ms-options {
    width: 300px; /* Set your desired width */
}

.ms-options ul {
    width: 100%; /* Ensures the list inside the select box takes full width of its parent */
}

.ms-options-wrap > .ms-options {
  position: absolute;
  left: 0;
  width: 361px;
  margin-top: 1px;
  margin-bottom: 20px;
  background: white;
  z-index: 2000;
  border: 1px solid #aaa;
}
.modal-footer {
  border-top-color: #cecaca;
  margin-top: 31px;
}
.ms-options .ms-search input {
    width: 100%; /* Optional: Make the search input take the full width of the container */
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
.btn {
  padding: 0px 2px !important;
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
  font-size: 13px;
  text-transform: uppercase;
  font-weight: bold;
}
.modal-footer {

  padding: 14px; 
  text-align: center;
  margin-top: 20px;
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
div.container table.dataTable {
    border-collapse: collapse;
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
table.dataTable thead th{
  padding: 4px 18px;
}
.bootstrap-select > .dropdown-toggle.bs-placeholder {
  width: 358px;
  height: 28px;
}
hr{

  margin-top: 36px;
  margin-bottom: -20px;
  border-top: 1px solid #d7d2d2;
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
          <table id="example" class="table table-bordered table-responsive table-condenced" style="font-size: 12px;width: 100%">
              <thead style="font-size: 12px">
                    <tr>
                        <th>SL#</th>
                        <th>Order(Number)</th>
                        <th>Order(Date)</th>
                        <th>Order(Type)</th>
                        <th>Order(Qty)</th>
                        <th>Order(Status)</th>
                        <th>GSM(Status)</th>
                        <th>Attachment</th>
                        <th>Action</th>
                    </tr>  
              </thead>
              <tbody></tbody>
          </table>
        </div>
    </div>
  </div>
  <div class="col-md-12" id="po_details_div_id">
    <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px;">
         <div class="box-header with-border" id="button_grouo_id">
            <input type="button" class="btn btn-primary btn-sm"  value="+Add Item" id="item_add_btn_id">
            <input type="button" class="btn btn-info btn-sm edit_all" value="Update" style="font-weight: bold;">
            <input type="button" class="btn btn-danger btn-sm inactive-item" value="Inactive">
          </div>
          <table class="table table-bordered table-responsive table-condenced" style="margin:auto;margin-top:21px" id="po_details_table_id">
            <thead>
                  <tr style="font-size: 12px">
                      <th>SL</th>
                      <th>Code</th>
                      <th style="width:3000px">Name</th>
                      <th>Factor</th>
                      <th>Rate_Per(Ctn)</th>
                      <th>Order_Qty(Ctn)</th>
                      <th>Coding_Matter</th>
                      <th>Special_Requirment</th>
                      <th>Remarks</th>
                  </tr>  
            </thead>
            <tbody id="po_details" style="font-size: 11px"></tbody>
          </table>
        <br></br>
    </div>
    <input type="hidden" id="edit_po_id" value="">
  </div>
  <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form class="form-horizontal" id="postForm">
        @csrf
        <div class="modal-content" style="width: 424px;margin:auto">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">GT User Selected Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="col-sm-12">
                <div class="form-group{{ $errors->has('user_ids') ? 'has-error' : '' }}">
                  <label for="user_ids">User</label>
                  <select name="user_ids[]"  multiple id="user_ids">
                       @foreach($users as $user) 
                       <option value="{{$user->id}}">{{$user->username}}/{{$user->name}}</option>
                       @endforeach
                  </select>
                  <input type="hidden" name="po_id" id="po_id" value="">
                  <input type="hidden" name="order_type" id="order_type" value="">
                  @if($errors->has('user_ids'))
                      <span class="help-block"><strong>{{ $errors->first('user_ids') }}</strong></span>
                  @endif  
                </div>
              </div>
          </div>
          <br>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-flat btn-md" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-info btn-flat btn-md" value="Post">
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="modal fade" id="addNewItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form class="form-horizontal" id="myForm">
        <div class="modal-content" style="width: 424px;margin:auto">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Item</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="col-sm-12">
                  <div class="form-group {{ $errors->has('item_id') ? 'has-error' : '' }}">
                      <label for="sales_contract_no">Item</label>
                      <select name="mitem_id" id="mitem_id" data-live-search="true" class="form-control selectpicker">
                        <option value="">Select Item</option>

                      </select>  
                      @if ($errors->has('item_id'))
                          <span class="help-block"><strong>{{ $errors->first('item_id') }}</strong></span>
                      @endif
                  </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
                  <label for="sales_contract_no">Item Name</label>
                  <input name="mitem_name" id="mitem_name" type="text"  class="form-control input-sm"   value=""    autofocus max="191"  placeholder="Item Factor(Auto Load)" >
                  @if ($errors->has('sales_contract_no'))
                      <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                  @endif
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
                  <label for="sales_contract_no">Factor</label>
                  <input name="m_factor" type="text" id="m_factor" class="form-control input-sm"   value=""    autofocus max="191"  placeholder="Item Factor(Auto Load)" >
                  @if ($errors->has('sales_contract_no'))
                      <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                  @endif
                </div>
              </div>
              <div class="col-sm-12">
                  <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
                    <label for="sales_contract_no">Order Quantity</label>
                    <input name="m_order_qty" type="text" id="m_order_qty" class="form-control input-sm"   value=""    autofocus max="191"  placeholder="Enter Order Quantity" >
                    @if ($errors->has('sales_contract_no'))
                        <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                    @endif
                  </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
                  <label for="sales_contract_no">Remarks</label>
                  <input name="m_specification" type="text" id="m_specification" class="form-control input-sm"   value=""     max="191"  placeholder="Enter Specifications" >
                  @if ($errors->has('sales_contract_no'))
                      <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                  @endif
                </div>
            </div>
          </div>
          <br>
          <div class="modal-footer">
            <input type="submit" class="btn btn-info btn-flat pull-right" style="margin-left: 4px;" value="Submit">
            <button type="button" class="btn btn-danger btn-flat pull-right" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>document.title = 'Export | Order List';</script>
<script type="text/javascript">
  $('#po_details_div_id').hide();
   $(document).ready(function() {

        setTimeout(function() { 
          $('.sr-only').click();
        }, 0.0001);
        $('#user_ids').multiselect({
            columns: 1,
            search: true,
            selectAll: true,
            onDropdownShow: function() {
                $('#user_ids option').prop('selected', false);
                $('#user_ids').multiselect('refresh'); // Refresh multiselect to reflect the change
            }
        });
        $('#po_details_table_id').DataTable(); // Assuming you're using DataTables plugin for this table

        $('#po_details_table_id_filter input').on('keyup', function () {

          var columnIndex = $(this).data('column'); // Get the column index
          var searchText = $(this).val().toLowerCase(); // Get the search text
          table.column(columnIndex).search(searchText).draw();
          
        });
        
        //Item Add Form Submit

        $("#myForm").submit(function (e) {
            
            e.preventDefault();
            var item_id=$('#mitem_id').val();
            var item_name=$('#mitem_name').val();
            var item_factor=$('#m_factor').val();
            var order_qty=$('#m_order_qty').val();
            var specification=$('#m_specification').val();
            var po_master_id=$('#edit_po_id').val();
            if(item_name==""){
              
                Swal.fire(
                  'Alert!',
                  'Please Enter Item Name.!',
                  'warning'
                );

            }else if(order_qty==""){
                  
              Swal.fire(
                    'Alert!',
                    'Please enter order qty.!',
                    'warning'
                  );

            }else{

                  $.ajax({
                        method: 'POST',
                        url: "/json/add/master/item",
                        data: {'item_id': item_id,'item_name':item_name,'item_factor': item_factor,'order_qty':order_qty,'specification':specification,'po_master_id':po_master_id,'_token': $('input[name=_token]').val()},
                        success: function (value) {
                                                       
                          if(value.status=="alredy_exist"){

                              Swal.fire(
                                'Alert!',
                                'This item already exists.!',
                                'warning'
                              );

                              $('#mitem_id').val('').selectpicker('refresh');
                              $('#m_factor').val("");
                              $('#m_order_qty').val("");
                              $('#m_specification').val("");
                              $("#addNewItemModal").modal("hide"); 
                            
                          }else if(value.status=="success"){
                          
                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: 'Item Successfully Added',
                                  showConfirmButton: false,
                                  timer: 1500
                              }); 

                              $('#mitem_id').val('').selectpicker('refresh');
                              $('#m_factor').val("");
                              $('#m_order_qty').val("");
                              $('#m_specification').val("");
                              $("#addNewItemModal").modal("hide"); 
                              var table2 = $('#po_details_table_id').DataTable();
                              table2.ajax.reload();
                            
                          }
                                                                        
                        },
                        error: function (e) {

                            console.log(e);
                        }
                      
                    });   
              

               }

        });
        
       $("#item_add_btn_id").click(function(){
           
          var edit_po_id=$('#edit_po_id').val(); 
          var $el = $('#mitem_id');
          if(edit_po_id){
            
              $.ajax({
                url: "{{url('/json/po_wise/party_item')}}",
                type: "get",
                dataType: "json",
                data: {'edit_po_id':edit_po_id,'_token': $('input[name=_token]').val()},
                success: function(res) {
                    
                  if(!res.results){

                        $el.html('');
                        $el.append($("<option></option>").attr("value", "").text("---"));
                        $el.selectpicker('destroy');

                    }else{

                        $el.html(' ');
                        $el.append($("<option></option>").attr("value", "").text("Select"));
                        $.each(res.results, function(key,value) {

                            $el.append($("<option></option>").attr("value", value['id']).text(value['ci_item_code']+'-'+value['ci_item_name']));

                        });
                        $el.selectpicker('refresh');

                    }  
                                        
                }
                
              }); 

          }
          $("#addNewItemModal").modal("show"); 

       });

       $("#mitem_id").change(function(){
             
            var item_id=$(this).val();
            var url = "{{url('/json/get/item/factor')}}?item_id="+item_id;
            $.get(url, function(data) {
                  
                if(data.factor){
                   
                  $('#m_factor').val(data.factor);
                  $('#mitem_name').val(data.ci_item_name);

                }else{

                  $('#m_factor').val(""); 

                } 
                
                
            });

      }); 

  //       //@@--Single edit----------
  //       $("#po_details").on("click", ".btn-edit", function(){
          
  //         Swal.fire({
  //           title: 'Are you sure?',
  //           text: "You won't be able to revert this!",
  //           icon: 'warning',
  //           showCancelButton: true,
  //           confirmButtonColor: '#3085d6',
  //           cancelButtonColor: '#d33',
  //           confirmButtonText: 'Yes, Update it!'
  //         }).then((result) => {

  //             if (result.isConfirmed) {

  //               var row = $(this).closest("tr");
  //               var item_code = row.find("td:eq(1) input[type='text']").val();  
  //               var order_qty = row.find("td:eq(5) input[type='text']").val();
  //               var coding_matter = row.find("td:eq(6) input[type='text']").val();
  //               var special_requirement = row.find("td:eq(7) input[type='text']").val();
  //               var specifications = row.find("td:eq(8) input[type='text']").val();
  //               var edit_id=$('#edit_po_id').val();
  //               if(order_qty==""){
                  
  //                     Swal.fire({ 

  //                       title: 'Alert ! <br> Order can not empty..!!',

  //                     });

  //               }else{

  //                     $.ajax({
  //                       url: "{{url('/update/single/demand')}}",
  //                       type: "get",
  //                       dataType: "json",
  //                       data: {'edit_po_id':edit_id,'item_code':item_code,'order_qty':order_qty,'coding_matter':coding_matter,'special_requirement':special_requirement,'specifications':specifications,'_token': $('input[name=_token]').val()},
  //                       success: function(res) {

  //                           if(res.message=="Success"){

  //                                 Swal.fire({
  //                                     position: 'top-end',
  //                                     icon: 'success',
  //                                     title: 'Updated Successfully Done',
  //                                     showConfirmButton: false,
  //                                     timer: 1500
  //                                 });
 
  //                                 var table1 = $('#example').DataTable();
  //                                 table1.ajax.reload();
  //                                 var table2 = $('#po_details_table_id').DataTable();
  //                                 table2.ajax.reload();

  //                           }else if(res.message=="Fail"){
                                
  //                                 Swal.fire({
  //                                     position: 'top-end',
  //                                     icon: 'error',
  //                                     title: 'Not Updated Done',
  //                                     showConfirmButton: false,
  //                                     timer: 1500
  //                                 });  

  //                           }
                          
  //                       }
                      
  //                   });

  //               }
  
  //             }

  //         });  
    
  //       });

        $("#party_id").change(function(){
            
           var party_code=$(this).val();
           displayPartyPOs(party_code);
           
        }); 

        function displayPartyPOs(party_code){
           
          $(".preload").show();
          $('#example').dataTable().fnDestroy(); 
          var table = $('#example').DataTable({
                "ajax": {
                    "url": "/getPOs",
                    "type": "GET",
                    "data": {
                       "party_code": party_code,
                       "_token": $('input[name=_token]').val()
                      },
                    "dataSrc": function (json) {

                        if(json.data.length > 0) {

                            return json.data;
                            
                        } else {

                             return false;

                        }

                    }
                },
                "columns": [
                   { 
                        "data": null, 
                        "width": "5%",
                        "render": function(data, type, row, meta) {
                            return meta.row + 1; // Serial number starts from 1
                        }
                    },
                    { "data": null, "width": "10%",
                        render: function(data, type, row) {
                            return '<a href="/demand/' + row.id + '">' + row.po_no + '</a>'
                        }
                    },
                    { "data": "po_date", "width": "15%" }, 
                    { "data": "order_type", "width": "10%" }, 
                    { "data": "order_qty", "width": "10%" }, 
                    { "data": "status", "width": "15%" }, 
                    { "data": "gt_status", "width": "15%" }, 
                    {
                      "data": null,
                      "render": function(data, type, row) {
                        if (row.gt_doc_ref) {
                            return '<a href="http://localhost:8082/storage/' + row.gt_doc_ref + '" download>' + "Download" + '</a>';
                        } else {
                            return 'No Attach.';
                        }
                      }
                    },
                    {
                      "data": null,
                      "width": "20%",
                      render: function(data, type, row) {
                          if(row.status == "Posted"){
                              return '<input type="button" data-id="' + row.id + '" data-order-type="'+row.order_type+'" class="btn btn-primary btn-sm btn-approved" value="Approve" disabled> | <input type="button" data-id="' + row.id + '" class="btn btn-danger btn-sm btn-cancel" value="Cancel">'
                          }    
                          else if(row.status == "Cancel"){
                               
                               return '<input type="button" data-id="' + row.id + '" data-order-type="'+row.order_type+'" class="btn btn-primary btn-sm btn-approved" value="Approve" disabled> | <input type="button" data-id="' + row.id + '" class="btn btn-danger btn-sm btn-cancel" value="Cancel" disabled>'
                          }else {
                              return '<input type="button" data-id="' + row.id + '"  data-order-type="'+row.order_type+'" class="btn btn-success btn-sm btn-approved" value="Approve"> | <input type="button" data-id="' + row.id + '" class="btn btn-danger btn-sm btn-cancel" value="Cancel">'
                          }
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
          
        }
        //@@@---Action Function For Download Button
        $('#example tbody').on('click', '.btn_download', function (e) {
        
            var po_id=$(this).data('id');  
            var url ="{{url('/json/download/po/item')}}?po_id="+po_id;
            window.open(url, '_self');
                  
        });
         //@@@---Action Function For Cancel Button
        $('#example tbody').on('click', '.btn-cancel', function (e) {
        
           var po_id=$(this).data('id'); 
           Swal.fire({
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, Cancel it!"
            }).then((result) => {

              if (result.isConfirmed) {

                  $.ajax({
                    url: "{{ url('/cancel/po')}}",
                    type: "get",
                    dataType: 'json',
                    data: {
                      "_token": "{{ csrf_token() }}",
                      "po_id": $(this).data('id'),
                      "template_id": result.value
                    },
                    success: function(res) {
                        
                      if(res.status=='Success'){

                          Swal.fire({
                              position: 'top-end',
                              icon: 'success',
                              title: 'Cancel Successfully Done',
                              showConfirmButton: false,
                              timer: 1500
                          });

                          var table = $('#example').DataTable();
                          table.ajax.reload();
                          $('#po_details_div_id').hide();

                      }else if(res.status=='Alert'){
                           
                        Swal.fire({
                          icon: "warning",
                          title: "Oops...",
                          text: "Scouring Team Not Cancel Yet!",
                        });

                      }else if(res.status=='Error'){
                        
                        Swal.fire({
                          icon: "error",
                          title: "Oops...",
                          text: "Something went wrong!",
                        });
                         
                      }

                    }

                  }); 

              }

            });
                
        }); 

        // Handle click Approve button
        // $('#example tbody').on('click', '.btn-approved', function (e) {

        //     var po_id=$(this).data('id');
            
        //     // var order_type=$(this).data('order-type');
        //     // $('#po_id').val(po_id);
        //     // $('#order_type').val(order_type);
        //     // $('#approveModal').modal('show');  
            
              
        // });

        $('#example tbody').on('click', '.btn-approved', function (e) {

          e.preventDefault();
          var po_id = $(this).data('id');
          // Step 1: Confirmation alert
          Swal.fire({
              title: 'Are you sure?',
              text: 'Do you want to approve this Order?',
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Approve it!',
              cancelButtonText: 'Cancel'
          }).then((result) => {
              if (result.isConfirmed) {

                  // Step 2: Send AJAX request only after confirmation
                  $.ajax({
                      url: '/approve/po',
                      type: 'GET',
                      data: { po_id: po_id },
                      success: function (response) {

                          if (response.status === 'Success' && response.approve_status === 'Y') {
                              Swal.fire({
                                  title: 'Approved!',
                                  text: 'Purchase Order has been approved successfully.',
                                  icon: 'success',
                                  timer: 2000,
                                  showConfirmButton: false
                              });

                              // reload datatable
                              $('#example').DataTable().ajax.reload();
                          } 
                          else {
                              Swal.fire({
                                  title: 'Failed!',
                                  text: 'Approval failed. Please try again.',
                                  icon: 'error'
                              });
                          }
                      },
                      error: function (xhr, status, error) {
                          Swal.fire({
                              title: 'Error!',
                              text: 'Something went wrong while approving the order.',
                              icon: 'error'
                          });
                      }
                  });
              }
          });
      });


        //@@@---Submit Form----
        $("#postForm").submit(function (e) {
              
              e.preventDefault(); 
              var userIds = $("#user_ids").val();
              var orderType=$('#order_type').val();
              if(orderType=='GT'){
                if(!userIds || userIds.length === 0) {
                  Swal.fire({
                    icon: "warning",
                    title: "Alert",
                    text: "Select at least one user..!",
                  }); 
                  return; // Stop form submission
                }
              }
             
              $.ajax({
                type:'POST',
                url: "{{ url('/approve/po')}}",
                data: new FormData(this),
                cache:false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in the header
                },
                success: (res) => {
      
                    if(res.status=="Success"){
                        
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: "Posted successfully done..!!",
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#category_ids').empty();
                        $("#approveModal").modal("hide");
                        $('#user_ids').val([]).trigger('change');
                        var table1 = $('#example').DataTable();
                        table1.ajax.reload();
                        
                    }else{

                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: "Posted Failed..!!"
                        });

                    }
                            
                },
                error: function(data){

                    console.log(data);
                    
                }
          
              });   
                
          }); //@@@End Submit
          // PO Details
          $('#example tbody').on('click', 'td a', function(e) {
          
            e.preventDefault();
            $('#po_details_div_id').show();  
            $('#po_details_table_id').dataTable().fnDestroy(); 
            var po_id=$(this).data('id');
            var url = $(this).attr('href');
            var table = $('#po_details_table_id').DataTable( {
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
                        render: function(data, type, row) {
                            return '<input type="checkbox" data-id="'+row.id+'" name="record" id="record">';  
                        }
                    },
                    { 
                        "data": null,
                        "render": function (data, type, row) {
                            return '<input type="text" value="'+row.code+'">' +
                                  '<input type="hidden" value="'+row.id+'" class="row-id">'; // Hidden input for storing the ID
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
                  dom: 'Bfrtip', // Enable buttons
                  buttons: [
                      {
                          extend: 'csvHtml5',
                          text: 'CSV',
                          filename: 'PO_Details' // Default name for CSV
                      },
                      {
                          extend: 'excelHtml5',
                          text: 'Excel',
                          filename: 'PO_Details' // Custom name for Excel file
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

      //@@--Update PO Items----------  
      $(".edit_all").on("click",function(){   

            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Update it!'

        }).then((result) => {
           
           if(result.isConfirmed){
              
              var edit_po_id=$('#edit_po_id').val();
              var editPoDetails = new Array();
              $("#po_details_table_id tbody TR").each(function () {

                  var row = $(this);
                  var po_info = {};
                  po_info.line_id = row.find("input[type='hidden']").val();
                  po_info.item_code=row.find("td:eq(2) input[type='text']").val();
                  po_info.order_qty=row.find("td:eq(5) input[type='text']").val();
                  po_info.coding_matter=row.find("td:eq(6) input[type='text']").val();
                  po_info.special_requirement=row.find("td:eq(7) input[type='text']").val();
                  po_info.remarks=row.find("td:eq(8) input[type='text']").val();
                  editPoDetails.push(po_info);

              });

              if(editPoDetails.length>0){
                
                  $.ajax({
                    url: "{{url('/update/all/demand')}}",
                    type: "post",
                    dataType: "json",
                    data: {'edit_po_id':edit_po_id,'editPoDetails':editPoDetails,'_token': $('input[name=_token]').val()},
                    success: function(res) {

                      if(res.message=="Success"){

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Updated Successfully Done',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            var table1 = $('#example').DataTable();
                            table1.ajax.reload();

                      }else if(res.message=="Error"){
                          
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Updated Failed',
                                showConfirmButton: false,
                                timer: 1500
                            });  

                      }
                      
                    }
                  });
              
                }

           }

        })
        
      });

         //@@@@--Inactive Item---

      $(".inactive-item").click(function(){
          
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Inactive it!'
            }).then((result) => {

                if (result.isConfirmed) {
                  
                  var line_ids = [];   
                  $("#po_details_table_id tbody").find('input[name="record"]').each(function(){

                      if($(this).is(":checked")){
                          
                        line_ids.push($(this).data('id'));

                      }

                  });                  

                  if(line_ids.length==0){
                    
                      Swal.fire(
                        'Alert!',
                        'Please select at least one.!',
                        'warning'
                      );

                  }else{
                      
                      $.ajax({
                        url: "{{url('/inactive/demand/item')}}",
                        type: "get",
                        dataType: "json",
                        data: {'line_ids':line_ids,'edit_po_id':$('#edit_po_id').val(),'_token': $('input[name=_token]').val()},
                        success: function(res) {

                            if(res.status=="success"){
                               
                              Swal.fire(
                                  'Inactive!',
                                  'Inactive done successfully.',
                                  'success'
                              );

                              $("#po_details_table_id tbody").find('input[name="record"]').each(function(){

                                  if($(this).is(":checked")){
                                      
                                    $(this).parents("tr").remove();

                                  }

                              });

                              var table2 = $('#po_details_table_id').DataTable();
                              table2.ajax.reload();

                            }
                          
                        }
                        
                      }); 
                        
                    
                  }

                }
            })
               
        });

        //@@@-End--
  
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