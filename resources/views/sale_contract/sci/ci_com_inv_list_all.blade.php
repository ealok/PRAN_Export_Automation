@extends('layouts.master')
@section('content')
<h4 class="text-center" style="font-weight: bold;text-transform: uppercase;margin-bottom: -25px">CI COMMERCIAL INVOICE LIST</h4><p style="text-align: right;"><input type="text" placeholder="From Date" id="from_date" class="datepicker input-sm" value="@if(!empty($fromDate)){{$fromDate}}@endif">&nbsp;&nbsp;<input type="text" placeholder="To Date" id="to_date" class="datepicker input-sm" onchange="getAllComInvList()" value="@if($to_date){{$to_date}}@endif">&nbsp;&nbsp;<a href="{{url('/ci_com_inv/list/all/excel/download/'.$fromDate.'/'.$to_date)}}" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">Excel</button></a></p>
<style type="text/css">
    .table-bordered > thead > tr > th{

        border: 1px solid #919191;
    }
    .th_width_line{

         color: white;
    }

    tbody {

      overflow-x: auto;   
    }
    .table-bordered > tbody > tr > td{
      
       border: 1px solid #5e4545;
    }  
</style>
<div class="table-responsive" style="margin-top: -33px">
<input id="myInput" type="text" placeholder="Search.."> 
<table class="table table-condensed table-bordered" id="inv" width="100%" style="border: 1px solid #222">
        <thead style="font-size: 13px">
            <tr style="background: #3f5164;"> 
                <th class="th_width_line">Exp_No</th>       
                <th class="th_width_line" style="width:94px">Invoice_No</th>
                <th class="th_width_line">CO</th>
                <th class="th_width_line">Net<br>FOB</th>
                <th class="th_width_line">Total<br>Value</th> 
                <th class="th_width_line">30%<br>Insentive</th>
                <th class="th_width_line">Date</th>
                <th class="th_width_line">70%<br>Insentive</th>
                <th class="th_width_line">Date</th>
                <th class="th_width_line">100%<br>Insentive</th> 
                <th class="th_width_line">Date</th>
                <th class="th_width_line">User</th>
                <th class="th_width_line">P_Date</th> 
                <th class="th_width_line" style="text-align: center;width:200px">ACTION</th>
            </tr>
        </thead>
        <tbody id="search_data">
          <?php $i=1?>
          @if(!empty($results))
          @foreach($results as $result)
          <tr style="font-size: 10px">
              <td>{{$result->export_no}}</td>
              <td>{{$result->invoice_no}}</td> 
              <td>{{$result->code}}</td> 
              <td>{{$result->net_fob}}</td>
              <td>{{$result->total_claim}}</td> 
              <td>{{$result->Amount1}}</td> 
              <td>{{$result->date1}}</td>
              <td>{{$result->Amount2}}</td>
              <td>{{$result->date2}}</td>
              <td>{{$result->Amount3}}</td>
              <td>{{$result->date3}}</td>
              <td>{{$result->staff_id}}<br>{{$result->name}}</td>
              <td>{{$result->date}}</td> 
              <td>
                  <!-- <a href="{{url('/ci_com_inv_show/'.$result->id.'/show')}}" title="Edit" ><button type="button" class="btn btn-xs btn-success btn-flat">Show</button></a> -->
                <!--   <a href="{{url('/ci_com_inv/'.$result->id.'/edit')}}" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a> -->
                  <a href="" title="Edit" ><button type="button" class="btn btn-xs btn-success btn-flat" id="{{$result->id}}" onclick="createCaseInsentivView(this.id)" data-toggle="modal" data-target="#exampleModalCenter">Insentive</button></a>
                  <a href="" title="Edit" ><button type="button" class="btn btn-xs btn-primary btn-flat" id="{{$result->id}}" onclick="editInsentiveOpenModel(this.id)" data-toggle="modal" data-target="#exampleModalCenter2">Edit Amount</button></a>
                  <a href="" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat" id="{{$result->id}}" onclick="editOthers(this.id)" data-toggle="modal" data-target="#exampleModalCenter3">Edit</button></a>
              </td> 
          </tr>
          @endforeach
          @endif
        </tbody>
    </table>
    
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">CREATE INSENTIVE</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">PERCENTAGE:</label>
                    <select name="insentive_percentage_id" id="insentive_percentage_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                          <option value="">Select</option>
                          @foreach($insentivePercentages as $insentivePercentage)
                          <option value="{{$insentivePercentage->id}}">{{$insentivePercentage->percentage}}{{'%'}}</option>
                          @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="message-text" class="col-form-label">DATE:</label>
                    <input name="dated" type="text" id="insentive_date" class="form-control datepicker"  value=""   required autofocus placeholder="Dated"  autocomplete="off"  is_date="1" >
                    <input name="" type="hidden"  class="form-control"  value="" id="insentive_edit_id">
                  </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="saveCaseInsentiveValue()">Save</button>
            </div>
          </div>
        </div>
    </div>
    <!-------@@@@@@@@@@@@@@@@@@ Edit Amount @@@@@@@@@@@@@@@@@@@---------- -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">EDIT INVOICE AMOUNT</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Invoice No:</label>
                    <select name="invoice_id" id="invoice_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                          <option value="">Select</option>
                          @foreach($invoices as $invoice)
                          <option value="{{$invoice->id}}">{{$invoice->invoice_no}}</option>
                          @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="message-text" class="col-form-label">Amount:</label>
                    <input name="edit_amount" type="text" id="edit_amount" class="form-control allow-numeric"  value=""   required autofocus placeholder="Enter Edit Amount"  required="">
                    <input name="" type="hidden"  class="form-control"  value="" id="edit_id">
                    <span class="error" style="color: red; display: none">* Input digits (0 - 9)</span>
                  </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="editInsentiveAmount()">Edit</button>
            </div>
          </div>
        </div>
    </div>
    <!-- @@@@@@@@@@@@@@--End Edit Amount @@@@@@@@@@@@@ -->

    <!-- @@@@@@@@@@@@@@@@--Edit Ref and date---@@@@@@@@@@@@ -->
        <div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">EDIT DETAILS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <form>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Invoice No:</label>
                      <select name="ref_invoice_id" id="ref_invoice_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                            
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="message-text" class="col-form-label">Ref No:</label>
                      <input name="ref_no" type="text" id="ref_no" class="form-control"  value=""   required autofocus placeholder="Enter Edit Amount"  required="">
                      <span class="error" style="color: red; display: none">* Input digits (0 - 9)</span>
                    </div>
                    <div class="form-group">
                      <label for="message-text" class="col-form-label">Date:</label>
                      <input name="ref_date" type="text" id="ref_date" class="form-control datepicker"  value=""   required autofocus placeholder="Enter Edit Amount"  required="">
                      <input name="" type="hidden"  class="form-control"  value="" id="other_id">
                      <span class="error" style="color: red; display: none">* Input digits (0 - 9)</span>
                    </div>
                  </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editRefAndDate()">Edit</button>
              </div>
            </div>
          </div>
      </div>
    <!-- @@@@@@@@@@@@@@@@@--End-->



