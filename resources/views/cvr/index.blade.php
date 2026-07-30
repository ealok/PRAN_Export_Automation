@extends('layouts.master')
@section('content') 
<style>
  .table > thead:first-child > tr:first-child > th {
  
     border: 1px solid #222;

  }
  .modal-header {
    border-bottom-color: #eee8e8;
  }
  .modal-footer {
    border-top-color: #eee8e8;
  }
  .panel-body{
    padding: 7px;
    margin-top: -11px;
  }
  .table-bordered > tbody > tr > td{

    border: 1px solid #222;

  }
  table.dataTable thead th{
    padding: 3px 0px;
    font-size: 11px;
  }

  .table > tbody > tr > td{
  
    padding: 1px;
    line-height: 1.42857143;
    vertical-align: top;
    font-size: 9px

  }
  .table-bordered > tbody > tr > td{
    
    border: 1px solid #201f1f;
    padding: 1px;
    font-weight: bold;
  
  }

  .table-bordered > tbody > tr:hover{
  
    background-color: rgba(101, 212, 97, 0.836);
  }
  
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1>CVR<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/cvr')}}"><i class="fa fa-dashboard"></i>CVR</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
            <button class="btn btn-xs btn-success pull-right btn-flat" id="add_new">+ Add New</button>
        </div>
        <div class="panel-body table-responsive">
          <table class="table table-bordered table-responsive table-condenced" id='example1'>
              <thead>
                 <tr>
                    <th>#Sl</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>CVR</th>
                    <th>Status</th>
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
<!-- Create Modal-->
<div id="createModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
    <form class="form-horizontal" id="create_form">
      {{csrf_field()}}
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New CVR</h4>
        </div>
        <div class="modal-body" style="height: 155px;">
          <div class="col-sm-5">
            <div class="form-group {{ $errors->has('party_name') ? 'has-error' : '' }}">
                <label for="party_name">From Date</label>
                <input  type="text" name="form_date" id="form_date" class="form-control input-sm datepicker"  placeholder="Enter Form Date" value="">
                @if ($errors->has('party_name'))
                    <span class="help-block"><strong>{{ $errors->first('party_name') }}</strong></span>
                @endif
            </div>
          </div>
          <div class="col-sm-offset-1 col-sm-6">
            <div class="form-group {{ $errors->has('party_name') ? 'has-error' : '' }}">
                <label for="party_name">To Date</label>
                <input  type="text" name="to_date" class="form-control input-sm datepicker"  placeholder="Enter To Date" value="">
                @if ($errors->has('party_name'))
                    <span class="help-block"><strong>{{ $errors->first('party_name') }}</strong></span>
                @endif
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-group {{ $errors->has('party_name') ? 'has-error' : '' }}">
                <label for="party_name">CVR</label>
                <input type="number" name="conversion_rate" id="conversion_rate" class="form-control input-sm"  placeholder="Enter Conversion Rate" value="" step="any">
                @if ($errors->has('party_name'))
                    <span class="help-block"><strong>{{ $errors->first('party_name') }}</strong></span>
                @endif
            </div>
          </div>
          <div class="col-sm-5" style="margin-left: 46px;margin-top: 7px;">
              <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                  <label for="is_revised" >Status</label><br>
                  <label class="radio-inline">
                      <input type="radio" name="status"  value="N">Active
                  </label>
                  <label class="radio-inline">
                      <input type="radio" name="status"  value="Y">Inactive
                  </label>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info btn-sm">Add New</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
    <form class="form-horizontal" id="update_form">
      {{ csrf_field() }}
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update CVR</h4>
        </div>
        <div class="modal-body" style="height: 155px;">
          <div class="col-sm-5">
            <div class="form-group {{ $errors->has('party_name') ? 'has-error' : '' }}">
                <label for="party_name">From Date</label>
                <input name="from_date" type="text" id="from_date" class="form-control input-sm datepicker"  placeholder="Enter Form Date" value="">
                @if ($errors->has('party_name'))
                    <span class="help-block"><strong>{{ $errors->first('party_name') }}</strong></span>
                @endif
            </div>
          </div>
          <div class="col-sm-offset-1 col-sm-6">
            <div class="form-group {{ $errors->has('party_name') ? 'has-error' : '' }}">
                <label for="party_name">To Date</label>
                <input name="to_date" type="text" id="to_date" class="form-control input-sm datepicker"  placeholder="Enter To Date" value="">
                @if ($errors->has('party_name'))
                    <span class="help-block"><strong>{{ $errors->first('party_name') }}</strong></span>
                @endif
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-group {{ $errors->has('party_name') ? 'has-error' : '' }}">
                <label for="party_name">CVR</label>
                <input name="cvr_rate" type="number" id="cvr_rate" class="form-control input-sm"  placeholder="Enter Conversion Rate" value="" step="any">
                @if ($errors->has('party_name'))
                    <span class="help-block"><strong>{{ $errors->first('party_name') }}</strong></span>
                @endif
            </div>
          </div>
          <div class="col-sm-5" style="margin-left: 46px;margin-top: 7px;">
              <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                  <label for="is_revised" >Status</label><br>
                  <label class="radio-inline">
                      <input type="radio" name="status"  value="N"   id="active">Active
                  </label>
                  <label class="radio-inline">
                      <input type="radio" name="status"  value="Y"   id="inactive">Inactive
                  </label>
              </div>
              <input type="hidden" id='editId' name="editId" value="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info btn-sm">Update</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>document.title = 'CVR';</script>
