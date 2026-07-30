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
  margin-top: 235px;

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
      <li class="active"><a href="{{url('/cnf_list')}}"><i class="fa fa-dashboard"></i>CNF List</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12"> 
      <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px">
        <form class="form-inline">
          <div class="box-header with-border">
            <div class="col-sm-4">
                <label for="name">From Date :</label>
                <div class="form-group {{ $errors->has('from_date') ? 'has-error' : '' }}">
                  <input name="from_date" type="text" id="from_date" class="form-control datepicker"   value=""  max="191"  placeholder="Select From Date" required>
                </div>
            </div>
            <div class="col-sm-4" style="margin-left: -162px;">
              <label for="name">From Date :</label>
              <div class="form-group {{ $errors->has('to_date') ? 'has-error' : '' }}">
                <input name="to_date" type="text" id="to_date" class="form-control datepicker"   value=""  max="191"  placeholder="Select From Date" required>
              </div>
            </div>
            <div class="col-sm-1">
              <input type="button" class="btn btn-info btn-sm" value="Search" style="margin-left: -100px;padding: 4px 13px;" id="search_btn_id">
            </div>
            <hr>
          </div>
        </form> 
        <div class="panel-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive table-condenced" style="font-size: 12px">
              <thead style="font-size: 12px">
                    <tr>
                        <th>#Job_No</th>
                        <th>Inv</th>
                        <th>Inv_Value</th>
                        <th>S/B_NO</th>
                        <th>S/B_DT:</th>
                        <th>Rate(USD)</th>
                        <th>Examine_Dt</th>
                        <th>Doc.Send_date</th>
                        <th>Depot_Name</th>
                        <th>Doc_rvd_date</th>
                        <th>Action</th>
                    </tr>
              </thead>
              <tbody></tbody>
          </table>
        </div>
      </div>
  </div>
