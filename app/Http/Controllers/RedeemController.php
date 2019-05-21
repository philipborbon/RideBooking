<?php

namespace RideBooking\Http\Controllers;

use Illuminate\Http\Request;
use RideBooking\Redeem;
use RideBooking\Wallet;
use RideBooking\WalletTransaction;

class RedeemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redeems = Redeem::with('wallet')->get();
        return view('redeem.index', compact('redeems'));
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
        $redeem = Redeem::find($id);

        if( !$redeem->approved ){
            $wallet = Wallet::with('user')->where('id', $redeem->walletid)->first();

            if ( $redeem->amount > $wallet->amount ) {
                return redirect('redeems')->with('error', 'Unable to process. ' . $wallet->user->firstname . '\'s Wallet has insufficient balance.');
            }

            $wallet->amount -= $redeem->amount;

            $transaction = [
                'fromwalletid' => $wallet->id,
                'amount' => $redeem->amount,
                'type' => 'redeem'
            ];

            $transaction = WalletTransaction::create($transaction);

            $redeem->transactionid = $transaction->id;

            $wallet->save();
        }

        $redeem->approved = true;

        $redeem->save();

        return redirect('redeems')->with('success', 'Redeem has beend approved.');
    }
}
