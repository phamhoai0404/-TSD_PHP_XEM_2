<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';

    public function department()
    {
        return $this->belongsTo('App\Entities\Department', 'depCode', 'depCode');
    }
}
