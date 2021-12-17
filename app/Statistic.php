<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = ['apartment_id', 'data', 'visitors'];
    public function apartment(){
        return $this->belongsTo('App\Apartment');
    }
}
