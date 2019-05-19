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
use RideBooking\Wallet;

class WalletController extends Controller
{
    public function detail(){
        $response = new Response;

        $user = Auth::user();
        $wallet = Wallet::where('userid', $user->id)->first();

        $response->data = $wallet;

        return response()->json($response, Response::HTTP_OK);
    }
}
