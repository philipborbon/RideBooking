<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;
use RideBooking\Vehicle;
use RideBooking\RideScheduleRoute;

class RideSchedule extends Model
{
	protected $fillable = ['vehicleid', 'departuretime', 'boardingtime', 'date', 'departed', 'active'];

	protected $dates = ['date'];

	public function vehicle(){
		return $this->belongsTo(Vehicle::class, 'vehicleid');
	}

	public function routes(){
		return $this->hasMany(RideScheduleRoute::class, 'scheduleid');
	}
}
