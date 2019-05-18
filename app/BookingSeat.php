<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;
use RideBooking\Booking;
use RideBooking\Route;

class BookingSeat extends Model
{
	protected $fillable = ['bookingid', 'routeid', 'typeid', 'count'];

	public function booking(){
		return $this->belongsTo(Booking::class, 'bookingid');
	}

	public function route(){
		return $this->belongsTo(Route::class, 'routeid');
	}
}
