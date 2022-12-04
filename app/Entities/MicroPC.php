<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class MicroPC extends Model
{
    protected $fillable = ['microCode', 'ipAddress', 'depId', 'note'];

    protected $table = 'micro_pcs';
    
    public function department() {
        return $this->belongsTo('App\Entities\Department', 'depId', 'id');
    }

    public function line() {
        return $this->belongsTo('App\Entities\Line', 'lineId', 'id');
    }

    public function playfile() {
        return $this->hasOne('App\Entities\PlayList', 'micropcId', 'id');
    }
}
