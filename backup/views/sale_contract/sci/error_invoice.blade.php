@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/incentive/excel/upload/view')}}"><i class="fa fa-dashboard"></i>Incentive Excel Upload</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
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
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Error Invoice List</h3>
             </div><!-- /.box-header-end -->
              <table class="table table-border"> 
                  <tr>
                      <td>Sl</td>
                      <td>invoice</td>
                  </tr>    
                  <?php $i=1?>
                  @foreach($results as $key=>$value)
                  <tr>
                    <td>{{$i++}}</td>
                    <td>{{$value}}</td>  
                  </tr> 
                  @endforeach
              </table>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Not Found ';</script>
@endsection