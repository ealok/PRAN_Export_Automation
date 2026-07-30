@extends('layouts.master')
@section('content') 
<style>
.form-control {

  border-radius: 0;
  box-shadow: none;
  border-color: #0d18b9;
  height: 25px;
  width: 83px;
  font-size: 11px;

 }

 .ms-options-wrap > button {

    position: relative;
    width: 100%;
    text-align: left;
    border: 1px solid #aaa;
    background-color: #fff;
    padding: 0px 15px 4px 5px;
    margin-top: 0px;
    font-size: 13px;
    color: #aaa;
    outline: none;
    white-space: nowrap;

  }

 .form-group {

   margin-bottom: 0px;

 }

 .ms-options-wrap > .ms-options {
    position: absolute;
    left: 0;
    width: 200%;
    margin-top: 1px;
    margin-bottom: 20px;
    background: white;
    z-index: 2000;
    border: 1px solid #aaa;
  }


 .modal-body{

  position: relative;
  top: -12px;
  padding: 18px;

 }

 .modal-header .close {

  margin-top: -22px;

 }

.modal-header {

  border-bottom-color: #cac4c4;

}

 #right_side_style{
 
  border: 2px solid blue;
  min-height: 439px;
  margin-left: 5px;  

}
.bootstrap-select > .dropdown-toggle.bs-placeholder{

  color: #222;
  border: 1px solid #0f0f1a;
  border-radius: 10px;

}

.btn-default {

background-color: #FFFFFF;

}
.btn{

  padding: 3px 12px;
  padding-right: 12px;
  margin-bottom: 0;
  font-size: 12px;
  font-weight: 400;
  line-height: 1.42857143;
  text-align: center;
  white-space: nowrap;
  touch-action: manipulation;
  cursor: pointer;
  user-select: none;
  background-image: none;

}

.bootstrap-select > .dropdown-toggle.bs-placeholder,.bootstrap-select > .dropdown-toggle.bs-placeholder:hover {

  color: #222;
  border: 1px solid #0f0f1a;
  border-radius: 10px;

}

.btn dropdown-toggle btn-default{

  border-radius: 10px;

}
.form-control{

  border-radius: 10px;

}


.modal-title{
    text-align: left;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: bold;
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
  font-size: 11px;

}

.table-bordered > tbody > tr > td{

  border: 1px solid #201f1f;
  padding: 0px;
  font-weight: normal;
  font-family: initial;

}

.table > tbody > tr > td{
 
  padding: 1px;
  line-height: 1.42857143;
  vertical-align: top;
  font-size: 10px;

}

.table-bordered > tbody > tr > td{
  
  border: 1px solid #201f1f;
  padding: 1px;
  font-weight: bold;

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


.form-horizontal .form-group {

  margin-right: 0px;
  margin-left: 0px;

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
img{

  height: 40px;
  position: absolute;
  top: -3px;
  left: 1051px;

}
.box-header.with-border {

  border-bottom: none;

}

::-webkit-input-placeholder {
  font-size: 11px; /* Adjust the font size as needed */
}

:-moz-placeholder {
  font-size: 11px; /* Adjust the font size as needed */
}

::-moz-placeholder {
  font-size: 11px; /* Adjust the font size as needed */
}

:-ms-input-placeholder {
  font-size: 11px; /* Adjust the font size as needed */
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
.bootstrap-select > .dropdown-toggle.bs-placeholder, .bootstrap-select > .dropdown-toggle.bs-placeholder:hover {
  color: #222;
  border: 1px solid #0D18B9;
  border-radius: 10px;
}
.modal-footer {

  padding: 14px;
  border-top: 1px solid #c4c2c2;

}

#tblMain {

   display: block;

}

#po_details_table_id_wrapper{

  padding: 13px;
  width: 1015px;
  margin: auto;

}
.table > thead > tr > th {
    padding: 4px;
}

#item_add_btn_id{

  padding: 2px 3px;
  font-weight: bold;

}

#tblMain{

  height: 358px;      
  overflow-y: auto;    
  overflow-x: hidden;  
}

hr{

  margin-top: 36px;
  margin-bottom: -20px;
  border-top: 1px solid #d7d2d2;
}
.fixed-width-select{

  position: absolute;
  top: -3px;
  width: 261px !important;

}

