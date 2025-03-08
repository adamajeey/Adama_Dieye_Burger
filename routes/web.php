<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\CommandeDetailController;
use App\Http\Controllers\PaiementController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/create', [CommandeController::class, 'create'])->name('commandes.create');
    Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
    Route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');
    Route::get('/commandes/{commande}/edit', [CommandeController::class, 'edit'])->name('commandes.edit');
    Route::put('/commandes/{commande}', [CommandeController::class, 'update'])->name('commandes.update');
    Route::delete('/commandes/{commande}', [CommandeController::class, 'destroy'])->name('commandes.destroy');

    Route::resource('burgers', BurgerController::class);

    Route::get('/commandes/{commande}/details', [\App\Http\Controllers\Commande_DetailController::class, 'index'])->name('commande_details.index');
    Route::post('/commandes/{commande}/details', [\App\Http\Controllers\Commande_DetailController::class, 'store'])->name('commande_details.store');
    Route::put('/commandes/{commande}/details/{detail}', [\App\Http\Controllers\Commande_DetailController::class, 'update'])->name('commande_details.update');
    Route::delete('/commandes/{commande}/details/{detail}', [\App\Http\Controllers\Commande_DetailController::class, 'destroy'])->name('commande_details.destroy');

    Route::get('/paiements', [PaiementController::class, 'index'])->name('paiements.index');
    Route::get('/paiements/create', [PaiementController::class, 'create'])->name('paiements.create');
    Route::post('/paiements', [PaiementController::class, 'store'])->name('paiements.store');
    Route::get('/paiements/{paiement}', [PaiementController::class, 'show'])->name('paiements.show');
    Route::get('/paiements/{paiement}/edit', [PaiementController::class, 'edit'])->name('paiements.edit');
    Route::put('/paiements/{paiement}', [PaiementController::class, 'update'])->name('paiements.update');
    Route::delete('/paiements/{paiement}', [PaiementController::class, 'destroy'])->name('paiements.destroy');

    Route::post('/valider_panier', [CommandeController::class, 'valider_panier'])->name('valider_panier');
});

require __DIR__.'/auth.php';
