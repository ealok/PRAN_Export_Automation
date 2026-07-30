@extends('layouts.master')
@section('content')
<style type="text/css">
   #exTab1 .tab-content {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}

#exTab2 h3 {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}

/* remove border radius for the tab */

#exTab1 .nav-pills > li > a {
  border-radius: 0;
}

/* change border radius for the tab , apply corners on top*/

#exTab3 .nav-pills > li > a {
  border-radius: 4px 4px 0 0 ;
}

#exTab3 .tab-content {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}
</style>
<section class="content-header" style="padding-top: 0px;">
    <h4 style="margin-bottom: -16px">SCI COMMERCIAL INV UPDATE</h4>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/sale_contract/create')}}"><i class="fa fa-dashboard"></i>SCI COM INV</a></li>
    </ol>
    <br>
</section>
<div class="row">
        @if(Session::has('success'))
       <div class="alert alert-success">
               <strong>Success!</strong>{{ Session::get('success') }}
       </div> 
       @endif 
       @if(Session::has('danger'))
       <div class="alert alert-danger">
               <strong>Failed !</strong>{{ Session::get('danger') }}
       </div> 
       @endif
        <div class="col-md-12">
           <!-- Horizontal Form -->
            <div class="box box-info"> <!-- /.box-header start-->
            <form method="post" id="insert_form" action="">
            {{ csrf_field() }}
                 <!-- /.box-body-start --> 
              <div class="box-body" style="margin-bottom: -46px">
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('export_no') ? 'has-error' : '' }}" style="margin-bottom: 0px;">
                        <label for="">Our_Ref_No</label>
                        <input name="" type="text" id="ref_name" value="@if(!empty($comInvMaster->ref_name)){{$comInvMaster->ref_name}}@endif" class="form-control">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Date</label>
                        <input name="" type="text" id="date" class="form-control" placeholder="Dated"  autocomplete="off" value="@if(!empty($comInvMaster->date)){{$comInvMaster->date}}@endif">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;"> 
                        <label for="">Time Out</label>
                        <input name="" type="text" id="time_out" class="form-control" value="@if(!empty($comInvMaster->time_out)){{$comInvMaster->time_out}}@endif">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Bank</label>    
                        <input name="bank" type="text" id="bank" class="form-control" value="@if(!empty($comInvMaster->bank)){{$comInvMaster->bank}}@endif">
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Bank Addess</label>
                        <input name="" type="text" id="bank_address" class="form-control" value="@if(!empty($comInvMaster->bank_address)){{$comInvMaster->bank_address}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="freight_cost_1">S/C No</label>
                        <input name="" type="text" id="sc_no" class="form-control" value="@if(!empty($comInvMaster->sc_no)){{$comInvMaster->sc_no}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">S/C Date</label>
                        <input name="" type="text" id="sc_date" class="form-control" value="@if(!empty($comInvMaster->sc_date)){{$comInvMaster->sc_no}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">S/C Value</label>
                        <input name="" type="text" id="sc_value" class="form-control" value="@if(!empty($comInvMaster->sc_value)){{$comInvMaster->sc_value}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Inv No</label>
                        <input name="" type="text" id="inv_no" class="form-control" value="@if(!empty($comInvMaster->invoice_no)){{$comInvMaster->invoice_no}}@endif"> 
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Inv Date</label>
                        <input name="" type="text" id="inv_date" class="form-control" value="@if(!empty($comInvMaster->sc_no)){{$comInvMaster->sc_no}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('freight_cost_3') ? 'has-error' : '' }}" style="margin-bottom: 0px;">
                        <label for="">Inv Value</label>
                        <input name="" type="text" id="inv_value" class="form-control" value="@if(!empty($comInvMaster->invoice_value)){{$comInvMaster->invoice_value}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Name Of Importer</label>
                        <input name="" type="text" id="name_of_importer" class="form-control" value="@if(!empty($comInvMaster->name_of_importer)){{$comInvMaster->name_of_importer}}@endif">
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Importer Address</label>
                        <input name="" type="text" id="importer_address" class="form-control" value="@if(!empty($comInvMaster->importer_address)){{$comInvMaster->importer_address}}@endif">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Quantity</label>
                        <input name="" type="text" id="quantity" class="form-control" value="@if(!empty($comInvMaster->quantity)){{$comInvMaster->quantity}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Carton</label>
                        <input name="" type="text" id="carton" class="form-control" value="@if(!empty($comInvMaster->carton)){{$comInvMaster->carton}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exported Value</label>
                        <input name="" type="text" id="exported_value" class="form-control" value="@if(!empty($comInvMaster->exported_value)){{$comInvMaster->exported_value}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exp No</label>
                        <input name="" type="text" id="exp_no" class="form-control" value="@if(!empty($comInvMaster->exp_no)){{$comInvMaster->exp_no}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exp Date</label>
                        <input name="" type="text" id="exp_date" class="form-control" value="@if(!empty($comInvMaster->exp_date)){{$comInvMaster->exp_date}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exp Value</label>
                        <input name="" type="text" id="exp_value" class="form-control" value="@if(!empty($comInvMaster->exp_value)){{$comInvMaster->exp_value}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Realise Value</label>
                        <input name="" type="text" id="realise_value" class="form-control" value="@if(!empty($comInvMaster->realise_value)){{$comInvMaster->realise_value}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">OD Sight Rate</label>
                        <input name="" type="text" id="od_sight_rate" class="form-control" value="@if(!empty($comInvMaster->od_sight_rate)){{$comInvMaster->od_sight_rate}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Freight</label>
                        <input name="freight" type="text" id="freight" class="form-control" value="@if(!empty($freight_cost)){{$freight_cost}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Shipment Date</label>
                        <input name="" type="text" id="shipment_date" class="form-control" value="@if(!empty($comInvMaster->shipment_date)){{$comInvMaster->shipment_date}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Discharge Port</label>
                        <input name="" type="text" id="discharge_port" class="form-control" value="@if(!empty($comInvMaster->discharge_port)){{$comInvMaster->discharge_port}}@endif">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Insurance</label>
                        <input name="insurance" type="text" id="insurance" class="form-control" value="@if(!empty($comInvMaster->insurance)){{$comInvMaster->insurance}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Net FOB</label>
                        <input name="net_fob" type="text" id="net_fob" class="form-control" value="@if(!empty($comInvMaster->net_fob)){{$comInvMaster->net_fob}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Non Eligible Item</label>
                        <input name="" type="text" id="non_eligible_item" class="form-control" value="@if(!empty($comInvMaster->non_eligible_item)){{$comInvMaster->non_eligible_item}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Local Material</label>
                        <input name="" type="text" id="local_material" class="form-control" value="@if(!empty($comInvMaster->local_material)){{$comInvMaster->local_material}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Imported</label>
                        <input name="" type="text" id="imported" class="form-control" value="@if(!empty($comInvMaster->imported)){{$comInvMaster->imported}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Claim(USD)</label>
                        <input name="" type="text" id="claim_usd" class="form-control" value="@if(!empty($comInvMaster->claim_usd)){{$comInvMaster->claim_usd}}@endif">
                    </div>
                </div>
                
                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Description Of Goods</label>
                        <input name="" type="text" id="description_of_good" class="form-control" value="@if(!empty($comInvMaster->description_of_good)){{$comInvMaster->description_of_good}}@endif">
                    </div>
                </div>  

                </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
        <div class="panel-body table-responsive">
          <table class="table table-bordered table-responsive table-condenced" style="font-size: 12px;font-weight: bold;" id="tblMain">
              <thead style="background: #df7ede;">
                  <th>Group</th>
                  <th>BU_Name</th>
                  <th>Item</th>
                  <th>Code</th>
                  <th>Pack_Size</th>
                  <th>Carton</th>
                  <th>Net_Weight</th>
                  <th>Amount</th>
                  <th>Frieght</th>
                  <th>FOB</th>
                  <th>Claim_BDT</th>
                  <th>Short_Access</th>
                  <th>Realize</th>
              </thead>
              <tbody>
                  <?php $i=1; ?>
                  <?php $itemGroupName=''; $totalCtn=0; $totalNetWeight=0; $subTotalCtn=0; $subTotalAmount=0; $subNetWeight=0;$subFreight=0; $subFob=0;?>
                  @if(!empty($itemDetails))
                  @foreach($itemDetails as $itemDetail)
                      <?php

                        $results=DB::select("SELECT
                              ci_items.p_net_weight,ci_items.ci_item_name,ci_items.ci_item_code,item_groups.item_group_name,item_groups.id AS item_group_id,
                              sale_contracts.id AS sale_contract_id,sale_contract_details.ctn,sale_contract_details.net_weight_kg,sale_contract_details.total_amount, bus.name as bu_name,bus.code
                          FROM
                              sale_contracts
                          JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
                          JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                          JOIN item_groups ON item_groups.id = ci_items.item_group_id
                          JOIN bus ON bus.id=ci_items.bu_id
                          WHERE
                              sale_contracts.id = '$itemDetail->sale_contract_id' AND item_groups.id = '$itemDetail->item_group_id'");       
                      ?>
                      @foreach($results as $result)
                      <tr>
                           <td>@if($i==1){{$result->item_group_name}}@endif</td>
                           <td>{{$result->bu_name}}</td>
                           <td style="font-size: 12px">{{$result->ci_item_name}}</td>
                           <td>{{$result->ci_item_code}}</td>
                           <td>{{$result->p_net_weight}}</td>
                           <td>{{$result->ctn}}<?php $totalCtn=$totalCtn+$result->ctn?><?php $subTotalCtn=$subTotalCtn+$result->ctn?></td>
                           <td>{{$result->net_weight_kg}}<?php $totalNetWeight=$totalNetWeight+$result->net_weight_kg?><?php $subNetWeight=$subNetWeight+$result->net_weight_kg?></td>
                           <td>{{$result->total_amount}}<?php $subTotalAmount=$subTotalAmount+$result->total_amount?></td>
                           <td>{{number_format($result->total_amount/$result->net_weight_kg,3)}}</td>
                           <td></td>
                           <td><?php $i++;?></td>
                           <td></td>
                           <td></td>
                      </tr>
                      @endforeach
                      <tr style="background: #c6c6">
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td><?php echo $subTotalCtn; ?></td>
                         <td><?php echo $subNetWeight; ?></td>
                         <td><?php echo $subTotalAmount;?></td>
                         <td>{{number_format($subTotalAmount*$freight_cost/$totalAmount,3)}}</td>
                         <td><?php $fob=$subTotalAmount-($subTotalAmount*$freight_cost/$totalAmount)-(($realize_amont*$subTotalAmount)/$totalAmount)?>{{number_format($fob,3)}}</td>
                         <td>{{number_format($fob*0.2*$od_sight_rate)}}</td>
                         <td>{{number_format($subTotalAmount*$realize_amont/$totalAmount,3)}}</td>
                         <td>{{number_format($realize_amont)}}</td>
                     </tr>
                     <?php $subTotalCtn=0; $subTotalAmount=0; $subNetWeight=0; $i=1;?> 
                  @endforeach
                  @endif
                 <tr style="background: #e5ece6;">
                     <td>Freight:</td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>  
                  </tr>
                  <tr style="background: #e5ece6;">
                       <td>Insurance:</td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                  </tr>
                  <tr style="background: #c6c6c6;">
                       <td>Total:</td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td>@if(!empty($totalAmount)){{$totalAmount}}@endif</td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td> 
                  </tr>
              </tbody>
          </table>
        </div>
        <div class="container">
            <h4 style="margin-top: -25px;color: black" class="inline"></h4>
            <input type="submit" class="inline btn btn-success" id="slide_stop_button"  value="Upgrade Data" style="margin-left: 476px;margin-top: -15px">
        </div>
      </form>
      <div id="exTab2" class="container"> 
            <ul class="nav nav-tabs" style="width: 94%">
              <li class="active">
                  <a  href="#1" data-toggle="tab">Local</a>
              </li>
              <li>
                  <a href="#2" data-toggle="tab">Imported</a>
              </li>
            </ul>
            <div class="tab-content ">
              <div class="tab-pane active" id="1">
                  <table class="table table-bordered table-responsive table-condenced" style="margin-top: 20px;width: 93%">
                      <thead>
                           <tr>
                           <td style="background: #df7ede;">SL</td> 
                           <td style="background: #df7ede;">Supplier_Name_&_Address</td>
                           <td style="background: #df7ede;">Raw_Materials_Name</td>
                           <td style="background: #df7ede;">Quantity(kgs/Ltr)</td>
                        </tr>
                      </thead>
                      <tbody>
                            <?php $i=1; ?>
                            @if(!empty($rcpeDetails))
                            @foreach($rcpeDetails as $rcpeDetail)
                            @if($rcpeDetail->source_type=="Local")
                            <tr>
                              <td>{{$i++}}</td>
                              <td>{{$rcpeDetail->source_address}}</td>
                              <td>{{$rcpeDetail->ingredient}}</td>
                              <td>{{number_format($rcpeDetail->percentage,3)}}</td>
                            </tr>
                            @endif
                            @endforeach
                            @endif
                      </tbody>
                  </table>
              </div>
              <div class="tab-pane" id="2">
                  <table class="table table-bordered table-responsive table-condenced" style="margin-top: 20px;width: 93%">
                      <thead>
                          <tr>
                           <td style="background: #df7ede;">SL</td> 
                           <td style="background: #df7ede;">Supplier_Name_&_Address</td>
                           <td style="background: #df7ede;">Raw_Materials_Name</td>
                           <td style="background: #df7ede;">Quantity(kgs/Ltr)</td>
                        </tr>
                      </thead>
                      <tbody>
                          <?php $i=1; ?>
                          @if(!empty($rcpeDetails))
                          @foreach($rcpeDetails as $rcpeDetail)
                          @if($rcpeDetail->source_type=="Imported")
                          <tr>
                            <td>{{$i++}}</td>
                            <td>{{$rcpeDetail->source_address}}</td>
                            <td>{{$rcpeDetail->ingredient}}</td>
                            <td>{{number_format($rcpeDetail->percentage,3)}}</td>
                          </tr>
                          @endif
                          @endforeach
                          @endif
                      </tbody>
                  </table>
              </div>
            </div>
          </div>
  </div>
</div> 
<script>document.title = 'Sci Com | Inv | Update';</script>
<script type="text/javascript">
  $('#insert_form').on('submit', function(event){
       event.preventDefault();
       var ref_name = $('#ref_name').val();
       var date= $('#date').val();
       var time_out= $('#time_out').val();
       var bank= $('#bank').val();
       var bank_address= $('#bank_address').val();
       var sc_no= $('#sc_no').val();
       var sc_date= $('#sc_date').val();
       var sc_value= $('#sc_value').val();
       var inv_no= $('#inv_no').val();
       var inv_date= $('#inv_date').val();
       var inv_value= $('#inv_value').val();
       var name_of_importer= $('#name_of_importer').val();
       var importer_address= $('#importer_address').val();
       var quantity= $('#quantity').val();
       var carton= $('#carton').val();
       var exported_value= $('#exported_value').val();
       var exp_no= $('#exp_no').val();
       var exp_date= $('#exp_date').val();
       var exp_value= $('#exp_value').val();
       var realise_value= $('#realise_value').val();
       var od_sight_rate= $('#od_sight_rate').val();
       var freight= $('#freight').val();
       var shipment_date= $('#shipment_date').val();
       var discharge_port= $('#discharge_port').val();
       var insurance= $('#insurance').val();
       var net_fob= $('#net_fob').val();
       var non_eligible_item= $('#non_eligible_item').val();
       var local_material= $('#local_material').val();
       var imported= $('#imported').val();
       var claim_usd= $('#claim_usd').val();
       var description_of_good= $('#description_of_good').val();
       var rate_in_usd= $('#rate_in_usd').val();

      $.ajax({
         method: 'GET',
         url: "/json/edit_com_inv_details",
         data: {'ref_name': ref_name,'date': date,'time_out':time_out,'bank':bank,'bank_address':bank_address,'sc_no':sc_no,
         'sc_date':sc_date,'sc_value':sc_value,'inv_no':inv_no,'inv_date':inv_date,'inv_value':inv_value,'name_of_importer':name_of_importer,'importer_address':importer_address,'quantity':quantity,'carton':carton,'exported_value':exported_value,
         'exp_no':exp_no,'exp_date':exp_date,'exp_value':exp_value,'realise_value':realise_value,'od_sight_rate':od_sight_rate,'freight':freight,'shipment_date':shipment_date,'discharge_port':discharge_port,'insurance':insurance,'net_fob':net_fob,'non_eligible_item':non_eligible_item,'local_material':local_material,'imported':imported,'claim_usd':claim_usd,'description_of_good':description_of_good,'rate_in_usd':rate_in_usd,'_token': $('input[name=_token]').val()},
         success: function (value) {
           
              if(value=="Success"){

                  alert("Information Updated Successfull..!!");
                  $('#slide_stop_button').attr('disabled','disabled');

              }else{

                  alert("Information Updated Failed..!!");

              }
                                                         
         },
         error: function (e) {

             console.log(e);
         }
               
      });    

 });
</script>
@endsection