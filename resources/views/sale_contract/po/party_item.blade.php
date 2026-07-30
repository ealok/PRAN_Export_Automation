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
    left: 126px;
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
  width: 200px;

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
    text-align: left;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: bold;
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
  font-size: 11px;

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
  font-size: 10px;

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

    width: 200px;

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
  width: 1015px;
  margin: auto;

}
.table > thead > tr > th {
    padding: 4px;
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
                        <th>SL#</th>
                        <th>Code</th>
                        <th>Item</th>
                        <th>Unit</th>
                        <th>Ref_Code</th>
                        <th>Ref_Name</th>
                        <th>Min(Order_Qty)</th>
                        <th>Max(Order_Qty)</th>
                        <th>Purch(LD)</th>
                        <th>Avg_Sales</th>
                    </tr>  
              </thead>
              <tbody></tbody>
          </table>
          <div class="row">
              <div style="position: relative;top:-30px;text-align: center"><button class="btn btn-sm btn-danger inactive-item">Delete</button> <button class="btn btn-sm btn-primary save_all">Save</button></div>
          </div>
        </div>
    </div>
  </div>
  {{-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form class="form-horizontal" id="myForm">
        <div class="modal-content" style="width: 424px;margin:auto">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="col-sm-12">
                  <div class="form-group {{ $errors->has('item_id') ? 'has-error' : '' }}">
                      <label for="sales_contract_no">Party</label>
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
                  <label for="sales_contract_no">Specifications</label>
                  <input name="m_specification" type="text" id="m_specification" class="form-control input-sm"   value=""     max="191"  placeholder="Enter Specifications" >
                  @if ($errors->has('sales_contract_no'))
                      <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                  @endif
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
                  <label for="sales_contract_no">Specifications</label>
                  <input name="m_specification" type="text" id="m_specification" class="form-control input-sm"   value=""     max="191"  placeholder="Enter Specifications" >
                  @if ($errors->has('sales_contract_no'))
                      <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                  @endif
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
                  <label for="sales_contract_no">Specifications</label>
                  <input name="m_specification" type="text" id="m_specification" class="form-control input-sm"   value=""     max="191"  placeholder="Enter Specifications" >
                  @if ($errors->has('sales_contract_no'))
                      <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                  @endif
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
                  <label for="sales_contract_no">Specifications</label>
                  <input name="m_specification" type="text" id="m_specification" class="form-control input-sm"   value=""     max="191"  placeholder="Enter Specifications" >
                  @if ($errors->has('sales_contract_no'))
                      <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                  @endif
                </div>
              </div>
          </div>
          <br>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-flat btn-md" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-info btn-flat btn-md" value="Save">
          </div>
        </div>
      </form>
    </div>
  </div> --}}
</div>
<script>document.title = 'Export | Demand List';</script>
<script type="text/javascript">
  $('#po_details_div_id').hide();
   $(document).ready(function() {

        setTimeout(function() { 
          $('.sr-only').click();
      }, 0.0001);
        
        //Item Add Form Submit

        $("#myForm").submit(function (e) {
            
            e.preventDefault();
            var item_id=$('#mitem_id').val();
            var item_factor=$('#m_factor').val();
            var order_qty=$('#m_order_qty').val();
            var specification=$('#m_specification').val();
            var po_master_id=$('#edit_po_id').val();
            if(item_id==""){
              
                Swal.fire(
                  'Alert!',
                  'Please select Item.!',
                  'warning'
                );

            }else if(order_qty==""){
                  
              Swal.fire(
                    'Alert!',
                    'Please enter order qty.!',
                    'warning'
                  );

            }else if(specification==""){

                Swal.fire(
                    'Alert!',
                    'Please enter item specifications.!',
                    'warning'
                  );

            }else{

                  $.ajax({
                        method: 'POST',
                        url: "/json/add/master/item",
                        data: {'item_id': item_id,'item_factor': item_factor,'order_qty':order_qty,'specification':specification,'po_master_id':po_master_id,'_token': $('input[name=_token]').val()},
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
                              $("#myModal").modal("hide"); 
                            
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
                              $("#myModal").modal("hide"); 
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
        
        $('#add_order_party_item').click(function(){
             
             $("#myModal").modal("show");

        });
           
        //   var edit_po_id=$('#edit_po_id').val(); 
        //   var $el = $('#mitem_id');
        //   if(edit_po_id){
            
        //       $.ajax({
        //         url: "{{url('/json/po_wise/party_item')}}",
        //         type: "get",
        //         dataType: "json",
        //         data: {'edit_po_id':edit_po_id,'_token': $('input[name=_token]').val()},
        //         success: function(res) {
                    
        //           if(!res.results){

        //                 $el.html('');
        //                 $el.append($("<option></option>").attr("value", "").text("---"));
        //                 $el.selectpicker('destroy');

        //             }else{

        //                 $el.html(' ');
        //                 $el.append($("<option></option>").attr("value", "").text("Select"));
        //                 $.each(res.results, function(key,value) {

        //                     $el.append($("<option></option>").attr("value", value['id']).text(value['ci_item_code']+'-'+value['ci_item_name']));

        //                 });
        //                 $el.selectpicker('refresh');

        //             }  
                                        
        //         }
                
        //       }); 

        //   }
          
       $("#mitem_id").change(function(){
             
            var item_id=$(this).val();
            var url = "{{url('/json/get/item/factor')}}?item_id="+item_id;
            $.get(url, function(data) {
                  
                if(data.factor){
                   
                  $('#m_factor').val(data.factor);

                }else{

                  $('#m_factor').val(""); 

                } 
                
                
            });

      }); 

      
        
        //@@@@--Inactive Item---

        $(".inactive-item").click(function(){
          
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {

                if (result.isConfirmed) {
                  
                  var item_ids = [];   
                  $("#example tbody").find('input[name="record"]').each(function(){

                      if($(this).is(":checked")){
                        
                        item_ids.push($(this).data('item-id'));

                      }

                  });

                  if(item_ids.length==0){
                    
                    Swal.fire(
                      'Alert!',
                      'Please select at least one.!',
                      'warning'
                    );

                  }else{

                      $("#example tbody").find('input[name="record"]').each(function(){

                          if($(this).is(":checked")){
                              
                            $(this).parents("tr").remove();

                          }

                      });

                  }
                  
                }  
                  
            })
               
        });

        //@@@-End--

        
        //@@--All edit----------
        
        $(".save_all").on("click",function(){   

            Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Save it!'

        }).then((result) => {
           
           if(result.isConfirmed){
              
              var party_code=$('#party_id').val();
              var itemDetails = new Array();
              $("#example tbody TR").each(function () {

                  var row = $(this);
                  var item_info = {};
                  item_info.item_code=row.find("td:eq(1)").text();
                  item_info.party_item_code=row.find("td:eq(4) input[type='text']").val();
                  item_info.party_item_name=row.find("td:eq(5) input[type='text']").val();
                  item_info.min_order_qty=row.find("td:eq(6) input[type='text']").val();
                  item_info.max_order_qty=row.find("td:eq(7) input[type='text']").val();
                  item_info.reorder_qty=row.find("td:eq(8) input[type='text']").val();
                  item_info.purchase_lead_day=row.find("td:eq(9) input[type='text']").val();
                  item_info.avg_sales=row.find("td:eq(10) input[type='text']").val();
                  itemDetails.push(item_info);
                  

              });

              if(itemDetails.length>0){
                
                  $.ajax({
                    url: "{{url('/save/order/items')}}",
                    type: "post",
                    dataType: "json",
                    data: {'itemDetails':itemDetails,'party_code':party_code,'_token': $('input[name=_token]').val()},
                    success: function(res) {

                        if(res.code==200){

                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: 'Save Successfully Done',
                                  showConfirmButton: false,
                                  timer: 1500
                              });

                              var table2 = $('#example').DataTable();
                              table2.ajax.reload();  

                        }else if(res.code==500){
                          
                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'error',
                                  title: 'Save Failed',
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
        //@@--Single edit----------
        $("#po_details").on("click", ".btn-edit", function(){
          
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Update it!'
          }).then((result) => {

              if (result.isConfirmed) {

                var row = $(this).closest("tr");
                var item_code = row.find("td:eq(1) input[type='text']").val();  
                var order_qty = row.find("td:eq(5) input[type='text']").val();
                var specifications = row.find("td:eq(6) input[type='text']").val();
                var edit_id=$('#edit_po_id').val();
                if(order_qty==""){
                  
                      Swal.fire({ 

                        title: 'Alert ! <br> Order can not empty..!!',

                      });

                }else if(specifications==""){
                      
                    Swal.fire({ 

                      title: 'Alert ! <br> Specifications can not empty..!!',

                    });
                                  
                }else{

                      $.ajax({
                        url: "{{url('/update/single/demand')}}",
                        type: "get",
                        dataType: "json",
                        data: {'edit_po_id':edit_id,'item_code':item_code,'order_qty':order_qty,'specifications':specifications,'_token': $('input[name=_token]').val()},
                        success: function(res) {

                            if(res.message=="Success"){

                                  Swal.fire({
                                      position: 'top-end',
                                      icon: 'success',
                                      title: 'Updated Successfully Done',
                                      showConfirmButton: false,
                                      timer: 1500
                                  });

                                  var table2 = $('#po_details_table_id').DataTable();
                                  table2.ajax.reload();

                            }else if(res.message=="Fail"){
                                
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

          });  
    
        });
         
        //@@--Party Id---
        $("#party_id").change(function(){
            
           var party_code=$(this).val();
           displayPartyItems(party_code);
           
        }); //@@-end Party Id

        function displayPartyItems(party_code){
           
          $(".preload").show();
          $('#example').dataTable().fnDestroy(); 
          var table = $('#example').DataTable({
                "ajax": {
                    "url": "/get/order/partyItems",
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
                    "render": function (data, type, row) {

                       return '<input type="checkbox" name="record" data-item-id="'+row.id+'">';

                    }

                },
                { "data": "item_code"},
                { "data": "item_name"},
                { "data": "unit"},
                { 
                    "data": null,
                    render: function(data, type, row) {

                        return '<input type="text" value="'+row.party_item_code+'" width="50px">';  
                    
                    }

                },
                { 
                    "data": null,
                    render: function(data, type, row) {

                      return '<input type="text" value="'+row.party_item_name+'" width="50px">';    
                    
                    }

                },
                { 
                    "data": null,
                    render: function(data, type, row) {

                      return '<input type="text" value="'+row.min_odr_qty+'" width="50px">';  
                    
                    }

                },
                { 
                    "data": null,
                    render: function(data, type, row) {

                      return '<input type="text" value="'+row.max_odr_qty+'" width="50px">';  
                    
                    }

                },
                { 
                    "data": null,
                    render: function(data, type, row) {

                      return '<input type="text" value="'+row.purchase_lead_day+'" width="50px">';  
                    
                    }

                },
                { 
                    "data": null,
                    render: function(data, type, row) {

                      return '<input type="text" value="'+row.avg_sales+'" width="50px">';   
                    
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

            },
            "initComplete": function(settings, json) {
                  
                $('#example thead th:eq(1)').css('width',  '62px');
                $('#example thead th:eq(2)').css('width',  '5000px');
                $('#example thead th:eq(4)').css('width',  '50px');
                $('#example thead th:eq(9)').css('width',  '65px');
                $('#example thead th:eq(10)').css('width', '65px');
                $('#example thead th:eq(11)').css('width', '65px');
                $('#example thead th:eq(12)').css('width', '65px');
                $('#example thead th:eq(13)').css('width', '65px');
                $('#example thead th:eq(14)').css('width', '52px');
                $('#example thead th:eq(15)').css('width', '60px');
                $('#example thead th:eq(16)').css('width', '77px');

            }

          });
          
        }

          // PO Details
          $('#example tbody').on('click', 'td a', function(e) {
          
            e.preventDefault();
            $('#po_details_div_id').show();  
            $('#po_details_table_id').dataTable().fnDestroy(); 
            var po_id=$(this).data('id');
            var url = $(this).attr('href');
            var table = $('#po_details_table_id').DataTable( {
                  paging: false,
          //         dom: 'Bfrtip', 
          //         buttons: [
          //             'csv', 'excel'
          //         ],
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

                              return '<input type="checkbox" name="record" data-item-id="'+row.id+'">';
                        }

                    },
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

                           return '<input type="text" value="'+row.specifition+'" width="150px">';  
                        
                        }

                    },
                    { 
                        "data": null,
                        render: function(data, type, row) {


                          if(row.status=="Y"){

                              return '<input type="button" data-id="'+row.id+'" class="btn btn-primary btn-sm btn-edit" value="Edit" disabled>'

                          }else{

                             return '<input type="button" data-id="'+row.id+'" class="btn btn-primary btn-sm btn-edit" value="Edit">'

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


          });
  
     });
</script>
<script>
  $('#example').DataTable({
    "order": [[ 0, "DESC" ]],
    "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100,"All"]]
  });
</script>
@endsection