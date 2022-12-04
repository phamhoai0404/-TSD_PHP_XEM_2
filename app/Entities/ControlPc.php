<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ControlPc extends Model
{

    protected $table = 'controlpcs';
     protected $fillable = [
        'controlpcCode', 'ipAddress', 'note'
    ];
}
