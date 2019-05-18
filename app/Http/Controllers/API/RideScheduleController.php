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

class RideScheduleController extends Controller
{
    public function activeSchedules(){
        $response = new Response;
        
        $list = RideSchedule::with('vehicle', 'routes', 'routes.route')->where('active', true)->get();

        $response->data = $list;

        return response()->json($response, Response::HTTP_OK);
    }
}
