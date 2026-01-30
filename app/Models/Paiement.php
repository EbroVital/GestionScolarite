<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;


    protected $fillable = [
        'montant',
        'date_paiement',
        'observation',
        'reference_transaction',
        'type_paiement_id',
        'eleve_id',
        
    ];

    // un paiement concerne un seul eleve
    public function eleve(){
        return $this->belongsTo(Eleve::class);
    }

    // un paiement a un seul reçus
    public function recu(){
        return $this->hasOne(Recu::class);
    }

    // un paiement a un seul type de paiement
    public function typePaiement(){
        return $this->belongsTo(TypePaiement::class);
    }
}
