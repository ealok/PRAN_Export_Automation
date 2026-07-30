@extends('layouts.master')
@section('content') 
<section class="content-header" style="padding-top: 0px;">
    <h1>Recipe<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/loading_place')}}"><i class="fa fa-dashboard"></i>Recipe</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
  @if(Session::has('success'))
  <div class="alert alert-success alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Success!</strong>{{ Session::get('success') }}
  </div>
  @endif
  @if(Session::has('danger'))
  <div class="alert alert-danger alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Alert!</strong>&nbsp;&nbsp;&nbsp;{{ Session::get('danger') }}
  </div>
  @endif
  <div>
  <div class="col-md-12">
      <div class="box box-primary">
        <a href="{{url('/recipe/create')}}">
            <button class="btn btn-xs btn-success pull-right btn-flat" style="margin-top: 5px">Create Recipe</button></a><br><br>
        <div class="panel-body table-responsive" style="margin-top: -37px">
          <table id="example1" class="table table-bordered table-responsive table-condenced">
              <thead style="background: #6edb75;">
                  <th>Sl</th>
                  <th>Fg Name</th>
                  <th>Create Date</th>
                  <th>Status</th>
                  <th>Product Percentage(%)</th>
                  <th>Controls</th>
              </thead>
              <tbody>
                 <?php $i=1; ?>
                 @foreach($results as $result)
                  <tr>
                     <td>{{$result->id}}</td>
                     <td>{{$result->name}}</td>
                     <td><?php echo $date=date("Y-m-d",strtotime($result->created_at));?></td>
                     <td>{{$result->active_status}}</td>
                     <td>{{number_format($result->product_percentage,3)}}</td>
                     <td>
                          <a href="{{url('/recipe/'.$result->id)}}" title="Show" ><button type="button" class="btn btn-xs btn-success btn-flat">Show</button></a>
                          <a href="{{url('/recipe/'.$result->id.'/edit')}}" title="Edit" ><button type="button" class="btn btn-xs btn-info btn-flat">Edit</button></a>
                          <a href="{{url('/recipe/'.$result->id.'/addnew')}}" title="Edit" ><button type="button" class="btn btn-xs btn-danger btn-flat">Add New</button></a>
                     </td>
                  </tr>
                 @endforeach 
              </tbody>
          </table>
        </div>
    </div>
  </div>
</div>
<script>document.title = 'Recipe | List';</script>
<script>
   setTimeout(function() { 
          $('.sr-only').click();
    }, 0.0001);
</script>
@endsection