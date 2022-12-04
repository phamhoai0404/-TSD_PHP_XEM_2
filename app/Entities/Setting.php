<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'setting';
     protected $fillable = [
        'timeDefault'
    ];
}
