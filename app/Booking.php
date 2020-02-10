<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    public function providers(){

        return $this->belongsTo('App\Provider','provider_id');
    } 

    public function users(){

        return $this->belongsTo('App\User','user_id');
    } 

    public function spaces(){

        return $this->belongsTo('App\Space','space_id');
    }

    public function booking_payments() {

        return $this->hasOne('App\BookingPayment');
    }

    public function bookingUserReviews() {

        return $this->hasOne('App\BookingUserReview');
    }

    public function bookingProviderReviews() {

        return $this->hasOne('App\BookingProviderReview');
    }
    
}
