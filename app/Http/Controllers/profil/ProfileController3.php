<?php

namespace App\Http\Controllers\profil;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ProfileController3 extends Controller
{
    public function mettreAjour(Request $request){
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'telephone' => ['required', 'string', 'max:15'],
            'adresse' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'], // Validation pour la photo
        ]);

        $user->name = $request->name;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->adresse = $request->adresse;

        // Gestion de l'upload de la photo (similaire à votre RegisteredUserController)
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe (optionnel)
            if ($user->photo) {
                \Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $path;
        }

        $user->save();

        return Redirect::route('profile.afficher')->with('success', 'Profil mis à jour avec succès!');
    }
}
