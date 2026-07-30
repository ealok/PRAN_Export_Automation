@extends('layouts.master')
@section('content')
<style>
   
   #def_header_style{
         
      position: absolute;
      top: -18px;
      background: #FFF;
      border: 1px solid #406CF0;
      padding: 6px 28px 6px 20px;
   }
   .form-control {

    border-radius: 0;
    box-shadow: none;
    border-color: #0d18b9;

   }
   .form-group {

     margin-bottom: 0px;
   }
   #left_side_style{
   
      border: 1px solid blue;
      min-height: 246px;  

   }

   #right_side_style{
   
   border: 1px solid blue;
   min-height: 246px;


}
.bootstrap-select > .dropdown-toggle.bs-placeholder{

  color: #222;
  border: 1px solid blue;

}
.btn-default {

  background-color: #FFFFFF;

}
.table > thead:first-child > tr:first-child > th {

  border: 1px solid blue;

}

.table-bordered > tbody > tr > td{

  border: 1px solid blue;
}

.bootstrap-select > .dropdown-toggle.bs-placeholder,.bootstrap-select > .dropdown-toggle.bs-placeholder:hover {
  color: #222;
  border: 1px solid blue;
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
#header_style{
 
  position: absolute;
  top: -9px;
  background: #FFFFFF;
  border: 1px solid blue;
  width: 124px;
  font-weight: bold;
  color: cornflowerblue;

}

#adding_task_to_template{

  position: absolute;
  left: 16px;
  top: -7px;
  background: #FFF;
  border: 1px solid blue;
  font-weight: bold;
  color: cornflowerblue;

}

.row {

  margin-right: 0px;
  margin-left: 0px;

}

#template_style{

    position: absolute;
    left: 13px;
    top: -52px;
    border: 1px solid blue;
    width: 200px;
    text-align: center;
    background: #FFF;
    font-weight: bold;
    font-size: 18px;
    color: #495873;
    background: #c9c9f7;

}

.table > thead:first-child > tr:first-child > th {

    border: 1px solid #222;

}
.table > tbody > tr > td{
   
    border: 1px solid #222;
    text-align: center;

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
    text-align: center;

}
.table > thead:first-child > tr:first-child > th {
   text-align: center;
}

.table-bordered > tbody > tr:hover{

   background-color: rgba(101, 212, 97, 0.836);
}
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/template')}}"><i class="fa fa-dashboard"></i>Template List</a></li>
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
        <div class="col-md-10 col-md-offset-1" style="position: relative">
           <!-- Horizontal Form -->
           <div class="box box-info" style="border-top-color: none;border: 1px solid #4e7bd7;"> <!-- /.box-header start-->
             <form class="" role="form" method="POST" action="" id="task_definition">
              {{ csrf_field() }}
                  <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12" style="margin-top: 28px">
                           <span id="template_style">Data Syn</span>
                           <table class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Time</th>
                                <th scope="col">Url</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                  <td scope="row">1</td>
                                  <td>{{"JO Data Rcv"}}</td>
                                  <td>{{"11:00"}}</td>
                                  <td>{{"/kyv/jo_order/receive"}}</td>
                                  <td><input type="button" class="btn btn-sm btn-danger" value="Action" id="jo_syn_btn_rcv"></td>
                              </tr>
                              <tr>
                                  <td scope="row">2</td>
                                  <td>JO Update</td>
                                  <td>{{'11.30'}}</td>
                                  <td>{{'/kyv/jo/updated/receive'}}</td>
                                  <td><input type="button" class="btn btn-sm btn-danger" value="Action" id="jo_syn_btn_updated_rcv"></td>
                              </tr>
                              <tr>
                                <td scope="row">3</td>
                                <td>{{"Do Data Update Rcv"}}</td>
                                <td>{{"12:00"}}</td>
                                <td>{{"/kyv/do/updated/receive"}}</td>
                                <td><input type="button" class="btn btn-sm btn-danger" value="Action" id="do_syn_btn_updated_rcv"></td>
                              </tr>
                              <tr>
                                <td scope="row">4</td>
                                <td>{{"Freight Rcv"}}</td>
                                <td>Manual</td>
                                <td>{{"/invoice/freight/fatching"}}</td>
                                <td><input type="button" class="btn btn-sm btn-danger" value="Action" id="inv_freight_fatch_id"></td>
                              </tr>
                              <tr>
                                <td scope="row">5</td>
                                <td>{{"OC Update"}}</td>
                                <td>{{"12:30"}}</td>
                                <td>{{"/oc/updated"}}</td>
                                <td><input type="button" class="btn btn-sm btn-danger" value="Action" id="oc_fatch_id"></td>
                              </tr>
                              <tr>
                                <td scope="row">6</td>
                                <td>{{"TRADING ITEM"}}</td>
                                <td><input type="text" id="party_code" name="party_code"></td>
                                <td>{{"/syn/trading_item"}}</td>
                                <td><input type="button" class="btn btn-sm btn-danger" value="Action" id="trading_syn_id"></td>
                              </tr>
                              <tr>
                                <td scope="row">6</td>
                                <td>{{"Ci Value Syn"}}</td>
                                <td>Manual</td>
                                <td>{{"/ci_value/syn"}}</td>
                                <td><input type="button" class="btn btn-sm btn-danger" value="Action" id="ci_syn_id"></td>
                              </tr>
                              <tr>
                                <td scope="row">7</td>
                                <td>{{"JO NO:"}}</td>
                                <td><input type="text" id="jo_no" name="jo_no"></td>
                                <td>{{"/jo_receive/using/jo_number"}}</td>
                                <td><input type="button" class="btn btn-sm btn-danger" value="Action" id="jo_single_id"></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                    </div> 
                  </form>  
                </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Data Syn';</script>
