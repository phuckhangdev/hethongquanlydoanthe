<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Xeploaicd extends Model
{
    protected $primaryKey = ['namhoc', 'chidoan_id'];
    public $incrementing = false;

    protected $fillable = [
        'namhoc', 'chidoan_id', 'xeploai'
    ];
    public $timestamps = false;
}
