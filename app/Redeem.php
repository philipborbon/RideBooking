<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;
use RideBooking\User;
use RideBooking\WalletTransaction;

class Redeem extends Model
{
	protected $fillable = ['walletid', 'transactionid', 'amount', 'redeemcode', 'approved'];

	public function wallet(){
		return $this->belongsTo(Wallet::class, 'walletid');
	}

	public function transaction(){
		return $this->belongsTo(WalletTransaction::class, 'transactionid');
	}
}
