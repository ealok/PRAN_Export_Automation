@extends('layouts.master')
@section('content')
<style>
    .table-bordered > thead > tr > th{

        border-bottom-width: 1px;
    }
    .table-bordered > thead > tr > th{

        border: 1px solid #151313;
    }
    .table-bordered > thead > tr{

        border-top: 1px solid;
    }
    .table-bordered > tbody > tr > td{

        border: 1px solid #151313;
    }
    .table-bordered > tbody > tfoot> tr > td{

      border: 1px solid #151313;

    } 



    .preload {
        margin:0;
        position:absolute;
        top:86%;
        left:50%;
        margin-right: -50%;
        transform:translate(-50%, -50%);
    }
    img{
    
       height: 386px;

    }
    .btn {

        padding: 4px 12px;
    }
     
    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
        font-size: 9px;
    }
    .table > tbody > tr > td{

        padding: 2px;
        line-height: 1.2;
        vertical-align: top;
    }
    
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/jo/receive')}}"><i class="fa fa-dashboard"></i>DO Query</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-12">
          @if(Session::has('success')) 
          <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong>{{ Session::get('success') }}
          </div>
         @endif 
         @if(Session::has('danger'))
         <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Failed!</strong>{{ Session::get('success') }}
          </div>
         @endif
           <!-- Horizontal Form -->
           <div class="box box-info" style="border: 1px solid"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">DO Query</h3>
             </div><!-- /.box-header-end -->
             <div class="preload">
                <img src="{{asset('/img/loading_spinner.gif')}}"/>
             </div>   
             <form class="" role="form" method="POST" action="{{url('/notify_party/upload') }}" enctype="multipart/form-data">
                 {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body" style="min-height: 200px">    
                    <div class="row" style="border: 1px solid;margin-right: 0px;margin-left: 0px;">
                        <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('from_date') ? 'has-error' : '' }}">
                                <label for="name">From Date:</label>
                                <div class="form-group{{ $errors->has('from_date') ? 'has-error' : '' }}">
                                  <input name="from_date" type="text" id="from_date" class="form-control datepicker input-sm"  value="{{date("d-m-Y", strtotime($previous_date))}}"  placeholder="Select From Date">
                                </div>
                              </div> 
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">To Date:</label>
                                <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                                  <input name="to_date" type="text" id="to_date" class="form-control datepicker input-sm"  value="{{date("d-m-Y", strtotime($current_date))}}"  placeholder="Select To Date">
                                </div>
                            </div> 
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('pfloor_id') ? 'has-error' : '' }}">
                                <div class="form-group{{ $errors->has('pfloor_id') ? 'has-error' : '' }}">
                                    <label for="pfloor_id">Production Floor</label>
                                    <select name="pfloor_id" id="pfloor_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                                        <option value="">Select</option>
                                        @foreach($p_floors as $p_floor)
                                        <option value="{{$p_floor->id}}">{{$p_floor->p_code}}-{{$p_floor->p_name}}</option>
                                        @endforeach  
                                    </select>  
                                </div>
                                @if ($errors->has('pfloor_id'))
                                    <span class="help-block"><strong>{{ $errors->first('pfloor_id') }}</strong></span>
                                @endif  
                            </div> 
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('job_order_id') ? 'has-error' : '' }}">
                                <div class="form-group{{ $errors->has('job_order_id') ? 'has-error' : '' }}">
                                    <label for="job_order_id">SC Number</label>
                                    <select name="job_order_id" id="job_order_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                                      <option value="">Select</option>
                                       
                                    </select>  
                                </div>
                                @if ($errors->has('job_order_id'))
                                    <span class="help-block"><strong>{{ $errors->first('job_order_id') }}</strong></span>
                                @endif  
                            </div>
                        </div>
                        <div class="col-sm-12"> 
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                               <button type="button" class="btn btn-info btn-flat pull-right" style="margin-top: -4px;margin-bottom:8px;" id="check_button_id">Search</button>
                            </div>
                         </div> 
                    </div> 
                    <input id="myInput" type="text" placeholder="Search..">
                    <br>
                    <div class="table-responsive">
                     <table class="table table-bordered table-responsive table-condenced" id="tblMain">
                        <thead style="background: #a6cc54;">
                            <tr> 
                                <th>Party</th>
                                <th>Country</th>
                                <th>Order(PCS)</th>
                                <th>Order(CTN)</th>
                                <th>P_Floor</th>
                                <th>JO_NO</th>
                                <th>DO_NO</th>
                                <th>Mfg_Date</th>
                                <th>Delivery_Date</th>
                                <th>Created_Date</th>
                                <th>Created_BY</th>
                                <th>JO_Status</th>
                            </tr> 
                        </thead>
                        <tbody id="job_details">
                               
                        </tbody>
                    </table>
                    <div>
                  </div>  
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
    {{-- !-- Status Update Modal --> --}}
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 485px;margin: 30px auto;">
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
                          <div class="col-sm-4" style="margin-left: 145px;">
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
                                  <input type="hidden" class="form-control" id="po_master_id" name="po_master_id">
                                  <input type="hidden" class="form-control" id="jo_no" name="jo_no">
                              </div>
                            </div>
                            <br>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                              <button type="button" class="btn btn-danger pull-right" style="margin-left: 4px" data-dismiss="modal">No</button>
                              <button type="submit" class="btn btn-info pull-right" onclick="updateProductionStatus()">Submit</button>
                            </div>
                          </div>
                      </div>
                  </div>   
                </div> 
            </div>
          </div>
      </form>
    </div>
  </div>      
