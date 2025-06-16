<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function invoices(){
        return $this->belongsToMany(Invoice::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
