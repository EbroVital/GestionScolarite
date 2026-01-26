<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    // une classe concerne une année scolaire
    public function anneeScolaire(){
        return $this->belongsTo(anneeScolaire::class);
    }

    // une classe contient plusieurs eleves
    public function eleves(){
        return $this->hasMany(Eleve::class);
    }

    // une classe a un  frais scolaire
    public function fraisScolaire(){
        return $this->belongsTo(fraisScolaire::class);
    }



}
