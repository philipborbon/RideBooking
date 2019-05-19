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
        <div class="m-1 text-right"><a href="{{action('VehicleController@create')}}" class="btn btn-primary">Add Vehicle</a></div>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Driver</th>
              <th scope="col">Plate #</th>
              <th scope="col">Cab #</th>
              <th scope="col">Description</th>
              <th scope="col" colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($vehicles as $vehicle)
            <tr>
              <th scope="row">{{$vehicle->id}}</th>
              <td>
                @php 
                if ($vehicle->driver) {
                  echo $vehicle->driver->getFullname();
                }
                @endphp
              </td>
              <td>{{$vehicle->platenumber}}</td>
              <td>{{$vehicle->cabnumber}}</td>
              <td>{{$vehicle->description}}</td>
              <td><a href="{{action('VehicleController@edit', $vehicle['id'])}}" class="btn btn-warning">Edit</a></td>
              <td>
                <form action="{{action('VehicleController@destroy', $vehicle['id'])}}" method="post">
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