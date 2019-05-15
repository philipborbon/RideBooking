<?php

namespace RideBooking\Http\Controllers;

use Illuminate\Http\Request;
use RideBooking\Route;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = Route::all();
        return view('route.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('route.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $route = $this->validate(request(), [
            'startlocation' => 'nullable|string',
            'endlocation' => 'nullable|string',
            'distance' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'eta' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'regularfare' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);

        Route::create($route);

        return back()->with('success', 'Route has been added.');
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
        $route = Route::find($id);
        return view('route.edit', compact('id', 'route'));
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
            'startlocation' => 'nullable|string',
            'endlocation' => 'nullable|string',
            'distance' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'eta' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'regularfare' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);

        $route = Route::find($id);
        $route->startlocation = $request->get('startlocation');
        $route->endlocation = $request->get('endlocation');
        $route->distance = $request->get('distance');
        $route->eta = $request->get('eta');
        $route->regularfare = $request->get('regularfare');

        $route->save();

        return redirect('routes')->with('success','Route has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $route = Route::find($id);
        $route->delete();
        return redirect('routes')->with('success','Route has been  deleted.');
    }
}
