<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Mail\ConfirmationCommandeMail;
use App\Models\Client;
use App\Models\CommandeElement;
use App\Models\Livre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\FactureMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;          // ← Importer DB

class CommandeController extends Controller
{
    // Afficher la liste des commandes
    public function index()
    {
        $livres = Livre::all();
        $commandes = commande::all();
        return view('commandes.index', compact('commandes', 'livres'));
    }

    // Afficher le formulaire de création d'une commande
    public function create()
    {

        $clients = Client::all();
        $livres = Livre::all();
        return view('commandes.create', compact('clients', 'livres'));
    }

    public function add(Request $request){

    }
    // Enregistrer une nouvelle commande
    // Enregistrer une nouvelle commande
    public function store(Request $request)
    {
        // 1️⃣ Validation des données
        $request->validate([
            'client_id'       => 'required|exists:clients,id',
            'produit_id'      => 'required|array|min:1',
            'produit_id.*'    => 'exists:livres,id',
            'quantite'        => 'required|array|min:1',
            'quantite.*'      => 'integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Création de la commande
                $commande = new Commande();
                $commande->client_id      = $request->client_id;
                $commande->utilisateur_id = Auth::id();
                $commande->statut         = $request->has('statut') ? $request->statut : 'en_attente';
                $commande->montant_total  = 0;
                $commande->save();

                $total = 0;
                $elements = [];

                // Parcours des produits sélectionnés
                foreach ($request->produit_id as $i => $produitId) {
                    $livre = Livre::findOrFail($produitId);
                    $qteDemandee = (int) $request->quantite[$i];

                    if ($livre->stock < $qteDemandee) {
                        throw new \Exception("Stock insuffisant pour « {$livre->titre} » ({$livre->stock} dispo).");
                    }

                    $sousTotal = $livre->prix * $qteDemandee;
                    $livre->decrement('stock', $qteDemandee);

                    $total += $sousTotal;

                    $elements[] = new CommandeElement([
                        'livre_id'  => $livre->id,
                        'quantite'  => $qteDemandee,
                        'prix'      => $sousTotal,
                    ]);
                }

                // Mise à jour du total et enregistrement des éléments
                $commande->update(['montant_total' => $total]);
                $commande->elements()->saveMany($elements);

                // Envoi du mail de confirmation
                Mail::to($commande->client->email)
                    ->send(new ConfirmationCommandeMail($commande));
            });

            return redirect()->route('commandes.index')
                ->with('success', 'Commande créée avec succès et stock mis à jour !');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erreur lors de la création de la commande : ' . $e->getMessage());
        }
    }








    // Afficher les détails d'une commande
