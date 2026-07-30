@extends('layouts.master')
@section('content') 
<style>
.form-control {

  border-radius: 0;
  box-shadow: none;
  height: 25px;
  width: 83px;
  font-size: 11px;

 }

 .ms-options-wrap > button {

    position: relative;
    width: 100%;
    text-align: left;
    border: 1px solid #aaa;
    background-color: #fff;
    padding: 0px 15px 4px 5px;
    margin-top: 0px;
    font-size: 13px;
    color: #aaa;
    outline: none;
    white-space: nowrap;

  }

 .form-group {

   margin-bottom: 0px;

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
.btn{

  padding: 3px 12px;
  padding-right: 12px;
  margin-bottom: 0;
  font-size: 12px;
  font-weight: 400;
  line-height: 1.42857143;
  text-align: center;
  white-space: nowrap;
  touch-action: manipulation;
  cursor: pointer;
  user-select: none;
  background-image: none;

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


.modal-title{
    text-align: left;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: bold;
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
  font-size: 12px;

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
  font-size: 11px;

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

::-webkit-input-placeholder {
  font-size: 11px; /* Adjust the font size as needed */
}

:-moz-placeholder {
  font-size: 11px; /* Adjust the font size as needed */
}

::-moz-placeholder {
  font-size: 11px; /* Adjust the font size as needed */
}

:-ms-input-placeholder {
  font-size: 11px; /* Adjust the font size as needed */
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
  border-top: 1px solid #c4c2c2;

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

/* Autocomplete styles */
.autocomplete-results {
    position: absolute;
    z-index: 1000;
    width: 100%;
    max-height: 300px;
    overflow-y: auto;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-top: 2px;
}

.autocomplete-item {
    padding: 8px 12px;
    cursor: pointer;
    border-bottom: 1px solid #b3a0a0;
    font-size: 14px;
}

.autocomplete-item:hover {
    background-color: #f5f5f5;
}

.autocomplete-item.selected {
    background-color: #a5e38f;
}

.autocomplete-item .item-code {
    font-weight: bold;
    color: #2575fc;
}

.autocomplete-item .item-name {
    color: #333;
}

hr{

  margin-top: 36px;
  margin-bottom: -20px;
  border-top: 1px solid #d7d2d2;
}
.fixed-width-select{

  position: absolute;
  top: -3px;
  width: 261px !important;

}
#copy_modal-style{
  position: relative;
  top: -12px;
  margin-left: 96px;
  height: 300px;
}

.row-status-inactive td {
    background-color: #cc0924 !important;
    color: #f0e0e0;
}

/*spinner style */
    .spinner-container {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9999;
    }

    .spinner {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 50px;
      height: 50px;
      border: 3px solid #f3f3f3;
      border-radius: 50%;
      border-top: 3px solid #3498db;
      width: 50px;
      height: 50px;
      -webkit-animation: spin 2s linear infinite;
      animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

  /*End*/

  @media (min-width: 768px) {
    .modal-dialog {
      width: 800px;
      margin: 30px auto;
    }
  }

  .upload-container {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }
        .upload-icon {
            font-size: 3rem;
            color: #2575fc;
            margin-bottom: 15px;
        }
        .btn-upload {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(37, 117, 252, 0.4);
        }
        .features-list {
            list-style-type: none;
            padding: 0;
        }
        .features-list li {
            padding: 10px 0;
            padding-left: 35px;
            position: relative;
        }
        .features-list li i {
            position: absolute;
            left: 0;
            top: 12px;
            color: #6a11cb;
            font-size: 1.2rem;
        }
        .modal-content {
            border-radius: 12px;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        .modal-header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
        }
        .modal-title {
            font-weight: 600;
        }
        .close {
            color: white;
            opacity: 0.8;
        }
        .file-upload-container {
            border: 2px dashed #ced4da;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            margin: 20px 0;
            transition: all 0.3s;
            background-color: #f8f9fa;
        }
        .file-upload-container:hover {
            border-color: #6a11cb;
            background-color: #eef4ff;
        }
        .file-input {
            display: none;
        }
        .file-label {
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .file-label i {
            font-size: 3rem;
            color: #6a11cb;
            margin-bottom: 15px;
        }
        .file-label h5 {
            color: #495057;
            margin-bottom: 10px;
        }
        .file-label p {
            color: #6c757d;
            margin-bottom: 0;
        }
        .file-name {
            margin-top: 15px;
            font-weight: 500;
            color: #495057;
        }
        .requirements {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 10px;
        }
        .btn-modal {
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 6px;
        }
        .instructions {
            background-color: #eef4ff;
            border-left: 4px solid #6a11cb;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            color: #6c757d;
            font-size: 0.9rem;
        }

</style>
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/notify_party_item')}}"><i class="fa fa-dashboard"></i>Party Item List</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px">
        <form class="form-inline">
          <div class="box-header with-border">
            <div class="col-sm-4">
                <label for="name">Notify Party :</label>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <select name="party_id" id="party_id" data-live-search="true" class="form-control select2 selectpicker fixed-width-select" required autofocus type="select"  value="1" style="position: absolute">
                        <option value="">Select</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4 col-md-offset-4">
                <button class="form-control btn btn-xs btn-primary" id="add_item_btn_id">Add Item</button>
                <button class="form-control btn btn-xs btn-info" id="copy_item_btn_id">Copy Item</button>
                <button class="form-control btn btn-xs btn-success" id="upload_excel_btn_id" style="background: #ff2f73;">Upload Excel</button>
            </div>
            <hr>
          </div>
        </form>  
        <div class="panel-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive table-condenced" style="font-size: 12px">
              <thead style="font-size: 12px">
                    <tr>
                        <th>SL#</th>
                        <th>Item_Code</th>
                        <th style="width: 250px">Item Name</th>
                        <th style="width: 280px">Desk Name</th>
                        <th>Acct_Rate</th>
                        <th>Party_Rate</th>
                        <th>FOB</th>
                        <th>CBM</th>
                        <th>Gross_Weight</th>
                        <th>Shelf_Life</th>
                        <th style="width:90px">Is_assigned</th>
                        <th>Factory</th>
                        <th>HS_Code2</th>
                        <th>Status</th>
                        <th>Controls</th>
                    </tr>  
              </thead>
              <div class="spinner-container" id="spinner-container">
                <div class="spinner"></div>
              </div>
              <tbody>

              </tbody>
          </table>
        </div>
    </div>
  </div>
</div>
<!--@@@@@@@ Item Added Modal @@@@@@@-->
<div class="modal fade" id="ItemAddedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form enctype="multipart/form-data" id="addSubmitFormId">
    {{csrf_field()}} 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Added Party Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">  
          <div class="box-header with-border">
            <div class="col-sm-4">
                <label for="notify_party_id" id="notify_party_id">Notify Party :</label>
                <div class="form-group {{ $errors->has('notify_party_id') ? 'has-error' : '' }}">
                    <select name="party_code" id="party_code" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                      <option value="">Select</option>
                      
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="dunit_id" id="party">DUnit :</label>
                <div class="form-group {{ $errors->has('dunit_id') ? 'has-error' : '' }}">
                    <select name="dunit_id" id="dunit_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                         <option value="">Select</option>
                         @foreach($dunits as $dunit)
                         <option value="{{$dunit->id}}">{{$dunit->dunit_name}}</option>
                         @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="runit_id" id="party">RUnit :</label>
                <div class="form-group {{ $errors->has('runit_id') ? 'has-error' : '' }}">
                    <select name="runit_id" id="runit_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                         <option value="">Select</option>
                         @foreach($runits as $runit)
                         <option value="{{$runit->id}}">{{$runit->runit_name}}</option>
                         @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="ci_item_id" id="party">Item :</label>
                <div class="form-group {{ $errors->has('ci_item_id') ? 'has-error' : '' }}">
                    <input type="text" 
                          name="ci_item_search" 
                          id="ci_item_search" 
                          class="form-control" 
                          placeholder="Search Item (Type at least 2 characters)" 
                          autocomplete="off"
                          style="width: 100%;">
                    <input type="hidden" name="ci_item_id" id="ci_item_id" value="">
                    <div id="item_results" class="autocomplete-results" style="display:none;"></div>
                </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('desk_item_name') ? 'has-error' : '' }}">
                  <label for="desk_item_name">Desk Item Name</label>
                  <input name="desk_item_name" type="text" id="desk_item_name"class="form-control"  value=""    autofocus placeholder="Enter desk item name"  autocomplete="off"  is_date="1" style="width: 150px">
                  @if ($errors->has('desk_item_name'))
                      <span class="help-block"><strong>{{ $errors->first('desk_item_name') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('acc_rate') ? 'has-error' : '' }}">
                  <label for="acc_rate">Acc Rate</label>
                  <input name="acc_rate" type="number" id="acc_rate" class="form-control"   value=""   required autofocus step="any"  placeholder="Enter Acc rate" style="width: 218px">
                  @if ($errors->has('acc_rate'))
                      <span class="help-block"><strong>{{ $errors->first('acc_rate') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('percentage') ? 'has-error' : '' }}">
                  <label for="percentage">Percentage</label>
                  <input name="percentage" type="text" id="percentage"class="form-control"  value=""    autofocus placeholder="Enter Percentage"  autocomplete="off"  is_date="1" style="width: 150px" onkeyup="getPercenatage()">
                  @if ($errors->has('percentage'))
                      <span class="help-block"><strong>{{ $errors->first('percentage') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('party_rate') ? 'has-error' : '' }}">
                  <label for="party_rate">Party Rate</label>
                  <input name="party_rate" type="text" id="party_rate"class="form-control"  value=""    autofocus placeholder="Enter Party Rate"  autocomplete="off"  is_date="1" style="width: 150px" required>
                  @if ($errors->has('party_rate'))
                      <span class="help-block"><strong>{{ $errors->first('party_rate') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('cbm_per_ctn') ? 'has-error' : '' }}">
                  <label for="cbm_per_ctn">CBM</label>
                  <input name="cbm_per_ctn" type="text" id="cbm_per_ctn"class="form-control"  value=""    autofocus placeholder="Enter CBM"  autocomplete="off"  is_date="1" style="width: 218px" required>
                  @if ($errors->has('cbm_per_ctn'))
                      <span class="help-block"><strong>{{ $errors->first('cbm_per_ctn') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('gross_weight') ? 'has-error' : '' }}">
                  <label for="gross_weight">Gross Weight</label>
                  <input name="gross_weight" type="text" id="gross_weight"class="form-control"  value=""    autofocus placeholder="Enter Gross Weight"  autocomplete="off"  is_date="1" style="width: 150px" required>
                  @if ($errors->has('gross_weight'))
                      <span class="help-block"><strong>{{ $errors->first('gross_weight') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('shelf_life') ? 'has-error' : '' }}">
                  <label for="shelf_life">Shelf Life</label>
                  <input name="shelf_life" type="text" id="shelf_life"class="form-control"  value=""    autofocus placeholder="Enter Shelf Life"  autocomplete="off"  is_date="1" style="width: 150px" required>
                  @if ($errors->has('shelf_life'))
                      <span class="help-block"><strong>{{ $errors->first('shelf_life') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
                <label for="factory_id" id="party">Factory :</label>
                <div class="form-group {{ $errors->has('factory_id') ? 'has-error' : '' }}">
                    <select name="factory_id" id="factory_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                         <option value="">Select</option>
                         @foreach($productionFloors as $productionFloor)
                         <option value="{{$productionFloor->id}}">{{$productionFloor->p_code}}->{{$productionFloor->short_name}}</option>
                         @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('hs_code2') ? 'has-error' : '' }}">
                  <label for="hs_code2">HS Code_2</label>
                  <input name="hs_code2" type="text" id="hs_code2"class="form-control"  value=""    autofocus placeholder="Enter HS Code_2"  autocomplete="off"  is_date="1" style="width: 150px">
                  @if ($errors->has('hs_code2'))
                      <span class="help-block"><strong>{{ $errors->first('hs_code2') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-8">
              <div class="form-group {{ $errors->has('export_date') ? 'has-error' : '' }}">
                  <label for="export_date">Coding Matter</label>
                  <textarea class="form-control" rows="2" cols="200" style="min-width: 434px; height: 79px; width: 480px;" name="coding_matter" placeholder="Enter Your Coding matter"></textarea>
                  @if ($errors->has('export_date'))
                      <span class="help-block"><strong>{{ $errors->first('export_date') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group {{ $errors->has('export_date') ? 'has-error' : '' }}">
                  <label for="export_date">Special Requirment</label>
                  <textarea class="form-control" rows="2" cols="200" style="width: 355px; height: 82px;" name="special_requirment" placeholder="Enter Your Special Requirment"></textarea>
                  @if ($errors->has('export_date'))
                      <span class="help-block"><strong>{{ $errors->first('export_date') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('ingredient') ? 'has-error' : '' }}">
                  <label for="ingredient">Ingredient</label>
                  <textarea class="form-control" rows="2" cols="200" style="width: 355px; height: 82px;" name="ingredient" placeholder="Enter Your Item Ingredient"></textarea>
                  @if ($errors->has('ingredient'))
                      <span class="help-block"><strong>{{ $errors->first('ingredient') }}</strong></span>
                  @endif
              </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
    </form>
  </div>
</div><!--@@@@@@@ End Modal @@@@@@@-->
<!--@@@@@@@ Item Copy Modal @@@@@@@-->
<div class="modal fade" id="copyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form enctype="multipart/form-data" id="copySubmitFormId">
    {{csrf_field()}} 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Copy Item Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="copy_modal-style">
          <div class="box-header with-border">
            <div class="col-sm-10">
                <label for="notify_party_id" id="notify_party_id">From Party:</label>
                <div class="form-group {{ $errors->has('notify_party_id') ? 'has-error' : '' }}">
                    <select name="from_party_code" id="from_party_code" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                    </select>
                </div>
            </div>
            <div class="col-sm-10">
              <label for="ci_item_id" id="party">Item :</label>
              <div class="form-group {{ $errors->has('ci_item_id') ? 'has-error' : '' }}">
                  <select name="ci_item_list[]" autofocus multiple id="ci_item_list">

                  </select>
              </div>
            </div>
            <div class="col-sm-10">
              <label for="notify_party_id" id="notify_party_id">To Party :</label>
              <div class="form-group {{ $errors->has('notify_party_id') ? 'has-error' : '' }}">
                  <select name="to_party_code" id="to_party_code" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                  </select>
              </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Copy</button>
      </div>
    </div>
    </form>
  </div>
</div><!--@@@@@@@ End Modal @@@@@@@-->
<!--@@@@@@@ Item Excel Upload @@@@@@@-->
<div class="modal fade" id="excel_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form enctype="multipart/form-data" id="uploadExcelFormId">
    {{csrf_field()}} 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Excel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="box-header with-border">
              <form id="uploadExcelForm" enctype="multipart/form-data">
                  <div class="modal-body">
                      <div class="file-upload-container">
                         <input type="file" name="excel_file" id="excelFile" class="file-input" accept=".xlsx, .xls" style="display: none">
                          <label for="excelFile" class="file-label">
                              <i class="fa fa-cloud-upload" style="font-size: 50px;"></i>
                              <h5 style="margin-top: -7px;">Drag & Drop or Click to Upload</h5>
                              <p>Supported formats: .xlsx, .xls</p>
                          </label>
                          <div id="fileName" class="file-name"></div>
                      </div>
                  </div>
              </form>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
    </div>
    </form>
  </div>
</div><!--@@@@@@@ End Modal @@@@@@@-->
<!--@@@@@@@ Item Edit Modal @@@@@@@-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div id="errorContainer" style="display:none; margin-top:10px;"></div>
  <div class="modal-dialog" role="document">
    <form enctype="multipart/form-data" id="upateSubmitFormId">
      {{csrf_field()}} 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Party Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="box-header with-border">
            <div class="col-sm-4">
                <label for="notify_party_id" id="notify_party_id">Notify Party :</label>
                <div class="form-group {{ $errors->has('notify_party_id') ? 'has-error' : '' }}">
                    <select name="notify_party_id" id="enotify_party_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                      <option value="">Select</option>
                      
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="dunit_id" id="party">DUnit :</label>
                <div class="form-group {{ $errors->has('dunit_id') ? 'has-error' : '' }}">
                    <select name="dunit_id" id="edunit_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                         <option value="">Select</option>
                        
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="runit_id" id="party">RUnit :</label>
                <div class="form-group {{ $errors->has('runit_id') ? 'has-error' : '' }}">
                    <select name="runit_id" id="erunit_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                         <option value="">Select</option>
                         @foreach($runits as $runit)
                         <option value="{{$runit->id}}">{{$runit->runit_name}}</option>
                         @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
              <label for="ci_item_id" id="party">Item :</label>
              <div class="form-group {{ $errors->has('ci_item_id') ? 'has-error' : '' }}">
                  <select name="ci_item_id" id="eci_item_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                       
                  </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('desk_item_name') ? 'has-error' : '' }}">
                  <label for="desk_item_name">Desk Item Name</label>
                  <input name="desk_item_name" type="text" id="edesk_item_name"class="form-control"  value=""    autofocus placeholder=""  autocomplete="off"  is_date="1" style="width: 150px" required>
                  @if ($errors->has('desk_item_name'))
                      <span class="help-block"><strong>{{ $errors->first('desk_item_name') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('acc_rate') ? 'has-error' : '' }}">
                  <label for="acc_rate">Acc Rate(< <span id="acc_rate_id"></span>)</label>
                  <input name="acc_rate" type="text" id="eacc_rate"class="form-control"  value=""    autofocus placeholder="Enter Acc Rate"  autocomplete="off"  is_date="1" style="width: 217px" required>
                  @if ($errors->has('acc_rate'))
                      <span class="help-block"><strong>{{ $errors->first('acc_rate') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('percentage') ? 'has-error' : '' }}">
                  <label for="percentage">Percentage</label>
                  <input name="percentage" type="text" id="epercentage"class="form-control"  value=""    autofocus placeholder="Export date"  autocomplete="off"  is_date="1" style="width: 150px">
                  @if ($errors->has('percentage'))
                      <span class="help-block"><strong>{{ $errors->first('percentage') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('party_rate') ? 'has-error' : '' }}">
                  <label for="party_rate">Party Rate</label>
                  <input name="party_rate" type="text" id="eparty_rate"class="form-control"  value=""    autofocus placeholder="Export date"  autocomplete="off"  is_date="1" style="width: 150px">
                  @if ($errors->has('party_rate'))
                      <span class="help-block"><strong>{{ $errors->first('party_rate') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('cbm_per_ctn') ? 'has-error' : '' }}">
                  <label for="cbm_per_ctn">CBM</label>
                  <input name="cbm_per_ctn" type="text" id="ecbm_per_ctn"class="form-control"  value=""    autofocus placeholder="Export date"  autocomplete="off"  is_date="1" style="width: 217px">
                  @if ($errors->has('cbm_per_ctn'))
                      <span class="help-block"><strong>{{ $errors->first('cbm_per_ctn') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('gross_weight') ? 'has-error' : '' }}">
                  <label for="gross_weight">Gross Weight</label>
                  <input name="gross_weight" type="text" id="egross_weight"class="form-control"  value=""    autofocus placeholder="Export date"  autocomplete="off"  is_date="1" style="width: 150px">
                  @if ($errors->has('gross_weight'))
                      <span class="help-block"><strong>{{ $errors->first('gross_weight') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('shelf_life') ? 'has-error' : '' }}">
                  <label for="shelf_life">Shelf Life</label>
                  <input name="shelf_life" type="text" id="eshelf_life"class="form-control"  value=""    autofocus placeholder="Export date"  autocomplete="off"  is_date="1" style="width: 150px">
                  @if ($errors->has('shelf_life'))
                      <span class="help-block"><strong>{{ $errors->first('shelf_life') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-4">
                <label for="factory_id" id="party">Factory :</label>
                <div class="form-group {{ $errors->has('factory_id') ? 'has-error' : '' }}">
                    <select name="factory_id" id="efactory_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                         <option value="">Select</option>
                         
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group {{ $errors->has('shelf_life') ? 'has-error' : '' }}">
                  <label for="shelf_life">HS Code_2</label>
                  <input name="hs_code2" type="text" id="ehs_code2"class="form-control"  value=""    autofocus placeholder="Export HS Code2"  autocomplete="off"  is_date="1" style="width: 150px">
                  @if ($errors->has('shelf_life'))
                      <span class="help-block"><strong>{{ $errors->first('shelf_life') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-8">
              <div class="form-group {{ $errors->has('export_date') ? 'has-error' : '' }}">
                  <label for="export_date">Coding Matter</label>
                  <textarea class="form-control" name="coding_matter" rows="2" cols="200" style="width: 468px;height: 80px" id="ecoding_matter" placeholder="Enter Your Coding Matter"></textarea>
                  @if ($errors->has('export_date'))
                      <span class="help-block"><strong>{{ $errors->first('export_date') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group {{ $errors->has('export_date') ? 'has-error' : '' }}">
                  <label for="export_date">Special Requirment</label>
                  <textarea class="form-control" name="special_req" rows="2" cols="200" style="width: 350px;height: 80px" id="especial_req" placeholder="Enter Your Special Requirement"></textarea>
                  @if ($errors->has('export_date'))
                      <span class="help-block"><strong>{{ $errors->first('export_date') }}</strong></span>
                  @endif
              </div>
              <input type="hidden" value="" id="edit_id" name="edit_id"> 
            </div>
            <div class="col-sm-6">
              <div class="form-group {{ $errors->has('ingredient') ? 'has-error' : '' }}">
                  <label for="ingredient">Ingredients</label>
                  <textarea class="form-control" rows="2" cols="200" style="width: 350px;height: 80px" name="ingredient" id="ingredient" placeholder="Enter Item Ingredients Here"></textarea>
                  @if ($errors->has('ingredient'))
                      <span class="help-block"><strong>{{ $errors->first('ingredient') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group {{ $errors->has('ingredient') ? 'has-error' : '' }}">
                  <label for="ingredient">Is Assign?</label>
                  <input type="checkbox" value="1" id="is_assign" name="is_assign">
              </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary update_btn_id">Update</button>
      </div>
    </div>
    </form>
  </div>
</div><!--@@@@@@@ End Modal @@@@@@@-->
<script>document.title = 'Export | Party Items';</script>
<script type="text/javascript">
    
    setTimeout(function() { 
        $('.sr-only').click();
    }, 0.0001);
    
    let itemSearchTimeout;
  let currentFocus = -1;

  $('#ci_item_search').on('input', function() {
      const searchTerm = $(this).val().trim();
      
      // Clear previous timeout
      clearTimeout(itemSearchTimeout);
      
      if (searchTerm.length < 2) {
          $('#item_results').hide().empty();
          return;
      }
      
      // Set new timeout for debouncing
      itemSearchTimeout = setTimeout(() => {
          searchItems(searchTerm);
      }, 300);
  });

  // Function to search items via AJAX
  function searchItems(searchTerm) {
      $.ajax({
          url: "{{ url('/search/ci_items') }}", // Create this route
          type: "GET",
          data: {
              search: searchTerm,
              _token: "{{ csrf_token() }}"
          },
          success: function(response) {
              if (response.success && response.data.length > 0) {
                  displayResults(response.data);
              } else {
                  $('#item_results').html('<div class="autocomplete-item">No items found</div>').show();
              }
          },
          error: function() {
              $('#item_results').html('<div class="autocomplete-item">Error loading items</div>').show();
          }
      });
  }

  // Function to display search results
  function displayResults(items) {
      const resultsDiv = $('#item_results');
      resultsDiv.empty();
      
      items.forEach(item => {
          const itemDiv = $('<div>')
              .addClass('autocomplete-item')
              .attr('data-id', item.id)
              .attr('data-code', item.ci_item_code)
              .attr('data-name', item.ci_item_name)
              .html(`
                  <div>
                      <span class="item-code">${item.ci_item_code}</span> - 
                      <span class="item-name">${item.ci_item_name}</span>
                  </div>
              `);
          
          // Click event for selecting item
          itemDiv.on('click', function() {
              selectItem($(this));
          });
          
          resultsDiv.append(itemDiv);
      });
      
      resultsDiv.show();
      currentFocus = -1; // Reset focus
  }

  // Function to handle item selection
  function selectItem(itemElement) {

      const itemId = itemElement.data('id');
      const itemCode = itemElement.data('code');
      const itemName = itemElement.data('name');  
      // Set values in form
      $('#ci_item_search').val(`${itemCode} - ${itemName}`);
      $('#ci_item_id').val(itemId);
      
      // Set desk item name
      $('#desk_item_name').val(itemName);
      
      // Hide results
      $('#item_results').hide().empty();
      
      // Get additional data (gross weight, CBM)
      getItemDetails(itemId);
  }

  // Keyboard navigation for autocomplete
  $('#ci_item_search').on('keydown', function(e) {
      const results = $('.autocomplete-item');
      
      if (results.length > 0) {
          // Down arrow
          if (e.keyCode === 40) {
              currentFocus++;
              addActive(results);
          }
          // Up arrow
          else if (e.keyCode === 38) {
              currentFocus--;
              addActive(results);
          }
          // Enter key
          else if (e.keyCode === 13) {
              e.preventDefault();
              if (currentFocus > -1) {
                  if (results[currentFocus]) {
                      selectItem($(results[currentFocus]));
                  }
              }
          }
      }
  });

  // Function to handle keyboard navigation
  function addActive(items) {
      if (!items) return false;
      
      // Remove active class from all items
      removeActive(items);
      
      if (currentFocus >= items.length) currentFocus = 0;
      if (currentFocus < 0) currentFocus = items.length - 1;
      
      // Add active class to current item
      $(items[currentFocus]).addClass('selected');
      
      // Scroll into view if needed
      items[currentFocus].scrollIntoView({
          behavior: 'smooth',
          block: 'nearest'
      });
  }

  function removeActive(items) {
      items.each(function() {
          $(this).removeClass('selected');
      });
  }

  // Click outside to close results
  $(document).on('click', function(e) {
      if (!$(e.target).closest('#ci_item_search, #item_results').length) {
          $('#item_results').hide();
      }
  });

  // Get item details function (existing)
  function getItemDetails(itemId) {
      var party_code = document.getElementById('party_code').value;
      $.ajax({
          type: "GET",
          url: "{{url('/get/item/gross/weight')}}?ci_item_id=" + itemId + "&party_code=" + party_code,
          success: function (data) {
              $('#gross_weight').val(data.gross_weight);
              $('#cbm_per_ctn').val(data.cbm);
          }
      });
  }

  // Function to clear the add modal form (except party)
  function clearAddModalForm() {
      $('#ci_item_search').val('');
      $('#ci_item_id').val('');
      $('#desk_item_name').val('');
      $('#acc_rate').val('');
      $('#percentage').val('');
      $('#party_rate').val('');
      $('#cbm_per_ctn').val('');
      $('#gross_weight').val('');
      $('#shelf_life').val('');
      $('#hs_code2').val('');
      $('textarea[name="coding_matter"]').val('');
      $('textarea[name="special_requirment"]').val('');
      $('textarea[name="ingredient"]').val('');
      $('#dunit_id').val('').selectpicker('refresh');
      $('#runit_id').val('').selectpicker('refresh');
      $('#factory_id').val('').selectpicker('refresh');
      $('#item_results').hide().empty();
  }

  function clearAddModalForm() {
      $('#ci_item_search').val('');
      $('#ci_item_id').val('');
      $('#desk_item_name').val('');
      $('#acc_rate').val('');
      $('#percentage').val('');
      $('#party_rate').val('');
      $('#cbm_per_ctn').val('');
      $('#gross_weight').val('');
      $('#shelf_life').val('');
      $('#hs_code2').val('');
      $('textarea[name="coding_matter"]').val('');
      $('textarea[name="special_requirment"]').val('');
      $('textarea[name="ingredient"]').val('');
      $('#dunit_id').val('').selectpicker('refresh');
      $('#runit_id').val('').selectpicker('refresh');
      $('#factory_id').val('').selectpicker('refresh');
      $('#item_results').hide().empty();
  }


  function clearAddModalForm2() {
      $('#ci_item_search').val('');
      $('#ci_item_id').val('');
      $('#desk_item_name').val('');
      $('#acc_rate').val('');
      $('#percentage').val('');
      $('#party_rate').val('');
      $('#cbm_per_ctn').val('');
      $('#gross_weight').val('');
      $('#shelf_life').val('');
      $('#hs_code2').val('');
    //   $('#dunit_id').val('').selectpicker('refresh');
    //   $('#runit_id').val('').selectpicker('refresh');
    //   $('#factory_id').val('').selectpicker('refresh');
      $('#item_results').hide().empty();
  }


  $('#ci_item_list').multiselect({
      columns: 1,
      placeholder: 'Select Item',
      search: true,
      selectAll: true
  });  

  $(document).ready(function() {  
    
      loadNotifyParties();
      function loadNotifyParties() {
        $.ajax({
            type: "GET",
            url: "{{ url('/json/get/notify_parties') }}",
            success: function(response) {
                var options = '<option value="">Select</option>';
                
                $.each(response.data, function(index, party) {
                    if(party.ref_name) {
                        options += '<option value="' + party.code + '">' + 
                                   party.code + '-' + party.name + 
                                   ' (' + party.ref_name + ')' + 
                                   '</option>';
                    } else {
                        options += '<option value="' + party.code + '">' + 
                                   party.code + '-' + party.name + 
                                   '</option>';
                    }
                });
                
                $('#party_id').html(options);
                $('#party_id').selectpicker('refresh');
                
                // Also populate the copy modal dropdowns if needed
                $('#from_party_code').html(options);
                $('#to_party_code').html(options);
                $('#party_code').html(options);
                $('#from_party_code, #to_party_code, #party_code').selectpicker('refresh');
            },
            error: function(xhr) {
                console.log('Error loading parties:', xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load notify parties. Please refresh the page.'
                });
            }
        });

      }
     
      //Item Add Form Submit
      $("#ci_item_id").change(function(){

          var text = $("#ci_item_id option:selected").text();
          var parts = text.split('-');
          var res = parts.slice(1).join('-').trim();
          $("#desk_item_name").val(res);
          var ci_item_id = document.getElementById('ci_item_id').value;
          var party_code = document.getElementById('party_code').value;
          $.ajax({
              type: "GET",
              url: "{{url('/get/item/gross/weight')}}?ci_item_id=" + ci_item_id+"&party_code="+party_code,
              success: function (data) {
                  
                $('#gross_weight').val(data.gross_weight);
                $('#cbm_per_ctn').val(data.cbm);

              }

          });

      }); //@@--end




      //--Account Rate Cannot less check function---
      $('#eacc_rate').on('keyup', function() {

        const standard_value = parseFloat($('#acc_rate_id').html());
        let account_rate = parseFloat($('#eacc_rate').val());
        $('.update_btn_id').prop('disabled', true);
        if(isNaN(account_rate)){ account_rate=0; }
        
        if(account_rate<standard_value){
            
          Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "Accounts rate can not < then "+standard_value
          });

          $('.update_btn_id').prop('disabled', true);

        }else{

          $('.update_btn_id').prop('disabled', false);

        }

      });
      //--Notify party item---
      $("#from_party_code").change(function(){

          var from_party_code = $("#from_party_code").val();
          $.ajax({
              type: "GET",
              url: "{{url('/json/get/notify/party/items_list')}}",
              data:{'party_code': from_party_code,"_token": $('input[name=_token]').val()},
              success: function (res) {
                  
                  var option='';
                  $.each(res.data, function (key, value) {
                    
                    option+='<option value="'+value.item_id+'">'+value.ci_item_code+'-'+value.ci_item_name+'</option>';

                  });
                
                  $('#ci_item_list').html(option);
                  $('#ci_item_list').multiselect({
                    columns: 1,
                    search: true,
                    selectAll: true
                  });
                  $('#ci_item_list').multiselect('reload');
                
              }

          });

        }); //@@--end

      
       //Item Add Form Submit
       $("#addSubmitFormId").submit(function (e) {
           
            e.preventDefault(); 
            $.ajax({
                type:'POST',
                url: "{{ url('/notify_party_item')}}",
                data: new FormData(this),
                cache:false,
                contentType: false,
                processData: false,
                success: (res) => {
    
                    if(res.code==200){
                        
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Create Successfully Done..!!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        // Keep party selected, clear other fields
                        var currentParty = $('#party_code').val();
                        clearAddModalForm2();
                        $('#party_code').val(currentParty).selectpicker('refresh');
                        $("#ItemAddedModal").modal("show");
                        

                    }else if(res.code==409){
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Already exists this item..!!'
                        });

                    }
                            
                },
                error: function(data){

                    console.log(data);
                    
                }
            
            });    

       }); //@@@end model

       //Item Add Form Submit
        $("#copySubmitFormId").submit(function (e) {
           
           e.preventDefault(); 
           var from_party_code=$('#from_party_code').val();
           var to_party_code=$('#to_party_code').val();
           var selectedItemsCount = $('#ci_item_list option:selected').length;
           console.log(selectedItemsCount);
           if (selectedItemsCount===0) {
             
              Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Select al least one..!!',
              });

           }else if(from_party_code==to_party_code){

              Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Copy same party not allow..!!',
              });
              
           }else{
              
                $.ajax({
                  type:'POST',
                  url: "{{ url('/copy/notify_party/items')}}",
                  data: new FormData(this),
                  cache:false,
                  contentType: false,
                  processData: false,
                  success: (res) => {
        
                      if(res.code==200){
                          
                          Swal.fire({
                              position: 'top-end',
                              icon: 'success',
                              title: 'Copy Successfully Done..!!',
                              showConfirmButton: false,
                              timer: 1500
                          });

                          $('#copySubmitFormId').trigger('reset');
                          $('#from_party_code').val('').selectpicker('refresh');
                          $('#to_party_code').val('').selectpicker('refresh');
                          $('#ci_item_list').multiselect('reload');
                          $("#copyModal").modal("hide");

                          

                      }
                              
                  },
                  error: function(data){

                      console.log(data);
                      
                  }
            
                });   

          } 
              
       }); //@@@end model




        //Item Add Form Submit
        $("#upateSubmitFormId").submit(function (e) {
           
           e.preventDefault(); 
           $.ajax({
            type:'POST',
            url: "{{ url('/update/notify_party/items')}}",
            data: new FormData(this),
            cache:false,
            contentType: false,
            processData: false,
            success: (res) => {
  
                if(res.code==200){
                    
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Updated Successfully Done..!!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $("#editModal").modal("hide");  
                }

                var table2 = $('#example1').DataTable();
                table2.ajax.reload(null, false);
                table2.draw(false); 
                
                        
            },
            error: function(data){

                console.log(data);
                
            }
      
          });    
              
       }); //@@@end model

       //@@open add item modal
      $('#add_item_btn_id').click(function(e){   
         
        e.preventDefault();
        
        // Get the currently selected party from main page
        var selectedParty = $('#party_id').val();
        
        if(selectedParty && selectedParty !== '') {
            // Set the party in modal dropdown
            $('#party_code').val(selectedParty).selectpicker('refresh');
        } else {
            // If no party selected, show warning
            Swal.fire({
                icon: 'warning',
                title: 'Please Select Party',
                text: 'You must select a party from the main page first!'
            });
            return;
        }
        
        // Clear other form fields
        clearAddModalForm();
        
        $("#ItemAddedModal").modal("show");

      });

      $('#ItemAddedModal').on('hidden.bs.modal', function () {
          // Keep party selected, clear other fields
          var currentParty = $('#party_code').val();
          clearAddModalForm();
          if(currentParty && currentParty !== '') {
              $('#party_code').val(currentParty).selectpicker('refresh');
          }
      });

      //@@open copy modal
      $('#copy_item_btn_id').click(function(e){   
         
         e.preventDefault();
         $("#copyModal").modal("show");
 
      });

      //@@open Excel Upload modal
      $('#upload_excel_btn_id').click(function(e){   
         
         e.preventDefault();
         $("#excel_model").modal("show");
 
      });

      // Submit Excel File Upload
      $("#uploadExcelFormId").on("submit", function(e) {
        
        e.preventDefault();
        var fileInput = document.getElementById('excelFile');
        if (!fileInput || fileInput.files.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No File Selected!',
                text: 'Please select Excel file before uploading.'
            });
            return; // stop submit
        }
        let formData = new FormData(this);
        $.ajax({
            url: "/upload/party_items",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $(".btn-primary").html('<i class="fa fa-spinner fa-spin"></i> Uploading...');
                $(".btn-primary").prop("disabled", true);
            },
            success: function(response) {
                // Only success messages will come here (status 200)
                if (response.status === "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message
                    });
                    $("#uploadExcelFormId")[0].reset();
                    $("#fileName").html('');
                    $("#exampleModal").modal("hide");
                }
            },
            error: function(xhr) {
                // Validation / 422 errors will come here
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorList = "<ul style='text-align:left;'>";
                    errors.forEach(function(err) {
                        errorList += "<li>" + err + "</li>";
                    });
                    errorList += "</ul>";

                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Failed!',
                        html: errorList
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error!',
                        text: xhr.responseJSON?.message || 'Something went wrong!'
                    });
                }
            },
            complete: function() {
                $(".btn-primary").html('Upload');
                $(".btn-primary").prop("disabled", false);
            }
        });
      });

      
      //@@@@@@Handle onchange event@@@@@@@@@@
      $("#party_id").change(function(){
          
          var party_code=$(this).val();
          showPartyItems(party_code);
          
      });

      //@@@@@@Show party items@@@@@@@@@@
        function showPartyItems(party_code) {
            
            $(".preload").show();
            
            // Destroy existing DataTable if it exists
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }
            
            $('#example1 tbody').empty(); // Clear table body
            
            // Status to CSS class mapping
            const statusClasses = {
                0: 'row-status-inactive',
                1: 'row-status-active',
                2: 'row-status-pending'
            };
            
            var table = $('#example1').DataTable({
                dom: 'Bfrtip',

                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export Excel',
                        title: 'Notify_Party_Items'
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'Export CSV',
                        title: 'Notify_Party_Items'
                    }
                ],

                ajax: {
                    url: "/json/get/notify/party/items_list",
                    type: "GET",
                    data: {
                        party_code: party_code,
                        _token: $('input[name=_token]').val()
                    },
                    dataSrc: function(json) {
                        return json.data && json.data.length > 0 ? json.data : [];
                    }
                },

                columns: [
                    {
                        data: null,
                        render: (data, type, full, meta) => meta.row + 1
                    },
                    { data: "ci_item_code" },
                    { data: "ci_item_name" },
                    { data: "desk_item_name" },
                    { data: "acc_rate" },
                    { data: "party_rate" },
                    { data: "fob_value" },
                    { data: "cbm_per_ctn" },
                    { data: "gross_weight" },
                    { data: "shelf_life" },
                    { data: "is_assign" },
                    { data: "short_name" },
                    { data: "hs_code2" },
                    { data: "status" },
                    {
                        data: null,
                        render: (data, type, row) =>
                            `<input type="button" data-id="${row.id}" class="btn btn-success btn-sm btn-edit" value="Edit">`
                    }
                ],

                language: {
                    emptyTable: "No records available"
                },

                rowCallback: function(row, data) {
                    if(data.is_assign == 'No') {
                        $(row).addClass('row-status-inactive');
                        $('td', row).css('background-color', '#ffcccc');
                    }
                },

                drawCallback: function() {
                    $(".preload").hide();
                }
            });
        }
      // Handle click edit button
      $('#example1 tbody').on('click', '.btn-edit', function (e) {
          var edit_id=$(this).data('id');
          document.getElementById("spinner-container").style.display = "block";
          $.ajax({
              type: "GET",
              url: "{{url('/json/get/party_item/edit/details')}}?edit_id=" + $(this).data('id'),
              success: function (response) {
                  
                  var updateDunitId=response.notifyPartyItem.dunit;
                  var updateRunitId=response.notifyPartyItem.runit;
                  var updateFactoryId=response.notifyPartyItem.factory_id;
                  var updatePartyId=response.notifyPartyItem.notify_party_id;
                  var updateItemId=response.notifyPartyItem.ci_item_id;

                  $('#editModal #edesk_item_name').val(response.notifyPartyItem.desk_item_name);
                  $('#editModal #eacc_rate').val(response.notifyPartyItem.acc_rate);
                  $('#acc_rate_id').html(response.notifyPartyItem.acc_rate);
                  $('#editModal #epercentage').val(response.notifyPartyItem.percentage);
                  $('#editModal #eparty_rate').val(response.notifyPartyItem.party_rate);
                  $('#editModal #ecbm_per_ctn').val(response.notifyPartyItem.cbm_per_ctn);
                  $('#editModal #egross_weight').val(response.notifyPartyItem.gross_weight);
                  $('#editModal #eshelf_life').val(response.notifyPartyItem.shelf_life);
                  $('#editModal #ecoding_matter').val(response.notifyPartyItem.coding_matter);
                  $('#editModal #especial_req').val(response.notifyPartyItem.special_requirement);
                  $('#edunit_id').empty();
                  $("#editModal #edit_id").val(edit_id);
                  $("#editModal #ingredient").val(response.notifyPartyItem.ingredient);
                  $("#editModal #ehs_code2").val(response.notifyPartyItem.hs_code2);
                  
                  $.each(response.dunits, function(index, dunit) {
                      var selected = (dunit.id == updateDunitId) ? 'selected' : '';
                      $('#edunit_id').append('<option value="' + dunit.id + '" ' + selected + '>' + dunit.dunit_name + '</option>');
                  });
                  
                  $.each(response.runits, function(index, runit) {
                      var selected = (runit.id == updateRunitId) ? 'selected' : '';
                      $('#erunit_id').append('<option value="' + runit.id + '" ' + selected + '>' + runit.runit_name + '</option>');
                  });

                  $.each(response.productionFloors, function(index, floor) {
                      var selected = (floor.id == updateFactoryId) ? 'selected' : '';
                      $('#efactory_id').append('<option value="' + floor.id + '" ' + selected + '>' + floor.short_name + '</option>');
                  });

                  $.each(response.notifyParty, function(index, party) {
                      var selected = (party.id == updatePartyId) ? 'selected' : '';
                      $('#enotify_party_id').append('<option value="' + party.code + '" ' + selected + '>'+  party.code+'-'+party.name  + '</option>');
                  });

                  $.each(response.partyItems, function(index, item) {
                      var selected = (item.id == updateItemId) ? 'selected' : '';
                      $('#eci_item_id').append('<option value="' + item.id + '" ' + selected + '>'+  item.ci_item_code+'-'+item.ci_item_name  + '</option>');
                  });

                  // Make Notify Party and Item dropdowns unselectable
                  $('#enotify_party_id').selectpicker('refresh');
                  $('#eci_item_id').selectpicker('refresh');
                  
                  // Disable the dropdowns to prevent user selection
                  $('#enotify_party_id').prop('disabled', true);
                  $('#eci_item_id').prop('disabled', true);
                  
                  // Create hidden fields to preserve values for form submission
                  if(!$('#hidden_notify_party').length) {
                      $('#upateSubmitFormId').append('<input type="hidden" id="hidden_notify_party" name="notify_party_id">');
                  }
                  if(!$('#hidden_ci_item').length) {
                      $('#upateSubmitFormId').append('<input type="hidden" id="hidden_ci_item" name="ci_item_id">');
                  }
                  
                  // Set hidden field values
                  $('#hidden_notify_party').val(updatePartyId);
                  $('#hidden_ci_item').val(updateItemId);
                  
                  // Refresh selectpickers after disabling
                  $('#erunit_id, #edunit_id, #efactory_id, #enotify_party_id, #eci_item_id').selectpicker('refresh');
                  $("#editModal").modal("show");
                  document.getElementById("spinner-container").style.display = "none";
              }
          });
      }); //--End

      // Handle click delete button
      $('#example1 tbody').on('click', '.btn-delete', function (e) {

          var delete_id=$(this).data('id');
          Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Delete it!'
          }).then((result) => {

              if(result.isConfirmed) {
                
                $.ajax({
                    url: "{{url('/delete/notify_party_item')}}",
                    type: "get",
                    dataType: "json",
                    data: {'delete_id':$(this).data('id'),'_token': $('input[name=_token]').val()},
                    success: function(res) {

                       console.log(res);

                        if(res.code==200){
                      
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Delete Successfully Done..!!',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            var table1 = $('#example1').DataTable();
                            table1.ajax.reload();

                        }else if(res.code==500){
                      
                          Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                          });
                                                
                        }  
                  
                    }
              
                });

                  
              }

          });

      }); //--End
  });
