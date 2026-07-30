@extends('layouts.master')
@section('content')
<style>
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
.swal2-title {
  position: relative;
  max-width: 100%;
  margin: -5px 0 -0.6em;
  padding: 6px;
  color: #595959;
  font-size: 1.68em;
  font-weight: 600;
  text-align: center;
  text-transform: none;
  word-wrap: break-word;
  line-height: 1.5;
}
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
  border-radius: 11px;

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
.table > thead > tr > th {
  padding: 1px;
  line-height: 1.429;
  vertical-align: top;
  text-align: center;
}
.table > thead > tr > th {
  border: 1px solid #1549c4 !important;
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

label {
  display: inline-block;
  max-width: 100%;
  margin-bottom: 0px;
  font-weight: 700;
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
  color: cornflowerblue;
  border-radius: 50px;

}

#table_footer{
 
  margin-right: 48px;

}

</style>
<section class="content-header" style="padding-top: 0px;">
  <h1><small></small></h1>
  <ol class="breadcrumb">
  <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
  <li class="active"><a href="{{url('/template')}}"><i class="fa fa-dashboard"></i>PO List</a></li>
  </ol>
  <br>
</section>
<div class="row">
<div class="col-md-10 col-md-offset-1" style="position: relative">
  @if(Session::has('danger'))
  <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Failed!</strong> {{ Session::get('danger') }}
  </div> 
  @endif
  <!-- Horizontal Form -->
  <div class="box box-info" style="border-top-color: none;border: 1px solid #4e7bd7;"> <!-- /.box-header start-->
    <form class="" role="form" method="POST" action="" id="task_definition">
    {{ csrf_field() }}
    <div class="box-body">
    <div class="row">
    <div class="col-sm-12" style="margin-top: 28px">
    <span id="template_style">Purchase Order</span>
    <div class="col-sm-12" id="left_side_style">
    <div class="col-sm-3"></div>  
    <div class="col-sm-3" style="position: absolute">
      <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
          <label for="party_id">Notify Party</label>
          <select name="party_id" id="party_id" data-live-search="true" class="form-control select2 selectpicker" required>
            <option value="">Select Party</option>
            @foreach($notifyParties as $value)
                <option value="{{$value->id}}">{{$value->code}}-{{$value->name}}</option>
            @endforeach
          </select>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group {{ $errors->has('sales_contact_no') ? 'has-error' : '' }}">
          <label for="sales_contact_no">Sc/Invoice NO</label>
          <input name="sales_contact_no" type="text" id="sales_contact_no" class="form-control input-sm"   value=""   required autofocus max="191"  placeholder="Sales Contact/Invoice no" >
          @if ($errors->has('sales_contact_no'))
              <span class="help-block"><strong>{{ $errors->first('sales_contact_no') }}</strong></span>
          @endif
      </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group {{ $errors->has('sales_csales_contact_dateontract_no') ? 'has-error' : '' }}">
          <label for="sales_contact_date">Date</label>
          <input name="sales_contact_date" type="text" id="sales_contact_date" class="form-control input-sm datepicker"   value=""   required autofocus max="191"  placeholder="Select Your Date" >
          @if ($errors->has('sales_contact_date'))
              <span class="help-block"><strong>{{ $errors->first('sales_contact_date') }}</strong></span>
          @endif
      </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
          <label for="note">Note</label>
          <input name="note" type="text" id="note" class="form-control input-sm"   value=""   required autofocus max="191"  placeholder="Enter Your Note" >
          @if ($errors->has('note'))
              <span class="help-block"><strong>{{ $errors->first('note') }}</strong></span>
          @endif
      </div>
    </div>
    <div class="col-sm-3" style="position: absolute;top: 49px;width: 24%;">
      <div class="form-group {{ $errors->has('item_id') ? 'has-error' : '' }}">
          <label for="sales_contract_no">Item</label>
          <select name="item_id" id="item_id" data-live-search="true" class="form-control select2 selectpicker" required>
            <option value="">Select Item</option>

          </select>  
          @if ($errors->has('item_id'))
              <span class="help-block"><strong>{{ $errors->first('item_id') }}</strong></span>
          @endif
      </div>
    </div>
    <div class="col-sm-3"></div>
    <div class="col-sm-3">
      <div class="form-group {{ $errors->has('factor') ? 'has-error' : '' }}">
          <label for="sales_contract_no">Factor</label>
          <input name="factor" type="text" id="factor" class="form-control input-sm"   value=""   required autofocus max="191"  placeholder="Item Factor Here" >
          @if ($errors->has('factor'))
              <span class="help-block"><strong>{{ $errors->first('factor') }}</strong></span>
          @endif
      </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group {{ $errors->has('rate') ? 'has-error' : '' }}">
          <label for="rate">Rate Per_Ctn</label>
          <input name="rate" type="text" id="rate" class="form-control input-sm allow_decimal"   value=""   required autofocus max="191"  placeholder="Item Rate Here" >
          @if ($errors->has('rate'))
              <span class="help-block"><strong>{{ $errors->first('rate') }}</strong></span>
          @endif
      </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group {{ $errors->has('order_qty') ? 'has-error' : '' }}">
          <label for="order_qty">Order Qty(CTN)</label>
          <input name="order_qty" type="text" id="order_qty" class="form-control input-sm numberonly"   value=""   required autofocus max="191"  placeholder="Order Quantity Here" >
          @if ($errors->has('order_qty'))
              <span class="help-block"><strong>{{ $errors->first('order_qty') }}</strong></span>
          @endif
      </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group {{ $errors->has('specifications') ? 'has-error' : '' }}" >
          <label for="specifications">Specifications</label>
          <textarea class="form-control input-sm" rows="1" cols="3" placeholder="Item Specifications Here" id="specifications" name="specifications"></textarea>
          @if ($errors->has('specifications'))
              <span class="help-block"><strong>{{ $errors->first('specifications') }}</strong></span>
          @endif
      </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
          <label for="sales_contract_no">Choose File</label>
          <input name="file_upload" type="file" id="file_upload" class="form-control input-sm"   value=""   required autofocus max="191"  placeholder="Sales contract no" >
          @if ($errors->has('sales_contract_no'))
              <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
          @endif
      </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
          <input type="button" class="form-control input-sm btn btn-primary" value="Load Item" style="margin-top: 21px;width: 86px;" onclick="upload()">
          <input type="button" class="form-control input-sm btn btn-info add-row" value="+Add Item" style="width: 86px;margin-top: -52px;margin-left: 92px;">
          <input type="button" class="form-control input-sm btn btn-success" value="Download" id="download_btn_id" style="width: 88px;margin-top: -92px;margin-left: 184px;">
      </div>
    </div> 
    <div class="col-sm-12" style="border-top: 1px solid #c6b6b6;margin-bottom: 5px;margin-top: -14px;"></div>
     <div class="row" style="margin-top: 10px">
        <div class="col-sm-12">
            <table class="table table-bordered" id="item_table">
                <thead>
                    <tr>
                        <th>Check</th>
                        <th>Item</th>
                        <th>Factor</th>
                        <th>Rate_Per_Ctn</th>
                        <th style="width: 80px">Order_Qty(CTN)</th>
                        <th>Specifications</th>
                    </tr>
                </thead>
                <div class="preload">
                    <img src="{{asset('/img/loading_spinner.gif')}}"/>
                </div>
                <tbody id="display_excel_data">

                </tbody>
            </table>
            <div id="table_footer">
              <p style="position: absolute;font-size: 14px;font-weight: bold;">Total Rows: <span id="rowCountId"></span></p>
              <button type="button" class="delete-row btn-success pull-right" id="clearTableId" style="margin-left: 7px;background-color: black">Clear Table</button>
              <button type="button" class="delete-row btn-success pull-right" id="submit_button" style="margin-left: 7px">Save Row</button>
              <button type="button" class="delete-row btn-danger pull-right">Delete Row</button>
            </div>
        </div>
      </div> 
    </form>       
  </div> 
