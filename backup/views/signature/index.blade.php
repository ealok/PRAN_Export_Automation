@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>Signature<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/signature')}}"><i class="fa fa-dashboard"></i>Signature</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
  @if(Session::has('success'))
    <div class="callout callout-success">
        <strong>Success!</strong>{{ Session::get('success') }}
    </div> 
  @endif 
  @if(Session::has('danger'))
    <div class="callout callout-danger">
        <strong>Unsuccessful!</strong>{{ Session::get('danger') }}
    </div> 
  @endif 
  <div>
  <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border"><a href="{{url('/bu/create')}}">
          <a id="openCreateModal" data-toggle="modal" title="Delete"  href=""><button type="button" class="btn btn-xs btn-success btn-flat pull-right">Upload</button></a>
        </div>
        <div class="panel-body table-responsive">
          <table class="table table-bordered table-responsive table-condenced" id="example1">
              <thead>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Company</th>
                  <th>Signature</th>
                  <th>Controls</th>
              </thead>
              <tbody>
                
              </tbody>
          </table>
        </div>
    </div>
  </div>
</div>


<!-- Create Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
    <form enctype="multipart/form-data" id="createForm">
        {{ csrf_field() }}
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Signature Upload</h4>
          </div>
          <div class="modal-body">
              <div class="form-group">
                  <div class="form-group{{ $errors->has('user_id') ? 'has-error' : '' }}">
                    <label for="user_id">User</label>
                    <select name="user_id" id="user_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                      <option value="">Select</option>
                      @foreach($users as $user)
                      <option value="{{$user->id}}">{{$user->name}}-{{$user->username}}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('user_id'))
                        <span class="help-block"><strong>{{ $errors->first('user_id') }}</strong></span>
                    @endif  
                  </div>
              </div>
              <div class="form-group">
                <div class="form-group{{ $errors->has('company_id') ? 'has-error' : '' }}">
                  <label for="company_id">Company</label>
                  <select name="company_id" id="company_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                      <option value="">Select</option>
                      @foreach($companies as $company)
                      <option value="{{$company->id}}">{{$company->code}}</option>
                      @endforeach
                  </select>
                  @if($errors->has('company_id'))
                      <span class="help-block"><strong>{{ $errors->first('company_id') }}</strong></span>
                  @endif  
                </div>
              </div>
              <div class="form-group">
                  <label for="exampleInputEmail1">Signature</label>
                  <input type="file" class="form-control" id="signature" name="signature" placeholder="" required>
              </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-info" >Upload</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
          </div>
        </div>
    </form>
  </div>
</div> <!----End model----->

<!-- Edit Modal -->
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
    <form enctype="multipart/form-data" id="updateForm">
        {{ csrf_field() }}
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Signature Upload</h4>
          </div>
          <div class="modal-body">
              <div class="form-group">
                  <div class="form-group{{ $errors->has('euser_id') ? 'has-error' : '' }}">
                    <label for="euser_id">User</label>
                    <select name="euser_id" id="euser_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                      <option value="">Select</option>
                      @foreach($users as $user)
                      <option value="{{$user->id}}">{{$user->name}}-{{$user->username}}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('euser_id'))
                        <span class="help-block"><strong>{{ $errors->first('euser_id') }}</strong></span>
                    @endif  
                  </div>
              </div>
              <div class="form-group">
                <div class="form-group{{ $errors->has('ecompany_id') ? 'has-error' : '' }}">
                  <label for="ecompany_id">Company</label>
                  <select name="ecompany_id" id="ecompany_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                      <option value="">Select</option>
                      @foreach($companies as $company)
                      <option value="{{$company->id}}">{{$company->code}}</option>
                      @endforeach
                  </select>
                  @if($errors->has('ecompany_id'))
                      <span class="help-block"><strong>{{ $errors->first('ecompany_id') }}</strong></span>
                  @endif  
                </div>
              </div>
              <div class="form-group">
                  <label for="exampleInputEmail1">Signature</label>
                  <input type="file" class="form-control" id="esignature" name="esignature" placeholder="">
                  <input type="hidden" value="" id="edit_id" name="edit_id"> 
              </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-info" >Upload</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
          </div>
        </div>
    </form>
  </div>
</div> <!----End model----->

