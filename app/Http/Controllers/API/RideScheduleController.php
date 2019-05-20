<?php

namespace RideBooking\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Carbon\Carbon;
use Validator;

use RideBooking\Http\Controllers\Controller;
use RideBooking\RideSchedule;
use RideBooking\Helpers\Response as Response;
use RideBooking\User;

class RideScheduleController extends Controller
{
    public function activeSchedules(){
        $response = new Response;
        
        $list = RideSchedule::with('vehicle', 'routes', 'routes.route')->where('active', true)->get();

        $response->data = $list;

        return response()->json($response, Response::HTTP_OK);
    }

    public function driverSchedules(){
        $response = new Response;

        $list = RideSchedule::with('vehicle', 'routes','routes.route')
        ->whereHas('vehicle', function($query) {
			$user = Auth::user();
			$query->where('vehicles.driverid', $user->id);
        })->where('active', true)->get();

        $response->data = $list;

        return response()->json($response, Response::HTTP_OK);
    }
}
