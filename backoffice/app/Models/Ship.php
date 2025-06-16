<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    public function invoice(){
        return $this->belongsToMany(Invoice::class);
    }
}
