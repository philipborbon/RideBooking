<?php

namespace RideBooking;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use RideBooking\Vehicle;
use RideBooking\Wallet;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'usertype'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at'
    ];

    public function getFullname()
    {
      return "{$this->firstname} {$this->lastname}";
    }

    public function getUserType(){
        $type = $this->usertype;

        $description = "";

        $types = config('enums.usertype');

        if ( array_key_exists($type, $types) ) {
            $description = $types[$type];
        }

        return $description;
    }

    public function drivers() {
        return $this->hasMany(Vehicle::class, 'driverid');
    }

    public function operators() {
        return $this->hasMany(Vehicle::class, 'operatorid');
    }

    public function wallet(){
        return $this->hasOne(Wallet::class, 'userid');
    }
}
