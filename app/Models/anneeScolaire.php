<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class anneeScolaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle', 'date_debut', 'date_fin'
    ];


    // une année scolaire a plusieurs classes
    public function classes(){
        return $this->hasMany(Classe::class);
    }
}
