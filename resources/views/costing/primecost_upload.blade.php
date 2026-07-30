@extends('layouts.master')
<style>
  .preload {
    margin: 0;
    margin-right: 0px;
    position: absolute;
    top: 45%;
    left: 47%;
    margin-right: -50%;
    transform: translate(-50%, -50%);
    z-index: 9999999;
  }
  img{

    height: 183px;
  }
  .swal2-title {
    position: relative;
    max-width: 100%;
    margin: -5px 0 -0.6em;
    padding: 6px;
    color: #595959;
    font-size: 1.875em;
    font-weight: 600;
    text-align: center;
    text-transform: none;
    word-wrap: break-word;
    line-height: 1.5;
  }  

</style>
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/prime_cost/upload')}}"><i class="fa fa-dashboard"></i>Prime Cost Upload</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2" style="margin-top: 40px">
          @if(Session::has('success')) 
          <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong>{{ Session::get('success') }}
          </div>
         @endif 
         @if(Session::has('danger'))
         <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Failed!</strong>{{ Session::get('success') }}
          </div>
         @endif
           <!-- Horizontal Form -->
           <div class="box box-info" style="height: 200px"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Prime Cost Upload</h3>
             </div><!-- /.box-header-end -->
             <form class="form-horizontal" method="POST" id="update_task_status_form_id" action="javascript:void(0)" enctype="multipart/form-data">
                 {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body">    
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('formated_file') ? 'has-error' : '' }}">
                            <label for="formated_file">File</label>
                            <input type="file" name="file"  id="file" class="form-control input-sm"  value=""  placeholder="">
                            @if ($errors->has('formated_file'))
                                <span class="help-block"><strong>{{ $errors->first('formated_file') }}</strong></span>
                            @endif
                        </div> 
                    </div>
                    <div class="preload">
                        <img src="{{asset('/img/loading_spinner.gif')}}"/>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                           <button type="submit" class="btn btn-info btn-flat" style="margin-top: 24px;margin-left:24px" id="upload_btn_id">Upload</button>
                        </div>
                    </div>    
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Notify Party | Upload';</script>
<script>
    setTimeout(function() {  $('.sr-only').click();}, 0.0001);
    $(".preload").hide(); 
    $(document).ready(function (e) {
  
      $.ajaxSetup({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
  
      $('#update_task_status_form_id').submit(function(e) {
        
        e.preventDefault();
        $('#upload_btn_id').prop("disabled",true);
        $(".preload").show(); 
        var formData = new FormData(this);
        
        $.ajax({
            type:'POST',
            url: "{{ url('/prime_cost/upload')}}",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: (res) => {
  
                $(".preload").hide(); 
                $('#upload_btn_id').prop("disabled",false);  

                if(res.status=='success'){
                  
                  Swal.fire({
                    icon: "success",
                    title: "success!",
                    text: "Upload Successfully Done..!!",
                  });
                  
                }else if(res.status=='fail'){
                   
                  Swal.fire({
                    icon: "warning",
                    title: "Alert!",
                    text: "Upload Failed Talk With MIS.!!",
                  });  

                }          
  
            },
            error: function(data){
  
              console.log(data);
              
            }
        });
  
      });
  
    });
  </script>
@endsection