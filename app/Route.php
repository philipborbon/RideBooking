<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
	protected $fillable = ['startlocation', 'endlocation', 'distance', 'eta', 'regularfare'];
}
