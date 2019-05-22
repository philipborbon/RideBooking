@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Collections</h1>

    @if (Session::has('message'))
      <div class="alert alert-info"><p>{{ Session::get('message') }}</p></div>
    @endif
    @if (Session::has('success'))
    <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
    </div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-danger">
      <p>{{ Session::get('error') }}</p>
    </div>
    @endif
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Driver</th>
          <th scope="col">Vehicle</th>
          <th scope="col">Date</th>
          <th scope="col">Amount</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($collections as $collection)
        <tr>
          <th scope="row">{{$collection->id}}</th>
          <td>{{$collection->driver->getFullname()}}</td>
          <td>{{$collection->vehicle->description}}</td>
          <td>{{$collection->fordate}}</td>
          <td>Php {{number_format($collection->amount, 2)}}</td>
          <td>
            @if( $collection->processed )
            Processed
            @else
            <form action="{{action('VehicleCollectionController@approve', $collection['id'])}}" method="post">
              {{csrf_field()}}
              <input name="_method" type="hidden" value="PATCH">
              <button class="btn btn-warning" type="submit">Process</button>
            </form>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
</div>
@endsection