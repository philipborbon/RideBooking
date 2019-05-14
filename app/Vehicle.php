<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;
use RideBooking\User;

class Vehicle extends Model
{
    protected $fillable = [
    	'description', 'driverid', 'seats', 'platenumber', 'cabnumber', 'available', 'operatorid', 'boundary'
    ];

    public function driver() {
        return $this->belongsTo(User::class, 'driverid');
    }

    public function operator() {
        return $this->belongsTo(User::class, 'operatorid');
    }
}