</div>
<!-- /.box -->  
</div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'PO Create';</script>
<script type="text/javascript">
$(document).ready(function(){
   
  setTimeout(function() { 
    $('.sr-only').click();
  }, 0.0001);

  $("#submit_button").click(function(){

        var rowCount = $('#template_table tr').length;
        if(rowCount>1){

              var template_type=$("#template_type").val();
              var description=$("#description").val();
              var remark=$("#remark").val();
              var mail=$('input[name="mail"]:checked').val();
              var matching_info = new Array();
              $("#template_table TBODY TR").each(function () {
                  var row = $(this);
                  var dist_info = {};
                  dist_info.sequance = row.find("TD").eq(0).html();
                  dist_info.task_description = row.find("TD").eq(1).html();
                  dist_info.dependent_task_id = row.find("TD").eq(2).html();
                  dist_info.standard_day = row.find("TD").eq(4).html();
                  dist_info.lay_day = row.find("TD").eq(5).html();
                  dist_info.task_id = row.find("TD").eq(6).html();
                  dist_info.default_uid = row.find("TD").eq(7).html();
                  matching_info.push(dist_info);
              });

        $.ajax({

            method: 'POST',
            url: "/template",
            data: {
              'template_type': template_type,
              'description': description,
              'remark':remark,
              'mail':mail,
              'matching_info':matching_info,
              '_token': $('input[name=_token]').val()
            },
            success: function (response) {

                  console.log(response);

                  if(response.status=='success'){

                      Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'Template Create Successfully',
                      showConfirmButton: false,
                      timer: 1500
                      });

                      $('#task_definition').trigger("reset");
                      $('#task_id').selectpicker('refresh');
                      $('#assign_id').selectpicker('refresh');
                      $('#template_type').selectpicker('refresh');
                      $("#template_body_id").empty();

                  }

            },
            error: function (e) {

                console.log(e);

            }

        });


      }else{

      // Swal.fire({ 

      //     title: 'Alert ! <br> Atleat you have to added one task..!!',

      // });

      } 


  });
   
  $("#party_id").change(function(){

    var party_id=$(this).val();
    var $el = $('#item_id');
    $.ajax({

        method: 'GET',
        url: "/json/get_item_of_notify_party",
        data: {
          'notify_party_id': party_id,
          '_token': $('input[name=_token]').val()
        },
        success: function (data) {

          if(!data){

                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("---"));
                $el.selectpicker('destroy');

          }else{

                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function(key,value) {

                    $el.append($("<option></option>").attr("value", value.ci_item_code).text(value.ci_item_code+'-'+value.ci_item_name));

                });
                $el.selectpicker('refresh');

          }

        },
        error: function (e) {

            console.log(e);

        }

        });

  }); 
   
  $("#item_id").change(function(){

    var item_code=$(this).val();
    var party_id=$('#party_id').val();
    $.ajax({

        method: 'GET',
        url: "/json/code_wise/item_details",
        data: {
          'notify_party_id': party_id,
          'ci_item_code':item_code,
          '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            
          $('#factor').val(data.factor);
          $('#rate').val(data.party_rate);

        },
        error: function (e) {

            console.log(e);

        }

    });

  });
  
  $('#download_btn_id').click(function(){
          
      var party_id=$('#party_id').val();
      if(party_id==""){
        
          Swal.fire({ 

            title: 'Alert!<br>Please Select Your Party..!!',

          });

      }else{
          
        // var url = url: "/json/excel/download/party_item" + party_code;
        // window.open(url, '_blank');
        var url ="{{url('/json/excel/download/party_item')}}?party_id="+party_id;
        window.open(url, '_blank');

      }
      

  });

  $(".add-row").click(function(){

      var item_code=$("#item_id").val();
      var item_name= $("#item_id option:selected").text();
      var factor=$("#factor").val();
      var rate=$("#rate").val();
      var order_qty = $("#order_qty").val();
      var specifications = $("#specifications").val();
      var rowCount = $("#display_excel_data tr").length;
      if(rowCount==0){
           
          var status=checkValidation(item_id,factor,rate,order_qty,specifications);
          if(status==true){
            
             plotRow(item_code,item_name,factor,rate,order_qty,specifications); 

          }

      }else{
           
          var plot_status=0;
          var item_arrays = [];
          $("#item_table TBODY TR").each(function () {

              var row = $(this);
              var td_item_code = row.find("td:eq(1) input[type='text']").val();
              item_arrays.push(td_item_code);
            
          });
            
          var status=0;
          for(var i=0; i<item_arrays.length; i++){
             
            if(item_code == item_arrays[i]){

              status = 1;
              break;

            }

          }

          if(status){
                
              Swal.fire({ 

                  title: 'Alert!<br>This Item Already Added..!!',

                }); 

          }else{
            
            plotRow(item_code,item_name,factor,rate,order_qty,specifications); 
 
          }

      }


  });

  function plotRow(item_code,item_name,factor,rate,order_qty,specifications){

      var markup = "<tr style='background-color: yellow;font-size: smaller;'><td>"+'<input type="checkbox" name="record">'+"</td><td style='display:none'>"+'<input type="text" value="'+item_code+'" id="item_code">'+"</td><td>" + item_name + "</td><td>"+'<input type="text" value="'+factor+'" style="width:80px">'+"</td><td>" + '<input type="text" value="'+rate+'" style="width:80px">'+ "</td><td>" +'<input type="text" value="'+order_qty+'" style="width:80px">'+"</td><td>"+'<input type="text" value="'+specifications+'" style="width:100px">'+"</td></tr>";
      $("table tbody").append(markup);
      Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Item Added Successfully..!!',
          showConfirmButton: false,
          timer: 1500
      });  
      
      countTotal();
      resetForm();
    
  }

  function resetForm(){
    
    $('#item_id').val('').selectpicker('refresh');
    $('#factor').val('');
    $('#rate').val('');
    $('#order_qty').val('');
    $('#specifications').val('');

  };

  function countTotal(){
   
    $('#rowCountId').html($("#display_excel_data tr").length); 

  }
 
  //@@@@@--Get Only Number--@@@@@@@@ 
    $('.numberonly').keypress(function (e) {    
      
         var charCode = (e.which) ? e.which : event.keyCode    
         if (String.fromCharCode(charCode).match(/[^0-9]/g))    
      
            return false;                        
      
    });//@@@@@--End---

  //@@@@@--Get Number with point--@@@@@@@@ 
         
  $(".allow_decimal").on("input", function(evt) {

      var self = $(this);
      self.val(self.val().replace(/[^0-9\.]/g, ''));
      if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
      {
        evt.preventDefault();
      }

  });   

  //@@@@@--End---

  function checkValidation(item_id,factor,rate,order_qty,specifications){
         
      if(item_id==""){
         
          Swal.fire({ 

            title: 'Alert!<br>Please Select Your Item..!!',

          });
          
          return false;

      }else if(factor==""){

        Swal.fire({ 

           title: 'Alert!<br>Factor Can not Empty..!!',

        }); 

        return false;

      }else if(rate==""){
        
        Swal.fire({ 

           title: 'Alert!<br>Rate Can not Empty..!!',

        }); 

        return false;

      }else if(order_qty==""){

          Swal.fire({ 

              title: 'Alert!<br>Order Qty Can not Empty..!!',

          });  

          return false;

      }else if(specifications==""){
           
          Swal.fire({ 

              title: 'Alert!<br>Specifications Can not Empty..!!',

          }); 

          return false;

      }

      return true;

  }

  // Find and remove selected table rows
  $(".delete-row").click(function(){
    $("table tbody").find('input[name="record"]').each(function(){
      if($(this).is(":checked")){

          $(this).parents("tr").remove();
          
      }
    });
    
    countTotal();
 
  });

  $("#clearTableId").click(function(){
     
    $(".preload").show(); 
    $('#item_table tbody').empty();
    $(".preload").hide();
    countTotal();

  });

});
</script>
<script type="text/javascript">

  $(".preload").hide();
  function upload() {
      var files = document.getElementById('file_upload').files;
      if(files.length==0){

          alert("Please choose any file...");
          return;

       }
       var filename = files[0].name;
       var extension = filename.substring(filename.lastIndexOf(".")).toUpperCase();
       if (extension == '.XLS' || extension == '.XLSX') {
           
            excelFileToJSON(files[0]);
            $(".preload").show();

        }else{

           alert("Please select a valid excel file.");

        }
  }
   //Method to read excel file and convert it into JSON 
   function excelFileToJSON(file){
          try {
            var reader = new FileReader();
            reader.readAsBinaryString(file);
            reader.onload = function(e) {
 
                var data = e.target.result;
                var workbook = XLSX.read(data, {
                    type : 'binary'
                });
                var result = {};
                var firstSheetName = workbook.SheetNames[0];
                //reading only first sheet data
                var jsonData = XLSX.utils.sheet_to_json(workbook.Sheets[firstSheetName]);
                //displaying the json result into HTML table
                displayJsonToHtmlTable(jsonData);
                }
            }catch(e){
                console.error(e);
            }
    }

    //Method to display the data in HTML Table
    function displayJsonToHtmlTable(jsonData){

        var table=document.getElementById("display_excel_data");
        if(jsonData.length>0){

          var markup='';
          var item_arrays = [];
          $("#item_table TBODY TR").each(function () {

              var row = $(this);
              var td_item_code = row.find("td:eq(1) input[type='text']").val();
              item_arrays.push(td_item_code);
            
          });
           
          if(item_arrays.length==0){

            for(var i=0;i<jsonData.length;i++){

                var row=jsonData[i];
                var item=row["Item_Code"]+'-'+row["Name"];
                var order_qty=0;
                var Specifications="";
                if(row["Order_Qty_Ctn"]==undefined){

                  order_qty="";

                }else{

                  order_qty=row["Order_Qty_Ctn"];

                }

                if(row["Specifications"]==undefined){

                  Specifications="";

                }else{

                  Specifications=row["Specifications"];

                }
                markup+='<tr style="background-color: #c6f9e8;font-size: smaller;"><td>'+"<input type='checkbox' name='record'>"+'</td><td style="display:none">'+'<input type="text" value="'+row["Item_Code"]+'" id="item_code">'+'</td><td>'+item+'</td><td>'+'<input type="text" value="'+row["Factor"]+'" style="width:80px">'+'</td><td>'+'<input type="text" value="'+row["Rate_Per_Ctn"]+'" style="width:80px">'+'</td><td>'+'<input type="text" value="'+order_qty+'" style="width:80px">'+'</td><td>'+'<input type="text" value="'+Specifications+'" style="width:100px">'+'</td></tr>';

            }
            
            $("table tbody").html(markup);
            $(".preload").hide();
            countRow();

          }else{

              for(var i=0;i<jsonData.length;i++){ 
                   
                var row=jsonData[i];
                var item_code=row["Item_Code"];
                var item=row["Item_Code"]+'-'+row["Name"];
                var printStatus=0;
                for(var j=0; j<item_arrays.length; j++){
             
                    if(item_code == item_arrays[j]){

                      printStatus=0  
                      break;
        
                    }else{

                      printStatus=1;
                      
                    }
 
                }
               
                if(printStatus==1){
                 
                  plotRow(row,item); 

                }
               
               
              }

              function plotRow(row,item){
                   
                  markup+='<tr style="background-color: #c6f9e8;font-size: smaller;"><td>'+"<input type='checkbox' name='record'>"+'</td><td style="display:none">'+'<input type="text" value="'+row["Item_Code"]+'" id="item_code">'+'</td><td>'+item+'</td><td>'+'<input type="text" value="'+row["Factor"]+'" style="width:80px">'+'</td><td>'+'<input type="text" value="'+row["Rate"]+'" style="width:80px">'+'</td><td>'+'<input type="text" value="'+row["Order_Qty"]+'" style="width:80px">'+'</td><td>'+'<input type="text" value="'+row["Specifications"]+'" style="width:100px">'+'</td></tr>';
                  $("table tbody").append(markup); 
                  markup="";
                  countRow();
                  

              }
               
          }
          
          function countRow(){
               
            $('#rowCountId').html($("#display_excel_data tr").length);

          }

          Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Item Loaded Successfully..!!',
              showConfirmButton: false,
              timer: 1900
          })
          $(".preload").hide();

        }else{

            table.innerHTML='There is no data in Excel';

        }

     }
</script>
@endsection