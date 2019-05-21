<?php

namespace RideBooking\Http\Controllers;

use Illuminate\Http\Request;
use RideBooking\Booking;
use RideBooking\User;
use RideBooking\Wallet;
use RideBooking\WalletTransaction;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::with('user')->get();
        return view('booking.index', compact('bookings'));
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
        $booking = Booking::with('user', 'schedule', 'seats', 'seats.route', 'seats.type')->where('id', $id)->first();
        return view('booking.detail', compact('booking'));
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
        $booking = Booking::find($id);

        if( !$booking->approved ){
            $user = User::with('wallet')->where('id', $booking->userid)->first();
            $wallet = $user->wallet;

            if ( $booking->payment > $wallet->amount ) {
                return redirect('bookings')->with('error', 'Unable to process. ' . $user->firstname . '\'s Wallet has insufficient balance.');
            }

            $wallet->amount -= $booking->payment;

            $transaction = [
                'fromwalletid' => $wallet->id,
                'amount' => $booking->payment,
                'type' => 'payment'
            ];

            $transaction = WalletTransaction::create($transaction);

            $booking->transactionid = $transaction->id;

            $wallet->save();
        }

        $booking->approved = true;

        $booking->save();

        return redirect('bookings')->with('success', 'Booking has been confirmed.');
    }

    public function cancel(Request $request, $id){
        $booking = Booking::find($id);
        $booking->closed = true;
        $booking->save();

        return redirect('bookings')->with('success', 'Booking has been cancelled.');
    }
}