</div>
<!-- Edit Modal -->
<div id="editModal" class="modal fade">
  <div class="modal-dialog">
      <!-- Modal content-->   
      <form enctype="multipart/form-data" id="SubmitFormId">
          {{ csrf_field() }}
          <div class="modal-content" style="padding: 20px">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">CNF Update Form</h4>
          </div>
          <div class="modal-body">
            <div class="col-sm-6">
              <div class="form-group {{ $errors->has('job_no') ? 'has-error' : '' }}">
                  <label for="job_no">JOB No :</label>
                  <input name="job_no" type="text" id="job_no" class="form-control"   value=""   required autofocus   placeholder="job number" style="width: 200px">
                  @if ($errors->has('job_no'))
                      <span class="help-block"><strong>{{ $errors->first('job_no') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group {{ $errors->has('invoice_value') ? 'has-error' : '' }}">
                  <label for="invoice_value">Invoice Value :</label>
                  <input name="invoice_value" type="text" id="invoice_value" class="form-control"   value=""   required autofocus   placeholder="job number" style="width: 200px">
                  @if ($errors->has('job_no'))
                      <span class="help-block"><strong>{{ $errors->first('job_no') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group {{ $errors->has('sb_no') ? 'has-error' : '' }}">
                  <label for="sb_no">S/B No :</label>
                  <input name="sb_no" type="text" id="sb_no" class="form-control"   value=""   required autofocus   placeholder="Enter S/B No" style="width: 200px">
                  @if ($errors->has('sb_no'))
                      <span class="help-block"><strong>{{ $errors->first('sb_no') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group {{ $errors->has('sb_date') ? 'has-error' : '' }}">
                  <label for="sb_date">S/B No DT :</label>
                  <input name="sb_date" type="text" id="sb_date" class="form-control datepicker"   value=""   required autofocus   placeholder="Enter S/B Date"  style="width: 200px">
                  @if ($errors->has('sb_date'))
                      <span class="help-block"><strong>{{ $errors->first('sb_date') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group {{ $errors->has('assessable_rate') ? 'has-error' : '' }}">
                  <label for="assessable_rate">ASSESSABLE RATE(USD) :</label>
                  <input name="assessable_rate" type="text" id="assessable_rate" class="form-control"   value=""   required autofocus   placeholder="Enter assessable rate(USD)"  style="width: 200px">
                  @if ($errors->has('assessable_rate'))
                      <span class="help-block"><strong>{{ $errors->first('assessable_rate') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group {{ $errors->has('examine_date') ? 'has-error' : '' }}">
                  <label for="examine_date">EXAMINE DT :</label>
                  <input name="examine_date" type="text" id="examine_date" class="form-control datepicker"   value=""   required autofocus   placeholder="Enter axamine date"  style="width: 200px">
                  @if ($errors->has('examine_date'))
                      <span class="help-block"><strong>{{ $errors->first('examine_date') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group {{ $errors->has('doc_send_date') ? 'has-error' : '' }}">
                  <label for="doc_send_date">DOC.SEND  DT :</label>
                  <input name="doc_send_date" type="text" id="doc_send_date" class="form-control datepicker"   value=""   required autofocus   placeholder="Enter doc send date"  style="width: 200px">
                  @if ($errors->has('doc_send_date'))
                      <span class="help-block"><strong>{{ $errors->first('doc_send_date') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group{{ $errors->has('depot_id') ? 'has-error' : '' }}">
                    <label for="depot_id">DEPOT NAME<span class="req_style_id">(*)</span></label>
                    <select name="depot_id" id="depot_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                       
                    </select>
                    @if ($errors->has('depot_id'))
                        <span class="help-block"><strong>{{ $errors->first('depot_id') }}</strong></span>
                    @endif  
                </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group {{ $errors->has('doc_rvd_date') ? 'has-error' : '' }}">
                  <label for="doc_rvd_date">DOC RVD DT :</label>
                  <input name="doc_rvd_date" type="text" id="doc_rvd_date" class="form-control datepicker"   value=""   required autofocus   placeholder="Enter doc rvd date"  style="width: 200px">
                  @if ($errors->has('doc_rvd_date'))
                      <span class="help-block"><strong>{{ $errors->first('doc_rvd_date') }}</strong></span>
                  @endif
              </div>
            </div>
            <input type="hidden" name="edit_id" id="edit_id" value="">
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-info">Update</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
          </div>
        </div>
      </form>
  </div>
</div>
<script>document.title = 'Export | CNF List';</script>
<script type="text/javascript">
  $('#trading_details_div_id').hide();
   $(document).ready(function() {

        setTimeout(function() { 

          $('.sr-only').click();

        }, 0.0001);

        $("#search_btn_id").click(function(){
            
           var from_date=$('#from_date').val();
           var to_date=$('#to_date').val();
           if(from_date==""){
             
                Swal.fire({
                    icon: 'warning',
                    text: 'From date Connot empty..!!'
                });

           }else if(to_date==""){

                Swal.fire({
                    icon: 'warning',
                    text: 'To date Connot empty..!!'
                });

           }else{
             
                displayCnfList(from_date,to_date);

           }
           
           
        }); 

        function displayCnfList(from_date, to_date){
           
          $(".preload").show();
          $('#example1').dataTable().fnDestroy(); 
          var table = $('#example1').DataTable({
                "ajax": {
                    "url": "/json/get/cnf_list",
                    "type": "GET",
                    "data": {
                       "from_date": from_date,
                       "to_date": to_date,
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
                { "data": "job_no" },
                { "data": "invoice_no" },
                { "data": "invoice_value" },
                { "data": "sb_no" },
                { "data": "sb_date" },
                { "data": "assessable_rate" },
                { "data": "examine_date" },
                { "data": "doc_send_date" },
                { "data": "depot_name" },
                { "data": "doc_rvd_date" },
                { 
                    "data": null,
                    render: function(data, type, row) {

                        return '<input type="button" data-id="'+row.id+'" class="btn btn-primary btn-sm edit-cnf" value="Edit">' 
                      
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
          
        }
  
        // Handle click Approve button
        $('#example1 tbody').on('click', '.edit-cnf', function (e) {

          var edit_id=$(this).data('id');
          if(edit_id){

              var url = "{{url('/')}}"+"/json/get/cnf/edit_details?edit_id="+edit_id;
              $.get(url,function(data) {

                  $('#editModal #sb_no').val(data.result.sb_no);
                  $('#editModal #job_no').val(data.result.job_no);
                  $('#editModal #invoice_value').val(data.result.invoice_value);
                  $('#editModal #sb_date').val(data.result.sb_date);
                  $('#editModal #assessable_rate').val(data.result.assessable_rate);
                  $('#editModal #examine_date').val(data.result.examine_date);
                  $('#editModal #doc_send_date').val(data.result.doc_send_date);
                  loadDepots(data.result.depot_id,data.depots);
                  $('#editModal #doc_rvd_date').val(data.result.doc_rvd_date);
                  $('#editModal #edit_id').val(edit_id);
                  $('#editModal').modal('show');

              }); 

          }

        });

        function loadDepots(depo_id,depots){

            if(depots){
                var $el = $('#depot_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(depots, function (key, value) {
                   
                   $('select[name="depot_id"]').append(`<option value="${value.id}" ${value.id == depo_id ? 'selected' : ''}>${value.name}</option>`)

                });
                $el.selectpicker('refresh');
            }else{
                var $el = $('#depot_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $el.selectpicker('refresh'); 
            }
        }

        $('#SubmitFormId').on('submit',function(e){


            e.preventDefault(); 
            $.ajax({
                type:'POST',
                url: "/cnf_update",
                data: new FormData(this),
                cache:false,
                contentType: false,
                processData: false,
                success: (res) => {

                    if(res.code==200){
                    
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $("#editModal").modal("hide");
                        var table2 = $('#example1').DataTable();
                        table2.ajax.reload();                        

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


        });

     });
</script>
@endsection