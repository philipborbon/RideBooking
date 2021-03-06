<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
	protected $fillable = ['startlocation', 'endlocation', 'distance', 'eta', 'regularfare'];

	public function getDescription(){
		$start = $this->startlocation;
		$end = $this->endlocation;

		return "$start To $end";
	}
}
