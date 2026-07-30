@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/recipe/create')}}"><i class="fa fa-dashboard"></i>Receipe Create</a></li>
    </ol>
    <br>
</section>
<div class="row">
        @if(Session::has('success'))
       <div class="alert alert-success">
               <strong>Success!</strong>{{ Session::get('success') }}
       </div> 
       @endif 
       @if(Session::has('danger'))
       <div class="alert alert-danger">
               <strong>Failed !</strong>{{ Session::get('danger') }}
       </div> 
       @endif
        <div class="col-md-12">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Create Receipe</h3>
             </div><!-- /.box-header-end -->
              <form class="" role="form"  action="">
              {{ csrf_field() }}
               <div class="box-body">    
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('rcpe_fg_id') ? 'has-error' : '' }}">
                        <label for="rcpe_fg_id">Product Name</label>
                        <select name="rcpe_fg_id" id="rcpe_fg_id" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" >
                            <option value="0">Select Product</option>
                            @foreach($results as $result)
                             <option value="{{$result->id}}">{{$result->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('rcpe_fg_id'))
                            <span class="help-block"><strong>{{ $errors->first('rcpe_fg_id') }}</strong></span>
                        @endif  
                    </div>
                </div> 
                 <div class="col-sm-4">
                     <div class="form-group {{ $errors->has('source_address') ? 'has-error' : '' }}">
                        <label for="source_address">Product Percentage</label>
                        <input name="product_percentage" type="text" id="product_percentage" class="form-control"   value=""   required  max="191"  placeholder="Enter Product Percentage" >
                        @if ($errors->has('product_percentage'))
                            <span class="help-block"><strong>{{ $errors->first('product_percentage') }}</strong></span>
                        @endif
                    </div>
                </div>   
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('ingredient') ? 'has-error' : '' }}">
                        <label for="ingredient">Ingredient</label>
                        <input name="ingredient" type="text" id="ingredient" class="form-control"   value=""   required  max="191"  placeholder="Enter Ingredient Name" >
                        @if ($errors->has('ingredient'))
                            <span class="help-block"><strong>{{ $errors->first('ingredient') }}</strong></span>
                        @endif
                    </div>
                </div>    
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('rcpe_unit') ? 'has-error' : '' }}">
                        <label for="rcpe_unit">Recipe Unit</label>
                        <input name="rcpe_unit" type="text" id="rcpe_unit" class="form-control"   value=""   required  max="191"  placeholder="Enter Recipe Unit">
                        @if ($errors->has('rcpe_unit'))
                            <span class="help-block"><strong>{{ $errors->first('rcpe_unit') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('qty') ? 'has-error' : '' }}">
                        <label for="qty">Total Qty</label>
                        <input name="qty" type="text" id="qty" class="form-control"   value=""   required  max="191"  placeholder="Enter Total Qty" onkeyup="return isNumberKey(event)">
                        @if ($errors->has('qty'))
                            <span class="help-block"><strong>{{ $errors->first('qty') }}</strong></span>
                        @endif
                    </div>
                </div> 
                 <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('percentage') ? 'has-error' : '' }}">
                        <label for="percentage">Percentage(%)</label>
                        <input name="percentage" type="text" id="percentage" class="form-control"   value=""   required  max="191"  placeholder="Enter Percentage Value" onkeyup="return isNumberKey(event)">
                        @if ($errors->has('percentage'))
                            <span class="help-block"><strong>{{ $errors->first('percentage') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('wqty') ? 'has-error' : '' }}">
                        <label for="wqty">Weight Qty(Kg/Ltr)</label>
                        <input name="wqty" type="text" id="wqty" class="form-control"   value=""   required  max="191"  placeholder="Enter Weight Qty" disabled="">
                        @if ($errors->has('wqty'))
                            <span class="help-block"><strong>{{ $errors->first('wqty') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('rate') ? 'has-error' : '' }}">
                        <label for="rate">Rate</label>
                        <input name="rate" type="number" id="rate" class="form-control"   value=""   required  max="191"  placeholder="Enter Material Rate" >
                        @if ($errors->has('rate'))
                            <span class="help-block"><strong>{{ $errors->first('rate') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('source_type') ? 'has-error' : '' }}">
                        <label for="source_type">Source Type</label>
                        <select name="source_type" id="source_type" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" >
                            <option value="">Select Source</option>
                            <option value="Local" selected="">Local</option>
                            <option value="Imported">Imported</option>
                        </select>
                        @if ($errors->has('source_type'))
                            <span class="help-block"><strong>{{ $errors->first('source_type') }}</strong></span>
                        @endif  
                    </div>
                </div>
                <div class="col-sm-4">
                     <div class="form-group {{ $errors->has('source_address') ? 'has-error' : '' }}">
                        <label for="source_address">Source Address</label>
                        <input name="source_address" type="text" id="source_address" class="form-control"   value=""   required  max="191"  placeholder="Enter Address" >
                        @if ($errors->has('source_address'))
                            <span class="help-block"><strong>{{ $errors->first('source_address') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-8"></div>
                <div class="col-sm-1" style="margin-left: -7px;margin-top:25px">
                     <input type="button" class="btn btn-info pull-right btn-flat btn-sm" value="+ Add" onclick="getAllRecipeCreateValue()">
                </div>
                </div>
              </form>  
              <form class="" role="form" method="POST" action="{{route('recipe.store') }}">
               {{ csrf_field() }}  
                <div class="panel-body table-responsive">
                    <table class="table table-bordered table-responsive table-condenced recipe_table">
                      <thead style="background: #6bd99b;">
                        <tr>
                            <th>Sl</th>
                            <th>Product_Name</th>
                            <th>Product_percent</th>
                            <th>Ingredient_Name</th>
                            <th>Receipe_Unit</th>
                            <th>Total_Qty</th>
                            <th>Percentage</th>
                            <th>Weight_Qty</th>
                            <th>Rate</th>
                            <th>Source_Type</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>  
                      </thead>
                      <tbody id="recipe_details">
                          
                      </tbody>
                  </table> 
                </div> 
                <div class="row">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-1"><button class="btn btn-primary btn-sm">Save</button></div>
                </div>
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Recipe | Create';</script>
<script type="text/javascript">
     setTimeout(function() { 
          $('.sr-only').click();
    }, 0.0001);
    function isNumberKey(evt){
         
        var qty=document.getElementById('qty').value;
        var percentage=document.getElementById('percentage').value;
        var weight_qty=parseFloat(qty)*parseFloat(percentage);
        if(isNaN(weight_qty)){

           document.getElementById('wqty').value='0.00';

        }else{

          
           document.getElementById('wqty').value=weight_qty.toFixed(2);;

        }
        
        
         
    }
    var l=0;
    function getAllRecipeCreateValue(){
      
       var rcpe_fg_id=document.getElementById('rcpe_fg_id'); 
       var rcpe_fg_value=document.getElementById('rcpe_fg_id').value;
       var item_name = rcpe_fg_id.options[rcpe_fg_id.selectedIndex].text;
       var ingredient=document.getElementById('ingredient').value;
       var rcpe_unit=document.getElementById('rcpe_unit').value;
       var qty=document.getElementById('qty').value;
       var wqty=document.getElementById('wqty').value;
       var source_type=document.getElementById('source_type').value;
       var percentage=document.getElementById('percentage').value;
       var source_address=document.getElementById('source_address').value;
       var product_percentage=document.getElementById('product_percentage').value;
       var rate=document.getElementById('rate').value;
       
       if(rcpe_fg_value=="0"){

          swal({

            text: "Please Select Your Product..!!",

          });

       }else if(ingredient==''){
          
          swal({

            text: "Enter Your Ingredient Value..!!",

          });

       }else if(rcpe_unit==''){
          
          swal({

            text: "Enter Your Unit Value..!!",

          });

       }else if(percentage==''){
          
          swal({

            text: "Enter Your Percentage Value..!!",

          });

       }else if(source_address==''){
          
          swal({

            text: "Enter Your Source Address..!!",

          });

       }else if(product_percentage==""){

          swal({

            text: "Enter Your Product Percentage..!!",

          });           
       }
       else{

             l++;
             var markup = "<tr>\n\
                <td><input type='text' name='route[]' value='" + l + "' style='display:none'>" + l + "</td>\n\
                <td style='display:none'><input type='text' name='rcpe_fg_value[]' value='" + rcpe_fg_value + "' style='display:none'>" + rcpe_fg_value + "</td>\n\
                <td><input type='text' name='item_name[]' value='" + item_name + "' style='display:none'>" + item_name + "</td>\n\
                <td><input type='text' name='product_percentage[]' value='" + product_percentage + "' style='display:none'>" + product_percentage + "</td>\n\
                <td><input type='text' name='ingredient[]' value='" + ingredient + "' style='display:none'>" + ingredient + "</td>\n\
                <td><input type='text' name='rcpe_unit[]' value='" + rcpe_unit + "' style='display:none'>" + rcpe_unit + "</td>\n\
                <td><input type='text' name='qty[]' value='" + qty + "' style='display:none'>" + qty + "</td>\n\
                <td><input type='text' name='percentage[]' value='" + percentage + "' style='display:none' >" + percentage + "</td>\n\
                <td><input type='text' name='wqty[]' value='" + wqty + "' style='display:none' >" + wqty + "</td>\n\
                <td><input type='text' name='rate[]' value='" + rate + "' style='display:none'>" + rate + "</td>\n\
                <td><input type='text' name='source_type[]' value='" + source_type + "' style='display:none' >" + source_type + "</td>\n\
                <td><input type='text' name='source_address[]' value='" + source_address + "' style='display:none' >" + source_address + "</td>\n\
                <td><input type='button' value='X' class='remove' style='background:red; border:none'></td>\n\
            </tr>";  
            $("#recipe_details").append(markup);
            document.getElementById('ingredient').value='';
            document.getElementById('rcpe_unit').value='';
            document.getElementById('qty').value='';
            document.getElementById('wqty').value='';
            document.getElementById('percentage').value='';
            document.getElementById('rate').value='';
            document.getElementById('source_address').value='';

       }

       $('.recipe_table').on('click', '.remove', function () {

            var rowIndex = $(this).closest('tr').prop('rowIndex');
            $('.recipe_table tr').filter(function () {

                return this.rowIndex === rowIndex;

            }).remove();
                       
      });


    }
</script>
@endsection