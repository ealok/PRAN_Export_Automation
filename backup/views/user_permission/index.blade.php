@extends('layouts.master')
@section('content') 
<style>
    .btn {
        padding: 3px 12px;
    }
    .table > thead > tr > th{
        padding: 1px;
    }
    .table > tbody > tr > td {
        padding: 0px;
    }
    .table-bordered > thead > tr > th {
       border: 1px solid #c6c6c6 !important;
    }
    .table-bordered > tbody > tr > td {
        border: 1px solid #c6c6c6;
        font-size: 11px
    }
    h5{
        text-align: center;
        text-transform: uppercase;
        background: #1db5b5;
        width: 200px;
        padding: 6px;
        font-weight: bold;
        color: white;
    }
    .btn-default {
        border-color: #a8a1a1;
    }
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1>Role-Permission<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"></a></li>
      <li class="active"></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
                 <!-- /.box-body-start --> 
                 <div class="box-body">
                    <div class="row">
                        <form class="form-horizontal" id="roleFormId">
                        {{ csrf_field() }}
                         <div class="col-sm-6">
                            <h5>Role Permission</h5>
                            <div class="form-group" style="margin-bottom: 5px;">
                                <label for="user_id" class="col-sm-2 control-label">User</label>
                                <div class="col-sm-8">
                                    <select name="user_id" id="user_id_role" data-live-search="true" class="form-control select2 selectpicker"  type="select"  value="1" required>
                                        <option value="">Select</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" @if(request()->get('user_id') == $user->id){{"selected"}} @endif>{{$user->username}}-{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="userErrorRole"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="qc_master_id" class="col-sm-2 control-label">Role</label>
                                <div class="col-sm-8">
                                    <select name="role_id" id="role_id" data-live-search="true" class="form-control select2 selectpicker"  type="select"  value="1" required>
                                        <option value="">Select</option>
                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="roleError"></span>
                                </div>
                            </div>
                            <br>
                            <div class="col-sm-8"></div>
                            <div class="col-sm-2"><input type="submit" class="btn btn-info pull-right btn-flat" value="Submit" style="margin-bottom: 10px;"></div>
                           </form>
                           </br>
                            <table class="table table-bordered table-condenced" id="example1">
                                <thead>
                                    <tr> 
                                        <th>#Sl</th>
                                        <th>User</th>
                                        <th>Role</th>
                                        <th>Controls</th>
                                    </tr>  
                                </thead>
                                <tbody>
                                
                                </tbody>
                            </table>
                       </div>   
                              
                    </div> 
            </div>  
        </div> 
    </div>
</div>
<script>document.title = 'Role Permission';</script>
<script type="text/javascript">
    setTimeout(function() { 
  $('.sr-only').click();
}, 0.0001);
    $(document).ready(function() {
         
        //@@@--get user role
        $('#user_id_role').change(function(e){

            $('#example1').dataTable().fnDestroy(); 
            var table=$('#example1').DataTable({
                "ajax": {
                    "url" : "/jsonGetUserRole",
                    "type": "GET",
                    "data": {'user_id':$(this).val()},
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
                      "render": function(data, type, full, meta) {

                          return meta.row + 1;

                      }
                    },
                    { "data": "user"},
                    { "data": "role"},
                    { 
                        "data": null,
                        render: function(data, type, row){

                            return '<input type="button" data-id="'+row.id+'" class="btn btn-danger btn-xs btn-edit" value="Del">' 
                        
                        }
                    }

                ],
                "language": {

                    "emptyTable": "No records available"
                },
                "searching": false, 
                "info": false,      
                "paging": false,      
                "dataSrc": function (json) {

                    if (!json.data || json.data.length === 0) {

                        return false;
                    }
                    return json.data;
                }
            
            }); 

        });

        $("#roleFormId").submit(function (e) {
            
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                type:'POST',
                url: "{{ url('/update/user_role')}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (res) => {
                    
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: res.msg,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    var table2 = $('#example1').DataTable();
                    table2.ajax.reload();  
                                       
                },
                error: function(data){

                    console.log(data);
                    
                }
            });

        });
  

    });

</script>
@endsection