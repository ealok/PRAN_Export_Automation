@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>MailList<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href=""><i class="fa fa-dashboard"></i>mail_list Show</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">MailList</h3>
             </div><!-- /.box-header-end --> 
                 <div class="box-body"> 
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Id</strong></div>
                       <div class="col-md-8"><p>{{$mail_list->id}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Email</strong></div>
                       <div class="col-md-8"><p>{{$mail_list->email}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Name</strong></div>
                       <div class="col-md-8"><p>{{$mail_list->name}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Is active</strong></div>
                       <div class="col-md-8"><p>{{$mail_list->is_active}}</p></div>              
                    </div>
                    
                 </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'MailList | Show';</script>
@endsection


