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

 #land_port_dataTable_wrapper{

  width: 96%;
  margin: auto;
  margin-top: 50px;
  
 }

.btn dropdown-toggle btn-default{

  border-radius: 10px;

}
.form-control{

  border-radius: 10px;

}

.bootstrap-select > .dropdown-toggle.bs-placeholder{

  color: #9999A9;
  
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

.table > thead:first-child > tr:first-child > th {

  border: 1px solid #222;
  text-align: center;

}

.table-bordered > tbody > tr > td{

  border: 1px solid #201f1f;
  padding: 0px;
  font-weight: normal;
  font-family: initial;
  font-size: 12px

}

.table > tbody > tr > td{
 
  padding: 1px;
  line-height: 1.42857143;
  vertical-align: top;

}

.table-bordered > tbody > tr > td{
  
  border: 1px solid #201f1f;
  padding: 1px;

}
#land_port_dataTable{

  font-size: 8px;

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

#date_field_style{

  position: relative;
  top: 53px;
  z-index: 8;
  left: 197px;

}

.form-horizontal .form-group {

  margin-right: 0px;
  margin-left: 0px;

}
.modal-content{

  width: 543px;
}


.row {
  margin-right: -15px;
  margin-left: -7px;
}
.box-header.with-border {

  border-bottom: 1px solid #b9acac;
  font-weight: bold;

}
.box.box-primary {

  border-top-color: #FFFFFF;

}

.form-control {

    display: block;
    width: 100%;
    height: 29px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    background-color: #fff;
    background-image: none;
    border: 1px solid #222;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
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
  min-height: 200px;
}

.modal-footer {
  padding: 14px;
  text-align: center;
}

.box-body {
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  border-bottom-right-radius: 3px;
  border-bottom-left-radius: 3px;
  padding: 0px 20px 11px 10px;

}

.bootstrap-select > .dropdown-toggle.bs-placeholder{

  border: 1px solid #222;
  border-radius: 7px;

}

.btn {
 
    padding-right: 6px;
    margin-bottom: 0;
    font-size: 12px;
    font-weight: 400;
    line-height: 1.42857143;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid;
    border-radius: 9px;
}
#land_port_dataTable{

  font-size: 11px;
}

#land_port_dataTable table { 

  width: 628.1px;

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
.table > thead:first-child > tr:first-child > th {
  
  border: 1px solid #222;
  font-size: 11px;

}
.table.dataTable thead th, table.dataTable thead td {
  
  padding: 0px 0px;
}
hr{

  margin-top: 36px;
  margin-bottom: -20px;
  border-top: 1px solid #d7d2d2;
}
#btn_action_div{

  position: relative;
  left: -77px;
  /* z-index: 555; */
  top: -65px;

}
#sea_port_dataTable_wrapper{

    width: 96%;
    margin: auto;
}

</style>
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/bapa_receive')}}"><i class="fa fa-dashboard"></i>Task Query</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12" style="margin-top: -20px;">
    <div class="row" id="date_field_style">
       <div class="col-sm-2">
        <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
            <select name="party_id" id="party_id" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" >
                <option value="">Select</option>
            </select>
            @if ($errors->has('party_id'))
                <span class="help-block"><strong>{{ $errors->first('party_id') }}</strong></span>
            @endif  
        </div>
      </div> 
      <div class="col-sm-2">
          <div class="form-group{{ $errors->has('receive_date') ? 'has-error' : '' }}">
            <input name="from_date" type="text" id="from_date" class="form-control datepicker"   value=""  max="191"  placeholder="Select From Date" required>
            @if ($errors->has('receive_date'))
                <span class="help-block"><strong>{{ $errors->first('receive_date') }}</strong></span>
            @endif  
          </div>
      </div>
      <div class="col-sm-2">
        <div class="form-group{{ $errors->has('receive_date') ? 'has-error' : '' }}">
          <input name="to_date" type="text" id="to_date" class="form-control datepicker"   value=""  max="191"  placeholder="Select To Date" required>
          @if ($errors->has('receive_date'))
              <span class="help-block"><strong>{{ $errors->first('receive_date') }}</strong></span>
          @endif  
        </div>
      </div>
      <div class="col-sm-2">
        <div class="form-group{{ $errors->has('receive_date') ? 'has-error' : '' }}">
            <label class="checkbox-inline"><input type="radio" name="port_type" value="1">Land</label>
            <label class="checkbox-inline"><input type="radio" name="port_type" value="2">Sea</label>
        </div>
      </div>
    </div>
        <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px;">
            <div id="land_port_view">
                <table class="table table-bordered table-responsive table-condenced" id="land_port_dataTable">
                    <thead>
                        <tr style="font-size: 8px">
                            <th>SL</th>
                            <th>PO</th>
                            <th>Invoice</th>
                            <th>Invoice<br>Date</th>
                            <th>JO<br>Create</th> 
                            <th>JO<br>RCV</th>
                            <th>Prod<br>Status</th> 
                            <th>Shipment<br>Doc</th>
                            <th>Phyto<br>Certificate</th>
                            <th>Bsti<br>Certificate</th> 
                            <th>Veterinary<br>Certificate</th> 
                            <th>Collection<br>Confirmation</th>
                            <th>DO<br>Approval</th> 
                            <th>DO<br>Date</th> 
                            <th>OC<br>Date</th> 
                            <th>Exp<br>Duplicate</th>
                            <th>Bank<br>Doc</th> 
                            <th>CI<br>Doc_Sub</th>
                            <th>Final<br>Approve</th>
                            <th>Action</th>
                        </tr>  
                    </thead>
                </table>
            </div>
            <div id="sea_port_view" style="margin-top: 41px">
                <table class="table table-bordered table-responsive table-condenced" id="sea_port_dataTable">
                    <thead>
                        <tr style="font-size: 8px">
                            <th>SL</th>
                            <th>PO</th>
                            <th>Invoice</th>
                            <th>Invoice<br>Date</th> 
                            <th>JO<br>Create</th>
                            <th>JO<br>Rcv</th> 
                            <th>Prod<br>Date</th>
                            <th>Vat+<br>C&F Doc</th>
                            <th>Shipping<br>Selection</th> 
                            <th>DO<br>Date</th> 
                            <th>OC<br>Date</th>
                            <th>Shipped<br>Board Date</th> 
                            <th>Arrival<br>Date</th> 
                            <th>Freight<br>Inv Recipt</th>
                            <th>Freight<br>Payment</th> 
                            <th>BL<br>Submit</th>
                            <th>CO<br>Collect</th>
                            <th>Others<br>Doc</th>
                            <th>Shipment<br>Amount_Collect</th>
                            <th>Buyer<br>Doc_Approval</th>
                            <th>Buyer<br>Doc_Send</th>
                            <th>Exp<br>Dup</th>
                            <th>Bank<br>Doc_Sub</th>
                            <th>CI<br>Doc_Sub</th>
                            <th>Final<br>Approve</th>
                            <th>Action</th>
                        </tr>  
                    </thead>
                </table>
            </div>  
            <br><br>
        </div>
  </div>
