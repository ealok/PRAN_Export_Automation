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
   table.dataTable thead th{
      padding: 3px 0px;
   }
   #example1{
    font-size: 11px;
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
      height: 30px;
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
    margin-top: 26px;
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

    margin-top: 50px;
  }
  .region{
    width: 185px;
    text-align: center;
  }
  .eitem{
    margin-top: 49px;
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

.table > tbody > tr > td{
 
  padding: 1px;
  line-height: 1.42857143;
  vertical-align: top;
  font-size: 9px;

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

  .item{ width: 500px; text-align: center;}
  .country{}
  .region{}
  .loc{}
  .ctn_per_con{}
  .factor{}
  .cvr{}
  .fob_per_pc_bd{width: 76px}
  .fob_per_pc_usd{width: 76px}
  .for_per_ctn_bd{width: 76px}
  .fob_per_ctn_usd{width: 76px}
  .prime_cost{}
  .oh_cost{}
  .total_cost{}
  .gp{}
  .updated_date{width: 76px;}
  
  #tblMain{
  
    height: 358px;      
    overflow-y: auto;    
    overflow-x: hidden;  
  }

  .preload {
    margin:0;
    position:absolute;
    top:50%;
    left:50%;
    margin-right: -50%;
    transform:translate(-50%, -50%);
  }

  img{ height: 386px; }


</style>
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/costing_report')}}"><i class="fa fa-dashboard"></i>Costing Report</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <div class="col-sm-3">
                <label for="name" id="party">Region :</label>
                <select name="region" id="region" data-live-search="true" class="form-control select2 selectpicker party_style_id"  type="select"  value="1">
                <option value="">Select</option>
                   <option>All</option>
                   @foreach($regions as $value)
                   <option value="{{$value->region}}">{{$value->region}}</option>
                   @endforeach
                </select>
          </div>
          <div class="col-sm-3">
                <label for="name" id="party">Country :</label>
                <select name="country" id="country" data-live-search="true" class="form-control select2 selectpicker party_style_id"  type="select"  value="1">
                   <option value="">Select</option>
                </select>
          </div>
          <div class="col-sm-3">
                <label for="name" id="party">Party :</label>
                <select name="party_code" id="party_code" data-live-search="true" class="form-control select2 selectpicker input-md party_style_id"  type="select"  value="1">
                <option value="">Select</option>
               
                </select>
          </div>
          <div class="col-sm-3">
              <button class="btn btn-primary btn-sm" style="margin-top: 2px;" id="btn-submit-id">Submit</button>
          </div>
        </div>
        <div class="panel-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive table-condenced">
              <thead>
                  <tr>
                      <th class="party" tabindex="0" aria-label="Item Name">Party</th>
                      <th class="item_code">Item_Code</th>
                      <th class="item" tabindex="0" aria-label="Item Name">Item_Name</th>
                      <th class="country">Country</th>
                      <th class="region">Region</th>
                      <th class="loc">Loc</th>
                      <th class="ctn_per_con">Ctn/Con</th>
                      <th class="factor">Factor</th>
                      <th class="freight">Freight</th>
                      <th class="ins">Ins</th>
                      <th class="cvr">CVR</th>
                      <th class="fob_per_pc_bd">FOB/PC(BD)</th>
                      <th class="fob_per_pc_usd">FOB/PC(USD)</th>
                      <th class="for_per_ctn_bd">FOB/CTN(BD)</th>
                      <th class="fob_per_ctn_usd">FOB/CTN(USD)</th>
                      <th class="prime_cost">Prime_Cost</th>
                      <th class="oh_cost">OH_Cost</th>
                      <th class="total_cost">Total_Cost</th>
                      <th class="gp">GP</th>
                      <th class="updated_date">Updated_Date</th>
                  </tr> 
              </thead>
              <div class="preload">
                <img src="{{asset('/img/loading_spinner.gif')}}"/>
              </div>
              <tbody>
                  
              </tbody>
          </table>
        </div>
    </div>
  </div>
</div>
<script>document.title = 'Costing | Report';</script>
<script type="text/javascript">
    
    $(".preload").hide();
    setTimeout(function() { $('.sr-only').click(); }, 0.0001);
    $(document).ready(function() {
       
        //@@@Datatable Filter Function
        $('#btn-submit-id').click(function(e){
            
            var region=$('#region').val();
            var country=$('#country').val();
            var party_code=$('#party_code').val();

            if((party_code || country || region)==""){
                
                Swal.fire({
                    icon: 'warning',
                    title: 'Alert',
                    text: 'Please select at least one..!!',
                    footer: '<a href="">Why do I have this issue?</a>'
                });
    
            }else{
                
                getCostingReportData(party_code,country,region);  

        
            }  
    
    
        });
    
        function getCostingReportData(party_code,country,region){
            
            $('#example1').dataTable().fnDestroy(); 
            $(".preload").show();
            var table=$('#example1').DataTable({
            "ajax": {
                "url": "/json/get_costing/reprot_data",
                "type": "GET",
                "data": {
                  "party_code": party_code,
                  "country": country,
                  "region": region,
                  "_token": $('input[name=_token]').val()
                },
                "dataSrc": function (json) {
    
                    console.log(json);
    
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
              { "data": "ctn_per_con" },
              { "data": "pcs_per_ctn" },
              { "data": "freight" },
              { "data": "insurance" },
              { "data": "conversion_rate" },
              { "data": "fob_per_piece_bd"},
              { "data": "fob_per_piece_usd"},
              { "data": "fob_per_ctn_bd"},
              { "data": "fob_per_ctn_usd"},
              { "data": "prime_cost_bdt"},
              { "data": "factory_oh_bdt"},
              { "data": "total_cost_bdt"},
              { "data": "gp_percentage"},
              { "data": "last_updated_date"}
            ],
            "language": {
    
                "emptyTable": "No records available"
            },
            "dataSrc": function (json) {
    
                if (!json.data || json.data.length === 0) {
    
                    return false;
                }
                return json.data;
            },
            "initComplete": function(settings, json) {
                  
                $('#example1 thead th:eq(1)').css('width', '62px');
                $('#example1 thead th:eq(2)').css('width', '600px');
                $('#example1 thead th:eq(4)').css('width', '100px');
                $('#example1 thead th:eq(9)').css('width', '65px');
                $('#example1 thead th:eq(10)').css('width', '65px');
                $('#example1 thead th:eq(11)').css('width', '65px');
                $('#example1 thead th:eq(12)').css('width', '65px');
                $('#example1 thead th:eq(13)').css('width', '65px');
                $('#example1 thead th:eq(14)').css('width', '52px');
                $('#example1 thead th:eq(15)').css('width', '60px');
                $('#example1 thead th:eq(16)').css('width', '77px');
            },
            "dom": 'Bfrtip',
            "buttons": [
                'excel'
            ],
            "pageLength": 15
            });

            $(".preload").hide();

        }

        $('#region').change(function(e){ 

            var region=$(this).val();
            var url = "{{url('/')}}"+"/json/get/region_wise/country_list?region="+region;
            var $el = $('#country');
            $.get(url,function(res) {

                if(res.data.length=="0"){

                    $el.html('');
                    $el.append($("<option></option>").attr("value", "").text("-NO Record--"));
                    $el.selectpicker('refresh');

                }else{

                    $el.html('');
                    $el.append($("<option></option>").attr("value", "").text("Select"));
                    $el.append($("<option></option>").attr("value", "All").text("All"));
                    $.each(res.data, function(key,value) {

                        $el.append($("<option></option>").attr("value", value.country).text(value.country));

                    });
                    $el.selectpicker('refresh');

                }

            }); 

        });

        $('#country').change(function(e){ 

            var country=$(this).val();
            var url = "{{url('/')}}"+"/json/get/region_wise/party_list?country="+country;
            var $el = $('#party_code');
            $.get(url,function(res) {

                if(res.data.length=="0"){

                    $el.html('');
                    $el.append($("<option></option>").attr("value", "").text("---"));
                    // $el.selectpicker('destroy');

                }else{

                    $el.html('');
                    $el.append($("<option></option>").attr("value", "").text("Select"));
                    $el.append($("<option></option>").attr("value", "All").text("All"));
                    $.each(res.data, function(key,value) {

                        $el.append($("<option></option>").attr("value", value.code).text(value.code+' / '+value.name));

                    });
                    $el.selectpicker('refresh');

                }

            });   
        //     notify_parties.region = 'All' OR
        // (notify_parties.region LIKE '%' OR 
        });

    })
</script>
@endsection