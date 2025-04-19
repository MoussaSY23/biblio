<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use Illuminate\Http\Request;

class LivreController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categorie = $request->input('categorie'); // Récupérer le paramètre de catégorie

        $query = Livre::query();

        if ($search) {
            $query->where('titre', 'like', '%' . $search . '%')
                ->orWhere('auteur', 'like', '%' . $search . '%');
        }

        if ($categorie) {
            $query->where('categorie', $categorie); // Filtrer par catégorie si elle est présente
        }

        $livres = $query->paginate(9)->appends(request()->query()); // Conserver tous les paramètres dans la pagination

        return view('livres.index', compact('livres'));
    }

    public function create()
    {
        return view('livres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required',
            'auteur' => 'required',
            'prix' => 'required|numeric',
            'description' => 'required',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categorie' => 'nullable|string|max:255',
        ]);

        $livre = Livre::create($request->all());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/livres', 'public');
            $livre->image = $imagePath;
            $livre->save();
        }

        return redirect()->route('livres.index')->with('success', 'Le livre a été ajouté avec succès.');
    }

    public function show(Livre $livre)
    {
        return view('livres.show', compact('livre'));
    }

    public function edit(Livre $livre)
    {
        return view('livres.edit', compact('livre'));
    }

    public function update(Request $request, Livre $livre)
    {
        $request->validate([
            'titre' => 'required',
            'auteur' => 'required',
            'prix' => 'required|numeric',
            'description' => 'required',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $livre->update($request->all());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/livres', 'public');
            $livre->image = $imagePath;
            $livre->save();
        }

        return redirect()->route('livres.index')->with('success', 'Livre mis à jour avec succès!');
    }

    public function destroy(Livre $livre)
    {
        $livre->delete();
        return redirect()->route('livres.index')->with('success', 'Livre supprimé avec succès!');
    }
}
//         $commande->produits()->detach(); // Détacher tous les produits existants
//         foreach ($request->produit_id as $produitId) {
//             $commande->produits()->attach($produitId, ['quantite' => 1, 'prix' => Livre::find($produitId)->prix]);
//         }
//
//         return redirect()->route('commandes.index')->with('success', 'Commande mise à jour avec succès!');
//     }
//     }
//         return redirect()->route('commandes.index')->with('success', 'Commande supprimée avec succès!');
//     }
//     }
//     }
//         return redirect()->route('commandes.index')->with('success', 'Commande supprimée avec succès!');
//     }
