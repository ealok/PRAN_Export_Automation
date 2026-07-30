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

 #right_side_style{
 
  border: 2px solid blue;
  min-height: 439px;
  margin-left: 5px;  

}
table.dataTable thead th, table.dataTable thead td {
  padding: 0px 0px;
  border-bottom: 1px solid #111;
}

.bootstrap-select > .dropdown-toggle.bs-placeholder{

  color: #222;
  border: 1px solid blue;

}
.btn-default {

background-color: #FFFFFF;

}

.bootstrap-select > .dropdown-toggle.bs-placeholder,.bootstrap-select > .dropdown-toggle.bs-placeholder:hover {

  color: #222;
  border: 1px solid blue;
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
.box {
  position: relative;
  border-radius: 3px;
  background: #ffffff;
  border-top: 3px solid #d2d6de;
  margin-bottom: 20px;
  width: 100%;
  box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}

#tblMain {

   display: block;

}

#tblMain{

  height: 358px;      
  overflow-y: auto;    
  overflow-x: hidden;  
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
      <div class="box box-primary">
        <div class="box-header with-border">PO List<a href="{{url('/po/create')}}">
            <button class="btn btn-xs btn-success pull-right btn-flat">Create PO</button></a>
        </div>
        @if(Session::has('danger'))
          <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong>Success !</strong>{{Session::get('danger')}}
          </div>
        @endif 
        <div class="panel-body table-responsive">
          <table id="example2" class="table table-bordered table-responsive table-condenced ">
              <thead>
                <tr>
                    <th>PO_Number</th>
                    {{-- <th>Invoice_no</th> --}}
                    <th>Notify_Party</th>
                    <th>Order_Qty</th>
                    <th>Create_Date</th>
                    <th>Created_By</th>
                    <th>Status</th>
                    <th>Controls</th>
                </tr>  
              </thead>
                 @foreach ($results as $key=>$result)
                 <tr>
                    <td>{{$result->po_no}}</td>
                    {{-- <td>{{$result->invoice_no}}</td> --}}
                    <td>{{$result->code}}/{{$result->party_name}}</td>
                    <td>{{$result->order_qty}}</td>
                    <td>{{date("d-m-Y", strtotime($result->create_date))}}</td>
                    <td>{{$result->created_by}}</td>
                    <td>{{$result->status}}</td>
                    <td>
                       <button type="button" class="btn btn-xs btn-success btn-flat" id="showPOModal" data-id='{{$result->id}}'>View</button>
                    </td>
                 </tr>
                 @endforeach
          </table>
        </div>
    </div>
  </div>
</div>


<!-- Show Modal -->
<div id="showModel" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
    <form class="form-horizontal" role="form" method="POST" action="">
        {{ csrf_field() }}
        {{ method_field("DELETE") }}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">PO Details</h4>
          </div>
          <div class="modal-body">
            <form class="" role="form" method="POST" action="" id="po_definition">
              {{ csrf_field() }}
                  <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12"> 
                            <div class="col-sm-4" id="left_side_style">
                              <span id="po_details_style">PO Create</span>
                              <br>
                              <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                <label for="name">Party:</label>
                                <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <select name="edit_party_id" id="edit_party_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" required>
                                    <option value="">Select</option>
                                   
                                  </select> 
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Date:</label>
                                <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                                  <input name="edit_create_date" type="text" id="edit_create_date" class="form-control datepicker"  value=""  placeholder="Select Dated">
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Order Qty:</label>
                                <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                                    <input type="text" name="edit_order_qty"  id="edit_order_qty" class="form-control"  value=""  placeholder="Order Qty">
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                  <label for="name">Template:</label>
                                  <select name="edit_template_id" id="edit_template_id" data-live-search="true" class="form-control select2 selectpicker" onchange="getTemplateDetails()" "select" required>
                                    <option value="">Select</option>
                                    
                                  </select> 
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Remarks:</label>
                                <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                                    <textarea class="form-control" id="edit_remark" name="edit_remark"></textarea>
                                </div>
                              </div>
                              <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                                <label for="is_revised" >Status :</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="status"  id="active" value="1"><span class="task_class_id">Active</span>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="status"  id="inactive" value="0"><span class="task_class_id">Inactive</span>
                                </label>
                              </div>
                            </div>
                            <div class="col-sm-7" id="right_side_style">
                              <span id="task_details_style">Task Details</span>
                               <br>
                                <div class="row">
                                  <table class="table table-bordered" id="tblMain">
                                    <thead>
                                      <tr style="background-color: #C9DEE3;">
                                        <th scope="col" style="width:200px">Task_Name</th>
                                        <th scope="col" style="width:330px">Assigne</th>
                                        <th scope="col" style="width:100px">Std</th>
                                      </tr>
                                    </thead>
                                    <div class="preload">
                                      <img src="{{asset('/img/loading_spinner.gif')}}"/>
                                    </div>
                                    <tbody id="po_detils">

                                    </tbody>
                                  </table>
                                </div>
                                <div class="col-sm-3">
                                  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                                         <input type="hidden" id="edit_id" value="">
                                        <input type="text" class="form-control btn btn-danger btn-sm pull-right" value="Update" onclick="updatePODetails()">
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                  </div> 
            </form>
          </div>
        </div>
    </form>
  </div>
