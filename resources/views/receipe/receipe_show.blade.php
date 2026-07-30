@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href=""><i class="fa fa-dashboard"></i>Recipe Details</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-9 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title" style="border-bottom: 2px solid">Recipe Details</h3>
             </div><!-- /.box-header-end --> 
                 <div class="box-body"> 
                     @foreach($rcpeMasters as $rcpeMaster) 
                    <div class="col-md-12" style="margin-bottom: 10px">
                       <div class="col-md-4"><strong>SL</strong></div>
                       <div class="col-md-4" style="background: #ddd"><p>{{$rcpeMaster->id}}</p></div>              
                    </div>
                    <div class="col-md-12" style="margin-bottom: 10px">
                       <div class="col-md-4"><strong>FG Name</strong></div>
                       <div class="col-md-4" style="background: #ddd"><p>{{$rcpeMaster->rcpe_fg_id}}</p></div>              
                    </div>
                    <div class="col-md-12">
                       <div class="col-md-4"><strong>Status</strong></div>
                       <div class="col-md-4" style="margin-bottom: 30px; background: #ddd"><p>{{$rcpeMaster->active_status}}</p></div>              
                    </div>
                    <div class="col-md-12" style="margin-top: -20px;">
                       <div class="col-md-4"><strong>Product Percentage(%)</strong></div>
                       <div class="col-md-4" style="margin-bottom: 30px; background: #ddd"><p>{{$rcpeMaster->product_percentage}}</p></div>              
                    </div>
                    @endforeach
                    <div class="row-fluid">
                        <table class="table table-bordered">
                        <thead style="background: #AAC13A">
                            <td><strong>Sl_No</strong></td>
                            <td><strong>Ingredient</strong></td>
                            <td><strong>Recipe_Unit</strong></td>
                            <td><strong>Qty</strong></td>
                            <td><strong>Wqty</strong></td>
                            <td><strong>Rate</strong></td>
                            <td><strong>percentage</strong></td>
                            <td><strong>source_type</strong></td>
                            <td><strong>source_address</strong></td>
                        </thead>
                        <tbody>
                          <?php $i=1; $total_percentage=0;?>
                          @foreach($rcpeDetails as $rcpeDetail)
                           <tr>
                              <td>{{$i++}}</td>
                              <td>{{$rcpeDetail->ingredient}}</td>
                              <td>{{$rcpeDetail->rcpe_unit}}</td>
                              <td>{{$rcpeDetail->qty}}</td>
                              <td>{{$rcpeDetail->wqty}}</td>
                              <td>{{$rcpeDetail->rate}}</td>
                              <td>{{$rcpeDetail->percentage}}%<?php $total_percentage=$total_percentage+$rcpeDetail->percentage?></td>
                              <td>{{$rcpeDetail->source_type}}</td>
                              <td>{{$rcpeDetail->source_address}}</td>
                           </tr>
                          @endforeach 
                        </tbody> 
                        <tfoot>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td>Total:{{$total_percentage}}%</td>
                              <td></td>
                              <td></td>
                           </tr>
                        </tfoot> 
                      </table>
                    </div>
                 </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Recipe | Show';</script>
<script>
   setTimeout(function() { 
         $('.sr-only').click();
   }, 0.0001);
</script>
@endsection


