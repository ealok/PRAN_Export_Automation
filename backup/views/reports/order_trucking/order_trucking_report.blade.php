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
    left: 126px;
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
    text-align: left;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: bold;
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
  font-size: 11px;

}


.table > tbody > tr > td{
 
  padding: 1px;
  line-height: 1.42857143;
  vertical-align: top;
  font-size: 10px;
  border:1px solid;

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

/* .bootstrap-select > .dropdown-toggle.bs-placeholder {

  width: 573px;

} */

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
.bootstrap-select > .dropdown-toggle.bs-placeholder, .bootstrap-select > .dropdown-toggle.bs-placeholder:hover {
  color: #222;
  border: 1px solid #0D18B9;
  border-radius: 10px;
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
.table > thead > tr > th {
    padding: 4px;
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

hr{

  margin-top: 36px;
  margin-bottom: -20px;
  border-top: 1px solid #d7d2d2;
}

</style>
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/po')}}"><i class="fa fa-dashboard"></i></a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px">
          <div class="content">
            <form class="" role="form" method="POST" action="{{url('/get/trucking/report/details')}}">
            {{ csrf_field() }}
             <!-- /.box-body-start --> 
             <div class="box-body" style="37px"> 
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                        <label for="party_id">Party</label>
                        <select name="party_id" id="party_id" data-live-search="true" class="form-control select2 selectpicker" required type="select"  value="1" >
                            <option value="">Select Party</option>
                            @foreach($notifyParties as $notifyParty)
                            <option value="{{$notifyParty->id}}" @if(!empty($party_id)) @if($notifyParty->id==$party_id){{'selected'}}@endif @endif>{{$notifyParty->code}}-{{$notifyParty->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('party_id'))
                            <span class="help-block"><strong>{{ $errors->first('party_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('from_date') ? 'has-error' : '' }}">
                        <label for="from_date">From Date</label>
                        <input name="from_date" type="text" id="from_date" class="form-control datepicker"   value="@if(!empty($form_date)){{$form_date}}@endif"   required  placeholder="Select From Date" >
                        @if ($errors->has('from_date'))
                            <span class="help-block"><strong>{{ $errors->first('from_date') }}</strong></span>
                        @endif
                    </div>
                </div>    
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('to_date') ? 'has-error' : '' }}">
                        <label for="to_date">To Date</label>
                        <input name="to_date" type="text" id="to_date" class="form-control datepicker"   value="@if(!empty($to_date)){{$to_date}}@endif"   required  placeholder="Select To Date" >
                        @if ($errors->has('to_date'))
                            <span class="help-block"><strong>{{ $errors->first('to_date') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('po_no') ? 'has-error' : '' }}">
                        <label for="po_no">PO NO</label>
                        <select name="po_no" id="po_no" data-live-search="true" class="form-control select2 selectpicker" type="select"  value="1" >
                          <option value="">Select</option>
                        </select>
                        @if ($errors->has('po_no'))
                            <span class="help-block"><strong>{{ $errors->first('po_no') }}</strong></span>
                        @endif  
                    </div>
                </div> 
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                   <button type="submit" class="btn btn-info btn-flat" style="margin-top: 22px">submit</button>
                </div>    
             </div> 
             <!-- /.box-body -->
         </form>
          </div>
      </div>
      <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px">
        <div class="content">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Code</th>
                    <th scope="col">Party_Name</th>
                    <th scope="col">PO_NO</th>
                    <th scope="col">PO_Date</th>
                    <th scope="col">SC_NO</th>
                    <th scope="col">SC_Date</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Desk Name</th>
                    <th style="width: 12%;">Action</th>
                  </tr>
                </thead>
                <tbody>
                    <?php $i=1?>
                    @if(!empty($empty_array))
                    @foreach($empty_array as $key=>$value)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>
                            <span class="order-list-text">{{$value['code']}}</span>
                        </td>
                        <td>
                            <span class="order-list-text">{{$value['party_name']}}</span>
                        </td>
                        <td>
                            <span class="order-list-text">{{$value['po_no']}}</span>
                        </td>
                        <td>
                            <span class="order-list-text">{{$value['po_date']}}</span>
                        </td>
                        <td>
                            <span class="order-list-text">{{$value['SC_NO']}}</span>
                        </td>
                        <td>
                            <span class="order-list-text">{{$value['SC_Date']}}</span>
                        </td>
                        <td>
                            <span class="order-list-text">{{$value['User_Id']}}</span>
                        </td>
                        <td>
                            <span class="order-list-text">{{$value['desk']}}</span>
                        </td>
                        <td style="text-align: left">
                            <button type="button" class="fa fa-plus-circle text-success collapsed" data-toggle="collapse" data-target="#order-details-info-{{$key}}" aria-expanded="false" style="
                                border: none;
                                background: none;
                            "></button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <div class="collapse" id="order-details-info-{{$key}}" aria-expanded="false" style="">
                                <div class="col-md-12 order-details-table" style="/* overflow-y: scroll; /padding: 0px;/ height: 200px !important; // display: none; */">
                                    <table class="table" style="width: 100%; padding-top: 10px; padding-left: 5px; margin: 0">
                                        <thead style="position: sticky; top: 0;">
                                        <tr class="tbl_header_light">
                                            <th style="width: 20%;">Item_ID</th>
                                            <th>Item_Name</th>
                                            <th>Party_Code_Name</th>
                                            <th>Party_Item_Name</th>
                                            <th>JO_NO</th>
                                            <th>JO_Date</th>
                                            <th>Item_Qty</th>
                                            <th>Unit</th>
                                            <th>Prod_Qty</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($value['items'] as $item)
                                            <tr>
                                                <td>
                                                    <span class="order-list-text">{{$item['Item_Id']}}</span>
                                                </td>
                                                <td>
                                                    <span class="order-list-text">{{$item['Item_Name']}}</span>
                                                </td>
                                                <td>
                                                    <span class="order-list-text"></span>
                                                </td>
                                                <td style="text-align: end;">
                                                    <span class="order-list-text"></span>
                                                </td>
                                                <td style="text-align: end;">
                                                    <span class="order-list-text">{{$item['JO_NO']}}</span>
                                                </td>
                                                <td style="text-align: end;">
                                                    <span class="order-list-text">{{$item['Jo_Date']}}</span>
                                                </td>
                                                <td style="text-align: end;">
                                                    <span class="order-list-text">{{$item['Item_Qty']}}</span>
                                                </td>
                                                <td style="text-align: end;">
                                                    <span class="order-list-text">{{$item['Unit']}}</span>
                                                </td>
                                                <td style="text-align: end;">
                                                    <span class="order-list-text">{{$item['prod_qty']}}</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    <tr>
                    @endforeach  
                    @endif  
                </tbody>
              </table>
        </div>
    </div>
  </div>
</div>
<script>document.title = 'Export | Demand List';
    setTimeout(function() { 
        $('.sr-only').click();
    }, 0.0001);

    $('#party_id,#from_date,#to_date').change(function(){
       
        var party_id=$('#party_id').val();
        var from_date=$('#from_date').val();
        var to_date=$('#to_date').val();
        var po_no=$('#po_no').val();
        if(party_id!="" && from_date!="" && to_date!=""){
             
            $.ajax({

                type:'get',
                url:'/get/order/party/wise_po',
                data:{'party_id':party_id,'from_date':from_date,'to_date':to_date,'po_no':po_no},
                success:function(data){
                
                    var $el = $('#po_no');
                    if(!data.results){

                        $el.html('');
                        $el.append($("<option></option>").attr("value", "").text("---"));
                        $el.selectpicker('destroy');

                    }else{

                        $el.html(' ');
                        $el.append($("<option></option>").attr("value", "").text("Select"));
                        $.each(data.results, function(key,value) {

                            $el.append($("<option></option>").attr("value", value['ID']).text(value['PO_NO']));

                        });
                        $el.selectpicker('refresh');

                    }
                 

                }


            })

        }


    });
</script>
@endsection