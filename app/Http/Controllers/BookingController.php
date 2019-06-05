<?php

namespace RideBooking\Http\Controllers;

use Illuminate\Http\Request;
use RideBooking\Booking;
use RideBooking\User;
use RideBooking\Wallet;
use RideBooking\WalletTransaction;
use RideBooking\VehicleCollection;
use RideBooking\Helpers\Notification;

class BookingController extends Controller
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
        $bookings = Booking::with('user')
        ->orderBy('approved', 'ASC')
        ->orderBy('created_at', 'DESC')->get();
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
        $booking = Booking::with('schedule')->where('id', $id)->first();

        if( !$booking->approved ){
            $user = User::with('wallet')->where('id', $booking->userid)->first();
            $wallet = $user->wallet;

            $payment = $booking->payment;

            if ( $payment > $wallet->amount ) {
                return redirect('bookings')->with('error', 'Unable to process. ' . $user->firstname . '\'s Wallet has insufficient balance.');
            }

            $wallet->amount -= $payment;

            $collection = VehicleCollection::where('vehicleid', $booking->schedule->vehicleid)
                ->where('fordate', $booking->schedule->date)
                ->where('processed', false)->first();

            if( $collection ){
                $collection->amount += $payment;
                $collection->save();
            } else {
                if ( $booking->schedule->vehicle->driver ) {
                    $collection = [
                        'driverid' => $booking->schedule->vehicle->driver->id,
                        'vehicleid' => $booking->schedule->vehicleid,
                        'amount' => $payment, 
                        'fordate' => $booking->schedule->date
                    ];

                    VehicleCollection::create($collection);
                } else {
                    return redirect('bookings')->with('error', 'Unable to confirm booking, vehicle for this booking doesn\'t have a driver.');
                }
            }

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

        $user = $booking->user;
        $driver = $booking->schedule->vehicle->driver;

        if ( $user->push_token ) {
            $notification = new Notification;
            $notification->pushToken = $user->push_token;
            $notification->title = "Booking Confirmed";
            $notification->message = "Hi " . $user->firstname . ". Your booking with code: ". $booking->bookingcode . " for " . $booking->schedule->date->format('M d, Y') . " has been confirmed.";
            $notification->clickAction = Notification::ACTION_BOOKING;

            Notification::sendPushNotification($notification);
        }

        if ( $driver->push_token ) {
            $notification = new Notification;
            $notification->pushToken = $driver->push_token;
            $notification->title = "Booking Paid";
            $notification->message = "Hi " . $driver->firstname . ". Booking with code: ". $booking->bookingcode . " for " . $booking->schedule->date->format('M d, Y') . " has been paid.";
            $notification->clickAction = Notification::ACTION_PAID_BOOKING;

            Notification::sendPushNotification($notification);
        }

        return redirect('bookings')->with('success', 'Booking has been confirmed.');
    }

    public function cancel(Request $request, $id){
        $booking = Booking::find($id);
        $booking->closed = true;
        $booking->save();

        return redirect('bookings')->with('success', 'Booking has been cancelled.');
    }
}
