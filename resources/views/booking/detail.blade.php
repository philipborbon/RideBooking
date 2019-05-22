@extends('layouts.app')

@section('content')
<div class="container">
   <h1>Booking Detail</h1>

   <div class="row">
      <div class="col-6">
         <h3><small>Booking Code:</small> <b>{{ $booking->bookingcode }}</b></h3>
         <h3><small>Ammount:</small> <b>Php {{ number_format($booking->payment, 2) }}</b></h3>   
         <h3><small>Vehicle:</small> <b>{{ $booking->schedule->vehicle->description }}</b></h3>   
         <h3><small>Driver:</small> <b>{{ $booking->schedule->vehicle->driver->getFullname() }}</b></h3>
         <h3><small>Cab #:</small> <b>{{ $booking->schedule->vehicle->cabnumber }}</b></h3>
      </div>
      <div class="col-g">
         <h3><small>Status:</small> <b>{{ $booking->closed ? 'Closed' : $booking->approved ? 'Confirmed' : 'Unconfirmed' }}</b></h3>
         <h3><small>Booked By:</small> <b>@if($booking->user) {{ $booking->user->getFullname() }} @endif</b></h3>
      </div>
   </div>

   @php
   $routes = array();

   foreach($booking->seats as $seat) {
      $route;
      if ( array_key_exists($seat->route->id, $routes) ) {
         $route = $routes[$seat->route->id];
      } else {
         $route = array('route' => $seat->route, 'seats' => array());
      }

      $route['seats'][] = $seat;

      $routes[$seat->route->id] = $route;
   }

   foreach($routes as $key => $value){
      echo "<h2 class='center mt-3'>" . $value['route']->startlocation . " To " . $value['route']->endlocation . "</h2>";

      $typeString = ""; $index = 0;
      foreach($value['seats'] as $seat){
         if ($index != 0) {
            $typeString .= ", ";
         }

         $typeString .= "<span class='h4'>" . $seat->type->name . ": <b>" . $seat->count . "</b></span>";

         $index++;
      }

      echo "<div>" . $typeString . "</div>";
   }
   @endphp

   <div class="row">
   <div class="col-8"></div>
   @if($booking->closed)
   @elseif($booking->approved)
   @else
   <form class="col-2" action="{{action('BookingController@approve', $booking['id'])}}" method="post">
     {{csrf_field()}}
     <input name="_method" type="hidden" value="PATCH">
     <button class="btn btn-warning" type="submit">Confirm Booking</button>
   </form>
   @endif

   @if (!$booking->closed && !$booking->approved)
   <form class="col-2" action="{{action('BookingController@cancel', $booking['id'])}}" method="post">
     {{csrf_field()}}
     <input name="_method" type="hidden" value="PATCH">
     <button class="btn btn-danger" type="submit">Cancel Booking</button>
   </form>
   @endif
   </div>

</div>
@endsection