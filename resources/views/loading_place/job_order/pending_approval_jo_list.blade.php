
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
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/job_order/create')}}"><i class="fa fa-dashboard"></i>Pending SC List</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12" style="font-size: 11px">
      <div class="box box-primary" style="background: rgba(206, 201, 201,); border-top-color: #e3e5e6;position: relative; width: 100%"> 
        <div class="panel-body table-responsive" style="border: 3px solid #c67520;">
            <div class="col-sm-12">
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
                <table class="table table-bordered table-responsive table-condenced">  
                <span>All&nbsp;&nbsp;&nbsp;<input type="checkbox" id="chk" onclick="checkAll('chk')";></span>
                <button style="margin: 5px;" class="btn btn-danger btn-xs delete-all" data-url="">Approve</button>
                <input id="myInput" type="text" placeholder="Search..">
                <thead style="color: #3c2608;">
                      <tr>
                          <th width="3px">SL</th>
                          <th style="text-align: center;background: #1ebd82">Item_Name</th>
                          <th style="text-align: center;background: #1ebd82">Item_Code</th>
                          <th style="text-align: center;background: #1ebd82">BU</th>
                          <th style="text-align: center;background: #1ebd82">Rate/pcs</th>
                          <th style="text-align: center;background: #1ebd82">Prime_Cost</th>
                          <th style="text-align: center;background: #1ebd82">Difference</th>
                          <th style="text-align: center;background: #1ebd82">Action</th>
                      </tr>  
                  </thead>
                  <tbody id="myTable">
                        @foreach($sale_contracts as $sale_contract) 
                         <?php $i=1;$lenght=1; $item="";?>
                            @foreach($sale_contract->sale_contract_details as $sale_contact_detail)
                              @if($sale_contact_detail->rate_status=="M")
                                  <?php $item=$item.$sale_contact_detail->ci_item->ci_item_code.",";?>
                              @endif
                            @endforeach
                            @if($sale_contract->sale_contract_details->first()->count()>1)
                              <tr style="background: #bdbdbd7a;">
                                <td><input type="checkbox" name="chk" value="{{$sale_contract->id}}"></td>
                                <td colspan="7"><strong style="font-size: 11px;text-transform: uppercase;">Invoice: {{$sale_contract->invoice_no}}, Country : {{$sale_contract->notify_pary->country}}, User: {{$sale_contract->user->name}}</strong></td>
                                <td colspan="4" style="display: none;">{{$item}}</td>
                              </tr>
                            @endif
                            @foreach($sale_contract->sale_contract_details as $sale_contact_detail)
                              @if($sale_contact_detail->rate_status=="M" || $sale_contact_detail->rate_status=="E")
                               <tr>
                                  <td>{{$i++}}</td>
                                  <td>{{$sale_contact_detail->ci_item->ci_item_name}}</td>
                                  <td>{{$sale_contact_detail->ci_item->ci_item_code}}</td>
                                  <td>{{$sale_contact_detail->bu->name}}</td>
                                  <td>{{$sale_contact_detail->per_piece_rate}}</td>
                                  <td>{{$sale_contact_detail->prime_cost}}</td>
                                  <td>{{$sale_contact_detail->rate_percent}}%</td>
                                  <td><span>X</span></td>
                                  <td style="display: none;">{{$sale_contract->invoice_no}}</td>
                                  <td style="display: none;">{{$sale_contract->user->name}}</td>
                                  <td style="display: none;">{{$sale_contract->notify_pary->country}}</td> 
                               </tr>
                              @endif 
                            @endforeach
                        @endforeach  
                  </tbody>
                </table>
              </div> 
            </div>
           </div> 
        </div>
        <label for="name" style="position: absolute;top: -21px;left: 40px;width: 252px;height: 23px;text-align: center;padding: 11px 15px 30px 18px;background: darkorange;color: black;border-radius: 20px;">SC Approval List(MD)</label>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
  <form class="form-horizontal" id="delete_modal_form" role="form" method="POST" action="">
    {{ csrf_field() }}
    {{ method_field("DELETE") }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete item</h4>
      </div>
      <div class="modal-body">
        <h4>Do you want to delete This item ??</h4>
        <input id="delete_id" type="hidden" name="id">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-info pull-left" >Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
    </form>
  </div>
</div>
<script>document.title = 'SC Approval List';</script>
<script type="text/javascript">
   
   setTimeout(function() { 

$('.sr-only').click();

}, 0.0001); 

  function deleteItem(delId,ab){
      
      var a= 0;
      Swal.fire({
          title: 'Are you sure ??',
          text: "Do you want to delete..??",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then(function(isConfirm) {

            if(isConfirm.value==true){

                $.ajax({

                    method: 'POST',
                    url: "/delete/job_order/approval_item",
                    data: {'delete_id': delId,'_token': $('input[name=_token]').val()},
                    success: function (data) {
                            
                       if(data=='yes'){
                          
                          Swal.fire({

                             title: 'Item Deleted Successfully..!!',

                          }) 

                          $(ab).closest('tr').remove();

                       }

                        

                    },
                  error: function (e) {

                        console.log(e);
                  }

                });


               
            }            

        });

      //setTimeout(myfun, 5000);
     
  } 

  function myfun(){
     
      console.log('calling......0');
     $("#myTable").on('click','.btnDelete',function(){

       $(this).closest('tr').remove();

     });


  }



  $(document).ready(function(){

    $("#myInput").on("keyup", function() {

      var value = $(this).val().toLowerCase();
      
      $("#myTable tr").filter(function() {

        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

      });

    });

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
           
           alert("Please Select At least One..!!");

        }else{
           
           var r = confirm("Are You Sure..??");
           if (r == true) {
            
              var url = "{{url('/approve/pending/job_order_md')}}?ids="+ids;
              $.get( url, function(data) {

                  if(data=="success"){

                     alert("Approve Done..!!");

                  }

                  location.reload();
                
              }); 


            } else {

              return false;

            }  

        }
         
    });
        
  });
</script>
@endsection