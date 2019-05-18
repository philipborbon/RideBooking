<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;
use RideBooking\User;
use RideBooking\WalletTransaction;

class Redeem extends Model
{
	protected $fillable = ['driverid', 'transactionid', 'amount', 'redeemcode', 'approved'];

	public function driver(){
		$this->belongsTo(User::class, 'driverid');
	}

	public function transaction(){
		return $this->belongsTo(WalletTransaction::class, 'transactionid');
	}
}
