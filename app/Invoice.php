<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    public function circle()
    {
        return $this->hasOne('App\Circle');
    }
    public function transcation()
    {
        return $this->hasMany('App\Transcations');
    }
}
