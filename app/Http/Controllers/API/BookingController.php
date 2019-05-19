<?php

namespace RideBooking\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Carbon\Carbon;
use Validator;

use RideBooking\Http\Controllers\Controller;
use RideBooking\User;
use RideBooking\Helpers\Response as Response;
use RideBooking\Helpers\Util as Util;
use RideBooking\Wallet;
use RideBooking\Topup;
use RideBooking\PassengerType;
use RideBooking\Route;
use RideBooking\Booking;
use RideBooking\BookingSeat;


class BookingController extends Controller
{
    public function create(Request $request){
        $response = new Response;

        $validator = Validator::make($request->all(), [
            'ridescheduleid' => 'required|exists:ride_schedules,id',
            'seats.*.routeid' => 'required|exists:routes,id',
            'seats.*.typeid' => 'required|exists:passenger_types,id'
        ]);

        if ($validator->fails()) {
            $response->message = "Invalid data.";
            $response->data = $validator->errors();

            return response()->json($response, Response::HTTP_BAD_REQUEST);
        }

        $input = $request->all();

        $seats = $input['seats'];

        $amount = 0;

        foreach($seats as $seat){            
            $type = PassengerType::find($seat['typeid']);
            $route = Route::find($seat['routeid']);

            $amount += $route->regularfare - (( $type->discount / 100 ) * $route->regularfare);
        }

        $user = Auth::user();

        $booking = [
            'userid' => $user->id,
            'ridescheduleid' => $request->ridescheduleid,
            'payment' => $amount,
            'bookingcode' => Util::generateCode()
        ];

        $booking = Booking::create($booking);

        $saved = array();

        foreach($seats as $seat) {
            $seat['bookingid'] = $booking->id;
            $saved[] = BookingSeat::create($seat);
        }

        $booking->seats = $saved;
        $response->data = $booking;

        return response()->json($response, Response::HTTP_OK);
    }
}
