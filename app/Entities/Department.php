<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    protected $table = 'departments';

    public function users() {
        return $this->hasMany('\App\Entities\User', 'depId', 'id');
    }

    protected $fillable = [
        'depCode', 'depName', 'note'
    ];
}
