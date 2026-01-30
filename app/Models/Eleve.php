<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'sexe',
        'date_naissance',
        'telephone_parent',
        'adresse',
        'user_id',
        'classe_id'
    ];

    // un eleve appartient à une seule classe
    public function classe(){
        return $this->belongsTo(Classe::class);
    }

    // un eleve a plusieurs paiements
    public function paiements(){
        return $this->hasMany(Paiement::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
