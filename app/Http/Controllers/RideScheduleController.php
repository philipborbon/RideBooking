<?php

namespace RideBooking\Http\Controllers;

use Illuminate\Http\Request;
use RideBooking\RideSchedule;
use RideBooking\Vehicle;
use RideBooking\Route;
use RideBooking\RideScheduleRoute;

class RideScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = RideSchedule::with('vehicle')->get();
        return view('rideschedule.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicles = Vehicle::where('available', true)->get();
        return view('rideschedule.create', compact('vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedule = $this->validate(request(), [
            'vehicleid' => 'required|exists:vehicles,id',
            'departuretime' => 'date_format:H:i|after:boardingtime',
            'boardingtime' => 'date_format:H:i',
            'date' => 'required|date',
            'departed' => 'in:1,0'
        ]);

        RideSchedule::create($schedule);

        return back()->with('success', 'Schedule has been added.');
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
        $schedule = RideSchedule::find($id);
        $vehicles = Vehicle::where('available', true)->get();
        return view('rideschedule.edit', compact('id', 'schedule', 'vehicles'));
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
        $this->validate(request(), [
            'vehicleid' => 'required|exists:vehicles,id',
            'departuretime' => 'date_format:H:i|after:boardingtime',
            'boardingtime' => 'date_format:H:i',
            'date' => 'required|date',
            'departed' => 'in:1,0'
        ]);

        $schedule = RideSchedule::find($id);
        $schedule->vehicleid = $request->get('vehicleid');
        $schedule->departuretime = $request->get('departuretime');
        $schedule->boardingtime = $request->get('boardingtime');
        $schedule->date = $request->get('date');
        $schedule->departed = $request->get('departed');

        $schedule->save();

        return redirect('rideschedules')->with('success','Schedule has been updated.');
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
     * Manage ride routes
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function route($id)
    {
        $schedule = RideSchedule::find($id);
        $routes = Route::all();
        $rideRoutes = RideScheduleRoute::with('route')->where('scheduleid', $id)->get();
        return view('rideschedule.route', compact('id', 'schedule', 'routes', 'rideRoutes'));
    }

    /**
     * Update ride routes
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function routeUpdate(Request $request, $id)
    {
        $route = $this->validate(request(), [
            'scheduleid' => 'required|exists:ride_schedules,id',
            'routeid' => 'required|exists:routes,id'
        ]);

        $rideRoute = RideScheduleRoute::where([
            'scheduleid' => $request->scheduleid, 
            'routeid' => $request->routeid
        ])->first();

        if ($rideRoute) {
            return back()->with('error', 'Route already exist.');
        } else {
            $hasRecord = RideScheduleRoute::where('scheduleid', $request->scheduleid)->first();

            if ( !$hasRecord ) {
                $route['isMain'] = true;
            }

            RideScheduleRoute::create($route);


            return back()->with('success', 'Route has been added.');
        }
    }

    /**
     * Mark route main
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markMain($scheduleId, $id)
    {
        RideScheduleRoute::where('scheduleid', $scheduleId)->update(['isMain' => false]);

        $route = RideScheduleRoute::find($id);
        $route->isMain = true;

        $route->save();

        return back()->with('success', 'Main route has been updated.');
    }

    /**
     * Remove the route from schedule
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyRoute($scheduleId, $id)
    {
        $route = RideScheduleRoute::find($id);
        $route->delete();
        return back()->with('success','Route has been deleted.');
    }
}
