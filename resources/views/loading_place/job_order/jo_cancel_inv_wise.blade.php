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
 #left_side_style{

    border: 2px solid blue;
    min-height: 440px;  
 }

 .form-control[disabled]{

  background-color: #288a37;
  
 }
 #button_grouo_id{

    position: absolute;
    left: 206px;
    top: 4px;
    z-index: 1;

 } 

 .modal-body{

  position: relative;
  top: -12px;
  padding: 18px;

 }

 .modal-header .close {

  margin-top: -22px;

 }

.modal-header {

  border-bottom-color: #cac4c4;

}

 #right_side_style{
 
  border: 2px solid blue;
  min-height: 439px;
  margin-left: 5px;  

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
.modal-title{
  text-align: center;
  font-size: 17px;
  text-transform: uppercase;
}
.modal-footer {

  padding: 14px; 
  text-align: center;
  margin-top: 181px;
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
  font-size: 10px;

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
img{

  height: 40px;
  position: absolute;
  top: -3px;
  left: 1051px;

}
.box-header.with-border {

  border-bottom: none;

}

.bootstrap-select > .dropdown-toggle.bs-placeholder {

  width: 187px;

}

.modal-body{

  width: 426px;
  margin: auto;
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

.modal-footer {
  padding: 14px;
  text-align: center;
}

#tblMain {

   display: block;

}

#po_details_table_id_wrapper{

  padding: 13px;
  width: 1015px;
  margin: auto;

}

#item_add_btn_id{

  padding: 2px 3px;
  font-weight: bold;

}

#tblMain{

  height: 358px;      
  overflow-y: auto;    
  overflow-x: hidden;  
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

hr{

  margin-top: 36px;
  margin-bottom: -20px;
  border-top: 1px solid #d7d2d2;
}

#trading_details_table_id_wrapper{

  width: 72%;
  margin: auto;
  margin-top: 10px;

}

</style>
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/jo/cancel')}}"><i class="fa fa-dashboard"></i>JO Cancel</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px">
        <div class="box-header with-border">
          <div class="col-sm-4"></div>
          <div class="col-sm-3">
              <label for="name" id="party">Invoice No :</label>
              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                  <input name="invoice_no" type="text" id="invoice_no" class="form-control input-sm" value="" required placeholder="Enter Invoice No" style="margin-left: -260px; margin-top: -4px;">
                  @if ($errors->has('sb_date'))
                      <span class="help-block"><strong>{{ $errors->first('sb_date') }}</strong></span>
                  @endif
              </div>
          </div>
          <div class="col-sm-1"><button class="btn btn-sm btn-info" style="margin-left: -258px;padding: 4px;margin-top: -3px" id="search_btn_id">Search</button></div>
        <hr>
        </div>
        <div class="panel-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive table-condenced" style="font-size: 12px">
              <thead style="font-size: 12px">
                    <tr>
                        <th>SL</th>
                        <th style="width: 84px">JO_No</th>
                        <th style="width: 100px">DO_No</th>
                        <th>Order_Qty</th>
                        <th>Sample_Qty</th>
                        <th>Create_Date</th>
                        <th>Delivery_Date</th>
                        <th>Mfg_date</th>
                        <th style="width: 144px">Create_By</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>  
              </thead>
              <tbody></tbody>
          </table>
        </div>
    </div>
  </div>
  <div class="col-md-12" id="trading_details_div_id">
    <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px;">
          <table class="table table-bordered table-responsive table-condenced"  id="trading_details_table_id">
            <thead>
              <tr style="font-size: 12px">
                  <th>#Sl</th>
                  <th>Code</th>
                  <th style="width: 700px">Name</th>
                  <th>Order_Qty</th>
                  <th>Sample_Qty</th>
                  <th>Rate/Piece</th>
                  <th>Value(USD)</th>
                  <th>Status</th>
              </tr>  
            </thead>
            <tbody></tbody>
          </table>
        <br></br>
    </div>
  </div>
