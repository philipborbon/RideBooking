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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

  /**
    * login api
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
            $response->message = 'Unauthorised';
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
       $user = Auth::user();
       return response()->json(['success' => $user], Response::HTTP_OK);
   }
}
