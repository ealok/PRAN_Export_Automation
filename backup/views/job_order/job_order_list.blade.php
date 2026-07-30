
<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content') 
<style type="text/css">
  .main{

         position: absolute;
         border:1px solid #222;
         top: -13px;
         left: 35px;
         background: burlywood;
         width: 200px;
         text-align: center;
         height: 24px;

  }
  .form-group{
  
    margin-bottom: 0px;

  }
    
  tr:nth-child(2n+1) {background:#c4b366;}
  tr:nth-child(even) {background: #CCC}
  tr:first-child{darkgreen}  (nth-child(0) would also work)
  table {

    table-layout: fixed;

  }  
  .ellipsis {

    max-width: 40px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;

  }
  .table_footer{

    text-align: center;
    
  } 
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/job_order/create')}}"><i class="fa fa-dashboard"></i>Job Order Process</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12" style="font-size: 11px">
      <div class="box box-primary" style="background: rgba(206, 201, 201,); border-top-color: #e3e5e6;position: relative; width: 100%"> 
        <div class="panel-body table-responsive" style="border: 3px solid #c67520;">
            <div class="col-sm-12">
                @if(Session::has('success'))
                <div class="alert alert-success">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Success!</strong>{{ Session::get('success') }}
                </div>
                @endif 
                @if(Session::has('danger'))
                <div class="alert alert-danger">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Alert!</strong>{{ Session::get('danger') }}
                </div>
                @endif 
               <div class="panel-body table-responsive" style="padding: 0px">
                <table id="example1" class="table table-bordered table-responsive table-condenced">
                <thead style="color: #3c2608;">
                  <tr>
                      <th style="text-align: center;background: #1ebd82">SL#</th>
                      <th style="text-align: center;background: #1ebd82">JOB Number</th>
                      <th style="text-align: center;background: #1ebd82">Factory</th>
                      <th style="text-align: center;background: #1ebd82">DO Number</th>
                      <th style="text-align: center;background: #1ebd82">Invoice_Number</th>
                      <th style="text-align: center;background: #1ebd82">Party</th>
                      <th style="text-align: center;background: #1ebd82">Issue Date</th>
                      <th style="text-align: center;background: #1ebd82">Status</th>
                      <th style="text-align: center;background: #1ebd82">Action</th>
                  </tr>  
                </thead>
                <tbody>
                    <?php $i=1?>
                    @foreach($jobOrderMasters as $jobOrderMaster)
                    <tr>
                      <td>{{$i++}}</td>
                      <td>{{$jobOrderMaster->job_order_number}}</td>
                      <td>{{$jobOrderMaster->d_code}}/<br>{{$jobOrderMaster->d_name}}</td>
                      <td>{{$jobOrderMaster->job_order_do_number}}</td>
                      <td>{{$jobOrderMaster->invoice_no}}</td>
                      <td>{{$jobOrderMaster->code}}<br>{{$jobOrderMaster->name}}</td>
                      <td>{{$jobOrderMaster->issue_date}}</td>
                      <td>
                         <?php 

                             if($jobOrderMaster->status=='1'){

                                  echo"<p style='Color:black'>Not Approved</p>";

                             }else if($jobOrderMaster->status=='2'){

                                 echo"<p style='Color:green'>Approved</p>";

                             }else if($jobOrderMaster->status=='3'){

                                 echo"<p style='Color:red'>Cancel</p>";

                             }
                             
                         ?> 
                      </td>
                      <td>
                          <a href="{{url('/job_order/show',$jobOrderMaster->id)}}" title="Show" ><button type="button" class="btn btn-xs btn-primary btn-flat">Report</button></a>
                          @if($jobOrderMaster->status!='2')
                          @if($jobOrderMaster->status!='3')
                          <a href="{{url('/job_order/approve',$jobOrderMaster->id)}}" title="Approve" ><button type="button" class="btn btn-xs btn-success btn-flat" onclick="return approveJobOrder()" style="background: #3b3c3a;">Approve</button></a>
                          @endif
                          @endif
                          @if($jobOrderMaster->status!='2')
                          @if($jobOrderMaster->status=='1')
                          <a href="{{url('/job_order/cancel',$jobOrderMaster->id)}}" title="Cancel" ><button type="button" class="btn btn-xs btn-danger btn-flat" onclick="return cancelJobOrder()">Cancel</button></a>
                          @endif
                          @endif
                      </td>
                    </tr> 
                    @endforeach
                </tbody>
                </table>
              </div> 
            </div>
           </div> 
        </div>
        <label for="name" style="position: absolute;top: -21px;left: 40px;width: 252px;height: 23px;text-align: center;padding: 11px 15px 30px 18px;background: darkorange;color: black;border-radius: 20px;">Job Order List</label>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
  <form class="form-horizontal" id="delete_modal_form" role="form" method="POST" action="">
    {{ csrf_field() }}
    {{ method_field("DELETE") }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete item</h4>
      </div>
      <div class="modal-body">
        <h4>Do you want to delete This item ??</h4>
        <input id="delete_id" type="hidden" name="id">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-info pull-left" >Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
    </form>

  </div>
</div>
<script>document.title = 'Job Ordr List';</script>
<script type="text/javascript">
function approveJobOrder(e){
  var check = confirm("Are you sure you want to Approve?");  
  if(check == true){ 
   
     return true;

  }else{

     return false;
  }  
}

function cancelJobOrder(){
 
  var check = confirm("Are you sure you want to Cancel ?");  
  if(check == true){ 
   
     return true;

  }else{

     return false;
  }  

}    
</script>
@endsection