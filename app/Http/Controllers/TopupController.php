<?php

namespace RideBooking\Http\Controllers;

use Illuminate\Http\Request;
use RideBooking\Topup;
use RideBooking\Wallet;
use RideBooking\WalletTransaction;

class TopupController extends Controller
{
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

            $wallet->save();

            $transaction = [
                'fromwalletid' => $wallet->id,
                'amount' => $topup->amount,
                'type' => 'topup'
            ];

            WalletTransaction::create($transaction);
        }

        $topup->approved = true;

        $topup->save();

        return redirect('topups')->with('success', 'Topup has beend approved');
    }
}
