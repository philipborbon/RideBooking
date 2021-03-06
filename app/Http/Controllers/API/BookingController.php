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

            $amount += ($route->regularfare - (($type->discount / 100) * $route->regularfare)) * $seat['count'];
        }

        $user = Auth::user();
        $wallet = Wallet::where('userid', $user->id)->first();

        if ($wallet->amount < $amount) {
            $response->message = "You have insufficient balance in your wallet.";
            return response()->json($response, Response::HTTP_BAD_REQUEST);
        }

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

    public function passengerTypes(){
        $response = new Response;
        $response->data = PassengerType::all();

        return response()->json($response, Response::HTTP_OK);
    }

    public function history(){
        $user = Auth::user();
        $bookings = Booking::with('schedule', 'schedule.vehicle', 'seats', 'seats.route', 'seats.type')->where('userid', $user->id)->orderBy('created_at', 'DESC')->get();

        $response = new Response;
        $response->data = $bookings;

        return response()->json($response, Response::HTTP_OK);
    }

    public function confirmed(){
        $bookings = Booking::with('schedule', 'seats', 'seats.route', 'seats.type')
        ->whereHas('schedule.vehicle', function($query) {
            $user = Auth::user();
            $query->where('vehicles.driverid', $user->id);
        })->where('approved', true)->orderBy('created_at', 'DESC')->get();

        $response = new Response;
        $response->data = $bookings;

        return response()->json($response, Response::HTTP_OK);
    }
}