</div>
<script type="text/javascript">

    $(document).ready(function() {

      $(".allow-numeric").bind("keypress", function (e) {

          var keyCode = e.which ? e.which : e.keyCode

          if (!(keyCode >= 46 && keyCode <= 57) ) {

            $(".error").css("display", "inline");

            return false;

          }else{

            $(".error").css("display", "none");

          }

      });

    });

</script>
<script>


    $("#to_date").change(function(){
  
      var from_date=document.getElementById("from_date").value;
      var to_date=document.getElementById("to_date").value;
      var url = "{{url('/ci_com_inv/list/all')}}?from_date="+from_date+"&to_date="+to_date;
      window.location = url ;

    });
   

    function createCaseInsentivView(e){
         
        event.preventDefault();
        $('#insentive_edit_id').val(e);

    }

    function editInsentiveOpenModel(e){

        event.preventDefault();
        $('#edit_id').val(e);

    }

    function editOthers(e){

        event.preventDefault();
        var url = "/json/get_edit_insentive_details?insentive_percentage_id="+e;
        var $el = $('#ref_invoice_id');
        $.get(url, function(data) {

          
           if(data.allInvoices.length<0){

                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("---"));
                $el.selectpicker('destroy');

            }else{

                $el.html(' ');
                $.each(data.allInvoices, function(key,value) {

                  $el.append($("<option></option>").attr("value", value.id).text(value.name));

                });
                $el.selectpicker('refresh');
            }

            $('#ref_no').val(data.ref_num);
            $('#ref_date').val(data.date);
            $('#other_id').val(e);

            
        });
        

    }

    function saveCaseInsentiveValue(){

      var insentive_percentage_id=document.getElementById("insentive_percentage_id").value;
      var insentive_date=document.getElementById("insentive_date").value;
      var edit_id=document.getElementById("insentive_edit_id").value;
      var url = "/json/create_case_insentive?insentive_percentage_id="+insentive_percentage_id+"&insentive_date="+insentive_date+"&edit_id="+edit_id;
      var $el = $('#bank_id');
      $.get(url, function(data) {
          
          if(data=="Success"){

              $('#exampleModalCenter').modal('hide'); 
              alert("Create Success..!!");
              location.reload(true);

          }else if(data=="check"){
              
              alert("First You Have To Create 100% Or 70% Insentive..!!");
              $('#exampleModalCenter').modal('hide'); 
              location.reload(true);

          }else if(data=="Fail"){

              alert("Already Created..!!");
              $('#exampleModalCenter').modal('hide'); 

          }

      });
      
    }

    function editInsentiveAmount(){

      var edit_id=document.getElementById("edit_id").value;
      var invoice_id=document.getElementById("invoice_id").value;
      var edit_amount=document.getElementById("edit_amount").value;
      var url = "/json/edit_insentive_amount?invoice_id="+invoice_id+"&edit_amount="+edit_amount+"&edit_id="+edit_id;
      if(invoice_id==""){

          alert("Please Select Invoice No..!!");

      }else if(edit_amount==""){

          alert("Please Enter Edit Amount..!!");

      }else{

          $.get(url, function(data) {

          
              if(data=="Success"){

                  alert("Amount Edit Success..!!");
                  $('#exampleModalCenter2').modal('hide'); 
                  location.reload(true);

              }else{

                   alert("Create Fail..!!");

              }

          });  

      }

    }

    function editRefAndDate(){

        var ref_invoice_id=document.getElementById("ref_invoice_id").value;
        var ref_no=document.getElementById("ref_no").value;
        var ref_date=document.getElementById("ref_date").value;
        var url = "/json/edit_insentive_details?ref_invoice_id="+ref_invoice_id+"&ref_no="+ref_no+"&ref_date="+ref_date;
        if(ref_invoice_id==""){

          alert("Please Select Invoice No..!!");

        }else if(ref_no==""){

          alert("Please Enter Ref No ..!!");

        }else if(ref_date==""){

          alert("Please Select date..!!");

        }else{

             
           $.get(url, function(data) {
            
              if(data.status=='success'){
                  
                  
                  $('#exampleModalCenter3').modal('hide');
                  alert("Edit Successfully..!!"); 
                  location.reload(true);

              }else{

                  alert("Information Edit Fail..!!");

              }

          });     

        }    

    }
    
    var i=1;
    $(document).ready(function () {
    $("#search").keyup(function () {
        var data = $(this).val();
        $.ajax({
            method: 'get',
            url: "{{url('/json/com_inv/search')}}",
            data: {'data': data, '_token': $('input[name=_token]').val()},
            success: function (data) {

                var rows = '';
                $.each(data, function (key, value) { 
                  i++;
                  rows = rows + '<tr>';
                  rows = rows + '<td>' + value.export_no + '</td>';
                  rows = rows + '<td>' + value.invoice_no + '</td>';
                  rows = rows + '<td>' + value.code + '</td>';
                  rows = rows + '<td>' + value.net_fob + '</td>';
                  rows = rows + '<td>' + value.total_claim + '</td>';
                  rows = rows + '<td>' + value.Amount1 + '</td>';
                  rows = rows + '<td>' + value.date1 + '</td>';
                  rows = rows + '<td>' + value.Amount2 + '</td>';
                  rows = rows + '<td>' + value.date2 + '</td>';
                  rows = rows + '<td>' + value.Amount3 + '</td>';
                  rows = rows + '<td>' + value.date3 + '</td>';
                  rows = rows + '<td>' + '<button type="button" class="btn btn-xs btn-success btn-flat" id="'+value.id+'" onclick="createCaseInsentivView(this.id)" data-toggle="modal" data-target="#exampleModalCenter"> Insentive</button><button type="button" class="btn btn-xs btn-primary btn-flat" id="'+value.id+'" onclick="editInsentiveOpenModel(this.id)" data-toggle="modal" data-target="#exampleModalCenter2">Edit Amount</button><button type="button" class="btn btn-xs btn-primary btn-flat" id="'+value.id+'" onclick="editOthers(this.id)" data-toggle="modal" data-target="#exampleModalCenter3">Edit</button>' + '</td>';
                  rows = rows + '/<tr>';
                });
                $("tbody").html(rows);                     
            },
            error: function (e) {
                console.log(e);
            }

            });

        });

    });

    function exportF(elem) {

        var table = document.getElementById("inv");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Manufacturing_deshboard.xls"); // Choose the file name
        return false;
    }

</script>
<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
             
            var value = $(this).val().toLowerCase();
            $("#search_data tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });

        });
    });
</script>
@endsection    

    


