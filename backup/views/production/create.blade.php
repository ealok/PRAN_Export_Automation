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
      <li class="active"><a href="{{url('/production/create')}}"><i class="fa fa-dashboard"></i>Production Entry</a></li>
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
               <h3 class="box-title">Production Entry</h3>
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
                                    <label for="job_order_id">SC/JO Number</label>
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
                     <input id="myInput" type="text" placeholder="Search.." style="border: 2px solid #558dbd;">
                     <table class="table table-bordered table-responsive table-condenced ">
                        <thead>
                            <tr> 
                                <th>Action</th>
                                <th>Item_Code</th>
                                <th>Item_Name</th>
                                <th>Order_Qty(CTN)</th>
                                <th>Prod_Qty(CTN)</th>
                                <th>Last_Entry_Data</th>
                                <th>Entered_Qty(CTN)</th>
                            </tr> 
                        </thead>
                        <tbody id="job_details">
                               
                        </tbody>
                        <tfoot id="hide_tfood_id">
                            <tr>
                               <td colspan="7" style="text-align: right">
                                    <button type="button" class=" btn btn-danger delete-row btn-xs">Delete</button>
                                    <button type="button" class=" btn btn-primary save_data  btn-xs">Save</button>
                               </td>
                            </tr>
                        </tfoot>
                    </table>
                  </div>  
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
<script>document.title = 'Prod Entry';</script>
<script>

     $(".preload").hide();
     $('#hide_tfood_id').hide();
     $(document).ready(function(){ 

     $("#pfloor_id").change(function() {

        var pfloor_id=$(this).val();
        var from_date=$('#from_date').val();
        var to_date=$('#to_date').val();
        var $el = $('#job_order_id');
        if(pfloor_id){

            $.ajax({
                method: 'GET',
                url: "/json/get/production_floor/sc_jo_list",
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
                            $el.append($("<option></option>").attr("value", value['id']).text(value.invoice_no+' / '+value.country+' / '+value.job_order_number));
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
    
     $(".save_data").click(function(){
           
            var prod_details = new Array(); 
            $(".preload").show();
            $(".table-bordered TBODY TR").each(function () {
                var row = $(this);
                var dist_info = {};
                dist_info.item_id = row.find("TD").eq(1).html();
                dist_info.order_qty = $(this).find("td:eq(4) input[type='text']").val();
                dist_info.prod_qty = row.find("TD").eq(5).html();
                dist_info.entered_qty = $(this).find("td:eq(7) input[type='text']").val();
                dist_info.prod_floor = $('#pfloor_id').val();
                prod_details.push(dist_info);
            }); 

            console.log(prod_details);

            if(prod_details.length>0){

                $.ajax({
                    method: 'POST',
                    url: "/store/prod/details",
                    data: {
                        'job_order_id': $('#job_order_id').val(), 
                        'prod_details': prod_details, 
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Information Save Successfully..!!',
                            timer: 1500
                        });
                        $(".preload").hide();
                        $('#hide_tfood_id').hide();
                        $('#job_details').hide();

                    },
                    error: function (e) {

                       console.log(e);

                    }

                });

            }
        
        }) 
        $("#check_button_id").click(function(){

            var job_order_id = $('#job_order_id').val();
            if(job_order_id==""){
                
                Swal.fire({ 

                   title: 'Alert!! <br> Please Select JO/SC Number..!!',

                })
                            
            }else{

                var url = "{{url('/json/get/jo_details')}}?job_order_id="+job_order_id;

                $.get(url, function(data) {
                    
                    if(data.results.length>0){
                        
                        var rows = '';
                        var i=1;
                        $.each(data.results, function (key, value) {

                            rows = rows + '<tr>';
                            rows = rows + '<td style="background: yellow">' + "<input type='checkbox' name='record'>"+'</td>';
                            rows = rows + '<td style="display:none">' + value.item_id + '</td>';
                            rows = rows + '<td>' + value.item_code + '</td>';
                            rows = rows + '<td>' + value.item_name + '</td>';
                            rows = rows + '<td>' + '<input type="text" value="'+value.order_qty+'" readonly>'+'</td>';
                            rows = rows + '<td>' + value.prod_qty + '</td>';
                            rows = rows + '<td>' + value.date + '</td>';
                            rows = rows + '<td contenteditable="true" style="background: yellow">' + '<input type="text" value="0">' + '</td>';
                            rows = rows + '</tr>';

                        });

                        $("#job_details").html(rows);
                        $("#job_details").show();
                        $('#hide_tfood_id').show();
                       

                    }else{
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Alert',
                            text: 'Production Done This JO..!!',
                            timer: 1500
                        })
                        $('#hide_tfood_id').hide();

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
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#job_details tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
</script> 
<script>
    $(document).ready(function(){
        setTimeout(function() { 

            $('.sr-only').click();

        }, 0.0001);
    });
</script>
@endsection