<script>document.title = 'Signature Upload';</script>
<script type="text/javascript">

    $(document).ready(function(){

       $('#example1').dataTable().fnDestroy(); 
        var table=$('#example1').DataTable({
            dom: 'Bfrtip', 
            buttons: [
                'csv', 'excel'
            ],
            "ajax": {
                "url": "/json/get/user_singature",
                "type": "GET",
                "dataSrc": function (json) {
                      
                    if(json.data.length > 0) {

                        return json.data;
                        
                    } else {

                        return false;

                    }

                }
            },
            "columns": [
                { "data": "user"}, 
                { "data": "user"},
                { "data": "company"},
                { "data": "image",

                  "render": function(data, type, row) {

                    return '<img src="' + data + '" alt="Image" width="80" height="40">';

                  }

                },
                { 
                    "data": null,
                    render: function(data, type, row){

                        return '<input type="button" data-id="'+row.id+'" class="btn-sm btn-info btn-edit" value="Edit" data-toggle="modal">' 
                    
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
    // Handle Create model
    $(document).on("click", "#openCreateModal", function () {

        var user_id = $(this).data("id");
        $("#myModal").modal("show");

    });

    //@@@Handle edit model
    $('#example1 tbody').on('click', '.btn-edit', function (e) {
         
        var edit_id=$(this).data('id');
        $.ajax({
            type: "GET",
            url: "{{url('/json/get/signature_edit/data')}}?edit_id=" + $(this).data('id'),
            success: function (response) {

                var updatedUser = response.users;
                var updatedComapany= response.companies;
                var updatedUserId=response.updatedUserId;
                var updatedCompanyId=response.updatedCompanyId;
                $('#euser_id').empty();
                $('#ecompany_id').empty();
                $.each(updatedUser, function(index, user) {

                  var selected = (user.id == updatedUserId) ? 'selected' : '';
                  $('#euser_id').append('<option value="' + user.id + '" ' + selected + '>' + user.name + '-' + user.username + '</option>');
                  
                });

                $.each(updatedComapany, function(index, company) {

                  var selected = (company.id == updatedCompanyId) ? 'selected' : '';
                  $('#ecompany_id').append('<option value="' + company.id + '" ' + selected + '>' + company.code + '</option>');

                });

                $('#euser_id, #ecompany_id').selectpicker('refresh');
                $("#editModal").modal("show");
                $("#editModal #edit_id").val(edit_id);

            }

        });

    }); //@@@@@-End Model--@@@    
    //@@@Submit Create model
    $("#createForm").submit(function (e) {
        
        var signature=$('#signature').val();
        e.preventDefault(); 
        $.ajax({
            type:'POST',
            url: "{{ url('/signature')}}",
            data: new FormData(this),
            cache:false,
            contentType: false,
            processData: false,
            success: (res) => {
                
                if(res.code==200){
                
                   Swal.fire({
                       position: 'top-end',
                       icon: 'success',
                       title: 'Create Successfully Done..!!',
                       showConfirmButton: false,
                       timer: 1500
                   });

                   $(this).trigger('reset');
                   $('#user_id').val('').selectpicker('refresh');
                   $('#company_id').val('').selectpicker('refresh');
                   $("#myModal").modal("hide");
                   var table2 = $('#example1').DataTable();
                   table2.ajax.reload();



                }else if(res.code==500){

                   Swal.fire({
                       icon: 'error',
                       title: 'Oops...',
                       text: 'Something went wrong!'
                   });

                }else if(res.code==404){

                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Already assign signature..!!'
                    });

                }
                                      
            },
            error: function(data){

                console.log(data);
                
            }
        });

    }); //@@@@-End Model
    //@@@Submit Update model@@@
    $("#updateForm").submit(function (e) {
        
        var signature=$('#signature').val();
        e.preventDefault(); 
        $.ajax({
            type:'POST',
            url: "{{ url('/update/signature')}}",
            data: new FormData(this),
            cache:false,
            contentType: false,
            processData: false,
            success: (res) => {

                   console.log(res);
                
                if(res.code==200){
                
                   Swal.fire({
                       position: 'top-end',
                       icon: 'success',
                       title: 'Updated Successfully Done..!!',
                       showConfirmButton: false,
                       timer: 1500
                   });

                   $(this).trigger('reset');
                   $('#euser_id').val('').selectpicker('refresh');
                   $('#ecompany_id').val('').selectpicker('refresh');
                   $("#editModal").modal("hide");
                   var table3 = $('#example1').DataTable();
                   table3.ajax.reload();

                }else if(res.code==500){

                   Swal.fire({
                       icon: 'error',
                       title: 'Oops...',
                       text: 'Something went wrong!'
                   });

                }
                                      
            },
            error: function(data){

                console.log(data);
                
            }
        });

    }); //@@@@-End Model--

</script>
@endsection