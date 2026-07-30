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
    <h4 style="margin-bottom: -16px">SCI COMMERCIAL INV</h4>
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
             <form class="" role="form" method="POST" action="{{ route('sale_contract.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
              <div class="box-body">
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('export_no') ? 'has-error' : '' }}" style="margin-bottom: 0px;">
                        <label for="">Our_Ref_No</label>
                        <input name="" type="text" id="" value="@if(!empty($ref_name)){{$ref_name}}@endif" class="form-control">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Date</label>
                        <input name="" type="text" id=""class="form-control" placeholder="Dated"  autocomplete="off" value="@if(!empty($claim_submission_date)){{$claim_submission_date}}@endif">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;"> 
                        <label for="">Time Out</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($last_date_for_lodging_claim)){{$last_date_for_lodging_claim}}@endif">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Bank</label>    
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($bank_name)){{$bank_name}}@endif">
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Bank Addess</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($bank_address)){{$bank_address}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="freight_cost_1">S/C No</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($sales_contract_no)){{$sales_contract_no}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">S/C Date</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($sale_contact_date)){{$sale_contact_date}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">S/C Value</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($totalAmount)){{$totalAmount}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Inv No</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($invoice_no)){{$invoice_no}}@endif"> 
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Inv Date</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($invoice_date)){{$invoice_date}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('freight_cost_3') ? 'has-error' : '' }}" style="margin-bottom: 0px;">
                        <label for="">Inv Value</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($totalAmount)){{$totalAmount}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Name Of Importer</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($importer_name)){{$importer_name}}@endif">
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Importer Address</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($importer_address)){{$importer_address}}@endif">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Quantity</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($pcs_in_ctn)){{$pcs_in_ctn}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Carton</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($total_ctn)){{$total_ctn}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exported Value</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($totalAmount)){{$totalAmount}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exp No</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($exp_no)){{$exp_no}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exp Date</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($exp_date)){{$exp_date}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exp Value</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($totalAmount)){{$totalAmount}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Realise Value</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($amount_of_proceed_realized)){{$amount_of_proceed_realized}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">OD Sight Rate</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($od_sight_rate)){{$od_sight_rate}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Freight</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($freight_cost)){{$freight_cost}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Shipment Date</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($shipped_on_board_date)){{$shipped_on_board_date}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Discharge Port</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($discharge_port)){{$discharge_port}}@endif">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Insurance</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($insurance)){{$insurance}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Net FOB</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($net_fob) && $net_fob>0){{$net_fob}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Non Eligible Item</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($noneligibleItemTotal)){{$noneligibleItemTotal}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Local Material</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($localMateril)){{$localMateril}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Imported</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($imported)){{$imported}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Claim(USD)</label>
                        <input name="" type="text" id="" class="form-control">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Different Of R&I</label>
                        <input name="different_of_r_and_i" type="text" id="" class="form-control" value="@if(!empty($different_of_r_and_i) && $different_of_r_and_i>=0){{$different_of_r_and_i}}@endif">
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Description Of Goods</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($description_of_goods)){{$description_of_goods}}@endif">
                    </div>
                </div>  

                </div> 
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
      <div class="col-md-12">
      <div class="box box-primary">
          <div class="panel-body table-responsive">
          <table class="table table-bordered table-responsive table-condenced ">
              <thead style="background: #c6c6c6;">
                  <th>Group</th>
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
                              sale_contracts.id AS sale_contract_id,sale_contract_details.ctn,sale_contract_details.net_weight_kg,sale_contract_details.total_amount
                          FROM
                              sale_contracts
                          JOIN sale_contract_details ON sale_contracts.id = sale_contract_details.sale_contract_id
                          JOIN ci_items ON ci_items.id = sale_contract_details.ci_item_id
                          JOIN item_groups ON item_groups.id = ci_items.item_group_id
                          WHERE
                              sale_contracts.id = '$itemDetail->sale_contract_id' AND item_groups.id = '$itemDetail->item_group_id'");       
                      ?>
                      @foreach($results as $result)
                      <tr>
                           <td>@if($i==1){{$result->item_group_name}}@endif</td>
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
                         <td><?php echo $subTotalCtn; ?></td>
                         <td><?php echo $subNetWeight; ?></td>
                         <td><?php echo $subTotalAmount;?></td>
                         <td>{{number_format($subTotalAmount*$freight_cost/$totalAmount,3)}}</td>
                         <td><?php $fob=$subTotalAmount-($subTotalAmount*$freight_cost/$totalAmount)-$freight_cost?>{{number_format($fob,3)}}</td>
                         <td>{{number_format($fob*0.2*$od_sight_rate)}}</td>
                         <td>{{number_format($subTotalAmount*$realize_amont/$totalAmount,3)}}</td>
                         <td>{{$realize_amont}}</td>
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
                  </tr>
                  <tr style="background: #c6c6c6;">
                       <td>Total:</td>
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
        <div class="container"><h4 style="margin-top: -30px;color: black">Material Information</h4></div>
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
                           <td style="background: #224cb0;color: #FFFFFF">SL</td> 
                           <td style="background: #224cb0;color: #FFFFFF">Supplier_Name_&_Address</td>
                           <td style="background: #224cb0;color:#FFFFFF">Raw_Materials_Name</td>
                           <td style="background: #224cb0;color: #FFFFFF">Quantity(kgs/Ltr)</td>
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
                           <td style="background: #224cb0;color: #FFFFFF">SL</td> 
                           <td style="background: #224cb0;color: #FFFFFF">Supplier_Name_&_Address</td>
                           <td style="background: #224cb0;color:#FFFFFF">Raw_Materials_Name</td>
                           <td style="background: #224cb0;color: #FFFFFF">Quantity(kgs/Ltr)</td>
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
</div> 
<script>document.title = 'Sci Com | Inv';</script>
@endsection