<script>document.title = 'Prod | DO_Query';</script>
<script>

    $(".preload").hide();
     
    $(document).ready(function(){ 

     $("#from_date,#pfloor_id").change(function() {

        var pfloor_id=$(this).val();
        var from_date=$('#from_date').val();
        var to_date=$('#to_date').val();
        var $el = $('#job_order_id');
        if(pfloor_id){

            $.ajax({
                method: 'GET',
                url: "/json/get/production_floor/job_order",
                data: {
                    'pfloor_id': pfloor_id,
                    'from_date':from_date,
                    'to_date':to_date,
                    '_token': $('input[name=_token]').val()
                },
                success: function (response) {

                    console.log(response);

                    if(!response.results){

                        $el.html('');
                        $el.append($("<option></option>").attr("value", "").text("---"));
                        $el.selectpicker('destroy');
                        $el.selectpicker('refresh');

                    }else{

                        $el.html(' ');
                        $el.append($("<option></option>").attr("value", "").text("Select"));
                        $.each(response.results, function(key,value) {
                            $el.append($("<option></option>").attr("value", value['sc_id']).text(value.invoice_no));
                        });
                        $el.selectpicker('refresh');
                    }
                   
                },
                error: function (e) {

                    console.log(e);

                }

            }); 

        }
        
     });

     $("#myInput").on("keyup", function() {

        var value = $(this).val().toLowerCase();
        $("#job_details tr").filter(function() {
       
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

        });

     });

        $("#check_button_id").click(function(){

            var sc_id = $('#job_order_id').val();
            if(sc_id==""){
                
                Swal.fire({ 

                   title: 'Alert!! <br> Please Select Sales Contact Number..!!',

                })
                            
            }else{

                var url = "{{url('/json/get/sc_wise/jo/details')}}?sc_id="+sc_id;

                $.get(url, function(data) {
                   
                    console.log(data);

                    if(data.results.length>0){
                        
                        var rows = '';
                        var i=1;
                        $.each(data.results, function (key, value) {
                            rows = rows + '<tr>';   
                            rows = rows + '<td>' + value.party + '</td>';
                            rows = rows + '<td>' + value.country + '</td>';
                            rows = rows + '<td>' + value.orqt_qty +'</td>';
                            rows = rows + '<td>' + value.orqt_qty_ctn +'</td>';
                            rows = rows + '<td>' + value.prod_floor +'</td>';
                            rows = rows + '<td>' + value.job_order_number + '</td>';
                            rows = rows + '<td>' + value.job_order_do_number + '</td>';
                            rows = rows + '<td style="display:none">' + value.sc_id + '</td>';
                            rows = rows + '<td>' + value.mfg_date + '</td>';
                            rows = rows + '<td>' + value.delivery_date + '</td>';
                            rows = rows + '<td>' + value.created_date + '</td>';
                            rows = rows + '<td>' + value.created_by +'</td>';
                            rows = rows + '<td>' + value.jo_status +'</td>'; 
                            rows = rows + '</tr>';
                        });
                        $("#job_details").html(rows);
                        $("#job_details").show();
                       

                    }else{
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Alert',
                            text: 'Production Done This JO..!!',
                            timer: 1500
                        })

                    }
                    
                
                });

            }  

        });    
        
        $(".delete-row").click(function(){
            $("table tbody").find('input[name="record"]').each(function(){
            	if($(this).is(":not(:checked)")){
                    $(this).parents("tr").remove();
                }
            });
        });

     });
</script>
<script>
    function showTaskUpdateModel(element){

        var rowJavascript = element.parentNode.parentNode;
        var rowjQuery = $(element).closest("tr");
        var jo_number=rowjQuery.find("td:eq(2)").text();
        var sc_id=rowjQuery.find("td:eq(3)").text();

        var url = "{{url('/json/get/sc/jo/task_list')}}?sc_id="+sc_id+"&jo_number="+jo_number;
        $.get(url, function(res) {

            if(res.error=="po_error"){

                Swal.fire({ 

                    title: 'Alert !! <br>Please First Assign PO..!!',

                });

                $("#myModal").modal("hide");
                return false;
            
            }else{

                loadUserTaskList(res.userTaskLists); 
                $('#po_master_id').val(res.po_master_id); 
                $('#jo_no').val(res.jo_no); 
                $("#myModal").modal("show");

            }  
                        
        
        });
        

    }

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

    function updateProductionStatus(){

        var jo_no=$('#jo_no').val();
        var po_master_id=$('#po_master_id').val();
        var task_id=$('#task_id').val();
        $.ajax({

            method: 'POST',
            url: "/json/save/jo_status",
            data: {'jo_no': jo_no, 'po_master_id':po_master_id,'task_id': task_id, '_token': $('input[name=_token]').val()},
            success: function (res) {
                            

                if(res.status=='success'){
            
                    Swal.fire({ 

                        title: 'Success !! <br>Task Status Upgraded Successfully..!!',

                    }); 

                }  
                
                $("#myModal").modal("hide");


            },
            error: function (e) {

                console.log(e);
            }

        });

    }

    function redirectURL(url){

        window.open(url, '_blank');
        return false;   

    }

</script>
<script>
    $(document).ready(function(){
        setTimeout(function() { 

            $('.sr-only').click();

        }, 0.0001);
    });
</script>
@endsection