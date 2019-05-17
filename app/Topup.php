<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
	protected $fillable = ['walletid', 'transactionid', 'amount', 'topupcode', 'approved'];

	public function wallet(){
		return $this->belongsTo(Wallet::class, 'walletid');
	}

	public function transaction(){
		return $this->belongsTo(Wallet::class, 'transactionid');
	}
}
