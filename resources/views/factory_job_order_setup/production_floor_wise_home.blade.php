
<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content') 
<style type="text/css">
  .main{

         position: absolute;
         border:1px solid #222;
         top: -13px;
         left: 35px;
         background: burlywood;
         width: 200px;
         text-align: center;
         height: 24px;

  }
  .form-group{
  
    margin-bottom: 0px;

  }
    
  tr:nth-child(2n+1) {background:#c4b366;}
  tr:nth-child(even) {background: #CCC}
  tr:first-child{darkgreen}  (nth-child(0) would also work)
  table {

    table-layout: fixed;

  }  
  .ellipsis {

    max-width: 40px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;

  }
  .table_footer{

    text-align: center;
    
  } 
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <div class="box-header with-border">
        <button class="btn btn-xs btn-success pull-right btn-flat" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Setup Create</button>
    </div>
    <br>
</section>
<div class="row" style="margin-top: -20px" id="row">
  <div class="col-md-12" style="font-size: 11px">
      <div class="box box-primary" style="background: rgba(206, 201, 201,); border-top-color: #e3e5e6;position: relative; width: 100%"> 
        <div class="panel-body table-responsive" style="border: 3px solid #c67520;" id="panelBody">
            <div class="col-sm-12">
                @if(Session::has('success'))
                <div class="alert alert-success">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Success!</strong>{{ Session::get('success') }}
                </div>
                @endif 
                @if(Session::has('danger'))
                <div class="alert alert-danger">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Alert!</strong>{{ Session::get('danger') }}
                </div>
                @endif 
               <div class="panel-body table-responsive" style="padding: 0px">
                <table id="example1" class="table table-bordered table-responsive table-condenced">
                <thead style="color: #3c2608;">
                  <tr>
                      <th style="text-align: center;background: #1ebd82">SL#</th>
                      <th style="text-align: center;background: #1ebd82">Production Floor</th>
                      <th style="text-align: center;background: #1ebd82">User</th>
                      <th style="text-align: center;background: #1ebd82">Action</th>
                  </tr>  
                </thead>
                <tbody>
                  @foreach($results as $result)
                    <tr>
                       <td>{{$result->id}}</td>
                       <td>{{$result->p_code}}/{{$result->p_name}}</td>
                       <td>{{$result->user_name}}/{{$result->staff_id}}</td>
                       <td><a href="#" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a></td>
                    </tr>
                  @endforeach  
                </tbody>
                </table>
              </div> 
            </div>
           </div> 
        </div>
        <label for="name" style="position: absolute;top: -21px;left: 40px;width: 252px;height: 23px;text-align: center;padding: 11px 15px 30px 18px;background: darkorange;color: black;border-radius: 20px;">Setup List</label>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Setup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">User:</label>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <select name="user_id" id="user_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                     <option value="">Select</option>
                     @foreach($users as $user)
                     <option value="{{$user->id}}">{{$user->username}} || {{$user->name}}</option>
                     @endforeach
                </select>
            </div>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Production Floor:</label>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <select name="p_floor_id" id="p_floor_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                     <option value="">Select</option>
                     @foreach($productionFloors as $productionFloor)
                     <option value="{{$productionFloor->id}}">{{$productionFloor->p_code}}->{{$productionFloor->p_name}}->{{$productionFloor->short_name}}</option>
                     @endforeach
                </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="onSaveProductionFloorDetals()">Create</button>
      </div>
    </div>
  </div>
</div>
<script>document.title = 'Production Floor Setup | Create';</script>
<script type="text/javascript">
     function onSaveProductionFloorDetals(){

        var user_id=$('#user_id').val();
        var p_floor_id=$('#p_floor_id').val();
        var url = "{{url('/json/saveProduction/floor/details')}}?user_id="+user_id+"&p_floor_id="+p_floor_id;
        if(user_id=="" || p_floor_id==""){
           
           alert("Please Select All..!!");

        }else{
 
            $.get(url, function(data) {
               console.log(data);
               if(data=='Success'){
                  
                  $('#exampleModal').modal('toggle');
                  alert("Create Successful..!!");

               }else if(data=='created'){

                  $('#exampleModal').modal('toggle');
                  alert("Already Created..!!");
               }
               else{

                  $('#exampleModal').modal('toggle');
                  alert("Create Failed..!!"); 
               }

            });

        }

     }
</script>
@endsection