</div>
<script>document.title = 'Trading | Order List';</script>
<script type="text/javascript">
  $('#trading_details_div_id').hide();
   $(document).ready(function() {

        setTimeout(function() { 

          $('.sr-only').click();

        }, 0.0001);
        
        $('#pf_id').prop('disabled', true);
        //Item Add Form Submit

        $("#search_btn_id").click(function(){
            
           var invoice_no=$('#invoice_no').val();
           if(invoice_no==""){
                
              Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Invoice Can Not Emtpy..!!',
              });

           }else{
              
            displayJODetails(invoice_no);

           }
           
           
        }); 

        function displayJODetails(invoice_no){
           
          $(".preload").show();
          $('#example1').dataTable().fnDestroy(); 
          var table = $('#example1').DataTable({
                "ajax": {
                    "url": "/json/get/invoice/jo_list",
                    "type": "GET",
                    "data": {
                       "invoice_no": invoice_no,
                       "_token": $('input[name=_token]').val()
                      },
                    "dataSrc": function (json) {

                        if(json.data.length > 0) {

                            return json.data;
                            
                        } else {

                             return false;

                        }

                    }
                },
              "columns": [
                {
                      "data": null,
                      "render": function(data, type, full, meta) {

                          return meta.row + 1;

                      }
                },
                {
                    "data": null,
                    render: function(data, type, row) {

                         return '<a href="/json/get/jo/details/'+row.id+'">'+row.jo_no+'</a>'
          
                    }
                },
                { "data": "do_no" },
                { "data": "order_qty" },
                { "data": "sample_qty" },
                { "data": "create_date" },
                { "data": "delivery_date" },
                { "data": "mfg_date" },
                { "data": "user" },
                { "data": "status" },
                { 
                  "data": null,
                  render: function(data, type, row) {

                    if(row.status=="Approved" || row.status=="Cancel") {

                      return '<input type="button" data-id="'+row.id+'" class="btn btn-danger btn-sm" value="Cancel" disabled>' 
                    
                    }else{

                      return '<input type="button" data-id="'+row.id+'" class="btn btn-danger btn-sm btn-cancel" value="Cancel">'
                      
                    }

                  }

                }  
            ],
            "language": {

               "emptyTable": "No records available"
            },
            "dataSrc": function (json) {

              if (!json.data || json.data.length === 0) {

                  return false;
              }

              return json.data;

            }

          });
          
        }

        // JO Details
        $('#example1 tbody').on('click', 'td a', function(e) {

            e.preventDefault();
            $('#trading_details_div_id').show();  
            $('#trading_details_table_id').dataTable().fnDestroy(); 
            var jo_id=$(this).data('id');
            var url = $(this).attr('href');
            var table = $('#trading_details_table_id').DataTable({
                paging: false,
                ajax:{
                      type: "GET",
                      url: url,
                      data: {'_token': $('input[name=_token]').val()},
                      "dataSrc": function (json) {
                            
                          if(json.data.length > 0) {
                              
                              return json.data;
                              
                          } else {

                              return false;

                          }

                      }
                  },
                columns: [
                  {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                  },
                  { "data": "code"},
                  { "data": "item"},
                  { "data": "orqt"},
                  { "data": "smqt"},
                  { "data": "rate"},
                  { "data": "value"},
                  { "data": "item_status"}
                ],
                "language": {

                    "emptyTable": "No records available"

                },
                "dataSrc": function (json) {

                    if (!json.data || json.data.length === 0) {

                        return false;
                    }
                    return json.data;

                }

            });

        });
  
        // Handle click Approve button
        $('#example1 tbody').on('click', '.btn-cancel', function (e) {

            var cancel_id=$(this).data('id');
            if(cancel_id){

              Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel it!'
              }).then((result) => {

                if(result.isConfirmed){

                    $.ajax({
                        url: "{{ url('/jo/soft_cancel')}}",
                        type: "get",
                        dataType: 'json',
                        data: {"cancel_id": $(this).data('id'),"_token": "{{ csrf_token() }}"},
                        success: function(res) {
                                   
                          if(res.code==200){
                            
                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: 'Cancel Successfully Done..!!',
                                  showConfirmButton: false,
                                  timer: 1500
                              });

                              var table2 = $('#example1').DataTable();
                              table2.ajax.reload();                              

                          }else if(res.code==500){
                        
                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: 'result Failed.!!',
                                  showConfirmButton: false,
                                  timer: 1500
                              }); 
                        
                          }
                          
                        }

                    }); 

                  }

              });

            }
            
        });
  
     });
</script>
@endsection