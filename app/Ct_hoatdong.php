<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ct_hoatdong extends Model
{
    protected $primaryKey = ['user_id', 'hoatdong_id'];
    public $incrementing = false;

    protected $fillable = [
        'user_id', 'hoatdong_id', 'vaitro', 'thanhtich'
    ];
    public $timestamps = false;
    
}
