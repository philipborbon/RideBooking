<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;
use RideBooking\User;
use RideBooking\RideSchedule;
use RideBooking\WalletTransaction;

class Booking extends Model
{
	protected $fillable = ['userid', 'ridescheduleid', 'transactionid', 'payment', 'bookingcode', 'approved', 'closed'];

	public function user(){
		return $this->belongsTo(User::class, 'userid');
	}

	public function schedule(){
		return $this->belongsTo(RideSchedule::class, 'ridescheduleid');
	}

	public function transaction(){
		return $this->belongsTo(WalletTransaction::class, 'transactionid');
	}
}
