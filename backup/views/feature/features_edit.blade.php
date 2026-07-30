    @extends('layouts.master')

    @section('content')

    <diSv class="container">
        <div class="row">
              @if(Session::has('success'))
                  <div class="alert alert-success">
                      <strong>Success!</strong>{{ Session::get('success') }}
                    </div> 
              @endif 

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                <div class="panel-heading">Edit Feture</div>

                <div class="panel-body">
                  <form class="form-horizontal" role="form" method="POST" action="/feature/{{$feature->id}}">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <input type="hidden" name="_method" value="PUT">
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $feature->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary pull-right" autofocus>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--               map   -->


    @endsection
