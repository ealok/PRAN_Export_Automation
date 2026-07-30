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

.table-bordered > tbody > tr > td{

  border:1px solid #312020;
}

.inline {
   display:inline-block;
   margin-right:301px;
}
</style>
<section class="content-header" style="padding-top: 0px;">
    <h4 style="margin-bottom: -16px">SCI COMMERCIAL INV</h4>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/sale_contract/create')}}"><i class="fa fa-dashboard"></i>SCI COM INV</a></li>
    </ol>
    <br>
</section>
<div class="row">
       @if(Session::has('success')) 
    <div class="alert alert-success alert-dismissable">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
       <strong>Success!</strong>{{ Session::get('success') }}
    </div>
  @endif 
  @if(Session::has('danger')) 
    <div class="alert alert-danger alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <strong>Failed!</strong>{{ Session::get('danger') }}
    </div>
  @endif
       <form method="post" id="insert_form" action="">
        <div class="col-md-12">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start--> 
              <div class="box-body">
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('export_no') ? 'has-error' : '' }}" style="margin-bottom: 0px;">
                        <label for="">Our_Ref_No</label>
                        <input name="ref_name" type="text" id="ref_name" value="" class="form-control">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Date</label>
                        <input name="date"  id="date" type="text" id=""class="form-control datepicker" placeholder="Dated"  autocomplete="off" value="">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;"> 
                        <label for="">Time Out</label>
                        <input name="time_out" id="time_out" type="text" id="" class="form-control" value="@if(!empty($last_date_for_lodging_claim)){{$last_date_for_lodging_claim}}@endif" readonly="">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Bank</label>    
                        <input name="bank" type="text" id="bank" class="form-control" value="@if(!empty($bank_name)){{$bank_name}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Bank Addess</label>
                        <input name="bank_address" id="bank_address" type="text" id="" class="form-control" value="@if(!empty($bank_address)){{$bank_address}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="freight_cost_1">S/C No</label>
                        <input name="sc_no" type="text" id="sc_no" class="form-control" value="@if(!empty($sales_contract_no)){{$sales_contract_no}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">S/C Date</label>
                        <input name="sc_date" type="text" id="sc_date" class="form-control" value="@if(!empty($sale_contact_date)){{$sale_contact_date}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">S/C Value</label>
                        <input name="sc_value" type="text" id="sc_value" class="form-control" value="@if(!empty($totalAmount)){{$totalAmount}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Inv No</label>
                        <input name="inv_no" type="text" id="inv_no" class="form-control" value="@if(!empty($invoice_no)){{$invoice_no}}@endif" readonly=""> 
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Inv Date</label>
                        <input name="inv_date" type="text" id="inv_date" class="form-control" value="@if(!empty($invoice_date)){{$invoice_date}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('freight_cost_3') ? 'has-error' : '' }}" style="margin-bottom: 0px;">
                        <label for="">Inv Value</label>
                        <input name="inv_value" type="text" id="inv_value" class="form-control" value="@if(!empty($totalAmount)){{$totalAmount}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Name Of Importer</label>
                        <input name="name_of_importer" type="text" id="name_of_importer" class="form-control" value="@if(!empty($importer_name)){{$importer_name}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Importer Address</label>
                        <input name="importer_address" type="text" id="importer_address" class="form-control" value="@if(!empty($importer_address)){{$importer_address}}@endif" readonly="">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Quantity</label>
                        <input name="quantity" type="text" id="quantity" class="form-control" value="@if(!empty($pcs_in_ctn)){{$pcs_in_ctn}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Carton</label>
                        <input name="carton" type="text" id="carton" class="form-control" value="@if(!empty($total_ctn)){{$total_ctn}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exported Value</label>
                        <input name="exported_value" type="text" id="exported_value" class="form-control" value="@if(!empty($totalAmount)){{$totalAmount}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exp No</label>
                        <input name="exp_no" type="text" id="exp_no" class="form-control" value="@if(!empty($exp_no)){{$exp_no}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exp Date</label>
                        <input name="exp_date" type="text" id="exp_date" class="form-control" value="@if(!empty($exp_date)){{$exp_date}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exp Value</label>
                        <input name="exp_value" type="text" id="exp_value" class="form-control" value="@if(!empty($totalAmount)){{$totalAmount}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Realise Value</label>
                        <input name="realise_value" type="text" id="realise_value" class="form-control" value="@if(!empty($amount_of_proceed_realized)){{$amount_of_proceed_realized}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">OD Sight Rate</label>
                        <input name="od_sight_rate" type="text" id="od_sight_rate" class="form-control" value="@if(!empty($od_sight_rate)){{$od_sight_rate}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Freight</label>
                        <input name="freight" type="text" id="freight" class="form-control" value="@if(!empty($freight_cost)){{$freight_cost}}@else{{'0'}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Shipment Date</label>
                        <input name="shipment_date" type="text" id="shipment_date" class="form-control" value="@if(!empty($shipped_on_board_date)){{$shipped_on_board_date}}@endif" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Discharge Port</label>
                        <input name="discharge_port" type="text" id="discharge_port" class="form-control" value="@if(!empty($discharge_port)){{$discharge_port}}@endif" readonly="">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Insurance</label>
                        <input name="insurance" type="text" id="insurance" class="form-control" value="@if(!empty($insurance)){{$insurance}}@else{{'0'}}@endif" readonly="">
                    </div>
                </div>
                </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
      <div class="col-md-12">
      <div class="box box-primary">
          <div class="panel-body table-responsive">
          <table class="table table-bordered table-responsive table-condenced" style="font-size: 12px;font-weight: bold;" id="tblMain">
              <thead style="background: #df7ede;">
                  <th>Group</th>
                  <th>BU<br>Name</th>
                  <th>Item</th>
                  <th>Code</th>
                  <th>Pack<br>Size</th>
                  <th>Carton</th>
                  <th>Net<br>Weight</th>
                  <th>Amount</th>
                  <th>Rate/(kg)</th>
                  <th>FOB</th>
                  <th>Claim<br>BDT</th>
                  <th>Short<br>Access</th>
                  <th>Realize</th>
                  <th>Ins</th>
                  <th>CFR</th>
                  <th>Bapa<br>Rate</th>
              </thead>
              <tbody>
                  <?php $i=1; ?>
                  <?php $itemGroupName=''; $totalCtn=0; $totalNetWeight=0; $subTotalCtn=0; $subTotalAmount=0; $subNetWeight=0;$subFreightValue=array(); $subFob=0; $subFreight=0; $minus_fob_value=0;$totalFreightCost=0;$short_access=0;$insuranceTotal=0;$minusFobValue=array();$itemGroup=array();$total_amount=0;$carton_fright_pl_rate=0; $insurance_array=array(); $fob_array=array(); $claimBdtArray=array();$netWeightArray=array();$subtruckInsu=0;$total_sub_total_value=array();?>
                  @if(!empty($itemDetails))
                  @foreach($itemDetails as $itemDetail)
                      <?php

                        $results=DB::select("SELECT
                              ci_items.p_net_weight,ci_items.duplicate_name as ci_item_name,ci_items.ci_item_code,item_groups.item_group_name,item_groups.id AS item_group_id,
                              sale_contracts.id AS sale_contract_id,sale_contract_details.ctn,sale_contract_details.total_amount, bus.name as bu_name,bus.code,ci_items.bapa_rate,ci_items.bapa_old_date,ci_items.bapa_new_rate,ci_items.bapa_new_date,ci_items.ci_factor,sale_contract_details.ctn,sale_contract_details.rate_per_ctn,sale_contract_details.net_weight_kg
                          FROM
                              sale_contracts
                          JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
                          JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                          JOIN item_groups ON item_groups.id = ci_items.item_group_id
                          JOIN bus ON bus.id=ci_items.bu_id
                          WHERE
                              sale_contracts.id = '$itemDetail->sale_contract_id' AND item_groups.id = '$itemDetail->item_group_id' AND item_groups.id!=236 AND bus.id='$itemDetail->bu_id'");                   
                      ?>
                      @foreach($results as $result)
                      <?php 
                              try { 
                                  if($result->ci_factor!=0){

                                    $per_net_weight_kg_fright=$per_unit_freight*$result->net_weight_kg;
                                    $caton_fright=$per_net_weight_kg_fright/$result->ctn;
                                    $carton_fright_pl_rate=round($caton_fright+$result->rate_per_ctn, 3);
                                     

                                  }else{

                                    $carton_fright_pl_rate="0";

                                  }

                                  }catch (Exception $e) {

                                  } 

                             $total_amount=$total_amount+round($carton_fright_pl_rate*$result->ctn,2);
                             $freight=number_format($total_amount/$result->net_weight_kg,4); 
                             $shipment_date=date("Y-m-d", strtotime($shipped_on_board_date));
                             $bapaOldDate=date("Y-m-d", strtotime($result->bapa_old_date));

                             if($shipment_date<=$bapaOldDate){
                                 
                                $bapa_rate=$result->bapa_rate;
                                

                             }else{

                                $bapa_rate=$result->bapa_new_rate;

                             }

                             $crf=number_format($freight_cost/$total_net_weight,4)+$bapa_rate;

                        ?>
                      <tr>
                           <td>@if($i==1){{$result->item_group_name}}@endif</td>
                           <td>{{$result->bu_name}}</td>
                           <td style="font-size: 12px">{{$result->ci_item_name}}</td>
                           <td>{{$result->ci_item_code}}</td>
                           <td>{{$result->p_net_weight}}<?php if($crf<$freight){ $fob_rate=$freight-$crf; $minus_fob_value=$fob_rate*$result->net_weight_kg; array_push($minusFobValue, $minus_fob_value);} else{ $minus_fob_value=0; } ?></td>
                           <td>{{$result->ctn}}<?php $totalCtn=$totalCtn+$result->ctn?><?php $subTotalCtn=$subTotalCtn+$result->ctn?></td>
                           <td>{{$result->net_weight_kg}}<?php $totalNetWeight=$totalNetWeight+$result->net_weight_kg?><?php $subNetWeight=$subNetWeight+$result->net_weight_kg?></td>
                           <td><?php $subTotalAmount=$subTotalAmount+$total_amount?>{{number_format($total_amount,2)}}</td>
                           <td style="@if($crf<$freight)
                                 background-color : #E34646;@endif">{{$freight}}</td>
                           <td><?php $short_access=$short_access+$minus_fob_value ?>{{$short_access}}</td>
                           <td><?php $i++;?></td>
                           <td><?php $insuranceTotal=$insuranceTotal+($insurance*$result->net_weight_kg)/$total_net_weight?>{{number_format($minus_fob_value,3)}}</td>
                           <td><?php array_push($netWeightArray,$result->net_weight_kg)?></td>
                           <td>{{number_format(($insurance*$result->net_weight_kg)/$total_net_weight,4)}}</td>
                           <td>{{$crf}}<?php array_push($insurance_array, $insuranceTotal); $subtruckInsu=$subtruckInsu+$insuranceTotal?></td>
                           <td>{{$bapa_rate}}<?php array_push($itemGroup, $result->item_group_id)?></td>
                      </tr>
                      <?php $total_amount=0;$insuranceTotal=0;$claimPercent=0?>
                      @endforeach
                      <tr style="background: #c6c6">
                         <td></td>
                         <td></td>
                         <td><?php array_push($total_sub_total_value,$subTotalAmount)?></td>
                         <td><?php $item_group_id=end($itemGroup);?></td>
                         <td>{{$subTotalAmount}}</td>
                         <?php

                            $claim_id=DB::table('assign_item_claims')->where('assign_item_claims.item_group_id', $item_group_id)->select('assign_item_claims.ci_item_claim_id as claim_id')->first()->claim_id;
                            $claimPercents=DB::select("SELECT ci_item_claims.ci_item_claim_percentage AS claimPercent FROM ci_item_claims WHERE ci_item_claims.id=$claim_id");
                            $claimPercents = DB::table('claim_details')
                                    ->select('claim_details.ci_item_claim_percentage AS claimPercent')
                                    ->where('fship_date', '<=', $shipment_date)  
                                    ->where('tship_date', '>=', $shipment_date)
                                    ->where('claim_id', $claim_id)
                                    ->get();
                            foreach($claimPercents as $key =>$value) {

                                $claimPercent=$value->claimPercent;
                            
                            }


                            $claimPercent=$claimPercent/100;      
                       
                              
                         ?>
                         <td><?php echo $subTotalCtn; ?></td>
                         <td><?php echo $subNetWeight; ?></td>
                         <td><?php echo $subTotalAmount;?></td>
                         <td>{{number_format($subNetWeight*$freight_cost/$total_net_weight,4)}}<?php $totalFreightCost=$totalFreightCost+($subNetWeight*$freight_cost/$total_net_weight)?></td>
                         <td><?php $fob=$subTotalAmount-($subNetWeight*$freight_cost/$total_net_weight)-(($realize_amont*$subNetWeight)/$total_net_weight)-$short_access-$subtruckInsu?>{{number_format($fob,4)}}</td>
                         <td>{{number_format($fob*$claimPercent*$od_sight_rate,4)}}</td>
                         <td>{{number_format($subNetWeight*$realize_amont/$total_net_weight,3)}}</td>
                         <td>{{number_format($realize_amont,3)}}</td>
                         <td><?php array_push($fob_array,$fob)?>{{number_format($subtruckInsu,3)}}</td>
                         <td><?php array_push($claimBdtArray,$fob*$claimPercent*$od_sight_rate)?></td>
                         <td><?php $total_short_access=array_sum($minusFobValue);?></td>
                     </tr>
                     <?php $subTotalCtn=0; $subTotalAmount=0; $subNetWeight=0; $i=1; $short_access=0; $insuranceTotal=0; $carton_fright_pl_rate=0;$subtruckInsu=0;?> 
                  @endforeach
                  @endif
                  <?php if(empty($total_short_access)){ $total_short_access=0; }?>
                 <tr style="">
                     <td colspan="4">Non Eligible Item:<input name="non_eligible_item" type="text" id="non_eligible_item" class="form-control" value="{{round(($noneligibleItemTotal+$total_short_access),2)}}" readonly="" style="background: #FFFFFF"></td>
                     <?php $net_fob=$net_fob-$total_short_access;?>
                     <td colspan="4">NET FOB:<input name="net_fob" type="text" id="net_fob" class="form-control" value="{{round($net_fob,2)}}" readonly="" style="background: #FFFFFF"></td>
                     <?php $local_material=(($net_fob*$avgPercentage)/100);?>
                     <td colspan="4">Local Material:<input name="local_material" type="text" id="local_material" class="form-control" value="{{round($local_material,2)}}" readonly=""></td>
                     <td colspan="4">Imported Material:<input name="imported" type="text" id="imported" class="form-control" value="{{round(($net_fob-$local_material),2)}}" readonly=""></td>
                  </tr>
                  <tr style="background: #c6c6c6;">
                       <td>Total:</td>
                       <td></td>
                       <td><?php $netWeight=array_sum($netWeightArray);?></td>
                       <td><?php $claimBDT=array_sum($claimBdtArray);?></td>
                       <td><?php $total_fob=array_sum($fob_array);?></td>
                       <td></td>
                       <td>{{number_format($netWeight,2)}}</td>
                       <td><?php echo $total_sub_total_value=array_sum($total_sub_total_value);?></td>
                       <td>{{number_format($totalFreightCost)}}</td>
                       <td>{{number_format($total_fob,2)}}</td>
                       <td><input type="text" name="total_claim_bdt" value="{{round($claimBDT,2)}}" style="border:none;background: bottom;" readonly="" id="total_claim_bdt"></td>
                       <td></td>
                       <td><?php $insuracneValue=array_sum($insurance_array);?></td>
                       <td>{{number_format($insuracneValue)}}</td>  
                       <td></td> 
                       <td><input type="hidden" class="form-control" name="sale_contact_id" id="sale_contact_id" value="{{$sale_contact_id}}"></td>  
                  </tr>
              </tbody>
          </table>
        </div>
        <div class="container">
            <h4 style="margin-top: -30px;color: black" class="inline"></h4>
            <input type="submit" class="inline btn btn-success" id="slide_stop_button"  value="Upgrade Data" style="margin-left: 160px">
        </div>
      </form>
  </div>
  </div>
</div> 
<script>document.title = 'Sci Com | Inv';</script>
<script type="text/javascript">
  
  setTimeout(function() { 
          $('.sr-only').click();
    }, 0.0001);
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
       var total_claim_bdt= $('#total_claim_bdt').val();
       var sale_contact_id= $('#sale_contact_id').val();
       if(ref_name==""){

           alert("Please Enter Ref Number");

       }else if(date==""){

           alert("Please Select Date");
           
       }else{

            $.ajax({
               method: 'GET',
               url: "/json/save_com_inv_details",
               data: {'ref_name': ref_name,'date': date,'time_out':time_out,'bank':bank,'bank_address':bank_address,'sc_no':sc_no,
               'sc_date':sc_date,'sc_value':sc_value,'inv_no':inv_no,'inv_date':inv_date,'inv_value':inv_value,'name_of_importer':name_of_importer,'importer_address':importer_address,'quantity':quantity,'carton':carton,'exported_value':exported_value,
               'exp_no':exp_no,'exp_date':exp_date,'exp_value':exp_value,'realise_value':realise_value,'od_sight_rate':od_sight_rate,'freight':freight,'shipment_date':shipment_date,'discharge_port':discharge_port,'insurance':insurance,'net_fob':net_fob,'non_eligible_item':non_eligible_item,'local_material':local_material,'imported':imported,'claim_usd':claim_usd,'description_of_good':description_of_good,'total_claim_bdt':total_claim_bdt,'sale_contact_id':sale_contact_id,'_token': $('input[name=_token]').val()},
               success: function (value) {

                    console.log(value);
                    if(value=="Success"){

                        alert("Information Updated Successfull..!!");
                        $('#slide_stop_button').attr('disabled','disabled');

                    }else if(value=="Exist"){
                       
                        alert("Information Updated Already Exist..!!");

                    }else{

                        alert("Information Updated Failed..!!");

                    }
                                                               
               },
               error: function (e) {

                   console.log(e);
               }
                     
            }); 

       }   
         
 });
</script>
@endsection