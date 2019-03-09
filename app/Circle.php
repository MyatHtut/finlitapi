<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    protected $table    = 'circles';
    public function user()
    {
        return $this->belongsToMany('App\User','user_circles','circle_id','user_id');
    }
}
