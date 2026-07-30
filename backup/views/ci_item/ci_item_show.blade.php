@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>CiItem<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href=""><i class="fa fa-dashboard"></i>ci_item Show</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">CiItem</h3>
             </div><!-- /.box-header-end --> 
                 <div class="box-body"> 
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Id</strong></div>
                       <div class="col-md-8"><p>{{$ci_item->id}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Ci item name</strong></div>
                       <div class="col-md-8"><p>{{$ci_item->ci_item_name}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Ci item code</strong></div>
                       <div class="col-md-8"><p>{{$ci_item->ci_item_code}}</p></div>              
                    </div>

                     <div class="col-md-6">
                       <div class="col-md-4"><strong>Ci item Name</strong></div>
                       <div class="col-md-8"><p>{{$ci_item->duplicate_name}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>P net weight</strong></div>
                       <div class="col-md-8"><p>{{$ci_item->p_net_weight}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Factor</strong></div>
                       <div class="col-md-8"><p>{{$ci_item->factor}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Ci factor</strong></div>
                       <div class="col-md-8"><p>{{$ci_item->ci_factor}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>D net weight</strong></div>
                       <div class="col-md-8"><p>{{$ci_item->d_net_weight}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>D gross weight</strong></div>
                       <div class="col-md-8"><p>{{$ci_item->d_gross_weight}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Ci item rate</strong></div>
                       <div class="col-md-8"><p>{{$ci_item->ci_item_rate}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Hs code</strong></div>
                       <div class="col-md-8"><p>{{$ci_item->hs_code}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Bu</strong></div>
                       <div class="col-md-8"><p>{{$ci_item->bu->name}}</p></div>              
                    </div>

                     <div class="col-md-6">
                       <div class="col-md-4"><strong>Status</strong></div>
                       <div class="col-md-8"><p>@if($ci_item->status=="1"){{'Active'}}@else{{"Inactive"}}@endif</p></div>              
                    </div>
                                     
                 </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'CiItem | Show';</script>
@endsection


