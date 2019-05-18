<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;
use RideBooking\Vehicle;

class RideSchedule extends Model
{
	protected $fillable = ['vehicleid', 'departuretime', 'boardingtime', 'date', 'departed', 'active'];

	public function vehicle(){
		return $this->belongsTo(Vehicle::class, 'vehicleid');
	}
}