</script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const excelFileInput = document.getElementById('excelFile');
            const fileNameDiv = document.getElementById('fileName');            
            excelFileInput.addEventListener('change', function() {
                if (this.files.length > 0) {

                    fileNameDiv.textContent = this.files[0].name;  
                    // Simple file validation
                    const fileSize = this.files[0].size / 1024 / 1024; // in MB
                    if (fileSize > 10) {
                        alert('File size exceeds 10MB. Please choose a smaller file.');
                        this.value = '';
                        fileNameDiv.textContent = '';
                    }

                } else {
                    fileNameDiv.textContent = '';
                }
            });
    
            // Drag and drop functionality
            const fileLabel = document.querySelector('.file-label');
            fileLabel.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.closest('.file-upload-container').style.borderColor = '#6a11cb';
                this.closest('.file-upload-container').style.backgroundColor = '#eef4ff';
            });
            
            fileLabel.addEventListener('dragleave', function() {
                this.closest('.file-upload-container').style.borderColor = '#ced4da';
                this.closest('.file-upload-container').style.backgroundColor = '#f8f9fa';
            });
            
            fileLabel.addEventListener('drop', function(e) {
                e.preventDefault();
                this.closest('.file-upload-container').style.borderColor = '#ced4da';
                this.closest('.file-upload-container').style.backgroundColor = '#f8f9fa';
                
                if (e.dataTransfer.files.length) {
                    excelFileInput.files = e.dataTransfer.files;
                    const event = new Event('change');
                    excelFileInput.dispatchEvent(event);
                }
            });
        });
    </script>
@endsection