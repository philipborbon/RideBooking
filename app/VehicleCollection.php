<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;
use RideBooking\User;
use RideBooking\Vehicle;

class VehicleCollection extends Model
{
	protected $fillable = ['driverid', 'vehicleid', 'amount'];

	public function driver(){
		return $this->belongsTo(User::class, 'driverid');
	}

	public function vehicle(){
		return $this->belongsTo(Vehicle::class, 'vehicleid');
	}
}
