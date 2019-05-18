<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;

class PassengerType extends Model
{
	protected $fillable = ['name', 'discount'];
}
