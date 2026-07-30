
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
    
  tr:nth-child(2n+1) {background:#c4b366;}
  tr:nth-child(even) {background: #CCC}
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

       border: 1px solid #222;

  }

  .table-bordered > tbody > tr > td{

     border: 1px solid #222;

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

  table.dataTable {
    width: 99%;
    margin: 0 auto;
    clear: both;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 12px;
  }
  .content-header > .breadcrumb > li > a {
    color: #206C8A;
    text-decoration: none;
    display: inline-block;
    font-size: 13px;
    font-weight: bold;
  }

.table-bordered > tbody > tr:hover{

    background-color: rgba(101, 212, 97, 0.836);

}

</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/desk/wise/notify/party')}}"><i class="fa fa-dashboard"></i>Notify_Party_List</a></li>
      <li class="active"><a href="{{url('/notify/party/list/desk')}}/{{\Crypt::encrypt($party_id)}}"><i class="fa fa-dashboard"></i>SC_List</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary" style="background: rgba(206, 201, 201,); border-top-color: #e3e5e6;position: relative; width: 100%"> 
        <div class="panel-body table-responsive" style="border: 3px solid #c67520;">
            <div class="col-sm-12" style="font-size: 12px">
                @if(Session::has('success'))
                <div class="alert alert-success">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Success!</strong>{{ Session::get('success') }}
                </div>
                @endif 
                @if(Session::has('danger'))
                <div class="alert alert-danger">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Alert!</strong>{{ Session::get('danger') }}
                </div>
                @endif 
               <div class="panel-body table-responsive" style="padding: 0px">
                <table id="example2" class="table table-bordered table-responsive table-condenced">
                <thead style="color: #3c2608;">
                  <tr> 
                      <th style="text-align: center;background: #1ebd82;width:89px">JOB Number</th>
                      <th style="text-align: center;background: #1ebd82;width: 121px">Prod_Floor / Out Depo</th>
                      <th style="text-align: center;background: #1ebd82;width: 109.6px;">DO Number</th>
                      <th style="text-align: center;background: #1ebd82;width: 25px;">Party</th>
                      <th style="text-align: center;background: #1ebd82;width: 110.3px;">Invoice No</th>
                      <th style="text-align: center;background: #1ebd82;width: 41.9333px;">Status</th>
                      <th style="text-align: center;background: #1ebd82;width: 200px;">Action</th>
                  </tr>  
                </thead>
                <tbody>
                    @foreach($jobOrderMasters as $jobOrderMaster)
                    <tr>
                      <td>{{$jobOrderMaster->job_order_number}}</td>
                      <td>{{$jobOrderMaster->prod_floor}} / {{$jobOrderMaster->out_depo}}</td>
                      <td>{{$jobOrderMaster->job_order_do_number}}</td>
                      <td>{{$jobOrderMaster->code}}</td>
                      <td>{{$jobOrderMaster->invoice_no}}</td>
                      <td>
                         <?php 
                             if($jobOrderMaster->status=='1'){
                                  echo"<p style='Color:black'>Not Approved</p>";
                             }else if($jobOrderMaster->status=='2'){
                                 echo"<p style='Color:green'>Approved</p>";
                             }else if($jobOrderMaster->status=='3'){
                                 echo"<p style='Color:red'>Cancel</p>";
                             }
                         ?> 
                      </td>
                      <td>
                          <a href="{{url('/job_order/show')}}/{{\Crypt::encrypt($jobOrderMaster->id)}}" title="report" ><button type="button" class="btn btn-xs btn-primary btn-flat">Report</button></a>
                          @if($jobOrderMaster->status=='2')
                            @if($jobOrderMaster->job_order_do_status!='OK')
                            <a href="{{url('/job_order/do/create')}}/{{\Crypt::encrypt($jobOrderMaster->id)}}" title="DO" ><button type="button" class="btn btn-xs btn-success btn-flat">Do</button></a>
                            @endif
                          @endif
                          @if($jobOrderMaster->status!='2')
                            @if($jobOrderMaster->status!='3')
                            <a href="{{url('/job/order/edit')}}/{{\Crypt::encrypt($jobOrderMaster->id)}}" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>
                            <button type="button" class="btn btn-danger btn-xs btn-flat use-address" data-toggle="modal" data-target="#myModal">Add Item</button>
                            @endif
                          @endif
                          @if($jobOrderMaster->status!='2')
                            @if($jobOrderMaster->status!='3')
                            <a href="{{url('/job_order/approve')}}/{{\Crypt::encrypt($jobOrderMaster->id)}}" title="Approve" ><button type="button" class="btn btn-xs btn-success btn-flat" onclick="return approveJobOrder()" style="background: #3b3c3a;">Approve</button></a>
                            @endif
                          @endif
                          @if($jobOrderMaster->status!='2')
                            @if($jobOrderMaster->status=='1')
                            <a href="{{url('/job_order/cancel',$jobOrderMaster->id)}}" title="Cancel" ><button type="button" class="btn btn-xs btn-danger btn-flat" onclick="return cancelJobOrder()">Cancel</button></a>
                            @endif
                          @endif
                      </td>
                    </tr> 
                    @endforeach
                </tbody>
                </table>
              </div> 
            </div>
           </div> 
        </div>
        <label for="name" style="position: absolute;top: -21px;left: 40px;width: 252px;height: 23px;text-align: center;padding: 11px 15px 30px 18px;background: darkorange;color: black;border-radius: 20px;">Job Order List</label>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">  
  <form class="form-horizontal" action="">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">ITEM ADDED</h4>
      </div>
      <div class="modal-body">
         <div class="modal-body mx-3">
          <div class="md-form mb-4">
            <label data-error="wrong" data-success="right" for="defaultForm-email">Depo</label>
            <select name="depo_id" id="depo_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                
                
            </select>
          </div>
          <div class="md-form mb-4">
            <label data-error="wrong" data-success="right" for="defaultForm-email">Item</label>
            <select name="sc_item_id" id="sc_item_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                <option value="">Select Item</option>
                
            </select>
          </div>
          <div>
             <input type="hidden" class="form-control" id="job_order_number">
             <input type="hidden" class="form-control" id="sc_id">
          </div>
      </div>
      <div class="modal-footer">
        <!-- <input type="button" class="btn btn-success btn-sm" value="Rate Matching" onclick="return itemAddRateMatchingFun()"> -->
        <input type="button" class="btn btn-info btn-sm" value="+Add" onclick="return addNewJobOrderItem()">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<script>document.title = 'Desk Wise JOB';</script>
<script type="text/javascript">

  $(document).ready(function(){
      setTimeout(function() { 

          $('.sr-only').click();

      }, 0.0001);
  });
 
  function approveJobOrder(e){

    var check = confirm("Are you sure you want to Approve?");  
    if(check == true){ 
    
      return true;

    }else{

      return false;
    }  

  }

  function getMfgDate(){
       
      var delivery_date=document.getElementById('delivery_date').value;
      var delivery_date = delivery_date.split("-");
      var mm = delivery_date[1];
      if (mm < 10) {

          mm = mm
      }
      var day = delivery_date[0];
      day=parseInt(day)-1;
      if (day < 10) {

          day = '0'+day;
      }

      
      var yyyy = delivery_date[2];
      var date = day+"-"+mm+"-"+yyyy;
      document.getElementById("mfg_date").value = date;


  }

$('.table-condenced tbody').on('click', '.use-address', function () {

    var currow=$(this).closest('tr');
    var job_number=currow.find('td:eq(0)').text();
    if(job_number){

      $.ajax({
              type: "GET",
              url: "{{url('/job/order/add_item/edit_option')}}?job_number=" + job_number,
              success: function (data) {
                  
                  loadDepo(data[2]);
                  $('#job_order_number').val(data[1]); 
                  loadItem(data[0]);
                  $('#sc_id').val(data[3]);

              }
      });


      function loadDepo(data){
          
          if (data) {

              var $el = $('#depo_id');
              $el.html(' ');
              $.each(data, function (key, value) {
                  $el.append($("<option></option>").attr("value", value.id).text(value.d_code));
              });
              $el .selectpicker('refresh');

          }

      }

      function loadItem(data){

          if (data) {

              var $el = $('#sc_item_id');
              $el.html(' ');
              $el.append($("<option></option>").attr("value", "0").text("Select Item"));
              $.each(data, function (key, value) {
                  $el.append($("<option></option>").attr("value", value.item_id).text(value.ci_item_code+"-"+value.ci_item_name));
              });
              $el .selectpicker('refresh');

          }

      }

    }else{

        Swal.fire({ 

            title: 'Alert! Sorry You Can Not Add Item..!!',

        })

    } 


});

function addNewJobOrderItem(){

    var job_order_number=document.getElementById('job_order_number').value;
    var sc_item_id=document.getElementById('sc_item_id').value;
    var sc_id=document.getElementById('sc_id').value;
    if(sc_item_id=="0"){
      
        Swal.fire({ 

            title: 'Alert! Please Frist Select Your Item..!!',

        })

    }
    else if(job_order_number==""){
         
        Swal.fire({ 

            title: 'Alert! Sorry Something is Wrong..!!',

        }) 

    }else{

          $.ajax({
            method: 'POST',
            url: "/add_new/job_order/item",
            data: {'sc_item_id': sc_item_id,
                'job_order_number': job_order_number,
                'sc_id': sc_id,
                '_token': $('input[name=_token]').val()},
                success: function (data) {

                  console.log(data);

                   if(data=="item_exist"){

                      Swal.fire({ 

                              title: 'Alert! Item Already Exist..!!',

                      })      

                   }
                  
                   if(data=="success"){

                      Swal.fire({ 

                          title: 'Item Added Successfully..!!',

                      })

                      $('#myModal').modal('hide');
      

                   }

                   if(data=="not_approve"){

                      Swal.fire({ 

                          title: 'Item Approval Not Done..!!',

                      })

                      //$('#myModal').modal('hide');
      

                   }                        

                },
                error: function (e) {

                    console.log(e);
                }

          });   

    }

}

function cancelJobOrder(){
 
  var check = confirm("Are you sure you want to Cancel ?");  
  if(check == true){ 
   
     return true;

  }else{

     return false;
  }  

}

$('#example2').DataTable({
    "order": [[ 5, "ASC" ]],
    "lengthMenu": [[25, 50,100, -1], [25, 50,100,"All"]]
});
</script>
@endsection