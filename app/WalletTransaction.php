<?php

namespace RideBooking;

use Illuminate\Database\Eloquent\Model;
use RideBooking\Wallet;

class WalletTransaction extends Model
{
	protected $fillable = ['fromwalletid', 'towalletid', 'amount', 'type'];

	public function from(){
		return $this->belongsTo(Wallet::class, 'fromwalletid');
	}

	public function to(){
		return $this->belongsTo(Wallet::class, 'towalletid');
	}

	public function getType(){
        $type = $this->type;

        $description = "";

        $types = config('enums.transactiontype');

        if ( array_key_exists($type, $types) ) {
            $description = $types[$type];
        }

        return $description;
	}
}
