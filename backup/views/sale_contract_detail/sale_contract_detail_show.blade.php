@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>SaleContractDetail<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href=""><i class="fa fa-dashboard"></i>sale_contract_detail Show</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">SaleContractDetail</h3>
             </div><!-- /.box-header-end --> 
                 <div class="box-body"> 
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Id</strong></div>
                       <div class="col-md-8"><p>{{$sale_contract_detail->id}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Ci item</strong></div>
                       <div class="col-md-8"><p>{{$sale_contract_detail->ci_item->name}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Sale contract</strong></div>
                       <div class="col-md-8"><p>{{$sale_contract_detail->sale_contract->name}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Hs code</strong></div>
                       <div class="col-md-8"><p>{{$sale_contract_detail->hs_code}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Rate per ctn</strong></div>
                       <div class="col-md-8"><p>{{$sale_contract_detail->rate_per_ctn}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Ctn</strong></div>
                       <div class="col-md-8"><p>{{$sale_contract_detail->ctn}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Pcs in ctn</strong></div>
                       <div class="col-md-8"><p>{{$sale_contract_detail->pcs_in_ctn}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Total amount</strong></div>
                       <div class="col-md-8"><p>{{$sale_contract_detail->total_amount}}</p></div>              
                    </div>
                    
                 </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'SaleContractDetail | Show';</script>
@endsection


