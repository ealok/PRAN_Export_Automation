@extends('layouts.master')
@section('content')
<style>
   
   #def_header_style{
         
      position: absolute;
      top: -18px;
      background: #FFF;
      border: 1px solid #406CF0;
      padding: 6px 28px 6px 20px;
   }
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
      min-height: 169px;  

   }

   #right_side_style{
   
   border: 1px solid blue;
   min-height: 246px;


}
.bootstrap-select > .dropdown-toggle.bs-placeholder{

  color: #222;
  border: 1px solid blue;

}
.btn-default {

  background-color: #FFFFFF;

}
.table > thead:first-child > tr:first-child > th {

  border: 1px solid blue;

}

.table-bordered > tbody > tr > td{

  border: 1px solid blue;
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
#header_style{
 
  position: absolute;
  top: -9px;
  background: #FFFFFF;
  border: 1px solid blue;
  width: 124px;
  font-weight: bold;
  color: cornflowerblue;

}

#adding_task_to_template{

  position: absolute;
  left: 16px;
  top: -7px;
  background: #FFF;
  border: 1px solid blue;
  font-weight: bold;
  color: cornflowerblue;

}

.row {

  margin-right: 0px;
  margin-left: 0px;

}

#template_style{

  position: absolute;
  left: 13px;
  top: -52px;
  border: 1px solid blue;
  width: 200px;
  text-align: center;
  background: #FFF;
  font-weight: bold;
  font-size: 18px;
  color: cornflowerblue;
  
}

</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/template')}}"><i class="fa fa-dashboard"></i>Template List</a></li>
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
             <form class="" role="form" method="POST" action="" id="task_definition">
              {{ csrf_field() }}
                  <div class="box-body">
                    <div class="row">
                        @foreach ($templateMaster as $value)
                        <div class="col-sm-12" style="margin-top: 28px">
                           <span id="template_style">View Template</span>
                            <div class="col-sm-12" id="left_side_style">
                               <br>
                              <span id="header_style">Template Header</span>
                              <div class="form-group {{ $errors->has('desk_uid') ? 'has-error' : '' }}" style="margin-top: 16px">
                                <label for="name">Template Type: {{$value->tempalte_type}}</label>
                              </div>           
                              <br>                   
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Template Name : {{$value->template_name}}</label>
                              </div>
                              <br>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Remark : {{$value->remark}}</label>
                              </div>
                            </div>
                        </div>
                        @endforeach
                    </div> 
                  </form>  
                    <div class="row" style="margin-top: 10px">
                       <div class="col-sm-12">
                        <table class="table table-bordered" id="template_table">
                          <thead>
                            <tr>
                              <th>Sequance</th>
                              <th>Task_Name</th>
                              <th>Dependent_Task</th>
                              <th>Standard_Days</th>
                              <th>Lag_Days</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="template_body_id">
                           @foreach ($templateDetails as $key=>$value)
                           <tr>
                              <td>{{$key+1}}</td>
                              <td>{{$value->task_name}}</td>
                              <td>{{$value->dependent_task}}</td>
                              <td>{{$value->standard_day}}</td>
                              <td>{{$value->lay_day}}</td>
                              <td>
                                 <button type="button" class="btn btn-xs btn-info btn-flat">Edit</button>
                                 <button type="button" class="btn btn-xs btn-danger btn-flat">Del</button>
                              </td>   
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                       </div>
                    </div>  
                  </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Task Definiation';</script>
