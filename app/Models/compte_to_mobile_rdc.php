<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class compte_to_mobile_rdc extends Model
{
    use HasFactory;

    public function operator()
    {
        return $this->belongsTo(operator::class);
    }
}
