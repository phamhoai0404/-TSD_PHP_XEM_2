<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $fillable = [
        'lineCode', 'userId', 'note'
    ];
    
    public function user() {
        return $this->belongsTo(\App\Entities\User::class, 'userId');
    }
}
