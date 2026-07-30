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

      border: 1px solid blue;
      min-height: 440px;  
   }

   #right_side_style{
   
   border: 1px solid blue;
   min-height: 185px;
   margin-left: 5px;  

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
  border: 1px solid blue;
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
  border: 1px solid blue;
  background: #FFF;
  width: 198px;
  text-align: center;
  font-weight: bold;
  padding: 3px;
  font-style: oblique;

}
.swal2-title {
  position: relative;
  max-width: 100%;
  margin: -5px 0 -0.6em;
  padding: 6px;
  color: #595959;
  font-size: 1.875em;
  font-weight: 600;
  text-align: center;
  text-transform: none;
  word-wrap: break-word;
  line-height: 1.5;
}

.table > thead:first-child > tr:first-child > th {

    border: 1px solid blue;

}

.table-bordered > tbody > tr > td{

   border: 1px solid blue;

}

.table > tbody > tr > td{
   
  padding: 1px;
  line-height: 1.42857143;
  vertical-align: top;

}

thead, tbody {

  display: block;

}
tbody {

    height: 358px;      
    overflow-y: auto;    
    overflow-x: hidden;  
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
tr:nth-child(2n+1) {background:#f2f0e700}
tr:nth-child(even) {background: #D8F2D370;}
tr:first-child{darkgreen}  (nth-child(0) would also work)
.table > thead:first-child > tr:first-child > th {
    border-top: 1px solid;
    padding: 15px 0px 14px 3px;
    font-weight: bold;
    font-size: 15px;
    border-bottom-width: 0px;
  }
  .table-bordered > tbody > tr > td{
    
    border: 1px solid #201f1f;
    padding: 1px;
    font-weight: bold;

  }
  .table-bordered > tbody > tr:hover{

    background-color: rgba(101, 212, 97, 0.836);
  }

  input{

    border-radius: 50px;
    border: 1px solid black;
    
  }

</style>
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/po')}}"><i class="fa fa-dashboard"></i>PO List</a></li>
      <li class="active"><a href="{{url('/task')}}"><i class="fa fa-dashboard"></i>Task List</a></li>
    </ol>
    <br>
</section>
<div class="row">
        @if(Session::has('success'))
       <div class="alert alert-success">
               <strong>Success!</strong>{{ Session::get('success') }}
       </div> 
       @endif 
       @if(Session::has('danger'))
       <div class="alert alert-danger">
               <strong>Failed !</strong>{{ Session::get('danger') }}
       </div> 
       @endif
        <div class="col-md-10 col-md-offset-1" style="position: relative">
           <!-- Horizontal Form -->
           <div class="box box-info" style="border-top-color: none;border: 1px solid #4e7bd7;"> <!-- /.box-header start-->
             <div class="box-header with-border">
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="" id="po_definition">
              {{ csrf_field() }}
                  <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12"> 
                            <div class="col-sm-4" id="left_side_style">
                              <span id="po_details_style">Task Master</span>
                              <br>
                              <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                <label for="name">Party</label>
                                <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <select name="party_id" id="party_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" required>
                                    <option value="">Select</option>
                                    @foreach ($notifyParties as $notifyParty)
                                    <option value="{{$notifyParty->id}}">{{$notifyParty->code}} / <span style="color: #406CF0">{{$notifyParty->name}}</span></option>  
                                    @endforeach
                                  </select> 
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Date:</label>
                                <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                                  <input name="create_date" type="text" id="create_date" class="form-control datepicker"  value=""  placeholder="Select Dated">
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Order Qty</label>
                                <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                                    <input type="text" name="order_qty"  id="order_qty" class="form-control"  value=""  placeholder="Order Qty">
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                  <label for="name">Template:</label>
                                  <select name="template_id" id="template_id" data-live-search="true" class="form-control select2 selectpicker" onchange="getTemplateDetails()" "select" required>
                                    <option value="">Select</option>
                                    @foreach($templateNames as $value)
                                    <option value="{{$value->ID}}">{{$value->DESCRIPTION}}</option>
                                    @endforeach
                                  </select> 
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Remarks</label>
                                <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                                    <textarea class="form-control" id="remark" name="remark"></textarea>
                                </div>
                              </div>
                              <br>
                                <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}" style="width: 100px;margin-left: 67px;">
                                   <input type="button" class="form-control btn btn-info btn-sm" value="Save" id="saveBtnID" onclick="return savePODetails()">
                                </div>
                              </div>
                            <div class="col-sm-7" id="right_side_style">
                              <span id="task_details_style">Task Details</span>
                               <br>
                                <div class="row">
                                  <table class="table table-bordered" id="tblMain">
                                    <thead>
                                      <tr style="background-color: #C9DEE3;">
                                        <th scope="col" style="width:389px">Task_Name</th>
                                        <th scope="col" style="width:515px">Assigne</th>
                                        <th scope="col" style="width:194px">Standard Days</th>
                                        <th scope="col" style="width:194px">Action</th>
                                      </tr>
                                    </thead>
                                    <div class="preload">
                                      <img src="{{asset('/img/loading_spinner.gif')}}"/>
                                    </div>
                                    <tbody id="po_detils">

                                    </tbody>
                                  </table>
                                </div>
                            </div>
                        </div>
                    </div>   
                  </div> 
            </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Export | PO Create';</script>
<script type="text/javascript">

    $(".preload").hide();
    setTimeout(function() { $('.sr-only').click();}, 0.0001);
    function savePODetails(){

      var party_id=$('#party_id').val();
      var create_date=$('#create_date').val();
      var order_qty=$('#order_qty').val(); 
      var template_id=$('#template_id').val();
      var remark=$('#remark').val();
      if(party_id==""){
        
        Swal.fire({

          title: 'Alert ! <br> Please Select Notify Party..!!',
          
        });
          
        return false;

      }else if(create_date==""){

        Swal.fire({

            title: 'Alert ! <br> Create Date Connot Be Empty..!!',

        });

        return false; 

      }else if(order_qty==""){

        Swal.fire({

           title: 'Alert ! <br> Order Qty Connot Be Empty..!!',

        });

        return false;

      }else if(template_id==""){

          Swal.fire({

            title: 'Alert !<br>Template Can Not Be Empty..!!',

          });

          return false;

      }else{
            
          $(".preload").show();
          var results = new Array();
          $("#tblMain tbody TR").each(function () {

              var row = $(this);
              var po_info = {};
              po_info.task_id = row.find("TD").eq(1).html();
              po_info.type_id = $(this).find("select").val();
              po_info.status=$(this).find('option:selected').attr("name");
              po_info.std=$(this).find("td:eq(3) input[type='text']").val();
              results.push(po_info);

          });
                     
          $.ajax({
                method: 'POST',
                url: "/po",
                data: {
                  'results': results,
                  'party_id': party_id,
                  'create_date':create_date,
                  'order_qty':order_qty,
                  'template_id':template_id,
                  'remark':remark,
                  '_token': $('input[name=_token]').val()
                },
                success: function (res){

                  if(res.status=='Success'){
                      
                      Swal.fire({  
                              icon: 'success',
                              title: 'Success <br><br><br><br> PO NO : ' + res.po_number,    
                              denyButtonText: `Don't save`,
                            })

                      $('#po_definition').trigger("reset");
                      $('#template_id').selectpicker('refresh');
                      $('#party_id').selectpicker('refresh');
                      $("#po_detils").empty();

                  }else if(res.status=='Error'){

                      Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'PO already create this party..!!',
                        showConfirmButton: false,
                        timer: 1500
                      });

                  }
                  
                  $(".preload").hide();

                },
                error: function (e) {

                    console.log(e);

                }

          }); 
  
      }

    }


    function getTemplateDetails(){             
       
      $(".preload").show();
      var template_id=$('#template_id').val();
      if(template_id){
        $.ajax({
              method: 'GET',
              url: "/json/get/template/details",
              data: {
                'template_id': template_id,
                '_token': $('input[name=_token]').val()
              },
              success: function (res) {
                 
                console.log(res);

                if(res.results.length>0){
                      
                    var rows = '';

                    $.each(res.results, function (key, value) {

                      var user=res.user;
                      var userTypes=res.userTypes;
                      var desk_user=res.desk_user;
                      var select='<select class="form-control input-sm" id="user_id" name="user_id">';
                      for(var i=0; i<userTypes.length; i++){
                             
                          if(value.user_type==userTypes[i].id && value.user_type==1){

                            select+='<option value="'+userTypes[i].id+'" name="parent">'+userTypes[i].name+'</option>';
                            
                            for(var j=0; j<desk_user.length; j++){
                                
                               select+='<option value="'+desk_user[j].id+'" name="child">'+desk_user[j].name+'</option>';

                            }

                          }

                          if(value.user_type==userTypes[i].id){

                            select+='<option value="'+userTypes[i].id+'" name="parent">'+userTypes[i].name+'</option>';

                            for(var j=0; j<user.length; j++){
                                
                              if(userTypes[i].id==user[j].type_id){
                                
                                select+='<option value="'+user[j].id+'" name="child">'+user[j].name+'</option>';

                              }

                            }

                          }
                          
                      }

                      select+="</select>";

                      var buttonStatus = (value.status==1) ? 'disabled' : '';
                      rows = rows + '<tr>';
                      rows = rows + '<td style="font-weight:bold;width:200px">' + value.template_name + '</td>';
                      rows = rows + '<td style="display:none">' + value.id + '</td>';
                      rows = rows + '<td style="font-weight:bold">'+select+'</td>';
                      rows = rows + '<td style="font-weight:bold">'+'<input type="text" name="std" id="std" value="'+value.std+'" style="width: 117px;">'+'</td>';
                      rows = rows + '<td style="font-weight:bold;width: 89px;">'+'<input type="button" class="btn btn-sm btn-danger btnDelete" value="X" style="width: 42%;height: 25px;padding: 2px 2px;" '+buttonStatus+'>'+'</td>';
                      rows = rows + '</tr>';

                    });

                    $("#po_detils").html(rows);
                    $(".preload").hide();
                    $("#saveBtnID").attr("disabled",false);

                }else{

                  Swal.fire('Alert','Your Desk Not Setup..!!');
                  $(".preload").hide();
                  $("#saveBtnID").attr("disabled",true);
                  return false;

                }

              },
              error: function (e) {

                  console.log(e);

              }

        });

      } 
       
    } 
   
    function saveTaskDefinitionDetails(){
            
        event.preventDefault();

        var desk_uid=$('#desk_uid').val();
        var process_id=$('#process_id').val();
        var default_uid=$('#default_uid').val();
        var desk_head_id=$('#desk_head_id').val();
        var related_to=$('#related_to').val();
        var event_type_id=$('#event_type_id').val();
        var description=$('#description').val();
        var tclass_id=$('input[name="tclass_id"]:checked').val();
        var mail_send=$('input[name="mail_send"]:checked').val();
        var standard_day=$('#standard_day').val();
        var lag_day=$('#lag_day').val();
        var cal_type=$('input[name="cal_type"]:checked').val();
        var related_order=$('input[name="related_order"]:checked').val();
        if(desk_uid==""){
          
          Swal.fire({ 

              title: 'Alert ! Select Your Desk..!!',

          });

          return false;

        }else if(process_id==""){
              
          Swal.fire({ 

             title: 'Alert ! Select Your Process..!!',

          });

          return false;

        }else if(desk_head_id==""){
              
              Swal.fire({ 
    
                 title: 'Alert ! Select Milestore Owner..!!',
    
              });
    
              return false;
    
        }else if(default_uid==""){
              
              Swal.fire({ 
    
                 title: 'Alert ! Select Default Task User..!!',
    
              });
    
              return false;
    
        }else{
           
          $.ajax({

                method: 'POST',
                url: "/json/save/task_definition",
                data: {
                  'desk_uid': desk_uid,
                  'process_id':process_id,
                  'default_uid':default_uid,
                  'desk_head_id':desk_head_id,
                  'related_to':related_to,
                  'description':description,
                  'tclass_id':tclass_id,
                  'mail_send':mail_send,
                  'standard_day':standard_day,
                  'lag_day':lag_day,
                  'cal_type':cal_type,
                  'related_order':related_order,
                  'event_type_id':event_type_id,
                  '_token': $('input[name=_token]').val()
                },
                success: function (response) {

                   console.log(response);

                  if(response.status=="Success"){
                      
                      Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Task Save Successfully',
                        showConfirmButton: false,
                        timer: 1500
                      });

                  }else if(response.status=="Fail"){
                    
                      Swal.fire({
                          position: 'top-end',
                          icon: 'Fail',
                          title: 'Something Went Wrong',
                          showConfirmButton: false,
                          timer: 1500
                        }); 
                        
                  }
                  
                    
                },
                error: function (e) {

                    console.log(e);

                }

          }); 

        }

      }

      $("#tblMain").on('click','.btnDelete',function(){
          $(this).closest('tr').remove();
        });
      
</script>
@endsection