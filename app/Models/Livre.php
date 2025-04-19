<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;

    // Les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'titre',
        'auteur',
        'prix',
        'description',
        'image',
        'stock',
        'categorie',
    ];

    // Livre.php
    public function commandes()
    {
        return $this->hasMany(CommandeElement::class);
    }

}
