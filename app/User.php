<?php

namespace App;

use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\Helper;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Setting, DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'timezone',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function boot() {

        parent::boot();

        static::creating(function ($model) {

            $model->name = $model->first_name.' '.$model->last_name;

            $model->username = $model->first_name.uniqid();

            $model->is_verified = USER_EMAIL_VERIFIED;

            $model->mobile = '';

            $model->description = '';
            
            $model->unique_id = uniqid();

            $model->payment_mode = COD;

            $model->token = Helper::generate_token();

            $model->token_expiry = Helper::generate_token_expiry();

        });

        static::created(function($model) {

            $model->email_notification_status = $model->push_notification_status = YES;

            $model->token = Helper::generate_token();

            $model->token_expiry = Helper::generate_token_expiry();

            $model->save();
        
        });

        static::updating(function($model) {

            $model->username = $model->name.uniqid();

            $model->name = $model->first_name.' '.$model->last_name ;
            
        });

        static::deleting(function ($model){

            delete_picture($model->picture, PROFILE_PATH_USER);

            $model->bookings()->delete();

            $model->BookingUserReview()->delete();

            $model->BookingProviderReview()->delete();

            $model->booking_payments()->delete();

        });
    }

    public function BookingUserReview() {

        return $this->hasMany('App\BookingUserReview');
    }

    public function BookingProviderReview(){

        return $this->hasMany('App\BookingProviderReview');
    }

    public function providers() {

        return $this->hasMany('App\Provider');
    }

    public function bookings() {

        return $this->hasMany('App\Booking');
    }

    public function booking_payments() {

        return $this->hasMany('App\BookingPayment');
    }

}
