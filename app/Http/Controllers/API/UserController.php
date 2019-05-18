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

class UserController extends Controller
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        $response = new Response;

        if ( Auth::attempt(['email' => request('username'), 'password' => request('password')]) ) {
            Passport::tokensExpireIn(Carbon::now()->addDays(30));
            Passport::refreshTokensExpireIn(Carbon::now()->addDays(60));

            $user = Auth::user();
            $token = $user->createToken('RideBooking');

            $expiration = $token->token->expires_at->diffInSeconds(Carbon::now());

            $login = [
                'tokentype' => "Bearer",
                'token' => $token->accessToken,
                'expiresin' => $expiration,
                'user' => $user
            ];

            $response->message = 'Success';
            $response->data = $login;

            return response()->json($response, Response::HTTP_OK);
        } else {
            $response->message = 'Unauthorized';
            return response()->json($response, 401);                             
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $response = new Response;

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->has('email')) {
                $response->message = 'Email address is already taken.';
            } else if ($errors->has('c_password')) {
                $response->message = 'Confirm password do not match with password.';
            } else {
                $response->message = 'Invalid input.';
            }

            return response()->json($response, Response::HTTP_UNAUTHORIZED);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $token = $user->createToken('RideBooking');

        $expiration = $token->token->expires_at->diffInSeconds(Carbon::now());

        $login = [
            'tokentype' => "Bearer",
            'token' => $token->accessToken,
            'expiresin' => $expiration,
            'user' => $user
        ];

        $response->data = $login;
        $response->message = "Account created.";

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $response = new Response;
        $response->data = Auth::user();

        return response()->json($response, Response::HTTP_OK);
    }
}
