<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vanban extends Model
{
    protected $fillable = [
        'tenvanban', 'duongdan', 'loaivanban', 'captochuc'
    ];
}
