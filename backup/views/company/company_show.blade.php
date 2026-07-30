@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>Company<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href=""><i class="fa fa-dashboard"></i>company Show</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Company</h3>
             </div><!-- /.box-header-end --> 
                 <div class="box-body"> 
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Id</strong></div>
                       <div class="col-md-8"><p>{{$company->id}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Name</strong></div>
                       <div class="col-md-8"><p>{{$company->name}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Code</strong></div>
                       <div class="col-md-8"><p>{{$company->code}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Erc no</strong></div>
                       <div class="col-md-8"><p>{{$company->erc_no}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Bin no</strong></div>
                       <div class="col-md-8"><p>{{$company->bin_no}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Factory_name</strong></div>
                       <div class="col-md-8"><p>{{$company->factory_name}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Factory address</strong></div>
                       <div class="col-md-8"><p>{{$company->factory_address}}</p></div>              
                    </div>

                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Factory address Details</strong></div>
                       <div class="col-md-8"><p>{{$company->factory_address_details}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Ho address</strong></div>
                       <div class="col-md-8"><p>{{$company->ho_address}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Group</strong></div>
                       <div class="col-md-8"><p>{{$company->group->name}}</p></div>              
                    </div>
                    
                 </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Company | Show';</script>
@endsection


