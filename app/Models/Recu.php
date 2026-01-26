<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recu extends Model
{
    use HasFactory;

    // un reçu a un paiement
    public function paiement(){
        return $this->belongsTo(Paiement::class);
    }
}
