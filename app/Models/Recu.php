<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recu extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant',
        'paiement_id',
        'date_emission',
        'numero_recu'
    ];

    // un reçu a un paiement
    public function paiement(){
        return $this->belongsTo(Paiement::class);
    }
}
