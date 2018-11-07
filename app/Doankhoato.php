<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doankhoato extends Model
{
    protected $fillable = [
        'tendoankhoato',
    ];

    public function chidoans()
    {
        return $this->hasMany('App\Chidoan');
    }
}
