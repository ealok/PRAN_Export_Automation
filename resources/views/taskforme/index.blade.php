@extends('layouts.master')
@section('content') 
<style>
.form-control {

  border-radius: 0;
  box-shadow: none;
  border-color: #0d18b9;

 }

table.dataTable thead th{

   padding: 0px 0px;

}
 .form-group {

   margin-bottom: 0px;

 }


 .form-control[disabled]{

  background-color: #288a37;
  
 }

 #party{

    position: absolute;
    left: -346px;
    top: 1px;
 }
 .select2{

    position: absolute;
    left: -248px;
    top: -5px;
 }
 .form-group .bootstrap-select.btn-group, .form-horizontal .bootstrap-select.btn-group{
    margin-bottom: 0;
    position: relative;
    left: -2px;
 }
.btn-default {

  background-color: #FFFFFF;

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

.table > thead:first-child > tr:first-child > th {

  border: 1px solid #222;

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

  width: 600px;

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
#img_toggle_id{

  height: 40px;
  position: absolute;
  top: -3px;
  left: 845px;

}
.box-header.with-border {

  border-bottom: none;

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
      <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px">
        <div class="preload">
            <img src="{{asset('/img/loading_spinner.gif')}}"/ alt="no image">
        </div>  
        <div class="panel-body table-responsive">
            <table id="example1" class="table table-bordered table-responsive table-condenced" style="font-size: 12px;width: 100%">
                <thead>
                    <tr>
                        <th>SL#</th>
                        <th>SC_Number</th>
                        <th>Invoice_NO</th>
                        <th>Date</th>
                        <th>PO_Number</th>
                        <th>User</th>
                        <th>Action</th>
                    </tr>  
                </thead>
                <tbody>
                        
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
{{-- !-- Status Update Modal --> --}}
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
    <form class="form-horizontal" method="POST" id="update_task_status_form_id" action="javascript:void(0)" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Update Status</h4>
          </div>
          <div class="modal-body">
              <div class="box-body">
                <div class="row">
                    <div class="col-sm-12"> 
                      <div class="form-group {{ $errors->has('task_id') ? 'has-error' : '' }}">
                        <label for="name">Task:</label>
                        <div class="form-group{{ $errors->has('task_id') ? 'has-error' : '' }}">
                          <select name="task_id" id="task_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" required>
                            
                          </select> 
                        </div>
                      </div>
                        <div class="preload">
                          <img src="{{asset('/img/loading_spinner.gif')}}"/>
                        </div>
                      <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Remarks:</label>
                        <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                            <textarea class="form-control" id="remark" name="remark"></textarea>
                            <input type="hidden" class="form-control" id="po_master_id" name="po_master_id"></textarea>
                        </div>
                      </div>
                      <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">File:</label>
                        <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                            <input type="file" name="file"  id="file" class="form-control input-sm"  value=""  placeholder="">
                        </div>
                      </div>
                      <br>
                      <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <button type="button" class="btn btn-danger pull-right" style="margin-left: 4px" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-info pull-right" data_>Submit</button>
                      </div>
                    </div>
                </div>   
              </div> 
          </div>
        </div>
    </form>
  </div>
</div>
<script>document.title = 'Export | Pending JO List';</script>
<script type="text/javascript">

   $('#po_details_div_id').hide();
   $(".preload").hide();
   $(document).ready(function() {

        setTimeout(function() {

          $('.sr-only').click();

        }, 0.0001);  

        $('#example1').dataTable().fnDestroy(); 
        var table=$('#example1').DataTable({
            dom: 'Bfrtip', 
            buttons: [
                'csv', 'excel'
            ],
            "ajax": {
                "url": "/get/task_list",
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
                  { "data": null}, 
                  { "data": "sc_no"},
                  { "data": "invoice_no"},
                  { "data": "create_date"},
                  { "data": "po_number"},
                  { "data": "name"},
                  { 
                      "data": null,
                      render: function(data, type, row){

                          return '<input type="button" data-id="'+row.id+'" class="btn btn-danger btn-sm btn-update" value="Update">' 
                      
                      }
                  }
            ],
            "createdRow": function( row, data, dataIndex ) {

                $('td', row).eq(0).html(dataIndex + 1);

            },
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

        $('#example1 tbody').on('click', '.btn-update', function (e) {
              
            var id = $(this).data("id");
            $(".preload").show();
            if(id){

                  $.ajax({
                        method: 'GET',
                        url: "/json/get/upgrade/mytask/details",
                        data: {
                          'id': id,
                          '_token': $('input[name=_token]').val()
                        },
                        success: function (res) {

                          console.log(res);
                          if(res.error=="po_error"){

                              Swal.fire({ 

                                  title: 'Alert !! <br>Please First Assign PO..!!',

                              });

                              $("#myModal").modal("hide");
                              return false;
                              $(".preload").show();
                            
                          }else{

                              $("#po_master_id").val(res.po_master_id);
                              loadUserTaskList(res.userTaskLists);       
                              $(".preload").hide();


                          }            
                            
                        },
                        error: function (e) {

                            console.log(e);

                        }

                  });

                  function loadUserTaskList(data){
                    
                      if(data){

                          var $el = $('#task_id');
                          $el.html(' ');
                          $el.append($("<option></option>").attr("value", "").text("Select"));
                          $.each(data, function (key, value) {
                              
                            $('select[name="task_id"]').append(`<option value="${value.id}">${value.task_name}</option>`)

                          });
                          $el.selectpicker('refresh');


                      }else{

                          var $el = $('#task_id');
                          $el.html(' ');
                          $el.append($("<option></option>").attr("value", "").text("Select"));
                          $el.selectpicker('refresh'); 

                      }

                  }   

            }             

            $("#myModal").modal("show");

        });

        $.ajaxSetup({
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $('#update_task_status_form_id').submit(function(e) {
          
            e.preventDefault();
            $(".preload").show(); 
            var formData = new FormData(this);
            
            $.ajax({
                type:'POST',
                url: "{{ url('/mytask')}}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: (res) => {
                    
                    this.reset();
                    $(".preload").hide(); 
                    $("#myModal").modal("hide");   
                    if(res.status=='success'){
                      
                      Swal.fire({ 

                          title: 'Success !! <br>Task Status Upgraded Successfully..!!',

                      }); 

                    }          

                },
                error: function(data){

                  console.log(data);
                  
                }
            });

        });

    });
</script>
@endsection