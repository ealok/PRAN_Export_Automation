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
    <h1>Costing Others Head<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/costing_others_hd')}}"><i class="fa fa-dashboard"></i>Others Head</a></li>
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
                    <th>Head</th>
                    <th>Charge</th>
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
          <h4 class="modal-title">Add New Head</h4>
        </div>
        <div class="modal-body" style="height: 100px;">
          <div class="col-sm-5">
            <div class="form-group {{ $errors->has('cost_head') ? 'has-error' : '' }}">
                <label for="cost_head">Head</label>
                <input type="text" name="cost_head" id="cost_head" class="form-control input-sm"  placeholder="Enter C&F Charge/CTN" value="" step="any" required>
                @if ($errors->has('cost_head'))
                    <span class="help-block"><strong>{{ $errors->first('cost_head') }}</strong></span>
                @endif
            </div>
          </div>
          <div class="col-sm-offset-1 col-sm-5">
            <div class="form-group {{ $errors->has('charge') ? 'has-error' : '' }}">
                <label for="charge">Charge</label>
                <input type="number" name="charge" id="charge" class="form-control input-sm"  placeholder="Enter Doc/Bank/Stamp Chg" value="" step="any" required>
                @if ($errors->has('charge'))
                    <span class="help-block"><strong>{{ $errors->first('charge') }}</strong></span>
                @endif
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
          <h4 class="modal-title">Update Carrying Charge</h4>
        </div>
        <div class="modal-body" style="height: 100px;">
          <div class="col-sm-5">
            <div class="form-group {{ $errors->has('cost_head') ? 'has-error' : '' }}">
                <label for="cost_head">Head</label>
                <input type="text" name="ecost_head" id="ecost_head" class="form-control input-sm"  placeholder="Enter C&F Charge/CTN" value="" step="any" required>
                @if ($errors->has('cost_head'))
                    <span class="help-block"><strong>{{ $errors->first('cost_head') }}</strong></span>
                @endif
            </div>
          </div>
          <div class="col-sm-offset-1 col-sm-6">
            <div class="form-group {{ $errors->has('carring_charge') ? 'has-error' : '' }}">
                <label for="carring_charge">Carrying Charge</label>
                <input type="number" name="ecarring_charge" id="ecarring_charge" class="form-control input-sm"  placeholder="Enter Carrying Charge" value="" step="any" required>
                @if ($errors->has('carring_charge'))
                    <span class="help-block"><strong>{{ $errors->first('carring_charge') }}</strong></span>
                @endif
            </div>
          </div>
          <input type="hidden" id="editId" value="" name="editId">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info btn-sm">Update</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>document.title = 'Costing Others | Head';</script>
<script type="text/javascript">
   
    setTimeout(function() { 
          $('.sr-only').click();
    }, 0.0001);

    $(document).ready(function(){
         
      function getListOfCVR(){
            
          $('#example1').dataTable().fnDestroy(); 
          var table=$('#example1').DataTable({
            "ajax": {
                "url": "/get/costing/others/hd",
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
                  { "data": "cost_head"},
                  { "data": "charge"},
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
              url: "{{ url('/costing_others_hd')}}",
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


                  }else if(res.status=="warning"){

                      
                      Swal.fire({
                          icon: 'warning',
                          title: 'Oops...',
                          text: 'Already Exists'
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
          url: '/json/get/costing/other_hd',
          method: 'GET',
          data: { id: $(this).data('id')},
          success: function(res) {
            
              $('#editId').val(res.data[0].id);
              $('#ecost_head').val(res.data[0].cost_head);
              $('#ecarring_charge').val(res.data[0].charge);
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
            url: "{{ url('/update/costing/other_hd')}}",
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