</div>
<script>document.title = 'Export | PO List';</script>
<script type="text/javascript">
    $(".preload").hide();
    setTimeout(function() { $('.sr-only').click();}, 0.0001);
    $(document).on("click", "#showPOModal", function () {
       
        var showId = $(this).data("id");
        var url = "{{url('/po')}}/"+showId;
        $(".preload").show(); 
        
        $.get(url,function(res) {
            
            selectNotityParty(res.notifyParties,res.party_id); 
            $('#edit_create_date').val(res.date);
            $('#edit_order_qty').val(res.order_qty);
            selectTemplate(res.templates,res.template_id);
            $('#edit_template_id').val(res.template);
            $('#edit_remark').val(res.remark);
            $('#edit_id').val(res.update_id);
            if(res.status==1){
                
              $("#inactive").prop('checked', false);
              $("#active").prop('checked', true);

            }else if(res.status==0){
              
              $("#inactive").prop('checked', true);
              $("#active").prop('checked', false);

            }
 
            if(res.taskDetails.length>0){
                      
                var rows="";
                $.each(res.taskDetails, function (key, value) {
                               
                  var user=res.user;
                  var userTypes=res.userTypes;
                  var desk_user=res.desk_user;
                  var select='<select class="form-control input-sm" id="user_id" name="user_id">';

                  if(value.status=='parent'){ 
                    
                    for(var i=0; i<userTypes.length; i++){
                      
                      if(value.type_id==userTypes[i].id && value.USER_TYPE=="Desk Head"){ 
                         
                        select+='<option value="'+userTypes[i].id+'" name="parent" selected>'+userTypes[i].name+'</option>';
                      
                      } 
                    
                    }
                    
                    for(var i=0; i<userTypes.length; i++){
                      
                      if(value.type_id==userTypes[i].id && value.USER_TYPE=="Desk"){ 

                          select+='<option value="'+userTypes[i].id+'" name="parent" selected>'+userTypes[i].name+'</option>';

                          for(var j=0; j<desk_user.length; j++){
                        
                             select+='<option value="'+desk_user[j].id+'" name="child">'+desk_user[j].name+'</option>';

                          }
                      
                      }
                    
                    }

                    for(var i=0; i<userTypes.length; i++){
                      
                      if(value.type_id==userTypes[i].id && value.USER_TYPE=="Accounts"){ 

                        select+='<option value="'+userTypes[i].id+'" name="parent" selected>'+userTypes[i].name+'</option>';

                        for(var j=0; j<user.length; j++){
                             
                          if(userTypes[i].id==user[j].type_id ){

                            select+='<option value="'+user[j].id+'" name="child">'+user[j].name+'</option>';

                          }

                        }
                      
                      }
                    
                    }

                    for(var i=0; i<userTypes.length; i++){
                      
                      if(value.type_id==userTypes[i].id && value.USER_TYPE=="Production"){ 

                        select+='<option value="'+userTypes[i].id+'" name="parent" selected>'+userTypes[i].name+'</option>';

                        for(var j=0; j<user.length; j++){
                             
                          if(userTypes[i].id==user[j].type_id ){

                            select+='<option value="'+user[j].id+'" name="child">'+user[j].name+'</option>';

                          }

                        }
                      
                      }
                    
                    }
                    for(var i=0; i<userTypes.length; i++){
                      
                      if(value.type_id==userTypes[i].id && value.USER_TYPE=="Documentation"){ 

                        select+='<option value="'+userTypes[i].id+'" name="parent" selected>'+userTypes[i].name+'</option>';

                        for(var j=0; j<user.length; j++){
                             
                          if(userTypes[i].id==user[j].type_id ){

                            select+='<option value="'+user[j].id+'" name="child">'+user[j].name+'</option>';

                          }

                        }
                      
                      }
                    
                    }

                    for(var i=0; i<userTypes.length; i++){
                      
                      if(value.type_id==userTypes[i].id && value.USER_TYPE=="Distribution"){ 

                        select+='<option value="'+userTypes[i].id+'" name="parent" selected>'+userTypes[i].name+'</option>';

                        for(var j=0; j<user.length; j++){
                             
                          if(userTypes[i].id==user[j].type_id ){

                            select+='<option value="'+user[j].id+'" name="child">'+user[j].name+'</option>';

                          }

                        }
                      
                      }
                    
                    }


                  }

                  if(value.status=='child'){
                      
                    for(var j=0; j<user.length; j++){

                      if(value.type_id==user[j].id){

                        select+='<option value="'+user[j].id+'" name="child">'+user[j].name+'</option>';

                      }
                      
                    }

                    
                  }


                  select+="</select>";
                    rows = rows + '<tr>';
                    rows = rows + '<td style="width:206px;font-weight:bold">' + value.task_name + '</td>';
                    rows = rows + '<td style="display:none">' + value.task_id + '</td>';
                    rows = rows + '<td style="width:330px;font-weight:bold">'+select+'</td>';
                    rows = rows + '<td style="width:330px;font-weight:bold">'+value.STD+'</td>';
                    rows = rows + '</tr>';

                });

                $("#po_detils").html(rows);
                $(".preload").hide();

            }else{

                Swal.fire({

                      title: 'Alert !<br>Something went wrong..!!',
                });

                return false;

            }

        }); 
        $("#showModel").modal("show");

    });

    function selectTemplate(templates,select_template_id){
          
      if(templates){

            var $el = $('#edit_template_id');
            $el.html(' ');
            $el.append($("<option></option>").attr("value", "").text("Select"));
            $.each(templates, function (key, value) {
                
              $('select[name="edit_template_id"]').append(`<option value="${value.ID}" ${value.ID == parseInt(select_template_id) ? 'selected' : ''}>${value.DESCRIPTION}</option>`)

            });
            $el.selectpicker('refresh');

      }else{

            var $el = $('#edit_template_id');
            $el.html(' ');
            $el.append($("<option></option>").attr("value", "").text("Select"));
            $el.selectpicker('refresh'); 

      }

      
    }

    function selectNotityParty(parties,select_id){
        
      if(parties){

            var $el = $('#edit_party_id');
            $el.html(' ');
            $el.append($("<option></option>").attr("value", "").text("Select"));
            $.each(parties, function (key, value) {
                
              $('select[name="edit_party_id"]').append(`<option value="${value.id}" ${value.id == parseInt(select_id) ? 'selected' : ''}>${value.code}-${value.name}</option>`)

            });
            $el.selectpicker('refresh');


        }else{

            var $el = $('#edit_party_id');
            $el.html(' ');
            $el.append($("<option></option>").attr("value", "").text("Select"));
            $el.selectpicker('refresh'); 

        }

    }  
    
    function updatePODetails(){
           
      var edit_id=$('#edit_id').val();
      var status='';
      if ($("#active").prop("checked")) {
           
        status=$('#active').val();

      }else if($("#inactive").prop("checked")){
             
        status=$('#inactive').val();  

      }

      if(edit_id){
         
        $.ajax({
          url: "{{url('/po')}}/"+edit_id+'/edit',
          type: "get",
          data: { 

            status: status

          },
          success: function(res) {
              
            if(res.status=='success'){
               
              Swal.fire({

                  title: 'Success !<br>Update Successfully Done..!!',

              });
                 
            }
             
          },
          error: function(err){

             console.log(err);

          }
        });

      }
      
    }

    $(document).on("click", "#editPoModel", function () {

        var delId = $(this).data("id");
        $("#editModel").modal("show");

    });

    $('#example2').DataTable({
      "order": [[ 0, "DESC" ]],
      "lengthMenu": [[10, 50,100, -1], [10, 50,100,"All"]]
    });
</script>
@endsection