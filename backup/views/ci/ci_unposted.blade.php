@extends('layouts.master')
@section('content') 
<style>
.form-control {

  border-radius: 0;
  box-shadow: none;
  border-color: #0d18b9;

 }
 .form-group {

   margin-bottom: 0px;

 }


 .form-control[disabled]{

  background-color: #288a37;
  
 }

 #party{

    position: absolute;
    left: -346px;
    top: 1px;
 }
 .select2{

    position: absolute;
    left: -248px;
    top: -5px;
 }
.bootstrap-select > .dropdown-toggle.bs-placeholder{

  color: #222;
  border: 1px solid #0f0f1a;
  border-radius: 10px;
  width: 176px;

}
.btn-default {

background-color: #FFFFFF;

}

.bootstrap-select > .dropdown-toggle.bs-placeholder,.bootstrap-select > .dropdown-toggle.bs-placeholder:hover {

  color: #222;
  border: 1px solid #0f0f1a;
  border-radius: 10px;

}

.btn dropdown-toggle btn-default{

  border-radius: 10px;

}
.form-control{

  border-radius: 10px;

}
.task_class_id{

  color: #ae6911f2;
  font-weight: bold;

}
.mail_send{

  color: brown;
  font-weight: bold;

}

.col-sm-7 {

  width: 65.333%;

}
#po_details_style{

  position: absolute;
  top: -15px;
  border: 2px solid blue;
  background: #FFF;
  width: 167px;
  text-align: center;
  font-weight: bold;
  padding: 3px;
  font-style: oblique;

}
#task_details_style{

  position: absolute;
  top: -15px;
  border: 2px solid blue;
  background: #FFF;
  width: 198px;
  text-align: center;
  font-weight: bold;
  padding: 3px;
  font-style: oblique;

}

.table > thead:first-child > tr:first-child > th {

  border: 1px solid #222;

}

.table-bordered > tbody > tr > td{

  border: 1px solid #201f1f;
  padding: 0px;
  font-weight: normal;
  font-family: initial;

}

.table > tbody > tr > td{
 
  padding: 1px;
  line-height: 1.42857143;
  vertical-align: top;

}

.table-bordered > tbody > tr > td{
  
  border: 1px solid #201f1f;
  padding: 1px;
  font-weight: bold;

}

.btn-sm {
   
  padding: 1px 7px 0px 6px;
  font-size: 12px;
  line-height: 1.5;

}

.table-bordered > tbody > tr:hover{

  background-color: rgba(101, 212, 97, 0.836);
  
}


.content-header > .breadcrumb {
  float: right;
  background: transparent;
  margin-top: 0;
  margin-bottom: 0;
  font-size: 12px;
  padding: 7px 5px;
  position: absolute;
  top: -14px;
  right: 10px;
  border-radius: 2px;
}

.preload {
  margin:0;
  position:absolute;
  top:50%;
  left:50%;
  margin-right: -50%;
  transform:translate(-50%, -50%);
}
img{

  height: 386px;

}


.form-horizontal .form-group {

  margin-right: 0px;
  margin-left: 0px;

}
.modal-content{

  width: 900px;
}

#po_detils{

  height: 358px;      
  overflow-y: auto;    
  overflow-x: hidden;  
}
.row {
  margin-right: -15px;
  margin-left: -7px;
}
.box-header.with-border {
  border-bottom: 3px solid #3C8DBC;
  font-weight: bold;
}
.box.box-primary {

  border-top-color: #FFFFFF;

}
#img_toggle_id{

  height: 40px;
  position: absolute;
  top: -3px;
  left: 845px;

}
.box-header.with-border {

  border-bottom: none;

}

.box {
  position: relative;
  border-radius: 3px;
  background: #ffffff;
  border-top: 3px solid #d2d6de;
  margin-bottom: 20px;
  width: 100%;
  box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}

#tblMain {

   display: block;

}

#tblMain{

  height: 358px;      
  overflow-y: auto;    
  overflow-x: hidden;  
}

</style>
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/po')}}"><i class="fa fa-dashboard"></i>Unposted Ci Doc</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px;min-height: 241px;">
        <div class="box-header with-border">
            <div class="row" style="margin-left: 154px;margin-top: 84px;">
                <div class="col-sm-2" style="text-align: right;margin-top: 7px;">Invoice No:</div>
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <input type="text" class="form-control"  name="invoice_no" id="invoice_no" placeholder="Enter Invoice No" value="">
                    </div>
                </div>
                <div class="col-sm-3">
                    <button class="btn btn-info" id="ci_submit_id">Submit</button>
                </div>
            </div>
        </div>
        <br>
    </div>
  </div>
</div>
<script>document.title = 'Unposted | CI Doc';</script>
<script type="text/javascript">
   $(document).ready(function() {
     
        $('#ci_submit_id').click(function(){
            var invoice_no=$('#invoice_no').val();
            $(this).prop('disabled', true);
            if(invoice_no){
               
                $.ajax({
                    type:'GET',
                    url:'/unposted/ci_file',
                    dataType:'json',
                    data:{'invoice_no': invoice_no},
                    success:function(res){
                    
                        if(res.code==500){

                            Swal.fire({
                                position: 'top-end',
                                icon: 'warning',
                                title: 'Invoice not match.!!',
                                timer: 1500
                            });
                            $(this).prop('disabled', false);
                           
                        }else if(res.code==200){
                           
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'File unposted successfully.!!',
                                timer: 1500
                            });

                            $('#invoice_no').val("");
                            $('#ci_submit_id').removeAttr('disabled');

                        }

                    }

                });

            }
            
        });

    });
</script>
@endsection