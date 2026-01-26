<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fraisScolaire extends Model
{
    use HasFactory;
    public function classe(){
        return $this->hasMany(Classe::class);
    }

}
