@extends('layouts.master')
@section('content') 
<style>
  .form-control {

      display: block;
      width: 100%;
      height: 24px;
      padding: 0px 5px;
      font-size: 14px;
      line-height: 1.42857143;
      color: #555;
      background-color: #fff;
      background-image: none;
      border: 1px solid #ccc;
      border-top-color: rgb(204, 204, 204);
      border-right-color: rgb(204, 204, 204);
      border-bottom-color: rgb(204, 204, 204);
      border-left-color: rgb(204, 204, 204);
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
      box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
      -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
      -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
      transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
  
   }
   .swal2-popup {
      display: none;
      position: relative;
      box-sizing: border-box;
      flex-direction: column;
      justify-content: center;
      width: 38em;
      max-width: 100%;
      padding: 1.25em;
      border: none;
      border-radius: .3125em;
      background: #fff;
      font-family: inherit;
      font-size: 1rem;
      height: 200px;
  }
  .swal2-title {
      position: relative;
      max-width: 100%;
      margin: 0 0 .4em;
      padding: 0;
      color: #595959;
      font-size: 1.875em;
      font-weight: 600;
      text-align: center;
      text-transform: none;
      word-wrap: break-word;
      line-height: .8cm;
  }
   .form-control{

      border: 1px solid #26663f;

   }
   .bootstrap-select > .dropdown-toggle {
      width: 72%;
      padding-right: 25px;
      z-index: 1;
      height: 21px;
      border: 1px solid;
      padding: 2px 2px 2px 10px;
      left: 87px;
    }
   .form-group {
  
     margin-bottom: 0px;
  
   }
   #left_side_style{
  
      border: 2px solid blue;
      min-height: 483px;  
   }
  
   #right_side_style{
   
    border: 2px solid blue;
    min-height: 483px;
    margin-left: 5px;  
  
  }
  .dropdown-menu {
    
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    float: left;
    padding: 5px 0;
    margin: 2px 87px 0;
    font-size: 14px;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.15);
    border-top-color: rgba(0, 0, 0, 0.15);
    border-right-color: rgba(0, 0, 0, 0.15);
    border-bottom-color: rgba(0, 0, 0, 0.15);
    border-left-color: rgba(0, 0, 0, 0.15);
    border-radius: 4px;

  }

  .location{
    margin-top: 26px;
  }
  .edlocation{
    margin-top: 22px;
  }
  #party{
    margin-top: 4px;
    position: absolute;
    z-index: 999;
  }
  .eparty{
    margin-top: -5px;
  }
  .item{

    margin-top: 45px;
  }
  .eitem{
    margin-top: 45px;
  }

  .btn-default {
  
  background-color: #FFFFFF;
  
  }
  .btn dropdown-toggle btn-default{
  
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
    z-index: 9999999;
    transform:translate(-50%, -50%);
  }
  img{
  
    height: 386px;
  
  }

.table > thead:first-child > tr:first-child > th {
  
  border: 1px solid #222;

}

.table-bordered > tbody > tr > td{

 border: 1px solid #222;

}
table.dataTable thead th{
  padding: 3px 0px;
  font-size: 11px;
}

.table > tbody > tr > td{
 
  padding: 1px;
  line-height: 1.42857143;
  vertical-align: top;
  font-size: 9px

}
  
  .table-bordered > tbody > tr > td{
    
    border: 1px solid #201f1f;
    padding: 1px;
    font-weight: bold;
  
  }

  .table-bordered > tbody > tr:hover{
  
    background-color: rgba(101, 212, 97, 0.836);
  }
  
  .form-horizontal .form-group {
  
    margin-right: 0px;
    margin-left: 0px;
  
  }
  .modal-content{
  
    width: 1024px;
    margin-left: -130px;
    margin-top: -19px;
    font-family: initial;

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
    border-bottom: 1px solid #cccc;;
    font-weight: bold;
  }
  .box.box-primary {
  
    border-top-color: #FFFFFF;
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
  
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
  .party_style_id{

    margin-top: 3px;
    width: 101% !important;

  }
  #tblMain {
  
     display: block;
  
  }
  
  #tblMain{
  
    height: 358px;      
    overflow-y: auto;    
    overflow-x: hidden;  
  }
  .party{width: 17px;}
  .item{width: 20px;}
  .item_names{width: 350px;text-align: center}
  .country{width: 28px;}
  .region{width: 25px;}
  .loc{width: 19px;}
  .cont_size{width: 35px;}
  .rate{width: 25px;}
  .fobs{width: 55px;}
  .prime_cost{width: 51px;}
  .oh_cost{width: 46px;}
  .total_cost{width: 53px}
  .gps{width:33px}
  .date{width: 75px;}
  .action{}

