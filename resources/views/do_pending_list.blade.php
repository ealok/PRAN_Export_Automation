
<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content') 
<style type="text/css">
  .main{

         position: absolute;
         border:1px solid #222;
         top: -13px;
         left: 35px;
         background: burlywood;
         width: 200px;
         text-align: center;
         height: 24px;

  }
  .form-group{
  
    margin-bottom: 0px;

  }
    
  tr:nth-child(2n+1) {background:#f2f0e700}
  tr:nth-child(even) {background: #D5D0D070}
  tr:first-child{darkgreen}  (nth-child(0) would also work)
  table {

    table-layout: fixed;

  }  
  .ellipsis {

    max-width: 40px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;

  }
  .table_footer{

    text-align: center;
    
  } 
  .table > thead:first-child > tr:first-child > th {
    border-top: 1px solid;
    padding: 15px 0px 14px 3px;
    font-weight: bold;
    font-size: 15px;
    border-bottom-width: 0px;
  }
  .table-bordered > tbody > tr > td{
    
    border: 1px solid #201f1f;
    padding: 6px;
    font-weight: bold;

  }
  .table-bordered > tbody > tr:hover{

    background-color: rgb(240, 250, 148);
  }

  swal2-popup {

font-size: 0.5rem !important;
font-family: Georgia, serif;

}

.swal2-title {

position: relative;
max-width: 100%;
margin: 0 0 .4em;
padding: 0;
color: #111010;
font-size: 1.25em;
font-weight: 600;
text-align: center;
text-transform: none;
word-wrap: break-word;
line-height: 1.6;
}

.swal2-styled.swal2-cancel {
border: 0;
border-radius: .25em;
background: initial;
background-color: initial;
background-color: #9b1010;
color: #fff;
font-size: 1.0625em;
}
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/pending/do/approval_list')}}"><i class="fa fa-dashboard"></i>Pending DO List</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12" style="font-size: 11px;margin-top: 20px;">
      <div class="box box-primary" style="background: rgba(206, 201, 201,); border-top-color: #e3e5e6;position: relative; width: 100%"> 
        <div class="panel-body table-responsive" style="border: 3px solid #c67520;">
            <div class="col-sm-12" style="margin-top: 20px;border: 1px solid;">
               <div class="panel-body table-responsive" style="padding: 0px">
                <table class="table table-bordered table-responsive table-condenced">  
                <span>All&nbsp;&nbsp;&nbsp;<input type="checkbox" id="chk" onclick="checkAll('chk')";></span>
                <button style="margin: 5px;" class="btn btn-danger btn-xs delete-all" data-url="">Approve</button>
                <input id="myInput" type="text" placeholder="Search..">
                <thead style="color: #3c2608;">
                      <tr>
                          <th style="text-align: center;background: #1ebd82">/</th>
                          <th style="text-align: center;background: #1ebd82">SC_NO</th>
                          <th style="text-align: center;background: #1ebd82">Party</th>
                          <th style="text-align: center;background: #1ebd82">Country</th>
                          <th style="text-align: center;background: #1ebd82">JO</th>
                          <th style="text-align: center;background: #1ebd82">Credit Limit</th>
                          <th style="text-align: center;background: #1ebd82">Pending OC</th>
                          <th style="text-align: center;background: #1ebd82">Balance</th>
                          <th style="text-align: center;background: #1ebd82">New DO</th>
                          <th style="text-align: center;background: #1ebd82">Dues($)</th>
                          <th style="text-align: center;background: #1ebd82">Submission Date</th>
                          <th style="text-align: center;background: #1ebd82">Requester</th>
                      </tr>  
                  </thead>
                  <tbody id="myTable">
                        @foreach ($results as $result)
                        <tr id="{{$result->id}}">
                          <td><input type="checkbox" name="chk" value="{{$result->id}}"></td>
                          <td>{{$result->sc_no}}</td>
                          <td>{{$result->party_name}}</td>
                          <td>{{$result->country}}</td>
                          <td>{{$result->jo_number}}</td>
                          <td>{{$result->credit_limit}}</td>
                          <td>{{round($result->undel_value,0)}}</td>
                          <td>{{round($result->balance,0)}}</td>
                          <td>{{round($result->do_amount,0)}}</td>
                          <td>{{round($result->due_amount,0)}}</td>
                          <td>{{$result->create_date}}</td>
                          <td>{{$result->user_name}}</td>
                        </tr>
                        @endforeach
                  </tbody>
                </table>
              </div> 
            </div>
           </div> 
        </div>
        <label for="name" style="position: absolute;top: -21px;left: 40px;width: 252px;height: 23px;text-align: center;padding: 11px 15px 30px 18px;background: darkorange;color: black;border-radius: 20px;">Pending DO List</label>
    </div>
</div>
<script>document.title = 'DO Approval List';</script>
<script type="text/javascript">

  $(document).ready(function(){

    $("#myInput").on("keyup", function() {

      var value = $(this).val().toLowerCase();

      $("#myTable tr").filter(function() {

        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

      });

    });
    
  });

  $(document).ready(function(){

    setTimeout(function() { 

          $('.sr-only').click();

    }, 0.0001);

  });

  function checkAll(checkId) {

    var inputs = document.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++) {
      if (inputs[i].id != checkId) {
        if (inputs[i].type == "checkbox") {
          if (inputs[i].checked == true) {
            inputs[i].checked = false;
          } else if (inputs[i].checked == false) {
            inputs[i].checked = true;
          }
        }
      }
    }

  }

 $(document).ready(function () {
       
    $('.delete-all').on('click', function(e) {
        
        var ids = [];
        $.each($("input[name='chk']:checked"), function(){  

            ids.push($(this).val());

        });

        if(ids.length<1){
           
            Swal.fire('Please select at least one', '', 'warning')

        }else{


            Swal.fire({
              title: 'Are you sure ??',
              text: "Do you want to Approved..??",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then(function(isConfirm) {

                  if(isConfirm.value==true){

                      var url = "{{url('/approve/pending/do_list')}}?ids="+ids;
                      $.get( url, function(data) {

                          console.log(data);

                        if(data.status=='success'){
                                               
                           Swal.fire('Approved Successfully Done.', '', 'success')

                        } 

                        var approve_ids = data.ids.split(",");
                        for (var i=0; i<approve_ids.length; i++ ) {	

                          $("#"+approve_ids[i]).fadeTo("slow",9000, function(){

                              $(this).remove();

                          })

                        }
                        
                      }); 

                  }            

            });
  

        }
         
    });
        
  });
</script>
@endsection