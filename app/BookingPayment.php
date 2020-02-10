<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
	
   	public function bookings(){

   	    return $this->belongsTo('App\Booking','booking_id');
   	}
   	 public function users() {

    	return $this->belongsTo('App\User','user_id');
    } 

    public function spaces() {

    	return $this->belongsTo('App\Space','space_id');
    } 

    public function providers() {

    	return $this->belongsTo('App\Provider','provider_id');

    } 
}

