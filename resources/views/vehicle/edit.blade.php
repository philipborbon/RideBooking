@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Edit Vehicle</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{action('VehicleController@update', $id)}}">
      {{ csrf_field() }}

      <input name="_method" type="hidden" value="PATCH">

      <div class="row">

        <div class="col">
        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label for="description" class="control-label">Description</label>

            <input id="description" type="text" class="form-control" name="description" value="{{ old('description', $vehicle->description) }}" required autofocus>

            @if ($errors->has('description'))
                <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
        </div>

    </div>

    <div class="row">

        <div class="col">
        <div class="form-group{{ $errors->has('platenumber') ? ' has-error' : '' }}">
            <label for="platenumber" class="control-label">Plate #</label>

            <input id="platenumber" type="text" class="form-control" name="platenumber" value="{{ old('platenumber', $vehicle->platenumber) }}" required autofocus>

            @if ($errors->has('platenumber'))
                <span class="help-block">
                    <strong>{{ $errors->first('platenumber') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col">
        <div class="form-group{{ $errors->has('cabnumber') ? ' has-error' : '' }}">
            <label for="cabnumber" class="control-label">Cab #</label>

            <input id="cabnumber" type="text" class="form-control" name="cabnumber" value="{{ old('cabnumber', $vehicle->cabnumber) }}" required autofocus>

            @if ($errors->has('cabnumber'))
                <span class="help-block">
                    <strong>{{ $errors->first('cabnumber') }}</strong>
                </span>
            @endif
        </div>
        </div>

    </div>

    <div class="row">

        <div class="col">
        <div class="form-group{{ $errors->has('driverid') ? ' has-error' : '' }}">
            <label for="driverid" class="control-label">Driver</label>

            <select id="driverid" class="form-control" name="driverid" autofocus>
              @foreach($drivers as $driver)
                <option value="{{ $driver->id }}" {{ old('driverid', $vehicle->driverid) == $driver->id ? 'selected' : '' }}>{{ $driver->getFullname() }}</option>
              @endforeach
            </select>

            @if ($errors->has('driverid'))
                <span class="help-block">
                    <strong>{{ $errors->first('driverid') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col">
        <div class="form-group{{ $errors->has('operatorid') ? ' has-error' : '' }}">
            <label for="operatorid" class="control-label">Operator</label>

            <select id="operatorid" class="form-control" name="operatorid" autofocus>
              @foreach($operators as $operator)
                <option value="{{ $operator->id }}" {{ old('operatorid', $vehicle->operatorid) == $operator->id ? 'selected' : '' }}>{{ $operator->getFullname() }}</option>
              @endforeach
            </select>

            @if ($errors->has('operatorid'))
                <span class="help-block">
                    <strong>{{ $errors->first('operatorid') }}</strong>
                </span>
            @endif
        </div>
        </div>

    </div>

    <div class="row">

        <div class="col-2">
        <div class="form-group{{ $errors->has('seats') ? ' has-error' : '' }}">
            <label for="seats" class="control-label"># Of Seats</label>

            <input id="seats" type="number" min="1" class="form-control" name="seats" value="{{ old('seats', $vehicle->seats) }}" autofocus>

            @if ($errors->has('seats'))
                <span class="help-block">
                    <strong>{{ $errors->first('seats') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col-2">
        <div class="form-group{{ $errors->has('boundary') ? ' has-error' : '' }}">
            <label for="boundary" class="control-label">Boundary</label>

            <input id="boundary" type="number" min="0" step="0.01" class="form-control" name="boundary" value="{{ old('boundary', $vehicle->boundary) }}" autofocus>

            @if ($errors->has('boundary'))
                <span class="help-block">
                    <strong>{{ $errors->first('boundary') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col-2">
        <div class="form-group{{ $errors->has('available') ? ' has-error' : '' }}">
            <label for="available" class="control-label">Available?</label>

            <select id="available" class="form-control" name="available" autofocus>
                <option value="1" @if (old('available', $vehicle->available) == 1) selected @endif>Yes</option>
                <option value="0" @if (old('available', $vehicle->available) == 0) selected @endif>No</option>
            </select>

            @if ($errors->has('available'))
                <span class="help-block">
                    <strong>{{ $errors->first('available') }}</strong>
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
