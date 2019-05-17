<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;
use RideBooking\User;

class Wallet extends Model
{
	protected $fillable = ['userid', 'amount'];

	public function user(){
		return $this->belongsTo(User::class, 'userid');
	}
}
