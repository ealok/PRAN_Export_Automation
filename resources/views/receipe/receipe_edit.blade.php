@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href=""><i class="fa fa-dashboard"></i>Recipe Edit</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-9 col-md-offset-2">
           @if(Session::has('success'))
          <div class="alert alert-success alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong>{{ Session::get('success') }}
          </div>
          @endif
          @if(Session::has('danger'))
          <div class="alert alert-danger alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Alert!</strong>&nbsp;&nbsp;&nbsp;{{ Session::get('danger') }}
          </div>
          @endif
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title" style="border-bottom: 2px solid">Recipe Edit</h3>
             </div><!-- /.box-header-end --> 
                 <div class="box-body">
                  <form class="" method="post" action="{{url('update/recipe/master')}}"> 
                  {{csrf_field()}}  
                     @foreach($rcpeMasters as $rcpeMaster) 
                    <div class="col-md-12" style="margin-bottom: 10px;">
                       <div class="col-md-4"><strong>SL</strong></div>
                       <div class="col-md-4"><input type="hidden" name="master_id" value="{{$rcpeMaster->id}}">{{$rcpeMaster->id}}</div>
                    </div>
                    <div class="col-md-12" style="margin-bottom: 10px">
                       <div class="col-md-4"><strong>FG Name</strong></div>
                       <div class="col-md-4">
                          <select name="rcpe_fg_id" id="rcpe_fg_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select">
                            @foreach($rcpeis as $rcpe)
                            <option value="{{$rcpe->id}}"{{$recipeMasterId==$rcpe->id ? 'selected="selected"' : '' }}>{{$rcpe->name}}
                            </option>
                            @endforeach
                          </select>  
                       </div>              
                    </div>
                    <div class="col-sm-12">
                       <div class="form-group {{ $errors->has('source_address') ? 'has-error' : '' }}">
                          <label for="source_address" class="col-md-4">Product Percentage</label>
                          <div class="col-md-4" style="margin-bottom: 30px;">
                            <input name="product_percentage" type="text" id="product_percentage" class="form-control"   value="{{$rcpeMaster->product_percentage}}"   required autofocus max="191"  placeholder="Enter Product Percentage" >
                            @if ($errors->has('product_percentage'))
                                <span class="help-block"><strong>{{ $errors->first('product_percentage') }}</strong></span>
                            @endif
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                       <div class="col-md-4"><strong>Status</strong></div>
                       <div class="col-md-4" style="margin-bottom: 30px;">
                          @if($rcpeMaster->status=='1')
                           <input type="checkbox" name="status" value="1" checked>&nbsp;&nbsp;Active
                          @else
                           <input type="checkbox" name="status" value="0">&nbsp;&nbsp;Inactive
                          @endif 
                       </div>              
                    </div>
                    <div class="col-md-12" style="margin-top: -20px;margin-bottom: 10px">
                       <div class="col-md-4"><strong></strong></div>
                       <div class="col-md-4"><button class="btn btn-info btn-sm btn-flat">Edit</button></div>              
                    </div>
                    @endforeach
                  </form>
                    <div class="row-fluid">
                        <table class="table table-bordered">
                        <thead style="background: #AAC13A">
                            <td><strong>Sl_No</strong></td>
                            <td><strong>Ingredient</strong></td>
                            <td><strong>Recipe_Unit</strong></td>
                            <td><strong>Qty</strong></td>
                            <td><strong>Wqty</strong></td>
                            <td><strong>percentage</strong></td>
                            <td><strong>source_type</strong></td>
                            <td><strong>source_address</strong></td>
                            <td><strong>Rate</strong></td>
                            <td><strong>Action</strong></td>
                        </thead>
                        <tbody>
                          <?php $i=1?>
                          @foreach($rcpeDetails as $rcpeDetail)
                           <tr>
                              <td>{{$i++}}</td>
                              <td>{{$rcpeDetail->ingredient}}</td>
                              <td>{{$rcpeDetail->rcpe_unit}}</td>
                              <td>{{$rcpeDetail->qty}}</td>
                              <td>{{$rcpeDetail->wqty}}</td>
                              <td>{{$rcpeDetail->percentage}}%</td>
                              <td>{{$rcpeDetail->source_type}}</td>
                              <td>{{$rcpeDetail->source_address}}</td>
                              <td>{{$rcpeDetail->rate}}</td>
                              <td>
                                  <a href="{{url('/recipe/details/edit',$rcpeDetail->id)}}" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>
                                  <a href="{{url('/recipe/details/delete',$rcpeDetail->id)}}" title="Edit" ><button type="button" class="btn btn-xs btn-danger btn-flat">Del</button></a>
                              </td>
                           </tr>
                          @endforeach 
                        </tbody>  
                      </table>
                    
                    </div>
                    
                 </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Recipe | Edit';</script>
<script>
    setTimeout(function() { 
          $('.sr-only').click();
    }, 0.0001);
</script>
@endsection


