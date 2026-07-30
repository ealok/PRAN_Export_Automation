@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>NotifyPartyItem<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href=""><i class="fa fa-dashboard"></i>notify_party_item Show</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">NotifyPartyItem</h3>
             </div><!-- /.box-header-end --> 
                 <div class="box-body"> 
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Id</strong></div>
                       <div class="col-md-8"><p>{{$notify_party_item->id}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Notify party</strong></div>
                       <div class="col-md-8"><p>{{$notify_party_item->notify_party->name}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Ci item</strong></div>
                       <div class="col-md-8"><p>{{$notify_party_item->ci_item->name}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Desk item name</strong></div>
                       <div class="col-md-8"><p>{{$notify_party_item->desk_item_name}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Acc rate</strong></div>
                       <div class="col-md-8"><p>{{$notify_party_item->acc_rate}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Party rate</strong></div>
                       <div class="col-md-8"><p>{{$notify_party_item->party_rate}}</p></div>              
                    </div>
                    
                 </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'NotifyPartyItem | Show';</script>
@endsection


