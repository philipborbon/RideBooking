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

class BookingController extends Controller
{
    public function create(Request $request){
        $response = new Response;

        $user = Auth::user();
    }
}