<script type="text/javascript">
   
    setTimeout(function() { 
          $('.sr-only').click();
    }, 0.0001);

    $(document).ready(function(){
         
      function getListOfCVR(){
            
          $('#example1').dataTable().fnDestroy(); 
          var table=$('#example1').DataTable({
            "ajax": {
                "url": "/jsonGetListOfCvr",
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
                  { "data": "id"},
                  { "data": "from_date"},
                  { "data": "to_date"},
                  { "data": "cvr_rate"},
                  { "data": "status" },
                  { 
                      "data": null,
                      render: function(data, type, row){

                          return '<input type="button" data-id="'+row.id+'" class="btn btn-info btn-xs btn-edit" value="Edit">' 
                      
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
      getListOfCVR();

      $('#add_new').click(function(){
           
        $('#createModal').modal('show');
 
      });

      //@@@---Create Modal Submit----------
      $("#create_form").submit(function (e) {

          e.preventDefault(); 
          $.ajax({
              type:'POST',
              url: "{{ url('/cvr')}}",
              data: new FormData(this),
              cache:false,
              contentType: false,
              processData: false,
              success: (res) => {
                  
                  if(res.status=="success"){
                  
                      Swal.fire({
                          position: 'top-end',
                          icon: 'success',
                          title: 'Create Successfully Done..!!',
                          showConfirmButton: false,
                          timer: 1500
                      });

                      $(this).trigger('reset');
                      var table2 = $('#example1').DataTable();
                      table2.ajax.reload();
                      $('#createModal').modal('hide');


                  }else if(res.status=="error"){

                      
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong!'
                      })

                      $(this).trigger('reset');

                  }
                      
              },
              error: function(data){

                  console.log(data);
                  
              }
          });

      }); //@@end 

      //@@@---Load Edit Modal Submit----------
      $('#example1').on('click', '.btn-edit', function(event) {

        // var id = $(this).data('id');
        // table.ajax.reload(null, false);
        // table.draw(false);
        event.preventDefault();
        $.ajax({
          url: '/json/get/cvr/edit_data',
          method: 'GET',
          data: { id: $(this).data('id')},
          success: function(response) {
               
              console.log(response);
              $('#editId').val(response.data[0].id);
              $('#from_date').val(response.data[0].from_date);
              $('#to_date').val(response.data[0].to_date);
              $('#cvr_rate').val(response.data[0].cvr_rate);
              response.data[0].status=='N' ?  $('#active').prop('checked', true) : $('#inactive').prop('checked', true);
              $('#editModal').modal('show'); 
          
          },
          error: function(xhr, status, error) {

              console.error('Failed to fetch data:', error);
            
          }
        });

      }); //@@end
        
      //@@@---Update Modal Submit----------
      $("#update_form").submit(function (e) {

        e.preventDefault(); 
        $.ajax({
            type:'POST',
            url: "{{ url('/update/cvr')}}",
            data: new FormData(this),
            cache:false,
            contentType: false,
            processData: false,
            success: (res) => {
                
                if(res.status=="success"){
                
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Updated Successfully Done..!!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    var table2 = $('#example1').DataTable();
                    table2.ajax.reload(null, false);
                    table2.draw(false); 
                    $('#editModal').modal('hide');


                }else {

                    
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

      }); //@@end 
    
   });
</script>
@endsection