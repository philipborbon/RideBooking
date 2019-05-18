@extends('layouts.app')

@section('content')
<div class="container">
        @if (Session::has('message'))
          <div class="alert alert-info"><p>{{ Session::get('message') }}</p></div>
        @endif
        @if (Session::has('success'))
        <div class="alert alert-success">
          <p>{{ Session::get('success') }}</p>
        </div>
        @endif
        <div class="m-1 text-right"><a href="{{action('RideScheduleController@create')}}" class="btn btn-primary">Add Schedule</a></div>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Vehicle</th>
              <th scope="col">Boarding</th>
              <th scope="col">Departure</th>
              <th scope="col">Departed</th>
              <th scope="col">Active</th>
              <th scope="col" colspan="3">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($schedules as $schedule)
            <tr>
              <th scope="row">{{$schedule->id}}</th>
              <td>{{$schedule->vehicle->description}}</td>
              <td>{{date('H:i', strtotime($schedule->boardingtime))}}</td>
              <td>{{date('H:i', strtotime($schedule->departuretime))}}</td>
              <td>{{$schedule->departed ? 'Yes' : 'No'}}</td>
              <td>{{$schedule->active ? 'Yes' : 'No'}}</td>
              <td><a href="{{action('RideScheduleController@route', $schedule['id'])}}" class="btn btn-info">Routes</a></td>
              <td><a href="{{action('RideScheduleController@edit', $schedule['id'])}}" class="btn btn-warning">Edit</a></td>
              <td>
                <form action="{{action('RideScheduleController@destroy', $schedule['id'])}}" method="post">
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