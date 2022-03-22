<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class compte_to_compte_rdc extends Model
{
    use HasFactory;

    public function recever()
    {
        return $this->belongsTo(user::class, 'recever_id');
    }
}
