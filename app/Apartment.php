<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = [
        'title','slug','type','description', 'mq','n_rooms','n_beds','n_baths','n_guests','pet','h_checkin', 'h_checkout', 'price_night', 'image', 'visibility', 'city', 'street', 'lat', 'long', 'house_number','user_id',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function statistics(){
        return $this->hasMany('App\Statistic');
    }

    public function messages(){
        return $this->hasMany('App\Message');
    }

    public function services(){
        return $this->belongsToMany('App\Service');
    }

    
    public function advertises(){
        return $this->belongsToMany('App\Advertise');
    }
    
}