</style>
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/pfp')}}"><i class="fa fa-dashboard"></i>PFP List</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px">
        <form class="form-inline">
          <div class="box-header with-border">
            <div class="col-sm-4">
                <label for="name">User:</label>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <select name="onchange_user_id" id="onchange_user_id" data-live-search="true" class="form-control select2 selectpicker fixed-width-select" required autofocus type="select"  value="1" style="position: absolute">
                        <option value="">Select</option>
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->username}}-{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6"></div>
            <div class="col-sm-2"><input type="button" class="btn btn-info" value="Add Permission" id="permission_btn_id"></div>
            <hr>
          </div>
        </form>  
        <div class="panel-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive table-condenced" style="font-size: 12px">
              <thead style="font-size: 12px">
                    <tr>
                        <th>SL#</th>
                        <th>User</th>
                        <th>Desk</th>
                        <th>Status</th>
                        <th>Controls</th>
                    </tr>  
              </thead>
              <tbody></tbody>
          </table>
        </div>
    </div>
  </div>
  <!-- Create Modal -->
  <div id="permissionModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->   
      <form enctype="multipart/form-data" id="SubmitFormId">
          {{ csrf_field() }}
          <div class="modal-content" style="padding: 20px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Production Floor Permission</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <div class="form-group{{ $errors->has('user_id') ? 'has-error' : '' }}">
                    <label for="user_id">User</label>
                    <select name="user_id" id="user_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                        <option value="">Select</option>
                        @foreach($users as $user)
                          <option value="{{$user->id}}">{{$user->username}}-{{$user->name}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user_id'))
                        <span class="help-block"><strong>{{ $errors->first('user_id') }}</strong></span>
                    @endif  
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-group{{ $errors->has('p_floor_id') ? 'has-error' : '' }}">
                    <label for="p_floor_id">P_Floor</label>
                    <select name="p_floor_ids[]"  multiple id="p_floor_ids">
                        @foreach($p_floors as $p_floor)
                          <option value="{{$p_floor->id}}">{{$p_floor->p_code}}-{{$p_floor->short_name}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('p_floor_id'))
                        <span class="help-block"><strong>{{ $errors->first('p_floor_id') }}</strong></span>
                    @endif  
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Upload</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
            </div>
          </div>
      </form>
    </div>
  </div> <!----End model----->
</div>
<script>document.title = 'Export | PFP';</script>
<script type="text/javascript">
    
  setTimeout(function() { 
      $('.sr-only').click();
  }, 0.0001);  

  $('#p_floor_ids').multiselect({
    columns: 1,
    search: true,
    selectAll: true
  });

  $(document).ready(function() {   
     
      
      //Item Add Form Submit
      $("#ci_item_id").change(function(){

            var text = $("#ci_item_id option:selected").text();
            var code = text.split(' - ');
            var res = text.replace(code[0]+' - ', "");
            $("#desk_item_name").val(res);
            var ci_item_id = document.getElementById('ci_item_id').value;
            $.ajax({
                type: "GET",
                url: "{{url('/get/item/gross/weight')}}?ci_item_id=" + ci_item_id,
                success: function (data) {
                    
                  $('#gross_weight').val(data['0'])
                  console.log(data);

                }

            });

       }); //@@--end

       //--Notify party item---
      $("#from_party_code").change(function(){

          var from_party_code = $("#from_party_code").val();
          $.ajax({
              type: "GET",
              url: "{{url('/json/get/notify/party/items_list')}}",
              data:{'party_code': from_party_code,"_token": $('input[name=_token]').val()},
              success: function (res) {
                  
                  var option='';
                  $.each(res.data, function (key, value) {
                    
                    option+='<option value="'+value.item_id+'">'+value.ci_item_code+'-'+value.ci_item_name+'</option>';

                  });
                
                  $('#ci_item_list').html(option);
                  $('#ci_item_list').multiselect({
                    columns: 1,
                    search: true,
                    selectAll: true
                  });
                  $('#ci_item_list').multiselect('reload');
                
              }

          });

        }); //@@--end

       //Item Add Form Submit
        $("#SubmitFormId").submit(function (e) {
           
            e.preventDefault(); 
            $.ajax({
              type:'POST',
              url: "{{ url('/pfp')}}",
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
                          title: res.message,
                          showConfirmButton: false,
                          timer: 1500
                      });
                      $('#user_id').val('').selectpicker('refresh');
                      $('#p_floor_id').val('').selectpicker('refresh');
                      $("#permissionModal").modal("hide");
                      
                  }else if(res.code==400){

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: res.message
                      });

                  }
                          
              },
              error: function(data){

                  console.log(data);
                  
              }
        
            });   


              
       }); //@@@end model

       //@@open permission modal
      $('#permission_btn_id').click(function(e){   
         
         e.preventDefault();
         $("#permissionModal").modal("show");
 
      });
      //@@@@@@Handle onchange event@@@@@@@@@@
      $("#onchange_user_id").change(function(){
          
          var user_id=$(this).val();
          showPFPUsers(user_id);
          
      });
      //@@@@@@Show party items@@@@@@@@@@
      function showPFPUsers(user_id){
            
          $(".preload").show();
          $('#example1').dataTable().fnDestroy(); 
          var table = $('#example1').DataTable({
                "ajax": {
                    "url": "/json/get/pfp/user_list",
                    "type": "GET",
                    "data": {
                        "user_id": user_id,
                        "_token": $('input[name=_token]').val()
                      },
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
                { "data": "pfloor"},
                { "data": "status"},
                { 
                    "data": null,
                    render: function(data, type, row) {

                        
                        if(row.status=='Inactive'){

                            return '<input type="button" data-id="'+row.id+'" class="btn btn-sm btn-success btn-sm active-inactive_btn_id" value="Active">'  

                        }else{
                           
                            return '<input type="button" data-id="'+row.id+'" class="btn btn-sm btn-danger active-inactive_btn_id" value="Inactive">'  
                            
                        }
                          
                      
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
          
      }//--End
      // Handle click delete button
      $('#example1 tbody').on('click', '.active-inactive_btn_id', function (e) {

          var delete_id=$(this).data('id');
          Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, make it!'
          }).then((result) => {

              if(result.isConfirmed) {
                
                $.ajax({
                    url: "{{url('/json/active_inactive/pfp')}}",
                    type: "get",
                    dataType: "json",
                    data: {'delete_id':$(this).data('id'),'_token': $('input[name=_token]').val()},
                    success: function(res) {

                        if(res.code==200){
                      
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Successfully Done..!!',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            var table1 = $('#example1').DataTable();
                            table1.ajax.reload();

                        }else if(res.code==500){
                      
                          Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                          });
                                                
                        }  
                  
                    }
              
                });

                  
              }

          });

      }); //--End
  
  });
</script>
@endsection