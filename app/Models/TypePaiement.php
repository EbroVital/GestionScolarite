<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePaiement extends Model
{
    use HasFactory;


    protected $fillable = [
        'libelle'
    ];

    // un type de paiement a plusieurs paiements

    public function paiements(){
        return $this->hasMany(Paiement::class);
    }
}