<script type="text/javascript">

    $(document).ready(function(){

        $("#submit_button").click(function(){
  
          var rowCount = $('#template_table tr').length;
          if(rowCount>1){
            
            var template_type=$("#template_type").val();
            var description=$("#description").val();
            var remark=$("#remark").val();
            var mail=$('input[name="mail"]:checked').val();
            var matching_info = new Array();
            $("#template_table TBODY TR").each(function () {
                  var row = $(this);
                  var dist_info = {};
                  dist_info.sequance = row.find("TD").eq(0).html();
                  dist_info.task_description = row.find("TD").eq(1).html();
                  dist_info.dependent_task_id = row.find("TD").eq(2).html();
                  dist_info.lay_day = row.find("TD").eq(4).html();
                  dist_info.standard_day = row.find("TD").eq(5).html();
                  dist_info.task_id = row.find("TD").eq(6).html();
                  matching_info.push(dist_info);
            });

            console.log(matching_info);

            $.ajax({

                  method: 'POST',
                  url: "/template",
                  data: {
                    'template_type': template_type,
                    'description': description,
                    'remark':remark,
                    'mail':mail,
                    'matching_info':matching_info,
                    '_token': $('input[name=_token]').val()
                  },
                  success: function (response) {

                    if(response.status=='success'){
                         
                      Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Template Create Successfully',
                        showConfirmButton: false,
                        timer: 1500
                      });

                      $('#task_definition').trigger("reset");
                      $('#task_id').selectpicker('refresh');
                      $('#assign_id').selectpicker('refresh');
                      $('#template_type').selectpicker('refresh');
                      $("#template_body_id").empty();

                    }

                   
                   
                    
                  },
                  error: function (e) {

                      console.log(e);

                  }

              });

              
          }else{

            // Swal.fire({ 

            //     title: 'Alert ! <br> Atleat you have to added one task..!!',

            // });

          } 

 
        });

        $("#task_id").change(function(){
            
            var task_id=$(this).val();

            if(task_id){

              var url = "{{url('/json/get/task/details')}}/"+task_id;
              $.get(url,function(res) {
                   
                   $('#task_description').val(res.task_des);
                   $('#lay_day').val(res.lag_day);
                   $('#standard_day').val(res.standard_day);
                   loadAssigne(res.users,res.default_uid);
                   

              });
               
            } 
           
        }); 

        function loadAssigne(data,default_uid){

            if(data){

                var $el = $('#assign_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function (key, value) {
                    
                  $('select[name="assign_id"]').append(`<option value="${value.id}" ${value.id == parseInt(default_uid) ? 'selected' : ''}>${value.name}</option>`)

                });
                $el.selectpicker('refresh');

                
            }else{
                
                var $el = $('#assign_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $el.selectpicker('refresh'); 

            }


        }

        $(".add-row").click(function(){

            var template_type=$("#template_type").val();
            var description=$("#description").val();
            var remark=$("#remark").val();

            var task_id = $("#task_id").val();
            var sequance = $("#sequance").val();
            var task_description = $("#task_description").val();
            var dependet_task_name= $( "#dependent_task_id option:selected" ).text();
            if(dependet_task_name=="Select"){

              dependet_task_name="";    

            }
            var dependent_task_id=$("#dependent_task_id").val();
            var lay_day = $("#lay_day").val();
            var standard_day = $("#standard_day").val();
            if(template_type==""){

              Swal.fire({ 

                   title: 'Alert ! Select Your Task Type..!!',

              });

              return false; 

            }else if(description==""){
              
              Swal.fire({ 

                 title: 'Alert ! Description Con Not Empty..!!',

              });

              return false;

            }else if(task_id==""){
                
              Swal.fire({ 

                 title: 'Alert ! Select Your Task ID..!!',

              }); 

              return false;

            }else if(sequance==""){
                
                Swal.fire({ 
  
                   title: 'Alert !  Please Put Your Task Sequance..!!',
  
                }); 

                return false;
  
              }else if(task_description==""){
                
              Swal.fire({ 

                   title: 'Alert ! Required Your Task Description..!!',

              });

              return false;

            }else{
               
                var markup = "<tr><td>" + sequance + "</td><td>" + task_description + "</td><td style='display:none'>" +dependent_task_id+ "</td><td>" + dependet_task_name + "</td><td>" +lay_day +"</td><td>" +standard_day+ "</td><td style='display:none'>" +task_id+ "</td><td>"+"<input type='checkbox' name='record'>"+"</td></tr>";
                $("table tbody").append(markup);

            } 

            return false;
            
        });
        
        // Find and remove selected table rows
        $(".delete-row").click(function(){
            $("table tbody").find('input[name="record"]').each(function(){
            	if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                }
            });
        });

    });

</script>
@endsection