</style>
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/costing')}}"><i class="fa fa-dashboard"></i>Costing List</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <div class="col-sm-3">
            <label for="name" id="party">Party :</label>
            <select name="party_code" id="search_party_code" data-live-search="true" class="form-control select2 selectpicker input-sm party_style_id"  type="select"  value="1">
              <option value="">Select</option>
              @foreach($parties as $party)
              <option value="{{$party->code}}">{{$party->code}} / {{$party->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-sm-offset-7 col-sm-2">
            <button type="button" class="btn btn-sm btn-success pull-right btn-flat" id="create_btn">Create Costing</button>
          </div>  
        </div>
        <div class="panel-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive table-condenced">
              <thead>
                  <tr>
                      <th class="party" tabindex="0" aria-label="Item Name">Party</th>
                      <th class="item" tabindex="0" aria-label="Item Name">Item</th>
                      <th class="item_name" tabindex="0" aria-label="Item Name">Item_Name</th>
                      <th class="country" tabindex="0" aria-label="Item Name">Country</th>
                      <th class="region" tabindex="0" aria-label="Item Name">Region</th>
                      <th class="loc" tabindex="0" aria-label="Item Name">Loc</th>
                      <th class="cont_size" tabindex="0" aria-label="Item Name">CTR_Size</th>
                      <th class="rate" tabindex="0" aria-label="Item Name">Rate</th>
                      <th class="fob" tabindex="0" aria-label="Item Name" style="width: 55px">FOB/PCS</th>
                      <th class="fob" tabindex="0" aria-label="Item Name" style="width: 55px">FOB/CTN</th>
                      <th class="prime_cost" tabindex="0" aria-label="Item Name">Prime_Cost</th>
                      <th class="total_cost" tabindex="0" aria-label="Item Name">Total_Cost</th>
                      <th class="gp" tabindex="0" aria-label="Item Name" style="width: 38px">GP%</th>
                      <th class="date" tabindex="0" aria-label="Item Name">Updated_Date</th>
                      <th class="action" tabindex="0" aria-label="Item Name" style="width: 120px;">&nbsp;&nbsp;&nbsp;Action&nbsp;&nbsp;&nbsp;</th>
                  </tr> 
              </thead>
              <tbody>
                  
              </tbody>
          </table>
        </div>
    </div>
  </div>
</div>
<!-- Create Modal -->
<div id="createModel" class="modal fade" role="dialog">
    <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" style="border-bottom: 1px solid #cccc;">COSTING CREATE FORM</h4>
            </div>
            <div class="modal-body">
                    <div class="box-body" style="margin-top: -25px">
                      <div class="row">
                          <div class="col-sm-12"> 
                              <div class="col-sm-4" id="left_side_style">
                                <span id="po_details_style">Info Details</span>
                                <br>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;z-index: 999;left: 15px;">Party:</label>
                                  <select name="party_code" id="party_code" data-live-search="true" class="form-control select2 selectpicker input-sm party" autofocus type="select"  value="1" onchange="getPartyInfo(this)">
                                    <option value="">Select</option>
                                    @foreach($parties as $party)  
                                      <option value="{{$party->code}}">{{$party->code}}/{{$party->name}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 41px;left: 15px;">Country:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="country"  id="country" class="form-control input-sm" style="position: absolute;width: 206px;top: 40px;left: 102px;" placeholder="Auto Select Country Name" readonly>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position:absolute;top: 65px;left: 15px;">Region:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="region"  id="region" class="form-control input-sm" style="position: absolute;width: 80px;left: 102px;top: 65px;height:21px;" placeholder="Region" readonly>
                                  </div>
                                  <label for="name" style="position: absolute;left:183px;top: 66px;">Zone:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="zone"  id="zone" class="form-control input-sm" style="position: absolute;width: 85px;left: 223px;top:65px;height:21px;" value="" placeholder="Zone" readonly>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('item_code') ? 'has-error' : '' }}">
                                  <label for="name" style="top: 89px;left: 15px;position: absolute;z-index: 999;">Item:</label>
                                  <div class="form-group{{ $errors->has('item_code') ? 'has-error' : '' }}">
                                    <select name="item_code" id="item_code" data-live-search="true" class="form-control select2 selectpicker input-sm item" required autofocus type="select"  value="1" style="margin-top: 96px;height:21px;" onchange="getItemInfo(this)">
                                       <option value="">Select</option>
                                    </select>
                                  </div> 
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;left: 15px;top: 115px;">BU:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="bu"  id="bu" class="form-control input-sms" style="position: absolute;width: 207px;left: 102px;top: 115px;height:21px;" placeholder="BU Name" readonly>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 140px;z-index: 999;">Location:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <select name="location" id="location" data-live-search="true" class="form-control select2 selectpicker input-sm location" required autofocus type="select"  value="1" style="margin-top: 96px;height:21px;">
                                        <option value="">Select</option>
                                        @foreach($locations as $location)
                                        <option value="{{$location->id}}">{{$location->name}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 164px;">Sales Term:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <select style="position: absolute;width: 206px;left: 102px;top:165px;height:21px;" class="form-control" name="sales_term" id="sales_term">
                                       <option value="" selected="selected">Select</option>
                                       @foreach($sales_term as $value)
                                       <option value="{{$value->name}}" @if($value->name=='FOB'){{'Selected'}}@endif>{{$value->name}}</option>
                                       @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 188px;">Container Size:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <select style="position: absolute;width: 111px;left: 197px;top:188px;height:21px;" class="form-control input-sm" name="container_size" id="container_size">
                                      <option value="" selected="selected">Select</option>
                                       @foreach($container_size as $value)
                                       <option value="{{$value->name}}">{{$value->name}}</option>
                                       @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 211px;">CTN/Container:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="ctn_per_container"  id="ctn_per_container" class="form-control input-sm" style="position: absolute;width: 110px;left: 198px;top:211px;height:21px;" placeholder="CTN Per Container" onkeyup="totalPCSContainer();calculateCosting();calCFROrCIF()">
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 234px;">PCS/Container:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="pcs_per_container"  id="pcs_per_container" class="form-control input-sm" style="position: absolute;width: 110px;left: 198px;top:234px;height:21px;" placeholder="PCS per container" onkeyup="totalCTNContainer();calculateCosting();calCFROrCIF()">
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 257px;">PCS/CTN:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="pcs_per_ctn"  id="pcs_per_ctn" class="form-control input-sm" style="position: absolute;width: 110px;left: 198px;top:257px;height:21px;" placeholder="Carton Factor" onkeyup="calculateTotalPcsCTN();calculateCosting()" readonly>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 280px;">Container Category:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <select style="position: absolute;width: 110px;left: 198px;top:280px;height:21px;" class="form-control input-sm" name="container_category" id="container_category" onkeyup="calculateCosting()">
                                       <option value="" selected="selected">Select</option>
                                       @foreach($container_cat as $value)
                                       <option value="{{$value->name}}">{{$value->name}}</option>
                                       @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 303px;">Carrying Chg/Ctr:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="carriage_per_container"  id="carriage_per_container" class="form-control" style="position: absolute;width: 109px;left: 198px;top:303px;height:21px;" placeholder="Carriage Chg" value="" onkeyup="calculateCosting()">
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 326px;">C&F Chg/Ctn:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="c_and_f_charge"  id="c_and_f_charge" class="form-control" style="position: absolute;width: 109px;left: 198px;top:326px;height:21px;" placeholder="C&F Expenses" value="" onkeyup="calculateCosting()">
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 349px;">Depot Chg/Ctr:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="depot_exp"  id="depot_exp" class="form-control" style="position: absolute;width: 108px;left: 198px;top:349px;height:21px;" placeholder="Enter Depot Chg" value="" onkeyup="calculateCosting()" onchange="calculateCosting()">
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 372px;">Doc/Stamp/Bank Chg:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="coln_chg_id"  id="coln_chg_id" class="form-control" style="position: absolute;width: 108px;left: 198px;top:372px;height:21px;" placeholder="Collection Chg" value="" onkeyup="calculateCosting()">
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 395px;">Insight Gift:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="inside_gift_id"  id="inside_gift_id" class="form-control" style="position: absolute;width: 108px;left: 198px;top: 395px;height:21px;" placeholder="insight gift" value="" onkeyup="calculateCosting()">
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 418px;">Others:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="others_id"  id="others_id" class="form-control" style="position: absolute;width: 108px;left: 198px;top: 418px;height:21px;" placeholder="Others" value="" onkeyup="calculateCosting()">
                                  </div>
                                </div>
                                <div class="cif_cfr_div_id">
                                  <div class="form-group {{ $errors->has('freight_chg') ? 'has-error' : '' }}">
                                    <label for="name" style="position: absolute;top: 440px;">Freight Chg:</label>
                                    <div class="form-group{{ $errors->has('freight_chg') ? 'has-error' : '' }}">
                                      <input type="text" name="freight_chg"  id="freight_chg" class="form-control" style="position: absolute;width: 56px;left: 98px;top: 440px;height:21px;" placeholder="Freight Chg" value="" onkeyup="calCFROrCIF()">
                                    </div>
                                  </div>
                                  <div class="form-group {{ $errors->has('ins_chg') ? 'has-error' : '' }}">
                                    <label for="name" style="position: absolute;top: 440px;left:157px">Ins Chg:</label>
                                    <div class="form-group{{ $errors->has('ins_chg') ? 'has-error' : '' }}">
                                      <input type="text" name="ins_chg"  id="ins_chg" class="form-control" style="position: absolute;width: 92px;left: 214px;top: 440px;height:21px;" placeholder="Ins Chg" value="" onkeyup="calCFROrCIF()">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-7" id="right_side_style">
                                <span id="task_details_style">Costing Details</span>
                                  {{-- <div class="preload">
                                    <img src="{{asset('/img/loading_spinner.gif')}}"/>
                                  </div> --}}
                                 <br>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <label for="name" style="width: 300px;position: absolute;left:73px;top: 45px;">Head</label>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <label for="name" style="width: 300px;position: absolute;left: 262px;top: 45px;">% ON TP</label>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <label for="name" style="width: 300px;position: absolute;left: 420px;top: 45px;">BDT</label>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <label for="name" style="width: 300px;position: absolute;left: 545px;top: 45px;">USD</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:21px;font-weight: bold;" value="Prime Cost">
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="manual_prime_cost"  id="manual_prime_cost" class="form-control" style="position: absolute;width:  115px;left: 385px;top:21px" placeholder="Manual Input" onkeyup="calculateCosting()">
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="prime_cost_bdt"  id="prime_cost_bdt" class="form-control" style="position: absolute;width:  115px;top:21px;left: 247px;" readonly placeholder="From ERP">
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="prime_cost_usd"  id="prime_cost_usd" class="form-control" style="position: absolute;width:  115px;top:21px;left: 507px;" readonly placeholder="">
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:67px;font-weight: bold" value="Factory OH" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="factory_oh_percent"  id="factory_oh_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:67px" value="0" onkeyup="calculateCosting()" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="factory_oh_bdt"  id="factory_oh_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:67px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="factory_oh_usd"  id="factory_oh_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:67px;" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:93px;font-weight: bold" value="Carriage" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="carriage_percent"  id="carriage_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:93px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="carriage_percent_bdt"  id="carriage_percent_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:93px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="carriage_percent_usd"  id="carriage_percent_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:93px;" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:119px;font-weight: bold" value="C&F expenses" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="cnf_exp_percent"  id="cnf_exp_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:119px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="cnf_exp_bdt"  id="cnf_exp_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:119px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="cnf_exp_usd"  id="cnf_exp_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:119px;" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:145px;font-weight: bold" value="Depot EXP" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="depot_chg_percent"  id="depot_chg_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:145px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="depot_chg_bdt"  id="depot_chg_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:145px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="depot_chg_usd"  id="depot_chg_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:145px;" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:171px;font-weight: bold" value="Doc/Stamp/Bank/collection Chg" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="collection_chg_percent"  id="collection_chg_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:171px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="collection_chg_bdt"  id="collection_chg_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:171px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="collection_chg_usd"  id="collection_chg_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:171px;" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:197px;font-weight: bold" value="Insight Gift" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="insight_gift_percent"  id="insight_gift_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:197px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="insight_gift_bdt"  id="insight_gift_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:197px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="insight_gift_usd"  id="insight_gift_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:197px;" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:223px;font-weight: bold" value="Others" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="others_percent"  id="others_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:223px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="others_bdt"  id="others_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:223px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="others_usd"  id="others_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:223px;" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:249px;background: yellow;font-weight: bold" value="Total OH" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="total_oh_percent"  id="total_oh_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:249px;background: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="total_oh_bdt"  id="total_oh_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:249px;background: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="total_oh_usd"  id="total_oh_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:249px;background: yellow" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:275px;font-weight: bold;background-color: yellow" value="Total Cost" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="total_cost_percent"  id="total_cost_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:275px;background-color: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="total_cost_bdt"  id="total_cost_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:275px;background-color: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="total_cost_usd"  id="total_cost_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:275px;background-color: yellow" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:301px;font-weight: bold;background-color: yellow" value="GP" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="gp_percentage"  id="gp_percentage" class="form-control" style="position: absolute;width:  115px;left: 247px;top:301px;background-color: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="gp_bdt"  id="gp_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:301px;background-color: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="gp_usd"  id="gp_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:301px;background-color: yellow" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:327px;font-weight: bold;background-color: yellow" value="FOB/PCS" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="per_piece_percent_value"  id="per_piece_percent_value" class="form-control" style="position: absolute;width:  115px;left: 247px;top:327px;background-color: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="per_piece_bd_value"  id="per_piece_bd_value" class="form-control" style="position: absolute;width:  115px;left: 385px;top:327px;background-color: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="per_piece_usd_value"  id="per_piece_usd_value" class="form-control" style="position: absolute;width:  115px;left: 507px;top:327px;background-color: yellow" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:353px;background: yellow;font-weight: bold" value="FOB/CTN" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="fob_in_percent"  id="fob_in_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:353px;background: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="fob_in_bdt"  id="fob_in_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:353px;background: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" id="fob_in_ctn" name="fob_in_ctn" class="form-control" style="position: absolute;width:  115px;left: 507px;top:353px;" onkeyup="fobCalculation();calCFROrCIF()" value="0">
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:379px;background: yellow;font-weight: bold" value="Conversion Rate(USD)" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="conversion_rate_id"  id="conversion_rate_id" class="form-control" style="position: absolute;width:  115px;left: 247px;top:379px;" value="" onkeyup="fobCalculation();calculateCosting()">
                                    </div>
                                  </div>
                                  <div class="row cif_cfr_div_id">
                                      <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                        <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:405px;background: yellow;font-weight: bold" value="CFR OR CIF/CTN" readonly>
                                      </div>
                                      <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                        <input type="text" name="cif_or_cfr_rate_per_ctn"  id="cif_or_cfr_rate_per_ctn" class="form-control" style="position: absolute;width:  115px;left: 247px;top:405px;" value="0" onkeyup="" placeholder="Per CTN" readonly>
                                      </div>
                                      <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                        <input type="text" name="cif_or_cfr_rate_per_piece"  id="cif_or_cfr_rate_per_piece" class="form-control" style="position: absolute;width:  115px;left: 386px;top:405px;" value="0" onkeyup="" placeholder="Per Piece" readonly>
                                      </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 114px;left: 386px;top:379px;background: yellow;font-weight: bold;text-align: left" value="LUD" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="last_updated_date"  id="last_updated_date" class="form-control" style="position: absolute;width:  115px;left: 507px;top:379px;background-color: yellow;" value="" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                     <input type="submit" class="btn btn-primary btn-xs" style="position: absolute;width: 50px;left: 386px;top:451px" value="Save" onclick="saveCostingDetails()">
                                     <input type="submit" class="btn btn-info btn-xs" style="position: absolute;width: 50px;left: 439px;top:451px" value="Clear" id="btnClear" onclick="clearFormElement()">
                                     <input type="submit" class="btn btn-danger btn-xs" style="position: absolute;width: 50px;left: 492px;top:451px;" value="Close" data-dismiss="modal">
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>   
                    </div> 

                </div>
          </div>
    </div>
</div>
<!-- Edit Modal -->
<div id="EditModel" class="modal fade" role="dialog">
    <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" style="border-bottom: 1px solid #cccc;">COSTING UPDATE FORM</h4>
            </div>
            <div class="modal-body">
                    <div class="box-body" style="margin-top: -25px">
                      <div class="row">
                          <div class="col-sm-12"> 
                              <div class="col-sm-4" id="left_side_style">
                                <span id="po_details_style">Info Details</span>
                                <br>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;z-index: 999">Party:</label>
                                  <select name="eparty_code" id="eparty_code" data-live-search="true" class="form-control select2 selectpicker input-sm eparty" required autofocus type="select"  value="1" onchange="getPartyInfo(this)">

                                  </select>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 44px;z-index: 999">Country:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="ecountry"  id="ecountry" class="form-control" style="position: absolute;width: 207px;top: 40px;left: 102px;height: 21px;" placeholder="Auto Select Country Name" readonly>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 63px;z-index: 999">Region:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="eregion"  id="eregion" class="form-control" style="position: absolute;width: 80px;left: 102px;top: 63px;height: 21px;" placeholder="Region" readonly>
                                  </div>
                                  <label for="name" style="position: absolute;left:183px;top: 63px;z-index: 999">Zone:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="ezone"  id="ezone" class="form-control" style="position: absolute;width: 86px;left: 223px;top:63px;height: 21px;" value="" placeholder="Zone" readonly>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 86px;z-index: 999">Item:</label>
                                  <select name="eitem" id="eitem" data-live-search="true" class="form-control select2 selectpicker input-sm eitem" required autofocus type="select"  value="1" >
  
                                  </select>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;left: 14px;top: 109px;">BU:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="ebu"  id="ebu" class="form-control" style="position: absolute;width: 207px;left: 102px;top:109px;height: 21px;" placeholder="Auto Select BU Name" readonly>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 133px;z-index: 999">Location:</label>
                                  <select name="elocation" id="elocation" data-live-search="true" class="form-control select2 selectpicker input-sm edlocation" required  type="select"  value="1">

                                  </select>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 156px;">Sales Term:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <select style="position: absolute;width: 207px;left: 102px;top:156px;height: 21px;" class="form-control" name="esales_term" id="esales_term">
                                       
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 180px;">Container Size:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <select style="position: absolute;width: 111px;left: 197px;top:180px;height: 21px;" class="form-control" name="econtainer_size" id="econtainer_size">
                                       
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 204px;">CTN/Container:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="ectn_per_container"  id="ectn_per_container" class="form-control" style="position: absolute;width: 111px;left: 197px;top:204px;height: 21px;" placeholder="CTN Per Container" onkeyup="etotalPCSContainer();ecalculateCosting();calCFROrCIFOnEdit()">
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 228px;">PCS/Container:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="epcs_per_container"  id="epcs_per_container" class="form-control" style="position: absolute;width: 110px;left: 197px;top:228px;height: 21px;" placeholder="PCS per container" onkeyup="etotalCTNContainer();ecalculateCosting();calCFROrCIFOnEdit()">
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 252px;">PCS/CTN:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="epcs_per_ctn"  id="epcs_per_ctn" class="form-control" style="position: absolute;width: 110px;left: 197px;top:252px;height: 21px;" placeholder="Carton Factor" onkeyup="calculateTotalPcsCTN();calCFROrCIFOnEdit();" readonly>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 277px;">Container Category:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <select style="position: absolute;width: 110px;left: 197px;top:277px;height: 21px;" class="form-control" name="econtainer_category" id="econtainer_category">
                                       
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 301px;">Carriage/Container:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="ecarriage_per_container"  id="ecarriage_per_container" class="form-control" style="position: absolute;width: 110px;left: 197px;top:300px;height: 21px;" placeholder="Carriage Fare" value="" onkeyup="ecalculateCosting()">
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 324px;">C&F Chg/Ctn:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="ec_and_f_charge"  id="ec_and_f_charge" class="form-control" style="position: absolute;width: 110px;left: 197px;top:324px;height: 21px;" placeholder="C&F Expenses" value="" onkeyup="ecalculateCosting()">
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 348px;">Depot Chg:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="edepot_exp"  id="edepot_exp" class="form-control" style="position: absolute;width: 109px;left: 197px;top:348px;height: 21px;" placeholder="Enter Depot Chg" value="" onkeyup="ecalculateCosting()">
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 373px;">Doc/Stamp/Bank/Chg:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="ecoln_chg_id"  id="ecoln_chg_id" class="form-control" style="position: absolute;width: 109px;left: 197px;top:372px;height: 21px;" placeholder="Collection Chg" value="" onkeyup="ecalculateCosting()">
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 397px;">Insight Gift:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="einside_gift_id"  id="einside_gift_id" class="form-control" style="position: absolute;width: 109px;left: 197px;top: 396px;height: 21px;" placeholder="insight gift" value="" onkeyup="ecalculateCosting()">
                                  </div>
                                </div>
                                <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                  <label for="name" style="position: absolute;top: 421px;">Others:</label>
                                  <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <input type="text" name="eothers_id"  id="eothers_id" class="form-control" style="position: absolute;width: 108px;left: 197px;top: 420px;height: 21px;" placeholder="Others" value="" onkeyup="ecalculateCosting()">
                                  </div>
                                </div>
                                <div class="cif_cfr_div_id">
                                  <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <label for="name" style="position: absolute;top: 444px;">Freight Chg:</label>
                                    <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="efreight_chg"  id="efreight_chg" class="form-control" style="position: absolute;width: 55px;left: 94px;top: 444px;height:21px;" placeholder="Freight" value="" onkeyup="calculateCosting();calCFROrCIFOnEdit()">
                                    </div>
                                  </div>
                                  <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                    <label for="name" style="position: absolute;top: 444px;left: 152px;">Ins Chg:</label>
                                    <div class="form-group{{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="eins_chg"  id="eins_chg" class="form-control" style="position: absolute;width: 100px;left: 205px;top: 444px;height:21px;" placeholder="Freight" value="" onkeyup="calculateCosting();calCFROrCIFOnEdit()">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-7" id="right_side_style">
                                <span id="task_details_style">Costing Details</span>
                                 <br>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <label for="name" style="width: 300px;position: absolute;left:73px;top: 46px">Head</label>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <label for="name" style="width: 300px;position: absolute;left: 262px;top: 46px">% ON TP</label>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <label for="name" style="width: 300px;position: absolute;left: 420px;top: 46px">BDT</label>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <label for="name" style="width: 300px;position: absolute;left: 545px;top: 46px">USD</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:21px;font-weight: bold;" value="Prime Cost" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="emanual_prime_cost"  id="emanual_prime_cost" class="form-control" style="position: absolute;width:  115px;left: 385px;top:21px" placeholder="Manual Input" onkeyup="ecalculateCosting()">
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="eprime_cost_bdt"  id="eprime_cost_bdt" class="form-control" style="position: absolute;width:  115px;top:21px;left: 247px;" value="" readonly placeholder="From ERP">
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="eprime_cost_usd"  id="eprime_cost_usd" class="form-control" style="position: absolute;width:  115px;top:21px;left: 507px;" readonly placeholder="">
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:67px;font-weight: bold" value="Factory OH" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="efactory_oh_percent"  id="efactory_oh_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:67px" value="0" onkeyup="ecalculateCosting()" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="efactory_oh_bdt"  id="efactory_oh_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:67px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="efactory_oh_usd"  id="efactory_oh_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:67px;" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                      <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                        <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:93px;font-weight: bold" value="Carriage" readonly>
                                      </div>
                                      <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                        <input type="text" name="ecarriage_percent"  id="ecarriage_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:93px" readonly>
                                      </div>
                                      <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                        <input type="text" name="ecarriage_percent_bdt"  id="ecarriage_percent_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:93px" readonly>
                                      </div>
                                      <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                        <input type="text" name="ecarriage_percent_usd"  id="ecarriage_percent_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:93px;" readonly>
                                      </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:119px;font-weight: bold" value="C&F expenses" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="ecnf_exp_percent"  id="ecnf_exp_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:119px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="ecnf_exp_bdt"  id="ecnf_exp_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:119px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="ecnf_exp_usd"  id="ecnf_exp_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:119px;" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:145px;font-weight: bold" value="Depot Chg" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="edepot_chg_percent"  id="edepot_chg_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:145px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="edepot_chg_bdt"  id="edepot_chg_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:145px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="edepot_chg_usd"  id="edepot_chg_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:145px;" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:171px;font-weight: bold" value="Doc/Stamp/Bank Chg" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="ecollection_chg_percent"  id="ecollection_chg_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:171px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="ecollection_chg_bdt"  id="ecollection_chg_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:171px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="ecollection_chg_usd"  id="ecollection_chg_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:171px;" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:197px;font-weight: bold" value="Insight Gift" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="einsight_gift_percent"  id="einsight_gift_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:197px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="einsight_gift_bdt"  id="einsight_gift_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:197px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="einsight_gift_usd"  id="einsight_gift_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:197px;" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:223px;font-weight: bold" value="Others" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="eothers_percent"  id="eothers_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:223px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="eothers_bdt"  id="eothers_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:223px" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="eothers_usd"  id="eothers_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:223px;" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:249px;background: yellow;font-weight: bold" value="Total OH" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="etotal_oh_percent"  id="etotal_oh_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:249px;background: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="etotal_oh_bdt"  id="etotal_oh_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:249px;background: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="etotal_oh_usd"  id="etotal_oh_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:249px;background: yellow" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:275px;font-weight: bold;background-color: yellow" value="Total Cost" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="etotal_cost_percent"  id="etotal_cost_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:275px;background-color: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="etotal_cost_bdt"  id="etotal_cost_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:275px;background-color: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="etotal_cost_usd"  id="etotal_cost_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:275px;background-color: yellow" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:301px;font-weight: bold;background-color: yellow" value="GP" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="egp_percentage"  id="egp_percentage" class="form-control" style="position: absolute;width:  115px;left: 247px;top:301px;background-color: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="egp_bdt"  id="egp_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:301px;background-color: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="egp_usd"  id="egp_usd" class="form-control" style="position: absolute;width:  115px;left: 507px;top:301px;background-color: yellow" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:327px;font-weight: bold;background-color: yellow" value="FOB/PCS" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="eper_piece_percent_value"  id="eper_piece_percent_value" class="form-control" style="position: absolute;width:  115px;left: 247px;top:327px;background-color: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="eper_piece_bd_value"  id="eper_piece_bd_value" class="form-control" style="position: absolute;width:  115px;left: 385px;top:327px;background-color: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="eper_piece_usd_value"  id="eper_piece_usd_value" class="form-control" style="position: absolute;width:  115px;left: 507px;top:327px;background-color: yellow" readonly>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:353px;background: yellow;font-weight: bold" value="FOB/CTN" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="efob_in_percent"  id="efob_in_percent" class="form-control" style="position: absolute;width:  115px;left: 247px;top:353px;background: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="efob_in_bdt"  id="efob_in_bdt" class="form-control" style="position: absolute;width:  115px;left: 385px;top:353px;background: yellow" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" id="efob_in_ctn" name="efob_in_ctn" class="form-control" style="position: absolute;width:  115px;left: 507px;top:353px;background: yellow" onkeyup="efobCalculation();calCFROrCIFOnEdit()">
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:379px;background: yellow;font-weight: bold" value="Conversion Rate(USD)" readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="text" name="econversion_rate_id"  id="econversion_rate_id" class="form-control" style="position: absolute;width:  115px;left: 247px;top:379px;background-color: yellow" value="" onkeyup="efobCalculation();ecalculateCosting()">
                                      <input type="hidden" value="" id="edit_id">
                                    </div>
                                  </div>
                                  <div class="cif_cfr_div_id">
                                    <div class="row">
                                      <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                        <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 222px;left: 4px;top:405px;background: yellow;font-weight: bold" value="CFR OR CIF/CTN" readonly>
                                      </div>
                                      <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                        <input type="text" name="ecif_or_cfr_rate_per_ctn"  id="ecif_or_cfr_rate_per_ctn" class="form-control" style="position: absolute;width:  115px;left: 247px;top:405px;background-color: yellow" value="" onkeyup="efobCalculation();ecalculateCosting()">
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                        <input type="text" name=""  id="" class="form-control" style="position: absolute;width: 125px;left: 385px;top:405px;background: yellow;font-weight: bold" value="CFR OR CIF/PCS" readonly>
                                      </div>
                                      <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                        <input type="text" name="ecif_or_cfr_rate_per_piece"  id="ecif_or_cfr_rate_per_piece" class="form-control" style="position: absolute;width:  91px;left: 521px;top:405px;background-color: yellow" value="" onkeyup="efobCalculation();ecalculateCosting()">
                                      </div>
                                    </div>
                                  </div>  
                                  <div class="row">
                                    <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                                      <input type="submit" class="btn btn-primary btn-xs btn-new" style="position: absolute;width: 69px;left: 439px;top:440px" onclick="updateCostingDetails(1)" value="Create New">
                                      <input type="submit" class="btn btn-success btn-xs btn-update" style="position: absolute;width: 50px;left: 387px;top:440px" value="Update" onclick="updateCostingDetails(2)">
                                      <input type="submit" class="btn btn-danger btn-xs" style="position: absolute;width: 50px;left: 510px;top:440px;" value="Close" data-dismiss="modal">
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>   
                    </div> 

                </div>
          </div>
    </div>
</div> 
<script>document.title = 'Costing | Create';</script>
<script type="text/javascript">
    
    $(".preload").hide();
    $(".cfr_div").hide();
    setTimeout(function() { $('.sr-only').click();}, 0.001);
     
    //@@Hide and show CFR and CIF calculation

    $('.cif_cfr_div_id').hide();

    //@@Create Form CFR,CIF,FOB Calculation 
    $('#sales_term').change(function(){
          
        var sales_tern=$(this).val();
        if(sales_tern=='FOB'){

          $('.cif_cfr_div_id').hide();

        }else{
          
          $('.cif_cfr_div_id').show();

        }
      
    });

    //@@Cpdate Form CFR,CIF,FOB Calculation 
    $('#esales_term').change(function(){
          
          var sales_term=$(this).val();
          var id=$('#edit_id').val();
          var url = "{{url('/')}}"+"/json/get/costing/freight_details?id="+id+'&sales_term='+sales_term;
          $.get(url,function(res) {

              if(sales_term=='FOB'){

                  // $('.cif_cfr_div_id').hide();
                  $('#efreight_chg').val(0);
                  $('#eins_chg').val(0);
                  $('#ecif_or_cfr_rate_per_ctn').val(0);
                  $('#ecif_or_cfr_rate_per_piece').val(0);

              }else{
                
                  $('.cif_cfr_div_id').show();

              }

              $('#efreight_chg').val(res.freight_chg);
              $('#eins_chg').val(res.ins_chg);
              $('#ecif_or_cfr_rate_per_ctn').val(res.rate_per_ctn);
              $('#ecif_or_cfr_rate_per_piece').val(res.rate_per_piece);

          }); 
        
    });

    //@@@Load Carriage Charge Create Form--
    $('#location,#container_size,#container_category').change(function (e){
           
        var location=$("#location").val();
        var container_size=$("#container_size").val();
        var container_category=$("#container_category").val();
        if(location!='' && container_size!='' && container_category!=''){
             
          var url = "{{url('/json/get/carrying/charge')}}?location_id="+location+"&container_size="+container_size+"&container_category="+container_category;
          $.get(url,function(res){

              $('#carriage_per_container').val(res.carrying_charge);

          }); 

        }
       
      
    });
    //@@@Load Carriage Charge Update Form--
    $('#elocation, #econtainer_size, #econtainer_category').change(function (e) {
          
          var location = $("#elocation").val();
          var container_size = $("#econtainer_size").val();
          var container_category = $("#econtainer_category").val();
          if(location!="" && container_size!="" && container_category!=""){

            if (location !== "" && container_size !== "" && container_category !== "") {
                var url = "{{url('/json/get/carrying/charge')}}?location_id=" + location + "&container_size=" + container_size + "&container_category=" + container_category;
                $.get(url, function (res) {
                    $('#ecarriage_per_container').val(res.carrying_charge);
                });
            }

          }
           
      });

    //@@@Load Carriage Charge Create Form--
    $('#container_size,#container_category').change(function (e){
           
        var container_size=$("#container_size").val();
        var container_cat=$("#container_category").val();
        if(container_size!=''&& container_cat!=''){
               
          var url = "{{url('/json/get/depot/charge')}}?container_size="+container_size+'&container_cat='+container_cat;
          $.get(url,function(res){
          
            $('#depot_exp').val(res.depot_charge);

          });

        }
         
         
    });

    //@@@Load Carriage Charge Update Form--
    $('#econtainer_size,#econtainer_category').change(function (e){
           
        var container_size=$("#econtainer_size").val();
        var container_cat=$("#econtainer_category").val();
        if(container_size!=''&& container_cat!=''){
              
          var url = "{{url('/json/get/depot/charge')}}?container_size="+container_size+'&container_cat='+container_cat;
          $.get(url,function(res){
          
            $('#edepot_exp').val(res.depot_charge);

          });

        }
            
            
    });

    //@@@Datatable Filter Function
    $('#search_party_code').change(function(e){

       var party_code=$('#search_party_code').val();
       getAllcostingList(party_code); 
       
    });

    function getAllcostingList(party_code){
      
        $('#example1').dataTable().fnDestroy(); 
          var table=$('#example1').DataTable({
          "ajax": {
              "url": "/jsonGetAllCosting",
              "type": "GET",
              "data": {
                "party_code": party_code,
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
                { "data": "party_code"},
                { "data": "item_code"},
                { "data": "item_name"},
                { "data": "country" },
                { "data": "region" },
                { "data": "loc_name" },
                { "data": "container_size"},
                { "data": "conversion_rate"},
                { "data": "fob_per_piece"},
                { "data": "rate_per_ctn"},
                { "data": "prime_cost_bdt"},
                { "data": "total_cost_bdt"},
                { "data": "gp_percentage"},
                { "data": "last_updated_date"},
                { 
                    "data": null,
                    render: function(data, type, row){

                      if(data.approve=='N'){
                        
                        return '<input type="button" data-id="'+row.id+'" class="btn btn-info btn-xs btn-edit" value="Edit"> <input type="button" data-id="'+row.id+'" class="btn btn-success btn-xs btn-approve" value="Approve">' 
                        
                      }else{

                        return '<input type="button" data-id="'+row.id+'" class="btn btn-info btn-xs" value="Edit"> <input type="button" data-id="'+row.id+'" class="btn btn-success btn-xs" value="Approve" disabled>' 

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

    function saveCostingDetails(){

      $(".preload").show();
      var party_code=$('#party_code').val();
      var country_name=$('#country').val();
      var item=$("#item_code").val();
      var bu=$("#bu").val();
      var region=$("#region").val();
      var zone=$("#zone").val();
      var location=$("#location").val();
      var sales_term=$("#sales_term").val();
      var container_size=$("#container_size").val();
      var container_category=$("#container_category").val();
      var ctn_per_container=$("#ctn_per_container").val();
      var pcs_per_container=$("#pcs_per_container").val();
      var pcs_per_ctn=$("#pcs_per_ctn").val();
      var carriage_per_container=$("#carriage_per_container").val();
      var c_and_f_charge=$("#c_and_f_charge").val();
      var depot_exp=$("#depot_exp").val();
      var coln_chg_id=$("#coln_chg_id").val();
      var inside_gift_id=$("#inside_gift_id").val();
      var others_id=$("#others_id").val();
      var manual_prime_cost=$("#manual_prime_cost").val();
      var prime_cost_bdt=$("#prime_cost_bdt").val();
      var prime_cost_usd=$("#prime_cost_usd").val();
      var factory_oh_percent=$("#factory_oh_percent").val();
      var factory_oh_bdt=$("#factory_oh_bdt").val();
      var factory_oh_usd=$("#factory_oh_usd").val();
      var carriage_percent=$("#carriage_percent").val();
      var carriage_percent_bdt=$("#carriage_percent_bdt").val();
      var carriage_percent_usd=$("#carriage_percent_usd").val();
  
      var cnf_exp_percent=$("#cnf_exp_percent").val();
      var cnf_exp_bdt=$("#cnf_exp_bdt").val();
      var cnf_exp_usd=$("#cnf_exp_usd").val();

      var depot_chg_percent=$("#depot_chg_percent").val();
      var depot_chg_bdt=$("#depot_chg_bdt").val();
      var depot_chg_usd=$("#depot_chg_usd").val();

      var collection_chg_percent=$("#collection_chg_percent").val();
      var collection_chg_bdt=$("#collection_chg_bdt").val();
      var collection_chg_usd=$("#collection_chg_usd").val();
      var insight_gift_percent=$("#insight_gift_percent").val();
      var insight_gift_bdt=$("#insight_gift_bdt").val();
      var insight_gift_usd=$("#insight_gift_usd").val();
      var others_percent=$("#others_percent").val();
      var others_bdt=$("#others_bdt").val();
      var others_usd=$("#others_usd").val(); 
      var total_oh_percent=$("#total_oh_percent").val(); 
      var total_oh_bdt=$("#total_oh_bdt").val();
      var total_oh_usd=$("#total_oh_usd").val();
      var total_cost_percent=$("#total_cost_percent").val();
      var total_cost_bdt=$("#total_cost_bdt").val();
      var total_cost_usd=$("#total_cost_usd").val();
      var gp_percentage=$("#gp_percentage").val();
      var gp_bdt=$("#gp_bdt").val();
      var gp_usd=$("#gp_usd").val();
      var per_piece_percent_value=$("#per_piece_percent_value").val();
      var per_piece_bd_value=$("#per_piece_bd_value").val();
      var per_piece_usd_value=$("#per_piece_usd_value").val();
      var fob_in_bdt=$("#fob_in_bdt").val();
      var fob_in_ctn=$("#fob_in_ctn").val(); 
      var conversion_rate=$("#conversion_rate_id").val();
      var updated_date=$("#last_updated_date").val();
      var freight_chg=$("#freight_chg").val() ? $("#freight_chg").val() : 0;
      var ins_chg=$("#ins_chg").val() ? $("#ins_chg").val() : 0;
      var cif_or_cfr_rate_per_ctn=$("#cif_or_cfr_rate_per_ctn").val() ? $("#cif_or_cfr_rate_per_ctn").val() : 0;
      var cif_or_cfr_rate_per_piece=$("#cif_or_cfr_rate_per_piece").val() ? $("#cif_or_cfr_rate_per_piece").val() : 0;
      var validateStatus=checkValidation(party_code,item,location,sales_term,container_size,container_category,prime_cost_bdt,factory_oh_percent,gp_percentage);
      if(validateStatus==true){
           
          $.ajax({
              method: 'POST',
              url: "/costing",
              data: {'party_code': party_code, 'country_name':country_name,'item': item,'region':region,'zone':zone,
                    'bu':bu,'location':location,'ctn_per_container':ctn_per_container,'pcs_per_container':pcs_per_container,
                    'pcs_per_ctn':pcs_per_ctn,'carriage_per_container':carriage_per_container,'c_and_f_charge':c_and_f_charge,'depot_exp':depot_exp,
                    'doc_chg':coln_chg_id,'inside_gift_id':inside_gift_id,'others_id':others_id,'container_size':container_size,
                    'sales_term':sales_term,'container_category':container_category,'manual_prime_cost':manual_prime_cost,'prime_cost_bdt':prime_cost_bdt,'prime_cost_usd':prime_cost_usd,
                    'factory_oh_percent':factory_oh_percent,'factory_oh_bdt':factory_oh_bdt,'factory_oh_usd':factory_oh_usd,'carriage_percent':carriage_percent,
                    'carriage_percent_bdt':carriage_percent_bdt,'carriage_percent_usd':carriage_percent_usd,'cnf_exp_percent':cnf_exp_percent,'cnf_exp_bdt':cnf_exp_bdt,'cnf_exp_usd':cnf_exp_usd,
                    'depot_chg_usd':depot_chg_usd,'depot_chg_bdt':depot_chg_bdt,'depot_chg_percent':depot_chg_percent,'collection_chg_percent':collection_chg_percent,
                    'collection_chg_bdt':collection_chg_bdt,'collection_chg_usd':collection_chg_usd,'insight_gift_percent':insight_gift_percent,
                    'insight_gift_bdt':insight_gift_bdt,'insight_gift_usd':insight_gift_usd,'others_percent':others_percent,'others_bdt':others_bdt,
                    'others_usd':others_usd,'total_oh_percent':total_oh_percent,'total_oh_bdt':total_oh_bdt,'total_oh_usd':total_oh_usd,'total_cost_percent':total_cost_percent,
                    'total_cost_bdt':total_cost_bdt,'total_cost_usd':total_cost_usd,'gp_percentage':gp_percentage,'gp_bdt':gp_bdt,
                    'gp_usd':gp_usd,'per_piece_percent_value':per_piece_percent_value,'per_piece_bd_value':per_piece_bd_value,'per_piece_usd_value':per_piece_usd_value,
                    'fob_in_bdt':fob_in_bdt,'conversion_rate':conversion_rate,'updated_date':updated_date,'fob_in_ctn':fob_in_ctn,'freight_chg':freight_chg,'ins_chg':ins_chg,
                    'cif_or_cfr_rate_per_ctn':cif_or_cfr_rate_per_ctn,'cif_or_cfr_rate_per_piece':cif_or_cfr_rate_per_piece,'_token': $('input[name=_token]').val()},
              success: function (res) {

                  if(res.status=='success'){
                    
                      Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Successfully Create'
                      })
                      $('#createModel').modal('hide');

                      clearFormElement();
                      getAllcostingList(party_code);
                    

                  }else if(res.status=='fail'){
                    
                      Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                      });

                  }

              },

              error: function (e) {

                  console.log(e);
              }

          });

      }


    }

    function updateCostingDetails(type){

      var party_code=$('#eparty_code').val();
      var country_name=$('#ecountry').val();
      var item=$("#eitem").val();
      var bu=$("#ebu").val();
      var region=$("#eregion").val();
      var zone=$("#ezone").val();
      var location=$("#elocation").val();
      var sales_term=$("#esales_term").val();
      var container_size=$("#econtainer_size").val();
      var container_category=$("#econtainer_category").val();
      var ctn_per_container=$("#ectn_per_container").val();
      var pcs_per_container=$("#epcs_per_container").val();
      var pcs_per_ctn=$("#epcs_per_ctn").val();
      var carriage_per_container=$("#ecarriage_per_container").val();
      var c_and_f_charge=$("#ec_and_f_charge").val();
      var depot_exp=$("#edepot_exp").val();
      var coln_chg_id=$("#ecoln_chg_id").val();
      var inside_gift_id=$("#einside_gift_id").val();
      var others_id=$("#eothers_id").val();
      var emanual_prime_cost=$("#emanual_prime_cost").val();
      var prime_cost_bdt=$("#eprime_cost_bdt").val();
      var prime_cost_usd=$("#eprime_cost_usd").val();
      var factory_oh_percent=$("#efactory_oh_percent").val();
      var factory_oh_bdt=$("#efactory_oh_bdt").val();
      var factory_oh_usd=$("#efactory_oh_usd").val();
      var carriage_percent=$("#ecarriage_percent").val();
      var carriage_percent_bdt=$("#ecarriage_percent_bdt").val();
      var carriage_percent_usd=$("#ecarriage_percent_usd").val();

      var cnf_exp_percent=$("#ecnf_exp_percent").val();
      var cnf_exp_bdt=$("#ecnf_exp_bdt").val();
      var cnf_exp_usd=$("#ecnf_exp_usd").val();

      var depot_chg_percent=$("#edepot_chg_percent").val();
      var depot_chg_bdt=$("#edepot_chg_bdt").val();
      var depot_chg_usd=$("#edepot_chg_usd").val();

      var collection_chg_percent=$("#ecollection_chg_percent").val();
      var collection_chg_bdt=$("#ecollection_chg_bdt").val();
      var collection_chg_usd=$("#ecollection_chg_usd").val();
      var insight_gift_percent=$("#einsight_gift_percent").val();
      var insight_gift_bdt=$("#einsight_gift_bdt").val();
      var insight_gift_usd=$("#einsight_gift_usd").val();
      var others_percent=$("#eothers_percent").val();
      var others_bdt=$("#eothers_bdt").val();
      var others_usd=$("#eothers_usd").val(); 
      var total_oh_percent=$("#etotal_oh_percent").val(); 
      var total_oh_bdt=$("#etotal_oh_bdt").val();
      var total_oh_usd=$("#etotal_oh_usd").val();
      var total_cost_percent=$("#etotal_cost_percent").val();
      var total_cost_bdt=$("#etotal_cost_bdt").val();
      var total_cost_usd=$("#etotal_cost_usd").val();
      var gp_percentage=$("#egp_percentage").val();
      var gp_bdt=$("#egp_bdt").val();
      var gp_usd=$("#egp_usd").val();
      var per_piece_percent_value=$("#eper_piece_percent_value").val();
      var per_piece_bd_value=$("#eper_piece_bd_value").val();
      var per_piece_usd_value=$("#eper_piece_usd_value").val();
      var fob_in_bdt=$("#efob_in_bdt").val();
      var fob_in_ctn=$("#efob_in_ctn").val(); 
      var conversion_rate=$("#econversion_rate_id").val();
      var edit_id=$('#edit_id').val();
      var freight_chg=$("#efreight_chg").val() ? $("#efreight_chg").val() : 0;
      var ins_chg=$("#eins_chg").val() ? $("#eins_chg").val() : 0;
      var cif_or_cfr_rate_per_ctn=$("#ecif_or_cfr_rate_per_ctn").val() ? $("#ecif_or_cfr_rate_per_ctn").val() : 0;
      var cif_or_cfr_rate_per_piece=$("#ecif_or_cfr_rate_per_piece").val() ? $("#ecif_or_cfr_rate_per_piece").val() : 0;
      var validateStatus=checkValidation(party_code,item,location,sales_term,container_size,container_category,prime_cost_bdt,factory_oh_percent,gp_percentage);
      if(validateStatus==true){
          
        $.ajax({

            method: 'POST',
            url: "/update/costing",
            data: {'party_code': party_code, 'country_name':country_name,'item': item,'region':region,'zone':zone,
                  'bu':bu,'location':location,'ctn_per_container':ctn_per_container,'pcs_per_container':pcs_per_container,
                  'pcs_per_ctn':pcs_per_ctn,'carriage_per_container':carriage_per_container,'c_and_f_charge':c_and_f_charge,'depot_exp':depot_exp,
                  'doc_chg':coln_chg_id,'inside_gift_id':inside_gift_id,'others_id':others_id,'container_size':container_size,
                  'sales_term':sales_term,'container_category':container_category,'manual_prime_cost':emanual_prime_cost,'prime_cost_bdt':prime_cost_bdt,'prime_cost_usd':prime_cost_usd,
                  'factory_oh_percent':factory_oh_percent,'factory_oh_bdt':factory_oh_bdt,'factory_oh_usd':factory_oh_usd,'carriage_percent':carriage_percent,
                  'carriage_percent_bdt':carriage_percent_bdt,'carriage_percent_usd':carriage_percent_usd,'depot_chg_percent':depot_chg_percent,'depot_chg_bdt':depot_chg_bdt,
                  'depot_chg_usd':depot_chg_usd,'cnf_exp_percent':cnf_exp_percent,'cnf_exp_bdt':cnf_exp_bdt,'cnf_exp_usd':cnf_exp_usd,'collection_chg_percent':collection_chg_percent,
                  'collection_chg_bdt':collection_chg_bdt,'collection_chg_usd':collection_chg_usd,'insight_gift_percent':insight_gift_percent,
                  'insight_gift_bdt':insight_gift_bdt,'insight_gift_usd':insight_gift_usd,'others_percent':others_percent,'others_bdt':others_bdt,
                  'others_usd':others_usd,'total_oh_percent':total_oh_percent,'total_oh_bdt':total_oh_bdt,'total_oh_usd':total_oh_usd,'total_cost_percent':total_cost_percent,
                  'total_cost_bdt':total_cost_bdt,'total_cost_usd':total_cost_usd,'gp_percentage':gp_percentage,'gp_bdt':gp_bdt,
                  'gp_usd':gp_usd,'per_piece_percent_value':per_piece_percent_value,'per_piece_bd_value':per_piece_bd_value,'per_piece_usd_value':per_piece_usd_value,
                  'fob_in_bdt':fob_in_bdt,'conversion_rate':conversion_rate,'edit_id':edit_id,'fob_in_ctn':fob_in_ctn,'type':type,'freight_chg':freight_chg,'ins_chg':ins_chg,
                  'cif_or_cfr_rate_per_ctn':cif_or_cfr_rate_per_ctn,'cif_or_cfr_rate_per_piece':cif_or_cfr_rate_per_piece,'_token': $('input[name=_token]').val()},
            success: function (response) {


              if(response.code==200){
                
                  Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                  });

                  $('#EditModel').modal('hide');
                  var table2 = $('#example1').DataTable();
                  table2.ajax.reload();


              }else if(response.status==500){
                
                  Swal.fire({
                    icon: 'warning',
                    title: 'Oops',
                    text: response.message
                  }) 

              }         

            },

            error: function (e) {

                console.log(e);
            }

        });

      }

    }
    function getPartyInfo(sel)
    {   
        var selectedParty = $(sel).find(":selected").attr("value");
        var url = "{{url('/json/get/party/details')}}/"+selectedParty;
        $.get(url,function(res){

            $('#party_name').val(res.party_name);
            $('#country').val(res.country);
            $('#region').val(res.region);
            $('#zone').val(res.zone);

            if(res.partyItems){

                var $el = $('#item_code');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(res.partyItems, function (key, value) {
                    
                  $('select[name="item_code"]').append(`<option value="${value.item_code}">${value.item_code}-${value.item_name}</option>`)

                });
                $el.selectpicker('refresh');

            }else{

                var $el = $('#item_code');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $el.selectpicker('refresh'); 

            }

        }); 
        
    }

    function getItemInfo(sel){

      var selectedItem = $(sel).find(":selected").attr("value");
      var url = "{{url('/json/get/item/details')}}/"+selectedItem;
      $.get(url,function(res){
        
        $('#bu').val(res.bu);
        $('#prime_cost_bdt').val(res.prime_cost);
        $('#manual_prime_cost').val(res.prime_cost);
        $('#pcs_per_ctn').val(res.factor);
        $('#last_updated_date').val(res.updated_at);
        calculateCosting();

      }); 
   
    }

    function totalPCSContainer(){
    
      var ctn=$('#ctn_per_container').val();
      var factor=$('#pcs_per_ctn').val();
      var pcs_per_container=ctn*factor;
      $('#pcs_per_container').val(pcs_per_container);

    }

    function etotalPCSContainer(){
    
      var ctn=$('#ectn_per_container').val();
      var factor=$('#epcs_per_ctn').val();
      var pcs_per_container=ctn*factor;
      $('#epcs_per_container').val(pcs_per_container);

    }

    function totalCTNContainer(){

      var factor=$('#pcs_per_ctn').val();
      var pcs_per_container=$('#pcs_per_container').val();
      var total_ctn=parseInt(pcs_per_container/factor);
      $('#ctn_per_container').val(total_ctn);

    }
    //@@@--
    function etotalCTNContainer(){

      var factor=$('#epcs_per_ctn').val();
      var pcs_per_container=$('#epcs_per_container').val();
      var total_ctn=parseInt(pcs_per_container/factor);
      $('#ectn_per_container').val(total_ctn);

    }
    //@@@-Calcuate Total PCS 
    function calculateTotalPcsCTN(){
      
      var factor=$('#pcs_per_ctn').val();
      var pcs_per_container=$('#pcs_per_container').val();
      var total_ctn=parseInt(pcs_per_container/factor);
      $('#ctn_per_container').val(total_ctn);

    }
    //@@@--Calculate FOB
    function fobCalculation(){

      var fob=$('#fob_in_ctn').val();
      var conversion_value=0;
      if(fob==""){
         
        var conversion_value=$('#conversion_rate_id').val();
        $('#fob_in_bdt').val(conversion_value);
        calculateCosting();

      }else{

        var conversion_rate=$('#conversion_rate_id').val();
        $('#fob_in_bdt').val(fob*conversion_rate_id);
        conversion_value=fob*conversion_rate
        $('#fob_in_bdt').val(conversion_value);
        calculateCosting(); 

      }

    } //@@ --End Fob
    //Calculate Edit Form Fob
    function efobCalculation(){
            
      var fob=$('#efob_in_ctn').val();
      var conversion_value=0;
      if(fob==""){
         
        var conversion_value=$('#econversion_rate_id').val();
        $('#efob_in_bdt').val(conversion_value);
        ecalculateCosting();

      }else{

        var conversion_rate=$('#econversion_rate_id').val();
        $('#efob_in_bdt').val(fob*conversion_rate_id);
        conversion_value=fob*conversion_rate
        $('#efob_in_bdt').val(conversion_value);
        ecalculateCosting(); 

      }


    }
    //@@@-Clear form  
    function clearFormElement(){
         
       $('#party_code').val('').selectpicker('refresh');
       $('#item_code').val('').selectpicker('refresh');
       $('#location').val('').selectpicker('refresh');
       $('#country').val("");
       $('#carriage_per_container').val("");
       $('#region').val(""); $('#zone').val("");$("#item").val("");
       $("#item_name").val(""); $("#bu").val("");$("#location").val("");
       $("#ctn_per_container").val(""); $("#pcs_per_container").val("");
       $("#pcs_per_ctn").val(""); $("#c_and_f_charge").val("");
       $("#depot_exp").val(""); $("#coln_chg_id").val("");
       $("#inside_gift_id").val("");
       $("#freight_chg").val("");
       $("#ins_chg").val("");
       $("#others_id").val("");
       $("#conversion_rate_id").val("0");
       $("#cif_or_cfr_rate_per_ctn").val("0");
       $("#cif_or_cfr_rate_per_piece").val("0");
       $("#manual_prime_cost").val("");
       $("#prime_cost_bdt").val(""); $("#prime_cost_usd").val("");
       $("#factory_oh_percent").val("");$("#factory_oh_bdt").val(""); $("#factory_oh_usd").val(""); 
       $("#carriage_percent").val("");$("#carriage_percent_bdt").val(""); $("#carriage_percent_usd").val(""); 
       $("#cnf_exp_percent").val("");$("#cnf_exp_bdt").val(""); $("#cnf_exp_usd").val("");
       $("#doc_chg_percent").val(""); $("#doc_chg_bdt").val(""); $("#doc_chg_usd").val(""); 
       $("#depot_chg_percent").val(""); $("#depot_chg_bdt").val(""); $("#depot_chg_usd").val(""); 
       $("#collection_chg_percent").val("");$("#collection_chg_bdt").val(""); $("#collection_chg_usd").val("");
       $("#insight_gift_percent").val("");$("#insight_gift_bdt").val(""); $("#insight_gift_usd").val(""); 
       $("#others_percent").val("");$("#others_bdt").val(""); $("#others_usd").val(""); 
       $("#total_oh_percent").val(""); $("#total_oh_bdt").val(""); $("#total_oh_usd").val("");
       $("#total_cost_percent").val(""); $("#total_cost_bdt").val(""); $("#total_cost_usd").val("");
       $("#gp_percentage").val(""); $("#gp_bdt").val(""); $("#gp_usd").val("");
       $("#per_piece_percent_value").val(""); $("#per_piece_bd_value").val(""); $("#per_piece_usd_value").val("");
       $("#fob_in_bdt").val(""); $("#fob_in_ctn").val("0");$("#last_updated_date").val("");
       $('#sales_term option').prop('selected', function() {

             return this.defaultSelected;

       });

       $('#container_size option').prop('selected', function() {

             return this.defaultSelected;

       });

       $('#container_category option').prop('selected', function() {

             return this.defaultSelected;

       });
  
    } //@@end
    //@@@-Calculate costing---
    function calculateCosting(){
        
      var fob=$('#fob_in_ctn').val();
      var factor=$('#pcs_per_ctn').val();
      var ctn_per_container=$('#ctn_per_container').val();
      var pcs_per_container=$('#pcs_per_container').val();
      var conversion_rate=$('#conversion_rate_id').val();
      var manual_prime_cost=$('#manual_prime_cost').val();
      var per_piece_bdt_amount=0;
      if(factor=="" || factor==0 || ctn_per_container=="" || pcs_per_container=="" || manual_prime_cost==""){
        
          makingInputZero();

      }else{
        
        var per_piece_value_usd=fob/factor;
        var formatted_per_piece_value_usd=per_piece_value_usd.toFixed(6);
        $('#per_piece_usd_value').val(formatted_per_piece_value_usd);
        per_piece_bdt_amount=per_piece_value_usd*conversion_rate;
        formated_per_piece_bdt_amount=per_piece_bdt_amount.toFixed(3);
        $('#per_piece_bd_value').val(formated_per_piece_bdt_amount);
        if(per_piece_bdt_amount==0){

            makingInputZero();

        }else{

          var per_piece_percent_value=0;
          $('#per_piece_percent_value').val(per_piece_percent_value);
          var manual_prime_cost=$('#manual_prime_cost').val();
          var prime_cost=manual_prime_cost/conversion_rate;
          var forated_prime_cost=prime_cost.toFixed(6);
          $('#prime_cost_usd').val(forated_prime_cost);

          //factory oh bdt

          var factory_oh=0;
          var forated_factory_oh_bd=factory_oh.toFixed(3);
          $('#factory_oh_bdt').val(forated_factory_oh_bd);
          var factory_oh_usd=0;
          var forated_factory_oh_usd=factory_oh_usd.toFixed(6);
          $('#factory_oh_usd').val(forated_factory_oh_usd);
          var _factory_oh_percent=0;
          var formated_factory_oh_percent=_factory_oh_percent.toFixed(2);
          $('#factory_oh_percent').val(formated_factory_oh_percent);

          //carriage percent

          var carriage_per_container=$('#carriage_per_container').val();
          var carriage_percent_bdt=carriage_per_container/pcs_per_container;
          var formated_carriage_percent_bdt=carriage_percent_bdt.toFixed(3);
          $('#carriage_percent_bdt').val(formated_carriage_percent_bdt);
          var carriage_percent=(carriage_percent_bdt/per_piece_bdt_amount)*100;
          var forated_carriage_percent=carriage_percent.toFixed(2);          
          $('#carriage_percent').val(forated_carriage_percent);
          var carriage_percent_usd=carriage_percent_bdt/conversion_rate;
          var forated_carriage_percent_usd=carriage_percent_usd.toFixed(6);
          $('#carriage_percent_usd').val(forated_carriage_percent_usd);


          // C & F expenses/Depot exp

          var cnf_charge=$('#c_and_f_charge').val();
          var ctr_cnf_charge=cnf_charge*ctn_per_container;
          var cnf_exp_bdt=ctr_cnf_charge/pcs_per_container;
          var foramated_cnf_exp_bdt=cnf_exp_bdt.toFixed(3);
          $('#cnf_exp_bdt').val(foramated_cnf_exp_bdt);
          var cnf_exp_percent=(cnf_exp_bdt/per_piece_bdt_amount)*100;
          var forated_cnf_exp_percent=cnf_exp_percent.toFixed(2);
          $('#cnf_exp_percent').val(forated_cnf_exp_percent);
          var cnf_exp_usd=cnf_exp_bdt/conversion_rate;
          var forated_cnf_exp_usd=cnf_exp_usd.toFixed(6);
          $('#cnf_exp_usd').val(forated_cnf_exp_usd);


          // Depot Chg Calculation
            
          var depot_charge=$('#depot_exp').val();
          var depot_exp_bdt=depot_charge/pcs_per_container;
          var formated_depot_exp_bdt=depot_exp_bdt.toFixed(3);
          $('#depot_chg_bdt').val(formated_depot_exp_bdt);
          var depot_exp_percent=(depot_exp_bdt/per_piece_bdt_amount)*100;
          var formated_depot_exp_percent=depot_exp_percent.toFixed(2);
          $('#depot_chg_percent').val(formated_depot_exp_percent);
          var depot_exp_usd=depot_exp_bdt/conversion_rate;
          var forated_depot_exp_usd=depot_exp_usd.toFixed(6);
          $('#depot_chg_usd').val(forated_depot_exp_usd);   
          
          // DOC/Stamp/Bank Chg/collection chg.

          var coln_chg=$('#coln_chg_id').val();
          var coln_chg_bdt=coln_chg/pcs_per_container; 
          var forated_coln_chg_bdt=coln_chg_bdt.toFixed(3);
          $('#collection_chg_bdt').val(forated_coln_chg_bdt);  
          var coln_chg_percent=(coln_chg_bdt/per_piece_bdt_amount)*100; 
          var forated_coln_chg_percent=coln_chg_percent.toFixed(2);
          $('#collection_chg_percent').val(forated_coln_chg_percent);  
          var coln_chg_usd=coln_chg_bdt/conversion_rate;
          var forated_coln_chg_usd=coln_chg_usd.toFixed(6);
          $('#collection_chg_usd').val(forated_coln_chg_usd);  
          
          //insight gift 

          var inside_gift=$('#inside_gift_id').val();
          var inside_gift_bdt=inside_gift/pcs_per_container;
          var forated_inside_gift_bdt=inside_gift_bdt.toFixed(3);
          $('#insight_gift_bdt').val(forated_inside_gift_bdt);
          var inside_gift_percent=(inside_gift_bdt/per_piece_bdt_amount)*100;
          var forated_inside_gift_percent=inside_gift_percent.toFixed(2);
          $('#insight_gift_percent').val(forated_inside_gift_percent);
          var insight_gift_usd=inside_gift_bdt/conversion_rate;
          var forated_insight_gift_usd=insight_gift_usd.toFixed(6);
          $('#insight_gift_usd').val(forated_insight_gift_usd);  

          //others 
          var others=$('#others_id').val();
          var others_bdt=others/pcs_per_container;
          var forated_others_bdt=others_bdt.toFixed(3);
          $('#others_bdt').val(forated_others_bdt);
          var others_percent=(others_bdt/per_piece_bdt_amount)*100;
          var formated_others_percent=others_percent.toFixed(2);
          $('#others_percent').val(formated_others_percent);
          var others_usd=others_bdt/conversion_rate;
          var formated_others_usd=others_usd.toFixed(6);
          $('#others_usd').val(formated_others_usd);

          calculateTotalBdtAndUsd(per_piece_bdt_amount);
                 
        }
        
      } 

    } //@@End 
    //@@@-Making Input Zero-    
    function makingInputZero() {

            $('#per_piece_percent_value').val(0);
            $('#prime_cost_usd').val(0.00);
            $('#factory_oh_usd').val(0.00);
            $('#factory_oh_bdt').val(0.00);
            $('#carriage_percent_bdt').val(0.00);
            $('#carriage_percent').val(0.00);
            $('#carriage_percent_usd').val(0.00);
            $('#cnf_exp_percent').val(0.00);
            $('#cnf_exp_bdt').val(0.00);
            $('#cnf_exp_usd').val(0.00);
            $('#depot_chg_bdt').val(0.00);
            $('#depot_chg_percent').val(0.00);
            $('#depot_chg_usd').val(0.00);
            $('#collection_chg_bdt').val(0.00);  
            $('#collection_chg_percent').val(0.00);  
            $('#collection_chg_usd').val(0.00);
            $('#insight_gift_bdt').val(0.00);
            $('#insight_gift_percent').val(0.00);  
            $('#insight_gift_usd').val(0.00);
            $('#others_bdt').val(0.00);
            $('#others_percent').val(0.00);   
            $('#others_usd').val(0.00);
            $('#total_oh_bdt').val(0.00);
            $('#total_oh_usd').val(0.00);  
            $('#total_oh_percent').val(0.00);
            $('#total_cost_bdt').val(0.00);
            $('#total_cost_usd').val(0.00);
            $('#total_cost_percent').val(0.00);
            $('#gp_percentage').val(0.00);
            $('#gp_bdt').val(0.00);
            $('#gp_usd').val(0.00);
      
    }//@@End
    //@@@-Calcualte TotalBdtAndUSD
    function calculateTotalBdtAndUsd(per_piece_bdt_amount){
        
      //@@@@--Total OH Calculation------

        var factory_oh_bdt=parseFloat($('#factory_oh_bdt').val());
        var carriage_percent_bdt=parseFloat($('#carriage_percent_bdt').val());
        var cnf_exp_bdt=parseFloat($('#cnf_exp_bdt').val());
        var depot_chg_bdt=parseFloat($('#depot_chg_bdt').val());
        var collection_chg_bdt=parseFloat($('#collection_chg_bdt').val());
        var insight_gift_bdt=parseFloat($('#insight_gift_bdt').val());
        var others_bdt=parseFloat($('#others_bdt').val());
        var total_oh_bdt=(factory_oh_bdt+carriage_percent_bdt+cnf_exp_bdt+depot_chg_bdt+collection_chg_bdt+insight_gift_bdt+others_bdt);
        var formated_total_oh_bdt=total_oh_bdt.toFixed(3);
        $('#total_oh_bdt').val(formated_total_oh_bdt);
        
        var factory_oh_usd=parseFloat($('#factory_oh_usd').val());
        var carriage_percent_usd=parseFloat($('#carriage_percent_usd').val());
        var cnf_exp_usd=parseFloat($('#cnf_exp_usd').val());
        var depot_chg_usd=parseFloat($('#depot_chg_usd').val());
        var collection_chg_usd=parseFloat($('#collection_chg_usd').val());
        var insight_gift_usd=parseFloat($('#insight_gift_usd').val());
        var others_usd=parseFloat($('#others_usd').val());
        var total_oh_usd=(factory_oh_usd+carriage_percent_usd+cnf_exp_usd+depot_chg_usd+collection_chg_usd+insight_gift_usd+others_usd);    
        var formated_total_oh_usd=total_oh_usd.toFixed(6);
        $('#total_oh_usd').val(formated_total_oh_usd);   

       
        var total_oh_percent=(total_oh_bdt/per_piece_bdt_amount)*100;
        var formated_total_oh_percent=total_oh_percent.toFixed(2)
        $('#total_oh_percent').val(formated_total_oh_percent);

      //@@@@--END Total OH Calculation------

      //@@@@--Total Cost Calculation------

        var total_cost_bdt=parseFloat(total_oh_bdt)+parseFloat($('#manual_prime_cost').val());
        var formated_total_cost_bdt=total_cost_bdt.toFixed(3)
        $('#total_cost_bdt').val(formated_total_cost_bdt);
        var total_cost_usd=parseFloat(total_oh_usd)+parseFloat($('#prime_cost_usd').val());
        var formated_total_cost_usd=total_cost_usd.toFixed(6)
        $('#total_cost_usd').val(formated_total_cost_usd);
        var total_cost_percent=((total_cost_bdt/per_piece_bdt_amount)*100);
        var formated_total_cost_percent=total_cost_percent.toFixed(2)
        $('#total_cost_percent').val(formated_total_cost_percent);

      //@@@@--End Total Cost Calculation
      
      //@@@@--Per Piece FOB Calcuation------   
        // var per_piece_percent_value=parseFloat($('#per_piece_percent_value').val());
        var per_piece_bd_value=parseFloat($('#per_piece_bd_value').val());
        var per_piece_usd_value=parseFloat($('#per_piece_usd_value').val());
      //@@@@--End Per Piece Calculation------   

      //@@@@--GP Calculation & Show------
        var gp_percentage=(100-total_cost_percent).toFixed(2);
        var gp_bdt=(per_piece_bd_value-total_cost_bdt).toFixed(3);
        var gp_usd=(per_piece_usd_value-total_cost_usd).toFixed(6);
        
        $('#gp_percentage').val(gp_percentage);
        $('#gp_bdt').val(gp_bdt);
        $('#gp_usd').val(gp_usd);

      //@@@@----END GP Calculation------


    }
    //@@@-Calculate Costing Edit Form 
    function ecalculateCosting(){
        
        var fob=$('#efob_in_ctn').val();
        var factor=$('#epcs_per_ctn').val();
        var conversion_rate=$('#econversion_rate_id').val();
        var ctn_per_container=$('#ectn_per_container').val();
        var pcs_per_container=$('#epcs_per_container').val();
        var factory_oh_percent=$('#efactory_oh_percent').val();
        var emanual_prime_cost=$('#emanual_prime_cost').val();
        var per_piece_bdt_amount=0;
        
        if(factor=="" || factor==0 || ctn_per_container=="" || pcs_per_container=="" || factory_oh_percent=="" || emanual_prime_cost=="" || emanual_prime_cost==0){
          
          makingInputZeroEditForm();

        }else{
          
          var per_piece_value_usd=fob/factor;
          var formated_per_piece_value_usd=per_piece_value_usd.toFixed(6);
          $('#eper_piece_usd_value').val(formated_per_piece_value_usd);
          per_piece_bdt_amount=per_piece_value_usd*conversion_rate;
          formated_per_piece_bdt_amount=per_piece_bdt_amount.toFixed(3);
          $('#eper_piece_bd_value').val(formated_per_piece_bdt_amount);
          if(per_piece_bdt_amount==0){
  
            makingInputZeroEditForm();
  
          }else{
  
            var per_piece_percent_value=0;
            $('#eper_piece_percent_value').val(per_piece_percent_value);
            var emanual_prime_cost=$('#emanual_prime_cost').val();
            var prime_cost=emanual_prime_cost/conversion_rate;
            var formated_prime_cost=prime_cost.toFixed(6);
            $('#eprime_cost_usd').val(formated_prime_cost);
  
            var efactory_oh_percent=0;
            var efactory_oh_bdt=0;
            var efactory_oh_usd=0;
            var formated_efactory_oh_percent=efactory_oh_percent.toFixed(2);  
            var formated_efactory_oh_bdt=efactory_oh_bdt.toFixed(3) 
            var formated_efactory_oh_usd=efactory_oh_usd.toFixed(6)  

            $('#efactory_oh_percent').val(formated_efactory_oh_percent);
            $('#efactory_oh_bdt').val(formated_efactory_oh_bdt);
            $('#efactory_oh_usd').val(formated_efactory_oh_usd);

            
  
  
            //carriage Chg Cal
  
            var carriage_per_container=$('#ecarriage_per_container').val();
            var pcs_per_container=$('#epcs_per_container').val();
            var carriage_percent_bdt=carriage_per_container/pcs_per_container;
            var formated_carriage_percent_bdt=carriage_percent_bdt.toFixed(3);
            $('#ecarriage_percent_bdt').val(formated_carriage_percent_bdt);
            var carriage_percent=(carriage_percent_bdt/per_piece_bdt_amount)*100;
            var formated_carriage_percent=carriage_percent.toFixed(2);          
            $('#ecarriage_percent').val(formated_carriage_percent);
            var carriage_percent_usd=carriage_percent_bdt/conversion_rate;
            var formated_carriage_percent_usd=carriage_percent_usd.toFixed(6);
            $('#ecarriage_percent_usd').val(formated_carriage_percent_usd);
  
  
            // C & F expenses Cal

            var cnf_charge=$('#ec_and_f_charge').val();
            var ctr_cnf_charge=cnf_charge*ctn_per_container;
            var cnf_exp_bdt=ctr_cnf_charge/pcs_per_container;
            var formated_cnf_exp_bdt=cnf_exp_bdt.toFixed(3);
            $('#ecnf_exp_bdt').val(formated_cnf_exp_bdt);
            var cnf_exp_percent=(cnf_exp_bdt/per_piece_bdt_amount)*100;
            var formated_cnf_exp_percent=cnf_exp_percent.toFixed(2);
            $('#ecnf_exp_percent').val(formated_cnf_exp_percent);
            var cnf_exp_usd=cnf_exp_bdt/conversion_rate;
            var formated_cnf_exp_usd=cnf_exp_usd.toFixed(6);
            $('#ecnf_exp_usd').val(formated_cnf_exp_usd);
  
           
            // Depot Chg Calculation cal 
            
            var depot_charge=$('#edepot_exp').val();
            console.log(depot_charge);
            var depot_exp_bdt=depot_charge/pcs_per_container;
            var formated_depot_exp_bdt=depot_exp_bdt.toFixed(3);
            $('#edepot_chg_bdt').val(formated_depot_exp_bdt);
            var depot_exp_percent=(depot_exp_bdt/per_piece_bdt_amount)*100;
            var formated_depot_exp_percent=depot_exp_percent.toFixed(2);
            $('#edepot_chg_percent').val(formated_depot_exp_percent);
            var depot_exp_usd=depot_exp_bdt/conversion_rate;
            var formated_depot_exp_usd=depot_exp_usd.toFixed(6);
            $('#edepot_chg_usd').val(formated_depot_exp_usd);   
  
            
  
            //Doc/Stamp/Bank Chg/collection chg cal
  
            var coln_chg=$('#ecoln_chg_id').val();
            var coln_chg_bdt=coln_chg/pcs_per_container; 
            var formate_coln_chg_bdt=coln_chg_bdt.toFixed(3);
            $('#ecollection_chg_bdt').val(formate_coln_chg_bdt);  
            var coln_chg_percent=(coln_chg_bdt/per_piece_bdt_amount)*100;
            var formated_coln_chg_percent=coln_chg_percent.toFixed(2);
            $('#ecollection_chg_percent').val(formated_coln_chg_percent);  
            var coln_chg_usd=coln_chg_bdt/conversion_rate;
            var formated_coln_chg_usd=coln_chg_usd.toFixed(6);
            $('#ecollection_chg_usd').val(formated_coln_chg_usd);  
            
            //insight gift  Cal
  
            var inside_gift=$('#einside_gift_id').val();
            var inside_gift_bdt=inside_gift/pcs_per_container;
            var formated_inside_gift_bdt=inside_gift_bdt.toFixed(3);
            $('#einsight_gift_bdt').val(formated_inside_gift_bdt);
            var inside_gift_percent=(inside_gift_bdt/per_piece_bdt_amount)*100;
            var formated_inside_gift_percent=inside_gift_percent.toFixed(2);
            $('#einsight_gift_percent').val(formated_inside_gift_percent);
            var insight_gift_usd=inside_gift_bdt/conversion_rate;
            var formated_insight_gift_usd=insight_gift_usd.toFixed(6);
            $('#einsight_gift_usd').val(formated_insight_gift_usd);   
  
            //others Cal
            var others=$('#eothers_id').val();
            var others_bdt=others/pcs_per_container;
            var formated_others_bdt=others_bdt.toFixed(3);
            $('#eothers_bdt').val(formated_others_bdt);
            var others_percent=(others_bdt/per_piece_bdt_amount)*100;
            var formated_others_percent=others_percent.toFixed(2);
            $('#eothers_percent').val(formated_others_percent);
            var others_bdt=others_bdt/conversion_rate;
            var formated_others_bdt=others_bdt.toFixed(6);
            $('#eothers_usd').val(formated_others_bdt);
            ecalculateTotalBdtAndUsd(per_piece_bdt_amount);
        
          }
          
        } 
  
    } // End Calculation
    //@@@-Make Input Zero--
    function makingInputZeroEditForm() {
       
          $('#eper_piece_percent_value').val(0);
          $('#eprime_cost_usd').val(0.00);
          $('#efactory_oh_usd').val(0.00);
          $('#efactory_oh_bdt').val(0.00);
          $('#ecarriage_percent_bdt').val(0.00);
          $('#ecarriage_percent').val(0.00);
          $('#ecarriage_percent_usd').val(0.00);
          $('#edepot_exp_percent').val(0.00);
          $('#edepot_exp_bdt').val(0.00);
          $('#edepot_exp_usd').val(0.00);
          $('#edoc_chg_bdt').val(0.00);
          $('#edoc_chg_usd').val(0.00); 
          $('#edoc_chg_percent').val(0.00);
          $('#ecollection_chg_bdt').val(0.00);  
          $('#ecollection_chg_percent').val(0.00);  
          $('#ecollection_chg_usd').val(0.00);
          $('#einsight_gift_bdt').val(0.00);
          $('#einsight_gift_percent').val(0.00);  
          $('#einsight_gift_usd').val(0.00);
          $('#eothers_bdt').val(0.00);
          $('#eothers_percent').val(0.00);   
          $('#eothers_usd').val(0.00);
          $('#etotal_oh_bdt').val(0.00);
          $('#etotal_oh_usd').val(0.00);  
          $('#etotal_oh_percent').val(0.00);
          $('#etotal_cost_bdt').val(0.00);
          $('#etotal_cost_usd').val(0.00);
          $('#etotal_cost_percent').val(0.00);
          $('#egp_percentage').val(0.00);
          $('#egp_bdt').val(0.00);
          $('#egp_usd').val(0.00);

    } //-End
    //@@@-Calculation total Bdt And Usd
    function ecalculateTotalBdtAndUsd(per_piece_bdt_amount){

      var factory_oh_bdt=parseFloat($('#efactory_oh_bdt').val());
      var carriage_percent_bdt=parseFloat($('#ecarriage_percent_bdt').val());
      var cnf_exp_bdt=parseFloat($('#ecnf_exp_bdt').val());
      var depot_exp_bdt=parseFloat($('#edepot_chg_bdt').val());
      var collection_chg_bdt=parseFloat($('#ecollection_chg_bdt').val());
      var insight_gift_bdt=parseFloat($('#einsight_gift_bdt').val());
      var others_bdt=parseFloat($('#eothers_bdt').val());
      var total_oh_bdt=(factory_oh_bdt+carriage_percent_bdt+cnf_exp_bdt+depot_exp_bdt+collection_chg_bdt+insight_gift_bdt+others_bdt);
      var formated_total_oh_bdt=total_oh_bdt.toFixed(3)
      $('#etotal_oh_bdt').val(formated_total_oh_bdt);

      var factory_oh_usd=parseFloat($('#efactory_oh_usd').val());
      var carriage_percent_usd=parseFloat($('#ecarriage_percent_usd').val());
      var cnf_exp_usd=parseFloat($('#ecnf_exp_usd').val());
      var depot_exp_usd=parseFloat($('#edepot_chg_usd').val());
      var collection_chg_usd=parseFloat($('#ecollection_chg_usd').val());
      var insight_gift_usd=parseFloat($('#einsight_gift_usd').val());
      var others_usd=parseFloat($('#eothers_usd').val());

      var total_oh_usd=(factory_oh_usd+carriage_percent_usd+cnf_exp_usd+depot_exp_usd+collection_chg_usd+insight_gift_usd+others_usd);
      var formated_total_oh_usd=total_oh_usd.toFixed(6)   
      $('#etotal_oh_usd').val(formated_total_oh_usd);   
      
      var total_oh_percent=((total_oh_bdt/per_piece_bdt_amount)*100);
      var formated_total_oh_percent=total_oh_percent.toFixed(2)
      $('#etotal_oh_percent').val(formated_total_oh_percent);
      
      var total_cost_bdt=(parseFloat(total_oh_bdt)+parseFloat($('#emanual_prime_cost').val()));
      var formated_total_cost_bdt=total_cost_bdt.toFixed(3);
      $('#etotal_cost_bdt').val(formated_total_cost_bdt);

      var total_cost_usd=(parseFloat(total_oh_usd)+parseFloat($('#eprime_cost_usd').val()));
      var formated_total_cost_usd=total_cost_usd.toFixed(6);
      $('#etotal_cost_usd').val(formated_total_cost_usd);

      var total_cost_percent=((total_cost_bdt/per_piece_bdt_amount)*100);
      var formated_total_cost_percent=total_cost_percent.toFixed(2)
      $('#etotal_cost_percent').val(formated_total_cost_percent);


      var per_piece_bd_value=parseFloat($('#eper_piece_bd_value').val());
      var per_piece_usd_value=parseFloat($('#eper_piece_usd_value').val());

      var gp_percentage=(100-total_cost_percent).toFixed(2);
      var gp_bdt=(per_piece_bd_value-total_cost_bdt).toFixed(3);
      var gp_usd=(per_piece_usd_value-total_cost_usd).toFixed(6);

      $('#egp_percentage').val(gp_percentage);
      $('#egp_bdt').val(gp_bdt);
      $('#egp_usd').val(gp_usd);

    } //-End
    //@@@-Validation Check----
    function checkValidation(party_code,item,location,sales_term,container_size,container_category,manual_prime_cost,prime_cost_bdt,factory_oh_percent,gp_percentage){
      
      var status=true;
      if(party_code==""){
        
        Swal.fire({
          icon: 'warning',
          title: 'Alert',
          text: 'Party Code Cannot Empty..!!'
        });
        status=false;

      }

      if(item==""){
        
        Swal.fire({
          icon: 'warning',
          title: 'Alert',
          text: 'Item Code Cannot Empty..!!'
        });
        status=false;
        
      }

      if(location==""){
        
        Swal.fire({
          icon: 'warning',
          title: 'Alert',
          text: 'Location Cannot Empty..!!'
        });
        status=false;

      }

      if(sales_term==""){
         
        Swal.fire({
          icon: 'warning',
          title: 'Alert',
          text: 'Sales Term Cannot Empty..!!'
        });
        status=false;

      }

      if(container_size==""){
        
        Swal.fire({
          icon: 'warning',
          title: 'Alert',
          text: 'Container Size Cannot Empty..!!'
        });
        status=false;

      }

      if(container_category==""){
         
         Swal.fire({
          icon: 'warning',
          title: 'Alert',
          text: 'Container Category Cannot Empty..!!'
         });
         status=false;
 
      }

      if(factory_oh_percent==""){
         
        Swal.fire({
          icon: 'warning',
          title: 'Alert',
          text: 'Factory OH Cannot Empty..!!'
        });
        status=false;
          
      }

      if(gp_percentage < 0){
         
         Swal.fire({
          icon: 'warning',
          title: 'Alert',
          text: 'GP Never Can - Negative Value..!!'
         });
         status=false;
 
      }

      return status;

    } 
    //@@ Calculation CFR OR CIF/CTN On Create
    function calCFROrCIF() {
       
      var fob = parseFloat($('#fob_in_ctn').val()) || 0;
      var pcs_per_ctn = parseFloat($('#pcs_per_ctn').val()) || 0;

      if(fob){
          
          var freight_chg=parseFloat($('#freight_chg').val()) ? parseFloat($('#freight_chg').val()) : 0;
          var ins_chg=parseFloat($('#ins_chg').val()) ? parseFloat($('#ins_chg').val()) : 0;
          var ctn_per_container=parseFloat($('#ctn_per_container').val()) ? parseFloat($('#ctn_per_container').val()) : 0;
          if(ctn_per_container){

            var freight_plus_ins=freight_chg+ins_chg;
            var freight_plus_ins_per_ctn=(freight_plus_ins/ctn_per_container+fob).toFixed(6);
            $('#cif_or_cfr_rate_per_ctn').val(freight_plus_ins_per_ctn);

            if(pcs_per_ctn){
                    
              freight_plus_ins_per_piece=(freight_plus_ins_per_ctn/pcs_per_ctn).toFixed(6);
              $('#cif_or_cfr_rate_per_piece').val(freight_plus_ins_per_piece);

            }

          }else{

            $('#cif_or_cfr_rate_per_ctn').val('0');
            $('#cif_or_cfr_rate_per_piece').val('0');

          }

      }else{
          
          $('#cif_or_cfr_rate_per_ctn').val('0');
          $('#cif_or_cfr_rate_per_piece').val('0');

      }


    } //@@ End 

    //@@ Calculation CFR OR CIF/CTN On edit
    function calCFROrCIFOnEdit() {
       
       var fob = parseFloat($('#efob_in_ctn').val()) || 0;
       var pcs_per_ctn = parseFloat($('#epcs_per_ctn').val()) || 0; 
       if(fob){
           
           var freight_chg=parseFloat($('#efreight_chg').val()) ? parseFloat($('#efreight_chg').val()) : 0;
           var ins_chg=parseFloat($('#eins_chg').val()) ? parseFloat($('#eins_chg').val()) : 0;
           var ctn_per_container=parseFloat($('#ectn_per_container').val()) ? parseFloat($('#ectn_per_container').val()) : 0;
           if(ctn_per_container){
 
             var freight_plus_ins=freight_chg+ins_chg;
             var freight_plus_ins_per_ctn=(freight_plus_ins/ctn_per_container+fob).toFixed(6);
             $('#ecif_or_cfr_rate_per_ctn').val(freight_plus_ins_per_ctn);
 
             if(pcs_per_ctn){
                     
               freight_plus_ins_per_piece=(freight_plus_ins_per_ctn/pcs_per_ctn).toFixed(6);
               $('#ecif_or_cfr_rate_per_piece').val(freight_plus_ins_per_piece);
 
             }
 
           }else{
             
             $('#ecif_or_cfr_rate_per_ctn').val('0');
             $('#ecif_or_cfr_rate_per_piece').val('0');

           }
 
       }else{
           
           $('#ecif_or_cfr_rate_per_ctn').val('0');
           $('#ecif_or_cfr_rate_per_piece').val('0');
 
       }
 
 
    }//@@ End

    $(document).on("click", "#create_btn", function () {
       
       var url = "{{url('/get/costing/cvr_and_hd/cost')}}";
       $.get(url,function(res){
             
          $('#conversion_rate_id').val(res.cvr_rate);
          $('#c_and_f_charge').val(res.cnf_charage);
          $('#coln_chg_id').val(res.doc_charge);
          $('#inside_gift_id').val(res.inside_gift);
          $('#others_id').val(res.others);
          $("#createModel").modal("show");

       }); 
 
    });

    $('#example1 tbody').on('click', '.btn-edit', function (e) {


       var isApproveDisabled = $(this).closest('tr').find('.btn-approve').prop('disabled');
       if(isApproveDisabled==true){
          
        $('.btn-update').hide();

       }else{
        
        $('.btn-update').show();

       }
       var edit_id = $(this).data("id");
       var url = "{{url('/costing')}}/"+edit_id;
       $.get(url,function(res) {


            if(res.sales_term=='FOB'){
      
              $('.cif_cfr_div_id').hide();

            }else{
              
              $('.cif_cfr_div_id').show();

            }

            $('#ecountry').val(res.masterInfo.notify_party.country);
            $('#eregion').val(res.masterInfo.notify_party.region);
            $('#ezone').val(res.masterInfo.notify_party.zone);
            $("#ebu").val(res.masterInfo.bu);
            $("#ectn_per_container").val(res.masterInfo.ctn_per_container);
            $("#epcs_per_container").val(res.masterInfo.pcs_per_container);
            $("#epcs_per_ctn").val(res.masterInfo.pcs_per_ctn); 
            $("#ecarriage_per_container").val(res.masterInfo.carriage_per_container);
            $("#ec_and_f_charge").val(res.masterInfo.cnf_charge);
            $("#edepot_exp").val(res.masterInfo.depot_exp);
            $("#ecoln_chg_id").val(res.masterInfo.doc_chg);
            $("#einside_gift_id").val(res.masterInfo.inside_gift_id);
            $("#eothers_id").val(res.masterInfo.others_id);
            $("#efreight_chg").val(res.masterInfo.freight_chg);
            $("#eins_chg").val(res.masterInfo.ins_chg);
            $("#eins_chg").val(res.masterInfo.ins_chg);
            $("#ecif_or_cfr_rate_per_ctn").val(res.costingDetails.cif_or_cfr_rate_per_ctn);
            $("#ecif_or_cfr_rate_per_piece").val(res.costingDetails.cif_or_cfr_rate_per_piece);
            $.each(res.salesTerm, function (key, value) {
            
              $('select[name="esales_term"]').append(`<option value="${value.name}" ${value.name == res.masterInfo.sales_term ? 'selected' : ''}>${value.name}</option>`)
              
            });
              
            $.each(res.container_sizes, function(key, value) {
                
              $('select[name="econtainer_size"]').append(`<option value="${value.name}" ${value.name == res.masterInfo.container_size ? 'selected' : ''}>${value.name}</option>`)
                  
            });
            
            $.each(res.container_cats, function(key, value){
                
                $('select[name="econtainer_category"]').append(`<option value="${value.name}" ${value.name == res.masterInfo.container_category ? 'selected' : ''}>${value.name}</option>`)
                  
            }); 
            
            $.each(res.notifyParties, function (key, value) {
              
                $('select[name="eparty_code"]').append(`<option value="${value.code}" ${value.id == res.masterInfo.party_id ? 'selected' : ''}>${value.code}-${value.name}</option>`)
  
            });

            $('select[name="eparty_code"]').trigger('change');

            $.each(res.partyItems, function (key, value) {
              
              $('select[name="eitem"]').append(`<option value="${value.item_code}" ${value.id == res.masterInfo.item_id ? 'selected' : ''}>${value.item_code}-${value.item_name}</option>`)

            });

            $('select[name="eitem"]').trigger('change');
            loadLocation(res.locations,res.masterInfo.location_id);

            $('#emanual_prime_cost').val(res.costingDetails.manual_prime_cost);
            $('#eprime_cost_bdt').val(res.costingDetails.prime_cost_bdt);
            $('#eprime_cost_usd').val(res.costingDetails.prime_cost_usd);
            $('#efactory_oh_percent').val(parseFloat(res.costingDetails.factory_oh_percent).toFixed(2));
            $('#efactory_oh_bdt').val(parseFloat(res.costingDetails.factory_oh_bdt).toFixed(3));
            $('#efactory_oh_usd').val(parseFloat(res.costingDetails.factory_oh_usd).toFixed(6));
            $('#ecarriage_percent').val(parseFloat(res.costingDetails.carriage_percent).toFixed(2));
            $('#ecarriage_percent_bdt').val(parseFloat(res.costingDetails.carriage_percent_bdt).toFixed(3));
            $('#ecarriage_percent_usd').val(parseFloat(res.costingDetails.carriage_percent_usd).toFixed(6));
             
            $('#ecnf_exp_percent').val(parseFloat(res.costingDetails.cnf_exp_percent).toFixed(2));
            $('#ecnf_exp_bdt').val(parseFloat(res.costingDetails.cnf_exp_bdt).toFixed(3));
            $('#ecnf_exp_usd').val(parseFloat(res.costingDetails.cnf_exp_usd).toFixed(6));

            $('#edepot_chg_percent').val(parseFloat(res.costingDetails.depot_exp_percent).toFixed(2));
            $('#edepot_chg_bdt').val(parseFloat(res.costingDetails.depot_exp_bdt).toFixed(3));
            $('#edepot_chg_usd').val(parseFloat(res.costingDetails.depot_exp_usd).toFixed(6));
            $('#ecollection_chg_percent').val(parseFloat(res.costingDetails.collection_chg_percent).toFixed(2));
            $('#ecollection_chg_bdt').val(parseFloat(res.costingDetails.collection_chg_bdt).toFixed(3));
            $('#ecollection_chg_usd').val(parseFloat(res.costingDetails.collection_chg_usd).toFixed(6));
            $('#einsight_gift_percent').val(parseFloat(res.costingDetails.insight_gift_percent).toFixed(2));
            $('#einsight_gift_bdt').val(parseFloat(res.costingDetails.insight_gift_bdt).toFixed(3));
            $('#einsight_gift_usd').val(parseFloat(res.costingDetails.insight_gift_usd).toFixed(6));
            $('#eothers_percent').val(parseFloat(res.costingDetails.others_percent).toFixed(2));
            $('#eothers_bdt').val(parseFloat(res.costingDetails.others_bdt).toFixed(3));
            $('#eothers_usd').val(parseFloat(res.costingDetails.others_usd).toFixed(6));
            $('#etotal_oh_percent').val(parseFloat(res.costingDetails.total_oh_percent).toFixed(2));
            $('#etotal_oh_bdt').val(parseFloat(res.costingDetails.total_oh_bdt).toFixed(3));
            $('#etotal_oh_usd').val(parseFloat(res.costingDetails.total_oh_usd).toFixed(6));
            $('#etotal_cost_percent').val(parseFloat(res.costingDetails.total_cost_percent).toFixed(3));
            $('#etotal_cost_bdt').val(parseFloat(res.costingDetails.total_cost_bdt).toFixed(2));
            $('#etotal_cost_usd').val(parseFloat(res.costingDetails.total_cost_usd).toFixed(6));
            $('#egp_percentage').val(parseFloat(res.costingDetails.gp_percentage).toFixed(2));
            $('#egp_bdt').val(parseFloat(res.costingDetails.gp_bdt).toFixed(3));
            $('#egp_usd').val(parseFloat(res.costingDetails.gp_usd).toFixed(6));
            $('#eper_piece_percent_value').val(parseFloat(res.costingDetails.per_piece_percent_value).toFixed(2));
            $('#eper_piece_bd_value').val(parseFloat(res.costingDetails.per_piece_bd_value).toFixed(3));
            $('#eper_piece_usd_value').val(parseFloat(res.costingDetails.per_piece_usd_value).toFixed(6));
            $('#efob_in_percent').val(res.costingDetails.fob_in_percent);
            $('#efob_in_bdt').val(res.costingDetails.fob_in_bdt);
            $('#efob_in_ctn').val(res.costingDetails.fob_in_ctn);
            $('#econversion_rate_id').val(res.costingDetails.conversion_rate);
            $('#edit_id').val(res.costingDetails.id);
            $("#EditModel").modal("show");

       }); 
      

    });//@@@--End Edit 

    function loadLocation(data,location_id){
          
        var $el = $('#elocation');
        $el.html(' ');
        $el.append($("<option></option>").attr("value", "").text("Select"));
        $.each(data, function (key, value) {
            
          $('select[name="elocation"]').append(`<option value="${value.id}" ${value.id == location_id ? 'selected' : ''}>${value.name}</option>`)

        });

        $el.selectpicker('refresh');

    }

    $('#example1 tbody').on('click', '.btn-approve', function (e) {
       
        var approve_id = $(this).data("id");
        var approveButton = $(this);
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, Approved it!"
        }).then((result) => {

          if (result.isConfirmed) {
              
            var url = "{{url('/approve/costing')}}/"+approve_id;
            $.get(url,function(res) {
               
              if(res.code==200){
               
                Swal.fire({
                  icon: "success",
                  title: "Success!",
                  text: res.message
                });

                approveButton.prop('disabled', true);
              
              }else if(res.code==500){
                 
                Swal.fire({
                  icon: "warning",
                  title: "Alert!",
                  text: res.message
                });
              
              }else if(res.code==409){
                 
                 Swal.fire({
                   icon: "warning",
                   title: "Alert!",
                   text: res.message
                 });
               
               }  


            });
             

          }

        });

    });    
</script>
@endsection