<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertise extends Model
{
    
    public function apartments(){
        return $this->belongsToMany('App\Apartment');
    }
    
}
