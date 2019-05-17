@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Routes</h1>

    @if (Session::has('success'))
    <div class="alert alert-success">
    <p>{{ Session::get('success') }}</p>
    </div><br />
    @endif

    @if (Session::has('error'))
    <div class="alert alert-warning">
    <p>{{ Session::get('error') }}</p>
    </div><br />
    @endif

    <form method="POST" action="{{ action('RideScheduleController@routeUpdate', $id) }}">
        {{ csrf_field() }}

        <input name="_method" type="hidden" value="PATCH">
        <input name="scheduleid" type="hidden" value="{{ $schedule->id }}">

        <div class="form-group{{ $errors->has('routeid') ? ' has-error' : '' }}">
            <select id="routeid" class="form-control" name="routeid" autofocus>
              @foreach($routes as $route)
                <option value="{{ $route->id }}" {{ old('routeid') == $route->id ? 'selected' : '' }}>{{ $route->getDescription() }}</option>
              @endforeach
            </select>

            @if ($errors->has('routeid'))
                <span class="help-block">
                    <strong>{{ $errors->first('routeid') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>

        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Route</th>
              <th scope="col" colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($rideRoutes as $route)
            <tr>
              <th scope="row">{{$route->id}}</th>
              <td>{{$route->route->getDescription()}}</td>
              <td>
                @if ( $route->isMain )
                <label>Main Route</label>
                @else
                <form action="{{ route('mark-main', ['scheduleId' => $schedule->id, 'id' => $route->id]) }}" method="post">
                  {{csrf_field()}}
                  <input name="_method" type="hidden" value="PATCH">
                  <button class="btn btn-warning" type="submit">Make Main</button>
                </form>
                @endif
              </td>
              <td>
                <form action="{{ route('delete-route', ['scheduleId' => $schedule->id, 'id' => $route->id]) }}" method="post">
                  {{csrf_field()}}
                  <input name="_method" type="hidden" value="DELETE">
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
</div>
@endsection
