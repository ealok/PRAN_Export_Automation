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
      min-height: 460px;  

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
/* 
.bootstrap-select > .dropdown-toggle.bs-placeholder:hover {
  color: #222;
  border: 1px solid;
  border-radius: 50px;
} */

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
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
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
               <h3 class="box-title" id="def_header_style">Task Definition</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="" id="task_definition">
              {{ csrf_field() }}
                  <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-6" id="left_side_style">
                              <div class="form-group {{ $errors->has('desk_uid') ? 'has-error' : '' }}">
                                <label for="name">Section</label>
                                <div class="form-group{{ $errors->has('desk_uid') ? 'has-error' : '' }}">
                                  <select name="desk_uid" id="desk_uid" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" required>
                                      <option value="">Select</option>
                                      @foreach($desks as $desk)
                                       <option value="{{$desk->id}}" @if($desk->id == $taskDefinition->desk_uid) {{'selected'}} @endif>{{$desk->name}}</option>
                                      @endforeach
                                  </select> 
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Process</label>
                                <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                                  <select name="process_id" id="process_id" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" required>
                                      <option value="">Select</option>
                                      @foreach ($process as $value)
                                        <option value="{{$value->id}}" @if($value->id == $taskDefinition->process_id) {{'selected'}} @endif>{{$value->name}}</option>
                                      @endforeach
                                  </select> 
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Milestore Owner</label>
                                <div class="form-group{{ $errors->has('desk_head_id') ? 'has-error' : '' }}">
                                  <select name="desk_head_id" id="desk_head_id" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" required>
                                      <option value="">Select</option>
                                      @foreach ($users as $user)
                                         <option value="{{$user->id}}" @if($user->id == $taskDefinition->desk_head_uid) {{'selected'}} @endif>{{$user->name}}</option>  
                                      @endforeach
                                  </select> 
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('default_uid') ? 'has-error' : '' }}">
                                <label for="name">Default Assignee</label>
                                <div class="form-group{{ $errors->has('default_uid') ? 'has-error' : '' }}">
                                  <select name="default_uid" id="default_uid" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" required>
                                      <option value="">Select</option>
                                      @foreach ($users as $user)
                                         <option value="{{$user->id}}" @if($user->id == $taskDefinition->default_uid) {{'selected'}} @endif>{{$user->name}}</option>    
                                      @endforeach
                                  </select> 
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Relate To</label>
                                <div class="form-group{{ $errors->has('related_to') ? 'has-error' : '' }}">
                                  <select name="related_to" id="related_to" data-live-search="true" class="form-control select2 selectpicker"  type="select"  value="1" >
                                      <option value="">Select</option>
                                  </select> 
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Event Type</label>
                                <div class="form-group{{ $errors->has('related_to') ? 'has-error' : '' }}">
                                  <select name="event_type_id" id="event_type_id" data-live-search="true" class="form-control select2 selectpicker" type="select"  value="1" >
                                      <option value="">Select</option>
                                      @foreach ($event_types as $event_type)
                                        <option value="{{$event_type->id}}" @if($event_type->id == $taskDefinition->event_type_id) {{'selected'}} @endif>{{$event_type->name}}</option>                                       
                                      @endforeach
                                  </select> 
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Description</label>
                                <textarea class="form-control input-sm" name="description" id="description" required>{{$taskDefinition->description}}</textarea>
                                @if ($errors->has('name'))
                                    <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                @endif
                              </div>
                            </div>
                            <div class="col-sm-5" id="right_side_style">
                                <div class="row">
                                    <div class="col-sm-7">
                                      <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                                        <label for="is_revised" >Task Class</label><br>
                                        <label class="radio-inline">
                                            <input type="radio" name="tclass_id"  id="tclass_id" value="1" required @if($taskDefinition->tclass_id==1){{'checked'}}@else{{""}}@endif><span class="task_class_id">Milestone</span>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="tclass_id"  id="tclass_id" value="0" required @if($taskDefinition->tclass_id==0){{'checked'}}@else{{""}}@endif><span class="task_class_id">Normal</span>
                                        </label>
                                      </div>
                                    </div>
                                    <div class="col-sm-5">
                                      <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                                        <label for="is_revised" >Mail Send</label><br>
                                        <label class="radio-inline">
                                            <input type="radio" name="mail_send" id="mail_send"  value="1"   id="is_revised" @if($taskDefinition->mail_send==1){{'checked'}}@else{{""}}@endif><span class="task_class_id">Yes</span>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="mail_send" id="mail_send" value="0" ><span class="task_class_id" @if($taskDefinition->mail_send==1){{'checked'}}@else{{""}}@endif>No</span>
                                        </label>
                                      </div> 
                                    </div>
                                    <div class="col-sm-5">
                                      <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                                        <label for="is_revised" >Standard Days</label><br>
                                        <label class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                            <input type="text" id="standard_day" name="standard_day" class="form-control input-sm" value="{{$taskDefinition->standard_days}}">
                                        </label>
                                      </div> 
                                    </div>
                                    <div class="col-sm-5">
                                      <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                                        <label for="is_revised" >Lag Days</label><br>
                                        <label class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                            <input type="text" id="lag_day" name="lag_day" class="form-control input-sm" value="{{$taskDefinition->lag_day}}">
                                        </label>
                                      </div> 
                                    </div>
                                    <div class="col-sm-5">
                                      <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                                        <label for="is_revised" >Cal Type</label><br>
                                        <label class="radio-inline">
                                          <input type="radio" name="cal_type"   value="1"   id="cal_type" @if($taskDefinition->cal_type==1){{'checked'}}@else{{""}}@endif><span class="task_class_id">BW</span>
                                        </label> 
                                        <label class="radio-inline">
                                          <input type="radio" name="cal_type"  value="0" id="cal_type" @if($taskDefinition->cal_type==0){{'checked'}}@else{{""}}@endif><span class="task_class_id">FW</span>
                                        </label>
                                      </div> 
                                    </div>
                                    <div class="col-sm-5">
                                      <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                                        <label for="name">Relate Order</label>&nbsp;&nbsp;
                                        <input type="checkbox" class="form-check-input" id="related_order" name="related_order" value="1" `@if($taskDefinition->related_to==1){{'checked'}}@else{{""}}@endif>
                                      </div> 
                                    </div>
                                      <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <input type="submit" class="btn btn-info pull-center btn-flat" style="margin-left: 44px;margin-top: 5px;" value="Updated" onclick="return saveTaskDefinitionDetails()">
                                        <input type="hidden" value="{{$edit_id}}" id="edit_id">
                                     </div>
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
<script>document.title = 'Task Definiation';</script>
<script type="text/javascript">

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
                url: "/json/update/task_definition",
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
                  'edit_id':edit_id,
                  '_token': $('input[name=_token]').val()
                },
                success: function (response) {

                  if(response.status=="Success"){
                      
                      Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Updated Successfully Done',
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
</script>
@endsection