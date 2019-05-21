@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Create New Route</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ url('routes') }}">
    {{ csrf_field() }}

    <div class="row">
        <div class="col-6">

        <div class="form-group{{ $errors->has('startlocation') ? ' has-error' : '' }}">
            <label for="startlocation" class="control-label">Start</label>

            <input id="startlocation" type="text" class="form-control" name="startlocation" value="{{ old('startlocation') }}" required autofocus>

            @if ($errors->has('startlocation'))
                <span class="help-block">
                    <strong>{{ $errors->first('startlocation') }}</strong>
                </span>
            @endif
        </div>

        </div>

        <div class="col-6">

        <div class="form-group{{ $errors->has('endlocation') ? ' has-error' : '' }}">
            <label for="endlocation" class="control-label">End</label>

            <input id="endlocation" type="text" class="form-control" name="endlocation" value="{{ old('endlocation') }}" required autofocus>

            @if ($errors->has('endlocation'))
                <span class="help-block">
                    <strong>{{ $errors->first('endlocation') }}</strong>
                </span>
            @endif
        </div>

        </div>
    </div>

    <div class="row">
        <div class="col-4">

        <div class="form-group{{ $errors->has('distance') ? ' has-error' : '' }}">
            <label for="distance" class="control-label">Distance</label>

            <input id="distance" type="number" step="0.01" min="0" class="form-control" name="distance" value="{{ old('distance') }}" required autofocus>

            @if ($errors->has('distance'))
                <span class="help-block">
                    <strong>{{ $errors->first('distance') }}</strong>
                </span>
            @endif
        </div>

        </div>
        
        <div class="col-4">
            
        <div class="form-group{{ $errors->has('regularfare') ? ' has-error' : '' }}">
            <label for="regularfare" class="control-label">Regular Fare</label>

            <input id="regularfare" type="number" step="0.01" min="0" class="form-control" name="regularfare" value="{{ old('regularfare') }}" required autofocus>

            @if ($errors->has('regularfare'))
                <span class="help-block">
                    <strong>{{ $errors->first('regularfare') }}</strong>
                </span>
            @endif
        </div>

        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            Save
        </button>
    </div>
  </form>
</div>
@endsection
