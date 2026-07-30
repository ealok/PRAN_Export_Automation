@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
    @if(Session::has('success'))
                  <div class="alert alert-success">
                      <strong>Success!</strong>{{ Session::get('success') }}
                    </div> 
      @endif 
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Features: <a href="{{url('/feature/create')}}"><button class="btn btn-xs btn-success pull-right">Create feature</button></a></div>

                <div class="panel-body table-responsive">
                    <table class="table table-bordered table-responsive table-condenced" id="example1">
                        <thead>
                         <tr> 
                            <th>Sl</th>
                            <th>Feature Name</th>
                            <th>Controls</th>
                          </tr>  
                        </thead>
                        <tbody>
                         @foreach ($features as $feature)
                            <tr>
                                <td>{{$feature->id}}</td>
                                <td>{{$feature->name}}</td>
                                <td><a href="/feature/{{ $feature->id }}/edit"><button type="button" class="btn btn-xs btn-info">Edit</button></a></td>
                            </tr>
                          @endforeach  
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
