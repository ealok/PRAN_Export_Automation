
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
                      <th style="text-align: center;background: #1ebd82">#SL</th>
                      <th style="text-align: center;background: #1ebd82">Code</th>
                      <th style="text-align: center;background: #1ebd82">Name</th>
                      <th style="text-align: center;background: #1ebd82">Factor</th>
                      <th style="text-align: center;background: #1ebd82">Rate</th>
                      <th style="text-align: center;background: #1ebd82">Status</th>
                  </tr>  
                </thead>
                <tbody>
                    <?php $i=1; ?>
                    @foreach($results as $result)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$result->ci_item_code}}</td>
                        <td>{{$result->ci_item_name}}</td>
                        <td>{{$result->factor}}</td>
                        <td>{{$result->rate}}</td>
                        <td><span class="badge">{{$result->status}}</span></td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
              </div> 
            </div>
           </div> 
        </div>
        <label for="name" style="position: absolute;top: -21px;left: 40px;width: 252px;height: 23px;text-align: center;padding: 11px 15px 30px 18px;background: darkorange;color: black;border-radius: 20px;">JOB Order Item Status</label>
    </div>
</div>
<script>document.title = 'JOB View Rate Matching';</script>  
</script>
@endsection