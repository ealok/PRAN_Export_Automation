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
                        <input name="" type="text" id="" value="@if(!empty($comInvMaster->ref_name)){{$comInvMaster->ref_name}}@endif" class="form-control">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Date</label>
                        <input name="" type="text" id=""class="form-control" placeholder="Dated"  autocomplete="off" value="@if(!empty($comInvMaster->date)){{$comInvMaster->date}}@endif">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;"> 
                        <label for="">Time Out</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->time_out)){{$comInvMaster->time_out}}@endif">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Bank</label>    
                        <input name="bank" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->bank)){{$comInvMaster->bank}}@endif">
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Bank Addess</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->bank_address)){{$comInvMaster->bank_address}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="freight_cost_1">S/C No</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->sc_no)){{$comInvMaster->sc_no}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">S/C Date</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->sc_date)){{$comInvMaster->sc_no}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">S/C Value</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->totalAmount)){{$comInvMaster->sc_no}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Inv No</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->inv_no)){{$comInvMaster->inv_no}}@endif"> 
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Inv Date</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->sc_no)){{$comInvMaster->sc_no}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('freight_cost_3') ? 'has-error' : '' }}" style="margin-bottom: 0px;">
                        <label for="">Inv Value</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->inv_value)){{$comInvMaster->inv_value}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Name Of Importer</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->name_of_importer)){{$comInvMaster->name_of_importer}}@endif">
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Importer Address</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->importer_address)){{$comInvMaster->importer_address}}@endif">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Quantity</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->quantity)){{$comInvMaster->quantity}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Carton</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->carton)){{$comInvMaster->carton}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exported Value</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->exported_value)){{$comInvMaster->exported_value}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exp No</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->exp_no)){{$comInvMaster->exp_no}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exp Date</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->exp_date)){{$comInvMaster->exp_date}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Exp Value</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->exp_value)){{$comInvMaster->exp_value}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Realise Value</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->realise_value)){{$comInvMaster->realise_value}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">OD Sight Rate</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->od_sight_rate)){{$comInvMaster->od_sight_rate}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Freight</label>
                        <input name="freight" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->freight)){{$comInvMaster->freight}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Shipment Date</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->shipment_date)){{$comInvMaster->shipment_date}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Discharge Port</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->discharge_port)){{$comInvMaster->discharge_port}}@endif">
                    </div>
                </div> 

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Insurance</label>
                        <input name="insurance" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->insurance)){{$comInvMaster->insurance}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Net FOB</label>
                        <input name="net_fob" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->net_fob)){{$comInvMaster->net_fob}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Non Eligible Item</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->non_eligible_item)){{$comInvMaster->non_eligible_item}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Local Material</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->local_material)){{$comInvMaster->local_material}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Imported</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->imported)){{$comInvMaster->imported}}@endif">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Claim(USD)</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->claim_usd)){{$comInvMaster->claim_usd}}@endif">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="">Description Of Goods</label>
                        <input name="" type="text" id="" class="form-control" value="@if(!empty($comInvMaster->description_of_good)){{$comInvMaster->description_of_good}}@endif">
                    </div>
                </div>  

                </div> 
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
      <div class="col-md-12">
      <div class="box box-primary">
          <div class="panel-body table-responsive" style="margin-bottom: 38px">
          <table class="table table-bordered table-responsive table-condenced ">
              <thead style="background: #c6c6c6;">
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
</div> 
<script>document.title = 'Sci Com | Inv';</script>
@endsection