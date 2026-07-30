@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>CiItem<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{ route('ci_item.update',$ci_item->id ) }}"><i class="fa fa-dashboard"></i>ci_item Update</a></li>
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
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">CiItem</h3><span id="demo" style="color: brown;margin-left: 50px"></span>
             </div><!-- /.box-header-end -->
            <form class="" id="SubmitForm">
                {{ csrf_field() }}
                {{ method_field('PUT') }} 
                <!-- /.box-body-start -->    
                <div class="box-body"> 
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('ci_item_code') ? 'has-error' : '' }}">
                        <label for="ci_item_code">Ci item code</label>
                        <input name="ci_item_code" type="text" id="ci_item_code" class="form-control"   value="{{$ci_item->ci_item_code}}"   required autofocus max="191"  placeholder="Ci item code" >
                        @if ($errors->has('ci_item_code'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_code') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-2">
                    <input type="button" name="" value="Check" class="btn btn danger btn-sm" style="background: aquamarine;margin-top: 25px;" onclick="getItemDetails()">
                </div>          
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ci_item_name') ? 'has-error' : '' }}">
                        <label for="ci_item_name">Ci item name</label>
                        <input name="ci_item_name" type="text" id="ci_item_name" class="form-control"   value="{{$ci_item->ci_item_name}}"   required autofocus max="191"  placeholder="Ci item name" readonly>
                        @if ($errors->has('ci_item_name'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_name') }}</strong></span>
                        @endif
                    </div>
                </div>    
                 <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('duplicate_name') ? 'has-error' : '' }}">
                        <label for="ci_item_code">Ci Duplicate Name</label>
                        <input name="duplicate_name" type="text" id="duplicate_name" class="form-control"   value="{{$ci_item->duplicate_name}}"   required autofocus max="191"  placeholder="Ci item name" >
                        @if ($errors->has('duplicate_name'))
                            <span class="help-block"><strong>{{ $errors->first('duplicate_name') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('p_net_weight') ? 'has-error' : '' }}">
                        <label for="p_net_weight">P net weight</label>
                        <input name="p_net_weight" type="number" id="p_net_weight" class="form-control"   value="{{$ci_item->p_net_weight}}"   required autofocus step="any"  placeholder="P net weight" >
                        @if ($errors->has('p_net_weight'))
                            <span class="help-block"><strong>{{ $errors->first('p_net_weight') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('factor') ? 'has-error' : '' }}">
                        <label for="factor">Factor</label>
                        <input name="factor" type="number" id="factor" class="form-control"   value="{{$ci_item->factor}}"   required autofocus placeholder="Factor" readonly>
                        @if ($errors->has('factor'))
                            <span class="help-block"><strong>{{ $errors->first('factor') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ci_factor') ? 'has-error' : '' }}">
                        <label for="ci_factor">Ci factor</label>
                        <input name="ci_factor" type="number" id="ci_factor" class="form-control"   value="{{$ci_item->ci_factor}}"   required autofocus placeholder="Ci factor" readonly>
                        @if ($errors->has('ci_factor'))
                            <span class="help-block"><strong>{{ $errors->first('ci_factor') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('d_net_weight') ? 'has-error' : '' }}">
                        <label for="d_net_weight">D net weight</label>
                        <input name="d_net_weight" type="number" id="d_net_weight" class="form-control"   value="{{$ci_item->d_net_weight}}"   required autofocus step="any"  placeholder="D net weight" >
                        @if ($errors->has('d_net_weight'))
                            <span class="help-block"><strong>{{ $errors->first('d_net_weight') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('d_gross_weight') ? 'has-error' : '' }}">
                        <label for="d_gross_weight">D gross weight</label>
                        <input name="d_gross_weight" type="number" id="d_gross_weight" class="form-control"   value="{{$ci_item->d_gross_weight}}"   required autofocus step="any"  placeholder="D gross weight" >
                        @if ($errors->has('d_gross_weight'))
                            <span class="help-block"><strong>{{ $errors->first('d_gross_weight') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ci_item_rate') ? 'has-error' : '' }}">
                        <label for="ci_item_rate">Ci item rate</label>
                        <input name="ci_item_rate" type="number" id="ci_item_rate" class="form-control"   value="{{$ci_item->ci_item_rate}}"   required autofocus step="any"  placeholder="Ci item rate" >
                        @if ($errors->has('ci_item_rate'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_rate') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('hs_code') ? 'has-error' : '' }}">
                        <label for="hs_code">Hs code</label>
                        <input name="hs_code" type="text" id="hs_code" class="form-control"   value="{{$ci_item->hs_code}}"   required autofocus max="191"  placeholder="Hs code" >
                        @if ($errors->has('hs_code'))
                            <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('bu_id') ? 'has-error' : '' }}">
                        <label for="bu_id">Bu </label>
                        <select name="bu_id" id="bu_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                            
                            
                        </select>
                        @if ($errors->has('bu_id'))
                            <span class="help-block"><strong>{{ $errors->first('bu_id') }}</strong></span>
                        @endif  
                    </div>
                    <input type="hidden" id="edit_id" value="{{$ci_item->id}}">
                    <input type="hidden" id="bu_name" value="">
                </div>   
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('hs_code') ? 'has-error' : '' }}">
                        <label for="hs_code">Categroy</label>
                        <input name="cat_name" type="text" id="cat_name" class="form-control"   value="{{$ci_item->cat_name}}"   required autofocus max="191"  placeholder="Hs code" >
                        @if ($errors->has('hs_code'))
                            <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('hs_code') ? 'has-error' : '' }}">
                        <label for="hs_code">Class</label>
                        <input name="class_name" type="text" id="class_name" class="form-control"   value="{{$ci_item->class_name}}"   required autofocus max="191"  placeholder="Hs code" >
                        @if ($errors->has('hs_code'))
                            <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                        @endif
                    </div>
                </div>   
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                         <input type="submit" class="btn btn-info btn-flat" style="margin-top: 23px" id="edit_button_id" value="Update">
                    </div>
                </div> 
                 <!-- /.box-body -->                
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'CiItem | Edit';</script>
<script style="text/javascript">
       
        $('#edit_button_id').prop("disabled", true);  //Button Diable ture 

        $('#SubmitForm').on('submit',function(e){
          
          e.preventDefault();
          var itemDetails = $("#SubmitForm").serializeArray();
          var edit_id= $('#edit_id').val();
          var bu_name= $('#bu_name').val();
          $.ajax({
              method: 'PUT',
              url: `/ci_item/${edit_id}`,
              data: {'itemDetails': itemDetails,'bu_name':bu_name,'_token': $('input[name=_token]').val()},
              success: function (data) {

                  console.log(data);
                 
                  if(data.Status=='success'){
                      
                      Swal.fire({  
  
                          title: 'Item Updated Successfully..?',  
  
                      }); 
                      $('#edit_button_id').prop("disabled", false);
                  
                  }else{
  
                      Swal.fire({  
  
                        title: 'Item Not Updated Successfully..?',  
  
                      });
  
                  }
  
              },
              error: function (e) {
  
                  console.log(e);
              }
  
          });
          
  
      });

      function getItemDetails(){
        
        var ci_item_code=$('#ci_item_code').val();
        var url = "{{url('/json/ci_item/details')}}/"+ci_item_code;
        var bu='';
        $.get(url,function(data) {
              

            bu=data.bus;
            console.log(bu);
            var object = JSON.parse(data.itemDetails);
            var data = object;
            if(data=="") {

                Swal.fire({  

                    title: 'Sorry!! Item Not Found..?',  
                
                });

                $("#formId")[0].reset();
                loadBU('','');


            }else{

                var result = (Object.entries(data));
                $('#edit_button_id').prop("disabled", false);
                $('#demo').html(result[0][1]['COMPANY_ID']+', '+result[0][1]['BU']);
                $('#buId').val(result[0][1]['COMPANY_ID']);
                $('#ci_item_name').val(result[0][1]['ITEM_NAME']);
                // $('#duplicate_name').val(result[0][1]['ITEM_NAME']);
                $('#factor').val(result[0][1]['D_U_FACT']);
                $('#ci_factor').val(result[0][1]['D_U_FACT']);
                $('#cat_name').val(result[0][1]['CAT_NAME']);
                $('#class_name').val(result[0][1]['CLASS_NAME']);
                $('#class_name').val(result[0][1]['CLASS_NAME']);
                $('#bu_name').val(result[0][1]['BU']);
                loadBU(bu,result[0][1]['COMPANY_ID']);   

            }
            
           

        }); 

        function loadBU(data,party_code){

            if(data){

                var $el = $('#bu_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function (key, value) {
                    
                   $('select[name="bu_id"]').append(`<option value="${value.id}" ${value.code == parseInt(party_code) ? 'selected' : ''}>${value.code}-${value.name}</option>`)

                });

                $el.selectpicker('refresh');
                
            }else{
                
                var $el = $('#bu_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $el.selectpicker('refresh'); 

            }
           

        }

    }  

</script>
@endsection


