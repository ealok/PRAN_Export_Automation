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
   .btn {
    padding: 4px 12px;
   }
   .table-bordered > tbody > tr > td {
    font-size: 12px;
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
      min-height: 246px;  

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
                        <div class="col-sm-12" style="margin-top: 28px">
                           <span id="template_style">Task Template</span>
                            <div class="col-sm-5" id="left_side_style">
                              <br>
                              <span id="header_style">Template Header</span>
                              {{-- <div class="form-group {{ $errors->has('desk_uid') ? 'has-error' : '' }}" style="margin-top: 16px">
                                <label for="name">Template Type</label>
                                <div class="form-group{{ $errors->has('desk_uid') ? 'has-error' : '' }}">
                                  <select name="template_type" id="template_type" data-live-search="true" class="form-control select2 selectpicker input-xs"  type="select"  value="1">
                                    <option value="">Select</option>
                                    @foreach ($process as $value)
                                      <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                  </select> 
                                </div>
                              </div> --}}
                              {{-- <div class="form-group {{ $errors->has('desk_uid') ? 'has-error' : '' }}">
                                <label for="name">Company</label>
                                <div class="form-group{{ $errors->has('desk_uid') ? 'has-error' : '' }}">
                                  <select name="company_id" id="company_id" data-live-search="true" class="form-control select2 selectpicker input-xs"  type="select"  value="1">
                                    <option value="">Select</option>
                                    @foreach($companies as $company)
                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                    @endforeach
                                  </select> 
                                </div>
                              </div>                               --}}
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Template Name</label>
                                <input type="text" class="form-control input-xs" id="description" name="description">
                                @if ($errors->has('name'))
                                    <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                @endif
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Remark</label>
                                <textarea class="form-control input-sm" name="remark" id="remark" rows="2" style="height: 91px;width: 371px;"></textarea>
                                @if ($errors->has('name'))
                                    <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                @endif
                              </div>
                              <br>
                            </div>
                            <div class="col-sm-6 col-sm-offset-1" id="right_side_style">
                                <br>
                                <div class="row">
                                    <span id="adding_task_to_template">Adding Task To Template</span>
                                    <div class="col-sm-6">
                                      <div class="form-group form-group {{ $errors->has('task_id') ? 'has-error' : '' }}">
                                        <label for="task_id" >Task ID</label><br>
                                        <div class="form-group{{ $errors->has('task_id') ? 'has-error' : '' }}">
                                          <select name="task_id" id="task_id" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1">
                                            <option value="">Select</option>
                                            @foreach ($taskes as $task)
                                              <option value="{{$task->id}}">{{$task->DESCRIPTION}}</option>
                                            @endforeach
                                          </select> 
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                                        <label for="is_revised" >Task Name</label><br>
                                        <input type="text" class="form-control input-sm" id="task_description" name="task_description" readonly>
                                      </div>
                                    </div>
                                    <div class="col-sm-12">
                                      <div class="form-group form-group {{ $errors->has('dependent_task_id') ? 'has-error' : '' }}">
                                        <label for="dependent_task_id" >Dependent Task</label><br>
                                        <div class="form-group{{ $errors->has('dependent_task_id') ? 'has-error' : '' }}">
                                          <select name="dependent_task_id" id="dependent_task_id" data-live-search="true" class="form-control select2 selectpicker input-sm"  type="select"  value="1">
                                            <option value="">Select</option>
                                            @foreach ($taskes as $task)
                                              <option value="{{$task->id}}">{{$task->DESCRIPTION}}</option>
                                            @endforeach
                                          </select> 
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                                        <label for="is_revised" >Sequance</label><br>
                                        <input type="text" class="form-control input-sm" id="sequance" name="sequance">
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                                        <label for="is_revised" >Standard Days</label><br>
                                        <input type="text" class="form-control input-sm" id="standard_day" name="standard_day">
                                      </div>
                                    </div>
                                    <div class="col-sm-5" style="float: right">
                                      <div class="form-group form-group {{ $errors->has('') ? 'has-error' : '' }}">
                                        <label for="" ></label><br>
                                        <input type="submit" class="form-control input-sm btn btn-success add-row pull-right" value="Add Task">
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                  </form>  
                    <div class="row" style="margin-top: 10px">
                       <div class="col-sm-12">
                        <table class="table table-bordered" id="template_table">
                          <thead>
                            <tr>
                              <th>SL</th>
                              <th>Description</th>
                              <th>Dependent_Task</th>
                              <th>Standard_Days</th>
                              <th>Sequance</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="template_body_id">
                            
                          </tbody>
                        </table>
                        <button type="button" class="delete-row btn-danger pull-right" style="margin-left: 2px;">Delete Row</button>
                        <button type="button" class="delete-row btn-success pull-right" id="submit_button">Save Row</button>
                       </div>
                    </div>  
                  </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Template | Create';</script>
<script type="text/javascript">
    setTimeout(function() { 
          $('.sr-only').click();
    }, 0.0001);
    $(document).ready(function(){

        $("#submit_button").click(function(){
  
          var rowCount = $('#template_table tr').length;
          if(rowCount>1){
            
            // var template_type=$("#template_type").val();
            var description=$("#description").val();
            var remark=$("#remark").val();
            // var company_id=$("#company_id").val();
            var mail=$('input[name="mail"]:checked').val();
            var matching_info = new Array();
            $("#template_table TBODY TR").each(function () {
                var row = $(this);
                var dist_info = {};
                dist_info.task_description = row.find("TD").eq(1).html();
                dist_info.dependent_task_id = row.find("TD").eq(2).html();
                dist_info.standard_day = row.find("TD:eq(4) input").val();
                dist_info.sequance = row.find("TD:eq(5) input").val();;
                dist_info.task_id = row.find("TD").eq(6).html();
                matching_info.push(dist_info);
            });

            $.ajax({

                  method: 'POST',
                  url: "/template",
                  data: {
                    // 'template_type': template_type,
                    'description': description,
                    'remark':remark,
                    'mail':mail,
                    // 'company_id':company_id,
                    'matching_info':matching_info,
                    '_token': $('input[name=_token]').val()
                  },
                  success: function (response) {

                     console.log(response);

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
                      $('#company_id').selectpicker('refresh');
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
                //console.log(res)
                 //  return res;

                   $('#task_description').val(res.task_des);
                   $('#lay_day').val(res.lag_day);
                   $('#standard_day').val(res.standard_day);
                   $('#sequance').val("");
                   //loadAssigne(res.users,res.default_uid,res.user_type);
                  // var cat=res.user_types;
                  // var users=res.users;
                  //var html='<select class="form-control" name="default_uid" id="default_uid">';
                    //console.log(cat[0].name);
                   //for(var i=0;i<cat.length;i++){
                     //html+='<optgroup label="'+cat[i].name+'">';
                      //for(var j=0;j<users.length;j++){

                         

                        //   alert(users[j].type_id);
                          // alert(cat[i].id);
                        // if(users[j].type_id==cat[i].id){
                        //   if(users[j].id==res.default_uid){
                        //     html+='<option value="'+users[j].id+'" selected>'+users[j].name+'</option>';
                        //   }else{
                        //     html+='<option value="'+users[j].id+'">'+users[j].name+'</option>';
                        //   }
                        // }

                      //}          
                      //html+='</optgroup>';

                   //}
                   //html+='</option>';
                   //console.log(html)
                  //$('#default_uid').append(html);
              });
               
            } 
           
        }); 

        function loadAssigne(data,default_uid,type){

            if(data){

                var $el = $('#default_uid');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function (key, value) {
                    
                  $('select[name="default_uid"]').append(`<option value="${value.id}" ${value.id == parseInt(default_uid) ? 'selected' : ''}>${value.name}</option>`)

                });
                $el.selectpicker('refresh');

                
            }else{
                
                var $el = $('#default_uid');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $el.selectpicker('refresh'); 

            }


        }
        
        var i=0;
        $(".add-row").click(function(){

            var template_type=$("#template_type").val();
            var description=$("#description").val();
            var remark=$("#remark").val();
            var task_id = $("#task_id").val();
            var sequance = $("#sequance").val();
            var task_description =$("#task_id option:selected").text();
            var dependet_task_name= $("#dependent_task_id option:selected").text();
            var default_uid= $("#default_uid").val();
            if(dependet_task_name=="Select"){

              dependet_task_name="";    

            }
            var dependent_task_id=$("#dependent_task_id").val();
            var lay_day = $("#lay_day").val();
            var standard_day = $("#standard_day").val();
            if(task_id==""){
                
                Swal.fire({ 

                  title: 'Alert !! <br>Select Your Task ID..!!',

                }); 

                return false;

              }else if(task_description==""){
                
                  Swal.fire({ 

                      title: 'Alert !! <br>Required Your Task Description..!!',

                  });

                  return false;

            }else{
                i++;
                var seq=sequance=="" ?  i : sequance;
                var markup = "<tr><td>" + i + "</td><td>" + task_description + "</td><td style='display:none'>" +dependent_task_id+ "</td><td>" + dependet_task_name + "</td><td>" + '<input type="text" value="'+standard_day+'">' +"</td><td>" +'<input type="text" value="'+seq+'">'+ "</td><td style='display:none'>" +task_id+ "</td><td>"+"<input type='checkbox' name='record'>"+"</td></tr>";
                $("table tbody").append(markup);
                $('#task_id').val('').selectpicker('refresh');
                $('#sequance').val("");
                $('#task_description').val("");
                $('#dependent_task_id').val('').selectpicker('refresh');
                $('#standard_day').val('');
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