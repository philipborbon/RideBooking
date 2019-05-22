<?php

namespace RideBooking\Http\Controllers;

use Illuminate\Http\Request;
use RideBooking\VehicleCollection;
use RideBooking\WalletTransaction;
use RideBooking\Wallet;

class VehicleCollectionController extends Controller
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
        $collections = VehicleCollection::with('driver', 'vehicle')
        ->orderBy('processed', 'ASC')
        ->orderBy('fordate', 'DESC')->get();
        return view('collection.index', compact('collections'));
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

    public function approve(Request $request, $id){
        $collection = VehicleCollection::find($id);

        if( !$collection->processed ){
            $vehicle = $collection->vehicle;

            if ( !$vehicle->operator ) {
                return redirect('collections')->with('error', 'Unable to process collection. Vehicle doesn\'t have an operator and can\'t transfer operator\'s boundary.');
            }

            if ( !$collection->driver ) {
                return redirect('collections')->with('error', 'Unable to process collection. Driver has beend removed and unable transfer driver\'s collection.');
            }

            if ( !$vehicle ) {
                return redirect('collections')->with('error', 'Unable to process collection. Vehicle has been removed and can\'t identify operator and boundary for processing of operator\'s boundary.');
            }

            $operatorWallet = $vehicle->operator->wallet;
            $driverWallet = $collection->driver->wallet;

            $collectionAmount = $collection->amount;

            if ( $collectionAmount > $vehicle->boundary ) {
                $boundaryTransaction = [
                    'fromwalletid' => $operatorWallet->id,
                    'amount' => $vehicle->boundary,
                    'type' => 'boundary'
                ];

                $collectionAmount -= $vehicle->boundary;

                $operatorWallet->amount += $vehicle->boundary; 
                $boundaryTransaction = WalletTransaction::create($boundaryTransaction);

                $operatorWallet->save();

                $collectionTransaction = [
                    'fromwalletid' => $driverWallet->id,
                    'amount' => $collectionAmount,
                    'type' => 'collection'
                ];

                $driverWallet->amount += $collectionAmount;
                $collectionTransaction = WalletTransaction::create($collectionTransaction);

                $driverWallet->save();
            } else {
                $boundaryTransaction = [
                    'fromwalletid' => $operatorWallet->id,
                    'amount' => $collectionAmount,
                    'type' => 'boundary'
                ];

                $operatorWallet->amount += $collectionAmount; 
                $boundaryTransaction = WalletTransaction::create($boundaryTransaction);

                $operatorWallet->save();
            }
        }

        $collection->processed = true;

        $collection->save();

        return redirect('collections')->with('success', 'Collection has beend processed.');
    }
}
