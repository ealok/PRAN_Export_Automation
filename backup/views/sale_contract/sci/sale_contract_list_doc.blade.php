@extends('layouts.master')
@section('content') 
<style>
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
  
  }
  
  .table-bordered > tbody > tr > td{
  
    border: 1px solid #201f1f;
    padding: 1px;
    font-weight: bold;
  
  }
  
  table.dataTable {
  
    width: 99%;
    margin: 0 auto;
    clear: both;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 12px;
    
  }
  
  .table-bordered > tbody > tr:hover{
  
    background-color: rgba(101, 212, 97, 0.836);
  
  }
  </style>
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
    <div class="callout callout-success">
        <strong>Success!</strong>{{ Session::get('success') }}
    </div> 
  @endif 
  @if(Session::has('danger'))
    <div class="callout callout-danger">
        <strong>Unsuccessful!</strong>{{ Session::get('danger') }}
    </div> 
  @endif 
  <div>
  <div class="col-md-12">
      <div class="box box-primary">
        <div class="panel-body table-responsive">
          <table id="example2" class="table table-bordered table-responsive table-condenced ">
              <thead>
                  <th>Id</th>
                  <th>Code</th>
                  <th>Name</th>
                  {{-- <th>Address</th> --}}
                  <th>Ref_Name</th>
                  <th>Controls</th>
              </thead>
              <tbody>
                @foreach ($notify_parties as $notify_party)
                  <tr>
                      <td>{{$notify_party->id}}</td>
                      <td>{{$notify_party->code}}</td>
                      <td>{{$notify_party->name}}</td>
                      {{-- <td>{{$notify_party->address}}</td> --}}
                      <td style="background: #ddd">{{$notify_party->ref_name}}</td>
                      <td>
                          <a href="{{url('/notify/party/list/doc')}}/{{\Crypt::encrypt($notify_party->id)}}" title="Show" ><button type="button" class="btn btn-xs btn-primary btn-flat custom">Show</button></a>
                      </td>
                  </tr>
                @endforeach  
              </tbody>
          </table>
        </div>
    </div>
  </div>
</div>

<script>document.title = 'NotifyPartyList';</script>
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
  $('#example2').DataTable({
      "order": [[ 0, "DESC" ]],
      "lengthMenu": [[25, 50,100, -1], [25, 50,100,"All"]]
    });
</script>
</script>
@endsection
