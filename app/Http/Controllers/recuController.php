<?php

namespace App\Http\Controllers;

use App\Models\Recu;
use Illuminate\Http\Request;

class recuController extends Controller
{
    public function show($id) {
        
        $recu = Recu::find($id);
        return view('recus.show', compact('recu'));
    }
}
