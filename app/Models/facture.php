<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Psy\Readline\Hoa\ProtocolWrapper;

class facture extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function commande(): BelongsTo
    {
        return $this->belongsTo(commande::class);
    }
    public function ligneFactures(): HasMany
    {
        return $this->hasMany(ligneFacture::class);
    }
    public function ligneCarte(): HasOne
    {
        return $this->hasOne(ligneCarte::class);
    }
    public function bonAchats(): HasMany
    {
        return $this->hasMany(ligneCarte::class);
    }
    protected $fillable = [
        'montant',
        'remise',
        'tel',
        'typeFac',
        'capital',
        'tva',
        'codePromo',
    ];

    protected $with = [
        'ligneFactures'
    ];

}
