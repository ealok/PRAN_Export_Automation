@extends('layouts.master')
@section('content') 
<style>
  .modal-title{
    text-align: left;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: bold;
  }

</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
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
    </div>
</div>

<div class="row">
    <!-- First Box for Staff ID and Buttons -->
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="staff_id">Staff Id</label>
                        <input type="text" id="staff_id" class="form-control" placeholder="Enter staff id">
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-sm-3">
                        <input type="button" class="btn btn-info btn-xs btn-submit" value="Show Party">
                        <input type="button" class="btn btn-primary btn-xs btn-assign" value="Assign Party">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--@@@@@@@ Item Added Modal @@@@@@@-->
    <div class="modal fade" id="partyAddedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="addSubmitFormId">
                {{csrf_field()}} 
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Party Assign</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">  
                        <div class="box-header with-border">
                            <div class="col-sm-4">
                                <label for="user_id" id="party">User:</label>
                                <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                    <select name="user_id" id="user_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                                        <option value="">Select</option>
                                        @foreach($users as $users)
                                        <option value="{{$users->id}}">{{$users->username}}-{{$users->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                            <label for="ci_item_id" id="party">Party :</label>
                            <div class="form-group {{ $errors->has('ci_item_id') ? 'has-error' : '' }}">
                                <select name="party_list[]" autofocus multiple id="party_list">
                                    @foreach($notify_parties as $notify_party)
                                    <option value="{{$notify_party->id}}">{{$notify_party->code}}-{{$notify_party->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div><!--@@@@@@@ End Modal @@@@@@@-->
    <!-- Second Box for the Table -->
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Party User List</h3>
            </div>
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-responsive table-condensed">
                    <thead>
                        <tr>
                            <th style="width: 5px">Select</th>
                            <th>Party</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="row" id="action_btn_id" style="text-align: center; margin-top: 15px;">
                    <div class="col-sm-12">
                        <button class="btn btn-xs btn-primary" id="check_all">Check All</button>
                        <button class="btn btn-xs btn-info" id="uncheck_all">Uncheck All</button>
                        <button class="btn btn-xs btn-danger" id="delete_all">Delete All</button>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

<script>document.title = 'Party Permission';</script>
<script type="text/javascript">
    $('#action_btn_id').hide();
    setTimeout(function() { 
          $('.sr-only').click();
    }, 0.0001);
    $('#party_list').multiselect({
      columns: 1,
      placeholder: 'Select Item',
      search: true,
      selectAll: true
    });  

    $(document).ready(function () {
        $('.btn-submit').click(function(){
            var staff_id = $('#staff_id').val();
            if(staff_id == ""){
                Swal.fire({
                    icon: 'warning',
                    text: 'Please Enter Staff Id.!!',
                });
            } else {
                loadPartyUserList(staff_id);  
                $('#staff_id').val("");
            }
        });

        $('#check_all').click(function(){
            $('input[type="checkbox"]').prop('checked', true);
        });

        $('#uncheck_all').click(function(){
            $('input[type="checkbox"]').prop('checked', false);
        });
       
        $('.btn-assign').click(function(){
            $('#partyAddedModal').modal('show');
        });
        

        $('#delete_all').click(function(){
            var item_ids = [];   
            $("#example1 tbody").find('input[name="item"]').each(function(){
                if($(this).is(":checked")){
                    item_ids.push($(this).data('item-id'));
                }
            });

            if(item_ids.length == 0){
                Swal.fire(
                    'Alert!',
                    'Please select at least one.!',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "{{url('/delete/notify/party_user')}}",
                    type: "get",
                    dataType: "json",
                    data: {'item_ids':item_ids,'_token': $('input[name=_token]').val()},
                    success: function(res) {
                        if(res.code == 200){
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Delete Successfully Done..!!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            var table2 = $('#example1').DataTable();
                            table2.ajax.reload();
                        }
                    }
                });
            }
        });

        function loadPartyUserList(staff_id){
            $('#example1').dataTable().fnDestroy(); 
            var table = $('#example1').DataTable({
                "ajax": {
                    "processing": true,
                    "serverSide": true,
                    "url": "/json/get/party_user/list",
                    "type": "GET",
                    data: {'staff_id': staff_id, "_token": $('input[name=_token]').val()},
                    "dataType": "json",
                    "dataSrc": function (json) {
                        if(json.data.length > 0){
                            $('#action_btn_id').show();
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
                            return '<input type="checkbox" id="checkItem" name="item" data-item-id="'+row.id+'">';
                        }
                    },
                    { "data": "party"},
                    { "data": "user"}
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
    });
    $("#addSubmitFormId").submit(function (e) {

      e.preventDefault(); 
        $.ajax({
            type:'POST',
            url: "{{ url('/notify_party_user')}}",
            data: new FormData(this),
            cache:false,
            contentType: false,
            processData: false,
            success: (res) => {
              
                if(res.code==200){
                    
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Successfully Done..!!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $(this).trigger('reset');
                    $('#user_id').val('').selectpicker('refresh');
                    // $('#party_list').val([]).trigger('change');
                    $('#party_list').selectpicker('refresh');
                    $('#partyAddedModal').modal('hide');
                     

                }else if(res.code==409){
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Already exists this item..!!'
                    });

                }
                        
            },
            error: function(data){

                console.log(data);
                
            }
         
         });   

    });
</script>
@endsection
