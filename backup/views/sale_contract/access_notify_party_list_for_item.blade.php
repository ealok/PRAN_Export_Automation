@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>NotifyParty<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/notify_party')}}"><i class="fa fa-dashboard"></i>notify_party</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      @if(Session::has('success'))
        <div class=container>
          <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong>Success!</strong>{{ Session::get('success') }}
          </div>
       </div> 
      @endif 
      @if(Session::has('danger'))
        <div class=container>
          <div class="alert alert-warning alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong>Warning!</strong>{{ Session::get('danger') }}
          </div>
       </div> 
      @endif
      <div class="box box-primary">
        <div class="box-header with-border">NotifyParty <a href="{{url('/notify_party_item/create')}}">
          <button class="btn btn-xs btn-success pull-right btn-flat">Create</button></a>
        </div>
        <div class="panel-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive table-condenced ">
              <thead>
                  <th>Id</th>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Ref_Name</th>
                  <th>Controls</th>
              </thead>
              <tbody>
                @foreach ($notify_parties as $notify_party)
                  <tr>
                      <td>{{$notify_party->id}}</td>
                      <td>{{$notify_party->code}}</td>
                      <td>{{$notify_party->name}}</td>
                      <td>{{$notify_party->address}}</td>
                      <td>{{$notify_party->ref_name}}</td>
                      <td>
                          <div class="card-block">
                             <a href="{{url('/notify/party/item/list',$notify_party->id)}}" title="Show" ><button type="button" class="btn btn-xs btn-primary btn-flat">Show</button></a>
                             <button type="button" class="btn btn-xs btn-success btn-flat remove" data-toggle="modal" data-target="#copyItem" onclick="getNofityPartyId()">Copy</button>
                          </div> 
                      </td>
                  </tr>
                @endforeach  
              </tbody>
          </table>
        </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal -->
<div id="copyItem" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
  <form class="form-horizontal" id="delete_modal_form" role="form" method="POST" action="{{'/copy/notify_party/items'}}">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Copy Item</h4>
      </div>
      <div class="modal-body">
         <form class="" role="form" method="POST" action="{{ route('sale_contract.store') }}" enctype="multipart/form-data">
        <div class="modal-body mx-3">
          <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="defaultForm-email">From Party</label>
            <select name="form_party_id" id="form_party_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                <option value="">Select Notify pary</option>
                @foreach($notify_parties as $notify_party)
                <option value="{{$notify_party->id}}">{{$notify_party->code}} - {{$notify_party->name}}</option>
                @endforeach
            </select>
          </div>
          <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="defaultForm-email">To Party</label>
            <select name="to_party_id" id="to_party_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                <option value="">Select Notify pary</option>
                @foreach($all_notify_parties as $notify_party)
                <option value="{{$notify_party->id}}">{{$notify_party->code}} - {{$notify_party->name}}</option>
                @endforeach
            </select>
          </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-default">Copy</button>
      </div>
          </form>
      </div>
    </div>
    </form>

  </div>
</div>
<script>document.title = 'NotifyParty';</script>
<script type="text/javascript">
  
  setTimeout(function() { 
    $('.sr-only').click();
  }, 0.0001);
   
  $(document).on("click", "#openDeleteModal", function () {
      var delId = $(this).data("id");
      $("#delete_modal_form").attr("action", "{{url('/notify_party')}}/" + delId);
      $(".modal-body #delete_id").val( delId );
      $("#myModal").modal("show");
  });

</script>
@endsection