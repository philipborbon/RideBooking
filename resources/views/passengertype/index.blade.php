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
        <div class="m-1 text-right"><a href="{{action('PassengerTypeController@create')}}" class="btn btn-primary">Add Passenger Type</a></div>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Type</th>
              <th scope="col">Discount</th>
              <th scope="col" colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($types as $type)
            <tr>
              <th scope="row">{{$type->id}}</th>
              <td>{{$type->name}}</td>
              <td>{{$type->discount}}%</td>
              <td><a href="{{action('PassengerTypeController@edit', $type['id'])}}" class="btn btn-warning">Edit</a></td>
              <td>
                <form action="{{action('PassengerTypeController@destroy', $type['id'])}}" method="post">
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