<?php

namespace RideBooking\Http\Controllers;

use Illuminate\Http\Request;
use RideBooking\PassengerType;

class PassengerTypeController extends Controller
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
        $types = PassengerType::all();
        return view('passengertype.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('passengertype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $type = $this->validate(request(), [
            'name' => 'nullable|string|unique:passenger_types',
            'discount' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);

        PassengerType::create($type);

        return back()->with('success', 'Pasenger type has been added.');
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
        $type = PassengerType::find($id);
        return view('passengertype.edit', compact('id', 'type'));
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
            'name' => 'nullable|string|unique:passenger_types,name,' . $id,
            'discount' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);

        $type = PassengerType::find($id);
        $type->name = $request->get('name');
        $type->discount = $request->get('discount');

        $type->save();

        return redirect('passengertypes')->with('success', 'Passenger type has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = PassengerType::find($id);
        $type->delete();
        return redirect('passengertypes')->with('success','Passenger type has been  deleted.');
    }
}
