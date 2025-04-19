<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ClientController;
use App\Models\Livre;

Route::get('/', function () {
    $livres = Livre::all();
    return view('welcome' , compact('livres'));
});

Route::get('/dashboard', function () {
    $livres = Livre::all();
    return view('dashboard' , compact('livres'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Routes pour les livres

Route::resource('livres', LivreController::class);

// Routes pour les commandes
Route::resource('commandes', CommandeController::class);

// Routes pour les paiements
Route::resource('paiements', PaiementController::class);

// Routes pour les clients
Route::resource('clients', ClientController::class);

Route::put('/commandes/{id}/statut', [CommandeController::class, 'updateStatut'])->name('commandes.updateStatut');
Route::get('profile', [ProfileController::class, 'afficher'])->name('profile.afficher');
Route::get('profile2', [\App\Http\Controllers\ProfileController2::class, 'modifier'])->name('profile2.modifier');
Route::put('profile3', [\App\Http\Controllers\profil\ProfileController3::class, 'mettreAjour'])->name('profile3.mettreAjour');

// Ajouter des routes spécifiques comme l'affichage des statistiques
Route::get('statistiques', [CommandeController::class, 'statistiques'])->name('statistiques');
Route::get('rapport', [CommandeController::class, 'rapport'])->name('rapport');
Route::get('commandes/{commande}/paiements', [CommandeController::class, 'paiements'])->name('commandes.paiements');

Route::get('commandes/{commande}/facture', [CommandeController::class, 'genererFacture'])->name('commandes.facture');

Route::post('/paiements/{commandeId}', [CommandeController::class, 'storePayment'])->name('paiements.store');

Route::resource('factures', \App\Http\Controllers\FactureController::class);
Route::get('paiements/create/{facture}', [PaiementController::class, 'create'])->name('paiements.create');
Route::post('paiements/store/{facture}', [PaiementController::class, 'store'])->name('paiements.store');

Route::get('commandes/{commande}/envoyer-facture', [CommandeController::class, 'envoyerFacture'])->name('commandes.envoyerFacture');


Route::get('/catalogue', function () {
    $livres = Livre::all();
    $livresParAuteur = $livres->groupBy('auteur');
    return view('catalogue' , compact('livresParAuteur')); // Crée un fichier resources/views/catalogue.blade.php
})->name('catalogue');


Route::get('/statistiques', [\App\Http\Controllers\StatistiqueController::class, 'index'])->name('statistiques.index');

Route::delete('/commandes/{commande}/livres/{livre}', [App\Http\Controllers\CommandeController::class, 'supprimerLivre'])->name('commandes.supprimerLivre');
