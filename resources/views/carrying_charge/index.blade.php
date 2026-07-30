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
    <h1>Carrying Charge<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/carrying_chg')}}"><i class="fa fa-dashboard"></i>Carring_Charge</a></li>
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
                    <th>Location</th>
                    <th>CTR_Size</th>
                    <th>CTR_Category</th>
                    <th>Carrying_Charge</th>
                    <th>Depot_expense</th>
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
        <div class="modal-body" style="height: 225px;">
          <div class="col-sm-5">
            <div class="form-group {{ $errors->has('location_id') ? 'has-error' : '' }}">
                <label for="party_name">Location</label>
                <select name="location_id" id="location_id" data-live-search="true" class="form-control select2 selectpicker input-xs" required  type="select"  value="1" >
                  <option value="">Select</option>
                  @foreach($locations as $location)
                  <option value="{{$location->id}}">{{$location->name}}</option>
                  @endforeach
                </select>
            </div>
          </div>
          <div class="col-sm-offset-1 col-sm-6">
            <div class="form-group {{ $errors->has('ctr_size_id') ? 'has-error' : '' }}">
              <label for="ctr_size_id">CTR Size</label>
              <select name="ctr_size_id" id="ctr_size_id" data-live-search="true" class="form-control select2 selectpicker input-xs" required  type="select"  value="1" >
                <option value="">Select</option>
                @foreach($container_sizes as $container_size)
                <option value="{{$container_size->id}}">{{$container_size->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-group {{ $errors->has('ctr_cat_id') ? 'has-error' : '' }}">
              <label for="ctr_cat_id">CTR Category</label>
              <select name="ctr_cat_id" id="ctr_cat_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                <option value="">Select</option>
                @foreach($container_cats as $container_cat)
                <option value="{{$container_cat->id}}">{{$container_cat->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-sm-offset-1 col-sm-6">
            <div class="form-group {{ $errors->has('carring_charge') ? 'has-error' : '' }}">
                <label for="carring_charge">Carrying Charge</label>
                <input type="number" name="carring_charge" id="carring_charge" class="form-control input-sm"  placeholder="Enter Carrying Charge" value="" step="any" required>
                @if ($errors->has('carring_charge'))
                    <span class="help-block"><strong>{{ $errors->first('carring_charge') }}</strong></span>
                @endif
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-group {{ $errors->has('depot_expense') ? 'has-error' : '' }}">
                <label for="depot_expense">Depot Charge</label>
                <input type="number" name="depot_expense" id="depot_expense" class="form-control input-sm"  placeholder="Enter Depot Charge" value="" step="any" required>
                @if ($errors->has('depot_expense'))
                    <span class="help-block"><strong>{{ $errors->first('depot_expense') }}</strong></span>
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
        <div class="modal-body" style="height: 225px;">
          <div class="col-sm-5">
            <div class="form-group {{ $errors->has('location_id') ? 'has-error' : '' }}">
                <label for="party_name">Location</label>
                <select name="elocation_id" id="elocation_id" data-live-search="true" class="form-control select2 selectpicker input-xs" required  type="select"  value="1" >
                  <option value="">Select</option>
                  @foreach($locations as $location)
                  <option value="{{$location->id}}">{{$location->name}}</option>
                  @endforeach
                </select>
            </div>
          </div>
          <div class="col-sm-offset-1 col-sm-6">
            <div class="form-group {{ $errors->has('ctr_size_id') ? 'has-error' : '' }}">
              <label for="ctr_size_id">CTR Size</label>
              <select name="ectr_size_id" id="ectr_size_id" data-live-search="true" class="form-control select2 selectpicker input-xs" required  type="select"  value="1" >
                <option value="">Select</option>
                @foreach($container_sizes as $container_size)
                <option value="{{$container_size->id}}">{{$container_size->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-group {{ $errors->has('ctr_cat_id') ? 'has-error' : '' }}">
              <label for="ctr_cat_id">CTR Category</label>
              <select name="ectr_cat_id" id="ectr_cat_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" >
                <option value="">Select</option>
                @foreach($container_cats as $container_cat)
                <option value="{{$container_cat->id}}">{{$container_cat->name}}</option>
                @endforeach
              </select>
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
          <div class="col-sm-5">
            <div class="form-group {{ $errors->has('depot_expense') ? 'has-error' : '' }}">
                <label for="depot_expense">Depot Charge</label>
                <input type="number" name="edepot_expense" id="edepot_expense" class="form-control input-sm"  placeholder="Enter Depot Charge" value="" step="any" required>
                @if ($errors->has('depot_expense'))
                    <span class="help-block"><strong>{{ $errors->first('depot_expense') }}</strong></span>
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

<script>document.title = 'Carring Charge';</script>
<script type="text/javascript">
   
    setTimeout(function() { 
          $('.sr-only').click();
    }, 0.0001);

    $(document).ready(function(){
         
      function getListOfCVR(){
            
          $('#example1').dataTable().fnDestroy(); 
          var table=$('#example1').DataTable({
            "ajax": {
                "url": "/jsonGetListOfCarryingChg",
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
                  { "data": "location"},
                  { "data": "ctr_size"},
                  { "data": "ctr_name"},
                  { "data": "carring_chg"},
                  { "data": "depot_expense"},
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
              url: "{{ url('/carrying_chg')}}",
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
                          text: 'Already Exists This Charge'
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
          url: '/json/get/carrying_chg/edit_data',
          method: 'GET',
          data: { id: $(this).data('id')},
          success: function(res) {

              $.each(res.locations, function (key, value) {
                
                $('select[name="elocation_id"]').append(`<option value="${value.id}" ${value.id == res.data[0].location_id ? 'selected' : ''}>${value.name}</option>`)
              
              });
              $('select[name="elocation_id"]').trigger('change');

              
              $.each(res.container_sizes, function(key, value) {
                
                $('select[name="ectr_size_id"]').append(`<option value="${value.id}" ${value.id == res.data[0].ctr_size_id ? 'selected' : ''}>${value.name}</option>`)
                  
              });

              $('select[name="ectr_size_id"]').trigger('change');

              $.each(res.container_cats, function(key, value) {
                
                $('select[name="ectr_cat_id"]').append(`<option value="${value.id}" ${value.id == res.data[0].ctr_cat_id ? 'selected' : ''}>${value.name}</option>`)
                  
              });

              $('select[name="ectr_cat_id"]').trigger('change');
              $('#editId').val(res.data[0].id);
              $('#ecarring_charge').val(res.data[0].carring_charge);
              $('#edepot_expense').val(res.data[0].depot_expense);
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
            url: "{{ url('/update/carrying_chg')}}",
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