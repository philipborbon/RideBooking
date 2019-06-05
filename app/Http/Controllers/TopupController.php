<?php

namespace RideBooking\Http\Controllers;

use Illuminate\Http\Request;
use RideBooking\Topup;
use RideBooking\Wallet;
use RideBooking\WalletTransaction;
use RideBooking\Helpers\Notification;

class TopupController extends Controller
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
        $topups = Topup::with('wallet')->get();
        return view('topup.index', compact('topups'));
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
        $topup = Topup::find($id);

        if( !$topup->approved ){
            $wallet = Wallet::find($topup->walletid);
            $wallet->amount += $topup->amount;

            $transaction = [
                'fromwalletid' => $wallet->id,
                'amount' => $topup->amount,
                'type' => 'topup'
            ];

            $transaction = WalletTransaction::create($transaction);

            $topup->transactionid = $transaction->id;

            $wallet->save();
        }

        $topup->approved = true;

        $topup->save();

        $user = $topup->wallet->user;

        if ( $user->push_token ) {
            $notification = new Notification;
            $notification->pushToken = $user->push_token;
            $notification->title = "Topup Approved";
            $notification->message = "Hi " . $user->firstname . ". Your top-up with code: ". $topup->topupcode . " on " . $topup->created_at->format('M d, Y') . " has been approved.";
            $notification->clickAction = Notification::ACTION_TOPUP;

            Notification::sendPushNotification($notification);
        }

        return redirect('topups')->with('success', 'Topup has beend approved');
    }
}
