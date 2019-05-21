@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bookings</h1>

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
          <th scope="col">Booked By</th>
          <th scope="col">Code</th>
          <th scope="col">Amount</th>
          <th scope="col" colspan="3">Confirmation</th>
        </tr>
      </thead>
      <tbody>
        @foreach($bookings as $booking)
        <tr>
          <th scope="row">{{$booking->id}}</th>
          <td>{{$booking->user->getFullname()}}</td>
          <td>{{$booking->bookingcode}}</td>
          <td>{{number_format($booking->payment, 2)}}</td>
          <td>
            @if($booking->closed)
              Cancelled
            @elseif($booking->approved)
              Confirmed
            @else
            <form action="{{action('BookingController@approve', $booking['id'])}}" method="post">
              {{csrf_field()}}
              <input name="_method" type="hidden" value="PATCH">
              <button class="btn btn-warning" type="submit">Confirm</button>
            </form>
            @endif
          </td>
          <td>
            @if (!$booking->closed && !$booking->approved)
            <form action="{{action('BookingController@cancel', $booking['id'])}}" method="post">
              {{csrf_field()}}
              <input name="_method" type="hidden" value="PATCH">
              <button class="btn btn-danger" type="submit">Cancel</button>
            </form>
            @endif
          </td>
          <td>
            <a href="{{action('BookingController@show', $booking['id'])}}" class="btn btn-info">Details</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
</div>
@endsection