<script type="text/javascript">
    
    setTimeout(function() { $('.sr-only').click();}, 0.0001);
    $(document).ready(function(){

        $("#jo_syn_btn_rcv").click(function(){
  
            var url = "{{url('/')}}"+"/kyv/jo_order/receive";
            $.get(url, function(res) {

                console.log(res);

            });                  
 
        });

        $("#jo_syn_btn_updated_rcv").click(function(){
  
          var url = "{{url('/')}}"+"/kyv/jo/updated/receive";
          $.get(url, function(res) {

              console.log(res);

          });                  

        });

        $("#do_syn_btn_updated_rcv").click(function(){
          
          var url = "{{url('/')}}"+"/kyv/do/updated/receive";
          $.get(url, function(res) {

              console.log(res);

          });                  

        });

        $("#inv_freight_fatch_id").click(function(){
          
          var url = "{{url('/')}}"+"/invoice/freight/fatching";
          $.get(url, function(res) {

              console.log(res);

          });                  

        }); 

        $("#oc_fatch_id").click(function(){
          
          var url = "{{url('/')}}"+"/oc/updated";
          $.get(url, function(res) {

              console.log(res);

          }); 
          

        }); 

        $("#trading_syn_id").click(function(){
          
          var party_code=$('#party_code').val();
          if(party_code==""){

            Swal.fire({
                icon: "warning",
                title: "Oops...",
                text: "Party code cannot empty.!!",
              });

          }else{

            var url = "{{ url('/syn/trading_item')}}";
            url += '?party_code=' + encodeURIComponent(party_code);
            $.get(url, function(res) {

                console.log(res);

            }); 

          }
          
        }); 

        $("#ci_syn_id").click(function(){
          
          var url = "{{url('/')}}"+"/ci_value/syn";
          $.get(url, function(res) {

              console.log(res);

          }); 
          

        }); 

        $('#jo_single_id').click(function() {

            var joNo = $("input[name='jo_no']").val();  
            var url = "{{url('/')}}/jo_receive/by/jo?jo_no=" + encodeURIComponent(joNo);
            $.get(url, function(res) {

               if(res.code==200){
                   
                  Swal.fire({
                    icon: "success",
                    title: "success",
                    text: res.msg,
                  });
                                    
               }else{
                  
                   Swal.fire({
                      icon: "waning",
                      title: "Oops...",
                      text: res.msg,
                  });

               }

            }).fail(function(xhr, status, error) {

                console.error("Error: " + error);
            });
        });  

    });

</script>
@endsection