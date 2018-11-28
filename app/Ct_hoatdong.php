<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ct_hoatdong extends Model
{
    protected $fillable = [
        'user_id', 'hoatdong_id', 'vaitro', 'thanhtich'
    ];
    public $timestamps = false;
}
