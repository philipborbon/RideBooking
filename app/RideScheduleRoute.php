<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;
use RideBooking\RideSchedule;
use RideBooking\Route;

class RideScheduleRoute extends Model
{
	protected $fillable = ['scheduleid', 'routeid', 'isMain'];

	public function schedule(){
		return $this->belongsTo(RideSchedule::class, 'scheduleid');
	}

	public function route(){
		return $this->belongsTo(Route::class, 'routeid');
	}
}
