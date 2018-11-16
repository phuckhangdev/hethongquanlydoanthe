<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hoatdong extends Model
{
    protected $fillable = [
        'tenhoatdong', 'namhoc', 'hocky', 'thoigian', 'diadiem', 'ghichu', 'captochuc_id'
    ];
}
