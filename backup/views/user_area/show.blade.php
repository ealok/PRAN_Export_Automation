@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/user_area')}}"><i class="fa fa-dashboard"></i>User_Area List</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title"></h3>
             </div><!-- /.box-header-end --> 
                 <div class="box-body"> 
                  
                    <div class="col-md-8">
                       <div class="col-md-4"><strong>User</strong></div>
                       <div class="col-md-8"><p>{{$userArea->user->username}}-{{$userArea->user->name}}</p></div>              
                    </div>
                    <br><br>
                    <div class="col-md-8">
                       <div class="col-md-4"><strong>Area</strong></div>
                       <div class="col-md-8"><p>{{$userArea->area->name}}</p></div>              
                    </div>
                 </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'User Area | Details';</script>
@endsection


