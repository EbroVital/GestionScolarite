<?php

use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\FraisScolaireController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\recuController;
use App\Http\Controllers\TypePaiementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->group(function(){

    Route::middleware(['role:admin,caissier'])->group(function () {
        Route::resource('eleves', EleveController::class);
        Route::resource('paiements', PaiementController::class);
        Route::get('/paiements/eleves/{classe}', [PaiementController::class, 'getEleves'])->name('paiements.eleves');
        Route::get('/reçu/{id}', [recuController::class, 'show'])->name('recus.show');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('classe', ClasseController::class);
        Route::resource('type-paiement', TypePaiementController::class);
        Route::resource('frais-scolaire', FraisScolaireController::class);
    });

});

require __DIR__.'/auth.php';
