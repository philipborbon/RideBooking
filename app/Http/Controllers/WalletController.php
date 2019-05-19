<?php

namespace RideBooking\Http\Controllers;

use Illuminate\Http\Request;
use RideBooking\Wallet;
use RideBooking\User;

class WalletController extends Controller
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
    	$wallets = Wallet::with('user')->get();
    	return view('wallet.index', compact('wallets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$users = User::all();
    	return view('wallet.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $wallet = $this->validate(request(), [
        	'userid' => 'required|exists:users,id|unique:wallets',
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        Wallet::create($wallet);

        return back()->with('success', 'Wallet has been added.');
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
    	$wallet = Wallet::with('user')->where('id', $id)->first();
    	return view('wallet.edit', compact('id', 'wallet'));
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
        	'userid' => 'required|exists:users,id|unique:wallets,userid,'. $id,
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        $wallet = Wallet::find($id);
        $wallet->amount = $request->amount;
        $wallet->save();

        return redirect('wallets')->with('success', 'Wallet has been updated.');
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
}
