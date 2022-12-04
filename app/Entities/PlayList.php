<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PlayList extends Model
{
    protected $table = 'playlists';
    protected $fillable = ['micropcId', 'setting'];
    
    public function micropcs() {
        return $this->hasMany('\App\Entities\MicroPC', 'micropcId', 'id');
    }
}
