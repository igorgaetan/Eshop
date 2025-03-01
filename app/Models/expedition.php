<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class expedition extends Model
{
    use HasFactory;
    
    public function ville(): BelongsTo
    {
        return $this->belongsTo(ville::class);
    }
    
    protected $fillable = [    
        'transporteur',
       'prix',
        'mobile1', 
        'mobile2',
     
    ];
}
