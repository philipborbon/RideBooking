<?php

namespace RideBooking\Http\Controllers;

use Illuminate\Http\Request;
use RideBooking\Vehicle;
use RideBooking\User;

class VehicleController extends Controller
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
        $vehicles = Vehicle::with('driver', 'operator')->get();
        return view('vehicle.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $drivers = User::where('usertype', 'driver')->get();
        $operators = User::where('usertype', 'operator')->get();

        return view('vehicle.create', compact('drivers', 'operators'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vehicle = $this->validate(request(), [
            'description' => 'nullable|string',
            'driverid' => 'required|exists:users,id',
            'seats' => 'nullable|regex:/^[1-9][0-9]*/|not_in:0',
            'platenumber' => 'nullable|string',
            'cabnumber' => 'nullable|string',
            'available' => 'in:1,0',
            'operatorid' => 'required|exists:users,id',
            'boundary' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);

        Vehicle::create($vehicle);

        return back()->with('success', 'Vehicle has been added.');
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
        $vehicle = Vehicle::find($id);
        $drivers = User::where('usertype', 'driver')->get();
        $operators = User::where('usertype', 'operator')->get();

        return view('vehicle.edit', compact('drivers', 'operators', 'vehicle','id'));
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
            'description' => 'nullable|string',
            'driverid' => 'required|exists:users,id',
            'seats' => 'nullable|regex:/^[1-9][0-9]*/|not_in:0',
            'platenumber' => 'nullable|string',
            'cabnumber' => 'nullable|string',
            'available' => 'in:1,0',
            'operatorid' => 'required|exists:users,id',
            'boundary' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);

        $vehicle = Vehicle::find($id);
        $vehicle->description = $request->get('description');
        $vehicle->driverid = $request->get('driverid');
        $vehicle->seats = $request->get('seats');
        $vehicle->platenumber = $request->get('platenumber');
        $vehicle->cabnumber = $request->get('cabnumber');
        $vehicle->available = $request->get('available');
        $vehicle->operatorid = $request->get('operatorid');
        $vehicle->boundary = $request->get('boundary');

        $vehicle->save();

        return redirect('vehicles')->with('success','Vehicle has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->delete();
        return redirect('vehicles')->with('success','Vehicle has been deleted.');
    }
}