</div>
<script>document.title = 'Special | Approval';</script>
@endsection
@section("child.js") 
<script type="text/javascript">
  $('#btn_action_div').hide();
  $('#land_port_view').hide();
  $('#sea_port_view').hide();
  $(document).ready(function(){
       
      //@@@@--window Toggle
      setTimeout(function() { 
        $('.sr-only').click();
      }, 0.0001); //@@-End

      function loadNotifyParty(){

        $.ajax({
            type: "GET",
            url: "/json/get/notify_party", 
            dataType: "json", 
            success: function(data) { 
                
                var $el = $('#party_id');
                if(!data.results){

                    $el.html('');
                    $el.append($("<option></option>").attr("value", "").text("---"));
                    $el.selectpicker('destroy');

                }else{

                    $el.html(' ');
                    $el.append($("<option></option>").attr("value", "").text("Select"));
                    $.each(data.results, function(key,value) {

                        $el.append($("<option></option>").attr("value", value['id']).text(value['code']+'-'+value['name']));

                    });
                    $el.selectpicker('refresh');

                }
                 
            }
        
        });

      }

      loadNotifyParty();

        $('input[type="radio"][name="port_type"]').click(function() {

            let port_type=$('input[type="radio"][name="port_type"]:checked').val(); 
            let from_date=$('#from_date').val();
            let to_date=$('#to_date').val();
            let party_id=$('#party_id').val();   
            if(party_id==""){
               
                Swal.fire({
                    icon: 'warning',
                    text: 'Please Select Party..!!',
                });  

            }else if(from_date==""){
             
                Swal.fire({
                    icon: 'warning',
                    text: 'Please Select From Date..!!',
                });

            }else if(to_date==""){
                
                Swal.fire({
                    icon: 'warning',
                    text: 'Please Select TO Date..!!',
                });

            }else{
                
                 if(port_type==1){
                
                    displayLandPortView(from_date,to_date,party_id,port_type);
                
                }else if(port_type==2){

                    displaySeaPortView(from_date,to_date,party_id,port_type);

                }

            }      

        });

        function displayLandPortView(from_date,to_date,party_id,port_type) {

            $('#land_port_view').show();
            $('#sea_port_view').hide();
            $('#land_port_dataTable').dataTable().fnDestroy(); 
            var table = $('#land_port_dataTable').DataTable({
                    "ajax": {
                        "processing": true,
                        "serverSide": true,
                        "url": "/json/get/task_query/details",
                        "type": "GET",
                        data: {'from_date': from_date, 'to_date': to_date,'party_id':party_id,'port_type':port_type, "_token": $('input[name=_token]').val()},
                        "dataType": "json",
                        "dataSrc": function (json) {
                            
                            if(json.data.length > 0){

                                $('#btn_action_div').show();
                                return json.data;
                                
                            }else{

                                $('#btn_action_div').hide();
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
                    { "data": "po_no" },
                    { "data": "invoice_no"},
                    { "data": "col_13"},
                    { "data": "col_1" },
                    { "data": "col_2" },
                    { "data": "col_3" },
                    { "data": "col_4" },
                    { "data": "col_5" },
                    { "data": "col_6" },
                    { "data": "col_27"},
                    { "data": "col_7" },
                    { "data": "col_34"},
                    { "data": "col_8" },
                    { "data": "col_9" },
                    { "data": "col_10"},
                    { "data": "col_11"},
                    { "data": "col_21"},
                    { "data": "col_32"},
                    { 
                        "data": null,
                        render: function(data, type, row){
                           
                          if(data.col_32){
                             
                            return '<input type="button" data-id="'+row.id+'" class="btn btn-info btn-sm btn-update-land" value="Approve" disabled>'

                          }else{

                            return '<input type="button" data-id="'+row.id+'" class="btn btn-info btn-sm btn-update-land" value="Approve">'  

                          }                           
                        
                        }
                    }
                ],
                "pageLength": 25,
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

        function displaySeaPortView(from_date,to_date,party_id,port_type) {

            $('#sea_port_view').show();
            $('#land_port_view').hide();
            $('#sea_port_dataTable').dataTable().fnDestroy(); 
            var table = $('#sea_port_dataTable').DataTable({
                    "ajax": {
                        "processing": true,
                        "serverSide": true,
                        "url": "/json/get/task_query/details",
                        "type": "GET",
                        data: {'from_date': from_date, 'to_date': to_date,'party_id':party_id,'port_type':port_type,"_token": $('input[name=_token]').val()},
                        "dataType": "json",
                        "dataSrc": function (json) {
                            
                            if(json.data.length > 0){

                                $('#btn_action_div').show();
                                return json.data;
                                
                            }else{

                                $('#btn_action_div').hide();
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
                    { "data": "po_no" },
                    { "data": "invoice_no" },
                    { "data": "col_13" },
                    { "data": "col_1" },
                    { "data": "col_2" },
                    { "data": "col_3" },
                    { "data": "col_15" },
                    { "data": "col_31" },
                    { "data": "col_8" },
                    { "data": "col_9" },
                    { "data": "col_16" },
                    { "data": "col_17" },
                    { "data": "col_18" },
                    { "data": "col_19" },
                    { "data": "col_20" },
                    { "data": "col_23" },
                    { "data": "col_24" },
                    { "data": "col_25" },
                    { "data": "col_33" },
                    { "data": "col_26" },
                    { "data": "col_10" },
                    { "data": "col_11" },
                    { "data": "col_21" },
                    { "data": "col_32"},
                    { 
                        "data": null,
                        render: function(data, type, row){

                          if(data.col_32){
                             
                             return '<input type="button" data-id="'+row.id+'" class="btn btn-info btn-sm btn-update-sea" value="Approve" disabled>'
 
                          }else{
 
                             return '<input type="button" data-id="'+row.id+'" class="btn btn-info btn-sm btn-update-sea" value="Approve">'  
 
                          }
                        
                        }
                    }

                ],
                "pageLength": 25,
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
     

      ///@@@--Datatable----
      $('#land_port_dataTable').DataTable({
            "order": [[ 0, "DESC" ]],
            // lengthChange: false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
      }); //@@@end Datatable 

      ///@@@--Datatable----
      $('#sea_port_dataTable').DataTable({
            "order": [[ 0, "DESC" ]],
            // lengthChange: false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
      }); //@@@end Datatable 

      //@@@@--Handle Land Port Special Approval--@@@---
      $('#land_port_dataTable tbody').on('click', '.btn-update-land', function (e) {

          var sc_id=$(this).data('id');
          Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Updated!'
            }).then((result) => {

                if (result.isConfirmed) {
                    
                    $.ajax({

                        type:'get',
                        url:'/update/landport/special/task',
                        data: {'sc_id': sc_id},
                        success:function(res){
                            
                          console.log(res.code);
                            
                          if(res.code==200){

                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: 'Updated Successfully Done',
                                  showConfirmButton: false,
                                  timer: 1500
                              });

                              var table = $('#land_port_dataTable').DataTable();
                              table.ajax.reload();

                          }else if(res.code==500){

                              Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: 'Updated Failed..!'
                              });
                              
                          }

                        },
                        error:function(){
            
                            
                        }


                    });       

                }
                
            });

                
          }); //---@@@@--End
          //@@@@--Handle Sea Port Special Approval
          $('#sea_port_dataTable tbody').on('click', '.btn-update-sea', function (e) {

          var sc_id=$(this).data('id');
          Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Updated!'
            }).then((result) => {

                if (result.isConfirmed) {
                    
                    $.ajax({

                        type:'get',
                        url:'/update/seaport/special/task',
                        data: {'sc_id': sc_id},
                        success:function(res){
                            
                          if(res.code==200){

                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: 'Updated Successfully Done',
                                  showConfirmButton: false,
                                  timer: 1500
                              });

                              var table = $('#sea_port_dataTable').DataTable();
                              table.ajax.reload();

                          }else if(res.code==500){

                              Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: 'Updated Failed..!'
                              });
                              
                          }

                        },
                        error:function(){
            
                            
                        }


                    });       

                }
                
            });

                
          });
          //@@@@--End---


  });

</script>
@endsection