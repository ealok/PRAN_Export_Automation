@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>NotifyParty<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/notify_party/create')}}"><i class="fa fa-dashboard"></i>notify_party Create</a></li>
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
               <h3 class="box-title">NotifyParty (<span id="party_area" style="color: red"></span>)</h3>
             </div><!-- /.box-header-end -->
             <form class="" id="SubmitForm">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                        
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                        <label for="code">Code</label>
                        <input name="code" type="text" id="code" class="form-control"   value=""   required autofocus max="191"  placeholder="Code" >
                        @if ($errors->has('code'))
                            <span class="help-block"><strong>{{ $errors->first('code') }}</strong></span>
                        @endif
                    </div>
                </div>    
                <div class="col-sm-2">
                    <input type="button" name="" value="Check" class="btn btn danger btn-sm" style="background: aquamarine;margin-top: 25px;" onclick="getPartyDetails()">
                </div>  
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Name</label>
                        <input name="name" type="text" id="name" class="form-control"   value=""   required autofocus max="191"  placeholder="Name" readonly>
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>    
                <div class="col-sm-6">
                    <div class="form-group {{$errors->has('address') ? 'has-error' : '' }}">
                        <label for="address" class="col-sm-6 control-label">Address</label>
                        <textarea name="address" id="address" type="text" class="form-control"  required autofocus placeholder="address">{{ old('address') }}</textarea>
                        @if ($errors->has('address'))
                            <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{$errors->has('shipping_mark') ? 'has-error' : '' }}">
                        <label for="shipping_mark" class="col-sm-6 control-label">Shipping Mask</label>
                        <textarea name="shipping_mark" id="shipping_mark" type="text" class="form-control" autofocus placeholder="Shipping Mask">{{ old('shipping_mark') }}</textarea>
                        @if ($errors->has('shipping_mark'))
                            <span class="help-block"><strong>{{ $errors->first('shipping_mark') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{$errors->has('address') ? 'has-error' : '' }}">
                        <label for="address" class="col-sm-6 control-label">Country</label>
                        <input name="country" type="text" id="country" class="form-control"   value=""   required autofocus max="191"  placeholder="Name">
                        @if ($errors->has('address'))
                            <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('mfg_date') ? 'has-error' : '' }}">
                        <label for="mfg_date">MFG Date Format</label>
                        <select name="mfg_date" id="mfg_date" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                            <option value="">Select</option>
                            @foreach($dateFormates as $dateFormate)
                            <option value="{{$dateFormate->id}}">{{$dateFormate->formate}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('mfg_date'))
                        <span class="help-block"><strong>{{ $errors->first('mfg_date') }}</strong></span>
                        @endif  
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('exp_date') ? 'has-error' : '' }}">
                        <label for="exp_date">EXP Date Format</label>
                        <select name="exp_date" id="exp_date" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                            <option value="">Select</option>
                            @foreach($dateFormates as $dateFormate)
                            <option value="{{$dateFormate->id}}">{{$dateFormate->formate}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('exp_date'))
                        <span class="help-block"><strong>{{ $errors->first('exp_date') }}</strong></span>
                        @endif  
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ref_name') ? 'has-error' : '' }}">
                        <label for="name">Ref Name</label>
                        <input name="ref_name" type="text" id="ref_name" class="form-control"   value=""   required autofocus max="191"  placeholder="Ref name" >
                        @if ($errors->has('ref_name'))
                            <span class="help-block"><strong>{{ $errors->first('ref_name') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('region') ? 'has-error' : '' }}">
                        <label for="name">Region</label>
                        <input name="region" type="text" id="region" class="form-control"   value="" autofocus max="191"  placeholder="" readonly>
                        @if ($errors->has('region'))
                            <span class="help-block"><strong>{{ $errors->first('region') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('area') ? 'has-error' : '' }}">
                        <label for="name">Area</label>
                        <select name="area_id" id="area_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                            <option value="">Select</option>
                            @foreach($areas as $area)
                            <option value="{{$area->id}}">{{$area->name}}</option>
                            @endforeach
                        </select>
                        <input name="area" type="hidden" id="area" class="form-control"   value="" autofocus max="191"  placeholder="" readonly>
                        @if ($errors->has('area'))
                            <span class="help-block"><strong>{{ $errors->first('area') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('first_approval') ? 'has-error' : '' }}">
                        <label for="name">First Approval</label>
                        <select name="first_approval" id="first_approval" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                            <option value="">Select</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->username}} / {{$user->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('first_approval'))
                            <span class="help-block"><strong>{{ $errors->first('first_approval') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('second_approval') ? 'has-error' : '' }}">
                        <label for="name">Second Approval</label>
                        <select name="second_approval" id="second_approval" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                            <option value="">Select</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->username}} / {{$user->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('second_approval'))
                            <span class="help-block"><strong>{{ $errors->first('second_approval') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('area') ? 'has-error' : '' }}">
                        <label for="name">Status</label><br>
                        <class="checkbox-inline">
                            <input type="radio" name="status" value="1" name="status" id="check1">&nbsp;Active
                        </label>
                        <label class="checkbox-inline">
                            <input type="radio" name="status" value="0" name="status" id="check2">&nbsp;Inactive
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px">Create</button>
                </div>         
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'NotifyParty | Create';</script>
<script type="text/javascript">
     setTimeout(function() { $('.sr-only').click();}, 0.0001);
    $('#SubmitForm').on('submit',function(e){
          
          e.preventDefault();
          var partyDetails = $("#SubmitForm").serializeArray();
          var area=$('#area').val();
          console.log(partyDetails);
          $.ajax({
              method: 'POST',
              url: "/notify_party",
              data: {'partyDetails': partyDetails,'area':area,'_token': $('input[name=_token]').val()},
              success: function (data) {

                console.log(data);
  
                if(data.Status=='success'){

                    $("#SubmitForm")[0].reset();
                    Swal.fire({  

                        title: 'Party Create Successfully..?',  

                    });                     
                
                }else if(data.Status=='exist'){

                    Swal.fire({  

                        title: 'Party Already Exist..?',  

                    });

                }else{

                    Swal.fire({  

                      title: 'Party Create Unsuccessfull..?',  

                    });

                }
                 
              },
              error: function (e) {
  
                  console.log(e);
              }
  
          });
          
  
      });

    function getPartyDetails(){
        
        var party_code=$('#code').val();
        var url = "{{url('/json/notify_party/details')}}/"+party_code;
        var bu='';
        $.get(url,function(data) {
  
            bu=data.bus;
            var object = JSON.parse(data.partyDetils);
            console.log(object);
            var data = object;
            if (data=="") {

                Swal.fire({  

                    title: 'Sorry!! Party Not Found..?',  
                
                });

                $("#formId")[0].reset();

            }else {

                var result = (Object.entries(data));
                
                $('#name').val(result[0][1]['PARTY_NAME']);
                $('#address').val(result[0][1]['ADDR']);
                $('#region').val("Export");
                $('#area').val(result[0][1]['AREA_NAME']);
                $('#party_area').html(result[0][1]['AREA_NAME']);
                if(result[0][1]['CANCELLED']=='N'){
                    
                    $("#check2").prop("checked", false);
                    $("#check1").prop("checked", true);

                }else{

                    $("#check1").prop("checked", false);
                    $("#check2").prop("checked", true);

                }
  

            }
            

        }); 

    }

</script>
@endsection