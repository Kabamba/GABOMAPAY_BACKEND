<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class depot_rdc extends Model
{
    use HasFactory;

    public function transaction(){
        return $this->belongsTo(transaction::class);
    }

    public function operator(){
        return $this->belongsTo(operator::class);
    }
}
