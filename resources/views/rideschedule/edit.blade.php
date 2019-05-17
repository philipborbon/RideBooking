@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Update Schedule</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ action('RideScheduleController@update', $id) }}">
    {{ csrf_field() }}

    <input name="_method" type="hidden" value="PATCH">

    <div class="form-group{{ $errors->has('vehicleid') ? ' has-error' : '' }}">
        <label for="vehicleid" class="control-label">Vehicle</label>

        <select id="vehicleid" class="form-control" name="vehicleid" autofocus>
          @foreach($vehicles as $vehicle)
            <option value="{{ $vehicle->id }}" {{ $schedule->vehicleid == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->description }}</option>
          @endforeach
        </select>

        @if ($errors->has('vehicleid'))
            <span class="help-block">
                <strong>{{ $errors->first('vehicleid') }}</strong>
            </span>
        @endif
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                <label for="date" class="control-label">Date</label>

                <input id="date" type="date" class="form-control" name="date" value="{{ $schedule->date }}" required autofocus>

                @if ($errors->has('date'))
                    <span class="help-block">
                        <strong>{{ $errors->first('date') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-6">

        <div class="form-group{{ $errors->has('boardingtime') ? ' has-error' : '' }}">
            <label for="boardingtime" class="control-label">Boarding Time</label>

            <input id="boardingtime" type="time" class="form-control" name="boardingtime" value="{{ date('H:i', strtotime($schedule->boardingtime)) }}" required autofocus>

            @if ($errors->has('boardingtime'))
                <span class="help-block">
                    <strong>{{ $errors->first('boardingtime') }}</strong>
                </span>
            @endif
        </div>

        </div>
        

        <div class="col-6">

        <div class="form-group{{ $errors->has('departuretime') ? ' has-error' : '' }}">
            <label for="departuretime" class="control-label">Departure Time</label>

            <input id="departuretime" type="time" class="form-control" name="departuretime" value="{{ date('H:i', strtotime($schedule->departuretime)) }}" required autofocus>

            @if ($errors->has('departuretime'))
                <span class="help-block">
                    <strong>{{ $errors->first('departuretime') }}</strong>
                </span>
            @endif
        </div>

        </div>
    </div>

    <div class="row">
        <div class="col-4">
        <div class="form-group{{ $errors->has('departed') ? ' has-error' : '' }}">
            <label for="departed" class="control-label">Departed?</label>

            <select id="departed" class="form-control" name="departed" autofocus>
                <option value="1" @if ( $schedule->departed == 1) selected @endif>True</option>
                <option value="0" @if ( $schedule->departed == 0) selected @endif>False</option>
            </select>

            @if ($errors->has('departed'))
                <span class="help-block">
                    <strong>{{ $errors->first('departed') }}</strong>
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
