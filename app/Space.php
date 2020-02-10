<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $fillable = [
        'name', 'space_type',
    ];

    public static function boot() {

        parent::boot();

         static::creating(function ($model) {
            
            $model->unique_id = uniqid();

        });

         static::deleting(function ($model) {

            $model->picture = delete_picture($model->picture, FILE_PATH_SPACE);

            $model->bookings()->delete();

            $model->booking_payments()->delete();

        });
    }

    public function providers(){

        return $this->belongsTo('App\Provider','provider_id');
        
    } 
    public function bookings() {

        return $this->hasMany('App\Booking');
    }

    public function booking_payments() {

        return $this->hasMany('App\BookingPayment');
    }
    

}
