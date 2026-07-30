@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/bu/create')}}"><i class="fa fa-dashboard"></i>CNF Update</a></li>
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
           <div class="box box-info" style="box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;border-top-color: none">
             <div class="box-header with-border">
               <h3 class="box-title">CNF Update Form</h3>
             </div><!-- /.box-header-end -->
             <form id="SubmitForm">
                {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                <div class="box-body">  
                    <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('invoice_id') ? 'has-error' : '' }}">
                            <label for="carrying_mode_id">Invoice No</label>
                            <select name="invoice_id" id="invoice_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" onchange="getInvoiceValue()">
                                <option value="">Select</option>
                                @foreach($sale_contracts as $sale_contract)
                                <option value="{{$sale_contract->id}}">{{$sale_contract->invoice_no}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('invoice_id'))
                                <span class="help-block"><strong>{{ $errors->first('invoice_id') }}</strong></span>
                            @endif  
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('invoice_value') ? 'has-error' : '' }}">
                            <label for="invoice_value">Invoice Value</label>
                            <input name="invoice_value" type="text" id="invoice_value" class="form-control"   value=""   required  placeholder="Enter Job no..">
                            @if ($errors->has('invoice_value'))
                                <span class="help-block"><strong>{{ $errors->first('invoice_value') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('sb_no') ? 'has-error' : '' }}">
                            <label for="sb_no">JOB NO : (Last Job Id: <span id="job_id">{{$lastJobId}}</span>)</label>
                            <input name="job_no" type="text" id="job_no" class="form-control"   value=""   required  placeholder="Enter Job no.." onkeyup="checkingJONumber()">
                            @if ($errors->has('sb_no'))
                                <span class="help-block"><strong>{{ $errors->first('sb_no') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('sb_no') ? 'has-error' : '' }}">
                            <label for="sb_no">S/B No :</label>
                            <input name="sb_no" type="number" id="sb_no" class="form-control"   value=""   required  placeholder="Enter S/B No">
                            @if ($errors->has('sb_no'))
                                <span class="help-block"><strong>{{ $errors->first('sb_no') }}</strong></span>
                            @endif
                        </div>
                    </div>  
                    
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('sb_date') ? 'has-error' : '' }}">
                            <label for="sb_date">S/B No DT :</label>
                            <input name="sb_date" type="text" id="sb_date" class="form-control datepicker"   value=""   required  placeholder="Enter S/B Date">
                            @if ($errors->has('sb_date'))
                                <span class="help-block"><strong>{{ $errors->first('sb_date') }}</strong></span>
                            @endif
                        </div>
                    </div>  
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('assessable_rate') ? 'has-error' : '' }}">
                            <label for="assessable_rate">ASSESSABLE RATE(USD):</label>
                            <input name="assessable_rate" type="text" id="assessable_rate" class="form-control"   value=""   required  placeholder="Enter assessable rate(USD)" >
                            @if ($errors->has('assessable_rate'))
                                <span class="help-block"><strong>{{ $errors->first('assessable_rate') }}</strong></span>
                            @endif
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('examine_date') ? 'has-error' : '' }}">
                            <label for="examine_date">EXAMINE DT :</label>
                            <input name="examine_date" type="text" id="examine_date" class="form-control datepicker"   value=""   required  placeholder="Enter axamine date" >
                            @if ($errors->has('examine_date'))
                                <span class="help-block"><strong>{{ $errors->first('examine_date') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('doc_send_date') ? 'has-error' : '' }}">
                            <label for="doc_send_date">DOC.SEND  DT :</label>
                            <input name="doc_send_date" type="text" id="doc_send_date" class="form-control datepicker"   value=""   required   placeholder="Enter doc send date" >
                            @if ($errors->has('doc_send_date'))
                                <span class="help-block"><strong>{{ $errors->first('doc_send_date') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('depot_id') ? 'has-error' : '' }}">
                            <label for="depot_id">DEPOT NAME<span class="req_style_id">(*)</span></label>
                            <select name="depot_id" id="depot_id" class="form-control select2" required>
                                <option value="">Select Depot</option>
                                @foreach($depots as $depot)
                                    <option value="{{ $depot->id }}">{{ $depot->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('depot_id'))
                                <span class="help-block"><strong>{{ $errors->first('depot_id') }}</strong></span>
                            @endif  
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('doc_rvd_date') ? 'has-error' : '' }}">
                            <label for="doc_rvd_date">DOC RVD DT :</label>
                            <input name="doc_rvd_date" type="text" id="doc_rvd_date" class="form-control datepicker"   value=""   required    placeholder="Enter doc rvd date" >
                            @if ($errors->has('doc_rvd_date'))
                                <span class="help-block"><strong>{{ $errors->first('doc_rvd_date') }}</strong></span>
                            @endif
                        </div>
                    </div>
                   <div class="col-sm-6"></div>
                   <div class="col-sm-6">
                      <button type="submit" class="btn btn-info btn-flat" id="update_btn_id">UPDATE</button>
                   </div> 
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'CNF | Update';</script>
<script>
    //@@@@--window Toggle
    setTimeout(function() { 

        $('.sr-only').click();

    }, 0.0001); //@@-End

    function getInvoiceValue(){
         
        var invoice_id=$('#invoice_id').val();
        if(invoice_id){

            $.get( "{{url('/json/cnf/get/invoie_value')}}?invoice_id="+invoice_id, function(res) {
               

                $('#invoice_value').val(res.date);
                
    
            });  

        }

    };

    function checkingJONumber(){

       if($('#job_no').val().length>3){

          $.get( "{{url('/json/check/cnf/job_no')}}?job_no="+$('#job_no').val(), function(res) {
               
                if (res.status === true) {

                    $('#job_no').css('border', '2px solid red');
                    $('#update_btn_id').prop('disabled', true);

                } else {

                    $('#job_no').css('border-color', ''); 
                    $('#update_btn_id').prop('disabled', false);
                    
                }
   
           });

       }  


    }

    $('#SubmitForm').on('submit',function(e){

        e.preventDefault();
        $.ajax({
            type:'POST',
            url: "/cnf",
            data: new FormData(this),
            cache:false,
            contentType: false,
            processData: false,
            success: (res) => {

                if(res.code==200){
                
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    resetForm();
                    $("#createModal").modal("hide");
                    $("#job_id").html('');
                    $("#job_id").html(res.last_id);

                }else if(res.code==400){

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: res.message
                    });

                }
                    
            },
            error: function(data){

                console.log(data);
                
            }

        });

        function resetForm(){

           $('#invoice_id').val('').selectpicker('refresh');
           $('#sb_no').val("");
           $('#sb_date').val("");
           $('#assessable_rate').val("");
           $('#examine_date').val("");
           $('#examine_date').val("");
           $('#doc_send_date').val("");
           $('#depot_name').val("");
           $('#doc_rvd_date').val("");
           $('#job_no').val("");
           $('#invoice_value').val("");

        }

    }); 
</script>  
@endsection