<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    use HasFactory;

    public function devise()
    {
        return $this->belongsTo(Devise::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
