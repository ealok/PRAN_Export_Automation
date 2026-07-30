@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>Country<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href=""><i class="fa fa-dashboard"></i>country Show</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Country</h3>
             </div><!-- /.box-header-end --> 
                 <div class="box-body"> 
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Id</strong></div>
                       <div class="col-md-8"><p>{{$country->id}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Name</strong></div>
                       <div class="col-md-8"><p>{{$country->name}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Code</strong></div>
                       <div class="col-md-8"><p>{{$country->code}}</p></div>              
                    </div>
                    
                 </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Country | Show';</script>
@endsection


