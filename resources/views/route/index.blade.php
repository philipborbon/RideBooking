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
        <div class="m-1 text-right"><a href="{{action('RouteController@create')}}" class="btn btn-primary">Add Route</a></div>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Start</th>
              <th scope="col">End</th>
              <th scope="col">Distance</th>
              <th scope="col" colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($routes as $route)
            <tr>
              <th scope="row">{{$route->id}}</th>
              <td>{{$route->startlocation}}</td>
              <td>{{$route->endlocation}}</td>
              <td>{{$route->distance}}</td>
              <td><a href="{{action('RouteController@edit', $route['id'])}}" class="btn btn-warning">Edit</a></td>
              <td>
                <form action="{{action('RouteController@destroy', $route['id'])}}" method="post">
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