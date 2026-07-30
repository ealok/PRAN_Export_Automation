@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>CiItem<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/ci_item/create')}}"><i class="fa fa-dashboard"></i>ci_item Create</a></li>
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
             <form id="SubmitForm">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                <div class="box-body"> 
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('ci_item_code') ? 'has-error' : '' }}">
                        <label for="ci_item_code">Ci item code</label>
                        <input name="ci_item_code" type="text" id="ci_item_code" class="form-control"     required autofocus max="191"  placeholder="Enter Your Item Code">
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
                        <input name="ci_item_name" type="text" id="ci_item_name" class="form-control"     required autofocus max="191"  placeholder="Ci item name" readonly>
                        @if ($errors->has('ci_item_name'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_name') }}</strong></span>
                        @endif
                    </div>
                </div>     
                 <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('duplicate_name') ? 'has-error' : '' }}">
                        <label for="ci_item_code">Ci Item Name(Duplicate)</label>
                        <input name="duplicate_name" type="text" id="duplicate_name" class="form-control"  required autofocus max="191"  placeholder="Ci item name" >
                        @if ($errors->has('duplicate_name'))
                            <span class="help-block"><strong>{{ $errors->first('duplicate_name') }}</strong></span>
                        @endif
                    </div>
                </div>   

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('p_net_weight') ? 'has-error' : '' }}">
                        <label for="p_net_weight">P net weight</label>
                        <input name="p_net_weight" type="number" id="p_net_weight" class="form-control"      required autofocus step="any"  placeholder="P net weight" >
                        @if ($errors->has('p_net_weight'))
                            <span class="help-block"><strong>{{ $errors->first('p_net_weight') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('factor') ? 'has-error' : '' }}">
                        <label for="factor">Factor</label>
                        <input name="factor" type="number" id="factor" class="form-control"      required autofocus placeholder="Factor" readonly>
                        @if ($errors->has('factor'))
                            <span class="help-block"><strong>{{ $errors->first('factor') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ci_factor') ? 'has-error' : '' }}">
                        <label for="ci_factor">Ci factor</label>
                        <input name="ci_factor" type="number" id="ci_factor" class="form-control" required autofocus placeholder="Ci factor" readonly>
                        @if ($errors->has('ci_factor'))
                            <span class="help-block"><strong>{{ $errors->first('ci_factor') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('d_net_weight') ? 'has-error' : '' }}">
                        <label for="d_net_weight">D net weight</label>
                        <input name="d_net_weight" type="number" id="d_net_weight" class="form-control"     required autofocus step="any"  placeholder="D net weight" >
                        @if ($errors->has('d_net_weight'))
                            <span class="help-block"><strong>{{ $errors->first('d_net_weight') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('d_gross_weight') ? 'has-error' : '' }}">
                        <label for="d_gross_weight">D gross weight</label>
                        <input name="d_gross_weight" type="number" id="d_gross_weight" class="form-control"     required autofocus step="any"  placeholder="D gross weight" >
                        @if ($errors->has('d_gross_weight'))
                            <span class="help-block"><strong>{{ $errors->first('d_gross_weight') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ci_item_rate') ? 'has-error' : '' }}">
                        <label for="ci_item_rate">Ci item rate</label>
                        <input name="ci_item_rate" type="number" id="ci_item_rate" class="form-control"     required autofocus step="any"  placeholder="Ci item rate" >
                        @if ($errors->has('ci_item_rate'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_rate') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('hs_code') ? 'has-error' : '' }}">
                        <label for="hs_code">Hs code</label>
                        <input name="hs_code" type="text" id="hs_code" class="form-control"   value=""   required autofocus max="191"  placeholder="Hs code" >
                        @if ($errors->has('hs_code'))
                            <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                        @endif
                        
                    </div>
                </div> 

                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('bu_id') ? 'has-error' : '' }}">
                        <label for="bu_id">Bu </label>
                        <select name="bu_id" id="bu_id" data-live-search="true" class="form-control select2 selectpicker" type="select"  value="1"  disabled>
                            
                        </select>
                        @if ($errors->has('bu_id'))
                            <span class="help-block"><strong>{{ $errors->first('bu_id') }}</strong></span>
                        @endif  
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('categroy_name') ? 'has-error' : '' }}">
                        <label for="categroy_name">Category Name</label>
                        <input name="categroy_name" type="text" id="categroy_name" class="form-control"   value=""   required autofocus max="191"  placeholder="Enter Categroy Name" readonly>
                        @if ($errors->has('categroy_name'))
                            <span class="help-block"><strong>{{ $errors->first('categroy_name') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('class_name') ? 'has-error' : '' }}">
                        <label for="class_name">Class Name</label>
                        <input name="class_name" type="text" id="class_name" class="form-control"   value=""   required autofocus max="191"  placeholder="Enter Class Name" readonly>
                        @if ($errors->has('class_name'))
                            <span class="help-block"><strong>{{ $errors->first('class_name') }}</strong></span>
                        @endif
                        <input type="hidden" name="buId" value="" id="buId">
                        <input type="hidden" id="bu_name" value="">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('class_name') ? 'has-error' : '' }}">
                        <button type="submit" class="btn btn-primary" style="margin-top: 25px">Create</button>
                    </div>
                </div>  
                 </div> 
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'CiItem | Create';</script>
<script type="text/javascript">
   
    $('#SubmitForm').on('submit',function(e){
          
        e.preventDefault();
        var itemDetails = $("#SubmitForm").serializeArray();
        var bu_name= $('#bu_name').val();
        $.ajax({
            method: 'POST',
            url: "/ci_item",
            data: {'itemDetails': itemDetails,'bu_name':bu_name,'_token': $('input[name=_token]').val()},
            success: function (data) {
               
                if(data=='success'){
                    
                    Swal.fire({  

                        title: 'Item Create Successfully..?',  

                    }); 
                
                }else if(data=='exist'){
                  
                    Swal.fire({  

                        title: 'Item Already Exist..?',  

                    }); 

                }else{

                    Swal.fire({  

                      title: 'Item Not Create Successfully..?',  

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

                $('#demo').html(result[0][1]['COMPANY_ID']+', '+result[0][1]['BU']);
                $('#buId').val(result[0][1]['COMPANY_ID']);
                $('#ci_item_name').val(result[0][1]['ITEM_NAME']);
                $('#duplicate_name').val(result[0][1]['ITEM_NAME']);
                $('#factor').val(result[0][1]['D_U_FACT']);
                $('#ci_factor').val(result[0][1]['D_U_FACT']);
                $('#categroy_name').val(result[0][1]['CAT_NAME']);
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