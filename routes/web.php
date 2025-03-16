<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\Commande_DetailController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Routes accessibles à tous les utilisateurs connectés
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard - redirige selon le rôle
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (accessible à tous)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Catalogue des burgers pour les clients
    Route::get('/catalogue', [BurgerController::class, 'catalogue'])->name('catalogue');

    // Système de panier et validation de commande
    // Correction : Utiliser la méthode validerPanier au lieu de valider_panier
    Route::post('/valider-panier', [CommandeController::class, 'validerPanier'])->name('valider_panier');
});

// Routes réservées aux gestionnaires
Route::middleware(['auth', 'role:gestionnaire'])->group(function () {
    // Gestion des burgers (CRUD complet)
    Route::resource('burgers', BurgerController::class);

    // Gestion complète des commandes
    Route::resource('commandes', CommandeController::class);

    // Détails des commandes
    Route::get('/commandes/{commande}/details', [Commande_DetailController::class, 'index'])->name('commande_details.index');
    Route::post('/commandes/{commande}/details', [Commande_DetailController::class, 'store'])->name('commande_details.store');
    Route::put('/commandes/{commande}/details/{detail}', [Commande_DetailController::class, 'update'])->name('commande_details.update');
    Route::delete('/commandes/{commande}/details/{detail}', [Commande_DetailController::class, 'destroy'])->name('commande_details.destroy');

    // Gestion des paiements
    Route::resource('paiements', PaiementController::class);
});

// Commandes des clients
Route::get('/mes-commandes', [CommandeController::class, 'mesCommandes'])->name('commandes.mes_commandes');

require __DIR__.'/auth.php';
