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
use RideBooking\Redeem;

class WalletController extends Controller
{
    public function detail(){
        $response = new Response;

        $user = Auth::user();
        $wallet = Wallet::where('userid', $user->id)->first();

        $response->data = $wallet;

        return response()->json($response, Response::HTTP_OK);
    }

    public function topup(Request $request){
    	$response = new Response;

        $validator = Validator::make($request->all(), [
			'amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);

        if ($validator->fails()){
        	$errors = $validator->errors();

        	if($errors->has('amount')){
        		$response->message = $errors->first('amount');
        	}

        	return response()->json($response, Response::HTTP_BAD_REQUEST);
        }

        $user = Auth::user();
        $wallet = Wallet::where('userid', $user->id)->first();

        $topup = [
        	'walletid' => $wallet->id,
        	'amount' => $request->amount,
        	'topupcode' => Util::generateCode()
        ];

     	$topup = Topup::create($topup);

     	$response->data = $topup->topupcode;

     	return response()->json($response, Response::HTTP_OK);
    }

    public function topups(){
        $response = new Response;

        $user = Auth::user();
        $wallet = Wallet::where('userid', $user->id)->first();
        $topups = Topup::where('walletid', $wallet->id)->orderBy('created_at', 'DESC')->get();

        $response->data = $topups;

        return response()->json($response, Response::HTTP_OK);
    }

    public function redeem(Request $request){
        $response = new Response;

        $validator = Validator::make($request->all(), [
            'amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);

        if ($validator->fails()){
            $errors = $validator->errors();

            if($errors->has('amount')){
                $response->message = $errors->first('amount');
            }

            return response()->json($response, Response::HTTP_BAD_REQUEST);
        }

        $user = Auth::user();
        $wallet = Wallet::where('userid', $user->id)->first();

        $redeem = [
            'walletid' => $wallet->id,
            'amount' => $request->amount,
            'redeemcode' => Util::generateCode()
        ];

        $redeem = Redeem::create($redeem);

        $response->data = $redeem->redeemcode;

        return response()->json($response, Response::HTTP_OK);
    }

    public function redeems(){
        $response = new Response;

        $user = Auth::user();
        $wallet = Wallet::where('userid', $user->id)->first();
        $redeems = Redeem::where('walletid', $wallet->id)->orderBy('created_at', 'DESC')->get();

        $response->data = $redeems;

        return response()->json($response, Response::HTTP_OK);
    }
}
