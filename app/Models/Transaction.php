<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->belongsTo(country::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function depot_gabon(){
        return $this->hasOne(depot_gabon::class);
    }

    public function depot_rdc(){
        return $this->hasOne(depot_rdc::class);
    }
    
    public function compte_to_compte_rdc(){
        return $this->hasOne(compte_to_compte_rdc::class);
    }

    public function compte_to_mobile_rdc(){
        return $this->hasOne(compte_to_mobile_rdc::class);
    }

    public function compte_rdc_to_gabon(){
        return $this->hasOne(compte_rdc_to_gabon::class);
    }

    public function compte_gabon_to_gabon(){
        return $this->hasOne(compte_gabon_to_gabon::class);
    }

    public function gabon_to_mobile_rdc(){
        return $this->hasOne(gabon_to_mobile_rdc::class);
    }

    public function compte_gabon_to_rdc(){
        return $this->hasOne(compte_gabon_to_rdc::class);
    }

    public function retrait_rdc(){
        return $this->hasOne(retrait_rdc::class);
    }
}
