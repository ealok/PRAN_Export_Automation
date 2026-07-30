@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>BankImporter<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href=""><i class="fa fa-dashboard"></i>bank_importer Show</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">BankImporter</h3>
             </div><!-- /.box-header-end --> 
                 <div class="box-body"> 
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Id</strong></div>
                       <div class="col-md-8"><p>{{$bank_importer->id}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Bank name</strong></div>
                       <div class="col-md-8"><p>{{$bank_importer->bank_name}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Account name</strong></div>
                       <div class="col-md-8"><p>{{$bank_importer->account_name}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Branch</strong></div>
                       <div class="col-md-8"><p>{{$bank_importer->branch}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Ac or iban</strong></div>
                       <div class="col-md-8"><p>{{$bank_importer->ac_or_iban}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Swift code</strong></div>
                       <div class="col-md-8"><p>{{$bank_importer->swift_code}}</p></div>              
                    </div>
                    
                    <div class="col-md-6">
                       <div class="col-md-4"><strong>Other</strong></div>
                       <div class="col-md-8"><p>{{$bank_importer->other}}</p></div>              
                    </div>
                    
                 </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'BankImporter | Show';</script>
@endsection


