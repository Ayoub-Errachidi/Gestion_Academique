<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Matiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 
        'coefficient'
    ];

    // Relation ManyToMany avec Etudiant
    public function etudiants(): BelongsToMany {
        return $this->belongsToMany(Etudiant::class)
                ->withPivot('note')->withTimestamps();
    }

    public function enseignants(){
        return $this->belongsToMany(Enseignant::class)->withTimestamps();
    }
}
