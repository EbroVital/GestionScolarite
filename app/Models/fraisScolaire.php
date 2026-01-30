<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fraisScolaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'niveau',
        'montant'
    ];
    public function classes(){
        return $this->hasMany(Classe::class);
    }

}
