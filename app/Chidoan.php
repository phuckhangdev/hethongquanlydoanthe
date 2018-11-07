<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chidoan extends Model
{
    // public function doankhoato()
    // {
    //     return $this->belongsTo('App\Doankhoato','doankhoato_id');
    // }
    protected $fillable = [
        'tenchidoan', 'tencuthe', 'doankhoato_id'
    ];

    public function doankhoato() {
        return $this->belongsTo(Doankhoato::class, 'doankhoato_id');
    }
    
}
