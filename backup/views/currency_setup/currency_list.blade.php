@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>Currency Setup<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/currency_setup')}}"><i class="fa fa-dashboard"></i>Currency</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      @if(Session::has('success'))
        <div class="alert alert-success">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success!</strong> {{Session::get('success')}}
        </div>    
      @endif 
      @if(Session::has('danger'))
        <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success!</strong> {{Session::get('success')}}
        </div> 
      @endif 
      <div class="box box-primary">
        <div class="box-header with-border">Currency <a href="{{url('/currency/create')}}">
            <button class="btn btn-xs btn-success pull-right btn-flat">Create Setup</button></a>
        </div>
        <div class="panel-body table-responsive">
          <table class="table table-bordered table-responsive table-condenced">
              <thead>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Exchange Rate</th>
                  <th>Controls</th>
              </thead>
              <tbody>
                @foreach ($results as $result)
                  <tr>
                      <td>{{$result->id}}</td>
                      <td>{{$result->currency_name}}</td>
                      <td>{{$result->currency_rate}}</td>
                      <td>
                          <a href="{{url('/currency/'.$result->id.'/edit')}}" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>
                      </td>
                  </tr>
                @endforeach  
              </tbody>
          </table>
          {{$results->links()}}
        </div>
    </div>
  </div>
</div>

<script>document.title = 'Currency | List';</script>
<script type="text/javascript">
     setTimeout(function() { 
          $('.sr-only').click();
    }, 0.0001);
</script>
@endsection