// CommandeController.php
    public function show($id)
    {
        $commande = Commande::with('elements.livre')->findOrFail($id);
        $montantTotalCommande = 0;
        foreach ($commande->elements as $element) {
            $montantTotalCommande += $element->prix * $element->quantite;
        }
        return view('commandes.show', compact('commande', 'montantTotalCommande'));
    }


    // Afficher le formulaire de modification d'une commande
    public function edit($id)
    {
        // Utilisez la relation 'client' (ou 'user' selon votre modèle)
        $commande = Commande::with('client', 'elements.livre')->findOrFail($id);

        // Assurez-vous d'utiliser le modèle correct pour récupérer les clients
        $clients = User::all(); // Si votre relation dans Commande est 'user'
        // OU
        $clients = Client::all(); // Si votre relation dans Commande est 'client'

        $livres = Livre::all();
        return view('commandes.edit', compact('commande', 'clients', 'livres'));
    }

    // Mettre à jour les informations d'une commande
    public function update(Request $request, $id)
    {
        // Validation pour les quantités des livres existants
        $request->validate([
            'quantites' => 'nullable|array',
            'quantites.*' => 'nullable|integer|min:1',
            'nouveaux_produits' => 'nullable|array',
            'nouveaux_produits.*' => 'exists:livres,id',
            'nouvelles_quantites' => 'nullable|array',
            'nouvelles_quantites.*' => 'nullable|integer|min:1',
        ]);

        $commande = Commande::findOrFail($id);

        try {
            DB::transaction(function () use ($request, $commande) {
                $total = 0;
                $elementsToUpdate = [];

                // Mise à jour des quantités des livres existants
                if ($request->has('quantites')) {
                    foreach ($request->input('quantites') as $livreId => $quantite) {
                        $element = $commande->elements()->where('livre_id', $livreId)->first();

                        if ($element) {
                            $livre = Livre::findOrFail($livreId);
                            $ancienneQuantite = $element->quantite;
                            $nouvelleQuantite = (int) $quantite;
                            $diffQuantite = $nouvelleQuantite - $ancienneQuantite;

                            if ($diffQuantite > 0 && $livre->stock < $diffQuantite) {
                                throw new \Exception("Stock insuffisant pour « {$livre->titre} » (disponible : {$livre->stock}, demandé : {$nouvelleQuantite}).");
                            }

                            $element->quantite = $nouvelleQuantite;
                            $element->prix = $livre->prix * $nouvelleQuantite;
                            $elementsToUpdate[] = $element;
                            $livre->decrement('stock', $diffQuantite);
                            $total += $element->prix;
                        }
                    }

                    foreach ($elementsToUpdate as $element) {
                        $element->save();
                    }
                }

                // Ajout de nouveaux livres à la commande
                if ($request->has('nouveaux_produits')) {
                    foreach ($request->input('nouveaux_produits') as $index => $nouveauLivreId) {
                        $nouvelleQuantite = (int) ($request->input('nouvelles_quantites')[$nouveauLivreId] ?? 1);
                        $nouveauLivre = Livre::findOrFail($nouveauLivreId);

                        if ($nouveauLivre->stock < $nouvelleQuantite) {
                            throw new \Exception("Stock insuffisant pour « {$nouveauLivre->titre} » (disponible : {$nouveauLivre->stock}, demandé : {$nouvelleQuantite}).");
                        }

                        $commande->elements()->create([
                            'livre_id' => $nouveauLivre->id,
                            'quantite' => $nouvelleQuantite,
                            'prix' => $nouveauLivre->prix * $nouvelleQuantite,
                        ]);

                        $nouveauLivre->decrement('stock', $nouvelleQuantite);
                        $total += $nouveauLivre->prix * $nouvelleQuantite;
                    }
                }

                // Recalcul du montant total de la commande
                $nouveauTotal = $commande->elements->sum(function ($element) {
                    return $element->prix;
                });
                $commande->update(['montant_total' => $nouveauTotal]);
            });

            return redirect()->route('commandes.show', $commande->id)
                ->with('success', 'Commande mise à jour avec succès et stock ajusté !');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erreur lors de la mise à jour de la commande : ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $commande = Commande::with('elements.livre')->findOrFail($id);

        // Restituer les quantités au stock
        foreach ($commande->elements as $element) {
            $livre = $element->livre;
            $livre->stock += $element->quantite; // on restitue la quantité
            $livre->save();
        }

        // Supprimer la commande (et potentiellement ses éléments, selon ton modèle)
        $commande->delete();

        return redirect()->route('commandes.index')->with('success', 'Commande annulée et stock mis à jour avec succès!');
    }


    public function updateStatut(Request $request, $id)
    {
        // Valider l'entrée
        $request->validate([
            'statut' => 'required|in:en_attente,en_preparation,expediee,payee',
        ]);

        // Récupérer la commande
        $commande = Commande::findOrFail($id);

        // Modifier le statut
        $commande->statut = $request->statut;
        $commande->save();

        // Rediriger avec un message de succès
        return redirect()->route('commandes.show', $commande->id)->with('success', 'Statut de la commande mis à jour avec succès!');
    }
    public function envoyerFacture($commandeId)
    {
        $commande = Commande::findOrFail($commandeId);

        // Envoi de la facture par e-mail au client
        Mail::to($commande->utilisateur->email)->send(new FactureMail($commande));

        return redirect()->route('commandes.show', $commandeId)->with('success', 'La facture a été envoyée au client.');
    }



    public function supprimerLivre($commandeId, $livreId)
    {
        Log::info("Tentative de suppression du livre {$livreId} de la commande {$commandeId}");
        $commande = Commande::findOrFail($commandeId);

        try {
            DB::transaction(function () use ($commande, $livreId) {
                $element = $commande->elements()->where('livre_id', $livreId)->firstOrFail();
                Log::info("Élément de commande trouvé : " . json_encode($element));

                $quantiteASupprimer = $element->quantite;
                $livre = $element->livre;

                $element->delete();
                Log::info("Élément de commande supprimé");

                $livre->increment('stock', $quantiteASupprimer);
                Log::info("Stock du livre {$livreId} incrémenté");

                $nouveauTotal = $commande->elements()->sum('prix');
                $commande->update(['montant_total' => $nouveauTotal]);
                Log::info("Montant total de la commande mis à jour : {$nouveauTotal}");
            });

            return back()->with('success', 'Livre supprimé de la commande avec succès et stock mis à jour.');

        } catch (\Exception $e) {
            Log::error("Erreur lors de la suppression du livre {$livreId} de la commande {$commandeId}: " . $e->getMessage());
            return back()->with('error', 'Erreur lors de la suppression du livre : ' . $e->getMessage());
        }
    }

}

