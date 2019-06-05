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
use RideBooking\Vehicle;

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
            $user = Auth::user();
            $token = $user->createToken('RideBooking');

            $expiration = $token->token->expires_at->diffInSeconds(Carbon::now());

            $login = [
                'tokentype' => "Bearer",
                'token' => $token->accessToken,
                'expiresin' => $expiration,
                'user' => $user
            ];

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
        Wallet::create([
            'userid' => $user->id,
            'amount' => 0
        ]);


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
    public function detail()
    {
        $response = new Response;
        $response->data = Auth::user();

        return response()->json($response, Response::HTTP_OK);
    }

    public function isDriverAvailable(Request $request){
        $user = Auth::user();
        $vehicle = Vehicle::where('driverid', $user->id)->first();

        $response = new Response;
        $response->data = $vehicle ? $vehicle->available : 0;

        return response()->json($response, Response::HTTP_OK);
    }

    public function setDriverAvailable(Request $request){
        $response = new Response;

        $validator = Validator::make($request->all(), [
            'available' => 'boolean'
        ]);

        if ($validator->fails()) {
            $response->message = 'Invalid input.';
            return response()->json($response, Response::HTTP_BAD_REQUEST);
        }

        $user = Auth::user();
        $vehicle = Vehicle::where('driverid', $user->id)->first();

        if ( $vehicle ) {
            $vehicle->available = $request->available ? 1 : 0;
            $response->data = $vehicle->available;

            $vehicle->save();
        } else {
            $response->message = 'Driver is not associated with any vehicle.';
            return response()->json($response, Response::HTTP_BAD_REQUEST);   
        }

        return response()->json($response, Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $response = new Response;

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'password' => 'string|nullable',
            'c_password' => 'string|nullable|required_with:password|same:password',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->has('c_password')) {
                $response->message = 'Confirm password do not match with password.';
            } else {
                $response->message = 'Invalid input.';
            }

            return response()->json($response, Response::HTTP_BAD_REQUEST);
        }

        $user = Auth::user();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;

        if ( trim($request->password) != "" ) {
            $user->password = bcrypt($request->password);
        }

        $response->data = $user;
        $response->message = "Account updated.";

        return response()->json($response, Response::HTTP_OK);
    }

    public function updateToken(Request $request){
        $response = new Response;

        $validator = Validator::make($request->all(), [
            'push_token' => 'required|string'
        ]);

        if ($validator->fails()) {
            $response->message = 'Invalid input.';

            return response()->json($response, Response::HTTP_BAD_REQUEST);
        }

        $user = Auth::user();
        $user->push_token = $request->push_token;

        $user->save();

        $response->message = "Token updated.";

        return response()->json($response, Response::HTTP_OK);
    }

    public function clearToken(){
        $user = Auth::user();
        $user->push_token = NULL;

        $user->save();

        $response = new Response;
        $response->message = "Token cleared.";

        return response()->json($response, Response::HTTP_OK);
    }
}
