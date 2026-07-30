@extends('layouts.master')
@section('content')
<div class="container">
  <h4>Please Download Below Format</h4>
  <a href="{{asset('formats/sale_contract_format.xlsx')}}"><button class="btn btn-info">Sale Contract format</button></a>
  <a href="{{asset('formats/notify_party_format.xlsx')}}"><button class="btn btn-info">Notify Party Upload Format</button></a>
  <a href="{{asset('formats/swift_formate.xlsx')}}"><button class="btn btn-info">Swift Format</button></a>
  <a href="{{asset('formats/CI_Item_active_Inactive_format.xlsx')}}"><button class="btn btn-info">Item Active/InActive Format</button></a>
  <a href="{{asset('formats/bapa_update_format.xlsx')}}"><button class="btn btn-info">Update Bapa Rate</button></a>
  <a href="{{asset('formats/change_party_rate.xlsx')}}"><button class="btn btn-info">Update Party Rate</button></a>
  <br><br>
  <a href="{{asset('formats/Incentive_format.xlsx')}}"><button class="btn btn-info">Incentive Formate</button></a>
  <a href="{{asset('formats/COSTING_FORMAT.xlsx')}}"><button class="btn btn-info">Costing Formate</button></a>
  <a href="{{asset('formats/Prime_Cost_Format.xlsx')}}"><button class="btn btn-info">Prime Cost Format</button></a>
  <a href="{{asset('formats/item_format.xlsx')}}"><button class="btn btn-info">Web Order Formate</button></a>
  <a href="{{asset('formats/trading_Item_Format.xlsx')}}"><button class="btn btn-info">Trading Item Formate</button></a>
  <a href="{{asset('formats/BL_Upload_Format.xls')}}"><button class="btn btn-info">BL Upload Formate</button></a>
</div>
@endsection