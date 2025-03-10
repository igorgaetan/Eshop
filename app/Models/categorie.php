<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class categorie extends Model
{
    use HasFactory;

    public function produits(): HasMany
    {
        return $this->hasMany(produit::class);
    }
    protected $fillable = [
        "nomCat",
        "image",
        "actif"
    ];
    public function getRouteKeyName(): string
    {
        return "nomCat"; //Affiche le slug en bas plutot que l'id
    }
}
