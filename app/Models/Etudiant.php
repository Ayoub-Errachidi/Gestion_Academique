<?php

namespace App\Models;

use App\Models\Classe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;



class Etudiant extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'etudiants';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'age',
        'classe_id'
    ];

    // Chaque étudiant appartient à une classe
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    // Relation ManyToMany avec Matiere
    public function matieres(): BelongsToMany {
        return $this->belongsToMany(Matiere::class);
    }
}
