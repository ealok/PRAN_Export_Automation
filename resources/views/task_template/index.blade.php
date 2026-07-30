@extends('layouts.master')
@section('content') 
<style>
  .form-control {
  
    border-radius: 0;
    box-shadow: none;
    border-color: #0d18b9;
  
   }
   .form-group {
  
     margin-bottom: 0px;
  
   }
   #left_side_style{
  
      border: 2px solid blue;
      min-height: 440px;  
   }
  
   #right_side_style{
   
    border: 2px solid blue;
    min-height: 439px;
    margin-left: 5px;  
  
  }
  .bootstrap-select > .dropdown-toggle.bs-placeholder{
  
    color: #222;
    border: 1px solid blue;
  
  }
  .btn-default {
  
  background-color: #FFFFFF;
  
  }
  
  .bootstrap-select > .dropdown-toggle.bs-placeholder,.bootstrap-select > .dropdown-toggle.bs-placeholder:hover {
  
    color: #222;
    border: 1px solid blue;
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
  #po_details_style{
  
    position: absolute;
    top: -15px;
    border: 2px solid blue;
    background: #FFF;
    width: 167px;
    text-align: center;
    font-weight: bold;
    padding: 3px;
    font-style: oblique;
  
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
  
  }
  
  .table-bordered > tbody > tr > td{
  
   border: 1px solid #222;
  
  }
  
  .table > tbody > tr > td{
   
    padding: 1px;
    line-height: 1.42857143;
    vertical-align: top;
  
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
  
  .table-bordered > tbody > tr > td{
    
    border: 1px solid #201f1f;
    padding: 1px;
    font-weight: bold;
  
  }
  .table-bordered > tbody > tr:hover{
  
    background-color: rgba(101, 212, 97, 0.836);
  }
  
  .form-horizontal .form-group {
  
    margin-right: 0px;
    margin-left: 0px;
  
  }
  .modal-content{
  
    width: 900px;
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

  .form-control{

    font-weight: bold;
    color: #222;
  }
  
  </style>
<section class="content-header" style="padding-top: 0px;">
    <h1>Template List<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/template')}}"><i class="fa fa-dashboard"></i>Template List</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">Create Template<a href="{{url('/template/create')}}">
            <button class="btn btn-xs btn-success pull-right btn-flat">Create Template</button></a>
        </div>
        @if(Session::has('danger'))
          <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong>Success !</strong>{{Session::get('danger')}}
          </div>
        @endif 
        <div class="panel-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive table-condenced ">
              <thead>
                  <th>#SL</th>
                  <th>Name</th>
                  <th>Template_Type</th>
                  <th>Controls</th>
              </thead>
              <tbody>
                  <?php $i=1; ?>
                  @foreach($results as $result)
                  <tr>
                      <td>{{$i++}}</td>
                      <td>{{$result->des}}</td>
                      <td>{{$result->name}}</td>
                      <td>
                        <button type="button" class="btn btn-xs btn-success btn-flat" id="openShowModal" data-id='{{$result->id}}'>View</button>
                      </td>
                  </tr>
                  @endforeach 
              </tbody>
          </table>
        </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div id="showModel" class="modal fade" role="dialog">
  <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Task Template</h4>
          </div>
          <div class="modal-body">
                  <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12"> 
                            <div class="col-sm-4" id="left_side_style">
                              <span id="po_details_style">Header Info</span>
                              <br>
                              <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                <label for="name">Template Type:</label>
                                <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <input type="text" name="template_type"  id="template_type" class="form-control">
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Template Name:</label>
                                <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                                  <input  type="text" name="template_name" id="template_name" class="form-control"  value="">
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Remarks:</label>
                                <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                                    <textarea class="form-control" id="remark" name="remark"></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-7" id="right_side_style">
                              <span id="task_details_style">Task Details</span>
                               <br>
                                <div class="row">
                                  <table class="table table-bordered" id="tblMain">
                                    <thead>
                                      <tr style="background-color: #C9DEE3;">
                                        <th scope="col">Seq</th>
                                        <th scope="col" style="width: 500px;text-align: center">Task_Name</th>
                                        <th scope="col" style="width: 300px;text-align: center">Dependent_Task</th>
                                        <th scope="col">Std</th>
                                      </tr>
                                    </thead>
                                    <div class="preload">
                                      <img src="{{asset('/img/loading_spinner.gif')}}"/>
                                    </div>
                                    <tbody id="po_detils">
                                         
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                        </div>
                    </div>   
                  </div> 
              </div>
        </div>
  </div>
</div>
<script>document.title = 'Template List';</script>
<script type="text/javascript">

    $(".preload").hide();
    $(document).on("click", "#openShowModal", function () {
       
      var show_id = $(this).data("id");
      var url = "{{url('/template')}}/"+show_id;
      $.get(url,function(res) {

         $('#template_type').val(res.template_type);
         $('#template_name').val(res.template_name);
         $('#remark').val(res.remark);

          if(res.templateDetails.length>0){
                    
              var rows="";
              var dependent_task="";
              var standard_day="";
              $.each(res.templateDetails, function (key, value) {
                                 
                   if(value.dependent_task!=null) {dependent_task=value.dependent_task}
                   if(value.standard_day!=null)   {standard_day=value.standard_day}
                  
                  rows = rows + '<tr>';
                  rows = rows + '<td style="width:206px;font-weight:bold">' + value.seq + '</td>';
                  rows = rows + '<td style="width:206px;font-weight:bold">' + value.task_name + '</td>';
                  rows = rows + '<td style="width:206px;font-weight:bold">' + dependent_task + '</td>';
                  rows = rows + '<td style="width:206px;font-weight:bold">' + standard_day + '</td>';
                  rows = rows + '</tr>';

              });

              $("#po_detils").html(rows);
              $(".preload").hide();

          }else{

              Swal.fire({

                    title: 'Alert !<br>Something went wrong..!!',
              });

              return false;

          }

      }); 

      $("#showModel").modal("show");

    });
</script>
@endsection